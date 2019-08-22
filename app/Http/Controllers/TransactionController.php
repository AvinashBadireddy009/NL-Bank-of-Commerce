<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use Redirect;
use Mail;
use Response;
use App\User;
use App\Transfer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class TransactionController extends Controller
{
    public function index()
    {
        return view('transaction');
    }
    
    public function validator(array $data)
    {
        return Validator::make($data, [
            'operation' => 'required|string',
            'amount' => 'required|string',
            'remarks' => 'required|string',
        ]);
    }
    
    public function transaction(Request $request)
    {       
        if($request->operation == 'withdraw'){
            $new_amount = Auth::user()->account_bal - $request->amount;
            $current_user = User::find(Auth::user()->id);
            $current_user->account_bal = $new_amount;
            $current_user->update();
            Session::flash('message', "Your withdraw process was sucessful.");
            return redirect('home');
        }
        else{
            $new_amount = Auth::user()->account_bal + $request->amount;
            $current_user = User::find(Auth::user()->id);
            $current_user->account_bal = $new_amount;
            $current_user->update();
            Session::flash('message', "Your Deposite process was sucessful.");
            return redirect('home');
        }
        
        
    }
}
