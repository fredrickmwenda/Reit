<?php

/**
 * Created by PhpStorm.
 * User: Jream
 * Date: 5/12/2020
 * Time: 11:33 PM
 */




$namespace = 'App\Modules\Backend\Controllers';
Route::group(
    [
        'module' => 'Backend',
        'namespace' => $namespace,
        'middleware' => ['web', 'auth', 'locale'],
        'prefix' => admin_config('prefix')
    ],
    function () {
        Route::get('/', 'DashboardController@index')->name('dashboard');
        Route::get('/create-storage-link', function () {
    try {
        Artisan::call('storage:link');
        return 'Storage link created successfully!';
    } catch (\Exception $e) {
        return 'Error creating storage link: ' . $e->getMessage();
    }
});

Route::get('/clear-optimization', function () {
    try {
        Artisan::call('optimize:clear');
        return 'Optimization cache cleared successfully!';
    } catch (\Exception $e) {
        return 'Error clearing optimization cache: ' . $e->getMessage();
    }
});

        Route::get('profile', 'UserController@profileView')->name('profile');
        Route::post('update-profile', 'UserController@updateProfileAction')->name('update.profile');

        Route::post('get-icons', 'OptionController@getIconsAction');

        /*Route::get('import-font', 'ImportController@importFontView')->name('import-font');*/
        Route::post('import-font', 'ImportController@importFontAction');
        Route::post('delete-font-icon', 'ImportController@deleteFontIconAction');

        Route::get('settings', 'OptionController@settingsView')->name('settings');
        Route::post('save-settings', 'OptionController@saveSettingsAction')->name('save-settings');
        Route::post('get-list-item-html', 'OptionController@getListItemHtml');

        Route::get('all-media', 'MediaController@allMediaView')->name('all-media');
        Route::post('all-media', 'MediaController@getAllMediaAction');
        Route::post('upload-new-media', 'MediaController@uploadImageAction');
        Route::post('get-media-detail', 'MediaController@getMediaDetailAction');
        Route::post('delete-media-item', 'MediaController@deleteMediaAction');
        Route::post('bulk-delete-media-item', 'MediaController@bulkDeleteMediaAction');

        Route::get('new-post', 'PostController@newPostView')->name('new-post');
        Route::get('all-posts', 'PostController@allPostView')->name('all-posts');
        Route::get('edit-post/{id?}', 'PostController@editPostView')->name('edit-post');
        Route::post('save-post', 'PostController@savePostAction');
        Route::post('delete-post', 'PostController@deletePostAction');
        Route::post('restore-post', 'PostController@restorePostAction');
        Route::post('hard-delete-post', 'PostController@hardDeletePostAction');
        Route::post('change-post-status', 'PostController@changePostStatusAction');
        Route::get('comment', 'PostController@allCommentView')->name('comment');

        Route::get('new-page', 'PageController@newPageView')->name('new-page');
        Route::get('all-pages', 'PageController@allPageView')->name('all-pages');
        Route::get('edit-page/{id?}', 'PageController@editPageView')->name('edit-page');
        Route::post('save-page', 'PageController@savePageAction');
        Route::post('delete-page', 'PageController@deletePageAction');
        Route::post('restore-page', 'PageController@restorePageAction');
        Route::post('hard-delete-page', 'PageController@hardDeletePageAction');
        Route::post('change-page-status', 'PageController@changePostStatusAction');
 
        Route::get('term/{type}/{page?}', 'TermController@allTermView')->name('term');
        Route::get('new-term/{type}', 'TermController@addTermView')->name('new-term');
        Route::get('edit-term/{id}/{type}', 'TermController@editTermView')->name('edit-term');
        Route::post('new-term', 'TermController@newTermAction');
        Route::post('edit-term', 'TermController@editTermAction');
        Route::post('delete-term', 'TermController@deleteTermAction');
        Route::post('get-term-form', 'TermController@getTermFormAction');

        Route::get('order/{post_type}', 'OrderController@getOrderView')->name('order');

        //Avaliability
        Route::post('get-availability', 'AvailabilityController@getAvailability');
        Route::post('add-availability', 'AvailabilityController@addAvailability');

        //Menu
        Route::get('menu', 'MenuController@index')->name('menu');
        Route::post('update-menu', 'MenuController@updateMenuAction');
        Route::post('delete-menu', 'MenuController@deleteMenuAction');

        //User
        Route::get('all-users', 'UserController@allUsersView')->name('all-users');
        Route::post('new-user', 'UserController@newUserAction');
        Route::post('edit-user', 'UserController@editUserAction');
        Route::post('delete-user', 'UserController@deleteUserAction');
        Route::post('get-user-form', 'UserController@getUserFormAction');


        //subscription
        Route::get('subscription', 'SubscriptionController@index')->name('subscription.index');
        Route::get('subscription/creation', 'SubscriptionController@create')->name('subscription.create');
        Route::post('subscription', 'SubscriptionController@store')->name('subscription.store');
        Route::get('edit-subscription/{id}', 'SubscriptionController@edit')->name('subscription.edit');
        Route::post('subscription/update/{id}', 'SubscriptionController@update')->name('subscription.update');
        Route::get('/subscriptions', 'SubscriptionController@show')->name('subscriptions.show');
        Route::get('/partner-subscriptions', 'SubscriptionController@partner_subscriptions')->name('partner-subscriptions');
        Route::get('/subscription-plans', 'SubscriptionController@subscriptionPlans')->name('subscription-plans');
        Route::delete('/delete-subscription/{id}', 'SubscriptionController@destroy')->name('subscription.destroy');


        Route::get('feature', 'FeatureController@index')->name('feature.index');
        Route::get('feature/creation', 'FeatureController@create')->name('feature.create');
        Route::post('feature', 'FeatureController@store')->name('feature.store');
        Route::get('edit-feature/{id}', 'FeatureController@edit')->name('feature.edit');
        Route::post('feature/update/{id}', 'FeatureController@update')->name('feature.update');

        Route::get('get-analytics', 'AnalyticsController@index')->name('get-analytics');



        // Route::get('analytics/today', 'GoogleAnalyticsController@fetchTodayVisitors')->name('top-today-visitors');
        // // fetchVisitorsAndPageViews
        // Route::get('analytics/visitors', 'GoogleAnalyticsController@fetchVisitorsAndPageViews')->name('top-visitors');
        // Route::get('analytics/most-visited', 'GoogleAnalyticsController@fetchMostVisitedPages');
        // Route::get('analytics/top-browsers', 'GoogleAnalyticsController@fetchTopBrowsers');
        // Route::get('analytics/top-countries', 'GoogleAnalyticsController@fetchVisitorsByCountry');
        //Partner
        Route::get('partner-request', 'UserController@allPartnerView')->name('partner-request');
        Route::post('approve-partner', 'UserController@approvePartnerAction');

        //Languages
        Route::get('language/{page?}', 'LanguageController@index')->name('language');
        Route::post('update-language', 'LanguageController@updateLanguageAction');
        Route::post('change-language-status', 'LanguageController@changeLanguageStatusAction');
        Route::post('delete-language', 'LanguageController@deleteLanguageAction');
        Route::post('sort-language', 'LanguageController@sortLanguageAction');

        //Translation
        Route::get('translation', 'LanguageController@translationView')->name('translation');
        Route::post('scan-translation', 'LanguageController@scanTranslateAction');
        Route::post('update-translation', 'LanguageController@updateTranslateAction');

        //Booking History
        Route::get('my-orders', 'OrderController@bookingHistoryView')->name('my-orders');
        Route::post('get-order-detail', 'OrderController@getOrderDetailAction');
        Route::post('update-status-order', 'OrderController@updateStatusOrder');

        //Wishlist
        Route::get('wishlist', 'WishlistController@wishlistAllView')->name('wishlist');
        Route::get('wishlist/{post_type}', 'WishlistController@wishlistView')->name('wishlist');

        //Review
        Route::post('change-review-status', 'CommentController@changeReviewStatusAction');
        Route::post('delete-review', 'CommentController@deleteReviewAction');

        //Earnings
        Route::get('analytics/{id?}/', 'EarningsReportController@analyticsView')->where('id', '[0-9]+')->name('analytics');
        Route::get('partner-analytics', 'EarningsReportController@analyticsPartnerView')->where('id', '[0-9]+')->name('partner-analytics');
        Route::get('partner-earnings', 'EarningsReportController@partnerEarningsView')->name('partner-earnings');
        Route::get('get-widget', 'EarningsReportController@getWidget');
        Route::get('withdrawal/{id?}/', 'WithdrawalController@withdrawalView')->where('id', '[0-9]+')->name('withdrawal');
        Route::post('want-withdrawal', 'WithdrawalController@withdrawalRequest');
        Route::post('update-status-withdrawal', 'WithdrawalController@withdrawalUpdateStatus');
        Route::get('modal-withdrawal', 'WithdrawalController@getDataModal');

        Route::get('coupon', 'CouponController@couponView')->name('coupon');
        Route::post('new-coupon', 'CouponController@newCouponAction');
        Route::post('change-coupon-status', 'CouponController@changeCouponStatusAction');
        Route::post('edit-coupon', 'CouponController@editCouponAction');
        Route::post('delete-coupon', 'CouponController@deleteCouponAction');
        Route::post('get-coupon-form', 'CouponController@getCouponFormAction');

        //Notification
        Route::get('notifications', 'NotificationController@notificationView')->name('notifications');

        Route::get('import-data', 'ImportController@importDataView')->name('import-data');
        Route::post('import-data', 'ImportController@importDataAction')->name('import-data');
        Route::get('checking-email', 'DashboardController@emailCheckerView')->name('email-checker');
        Route::post('checking-email', 'DashboardController@emailCheckerAction');

        Route::post('get-payment-form', 'OptionController@getPaymentFormAction');
        Route::post('sort-payment', 'OptionController@sortPaymentAction');
        Route::post('get-checking-email-form', 'OptionController@getCheckingEmailFormAction');
        Route::get('seo', 'SeoController@seoView')->name('seo');
        Route::post('seo-save-settings', 'SeoController@saveSettingsAction');
        Route::post('seo-single-save-settings', 'SeoController@saveSingleSettingsAction');

        Route::get('themes', 'ThemeController@themeView')->name('themes');
        Route::post('active-theme', 'ThemeController@activeThemeAction');
        Route::post('deactivate-theme', 'ThemeController@deactivateThemeAction');
        Route::post('delete-theme', 'ThemeController@deleteThemeAction');
        Route::get('theme-install', 'ThemeController@newThemeView')->name('theme.new');
        Route::post('install-theme', 'ThemeController@installThemeAction');
        Route::post('update-theme', 'ThemeController@updateThemeAction');

        Route::get('plugins', 'PluginController@pluginView')->name('plugins');
        Route::post('active-plugin', 'PluginController@activePluginAction');
        Route::post('deactivate-plugin', 'PluginController@deactivatePluginAction');
        Route::post('delete-plugin', 'PluginController@deletePluginAction');
        Route::get('plugin-install', 'PluginController@newPluginView')->name('plugin.new');
        Route::post('install-plugin', 'PluginController@installPluginAction');
        Route::post('update-plugin', 'PluginController@updatePluginAction');


    }
);

