<?php

namespace public_site\controller;

use api\manager\ServerRequestManager;
use api\model\Database;
use api\model\FileModel;
use api\model\ImageModel;

class ImageController
{
  /** @var int */
  public $postId;

  /** @var Database */
  private $db;

  public function __construct()
  {
    $this->db = new Database();
  }

  public function saveImages(): void
  {
    $imageFiles = ServerRequestManager::filesImages();
    for ($i = 0; $i < count($imageFiles["name"]); $i++) {
      $imageFile = [
        "name" => $imageFiles["name"][$i],
        "tmp_name" => $imageFiles["tmp_name"][$i]
      ];
      $fileModel = new FileModel($imageFile, "/src/public_site/media/posts/");
      $fileModel->generateFileName();

      $imageModel = new ImageModel($this->db);
      $imageModel->imagePath = $fileModel->createFilePath();
      $fileModel->saveFileToServer();
      $imageModel->postId = $this->postId;
      $imageModel->save();
    }
  }

  /** @return ImageModel[] */
  public function getImages()
  {
    $imageModel = new ImageModel($this->db);
    $imageModel->postId = $this->postId;
    return $imageModel->load();
  }

  public function deleteImage(): void
  {
    $imageModel = new ImageModel($this->db);
    $imageModel->postId = $this->postId;
    $imageModel->delete();
  }
}
