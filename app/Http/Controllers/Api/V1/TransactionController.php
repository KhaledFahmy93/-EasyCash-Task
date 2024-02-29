<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\TransactionService;
use App\Helpers\HttpStatusCodes;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * list all transactions which combine transactions from all the available providerDataProvider.
     * @param TransactionService $transactionService
     * @return JsonResponse
     */
    public function index(TransactionService $transactionService, Request $request): JsonResponse
    {
        try {
            $transactions = $transactionService->listAllTransactions($request->all());
        } catch (\Exception $exception) {
            return $this->response->error('', $exception->getMessage(), HttpStatusCodes::HTTP_BAD_REQUEST);
        }

        return $this->response->success($transactions, 'transactions listed successfully');
    }
}
