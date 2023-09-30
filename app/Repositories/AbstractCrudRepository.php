<?php

namespace App\Repositories;

use App\Contracts\Repositories\CrudRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

abstract class AbstractCrudRepository implements CrudRepositoryInterface
{
    /**
     * @return Builder
     */
    abstract public function query(): Builder;

    /**
     * @return Collection
     */
    public function all(): Collection
    {
        return $this->query()->get();
    }

    /**
     * @param  array  $attributes
     * @return Builder|Model
     */
    public function create(array $attributes = [])
    {
        return $this->query()->create($attributes);
    }

    /**
     * @param $id
     * @param  array  $columns
     * @return Builder|Builder[]|Collection|Model|null
     */
    public function find($id, array $columns = ['*'])
    {
        return $this->query()->find($id, $columns);
    }

    /**
     * @param $id
     * @param  array  $columns
     * @return Builder|Builder[]|Collection|Model|null
     */
    public function findOrFail($id, array $columns = ['*'])
    {
        return $this->query()->findOrFail($id, $columns);
    }

    /**
     * @param  Model  $model
     * @param  array  $attributes
     * @param  array  $options
     * @return bool
     */
    public function update(Model $model, array $attributes = [], array $options = []): bool
    {
        return $model->update($attributes, $options);
    }

    /**
     * @param  Model  $model
     * @return bool|null
     */
    public function delete(Model $model): ?bool
    {
        return $model->delete();
    }

    /**
     * @param  array  $params
     * @return LengthAwarePaginator
     */
    public function getList(array $params = []): LengthAwarePaginator
    {
        $query = $this->query();

        if (!empty($params['user_id'])) {
            $query->where('user_id', '=', $params['user_id']);
        }

        return $query->paginate();
    }
}
