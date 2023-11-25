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

  /** @var string */
  private $activeTimeBegin;

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
    $postModel->minimumRaise = ServerRequestManager::postMinimumRaise();
    $postModel->isPriceSuggestion = ServerRequestManager::postIsPriceSuggestion();
    $postModel->deliveryId = $this->deliveryId;
    $postModel->paymentId = $this->paymentId;
    $this->activeTimeBegin = ServerRequestManager::postActiveTimeBegin();
    $postModel->activeTimeBegin = $this->activeTimeBegin;
    $postModel->activeTimeEnd = $this->getActiveTimeEnd();
    $postModel->onlyToIdentifiedUsers = ServerRequestManager::postOnlyToIdentifiedUsers();
    return $postModel->save();
  }

  private function getActiveTimeEnd()
  {
    $activeTimeEnd = ServerRequestManager::postActiveTimeEnd();
    return date('y-m-d', strtotime($this->activeTimeBegin . " + $activeTimeEnd days"));
  }

  private function saveImageDetails()
  {

  }
}
