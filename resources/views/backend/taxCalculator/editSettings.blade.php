@extends('backend.layouts.app')
@section('content')
    <x-backend.ui.breadcrumbs :list="['Management', 'Tax Calculator', 'Create Settings']" />

    <x-backend.ui.section-card name="Add New Settings">
        <div class="container">
            <x-btn-back></x-btn-back>
            {{-- Slot template --}}
            <div class="row border rounded p-1 mb-2 d-none" id="slot">
                <h5 class="fw-medium mb-1">Slot <span class="slot-count"></span></h5>
                <div class="row only-tax">
                    <div class="col-md-3">
                        <x-backend.form.text-input type="number" name="tax_slot_from[]" placeholder="Range From"
                            label="Range From" />
                    </div>
                    <div class="col-md-3">
                        <x-backend.form.text-input type="number" name="tax_slot_to[]" placeholder="Range To"
                            label="Range To" />
                    </div>
                    <div class="col-md-2">
                        <x-backend.form.text-input type="number" name="slot_percentage[]" placeholder="Percentage"
                            label="Percentage(%)" />
                    </div>
                    <div class="col-md-4">
                        <x-backend.form.select-input name="slot_types[]" id="slot-type" label="Slot Type"
                            placeholder="Select an option">
                            <option value="income">Income</option>
                            <option value="turnover">Turnover</option>
                            <option value="asset">Asset</option>
                        </x-backend.form.select-input>
                    </div>
                </div>
                <div class="row services only-others d-none">
                    <div class="service-wrapper">
                        <div class="row" id="service">
                            <div class="col-md-3">
                                <x-backend.form.text-input type="number" name="others_slot_from[]" placeholder="Range From"
                                    label="Range From" disabled />
                            </div>
                            <div class="col-md-3">
                                <x-backend.form.text-input type="number" name="others_slot_to[]" placeholder="Range To"
                                    label="Range To" disabled />
                            </div>
                            <div class="col-md-3">
                                <x-backend.form.text-input id="service-name" name="services[]" placeholder="Service Name"
                                    label="Service Name" disabled />
                            </div>
                            <div class="col-md-3">
                                <div class="mb-2">
                                    <label class="form-label mb-0 p-0 col-12">Amount</label>
                                    <div class="d-flex align-items-center justify-content-center border shadow-sm rounded"
                                        style="overflow: hidden;">
                                        <input type="text" id="is-discount" name="is_discounts_fixed[]" value="false"
                                            hidden disabled>
                                        <input type="number" id="discount-amount" name="discount_amounts[]"
                                            class="amount border-0 rounded-0 w-100 ps-2" style="outline:transparent;"
                                            placeholder="0" aria-label="Discont" disabled>


                                        <span id="slot-1-service-discount-icon-1"
                                            style="padding-top:.25rem;padding-bottom:0.25rem;"
                                            class="mdi mdi-percent-outline bg-light px-xxl-3 px-2 text-success font-18"></span>


                                        <span onclick="service.discount.toggle(this)"
                                            style="padding-top:.25rem;padding-bottom:0.25rem;"
                                            class="mdi mdi-swap-horizontal bg-blue px-xxl-3 px-2  text-white font-18"
                                            style="cursor: pointer;"></span>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <form action="{{ route('tax-setting.store') }}" class="row" method="post">
                @csrf
                <div class="col-12">
                    <h4 class="text-center fw-bold">Tax Informations</h4>
                    <div class="row">
                        <div class="col-md-3">
                            <x-backend.form.text-input required name="name" placeholder="Name" label="Name"
                                :value="$taxSetting->name" />
                        </div>
                        <div class="col-md-3">
                            <x-backend.form.select-input required name="for" id="for" label="Tax For"
                                placeholder="Select an option">
                                <option value="individual" @selected($taxSetting->for === 'individual')>Individual</option>
                                <option value="firm" @selected($taxSetting->for === 'firm')>Firm</option>
                                <option value="company" @selected($taxSetting->for === 'company')>Company</option>
                            </x-backend.form.select-input>
                        </div>
                        <div class="col-md-3">
                            <x-backend.form.select-input required name="type" id="type" label="Tax Type"
                                placeholder="Select an option">
                                <option value="tax" @selected($taxSetting->type === 'tax')>Tax</option>
                                <option value="others" @selected($taxSetting->type === 'others')>Others</option>
                            </x-backend.form.select-input>
                        </div>
                        <div class="col-md-3">
                            <x-backend.form.text-input required type="number" name="min_tax" placeholder="Min. Tax"
                                label="Min. Tax" :value="$taxSetting->min_tax" />
                        </div>
                    </div>
                    <div
                        class="row only-company only-tax {{ $taxSetting->for !== 'company' && $taxSetting->type === 'others' ? 'd-none' : '' }}">
                        <div class="col-md-4">
                            <x-backend.form.text-input type='number' name="turnover_percentage"
                                placeholder="Percentage For Turnover" label="Percentage For Turnover(%)"
                                @if ($taxSetting->for === 'company' && $taxSetting->type === 'tax') :value="$taxSetting->turnover_percentage" @endif
                                disabled />
                        </div>
                        <div class="col-md-4">
                            <x-backend.form.text-input type='number' name="income_percentage"
                                placeholder="Percentage For Income" label="Percentage For Income(%)"
                                @if ($taxSetting->for === 'company' && $taxSetting->type === 'tax') :value="$taxSetting->income_percentage" @endif disabled />
                        </div>
                        <div class="col-md-4">
                            <x-backend.form.text-input type='number' name="asset_percentage"
                                placeholder="Percentage For Asset" label="Percentage For Asset(%)"
                                @if ($taxSetting->for === 'company' && $taxSetting->type === 'tax') :value="$taxSetting->asset_percentage" @endif disabled />
                        </div>
                    </div>


                    <div class="row only-individual {{ $taxSetting->for !== 'individual' ? 'd-none' : '' }}">
                        <div class="col-md-6">
                            <x-backend.form.text-input type="number" name="tax_free_male"
                                placeholder="Tax Free Male" label="Tax Free Male(৳)" :value="$taxSetting->tax_free->male ?? null" />
                        </div>
                        <div class="col-md-6">
                            <x-backend.form.text-input type="number" name="tax_free_female"
                                placeholder="Tax Free Female" label="Tax Free Female(৳)" :value="$taxSetting->tax_free->female ?? null" />
                        </div>
                    </div>
                    <div class="row not-individual {{ $taxSetting->for === 'individual' ? 'd-none' : '' }}">
                        <x-backend.form.text-input type="number" name="tax_free" placeholder="Tax Free"
                            label="Tax Free(৳)" :value="$taxSetting->tax_free->amount ?? null" />
                    </div>

                </div>
                <div class="col-12 mb-2 slots-container">
                    <h4 class="text-center fw-bold">Slots</h4>
                    <div id="slot-wrapper" class="mb-2">
                        @foreach ($taxSetting->slots as $slot)
                            <div class="row border  rounded p-1 mb-2" id="slot-1">
                                <input type="hidden" name="slot_ids[]" value="{{ $slot->id }}">
                                <div class="d-none slot-count">1</div>
                                <h5 class="fw-medium mb-1">Slot 1</h5>
                                <div class="row only-tax">
                                    <div class="col-md-3">
                                        <x-backend.form.text-input type="number" name="tax_slot_from[]"
                                            placeholder="Range From" label="Range From" :value="$slot->from" />
                                    </div>
                                    <div class="col-md-3">
                                        <x-backend.form.text-input type="number" name="tax_slot_to[]"
                                            placeholder="Range To" label="Range To" :value="$slot->to" />
                                    </div>
                                    <div class="col-md-2">
                                        <x-backend.form.text-input type="number" name="slot_percentage[]"
                                            placeholder="Percentage" label="Percentage(%)" :value="$slot->tax_percentage" />
                                    </div>
                                    <div class="col-md-4">
                                        <x-backend.form.select-input name="slot_types[]" id="slot-type" label="Slot Type"
                                            placeholder="Select an option">
                                            <option value="income" @selected($slot->type === 'income')>Income</option>
                                            <option value="turnover" @selected($slot->type === 'turnover')>Turnover</option>
                                            <option value="asset" @selected($slot->type === 'asset')>Asset</option>
                                        </x-backend.form.select-input>
                                    </div>
                                </div>
                                <div class="row services only-others d-none">
                                    <div class="service-wrapper">
                                        <div class="row" id="service">
                                            <div class="col-md-3">
                                                <x-backend.form.text-input type="number" name="others_slot_from[]"
                                                    placeholder="Range From" label="Range From" :value="$slot->from"
                                                    disabled />
                                            </div>
                                            <div class="col-md-3">
                                                <x-backend.form.text-input type="number" name="others_slot_to[]"
                                                    placeholder="Range To" label="Range To" :value="$slot->to" disabled />
                                            </div>
                                            <div class="col-md-3">
                                                <x-backend.form.text-input id="service-name" name="services[]"
                                                    placeholder="Service Name" label="Service Name" :value="$slot->service"
                                                    disabled />
                                            </div>
                                            <div class="col-md-3">
                                                <div class="mb-2">
                                                    <label class="form-label mb-0 p-0 col-12">Amount</label>
                                                    <div class="d-flex align-items-center justify-content-center border shadow-sm rounded"
                                                        style="overflow: hidden;">
                                                        <input type="text" id="is-discount"
                                                            name="is_discounts_fixed[]"
                                                            value="{{ $slot->is_discount_fixed ? 'true' : 'false' }}"
                                                            hidden disabled>
                                                        <input type="number" id="discount-amount"
                                                            name="discount_amounts[]" :value="$slot - > amount"
                                                            class="amount border-0 rounded-0 w-100 ps-2"
                                                            style="outline:transparent;" placeholder="0"
                                                            aria-label="Discont" disabled>


                                                        <span id="slot-1-service-discount-icon-1"
                                                            style="padding-top:.25rem;padding-bottom:0.25rem;"
                                                            class="mdi {{ $slot->is_discount_fixed ? 'mdi-currency-bdt' : 'mdi-percent-outline' }} bg-light px-xxl-3 px-2 text-success font-18"></span>


                                                        <span onclick="service.discount.toggle(this)"
                                                            style="padding-top:.25rem;padding-bottom:0.25rem;"
                                                            class="mdi mdi-swap-horizontal bg-blue px-xxl-3 px-2  text-white font-18"
                                                            style="cursor: pointer;"></span>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="d-flex justify-content-center gap-2 mb-2">
                        <span role="button" id="slot-delete-btn" onclick="slot.decrement()"
                            class="d-none mdi mdi-delete text-danger bg-soft-danger rounded rounded-circle px-1"></span>
                        <span role="button" onclick="slot.increment()"
                            class="mdi mdi-plus text-info bg-soft-info rounded rounded-circle px-1"></span>
                    </div>

                </div>
                <x-backend.ui.button class="btn-primary">Submit</x-backend.ui.button>
            </form>
        </div>

    </x-backend.ui.section-card>
