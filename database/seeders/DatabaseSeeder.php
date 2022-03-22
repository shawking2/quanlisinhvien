<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //   create acc
        $userTeacher= User::create(['name' => 'teacher',  'email' => 'teacher@gmail.com', 'phone'=>'01234567', 'password' => bcrypt('teacher'), 'created_at' => NOW()]);
        $userStudent= User::create(['name' => 'student', 'email' => 'student@gmail.com', 'phone'=>'07890123', 'password' => bcrypt('student'), 'created_at' => NOW()]);

        //create permissions
       $permissions =['user-list', 'user-add', 'user-edit', 'user-delete', 'role-list', 'role-add', 'role-edit', 'role-delete','post-list', 'post-add',  'post-edit', 'post-delete',  'document-list', 'document-add', 'document-edit', 'document-delete'];
       foreach ($permissions as $permission)   {
           Permission::create([
               'name' => $permission
           ]);
       }

       //create role
       $teacher = Role::create([ 'name' => 'teacher', 'created_at' => NOW()]);
       $student = Role::create([ 'name' => 'student', 'created_at' => NOW()]);

       //crete role_has_permission
       $teacherPermissions=['user-list', 'user-add', 'user-edit', 'user-delete', 'role-list', 'role-add', 'role-edit', 'role-delete','post-list', 'post-add',  'post-edit', 'post-delete',  'document-list', 'document-add', 'document-edit', 'document-delete'];
       foreach ($teacherPermissions as $permission)   {
           $teacher->givePermissionTo($permission);
       }

       //trao role cho user
       $userTeacher->assignRole($teacher);
    }
}
