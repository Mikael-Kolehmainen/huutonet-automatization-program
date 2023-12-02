<?php

namespace public_site\controller;

use api\manager\RedirectManager;
use api\manager\ServerRequestManager;
use api\model\Database;
use api\model\PostModel;

class PostController
{
  /** @var int */
  private $paymentId;

  /** @var int */
  private $deliveryId;

  /** @var int */
  private $postId;

  /** @var Database */
  private $db;

  public function __construct()
  {
    $this->db = new Database();
  }

  public function savePost(): void
  {
    $this->paymentId = $this->savePostPaymentDetails();
    $this->deliveryId = $this->savePostDeliveryDetails();
    $this->postId = $this->savePostDetails();
    $this->saveImageDetails();
    RedirectManager::redirectToNewPost();
  }

  private function savePostPaymentDetails(): int
  {
    $paymentController = new PaymentController();
    return $paymentController->savePayment();
  }

  private function savePostDeliveryDetails(): int
  {
    $deliveryController = new DeliveryController();
    return $deliveryController->saveDelivery();
  }

  private function savePostDetails(): int
  {
    $postModel = new PostModel($this->db);
    $postModel->title = ServerRequestManager::postTitle();
    $postModel->description = ServerRequestManager::postDescription();
    $postModel->itemCondition = ServerRequestManager::postItemCondition();
    $postModel->zipCode = ServerRequestManager::postZipCode();
    $postModel->isOutsideOfFinland = ServerRequestManager::postIsOutsideOfFinland();
    $postModel->category = ServerRequestManager::postCategory();
    $postModel->sellType = ServerRequestManager::postSellType();
    $postModel->price = ServerRequestManager::postPrice();
    $postModel->minimumRaise = $this->getMinimumRaise();
    $postModel->isPriceSuggestion = ServerRequestManager::postIsPriceSuggestion();
    $postModel->deliveryId = $this->deliveryId;
    $postModel->paymentId = $this->paymentId;
    $postModel->activeTimeBegin = ServerRequestManager::postActiveTimeBegin();
    $postModel->activeTimeEnd = $this->getActiveTimeEnd();
    $postModel->onlyToIdentifiedUsers = ServerRequestManager::postOnlyToIdentifiedUsers();
    return $postModel->save();
  }

  private function getMinimumRaise()
  {
    if (ServerRequestManager::postSellType() == "buy-now") {
      return 0;
    }

    $price = ServerRequestManager::postPrice();
    if (!$price) return 0;
    if ($price < 49.99) return 1;
    if ($price < 99.99) return 2;
    if ($price < 499.99) return 5;
    if ($price < 999.99) return 10;

    return 20;
  }

  private function getActiveTimeEnd(): string
  {
    $activeTimeEndDays = ServerRequestManager::postActiveTimeEnd();
    return date('y-m-d', strtotime(ServerRequestManager::postActiveTimeBegin() . " + $activeTimeEndDays days"));
  }

  private function saveImageDetails(): void
  {
    $imageController = new ImageController();
    $imageController->postId = $this->postId;
    $imageController->saveImages();
  }

  public function getPosts()
  {
    $postModel = new PostModel($this->db);
    $posts = $postModel->loadAll();

    foreach ($posts as $post) {
      $this->postId = $post->id;
      $this->paymentId = $post->paymentId;
      $this->deliveryId = $post->deliveryId;

      $post->paymentDetails = $this->getPostPaymentDetails();
      $post->deliveryDetails = $this->getPostDeliveryDetails();
      $post->imageDetails = $this->getImageDetails();

      unset($post->paymentId);
      unset($post->deliveryId);
    }

    return $posts;
  }

  private function getPostPaymentDetails()
  {
    $paymentController = new PaymentController();
    $paymentController->paymentId = $this->paymentId;
    return $paymentController->getPayment();
  }

  private function getPostDeliveryDetails()
  {
    $deliveryController = new DeliveryController();
    $deliveryController->deliveryId = $this->deliveryId;
    return $deliveryController->getDelivery();
  }

  private function getImageDetails()
  {
    $imageController = new ImageController();
    $imageController->postId = $this->postId;
    return $imageController->getImages();
  }
}
