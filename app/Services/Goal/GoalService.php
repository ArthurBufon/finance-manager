<?php

namespace App\Services\Goal;

use App\Queries\Goal\GoalQueries;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class GoalService
{
    public function __construct(
        private GoalQueries $queries
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
            throw new ModelNotFoundException('Goal not found');
        }

        return $this->queries->update($transaction, $data);
    }

    public function delete(int $id)
    {
        $transaction = $this->queries->getByCustom(['id' => $id])->first();

        if (!$transaction) {
            throw new ModelNotFoundException('Goal not found');
        }

        return $this->queries->delete($transaction);
    }
}
