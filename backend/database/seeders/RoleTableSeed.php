<?php

namespace Database\Seeders;

use App\Repositories\Common\Acl\RoleRepository;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleTableSeed extends Seeder
{
    const TABLE = 'roles';

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
            'id' => RoleRepository::ROLE_ADMIN,
            'name' => RoleRepository::NAME_ADMIN,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table(self::TABLE)->insertOrIgnore([
            'id' => RoleRepository::ROLE_MANAGER,
            'name' => RoleRepository::NAME_MANAGER,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table(self::TABLE)->insertOrIgnore([
            'id' => RoleRepository::ROLE_USER,
            'name' => RoleRepository::NAME_USER,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table(self::TABLE)->insertOrIgnore([
            'id' => RoleRepository::ROLE_TEACHER,
            'name' => RoleRepository::NAME_TEACHER,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
