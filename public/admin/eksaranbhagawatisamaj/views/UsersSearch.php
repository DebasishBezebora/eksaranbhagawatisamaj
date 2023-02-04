<?php

namespace PHPMaker2022\eksbs;

// Page object
$UsersSearch = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { users: currentTable } });
var currentForm, currentPageID;
var fuserssearch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object for search
    fuserssearch = new ew.Form("fuserssearch", "search");
    <?php if ($Page->IsModal) { ?>
    currentAdvancedSearchForm = fuserssearch;
    <?php } else { ?>
    currentForm = fuserssearch;
    <?php } ?>
    currentPageID = ew.PAGE_ID = "search";

    // Add fields
    var fields = currentTable.fields;
    fuserssearch.addFields([
        ["ID", [ew.Validators.integer], fields.ID.isInvalid],
        ["_Username", [], fields._Username.isInvalid],
        ["_Password", [], fields._Password.isInvalid],
        ["Name", [], fields.Name.isInvalid],
        ["Mobile", [], fields.Mobile.isInvalid],
        ["_Email", [], fields._Email.isInvalid],
        ["User_Level", [], fields.User_Level.isInvalid],
        ["Status", [], fields.Status.isInvalid],
        ["Created_BY", [], fields.Created_BY.isInvalid],
        ["Created_AT", [ew.Validators.datetime(fields.Created_AT.clientFormatPattern)], fields.Created_AT.isInvalid],
        ["IP", [], fields.IP.isInvalid],
        ["_Profile", [], fields._Profile.isInvalid]
    ]);

    // Validate form
    fuserssearch.validate = function () {
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
    fuserssearch.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fuserssearch.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    fuserssearch.lists.User_Level = <?= $Page->User_Level->toClientList($Page) ?>;
    fuserssearch.lists.Status = <?= $Page->Status->toClientList($Page) ?>;
    loadjs.done("fuserssearch");
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
<form name="fuserssearch" id="fuserssearch" class="<?= $Page->FormClassName ?>" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="users">
<input type="hidden" name="action" id="action" value="search">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<div class="ew-search-div"><!-- page* -->
<?php if ($Page->ID->Visible) { // ID ?>
    <div id="r_ID"<?= $Page->ID->rowAttributes() ?>>
        <label for="x_ID" class="<?= $Page->LeftColumnClass ?>"><span id="elh_users_ID"><?= $Page->ID->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_ID" id="z_ID" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->ID->cellAttributes() ?>>
            <span id="el_users_ID" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->ID->getInputTextType() ?>" name="x_ID" id="x_ID" data-table="users" data-field="x_ID" value="<?= $Page->ID->EditValue ?>" maxlength="11" placeholder="<?= HtmlEncode($Page->ID->getPlaceHolder()) ?>"<?= $Page->ID->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->ID->getErrorMessage(false) ?></div>
</span>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->_Username->Visible) { // Username ?>
    <div id="r__Username"<?= $Page->_Username->rowAttributes() ?>>
        <label for="x__Username" class="<?= $Page->LeftColumnClass ?>"><span id="elh_users__Username"><?= $Page->_Username->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z__Username" id="z__Username" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->_Username->cellAttributes() ?>>
            <span id="el_users__Username" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->_Username->getInputTextType() ?>" name="x__Username" id="x__Username" data-table="users" data-field="x__Username" value="<?= $Page->_Username->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->_Username->getPlaceHolder()) ?>"<?= $Page->_Username->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->_Username->getErrorMessage(false) ?></div>
</span>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->_Password->Visible) { // Password ?>
    <div id="r__Password"<?= $Page->_Password->rowAttributes() ?>>
        <label for="x__Password" class="<?= $Page->LeftColumnClass ?>"><span id="elh_users__Password"><?= $Page->_Password->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z__Password" id="z__Password" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->_Password->cellAttributes() ?>>
            <span id="el_users__Password" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->_Password->getInputTextType() ?>" name="x__Password" id="x__Password" data-table="users" data-field="x__Password" value="<?= $Page->_Password->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->_Password->getPlaceHolder()) ?>"<?= $Page->_Password->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->_Password->getErrorMessage(false) ?></div>
