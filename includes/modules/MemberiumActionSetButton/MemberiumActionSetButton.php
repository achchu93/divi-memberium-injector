<?php

class DMI_MemberiumActionSetButton extends ET_Builder_Module {

    public $slug = 'dmi_button';
    public $vb_support = 'on';

    function init() {
        $this->name       = esc_html__( 'Memberium Action Button', 'divi-memb-inject' );
        $this->plural     = esc_html__( 'Memberium Action Buttons', 'divi-memb-inject' );

        $this->custom_css_fields = array(
            'main_element' => array(
                'label'    => esc_html__( 'Main Element', 'divi-memb-inject' ),
                'no_space_before_selector' => true,
            ),
        );

        $this->settings_modal_toggles = array(
            'general'  => array(
                'toggles' => array(
                    'main_content' => esc_html__( 'Text', 'divi-memb-inject' ),
                    'link'         => esc_html__( 'Redirect Link', 'divi-memb-inject' ),
                    'action_ids'  => esc_html__( 'Action IDs', 'divi-memb-inject' ),
                    'tag_ids'  => esc_html__( 'Tag IDs', 'divi-memb-inject' ),
                ),
            ),
            'advanced' => array(
                'toggles' => array(
                    'alignment'  => esc_html__( 'Alignment', 'divi-memb-inject' ),
                    'text'       => array(
                        'title'    => esc_html__( 'Text', 'divi-memb-inject' ),
                        'priority' => 49,
                    ),
                ),
            ),
        );
    }

    function get_fields() {

        $this->get_actions();

        $fields = array(
            'button_url' => array(
                'label'            => esc_html__( 'Button URL', 'divi-memb-inject' ),
                'type'             => 'text',
                'option_category'  => 'basic_option',
                'description'      => esc_html__( 'Input the destination URL for your button.', 'divi-memb-inject' ),
                'toggle_slug'      => 'link',
            ),
            'url_new_window' => array(
                'label'            => esc_html__( 'Url Opens', 'divi-memb-inject' ),
                'type'             => 'select',
                'option_category'  => 'configuration',
                'options'          => array(
                    'off' => esc_html__( 'In The Same Window', 'divi-memb-inject' ),
                    'on'  => esc_html__( 'In The New Tab', 'divi-memb-inject' ),
                ),
                'toggle_slug'      => 'link',
                'description'      => esc_html__( 'Here you can choose whether or not your link opens in a new window', 'divi-memb-inject' ),
                'default_on_front' => 'off',
            ),
            'button_text' => array(
                'label'            => esc_html__( 'Button Text', 'divi-memb-inject' ),
                'type'             => 'text',
                'option_category'  => 'basic_option',
                'description'      => esc_html__( 'Input your desired button text.', 'divi-memb-inject' ),
                'toggle_slug'      => 'main_content',
            ),
            'button_alignment' => array(
                'label'            => esc_html__( 'Button Alignment', 'divi-memb-inject' ),
                'type'             => 'text_align',
                'option_category'  => 'configuration',
                'options'          => et_builder_get_text_orientation_options( array( 'justified' ) ),
                'tab_slug'         => 'advanced',
                'toggle_slug'      => 'alignment',
                'description'      => esc_html__( 'Here you can define the alignment of Button', 'divi-memb-inject' ),
            ),
            'action_ids' => array(
                'label'            => esc_html__( 'IDs', 'divi-memb-inject' ),
                'type'             => 'text',
                "class"            => "tag-selector",
                'options'          => $this->get_actions(),
                'description'      => esc_html__( 'Comma separated list of Action Set IDs to run. (empty would not run anything)', 'divi-memb-inject' ),
                'toggle_slug'      => 'action_ids',
            ),
            'tag_ids' => array(
                'label'            => esc_html__( 'IDs', 'divi-memb-inject' ),
                'type'             => 'text',
                'description'      => esc_html__( 'Comma separated list of Action Set IDs to run. (empty would not run anything)', 'divi-memb-inject' ),
                'toggle_slug'      => 'tag_ids',
            ),
            'debug' => array(
                'label'           => esc_html__( 'Debug', 'divi-memb-inject' ),
                'type'            => 'yes_no_button',
                'options'         => array(
                    'on'  => esc_html__( 'On', 'divi-memb-inject' ),
                    'off' => esc_html__( 'Off', 'divi-memb-inject' ),
                ),
                'default'         => 'off',
                'toggle_slug'     => 'tag_ids'
            )
        );

        return $fields;
    }

