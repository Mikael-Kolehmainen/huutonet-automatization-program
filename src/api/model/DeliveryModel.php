<?php

namespace api\model;

class DeliveryModel
{
  private const TABLE_NAME = "delivery";
  private const FIELD_ID = "id";
  private const FIELD_IS_FETCH = "isFetch";
  private const FIELD_IS_DELIVERY = "isDelivery";
  private const FIELD_DELIVERY_FEE = "deliveryFee";
  private const FIELD_DELIVERY_TERMS = "deliveryTerms";

  /** @var int */
  public $id;

  /** @var string */
  public $isFetch;

  /** @var string */
  public $isDelivery;

  /** @var string */
  public $deliveryFee;

  /** @var string */
  public $deliveryTerms;

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
        self::FIELD_IS_FETCH . ', ' .
        self::FIELD_IS_DELIVERY . ', ' .
        self::FIELD_DELIVERY_FEE . ', ' .
        self::FIELD_DELIVERY_TERMS .
        ') VALUES (?, ?, ?, ?)',
      [
        ['iiss'],
        [
          $this->isFetch,
          $this->isDelivery,
          $this->deliveryFee,
          $this->deliveryTerms
        ]
      ]
     );
  }
}
