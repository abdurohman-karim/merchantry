@extends('layouts.master')
@section('title')
    Создать транзакцию
@endsection

@section('css')
    <link href="{{ URL::asset('/assets/libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
    <div class="row mb-3">
        <div class="col-lg-8 col-sm-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">Создать транзакцию</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 col-lg-8 offset-lg-2 offset-md-2 col-sm-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Новая транзакция</h4>
                    <form action="{{ route('transactions.store') }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="row mb-4">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Продукт</label>
                                            <select class="select2 form-control" id="productSelect"
                                                    data-placeholder="Выберите продукт" name="product_id">
                                                <option></option>
                                                @foreach($products as $product)
                                                    <option value="{{ $product->id }}"
                                                            data-price="{{ $product->price }}"
                                                            data-count="{{ $product->count }}">{{ $product->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('pack')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Штук</label>
                                            <input type="text" name="count" class="form-control numberFormat @error('count') is-invalid @enderror" value="{{ old('count') }}">
                                            @error('count')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Тип</label>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="type" id="flexRadioDefault1" value="in" checked>
                                                <label class="form-check-label" for="flexRadioDefault1">
                                                    Приход
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="type" id="flexRadioDefault2" value="out">
                                                <label class="form-check-label" for="flexRadioDefault2">
                                                    Расход
                                                </label>
                                            </div>
                                            @error('type')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Цена</label>
                                            <input type="text" name="price" class="form-control numberFormat @error('price') is-invalid @enderror" value="{{ old('price') }}" >
                                            @error('price')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                            <p class="text-muted mt-2">
                                                Приходная цена : <span id="formattedProductPrice">0</span> SUM
                                            </p>
                                            <p class="text-muted">
                                                Штук на складе: <span id="productCount">0</span>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Выберите торговца</label>
                                            <select id="merchantSelectContainer" disabled class="select2 form-control @error('merchant_id') is-invalid @enderror" name="merchant_id"
                                                    data-placeholder="Выберите торговца">
                                                <option></option>
                                                <!-- Populate options dynamically here -->
                                                @foreach($merchants as $merchant)
                                                    <option value="{{ $merchant->id }}">{{ $merchant->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('merchant_id')
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
                                            <a href="{{ route('transactions.index') }}" class="btn btn-secondary w-md">Отмена</a>
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
    <script src="{{ URL::asset('/assets/libs/select2/select2.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2(); // Initialize select2

            // Event listener for product selection change
            $('#productSelect').on('change', function() {
                var selectedOption = $(this).find('option:selected');
                var selectedPrice = selectedOption.data('price');
                var selectedCount = selectedOption.data('count');

                // Update the formatted price display
                $('#formattedProductPrice').text(numberWithCommas(selectedPrice));

                // Update the product count display
                $('#productCount').text(selectedCount);
            });

            // Event listener for radio button change
            $('input[name="type"]').on('change', function() {
                if ($(this).val() === 'out') {
                    $('#merchantSelectContainer').attr('disabled', false); // Show merchant selection input
                } else {
                    $('#merchantSelectContainer').attr('disabled', true); // Hide merchant selection input
                }
            });

            // Helper function to format number with commas
            function numberWithCommas(x) {
                return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            }
        });
    </script>
@endsection
