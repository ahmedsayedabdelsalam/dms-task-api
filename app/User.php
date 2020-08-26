<?php

namespace App;

use App\Contracts\Scopes\WithRequestQueryBuilder;
use Facade\Ignition\QueryRecorder\Query;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Spatie\QueryBuilder\AllowedInclude;
use Spatie\QueryBuilder\QueryBuilder;

class User extends Model implements WithRequestQueryBuilder
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'second_name', 'family_name', 'uuid', 'accepted'
    ];

    protected $casts = [
        'accepted' => 'boolean'
    ];

    public function ownUuid()
    {
        return $this->hasOne(Uuid::class, 'uuid', 'uuid');
    }

    public function scopeAccepted(Builder $query)
    {
        return $query->where('accepted', true);
    }

    public function scopeRejected(Builder $query)
    {
        return $query->where('accepted', false);
    }

    public function scopeUsingRequestQueryBuilder(): QueryBuilder
    {
        return QueryBuilder::for(self::class)
            ->allowedFilters(
                [
                    'first_name',
                    'second_name',
                    'family_name',
                    'uuid'
                ]
            )->allowedSorts(
                [
                    'first_name',
                    'second_name',
                    'family_name',
                    'uuid'
                ]
            );
    }
}
