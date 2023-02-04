<?php

namespace PHPMaker2022\eksbs;

// Page object
$EventsAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { events: currentTable } });
var currentForm, currentPageID;
var feventsadd;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    feventsadd = new ew.Form("feventsadd", "add");
    currentPageID = ew.PAGE_ID = "add";
    currentForm = feventsadd;

    // Add fields
    var fields = currentTable.fields;
    feventsadd.addFields([
        ["Event_Date", [fields.Event_Date.visible && fields.Event_Date.required ? ew.Validators.required(fields.Event_Date.caption) : null, ew.Validators.datetime(fields.Event_Date.clientFormatPattern)], fields.Event_Date.isInvalid],
        ["Event_Category", [fields.Event_Category.visible && fields.Event_Category.required ? ew.Validators.required(fields.Event_Category.caption) : null], fields.Event_Category.isInvalid],
        ["_Content", [fields._Content.visible && fields._Content.required ? ew.Validators.required(fields._Content.caption) : null], fields._Content.isInvalid],
        ["Photos", [fields.Photos.visible && fields.Photos.required ? ew.Validators.fileRequired(fields.Photos.caption) : null], fields.Photos.isInvalid],
        ["Video_1", [fields.Video_1.visible && fields.Video_1.required ? ew.Validators.required(fields.Video_1.caption) : null], fields.Video_1.isInvalid],
        ["Video_2", [fields.Video_2.visible && fields.Video_2.required ? ew.Validators.required(fields.Video_2.caption) : null], fields.Video_2.isInvalid],
        ["Video_3", [fields.Video_3.visible && fields.Video_3.required ? ew.Validators.required(fields.Video_3.caption) : null], fields.Video_3.isInvalid],
        ["_Title", [fields._Title.visible && fields._Title.required ? ew.Validators.required(fields._Title.caption) : null], fields._Title.isInvalid],
        ["Description", [fields.Description.visible && fields.Description.required ? ew.Validators.required(fields.Description.caption) : null], fields.Description.isInvalid],
        ["Keywords", [fields.Keywords.visible && fields.Keywords.required ? ew.Validators.required(fields.Keywords.caption) : null], fields.Keywords.isInvalid],
        ["Active", [fields.Active.visible && fields.Active.required ? ew.Validators.required(fields.Active.caption) : null], fields.Active.isInvalid],
        ["Sort_Order", [fields.Sort_Order.visible && fields.Sort_Order.required ? ew.Validators.required(fields.Sort_Order.caption) : null, ew.Validators.integer], fields.Sort_Order.isInvalid],
        ["Created_BY", [fields.Created_BY.visible && fields.Created_BY.required ? ew.Validators.required(fields.Created_BY.caption) : null], fields.Created_BY.isInvalid],
        ["Created_AT", [fields.Created_AT.visible && fields.Created_AT.required ? ew.Validators.required(fields.Created_AT.caption) : null], fields.Created_AT.isInvalid],
        ["IP", [fields.IP.visible && fields.IP.required ? ew.Validators.required(fields.IP.caption) : null], fields.IP.isInvalid]
    ]);

    // Form_CustomValidate
    feventsadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    feventsadd.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    feventsadd.lists.Event_Category = <?= $Page->Event_Category->toClientList($Page) ?>;
    feventsadd.lists.Active = <?= $Page->Active->toClientList($Page) ?>;
    loadjs.done("feventsadd");
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
<form name="feventsadd" id="feventsadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="events">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->Event_Date->Visible) { // Event_Date ?>
    <div id="r_Event_Date"<?= $Page->Event_Date->rowAttributes() ?>>
        <label id="elh_events_Event_Date" for="x_Event_Date" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Event_Date->caption() ?><?= $Page->Event_Date->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Event_Date->cellAttributes() ?>>
