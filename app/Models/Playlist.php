<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Playlist
 * @package App\Models
 * @version February 21, 2020, 9:44 pm UTC
 *
 * @property \Illuminate\Database\Eloquent\Collection playlistItems
 * @property string name
 * @property string description
 */
class Playlist extends Model
{
    use SoftDeletes;

    public $table = 'playlists';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];



    public $fillable = [
        'name',
        'description'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'name' => 'string',
        'description' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required',
        'description' => 'required'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function playlistItems()
    {
        return $this->hasMany(\App\Models\PlaylistItem::class, 'playlist_id');
    }
}
