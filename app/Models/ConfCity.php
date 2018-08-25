<?php

/**
 * Created by Reliese Model.
 * Date: Sat, 25 Aug 2018 17:57:34 +0800.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class ConfCity
 * 
 * @property int $id
 * @property string $name
 * @property string $zip_code
 * @property string $path
 * @property int $parent_id
 * @property \Carbon\Carbon $created
 * @property int $state
 * @property \Carbon\Carbon $updated_at
 *
 * @package App\Models
 */
class ConfCity extends Eloquent
{
	protected $table = 'conf_city';
	protected $primaryKey = 'id';
	public $timestamps = false;

	protected $casts = [
		'parent_id' => 'int',
		'state' => 'int'
	];

	protected $dates = [
		'created'
	];

	protected $fillable = [
		'name',
		'zip_code',
		'path',
		'parent_id',
		'created',
		'state'
	];
}
