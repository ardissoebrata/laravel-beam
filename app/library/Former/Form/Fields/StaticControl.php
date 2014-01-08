<?php

namespace Former\Form\Fields;

use Former\Traits\Field;
use HtmlObject\Element;

/**
 * Static Control fields
 */
class StaticControl extends Field
{
	////////////////////////////////////////////////////////////////////
	/////////////////////////// CORE METHODS ///////////////////////////
	////////////////////////////////////////////////////////////////////

	/**
	 * Prints out the current tag
	 *
	 * @return string An uneditable input tag
	 */
	public function render()
	{
		$this->Class('form-control-static');

		$this->setId();

		return Element::create('p', $this->getValue(), $this->getAttributes());;
	}

}
