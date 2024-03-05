<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class OrganisationAdmin extends Model
{
    use HasFactory;
    use HasUuids;
    use Notifiable;

    protected $primaryKey = 'id';

    protected $keyType = 'string';

    public $incrementing = false;

    protected $table = 'organisation_admins';

    protected $fillable = [
        'id_user',
        'id_organisation',
    ];
}