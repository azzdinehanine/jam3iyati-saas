<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('members', function (Blueprint $t) {
            $t->id();
            $t->foreignId('tenant_id')->constrained()->cascadeOnDelete();
            $t->string('cin', 20)->nullable();
            $t->string('name');
            $t->string('lastname');
            $t->string('email')->nullable();
            $t->string('phone', 20)->nullable();
            $t->string('address')->nullable();
            $t->date('birthdate')->nullable();
            $t->enum('gender', ['M','F'])->nullable();
            $t->date('join_date');
            $t->string('role_in_assoc')->nullable();
            $t->enum('status', ['active','inactive','left'])->default('active');
            $t->string('photo')->nullable();
            $t->timestamps();
            $t->index(['tenant_id', 'status']);
        });
    }
    public function down(): void { Schema::dropIfExists('members'); }
};
