<?php

require_once 'checkflow.civix.php';

/**
 * Implements hook_civicrm_buildForm().
 *
 * @link
 * http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_buildForm
 */
function checkflow_civicrm_buildForm($formName, &$form) {
  if ($formName == 'CRM_Activity_Form_Activity') {
    // Depending on how this form is called, the activity type may be pre-set in
    // the URL.
    if (isset($_GET['atype'])) {
      //force to int
      $atype = (int) $_GET['atype'];
      CRM_Core_Resources::singleton()->addVars('checkflow', array('atype' => $atype));
    }
    // add the Javascript to control the display of the activity entry form.
    if ($form->_action == CRM_Core_Action::ADD || $form->_action == CRM_Core_Action::UPDATE) {
      CRM_Core_Resources::singleton()->addScriptFile('org.saintfranciscocc.checkflow', 'js/checkflow.js');
    }
    // Add the activity history to the page.
    if ($form->_action == CRM_Core_Action::VIEW  && $form->_activityTypeName == 'Check Request') {
      checkflow_getActivityLog($form->_activityId, $form);
      CRM_Core_Region::instance('page-body')->add(array(
        'template' => 'CRM/Checkflow/ActivityLog.tpl',
      ));
    }
  }
}

function checkflow_getActivityLog($activityId, &$form) {
  $query = "
  SELECT lca.log_date, cc.display_name, cov.label
  FROM log_civicrm_activity lca
  LEFT JOIN civicrm_contact cc ON lca.log_user_id = cc.id
  LEFT JOIN civicrm_option_value cov ON lca.status_id = cov.value
  JOIN civicrm_option_group cog ON cov.option_group_id = cog.id
  WHERE lca.id = %1 AND cog.name = 'activity_status'
  ORDER BY lca.log_date DESC
  ";

  $params = array(1 => array($activityId, 'Integer'));
  $dao = CRM_Core_DAO::executeQuery($query, $params);

  $i = 0;

  while ($dao->fetch()) {
    $activityLog[$i]['log_date'] = $dao->log_date;
    $activityLog[$i]['editor'] = $dao->display_name;
    $activityLog[$i]['status'] = $dao->label;
    $i++;
  }
  $dao->free();
  $form->assign('activityLog', $activityLog);
}

/**
 * Implements hook_civicrm_config().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_config
 */
function checkflow_civicrm_config(&$config) {
  _checkflow_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_xmlMenu().
 *
 * @param $files array(string)
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_xmlMenu
 */
function checkflow_civicrm_xmlMenu(&$files) {
  _checkflow_civix_civicrm_xmlMenu($files);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_install
 */
function checkflow_civicrm_install() {
  _checkflow_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_uninstall().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_uninstall
 */
function checkflow_civicrm_uninstall() {
  _checkflow_civix_civicrm_uninstall();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_enable
 */
function checkflow_civicrm_enable() {
  _checkflow_civix_civicrm_enable();
}

/**
 * Implements hook_civicrm_disable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_disable
 */
function checkflow_civicrm_disable() {
  _checkflow_civix_civicrm_disable();
}

/**
 * Implements hook_civicrm_upgrade().
 *
 * @param $op string, the type of operation being performed; 'check' or 'enqueue'
 * @param $queue CRM_Queue_Queue, (for 'enqueue') the modifiable list of pending up upgrade tasks
 *
 * @return mixed
 *   Based on op. for 'check', returns array(boolean) (TRUE if upgrades are pending)
 *                for 'enqueue', returns void
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_upgrade
 */
function checkflow_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _checkflow_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implements hook_civicrm_managed().
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_managed
 */
function checkflow_civicrm_managed(&$entities) {
  _checkflow_civix_civicrm_managed($entities);
}

/**
 * Implements hook_civicrm_caseTypes().
 *
 * Generate a list of case-types
 *
 * Note: This hook only runs in CiviCRM 4.4+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_caseTypes
 */
function checkflow_civicrm_caseTypes(&$caseTypes) {
  _checkflow_civix_civicrm_caseTypes($caseTypes);
}

/**
 * Implements hook_civicrm_angularModules().
 *
 * Generate a list of Angular modules.
 *
 * Note: This hook only runs in CiviCRM 4.5+. It may
 * use features only available in v4.6+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_caseTypes
 */
function checkflow_civicrm_angularModules(&$angularModules) {
_checkflow_civix_civicrm_angularModules($angularModules);
}

/**
 * Implements hook_civicrm_alterSettingsFolders().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_alterSettingsFolders
 */
function checkflow_civicrm_alterSettingsFolders(&$metaDataFolders = NULL) {
  _checkflow_civix_civicrm_alterSettingsFolders($metaDataFolders);
}

/**
 * Functions below this ship commented out. Uncomment as required.
 *

/**
 * Implements hook_civicrm_preProcess().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_preProcess
 *
function checkflow_civicrm_preProcess($formName, &$form) {

}

*/
