<?php

namespace App\Observers;

class CategoryObserver
{
    public function deleted(\App\Models\Category $category)
    {
        $category->product()->delete();

    }
}
