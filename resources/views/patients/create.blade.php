<form action="{{ route('patients.store') }}" method="POST">
    @csrf
    <input type="hidden" name ="from_modal_ajax_href" value="{{ route('patients.create') }}">
    <input type="hidden" name ="modal_ajax_target" value="#createPatientModal">
    <div class="modal fade" id="createPatientModal" data-backdrop="static" data-keyboard="false" {{-- tabindex="-1" --}} role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Patient</h5>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form-label" for="inputFirstName">First Name <strong class="text-danger">*</strong></label>
                                <input type="text" name="first_name" value="{{ old('first_name') }}" id="inputFirstName" class="form-control @error('first_name') is-invalid @enderror" required/>
                                @error('first_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form-label" for="inputLastName">Last Name <strong class="text-danger">*</strong></label>
                                <input type="text" name="last_name" value="{{ old('last_name') }}" id="inputLastName" class="form-control @error('last_name') is-invalid @enderror" required/>
                                @error('first_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Sex <strong class="text-danger">*</strong></label>
                                <br>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input @error('sex') is-invalid @enderror" type="radio" name="sex" id="radioSexMale" value="male" @if(old('sex') == 'male') checked @endif required/>
                                    <label class="form-check-label" for="radioSexMale">Male</label>
                                    @error('sex')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input @error('sex') is-invalid @enderror" type="radio" name="sex" id="radioSexFemale" value="female" @if(old('sex') == 'female') checked @endif required/>
                                    <label class="form-check-label" for="radioSexFemale">Female</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form-label" for="inputBirthdate">Birthdate <strong class="text-danger">*</strong></label>
                                <input type="date" name="birthdate" value="{{ old(Carbon::parse(old('birthdate'))->format('Y-m-d'), '') }}" id="inputBirthdate" class="form-control @error('birthdate') is-invalid @enderror" max="{{ date('Y-m-d') }}" required/>
                                @error('birthdate')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form-label" for="inputContactNumber">Contact # <strong class="text-danger">*</strong></label>
                                <input type="text" name="contact_number" value="{{ old('contact_number') }}" id="inputContactNumber" class="form-control @error('contact_number') is-invalid @enderror" required/>
                                @error('contact_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form-label" for="inputOccupation">Occupation <strong class="text-danger">*</strong></label>
                                <input type="text" name="occupation" value="{{ old('occupation') }}" id="inputOccupation" class="form-control @error('occupation') is-invalid @enderror" required/>
                                @error('occupation')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="textareaAddress">Address <strong class="text-danger">*</strong></label>
                        <textarea class="form-control @error('address') is-invalid @enderror" name="address" id="textareaAddress" rows="4">{{ old('address') }}</textarea>
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="inputEmail">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" id="inputEmail" class="form-control @error('email') is-invalid @enderror"/>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-default" type="button" data-dismiss="modal">Cancel</button>
					<button type="submit" class="btn btn-default text-success btn-submit"><i class="fad fa-save"></i> Save</button>
                </div>
            </div>
        </div>
    </div>
</form>