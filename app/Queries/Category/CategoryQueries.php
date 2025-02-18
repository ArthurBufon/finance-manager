<?php

namespace App\Queries\Category;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

class CategoryQueries
{
    public function getByCustom(array $filters = [], bool $collection = true): Category|Collection|null
    {
        $query = Category::where('user_id', auth()->user->id)
            ->when(
                isset($filters['name']),
                fn($q) => $q->where('name', 'like', "%{$filters['start_date']}%")
            )
            ->when(
                isset($filters['type']),
                fn($q) => $q->where('type', $filters['type'])
            );

        return $collection
            ? $query->get()
            : $query->first();
    }

    public function store(array $data): Category
    {
        return Category::create([
            ...$data,
            'user_id' => auth()->user->id
        ]);
    }

    public function update(Category $category, array $data): bool
    {
        return $category->update($data);
    }

    public function delete(Category $category): bool
    {
        return $category->delete();
    }
}
