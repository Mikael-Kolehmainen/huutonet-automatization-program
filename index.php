<?php

use public_site\controller\ErrorController;
use public_site\controller\HomeController;
use public_site\controller\BrowseController;
use public_site\controller\NewController;
use api\manager\ServerRequestManager;

require __DIR__ . "/src/inc/bootstrap.php";

session_start();

$uri = ServerRequestManager::getUriParts();

if ($uri[2] != "ajax") {
  echo "
    <!DOCTYPE html>
    <html>
      <head>
        <meta name='viewport' content='width=device-width, initial-scale=1'>
        <link rel='icon' type='image/x-icon' href='/src/public_site/media/icons/favicon.svg'>
        <link href='/src/public_site/styles/css/main.css' rel='stylesheet' type='text/css'>
  ";
}

switch ($uri[2]) {
  case "":
    showHome();
    break;
	case "browse-posts":
		showBrowse();
		break;
	case "new-post":
		showNew();
		break;
  case "error":
    showError("Error title", "This is the error page.", "/index.php");
    break;
  default:
    showError(
      "404 Not Found",
      "The page you're looking for doesn't exist.",
      "/index.php"
    );
    exit();
}

if ($uri[2] != "ajax") {
  echo "
      </body>
    </html>
  ";
}

function showHome(): void
{
  $homeController = new HomeController();
  $homeController->showHomePage();
}

function showBrowse(): void
{
	$browseController = new BrowseController();
	$browseController->showBrowsePage();
}

function showNew(): void
{
	$newController = new NewController();
	$newController->showNewPage();
}

/**
 * @param string $title
 * @param string $message
 * @param string $link
 */
function showError($title, $message, $link): void
{
  $errorController = new ErrorController($title, $message, $link);
  $errorController->showErrorPage();
}
