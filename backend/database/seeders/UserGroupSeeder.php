<?php

namespace Database\Seeders;

use App\Repositories\Common\UserGroup\UserGroupRepository;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserGroupSeeder extends Seeder
{
    const TABLE = 'user_groups';

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table(self::TABLE)->insertOrIgnore([
            'name' => UserGroupRepository::BASIC_GROUP_NAME,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
