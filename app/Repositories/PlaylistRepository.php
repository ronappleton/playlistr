<?php

namespace App\Repositories;

use App\Models\Playlist;
use App\Repositories\BaseRepository;

/**
 * Class PlaylistRepository
 * @package App\Repositories
 * @version February 21, 2020, 9:44 pm UTC
*/

class PlaylistRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'description'
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
        return Playlist::class;
    }
}
