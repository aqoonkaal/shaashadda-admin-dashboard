<?php
/**
* Faylka maaraynta shaashadda  
*/

class SHAD_Admin_Dashboard_Customization {

    /*******************************************
    * Constructor
    *******************************************/
  
    function __construct() {

        //register an activation hook to add user role
        register_activation_hook( SHAD_PLUGIN_FILE, array( &$this, 'add_role' ) );

        // Add custom styles to login page
        add_action( 'login_head', array( &$this, 'shad_login_styles' ) );
    
        // Change login logo's title
        add_filter( 'login_headertitle', array( &$this,'shad_login_header_title' ) );

        // Change login logo's URL it links to
        add_filter( 'login_headerurl', array( &$this, 'shad_login_header_url' ) );

        // Add custom message above login form
        add_filter( 'login_message', array( &$this, 'shad_login_message' ) );

        // Add or remove widgets from dashboard
        add_action( 'wp_dashboard_setup', array( &$this, 'shad_dashboard_setup' ) );

        // Add favicon to the admin dashboard
        add_action( 'login_head', array( &$this, 'shad_admin_favicon' ) );
        add_action( 'admin_head', array( &$this, 'shad_admin_favicon' ) );

        //Add custom stylesheet to the admin dashboard
        add_action( 'admin_enqueue_scripts', array( &$this, 'shad_admin_style' ) );

        //Add custom footer text to dashboard
        add_filter( 'admin_footer_text', array( &$this, 'shad_admin_footer_text' ) );
     
        // Add custom link to admin bar
        add_action( 'wp_before_admin_bar_render', array( &$this, 'shad_custom_link_admin_bar' ) );

        // Dashboard ka masax howdy
        add_filter( 'admin_bar_menu', array( &$this, 'shad_replace_howdy' ), 25 );

        // Add quicktags to editor
        add_action( 'admin_print_footer_scripts', array( &$this, 'add_quick_tags') );

        // Register editor callback filter
        add_filter( 'mce_buttons_2', array( &$this, 'shad_mce_buttons_2') );

        // Attach callback to 'tiny_mce_before_init'
        add_filter( 'tiny_mce_before_init', array( &$this, 'shad_mce_before_init_formats') );

        // Add custom stylesheet to the website front-end with hook 'wp_enqueue_scripts'  
        add_action( 'wp_enqueue_scripts', array( &$this, 'shad_mce_style_editor_enqueue') );

        // No admin login errors
        add_filter( 'login_errors', array( &$this, 'shad_no_admin_login_errors' ) );

        // remove unncessary header info
        add_action('init', array( &$this, 'shad_remove_header_info' ) );

        // Remove ?ver number on the end of CSS and JS files
        add_filter( 'script_loader_src', array( &$this, 'shad_remove_script_version'), 15, 1 );
        add_filter( 'style_loader_src', array( &$this, 'shad_remove_script_version'), 15, 1 );

        //
        add_filter( 'user_contactmethods', array( &$this, 'shad_contact_methods'), 10,1 );

        // Settings functions
        //add_action('admin_init', array( &$this, 'settings_api_init') );
    }

    /*******************************************
    * Add a new role on plugin activation
    *******************************************/
    function add_role() {
        $capabilities = array(
            'read' => true, 
            'edit_posts' => true,
            'delete_posts' => false
        );
        add_role( 'basic_contributor', 'Basic Contributor', $capabilities );
    }

     
    /*******************************************
    * LOGIN PAGE
    *******************************************/
    
    /*
     * Add custom stylesheet to login page
     */
     function shad_login_styles() {  
        wp_enqueue_style( 'shad-login-styles', SHAD_PLUGIN_URL . 'css/shad-login-styles.css' ); 
    }

    /*
     * Change login logo's title
     */
    function shad_login_header_title( $title ) {
      return 'Booqo bogga hore';
    }
    
    /*
     * Change login logo's URL it links to
     */
    function shad_login_header_url( $url ) {
      return home_url();
    }
   
