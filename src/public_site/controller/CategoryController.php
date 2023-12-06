<?php

namespace public_site\controller;

use api\manager\CurlManager;
use api\manager\HuutonetManager;

class CategoryController
{
  /** @var string */
  public $selectedCategory;

  public function showCategories(): void
  {
    $categories = $this->getCategories();

    echo "<select id='category' name='category' required>";
    foreach ($categories as $category) {
      $selected = $this->isSelected($category["id"]);
      echo "<option value='$category[id]' $selected>$category[title]</option>";
    }
    echo "</select>";
  }

  private function getCategories()
  {
    $huutonetManager = new HuutonetManager();
    return $huutonetManager->fetchCategories();
  }

  private function isSelected($categoryId): string
  {
    return $this->selectedCategory == $categoryId ? "selected" : "";
  }
}
