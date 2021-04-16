@if ( has_post_thumbnail() )
@php
	$featured_image = get_the_post_thumbnail_url( get_the_ID() );
@endphp
@else
@php
	$featured_image = App\asset_path('images/general-jumbotron.jpg');
@endphp
@endif
@if (('omrade_hall' == get_post_type()) || is_front_page())
<div class="jumbotron d-flex align-items-center" style="box-shadow: inset 0 0 0 1000px rgba(0,0,0,.6); background-image:url('{!! $featured_image !!}'); background-size: cover; background-repeat: no-repeat; background-position: top center;">
	<div class="container justify-content-center text-white pt-4 pb-4">
		<div class="row text-center">
			<div class="col-12">
			@if ('omrade_hall' == get_post_type() && get_post_meta(get_the_ID(), 'hall_sida', true))
			<h2>{!! get_theme_mod('above_hall_footer_title') !!}</h2>
				<p>{!! get_theme_mod('above_hall_footer_text') !!}</p>
				<a href="{!! get_post_meta(get_the_ID(), 'matchi_link', true) !!}" target="_blank" class="btn btn-primary btn-lg btn-huge">BOKA BANA NU</a>
			@elseif( is_front_page() )
				<h2>{!! get_theme_mod('above_footer_title') !!}</h2>
				<p>{!! get_theme_mod('above_footer_text') !!}</p>
				<button type="button" data-bs-toggle="collapse" data-bs-target="#showAllBanor" aria-expanded="false" aria-controls="showAllBanor" class="btn btn-primary btn-lg btn-huge">
					BOKA BANA NU
				</button>
				<div class="collapse" id="showAllBanor">
					<div class="card-body pt-0 mt-2">
						<ul class="list-group">
						@if($get_matchi_links)
							@while ($get_matchi_links->have_posts())
							@php $get_matchi_links->the_post() @endphp
							<li class="list-group-item list-group-item-action">
								<a href="{!! get_post_meta(get_the_ID(), 'matchi_link', true) !!}" target="_blank">{!! the_title() !!}</a>
							</li>
							@endwhile
						@endif
						</ul>	
					</div>
				</div>
			@endif
			</div>
		</div>
	</div>
</div>
@endif
<footer class="content-info text-white pt-4 pb-4">
	<div class="container">
		<div class="row">
			<nav class="nav-footer col-md-4 mb-4 mb-md-0">
				<h3 class="text-red"><strong>Våra Hallar</strong></h3>
				@if (has_nav_menu('footer_navigation'))
					{!! wp_nav_menu(['theme_location' => 'footer_navigation', 'menu_class' => 'nav flex-column']) !!}
        		@endif
			</nav>
			<div class="col-md-3 mt-2 mt-md-0 mb-4 mb-md-0">
				<h3><strong>Kontakt</strong></h3>
				<div class="row">
					<div class="col-2 col-md-3">
						<img src="@asset('images/icons/pin.png')" class="img-fluid" alt="Pin" />
					</div>
					<div class="col-10 col-md-9">
						<p>Padel United AB<br />
						Västeråsgatan 5<br />
						113 43 Stockholm
					</div>
				</div>
			</div>
			<div class="col-md-5 mb-4 mb-md-0">
				<div class="row">
					<div class="col-4">
						<img class="img-fluid" src="@asset('images/footer-logo.png')" alt="Padel United Footer Logga" />
					</div>
					<div class="col-8">
						@if (has_nav_menu('footer_second_navigation'))
							{!! wp_nav_menu(['theme_location' => 'footer_second_navigation', 'menu_class' => 'nav flex-column']) !!}
						@endif
						<br />
						<div>
							<p>&copy; {{ date('Y') }} Padel United AB</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>                        
</footer>