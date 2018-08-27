<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Common;
use Illuminate\Http\Response;

class ApiController extends BaiseController
{
    public $successStatus = 200;
    public $errorStatus = 201;
    public $unauthized = 403;

    public $buyer = 1;
    public $shopeeker = 2;
    public $admin = 3;

    public $interest_rate = 0.00005;

    public $limit = 10;

    public $pub = 999;

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
