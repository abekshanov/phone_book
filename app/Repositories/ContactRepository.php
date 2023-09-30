<?php

namespace App\Repositories;

use App\Models\Contact;
use Illuminate\Database\Eloquent\Builder;

class ContactRepository extends AbstractCrudRepository
{
    /**
     * @return Builder
     */
    public function query(): Builder
    {
        return Contact::query();
    }
}
