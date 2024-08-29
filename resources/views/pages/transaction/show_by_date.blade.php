@extends('layouts.master')

@section('title')
    Транзакции за {{ $date }}
@endsection

@section('content')
    <div class="row mb-3">
        <div class="col-lg-8 col-sm-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Транзакции за {{ $date }}</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-sm-12 col-lg-6">
                            <h4 class="card-title">Итоги за день</h4>
                            <ul class="list-unstyled">
                                <li><strong>Общая сумма прихода:</strong> {{ number_format($totalIncomePrice) }}</li>
                                <li><strong>Общая сумма расхода:</strong> {{ number_format($totalOutcomePrice) }}</li>
                                <li><strong>Общее количество приходных штук:</strong> {{ $totalIncomeCount }}</li>
                                <li><strong>Общее количество расходных штук:</strong> {{ $totalOutcomeCount }}</li>
                            </ul>
                        </div>
                    </div>
                    <div class="row mb-3">
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
                                    <th>Действие</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($transactions as $transaction)
                                    <tr class="@if ($transaction->status == 'cancel') bg-soft bg-danger @endif">
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
                                        <td>
                                            @if($transaction->status == 'active')
                                                @can('transactions.cancel')
                                                    <form action="{{ route('transactions.cancel', $transaction->id) }}" method="post">
                                                        @csrf
                                                        <button type="submit" class="btn btn-danger btn-sm">Отменить</button>
                                                    </form>
                                                @endcan
                                            @else
                                                <button class="btn btn-danger btn-sm disabled"> Отменен</button>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <a href="{{ route('transactions.index') }}" class="btn btn-secondary">Назад к списку дат</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const cancelButtons = document.querySelectorAll('form[action*="transactions/cancel"] button[type="submit"]');
            cancelButtons.forEach(function(button) {
                button.addEventListener('click', function(event) {
                    event.preventDefault(); // Prevent form submission
                    const confirmation = confirm('Вы уверены, что хотите отменить эту транзакцию?');
                    if (confirmation) {
                        this.closest('form').submit(); // Submit the form if confirmed
                    }
                });
            });
        });
    </script>
@endsection
