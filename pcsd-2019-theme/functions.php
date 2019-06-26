<?php
/*==========================================================================================
Add stylesheet to enqueue
============================================================================================*/
function theme_specific_stylesheet() {
	/*   REGISTER ALL JS FOR SITE */
	wp_register_script( '404easterEgg', get_template_directory_uri() .'/assets/js/404.js', '', '', true );

	/*   CALL ALL CSS AND SCRIPTS FOR SITE */
	wp_enqueue_style( 'parent-style', get_stylesheet_uri(), '', '1.5', false);
	wp_enqueue_script('slick-script', get_template_directory_uri() .'/assets/slick/slick.min.js', array('jquery'), null, true);
	wp_enqueue_script('my-custom-scripts', get_template_directory_uri() .'/assets/js/scripts.js', array('jquery', 'slick-script',), '1.0.1', true);
	if ( is_404() ) {
		wp_enqueue_script( '404easterEgg');
	}
}
add_action('wp_enqueue_scripts', 'theme_specific_stylesheet', 9999);
/*==========================================================================================
Remove Version Number from WP
============================================================================================*/
remove_action('wp_head', 'wp_generator');
function wpt_remove_version() {
   return '';
}
add_filter('the_generator', 'wpt_remove_version');

function wpbeginner_remove_version() {
	return '';
}
add_filter('the_generator', 'wpbeginner_remove_version');

/*==========================================================================================
// REMOVE WP EMOJI
============================================================================================*/
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );
/*==========================================================================================
// Enable Featured Images
============================================================================================*/
add_theme_support( 'post-thumbnails' );

/*==========================================================================================
removes the welcome panel from the dashboard page since
most users cant do the things it references anyway
============================================================================================*/
function pcsd_auto_hide_welcome() {
	remove_action( 'welcome_panel', 'wp_welcome_panel' );
	$user_id = get_current_user_id();
	if (1 == get_user_meta( $user_id, 'show_welcome_panel', true ))
		update_user_meta( $user_id, 'show_welcome_panel', 0 );
}
add_action( 'load-index.php', 'pcsd_auto_hide_welcome' );

/*==========================================================================================
Remove non needed meta boxes from the dashboard page.
============================================================================================*/
function pcsd_dashboard_setup() {

	remove_meta_box( 'dashboard_primary', 'dashboard', 'side' ); //Wordpress Blog info
	remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' ); //At a Glance
	remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' ); //Quick Draft
	remove_meta_box( 'tinypng_dashboard_widget', 'dashboard', 'side' ); //remove compressions widget
	remove_meta_box( 'dashboard_activity', 'dashboard', 'side' ); // Activity
}
add_action( 'wp_dashboard_setup', 'pcsd_dashboard_setup' );

/*==========================================================================================
Dashboard Widgets

Can be used to announce new things to the users of the site once they Log in
============================================================================================*/

function add_custom_dashboard_widgets() {
		$site = get_bloginfo( 'name' );
	    wp_add_dashboard_widget(
	                 'wpexplorer_dashboard_widget', // Widget slug.
	                 'Welcome to the '.$site.' website', // Title.
	                 'custom_dashboard_widget_content' // Display function.
	        );
	}

	add_action( 'wp_dashboard_setup', 'add_custom_dashboard_widgets' );

	/**
	 * Create the function to output the contents of your Dashboard Widget.
	 */

	function custom_dashboard_widget_content() {
	    // Display whatever it is you want to show.
	    $tutorialspage = get_bloginfo( 'url').'/wp-admin/admin.php?page=pcsd_tutorial-admin-page.php';
	    echo "Check out our new <a href=\"".$tutorialspage."\">Tutorials page</a> for helpful hints on how to accomplish your desired task.";
	}
	
