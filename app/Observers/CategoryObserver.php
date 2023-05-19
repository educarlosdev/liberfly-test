<?php

namespace App\Observers;


use App\Models\Category;

class CategoryObserver
{
    public function creating(Category $category): void
    {
        $category->user_id = auth()->check() ? auth()->id() : $category->user_id;
    }
}
