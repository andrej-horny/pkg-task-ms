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
         *  tms_ticket_types
         * ---------------------------------------------------------
         */
        Schema::create('tms_ticket_types', function (Blueprint $table) {
            // ULID PK with comment
            $table->ulid('id')
                ->primary()
                ->comment('ULID');

            $table->string('uri')
                ->unique()
                ->comment('URI to identify record in application layer');

            $table->string('title')
                ->nullable();

            $table->timestamps();
            $table->softDeletes();
        });

        /**
         * ---------------------------------------------------------
         *  tms_tickets
         * ---------------------------------------------------------
         */
        Schema::create('tms_tickets', function (Blueprint $table) {
            // ULID PK with comment
            $table->ulid('id')
                ->primary()
                ->comment('ULID');

            $table->date('date')->nullable();

            $table->text('description')
                ->nullable()
                ->comment('Ticket description');

            $table->ulid('type_id')
                ->nullable()
                ->comment('Ticket type');

            $table->ulid('subject_id')
                ->nullable()
                ->comment('Entity responsible for this ticket e.g. maintenance group, department, ...');

            $table->string('subject_type')
                ->nullable()
                ->comment('Morph class of related polymorphic record. Determines respective database table holding records of this type.');

            $table->string('state')
                ->nullable()
                ->comment('Current ticket state');

            $table->unsignedBigInteger('author_id')
                ->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Foreign key constraint (same as in dump)
            $table->foreign('type_id', 'FK_tms_tickets_tms_ticket_types')
                ->references('id')
                ->on('tms_ticket_types')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tms_tickets');
        Schema::dropIfExists('tms_ticket_types');
    }
};
