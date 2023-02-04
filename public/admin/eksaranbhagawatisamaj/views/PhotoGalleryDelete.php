<?php

namespace PHPMaker2022\eksbs;

// Page object
$PhotoGalleryDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { photo_gallery: currentTable } });
var currentForm, currentPageID;
var fphoto_gallerydelete;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fphoto_gallerydelete = new ew.Form("fphoto_gallerydelete", "delete");
    currentPageID = ew.PAGE_ID = "delete";
    currentForm = fphoto_gallerydelete;
    loadjs.done("fphoto_gallerydelete");
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
<form name="fphoto_gallerydelete" id="fphoto_gallerydelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="photo_gallery">
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
        <th class="<?= $Page->ID->headerCellClass() ?>"><span id="elh_photo_gallery_ID" class="photo_gallery_ID"><?= $Page->ID->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Album_Name->Visible) { // Album_Name ?>
        <th class="<?= $Page->Album_Name->headerCellClass() ?>"><span id="elh_photo_gallery_Album_Name" class="photo_gallery_Album_Name"><?= $Page->Album_Name->caption() ?></span></th>
<?php } ?>
<?php if ($Page->_Title->Visible) { // Title ?>
        <th class="<?= $Page->_Title->headerCellClass() ?>"><span id="elh_photo_gallery__Title" class="photo_gallery__Title"><?= $Page->_Title->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Slug->Visible) { // Slug ?>
        <th class="<?= $Page->Slug->headerCellClass() ?>"><span id="elh_photo_gallery_Slug" class="photo_gallery_Slug"><?= $Page->Slug->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Active->Visible) { // Active ?>
        <th class="<?= $Page->Active->headerCellClass() ?>"><span id="elh_photo_gallery_Active" class="photo_gallery_Active"><?= $Page->Active->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Sort_Order->Visible) { // Sort_Order ?>
        <th class="<?= $Page->Sort_Order->headerCellClass() ?>"><span id="elh_photo_gallery_Sort_Order" class="photo_gallery_Sort_Order"><?= $Page->Sort_Order->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Created_AT->Visible) { // Created_AT ?>
        <th class="<?= $Page->Created_AT->headerCellClass() ?>"><span id="elh_photo_gallery_Created_AT" class="photo_gallery_Created_AT"><?= $Page->Created_AT->caption() ?></span></th>
<?php } ?>
<?php if ($Page->Created_BY->Visible) { // Created_BY ?>
        <th class="<?= $Page->Created_BY->headerCellClass() ?>"><span id="elh_photo_gallery_Created_BY" class="photo_gallery_Created_BY"><?= $Page->Created_BY->caption() ?></span></th>
<?php } ?>
<?php if ($Page->IP->Visible) { // IP ?>
        <th class="<?= $Page->IP->headerCellClass() ?>"><span id="elh_photo_gallery_IP" class="photo_gallery_IP"><?= $Page->IP->caption() ?></span></th>
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
<span id="el<?= $Page->RowCount ?>_photo_gallery_ID" class="el_photo_gallery_ID">
<span<?= $Page->ID->viewAttributes() ?>>
<?= $Page->ID->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Album_Name->Visible) { // Album_Name ?>
        <td<?= $Page->Album_Name->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_photo_gallery_Album_Name" class="el_photo_gallery_Album_Name">
<span<?= $Page->Album_Name->viewAttributes() ?>>
<?= $Page->Album_Name->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->_Title->Visible) { // Title ?>
        <td<?= $Page->_Title->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_photo_gallery__Title" class="el_photo_gallery__Title">
<span<?= $Page->_Title->viewAttributes() ?>>
<?= $Page->_Title->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Slug->Visible) { // Slug ?>
        <td<?= $Page->Slug->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_photo_gallery_Slug" class="el_photo_gallery_Slug">
<span<?= $Page->Slug->viewAttributes() ?>>
<?= $Page->Slug->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Active->Visible) { // Active ?>
        <td<?= $Page->Active->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_photo_gallery_Active" class="el_photo_gallery_Active">
<span<?= $Page->Active->viewAttributes() ?>>
<div class="form-check d-inline-block">
    <input type="checkbox" id="x_Active_<?= $Page->RowCount ?>" class="form-check-input" value="<?= $Page->Active->getViewValue() ?>" disabled<?php if (ConvertToBool($Page->Active->CurrentValue)) { ?> checked<?php } ?>>
    <label class="form-check-label" for="x_Active_<?= $Page->RowCount ?>"></label>
</div></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Sort_Order->Visible) { // Sort_Order ?>
        <td<?= $Page->Sort_Order->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_photo_gallery_Sort_Order" class="el_photo_gallery_Sort_Order">
<span<?= $Page->Sort_Order->viewAttributes() ?>>
<?= $Page->Sort_Order->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Created_AT->Visible) { // Created_AT ?>
        <td<?= $Page->Created_AT->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_photo_gallery_Created_AT" class="el_photo_gallery_Created_AT">
<span<?= $Page->Created_AT->viewAttributes() ?>>
<?= $Page->Created_AT->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->Created_BY->Visible) { // Created_BY ?>
        <td<?= $Page->Created_BY->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_photo_gallery_Created_BY" class="el_photo_gallery_Created_BY">
<span<?= $Page->Created_BY->viewAttributes() ?>>
<?= $Page->Created_BY->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->IP->Visible) { // IP ?>
        <td<?= $Page->IP->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_photo_gallery_IP" class="el_photo_gallery_IP">
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
