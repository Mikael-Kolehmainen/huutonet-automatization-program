<?php

namespace public_site\controller;

use api\model\Database;

class ImageController
{
  /** @var Database */
  private $db;

  public function __construct()
  {
    $this->db = new Database();
  }

  public function saveImage(): void
  {

  }
}
