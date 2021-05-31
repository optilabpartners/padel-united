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
							<a href="/"><img class="logo d-none logo-class ps-3 ms-2" src="{!! $image[0] !!}" alt="Padel United Logo" /></a>
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
@endphp

@if ('omrade_hall' == get_post_type())
<div class="pu-containers">
	<div class="pu-backgrounds">
		<div class="pu-background" style="box-shadow: inset 0 0 0 1000px rgba(0,0,0,.6);background-image: url('https://padelunited.se/wp-content/uploads/2021/05/bg-header-2.jpg')"></div>
		<div class="pu-background pu-previous" style="box-shadow: inset 0 0 0 1000px rgba(0,0,0,.6);background-image: url('https://padelunited.se/wp-content/uploads/2021/05/bg-header-3.jpg')"></div>
		<div class="pu-background pu-current" style="box-shadow: inset 0 0 0 1000px rgba(0,0,0,.6);background-image: url('https://padelunited.se/wp-content/uploads/2021/04/lanner_20210223_1233.jpg')"></div>
	</div>
	<div class="pu-content min-vh-100 d-flex align-items-center">
		<div class="container justify-content-center text-white jumbotron-text-box">
			<div class="row text-center">
				<div class="col-12">
					<h1 class="text-uppercase pb-4 fw-bold">@if(!$get_children_pages->have_posts() && $hallsida == 1) Padel United @endif{!! App::title() !!}</h1>
					@if ($get_children_pages->have_posts() && $hallsida != 1)
						<button type="button" data-bs-toggle="collapse" data-bs-target="#showAllBanor" aria-expanded="false" aria-controls="showAllBanor" class="btn btn-primary btn-lg btn-huge">
							BOKA BANA NU
						</button>
						<div class="collapse" id="showAllBanor">
							<div class="card-body pt-0 mt-2">
								<ul class="list-group">
								@if($get_children_pages)
									@while ($get_children_pages->have_posts())
									@php $get_children_pages->the_post() @endphp
										@if(get_post_meta(get_the_ID(), 'matchi_link', true))
											<li class="list-group-item list-group-item-action">
												<a href="{!! get_post_meta(get_the_ID(), 'matchi_link', true) !!}" target="_blank">{!! the_title() !!}</a>
											</li>
										@endif
									@endwhile
									@php wp_reset_postdata() @endphp
								@endif
								</ul>	
							</div>
						</div>
					@elseif(!$get_children_pages->have_posts() && $hallsida == 1)
						@if(get_post_meta(get_the_ID(), 'matchi_link', true))
							<a href="{!! get_post_meta(get_the_ID(), 'matchi_link', true) !!}" target="_blank" class="btn btn-primary btn-lg btn-huge">BOKA BANA NU</a>
						@endif
					@endif
					@if (get_post_meta(get_the_ID(), 'hall_sida', true))
						<div class="row mt-4">
							<div class="col-12 pt-3">
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
<div class="pu-containers">
	<div class="pu-backgrounds">
		<div class="pu-background" style="box-shadow: inset 0 0 0 1000px rgba(0,0,0,.6);background-image: url('https://padelunited.se/wp-content/uploads/2021/05/bg-header-2.jpg')"></div>
		<div class="pu-background pu-previous" style="box-shadow: inset 0 0 0 1000px rgba(0,0,0,.6);background-image: url('https://padelunited.se/wp-content/uploads/2021/05/bg-header-3.jpg')"></div>
		<div class="pu-background pu-current" style="box-shadow: inset 0 0 0 1000px rgba(0,0,0,.6);background-image: url('https://padelunited.se/wp-content/uploads/2021/04/lanner_20210223_1233.jpg')"></div>
	</div>
	<div class="pu-content min-vh-100 d-flex align-items-center">
		<div class="container justify-content-center text-white jumbotron-text-box">
			<div class="row text-center justify-content-md-center">
				<div class="col-12 col-md-8">
					<h1 class="text-uppercase pb-4 fw-bold">{!! App::title() !!}</h1>
					<button type="button" data-bs-toggle="collapse" data-bs-target="#showAllBanor" aria-expanded="false" aria-controls="showAllBanor" class="btn btn-primary btn-lg btn-huge">
						BOKA BANA NU
					</button>
					<div class="collapse" id="showAllBanor">
						<div class="card-body pt-0 mt-2">
							<ul class="list-group">
							@if($get_matchi_links)
								@while ($get_matchi_links->have_posts())
								@php $get_matchi_links->the_post() @endphp
									@if(get_post_meta(get_the_ID(), 'matchi_link', true))
									<li class="list-group-item list-group-item-action">
										<a href="{!! get_post_meta(get_the_ID(), 'matchi_link', true) !!}" target="_blank">{!! the_title() !!}</a>
									</li>
									@endif
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
<div class="pu-containers">
	<div class="pu-backgrounds">
		<div class="pu-background" style="box-shadow: inset 0 0 0 1000px rgba(0,0,0,.6);background-image: url('https://padelunited.se/wp-content/uploads/2021/05/bg-header-2.jpg')"></div>
		<div class="pu-background pu-previous" style="box-shadow: inset 0 0 0 1000px rgba(0,0,0,.6);background-image: url('https://padelunited.se/wp-content/uploads/2021/05/bg-header-3.jpg')"></div>
		<div class="pu-background pu-current" style="box-shadow: inset 0 0 0 1000px rgba(0,0,0,.6);background-image: url('https://padelunited.se/wp-content/uploads/2021/04/lanner_20210223_1233.jpg')"></div>
	</div>
	<div class="pu-content min-vh-100 d-flex align-items-center">
		<div class="container justify-content-center text-white jumbotron-text-box">
			<div class="row text-center">
				<div class="col-12">
					<h1 class="text-uppercase fw-bold">{!! App::title() !!}</h1>
				</div>
			</div>
		</div>
	</div>
</div>
@endif