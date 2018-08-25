<?php

/**
 * Created by Reliese Model.
 * Date: Sat, 25 Aug 2018 17:57:34 +0800.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class AuthMenu
 * 
 * @property int $id
 * @property string $name
 * @property string $url
 * @property int $parent_id
 * @property int $status
 * @property int $order
 * @property int $tier
 * @property string $title
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @package App\Models
 */
class AuthMenu extends Eloquent
{
	protected $table = 'auth_menu';
	protected $primaryKey = 'id';

	protected $casts = [
		'parent_id' => 'int',
		'status' => 'int',
		'order' => 'int',
		'tier' => 'int'
	];

	protected $fillable = [
		'name',
		'url',
		'parent_id',
		'status',
		'order',
		'tier',
		'title'
	];
}
