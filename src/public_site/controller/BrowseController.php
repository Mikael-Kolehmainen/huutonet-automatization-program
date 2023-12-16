<?php

namespace public_site\controller;

use public_site\controller\HeaderController;

class BrowseController
{
  public function showBrowsePage(): void
  {
    $this->showHeader();

    echo "
      <script src='/src/public_site/js/eventListeners/deletePostPopup.js' defer></script>
      <script src='/src/public_site/js/eventListeners/changeActiveTime.js' defer></script>
      <section>
        <h2>Ilmoitukset</h2>
        <form action='/index.php/post/upload' method='POST'>
    ";

    $this->showPosts();

    echo "
          <div class='container'>
            <div>
              <input type='checkbox' id='change-active-time' value='1' name='change-active-time'>
              <label for='change-active-time'>Määritä aukioloaika kaikkille valituille ilmoituksille.</label>
            </div>
            <div id='active-time-changers' style='display: none;'>
              <label for='active-time-begin'>Aukioloaika - alku</label>
              <input type='date' name='active-time-begin'>
              <label for='active-time-end'>Aukioloaika - päättyy</label>
              <div class='radio-group'>
                <input type='radio' id='14-days' value='14' name='active-time-end'>
                <label for='14-days'>14 päivää</label>
                <input type='radio' id='7-days' value='7' name='active-time-end'>
                <label for='7-days'>7 päivää</label>
              </div>
            </div>
            <input type='text' name='huutonet-username' placeholder='Huutonet käyttäjänimi' required>
            <input type='password' name='huutonet-password' placeholder='Huutonet salasana' required>
            <div class='btn-container'>
              <input type='submit' class='btn' name='upload-post' value='Luo valittut ilmoitukset Huutonet:iin'>
            </div>
          </form>
          <div class='popup' id='delete-post-popup' style='display: none;'>
            <p id='delete-post-popup-text'>Oletko varma että haluat poistaa ilmoituksen?</p>
            <div class='btn-container'>
              <a class='btn' id='delete-post-cancel'>En</a>
              <a href='/index.php/post/delete' class='btn' id='delete-post-confirm'>Kyllä</a>
            </div>
          </div>
        </div>
      </section>
    ";
  }

  private function showHeader(): void
  {
    $headerController = new HeaderController();
    $headerController->showHeader();
  }

  private function showPosts(): void
  {
    echo "
      <table>
        <tr>
          <td>ID</td>
          <td>Luo ilmoitus?</td>
          <td>Muokkaa ilmoitusta</td>
          <td>Poista ilmoitus</td>
          <td>Otsikko</td>
          <td>Kuvaus</td>
          <td>Kunto</td>
          <td>Postinumero</td>
          <td>Suomen ulkopuolella?</td>
          <td>Osasto</td>
          <td>Myyntitapa</td>
          <td>Hinta</td>
          <td>Minimikorotus</td>
          <td>Hintaehdotukset?</td>
          <td>Aukioloaika - alku</td>
          <td>Aukioloaika - päättyy</td>
          <td>Vain tunnistautuneille käyttäjille?</td>
          <td>Nouto?</td>
          <td>Toimitus?</td>
          <td>Toimituskulut</td>
          <td>Toimitusehdot</td>
          <td>Tilisiirto?</td>
          <td>Käteinen?</td>
          <td>Paypal?</td>
          <td>Mobilepay?</td>
          <td>Maksuehdot</td>
          <td>Kuvat</td>
        </tr>
    ";

    $postController = new PostController();
    $posts = $postController->getPosts();

    foreach ($posts as $post) {
      echo "
        <tr>
          <td>$post->id</td>
          <td>
            <input type='checkbox' name='selected-posts[]' value='$post->id'>
          </td>
          <td><a href='/index.php/edit-post/$post->id'>Muokkaa</a></td>
          <td><a href='#' class='delete-post-btn' onClick='openCloseDeletePostPopup($post->id)'>Poista</a></td>
          <td>$post->title</td>
          <td>$post->description</td>
          <td>$post->itemCondition</td>
          <td>$post->zipCode</td>
          <td>$post->isOutsideOfFinland</td>
          <td>$post->category</td>
          <td>$post->sellType</td>
          <td>$post->price</td>
          <td>$post->minimumRaise</td>
          <td>$post->isPriceSuggestion</td>
          <td>$post->activeTimeBegin</td>
          <td>$post->activeTimeEnd</td>
          <td>$post->onlyToIdentifiedUsers</td>
          <td>{$post->deliveryDetails->isFetch}</td>
          <td>{$post->deliveryDetails->isDelivery}</td>
          <td>{$post->deliveryDetails->deliveryFee}</td>
          <td>{$post->deliveryDetails->deliveryTerms}</td>
          <td>{$post->paymentDetails->isBankTransfer}</td>
          <td>{$post->paymentDetails->isCash}</td>
          <td>{$post->paymentDetails->isPayPal}</td>
          <td>{$post->paymentDetails->isMobilePay}</td>
          <td>{$post->paymentDetails->paymentTerms}</td>
      ";

      if ($post->imageDetails) {
        echo "<td class='image-container'>";
        foreach ($post->imageDetails as $imageDetails) {
          echo "
            <img src='$imageDetails->imagePath'>
          ";
        }
      } else {
        echo "<td>";
      }

      echo "
          </td>
        </tr>
      ";
    }

    echo "</table>";
  }
}
