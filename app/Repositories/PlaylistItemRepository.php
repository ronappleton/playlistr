<?php

namespace App\Repositories;

use App\Models\PlaylistItem;
use App\Repositories\BaseRepository;

/**
 * Class PlaylistItemRepository
 * @package App\Repositories
 * @version February 21, 2020, 9:44 pm UTC
*/

class PlaylistItemRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'playlist_id',
        'name',
        'url'
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return PlaylistItem::class;
    }
}
