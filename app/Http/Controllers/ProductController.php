<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /* Str::slug(trim($request->name),"-"); */

    //product
    public function view_product(){
        $product=Product::select('products.*','users.name as created_by_name', 'categories.name as category_name','brands.name as brand_name')
                                ->join('categories', 'categories.id', '=', 'products.category_id')
                                ->join('brands', 'brands.id', '=', 'products.brand_id')
                                ->join('users','users.id','=','products.created_by')
                                ->orderBy('products.id','DESC')
                                ->get();
        return view('admin.partials.product.view_product',compact('product'));
    }

    public function add_product(){
        $categories=Category::where('status','1')->get();
        $brands=Brand::all();
        $colours=Color::all();
        return view('admin.partials.product.add_product',compact('categories','brands','colours'));
    }

    public function upload_product(Request $request){
        $request->validate([
            'title' => 'required|string',
            'slug' => 'required|string|unique:products,slug,',
            'short_desc' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'status' => 'required|boolean',
            'category' => 'required|exists:categories,id',
            'sub_category' => 'nullable|exists:subcategories,id',
            'brand' => 'required|exists:brands,id',
            'material' => 'required|string',
            'meta_title' => 'required|string',
            'meta_key' => 'nullable|string',
            'meta_desc' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);
        $data=new Product();
        $data->title = $request->title;
        $data->slug = Str::slug(trim($request->title),"-");;
        $data->short_desc = $request->short_desc;
        $data->description = $request->description;
        $data->add_info = $request->add_info;
        $data->price = $request->price;
        $data->compare_price = $request->compare_price;
        $data->stock = $request->stock;
        $data->status = $request->status;
        $data->category_id = $request->category;
        $data->subcategory_id = $request->sub_category;
        $data->color = implode(', ', $request->color);
        $data->size = implode(', ', $request->size);
        $data->brand_id = $request->brand;
        $data->material = $request->material;
        $data->featured = $request->featured;
        $data->hot = $request->hot;
        $data->sale = $request->sale;
        $data->meta_title = $request->meta_title;
        $data->meta_key = $request->meta_key;
        $data->meta_desc = $request->meta_desc;
        $data->created_by = Auth::user()->id;

        if($request->file('image')){
            $takeimage =$request->file('image');
            // create image manager with desired driver
            $manager = new ImageManager(new Driver());
            $name_gen = hexdec(uniqid()).'.'.$takeimage->getClientOriginalExtension();
            $img = $manager->read($takeimage);
            $img->resize(500,600);
            $img->toJpeg(80)->save(public_path('upload/product/'.$name_gen));

            $data->image = $name_gen;
        }
        
        $data->save();

        return redirect()->route('admin.view_product')->with('message', 'Product Added Successfully');

    }
    public function getSubcategories($category_id){
    $subcategories = Subcategory::where('category_id', $category_id)->get(['id', 'name']);
    return response()->json($subcategories);
    }

    public function edit_product($id){
        $product=Product::findOrfail($id);
        $selectedCategory = Category::find($product->category_id);
        $selectedSubcategory = Subcategory::find($product->subcategory_id);
        $selectedBrand = Brand::find($product->brand_id);
        $categories=Category::where('status','1')->get();
        $brands=Brand::all();
        $colours=Color::all();
        $selectedColors = explode(', ', $product->color);
        $selectedSize = explode(', ', $product->size);
        return view('admin.partials.product.edit_product',compact('categories','brands','colours','product','selectedCategory','selectedSubcategory','selectedBrand','selectedColors','selectedSize'));
    }

    public function update_product(Request $request, $id){
        $request->validate([
            'title' => 'required|string',
            'slug' => 'required|string|unique:products,slug,'.$id,
            'short_desc' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'status' => 'required|boolean',
            'category' => 'required|exists:categories,id',
            'sub_category' => 'nullable|exists:subcategories,id',
            'brand' => 'required|exists:brands,id',
            'material' => 'required|string',
            'meta_title' => 'required|string',
            'meta_key' => 'nullable|string',
            'meta_desc' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp',
        ]);
        $data=Product::findOrfail($id);
        $data->title = $request->title;
        $data->slug = Str::slug(trim($request->title),"-");;
        $data->short_desc = $request->short_desc;
        $data->description = $request->description;
        $data->add_info = $request->add_info;
        $data->price = $request->price;
        $data->compare_price = $request->compare_price;
        $data->stock = $request->stock;
        $data->status = $request->status;
        $data->category_id = $request->category;
        $data->subcategory_id = $request->sub_category;
        $data->color = implode(', ', $request->color);
        $data->size = implode(', ', $request->size);
        $data->brand_id = $request->brand;
        $data->material = $request->material;
        $data->featured = $request->featured;
        $data->hot = $request->hot;
        $data->sale = $request->sale;
        $data->meta_title = $request->meta_title;
        $data->meta_key = $request->meta_key;
        $data->meta_desc = $request->meta_desc;
        $data->created_by = Auth::user()->id;

        if($request->file('image')){
            $takeimage =$request->file('image');
            // create image manager with desired driver
            $manager = new ImageManager(new Driver());
            $name_gen = hexdec(uniqid()).'.'.$takeimage->getClientOriginalExtension();
            $img = $manager->read($takeimage);
            $img->resize(500,600);
            $img->toJpeg(80)->save(public_path('upload/product/'.$name_gen));

            $data->image = $name_gen;
        }
        
        $data->save();

        return redirect()->route('admin.view_product')->with('message', 'Product Updated Successfully');

    }

    public function delete_product($id){
        $data=Product::findOrFail($id);

        
        $image_path=public_path('upload/product/'.$data->image);
        if(file_exists($image_path)){
            unlink($image_path);
        }

        $data->delete();

        return redirect()-> back()->with('message', 'Product Delete Successfully');
    }


    public function productimages(int $productId){
        $product=Product::findOrfail($productId);
        $images = ProductImage::where('product_id',$productId)->get();
        return view('admin.partials.product.productimages',compact('product','images'));
    }

    public function upload_productimages(Request $request, $productId){
        $validator = Validator::make($request->all(),[
            'image.*' => 'required|image|mimes:jpg,jpeg,png,webp',
        ]);
        
        $product = Product::findOrfail($productId);
        $imageData = [];
        if($files = $request->file('image')){
            foreach($files as $file){
            $manager = new ImageManager(new Driver());
            $name_gen = hexdec(uniqid()).'.'.$file->getClientOriginalExtension();
            $img = $manager->read($file);
            $img->resize(500,600);
            $img->toJpeg(80)->save(public_path('upload/product/'.$name_gen));

            $save_url = $name_gen;
            $imageData[] = [
                'image' => $save_url,
                'product_id' => $product->id,
            ];
            }
        }
        ProductImage::insert($imageData);

        return redirect()->back()->with('message', 'Images Added Successfully');

    }

    public function delete_productimages($id){
        $data=ProductImage::findOrFail($id);

        
        $image_path=public_path('upload/product/'.$data->image);
        if(file_exists($image_path)){
            unlink($image_path);
        }

        $data->delete();

        $notification = array(
            'message' => 'Product Deleted Successfully',
            'alert-type' => 'warning'
        );

        return redirect()-> back()->with($notification);
    }
}
