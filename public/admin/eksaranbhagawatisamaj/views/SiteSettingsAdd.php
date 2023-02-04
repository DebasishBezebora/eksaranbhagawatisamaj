<?php

namespace PHPMaker2022\eksbs;

// Page object
$SiteSettingsAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { site_settings: currentTable } });
var currentForm, currentPageID;
var fsite_settingsadd;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fsite_settingsadd = new ew.Form("fsite_settingsadd", "add");
    currentPageID = ew.PAGE_ID = "add";
    currentForm = fsite_settingsadd;

    // Add fields
    var fields = currentTable.fields;
    fsite_settingsadd.addFields([
        ["Contact_No_1", [fields.Contact_No_1.visible && fields.Contact_No_1.required ? ew.Validators.required(fields.Contact_No_1.caption) : null], fields.Contact_No_1.isInvalid],
        ["Contact_No_2", [fields.Contact_No_2.visible && fields.Contact_No_2.required ? ew.Validators.required(fields.Contact_No_2.caption) : null], fields.Contact_No_2.isInvalid],
        ["Brand_Name", [fields.Brand_Name.visible && fields.Brand_Name.required ? ew.Validators.required(fields.Brand_Name.caption) : null], fields.Brand_Name.isInvalid],
        ["Logo", [fields.Logo.visible && fields.Logo.required ? ew.Validators.fileRequired(fields.Logo.caption) : null], fields.Logo.isInvalid],
        ["Favicon", [fields.Favicon.visible && fields.Favicon.required ? ew.Validators.fileRequired(fields.Favicon.caption) : null], fields.Favicon.isInvalid],
        ["Address", [fields.Address.visible && fields.Address.required ? ew.Validators.required(fields.Address.caption) : null], fields.Address.isInvalid],
        ["Facebook", [fields.Facebook.visible && fields.Facebook.required ? ew.Validators.required(fields.Facebook.caption) : null], fields.Facebook.isInvalid],
        ["Twitter", [fields.Twitter.visible && fields.Twitter.required ? ew.Validators.required(fields.Twitter.caption) : null], fields.Twitter.isInvalid],
        ["Instagram", [fields.Instagram.visible && fields.Instagram.required ? ew.Validators.required(fields.Instagram.caption) : null], fields.Instagram.isInvalid],
        ["Map", [fields.Map.visible && fields.Map.required ? ew.Validators.required(fields.Map.caption) : null], fields.Map.isInvalid],
        ["_Title", [fields._Title.visible && fields._Title.required ? ew.Validators.required(fields._Title.caption) : null], fields._Title.isInvalid],
        ["Description", [fields.Description.visible && fields.Description.required ? ew.Validators.required(fields.Description.caption) : null], fields.Description.isInvalid],
        ["Keywords", [fields.Keywords.visible && fields.Keywords.required ? ew.Validators.required(fields.Keywords.caption) : null], fields.Keywords.isInvalid],
        ["Active", [fields.Active.visible && fields.Active.required ? ew.Validators.required(fields.Active.caption) : null], fields.Active.isInvalid],
        ["Created_AT", [fields.Created_AT.visible && fields.Created_AT.required ? ew.Validators.required(fields.Created_AT.caption) : null], fields.Created_AT.isInvalid],
        ["Created_BY", [fields.Created_BY.visible && fields.Created_BY.required ? ew.Validators.required(fields.Created_BY.caption) : null], fields.Created_BY.isInvalid],
        ["IP", [fields.IP.visible && fields.IP.required ? ew.Validators.required(fields.IP.caption) : null], fields.IP.isInvalid]
    ]);

    // Form_CustomValidate
    fsite_settingsadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fsite_settingsadd.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    fsite_settingsadd.lists.Active = <?= $Page->Active->toClientList($Page) ?>;
    loadjs.done("fsite_settingsadd");
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
<form name="fsite_settingsadd" id="fsite_settingsadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="site_settings">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->Contact_No_1->Visible) { // Contact_No_1 ?>
    <div id="r_Contact_No_1"<?= $Page->Contact_No_1->rowAttributes() ?>>
        <label id="elh_site_settings_Contact_No_1" for="x_Contact_No_1" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Contact_No_1->caption() ?><?= $Page->Contact_No_1->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Contact_No_1->cellAttributes() ?>>
