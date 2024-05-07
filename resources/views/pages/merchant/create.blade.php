@extends('layouts.master')
@section('title')
    Добавить торговца
@endsection

@section('content')
    <div class="row mb-3">
        <div class="col-lg-8 col-sm-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Добавить торговца</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3 col-lg-3 offset-lg-4 offset-md-4 col-sm-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Новый торговец</h4>
                    <form action="{{route('merchants.store')}}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="row mb-4">
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label">Название</label>
                                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">
                                            @error('name')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label">Номер</label>
                                            <input type="text" name="phone" class="form-control numberFormat @error('phone') is-invalid @enderror" value="{{ old('phone') }}">
                                            @error('phone')
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
                                            <button type="submit" class="btn btn-success w-md"><i class="fas fa-plus"></i> Создать</button>
                                            <a href="{{ route('merchants.index') }}" class="btn btn-secondary w-md">Отмена</a>
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
