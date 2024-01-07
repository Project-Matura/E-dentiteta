<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class RequestCard extends Model
{
    use HasFactory;
    use HasUuids;

    protected $table = 'request_card';
    protected $primaryKey = 'id_request_card';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_user',
        'id_card',
        'id_organisation',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
    
    // RequestCard belongs to a Card
    public function card()
    {
        return $this->belongsTo(Card::class, 'id_card');
    }
    
    // RequestCard belongs to an Organisation
    public function organisation()
    {
        return $this->belongsTo(Organisation::class, 'id_organisation');
    }
}
