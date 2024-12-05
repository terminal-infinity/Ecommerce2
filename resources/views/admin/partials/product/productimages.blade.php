@extends('admin.admin_dashboard')

@section('content')
<div class="page-content">
    <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
            <div>
                <h4 class="mb-3 mb-md-0">Product Image Gallary</h4>
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
            <a style="color: aliceblue;" href="{{route('admin.view_product')}}">
            <button button type="button" class="btn btn-primary btn-icon-text mb-2 mb-md-0">
               <i class="btn-icon-prepend" data-feather="download-cloud"></i>
                Back
            </button>
            </a>
        </div>
    </div>
    <div class="container-fluid">
        <form action="{{route('admin.upload_productimages',$product->id)}}" method="post" enctype="multipart/form-data">
            @csrf
        <div class="card mb-4">
            <div class="card-body">	
                <div class="col-sm-6 mb-4">
                    <h4>Add Images</h4>
                </div>							
                <div class="row">
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="name">Product Name</label>
                            <input type="text" name="product_id" value="{{ $product->title }}"  class="form-control" >	
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="name">Upload Images</label>
                            <input type="file" name="image[]" multiple id="images" class="form-control" required>	
                        </div>
                    </div>								
                </div>
                <div class="pt-3">
                    <button type="submit" class="btn btn-primary">Upload Images</button>
                </div>
            </div>						
        </div>

        
        </form>
    </div>
    <div class="col-12 mt-2">
        <div class="bg-light rounded h-100 p-4">
            <h6 class="mb-4">Product Images</h6>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th width="100" scope="col">Image</th>
                            <th width="100" scope="col">Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($images as $img)
                        @if ($img != "")
                        <tr>
                            <td>
                                @if ($img->image != "")
                                <img src="/upload/product/{{$img->image}}"  width="50%" >
                                @else
                                <p>no image</p>
                                @endif
                                
                            </td>
                            <td>
                                <a href="{{route('admin.delete_productimages',$img->id)}}"><span class="badge bg-danger">Delete</span></a>
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
@endsection