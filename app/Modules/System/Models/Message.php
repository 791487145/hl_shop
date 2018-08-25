<?php

/**
 * Created by Reliese Model.
 * Date: Sat, 25 Aug 2018 17:28:24 +0800.
 */

namespace App\Modules\System\Models;

use Reliese\Database\Eloquent\Model as Eloquent;


/**
 * App\Modules\System\Models\Message
 *
 * @property int $id
 * @property int $from_id
 * @property int $to_id
 * @property string $content
 * @property int $ide 1:订单
 * @property int $status 0未读1已读
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\System\Models\Message whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\System\Models\Message whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\System\Models\Message whereFromId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\System\Models\Message whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\System\Models\Message whereIde($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\System\Models\Message whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\System\Models\Message whereToId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\System\Models\Message whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Message extends Eloquent
{
    const IDE_ORDER = 1;

    const STATUS_IS_READ = 1;
    const STATUS_NO_READ = 0;

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
