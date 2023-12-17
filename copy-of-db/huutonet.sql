CREATE DATABASE huutonet_automatization;

CREATE TABLE post (
  id INT NOT NULL AUTO_INCREMENT,
  title VARCHAR(60) NOT NULL,
  description VARCHAR(2000) NOT NULL,
  itemCondition ENUM('weak', 'acceptable', 'good', 'like-new', 'new') NOT NULL,
  zipCode VARCHAR(5) NULL,
  isOutsideOfFinland TINYINT(1) NOT NULL,
  category INT NOT NULL,
  sellType ENUM('buy-now', 'auction') NOT NULL,
  price DECIMAL(9,2) NOT NULL,
  minimumRaise DECIMAL(9,2) NULL,
  isPriceSuggestion TINYINT(1) NOT NULL,
  delivery_id int NOT NULL,
  payment_id int NOT NULL,
  activeTimeBegin DATETIME NOT NULL,
  activeTimeEnd DATETIME NOT NULL,
  onlyToIdentifiedUsers TINYINT(1) NOT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (delivery_id) REFERENCES delivery(id),
  FOREIGN KEY (payment_id) REFERENCES payment(id)
);

CREATE TABLE image (
  id INT NOT NULL AUTO_INCREMENT,
  imagePath VARCHAR(255) NOT NULL,
  post_id INT NOT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (post_id) REFERENCES post(id)
);

CREATE TABLE delivery (
  id INT NOT NULL AUTO_INCREMENT,
  isFetch TINYINT(1) NOT NULL,
  isDelivery TINYINT(1) NOT NULL,
  deliveryFee DECIMAL(9,2) NULL,
  deliveryTerms VARCHAR(1000) NULL,
  PRIMARY KEY (id)
);

CREATE TABLE payment (
  id INT NOT NULL AUTO_INCREMENT,
  isBankTransfer TINYINT(1) NOT NULL,
  isCash TINYINT(1) NOT NULL,
  isPayPal TINYINT(1) NOT NULL,
  isMobilePay TINYINT(1) NOT NULL,
  paymentTerms VARCHAR(1000),
  PRIMARY KEY (id)
);
