<?php

namespace App;

use Roots\Sage\Container;

/**
 * Get the sage container.
 *
 * @param string $abstract
 * @param array  $parameters
 * @param Container $container
 * @return Container|mixed
 */
function sage($abstract = null, $parameters = [], Container $container = null)
{
    $container = $container ?: Container::getInstance();
    if (!$abstract) {
        return $container;
    }
    return $container->bound($abstract)
        ? $container->makeWith($abstract, $parameters)
        : $container->makeWith("sage.{$abstract}", $parameters);
}

/**
 * Get / set the specified configuration value.
 *
 * If an array is passed as the key, we will assume you want to set an array of values.
 *
 * @param array|string $key
 * @param mixed $default
 * @return mixed|\Roots\Sage\Config
 * @copyright Taylor Otwell
 * @link https://github.com/laravel/framework/blob/c0970285/src/Illuminate/Foundation/helpers.php#L254-L265
 */
function config($key = null, $default = null)
{
    if (is_null($key)) {
        return sage('config');
    }
    if (is_array($key)) {
        return sage('config')->set($key);
    }
    return sage('config')->get($key, $default);
}

/**
 * @param string $file
 * @param array $data
 * @return string
 */
function template($file, $data = [])
{
    return sage('blade')->render($file, $data);
}

/**
 * Retrieve path to a compiled blade view
 * @param $file
 * @param array $data
 * @return string
 */
function template_path($file, $data = [])
{
    return sage('blade')->compiledPath($file, $data);
}

/**
 * @param $asset
 * @return string
 */
function asset_path($asset)
{
    return sage('assets')->getUri($asset);
}

/**
 * @param string|string[] $templates Possible template files
 * @return array
 */
function filter_templates($templates)
{
    $paths = apply_filters('sage/filter_templates/paths', [
        'views',
        'resources/views'
    ]);
    $paths_pattern = "#^(" . implode('|', $paths) . ")/#";

    return collect($templates)
        ->map(function ($template) use ($paths_pattern) {
            /** Remove .blade.php/.blade/.php from template names */
            $template = preg_replace('#\.(blade\.?)?(php)?$#', '', ltrim($template));

            /** Remove partial $paths from the beginning of template names */
            if (strpos($template, '/')) {
                $template = preg_replace($paths_pattern, '', $template);
            }

            return $template;
        })
        ->flatMap(function ($template) use ($paths) {
            return collect($paths)
                ->flatMap(function ($path) use ($template) {
                    return [
                        "{$path}/{$template}.blade.php",
                        "{$path}/{$template}.php",
                    ];
                })
                ->concat([
                    "{$template}.blade.php",
                    "{$template}.php",
                ]);
        })
        ->filter()
        ->unique()
        ->all();
}

/**
 * @param string|string[] $templates Relative path to possible template files
 * @return string Location of the template
 */
function locate_template($templates)
{
    return \locate_template(filter_templates($templates));
}

/**
 * Determine whether to show the sidebar
 * @return bool
 */
function display_sidebar()
{
    static $display;
    isset($display) || $display = apply_filters('sage/display_sidebar', false);
    return $display;
}

