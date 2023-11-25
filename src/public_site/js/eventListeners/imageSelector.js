const postImageInput = document.getElementById("post-image");
const postImageContainerId = "post-image-container";
const postImageSelectorId = "post-image-selector";

const displaySelectedImages = () => {
  const selectedImages = postImageInput.files;
  const selectedImagesContainer = document.getElementById(postImageContainerId);

  for (const selectedImage of selectedImages) {
    const selectedImageElement = document.createElement("img");
    selectedImageElement.src = URL.createObjectURL(selectedImage);

    selectedImagesContainer.appendChild(selectedImageElement);
  }

  if (selectedImages.length >= 5) {
    document.getElementById(postImageSelectorId).style.display = "none";
  }
};

postImageInput.addEventListener("change", displaySelectedImages);
