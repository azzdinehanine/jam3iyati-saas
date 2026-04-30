#!/bin/bash
set -e
echo '🚀 Building Database Layer...'

# === Plans Migration ===
cat > database/migrations/2026_01_01_000002_create_plans_table.php << 'EOF'
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
EOF
echo '  ✓ plans migration'

# === Tenants Migration ===
cat > database/migrations/2026_01_01_000003_create_tenants_table.php << 'EOF'
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
EOF
echo '  ✓ tenants migration'

# === Users Migration ===
cat > database/migrations/2026_01_01_000004_create_users_table.php << 'EOF'
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('users', function (Blueprint $t) {
            $t->id();
            $t->foreignId('tenant_id')->nullable()->constrained()->cascadeOnDelete();
            $t->string('name');
            $t->string('lastname');
            $t->string('email')->unique();
            $t->string('phone', 20);
            $t->timestamp('email_verified_at')->nullable();
            $t->string('password');
            $t->enum('role', ['super_admin','admin','manager','member'])->default('admin');
            $t->boolean('is_active')->default(true);
            $t->rememberToken();
            $t->timestamps();
        });
        Schema::create('password_reset_tokens', function (Blueprint $t) {
            $t->string('email')->primary();
            $t->string('token');
            $t->timestamp('created_at')->nullable();
        });
        Schema::create('sessions', function (Blueprint $t) {
            $t->string('id')->primary();
            $t->foreignId('user_id')->nullable()->index();
            $t->string('ip_address', 45)->nullable();
            $t->text('user_agent')->nullable();
            $t->longText('payload');
            $t->integer('last_activity')->index();
        });
    }
    public function down(): void {
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('users');
    }
};
EOF
echo '  ✓ users migration'

# === Members Migration ===
cat > database/migrations/2026_01_01_000005_create_members_table.php << 'EOF'
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
EOF
echo '  ✓ members migration'

# === Finance Migration ===
cat > database/migrations/2026_01_01_000006_create_finance_tables.php << 'EOF'
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
EOF
echo '  ✓ finance migration'

# === Meetings & Projects Migration ===
cat > database/migrations/2026_01_01_000007_create_meetings_projects.php << 'EOF'
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
EOF
echo '  ✓ meetings/projects/documents migration'

# === Models Directories ===
mkdir -p app/Models/Concerns app/Scopes

# === TenantScope ===
cat > app/Scopes/TenantScope.php << 'EOF'
<?php
namespace App\Scopes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
class TenantScope implements Scope {
    public function apply(Builder $builder, Model $model): void {
        if (auth()->check() && auth()->user()->tenant_id) {
            $builder->where($model->getTable() . '.tenant_id', auth()->user()->tenant_id);
        }
    }
}
EOF
echo '  ✓ TenantScope'

# === BelongsToTenant Trait ===
cat > app/Models/Concerns/BelongsToTenant.php << 'EOF'
<?php
namespace App\Models\Concerns;
use App\Scopes\TenantScope;
trait BelongsToTenant {
    protected static function bootBelongsToTenant() {
        static::addGlobalScope(new TenantScope);
        static::creating(function ($model) {
            if (auth()->check() && auth()->user()->tenant_id && !$model->tenant_id) {
                $model->tenant_id = auth()->user()->tenant_id;
            }
        });
    }
    public function tenant() { return $this->belongsTo(\App\Models\Tenant::class); }
}
EOF
echo '  ✓ BelongsToTenant trait'

