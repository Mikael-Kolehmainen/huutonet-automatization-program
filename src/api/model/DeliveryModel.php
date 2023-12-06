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

  public function update(): void
  {
    $this->db->insert(
      'UPDATE ' . self::TABLE_NAME .
      ' SET ' . self::FIELD_IS_FETCH . ' = ?,' .
      self::FIELD_IS_DELIVERY . ' = ?,' .
      self::FIELD_DELIVERY_FEE . ' = ?,' .
      self::FIELD_DELIVERY_TERMS . ' = ?' .
      ' WHERE ' . self::FIELD_ID . ' = ?',
      [
        ['iissi'],
        [
          $this->isFetch,
          $this->isDelivery,
          $this->deliveryFee,
          $this->deliveryTerms,
          $this->id
        ]
      ]
    );
  }

  public function delete(): void
  {
    $this->db->remove(
      'DELETE FROM ' . self::TABLE_NAME . ' WHERE ' . self::FIELD_ID . ' = ?',
      [["s"], [$this->id]]
    );
  }

  public function load(): DeliveryModel
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
    $this->isFetch = $record[self::FIELD_IS_FETCH];
    $this->isDelivery = $record[self::FIELD_IS_DELIVERY];
    $this->deliveryFee = $record[self::FIELD_DELIVERY_FEE];
    $this->deliveryTerms = $record[self::FIELD_DELIVERY_TERMS];

    return $this;
  }
}
