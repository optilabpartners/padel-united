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
    $atts = shortcode_atts( array(), $atts, 'visa_general_info' );
    ob_start();?>
    <div class="container w-75 pt-md-4 pb-md-4">
		<div class="row text-center pu-darkblue">
			<div class="col-6 col-md-3">
                <img src="<?php echo asset_path('images/icons/hallar.png') ?>" alt="Padel Hallar" class="img-fluid" />
                <h2 class="h1"><strong><?php echo get_theme_mod('antal_hallar') ?></strong></h2><h5>Hallar</h5>
            </div>
			<div class="col-6 col-md-3">
                <img src="<?php echo asset_path('images/icons/banor.png') ?>" alt="Banor" class="img-fluid" />
                <h2 class="h1"><strong><?php echo get_theme_mod('antal_banor') ?></strong></h2><h5>Banor</h5>
            </div>
			<div class="col-6 col-md-3">
                <img src="<?php echo asset_path('images/icons/turneringar.png') ?>" alt="Turneringar" class="img-fluid" />
                <h2 class="h1"><strong><?php echo get_theme_mod('antal_turneringar') ?></strong></h2><h5>Turneringar</h5>
            </div>
			<div class="col-6 col-md-3">
                <img src="<?php echo asset_path('images/icons/medlemmar.png') ?>" alt="Medlemmar" class="img-fluid" />
                <h2 class="h1"><strong><?php echo get_theme_mod('antal_medlemmar') ?></strong></h2><h5>Medlemmar</h5>
            </div>
		</div>
	</div>
    <?php
    $content = ob_get_clean();
    return $content;
}
add_shortcode( 'visa_general_info', __NAMESPACE__ . '\visa_general_info' );