//Visa antalet hallar, banor, turneringar, medlemmar
function visa_general_info( $atts ) {
    global $post;
    $atts = shortcode_atts( array(), $atts, 'visa_general_info' );
    ob_start();?>
    <div class="container w-75 pt-md-4 pb-md-4 ps-0 pe-0">
		<div class="row text-center pu-darkblue pb-4">
			<div class="col-6 col-md">
                <img src="<?php echo asset_path('images/icons/hallar.png') ?>" alt="Padel Hallar" class="w-160" />
                <div class="pt-1 pb-1"><h3 class="h2 no-padding"><strong><?php echo get_theme_mod('antal_hallar') ?></strong></h3><h5>Hallar</h5></div>
            </div>
			<div class="col-6 col-md">
                <img src="<?php echo asset_path('images/icons/banor.png') ?>" alt="Banor" class="w-160" />
                <div class="pt-1 pb-1"><h3 class="h2 no-padding"><strong><?php echo get_theme_mod('antal_banor') ?></strong></h3><h5>Banor</h5></div>
            </div>
            <?php if(get_theme_mod('antal_turneringar')) {?>
			<div class="col-6 col-md">
                <img src="<?php echo asset_path('images/icons/turneringar.png') ?>" alt="Turneringar" class="w-160" />
                <div class="pt-1 pb-1"><h3 class="h2 no-padding"><strong><?php echo get_theme_mod('antal_turneringar') ?></strong></h3><h5>Turneringar</h5></div>
            </div>
            <div class="col-6 col-md">
                <img src="<?php echo asset_path('images/icons/medlemmar.png') ?>" alt="Medlemmar" class="w-160" />
                <div class="pt-1 pb-1"><h3 class="h2 no-padding"><strong><?php echo get_theme_mod('antal_medlemmar') ?></strong></h3><h5>Spelare</h5></div>
            </div>
            <?php } else { ?>
			<div class="col-6 col-md offset-3 offset-md-0">
                <img src="<?php echo asset_path('images/icons/medlemmar.png') ?>" alt="Medlemmar" class="w-160" />
                <div class="pt-1 pb-1"><h3 class="h2 no-padding"><strong><?php echo get_theme_mod('antal_medlemmar') ?></strong></h3><h5>Spelare</h5></div>
            </div>
            <?php } ?>
		</div>
	</div>
    <?php
    wp_reset_query();
    $content = ob_get_clean();
    return $content;
}
add_shortcode( 'visa_general_info', __NAMESPACE__ . '\visa_general_info' );

//Visa områdes boxar med excerpt och lite innehåll
function omrades_excerpt_boxar( $atts ) {
    global $post;
    $atts = shortcode_atts( array(), $atts, 'omrades_excerpt_boxar' );
    ob_start();

    $args = array(
        'post_type' => 'omrade_hall',
        'post_status' => 'publish',
        'orderby' => 'title',
        'post_parent' => 0,
        'order' => 'ASC'
    );

    $omrade_pages = new \WP_Query( $args );
    ?>
    <div class="container alignfull pu-darkblue-bg pb-4 pt-4">
        <div class="text-center pb-4">
            <h2 class="text-white fw-bold">Välj område</h2>
        </div>
        <div class="container ps-0 pe-0 ps-md-3 pe-md-3 pb-4">
            <div class="row">
                <?php
                $counter = 1;
                while($omrade_pages->have_posts() ) : $omrade_pages->the_post();?>
                <div class="col-md-4 pe-md-1">
                    <div class="<?php if ($counter % 3 == 1) {
                        echo 'pu-orange-bg';
                    } else if ($counter % 3 == 2) {
                        echo 'pu-warmyellow-bg';
                    } else if ($counter % 3 == 0) {
                        echo 'pu-yellow-bg';
                    } ?> pt-2 pb-2"></div>
                    <div class="pu-lightblue-bg mt-2 mb-4 p-4 text-white">
                        <div class="container d-flex h-100 p-0">
                            <div class="row pt-4 pb-4">
                                <div class="col-3">
                                    <img class="img-fluid" src="<?php echo asset_path('images/footer-logo.png') ?>" alt="Padel United Logga" />
                                </div>
                                <div class="col-9 justify-content-center align-self-center">
                                    <?php if(get_post_meta(get_the_ID(), 'short_title', true)) {?>
                                        <h3>Se våra hallar i <?php echo(get_post_meta(get_the_ID(), 'short_title', true)) ?></h3>
                                    <?php } else {?>
                                        <h3>Se våra hallar i <?php the_title() ?></h3>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                        <p><?php echo(get_the_excerpt()) ?></p>
                        <div class="pb-4 pt-4 clearfix">
                            <a href="<?php echo(get_the_permalink()) ?>" class="btn btn-primary btn-huge float-end">Se Hallar <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div>
                <?php $counter++; endwhile ?>
            </div>
        </div>
    </div>
    <?php
    wp_reset_query();
    $content = ob_get_clean();
    return $content;
}
add_shortcode( 'omrades_excerpt_boxar', __NAMESPACE__ . '\omrades_excerpt_boxar' );

