<?php

/**
 * Created by Reliese Model.
 * Date: Tue, 14 Aug 2018 10:52:36 +0000.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class AuthMenu
 * 
 * @property int $id
 * @property string $name
 * @property int $parent_id
 * @property int $status
 * @property string $title
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @package App\Models
 */
class AuthMenu extends Eloquent
{
	protected $table = 'auth_menu';

	protected $casts = [
		'parent_id' => 'int',
		'status' => 'int'
	];

	protected $fillable = [
		'name',
		'parent_id',
		'status',
		'title'
	];
}