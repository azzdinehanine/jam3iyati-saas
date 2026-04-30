<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class ProvinceSeeder extends Seeder {
    public function run(): void {
        $data = [
            1 => [['ar'=>'طنجة أصيلة','fr'=>'Tanger-Assilah'],['ar'=>'تطوان','fr'=>'Tetouan'],['ar'=>'الحسيمة','fr'=>'Al Hoceima'],['ar'=>'العرائش','fr'=>'Larache'],['ar'=>'شفشاون','fr'=>'Chefchaouen']],
            2 => [['ar'=>'وجدة','fr'=>'Oujda'],['ar'=>'الناظور','fr'=>'Nador'],['ar'=>'بركان','fr'=>'Berkane'],['ar'=>'تاوريرت','fr'=>'Taourirt']],
            3 => [['ar'=>'فاس','fr'=>'Fes'],['ar'=>'مكناس','fr'=>'Meknes'],['ar'=>'الحاجب','fr'=>'El Hajeb'],['ar'=>'إفران','fr'=>'Ifrane'],['ar'=>'تازة','fr'=>'Taza']],
            4 => [['ar'=>'الرباط','fr'=>'Rabat'],['ar'=>'سلا','fr'=>'Sale'],['ar'=>'القنيطرة','fr'=>'Kenitra'],['ar'=>'الخميسات','fr'=>'Khemisset']],
            5 => [['ar'=>'بني ملال','fr'=>'Beni Mellal'],['ar'=>'خنيفرة','fr'=>'Khenifra'],['ar'=>'أزيلال','fr'=>'Azilal'],['ar'=>'خريبكة','fr'=>'Khouribga']],
            6 => [['ar'=>'الدار البيضاء','fr'=>'Casablanca'],['ar'=>'المحمدية','fr'=>'Mohammedia'],['ar'=>'الجديدة','fr'=>'El Jadida'],['ar'=>'سطات','fr'=>'Settat'],['ar'=>'برشيد','fr'=>'Berrechid']],
            7 => [['ar'=>'مراكش','fr'=>'Marrakech'],['ar'=>'آسفي','fr'=>'Safi'],['ar'=>'الصويرة','fr'=>'Essaouira'],['ar'=>'الحوز','fr'=>'Al Haouz']],
            8 => [['ar'=>'الرشيدية','fr'=>'Errachidia'],['ar'=>'ورزازات','fr'=>'Ouarzazate'],['ar'=>'ميدلت','fr'=>'Midelt']],
            9 => [['ar'=>'أكادير','fr'=>'Agadir'],['ar'=>'تارودانت','fr'=>'Taroudant'],['ar'=>'تيزنيت','fr'=>'Tiznit']],
            10 => [['ar'=>'كلميم','fr'=>'Guelmim'],['ar'=>'طانطان','fr'=>'Tan-Tan']],
            11 => [['ar'=>'العيون','fr'=>'Laayoune'],['ar'=>'بوجدور','fr'=>'Boujdour']],
            12 => [['ar'=>'وادي الذهب','fr'=>'Oued Ed-Dahab'],['ar'=>'أوسرد','fr'=>'Aousserd']],
        ];
        foreach ($data as $regionId => $provinces) {
            foreach ($provinces as $p) {
                DB::table('provinces')->insert(['region_id' => $regionId, 'name_ar' => $p['ar'], 'name_fr' => $p['fr'], 'created_at' => now(), 'updated_at' => now()]);
            }
        }
    }
}
