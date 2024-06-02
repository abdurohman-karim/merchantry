@extends('layouts.master')

@section('title')
    Транзакции
@endsection

@section('content')
    <div class="row mb-3">
        <div class="col-lg-8 col-sm-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Транзакции</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-sm-12 col-lg-12">
                            <table class="table table-centered mb-0">
                                <thead>
                                <tr>
                                    <th>Дата</th>
                                    <th>Количество транзакций</th>
                                    <th>Действие</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($transactions as $transaction)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($transaction->date)->format('d/m/Y') }}</td>
                                        <td>{{ $transaction->total }}</td>
                                        <td>
                                            <a href="{{ route('transactions.show_by_date', $transaction->date) }}" class="btn btn-primary btn-sm">Посмотреть транзакции</a>
                                        </td>
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
