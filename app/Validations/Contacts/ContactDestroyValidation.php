<?php

namespace App\Validations\Contacts;

use App\Validations\AbstractValidation;

class ContactDestroyValidation extends AbstractValidation
{
    protected function getRules(): array
    {
        return [
            'id' => ['required', 'integer', 'exists:contacts,id'],
        ];
    }
}
