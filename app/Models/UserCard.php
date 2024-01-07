<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserCard extends Pivot
{
    use HasFactory;
    use HasUuids;

    protected $table = 'user_cards';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
    
    // UserCard belongs to a Card
    public function card()
    {
        return $this->belongsTo(Card::class, 'id_card');
    }

}

