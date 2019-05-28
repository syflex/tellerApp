<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\PaymentCycle;
use App\PaymentCycleData;
use Auth;
use Carbon\Carbon;

class PaymentCycleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user =  Auth::user();
        $cycle = PaymentCycle::where('user_id',$user->id)->where('status','0')->with('cycle_data')->get();
        return response()->json(
            [
                'status'=>'success',
                'data'=> $cycle
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
        $user =  Auth::user();
        $date = Carbon::now();

        $cycle = new PaymentCycle;
        $cycle->user_id = $user->id;
        $cycle->company_id = $user->company_id;
        $cycle->amount = $request->amount;
        $cycle->save();

        $day = 1;
       
        while ( $day <= 30) {
            $data = new PaymentCycleData;
            $data->company_id = $user->company_id;
            $data->payment_cycle_id = $cycle->id;
            $data->day = $day;
            if ($day == 1) {
                $data->date = $date->toDateString();
            }else {                
                $data->date = $date->addDay(1)->toDateString();
            }            
            $data->status = 0;
            $data->save();
            $day += 1;
            
        }

        return $cycle;
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
        // $cycle = PaymentCycleData::find($request->ids);
        // $cycle->status = true;
        // $cycle->save();
        $cycle = PaymentCycleData::whereIn('id', $request->ids)
          ->update(['status' => 1]);
        return response()->json(
            [
                'status'=>'success',
                'data'=> $cycle
            ]
        );
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
