<?php

namespace public_site\controller;

use api\manager\CurlManager;
use api\manager\HuutonetManager;

class CategoryController
{
  public function showCategories(): void
  {
    $categories = $this->getCategories();

    echo "<select id='category' name='category' required>";
    foreach ($categories as $category) {
      echo "<option value='$category[id]'>$category[title]</option>";
    }
    echo "</select>";
  }

  private function getCategories()
  {
    $huutonetManager = new HuutonetManager();
    return $huutonetManager->fetchCategories();
  }
}
