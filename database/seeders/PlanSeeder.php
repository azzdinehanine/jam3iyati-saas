<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Plan;
class PlanSeeder extends Seeder {
    public function run(): void {
        $plans = [
            ['name_ar' => 'مجاني', 'name_fr' => 'Gratuit', 'price_monthly' => 0, 'price_yearly' => 0, 'max_members' => 30, 'max_projects' => 3, 'features' => ['basic']],
            ['name_ar' => 'أساسي', 'name_fr' => 'Basique', 'price_monthly' => 99, 'price_yearly' => 990, 'max_members' => 100, 'max_projects' => 10, 'features' => ['basic','reports']],
            ['name_ar' => 'متقدم', 'name_fr' => 'Avance', 'price_monthly' => 199, 'price_yearly' => 1990, 'max_members' => 500, 'max_projects' => 50, 'features' => ['all']],
            ['name_ar' => 'احترافي', 'name_fr' => 'Pro', 'price_monthly' => 399, 'price_yearly' => 3990, 'max_members' => 9999, 'max_projects' => 9999, 'features' => ['all','priority']],
        ];
        foreach ($plans as $p) Plan::create($p);
    }
}
