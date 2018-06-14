@if(!empty($blogs) && !collect($blogs)->isEmpty())

    @foreach($blogs as $blog) 

        @php 
            $months = [
                '-01-' => '-Enero-', 
                '-02-' => '-Febrero-', 
                '-03-' => '-Marzo-',
                '-04-' => '-Abril-', 
                '-05-' => '-Mayo-',
                '-06-' => '-Junio-',
                '-07-' => '-Julio-',
                '-08-' => '-Agosto-',
                '-09-' => '-Septiembre-',
                '-10-' => '-Octubre-',
                '-11-' => '-Noviembre-',
                '-12-' => '-Diciembre-'
            ];  
            
            $date_split = substr($blog->updated_at, 0, -9);
            $date = str_replace(array_keys($months), $months, $date_split);
            $date_array = explode("-", $date);
                
        @endphp
        
        <div
        @if($form_list == "grid")         
            class="col-lg-6 col-md-6 col-sm-6 col-xs-6"
        @endif
        > 

            
            @if($form_list == "grid")         
                <div class="blog-page-box">
                        <!-- ---------- La siguiente vista es la pag principal de Blogs ------------------ -->
                        <div class="blog-img-holder">
                            @if(isset($blog->cover))
                                <a href="{{ route('front.get.blog', str_slug($blog->slug)) }}">
                                    <img 
                                    src="{{ asset("storage/$blog->cover") }}"
                                    alt="{{ $blog->name_blog }}"
                                    height="273"
                                    width="422"
                                    class="img-responsive">
                                </a>

                            @else
                                <a href="{{ route('front.get.blog', str_slug($blog->slug)) }}">
                                    <img 
                                    src="https://placehold.it/263x330"
                                    alt="{{ $blog->name_blog }}"
                                    height="273"
                                    width="422"
                                    class="img-responsive">
                                </a>
                            @endif  
                        </div>
                        <div class="blog-content-holder">
                            <span>{{ $date_array[1] }} {{ $date_array[2] }}, {{ $date_array[0] }}</span>
                            <h3><a href="{{ route('front.get.blog', str_slug($blog->slug)) }}" >{{ $blog->name_blog }}</a></h3>
                            <ul>
                                <li><span>by</span> {{ $blog->name_creator }}</li>
                                <li>Comments (05)</li>
                            </ul>
                            {!! $blog->description_short !!}
                        </div>               

            @endif
            @if($form_list == "listCarousel") 
                
                <div class="blog-box">
                        <!-- ---------- La siguiente vista es para el index "Carrusel" ----------------------- -->
                        <a href="{{ route('front.get.blog', str_slug($blog->slug)) }}"><span><i class="fa fa-chevron-right" aria-hidden="true"></i></span></a>
                        <div class="blog-img-holder">
                            <div class="post-date">
                                <span>{{ $date_array[1] }} {{ $date_array[2] }}</span>
                            </div>

                            @if(isset($blog->cover))
                                <a href="{{ route('front.get.blog', str_slug($blog->slug)) }}">
                                    <img 
                                    src="{{ asset("storage/$blog->cover") }}"
                                    alt="{{ $blog->name_blog }}"
                                    height="219"
                                    width="373"                                    
                                    class="img-bordered img-responsive">
                                </a>

                            @else
                                <a href="{{ route('front.get.blog', str_slug($blog->slug)) }}">
                                    <img 
                                    src="https://placehold.it/263x330"
                                    alt="{{ $blog->name_blog }}"
                                    height="219"
                                    width="373"                                    
                                    class="img-bordered img-responsive">
                                </a>
                            @endif  
                            
                        </div>
                        <div class="blog-content-holder">
                            <h3><a href="{{ route('front.get.blog', str_slug($blog->slug)) }}" >{{ $blog->name_blog }}</a></h3>
                            <ul class="solid-underline">
                                <li><span>by</span> {{ $blog->name_creator }}</li>
                                <li>Comments (03)</li>
                            </ul>
                            {!! $blog->description_short !!}
                        </div>
            @endif

            @if($form_list == "column") 
                <div class="media">
                    @if(isset($blog->cover))
                        <a href="{{ route('front.get.blog', str_slug($blog->slug)) }}" class="pull-left">
                            <img 
                            src="{{ asset("storage/$blog->cover") }}"
                            alt="{{ $blog->name_blog }}"
                            height="107"
                            width="107"
                            class="img-responsive">
                        </a>

                    @else
                        <a href="{{ route('front.get.blog', str_slug($blog->slug)) }}" class="pull-left">
                            <img 
                            src="https://placehold.it/263x330"
                            alt="{{ $blog->name_blog }}"
                            height="107"
                            width="107"
                            class="img-responsive">
                        </a>
                    @endif



                    <div class="media-body">
                        <h3 class="media-heading"><a href="{{ route('front.get.blog', str_slug($blog->slug)) }}">{{ $blog->name_blog }}</a></h3>
                        <!-- dia mes, anio -->
                        <p>{{ $date_array[1] }} {{ $date_array[2] }}, {{ $date_array[0] }}</p>
                    </div>                 
            @endif

            </div>            
        </div>
    @endforeach
    @if($blogs instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator)
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="mypagination">{{ $blogs->links() }}</div>
            </div>
        </div>
        
        <!-- 
        <div class="row">
            <div class="col-md-12">
                <div class="pull-left">{ $blogs->links() }}</div>
            </div>
        </div>
        -->
    @endif
@else
    <p class="alert alert-warning">No blogs yet.</p>
@endif