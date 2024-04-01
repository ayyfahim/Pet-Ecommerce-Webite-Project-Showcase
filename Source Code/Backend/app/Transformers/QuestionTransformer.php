<?php

namespace App\Transformers;

use App\Models\Question;

class QuestionTransformer extends BaseTransformer
{

    protected array $defaultIncludes = [
    ];
    protected array $availableIncludes = [
    ];

    /**
     * A Fractal transformer.
     *
     * @param Question $question
     * @return array
     */
    public function transform(Question $question)
    {
        $data = [
            'question' => $question->question,
            'answer' => $question->answer,
        ];
        return $data;
    }
}
