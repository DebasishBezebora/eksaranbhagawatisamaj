<?php

namespace PHPMaker2022\eksbs;

// Page object
$LinksSearch = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { links: currentTable } });
var currentForm, currentPageID;
var flinkssearch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object for search
    flinkssearch = new ew.Form("flinkssearch", "search");
    <?php if ($Page->IsModal) { ?>
    currentAdvancedSearchForm = flinkssearch;
    <?php } else { ?>
    currentForm = flinkssearch;
    <?php } ?>
    currentPageID = ew.PAGE_ID = "search";

    // Add fields
    var fields = currentTable.fields;
    flinkssearch.addFields([
        ["ID", [ew.Validators.integer], fields.ID.isInvalid],
        ["Link_Name", [], fields.Link_Name.isInvalid],
        ["URL_Slug", [], fields.URL_Slug.isInvalid],
        ["Link_Content", [], fields.Link_Content.isInvalid],
        ["Photos", [], fields.Photos.isInvalid],
        ["Video_1", [], fields.Video_1.isInvalid],
        ["Video_2", [], fields.Video_2.isInvalid],
        ["Video_3", [], fields.Video_3.isInvalid],
        ["_Title", [], fields._Title.isInvalid],
        ["Description", [], fields.Description.isInvalid],
        ["Keywords", [], fields.Keywords.isInvalid],
        ["Active", [], fields.Active.isInvalid],
        ["Created_AT", [ew.Validators.datetime(fields.Created_AT.clientFormatPattern)], fields.Created_AT.isInvalid],
        ["Created_BY", [], fields.Created_BY.isInvalid],
        ["IP", [], fields.IP.isInvalid]
    ]);

    // Validate form
    flinkssearch.validate = function () {
        if (!this.validateRequired)
            return true; // Ignore validation
        var fobj = this.getForm(),
            $fobj = $(fobj),
            rowIndex = "";
        $fobj.data("rowindex", rowIndex);

        // Validate fields
        if (!this.validateFields(rowIndex))
            return false;

        // Call Form_CustomValidate event
        if (!this.customValidate(fobj)) {
            this.focus();
            return false;
        }
        return true;
    }

    // Form_CustomValidate
    flinkssearch.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    flinkssearch.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    flinkssearch.lists.Active = <?= $Page->Active->toClientList($Page) ?>;
    loadjs.done("flinkssearch");
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
<form name="flinkssearch" id="flinkssearch" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="links">
<input type="hidden" name="action" id="action" value="search">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<div class="ew-search-div"><!-- page* -->
<?php if ($Page->ID->Visible) { // ID ?>
    <div id="r_ID"<?= $Page->ID->rowAttributes() ?>>
        <label for="x_ID" class="<?= $Page->LeftColumnClass ?>"><span id="elh_links_ID"><?= $Page->ID->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_ID" id="z_ID" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->ID->cellAttributes() ?>>
            <span id="el_links_ID" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->ID->getInputTextType() ?>" name="x_ID" id="x_ID" data-table="links" data-field="x_ID" value="<?= $Page->ID->EditValue ?>" maxlength="11" placeholder="<?= HtmlEncode($Page->ID->getPlaceHolder()) ?>"<?= $Page->ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->ID->getErrorMessage(false) ?></div>
</span>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->Link_Name->Visible) { // Link_Name ?>
    <div id="r_Link_Name"<?= $Page->Link_Name->rowAttributes() ?>>
        <label for="x_Link_Name" class="<?= $Page->LeftColumnClass ?>"><span id="elh_links_Link_Name"><?= $Page->Link_Name->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_Link_Name" id="z_Link_Name" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->Link_Name->cellAttributes() ?>>
            <span id="el_links_Link_Name" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->Link_Name->getInputTextType() ?>" name="x_Link_Name" id="x_Link_Name" data-table="links" data-field="x_Link_Name" value="<?= $Page->Link_Name->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->Link_Name->getPlaceHolder()) ?>"<?= $Page->Link_Name->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Link_Name->getErrorMessage(false) ?></div>
</span>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->URL_Slug->Visible) { // URL_Slug ?>
    <div id="r_URL_Slug"<?= $Page->URL_Slug->rowAttributes() ?>>
        <label for="x_URL_Slug" class="<?= $Page->LeftColumnClass ?>"><span id="elh_links_URL_Slug"><?= $Page->URL_Slug->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_URL_Slug" id="z_URL_Slug" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->URL_Slug->cellAttributes() ?>>
            <span id="el_links_URL_Slug" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->URL_Slug->getInputTextType() ?>" name="x_URL_Slug" id="x_URL_Slug" data-table="links" data-field="x_URL_Slug" value="<?= $Page->URL_Slug->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->URL_Slug->getPlaceHolder()) ?>"<?= $Page->URL_Slug->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->URL_Slug->getErrorMessage(false) ?></div>
