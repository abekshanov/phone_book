<?php

namespace App\Http\Controllers\Api\v1\Contacts;

use App\Http\Controllers\Api\v1\AbstractControllers\AbstractCrudController;
use App\Models\Contact;

class ContactController extends AbstractCrudController
{
    protected static string $entity_class = Contact::class;
}
