@extends('layouts.master')
@section('title')
    Магазины
@endsection

@section('content')
    <div class="row mb-3">
        <div class="col-lg-8 col-sm-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Магазины</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-sm-12 col-lg-6">
                            <h4 class="card-title">Магазины</h4>
                        </div>
                        @can('merchants.create')
                            <div class="col-sm-12 col-lg-6">
                                <div class="text-sm-end">
                                    <a href="{{ route('merchants.create') }}" type="button"
                                       class="btn btn-success btn-rounded waves-effect waves-light mb-2 me-2">
                                        <i class="fa fa-plus align-middle font-size-16"></i>
                                        Создать
                                    </a>
                                </div>
                            </div>
                        @endcan
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
                                            <td>{{ $merchant->id }}</td>
                                            <td>
                                                <a href="{{ route('merchants.show', $merchant->id) }}">{{ $merchant->name }}</a>
                                            </td>
                                            <td>{{ $merchant->phone }}</td>
                                            <td>
                                                @canany(['merchants.edit', 'merchants.delete'])
                                                    <div class="btn-group btn-group-sm gap-1">
                                                        @can('merchant.edit')
                                                            <a href="{{ route('merchants.edit', $merchant->id) }}"
                                                               class="btn btn-success btn-sm">
                                                                <i class="fa fa-edit"></i>
                                                            </a>
                                                        @endcan
                                                        @can('merchants.delete')
                                                            <form action="{{ route('merchants.delete', $merchant->id) }}" method="post">
                                                                @csrf
                                                                @method('delete')
                                                                <button type="submit" class="btn btn-danger btn-sm">
                                                                    <i class="fa fa-trash"></i>
                                                                </button>
                                                            </form>
                                                        @endcan
                                                    </div>
                                                @endcanany
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

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteButtons = document.querySelectorAll('form[action*="merchants/delete"] button[type="submit"]');
            deleteButtons.forEach(function(button) {
                button.addEventListener('click', function(event) {
                    event.preventDefault(); // Prevent form submission
                    const confirmation = confirm('Вы уверены, что хотите удалить этот магазин?');
                    if (confirmation) {
                        this.closest('form').submit(); // Submit the form if confirmed
                    }
                });
            });
        });
    </script>
@endsection
