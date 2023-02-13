<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Account extends Model
{
    use HasFactory;
    protected $fillable=[
        'account_number',
        'currency_symbol',
        'currency_amount',
        'crypto_symbol',
        'crypto_amount'
    ];

    public function user():BelongsTo
    {
        return $this->BelongsTo(User::class, 'user_id','id');
    }
}
