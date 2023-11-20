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
}
