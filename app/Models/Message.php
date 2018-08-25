<?php

/**
 * Created by Reliese Model.
 * Date: Sat, 25 Aug 2018 17:57:34 +0800.
 */

namespace App\Models;

use Reliese\Database\Eloquent\Model as Eloquent;

/**
 * Class Message
 * 
 * @property int $id
 * @property int $from_id
 * @property int $to_id
 * @property string $content
 * @property int $ide
 * @property int $status
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @package App\Models
 */
class Message extends Eloquent
{
	protected $table = 'message';
	protected $primaryKey = 'id';

	protected $casts = [
		'from_id' => 'int',
		'to_id' => 'int',
		'ide' => 'int',
		'status' => 'int'
	];

	protected $fillable = [
		'from_id',
		'to_id',
		'content',
		'ide',
		'status'
	];
}
