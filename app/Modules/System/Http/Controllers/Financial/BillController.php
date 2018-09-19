<?php
namespace App\Modules\System\Http\Controllers\Financial;

use App\Modules\System\Models\BuyerBill;
use App\Modules\System\Models\BuyerBillFile;
use App\Modules\System\Models\BuyerOrder;
use App\Modules\System\Models\BuyerOrderBill;
use App\Modules\System\Models\BuyerOrderDetail;
use App\Modules\System\Http\Controllers\SystemController;
use App\Modules\System\Models\CoverCharse;
use App\Modules\System\Models\Message;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;
use Validator;
use Log;
use DB;
use Storage;
use Excel;


class BillController extends SystemController
{
    public function billfileList(Request $request)
    {
        $bill_files = BuyerBillFile::whereStatus(BuyerBillFile::STATUS_NOT_CHECK)->forPage($request->post('page',1),$request->post('limit',$this->limit))->get();
        foreach ($bill_files as $bill_file){
            $bill = $bill_file->bill()->first();
            $bill_file->bill_order_sn = $bill->order_sn;
            $bill_file->statusCN = BuyerBillFile::statusCN($bill_file->status);
        }

        $data = array(
            'count' => count($bill_files),
            'bill_files' => $bill_files
        );
        return $this->formatResponse('获取成功',$this->successStatus,$data);
    }

    /**
     * 账单附件提交
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function billFileSubmit(Request $request)
    {
        $bill_file = BuyerBillFile::whereBillId($request->post('bill_id'))->whereIn('status',[BuyerBillFile::STATUS_SUCCESS,BuyerBillFile::STATUS_NOT_CHECK])->first();
        if(!is_null($bill_file)){
            return $this->formatResponse('该账单附件已经提交，请勿重复提交',$this->errorStatus);
        }
        $bill_file = new BuyerBillFile();
        $bill_file->user_id = Auth::id();
        $bill_file->status = BuyerBillFile::STATUS_SUCCESS;
        $bill_file->content = $request->post('content','');
        $bill_file->bill_id = $request->post('bill_id');
        $bill_file->refund_file = $request->post('refund_file');
        $bill_file->save();

        return $this->formatResponse('提交成功',$this->successStatus);
    }

    /**
     * 更改文件附件状态
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function billFileStatusChange(Request $request)
    {
        $bill_file_id = $request->post('bill_file_id');
        BuyerBillFile::whereId($bill_file_id)->update(['status'=> $request->post('status')]);
        return $this->formatResponse('操作成功',$this->successStatus);
    }

    /**
     * 服务费列表
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function covercharseList(Request $request)
    {
        $cover_charse = BuyerBill::whereStatus(BuyerBill::STATUS_PAY)->forPage($request->post('page',1),$request->post('limit',$this->limit))->get();

        $data = array(
            'count' => count($cover_charse),
            'cover_charse' => $cover_charse
        );
        return $this->formatResponse('获取成功',$this->successStatus,$data);
    }








}