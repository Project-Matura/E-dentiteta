<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Organisation extends Model
{
    use HasFactory;
    use HasUuids;

    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'name',
        'description',
        'verified',
        'checking_all_cards',
        'id_user'
    ];

    // Relationships
    public function cards()
    {
        return $this->hasMany(Card::class, 'id_organisation');
    }
    
    // Organisation belongs to many Users
    public function users()
    {
        return $this->belongsToMany(User::class, 'organisation_users', 'id_organisation', 'id_user');
    }
    
    // Organisation has many RequestCards
    public function requestCards()
    {
        return $this->hasMany(RequestCard::class, 'id_organisation');
    }
}

