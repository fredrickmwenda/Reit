@extends('Backend::layouts.master')

@section('title', __(sprintf('Edit %s', 'Edit Feature')))

@section('content')

<div class="layout-top-spacing">
    <div class="statbox widget box box-shadow">

        <!-- Widget header and back button -->
        <div class="widget-header p-0 mb-4">
            <div class="row">
                <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                    <div class="d-flex align-items-center justify-content-between">
                        <h4></h4>

                        <a href="{{dashboard_url('feature')}}" class="btn btn-dark">{{__('Back to all')}}</a>
                    </div>
                </div>
            </div>
        </div>

        <form action="{{ route('feature.update', $feature->id) }}" method="POST" data-loader="body" enctype="multipart/form-data">
            @csrf
            

            <div class="mb-3">
                <label for="name" class="form-label">Feature Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $feature->name }}" required>
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" id="consumable" name="consumable" class="form-check-input" @if($feature->consumable) checked @endif>
                <label class="form-check-label" for="consumable">Consumable</label>
            </div>

            <div class="mb-3 form-check">
                <input type="checkbox" id="quota" name="quota" class="form-check-input" @if($feature->quota) checked @endif>
                <label class="form-check-label" for="quota">Quota</label>
            </div>

            <button type="submit" class="btn btn-primary">Update Feature</button>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<!-- Include Bootstrap Switch JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-switch/3.3.4/js/bootstrap-switch.min.js"></script>

<script>
    // Initialize Bootstrap Switch
    $("[data-toggle='switch']").bootstrapSwitch();
</script>
@endpush
