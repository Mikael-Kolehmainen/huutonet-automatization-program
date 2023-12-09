<?php

namespace public_site\controller;

use public_site\controller\HeaderController;

class HomeController
{
  public function showHomePage(): void
  {
    $this->showHeader();
    echo "
        <title>Huutonet automatisointi ohjelma</title>
      </head>
    ";
  }

  private function showHeader(): void
  {
    $headerController = new HeaderController();
    $headerController->showHeader();
  }
}
