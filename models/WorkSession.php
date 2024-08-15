<?php namespace Miravo\Timetracker\Models;

use Model;
use Carbon\Carbon;

/**
 * Model
 */
class WorkSession extends Model
{
    use \October\Rain\Database\Traits\Validation;
    use \October\Rain\Database\Traits\SoftDelete;

    /**
     * @var array dates to cast from the database.
     */
    protected $dates = ['check_in_time', 'check_out_time', 'deleted_at'];

    /**
     * @var string table in the database used by the model.
     */
    public $table = 'miravo_timetracker_worksessions';

    /**
     * @var array rules for validation.
     */
    public $rules = [
        'worker' => 'required'
    ];

    public $fillable = [
        'worker_id', 'check_in_time', 'check_out_time', 'is_error'
    ];

    public $belongsTo = [
        'worker' => \Miravo\Timetracker\Models\Worker::class,
    ];

    /**
     * Get the human-readable check-in time.
     *
     * @return string|null
     */
    public function getCheckInTimeHumanAttribute()
    {
        return $this->check_in_time ? Carbon::parse($this->check_in_time)->diffForHumans() : null;
    }

    /**
     * Get the human-readable check-out time.
     *
     * @return string|null
     */
    public function getCheckOutTimeHumanAttribute()
    {
        return $this->check_out_time ? Carbon::parse($this->check_out_time)->diffForHumans() : null;
    }

    /**
     * Check if the work session is from today.
     *
     * @return bool
     */
    public function isSameDay()
    {
        return $this->check_in_time && $this->check_in_time->isSameDay(Carbon::today());
    }

}
