<?php

/**
 * Created by Reliese Model.
 * Date: Sat, 25 Aug 2018 17:57:34 +0800.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class SystemLog
 * 
 * @property int $id
 * @property string $name
 * @property string $aciton
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @package App\Models
 */
class SystemLog extends Eloquent
{
	protected $table = 'system_log';
	protected $primaryKey = 'id';

	protected $fillable = [
		'name',
		'aciton'
	];
}
