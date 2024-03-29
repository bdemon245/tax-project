<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# About This Project
This is a real-world application that handles tax related operation like managing clients, sending invoices, handling reports, tracking events & appointments etc. We have developed an application that will play a crucial role in the digitalization of the IT sector in our country. The general public can quickly and reliably understand all the laws and regulations related to income tax through this application. It will eliminate the hassle of paperwork for ordinary people when submitting income tax. Anyone can access any book related to the law and can file any case pertaining to the law. The admin can monitor their employees' work through this application. Overall, this application will have a positive and convenient role in the advancement of Bangladesh's economy.

### Core Features:
- Used Laravel, Bootstrap, jQuery & vanilla JavaScript
- Developed in-app affiliate & bonus system
- Enabled e-commerce capabilities by providing options to buy Books & Services
- Integrated features Client Management, Invoice Management, Report Handling, Manual Payments Management, & Custom CMS etc
- Developed LMS to buy and sell courses
- Role & permission based administritive panel

### Test Credentials:
- [Test Website](https://tax-project.wisedev.xyz)
- Email: superadmin@gmail.com
- Password: 12345678

## Getting Started

- Fork this project.
- Clone from the forked repository.
- Install dependencies ```composer update && npm install```.
- Copy everything from ```env.example``` & paste them in .```env``` file.
- Run the server ```php artisan ser``` && ```npm run dev```.
 
 Open your project in https://localhost:8000
 

 
## Components & Helpers
For productivity & efficiency this project is included with some components and helper functions
 -### Blade Broilerplate
 - ##### After creating a blade file paste broilerplate in your blade file
  ```blade
 @extends('backend.layouts.app')


@section('content')
    <x-backend.ui.breadcrumbs :list="['Frontend', 'Hero', 'List']" />

    <x-backend.ui.section-card name="Hero Section">

        <!-- Your Content-->
        
    </x-backend.ui.section-card>
    

    @push('customJs')
        <script>
            
        </script>
    @endpush
@endsection

 ```
 - ### Components
 1. ##### Inputs
     - ###### TextInput
     ```blade
     <x-backend.form.text-input type="text" name="text_input" label="Text Input" class="other classes" required />
     ```
     - ###### ImageInput
     ```blade
     <x-backend.form.image-input name="image_input" image="image_url" class="other classes" />
     ```
     - ###### SelectInput
     ```blade
     <x-backend.form.select-input id="category" label="Category" name="category"
        placeholder="Choose Category...">
        @forelse ($categories as $category)
            <option value="{{ $category->id }}">
                {{ $category->name }}
            </option>
        @empty
            <option disabled>No Records Found!</option>
        @endforelse
    </x-backend.form.select-input>
    ```
 2. ##### UI Elements
     - ###### Button
     ```blade
     <x-backend.ui.button class="btn-primary">Create</x-backend.ui.button>
     <x-backend.ui.button type="edit" href="{{ route('role.edit', $role->id) }}" class="btn-sm" />
     <x-backend.ui.button type="delete" action="{{route('role.destroy', $role->id)}}" class="btn-sm" />
     <x-backend.ui.button type="custom" href="{{route("home")}}" class="btn-sm">GO Home</x-backend.ui.button>
     ```
     - ###### BreadCrumbs
     ```blade
     <x-backend.ui.breadcrumbs :list="['Frontend', 'Hero', 'List']" />
     ```
     - ###### Card Wrapper
     ```blade
    <x-backend.ui.section-card name="Hero List">
    {{-- Your Content --}}
    </x-backend.ui.section-card />
     ```
    - ###### Recent Active Invoice
     ```blade
    <x-backend.ui.recent-update-invoice :method="route('invoice.create')"/>
     ```
  3. ##### Tables
     - ###### BasicTable
     ```blade
      <x-backend.table.basic>
        <thead>
            <tr>
                <th>#</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($banners as $key => $banner)
                <tr>
                    <td>{{ ++$key }}</td>
                </tr>
            @endforeach
        </tbody>
      </x-backend.table.basic>
      
     ```
     4. Review
        ```blade
        <x-review-section :item="$expert" :reviews="$reviews" :slug="'expert_profile'" />
        ```
     
 - ### Helpers
 1. #### useImage
     > **useImage function takes an image from database and returns an url**
     - ###### Example:
     ```blade
     <img src="{{useImage($data->image)}}" alt="" />
     ```
 1. #### saveImage
      **saveImage function takes 3 arguments.**
      
     > - **Image from the request,** 
     > - **Which directory to save &**
     > - **A prefix to prepend to the image name (default prefix is "image").** 
     > - **The function returns the path where the image has been saved**
     - ###### Example:
     ```php
     $user = new User();
     $user->image = saveImage($request->image, 'avatar', 'user-image'); //This will return "uploads/avatar/user-image-154xxxxx.png"
     $user->save();
     ```
 1. #### updateFile
      **updateFile function takes 4 arguments.**
      
     > - **File from the request,** 
     > - **Old file path form database record,**
     > - **Which directory to save &**
     > - **A prefix to prepend to the file name (default prefix is "image").** 
     > - **The function returns the new path where the file has been saved**
     - ###### Example:
     ```php
     $user = new User();
     $old_path = $user->image;
     $user->image = updateFile($request->image, $old_path, 'avatar', 'user-image'); //This will update the file & return new path
     $user->save();
     ```
 
## Conventions to follow for this project

To be more consistant and productive to our team work in this project we must follow some conventions.

- ### Naming Conventions
 1. Use camelCaseing for
 > - **Blade Files.**
 > - **Function Names.**
 > - **Variables**
  
 
 2. Always organise your files in separate folders as needed
 3. Always `git fetch && git pull` before merging any branch into `main`
 4. Always sync your fork before `git fetch && git pull`
 5. Keep your sub-branch up to date by using `git merge main` (if working tree is clean)
 

- ### Resoucre Routes
Resource routes are a very simple way to write clean and consistant routes
```php
Route:resource('user', UserController::class);
```
This single line of code creates 6 general routes that is necessary for CRUD operations
The route names is corresponding to the controllers method names.

- ### Controllers
While resource routes creates a clean and consistant they need some predefined method names to work
So when ever you need a new controller use below command
```bash
php artisan make:controller NameController -r
```
this will create a controller with all the necessarry methods
### Additionally you can create everything you need while creating your Model
```bash
php artisan make:model ModelName -a
```
This command will create Controller, Requests, Migrations and Other files that you may need.


## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains over 2000 video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the Laravel [Patreon page](https://patreon.com/taylorotwell).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Cubet Techno Labs](https://cubettech.com)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[Many](https://www.many.co.uk)**
- **[Webdock, Fast VPS Hosting](https://www.webdock.io/en)**
- **[DevSquad](https://devsquad.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[OP.GG](https://op.gg)**
- **[WebReinvent](https://webreinvent.com/?utm_source=laravel&utm_medium=github&utm_campaign=patreon-sponsors)**
- **[Lendio](https://lendio.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
