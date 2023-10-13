@extends('adminlte.app')
@section('content')
<div class="content-wrapper">
    <section class="content">
      <div class="error-page pt-5">
            <h2 class="headline text-warning"> 401</h2>
            <div class="error-content">
                <h3><i class="fas fa-exclamation-triangle text-warning"></i> Unauthorized</h3>
                <p>
                    {{ __($exception->getMessage() ?: 'Unauthorized') }}
                    {{-- Meanwhile, you may <a href="{{ route('home') }}">return to dashboard</a> --}}
                    Meanwhile, you may <a href="{{ url()->previous() }}">back to previous page.</a>
                </p>
            </div>
      </div>
    </section>
  </div>
@endsection
{{-- @section('title', __('Forbidden'))
@section('code', '403')
@section('message', __($exception->getMessage() ?: 'Forbidden')) --}}
