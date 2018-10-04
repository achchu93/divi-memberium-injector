<?php

class DMI_DiviMemberiumInjector extends DiviExtension {

	/**
	 * The gettext domain for the extension's translations.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	public $gettext_domain = 'dmi-divi-memberium-injector';

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

		parent::__construct( $name, $args );
	}

	protected function _initialize()
    {
        parent::_initialize();
        add_action( 'admin_enqueue_scripts', array( $this, 'dmi_admin_enqueue_scripts' ), 11 );
    }

    public function dmi_admin_enqueue_scripts()
    {
        wp_enqueue_script("dmi-backend-js", $this->plugin_dir_url . "scripts/backend.js", array('jquery', 'et_pb_admin_js'), null, true);
    }
}

new DMI_DiviMemberiumInjector();
