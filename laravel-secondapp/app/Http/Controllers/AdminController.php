<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    //Show Admin Dashborad
    public function index(){
        return view('admin.index');
    }
}
