<?php
namespace Undkonsorten\Eventmgmt\Domain\Model;

/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2015 Eike Starkmann <es@undkonsorten.com>, undkonsorten
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
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
 
 class Ensemble extends \TYPO3\CMS\Extbase\Domain\Model\FrontendUser
 {
     protected $status;
     
     protected $cfxClFirstname;
     
     protected $cfxClLastname;
     
     protected $cfxClTitle;

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    public function getCfxClFirstname()
    {
        return $this->cfxClFirstname;
    }

    public function setCfxClFirstname($cfxClFirstname)
    {
        $this->cfxClFirstname = $cfxClFirstname;
        return $this;
    }

    public function getCfxClLastname()
    {
        return $this->cfxClLastname;
    }

    public function setCfxClLastname($cfxClLastname)
    {
        $this->cfxClLastname = $cfxClLastname;
        return $this;
    }

    public function getCfxClTitle()
    {
        return $this->cfxClTitle;
    }

    public function setCfxClTitle($cfxClTitle)
    {
        $this->cfxClTitle = $cfxClTitle;
        return $this;
    }
 
     
     
 }