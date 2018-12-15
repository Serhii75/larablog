<?php

namespace App\Observers;

use App\Category;

class CategoryObserver
{
    /**
     * Handle the category "saving" event.
     *
     * @param  \App\Category  $category
     * @return void
     */
    public function saving(Category $category)
    {
        $category->slug = str_slug($category->name);
        $category->live = request()->live ? true : false;
    }
}
