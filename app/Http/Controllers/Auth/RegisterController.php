<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Company;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            // 'phone' => ['required', 'string', 'max:255'],
            // 'company_name' => ['required', 'string', 'max:255'],
            // 'company_prefix' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $company = Company::create([
            'name' => $data['company_name'],
            'prefix' => $data['company_prefix'],
        ]);

        // $words = preg_split("/\s+/", ($data['name']));
        // $acronym = "";
        // foreach ($words as $w) {
        //     $acronym .= $w[0];
        // }

        // $six_digit_random_number = mt_rand(100000, 999999);
        $account_number = $company->prefix.'100000';

        return User::create([
            'company_id' => $company->id,
            'name' => $data['name'],
            'phone' => $data['phone'],
            'account_number' => $account_number,
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
}