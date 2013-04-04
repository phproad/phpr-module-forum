<?php

class Forum_Module extends Core_Module_Base
{

	protected function set_module_info()
	{
		return new Core_Module_Detail(
			"Forum",
			"Forum functions",
			"PHP Road",
			"http://phproad.com/"
		);
	}

	public function subscribe_events()
	{
	}

	public function build_admin_settings($settings)
	{
		$settings->add('/forum/setup', 'Forum Settings', 'Customise forum features', '/modules/forum/assets/images/forum_config.png', 100);
	}

}
