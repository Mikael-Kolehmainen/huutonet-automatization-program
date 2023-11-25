<?php

namespace api\model;

class PaymentModel
{
  private const TABLE_NAME = "payment";
  private const FIELD_ID = "id";
  private const FIELD_IS_BANK_TRANSFER = "isBankTransfer";
  private const FIELD_IS_CASH = "isCash";
  private const FIELD_IS_PAYPAL = "isPaypal";
  private const FIELD_IS_MOBILEPAY = "isMobilepay";
  private const FIELD_PAYMENT_TERMS = "paymentTerms";

  /** @var int */
  public $id;

  /** @var string */
  public $isBankTransfer;

  /** @var string */
  public $isCash;

  /** @var string */
  public $isPaypal;

  /** @var string */
  public $isMobilepay;

  /** @var int */
  public $paymentTerms;

  /** @var Database */
  private $db;

  public function __construct($database)
  {
    $this->db = $database;
  }

  public function save(): int
  {
    return $this->db->insert(
      'INSERT INTO ' . self::TABLE_NAME .
        ' ( ' .
        self::FIELD_IS_BANK_TRANSFER . ', ' .
        self::FIELD_IS_CASH . ', ' .
        self::FIELD_IS_PAYPAL . ', ' .
        self::FIELD_IS_MOBILEPAY . ', ' .
        self::FIELD_PAYMENT_TERMS .
        ') VALUES (?, ?, ?, ?, ?)',
      [
        ['iiiis'],
        [
          $this->isBankTransfer,
          $this->isCash,
          $this->isPaypal,
          $this->isMobilepay,
          $this->paymentTerms
        ]
      ]
    );
  }
}
