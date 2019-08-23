<?php
namespace Undkonsorten\Eventmgmt\ViewHelpers\Widget;

/*                                                                        *
 * This script is backported from the TYPO3 Flow package "TYPO3.Fluid".   *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU Lesser General Public License, either version 3   *
 *  of the License, or (at your option) any later version.                *
 *                                                                        *
 *                                                                        *
 * This script is distributed in the hope that it will be useful, but     *
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHAN-    *
 * TABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Lesser       *
 * General Public License for more details.                               *
 *                                                                        *
 * You should have received a copy of the GNU Lesser General Public       *
 * License along with the script.                                         *
 * If not, see http://www.gnu.org/licenses/lgpl.html                      *
 *                                                                        *
 * The TYPO3 project - inspiring people to share!                         *
 *                                                                        */
/**
 * A view helper for creating Links to extbase actions within widets.
 *
 * = Examples =
 *
 * <code title="URI to the show-action of the current controller">
 * <f:widget.link action="show">link</f:widget.link>
 * </code>
 * <output>
 * <a href="index.php?id=123&tx_myextension_plugin[widgetIdentifier][action]=show&tx_myextension_plugin[widgetIdentifier][controller]=Standard&cHash=xyz">link</a>
 * (depending on the current page, widget and your TS configuration)
 * </output>
 *
 * @api
 */
class LinkViewHelper extends \TYPO3Fluid\Fluid\Core\ViewHelper\AbstractTagBasedViewHelper {

	/**
	 * @var string
	 */
	protected $tagName = 'a';

	/**
	 * Initialize arguments
	 *
	 * @return void
	 * @api
	 */
	public function initializeArguments() {
		$this->registerUniversalTagAttributes();
		$this->registerTagAttribute('name', 'string', 'Specifies the name of an anchor');
		$this->registerTagAttribute('rel', 'string', 'Specifies the relationship between the current document and the linked document');
		$this->registerTagAttribute('rev', 'string', 'Specifies the relationship between the linked document and the current document');
		$this->registerTagAttribute('target', 'string', 'Specifies where to open the linked document');

//        $this->registerArgument('action', 'string', 'Target action');
        $this->registerArgument('arguments', 'array', 'Arguments');
        $this->registerArgument('additionalParams', 'array', 'additionalParamsPrefix');
        $this->registerArgument('additionalParamsPrefix', 'string', 'additionalParamsPrefix');
        $this->registerArgument('section', 'string', 'The anchor to be added to the URI');
        $this->registerArgument('format', 'string', 'The requested format, e.g. ".html"');
        $this->registerArgument('ajax', 'boolean', 'TRUE if the URI should be to an AJAX widget, FALSE otherwise.');
	}

	/**
	 * Render the link.
	 *
	 * @return string The rendered link
	 * @api
	 */
	public function render() {
        $arguments = array();
        $additionalParams = array();
        [
            'arguments' => $arguments,
            'additionalParams' => $additionalParams,
            'additionalParamsPrefix' => $additionalParamsPrefix,
            'section' => $section,
            'format' => $format,
            'ajax' => $ajax,
        ] = $this->arguments;
		if ($ajax === TRUE) {
			$uri = $this->getAjaxUri();
		} else {
			$uri = $this->getWidgetUri();
		}
		$this->tag->addAttribute('href', $uri);
		$this->tag->setContent($this->renderChildren());
		return $this->tag->render();
	}

	/**
	 * Get the URI for an AJAX Request.
	 *
	 * @return string the AJAX URI
	 */
	protected function getAjaxUri() {
		$action = $this->arguments['action'];
		$arguments = $this->arguments['arguments'];
		$additionalParams = $this->arguments['additionalParams'];
		$additionalParamsPrefix = $this->arguments['additionalParamsPrefix'];
		
		$arguments[$additionalParamsPrefix] = $additionalParams;
		if ($action === NULL) {
			$action = $this->renderingContext->getControllerContext()->getRequest()->getControllerActionName();
		}
		$arguments['id'] = $GLOBALS['TSFE']->id;
		// TODO page type should be configurable
		$arguments['type'] = 7076;
		$arguments['fluid-widget-id'] = $this->renderingContext->getControllerContext()->getRequest()->getWidgetContext()->getAjaxWidgetIdentifier();
		$arguments['action'] = $action;
		return '?' . http_build_query($arguments, NULL, '&');
	}

	/**
	 * Get the URI for a non-AJAX Request.
	 *
	 * @return string the Widget URI
	 */
	protected function getWidgetUri() {
		$uriBuilder = $this->renderingContext->getControllerContext()->getUriBuilder();
		$argumentPrefix = $this->renderingContext->getControllerContext()->getRequest()->getArgumentPrefix();
		$arguments = $this->hasArgument('arguments') ? $this->arguments['arguments'] : array();
		$additionalParams = $this->hasArgument('additionalParams') ? $this->arguments['additionalParams'] : array();
		$additionalParamsPrefix = $this->hasArgument('additionalParamsPrefix') ? $this->arguments['additionalParamsPrefix'] : '';
		if ($this->hasArgument('action')) {
			$arguments['action'] = $this->arguments['action'];
		}
		if ($this->hasArgument('format') && $this->arguments['format'] !== '') {
			$arguments['format'] = $this->arguments['format'];
		}
		return $uriBuilder
			->reset()
			->setArguments(array($argumentPrefix => $arguments, $additionalParamsPrefix => $additionalParams))
			->setSection($this->arguments['section'])
			->setAddQueryString(TRUE)
			->setArgumentsToBeExcludedFromQueryString(array($argumentPrefix, 'cHash'))
			->setFormat($this->arguments['format'])
			->build();
	}
}

?>
