<?php
/**
 * Side Notes.
 *
 * @package   Side_Note

 * @license   GPL-2.0+
 * @link      http://example.com
 * @copyright 2014 Your Name or Company Name
 */

/**
 * Plugin class. This class should ideally be used to work with the
 * public-facing side of the WordPress site.
 *
 * If you're interested in introducing administrative or dashboard
 * functionality, then refer to `class-side-notes-admin.php`
 *
 * @TODO: Rename this class to a proper name for your plugin.
 *
 * @package Side_Note

 */
class Side_Note {

	/**
	 * Plugin version, used for cache-busting of style and script file references.
	 *
	 * @since   1.0.0
	 *
	 * @var     string
	 */
	const VERSION = '1.0.0';

	/**
	 * @TODO - Rename "side-notes" to the name your your plugin
	 *
	 * Unique identifier for your plugin.
	 *
	 *
	 * The variable name is used as the text domain when internationalizing strings
	 * of text. Its value should match the Text Domain file header in the main
	 * plugin file.
	 *
	 * @since    1.0.0
	 *
	 * @var      string
	 */
	protected $plugin_slug = 'side-notes';

	/**
	 * Instance of this class.
	 *
	 * @since    1.0.0
	 *
	 * @var      object
	 */
	protected static $instance = null;


	public $shortcode_counter = 0;

	/**
	 * Initialize the plugin by setting localization and loading public scripts
	 * and styles.
	 *
	 * @since     1.0.0
	 */
	private function __construct() {

		// Load plugin text domain
		add_action( 'init', array( $this, 'load_plugin_textdomain' ) );

		add_action( 'init', array( $this, 'add_shortcodes' ) );

		// Load public-facing style sheet and JavaScript.
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_styles' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );


	}

	/**
	 * Return the plugin slug.
	 *
	 * @since    1.0.0
	 *
	 * @return    Plugin slug variable.
	 */
	public function get_plugin_slug() {
		return $this->plugin_slug;
	}

	/**
	 * Return an instance of this class.
	 *
	 * @since     1.0.0
	 *
	 * @return    object    A single instance of this class.
	 */
	public static function get_instance() {

		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * Fired when the plugin is activated.
	 *
	 * @since    1.0.0
	 *
	 * @param    boolean    $network_wide    True if WPMU superadmin uses
	 *                                       "Network Activate" action, false if
	 *                                       WPMU is disabled or plugin is
	 *                                       activated on an individual blog.
	 */
	public static function activate( $network_wide ) {

		if ( function_exists( 'is_multisite' ) && is_multisite() ) {

			if ( $network_wide  ) {

				// Get all blog ids
				$blog_ids = self::get_blog_ids();

				foreach ( $blog_ids as $blog_id ) {

					switch_to_blog( $blog_id );
					self::single_activate();
				}

				restore_current_blog();

			} else {
				self::single_activate();
			}

		} else {
			self::single_activate();
		}

	}

	/**
	 * Fired when the plugin is deactivated.
	 *
	 * @since    1.0.0
	 *
	 * @param    boolean    $network_wide    True if WPMU superadmin uses
	 *                                       "Network Deactivate" action, false if
	 *                                       WPMU is disabled or plugin is
	 *                                       deactivated on an individual blog.
	 */
	public static function deactivate( $network_wide ) {

		if ( function_exists( 'is_multisite' ) && is_multisite() ) {

			if ( $network_wide ) {

				// Get all blog ids
				$blog_ids = self::get_blog_ids();

				foreach ( $blog_ids as $blog_id ) {

					switch_to_blog( $blog_id );
					self::single_deactivate();

				}

				restore_current_blog();

			} else {
				self::single_deactivate();
			}

		} else {
			self::single_deactivate();
		}

	}


	/**
	 * Get all blog ids of blogs in the current network that are:
	 * - not archived
	 * - not spam
	 * - not deleted
	 *
	 * @since    1.0.0
	 *
	 * @return   array|false    The blog ids, false if no matches.
	 */
	private static function get_blog_ids() {

		global $wpdb;

		// get an array of blog ids
		$sql = "SELECT blog_id FROM $wpdb->blogs
			WHERE archived = '0' AND spam = '0'
			AND deleted = '0'";

		return $wpdb->get_col( $sql );

	}

	/**
	 * Fired for each blog when the plugin is activated.
	 *
	 * @since    1.0.0
	 */
	private static function single_activate() {
		// @TODO: Define activation functionality here
	}

	/**
	 * Fired for each blog when the plugin is deactivated.
	 *
	 * @since    1.0.0
	 */
	private static function single_deactivate() {
		// @TODO: Define deactivation functionality here
	}

	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		$domain = $this->plugin_slug;
		$locale = apply_filters( 'plugin_locale', get_locale(), $domain );

		load_textdomain( $domain, trailingslashit( WP_LANG_DIR ) . $domain . '/' . $domain . '-' . $locale . '.mo' );
		load_plugin_textdomain( $domain, FALSE, basename( plugin_dir_path( dirname( __FILE__ ) ) ) . '/languages/' );

	}


