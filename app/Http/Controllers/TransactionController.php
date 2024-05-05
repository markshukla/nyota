<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Setting;
use App\Models\User;
use App\Models\Subscription;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $data['transactions'] = Transaction::with('user')->orderBy('id','DESC')->paginate(12);
        return view('transaction.index',$data);
    }
    
    public function completeOfflinePayment(Request $request){
        
        $transaction = Transaction::find($request->get("id"));
        $user = User::find($transaction->user_id);
        $subs = Subscription::where('name',$transaction->plan)->first();
        
        $start_date = date('Y-m-d');
        $end_date = date('Y-m-d', strtotime($subs->value." ".$subs->type));
            
        $user->subscription_name = $subs->name;
        $user->subscription_price = $transaction->amount;
        $user->subscription_date = $start_date;
        $user->subscription_end_date = $end_date;
        
        $user->posts_limit = $user->posts_limit+$subs->posts_limit;
        $user->business_limit = $subs->business_limit;
        $user->political_limit = $subs->political_limit;
        
        $user->save();
        $transaction->status = 'paid';
        $transaction->save();
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
