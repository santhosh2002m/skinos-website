@extends('layouts.load')

@section('content')
    <div class="content-area">
        <div class="add-product-content1">
            <div class="row">
                <div class="col-lg-12">
                    <div class="product-description">
                        <div class="body-area">
                            @include('alerts.admin.form-error')
                            <form id="geniusformdata" action="{{ route('admin-tag-update', $data->id) }}" method="POST" enctype="multipart/form-data">
                                {{ csrf_field() }}

                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="left-area">
                                            <h4 class="heading">{{ __('Name') }} *</h4>
                                            <p class="sub-heading">{{ __('(In Any Language)') }}</p>
                                        </div>
                                    </div>
                                    <div class="col-lg-7">
                                        <input type="text" class="input-field" name="name" placeholder="{{ __('Enter Name') }}" required="" value="{{ $data->name }}">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="left-area">
                                            <h4 class="heading">{{ __('Slug') }} *</h4>
                                            <p class="sub-heading">{{ __('(In English)') }}</p>
                                        </div>
                                    </div>
                                    <div class="col-lg-7">
                                        <input type="text" class="input-field" name="slug" placeholder="{{ __('Enter Slug') }}" required="" value="{{ $data->slug }}">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="left-area">
                                            <h4 class="heading">{{ __('Image') }}</h4>
                                        </div>
                                    </div>
                                    <div class="col-lg-7">
                                        <input type="file" id="image" name="image" class="input-field">
                                        @if($data->image)
                                            <img src="{{ asset('assets/images/categories/' . $data->image) }}" alt="{{ $data->name }}" style="max-width: 100px; margin-top: 10px;">
                                        @else
                                            <p>{{ __('No Image Uploaded') }}</p>
                                        @endif
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