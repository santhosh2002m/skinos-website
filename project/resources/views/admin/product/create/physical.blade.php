@extends('layouts.admin')

@section('styles')
    <link href="{{ asset('assets/admin/css/product.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/admin/css/jquery.Jcrop.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/admin/css/Jcrop-style.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/admin/css/select2.css') }}" rel="stylesheet" />
@endsection

@section('content')
    <div class="content-area">
        <div class="mr-breadcrumb">
            <div class="row">
                <div class="col-lg-12">
                    <h4 class="heading">{{ __('Physical Product') }} <a class="add-btn" href="{{ route('admin-prod-index') }}"><i class="fas fa-arrow-left"></i> {{ __('Back') }}</a></h4>
                    <ul class="links">
                        <li><a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }}</a></li>
                        <li><a href="javascript:;">{{ __('Products') }}</a></li>
                        <li><a href="{{ route('admin-prod-index') }}">{{ __('All Products') }}</a></li>
                        <li><a href="{{ route('admin-prod-types') }}">{{ __('Add Product') }}</a></li>
                        <li><a href="{{ route('admin-prod-create', 'physical') }}">{{ __('Physical Product') }}</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <form id="geniusform" action="{{ route('admin-prod-store') }}" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}
            @include('alerts.admin.form-both')
            <div class="row">
                <div class="col-lg-8">
                    <div class="add-product-content">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="product-description">
                                    <div class="body-area">
                                        <div class="gocover" style="background: url({{ asset('assets/images/' . $gs->admin_loader) }}) no-repeat scroll center center rgba(45, 45, 45, 0.5);"></div>

                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="left-area">
                                                    <h4 class="heading">{{ __('Product Name') }}* </h4>
                                                    <p class="sub-heading">{{ __('(In Any Language)') }}</p>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <input type="text" class="input-field" placeholder="{{ __('Enter Product Name') }}" name="name" required="">
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="left-area">
                                                    <h4 class="heading">{{ __('Product Sku') }}* </h4>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <input type="text" class="input-field" placeholder="{{ __('Enter Product Sku') }}" name="sku" required="" value="{{ Str::random(3) . substr(time(), 6, 8) . Str::random(3) }}">
                                            </div>
                                        </div>

                                        {{-- <div class="row">
                                            <div class="col-lg-12">
                                                <div class="left-area">
                                                    <h4 class="heading">{{ __('Category') }}*</h4>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <select id="cat" name="category_id" required="">
                                                    <option value="">{{ __('Select Category') }}</option>
                                                    @foreach ($cats as $cat)
                                                        <option data-href="{{ route('admin-subcat-load', $cat->id) }}" value="{{ $cat->id }}">{{ $cat->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div> --}}

                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="left-area">
                                                    <h4 class="heading">{{ __('Brand') }}*</h4>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <select id="brand" name="brand_id" required="">
                                                    <option value="">{{ __('Select Brand') }}</option>
                                                    @foreach ($brands as $brand)
                                                        <option value="{{ $brand->id }}">{{ $brand->name }} - (scheme: {{ $brand->scheme->name }})</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="left-area"></div>
                                            </div>
                                            <div class="col-lg-12">
                                                <ul class="list">
                                                    <li>
                                                        <input name="stock_check" class="stock-check" type="checkbox" id="size-check" value="1">
                                                        <label for="size-check" class="stock-text">{{ __('Manage Stock') }}</label>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>

                                        <div class="showbox" id="size-display">
                                            <div class="row">
                                                <div class="col-lg-12"></div>
                                                <div class="col-lg-12">
                                                    <div class="product-size-details" id="size-section">
                                                        <div class="size-area">
                                                            <span class="remove size-remove"><i class="fas fa-times"></i></span>
                                                            <div class="row">
                                                                <div class="col-md-4 col-sm-4">
                                                                    <label>
                                                                        {{ __('Batch Number') }} :
                                                                        <span>{{ __('(eg. S,M,L,XL,3XL,4XL)') }}</span>
                                                                    </label>
                                                                    <input type="text" name="size[]" class="input-field tsize" placeholder="{{ __('Enter Product Size') }}">
                                                                </div>
                                                                <div class="col-md-4 col-sm-4">
                                                                    <label>
                                                                        {{ __('Expired Date') }} :
                                                                        <span>{{ __('(Quantity of this size)') }}</span>
                                                                    </label>
                                                                    <input type="number" name="size_qty[]" class="input-field" placeholder="{{ __('Size Qty') }}" value="1" min="1">
                                                                </div>
                                                                <div class="col-md-4 col-sm-4">
                                                                    <label>
                                                                        {{ __('Brand Execution') }} :
                                                                        <span>{{ __('(Added with base price)') }}</span>
                                                                    </label>
                                                                    <input type="number" name="size_price[]" class="input-field" placeholder="{{ __('Size Price') }}" value="0" min="0">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <a href="javascript:;" id="size-btn" class="add-more"><i class="fas fa-plus"></i>{{ __('Add More') }}</a>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row" id="default_stock">
                                            <div class="col-lg-12">
                                                <div class="left-area">
                                                    <h4 class="heading">{{ __('Product Stock') }}*</h4>
                                                    <p class="sub-heading">{{ __('(Leave Empty will Show Always Available)') }}</p>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <input name="stock" type="number" class="input-field" placeholder="e.g 20" min="0">
                                            </div>
                                        </div>

                                        <!-- Text Editors -->
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="left-area">
                                                    <h4 class="heading">{{ __('Product Description') }}*</h4>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="text-editor">
                                                    <textarea class="nic-edit" name="description"></textarea>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="left-area">
                                                    <h4 class="heading">{{ __('Safety Information') }}*</h4>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="text-editor">
                                                    <textarea class="nic-edit" name="safety_information"></textarea>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="left-area">
                                                    <h4 class="heading">{{ __('Clinical Evidences') }}*</h4>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="text-editor">
                                                    <textarea class="nic-edit" name="clinical_evidences"></textarea>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="left-area">
                                                    <h4 class="heading">{{ __('Usage Instructions') }}*</h4>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="text-editor">
                                                    <textarea class="nic-edit" name="usage_instructions"></textarea>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="left-area">
                                                    <h4 class="heading">{{ __('Ingredients') }}*</h4>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="text-editor">
                                                    <textarea class="nic-edit" name="ingredients"></textarea>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="left-area">
                                                    <h4 class="heading">{{ __('Technology') }}*</h4>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="text-editor">
                                                    <textarea class="nic-edit" name="technology"></textarea>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="checkbox-wrapper">
                                                    <input type="checkbox" name="seo_check" value="1" class="checkclick" id="allowProductSEO">
                                                    <label for="allowProductSEO">{{ __('Allow Product SEO') }}</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="showbox">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="left-area">
                                                        <h4 class="heading">{{ __('Meta Tags') }} *</h4>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <ul id="metatags" class="myTags"></ul>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="left-area">
                                                        <h4 class="heading">{{ __('Meta Description') }} *</h4>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="text-editor">
                                                        <textarea name="meta_description" class="input-field" placeholder="{{ __('Meta Description') }}"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <input type="hidden" name="type" value="Physical">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="add-product-content">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="product-description">
                                    <div class="body-area">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="left-area">
                                                    <h4 class="heading">{{ __('Feature Image') }} *</h4>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="panel panel-body">
                                                    <div class="span4 cropme text-center" id="landscape" style="width: 100%; height: 285px; border: 1px dashed #ddd; background: #f1f1f1;">
                                                        <a href="javascript:;" id="crop-image" class="mybtn1">
                                                            <i class="icofont-upload-alt"></i>
                                                            {{ __('Upload Image Here') }}
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" id="feature_photo" name="photo" value="">
                                        <input type="file" name="gallery[]" class="hidden" id="uploadgallery" accept="image/*" multiple>
                                        <div class="row mb-4">
                                            <div class="col-lg-12 mb-2">
                                                <div class="left-area">
                                                    <h4 class="heading">{{ __('Product Gallery Images') }} *</h4>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <a href="#" class="set-gallery" data-toggle="modal" data-target="#setgallery">
                                                    <i class="icofont-plus"></i> {{ __('Set Gallery') }}
                                                </a>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="left-area">
                                                    <h4 class="heading">{{ __('Product Current Price') }}*</h4>
                                                    <p class="sub-heading">({{ __('In') }} {{ $sign->name }})</p>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <input name="price" type="number" class="input-field" placeholder="{{ __('e.g 20') }}" step="0.1" required="" min="0">
                                            </div>
                                        </div>

                                        {{-- <div class="row">
                                            <div class="col-lg-12">
                                                <div class="left-area">
                                                    <h4 class="heading">{{ __('Product Discount Price') }}*</h4>
                                                    <p class="sub-heading">{{ __('(Optional)') }}</p>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <input name="previous_price" step="0.1" type="number" class="input-field" placeholder="{{ __('e.g 20') }}" min="0">
                                            </div>
                                        </div> --}}

                                        {{-- <div class="row">
                                            <div class="col-lg-12">
                                                <div class="left-area">
                                                    <h4 class="heading">{{ __('Youtube Video URL') }}*</h4>
                                                    <p class="sub-heading">{{ __('(Optional)') }}</p>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <input name="youtube" type="text" class="input-field" placeholder="{{ __('Enter Youtube Video URL') }}">
                                            </div>
                                        </div> --}}

                                        <div class="row d-none">
                                            <div class="col-lg-12">
                                                <div class="left-area"></div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="featured-keyword-area">
                                                    <div class="heading-area">
                                                        <h4 class="title">{{ __('Feature Tags') }}</h4>
                                                    </div>
                                                    <div class="feature-tag-top-filds" id="feature-section">
                                                        <div class="feature-area">
                                                            <span class="remove feature-remove"><i class="fas fa-times"></i></span>
                                                            <div class="row">
                                                                <div class="col-lg-6">
                                                                    <input type="text" name="features[]" class="input-field" placeholder="{{ __('Enter Your Keyword') }}">
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <div class="input-group colorpicker-component cp">
                                                                        <input type="text" name="colors[]" value="#000000" class="input-field cp" />
                                                                        <span class="input-group-addon"><i></i></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <a href="javascript:;" id="feature-btn" class="add-fild-btn"><i class="icofont-plus"></i> {{ __('Add More Field') }}</a>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Updated Tags Section -->
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="left-area">
                                                    <h4 class="heading">{{ __('Tags') }} *</h4>
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <select name="tags[]" id="tags" class="select2" multiple="multiple" required>
                                                    <option value="">{{ __('Select Tags') }}</option>
                                                    @foreach ($tags as $tag)
                                                        <option value="{{ $tag->slug }}">{{ $tag->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row text-center">
                                            <div class="col-6 offset-3">
                                                <button class="addProductSubmit-btn" type="submit">{{ __('Create Product') }}</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="modal fade" id="setgallery" tabindex="-1" role="dialog" aria-labelledby="setgallery" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">{{ __('Image Gallery') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="top-area">
                        <div class="row">
                            <div class="col-sm-6 text-right">
                                <div class="upload-img-btn">
                                    <label for="image-upload" id="prod_gallery"><i class="icofont-upload-alt"></i>{{ __('Upload File') }}</label>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <a href="javascript:;" class="upload-done" data-dismiss="modal"> <i class="fas fa-check"></i> {{ __('Done') }}</a>
                            </div>
                            <div class="col-sm-12 text-center">
                                (<small>{{ __('You can upload multiple Images.') }}</small>)
                            </div>
                        </div>
                    </div>
                    <div class="gallery-images">
                        <div class="selected-image">
                            <div class="row"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/admin/js/jquery.Jcrop.js') }}"></script>
    <script src="{{ asset('assets/admin/js/jquery.SimpleCropper.js') }}"></script>
    <script src="{{ asset('assets/admin/js/select2.js') }}"></script>

    <script type="text/javascript">
        (function($) {
            "use strict";
            $(document).ready(function() {
                // Initialize Select2 for all select elements
                $('.select2').select2({
                    placeholder: function() {
                        return $(this).data('placeholder') || "Select an option";
                    },
                    maximumSelectionLength: 4,
                });

                // Initialize Select2 specifically for tags with multi-select
                $('#tags').select2({
                    placeholder: "{{ __('Select Tags') }}",
                    allowClear: true,
                    width: '100%',
                    tags: true // Optional: allows adding new tags if needed
                });

                // Initialize NicEdit for textareas
                bkLib.onDomLoaded(function() {
                    new nicEditor({ fullPanel: true }).panelInstance('description');
                    new nicEditor({ fullPanel: true }).panelInstance('safety_information');
                    new nicEditor({ fullPanel: true }).panelInstance('clinical_evidences');
                    new nicEditor({ fullPanel: true }).panelInstance('usage_instructions');
                    new nicEditor({ fullPanel: true }).panelInstance('technology');
                });

                // Detect Enter key press in textareas and submit form via AJAX
                $('textarea.nic-edit').on('keypress', function(e) {
                    if (e.which === 13 && !e.shiftKey) { // Enter key pressed without Shift
                        e.preventDefault(); // Prevent default Enter behavior (e.g., new line)

                        // Get NicEdit content
                        var description = nicEditors.findEditor('description').getContent();
                        var safety_information = nicEditors.findEditor('safety_information').getContent();
                        var clinical_evidences = nicEditors.findEditor('clinical_evidences').getContent();
                        var usage_instructions = nicEditors.findEditor('usage_instructions').getContent();
                        var technology = nicEditors.findEditor('technology').getContent();

                        // Prepare form data
                        var formData = new FormData($('#geniusform')[0]);
                        formData.set('description', description);
                        formData.set('safety_information', safety_information);
                        formData.set('clinical_evidences', clinical_evidences);
                        formData.set('usage_instructions', usage_instructions);
                        formData.set('technology', technology);

                        // AJAX request to store the data
                        $.ajax({
                            url: $('#geniusform').attr('action'), // Form action URL
                            method: 'POST',
                            data: formData,
                            contentType: false,
                            processData: false,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // CSRF token
                            },
                            success: function(response) {
                                if (response.success) {
                                    alert('Product saved successfully!');
                                    window.location.href = "{{ route('admin-prod-index') }}";
                                } else {
                                    alert('Error: ' + response.message);
                                }
                            },
                            error: function(xhr) {
                                alert('An error occurred while saving the product.');
                                console.log(xhr.responseText);
                            }
                        });
                    }
                });

                // Gallery Section Insert
                $(document).on('click', '.remove-img', function() {
                    var id = $(this).find('input[type=hidden]').val();
                    $('#galval' + id).remove();
                    $(this).parent().parent().remove();
                });

                $(document).on('click', '#prod_gallery', function() {
                    $('#uploadgallery').click();
                    $('.selected-image .row').html('');
                    $('#geniusform').find('.removegal').val(0);
                });

                $("#uploadgallery").change(function() {
                    var total_file = document.getElementById("uploadgallery").files.length;
                    for (var i = 0; i < total_file; i++) {
                        $('.selected-image .row').append('<div class="col-sm-6">' +
                            '<div class="img gallery-img">' +
                            '<span class="remove-img"><i class="fas fa-times"></i>' +
                            '<input type="hidden" value="' + i + '">' +
                            '</span>' +
                            '<a href="' + URL.createObjectURL(event.target.files[i]) + '" target="_blank">' +
                            '<img src="' + URL.createObjectURL(event.target.files[i]) + '" alt="gallery image">' +
                            '</a>' +
                            '</div>' +
                            '</div> '
                        );
                        $('#geniusform').append('<input type="hidden" name="galval[]" id="galval' + i + '" class="removegal" value="' + i + '">');
                    }
                });

                $('.cp').colorpicker();
                $('.cropme').simpleCropper();

                $(document).on('click', '#size-check', function() {
                    if ($(this).is(':checked')) {
                        $('#default_stock').addClass('d-none');
                    } else {
                        $('#default_stock').removeClass('d-none');
                    }
                });
            });
        })(jQuery);
    </script>

    @include('partials.admin.product.product-scripts')
@endsection