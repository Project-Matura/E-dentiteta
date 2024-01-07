<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrganisationUser extends Pivot
{
    use HasFactory;
    use HasUuids;

    protected $table = 'organisaton_users';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
}

