<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * App\Models\TodoItem
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property int $done
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\TodoList[] $lists
 * @property-read int|null $lists_count
 * @method static \Illuminate\Database\Eloquent\Builder|TodoItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TodoItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TodoItem query()
 * @method static \Illuminate\Database\Eloquent\Builder|TodoItem whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TodoItem whereDone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TodoItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TodoItem whereTitle($value)
 * @mixin \Eloquent
 */
class TodoItem extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'title',
        'description',
    ];

    protected $hidden = ['pivot'];

    public function lists(): BelongsToMany
    {
        return $this->belongsToMany(
            TodoList::class,
            'lists_items',
            'item_id',
            'list_id',
        );
    }
}
