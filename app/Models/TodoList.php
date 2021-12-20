<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * App\Models\TodoList
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property-read Collection|TodoItem[] $items
 * @property-read int|null $items_count
 * @property-read Collection|User[] $users
 * @property-read int|null $users_count
 * @method static Builder|TodoList newModelQuery()
 * @method static Builder|TodoList newQuery()
 * @method static Builder|TodoList query()
 * @method static Builder|TodoList whereDescription($value)
 * @method static Builder|TodoList whereId($value)
 * @method static Builder|TodoList whereTitle($value)
 * @mixin Eloquent
 */
class TodoList extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'title',
        'description',
    ];

    protected $hidden = ['pivot'];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'users_lists',
            'list_id',
            'user_id',
        );
    }

    public function items(): BelongsToMany
    {
        return $this->belongsToMany(
            TodoItem::class,
            'lists_items',
            'list_id',
            'item_id',
        );
    }
}
