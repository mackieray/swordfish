<?php
/*
 * Project  : swordfish
 * Filename : phpbuilder.php
 * Create by: Ray
 * Date     : 2015-05-26
 * Time     : 12:45
 */

if(isset($_REQUEST['key'])) {
    $OAuth = $_REQUEST['key'];
    if ($OAuth == "") {
        die("Unauthorised Access!");
    }
}else{
    die("Unauthorised Access!");
}
echo "<link rel='stylesheet' href='style.css' rel='stylesheet' type='text/css'>";
require_once(__DIR__ . '/githubphp/client/GitHubClient.php');

$owner = 'TimoSolo';
$repo = 'spiraleye_openerp_addons_6.1';

$client = new GitHubClient();
//$client->setCredentials($username, $password);
$client->setOauthKey($OAuth);
$client->setPage();
$client->setPageSize(20);
$issues = $client->issues->listIssues($owner, $repo);
//Issue Count: " . count($issues) ."
$html = "<div class='layout'>
    <div class='hdr-layout'>
    <div class='hdr-layout-row'>
    <div class='hdr-layout-cell'>#</div>
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

    if($n==0) {
        //$labels = $client->issues->labels->listLabelsOnAnIssue($owner, $repo, $issue->getNumber());
        $labels = $client->issues->labels->listAllLabelsForThisRepository($owner, $repo);
        echo "<pre>";
        var_dump($labels);
        echo "</pre>";
        die();
    }

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
        "<div class='layout-cell'>" . $n . ".&nbsp;</div>".
        "<div class='layout-cell'>" . $client . "</div>".
        "<div class='layout-cell'>" . $title . "</div>".
        "<div class='layout-cell'>" . $body . "</div>".
        "<div class='layout-cell'>" . $issue->getNumber() ."</div>".
        "<div class='layout-cell'>" . $priority . "</div>".
        "<div class='layout-cell'>" . $category . "</div>".
        "<div class='layout-cell'>" . $assign . "</div>".
        "<div class='layout-cell'>" . $comment . "</div>".
        "<div class='layout-cell'>" . $status . "</div>".
        "</div>
        ";
    //<div class='spacer'></div>

    $n++;
}
$html .= "</div>";
echo $html;
