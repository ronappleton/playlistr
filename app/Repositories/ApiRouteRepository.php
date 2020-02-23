<?php

namespace App\Repositories;

use App\Models\ApiRoute;
use App\Repositories\BaseRepository;

/**
 * Class ApiRouteRepository
 * @package App\Repositories
 * @version February 22, 2020, 9:54 pm UTC
*/

class ApiRouteRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'route',
        'description',
        'active'
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
        return ApiRoute::class;
    }
}
