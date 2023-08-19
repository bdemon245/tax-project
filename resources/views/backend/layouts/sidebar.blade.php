<style>
    .nav-second-level .mdi {
        font-size: 18px;
    }

    #side-menu>li>a .mdi {
        font-size: 22px !important;
    }
</style>
<div class="left-side-menu">

    <div class="h-100" data-simplebar>


        <!--- Sidemenu -->
        <div id="sidebar-menu">

            <ul id="side-menu">

                <li>
                    <a href="{{ route('dashboard') }}">
                        <i class="mdi mdi-view-dashboard-outline"></i>
                        <span> Dashboard </span>
                    </a>

                </li>
                <li class="menu-title mt-2">Frontend Manage</li>
                <li>
                    <a href="#homepage" data-bs-toggle="collapse">
                        <i class="mdi mdi-home-outline"></i>
                        <span>Homepage</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="homepage">
                        <ul class="nav-second-level">
                            <li>
                                <a href="#sidebarHeroSection" data-bs-toggle="collapse">
                                    <i class="mdi mdi-image-frame"></i>
                                    <span> Hero Section </span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <div class="collapse" id="sidebarHeroSection">
                                    <ul class="nav-second-level">
                                        <li>
                                            <a href="{{ route('banner.create') }}">Create Hero

                                            </a>
                                            <a href="{{ route('banner.index') }}">
                                                View Hero
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>

                            <li>
                                <a href="#productSection" data-bs-toggle="collapse">
                                    <i class="mdi mdi-gift-outline"></i>
                                    <span> Products </span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <div class="collapse" id="productSection">
                                    <ul class="nav-second-level">
                                        <li>
                                            <a href="{{ route('product.create') }}">Create Product</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('product.index') }}">View Products</a>
                                        </li>
                                        {{-- <li>
                                            <a href="{{ route('product-category.index') }}">Category</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('product-subcategory.index') }}">Sub-Category</a>
                                        </li> --}}
                                    </ul>
                                </div>
                            </li>

                            <li>
                                <a href="#appointmentSection" data-bs-toggle="collapse">
                                    <i class="mdi mdi-comment-edit-outline"></i>
                                    <span> Appointment Section </span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <div class="collapse" id="appointmentSection">
                                    <ul class="nav-second-level">
                                        <li>
                                            <a href="{{ route('appointment.index') }}">
                                                View All
                                            </a>
                                            <a href="{{ route('appointment.create') }}">Create

                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li>
                                <a href="#stats" data-bs-toggle="collapse">
                                    <i class="mdi mdi-chart-box-outline"></i>
                                    <span> Stats </span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <div class="collapse" id="stats">
                                    <ul class="nav-second-level">
                                        <li>
                                            <a href="#">
                                                <span>View</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <span>Create</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>

                            <li>
                                <a href="#sidebarInfoSection" data-bs-toggle="collapse">
                                    <i class="mdi mdi-information-outline"></i>
                                    <span> Info Section </span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <div class="collapse" id="sidebarInfoSection">
                                    <ul class="nav-second-level">
                                        <li>
                                            <a href="{{ route('info.index') }}">
                                                View Info
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('info.create') }}">Create Info
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>

                        </ul>
                    </div>
                </li>

                <li>
                    <a href="#services" data-bs-toggle="collapse">
                        <i class="mdi mdi-badge-account-horizontal-outline"></i>
                        <span>Service Page</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="services">
                        <ul class="nav-second-level">

                            <li>
                                <a href="#sidebarSerivces" data-bs-toggle="collapse">
                                    <i class="mdi mdi-badge-account-horizontal-outline"></i>
                                    <span>Services </span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <div class="collapse" id="sidebarSerivces">
                                    <ul class="nav-second-level">
                                        @php
                                            $categories = getRecords('service_categories');
                                        @endphp
                                        @foreach ($categories as $category)
                                            <li>
                                                <a href="{{ route('service.subs.view', $category->id) }}">
                                                    <span>{{ $category->name }}</span>
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </li>
                            <li>
                                <a href="#sidebarInfoSection" data-bs-toggle="collapse">
                                    <i class="mdi mdi-information-outline"></i>
                                    <span> Info Section </span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <div class="collapse" id="sidebarInfoSection">
                                    <ul class="nav-second-level">
                                        <li>
                                            <a href="{{ route('info.index') . '?page_type=service' }}">
                                                View Info
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('info.create') . '?page_type=service' }}">Create Info
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </li>

                <li>
                    <a href="#training" data-bs-toggle="collapse">
                        <i class="mdi mdi-book-education-outline"></i>
                        <span>Training</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="training">
                        <ul class="nav-second-level">
                            <li>
                                <a href="#courseSection" data-bs-toggle="collapse">
                                    <i class="mdi mdi-certificate-outline"></i>
                                    <span>Courses</span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <div class="collapse" id="courseSection">
                                    <ul class="nav-second-level">
                                        <li>
                                            <a href="{{ route('course.create') }}">Create Course</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('course.backend.index') }}">View Courses</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('video.create') . '?course_id=1' }}">Create Video</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('video.index') . '?course_id=1' }}">View Videos</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>

                            <li>
                                <a href="#caseStudySection" data-bs-toggle="collapse">
                                    <i class="mdi mdi-file-chart-outline"></i>
                                    <span> Case Studies </span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <div class="collapse" id="caseStudySection">
                                    <ul class="nav-second-level">
                                        <li>
                                            <a href="{{ route('case.study.package.backend.index') }}">Create Package

                                            </a>
                                            <a href="{{ route('case.study.package.backend.show.all') }}">
                                                View Package
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </li>




                <li>
                    <a href="{{ route('project-discussion.index') }}">
                        <i class="mdi mdi-view-dashboard-outline"></i>
                        <span>Project Discussion</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('industry.index') }}">
                        <i class="mdi mdi-view-dashboard-outline"></i>
                        <span>Industries</span>
                    </a>
                </li>
                <li>
                    <a href="#sidebarAboutPage" data-bs-toggle="collapse">
                        <i class="mdi mdi-view-dashboard-outline"></i>
                        <span> About Page</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarAboutPage">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('about.create') }}">Create

                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li>
                    <a href="#user-doc" data-bs-toggle="collapse">
                        <i class="mdi mdi-view-dashboard-outline"></i>
                        <span>User Documents</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="user-doc">
                        <ul class="nav-second-level">
                            <li>

                                <a href="{{ route('user-doc.index') }}">Show</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li>
                    <a href="#Section-manager" data-bs-toggle="collapse">
                        <i class="mdi mdi-view-dashboard-outline"></i>
                        <span>Section Manager</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="Section-manager">
                        <ul class="nav-second-level">
                            <li>

                                <a href="{{ route('partner-section.index') }}">About Us Partner Section</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li>
                    <a href="#invoiceSection" data-bs-toggle="collapse">
                        <i class="mdi mdi-view-dashboard-outline"></i>
                        <span>Invoice</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="invoiceSection">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('invoice.create') }}">
                                    Create
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('invoice.index') }}">
                                    View All
                                </a>
                            </li>

                        </ul>
                    </div>
                </li>

                <li>
                    <a href="{{ route('project.index') }}">
                        <i class="mdi mdi-view-dashboard-outline"></i>
                        <span>Projects Progress</span>
                    </a>
                </li>
                <li>
                    <a href="#user-appointmentSection" data-bs-toggle="collapse">
                        <i class="mdi mdi-view-dashboard-outline"></i>
                        <span>User Appointments</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="user-appointmentSection">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('user-appointments.index') }}">
                                    Pending For Approval
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('user-appointments.approved') }}">
                                    Approved
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('user-appointments.completed') }}">
                                    Completed
                                </a>
                            </li>

                        </ul>
                    </div>
                </li>
                <li>
                    <a href="#clientStudio" data-bs-toggle="collapse">
                        <i class="mdi mdi-view-dashboard-outline"></i>
                        <span>Client Studio</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="clientStudio">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('client-studio.index') }}">
                                    Create
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('client-studio.create') }}">
                                    View
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>


                <li>
                    <a href="{{ route('social-handle.index') }}">
                        <i class="mdi mdi-view-dashboard-outline"></i>
                        <span>Social Media</span>
                    </a>
                </li>
                <li>
                    <a href="#map-section" data-bs-toggle="collapse">
                        <i class="fe-map-pin"></i>
                        <span>Maps</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="map-section">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('map.create') }}">Create</a>
                                <a href="{{ route('map.index') }}">
                                    View All
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li>
                    <a href="#testimonialSection" data-bs-toggle="collapse">
                        <i class="mdi mdi-view-dashboard-outline"></i>
                        <span> Testimonial Section </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="testimonialSection">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('testimonial.index') }}">
                                    View All
                                </a>
                                <a href="{{ route('testimonial.create') }}">Create

                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li>
                    <a href="#promoCodeSection" data-bs-toggle="collapse">
                        <i class="mdi mdi-view-dashboard-outline"></i>
                        <span> Promo Code </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="promoCodeSection">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('promo-code.create') }}">Create Promo Code</a>
                            </li>
                            <li>
                                <a href="{{ route('promo-code.index') }}">View Promo Code</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li>
                    <a href="#timeTracking" data-bs-toggle="collapse">
                        <i class="mdi mdi-view-dashboard-outline"></i>
                        <span>Time Tracking</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="timeTracking">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('calendar.create') }}">Calendar</a>
                            </li>
                            <li>
                                <a href="{{ route('calendar.index') }}">View Events</a>
                            </li>
                        </ul>
                    </div>
                </li>


                <li>
                    <a href="#roleSection" data-bs-toggle="collapse">
                        <i class="mdi mdi-view-dashboard-outline"></i>
                        <span>Roles</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="roleSection">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('users.create') }}">Create User</a>
                            </li>
                            <li>
                                <a href="{{ route('users.index') }}">View User</a>
                            </li>
                            <li>
                                <a href="{{ route('role.create') }}">Create Role</a>
                            </li>
                            <li>
                                <a href="{{ route('role.index') }}">Manage Roles</a>
                            </li>
                        </ul>
                    </div>
                </li>



                <li>
                    <a href="#clientSection" data-bs-toggle="collapse">
                        <i class="mdi mdi-view-dashboard-outline"></i>
                        <span>Clients</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="clientSection">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('client.create') }}">Create</a>
                            </li>
                            <li>
                                <a href="{{ route('client.index') }}">View</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li>
                    <a href="#chalanSection" data-bs-toggle="collapse">
                        <i class="mdi mdi-view-dashboard-outline"></i>
                        <span>Chalan</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="chalanSection">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('chalan.create') }}">Create</a>
                            </li>
                            <li>
                                <a href="{{ route('chalan.index') }}">View</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li>
                    <a href="#return-formSection" data-bs-toggle="collapse">
                        <i class="mdi mdi-view-dashboard-outline"></i>
                        <span>Return</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="return-formSection">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('return-form.create') }}">Create</a>
                            </li>
                            <li>
                                <a href="{{ route('return-form.index') }}">View</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li>
                    <a href="#bookSection" data-bs-toggle="collapse">
                        <i class="mdi mdi-view-dashboard-outline"></i>
                        <span>Book</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="bookSection">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('book.create') }}">Create</a>
                            </li>
                            <li>
                                <a href="{{ route('book.index') }}">View</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li>
                    <a href="#expertProfile" data-bs-toggle="collapse">
                        <i class="mdi mdi-view-dashboard-outline"></i>
                        <span>Expert Profile</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="expertProfile">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('expert-profile.create') }}">Create</a>
                            </li>
                            <li>
                                <a href="{{ route('expert-profile.index') }}">View</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li>
                    <a href="#reviews" data-bs-toggle="collapse">
                        <i class="mdi mdi-view-dashboard-outline"></i>
                        <span>Reviews</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="reviews">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('backend.review.index') }}">All Reviews</a>
                            </li>
                            {{-- <li>
                                <a href="{{ route('review.index', 'service') }}">Service Reviews</a>
                            </li>
                            <li>
                                <a href="{{ route('review.index', 'book') }}">Book Reviews</a>
                            </li>
                            <li>
                                <a href="{{ route('review.index', 'expert-profile') }}">Expert Reviews</a>
                            </li> --}}
                        </ul>
                    </div>
                </li>
                <li>
                    <a href="#exams" data-bs-toggle="collapse">
                        <i class="mdi mdi-view-dashboard-outline"></i>
                        <span>Exams</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="exams">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('exams.index') }}">Exams</a>
                            </li>
                        </ul>
                    </div>
                </li>


                <li>
                    <a href="#payments" data-bs-toggle="collapse">
                        <i class="mdi mdi-view-dashboard-outline"></i>
                        <span>Order</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="payments">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('order.index') }}">Order</a>
                            </li>
                        </ul>
                    </div>
                </li>



                <li>
                    <a href="#taxCalculator" data-bs-toggle="collapse">
                        <i class="mdi mdi-view-dashboard-outline"></i>
                        <span>Tax Calculator</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="taxCalculator">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('tax-setting.create') }}">New Tax Setting</a>
                            </li>
                        </ul>
                    </div>
                    <div class="collapse" id="taxCalculator">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{ route('tax-setting.index') }}">View Tax Settings</a>
                            </li>
                        </ul>
                    </div>
                </li>


            </ul>
        </div>

    </div>
    <!-- End Sidebar -->

    <div class="clearfix"></div>

</div>
<!-- Sidebar -left -->

</div>
