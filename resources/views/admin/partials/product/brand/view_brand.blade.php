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

        </div>
    </div>
    @include('_message')
    <div class="container-fluid">
        <form action="{{route('admin.upload_brand')}}" method="post" id="categoryForm" name="categoryForm" enctype="multipart/form-data">
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
                            <input type="text" name="name" id="name" class="form-control" placeholder="Name" value="{{ old('name') }}">	
                            <span style="color: red;">{{ $errors->first('name') }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="slug">Slug <span style="color: red;">*</span></label>
                            <input type="text" name="slug" id="slug" class="form-control" placeholder="Slug Ex.URL" value="{{ old('slug') }}">	
                            <span style="color: red;">{{ $errors->first('slug') }}</span>
                        </div>
                    </div>									
                </div>
            </div>		
        </div>
        <div class="pb-5 pt-3">
            <button type="submit" class="btn btn-primary">Upload Brand</button>
        </div>
        </form>
    </div>

    <div class="row">
		<div class="col-md-12 grid-margin stretch-card">
            <div class="card">
              <div class="card-body">
                <h6 class="card-title">Brand List</h6>
                <div class="table-responsive">
                  <table id="dataTableExample" class="table">
                    <thead>
                      <tr>
                        <th width="100">Created By</th>
                        <th width="100">Name</th>
                        <th width="100">Slug</th>
                        <th width="100">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                    @foreach ($brand as $brands)
                        @if ($brands != "")
                        <tr>
                            <td>{{ $brands->created_by_name }}</td>
                            <td>{{ $brands->name }}</td>
                            <td>{{ $brands->slug }}</td>
                            <td>
                                <a class="mx-2" href="{{route('admin.edit_brand',$brands->id)}}"><i style="color: green" data-feather="edit"></i></a>
                                <a onclick="showSwal('message-with-auto-close')" href="{{route('admin.delete_brand',$brands->id)}}" ><i style="color: red" data-feather="x-circle"></i></a>
                            </td>
                        </tr>
                        @endif
                        @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
		</div>
	</div>

</div>


@endsection