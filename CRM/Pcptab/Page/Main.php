<?php

require_once 'CRM/Core/Page.php';

class CRM_Pcptab_Page_Main extends CRM_Core_Page {
  
  public $_contactId = NULL;

  public function run() {

    $this->_contactId = CRM_Utils_Request::retrieve( 'cid', 'Positive', $this, true );
    $this->assign( 'contactId', $this->_contactId );

    return parent::run();
  }
  
}
