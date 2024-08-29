@extends('layouts.master')
@section('title')
    Отходы
@endsection

@section('content')
    <div class="row mb-3">
        <div class="col-lg-12 col-sm-12">
            <div class="d-flex align-items-center justify-content-between">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Отходы</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('waste.index') }}" method="get">
                        <div class="d-flex justify-content-between">
                            <div class="row">
                                <div class="col-md-12">
                                    <div>
                                        <input type="text" name="name" class="form-control" value="{{ old('name', request()->name) }}" placeholder="Название">
                                    </div>
                                </div>
                            </div>
                            <div class="btn-group">
                                <button type="submit" class="btn btn-primary btn-rounded">Поиск</button>
                                <a href="{{ route('waste.index') }}" class="btn btn-secondary btn-rounded">
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
                        <div class="col-sm-12 col-lg-6">
                            <h4 class="card-title">Отходы</h4>
                        </div>
                        @can('waste.create')
                            <div class="col-sm-12 col-lg-6">
                                <div class="text-sm-end">
                                    <a href="{{ route('waste.create') }}" type="button"
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
                                    <th>Потерянная стоимость</th>
                                    <th>Количество</th>
                                    <th>Действия</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($wastes as $waste)
                                    <tr>
                                        <td>{{ $waste->id }}</td>
                                        <td>{{ $waste->name }}</td>
                                        <td>{{ number_format($waste->price) }}</td>
                                        <td>{{ number_format($waste->lost_amount) }}</td>
                                        <td>{{ $waste->count }}</td>
                                        <td>
                                            @can('waste.delete')
                                                <form action="{{ route('waste.delete', $waste->id) }}" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">Удалить</button>
                                                </form>
                                            @endcan
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="col-sm-12 col-lg-12">
                            {{ $wastes->withQueryString()->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
