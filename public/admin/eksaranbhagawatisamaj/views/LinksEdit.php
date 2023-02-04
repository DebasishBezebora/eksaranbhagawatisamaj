<?php

namespace PHPMaker2022\eksbs;

// Page object
$LinksEdit = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { links: currentTable } });
var currentForm, currentPageID;
var flinksedit;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    flinksedit = new ew.Form("flinksedit", "edit");
    currentPageID = ew.PAGE_ID = "edit";
    currentForm = flinksedit;

    // Add fields
    var fields = currentTable.fields;
    flinksedit.addFields([
        ["ID", [fields.ID.visible && fields.ID.required ? ew.Validators.required(fields.ID.caption) : null], fields.ID.isInvalid],
        ["Link_Name", [fields.Link_Name.visible && fields.Link_Name.required ? ew.Validators.required(fields.Link_Name.caption) : null], fields.Link_Name.isInvalid],
        ["URL_Slug", [fields.URL_Slug.visible && fields.URL_Slug.required ? ew.Validators.required(fields.URL_Slug.caption) : null], fields.URL_Slug.isInvalid],
        ["Link_Content", [fields.Link_Content.visible && fields.Link_Content.required ? ew.Validators.required(fields.Link_Content.caption) : null], fields.Link_Content.isInvalid],
        ["Photos", [fields.Photos.visible && fields.Photos.required ? ew.Validators.fileRequired(fields.Photos.caption) : null], fields.Photos.isInvalid],
        ["Video_1", [fields.Video_1.visible && fields.Video_1.required ? ew.Validators.required(fields.Video_1.caption) : null], fields.Video_1.isInvalid],
        ["Video_2", [fields.Video_2.visible && fields.Video_2.required ? ew.Validators.required(fields.Video_2.caption) : null], fields.Video_2.isInvalid],
        ["Video_3", [fields.Video_3.visible && fields.Video_3.required ? ew.Validators.required(fields.Video_3.caption) : null], fields.Video_3.isInvalid],
        ["_Title", [fields._Title.visible && fields._Title.required ? ew.Validators.required(fields._Title.caption) : null], fields._Title.isInvalid],
        ["Description", [fields.Description.visible && fields.Description.required ? ew.Validators.required(fields.Description.caption) : null], fields.Description.isInvalid],
        ["Keywords", [fields.Keywords.visible && fields.Keywords.required ? ew.Validators.required(fields.Keywords.caption) : null], fields.Keywords.isInvalid],
        ["Active", [fields.Active.visible && fields.Active.required ? ew.Validators.required(fields.Active.caption) : null], fields.Active.isInvalid],
        ["Created_AT", [fields.Created_AT.visible && fields.Created_AT.required ? ew.Validators.required(fields.Created_AT.caption) : null], fields.Created_AT.isInvalid],
        ["Created_BY", [fields.Created_BY.visible && fields.Created_BY.required ? ew.Validators.required(fields.Created_BY.caption) : null], fields.Created_BY.isInvalid],
        ["IP", [fields.IP.visible && fields.IP.required ? ew.Validators.required(fields.IP.caption) : null], fields.IP.isInvalid]
    ]);

    // Form_CustomValidate
    flinksedit.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    flinksedit.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    flinksedit.lists.Active = <?= $Page->Active->toClientList($Page) ?>;
    loadjs.done("flinksedit");
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
<form name="flinksedit" id="flinksedit" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="links">
<input type="hidden" name="action" id="action" value="update">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-edit-div"><!-- page* -->
<?php if ($Page->ID->Visible) { // ID ?>
    <div id="r_ID"<?= $Page->ID->rowAttributes() ?>>
        <label id="elh_links_ID" class="<?= $Page->LeftColumnClass ?>"><?= $Page->ID->caption() ?><?= $Page->ID->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->ID->cellAttributes() ?>>
<span id="el_links_ID">
<span<?= $Page->ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->ID->getDisplayValue($Page->ID->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="links" data-field="x_ID" data-hidden="1" name="x_ID" id="x_ID" value="<?= HtmlEncode($Page->ID->CurrentValue) ?>">
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Link_Name->Visible) { // Link_Name ?>
    <div id="r_Link_Name"<?= $Page->Link_Name->rowAttributes() ?>>
        <label id="elh_links_Link_Name" for="x_Link_Name" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Link_Name->caption() ?><?= $Page->Link_Name->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Link_Name->cellAttributes() ?>>
<span id="el_links_Link_Name">
<input type="<?= $Page->Link_Name->getInputTextType() ?>" name="x_Link_Name" id="x_Link_Name" data-table="links" data-field="x_Link_Name" value="<?= $Page->Link_Name->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->Link_Name->getPlaceHolder()) ?>"<?= $Page->Link_Name->editAttributes() ?> aria-describedby="x_Link_Name_help">
<?= $Page->Link_Name->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Link_Name->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->URL_Slug->Visible) { // URL_Slug ?>
    <div id="r_URL_Slug"<?= $Page->URL_Slug->rowAttributes() ?>>
        <label id="elh_links_URL_Slug" for="x_URL_Slug" class="<?= $Page->LeftColumnClass ?>"><?= $Page->URL_Slug->caption() ?><?= $Page->URL_Slug->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->URL_Slug->cellAttributes() ?>>
<span id="el_links_URL_Slug">
<input type="<?= $Page->URL_Slug->getInputTextType() ?>" name="x_URL_Slug" id="x_URL_Slug" data-table="links" data-field="x_URL_Slug" value="<?= $Page->URL_Slug->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->URL_Slug->getPlaceHolder()) ?>"<?= $Page->URL_Slug->editAttributes() ?> aria-describedby="x_URL_Slug_help">
<?= $Page->URL_Slug->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->URL_Slug->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Link_Content->Visible) { // Link_Content ?>
    <div id="r_Link_Content"<?= $Page->Link_Content->rowAttributes() ?>>
        <label id="elh_links_Link_Content" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Link_Content->caption() ?><?= $Page->Link_Content->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Link_Content->cellAttributes() ?>>
<span id="el_links_Link_Content">
<?php $Page->Link_Content->EditAttrs->appendClass("editor"); ?>
<textarea data-table="links" data-field="x_Link_Content" name="x_Link_Content" id="x_Link_Content" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->Link_Content->getPlaceHolder()) ?>"<?= $Page->Link_Content->editAttributes() ?> aria-describedby="x_Link_Content_help"><?= $Page->Link_Content->EditValue ?></textarea>
<?= $Page->Link_Content->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Link_Content->getErrorMessage() ?></div>
<script>
loadjs.ready(["flinksedit", "editor"], function() {
	ew.createEditor("flinksedit", "x_Link_Content", 35, 4, <?= $Page->Link_Content->ReadOnly || false ? "true" : "false" ?>);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Photos->Visible) { // Photos ?>
    <div id="r_Photos"<?= $Page->Photos->rowAttributes() ?>>
        <label id="elh_links_Photos" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Photos->caption() ?><?= $Page->Photos->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Photos->cellAttributes() ?>>
<span id="el_links_Photos">
<div id="fd_x_Photos" class="fileinput-button ew-file-drop-zone">
    <input type="file" class="form-control ew-file-input" title="<?= $Page->Photos->title() ?>" data-table="links" data-field="x_Photos" name="x_Photos" id="x_Photos" lang="<?= CurrentLanguageID() ?>" multiple<?= $Page->Photos->editAttributes() ?> aria-describedby="x_Photos_help"<?= ($Page->Photos->ReadOnly || $Page->Photos->Disabled) ? " disabled" : "" ?>>
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
<?php if ($Page->Video_1->Visible) { // Video_1 ?>
    <div id="r_Video_1"<?= $Page->Video_1->rowAttributes() ?>>
        <label id="elh_links_Video_1" for="x_Video_1" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Video_1->caption() ?><?= $Page->Video_1->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Video_1->cellAttributes() ?>>
<span id="el_links_Video_1">
<input type="<?= $Page->Video_1->getInputTextType() ?>" name="x_Video_1" id="x_Video_1" data-table="links" data-field="x_Video_1" value="<?= $Page->Video_1->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->Video_1->getPlaceHolder()) ?>"<?= $Page->Video_1->editAttributes() ?> aria-describedby="x_Video_1_help">
<?= $Page->Video_1->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Video_1->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Video_2->Visible) { // Video_2 ?>
    <div id="r_Video_2"<?= $Page->Video_2->rowAttributes() ?>>
        <label id="elh_links_Video_2" for="x_Video_2" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Video_2->caption() ?><?= $Page->Video_2->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Video_2->cellAttributes() ?>>
<span id="el_links_Video_2">
<input type="<?= $Page->Video_2->getInputTextType() ?>" name="x_Video_2" id="x_Video_2" data-table="links" data-field="x_Video_2" value="<?= $Page->Video_2->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->Video_2->getPlaceHolder()) ?>"<?= $Page->Video_2->editAttributes() ?> aria-describedby="x_Video_2_help">
<?= $Page->Video_2->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Video_2->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Video_3->Visible) { // Video_3 ?>
    <div id="r_Video_3"<?= $Page->Video_3->rowAttributes() ?>>
        <label id="elh_links_Video_3" for="x_Video_3" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Video_3->caption() ?><?= $Page->Video_3->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Video_3->cellAttributes() ?>>
<span id="el_links_Video_3">
<input type="<?= $Page->Video_3->getInputTextType() ?>" name="x_Video_3" id="x_Video_3" data-table="links" data-field="x_Video_3" value="<?= $Page->Video_3->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->Video_3->getPlaceHolder()) ?>"<?= $Page->Video_3->editAttributes() ?> aria-describedby="x_Video_3_help">
<?= $Page->Video_3->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Video_3->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->_Title->Visible) { // Title ?>
    <div id="r__Title"<?= $Page->_Title->rowAttributes() ?>>
        <label id="elh_links__Title" for="x__Title" class="<?= $Page->LeftColumnClass ?>"><?= $Page->_Title->caption() ?><?= $Page->_Title->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->_Title->cellAttributes() ?>>
<span id="el_links__Title">
<input type="<?= $Page->_Title->getInputTextType() ?>" name="x__Title" id="x__Title" data-table="links" data-field="x__Title" value="<?= $Page->_Title->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->_Title->getPlaceHolder()) ?>"<?= $Page->_Title->editAttributes() ?> aria-describedby="x__Title_help">
<?= $Page->_Title->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->_Title->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Description->Visible) { // Description ?>
    <div id="r_Description"<?= $Page->Description->rowAttributes() ?>>
        <label id="elh_links_Description" for="x_Description" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Description->caption() ?><?= $Page->Description->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Description->cellAttributes() ?>>
<span id="el_links_Description">
<textarea data-table="links" data-field="x_Description" name="x_Description" id="x_Description" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->Description->getPlaceHolder()) ?>"<?= $Page->Description->editAttributes() ?> aria-describedby="x_Description_help"><?= $Page->Description->EditValue ?></textarea>
<?= $Page->Description->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Description->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Keywords->Visible) { // Keywords ?>
    <div id="r_Keywords"<?= $Page->Keywords->rowAttributes() ?>>
        <label id="elh_links_Keywords" for="x_Keywords" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Keywords->caption() ?><?= $Page->Keywords->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Keywords->cellAttributes() ?>>
<span id="el_links_Keywords">
<textarea data-table="links" data-field="x_Keywords" name="x_Keywords" id="x_Keywords" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->Keywords->getPlaceHolder()) ?>"<?= $Page->Keywords->editAttributes() ?> aria-describedby="x_Keywords_help"><?= $Page->Keywords->EditValue ?></textarea>
<?= $Page->Keywords->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Keywords->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Active->Visible) { // Active ?>
    <div id="r_Active"<?= $Page->Active->rowAttributes() ?>>
        <label id="elh_links_Active" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Active->caption() ?><?= $Page->Active->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Active->cellAttributes() ?>>
<span id="el_links_Active">
<template id="tp_x_Active">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="links" data-field="x_Active" name="x_Active" id="x_Active"<?= $Page->Active->editAttributes() ?>>
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
    data-table="links"
    data-field="x_Active"
    data-value-separator="<?= $Page->Active->displayValueSeparatorAttribute() ?>"
    <?= $Page->Active->editAttributes() ?>></selection-list>
<?= $Page->Active->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Active->getErrorMessage() ?></div>
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
    ew.addEventHandlers("links");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
