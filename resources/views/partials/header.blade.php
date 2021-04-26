<header>
	<div id="ct-menu" class="container-fluid">
		<div class="container p-0">
    		<div class="row">
    			<div class="col-lg-3 p-0">
                  	@php
                      $custom_logo_id = get_theme_mod( 'custom_logo' );
                      $image = wp_get_attachment_image_src( $custom_logo_id , 'full' );
                  	@endphp
    				<nav class="navbar navbar-expand-lg navbar-dark">
              			<a href="/"><img class="logo ps-3" src="{!! $image[0] !!}" alt="Padel United Logo" /></a>
						<div class="d-lg-none nav-primary-responsive">
							<button class="btn btn-bars" aria-label="Menu Button"><span class="navbar-toggler-icon"></span></button>
							<a href="/"><img class="logo d-none logo-class" src="{!! $image[0] !!}" alt="Padel United Logo" /></a>
							{!! wp_nav_menu([
								'theme_location'  => 'primary_navigation',
								'menu_class'      => 'nav flex-column',
								'container_class' => 'nav-responsive',
								'depth'           => 2,
								'walker'          => new WP_Bootstrap_Navwalker()
							]) !!}
						</div>
            		</nav>
    			</div>
    			<div class="col-lg-9 d-none d-lg-block">
    				<div class="col-md-12 p-md-0 mt-3 mt-md-1">
                        <nav class="navbar nav-primary d-none d-lg-flex justify-content-end">
        					@if (has_nav_menu('primary_navigation'))
        						{!! wp_nav_menu([
        							'theme_location'  => 'primary_navigation',
        							'menu_class'      => 'navbar-nav',
        							'depth'           => 2,
        							'walker'          => new WP_Bootstrap_Navwalker()
        						]) !!}
        					@endif
        				</nav>
    				</div>
    			</div>
    		</div>
		</div>
	</div>
</header>
@if ( has_post_thumbnail() )
@php
	$featured_image = get_the_post_thumbnail_url( get_the_ID() );
@endphp
@else
@php
	$featured_image = App\asset_path('images/general-jumbotron.jpg');
@endphp
@endif

@php
$hallsida = get_post_meta(get_the_ID(), 'hall_sida', true);
echo($hallsida);
@endphp

@if ('omrade_hall' == get_post_type())
<div class="jumbotron-cover">
	<div class="jumbotron d-flex align-items-center min-vh-60" style="box-shadow: inset 0 0 0 1000px rgba(0,0,0,.6); background-image:url('{!! $featured_image !!}'); background-size: cover; background-repeat: no-repeat; background-position: top center;">
		<div class="container justify-content-center text-white jumbotron-text-box">
			<div class="row text-center">
				<div class="col-12">
					<h1>{!! App::title() !!}</h1>
					@if ($get_children_pages && $hallsida != 1)
						<button type="button" data-bs-toggle="collapse" data-bs-target="#showAllBanor" aria-expanded="false" aria-controls="showAllBanor" class="btn btn-primary btn-lg btn-huge">
							BOKA BANA NU
						</button>
						<div class="collapse" id="showAllBanor">
							<div class="card-body pt-0 mt-2">
								<ul class="list-group">
								@if($get_children_pages)
									@while ($get_children_pages->have_posts())
									@php $get_children_pages->the_post() @endphp
									<li class="list-group-item list-group-item-action">
										<a href="{!! get_post_meta(get_the_ID(), 'matchi_link', true) !!}" target="_blank">{!! the_title() !!}</a>
									</li>
									@endwhile
									@php wp_reset_postdata() @endphp
								@endif
								</ul>	
							</div>
						</div>
					@else
						<a href="{!! get_post_meta(get_the_ID(), 'matchi_link', true) !!}" target="_blank" class="btn btn-primary btn-lg btn-huge">BOKA BANA NU</a>
					@endif
					@if (get_post_meta(get_the_ID(), 'hall_sida', true))
						<div class="row mt-4">
							<div class="col-12">
								<p class="text-center">
									@if(get_post_meta(get_the_ID(), 'maps_link', true))
										<img src="@asset('images/icons/pin.png')" style="height: 40px;" class="me-2 h-40" alt="Pin" />
										<a class="h5 me-4 text-white text-decoration-none" href="{!! get_post_meta(get_the_ID(), 'maps_link', true) !!}" target="_blank">Hitta Hit </a>
									@endif
									@if(get_post_meta(get_the_ID(), 'telefon_nummer', true))
										<img src="@asset('images/icons/phone.png')" style="height: 40px;" class="me-2 h-40" alt="Phone" />
										<a class="h5 text-white  text-decoration-none" href="tel:{!! get_post_meta(get_the_ID(), 'telefon_nummer', true) !!}">Ring till oss</i></a>
									@endif
								</p>
							</div>						
						</div>
					@endif
				</div>
			</div>
		</div>
	</div>
</div>
@elseif( is_front_page() )
<div class="jumbotron-cover">
	<div class="jumbotron d-flex align-items-center min-vh-50" style="box-shadow: inset 0 0 0 1000px rgba(0,0,0,.6); background-image:url('{!! $featured_image !!}'); background-size: cover; background-repeat: no-repeat; background-position: center center;">
		<div class="container justify-content-center text-white jumbotron-text-box">
			<div class="row text-center">
				<div class="col-12">
					<h1>{!! App::title() !!}</h1>
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
								@php wp_reset_postdata() @endphp
							@endif
							</ul>	
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@else
<div class="jumbotron-cover">
	<div class="jumbotron d-flex align-items-center min-vh-50" style="box-shadow: inset 0 0 0 1000px rgba(0,0,0,.6); background-image:url('{!! $featured_image !!}'); background-size: cover; background-repeat: no-repeat; background-position: center center;">
		<div class="container justify-content-center text-white jumbotron-text-box">
			<div class="row text-center">
				<div class="col-12">
					<h1>{!! App::title() !!}</h1>
				</div>
			</div>
		</div>
	</div>
</div>
@endif