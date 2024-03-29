@extends('backend.layouts.app')


@section('content')
    <x-backend.ui.breadcrumbs :list="['Frontend', 'Create Promo Code']" />

    <x-backend.ui.section-card name="Create Promo Code">
        <form action="{{ route('promo-code.store') }}" method="POST">
            @csrf
            <div class="container rounded bg-white py-2">

                <div class="row justify-content-center">
                    <div class="col-md-5 col-sm-6">
                        <x-backend.form.text-input label="Promo Code" class="w-100" type="text" id="code"
                            name="code">
                        </x-backend.form.text-input>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <button type="button" id="code_btn"
                            class="btn btn-success waves-effect waves-light w-100 mt-sm-3 mb-2">Generate
                            Code</button>
                    </div>
                    <div class="col-12"></div>

                    <div class="col-md-3">
                        <x-backend.form.text-input label="Expired Date" type="date" name="expired_at" :value="Carbon\Carbon::now()
                            ->addDays(10)
                            ->format('Y-m-d')">
                        </x-backend.form.text-input>
                    </div>
                    <div class="col-md-3 col-6">
                        <x-backend.form.text-input label="Use Limit" type="number" value="1" id="limit"
                            name="limit">
                        </x-backend.form.text-input>
                    </div>
                    <div class="col-md-3 col-6">
                        <input type="text" name="is_discount" hidden value="false" id="is-discount">
                        <label class="form-label mb-0 p-0 col-12">Discount</label>
                        <div class="d-flex align-items-center justify-content-center border shadow-sm rounded" style="overflow: hidden;">

                            <input type="text" name="amount" class="border-0 rounded-0 w-100 ps-2"
                                style="outline:transparent;" placeholder="0" aria-label="Discunt">


                            <span id="discount-icon"
                            style="padding-top:.25rem;padding-bottom:0.25rem;"
                                class="mdi mdi-currency-bdt bg-light px-xxl-3 px-2 text-success font-18"></span>


                            <span onclick="toggleDiscount()"
                            style="padding-top:.25rem;padding-bottom:0.25rem;"
                                class="mdi mdi-swap-horizontal bg-blue px-xxl-3 px-2  text-white font-18"
                                style="cursor: pointer;"></span>

                        </div>
                    </div>
                    <div class="col-12"></div>

                    <div class="col-md-4 col-12">
                        <x-backend.form.select-input id="user_type" label="User Type" name="user_type">
                            <option selected value="all">All</option>
                            <option value="partner">Partner</option>
                            <option value="user">User</option>
                            <option value="individual">Individual</option>
                        </x-backend.form.select-input>
                    </div>
                    <div class="col-md-5 col-6">
                        <div id="user-select-wrapper" class="d-none mb-2">
                            <label for="user-select" class="form-label mb-0">Select User</label>
                            <select id="user-select" name="user_id" placeholde="Choose User...">
                            </select>
                        </div>
                    </div>
                    <div class="col-12"></div>



                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary rounded-3 waves-effect waves-light profile-button">
                            Create
                        </button>
                    </div>
                </div>


            </div>
        </form>
    </x-backend.ui.section-card>


    @push('customJs')
        {{-- Selectize start --}}
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/css/selectize.default.min.css"
            integrity="sha512-pTaEn+6gF1IeWv3W1+7X7eM60TFu/agjgoHmYhAfLEU8Phuf6JKiiE8YmsNC0aCgQv4192s4Vai8YZ6VNM6vyQ=="
            crossorigin="anonymous" referrerpolicy="no-referrer" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.15.2/js/selectize.min.js"
            integrity="sha512-IOebNkvA/HZjMM7MxL0NYeLYEalloZ8ckak+NDtOViP7oiYzG5vn6WVXyrJDiJPhl4yRdmNAG49iuLmhkUdVsQ=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        {{-- Selectize end --}}
        <script>
            const input = $('[name="code"]')
            const generateBtn = $('#code_btn')
            let userDefienedValue;
            input.on('input', function() {
                userDefienedValue = input.val().toUpperCase()
            })
            generateBtn.click(function() {
                let digits = Math.floor(Math.random() * (1000 - 10) + 10)
                if (!userDefienedValue) {
                    userDefienedValue = "TAXACT"
                }
                input.val(userDefienedValue + digits)
            })

            let isDiscount = false;
            const toggleDiscount = (e) => {
                isDiscount = !isDiscount
                $('#is-discount').val(isDiscount)
                $('#discount-icon').toggleClass('mdi-currency-bdt')
                $('#discount-icon').toggleClass('mdi-percent-outline')

            }
            let userSelectize = $('#user-select').selectize({
                maxItems: 1,
                sortField: 'text',
                create: false,
                labelField: 'name',
                valueField: 'id',
                searchField: ['id', 'name', 'user_name', 'email', 'phone'],
                placeholder: 'Type name, username, id, email to search'
            });
            $('#user_type').on('change', function getUsers(e) {
                const userType = e.target.value

                if (userType === 'individual') {
                    $(e.target).parent().parent().toggleClass('col-12')
                    $(e.target).parent().parent().toggleClass('col-6')
                    $('#user-select-wrapper').removeClass('d-none');
                    let url = "{{ route('getUsers') }}"
                    $.ajax({
                        type: 'POST',
                        url: url,
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        success: function(data) {
                            console.log(data);
                            console.log(data);
                            const selectize = userSelectize[0].selectize
                            selectize.clear();
                            selectize.clearOptions();
                            selectize.load(set => set(data));
                        },
                        error: function(error) {
                            console.log(error)
                        }
                    });
                } else {
                    $('#user-select-wrapper').addClass('d-none');
                    $(e.target).parent().parent().addClass('col-12')
                    $(e.target).parent().parent().removeClass('col-6')
                }
            })
        </script>
    @endpush
@endsection
