<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        ini_set('memory_limit', '2048M');
        Schema::disableForeignKeyConstraints();
        Role::truncate();
        Permission::truncate();
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
       	
        foreach (Route::getRoutes()->getRoutes() as $i => $route) {
            $action_object = $route->getAction();
            if (!empty($action_object['controller'])) {
                if(is_array($action_object['middleware'])){
                    if(in_array('auth',  $action_object['middleware'])) {
                        $array = explode('.', $action_object['as']);
                        if(
                            $array[1] == 'create' ||
                            $array[1] == 'show' ||
                            $array[1] == 'edit' ||
                            $array[1] == 'destroy' ||
                            $array[1] == 'export' ||
                            $action_object['as'] == 'appointments.confirm' ||
                            $action_object['as'] == 'appointments.decline' ||
                            $action_object['as'] == 'appointments.cancel' ||
                            $action_object['as'] == 'appointments.accept_patient' ||
                            $action_object['as'] == 'patient_visits.end_visit' ||
                            $array[1] == 'edit_company' ||
                            $array[1] == 'reset_company' ||
                            $array[1] == 'edit_user_interface' ||
                            $array[1] == 'reset_user_interface' ||
                            $array[1] == 'edit_system' ||
                            $array[1] == 'reset_system' ||
                            $array[1] == 'index'
                        )
                        /* if(
                            $array[1] !== 'store' &&
                            $array[1] !== 'update' &&
                            $array[1] !== 'restore'
                        ) */
                        {
                            Permission::create([
                               'group' => str_replace("_", " ",$array[0]),
                               'name' => $action_object['as'],
                            ]);
                        }
                    }
                }
            }
        }

        $master_admin = Role::create(['name' => 'System Administrator']);
        $admin = Role::create(['name' => 'Administrator']);
        $doctor = Role::create(['name' => 'Doctor']);
        $patient = Role::create(['name' => 'Patient']);

        $admin->givePermissionTo(
            Permission::where([
                ['group', '!=', 'roles'],
                ['group', '!=', 'permissions'],
                ['name', '!=', 'settings.edit_system'],
                ['name', '!=', 'settings.restore_system'],
            ])->get()
        );

        $doctor->givePermissionTo(
            Permission::where([
                ['group', '!=', 'roles'],
                ['group', '!=', 'permissions'],
                ['group', '!=', 'settings'],
                ['group', '!=', 'users'],
                ['group', '!=', 'login infos'],
                ['group', 'NOT LIKE', '%reference%'],
                ['name', 'NOT LIKE', '%destroy%'],
            ])->get()
        );

        $patient->givePermissionTo(
            Permission::where([
                ['name', 'appointments.cancel'],
            ])->get()
        );
    }
}
