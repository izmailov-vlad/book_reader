<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Book
 *
 * @property int $id
 * @property string $googleBookId
 * @property string $title
 * @property string $publishedDate
 * @property string $description
 * @property int $pageCount
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static Builder|Book newModelQuery()
 * @method static Builder|Book newQuery()
 * @method static Builder|Book query()
 * @method static Builder|Book whereCreatedAt($value)
 * @method static Builder|Book whereDescription($value)
 * @method static Builder|Book whereGoogleBookId($value)
 * @method static Builder|Book whereId($value)
 * @method static Builder|Book wherePageCount($value)
 * @method static Builder|Book wherePublishedDate($value)
 * @method static Builder|Book whereTitle($value)
 * @method static Builder|Book whereUpdatedAt($value)
 * @property string $ratingsCount
 * @method static Builder|Book whereRatingsCount($value)
 * @mixin \Eloquent
 */
class Book extends Model
{
    use HasFactory;

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function isRatedByUser(User $user)
    {
        return $this->ratings()->where('user_id', $user->id)->exists();
    }

    protected $fillable = [
        'id',
        'title',
        'publishedDate',
        'description',
        'pageCount',
        'ratingsCount',
    ];
}
