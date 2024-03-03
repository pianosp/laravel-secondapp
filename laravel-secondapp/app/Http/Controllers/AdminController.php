<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    //Show Admin Dashborad
    public function admin_dashboard(){
        return view('admin.index');
    }

    //Logout Admin
    public function admin_logout(Request $request){
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/admin/login');
    }

    //Show Login Form
    public function admin_login(){
        return view('admin.admin_login');
    }

    //Show Profile Page
    public function admin_profile(){
        $profileData = User::find(Auth::user()->id);
        return view('admin.admin_profile_view', compact('profileData'));
    }

    //Update Profile
    public function admin_profile_store(Request $request){
        $profileData = User::find(Auth::user()->id);
        $formFields = $request->validate([
            'username' => 'required',
            'name'=> 'required',
            'email'=> ['required','email'],
            'phone'=> 'required|digits:10',
            'address'=> 'required'
        ]);
        if($request->hasFile('photo')){
            $file = $request->file('photo');
            @unlink(public_path('upload/admin_images/'.$profileData->photo));
            $filename = date('YmdHi').$file->getClientOriginalName();
            //getCilentOriginalName เอาแค่ extension ของไฟล์ ตัวอย่าง '24232profile.png'
            $file->move(public_path('upload/admin_images'), $filename);
            $formFields['photo'] = $filename;
        }

        $profileData->update($formFields);
        $notification = array(
            'message' => 'Admin Profile Updated Successfully!',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    //Show Change Password Page
    public function admin_change_password(){
        $profileData = User::find(Auth::user()->id);
        return view('admin.admin_change_password', compact('profileData'));
    }

    //Update Admin Password Page
    public function admin_update_password(Request $request){
        $request->validate([
            'old_password' => 'required',
            'new_password'=> 'required|confirmed',
        ]);

        if(!Hash::check($request->old_password, auth()->user()->password)){
            $notification = array(
                'message' => "Old Password Doesn't Match!",
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
        User::whereId(auth()->user()->id)->update(['password' => Hash::make($request->new_password)]);
        $notification = array(
            'message' => "Password Change Successfully!",
            'alert-type' => 'success'
        );
        return back()->with($notification);
    }

}
