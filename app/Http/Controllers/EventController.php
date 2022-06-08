<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Account;

class EventController extends Controller
{
    public function store(Request $request)
    {
        if($request->input('type') === 'deposit'){
            return $this -> deposit(
                $request->input('destination'),
                $request->input('amount')
            );
        }elseif($request->input('type') === 'withdraw'){
            return $this -> withdraw(
                $request->input('origin'),
                $request->input('amount')
            );
        }
    }
    
    private function deposit($destination, $amount )
    {
        $account = Account::firstOrCreate([
            'id' => $destination
        ]);

        $account->balance += $amount;
        $account->save();
        return response()->json([
            'balance' => [
                'id' => $account->id,
                'balance' => $account->balance
          ]
        ], 201);
    }

    private function withdraw($origin, $amount )
    {
        $account = Account::findOrFail($origin);

  
    }
}