<?php
/**
 * Created by PhpStorm.
 * User: Jream
 * Date: 5/12/2020
 * Time: 11:33 PM
 */

namespace App\Modules\Backend\Controllers;

use App\Services\PropertyService;
use App\Services\CommentService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\Paginator;

class SaleController extends Controller
{
    private $service;

    public function __construct()
    {
        $this->service = PropertyService::inst();
    }

    public function changePostStatusAction(Request $request)
    {
        $response = $this->service->changeStatus($request);
        return response()->json($response);
    }

    public function allReviewView()
    {
        $commentService = CommentService::inst();
        $allPosts = $commentService->getReviewsPagination('property', 5);
        Paginator::useBootstrap();
        return $this->getView($this->getFolderView('services.property.review'), ['allPosts' => $allPosts]);
    }

    public function hardDeletePropertyAction(Request $request)
    {
        $response = $this->service->hardDeleteProperty($request);
        return response()->json($response);
    }

    public function restorePropertyAction(Request $request)
    {
        $response = $this->service->restoreProperty($request);
        return response()->json($response);
    }

    public function deletePropertyAction(Request $request)
    {
        $response = $this->service->deletePost($request);
        return response()->json($response);
    }

    public function editPropertyView($id)
    {
        $postData = $this->service->storeTermData($id);
        if ($postData) {
            $postData = $postData->getAttributes();
            $postData['post_type'] = 'property';
            return $this->getView($this->getFolderView('services.property.edit'), [
                'serviceData' => $postData,
                'title' => __('Edit property'),
                'new' => false
            ]);
        }
        return response()->redirectTo(dashboard_url('all-properties'));
    }

    public function allPropertyView(Request $request)
    {
        $this->service->deletePostTemp();
        $status = $request->get('status', '');
        $where = [];
        $post_status = admin_config('property_status');
       
        if (!empty($status) && in_array($status, array_keys($post_status))) {
            $where['status'] = $status;
        }
        $allPosts = $this->service->getPostsPagination(10, $where);
        Paginator::useBootstrap();
        return $this->getView($this->getFolderView('services.property.all'), ['allPosts' => $allPosts]);
    }

    public function savePropertyAction(Request $request)
    {
        $response = $this->service->savePost($request);
        return response()->json($response);
    }

    public function newPropertyView()
    {
        $this->service->deletePostTemp();
        $id = $this->service->storeNewPost();
        $postData = $this->service->getPostById($id)->getAttributes();
        $postData['post_type'] = 'property';
        
        return $this->getView($this->getFolderView('services.property.edit'), [
            'serviceData' => $postData,
            'title' => __('Add new property'),
            'new' => true
        ]);
    }
}