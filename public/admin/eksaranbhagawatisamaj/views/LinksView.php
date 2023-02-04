<?php

namespace PHPMaker2022\eksbs;

// Page object
$LinksView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { links: currentTable } });
var currentForm, currentPageID;
var flinksview;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    flinksview = new ew.Form("flinksview", "view");
    currentPageID = ew.PAGE_ID = "view";
    currentForm = flinksview;
    loadjs.done("flinksview");
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
<form name="flinksview" id="flinksview" class="ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="links">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-bordered table-hover table-sm ew-view-table">
<?php if ($Page->ID->Visible) { // ID ?>
    <tr id="r_ID"<?= $Page->ID->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_links_ID"><?= $Page->ID->caption() ?></span></td>
        <td data-name="ID"<?= $Page->ID->cellAttributes() ?>>
<span id="el_links_ID">
<span<?= $Page->ID->viewAttributes() ?>>
<?= $Page->ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Link_Name->Visible) { // Link_Name ?>
    <tr id="r_Link_Name"<?= $Page->Link_Name->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_links_Link_Name"><?= $Page->Link_Name->caption() ?></span></td>
        <td data-name="Link_Name"<?= $Page->Link_Name->cellAttributes() ?>>
<span id="el_links_Link_Name">
<span<?= $Page->Link_Name->viewAttributes() ?>>
<?= $Page->Link_Name->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->URL_Slug->Visible) { // URL_Slug ?>
    <tr id="r_URL_Slug"<?= $Page->URL_Slug->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_links_URL_Slug"><?= $Page->URL_Slug->caption() ?></span></td>
        <td data-name="URL_Slug"<?= $Page->URL_Slug->cellAttributes() ?>>
<span id="el_links_URL_Slug">
<span<?= $Page->URL_Slug->viewAttributes() ?>>
<?= $Page->URL_Slug->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Link_Content->Visible) { // Link_Content ?>
    <tr id="r_Link_Content"<?= $Page->Link_Content->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_links_Link_Content"><?= $Page->Link_Content->caption() ?></span></td>
        <td data-name="Link_Content"<?= $Page->Link_Content->cellAttributes() ?>>
<span id="el_links_Link_Content">
<span<?= $Page->Link_Content->viewAttributes() ?>>
<?= $Page->Link_Content->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Photos->Visible) { // Photos ?>
    <tr id="r_Photos"<?= $Page->Photos->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_links_Photos"><?= $Page->Photos->caption() ?></span></td>
        <td data-name="Photos"<?= $Page->Photos->cellAttributes() ?>>
<span id="el_links_Photos">
<span<?= $Page->Photos->viewAttributes() ?>>
<?= GetFileViewTag($Page->Photos, $Page->Photos->getViewValue(), false) ?>
</span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Video_1->Visible) { // Video_1 ?>
    <tr id="r_Video_1"<?= $Page->Video_1->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_links_Video_1"><?= $Page->Video_1->caption() ?></span></td>
        <td data-name="Video_1"<?= $Page->Video_1->cellAttributes() ?>>
<span id="el_links_Video_1">
<span<?= $Page->Video_1->viewAttributes() ?>>
<?= $Page->Video_1->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Video_2->Visible) { // Video_2 ?>
    <tr id="r_Video_2"<?= $Page->Video_2->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_links_Video_2"><?= $Page->Video_2->caption() ?></span></td>
        <td data-name="Video_2"<?= $Page->Video_2->cellAttributes() ?>>
<span id="el_links_Video_2">
<span<?= $Page->Video_2->viewAttributes() ?>>
<?= $Page->Video_2->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Video_3->Visible) { // Video_3 ?>
    <tr id="r_Video_3"<?= $Page->Video_3->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_links_Video_3"><?= $Page->Video_3->caption() ?></span></td>
        <td data-name="Video_3"<?= $Page->Video_3->cellAttributes() ?>>
<span id="el_links_Video_3">
<span<?= $Page->Video_3->viewAttributes() ?>>
<?= $Page->Video_3->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->_Title->Visible) { // Title ?>
    <tr id="r__Title"<?= $Page->_Title->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_links__Title"><?= $Page->_Title->caption() ?></span></td>
        <td data-name="_Title"<?= $Page->_Title->cellAttributes() ?>>
<span id="el_links__Title">
<span<?= $Page->_Title->viewAttributes() ?>>
<?= $Page->_Title->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Description->Visible) { // Description ?>
    <tr id="r_Description"<?= $Page->Description->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_links_Description"><?= $Page->Description->caption() ?></span></td>
        <td data-name="Description"<?= $Page->Description->cellAttributes() ?>>
<span id="el_links_Description">
<span<?= $Page->Description->viewAttributes() ?>>
<?= $Page->Description->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Keywords->Visible) { // Keywords ?>
    <tr id="r_Keywords"<?= $Page->Keywords->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_links_Keywords"><?= $Page->Keywords->caption() ?></span></td>
        <td data-name="Keywords"<?= $Page->Keywords->cellAttributes() ?>>
<span id="el_links_Keywords">
<span<?= $Page->Keywords->viewAttributes() ?>>
<?= $Page->Keywords->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Active->Visible) { // Active ?>
    <tr id="r_Active"<?= $Page->Active->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_links_Active"><?= $Page->Active->caption() ?></span></td>
        <td data-name="Active"<?= $Page->Active->cellAttributes() ?>>
<span id="el_links_Active">
<span<?= $Page->Active->viewAttributes() ?>>
<?= $Page->Active->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Created_AT->Visible) { // Created_AT ?>
    <tr id="r_Created_AT"<?= $Page->Created_AT->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_links_Created_AT"><?= $Page->Created_AT->caption() ?></span></td>
        <td data-name="Created_AT"<?= $Page->Created_AT->cellAttributes() ?>>
<span id="el_links_Created_AT">
<span<?= $Page->Created_AT->viewAttributes() ?>>
<?= $Page->Created_AT->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Created_BY->Visible) { // Created_BY ?>
    <tr id="r_Created_BY"<?= $Page->Created_BY->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_links_Created_BY"><?= $Page->Created_BY->caption() ?></span></td>
        <td data-name="Created_BY"<?= $Page->Created_BY->cellAttributes() ?>>
<span id="el_links_Created_BY">
<span<?= $Page->Created_BY->viewAttributes() ?>>
<?= $Page->Created_BY->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->IP->Visible) { // IP ?>
    <tr id="r_IP"<?= $Page->IP->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_links_IP"><?= $Page->IP->caption() ?></span></td>
        <td data-name="IP"<?= $Page->IP->cellAttributes() ?>>
<span id="el_links_IP">
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
