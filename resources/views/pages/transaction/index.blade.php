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
                        <div class="col-sm-12 col-lg-6">
                            <h4 class="card-title">Транзакции</h4>
                        </div>
                        @can('transactions.delete_all')
                            <div class="col-sm-12 col-lg-6">
                                <div class="text-sm-end">
                                    <form action="{{route('transactions.delete_all') }}" method="post">
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-sm btn-rounded waves-effect waves-light mb-2 me-1">
                                            <i class="fa fa-trash font-size-12 align-middle me-2"></i>Удалить все
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endcan
                        <div class="col-sm-12 col-lg-12">
                            <table class="table table-centered mb-0">
                                <thead>
                                <tr>
                                    <th>Дата</th>
                                    <th>Продукт</th>
                                    <th>Количество</th>
                                    <th>Цена</th>
                                    <th>Сумма</th>
                                    <th>Мерчант</th>
                                    <th>Тип</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($transactions as $transaction)
                                    <tr>
                                        <td>{{ $transaction->created_at }}</td>
                                        <td>{{ $transaction->product->name ?? '-' }}</td>
                                        <td>{{ $transaction->count }}</td>
                                        <td>{{ number_format($transaction->price) }}</td>
                                        <td>{{ number_format($transaction->sum) }}</td>
                                        <td>{{ $transaction->merchant->name ?? '-' }}</td>
                                        <td>
                                            @if($transaction->type == 'in')
                                                <span class="badge badge-soft-success font-size-12">Приход</span>
                                            @else
                                                <span class="badge badge-soft-danger font-size-12">Расход</span>
                                            @endif
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


