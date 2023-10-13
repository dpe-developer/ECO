<form method="POST" action="{{ route('users.update_profile', $user->username) }}" autocomplete="off" enctype="multipart/form-data">
	@csrf
	@method('PUT')
	<input type="hidden" name ="from_modal_ajax_href" value="{{ route('users.edit_profile', $user->username) }}">
	<input type="hidden" name ="modal_ajax_target" value="#editProfile">
		<div class="modal fade" id="editProfile" data-backdrop="static" data-keyboard="false" {{-- tabindex="-1" --}} role="dialog" aria-hidden="true">
			<div class="modal-dialog modal-dialog-scrollable modal-md" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Edit User</h5>
						<a href="javascript:void(0)" class="close" data-dismiss="modal-ajax">
							<span aria-hidden="true">&times;</span>
						</a>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="col">
								<div class="form-group">
									<label>Avatar:</label>
									<br>
									<i>File must be <b>jpeg, png, or jpg</b>. Required image dimention is <b>square.</b></i>
									<div class="row justify-content-center">
										<div class="col-md-8">
											<img id="img" width="100%" class="img-thumbnail" src="@isset($user->avatar->id) {{ asset($user->avatar->file_path.'/'.$user->avatar->file_name) }} @else {{ asset('images/avatar.png') }} @endisset" />
											<label class="btn btn-primary btn-block">
												Browse&hellip;<input value="" type="file" name="avatar" style="display: none;" id="upload" accept="image/*" />
											</label>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label for="email">{{ __('E-Mail Address') }}:</label>
									<input type="email" value="@if(old('email')){{ old('email') }}@else{{ $user->email }}@endif" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" disabled>
									<span class="invalid-feedback" role="alert">
										<strong>{{ $errors->first('email') }}</strong>
									</span>
								</div>
								<div class="form-group">
									<label for="username">Username:</label>
									<input id="username" value="@if(old('username')){{ old('username') }}@else{{ $user->username }}@endif" type="text" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" name="username" disabled>
									<span class="invalid-feedback" role="alert">
										<strong>{{ $errors->first('username') }}</strong>
									</span>
								</div>
								<div class="form-group">
									<label for="first_name">First Name:</label>
									<input id="first_name" value="@if(old('first_name')){{ old('first_name') }}@else{{ $user->first_name }}@endif" type="text" class="form-control{{ $errors->has('first_name') ? ' is-invalid' : '' }}" name="first_name" disabled>
									<span class="invalid-feedback" role="alert">
										<strong>{{ $errors->first('first_name') }}</strong>
									</span>
								</div>
								<div class="form-group">
									<label for="last_name">Last Name:</label>
									<input id="last_name" value="@if(old('last_name')){{ old('last_name') }}@else{{ $user->last_name }}@endif" type="text" class="form-control{{ $errors->has('last_name') ? ' is-invalid' : '' }}" name="last_name" disabled>
									<span class="invalid-feedback" role="alert">
										<strong>{{ $errors->first('last_name') }}</strong>
									</span>
								</div>
								<button class="btn btn-default btn-block text-primary" type="button" data-target="#changePassword" data-toggle="collapse" aria-expanded="false" aria-controls="changePassword"><i class="fa fa-lock"></i> Change Password</button>
								<div id="changePassword" class="callout callout-warning pt-2 pb-2 pr-5 pl-5 collapse">
									<div class="form-group">
										<label for="password">{{ __('Password') }}:</label>
										<input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password">
										<span class="invalid-feedback" role="alert">
											<strong>{{ $errors->first('password') }}</strong>
										</span>
									</div>
									<div class="form-group">
										<label for="password-confirm">{{ __('Confirm Password') }}:</label>
										<input id="password-confirm" type="password" class="form-control" name="password_confirmation">
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						@if(Auth::user()->id != $user->id)
						<div class="col">
							@if ($user->trashed())
								@can('users.restore')
								<a class="btn btn-default text-success" href="javascript:void(0)" onclick="restoreFromTable(this)" data-href="{{ route('users.restore', $user->id) }}"><i class="fad fa-download"></i> Restore</a>
								@endcan
							@else
								@can('users.destroy')
								<a class="btn btn-default text-danger" href="javascript:void(0)" onclick="deleteFromTable(this)" data-href="{{ route('users.destroy', $user->id) }}"><i class="fad fa-trash-alt"></i> Delete</a>
								@endcan
							@endif
						</div>
						@endif
						<div class="col text-right">
							<button class="btn btn-default" type="button" data-dismiss="modal-ajax">Cancel</button>
							<button type="submit" class="btn btn-default text-success btn-submit"><i class="fad fa-save"></i> Save</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>
	{{-- <div class="modal fade" id="cropperModal" tabindex="-1" data-backdrop="static" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="modalLabel">Cropper</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="img-container">
						<img id="cropperImage" src="" alt="Picture">
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div> --}}
	<script>
		/* $('#avatar').change(function(){
			var input = this;
			var url = $(this).val();
			var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
			if (input.files && input.files[0]&& (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg")) 
			{
				var reader = new FileReader();
				
				reader.onload = function (e) {
					$('#cropperImage').attr('src', e.target.result);
				}
				reader.readAsDataURL(input.files[0]);
			}
			$('#cropperModal').modal('show')
	
			// cropper script
			window.addEventListener('DOMContentLoaded', function () {
			var image = document.getElementById('cropperImage');
			var cropBoxData;
			var canvasData;
			var cropper;
	
			$('#cropperModal').on('shown.bs.modal', function () {
				cropper = new Cropper(image, {
				autoCropArea: 0.5,
				ready: function () {
					//Should set crop box data first here
					cropper.setCropBoxData(cropBoxData).setCanvasData(canvasData);
				}
				});
			}).on('hidden.bs.modal', function () {
				cropBoxData = cropper.getCropBoxData();
				canvasData = cropper.getCanvasData();
				cropper.destroy();
			});
			});
		}) */
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