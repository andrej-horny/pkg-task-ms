<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $tablePrefix = config('pkg-task-ms.table_prefix');

        // tasks
        Schema::create($tablePrefix . 'task_groups', function (Blueprint $table) use ($tablePrefix) {
            $table->comment('List of Task groups');
            $table->id();
            $table->string('code')->nullable(false)->unique();
            $table->string('title');
            $table->string('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        // tasks
        Schema::create($tablePrefix . 'tasks', function (Blueprint $table) use ($tablePrefix) {
            $table->string('id', 26)->primary();
            $table->dateTime('date')->nullable();
            $table->string('title')->nullable();
            $table->string('description')->nullable();
            // $table->dateTime('deadline')->nullable();
            // $table->foreignId('parent_id')
            //     ->nullable()
            //     ->comment('Parent ticket to handle ticket hierarchy.')
            //     ->constrained($tablePrefix . 'tickets', 'id');
            $table->string('group_id', 26)
                ->nullable()
                ->constrained($tablePrefix . 'task_groups', 'id');
            // $table->string('state')
            //     ->nullable()
            //     ->comment("Current ticket state");
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $tablePrefix = config('pkg-task-ms.table_prefix');

        Schema::dropIfExists($tablePrefix . 'task_groups');
    }
};
