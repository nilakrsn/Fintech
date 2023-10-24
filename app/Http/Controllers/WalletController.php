<?php

namespace App\Http\Controllers;

use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WalletController extends Controller
{
    public function topUp(Request $request){
        $user_id = Auth::user()->id;
        $credit = $request->credit;
        $description = "top up saldo";
        $status = "diproses";

        Wallet::create([
            'user_id' => $user_id,
            'credit' => $credit,
            'description' => $description,
            'status' => $status,
        ]);
        return redirect()-> back()->with('status', 'Berhasil merequest saldo');
    }

    public function acceptRequest(Request $request){
        $wallet_id = $request->wallet_id;

        Wallet::find($wallet_id)->update([
            'status' => 'selesai'
        ]);
        
        return redirect()-> back()->with('status', 'Berhasil menyetujui saldo');
    }
}
