<?php

namespace api\manager;

class ServerRequestManager
{
  private const REQUEST_METHOD = "REQUEST_METHOD";
  private const POST = "POST";
  private const GET = "GET";
  private const REQUEST_URI = "REQUEST_URI";
  private const CREATE_POST = "create-post";
  private const IS_BANK_TRANSFER = "is-bank-transfer";
  private const IS_CASH = "is-cash";
  private const IS_PAYPAL = "is-paypal";
  private const IS_MOBILEPAY = "is-mobilepay";
  private const PAYMENT_TERMS = "payment-terms";
  private const IS_FETCH = "is-fetch";
  private const IS_DELIVERY = "is-delivery";
  private const DELIVERY_FEE = "delivery-fee";
  private const DELIVERY_TERMS = "delivery-terms";
  private const TITLE = "title";
  private const DESCRIPTION = "description";
  private const ITEM_CONDITION = "item-condition";
  private const ZIP_CODE = "zip-code";
  private const IS_OUTSIDE_OF_FINLAND = "is-outside-of-finland";
  private const CATEGORY = "category";
  private const SELL_TYPE = "sell-type";
  private const PRICE = "price";
  private const MINIMUM_RAISE = "minimum-raise";
  private const IS_PRICE_SUGGESTION = "is-price-suggestion";
  private const ACTIVE_TIME_BEGIN = "active-time-begin";
  private const ACTIVE_TIME_END = "active-time-end";
  private const ONLY_TO_IDENTIFIED_USERS = "only-to-identified-users";

  public static function isPost(): bool
  {
    return $_SERVER[self::REQUEST_METHOD] == self::POST;
  }

  public static function isGet(): bool
  {
    return $_SERVER[self::REQUEST_METHOD] == self::GET;
  }

  /** @return array<string>|bool */
  public static function getUriParts()
  {
    $uri = parse_url($_SERVER[self::REQUEST_URI], PHP_URL_PATH);
    return explode('/', $uri);
  }

  public static function issetCreatePost(): bool
  {
    return isset($_POST[self::CREATE_POST]);
  }

  public static function postIsBankTransfer(): string
  {
    return $_POST[self::IS_BANK_TRANSFER] ? $_POST[self::IS_BANK_TRANSFER] : "0";
  }

  public static function postIsCash(): string
  {
    return $_POST[self::IS_CASH] ? $_POST[self::IS_CASH] : "0";
  }

  public static function postIsPaypal(): string
  {
    return $_POST[self::IS_PAYPAL] ? $_POST[self::IS_PAYPAL] : "0";
  }

  public static function postIsMobilepay(): string
  {
    return $_POST[self::IS_MOBILEPAY] ? $_POST[self::IS_MOBILEPAY] : "0";
  }

  public static function postPaymentTerms(): string
  {
    return $_POST[self::PAYMENT_TERMS];
  }

  public static function postIsFetch(): string
  {
    return $_POST[self::IS_FETCH] ? $_POST[self::IS_FETCH] : "0";
  }

  public static function postIsDelivery(): string
  {
    return $_POST[self::IS_DELIVERY] ? $_POST[self::IS_DELIVERY] : "0";
  }

  public static function postDeliveryFee(): float
  {
    return $_POST[self::DELIVERY_FEE] ? $_POST[self::DELIVERY_FEE] : 0.00;
  }

  public static function postDeliveryTerms(): string
  {
    return $_POST[self::DELIVERY_TERMS];
  }

  public static function postTitle(): string
  {
    return $_POST[self::TITLE];
  }

  public static function postDescription(): string
  {
    return $_POST[self::DESCRIPTION];
  }

  public static function postItemCondition(): string
  {
    return $_POST[self::ITEM_CONDITION];
  }

  public static function postZipCode(): string
  {
    return $_POST[self::ZIP_CODE] ? $_POST[self::ZIP_CODE] : "";
  }

  public static function postIsOutsideOfFinland(): string
  {
    return $_POST[self::IS_OUTSIDE_OF_FINLAND] ? $_POST[self::IS_OUTSIDE_OF_FINLAND] : "0";
  }

  public static function postCategory(): string
  {
    return $_POST[self::CATEGORY];
  }

  public static function postSellType(): string
  {
    return $_POST[self::SELL_TYPE];
  }

  public static function postPrice(): float
  {
    return $_POST[self::PRICE];
  }

  public static function postMinimumRaise(): float
  {
    return $_POST[self::MINIMUM_RAISE] ? $_POST[self::MINIMUM_RAISE] : 0.00;
  }

  public static function postIsPriceSuggestion(): string
  {
    return $_POST[self::IS_PRICE_SUGGESTION] ? $_POST[self::IS_PRICE_SUGGESTION] : "0";
  }

  public static function postActiveTimeBegin(): string
  {
    return $_POST[self::ACTIVE_TIME_BEGIN];
  }

  public static function postActiveTimeEnd(): string
  {
    return $_POST[self::ACTIVE_TIME_END];
  }

  public static function postOnlyToIdentifiedUsers(): string
  {
    return $_POST[self::ONLY_TO_IDENTIFIED_USERS] ? $_POST[self::ONLY_TO_IDENTIFIED_USERS] : "0";
  }
}
