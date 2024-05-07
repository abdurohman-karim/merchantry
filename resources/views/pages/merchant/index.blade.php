@extends('layouts.master')
@section('title')
    Торговцы
@endsection

@section('content')
    <div class="row mb-3">
        <div class="col-lg-8 col-sm-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Торговцы</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-sm-12 col-lg-6">
                            <h4 class="card-title">Торговцы</h4>
                        </div>
                        <div class="col-sm-12 col-lg-6">
                            <div class="text-sm-end">
                                <a href="{{ route('merchants.create') }}" type="button"
                                   class="btn btn-success btn-rounded waves-effect waves-light mb-2 me-2">
                                    <i class="fa fa-plus align-middle font-size-16"></i>
                                    Создать
                                </a>
                            </div>
                        </div>
                        <div class="col-sm-12 col-lg-12">
                            <table class="table table-centered mb-0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Название</th>
                                        <th>Номер</th>
                                        <th>Действия</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($merchants as $merchant)
                                        <tr>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
