<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class RegionSeeder extends Seeder {
    public function run(): void {
        $regions = [
            ['name_ar' => 'طنجة - تطوان - الحسيمة', 'name_fr' => 'Tanger-Tetouan-Al Hoceima'],
            ['name_ar' => 'الشرق', 'name_fr' => "L'Oriental"],
            ['name_ar' => 'فاس - مكناس', 'name_fr' => 'Fes-Meknes'],
            ['name_ar' => 'الرباط - سلا - القنيطرة', 'name_fr' => 'Rabat-Sale-Kenitra'],
            ['name_ar' => 'بني ملال - خنيفرة', 'name_fr' => 'Beni Mellal-Khenifra'],
            ['name_ar' => 'الدار البيضاء - سطات', 'name_fr' => 'Casablanca-Settat'],
            ['name_ar' => 'مراكش - آسفي', 'name_fr' => 'Marrakech-Safi'],
            ['name_ar' => 'درعة - تافيلالت', 'name_fr' => 'Draa-Tafilalet'],
            ['name_ar' => 'سوس - ماسة', 'name_fr' => 'Souss-Massa'],
            ['name_ar' => 'كلميم - واد نون', 'name_fr' => 'Guelmim-Oued Noun'],
            ['name_ar' => 'العيون - الساقية الحمراء', 'name_fr' => 'Laayoune-Sakia El Hamra'],
            ['name_ar' => 'الداخلة - وادي الذهب', 'name_fr' => 'Dakhla-Oued Ed-Dahab'],
        ];
        foreach ($regions as $r) {
            DB::table('regions')->insert(array_merge($r, ['created_at' => now(), 'updated_at' => now()]));
        }
    }
}
