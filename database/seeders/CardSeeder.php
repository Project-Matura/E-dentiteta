<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Models\Card;

class CardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('cards')->insert([
            'id' => Str::uuid(),
            'id_organisation' => '55c8f13b-d2c6-41f8-adde-362093237725',
            'name' => 'Dijaška KER',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
            'auto_join' => 'Y',
        ]);
        DB::table('cards')->insert([
            'id' => Str::uuid(),
            'id_organisation' => 'd2fddf70-58ad-40fe-9be3-8fee066f0250',
            'name' => 'Dijaška SMP',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
            'auto_join' => 'N',
        ]);
        Card::factory()->count(3)->create();
    }
}
