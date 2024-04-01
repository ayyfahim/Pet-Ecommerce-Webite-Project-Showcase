<?php

namespace App\Observers;

use App\Acme\Core;
use App\Models\ConfigData;
use App\Models\Category;
use App\Notifications\NotifyUserOfCategory;
use App\Notifications\SendNotification;

class CategoryObserver
{
    /**
     * Handle the order "creating" event.
     * @param Category $category
     */
    public function creating(Category $category)
    {
        if (!$category->status_id) {
            $arr = Category::getStatusFor();
            $category->status_id = $arr['status']->firstWhere('order', 1)->id;
        }
    }

    /**
     * Handle the category "created" event.
     *
     * @param Category $category
     */
    public function created(Category $category)
    {
    }

    /**
     * Handle the category "updating" event.
     *
     * @param Category $category
     */
    public function updating(Category $category)
    {
        $category->user_id = auth()->user()->id;
    }

    /**
     * Handle the category "updated" event.
     *
     * @param Category $category
     */
    public function updated(Category $category)
    {

    }

    /**
     * Handle the category "deleted" event.
     *
     * @param Category $category
     */
    public function deleted(Category $category)
    {
    }

    /**
     * Handle the category "restored" event.
     *
     * @param Category $category
     */
    public function restored(Category $category)
    {
    }

    /**
     * Handle the category "force deleted" event.
     *
     * @param Category $category
     */
    public function forceDeleted(Category $category)
    {
    }
}
