<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 22 Aug 2018 06:22:20 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class BuyerBillFile
 *
 * @property int $id
 * @property int $bill_id
 * @property string $content
 * @property string $refund_file
 * @property int $user_id
 * @property int $status
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @package App\Models
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BuyerBillFile whereBillId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BuyerBillFile whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BuyerBillFile whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BuyerBillFile whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BuyerBillFile whereRefundFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BuyerBillFile whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BuyerBillFile whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BuyerBillFile whereUserId($value)
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
}
