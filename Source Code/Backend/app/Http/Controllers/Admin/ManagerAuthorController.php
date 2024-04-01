<?php

namespace App\Http\Controllers\Admin;

use App\Models\Article;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\AuthorRequest;
use App\Models\Author;
use App\Presenters\CommonPresenter;
use Exception;

class ManagerAuthorController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    /**
     * index
     *
     * @param Request $request
     * @return Renderable
     */
    public function index(Request $request)
    {
        $authors = Author::query();
        return view('pages.authors.manager.index', [
            'authors' => app(CommonPresenter::class)->paginate($authors->get()),
            'breadcrumb' => $this->breadcrumb([], 'Authors')
        ]);
    }

    public function create()
    {
        return view('pages.authors.manager.create', array_merge([], [
            'breadcrumb' => $this->breadcrumb([
                [
                    'title' => 'Authors',
                    'route' => route('author.admin.index')
                ]
            ], 'Add New Author'),

        ]));
    }

    public function store(AuthorRequest $request)
    {
        try {
            $data = $request->except('avatar');
            $article = Author::create($data);
            if ($avatar = $request->avatar) {
                $article->addHashedMedia($avatar)
                    ->toMediaCollection('avatar');
            }
            return $this->returnCrudData('Created Successfully', route('author.admin.index'));
        } catch (Exception $exception) {
            return $this->returnCrudData($exception->getMessage(), null, 'error');
        }
    }

    public function edit(Author $author)
    {
        return view('pages.authors.manager.edit', array_merge([], [
            'breadcrumb' => $this->breadcrumb([
                [
                    'title' => 'Authors',
                    'route' => route('author.admin.index')
                ]
            ], 'Edit Author'),
            'author' => $author,
        ]));
    }

    public function update(AuthorRequest $request, Author $author)
    {
        try {
            $data = $request->except('avatar', 'redirect_to');
            $author->update($data);
            if ($avatar = $request->avatar) {
                $author->addHashedMedia($avatar)
                    ->toMediaCollection('avatar');
            }
            return $this->returnCrudData('Updated Successfully', $request->redirect_to);
        } catch (Exception $exception) {
            return $this->returnCrudData($exception->getMessage(), null, 'error');
        }
    }

    public function destroy(Author $author)
    {
        $author->delete();
        return $this->returnCrudData('Deleted Successfully', route('author.admin.index'));
    }
}
