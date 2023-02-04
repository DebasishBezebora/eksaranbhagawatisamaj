<?php

namespace PHPMaker2022\eksbs;

// Page object
$SiteSettingsDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { site_settings: currentTable } });
var currentForm, currentPageID;
var fsite_settingsdelete;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fsite_settingsdelete = new ew.Form("fsite_settingsdelete", "delete");
    currentPageID = ew.PAGE_ID = "delete";
    currentForm = fsite_settingsdelete;
    loadjs.done("fsite_settingsdelete");
});
</script>
<script>
loadjs.ready("head", function () {
    // Write your table-specific client script here, no need to add script tags.
});
</script>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fsite_settingsdelete" id="fsite_settingsdelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="site_settings">
<input type="hidden" name="action" id="action" value="delete">
<?php foreach ($Page->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode(Config("COMPOSITE_KEY_SEPARATOR"), $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?= HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="card ew-card ew-grid">
<div class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table class="table table-bordered table-hover table-sm ew-table">
    <thead>
    <tr class="ew-table-header">
<?php if ($Page->ID->Visible) { // ID ?>
        <th class="<?= $Page->ID->headerCellClass() ?>"><span id="elh_site_settings_ID" class="site_settings_ID"><?= $Page->ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Contact_No_1->Visible) { // Contact_No_1 ?>
        <th class="<?= $Page->Contact_No_1->headerCellClass() ?>"><span id="elh_site_settings_Contact_No_1" class="site_settings_Contact_No_1"><?= $Page->Contact_No_1->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Contact_No_2->Visible) { // Contact_No_2 ?>
        <th class="<?= $Page->Contact_No_2->headerCellClass() ?>"><span id="elh_site_settings_Contact_No_2" class="site_settings_Contact_No_2"><?= $Page->Contact_No_2->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Brand_Name->Visible) { // Brand_Name ?>
        <th class="<?= $Page->Brand_Name->headerCellClass() ?>"><span id="elh_site_settings_Brand_Name" class="site_settings_Brand_Name"><?= $Page->Brand_Name->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Logo->Visible) { // Logo ?>
        <th class="<?= $Page->Logo->headerCellClass() ?>"><span id="elh_site_settings_Logo" class="site_settings_Logo"><?= $Page->Logo->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Favicon->Visible) { // Favicon ?>
        <th class="<?= $Page->Favicon->headerCellClass() ?>"><span id="elh_site_settings_Favicon" class="site_settings_Favicon"><?= $Page->Favicon->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Facebook->Visible) { // Facebook ?>
        <th class="<?= $Page->Facebook->headerCellClass() ?>"><span id="elh_site_settings_Facebook" class="site_settings_Facebook"><?= $Page->Facebook->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Twitter->Visible) { // Twitter ?>
        <th class="<?= $Page->Twitter->headerCellClass() ?>"><span id="elh_site_settings_Twitter" class="site_settings_Twitter"><?= $Page->Twitter->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Instagram->Visible) { // Instagram ?>
        <th class="<?= $Page->Instagram->headerCellClass() ?>"><span id="elh_site_settings_Instagram" class="site_settings_Instagram"><?= $Page->Instagram->caption() ?></span></th>
<?php } ?>
<?php if ($Page->_Title->Visible) { // Title ?>
        <th class="<?= $Page->_Title->headerCellClass() ?>"><span id="elh_site_settings__Title" class="site_settings__Title"><?= $Page->_Title->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Active->Visible) { // Active ?>
        <th class="<?= $Page->Active->headerCellClass() ?>"><span id="elh_site_settings_Active" class="site_settings_Active"><?= $Page->Active->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Created_AT->Visible) { // Created_AT ?>
        <th class="<?= $Page->Created_AT->headerCellClass() ?>"><span id="elh_site_settings_Created_AT" class="site_settings_Created_AT"><?= $Page->Created_AT->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Created_BY->Visible) { // Created_BY ?>
        <th class="<?= $Page->Created_BY->headerCellClass() ?>"><span id="elh_site_settings_Created_BY" class="site_settings_Created_BY"><?= $Page->Created_BY->caption() ?></span></th>
<?php } ?>
<?php if ($Page->IP->Visible) { // IP ?>
        <th class="<?= $Page->IP->headerCellClass() ?>"><span id="elh_site_settings_IP" class="site_settings_IP"><?= $Page->IP->caption() ?></span></th>
<?php } ?>
    </tr>
    </thead>
    <tbody>
<?php
$Page->RecordCount = 0;
$i = 0;
while (!$Page->Recordset->EOF) {
    $Page->RecordCount++;
    $Page->RowCount++;

    // Set row properties
    $Page->resetAttributes();
    $Page->RowType = ROWTYPE_VIEW; // View

    // Get the field contents
    $Page->loadRowValues($Page->Recordset);

    // Render row
    $Page->renderRow();
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php if ($Page->ID->Visible) { // ID ?>
        <td<?= $Page->ID->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_site_settings_ID" class="el_site_settings_ID">
<span<?= $Page->ID->viewAttributes() ?>>
<?= $Page->ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Contact_No_1->Visible) { // Contact_No_1 ?>
        <td<?= $Page->Contact_No_1->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_site_settings_Contact_No_1" class="el_site_settings_Contact_No_1">
<span<?= $Page->Contact_No_1->viewAttributes() ?>>
<?= $Page->Contact_No_1->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Contact_No_2->Visible) { // Contact_No_2 ?>
        <td<?= $Page->Contact_No_2->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_site_settings_Contact_No_2" class="el_site_settings_Contact_No_2">
<span<?= $Page->Contact_No_2->viewAttributes() ?>>
<?= $Page->Contact_No_2->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Brand_Name->Visible) { // Brand_Name ?>
        <td<?= $Page->Brand_Name->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_site_settings_Brand_Name" class="el_site_settings_Brand_Name">
<span<?= $Page->Brand_Name->viewAttributes() ?>>
<?= $Page->Brand_Name->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Logo->Visible) { // Logo ?>
        <td<?= $Page->Logo->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_site_settings_Logo" class="el_site_settings_Logo">
<span<?= $Page->Logo->viewAttributes() ?>>
<?= GetFileViewTag($Page->Logo, $Page->Logo->getViewValue(), false) ?>
</span>
</span>
</td>
<?php } ?>
<?php if ($Page->Favicon->Visible) { // Favicon ?>
        <td<?= $Page->Favicon->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_site_settings_Favicon" class="el_site_settings_Favicon">
<span<?= $Page->Favicon->viewAttributes() ?>>
<?= GetFileViewTag($Page->Favicon, $Page->Favicon->getViewValue(), false) ?>
</span>
</span>
</td>
<?php } ?>
<?php if ($Page->Facebook->Visible) { // Facebook ?>
        <td<?= $Page->Facebook->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_site_settings_Facebook" class="el_site_settings_Facebook">
<span<?= $Page->Facebook->viewAttributes() ?>>
<?= $Page->Facebook->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Twitter->Visible) { // Twitter ?>
        <td<?= $Page->Twitter->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_site_settings_Twitter" class="el_site_settings_Twitter">
<span<?= $Page->Twitter->viewAttributes() ?>>
<?= $Page->Twitter->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Instagram->Visible) { // Instagram ?>
        <td<?= $Page->Instagram->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_site_settings_Instagram" class="el_site_settings_Instagram">
<span<?= $Page->Instagram->viewAttributes() ?>>
<?= $Page->Instagram->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->_Title->Visible) { // Title ?>
        <td<?= $Page->_Title->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_site_settings__Title" class="el_site_settings__Title">
<span<?= $Page->_Title->viewAttributes() ?>>
<?= $Page->_Title->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Active->Visible) { // Active ?>
        <td<?= $Page->Active->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_site_settings_Active" class="el_site_settings_Active">
<span<?= $Page->Active->viewAttributes() ?>>
<?= $Page->Active->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Created_AT->Visible) { // Created_AT ?>
        <td<?= $Page->Created_AT->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_site_settings_Created_AT" class="el_site_settings_Created_AT">
<span<?= $Page->Created_AT->viewAttributes() ?>>
<?= $Page->Created_AT->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Created_BY->Visible) { // Created_BY ?>
        <td<?= $Page->Created_BY->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_site_settings_Created_BY" class="el_site_settings_Created_BY">
<span<?= $Page->Created_BY->viewAttributes() ?>>
<?= $Page->Created_BY->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->IP->Visible) { // IP ?>
        <td<?= $Page->IP->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_site_settings_IP" class="el_site_settings_IP">
<span<?= $Page->IP->viewAttributes() ?>>
<?= $Page->IP->getViewValue() ?></span>
</span>
</td>
<?php } ?>
    </tr>
<?php
    $Page->Recordset->moveNext();
}
$Page->Recordset->close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("DeleteBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
</div>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
