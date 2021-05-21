@if ( has_post_thumbnail() )
@php
	$featured_image = get_the_post_thumbnail_url( get_the_ID() );
@endphp
@else
@php
	$featured_image = App\asset_path('images/general-jumbotron.jpg');
@endphp
@endif

@if ('omrade_hall' == get_post_type() && get_post_meta(get_the_ID(), 'hall_sida', true))
	@if (get_post_meta(get_the_ID(), 'facebook', true) || get_post_meta(get_the_ID(), 'instagram', true))
	<div class="container pt-4 pb-4">
		<div class="row text-center">	
			<div class="col">
				@if (get_post_meta(get_the_ID(), 'facebook', true))
					<a href="{!! get_post_meta(get_the_ID(), 'facebook', true) !!}" target="_blank" class="pe-4"><img src="@asset('images/icons/facebook.png')" class="w-65" alt="Facebook" /></a>
				@endif
				@if (get_post_meta(get_the_ID(), 'instagram', true))
					<a href="{!! get_post_meta(get_the_ID(), 'instagram', true) !!}" target="_blank" class="ps-4"><img src="@asset('images/icons/instagram.png')" class="w-65" alt="Instagram" /></a>
				@endif
			</div>
		</div>
	</div>
	@endif
@endif

@if (('omrade_hall' == get_post_type() && get_post_meta(get_the_ID(), 'hall_sida', true)) || is_front_page())
<div class="jumbotron d-flex align-items-center" style="box-shadow: inset 0 0 0 1000px rgba(0,0,0,.6); background-image:url('{!! $featured_image !!}'); background-size: cover; background-repeat: no-repeat; background-position: top center;">
	<div class="container justify-content-center text-white pt-4 pb-4">
		<div class="row text-center pb-4 d-flex justify-content-center">
			<div class="col-12 pb-4 w-85">
			@if ('omrade_hall' == get_post_type() && get_post_meta(get_the_ID(), 'hall_sida', true))
				{!! get_post_meta(get_the_ID(), 'above_footer', true) !!}
				<a href="{!! get_post_meta(get_the_ID(), 'matchi_link', true) !!}" target="_blank" class="btn btn-primary btn-lg btn-huge">BOKA BANA NU</a>
			@elseif( is_front_page() )
				<h2 class="fw-bold">{!! get_theme_mod('above_footer_title') !!}</h2>
				<p class="pb-4">{!! get_theme_mod('above_footer_text') !!}</p>
				<a href="{!! get_theme_mod('medlemskaps_link') !!}" class="btn btn-huge btn-primary">BLI MEDLEM NU</a>
			@endif
			</div>
		</div>
	</div>
</div>
@endif
<footer class="content-info text-white pt-4 pb-4">
	<div class="container pb-4 pt-4">
		<div class="row pt-4 pb-4">
			<nav class="nav-footer col-md-4 mb-4 mb-md-0">
				<h3>Våra Hallar</h3>
				@if (has_nav_menu('footer_navigation'))
					{!! wp_nav_menu(['theme_location' => 'footer_navigation', 'menu_class' => 'nav flex-column']) !!}
        		@endif
			</nav>
			<div class="col-md-3 mt-2 mt-md-0 mb-4 mb-md-0">
				<h3>Länkar</h3>
				<div class="row">
					@if (has_nav_menu('footer_second_navigation'))
						{!! wp_nav_menu(['theme_location' => 'footer_second_navigation', 'menu_class' => 'nav flex-column']) !!}
					@endif
					
					
				</div>
			</div>
			<div class="col-md-5 mb-4 mb-md-0">
				<div class="row">
					<div class="col-3">
						<img class="img-fluid" src="@asset('images/footer-logo.png')" alt="Padel United Footer Logga" />
					</div>
					<div class="col-9">
						<p>Padel-tennis Stockholm AB<br />
						Västeråsgatan 5<br />
						113 43 Stockholm<br />
						Org. Nr. 559151-9417<br />
						Tel: 0763-64 63 75
						<p>&copy; {{ date('Y') }} Padel United AB</p>
					</div>
				</div>
			</div>
		</div>
	</div>                        
</footer>