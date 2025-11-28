<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        /**
         * ---------------------------------------------------------
         *  tms_places_of_occurence
         * ---------------------------------------------------------
         */
        Schema::create('tms_places_of_occurence', function (Blueprint $table) {
            $table->ulid('id')->primary()->comment('ULID');
            $table->string('uri', 50)->unique()->comment('URI to identify record in application layer');
            $table->string('title', 50)->nullable();
            $table->string('description', 255)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        /**
         * ---------------------------------------------------------
         *  tms_task_groups
         * ---------------------------------------------------------
         */
        Schema::create('tms_task_groups', function (Blueprint $table) {
            $table->ulid('id')->primary()->comment('ULID');
            $table->string('uri', 50)->unique()->comment('URI to identify record in application layer');
            $table->string('title', 50)->nullable();
            $table->string('description', 255)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        /**
         * ---------------------------------------------------------
         *  tms_task_item_groups
         * ---------------------------------------------------------
         */
        Schema::create('tms_task_item_groups', function (Blueprint $table) {
            $table->ulid('id')->primary()->comment('ULID');
            $table->string('code')->nullable()->comment('URI to identify record in application layer');
            $table->string('title')->nullable();
            $table->ulid('task_group_id')->nullable()->comment('Task item group for hierarchical structuring of groups');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('task_group_id', 'FK_tms_task_item_groups_tms_task_groups')
                ->references('id')
                ->on('tms_task_groups')
                ->nullOnDelete();

            $table->comment('List of ticket item groups e.g. activity templates, inspection templates, ...');
        });

        /**
         * ---------------------------------------------------------
         *  tms_tasks
         * ---------------------------------------------------------
         */
        Schema::create('tms_tasks', function (Blueprint $table) {
            $table->ulid('id')->primary()->comment('ULID');
            $table->date('date')->nullable();
            $table->string('title', 50)->nullable();
            $table->ulid('group_id')->nullable()->comment('Task group');
            $table->string('description', 255)->nullable();
            $table->ulid('subject_id')->nullable()->comment('Entity belonging to this task e.g. vehicle, building, ...');
            $table->string('subject_type')->nullable()->comment('Morph class of related polymorphic record. Determines respective database table holding records of this type.');
            $table->ulid('assigned_to_id')->nullable()->comment('Entity responsible for this task e.g. maintenance group, department, ...');
            $table->string('assigned_to_type')->nullable()->comment('Morph class of related polymorphic record. Determines respective database table holding records of this type.');
            $table->ulid('place_of_occurence_id')->nullable()->comment('Place of occurence');
            $table->unsignedBigInteger('author_id')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('group_id', 'FK_tms_tasks_tms_task_groups')
                ->references('id')
                ->on('tms_task_groups')
                ->nullOnDelete();

            $table->foreign('place_of_occurence_id', 'FK_tms_tasks_tms_places_of_occurence')
                ->references('id')
                ->on('tms_places_of_occurence')
                ->nullOnDelete();                
        });

        /**
         * ---------------------------------------------------------
         *  tms_task_items
         * ---------------------------------------------------------
         */
        Schema::create('tms_task_items', function (Blueprint $table) {
            $table->ulid('id')->primary()->comment('ULID');
            $table->dateTime('date')->nullable();
            $table->ulid('task_id')->nullable()->comment('Parent task');
            $table->string('title', 255)->nullable();
            $table->string('description', 255)->nullable();
            $table->string('state')->nullable()->comment('Current task item state');
            $table->ulid('group_id')->nullable()->comment('Task item group');
            $table->ulid('assigned_to_id')->nullable()->comment('Entity responsible for this task item e.g. maintenance group, department, ...');
            $table->string('assigned_to_type')->nullable()->comment('Morph class of related polymorphic record. Determines respective database table holding records of this type.');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('task_id', 'FK_tms_task_items_tms_tasks')
                ->references('id')
                ->on('tms_tasks')
                ->nullOnDelete();

            $table->foreign('group_id', 'FK_tms_task_items_tms_task_item_groups')
                ->references('id')
                ->on('tms_task_item_groups')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tms_task_items');
        Schema::dropIfExists('tms_tasks');
        Schema::dropIfExists('tms_task_item_groups');
        Schema::dropIfExists('tms_task_groups');
        Schema::dropIfExists('tms_places_of_occurence');
    }
};
