<?php
namespace Undkonsorten\Eventmgmt\ViewHelpers\Misc;

use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * View helper like ucfirst()
 *
 * @package TYPO3
 * @subpackage Fluid
 */
class UpperViewHelper extends AbstractViewHelper {

    /**
     * Arguments initialization
     *
     */
    public function initializeArguments()
    {
        $this->registerArgument('string', 'string', 'The string to transform', true);
    }

	/**
	 * View helper like ucfirst()
	 *
	 * @return string
	 */
	public function render() {
        [
            'string' => $string,
        ] = $this->arguments;
		return ucfirst($string);
	}
}
