<?php
use Illuminate\Database\Seeder;
use App\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
class CreateAdminUserSeeder extends Seeder
{
/**
* Run the database seeds.
*
* @return void
*/
public function run()
{
$user = User::create([
'name' => 'علاء محمد',
'email' => 'admin',
'password' => bcrypt('00'),
'roles_name' =>["المدير"],
]);
$role = Role::create(['name' => 'المدير']);
$permissions = Permission::pluck('id','id')->all();
$role->syncPermissions($permissions);
$user->assignRole([$role->id]);
}
}
