<?php
namespace Undkonsorten\Eventmgmt\ViewHelpers\Misc;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * View helper to explode a list
 *
 * @package TYPO3
 * @subpackage Fluid
 */
class ExplodeViewHelper extends AbstractViewHelper {

    /**
     * Arguments initialization
     *
     */
    public function initializeArguments()
    {
        $this->registerArgument('string', 'string', 'Any list (e.g. "a,b,c,d")', false, '');
        $this->registerArgument('separator', 'string', 'Separator sign (e.g. ",")', false, ',');
        $this->registerArgument('trim', 'boolean', 'Should be trimmed?', false, true);
    }


    /**
	 * View helper to explode a list
	 *
	 *
	 * @return array
	 */
	public function render() {
        [
            'string' => $string,
            'separator' => $separator,
            'trim' => $trim,
        ] = $this->arguments;
		return $trim ? GeneralUtility::trimExplode($separator, $string, 1) : explode($separator, $string);
	}
}
