@extends('frontend.layouts.app')
@section('main')
    <x-frontend.hero-section :banners="$banners" />
    @php
        $productCat = \App\Models\ProductCategory::where('name', 'Standard Package (tax)')
            ->with(['productSubCategories', 'productSubCategories.products'])
            ->first();
        
    @endphp
    <section class="mb-5">
        <div class="card-body container-fluid px-5">
            <h2 class="header-title h4 mt-4 text-center">{{ $productCat->name }}</h2>
            <div class=" d-flex justify-content-center">
                <p class="text-justify" style="max-width: 100ch; font-weight:500;">
                    {{ $productCat->description }}</p>
            </div>
            <div class="container d-flex justify-content-center">
                <ul class="nav nav-pills navtab-bg justify-content-center" role="tablist">
                    @foreach ($productCat->productSubCategories as $key => $subCat)
                        <li class="nav-item mb-2 md-mb-0" role="presentation">
                            <a href="#{{ str($subCat->name)->slug() . '-' . $subCat->id }}" data-bs-toggle="tab"
                                aria-expanded="{{ $key === 0 ? 'true' : 'false' }}"
                                aria-selected="{{ $key === 0 ? 'true' : 'false' }}" role="tab"
                                class="text-capitalize nav-link {{ $key === 0 ? 'active' : '' }}" tabindex="-1">
                                {{ $subCat->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="container-fluid">
                <div class="tab-content">
                    @foreach ($productCat->productSubCategories as $key => $subCat)
                        <div class="tab-pane {{ $key === 0 ? 'active' : '' }}"
                            id="{{ str($subCat->name)->slug() . '-' . $subCat->id }}" role="tabpanel">
                            <div class="product-wrapper">
                                @foreach ($subCat->products as $product)
                                    <x-frontend.product-card :$product />
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    @php
        $services = [
            [
                'id' => 1,
                'name' => 'Tax Services',
                'description' => fake()->realText(),
                'image' => picsum(fake()->word()),
            ],
            [
                'id' => 2,
                'name' => 'Vat Services',
                'description' => fake()->realText(),
                'image' => picsum(fake()->word()),
            ],
            [
                'id' => 3,
                'name' => 'Misc Services',
                'description' => fake()->realText(),
                'image' => picsum(fake()->word()),
            ],
        ];
    @endphp
    <section class="px-lg-5 px-2 my-5">
        <h4 class="text-center my-5" style="font-size:28px; font-weight:600;">Services</h4>
        <div class="row mx-lg-5 mx-2 service-category justify-content-center">
            @foreach ($services as $sub)
                <div class="col-md-4 col-lg-3 col-sm-6 mb-3">
                    <div class="d-flex flex-column align-items-center border rounded shadow-sm p-2 h-100">
                        <a href="{{ route('service.category', $sub['id']) }}">
                            <img loading="lazy" style="width:clamp(80px, 120px, 150px);aspect-ratio:1/1;"
                                class="rounded rounded-circle mb-3" src="{{ useImage($sub['image']) }}" alt="">
                        </a>
                        <a class="text-dark text-capitalize" href="{{ route('service.category', $sub['id']) }}">
                            <h6>{{ $sub['name'] }}</h6>
                        </a>
                        <a href="{{ route('service.category', $sub['id']) }}"
                            class="text-center text-muted">{{ $sub['description'] }}</a>
                    </div>
                </div>
            @endforeach

        </div>
    </section>

    <x-frontend.appointment-section :sections="$appointmentSections" />

    <x-frontend.achievements :achievements="$achievements" />


    <x-frontend.info-section :title="$infos1[0]->title" class="text-capitalize">
        @foreach ($infos1 as $info)
            <x-frontend.info-card :$info />
        @endforeach
    </x-frontend.info-section>
    <x-frontend.info-section :title="$infos2[0]->title" class="text-danger text-capitalize">
        @foreach ($infos2 as $info)
            <x-frontend.info-card :$info />
        @endforeach
    </x-frontend.info-section>
    <x-frontend.testimonial-section>
    </x-frontend.testimonial-section>
@endsection

@pushOnce('customJs')
    <script>
        $(document).ready(function() {
            const submit = () => {
                $.ajax({
                    type: "post",
                    url: "{{ route('review.store', 'book') }}",
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                    success: function(response) {
                        console.log(response);
                    }
                });
            }

            $('#submit-btn').click(submit)
        });
    </script>

    <script>
        $(document).ready(function() {
            var counter = 0
            window.onload = () => {
                if (!counter && isScrolledIntoView(document.getElementById("counter-section"))) {
                    counter = 1
                    counterUp()
                }
            }

            window.addEventListener("scroll", () => {
                console.log(counter)
                if (!counter && isScrolledIntoView(document.getElementById("counter-section"))) {
                    counter = 1
                    counterUp()
                }
                // else if (!isScrolledIntoView(document.getElementById("counter-section")) && counter) {
                //     counter = 0
                // }
            })

            function isScrolledIntoView(el) {
                let rect = el.getBoundingClientRect();
                let elemTop = rect.top;
                let elemBottom = rect.bottom;

                let isVisible = (elemTop >= 0) && (elemBottom <= window.innerHeight);
                // let isVisible = elemTop < window.innerHeight && elemBottom >= 0;
                return isVisible;
            }

            function counterUp() {
                $('.counter-up').each(function() {
                    let countTo = $(this).text()
                    $(this).prop('Counter', 0).animate({
                        Counter: countTo
                    }, {
                        duration: 2000,
                        easing: 'swing',
                        step: function(now) {
                            $(this).text(Math.ceil(now));
                        },
                        complete: function() {
                            $(this).text($(this).Counter);
                        }
                    });
                });
            }
        });
    </script>
@endPushOnce
