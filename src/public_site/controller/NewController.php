<?php

namespace public_site\controller;

use public_site\controller\HeaderController;

class NewController
{
  public function showNewPage(): void
  {
    $this->showHeader();

    echo "
        <script src='/src/public_site/js/eventListeners/isOutsideOfFinland.js' defer></script>
        <script src='/src/public_site/js/eventListeners/isDelivery.js' defer></script>
        <script src='/src/public_site/js/eventListeners/sellType.js' defer></script>
        <script src='/src/public_site/js/eventListeners/updateMinimumRaise.js' defer></script>
      </head>
      <section>
        <h2>Luo ilmoitus</h2>
        <form>
          <input type='text' placeholder='Otsikko' name='title' required>
          <textarea placeholder='Kuvaus' name='description' required></textarea>
          <input type='file'>
          <p>Kunto:</p>
          <div class='radio-group'>
            <input type='radio' id='new' value='4' name='item-condition'>
            <label for='new'>Uusi</label>
            <input type='radio' id='like-new' value='3' name='item-condition'>
            <label for='like-new'>Uudenveroinen</label>
            <input type='radio' id='good' value='2' name='item-condition' checked>
            <label for='good'>Hyvä</label>
            <input type='radio' id='acceptable' value='1' name='item-condition'>
            <label for='acceptable'>Tyydyttävä</label>
            <input type='radio' id='weak' value='0' name='item-condition'>
            <label for='weak'>Heikko</label>
          </div>
          <div class='input-with-checkbox'>
            <input type='text' placeholder='Postinumero' id='zip-code' name='zip-code'>
            <input type='checkbox' id='is-outside-of-finland' name='is-outside-of-finland'>
            <label for='is-outside-of-finland'>Tuote sijaitsee Suomen ulkopuolella</label>
          </div>
          <div class='three-inputs'>
            <input type='text' placeholder='Osasto 1' name='category-1' required>
            <input type='text' placeholder='Osasto 2' name='category-2' required>
            <input type='text' placeholder='Osasto 3' name='category-3' required>
          </div>
          <p>Myyntitapa:</p>
          <div class='radio-group'>
            <input type='radio' id='buy-now' value='Osta heti' name='sell-type' required checked>
            <label for='buy-now'>Osta heti</label>
            <input type='radio' id='auction'  value='Huutokauppa' name='sell-type' required>
            <label for='auction'>Huutokauppa</label>
          </div>
          <div class='input-with-checkbox'>
            <input type='number' placeholder='Hinta' id='price' name='price' required>
            <input type='number' placeholder='Minimikorotus' value='0' id='minimum-raise' name='minimum-raise' style='display: none;' disabled>
            <input type='checkbox' id='is-price-suggestion' name='is-price-suggestion'>
            <label for='is-price-suggestion'>Ostaja saa ehdottaa hintaa</label>
          </div>
          <div class='input-with-checkbox reversed'>
            <input type='checkbox' id='is-fetch' name='is-fetch'>
            <label for='is-fetch'>Nouto</label>
            <input type='checkbox' id='is-delivery' name='is-delivery'>
            <label for='is-delivery'>Toimitus</label>
            <input type='number' placeholder='Toimituskulut Suomeen' id='delivery-fee' name='delivery-fee' style='display: none;' disabled>
          </div>
          <textarea placeholder='Muut toimitus-/palautusehdot' name='delivery-terms'></textarea>
          <div>
            <input type='checkbox' id='is-bank-transfer' name='is-bank-transfer'>
            <label for='is-bank-transfer'>Tilisiirto</label>
            <input type='checkbox' id='is-cash' name='is-cash'>
            <label for='is-cash'>Käteinen</label>
            <input type='checkbox' id='is-paypal' name='is-paypal'>
            <label for='is-paypal'>Paypal</label>
            <input type='checkbox' id='is-mobilepay' name='is-mobilepay'>
            <label for='is-mobilepay'>Mobilepay</label>
          </div>
          <textarea placeholder='Muut maksuehdot' name='payment-terms'></textarea>
          <label for='active-time-start'>Aukioloaika - alku</label>
          <input type='date' name='active-time-start' required>
          <p>Aukioloaika - päättyy</p>
          <div class='radio-group'>
            <input type='radio' id='14-days' value='14 päivää' name='active-time-end' required checked>
            <label for='14-days'>14 päivää</label>
            <input type='radio' id='7-days' value='7 päivää' name='active-time-end' required>
            <label for='7-days'>7 päivää</label>
          </div>
          <div>
            <input type='checkbox' id='only-to-identified-users' name='only-to-identified-users'>
            <label for='only-to-identified-users'>Myyn vain tunnistautuneille käyttäjille</label>
          </div>
          <div class='btn-container'>
            <input type='submit' class='btn' value='Luo ilmoitus tietokantaan'>
          </div>
        </form>
      </section>
    ";
  }

  private function showHeader(): void
  {
    $headerController = new HeaderController();
    $headerController->showHeader();
  }
}
