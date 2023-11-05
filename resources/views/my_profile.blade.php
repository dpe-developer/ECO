@extends('layouts.app')

@section('content')
{{-- <div
    class="p-5 text-center bg-image"
    style="
        margin-top: -4px;
        background-image: url('{{ asset('website/banner/our-story.jpg') }}');
        height: 300px;
    "
>
    <div class="mask" style="background-color: rgba(0, 0, 0, 0.6);">
        <div class="d-flex justify-content-center align-items-center h-100">
            <div class="text-white">
                <h1 class="mb-3">My Profile</h1>
            </div>
        </div>
    </div>
</div> --}}
<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h1 class="heading">&nbsp;&nbsp;My Profile</h1>
            <form action="{{ route('update-my-profile', $user->username) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-text text-center">
                            Your profile photo must be a sqare image.
                            @error('avatar')
                            <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="row justify-content-center">
                            <div class="col-sm-8">
                                <img id="img" width="100%" class="img-thumbnail" src="@isset($user->avatar->id) {{ asset($user->avatar->file_path.'/'.$user->avatar->file_name) }} @else {{ asset('images/avatar.png') }} @endisset" />
                                <label class="btn btn-primary btn-block btn-sm">
                                    Browse&hellip;<input value="" type="file" name="avatar" style="display: none;" id="upload" accept="image/*" />
                                </label>
                                
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-outline mb-4">
                            <input type="text" name="first_name" value="{{ $user->first_name }}" id="inputFirstName" class="form-control @error('first_name') is-invalid @enderror" readonly/>
                            <label class="form-label" for="inputFirstName">First Name <strong class="text-danger">*</strong></label>
                            @error('first_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-outline mb-4">
                            <input type="text" name="last_name" value="{{ $user->last_name }}" id="inputLastName" class="form-control @error('last_name') is-invalid @enderror" readonly/>
                            <label class="form-label" for="inputLastName">Last Name <strong class="text-danger">*</strong></label>
                            @error('first_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input @error('sex') is-invalid @enderror" type="radio" name="sex" id="radioSexMale" value="male" @if($user->sex == 'male') checked @endif disabled/>
                            <label class="form-check-label" for="radioSexMale">Male</label>
                            @error('sex')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-check form-check-inline mb-4">
                            <input class="form-check-input @error('sex') is-invalid @enderror" type="radio" name="sex" id="radioSexFemale" value="remale" @if($user->sex == 'remale') checked @endif disabled/>
                            <label class="form-check-label" for="radioSexFemale">Female</label>
                        </div>
                        <div class="form-outline mb-4">
                            <input type="date" name="birthdate" value="{{ $user->birthdate }}" id="inputBirthdate" class="form-control @error('birthdate') is-invalid @enderror" max="{{ date('Y-m-d') }}" readonly/>
                            <label class="form-label" for="inputBirthdate">Birthdate <strong class="text-danger">*</strong></label>
                            @error('birthdate')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-outline mb-4">
                            <input type="text" name="contact_number" value="{{ old('contact_number', $user->contact_number) }}" id="inputContactNumber" class="form-control @error('contact_number') is-invalid @enderror" required/>
                            <label class="form-label" for="inputContactNumber">Contact # <strong class="text-danger">*</strong></label>
                            @error('contact_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-outline mb-4">
                            <input type="text" name="occupation" value="{{ old('occupation', $user->occupation) }}" id="inputOccupation" class="form-control @error('occupation') is-invalid @enderror" required/>
                            <label class="form-label" for="inputOccupation">Occupation <strong class="text-danger">*</strong></label>
                            @error('occupation')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="form-outline mb-4">
                    <textarea class="form-control @error('address') is-invalid @enderror" name="address" id="textareaAddress" rows="4" required>{{ old('address', $user->address) }}</textarea>
                    <label class="form-label" for="textareaAddress">Address</label>
                    @error('address')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-outline mb-4">
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" id="inputEmail" class="form-control @error('email') is-invalid @enderror"/>
                    <label class="form-label" for="inputEmail">Email</label>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="row mb-4">
                    <div class="col-sm-6">
                        <div class="form-outline">
                            <input type="password" name="password" id="inputPassword" class="form-control @error('password') is-invalid @enderror"/>
                            <label class="form-label" for="inputPassword">Password</label>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-text">
                            Leave the Password field blank if you don't want to change your password.
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-outline">
                            <input type="password" name="password_confirmation" id="inputPasswordConfirmation" class="form-control @error('password_confirmation') is-invalid @enderror"/>
                            <label class="form-label" for="inputPasswordConfirmation">Confirm Password </label>
                            @error('password_confirmation')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-success">Update Profile</button>
            </form>
        </div>
    </div>
</div>
@endsection
@section('scripts')
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
@endsection