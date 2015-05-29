<?php
/*
 * Project  : swordfish
 * Filename : phpjson.php
 * Create by: Ray
 * Date     : 2015-05-28
 * Time     : 11:19
 */

if(isset($_REQUEST['key'])) {
    $OAuth = $_REQUEST['key'];
    if ($OAuth == "") {
        die("Unauthorised Access!");
    }
}else{
    die("Unauthorised Access!");
}

$owner = 'TimoSolo';
$repo = 'spiraleye_openerp_addons_6.1';

echo "<link rel='stylesheet' href='style.css' rel='stylesheet' type='text/css'>";

//exec("C:\Program Files (x86)\Git\bin\curl --url https://api.github.com/repos/$owner/$repo/issues > response.json");
//"curl https://api.github.com/repos/TimoSolo/spiraleye_openerp_addons_6.1/issues > response.json";
//$url1 =  "curl https://api.github.com/repos/$owner/$repo/issues > response.json";
$url2 =  "https://api.github.com/repos/$owner/$repo/issues";

$html = "<div class='container'>

    <div class='row hdr'>
    <div class='column'>#</div>
    <div class='column'>Client<br>Name</div>
    <div class='column'>Action<br>Item/Request</div>
    <div class='column'>Description</div>
    <div class='column'>GH Number</div>
    <div class='column'>Priority<br>(High, Med, Low)</div>
    <div class='column'>Category<br>(Bug, Enhancement,<br>Reporting, OPS Support)</div>
    <div class='column'>Assigned To</div>
    <div class='column'>Comments</div>
    <div class='column'>Status</div>
    </div>";

// Read the file contents into a string variable, and parse the string into a data structure
$output = file_get_contents("response.json");
$issues = json_decode($output,true);
if(count($issues)<1){die("Sorry but there are no issues to list.");}

$n = 1;
foreach ($issues as $issue)
{
    //initailize ariables
    $client = 'Unknown';
    $clients = $issue['labels'];
    $cnt = count($clients);
    $priority = 'None';
    $category = 'None';
    if(is_null($issue['assignee'])){ $assignee = $issue['assignee'];}else{$assignee = '';}
    $comment = $issue['comments'];
    $status = $issue['state'];
    $title = $issue['title'];
    $body = $issue['body'];
    $num = $issue['number'];

    //eyeline
    if(($n % 2)!=0){$bgcolor = '#DEEAF6';}else{$bgcolor = '#FFFFFF';}

    for($c=0;$c<$cnt;$c++){
        $nme = $clients[$c]['name'].'<br>';
        $prefix = substr($nme,0,2);
        switch($prefix){
            case 'C:':
                $client = $nme;
                break;
            case 'P:':
                $priority = $nme;
                break;
            default:
                $category = $nme;
                break;
        }
    }

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

    $n++;
}
$html .= "</div>";
echo $html;

function addIssue()
{
//Modify the value, and write the structure to a file "data_out.json"
$data["boss"]["Hobbies"][0] = "Swimming";
$fh = fopen("response.json", 'w')
or die("Error opening output file");
fwrite($fh, json_encode($data,JSON_UNESCAPED_UNICODE));
fclose($fh);
}