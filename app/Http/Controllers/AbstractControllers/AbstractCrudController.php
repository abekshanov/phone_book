<?php

namespace App\Http\Controllers\AbstractControllers;

use App\Contracts\Controllers\Factories\ControllerFactoryInterface;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

abstract class AbstractCrudController extends Controller
{
    /**
     * @var string
     */
    protected static string $entity_class;

    /**
     * @var ControllerFactoryInterface
     */
    protected ControllerFactoryInterface $factory;

    /**
     * @param  ControllerFactoryInterface  $factory
     */
    public function __construct(ControllerFactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    /**
     * @param  Request  $request
     * @return mixed
     * @throws AuthorizationException
     * @throws ValidationException
     */
    public function index(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        $this->authorize('viewAny', static::$entity_class);

        $validation = $this->factory->createIndexValidation();
        $data = $validation->validateCustomData($request->all());

        $params = $this->addUserId($data, $user->id);

        $service = $this->factory->createService();
        $result = $service->getList($params);

        return $this->responseIndex($result);
    }

    /**
     * @param  int  $id
     * @return mixed
     * @throws AuthorizationException|ValidationException
     */
    public function show(int $id)
    {
        $validation = $this->factory->createShowValidation();
        $data = $validation->validateCustomData(
            compact('id')
        );

        $service = $this->factory->createService();
        $model = $service->find($data['id']);

        $this->authorize('view', $model);

        return $this->responseShow($model);
    }

    /**
     * @param  Request  $request
     * @return mixed
     * @throws AuthorizationException
     * @throws ValidationException
     */
    public function store(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        $validation = $this->factory->createStoreValidation();
        $data = $validation->validateCustomData($request->all());

        $this->authorize('create', static::$entity_class);

        $data = $this->addUserId($data, $user->id);

        $service = $this->factory->createService();
        $model = $service->create($data);

        return $this->responseStore($model->refresh());
    }

    /**
     * @param  Request  $request
     * @param  int  $id
     * @return mixed
     * @throws AuthorizationException
     * @throws ValidationException
     */
    public function update(Request $request, int $id)
    {
        $request_data = $request->all();
        $request_data['id'] = $id;

        $validation = $this->factory->createUpdateValidation();
        $data = $validation->validateCustomData($request_data);

        $service = $this->factory->createService();

        $model = $service->find(Arr::pull($data, 'id'));

        $this->authorize('update', $model);

        $service->update($model, $data);

        return $this->responseUpdate($model->refresh());
    }

    /**
     * @param  int  $id
     * @return mixed
     * @throws AuthorizationException
     * @throws ValidationException
     */
    public function destroy(int $id)
    {
        $validation = $this->factory->createDestroyValidation();
        $data = $validation->validateCustomData(
            compact('id')
        );

        $service = $this->factory->createService();
        $model = $service->find($data['id']);

        $this->authorize('delete', $model);

        $service->delete($model);

        return $this->responseDestroy('', 204);
    }

    /**
     * @param mixed|Model|Collection|JsonResource $resource
     * @param int $status
     * @param mixed|null $additional
     * @return mixed
     */
    protected function response($resource, int $status = 200, $additional = null)
    {
        if ($additional) {
            if ($resource instanceof Collection) {
                $resource->push([compact('additional')]);
            }

            if ($resource instanceof Model) {
                $resource->setAttribute('additional', $additional);
            }

            if (is_array($resource)) {
                $resource['additional'] = $additional;
            }
        }

        return response()->json($resource, $status);
    }

    /**
     * @param $resource
     * @param  int  $status
     * @param mixed $additional
     * @return mixed
     */
    protected function responseIndex($resource, int $status = 200, $additional = null)
    {
        $resource = $this->factory->createIndexResource($resource);

        return $this->response($resource, $status, $additional);
    }

    /**
     * @param $resource
     * @param  int  $status
     * @param mixed $additional
     * @return mixed
     */
    protected function responseShow($resource, int $status = 200, $additional = null)
    {
        $resource = $this->factory->createShowResource($resource);

        return $this->response($resource, $status, $additional);
    }

    /**
     * @param $resource
     * @param  int  $status
     * @param mixed $additional
     * @return mixed
     */
    protected function responseStore($resource, int $status = 200, $additional = null)
    {
        $resource = $this->factory->createStoreResource($resource);

        return $this->response($resource, $status, $additional);
    }

    /**
     * @param $resource
     * @param  int  $status
     * @param mixed $additional
     * @return mixed
     */
    protected function responseUpdate($resource, int $status = 200, $additional = null)
    {
        $resource = $this->factory->createUpdateResource($resource);

        return $this->response($resource, $status, $additional);
    }

    /**
     * @param $resource
     * @param  int  $status
     * @param mixed $additional
     * @return mixed
     */
    protected function responseDestroy($resource, int $status = 200, $additional = null)
    {
        return $this->response($resource, $status, $additional);
    }

    /**
     * @param  array  $params
     * @param  int  $userId
     * @return array
     */
    protected function addUserId(array $params, int $userId): array
    {
        $params['user_id'] = $userId;

        return $params;
    }
}
