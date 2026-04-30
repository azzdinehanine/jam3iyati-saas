<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('member_subscriptions', function (Blueprint $t) {
            $t->id();
            $t->foreignId('tenant_id')->constrained()->cascadeOnDelete();
            $t->foreignId('member_id')->constrained()->cascadeOnDelete();
            $t->year('year');
            $t->decimal('amount', 8, 2);
            $t->date('paid_at')->nullable();
            $t->string('receipt_number')->nullable();
            $t->enum('status', ['pending','paid','exempted'])->default('pending');
            $t->text('notes')->nullable();
            $t->timestamps();
            $t->unique(['tenant_id','member_id','year']);
        });
        Schema::create('transactions', function (Blueprint $t) {
            $t->id();
            $t->foreignId('tenant_id')->constrained()->cascadeOnDelete();
            $t->enum('type', ['income','expense']);
            $t->string('category');
            $t->decimal('amount', 10, 2);
            $t->string('description');
            $t->date('transaction_date');
            $t->string('receipt_file')->nullable();
            $t->foreignId('created_by')->constrained('users');
            $t->timestamps();
            $t->index(['tenant_id', 'type', 'transaction_date']);
        });
    }
    public function down(): void {
        Schema::dropIfExists('transactions');
        Schema::dropIfExists('member_subscriptions');
    }
};
