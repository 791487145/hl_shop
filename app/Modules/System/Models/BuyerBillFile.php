<?php

/**
 * Created by Reliese Model.
 * Date: Sat, 25 Aug 2018 17:57:34 +0800.
 */

namespace App\Modules\System\Models;

use Reliese\Database\Eloquent\Model as Eloquent;


/**
 * App\Modules\System\Models\BuyerBillFile
 *
 * @property int $id
 * @property int $bill_id
 * @property string $content 还款备注
 * @property string $refund_file 还款附件
 * @property int $user_id 提交人
 * @property int $status 0未审核；1审核通过；2不通过
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\System\Models\BuyerBillFile whereBillId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\System\Models\BuyerBillFile whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\System\Models\BuyerBillFile whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\System\Models\BuyerBillFile whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\System\Models\BuyerBillFile whereRefundFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\System\Models\BuyerBillFile whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\System\Models\BuyerBillFile whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\System\Models\BuyerBillFile whereUserId($value)
 * @mixin \Eloquent
 * @property-read \App\Modules\System\Models\BuyerBill $bill
 */
class BuyerBillFile extends Eloquent
{
    const STATUS_NOT_CHECK = 0;
    const STATUS_SUCCESS = 1;
    const STATUS_FAIL_CHECK = 2;

	protected $table = 'buyer_bill_file';
	protected $primaryKey = 'id';

	protected $casts = [
		'bill_id' => 'int',
		'user_id' => 'int',
		'status' => 'int'
	];

	protected $fillable = [
		'bill_id',
		'content',
		'refund_file',
		'user_id',
		'status'
	];

	public function bill()
    {
        return $this->hasOne(BuyerBill::class,'bill_id','id');
    }

    static function statusCN($st)
    {
        $status = array(
            self::STATUS_NOT_CHECK => '未审核',
            self::STATUS_SUCCESS => '已通过',
            self::STATUS_FAIL_CHECK => '已拒绝',
        );

        return $status[$st];
    }
}
