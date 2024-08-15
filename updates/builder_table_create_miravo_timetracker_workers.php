<?php namespace Miravo\Timetracker\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateMiravoTimetrackerWorkers extends Migration
{
    public function up()
    {
        Schema::create('miravo_timetracker_workers', function($table)
        {
            $table->increments('id')->unsigned();
            $table->text('first_name')->nullable();
            $table->text('last_name')->nullable();
            $table->text('email')->nullable();
            $table->text('phone')->nullable();
            $table->integer('company_id')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('miravo_timetracker_workers');
    }
}
