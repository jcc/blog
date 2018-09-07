<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()['cache']->forget('spatie.permission.cache');

        $now = Carbon::now();

        $permissions = [
            // User
            ['name' => 'list_user'],
            ['name' => 'create_user'],
            ['name' => 'update_user'],
            ['name' => 'delete_user'],

            // Article
            ['name' => 'list_article'],
            ['name' => 'create_article'],
            ['name' => 'update_article'],
            ['name' => 'delete_article'],

            // Discussion
            ['name' => 'list_discussion'],
            ['name' => 'create_discussion'],
            ['name' => 'update_discussion'],
            ['name' => 'delete_discussion'],

            // Comment
            ['name' => 'list_comment'],
            ['name' => 'update_comment'],
            ['name' => 'delete_comment'],

            // File
            ['name' => 'list_file'],
            ['name' => 'create_file_folder'],
            ['name' => 'upload_file'],
            ['name' => 'delete_file'],

            // Tag
            ['name' => 'list_tag'],
            ['name' => 'create_tag'],
            ['name' => 'update_tag'],
            ['name' => 'delete_tag'],

            // Category
            ['name' => 'list_category'],
            ['name' => 'create_category'],
            ['name' => 'update_category'],
            ['name' => 'delete_category'],

            // Link
            ['name' => 'list_link'],
            ['name' => 'create_link'],
            ['name' => 'update_link'],
            ['name' => 'delete_link'],

            // Role
            ['name' => 'list_role'],
            ['name' => 'create_role'],
            ['name' => 'update_role'],
            ['name' => 'update_role_permissions'],
            ['name' => 'delete_role'],

            // Visitor
            ['name' => 'list_visitor'],

            // System
            ['name' => 'list_system_info'],
        ];

        foreach ($permissions as $key => $permission) {
            $permissions[$key]['guard_name'] = 'api';
            $permissions[$key]['created_at'] = $now;
            $permissions[$key]['updated_at'] = $now;
        }

        Permission::insert($permissions);
    }
}
