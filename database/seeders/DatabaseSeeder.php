<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('settings')->insert([
            ['setting' => 'version', 'value' => '001'],
            ['setting' => 'maintenance_mode', 'value' => 'enabled'],
            ['setting' => 'maintenance_message', 'value' => 'Installation not completed'],
            ['setting' => 'can_register', 'value' => 'yes'],
            ['setting' => 'can_signature', 'value' => 'yes'],
            ['setting' => 'contact_type', 'value' => 'default'],
            ['setting' => 'contact_link', 'value' => '/contact'],
            ['setting' => 'header', 'value' => 'default'],
            ['setting' => 'footer', 'value' => 'default'],
            
        ]);

        DB::table('pages')->insert([
            ['page' => 'terms', 'content' => ''],
            ['page' => 'privacy', 'content' => ''],
        ]);

        DB::table('integrations')->insert([
            ['element' => 'header', 'content' => ''],
            ['element' => 'footer', 'content' => ''],
        ]);

        DB::table('sections')->insert([
            ['name' => 'Forums', 'slug' => 'forums', 'order' => '100'],
        ]);
    }
}
