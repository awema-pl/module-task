
<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use AwemaPL\Task\User\Sections\Statuses\Services\TaskStatus;

class AddIndexCreatedAtTaskStatusesTable extends Migration
{
    public function up()
    {
        Schema::table(config('task.database.tables.task_statuses'), function (Blueprint $table) {
            $table->index(['created_at']);
        });
    }

    public function down()
    {
        Schema::table(config('task.database.tables.task_statuses'), function (Blueprint $table) {
            $table->dropIndex(['created_at']);
        });
    }
}
