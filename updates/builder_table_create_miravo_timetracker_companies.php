<?php namespace Miravo\Timetracker\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateMiravoTimetrackerCompanies extends Migration
{
    public function up()
    {
        Schema::create('miravo_timetracker_companies', function($table)
        {
            $table->increments('id')->unsigned();
            $table->text('name')->nullable();
            $table->text('address')->nullable();
            $table->text('contact_person')->nullable();
            $table->text('contact_email')->nullable();
            $table->text('contact_phone')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('miravo_timetracker_companies');
    }
}
