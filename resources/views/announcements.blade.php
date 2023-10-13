@extends('layouts.app')

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
                <h1 class="mb-3">Discover the latest updates and news</h1>
                <h5 class="mb-3">Stay informed, stay ahead.</h5>
                {{-- <a class="btn btn-outline-light btn-lg" href="#!" role="button">Call to action</a> --}}
            </div>
        </div>
    </div>
</div>
<div class="container mt-3">
    <h1 class="heading">&nbsp;&nbsp;Our Story</h1>
    <p class="lead" style="text-indent: 50px">
        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
        Porta nibh venenatis cras sed felis eget velit. Iaculis urna id volutpat lacus laoreet non curabitur gravida.
        Volutpat diam ut venenatis tellus in metus vulputate eu scelerisque. Massa ultricies mi quis hendrerit dolor magna eget.
    </p>
    <p class="lead" style="text-indent: 50px">
        Vel turpis nunc eget lorem dolor sed viverra ipsum nunc. Neque ornare aenean euismod elementum nisi quis eleifend quam.
        Quis auctor elit sed vulputate mi sit amet mauris commodo. Dignissim sodales ut eu sem integer vitae justo eget.
        Blandit turpis cursus in hac habitasse platea dictumst quisque sagittis. Netus et malesuada fames ac turpis egestas sed tempus urna.
        Arcu dui vivamus arcu felis bibendum ut tristique et. Feugiat vivamus at augue eget arcu dictum varius duis.
    </p>
    <p class="lead" style="text-indent: 50px">
        Lacus suspendisse faucibus interdum posuere lorem. Placerat orci nulla pellentesque dignissim enim sit amet venenatis urna.
        Amet luctus venenatis lectus magna fringilla urna porttitor. Dictum non consectetur a erat nam at. Urna porttitor rhoncus dolor purus non enim.
    </p>
</div>
@endsection