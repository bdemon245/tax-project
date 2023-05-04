@extends('backend.layouts.app')
@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right mt-0">
                    <x-backend.ui.breadcrumbs :list="['Dashboard', 'info', 'Edit Info']" />
                </div>
                <h4 class="page-title">Edit Info</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <x-backend.ui.section-card name="Edit Info">
        <form action="{{ Route('info.update', $info) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-6 mt-3">
                    <x-backend.form.image-input name="info_image" :image="$info->image_url" />
                </div>

                <div class="col-md-6">
                    <x-backend.form.select-input id="section" label="SECTION" name="section"
                        placeholder="Choose Section..." onchange="getSectionTitle(this)">
                        {{-- <option selected disabled>Choose Section...</option> --}}
                        <option value="1" {{ $info->section_id === 1 ? 'selected' : '' }}>Section 1</option>
                        <option value="2" {{ $info->section_id === 2 ? 'selected' : '' }}>Section 2</option>
                    </x-backend.form.select-input>

                    <x-backend.form.text-input label="Title" type="text" required name="title"
                        value="{{ $info->title }}" />
                    <input type="hidden" name="old_title" value="{{ $info->title }}">

                    <x-backend.form.select-input id="section" label="STATUS" name="status">
                        {{-- <option selected disabled>Choose Section...</option> --}}
                        <option value="1" {{ $info->status ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ $info->status ? '' : 'selected' }}>Deactive</option>
                    </x-backend.form.select-input>

                    <div class="mt-1">
                        <label for="snow-editor" class="form-label">Description</label>
                        <div id="snow-editor" style="height: 100px;">{!! $info->description !!} </div>
                        <textarea class="d-none" name="description" id="description"></textarea>
                    </div>



                    <x-backend.ui.button class="btn-primary" onclick="descriptionAdd()">Update</x-backend.ui.button>

                </div>
            </div>
        </form>
    </x-backend.ui.section-card>
    <!-- end row-->
@endsection

@push('customJs')
    <script>
        const descriptionAdd = () => {
            $("#description").val($('.ql-editor').html())
        }

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
@endpush
