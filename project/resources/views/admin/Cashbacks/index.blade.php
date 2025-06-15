@extends('layouts.admin')

@section('content')
    <input type="hidden" id="headerdata" value="{{ __('Cashback') }}">
    <div class="content-area">
        <div class="mr-breadcrumb">
            <div class="row">
                <div class="col-lg-12">
                    <h4 class="heading">{{ __('Cashback Rules') }}</h4>
                    <ul class="links">
                        <li>
                            <a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }} </a>
                        </li>
                        <li><a href="javascript:;">{{ __('Manage Cashbacks') }}</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="product-area">
            <div class="row">
                <div class="col-lg-12">
                    <div class="mr-table allproduct">
                        @include('alerts.admin.form-success')

                        <div class="table-responsive">
                            <table id="geniustable" class="table table-hover dt-responsive" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>{{ __('Min Purchase') }}</th>
                                        <th>{{ __('Max Purchase') }}</th>
                                        <th>{{ __('Advance %') }}</th>
                                        <th>{{ __('7 Days %') }}</th>
                                        <th>{{ __('7-30 Days %') }}</th>
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

    {{-- ADD / EDIT MODAL --}}
    <div class="modal fade" id="modal1" tabindex="-1" role="dialog" aria-labelledby="modal1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="submit-loader">
                    <img src="{{ asset('assets/images/' . $gs->admin_loader) }}" alt="">
                </div>
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body"></div>
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
                    <p class="text-center">{{ __('You are about to delete this cashback rule.') }}</p>
                    <p class="text-center">{{ __('Do you want to proceed?') }}</p>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('Cancel') }}</button>
                    <form action="" class="d-inline delete-form" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">{{ __('Delete') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        (function($) {
            "use strict";

            var table = $('#geniustable').DataTable({
                ordering: false,
                processing: true,
                serverSide: true,
                ajax: '{{ route('admin-cashback-datatables') }}',
                columns: [
                    { data: 'min_purchase_value', name: 'min_purchase_value' },
                    { data: 'max_purchase_value', name: 'max_purchase_value' },
                    { data: 'advance_percentage', name: 'advance_percentage' },
                    { data: 'days_7_percentage', name: 'days_7_percentage' },
                    { data: 'days_7_30_percentage', name: 'days_7_30_percentage' },
                    { data: 'action', name: 'action', searchable: false, orderable: false }
                ],
                language: {
                    processing: '<img src="{{ asset('assets/images/' . $gs->admin_loader) }}">'
                }
            });

            $(document).on('click', '#add-data', function() {
                let href = $(this).data('href');
                $('#modal1').modal('show').find('.modal-body').load(href);
            });

            $(document).on('click', '.edit', function() {
                let href = $(this).data('href');
                $('#modal1').modal('show').find('.modal-body').load(href);
            });

            $(document).on('click', '.delete', function() {
                let href = $(this).data('href');
                $('#confirm-delete').modal('show').find('.delete-form').attr('action', href);
            });

            $(document).on('submit', '.ajax-form', function(e) {
                e.preventDefault();
                let form = $(this);
                $.ajax({
                    url: form.attr('action'),
                    method: form.attr('method'),
                    data: form.serialize(),
                    success: function(response) {
                        if (response.success) {
                            toastr.success(response.success);
                            $('#modal1').modal('hide');
                            table.ajax.reload();
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            let errorMsg = '';
                            for (let key in errors) {
                                errorMsg += errors[key].join('<br>') + '<br>';
                            }
                            toastr.error(errorMsg);
                        } else {
                            toastr.error('An error occurred.');
                        }
                    }
                });
            });

            $(function() {
                $(".btn-area").append('<div class="col-sm-4 table-contents">' +
                    '<a class="add-btn" data-href="{{ route('admin-cashback-create') }}" id="add-data" data-toggle="modal" data-target="#modal1">' +
                    '<i class="fas fa-plus"></i> <span class="remove-mobile">{{ __('Add New') }}</span>' +
                    '</a>' +
                    '</div>');
            });
        })(jQuery);
    </script>
@endsection