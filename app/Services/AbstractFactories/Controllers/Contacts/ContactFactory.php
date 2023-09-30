<?php

namespace App\Services\AbstractFactories\Controllers\Contacts;

use App\Contracts\Controllers\Factories\ControllerFactoryInterface;
use App\Contracts\Controllers\Services\EntityServiceInterface;
use App\Contracts\Repositories\CrudRepositoryInterface;
use App\Http\Resources\Contacts\ContactIndexResource;
use App\Http\Resources\Contacts\ContactShowResource;
use App\Http\Resources\Contacts\ContactStoreResource;
use App\Http\Resources\Contacts\ContactUpdateResource;
use App\Repositories\ContactRepository;
use App\Services\Contacts\ContactService;
use App\Validations\AbstractValidation;
use App\Validations\Contacts\ContactDestroyValidation;
use App\Validations\Contacts\ContactIndexValidation;
use App\Validations\Contacts\ContactShowValidation;
use App\Validations\Contacts\ContactStoreValidation;
use App\Validations\Contacts\ContactUpdateValidation;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\JsonResource;

class ContactFactory implements ControllerFactoryInterface
{
    public function createCrudRepository(): CrudRepositoryInterface
    {
        return app(ContactRepository::class);
    }

    public function createService(): EntityServiceInterface
    {
        return app(ContactService::class);
    }

    /**
     * @param array|Model|Collection|mixed $resource_data
     * @return JsonResource
     */
    public function createIndexResource($resource_data): JsonResource
    {
        return new ContactIndexResource($resource_data);
    }

    public function createShowResource(Model $model): JsonResource
    {
        return new ContactShowResource($model);
    }

    public function createUpdateResource(Model $model): JsonResource
    {
        return new ContactUpdateResource($model);
    }

    public function createStoreResource(Model $model): JsonResource
    {
        return new ContactStoreResource($model);
    }

    public function createIndexValidation(): AbstractValidation
    {
        return app(ContactIndexValidation::class);
    }

    public function createShowValidation(): AbstractValidation
    {
        return app(ContactShowValidation::class);
    }

    public function createStoreValidation(): AbstractValidation
    {
        return app(ContactStoreValidation::class);
    }

    public function createUpdateValidation(): AbstractValidation
    {
        return app(ContactUpdateValidation::class);
    }

    public function createDestroyValidation(): AbstractValidation
    {
        return app(ContactDestroyValidation::class);
    }
}
