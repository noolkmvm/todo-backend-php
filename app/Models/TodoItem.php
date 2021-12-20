<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * App\Models\TodoItem
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property int $done
 * @property-read Collection|TodoList[] $lists
 * @property-read int|null $lists_count
 * @method static Builder|TodoItem newModelQuery()
 * @method static Builder|TodoItem newQuery()
 * @method static Builder|TodoItem query()
 * @method static Builder|TodoItem whereDescription($value)
 * @method static Builder|TodoItem whereDone($value)
 * @method static Builder|TodoItem whereId($value)
 * @method static Builder|TodoItem whereTitle($value)
 * @mixin Eloquent
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
