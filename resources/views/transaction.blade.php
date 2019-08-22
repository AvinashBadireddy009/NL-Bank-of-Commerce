@extends('layouts.app')
@section('content')
<form method="POST" action="{{ route('transaction') }}">
            @csrf
    <div class="container">
    <div class="col-md-12 card">
        <br/>
            @if (Session::has('message'))
            <div class="alert alert-info"><h4 class="text-center" style="font-family:tahoma;">{{ Session::get('message') }}</h4></div>
            @endif
            <br /><h2 class="text-center">Withdraw/Deposite</h2>
    <div class="row card-body">
        <div class="col-md-6">

                <div class="form-group ">
                    <div class="col-md-12">
                        <label for="" class="col-form-label text-md-right">{{ __('From') }}</label>
                        <input id="" type="number" class="form-control" name="account" value="{{ Auth::user()->account_number }}"  disabled>
                    </div>
                </div>
        </div>
        <div class="col-md-6">
            <div class="form-group ">
                <div class="col-md-12">
                  <label for="" class="col-form-label text-md-right">Deposite/withdraw</label>
                  <select name="operation" class="custom-select">
                    <option selected>Select</option>
                    <option value="deposite">Deposite</option>
                    <option value="withdraw">Withdraw</option>
                  </select>
                </div>
            </div>
        </div>
    </div>



    <div class="row card-body">
            <div class="col-md-6">
                <div class="form-group ">
                        <div class="col-md-12">
                            <label for="amount" class="col-form-label text-md-right">{{ __('Amount($)') }}</label>
                            <input id="name" type="number" class="form-control" name="amount" value="" required >
                        </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group ">
                    <div class="col-md-12">
                        <label for="remarks" class="col-form-label text-md-right">{{ __('Message') }}</label>
                        <input id="name" type="text" class="form-control" name="remarks" value="" required >
                    </div>
                </div>
            </div>
    </div>
    <div class="row card-body">
        <div class="col-md-6">
            <div class="form-group">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Submit') }}
                    </button>
                </div>
            </div>
        </div>
        <div class="col-md-6">

        </div>
    </div>  
</form>
@stop