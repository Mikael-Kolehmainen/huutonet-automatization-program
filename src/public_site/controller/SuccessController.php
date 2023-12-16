<?php

namespace public_site\controller;

class SuccessController
{
  public function __construct()
  {

  }

  public function showSuccessPage(): void
  {
    $this->showHeader();
    echo "
        <title>Ilmoitukset luotu</title>
      </head>
      <section>
        <article class='box'>
          <h2>Ilmoitukset luoto Huutonet:iin!</h2>
        </article>
      </section>
    ";
  }

  private function showHeader(): void
  {
    $headerController = new HeaderController();
    $headerController->showHeader();
  }
}
