<?php

namespace public_site\controller;

use public_site\controller\HeaderController;
use public_site\controller\CategoryController;
use public_site\controller\PostController;

class EditController
{
  private $post;

  public function showEditPage(): void
  {
    $this->showHeader();
    $this->getPost();

    echo "
        <title>Muokkaa ilmoitusta</title>
        <script src='/src/public_site/js/eventListeners/isOutsideOfFinland.js' defer></script>
        <script src='/src/public_site/js/eventListeners/isDelivery.js' defer></script>
        <script src='/src/public_site/js/eventListeners/sellType.js' defer></script>
        <script src='/src/public_site/js/eventListeners/updateMinimumRaise.js' defer></script>
        <script src='/src/public_site/js/eventListeners/imageSelector.js' defer></script>
        <script src='/src/public_site/js/eventListeners/updateCategories.js' defer></script>
      </head>
      <section>
        <h2>Muokkaa ilmoitusta</h2>
        <form action='/index.php/post/update/{$this->post->id}' method='POST' enctype='multipart/form-data'>
          <input type='text' placeholder='Otsikko' name='title' value='{$this->post->title}' required>
          <textarea placeholder='Kuvaus' name='description' required>{$this->post->description}</textarea>
          <div class='image-container' id='post-image-container'>
            <label class='image-file-input' id='post-image-selector'>
              <input type='file' name='post-images[]' id='post-image' accept='png/jpg/jpeg/gif' multiple>
              <p id='file-input-text'>Lisää kuva</p>
            </label>";
          $this->showPostImages();
    echo "
          </div>
          <p>Kunto:</p>
          <div class='radio-group'>";
          $this->showItemConditionRadioButtons();
    echo "
          </div>
          <div class='input-with-checkbox'>
            <input type='text' placeholder='Postinumero' id='zip-code' name='zip-code' value='{$this->post->zipCode}' style='display: {$this->isVisible(!$this->post->isOutsideOfFinland)}'>
            <input type='checkbox' id='is-outside-of-finland' value='1' name='is-outside-of-finland' {$this->isChecked($this->post->isOutsideOfFinland)}>
            <label for='is-outside-of-finland'>Tuote sijaitsee Suomen ulkopuolella</label>
          </div>";
          $this->showCategoriesDropdowns();
    echo "
          <p>Myyntitapa:</p>
          <div class='radio-group'>";
          $this->showSellTypeRadioButtons();
    echo "
          </div>
          <div class='input-with-checkbox'>
            <input type='number' placeholder='Hinta' id='price' name='price' step='.01' value='{$this->post->price}' required>
            <input type='number' placeholder='Minimikorotus' id='minimum-raise' name='minimum-raise' step='.01' value='{$this->post->minimumRaise}' style='display: {$this->isVisible($this->post->sellType === "auction")}' disabled>
            <input type='checkbox' id='is-price-suggestion' value='1' name='is-price-suggestion' {$this->isChecked($this->post->isPriceSuggestion)}>
            <label for='is-price-suggestion'>Ostaja saa ehdottaa hintaa</label>
          </div>
          <div class='input-with-checkbox reversed'>
            <input type='checkbox' id='is-fetch' value='1' name='is-fetch' {$this->isChecked($this->post->deliveryDetails->isFetch)}>
            <label for='is-fetch'>Nouto</label>
            <input type='checkbox' id='is-delivery' value='1' name='is-delivery' {$this->isChecked($this->post->deliveryDetails->isDelivery)}>
            <label for='is-delivery'>Toimitus</label>
            <input type='number' placeholder='Toimituskulut Suomeen' id='delivery-fee' name='delivery-fee' step='.01' value='{$this->post->deliveryDetails->deliveryFee}' style='display: {$this->isVisible($this->post->deliveryDetails->isDelivery)}'>
          </div>
          <textarea placeholder='Muut toimitus-/palautusehdot' name='delivery-terms'>{$this->post->deliveryDetails->deliveryTerms}</textarea>
          <div>
            <input type='checkbox' id='is-bank-transfer' value='1' name='is-bank-transfer' {$this->isChecked($this->post->paymentDetails->isBankTransfer)}>
            <label for='is-bank-transfer'>Tilisiirto</label>
            <input type='checkbox' id='is-cash' value='1' name='is-cash' {$this->isChecked($this->post->paymentDetails->isCash)}>
            <label for='is-cash'>Käteinen</label>
            <input type='checkbox' id='is-paypal' value='1' name='is-paypal' {$this->isChecked($this->post->paymentDetails->isPayPal)}>
            <label for='is-paypal'>Paypal</label>
            <input type='checkbox' id='is-mobilepay' value='1' name='is-mobilepay' {$this->isChecked($this->post->paymentDetails->isMobilePay)}>
            <label for='is-mobilepay'>Mobilepay</label>
          </div>
          <textarea placeholder='Muut maksuehdot' name='payment-terms'>{$this->post->paymentDetails->paymentTerms}</textarea>
          <label for='active-time-begin'>Aukioloaika - alku</label>
          <input type='date' name='active-time-begin' value='{$this->post->activeTimeBegin}' required>
          <p>Aukioloaika - päättyy</p>
          <div class='radio-group'>
            <input type='radio' id='14-days' value='14' name='active-time-end' required checked>
            <label for='14-days'>14 päivää</label>
            <input type='radio' id='7-days' value='7' name='active-time-end' required>
            <label for='7-days'>7 päivää</label>
          </div>
          <div>
            <input type='checkbox' id='only-to-identified-users' value='1' name='only-to-identified-users' {$this->isChecked($this->post->onlyToIdentifiedUsers)}>
            <label for='only-to-identified-users'>Myyn vain tunnistautuneille käyttäjille</label>
          </div>
          <div class='btn-container'>
            <input type='submit' class='btn' name='edit-post' value='Päivitä ilmoitus tietokannassa'>
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

  private function getPost(): void
  {
    $postController = new PostController();
    $this->post = $postController->getPostWithUriId();
  }

  private function showPostImages(): void
  {
    foreach ($this->post->imageDetails as $postImage) {
      echo "<img src='$postImage->imagePath'>";
    }
  }

  private function showItemConditionRadioButtons(): void
  {
    $itemConditions = ["new", "like-new", "good", "acceptable", "weak"];
    $itemConditionsLabels = ["Uusi", "Uudenveroinen", "Hyvä", "Tyydyttävä", "Heikko"];
    foreach ($itemConditions as $key => $itemCondition) {
      $checked = $this->isChecked($this->post->itemCondition === $itemCondition);
      echo "
        <input type='radio' id='$itemCondition' value='$itemCondition' name='item-condition' required $checked>
        <label for='$itemCondition'>$itemConditionsLabels[$key]</label>
      ";
    }
  }

  private function isVisible($condition): string
  {
    return $condition ? "inline-block;" : "none;";
  }

  private function isChecked($condition): string
  {
    return $condition ? "checked" : "";
  }

  private function showCategoriesDropdowns(): void
  {
    $categoryController = new CategoryController();
    $categoryController->selectedCategory = $this->post->category;
    $categoryController->showCategories();
  }

  private function showSellTypeRadioButtons(): void
  {
    $sellTypes = ["buy-now", "auction"];
    $sellTypesLabels = ["Osta heti", "Huutokauppa"];
    foreach ($sellTypes as $key => $sellType) {
      $checked = $this->isChecked($this->post->sellType === $sellType);
      echo "
        <input type='radio' id='$sellType' value='$sellType' name='sell-type' required $checked>
        <label for='$sellType'>$sellTypesLabels[$key]</label>
      ";
    }
  }
}
