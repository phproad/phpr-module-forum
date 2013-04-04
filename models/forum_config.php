<?php

class Forum_Config extends Core_Settings_Base
{
	public $record_code = 'forum_config';

	public static function create()
	{
		$config = new self();
		return $config->load();
	}   
	
	protected function build_form()
	{
		$this->add_field('time_between_posts', 'Time between posts', 'full', db_number)->tab('General')->comment('Used to control the time allowed between posts (Seconds)');
	}

	protected function init_config_data()
	{
		$this->locale_code = 5000; // @todo Verify
	}

	public function is_configured()
	{
		$config = self::create();
		if (!$config)
			return false;

		return true;
	}

}