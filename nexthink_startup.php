<?php

if (!defined('__DIR__')) define('__DIR__', dirname(__FILE__));
if (!defined('APPROOT')) require_once(__DIR__.'/../../approot.inc.php');
require_once(APPROOT.'application/application.inc.php');
require_once(APPROOT.'application/itopwebpage.class.inc.php');
require_once(APPROOT.'application/ajaxwebpage.class.inc.php');
require_once(APPROOT.'application/startup.inc.php');
require_once(APPROOT.'application/loginwebpage.class.inc.php');
require_once(__DIR__.'/vendor/php-nexthink/src/NexthinkClient.php');

/////////////////////////////////////////////////////////////////////
// Main program
//
LoginWebPage::DoLogin(); // Check user rights and prompt if needed

$sName = $_GET["name"];

$oP = new ajax_page('');

$nxt =  new NeXthinkClient();
$sQuery = "(select (number_of_days_since_last_boot last_boot_duration average_boot_duration last_logon_time last_logon_duration last_logged_on_user privileges_of_last_logged_on_users average_logon_duration)(from device (where device (eq name (string \"".$sName."\")))) )";

$jSon = $nxt->execute($sQuery, NeXthinkClient::FORMAT_JSON);
$aData = json_decode($jSon, true);        

$aDetails = array();
foreach ($aData[0] as $key => $value) {

    if (is_array($value)){
        $value = implode($value,',');
    }

    $aDetails[] = [
        "nom"   => Dict::S('UI:nxt-device-'.$key),
        "valeur" => $value,
    ];
}

$aConfig = array(
        'nom'   => array('label' => "Nom", 'description' => "Nom de l'attribut nexThink"),
        'valeur'   => array('label' => "Valeur", 'description' => "Valeur"),
);

$oP->add('<div style="max-height:400px; overflow: auto;" id="tbl_startup">');
$oP->table($aConfig, $aDetails);
$oP->add('</div>');
$oP->add_ready_script('$("#tbl_startup table.listResults").tableHover();');
$oP->add_ready_script('$("#tbl_startup table.listResults").tablesorter( { widgets: ["myZebra", "truncatedList"]} );');

$oP->output();
?>

