const activeTimeChangersDivId = "active-time-changers";
const changeActiveTimeCheckboxId = "change-active-time";

const showHideDeliveryFeeInput = () => {
  ElementDisplay.changeBasedOnCheckbox(
    changeActiveTimeCheckboxId,
    activeTimeChangersDivId,
    "block",
    "none"
  );
  ElementDisplay.disableOrEnable(activeTimeChangersDivId);
};

document.getElementById(changeActiveTimeCheckboxId).addEventListener("change", showHideDeliveryFeeInput);
