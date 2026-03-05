<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
	public function run(): void
	{
		// Limpa o cache do Spatie antes de seedar
		app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

		// Permissions
		$permissions = [
			'create_user',
			'edit_user',
			'delete_user',
			'create_suite',
			'edit_suite',
			'delete_suite',
		];

		foreach ($permissions as $permissionName) {
			Permission::firstOrCreate(['name' => $permissionName]);
		}

		// Role: admin (todas as permissões)
		$admin = Role::firstOrCreate(['name' => 'admin']);
		$admin->syncPermissions($permissions);

		// Role: operator (permissões de suítes)
		$operator = Role::firstOrCreate(['name' => 'operator']);
		$operator->syncPermissions(['create_suite', 'edit_suite']);
	}
}
