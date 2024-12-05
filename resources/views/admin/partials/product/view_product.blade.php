@extends('admin.admin_dashboard')

@section('content')
<div class="page-content">
    <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
            <div>
                <h4 class="mb-3 mb-md-0">Product</h4>
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
                        <th width="100">Created By</th>
                        <th width="100">Image</th>
                        <th width="100">Title</th>
                        <th width="100">Category</th>
                        <th width="100">Size</th>
                        <th width="100">Brand</th>
                        <th width="100">Colour</th>
                        <th width="100">Material</th>
                        <th width="100">Status</th>
                        <th width="100">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                    @foreach ($product as $product_item)
                        <tr>
                            <td>{{ $product_item->created_by_name }}</td>
                            <td>
                                @if ($product_item->image != "")
                                <img src="/upload/product/{{$product_item->image}}"  width="50" >
                                @else
                                <p>no image</p>
                                @endif
                                
                            </td>
                            <td>{{ $product_item->title }}</td>
                            <td>{{ $product_item->category_name }}</td>
                            <td>
                              <div style="width: 100px; white-space: normal; word-wrap: break-word;">
                                {{ $product_item->size }}
                              </div>
                            </td>
                            <td>{{ $product_item->brand_name }}</td>
                            <td>
                              <div style="width: 100px; white-space: normal; word-wrap: break-word;">
                              {{ $product_item->color }}
                              </div>
                            </td>
                            <td>{{ $product_item->material }}</td>
                            <td>
                                @if ( $product_item->status != 0 )
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-danger">Inactive</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{route('admin.productimages',$product_item->id)}}"><span class="badge bg-primary">Images</span></a>
                            </td>
                            <td>
                                <a class="mx-2" href="{{route('admin.edit_product',$product_item->id)}}"><i style="color: green" data-feather="edit"></i></a>
                                <a onclick="showSwal('message-with-auto-close')" href="{{route('admin.delete_product',$product_item->id)}}" ><i style="color: red" data-feather="x-circle"></i></a>
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