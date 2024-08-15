<?php namespace Miravo\Timetracker\Models;

use Model;

/**
 * Model
 */
class Worker extends Model
{
    use \October\Rain\Database\Traits\Validation;
    use \October\Rain\Database\Traits\SoftDelete;
    use \October\Rain\Database\Traits\Nullable;

    /**
     * @var array dates to cast from the database.
     */
    protected $dates = ['deleted_at'];

    /**
     * @var string table in the database used by the model.
     */
    public $table = 'miravo_timetracker_workers';

    /**
     * @var array rules for validation.
     */
    public $rules = [
        'code' => 'required'
    ];

    public $nullable = [
        'code'
    ];

    public $belongsTo = [
        'company' => \Miravo\Timetracker\Models\Company::class
    ];

    public $hasMany = [
        'workSessions' => \Miravo\Timetracker\Models\WorkSession::class
    ];

    public function filterFields($fields, $context) {
        if ($context == 'create') {
            $codeAlreadyUsed = self::pluck('code')->toArray();
    
            do {
                $newCode = $this->generateCustomCode();
            } while (in_array($newCode, $codeAlreadyUsed));
    
            $fields->code->value = $newCode;
        }
    }
    
    private function generateCustomCode() {
        $colors = ['Red', 'Blue', 'Green', 'Yellow', 'Purple', 'Orange', 'Pink', 'Black', 'White', 'Grey'];
        $objects = ['Car', 'Tree', 'House', 'Boat', 'Plane', 'Ball', 'Book', 'Phone', 'Chair', 'Clock'];
        
        $randomColor = $colors[array_rand($colors)];
        $randomObject = $objects[array_rand($objects)];
        $randomNumber = rand(1, 9);
    
        return $randomColor . $randomObject . $randomNumber;
    }

    public function getNameAttribute() {
        return $this->first_name . ' ' . $this->last_name;
    }

}
