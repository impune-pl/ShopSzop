<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Users extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
        ["name"=>"admin","email"=>"admin@mail.local","email_verified_at"=>NULL,"password"=>"\$2y\$10\$.zKec7nu6i4oUmj/1NLDCu/CcYnS5YZNt7gVfqfh0WdaKAeJ.0iGy","api_token"=>NULL,"created_at"=>"2020-05-05 06:19:00","updated_at"=>"2020-05-05 06:19:00","isAdmin"=>TRUE,"isBanned"=>FALSE],
        ["name"=>"user","email"=>"user@mail.local","email_verified_at"=>NULL,"password"=>"\$2y\$10\$kuvPYQMmQbyg4837br9xkOtGKnwfPIHl8AMA1qYIN4VWWUmn6/INC","api_token"=>NULL,"created_at"=>"2020-05-05 06:36:03","updated_at"=>"2020-05-05 06:36:03","isAdmin"=>FALSE,"isBanned"=>FALSE],
        ["name"=>"test","email"=>"test@mail.local","email_verified_at"=>NULL,"password"=>"\$2y\$10\$yOzrv/RPeehCytX.4QzLe.pFm1R19mFKkYpHt5bIl0t7oIrcJu9Jq","api_token"=>NULL,"created_at"=>"2020-05-05 07:06:09","updated_at"=>"2020-05-05 07:06:09","isAdmin"=>FALSE,"isBanned"=>TRUE],
        ];
        DB::table('users')->insert($users);
    }
}
