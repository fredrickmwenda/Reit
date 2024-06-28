<?php
/**
 * Created by PhpStorm.
 * User: Jream
 * Date: 5/12/2020
 * Time: 11:33 PM
 */

namespace App\Modules\Backend\Controllers;

use App\Services\RentService;
use App\Services\CommentService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\Paginator;

class RentController extends Controller
{
    private $service;

    public function __construct()
    {
        $this->service = RentService::inst();
    }

    public function changePostStatusAction(Request $request)
    {
        $response = $this->service->changeStatus($request);
        return response()->json($response);
    }

    public function allReviewView()
    {
        $commentService = CommentService::inst();
        $allPosts = $commentService->getReviewsPagination('rent', 5);
        Paginator::useBootstrap();
        return $this->getView($this->getFolderView('services.rent.review'), ['allPosts' => $allPosts]);
    }

    public function hardDeleteRentAction(Request $request)
    {
        $response = $this->service->hardDeleteRent($request);
        return response()->json($response);
    }

    public function restoreRentAction(Request $request)
    {
        $response = $this->service->restoreRent($request);
        return response()->json($response);
    }

    public function deleteRentAction(Request $request)
    {
        $response = $this->service->deletePost($request);
        return response()->json($response);
    }

    public function editRentView($id)
    {
        $postData = $this->service->storeTermData($id);
        if ($postData) {
            $postData = $postData->getAttributes();
            $postData['post_type'] = 'rent';
            return $this->getView($this->getFolderView('services.rent.edit'), [
                'serviceData' => $postData,
                'title' => __('Edit rent'),
                'new' => false
            ]);
        }
        return response()->redirectTo(dashboard_url('all-rents'));
    }

    public function allRentView(Request $request)
    {
        $this->service->deletePostTemp();
        $status = $request->get('status', '');
        $where = [];
        $post_status = admin_config('rent_status');
        if (!empty($status) && in_array($status, array_keys($post_status))) {
            $where['status'] = $status;
        }
        $allPosts = $this->service->getPostsPagination(10, $where);
        Paginator::useBootstrap();
        return $this->getView($this->getFolderView('services.rent.all'), ['allPosts' => $allPosts]);
    }

    public function saveRentAction(Request $request)
    {
        $response = $this->service->savePost($request);
        return response()->json($response);
    }

    public function newRentView()
    {
        $this->service->deletePostTemp();
        $id = $this->service->storeNewPost();
        $postData = $this->service->getPostById($id)->getAttributes();
        $postData['post_type'] = 'rent';
        return $this->getView($this->getFolderView('services.rent.edit'), [
            'serviceData' => $postData,
            'title' => __('Add new rent'),
            'new' => true
        ]);
    }
}