@extends('layouts.master')
@section('title')
    Приход
@endsection

@section('css')
    <link href="{{ URL::asset('/assets/libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    <div class="row mb-3">
        <div class="col-lg-8 col-sm-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Создать приход</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 col-lg-8 offset-lg-2 offset-md-2 col-sm-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Новый приход</h4>
                    <form action="{{ route('transactions.income') }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Продукт</label>
                                            <select class="select2 form-control productSelect"
                                                    data-placeholder="Выберите продукт" name="product_id[]">
                                                <option></option>
                                                @foreach($products as $product)
                                                    <option value="{{ $product->id }}"
                                                            data-price="{{ $product->price }}"
                                                            data-sale-price="{{ $product->sale_price }}"
                                                            data-count="{{ $product->count }}">{{ $product->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('product_id')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="mb-3">
                                            <label class="form-label">Штук</label>
                                            <input type="text" name="count[]" class="form-control numberFormat @error('count') is-invalid @enderror" value="{{ old('count') }}">
                                            @error('count')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label">Цена</label>
                                            <input type="text" name="price[]" class="form-control numberFormat @error('price') is-invalid @enderror" value="{{ old('price') }}" >
                                            @error('price')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="button">Добавить продукт</label>
                                            <button type="button" class="btn btn-success waves-effect waves-light addProduct">
                                                <i class="fas fa-plus"></i> Добавить
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-md-12 product-info">
                                        <p class="badge badge-soft-secondary text-secondary font-size-11">
                                            Приходная цена : <span class="formattedIncomePrice">0</span> SUM
                                        </p>
                                        <p class="badge badge-soft-secondary text-secondary font-size-11">
                                            Штук на складе: <span class="formattedCount">0</span>
                                        </p>
                                    </div>
                                </div>
                                <div class="row mb-3 productList">
                                    {{-- new product must be here--}}
                                </div>
                                <div class="row">
                                    <div class="text-lg-end text-sm-center">
                                        <div>
                                            <button type="submit" class="btn btn-success w-md"><i class="fas fa-plus"></i> Создать</button>
                                            <a href="{{ route('transactions.index') }}" class="btn btn-secondary w-md">Отмена</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection


@section('script')
    <script src="{{ URL::asset('/assets/js/pages/form-advanced.init.js') }}"></script>
    <script>
        $(document).ready(function() {
            function initializeSelect2() {
                $('.select2').select2(); // Initialize select2
            }

            function updateProductInfo(selectElement) {
                var selectedOption = selectElement.find('option:selected');
                var selectedPrice = selectedOption.data('price') || 0;
                var selectedCount = selectedOption.data('count') || 0;

                selectElement.closest('.row').find('.formattedIncomePrice').text(numberWithCommas(selectedPrice));
                selectElement.closest('.row').find('.formattedCount').text(selectedCount);

                // Update the count and price input fields for the selected product row
                selectElement.closest('.row').find('.priceInput').val(selectedPrice);
            }

            // Event listener for initial product selection change
            $(document).on('change', '.productSelect', function() {
                updateProductInfo($(this));
            });

            // Add product
            $('.addProduct').on('click', function() {
                var newProductHtml = `
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Продукт</label>
                                <select class="select2 form-control productSelect" data-placeholder="Выберите продукт" name="product_id[]">
                                    <option></option>
                                    @foreach($products as $product)
                <option value="{{ $product['id'] }}"
                                        data-price="{{ $product['price'] }}"
                                        data-count="{{ $product['count'] }}">{{ $product['name'] }}</option>
                                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-2">
            <div class="mb-3">
                <label class="form-label">Штук</label>
                <input type="text" name="count[]" class="form-control numberFormat countInput">
            </div>
        </div>
        <div class="col-md-3">
            <div class="mb-3">
                <label class="form-label">Цена</label>
                <input type="text" name="price[]" class="form-control numberFormat priceInput">
            </div>
        </div>
        <div class="col-md-3">
            <div class="mb-3">
                <label>&nbsp;</label>
                <button type="button" class="btn btn-danger waves-effect waves-light removeProduct">
                    <i class="fas fa-minus"></i> Удалить
                </button>
            </div>
        </div>
        <div class="col-md-12 product-info">
            <p class="badge badge-soft-secondary text-secondary font-size-11">
                Приходная цена : <span class="formattedIncomePrice">0</span> SUM
            </p>
            <p class="badge badge-soft-secondary text-secondary font-size-11">
                Штук на складе: <span class="formattedCount">0</span>
            </p>
        </div>
    </div>
`;

                $('.productList').append(newProductHtml);
                initializeSelect2();
            });

            // Event listener for remove button
            $(document).on('click', '.removeProduct', function() {
                $(this).closest('.row').remove();
            });

            // Helper function to format number with commas
            function numberWithCommas(x) {
                return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            }

            // Initialize select2 for the initial product select element
            initializeSelect2();
        });
    </script>
@endsection


