@extends('layouts.front.app') 
 
@section('og')  
    <meta property="og:type" content="404"/>
    <meta property="og:title" content=">Service Unavailable"/>
    <meta property="og:description" content=">Service Unavailable"/>
    
@endsection 

@section('content')
    <div class="page-error-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="page-error-top">
                        <span>404</span>
                        <p>Sorry Page Was Not Found</p>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="page-error-bottom">
                        <p>The page you are looking is not available or has been removed.</p>
                        <p>Try going to Home Page by using the button below.</p>
                        <a href="{{ route('home') }}" class="btn btn-error">Go To Home Page</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection