@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.css">
<link rel="stylesheet" href="{{ asset('css/animate.css') }}">
<!-- Portfolio-Section -->
    <section class="mystories-page">
        <div class="container">
            <h2>My Stories</h2>
            <div class="row justify-content-center">
                <div class="col-md-12 col-12">
                    <div class="row">
                        <a href="https://unsplash.it/1200/768.jpg?image=251" data-toggle="lightbox" data-gallery="example-gallery" class="col-xl-6 col-md-4 box-1">
                          <img src="https://unsplash.it/600.jpg?image=251" class="img-fluid">
                            <div class="overlay">
                             <img src="{{ asset('images/comment.png') }}" alt="plus-icon">
                              <div class="text">Man standing on the middle of the road in the morning <span>Landscapes</span></div>
                              <div class="count">45</div>
                            </div>
                        </a>
                        <a href="https://unsplash.it/1200/768.jpg?image=252" data-toggle="lightbox" data-gallery="example-gallery" class="col-xl-3 col-md-4 box-2">
                         <img src="https://unsplash.it/600.jpg?image=252" class="img-fluid">
                           <div class="overlay">
                            <img src="{{ asset('images/comment.png') }}" alt="plus-icon">
                             <div class="text">Man standing on the middle of the road in the morning <span>Landscapes</span></div>
                              <div class="count">45</div>
                           </div>
                        </a>
                        <a href="https://unsplash.it/1200/768.jpg?image=253" data-toggle="lightbox" data-gallery="example-gallery" class="col-xl-3 col-md-4 box-2">
                         <img src="https://unsplash.it/600.jpg?image=253" class="img-fluid">
                           <div class="overlay">
                            <img src="{{ asset('images/comment.png') }}" alt="plus-icon">
                             <div class="text">Man standing on the middle of the road in the morning <span>Landscapes</span></div>
                             <div class="count">45</div>
                           </div>
                        </a>
                    </div>
                    <div class="row">
                        <a href="https://unsplash.it/1200/768.jpg?image=254" data-toggle="lightbox" data-gallery="example-gallery" class="col-xl-3 col-md-4 box-2">
                          <img src="https://unsplash.it/600.jpg?image=254" class="img-fluid">
                            <div class="overlay">
                             <img src="{{ asset('images/comment.png') }}" alt="plus-icon">
                              <div class="text">Man standing on the middle of the road in the morning <span>Landscapes</span></div>
                              <div class="count">45</div>
                            </div>
                        </a>
                        <a href="https://unsplash.it/1200/768.jpg?image=255" data-toggle="lightbox" data-gallery="example-gallery" class="col-xl-3 col-md-4 box-2">
                         <img src="https://unsplash.it/600.jpg?image=255" class="img-fluid">
                           <div class="overlay">
                            <img src="{{ asset('images/comment.png') }}" alt="plus-icon">
                             <div class="text">Man standing on the middle of the road in the morning <span>Landscapes</span></div>
                              <div class="count">45</div>
                           </div>
                        </a>
                        <a href="https://unsplash.it/1200/768.jpg?image=256" data-toggle="lightbox" data-gallery="example-gallery" class="col-xl-6 col-md-4 box-1">
                         <img src="https://unsplash.it/600.jpg?image=256" class="img-fluid">
                           <div class="overlay">
                            <img src="{{ asset('images/comment.png') }}" alt="plus-icon">
                             <div class="text">Man standing on the middle of the road in the morning <span>Landscapes</span></div>
                             <div class="count">45</div>
                           </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="row bt">
                <div class="col-sm-12">
                    <ul>
                        <li><a class="active" href="#">1</a></li>
                        <li><a href="#">2</a></li>
                        <li><a href="#">3</a></li>
                        <li><a href="#">4</a></li>
                        <li><a href="#">5</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!--/.Portfolio-Section -->
    <!-- Footer -->
    <footer>
        <section class="footer-top">
            <!--Container-->
            <div class="container">
                <h2>My Flickr Feed</h2>
                <div class="row text-center text-lg-left">
                    <div class="col-lg-2 col-md-4 col-xs-6">
                        <a href="#" class="d-block h-100"><img class="img-fluid img-thumbnail" src="{{ asset('images/banner-image-1.jpg') }}" alt=""></a>
                    </div>
                    <div class="col-lg-2 col-md-4 col-xs-6">
                        <a href="#" class="d-block h-100"><img class="img-fluid img-thumbnail" src="{{ asset('images/banner-image-2.jpg') }}" alt=""></a>
                    </div>
                    <div class="col-lg-2 col-md-4 col-xs-6">
                        <a href="#" class="d-block h-100"><img class="img-fluid img-thumbnail" src="{{ asset('images/banner-image-3.jpg') }}" alt=""></a>
                    </div>
                    <div class="col-lg-2 col-md-4 col-xs-6">
                        <a href="#" class="d-block h-100"><img class="img-fluid img-thumbnail" src="{{ asset('images/banner-image-4.jpg') }}" alt=""></a>
                    </div>
                    <div class="col-lg-2 col-md-4 col-xs-6">
                        <a href="#" class="d-block h-100"><img class="img-fluid img-thumbnail" src="{{ asset('images/banner-image-2.jpg') }}" alt=""></a>
                    </div>
                    <div class="col-lg-2 col-md-4 col-xs-6">
                        <a href="#" class="d-block h-100"><img class="img-fluid img-thumbnail" src="{{ asset('images/banner-image-1.jpg') }}" alt=""></a>
                    </div>
                </div>
            </div>
            <!-- /.container -->
        </section>
        <section class="footer-bottom">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <ul>
                            <li><a href="{{ url('/') }}">Home</a></li>
                            <li class="hidden">/</li>
                            <li><a href="{{ url('/about') }}">About-us</a></li>
                            <li class="hidden">/</li>
                            <li><a href="{{ url('/mystories') }}">My stories</a></li>
                            <li class="hidden">/</li>
                            <li><a href="{{ url('/gallery') }}">Gallery</a></li>
                            <li class="hidden">/</li>
                            <li><a href="{{ url('/contact') }}">Contact</a></li>
                        </ul>
                    </div>
                    <div class="col-md-12">
                        <p>(C) All Rights Reserved <a href="https://www.template.net/editable/websites/html5" target="_blank">ClickaHolic</a> <span>/</span> Designed and Developed by <a href="https://www.template.net/editable/websites/html5" target="_blank">Template.net</a></p>
                    </div>
                </div>
            </div>
            <!-- /.container -->
        </section>
    </footer>
    <!-- /.Footer -->
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/ekko-lightbox/5.3.0/ekko-lightbox.js"></script>
<script src="{{ asset('js/animate.js') }}"></script>
<script src="{{ asset('js/custom.js') }}"></script>
<script>
    $(document).on('click', '[data-toggle="lightbox"]', function(event) {
        event.preventDefault();
        $(this).ekkoLightbox();
    });
</script>
@endsection