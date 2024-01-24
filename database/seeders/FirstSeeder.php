<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Student;
use App\Models\Category;
use App\Models\Product;
use App\Models\Wallet;
use App\Models\Transaction;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class FirstSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name'=>'Kamila Nurul Ramadhani',
            'username'=>'kamila',
            'password'=>Hash::make('kamila'),
            'role'=>'siswa',
        ]);
        User::create([
            'name'=>'TenizenKantin',
            'username'=>'kantin',
            'password'=>Hash::make('kantin'),
            'role'=>'kantin',
        ]);
        User::create([
            'name'=>'TenizenBank',
            'username'=>'bank',
            'password'=>Hash::make('bank'),
            'role'=>'bank',
        ]);
        Student::create([
            'user_id'=>'1',
            'nis'=>'12345',
            'class'=>'XII RPL',
        ]);
        Category::create([
            'name'=>'Makanan'
        ]);
        Category::create([
            'name'=>'Minuman'
        ]);
        Product::create([
            'name'=>'Bakso Sapi',
            'price'=>10000,
            'stock'=>10,
            'photo'=>'https://asset-a.grid.id/crop/0x0:0x0/x/photo/2019/08/07/1325166108.jpg',
            'description'=>'Bakso Sapi yang lezat dan bergizi',
            'category_id'=>1,
            'stand'=>1
        ]);
        Product::create([
            'name'=>'Es Teh',
            'price'=>3000,
            'stock'=>10,
            'photo'=>'https://i.pinimg.com/564x/38/fb/73/38fb730ee6e8daf814fbb3766a675820.jpg',
            'description'=>'Es Teh yang menyegarkan',
            'category_id'=>2,
            'stand'=>2
        ]);
        Wallet::create([
            'user_id'=>1,
            'credit'=>10000,
            'debit'=>null,
            'description'=>'Pembelian',
        ]);
        Wallet::create([
            'user_id'=>1,
            'credit'=>8000,
            'debit'=>null,
            'description'=>'Pembelian',
        ]);
        Transaction::create([
            'user_id'=>1,
            'product_id'=>1,
            'price'=>10000,
            'quantity'=>1,
            'order_id'=>'INV_12345',
            'status'=>'Keranjang'
        ]);
        Transaction::create([
            'user_id'=>1,
            'product_id'=>2,
            'price'=>3000,
            'quantity'=>1,
            'order_id'=>'INV_12345',
            'status'=>'Keranjang'
        ]);

        $total_debit = 0;

        $transactions = Transaction::where('order_id' == 'INV_12345');

        foreach ($transactions as $transaction) {
            $total_price = $transaction->price * $transaction->quantity;
            $total_debit += $total_price;
        };

        Wallet::create([
            'user_id'=>1,
            'credit'=>$total_debit,
            'description'=>'Pembelian produk',
        ]);

        foreach ($transactions as $transaction) {
            Transaction::find($transaction->id)->update([
                'status'=>'Keranjang'
            ]);
        }
        foreach ($transactions as $transaction) {
            Transaction::find($transaction->id)->update([
                'status'=>'Bayar'
            ]);
        }
        foreach ($transactions as $transaction) {
            Transaction::find($transaction->id)->update([
                'status'=>'Ambil'
            ]);
        }
    }
}
