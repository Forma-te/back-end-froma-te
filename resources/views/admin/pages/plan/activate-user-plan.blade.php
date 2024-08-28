@extends('admin.templates.template-admin')

@section('contect')
<!-- Main content START -->
<div class="page-content-wrapper border">

    <div class="card card-body bg-transparent pb-0 border mb-4">
        <form action="{{ route('plans.activate', $data->id) }}" method="POST" class="comments-form">
            @csrf
        <!-- Update plan START -->
        <div class="row g-2">
            <!-- Update plan item -->
            <div class="col-6 col-lg-2">
                <span>Transação Nº</span>
                <h5>{{ $data->transaction }}</h5>
            </div>

             <!-- Update plan item -->
             <div class="col-6 col-lg-2">
                <span>plano</span>
                <h5>{{ $data->plan->name }}</h5>
            </div>
             <!-- Update plan item -->
             <div class="col-6 col-lg-2">
                <span>Mensalidade</span>
                <h5>{{ $data->quantity }}</h5>
            </div>
            <!-- Update plan item -->
            <div class="col-6 col-lg-2">
                <span>Preço total</span>
                <h5>{{ number_format($data->total, 2, ',', '.') }} Kz</h5>
            </div>

            <!-- Update plan item -->
            <div class="col-6 col-lg-2">
                <span>Data</span>
                <h5>{!! date('d/m/Y', strtotime($data->date)) !!}</h5>
            </div>

             <!-- Update plan item -->
             <div class="col-lg-4">
                <span>Data de renovação</span>
                <input name="date_the_end" class="form-control" type="date">
            </div>
        </div>
        <!-- Update plan END -->


        <!-- Button -->
        <div class="d-sm-flex justify-content-sm-between align-items-center">
            <div>
                <!-- Switch Content -->

                <p class="mb-0">{{ $data->email }}</p>
            </div>
            <!-- Buttons -->
            <div class="mt-2 mt-sm-0">
                <button type="submit" class="btn btn-sm btn-success mb-0">Confirmar pagamento</button>
            </div>
        </div>

    </form>
        <!-- Divider -->
        <hr>
        <!-- Plan Benefits -->
        @if (isset($errors) && count($errors) > 0)
            <div class="alert alert-warning">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif
        @if (Session::has('success'))
            <div class="alert alert-success hide-msg" style="float: left; width:100%; margin: 10px 0px">
                {{ Session::get('success') }}
            </div>
        @endif

    </div>
</div>
<!-- Main content END -->

@endsection
