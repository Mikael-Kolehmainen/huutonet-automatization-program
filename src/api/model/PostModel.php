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
}
