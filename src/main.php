<?php
require "../vendor/autoload.php";

use HeadlessChromium\BrowserFactory;

$browserFactory = new BrowserFactory("chromium");
$browser = $browserFactory->createBrowser(["noSandbox" => true]);
$credentials = include "config.php";
$page = $browser->createPage();
while (true) {
    try {
        $page->navigate('https://mit.tv2.dk/konto/play/enheder')->waitForNavigation();
        $pageTitle = $page->evaluate('document.title')->getReturnValue();
        if ($pageTitle == "Log ind") {
            echo "Not logged in, logging in...\n";
            // Username
            $page->evaluate('document.querySelector("#input-guid-1").focus();');
            $page->keyboard()->typeText($credentials["username"]);
            $page->keyboard()->typeRawKey('Tab');
            $page->keyboard()->typeText($credentials["password"]);
            $page->keyboard()->typeRawKey('Tab');
            sleep(2);
            $page->evaluate('document.querySelector("#app > div > div > div > div.FormContainer_content__4NaEi > form > div > div.Bottom_container__EKoqD > button").click()');
            sleep(3);
            echo "Login complete\n";
        }
        $numOfDevices = $page->evaluate('document.querySelectorAll(".datatable__tbody > tr").length.toString();')->getReturnValue();
        while ($numOfDevices > 0) {
            $deviceName = $page->evaluate('document.querySelector(".datatable__tbody > tr > td:nth-child(1) > strong").innerHTML.toString()')->getReturnValue();
            $page->evaluate('document.querySelector(".datatable__tbody > tr:nth-child(1) > td:nth-child(4) > button").click()');
            sleep(1);
            $numOfDevices = $page->evaluate('document.querySelectorAll(".datatable__tbody > tr").length.toString();')->getReturnValue();
            echo "Removed device $deviceName...\n";
            sleep(1);
        }
    } finally {

    }
    sleep(300);
}