Route::group([
    'module' => 'Backend',
    'namespace' => $namespace,
    'middleware' => ['web', 'auth', 'locale', 'car_enable'],
    'prefix' => admin_config('prefix')
], function () {
    Route::get('new-car', 'CarController@newCarView')->name('new-car');
    Route::get('all-cars', 'CarController@allCarView')->name('all-cars');
    Route::get('edit-car/{id?}', 'CarController@editCarView')->name('edit-car');
    Route::post('save-car', 'CarController@saveCarAction');
    Route::post('delete-car', 'CarController@deleteCarAction');
    Route::get('car-review', 'CarController@allReviewView')->name('car-review');
    Route::post('restore-car', 'CarController@restoreCarAction');
    Route::post('hard-delete-car', 'CarController@hardDeleteCarAction');
    Route::post('change-car-status', 'CarController@changePostStatusAction');
});

Route::group([
    'module' => 'Backend',
    'namespace' => $namespace,
    'middleware' => ['web', 'auth', 'locale', 'apartment_enable'],
    'prefix' => admin_config('prefix')
], function () {
    Route::get('new-apartment', 'ApartmentController@newApartmentView')->name('new-apartment');
    Route::get('all-apartments', 'ApartmentController@allApartmentView')->name('all-apartments');
    Route::get('edit-apartment/{id?}', 'ApartmentController@editApartmentView')->name('edit-apartment');
    Route::post('save-apartment', 'ApartmentController@saveApartmentAction');
    Route::post('delete-apartment', 'ApartmentController@deleteApartmentAction');
    Route::get('apartment-review', 'ApartmentController@allReviewView')->name('apartment-review');
    Route::post('restore-apartment', 'ApartmentController@restoreApartmentAction');
    Route::post('hard-delete-apartment', 'ApartmentController@hardDeleteApartmentAction');
    Route::post('change-apartment-status', 'ApartmentController@changePostStatusAction');
});


