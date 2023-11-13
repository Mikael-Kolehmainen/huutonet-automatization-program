<?php

namespace public_site\controller;

use public_site\controller\HeaderController;

class NewController
{
  public function showNewPage(): void
  {
    $this->showHeader();
  }

  private function showHeader(): void
  {
    $headerController = new HeaderController();
    $headerController->showHeader();
  }
}
