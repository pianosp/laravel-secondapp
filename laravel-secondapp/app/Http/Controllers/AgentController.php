<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AgentController extends Controller
{
    //Show Agent Dashborad
    public function agent_dashboard(){
        return view('agent.agent_dashboard');
    }
}
