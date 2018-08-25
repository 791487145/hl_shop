<?php

/**
 * Created by Reliese Model.
 * Date: Sat, 25 Aug 2018 17:57:34 +0800.
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
 *
 * @package App\Models
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
