<?php

namespace PHPMaker2022\eksbs;

// Page object
$PhotoGalleriesEdit = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { photo_galleries: currentTable } });
var currentForm, currentPageID;
var fphoto_galleriesedit;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fphoto_galleriesedit = new ew.Form("fphoto_galleriesedit", "edit");
    currentPageID = ew.PAGE_ID = "edit";
    currentForm = fphoto_galleriesedit;

    // Add fields
    var fields = currentTable.fields;
    fphoto_galleriesedit.addFields([
        ["ID", [fields.ID.visible && fields.ID.required ? ew.Validators.required(fields.ID.caption) : null], fields.ID.isInvalid],
        ["Album_Name", [fields.Album_Name.visible && fields.Album_Name.required ? ew.Validators.required(fields.Album_Name.caption) : null], fields.Album_Name.isInvalid],
        ["_Title", [fields._Title.visible && fields._Title.required ? ew.Validators.required(fields._Title.caption) : null], fields._Title.isInvalid],
        ["Slug", [fields.Slug.visible && fields.Slug.required ? ew.Validators.required(fields.Slug.caption) : null], fields.Slug.isInvalid],
        ["Photos", [fields.Photos.visible && fields.Photos.required ? ew.Validators.fileRequired(fields.Photos.caption) : null], fields.Photos.isInvalid],
        ["Active", [fields.Active.visible && fields.Active.required ? ew.Validators.required(fields.Active.caption) : null], fields.Active.isInvalid],
        ["Sort_Order", [fields.Sort_Order.visible && fields.Sort_Order.required ? ew.Validators.required(fields.Sort_Order.caption) : null, ew.Validators.integer], fields.Sort_Order.isInvalid],
        ["Description", [fields.Description.visible && fields.Description.required ? ew.Validators.required(fields.Description.caption) : null], fields.Description.isInvalid],
        ["Keywords", [fields.Keywords.visible && fields.Keywords.required ? ew.Validators.required(fields.Keywords.caption) : null], fields.Keywords.isInvalid],
        ["Created_AT", [fields.Created_AT.visible && fields.Created_AT.required ? ew.Validators.required(fields.Created_AT.caption) : null], fields.Created_AT.isInvalid],
        ["Created_BY", [fields.Created_BY.visible && fields.Created_BY.required ? ew.Validators.required(fields.Created_BY.caption) : null], fields.Created_BY.isInvalid],
        ["IP", [fields.IP.visible && fields.IP.required ? ew.Validators.required(fields.IP.caption) : null], fields.IP.isInvalid]
    ]);

    // Form_CustomValidate
    fphoto_galleriesedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fphoto_galleriesedit.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    fphoto_galleriesedit.lists.Active = <?= $Page->Active->toClientList($Page) ?>;
    loadjs.done("fphoto_galleriesedit");
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
<form name="fphoto_galleriesedit" id="fphoto_galleriesedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="photo_galleries">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->ID->Visible) { // ID ?>
    <div id="r_ID"<?= $Page->ID->rowAttributes() ?>>
        <label id="elh_photo_galleries_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ID->caption() ?><?= $Page->ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->ID->cellAttributes() ?>>
