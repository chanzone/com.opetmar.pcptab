<?php

require_once 'CRM/Core/Page.php';

class CRM_Pcptab_Page_Main extends CRM_Core_Page {
  
  public $_contactId = NULL;

  public function run() {

    $this->_contactId = CRM_Utils_Request::retrieve( 'cid', 'Positive', $this, true );
    $this->assign( 'contactId', $this->_contactId );

    // check logged in url permission
    require_once 'CRM/Contact/Page/View.php';
    CRM_Contact_Page_View::checkUserPermission( $this );

    return parent::run();
  }
  
}
