<?php

namespace Tests;

class TransactionsTest extends TestCase
{
    /**
     * /transactions [GET]
     */
    public function testShouldReturnAllTransactions()
    {
        $this->get('/api/v1/transactions', []);
        $this->seeStatusCode(200);
        $this->seeJsonStructure([
            'data' => [],
        ]);
    }

    /**
     * /api/v1/transactions?provider=DataProviderX [GET]
     */
    public function testShouldReturnDataProviderXTranactions()
    {
        $this->call('GET', "/api/v1/transactions", ['provider' => 'DataProviderX']);
        $this->seeStatusCode(200);
        $this->seeJsonStructure([
            'data' =>
            ["*" => [
                "transactionAmount",
                "currency",
                "senderPhone",
                "transactionStatus",
                "transactionDate",
                "transactionIdentification"
            ]]
        ]);
    }

    /**
     * /api/v1/transactions?provider=DataProviderW [GET]
     */
    public function testShouldReturnDataProviderWTranactions()
    {
        $this->call("GET", "/api/v1/transactions", ['provider' => 'DataProviderW']);
        $this->seeStatusCode(200);
        $this->seeJsonStructure([
            'data' => ["*" => [
                "amount",
                "currency",
                "phone",
                "status",
                "created_at",
                "id"
            ]]
        ]);
    }


    /**
     * /api/v1/transactions?provider=DataProviderY [GET]
     */
    public function testShouldReturnDataProviderYTranactions()
    {
        $this->call("GET", "/api/v1/transactions", ['provider' => 'DataProviderY']);
        $this->seeStatusCode(200);
        $this->seeJsonStructure([
            'data' => ['*' => [
                "amount",
                "currency",
                "phone",
                "status",
                "created_at",
                "id"
            ]]
        ]);
    }

    public function testShouldFailsWhenProviderNotFound()
    {
        $this->call("GET", "/api/v1/transactions", ['provider' => 'DataProviderZ']);
        $this->seeStatusCode(400);
        $this->seeJsonEquals([
            "error_code" => 400,
            "status" => "error",
            "message" => "",
            "data" => "provider not exits"
        ]);
    }

    ///api/v1/transactaions?statusCode=paid
    public function testShouldReturnDataFilteredByPaidStatusCode()
    {
        $this->call("GET", "/api/v1/transactions", ['statusCode' => 'paid']);
        $this->seeStatusCode(200);
        $this->seeJsonStructure([
            'data' => ['*' => []]
        ]);
    }

    public function testShouldReturnDataFilteredByCurrency()
    {
        $this->call("GET", "/api/v1/transactions", ['currency' => 'EGP']);
        $this->seeStatusCode(200);
        $this->seeJsonStructure([
            'data' => ['*' => []]
        ]);
    }

    //amounteMin=10&amounteMax=100
    public function testShouldReturnDataFilteredByAmount()
    {
        $this->call("GET", "/api/v1/transactions", ['amounteMin' => 10, 'amounteMax' => 100]);
        $this->seeStatusCode(200);
        $this->seeJsonStructure([
            'data' => ['*' => []]
        ]);
    }


    //provider=DataProviderW&currency=EGP&status=paid&amounteMin=10&amounteMax=100
    public function testShouldReturnDataFilteredByAllFilters()
    {
        $this->call("GET", "/api/v1/transactions", [
            'provider' => 'DataProviderW',
            'currency' => 'EGP', 'status' => 'paid',
            'amounteMin' => 10, 'amounteMax' => 100
        ]);
        $this->seeStatusCode(200);
        $this->seeJsonStructure([
            'data' => ['*' => [
                "amount",
                "currency",
                "phone",
                "status",
                "created_at",
                "id"
            ]]
        ]);
    }
}
