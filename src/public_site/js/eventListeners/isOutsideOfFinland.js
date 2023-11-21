const zipCodeInputId = "zip-code";
const isOutsideOfFinlandCheckboxId = "is-outside-of-finland";

const showHideZipCodeInput = () => {
  ElementDisplay.changeBasedOnCheckbox(isOutsideOfFinlandCheckboxId, zipCodeInputId);
  ElementDisplay.disableOrEnable(zipCodeInputId);
};

document.getElementById(isOutsideOfFinlandCheckboxId).addEventListener("change", showHideZipCodeInput);
