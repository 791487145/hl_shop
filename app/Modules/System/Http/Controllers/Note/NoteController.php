<?php
namespace App\Modules\System\Http\Controllers\Note;

use App\Modules\System\Models\BuyerBill;
use App\Modules\System\Models\BuyerBillFile;
use App\Modules\System\Models\BuyerOrder;
use App\Modules\System\Models\BuyerOrderBill;
use App\Modules\System\Models\BuyerOrderDetail;
use App\Modules\System\Http\Controllers\SystemController;
use App\Modules\System\Models\CoverCharse;
use App\Modules\System\Models\Message;
use App\Modules\System\Models\Note;
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


class NoteController extends SystemController
{


    public function noteList(Request $request)
    {
        $role = Auth::user()->roles()->first();
        if($role->id != $this->shopeeker && $role->id != $this->buyer){
            $notes = Note::whereStatus(Note::STATUS_NOT_REDA)->whereToId(0)->forPage($request->post('page',1),$request->post('limit',$this->limit))->get();
        }else{
            $notes = Note::whereStatus(Note::STATUS_NOT_REDA)->whereToId(Auth::id())->forPage($request->post('page',1),$request->post('limit',$this->limit))->get();
        }

        return $this->formatResponse('获取成功',$this->successStatus,$notes);
    }

    public function noteInfo(Request $request)
    {
        $note = Note::whereId($request->post('note_id'))->first();
        return $this->formatResponse('获取成功',$this->successStatus,$note);
    }

    public function noteReplay(Request $request)
    {
        $note = new Note();
        $note->from_id = Auth::id();
        $note->to_id = $request->post('to_id');
        $note->content = $request->post('content');
        $note->title = $request->post('title');
        $note->save();
        return $this->formatResponse('操作成功',$this->successStatus);
    }

    public function noteIssue(Request $request)
    {
        $note = new Note();
        $note->from_id = Auth::id();
        $note->to_id = 0;
        $note->content = $request->post('content');
        $note->title = $request->post('title');
        $note->save();

        return $this->formatResponse('操作成功',$this->successStatus);
    }










}