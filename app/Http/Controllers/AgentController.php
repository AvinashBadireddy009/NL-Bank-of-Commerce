<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Agent;
use Session;
use Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AgentController extends Controller
{
    public function index()
    {
       return view('agent-login'); 
    }
    
    public function validator(array $data)
    {
        return Validator::make($data, [
            'email' => 'required|string',
            'password' => 'required|string',
        ]);
    }
    
    public function login(Request $request)
    {
        $agent = Agent::where('email', '=', $request->email)->get();
        
        if($agent[0]->email != ''){
            return redirect()->route('transaction.form');
        }
        else{
            Session::flash('message', "Account not found");
            return Redirect::back();
        }
    }
}
