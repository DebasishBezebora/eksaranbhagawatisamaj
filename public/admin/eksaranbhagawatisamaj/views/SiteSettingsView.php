<?php

namespace PHPMaker2022\eksbs;

// Page object
$SiteSettingsView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { site_settings: currentTable } });
var currentForm, currentPageID;
var fsite_settingsview;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fsite_settingsview = new ew.Form("fsite_settingsview", "view");
    currentPageID = ew.PAGE_ID = "view";
    currentForm = fsite_settingsview;
    loadjs.done("fsite_settingsview");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php } ?>
<?php if (!$Page->isExport()) { ?>
<div class="btn-toolbar ew-toolbar">
<?php $Page->ExportOptions->render("body") ?>
<?php $Page->OtherOptions->render("body") ?>
</div>
<?php } ?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fsite_settingsview" id="fsite_settingsview" class="ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="site_settings">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-bordered table-hover table-sm ew-view-table">
<?php if ($Page->ID->Visible) { // ID ?>
    <tr id="r_ID"<?= $Page->ID->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_site_settings_ID"><?= $Page->ID->caption() ?></span></td>
        <td data-name="ID"<?= $Page->ID->cellAttributes() ?>>
<span id="el_site_settings_ID">
<span<?= $Page->ID->viewAttributes() ?>>
<?= $Page->ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Contact_No_1->Visible) { // Contact_No_1 ?>
    <tr id="r_Contact_No_1"<?= $Page->Contact_No_1->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_site_settings_Contact_No_1"><?= $Page->Contact_No_1->caption() ?></span></td>
        <td data-name="Contact_No_1"<?= $Page->Contact_No_1->cellAttributes() ?>>
<span id="el_site_settings_Contact_No_1">
<span<?= $Page->Contact_No_1->viewAttributes() ?>>
<?= $Page->Contact_No_1->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Contact_No_2->Visible) { // Contact_No_2 ?>
    <tr id="r_Contact_No_2"<?= $Page->Contact_No_2->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_site_settings_Contact_No_2"><?= $Page->Contact_No_2->caption() ?></span></td>
        <td data-name="Contact_No_2"<?= $Page->Contact_No_2->cellAttributes() ?>>
<span id="el_site_settings_Contact_No_2">
<span<?= $Page->Contact_No_2->viewAttributes() ?>>
<?= $Page->Contact_No_2->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Brand_Name->Visible) { // Brand_Name ?>
    <tr id="r_Brand_Name"<?= $Page->Brand_Name->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_site_settings_Brand_Name"><?= $Page->Brand_Name->caption() ?></span></td>
        <td data-name="Brand_Name"<?= $Page->Brand_Name->cellAttributes() ?>>
<span id="el_site_settings_Brand_Name">
<span<?= $Page->Brand_Name->viewAttributes() ?>>
<?= $Page->Brand_Name->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Logo->Visible) { // Logo ?>
    <tr id="r_Logo"<?= $Page->Logo->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_site_settings_Logo"><?= $Page->Logo->caption() ?></span></td>
        <td data-name="Logo"<?= $Page->Logo->cellAttributes() ?>>
<span id="el_site_settings_Logo">
<span<?= $Page->Logo->viewAttributes() ?>>
<?= GetFileViewTag($Page->Logo, $Page->Logo->getViewValue(), false) ?>
</span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Favicon->Visible) { // Favicon ?>
    <tr id="r_Favicon"<?= $Page->Favicon->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_site_settings_Favicon"><?= $Page->Favicon->caption() ?></span></td>
        <td data-name="Favicon"<?= $Page->Favicon->cellAttributes() ?>>
<span id="el_site_settings_Favicon">
<span<?= $Page->Favicon->viewAttributes() ?>>
<?= GetFileViewTag($Page->Favicon, $Page->Favicon->getViewValue(), false) ?>
</span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Address->Visible) { // Address ?>
    <tr id="r_Address"<?= $Page->Address->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_site_settings_Address"><?= $Page->Address->caption() ?></span></td>
        <td data-name="Address"<?= $Page->Address->cellAttributes() ?>>
<span id="el_site_settings_Address">
<span<?= $Page->Address->viewAttributes() ?>>
<?= $Page->Address->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Facebook->Visible) { // Facebook ?>
    <tr id="r_Facebook"<?= $Page->Facebook->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_site_settings_Facebook"><?= $Page->Facebook->caption() ?></span></td>
        <td data-name="Facebook"<?= $Page->Facebook->cellAttributes() ?>>
<span id="el_site_settings_Facebook">
<span<?= $Page->Facebook->viewAttributes() ?>>
<?= $Page->Facebook->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Twitter->Visible) { // Twitter ?>
    <tr id="r_Twitter"<?= $Page->Twitter->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_site_settings_Twitter"><?= $Page->Twitter->caption() ?></span></td>
        <td data-name="Twitter"<?= $Page->Twitter->cellAttributes() ?>>
<span id="el_site_settings_Twitter">
<span<?= $Page->Twitter->viewAttributes() ?>>
<?= $Page->Twitter->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Instagram->Visible) { // Instagram ?>
    <tr id="r_Instagram"<?= $Page->Instagram->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_site_settings_Instagram"><?= $Page->Instagram->caption() ?></span></td>
        <td data-name="Instagram"<?= $Page->Instagram->cellAttributes() ?>>
<span id="el_site_settings_Instagram">
<span<?= $Page->Instagram->viewAttributes() ?>>
<?= $Page->Instagram->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Map->Visible) { // Map ?>
    <tr id="r_Map"<?= $Page->Map->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_site_settings_Map"><?= $Page->Map->caption() ?></span></td>
        <td data-name="Map"<?= $Page->Map->cellAttributes() ?>>
<span id="el_site_settings_Map">
<span<?= $Page->Map->viewAttributes() ?>>
<?= $Page->Map->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->_Title->Visible) { // Title ?>
    <tr id="r__Title"<?= $Page->_Title->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_site_settings__Title"><?= $Page->_Title->caption() ?></span></td>
        <td data-name="_Title"<?= $Page->_Title->cellAttributes() ?>>
<span id="el_site_settings__Title">
<span<?= $Page->_Title->viewAttributes() ?>>
<?= $Page->_Title->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Description->Visible) { // Description ?>
    <tr id="r_Description"<?= $Page->Description->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_site_settings_Description"><?= $Page->Description->caption() ?></span></td>
        <td data-name="Description"<?= $Page->Description->cellAttributes() ?>>
<span id="el_site_settings_Description">
<span<?= $Page->Description->viewAttributes() ?>>
<?= $Page->Description->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Keywords->Visible) { // Keywords ?>
    <tr id="r_Keywords"<?= $Page->Keywords->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_site_settings_Keywords"><?= $Page->Keywords->caption() ?></span></td>
        <td data-name="Keywords"<?= $Page->Keywords->cellAttributes() ?>>
<span id="el_site_settings_Keywords">
<span<?= $Page->Keywords->viewAttributes() ?>>
<?= $Page->Keywords->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Active->Visible) { // Active ?>
    <tr id="r_Active"<?= $Page->Active->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_site_settings_Active"><?= $Page->Active->caption() ?></span></td>
        <td data-name="Active"<?= $Page->Active->cellAttributes() ?>>
<span id="el_site_settings_Active">
<span<?= $Page->Active->viewAttributes() ?>>
<?= $Page->Active->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Created_AT->Visible) { // Created_AT ?>
    <tr id="r_Created_AT"<?= $Page->Created_AT->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_site_settings_Created_AT"><?= $Page->Created_AT->caption() ?></span></td>
        <td data-name="Created_AT"<?= $Page->Created_AT->cellAttributes() ?>>
<span id="el_site_settings_Created_AT">
<span<?= $Page->Created_AT->viewAttributes() ?>>
<?= $Page->Created_AT->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Created_BY->Visible) { // Created_BY ?>
    <tr id="r_Created_BY"<?= $Page->Created_BY->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_site_settings_Created_BY"><?= $Page->Created_BY->caption() ?></span></td>
        <td data-name="Created_BY"<?= $Page->Created_BY->cellAttributes() ?>>
<span id="el_site_settings_Created_BY">
<span<?= $Page->Created_BY->viewAttributes() ?>>
<?= $Page->Created_BY->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->IP->Visible) { // IP ?>
    <tr id="r_IP"<?= $Page->IP->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_site_settings_IP"><?= $Page->IP->caption() ?></span></td>
        <td data-name="IP"<?= $Page->IP->cellAttributes() ?>>
<span id="el_site_settings_IP">
<span<?= $Page->IP->viewAttributes() ?>>
<?= $Page->IP->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<?php if (!$Page->isExport()) { ?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
