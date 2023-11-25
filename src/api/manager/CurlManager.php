<?php

namespace api\manager;

class CurlManager
{
  private $curl;

  /**
   * @param string $url
   */
  public function __construct($url)
  {
    $this->curl = curl_init();
    curl_setopt_array($this->curl, [
      CURLOPT_URL => $url,
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

  public function fetch(): mixed
  {
    $response = curl_exec($this->curl);
    curl_close($this->curl);
    return json_decode($response, true);
  }
}
