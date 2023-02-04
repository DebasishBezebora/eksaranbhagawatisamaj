<?php

namespace PHPMaker2022\eksbs;

// Page object
$LinksDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { links: currentTable } });
var currentForm, currentPageID;
var flinksdelete;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    flinksdelete = new ew.Form("flinksdelete", "delete");
    currentPageID = ew.PAGE_ID = "delete";
    currentForm = flinksdelete;
    loadjs.done("flinksdelete");
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
<form name="flinksdelete" id="flinksdelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="links">
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
        <th class="<?= $Page->ID->headerCellClass() ?>"><span id="elh_links_ID" class="links_ID"><?= $Page->ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Link_Name->Visible) { // Link_Name ?>
        <th class="<?= $Page->Link_Name->headerCellClass() ?>"><span id="elh_links_Link_Name" class="links_Link_Name"><?= $Page->Link_Name->caption() ?></span></th>
<?php } ?>
<?php if ($Page->URL_Slug->Visible) { // URL_Slug ?>
        <th class="<?= $Page->URL_Slug->headerCellClass() ?>"><span id="elh_links_URL_Slug" class="links_URL_Slug"><?= $Page->URL_Slug->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Video_1->Visible) { // Video_1 ?>
        <th class="<?= $Page->Video_1->headerCellClass() ?>"><span id="elh_links_Video_1" class="links_Video_1"><?= $Page->Video_1->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Video_2->Visible) { // Video_2 ?>
        <th class="<?= $Page->Video_2->headerCellClass() ?>"><span id="elh_links_Video_2" class="links_Video_2"><?= $Page->Video_2->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Video_3->Visible) { // Video_3 ?>
        <th class="<?= $Page->Video_3->headerCellClass() ?>"><span id="elh_links_Video_3" class="links_Video_3"><?= $Page->Video_3->caption() ?></span></th>
<?php } ?>
<?php if ($Page->_Title->Visible) { // Title ?>
        <th class="<?= $Page->_Title->headerCellClass() ?>"><span id="elh_links__Title" class="links__Title"><?= $Page->_Title->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Active->Visible) { // Active ?>
        <th class="<?= $Page->Active->headerCellClass() ?>"><span id="elh_links_Active" class="links_Active"><?= $Page->Active->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Created_AT->Visible) { // Created_AT ?>
        <th class="<?= $Page->Created_AT->headerCellClass() ?>"><span id="elh_links_Created_AT" class="links_Created_AT"><?= $Page->Created_AT->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Created_BY->Visible) { // Created_BY ?>
        <th class="<?= $Page->Created_BY->headerCellClass() ?>"><span id="elh_links_Created_BY" class="links_Created_BY"><?= $Page->Created_BY->caption() ?></span></th>
<?php } ?>
<?php if ($Page->IP->Visible) { // IP ?>
        <th class="<?= $Page->IP->headerCellClass() ?>"><span id="elh_links_IP" class="links_IP"><?= $Page->IP->caption() ?></span></th>
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
<span id="el<?= $Page->RowCount ?>_links_ID" class="el_links_ID">
<span<?= $Page->ID->viewAttributes() ?>>
<?= $Page->ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Link_Name->Visible) { // Link_Name ?>
        <td<?= $Page->Link_Name->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_links_Link_Name" class="el_links_Link_Name">
<span<?= $Page->Link_Name->viewAttributes() ?>>
<?= $Page->Link_Name->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->URL_Slug->Visible) { // URL_Slug ?>
        <td<?= $Page->URL_Slug->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_links_URL_Slug" class="el_links_URL_Slug">
<span<?= $Page->URL_Slug->viewAttributes() ?>>
<?= $Page->URL_Slug->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Video_1->Visible) { // Video_1 ?>
        <td<?= $Page->Video_1->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_links_Video_1" class="el_links_Video_1">
<span<?= $Page->Video_1->viewAttributes() ?>>
<?= $Page->Video_1->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Video_2->Visible) { // Video_2 ?>
        <td<?= $Page->Video_2->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_links_Video_2" class="el_links_Video_2">
<span<?= $Page->Video_2->viewAttributes() ?>>
<?= $Page->Video_2->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Video_3->Visible) { // Video_3 ?>
        <td<?= $Page->Video_3->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_links_Video_3" class="el_links_Video_3">
<span<?= $Page->Video_3->viewAttributes() ?>>
<?= $Page->Video_3->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->_Title->Visible) { // Title ?>
        <td<?= $Page->_Title->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_links__Title" class="el_links__Title">
<span<?= $Page->_Title->viewAttributes() ?>>
<?= $Page->_Title->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Active->Visible) { // Active ?>
        <td<?= $Page->Active->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_links_Active" class="el_links_Active">
<span<?= $Page->Active->viewAttributes() ?>>
<?= $Page->Active->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Created_AT->Visible) { // Created_AT ?>
        <td<?= $Page->Created_AT->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_links_Created_AT" class="el_links_Created_AT">
<span<?= $Page->Created_AT->viewAttributes() ?>>
<?= $Page->Created_AT->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Created_BY->Visible) { // Created_BY ?>
        <td<?= $Page->Created_BY->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_links_Created_BY" class="el_links_Created_BY">
<span<?= $Page->Created_BY->viewAttributes() ?>>
<?= $Page->Created_BY->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->IP->Visible) { // IP ?>
        <td<?= $Page->IP->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_links_IP" class="el_links_IP">
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
