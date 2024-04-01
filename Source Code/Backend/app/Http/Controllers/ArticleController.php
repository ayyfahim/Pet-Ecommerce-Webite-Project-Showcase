<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Presenters\CommonPresenter;
use App\Transformers\ArticleTransformer;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
/**
 * @group Article
 */
class ArticleController extends Controller
{
    public function __construct()
    {
//        $this->middleware(['auth']);
    }

    /**
     * index
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $articles = Article::isActive()->latest();

        $title = str_replace('"', '\"', $request->q);
        $title = str_replace("'", "\'", $title);
        $articles->when($title, function ($query) use ($title) {
            $query->whereRaw('lower(title) like "%' . strtolower($title) . '%"');
        });

        $articles = app(CommonPresenter::class)->paginate($articles->get());
        if ($request->expectsJson()) {
            return $this->returnPaginatedApiData(
                $articles, new ArticleTransformer(), [
                ]
            );
        }
    }

    /**
     * show
     *
     * @param $slug
     * @return Renderable
     */
    public function show($slug)
    {
        $article = Article::where('slug', $slug)->isActive()->firstOrFail();
        return response()->json([
            'article' => fractal($article, new ArticleTransformer())->toArray()['data'],
            'related_articles' => fractal(Article::where('id', '!=', $article->id)->whereHas('user', function ($query) use ($article) {
                $query->where('user_id', $article->user_id);
            })->take(3)->get(), new ArticleTransformer())->toArray()['data'],
        ]);
    }

    // Other Methods

    private function commonData()
    {
        return [
        ];
    }
}
