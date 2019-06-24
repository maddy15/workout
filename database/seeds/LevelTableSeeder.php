<?php

use Illuminate\Database\Seeder;
use App\Level;
use Illuminate\Support\Facades\Date;

class LevelTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $levels = collect(['Beginner','Intermediate','Advance','Monster']);

        $levels->each(function($level){
            DB::table('levels')->insert([
                'name' => $level,
            ]);
        });
    }
}
