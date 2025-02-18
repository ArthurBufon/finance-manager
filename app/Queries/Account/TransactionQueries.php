<?php

namespace App\Queries\Account;

use App\Models\Account;
use Illuminate\Database\Eloquent\Collection;

class TransactionQueries
{
    public function getByCustom(array $filters = [], bool $collection = true): Account|Collection|null
    {
        $query = Account::where('user_id', auth()->user->id)
            ->when(
                isset($filters['start_date']),
                fn($q) => $q->where('date', '>=', $filters['start_date'])
            )
            ->when(
                isset($filters['end_date']),
                fn($q) => $q->where('date', '<=', $filters['end_date'])
            )
            ->when(
                isset($filters['type']),
                fn($q) => $q->where('type', $filters['type'])
            )
            ->when(
                isset($filters['account_id']),
                fn($q) => $q->where('account_id', $filters['account_id'])
            )
            ->with(['account', 'category']);

        return $collection
            ? $query->get()
            : $query->first();
    }

    public function store(array $data): Account
    {
        return Account::create([
            ...$data,
            'user_id' => auth()->user->id
        ]);
    }

    public function update(Account $account, array $data): bool
    {
        return $account->update($data);
    }

    public function delete(Account $account): bool
    {
        return $account->delete();
    }
}
