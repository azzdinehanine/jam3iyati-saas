<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('regions', function (Blueprint $t) {
            $t->id();
            $t->string('name_ar');
            $t->string('name_fr');
            $t->timestamps();
        });
        Schema::create('provinces', function (Blueprint $t) {
            $t->id();
            $t->foreignId('region_id')->constrained()->cascadeOnDelete();
            $t->string('name_ar');
            $t->string('name_fr');
            $t->timestamps();
        });
        Schema::create('communes', function (Blueprint $t) {
            $t->id();
            $t->foreignId('province_id')->constrained()->cascadeOnDelete();
            $t->string('name_ar');
            $t->string('name_fr');
            $t->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('communes');
        Schema::dropIfExists('provinces');
        Schema::dropIfExists('regions');
    }
};
