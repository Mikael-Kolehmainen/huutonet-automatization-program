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
          <input type='radio' id='14-days' value='14 päivää' name='active-time-end'>
          <label for='14-days'>14 päivää</label>
          <input type='radio' id='7-days' value='7 päivää' name='active-time-end'>
          <label for='7-days'>7 päivää</label>
        </div>
        <input type='text' name='huutonet-username' placeholder='Huutonet käyttäjänimi' required>
        <input type='password' name='huutonet-password' placeholder='Huutonet salasana' required>
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
