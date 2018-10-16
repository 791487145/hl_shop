<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Common;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class IndexController extends BaiseController
{

    public function wx(Request $request)
    {
        return view('wx/index');
    }
}
