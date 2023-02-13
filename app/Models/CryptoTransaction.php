<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;

class CryptoTransaction extends Model
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $fillable=[
        'from_account',
        'to_account',
        'symbol',
        'amount',
        'currency_symbol',
        'bill'
    ];

    public function user():BelongsTo
    {
        return $this->BelongsTo(User::class, 'user_id','id');
    }
}
