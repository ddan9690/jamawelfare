<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WelfareSeeder extends Seeder
{
    public function run(): void
    {
        $welfares = [
            ['name' => 'Homa Bay Primary Teachers Welfare Association', 'abbr' => 'HBPTWA', 'county_id' => 8],
            ['name' => 'Homa Bay Junior School Teachers Welfare', 'abbr' => 'HBJSTW', 'county_id' => 8],
            ['name' => 'Homa Bay Secondary Teachers Welfare', 'abbr' => 'HBSTW', 'county_id' => 8],
            ['name' => 'Homa Bay Tertiary Staff Welfare', 'abbr' => 'HBTSW', 'county_id' => 8],
            ['name' => 'Homa Bay County Health Staff Welfare', 'abbr' => 'HBCHSW', 'county_id' => 8],
            ['name' => 'Migori Primary Teachers Welfare Association', 'abbr' => 'MPTWA', 'county_id' => 27],
            ['name' => 'Migori Junior School Teachers Welfare', 'abbr' => 'MJSTW', 'county_id' => 27],
            ['name' => 'Migori Secondary Teachers Welfare', 'abbr' => 'MSTW', 'county_id' => 27],
            ['name' => 'Migori Tertiary Staff Welfare', 'abbr' => 'MTSW', 'county_id' => 27],
            ['name' => 'Migori County Health Staff Welfare', 'abbr' => 'MCSW', 'county_id' => 27],
            ['name' => 'Siaya Primary Teachers Welfare Association', 'abbr' => 'SPTWA', 'county_id' => 38],
            ['name' => 'Siaya Junior School Teachers Welfare', 'abbr' => 'SJSTW', 'county_id' => 38],
            ['name' => 'Siaya Secondary Teachers Welfare', 'abbr' => 'SSTW', 'county_id' => 38],
            ['name' => 'Siaya Tertiary Staff Welfare', 'abbr' => 'STSW', 'county_id' => 38],
            ['name' => 'Siaya County Health Staff Welfare', 'abbr' => 'SCHSW', 'county_id' => 38],
            ['name' => 'Kisumu Primary Teachers Welfare Association', 'abbr' => 'KPTWA', 'county_id' => 17],
            ['name' => 'Kisumu Junior School Teachers Welfare', 'abbr' => 'KJSTW', 'county_id' => 17],
            ['name' => 'Kisumu Secondary Teachers Welfare', 'abbr' => 'KSTW', 'county_id' => 17],
            ['name' => 'Kisumu Tertiary Staff Welfare', 'abbr' => 'KTSW', 'county_id' => 17],
            ['name' => 'Kisumu County Health Staff Welfare', 'abbr' => 'KCHSW', 'county_id' => 17],
        ];

        foreach ($welfares as $w) {
            DB::table('welfares')->insert([
                'name' => $w['name'],
                'abbreviation' => $w['abbr'],
                'county_id' => $w['county_id'],
                'status' => 'active',
                'description' => 'Sample welfare association for ' . $w['name'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}