@endsection

@push('customJs')
    <script>
        let slot = {}
        let service = {}
        let ui = {}

        function incrementService(e) {

        }

        $(document).ready(function() {
            slot = {
                count: parseInt('{{ count($taxSetting->slots) }}'),
                slotWrapper: $('#slot-wrapper'),
                increment: function() {
                    let count = ++this.count;
                    let html = $('#slot').clone()
                    let serviceCount = html.find('#service-count').val(count)
                    let taxType = $('select[name="type"]')
                    if (taxType.val() === 'others') {
                        // show others slots
                        html.find('.only-others').removeClass('d-none')
                        html.find('.only-others').find('input').attr('disabled', false)
                        html.find('.only-others').find('select').attr('disabled', false)

                        // hide tax slots
                        html.find('.only-tax').addClass('d-none')
                        html.find('.only-tax').find('input').attr('disabled', true)
                        html.find('.only-tax').find('select').attr('disabled', true)
                    }
                    html.find('.slot-count').text(count)
                    this.slotWrapper.append(html.removeClass('d-none'))
                    this.showBtn()
                },
                decrement: function() {
                    if (this.count > 1) {
                        this.slotWrapper.children().last().remove()
                        this.count--;
                    } else {
                        console.log('At least on slot is required');
                    }
                    if (this.count === 1) {
                        this.hideBtn()
                    }
                },
                addSlot: function(count) {
                    service.count = 1
                    this.slotWrapper.append(this.slot(count))
                    service.toggleServices();
                },
                hideBtn: function() {
                    $('#slot-delete-btn').addClass('d-none')
                },
                showBtn: function() {
                    $('#slot-delete-btn').removeClass('d-none')
                }
            }
            service = {
                toggle: function() {
                    let taxType = $('select[name="type"]')
                    if (taxType.val() === 'others') {
                        $('.only-others').removeClass('d-none')
                        $('.only-tax').addClass('d-none')
                    }
                    taxType.on('change', e => {
                        switch (e.target.value) {
                            case 'tax':
                                // hide others slots
                                $('.only-others').addClass('d-none')
                                let inputs = $('.only-others').find('input')
                                let selects = $('.only-others').find('select')
                                inputs.attr('disabled', true)
                                selects.attr('disabled', true)
                                // show tax slots
                                $('.only-tax').removeClass('d-none')
                                $('.only-tax').find('input').attr('disabled', false)
                                $('.only-tax').find('select').attr('disabled', false)
                                break;
                            case 'others':
                                // show others slots
                                $('.only-others').removeClass('d-none')
                                $('.only-others').find('input').attr('disabled', false)
                                $('.only-others').find('select').attr('disabled', false)

                                // hide tax slots
                                $('.only-tax').addClass('d-none')
                                $('.only-tax').find('input').attr('disabled', true)
                                $('.only-tax').find('select').attr('disabled', true)
                                break;
                            default:
                                break;
                        }
                    })
                },
                discount: {
                    isFixed: false,
                    toggle: function(element) {
                        console.log(element);
                        this.isFixed = !this.isFixed;
                        let isDiscount = $(element).parent().find('#is-discount')
                        console.log(isDiscount);
                        isDiscount.val(this.isFixed)
                        let icon = $(element).prev()
                        icon
                            .toggleClass('mdi-currency-bdt')
                            .toggleClass('mdi-percent-outline')
                    },

                },

            }
            service.toggle()


            ui = {
                toggle: {
                    onlyIndividual: (e) => {
                        let type = $('select[name="type"]')
                        if (e.target.value !== 'individual') {
                            $('.not-individual').removeClass('d-none')
                            $('.not-individual').find('input').attr('disabled', false)
                            $('.only-individual').addClass('d-none')
                            $('.only-individual').find('input').attr('disabled', true)
                            $('.only-individual').find('select').attr('disabled', true)
                        } else {
                            $('.not-individual').addClass('d-none')
                            $('.not-individual').find('input').attr('disabled', true)
                            $('.only-individual').removeClass('d-none')
                            $('.only-individual').find('input').attr('disabled', false)
                            $('.only-individual').find('select').attr('disabled', false)
                        }
                    },
                    onlyCompany: (e) => {
                        if (e.target.value === 'company') {
                            $('.only-company').removeClass('d-none')
                            $('.only-company').find('input').attr('disabled', false)
                            $('.only-company').find('select').attr('disabled', false)
                        } else {
                            $('.only-company').addClass('d-none')
                            $('.only-company').find('input').attr('disabled', true)
                            $('.only-company').find('select').attr('disabled', true)
                        }
                    },
                    slotContainer: () => {
                        let type = $('select[name="type"]');
                        let forTax = $('select[name="for"]');
                        if (forTax.val() == 'company' && type.val() == 'tax') {
                            $('.slots-container').addClass('d-none')
                            $('.slots-container').find('input').attr('disabled', true)
                            $('.slots-container').find('select').attr('disabled', true)
                        } else {
                            $('.slots-container').removeClass('d-none')
                            $('.slots-container').find('input').attr('disabled', false)
                            $('.slots-container').find('select').attr('disabled', false)
                        }
                    }
                }
            }


            $('select[name="type"]').on('change', e => {
                ui.toggle.slotContainer()
            });
            $('select[name="for"]').on('change', e => {
                ui.toggle.slotContainer()
                ui.toggle.onlyCompany(e)
                ui.toggle.onlyIndividual(e)
            });

            // trigering events based on values

            // show delete btn
            if (slot.count > 1) {
                slot.showBtn()
            }
        });
    </script>
@endpush
