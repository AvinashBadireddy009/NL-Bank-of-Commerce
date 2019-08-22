@extends('layouts.app')
@section('content')

 <form method="POST" action="{{ route('deposit') }}">
        @csrf
<div class="container">
<div class="col-md-12 card">
    <br/>
        @if (Session::has('message'))
        <div class="alert alert-info"><h4 class="text-center" style="font-family:tahoma;">{{ Session::get('message') }}</h4></div>
        @endif
        <br /><h2 class="text-center">Deposit check</h2>
<div class="row card-body">
    <div class="col-md-4">
        
            <div class="form-group ">
                <div class="col-md-12">
                    <label for="" class="col-form-label text-md-right">{{ __('From') }}</label>
                    <input id="" type="number" class="form-control" name="account" value={{ Auth::user()->account_number }}  disabled>
                </div>
            </div>
    </div>
     <div class="col-md-4">
        <div class="form-group ">
            <div class="col-md-12">
                <label for="check_number" class="col-form-label text-md-right">{{ __('Check number') }}</label>
                <input id="check_number" type="number" class="form-control" name="check_number" value="" required autofocus>
            </div>
        </div>
    </div>
     <div class="col-md-4">
        <div class="form-group ">
            <div class="col-md-12">
                <label for="ben_number" class="col-form-label text-md-right">{{ __('To') }}</label>
                <input id="ben_number" type="number" class="form-control" name="ben_number" value="" required autofocus>
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
                    {{ __('Deposit') }}
                </button>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        
    </div>
</div>  
</form>
 

</div>
</div>
@endsection