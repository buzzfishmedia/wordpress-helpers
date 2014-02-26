<?php

namespace WordPress;

class Theme
{
	public $name;
	public $setup = array();
	public $init = array();
	public $scripts = array();

	public function __construct($name, $setup = array() )
	{
		$this->name = $name;
		if( ! empty( $setup ) ) {
			$this->themeSetup($setup);
		}

		add_action('init', array( $this, 'doThemeInit') );
		add_action('after_setup_theme', array( $this, 'doThemeSetup' ) );
		add_action('wp_enqueue_scripts', array( $this, 'doThemeScripts' ) );

	}

	

	public function doThemeInit()
	{
		$settings = $this->getThemeInit();

		// Content Width
		if( array_key_exists('content_width', $settings ) and $settings['content_width'] != "" ){
			if ( ! isset( $content_width ) ){
				$content_width = $settings['content_width'];
			} else {
				$content_width = 640;
			}
		}

	}

	public function themeInit( $args = array() )
	{
		$this->init = $args;
		return $this->init;
	}

	public function getThemeInit()
	{
		return $this->init;
	}

	/**
	 * Theme Setup
	 */
	public function doThemeSetup()
	{
		$setup = $this->getThemeSetup();

		// Theme Support
		if ( array_key_exists('theme_support', $setup ) and $setup['theme_support'] != "" ) {

			$supports = $setup['theme_support'];

			foreach ($supports as $feature => $value) {

				switch ( $feature ) {

					case 'automatic-feed-links':
						add_theme_support( 'automatic-feed-links' );
						break;

					case 'post-thumbnails':
						add_theme_support( 'post-thumbnails' );
						break;

					case 'post-formats':

						if( $value != "" ) {
							add_theme_support( 'post-formats', $value );
						} else {
							add_theme_support( 'post-formats' );
						}
						break;

					case 'custom-header':
						add_theme_support( 'custom-header' );
						break;

					case 'custom-background':

						if( $value != "" ) {
							add_theme_support( 'custom-background', $value );
						} else {
							add_theme_support( 'custom-background' );
						}
						break;

					case 'html5':
						if( $value != "" ) {
							add_theme_support( 'html5', $value );
						} else {
							add_theme_support( 'html5' );
						}
						break;

					default:
						# code...
						break;
				}
			}
		}

		// Nav Menus
		if ( array_key_exists('nav_menus', $setup ) and $setup['nav_menus'] != "" ) {

		    $navmenus = $setup['nav_menus'];

		    foreach ($navmenus as $menu) {
		        register_nav_menus( $menu );
		    }

		} else {
		    register_nav_menu( 'default-menu', 'Default Menu' );
		}
	}

	/**
	 * Set the values of "Setup"
	 */
	public function themeSetup($setup)
	{
		$this->setup = $setup;
		return $this->setup;
	}

	/**
	 * Get the values of "Setup"
	*/
	public function getThemeSetup()
	{
		return $this->setup;
	}

	public function doThemeScripts()
	{
		$scripts = $this->getThemeScripts();
		
		foreach ($scripts as $script) {

			// Vars
			$method = isset($script['method']) ? $script['method'] : 'enqueue';
			$location = isset($script['location']) ? $script['location'] : '';
			$deps = isset($script['dependencies']) ? $script['dependencies'] : array();
			$vers = isset($script['version']) ? $script['version'] : false;
			$admin = isset($script['admin']) ? $script['admin'] : false;

			// Check Type: Style
			if ($script['type'] == 'style') {

				// Check Method
				if ($method == 'register') {
					wp_register_style($script['name'], $location, $deps, $vers );
				} else {
					wp_enqueue_style($script['name'], $location, $deps, $vers );
				}
			}

			// Check Type: Script
			else {

				// Check Method
				if ($method == 'register') {
					wp_register_script($script['name'], $location, $deps, $vers );
				} else {
					wp_enqueue_script( $script['name'], $location, $deps, $vers );
				}
			}
		}

		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
	}

	public function themeScripts( $scripts = array() )
	{
		$this->scripts = $scripts;
		return $this->scripts;
	}

	public function getThemeScripts()
	{
		return $this->scripts;
	}




}