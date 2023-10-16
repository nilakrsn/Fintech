<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Student;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Wallet;
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
            "name" => "Admin",
            "username" => "admin",
            "password" => Hash::make("admin"),
            "role" => "admin"
        ]);
        User::create([
            "name" => "Tenizen bank",
            "username" => "bank",
            "password" => Hash::make("bank"),
            "role" => "bank"
        ]);
        User::create([
            "name" => "Tenizen mart",
            "username" => "kantin",
            "password" => Hash::make("kantin"),
            "role" => "kantin"
        ]);
        User::create([
            "name" => "Nila",
            "username" => "nila",
            "password" => Hash::make("nila"),
            "role" => "siswa"
        ]);

        Student::create([
            "user_id" => 4,
            "nis" => 12341,
            "grade"=> "XII RPL"

        ]);
        Category::create([
            "name" => "Makanan",
        ]);
        Category::create([
            "name" => "Minuman",
        ]);
        Category::create([
            "name" => "Snack",
        ]);
        Product::create([
            "name" => "es teh",
            "price" => 3000,
            "stock" => 50,
            "photo" => "anannaaan",
            "description" => "enak",
            "category_id" => 2,
            "stand" => 2

        ]);
        Product::create([
            "name" => "risol",
            "price" => 3000,
            "stock" => 100,
            "photo" => "anannaaan",
            "description" => "enak",
            "category_id" => 1,
            "stand" => 1

        ]);
        Product::create([
            "name" => "bakso",
            "price" => 10000,
            "stock" => 100,
            "photo" => "anannaaan",
            "description" => "enak",
            "category_id" => 1,
            "stand" => 1

        ]);

        Wallet::create([
            "user_id" => 4,
            "credit" => 100000,
            "description" => "pembukaan buku rekening"
        ]);

        Transaction::create([
            "user_id" => 4,
            "product_id" => 3,
            "status" => "dikeranjang",
            "order_id" => "INV_12345",
            "price" => 10000,
            "quantity" => 2
        ]);

        $transactions = Transaction::where('order_id', 'INV_12345')->get();
        $total_debit = 0;

        foreach($transactions as $transaction){
            $total_price = $transaction->price * $transaction->quantity;
            $total_debit = $total_price;
        }

        Wallet::create([
            "user_id" => 4,
            "debit" => $total_debit,
            "description" => "pembelian produk"
        ]);

        foreach($transactions as $transaction){
            Transaction::find($transaction->id)->update([
                "status" => "dibayar"
            ]);
        }
        foreach($transactions as $transaction){
            Transaction::find($transaction->id)->update([
                "status" => "diambil"
            ]);
        }
    }
}