    /*
     * Add custom message above login form
     */
    function shad_login_message( $message ) {
      return '<p class="message">Waa barta laga galo qaybta hagidda webka.</p>';
    }    

     
    /*******************************************
    * ADMIN DASHBOARD
    *******************************************/
    function shad_dashboard_setup() {
        // add our dashboard widget
        wp_add_dashboard_widget( 'shad_dashboard_widget', 
            'Shaashadda Dashboard Widget', 
            array( &$this, 'dashboard_widget_output' ) );
        
        // remove undesired widgets
        remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
        remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );

    }
    
    function dashboard_widget_output() {
        echo 'Kusoo dhawaada shaashadda laga maareeyo websiteka <a href="http://' .  home_url() . '">' . get_bloginfo('name') . '</a>';        
    }

    /*
     * Add favicon to the admin dashboard
     */
    function shad_admin_favicon() { 
      ?>
      <link rel="shortcut icon" href="<?php echo SHAD_PLUGIN_URL; ?>/css/images/favicon.png" />
      <?php
    }

    /*
     * Add custom stylesheet to the admin dashboard
     */
    function shad_admin_style() {
      wp_enqueue_style( 'shad-admin-styles', SHAD_PLUGIN_URL . 'css/shad-admin-styles.css' );
    }

    /*
     * Add custom footer text to dashboard
     */
    function shad_admin_footer_text( $text ) {
      return '&copy; <a href="http://' . home_url() . '">' . get_bloginfo('name') . '</a> | Powered by <a href="http://wordpress.org/">WordPress.</a>';
    }

    /*
     * Add custom link to admin bar
     */
    function shad_custom_link_admin_bar() {
      global $wp_admin_bar;
      $wp_admin_bar->add_menu( array(
        'id'    => 'google_analytics',
        'title' => 'Analytics',
        'href'  => 'http://google.com/analytics/'
      ) );
    }


    /**
    * Shaashadda Dashboardka WordPress ka masax howdy
    */
    function shad_replace_howdy( $wp_admin_bar ) {
       $my_account=$wp_admin_bar->get_node('my-account');
       $newtitle = str_replace( 'Howdy,', 'soo dhawaada,', $my_account->title );
       $wp_admin_bar->add_node( array(
       'id' => 'my-account',
       'title' => $newtitle,
       ) );
    }
    

    /*******************************************
    * Add quicktags to editor
    *******************************************/
     /**
     * QTags.addButton( id, display, arg1, arg2, access_key, title, priority, instance );
     */
    
    function add_quick_tags() {
    ?>
        <script type="text/javascript">
        QTags.addButton( 'shad_paragraph', 'p', '<p>', '</p>', 'p', 'p', 1 );
        QTags.addButton( 'shad_hr', 'hr', '<hr />', '', 'h', 'hr', 201 );
        </script>
    <?php
    }

    /*******************************************
    * Add styles to MCE editor
    *******************************************/
    /**
    * Callback function to insert 'styleselect' into the $buttons array
    */
    function shad_mce_buttons_2( $buttons ) {
      array_unshift( $buttons, 'styleselect' );
      return $buttons;
    }

    /**
    * Callback function to filter the MCE settings
    * Add styles/classes to the "Styles" drop-down 
    */  
    function shad_mce_before_init_formats( $init_array ) { 
      // Define the style_formats array
      $style_formats = array( 
        // Each array is a format with it's own settings
         array( 
            'title' => 'Yellow Box',
            'block' => 'div',
            'classes' => 'yellow-box',
            'wrapper' => true
        ),
        array( 
            'title' => 'Red Box',
            'block' => 'div',
            'classes' => 'red-box',
            'wrapper' => true
        ),
         array( 
            'title' => 'Blue Box',
            'block' => 'div',
            'classes' => 'blue-box',
            'wrapper' => true
        ),
         array(  
            'title' => 'External Link',  
            'selector' => 'a',  
            'classes' => 'external-link'  
            ), 
      );
      // Insert the array, JSON ENCODED, into 'style_formats'
      $init_array['style_formats'] = json_encode( $style_formats );      
      return $init_array;      
    }

    /* 
     * Enqueue stylesheet 
     */  
    function shad_mce_style_editor_enqueue() {  
        wp_enqueue_style( 'shad-styles', SHAD_PLUGIN_URL . 'css/shad-editor-styles.css' ); 
    }

    /*******************************************
    * No Admin Login Error
    *******************************************/
    function shad_no_admin_login_errors(){
    return 'Bal si fiican u feker waxbaa khaldamaye !!';
    }

    /*******************************************
    *  Remove unncessary header info
    *******************************************/
    function shad_remove_header_info() {   
        remove_action( 'wp_head', 'feed_links', 2 );
        remove_action( 'wp_head', 'feed_links_extra', 3);
        remove_action( 'wp_head', 'rsd_link');
        remove_action( 'wp_head', 'wlwmanifest_link');
        remove_action( 'wp_head', 'wp_generator');
        remove_action( 'wp_head', 'start_post_rel_link');
        remove_action( 'wp_head', 'index_rel_link'); 
        remove_action( 'wp_head', 'rel_canonical');
        remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );
        remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
    }

    /*******************************************
    *  Remove ?ver number on the end of CSS and JS files
    *******************************************/
    function shad_remove_script_version( $src ){
      $parts = explode( '?ver', $src );
            return $parts[0];
    }

    /*******************************************
    *  AUTHORS Contact Info
    *******************************************/

    function shad_contact_methods( $contactmethods ) {
        // Remove we fields you do not want
        unset( $contactmethods[ 'aim' ] );
        unset( $contactmethods[ 'yim' ] );
        unset( $contactmethods[ 'jabber' ] );
        // Add some useful contact fields
        $contactmethods[ 'twitter' ] = 'Twitter URL';
        $contactmethods[ 'facebook' ] = 'Facebook URL';
        $contactmethods[ 'linkedin' ] = 'LinkedIn URL';
        $contactmethods[ 'googleplus' ] = 'Google+ URL';
        $contactmethods[ 'youtube' ] = 'Youtube URL';
        return $contactmethods;
    }


    /*******************************************
    * Settings functions
    *******************************************/
    // function settings_api_init() {
         
    //      add_settings_section('shad_setting_section',
    //         'Shaashadda Settings Section ',
    //         array( &$this, 'shad_settings_section_callback' ),
    //         'general');
         
    //      add_settings_field('shad_setting_name',
    //         'Shaashadda Setting Name',
    //         array( &$this, 'shad_settings_callback' ),
    //         'general',
    //         'shad_setting_section');
         
    //      register_setting('general','shad_setting_name');
    //  }
     
    //  function shad_settings_section_callback() {
    //      echo '<p>This is the introduction to the settings section.</p>';
    //  }
     
    //  function shad_settings_callback() {
    //      echo '<input name="shad_setting_name" id="shad_setting_name" type="checkbox" value="1" class="code" ' . checked( 1, get_option('shad_setting_name'), false ) . ' /> Shaashadda setting details';
    //  }

    
  
} // end class
new SHAD_Admin_Dashboard_Customization();