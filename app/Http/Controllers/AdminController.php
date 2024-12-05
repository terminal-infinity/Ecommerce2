<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function AdminDashboard(){

        return view('admin.pages.index');
    } // end method


    public function AdminLogout(Request $request){
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/admin/login');
    }   // end method

    public function AdminLogin(){
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.pages.admin_login');
    }   // end method

    public function AdminProfile(){

        $id = Auth::user()->id;
        $profileData = User::find($id);

        return view('admin.pages.admin_profile_view', compact('profileData'));
    }   // end method


    public function AdminProfileStore(Request $request){

        $id = Auth::user()->id;
        $data = User::find($id);

        $data->username = $request->username;
        $data->name = $request->name;
        $data->email = $request->email;
        $data->phone = $request->phone;
        $data->address = $request->address;

        if($request->file('photo')){
            $file = $request->file('photo');
            @unlink(public_path('upload/admin_images/'.$data->photo));
            $filename = date('YmdHi').$file->getClientOriginalName();
            $file->move(public_path('upload/admin_images'), $filename);
            $data['photo'] = $filename;
        }

        $data->save();

        $notification = array(
            'message' => 'Admin Profile Updated Successfully',
            'alert-type' => 'success'
        );
        
        return redirect()->back()->with($notification);

    }   // end method

    public function AdminChangePassword(){

        $id = Auth::user()->id;
        $profileData = User::find($id);

        return view('admin.pages.admin_change_password',compact('profileData'));
    }   // end method

    public function AdminUpdatePassword(Request $request){

        // Validation
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed'
        ]);

        // Match the old password
        if(!Hash::check($request->old_password, auth::user()->password)){

            $notification = array(
                'message' => 'Old Password Does not Match!',
                'alert-type' => 'error'
            );

            return back()->with($notification);
        }

        // Update the new password
        User::whereId(auth()->user()->id)->update([
            'password' => Hash::make($request->new_password)
        ]);

        $notification = array(
            'message' => 'Password Change Successfully',
            'alert-type' => 'success'
        );

        return back()->with($notification);

    }   // end method


    public function AdminList(){
        $user = User::where('role','=' , 1)->get();
        return view('admin.partials.admin.admin_list',compact('user'));
    } // end method

    public function AdminAdd(){
        return view('admin.partials.admin.admin_add');
    } // end method

    public function AdminUpload(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
        ]);
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->status = $request->status;
        $user->role = 1;

        $user->save();

        return redirect()->route('admin.admin_list')->with('success','New Admin Added Successfully');
    } // end method

    public function AdminEdit($id){
        $user = User::findOrfail($id);
        return view('admin.partials.admin.admin_edit',compact('user'));
    } // end method

    public function AdminUpdate(Request $request,$id){
        $request->validate([
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|email|unique:users,email,'.$id,
        ]);
        $user = User::findOrfail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        if(!empty($request->password)){
            $user->password = Hash::make($request->password);
        }
        $user->status = $request->status;
        $user->role = 1;

        $user->save();

        return redirect()->route('admin.admin_list')->with('success','Admin Updated Successfully');
    } // end method

    public function AdminDelete($id){
        $user=User::findOrFail($id);

        $user->delete();

        return redirect()-> back()->with('error','Admin Delete Successfully');
    }

}
