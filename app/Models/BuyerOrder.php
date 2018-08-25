<?php

/**
 * Created by Reliese Model.
 * Date: Sat, 25 Aug 2018 17:57:34 +0800.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class BuyerOrder
 * 
 * @property int $id
 * @property string $order_no
 * @property int $buyer_id
 * @property float $goods_price
 * @property float $order_account
 * @property float $order_total
 * @property int $amortize_time
 * @property int $amortize_now
 * @property string $goods_file
 * @property float $over_cover_charse
 * @property float $cover_charse
 * @property float $has_payment
 * @property string $contract
 * @property int $effective_end_time
 * @property int $effective_time
 * @property int $status
 * @property string $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @package App\Models
 */
class BuyerOrder extends Eloquent
{
	protected $table = 'buyer_order';
	protected $primaryKey = 'id';
	public $incrementing = false;

	protected $casts = [
		'id' => 'int',
		'buyer_id' => 'int',
		'goods_price' => 'float',
		'order_account' => 'float',
		'order_total' => 'float',
		'amortize_time' => 'int',
		'amortize_now' => 'int',
		'over_cover_charse' => 'float',
		'cover_charse' => 'float',
		'has_payment' => 'float',
		'effective_end_time' => 'int',
		'effective_time' => 'int',
		'status' => 'int'
	];

	protected $fillable = [
		'order_no',
		'buyer_id',
		'goods_price',
		'order_account',
		'order_total',
		'amortize_time',
		'amortize_now',
		'goods_file',
		'over_cover_charse',
		'cover_charse',
		'has_payment',
		'contract',
		'effective_end_time',
		'effective_time',
		'status'
	];
}
