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
		<div class="row text-center pu-darkblue">
			<div class="col-6 col-md-3">
                <img src="<?php echo asset_path('images/icons/hallar.png') ?>" alt="Padel Hallar" class="w-160" />
                <h2 class="h1"><strong><?php echo get_theme_mod('antal_hallar') ?></strong></h2><h5>Hallar</h5>
            </div>
			<div class="col-6 col-md-3">
                <img src="<?php echo asset_path('images/icons/banor.png') ?>" alt="Banor" class="w-160" />
                <h2 class="h1"><strong><?php echo get_theme_mod('antal_banor') ?></strong></h2><h5>Banor</h5>
            </div>
			<div class="col-6 col-md-3">
                <img src="<?php echo asset_path('images/icons/turneringar.png') ?>" alt="Turneringar" class="w-160" />
                <h2 class="h1"><strong><?php echo get_theme_mod('antal_turneringar') ?></strong></h2><h5>Turneringar</h5>
            </div>
			<div class="col-6 col-md-3">
                <img src="<?php echo asset_path('images/icons/medlemmar.png') ?>" alt="Medlemmar" class="w-160" />
                <h2 class="h1"><strong><?php echo get_theme_mod('antal_medlemmar') ?></strong></h2><h5>Medlemmar</h5>
            </div>
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
        'order' => 'ASC',
        'meta_query' => array(
            array(
                'key' => 'matchi_link',
                'value' => ''
            )
        )
    );

    $omrade_pages = new \WP_Query( $args );
    ?>
    <div class="container alignfull pu-darkblue-bg pt-4 pb-4">
        <div class="text-center">
            <h2 class="pt-4 pb-4 text-white"><strong>VÄLJ OMRÅDE</strong></h2>
        </div>
        <div class="container ps-0 pe-0 ps-md-3 pe-md-3">
            <div class="row">
                <?php
                $counter = 1;
                while($omrade_pages->have_posts() ) : $omrade_pages->the_post();?>
                <div class="col-md-4 pe-md-1">
                    <div class="<?php if ($counter % 3 == 1) {
                        echo 'pu-warmyellow-bg';
                    } else if ($counter % 3 == 2) {
                        echo 'pu-yellow-bg';
                    } else if ($counter % 3 == 0) {
                        echo 'pu-orange-bg';
                    } ?> pt-2 pb-2"></div>
                    <div class="<?php if ($counter % 3 == 1) {
                        echo 'pu-warmyellow-bg';
                    } else if ($counter % 3 == 2) {
                        echo 'pu-yellow-bg';
                    } else if ($counter % 3 == 0) {
                        echo 'pu-orange-bg';
                    } ?> mt-2 p-4 clearfix text-black">
                        <div class="container d-flex h-100 p-0">
                            <div class="row">
                                <div class="col-3">
                                    <img class="img-fluid" src="<?php echo asset_path('images/footer-logo.png') ?>" alt="Padel United Logga" />
                                </div>
                                <div class="col-9 justify-content-center align-self-center">
                                    <h3>Se våra hallar i <?php the_title() ?></h3>
                                </div>
                            </div>
                        </div>
                        <p><?php get_the_excerpt() ?></p>
                        <a href="<?php echo(get_the_permalink()) ?>" class="btn btn-primary float-end">Se Hallar <i class="fas fa-arrow-circle-right"></i></a>
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
        <div class="text-center text-white">
            <h2 class="pt-4 pb-4"><strong>Vårt hjärta slår för spelet</strong></h2>
        </div>
        <div class="container text-white ps-0 pe-0 ps-md-3 pe-md-3">
            <div class="row">
            <p>Padel är en fantastisk sport som alla kan utöva – oavsett erfarenhet eller spelnivå. På Padel United erbjuder vi spel för såväl nybörjare som elitspelare, för barn, ungdomar, vuxna och pensionärer och varje padelhall erbjuder också banor för handikappade där man kan komma in med rullstol. Välkommen till Padel United! - vi kan garantera ett personligt bemötande och en rolig stund på banan.</p>
            </div>
        </div>
        <div class="container ps-0 pe-0 ps-md-3 pe-md-3 text-white text-center w-75">
            <div class="row">
                <div class="col-6 col-md-3 p-md-4 pb-4">
                    <img src="<?php echo asset_path('images/icons/vpt_underlag.png') ?>" alt="VPT Underlag" class="w-160 pb-2" />
                    <h5>VTP-underlag: Mondo super court XN</h5>
                </div>
                <div class="col-6 col-md-3 p-md-4 pb-4">
                    <img src="<?php echo asset_path('images/icons/panorama_glas.png') ?>" alt="Panorama glas på alla banor" class="w-160 pb-2" />
                    <h5>Panorama glas på alla banor</h5>
                </div>
                <div class="col-6 col-md-3 p-md-4 pb-4">
                    <img src="<?php echo asset_path('images/icons/optimal_ljudisolering.png') ?>" alt="Optimal ljudisolering" class="w-160 pb-2" />
                    <h5>Optimal ljudisolering</h5>
                </div>
                <div class="col-6 col-md-3 p-md-4 pb-4">
                    <img src="<?php echo asset_path('images/icons/belysning.png') ?>" alt="Skräddarsydd belysning" class="w-160 pb-2" />
                    <h5>Skräddasydd belysning</h5>
                </div>
                <div class="col-6 col-md-3 p-md-4 pb-4">
                    <img src="<?php echo asset_path('images/icons/trivsam_luftig_miljo.png') ?>" alt="Trivsam luftig miljö" class="w-160 pb-2" />
                    <h5>Trivsam luftig miljö</h5>
                </div>
                <div class="col-6 col-md-3 p-md-4 pb-4">
                    <img src="<?php echo asset_path('images/icons/barn_och_ungdom.png') ?>" alt="Barn & Ungdoms verksamhet" class="w-160 pb-2" />
                    <h5>Barn & ungdoms verksamhet</h5>
                </div>
                <div class="col-6 col-md-3 p-md-4 pb-4">
                    <img src="<?php echo asset_path('images/icons/elittranare.png') ?>" alt="Elittränare" class="w-160 pb-2" />
                    <h5>Elittränare</h5>
                </div>
                <div class="col-6 col-md-3 p-md-4 pb-4">
                    <img src="<?php echo asset_path('images/icons/lounge.png') ?>" alt="Lounge" class="w-160 pb-2" />
                    <h5>Supertrevlig lounge</h5>
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
    <div class="container alignfullmobile p-0 mb-4 mt-4">
        <div class="col-12 pu-orange-bg pt-2 pb-2"></div>
        <div class="col-12 pu-lightblue-bg text-white p-4 clearfix">    
            <div class="float-md-start"><h2 class="m-0 mb-2 mb-md-0"><strong>Detta ingår i medlemskapet</strong></h2></div>
            <div class="float-md-end"><h2 class="m-0"><strong>Pris: <?php echo(get_theme_mod('medlemskaps_pris')) ?> kr</strong></h2></div>
        </div>
        <div class="col-12 p-2 border clearfix">
            <ul class="float-start pu-darkblue">
                <?php foreach($ingar_medlemskapet as $medlemskap) {?> 
                    <li><?php echo($medlemskap); ?>    
                <?php } ?>
            </ul>
            <div class="float-md-end text-center">
                <a href="<?php echo(get_theme_mod('medlemskaps_link')) ?>" target="_blank" class="btn btn-huge btn-primary">BLI MEDLEM NU</a>
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
		<div class="row text-center pu-darkblue">
			<div class="col">
                <img src="<?php echo asset_path('images/icons/tak_hojd.png') ?>" alt="Tak Höjd" class="w-160" />
                <h2 class="h1 mb-0"><strong><?php echo get_post_meta(get_the_ID(), 'tak_hojd', true) ?>m</strong></h2><h5>Tak Höjd</h5>
            </div>
			<div class="col">
                <img src="<?php echo asset_path('images/icons/banor.png') ?>" alt="Banor" class="w-160" />
                <h2 class="h1 mb-0"><strong><?php echo get_post_meta(get_the_ID(), 'antal_banor', true) ?></strong></h2><h5>Banor</h5>
            </div>
            <?php if(get_post_meta(get_the_ID(), 'fri_parkering', true)) {?>
			<div class="col">
                <img src="<?php echo asset_path('images/icons/fri_parkering.png') ?>" alt="Fri Parkering" class="w-160" />
                <h2 class="h1 mb-0"><strong>FRI</strong></h2><h5>Parkering</h5>
            </div>
            <?php } ?>
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
        <div class="carousel-item <?php echo ($key == 0 ) ? 'active' : ''?> pu-teal-bg">
          <img src="<?php echo asset_path('images/padel_boll.jpg') ?>" style="opacity: 0.3" class="d-block w-100" alt="Padel Boll">
          <div class="carousel-caption d-block pt-0 pt-md-4">
            <h2 class="h1"><a href="<?php the_permalink() ?>" class="text-white text-decoration-none"><?php the_title() ?></a></h2>
            <div class="d-none d-md-block">
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
    <div class="container ps-0 pe-0 mb-4">
        <div class="row">
            <div class="col-md-6">
                <div class="row">
                    <div class="col-2 text-end">
                        <img src="<?php echo asset_path('images/icons/mobile.png') ?>" class="w-70 pe-2 p-md-0" alt="Telefon nummer" />
                    </div>
                    <div class="col-10 align-self-center">
                        <h3 class="ps-2 ps-md-0"><a class="pu-darkblue text-decoration-none" href="tel:<?php echo get_post_meta(get_the_ID(), 'telefon_nummer', true) ?>"><?php echo get_post_meta(get_the_ID(), 'telefon_nummer', true) ?></a></h3>
                    </div>
                    <div class="mt-2 col-2 text-end">
                        <img src="<?php echo asset_path('images/icons/mail.png') ?>" class="w-70 pe-2 p-md-0" alt="Email" />
                    </div>
                    <div class="col-10 align-self-center">
                        <h3 class="ps-2 ps-md-0 text-break"><a class="pu-darkblue text-decoration-none" href="mailto:<?php echo get_post_meta(get_the_ID(), 'epost', true) ?>"><?php echo get_post_meta(get_the_ID(), 'epost', true) ?></a></h3>
                    </div>
                    <div class="mt-2 col-2 text-end">
                        <img src="<?php echo asset_path('images/icons/location.png') ?>" class="w-70 pe-2 p-md-0" alt="Telefon nummer" />
                    </div>
                    <div class="mt-2 col-10 align-self-center">
                        <h3 class="ps-2 ps-md-0"><?php echo get_post_meta(get_the_ID(), 'adress', true) ?></h3>
                    </div>
                </div>
            </div>
            <div class="mt-2 col-md-6">
                <div class="row">
                    <div class="col-2 text-end">
                        <img src="<?php echo asset_path('images/icons/building.png') ?>" class="w-70 pe-2 p-md-0" alt="Öppettider" />
                    </div>
                    <div class="col-10 align-self-center">
                        <h3 class="ps-2 ps-md-0"><?php echo get_post_meta(get_the_ID(), 'oppettider', true) ?></h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <h2 class="text-center">Hitta Hit</h2>
            <div class="mt-2 col-12 col-md-6">
                <p class="ps-2 ps-md-0"><?php echo get_post_meta(get_the_ID(), 'hitta_hit', true) ?></p>
            </div>
            <div class="mt-2 col-12 col-md-6">
                <iframe src="<?php echo get_post_meta(get_the_ID(), 'google_maps_adress', true) ?>" width="100%" height="350" frameborder="0" style="border:0" allowfullscreen></iframe>
            </div>
        </div>
    </div>
    <?php
    $content = ob_get_clean();
    return $content;
}
add_shortcode( 'kontakt_box', __NAMESPACE__ . '\kontakt_box' );

