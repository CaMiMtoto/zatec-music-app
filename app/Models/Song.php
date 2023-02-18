<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Song
 *
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property int $length
 * @property string|null $file
 * @property string|null $cover_image
 * @property int $genre_id
 * @property int $album_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Album $album
 * @property-read \App\Models\Genre $genre
 * @property-read string $cover_image_url
 * @property-read string $duration
 * @property-read string $file_url
 * @method static \Database\Factories\SongFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Song newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Song newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Song query()
 * @method static \Illuminate\Database\Eloquent\Builder|Song whereAlbumId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Song whereCoverImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Song whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Song whereFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Song whereGenreId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Song whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Song whereLength($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Song whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Song whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Song whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Song extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'length',
        'file',
        'description',
        'genre_id',
        'album_id',
    ];

    protected $appends = [
        'duration',
        'cover_image_url',
        'file_url',
    ];


    public function genre(): BelongsTo
    {
        return $this->belongsTo(Genre::class);
    }

    public function album(): BelongsTo
    {
        return $this->belongsTo(Album::class);
    }

    // cover_image attribute
    public function getCoverImageUrlAttribute($value): string
    {
        return $value ? asset('storage/' . $value) : '';
    }

    // length attribute

    public function getDurationAttribute($value): string
    {
        $minutes = floor($value / 60);
        $seconds = $value % 60;

        return sprintf('%02d:%02d', $minutes, $seconds);
    }

    // file attribute

    public function getFileUrlAttribute($value): string
    {
        return $value ? asset('storage/' . $value) : '';
    }

}