Route::group([
    'module' => 'Backend',
    'namespace' => $namespace,
    'middleware' => ['web', 'auth', 'locale', 'property_enable' ,'subscription'],
    'prefix' => admin_config('prefix')
], function () {
    Route::get('new-property', 'SaleController@newPropertyView')->name('new-property');
    Route::get('all-properties', 'SaleController@allPropertyView')->name('all-properties');

    Route::get('edit-property/{id?}', 'SaleController@editPropertyView')->name('edit-property');
    Route::post('save-property', 'SaleController@savePropertyAction');
    Route::post('delete-property', 'SaleController@deletePropertyAction');
    Route::get('property-review', 'SaleController@allReviewView')->name('rent-review');
    Route::post('restore-property', 'SaleController@restorePropertyAction');
    Route::post('hard-delete-property', 'SaleController@hardDeletePropertyAction');
    Route::post('change-property-status', 'SaleController@changePostStatusAction');
});

Route::group([
    'module' => 'Backend',
    'namespace' => $namespace,
    'middleware' => ['web', 'auth', 'locale', 'hotel_enable','subscription'],
    'prefix' => admin_config('prefix')
], function () {
    Route::get('new-hotel', 'HotelController@newHotelView')->name('new-hotel');
    Route::get('all-hotels', 'HotelController@allHotelView')->name('all-hotels');
    Route::get('edit-hotel/{id?}', 'HotelController@editHotelView')->name('edit-hotel');
    Route::post('save-hotel', 'HotelController@saveHotelAction');
    Route::post('delete-hotel', 'HotelController@deleteHotelAction');
    Route::get('hotel-review', 'HotelController@allReviewView')->name('hotel-review');
    Route::post('restore-hotel', 'HotelController@restoreHotelAction');
    Route::post('hard-delete-hotel', 'HotelController@hardDeleteHotelAction');
    Route::post('change-hotel-status', 'HotelController@changePostStatusAction');

    Route::get('all-rooms', 'RoomController@allRoomView')->name('all-rooms');
    Route::get('new-room', 'RoomController@newRoomView')->name('new-room');
    Route::post('save-room', 'RoomController@saveRoomAction');
    Route::get('edit-room/{id?}', 'RoomController@editRoomView')->name('edit-room');
    Route::post('delete-room', 'RoomController@deleteRoomAction');
    Route::post('restore-room', 'RoomController@restoreRoomAction');
    Route::post('hard-delete-room', 'RoomController@hardDeleteRoomAction');
    Route::post('change-room-status', 'RoomController@changePostStatusAction');
});

