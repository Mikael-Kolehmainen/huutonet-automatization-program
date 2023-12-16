const mainCategorySelect = document.getElementById("main-category");
const subCategorySelect = document.getElementById("sub-category");
const subSubCategorySelect = document.getElementById("category");

const updateSubCategorySelect = async () => {
  while (subCategorySelect.options.length > 0) {
    subCategorySelect.remove(0);
  }

  const mainCategoryId = mainCategorySelect.value;
  const ajax = new Data(`/index.php/ajax/sub-categories/${mainCategoryId}`);
  const rawSubCategories = await ajax.receiveFromBackend();
  const subCategories = JSON.parse(rawSubCategories);

  subCategories.forEach(subCategory => {
    const subCategoryOption = document.createElement("option");
    subCategoryOption.value = subCategory.id;
    subCategoryOption.innerText = subCategory.title;
    subCategorySelect.appendChild(subCategoryOption);
  });

  await updateSubSubCategorySelect();
};

const updateSubSubCategorySelect = async () => {
  while (subSubCategorySelect.options.length > 0) {
    subSubCategorySelect.remove(0);
  }

  const subCategoryId = subCategorySelect.value;
  const ajax = new Data(`/index.php/ajax/sub-sub-categories/${subCategoryId}`);
  const rawSubSubCategories = await ajax.receiveFromBackend();
  const subSubCategories = JSON.parse(rawSubSubCategories);

  subSubCategories.forEach(subSubCategory => {
    const subSubCategoryOption = document.createElement("option");
    subSubCategoryOption.value = subSubCategory.id;
    subSubCategoryOption.innerText = subSubCategory.title;
    subSubCategorySelect.appendChild(subSubCategoryOption);
  });
};

mainCategorySelect.addEventListener("change", updateSubCategorySelect);
subCategorySelect.addEventListener("change", updateSubSubCategorySelect);
