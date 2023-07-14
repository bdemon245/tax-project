@extends('backend.layouts.app')

@section('content')
    <x-backend.ui.breadcrumbs :list="['User', 'Appointments']" />

    <x-backend.ui.section-card name="User Appointments">
        <x-backend.table.basic>
            <thead>
                <tr>
                    <th>#</th>
                    <th>User Info</th>
                    <th>Date & Time</th>
                    <th>Status</th>
                    <th>Location</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($appointments as $appointment)
                    <tr>
                        <td>1</td>
                        <td>
                            <p class="mb-1">
                                <strong>Name:</strong> <span>{{ $appointment->name }}</span>
                            </p>
                            <p class="mb-1">
                                <strong>Email:</strong> <span>{{ $appointment->email }}</span>
                            </p>
                            <p class="mb-1">
                                <strong>Phone:</strong> <span>{{ $appointment->phone }}</span>
                            </p>
                            <div class="d-flex gap-3">
                                <p class="mb-1">
                                    <strong>District:</strong> <span>{{ $appointment->district }}</span>
                                </p>
                                <p class="mb-1">
                                    <strong>Thana:</strong> <span>{{ $appointment->thana }}</span>
                                </p>
                            </div>
                        </td>
                        <td>
                            <strong class="d-block">Date:
                                {{ Carbon\Carbon::parse($appointment->date)->format('d M, Y') }}</strong>
                            <strong class="d-block">Time: {{ $appointment->time }}</strong>

                        </td>
                        <td>
                            @if ($appointment->is_completed)
                                <span class="badge bg-soft-success text-success p-1 fs-6">Completed</span>
                            @else
                                <span class="badge bg-warning p-1 fs-6">Yet to complete</span>
                            @endif
                        </td>
                        @isset($appointment->map_id)
                            <td>
                                <strong>Location: {{ $appointment->map->location }}</strong>
                                <strong class="d-block">Address:</strong>
                                <p class="text-muted">
                                    {{ $appointment->map->address }}
                                </p>
                            </td>
                        @else
                            <td>
                                <span class="badge bg-info p-1 fs-6">
                                    Virtual
                                </span>
                            </td>
                        @endisset
                        <td>
                            <form action="{{ route('user-appointments.complete', $appointment->id) }}" method="post"
                                class="d-inline-block">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-success waves-effect waves-light btn-sm">
                                    <span class="mdi mdi-check-all fs-5"></span>
                                    <span class="fs-6">Mark as completed</span>
                                </button>
                            </form>
                            <form action="{{ route('user-appointments.destroy', $appointment->id) }}" method="post"
                                class="d-inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    Delete
                                </button>
                            </form>


                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="bg-light">
                            <div class="text-center text-muted">
                                No Appointments Found
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>



        </x-backend.table.basic>

    </x-backend.ui.section-card>
@endsection