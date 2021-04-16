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
        'order' => 'DESC',
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
            <h2 class="text-white"><strong>VÄLJ OMRÅDE</strong></h2>
        </div>
        <div class="container ps-0 pe-0 ps-md-3 pe-md-3">
            <div class="row">
                <?php 
                while($omrade_pages->have_posts()) {
                $omrade_pages->the_post(); ?>
                <div class="col-md-4 pe-md-1">
                    <div class="pu-warmyellow-bg pt-2 pb-2"></div>
                    <div class="pu-lightblue-bg mt-2 p-4 clearfix text-white ">
                        <div class="container d-flex h-100 p-0">
                            <div class="row">
                                <div class="col-3">
                                    <img class="img-fluid" src="<?php echo asset_path('images/footer-logo.png') ?>" alt="Padel United Logga" />
                                </div>
                                <div class="col-9 justify-content-center align-self-center">
                                    <h3>Se våra hallar i <?= the_title() ?></h3>
                                </div>
                            </div>
                        </div>
                        <p><?= get_the_excerpt() ?></p>
                        <button class="btn btn-primary float-end">Se Hallar <i class="fas fa-arrow-circle-right"></i></button>
                    </div>
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
add_shortcode( 'omrades_excerpt_boxar', __NAMESPACE__ . '\omrades_excerpt_boxar' );

//Visa generella ikoner för hela Padel United
function visa_generella_ikoner( $atts ) {
    global $post;
    $atts = shortcode_atts( array(), $atts, 'visa_generella_ikoner' );
    ob_start();
    ?>
    <div class="container alignfull pu-darkblue-bg pt-4 pb-4">
        <div class="text-center text-white">
            <h2><strong>VÅRT HJÄRTA SLÅR FÖR PADEL</strong></h2>
        </div>
        <div class="container text-white ps-0 pe-0 ps-md-3 pe-md-3">
            <div class="row">
            <p>Padel är en fantastisk sport som alla kan utöva – oavsett erfarenhet eller spelnivå. På Padel United erbjuder vi spel för såväl nybörjare som elitspelare, för barn, ungdomar, vuxna och pensionärer och varje padelhall erbjuder också banor för handikappade där man kan komma in med rullstol. Har du aldrig spelat padel förut är du varmt välkommen till någon av våra anläggningar – vi kan garantera ett personligt bemötande och en rolig stund på banan. Välkommen till Padel United!</p>
            </div>
        </div>
        <div class="container ps-0 pe-0 ps-md-3 pe-md-3 text-white text-center w-75">
            <div class="row">
                <div class="col-6 col-md-3 p-md-4 pb-4">
                    <img src="<?php echo asset_path('images/icons/vpt_underlag.png') ?>" alt="VPT Underlag" class="img-fluid pb-2" />
                    <h5>VTP-underlag: Mondo super court XN</h5>
                </div>
                <div class="col-6 col-md-3 p-md-4 pb-4">
                    <img src="<?php echo asset_path('images/icons/panorama_glas.png') ?>" alt="Panorama glas på alla banor" class="img-fluid pb-2" />
                    <h5>Panorama glas på alla banor</h5>
                </div>
                <div class="col-6 col-md-3 p-md-4 pb-4">
                    <img src="<?php echo asset_path('images/icons/optimal_ljudisolering.png') ?>" alt="Optimal ljudisolering" class="img-fluid pb-2" />
                    <h5>Optimal ljudisolering</h5>
                </div>
                <div class="col-6 col-md-3 p-md-4 pb-4">
                    <img src="<?php echo asset_path('images/icons/belysning.png') ?>" alt="Skräddarsydd belysning" class="img-fluid pb-2" />
                    <h5>Skräddasydd belysning</h5>
                </div>
                <div class="col-6 col-md-3 p-md-4 pb-4">
                    <img src="<?php echo asset_path('images/icons/trivsam_luftig_miljo.png') ?>" alt="Trivsam luftig miljö" class="img-fluid pb-2" />
                    <h5>Trivsam luftig miljö</h5>
                </div>
                <div class="col-6 col-md-3 p-md-4 pb-4">
                    <img src="<?php echo asset_path('images/icons/barn_och_ungdom.png') ?>" alt="Barn & Ungdoms verksamhet" class="img-fluid pb-2" />
                    <h5>Barn & ungdoms verksamhet</h5>
                </div>
                <div class="col-6 col-md-3 p-md-4 pb-4">
                    <img src="<?php echo asset_path('images/icons/elittranare.png') ?>" alt="Elittränare" class="img-fluid pb-2" />
                    <h5>Elittränare</h5>
                </div>
                <div class="col-6 col-md-3 p-md-4 pb-4">
                    <img src="<?php echo asset_path('images/icons/lounge.png') ?>" alt="Lounge" class="img-fluid pb-2" />
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
    <div class="container alignfullmobile p-0 mb-4">
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
                <a href="<?php echo(get_theme_mod('medlemskaps_link')) ?>" target="_blank" class="btn btn-huge btn-primary">Bli medlem nu</a>
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
    <div class="container w-75 pt-md-4 pb-md-4 ps-0 pe-0">
		<div class="row text-center pu-darkblue">
			<div class="col-4">
                <img src="<?php echo asset_path('images/icons/tak_hojd.png') ?>" alt="Tak Höjd" class="w-160" />
                <h2 class="h1 mb-0"><strong><?php echo get_post_meta(get_the_ID(), 'tak_hojd', true) ?>m</strong></h2><h5>Tak Höjd</h5>
            </div>
			<div class="col-4">
                <img src="<?php echo asset_path('images/icons/banor.png') ?>" alt="Banor" class="w-160" />
                <h2 class="h1 mb-0"><strong><?php echo get_post_meta(get_the_ID(), 'antal_banor', true) ?></strong></h2><h5>Banor</h5>
            </div>
			<div class="col-4">
                <img src="<?php echo asset_path('images/icons/fri_parkering.png') ?>" alt="Fri Parkering" class="w-160" />
                <h2 class="h1 mb-0"><strong>Fri</strong></h2><h5>Parkering</h5>
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