<?php

namespace public_site\controller;

use api\manager\ServerRequestManager;
use api\model\Database;
use api\model\PaymentModel;

class PaymentController
{
  /** @var int */
  public $paymentId;

  /** @var Database */
  private $db;

  public function __construct()
  {
    $this->db = new Database();
  }

  public function savePayment(): int
  {
    $paymentModel = new PaymentModel($this->db);
    $paymentModel->isBankTransfer = ServerRequestManager::postIsBankTransfer();
    $paymentModel->isCash = ServerRequestManager::postIsCash();
    $paymentModel->isPayPal = ServerRequestManager::postIsPaypal();
    $paymentModel->isMobilePay = ServerRequestManager::postIsMobilepay();
    $paymentModel->paymentTerms = ServerRequestManager::postPaymentTerms();
    return $paymentModel->save();
  }

  public function getPayment(): PaymentModel
  {
    $paymentModel = new PaymentModel($this->db);
    $paymentModel->id = $this->paymentId;
    return $paymentModel->load();
  }

  public function deletePayment(): void
  {
    $paymentModel = new PaymentModel($this->db);
    $paymentModel->id = $this->paymentId;
    $paymentModel->delete();
  }
}
