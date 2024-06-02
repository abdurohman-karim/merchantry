@extends('layouts.master')
@section('title')
    Магазин - {{ $merchant->name }}
@endsection

@section('content')
    <div class="row mb-3">
        <div class="col-lg-8 col-sm-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Магазин</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 col-lg-8 offset-lg-2 offset-md-2 col-sm-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">
                        Название : {{ $merchant->name }}
                        <span class="float-end">
                            Номер: {{ $merchant->phone }}
                        </span>
                    </h4>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <p class="text-muted">
                                    Общий расход на суммах: <br>
                                    <span class="badge bg-soft badge-soft-success fs-6 mt-1">{{ number_format($merchant->transactions->sum('sum')) }} сум</span>
                                </p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <p class="text-muted">
                                    Общий расход на штуках: <br>
                                    <span class="badge bg-soft badge-soft-success fs-6 mt-1">{{ number_format($merchant->transactions->sum('count')) }} шт</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <h4 class="card-title mb-4">Транзакции: {{ $merchant->transactions->count() }}</h4>
                    @foreach($groupedTransactions as $date => $transactions)
                        <table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th></th>
                                <th>Название продукта</th>
                                <th>Цена</th>
                                <th>Штук</th>
                                <th>Сумма</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td rowspan="{{ $transactions->count() + 1 }}">{{ \Carbon\Carbon::parse($date)->format('d/m/Y') }}</td>
                            </tr>
                            @foreach($transactions as $transaction)
                                <tr>
                                    <td>
                                        <a href="{{ route('products.edit', $transaction->product_id) }}">
                                            {{ $transaction->product->name }}
                                        </a>
                                    </td>
                                    <td>{{ number_format($transaction->price, 2) }}</td>
                                    <td>{{ $transaction->count }}</td>
                                    <td>{{ number_format($transaction->sum) }}</td>
                                </tr>
                            @endforeach
                            <tr>
                                <td colspan="4" class="text-end"><strong>Общая сумма расхода</strong></td>
                                <td>{{ number_format($transactions->sum('sum')) }}</td>
                            </tr>
                            </tbody>
                        </table>
                    @endforeach
                </div>
                <div class="card-footer">
                    <a href="{{ route('merchants.index') }}" class="btn btn-secondary">Назад</a>
                </div>
            </div>
        </div>
    </div>
@endsection
