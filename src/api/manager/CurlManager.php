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

  /** @var array */
  private $httpHeaders;

  /**
   * @param string $url
   */
  public function __construct($url, $method = "GET", $parameters = [], $optionalHttpHeaders = [])
  {
    $this->curl = curl_init();
    $this->url = $url;
    $this->parameters = $parameters;
    $this->httpHeaders = $optionalHttpHeaders;

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
    $this->httpHeaders[] = "Content-type: text/plain";
    curl_setopt_array($this->curl, [
      CURLOPT_URL => $this->url,
      CURLOPT_HTTPHEADER => $this->httpHeaders,
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
    $this->httpHeaders[] = "Content-type: multipart/form-data";
    curl_setopt_array($this->curl, [
      CURLOPT_URL => $this->url,
      CURLOPT_HTTPHEADER => $this->httpHeaders,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "POST",
      CURLOPT_POSTFIELDS => $this->parameters
    ]);
  }

  public function fetch(): mixed
  {
    $response = curl_exec($this->curl);
    curl_close($this->curl);
    return json_decode($response, true);
  }
}
