@extends('admin.admin_dashboard')

@section('content')
<div class="page-content">
    <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
            <div>
                <h4 class="mb-3 mb-md-0">Product SubCategory</h4>
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
            <a href="{{ route('admin.add_subcategory') }}">
            <button button type="button" class="btn btn-primary btn-icon-text mb-2 mb-md-0">
               <i class="btn-icon-prepend" data-feather="download-cloud"></i>
                Add Sub-Category
            </button>
            </a>
        </div>
    </div>
    @include('_message')
    <div class="row">
		<div class="col-md-12 grid-margin stretch-card">
            <div class="card">
              <div class="card-body">
                <h6 class="card-title">Sub-Category List</h6>
                <div class="table-responsive">
                  <table id="dataTableExample" class="table">
                    <thead>
                      <tr>
                        <th width="100">Created By</th>
                        <th width="100">Category Name</th>
                        <th width="100">Sub-Category</th>
                        <th width="100">Slug</th>
                        <th width="100">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                    @foreach ($subcategory as $subcategories)
                        @if ($subcategories != "")
                        <tr>
                            <td>{{ $subcategories->created_by_name }}</td>
                            <td>{{ $subcategories->category_name }}</td>
                            <td>{{ $subcategories->name }}</td>
                            <td>{{ $subcategories->slug }}</td>
                            <td>
                                <a class="mx-2" href="{{route('admin.edit_subcategory',$subcategories->id)}}"><i style="color: green" data-feather="edit"></i></a>
                                <a onclick="showSwal('message-with-auto-close')" href="{{route('admin.delete_subcategory',$subcategories->id)}}" ><i style="color: red" data-feather="x-circle"></i></a>
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