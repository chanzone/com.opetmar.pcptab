<?php


function civicrm_api3_personal_campaign_pages_get($params) {
  $returnValues = CRM_Pcptab_BAO_PCPs::getRawPCPs($params);
  return civicrm_api3_create_success($returnValues, $params, 'PersonalCampaignPages', 'Get');
}

function _civicrm_api3_personal_campaign_pages_get_spec(&$params) {
  $params['contact_id']['api.default'] = 1;
}