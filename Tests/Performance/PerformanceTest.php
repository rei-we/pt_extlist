<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2010-2011 punkt.de GmbH - Karlsruhe, Germany - http://www.punkt.de
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
 * Performance Testcase
 *
 * @package Tests
 * @subpackage Performance
 * @author Daniel Lienert
 */
class Tx_PtExtlist_Tests_Performance_Performance_testcase extends Tx_PtExtlist_Tests_BaseTestcase {

	/**
	 * @var string
	 */
	protected $baseConfigTSFile;


	/**
	 * @var array
	 */
	protected $listConfiguration = array();


	public function setup() {
		$this->baseConfigTSFile = t3lib_extMgm::extPath('pt_extlist') . 'Configuration/TypoScript/setup.txt';
	}


	/**
	 * @test
	 */
	public function performance() {



		$listSettings = $this->getExtListTypoScript();

		$memoryBefore = memory_get_usage(true);

		Tx_PtExtlist_ExtlistContext_ExtlistContextFactory::setExtListTyposSript($listSettings);
		$extlistContext = Tx_PtExtlist_ExtlistContext_ExtlistContextFactory::getContextByListIdentifier('performanceTestList');
		$renderedListData = $extlistContext->getRenderedListData();

		
		$usedMemory = memory_get_usage(true) - $memoryBefore;
		$readableMemoryUsage = $usedMemory / (1024*1024);

		echo 'Memory Usage: ' . $readableMemoryUsage . ' MB';

		die();
	}


	protected function getExtListTypoScript() {

		$extListConfigFile = __DIR__ . '/TestListConfiguration.ts';

		$tSString = $this->readTSString($this->baseConfigTSFile);
		$tSString .= $this->readTSString($extListConfigFile);

		$parserInstance = t3lib_div::makeInstance('t3lib_tsparser'); /** @var $parserInstance t3lib_tsparser */
		$tSString = $parserInstance->checkIncludeLines($tSString);
		$parserInstance->parse($tSString);


		$tsSettings = $parserInstance->setup;

		$typoScript = Tx_Extbase_Utility_TypoScript::convertTypoScriptArrayToPlainArray($tsSettings);

		return $typoScript['plugin']['tx_ptextlist'];
	}



	/**
	 * Read the list configuration from  file
	 *
	 * @param $pathAndFileName
	 * @return string
	 */
	protected function readTSString($pathAndFileName) {

		$typoScriptArray = file($pathAndFileName);

		if($typoScriptArray === FALSE) {
			$this->fail('Could not read from file ' . $pathAndFileName);
		}

		return implode("\n", $typoScriptArray);
	}

}

?>