@extends('admin.admin_dashboard')

@section('content')
<div class="page-content">
    <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
            <div>
                <h4 class="mb-3 mb-md-0">Product Brand</h4>
            </div>
         <div class="d-flex align-items-center flex-wrap text-nowrap">
            <div class="input-group flatpickr wd-200 me-2 mb-2 mb-md-0" id="dashboardDate">
                <span class="input-group-text input-group-addon bg-transparent border-primary" data-toggle><i data-feather="calendar" class="text-primary"></i></span>
                <input type="text" class="form-control bg-transparent border-primary" placeholder="Select date" data-input>
            </div>
            <button type="button" class="btn btn-outline-primary btn-icon-text me-2 mb-2 mb-md-0">
                <i class="btn-icon-prepend" data-feather="printer"></i>
                Download Report
            </button>
            <a href="{{ route('admin.view_brand') }}">
                <button button type="button" class="btn btn-primary btn-icon-text mb-2 mb-md-0">
                    <i class="btn-icon-prepend" data-feather="download-cloud"></i>
                    Back
                </button>
            </a>
        </div>
    </div>
    @include('_message')
    <div class="container-fluid">
        <form action="{{route('admin.update_brand', $brand->id )}}" method="post" id="categoryForm" name="categoryForm" enctype="multipart/form-data">
            @csrf
        <div class="card">
            <div class="card-body">	
                <div class="col-sm-6 mb-4">
                    <h4>Create Sub-Category</h4>
                </div>							
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name">Name <span style="color: red;">*</span></label>
                            <input type="text" name="name" id="name" class="form-control" placeholder="Name" value="{{ old('name', $brand->name) }}">	
                            <span style="color: red;">{{ $errors->first('name') }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="slug">Slug <span style="color: red;">*</span></label>
                            <input type="text" name="slug" id="slug" class="form-control" placeholder="Slug Ex.URL" value="{{ old('slug', $brand->slug) }}">	
                            <span style="color: red;">{{ $errors->first('slug') }}</span>
                        </div>
                    </div>									
                </div>
            </div>		
        </div>
        <div class="pb-5 pt-3">
            <button type="submit" class="btn btn-primary">Update Brand</button>
        </div>
        </form>
    </div>

</div>


@endsection