<span id="el_site_settings_Contact_No_1">
<input type="<?= $Page->Contact_No_1->getInputTextType() ?>" name="x_Contact_No_1" id="x_Contact_No_1" data-table="site_settings" data-field="x_Contact_No_1" value="<?= $Page->Contact_No_1->EditValue ?>" size="30" maxlength="10" placeholder="<?= HtmlEncode($Page->Contact_No_1->getPlaceHolder()) ?>"<?= $Page->Contact_No_1->editAttributes() ?> aria-describedby="x_Contact_No_1_help">
<?= $Page->Contact_No_1->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Contact_No_1->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Contact_No_2->Visible) { // Contact_No_2 ?>
    <div id="r_Contact_No_2"<?= $Page->Contact_No_2->rowAttributes() ?>>
        <label id="elh_site_settings_Contact_No_2" for="x_Contact_No_2" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Contact_No_2->caption() ?><?= $Page->Contact_No_2->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Contact_No_2->cellAttributes() ?>>
<span id="el_site_settings_Contact_No_2">
<input type="<?= $Page->Contact_No_2->getInputTextType() ?>" name="x_Contact_No_2" id="x_Contact_No_2" data-table="site_settings" data-field="x_Contact_No_2" value="<?= $Page->Contact_No_2->EditValue ?>" size="30" maxlength="10" placeholder="<?= HtmlEncode($Page->Contact_No_2->getPlaceHolder()) ?>"<?= $Page->Contact_No_2->editAttributes() ?> aria-describedby="x_Contact_No_2_help">
<?= $Page->Contact_No_2->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Contact_No_2->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Brand_Name->Visible) { // Brand_Name ?>
    <div id="r_Brand_Name"<?= $Page->Brand_Name->rowAttributes() ?>>
        <label id="elh_site_settings_Brand_Name" for="x_Brand_Name" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Brand_Name->caption() ?><?= $Page->Brand_Name->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Brand_Name->cellAttributes() ?>>
<span id="el_site_settings_Brand_Name">
<input type="<?= $Page->Brand_Name->getInputTextType() ?>" name="x_Brand_Name" id="x_Brand_Name" data-table="site_settings" data-field="x_Brand_Name" value="<?= $Page->Brand_Name->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->Brand_Name->getPlaceHolder()) ?>"<?= $Page->Brand_Name->editAttributes() ?> aria-describedby="x_Brand_Name_help">
<?= $Page->Brand_Name->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Brand_Name->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Logo->Visible) { // Logo ?>
    <div id="r_Logo"<?= $Page->Logo->rowAttributes() ?>>
        <label id="elh_site_settings_Logo" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Logo->caption() ?><?= $Page->Logo->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Logo->cellAttributes() ?>>
<span id="el_site_settings_Logo">
<div id="fd_x_Logo" class="fileinput-button ew-file-drop-zone">
    <input type="file" class="form-control ew-file-input" title="<?= $Page->Logo->title() ?>" data-table="site_settings" data-field="x_Logo" name="x_Logo" id="x_Logo" lang="<?= CurrentLanguageID() ?>"<?= $Page->Logo->editAttributes() ?> aria-describedby="x_Logo_help"<?= ($Page->Logo->ReadOnly || $Page->Logo->Disabled) ? " disabled" : "" ?>>
    <div class="text-muted ew-file-text"><?= $Language->phrase("ChooseFile") ?></div>
</div>
<?= $Page->Logo->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Logo->getErrorMessage() ?></div>
<input type="hidden" name="fn_x_Logo" id= "fn_x_Logo" value="<?= $Page->Logo->Upload->FileName ?>">
<input type="hidden" name="fa_x_Logo" id= "fa_x_Logo" value="0">
<input type="hidden" name="fs_x_Logo" id= "fs_x_Logo" value="255">
<input type="hidden" name="fx_x_Logo" id= "fx_x_Logo" value="<?= $Page->Logo->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_Logo" id= "fm_x_Logo" value="<?= $Page->Logo->UploadMaxFileSize ?>">
<table id="ft_x_Logo" class="table table-sm float-start ew-upload-table"><tbody class="files"></tbody></table>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Favicon->Visible) { // Favicon ?>
    <div id="r_Favicon"<?= $Page->Favicon->rowAttributes() ?>>
        <label id="elh_site_settings_Favicon" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Favicon->caption() ?><?= $Page->Favicon->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Favicon->cellAttributes() ?>>
<span id="el_site_settings_Favicon">
<div id="fd_x_Favicon" class="fileinput-button ew-file-drop-zone">
    <input type="file" class="form-control ew-file-input" title="<?= $Page->Favicon->title() ?>" data-table="site_settings" data-field="x_Favicon" name="x_Favicon" id="x_Favicon" lang="<?= CurrentLanguageID() ?>"<?= $Page->Favicon->editAttributes() ?> aria-describedby="x_Favicon_help"<?= ($Page->Favicon->ReadOnly || $Page->Favicon->Disabled) ? " disabled" : "" ?>>
    <div class="text-muted ew-file-text"><?= $Language->phrase("ChooseFile") ?></div>
</div>
<?= $Page->Favicon->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Favicon->getErrorMessage() ?></div>
<input type="hidden" name="fn_x_Favicon" id= "fn_x_Favicon" value="<?= $Page->Favicon->Upload->FileName ?>">
<input type="hidden" name="fa_x_Favicon" id= "fa_x_Favicon" value="0">
<input type="hidden" name="fs_x_Favicon" id= "fs_x_Favicon" value="255">
<input type="hidden" name="fx_x_Favicon" id= "fx_x_Favicon" value="<?= $Page->Favicon->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x_Favicon" id= "fm_x_Favicon" value="<?= $Page->Favicon->UploadMaxFileSize ?>">
<table id="ft_x_Favicon" class="table table-sm float-start ew-upload-table"><tbody class="files"></tbody></table>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Address->Visible) { // Address ?>
    <div id="r_Address"<?= $Page->Address->rowAttributes() ?>>
        <label id="elh_site_settings_Address" for="x_Address" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Address->caption() ?><?= $Page->Address->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Address->cellAttributes() ?>>
<span id="el_site_settings_Address">
<textarea data-table="site_settings" data-field="x_Address" name="x_Address" id="x_Address" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->Address->getPlaceHolder()) ?>"<?= $Page->Address->editAttributes() ?> aria-describedby="x_Address_help"><?= $Page->Address->EditValue ?></textarea>
<?= $Page->Address->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Address->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Facebook->Visible) { // Facebook ?>
    <div id="r_Facebook"<?= $Page->Facebook->rowAttributes() ?>>
        <label id="elh_site_settings_Facebook" for="x_Facebook" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Facebook->caption() ?><?= $Page->Facebook->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Facebook->cellAttributes() ?>>
<span id="el_site_settings_Facebook">
<input type="<?= $Page->Facebook->getInputTextType() ?>" name="x_Facebook" id="x_Facebook" data-table="site_settings" data-field="x_Facebook" value="<?= $Page->Facebook->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->Facebook->getPlaceHolder()) ?>"<?= $Page->Facebook->editAttributes() ?> aria-describedby="x_Facebook_help">
<?= $Page->Facebook->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Facebook->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Twitter->Visible) { // Twitter ?>
    <div id="r_Twitter"<?= $Page->Twitter->rowAttributes() ?>>
        <label id="elh_site_settings_Twitter" for="x_Twitter" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Twitter->caption() ?><?= $Page->Twitter->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Twitter->cellAttributes() ?>>
<span id="el_site_settings_Twitter">
<input type="<?= $Page->Twitter->getInputTextType() ?>" name="x_Twitter" id="x_Twitter" data-table="site_settings" data-field="x_Twitter" value="<?= $Page->Twitter->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->Twitter->getPlaceHolder()) ?>"<?= $Page->Twitter->editAttributes() ?> aria-describedby="x_Twitter_help">
<?= $Page->Twitter->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Twitter->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Instagram->Visible) { // Instagram ?>
    <div id="r_Instagram"<?= $Page->Instagram->rowAttributes() ?>>
        <label id="elh_site_settings_Instagram" for="x_Instagram" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Instagram->caption() ?><?= $Page->Instagram->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Instagram->cellAttributes() ?>>
<span id="el_site_settings_Instagram">
<input type="<?= $Page->Instagram->getInputTextType() ?>" name="x_Instagram" id="x_Instagram" data-table="site_settings" data-field="x_Instagram" value="<?= $Page->Instagram->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->Instagram->getPlaceHolder()) ?>"<?= $Page->Instagram->editAttributes() ?> aria-describedby="x_Instagram_help">
<?= $Page->Instagram->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Instagram->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Map->Visible) { // Map ?>
    <div id="r_Map"<?= $Page->Map->rowAttributes() ?>>
        <label id="elh_site_settings_Map" for="x_Map" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Map->caption() ?><?= $Page->Map->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Map->cellAttributes() ?>>
<span id="el_site_settings_Map">
<textarea data-table="site_settings" data-field="x_Map" name="x_Map" id="x_Map" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->Map->getPlaceHolder()) ?>"<?= $Page->Map->editAttributes() ?> aria-describedby="x_Map_help"><?= $Page->Map->EditValue ?></textarea>
<?= $Page->Map->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Map->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->_Title->Visible) { // Title ?>
    <div id="r__Title"<?= $Page->_Title->rowAttributes() ?>>
        <label id="elh_site_settings__Title" for="x__Title" class="<?= $Page->LeftColumnClass ?>"><?= $Page->_Title->caption() ?><?= $Page->_Title->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->_Title->cellAttributes() ?>>
<span id="el_site_settings__Title">
<input type="<?= $Page->_Title->getInputTextType() ?>" name="x__Title" id="x__Title" data-table="site_settings" data-field="x__Title" value="<?= $Page->_Title->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->_Title->getPlaceHolder()) ?>"<?= $Page->_Title->editAttributes() ?> aria-describedby="x__Title_help">
<?= $Page->_Title->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->_Title->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Description->Visible) { // Description ?>
    <div id="r_Description"<?= $Page->Description->rowAttributes() ?>>
        <label id="elh_site_settings_Description" for="x_Description" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Description->caption() ?><?= $Page->Description->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Description->cellAttributes() ?>>
<span id="el_site_settings_Description">
<textarea data-table="site_settings" data-field="x_Description" name="x_Description" id="x_Description" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->Description->getPlaceHolder()) ?>"<?= $Page->Description->editAttributes() ?> aria-describedby="x_Description_help"><?= $Page->Description->EditValue ?></textarea>
<?= $Page->Description->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Description->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Keywords->Visible) { // Keywords ?>
    <div id="r_Keywords"<?= $Page->Keywords->rowAttributes() ?>>
        <label id="elh_site_settings_Keywords" for="x_Keywords" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Keywords->caption() ?><?= $Page->Keywords->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Keywords->cellAttributes() ?>>
<span id="el_site_settings_Keywords">
<textarea data-table="site_settings" data-field="x_Keywords" name="x_Keywords" id="x_Keywords" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->Keywords->getPlaceHolder()) ?>"<?= $Page->Keywords->editAttributes() ?> aria-describedby="x_Keywords_help"><?= $Page->Keywords->EditValue ?></textarea>
<?= $Page->Keywords->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Keywords->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Active->Visible) { // Active ?>
    <div id="r_Active"<?= $Page->Active->rowAttributes() ?>>
        <label id="elh_site_settings_Active" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Active->caption() ?><?= $Page->Active->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Active->cellAttributes() ?>>
<span id="el_site_settings_Active">
<template id="tp_x_Active">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="site_settings" data-field="x_Active" name="x_Active" id="x_Active"<?= $Page->Active->editAttributes() ?>>
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
    data-table="site_settings"
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
    ew.addEventHandlers("site_settings");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
