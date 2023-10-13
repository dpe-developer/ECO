<form id="companySettingsForm" action="{{ route('settings.edit_company') }}" method="POST" autocomplete="off" enctype="multipart/form-data">
	@csrf
	@method('PUT')
	<div class="row">
		<div class="col-md-8">
			<h3>Company Settings</h3>
		</div>
		<div class="col-md-4 text-right">
			<button type="button" class="btn btn-default text-info" data-toggle="modal" data-target="#companySettingsResetModal"><i class="fad fa-undo"></i> Reset</button>
			<button type="submit" class="btn btn-default text-success"><i class="fad fa-save"></i> Save</button>
		</div>
	</div>
	<hr>
	<div class="row register-company">
		<div class="col-md-4">
			<div class="form-group">
				<label>Company Logo:</label>
				<img id="img" width="100%" class="img-thumbnail" src="{{ isset($companySetting['company_logo']) ? asset($companySetting['company_logo']) : asset('images/laravel-3d-logo.png') }}" />
				<label class="btn btn-primary btn-block">
					Browse&hellip;<input type="file" name="company_logo" style="display: none;" id="upload" accept="image/*" />
				</label>
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				<label>Company Name: <strong class="text-danger"> *</strong></label>
				<input class="form-control form-control-sm" type="text" value="@if(old('company_name')){{ old('company_name') }}@else{{$companySetting['company_name']}}@endif" name="company_name" required>
			</div>
			<div class="form-group">
				<label>Company Slogan:</label>
				<input class="form-control form-control-sm" type="text" value="@if(old('company_slogan')){{ old('company_slogan') }}@else{{$companySetting['company_slogan']}}@endif" name="company_slogan">
			</div>
			<div class="form-group">
				<label>Website:</label>
				<input class="form-control form-control-sm" type="text" value="@if(old('company_website')){{ old('company_website') }}@else{{$companySetting['company_website']}}@endif" name="company_website">
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				<label>Telephone #: <strong class="text-danger"> *</strong></label>
				<input class="form-control form-control-sm" type="text" value="@if(old('company_telephone')){{ old('company_telephone') }}@else{{$companySetting['company_telephone']}}@endif" name="company_telephone" placeholder="Telephone #">
			</div>
			<div class="form-group">
				<label>Fax #: </label>
				<input class="form-control form-control-sm" type="text" value="@if(old('company_fax')){{ old('company_fax') }}@else{{$companySetting['company_fax']}}@endif" name="company_fax" placeholder="Fax #">
			</div>
			<div class="form-group">
				<label>Email: <strong class="text-danger"> *</strong></label>
				<input class="form-control form-control-sm" type="email" value="@if(old('company_email')){{ old('company_email') }}@else{{$companySetting['company_email']}}@endif" name="company_email" placeholder="Email">
			</div>
			<div class="form-group">
				<label>Address: <strong class="text-danger"> *</strong></label>
				<textarea class="form-control form-control-sm dp-address" id="company_complete_address" data-dp-address-title="Company Address" data-dp-address-input-name="company-address" data-dp-address-custom-id="company-address" rows="4" name="company_address">{{ old('company_address') }}</textarea>
				<input class="dp-address-sub-input" data-dp-address-input-name="company-address" type="hidden" name="address_1" value="{{ old('address_1') ? old('address_1') : $companySetting['company_address_1'] }}">
				<input class="dp-address-sub-input" data-dp-address-input-name="company-address" type="hidden" name="address_2" value="{{ old('address_2') ? old('address_2') : $companySetting['company_address_2'] }}">
				<input class="dp-address-sub-input" data-dp-address-input-name="company-address" type="hidden" name="city" value="{{ old('city') ? old('city') : $companySetting['company_city'] }}">
				<input class="dp-address-sub-input" data-dp-address-input-name="company-address" type="hidden" name="state" value="{{ old('state') ? old('state') : $companySetting['company_state'] }}">
				<input class="dp-address-sub-input" data-dp-address-input-name="company-address" type="hidden" name="country" value="{{ old('country') ? old('country') : $companySetting['company_country'] }}">
				<input class="dp-address-sub-input" data-dp-address-input-name="company-address" type="hidden" name="postal_code" value="{{ old('postal_code') ? old('postal_code') : $companySetting['company_postal_code'] }}">
				<input class="dp-address-sub-input" data-dp-address-input-name="company-address" type="hidden" name="address_type" value="{{ old('address_type') ? old('address_type') : $companySetting['company_address_type'] }}">
				<input class="dp-address-sub-input" data-dp-address-input-name="company-address" type="hidden" name="address_remarks" value="{{ old('address_remarks') ? old('address_remarks') : $companySetting['company_address_remarks'] }}">
			</div>
		</div>
		<div class="col-md-4">
			<div class="form-group">
				<label>About:</label>
				<textarea class="form-control form-control-sm" type="text" name="about" rows="5">@if(old('about')){{ old('about') }}@else{{$companySetting['company_about']}}@endif</textarea>
			</div>
		</div>
	</div>
</form>
<div class="modal fade" id="companySettingsResetModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-warning">@fa('fa fa-exclamation-triangle fa-lg') Alert</h4>
                <a href="javascript:void(0)" class="close" aria-hidden="true" data-dismiss="modal">&times;</a>
            </div>
            <div class="modal-body">
                <p class="text-left">
                    Are you sure do you want to <strong class="text-warning">RESET</strong> Company Settings to default?
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <a href="{{ route('settings.reset_company') }}" class="btn btn-primary">Yes</a>
            </div>
        </div>
    </div>
</div>