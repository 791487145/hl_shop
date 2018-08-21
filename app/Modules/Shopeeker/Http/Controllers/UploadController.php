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
            Log::alert('file'.print_r($_FILES['file'],true));
           /* if(isset($agency_accessory_Info->account_apply)){
                Storage::delete($agency_accessory_Info->account_apply);
            }*/
            $pic = Storage::putFile('shopeeker',$request->file('file'));
            return $this->formatResponse('上传成功',$this->successStatus,$pic);
        }
    }

}