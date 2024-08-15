<?php namespace Miravo\Timetracker\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateMiravoTimetrackerWorksessions extends Migration
{
    public function up()
    {
        Schema::table('miravo_timetracker_worksessions', function($table)
        {
            $table->integer('is_error')->nullable();
        });
    }
    
    public function down()
    {
        Schema::table('miravo_timetracker_worksessions', function($table)
        {
            $table->dropColumn('is_error');
        });
    }
}
