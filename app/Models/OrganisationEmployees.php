<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class OrganisationEmployees extends Model
{
    use HasFactory;
    use HasUuids;

    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_user',
        'id_organisation'
    ];
    protected $table = 'organisation_employees'; // Explicitly defining the table name

    // Define the relationship back to the User
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    // Define the relationship back to the Organisation
    public function organisation()
    {
        return $this->belongsTo(Organisation::class, 'id_organisation');
    }
}
