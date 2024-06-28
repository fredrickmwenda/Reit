@extends('Backend::layouts.master')

@section('title', 'Subscription Plans')



@section('content')



<div class="layout-top-spacing">
    <div class="statbox widget box box-shadow">

        <div class="widget-header">
            <div class="row">
                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                    <div class="d-flex align-items-center justify-content-between">
                        <h4></h4>
                        <a href="{{dashboard_url('subscription/creation')}}" class="btn btn-success">{{__('Add New')}}</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="table-responsive mb-1 mt-4">
        @php
        $currentUser = Auth::user(); 
    @endphp

            <table class="multi-table table table-striped table-bordered table-hover non-hover w-100" data-plugin="footable">
                <thead>
                    <tr>
                        <th>Name </th>
                        <th>Periodicity</th>
                        <th>Periodicity Type</th>
                        <th> Grace Days </th>
                        <th> Price </th>
                        <th> No of Subscribers </th>

                        <th class="text-center">{{__('Action')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($subcriptionPlans as $subcriptionPlan)
                    @php
                    // Retrieve the price from the PlanPrice model based on the current plan ID
                    $planPrice = \App\Models\PlanPrice::where('plan_id', $subcriptionPlan->id)->first();

                    // Set image and header title based on plan type
                    $image = '';
                    $headerTitle = '';

                    if ($subcriptionPlan->name === 'Gold') {
                    $image = 'images/enterprise-coin.png';
                    $headerTitle = 'Enterprise';
                    } elseif ($subcriptionPlan->name === 'Diamond') {
                    $image = 'images/pro-coin.png';
                    $headerTitle = 'Professional';
                    } elseif ($subcriptionPlan->name === 'Silver') {
                    $image = 'images/free-coin.png';
                    $headerTitle = 'Basic';
                    }
                    @endphp
                    <tr>
                        <td>
                            {{$subcriptionPlan->name}}
                        </td>
                        <td>
                            {{$subcriptionPlan->periodicity}}
                        </td>
                        <td>
                            {{$subcriptionPlan->periodicity_type}}
                        </td>
                        <td>
                            {{$subcriptionPlan->grace_days}}
                        </td>

                        <td>
                            {{$planPrice ? $planPrice->price : 'N/A'}}
                        </td>

                        <td>
                        {{$currentUser->numberOfSubscribersInPlan($subcriptionPlan)}}

                        </td>

                 

                        <td class="text-center">
                            <div class="dropdown custom-dropdown">
                                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal">
                                        <circle cx="12" cy="12" r="1"></circle>
                                        <circle cx="19" cy="12" r="1"></circle>
                                        <circle cx="5" cy="12" r="1"></circle>
                                    </svg>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink1">
                              
                                    <a class="dropdown-item" href="{{dashboard_url('edit-subscription/' . $subcriptionPlan->id)}}"   >{{__('Edit')}}</a>
                                    <form action="{{ route('subscription.destroy', $subcriptionPlan->id) }}" method="POST">
    @csrf
    @method('DELETE')

    <button type="submit" class="btn btn-danger">Delete</button>
</form>
                                </div>
                            </div>
                        </td>

                    </tr>
                    @endforeach
                </tbody>
            </table>




        </div>

    </div>
</div>
@stop