<?php
defined('ABSPATH') || exit; // Abort, if called directly.

/**
 * Class Footer
 * @package PostType
 */
class Edubin_Footer
{
    /**
     * @var string
     *
     * Set post type params
     */
    private $type = 'eb_footer';
    private $slug;
    private $name;
    private $plural_name;

    /**
     * Footer constructor.
     *
     * When class is instantiated
     */
    public function __construct()
    {
        // Register the post type
        $this->slug = 'eb_footer';
        $this->name = esc_html__('Footer', 'edubin-core');
        $this->plural_name = esc_html__('Footers', 'edubin-core');

        add_action('init', [$this, 'register']);
        add_action('template_redirect', [$this, 'restrict_ui']);

        add_filter('single_template', [$this, 'get_custom_pt_single_template']);
    }

    /**
     * Register post type
     */
    public function register()
    {
        $labels = [
            'name' => $this->name,
            'singular_name' => $this->name,
            'add_new' => sprintf( __('Add New %s', 'edubin-core'), $this->name ),
            'add_new_item' => sprintf( __('Add New %s', 'edubin-core'), $this->name ),
            'edit_item' => sprintf( __('Edit %s', 'edubin-core'), $this->name ),
            'new_item' => sprintf( __('New %s', 'edubin-core'), $this->name ),
            'all_items' => sprintf( __('All %s', 'edubin-core'), $this->plural_name ),
            'view_item' => sprintf( __('View %s', 'edubin-core'), $this->name ),
            'search_items' => sprintf( __('Search %s', 'edubin-core'), $this->name ),
            'not_found' => sprintf( __('No %s found' , 'edubin-core'), strtolower($this->name) ),
            'not_found_in_trash' => sprintf( __('No %s found in Trash', 'edubin-core'), strtolower($this->name) ),
            'parent_item_colon' => '',
            'menu_name' => $this->name
        ];

        $args = [
            'labels' => $labels,
            'public' => true,
            'exclude_from_search' => true,
            'show_in_nav_menus' => false,
            'show_ui' => true,
            'show_in_menu' => true,
            'rewrite' => false,
            'menu_position' => 13,
            'supports' => ['title', 'editor', 'thumbnail', 'page-attributes'],
            'menu_icon' => 'dashicons-align-center',
        ];

        register_post_type($this->type, $args);
    }

    function restrict_ui()
    {
        if (is_singular($this->type)
            && !current_user_can('edit_posts')
        ) {
            wp_safe_redirect(site_url(), 301);
            die;
        }
    }

    public function wrapper_footer_open()
    {
        global $post;

        if ($post->post_type == $this->type) {
            echo '<footer>';
        }
    }

    public function wrapper_footer_close()
    {
        global $post;

        if ($post->post_type == $this->type) {

            echo '</footer>';
        }
    }

    // https://codex.wordpress.org/Plugin_API/Filter_Reference/single_template
    function get_custom_pt_single_template($single_template)
    {
        global $post;

        if ($post->post_type == $this->type) {

            if (defined('ELEMENTOR_PATH')) {
                $elementor_template = ELEMENTOR_PATH . '/modules/page-templates/templates/canvas.php';

                if (file_exists($elementor_template)) {
                    add_action('elementor/page_templates/canvas/before_content', [$this, 'wrapper_footer_open']);
                    add_action('elementor/page_templates/canvas/after_content', [$this, 'wrapper_footer_close']);
                    return $elementor_template;
                }
            }

            if (file_exists(get_template_directory().'/single-footer.php')) return $single_template;

            $single_template = plugin_dir_path( dirname( __FILE__ ) ) . 'footer/templates/single-footer.php';
        }

        return $single_template;
    }
}

new Edubin_Footer();