    function render( $attrs, $content = null, $render_slug ) {
        $action_ids        = $this->props['action_ids'];
        $tag_ids           = $this->props['tag_ids'];
        $debug             = $this->props['debug'] == "on" ? "1" : "0";
        $button_url        = !empty($this->props['button_url']) ? $this->props['button_url'] : "";
        $button_rel        = $this->props['button_rel'];
        $button_text       = !empty($this->props['button_text']) ? $this->props['button_text'] : "";
        $background_layout = $this->props['background_layout'];
        $url_new_window    = $this->props['url_new_window'];
        $custom_icon       = $this->props['button_icon'];
        $button_custom     = $this->props['custom_button'];
        $button_alignment  = $this->get_button_alignment();

        // Module classnames
        $this->add_classname( "et_pb_bg_layout_{$background_layout}" );
        $this->remove_classname( 'et_pb_module' );

        if(empty($action_ids) && empty( $tag_ids)){
            return '';
        }

        // Render Button
        $button = $this->render_button( array(
            'action_ids'       => $action_ids,
            'tag_ids'          => $tag_ids,
            'debug'            => $debug,
            'button_id'        => $this->module_id( false ),
            'button_classname' => explode( ' ', $this->module_classname( $render_slug ) ),
            'button_custom'    => $button_custom,
            'button_rel'       => $button_rel,
            'button_text'      => $button_text,
            'button_url'       => $button_url,
            'custom_icon'      => $custom_icon,
            'has_wrapper'      => false,
            'url_new_window'   => $url_new_window,
        ) );

        // Render module output
        $output = sprintf(
            '<div class="et_pb_button_module_wrapper et_pb_button_%3$s_wrapper %2$s et_pb_module ">
				%1$s
			</div>',
            $button,
            sprintf( 'et_pb_button_alignment_%1$s', esc_attr( $button_alignment ) ),
            $this->render_count()
        );

        return $output;
    }

    public function get_actions()
    {
        global $wpdb;
        $actions = array();
        $i2sdk_options = get_option( 'i2sdk' );
        $app_name = isset($i2sdk_options['app_name']) ? $i2sdk_options['app_name'] : "";

        if(empty($app_name)){
            return $actions;
        }

        $query = "SELECT * FROM ".MEMBERIUM_DB_ACTIONSETS." WHERE appname = '{$app_name}'";
        $action_data = $wpdb->get_results($query, ARRAY_A);

        if(count($action_data)){
            foreach ($action_data as $action){
                $actions[$action['id']] = $action['name'];
            }
        }

        return $actions;
    }

    public function get_button_alignment() {
        $text_orientation = isset( $this->props['button_alignment'] ) ? $this->props['button_alignment'] : '';

        return et_pb_get_alignment( $text_orientation );
    }

    public function render_button($args = array())
    {
        $defaults = array(
            'button_id'        => '',
            'button_classname' => array(),
            'button_custom'    => '',
            'button_rel'       => '',
            'button_text'      => '',
            'button_url'       => '',
            'custom_icon'      => '',
            'display_button'   => true,
            'has_wrapper'      => true,
            'url_new_window'   => '',
        );

        $args = wp_parse_args( $args, $defaults );

        // Do not proceed if no button URL or text found
        if ( ! $args['display_button'] || '' === $args['button_text'] ) {
            return '';
        }

        // Button classname
        $button_classname = array( 'et_pb_button' );

        if ( '' !== $args['custom_icon'] && 'on' === $args['button_custom'] ) {
            $button_classname[] = 'et_pb_custom_button_icon';
        }

        if ( ! empty( $args['button_classname'] ) ) {
            $button_classname = array_merge( $button_classname, $args['button_classname'] );
        }

        // Custom icon data attribute
        $use_data_icon = '' !== $args['custom_icon'] && 'on' === $args['button_custom'];
        $data_icon     = $use_data_icon ? sprintf(
            ' data-icon="%1$s"',
            esc_attr( et_pb_process_font_icon( $args['custom_icon'] ) )
        ) : '';

        $shortcode = sprintf(
            '[memb_action_link action_ids="%1$s" debug="%2$s" redirect="%3$s" tagids="%4$s"]',
            $args["action_ids"],
            $args["debug"],
            $args["button_url"],
            $args["tag_ids"]
        );

        // Render button
        return sprintf( '%7$s<a%9$s class="%5$s" href="%1$s"%3$s%4$s%6$s>%2$s</a>%8$s',
            esc_url( do_shortcode($shortcode) ),
            esc_html( $args['button_text'] ),
            ( 'on' === $args['url_new_window'] ? ' target="_blank"' : '' ),
            et_esc_previously( $data_icon ),
            esc_attr( implode( ' ', array_unique( $button_classname ) ) ), // #5
            et_esc_previously( $this->get_rel_attributes( $args['button_rel'] ) ),
            $args['has_wrapper'] ? '<div class="et_pb_button_wrapper">' : '',
            $args['has_wrapper'] ? '</div>' : '',
            '' !== $args['button_id'] ? sprintf( ' id="%1$s"', esc_attr( $args['button_id'] ) ) : ''
        );
    }

}

new DMI_MemberiumActionSetButton;
