<?php

namespace PHPMaker2022\eksbs;

// Menu Language
if ($Language && function_exists(PROJECT_NAMESPACE . "Config") && $Language->LanguageFolder == Config("LANGUAGE_FOLDER")) {
    $MenuRelativePath = "";
    $MenuLanguage = &$Language;
} else { // Compat reports
    $LANGUAGE_FOLDER = "../lang/";
    $MenuRelativePath = "../";
    $MenuLanguage = Container("language");
}

// Navbar menu
$topMenu = new Menu("navbar", true, true);
echo $topMenu->toScript();

// Sidebar menu
$sideMenu = new Menu("menu", true, false);
$sideMenu->addMenuItem(1, "mi_site_settings", $MenuLanguage->MenuPhrase("1", "MenuText"), $MenuRelativePath . "SiteSettingsList", -1, "", AllowListMenu('{514776AE-DABD-4646-A974-0B7DBFD74303}site_settings'), false, false, "", "", false);
$sideMenu->addMenuItem(9, "mi_links", $MenuLanguage->MenuPhrase("9", "MenuText"), $MenuRelativePath . "LinksList", -1, "", AllowListMenu('{514776AE-DABD-4646-A974-0B7DBFD74303}links'), false, false, "", "", false);
$sideMenu->addMenuItem(10, "mi_photo_galleries", $MenuLanguage->MenuPhrase("10", "MenuText"), $MenuRelativePath . "PhotoGalleriesList", -1, "", AllowListMenu('{514776AE-DABD-4646-A974-0B7DBFD74303}photo_galleries'), false, false, "", "", false);
$sideMenu->addMenuItem(15, "mci_Event_and_Activities", $MenuLanguage->MenuPhrase("15", "MenuText"), $MenuRelativePath . "javascript:void(0)", -1, "", IsLoggedIn(), false, true, "", "", false);
$sideMenu->addMenuItem(7, "mi_event_category", $MenuLanguage->MenuPhrase("7", "MenuText"), $MenuRelativePath . "EventCategoryList", 15, "", AllowListMenu('{514776AE-DABD-4646-A974-0B7DBFD74303}event_category'), false, false, "", "", false);
$sideMenu->addMenuItem(8, "mi_events", $MenuLanguage->MenuPhrase("8", "MenuText"), $MenuRelativePath . "EventsList", 15, "", AllowListMenu('{514776AE-DABD-4646-A974-0B7DBFD74303}events'), false, false, "", "", false);
$sideMenu->addMenuItem(6, "mci_Admin_Users", $MenuLanguage->MenuPhrase("6", "MenuText"), $MenuRelativePath . "javascript:void(0)", -1, "", IsLoggedIn(), false, true, "", "", false);
$sideMenu->addMenuItem(3, "mi_users", $MenuLanguage->MenuPhrase("3", "MenuText"), $MenuRelativePath . "UsersList", 6, "", AllowListMenu('{514776AE-DABD-4646-A974-0B7DBFD74303}users'), false, false, "", "", false);
$sideMenu->addMenuItem(4, "mi_user_level2", $MenuLanguage->MenuPhrase("4", "MenuText"), $MenuRelativePath . "UserLevel2List", 6, "", AllowListMenu('{514776AE-DABD-4646-A974-0B7DBFD74303}user_level'), false, false, "", "", false);
$sideMenu->addMenuItem(5, "mi_user_permission", $MenuLanguage->MenuPhrase("5", "MenuText"), $MenuRelativePath . "UserPermissionList", 6, "", AllowListMenu('{514776AE-DABD-4646-A974-0B7DBFD74303}user_permission'), false, false, "", "", false);
$sideMenu->addMenuItem(2, "mi_user_log", $MenuLanguage->MenuPhrase("2", "MenuText"), $MenuRelativePath . "UserLogList", 6, "", AllowListMenu('{514776AE-DABD-4646-A974-0B7DBFD74303}user_log'), false, false, "", "", false);
echo $sideMenu->toScript();
