<?php

namespace App\Observers;

use App\Models\Article;

class ArticleObserver
{
    /**
     * Handle the package info "creating" event.
     *
     * @param Article $article
     * @return void
     */
    public function creating(Article $article)
    {
        $arr = Article::getStatusFor();
        $article->status_id = $arr['status']->firstWhere('order', 1)->id;
        $article->user_id = auth()->id();
    }

    /**
     * Handle the package info "created" event.
     *
     * @param Article $article
     * @return void
     */
    public function created(Article $article)
    {
    }

    /**
     * Handle the package info "updating" event.
     *
     * @param Article $article
     * @return void
     */
    public function updating(Article $article)
    {
        //
    }
    /**
     * Handle the package info "updated" event.
     *
     * @param Article $article
     * @return void
     */
    public function updated(Article $article)
    {
        //
    }

    /**
     * Handle the package info "deleted" event.
     *
     * @param Article $article
     * @return void
     */
    public function deleted(Article $article)
    {
        //
    }

    /**
     * Handle the package info "restored" event.
     *
     * @param Article $article
     * @return void
     */
    public function restored(Article $article)
    {
        //
    }

    /**
     * Handle the package info "force deleted" event.
     *
     * @param Article $article
     * @return void
     */
    public function forceDeleted(Article $article)
    {
        //
    }
}
