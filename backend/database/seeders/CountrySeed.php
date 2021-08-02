<?php

namespace Database\Seeders;

use App\Repositories\Common\Country\CountryRepository;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountrySeed extends Seeder
{
    const TABLE = 'countries';

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \Illuminate\Support\Facades\Schema::disableForeignKeyConstraints();

        DB::table(self::TABLE)->truncate();

        DB::table(self::TABLE)->insertOrIgnore([
            'name' => CountryRepository::NAME_ENGLISH,
            'code' => CountryRepository::CODE_ENGLISH,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table(self::TABLE)->insertOrIgnore([
            'name' => CountryRepository::NAME_FRENCH,
            'code' => CountryRepository::CODE_FRENCH,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table(self::TABLE)->insertOrIgnore([
            'name' => CountryRepository::NAME_RUSSIAN,
            'code' => CountryRepository::CODE_RUSSIAN,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table(self::TABLE)->insertOrIgnore([
            'name' => CountryRepository::NAME_GERMANY,
            'code' => CountryRepository::CODE_GERMANY,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
