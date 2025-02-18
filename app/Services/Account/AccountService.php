<?php

namespace App\Services\Account;

use App\Queries\Account\AccountQueries;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TransactionService
{
    public function __construct(
        private AccountQueries $queries
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
            throw new ModelNotFoundException('Account not found');
        }

        return $this->queries->update($transaction, $data);
    }

    public function delete(int $id)
    {
        $transaction = $this->queries->getByCustom(['id' => $id])->first();

        if (!$transaction) {
            throw new ModelNotFoundException('Account not found');
        }

        return $this->queries->delete($transaction);
    }
}
