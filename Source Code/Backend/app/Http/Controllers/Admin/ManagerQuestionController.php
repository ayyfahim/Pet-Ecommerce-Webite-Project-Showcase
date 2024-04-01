<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Traits\Question\Filtration;
use App\Http\Requests\QuestionRequest;
use App\Models\Question;
use App\Presenters\CommonPresenter;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

class ManagerQuestionController extends Controller
{
    use Filtration;
    public function __construct()
    {
    }

    /**
     * index.
     *
     * @queryParam q search in name
     * @param Request $request
     * @return Factory|View
     */
    public function index(Request $request)
    {
        $questions = Question::query();
        if ($this->filterQueryStrings()) {
            $questions = $this->filterData($request, $questions);
        }
        $questions = app(CommonPresenter::class)->paginate($questions->get());

        return view('pages.questions.index', [
            'categories' => Question::select('category')->groupBy('category')->pluck('category')->toArray(),
            'questions' => $questions,
            'breadcrumb' => $this->breadcrumb([], 'Questions')
        ]);
    }

    /**
     * create.
     */
    public function create()
    {
        return view('pages.questions.add', [
            'categories' => Question::select('category')->groupBy('category')->pluck('category')->toArray(),
            'breadcrumb' => $this->breadcrumb([
                [
                    'title' => 'Questions',
                    'route' => route('question.admin.index')
                ]
            ], 'Add Question'),
        ]);
    }

    /**
     * store.
     *
     * @param QuestionRequest $request
     * @return JsonResponse|RedirectResponse|Redirector
     */
    public function store(QuestionRequest $request)
    {
        Question::create($request->all());
        return $this->returnCrudData(__('system_messages.common.create_success'), route('question.admin.index'));
    }

    /**
     * edit.
     *
     * @param mixed $question
     * @return Factory|View
     */
    public function edit(Question $question)
    {
        return view('pages.questions.edit', [
            'question' => $question,
            'categories' => Question::select('category')->groupBy('category')->pluck('category')->toArray(),
            'breadcrumb' => $this->breadcrumb([
                [
                    'title' => 'Questions',
                    'route' => route('question.admin.index')
                ]
            ], 'Edit Question'),
        ]);
    }

    /**
     * update.
     *
     * @param mixed $question
     * @param QuestionRequest $request
     * @return JsonResponse|RedirectResponse|Redirector
     */
    public function update(Question $question, QuestionRequest $request)
    {
        $question->update($request->except('redirect_to'));
        return $this->returnCrudData(__('system_messages.common.update_success'), $request->redirect_to);
    }

    /**
     * delete.
     *
     * @param Question $question
     * @param Request $request
     * @return JsonResponse|RedirectResponse|Redirector
     * @throws \Throwable
     */
    public function destroy(Question $question, Request $request)
    {
        DB::transaction(function () use ($question) {
            $question->user_questions()->delete();
            $question->delete();
        });

        return $this->returnCrudData(__('system_messages.common.delete_success'), $request->redirect_to ?: url()->previous());
    }
}
