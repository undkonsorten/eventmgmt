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
     * @var ConfigurationManagerInterface
     */
    protected $configurationManager;

    public function injectConfigurationManager(ConfigurationManagerInterface $configurationManager): void
    {
        $this->configurationManager = $configurationManager;
    }

    /**
     * Arguments initialization
     *
     */
    public function initializeArguments()
    {
        $this->registerArgument('fieldName', 'string', 'The field name', true);
        $this->registerArgument('actionName', 'string', 'the action name', false, 'editAction');
    }

    /**
	 * Check if this field is a required field
	 *
	 * @return bool
	 */
	public function render() {
        [
            'fieldName' => $fieldName,
            'actionName' => $actionName,
        ] = $this->arguments;

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
