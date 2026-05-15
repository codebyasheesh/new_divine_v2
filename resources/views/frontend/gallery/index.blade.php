@extends('frontend.layouts.app')

@section('content')
<section class="gallery-section">
    <div class="container">
        <!-- Gallery Grid -->
        <div class="gallery-grid">
            <img src="{{ asset('frontend_assets/images/gallery/gallery-1.webp') }}" alt="Gallery Image" title="">
            <img src="{{ asset('frontend_assets/images/gallery/gallery-2.webp') }}" alt="Gallery Image" title="">
            <img src="{{ asset('frontend_assets/images/gallery/gallery-3.webp') }}" alt="Gallery Image" title="">
            <img src="{{ asset('frontend_assets/images/gallery/gallery-4.webp') }}" alt="Gallery Image" title="">
            <img src="{{ asset('frontend_assets/images/gallery/gallery-5.webp') }}" alt="Gallery Image" title="">
            <img src="{{ asset('frontend_assets/images/gallery/gallery-6.webp') }}" alt="Gallery Image" title="">
            <img src="{{ asset('frontend_assets/images/gallery/gallery-7.webp') }}" alt="Gallery Image" title="">
        </div>

    </div>
</section>
<!-- Popup -->
<div class="gallery-popup" id="galleryPopup">
    <span class="close-popup">&times;</span>
    <img class="popup-img" src="" alt="">
</div>

@endsection