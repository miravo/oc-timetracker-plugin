<?php namespace Miravo\Expensetracker\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class UpdateMiravoTimetrackerWorkers1 extends Migration
{
    public function up()
    {
        Schema::table('miravo_timetracker_workers', function($table)
        {
            $table->string('code')->nullable()->unique();
        });

    }
    
    public function down()
    {
        Schema::table('miravo_timetracker_workers', function($table)
        {
            $table->dropColumn('code');
        });
    }
}
