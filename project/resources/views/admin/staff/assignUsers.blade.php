@extends('layouts.load')

@section('styles')
	<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
	<style>
		.body-area th,
		.body-area td{
			padding: 0.5rem 1rem !important;
		}
	</style>
@endsection

@section('content')

	<div class="content-area">
		<div class="add-product-content1">
			<div class="row">
				<div class="col-lg-4">
					<div class="left-area">
						<h4 class="heading">{{ __("Assign HCP") }} *</h4>
					</div>
				</div>
				<div class="col-lg-12">
					<div class="product-description">
						<div class="body-area">
							@if(isset($data->users) && count($data->users) > 0)
								<table class="table table-bordered">
									<thead>
										<tr>
											{{-- <th>User ID</th> --}}
											<th>Name</th>
											<th>Email</th>
											<th>Phone</th>
											<th>Address</th>
										</tr>
									</thead>
									<tbody>
										@foreach ($data->users as $user)
											<tr>
												{{-- <td>{{ $user->id }}</td> --}}
												<td>{{ $user->name }}</td>
												<td>{{ $user->email }}</td>
												<td>{{ $user->phone }}</td>
												<td>{{ $user->address ?? 'N/A' }}</td>
											</tr>
										@endforeach
									</tbody>
								</table>
							@else
								<p>No users assigned to this staff yet.</p>
							@endif
							@include('alerts.admin.form-error')
							<form id="geniusformdata" action="{{ route('admin-assign-user-store', $data->id) }}" method="POST"
								enctype="multipart/form-data">
								{{csrf_field()}}

								<div class="col-12">
									<select name="user_ids[]" multiple class="input-field select2" required>
										@foreach($users as $user)
											<option value="{{ $user->id }}" {{ in_array($user->id, $selectedUserIds ?? []) ? 'selected' : '' }}>
												{{ $user->name }} ({{ $user->email }})
											</option>
										@endforeach
									</select>
									<small class="text-muted">Hold Ctrl (Cmd on Mac) to select multiple users</small>
								</div>

								<div class="row">
									<div class="col-lg-4">
										<div class="left-area">

										</div>
									</div>
									<div class="col-lg-7">
										<button class="addProductSubmit-btn" type="submit">{{ __("Save") }}</button>
									</div>
								</div>

							</form>


						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<script defer>
		$(document).ready(function() {
			$('.select2').select2({
				width: '100%',
				placeholder: 'Select Users'
			});
		});
	</script>

@endsection

@section('scripts')
	<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endsection