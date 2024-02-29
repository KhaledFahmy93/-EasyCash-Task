<?php

namespace App\Contracts;

interface DataProvider
{
    public function getTransactions($prpvider);
}