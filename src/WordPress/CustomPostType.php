<?php

namespace WordPress;

class CustomPostType
{
	public $cpt_name;
	

	public function __construct($cpt_name)
	{
		$this->cpt_name = $cpt_name;
	}
}