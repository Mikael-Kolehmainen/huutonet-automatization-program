<?php

namespace api\manager;

class CurlManager
{
  /** @var \CurlHandle */
  private $curl;

  /** @var string */
  private $url;

  /** @var array */
  private $parameters;

  /**
   * @param string $url
   */
  public function __construct($url, $method = "GET", $parameters = [])
  {
    $this->curl = curl_init();
    $this->url = $url;
    $this->parameters = $parameters;

    switch ($method) {
      case "GET":
        $this->initializeGetMethod();
        break;
      case "POST":
        $this->initializePostMethod();
        break;
      default:
        $this->initializeGetMethod();
        break;
    }
  }

  private function initializeGetMethod(): void
  {
    curl_setopt_array($this->curl, [
      CURLOPT_URL => $this->url,
      CURLOPT_HTTPHEADER => [
        "Content-type: text/plain",
      ],
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "GET",
    ]);
  }

  private function initializePostMethod(): void
  {
    curl_setopt_array($this->curl, [
      CURLOPT_URL => $this->url,
      CURLOPT_HTTPHEADER => [
        "Content-type: application/x-www-form-urlencoded",
      ],
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "POST",
      CURLOPT_POSTFIELDS => http_build_query($this->parameters)
    ]);
  }

  public function fetch(): mixed
  {
    $response = curl_exec($this->curl);
    curl_close($this->curl);
    return json_decode($response, true);
  }
}
