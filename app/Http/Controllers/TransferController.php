<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Account;
use App\Models\User;
use App\Models\Transfer;
use App\Jobs\ProcessPodcast;
use App\Jobs\SendMoney;
use Illuminate\Validation\ValidationException;
use Illuminate\Queue\Events\JobProcessed;
use App\Models\Job;
use Illuminate\Support\Facades\Queue;

class TransferController extends Controller
{
    public function filterAccNumber($acc_id){
        return DB::table('accounts')
            ->select('id')
            ->where('account_no', '=', $acc_id)
            ->first();
    }

    public function store(Request $request){
        $ac  = Account::where('account_no', '=', request('faccountto'))->first();
        if(isset($ac)) {
            $us = User::where('id', '=', $ac['user_id'])->first();
        }else{
            throw ValidationException::withMessages(['Įvesta klaidinga gavėjo sąskaita']);
        }
        $ac1  = Account::where('account_no', '=', request('faccountfrom'))->first();

        //dd($na['surname']);

        $validateData = $request->validate([
            'faccountfrom'=>'required|string|min:20|max:20',
            'faccountto'=>[
                'required',
                'string',
                'different:faccountfrom',
                Rule::exists('accounts', 'account_no')
                    ->where('account_no', request('faccountto'))],
            'surname'=>[
                'required',
                Rule::exists('users', 'surname')
                    ->where('surname', $us['surname'])],
            'name'=>[
                'required',
                Rule::exists('users', 'name')
                    ->where('name', $us['name'])],
            'purpose'=>'required|max:255'
        ]);

        if($ac1['balance']-$ac1['reserved']>=request('amount')) {
            Account::where('account_no', request('faccountfrom'))->update(['reserved' => $ac1['reserved']+request('amount')]);
        }else{
            throw ValidationException::withMessages(['Insufficient bank account balance']);
        }

        $tid=Transfer::create([
            'account_id_from' => self::filterAccNumber(request('faccountfrom'))->id, //
            'account_id_to'=> self::filterAccNumber(request('faccountto'))->id,
            'purpose'=>request('purpose'),
            'status'=>1,
            'amount'=> request('amount'),
            'date'=>now()->format('Y-m-d')
        ]);

        $data=SendMoney::dispatch($ac, $ac1, request('faccountfrom'), request('faccountto'), request('amount'),  $tid->id )
            ->delay(120);

        return redirect('/transfer')->with('message','Payment made');
    }

    public function store1(Request $request){
        $ac  = Account::where('account_no', '=', request('faccountto'))->first();
        if(isset($ac)) {
            $us = User::where('id', '=', $ac['user_id'])->first();
        }else{
            throw ValidationException::withMessages(['Invalid beneficiary account']);
        }
        $ac1  = Account::where('account_no', '=', request('faccountfrom'))->first();


        $validateData = $request->validate([
            'faccountfrom'=>'required|string|min:20|max:20',
            'faccountto'=>[
                'required',
                'string',
                'different:faccountfrom',
                Rule::exists('accounts', 'account_no')
                    ->where('account_no', request('faccountto'))]
        ]);

        if($ac1['balance']-$ac1['reserved']>=request('amount')) {
            Account::where('account_no', request('faccountfrom'))->update(['reserved' => $ac1['reserved']+request('amount')]);
        }else{
            throw ValidationException::withMessages(['Insufficient bank account balance']);
        }

        $tid=Transfer::create([
            'account_id_from' => self::filterAccNumber(request('faccountfrom'))->id, //
            'account_id_to'=> self::filterAccNumber(request('faccountto'))->id,
            'purpose'=>'Money transfer between user accounts',
            'status'=>1,
            'amount'=> request('amount'),
            'date'=>now()->format('Y-m-d')
        ]);

        $data=SendMoney::dispatch($ac, $ac1, request('faccountfrom'), request('faccountto'), request('amount'),  $tid->id )
            ->delay(120);

        return redirect('/transferInside')->with('message','Payment made');
    }

    public function cancel($account)
    {
        $jobs = Job::get();

        foreach ($jobs as $job){
            $aw = json_decode($job->payload)->data->command;
            $cm = unserialize($aw);
        }
        return redirect('/');
    }
}
