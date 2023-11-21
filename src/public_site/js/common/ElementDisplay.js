class ElementDisplay
{
  /**
   * @param {string} elementId
   * @param {string} display
   */
  static change(elementId, display)
  {
    document.getElementById(elementId).style.display = display;
  }

  /**
   * @param {string} elementId
   */
  static disableOrEnable(elementId)
  {
    document.getElementById(elementId).disabled = !document.getElementById(elementId).disabled;
  }

  /**
   * @param {string} checkboxId
   * @param {string} elementId
   * @param {string} checkedDisplay
   * @param {string} notCheckedDisplay
   * @returns {void}
   */
  static changeBasedOnCheckbox(
    checkboxId,
    elementId,
    checkedDisplay = "none",
    notCheckedDisplay = "inline-block"
  )
  {
    const checkbox = document.getElementById(checkboxId);

    if (checkbox.checked) {
      this.change(elementId, checkedDisplay);
      return;
    }

    ElementDisplay.change(elementId, notCheckedDisplay);
  }
}
