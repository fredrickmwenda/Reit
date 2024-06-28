@extends('Backend::layouts.master')

@section('title', 'Subscription Features')



@section('content')



<div class="layout-top-spacing">
    <div class="statbox widget box box-shadow">

        <div class="widget-header">
            <div class="row">
                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                    <div class="d-flex align-items-center justify-content-between">
                        <h4></h4>
                        <a href="{{dashboard_url('feature/creation')}}" class="btn btn-success">{{__('Add New')}}</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="table-responsive mb-1 mt-4">

            <table class="multi-table table table-striped table-bordered table-hover non-hover w-100" data-plugin="footable">
                <thead>
                    <tr>
                        <th>Name </th>
                        <th>Quota</th>
                        <th>Consumable</th>


                        <th class="text-center">{{__('Action')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($features as $feature)
                    
                    <tr>
                        <td>
                            {{$feature->name}}
                        </td>
                        <td>{{ $feature->quota ? 'Yes' : 'No' }}</td>
                        <td>{{ $feature->consumable ? 'Yes' : 'No' }}</td>

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
                                    <a class="dropdown-item" href="{{dashboard_url('edit-feature/' . $feature->id)}}"   >{{__('Edit')}}</a>
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