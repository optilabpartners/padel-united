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

add_shortcode( 'lakemedel', function($atts) {
    $atts = shortcode_atts(
        array(
          'text' => "Behandla med receptfria läkemedel"
        ),
        $atts,
        'lakemedel'
        );
    ob_start();
    ?>
    <div class="text-center pb-3"><a class="btn btn-primary" onclick="javascript: trackBrokerLink('Behandling'); return true;" href="/go/behandla/" target="_blank" rel="nofollow"><?=$atts['text']?></a></div>
    <?php return ob_get_clean();
});

add_shortcode( 'lakarvard', function($atts) {
    $atts = shortcode_atts(
        array(
            'text' => "Sök läkarvård"
        ),
        $atts,
        'lakarvard'
        );
    ob_start();
    ?>
    <div class="text-center pb-3"><a class="btn btn-primary" onclick="javascript: trackBrokerLink('Läkarvård'); return true;" href="/go/doktor/" target="_blank" rel="nofollow"><?=$atts['text']?></a></div>
    <?php return ob_get_clean();
});

// Add job role
add_action( 'show_user_profile', __NAMESPACE__ . '\\custom_user_profile_fields' );
add_action( 'edit_user_profile', __NAMESPACE__ . '\\custom_user_profile_fields' );
function custom_user_profile_fields( $user ) {
    ?>
	<table class="form-table">
		<tr>
			<th><label for="company"><?php _e("Company"); ?></label></th>
			<td>
				<input type="text" name="company" id="company" class="regular-text" value="<?php echo esc_attr( get_the_author_meta( 'company', $user->ID ) ); ?>" /><br />
        		<span class="description"><?php _e("Please enter a company"); ?></span>
			</td>
		</tr>
		<tr>
			<th><label for="company_title"><?php _e("Company Title"); ?></label></th>
			<td>
				<input type="text" name="company_title" id="company_title" class="regular-text" value="<?php echo esc_attr( get_the_author_meta( 'company_title', $user->ID ) ); ?>" /><br />
        		<span class="description"><?php _e("Please enter a company title"); ?></span>
			</td>
		</tr>
  </table>
<?php
}

add_action( 'personal_options_update', __NAMESPACE__ . '\\save_custom_user_profile_fields' );
add_action( 'edit_user_profile_update', __NAMESPACE__ . '\\save_custom_user_profile_fields' );
function save_custom_user_profile_fields( $user_id ) {
  if ( current_user_can( 'edit_user', $user_id ) ) {
    update_user_meta( $user_id, 'company', $_POST['company'] );
  }
  if ( current_user_can( 'edit_user', $user_id ) ) {
      update_user_meta( $user_id, 'company_title', $_POST['company_title'] );
  }
  return true;
}

//Short code for conversion buttons to be used on pages and posts
function cta_buttons( $atts ) {
    $atts = shortcode_atts( array(
        'cta_button_one_text' => '',
        'cta_button_one_url' => '',
        'cta_button_two_text' => '',
        'cta_button_two_url' => ''
    ), $atts, 'cta_buttons' );
    ob_start();?>
    <div class="container">
    	<div class="row text-center">
    	<?php if ( $atts['cta_button_two_text'] != '' ) { ?>
    		<div class="col-md-6 mb-2">
    			<a href="<?php echo $atts['cta_button_one_url']?>" class="btn btn-primary" onclick="javascript: trackBrokerLink('Behandling'); return true;" target="_blank" rel="noopener nofollow"><?php echo $atts['cta_button_one_text']?></a>
    		</div>
    		<div class="col-md-6 mb-2">
    			<a href="<?php echo $atts['cta_button_two_url']?>" class="btn btn-primary" onclick="javascript: trackBrokerLink('Behandling'); return true;" target="_blank" rel="noopener nofollow"><?php echo $atts['cta_button_two_text']?></a>
    		</div>
    	<?php } else { ?>
    		<div class="col-md-12 mb-2">
    			<a href="<?php echo $atts['cta_button_one_url']?>" class="btn btn-primary" onclick="javascript: trackBrokerLink('Behandling'); return true;" target="_blank" rel="noopener nofollow"><?php echo $atts['cta_button_one_text']?></a>
    		</div>
    	<?php } ?>
    	</div>
    </div>
    <?php
    $content = ob_get_clean();
    return $content;
}

add_shortcode( 'cta_buttons', __NAMESPACE__ . '\\cta_buttons' );