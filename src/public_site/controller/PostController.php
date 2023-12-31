<?php

namespace public_site\controller;

use api\manager\HuutonetManager;
use api\manager\RedirectManager;
use api\manager\ServerRequestManager;
use api\model\Database;
use api\model\PostModel;
use stdClass;

class PostController
{
  /** @var int */
  private $paymentId;

  /** @var int */
  private $deliveryId;

  /** @var int */
  private $postId;

  /** @var object */
  private $post;

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
    $this->savePostImageDetails();
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

  private function savePostImageDetails(): void
  {
    $imageController = new ImageController();
    $imageController->postId = $this->postId;
    $imageController->saveImages();
  }

  /** @return mixed[] */
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

  private function getImageDetails(): array
  {
    $imageController = new ImageController();
    $imageController->postId = $this->postId;
    return $imageController->getImages();
  }

  /** @return mixed */
  public function getPostWithUriId()
  {
    $this->postId = ServerRequestManager::getUriParts()[3];
    return $this->getPost();
  }

  /** @return mixed */
  private function getPost()
  {
    $postModel = new PostModel($this->db);
    $postModel->id = $this->postId;
    $post = $postModel->load();
    $this->deliveryId = $post->deliveryId;
    $this->paymentId = $post->paymentId;
    $post->paymentDetails = $this->getPostPaymentDetails();
    $post->deliveryDetails = $this->getPostDeliveryDetails();
    $post->imageDetails = $this->getImageDetails();
    return $post;
  }

  public function updatePost(): void
  {
    $this->postId = ServerRequestManager::getUriParts()[4];
    $postRelatedIds = $this->getPostRelatedIds();
    $this->paymentId = $postRelatedIds->paymentId;
    $this->deliveryId = $postRelatedIds->deliveryId;

    $this->updatePostPaymentDetails();
    $this->updatePostDeliveryDetails();
    $this->updatePostDetails();
    $this->updatePostImageDetails();
    RedirectManager::redirectToBrowsePosts();
  }

  private function updatePostPaymentDetails(): void
  {
    $paymentController = new PaymentController();
    $paymentController->paymentId = $this->paymentId;
    $paymentController->updatePayment();
  }

  private function updatePostDeliveryDetails(): void
  {
    $deliveryController = new DeliveryController();
    $deliveryController->deliveryId = $this->deliveryId;
    $deliveryController->updateDelivery();
  }

