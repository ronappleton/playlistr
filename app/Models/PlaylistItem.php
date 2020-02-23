<?php

declare(strict_types=1);

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class PlaylistItem
 *
 * @package App\Models
 * @version February 21, 2020, 9:44 pm UTC
 * @property Playlist playlist
 * @property integer  playlist_id
 * @property string   name
 * @property string   url
 * @property string   media
 * @property bool     active
 */
class PlaylistItem extends Model
{
    use SoftDeletes;

    /**
     * @var string
     */
    public string $table = 'playlist_items';

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
      'playlist_id',
      'name',
      'url',
      'media_item',
      'active',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected array $casts = [
      'id' => 'integer',
      'playlist_id' => 'integer',
      'name' => 'string',
      'url' => 'string',
      'media' => 'array',
      'active' => 'bool',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static array $rules = [
      'playlist_id' => 'required',
      'name' => 'required',
      'url' => 'required',
    ];

    /**
     * @return BelongsTo
     **/
    public function playlist(): BelongsTo
    {
        return $this->belongsTo(Playlist::class, 'playlist_id');
    }


    /**
     * @return $this
     */
    public function toggleActive()
    {
        $this->active = !$this->active;
        return $this;
    }
}
