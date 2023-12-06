<?php

namespace public_site\controller;

use api\manager\ServerRequestManager;
use api\model\Database;
use api\model\DeliveryModel;

class DeliveryController
{
  /** @var int */
  public $deliveryId;

  /** @var Database */
  private $db;

  public function __construct()
  {
    $this->db = new Database();
  }

  public function saveDelivery(): int
  {
    $deliveryModel = new DeliveryModel($this->db);
    $deliveryModel->isFetch = ServerRequestManager::postIsFetch();
    $deliveryModel->isDelivery = ServerRequestManager::postIsDelivery();
    $deliveryModel->deliveryFee = ServerRequestManager::postDeliveryFee();
    $deliveryModel->deliveryTerms = ServerRequestManager::postDeliveryTerms();
    return $deliveryModel->save();
  }

  public function getDelivery(): DeliveryModel
  {
    $deliveryModel = new DeliveryModel($this->db);
    $deliveryModel->id = $this->deliveryId;
    return $deliveryModel->load();
  }

  public function updateDelivery(): void
  {
    $deliveryModel = new DeliveryModel($this->db);
    $deliveryModel->isFetch = ServerRequestManager::postIsFetch();
    $deliveryModel->isDelivery = ServerRequestManager::postIsDelivery();
    $deliveryModel->deliveryFee = ServerRequestManager::postDeliveryFee();
    $deliveryModel->deliveryTerms = ServerRequestManager::postDeliveryTerms();
    $deliveryModel->id = $this->deliveryId;
    $deliveryModel->update();
  }

  public function deleteDelivery(): void
  {
    $deliveryModel = new DeliveryModel($this->db);
    $deliveryModel->id = $this->deliveryId;
    $deliveryModel->delete();
  }
}