/*==========================================================================================
puts a note on each dashboard page to let content managers how to contact us.
============================================================================================*/
function pcsd_change_admin_footer(){
	 echo '<span id="footer-note">For any questions don\'t hesitate to contact the District Web Team Rob Francom(robertf@provo.edu), and Josh Espinoza(joshe@provo.edu).</span>';
}
add_filter('admin_footer_text', 'pcsd_change_admin_footer');
/*==========================================================================================
add Tutorials page
============================================================================================*/
add_action( 'admin_menu', 'pcsd_tut_admin_menu' );
function pcsd_tut_admin_menu() {
	add_menu_page( 'Tutorials Dashboard', 'Tutorials', 'read', 'pcsd_tutorial-admin-page.php', 'pcsd_tutorial_admin_page', 'dashicons-media-default', 4  );
}
function pcsd_tutorial_admin_page(){
	?>
		<div class="wrap">
			<h2>Tutorials For Wordpress</h2>
			<h3>Posts &amp; Pages</h3>
				<ul>
					<li><a href="https://provo.edu/wp-content/uploads/2018/12/12-12-2018-new-post-instructions-updated-for-2019-theme.pdf">New Post Instructions</a></li>
					<li><a href="https://provo.edu/wp-content/uploads/2017/08/08-18-2017-formatting-your-post.pdf">Formatting Your Post</a></li>
					<li><a href="https://provo.edu/wp-content/uploads/2017/08/08-18-201-adding-external-links.pdf">Adding External Links</a></li>
					<li><a href="https://provo.edu/wp-content/uploads/2019/02/An-Explanation-of-Website-Standards.pdf">An Explanation of Website Standards</a></li>
				</ul>
			<h3>Images &amp; Documents</h3>
				<ul>
					<li><a href="https://provo.edu/wp-content/uploads/2018/12/12-12-2018-image-resources-updated-for-2019-theme.pdf">Image Resources</a></li>
					
					<li><a href="https://provo.edu/wp-content/uploads/2017/08/08-18-2017-adding-pdfs.pdf">Adding PDFs</a></li>
					
					<li><a href="https://provo.edu/wp-content/uploads/2017/08/08-18-2017-file-naming-standards.pdf">File Naming Standards</a></li>
					<li><a href="https://docs.google.com/document/d/1P-ZmnvAQ1mymrFX6DvxjQxdD2Y3X9bAMz2rm5wnd9lY/edit?usp=sharing">Adding Videos</a></li>
					<li><a href="https://docs.google.com/document/d/1J418MQ561-Vo1xQH4s53pkAqlrcC5RMHQQxlcA51bhM/edit?usp=sharing">Adding a Gallery</a></li>
				</ul>
			<h3>Teacher Tutorials</h3>
				<ul>
					<li><a href="https://provo.edu/wp-content/uploads/2017/08/Secondary-School-Teachers-Add-a-Syllabus-to-Your-Official-Web-Page.pdf">How to Add a Syllabus to Your Official Web Page</a></li>
				</ul>
		</div>
	<?php
}
/*==========================================================================================
Tracks User Last Login
============================================================================================*/
//Log the date when a user logs in
function user_last_login( $user_login, $user ) {
    update_user_meta( $user->ID, 'last_login', current_time('M j, Y h:i a') );
}
add_action( 'wp_login', 'user_last_login', 10, 2 );

//display the time the user logged in on the users screen in the dashboard
function new_modify_user_table( $column ) {
    $column['lastLogin'] = 'Last Login';
    return $column;
}
add_filter( 'manage_users_columns', 'new_modify_user_table' );

function new_modify_user_table_row( $val, $column_name, $user_id ) {
    switch ($column_name) {
        case 'lastLogin' :
            return get_the_author_meta( 'last_login', $user_id );
            break;
        default:
    }
    return $val;
}
add_filter( 'manage_users_custom_column', 'new_modify_user_table_row', 10, 3 );

/*==========================================================================================
File Upload Tips
============================================================================================*/

//use post-upload-ui hook for after upload box, use pre-upload-ui hook for before upload box
add_action( 'post-upload-ui', 'pcsd_media_upload_tips' );

function pcsd_media_upload_tips(){
	?>
		<h2>Your file will be processed by the server. This may take a few minutes depending on the size of the file.</h2>
		<h3>Allowed File types: jpeg, mp3, mp4, pdf, mpeg, png, mov, wma</h3>
	<?php
};

/*==========================================================================================
Editor Changes
============================================================================================*/
//turn on paste_as_text by default
function change_paste_as_text($mceInit, $editor_id){
	//NB this has no effect on the browser's right-click context menu's paste!
	$mceInit['paste_as_text'] = true;
	return $mceInit;
}
add_filter('tiny_mce_before_init', 'change_paste_as_text', 1, 2);
add_filter('tiny_mce_before_init', 'tiny_mce_remove_unused_formats' );
/*
 * Modify TinyMCE editor to remove H1, H4,H5,H5, PRE.
 */
