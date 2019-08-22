<?php

use Illuminate\Database\Seeder;
use App\Agent;

class AgentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('agents')->insert([
               'email' => 'agent@gmail.com',
               'password' => 'password',
        ]);
    }
}
