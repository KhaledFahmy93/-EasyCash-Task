<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataProvider extends Model
{
    public const PROVIDERS = [
        'DataProviderX.json',
        'DataProviderW.json',
        'DataProviderY.json'
    ];
}
