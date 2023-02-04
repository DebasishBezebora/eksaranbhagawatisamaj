<?php

namespace PHPMaker2022\eksbs;

// Page object
$EventCategoryDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { event_category: currentTable } });
var currentForm, currentPageID;
var fevent_categorydelete;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fevent_categorydelete = new ew.Form("fevent_categorydelete", "delete");
    currentPageID = ew.PAGE_ID = "delete";
    currentForm = fevent_categorydelete;
    loadjs.done("fevent_categorydelete");
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
<form name="fevent_categorydelete" id="fevent_categorydelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="event_category">
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
        <th class="<?= $Page->ID->headerCellClass() ?>"><span id="elh_event_category_ID" class="event_category_ID"><?= $Page->ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Category->Visible) { // Category ?>
        <th class="<?= $Page->Category->headerCellClass() ?>"><span id="elh_event_category_Category" class="event_category_Category"><?= $Page->Category->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Active->Visible) { // Active ?>
        <th class="<?= $Page->Active->headerCellClass() ?>"><span id="elh_event_category_Active" class="event_category_Active"><?= $Page->Active->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Created_BY->Visible) { // Created_BY ?>
        <th class="<?= $Page->Created_BY->headerCellClass() ?>"><span id="elh_event_category_Created_BY" class="event_category_Created_BY"><?= $Page->Created_BY->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Created_AT->Visible) { // Created_AT ?>
        <th class="<?= $Page->Created_AT->headerCellClass() ?>"><span id="elh_event_category_Created_AT" class="event_category_Created_AT"><?= $Page->Created_AT->caption() ?></span></th>
<?php } ?>
<?php if ($Page->IP->Visible) { // IP ?>
        <th class="<?= $Page->IP->headerCellClass() ?>"><span id="elh_event_category_IP" class="event_category_IP"><?= $Page->IP->caption() ?></span></th>
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
<span id="el<?= $Page->RowCount ?>_event_category_ID" class="el_event_category_ID">
<span<?= $Page->ID->viewAttributes() ?>>
<?= $Page->ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Category->Visible) { // Category ?>
        <td<?= $Page->Category->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_event_category_Category" class="el_event_category_Category">
<span<?= $Page->Category->viewAttributes() ?>>
<?= $Page->Category->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Active->Visible) { // Active ?>
        <td<?= $Page->Active->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_event_category_Active" class="el_event_category_Active">
<span<?= $Page->Active->viewAttributes() ?>>
<?= $Page->Active->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Created_BY->Visible) { // Created_BY ?>
        <td<?= $Page->Created_BY->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_event_category_Created_BY" class="el_event_category_Created_BY">
<span<?= $Page->Created_BY->viewAttributes() ?>>
<?= $Page->Created_BY->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Created_AT->Visible) { // Created_AT ?>
        <td<?= $Page->Created_AT->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_event_category_Created_AT" class="el_event_category_Created_AT">
<span<?= $Page->Created_AT->viewAttributes() ?>>
<?= $Page->Created_AT->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->IP->Visible) { // IP ?>
        <td<?= $Page->IP->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_event_category_IP" class="el_event_category_IP">
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
