@extends('layouts.master')

@section('title')
    Транзакции
@endsection

@section('content')
    <div class="row mb-3">
        <div class="col-lg-12 col-sm-12">
            <div class="d-flex align-items-center justify-content-between">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Транзакции</h4>
                </div>
                @can('transaction.delete_all')
                    <form action="{{ route('transactions.delete_all') }}" method="post">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-sm btn-rounded waves-effect waves-light mb-2 me-2">
                            <i class="fas fa-trash"></i>
                            Удалить все
                        </button>
                    </form>
                @endcan
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('transactions.index') }}" method="get">
                        <div class="d-flex justify-content-between">
                            <div class="row">
                                <div class="col-md-12">
                                    <div>
                                        <input type="date" name="date" class="form-control" value="{{ old('date', request()->date) }}">
                                    </div>
                                </div>
                            </div>
                            <div class="btn-group">
                                <button type="submit" class="btn btn-primary btn-rounded">Поиск</button>
                                <a href="{{ route('transactions.index') }}" class="btn btn-secondary btn-rounded">
                                    <i class="fas fa-redo"></i>
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
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
                        <div class="col-sm-12 col-lg-12">
                            {{ $transactions->withQueryString()->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