  private function updatePostDetails(): void
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
    $postModel->id = $this->postId;
    $postModel->update();
  }

  private function updatePostImageDetails(): void
  {
    $imageController = new ImageController();
    $imageController->postId = $this->postId;
    $imageController->updateImages();
  }

  public function deletePost(): void
  {
    $this->postId = ServerRequestManager::getUriParts()[4];
    $postRelatedIds = $this->getPostRelatedIds();
    $this->paymentId = $postRelatedIds->paymentId;
    $this->deliveryId = $postRelatedIds->deliveryId;

    $this->deletePostImageDetails();
    $this->deletePostDetails();
    $this->deletePostPaymentDetails();
    $this->deletePostDeliveryDetails();
    RedirectManager::redirectToBrowsePosts();
  }

  private function getPostRelatedIds()
  {
    $postModel = new PostModel($this->db);
    $postModel->id = $this->postId;
    $post = $postModel->load();

    $postRelatedIds = new stdClass();
    $postRelatedIds->postId = $post->id;
    $postRelatedIds->paymentId = $post->paymentId;
    $postRelatedIds->deliveryId = $post->deliveryId;
    return $postRelatedIds;
  }

  private function deletePostPaymentDetails(): void
  {
    $paymentController = new PaymentController();
    $paymentController->paymentId = $this->paymentId;
    $paymentController->deletePayment();
  }

  private function deletePostDeliveryDetails(): void
  {
    $deliveryController = new DeliveryController();
    $deliveryController->deliveryId = $this->deliveryId;
    $deliveryController->deleteDelivery();
  }

  private function deletePostDetails(): void
  {
    $postModel = new PostModel($this->db);
    $postModel->id = $this->postId;
    $postModel->delete();
  }

  private function deletePostImageDetails(): void
  {
    $imageController = new ImageController();
    $imageController->postId = $this->postId;
    $imageController->deleteImage();
  }

  public function uploadPost(): void
  {
    $selectedPostsIds = ServerRequestManager::postSelectedPosts();

    $this->changePostActiveTimes($selectedPostsIds);

    $huutonetManager = new HuutonetManager(
      ServerRequestManager::postHuutonetUsername(),
      ServerRequestManager::postHuutonetPassword()
    );
    $this->authenticateHuutonetUser($huutonetManager);

    foreach ($selectedPostsIds as $selectedPostId) {
      $createItemResponse = $this->createHuutonetItem($selectedPostId, $huutonetManager);
      $huutonetManager->imagesUrl = $createItemResponse["links"]["images"];

      foreach ($this->post->imageDetails as $imageDetails) {
        $this->addImageToHuutonetItem($imageDetails, $huutonetManager);
      }

      $huutonetManager->itemLink = $createItemResponse["links"]["self"];
      $this->publishHuutonetItem($huutonetManager);
    }

    RedirectManager::redirectToUploadSuccess();
  }

  /**
   * @param array $selectedPostsIds
   */
  private function changePostActiveTimes($selectedPostsIds): void
  {
    if (ServerRequestManager::postChangeActiveTime()) {
      foreach ($selectedPostsIds as $selectedPostId) {
        $postModel = new PostModel($this->db);
        $postModel->id = $selectedPostId;
        $postModel->activeTimeBegin = ServerRequestManager::postActiveTimeBegin();
        $postModel->activeTimeEnd = $this->getActiveTimeEnd();
        $postModel->updateActiveTimes();
      }
    }
  }

  /**
   * @param HuutonetManager $huutonetManager
   */
  private function authenticateHuutonetUser($huutonetManager): string
  {
    $authenticationToken = $huutonetManager->authenticateUser();
    if (!$authenticationToken) {
      RedirectManager::redirectToBrowsePostsWithMessage("Huutonet kirjautuminen ei onnistunut, yritä uudelleen.");
    }
    return $authenticationToken;
  }

  private function createHuutonetItem($selectedPostId, $huutonetManager): mixed
  {
    $this->postId = $selectedPostId;
    $this->post = $this->getPost();
    $huutonetManager->postItem = [
      "buyNowPrice" => $this->post->price,
      "categoryId" => $this->post->category,
      "closingTime" => $this->post->activeTimeEnd,
      "condition" => $this->post->itemCondition,
      "description" => $this->post->description,
      "deliveryMethods" => $this->getHuutonetDeliveryMethods(),
      "deliveryTerms" => $this->post->deliveryDetails->deliveryTerms,
      "identificationRequired" => $this->post->onlyToIdentifiedUsers,
      "isLocationAbroad" => $this->post->isOutsideOfFinland,
      "paymentMethods" => $this->getHuutonetPaymentMethods(),
      "paymentTerms" => $this->post->paymentDetails->paymentTerms,
      "postalCode" => $this->post->zipCode,
      "quantity" => 1,
      "saleMethod" => $this->post->sellType,
      "startingPrice" => $this->post->price,
      "status" => "preview",
      "title" => $this->post->title,
      "offersAllowed" => $this->post->isPriceSuggestion,
    ];
    if ($this->isActiveTimeBeginInTheFuture()) {
      $huutonetManager->postItem["listTime"] = $this->post->activeTimeBegin;
    }
    $createItemResponse = $huutonetManager->createItem();

    if ($createItemResponse["errors"]) {
      RedirectManager::redirectToBrowsePostsWithMessage(
        "Huutonet API virhe: {$createItemResponse["errors"][0]["field"]} {$createItemResponse["errors"][0]["messages"][0]}."
      );
    }

    return $createItemResponse;
  }

  private function addImageToHuutonetItem($imageDetails, $huutonetManager): void
  {
    $imageAbsolutePath = realpath(__DIR__ . "/../../.." . $imageDetails->imagePath);
    $huutonetManager->postImage = [
      "image" => new \CURLFile($imageAbsolutePath)
    ];
    $addImageResponse = $huutonetManager->addImageToItem();

    if ($addImageResponse["errors"]) {
      RedirectManager::redirectToBrowsePostsWithMessage(
        "Huutonet API virhe: {$addImageResponse["errors"][0]["field"]} {$addImageResponse["errors"][0]["messages"][0]}."
      );
    }
  }

  /** @param HuutonetManager $huutonetManager */
  private function publishHuutonetItem($huutonetManager): void
  {
    $publishItemResponse = $huutonetManager->publishItem();
    if ($publishItemResponse["errors"]) {
      RedirectManager::redirectToBrowsePostsWithMessage(
        "Huutonet API virhe: {$publishItemResponse["errors"][0]["field"]} {$publishItemResponse["errors"][0]["messages"][0]}."
      );
    }
  }

  private function getHuutonetDeliveryMethods(): array
  {
    $deliveryMethods = [];

    if ($this->post->deliveryDetails->isFetch) {
      $deliveryMethods[] = "pickup";
    }

    if ($this->post->deliveryDetails->isDelivery) {
      $deliveryMethods[] = "shipment";
    }

    return $deliveryMethods;
  }

  private function getHuutonetPaymentMethods(): array
  {
    $paymentMethods = [];

    if ($this->post->paymentDetails->isBankTransfer) {
      $paymentMethods[] = "wire-transfer";
    }

    if ($this->post->paymentDetails->isCash) {
      $paymentMethods[] = "cash";
    }

    if ($this->post->paymentDetails->isPayPal) {
      $paymentMethods[] = "paypal";
    }

    if ($this->post->paymentDetails->isMobilePay) {
      $paymentMethods[] = "mobile-pay";
    }

    return $paymentMethods;
  }

  private function isActiveTimeBeginInTheFuture(): bool
  {
    $activeTimeBeginTimestamp = strtotime($this->post->activeTimeBegin);
    $currentTimestamp = time();
    return $activeTimeBeginTimestamp > $currentTimestamp;
  }
}
