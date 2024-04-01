<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\FrontendAboutUs;
use Illuminate\Http\Request;
use App\Models\FrontendHomepage;
use App\Models\FrontendRewardProgram;
use Illuminate\Http\JsonResponse;
use App\Presenters\CommonPresenter;
use App\Transformers\ArticleTransformer;
use App\Transformers\FrontendAboutUsTransformer;
use App\Transformers\FrontendHomepageTransformer;
use App\Transformers\FrontendRewardProgramTransformer;
use Illuminate\Contracts\Support\Renderable;

/**
 * @group Article
 */
class FrontendController extends Controller
{
    public function __construct()
    {
        //        $this->middleware(['auth']);
    }
    
    public function homepage()
    {
        $page = FrontendHomepage::first();
        return response()->json([
            'homepage' => fractal($page, new FrontendHomepageTransformer())->toArray()['data']
        ]);
    }

    public function reward_program()
    {
        $page = FrontendRewardProgram::first();
        return response()->json([
            'reward_program' => fractal($page, new FrontendRewardProgramTransformer())->toArray()['data']
        ]);
    }

    public function about_us()
    {
        $page = FrontendAboutUs::first();
        return response()->json([
            'about_us' => fractal($page, new FrontendAboutUsTransformer())->toArray()['data']
        ]);
    }
}
