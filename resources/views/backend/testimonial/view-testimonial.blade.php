@extends('backend.layouts.app')

@section('content')
    @push('customCss')
        <style>
            .paginate {
                float: right;
            }

            div.dataTables_paginate {
                margin: 0;
                white-space: nowrap;
                text-align: right;
                display: none !important;
            }
        </style>
    @endpush
    <x-backend.ui.breadcrumbs :list="['Frontend', 'Testimonial', 'View']" />

    <x-backend.ui.section-card name="Testimonial List">
        <x-backend.table.basic :items="$testimonials">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Image</th>
                    <th>name</th>
                    <th>comment</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($testimonials as $key => $testimonial)
                    <tr>
                        <td>{{ ++$key }}</td>
                        <td><img loading="lazy" src="{{ useImage($testimonial->avatar) }}" alt="{{ $testimonial->title }}" width="80px"
                                loading="lazy" /></td>
                        <td>{{ $testimonial->name }}</td>
                        <td>{{ Str::limit($testimonial->comment, 20, '...') }}</td>
                        <td>
                            <a href="{{ route('testimonial.edit', $testimonial->id) }}" class="btn btn-info btn-sm">Edit</a>
                            <form action="{{ route('testimonial.destroy', $testimonial->id) }}" method="post"
                                class="d-inline-block">
                                @csrf
                                @method('DELETE')
                                <x-backend.ui.button class="btn-danger btn-sm text-capitalize">Delete</x-backend.ui.button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </x-backend.table.basic>
    </x-backend.ui.section-card>
@endsection
