const deliveryFeeInputId = "delivery-fee";
const isDeliveryCheckboxId = "is-delivery";

const showHideDeliveryFeeInput = () => {
  ElementDisplay.changeBasedOnCheckbox(
    isDeliveryCheckboxId,
    deliveryFeeInputId,
    "inline-block",
    "none"
  );
  ElementDisplay.disableOrEnable(deliveryFeeInputId);
};

document.getElementById(isDeliveryCheckboxId).addEventListener("change", showHideDeliveryFeeInput);
