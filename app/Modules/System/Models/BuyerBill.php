<?php

/**
 * Created by Reliese Model.
 * Date: Sat, 25 Aug 2018 17:57:34 +0800.
 */

namespace App\Modules\System\Models;

use Reliese\Database\Eloquent\Model as Eloquent;


/**
 * App\Modules\System\Models\BuyerBill
 *
 * @property int $id
 * @property string $order_sn 账单编号
 * @property float $month_account 月应还款总额
 * @property float $refund_account 实际还款总额
 * @property float $over_cover_charse
 * @property float $cover_charse 服务费
 * @property int $status 0未还款；1已还款；2逾期未还；3逾期已还
 * @property int $end_time 账单结束日期
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\System\Models\BuyerBill whereCoverCharse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\System\Models\BuyerBill whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\System\Models\BuyerBill whereEndTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\System\Models\BuyerBill whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\System\Models\BuyerBill whereMonthAccount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\System\Models\BuyerBill whereOrderSn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\System\Models\BuyerBill whereOverCoverCharse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\System\Models\BuyerBill whereRefundAccount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\System\Models\BuyerBill whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\System\Models\BuyerBill whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property int|null $amortize_time 第几期账单
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\System\Models\BuyerBillFile[] $bill_file
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\System\Models\BuyerBill whereAmortizeTime($value)
 */
class BuyerBill extends Eloquent
{
    const STATUS_NOT_PAY = 0;
    const STATUS_PAY = 1;
    const STATUS_OVER_NOT_PAY = 2;
    const STATUS_OVER_PAY = 3;

	protected $table = 'buyer_bill';
	protected $primaryKey = 'id';

	protected $casts = [
		'month_account' => 'float',
		'refund_account' => 'float',
		'over_cover_charse' => 'float',
		'cover_charse' => 'float',
		'status' => 'int',
		'end_time' => 'int'
	];

	protected $fillable = [
		'order_sn',
		'month_account',
		'refund_account',
		'over_cover_charse',
		'cover_charse',
		'status',
		'end_time'
	];

	//账单对应服务费
	public function cover_charse()
    {
        return $this->belongsToMany(CoverCharse::class,'covercharset_bill','bill_id','cover_charse_id');
    }

    //账单添加服务费
    public function assignCovercharse($cover_charse)
    {
        return $this->cover_charse()->sync($cover_charse);
    }

    public function bill_file()
    {
        return $this->hasMany(BuyerBillFile::class,'bill_id','id');
    }

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
