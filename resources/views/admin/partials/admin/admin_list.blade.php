@extends('admin.admin_dashboard')

@section('content')
<div class="page-content">
    <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
      <div>
        <h4 class="mb-3 mb-md-0">Admin List</h4>
      </div>
      <div class="d-flex align-items-center flex-wrap text-nowrap">
        <div class="input-group flatpickr wd-200 me-2 mb-2 mb-md-0" id="dashboardDate">
          <span class="input-group-text input-group-addon bg-transparent border-primary" data-toggle><i data-feather="calendar" class="text-primary"></i></span>
          <input type="text" class="form-control bg-transparent border-primary" placeholder="Select date" data-input>
        </div>
        <button type="button" class="btn btn-outline-primary btn-icon-text me-2 mb-2 mb-md-0">
          <i class="btn-icon-prepend" data-feather="printer"></i>
          Print
        </button>
        <a href="{{ route('admin.admin_add') }}">
        <button type="button" class="btn btn-primary btn-icon-text mb-2 mb-md-0">
          <i class="btn-icon-prepend" data-feather="download-cloud"></i>
          Add new Admin
        </button>
        </a>
      </div>
    </div>
    @include('_message')
    <div class="row">
					<div class="col-md-12 grid-margin stretch-card">
            <div class="card">
              <div class="card-body">
                <h6 class="card-title">Admin List</h6>
                <div class="table-responsive">
                  <table id="dataTableExample" class="table">
                    <thead>
                      <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                    @foreach ($user as $admin)
                      <tr>
                        <td>{{ $admin->name }}</td>
                        <td>{{ $admin->email }}</td>
                        <td>
                          @if ( $admin->status != 'inactive' )
                              <span class="badge bg-success">Active</span>
                          @else
                              <span class="badge bg-danger">Inactive</span>
                          @endif
                        </td>
                        <td>
                        <a href="{{ route('admin.admin_edit', $admin->id) }}" class="px-2"><i style="color: green" data-feather="edit"></i></a>
                        <a href="{{ route('admin.admin_delete', $admin->id) }}"> <i style="color: red" data-feather="x-circle"></i></a>
                        </td>
                      </tr>
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