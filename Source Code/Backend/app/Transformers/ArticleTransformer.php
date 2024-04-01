<?php

namespace App\Transformers;

use App\Models\Address;
use App\Models\Article;
use Illuminate\Support\Str;
use App\Transformers\Traits\HasMap;

class ArticleTransformer extends BaseTransformer
{

    protected array $defaultIncludes = [
    ];
    protected array $availableIncludes = [
    ];

    /**
     * A Fractal transformer.
     *
     * @param Article $article
     * @return array
     */
    public function transform(Article $article)
    {
        $author = $article?->author?->toArray() ?: [];
        if ($article->author && $article->author->avatar) {
            $author['avatar'] = asset($article->author->getUrlFor('avatar'));
        }
        return [
            'id' => $article->id,
            'title' => $article->title,
            'slug' => $article->slug,
            'content' => $article->content,
            'excerpt' => Str::limit(strip_tags($article->content), $limit = 746, $end = '...'),
            'meta_title' => $article->meta_title,
            'meta_description' => $article->meta_description,
            'video_url' => $article->video_url,
            'category' => $article->category,
            'author' => $author,
            'created_at' => $article->created_at->format('d M Y'),
            'cover' => $article->cover ? asset($article->cover->getUrl()) : '',
        ];
    }
}
