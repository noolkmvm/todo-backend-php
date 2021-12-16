<?php

namespace App\Models;

use Eloquent;
use Database\Factories\UserFactory;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Notifications\DatabaseNotificationCollection;

/**
 * App\Models\User
 *
 * @property int $id
 * @property string $username
 * @property string $password
 * @property-read DatabaseNotificationCollection|DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @method static UserFactory factory(...$parameters)
 * @method static Builder|User newModelQuery()
 * @method static Builder|User newQuery()
 * @method static Builder|User query()
 * @method static Builder|User whereId($value)
 * @method static Builder|User wherePasswordHash($value)
 * @method static Builder|User whereUsername($value)
 * @mixin Eloquent
 */
class User extends Authenticatable implements JWTSubject
{
    use HasFactory;
    use Notifiable;

    public $timestamps = false;

    protected $fillable = [
        'username',
        'password',
    ];

    protected $hidden = ['pivot'];

    public function getJWTIdentifier(): mixed
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims(): array
    {
        return [];
    }

    public function lists(): BelongsToMany
    {
        return $this->belongsToMany(
            TodoList::class,
            'users_lists',
            'user_id',
            'list_id',
        );
    }
}
