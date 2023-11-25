<?php

namespace api\manager;

class HuutonetManager
{
  private $rootUrl = "https://api.huuto.net/1.1";

  public function fetchCategories(): mixed
  {
    $categoryCurl = new CurlManager("$this->rootUrl/categories/");
    $categoriesObj = $categoryCurl->fetch();
    $categories = [];

    $categoryCounter = 0;
    foreach ($categoriesObj as $categoryObj) {
      if ($categoryCounter++ <= 3) continue;
      foreach ($categoryObj as $category) {
        array_push($categories, [ "id" => $category["id"], "title" => $category["title"]]);

        $subCategoryCurl = new CurlManager($category["links"]["subcategories"]);
        $subCategoriesObj = $subCategoryCurl->fetch();

        $subCategoryCounter = 0;
        foreach ($subCategoriesObj as $subCategoryObj) {
          if ($subCategoryCounter++ <= 3) continue;
          foreach ($subCategoryObj as $subCategory) {
            array_push($categories, [ "id" => $subCategory["id"], "title" => $subCategory["title"]]);
          }
        }
      }
    }

    return $categories;
  }
}