<?php 

class CRM_Pcptab_BAO_PCPs{
	
	public static function getPCPs(&$params) {

	$status = CRM_PCP_BAO_PCP::buildOptions('status_id', 'create');

    // get all contribution pages
    $query = "SELECT id, title FROM civicrm_contribution_page";
    $cpages = CRM_Core_DAO::executeQuery($query);
    while ($cpages->fetch()) {
      $pages['contribute'][$cpages->id]['id'] = $cpages->id;
      $pages['contribute'][$cpages->id]['title'] = $cpages->title;
    }
	
    $query = "SELECT id, title
                  FROM civicrm_event
                  WHERE is_template IS NULL OR is_template != 1";
    $epages = CRM_Core_DAO::executeQuery($query);
    while ($epages->fetch()) {
      $pages['event'][$epages->id]['id'] = $epages->id;
      $pages['event'][$epages->id]['title'] = $epages->title;
    }
	
	$queryParam = array(1 => array($params['contact_id'], 'Integer'),2 => array($params['limit'], 'Integer'),3 => array($params['offset'], 'Integer'));

	$query = "SELECT pcp.id ,pcp.title, pcp.status_id, pcp.page_type, pcp.page_id,pcp.goal_amount, pcp.currency as pcp_currency
        FROM civicrm_pcp pcp
        WHERE pcp.contact_id=%1 ORDER BY pcp.id desc  LIMIT %2 OFFSET %3";	

    $pcps = array();
    $dao = CRM_Core_DAO::executeQuery($query, $queryParam);
    while ($dao->fetch()) {
		$pcp_url =  CRM_Utils_System::url('civicrm/pcp/info', 'reset=1&id=' . $dao->id);
    	$pcps[$dao->id]['id'] =  $dao->id;
   		$pcps[$dao->id]['pcp_url'] =  '<a target="_blank" href="'.$pcp_url.'">'.$dao->title.'</a>';
   		$pcps[$dao->id]['status_id'] =  $status[$dao->status_id];
		
	  $page_type = $dao->page_type;
      $page_id = (int) $dao->page_id;
      $title = $pages[$page_type][$page_id]['title'];

      if ($page_type == 'contribute') {
        $pageUrl = CRM_Utils_System::url('civicrm/' . $page_type . '/transact', 'reset=1&id=' . $page_id);
      }
      else {
        $pageUrl = CRM_Utils_System::url('civicrm/' . $page_type . '/register', 'reset=1&id=' . $page_id);
      }
	  
		
   		$pcps[$dao->id]['page_url'] =  '<a target="_blank" href="'.$pageUrl.'">'.$title.'</a>';
		$pcps[$dao->id]['goal_amount'] =  CRM_Utils_Money::format($dao->goal_amount, $dao->pcp_currency);
		list($no_of_contribution,$amount_raised) = CRM_Pcptab_BAO_PCPs::getContributionsTotal($dao->id);
		$pcps[$dao->id]['no_of_contribution'] =  ($no_of_contribution  == '' ? '0' : $no_of_contribution) ;
		$pcps[$dao->id]['amount_raised'] =  CRM_Utils_Money::format(($amount_raised  == '' ? '0' : $amount_raised),$dao->pcp_currency) ;
		$editURL =  CRM_Utils_System::url('civicrm/pcp/info', 'action=update&reset=1&id=' . $dao->id);
		$pcps[$dao->id]['links'] =  '<a  class="action-item crm-hover-button" title="Edit Personal Campaign Page" href="'.$editURL.'">Edit</a>';
    }
	
	$pcps['data'] = $pcps;
	$queryParam = array(1 => array($params['contact_id'], 'Integer'));
	$query = "SELECT count(*) as count FROM civicrm_pcp WHERE contact_id=%1";	
    $dao = CRM_Core_DAO::executeQuery($query, $queryParam);
	$dao->fetch();
	$pcps['totalCount'] = $dao->count;
    return $pcps;
  }
  
    public static function getContributionsTotal($pcpId) {
    $query = "
		SELECT COUNT(*) as no_of_contribution,SUM(cc.total_amount) as amount_raised
		FROM civicrm_pcp pcp
		LEFT JOIN civicrm_contribution_soft cs ON ( pcp.id = cs.pcp_id )
		LEFT JOIN civicrm_contribution cc ON ( cs.contribution_id = cc.id)
		WHERE pcp.id = %1 AND cc.contribution_status_id =1 AND cc.is_test = 0";
    $params = array(1 => array($pcpId, 'Integer'));
	$da = CRM_Core_DAO::executeQuery($query, $params);
	$da->fetch();
    return array($da->no_of_contribution,$da->amount_raised);
  }
  
  public static function getPCPsCount($contactID) {
	$queryParam = array(1 => array($contactID, 'Integer'));
	$query = "SELECT count(*) as count FROM civicrm_pcp WHERE contact_id=%1";	
    $dao = CRM_Core_DAO::executeQuery($query, $queryParam);
	$dao->fetch();
	return $dao->count;
  }
  
  public static function getRawPCPs($parms){
	if (isset($parms['contact_id'])){
		$queryParam = array(1 => array($parms['contact_id'], 'Integer'));
	  	$query = "SELECT * FROM civicrm_pcp WHERE contact_id=%1";	
	}else{
		$queryParam = array();
	  	$query = "SELECT * FROM civicrm_pcp";	
	}
	$dao = CRM_Core_DAO::executeQuery($query, $queryParam);
	return $dao->fetchAll();
  }
}