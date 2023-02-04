<?php

namespace PHPMaker2022\eksbs;

// Page object
$EventCategoryView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { event_category: currentTable } });
var currentForm, currentPageID;
var fevent_categoryview;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fevent_categoryview = new ew.Form("fevent_categoryview", "view");
    currentPageID = ew.PAGE_ID = "view";
    currentForm = fevent_categoryview;
    loadjs.done("fevent_categoryview");
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
<form name="fevent_categoryview" id="fevent_categoryview" class="ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="event_category">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-bordered table-hover table-sm ew-view-table">
<?php if ($Page->ID->Visible) { // ID ?>
    <tr id="r_ID"<?= $Page->ID->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_event_category_ID"><?= $Page->ID->caption() ?></span></td>
        <td data-name="ID"<?= $Page->ID->cellAttributes() ?>>
<span id="el_event_category_ID">
<span<?= $Page->ID->viewAttributes() ?>>
<?= $Page->ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Category->Visible) { // Category ?>
    <tr id="r_Category"<?= $Page->Category->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_event_category_Category"><?= $Page->Category->caption() ?></span></td>
        <td data-name="Category"<?= $Page->Category->cellAttributes() ?>>
<span id="el_event_category_Category">
<span<?= $Page->Category->viewAttributes() ?>>
<?= $Page->Category->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Active->Visible) { // Active ?>
    <tr id="r_Active"<?= $Page->Active->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_event_category_Active"><?= $Page->Active->caption() ?></span></td>
        <td data-name="Active"<?= $Page->Active->cellAttributes() ?>>
<span id="el_event_category_Active">
<span<?= $Page->Active->viewAttributes() ?>>
<?= $Page->Active->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Created_BY->Visible) { // Created_BY ?>
    <tr id="r_Created_BY"<?= $Page->Created_BY->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_event_category_Created_BY"><?= $Page->Created_BY->caption() ?></span></td>
        <td data-name="Created_BY"<?= $Page->Created_BY->cellAttributes() ?>>
<span id="el_event_category_Created_BY">
<span<?= $Page->Created_BY->viewAttributes() ?>>
<?= $Page->Created_BY->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Created_AT->Visible) { // Created_AT ?>
    <tr id="r_Created_AT"<?= $Page->Created_AT->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_event_category_Created_AT"><?= $Page->Created_AT->caption() ?></span></td>
        <td data-name="Created_AT"<?= $Page->Created_AT->cellAttributes() ?>>
<span id="el_event_category_Created_AT">
<span<?= $Page->Created_AT->viewAttributes() ?>>
<?= $Page->Created_AT->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->IP->Visible) { // IP ?>
    <tr id="r_IP"<?= $Page->IP->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_event_category_IP"><?= $Page->IP->caption() ?></span></td>
        <td data-name="IP"<?= $Page->IP->cellAttributes() ?>>
<span id="el_event_category_IP">
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