//Visa generella ikoner för hela Padel United
function visa_generella_ikoner( $atts ) {
    global $post;
    $atts = shortcode_atts( array(), $atts, 'visa_generella_ikoner' );
    ob_start();
    ?>
    <div class="container alignfull pu-darkblue-bg pt-4 pb-4">
        <div class="text-center text-white pt-4 pb-4">
            <h2 class="pt-4 pb-4 fw-bold text-uppercase">Vårt hjärta slår för spelet</h2>
        </div>
        <div class="container text-white ps-0 pe-0 ps-md-3 pe-md-3 text-center">
            <div class="row">
                <div class="col-md-1"></div>
                <div class="col col-md-10 pb-4 pb-md-0">
                    <p>Padel är en fantastisk sport som alla kan utöva – oavsett erfarenhet eller spelnivå. På Padel United erbjuder vi spel för såväl nybörjare som elitspelare, för barn, ungdomar, vuxna och pensionärer. Välkommen till Padel United! – hos oss får du ett personligt bemötande och en garanterat rolig stund på banan.</p>
                </div>
                <div class="col-md-1"></div>
            </div>
        </div>
        <div class="container ps-0 pe-0 ps-md-3 pe-md-3 text-white text-center w-75">
            <div class="row">
                <div class="col-6 col-md-3 p-md-4 pb-4">
                    <img src="<?php echo asset_path('images/icons/vpt_underlag.png') ?>" alt="VPT Underlag" class="w-160 pb-2" />
                    <h6>VTP-underlag: Mondo super court XN</h6>
                </div>
                <div class="col-6 col-md-3 p-md-4 pb-4">
                    <img src="<?php echo asset_path('images/icons/panorama_glas.png') ?>" alt="Panorama glas på alla banor" class="w-160 pb-2" />
                    <h6>Panorama glas på alla banor</h6>
                </div>
                <div class="col-6 col-md-3 p-md-4 pb-4">
                    <img src="<?php echo asset_path('images/icons/optimal_ljudisolering.png') ?>" alt="Optimal ljudisolering" class="w-160 pb-2" />
                    <h6>Optimal ljudisolering</h6>
                </div>
                <div class="col-6 col-md-3 p-md-4 pb-4">
                    <img src="<?php echo asset_path('images/icons/belysning.png') ?>" alt="Skräddarsydd belysning" class="w-160 pb-2" />
                    <h6>Skräddasydd belysning</h6>
                </div>
                <div class="col-6 col-md-3 p-md-4 pb-4">
                    <img src="<?php echo asset_path('images/icons/stream.png') ?>" alt="Streama din match" class="w-160 pb-2" />
                    <h6>Streama din match hos oss</h6>
                </div>
                <div class="col-6 col-md-3 p-md-4 pb-4">
                    <img src="<?php echo asset_path('images/icons/barn_och_ungdom.png') ?>" alt="Barn & Ungdoms verksamhet" class="w-160 pb-2" />
                    <h6>Barn & ungdoms verksamhet</h6>
                </div>
                <div class="col-6 col-md-3 p-md-4 pb-4">
                    <img src="<?php echo asset_path('images/icons/elittranare.png') ?>" alt="Elittränare" class="w-160 pb-2" />
                    <h6>Tränare</h6>
                </div>
                <div class="col-6 col-md-3 p-md-4 pb-4">
                    <img src="<?php echo asset_path('images/icons/lounge.png') ?>" alt="Lounge" class="w-160 pb-2" />
                    <h6>Shop & Lounge</h6>
                </div>
            </div>
        </div>
    </div>
    <?php
    wp_reset_query();
    $content = ob_get_clean();
    return $content;
}
add_shortcode( 'visa_generella_ikoner', __NAMESPACE__ . '\visa_generella_ikoner' );

