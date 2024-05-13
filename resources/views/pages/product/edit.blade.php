@extends('layouts.master')
@section('title')
    Редактирование продукта
@endsection

@section('content')
    <div class="row mb-3">
        <div class="col-lg-8 col-sm-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Редактирование продукта</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 col-lg-8 offset-lg-2 offset-md-2 col-sm-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">{{ $product->name }}</h4>
                    <form action="{{route('products.update', $product->id)}}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="row mb-4">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Название</label>
                                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $product->name) }}">
                                            @error('name')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Цена</label>
                                            <input type="text" name="price" class="form-control numberFormat @error('price') is-invalid @enderror" value="{{ old('price', $product->price) }}">
                                            @error('price')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Кол-во</label>
                                            <input type="text" name="pack_cnt" class="form-control numberFormat @error('pack_cnt') is-invalid @enderror" value="{{ old('pack_cnt', $product->pack_cnt) }}">
                                            @error('pack_cnt')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="text-lg-end text-sm-center">
                                        <div>
                                            <button type="submit" class="btn btn-primary w-md"><i class="fas fa-save"></i> Сохранить</button>
                                            <a href="{{ route('products.index') }}" class="btn btn-secondary w-md">Отмена</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection
