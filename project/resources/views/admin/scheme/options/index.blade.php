@extends('layouts.admin')

@section('content')
    <input type="hidden" id="headerdata" value="{{ __('CITY') }}">
    <div class="content-area">
        <div class="mr-breadcrumb">
            <div class="row">
                <div class="col-lg-12">
                    <h4 class="heading"><u>{{ $scheme->name }}</u> / {{ __('Manage Scheme') }}</h4>
                    <ul class="links">
                        <li>
                            <a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }} </a>
                        </li>
                        <li><a href="{{ route('admin-scheme-index') }}">{{ __('Manage Scheme') }}</a></li>
                        <li>
                            <a href="#">{{ __('Options') }}</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="product-area">
            <div class="row">
                <div class="col-lg-12">
                    <div class="mr-table allproduct">
                        @include('includes.admin.form-success')
                        <div class="table-responsive">
                            <table id="geniustable" class="table table-hover dt-responsive" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>{{ __('Option Name') }}</th>
                                        <th>{{ __('Order') }}</th>
                                        <th>{{ __('Total Quantity') }}</th>
                                        <th>{{ __('Discount Percentage') }}</th>
                                        <th>{{ __('Mix and Match Name') }}</th>
                                        <th>{{ __('Number of Boxes') }}</th>
                                        <th>{{ __('Quantity of items in Box') }}</th>
                                        <th>{{ __('Status') }}</th>
                                        <th>{{ __('Options') }}</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal1" tabindex="-1" role="dialog" aria-labelledby="modal1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="submit-loader">
                    <img src="{{ asset('assets/images/' . $gs->admin_loader) }}" alt="">
                </div>
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
                </div>
            </div>
        </div>
    </div>

    {{-- DELETE MODAL --}}
    <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="modal1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header d-block text-center">
                    <h4 class="modal-title d-inline-block">{{ __('Confirm Delete') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="text-center">{{ __('You are sure?') }}.</p>
                    <p class="text-center">{{ __('Do you want to proceed?') }}</p>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('Cancel') }}</button>
                    <form action="" class="d-inline delete-form" method="POST">
                        <input type="hidden" name="_method" value="delete" />
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <button type="submit" class="btn btn-danger">{{ __('Delete') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- DELETE MODAL ENDS --}}
@endsection

@section('scripts')
    {{-- DATA TABLE --}}
    <script type="text/javascript">
        var table = $('#geniustable').DataTable({
            ordering: false,
            processing: true,
            serverSide: true,
            ajax: '{{ route('admin-scheme-option-datatables', $scheme->id) }}',
            columns: [
                {
                    data: 'name',
                    searchable: true,
                    orderable: false
                },
                {
                    data: 'order',
                    searchable: true,
                    orderable: false
                },
                {
                    data: 'total_quantity',
                    searchable: true,
                    orderable: false
                },
                {
                    data: 'discount_percentage',
                    searchable: true,
                    orderable: false
                },
                {
					data: 'name_of_the_box',
					searchable: true,
					orderable: false
				},
				{
					data: 'number_of_boxes',
					searchable: true,
					orderable: false
				},
				{
					data: 'quantity_of_items_per_box',
					searchable: true,
					orderable: false
				},
                {
                    data: 'status',
                    searchable: false,
                    orderable: false
                },
                {
                    data: 'action',
                    searchable: false,
                    orderable: false
                }
            ],
            language: {
                processing: '<img src="{{ asset('assets/images/' . $gs->admin_loader) }}">'
            },
            drawCallback: function(settings) {
                $('.select').niceSelect();
            }
        });

        $(function() {
            $(".btn-area").append('<div class="col-sm-4 table-contents">' +
                '<a class="add-btn" data-href="{{ route('admin-scheme-option-create', $scheme->id) }}" id="add-data" data-toggle="modal" data-target="#modal1">' +
                '<i class="fas fa-plus"></i> Add New Option' +
                '</a>' +
                '</div>');
        });
    </script>
@endsection