@extends('backend.layouts.app')
@section('content')
    <x-backend.ui.breadcrumbs :list="['Dashboard', 'Frontend', 'Result']" />

    <x-backend.ui.section-card name="Industries">
    
        <x-backend.table.basic>
            <thead>
                <tr>
                    <th>#</th>
                    <th>User</th>
                    <th>Exams</th>
                    <th>Total Marks</th>
                    <th>Passing Marks</th>
                    <th>Right Answer</th>
                    <th>You Got</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($result as $key=>$item)
                    <tr>
                        <td>{{ ++$key }}</td>
                        <td>{{ $item->user->user_name  }}</td>
                        <td>{{ $item->exam->name  }}</td>
                        <td>{{ $item->exam->total_marks  }}</td>
                        <td>{{ $item->exam->passing_marks  }}</td>
                        <td>{{ $item->right  }}</td>
                        <td>{{ $item->obtained_marks  }}</td>
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