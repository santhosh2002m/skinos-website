@extends('layouts.admin')

@section('content')
    <input type="hidden" id="headerdata" value="{{ __('STATE') }}">
    <div class="content-area">
        <div class="mr-breadcrumb">
            <div class="row">
                <div class="col-lg-12">
                    {{-- <h4 class="heading"><u>{{ $country->country_name }}</u> / {{ __('Manage State') }}</h4> --}}
                    <ul class="links">
                        <li>
                            <a href="{{ route('admin.dashboard') }}">{{ __('Dashboard') }} </a>
                        </li>
                        <li><a href="javascript:;">{{ __('Manage Scheme') }}</a></li>
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
                                        <th>{{ __('Name') }}</th>
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
                    {{-- <h5 class="modal-title"></h5> --}}
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
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
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <!-- Modal body -->
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
            ajax: '{{ route('admin-scheme-datatables') }}',
            columns: [
				{
                    data: 'name',
                    name: 'scheme_name'
                },
                // {
                //     data: 'state',
                //     searchable: true,
                //     orderable: false
                // },
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
                '<a class="add-btn" data-href="{{ route('admin-scheme-create') }}" id="add-data" data-toggle="modal" data-target="#modal1">' +
                '<i class="fas fa-plus"></i> Add New Scheme' +
                '</a>' +
                '</div>');
        });
    </script>
@endsection
