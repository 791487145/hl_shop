<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 21 Aug 2018 03:47:03 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class CovercharsetBill
 *
 * @property int $id
 * @property int $bill_id
 * @property int $cover_charse_id
 * @package App\Models
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CovercharsetBill whereBillId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CovercharsetBill whereCoverCharseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CovercharsetBill whereId($value)
 * @mixin \Eloquent
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
