<section id="counter-section" class="px-lg-5 px-3 my-5">
    <h4 class="text-center mb-5 fs-3">Our Achievments</h4>
    <div class="row justify-content-center px-2">
        @foreach ($achievements as $item)
            <div class="col-6 col-md-4 col-xl-3 col-xxl-2 mb-1 px-2 align-items-center justify-content-center">
                <div class="px-1 bg-primary rounded">
                    <div class="card rounded" >
                        <div class="row" style="height: 6rem;">
                            <div class="col-6 ps-2 pe-0" style="height: 100%">
                                <img loading="lazy" class="rounded-start ps-1" style="width:100%;height:100%;"
                                src="{{ useImage($item->image) }}" alt="">
                            </div>
                            <div class="col-6 ps-0 pe-2">
                                <p class="m-0 fw-medium mt-2 text-center text-primary">{{ strlen($item->title) > 8 ? substr($item->title, 0, 7) .'...' : '' }}</p>
                                <h2 class="counter-up m-0 text-primary text-center" style="font-size: 32px; font-weight: 700;">
                                    {{ $item->count }}</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</section>