@extends('layouts.load')
 
@section('content')
 
<div class="content-area">
  <div class="add-product-content">
    <div class="row">
      <div class="col-lg-12">
        <div class="product-description">
          <div class="body-area">
            @include('includes.admin.form-error')
            <form id="geniusformdata" action="{{route('admin-scheme-option-update',$schemeEntry->id)}}" method="POST">
              {{csrf_field()}}
 
              <div class="row">
                <div class="col-lg-4">
                  <div class="left-area">
                    <h4 class="heading">{{ __('Current Scheme') }} *</h4>
                  </div>
                </div>
                <div class="col-lg-7">
                  <input type="text" readonly class="input-field" value="{{$schemeEntry->scheme->name}}">
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
                  <input type="text" class="input-field" name="name" placeholder="{{ __('Enter Option (Ex : 5+1..etc )') }}" value="{{$schemeEntry->name}}">
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
                  <input type="number" class="input-field" name="order" placeholder="{{ __('Enter Order (e.g., 1, 2, 3)') }}" value="{{$schemeEntry->order}}" min="0" required>
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
                  <input type="text" class="input-field" name="total_quantity" placeholder="{{ __('Enter Overall Quantity of Products') }}" value="{{$schemeEntry->total_quantity}}">
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
                  <input type="number" step="0.00000000000000001" class="input-field" name="discount_percentage" placeholder="{{ __('Enter Discount percentage for this option') }}" value="{{$schemeEntry->discount_percentage}}">
                </div>
              </div>

              {{-- Number of Boxes --}}
          <div class="row">
            <div class="col-lg-4">
              <div class="left-area">
              <h4 class="heading">{{ __('Number of Boxes') }} *</h4>
              <p class="sub-heading">{{ __('(e.g., 5)') }}</p>
              </div>
            </div>
            <div class="col-lg-7">
              <input type="number" class="input-field" name="number_of_boxes"
              value="{{ $schemeEntry->number_of_boxes }}" placeholder="{{ __('Enter Number of Boxes') }}"
              required>
            </div>
            </div>
  
            {{-- Name of the Box --}}
            <div class="row">
            <div class="col-lg-4">
              <div class="left-area">
              <h4 class="heading">{{ __('Name of the Box') }} *</h4>
              <p class="sub-heading">{{ __('(e.g., Product Box)') }}</p>
              </div>
            </div>
            <div class="col-lg-7">
              <input type="text" class="input-field" name="name_of_the_box"
              value="{{ $schemeEntry->name_of_the_box }}" placeholder="{{ __('Enter Name of the Box') }}"
              required>
            </div>
            </div>
  
            {{-- Quantity of Items per Box --}}
            <div class="row">
            <div class="col-lg-4">
              <div class="left-area">
              <h4 class="heading">{{ __('Quantity of Items per Box') }} *</h4>
              <p class="sub-heading">{{ __('(e.g., 6 items per box)') }}</p>
              </div>
            </div>
            <div class="col-lg-7">
              <input type="number" class="input-field" name="quantity_of_items_per_box"
              value="{{ $schemeEntry->quantity_of_items_per_box }}"
              placeholder="{{ __('Enter Quantity per Box') }}" required>
            </div>
            </div>
 
              <br>
              <div class="row">
                <div class="col-lg-4">
                  <div class="left-area">
                  </div>
                </div>
                <div class="col-lg-7">
                  <button class="addProductSubmit-btn" type="submit">{{ __('Update Option') }}</button>
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