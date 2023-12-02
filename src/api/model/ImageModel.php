<?php

namespace api\model;

class ImageModel
{
  private const TABLE_NAME = "image";
  private const FIELD_ID = "id";
  private const FIELD_IMAGE_PATH = "imagePath";
  private const FIELD_POST_ID = "post_id";

  /** @var int */
  public $id;

  /** @var string */
  public $imagePath;

  /** @var int */
  public $postId;

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
        self::FIELD_IMAGE_PATH . ', ' .
        self::FIELD_POST_ID .
        ') VALUES (?, ?)',
      [
        ['si'],
        [
          $this->imagePath,
          $this->postId
        ]
      ]
    );
  }

  /** @return ImageModel[] */
  public function load()
  {
    $records = $this->db->select(
      'SELECT * FROM ' . self::TABLE_NAME . ' WHERE ' . self::FIELD_POST_ID . ' = ?',
      [["s"], [$this->postId]]
    );

    $images = [];
    $i = 0;
    foreach ($records as $record) {
      $imageModel = new ImageModel($this->db);
      $images[$i] = $imageModel->mapFromDbRecord($record);

      $i++;
    }

    return $images;
  }

  /**
   * @param mixed[] $record Associative array of one db record
   * @return $this
   */
  public function mapFromDbRecord($record)
  {
    $this->id = $record[self::FIELD_ID];
    $this->imagePath = $record[self::FIELD_IMAGE_PATH];
    $this->postId = $record[self::FIELD_POST_ID];

    return $this;
  }
}
