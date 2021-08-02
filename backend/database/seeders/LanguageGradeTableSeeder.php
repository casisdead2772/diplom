<?php

namespace Database\Seeders;

use App\Repositories\Common\LanguageGrade\LanguageGradeRepository;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LanguageGradeTableSeeder extends Seeder
{
    const TABLE = 'language_grades';

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
            'name' => LanguageGradeRepository::GRADE_A1,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table(self::TABLE)->insertOrIgnore([
            'name' => LanguageGradeRepository::GRADE_A2,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table(self::TABLE)->insertOrIgnore([
            'name' => LanguageGradeRepository::GRADE_B1,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table(self::TABLE)->insertOrIgnore([
            'name' => LanguageGradeRepository::GRADE_B2,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table(self::TABLE)->insertOrIgnore([
            'name' => LanguageGradeRepository::GRADE_C1,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table(self::TABLE)->insertOrIgnore([
            'name' => LanguageGradeRepository::GRADE_C2,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table(self::TABLE)->insertOrIgnore([
            'name' => LanguageGradeRepository::GRADE_NATIVE,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
