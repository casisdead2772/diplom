<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class AnswerTableSeed extends Seeder
{
    const TABLE = 'answers';

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
            'question_id' => 1,
            'title' => 'First answer',
            'correct' => false,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table(self::TABLE)->insertOrIgnore([
            'question_id' => 1,
            'title' => 'second answer',
            'correct' => true,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table(self::TABLE)->insertOrIgnore([
            'question_id' => 1,
            'title' => 'third answer correct',
            'correct' => false,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table(self::TABLE)->insertOrIgnore([
            'question_id' => 1,
            'title' => 'fourth answer',
            'correct' => false,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table(self::TABLE)->insertOrIgnore([
            'question_id' => 2,
            'title' => 'First answer',
            'correct' => false,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table(self::TABLE)->insertOrIgnore([
            'question_id' => 2,
            'title' => 'second answer',
            'correct' => false,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table(self::TABLE)->insertOrIgnore([
            'question_id' => 2,
            'title' => 'third answer correct',
            'correct' => true,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table(self::TABLE)->insertOrIgnore([
            'question_id' => 2,
            'title' => 'fourth answer',
            'correct' => false,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table(self::TABLE)->insertOrIgnore([
            'question_id' => 3,
            'title' => 'First answer',
            'correct' => false,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table(self::TABLE)->insertOrIgnore([
            'question_id' => 3,
            'title' => 'second answer',
            'correct' => false,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table(self::TABLE)->insertOrIgnore([
            'question_id' => 3,
            'title' => 'third answer correct',
            'correct' => true,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table(self::TABLE)->insertOrIgnore([
            'question_id' => 3,
            'title' => 'fourth answer',
            'correct' => false,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        //
    }
}
