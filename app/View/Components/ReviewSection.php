<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ReviewSection extends Component {
    /**
     * Create a new component instance.
     */
    public function __construct(
        public $reviews = [],
        public $item,
        public $slug,
        public $canReview = false
    ) {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string {
        return view('components.review-section');
    }
}
