<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissionsByRole = [
            'admin' => ['edit user', 'delete user', 'create user'],
            'manager' => ['edit product', 'delete product', 'create product'],
            'cashier' => ['add transaction'],
            'user' => ['view me', 'edit me', 'delete me'],
        ];
        foreach ($permissionsByRole as $roleName => $permissions) {
            $id_role = Uuid::uuid5(Uuid::NAMESPACE_DNS, $roleName);
            Role::create(['id' => $id_role, 'name' => $roleName, 'guard_name' => 'web']);
            foreach ($permissions as $permission) {
                $id_permission = Uuid::uuid5(Uuid::NAMESPACE_DNS, $permission);
                Permission::create(['id' => $id_permission, 'name' => $permission, 'guard_name' => 'web']);
                DB::table('role_has_permissions')->insert(['permission_id' => $id_permission, 'role_id' => $id_role]);
            }
        }
    }
}
