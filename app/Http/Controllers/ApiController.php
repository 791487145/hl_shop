<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Common;
use Illuminate\Http\Response;

class ApiController extends BaiseController
{
    public $successStatus = 200;
    public $errorStatus = 201;


    public function formatResponse($msg, $code = 200, $data = '',$statusCode = 200)
    {
        $result['code'] = $code;
        $result['message'] = $msg;
        if (isset($data)) {
            $result['data'] = is_array($data) ? $data : json_decode($data, true);
        } else {
            $result['data'] = new \stdClass();
        }

        return new Response($result, $statusCode);
    }
}
