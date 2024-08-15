<?php namespace Miravo\Timetracker\Models;

use Model;

/**
 * Model
 */
class Company extends Model
{
    use \October\Rain\Database\Traits\Validation;
    use \October\Rain\Database\Traits\SoftDelete;

    /**
     * @var array dates to cast from the database.
     */
    protected $dates = ['deleted_at'];

    /**
     * @var string table in the database used by the model.
     */
    public $table = 'miravo_timetracker_companies';

    /**
     * @var array rules for validation.
     */
    public $rules = [
        'name' => 'required'
    ];
    
    public $hasMany = [
        'workers' => \Miravo\Timetracker\Models\Worker::class
    ];

}
