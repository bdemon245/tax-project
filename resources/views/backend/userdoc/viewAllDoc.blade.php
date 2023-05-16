@extends('backend.layouts.app')

@section('content')
    <!-- start page title -->
    <x-backend.ui.breadcrumbs :list="['Dashboard', 'User Documents', 'Show']" />
    <!-- end page title -->

    <x-backend.ui.section-card name="Users Documents">
        <x-backend.ui.button type="custom" href="{{ route('user-doc-type.index') }}" class="mb-3 btn-sm btn-success">Document type +</x-backend.ui.button>
            <x-backend.table.basic>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>User Info</th>
                        <th>Document Title</th>
                        <th>Images</th>
                        <th>Action</th>
                    </tr>
                </thead>
            
                <tbody>
                    @forelse ($upload_documents as $key => $document)
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td>
                                <p class="mb-0">Name: {{ $document->user->name }}</p>
                                <p class="mb-0 text-muted">Username: {{ $document->user->user_name }}</p>
                                <p class="mb-0 text-muted">Phone: {{ $document->user->phone }}</p>
                                <a href="mailto:{{$document->user->email}}">
                                    <p class="mb-0 text-muted">Email: {{ $document->user->email }}</p>   
                                </a>
                            </td>
                            <td>{{ $document->title }}</td>
                            <td id="tooltip-container">
                                <div class="avatar-group">
                                    @foreach (json_decode($document->images) as $image)
                                    <a href="javascript: void(0);" class="avatar-group-item" data-bs-container="#tooltip-container" data-bs-toggle="tooltip" data-bs-placement="top">
                                        <img src="{{ useImage($image) }}" class="rounded-circle border border-light border-3 avatar-md" alt="friend">
                                    </a>  
                                    @endforeach
                                </div>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <x-backend.ui.button type="custom" href="{{ route('user-doc-type.edit', $document->id) }}" class="btn-sm btn-info">View</x-backend.ui.button>
                                        <x-backend.ui.button type="delete" action="#" class="btn-sm"></x-backend.ui.button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        
                    @endforelse
                    {{-- {{ dd(json_decode($upload_documents[0]->images)) }} --}}
                </tbody>
            </x-backend.table.basic>
    </x-backend.ui.section-card>
    @push('customJs')
        <script></script>
    @endpush
@endsection
