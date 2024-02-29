<?php

namespace App\Services;

use App\Models\DataProvider;
use App\Models\Transaction;

class TransactionService
{
    private $dataProvider;

    public function __construct(DataProvider $dataProvider)
    {
        $this->dataProvider = $dataProvider;
    }

    public function listAllTransactions($filter)
    {
        $provider = $filter['provider'] ?? null;
        if ($provider && !file_exists(storage_path("providers/{$provider}.json"))) {
            throw new \Exception("provider not exits", 400);
        }
        $data = $this->getTransactionsData($provider);
        return $this->filterTransactions($data, $filter);
    }

    private function getTransactionsData($provider)
    {
        if ($provider)
            return $this->dataProvider->getTransactions($provider);
        foreach(DataProvider::PROVIDERS as $provider){
            $data []  = $this->dataProvider->getTransactions($provider);   
        }
        return $data;
    }

    private function filterTransactions($data, $filter)
    {
        $statusCode = array_key_exists('statusCode', $filter) ? Transaction::STATUS[$filter['statusCode']] : null;
        $currency = $filter['currency'] ??  null;
        $amountMax = $filter['amounteMax'] ?? null;
        $amountMin = $filter['amounteMin'] ?? null;
        $data = array_filter($data, function ($provider) use ($statusCode, $currency, $amountMax, $amountMin) {
            if ($statusCode && $currency && $amountMax && $amountMin)
                return (in_array($provider['status'], $statusCode) &&
                    $provider['currency'] == $currency &&
                    $provider['amount'] >= $amountMin &&
                    $provider['amount'] <= $amountMax
                );
            if ($statusCode && $currency)
                return ((array_key_exists('status', $provider) && in_array($provider['status'], $statusCode) &&
                    $provider['currency'] == $currency) ||
                    (array_key_exists('transactionStatus', $provider) && in_array($provider['transactionStatus'], $statusCode) &&
                    $provider['currency'] == $currency)
                );
            if ($currency)
                return ($provider['currency'] == $currency);
            if ($statusCode)
                return (array_key_exists('status', $provider) && in_array($provider['status'], $statusCode)) ||
                    (array_key_exists('transactionStatus', $provider) && in_array($provider['transactionStatus'], $statusCode));
            if ($amountMin && $amountMax)
                return ((array_key_exists('amount', $provider) && $provider['amount'] >= $amountMin &&
                    array_key_exists('amount', $provider) && $provider['amount'] <= $amountMax) ||
                    (array_key_exists('transactionAmount', $provider) && $provider['transactionAmount'] >= $amountMin &&
                        array_key_exists('transactionAmount', $provider) && $provider['transactionAmount'] <= $amountMax));
            if ($amountMin)
                return ((array_key_exists('amount', $provider) && $provider['amount'] >= $amountMin) ||
                    array_key_exists('transactionAmount', $provider) && $provider['transactionAmount'] >= $amountMin);
            if ($amountMax)
                return ((array_key_exists('amount', $provider) && $provider['amount'] <= $amountMax) ||
                    (array_key_exists('transactionAmount', $provider) && $provider['transactionAmount'] <= $amountMax));
            return true;
        });
        return array_values($data);
    }
}
