<?php

/**
 * Created by Reliese Model.
 * Date: Sat, 25 Aug 2018 17:57:34 +0800.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class CoverCharse
 * 
 * @property int $id
 * @property float $over_service_num
 * @property float $service_num
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @package App\Models
 */
class CoverCharse extends Eloquent
{
	protected $table = 'cover_charse';
	protected $primaryKey = 'id';
	public $incrementing = false;

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
