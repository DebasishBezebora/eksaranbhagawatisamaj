<?php

namespace PHPMaker2022\eksbs;

// Page object
$UsersList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { users: currentTable } });
var currentForm, currentPageID;
var fuserslist;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fuserslist = new ew.Form("fuserslist", "list");
    currentPageID = ew.PAGE_ID = "list";
    currentForm = fuserslist;
    fuserslist.formKeyCountName = "<?= $Page->FormKeyCountName ?>";

    // Add fields
    var fields = currentTable.fields;
    fuserslist.addFields([
        ["ID", [fields.ID.visible && fields.ID.required ? ew.Validators.required(fields.ID.caption) : null], fields.ID.isInvalid],
        ["_Username", [fields._Username.visible && fields._Username.required ? ew.Validators.required(fields._Username.caption) : null], fields._Username.isInvalid],
        ["_Password", [fields._Password.visible && fields._Password.required ? ew.Validators.required(fields._Password.caption) : null], fields._Password.isInvalid],
        ["Name", [fields.Name.visible && fields.Name.required ? ew.Validators.required(fields.Name.caption) : null], fields.Name.isInvalid],
        ["Mobile", [fields.Mobile.visible && fields.Mobile.required ? ew.Validators.required(fields.Mobile.caption) : null], fields.Mobile.isInvalid],
        ["_Email", [fields._Email.visible && fields._Email.required ? ew.Validators.required(fields._Email.caption) : null, ew.Validators.email], fields._Email.isInvalid],
        ["User_Level", [fields.User_Level.visible && fields.User_Level.required ? ew.Validators.required(fields.User_Level.caption) : null], fields.User_Level.isInvalid],
        ["Status", [fields.Status.visible && fields.Status.required ? ew.Validators.required(fields.Status.caption) : null], fields.Status.isInvalid],
        ["Created_BY", [fields.Created_BY.visible && fields.Created_BY.required ? ew.Validators.required(fields.Created_BY.caption) : null], fields.Created_BY.isInvalid],
        ["Created_AT", [fields.Created_AT.visible && fields.Created_AT.required ? ew.Validators.required(fields.Created_AT.caption) : null], fields.Created_AT.isInvalid],
        ["IP", [fields.IP.visible && fields.IP.required ? ew.Validators.required(fields.IP.caption) : null], fields.IP.isInvalid]
    ]);

    // Check empty row
    fuserslist.emptyRow = function (rowIndex) {
        var fobj = this.getForm(),
            fields = [["_Username",false],["_Password",false],["Name",false],["Mobile",false],["_Email",false],["User_Level",false],["Status",false]];
        if (fields.some(field => ew.valueChanged(fobj, rowIndex, ...field)))
            return false;
        return true;
    }

    // Form_CustomValidate
    fuserslist.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fuserslist.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    fuserslist.lists.User_Level = <?= $Page->User_Level->toClientList($Page) ?>;
    fuserslist.lists.Status = <?= $Page->Status->toClientList($Page) ?>;
    loadjs.done("fuserslist");
});
var fuserssrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object for search
    fuserssrch = new ew.Form("fuserssrch", "list");
    currentSearchForm = fuserssrch;

    // Dynamic selection lists

    // Filters
    fuserssrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("fuserssrch");
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
<?php if ($Page->TotalRecords > 0 && $Page->ExportOptions->visible()) { ?>
<?php $Page->ExportOptions->render("body") ?>
<?php } ?>
<?php if ($Page->ImportOptions->visible()) { ?>
<?php $Page->ImportOptions->render("body") ?>
<?php } ?>
<?php if ($Page->SearchOptions->visible()) { ?>
<?php $Page->SearchOptions->render("body") ?>
<?php } ?>
<?php if ($Page->FilterOptions->visible()) { ?>
<?php $Page->FilterOptions->render("body") ?>
<?php } ?>
</div>
<?php } ?>
<?php
$Page->renderOtherOptions();
?>
<?php if ($Security->canSearch()) { ?>
<?php if (!$Page->isExport() && !$Page->CurrentAction && $Page->hasSearchFields()) { ?>
<form name="fuserssrch" id="fuserssrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>">
<div id="fuserssrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="users">
<div class="ew-extended-search container-fluid">
<div class="row mb-0">
    <div class="col-sm-auto px-0 pe-sm-2">
        <div class="ew-basic-search input-group">
            <input type="search" name="<?= Config("TABLE_BASIC_SEARCH") ?>" id="<?= Config("TABLE_BASIC_SEARCH") ?>" class="form-control ew-basic-search-keyword" value="<?= HtmlEncode($Page->BasicSearch->getKeyword()) ?>" placeholder="<?= HtmlEncode($Language->phrase("Search")) ?>" aria-label="<?= HtmlEncode($Language->phrase("Search")) ?>">
            <input type="hidden" name="<?= Config("TABLE_BASIC_SEARCH_TYPE") ?>" id="<?= Config("TABLE_BASIC_SEARCH_TYPE") ?>" class="ew-basic-search-type" value="<?= HtmlEncode($Page->BasicSearch->getType()) ?>">
            <button type="button" data-bs-toggle="dropdown" class="btn btn-outline-secondary dropdown-toggle dropdown-toggle-split" aria-haspopup="true" aria-expanded="false">
                <span id="searchtype"><?= $Page->BasicSearch->getTypeNameShort() ?></span>
            </button>
            <div class="dropdown-menu dropdown-menu-end">
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "" ? " active" : "" ?>" form="fuserssrch" data-ew-action="search-type"><?= $Language->phrase("QuickSearchAuto") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "=" ? " active" : "" ?>" form="fuserssrch" data-ew-action="search-type" data-search-type="="><?= $Language->phrase("QuickSearchExact") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "AND" ? " active" : "" ?>" form="fuserssrch" data-ew-action="search-type" data-search-type="AND"><?= $Language->phrase("QuickSearchAll") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "OR" ? " active" : "" ?>" form="fuserssrch" data-ew-action="search-type" data-search-type="OR"><?= $Language->phrase("QuickSearchAny") ?></button>
            </div>
        </div>
    </div>
    <div class="col-sm-auto mb-3">
        <button class="btn btn-primary" name="btn-submit" id="btn-submit" type="submit"><?= $Language->phrase("SearchBtn") ?></button>
    </div>
</div>
</div><!-- /.ew-extended-search -->
</div><!-- /.ew-search-panel -->
</form>
<?php } ?>
<?php } ?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<?php if ($Page->TotalRecords > 0 || $Page->CurrentAction) { ?>
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> users">
<?php if (!$Page->isExport()) { ?>
<div class="card-header ew-grid-upper-panel">
<?php if (!$Page->isGridAdd()) { ?>
<form name="ew-pager-form" class="ew-form ew-pager-form" action="<?= CurrentPageUrl(false) ?>">
<?= $Page->Pager->render() ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $Page->OtherOptions->render("body") ?>
</div>
</div>
<?php } ?>
<form name="fuserslist" id="fuserslist" class="ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="users">
<div id="gmp_users" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_userslist" class="table table-bordered table-hover table-sm ew-table"><!-- .ew-table -->
<thead>
    <tr class="ew-table-header">
<?php
// Header row
$Page->RowType = ROWTYPE_HEADER;

// Render list options
$Page->renderListOptions();

// Render list options (header, left)
$Page->ListOptions->render("header", "left");
?>
<?php if ($Page->ID->Visible) { // ID ?>
        <th data-name="ID" class="<?= $Page->ID->headerCellClass() ?>"><div id="elh_users_ID" class="users_ID"><?= $Page->renderFieldHeader($Page->ID) ?></div></th>
<?php } ?>
<?php if ($Page->_Username->Visible) { // Username ?>
        <th data-name="_Username" class="<?= $Page->_Username->headerCellClass() ?>"><div id="elh_users__Username" class="users__Username"><?= $Page->renderFieldHeader($Page->_Username) ?></div></th>
<?php } ?>
<?php if ($Page->_Password->Visible) { // Password ?>
        <th data-name="_Password" class="<?= $Page->_Password->headerCellClass() ?>"><div id="elh_users__Password" class="users__Password"><?= $Page->renderFieldHeader($Page->_Password) ?></div></th>
<?php } ?>
<?php if ($Page->Name->Visible) { // Name ?>
        <th data-name="Name" class="<?= $Page->Name->headerCellClass() ?>"><div id="elh_users_Name" class="users_Name"><?= $Page->renderFieldHeader($Page->Name) ?></div></th>
<?php } ?>
<?php if ($Page->Mobile->Visible) { // Mobile ?>
        <th data-name="Mobile" class="<?= $Page->Mobile->headerCellClass() ?>"><div id="elh_users_Mobile" class="users_Mobile"><?= $Page->renderFieldHeader($Page->Mobile) ?></div></th>
<?php } ?>
<?php if ($Page->_Email->Visible) { // Email ?>
        <th data-name="_Email" class="<?= $Page->_Email->headerCellClass() ?>"><div id="elh_users__Email" class="users__Email"><?= $Page->renderFieldHeader($Page->_Email) ?></div></th>
<?php } ?>
<?php if ($Page->User_Level->Visible) { // User_Level ?>
        <th data-name="User_Level" class="<?= $Page->User_Level->headerCellClass() ?>"><div id="elh_users_User_Level" class="users_User_Level"><?= $Page->renderFieldHeader($Page->User_Level) ?></div></th>
<?php } ?>
<?php if ($Page->Status->Visible) { // Status ?>
        <th data-name="Status" class="<?= $Page->Status->headerCellClass() ?>"><div id="elh_users_Status" class="users_Status"><?= $Page->renderFieldHeader($Page->Status) ?></div></th>
<?php } ?>
<?php if ($Page->Created_BY->Visible) { // Created_BY ?>
        <th data-name="Created_BY" class="<?= $Page->Created_BY->headerCellClass() ?>"><div id="elh_users_Created_BY" class="users_Created_BY"><?= $Page->renderFieldHeader($Page->Created_BY) ?></div></th>
<?php } ?>
<?php if ($Page->Created_AT->Visible) { // Created_AT ?>
        <th data-name="Created_AT" class="<?= $Page->Created_AT->headerCellClass() ?>"><div id="elh_users_Created_AT" class="users_Created_AT"><?= $Page->renderFieldHeader($Page->Created_AT) ?></div></th>
<?php } ?>
<?php if ($Page->IP->Visible) { // IP ?>
        <th data-name="IP" class="<?= $Page->IP->headerCellClass() ?>"><div id="elh_users_IP" class="users_IP"><?= $Page->renderFieldHeader($Page->IP) ?></div></th>
<?php } ?>
<?php
// Render list options (header, right)
$Page->ListOptions->render("header", "right");
?>
    </tr>
</thead>
<tbody>
<?php
if ($Page->ExportAll && $Page->isExport()) {
    $Page->StopRecord = $Page->TotalRecords;
} else {
    // Set the last record to display
    if ($Page->TotalRecords > $Page->StartRecord + $Page->DisplayRecords - 1) {
        $Page->StopRecord = $Page->StartRecord + $Page->DisplayRecords - 1;
    } else {
        $Page->StopRecord = $Page->TotalRecords;
    }
}

// Restore number of post back records
if ($CurrentForm && ($Page->isConfirm() || $Page->EventCancelled)) {
    $CurrentForm->Index = -1;
    if ($CurrentForm->hasValue($Page->FormKeyCountName) && ($Page->isGridAdd() || $Page->isGridEdit() || $Page->isConfirm())) {
        $Page->KeyCount = $CurrentForm->getValue($Page->FormKeyCountName);
        $Page->StopRecord = $Page->StartRecord + $Page->KeyCount - 1;
    }
}
$Page->RecordCount = $Page->StartRecord - 1;
if ($Page->Recordset && !$Page->Recordset->EOF) {
    // Nothing to do
} elseif ($Page->isGridAdd() && !$Page->AllowAddDeleteRow && $Page->StopRecord == 0) {
    $Page->StopRecord = $Page->GridAddRowCount;
}

// Initialize aggregate
$Page->RowType = ROWTYPE_AGGREGATEINIT;
$Page->resetAttributes();
$Page->renderRow();
while ($Page->RecordCount < $Page->StopRecord) {
    $Page->RecordCount++;
    if ($Page->RecordCount >= $Page->StartRecord) {
        $Page->RowCount++;
        if ($Page->isAdd() || $Page->isGridAdd() || $Page->isGridEdit() || $Page->isConfirm()) {
            $Page->RowIndex++;
            $CurrentForm->Index = $Page->RowIndex;
            if ($CurrentForm->hasValue($Page->FormActionName) && ($Page->isConfirm() || $Page->EventCancelled)) {
                $Page->RowAction = strval($CurrentForm->getValue($Page->FormActionName));
            } elseif ($Page->isGridAdd()) {
                $Page->RowAction = "insert";
            } else {
                $Page->RowAction = "";
            }
        }

        // Set up key count
        $Page->KeyCount = $Page->RowIndex;

        // Init row class and style
        $Page->resetAttributes();
        $Page->CssClass = "";
        if ($Page->isGridAdd()) {
            $Page->loadRowValues(); // Load default values
            $Page->OldKey = "";
            $Page->setKey($Page->OldKey);
        } else {
            $Page->loadRowValues($Page->Recordset); // Load row values
            if ($Page->isGridEdit()) {
                $Page->OldKey = $Page->getKey(true); // Get from CurrentValue
                $Page->setKey($Page->OldKey);
            }
        }
        $Page->RowType = ROWTYPE_VIEW; // Render view
        if ($Page->isGridAdd()) { // Grid add
            $Page->RowType = ROWTYPE_ADD; // Render add
        }
        if ($Page->isGridAdd() && $Page->EventCancelled && !$CurrentForm->hasValue("k_blankrow")) { // Insert failed
            $Page->restoreCurrentRowFormValues($Page->RowIndex); // Restore form values
        }
        if ($Page->isGridEdit()) { // Grid edit
            if ($Page->EventCancelled) {
                $Page->restoreCurrentRowFormValues($Page->RowIndex); // Restore form values
            }
            if ($Page->RowAction == "insert") {
                $Page->RowType = ROWTYPE_ADD; // Render add
            } else {
                $Page->RowType = ROWTYPE_EDIT; // Render edit
            }
        }
        if ($Page->isGridEdit() && ($Page->RowType == ROWTYPE_EDIT || $Page->RowType == ROWTYPE_ADD) && $Page->EventCancelled) { // Update failed
            $Page->restoreCurrentRowFormValues($Page->RowIndex); // Restore form values
        }
        if ($Page->RowType == ROWTYPE_EDIT) { // Edit row
            $Page->EditRowCount++;
        }

        // Set up row attributes
        $Page->RowAttrs->merge([
            "data-rowindex" => $Page->RowCount,
            "id" => "r" . $Page->RowCount . "_users",
            "data-rowtype" => $Page->RowType,
            "class" => ($Page->RowCount % 2 != 1) ? "ew-table-alt-row" : "",
        ]);
        if ($Page->isAdd() && $Page->RowType == ROWTYPE_ADD || $Page->isEdit() && $Page->RowType == ROWTYPE_EDIT) { // Inline-Add/Edit row
            $Page->RowAttrs->appendClass("table-active");
        }

        // Render row
        $Page->renderRow();

        // Render list options
        $Page->renderListOptions();

        // Skip delete row / empty row for confirm page
        if (
            $Page->RowAction != "delete" &&
            $Page->RowAction != "insertdelete" &&
            !($Page->RowAction == "insert" && $Page->isConfirm() && $Page->emptyRow())
        ) {
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Page->ListOptions->render("body", "left", $Page->RowCount);
?>
    <?php if ($Page->ID->Visible) { // ID ?>
        <td data-name="ID"<?= $Page->ID->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_users_ID" class="el_users_ID"></span>
<input type="hidden" data-table="users" data-field="x_ID" data-hidden="1" name="o<?= $Page->RowIndex ?>_ID" id="o<?= $Page->RowIndex ?>_ID" value="<?= HtmlEncode($Page->ID->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_users_ID" class="el_users_ID">
<span<?= $Page->ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->ID->getDisplayValue($Page->ID->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="users" data-field="x_ID" data-hidden="1" name="x<?= $Page->RowIndex ?>_ID" id="x<?= $Page->RowIndex ?>_ID" value="<?= HtmlEncode($Page->ID->CurrentValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_users_ID" class="el_users_ID">
<span<?= $Page->ID->viewAttributes() ?>>
<?= $Page->ID->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } else { ?>
            <input type="hidden" data-table="users" data-field="x_ID" data-hidden="1" name="x<?= $Page->RowIndex ?>_ID" id="x<?= $Page->RowIndex ?>_ID" value="<?= HtmlEncode($Page->ID->CurrentValue) ?>">
    <?php } ?>
    <?php if ($Page->_Username->Visible) { // Username ?>
        <td data-name="_Username"<?= $Page->_Username->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_users__Username" class="el_users__Username">
<input type="<?= $Page->_Username->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>__Username" id="x<?= $Page->RowIndex ?>__Username" data-table="users" data-field="x__Username" value="<?= $Page->_Username->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->_Username->getPlaceHolder()) ?>"<?= $Page->_Username->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->_Username->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="users" data-field="x__Username" data-hidden="1" name="o<?= $Page->RowIndex ?>__Username" id="o<?= $Page->RowIndex ?>__Username" value="<?= HtmlEncode($Page->_Username->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_users__Username" class="el_users__Username">
<input type="<?= $Page->_Username->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>__Username" id="x<?= $Page->RowIndex ?>__Username" data-table="users" data-field="x__Username" value="<?= $Page->_Username->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->_Username->getPlaceHolder()) ?>"<?= $Page->_Username->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->_Username->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_users__Username" class="el_users__Username">
<span<?= $Page->_Username->viewAttributes() ?>>
<?= $Page->_Username->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->_Password->Visible) { // Password ?>
        <td data-name="_Password"<?= $Page->_Password->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_users__Password" class="el_users__Password">
<div class="input-group">
    <input type="password" name="x<?= $Page->RowIndex ?>__Password" id="x<?= $Page->RowIndex ?>__Password" autocomplete="new-password" data-field="x__Password" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->_Password->getPlaceHolder()) ?>"<?= $Page->_Password->editAttributes() ?>>
    <button type="button" class="btn btn-default ew-toggle-password rounded-end" data-ew-action="password"><i class="fas fa-eye"></i></button>
</div>
<div class="invalid-feedback"><?= $Page->_Password->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="users" data-field="x__Password" data-hidden="1" name="o<?= $Page->RowIndex ?>__Password" id="o<?= $Page->RowIndex ?>__Password" value="<?= HtmlEncode($Page->_Password->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_users__Password" class="el_users__Password">
<div class="input-group">
    <input type="password" name="x<?= $Page->RowIndex ?>__Password" id="x<?= $Page->RowIndex ?>__Password" autocomplete="new-password" data-field="x__Password" value="<?= $Page->_Password->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->_Password->getPlaceHolder()) ?>"<?= $Page->_Password->editAttributes() ?>>
    <button type="button" class="btn btn-default ew-toggle-password rounded-end" data-ew-action="password"><i class="fas fa-eye"></i></button>
</div>
<div class="invalid-feedback"><?= $Page->_Password->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_users__Password" class="el_users__Password">
<span<?= $Page->_Password->viewAttributes() ?>>
<?= $Page->_Password->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->Name->Visible) { // Name ?>
        <td data-name="Name"<?= $Page->Name->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_users_Name" class="el_users_Name">
<input type="<?= $Page->Name->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_Name" id="x<?= $Page->RowIndex ?>_Name" data-table="users" data-field="x_Name" value="<?= $Page->Name->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->Name->getPlaceHolder()) ?>"<?= $Page->Name->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Name->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="users" data-field="x_Name" data-hidden="1" name="o<?= $Page->RowIndex ?>_Name" id="o<?= $Page->RowIndex ?>_Name" value="<?= HtmlEncode($Page->Name->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_users_Name" class="el_users_Name">
<input type="<?= $Page->Name->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_Name" id="x<?= $Page->RowIndex ?>_Name" data-table="users" data-field="x_Name" value="<?= $Page->Name->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->Name->getPlaceHolder()) ?>"<?= $Page->Name->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Name->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_users_Name" class="el_users_Name">
<span<?= $Page->Name->viewAttributes() ?>>
<?= $Page->Name->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->Mobile->Visible) { // Mobile ?>
        <td data-name="Mobile"<?= $Page->Mobile->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_users_Mobile" class="el_users_Mobile">
<input type="<?= $Page->Mobile->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_Mobile" id="x<?= $Page->RowIndex ?>_Mobile" data-table="users" data-field="x_Mobile" value="<?= $Page->Mobile->EditValue ?>" size="30" maxlength="10" placeholder="<?= HtmlEncode($Page->Mobile->getPlaceHolder()) ?>"<?= $Page->Mobile->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Mobile->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="users" data-field="x_Mobile" data-hidden="1" name="o<?= $Page->RowIndex ?>_Mobile" id="o<?= $Page->RowIndex ?>_Mobile" value="<?= HtmlEncode($Page->Mobile->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_users_Mobile" class="el_users_Mobile">
<input type="<?= $Page->Mobile->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_Mobile" id="x<?= $Page->RowIndex ?>_Mobile" data-table="users" data-field="x_Mobile" value="<?= $Page->Mobile->EditValue ?>" size="30" maxlength="10" placeholder="<?= HtmlEncode($Page->Mobile->getPlaceHolder()) ?>"<?= $Page->Mobile->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Mobile->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_users_Mobile" class="el_users_Mobile">
<span<?= $Page->Mobile->viewAttributes() ?>>
<?= $Page->Mobile->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->_Email->Visible) { // Email ?>
        <td data-name="_Email"<?= $Page->_Email->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_users__Email" class="el_users__Email">
<input type="<?= $Page->_Email->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>__Email" id="x<?= $Page->RowIndex ?>__Email" data-table="users" data-field="x__Email" value="<?= $Page->_Email->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->_Email->getPlaceHolder()) ?>"<?= $Page->_Email->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->_Email->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="users" data-field="x__Email" data-hidden="1" name="o<?= $Page->RowIndex ?>__Email" id="o<?= $Page->RowIndex ?>__Email" value="<?= HtmlEncode($Page->_Email->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_users__Email" class="el_users__Email">
<input type="<?= $Page->_Email->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>__Email" id="x<?= $Page->RowIndex ?>__Email" data-table="users" data-field="x__Email" value="<?= $Page->_Email->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->_Email->getPlaceHolder()) ?>"<?= $Page->_Email->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->_Email->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_users__Email" class="el_users__Email">
<span<?= $Page->_Email->viewAttributes() ?>>
<?= $Page->_Email->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->User_Level->Visible) { // User_Level ?>
        <td data-name="User_Level"<?= $Page->User_Level->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<?php if (!$Security->isAdmin() && $Security->isLoggedIn()) { // Non system admin ?>
<span id="el<?= $Page->RowCount ?>_users_User_Level" class="el_users_User_Level">
<span class="form-control-plaintext"><?= $Page->User_Level->getDisplayValue($Page->User_Level->EditValue) ?></span>
</span>
<?php } else { ?>
<span id="el<?= $Page->RowCount ?>_users_User_Level" class="el_users_User_Level">
    <select
        id="x<?= $Page->RowIndex ?>_User_Level"
        name="x<?= $Page->RowIndex ?>_User_Level"
        class="form-select ew-select<?= $Page->User_Level->isInvalidClass() ?>"
        data-select2-id="fuserslist_x<?= $Page->RowIndex ?>_User_Level"
        data-table="users"
        data-field="x_User_Level"
        data-value-separator="<?= $Page->User_Level->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->User_Level->getPlaceHolder()) ?>"
        <?= $Page->User_Level->editAttributes() ?>>
        <?= $Page->User_Level->selectOptionListHtml("x{$Page->RowIndex}_User_Level") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->User_Level->getErrorMessage() ?></div>
<?= $Page->User_Level->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_User_Level") ?>
<script>
loadjs.ready("fuserslist", function() {
    var options = { name: "x<?= $Page->RowIndex ?>_User_Level", selectId: "fuserslist_x<?= $Page->RowIndex ?>_User_Level" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fuserslist.lists.User_Level.lookupOptions.length) {
        options.data = { id: "x<?= $Page->RowIndex ?>_User_Level", form: "fuserslist" };
    } else {
        options.ajax = { id: "x<?= $Page->RowIndex ?>_User_Level", form: "fuserslist", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.users.fields.User_Level.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<input type="hidden" data-table="users" data-field="x_User_Level" data-hidden="1" name="o<?= $Page->RowIndex ?>_User_Level" id="o<?= $Page->RowIndex ?>_User_Level" value="<?= HtmlEncode($Page->User_Level->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php if (!$Security->isAdmin() && $Security->isLoggedIn()) { // Non system admin ?>
<span id="el<?= $Page->RowCount ?>_users_User_Level" class="el_users_User_Level">
<span class="form-control-plaintext"><?= $Page->User_Level->getDisplayValue($Page->User_Level->EditValue) ?></span>
</span>
<?php } else { ?>
<span id="el<?= $Page->RowCount ?>_users_User_Level" class="el_users_User_Level">
    <select
        id="x<?= $Page->RowIndex ?>_User_Level"
        name="x<?= $Page->RowIndex ?>_User_Level"
        class="form-select ew-select<?= $Page->User_Level->isInvalidClass() ?>"
        data-select2-id="fuserslist_x<?= $Page->RowIndex ?>_User_Level"
        data-table="users"
        data-field="x_User_Level"
        data-value-separator="<?= $Page->User_Level->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->User_Level->getPlaceHolder()) ?>"
        <?= $Page->User_Level->editAttributes() ?>>
        <?= $Page->User_Level->selectOptionListHtml("x{$Page->RowIndex}_User_Level") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->User_Level->getErrorMessage() ?></div>
<?= $Page->User_Level->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_User_Level") ?>
<script>
loadjs.ready("fuserslist", function() {
    var options = { name: "x<?= $Page->RowIndex ?>_User_Level", selectId: "fuserslist_x<?= $Page->RowIndex ?>_User_Level" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fuserslist.lists.User_Level.lookupOptions.length) {
        options.data = { id: "x<?= $Page->RowIndex ?>_User_Level", form: "fuserslist" };
    } else {
        options.ajax = { id: "x<?= $Page->RowIndex ?>_User_Level", form: "fuserslist", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.users.fields.User_Level.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_users_User_Level" class="el_users_User_Level">
<span<?= $Page->User_Level->viewAttributes() ?>>
<?= $Page->User_Level->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->Status->Visible) { // Status ?>
        <td data-name="Status"<?= $Page->Status->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_users_Status" class="el_users_Status">
<template id="tp_x<?= $Page->RowIndex ?>_Status">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="users" data-field="x_Status" name="x<?= $Page->RowIndex ?>_Status" id="x<?= $Page->RowIndex ?>_Status"<?= $Page->Status->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Page->RowIndex ?>_Status" class="ew-item-list"></div>
<selection-list hidden
    id="x<?= $Page->RowIndex ?>_Status"
    name="x<?= $Page->RowIndex ?>_Status"
    value="<?= HtmlEncode($Page->Status->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Page->RowIndex ?>_Status"
    data-bs-target="dsl_x<?= $Page->RowIndex ?>_Status"
    data-repeatcolumn="5"
    class="form-control<?= $Page->Status->isInvalidClass() ?>"
    data-table="users"
    data-field="x_Status"
    data-value-separator="<?= $Page->Status->displayValueSeparatorAttribute() ?>"
    <?= $Page->Status->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Page->Status->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="users" data-field="x_Status" data-hidden="1" name="o<?= $Page->RowIndex ?>_Status" id="o<?= $Page->RowIndex ?>_Status" value="<?= HtmlEncode($Page->Status->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_users_Status" class="el_users_Status">
<template id="tp_x<?= $Page->RowIndex ?>_Status">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="users" data-field="x_Status" name="x<?= $Page->RowIndex ?>_Status" id="x<?= $Page->RowIndex ?>_Status"<?= $Page->Status->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Page->RowIndex ?>_Status" class="ew-item-list"></div>
<selection-list hidden
    id="x<?= $Page->RowIndex ?>_Status"
    name="x<?= $Page->RowIndex ?>_Status"
    value="<?= HtmlEncode($Page->Status->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Page->RowIndex ?>_Status"
    data-bs-target="dsl_x<?= $Page->RowIndex ?>_Status"
    data-repeatcolumn="5"
    class="form-control<?= $Page->Status->isInvalidClass() ?>"
    data-table="users"
    data-field="x_Status"
    data-value-separator="<?= $Page->Status->displayValueSeparatorAttribute() ?>"
    <?= $Page->Status->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Page->Status->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_users_Status" class="el_users_Status">
<span<?= $Page->Status->viewAttributes() ?>>
<?= $Page->Status->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->Created_BY->Visible) { // Created_BY ?>
        <td data-name="Created_BY"<?= $Page->Created_BY->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="users" data-field="x_Created_BY" data-hidden="1" name="o<?= $Page->RowIndex ?>_Created_BY" id="o<?= $Page->RowIndex ?>_Created_BY" value="<?= HtmlEncode($Page->Created_BY->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_users_Created_BY" class="el_users_Created_BY">
<span<?= $Page->Created_BY->viewAttributes() ?>>
<?= $Page->Created_BY->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->Created_AT->Visible) { // Created_AT ?>
        <td data-name="Created_AT"<?= $Page->Created_AT->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="users" data-field="x_Created_AT" data-hidden="1" name="o<?= $Page->RowIndex ?>_Created_AT" id="o<?= $Page->RowIndex ?>_Created_AT" value="<?= HtmlEncode($Page->Created_AT->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_users_Created_AT" class="el_users_Created_AT">
<span<?= $Page->Created_AT->viewAttributes() ?>>
<?= $Page->Created_AT->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->IP->Visible) { // IP ?>
        <td data-name="IP"<?= $Page->IP->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="users" data-field="x_IP" data-hidden="1" name="o<?= $Page->RowIndex ?>_IP" id="o<?= $Page->RowIndex ?>_IP" value="<?= HtmlEncode($Page->IP->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_users_IP" class="el_users_IP">
<span<?= $Page->IP->viewAttributes() ?>>
<?= $Page->IP->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Page->ListOptions->render("body", "right", $Page->RowCount);
?>
    </tr>
<?php if ($Page->RowType == ROWTYPE_ADD || $Page->RowType == ROWTYPE_EDIT) { ?>
<script>
loadjs.ready(["fuserslist","load"], () => fuserslist.updateLists(<?= $Page->RowIndex ?>));
</script>
<?php } ?>
<?php
    }
    } // End delete row checking
    if (!$Page->isGridAdd())
        if (!$Page->Recordset->EOF) {
            $Page->Recordset->moveNext();
        }
}
?>
<?php
if ($Page->isGridAdd() || $Page->isGridEdit()) {
    $Page->RowIndex = '$rowindex$';
    $Page->loadRowValues();

    // Set row properties
    $Page->resetAttributes();
    $Page->RowAttrs->merge(["data-rowindex" => $Page->RowIndex, "id" => "r0_users", "data-rowtype" => ROWTYPE_ADD]);
    $Page->RowAttrs->appendClass("ew-template");

    // Reset previous form error if any
    $Page->resetFormError();

    // Render row
    $Page->RowType = ROWTYPE_ADD;
    $Page->renderRow();

    // Render list options
    $Page->renderListOptions();
    $Page->StartRowCount = 0;
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php
// Render list options (body, left)
$Page->ListOptions->render("body", "left", $Page->RowIndex);
?>
    <?php if ($Page->ID->Visible) { // ID ?>
        <td data-name="ID">
<span id="el$rowindex$_users_ID" class="el_users_ID"></span>
<input type="hidden" data-table="users" data-field="x_ID" data-hidden="1" name="o<?= $Page->RowIndex ?>_ID" id="o<?= $Page->RowIndex ?>_ID" value="<?= HtmlEncode($Page->ID->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->_Username->Visible) { // Username ?>
        <td data-name="_Username">
<span id="el$rowindex$_users__Username" class="el_users__Username">
<input type="<?= $Page->_Username->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>__Username" id="x<?= $Page->RowIndex ?>__Username" data-table="users" data-field="x__Username" value="<?= $Page->_Username->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->_Username->getPlaceHolder()) ?>"<?= $Page->_Username->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->_Username->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="users" data-field="x__Username" data-hidden="1" name="o<?= $Page->RowIndex ?>__Username" id="o<?= $Page->RowIndex ?>__Username" value="<?= HtmlEncode($Page->_Username->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->_Password->Visible) { // Password ?>
        <td data-name="_Password">
<span id="el$rowindex$_users__Password" class="el_users__Password">
<div class="input-group">
    <input type="password" name="x<?= $Page->RowIndex ?>__Password" id="x<?= $Page->RowIndex ?>__Password" autocomplete="new-password" data-field="x__Password" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->_Password->getPlaceHolder()) ?>"<?= $Page->_Password->editAttributes() ?>>
    <button type="button" class="btn btn-default ew-toggle-password rounded-end" data-ew-action="password"><i class="fas fa-eye"></i></button>
</div>
<div class="invalid-feedback"><?= $Page->_Password->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="users" data-field="x__Password" data-hidden="1" name="o<?= $Page->RowIndex ?>__Password" id="o<?= $Page->RowIndex ?>__Password" value="<?= HtmlEncode($Page->_Password->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->Name->Visible) { // Name ?>
        <td data-name="Name">
<span id="el$rowindex$_users_Name" class="el_users_Name">
<input type="<?= $Page->Name->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_Name" id="x<?= $Page->RowIndex ?>_Name" data-table="users" data-field="x_Name" value="<?= $Page->Name->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->Name->getPlaceHolder()) ?>"<?= $Page->Name->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Name->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="users" data-field="x_Name" data-hidden="1" name="o<?= $Page->RowIndex ?>_Name" id="o<?= $Page->RowIndex ?>_Name" value="<?= HtmlEncode($Page->Name->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->Mobile->Visible) { // Mobile ?>
        <td data-name="Mobile">
<span id="el$rowindex$_users_Mobile" class="el_users_Mobile">
<input type="<?= $Page->Mobile->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_Mobile" id="x<?= $Page->RowIndex ?>_Mobile" data-table="users" data-field="x_Mobile" value="<?= $Page->Mobile->EditValue ?>" size="30" maxlength="10" placeholder="<?= HtmlEncode($Page->Mobile->getPlaceHolder()) ?>"<?= $Page->Mobile->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Mobile->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="users" data-field="x_Mobile" data-hidden="1" name="o<?= $Page->RowIndex ?>_Mobile" id="o<?= $Page->RowIndex ?>_Mobile" value="<?= HtmlEncode($Page->Mobile->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->_Email->Visible) { // Email ?>
        <td data-name="_Email">
<span id="el$rowindex$_users__Email" class="el_users__Email">
<input type="<?= $Page->_Email->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>__Email" id="x<?= $Page->RowIndex ?>__Email" data-table="users" data-field="x__Email" value="<?= $Page->_Email->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->_Email->getPlaceHolder()) ?>"<?= $Page->_Email->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->_Email->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="users" data-field="x__Email" data-hidden="1" name="o<?= $Page->RowIndex ?>__Email" id="o<?= $Page->RowIndex ?>__Email" value="<?= HtmlEncode($Page->_Email->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->User_Level->Visible) { // User_Level ?>
        <td data-name="User_Level">
<?php if (!$Security->isAdmin() && $Security->isLoggedIn()) { // Non system admin ?>
<span id="el$rowindex$_users_User_Level" class="el_users_User_Level">
<span class="form-control-plaintext"><?= $Page->User_Level->getDisplayValue($Page->User_Level->EditValue) ?></span>
</span>
<?php } else { ?>
<span id="el$rowindex$_users_User_Level" class="el_users_User_Level">
    <select
        id="x<?= $Page->RowIndex ?>_User_Level"
        name="x<?= $Page->RowIndex ?>_User_Level"
        class="form-select ew-select<?= $Page->User_Level->isInvalidClass() ?>"
        data-select2-id="fuserslist_x<?= $Page->RowIndex ?>_User_Level"
        data-table="users"
        data-field="x_User_Level"
        data-value-separator="<?= $Page->User_Level->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->User_Level->getPlaceHolder()) ?>"
        <?= $Page->User_Level->editAttributes() ?>>
        <?= $Page->User_Level->selectOptionListHtml("x{$Page->RowIndex}_User_Level") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->User_Level->getErrorMessage() ?></div>
<?= $Page->User_Level->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_User_Level") ?>
<script>
loadjs.ready("fuserslist", function() {
    var options = { name: "x<?= $Page->RowIndex ?>_User_Level", selectId: "fuserslist_x<?= $Page->RowIndex ?>_User_Level" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (fuserslist.lists.User_Level.lookupOptions.length) {
        options.data = { id: "x<?= $Page->RowIndex ?>_User_Level", form: "fuserslist" };
    } else {
        options.ajax = { id: "x<?= $Page->RowIndex ?>_User_Level", form: "fuserslist", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.users.fields.User_Level.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<input type="hidden" data-table="users" data-field="x_User_Level" data-hidden="1" name="o<?= $Page->RowIndex ?>_User_Level" id="o<?= $Page->RowIndex ?>_User_Level" value="<?= HtmlEncode($Page->User_Level->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->Status->Visible) { // Status ?>
        <td data-name="Status">
<span id="el$rowindex$_users_Status" class="el_users_Status">
<template id="tp_x<?= $Page->RowIndex ?>_Status">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="users" data-field="x_Status" name="x<?= $Page->RowIndex ?>_Status" id="x<?= $Page->RowIndex ?>_Status"<?= $Page->Status->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Page->RowIndex ?>_Status" class="ew-item-list"></div>
<selection-list hidden
    id="x<?= $Page->RowIndex ?>_Status"
    name="x<?= $Page->RowIndex ?>_Status"
    value="<?= HtmlEncode($Page->Status->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Page->RowIndex ?>_Status"
    data-bs-target="dsl_x<?= $Page->RowIndex ?>_Status"
    data-repeatcolumn="5"
    class="form-control<?= $Page->Status->isInvalidClass() ?>"
    data-table="users"
    data-field="x_Status"
    data-value-separator="<?= $Page->Status->displayValueSeparatorAttribute() ?>"
    <?= $Page->Status->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Page->Status->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="users" data-field="x_Status" data-hidden="1" name="o<?= $Page->RowIndex ?>_Status" id="o<?= $Page->RowIndex ?>_Status" value="<?= HtmlEncode($Page->Status->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->Created_BY->Visible) { // Created_BY ?>
        <td data-name="Created_BY">
<input type="hidden" data-table="users" data-field="x_Created_BY" data-hidden="1" name="o<?= $Page->RowIndex ?>_Created_BY" id="o<?= $Page->RowIndex ?>_Created_BY" value="<?= HtmlEncode($Page->Created_BY->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->Created_AT->Visible) { // Created_AT ?>
        <td data-name="Created_AT">
<input type="hidden" data-table="users" data-field="x_Created_AT" data-hidden="1" name="o<?= $Page->RowIndex ?>_Created_AT" id="o<?= $Page->RowIndex ?>_Created_AT" value="<?= HtmlEncode($Page->Created_AT->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->IP->Visible) { // IP ?>
        <td data-name="IP">
<input type="hidden" data-table="users" data-field="x_IP" data-hidden="1" name="o<?= $Page->RowIndex ?>_IP" id="o<?= $Page->RowIndex ?>_IP" value="<?= HtmlEncode($Page->IP->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Page->ListOptions->render("body", "right", $Page->RowIndex);
?>
<script>
loadjs.ready(["fuserslist","load"], () => fuserslist.updateLists(<?= $Page->RowIndex ?>, true));
</script>
    </tr>
<?php
}
?>
</tbody>
</table><!-- /.ew-table -->
<?php } ?>
</div><!-- /.ew-grid-middle-panel -->
<?php if ($Page->isGridAdd()) { ?>
<input type="hidden" name="action" id="action" value="gridinsert">
<input type="hidden" name="<?= $Page->FormKeyCountName ?>" id="<?= $Page->FormKeyCountName ?>" value="<?= $Page->KeyCount ?>">
<?= $Page->MultiSelectKey ?>
<?php } ?>
<?php if ($Page->isGridEdit()) { ?>
<input type="hidden" name="action" id="action" value="gridupdate">
<input type="hidden" name="<?= $Page->FormKeyCountName ?>" id="<?= $Page->FormKeyCountName ?>" value="<?= $Page->KeyCount ?>">
<?= $Page->MultiSelectKey ?>
<?php } ?>
<?php if (!$Page->CurrentAction) { ?>
<input type="hidden" name="action" id="action" value="">
<?php } ?>
</form><!-- /.ew-list-form -->
<?php
// Close recordset
if ($Page->Recordset) {
    $Page->Recordset->close();
}
?>
<?php if (!$Page->isExport()) { ?>
<div class="card-footer ew-grid-lower-panel">
<?php if (!$Page->isGridAdd()) { ?>
<form name="ew-pager-form" class="ew-form ew-pager-form" action="<?= CurrentPageUrl(false) ?>">
<?= $Page->Pager->render() ?>
</form>
<?php } ?>
<div class="ew-list-other-options">
<?php $Page->OtherOptions->render("body", "bottom") ?>
</div>
</div>
<?php } ?>
</div><!-- /.ew-grid -->
<?php } else { ?>
<div class="ew-list-other-options">
<?php $Page->OtherOptions->render("body") ?>
</div>
<?php } ?>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<?php if (!$Page->isExport()) { ?>
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
<?php } ?>
