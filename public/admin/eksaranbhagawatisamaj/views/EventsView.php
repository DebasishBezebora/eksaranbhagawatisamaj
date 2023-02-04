<?php

namespace PHPMaker2022\eksbs;

// Page object
$EventsView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { events: currentTable } });
var currentForm, currentPageID;
var feventsview;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    feventsview = new ew.Form("feventsview", "view");
    currentPageID = ew.PAGE_ID = "view";
    currentForm = feventsview;
    loadjs.done("feventsview");
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
<form name="feventsview" id="feventsview" class="ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="events">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-bordered table-hover table-sm ew-view-table">
<?php if ($Page->ID->Visible) { // ID ?>
    <tr id="r_ID"<?= $Page->ID->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_events_ID"><?= $Page->ID->caption() ?></span></td>
        <td data-name="ID"<?= $Page->ID->cellAttributes() ?>>
<span id="el_events_ID">
<span<?= $Page->ID->viewAttributes() ?>>
<?= $Page->ID->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Event_Date->Visible) { // Event_Date ?>
    <tr id="r_Event_Date"<?= $Page->Event_Date->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_events_Event_Date"><?= $Page->Event_Date->caption() ?></span></td>
        <td data-name="Event_Date"<?= $Page->Event_Date->cellAttributes() ?>>
<span id="el_events_Event_Date">
<span<?= $Page->Event_Date->viewAttributes() ?>>
<?= $Page->Event_Date->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Event_Category->Visible) { // Event_Category ?>
    <tr id="r_Event_Category"<?= $Page->Event_Category->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_events_Event_Category"><?= $Page->Event_Category->caption() ?></span></td>
        <td data-name="Event_Category"<?= $Page->Event_Category->cellAttributes() ?>>
<span id="el_events_Event_Category">
<span<?= $Page->Event_Category->viewAttributes() ?>>
<?= $Page->Event_Category->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->_Content->Visible) { // Content ?>
    <tr id="r__Content"<?= $Page->_Content->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_events__Content"><?= $Page->_Content->caption() ?></span></td>
        <td data-name="_Content"<?= $Page->_Content->cellAttributes() ?>>
<span id="el_events__Content">
<span<?= $Page->_Content->viewAttributes() ?>>
<?= $Page->_Content->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Photos->Visible) { // Photos ?>
    <tr id="r_Photos"<?= $Page->Photos->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_events_Photos"><?= $Page->Photos->caption() ?></span></td>
        <td data-name="Photos"<?= $Page->Photos->cellAttributes() ?>>
<span id="el_events_Photos">
<span<?= $Page->Photos->viewAttributes() ?>>
<?= GetFileViewTag($Page->Photos, $Page->Photos->getViewValue(), false) ?>
</span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Video_1->Visible) { // Video_1 ?>
    <tr id="r_Video_1"<?= $Page->Video_1->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_events_Video_1"><?= $Page->Video_1->caption() ?></span></td>
        <td data-name="Video_1"<?= $Page->Video_1->cellAttributes() ?>>
<span id="el_events_Video_1">
<span<?= $Page->Video_1->viewAttributes() ?>>
<?= $Page->Video_1->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Video_2->Visible) { // Video_2 ?>
    <tr id="r_Video_2"<?= $Page->Video_2->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_events_Video_2"><?= $Page->Video_2->caption() ?></span></td>
        <td data-name="Video_2"<?= $Page->Video_2->cellAttributes() ?>>
<span id="el_events_Video_2">
<span<?= $Page->Video_2->viewAttributes() ?>>
<?= $Page->Video_2->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Video_3->Visible) { // Video_3 ?>
    <tr id="r_Video_3"<?= $Page->Video_3->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_events_Video_3"><?= $Page->Video_3->caption() ?></span></td>
        <td data-name="Video_3"<?= $Page->Video_3->cellAttributes() ?>>
<span id="el_events_Video_3">
<span<?= $Page->Video_3->viewAttributes() ?>>
<?= $Page->Video_3->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->_Title->Visible) { // Title ?>
    <tr id="r__Title"<?= $Page->_Title->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_events__Title"><?= $Page->_Title->caption() ?></span></td>
        <td data-name="_Title"<?= $Page->_Title->cellAttributes() ?>>
<span id="el_events__Title">
<span<?= $Page->_Title->viewAttributes() ?>>
<?= $Page->_Title->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Description->Visible) { // Description ?>
    <tr id="r_Description"<?= $Page->Description->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_events_Description"><?= $Page->Description->caption() ?></span></td>
        <td data-name="Description"<?= $Page->Description->cellAttributes() ?>>
<span id="el_events_Description">
<span<?= $Page->Description->viewAttributes() ?>>
<?= $Page->Description->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Keywords->Visible) { // Keywords ?>
    <tr id="r_Keywords"<?= $Page->Keywords->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_events_Keywords"><?= $Page->Keywords->caption() ?></span></td>
        <td data-name="Keywords"<?= $Page->Keywords->cellAttributes() ?>>
<span id="el_events_Keywords">
<span<?= $Page->Keywords->viewAttributes() ?>>
<?= $Page->Keywords->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Active->Visible) { // Active ?>
    <tr id="r_Active"<?= $Page->Active->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_events_Active"><?= $Page->Active->caption() ?></span></td>
        <td data-name="Active"<?= $Page->Active->cellAttributes() ?>>
<span id="el_events_Active">
<span<?= $Page->Active->viewAttributes() ?>>
<?= $Page->Active->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Sort_Order->Visible) { // Sort_Order ?>
    <tr id="r_Sort_Order"<?= $Page->Sort_Order->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_events_Sort_Order"><?= $Page->Sort_Order->caption() ?></span></td>
        <td data-name="Sort_Order"<?= $Page->Sort_Order->cellAttributes() ?>>
<span id="el_events_Sort_Order">
<span<?= $Page->Sort_Order->viewAttributes() ?>>
<?= $Page->Sort_Order->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Created_BY->Visible) { // Created_BY ?>
    <tr id="r_Created_BY"<?= $Page->Created_BY->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_events_Created_BY"><?= $Page->Created_BY->caption() ?></span></td>
        <td data-name="Created_BY"<?= $Page->Created_BY->cellAttributes() ?>>
<span id="el_events_Created_BY">
<span<?= $Page->Created_BY->viewAttributes() ?>>
<?= $Page->Created_BY->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->Created_AT->Visible) { // Created_AT ?>
    <tr id="r_Created_AT"<?= $Page->Created_AT->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_events_Created_AT"><?= $Page->Created_AT->caption() ?></span></td>
        <td data-name="Created_AT"<?= $Page->Created_AT->cellAttributes() ?>>
<span id="el_events_Created_AT">
<span<?= $Page->Created_AT->viewAttributes() ?>>
<?= $Page->Created_AT->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->IP->Visible) { // IP ?>
    <tr id="r_IP"<?= $Page->IP->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_events_IP"><?= $Page->IP->caption() ?></span></td>
        <td data-name="IP"<?= $Page->IP->cellAttributes() ?>>
<span id="el_events_IP">
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
