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
 */
class BuyerBillFile extends Eloquent
{
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

    static function statusCN($st)
    {
        $status = array(
            self::STATUS_NOT_PAY => '未还款',
            self::STATUS_PAY => '已还款',
            self::STATUS_OVER_NOT_PAY => '逾期未还',
            self::STATUS_OVER_PAY => '逾期已还'
        );

        return $status[$st];
    }
}
