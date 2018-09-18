<?php

namespace Lucacri\NovaUnlayerjs;

use Laravel\Nova\Fields\Code;

class Unlayerjs extends Code
{

	/**
	 * The field's component.
	 *
	 * @var string
	 */
	public $component = 'unlayerjs';

	public function __construct(string $name, $attribute = NULL, $resolveCallback = NULL) {
		parent::__construct($name, $attribute, $resolveCallback);
		$this->json();
	}

	public function uploadUrl($url) {
		return $this->withMeta(['uploadUrl' => $url]);
	}

	public function mergeTags(array $mergeTags) {
		return $this->withMeta(['mergeTags' => $mergeTags]);
	}

}