//Visa medlemskapsboxen
function visa_medlemskap( $atts ) {
    global $post;
    $atts = shortcode_atts( array(), $atts, 'visa_medlemskap' );
    ob_start();
    $ingar_medlemskapet = array();
    $ingar_medlemskapet = explode("\n", get_theme_mod('ingar_medlemskapet'));
    ?>
    <div class="container alignfullmobile w-85 p-0 pb-4">
        <div class="pb-4">
            <div class="col-12 pu-orange-bg pt-2 pb-2"></div>
            <div class="col-12 pu-lightblue-bg text-white ps-4 pe-4 clearfix">    
                <div class="float-md-start"><h2 class="h3 small-padding fw-bold less-mobile-padding">Detta ingår i medlemskapet</h2></div>
                <div class="float-md-end"><h2 class="h3 small-padding fw-bold less-mobile-padding">Pris: <?php echo(get_theme_mod('medlemskaps_pris')) ?> kr</h2></div>
            </div>
            <div class="col-12 p-2 pt-4 pb-4 border clearfix">
                <ul class="float-start pb-4 pb-md-2">
                    <?php foreach($ingar_medlemskapet as $medlemskap) {?> 
                        <li><?php echo($medlemskap); ?>    
                    <?php } ?>
                </ul>
                <div class="pb-4 pb-md-0 float-md-end text-center">
                    <a href="<?php echo(get_theme_mod('medlemskaps_link')) ?>" class="btn btn-huge btn-primary">BLI MEDLEM NU</a>
                </div>
            </div>
        </div>
    </div>
    <?php
    wp_reset_query();
    $content = ob_get_clean();
    return $content;
}
add_shortcode( 'visa_medlemskap', __NAMESPACE__ . '\visa_medlemskap' );

