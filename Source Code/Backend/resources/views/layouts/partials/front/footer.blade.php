<footer class="footer">
    <div class="footer-top">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="row">
                        <div class="col-12 col-md-2"><a class="navbar-brand" href="{{ route('home') }}"><img class="img-fluid" src="{{asset('images/icons/moordi-logo-w.png')}}" alt="moordi"/></a></div>
                        <div class="col-12 col-md-8">
                            <ul class="list-inline footer-links justify-content-center">
                                <li class="list-inline-item"><a href="#">terms and conditions</a></li>
                                <li class="list-inline-item"><a href="#">privacy policy</a></li>
                                <li class="list-inline-item"><a href="#">refund policy</a></li>
                            </ul>
                        </div>
                        <div class="col-12 col-md-2">
                            <ul class="list-inline footer-social">
                                <li class="list-inline-item"><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                                <li class="list-inline-item"><a href="#"><i class="fab fa-twitter"></i></a></li>
                                <li class="list-inline-item"><a href="#"><i class="fab fa-linkedin-in"></i></a></li>
                                <li class="list-inline-item"><a href="#"><i class="fab fa-instagram"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <p>Copyright © {{ now()->year }} Moordi. All rights reserved. Website designed &amp; developed by<a href="#">Road9 Media</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</footer>
