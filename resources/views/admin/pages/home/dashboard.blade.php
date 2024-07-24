@extends('admin.templates.template-admin')

@section('contect')
<!-- Page main content START -->
<div class="page-content-wrapper border">

    <!-- Title -->
    <div class="row">
        <div class="col-12 mb-3">
            <h1 class="h3 mb-2 mb-sm-0">Dashboard</h1>
        </div>
    </div>

    <!-- Counter boxes START -->
    <div class="row g-4 mb-4">
        <!-- Counter item -->
        <div class="col-md-6 col-xxl-3">
            <div class="card card-body bg-warning bg-opacity-15 p-4 h-100">
                <div class="d-flex justify-content-between align-items-center">
                    <!-- Digit -->
                    <div>
                        <h2 class="purecounter mb-0 fw-bold" data-purecounter-start="0" data-purecounter-end="1958" data-purecounter-delay="200">0</h2>
                        <span class="mb-0 h6 fw-light">Completed Courses</span>
                    </div>
                    <!-- Icon -->
                    <div class="icon-lg rounded-circle bg-warning text-white mb-0"><i class="fas fa-tv fa-fw"></i></div>
                </div>
            </div>
        </div>

        <!-- Counter item -->
        <div class="col-md-6 col-xxl-3">
            <div class="card card-body bg-purple bg-opacity-10 p-4 h-100">
                <div class="d-flex justify-content-between align-items-center">
                    <!-- Digit -->
                    <div>
                        <h2 class="purecounter mb-0 fw-bold" data-purecounter-start="0" data-purecounter-end="1600"	data-purecounter-delay="200">0</h2>
                        <span class="mb-0 h6 fw-light">Enrolled Courses</span>
                    </div>
                    <!-- Icon -->
                    <div class="icon-lg rounded-circle bg-purple text-white mb-0"><i class="fas fa-user-tie fa-fw"></i></div>
                </div>
            </div>
        </div>

        <!-- Counter item -->
        <div class="col-md-6 col-xxl-3">
            <div class="card card-body bg-primary bg-opacity-10 p-4 h-100">
                <div class="d-flex justify-content-between align-items-center">
                    <!-- Digit -->
                    <div>
                        <h2 class="purecounter mb-0 fw-bold" data-purecounter-start="0" data-purecounter-end="1235"	data-purecounter-delay="200">0</h2>
                        <span class="mb-0 h6 fw-light">Course In Progress</span>
                    </div>
                    <!-- Icon -->
                    <div class="icon-lg rounded-circle bg-primary text-white mb-0"><i class="fas fa-user-graduate fa-fw"></i></div>
                </div>
            </div>
        </div>

        <!-- Counter item -->
        <div class="col-md-6 col-xxl-3">
            <div class="card card-body bg-success bg-opacity-10 p-4 h-100">
                <div class="d-flex justify-content-between align-items-center">
                    <!-- Digit -->
                    <div>
                        <div class="d-flex">
                            <h2 class="purecounter mb-0 fw-bold" data-purecounter-start="0" data-purecounter-end="845"	data-purecounter-delay="200">0</h2>
                            <span class="mb-0 h2 ms-1">hrs</span>
                        </div>
                        <span class="mb-0 h6 fw-light">Total Watch Time</span>
                    </div>
                    <!-- Icon -->
                    <div class="icon-lg rounded-circle bg-success text-white mb-0"><i class="bi bi-stopwatch-fill fa-fw"></i></div>
                </div>
            </div>
        </div>
    </div>
    <!-- Counter boxes END -->

    <!-- Chart and Ticket START -->
    <div class="row g-4 mb-4">

        <!-- Chart START -->
        <div class="col-xxl-8">
            <div class="card shadow h-100">

                <!-- Card header -->
                <div class="card-header p-4 border-bottom">
                    <h5 class="card-header-title">Earnings</h5>
                </div>

                <!-- Card body -->
                <div class="card-body">
                    <!-- Apex chart -->
                    <div id="ChartPayout"></div>
                </div>
            </div>
        </div>
        <!-- Chart END -->

        <!-- Ticket START -->
        <div class="col-xxl-4">
            <div class="card shadow h-100">
                <!-- Card header -->
                <div class="card-header border-bottom d-flex justify-content-between align-items-center p-4">
                    <h5 class="card-header-title">Plans Requests</h5>
                    <a href="#" class="btn btn-link p-0 mb-0">View all</a>
                </div>

                <!-- Card body START -->
                <div class="card-body p-4">

                    <!-- Ticket item START -->
                    <div class="d-flex justify-content-between position-relative">
                        <div class="d-sm-flex">
                            <!-- Avatar -->
                            <div class="avatar avatar-md flex-shrink-0">
                                <img class="avatar-img rounded-circle" src="assets/images/avatar/09.jpg" alt="avatar">
                            </div>
                            <!-- Info -->
                            <div class="ms-0 ms-sm-2 mt-2 mt-sm-0">
                                <h6 class="mb-0"><a href="#" class="stretched-link">Lori Stevens</a></h6>
                                <p class="mb-0">moises-alberto@hotmail.com</p>
                                <span class="small">8 hour ago</span>
                            </div>
                        </div>
                    </div>
                    <!-- Ticket item END -->

                    <hr><!-- Divider -->

                    <!-- Ticket item START -->
                    <div class="d-flex justify-content-between position-relative">
                        <div class="d-sm-flex">
                            <!-- Avatar -->
                            <div class="avatar avatar-md flex-shrink-0">
                                <div class="avatar-img rounded-circle bg-purple bg-opacity-10">
                                    <span class="text-purple position-absolute top-50 start-50 translate-middle fw-bold">DB</span>
                                </div>
                            </div>
                            <!-- Info -->
                            <div class="ms-0 ms-sm-2 mt-2 mt-sm-0">
                                <h6 class="mb-0"><a href="#" class="stretched-link">Dennis Barrett</a></h6>
                                <p class="mb-0">moises.alberto.bumba@gmail.com</p>
                                <span class="small">8 hour ago</span>
                            </div>
                        </div>
                    </div>
                    <!-- Ticket item END -->

                </div>
                <!-- Card body END -->
            </div>
        </div>
        <!-- Ticket END -->
    </div>
    <!-- Chart and Ticket END -->
</div>
<!-- Page main content END -->
@endsection
