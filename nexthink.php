<?php

if (!defined('__DIR__')) define('__DIR__', dirname(__FILE__));
if (!defined('APPROOT')) require_once(__DIR__.'/../../approot.inc.php');
require_once(APPROOT.'application/application.inc.php');
require_once(APPROOT.'application/itopwebpage.class.inc.php');
require_once(APPROOT.'application/startup.inc.php');
require_once(APPROOT.'application/loginwebpage.class.inc.php');
require_once(__DIR__.'/vendor/php-nexthink/src/NexthinkClient.php');

/////////////////////////////////////////////////////////////////////
// Main program
//
LoginWebPage::DoLogin(); // Check user rights and prompt if needed

//$oP = new iTopWebPage(Dict::S('bkp-status-title'));
$oP = new iTopWebPage("NeXthink Details");
$oP->set_base(utils::GetAbsoluteUrlAppRoot().'pages/');

$sName = $_GET["name"];

//utils::GetAbsoluteUrlAppRoot();
// have to retrieve module name
$module_name = "nexthink";

try
{

        $oP->add('<div class="object-details-header">');
        $oP->add('<div class="object-icon"><img src="http://itopdev.ght-espo.lan/env-production/nexthink/images/nexthink.png" style="vertical-align:middle;"></div>');
        $oP->add('<div class="object-infos">');
        $oP->add('<h1 class="object-name">Détail de la machine : <span class="hilite">'.$sName.'</span></h1>');
        $oP->add('</div>');    
        $oP->add('</div>');    

        $oP->AddTabContainer('tabs1');
        $oP->SetCurrentTabContainer('tabs1');
        
        $oP->AddAjaxTab(Dict::S('UI:tab-hardware'), utils::GetAbsoluteUrlAppRoot().'pages/exec.php?exec_module='.$module_name.'&exec_page=nexthink_hardware.php&name='.$sName, true /* bCache */);
        $oP->AddAjaxTab(Dict::S('UI:tab-network'), utils::GetAbsoluteUrlAppRoot().'pages/exec.php?exec_module='.$module_name.'&exec_page=nexthink_network.php&name='.$sName, true /* bCache */);
        $oP->AddAjaxTab(Dict::S('UI:tab-startup'), utils::GetAbsoluteUrlAppRoot().'pages/exec.php?exec_module='.$module_name.'&exec_page=nexthink_startup.php&name='.$sName, true /* bCache */);
        $oP->AddAjaxTab(Dict::S('UI:tab-operating_system'), utils::GetAbsoluteUrlAppRoot().'pages/exec.php?exec_module='.$module_name.'&exec_page=nexthink_operating_system.php&name='.$sName, true /* bCache */);
        $oP->AddAjaxTab(Dict::S('UI:tab-local_drives'), utils::GetAbsoluteUrlAppRoot().'pages/exec.php?exec_module='.$module_name.'&exec_page=nexthink_local_drives.php&name='.$sName, true /* bCache */);
        $oP->AddAjaxTab(Dict::S('UI:tab-security'), utils::GetAbsoluteUrlAppRoot().'pages/exec.php?exec_module='.$module_name.'&exec_page=nxt_security.php&name='.$sName, true /* bCache */);
        
}
catch(Exception $e)
{
	$oP->p('<b>'.$e->getMessage().'</b>');
}

$oP->output();

?>