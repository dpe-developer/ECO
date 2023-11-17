@extends('layouts.app')

@section('style')
<style>
    .row.grid > .grid-item{
        padding: 3px !important;
        margin: 0px !important;
    }
</style>
@endsection

@section('content')
<div
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
                <h1 class="mb-3">Gallery</h1>
                <h5 class="mb-3">Explore our gallery.</h5>
            </div>
        </div>
    </div>
</div>
<div class="container mt-5 mb-5">
    <div class="row grid">
        <div class="col-md-3 grid-item">
            <div class="bg-image hover-overlay ripple">
                <img src="{{ asset('File Attachments/Gallery/gallery- (1).jpg') }}" class="img-fluid" />
                <a href="#!">
                  <div class="mask" style="background-color: rgba(57, 192, 237, 0.2);"></div>
                </a>
            </div>
        </div>
        <div class="col-md-3 grid-item">
            <div class="bg-image hover-overlay ripple">
                <img src="{{ asset('File Attachments/Gallery/gallery- (2).jpg') }}" class="img-fluid" />
                <a href="#!">
                  <div class="mask" style="background-color: rgba(57, 192, 237, 0.2);"></div>
                </a>
            </div>
        </div>
        <div class="col-md-3 grid-item">
            <div class="bg-image hover-overlay ripple">
                <img src="{{ asset('File Attachments/Gallery/gallery- (3).jpg') }}" class="img-fluid" />
                <a href="#!">
                  <div class="mask" style="background-color: rgba(57, 192, 237, 0.2);"></div>
                </a>
            </div>
        </div>
        <div class="col-md-3 grid-item">
            <div class="bg-image hover-overlay ripple">
                <img src="{{ asset('File Attachments/Gallery/gallery- (4).jpg') }}" class="img-fluid" />
                <a href="#!">
                  <div class="mask" style="background-color: rgba(57, 192, 237, 0.2);"></div>
                </a>
            </div>
        </div>
        <div class="col-md-3 grid-item">
            <div class="bg-image hover-overlay ripple">
                <img src="{{ asset('File Attachments/Gallery/gallery- (5).jpg') }}" class="img-fluid" />
                <a href="#!">
                  <div class="mask" style="background-color: rgba(57, 192, 237, 0.2);"></div>
                </a>
            </div>
        </div>
        <div class="col-md-3 grid-item">
            <div class="bg-image hover-overlay ripple">
                <img src="{{ asset('File Attachments/Gallery/gallery- (6).jpg') }}" class="img-fluid" />
                <a href="#!">
                  <div class="mask" style="background-color: rgba(57, 192, 237, 0.2);"></div>
                </a>
            </div>
        </div>
        <div class="col-md-3 grid-item">
            <div class="bg-image hover-overlay ripple">
                <img src="{{ asset('File Attachments/Gallery/gallery- (7).jpg') }}" class="img-fluid" />
                <a href="#!">
                  <div class="mask" style="background-color: rgba(57, 192, 237, 0.2);"></div>
                </a>
            </div>
        </div>
        <div class="col-md-3 grid-item">
            <div class="bg-image hover-overlay ripple">
                <img src="{{ asset('File Attachments/Gallery/gallery- (8).jpg') }}" class="img-fluid" />
                <a href="#!">
                  <div class="mask" style="background-color: rgba(57, 192, 237, 0.2);"></div>
                </a>
            </div>
        </div>
        <div class="col-md-3 grid-item">
            <div class="bg-image hover-overlay ripple">
                <img src="{{ asset('File Attachments/Gallery/gallery- (9).jpg') }}" class="img-fluid" />
                <a href="#!">
                  <div class="mask" style="background-color: rgba(57, 192, 237, 0.2);"></div>
                </a>
            </div>
        </div>
        <div class="col-md-3 grid-item">
            <div class="bg-image hover-overlay ripple">
                <img src="{{ asset('File Attachments/Gallery/gallery- (10).jpg') }}" class="img-fluid" />
                <a href="#!">
                  <div class="mask" style="background-color: rgba(57, 192, 237, 0.2);"></div>
                </a>
            </div>
        </div>
        <div class="col-md-3 grid-item">
            <div class="bg-image hover-overlay ripple">
                <img src="{{ asset('File Attachments/Gallery/gallery- (11).jpg') }}" class="img-fluid" />
                <a href="#!">
                  <div class="mask" style="background-color: rgba(57, 192, 237, 0.2);"></div>
                </a>
            </div>
        </div>
        <div class="col-md-3 grid-item">
            <div class="bg-image hover-overlay ripple">
                <img src="{{ asset('File Attachments/Gallery/gallery- (12).jpg') }}" class="img-fluid" />
                <a href="#!">
                  <div class="mask" style="background-color: rgba(57, 192, 237, 0.2);"></div>
                </a>
            </div>
        </div>
        <div class="col-md-3 grid-item">
            <div class="bg-image hover-overlay ripple">
                <img src="{{ asset('File Attachments/Gallery/gallery- (13).jpg') }}" class="img-fluid" />
                <a href="#!">
                  <div class="mask" style="background-color: rgba(57, 192, 237, 0.2);"></div>
                </a>
            </div>
        </div>
        <div class="col-md-3 grid-item">
            <div class="bg-image hover-overlay ripple">
                <img src="{{ asset('File Attachments/Gallery/gallery- (14).jpg') }}" class="img-fluid" />
                <a href="#!">
                  <div class="mask" style="background-color: rgba(57, 192, 237, 0.2);"></div>
                </a>
            </div>
        </div>
        <div class="col-md-3 grid-item">
            <div class="bg-image hover-overlay ripple">
                <img src="{{ asset('File Attachments/Gallery/gallery- (15).jpg') }}" class="img-fluid" />
                <a href="#!">
                  <div class="mask" style="background-color: rgba(57, 192, 237, 0.2);"></div>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script type="application/javascript" src="{{ asset('plugins/masonry.pkgd.min.js') }}"></script>
<script type="application/javascript">
    $(window).on('load', function(){
        $('.grid').masonry({
            itemSelector: '.grid-item',
            // columnWidth: 400,
            // gutter: 20,
        });
    })
</script>
@endsection