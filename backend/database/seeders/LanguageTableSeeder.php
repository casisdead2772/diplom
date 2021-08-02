<?php

namespace Database\Seeders;

use App\Repositories\Common\Language\LanguageRepository;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LanguageTableSeeder extends Seeder
{
    const TABLE = 'languages';

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
            'name' => LanguageRepository::ENGLISH_NAME,
            'code' => LanguageRepository::ENGLISH_CODE,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table(self::TABLE)->insertOrIgnore([
            'name' => LanguageRepository::FRENCH_NAME,
            'code' => LanguageRepository::FRENCH_CODE,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table(self::TABLE)->insertOrIgnore([
            'name' => LanguageRepository::RUSSIAN_NAME,
            'code' => LanguageRepository::RUSSIAN_CODE,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table(self::TABLE)->insertOrIgnore([
            'name' => LanguageRepository::GERMAN_NAME,
            'code' => LanguageRepository::GERMAN_CODE,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
