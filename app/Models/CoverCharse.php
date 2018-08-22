<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 22 Aug 2018 06:22:20 +0000.
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
 * @package App\Models
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CoverCharse whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CoverCharse whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CoverCharse whereOverServiceNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CoverCharse whereServiceNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\CoverCharse whereUpdatedAt($value)
 * @mixin \Eloquent
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
