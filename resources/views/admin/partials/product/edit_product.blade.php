@extends('admin.admin_dashboard')

@section('content')
<style>
    label{
        font-weight: 500;
        margin-bottom: 5px;
    }
</style>
<div class="page-content">
    <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
            <div>
                <h4 class="mb-3 mb-md-0">Update Product</h4>
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
            <a href="{{route('admin.view_product')}}">
            <button button type="button" class="btn btn-primary btn-icon-text mb-2 mb-md-0">
                Back
            </button>
            </a>
        </div>
    </div>
    <div class="container-fluid">
        <form action="{{route('admin.update_product', $product->id)}}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-3">
                    <div class="card-body">								
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="title">Title <span style="color: red;">*</span></label>
                                    <input type="text" name="title" id="title" class="form-control" placeholder="Title" value="{{ old('title',$product->title) }}">	
                                    <span style="color: red;">{{ $errors->first('title') }}</span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="slug">Slug <span style="color: red;">*</span></label>
                                    <input type="text" name="slug" id="slug" class="form-control" placeholder="Slug Ex.URL" value="{{ old('slug',$product->slug) }}">	
                                    <span style="color: red;">{{ $errors->first('slug') }}</span>
                                </div>
                            </div> 
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="short_desc">Short Description <span style="color: red;">*</span></label>
                                    <textarea name="short_desc" id="short_desc" cols="30" rows="10" class="summernote" placeholder="short_desc" value="{{ old('short_desc',$product->short_desc) }}">{{ old('short_desc',$product->short_desc) }}</textarea>
                                    <span style="color: red;">{{ $errors->first('short_desc') }}</span>
                                </div>
                            </div> 
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="slug">Status <span style="color: red;">*</span></label>
                                    <select name="status" id="status" class="form-control">
                                        <option {{ (old('status',$product->status ) == 1) ? 'selected' : '' }} value="1">Active</option>
                                        <option {{ (old('status',$product->status ) == 0) ? 'selected' : '' }} value="0">Block</option>
                                    </select>	
                                    <span style="color: red;">{{ $errors->first('status') }}</span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="price">Price <span style="color: red;">*</span></label>
                                    <input type="text" name="price" id="price" class="form-control" placeholder="Price" value="{{ old('price',$product->price) }}">
                                    <span style="color: red;">{{ $errors->first('price') }}</span>	
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="compare_price">New Price</label>
                                    <input type="text" name="compare_price" id="compare_price" class="form-control" placeholder="Compare Price" value="{{ old('compare_price',$product->compare_price) }}">	
                                    <span style="color: red;">{{ $errors->first('compare_price') }}</span>
                                </div>
                            </div> 
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="slug">Stock <span style="color: red;">*</span></label>
                                    <input type="text" name="stock" id="stock" class="form-control" placeholder="stock" value="{{ old('stock',$product->stock) }}">	
                                    <span style="color: red;">{{ $errors->first('stock') }}</span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="slug">Metarial <span style="color: red;">*</span></label>
                                    <input type="text" name="material" id="material" class="form-control" placeholder="material" value="{{ old('material',$product->material) }}">	
                                    <span style="color: red;">{{ $errors->first('material') }}</span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="image">Image <span style="color: red;">*</span></label>
                                    <input type="file" name="image" id="image" class="form-control" value="{{ old('image') }}">	
                                    <span style="color: red;">{{ $errors->first('image') }}</span>
                                    @if($product)
                                    <img id="new_image" src="{{ asset('/upload/product/'.$product->image) }}" style="width: 200px; margin:5px;" >
                                    @endif 
                                </div>
                            </div>                                       
                        </div>
                    </div>	                                                                      
                </div>
                <div class="card">
                    <div class="card-body">	
                        <h2 class="h4  mb-3">Product Details</h2>
                        <div class="mb-3">
                            <label for="category">Category <span style="color: red;">*</span></label>
                            <select name="category" id="category" class="form-control">
                                <option value="{{ $selectedCategory->id }}">{{ $selectedCategory->name }}</option>
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            <span style="color: red;">{{ $errors->first('category') }}</span>
                        </div>
                        <div class="mb-3">
                            <label for="sub_category">Subcategory <span style="color: red;">*</span></label>
                            <select name="sub_category" id="sub_category" class="form-control">
                            @if($selectedSubcategory)
                                <option value="{{ $selectedSubcategory->id }}">{{ $selectedSubcategory->name }}</option>
                            @else
                                <option value="">Select a Subcategory</option>
                            @endif

                            </select>
                            <span style="color: red;">{{ $errors->first('sub_category') }}</span>
                        </div>
                        <div class="mb-3">
                        <label >Product Colours</label>
                            <div class="mb-3">
                                @foreach ($colours as $colour)
                                @if($colour != '')
                                <label style="font-weight: normal;" for="colour">
                                    <input type="checkbox" name="color[]" value="{{ $colour->name }}" class="me-2" @if(in_array($colour->name, $selectedColors)) checked @endif>{{ $colour->name }} <br>
                                </label>
                                @endif
                                @endforeach
                                <span style="color: red;">{{ $errors->first('colour') }}</span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="category">Brand <span style="color: red;">*</span></label>
                            <select name="brand" id="brand" class="form-control">
                            <option value="{{ $selectedBrand->id }}">{{ $selectedBrand->name }}</option>
                                @foreach($brands as $brand)
                                <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                @endforeach
                            </select>
                            <span style="color: red;">{{ $errors->first('brand') }}</span>
                        </div>
                        
                        <div class="mb-3">
                            <label >Product Size</label>
                                <div class="mb-3">
                                <label style="font-weight: normal;" for="size">
                                    <input type="checkbox" name="size[]" value="Extra-Small" class="me-2" @if(in_array('Extra-Small', $selectedSize)) checked @endif> Extra-Small <br>
                                    <input type="checkbox" name="size[]" value="Small" class="me-2" @if(in_array('Small', $selectedSize)) checked @endif> Small <br>
                                    <input type="checkbox" name="size[]" value="Medium" class="me-2" @if(in_array('Medium', $selectedSize)) checked @endif> Medium <br>
                                    <input type="checkbox" name="size[]" value="Large" class="me-2" @if(in_array('Large', $selectedSize)) checked @endif> Large <br>
                                    <input type="checkbox" name="size[]" value="Extra-Large" class="me-2" @if(in_array('Extra-Large', $selectedSize)) checked @endif> Extra-Large
                                </label>

                                </div>
                            <span style="color: red;">{{ $errors->first('size') }}</span>
                        </div>
                    </div>
                </div>   
                <div class="card">
                    <div class="card-body">	
                        <h2 class="h4  mb-3">Product Section</h2>
                        <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="slug">Featured product</label>
                                    <select name="featured" id="featured" class="form-control">
                                        <option value="">Select Option</option>
                                        <option {{ (old('featured',$product->featured ) == 1) ? 'selected' : '' }} value="1">Yes</option>
                                        <option {{ (old('featured',$product->featured ) == 0) ? 'selected' : '' }} value="0">No</option>
                                    </select>	
                                    <span style="color: red;">{{ $errors->first('featured') }}</span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="slug">Hot product</label>
                                    <select name="hot" id="hot" class="form-control">
                                    <option value="">Select Option</option>
                                        <option {{ (old('hot',$product->hot ) == 1) ? 'selected' : '' }} value="1">Yes</option>
                                        <option {{ (old('hot',$product->hot ) == 0) ? 'selected' : '' }} value="0">No</option>
                                    </select>	
                                    <span style="color: red;">{{ $errors->first('hot') }}</span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="slug">Sale product</label>
                                    <select name="sale" id="sale" class="form-control">
                                    <option value="">Select Option</option>
                                        <option {{ (old('sale',$product->sale ) == 1) ? 'selected' : '' }} value="1">Yes</option>
                                        <option {{ (old('sale',$product->sale ) == 0) ? 'selected' : '' }} value="0">No</option>
                                    </select>
                                    <span style="color: red;">{{ $errors->first('sale') }}</span>	
                                </div>
                            </div>
                    </div>
                </div>
                <div class="card mb-3">
                    <div class="card-body">								
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="description">Description <span style="color: red;">*</span></label>
                                    <textarea name="description" id="description" cols="30" rows="10" class="summernote" placeholder="Description" value="{{ old('description',$product->description) }}">{{ old('description',$product->description) }}</textarea>
                                    <span style="color: red;">{{ $errors->first('description') }}</span>
                                </div>
                            </div> 
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="add_info">Additional Information</label>
                                    <textarea name="add_info" id="add_info" cols="30" rows="10" class="summernote" placeholder="Additional Information" value="{{ old('add_info',$product->add_info) }}">{{ old('add_info',$product->add_info) }}</textarea>
                                    <span style="color: red;">{{ $errors->first('add_info') }}</span>
                                </div>
                            </div>                                            
                        </div>
                    </div>	                                                                      
                </div>
                <div class="card">
                <div class="card-body">	
                <div class="col-sm-6 mb-4">
                    <h4>For SCO</h4>
                </div>							
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label>Meta Title <span style="color: red;">*</span></label>
                            <input type="text" name="meta_title" id="meta_title" class="form-control" placeholder="Meta Title" value="{{ old('meta_title',$product->meta_title) }}">	
                            <span style="color: red;">{{ $errors->first('meta_title') }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="slug">Meta Keyword</label>
                            <input type="text" name="meta_key" id="meta_key" class="form-control" placeholder="Meta Keyword" value="{{ old('meta_key',$product->meta_key) }}">	
                            <span style="color: red;">{{ $errors->first('meta_key') }}</span>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label for="slug">Meta Description</label>
                            <textarea name="meta_desc" id="meta_desc" cols="30" rows="10" class="summernote" placeholder="Meta Description" value="{{ old('meta_desc',$product->meta_desc) }}">{{ old('meta_desc',$product->meta_desc) }}</textarea>
                            <span style="color: red;">{{ $errors->first('meta_desc') }}</span>
                        </div>
                    </div>									
                </div>
            </div>
                </div>
            </div>

        </div>

        <div class="pb-5 pt-3">
            <button class="btn btn-primary">Create</button>
        </div>
        </form>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $('#category').on('change', function() {
            var categoryId = $(this).val();
            if (categoryId) {
                $.ajax({
                    url: '/get-subcategories/' + categoryId,
                    type: 'GET',
                    success: function(data) {
                        $('#sub_category').empty().append('<option value="">Select Subcategory</option>');
                        $.each(data, function(key, value) {
                            $('#sub_category').append('<option value="' + value.id + '">' + value.name + '</option>');
                        });
                    },
                    error: function() {
                        alert('Error loading subcategories.');
                    }
                });
            } else {
                $('#sub_category').empty().append('<option value="">Select Subcategory</option>');
            }
        });
    });
</script>
@endsection