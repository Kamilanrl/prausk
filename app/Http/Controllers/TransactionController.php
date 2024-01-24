<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Wallet;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function addToCart(Request $request){

        $user_id = $request->user_id;
        $product_id = $request->product_id;
        $status = 'Keranjang';
        $price = $request->price;
        $quantity = $request->quantity;
        $stock = Product::find($product_id)->stock;

        if($stock <= 0){
            return redirect()->back()->with('status','Stock habis');
        }
        else if($quantity <= 0){
            return redirect()->back()->with('status','Jumlah tidak boleh 0');
        }
        else{
            Transaction::create([
                'user_id'=>$user_id,
                'product_id'=>$product_id,
                'status'=>$status,
                'price'=>$price,
                'quantity'=>$quantity
            ]);

            return redirect()->back()->with('status','Berhasil menambah ke keranjang');

        }

    }

    public function payNow(){
        $status = 'Bayar';
        $order_id = 'INV_' . Auth::user()->id . date('YmdHis');
        $carts = Transaction::where('user_id', Auth::user()->id)->where('status','Keranjang')->get();
        $total_debit = 0;

        foreach($carts as $cart){
            $total_price = $cart->price * $cart->quantity;
            $total_debit += $total_price;
        };

        $wallets = Wallet::where('user_id', Auth::user()->id)->get();
        $credit = 0;
        $debit = 0;

        foreach($wallets as $wallet){
            $credit += $wallet->credit;
            $debit += $wallet->debit;
        };

        $saldo = $credit-$debit;

        if($total_debit > $saldo){
            return redirect()->back()->with('status','Saldo tidak cukup');
        }
        else if($total_debit <= 0){
            return redirect()->back()->with('status','Anda belum masukkan keranjang');
        }
        else{
            foreach($carts as $cart){
                if($cart->product->stock > 0){
                    Transaction::find($cart->id)->update([
                        'status'=>$status,
                        'order_id'=>$order_id
                    ]);

                    Product::find($cart->product->id)->update([
                        'stok'=>$cart->product->stock - $cart->quantity,
                    ]);

                }
                else{
                    $total_debit = $total_debit - ($cart->price * $cart->quantity);
                }
            
            }
                
                Wallet::create([
                    'user_id'=>Auth::user()->id,
                    'debit'=>$total_debit,
                    'description'=>'Pembelian produk'
                ]);

            return redirect()->back()->with('status','Berhasil membayar transaksi');
        }
    }

    public function download($order_id){
        $transactions = Transaction::where('order_id', $order_id)->get();
        $total_biaya = 0;
        
        foreach($transactions as $transaction){
            $total_price = $transaction->price * $transaction->quantity;
            $total_biaya += $total_price;
        }

        return view('receipt', compact('transactions', 'total_biaya'));
    }

    public function take($id){
        Transaction::find($id)->update([
        'status'=>'Ambil'
    ]);

    return redirect()->back()->with('status','Pesanan sudah diambil');
    }
}
