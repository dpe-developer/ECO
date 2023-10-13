<form method="POST" action="{{ route('users.store') }}" autocomplete="off" enctype="multipart/form-data">
	@csrf
	<input type="hidden" name ="from_modal_ajax_href" value="{{ route('users.create') }}">
	<input type="hidden" name ="modal_ajax_target" value="#addUser">
		<div class="modal fade" id="addUser" data-backdrop="static" data-keyboard="false" {{-- tabindex="-1" --}} role="dialog" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered modal-md" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Add User</h5>
						<a href="javascript:void(0)" class="close" data-dismiss="modal-ajax">
							<span aria-hidden="true">&times;</span>
						</a>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="col">
								<div class="form-group">
									<label>Avatar:</label>
									<div class="row justify-content-center">
										<div class="col-md-6">
											<img id="img" width="100%" class="img-thumbnail" src="{{ asset('images/avatar.png') }}" />
											<label class="btn btn-primary btn-block">
												Browse&hellip;<input value="" type="file" name="avatar" style="display: none;" id="upload" accept="image/*" />
											</label>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label>Role:</label>
									<select class="form-control select2{{-- {{ $errors->has('role') ? ' is-invalid' : '' }} --}}" name="role" style="width: 100%">
										<option></option>
										@foreach ($roles as $role)
										<option value="{{ $role->id }}" @if(old('role') == $role->id){{'selected'}} @endif>{{ $role->name }}</option>
										@endforeach
									</select>
									<span class="invalid-feedback">
										<strong class="text-danger">{{ $errors->first('role') }}</strong>
									</span>
								</div>
								<div class="form-group">
									<label for="email">{{ __('E-Mail Address') }}:</label>
									<input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}">
									<span class="invalid-feedback" role="alert">
										<strong>{{ $errors->first('email') }}</strong>
									</span>
								</div>
								<div class="form-group">
									<label for="username">{{ __('Username') }}:</label>
									<input id="username" type="text" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" name="username" value="{{ old('username') }}">
									<span class="invalid-feedback" role="alert">
										<strong>{{ $errors->first('username') }}</strong>
									</span>
								</div>
								<div class="form-group">
									<label for="first_name">First Name:</label>
									<input id="first_name" type="text" class="form-control{{ $errors->has('first_name') ? ' is-invalid' : '' }}" name="first_name">
									<span class="invalid-feedback" role="alert">
										<strong>{{ $errors->first('first_name') }}</strong>
									</span>
								</div>
								<div class="form-group">
									<label for="last_name">Last Name:</label>
									<input id="last_name" type="text" class="form-control{{ $errors->has('last_name') ? ' is-invalid' : '' }}" name="last_name">
									<span class="invalid-feedback" role="alert">
										<strong>{{ $errors->first('last_name') }}</strong>
									</span>
								</div>
								<div class="form-group">
									<label for="password">{{ __('Password') }}:</label>
									<input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password">
									<span class="invalid-feedback" role="alert">
										<strong>{{ $errors->first('password') }}</strong>
									</span>
								</div>
								<div class="form-group">
									<label for="password-confirm">{{ __('Confirm Password') }}:</label>
									<input id="password-confirm" type="password" new-password class="form-control" name="password_confirmation">
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-default text-success"><i class="fad fa-save"></i> Save</button>
					</div>
				</div>
			</div>
		</div>
	</form>
	<script>
		$('#upload').change(function(){
			var input = this;
			var url = $(this).val();
			var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
			if (input.files && input.files[0]&& (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg")) 
			{
				var reader = new FileReader();
				
				reader.onload = function (e) {
					$('#img').attr('src', e.target.result);
				}
				reader.readAsDataURL(input.files[0]);
			}
		});
	</script>
	