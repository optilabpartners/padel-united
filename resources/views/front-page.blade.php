@php
	//Get the contents of the FAQ page
 	$your_query = new WP_Query( 'pagename=faq' ); 
@endphp

@extends('layouts.app')

@section('content')
	@include('partials.page-header')
	@php
		the_content()
	@endphp
	<hr />
    @php
      while ( $your_query->have_posts() ) : $your_query->the_post();
	the_content();
      endwhile;
      wp_reset_postdata();
    @endphp
@endsection
