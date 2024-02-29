<?php

namespace App\Library\Services;

use Illuminate\Http\JsonResponse;

/**
 * Description of PrepareResponse
 *
 * @author khaled
 */
class PrepareResponse implements ResponseInterface {

    /**
     * success response method.
     *
     * @return JsonResponse
     */
    public function success($result, $message, $code = 200): JsonResponse {
        $response = [
            'status' => 'success',
            'message' => $message,
            'data' => $result,
        ];

        return response()->json($response, $code);
    }

    /**
     * return error response.
     *
     * @param $error
     * @param array $errorMessages
     * @param int $code
     * @return JsonResponse
     */
    public function error($error, $errorMessages = [], $code = 404): JsonResponse {
        $response = [
            'error_code' => $code,
            'status' => 'error',
            'message' => $error,
        ];

        if (!empty($errorMessages)) {
            $response['data'] = $errorMessages;
        }

        return response()->json($response, $code);
    }
}
