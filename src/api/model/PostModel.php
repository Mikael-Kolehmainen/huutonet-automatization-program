<?php

namespace api\model;

class PostModel
{
  private const TABLE_NAME = "post";
  private const FIELD_ID = "id";
  private const FIELD_TITLE = "title";
  private const FIELD_DESCRIPTION = "description";
  private const FIELD_ITEM_CONDITION = "itemCondition";
  private const FIELD_ZIP_CODE = "zipCode";
  private const FIELD_IS_OUTSIDE_OF_FINLAND = "isOutsideOfFinland";
  private const FIELD_CATEGORY = "category";
  private const FIELD_SELL_TYPE = "sellType";
  private const FIELD_PRICE = "price";
  private const FIELD_MINIMUM_RAISE = "minimumRaise";
  private const FIELD_IS_PRICE_SUGGESTION = "isPriceSuggestion";
  private const FIELD_DELIVERY_ID = "delivery_id";
  private const FIELD_PAYMENT_ID = "payment_id";
  private const FIELD_ACTIVE_TIME_BEGIN = "activeTimeBegin";
  private const FIELD_ACTIVE_TIME_END = "activeTimeEnd";
  private const FIELD_ONLY_TO_IDENTIFIED_USERS = "onlyToIdentifiedUsers";

  /** @var int */
  public $id;

  /** @var string */
  public $title;

  /** @var string */
  public $description;

  /** @var string */
  public $itemCondition;

  /** @var string */
  public $zipCode;

  /** @var int */
  public $isOutsideOfFinland;

  /** @var string */
  public $category;

  /** @var string */
  public $sellType;

  /** @var float */
  public $price;

  /** @var float */
  public $minimumRaise;

  /** @var int */
  public $isPriceSuggestion;

  /** @var int */
  public $deliveryId;

  /** @var int */
  public $paymentId;

  /** @var \DateTime */
  public $activeTimeBegin;

  /** @var \DateTime */
  public $activeTimeEnd;

  /** @var int */
  public $onlyToIdentifiedUsers;

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
        self::FIELD_TITLE . ', ' .
        self::FIELD_DESCRIPTION . ', ' .
        self::FIELD_ITEM_CONDITION . ', ' .
        self::FIELD_ZIP_CODE . ', ' .
        self::FIELD_IS_OUTSIDE_OF_FINLAND . ', ' .
        self::FIELD_CATEGORY . ', ' .
        self::FIELD_SELL_TYPE . ', ' .
        self::FIELD_PRICE . ', ' .
        self::FIELD_MINIMUM_RAISE . ', ' .
        self::FIELD_IS_PRICE_SUGGESTION . ', ' .
        self::FIELD_DELIVERY_ID . ', ' .
        self::FIELD_PAYMENT_ID . ', ' .
        self::FIELD_ACTIVE_TIME_BEGIN . ', ' .
        self::FIELD_ACTIVE_TIME_END . ', ' .
        self::FIELD_ONLY_TO_IDENTIFIED_USERS .
        ') VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)',
      [
        ['ssssissddiiissi'],
        [
          $this->title,
          $this->description,
          $this->itemCondition,
          $this->zipCode,
          $this->isOutsideOfFinland,
          $this->category,
          $this->sellType,
          $this->price,
          $this->minimumRaise,
          $this->isPriceSuggestion,
          $this->deliveryId,
          $this->paymentId,
          $this->activeTimeBegin,
          $this->activeTimeEnd,
          $this->onlyToIdentifiedUsers
        ]
      ]
     );
  }

  public function update(): void
  {
    $this->db->insert(
      'UPDATE ' . self::TABLE_NAME .
      ' SET ' . self::FIELD_TITLE . ' = ?,' .
      self::FIELD_DESCRIPTION . ' = ?,' .
      self::FIELD_ITEM_CONDITION . ' = ?,' .
      self::FIELD_ZIP_CODE . ' = ?,' .
      self::FIELD_IS_OUTSIDE_OF_FINLAND . ' = ?,' .
      self::FIELD_CATEGORY . ' = ?,' .
      self::FIELD_SELL_TYPE . ' = ?,' .
      self::FIELD_PRICE . ' = ?,' .
      self::FIELD_MINIMUM_RAISE . ' = ?,' .
      self::FIELD_IS_PRICE_SUGGESTION . ' = ?,' .
      self::FIELD_DELIVERY_ID . ' = ?,' .
      self::FIELD_PAYMENT_ID . ' = ?,' .
      self::FIELD_ACTIVE_TIME_BEGIN . ' = ?,' .
      self::FIELD_ACTIVE_TIME_END . ' = ?,' .
      self::FIELD_ONLY_TO_IDENTIFIED_USERS . ' = ?' .
      ' WHERE ' . self::FIELD_ID . ' = ?',
      [
        ['ssssissddiiissii'],
        [
          $this->title,
          $this->description,
          $this->itemCondition,
          $this->zipCode,
          $this->isOutsideOfFinland,
          $this->category,
          $this->sellType,
          $this->price,
          $this->minimumRaise,
          $this->isPriceSuggestion,
          $this->deliveryId,
          $this->paymentId,
          $this->activeTimeBegin,
          $this->activeTimeEnd,
          $this->onlyToIdentifiedUsers,
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

  /** @return PostModel[] */
  public function loadAll()
  {
    $records = $this->db->select(
      'SELECT * FROM ' . self::TABLE_NAME,
      []
    );

    $posts = [];
    $i = 0;
    foreach ($records as $record) {
      $postModel = new PostModel($this->db);
      $posts[$i] = $postModel->mapFromDbRecord($record);

      $i++;
    }

    return $posts;
  }

  /** @return PostModel */
  public function load()
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
    $this->title = $record[self::FIELD_TITLE];
    $this->description = $record[self::FIELD_DESCRIPTION];
    $this->itemCondition = $record[self::FIELD_ITEM_CONDITION];
    $this->zipCode = $record[self::FIELD_ZIP_CODE];
    $this->isOutsideOfFinland = $record[self::FIELD_IS_OUTSIDE_OF_FINLAND];
    $this->category = $record[self::FIELD_CATEGORY];
    $this->sellType = $record[self::FIELD_SELL_TYPE];
    $this->price = $record[self::FIELD_PRICE];
    $this->minimumRaise = $record[self::FIELD_MINIMUM_RAISE];
    $this->isPriceSuggestion = $record[self::FIELD_IS_PRICE_SUGGESTION];
    $this->deliveryId = $record[self::FIELD_DELIVERY_ID];
    $this->paymentId = $record[self::FIELD_PAYMENT_ID];
    $this->activeTimeBegin = $this->formatDate($record[self::FIELD_ACTIVE_TIME_BEGIN]);
    $this->activeTimeEnd = $this->formatDate($record[self::FIELD_ACTIVE_TIME_END]);
    $this->onlyToIdentifiedUsers = $record[self::FIELD_ONLY_TO_IDENTIFIED_USERS];

    return $this;
  }

  private function formatDate($dateTimeStr): string
  {
    $dateTime = new \DateTime($dateTimeStr);
    return $dateTime->format("Y-m-d");
  }
}
