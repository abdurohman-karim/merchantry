@extends('layouts.master')
@section('title')
    Продукты
@endsection

@section('content')
    <div class="row mb-3">
        <div class="col-lg-12 col-sm-12">
            <div class="d-flex align-items-center justify-content-between">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Продукты</h4>
                </div>
                @can('products.delete_all')
                    <form action="{{ route('products.delete_all') }}" method="post">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-sm btn-rounded waves-effect waves-light mb-2 me-2">
                            <i class="fa fa-trash align-middle font-size-12"></i>
                            Удалить все
                        </button>
                    </form>
                @endcan
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-sm-12 col-lg-6">
                            <h4 class="card-title">Продукты</h4>
                        </div>
                        @can('products.create')
                            <div class="col-sm-12 col-lg-6">
                                <div class="text-sm-end">
                                    <a href="{{ route('products.create') }}" type="button"
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
                                    <th>Цена</th>
                                    <th>Наценка %</th>
                                    <th>Цена продажи</th>
                                    <th>Количество</th>
                                    <th>Действия</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($products as $product)
                                    <tr>
                                        <td>{{ $product->id }}</td>
                                        <td>
                                            @can('products.edit')
                                                <a href="{{ route('products.edit', $product->id) }}">{{ $product->name }}</a>
                                            @else
                                                {{ $product->name }}
                                            @endcan
                                        </td>
                                        <td>{{ number_format($product->price) }}</td>
                                        <td>{{ $product->surcharge }}</td>
                                        <td>{{ number_format($product->sale_price) }}</td>
                                        <td>{{ $product->count }}</td>
                                        <td>
                                            @can('products.delete')
                                                <form action="{{ route('products.delete', $product->id) }}" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </form>
                                            @endcan
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
