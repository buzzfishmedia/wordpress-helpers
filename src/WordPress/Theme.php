<?php

namespace WordPress;

class Theme
{
	public $theme_name;

	public function __construct($theme_name)
	{
		$this->theme_name = $theme_name;
	}
}