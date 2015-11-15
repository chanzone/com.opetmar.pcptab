<?php

class CRM_Pcptab_Page_AJAX {

  /**
   * Retrieve contact PCPs.
   */
  public static function getContactPCPs() {
    $contactID = CRM_Utils_Request::retrieve( 'cid', 'Positive', $this, true );

    $sEcho = CRM_Utils_Request::retrieve( 'sEcho', 'Positive', $this, true );
    $page = isset($_REQUEST['iDisplayStart']) ? CRM_Utils_Request::retrieve( 'iDisplayStart', 'Positive', $this, true ) : 0;
    $limit = isset($_REQUEST['iDisplayLength']) ? CRM_Utils_Request::retrieve( 'iDisplayLength', 'Positive', $this, true ) : 25;
	
    $page = $page/$limit;

    $params['limit'] = $limit;
    $params['offset'] = ($page*$limit);
	
    $params['contact_id'] = $contactID;
	
    // get the contact pcps
    $pcps = CRM_Pcptab_BAO_PCPs::getPCPs($params);
    $iFilteredTotal = $iTotal = $pcps['totalCount'];
    $selectorElements = array(
      'pcp_url',
	  'status_id',
	  'page_url',
	  'no_of_contribution',
	  'amount_raised',
	  'goal_amount',
	  'links',
    );

    header('Content-Type: application/json');
    echo CRM_Utils_JSON::encodeDataTableSelector($pcps['data'], $sEcho, $iTotal, $iFilteredTotal, $selectorElements);
    CRM_Utils_System::civiExit();
  }

}
