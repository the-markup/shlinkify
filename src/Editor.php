<?php

namespace Shlinkify;

class Editor {

	function __construct($plugin) {
		$this->plugin = $plugin;
		add_action('init', [$this, 'on_init']);
		add_action('enqueue_block_editor_assets', [$this, 'on_editor_assets']);
	}

	function on_init() {
		register_meta('post', 'shlinkify_long_url', array(
			'show_in_rest' => true,
			'type' => 'string',
			'single' => true
		));
		register_meta('post', 'shlinkify_short_url', array(
			'show_in_rest' => true,
			'type' => 'string',
			'single' => true
		));
		register_meta('post', 'shlinkify_short_code', array(
			'show_in_rest' => true,
			'type' => 'string',
			'single' => true
		));
	}

	function on_editor_assets() {

		// Only show on 'post' post_types for now
		$screen = get_current_screen();
		if ($screen->post_type != 'post') {
			return;
		}

		wp_enqueue_script(
			'shlinkify-editor',
			plugins_url('build/editor.js', __DIR__),
			['wp-edit-post', 'wp-components', 'wp-plugins', 'wp-data'],
			filemtime(plugin_dir_path(__DIR__) . 'build/editor.js')
		);

		wp_enqueue_style(
			'shlinkify-editor',
			plugins_url('build/editor.css', __DIR__),
			[],
			filemtime(plugin_dir_path(__DIR__) . 'build/editor.css')
		);
	}

}
