<?php

/**
 * Created by Reliese Model.
 * Date: Sat, 25 Aug 2018 17:57:34 +0800.
 */

namespace App\Modules\System\Models;

use Reliese\Database\Eloquent\Model as Eloquent;


/**
 * App\Modules\System\Models\BuyerOrderBill
 *
 * @property int $id
 * @property int $order_no 订单编号
 * @property int $order_sn 账单编号
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\System\Models\BuyerOrderBill whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\System\Models\BuyerOrderBill whereOrderNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\System\Models\BuyerOrderBill whereOrderSn($value)
 * @mixin \Eloquent
 */
class BuyerOrderBill extends Eloquent
{
	protected $table = 'buyer_order_bill';
	protected $primaryKey = 'id';
	public $timestamps = false;

	protected $casts = [
		'order_no' => 'int',
		'order_sn' => 'int'
	];

	protected $fillable = [
		'order_no',
		'order_sn'
	];
}