# === Tenant Model ===
cat > app/Models/Tenant.php << 'EOF'
<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Tenant extends Model {
    protected $fillable = ['serial_code','name','email','phone','address','facebook','founded_at','goals','region_id','province_id','commune_id','logo_path','deposit_receipt_path','plan_id','subscription_end','status','locale'];
    protected $casts = ['founded_at' => 'date', 'subscription_end' => 'date'];
    public static function generateSerial(): string {
        do { $code = 'JM3-' . strtoupper(bin2hex(random_bytes(3))); } while (self::where('serial_code', $code)->exists());
        return $code;
    }
    public function users() { return $this->hasMany(User::class); }
    public function members() { return $this->hasMany(Member::class); }
    public function plan() { return $this->belongsTo(Plan::class); }
    public function region() { return $this->belongsTo(Region::class); }
    public function province() { return $this->belongsTo(Province::class); }
    public function commune() { return $this->belongsTo(Commune::class); }
}
EOF
echo '  ✓ Tenant model'

# === User Model (overwrite default) ===
cat > app/Models/User.php << 'EOF'
<?php
namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
class User extends Authenticatable {
    use Notifiable;
    protected $fillable = ['tenant_id','name','lastname','email','phone','password','role','is_active'];
    protected $hidden = ['password','remember_token'];
    protected $casts = ['email_verified_at'=>'datetime','password'=>'hashed'];
    public function tenant() { return $this->belongsTo(Tenant::class); }
    public function isSuperAdmin(): bool { return $this->role === 'super_admin'; }
    public function isAdmin(): bool { return $this->role === 'admin'; }
}
EOF
echo '  ✓ User model'

# === Plan Model ===
cat > app/Models/Plan.php << 'EOF'
<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Plan extends Model {
    protected $fillable = ['name_ar','name_fr','price_monthly','price_yearly','max_members','max_projects','features','is_active'];
    protected $casts = ['features' => 'array'];
    public function tenants() { return $this->hasMany(Tenant::class); }
}
EOF

# === Region Model ===
cat > app/Models/Region.php << 'EOF'
<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Region extends Model {
    protected $fillable = ['name_ar','name_fr'];
    public function provinces() { return $this->hasMany(Province::class); }
    public function getNameAttribute() { return app()->getLocale()==='ar' ? $this->name_ar : $this->name_fr; }
}
EOF

# === Province Model ===
cat > app/Models/Province.php << 'EOF'
<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Province extends Model {
    protected $fillable = ['region_id','name_ar','name_fr'];
    public function region() { return $this->belongsTo(Region::class); }
    public function communes() { return $this->hasMany(Commune::class); }
    public function getNameAttribute() { return app()->getLocale()==='ar' ? $this->name_ar : $this->name_fr; }
}
EOF

# === Commune Model ===
cat > app/Models/Commune.php << 'EOF'
<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Commune extends Model {
    protected $fillable = ['province_id','name_ar','name_fr'];
    public function province() { return $this->belongsTo(Province::class); }
    public function getNameAttribute() { return app()->getLocale()==='ar' ? $this->name_ar : $this->name_fr; }
}
EOF
echo '  ✓ Plan, Region, Province, Commune models'

# === Member, Transaction, MemberSubscription, Meeting, Project, Document Models ===
cat > app/Models/Member.php << 'EOF'
<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\BelongsToTenant;
class Member extends Model {
    use BelongsToTenant;
    protected $fillable = ['tenant_id','cin','name','lastname','email','phone','address','birthdate','gender','join_date','role_in_assoc','status','photo'];
    protected $casts = ['birthdate' => 'date', 'join_date' => 'date'];
    public function subscriptions() { return $this->hasMany(MemberSubscription::class); }
    public function getFullNameAttribute() { return $this->name . ' ' . $this->lastname; }
}
EOF

cat > app/Models/Transaction.php << 'EOF'
<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\BelongsToTenant;
class Transaction extends Model {
    use BelongsToTenant;
    protected $fillable = ['tenant_id','type','category','amount','description','transaction_date','receipt_file','created_by'];
    protected $casts = ['transaction_date' => 'date', 'amount' => 'decimal:2'];
    public function creator() { return $this->belongsTo(User::class, 'created_by'); }
    public function scopeIncomes($q) { return $q->where('type','income'); }
    public function scopeExpenses($q) { return $q->where('type','expense'); }
}
EOF