//Våra Tränare box/accordion
function aktiviteter( $atts ) {
    $atts = shortcode_atts( array(), $atts, 'aktiviteter' );
    ob_start();
    ?>
    <div class="alignfull pu-beigegrey-bg mb-4">
        <div class="container pt-4 pb-4 d-none d-md-block">
            <h2 class="pt-4 pb-4 pu-darkblue text-center"><strong>Aktiviteter</strong></h2>
            <div class="row">
                <div class="d-flex align-items-start">
                    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        <button class="nav-link active h5 pu-darkblue text-start" id="v-pills-home-tab" data-bs-toggle="pill" data-bs-target="#v-pills-home" type="button" role="tab" aria-controls="v-pills-home" aria-selected="true">
                            Tränare
                        </button>
                        <button class="nav-link h5 pu-darkblue text-start" id="v-pills-profile-tab" data-bs-toggle="pill" data-bs-target="#v-pills-profile" type="button" role="tab" aria-controls="v-pills-profile" aria-selected="false">
                            Vårt Seriespel
                        </button>
                        <button class="nav-link h5 pu-darkblue text-start" id="v-pills-settings-tab" data-bs-toggle="pill" data-bs-target="#v-pills-settings" type="button" role="tab" aria-controls="v-pills-settings" aria-selected="false">
                            Ungdomsverksamhet
                        </button>
                        <button class="nav-link h5 pu-darkblue text-start" id="v-pills-foretag-tab" data-bs-toggle="pill" data-bs-target="#v-pills-foretag" type="button" role="tab" aria-controls="v-pills-foretag" aria-selected="false">
                            Företag & Skola
                        </button>
                        <button class="nav-link h5 pu-darkblue text-start" id="v-pills-abonnemang-tab" data-bs-toggle="pill" data-bs-target="#v-pills-abonnemang" type="button" role="tab" aria-controls="v-pills-abonnemang" aria-selected="false">
                            Abonnemang
                        </button>
                    </div>
                    <div class="tab-content" id="v-pills-tabContent">
                        <div class="tab-pane fade show active p-4" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                            <?php echo get_post_meta(get_the_ID(), 'tranare', true) ?>
                        </div>
                        <div class="tab-pane fade p-4" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                            <?php echo get_post_meta(get_the_ID(), 'vart_seriespel', true) ?>
                        </div>
                        <div class="tab-pane fade p-4" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">
                            <?php echo get_post_meta(get_the_ID(), 'ungdomsverksamhet', true) ?>
                        </div>
                        <div class="tab-pane fade p-4" id="v-pills-foretag" role="tabpanel" aria-labelledby="v-pills-foretag-tab">
                            <?php echo get_post_meta(get_the_ID(), 'foretag', true) ?>
                        </div>
                        <div class="tab-pane fade p-4" id="v-pills-abonnemang" role="tabpanel" aria-labelledby="v-pills-abonnemang-tab">
                            <?php echo get_post_meta(get_the_ID(), 'abonnemang', true) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container d-block d-md-none pt-4 pb-4">
            <h2 class="pt-4 pb-4 pu-darkblue text-center"><strong>Aktiviteter</strong></h2>
            <div class="accordion accordion-flush" id="padelUnitedAccordion">
                <div class="accordion-item">
                    <h2 class="accordion-header bg-white" id="headingOne">
                        <button class="accordion-button h5 pu-darkblue bg-white" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            Tränare
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#padelUnitedAccordion">
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
                            <?php echo get_post_meta(get_the_ID(), 'ungdomar_skola', true) ?>
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
    $content = ob_get_clean();
    return $content;
}
add_shortcode( 'aktiviteter', __NAMESPACE__ . '\aktiviteter' );

