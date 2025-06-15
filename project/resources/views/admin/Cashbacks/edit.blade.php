@extends('layouts.load')

@section('content')
    <div class="content-area">
        <div class="add-product-content1">
            <div class="row">
                <div class="col-lg-12">
                    <div class="product-description">
                        <div class="body-area">
                            @include('alerts.admin.form-error')
                            <form id="geniusformdata" action="{{ route('admin-cashback-update', $cashback->id) }}" method="POST" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                @method('PUT')

                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="left-area">
                                            <h4 class="heading">{{ __('Minimum Purchase Value') }} *</h4>
                                            <p class="sub-heading">{{ __('(In Any Language)') }}</p>
                                        </div>
                                    </div>
                                    <div class="col-lg-7">
                                        <input type="text" class="input-field" name="min_purchase_value" placeholder="Min Purchase (e.g. 10000)" pattern="\d+" required value="{{ $cashback->min_purchase_value }}">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="left-area">
                                            <h4 class="heading">{{ __('Maximum Purchase Value') }} *</h4>
                                            <p class="sub-heading">{{ __('In English') }}</p>
                                        </div>
                                    </div>
                                    <div class="col-lg-7">
                                        <input type="text" class="input-field" name="max_purchase_value" placeholder="Max Purchase (e.g. 20000)" pattern="\d+" required value="{{ $cashback->max_purchase_value }}">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="left-area">
                                            <h4 class="heading">{{ __('Advance Percentage') }} *</h4>
                                            <p class="sub-heading">{{ __('(In Any Language)') }}</p>
                                        </div>
                                    </div>
                                    <div class="col-lg-7">
                                        <input type="text" class="input-field" name="advance_percentage" placeholder="Advance % (e.g. 5.50)" pattern="\d+(\.\d{1,2})?" required value="{{ $cashback->advance_percentage }}">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="left-area">
                                            <h4 class="heading">{{ __('7 Days Percentage') }} *</h4>
                                            <p class="sub-heading">{{ __('(In Any Language)') }}</p>
                                        </div>
                                    </div>
                                    <div class="col-lg-7">
                                        <input type="text" class="input-field" name="days_7_percentage" placeholder="7 Days % (e.g. 3.75)" pattern="\d+(\.\d{1,2})?" required value="{{ $cashback->days_7_percentage }}">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="left-area">
                                            <h4 class="heading">{{ __('7-30 Days Percentage') }} *</h4>
                                            <p class="sub-heading">{{ __('(In Any Language)') }}</p>
                                        </div>
                                    </div>
                                    <div class="col-lg-7">
                                        <input type="text" class="input-field" name="days_7_30_percentage" placeholder="7-30 Days % (e.g. 2.25)" pattern="\d+(\.\d{1,2})?" required value="{{ $cashback->days_7_30_percentage }}">
                                    </div>
                                </div>

                                <br>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="left-area"></div>
                                    </div>
                                    <div class="col-lg-7">
                                        <button class="addProductSubmit-btn" type="submit">{{ __('Save') }}</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        (function($) {
            "use strict";

            // Ensure input fields allow typing numbers and decimals
            $('input[name="min_purchase_value"], input[name="max_purchase_value"]').on('input', function() {
                this.value = this.value.replace(/[^0-9]/g, ''); // Allow only integers
            });

            $('input[name="advance_percentage"], input[name="days_7_percentage"], input[name="days_7_30_percentage"]').on('input', function() {
                this.value = this.value.replace(/[^0-9.]/g, ''); // Allow numbers and decimal point
                // Ensure only one decimal point and max 2 decimal places
                let parts = this.value.split('.');
                if (parts.length > 2) {
                    this.value = parts[0] + '.' + parts[1].slice(0, 2);
                } else if (parts[1] && parts[1].length > 2) {
                    this.value = parts[0] + '.' + parts[1].slice(0, 2);
                }
            });
        })(jQuery);
    </script>
@endsection