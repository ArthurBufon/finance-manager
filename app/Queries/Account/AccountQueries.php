<?php

namespace App\Queries\Account;

use App\Models\Account;
use Illuminate\Database\Eloquent\Collection;

class AccountQueries
{
    public function getByCustom(array $filters = [], bool $collection = true): Account|Collection|null
    {
        $query = Account::where('user_id', auth()->user->id)
            ->when(
                isset($filters['name']),
                fn($q) => $q->where('name', 'like', "%{$filters['start_date']}%")
            )
            ->when(
                isset($filters['type']),
                fn($q) => $q->where('type', $filters['type'])
            )
            ->when(
                isset($filters['balance']),
                fn($q) => $q->where('balance', $filters['balance'])
            );

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
