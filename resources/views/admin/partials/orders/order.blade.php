@extends('admin.admin_dashboard')

@section('content')
<div class="page-content">
    <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
            <div>
                <h4 class="mb-3 mb-md-0">Orders</h4>
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
            <a href="{{ route('admin.add_product') }}">
            <button button type="button" class="btn btn-primary btn-icon-text mb-2 mb-md-0">
               <i class="btn-icon-prepend" data-feather="download-cloud"></i>
                Add Product
            </button>
            </a>
        </div>
    </div>
    @include('_message')
    <div class="row">
		<div class="col-md-12 grid-margin stretch-card">
            <div class="card">
              <div class="card-body">
                <h6 class="card-title">Product List</h6>
                <div class="table-responsive">
                  <table id="dataTableExample" class="table">
                    <thead>
                      <tr>
                        <th width="100">Customer Name</th>
                        <th width="100">Address</th>
                        <th width="100">Phone</th>
                        <th width="100">Product Title</th>
                        <th width="100">Price</th>
                        <th width="100">Image</th>
                        <th width="100">Payment</th>
                        <th width="100">Status</th>
                        <th width="100">Change Status</th>
                        <th width="100">Print PDF</th>
                      </tr>
                    </thead>
                    <tbody>
                    @foreach ($data as $data)
                    <tr>
                        <td>
                            <div style="width: 100px; white-space: normal; word-wrap: break-word;">
                                {{$data->name}}
                            </div>
                        </td>
                        <td>
                            <div style="width: 100px; white-space: normal; word-wrap: break-word;">
                                {{$data->address}}
                            </div>
                        </td>
                        <td>{{$data->phone}}</td>
                        <td>{{$data->product->title}}</td>
                        <td>{{$data->product->price}}</td>
                        <td>
                            <img width="50" src="/upload/product/{{$data->product->image}}" alt="">
                        </td>
                        <td>{{$data->payment_status}}</td>
                        <td>
                            @if ($data->status == 'in progress')
                                <span class="badge bg-danger">{{$data->status}}</span>
                            @else
                                <span class="badge bg-success">{{$data->status}}</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.on_the_way',$data->id)}}"><span class="badge bg-primary">On The Way</span></a>
                            <a href="{{ route('admin.delivered',$data->id)}}"><span class="badge bg-success">Delivered</span></a>
                        </td>
                        <td>
                            <a href="{{ route('admin.print_pdf',$data->id)}}"><span class="badge bg-danger">PDF</span></a>
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