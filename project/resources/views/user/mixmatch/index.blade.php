@extends('layouts.front')
<style>
    /* General content area */
    .mix_and_match .content-area {
        padding: 30px;
        background-color: #f9f9f9;
        min-height: 100vh;
    }

    /* Breadcrumb styling */
    .mix_and_match .mr-breadcrumb {
        margin-bottom: 20px;
    }

    .mix_and_match .mr-breadcrumb .heading {
        font-size: 22px;
        font-weight: 600;
        color: #333;
    }

    .mix_and_match .mr-breadcrumb .links {
        list-style: none;
        padding: 0;
        display: flex;
        gap: 10px;
    }

    .mix_and_match .mr-breadcrumb .links li a {
        color: #007bff;
        text-decoration: none;
        font-weight: 500;
    }

    .mix_and_match .mr-breadcrumb .links li a:hover {
        text-decoration: underline;
    }

    /* Product description wrapper */
    .mix_and_match .product-description {
        background: #fff;
        padding: 0.5rem 2rem;
        border-radius: 8px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    /* Left side table */
    .mix_and_match .allproduct .table-responsive {
        border-right: none;
        background-color: #fff;
        padding: 10px;
    }

    .mix_and_match #order-geniustable {
        width: 100%;
        border-collapse: collapse;
    }

    .mix_and_match #order-geniustable th,
    .mix_and_match #order-geniustable td {
        padding: 12px;
        border: none;
        font-size: 14px;
    }

    .mix_and_match #order-geniustable th,
    .mix_and_match #order-geniustable tr {
        background-color: unset;
        border: none;
        font-weight: 600;
    }

    /* Right side user details card */
    .mix_and_match .border {
        border: 1px solid #e3e3e3 !important;
        border-radius: 6px;
        background-color: #fff;
    }

    .mix_and_match label {
        font-weight: 500;
        margin-bottom: 5px;
        display: block;
    }

    .mix_and_match .input-group select {
        height: 38px;
        border-radius: 4px;
        border: 1px solid #ced4da;
    }

    /* Tables, buttons, and more */
    .mix_and_match .table {
        background-color: #fff;
    }

    .mix_and_match .table th {
        background-color: #f7f7f7;
        font-weight: 600;
    }

    .mix_and_match select.form-control {
        width: 100%;
    }

    /* Button styling (if any exist in partials) */
    .mix_and_match .btn {
        border-radius: 4px;
        padding: 8px 16px;
        font-weight: 500;
    }

    .mix_and_match h3 {
        font-size: 20px;
        margin-bottom: 15px;
        color: #333;
    }

    .mix_and_match .product-card-list {
        display: flex;
        flex-direction: column;
        gap: 15px;
        max-height: 100vh;
        overflow-y: auto;
        padding: 10px;
        background-color: #fff;
    }

    .mix_and_match .product-card {
        background: #fdfdfd;
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 10px;
        margin-bottom: 10px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    }
    .mix_and_match #product-boxes .product-card .image-container img{
        max-width: unset;
        width: 70px;
        border-radius: 50%;
    }
    .mix_and_match #product-boxes .product-card .content-container strong{
        max-width: 90%;
    }
    
    .mix_and_match .product-card:hover {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }

    .mix_and_match .product-title {
        font-size: 14px;
        font-weight: 600;
        margin: 0 0 4px 0;
        color: #333;
    }

    .mix_and_match .product-sku {
        font-size: 12px;
        color: #888;
        margin: 0;
    }

    .mix_and_match .product-options {
        margin-top: 6px;
    }

    .mix_and_match .dataTables_wrapper .table {
        border: none;
    }

    .mix_and_match .product-options .btn {
        font-size: 12px;
        padding: 6px 10px;
    }


    /* Conbine other CSS */
    .mix_and_match .dt-search {
        right: 0 !important;
        display: flex;
        flex-direction: row;
        justify-content: right;
        align-items: baseline;
    }


    /* BOXES */
    .mix_and_match .box-slot {
        min-height: 10rem;
        background-color: #f5f5f5;
        border-radius: 6px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        transition: background 0.3s ease;
    }

    .mix_and_match .box-slot.filled {
        background-color: #e6f7ff;
        border-color: #91d5ff;
    }

    .mix_and_match .box-slot .product-name {
        font-weight: 600;
        color: #333;
        margin-bottom: 4px;
    }

    .mix_and_match .box-slot .product-details {
        font-size: 12px;
        color: #555;
    }

    /* Remove Filled Box CSS */
    .box-slot {
        position: relative;
    }

    .remove-from-box {
        position: absolute;
        top: 5px;
        right: 5px;
        z-index: 2;
    }

    /* custom css */
    #order-geniustable_wrapper .dt-layout-row:first-child {
        position: sticky;
        top: -10;
        z-index: 3;
        background: white;
    }

    #order-geniustable_wrapper .dt-layout-row:first-child #dt-search-0 {
        border-radius: 10px
    }

    /* CSS for Readonly fields */
    #sessionStateContainer {
        display: flex;
        gap: 10px;
        padding: 1rem;
        background-color: #f8f9fa;
        border-radius: 0.5rem;
        flex-direction: column;
    }

    #sessionStateContainer input[type="text"] {
        background-color: #e9ecef;
        border: 1px solid #ced4da;
        border-radius: 0.375rem;
        padding: 0.5rem 0.75rem;
        font-size: 1rem;
        width: 100%;
        margin-bottom: 0.5rem;
        color: #495057;
    }

    #sessionStateContainer input[readonly] {
        cursor: default;
    }

    #sessionStateContainer .btn {
        font-weight: 500;
    }
