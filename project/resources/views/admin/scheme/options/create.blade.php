@extends('layouts.load')

@section('content')

<div class="content-area">
  <div class="add-product-content">
  <div class="content-area">

    <div class="add-product-content">
    <div class="row">
      <div class="col-lg-12">
      <div class="product-description">
        <div class="body-area">
        @include('includes.admin.form-error')
        <form id="geniusformdata" action="{{route('admin-scheme-option-store', $scheme->id)}}" method="POST">
          {{csrf_field()}}

          <div class="row">
          <div class="col-lg-4">
            <div class="left-area">
            <h4 class="heading">{{ __('Current Scheme') }} *</h4>
            </div>
          </div>
          <div class="col-lg-7">
            <input type="text" readonly class="input-field" value="{{$scheme->name}}">
          </div>
          </div>

              <div class="row">
                <div class="col-lg-4">
                  <div class="left-area">
                    <h4 class="heading">{{ __('Option Name') }} *</h4>
                    <p class="sub-heading">{{ __('(In Any Language)') }}</p>
                  </div>
                </div>
                <div class="col-lg-7">
                  <input type="text" class="input-field" name="name" placeholder="{{ __('Enter Option (Ex : 5+1..etc )') }}" value="">
                </div>
              </div>

              <div class="row">
                <div class="col-lg-4">
                  <div class="left-area">
                    <h4 class="heading">{{ __('Order') }} *</h4>
                    <p class="sub-heading">{{ __('(Enter a number for sorting)') }}</p>
                  </div>
                </div>
                <div class="col-lg-7">
                  <input type="number" class="input-field" name="order" placeholder="{{ __('Enter Order (e.g., 1, 2, 3)') }}" value="" min="0" required>
                </div>
              </div>

              <div class="row">
                <div class="col-lg-4">
                  <div class="left-area">
                    <h4 class="heading">{{ __('Total Quantity') }} *</h4>
                    <p class="sub-heading">{{ __('(In Any Language)') }}</p>
                  </div>
                </div>
                <div class="col-lg-7">
                  <input type="text" class="input-field" name="total_quantity" placeholder="{{ __('Enter Overall Quantity of Products') }}" value="">
                </div>
              </div>

              <div class="row">
                <div class="col-lg-4">
                  <div class="left-area">
                    <h4 class="heading">{{ __('Discount Percentage') }} *</h4>
                    <p class="sub-heading">{{ __('(In Any Language)') }}</p>
                  </div>
                </div>
                <div class="col-lg-7">
                  <input type="number" step="0.00000000000000001" class="input-field" name="discount_percentage" placeholder="{{ __('Enter Discount percentage for this option') }}" value="">
                </div>
              </div>
          <!-- Number of Boxes -->
          <div class="row">
          <div class="col-lg-4">
            <div class="left-area">
            <h4 class="heading">{{ __('Number of Boxes') }}</h4>
            </div>
          </div>
          <div class="col-lg-7">
            <input type="number" class="input-field" name="number_of_boxes"
            placeholder="{{ __('Enter Number of Boxes') }}">
          </div>
          </div>

          <!-- Name of the Box -->
          <div class="row">
          <div class="col-lg-4">
            <div class="left-area">
            <h4 class="heading">{{ __('Name of the Box') }}</h4>
            </div>
          </div>
          <div class="col-lg-7">
            <input type="text" class="input-field" name="name_of_the_box"
            placeholder="{{ __('Enter Box Name') }}">
          </div>
          </div>

          <!-- Quantity of Items Per Box -->
          <div class="row">
          <div class="col-lg-4">
            <div class="left-area">
            <h4 class="heading">{{ __('Items Per Box') }}</h4>
            </div>
          </div>
          <div class="col-lg-7">
            <input type="number" class="input-field" name="quantity_of_items_per_box"
            placeholder="{{ __('Enter Items Per Box') }}">
          </div>
          </div>

          <br>
          <div class="row">
          <div class="col-lg-4">
            <div class="left-area">

            </div>
          </div>
          <div class="col-lg-7">
            <button class="addProductSubmit-btn" type="submit">{{ __('Create Scheme Option') }}</button>
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