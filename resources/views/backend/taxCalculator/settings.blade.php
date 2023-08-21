@extends('backend.layouts.app')
@section('content')
    <style>
        .bg-soft-pink {
            background: hsl(350, 52%, 86%);
        }

        .text-pink {
            color: hsl(350, 95%, 74%);
        }
    </style>
    <x-backend.ui.breadcrumbs :list="['Management', 'Tax Calculator', 'Settings']" />

    <x-backend.ui.section-card name="Settings">
        <div class="container">
            <x-btn-back class="mb-2"></x-btn-back>
            <x-backend.ui.button type="custom" :href="route('tax-setting.create')" class="btn-sm btn-success mb-2">Create</x-backend.ui.button>
            <x-backend.table.basic>
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Details</th>
                        <th>Free</th>
                        <th class="text-center">Slots</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($taxSettings as $key => $tax)
                        <tr>
                            <td>
                                {{ ++$key }}
                            </td>
                            <td class="fw-bold">
                                <div>
                                    <span class="">Name: </span>
                                    <span>{{ $tax->name }}</span>
                                </div>
                                <div class="d-flex gap-2 mb-1">
                                    <div>
                                        <span class="">Type: </span>
                                        <span
                                            class="fw-bold text-capitalize {{ $tax->type === 'tax' ? 'text-success' : 'text-blue' }}">{{ $tax->type }}</span>
                                    </div>
                                    <div>
                                        <span class="">For: </span>
                                        <span class="fw-bold text-capitalize text-warning">{{ $tax->for }}</span>
                                    </div>
                                </div>
                                <div class="p-1 bg-soft-primary d-inline rounded rounded-3 text-primary">
                                    <span class="">Turnover Percentage: </span>
                                    <span>{{ $tax->turnover_percentage }} %</span>
                                </div>
                            </td>
                            <td class="fw-bold">
                                <div class="mb-1">
                                    <div class="p-1 bg-soft-blue text-blue d-inline rounded rounded-3">
                                        <span class="">Male: </span>
                                        <span>{{ $tax->tax_free->male }}</span> <span
                                            class="mdi mdi-currency-bdt font-16"></span>
                                    </div>
                                </div>
                                <div>
                                    <div class="p-1 bg-soft-pink text-pink d-inline rounded rounded-3">
                                        <span class="">Female: </span>
                                        <span>{{ $tax->tax_free->female }}</span> <span
                                            class="mdi mdi-currency-bdt font-16"></span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <table class="table table-borderless mb-0">
                                    <thead class="bg-soft-dark text-dark">
                                        <tr>
                                            <th class="p-1">From</th>
                                            <th class="p-1">To</th>
                                            <th class="p-1">Difference</th>
                                            <th class="p-1">Tax(%)</th>
                                            <th class="p-1">Minium(৳)</th>
                                            <th class="p-1">Type</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($tax->slots as $slot)
                                            <tr class="fw-medium mb-0">

                                                <td class="p-1">{{ $slot->from }} <span
                                                        class="mdi mdi-currency-bdt font-16"></span>
                                                </td>
                                                <td class="p-1">{{ $slot->to }} <span
                                                        class="mdi mdi-currency-bdt font-16"></span>
                                                </td>
                                                <td class="p-1">{{ $slot->difference }} <span
                                                        class="mdi mdi-currency-bdt font-16"></span> </td>
                                                <td class="p-1">{{ $slot->tax_percentage }} <span
                                                        class="mdi mdi-percent-outline font-16"></span> </td>
                                                <td class="p-1">{{ $slot->min_tax }} <span
                                                        class="mdi mdi-currency-bdt font-16"></span>
                                                </td>
                                                <td class="p-1 text-success text-capitalize">{{ $slot->type }}</span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </td>
                            <td>
                                <x-backend.ui.button type="edit" :href="route('tax-setting.edit', $tax->id)" class="btn-sm"></x-backend.ui.button>
                                <x-backend.ui.button type="delete" :action="route('tax-setting.destroy', $tax->id)" class="btn-sm"></x-backend.ui.button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                </thead>
            </x-backend.table.basic>
        </div>

    </x-backend.ui.section-card>
@endsection

@push('customJs')
@endpush