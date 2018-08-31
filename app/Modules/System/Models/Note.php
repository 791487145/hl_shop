<?php

/**
 * Created by Reliese Model.
 * Date: Fri, 31 Aug 2018 14:40:35 +0800.
 */

namespace App\Modules\System\Models;

use Reliese\Database\Eloquent\Model as Eloquent;


/**
 * App\Modules\System\Models\Note
 *
 * @property int $id
 * @property int $from_id
 * @property int $to_id
 * @property string|null $title
 * @property string|null $content
 * @property int $status 1已读0未读
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\System\Models\Note whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\System\Models\Note whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\System\Models\Note whereFromId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\System\Models\Note whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\System\Models\Note whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\System\Models\Note whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\System\Models\Note whereToId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\System\Models\Note whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Note extends Eloquent
{
    const STATUS_IS_READ = 1;
    const STATUS_NOT_REDA = 0;

	protected $table = 'note';
	protected $primaryKey = 'id';
	public $incrementing = true;

	protected $casts = [
		'from_id' => 'int',
		'to_id' => 'int',
		'status' => 'int'
	];

	protected $fillable = [
		'from_id',
		'to_id',
		'title',
		'content',
		'status'
	];
}
