<?php

/**
 * OSSMail checkMails action class
 * @package YetiForce.Action
 * @copyright YetiForce Sp. z o.o.
 * @license YetiForce Public License 2.0 (licenses/License.html or yetiforce.com)
 */
class OSSMail_checkMails_Action extends Vtiger_Action_Controller
{

	/**
	 * Function to check permission
	 * @param \App\Request $request
	 * @throws \App\Exceptions\NoPermitted
	 */
	public function checkPermission(\App\Request $request)
	{
		$currentUserPriviligesModel = Users_Privileges_Model::getCurrentUserPrivilegesModel();
		if (!$currentUserPriviligesModel->hasModulePermission($request->getModule())) {
			throw new \App\Exceptions\NoPermitted('LBL_PERMISSION_DENIED');
		}
	}

	public function process(\App\Request $request)
	{
		$users = $request->get('users');
		$output = [];
		if (count($users) > 0) {
			OSSMail_Record_Model::updateMailBoxmsgInfo($users);
			$output = OSSMail_Record_Model::getMailBoxmsgInfo($users);
		}
		$response = new Vtiger_Response();
		$response->setResult($output);
		$response->emit();
	}
}
