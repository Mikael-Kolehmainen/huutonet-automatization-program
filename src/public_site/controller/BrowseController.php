<?php

namespace public_site\controller;

use public_site\controller\HeaderController;

class BrowseController
{
  public function showBrowsePage(): void
  {
    $this->showHeader();

    echo "
      <h2>Ilmoitukset</h2>
      <form>
        <table>

        </table>
        <input type='checkbox' name='change-active-time'>
        <label for='change-active-time'>Määritä aukioloaika kaikkille valituille ilmoituksille.</label>
        <div id='active-time-changers'>
          <label for='active-time-start'>Aukioloaika - alku</label>
          <input type='date' name='active-time-start'>
          <label for='active-time-end'>Aukioloaika - päättyy</label>
          <input type='date' name='active-time-end'>
        </div>
        <label for='huutonet-username'>Huutonet käyttäjänimi:</label>
        <input type='text' name='huutonet-username' required>
        <label for='huutonet-password'>Huutonet salasana:</label>
        <input type='password' name='huutonet-password required>
        <input type='submit' value='Luo valittut ilmoitukset Huutonet:iin'>
      </form>
    ";
  }

  private function showHeader(): void
  {
    $headerController = new HeaderController();
    $headerController->showHeader();
  }
}
