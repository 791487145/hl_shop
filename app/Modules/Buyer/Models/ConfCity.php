<?php

/**
 * Created by Reliese Model.
 * Date: Sat, 25 Aug 2018 17:57:34 +0800.
 */

namespace App\Modules\Buyer\Models;

use Reliese\Database\Eloquent\Model as Eloquent;


/**
 * App\Modules\Buyer\Models\ConfCity
 *
 * @property int $id
 * @property string $name
 * @property string|null $zip_code
 * @property string $path
 * @property int $parent_id
 * @property \Carbon\Carbon $created
 * @property int $state
 * @property string|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Buyer\Models\ConfCity whereCreated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Buyer\Models\ConfCity whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Buyer\Models\ConfCity whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Buyer\Models\ConfCity whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Buyer\Models\ConfCity wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Buyer\Models\ConfCity whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Buyer\Models\ConfCity whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Buyer\Models\ConfCity whereZipCode($value)
 * @mixin \Eloquent
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
