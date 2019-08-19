<?php
namespace Undkonsorten\Eventmgmt\ViewHelpers\Form;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;
use TYPO3\CMS\Frontend\Resource\FilePathSanitizer;

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
 
 class TinyMceViewHelper extends \TYPO3Fluid\Fluid\ViewHelpers\Form\AbstractFormFieldViewHelper
 {
     
     /**
      * @var string
      */
     protected $tagName = 'textarea';
     
     
     
     /**
      * Initialize the arguments.
      *
      * @return void
      * @api
      */
     public function initializeArguments() {
         parent::initializeArguments();
         $this->registerTagAttribute('autofocus', 'string', 'Specifies that a text area should automatically get focus when the page loads');
         $this->registerTagAttribute('rows', 'int', 'The number of rows of a text area');
         $this->registerTagAttribute('cols', 'int', 'The number of columns of a text area');
         $this->registerTagAttribute('disabled', 'string', 'Specifies that the input element should be disabled when the page loads');
         $this->registerTagAttribute('placeholder', 'string', 'The placeholder of the textarea');
         $this->registerArgument('errorClass', 'string', 'CSS class to set if there are errors for this view helper', FALSE, 'f3-form-error');
         $this->registerUniversalTagAttributes();
     }
     

     /**
      * Renders the textarea.
      *
      * @return string
      * @api
      */
     public function render() {
         $this->loadJs();
         $name = $this->getName();
         $this->registerFieldNameForFormTokenGeneration($name);
     
         $this->tag->forceClosingTag(TRUE);
         $this->tag->addAttribute('name', $name);
         $this->tag->addAttribute('id', 'tinymce');
         $this->tag->setContent($this->getValue());
     
         $this->setErrorClassAttribute();
     
         return $this->tag->render();
     }
     
     protected function loadJs(){
        $extConf = $GLOBALS['TYPO3_CONF_VARS']['EXTENSIONS']['eventmgmt'];
        if(!$extConf['deactivateTinyMceJs']){
            $pageRenderer = GeneralUtility::makeInstance(PageRenderer::class);
            $path = GeneralUtility::makeInstance(FilePathSanitizer::class)->sanitize('EXT:eventmgmt/Resources/Public/Js/tinymce/tinymce.min.js');
            $pageRenderer->addJsFile($path, null, true);
            $path = GeneralUtility::makeInstance(FilePathSanitizer::class)->sanitize('EXT:eventmgmt/Resources/Public/Js/tinymce/initTinyMce.js');
            $pageRenderer->addJsFile($path, null, true);
        }
     }
 }
