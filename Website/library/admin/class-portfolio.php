<?php
if ( !class_exists('jvfrm_home_portpolio') ) :

    class jvfrm_home_portpolio {

		public static $instance = null;

		const SLUG = 'portfolio';
		const SLUGX = 'portfolio_%s';

        /**
        * @var  string  $prefix  The prefix for storing custom fields in the postmeta table
        */
        var $prefix = '_jvfrm_';
        /**
        * @var  array  $postTypes  An array of public custom post types, plus the standard "post" and "page" - add the custom types you want to include here
        */
        var $postTypes = array( 'portfolio' );
        /**
        * @var  array  $customFields  Defines the custom fields available
        */
        var $customFields = array(
            array(
                "name"          => "short-description",
                "title"         => "Short Description",
                "description"   => "",
                "type"          => "textarea",
                "scope"         =>   array( "portfolio" ),
                "capability"    => "edit_pages"
            ),
            array(
                "name"          => "creation-date",
                "title"         => "Date",
                "description"   => "Created date. ex) 01/01/2016 or 2016-01-01",
                "type"          =>   "text",
                "scope"         =>   array( "portfolio" ),
                "capability"    => "edit_posts"
            ),
            array(
                "name"          => "link-to",
                "title"         => "Link",
                "description"   => "Website link without 'http://' (ex: www.google.com)",
                "type"          =>   "text",
                "scope"         =>   array( "portfolio" ),
                "capability"    => "edit_posts"
            ),
            array(
                "name"          => "featured_portfolio",
                "title"         => "Featured Portfolio",
                "description"   => "Check if this portfolio is a featured one",
                "type"          => "checkbox",
                "scope"         =>   array( "portfolio" ),
                //"scope"         =>   array( "portfolio", "page" ),
                "capability"    => "manage_options"
            ),

			array(
                "name"          => "portfolio_detail_page_head_style",
                "title"         => "Head style",
                "description"   => "Select Layout Style",
                "type"          => "dropdown",
				'options' => Array(
					'Default ( Theme Setting )'		=> '',
					'Featured image with Title'		=> 'featured_image',
					'Title on the top'						=> 'title_on_top',
					'Title upper content'						=> 'title_upper_content'
				),
				"scope"         =>   array( "portfolio" ),
                "capability"    => "manage_options"
            ),

			array(
                "name"          => "portfolio_detail_page_layout",
                "title"         => "Layout Type",
                "description"   => "Select Layout Style",
                "type"          => "dropdown",
				'options' => Array(
					'Default ( Theme Setting )'		=> '',
					'Fullwidth Content After'		=> 'fullwidth-content-after',
					'Fullwidth Content Before'		=> 'fullwidth-content-before',
					'Right Sider'						=> 'right-sidebar',
				),
				"scope"         =>   array( "portfolio" ),
                "capability"    => "manage_options"
            ),
        );
        /**
        * PHP 4 Compatible Constructor
        */
        //function jvfrm_home_portpolio() { $this->__construct(); }
        /**
        * PHP 5 Constructor
        */
		public function __construct() {
			$this->register_hooks();
			$this->custom_pageSettings();
		}

		public function register_hooks() {

			add_action( 'init', Array( $this, 'registerPortfolio' ) );
			add_action( 'init', Array( $this, 'registerPortfolioTaxonomy' ) );

			add_action( 'save_post', array( &$this, 'saveCustomFields' ), 1, 2 );

			// Comment this line out if you want to keep default custom fields meta box
			add_action( 'do_meta_boxes', array( &$this, 'removeDefaultCustomFields' ), 10, 3 );

		}

		public function custom_pageSettings(){
			add_filter( 'jvfrm_home_admin_page_options', Array( $this, 'page_setting_add_portfolio' ) );

		}

		public function registerPortfolio() {
			$labels = array(
				'name' => 'Portfolio',
				'singular_name' => 'Portfolio',
				'add_new' => 'Add New Portfolio',
				'add_new_item' => 'Add New Portfolio',
				'edit_item' => 'Edit Portfolio',
				'new_item' => 'New Portfolio',
				'all_items' => 'All Portfolio',
				'view_item' => 'View Portfolio',
				'search_items' => 'Search Portfolio',
				'not_found' =>  'No Portfolio Found',
				'not_found_in_trash' => 'No Portfolio found in Trash',
				'parent_item_colon' => '',
				'menu_name' => 'Portfolio',
			);
			register_post_type(
				self::SLUG,
				array(
					'labels' => $labels,
					'has_archive' => true,
					'public' => true,
					'supports' => array( 'title', 'editor', 'excerpt', 'custom-fields', 'thumbnail','page-attributes' ),
					// 'taxonomies' => array( 'portfolio_category', 'portfolio_tag' ),
					'exclude_from_search' => false,
					'capability_type' => 'post',
					'rewrite' => array( 'slug' => 'portfolios' ),
				)
			);
		}

		public function registerPortfolioTaxonomy() {
			register_taxonomy(
				sprintf( self::SLUGX, 'category' ),
				self::SLUG,
				array(
					'labels' => array(
					'name' => 'Portofolio Category',
					'add_new_item' => 'Add New Category',
					'new_item_name' => "New Category"
				),
				'show_ui' => true,
				'show_tagcloud' => false,
				'hierarchical' => true
				)
			);

			register_taxonomy(
				sprintf( self::SLUGX, 'tag' ),
				self::SLUG,
				array(
					'labels' => array(
						'name' => 'Portofolio Tag',
						'add_new_item' => 'Add New Tag',
						'new_item_name' => "New Tag"
					),
					'show_ui' => true,
					'show_tagcloud' => false,
					'hierarchical' => true
				)
			);
		}


		public function page_setting_add_portfolio( $settings=Array() ){
			$settings[ 'page-option-portfolio' ] = Array(
				'label'						=> esc_html__( "Portfolio Setup", 'javohome' ),
				'icon'						=> 'fa fa-camera',
				'post_type'				=> Array( self::SLUG ),
			);

			if( isset( $settings[ 'page-option-navi' ] )  && isset( $settings[ 'page-option-navi' ][ 'post_type' ] ) )
				$settings[ 'page-option-navi' ][ 'post_type' ][] = self::SLUG;
			return $settings;
		}

        /**
        * Remove the default Custom Fields meta box
        */
        function removeDefaultCustomFields( $type, $context, $post ) {
            foreach ( array( 'normal', 'advanced', 'side' ) as $context ) {
                foreach ( $this->postTypes as $postType ) {
                    remove_meta_box( 'postcustom', $postType, $context );
                }
            }
        }
        /**
        * Create the new Custom Fields meta box
        */
        function createCustomFields() {
            if ( function_exists( 'add_meta_box' ) ) {
                foreach ( $this->postTypes as $postType ) {
                    add_meta_box( 'jvfrm-post-custom-fields', 'Additional information', array( &$this, 'displayCustomFields' ), $postType, 'normal', 'high' );
                }
            }
        }

        /**
        * Display the new Custom Fields meta box
        */
        function displayCustomFields() {
            global $post;
            ?>
            <div class="form-wrap">
                <?php
                wp_nonce_field( 'jvfrm-post-custom-fields', 'jvfrm-post-custom-fields_wpnonce', false, true );
                foreach ( $this->customFields as $customField ) {
                    // Check scope
                    $scope = $customField[ 'scope' ];
                    $output = false;
                    foreach ( $scope as $scopeItem ) {
                        switch ( $scopeItem ) {
                            default: {
                                if ( $post->post_type == $scopeItem )
                                    $output = true;
                                break;
                            }
                        }
                        if ( $output ) break;
                    }
                    // Check capability
                    if ( !current_user_can( $customField['capability'], $post->ID ) )
                        $output = false;
                    // Output if allowed
                    if ( $output ) { ?>
                        <div class="form-field form-required">
                            <?php
                            switch ( $customField[ 'type' ] ) {
                                case "checkbox": {
                                    // Checkbox
                                    echo '<div class="jvfrm_ctm_label"><label for="' . $this->prefix . $customField[ 'name' ] .'" style="display:inline;"><b>' . $customField[ 'title' ] . '</b></label>';
									if ( $customField[ 'description' ] ) echo '<p>' . $customField[ 'description' ] . '</p>';
									echo '</div>';
                                    echo '<div class="jvfrm_ctm_field"><input type="checkbox" name="' . $this->prefix . $customField['name'] . '" id="' . $this->prefix . $customField['name'] . '" value="yes"';
                                    if ( get_post_meta( $post->ID, $this->prefix . $customField['name'], true ) == "yes" )
                                        echo ' checked="checked"';
                                    echo '" style="width: auto;" />';
									echo '</div>';
                                    break;
                                }
								case "dropdown": {
                                    // Dropdown
                                    echo '<div class="jvfrm_ctm_label"><label for="' . $this->prefix . $customField[ 'name' ] .'" style="display:inline;"><b>' . $customField[ 'title' ] . '</b></label>';
									if ( $customField[ 'description' ] ) echo '<p>' . $customField[ 'description' ] . '</p>';
									echo '</div>';
									echo '<div class="jvfrm_ctm_field">';
									echo '<select name="' . $this->prefix . $customField[ 'name' ] .'">';
									foreach( $customField['options'] as $label => $value )
									{
										printf( "<option value='{$value}' %s>{$label}</option>", selected( $value == get_post_meta( $post->ID, $this->prefix . $customField['name'], true), true, false ) );
									}
									echo '</select>';
									echo '</div>';
                                    break;
                                }
                                case "textarea":
                                case "wysiwyg": {
                                    // Text area
                                    echo '<div class="jvfrm_ctm_label"><label for="' . $this->prefix . $customField[ 'name' ] .'"><b>' . $customField[ 'title' ] . '</b></label></div>';
                                    echo '<div class="jvfrm_ctm_field"><textarea name="' . $this->prefix . $customField[ 'name' ] . '" id="' . $this->prefix . $customField[ 'name' ] . '" columns="30" rows="3">' . htmlspecialchars( get_post_meta( $post->ID, $this->prefix . $customField[ 'name' ], true ) ) . '</textarea>';
                                    // WYSIWYG
                                    if ( $customField[ 'type' ] == "wysiwyg" ) { ?>
                                        <script type="text/javascript">
                                            jQuery( document ).ready( function() {
                                                jQuery( "<?php echo $this->prefix . $customField[ 'name' ]; ?>" ).addClass( "mceEditor" );
                                                if ( typeof( tinyMCE ) == "object" && typeof( tinyMCE.execCommand ) == "function" ) {
                                                    tinyMCE.execCommand( "mceAddControl", false, "<?php echo $this->prefix . $customField[ 'name' ]; ?>" );
                                                }
                                            });
                                        </script>
                                    <?php }
									echo '</div>';
                                    break;
                                }
                                default: {
                                    // Plain text field
                                    echo '<div class="jvfrm_ctm_label"><label for="' . $this->prefix . $customField[ 'name' ] .'"><b>' . $customField[ 'title' ] . '</b></label></div>';
                                    echo '<div class="jvfrm_ctm_field"><input type="text" name="' . $this->prefix . $customField[ 'name' ] . '" id="' . $this->prefix . $customField[ 'name' ] . '" value="' . htmlspecialchars( get_post_meta( $post->ID, $this->prefix . $customField[ 'name' ], true ) ) . '" />';
									echo '</div>';
                                    break;
                                }
                            }
                            ?>
                            <?php if ( $customField[ 'description' ] ) echo '<p>' . $customField[ 'description' ] . '</p>'; ?>
                        </div>
                    <?php
                    }
                } ?>
            </div>
            <?php
        }
        /**
        * Save the new Custom Fields values
        */
        function saveCustomFields( $post_id, $post ) {
            if ( !isset( $_POST[ 'jvfrm-post-custom-fields_wpnonce' ] ) || !wp_verify_nonce( $_POST[ 'jvfrm-post-custom-fields_wpnonce' ], 'jvfrm-post-custom-fields' ) )
                return;
            if ( !current_user_can( 'edit_post', $post_id ) )
                return;
            if ( ! in_array( $post->post_type, $this->postTypes ) )
                return;
            foreach ( $this->customFields as $customField ) {
                if ( current_user_can( $customField['capability'], $post_id ) ) {
                    if ( isset( $_POST[ $this->prefix . $customField['name'] ] ) && trim( $_POST[ $this->prefix . $customField['name'] ] ) ) {
                        $value = $_POST[ $this->prefix . $customField['name'] ];
                        // Auto-paragraphs for any WYSIWYG
                        if ( $customField['type'] == "wysiwyg" ) $value = wpautop( $value );
                        update_post_meta( $post_id, $this->prefix . $customField[ 'name' ], $value );
                    } else {
                        delete_post_meta( $post_id, $this->prefix . $customField[ 'name' ] );
                    }
                }
            }
        }

		public static function getInstance() {
			if( is_null( self::$instance ) )
				self::$instance = new self;
			return self::$instance;
		}

    } // End Class

endif; // End if class exists statement

// Instantiate the class
if( !function_exists( 'jvfrm_home_folio' ) ) : function jvfrm_home_folio() {
	return jvfrm_home_portpolio::getInstance();
} jvfrm_home_folio(); endif;