cat > app/Models/MemberSubscription.php << 'EOF'
<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\BelongsToTenant;
class MemberSubscription extends Model {
    use BelongsToTenant;
    protected $fillable = ['tenant_id','member_id','year','amount','paid_at','receipt_number','status','notes'];
    protected $casts = ['paid_at' => 'date', 'amount' => 'decimal:2'];
    public function member() { return $this->belongsTo(Member::class); }
}
EOF
echo '  ✓ Member, Transaction, MemberSubscription'

cat > app/Models/Meeting.php << 'EOF'
<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\BelongsToTenant;
class Meeting extends Model {
    use BelongsToTenant;
    protected $fillable = ['tenant_id','title','type','meeting_date','location','agenda','minutes','status'];
    protected $casts = ['meeting_date' => 'datetime'];
    public function attendances() { return $this->hasMany(MeetingAttendance::class); }
    public function attendees() { return $this->belongsToMany(Member::class, 'meeting_attendances')->withPivot('attended'); }
}
EOF

cat > app/Models/MeetingAttendance.php << 'EOF'
<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class MeetingAttendance extends Model {
    protected $fillable = ['meeting_id','member_id','attended'];
    protected $casts = ['attended' => 'boolean'];
    public function meeting() { return $this->belongsTo(Meeting::class); }
    public function member() { return $this->belongsTo(Member::class); }
}
EOF

cat > app/Models/Project.php << 'EOF'
<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\BelongsToTenant;
class Project extends Model {
    use BelongsToTenant;
    protected $fillable = ['tenant_id','name','description','start_date','end_date','budget','spent','status'];
    protected $casts = ['start_date'=>'date','end_date'=>'date','budget'=>'decimal:2','spent'=>'decimal:2'];
    public function getProgressAttribute() { return $this->budget > 0 ? min(100, round(($this->spent / $this->budget) * 100)) : 0; }
}
EOF

cat > app/Models/Document.php << 'EOF'
<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\BelongsToTenant;
class Document extends Model {
    use BelongsToTenant;
    protected $fillable = ['tenant_id','name','type','file_path','uploaded_by'];
    public function uploader() { return $this->belongsTo(User::class, 'uploaded_by'); }
}
EOF
echo '  ✓ Meeting, MeetingAttendance, Project, Document'

# === RegionSeeder ===
cat > database/seeders/RegionSeeder.php << 'EOF'
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
EOF
echo '  ✓ RegionSeeder'

# === ProvinceSeeder (simplified - main provinces only) ===
cat > database/seeders/ProvinceSeeder.php << 'EOF'
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
EOF
echo '  ✓ ProvinceSeeder'

# === PlanSeeder ===
cat > database/seeders/PlanSeeder.php << 'EOF'
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
EOF

# === SuperAdminSeeder ===
cat > database/seeders/SuperAdminSeeder.php << 'EOF'
<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class SuperAdminSeeder extends Seeder {
    public function run(): void {
        User::create([
            'tenant_id' => null,
            'name' => 'Super',
            'lastname' => 'Admin',
            'email' => 'admin@jam3iyati.ma',
            'phone' => '0600000000',
            'password' => Hash::make('Admin@2026'),
            'role' => 'super_admin',
            'email_verified_at' => now(),
        ]);
    }
}
EOF

# === DatabaseSeeder ===
cat > database/seeders/DatabaseSeeder.php << 'EOF'
<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
class DatabaseSeeder extends Seeder {
    public function run(): void {
        $this->call([
            RegionSeeder::class,
            ProvinceSeeder::class,
            PlanSeeder::class,
            SuperAdminSeeder::class,
        ]);
    }
}
EOF
echo '  ✓ PlanSeeder, SuperAdminSeeder, DatabaseSeeder'
echo ''
echo '✅ Database Layer Complete!'
