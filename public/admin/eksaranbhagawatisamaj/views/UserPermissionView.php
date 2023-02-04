<?php

namespace PHPMaker2022\eksbs;

// Page object
$UserPermissionView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { user_permission: currentTable } });
var currentForm, currentPageID;
var fuser_permissionview;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fuser_permissionview = new ew.Form("fuser_permissionview", "view");
    currentPageID = ew.PAGE_ID = "view";
    currentForm = fuser_permissionview;
    loadjs.done("fuser_permissionview");
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
<form name="fuser_permissionview" id="fuser_permissionview" class="ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="user_permission">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-bordered table-hover table-sm ew-view-table">
<?php if ($Page->userlevelid->Visible) { // userlevelid ?>
    <tr id="r_userlevelid"<?= $Page->userlevelid->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_user_permission_userlevelid"><?= $Page->userlevelid->caption() ?></span></td>
        <td data-name="userlevelid"<?= $Page->userlevelid->cellAttributes() ?>>
<span id="el_user_permission_userlevelid">
<span<?= $Page->userlevelid->viewAttributes() ?>>
<?= $Page->userlevelid->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->_tablename->Visible) { // tablename ?>
    <tr id="r__tablename"<?= $Page->_tablename->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_user_permission__tablename"><?= $Page->_tablename->caption() ?></span></td>
        <td data-name="_tablename"<?= $Page->_tablename->cellAttributes() ?>>
<span id="el_user_permission__tablename">
<span<?= $Page->_tablename->viewAttributes() ?>>
<?= $Page->_tablename->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->_permission->Visible) { // permission ?>
    <tr id="r__permission"<?= $Page->_permission->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_user_permission__permission"><?= $Page->_permission->caption() ?></span></td>
        <td data-name="_permission"<?= $Page->_permission->cellAttributes() ?>>
<span id="el_user_permission__permission">
<span<?= $Page->_permission->viewAttributes() ?>>
<?= $Page->_permission->getViewValue() ?></span>
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
