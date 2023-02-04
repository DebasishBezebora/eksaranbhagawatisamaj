<?php

namespace PHPMaker2022\eksbs;

// Page object
$UserPermissionEdit = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { user_permission: currentTable } });
var currentForm, currentPageID;
var fuser_permissionedit;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fuser_permissionedit = new ew.Form("fuser_permissionedit", "edit");
    currentPageID = ew.PAGE_ID = "edit";
    currentForm = fuser_permissionedit;

    // Add fields
    var fields = currentTable.fields;
    fuser_permissionedit.addFields([
        ["userlevelid", [fields.userlevelid.visible && fields.userlevelid.required ? ew.Validators.required(fields.userlevelid.caption) : null, ew.Validators.integer], fields.userlevelid.isInvalid],
        ["_tablename", [fields._tablename.visible && fields._tablename.required ? ew.Validators.required(fields._tablename.caption) : null], fields._tablename.isInvalid],
        ["_permission", [fields._permission.visible && fields._permission.required ? ew.Validators.required(fields._permission.caption) : null, ew.Validators.integer], fields._permission.isInvalid]
    ]);

    // Form_CustomValidate
    fuser_permissionedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fuser_permissionedit.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    loadjs.done("fuser_permissionedit");
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
<form name="fuser_permissionedit" id="fuser_permissionedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="user_permission">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->userlevelid->Visible) { // userlevelid ?>
    <div id="r_userlevelid"<?= $Page->userlevelid->rowAttributes() ?>>
        <label id="elh_user_permission_userlevelid" for="x_userlevelid" class="<?= $Page->LeftColumnClass ?>"><?= $Page->userlevelid->caption() ?><?= $Page->userlevelid->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->userlevelid->cellAttributes() ?>>
<input type="<?= $Page->userlevelid->getInputTextType() ?>" name="x_userlevelid" id="x_userlevelid" data-table="user_permission" data-field="x_userlevelid" value="<?= $Page->userlevelid->EditValue ?>" size="30" maxlength="11" placeholder="<?= HtmlEncode($Page->userlevelid->getPlaceHolder()) ?>"<?= $Page->userlevelid->editAttributes() ?> aria-describedby="x_userlevelid_help">
<?= $Page->userlevelid->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->userlevelid->getErrorMessage() ?></div>
<input type="hidden" data-table="user_permission" data-field="x_userlevelid" data-hidden="1" name="o_userlevelid" id="o_userlevelid" value="<?= HtmlEncode($Page->userlevelid->OldValue ?? $Page->userlevelid->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->_tablename->Visible) { // tablename ?>
    <div id="r__tablename"<?= $Page->_tablename->rowAttributes() ?>>
        <label id="elh_user_permission__tablename" for="x__tablename" class="<?= $Page->LeftColumnClass ?>"><?= $Page->_tablename->caption() ?><?= $Page->_tablename->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->_tablename->cellAttributes() ?>>
<input type="<?= $Page->_tablename->getInputTextType() ?>" name="x__tablename" id="x__tablename" data-table="user_permission" data-field="x__tablename" value="<?= $Page->_tablename->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->_tablename->getPlaceHolder()) ?>"<?= $Page->_tablename->editAttributes() ?> aria-describedby="x__tablename_help">
<?= $Page->_tablename->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->_tablename->getErrorMessage() ?></div>
<input type="hidden" data-table="user_permission" data-field="x__tablename" data-hidden="1" name="o__tablename" id="o__tablename" value="<?= HtmlEncode($Page->_tablename->OldValue ?? $Page->_tablename->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->_permission->Visible) { // permission ?>
    <div id="r__permission"<?= $Page->_permission->rowAttributes() ?>>
        <label id="elh_user_permission__permission" for="x__permission" class="<?= $Page->LeftColumnClass ?>"><?= $Page->_permission->caption() ?><?= $Page->_permission->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->_permission->cellAttributes() ?>>
<span id="el_user_permission__permission">
<input type="<?= $Page->_permission->getInputTextType() ?>" name="x__permission" id="x__permission" data-table="user_permission" data-field="x__permission" value="<?= $Page->_permission->EditValue ?>" size="30" maxlength="11" placeholder="<?= HtmlEncode($Page->_permission->getPlaceHolder()) ?>"<?= $Page->_permission->editAttributes() ?> aria-describedby="x__permission_help">
<?= $Page->_permission->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->_permission->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$Page->IsModal) { ?>
<div class="row"><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("SaveBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
    </div><!-- /buttons offset -->
</div><!-- /buttons .row -->
<?php } ?>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<script>
// Field event handlers
loadjs.ready("head", function() {
    ew.addEventHandlers("user_permission");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
