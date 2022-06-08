<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
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
        }elseif($request->input('type') === 'transfer'){
            return $this -> transfer(
                $request->input('origin'),
                $request->input('destination'),
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

        $account->balance -= $amount;
        $account->save();

        return response()->json([
            'origin' => [
                'id' => $account->id,
                'balance' => $account->balance
          ]
        ], 201);
    }

    private function transfer($origin, $destination, $amount )
    {
        
        $originAccount = Account::findOrFail($origin);
        $destinationAccount = Account::firstOrCreate([
            'id' => $destination
        ]);

        DB::transaction(function () use($originAccount, $destinationAccount, $amount) {
    
            $originAccount->balance -= $amount;
            $destinationAccount->balance += $amount;
    
            $originAccount->save();
            $destinationAccount->save();
        });

        return response()->json([
            'origin' => [
                'id' => $originAccount->id,
                'balance' => $originAccount->balance
            ],
            'destination' => [
                'id' => $destinationAccount->id,
                'balance' => $destinationAccount->balance
          ]
        ], 201);

    }
}