</style>
@php
    $brandsJson = $brands->map(function ($brand) {
        return [
            'id' => $brand->id,
            'name' => $brand->name,
            'scheme_entries' => $brand->scheme
                ? $brand->scheme->scheme_entries->map(function ($entry) {
                    return [
                        'id' => $entry->id,
                        'name' => $entry->name,
                        'name_of_the_box' => $entry->name_of_the_box,
                        'number_of_boxes' => $entry->number_of_boxes,
                        'quantity_of_items_per_box' => $entry->quantity_of_items_per_box,
                    ];
                })
                : [],
        ];
    })->toJson();
@endphp
@section('content')
    <div class="mix_and_match">
        <div class="content-area">
            <div class="add-product-content1 add-product-content2">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="product-description">
                            <div class="title m-1 text-center">
                                <h4>Mix and Match Products</h4>
                            </div>
                            <div class="gocover"
                                style="background: url({{asset('assets/images/' . $gs->admin_loader)}}) no-repeat scroll center center rgba(45, 45, 45, 0.5);">
                            </div>

                            <div class="alert alert-success alert-dismissible validation" style="display: none;">
                                <button type="button" class="close alert-close">&times;</button>
                                <p class="text-left"></p>
                            </div>
                            <div class="alert alert-danger alert-dismissible validation" style="display: none;">
                                <button type="button" class="close alert-close">&times;</button>
                                <ul class="text-left">
                                </ul>
                            </div>


                            <div class="product-area">
                                <div class="row">
                                    <div class="col-lg-4 border-right p-0">
                                        <div id="sessionStateContainer" style="display: none">
                                            <div class="name_container d-flex justify-content-around">
                                                <p><strong> Brand :</strong> <span id="brand_readonly_name"></span></p>
                                                <p><strong> Scheme :</strong> <span id="scheme_readonly_name"></span>
                                                </p>
                                            </div>
                                            <button id="clearMixAndMatch" class="btn btn-secondary mt-3 w-100">Clear Mix &
                                                Match</button>
                                        </div>
                                        <form id="brand-scheme-form" style="display: block">
                                            <div class="form-group">
                                                <label for="brand_id">Brand</label>
                                                <select name="brand_id" id="brand_id" class="form-control" required>
                                                    <option value="" selected disabled>Select Brand</option>
                                                    @foreach ($brands as $brand)
                                                        <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="form-group mt-3">
                                                <label for="scheme_entry_id">Scheme Entry</label>
                                                <select name="scheme_entry_id" id="scheme_entry_id" class="form-control"
                                                    required disabled>
                                                    <option value="">Select Scheme Entry</option>
                                                </select>
                                            </div>

                                            <button type="submit" class="btn btn-primary mt-3 w-100">Load Products</button>
                                        </form>
                                        <div class="mr-table allproduct" id="product_section" style="display: none">
                                            @include('alerts.form-success')
                                            <div class="table-responsive" style="height: 60vh;overflow-y: scroll">
                                                <table id="order-geniustable" class="table table-hover dt-responsive"
                                                    cellspacing="0" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th style="font-size: 1.55rem;">{{ __('Products') }}</th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-8">
                                        @if (Auth::user())
                                            <div class="btn-container d-flex justify-content-end gap-2">
                                                <button class="btn btn-success" id="add-to-mix-and-match-to-cart">
                                                    Add to Cart
                                                </button>
                                            </div>
                                        @else
                                            <div class="btn-container d-flex justify-content-end gap-2">
                                                <button class="btn btn-success">
                                                    <a href="{{route('user.login')}}" style="color: white">
                                                        Login to Proceed
                                                    </a>
                                                </button>
                                            </div>
                                        @endif
                                        <div class="py-4 px-4 my-2 mx-4 border">
                                            <div class="row" id="product-boxes">
                                                @for($i = 0; $i < 10; $i++)
                                                    <div class="col-md-4 mb-3">
                                                        <div class="box-slot border p-3 text-center" data-slot="{{$i}}">
                                                            <p>No Product Selected</p>
                                                        </div>
                                                    </div>
                                                @endfor
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection


