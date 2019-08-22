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
use App\Deposit;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class DepositcheckController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        return view('deposit-check');
    }
    
    public function validator(array $data)
    {
        return Validator::make($data, [
            'ben_number' => 'required|string|max:45',
            'amount' => 'required|string',
            'remarks' => 'required|string',
        ]);
    }
    
    public function depositCheck(Request $request, Deposit $deposit){
        
        $ben_account = User::where('account_number', '=', $request->ben_number)->get();
        
        if($ben_account->isEmpty()){
            Session::flash('message', "Sorry beneficiary account number does not corresspond with any user, please check it and try again.");
            return Redirect::back();   
        }
        if($request->amount > Auth::user()->account_bal ){
            Session::flash('message', "Sorry you do not have sufficient balance to make this transfer.");
            return Redirect::back(); 
        }
        
        if($request->amount <= 0){
            Session::flash('message', "Please enter a valid amount to transfer.");
            return Redirect::back();
        }
        if($request->ben_number == Auth::user()->account_number){
            Session::flash('message', "Sorry you can not transfer money to yourself.");
            return Redirect::back();
        }
        $receiver = User::where('account_number', '=', $request->ben_number)->get();
        $sender = User::find(Auth::user()->id);
        
        $receiver[0]->account_bal = $receiver[0]->account_bal + $request->amount;
        $sender->account_bal = $sender->account_bal - $request->amount;
        $receiver[0]->update();
        $sender->update();
        
        $deposit->from_account = Auth::user()->account_number;
        $deposit->to_account = $request->ben_number;
        $deposit->amount = $request->amount;
        $deposit->check_number = $request->check_number;
        $deposit->message = $request->remarks;
        
        $deposit->save();
        
        Session::flash('message', "Your Deposit process was sucessful.");
        return redirect('home');
    }
}
