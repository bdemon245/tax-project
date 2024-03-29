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
    <x-backend.ui.breadcrumbs :list="['Frontend', 'Footer', 'Social-Media']" />

    <x-backend.ui.section-card name="Social-Media Handle">

        {{-- Social media handle option --}}
        <form action="{{ route('social-handle.store') }}" method="POST">
            @csrf
            <div class="row">
                @can('manage social media')
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <x-backend.form.select-input id="selectize-optgroup" label="Social" name="social"
                                        placeholder="Select Platform" required>
                                        @foreach (socialItems() as $item)
                                            <option value="{{ json_encode($item) }}">
                                                {{ $item['name'] }}
                                            </option>
                                        @endforeach
                                    </x-backend.form.select-input>
                                </div> <!-- end col -->
                                <div class="col-md-12">
                                    <x-backend.form.text-input type="text" name="social_link" label="Link"
                                        placeholder="https:://" required />
                                </div>
                                {{-- social media link  --}}
                                <div class="mt-3"><button class="btn btn-primary w-100 btn-sm profile-button"
                                        type="submit">Add Account</button>
                                </div>
                            </div>
                        </div> <!-- end card-body -->
                    </div> <!-- end card -->
                </div>
                @endcan
        </form>
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">All Sub-Categories</h4>
                    <x-backend.table.basic :items="$socials">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Platform</th>
                                <th>Link</th>
                                @can('manage social media')
                                <th>Actions</th>
                                @endcan
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($socials as $key => $social_media)
                                <tr>
                                    <td>{{ ++$key }}</td>
                                    <td>{{ $social_media->name }}</td>
                                    <td>{{ $social_media->link }}</td>
                                    @can('manage social media')
                                    <td>
                                        <div class="btn-group">
                                            <x-backend.ui.button type="edit"
                                                href="{{ route('social-handle.edit', $social_media) }}" class="btn-sm" />
                                            <form action="{{ route('social-handle.destroy', $social_media->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <x-backend.ui.button class="text-capitalize btn-sm btn-danger">Delete
                                                </x-backend.ui.button>
                                            </form>
                                        </div>
                                    </td>
                                    @endcan
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="100%"><span>No data found.</span></td>
                                </tr>
                            @endforelse
                        </tbody>
                    </x-backend.table.basic>
                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
        </div>






        {{-- Show all categories table --}}
        <div class="row">

        </div>

    </x-backend.ui.section-card>


    @push('customJs')
        <script></script>
    @endpush
@endsection
