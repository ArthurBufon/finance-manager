<?php

namespace App\Services\Category;

use App\Queries\Category\CategoryQueries;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CategoryService
{
    public function __construct(
        private CategoryQueries $queries
    ) {
        //
    }

    public function index(array $filters = [])
    {
        return $this->queries->getByCustom($filters);
    }

    public function store(array $data)
    {
        return $this->queries->store($data);
    }

    public function update(int $id, array $data)
    {
        $transaction = $this->queries->getByCustom(['id' => $id])->first();

        if (!$transaction) {
            throw new ModelNotFoundException('Category not found');
        }

        return $this->queries->update($transaction, $data);
    }

    public function delete(int $id)
    {
        $transaction = $this->queries->getByCustom(['id' => $id])->first();

        if (!$transaction) {
            throw new ModelNotFoundException('Category not found');
        }

        return $this->queries->delete($transaction);
    }
}
