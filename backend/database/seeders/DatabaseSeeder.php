<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CountrySeed::class);
        $this->call(LanguageTableSeeder::class);
        $this->call(LanguageGradeTableSeeder::class);
        $this->call(SpecialtySeed::class);
        $this->call(PermissionTableSeed::class);
        $this->call(RoleTableSeed::class);
        $this->call(RoleUserTableSeed::class);
        $this->call(PermissionRoleTableSeed::class);
        $this->call(UserGroupSeeder::class);
        $this->call(UserTableSeed::class);
    }
}
