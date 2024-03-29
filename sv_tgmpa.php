<?php
	namespace sv100;

	class sv_tgmpa extends init {
		public function init() {
			$this->set_module_title( __( 'SV Recommend Plugins', 'sv100' ) )
				 ->set_module_desc( __( 'Recommend plugins for use with our theme.', 'sv100' ) );
			
			require_once( $this->get_path( 'lib/modules/class-tgm-plugin-activation.php' ) );
			
			// Action Hooks
			add_action( 'tgmpa_register', array( $this, 'sv100_register_required_plugins' ) );
		}
		
		/**
		 * Register the required plugins for this theme.
		 *
		 * In this example, we register five plugins:
		 * - one included with the TGMPA library
		 * - two from an external source, one from an arbitrary source, one from a GitHub repository
		 * - two from the .org repo, where one demonstrates the use of the `is_callable` argument
		 *
		 * The variables passed to the `tgmpa()` function should be:
		 * - an array of plugin arrays;
		 * - optionally a configuration array.
		 * If you are not changing anything in the configuration array, you can remove the array and remove the
		 * variable from the function call: `tgmpa( $plugins );`.
		 * In that case, the TGMPA default settings will be used.
		 *
		 * This function is hooked into `tgmpa_register`, which is fired on the WP `init` action on priority 10.
		 */
		public function sv100_register_required_plugins() {
			/*
			 * Array of plugin arrays. Required keys are name and slug.
			 * If the source is NOT from the .org repo, then source is also required.
			 */
			$plugins = array(
				// This is an example of how to include a plugin from the WordPress Plugin Repository.
				array(
					'name'	  => __( 'SV100 Companion', 'sv100' ),
					'slug'	  => 'sv100-companion',
					'required'  => false,
				),
			);
			
			/*
			 * Array of configuration settings. Amend each line as needed.
			 *
			 * TGMPA will start providing localized text strings soon. If you already have translations of our standard
			 * strings available, please help us make TGMPA even better by giving us access to these translations or by
			 * sending in a pull-request with .po file(s) with the translations.
			 *
			 * Only uncomment the strings in the config array if you want to customize the strings.
			 */
			$config = array(
				'id'		   => 'sv100',				 // Unique ID for hashing notices for multiple instances of TGMPA.
				'default_path' => '',					  // Default absolute path to bundled plugins.
				'menu'		 => 'tgmpa-install-plugins', // Menu slug.
				'has_notices'  => true,					// Show admin notices or not.
				'dismissable'  => true,					// If false, a user cannot dismiss the nag message.
				'dismiss_msg'  => '',					  // If 'dismissable' is false, this message will be output at top of nag.
				'is_automatic' => false,				   // Automatically activate plugins after installation or not.
				'message'	  => '',					  // Message to output right before the plugins table.
				
				/*
				'strings'	  => array(
					'page_title'					  => __( 'Install Required Plugins', 'sv100' ),
					'menu_title'					  => __( 'Install Plugins', 'sv100' ),
					/* translators: %s: plugin name. * /
					'installing'					  => __( 'Installing Plugin: %s', 'sv100' ),
					/* translators: %s: plugin name. * /
					'updating'						=> __( 'Updating Plugin: %s', 'sv100' ),
					'oops'							=> __( 'Something went wrong with the plugin API.', 'sv100' ),
					'notice_can_install_required'	 => _n_noop(
						/* translators: 1: plugin name(s). * /
						'This theme requires the following plugin: %1$s.',
						'This theme requires the following plugins: %1$s.',
						'sv100'
					),
					'notice_can_install_recommended'  => _n_noop(
						/* translators: 1: plugin name(s). * /
						'This theme recommends the following plugin: %1$s.',
						'This theme recommends the following plugins: %1$s.',
						'sv100'
					),
					'notice_ask_to_update'			=> _n_noop(
						/* translators: 1: plugin name(s). * /
						'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.',
						'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.',
						'sv100'
					),
					'notice_ask_to_update_maybe'	  => _n_noop(
						/* translators: 1: plugin name(s). * /
						'There is an update available for: %1$s.',
						'There are updates available for the following plugins: %1$s.',
						'sv100'
					),
					'notice_can_activate_required'	=> _n_noop(
						/* translators: 1: plugin name(s). * /
						'The following required plugin is currently inactive: %1$s.',
						'The following required plugins are currently inactive: %1$s.',
						'sv100'
					),
					'notice_can_activate_recommended' => _n_noop(
						/* translators: 1: plugin name(s). * /
						'The following recommended plugin is currently inactive: %1$s.',
						'The following recommended plugins are currently inactive: %1$s.',
						'sv100'
					),
					'install_link'					=> _n_noop(
						'Begin installing plugin',
						'Begin installing plugins',
						'sv100'
					),
					'update_link' 					  => _n_noop(
						'Begin updating plugin',
						'Begin updating plugins',
						'sv100'
					),
					'activate_link'				   => _n_noop(
						'Begin activating plugin',
						'Begin activating plugins',
						'sv100'
					),
					'return'						  => __( 'Return to Required Plugins Installer', 'sv100' ),
					'plugin_activated'				=> __( 'Plugin activated successfully.', 'sv100' ),
					'activated_successfully'		  => __( 'The following plugin was activated successfully:', 'sv100' ),
					/* translators: 1: plugin name. * /
					'plugin_already_active'		   => __( 'No action taken. Plugin %1$s was already active.', 'sv100' ),
					/* translators: 1: plugin name. * /
					'plugin_needs_higher_version'	 => __( 'Plugin not activated. A higher version of %s is needed for this theme. Please update the plugin.', 'sv100' ),
					/* translators: 1: dashboard link. * /
					'complete'						=> __( 'All plugins installed and activated successfully. %1$s', 'sv100' ),
					'dismiss'						 => __( 'Dismiss this notice', 'sv100' ),
					'notice_cannot_install_activate'  => __( 'There are one or more required or recommended plugins to install, update or activate.', 'sv100' ),
					'contact_admin'				   => __( 'Please contact the administrator of this site for help.', 'sv100' ),
		
					'nag_type'						=> '', // Determines admin notice type - can only be one of the typical WP notice classes, such as 'updated', 'update-nag', 'notice-warning', 'notice-info' or 'error'. Some of which may not work as expected in older WP versions.
				),
				*/
			);
			
			tgmpa( $plugins, $config );
		}
	}