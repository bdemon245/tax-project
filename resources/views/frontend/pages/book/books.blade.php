@php
    $banners = getRecords('banners');
@endphp
@extends('frontend.layouts.app')
@section('main')
    <x-frontend.hero-section :banners="$banners" />

    <section class="my-3 mx-xl-5 mx-lg-3 p-2">
        @if (count(request()->query()) > 0)
            <div class="d-flex justify-content-center align-items-center gap-3 p-2 my-2">
                <h5 class="mb-0 text-warning"><span class="mdi mdi-alert-outline text-warning font-18"></span>
                    Filters Applied</h5>
                <x-backend.ui.button type="custom" :href="route('books.view.all', $bookCategory->id)" class="btn-sm btn-outline-danger text-bold">
                    <span class="mdi mdi-close font-14"></span>
                    Clear Filters</x-backend.ui.button>
            </div>
        @else
            <div class="text-center fs-4 fw-medium text-dark my-3">Showing all books from {{ $bookCategory->name }}</div>
        @endif
        <div class="row">
            <div class="col-12">
                <button onclick="filter.clickHandler(event)" id="filter-menu-btn" data-target="#filter-menu"
                    class="btn btn-secondary text-dark rounded-1 d-lg-none mb-3 fw-medium waves-effect waves-dark">
                    <span class="mdi mdi-filter font-14"></span>
                    Filter
                </button>
            </div>
            <div id="filter-menu" class="col-lg-3 d-none d-lg-block ">
                <form action="{{ route('books.view.all', $bookCategory->id) }}" method="get">
                    <div class="filter-menu p-3 shadow bg-light rounded-2 ">
                        <div class="filters">
                            <x-range-slider class="" tooltips="false" name="price" id="price" :from="$minPrice"
                                :to="$maxPrice" :min-value="request()->query('price_from')" :max-value="request()->query('price_to')" step='1' icon="Yrs"
                                :is-dropdown="true"></x-range-slider>

                            <div class="card">
                                <div class="card-header py-1" role="button">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="">Authors</div>
                                        <span class="mdi mdi-chevron-down"></span>
                                    </div>
                                </div>
                                <div class="card-body">
                                    @php
                                        $slectedAuthor = request()->query('author');
                                    @endphp
                                    <x-form.selectize id="author" name="author" label="Filter by Author"
                                        placeholder="Select Author" :can-create="false">
                                        @foreach ($authors as $author)
                                            <option value="{{ $author }}" @selected($author === $slectedAuthor)>
                                                {{ $author }}</option>
                                        @endforeach
                                    </x-form.selectize>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header py-1" role="button">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="">Categories</div>
                                        <span class="mdi mdi-chevron-down"></span>
                                    </div>
                                </div>
                                <div class="card-body">
                                    @php
                                        $slectedCategories = collect(request()->query('categories'));
                                    @endphp
                                    @foreach ($categories as $category)
                                        <div>
                                            <input id="cat-{{ $category->id }}" type="checkbox" name="categories[]"
                                                value="{{ $category->id }}" @checked($slectedCategories->contains(fn($val) => $val == $category->id)) />
                                            <label
                                                for="cat-{{ $category->id }}">{{ str($category->name)->headline() }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="d-flex gap-3 justify-content-center mt-3">
                                <x-backend.ui.button type="custom" :href="route('books.view.all', $bookCategory->id)"
                                    class="btn-outline-primary mb-0">Clear</x-backend.ui.button>
                                <x-backend.ui.button class="btn-primary">Apply</x-backend.ui.button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-lg-9">
                <div class="grid sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-2">
                    @forelse ($books as $book)
                        <a class="rounded border-2 overflow-hidden" href="{{ route('books.show', $book->id) }}"
                            class="">
                            <img class="rounded-t-2 w-full h-[320px] object-cover" src="{{ useImage($book->thumbnail) }}"
                                alt="{{ $book->title }}">
                            <div class="bg-white rounded-b-2">
                                <h4 class="text-lg font-medium tracking-wider my-3 text-black text-center">
                                    {{ $book->title }}</h4>
                                <p class="text-center text-dark" style="font-size: 13px; line-height: 16px;">
                                    {!! str($book->description)->limit(100, '<span class="text-danger font-20 fw-bold">...</span>') !!}
                                </p>
                                <div class="mt-auto px-2 d-flex justify-content-between align-items-center py-2 w-100"
                                    style='background: rgba(14, 14, 14, 0.758);'>
                                    <x-avg-review-stars :avg="$book->reviews_avg_rating" icon-font="font-16" class="text-white" />
                                    <p class="mb-0 text-white fw-mideum">
                                        {{ $book->price }}
                                        <span class="mdi mdi-currency-bdt font-16"></span>
                                    </p>
                                </div>
                            </div>
                        </a>
                    @empty
                        <div class="col-span-full">
                            <div class="bg-light text-center">
                                <div class="d-flex flex-column justify-content-center" style="height: 50vh;">
                                    No Books Found!
                                </div>
                            </div>
                        </div>
                    @endforelse
                    <div class="col-12 mt-2">
                        <div class="paginator float-end">
                            {{ $books->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <x-frontend.testimonial-section :testimonials="$reviews">
    </x-frontend.testimonial-section>
@endsection
@pushOnce('customJs')
    <script src="{{ asset('frontend/filter.js') }}"></script>
@endPushOnce
@push('customJs')
    <script>
        const headers = $('section .card-header')
        headers.each((i, header) => {
            $(header).click(e => {
                let icon = $(header).find('.mdi');
                icon.toggleClass('mdi-chevron-down')
                icon.toggleClass('mdi-chevron-up')
                $(header).next().slideToggle();
            })
        })
    </script>
@endpush
