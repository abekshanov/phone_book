<?php

namespace App\Services\Contacts;

use App\Contracts\Controllers\Services\EntityServiceInterface;
use App\Repositories\ContactRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class ContactService implements EntityServiceInterface
{
    private ContactRepository $repository;

    /**
     * @param  ContactRepository  $repository
     */
    public function __construct(ContactRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getList(array $params = [], int $per_page = 10): LengthAwarePaginator
    {
        return $this->repository->getList($params, $per_page);
    }

    public function create(array $data): Model
    {
        return $this->repository->create($data);
    }

    public function find(int $id): ?Model
    {
        return $this->repository->find($id);
    }

    public function update(Model $model, array $data): bool
    {
        return $this->repository->update($model, $data);
    }

    public function delete(Model $model): ?bool
    {
        return $this->repository->delete($model);
    }
}
