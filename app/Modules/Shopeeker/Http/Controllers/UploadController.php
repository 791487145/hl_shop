<?php
namespace App\Modules\Shopeeker\Http\Controllers;

use App\Http\Controllers\ApiController;
use App\Modules\System\Models\AuthMenu;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Validator;
use Log;

class UploadController extends ApiController
{

    public function upload(Request $request)
    {
        if($request->file('file')){
            $pic = Storage::putFile('shopeeker',$request->file('file'));
            return response()->json(['pic'=>$pic]);
        }
    }

    public function fileDelete(Request $request)
    {
        $file = $request->post('file');
        $ret = Storage::delete($file);
        //dd($ret);
    }

    public function download(Request $request)
    {
        $a = 'shopeeker\/H60nFctIrbzaFtecGqNp3viMc5aYieRS0KlLQ7L5.xls';

        return Storage::download($a,'demo');
    }

}