<?php
/**
 * @author Xavier
 * @version 1.3
 * Date: 28.08.17
 * Time: 14:15
 *
 * Entry point of the application.
 * Performs the route analysis and invokes the proper controller
 *
 * History:
 *      v1.3    Introduces routes
 *      v1.2    Introduces JQuery and Ajax calls to get GIT username details
 *      v1.1    Form validation (user profile) with JS
 *      v1.0    First cut: MVC structure, json files for data storage
 *
 */

$appVersion = "v1.4";

// Route analysis
$routeparts = explode("/", $_SERVER['REQUEST_URI']); // The URI starts with a '/' so $routeparts[0] will be void
$page = $routeparts[1];
switch ($page)
{
    case 'profile':
        $id = $routeparts[2];
    case 'home':
    case 'list':
        break;
    default:
        $page = 'error';
        $errormessage = "La page demandée n'existe pas";
}

ob_start();
include("sources/pages/$page/$page.php"); // "call" to the controller
$content = ob_get_contents();
ob_end_clean();

include("layout.html");
?>
