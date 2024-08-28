@extends('admin.templates.template-admin')

@section('contect')
<!-- Page main content START -->
<div class="page-content-wrapper border">
    <!-- Title -->
    <div class="row mb-3">
        <div class="col-12">
            <h1 class="h3 mb-2 mb-sm-0">Solicitações Produtores</h1>
        </div>
    </div>
    <!-- Main card START -->
    <div class="card bg-transparent border">
        <!-- Card header START -->
        <div class="card-header bg-light border-bottom">
            <!-- Search and select START -->
            <div class="row g-3 align-items-center justify-content-between">
                <!-- Search bar -->
                <div class="col-md-8">
                    <form class="rounded position-relative">
                        <input class="form-control bg-body" type="search" placeholder="Search" aria-label="Search">
                        <button class="btn bg-transparent px-2 py-0 position-absolute top-50 end-0 translate-middle-y"
                            type="submit"><i class="fas fa-search fs-6"></i></button>
                    </form>
                </div>
                <!-- Select option -->
                <div class="col-md-3">
                    <!-- Short by filter -->
                    <form>
                        <select class="form-select js-choice border-0 z-index-9 bg-transparent"
                            aria-label=".form-select-sm">
                            <option value="">Sort by</option>
                            <option>Newest</option>
                            <option>Oldest</option>
                            <option>Accepted</option>
                            <option>Rejected</option>
                        </select>
                    </form>
                </div>
            </div>
            <!-- Search and select END -->
        </div>
        <!-- Card header END -->

        <!-- Card body START -->
        <div class="card-body">
            <!-- Instructor request table START -->
            <div class="table-responsive border-0">
                <table class="table table-dark-gray align-middle p-4 mb-0 table-hover">
                    <!-- Table head -->
                    <thead>
                        <tr>
                            <th scope="col" class="border-0 rounded-start">E-mail produtor</th>
                            <th scope="col" class="border-0">Transação Nº</th>
                            <th scope="col" class="border-0">Mensalidade</th>
                            <th scope="col" class="border-0 rounded-end">Data</th>
                        </tr>
                    </thead>
                    <!-- Table body START -->
                    <tbody>
                        <!-- Table row -->
                        @forelse($requests->items() as $key => $request)
                            <tr>
                                <!-- Table data -->
                                <td>
                                    <div class="d-flex align-items-center position-relative">
                                        <!-- Image -->
                                        <div class="avatar avatar-md">
                                            <img src="assets/images/avatar/09.jpg" class="rounded-circle"
                                                alt="">
                                        </div>
                                        <div class="mb-0 ms-2">
                                            <!-- Title -->
                                            <h6 class="mb-0"><a
                                                    href="{{ route('user.request', $request->id)}}"
                                                    class="stretched-link">{{ $request->email }}</a></h6>
                                        </div>
                                    </div>
                                </td>

                                <!-- Table data -->
                                <td class="text-center text-sm-start">
                                    <h6 class="mb-0">{{ $request->transaction }}</h6>
                                </td>

                                <!-- Table data -->
                                <td>{{ $request->quantity }}</td>

                                <!-- Table data -->
                                <td>{{ $request->date }}</td>

                            </tr>
                        @empty
                        @endforelse
                    </tbody>
                    <!-- Table body END -->
                </table>
            </div>
            <!-- Instructor request table END -->
        </div>
        <!-- Card body END -->

        <!-- Card footer START -->
        <div class="card-footer bg-transparent pt-0">
            <!-- Pagination START -->
            <div class="d-sm-flex justify-content-sm-between align-items-sm-center">
                <!-- Content -->
                <p class="mb-0 text-center text-sm-start">Showing 1 to 8 of 20 entries</p>
                <!-- Pagination -->
                <nav class="d-flex justify-content-center mb-0" aria-label="navigation">
                    <ul class="pagination pagination-sm pagination-primary-soft d-inline-block d-md-flex rounded mb-0">
                        <li class="page-item mb-0"><a class="page-link" href="#" tabindex="-1"><i
                                    class="fas fa-angle-left"></i></a></li>
                        <li class="page-item mb-0"><a class="page-link" href="#">1</a></li>
                        <li class="page-item mb-0 active"><a class="page-link" href="#">2</a></li>
                        <li class="page-item mb-0"><a class="page-link" href="#">3</a></li>
                        <li class="page-item mb-0"><a class="page-link" href="#"><i
                                    class="fas fa-angle-right"></i></a></li>
                    </ul>
                </nav>
            </div>
            <!-- Pagination END -->
        </div>
        <!-- Card footer END -->
    </div>
    <!-- Main card END -->

</div>
<!-- Page main content END -->

@endsection
