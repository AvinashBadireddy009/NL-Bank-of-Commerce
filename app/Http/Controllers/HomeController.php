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
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $all = Transfer::where('ben_number', '=', Auth::user()->account_number)->orWhere('user_id', '=', Auth::user()->id)->paginate(5);
        $all->withPath('custom/url');
        $credit = Transfer::where('ben_number', '=', Auth::user()->account_number)->get();
        $debit = Transfer::where('user_id', '=', Auth::user()->id)->get();
        return view('home',['credit' => $credit, 'all' => $all, 'debit' => $debit]);
    }

    public function transfer()
    {
        return view('transfer');
    }

    public function validator(array $data)
    {
        return Validator::make($data, [
            'ben_number' => 'required|string|max:45',
            'amount' => 'required|string',
            'remarks' => 'required|string',
        ]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function transferDb(Request $request)
    {
        $transfer = new Transfer();
        $transfer->ben_number = $request->input('ben_number');
        $transfer->amount = $request->input('amount');
        $transfer->remarks = $request->input('remarks');
        $transfer->otp = $request->input('otp');
        $transfer->user_id = Auth::user()->id;
        $transfer->otp_code = rand(1111,9999);
        

        $message = "Your transfer process was successful";
        $check = User::where('account_number', '=', $transfer->ben_number)->get();

        if($check->isEmpty()){
            Session::flash('message', "Sorry this account number does not corresspond with any user, please check it and try again.");
            return Redirect::back();   
        }
        if($transfer->amount > Auth::user()->account_bal ){
            Session::flash('message', "Sorry you do not have sufficient balance to make this transfer.");
            return Redirect::back(); 
        }
        if($transfer->ben_number == Auth::user()->account_number){
            Session::flash('message', "Sorry you can not transfer money to yourself.");
            return Redirect::back();
        }
        if($transfer->amount <= 0){
            Session::flash('message', "Please enter a valid amount to transfer.");
            return Redirect::back();
        }
        else {
            $data = array('name'=>"LN Bank", 'transfer' => $transfer);
   
            Mail::send(['html'=>'mail'], $data, function($message) {
               $message->to(Auth::user()->email, 'LN Bank')->subject
                  ('Confirm your OTP');
               $message->from('horluwatowbeey@gmail.com','LN Bank');
            });
            $transfer->save();
            return view('confirm-transfer',['transfer' => $transfer]);
         } 
    }
    
    public function otpConfirm(Request $request)
    {
        $transfer = Transfer::find($request->input('id'));
        if($request->input('otp') === $transfer->otp_code){
            $receiver = User::where('account_number', '=', $transfer->ben_number)->get();
            $sender = User::find(Auth::user()->id);
            $transfer->verified = 1;
            $newSenderBal = $sender->account_bal - $transfer->amount;
            $sender->account_bal = $newSenderBal;
            $newReceiverBal = $transfer->amount + $receiver[0]->account_bal;
            $receiver[0]->account_bal = $newReceiverBal;
            $sender->update();
            $receiver[0]->update();
            $transfer->update();
            Session::flash('message', "Your transfer process was sucessful.");
            return redirect('home');
        }
        else{
            Session::flash('message', "Sorry, The code you entered is incorrect.");
            return Redirect::back();   
        }
    }
}
