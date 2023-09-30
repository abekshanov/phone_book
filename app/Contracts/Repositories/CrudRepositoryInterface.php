<?php

namespace App\Contracts\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface CrudRepositoryInterface
{
    public function all(): Collection;

    public function create(array $attributes = []);

    public function find($id, array $columns = ['*']);

    public function findOrFail($id, array $columns = ['*']);

    public function update(Model $model, array $attributes = [], array $options = []): bool;

    public function delete(Model $model): ?bool;
}