@extends('Backend::layouts.master')

@section('title', __('Edit Subscription'))
@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />


@endpush
@section('content')

<div class="layout-top-spacing">
    <div class="statbox widget box box-shadow">
        <div class="widget-header p-0 mb-4">
            <div class="row">
                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                    <div class="d-flex align-items-center justify-content-between">
                        <h4>Edit Subscription</h4>
                        <a href="{{ dashboard_url('subscription') }}" class="btn btn-dark">{{__('Back to all')}}</a>
                    </div>
                </div>
            </div>
        </div>

        <form action="{{ route('subscription.update', $subscription->id) }}" method="POST" data-loader="body" enctype="multipart/form-data">
            @csrf


            <div class="mb-3">
                <label for="name" class="form-label">Subscription Plan</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $subscription->name }}" required>
            </div>

            <div class="mb-3">
                <label for="periodicity" class="form-label">Periodicity</label>
                <input type="number" class="form-control" id="periodicity" name="periodicity" value="{{ $subscription->periodicity }}" required>
            </div>

            <div class="mb-3">
                <label for="periodicity_type" class="form-label">Period Type</label>
                <select class="form-control" id="periodicity_type" name="periodicity_type" required>
                    <option value="Days" @if($subscription->periodicity_type === 'Day') selected @endif>Days</option>
                    <option value="Weeks" @if($subscription->periodicity_type === 'Week') selected @endif>Weeks</option>
                    <option value="Months" @if($subscription->periodicity_type === 'Month') selected @endif>Months</option>
                    <option value="Years" @if($subscription->periodicity_type === 'Year') selected @endif>Years</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="price" class="form-label">Price</label>
                <input type="number" class="form-control" id="price" name="price" value="{{ $subscription->prices->price }}" required>
            </div>

            <div class="mb-3">
                <label for="features" class="form-label">Features</label>
                <select name="features[]" id="features" class="select2-multiple form-control" multiple="multiple">
                    @foreach($features as $feature)
                    <option value="{{ $feature->id }}" @if(in_array($feature->id, $selectedFeatures)) selected @endif>{{ $feature->name }}</option>
                    @endforeach
                </select>
            </div>


            <div class="mb-3">
                <label for="grace_days" class="form-label">Grace Days:</label>
                <input type="number" class="form-control" id="grace_days" name="grace_days" value="{{ $subscription->grace_days }}">
            </div>

            <button type="submit" class="btn btn-primary">Update Subscription</button>
        </form>
    </div>
</div>

@endsection

@push('scripts')

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        // Select2 Multiple
        $('.select2-multiple').select2({
            placeholder: "Select",
            allowClear: true
        });

    });
</script>

@endpush