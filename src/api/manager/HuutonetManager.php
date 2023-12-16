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

  /** @var string */
  public $itemLink;

  /** @var number */
  public $mainCategoryId;

  /** @var number */
  public $subCategoryId;

  public function __construct($username="", $password="")
  {
    $this->username = $username;
    $this->password = $password;
  }

  public function fetchMainCategories(): mixed
  {
    $categoryCurl = new CurlManager("$this->rootUrl/categories/");
    $categoriesObj = $categoryCurl->fetch();
    $categories = [];

    $categoryCounter = 0;
    foreach ($categoriesObj as $categoryObj) {
      if ($categoryCounter++ <= 3) continue;
      foreach ($categoryObj as $category) {
        array_push($categories, [ "id" => $category["id"], "title" => $category["title"] ]);
      }
    }
    return $categories;
  }

  public function fetchSubCategories(): mixed
  {
    $subCategoryCurl = new CurlManager("$this->rootUrl/categories/$this->mainCategoryId/subcategories");
    $subCategoriesObj = $subCategoryCurl->fetch();
    $subCategories = [];

    $subCategoryCounter = 0;
    foreach ($subCategoriesObj as $subCategoryObj) {
      if ($subCategoryCounter++ <= 3) continue;
      foreach ($subCategoryObj as $subCategory) {
        array_push($subCategories, [ "id" => $subCategory["id"], "title" => $subCategory["title"] ]);
      }
    }
    return $subCategories;
  }

  public function fetchSubSubCategories(): mixed
  {
    $subSubCategoryCurl = new CurlManager("$this->rootUrl/categories/$this->subCategoryId/subcategories");
    $subSubCategoriesObj = $subSubCategoryCurl->fetch();
    $subSubCategories = [];

    $subSubCategoryCounter = 0;
    foreach ($subSubCategoriesObj as $subSubCategoryObj) {
      if ($subSubCategoryCounter++ <= 3) continue;
      foreach ($subSubCategoryObj as $subSubCategory) {
        array_push($subSubCategories, [ "id" => $subSubCategory["id"], "title" => $subSubCategory["title"] ]);
      }
    }
    return $subSubCategories;
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

  public function publishItem()
  {
    $publishItemCurl = new CurlManager(
      $this->itemLink,
      "PUT",
      ["status" => "published"],
      ["X-HuutoApiToken: $this->authenticationToken"]
    );

    return $publishItemCurl->fetch();
  }
}
