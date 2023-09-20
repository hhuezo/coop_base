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





        $user = User::create( [
            'name'=>'Alvaro herrera',
            'email'=>'aherrera@mail.com',
            'username'=>'aherrera',
            'password'=> bcrypt( 'Krusnik02' ),
            'rol_id' => 1
        ] );

        //$user->assignRole('administrador');
    }
}
