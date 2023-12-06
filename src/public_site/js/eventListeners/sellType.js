const minimumRaiseInputId = "minimum-raise";
const buyNowRadioButtonId = "buy-now";
const auctionRadioButtonId = "auction";

const showHideMinimumRaiseInput = () => {
  const isBuyNow = document.getElementById(buyNowRadioButtonId).checked;

  if (isBuyNow) {
    ElementDisplay.change(minimumRaiseInputId, "none");
    return;
  }

  ElementDisplay.change(minimumRaiseInputId, "inline-block");
};

document.getElementById(buyNowRadioButtonId).addEventListener("change", showHideMinimumRaiseInput);
document.getElementById(auctionRadioButtonId).addEventListener("change", showHideMinimumRaiseInput);
