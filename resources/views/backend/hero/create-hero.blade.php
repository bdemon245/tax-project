@extends('backend.layouts.app')

@section('content')
    
    <x-backend.ui.breadcrumbs :list="['Frontend', 'Hero', 'Create']" />

    <x-backend.ui.section-card name="Create Hero">
        <form action="{{ route('banner.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row">

                <div class="col-md-6 mt-3">
                    <label for="imagefile">
                        <input name="hero_image" type="file"
                            class="form-control d-none 
                                        @error('hero_image')
                                        is-invalid
                                        @enderror"
                            id="imagefile">
                        <img class="w-100 border border-2 border-primary" id="liveImage"
                            src="{{ asset('images/Placeholder_view_vector.svg.png') }}">
                    </label>
                    @error('hero_image')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="col-md-6">
                    <x-backend.form.text-input label="Title" type="text" name="title" />

                    <x-backend.form.text-input label="Sub Title" type="text" name="sub_title" />

                    <x-backend.form.text-input label="Button Link" type="text" name="button_link" />

                    <x-backend.ui.button class="btn-primary">Create</x-backend.ui.button>

                </div>

            </div>
        </form>
    </x-backend.ui.section-card>
@endsection
