<?php
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2010-2011 punkt.de GmbH - Karlsruhe, Germany - http://www.punkt.de
 *  Authors: Daniel Lienert, Michael Knoll, Christoph Ehscheidt
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
 * Testcase for base configuration
 *
 * @package Tests
 * @subpackage Domain\Configuration\Base
 * @author Daniel Lienert
 * @see Tx_PtExtlist_Domain_Configuration_Base_BaseConfig
 */
class Tx_PtExtlist_Tests_Domain_Configuration_Base_BaseConfigTest extends Tx_PtExtlist_Tests_BaseTestcase
{
    /**
     * @var Tx_PtExtlist_Domain_Configuration_Base_BaseConfig
     */
    protected $baseConfig;



    /**
     * @var array
     */
    protected $configArray;


    
    public function setup()
    {
        $this->initDefaultConfigurationBuilderMock();
        
        $this->configArray = ['uncachedSessionStorageAdapter' => 'uncachedSessionStorageAdapter',
                                   'cachedSessionStorageAdapter' => 'cachedSessionStorageAdapter'
        ];
        
        $this->baseConfig = new Tx_PtExtlist_Domain_Configuration_Base_BaseConfig($this->configurationBuilderMock, $this->configArray);
    }


    
    /**
     * @test
     */
    public function getCachedSessionStorageAdapter()
    {
        $this->assertEquals($this->baseConfig->getCachedSessionStorageAdapter(), 'cachedSessionStorageAdapter');
    }
    
    
    
    /**
     * @test
     */
    public function getUncachedSessionStorageAdapter()
    {
        $this->assertEquals($this->baseConfig->getUncachedSessionStorageAdapter(), 'uncachedSessionStorageAdapter');
    }



    /** @test */
    public function getResetOnEmptySubmitReturnsTrueIfSetInSettingsArray()
    {
        $this->configArray['resetOnEmptySubmit'] = '1';
        $baseConfig = new Tx_PtExtlist_Domain_Configuration_Base_BaseConfig($this->configurationBuilderMock, $this->configArray);
        $this->assertEquals($baseConfig->getResetOnEmptySubmit(), true);
    }



    /** @test */
    public function getResetOnEmptySubmitReturnsFalseIfNotSetInSettingsArray()
    {
        $this->configArray['resetOnEmptySubmit'] = null;
        $baseConfig = new Tx_PtExtlist_Domain_Configuration_Base_BaseConfig($this->configurationBuilderMock, $this->configArray);
        $this->assertEquals($baseConfig->getResetOnEmptySubmit(), false);
    }

    /** @test */
    public function getResetSessionOnResetParameterReturnsTrueIfSetInSettingsArray()
    {
        $this->configArray['resetSessionOnResetParameter'] = '1';
        $baseConfig = new Tx_PtExtlist_Domain_Configuration_Base_BaseConfig($this->configurationBuilderMock, $this->configArray);
        $this->assertEquals($baseConfig->getResetSessionOnResetParameter(), true);
    }



    /** @test */
    public function getResetSessionOnResetParameterReturnsFalseIfNotSetInSettingsArray()
    {
        $this->configArray['resetSessionOnResetParameter'] = null;
        $baseConfig = new Tx_PtExtlist_Domain_Configuration_Base_BaseConfig($this->configurationBuilderMock, $this->configArray);
        $this->assertEquals($baseConfig->getResetSessionOnResetParameter(), false);
    }
}
