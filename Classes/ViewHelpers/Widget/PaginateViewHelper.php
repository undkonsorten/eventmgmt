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

use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;
use TYPO3\CMS\Fluid\Core\Widget\AbstractWidgetViewHelper;
use Undkonsorten\Eventmgmt\ViewHelpers\Widget\Controller\PaginateController;

/**
 * This ViewHelper renders a Pagination of objects.
 *
 * = Examples =
 *
 * <code title="required arguments">
 * <f:widget.paginate objects="{blogs}" as="paginatedBlogs">
 * use {paginatedBlogs} as you used {blogs} before, most certainly inside
 * a <f:for> loop.
 * </f:widget.paginate>
 * </code>
 *
 * <code title="full configuration">
 * <f:widget.paginate objects="{blogs}" as="paginatedBlogs" configuration="{itemsPerPage: 5, insertAbove: 1, insertBelow: 0, maximumNumberOfLinks: 10}">
 * use {paginatedBlogs} as you used {blogs} before, most certainly inside
 * a <f:for> loop.
 * </f:widget.paginate>
 * </code>
 *
 * = Performance characteristics =
 *
 * In the above examples, it looks like {blogs} contains all Blog objects, thus
 * you might wonder if all objects were fetched from the database.
 * However, the blogs are NOT fetched from the database until you actually use them,
 * so the paginate ViewHelper will adjust the query sent to the database and receive
 * only the small subset of objects.
 * So, there is no negative performance overhead in using the Paginate Widget.
 *
 * @api
 */
class PaginateViewHelper extends AbstractWidgetViewHelper {

	/**
	 * @var PaginateController
	 */
	protected $controller;

	/**
     * AbstractWidgetController
     *
	 * @param PaginateController $controller
	 * @return void
	 */
	public function injectController(PaginateController $controller) {
		$this->controller = $controller;
	}

    /**
     * Arguments initialization
     *
     */
    public function initializeArguments()
    {
        $this->registerArgument('objects', QueryResultInterface::class, 'Object data', true);
        $this->registerArgument('as', 'string', '"as" string used', true);
        $this->registerArgument('pagination', 'string', '"as" string used', true);
        $this->registerArgument('additionalParams', 'array', '"as" string used', false, []);
        $this->registerArgument('additionalParamsPrefix', 'string', '"as" string used', false, '');
        $this->registerArgument('configuration', 'array', 'configuration for itemsPerPage, insertAbove, insertBelow, maximumNumberOfLinks', false, ['itemsPerPage' => 10, 'insertAbove' => false, 'insertBelow' => true, 'maximumNumberOfLinks' => 99]);
    }

	/**
     *
	 * @return string
	 */
	public function render() {
		return $this->initiateSubRequest();
	}
}
