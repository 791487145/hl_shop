<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 21 Aug 2018 03:47:03 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class BuyerBill
 *
 * @property int $id
 * @property string $order_sn
 * @property float $month_account
 * @property float $refund_account
 * @property float $over_cover_charse
 * @property float $cover_charse
 * @property int $status
 * @property int $end_time
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @package App\Models
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BuyerBill whereCoverCharse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BuyerBill whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BuyerBill whereEndTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BuyerBill whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BuyerBill whereMonthAccount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BuyerBill whereOrderSn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BuyerBill whereOverCoverCharse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BuyerBill whereRefundAccount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BuyerBill whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BuyerBill whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class BuyerBill extends Eloquent
{
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
}
