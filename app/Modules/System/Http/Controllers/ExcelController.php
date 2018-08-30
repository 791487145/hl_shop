<?php
namespace App\Modules\System\Http\Controllers;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Validator;
use Log;
use Excel;
use Storage;

class ExcelController extends ApiController
{

   /* public function export(){
        $cellData = [
            ['商品名称','数量','单价','总价'],
            ['太原-大连火车票','20','101.21','2024.2'],
            ['招牌手撕鸡','6','10','60'],
            ['太原-厦门飞机票','7','1000','7000']
        ];
        $a = mb_detect_encoding(json_encode($cellData,JSON_UNESCAPED_UNICODE), array("ASCII",'UTF-8',"GB2312","GBK",'BIG5'));

        Excel::create('导入账单格式demo',function($excel) use ($cellData){
            $excel->sheet('score', function($sheet) use ($cellData){
                $sheet->setWidth('A', 40);
                $sheet->rows($cellData);
            });
        })->export('xls');
    }*/

    /**
     * 上传excel
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function import(Request $request)
    {
        if($request->file('file')){
            $file_path = Storage::putFile('excel',$request->file('file'));
        }

        return response()->json(['excel'=>$file_path]);
    }

}