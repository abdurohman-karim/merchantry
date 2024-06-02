@extends('layouts.master')
@section('title')
    Добавить продукта
@endsection

@section('content')
    <div class="row mb-3">
        <div class="col-lg-8 col-sm-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Добавить продукта</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 col-lg-4 offset-lg-4 offset-md-4 col-sm-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Новый продукт</h4>
                    <form action="{{ route('products.store') }}" method="post">
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
                                            <label class="form-label">Цена</label>
                                            <input type="text" id="price" name="price" class="form-control numberFormat @error('price') is-invalid @enderror" value="{{ old('price') }}">
                                            @error('price')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label">Процент надбавки %</label>
                                            <input type="text" id="surcharge" name="surcharge" class="form-control numberFormat @error('surcharge') is-invalid @enderror" value="{{ old('surcharge', 0) }}" maxlength="3">
                                            @error('surcharge')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label">Цена продажи</label>
                                            <input type="text" id="sale_price" name="sale_price" class="form-control numberFormat @error('sale_price') is-invalid @enderror" value="{{ old('sale_price') }}">
                                            @error('sale_price')
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

    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            const priceInput = document.getElementById('price');
            const surchargeInput = document.getElementById('surcharge');
            const salePriceInput = document.getElementById('sale_price');

            function calculateSalePrice() {
                const price = parseFloat(priceInput.value.replace(/,/g, '')) || 0;
                const surcharge = parseFloat(surchargeInput.value) || 0;
                let salePrice = price * (1 + surcharge / 100);

                // Check if the decimal part is less than 0.01 (1 cent)
                if (salePrice % 1 < 0.01) {
                    salePrice = Math.round(salePrice); // Round to the nearest whole number
                } else {
                    salePrice = salePrice.toFixed(2); // Display with 2 decimal places
                }
                salePriceInput.value = salePrice;
            }

            function calculateSurcharge() {
                const price = parseFloat(priceInput.value.replace(/,/g, '')) || 0;
                const salePrice = parseFloat(salePriceInput.value.replace(/,/g, '')) || 0;
                const surcharge = ((salePrice / price) - 1) * 100;

                surchargeInput.value = Math.round(surcharge); // Round to the nearest whole number
            }

            priceInput.addEventListener('input', calculateSalePrice);
            surchargeInput.addEventListener('input', calculateSalePrice);
            salePriceInput.addEventListener('input', calculateSurcharge);

            // Initial calculation
            calculateSalePrice();
        });

    </script>
@endsection
