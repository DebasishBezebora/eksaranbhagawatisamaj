<?php

namespace PHPMaker2022\eksbs;

// Page object
$PhotoGalleriesView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { photo_galleries: currentTable } });
var currentForm, currentPageID;
var fphoto_galleriesview;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fphoto_galleriesview = new ew.Form("fphoto_galleriesview", "view");
    currentPageID = ew.PAGE_ID = "view";
    currentForm = fphoto_galleriesview;
    loadjs.done("fphoto_galleriesview");
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
<form name="fphoto_galleriesview" id="fphoto_galleriesview" class="ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="photo_galleries">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-bordered table-hover table-sm ew-view-table">
<?php if ($Page->ID->Visible) { // ID ?>
    <tr id="r_ID"<?= $Page->ID->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_photo_galleries_ID"><?= $Page->ID->caption() ?></span></td>
        <td data-name="ID"<?= $Page->ID->cellAttributes() ?>>
<span id="el_photo_galleries_ID">
<span<?= $Page->ID->viewAttributes() ?>>
<?= $Page->ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Album_Name->Visible) { // Album_Name ?>
    <tr id="r_Album_Name"<?= $Page->Album_Name->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_photo_galleries_Album_Name"><?= $Page->Album_Name->caption() ?></span></td>
        <td data-name="Album_Name"<?= $Page->Album_Name->cellAttributes() ?>>
<span id="el_photo_galleries_Album_Name">
<span<?= $Page->Album_Name->viewAttributes() ?>>
<?= $Page->Album_Name->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->_Title->Visible) { // Title ?>
    <tr id="r__Title"<?= $Page->_Title->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_photo_galleries__Title"><?= $Page->_Title->caption() ?></span></td>
        <td data-name="_Title"<?= $Page->_Title->cellAttributes() ?>>
<span id="el_photo_galleries__Title">
<span<?= $Page->_Title->viewAttributes() ?>>
<?= $Page->_Title->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Slug->Visible) { // Slug ?>
    <tr id="r_Slug"<?= $Page->Slug->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_photo_galleries_Slug"><?= $Page->Slug->caption() ?></span></td>
        <td data-name="Slug"<?= $Page->Slug->cellAttributes() ?>>
<span id="el_photo_galleries_Slug">
<span<?= $Page->Slug->viewAttributes() ?>>
<?= $Page->Slug->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Photos->Visible) { // Photos ?>
    <tr id="r_Photos"<?= $Page->Photos->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_photo_galleries_Photos"><?= $Page->Photos->caption() ?></span></td>
        <td data-name="Photos"<?= $Page->Photos->cellAttributes() ?>>
<span id="el_photo_galleries_Photos">
<span<?= $Page->Photos->viewAttributes() ?>>
<?= GetFileViewTag($Page->Photos, $Page->Photos->getViewValue(), false) ?>
</span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Active->Visible) { // Active ?>
    <tr id="r_Active"<?= $Page->Active->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_photo_galleries_Active"><?= $Page->Active->caption() ?></span></td>
        <td data-name="Active"<?= $Page->Active->cellAttributes() ?>>
<span id="el_photo_galleries_Active">
<span<?= $Page->Active->viewAttributes() ?>>
<?= $Page->Active->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Sort_Order->Visible) { // Sort_Order ?>
    <tr id="r_Sort_Order"<?= $Page->Sort_Order->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_photo_galleries_Sort_Order"><?= $Page->Sort_Order->caption() ?></span></td>
        <td data-name="Sort_Order"<?= $Page->Sort_Order->cellAttributes() ?>>
<span id="el_photo_galleries_Sort_Order">
<span<?= $Page->Sort_Order->viewAttributes() ?>>
<?= $Page->Sort_Order->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Description->Visible) { // Description ?>
    <tr id="r_Description"<?= $Page->Description->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_photo_galleries_Description"><?= $Page->Description->caption() ?></span></td>
        <td data-name="Description"<?= $Page->Description->cellAttributes() ?>>
<span id="el_photo_galleries_Description">
<span<?= $Page->Description->viewAttributes() ?>>
<?= $Page->Description->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Keywords->Visible) { // Keywords ?>
    <tr id="r_Keywords"<?= $Page->Keywords->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_photo_galleries_Keywords"><?= $Page->Keywords->caption() ?></span></td>
        <td data-name="Keywords"<?= $Page->Keywords->cellAttributes() ?>>
<span id="el_photo_galleries_Keywords">
<span<?= $Page->Keywords->viewAttributes() ?>>
<?= $Page->Keywords->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Created_AT->Visible) { // Created_AT ?>
    <tr id="r_Created_AT"<?= $Page->Created_AT->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_photo_galleries_Created_AT"><?= $Page->Created_AT->caption() ?></span></td>
        <td data-name="Created_AT"<?= $Page->Created_AT->cellAttributes() ?>>
<span id="el_photo_galleries_Created_AT">
<span<?= $Page->Created_AT->viewAttributes() ?>>
<?= $Page->Created_AT->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Created_BY->Visible) { // Created_BY ?>
    <tr id="r_Created_BY"<?= $Page->Created_BY->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_photo_galleries_Created_BY"><?= $Page->Created_BY->caption() ?></span></td>
        <td data-name="Created_BY"<?= $Page->Created_BY->cellAttributes() ?>>
<span id="el_photo_galleries_Created_BY">
<span<?= $Page->Created_BY->viewAttributes() ?>>
<?= $Page->Created_BY->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->IP->Visible) { // IP ?>
    <tr id="r_IP"<?= $Page->IP->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_photo_galleries_IP"><?= $Page->IP->caption() ?></span></td>
        <td data-name="IP"<?= $Page->IP->cellAttributes() ?>>
<span id="el_photo_galleries_IP">
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
