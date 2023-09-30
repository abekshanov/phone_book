<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $first_name
 * @property string $last_name
 * @property string|null $surname
 * @property string $phone
 * @property int $user_id
 * @property bool $favourite
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class Contact extends Model
{
    /**
     * @var string[]
     */
    protected $guarded = ['id'];

    protected $casts = [
        'created_at' => 'string',
        'updated_at' => 'string',
        'favourite' => 'boolean',
    ];
}
