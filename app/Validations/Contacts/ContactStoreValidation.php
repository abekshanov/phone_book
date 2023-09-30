<?php

namespace App\Validations\Contacts;

use App\Validations\AbstractValidation;

class ContactStoreValidation extends AbstractValidation
{
    protected function getRules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'regex:/^\+?[0-9]{3,15}$/'],
        ];
    }
}