</span>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->Name->Visible) { // Name ?>
    <div id="r_Name"<?= $Page->Name->rowAttributes() ?>>
        <label for="x_Name" class="<?= $Page->LeftColumnClass ?>"><span id="elh_users_Name"><?= $Page->Name->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_Name" id="z_Name" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->Name->cellAttributes() ?>>
            <span id="el_users_Name" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->Name->getInputTextType() ?>" name="x_Name" id="x_Name" data-table="users" data-field="x_Name" value="<?= $Page->Name->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->Name->getPlaceHolder()) ?>"<?= $Page->Name->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Name->getErrorMessage(false) ?></div>
</span>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->Mobile->Visible) { // Mobile ?>
    <div id="r_Mobile"<?= $Page->Mobile->rowAttributes() ?>>
        <label for="x_Mobile" class="<?= $Page->LeftColumnClass ?>"><span id="elh_users_Mobile"><?= $Page->Mobile->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_Mobile" id="z_Mobile" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->Mobile->cellAttributes() ?>>
            <span id="el_users_Mobile" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->Mobile->getInputTextType() ?>" name="x_Mobile" id="x_Mobile" data-table="users" data-field="x_Mobile" value="<?= $Page->Mobile->EditValue ?>" size="30" maxlength="10" placeholder="<?= HtmlEncode($Page->Mobile->getPlaceHolder()) ?>"<?= $Page->Mobile->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Mobile->getErrorMessage(false) ?></div>
</span>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->_Email->Visible) { // Email ?>
    <div id="r__Email"<?= $Page->_Email->rowAttributes() ?>>
        <label for="x__Email" class="<?= $Page->LeftColumnClass ?>"><span id="elh_users__Email"><?= $Page->_Email->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z__Email" id="z__Email" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->_Email->cellAttributes() ?>>
            <span id="el_users__Email" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->_Email->getInputTextType() ?>" name="x__Email" id="x__Email" data-table="users" data-field="x__Email" value="<?= $Page->_Email->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->_Email->getPlaceHolder()) ?>"<?= $Page->_Email->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->_Email->getErrorMessage(false) ?></div>
