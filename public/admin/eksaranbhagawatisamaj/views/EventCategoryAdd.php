<?php

namespace PHPMaker2022\eksbs;

// Page object
$EventCategoryAdd = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { event_category: currentTable } });
var currentForm, currentPageID;
var fevent_categoryadd;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fevent_categoryadd = new ew.Form("fevent_categoryadd", "add");
    currentPageID = ew.PAGE_ID = "add";
    currentForm = fevent_categoryadd;

    // Add fields
    var fields = currentTable.fields;
    fevent_categoryadd.addFields([
        ["Category", [fields.Category.visible && fields.Category.required ? ew.Validators.required(fields.Category.caption) : null], fields.Category.isInvalid],
        ["Active", [fields.Active.visible && fields.Active.required ? ew.Validators.required(fields.Active.caption) : null], fields.Active.isInvalid],
        ["Created_BY", [fields.Created_BY.visible && fields.Created_BY.required ? ew.Validators.required(fields.Created_BY.caption) : null], fields.Created_BY.isInvalid],
        ["Created_AT", [fields.Created_AT.visible && fields.Created_AT.required ? ew.Validators.required(fields.Created_AT.caption) : null], fields.Created_AT.isInvalid],
        ["IP", [fields.IP.visible && fields.IP.required ? ew.Validators.required(fields.IP.caption) : null], fields.IP.isInvalid]
    ]);

    // Form_CustomValidate
    fevent_categoryadd.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fevent_categoryadd.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    fevent_categoryadd.lists.Active = <?= $Page->Active->toClientList($Page) ?>;
    loadjs.done("fevent_categoryadd");
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
<form name="fevent_categoryadd" id="fevent_categoryadd" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="event_category">
<input type="hidden" name="action" id="action" value="insert">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<input type="hidden" name="<?= $Page->OldKeyName ?>" value="<?= $Page->OldKey ?>">
<div class="ew-add-div"><!-- page* -->
<?php if ($Page->Category->Visible) { // Category ?>
    <div id="r_Category"<?= $Page->Category->rowAttributes() ?>>
        <label id="elh_event_category_Category" for="x_Category" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Category->caption() ?><?= $Page->Category->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Category->cellAttributes() ?>>
<span id="el_event_category_Category">
<input type="<?= $Page->Category->getInputTextType() ?>" name="x_Category" id="x_Category" data-table="event_category" data-field="x_Category" value="<?= $Page->Category->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->Category->getPlaceHolder()) ?>"<?= $Page->Category->editAttributes() ?> aria-describedby="x_Category_help">
<?= $Page->Category->getCustomMessage() ?>
<div class="invalid-feedback"><?= $Page->Category->getErrorMessage() ?></div>
</span>
</div></div>
    </div>
<?php } ?>
<?php if ($Page->Active->Visible) { // Active ?>
    <div id="r_Active"<?= $Page->Active->rowAttributes() ?>>
        <label id="elh_event_category_Active" class="<?= $Page->LeftColumnClass ?>"><?= $Page->Active->caption() ?><?= $Page->Active->Required ? $Language->phrase("FieldRequiredIndicator") : "" ?></label>
        <div class="<?= $Page->RightColumnClass ?>"><div<?= $Page->Active->cellAttributes() ?>>
<span id="el_event_category_Active">
<template id="tp_x_Active">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="event_category" data-field="x_Active" name="x_Active" id="x_Active"<?= $Page->Active->editAttributes() ?>>
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
    data-table="event_category"
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
    ew.addEventHandlers("event_category");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
