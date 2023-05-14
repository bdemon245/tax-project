@extends('backend.layouts.app')


@section('content')
    <x-backend.ui.breadcrumbs :list="['Backend', 'client', 'List']" />

    <x-backend.ui.section-card name="Client Section">

        <x-backend.table.basic>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Client Name</th>
                    <th>Company Name</th>
                    <th>Present Address</th>
                    <th>Prmentat Address</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($clients as $key => $client)
                    <tr>
                        <td>{{ ++$key }}</td>
                        <td>{{ $client->client_name }}</td>
                        <td>{{ $client->company_name }}</td>
                        <td>{{ $client->present_address }}</td>
                        <td>{{ $client->parmentat_address }}</td>
                        <td>
                            <x-backend.ui.button type="edit" class="btn-primary btn-sm" href="{{route('client.edit',$client->id)}}">Create</x-backend.ui.button>
                            <x-backend.ui.button type="delete" class="btn-primary btn-sm" action="{{route('client.destroy', $client->id)}}"></x-backend.ui.button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </x-backend.table.basic>


    </x-backend.ui.section-card>


    @push('customJs')
        <script></script>
    @endpush
@endsection