</span>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->Link_Content->Visible) { // Link_Content ?>
    <div id="r_Link_Content"<?= $Page->Link_Content->rowAttributes() ?>>
        <label class="<?= $Page->LeftColumnClass ?>"><span id="elh_links_Link_Content"><?= $Page->Link_Content->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_Link_Content" id="z_Link_Content" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->Link_Content->cellAttributes() ?>>
            <span id="el_links_Link_Content" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->Link_Content->getInputTextType() ?>" name="x_Link_Content" id="x_Link_Content" data-table="links" data-field="x_Link_Content" value="<?= $Page->Link_Content->EditValue ?>" size="35" placeholder="<?= HtmlEncode($Page->Link_Content->getPlaceHolder()) ?>"<?= $Page->Link_Content->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Link_Content->getErrorMessage(false) ?></div>
</span>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->Photos->Visible) { // Photos ?>
    <div id="r_Photos"<?= $Page->Photos->rowAttributes() ?>>
        <label class="<?= $Page->LeftColumnClass ?>"><span id="elh_links_Photos"><?= $Page->Photos->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_Photos" id="z_Photos" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->Photos->cellAttributes() ?>>
            <span id="el_links_Photos" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->Photos->getInputTextType() ?>" name="x_Photos" id="x_Photos" data-table="links" data-field="x_Photos" value="<?= $Page->Photos->EditValue ?>" maxlength="65535" placeholder="<?= HtmlEncode($Page->Photos->getPlaceHolder()) ?>"<?= $Page->Photos->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Photos->getErrorMessage(false) ?></div>
</span>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->Video_1->Visible) { // Video_1 ?>
    <div id="r_Video_1"<?= $Page->Video_1->rowAttributes() ?>>
        <label for="x_Video_1" class="<?= $Page->LeftColumnClass ?>"><span id="elh_links_Video_1"><?= $Page->Video_1->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_Video_1" id="z_Video_1" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->Video_1->cellAttributes() ?>>
            <span id="el_links_Video_1" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->Video_1->getInputTextType() ?>" name="x_Video_1" id="x_Video_1" data-table="links" data-field="x_Video_1" value="<?= $Page->Video_1->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->Video_1->getPlaceHolder()) ?>"<?= $Page->Video_1->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Video_1->getErrorMessage(false) ?></div>
</span>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->Video_2->Visible) { // Video_2 ?>
    <div id="r_Video_2"<?= $Page->Video_2->rowAttributes() ?>>
        <label for="x_Video_2" class="<?= $Page->LeftColumnClass ?>"><span id="elh_links_Video_2"><?= $Page->Video_2->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_Video_2" id="z_Video_2" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->Video_2->cellAttributes() ?>>
            <span id="el_links_Video_2" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->Video_2->getInputTextType() ?>" name="x_Video_2" id="x_Video_2" data-table="links" data-field="x_Video_2" value="<?= $Page->Video_2->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->Video_2->getPlaceHolder()) ?>"<?= $Page->Video_2->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Video_2->getErrorMessage(false) ?></div>
</span>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->Video_3->Visible) { // Video_3 ?>
    <div id="r_Video_3"<?= $Page->Video_3->rowAttributes() ?>>
        <label for="x_Video_3" class="<?= $Page->LeftColumnClass ?>"><span id="elh_links_Video_3"><?= $Page->Video_3->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_Video_3" id="z_Video_3" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->Video_3->cellAttributes() ?>>
            <span id="el_links_Video_3" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->Video_3->getInputTextType() ?>" name="x_Video_3" id="x_Video_3" data-table="links" data-field="x_Video_3" value="<?= $Page->Video_3->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->Video_3->getPlaceHolder()) ?>"<?= $Page->Video_3->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Video_3->getErrorMessage(false) ?></div>
</span>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->_Title->Visible) { // Title ?>
    <div id="r__Title"<?= $Page->_Title->rowAttributes() ?>>
        <label for="x__Title" class="<?= $Page->LeftColumnClass ?>"><span id="elh_links__Title"><?= $Page->_Title->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z__Title" id="z__Title" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->_Title->cellAttributes() ?>>
            <span id="el_links__Title" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->_Title->getInputTextType() ?>" name="x__Title" id="x__Title" data-table="links" data-field="x__Title" value="<?= $Page->_Title->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->_Title->getPlaceHolder()) ?>"<?= $Page->_Title->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->_Title->getErrorMessage(false) ?></div>
