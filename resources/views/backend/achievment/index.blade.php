@extends('backend.layouts.app')
@section('content')
    <x-backend.ui.breadcrumbs :list="['Dashboard', 'Frontend', 'Achievement']" />

    <x-backend.ui.section-card name="Industries">
        <div class="mb-2">
            <a href="{{ route('achievements.create') }}" class="btn btn-sm btn-primary">(+) Create</a>
        </div>
        <x-backend.table.basic>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Image</th>
                    <th>Total Achievements</th>
                    <th>Title</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($data as $key=>$item)
                    <tr>
                        <td>{{ ++$key }}</td>
                        <td><img src="{{useImage($item->image)}}" alt="" width="80px"></td>
                        <td>{{ $item->total_user  }}</td>
                        <td>{{ $item->user  }}</td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('achievements.edit', $item) }}" class="btn btn-sm btn-info">Edit</a>
                                <form action="{{ route('achievements.destroy', $item) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <x-backend.ui.button class="btn-danger btn-sm text-capitalize">Delete
                                    </x-backend.ui.button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">
                            <h5 class="d-flex justify-content-center text-muted">No record found</h5>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </x-backend.table.basic>
    </x-backend.ui.section-card>
    <!-- end row-->
@endsection

{{-- @push('customJs')
    <script>
        const getSectionTitle = (e) => {
            const section_id = e.value
            let url = "{{ route('getInfoSectionTitle', ':sectionId') }}"
            url = url.replace(':sectionId', section_id)

            $.ajax({
                type: 'POST',
                url: url,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(title) {
                    $('input[name="title"]').val('')
                    $('input[name="old_title"]').val('')

                    $('input[name="title"]').val(title)
                    $('input[name="old_title"]').val(title)
                },
                error: function(error) {
                    $('input[name="title"]').val('')
                    $('input[name="old_title"]').val('')
                    console.log(error)
                }
            });
        }
    </script>
@endpush --}}