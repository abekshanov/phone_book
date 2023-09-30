<?php

namespace App\Validations\Contacts;

use App\Validations\AbstractValidation;

class ContactUpdateValidation extends AbstractValidation
{
    protected function getRules(): array
    {
        return [
            'first_name' => ['required', 'sometimes', 'string', 'max:255'],
            'last_name' => ['required', 'sometimes', 'string', 'max:255'],
            'surname' => ['required', 'sometimes', 'string', 'max:255'],
            'phone' => ['required', 'sometimes', 'regex:/^\+?[0-9]{3,15}$/'],
            'favourite' => ['required', 'sometimes', 'boolean'],
            'id' => ['required', 'integer', 'exists:contacts,id'],
        ];
    }
}
