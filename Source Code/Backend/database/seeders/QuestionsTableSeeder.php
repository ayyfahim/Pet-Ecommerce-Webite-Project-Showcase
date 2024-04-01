<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;

class QuestionsTableSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        foreach (app(\App\Models\Question::class)->categories as $category) {
            \App\Models\Question::create([
                'question' => faker()->sentence,
                'answer' => faker()->sentence,
                'category' => $category,
            ]);
        }
    }
}
