<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;

trait ResponseOutput
{
    function responseErrorValidate($validator)
    {
        return response()->json([
            'status' => false,
            'message' =>  __('Validation Failed'),
            'data' => $validator
        ], 422);
    }
    function safeExecute(callable $callback)
    {

        try {
            return $callback();
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->responseFailed($th->getMessage() . "|" . $th->getFile() . "|" . $th->getLine());
        }
    }
    function responseFailed($failedMsg)
    {
        return response()->json([
            'status' => false,
            'message' => __("Failed") . "!!",
            'data' => [
                'message' => $failedMsg
            ]
        ], 500);
    }
    function responseSuccess($data, $status = true)
    {
        return response()->json([
            'status' => $status,
            'message' => 'Success !!',
            'data' => $data
        ], 200);
    }
}
