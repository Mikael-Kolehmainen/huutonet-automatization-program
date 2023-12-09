<?php

use public_site\controller\EditController;
use public_site\controller\ErrorController;
use public_site\controller\HomeController;
use public_site\controller\BrowseController;
use public_site\controller\NewController;
use public_site\controller\SuccessController;
use public_site\controller\PostController;
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
        <script src='/src/public_site/js/common/ElementDisplay.js' defer></script>
  ";
}

switch ($uri[2]) {
  case "":
    showHome();
    break;
  case "new-post":
    showNew();
    break;
	case "browse-posts":
		showBrowse();
		break;
  case "edit-post":
    showEdit();
    break;
  case "post":
    switch ($uri[3]) {
      case "insert":
        if (ServerRequestManager::issetCreatePost()) {
          savePost();
        }
        break;
      case "update":
        if (ServerRequestManager::issetEditPost() && $uri[4]) {
          updatePost();
        }
        break;
      case "delete":
        if ($uri[4]) {
          deletePost();
        }
        break;
      case "upload":
        if (ServerRequestManager::issetUploadPost()) {
          uploadPost();
        }
        break;
    }
  case "upload-success":
    showUploadSuccess();
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

function showNew(): void
{
	$newController = new NewController();
	$newController->showNewPage();
}

function showBrowse(): void
{
	$browseController = new BrowseController();
	$browseController->showBrowsePage();
}

function showEdit(): void
{
  $editController = new EditController();
  $editController->showEditPage();
}

function savePost(): void
{
  $postController = new PostController();
  $postController->savePost();
}

function updatePost(): void
{
  $postController = new PostController();
  $postController->updatePost();
}

function deletePost(): void
{
  $postController = new PostController();
  $postController->deletePost();
}

function uploadPost(): void
{
  $postController = new PostController();
  $postController->uploadPost();
}

function showUploadSuccess(): void
{
  $successController = new SuccessController();
  $successController->showSuccessPage();
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
