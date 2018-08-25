<?php

/**
 * Created by Reliese Model.
 * Date: Sat, 25 Aug 2018 17:57:34 +0800.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class CovercharsetBill
 * 
 * @property int $id
 * @property int $bill_id
 * @property int $cover_charse_id
 *
 * @package App\Models
 */
class CovercharsetBill extends Eloquent
{
	protected $table = 'covercharset_bill';
	protected $primaryKey = 'id';
	public $timestamps = false;

	protected $casts = [
		'bill_id' => 'int',
		'cover_charse_id' => 'int'
	];

	protected $fillable = [
		'bill_id',
		'cover_charse_id'
	];
}
