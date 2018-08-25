<?php

/**
 * Created by Reliese Model.
 * Date: Sat, 25 Aug 2018 17:57:34 +0800.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Role
 * 
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int $order
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @package App\Models
 */
class Role extends Eloquent
{
	protected $table = 'role';
	protected $primaryKey = 'id';

	protected $casts = [
		'order' => 'int'
	];

	protected $fillable = [
		'name',
		'description',
		'order'
	];
}