//Pris boxar på hall sidor
function pris_boxar( $atts ) {
    $atts = shortcode_atts( array(), $atts, 'pris_boxar' );
    ob_start();
    ?>
    <div class="container alignfull pu-darkblue-bg pt-4 pb-4 mb-4">
        <h2 class="pt-4 pb-4 text-white text-center"><strong>PRISER</strong></h2>
        <div class="container ps-0 pe-0 ps-md-3 pe-md-3">
            <div class="row">
                <div class="col pe-md-1 mb-4">
                    <div class="pu-warmyellow-bg pt-2 pb-2"></div>
                    <div class="pu-lightblue-bg mt-2 p-4 clearfix text-white">
                        <div class="container d-flex h-100 p-0">
                            <div class="row">
                                <h3>Banhyra Dagtid</h3>
                                <p>Gäller vardagar 06.00 – 17.00<br />
                                  400 kr/tim<br />
                                  360 kr/tim Plusmedlemmar</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col pe-md-1 mb-4">
                    <div class="pu-warmyellow-bg pt-2 pb-2"></div>
                    <div class="pu-lightblue-bg mt-2 p-4 clearfix text-white">
                        <div class="container d-flex h-100 p-0">
                            <div class="row">
                                <h3>Banhyra Kväll & Helg</h3>
                                <p>Gäller vardagar 06.00 – 17.00<br />
                                  400 kr/tim<br />
                                  360 kr/tim Plusmedlemmar</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col pe-md-1 mb-4">
                    <div class="pu-warmyellow-bg pt-2 pb-2"></div>
                    <div class="pu-lightblue-bg mt-2 p-4 clearfix text-white">
                        <div class="container d-flex h-100 p-0">
                            <div class="row">
                                <h3>Abonnemang</h3>
                                <p>Gäller vardagar 06.00 – 17.00<br />
                                  400 kr/tim<br />
                                  360 kr/tim Plusmedlemmar</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <p class="text-white text-center">Hyra av racket kostar 40 kr/tillfälle</p>
    </div>
    <?php
    $content = ob_get_clean();
    return $content;
}
add_shortcode( 'pris_boxar', __NAMESPACE__ . '\pris_boxar' );