<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('tenants', function (Blueprint $t) {
            $t->id();
            $t->string('serial_code', 20)->unique();
            $t->string('name');
            $t->string('email')->unique();
            $t->string('phone', 20);
            $t->string('address');
            $t->string('facebook')->nullable();
            $t->date('founded_at');
            $t->text('goals')->nullable();
            $t->foreignId('region_id')->constrained();
            $t->foreignId('province_id')->constrained();
            $t->foreignId('commune_id')->nullable()->constrained();
            $t->string('logo_path')->nullable();
            $t->string('deposit_receipt_path')->nullable();
            $t->foreignId('plan_id')->nullable()->constrained();
            $t->date('subscription_end')->nullable();
            $t->enum('status', ['pending','active','suspended','rejected'])->default('pending');
            $t->string('locale', 5)->default('ar');
            $t->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('tenants'); }
};
