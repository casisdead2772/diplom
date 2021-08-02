<?php

namespace Database\Seeders;

use App\Repositories\Common\Specialty\SpecialtyRepository;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SpecialtySeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    const TABLE = 'specialties';

    public function run()
    {
        \Illuminate\Support\Facades\Schema::disableForeignKeyConstraints();

        DB::table(self::TABLE)->truncate();

        DB::table(self::TABLE)->insertOrIgnore([
            'id' => 1,
            'name' => SpecialtyRepository::ENGLISH_NAME,
            'code' => SpecialtyRepository::ENGLISH_CODE,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table(self::TABLE)->insertOrIgnore([
            'id' => 2,
            'name' => SpecialtyRepository::FRENCH_NAME,
            'code' => SpecialtyRepository::FRENCH_CODE,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table(self::TABLE)->insertOrIgnore([
            'id' => 3,
            'name' => SpecialtyRepository::RUSSIAN_NAME,
            'code' => SpecialtyRepository::RUSSIAN_CODE,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table(self::TABLE)->insertOrIgnore([
            'id' => 4,
            'name' => SpecialtyRepository::GERMAN_NAME,
            'code' => SpecialtyRepository::GERMAN_CODE,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
