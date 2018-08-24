<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 22 Aug 2018 06:22:20 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class BuyerOrder
 *
 * @property int $id
 * @property string $order_no
 * @property int $buyer_id
 * @property float $order_account
 * @property float $order_total
 * @property int $amortize_time
 * @property int $amortize_now
 * @property float $over_cover_charse
 * @property float $cover_charse
 * @property float $has_payment
 * @property string $contract
 * @property int $effective_time
 * @property int $status
 * @property string $created_at
 * @property \Carbon\Carbon $updated_at
 * @package App\Models
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BuyerOrder whereAmortizeNow($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BuyerOrder whereAmortizeTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BuyerOrder whereBuyerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BuyerOrder whereContract($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BuyerOrder whereCoverCharse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BuyerOrder whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BuyerOrder whereEffectiveTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BuyerOrder whereHasPayment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BuyerOrder whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BuyerOrder whereOrderAccount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BuyerOrder whereOrderNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BuyerOrder whereOrderTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BuyerOrder whereOverCoverCharse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BuyerOrder whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BuyerOrder whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class BuyerOrder extends Eloquent
{
    const ORDER_NOT_EFFECT = 0;
    const ORDER_EFFECT = 1;
    const ORDER_END = 2;
    const ORDER_REFUND = 3;


	protected $table = 'buyer_order';
	protected $primaryKey = 'id';
	public $incrementing = false;

	protected $casts = [
		'id' => 'int',
		'buyer_id' => 'int',
		'order_account' => 'float',
		'order_total' => 'float',
		'amortize_time' => 'int',
		'amortize_now' => 'int',
		'over_cover_charse' => 'float',
		'cover_charse' => 'float',
		'has_payment' => 'float',
		'effective_time' => 'int',
		'status' => 'int'
	];

	protected $fillable = [
		'order_no',
		'buyer_id',
		'order_account',
		'order_total',
		'amortize_time',
		'amortize_now',
		'over_cover_charse',
		'cover_charse',
		'has_payment',
		'contract',
		'effective_time',
		'status'
	];
}
