<?php

/**
 * Created by Reliese Model.
 * Date: Sat, 25 Aug 2018 17:57:34 +0800.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class BuyerOrderBill
 * 
 * @property int $id
 * @property int $order_no
 * @property int $order_sn
 *
 * @package App\Models
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
