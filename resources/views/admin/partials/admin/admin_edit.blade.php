@extends('admin.admin_dashboard')

@section('content')
<div class="page-content">
    <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
      <div>
        <h4 class="mb-3 mb-md-0">Admin Update</h4>
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
        <button type="button" class="btn btn-primary btn-icon-text mb-2 mb-md-0">
          <i class="btn-icon-prepend" data-feather="download-cloud"></i>
          Download Report
        </button>
      </div>
    </div>

    <div class="row">
            <div class="card">
                <div class="card-body">
                    <form class="forms-sample" action="{{ route('admin.admin_update', $user->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" class="form-control" id="exampleInputUsername1" placeholder="Enter Name" value="{{ old('name', $user->name) }}">
                            <span style="color: red;">{{ $errors->first('name') }}</span>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" placeholder="Enter Email" value="{{ old('email', $user->email) }}"">
                            <span style="color: red;">{{ $errors->first('email') }}</span>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="text" name="password" class="form-control" id="exampleInputUsername1" placeholder="Enter Password">
                            <span>Do You Want to Change Password? Then Change</span>
                            <span style="color: red;">{{ $errors->first('password') }}</span>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" id="status" class="form-control">
                                <option value="{{$user->status}}">
                                    @if ( $user->status != 'inactive' )
                                        <p>Active</p>
                                    @else
                                        <p>Inactive</p>
                                    @endif
                                </option>
                                <option value="active">Active</option>
                                <option value="inactive">Block</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary me-2 px-3">Update Admin</button>
                    </form>
                </div>
              </div>
        </div>
</div>
@endsection