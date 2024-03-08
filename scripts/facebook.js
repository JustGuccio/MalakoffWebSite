const { Builder, By, Key, until } = require('selenium-webdriver');

// Créer un pilote WebDriver pour Chrome
let driver = new selenium.WebDriverBuilder()
    .forBrowser('chrome')
    .build();

// Accéder à une page web
driver.get('https://www.example.com');

// Effectuer des actions sur la page
driver.findElement(selenium.By.id('myElement')).click();

// Fermer le navigateur
driver.quit();