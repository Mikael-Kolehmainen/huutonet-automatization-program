<?php

namespace api\manager;

class HuutonetManager
{
  /** @var string */
  private $rootUrl = "https://api.huuto.net/1.1";

  /** @var string */
  public $imagesUrl;

  /** @var string */
  private $username;

  /** @var string */
  private $password;

  /** @var string */
  private $authenticationToken;

  /** @var array */
  public $postItem;

  /** @var array */
  public $postImage;

  public function __construct($username="", $password="")
  {
    $this->username = $username;
    $this->password = $password;
  }

  public function fetchCategories(): mixed
  {
    $categoryCurl = new CurlManager("$this->rootUrl/categories/");
    $categoriesObj = $categoryCurl->fetch();
    $categories = [];

    $categoryCounter = 0;
    foreach ($categoriesObj as $categoryObj) {
      if ($categoryCounter++ <= 3) continue;
      foreach ($categoryObj as $category) {
        $subCategoryCurl = new CurlManager($category["links"]["subcategories"]);
        $subCategoriesObj = $subCategoryCurl->fetch();

        $subCategoryCounter = 0;
        foreach ($subCategoriesObj as $subCategoryObj) {
          if ($subCategoryCounter++ <= 3) continue;
          foreach ($subCategoryObj as $subCategory) {
            $subSubCategoryCurl = new CurlManager($subCategory["links"]["subcategories"]);
            $subSubCategoriesObj = $subSubCategoryCurl->fetch();

            $subSubCategoryCounter = 0;
            foreach ($subSubCategoriesObj as $subSubCategoryObj) {
              if ($subSubCategoryCounter++ <= 3) continue;
              foreach ($subSubCategoryObj as $subSubCategory) {
                array_push($categories, [ "id" => $subSubCategory["id"], "title" => $subSubCategory["title"] ]);
              }
            }
          }
        }
      }
    }

    return $categories;
  }

  public function authenticateUser(): string|null
  {
    $parameters = [
      "username" => $this->username,
      "password" => $this->password
    ];
    $authenticationCurl = new CurlManager(
      "$this->rootUrl/authentication",
      "POST",
      $parameters
    );

    $response = $authenticationCurl->fetch();
    $this->authenticationToken = $response["authentication"]["token"]["id"];
    return $this->authenticationToken;
  }

  public function createItem(): array
  {
    $createItemCurl = new CurlManager(
      "$this->rootUrl/items",
      "POST",
      $this->postItem,
      ["X-HuutoApiToken: $this->authenticationToken"]
    );

    return $createItemCurl->fetch();
  }

  public function addImageToItem()
  {
    $addImageCurl = new CurlManager(
      $this->imagesUrl,
      "POST",
      $this->postImage,
      ["X-HuutoApiToken: $this->authenticationToken"]
    );

    return $addImageCurl->fetch();
  }
}
