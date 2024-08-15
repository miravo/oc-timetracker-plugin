<?php namespace Miravo\Timetracker\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateMiravoTimetrackerWorksessions extends Migration
{
    public function up()
    {
        Schema::create('miravo_timetracker_worksessions', function($table)
        {
            $table->increments('id')->unsigned();
            $table->integer('worker_id')->nullable();
            $table->dateTime('check_in_time')->nullable();
            $table->dateTime('check_out_time')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('miravo_timetracker_worksessions');
    }
}
