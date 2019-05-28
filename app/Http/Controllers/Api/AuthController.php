<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use App\User;
use Auth;

class AuthController extends Controller
{
    /** 
     * login api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function login(){ 
        if(Auth::attempt(['phone' => request('phone'), 'password' => request('password')])){ 
            $user = Auth::user(); 
            $token = $user->createToken('teller')-> accessToken; 
            
            return response()->json([
                'status'=>'success',
                'token'=> "Bearer"." ".$token,
                'user' => $user->load('payment_wallet')
            ]); 
        } 
        else{ 
            return response()->json(['error'=>'Unauthorised'], 401); 
        } 
    }


    /** 
     * Register api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function register(Request $request){ 
        $validator = Validator::make($request->all(), [ 
            'name' => 'required',              
            'phone' => 'required|unique:users',             
            'password' => 'required', 
        ]);

        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);            
        }

        $words = preg_split("/\s+/", ($request->get('name')));
        $acronym = "";
        foreach ($words as $w) {
            $acronym .= $w[0];
        }
        $six_digit_random_number = mt_rand(100000, 999999);
        $code = mt_rand(100000, 999999);


        $input = $request->all(); 
        $input['password'] = bcrypt($input['password']);
        $input['account_number'] = strtoupper($acronym) .$six_digit_random_number;
        $user = User::create($input); 
        
        $token = $user->createToken('teller')-> accessToken; 

        
       
        $number = $request->get('phone');
        $message ='Welcome to Agrobays, '.$request->get('name').' Your account number is:'.strtoupper($acronym) .$six_digit_random_number.'. Kindly Make Payment to Activate Your Account';
        
        try {
            $url = 'https://www.bulksmsnigeria.com/api/v1/sms/create?api_token=ryo6Zr3nYfbJvP0YJKplSiTcNt4ZKw2HgLZ18old9p3yXS5d1pQnht9c9190&from=Agrobays&to='.$number.'&body='.$message;
            $client = new \GuzzleHttp\Client();
            $response = $client->request('POST', $url);
            $response = $response->getBody()->getContents();
        } catch (Exception $e) {
            
        }       

        return response()->json(
            [
                'status'=>'success',
                'token'=> $token,
                'user'=> $user
            ]
        ); 
     }


    /** 
     * get user details api 
     * 
     * @return \Illuminate\Http\Response 
     */ 
    public function user(Request $request){
        $user = Auth::user();
        return response()->json(
            [
                'status' => 'success',
                'user'=>$user->load('payment_wallet')
            ]
        );
    } 

    public function fund($amount)
    {
        $id = Auth::user()->id;
        $data = User::where('id', $id)->increment('wallet',$amount);
        return response()->json(
            ['success' => $data, 'wallet' => Auth::user()->wallet]);
    }

     /**
     * Logout user (Revoke the token)
     *
     * @return [string] message
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

    protected function SendSMS($number, $ac_number, $name){
        $message ='Welcome to Agrobays, '.$name.' Your account number is '.$ac_number;
        $url = 'https://www.bulksmsnigeria.com/api/v1/sms/create?api_token=ryo6Zr3nYfbJvP0YJKplSiTcNt4ZKw2HgLZ18old9p3yXS5d1pQnht9c9190&from=Agrobays&to='.$number .'&body='.$message;

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $response = curl_exec ($ch);
            $err = curl_error($ch);  //if you need
            curl_close ($ch);
    }
}
