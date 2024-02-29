<?php

namespace App\DataProviders;

use App\Contracts\DataProvider;

class DataProviderW implements DataProvider
{
    public function getTransactions($provider)
    {
        return json_decode(file_get_contents(storage_path("providers/{$provider}.json")), true);
    }
}