//Visa Tak Höjd, Antalet Banor, Fri Parkering
function visa_general_info_hallar( $atts ) {
    global $post;
    $atts = shortcode_atts( array(), $atts, 'visa_general_info_hallar' );
    ob_start();?>
    <div class="container w-75 pt-4 pb-4 ps-0 pe-0">
        <div class="pt-2 pb-2">
            <div class="row text-center pu-darkblue pt-4 pb-4">
                <?php if(get_post_meta(get_the_ID(), 'tak_hojd', true)) {?>
                <div class="col">
                    <img src="<?php echo asset_path('images/icons/tak_hojd.png') ?>" alt="Tak Höjd" class="w-160" />
                    <h3 class="h1 mb-0"><strong><?php echo get_post_meta(get_the_ID(), 'tak_hojd', true) ?>m</strong></h3><h5>Tak Höjd</h5>
                </div>
                <?php } ?>
                <div class="col">
                    <img src="<?php echo asset_path('images/icons/banor.png') ?>" alt="Banor" class="w-160" />
                    <h3 class="h1 mb-0"><strong><?php echo get_post_meta(get_the_ID(), 'antal_banor', true) ?></strong></h3><h5>Banor</h5>
                </div>
                <?php if(get_post_meta(get_the_ID(), 'fri_parkering', true)) {?>
                <div class="col">
                    <img src="<?php echo asset_path('images/icons/fri_parkering.png') ?>" alt="Fri Parkering" class="w-160" />
                    <h3 class="h1 mb-0"><strong>FRI</strong></h3><h5>Parkering</h5>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <?php
    wp_reset_query();
    $content = ob_get_clean();
    return $content;
}
add_shortcode( 'visa_general_info_hallar', __NAMESPACE__ . '\visa_general_info_hallar' );

//Hämta nyheter kopplade till en hall genom etiketter(tags)
function nyheter_med_etikett( $atts ) {
    global $post;
    $atts = shortcode_atts( array(
        'etiketter' => '',
        'limit' => 3
    ), $atts, 'nyheter_med_etikett' );
    ob_start();

    $atts['etiketter'] = $atts['etiketter'] . ',alla';
    
    $args = array(
        'numberposts' => $atts['limit'],
        'post_type' => 'post',
        'tag' => $atts['etiketter'],
        'post_status' => 'publish',
        'orderby' => 'date',
        'order' => 'DESC'
    );
    
    $nyheter = get_posts( $args );
    ?>
    <div id="hallNyheterCarousel" class="carousel slide alignfull" data-bs-ride="carousel">
        <div class="carousel-indicators">
        <?php foreach ($nyheter as $key => $post) : setup_postdata( $post )?>
            <button type="button" data-bs-target="#hallNyheterCarousel" data-bs-slide-to="<?=$key?>" <?php echo ($key == 0 ) ? 'class="active"' : ''?>></button>    
        <?php endforeach; ?>  
        </div>
      <div class="carousel-inner">
      <?php foreach ($nyheter as $key => $post) : setup_postdata( $post )?>
        <div class="carousel-item <?php echo ($key == 0 ) ? 'active' : ''?> pu-teal-bg" style="box-shadow: inset 0 0 0 1000px rgba(0,0,0,.6); background-image: url('<?php echo asset_path('images/padel_boll.jpg') ?>'); background-size: cover; background-position: center center;">
          <div class="carousel-caption d-block pt-0 pt-md-4">
            <h2 class="h1"><a href="<?php the_permalink() ?>" class="text-white text-decoration-none"><?php the_title() ?></a></h2>
            <div class="d-block">
                <a href="<?php the_permalink() ?>" class="btn btn-lg btn-huge btn-secondary">LÄS MER</a>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#hallNyheterCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#hallNyheterCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
    </div>
    <?php
    wp_reset_query();
    $content = ob_get_clean();
    return $content;
}
add_shortcode( 'nyheter_med_etikett', __NAMESPACE__ . '\nyheter_med_etikett' );

//Kontakt ruta för Hall sidor
function kontakt_box( $atts ) {
    $atts = shortcode_atts( array(), $atts, 'kontakt_box' );
    ob_start();
    ?>
    <div class="container ps-0 pe-0 pb-4">
        <div class="row pb-4">
            <div class="col-md-6">
                <h2 class="fw-bold">Kontakt</h2>
                <p><?php echo get_post_meta(get_the_ID(), 'oppettider', true) ?></p>
                <div class="row pt-4">
                <?php if(get_post_meta(get_the_ID(), 'telefon_nummer', true)) { ?>
                    <div class="col-12 pb-2">
                        <div class="row">
                            <div class="col-2">
                                <img src="<?php echo asset_path('images/icons/mobile.png') ?>" class="w-70 pe-2 p-md-0" alt="Telefon nummer" />               
                            </div>
                            <div class="align-self-center ps-4 col-10 ps-md-0">
                                <a class="pu-darkblue text-decoration-none" href="tel:<?php echo get_post_meta(get_the_ID(), 'telefon_nummer', true) ?>"><?php echo get_post_meta(get_the_ID(), 'telefon_nummer', true) ?></a>
                            </div>
                        </div>        
                    </div>
                <?php } ?>
                    <div class="col-12 pb-2">
                        <div class="row">
                            <div class="col-2">
                                <img src="<?php echo asset_path('images/icons/mail.png') ?>" class="w-70 pe-2 p-md-0" alt="Email" />
                            </div>
                            <div class="align-self-center ps-4 col-10 ps-md-0">
                                <a class="pu-darkblue text-decoration-none" href="mailto:<?php echo get_post_meta(get_the_ID(), 'epost', true) ?>"><?php echo get_post_meta(get_the_ID(), 'epost', true) ?></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                    <div class="row">
                        <div class="col-2">
                            <img src="<?php echo asset_path('images/icons/location.png') ?>" class="w-70 pe-2 p-md-0" alt="Telefon nummer" />
                        </div>
                        <div class="align-self-center ps-4 col-10 ps-md-0">
                            <span class="align-middle"><?php echo get_post_meta(get_the_ID(), 'adress', true) ?></span>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <h2 class="fw-bold">Hitta Hit</h2>
                <p><?php echo get_post_meta(get_the_ID(), 'hitta_hit', true) ?></p>
                <iframe src="<?php echo get_post_meta(get_the_ID(), 'google_maps_adress', true) ?>" width="100%" height="350" frameborder="0" style="border:0" allowfullscreen></iframe>
            </div>
        </div>
    </div>
    <?php
    $content = ob_get_clean();
    return $content;
}
add_shortcode( 'kontakt_box', __NAMESPACE__ . '\kontakt_box' );

//Aktiviteter box på hall sidorna
function aktiviteter( $atts ) {
    $atts = shortcode_atts( array(), $atts, 'aktiviteter' );
    ob_start();

    $args = array(
        'post_type' => 'omrade_hall',
        'post_status' => 'publish',
        'p' => 14,
    );

    $aktiviteter = new \WP_Query( $args );
    while($aktiviteter->have_posts() ) : $aktiviteter->the_post();
    ?>
    <div class="alignfull pu-beigegrey-bg pt-4 pb-4 mb-4">
        <div class="container pb-4 d-none d-md-block">
            <h2 class="pt-4 pb-4 text-center fw-bold">Aktiviteter</h2>
            <div class="row pt-4 pb-4">
                <div class="d-flex align-items-start">
                    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        <button class="nav-link active h5 pu-darkblue text-start pt-4 pb-4" id="v-pills-home-tab" data-bs-toggle="pill" data-bs-target="#v-pills-home" type="button" role="tab" aria-controls="v-pills-home" aria-selected="true">
                            <img src="<?php echo asset_path('images/padel-boll.png') ?>" alt="Aktiviterer Icon" width="84" height="84" class="rounded-circle pe-2" />Tränare
                        </button>
                        <button class="nav-link h5 pu-darkblue text-start pt-4 pb-4" id="v-pills-profile-tab" data-bs-toggle="pill" data-bs-target="#v-pills-profile" type="button" role="tab" aria-controls="v-pills-profile" aria-selected="false">
                            <img src="<?php echo asset_path('images/kille-smashar.png') ?>" alt="Aktiviterer Icon" width="84" height="84" class="rounded-circle pe-2" />Vårt Seriespel
                        </button>
                        <button class="nav-link h5 pu-darkblue text-start pt-4 pb-4" id="v-pills-settings-tab" data-bs-toggle="pill" data-bs-target="#v-pills-settings" type="button" role="tab" aria-controls="v-pills-settings" aria-selected="false">
                            <img src="<?php echo asset_path('images/ungdomar.png') ?>" alt="Aktiviterer Icon" width="84" height="84" class="rounded-circle pe-2" />Ungdomsverksamhet
                        </button>
                        <button class="nav-link h5 pu-darkblue text-start pt-4 pb-4" id="v-pills-foretag-tab" data-bs-toggle="pill" data-bs-target="#v-pills-foretag" type="button" role="tab" aria-controls="v-pills-foretag" aria-selected="false">
                            <img src="<?php echo asset_path('images/foretag-skola.png') ?>" alt="Aktiviterer Icon" width="84" height="84" class="rounded-circle pe-2" />Företag & Skola
                        </button>
                        <button class="nav-link h5 pu-darkblue text-start pt-4 pb-4" id="v-pills-abonnemang-tab" data-bs-toggle="pill" data-bs-target="#v-pills-abonnemang" type="button" role="tab" aria-controls="v-pills-abonnemang" aria-selected="false">
                            <img src="<?php echo asset_path('images/padel-boll.png') ?>" alt="Aktiviterer Icon" width="84" height="84" class="rounded-circle pe-2" />Abonnemang
                        </button>
                    </div>
                    <div class="tab-content" id="v-pills-tabContent">
                        <div class="tab-pane fade show active p-4 pt-0" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                            <div class="ps-4 pe-4"><?php echo get_post_meta(get_the_ID(), 'tranare', true) ?></div>
                        </div>
                        <div class="tab-pane fade p-4 pt-0" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                            <div class="ps-4 pe-4"><?php echo get_post_meta(get_the_ID(), 'vart_seriespel', true) ?></div>
                        </div>
                        <div class="tab-pane fade p-4 pt-0" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">
                            <div class="ps-4 pe-4"><?php echo get_post_meta(get_the_ID(), 'ungdomsverksamhet', true) ?></div>
                        </div>
                        <div class="tab-pane fade p-4 pt-0" id="v-pills-foretag" role="tabpanel" aria-labelledby="v-pills-foretag-tab">
                            <div class="ps-4 pe-4"><?php echo get_post_meta(get_the_ID(), 'foretag', true) ?></div>
                        </div>
                        <div class="tab-pane fade p-4 pt-0" id="v-pills-abonnemang" role="tabpanel" aria-labelledby="v-pills-abonnemang-tab">
                            <div class="ps-4 pe-4"><?php echo get_post_meta(get_the_ID(), 'abonnemang', true) ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container d-block d-md-none pt-4 pb-4">
            <h2 class="pt-4 pb-4 text-center fw-bold">Aktiviteter</h2>
            <div class="accordion accordion-flush" id="padelUnitedAccordion">
                <div class="accordion-item">
                    <h2 class="accordion-header bg-white" id="headingOne">
                        <button class="accordion-button h5 pu-darkblue bg-white collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            Tränare
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#padelUnitedAccordion">
                        <div class="accordion-body bg-white">
                            <?php echo get_post_meta(get_the_ID(), 'tranare', true) ?>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header bg-white" id="headingTwo">
                        <button class="accordion-button h5 pu-darkblue bg-white collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            Vårt Seriespel
                        </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#padelUnitedAccordion">
                        <div class="accordion-body bg-white">
                            <?php echo get_post_meta(get_the_ID(), 'vart_seriespel', true) ?>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header bg-white" id="headingThree">
                        <button class="accordion-button h5 pu-darkblue bg-white collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                            Ungdomsverksamhet
                        </button>
                    </h2>
                    <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#padelUnitedAccordion">
                        <div class="accordion-body bg-white">
                            <?php echo get_post_meta(get_the_ID(), 'ungdomsverksamhet', true) ?>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header bg-white" id="headingFour">
                        <button class="accordion-button h5 pu-darkblue bg-white collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                            Företag & Skola
                        </button>
                    </h2>
                    <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#padelUnitedAccordion">
                        <div class="accordion-body bg-white">
                            <?php echo get_post_meta(get_the_ID(), 'foretag', true) ?>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header bg-white" id="headingFive">
                        <button class="accordion-button h5 pu-darkblue bg-white collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                            Abonnemang
                        </button>
                    </h2>
                    <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#padelUnitedAccordion">
                        <div class="accordion-body bg-white">
                            <?php echo get_post_meta(get_the_ID(), 'abonnemang', true) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    endwhile;
    wp_reset_query();
    $content = ob_get_clean();
    return $content;
}
add_shortcode( 'aktiviteter', __NAMESPACE__ . '\aktiviteter' );

//Pris boxar på hall sidor
function pris_boxar( $atts ) {
    $atts = shortcode_atts( array(), $atts, 'pris_boxar' );
    ob_start();
    ?>
    <div class="container alignfull pu-darkblue-bg pt-4 pb-4">
        <h2 class="pt-4 pb-4 text-white text-center fw-bold">Priser</h2>
        <div class="container ps-0 pe-0 ps-md-3 pe-md-3 pb-4">
            <div class="row">
                <div class="col pe-md-1 pt-4">
                    <div class="pu-orange-bg pt-2 pb-2"></div>
                    <div class="pu-lightblue-bg mt-2 p-4 clearfix text-white h-250">
                        <div class="container d-flex h-100 p-0">
                            <div class="row">
                                <?php echo get_post_meta(get_the_ID(), 'pris_box_one', true) ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col pe-md-1 pt-4">
                    <div class="pu-warmyellow-bg pt-2 pb-2"></div>
                    <div class="pu-lightblue-bg mt-2 p-4 clearfix text-white h-250">
                        <div class="container d-flex h-100 p-0">
                            <div class="row">
                                <?php echo get_post_meta(get_the_ID(), 'pris_box_two', true) ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php if(get_post_meta(get_the_ID(), 'pris_box_three', true)) { ?>
                <div class="col pe-md-1 pt-4">
                    <div class="pu-yellow-bg pt-2 pb-2"></div>
                    <div class="pu-lightblue-bg mt-2 p-4 clearfix text-white h-250">
                        <div class="container d-flex h-100 p-0">
                            <div class="row">
                            <?php echo get_post_meta(get_the_ID(), 'pris_box_three', true) ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <?php
    $content = ob_get_clean();
    return $content;
}
add_shortcode( 'pris_boxar', __NAMESPACE__ . '\pris_boxar' );