Route::group([
    'module' => 'Backend',
    'namespace' => $namespace,
    'middleware' => ['web', 'auth', 'locale', 'beauty_enable','subscription'],
    'prefix' => admin_config('prefix')
], function () {
    Route::get('new-beauty', 'BeautyController@newBeautyView')->name('new-beauty');
    Route::get('all-beauty', 'BeautyController@allBeautyView')->name('all-beauty');
    Route::get('edit-beauty/{id?}', 'BeautyController@editBeautyView')->name('edit-beauty');
    Route::post('save-beauty', 'BeautyController@saveBeautyAction');
    Route::post('delete-beauty', 'BeautyController@deleteBeautyAction');
    Route::get('beauty-review', 'BeautyController@allReviewView')->name('beauty-review');
    Route::post('restore-beauty', 'BeautyController@restoreBeautyAction');
    Route::post('hard-delete-beauty', 'BeautyController@hardDeleteBeautyAction');
    Route::post('change-beauty-status', 'BeautyController@changePostStatusAction');
});


Route::group([
    'module' => 'Backend',
    'namespace' => $namespace,
    'middleware' => ['web', 'auth', 'locale', 'agent_enable','subscription'],
    'prefix' => admin_config('prefix')
], function () {
    Route::get('{service}/new-agent', 'AgentController@newAgentView')->name('new-agent');
    Route::get('{service}/all-agents', 'AgentController@allAgentView')->name('all-agents');
    Route::get('{service}/edit-agent/{id?}', 'AgentController@editAgentView')->name('edit-agent');
    Route::post('save-agent', 'AgentController@saveAgentAction');
    Route::post('{service}/delete-agent', 'AgentController@deleteAgentAction');
});

