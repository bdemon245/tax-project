@extends('backend.layouts.app')
@section('content')
    <x-backend.ui.breadcrumbs :list="['Dashboard', 'Frontend', 'Achievement']" />

    <x-backend.ui.section-card name="Achievment Create">
        <div class="mb-3">
            <a href="{{ route('achievements.index') }}" class="btn-info btn btn-sm">BACK</a>
        </div>
        <form action="{{ route('achievements.store') }}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6 mt-3">
                            <x-backend.form.image-input name="image" />
                        </div>
                       <div class="col-md-6">
                         <div class="col-md-12 mb-2">
                             <x-backend.form.text-input label="Total Achivement" placeholder="Total Achivement"
                                 type="number" name="total_user" />
                         </div>
                         <div class="col-md-12 mb-2">
                             <x-backend.form.text-input label="Title" placeholder="Title" type="text" name="user" />
                         </div>
                       </div>
                    </div>
                </div>
            </div>
            <div>
                <x-backend.ui.button class="btn-primary btn btn-sm">Create</x-backend.ui.button>
            </div>
        </form>
    </x-backend.ui.section-card>
    <!-- end row-->
@endsection
