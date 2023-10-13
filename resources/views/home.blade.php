@extends('layouts.app')

@section('content')
<div class="container-fluid">
  <!-- Carousel wrapper -->
<div id="carouselBasicExample" class="carousel slide carousel-fade" data-mdb-ride="carousel">
  <!-- Indicators -->
  <div class="carousel-indicators">
    <button
      type="button"
      data-mdb-target="#carouselBasicExample"
      data-mdb-slide-to="0"
      class="active"
      aria-current="true"
      aria-label="Slide 1"
    ></button>
    <button
      type="button"
      data-mdb-target="#carouselBasicExample"
      data-mdb-slide-to="1"
      aria-label="Slide 2"
    ></button>
    <button
      type="button"
      data-mdb-target="#carouselBasicExample"
      data-mdb-slide-to="2"
      aria-label="Slide 3"
    ></button>
  </div>

  <!-- Inner -->
  <div class="carousel-inner">
    <!-- Single item -->
    <div class="carousel-item active">
      <img src="{{ asset('website/carousel/carousel_1.jpg') }}" class="d-block w-100" alt="Sunset Over the City"/>
      <div class="carousel-caption d-none d-md-block">
        <h1 style="color: #fff212; text-shadow: 2px 2px 5px #0098da;">Your Vision is Our Priority</h1>
        <h5>See the World Clearly with Duzon Vision Clinic.</h5>
      </div>
    </div>

    <!-- Single item -->
    <div class="carousel-item">
      <img src="{{ asset('website/carousel/carousel_2.jpg') }}" class="d-block w-100" alt="Canyon at Nigh"/>
    </div>

    <!-- Single item -->
    <div class="carousel-item">
      <img src="{{ asset('website/carousel/carousel_3.jpg') }}" class="d-block w-100" alt="Cliff Above a Stormy Sea"/>
    </div>
  </div>
  <!-- Inner -->

  <!-- Controls -->
  <button class="carousel-control-prev" type="button" data-mdb-target="#carouselBasicExample" data-mdb-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-mdb-target="#carouselBasicExample" data-mdb-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>
<!-- Carousel wrapper -->
</div>
<div class="container">
    
</div>
@endsection
