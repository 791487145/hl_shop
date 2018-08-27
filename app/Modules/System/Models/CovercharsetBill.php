<?php

/**
 * Created by Reliese Model.
 * Date: Sat, 25 Aug 2018 17:57:34 +0800.
 */

namespace App\Modules\System\Models;

use Reliese\Database\Eloquent\Model as Eloquent;


/**
 * App\Modules\System\Models\CovercharsetBill
 *
 * @property int $id
 * @property int $bill_id 账单id
 * @property int $cover_charse_id 服务费id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\System\Models\CovercharsetBill whereBillId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\System\Models\CovercharsetBill whereCoverCharseId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\System\Models\CovercharsetBill whereId($value)
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
