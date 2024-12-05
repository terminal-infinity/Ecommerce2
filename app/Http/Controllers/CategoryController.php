<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Color;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
        //Category
        public function view_category(){
            $category=Category::select('categories.*','users.name as created_by_name')
                                ->join('users','users.id','=','categories.created_by')
                                ->orderBy('categories.id','DESC')
                                ->get();
            return view('admin.partials.product.category.view_category',compact('category'));
        }

        public function add_category(){
            return view('admin.partials.product.category.add_category');
        }
    
        public function upload_category(Request $request){
            $request->validate([
                'name' => 'required|string|max:255',
                'slug' => 'required|string|max:255|unique:categories,slug',
                'status' => 'required',
                'meta_title' => 'required|string|max:255',
                'meta_keyword' => 'nullable|string|max:255',
                'meta_description' => 'nullable|string|max:500',
                'image' => 'required|image|mimes:jpg,jpeg,png,webp',
            ]);
    
            $data=new Category();
            $data->name = $request->name;
            $data->slug = Str::slug($request->slug);
            $data->status = $request->status;
            $data->meta_title = $request->meta_title;
            $data->meta_keyword = $request->meta_keyword;
            $data->meta_description = $request->meta_description;
            $data->created_by = Auth::user()->id;
    
            if($request->file('image')){
                $takeimage =$request->file('image');
                // create image manager with desired driver
                $manager = new ImageManager(new Driver());
                $name_gen = hexdec(uniqid()).'.'.$takeimage->getClientOriginalExtension();
                $img = $manager->read($takeimage);
                $img->resize(1886, 3279);
                $img->toJpeg(80)->save(public_path('upload/categoryimage/'.$name_gen));
    
                $data->image = $name_gen;
            }
            
            $data->save();
    
            return redirect()->route('admin.view_category')->with('message', 'Category Added Successfully');
    
        }
    
        public function edit_category($id){
            $category=Category::findOrfail($id);
            return view('admin.partials.product.category.edit_category',compact('category'));
        }
    
        public function update_category(Request $request,$id){
            $request->validate([
                'name' => 'required|string|max:255',
                'slug' => 'required|string|max:255|unique:categories,slug,'.$id,
                'status' => 'required',
                'meta_title' => 'required|string|max:255',
                'meta_keyword' => 'nullable|string|max:255',
                'meta_description' => 'nullable|string|max:500',
                'image' => 'image|mimes:jpg,jpeg,png,webp',
            ]);
    
            $data=Category::findOrfail($id);
            $data->name = $request->name;
            $data->slug = Str::slug($request->slug);
            $data->status = $request->status;
            $data->meta_title = $request->meta_title;
            $data->meta_keyword = $request->meta_keyword;
            $data->meta_description = $request->meta_description;
            $data->created_by = Auth::user()->id;
    
            if($request->file('image')){
                $takeimage =$request->file('image');
                // create image manager with desired driver
                $manager = new ImageManager(new Driver());
                $name_gen = hexdec(uniqid()).'.'.$takeimage->getClientOriginalExtension();
                $img = $manager->read($takeimage);
                $img->resize(1886, 3279);
                $img->toJpeg(80)->save(public_path('upload/categoryimage/'.$name_gen));
    
                $data->image = $name_gen;
            }
            
            $data->save();
    
            return redirect()->route('admin.view_category')->with('message', 'Category Update Successfully');
    
        }
    
        public function delete_category($id){
            $data=Category::findOrFail($id);
    
            
            $image_path=public_path('upload/categoryimage/'.$data->image);
            if(file_exists($image_path)){
                unlink($image_path);
            }
    
            $data->delete();
    
            $notification = array(
                'message' => 'Category Deleted Successfully',
                'alert-type' => 'warning'
            );
    
            return redirect()-> back()->with($notification);
        }
    
    
    
        //SubCategory
        public function view_subcategory(){
            $subcategory = Subcategory::select('subcategories.*', 'users.name as created_by_name', 'categories.name as category_name')
                ->join('categories', 'categories.id', '=', 'subcategories.category_id')
                ->join('users', 'users.id', '=', 'subcategories.created_by')
                ->orderBy('subcategories.id', 'DESC')
                ->get();

            return view('admin.partials.product.subcategory.view_subcategory',compact('subcategory'));
        }

        public function add_subcategory(){
            $categories=Category::where('status','1')->get();
            return view('admin.partials.product.subcategory.add_subcategory',compact('categories'));
        }

        public function upload_subcategory(Request $request){
            $request->validate([
                'name' => 'required|string|max:255',
                'slug' => 'required|string|max:255',
                'category_id' => 'required|exists:categories,id',
            ]);
        
            $data = new Subcategory();
            $data->name = $request->name;
            $data->slug = Str::slug($request->slug);
            $data->created_by = Auth::user()->id;
            $data->category_id = $request->category_id;
            
            $data->save();
    
            return redirect()->route('admin.view_subcategory')->with('message', 'Subcategory Added Successfully');
    
        }

        public function edit_subcategory($id){
            $subcategories=Subcategory::findOrfail($id);
            $selectedCategory = Category::find($subcategories->category_id);
            $categories=Category::where('status','1')->get();
            return view('admin.partials.product.subcategory.edit_subcategory',compact('categories','subcategories','selectedCategory'));
        }

        public function update_subcategory(Request $request,$id){
            $request->validate([
                'name' => 'required|string|max:255',
                'slug' => 'required|string|max:255',
                'category_id' => 'required|exists:categories,id',
            ]);
        
            $data = Subcategory::findOrfail($id);
            $data->name = $request->name;
            $data->slug = Str::slug($request->slug);
            $data->created_by = Auth::user()->id;
            $data->category_id = $request->category_id;
            
            $data->save();
    
            return redirect()->route('admin.view_subcategory')->with('message', 'Subcategory Updated Successfully');
    
        }

        public function delete_subcategory($id){
            $data=Subcategory::findOrFail($id);
    
            $data->delete();
    
            return redirect()-> back()->with('message', 'Subcategory Deleted Successfully');
        }


        //Brand
        public function view_brand(){
            $brand = Brand::select('brands.*', 'users.name as created_by_name')
                ->join('users', 'users.id', '=', 'brands.created_by')
                ->orderBy('brands.id', 'DESC')
                ->get();

            return view('admin.partials.product.brand.view_brand',compact('brand'));
        }

        public function upload_brand(Request $request){
            $request->validate([
                'name' => 'required|string|max:255',
                'slug' => 'required|string|max:255|unique:brands,slug',
            ]);
        
            $data = new Brand();
            $data->name = $request->name;
            $data->slug = Str::slug($request->slug);
            $data->created_by = Auth::user()->id;
            
            $data->save();
    
            return redirect()->route('admin.view_brand')->with('message', 'Brand Added Successfully');
    
        }

        public function edit_brand($id){
            $brand=Brand::findOrfail($id);
            return view('admin.partials.product.brand.edit_brand',compact('brand'));
        }

        public function update_brand(Request $request,$id){
            $request->validate([
                'name' => 'required|string|max:255',
                'slug' => 'required|string|max:255|unique:brands,slug,'.$id,
            ]);
        
            $data = Brand::findOrfail($id);
            $data->name = $request->name;
            $data->slug = Str::slug($request->slug);
            $data->created_by = Auth::user()->id;
            
            $data->save();
    
            return redirect()->route('admin.view_brand')->with('message', 'Brand Updated Successfully');
    
        }

        public function delete_brand($id){
            $data=Brand::findOrFail($id);
    
            $data->delete();
    
            return redirect()-> back()->with('message', 'Brand Deleted Successfully');
        }


        //Colour
    public function view_colour(){
        $colour=Color::select('colors.*', 'users.name as created_by_name')
        ->join('users', 'users.id', '=', 'colors.created_by')
        ->orderBy('colors.id', 'DESC')
        ->get();
        return view('admin.partials.product.colour.view_colour',compact('colour'));
    }

    public function upload_colour(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|size:7|regex:/^#[0-9A-Fa-f]{6}$/', 
        ]);
        $data=new Color();
        $data->name = $request->name;
        $data->code = $request->code;
        $data->created_by = Auth::user()->id;
        
        $data->save();

        return redirect()->route('admin.view_colour')->with('message', 'Color Added Successfully');

    }

    public function delete_colour($id){
        $data=Color::findOrFail($id);

        $data->delete();

        return redirect()-> back()->with('message', 'Color Delete Successfully');
    }
}