<span id="el_photo_galleries_ID">
<span<?= $Page->ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->ID->getDisplayValue($Page->ID->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="photo_galleries" data-field="x_ID" data-hidden="1" name="x_ID" id="x_ID" value="<?= HtmlEncode($Page->ID->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Album_Name->Visible) { // Album_Name ?>
    <div id="r_Album_Name"<?= $Page->Album_Name->rowAttributes() ?>>
        <label id="elh_photo_galleries_Album_Name" for="x_Album_Name" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Album_Name->caption() ?><?= $Page->Album_Name->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Album_Name->cellAttributes() ?>>
<span id="el_photo_galleries_Album_Name">
<input type="<?= $Page->Album_Name->getInputTextType() ?>" name="x_Album_Name" id="x_Album_Name" data-table="photo_galleries" data-field="x_Album_Name" value="<?= $Page->Album_Name->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->Album_Name->getPlaceHolder()) ?>"<?= $Page->Album_Name->editAttributes() ?> aria-describedby="x_Album_Name_help">
<?= $Page->Album_Name->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Album_Name->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->_Title->Visible) { // Title ?>
    <div id="r__Title"<?= $Page->_Title->rowAttributes() ?>>
        <label id="elh_photo_galleries__Title" for="x__Title" class="<?= $Page->LeftColumnClass ?>"><?= $Page->_Title->caption() ?><?= $Page->_Title->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->_Title->cellAttributes() ?>>
<span id="el_photo_galleries__Title">
<input type="<?= $Page->_Title->getInputTextType() ?>" name="x__Title" id="x__Title" data-table="photo_galleries" data-field="x__Title" value="<?= $Page->_Title->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->_Title->getPlaceHolder()) ?>"<?= $Page->_Title->editAttributes() ?> aria-describedby="x__Title_help">
<?= $Page->_Title->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->_Title->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Slug->Visible) { // Slug ?>
    <div id="r_Slug"<?= $Page->Slug->rowAttributes() ?>>
        <label id="elh_photo_galleries_Slug" for="x_Slug" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Slug->caption() ?><?= $Page->Slug->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Slug->cellAttributes() ?>>
<span id="el_photo_galleries_Slug">
<input type="<?= $Page->Slug->getInputTextType() ?>" name="x_Slug" id="x_Slug" data-table="photo_galleries" data-field="x_Slug" value="<?= $Page->Slug->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->Slug->getPlaceHolder()) ?>"<?= $Page->Slug->editAttributes() ?> aria-describedby="x_Slug_help">
<?= $Page->Slug->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Slug->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Photos->Visible) { // Photos ?>
    <div id="r_Photos"<?= $Page->Photos->rowAttributes() ?>>
        <label id="elh_photo_galleries_Photos" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Photos->caption() ?><?= $Page->Photos->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Photos->cellAttributes() ?>>
<span id="el_photo_galleries_Photos">
<div id="fd_x_Photos" class="fileinput-button ew-file-drop-zone">
    <input type="file" class="form-control ew-file-input" title="<?= $Page->Photos->title() ?>" data-table="photo_galleries" data-field="x_Photos" name="x_Photos" id="x_Photos" lang="<?= CurrentLanguageID() ?>" multiple<?= $Page->Photos->editAttributes() ?> aria-describedby="x_Photos_help"<?= ($Page->Photos->ReadOnly || $Page->Photos->Disabled) ? " disabled" : "" ?>>
    <div class="text-muted ew-file-text"><?= $Language->phrase("ChooseFiles") ?></div>
</div>
<?= $Page->Photos->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Photos->getErrorMessage() ?></div>
<input type="hidden" name="fn_x_Photos" id= "fn_x_Photos" value="<?= $Page->Photos->Upload->FileName ?>">
<input type="hidden" name="fa_x_Photos" id= "fa_x_Photos" value="<?= (Post("fa_x_Photos") == "0") ? "0" : "1" ?>">
<input type="hidden" name="fs_x_Photos" id= "fs_x_Photos" value="65535">
<input type="hidden" name="fx_x_Photos" id= "fx_x_Photos" value="<?= $Page->Photos->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_Photos" id= "fm_x_Photos" value="<?= $Page->Photos->UploadMaxFileSize ?>">
<input type="hidden" name="fc_x_Photos" id= "fc_x_Photos" value="<?= $Page->Photos->UploadMaxFileCount ?>">
<table id="ft_x_Photos" class="table table-sm float-start ew-upload-table"><tbody class="files"></tbody></table>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Active->Visible) { // Active ?>
    <div id="r_Active"<?= $Page->Active->rowAttributes() ?>>
        <label id="elh_photo_galleries_Active" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Active->caption() ?><?= $Page->Active->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Active->cellAttributes() ?>>
<span id="el_photo_galleries_Active">
<template id="tp_x_Active">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="photo_galleries" data-field="x_Active" name="x_Active" id="x_Active"<?= $Page->Active->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x_Active" class="ew-item-list"></div>
<selection-list hidden
    id="x_Active"
    name="x_Active"
    value="<?= HtmlEncode($Page->Active->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x_Active"
    data-bs-target="dsl_x_Active"
    data-repeatcolumn="5"
    class="form-control<?= $Page->Active->isInvalidClass() ?>"
    data-table="photo_galleries"
    data-field="x_Active"
    data-value-separator="<?= $Page->Active->displayValueSeparatorAttribute() ?>"
    <?= $Page->Active->editAttributes() ?>></selection-list>
<?= $Page->Active->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Active->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Sort_Order->Visible) { // Sort_Order ?>
    <div id="r_Sort_Order"<?= $Page->Sort_Order->rowAttributes() ?>>
        <label id="elh_photo_galleries_Sort_Order" for="x_Sort_Order" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Sort_Order->caption() ?><?= $Page->Sort_Order->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Sort_Order->cellAttributes() ?>>
<span id="el_photo_galleries_Sort_Order">
<input type="<?= $Page->Sort_Order->getInputTextType() ?>" name="x_Sort_Order" id="x_Sort_Order" data-table="photo_galleries" data-field="x_Sort_Order" value="<?= $Page->Sort_Order->EditValue ?>" size="30" maxlength="11" placeholder="<?= HtmlEncode($Page->Sort_Order->getPlaceHolder()) ?>"<?= $Page->Sort_Order->editAttributes() ?> aria-describedby="x_Sort_Order_help">
<?= $Page->Sort_Order->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Sort_Order->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Description->Visible) { // Description ?>
    <div id="r_Description"<?= $Page->Description->rowAttributes() ?>>
        <label id="elh_photo_galleries_Description" for="x_Description" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Description->caption() ?><?= $Page->Description->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Description->cellAttributes() ?>>
<span id="el_photo_galleries_Description">
<textarea data-table="photo_galleries" data-field="x_Description" name="x_Description" id="x_Description" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->Description->getPlaceHolder()) ?>"<?= $Page->Description->editAttributes() ?> aria-describedby="x_Description_help"><?= $Page->Description->EditValue ?></textarea>
<?= $Page->Description->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Description->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Keywords->Visible) { // Keywords ?>
    <div id="r_Keywords"<?= $Page->Keywords->rowAttributes() ?>>
        <label id="elh_photo_galleries_Keywords" for="x_Keywords" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Keywords->caption() ?><?= $Page->Keywords->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Keywords->cellAttributes() ?>>
<span id="el_photo_galleries_Keywords">
<textarea data-table="photo_galleries" data-field="x_Keywords" name="x_Keywords" id="x_Keywords" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->Keywords->getPlaceHolder()) ?>"<?= $Page->Keywords->editAttributes() ?> aria-describedby="x_Keywords_help"><?= $Page->Keywords->EditValue ?></textarea>
<?= $Page->Keywords->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Keywords->getErrorMessage() ?></div>
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
    ew.addEventHandlers("photo_galleries");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