	public function add_shortcodes() {
		/**
		 * commented out for now until later.
		 */
// 		add_shortcode( 'ref', array( $this, 'ref_shortcode' ) );
		add_shortcode( 'side-note', array( $this, 'side_note_shortcode' ) );

	}
	public function list_of_icons(){

		return array(
			'flag' 	=> 'icon-flag',
			'hot'	=> 'icon-fire',
			'fire'	=> 'icon-fire',
			'world'	=> 'icon-globe',
			'tint'	=> 'icon-tint',
			'note'  => 'icon-file-alt',
			'puzzle'=> 'icon-puzzle-piece',
			'clue'	=> 'icon-puzzle-piece',
			'lab'		=> 'icon-beaker',
			'experiment'=> 'icon-beaker',
			'try'		=> 'icon-beaker',
			'beaker'		=> 'icon-beaker',
			'book'		=> 'icon-book',
			'read'		=> 'icon-book',
			'reading'	=> 'icon-book',
			'certificate'		=> 'icon-certificate',
			'seal'		=> 'icon-certificate',
			'stamp'		=> 'icon-certificate',
			'lightbulb'		=> 'icon-lightbulb',
			'idea'		=> 'icon-lightbulb',
			'ideas'		=> 'icon-lightbulb',
			'key'		=> 'icon-key',
			'win'		=> 'icon-trophy',
			'trophy'	=> 'icon-trophy',
			'heart'		=> 'icon-heart',
			'love'		=> 'icon-heart',
			'group'		=> 'icon-group',
			'groups'	=> 'icon-group',
			'bell'		=> 'icon-bell',
			'video'		=> 'icon-facetime-video',
			'play'		=> 'icon-play',
			'youtube'	=> 'icon-youtube-alt'

			);

	}

	public function side_note_shortcode( $atts, $content ) {

		$this->shortcode_counter++;

		extract( shortcode_atts( array(
			'icon'  => 'note',
			'title' => '',
			'align'	=> 'left'

		), $atts ) );

		$in_array = array();

		if( is_array($atts) ) {
			foreach( $atts as $key => $attr_value ) {
				if( is_numeric( $key ) )
					$in_array[] = $attr_value;
			}
		}


		$collapsed  	= in_array( 'collapsed', $in_array   ) ? true : false;
		$collapsible 	= in_array( 'collapsible', $in_array ) ? true : false;

		$side_note_class = array( 'side-note' );

		if( 'right' == $align ){
			$side_note_class[] = 'side-note-right';
		}
		/**
		 * commented out this section for now.  Float right causes issues with text at times.  Dummy books don't have half either!
		 */
// 		if( in_array( 'half', $in_array ) )
// 			$side_note_class[] = 'side-note-half';



		if( $collapsed ) {
			$icon_data = ' data-toggle="collapse" data-target="#side-note-'.$this->shortcode_counter.'" ';
			$icon_class = ' side-note-expand collapsed ';
			$shell_class = 'collapse';
		} else {
			$icon_data = ' data-toggle="collapse" data-target="#side-note-'.$this->shortcode_counter.'" ';
			$icon_class = ' side-note-expand';
			$shell_class = ' collapse in ';
		}

		if( !$collapsible && !$collapsed ){
			$shell_class = $icon_class = $icon_data = '';
			//var_dump($this->shortcode_counter.': cleared'.$collapsible.$collapsed);
		}

		$icon = ( empty($icon) ? 'note': $icon );
		$title = ( !empty($title) ? $title : $icon );
		$icons = $this->list_of_icons();

		return '<div class="'.implode(' ', $side_note_class ).'"><div class="side-note-icon-wrap side-note-icon-wrap"><i class="side-note-icon '.$icons[$icon].$icon_class.'" '.$icon_data.'></i><span class="side-note-title">'.$title.'</span></div><div id="side-note-'.$this->shortcode_counter.'" class="side-note-content-wrap '.$shell_class.'"><span class="side-note-content-wrap-height"> </span>'.do_shortcode( $content ).'</div></div>';
	}
	/**
	 * Register and enqueue public-facing style sheet.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		wp_enqueue_style( $this->plugin_slug . '-plugin-styles', plugins_url( 'assets/css/public.css', __FILE__ ), array(), self::VERSION );
	}

	/**
	 * Register and enqueues public-facing JavaScript files.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		wp_enqueue_script( $this->plugin_slug . '-plugin-script', plugins_url( 'assets/js/public.js', __FILE__ ), array( 'jquery' ), self::VERSION );
	}

}
