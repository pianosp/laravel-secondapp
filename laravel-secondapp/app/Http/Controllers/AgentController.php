<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AgentController extends Controller
{
    //Show Agent Dashborad
    public function index(){
        return view('agent.index');
    }
}
