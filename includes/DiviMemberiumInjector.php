<?php

class DMI_DiviMemberiumInjector extends DiviExtension {

	/**
	 * The gettext domain for the extension's translations.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	public $gettext_domain = 'divi-memb-inject';

	/**
	 * The extension's WP Plugin name.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	public $name = 'divi-memberium-injector';

	/**
	 * The extension's version
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	public $version = '1.0.0';

	/**
	 * DMI_DiviMemberiumInjector constructor.
	 *
	 * @param string $name
	 * @param array  $args
	 */
	public function __construct( $name = 'divi-memberium-injector', $args = array() ) {
		$this->plugin_dir     = plugin_dir_path( __FILE__ );
		$this->plugin_dir_url = plugin_dir_url( $this->plugin_dir );

        define('DMI_DEBUG', true);

		parent::__construct( $name, $args );
	}

	protected function _initialize()
    {
        parent::_initialize();
        add_action( 'admin_enqueue_scripts', array( $this, 'dmi_admin_enqueue_scripts' ), 11 );
        add_action('wp_ajax_dmi_get_actions_list', array($this, 'dmi_get_actions_list'));
    }

    public function dmi_admin_enqueue_scripts()
    {
        wp_enqueue_style("dmi-backend-css", $this->plugin_dir_url . "styles/admin.css", array(), null, "all");
        wp_enqueue_script("dmi-backend-js", $this->plugin_dir_url . "scripts/backend.js", array('jquery', 'et_pb_admin_js'), null, true);
    }

    public function dmi_get_actions_list()
    {
        global $wpdb, $post;
        $options = get_option('i2sdk');
        $app_name = isset($options["app_name"]) ? $options["app_name"] : "";
        $query = "SELECT * FROM " . MEMBERIUM_DB_ACTIONSETS . " WHERE appname = '{$app_name}'";
        $actions_sets = $wpdb->get_results($query, ARRAY_A);
        $actions_data = array();

        if(count($actions_sets)){
            foreach ($actions_sets as $action){
                $actions_data[] = array("id" => $action["id"], "text" => $action["name"] . " (". $action['id'] .")");
            }
        }

        wp_send_json_success($actions_data);
    }
}

new DMI_DiviMemberiumInjector();
