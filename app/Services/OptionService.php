<?php
namespace App\Services;

use App\Repositories\OptionRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class OptionService extends AbstractService
{
    private static $_inst;
    protected $repository;
    private $optionName = 'gmz_options';

    /**
     * Get the singleton instance of OptionService.
     *
     * @return self
     */
    public static function inst()
    {
        if (empty(self::$_inst)) {
            self::$_inst = new self();
        }
        return self::$_inst;
    }

    /**
     * OptionService constructor.
     */
    public function __construct()
    {
        $this->repository = OptionRepository::inst();
    }

    /**
     * Get the checking email form.
     *
     * @param Request $request
     * @return array
     */
    public function getCheckingEmailForm(Request $request): array
    {
        $data = [
            'title' => __('Checking Email'),
            'action' => dashboard_url('checking-email')
        ];
        return [
            'status' => 1,
            'html' => view('Backend::components.modal.checking-email-content', ['data' => $data])->render()
        ];
    }

    /**
     * Sort the payment structure.
     *
     * @param Request $request
     * @return array
     */
    public function sortPayment(Request $request): array
    {
        $structure = $request->post('payment_structure', []);
        if (!empty($structure)) {
            update_opt('payment_structure', json_encode($structure));
        }

        return [
            'status' => 1,
            'message' => __('Sort payment successfully.')
        ];
    }

    /**
     * Get the payment form.
     *
     * @param Request $request
     * @return array
     */
    public function getPaymentForm(Request $request): array
    {
        $data = [
            'title' => __('Sort Payment'),
            'action' => dashboard_url('sort-payment'),
            'payments' => \BaseGateway::inst()->getPaymentSettings()
        ];
        return [
            'status' => 1,
            'html' => view('Backend::components.modal.payment-content', ['data' => $data])->render()
        ];
    }

    /**
     * Get list item HTML.
     *
     * @param Request $request
     * @return array
     */
    public function getListItemHtml(Request $request): array
    {
        $id = $request->post('id', '');
        $fields = $request->post('fields', '');
        $html = '';
        if (!empty($fields) && !empty($id)) {
            $fields = json_decode(base64_decode($fields), true);
            $html = view('Backend::settings.fields.ajax.list-item-html', [
                'id' => $id,
                'fields' => $fields
            ])->render();
        }

        return [
            'status' => true,
            'html' => $html
        ];
    }

    /**
     * Merge settings from config and database.
     *
     * @param array $settings_config
     * @param array $settings_db
     * @return array
     */
    private function mergeSettings(array $settings_config, array $settings_db): array
    {
        $settings = [];
        if (!empty($settings_config)) {
            foreach ($settings_config as $item) {
                $settings[$item['id']] = $settings_db[$item['id']] ?? ($item['std'] ?? '');
            }
        }
        return $settings;
    }

    /**
     * Fetch and translate field values.
     *
     * @param array $field
     * @return mixed
     */
    private function _fetchTranslation(array $field)
    {
        switch ($field['type']) {
            case 'list_item':
                return $this->_fetchListItemTranslation($field);
            case 'location':
                return $this->_fetchLocationTranslation($field);
            case 'term_price':
                return $this->_fetchTermPriceTranslation($field);
            default:
                return $this->_fetchDefaultTranslation($field);
        }
    }

    /**
     * Fetch list item translation.
     *
     * @param array $field
     * @return array
     */
    private function _fetchListItemTranslation(array $field): array
    {
        $value = request()->get($field['id'], '');
        $langs = get_languages();
        $return = [];
        if (count($langs) > 0) {
            $field_need_trans = array_filter($field['fields'], fn($f) => $f['translation'] ?? false);

            if (!empty($value)) {
                foreach ($value as $key => $val) {
                    if (!empty($val)) {
                        foreach ($val as $key1 => $val1) {
                            if (in_array($key, $field_need_trans)) {
                                $str = array_reduce(array_keys($val1), fn($carry, $key2) => $carry . '[:' . $langs[$key2] . ']' . $val1[$key2], '');
                                $str .= '[:]';
                                $return[$key][$key1][0] = $str;
                            } else {
                                $return[$key][$key1] = $val1;
                            }
                        }
                    }
                }
            }
        }

        if (empty($return)) {
            $return = $value;
        }

        $list_item_data = [];
        if (is_array($return) && !empty($return)) {
            foreach ($return as $key => $val) {
                foreach ($val as $child_key => $child_val) {
                    $list_item_data[$child_key][$key] = $child_val[0];
                }
            }
        }

        return $list_item_data;
    }

    /**
     * Fetch location translation.
     *
     * @param array $field
     * @return array
     */
    private function _fetchLocationTranslation(array $field): array
    {
        $value = request()->get($field['id'], '');
        if (!empty($value['address']) && is_array($value['address'])) {
            $return = [
                'postcode' => $value['postcode'],
                'lat' => $value['lat'],
                'lng' => $value['lng'],
                'zoom' => $value['zoom'],
            ];

            $need_filter = ['address', 'city', 'state', 'country'];
            foreach ($need_filter as $item) {
                $val_temp = array_reduce(array_keys($value[$item]), fn($carry, $key) => $carry . '[:' . $key . ']' . $value[$item][$key], '');
                $val_temp .= '[:]';
                $return[$item] = $val_temp;
            }
            return $return;
        }
        return $value;
    }

    /**
     * Fetch term price translation.
     *
     * @param array $field
     * @return string
     */
    private function _fetchTermPriceTranslation(array $field): string
    {
        $termObject = get_terms($field['choices'], true);
        $termData = [];
        if (!empty($termObject)) {
            foreach ($termObject as $term) {
                $termData[$term->term_id] = [
                    'title' => $term->term_title,
                    'price' => $term->term_price
                ];
            }
        }

        $value = request()->get($field['id'], '');
        $return = [];
        if (!empty($value['price'])) {
            foreach ($value['price'] as $key => $val) {
                $status = isset($value['id'][$key]) ? 'yes' : 'no';
                $price = !empty($val) ? (float)$val : $termData[$key]['price'];
                $custom = !empty($val);
                $return[$key] = [
                    'choose' => $status,
                    'price' => $price,
                    'custom' => $custom
                ];
            }
        }
        return serialize($return);
    }

    /**
     * Fetch default translation.
     *
     * @param array $field
     * @return mixed
     */
    private function _fetchDefaultTranslation(array $field)
    {
        if ($field['translation'] ?? false) {
            return set_translate($field['id']);
        }
        return request()->get($field['id'], '');
    }

    /**
     * Save settings.
     *
     * @param Request $request
     * @return array
     */
    public function saveSettings(Request $request): array
    {
        $settings_config = get_config_settings()['fields'];
        $settings_db = $this->getOption($this->optionName, true);
        $options = json_decode(base64_decode($request->post('options', '')), true);

        foreach ($settings_config as &$item) {
            if ($item['type'] == 'tab' && !is_array($item['tabs']) && $item['tabs'] == 'payment_settings') {
                $item['tabs'] = \BaseGateway::inst()->getPaymentSettings();
            }
        }

        $settings = $this->mergeSettings($settings_config, $settings_db);

        $post_data = $request->except('_token');
        if (!empty($options)) {
            foreach ($options as $val) {
                if (isset($settings[$val['id']])) {
                    $option_value = $this->_fetchTranslation($val);
                    $settings[$val['id']] = $option_value;
                }
            }
        }

        $settings = serialize($settings);
        $need_create = empty($settings_db) || $settings_db == -1;

        if ($need_create) {
            $updated = $this->repository->save(['name' => $this->optionName, 'value' => $settings]);
        } else {
            $updated = $this->repository->updateByWhere(['name' => $this->optionName], ['value' => $settings]);
        }

        if ($updated) {
            $this->_configEmail($post_data);
            $this->_configIcal($post_data);
            return ['status' => true, 'message' => __('Save changes successfully')];
        }

        return ['status' => false, 'message' => __('Save changes failed')];
    }

    /**
     * Configure iCal settings.
     *
     * @param array $post_data
     */
    private function _configIcal(array $post_data): void
    {
        if (isset($post_data['ical_time_value']) && isset($post_data['ical_time_type'])) {
            set_env('ICAL_TYPE', $post_data['ical_time_type']);
            set_env('ICAL_VALUE', $post_data['ical_time_value']);
        }
    }

    /**
     * Configure email settings.
     *
     * @param array $post_data
     */
    private function _configEmail(array $post_data): void
    {
        if (isset($post_data['email_host']) && isset($post_data['email_username'])) {
            set_env('MAIL_HOST', $post_data['email_host'] ?? '');
            set_env('MAIL_USERNAME', $post_data['email_username'] ?? '');
            set_env('MAIL_PASSWORD', $post_data['email_password'] ?? '');
            set_env('MAIL_PORT', $post_data['email_port'] ?? '');
            set_env('MAIL_ENCRYPTION', $post_data['email_encryption'] ?? '');

            set_env('QUEUE_CONNECTION', $post_data['enable_queue_mail'] === 'on' ? 'database' : 'sync');
        }
    }

    /**
     * Get option value.
     *
     * @param string $key
     * @param bool $unserialize
     * @return mixed
     */
    public function getOption(string $key, bool $unserialize = false)
    {
        $data = $this->repository->getOption($key);
        if (!is_null($data)) {
            $option = $data->getAttributes();
            if (!empty($option['value']) && $unserialize) {
                return maybe_unserialize($option['value']);
            }
            return $option['value'];
        }
        return '';
    }

    /**
     * Get icons based on type and category.
     *
     * @param Request $request
     * @return array
     */
    public function getIconsAction(Request $request): array
    {
        $types_input = json_decode($request->post('type', '[]'), true);
        $categories_input = json_decode($request->post('category', '[]'), true);

        $types = empty($types_input) ? array_values(get_icon_types()) : array_intersect_key(get_icon_types(), array_flip($types_input));

        $icons_yml = \Symfony\Component\Yaml\Yaml::parseFile(public_path('html/assets/vendor/font-awesome-5/categories.yml'));
        $checking_yml = \Symfony\Component\Yaml\Yaml::parseFile(public_path('html/assets/vendor/font-awesome-5/icons.yml'));

        $icons = empty($categories_input) ? array_merge(...array_column($icons_yml, 'icons')) : array_merge(...array_intersect_key($icons_yml, array_flip($categories_input)));

        $icon_merge = [];
        $icon_types_flip = array_flip(get_icon_types());
        foreach ($icons as $icon) {
            foreach ($types as $type) {
                if (in_array($icon_types_flip[$type], $checking_yml[$icon]['styles'])) {
                    $icon_class = $type . ' fa-' . $icon;
                    if (!in_array($icon_class, $icon_merge)) {
                        $icon_merge[] = $icon_class;
                    }
                }
            }
        }

        return empty($icons) ? ['status' => 0, 'message' => __('Not found icons')] : ['status' => 1, 'icons' => $icon_merge];
    }
}
