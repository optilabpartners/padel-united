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
@if ('omrade_hall' == get_post_type())
	<div class="jumbotron d-flex align-items-center min-vh-60" style="box-shadow: inset 0 0 0 1000px rgba(0,0,0,.6); background-image:url('{!! $featured_image !!}'); background-size: cover; background-repeat: no-repeat; background-position: top center;">
		<div class="container justify-content-center text-white jumbotron-text-box">
			<div class="row text-center">
				<div class="col-12">
					<h1>{!! App::title() !!}</h1>
					<button class="btn btn-primary btn-lg btn-huge">BOKA BANA NU</button><br /><br />
					<a class="h3 text-white text-decoration-none" href="https://www.google.se/maps/place/Elektronv%C3%A4gen+4,+141+49+Huddinge/@59.2220457,17.954668,17z/data=!3m1!4b1!4m5!3m4!1s0x465f70e7e98ee98d:0x3be588b17646d39d!8m2!3d59.2220457!4d17.9568567?shorturl=1" target="_blank">Hitta Hit <i class="fas fa-map-marker-alt"></i></a><br /><br />
					<a class="h3 text-white text-decoration-none" href="#">Ring till oss <i class="fas fa-phone-square"></i></a>
				</div>
			</div>
		</div>
	</div>
@else
	<div class="jumbotron d-flex align-items-center min-vh-60" style="box-shadow: inset 0 0 0 1000px rgba(0,0,0,.6); background-image:url('/wp-content/uploads/2021/03/pv-2.jpg'); background-size: cover; background-repeat: no-repeat; background-position: center center;">
		<div class="container justify-content-center text-white jumbotron-text-box">
			<div class="row text-center">
				<div class="col-12">
					<h1>{!! App::title() !!}</h1>
					<button class="btn btn-primary btn-lg btn-huge">BOKA BANA</button><br /><br />
					<a class="h3 text-white text-decoration-none" href="https://www.google.se/maps/place/Elektronv%C3%A4gen+4,+141+49+Huddinge/@59.2220457,17.954668,17z/data=!3m1!4b1!4m5!3m4!1s0x465f70e7e98ee98d:0x3be588b17646d39d!8m2!3d59.2220457!4d17.9568567?shorturl=1" target="_blank">Hitta Hit <i class="fas fa-map-marker-alt"></i></a><br /><br />
					<a class="h3 text-white text-decoration-none" href="#">Ring till oss <i class="fas fa-phone-square"></i></a>
				</div>
			</div>
		</div>
	</div>
@endif