class Dropdown
{
  /**
   * @param {string} dropDownBtnId
   * @param {string} dropdownId
   */
  static connectElements(dropDownBtnId, dropdownId)
  {
    let dropdownBtn = document.getElementById(dropDownBtnId);
    let dropdown = document.getElementById(dropdownId);

    dropdownBtn.addEventListener("click", function() {
      if (dropdown.style.display == "block") {
        ElementDisplay.change(dropdownId, "none");
      } else {
        ElementDisplay.change(dropdownId, "block");
      }
    });
  }
}
