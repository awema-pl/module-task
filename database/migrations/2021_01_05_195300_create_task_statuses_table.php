
<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use AwemaPL\Task\User\Sections\Statuses\Services\TaskStatus;

class CreateTaskStatusesTable extends Migration
{
    public function up()
    {
        Schema::create(config('task.database.tables.task_statuses'), function (Blueprint $table) {
            $table->id();
            $table->nullableMorphs('taskable', 'C261O9KKXO87QQLZJKM7AA');
            $table->string('type')->index();
            $table->string('type_key')->nullable();
            $table->boolean('interrupt')->default(0)->index();
            $table->string('status')->default(TaskStatus::QUEUED)->index();
            $table->string('status_detail_key')->nullable();
            $table->json('status_detail_placeholders')->nullable();
            $table->mediumText('error')->nullable();
            $table->timestamps();
        });

        Schema::table(config('task.database.tables.task_statuses'), function (Blueprint $table) {
            $table->foreignId('user_id')
                ->constrained(config('task.database.tables.users'))
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table(config('task.database.tables.task_statuses'), function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });

        Schema::drop(config('task.database.tables.task_statuses'));
    }
}
