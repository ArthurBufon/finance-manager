<?php

namespace App\Queries\Goal;

use App\Models\Goal;
use Illuminate\Database\Eloquent\Collection;

class CategoryQueries
{
    public function getByCustom(array $filters = [], bool $collection = true): Goal|Collection|null
    {
        $query = Goal::where('user_id', auth()->user->id)
            ->when(
                isset($filters['account_id']),
                fn($q) => $q->where('account_id', $filters['account_id'])
            )
            ->when(
                isset($filters['category_id']),
                fn($q) => $q->where('category_id', $filters['category_id'])
            )
            ->when(
                isset($filters['name']),
                fn($q) => $q->where('name', 'like', "%{$filters['name']}%")
            )
            ->when(
                isset($filters['description']),
                fn($q) => $q->where('description', 'like', "%{$filters['description']}%")
            )
            ->when(
                isset($filters['type']),
                fn($q) => $q->where('type', $filters['type'])
            )
            ->when(
                isset($filters['start_date']),
                fn($q) => $q->where('date', '>=', $filters['start_date'])
            )
            ->when(
                isset($filters['end_date']),
                fn($q) => $q->where('date', '<=', $filters['end_date'])
            );

        return $collection
            ? $query->get()
            : $query->first();
    }

    public function store(array $data): Goal
    {
        return Goal::create([
            ...$data,
            'user_id' => auth()->user->id
        ]);
    }

    public function update(Goal $goal, array $data): bool
    {
        return $goal->update($data);
    }

    public function delete(Goal $goal): bool
    {
        return $goal->delete();
    }
}