function tiny_mce_remove_unused_formats($init) {
	// Add block format elements you want to show in dropdown
	$init['block_formats'] = 'Paragraph=p;Heading 2=h2;Heading 3=h3;';
	return $init;
}
/*==========================================================================================
Breadcrumbs
============================================================================================*/
function custom_breadcrumbs() {

    // Settings
    $separator          = '/';
    $breadcrums_id      = 'breadcrumbs';
    $breadcrums_class   = 'breadcrumbs';
    $home_title         = 'News';

    // If you have any custom post types with custom taxonomies, put the taxonomy name below (e.g. product_cat)
    $custom_taxonomy    = 'product_cat';

    // Get the query & post information
    global $post,$wp_query;

    // Do not display on the homepage
    if ( !is_front_page() ) {

        // Build the breadcrums
        echo '<ol id="' . $breadcrums_id . '" class="' . $breadcrums_class . '">';

        // Home page
        echo '<li class="item-home"><a class="bread-link bread-home" href="' . get_home_url() . '" title="' . $home_title . '">' . $home_title . '</a></li>';
        echo '<li class="separator separator-home"> ' . $separator . ' </li>';

        if ( is_archive() && !is_tax() && !is_category() && !is_tag() ) {

            echo '<li class="item-current item-archive">' . post_type_archive_title($prefix, false) . '</li>';

        } else if ( is_archive() && is_tax() && !is_category() && !is_tag() ) {

            // If post is a custom post type
            $post_type = get_post_type();

            // If it is a custom post type display name and link
            if($post_type != 'post') {

                $post_type_object = get_post_type_object($post_type);
                $post_type_archive = get_post_type_archive_link($post_type);

                echo '<li class="item-cat item-custom-post-type-' . $post_type . '"><a class="bread-cat bread-custom-post-type-' . $post_type . '" href="' . $post_type_archive . '" title="' . $post_type_object->labels->name . '">' . $post_type_object->labels->name . '</a></li>';
                echo '<li class="separator"> ' . $separator . ' </li>';

            }

            $custom_tax_name = get_queried_object()->name;
            echo '<li class="item-current item-archive">' . $custom_tax_name . '</li>';

        } else if ( is_single() ) {

            // If post is a custom post type
            $post_type = get_post_type();

            // If it is a custom post type display name and link
            if($post_type != 'post') {

                $post_type_object = get_post_type_object($post_type);
                $post_type_archive = get_post_type_archive_link($post_type);

                echo '<li class="item-cat item-custom-post-type-' . $post_type . '"><a class="bread-cat bread-custom-post-type-' . $post_type . '" href="' . $post_type_archive . '" title="' . $post_type_object->labels->name . '">' . $post_type_object->labels->name . '</a></li>';
                echo '<li class="separator"> ' . $separator . ' </li>';

            }

            // Get post category info
            $category = get_the_category();

            if(!empty($category)) {

                // Get last category post is in
                $last_category = end(array_values($category));

                // Get parent any categories and create array
                $get_cat_parents = rtrim(get_category_parents($last_category->term_id, true, ','),',');
                $cat_parents = explode(',',$get_cat_parents);

                // Loop through parent categories and store in variable $cat_display
                $cat_display = '';
                foreach($cat_parents as $parents) {
                    $cat_display .= '<li class="item-cat">'.$parents.'</li>';
                    $cat_display .= '<li class="separator"> ' . $separator . ' </li>';
                }

            }

            // If it's a custom post type within a custom taxonomy
            $taxonomy_exists = taxonomy_exists($custom_taxonomy);
            if(empty($last_category) && !empty($custom_taxonomy) && $taxonomy_exists) {

                $taxonomy_terms = get_the_terms( $post->ID, $custom_taxonomy );
                $cat_id         = $taxonomy_terms[0]->term_id;
                $cat_nicename   = $taxonomy_terms[0]->slug;
                $cat_link       = get_term_link($taxonomy_terms[0]->term_id, $custom_taxonomy);
                $cat_name       = $taxonomy_terms[0]->name;

            }

            // Check if the post is in a category
            if(!empty($last_category)) {
                echo $cat_display;
                echo '<li class="item-current item-' . $post->ID . '">' . get_the_title() . '</li>';

            // Else if post is in a custom taxonomy
            } else if(!empty($cat_id)) {

                echo '<li class="item-cat item-cat-' . $cat_id . ' item-cat-' . $cat_nicename . '"><a class="bread-cat bread-cat-' . $cat_id . ' bread-cat-' . $cat_nicename . '" href="' . $cat_link . '" title="' . $cat_name . '">' . $cat_name . '</a></li>';
                echo '<li class="separator"> ' . $separator . ' </li>';
                echo '<li class="item-current item-' . $post->ID . '">' . get_the_title() . '</li>';

            } else {

                echo '<li class="item-current item-' . $post->ID . '">' . get_the_title() . '</li>';

            }

        } else if ( is_category() ) {

            // Category page
            echo '<li class="item-current item-cat">' . single_cat_title('', false) . '</li>';

        } else if ( is_page() ) {

            // Standard page
            if( $post->post_parent ){

                // If child page, get parents
                $anc = get_post_ancestors( $post->ID );

                // Get parents in the right order
                $anc = array_reverse($anc);

                // Parent page loop
                if ( !isset( $parents ) ) $parents = null;
                foreach ( $anc as $ancestor ) {
                    $parents .= '<li class="item-parent item-parent-' . $ancestor . '"><a class="bread-parent bread-parent-' . $ancestor . '" href="' . get_permalink($ancestor) . '" title="' . get_the_title($ancestor) . '">' . get_the_title($ancestor) . '</a></li>';
                    $parents .= '<li class="separator separator-' . $ancestor . '"> ' . $separator . ' </li>';
                }

                // Display parent pages
                echo $parents;

                // Current page
                echo '<li class="item-current item-' . $post->ID . '"> ' . get_the_title() . '</li>';

            } else {

                // Just display current page if not parents
                echo '<li class="item-current item-' . $post->ID . '"> ' . get_the_title() . '</li>';

            }

        } else if ( is_tag() ) {

            // Tag page

            // Get tag information
            $term_id        = get_query_var('tag_id');
            $taxonomy       = 'post_tag';
            $args           = 'include=' . $term_id;
            $terms          = get_terms( $taxonomy, $args );
            $get_term_id    = $terms[0]->term_id;
            $get_term_slug  = $terms[0]->slug;
            $get_term_name  = $terms[0]->name;

            // Display the tag name
            echo '<li class="item-current item-tag-' . $get_term_id . ' item-tag-' . $get_term_slug . '">' . $get_term_name . '</li>';

        } elseif ( is_day() ) {

            // Day archive

            // Year link
            echo '<li class="item-year item-year-' . get_the_time('Y') . '"><a class="bread-year bread-year-' . get_the_time('Y') . '" href="' . get_year_link( get_the_time('Y') ) . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . ' Archives</a></li>';
            echo '<li class="separator separator-' . get_the_time('Y') . '"> ' . $separator . ' </li>';

            // Month link
            echo '<li class="item-month item-month-' . get_the_time('m') . '"><a class="bread-month bread-month-' . get_the_time('m') . '" href="' . get_month_link( get_the_time('Y'), get_the_time('m') ) . '" title="' . get_the_time('M') . '">' . get_the_time('M') . ' Archives</a></li>';
            echo '<li class="separator separator-' . get_the_time('m') . '"> ' . $separator . ' </li>';

            // Day display
            echo '<li class="item-current item-' . get_the_time('j') . '"> ' . get_the_time('jS') . ' ' . get_the_time('M') . ' Archives</li>';

        } else if ( is_month() ) {

            // Month Archive

            // Year link
            echo '<li class="item-year item-year-' . get_the_time('Y') . '"><a class="bread-year bread-year-' . get_the_time('Y') . '" href="' . get_year_link( get_the_time('Y') ) . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . ' Archives</a></li>';
            echo '<li class="separator separator-' . get_the_time('Y') . '"> ' . $separator . ' </li>';

            // Month display
            echo '<li class="item-month item-month-' . get_the_time('m') . '">' . get_the_time('M') . ' Archives</li>';

        } else if ( is_year() ) {

            // Display year archive
            echo '<li class="item-current item-current-' . get_the_time('Y') . '">' . get_the_time('Y') . ' Archives</li>';

        } else if ( is_author() ) {

            // Auhor archive

            // Get the author information
            global $author;
            $userdata = get_userdata( $author );

            // Display author name
            echo '<li class="item-current item-current-' . $userdata->user_nicename . '">' . 'Author: ' . $userdata->display_name . '</li>';

        } else if ( get_query_var('paged') ) {

            // Paginated archives
            echo '<li class="item-current item-current-' . get_query_var('paged') . '">'.__('Page') . ' ' . get_query_var('paged') . '</li>';

        } else if ( is_search() ) {

            // Search results page
            echo '<li class="item-current item-current-' . get_search_query() . '">Search results for: ' . get_search_query() . '</li>';

        } elseif ( is_404() ) {

            // 404 page
            echo '<li>' . 'Error 404' . '</li>';
        }

        echo '</ol>';

    }

}
/*==========================================================================================
Single: Related Post Counter
============================================================================================*/
/* Runs when plugin is activated */
register_activation_hook(__FILE__,'single_post_count_install');
/* Runs on plugin deactivation*/
register_deactivation_hook( __FILE__, 'single_post_count_remove' );

