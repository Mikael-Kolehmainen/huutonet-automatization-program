<?php

namespace public_site\controller;

use api\manager\ServerRequestManager;
use api\model\Database;
use api\model\DeliveryModel;

class DeliveryController
{
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
}
