<?php

/**
 * Created by Reliese Model.
 * Date: Sat, 25 Aug 2018 17:57:34 +0800.
 */

namespace App\Modules\System\Models;

use Reliese\Database\Eloquent\Model as Eloquent;


/**
 * App\Modules\System\Models\CoverCharse
 *
 * @property int $id
 * @property float $over_service_num 逾期服务费数额
 * @property float $service_num 服务费金额
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\System\Models\CoverCharse whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\System\Models\CoverCharse whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\System\Models\CoverCharse whereOverServiceNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\System\Models\CoverCharse whereServiceNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\System\Models\CoverCharse whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class CoverCharse extends Eloquent
{
	protected $table = 'cover_charse';
	protected $primaryKey = 'id';
	public $incrementing = true;

	protected $casts = [
		'id' => 'int',
		'over_service_num' => 'float',
		'service_num' => 'float'
	];

	protected $fillable = [
		'over_service_num',
		'service_num'
	];
}
