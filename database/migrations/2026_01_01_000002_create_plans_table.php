<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('plans', function (Blueprint $t) {
            $t->id();
            $t->string('name_ar');
            $t->string('name_fr');
            $t->decimal('price_monthly', 8, 2)->default(0);
            $t->decimal('price_yearly', 8, 2)->default(0);
            $t->integer('max_members')->default(30);
            $t->integer('max_projects')->default(5);
            $t->json('features')->nullable();
            $t->boolean('is_active')->default(true);
            $t->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('plans'); }
};
