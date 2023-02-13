<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Code extends Model
{
    use HasFactory;

    protected $fillable=[
        'four_digit',
        'five_digit'
    ];

    public function user():BelongsTo
    {
        return $this->BelongsTo(User::class, 'user_id','id');
    }
}
