<?php

declare(strict_types=1);

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Playlist
 * @package App\Models
 * @version February 21, 2020, 9:44 pm UTC
 *
 * @property Collection playlistItems
 * @property string name
 * @property string description
 */
class Playlist extends Model
{
    use SoftDeletes;

    /**
     * @var string
     */
    public string $table = 'playlists';

    /**
     * @var string
     */
    public const CREATED_AT = 'created_at';

    /**
     * @var string
     */
    public const UPDATED_AT = 'updated_at';


    /**
     * @var array
     */
    protected array $dates = ['deleted_at'];


    /**
     * @var array
     */
    public array $fillable = [
      'name',
      'description'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected array $casts = [
      'id' => 'integer',
      'name' => 'string',
      'description' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static array $rules = [
      'name' => 'required',
      'description' => 'required'
    ];

    /**
     * @return HasMany
     **/
    public function playlistItems(): HasMany
    {
        return $this->hasMany(\App\Models\PlaylistItem::class, 'playlist_id');
    }
}
