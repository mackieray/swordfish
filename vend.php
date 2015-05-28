<?php
/*
 * Project  : swordfish
 * Filename : vend.php
 * Create by: Ray
 * Date     : 2015-05-27
 * Time     : 11:50
 */
namespace Github;

$owner = 'TimoSolo';
$repo = 'spiraleye_openerp_addons_6.1';
use Github;

// This file is generated by Composer
require_once 'vendor/autoload.php';

$client = new \Github\Client();
$repositories = $client->api('user')->repositories($repo);
$issues = $client->api('issue')->find($owner,$repo, 'closed', 'bug');
echo "<pre>";
var_dump($issues);
echo "</pre>";
die();
$issue = $client->api('issue')->show($owner,$repo, 1);
$client->api('issue')->all($owner,$repo, array('labels' => 'label name'));

$html = "<div class='hdr-layout'>Issue Count: " . count($issues) ."
    <div class='hdr-layout-row'>
    <div class='hdr-layout-cell'>Client<br>Name</div>
    <div class='hdr-layout-cell'>Action<br>Item/Request</div>
    <div class='hdr-layout-cell'>Description</div>
    <div class='hdr-layout-cell'>GH Number</div>
    <div class='hdr-layout-cell'>Priority<br>(High, Med, Low)</div>
    <div class='hdr-layout-cell'>Category<br>(Bug, Enhancement,<br>Reporting, OPS Support)</div>
    <div class='hdr-layout-cell'>Assigned To</div>
    <div class='hdr-layout-cell'>Comments</div>
    <div class='hdr-layout-cell'>Status</div>
    </div>";
$n = 1;
foreach ($issues as $issue)
{
    $client = '';
    $priority = '';
    $category = '';
    $assign = '';
    $comment = '';
    $status = '';
    $title = $issue->getTitle();
    $body = $issue->getBody();
    $num = $issue->getNumber();
    //$issue->getNumber() != NULL

    $labels = $client->issues->labels->listLabelsOnAnIssue($owner, $repo, $issue->getNumber());
//    foreach($labels as $label){
//        if($label->getName() != NULL) {
//            $prefix = substr($label->getName(), 0, 2);
//            switch ($prefix) {
//                case "C:":
//                    $client = substr($label->getName(), 2);
//                    break;
//                case "P:":
//                    $priority = substr($label->getName(), 2);
//                    break;
//                default:
//                    switch (strtolower($label->getName())) {
//                        case "reporting":
//                            $category = 'Reporting';
//                            break;
//                        case "bug":
//                            $category = 'Bug';
//                            break;
//                        case "Enhancement":
//                            $category = 'Enhancement';
//                            break;
//                    }
//                    break;
//            }
//        }
//    }

    $html .= "<div class='layout-row'>".
        "<div class='layout-cell'>" . $client . "</div>".
        "<div class='layout-cell'>" . $title . "</div>".
        "<div class='layout-cell'>" . $body . "</div>".
        "<div class='layout-cell'>" . $num ."</div>".
        "<div class='layout-cell'>" . $priority . "</div>".
        "<div class='layout-cell'>" . $category . "</div>".
        "<div class='layout-cell'>" . $assign . "</div>".
        "<div class='layout-cell'>" . $comment . "</div>".
        "<div class='layout-cell'>" . $status . "</div>".
        "</div>";

    $n++;
}
$html .= "</div>";
echo $html;
