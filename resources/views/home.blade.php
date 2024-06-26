@extends('layouts.master')

@section('title')
    Основная
@endsection

@section('content')
    <!-- start page title -->
    <div class="row mb-3">
        <div class="col-lg-8 col-sm-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Основная</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->
    <div class="row">
        <div class="col-lg-12 col-sm-12">
            <div class="row">
                <div class="col-lg-6 col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <p class="text-muted mb-4">Bu oy kirim & chiqimlar:</p>
                            <div class="text-center">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div>
                                            <div class="font-size-24 text-primary mb-2">
                                                <i class="bx bx-import"></i>
                                            </div>

                                            <p class="text-muted mb-2">Kirim</p>
                                            <h5>{{ number_format($outcomeSum) ?? 0 }} sum</h5>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="mt-4 mt-sm-0">
                                            <div class="font-size-24 text-primary mb-2">
                                                <i class="bx bx-export"></i>
                                            </div>

                                            <p class="text-muted mb-2">Chiqim</p>
                                            <h5>{{ number_format($incomeSum) ?? 0 }} sum</h5>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="mt-4 mt-sm-0">
                                            <div class="font-size-24 text-primary mb-2">
                                                <i class="bx bx-dollar"></i>
                                            </div>

                                            <p class="text-muted mb-2">Daromad</p>
                                            <h5 class="{{ $incomeSum - $outcomeSum > 0 ? 'text-danger' : 'text-success' }}">{{ number_format($outcomeSum - $incomeSum) ?? 0 }} sum</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('script')

@endsection
