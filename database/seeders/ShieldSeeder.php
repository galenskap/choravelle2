<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use BezhanSalleh\FilamentShield\Support\Utils;
use Spatie\Permission\PermissionRegistrar;

class ShieldSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $rolesWithPermissions = '[{"name":"super_admin","guard_name":"web","permissions":["view_block","view_any_block","create_block","update_block","restore_block","restore_any_block","replicate_block","reorder_block","delete_block","delete_any_block","force_delete_block","force_delete_any_block","view_block::template","view_any_block::template","create_block::template","update_block::template","restore_block::template","restore_any_block::template","replicate_block::template","reorder_block::template","delete_block::template","delete_any_block::template","force_delete_block::template","force_delete_any_block::template","view_contact::submission","view_any_contact::submission","create_contact::submission","update_contact::submission","restore_contact::submission","restore_any_contact::submission","replicate_contact::submission","reorder_contact::submission","delete_contact::submission","delete_any_contact::submission","force_delete_contact::submission","force_delete_any_contact::submission","view_event","view_any_event","create_event","update_event","restore_event","restore_any_event","replicate_event","reorder_event","delete_event","delete_any_event","force_delete_event","force_delete_any_event","view_file","view_any_file","create_file","update_file","restore_file","restore_any_file","replicate_file","reorder_file","delete_file","delete_any_file","force_delete_file","force_delete_any_file","view_folder","view_any_folder","create_folder","update_folder","restore_folder","restore_any_folder","replicate_folder","reorder_folder","delete_folder","delete_any_folder","force_delete_folder","force_delete_any_folder","view_menu::item","view_any_menu::item","create_menu::item","update_menu::item","restore_menu::item","restore_any_menu::item","replicate_menu::item","reorder_menu::item","delete_menu::item","delete_any_menu::item","force_delete_menu::item","force_delete_any_menu::item","view_page","view_any_page","create_page","update_page","restore_page","restore_any_page","replicate_page","reorder_page","delete_page","delete_any_page","force_delete_page","force_delete_any_page","view_pupitre","view_any_pupitre","create_pupitre","update_pupitre","restore_pupitre","restore_any_pupitre","replicate_pupitre","reorder_pupitre","delete_pupitre","delete_any_pupitre","force_delete_pupitre","force_delete_any_pupitre","view_role","view_any_role","create_role","update_role","delete_role","delete_any_role","view_settings","view_any_settings","create_settings","update_settings","restore_settings","restore_any_settings","replicate_settings","reorder_settings","delete_settings","delete_any_settings","force_delete_settings","force_delete_any_settings","view_song","view_any_song","create_song","update_song","restore_song","restore_any_song","replicate_song","reorder_song","delete_song","delete_any_song","force_delete_song","force_delete_any_song","view_tenant","view_any_tenant","create_tenant","update_tenant","restore_tenant","restore_any_tenant","replicate_tenant","reorder_tenant","delete_tenant","delete_any_tenant","force_delete_tenant","force_delete_any_tenant","view_user","view_any_user","create_user","update_user","restore_user","restore_any_user","replicate_user","reorder_user","delete_user","delete_any_user","force_delete_user","force_delete_any_user","widget_BackToWebsiteWidget","widget_LatestActivitiesWidget"]},{"name":"admin","guard_name":"web","permissions":["view_block","view_any_block","create_block","update_block","restore_block","restore_any_block","replicate_block","reorder_block","delete_block","delete_any_block","view_contact::submission","view_any_contact::submission","view_event","view_any_event","create_event","update_event","restore_event","restore_any_event","replicate_event","reorder_event","delete_event","delete_any_event","view_file","view_any_file","create_file","update_file","restore_file","restore_any_file","replicate_file","reorder_file","delete_file","delete_any_file","view_folder","view_any_folder","create_folder","update_folder","restore_folder","restore_any_folder","replicate_folder","reorder_folder","delete_folder","delete_any_folder","view_menu::item","view_any_menu::item","create_menu::item","update_menu::item","restore_menu::item","restore_any_menu::item","replicate_menu::item","reorder_menu::item","delete_menu::item","delete_any_menu::item","view_page","view_any_page","create_page","update_page","restore_page","restore_any_page","replicate_page","reorder_page","delete_page","delete_any_page","view_pupitre","view_any_pupitre","create_pupitre","update_pupitre","restore_pupitre","restore_any_pupitre","replicate_pupitre","reorder_pupitre","delete_pupitre","delete_any_pupitre","view_song","view_any_song","create_song","update_song","restore_song","restore_any_song","replicate_song","reorder_song","delete_song","delete_any_song","view_user","view_any_user","create_user","update_user","restore_user","restore_any_user","replicate_user","reorder_user","delete_user","delete_any_user","widget_BackToWebsiteWidget","widget_LatestActivitiesWidget"]}]';
        $directPermissions = '[]';

        static::makeRolesWithPermissions($rolesWithPermissions);
        static::makeDirectPermissions($directPermissions);

        $this->command->info('Shield Seeding Completed.');
    }

    protected static function makeRolesWithPermissions(string $rolesWithPermissions): void
    {
        if (! blank($rolePlusPermissions = json_decode($rolesWithPermissions, true))) {
            /** @var Model $roleModel */
            $roleModel = Utils::getRoleModel();
            /** @var Model $permissionModel */
            $permissionModel = Utils::getPermissionModel();

            foreach ($rolePlusPermissions as $rolePlusPermission) {
                $role = $roleModel::firstOrCreate([
                    'name' => $rolePlusPermission['name'],
                    'guard_name' => $rolePlusPermission['guard_name'],
                ]);

                if (! blank($rolePlusPermission['permissions'])) {
                    $permissionModels = collect($rolePlusPermission['permissions'])
                        ->map(fn ($permission) => $permissionModel::firstOrCreate([
                            'name' => $permission,
                            'guard_name' => $rolePlusPermission['guard_name'],
                        ]))
                        ->all();

                    $role->syncPermissions($permissionModels);
                }
            }
        }
    }

    public static function makeDirectPermissions(string $directPermissions): void
    {
        if (! blank($permissions = json_decode($directPermissions, true))) {
            /** @var Model $permissionModel */
            $permissionModel = Utils::getPermissionModel();

            foreach ($permissions as $permission) {
                if ($permissionModel::whereName($permission)->doesntExist()) {
                    $permissionModel::create([
                        'name' => $permission['name'],
                        'guard_name' => $permission['guard_name'],
                    ]);
                }
            }
        }
    }
}
