<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2010-2014 punkt.de GmbH - Karlsruhe, Germany - http://www.punkt.de
 *  Authors: Daniel Lienert, Michael Knoll
 *  All rights reserved
 *
 *  For further information: http://extlist.punkt.de <extlist@punkt.de>
 *
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 *
 * example: {extlist:Sql.Filter(filter:filter.filterbox.roleFilter,filterField:'compcheck.role_uid')}
 *
 * @author Daniel Lienert
 * @package ViewHelpers
 */
class Tx_PtExtlist_ViewHelpers_Sql_FilterViewHelper extends Tx_Fluid_Core_ViewHelper_AbstractViewHelper {

	/**
	 * @param Tx_PtExtlist_Domain_Model_Filter_FilterInterface $filter
	 * @param string $filterField
	 *
	 * @return string
	 */
	public function render(Tx_PtExtlist_Domain_Model_Filter_FilterInterface $filter, $filterField = '') {

		if(!$filter->isActive()) {
			return '1 = 1';
		}

		if($filter instanceof Tx_PtExtlist_Domain_Model_Filter_DateRangeFilter){
			return sprintf('%s >= %s AND %1$s <= %s',$filterField, strtotime($filter->getFilterValueFrom()),strtotime($filter->getFilterValueTo()));
		}


		$filterValue = $filter->getValue();
		$filterField = $filterField ? $filterField : $filter->getFilterConfig()->getFieldIdentifier();

		if(is_array($filterValue)) {
			return sprintf('%s in (%s)', $filterField, implode(', ', $filterValue));
		} else {
			return sprintf('%s = %s', $filterField, $filterValue);
		}
	}
}