<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Account;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    public function addAccount()
    {
        Account::create([
            'user_id' => Auth::id(),
            'balance' => 500.00,
            'main_account' => '1'
        ]);
    }

    public function show(Account $accounts){
//       $accounts =  Account::all();
//        //return view('pages.home', compact('account'));
//        return view('pages.home', ['accounts'=>$accounts]);
    }
}
