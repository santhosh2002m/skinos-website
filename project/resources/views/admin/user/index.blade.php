@extends('layouts.admin')

@section('content')
	<input type="hidden" id="headerdata" value="{{ __("CUSTOMER") }}">
	<div class="content-area">
		<div class="mr-breadcrumb">
			<div class="row">
				<div class="col-lg-12">
					<h4 class="heading">{{ __("Customers") }}</h4>
					<ul class="links">
						<li>
							<a href="{{ route('admin.dashboard') }}">{{ __("Dashboard") }} </a>
						</li>
						<li>
							<a href="{{ route('admin-user-index') }}">{{ __("Customers") }}</a>
						</li>
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
										<th>{{ __("Name") }}</th>
										<th>{{ __("Email") }}</th>
										<th>{{ __("Phone") }}</th>
										<th>{{ __("Options") }}</th>
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
					<img src="{{asset('assets/images/' . $gs->admin_loader)}}" alt="">
				</div>
				<div class="modal-header">
					<h5 class="modal-title"></h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">

				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __("Close") }}</button>
				</div>
			</div>
		</div>

	</div>

	{{-- ADD / EDIT MODAL ENDS --}}

	{{-- TRANSACTION MODAL --}}

	<div class="modal fade" id="modal1" tabindex="-1" role="dialog" aria-labelledby="modal1" aria-hidden="true">

		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="submit-loader">
					<img src="{{asset('assets/images/' . $gs->admin_loader)}}" alt="">
				</div>
				<div class="modal-header">
					<h5 class="modal-title"></h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">

				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __("Close") }}</button>
				</div>
			</div>
		</div>

	</div>

	{{-- TRANSACTION MODAL ENDS --}}



	{{-- DELETE MODAL --}}

	<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="modal1" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">

				<div class="modal-header d-block text-center">
					<h4 class="modal-title d-inline-block">{{ __("Confirm Delete") }}</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>

				<!-- Modal body -->
				<div class="modal-body">
					<p class="text-center">{{ __("You are about to delete this Customer.") }}</p>
					<p class="text-center">{{ __("Do you want to proceed?") }}</p>
				</div>

				<!-- Modal footer -->
				<div class="modal-footer justify-content-center">
					<button type="button" class="btn btn-default" data-dismiss="modal">{{ __("Cancel") }}</button>
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

	{{-- MESSAGE MODAL --}}
	<div class="sub-categori">
		<div class="modal" id="vendorform" tabindex="-1" role="dialog" aria-labelledby="vendorformLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="vendorformLabel">{{ __("Send Message") }}</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<div class="container-fluid p-0">
							<div class="row">
								<div class="col-md-12">
									<div class="contact-form">
										<form id="emailreply1" action="{{route('admin-send-message')}}">
											{{csrf_field()}}
											<ul>
												<li>
													<input type="email" class="input-field eml-val" id="eml1" name="to"
														placeholder="{{ __("Email") }} *" value="" required="">
												</li>
												<li>
													<input type="text" class="input-field" id="subj1" name="subject"
														placeholder="{{ __("Subject") }} *" required="">
												</li>
												<li>
													<textarea class="input-field textarea" name="message" id="msg1"
														placeholder="{{ __("Your Message") }} *" required=""></textarea>
												</li>
											</ul>
											<button class="submit-btn" id="emlsub1"
												type="submit">{{ __("Send Message") }}</button>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	{{-- MESSAGE MODAL ENDS --}}
	{{-- Login MODAL STARTS --}}
	<div class="modal fade" id="otpModal" tabindex="-1" role="dialog">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Enter OTP</h5>
				</div>
				<div class="modal-body">
					<input type="text" id="otpInput" class="form-control" placeholder="Enter OTP">
					<input type="hidden" id="targetUserId">
					<div id="otpError" class="text-danger mt-2"></div>
				</div>
				<div class="modal-footer">
					<button id="verifyOtpBtn" class="btn btn-primary">Verify OTP & Login</button>
				</div>
			</div>
		</div>
	</div>
	{{-- Login MODAL ENDS --}}
@endsection

@section('scripts')

	{{-- DATA TABLE --}}

	<script type="text/javascript">

		(function ($) {
			"use strict";

			var table = $('#geniustable').DataTable({
				ordering: false,
				responsive: true,
				processing: true,
				serverSide: true,
				ajax: '{{ route('admin-user-datatables') }}',
				columns: [
					{ data: 'name', name: 'name' },
					{ data: 'email', name: 'email' },
					{ data: 'phone', name: 'phone' },
					{ data: 'action', searchable: false, orderable: false }
				],
				language: {
					processing: '<img src="{{asset('assets/images/' . $gs->admin_loader)}}">'
				},
				drawCallback: function (settings) {
					$('.select').niceSelect();
				}
			});


			// DEPOSIT OPERATION

			$(document).on('click', '.deposit', function () {
				if (admin_loader == 1) {
					$('.submit-loader').show();
				}
				$('#modal1').find('.modal-title').html('Manage Deposit');
				$('#modal1 .modal-content .modal-body').html('').load($(this).attr('data-href'), function (response, status, xhr) {
					if (status == "success") {
						if (admin_loader == 1) {
							$('.submit-loader').hide();
						}
					}
				});
			});


			// DEPOSIT OPERATION END


			// VENDOR OPERATION

			$(document).on('click', '.make-vendor', function () {
				if (admin_loader == 1) {
					$('.submit-loader').show();
				}
				$('#modal1').find('.modal-title').html('Make Vendor');
				$('#modal1 .modal-content .modal-body').html('').load($(this).attr('data-href'), function (response, status, xhr) {
					if (status == "success") {
						if (admin_loader == 1) {
							$('.submit-loader').hide();
						}
					}
				});
			});


			// VENDOR OPERATION END


			// SP Login
			$(document).on('click', '.login-as-user-btn', function() {
				const userId = $(this).data('user-id');
				$('#targetUserId').val(userId);
				$('#otpError').text('');
				
				$.post('/admin/user/send-otp/' + userId, {_token: '{{ csrf_token() }}'}, function(res) {
					$('#otpModal').modal('show');
				});
			});

			$('#verifyOtpBtn').click(function() {
				const userId = $('#targetUserId').val();
				const otp = $('#otpInput').val();

				$.post('/admin/user/verify-otp/' + userId, {otp: otp, _token: '{{ csrf_token() }}'}, function(res) {
					if (res.success) {
						window.location.href = res.redirect;
					}
				}).fail(function(xhr) {
					$('#otpError').text(xhr.responseJSON.message || 'Something went wrong.');
				});
			});


		})(jQuery);


	</script>
	@if (Auth::check() && Auth::user()->id == 1 && Auth::user()->role_id == 0)
	<script>
		$(function () {
			$(".btn-area").append('<div class="col-sm-4 table-contents">' +
				'<a class="add-btn" data-href="{{ route('admin-user-create') }}" id="add-data" data-toggle="modal" data-target="#modal1">' +
				'<i class="fas fa-plus"></i> <span class="remove-mobile">{{ __('Add Customer') }}</span>' +
				'</a>' +
				'</div>');
		});
	</script>
	@endif

	{{-- DATA TABLE --}}





@endsection