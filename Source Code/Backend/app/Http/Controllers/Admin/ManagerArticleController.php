<?php

namespace App\Http\Controllers\Admin;

use App\Models\Article;
use App\Http\Controllers\Traits\Article\Filtration;
use App\Presenters\CommonPresenter;
use Exception;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\ArticleRequest;
use Illuminate\Routing\Redirector;
use App\Http\Controllers\Controller;
use App\Models\Author;

class ManagerArticleController extends Controller
{
    use Filtration;

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
        $articles = Article::query();
        if ($this->filterQueryStrings()) {
            $articles = $this->filterData($request, $articles);
        }
        return view('pages.articles.manager.index', [
            'articles' => app(CommonPresenter::class)->paginate($articles->get(), 'sort_order', 'asc'),
            'breadcrumb' => $this->breadcrumb([], 'Articles')
        ]);
    }

    /**
     * create
     *
     * @return Renderable
     */
    public function create()
    {
        return view('pages.articles.manager.create', array_merge($this->commonData(), [
            'breadcrumb' => $this->breadcrumb([
                [
                    'title' => 'Articles',
                    'route' => route('article.admin.index')
                ]
            ], 'Add New Article'),
            'authors' => Author::get()->sortBy('name'),

        ]));
    }

    /**
     * store
     *
     * @param ArticleRequest $request
     * @return JsonResponse|RedirectResponse|Redirector
     */
    public function store(ArticleRequest $request)
    {
        try {
            $data = $request->except('slug', 'cover', 'avatar');
            $data['slug'] = $request->slug ?: $request->title;
            if (Article::where('slug', $data['slug'])->count()) {
                $data['slug'] .= '-' . rand(1111, 9999);
            }
            $article = Article::create($data);
            if ($cover = $request->cover) {
                $article->addHashedMedia($cover)
                    ->toMediaCollection('cover');
            }

            if ($avatar = $request->avatar) {
                $article->addHashedMedia($avatar)
                    ->toMediaCollection('avatar');
            }
            return $this->returnCrudData('Created Successfully', route('article.admin.index'));
        } catch (Exception $exception) {
            return $this->returnCrudData($exception->getMessage(), null, 'error');
        }
    }

    /**
     * edit
     *
     * @param Article $article .
     * @return Renderable
     */
    public function edit(Article $article)
    {
        return view('pages.articles.manager.edit', array_merge($this->commonData(), [
            'breadcrumb' => $this->breadcrumb([
                [
                    'title' => 'Articles',
                    'route' => route('article.admin.index')
                ]
            ], 'Edit Article'),
            'article' => $article,
            'authors' => Author::get()->sortBy('name'),
        ]));
    }

    /**
     * update
     *
     * @param ArticleRequest $request
     * @param Article $article .
     * @return JsonResponse|RedirectResponse|Redirector
     */
    public function update(ArticleRequest $request, Article $article)
    {
        try {
            $data = $request->except('slug', 'cover', 'avatar', 'redirect_to');
            $data['slug'] = $request->slug ?: $request->title;
            if (Article::where('slug', $data['slug'])->where('id', '!=', $article->id)->count()) {
                $data['slug'] .= '-' . rand(1111, 9999);
            }
            $article->update($data);
            if ($cover = $request->cover) {
                $article->addHashedMedia($cover)
                    ->toMediaCollection('cover');
            }
            if ($avatar = $request->avatar) {
                $article->addHashedMedia($avatar)
                    ->toMediaCollection('avatar');
            }
            return $this->returnCrudData('Updated Successfully', $request->redirect_to);
        } catch (Exception $exception) {
            return $this->returnCrudData($exception->getMessage(), null, 'error');
        }
    }

    /**
     * destroy
     *
     * @param Article $article .
     * @return JsonResponse|RedirectResponse|Redirector
     * @throws Exception
     */
    public function destroy(Article $article)
    {
        $article->delete();
        return $this->returnCrudData('Deleted Successfully', route('article.admin.index'));
    }

    // Other Methods

    private function commonData()
    {
        return [
            'status' => Article::getStatusFor('status'),
            'categories' => array_unique(
                array_merge(
                    array_filter(Article::select('category')->groupBy('category')->pluck('category')->toArray()), [
                    'Blog'
                ])),
        ];
    }
}
