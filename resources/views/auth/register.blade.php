@extends('layouts.app')

@section('content')
{{-- <div
    class="p-5 text-center bg-image"
    style="
        margin-top: -5px;
        background-image: url('{{ asset('website/banner/our-story.jpg') }}');
        height: 350px;
    "
>
    <div class="mask" style="background-color: rgba(0, 0, 0, 0.6);">
        <div class="d-flex justify-content-center align-items-center h-100">
            <div class="text-white">
                <h1 class="mb-3">Discover the latest updates and news</h1>
                <h5 class="mb-3">Stay informed, stay ahead.</h5>
            </div>
        </div>
    </div>
</div> --}}
<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h2 class="heading">&nbsp;Register</h2>
            <form action="patient-registration" method="POST">
                @csrf
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-outline mb-4">
                            <input type="text" name="first_name" value="{{ old('first_name') }}" id="inputFirstName" class="form-control @error('first_name') is-invalid @enderror" required/>
                            <label class="form-label" for="inputFirstName">First Name <strong class="text-danger">*</strong></label>
                            @error('first_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-outline mb-4">
                            <input type="text" name="last_name" value="{{ old('last_name') }}" id="inputLastName" class="form-control @error('last_name') is-invalid @enderror" required/>
                            <label class="form-label" for="inputLastName">Last Name <strong class="text-danger">*</strong></label>
                            @error('first_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input @error('sex') is-invalid @enderror" type="radio" name="sex" id="radioSexMale" value="male" @if(old('sex') == 'male') checked @endif required/>
                            <label class="form-check-label" for="radioSexMale">Male</label>
                            @error('sex')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input @error('sex') is-invalid @enderror" type="radio" name="sex" id="radioSexFemale" value="remale" @if(old('sex') == 'remale') checked @endif required/>
                            <label class="form-check-label" for="radioSexFemale">Female</label>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-outline mb-4">
                            <input type="date" name="birthdate" value="{{ old('birthdate') }}" id="inputBirthdate" class="form-control @error('birthdate') is-invalid @enderror" max="{{ date('Y-m-d') }}" required/>
                            <label class="form-label" for="inputBirthdate">Birthdate <strong class="text-danger">*</strong></label>
                            @error('birthdate')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-outline mb-4">
                            <input type="text" name="contact_number" value="{{ old('contact_number') }}" id="inputContactNumber" class="form-control @error('contact_number') is-invalid @enderror" required/>
                            <label class="form-label" for="inputContactNumber">Contact # <strong class="text-danger">*</strong></label>
                            @error('contact_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-6 mb-4">
                        <div class="form-outline">
                            <input type="text" name="occupation" value="{{ old('occupation') }}" id="inputOccupation" class="form-control @error('occupation') is-invalid @enderror" required/>
                            <label class="form-label" for="inputOccupation">Occupation <strong class="text-danger">*</strong></label>
                            @error('occupation')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="form-outline mb-4">
                    <textarea class="form-control @error('address') is-invalid @enderror" name="address" id="textareaAddress" rows="4" required>{{ old('address') }}</textarea>
                    <label class="form-label" for="textareaAddress">Address</label>
                    @error('address')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-outline mb-4">
                    <input type="email" name="email" value="{{ old('email') }}" id="inputEmail" class="form-control @error('email') is-invalid @enderror"/>
                    <label class="form-label" for="inputEmail">Email</label>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="row mb-4">
                    <div class="col-sm-6">
                        <div class="form-outline mb-4">
                            <input type="password" name="password" id="inputPassword" class="form-control @error('password') is-invalid @enderror" required/>
                            <label class="form-label" for="inputPassword">Password <strong class="text-danger">*</strong></label>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-outline">
                            <input type="password" name="password_confirmation" id="inputPasswordConfirmation" class="form-control @error('password_confirmation') is-invalid @enderror" required/>
                            <label class="form-label" for="inputPasswordConfirmation">Confirm Password <strong class="text-danger">*</strong></label>
                            @error('password_confirmation')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-1 mx-0">
                        <input class="form-check-input me-2" type="checkbox" value="confirm" id="checkboxConfirmRegistration" required/>
                    </div>
                    <div class="col-10 mx-0">
                        <label class="form-check-label" for="checkboxConfirmRegistration">
                            I confirm that I have completed the registration and have read all the information provided above.
                        </label>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>
@endsection