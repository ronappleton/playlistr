<?php

declare(strict_types=1);

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class ApiRoute
 * @package App\Models
 * @version February 22, 2020, 9:54 pm UTC
 *
 * @property string route
 * @property string description
 * @property boolean active
 */
class ApiRoute extends Model
{
    use SoftDeletes;

    public string $table = 'api_routes';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected array $dates = ['deleted_at'];


    public array $fillable = [
      'route',
      'description',
      'active'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected array $casts = [
      'id' => 'integer',
      'route' => 'string',
      'description' => 'string',
      'active' => 'boolean'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static array $rules = [
      'route' => 'required',
      'description' => 'required',
      'active' => 'required'
    ];

    /**
     * @return $this
     */
    public function toggleActive()
    {
        $this->active = !$this->active;
        return $this;
    }
}
