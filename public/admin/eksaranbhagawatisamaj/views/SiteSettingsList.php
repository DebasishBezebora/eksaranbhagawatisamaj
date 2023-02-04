<?php

namespace PHPMaker2022\eksbs;

// Page object
$SiteSettingsList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { site_settings: currentTable } });
var currentForm, currentPageID;
var fsite_settingslist;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fsite_settingslist = new ew.Form("fsite_settingslist", "list");
    currentPageID = ew.PAGE_ID = "list";
    currentForm = fsite_settingslist;
    fsite_settingslist.formKeyCountName = "<?= $Page->FormKeyCountName ?>";

    // Add fields
    var fields = currentTable.fields;
    fsite_settingslist.addFields([
        ["ID", [fields.ID.visible && fields.ID.required ? ew.Validators.required(fields.ID.caption) : null], fields.ID.isInvalid],
        ["Contact_No_1", [fields.Contact_No_1.visible && fields.Contact_No_1.required ? ew.Validators.required(fields.Contact_No_1.caption) : null], fields.Contact_No_1.isInvalid],
        ["Contact_No_2", [fields.Contact_No_2.visible && fields.Contact_No_2.required ? ew.Validators.required(fields.Contact_No_2.caption) : null], fields.Contact_No_2.isInvalid],
        ["Brand_Name", [fields.Brand_Name.visible && fields.Brand_Name.required ? ew.Validators.required(fields.Brand_Name.caption) : null], fields.Brand_Name.isInvalid],
        ["Logo", [fields.Logo.visible && fields.Logo.required ? ew.Validators.fileRequired(fields.Logo.caption) : null], fields.Logo.isInvalid],
        ["Favicon", [fields.Favicon.visible && fields.Favicon.required ? ew.Validators.fileRequired(fields.Favicon.caption) : null], fields.Favicon.isInvalid],
        ["Facebook", [fields.Facebook.visible && fields.Facebook.required ? ew.Validators.required(fields.Facebook.caption) : null], fields.Facebook.isInvalid],
        ["Twitter", [fields.Twitter.visible && fields.Twitter.required ? ew.Validators.required(fields.Twitter.caption) : null], fields.Twitter.isInvalid],
        ["Instagram", [fields.Instagram.visible && fields.Instagram.required ? ew.Validators.required(fields.Instagram.caption) : null], fields.Instagram.isInvalid],
        ["_Title", [fields._Title.visible && fields._Title.required ? ew.Validators.required(fields._Title.caption) : null], fields._Title.isInvalid],
        ["Active", [fields.Active.visible && fields.Active.required ? ew.Validators.required(fields.Active.caption) : null], fields.Active.isInvalid],
        ["Created_AT", [fields.Created_AT.visible && fields.Created_AT.required ? ew.Validators.required(fields.Created_AT.caption) : null], fields.Created_AT.isInvalid],
        ["Created_BY", [fields.Created_BY.visible && fields.Created_BY.required ? ew.Validators.required(fields.Created_BY.caption) : null], fields.Created_BY.isInvalid],
        ["IP", [fields.IP.visible && fields.IP.required ? ew.Validators.required(fields.IP.caption) : null], fields.IP.isInvalid]
    ]);

    // Check empty row
    fsite_settingslist.emptyRow = function (rowIndex) {
        var fobj = this.getForm(),
            fields = [["Contact_No_1",false],["Contact_No_2",false],["Brand_Name",false],["Logo",false],["Favicon",false],["Facebook",false],["Twitter",false],["Instagram",false],["_Title",false],["Active",true]];
        if (fields.some(field => ew.valueChanged(fobj, rowIndex, ...field)))
            return false;
        return true;
    }

    // Form_CustomValidate
    fsite_settingslist.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fsite_settingslist.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    fsite_settingslist.lists.Active = <?= $Page->Active->toClientList($Page) ?>;
    loadjs.done("fsite_settingslist");
});
var fsite_settingssrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object for search
    fsite_settingssrch = new ew.Form("fsite_settingssrch", "list");
    currentSearchForm = fsite_settingssrch;

    // Dynamic selection lists

    // Filters
    fsite_settingssrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("fsite_settingssrch");
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
<form name="fsite_settingssrch" id="fsite_settingssrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>">
<div id="fsite_settingssrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="site_settings">
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
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "" ? " active" : "" ?>" form="fsite_settingssrch" data-ew-action="search-type"><?= $Language->phrase("QuickSearchAuto") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "=" ? " active" : "" ?>" form="fsite_settingssrch" data-ew-action="search-type" data-search-type="="><?= $Language->phrase("QuickSearchExact") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "AND" ? " active" : "" ?>" form="fsite_settingssrch" data-ew-action="search-type" data-search-type="AND"><?= $Language->phrase("QuickSearchAll") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "OR" ? " active" : "" ?>" form="fsite_settingssrch" data-ew-action="search-type" data-search-type="OR"><?= $Language->phrase("QuickSearchAny") ?></button>
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
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> site_settings">
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
<form name="fsite_settingslist" id="fsite_settingslist" class="ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="site_settings">
<div id="gmp_site_settings" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_site_settingslist" class="table table-bordered table-hover table-sm ew-table"><!-- .ew-table -->
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
        <th data-name="ID" class="<?= $Page->ID->headerCellClass() ?>"><div id="elh_site_settings_ID" class="site_settings_ID"><?= $Page->renderFieldHeader($Page->ID) ?></div></th>
