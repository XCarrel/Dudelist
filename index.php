<?php
$page = 'home';
if(isset($_GET["page"]) && $_GET["page"] != '')
{
    $page = htmlspecialchars($_GET["page"]);
    switch ($page)
    {
        case 'home':
        case 'list':
        case 'profile':
            break;
        default:
            $page='error';
            $errormessage = "La page demandée n'existe pas";
    }
}
ob_start();
include("sources/pages/$page/$page.php"); // "call" to the controller
$content = ob_get_contents();
ob_end_clean();

include("layout.html");
?>
