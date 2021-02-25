<?php
/*
Plugin Name: SyntaxHighlighter Evolved: Google Apps Script
Description: Adds support for the Google Apps Script language to the SyntaxHighlighter Evolved plugin. This brush was originally created by Travis Whitton. It also includes a Google Developers inspired theme
Author: mhawksey
Version: 1.0
Author URI: https://hawksey.info
*/

 /**
 * Our main plugin instantiation class
 *
 * This contains important things that our relevant to
 * our add-on running correctly. Things like registering
 * custom post types, taxonomies, posts-to-posts
 * relationships, and the like.
 *
 * @since 1.0.0
 */
class SyntaxHighlighterGAS {
	public $depend = array('SyntaxHighlighter' => 'https://wordpress.org/plugins/syntaxhighlighter/');
	
	/**
	 * Get everything running.
	 *
	 * @since 1.0.0
	 */
	function __construct() {

		// Define plugin constants
		$this->basename       = plugin_basename( __FILE__ );
		$this->directory_url  = plugins_url( dirname( $this->basename ) );
		
		if ($this->meets_requirements()){
            // SyntaxHighlighter Evolved doesn't do anything until early in the "init" hook, so best to wait until after that
            add_action( 'init', array( $this, 'syntaxhighlighter_gas_regscript') );

            // Tell SyntaxHighlighter Evolved about this new language/brush
            add_filter( 'syntaxhighlighter_brushes', array( $this, 'syntaxhighlighter_gas_addlang') );

            // Register the Google Developers theme css
            add_action( 'wp_enqueue_scripts', array( $this,'googletheme_enqueue_styles') );

            // Register the Google Developers based Theme
            add_filter( 'syntaxhighlighter_themes', array( $this,'googletheme_function') ); 
		}
	} /* __construct() */
	
    /**
	 * Register the Google Developers theme css
	 *
	 * @since 1.0.0
	 */
    public function googletheme_enqueue_styles() { 
        wp_register_style( 'syntaxhighlighter-theme-googledev',
                            $this->directory_url .'/shThemeGoogleDev.css',
                            array( 'syntaxhighlighter-core' ), '1.0'); 
       }
    
    /**
	 * Register the Google Developers based theme
	 *
	 * @since 1.0.0
	 */
    public function googletheme_function( $themes ) {
        $themes['googledev'] = 'GoogleDev'; 
    return $themes;  }
    
    /**
	 * Register the brush file with WordPress
	 *
	 * @since 1.0.0
	 */
    public function syntaxhighlighter_gas_regscript() {
        wp_register_script( 'syntaxhighlighter-brush-gas', 
                            $this->directory_url . '/shBrushGoogleAppsScript.js', 
                            array( 'syntaxhighlighter-core' ), '1.0' );
    }
    
    /**
	 * Filter SyntaxHighlighter Evolved's language array
	 *
	 * @since 1.0.0
	 */
    public function syntaxhighlighter_gas_addlang( $brushes ) {
        $brushes['Google Apps Script'] = 'gas';
        $brushes['gas'] = 'gas';
        $brushes['gs'] = 'gas';
        return $brushes;
    }                                                                                       

	/**
	 * Activation hook for the plugin.
	 *
	 * @since 1.0.0
	 */
	public function activate() {
		// Do some activate things
	} /* activate() */

	/**
	 * Deactivation hook for the plugin.
	 *
	 * Note: this plugin may auto-deactivate due
	 * to $this->maybe_disable_plugin()
	 *
	 * @since 1.0.0
	 */
	public function deactivate() {

		// Do some deactivation things.

	} /* deactivate() */

	/**
	 * Check if BadgeOS is available
	 *
	 * @since  1.0.0
	 * @return bool True if BadgeOS is available, false otherwise
	 */
	public function meets_requirements() {
		foreach ($this->depend as $class => $url){ 
			if (!class_exists($class)){
				return false;	
			}
		}
		return true;
	} /* meets_requirements() */

	/**
	 * Potentially output a custom error message and deactivate
	 * this plugin, if we don't meet requriements.
	 *
	 * This fires on admin_notices.
	 *
	 * @since 1.0.0
	 */
	public function maybe_disable_plugin() {

		if ( ! $this->meets_requirements() ) {
			// Display our error
			echo '<div id="message" class="error">';
			foreach ($this->depend as $class => $url){ 
				if ( !class_exists($class)) {
					$extra = sprintf('<a href="%s">%s</a>', $url, $class); 
					echo '<p>' . sprintf( __( 'SyntaxHighlighter Evolved: Google Apps Script requires %s and has been <a href="%s">deactivated</a>. Please install and activate %s and then reactivate this plugin.', 'conferencer_addon' ),  $extra, admin_url( 'plugins.php' ), $extra ) . '</p>';
				}
			}
			echo '</div>';

			// Deactivate our plugin
			deactivate_plugins( $this->basename );
		}

	} /* maybe_disable_plugin() */

} 

// Start this plugin once all other plugins are fully loaded
add_action( 'init', 'SyntaxHighlighterGAS', 5 );
function SyntaxHighlighterGAS() {
	global $SyntaxHighlighterGAS;
	$SyntaxHighlighterGAS = new SyntaxHighlighterGAS();
}
