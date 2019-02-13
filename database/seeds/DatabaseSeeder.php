<?php

use Illuminate\Database\Seeder;
use Illuminate\Filesystem\Filesystem;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fileSystem = new Filesystem();
        $database = $fileSystem->get(base_path('database/seeds') . '/' . 'init.sql');
        DB::connection()->getPdo()->exec($database);
        DB::table('admin_users')->insert([
            'username' => 'admin',
            'real_name' => '超级管理员',
            'password' => bcrypt('admin'),
            'email' => 'user1@163.com',
            'mobile' => '123456',
            'avatar' => 'http://webimg-handle.liweijia.com/upload/avatar/avatar_0.jpg',
            'is_root' => 1
        ]);

        DB::table('attachment_classes')->insert([
            'class' => '未分类',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
    }
}
