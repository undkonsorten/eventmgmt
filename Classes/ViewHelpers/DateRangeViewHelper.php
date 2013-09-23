<?php
namespace Undkonsorten\Event\ViewHelpers;

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
class DateRangeViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper {

	/**
	 *
	 * @param \DateTime $start the startdate
	 * @param \DateTime $end the enddate
	 * @param array $map variable name mapping for sameDay, sameMonth, sameYear
	 * @return string Rendered string
	 * @api
	 */
	public function render(\DateTime $start, \DateTime $end = NULL, array $map = array()) {
		if(is_null($end)) {
			$end = $start;
		}
		$map = array_merge(array('sameDay' => 'sameDay', 'sameMonth' => 'sameMonth', 'sameYear' => 'sameYear'), $map);
		$variables = array();
		$variables[$map['sameDay']] = $start->format('Y-m-d') == $end->format('Y-m-d');
		$variables[$map['sameMonth']] = !$variables['sameDay'] && ($start->format('Y-m') == $end->format('Y-m'));
		$variables[$map['sameYear']] = !$variables['sameDay'] && !$variables['sameMonth'] && ($start->format('Y') == $end->format('Y'));
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