</span>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->Description->Visible) { // Description ?>
    <div id="r_Description"<?= $Page->Description->rowAttributes() ?>>
        <label for="x_Description" class="<?= $Page->LeftColumnClass ?>"><span id="elh_links_Description"><?= $Page->Description->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_Description" id="z_Description" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->Description->cellAttributes() ?>>
            <span id="el_links_Description" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->Description->getInputTextType() ?>" name="x_Description" id="x_Description" data-table="links" data-field="x_Description" value="<?= $Page->Description->EditValue ?>" size="35" maxlength="65535" placeholder="<?= HtmlEncode($Page->Description->getPlaceHolder()) ?>"<?= $Page->Description->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Description->getErrorMessage(false) ?></div>
</span>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->Keywords->Visible) { // Keywords ?>
    <div id="r_Keywords"<?= $Page->Keywords->rowAttributes() ?>>
        <label for="x_Keywords" class="<?= $Page->LeftColumnClass ?>"><span id="elh_links_Keywords"><?= $Page->Keywords->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_Keywords" id="z_Keywords" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->Keywords->cellAttributes() ?>>
            <span id="el_links_Keywords" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->Keywords->getInputTextType() ?>" name="x_Keywords" id="x_Keywords" data-table="links" data-field="x_Keywords" value="<?= $Page->Keywords->EditValue ?>" size="35" maxlength="65535" placeholder="<?= HtmlEncode($Page->Keywords->getPlaceHolder()) ?>"<?= $Page->Keywords->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Keywords->getErrorMessage(false) ?></div>
</span>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->Active->Visible) { // Active ?>
    <div id="r_Active"<?= $Page->Active->rowAttributes() ?>>
        <label class="<?= $Page->LeftColumnClass ?>"><span id="elh_links_Active"><?= $Page->Active->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_Active" id="z_Active" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->Active->cellAttributes() ?>>
            <span id="el_links_Active" class="ew-search-field ew-search-field-single">
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
    value="<?= HtmlEncode($Page->Active->AdvancedSearch->SearchValue) ?>"
    data-type="select-one"
    data-template="tp_x_Active"
    data-bs-target="dsl_x_Active"
    data-repeatcolumn="5"
    class="form-control<?= $Page->Active->isInvalidClass() ?>"
    data-table="links"
    data-field="x_Active"
    data-value-separator="<?= $Page->Active->displayValueSeparatorAttribute() ?>"
    <?= $Page->Active->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Page->Active->getErrorMessage(false) ?></div>
</span>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->Created_AT->Visible) { // Created_AT ?>
    <div id="r_Created_AT"<?= $Page->Created_AT->rowAttributes() ?>>
        <label for="x_Created_AT" class="<?= $Page->LeftColumnClass ?>"><span id="elh_links_Created_AT"><?= $Page->Created_AT->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_Created_AT" id="z_Created_AT" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->Created_AT->cellAttributes() ?>>
            <span id="el_links_Created_AT" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->Created_AT->getInputTextType() ?>" name="x_Created_AT" id="x_Created_AT" data-table="links" data-field="x_Created_AT" value="<?= $Page->Created_AT->EditValue ?>" maxlength="19" placeholder="<?= HtmlEncode($Page->Created_AT->getPlaceHolder()) ?>"<?= $Page->Created_AT->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Created_AT->getErrorMessage(false) ?></div>
<?php if (!$Page->Created_AT->ReadOnly && !$Page->Created_AT->Disabled && !isset($Page->Created_AT->EditAttrs["readonly"]) && !isset($Page->Created_AT->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["flinkssearch", "datetimepicker"], function () {
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
    ew.createDateTimePicker("flinkssearch", "x_Created_AT", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->Created_BY->Visible) { // Created_BY ?>
    <div id="r_Created_BY"<?= $Page->Created_BY->rowAttributes() ?>>
        <label for="x_Created_BY" class="<?= $Page->LeftColumnClass ?>"><span id="elh_links_Created_BY"><?= $Page->Created_BY->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_Created_BY" id="z_Created_BY" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->Created_BY->cellAttributes() ?>>
            <span id="el_links_Created_BY" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->Created_BY->getInputTextType() ?>" name="x_Created_BY" id="x_Created_BY" data-table="links" data-field="x_Created_BY" value="<?= $Page->Created_BY->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->Created_BY->getPlaceHolder()) ?>"<?= $Page->Created_BY->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Created_BY->getErrorMessage(false) ?></div>
</span>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->IP->Visible) { // IP ?>
    <div id="r_IP"<?= $Page->IP->rowAttributes() ?>>
        <label for="x_IP" class="<?= $Page->LeftColumnClass ?>"><span id="elh_links_IP"><?= $Page->IP->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_IP" id="z_IP" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->IP->cellAttributes() ?>>
            <span id="el_links_IP" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->IP->getInputTextType() ?>" name="x_IP" id="x_IP" data-table="links" data-field="x_IP" value="<?= $Page->IP->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->IP->getPlaceHolder()) ?>"<?= $Page->IP->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->IP->getErrorMessage(false) ?></div>
</span>
            </div>
        </div>
    </div>
<?php } ?>
</div><!-- /page* -->
<?php if (!$Page->IsModal) { ?>
<div class="row"><!-- buttons .row -->
    <div class="<?= $Page->OffsetColumnClass ?>"><!-- buttons offset -->
        <button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("Search") ?></button>
        <button class="btn btn-default ew-btn" name="btn-reset" id="btn-reset" type="button" data-ew-action="reload"><?= $Language->phrase("Reset") ?></button>
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
