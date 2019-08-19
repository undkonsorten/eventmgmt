<?php
namespace Undkonsorten\Eventmgmt\ViewHelpers\Misc;

use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Check if this field is a required field
 *
 * @package TYPO3
 * @subpackage Fluid
 */
class IsRequiredFieldViewHelper extends AbstractViewHelper {

	/**
	 * @var \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface
	 * @TYPO3\CMS\Extbase\Annotation\Inject
	 */
	protected $configurationManager;

	/**
	 * Check if this field is a required field
	 *
	 * @param string $fieldName
	 * @param string $actionName
	 * @return bool
	 */
	public function render($fieldName, $actionName = 'editAction') {
		$action = str_replace('Action', '', $actionName);
		$configuration = $GLOBALS['TCA']['tx_eventmgmt_domain_model_event']['columns'][$fieldName]['config'];
		if (
			isset($configuration['eval']) &&
			in_array('required', GeneralUtility::trimExplode(",", $configuration['eval']))
		) {
			return TRUE;
		}
		return FALSE;
	}
}
