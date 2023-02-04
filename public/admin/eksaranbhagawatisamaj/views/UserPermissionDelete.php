<?php

namespace PHPMaker2022\eksbs;

// Page object
$UserPermissionDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { user_permission: currentTable } });
var currentForm, currentPageID;
var fuser_permissiondelete;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fuser_permissiondelete = new ew.Form("fuser_permissiondelete", "delete");
    currentPageID = ew.PAGE_ID = "delete";
    currentForm = fuser_permissiondelete;
    loadjs.done("fuser_permissiondelete");
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
<form name="fuser_permissiondelete" id="fuser_permissiondelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="user_permission">
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
<?php if ($Page->userlevelid->Visible) { // userlevelid ?>
        <th class="<?= $Page->userlevelid->headerCellClass() ?>"><span id="elh_user_permission_userlevelid" class="user_permission_userlevelid"><?= $Page->userlevelid->caption() ?></span></th>
<?php } ?>
<?php if ($Page->_tablename->Visible) { // tablename ?>
        <th class="<?= $Page->_tablename->headerCellClass() ?>"><span id="elh_user_permission__tablename" class="user_permission__tablename"><?= $Page->_tablename->caption() ?></span></th>
<?php } ?>
<?php if ($Page->_permission->Visible) { // permission ?>
        <th class="<?= $Page->_permission->headerCellClass() ?>"><span id="elh_user_permission__permission" class="user_permission__permission"><?= $Page->_permission->caption() ?></span></th>
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
<?php if ($Page->userlevelid->Visible) { // userlevelid ?>
        <td<?= $Page->userlevelid->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_user_permission_userlevelid" class="el_user_permission_userlevelid">
<span<?= $Page->userlevelid->viewAttributes() ?>>
<?= $Page->userlevelid->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->_tablename->Visible) { // tablename ?>
        <td<?= $Page->_tablename->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_user_permission__tablename" class="el_user_permission__tablename">
<span<?= $Page->_tablename->viewAttributes() ?>>
<?= $Page->_tablename->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->_permission->Visible) { // permission ?>
        <td<?= $Page->_permission->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_user_permission__permission" class="el_user_permission__permission">
<span<?= $Page->_permission->viewAttributes() ?>>
<?= $Page->_permission->getViewValue() ?></span>
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
