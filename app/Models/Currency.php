<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    protected string $id;
    protected float $rate;

    public function __construct(string $id, float $rate)
    {
        $this->id=$id;
        $this->rate=$rate;
    }

    public function getId():string
    {
        return $this->id;
    }

    public function getRate():float
    {
        return $this->rate;
    }
}
