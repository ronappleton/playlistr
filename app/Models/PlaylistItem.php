<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class PlaylistItem
 * @package App\Models
 * @version February 21, 2020, 9:44 pm UTC
 *
 * @property \App\Models\Playlist playlist
 * @property integer playlist_id
 * @property string name
 * @property string url
 */
class PlaylistItem extends Model
{
    use SoftDeletes;

    public $table = 'playlist_items';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'playlist_id',
        'name',
        'url'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'playlist_id' => 'integer',
        'name' => 'string',
        'url' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'playlist_id' => 'required',
        'name' => 'required',
        'url' => 'required'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function playlist()
    {
        return $this->belongsTo(\App\Models\Playlist::class, 'playlist_id');
    }
}