/* Creates new database field */
function single_post_count_install() {
	add_option("single_post_count_data", 'Default', '', 'yes');
}

/* Deletes the database field */
function single_post_count_remove() {
	delete_option('single_post_count_data');
}
/* Creates Page and puts it in the Posts sub menu for anyone that has the capability "unfiltered_html */
add_action( 'admin_menu', 'single_post_count_menu' );

function single_post_count_menu() {
	add_posts_page( 'Single Post Count Options', 'Single Post Count', 'publish_posts', 'singe-post-count-page', 'single_post_count_options' );
}
/* option on the page to allow you to input a number */
function single_post_count_options() {
	if ( !current_user_can( 'unfiltered_html' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
		}?>
		<div class="wrap">
			<h2>Single Post Count</h2>
				<p>Insert a number between 3 and 21. Numbers divisible by 3 are best.
				<form method="post" action="options.php">
						<?php wp_nonce_field('update-options'); ?>
						<label>How many Posts to display</label>
						<input type="number" min="3" max="30" step="3" name="single_post_count_data" id="single_post_count_data" value="<?php echo get_option('single_post_count_data'); ?>" />
						<input type="hidden" name="action" value="update" />
						<input type="hidden" name="page_options" value="single_post_count_data" />
						<?php submit_button(); ?>

				</form>
		</div>
<?php }
/*==========================================================================================
// ShortCodes
============================================================================================*/

//For Two Column Layout [TwoColumn-Start]
function twoColumn_func( $atts ){
    return ' <div class="twoColumn"> ';
}
add_shortcode( 'TwoColumn-Start', 'twoColumn_func' );

//For Two Column Layout [TwoColumn-First-Column-End]
function twoColumn2_func( $atts ){
    return ' </div><div class="twoColumn"> ';
}
add_shortcode( 'TwoColumn-First-Column-End', 'twoColumn2_func' );

//For Two Column Layout [TwoColumn-Second-Column-End]
function twoColumn3_func( $atts ){
    return ' </div> ';
}
add_shortcode( 'TwoColumn-Second-Column-End', 'twoColumn3_func' );

//For Three Column Layout [ThreeColumn-Start]
function threeColumn_func( $atts ){
    return ' <div class="threeColumn"> ';
}
add_shortcode( 'ThreeColumn-Start', 'threeColumn_func' );

//For Three Column Layout [ThreeColumn-First-Column-End]
function threeColumn2_func( $atts ){
    return ' </div><div class="threeColumn"> ';
}
add_shortcode( 'ThreeColumn-First-Column-End', 'threeColumn2_func' );

//For Three Column Layout [ThreeColumn-Second-Column-End]
function threeColumn3_func( $atts ){
    return ' </div><div class="threeColumn"> ';
}
add_shortcode( 'ThreeColumn-Second-Column-End', 'threeColumn3_func' );

//For Three Column Layout [ThreeColumn-Third-Column-End]
function threeColumn4_func( $atts ){
    return ' </div> ';
}
add_shortcode( 'ThreeColumn-Third-Column-End', 'threeColumn4_func' );

//Display Modified Date [modified-date]
function modifiedDate_func( $atts ){
    ?>
     <p class="lastmodified"><em>Last modified: <?php the_modified_date(); ?></em></p>
    <?php
}
add_shortcode( 'modified-date', 'modifiedDate_func' );

//======================school camera images=============================
/*
//---------------Edgemont images-------------------
function ee_camera_code() {
    	$image = 'https://globalassets.provo.edu/image/construction-images/ee/currentpic.jpg';
    	$nocacheimage = "$image" . "?" . time();
    	$url = '<img src=' . $nocacheimage . ' alt' . ' /' . '>';
    	return $url;
}
add_shortcode('ee-construction-image', 'ee_camera_code');

//---------------Provost images-------------------
function peCameraCode() {
    	$image = 'https://globalassets.provo.edu/image/construction-images/pe/currentpic.jpg';
    	$nocacheimage = "$image" . "?" . time();
    	$url = '<img src=' . $nocacheimage . ' alt' . ' /' . '>';
    	return $url;
}
add_shortcode('pe-construction-image', 'peCameraCode');
*/
//disable open in a new tab/window checkbox in TinyMCE
function disable_open_new_window() {
    ?>
    <script type="text/javascript">
        jQuery(document).ready(function ($) {
            $('input#link-target-checkbox').prop('checked', false);
            $('#wp-link .link-target').css('visibility', 'hidden');
        });
    </script>
    <?php
}
add_action ('after_wp_tiny_mce', 'disable_open_new_window');

//================================Display Modified Date on Dashboard for Posts===================================

// Register Modified Date Column for both posts & pages
function modified_column_register( $columns ) {
	$columns['Modified'] = __( 'Modified Date', 'show_modified_date_in_admin_lists' );
	return $columns;
}
add_filter( 'manage_posts_columns', 'modified_column_register' );
add_filter( 'manage_pages_columns', 'modified_column_register' );

function modified_column_display( $column_name, $post_id ) {
	switch ( $column_name ) {
	case 'Modified':
		global $post; 
	       	echo '<p class="mod-date">';
	       	echo '<em>'.get_the_modified_date().' '.get_the_modified_time().'</em><br />';
			echo '<small>' . esc_html__( 'by ', 'show_modified_date_in_admin_lists' ) . '<strong>'.get_the_modified_author().'<strong></small>';
			echo '</p>';
		break; // end all case breaks
	}
}
add_action( 'manage_posts_custom_column', 'modified_column_display', 10, 2 );
add_action( 'manage_pages_custom_column', 'modified_column_display', 10, 2 );

function modified_column_register_sortable( $columns ) {
	$columns['Modified'] = 'modified';
	return $columns;
}
add_filter( 'manage_edit-post_sortable_columns', 'modified_column_register_sortable' );
add_filter( 'manage_edit-page_sortable_columns', 'modified_column_register_sortable' );

/*-------------------------------------------------------*/
/* [district_school_year_calendar]
/*-------------------------------------------------------*/

function district_school_year_calendar_pull() { 
	// create a new cURL resource
	$schoolyear_cal = curl_init();
	// set URL and other appropriate options
	curl_setopt($schoolyear_cal, CURLOPT_URL, 'https://globalassets.provo.edu/globalpages/district-school-year-calendar.html');
	//ignores the header from the request
	curl_setopt($schoolyear_cal, CURLOPT_HEADER, 0);
	//sets a timeout incase it cant find the file so it doens't hang forever
	curl_setopt($schoolyear_cal, CURLOPT_TIMEOUT, 12);
	//so that it doesn't print the results right away and we can control where the results are printed
	curl_setopt($schoolyear_cal, CURLOPT_RETURNTRANSFER, TRUE);
	// grab URL and pass it to the browser
	$result = curl_exec($schoolyear_cal);
	// close cURL resource, and free up system resources
	curl_close($schoolyear_cal);
	//prints results
	return $result;

}
add_shortcode('district_school_year_calendar', 'district_school_year_calendar_pull');

?>