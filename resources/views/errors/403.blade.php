{{-- @extends('adminlte.app')
@section('content')
<div class="content-wrapper">
    <section class="content">
      <div class="error-page pt-5">
            <h2 class="headline text-danger"> 403</h2>
            <div class="error-content">
                <h3><i class="fas fa-exclamation-triangle text-danger"></i> Oops! Permission Denied.</h3>
                <p>
                    {{ __($exception->getMessage() ?: 'Forbidden') }}
                    Meanwhile, you may <a href="{{ url()->previous() }}">back to previous page.</a>
                </p>
            </div>
      </div>
    </section>
  </div>
@endsection --}}
@extends('errors::illustrated-layout')
@section('title', __('Forbidden'))
@section('code', '403')
@section('message', __($exception->getMessage() ?: 'Forbidden'))