@section('script')

    {{-- DATA TABLE --}}

    <script src="{{ asset('assets/front/js/datatables.min.js') }}"></script>
    <script defer type="text/javascript">
        document.addEventListener('DOMContentLoaded', function () {
            // Dependency checks
            if (typeof $ === 'undefined') {
                console.error('jQuery is not loaded.');
                return;
            }
            if (typeof $.fn.DataTable === 'undefined') {
                console.error('DataTables is not loaded.');
                return;
            }
            if (typeof toastr === 'undefined') {
                console.error('Toastr is not loaded.');
                return;
            }

            const filledData = [];
            let initialState = {
                brand: null,
                scheme_entry_id: null
            };
            let dataTable = null;

            function generateUID(productId) {
                return `${productId}_${crypto.randomUUID()}`;
            }

            let batch = generateUID("batch");

            function sanitizeHTML(str) {
                return str.replace(/[<>"'&]/g, function (match) {
                    return {
                        '<': '&lt;',
                        '>': '&gt;',
                        '"': '&quot;',
                        "'": '&#x27;',
                        '&': '&amp;'
                    }[match];
                });
            }

            $('#order-geniustable').on('click', '.add-to-box', function () {
                const rawProduct = $(this).data('product');
                const img = $(this).data('image');

                if (!rawProduct || !rawProduct.id || !rawProduct.name || !rawProduct.sku || !img) {
                    toastr.error('Invalid product data.');
                    return;
                }

                const product = {
                    ...rawProduct,
                    uid: generateUID(rawProduct.id),
                    is_mix_match : true,
                    mix_match_batch: batch,
                    image: img,
                    name: rawProduct.name,
                    sku: rawProduct.sku,
                    scheme_entry_id: initialState.scheme_entry_id
                };

                const emptyBox = $('#product-boxes .box-slot').not('.filled').first();
                if (emptyBox.length) {
                    const pos = filledData.push(product) - 1;
                    emptyBox.addClass('filled').html(`
                        <div class="product-card text-left d-flex gap-3 align-items-start">
                            <div class="image-container">
                                <img src="${sanitizeHTML(product.image)}" alt="${sanitizeHTML(product.name)}" class="img-thumbnail mb-2">
                            </div>
                            <div class="content-container">
                                <strong class="d-block mb-1">${sanitizeHTML(product.name.length > 20 ? product.name.substring(0, 20) + '…' : product.name)}</strong>
                                <div class="product-details">SKU: ${sanitizeHTML(product.sku)}</div>
                            </div>
                            <button type="button" class="btn btn-sm btn-danger remove-from-box" data-id="${pos}" data-uid="${product.uid}" title="Remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    `);
                } else {
                    toastr.warning('All boxes are already filled.');
                }
            });

            $('#product-boxes').on('click', '.remove-from-box', function () {
                const uid = $(this).data('uid');
                const removedIndex = filledData.findIndex(p => p.uid === uid);

                if (removedIndex === -1) return;

                filledData.splice(removedIndex, 1);

                const $slot = $(this).closest('.box-slot');
                $slot.removeClass('filled').html('<p>No Product Selected</p>');
            });

            // Handling the Brand Form
            const brandData = {!! $brandsJson !!};

            document.getElementById('brand_id').addEventListener('change', function () {
                const brandId = this.value;
                const schemeEntrySelect = document.getElementById('scheme_entry_id');
                schemeEntrySelect.innerHTML = '<option value="">Select Scheme Entry</option>';
                schemeEntrySelect.disabled = true;

                if (!brandData || !Array.isArray(brandData)) {
                    toastr.error('Invalid brand data.');
                    return;
                }

                const selectedBrand = brandData.find(b => b.id == brandId);
                if (selectedBrand && Array.isArray(selectedBrand.scheme_entries) && selectedBrand.scheme_entries.length > 0) {
                    selectedBrand.scheme_entries.forEach(entry => {
                        if (entry.id && entry.name) {
                            const opt = document.createElement('option');
                            opt.value = entry.id;
                            opt.textContent = entry.name;
                            schemeEntrySelect.appendChild(opt);
                        }
                    });
                    schemeEntrySelect.disabled = false;
                }
            });

            function updateProductBoxes(schemeEntryId) {
                if (!brandData || !Array.isArray(brandData)) {
                    toastr.error('Invalid brand data.');
                    return;
                }

                const selectedBrand = brandData.find(brand => {
                    return brand.scheme_entries.some(entry => entry.id == schemeEntryId);
                });

                if (selectedBrand) {
                    const schemeEntry = selectedBrand.scheme_entries.find(entry => entry.id == schemeEntryId);
                    if (schemeEntry) {
                        const productBoxesContainer = $('#product-boxes');
                        productBoxesContainer.empty();
                        filledData.length = 0;

                        for (let i = 0; i < schemeEntry.number_of_boxes; i++) {
                            productBoxesContainer.append(`
                                <div class="col-md-4 mb-3">
                                    <div class="box-slot border p-3 text-center" data-slot="${i}">
                                        <p>${schemeEntry.name_of_the_box} (${schemeEntry.quantity_of_items_per_box} items)</p>
                                    </div>
                                </div>
                            `);
                        }
                    }
                }
            }

            $(document).on('change', '#scheme_entry_id', function () {
                const schemeEntryId = $(this).val();
                if (schemeEntryId) {
                    updateProductBoxes(schemeEntryId);
                }
            });

            document.getElementById('brand-scheme-form').addEventListener('submit', function (e) {
                e.preventDefault();
                const productSection = document.getElementById('product_section');
                const brandForm = document.getElementById('brand-scheme-form');
                const sessionStateContainer = document.getElementById('sessionStateContainer');
                const brandReadOnlyValue = document.getElementById('brand_readonly_name');
                const schemeReadOnlyValue = document.getElementById('scheme_readonly_name');

                const brandId = document.getElementById('brand_id').value;
                const schemeEntryId = document.getElementById('scheme_entry_id').value;

                brandReadOnlyValue.textContent = document.getElementById('brand_id').selectedOptions[0]?.text || '';
                schemeReadOnlyValue.textContent = document.getElementById('scheme_entry_id').selectedOptions[0]?.text || '';

                initialState.brand = brandId;
                initialState.scheme_entry_id = schemeEntryId;

                if (!brandId || !schemeEntryId) {
                    toastr.error('Please select both Brand and Scheme Entry.');
                    return;
                }

                if (dataTable) {
                    dataTable.destroy();
                    dataTable = null;
                }

                productSection.style.display = 'block';
                sessionStateContainer.style.display = 'block';
                brandForm.style.display = 'none';

                dataTable = $('#order-geniustable').DataTable({
                    ordering: false,
                    processing: true,
                    serverSide: true,
                    sorting: false,
                    paging: false,
                    searching: false,
                    ajax: {
                        url: '{{ route('user-mix-match-datatables') }}',
                        data: {
                            brand_id: brandId,
                            scheme_entry_id: schemeEntryId
                        },
                        error: function (xhr, error, thrown) {
                            toastr.error('Failed to load product data. Please try again.');
                            productSection.style.display = 'none';
                            sessionStateContainer.style.display = 'none';
                            brandForm.style.display = 'block';
                        }
                    },
                    columns: [
                        { data: 'product', name: 'product' }
                    ],
                    language: {
                        processing: '<img src="{{ asset('assets/images/' . $gs->admin_loader) }}">'
                    }
                });
            });

            document.getElementById('clearMixAndMatch').addEventListener('click', function (e) {
                e.preventDefault();
                batch = generateUID("batch")
                const productSection = document.getElementById('product_section');
                const brandForm = document.getElementById('brand-scheme-form');
                const sessionStateContainer = document.getElementById('sessionStateContainer');

                productSection.style.display = 'none';
                sessionStateContainer.style.display = 'none';
                brandForm.style.display = 'block';

                initialState.brand = null;
                initialState.scheme_entry_id = null;

                filledData.length = 0;
                $('#product-boxes .box-slot').each(function () {
                    $(this).removeClass('filled').html('<p class="box-slot">No Product Selected</p>');
                });

                document.getElementById('brand_readonly_name').textContent = '';
                document.getElementById('scheme_readonly_name').textContent = '';
                document.getElementById('brand_id').value = '';
                document.getElementById('scheme_entry_id').innerHTML = '<option value="">Select Scheme Entry</option>';
                document.getElementById('scheme_entry_id').disabled = true;

                if (dataTable) {
                    dataTable.destroy();
                    dataTable = null;
                }
            });

            $('#add-to-mix-and-match-to-cart').on('click', function (e) {
                e.preventDefault();
                if (filledData.length < 1) {
                    toastr.warning("Please fill the Boxes with Products");
                    return;
                }
                const selectedBrand = brandData.find(brand => {
                    return brand.scheme_entries.some(entry => entry.id == initialState.scheme_entry_id);
                });
                const schemeEntry = selectedBrand.scheme_entries.find(entry => entry.id == initialState.scheme_entry_id);
                if (!schemeEntry) {
                    
                }
                if (filledData.length === schemeEntry.number_of_boxes) {
                    $.ajax({
                        url: '{{ route('user-mix_match_cart_submit') }}',
                        type: 'POST',
                        data: {
                            "items": filledData,
                            "scheme_id": initialState.scheme_entry_id,
                            "brand_id": initialState.brand
                        },
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (response) {
                            $("#cart-count").html(response[0]);
                            $("#cart-count1").html(response[0]);
                            toastr.success('The Mix and Match Bundle added to Cart');
                        },
                        error: function (xhr, status, error) {
                            console.error('Error:', xhr.status, error);
                        }
                    });
                }else{
                    toastr.warning("Please fill products in all the boxes");
                }
            });
        });
    </script>
@endsection