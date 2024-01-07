<?php

namespace Database\Seeders;

use App\Models\Organisation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;


class OrganisationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('organisations')->insert([
            'id' => Str::uuid(),
            'name' => 'Srednja šola za kemijo, elektrotehniko in računalništvo',
            'verified' => 'Y',
            'checkking_all_cards' => 'Y',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
            'id_user' => 'd6cfc288-fe9c-4131-a27e-c06c96cf899c',
        ]);
        DB::table('organisations')->insert([
            'id' => Str::uuid(),
            'name' => 'Srednja šola za strojništvo',
            'verified' => 'Y',
            'checkking_all_cards' => 'N',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
            'id_user' => 'd6cfc288-fe9c-4131-a27e-c06c96cf899c',
        ]);
        DB::table('organisations')->insert([
            'id' => Str::uuid(),
            'name' => 'Srednja šola za medijske poklice',
            'verified' => 'N',
            'checkking_all_cards' => 'N',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now(),
            'id_user' => 'd6cfc288-fe9c-4131-a27e-c06c96cf899c',
        ]);
        Organisation::factory()->count(7)->create();
    }
}