</span>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->User_Level->Visible) { // User_Level ?>
    <div id="r_User_Level"<?= $Page->User_Level->rowAttributes() ?>>
        <label for="x_User_Level" class="<?= $Page->LeftColumnClass ?>"><span id="elh_users_User_Level"><?= $Page->User_Level->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_User_Level" id="z_User_Level" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->User_Level->cellAttributes() ?>>
            <span id="el_users_User_Level" class="ew-search-field ew-search-field-single">
<?php if (!$Security->isAdmin() && $Security->isLoggedIn()) { // Non system admin ?>
<span class="form-control-plaintext"><?= $Page->User_Level->getDisplayValue($Page->User_Level->EditValue) ?></span>
<?php } else { ?>
    <select
        id="x_User_Level"
        name="x_User_Level"
        class="form-select ew-select<?= $Page->User_Level->isInvalidClass() ?>"
        data-select2-id="fuserssearch_x_User_Level"
        data-table="users"
        data-field="x_User_Level"
        data-value-separator="<?= $Page->User_Level->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->User_Level->getPlaceHolder()) ?>"
        <?= $Page->User_Level->editAttributes() ?>>
        <?= $Page->User_Level->selectOptionListHtml("x_User_Level") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->User_Level->getErrorMessage(false) ?></div>
<?= $Page->User_Level->Lookup->getParamTag($Page, "p_x_User_Level") ?>
<script>
loadjs.ready("fuserssearch", function() {
    var options = { name: "x_User_Level", selectId: "fuserssearch_x_User_Level" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fuserssearch.lists.User_Level.lookupOptions.length) {
        options.data = { id: "x_User_Level", form: "fuserssearch" };
    } else {
        options.ajax = { id: "x_User_Level", form: "fuserssearch", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.users.fields.User_Level.selectOptions);
    ew.createSelect(options);
});
</script>
<?php } ?>
</span>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->Status->Visible) { // Status ?>
    <div id="r_Status"<?= $Page->Status->rowAttributes() ?>>
        <label class="<?= $Page->LeftColumnClass ?>"><span id="elh_users_Status"><?= $Page->Status->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_Status" id="z_Status" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->Status->cellAttributes() ?>>
            <span id="el_users_Status" class="ew-search-field ew-search-field-single">
<template id="tp_x_Status">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="users" data-field="x_Status" name="x_Status" id="x_Status"<?= $Page->Status->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x_Status" class="ew-item-list"></div>
<selection-list hidden
    id="x_Status"
    name="x_Status"
    value="<?= HtmlEncode($Page->Status->AdvancedSearch->SearchValue) ?>"
    data-type="select-one"
    data-template="tp_x_Status"
    data-bs-target="dsl_x_Status"
    data-repeatcolumn="5"
    class="form-control<?= $Page->Status->isInvalidClass() ?>"
    data-table="users"
    data-field="x_Status"
    data-value-separator="<?= $Page->Status->displayValueSeparatorAttribute() ?>"
    <?= $Page->Status->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Page->Status->getErrorMessage(false) ?></div>
</span>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->Created_BY->Visible) { // Created_BY ?>
    <div id="r_Created_BY"<?= $Page->Created_BY->rowAttributes() ?>>
        <label for="x_Created_BY" class="<?= $Page->LeftColumnClass ?>"><span id="elh_users_Created_BY"><?= $Page->Created_BY->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_Created_BY" id="z_Created_BY" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->Created_BY->cellAttributes() ?>>
            <span id="el_users_Created_BY" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->Created_BY->getInputTextType() ?>" name="x_Created_BY" id="x_Created_BY" data-table="users" data-field="x_Created_BY" value="<?= $Page->Created_BY->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->Created_BY->getPlaceHolder()) ?>"<?= $Page->Created_BY->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Created_BY->getErrorMessage(false) ?></div>
</span>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->Created_AT->Visible) { // Created_AT ?>
    <div id="r_Created_AT"<?= $Page->Created_AT->rowAttributes() ?>>
        <label for="x_Created_AT" class="<?= $Page->LeftColumnClass ?>"><span id="elh_users_Created_AT"><?= $Page->Created_AT->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("=") ?>
<input type="hidden" name="z_Created_AT" id="z_Created_AT" value="=">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->Created_AT->cellAttributes() ?>>
            <span id="el_users_Created_AT" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->Created_AT->getInputTextType() ?>" name="x_Created_AT" id="x_Created_AT" data-table="users" data-field="x_Created_AT" value="<?= $Page->Created_AT->EditValue ?>" maxlength="19" placeholder="<?= HtmlEncode($Page->Created_AT->getPlaceHolder()) ?>"<?= $Page->Created_AT->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Created_AT->getErrorMessage(false) ?></div>
<?php if (!$Page->Created_AT->ReadOnly && !$Page->Created_AT->Disabled && !isset($Page->Created_AT->EditAttrs["readonly"]) && !isset($Page->Created_AT->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["fuserssearch", "datetimepicker"], function () {
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
    ew.createDateTimePicker("fuserssearch", "x_Created_AT", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->IP->Visible) { // IP ?>
    <div id="r_IP"<?= $Page->IP->rowAttributes() ?>>
        <label for="x_IP" class="<?= $Page->LeftColumnClass ?>"><span id="elh_users_IP"><?= $Page->IP->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z_IP" id="z_IP" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->IP->cellAttributes() ?>>
            <span id="el_users_IP" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->IP->getInputTextType() ?>" name="x_IP" id="x_IP" data-table="users" data-field="x_IP" value="<?= $Page->IP->EditValue ?>" size="30" maxlength="50" placeholder="<?= HtmlEncode($Page->IP->getPlaceHolder()) ?>"<?= $Page->IP->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->IP->getErrorMessage(false) ?></div>
</span>
            </div>
        </div>
    </div>
<?php } ?>
<?php if ($Page->_Profile->Visible) { // Profile ?>
    <div id="r__Profile"<?= $Page->_Profile->rowAttributes() ?>>
        <label for="x__Profile" class="<?= $Page->LeftColumnClass ?>"><span id="elh_users__Profile"><?= $Page->_Profile->caption() ?></span>
        <span class="ew-search-operator">
<?= $Language->phrase("LIKE") ?>
<input type="hidden" name="z__Profile" id="z__Profile" value="LIKE">
</span>
        </label>
        <div class="<?= $Page->RightColumnClass ?>">
            <div<?= $Page->_Profile->cellAttributes() ?>>
            <span id="el_users__Profile" class="ew-search-field ew-search-field-single">
<input type="<?= $Page->_Profile->getInputTextType() ?>" name="x__Profile" id="x__Profile" data-table="users" data-field="x__Profile" value="<?= $Page->_Profile->EditValue ?>" size="35" placeholder="<?= HtmlEncode($Page->_Profile->getPlaceHolder()) ?>"<?= $Page->_Profile->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->_Profile->getErrorMessage(false) ?></div>
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
    ew.addEventHandlers("users");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
