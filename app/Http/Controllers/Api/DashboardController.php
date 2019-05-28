<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Auth;
use App\Transaction;
use Carbon\Carbon;
use App\expenses;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::User();
        $total_customer_wallet = User::where('company_id', $user->company_id)->sum('wallet');

        $total_customer = User::where('company_id', $user->company_id)->count();
        $total_customer_active = user::where('company_id', $user->company_id)->where('wallet', '>', '0')->count();
        $total_customer_inactive = user::where('company_id', $user->company_id)->where('wallet','0')->count();

        $total_transaction = Transaction::where('company_id', $user->company_id)->sum('amount');
        $total_transaction_today = Transaction::where('company_id', $user->company_id)->whereDate('created_at', Carbon::today())->sum('amount');
        $total_transaction_week = Transaction::where('company_id', $user->company_id)->whereBetween('created_at', [Carbon::now()->startOfWeek(),Carbon::now()->endOfWeek()])->sum('amount');
        $total_transaction_month = Transaction::where('company_id', $user->company_id)->whereBetween('created_at', [Carbon::now()->startOfMonth(),Carbon::now()->endOfMonth(),])->sum('amount');


        $total_expenses = expenses::where('company_id', $user->company_id)->sum('amount');
        $total_expenses_today = expenses::where('company_id', $user->company_id)->whereDate('created_at', Carbon::today())->sum('amount');
        $total_expenses_week = expenses::where('company_id', $user->company_id)->whereBetween('created_at', [Carbon::now()->startOfWeek(),Carbon::now()->endOfWeek()])->sum('amount');
        $total_expenses_month = expenses::where('company_id', $user->company_id)->whereBetween('created_at', [Carbon::now()->startOfMonth(),Carbon::now()->endOfMonth(),])->sum('amount');
        
        return response()->json([
            'total_customer_wallet' => $total_customer_wallet,

            'total_customer' => $total_customer,
            'total_customer_active' => $total_customer_active,
            'total_customer_inactive' => $total_customer_inactive,
            
            'total_transaction' => $total_transaction,
            'total_transaction_today' => $total_transaction_today,
            'total_transaction_week' => $total_transaction_week,
            'total_transaction_month' => $total_transaction_month,

            'total_expenses' => $total_expenses,
            'total_expenses_today' => $total_expenses_today,
            'total_expenses_week' => $total_expenses_week,
            'total_expenses_month' => $total_expenses_month,
        ]);
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
