<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ConfigData;
use Illuminate\Http\Request;
use App\Models\FrontendAboutUs;
use App\Models\FrontendHomepage;
use Illuminate\Http\JsonResponse;
use App\Presenters\CommonPresenter;
use App\Models\FrontendRewardProgram;
use App\Transformers\ArticleTransformer;
use Illuminate\Contracts\Support\Renderable;
use App\Transformers\FrontendAboutUsTransformer;
use App\Transformers\FrontendHomepageTransformer;
use App\Transformers\FrontendRewardProgramTransformer;

/**
 * @group Article
 */
class SocialMediaController extends Controller
{
    public function getInstagramFeed()
    {
        $insta_username = ConfigData::where('group', 'social_media')->where('title', 'instagram')->first()->value;

        if (!$insta_username) {
            return $this->returnCrudData('No Instagram Username found', null, 'error');
        }

        $exist = \Dymantic\InstagramFeed\Profile::for($insta_username);

        if (!$exist) {
            return $this->returnCrudData('No Authorized Instagram Username found', null, 'error');
        }

        $profile = \Dymantic\InstagramFeed\Profile::where('username', $insta_username)->first();

        return response()->json([
            'feed' => $profile->feed()->collect()
        ]);
    }
}
