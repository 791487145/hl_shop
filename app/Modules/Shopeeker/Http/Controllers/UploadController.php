<?php
namespace App\Modules\Shopeeker\Http\Controllers;

use App\Http\Controllers\ApiController;
use App\Modules\Buyer\Models\ConfCity;
use App\Modules\System\Models\AuthMenu;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Validator;
use Log;
use Cache;

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
        return $this->formatResponse('删除成功',$this->successStatus);
    }

    public function download(Request $request)
    {
        $file_path = $request->get('file_path');

        return Storage::download($file_path,'demo.xls');
    }

    public function city(Request $request)
    {
        if(Cache::has('city')){
            $param = Cache::get('city');
        }else{
            $citys = ConfCity::select('id','name','parent_id')->get();
            $param = array();
            foreach ($citys as $city){
                $pa = array(
                    'name' => $city->name,
                    'value' => (string)$city->id,
                );
				if($city->parent_id != 1){
					
					$pa['parent'] = (string)$city->parent_id;
				}
                $param[] = $pa;
            }
            Cache::put('city',$param);
        };

        return $this->formatResponse('获取成功',$this->successStatus,$param);
    }

}