<span id="el_events_Event_Date">
<input type="<?= $Page->Event_Date->getInputTextType() ?>" name="x_Event_Date" id="x_Event_Date" data-table="events" data-field="x_Event_Date" value="<?= $Page->Event_Date->EditValue ?>" maxlength="10" placeholder="<?= HtmlEncode($Page->Event_Date->getPlaceHolder()) ?>"<?= $Page->Event_Date->editAttributes() ?> aria-describedby="x_Event_Date_help">
<?= $Page->Event_Date->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Event_Date->getErrorMessage() ?></div>
<?php if (!$Page->Event_Date->ReadOnly && !$Page->Event_Date->Disabled && !isset($Page->Event_Date->EditAttrs["readonly"]) && !isset($Page->Event_Date->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["feventsadd", "datetimepicker"], function () {
    let options = {
        localization: {
            locale: ew.LANGUAGE_ID
        },
        display: {
            format: "<?= DateFormat(0) ?>",
            icons: {
                previous: ew.IS_RTL ? "fas fa-chevron-right" : "fas fa-chevron-left",
                next: ew.IS_RTL ? "fas fa-chevron-left" : "fas fa-chevron-right"
            }
        }
    };
    ew.createDateTimePicker("feventsadd", "x_Event_Date", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Event_Category->Visible) { // Event_Category ?>
    <div id="r_Event_Category"<?= $Page->Event_Category->rowAttributes() ?>>
        <label id="elh_events_Event_Category" for="x_Event_Category" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Event_Category->caption() ?><?= $Page->Event_Category->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Event_Category->cellAttributes() ?>>
<span id="el_events_Event_Category">
    <select
        id="x_Event_Category"
        name="x_Event_Category"
        class="form-select ew-select<?= $Page->Event_Category->isInvalidClass() ?>"
        data-select2-id="feventsadd_x_Event_Category"
        data-table="events"
        data-field="x_Event_Category"
        data-value-separator="<?= $Page->Event_Category->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->Event_Category->getPlaceHolder()) ?>"
        <?= $Page->Event_Category->editAttributes() ?>>
        <?= $Page->Event_Category->selectOptionListHtml("x_Event_Category") ?>
    </select>
    <?= $Page->Event_Category->getCustomMessage() ?>
    <div class="invalid-feedback"><?= $Page->Event_Category->getErrorMessage() ?></div>
<?= $Page->Event_Category->Lookup->getParamTag($Page, "p_x_Event_Category") ?>
<script>
loadjs.ready("feventsadd", function() {
    var options = { name: "x_Event_Category", selectId: "feventsadd_x_Event_Category" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (feventsadd.lists.Event_Category.lookupOptions.length) {
        options.data = { id: "x_Event_Category", form: "feventsadd" };
    } else {
        options.ajax = { id: "x_Event_Category", form: "feventsadd", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.events.fields.Event_Category.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->_Content->Visible) { // Content ?>
    <div id="r__Content"<?= $Page->_Content->rowAttributes() ?>>
        <label id="elh_events__Content" class="<?= $Page->LeftColumnClass ?>"><?= $Page->_Content->caption() ?><?= $Page->_Content->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->_Content->cellAttributes() ?>>
<span id="el_events__Content">
<?php $Page->_Content->EditAttrs->appendClass("editor"); ?>
<textarea data-table="events" data-field="x__Content" name="x__Content" id="x__Content" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->_Content->getPlaceHolder()) ?>"<?= $Page->_Content->editAttributes() ?> aria-describedby="x__Content_help"><?= $Page->_Content->EditValue ?></textarea>
<?= $Page->_Content->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->_Content->getErrorMessage() ?></div>
<script>
loadjs.ready(["feventsadd", "editor"], function() {
	ew.createEditor("feventsadd", "x__Content", 35, 4, <?= $Page->_Content->ReadOnly || false ? "true" : "false" ?>);
});
</script>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Photos->Visible) { // Photos ?>
    <div id="r_Photos"<?= $Page->Photos->rowAttributes() ?>>
        <label id="elh_events_Photos" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Photos->caption() ?><?= $Page->Photos->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Photos->cellAttributes() ?>>
<span id="el_events_Photos">
<div id="fd_x_Photos" class="fileinput-button ew-file-drop-zone">
    <input type="file" class="form-control ew-file-input" title="<?= $Page->Photos->title() ?>" data-table="events" data-field="x_Photos" name="x_Photos" id="x_Photos" lang="<?= CurrentLanguageID() ?>" multiple<?= $Page->Photos->editAttributes() ?> aria-describedby="x_Photos_help"<?= ($Page->Photos->ReadOnly || $Page->Photos->Disabled) ? " disabled" : "" ?>>
    <div class="text-muted ew-file-text"><?= $Language->phrase("ChooseFiles") ?></div>
</div>
<?= $Page->Photos->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Photos->getErrorMessage() ?></div>
<input type="hidden" name="fn_x_Photos" id= "fn_x_Photos" value="<?= $Page->Photos->Upload->FileName ?>">
<input type="hidden" name="fa_x_Photos" id= "fa_x_Photos" value="0">
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
        <label id="elh_events_Video_1" for="x_Video_1" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Video_1->caption() ?><?= $Page->Video_1->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Video_1->cellAttributes() ?>>
<span id="el_events_Video_1">
<input type="<?= $Page->Video_1->getInputTextType() ?>" name="x_Video_1" id="x_Video_1" data-table="events" data-field="x_Video_1" value="<?= $Page->Video_1->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->Video_1->getPlaceHolder()) ?>"<?= $Page->Video_1->editAttributes() ?> aria-describedby="x_Video_1_help">
<?= $Page->Video_1->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Video_1->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Video_2->Visible) { // Video_2 ?>
    <div id="r_Video_2"<?= $Page->Video_2->rowAttributes() ?>>
        <label id="elh_events_Video_2" for="x_Video_2" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Video_2->caption() ?><?= $Page->Video_2->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Video_2->cellAttributes() ?>>
<span id="el_events_Video_2">
<input type="<?= $Page->Video_2->getInputTextType() ?>" name="x_Video_2" id="x_Video_2" data-table="events" data-field="x_Video_2" value="<?= $Page->Video_2->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->Video_2->getPlaceHolder()) ?>"<?= $Page->Video_2->editAttributes() ?> aria-describedby="x_Video_2_help">
<?= $Page->Video_2->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Video_2->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Video_3->Visible) { // Video_3 ?>
    <div id="r_Video_3"<?= $Page->Video_3->rowAttributes() ?>>
        <label id="elh_events_Video_3" for="x_Video_3" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Video_3->caption() ?><?= $Page->Video_3->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Video_3->cellAttributes() ?>>
<span id="el_events_Video_3">
<input type="<?= $Page->Video_3->getInputTextType() ?>" name="x_Video_3" id="x_Video_3" data-table="events" data-field="x_Video_3" value="<?= $Page->Video_3->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->Video_3->getPlaceHolder()) ?>"<?= $Page->Video_3->editAttributes() ?> aria-describedby="x_Video_3_help">
<?= $Page->Video_3->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Video_3->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->_Title->Visible) { // Title ?>
    <div id="r__Title"<?= $Page->_Title->rowAttributes() ?>>
        <label id="elh_events__Title" for="x__Title" class="<?= $Page->LeftColumnClass ?>"><?= $Page->_Title->caption() ?><?= $Page->_Title->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->_Title->cellAttributes() ?>>
<span id="el_events__Title">
<input type="<?= $Page->_Title->getInputTextType() ?>" name="x__Title" id="x__Title" data-table="events" data-field="x__Title" value="<?= $Page->_Title->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->_Title->getPlaceHolder()) ?>"<?= $Page->_Title->editAttributes() ?> aria-describedby="x__Title_help">
<?= $Page->_Title->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->_Title->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Description->Visible) { // Description ?>
    <div id="r_Description"<?= $Page->Description->rowAttributes() ?>>
        <label id="elh_events_Description" for="x_Description" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Description->caption() ?><?= $Page->Description->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Description->cellAttributes() ?>>
<span id="el_events_Description">
<textarea data-table="events" data-field="x_Description" name="x_Description" id="x_Description" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->Description->getPlaceHolder()) ?>"<?= $Page->Description->editAttributes() ?> aria-describedby="x_Description_help"><?= $Page->Description->EditValue ?></textarea>
<?= $Page->Description->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Description->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Keywords->Visible) { // Keywords ?>
    <div id="r_Keywords"<?= $Page->Keywords->rowAttributes() ?>>
        <label id="elh_events_Keywords" for="x_Keywords" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Keywords->caption() ?><?= $Page->Keywords->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Keywords->cellAttributes() ?>>
<span id="el_events_Keywords">
<textarea data-table="events" data-field="x_Keywords" name="x_Keywords" id="x_Keywords" cols="35" rows="4" placeholder="<?= HtmlEncode($Page->Keywords->getPlaceHolder()) ?>"<?= $Page->Keywords->editAttributes() ?> aria-describedby="x_Keywords_help"><?= $Page->Keywords->EditValue ?></textarea>
<?= $Page->Keywords->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Keywords->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Active->Visible) { // Active ?>
    <div id="r_Active"<?= $Page->Active->rowAttributes() ?>>
        <label id="elh_events_Active" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Active->caption() ?><?= $Page->Active->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Active->cellAttributes() ?>>
<span id="el_events_Active">
<template id="tp_x_Active">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="events" data-field="x_Active" name="x_Active" id="x_Active"<?= $Page->Active->editAttributes() ?>>
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
    data-table="events"
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
        <label id="elh_events_Sort_Order" for="x_Sort_Order" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Sort_Order->caption() ?><?= $Page->Sort_Order->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Sort_Order->cellAttributes() ?>>
<span id="el_events_Sort_Order">
<input type="<?= $Page->Sort_Order->getInputTextType() ?>" name="x_Sort_Order" id="x_Sort_Order" data-table="events" data-field="x_Sort_Order" value="<?= $Page->Sort_Order->EditValue ?>" size="30" maxlength="11" placeholder="<?= HtmlEncode($Page->Sort_Order->getPlaceHolder()) ?>"<?= $Page->Sort_Order->editAttributes() ?> aria-describedby="x_Sort_Order_help">
<?= $Page->Sort_Order->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Sort_Order->getErrorMessage() ?></div>
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
    ew.addEventHandlers("events");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
