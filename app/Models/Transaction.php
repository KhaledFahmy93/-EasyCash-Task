<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    public const STATUS = [
        'paid' => ['done', 1, 100],
        "pending" => ['wait', 2, 200],
        "reject" => ['nope', 3, 300],
    ];
}
