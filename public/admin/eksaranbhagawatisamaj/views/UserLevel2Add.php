<?php

namespace PHPMaker2022\eksbs;

// Page object
$UserLevel2Add = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { user_level2: currentTable } });
var currentForm, currentPageID;
var fuser_level2add;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fuser_level2add = new ew.Form("fuser_level2add", "add");
    currentPageID = ew.PAGE_ID = "add";
    currentForm = fuser_level2add;

    // Add fields
    var fields = currentTable.fields;
    fuser_level2add.addFields([
        ["userlevelid", [fields.userlevelid.visible && fields.userlevelid.required ? ew.Validators.required(fields.userlevelid.caption) : null, ew.Validators.userLevelId, ew.Validators.integer], fields.userlevelid.isInvalid],
        ["userlevelname", [fields.userlevelname.visible && fields.userlevelname.required ? ew.Validators.required(fields.userlevelname.caption) : null, ew.Validators.userLevelName('userlevelid')], fields.userlevelname.isInvalid]
    ]);

    // Form_CustomValidate
    fuser_level2add.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fuser_level2add.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    loadjs.done("fuser_level2add");
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
<form name="fuser_level2add" id="fuser_level2add" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="user_level2">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->userlevelid->Visible) { // userlevelid ?>
    <div id="r_userlevelid"<?= $Page->userlevelid->rowAttributes() ?>>
        <label id="elh_user_level2_userlevelid" for="x_userlevelid" class="<?= $Page->LeftColumnClass ?>"><?= $Page->userlevelid->caption() ?><?= $Page->userlevelid->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->userlevelid->cellAttributes() ?>>
<span id="el_user_level2_userlevelid">
<input type="<?= $Page->userlevelid->getInputTextType() ?>" name="x_userlevelid" id="x_userlevelid" data-table="user_level2" data-field="x_userlevelid" value="<?= $Page->userlevelid->EditValue ?>" size="30" maxlength="11" placeholder="<?= HtmlEncode($Page->userlevelid->getPlaceHolder()) ?>"<?= $Page->userlevelid->editAttributes() ?> aria-describedby="x_userlevelid_help">
<?= $Page->userlevelid->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->userlevelid->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->userlevelname->Visible) { // userlevelname ?>
    <div id="r_userlevelname"<?= $Page->userlevelname->rowAttributes() ?>>
        <label id="elh_user_level2_userlevelname" for="x_userlevelname" class="<?= $Page->LeftColumnClass ?>"><?= $Page->userlevelname->caption() ?><?= $Page->userlevelname->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->userlevelname->cellAttributes() ?>>
<span id="el_user_level2_userlevelname">
<input type="<?= $Page->userlevelname->getInputTextType() ?>" name="x_userlevelname" id="x_userlevelname" data-table="user_level2" data-field="x_userlevelname" value="<?= $Page->userlevelname->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->userlevelname->getPlaceHolder()) ?>"<?= $Page->userlevelname->editAttributes() ?> aria-describedby="x_userlevelname_help">
<?= $Page->userlevelname->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->userlevelname->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
    <!-- row for permission values -->
    <div id="rp_permission" class="row">
        <label id="elh_permission" class="<?= $Page->LeftColumnClass ?>"><?= HtmlTitle($Language->phrase("Permission")) ?></label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div class="form-check">
                <input type="checkbox" class="form-check-input" name="x__AllowAdd" id="Add" value="<?= Config("ALLOW_ADD") ?>"><label class="form-check-label" for="Add"><?= $Language->phrase("PermissionAdd") ?></label>
            </div>
            <div class="form-check">
                <input type="checkbox" class="form-check-input" name="x__AllowDelete" id="Delete" value="<?= Config("ALLOW_DELETE") ?>"><label class="form-check-label" for="Delete"><?= $Language->phrase("PermissionDelete") ?></label>
            </div>
            <div class="form-check">
                <input type="checkbox" class="form-check-input" name="x__AllowEdit" id="Edit" value="<?= Config("ALLOW_EDIT") ?>"><label class="form-check-label" for="Edit"><?= $Language->phrase("PermissionEdit") ?></label>
            </div>
            <div class="form-check">
                <input type="checkbox" class="form-check-input" name="x__AllowList" id="List" value="<?= Config("ALLOW_LIST") ?>"><label class="form-check-label" for="List"><?= $Language->phrase("PermissionList") ?></label>
            </div>
            <div class="form-check">
                <input type="checkbox" class="form-check-input" name="x__AllowLookup" id="Lookup" value="<?= Config("ALLOW_LOOKUP") ?>"><label class="form-check-label" for="Lookup"><?= $Language->phrase("PermissionLookup") ?></label>
            </div>
            <div class="form-check">
                <input type="checkbox" class="form-check-input" name="x__AllowView" id="View" value="<?= Config("ALLOW_VIEW") ?>"><label class="form-check-label" for="View"><?= $Language->phrase("PermissionView") ?></label>
            </div>
            <div class="form-check">
                <input type="checkbox" class="form-check-input" name="x__AllowSearch" id="Search" value="<?= Config("ALLOW_SEARCH") ?>"><label class="form-check-label" for="Search"><?= $Language->phrase("PermissionSearch") ?></label>
            </div>
            <div class="form-check">
                <input type="checkbox" class="form-check-input" name="x__AllowImport" id="Import" value="<?= Config("ALLOW_IMPORT") ?>"><label class="form-check-label" for="Import"><?= $Language->phrase("PermissionImport") ?></label>
            </div>
<?php if (IsSysAdmin()) { ?>
            <div class="form-check">
                <input type="checkbox" class="form-check-input" name="x__AllowAdmin" id="Admin" value="<?= Config("ALLOW_ADMIN") ?>"><label class="form-check-label" for="Admin"><?= $Language->phrase("PermissionAdmin") ?></label>
            </div>
<?php } ?>
        </div>
    </div>
</div><!-- /page* -->
<?php if (!$Page->IsModal) { ?>
<div class="row"><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("AddBtn") ?></button>
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
    ew.addEventHandlers("user_level2");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
