@extends('frontend.layouts.app')
@section('main')
    <x-frontend.hero-section :banners="$banners" />
    <x-frontend.products-section :productCategory="$productCategory" />

    <section class="px-lg-5 px-2 my-5">
        <h4 class="text-center my-5" style="font-size:28px; font-weight:600;">{{ $subCategories[0]->serviceCategory->name }}
        </h4>
        <div class="row mx-lg-5 mx-2">
            @foreach ($subCategories as $sub)
                <div class="col-md-4 col-lg-3 col-sm-6">
                    <div class="d-flex flex-column align-items-center border rounded shadow p-2">
                        <a href="{{ route('service.sub', $sub->id) }}">
                            <img style="width:150px;aspect-ratio:1/1;" class="rounded rounded-circle mb-3"
                                src="{{ useImage($sub->image) }}" alt="">
                        </a>
                        <a class="text-dark text-capitalize" href="{{ route('service.sub', $sub->id) }}">
                            <h6>{{ $sub->name }}</h6>
                        </a>
                        <a href="{{ route('service.sub', $sub->id) }}"
                            class="text-center text-muted">{{ $sub->description }}</a>
                    </div>
                </div>
            @endforeach

        </div>
    </section>

    <x-frontend.appointment-section :sections="$appointmentSections" />

    </div><!-- /.modal -->
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
    <x-frontend.testimonial-section :testimonials="$testimonials">
    </x-frontend.testimonial-section>
@endsection

@pushOnce('customJs')
    <script>
        $(document).ready(function () {
            const submit = () => {
                $.ajax({
                    type: "post",
                    url: "{{route('review.store', 'book')}}",
                    headers: {
                        'X-CSRF-TOKEN': '{{csrf_token()}}'
                    }
                    success: function (response) {
                       console.log(response);
                    }
                });
            }

            $('#submit-btn').click(submit)
        });
    </script>
@endPushOnce
