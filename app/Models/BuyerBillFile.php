<?php

/**
 * Created by Reliese Model.
 * Date: Sat, 25 Aug 2018 17:57:34 +0800.
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
 *
 * @package App\Models
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
