<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Transaction;
use App\PaymentWallet;
use App\User;
use Auth;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $data = Transaction::where('company_id',$user->company_id)
            ->with('user:id,name,phone,account_number,wallet','staff:id,name')
            ->orderBy('created_at', 'desc')
            ->get();
        return response()->json(
            [
            'status' => 'success' , 
            'data' => $data,
            ]
        );
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

            $user = User::where('account_number',$request->get('account_number'))->first();
            $amount = $request->get('amount');

            $transaction = new Transaction;
            $transaction->user_id = $user->id;    
            $transaction->company_id = $request->get('company_id');    
            $transaction->transaction_id = str_replace(".","",microtime(true)).rand(000,999);    
            $transaction->transaction_type = $request->get('transaction_type');    
            $transaction->balance_befor = $user->wallet;    
            $transaction->amount = $amount;  
            if($request->get('transaction_type') == 'credit'){
                $transaction->balance_after = ($user->wallet - $amount); 
            }else{
                $transaction->balance_after = ($user->wallet + $amount); 
            }               
            $transaction->teller_id = Auth::user()->id;    
            $transaction->description = $request->get('description');    
            $transaction->save();

            if($request->get('transaction_type') == 'credit'){
                User::where('account_number', $request->get('account_number'))->increment('wallet', $amount);
                PaymentWallet::where('user_id', Auth::user()->id)->decrement('wallet', $amount);
            }else{
                User::where('account_number', $request->get('account_number'))->decrement('wallet', $amount);
                PaymentWallet::where('user_id', Auth::user()->id)->increment('wallet', $amount);
            }

            $number = $user->phone;
            $message = $amount.' Has been credited to your account, Your Balance is: '.($user->wallet + $amount).' Enquiry Call:07051312021,07051312022';
            
            // try {
            //     $url = 'https://www.bulksmsnigeria.com/api/v1/sms/create?api_token=ryo6Zr3nYfbJvP0YJKplSiTcNt4ZKw2HgLZ18old9p3yXS5d1pQnht9c9190&from=Agrobays&to='.$number.'&body='.$message;
            //     $client = new \GuzzleHttp\Client();
            //     $response = $client->request('POST', $url);
            //     $response = $response->getBody()->getContents();
            // } catch (Exception $e) {                
            // }       

            $user = Auth::user();
        
            return response()->json(
                [
                'status' => 'success' , 
                'data' => $transaction,
                'user'=>$user->load('payment_wallet')
                ]
            );
    }


    public function debit(Request $request)
    {

            // $user = User::where('account_number',$request->get('account_number'))->first();
            // $amount = $request->get('amount');

            // $transaction = new Transaction;
            // $transaction->user_id = $user->id;    
            // $transaction->company_id = $request->get('company_id');    
            // $transaction->transaction_id = str_replace(".","",microtime(true)).rand(000,999);    
            // $transaction->transaction_type = $request->get('transaction_type');    
            // $transaction->balance_befor = $user->wallet;    
            // $transaction->amount = $amount;    
            // $transaction->balance_after = ($user->wallet + $amount);  
            // $transaction->teller_id = Auth::user()->id; 
            // $transaction->description = $request->get('description'); 
            // $transaction->save();

            // if($request->get('transaction_type') == 'credit'){
            //     User::where('account_number', $request->get('account_number'))->increment('wallet', $amount);
            //     PaymentWallet::where('user_id', Auth::user()->id)->decrement('wallet', $amount);
            // }elseif ($request->get('transaction_type') == 'debit') {
            //     User::where('account_number', $request->get('account_number'))->decrement('wallet', $amount);
            //     PaymentWallet::where('user_id', Auth::user()->id)->increment('wallet', $amount);
            // }
           
            // $number = $user->phone;
            // $message = $amount.' Has been credited to your account, Your Balance is: '.($user->wallet + $amount).' Enquiry Call:07051312021,07051312022';
            
            // try {
            //     $url = 'https://www.bulksmsnigeria.com/api/v1/sms/create?api_token=ryo6Zr3nYfbJvP0YJKplSiTcNt4ZKw2HgLZ18old9p3yXS5d1pQnht9c9190&from=Agrobays&to='.$number.'&body='.$message;
            //     $client = new \GuzzleHttp\Client();
            //     $response = $client->request('POST', $url);
            //     $response = $response->getBody()->getContents();
            // } catch (Exception $e) {
                
            // }       

            // $user = Auth::user();
        
            // return response()->json(
            //     [
            //     'status' => 'success' , 
            //     'data' => $transaction,
            //     'user'=>$user->load('payment_wallet')
            //     ]
            // );
            return $request->get('transaction_type');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = Auth::user();
        $data = Transaction::where('company_id',$id)->where('user_id', $user->id)->with('user:id,name,wallet')->get();
        return response()->json(
            [
            'status' => 'success' , 
            'data' => $data,
            ]
        );
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
