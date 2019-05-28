<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Auth;
use App\PaymentToken;
use App\PaymentWallet;

class PaymentTokenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $data = PaymentToken::where('company_id',$user->company_id)->with('user:id,name')->get();                      
        return $data;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
            $user = User::where('id', $request->get('user_id'))->first();
            
            if(!(PaymentWallet::where('user_id',$user->id)->first())){
                $wallet = new PaymentWallet;
                $wallet->user_id = $request->get('user_id');
                $wallet->wallet = '0';
                $wallet->save();
            }

            $wallet = PaymentWallet::where('user_id', $user->id)->first();

            $amount = $request->get('amount');

            $payment_token = new PaymentToken;
            $payment_token->user_id = $user->id;
            $payment_token->company_id = $request->get('company_id');    
            $payment_token->token_id = str_replace(".","",microtime(true)).rand(000,999);    
            $payment_token->token_type = $request->get('token_type');  
            $payment_token->balance_befor = $wallet->wallet;
            $payment_token->amount = $amount;    
            $payment_token->balance_after = ($wallet->wallet + $amount);
            $payment_token->staff_id = Auth::user()->id; 
            $payment_token->description = $request->get('description');
            $payment_token->save();

            PaymentWallet::where('user_id', $user->id)->increment('wallet', $amount);

            return response()->json(
                [
                'status' => 'success' , 
                'data' => $payment_token,
                ]
            );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
