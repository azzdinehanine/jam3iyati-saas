<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('meetings', function (Blueprint $t) {
            $t->id();
            $t->foreignId('tenant_id')->constrained()->cascadeOnDelete();
            $t->string('title');
            $t->enum('type', ['ordinary','extraordinary','board'])->default('ordinary');
            $t->dateTime('meeting_date');
            $t->string('location')->nullable();
            $t->text('agenda')->nullable();
            $t->longText('minutes')->nullable();
            $t->enum('status', ['scheduled','done','cancelled'])->default('scheduled');
            $t->timestamps();
        });
        Schema::create('meeting_attendances', function (Blueprint $t) {
            $t->id();
            $t->foreignId('meeting_id')->constrained()->cascadeOnDelete();
            $t->foreignId('member_id')->constrained()->cascadeOnDelete();
            $t->boolean('attended')->default(false);
            $t->timestamps();
            $t->unique(['meeting_id','member_id']);
        });
        Schema::create('projects', function (Blueprint $t) {
            $t->id();
            $t->foreignId('tenant_id')->constrained()->cascadeOnDelete();
            $t->string('name');
            $t->text('description')->nullable();
            $t->date('start_date');
            $t->date('end_date')->nullable();
            $t->decimal('budget', 12, 2)->default(0);
            $t->decimal('spent', 12, 2)->default(0);
            $t->enum('status', ['planned','active','completed','cancelled'])->default('planned');
            $t->timestamps();
        });
        Schema::create('documents', function (Blueprint $t) {
            $t->id();
            $t->foreignId('tenant_id')->constrained()->cascadeOnDelete();
            $t->string('name');
            $t->string('type');
            $t->string('file_path');
            $t->foreignId('uploaded_by')->constrained('users');
            $t->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('documents');
        Schema::dropIfExists('projects');
        Schema::dropIfExists('meeting_attendances');
        Schema::dropIfExists('meetings');
    }
};
