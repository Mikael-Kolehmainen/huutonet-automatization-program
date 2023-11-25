<?php

namespace api\manager;

class RedirectManager
{
  public static function redirectToNewPost()
  {
    echo "<script>window.location.href = '/index.php/new-post';</script>";
  }
}
