<?php

namespace App\Modules\Frontend\Controllers;

use App\Http\Controllers\Controller;
use App\Services\PropertyService;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    private $service;

    public function __construct()
    {
        $this->service = PropertyService::inst();
    }

    // public function fetchTimeAction(Request $request)
    // {
    //     $response = $this->service->fetchTime($request);
    //     return response()->json($response);
    // }

    public function propertyPageView()
    {
        return view('Frontend::services.property.index'); 
    }

    public function sendEnquiryAction(Request $request)
    {
        $response = $this->service->sendEnquiry($request);
        return response()->json($response);
    }

    public function getRealPriceAction(Request $request)
    {
        $post_id = $request->post('post_id');

        $extra = $request->post('extras');
        $response = $this->service->getRealPrice($post_id, $extra);
      
        return response()->json($response);
    }

    public function fetchAvailabilityAction(Request $request)
    {
        $response = $this->service->fetchPropertyAvailability($request);
        return response()->json($response);
    }

    public function addCartAction(Request $request)
    {
        $data = $this->service->addToCart($request);
        return response()->json($data);
    }

    public function singleView($slug, Request $request)
    {
        $data = $this->service->getPostBySlug($slug);
        if ($data) {
            if (is_admin() || $data['author'] == get_current_user_id() || $data['status'] == 'publish') {
                global $post;
                $post = $data->getAttributes();
                $post['post_type'] = GMZ_SERVICE_PROPERTY;
                return view('Frontend::services.property.single', ['post' => $post]);
            }
        }
        return response()->view('Frontend::errors.404', [], 200);
    }

    public function propertySearchAction(Request $request)
    {
        $data = $this->service->getSearchResult($request);
        return response()->json($data);
    }

    public function propertySearchView(Request $request)
    {
        return view('Frontend::services.property.search');
    }
}