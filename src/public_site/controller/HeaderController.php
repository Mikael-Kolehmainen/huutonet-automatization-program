<?php

namespace public_site\controller;

class HeaderController
{
  public function showHeader(): void
  {
    echo "
      </head>
      <header>
        <h1>Huutonet automatisointi ohjelma</h1>
        <nav>
          <a href='/index.php/new-post' class='btn'>Uusi ilmoitus</a>
          <a href='/index.php/browse-posts' class='btn'>Selaa ilmoituksia</a>
        </nav>
      </header>
    ";
  }
}
