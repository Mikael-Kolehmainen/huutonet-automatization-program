<?php

namespace public_site\controller;

use public_site\controller\HeaderController;

class BrowseController
{
  public function showBrowsePage(): void
  {
    $this->showHeader();

    echo "
      <section>
        <h2>Ilmoitukset</h2>
        <form>
          <table>
    ";

    $this->showPosts();

    echo "
          </table>
          <div>
            <input type='checkbox' id='change-active-time' name='change-active-time'>
            <label for='change-active-time'>Määritä aukioloaika kaikkille valituille ilmoituksille.</label>
          </div>
          <div id='active-time-changers'>
            <label for='active-time-start'>Aukioloaika - alku</label>
            <input type='date' name='active-time-start'>
            <label for='active-time-end'>Aukioloaika - päättyy</label>
            <div class='radio-group'>
              <input type='radio' id='14-days' value='14 päivää' name='active-time-end'>
              <label for='14-days'>14 päivää</label>
              <input type='radio' id='7-days' value='7 päivää' name='active-time-end'>
              <label for='7-days'>7 päivää</label>
            </div>
          </div>
          <input type='text' name='huutonet-username' placeholder='Huutonet käyttäjänimi' required>
          <input type='password' name='huutonet-password' placeholder='Huutonet salasana' required>
          <div class='btn-container'>
            <input type='submit' class='btn' value='Luo valittut ilmoitukset Huutonet:iin'>
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

  private function showPosts(): void
  {
    $postController = new PostController();
    $posts = $postController->getPosts();
    print_r($posts);
  }
}
