@extends('layouts.master')
@section('title')
    Отход
@endsection

@section('css')
    <link href="{{ URL::asset('/assets/libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    <div class="row mb-3">
        <div class="col-lg-8 col-sm-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Создать отход</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 col-lg-4 offset-lg-4 offset-md-4 col-sm-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Новый отход</h4>
                    <form action="{{ route('waste.store') }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label for="button">Выбрать продукт</label>
                                            <select class="select2 form-control" data-placeholder="Выберите продукт" name="product_id">
                                                <option></option>
                                                @foreach($products as $product)
                                                    <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>{{ $product->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('merchant_id')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-5">
                                            <label for="button">Количество</label>
                                            <input type="text" name="count" class="form-control numberFormat @error('count') is-invalid @enderror" value="{{ old('count') }}">
                                            @error('count')
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
                                            <button type="submit" class="btn btn-success w-md"><i class="fas fa-plus"></i> Отход</button>
                                            <a href="{{ route('waste.index') }}" class="btn btn-secondary w-md">Отмена</a>
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

@section('script')
    <script src="{{ URL::asset('/assets/js/pages/form-advanced.init.js') }}"></script>
@endsection

