<?php
namespace Undkonsorten\Eventmgmt\ViewHelpers;

/*                                                                        *
 * This script is part of the TYPO3 project - inspiring people to share!  *
 *                                                                        *
 * TYPO3 is free software; you can redistribute it and/or modify it under *
 * the terms of the GNU General Public License version 2 as published by  *
 * the Free Software Foundation.                                          *
 *                                                                        *
 * This script is distributed in the hope that it will be useful, but     *
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHAN-    *
 * TABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General      *
 * Public License for more details.                                       *
 *                                                                        */
/**
 * This ViewHelper helps rendering a date range
 *
 * = Examples =
 *
 * <code>
 * <ns:dateRange start="{startDateTime}" end="{endDateTime}">
 * 	<f:if condition="{sameMonth}">
 *     <f:format.date format="%d">{startDateTime}</f:format> until <f:format.date format="%d.%m.%Y">{endDateTime}</f:format>
 * </ns:dateRange>
 * </code>
 * 
 * <output>
 * 	17. until 22.10.2013
 * </output>
 *
 */
class DateRangeViewHelper extends \TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper {

	/**
	 * @var boolean
	 */
	protected $escapeOutput = false;

    /**
     * Arguments initialization
     *
     */
    public function initializeArguments()
    {
        $this->registerArgument('start', 'mixed', 'a string that is accepted by DateTime constructor');
        $this->registerArgument('end', 'mixed', 'a string that is accepted by DateTime constructor');
    }

	/**
	 *
	 * @return string Rendered string
	 * @api
	 */
	public function render() {
        [
            'start' => $start,
            'end' => $end,
        ] = $this->arguments;
        if(is_null($end)) {
            $end = $start;
        }
        $map = array();
        $map = array_merge(array('sameDay' => 'sameDay', 'sameMonth' => 'sameMonth', 'sameYear' => 'sameYear', 'differentYear' => 'differentYear'), $map);
		$variables = array();
		$variables[$map['sameDay']] = $start->format('Y-m-d') == $end->format('Y-m-d');
		$variables[$map['sameMonth']] = !$variables[$map['sameDay']] && ($start->format('Y-m') == $end->format('Y-m'));
		$variables[$map['sameYear']] = !$variables[$map['sameDay']] && !$variables[$map['sameMonth']] && ($start->format('Y') == $end->format('Y'));
		$variables[$map['differentYear']] = !($variables[$map['sameDay']] || $variables[$map['sameMonth']] || $variables[$map['sameYear']]);
		foreach ($variables as $aliasName => $value) {
			$this->templateVariableContainer->add($aliasName, $value);
		}
		$output = $this->renderChildren();
		foreach ($variables as $aliasName => $value) {
			$this->templateVariableContainer->remove($aliasName);
		}
		return $output;
	}
}

?>
