<?php

namespace App\Http\Controllers;

use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WalletController extends Controller
{
    public function topupNow(Request $request)
    {
        $user_id = Auth::user()->id;
        $credit = $request->credit;
        $status = 'Proses';
        $description = 'Topup';

        Wallet::create([
            'user_id'=>$user_id,
            'credit'=>$credit,
            'status'=>$status,
            'description'=>$description,
        ]);

        return redirect()->back()->with('status','Berhasil request topup. Silahkan setor uangnya');
    }
    
    public function acceptRequest(Request $request)
    {
        $wallet_id = $request->id;
        Wallet::find($wallet_id)->update(['status'=>'Selesai']);
        return redirect()->back()->with('status','Berhasil menyetujui');
    }
}
