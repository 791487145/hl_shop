<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 22 Aug 2018 06:22:20 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class BuyerOrderBill
 *
 * @property int $id
 * @property int $order_no
 * @property int $order_sn
 * @package App\Models
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BuyerOrderBill whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BuyerOrderBill whereOrderNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BuyerOrderBill whereOrderSn($value)
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
