<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class CurrencyTransaction extends Model
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $fillable=[
        'from_account',
        'to_account',
        'symbol',
        'amount'
    ];

    public function user():BelongsTo
    {
        return $this->BelongsTo(User::class, 'user_id','id');
    }
}
