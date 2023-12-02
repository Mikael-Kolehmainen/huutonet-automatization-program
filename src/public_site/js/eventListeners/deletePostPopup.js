const deletePostCancelBtn = document.getElementById("delete-post-cancel");
const deletePostPopupId = "delete-post-popup";
const deletePostPopupParagraph = document.getElementById("delete-post-popup-text");
const deletePostPopupConfirmBtn = document.getElementById("delete-post-confirm");
let isDeletePostPopupOpen = false;

const openCloseDeletePostPopup = (postId) => {
  deletePostPopupParagraph.innerText = `Oletko varma että haluat poistaa ilmoituksen (ID: ${postId})?`;
  deletePostPopupConfirmBtn.setAttribute("href", `/index.php/post/delete/${postId}`);

  if (isDeletePostPopupOpen) {
    ElementDisplay.change(deletePostPopupId, "none")
    isDeletePostPopupOpen = !isDeletePostPopupOpen;
    return;
  }

  ElementDisplay.change(deletePostPopupId, "block");
  isDeletePostPopupOpen = !isDeletePostPopupOpen;
};

deletePostCancelBtn.addEventListener("click", openCloseDeletePostPopup);
