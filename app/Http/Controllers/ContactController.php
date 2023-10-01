<?php

namespace App\Http\Controllers;

use App\Http\Controllers\AbstractControllers\AbstractCrudController;
use App\Models\Contact;
use Inertia\Response;
use Inertia\ResponseFactory;

class ContactController extends AbstractCrudController
{
    /**
     * @var string
     */
    protected static string $entity_class = Contact::class;

    /**
     * @return Response|ResponseFactory
     */
    public function create()
    {
        return inertia('Contacts/Create');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $validation = $this->factory->createShowValidation();
        $data = $validation->validateCustomData(
            compact('id')
        );

        $service = $this->factory->createService();
        $model = $service->find($data['id']);

        $this->authorize('view', $model);

        return inertia('Contacts/Create', compact('model'));
    }

    /**
     * @param $resource
     * @param  int  $status
     * @param $additional
     * @return Response|ResponseFactory|mixed
     */
    protected function responseIndex($resource, int $status = 200, $additional = null)
    {
        return inertia('Contacts/Index', ['contacts' => $resource]);
    }

    /**
     * @param $resource
     * @param  int  $status
     * @param $additional
     * @return \Illuminate\Http\RedirectResponse|mixed
     */
    protected function responseStore($resource, int $status = 200, $additional = null)
    {
        return to_route('contacts.index');
    }

    /**
     * @param $resource
     * @param  int  $status
     * @param $additional
     * @return Response|ResponseFactory|mixed
     */
    protected function responseShow($resource, int $status = 200, $additional = null)
    {
        return inertia('Contacts/Show', ['contact' => $resource]);
    }

    /**
     * @param $resource
     * @param  int  $status
     * @param $additional
     * @return \Illuminate\Http\RedirectResponse|mixed
     */
    protected function responseUpdate($resource, int $status = 200, $additional = null)
    {
        return to_route('contacts.index');
    }

    /**
     * @param $resource
     * @param  int  $status
     * @param $additional
     * @return \Illuminate\Http\RedirectResponse|mixed
     */
    protected function responseDestroy($resource, int $status = 200, $additional = null)
    {
        return to_route('contacts.index');
    }
}
