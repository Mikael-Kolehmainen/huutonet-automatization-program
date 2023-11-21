const priceInputId = "price";

const updateMinimumRaise = () => {
  const price = document.getElementById(priceInputId).value;
  document.getElementById("minimum-raise").value = getMinimumRaise(price);
};

const getMinimumRaise = (price) => {
  if (!price) return 0;
  if (price < 49.99) return 1;
  if (price < 99.99) return 2;
  if (price < 499.99) return 5;
  if (price < 999.99) return 10;

  return 20;
};

document.getElementById(priceInputId).addEventListener("blur", updateMinimumRaise);
