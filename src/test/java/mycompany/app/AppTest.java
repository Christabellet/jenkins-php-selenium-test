package com.mycompany.app;

import java.io.ByteArrayOutputStream;
import java.io.PrintStream;
import org.junit.Before;
import org.junit.Test;
import org.junit.After;
import static org.junit.Assert.*;

import org.openqa.selenium.By;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;
import org.openqa.selenium.chrome.ChromeDriver;
import org.openqa.selenium.firefox.FirefoxDriver;
import org.openqa.selenium.htmlunit.HtmlUnitDriver;
import org.openqa.selenium.support.ui.ExpectedConditions;
import org.openqa.selenium.support.ui.WebDriverWait;

/**
 * Integration UI test for PHP App.
 */
public class AppTest {

    WebDriver driver;
    WebDriverWait wait;
    String url = "http://192.168.1.249";
    String searchTermWithScript = "<script>alert('XSS');</script>";
    String searchTermWithSQLInjection = "test'; DROP TABLE users; --";
	String validSearchTerm = "cheese";

    @Before
    public void setUp() {
        driver = new HtmlUnitDriver();
        wait = new WebDriverWait(driver, 10);
    }

    @After
    public void tearDown() {
        driver.quit();
    }

    @Test
    public void testSearchWithValidTerm() {
        driver.get(url);
        wait.until(ExpectedConditions.titleContains("Home Page"));

        driver.findElement(By.id("searchTerm")).sendKeys("validSearchTerm");
        driver.findElement(By.name("submit")).submit();

        // Assuming the results page has a specific title or element to verify
        assertTrue(driver.getTitle().contains("Results"));
    }

    @Test
    public void testSearchWithScript() {
        driver.get(url);
        wait.until(ExpectedConditions.titleContains("Home Page"));

        driver.findElement(By.id("searchTerm")).sendKeys(searchTermWithScript);
        driver.findElement(By.name("submit")).submit();

        // Assuming the results page has an error message for invalid input
        assertTrue(driver.getPageSource().contains("Invalid input detected"));
    }

    @Test
    public void testSearchWithSQLInjection() {
        driver.get(url);
        wait.until(ExpectedConditions.titleContains("Home Page"));

        driver.findElement(By.id("searchTerm")).sendKeys(searchTermWithSQLInjection);
        driver.findElement(By.name("submit")).submit();

        // Assuming the results page has an error message for invalid input
        assertTrue(driver.getPageSource().contains("Invalid input detected"));
    }
}
