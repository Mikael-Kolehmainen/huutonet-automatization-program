<?php

namespace api\manager;

class RedirectManager
{
  public static function redirectToNewPost(): void
  {
    echo "<script>window.location.href = '/index.php/new-post';</script>";
  }

  public static function redirectToBrowsePosts(): void
  {
    echo "<script>window.location.href = '/index.php/browse-posts';</script>";
  }

  public static function redirectToUploadSuccess(): void
  {
    echo "<script>window.location.href = '/index.php/upload-success';</script>";
  }
}
