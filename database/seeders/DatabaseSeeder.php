<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Очистка таблиц
        DB::table('messages')->delete();
        DB::table('chats')->delete();
        DB::table('users')->delete();

        // Создание пользователей
        $user1 = DB::table('users')->insertGetId([
            'name' => 'User 1',
            'user_id' => Str::random(10),
            'avatar' => null,
            'description' => 'This is user 1',
            'email' => 'user1@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
        ]);

        $user2 = DB::table('users')->insertGetId([
            'name' => 'User 2',
            'user_id' => Str::random(10),
            'avatar' => null,
            'description' => 'This is user 2',
            'email' => 'user2@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
        ]);

        $user3 = DB::table('users')->insertGetId([
            'name' => 'User 3',
            'user_id' => Str::random(10),
            'avatar' => null,
            'description' => 'This is user 3',
            'email' => 'user3@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
        ]);

        // Создание чатов
        $chat1 = DB::table('chats')->insertGetId([
            'user1_id' => $user1,
            'user2_id' => $user2,
        ]);

        $chat2 = DB::table('chats')->insertGetId([
            'user1_id' => $user1,
            'user2_id' => $user3,
        ]);

        // Создание сообщений
        DB::table('messages')->insert([
            [
                'content' => 'Hello, User 2!',
                'user_id' => $user1,
                'chat_id' => $chat1,
            ],
            [
                'content' => 'Hello, User 1!',
                'user_id' => $user2,
                'chat_id' => $chat1,
            ],
            [
                'content' => 'Hello, User 2!',
                'user_id' => $user1,
                'chat_id' => $chat1,
            ],
            [
                'content' => 'Hello, User 1!',
                'user_id' => $user2,
                'chat_id' => $chat1,
            ],
            [
                'content' => 'Hello, User 2!',
                'user_id' => $user1,
                'chat_id' => $chat1,
            ],
            [
                'content' => 'Hello, User 1!',
                'user_id' => $user2,
                'chat_id' => $chat1,
            ],
            [
                'content' => 'Hello, User 2!',
                'user_id' => $user1,
                'chat_id' => $chat1,
            ],
            [
                'content' => 'Hello, User 1!',
                'user_id' => $user2,
                'chat_id' => $chat1,
            ],
            [
                'content' => 'Hello, User 2!',
                'user_id' => $user1,
                'chat_id' => $chat1,
            ],
            [
                'content' => 'Hello, User 1!',
                'user_id' => $user2,
                'chat_id' => $chat1,
            ],
            [
                'content' => 'Hello, User 2!',
                'user_id' => $user1,
                'chat_id' => $chat1,
            ],
            [
                'content' => 'Hello, User 1!',
                'user_id' => $user2,
                'chat_id' => $chat1,
            ],
            [
                'content' => 'Hello, User 2!',
                'user_id' => $user1,
                'chat_id' => $chat1,
            ],
            [
                'content' => 'Hello, User 1!',
                'user_id' => $user2,
                'chat_id' => $chat1,
            ],
            [
                'content' => 'Hello, User 2!',
                'user_id' => $user1,
                'chat_id' => $chat1,
            ],
            [
                'content' => 'Hello, User 1!',
                'user_id' => $user2,
                'chat_id' => $chat1,
            ],
            [
                'content' => 'Hello, User 2!',
                'user_id' => $user1,
                'chat_id' => $chat1,
            ],
            [
                'content' => 'Hello, User 1!',
                'user_id' => $user2,
                'chat_id' => $chat1,
            ],
            [
                'content' => 'Hello, User 3!',
                'user_id' => $user1,
                'chat_id' => $chat2,
            ],
            [
                'content' => 'Hello, User 1!',
                'user_id' => $user3,
                'chat_id' => $chat2,
            ],
        ]);
    }
}
