<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
class RolesAndPermissions extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
       




        $administrador = User::create( [
            'name'=>'Administrador',
            'email'=>'admin@mail.com',
            'username'=>'admin',
            'password'=> bcrypt( '12345678' ),
        ] );

        $administrador->assignRole('administrador');
    }
}
