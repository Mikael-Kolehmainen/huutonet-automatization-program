<?php

namespace public_site\controller;

use api\manager\HuutonetManager;
use api\manager\ServerRequestManager;

class CategoryController
{
  /** @var string */
  public $selectedCategory;

  public function showCategories(): void
  {
    $huutonetManager = new HuutonetManager();
    $mainCategories = $huutonetManager->fetchMainCategories();
    $huutonetManager->mainCategoryId = $mainCategories[0]["id"];
    $subCategories = $huutonetManager->fetchSubCategories();
    $huutonetManager->subCategoryId = $subCategories[0]["id"];
    $subSubCategories = $huutonetManager->fetchSubSubCategories();

    echo "<select id='main-category' name='main-category' required>";
    foreach ($mainCategories as $category) {
      $selected = $this->isSelected($category["id"]);
      echo "<option value='$category[id]' $selected>$category[title]</option>";
    }
    echo "
      </select>
      <select id='sub-category' name='sub-category' required>
    ";
    foreach ($subCategories as $subCategory) {
      $selected = $this->isSelected($subCategory["id"]);
      echo "<option value='$subCategory[id]' $selected>$subCategory[title]</option>";
    }
    echo "
      </select>
      <select id='category' name='category' required>
    ";
    foreach ($subSubCategories as $subSubCategory) {
      $selected = $this->isSelected($subSubCategory["id"]);
      echo "<option value='$subSubCategory[id]' $selected>$subSubCategory[title]</option>";
    }
    echo "</select>";
  }

  private function isSelected($categoryId): string
  {
    return $this->selectedCategory == $categoryId ? "selected" : "";
  }

  public function getSubCategoriesAsJSON(): void
  {
    $huutonetManager = new HuutonetManager();
    $huutonetManager->mainCategoryId = ServerRequestManager::getUriParts()[4];
    $subCategories = $huutonetManager->fetchSubCategories();
    $json = json_encode($subCategories);

    echo $json;
  }

  public function getSubSubCategoriesAsJSON(): void
  {
    $huutonetManager = new HuutonetManager();
    $huutonetManager->subCategoryId = ServerRequestManager::getUriParts()[4];
    $subSubCategories = $huutonetManager->fetchSubSubCategories();
    $json = json_encode($subSubCategories);

    echo $json;
  }
}