<?php } ?>
<?php if ($Page->Contact_No_1->Visible) { // Contact_No_1 ?>
        <th data-name="Contact_No_1" class="<?= $Page->Contact_No_1->headerCellClass() ?>"><div id="elh_site_settings_Contact_No_1" class="site_settings_Contact_No_1"><?= $Page->renderFieldHeader($Page->Contact_No_1) ?></div></th>
<?php } ?>
<?php if ($Page->Contact_No_2->Visible) { // Contact_No_2 ?>
        <th data-name="Contact_No_2" class="<?= $Page->Contact_No_2->headerCellClass() ?>"><div id="elh_site_settings_Contact_No_2" class="site_settings_Contact_No_2"><?= $Page->renderFieldHeader($Page->Contact_No_2) ?></div></th>
<?php } ?>
<?php if ($Page->Brand_Name->Visible) { // Brand_Name ?>
        <th data-name="Brand_Name" class="<?= $Page->Brand_Name->headerCellClass() ?>"><div id="elh_site_settings_Brand_Name" class="site_settings_Brand_Name"><?= $Page->renderFieldHeader($Page->Brand_Name) ?></div></th>
<?php } ?>
<?php if ($Page->Logo->Visible) { // Logo ?>
        <th data-name="Logo" class="<?= $Page->Logo->headerCellClass() ?>"><div id="elh_site_settings_Logo" class="site_settings_Logo"><?= $Page->renderFieldHeader($Page->Logo) ?></div></th>
<?php } ?>
<?php if ($Page->Favicon->Visible) { // Favicon ?>
        <th data-name="Favicon" class="<?= $Page->Favicon->headerCellClass() ?>"><div id="elh_site_settings_Favicon" class="site_settings_Favicon"><?= $Page->renderFieldHeader($Page->Favicon) ?></div></th>
<?php } ?>
<?php if ($Page->Facebook->Visible) { // Facebook ?>
        <th data-name="Facebook" class="<?= $Page->Facebook->headerCellClass() ?>"><div id="elh_site_settings_Facebook" class="site_settings_Facebook"><?= $Page->renderFieldHeader($Page->Facebook) ?></div></th>
<?php } ?>
<?php if ($Page->Twitter->Visible) { // Twitter ?>
        <th data-name="Twitter" class="<?= $Page->Twitter->headerCellClass() ?>"><div id="elh_site_settings_Twitter" class="site_settings_Twitter"><?= $Page->renderFieldHeader($Page->Twitter) ?></div></th>
<?php } ?>
<?php if ($Page->Instagram->Visible) { // Instagram ?>
        <th data-name="Instagram" class="<?= $Page->Instagram->headerCellClass() ?>"><div id="elh_site_settings_Instagram" class="site_settings_Instagram"><?= $Page->renderFieldHeader($Page->Instagram) ?></div></th>
<?php } ?>
<?php if ($Page->_Title->Visible) { // Title ?>
        <th data-name="_Title" class="<?= $Page->_Title->headerCellClass() ?>"><div id="elh_site_settings__Title" class="site_settings__Title"><?= $Page->renderFieldHeader($Page->_Title) ?></div></th>
<?php } ?>
<?php if ($Page->Active->Visible) { // Active ?>
        <th data-name="Active" class="<?= $Page->Active->headerCellClass() ?>"><div id="elh_site_settings_Active" class="site_settings_Active"><?= $Page->renderFieldHeader($Page->Active) ?></div></th>
<?php } ?>
<?php if ($Page->Created_AT->Visible) { // Created_AT ?>
        <th data-name="Created_AT" class="<?= $Page->Created_AT->headerCellClass() ?>"><div id="elh_site_settings_Created_AT" class="site_settings_Created_AT"><?= $Page->renderFieldHeader($Page->Created_AT) ?></div></th>
<?php } ?>
<?php if ($Page->Created_BY->Visible) { // Created_BY ?>
        <th data-name="Created_BY" class="<?= $Page->Created_BY->headerCellClass() ?>"><div id="elh_site_settings_Created_BY" class="site_settings_Created_BY"><?= $Page->renderFieldHeader($Page->Created_BY) ?></div></th>
<?php } ?>
<?php if ($Page->IP->Visible) { // IP ?>
        <th data-name="IP" class="<?= $Page->IP->headerCellClass() ?>"><div id="elh_site_settings_IP" class="site_settings_IP"><?= $Page->renderFieldHeader($Page->IP) ?></div></th>
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
            "id" => "r" . $Page->RowCount . "_site_settings",
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
<span id="el<?= $Page->RowCount ?>_site_settings_ID" class="el_site_settings_ID"></span>
<input type="hidden" data-table="site_settings" data-field="x_ID" data-hidden="1" name="o<?= $Page->RowIndex ?>_ID" id="o<?= $Page->RowIndex ?>_ID" value="<?= HtmlEncode($Page->ID->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_site_settings_ID" class="el_site_settings_ID">
<span<?= $Page->ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->ID->getDisplayValue($Page->ID->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="site_settings" data-field="x_ID" data-hidden="1" name="x<?= $Page->RowIndex ?>_ID" id="x<?= $Page->RowIndex ?>_ID" value="<?= HtmlEncode($Page->ID->CurrentValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_site_settings_ID" class="el_site_settings_ID">
<span<?= $Page->ID->viewAttributes() ?>>
<?= $Page->ID->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } else { ?>
            <input type="hidden" data-table="site_settings" data-field="x_ID" data-hidden="1" name="x<?= $Page->RowIndex ?>_ID" id="x<?= $Page->RowIndex ?>_ID" value="<?= HtmlEncode($Page->ID->CurrentValue) ?>">
    <?php } ?>
    <?php if ($Page->Contact_No_1->Visible) { // Contact_No_1 ?>
        <td data-name="Contact_No_1"<?= $Page->Contact_No_1->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_site_settings_Contact_No_1" class="el_site_settings_Contact_No_1">
<input type="<?= $Page->Contact_No_1->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_Contact_No_1" id="x<?= $Page->RowIndex ?>_Contact_No_1" data-table="site_settings" data-field="x_Contact_No_1" value="<?= $Page->Contact_No_1->EditValue ?>" size="30" maxlength="10" placeholder="<?= HtmlEncode($Page->Contact_No_1->getPlaceHolder()) ?>"<?= $Page->Contact_No_1->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Contact_No_1->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="site_settings" data-field="x_Contact_No_1" data-hidden="1" name="o<?= $Page->RowIndex ?>_Contact_No_1" id="o<?= $Page->RowIndex ?>_Contact_No_1" value="<?= HtmlEncode($Page->Contact_No_1->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_site_settings_Contact_No_1" class="el_site_settings_Contact_No_1">
<input type="<?= $Page->Contact_No_1->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_Contact_No_1" id="x<?= $Page->RowIndex ?>_Contact_No_1" data-table="site_settings" data-field="x_Contact_No_1" value="<?= $Page->Contact_No_1->EditValue ?>" size="30" maxlength="10" placeholder="<?= HtmlEncode($Page->Contact_No_1->getPlaceHolder()) ?>"<?= $Page->Contact_No_1->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Contact_No_1->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_site_settings_Contact_No_1" class="el_site_settings_Contact_No_1">
<span<?= $Page->Contact_No_1->viewAttributes() ?>>
<?= $Page->Contact_No_1->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->Contact_No_2->Visible) { // Contact_No_2 ?>
        <td data-name="Contact_No_2"<?= $Page->Contact_No_2->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_site_settings_Contact_No_2" class="el_site_settings_Contact_No_2">
<input type="<?= $Page->Contact_No_2->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_Contact_No_2" id="x<?= $Page->RowIndex ?>_Contact_No_2" data-table="site_settings" data-field="x_Contact_No_2" value="<?= $Page->Contact_No_2->EditValue ?>" size="30" maxlength="10" placeholder="<?= HtmlEncode($Page->Contact_No_2->getPlaceHolder()) ?>"<?= $Page->Contact_No_2->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Contact_No_2->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="site_settings" data-field="x_Contact_No_2" data-hidden="1" name="o<?= $Page->RowIndex ?>_Contact_No_2" id="o<?= $Page->RowIndex ?>_Contact_No_2" value="<?= HtmlEncode($Page->Contact_No_2->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_site_settings_Contact_No_2" class="el_site_settings_Contact_No_2">
<input type="<?= $Page->Contact_No_2->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_Contact_No_2" id="x<?= $Page->RowIndex ?>_Contact_No_2" data-table="site_settings" data-field="x_Contact_No_2" value="<?= $Page->Contact_No_2->EditValue ?>" size="30" maxlength="10" placeholder="<?= HtmlEncode($Page->Contact_No_2->getPlaceHolder()) ?>"<?= $Page->Contact_No_2->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Contact_No_2->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_site_settings_Contact_No_2" class="el_site_settings_Contact_No_2">
<span<?= $Page->Contact_No_2->viewAttributes() ?>>
<?= $Page->Contact_No_2->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->Brand_Name->Visible) { // Brand_Name ?>
        <td data-name="Brand_Name"<?= $Page->Brand_Name->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_site_settings_Brand_Name" class="el_site_settings_Brand_Name">
<input type="<?= $Page->Brand_Name->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_Brand_Name" id="x<?= $Page->RowIndex ?>_Brand_Name" data-table="site_settings" data-field="x_Brand_Name" value="<?= $Page->Brand_Name->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->Brand_Name->getPlaceHolder()) ?>"<?= $Page->Brand_Name->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Brand_Name->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="site_settings" data-field="x_Brand_Name" data-hidden="1" name="o<?= $Page->RowIndex ?>_Brand_Name" id="o<?= $Page->RowIndex ?>_Brand_Name" value="<?= HtmlEncode($Page->Brand_Name->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_site_settings_Brand_Name" class="el_site_settings_Brand_Name">
<input type="<?= $Page->Brand_Name->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_Brand_Name" id="x<?= $Page->RowIndex ?>_Brand_Name" data-table="site_settings" data-field="x_Brand_Name" value="<?= $Page->Brand_Name->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->Brand_Name->getPlaceHolder()) ?>"<?= $Page->Brand_Name->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Brand_Name->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_site_settings_Brand_Name" class="el_site_settings_Brand_Name">
<span<?= $Page->Brand_Name->viewAttributes() ?>>
<?= $Page->Brand_Name->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->Logo->Visible) { // Logo ?>
        <td data-name="Logo"<?= $Page->Logo->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_site_settings_Logo" class="el_site_settings_Logo">
<div id="fd_x<?= $Page->RowIndex ?>_Logo" class="fileinput-button ew-file-drop-zone">
    <input type="file" class="form-control ew-file-input" title="<?= $Page->Logo->title() ?>" data-table="site_settings" data-field="x_Logo" name="x<?= $Page->RowIndex ?>_Logo" id="x<?= $Page->RowIndex ?>_Logo" lang="<?= CurrentLanguageID() ?>"<?= $Page->Logo->editAttributes() ?><?= ($Page->Logo->ReadOnly || $Page->Logo->Disabled) ? " disabled" : "" ?>>
    <div class="text-muted ew-file-text"><?= $Language->phrase("ChooseFile") ?></div>
</div>
<div class="invalid-feedback"><?= $Page->Logo->getErrorMessage() ?></div>
<input type="hidden" name="fn_x<?= $Page->RowIndex ?>_Logo" id= "fn_x<?= $Page->RowIndex ?>_Logo" value="<?= $Page->Logo->Upload->FileName ?>">
<input type="hidden" name="fa_x<?= $Page->RowIndex ?>_Logo" id= "fa_x<?= $Page->RowIndex ?>_Logo" value="0">
<input type="hidden" name="fs_x<?= $Page->RowIndex ?>_Logo" id= "fs_x<?= $Page->RowIndex ?>_Logo" value="255">
<input type="hidden" name="fx_x<?= $Page->RowIndex ?>_Logo" id= "fx_x<?= $Page->RowIndex ?>_Logo" value="<?= $Page->Logo->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?= $Page->RowIndex ?>_Logo" id= "fm_x<?= $Page->RowIndex ?>_Logo" value="<?= $Page->Logo->UploadMaxFileSize ?>">
<table id="ft_x<?= $Page->RowIndex ?>_Logo" class="table table-sm float-start ew-upload-table"><tbody class="files"></tbody></table>
</span>
<input type="hidden" data-table="site_settings" data-field="x_Logo" data-hidden="1" name="o<?= $Page->RowIndex ?>_Logo" id="o<?= $Page->RowIndex ?>_Logo" value="<?= HtmlEncode($Page->Logo->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_site_settings_Logo" class="el_site_settings_Logo">
<div id="fd_x<?= $Page->RowIndex ?>_Logo" class="fileinput-button ew-file-drop-zone">
    <input type="file" class="form-control ew-file-input" title="<?= $Page->Logo->title() ?>" data-table="site_settings" data-field="x_Logo" name="x<?= $Page->RowIndex ?>_Logo" id="x<?= $Page->RowIndex ?>_Logo" lang="<?= CurrentLanguageID() ?>"<?= $Page->Logo->editAttributes() ?><?= ($Page->Logo->ReadOnly || $Page->Logo->Disabled) ? " disabled" : "" ?>>
    <div class="text-muted ew-file-text"><?= $Language->phrase("ChooseFile") ?></div>
</div>
<div class="invalid-feedback"><?= $Page->Logo->getErrorMessage() ?></div>
<input type="hidden" name="fn_x<?= $Page->RowIndex ?>_Logo" id= "fn_x<?= $Page->RowIndex ?>_Logo" value="<?= $Page->Logo->Upload->FileName ?>">
<input type="hidden" name="fa_x<?= $Page->RowIndex ?>_Logo" id= "fa_x<?= $Page->RowIndex ?>_Logo" value="<?= (Post("fa_x<?= $Page->RowIndex ?>_Logo") == "0") ? "0" : "1" ?>">
<input type="hidden" name="fs_x<?= $Page->RowIndex ?>_Logo" id= "fs_x<?= $Page->RowIndex ?>_Logo" value="255">
<input type="hidden" name="fx_x<?= $Page->RowIndex ?>_Logo" id= "fx_x<?= $Page->RowIndex ?>_Logo" value="<?= $Page->Logo->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?= $Page->RowIndex ?>_Logo" id= "fm_x<?= $Page->RowIndex ?>_Logo" value="<?= $Page->Logo->UploadMaxFileSize ?>">
<table id="ft_x<?= $Page->RowIndex ?>_Logo" class="table table-sm float-start ew-upload-table"><tbody class="files"></tbody></table>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_site_settings_Logo" class="el_site_settings_Logo">
<span<?= $Page->Logo->viewAttributes() ?>>
<?= GetFileViewTag($Page->Logo, $Page->Logo->getViewValue(), false) ?>
</span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->Favicon->Visible) { // Favicon ?>
        <td data-name="Favicon"<?= $Page->Favicon->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_site_settings_Favicon" class="el_site_settings_Favicon">
<div id="fd_x<?= $Page->RowIndex ?>_Favicon" class="fileinput-button ew-file-drop-zone">
    <input type="file" class="form-control ew-file-input" title="<?= $Page->Favicon->title() ?>" data-table="site_settings" data-field="x_Favicon" name="x<?= $Page->RowIndex ?>_Favicon" id="x<?= $Page->RowIndex ?>_Favicon" lang="<?= CurrentLanguageID() ?>"<?= $Page->Favicon->editAttributes() ?><?= ($Page->Favicon->ReadOnly || $Page->Favicon->Disabled) ? " disabled" : "" ?>>
    <div class="text-muted ew-file-text"><?= $Language->phrase("ChooseFile") ?></div>
</div>
<div class="invalid-feedback"><?= $Page->Favicon->getErrorMessage() ?></div>
<input type="hidden" name="fn_x<?= $Page->RowIndex ?>_Favicon" id= "fn_x<?= $Page->RowIndex ?>_Favicon" value="<?= $Page->Favicon->Upload->FileName ?>">
<input type="hidden" name="fa_x<?= $Page->RowIndex ?>_Favicon" id= "fa_x<?= $Page->RowIndex ?>_Favicon" value="0">
<input type="hidden" name="fs_x<?= $Page->RowIndex ?>_Favicon" id= "fs_x<?= $Page->RowIndex ?>_Favicon" value="255">
<input type="hidden" name="fx_x<?= $Page->RowIndex ?>_Favicon" id= "fx_x<?= $Page->RowIndex ?>_Favicon" value="<?= $Page->Favicon->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?= $Page->RowIndex ?>_Favicon" id= "fm_x<?= $Page->RowIndex ?>_Favicon" value="<?= $Page->Favicon->UploadMaxFileSize ?>">
<table id="ft_x<?= $Page->RowIndex ?>_Favicon" class="table table-sm float-start ew-upload-table"><tbody class="files"></tbody></table>
</span>
<input type="hidden" data-table="site_settings" data-field="x_Favicon" data-hidden="1" name="o<?= $Page->RowIndex ?>_Favicon" id="o<?= $Page->RowIndex ?>_Favicon" value="<?= HtmlEncode($Page->Favicon->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_site_settings_Favicon" class="el_site_settings_Favicon">
<div id="fd_x<?= $Page->RowIndex ?>_Favicon" class="fileinput-button ew-file-drop-zone">
    <input type="file" class="form-control ew-file-input" title="<?= $Page->Favicon->title() ?>" data-table="site_settings" data-field="x_Favicon" name="x<?= $Page->RowIndex ?>_Favicon" id="x<?= $Page->RowIndex ?>_Favicon" lang="<?= CurrentLanguageID() ?>"<?= $Page->Favicon->editAttributes() ?><?= ($Page->Favicon->ReadOnly || $Page->Favicon->Disabled) ? " disabled" : "" ?>>
    <div class="text-muted ew-file-text"><?= $Language->phrase("ChooseFile") ?></div>
</div>
<div class="invalid-feedback"><?= $Page->Favicon->getErrorMessage() ?></div>
<input type="hidden" name="fn_x<?= $Page->RowIndex ?>_Favicon" id= "fn_x<?= $Page->RowIndex ?>_Favicon" value="<?= $Page->Favicon->Upload->FileName ?>">
<input type="hidden" name="fa_x<?= $Page->RowIndex ?>_Favicon" id= "fa_x<?= $Page->RowIndex ?>_Favicon" value="<?= (Post("fa_x<?= $Page->RowIndex ?>_Favicon") == "0") ? "0" : "1" ?>">
<input type="hidden" name="fs_x<?= $Page->RowIndex ?>_Favicon" id= "fs_x<?= $Page->RowIndex ?>_Favicon" value="255">
<input type="hidden" name="fx_x<?= $Page->RowIndex ?>_Favicon" id= "fx_x<?= $Page->RowIndex ?>_Favicon" value="<?= $Page->Favicon->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?= $Page->RowIndex ?>_Favicon" id= "fm_x<?= $Page->RowIndex ?>_Favicon" value="<?= $Page->Favicon->UploadMaxFileSize ?>">
<table id="ft_x<?= $Page->RowIndex ?>_Favicon" class="table table-sm float-start ew-upload-table"><tbody class="files"></tbody></table>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_site_settings_Favicon" class="el_site_settings_Favicon">
<span<?= $Page->Favicon->viewAttributes() ?>>
<?= GetFileViewTag($Page->Favicon, $Page->Favicon->getViewValue(), false) ?>
</span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->Facebook->Visible) { // Facebook ?>
        <td data-name="Facebook"<?= $Page->Facebook->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_site_settings_Facebook" class="el_site_settings_Facebook">
<input type="<?= $Page->Facebook->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_Facebook" id="x<?= $Page->RowIndex ?>_Facebook" data-table="site_settings" data-field="x_Facebook" value="<?= $Page->Facebook->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->Facebook->getPlaceHolder()) ?>"<?= $Page->Facebook->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Facebook->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="site_settings" data-field="x_Facebook" data-hidden="1" name="o<?= $Page->RowIndex ?>_Facebook" id="o<?= $Page->RowIndex ?>_Facebook" value="<?= HtmlEncode($Page->Facebook->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_site_settings_Facebook" class="el_site_settings_Facebook">
<input type="<?= $Page->Facebook->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_Facebook" id="x<?= $Page->RowIndex ?>_Facebook" data-table="site_settings" data-field="x_Facebook" value="<?= $Page->Facebook->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->Facebook->getPlaceHolder()) ?>"<?= $Page->Facebook->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Facebook->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_site_settings_Facebook" class="el_site_settings_Facebook">
<span<?= $Page->Facebook->viewAttributes() ?>>
<?= $Page->Facebook->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->Twitter->Visible) { // Twitter ?>
        <td data-name="Twitter"<?= $Page->Twitter->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_site_settings_Twitter" class="el_site_settings_Twitter">
<input type="<?= $Page->Twitter->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_Twitter" id="x<?= $Page->RowIndex ?>_Twitter" data-table="site_settings" data-field="x_Twitter" value="<?= $Page->Twitter->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->Twitter->getPlaceHolder()) ?>"<?= $Page->Twitter->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Twitter->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="site_settings" data-field="x_Twitter" data-hidden="1" name="o<?= $Page->RowIndex ?>_Twitter" id="o<?= $Page->RowIndex ?>_Twitter" value="<?= HtmlEncode($Page->Twitter->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_site_settings_Twitter" class="el_site_settings_Twitter">
<input type="<?= $Page->Twitter->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_Twitter" id="x<?= $Page->RowIndex ?>_Twitter" data-table="site_settings" data-field="x_Twitter" value="<?= $Page->Twitter->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->Twitter->getPlaceHolder()) ?>"<?= $Page->Twitter->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Twitter->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_site_settings_Twitter" class="el_site_settings_Twitter">
<span<?= $Page->Twitter->viewAttributes() ?>>
<?= $Page->Twitter->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->Instagram->Visible) { // Instagram ?>
        <td data-name="Instagram"<?= $Page->Instagram->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_site_settings_Instagram" class="el_site_settings_Instagram">
<input type="<?= $Page->Instagram->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_Instagram" id="x<?= $Page->RowIndex ?>_Instagram" data-table="site_settings" data-field="x_Instagram" value="<?= $Page->Instagram->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->Instagram->getPlaceHolder()) ?>"<?= $Page->Instagram->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Instagram->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="site_settings" data-field="x_Instagram" data-hidden="1" name="o<?= $Page->RowIndex ?>_Instagram" id="o<?= $Page->RowIndex ?>_Instagram" value="<?= HtmlEncode($Page->Instagram->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_site_settings_Instagram" class="el_site_settings_Instagram">
<input type="<?= $Page->Instagram->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_Instagram" id="x<?= $Page->RowIndex ?>_Instagram" data-table="site_settings" data-field="x_Instagram" value="<?= $Page->Instagram->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->Instagram->getPlaceHolder()) ?>"<?= $Page->Instagram->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Instagram->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_site_settings_Instagram" class="el_site_settings_Instagram">
<span<?= $Page->Instagram->viewAttributes() ?>>
<?= $Page->Instagram->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->_Title->Visible) { // Title ?>
        <td data-name="_Title"<?= $Page->_Title->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_site_settings__Title" class="el_site_settings__Title">
<input type="<?= $Page->_Title->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>__Title" id="x<?= $Page->RowIndex ?>__Title" data-table="site_settings" data-field="x__Title" value="<?= $Page->_Title->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->_Title->getPlaceHolder()) ?>"<?= $Page->_Title->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->_Title->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="site_settings" data-field="x__Title" data-hidden="1" name="o<?= $Page->RowIndex ?>__Title" id="o<?= $Page->RowIndex ?>__Title" value="<?= HtmlEncode($Page->_Title->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_site_settings__Title" class="el_site_settings__Title">
<input type="<?= $Page->_Title->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>__Title" id="x<?= $Page->RowIndex ?>__Title" data-table="site_settings" data-field="x__Title" value="<?= $Page->_Title->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->_Title->getPlaceHolder()) ?>"<?= $Page->_Title->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->_Title->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_site_settings__Title" class="el_site_settings__Title">
<span<?= $Page->_Title->viewAttributes() ?>>
<?= $Page->_Title->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->Active->Visible) { // Active ?>
        <td data-name="Active"<?= $Page->Active->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_site_settings_Active" class="el_site_settings_Active">
<template id="tp_x<?= $Page->RowIndex ?>_Active">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="site_settings" data-field="x_Active" name="x<?= $Page->RowIndex ?>_Active" id="x<?= $Page->RowIndex ?>_Active"<?= $Page->Active->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Page->RowIndex ?>_Active" class="ew-item-list"></div>
<selection-list hidden
    id="x<?= $Page->RowIndex ?>_Active"
    name="x<?= $Page->RowIndex ?>_Active"
    value="<?= HtmlEncode($Page->Active->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Page->RowIndex ?>_Active"
    data-bs-target="dsl_x<?= $Page->RowIndex ?>_Active"
    data-repeatcolumn="5"
    class="form-control<?= $Page->Active->isInvalidClass() ?>"
    data-table="site_settings"
    data-field="x_Active"
    data-value-separator="<?= $Page->Active->displayValueSeparatorAttribute() ?>"
    <?= $Page->Active->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Page->Active->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="site_settings" data-field="x_Active" data-hidden="1" name="o<?= $Page->RowIndex ?>_Active" id="o<?= $Page->RowIndex ?>_Active" value="<?= HtmlEncode($Page->Active->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_site_settings_Active" class="el_site_settings_Active">
<template id="tp_x<?= $Page->RowIndex ?>_Active">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="site_settings" data-field="x_Active" name="x<?= $Page->RowIndex ?>_Active" id="x<?= $Page->RowIndex ?>_Active"<?= $Page->Active->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Page->RowIndex ?>_Active" class="ew-item-list"></div>
<selection-list hidden
    id="x<?= $Page->RowIndex ?>_Active"
    name="x<?= $Page->RowIndex ?>_Active"
    value="<?= HtmlEncode($Page->Active->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Page->RowIndex ?>_Active"
    data-bs-target="dsl_x<?= $Page->RowIndex ?>_Active"
    data-repeatcolumn="5"
    class="form-control<?= $Page->Active->isInvalidClass() ?>"
    data-table="site_settings"
    data-field="x_Active"
    data-value-separator="<?= $Page->Active->displayValueSeparatorAttribute() ?>"
    <?= $Page->Active->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Page->Active->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_site_settings_Active" class="el_site_settings_Active">
<span<?= $Page->Active->viewAttributes() ?>>
<?= $Page->Active->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->Created_AT->Visible) { // Created_AT ?>
        <td data-name="Created_AT"<?= $Page->Created_AT->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="site_settings" data-field="x_Created_AT" data-hidden="1" name="o<?= $Page->RowIndex ?>_Created_AT" id="o<?= $Page->RowIndex ?>_Created_AT" value="<?= HtmlEncode($Page->Created_AT->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_site_settings_Created_AT" class="el_site_settings_Created_AT">
<span<?= $Page->Created_AT->viewAttributes() ?>>
<?= $Page->Created_AT->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->Created_BY->Visible) { // Created_BY ?>
        <td data-name="Created_BY"<?= $Page->Created_BY->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="site_settings" data-field="x_Created_BY" data-hidden="1" name="o<?= $Page->RowIndex ?>_Created_BY" id="o<?= $Page->RowIndex ?>_Created_BY" value="<?= HtmlEncode($Page->Created_BY->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_site_settings_Created_BY" class="el_site_settings_Created_BY">
<span<?= $Page->Created_BY->viewAttributes() ?>>
<?= $Page->Created_BY->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->IP->Visible) { // IP ?>
        <td data-name="IP"<?= $Page->IP->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="site_settings" data-field="x_IP" data-hidden="1" name="o<?= $Page->RowIndex ?>_IP" id="o<?= $Page->RowIndex ?>_IP" value="<?= HtmlEncode($Page->IP->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_site_settings_IP" class="el_site_settings_IP">
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
loadjs.ready(["fsite_settingslist","load"], () => fsite_settingslist.updateLists(<?= $Page->RowIndex ?>));
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
    $Page->RowAttrs->merge(["data-rowindex" => $Page->RowIndex, "id" => "r0_site_settings", "data-rowtype" => ROWTYPE_ADD]);
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
<span id="el$rowindex$_site_settings_ID" class="el_site_settings_ID"></span>
<input type="hidden" data-table="site_settings" data-field="x_ID" data-hidden="1" name="o<?= $Page->RowIndex ?>_ID" id="o<?= $Page->RowIndex ?>_ID" value="<?= HtmlEncode($Page->ID->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->Contact_No_1->Visible) { // Contact_No_1 ?>
        <td data-name="Contact_No_1">
<span id="el$rowindex$_site_settings_Contact_No_1" class="el_site_settings_Contact_No_1">
<input type="<?= $Page->Contact_No_1->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_Contact_No_1" id="x<?= $Page->RowIndex ?>_Contact_No_1" data-table="site_settings" data-field="x_Contact_No_1" value="<?= $Page->Contact_No_1->EditValue ?>" size="30" maxlength="10" placeholder="<?= HtmlEncode($Page->Contact_No_1->getPlaceHolder()) ?>"<?= $Page->Contact_No_1->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Contact_No_1->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="site_settings" data-field="x_Contact_No_1" data-hidden="1" name="o<?= $Page->RowIndex ?>_Contact_No_1" id="o<?= $Page->RowIndex ?>_Contact_No_1" value="<?= HtmlEncode($Page->Contact_No_1->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->Contact_No_2->Visible) { // Contact_No_2 ?>
        <td data-name="Contact_No_2">
<span id="el$rowindex$_site_settings_Contact_No_2" class="el_site_settings_Contact_No_2">
<input type="<?= $Page->Contact_No_2->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_Contact_No_2" id="x<?= $Page->RowIndex ?>_Contact_No_2" data-table="site_settings" data-field="x_Contact_No_2" value="<?= $Page->Contact_No_2->EditValue ?>" size="30" maxlength="10" placeholder="<?= HtmlEncode($Page->Contact_No_2->getPlaceHolder()) ?>"<?= $Page->Contact_No_2->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Contact_No_2->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="site_settings" data-field="x_Contact_No_2" data-hidden="1" name="o<?= $Page->RowIndex ?>_Contact_No_2" id="o<?= $Page->RowIndex ?>_Contact_No_2" value="<?= HtmlEncode($Page->Contact_No_2->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->Brand_Name->Visible) { // Brand_Name ?>
        <td data-name="Brand_Name">
<span id="el$rowindex$_site_settings_Brand_Name" class="el_site_settings_Brand_Name">
<input type="<?= $Page->Brand_Name->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_Brand_Name" id="x<?= $Page->RowIndex ?>_Brand_Name" data-table="site_settings" data-field="x_Brand_Name" value="<?= $Page->Brand_Name->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->Brand_Name->getPlaceHolder()) ?>"<?= $Page->Brand_Name->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Brand_Name->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="site_settings" data-field="x_Brand_Name" data-hidden="1" name="o<?= $Page->RowIndex ?>_Brand_Name" id="o<?= $Page->RowIndex ?>_Brand_Name" value="<?= HtmlEncode($Page->Brand_Name->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->Logo->Visible) { // Logo ?>
        <td data-name="Logo">
<span id="el$rowindex$_site_settings_Logo" class="el_site_settings_Logo">
<div id="fd_x<?= $Page->RowIndex ?>_Logo" class="fileinput-button ew-file-drop-zone">
    <input type="file" class="form-control ew-file-input" title="<?= $Page->Logo->title() ?>" data-table="site_settings" data-field="x_Logo" name="x<?= $Page->RowIndex ?>_Logo" id="x<?= $Page->RowIndex ?>_Logo" lang="<?= CurrentLanguageID() ?>"<?= $Page->Logo->editAttributes() ?><?= ($Page->Logo->ReadOnly || $Page->Logo->Disabled) ? " disabled" : "" ?>>
    <div class="text-muted ew-file-text"><?= $Language->phrase("ChooseFile") ?></div>
</div>
<div class="invalid-feedback"><?= $Page->Logo->getErrorMessage() ?></div>
<input type="hidden" name="fn_x<?= $Page->RowIndex ?>_Logo" id= "fn_x<?= $Page->RowIndex ?>_Logo" value="<?= $Page->Logo->Upload->FileName ?>">
<input type="hidden" name="fa_x<?= $Page->RowIndex ?>_Logo" id= "fa_x<?= $Page->RowIndex ?>_Logo" value="0">
<input type="hidden" name="fs_x<?= $Page->RowIndex ?>_Logo" id= "fs_x<?= $Page->RowIndex ?>_Logo" value="255">
<input type="hidden" name="fx_x<?= $Page->RowIndex ?>_Logo" id= "fx_x<?= $Page->RowIndex ?>_Logo" value="<?= $Page->Logo->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?= $Page->RowIndex ?>_Logo" id= "fm_x<?= $Page->RowIndex ?>_Logo" value="<?= $Page->Logo->UploadMaxFileSize ?>">
<table id="ft_x<?= $Page->RowIndex ?>_Logo" class="table table-sm float-start ew-upload-table"><tbody class="files"></tbody></table>
</span>
<input type="hidden" data-table="site_settings" data-field="x_Logo" data-hidden="1" name="o<?= $Page->RowIndex ?>_Logo" id="o<?= $Page->RowIndex ?>_Logo" value="<?= HtmlEncode($Page->Logo->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->Favicon->Visible) { // Favicon ?>
        <td data-name="Favicon">
<span id="el$rowindex$_site_settings_Favicon" class="el_site_settings_Favicon">
<div id="fd_x<?= $Page->RowIndex ?>_Favicon" class="fileinput-button ew-file-drop-zone">
    <input type="file" class="form-control ew-file-input" title="<?= $Page->Favicon->title() ?>" data-table="site_settings" data-field="x_Favicon" name="x<?= $Page->RowIndex ?>_Favicon" id="x<?= $Page->RowIndex ?>_Favicon" lang="<?= CurrentLanguageID() ?>"<?= $Page->Favicon->editAttributes() ?><?= ($Page->Favicon->ReadOnly || $Page->Favicon->Disabled) ? " disabled" : "" ?>>
    <div class="text-muted ew-file-text"><?= $Language->phrase("ChooseFile") ?></div>
</div>
<div class="invalid-feedback"><?= $Page->Favicon->getErrorMessage() ?></div>
<input type="hidden" name="fn_x<?= $Page->RowIndex ?>_Favicon" id= "fn_x<?= $Page->RowIndex ?>_Favicon" value="<?= $Page->Favicon->Upload->FileName ?>">
<input type="hidden" name="fa_x<?= $Page->RowIndex ?>_Favicon" id= "fa_x<?= $Page->RowIndex ?>_Favicon" value="0">
<input type="hidden" name="fs_x<?= $Page->RowIndex ?>_Favicon" id= "fs_x<?= $Page->RowIndex ?>_Favicon" value="255">
<input type="hidden" name="fx_x<?= $Page->RowIndex ?>_Favicon" id= "fx_x<?= $Page->RowIndex ?>_Favicon" value="<?= $Page->Favicon->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?= $Page->RowIndex ?>_Favicon" id= "fm_x<?= $Page->RowIndex ?>_Favicon" value="<?= $Page->Favicon->UploadMaxFileSize ?>">
<table id="ft_x<?= $Page->RowIndex ?>_Favicon" class="table table-sm float-start ew-upload-table"><tbody class="files"></tbody></table>
</span>
<input type="hidden" data-table="site_settings" data-field="x_Favicon" data-hidden="1" name="o<?= $Page->RowIndex ?>_Favicon" id="o<?= $Page->RowIndex ?>_Favicon" value="<?= HtmlEncode($Page->Favicon->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->Facebook->Visible) { // Facebook ?>
        <td data-name="Facebook">
<span id="el$rowindex$_site_settings_Facebook" class="el_site_settings_Facebook">
<input type="<?= $Page->Facebook->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_Facebook" id="x<?= $Page->RowIndex ?>_Facebook" data-table="site_settings" data-field="x_Facebook" value="<?= $Page->Facebook->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->Facebook->getPlaceHolder()) ?>"<?= $Page->Facebook->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Facebook->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="site_settings" data-field="x_Facebook" data-hidden="1" name="o<?= $Page->RowIndex ?>_Facebook" id="o<?= $Page->RowIndex ?>_Facebook" value="<?= HtmlEncode($Page->Facebook->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->Twitter->Visible) { // Twitter ?>
        <td data-name="Twitter">
<span id="el$rowindex$_site_settings_Twitter" class="el_site_settings_Twitter">
<input type="<?= $Page->Twitter->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_Twitter" id="x<?= $Page->RowIndex ?>_Twitter" data-table="site_settings" data-field="x_Twitter" value="<?= $Page->Twitter->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->Twitter->getPlaceHolder()) ?>"<?= $Page->Twitter->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Twitter->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="site_settings" data-field="x_Twitter" data-hidden="1" name="o<?= $Page->RowIndex ?>_Twitter" id="o<?= $Page->RowIndex ?>_Twitter" value="<?= HtmlEncode($Page->Twitter->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->Instagram->Visible) { // Instagram ?>
        <td data-name="Instagram">
<span id="el$rowindex$_site_settings_Instagram" class="el_site_settings_Instagram">
<input type="<?= $Page->Instagram->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_Instagram" id="x<?= $Page->RowIndex ?>_Instagram" data-table="site_settings" data-field="x_Instagram" value="<?= $Page->Instagram->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->Instagram->getPlaceHolder()) ?>"<?= $Page->Instagram->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Instagram->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="site_settings" data-field="x_Instagram" data-hidden="1" name="o<?= $Page->RowIndex ?>_Instagram" id="o<?= $Page->RowIndex ?>_Instagram" value="<?= HtmlEncode($Page->Instagram->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->_Title->Visible) { // Title ?>
        <td data-name="_Title">
<span id="el$rowindex$_site_settings__Title" class="el_site_settings__Title">
<input type="<?= $Page->_Title->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>__Title" id="x<?= $Page->RowIndex ?>__Title" data-table="site_settings" data-field="x__Title" value="<?= $Page->_Title->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->_Title->getPlaceHolder()) ?>"<?= $Page->_Title->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->_Title->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="site_settings" data-field="x__Title" data-hidden="1" name="o<?= $Page->RowIndex ?>__Title" id="o<?= $Page->RowIndex ?>__Title" value="<?= HtmlEncode($Page->_Title->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->Active->Visible) { // Active ?>
        <td data-name="Active">
<span id="el$rowindex$_site_settings_Active" class="el_site_settings_Active">
<template id="tp_x<?= $Page->RowIndex ?>_Active">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="site_settings" data-field="x_Active" name="x<?= $Page->RowIndex ?>_Active" id="x<?= $Page->RowIndex ?>_Active"<?= $Page->Active->editAttributes() ?>>
        <label class="form-check-label"></label>
    </div>
</template>
<div id="dsl_x<?= $Page->RowIndex ?>_Active" class="ew-item-list"></div>
<selection-list hidden
    id="x<?= $Page->RowIndex ?>_Active"
    name="x<?= $Page->RowIndex ?>_Active"
    value="<?= HtmlEncode($Page->Active->CurrentValue) ?>"
    data-type="select-one"
    data-template="tp_x<?= $Page->RowIndex ?>_Active"
    data-bs-target="dsl_x<?= $Page->RowIndex ?>_Active"
    data-repeatcolumn="5"
    class="form-control<?= $Page->Active->isInvalidClass() ?>"
    data-table="site_settings"
    data-field="x_Active"
    data-value-separator="<?= $Page->Active->displayValueSeparatorAttribute() ?>"
    <?= $Page->Active->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Page->Active->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="site_settings" data-field="x_Active" data-hidden="1" name="o<?= $Page->RowIndex ?>_Active" id="o<?= $Page->RowIndex ?>_Active" value="<?= HtmlEncode($Page->Active->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->Created_AT->Visible) { // Created_AT ?>
        <td data-name="Created_AT">
<input type="hidden" data-table="site_settings" data-field="x_Created_AT" data-hidden="1" name="o<?= $Page->RowIndex ?>_Created_AT" id="o<?= $Page->RowIndex ?>_Created_AT" value="<?= HtmlEncode($Page->Created_AT->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->Created_BY->Visible) { // Created_BY ?>
        <td data-name="Created_BY">
<input type="hidden" data-table="site_settings" data-field="x_Created_BY" data-hidden="1" name="o<?= $Page->RowIndex ?>_Created_BY" id="o<?= $Page->RowIndex ?>_Created_BY" value="<?= HtmlEncode($Page->Created_BY->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->IP->Visible) { // IP ?>
        <td data-name="IP">
<input type="hidden" data-table="site_settings" data-field="x_IP" data-hidden="1" name="o<?= $Page->RowIndex ?>_IP" id="o<?= $Page->RowIndex ?>_IP" value="<?= HtmlEncode($Page->IP->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Page->ListOptions->render("body", "right", $Page->RowIndex);
?>
<script>
loadjs.ready(["fsite_settingslist","load"], () => fsite_settingslist.updateLists(<?= $Page->RowIndex ?>, true));
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
    ew.addEventHandlers("site_settings");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
