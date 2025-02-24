<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\Category;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    private User $user;

    public function run(): void
    {
        $this->createUser();
        $this->createAccounts();
        $this->createCategories();
        $this->createTransactions();
    }

    private function createUser(): void
    {
        $this->user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);
    }

    private function createAccounts(): void
    {
        $accounts = [
            [
                'name' => 'Conta Corrente',
                'type' => 'checking',
                'balance' => 15000.00,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Cartão de Crédito',
                'type' => 'credit_card',
                'balance' => -3500.00,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        foreach ($accounts as $account) {
            Account::create([...$account, 'user_id' => $this->user->id]);
        }
    }

    private function createCategories(): void
    {
        $categories = [
            ['name' => 'Salário', 'type' => 'income'],
            ['name' => 'Alimentação', 'type' => 'expense'],
            ['name' => 'Transporte', 'type' => 'expense'],
            ['name' => 'Investimentos', 'type' => 'income'],
        ];

        foreach ($categories as $category) {
            Category::create([
                ...$category,
                'user_id' => $this->user->id,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }

    private function createTransactions(): void
    {
        $transactions = [
            [
                'date' => Carbon::parse('2024-01-05'),
                'amount' => 4500.00,
                'description' => 'Salário Empresa X',
                'type' => 'income',
                'category_name' => 'Salário',
                'account_name' => 'Conta Corrente'
            ],
            [
                'date' => Carbon::parse('2024-01-10'),
                'amount' => 1500.00,
                'description' => 'Freelance Site Y',
                'type' => 'income',
                'category_name' => 'Investimentos',
                'account_name' => 'Conta Corrente'
            ],
            [
                'date' => Carbon::parse('2024-01-07'),
                'amount' => 250.00,
                'description' => 'Supermercado',
                'type' => 'expense',
                'category_name' => 'Alimentação',
                'account_name' => 'Cartão de Crédito'
            ],
            [
                'date' => Carbon::parse('2024-01-08'),
                'amount' => 80.00,
                'description' => 'Uber para trabalho',
                'type' => 'expense',
                'category_name' => 'Transporte',
                'account_name' => 'Cartão de Crédito'
            ]
        ];

        foreach ($transactions as $transaction) {
            Transaction::create([
                'user_id' => $this->user->id,
                'account_id' => Account::where('name', $transaction['account_name'])->first()->id,
                'category_id' => Category::where('name', $transaction['category_name'])->first()->id,
                'date' => $transaction['date'],
                'amount' => $transaction['amount'],
                'description' => $transaction['description'],
                'type' => $transaction['type'],
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}