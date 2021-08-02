<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionRoleTableSeed extends Seeder
{
    const TABLE = 'permission_role';

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
            'permission_id' => 1,
            'role_id' => 1,
        ]);

        DB::table(self::TABLE)->insertOrIgnore([
            'permission_id' => 1,
            'role_id' => 2,
        ]);
    }
}