Route::group([
    'module' => 'Backend',
    'namespace' => $namespace,
    'middleware' => ['web', 'auth', 'locale', 'space_enable','subscription'],
    'prefix' => admin_config('prefix')
], function () {
    Route::get('new-space', 'SpaceController@newSpaceView')->name('new-space');
    Route::get('all-spaces', 'SpaceController@allSpaceView')->name('all-space');
    Route::get('edit-space/{id?}', 'SpaceController@editSpaceView')->name('edit-space');
    Route::post('save-space', 'SpaceController@saveSpaceAction');
    Route::post('delete-space', 'SpaceController@deleteSpaceAction');
    Route::get('space-review', 'SpaceController@allReviewView')->name('space-review');
    Route::post('restore-space', 'SpaceController@restoreSpaceAction');
    Route::post('hard-delete-space', 'SpaceController@hardDeleteSpaceAction');
    Route::post('change-space-status', 'SpaceController@changePostStatusAction');
});

Route::group([
    'module' => 'Backend',
    'namespace' => $namespace,
    'middleware' => ['web', 'auth', 'locale', 'tour_enable','subscription'],
    'prefix' => admin_config('prefix')
], function () {
    Route::get('new-tour', 'TourController@newTourView')->name('new-tour');
    Route::get('all-tours', 'TourController@allTourView')->name('all-tours');
    Route::get('edit-tour/{id?}', 'TourController@editTourView')->name('edit-tour');
    Route::post('save-tour', 'TourController@saveTourAction');
    Route::post('delete-tour', 'TourController@deleteTourAction');
    Route::get('tour-review', 'TourController@allReviewView')->name('tour-review');
    Route::post('restore-tour', 'TourController@restoreTourAction');
    Route::post('hard-delete-tour', 'TourController@hardDeleteTourAction');
    Route::post('change-tour-status', 'TourController@changePostStatusAction');
});
