const showHideZipCodeInput = () => {
  const isOutsideOfFinlandCheckbox = document.getElementById("is-outside-of-finland");
  const zipCodeInputId = "zip-code";

  if (isOutsideOfFinlandCheckbox.checked) {
    ElementDisplay.change(zipCodeInputId, "none");
    return
  }

  ElementDisplay.change(zipCodeInputId, "inline-block");
};

document.addEventListener("change", showHideZipCodeInput)
