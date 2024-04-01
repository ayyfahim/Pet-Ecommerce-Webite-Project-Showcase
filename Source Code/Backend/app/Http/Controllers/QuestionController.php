<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Transformers\QuestionTransformer;
use Illuminate\Http\Response;

/**
 * @group System-Questions
 */
class QuestionController extends Controller
{
    /**
     * show.
     *
     * @param $slug
     * @return Response
     */
    public function show()
    {
        $questions = [];
        foreach (Question::get()->groupBy('category') as $type => $type_questions) {
            $questions[] = [
                'category' => $type,
                'questions' => fractal($type_questions,QuestionTransformer::class)->toArray()['data'],
            ];
        }
        return $questions;
    }
}
