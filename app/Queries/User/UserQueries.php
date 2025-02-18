<?php

namespace App\Queries\User;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class TransactionQueries
{
    public function getByCustom(array $filters = [], bool $collection = true): User|Collection|null
    {
        $query = User::query()
            ->when(
                isset($filters['name']),
                fn($q) => $q->where('name', 'like', "%{$filters['name']}%")
            )
            ->with(['accounts', 'transactions', 'goals']);

        return $collection
            ? $query->get()
            : $query->first();
    }

    public function store(array $data): User
    {
        return User::create($data);
    }

    public function update(User $user, array $data): bool
    {
        return $user->update($data);
    }

    public function delete(User $user): bool
    {
        return $user->delete();
    }
}
