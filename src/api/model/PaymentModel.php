<?php

namespace api\model;

class PaymentModel
{
  private const TABLE_NAME = "payment";
  private const FIELD_ID = "id";
  private const FIELD_IS_BANK_TRANSFER = "isBankTransfer";
  private const FIELD_IS_CASH = "isCash";
  private const FIELD_IS_PAYPAL = "isPayPal";
  private const FIELD_IS_MOBILEPAY = "isMobilePay";
  private const FIELD_PAYMENT_TERMS = "paymentTerms";

  /** @var int */
  public $id;

  /** @var string */
  public $isBankTransfer;

  /** @var string */
  public $isCash;

  /** @var string */
  public $isPayPal;

  /** @var string */
  public $isMobilePay;

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
          $this->isPayPal,
          $this->isMobilePay,
          $this->paymentTerms
        ]
      ]
    );
  }

  public function delete()
  {
    $this->db->remove(
      'DELETE FROM ' . self::TABLE_NAME . ' WHERE ' . self::FIELD_ID . ' = ?',
      [["s"], [$this->id]]
    );
  }

  public function load(): PaymentModel
  {
    $records = $this->db->select(
      'SELECT * FROM ' . self::TABLE_NAME . ' WHERE ' . self::FIELD_ID . ' = ?',
      [["s"], [$this->id]]
    );
    $record = array_pop($records);
    return $this->mapFromDbRecord($record);
  }

  /**
   * @param mixed[] $record Associative array of one db record
   * @return $this
   */
  public function mapFromDbRecord($record)
  {
    $this->id = $record[self::FIELD_ID];
    $this->isBankTransfer = $record[self::FIELD_IS_BANK_TRANSFER];
    $this->isCash = $record[self::FIELD_IS_CASH];
    $this->isPayPal = $record[self::FIELD_IS_PAYPAL];
    $this->isMobilePay = $record[self::FIELD_IS_MOBILEPAY];
    $this->paymentTerms = $record[self::FIELD_PAYMENT_TERMS];

    return $this;
  }
}
