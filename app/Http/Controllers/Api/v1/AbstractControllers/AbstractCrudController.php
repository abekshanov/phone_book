<?php

namespace App\Http\Controllers\Api\v1\AbstractControllers;

use App\Contracts\Controllers\Factories\ControllerFactoryInterface;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
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
    private ControllerFactoryInterface $factory;

    /**
     * @param  ControllerFactoryInterface  $factory
     */
    public function __construct(ControllerFactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    /**
     * @param  Request  $request
     * @return JsonResponse
     * @throws AuthorizationException
     * @throws ValidationException
     */
    public function index(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = Auth::user();

        $this->authorize('viewAny', static::$entity_class);

        $validation = $this->factory->createIndexValidation();
        $data = $validation->validateCustomData($request->all());

        $params = $this->addUserId($data, $user->id);

        $service = $this->factory->createService();
        $result = $service->getList($params);

        $resource = $this->factory->createIndexResource($result);

        return $this->response($resource);
    }

    /**
     * @param  int  $id
     * @return JsonResponse
     * @throws AuthorizationException|ValidationException
     */
    public function show(int $id): JsonResponse
    {
        $validation = $this->factory->createShowValidation();
        $data = $validation->validateCustomData(
            compact('id')
        );

        $service = $this->factory->createService();
        $model = $service->find($data['id']);

        $this->authorize('view', $model);

        $resource = $this->factory->createShowResource($model);

        return $this->response($resource);
    }

    /**
     * @param  Request  $request
     * @return JsonResponse
     * @throws AuthorizationException
     * @throws ValidationException
     */
    public function store(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = Auth::user();

        $validation = $this->factory->createStoreValidation();
        $data = $validation->validateCustomData($request->all());

        $this->authorize('create', static::$entity_class);

        $data = $this->addUserId($data, $user->id);

        $service = $this->factory->createService();
        $model = $service->create($data);

        $resource = $this->factory->createStoreResource($model->refresh());

        return $this->response($resource);
    }

    /**
     * @param  Request  $request
     * @param  int  $id
     * @return JsonResponse
     * @throws AuthorizationException
     * @throws ValidationException
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $request_data = $request->all();
        $request_data['id'] = $id;

        $validation = $this->factory->createUpdateValidation();
        $data = $validation->validateCustomData($request_data);

        $service = $this->factory->createService();

        $model = $service->find(Arr::pull($data, 'id'));

        $this->authorize('update', $model);

        $service->update($model, $data);

        $resource = $this->factory->createUpdateResource($model->refresh());

        return $this->response($resource);
    }

    /**
     * @param  int  $id
     * @return JsonResponse
     * @throws AuthorizationException
     * @throws ValidationException
     */
    public function destroy(int $id): JsonResponse
    {
        $validation = $this->factory->createDestroyValidation();
        $data = $validation->validateCustomData(
            compact('id')
        );

        $service = $this->factory->createService();
        $model = $service->find($data['id']);

        $this->authorize('delete', $model);

        $service->delete($model);

        return $this->response('', 204);
    }

    /**
     * @param mixed|Model|Collection|JsonResource $resource
     * @param int $status
     * @param mixed|null $additional
     * @return mixed|JsonResource|JsonResponse
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
