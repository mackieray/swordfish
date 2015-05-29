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
$html = "<div class='container'>
    <div class='hdr-layout'>
    <div class='hdr-layout-cell'>
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

    if($n==0) {
        //$issue->getNumber() != NULL$issue->getNumber()
        $assignee = $client->issues->assignees->listAssignees($owner, $repo);
        echo "<pre>";
        var_dump($assignee);
        echo "</pre>";
        die();
    }
    if(($n % 2)!=0){$bgcolor = '#DEEAF6';}else{$bgcolor = '#FFFFFF';}
    $labels = $client->issues->labels->listLabelsOnAnIssue($owner, $repo, $issue->getNumber());
    echo "<pre>";
    var_dump($assignee);
    echo "</pre>";
    die();

    $client = '';
    $priority = '';
    $category = '';
    $assignee = '';
    $comment = '';
    $status = '';
    $title = $issue->getTitle();
    $body = $issue->getBody();
    $num = $issue->getNumber();


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

    $html .= "<div class='row' style='background-color: $bgcolor;'>".
        "<div class='column'>" . $n . ".&nbsp;</div>".
        "<div class='column'>" . $client . "</div>".
        "<div class='column'>" . $title . "</div>".
        "<div class='column'>" . $body . "</div>".
        "<div class='column'>" . $num ."</div>".
        "<div class='column'>" . $priority . "</div>".
        "<div class='column'>" . $category . "</div>".
        "<div class='column'>" . $assignee . "</div>".
        "<div class='column'>" . $comment . "</div>".
        "<div class='column'>" . $status . "</div>".
        "</div>
        ";
    //<div class='spacer'></div>

    $n++;
}
$html .= "</div>";
echo $html;
