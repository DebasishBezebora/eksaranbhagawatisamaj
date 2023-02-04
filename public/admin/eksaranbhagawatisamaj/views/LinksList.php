<?php

namespace PHPMaker2022\eksbs;

// Page object
$LinksList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { links: currentTable } });
var currentForm, currentPageID;
var flinkslist;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    flinkslist = new ew.Form("flinkslist", "list");
    currentPageID = ew.PAGE_ID = "list";
    currentForm = flinkslist;
    flinkslist.formKeyCountName = "<?= $Page->FormKeyCountName ?>";

    // Add fields
    var fields = currentTable.fields;
    flinkslist.addFields([
        ["ID", [fields.ID.visible && fields.ID.required ? ew.Validators.required(fields.ID.caption) : null], fields.ID.isInvalid],
        ["Link_Name", [fields.Link_Name.visible && fields.Link_Name.required ? ew.Validators.required(fields.Link_Name.caption) : null], fields.Link_Name.isInvalid],
        ["URL_Slug", [fields.URL_Slug.visible && fields.URL_Slug.required ? ew.Validators.required(fields.URL_Slug.caption) : null], fields.URL_Slug.isInvalid],
        ["Video_1", [fields.Video_1.visible && fields.Video_1.required ? ew.Validators.required(fields.Video_1.caption) : null], fields.Video_1.isInvalid],
        ["Video_2", [fields.Video_2.visible && fields.Video_2.required ? ew.Validators.required(fields.Video_2.caption) : null], fields.Video_2.isInvalid],
        ["Video_3", [fields.Video_3.visible && fields.Video_3.required ? ew.Validators.required(fields.Video_3.caption) : null], fields.Video_3.isInvalid],
        ["_Title", [fields._Title.visible && fields._Title.required ? ew.Validators.required(fields._Title.caption) : null], fields._Title.isInvalid],
        ["Active", [fields.Active.visible && fields.Active.required ? ew.Validators.required(fields.Active.caption) : null], fields.Active.isInvalid],
        ["Created_AT", [fields.Created_AT.visible && fields.Created_AT.required ? ew.Validators.required(fields.Created_AT.caption) : null], fields.Created_AT.isInvalid],
        ["Created_BY", [fields.Created_BY.visible && fields.Created_BY.required ? ew.Validators.required(fields.Created_BY.caption) : null], fields.Created_BY.isInvalid],
        ["IP", [fields.IP.visible && fields.IP.required ? ew.Validators.required(fields.IP.caption) : null], fields.IP.isInvalid]
    ]);

    // Check empty row
    flinkslist.emptyRow = function (rowIndex) {
        var fobj = this.getForm(),
            fields = [["Link_Name",false],["URL_Slug",false],["Video_1",false],["Video_2",false],["Video_3",false],["_Title",false],["Active",true]];
        if (fields.some(field => ew.valueChanged(fobj, rowIndex, ...field)))
            return false;
        return true;
    }

    // Form_CustomValidate
    flinkslist.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    flinkslist.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    flinkslist.lists.Active = <?= $Page->Active->toClientList($Page) ?>;
    loadjs.done("flinkslist");
});
var flinkssrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object for search
    flinkssrch = new ew.Form("flinkssrch", "list");
    currentSearchForm = flinkssrch;

    // Dynamic selection lists

    // Filters
    flinkssrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("flinkssrch");
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
<form name="flinkssrch" id="flinkssrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>">
<div id="flinkssrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="links">
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
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "" ? " active" : "" ?>" form="flinkssrch" data-ew-action="search-type"><?= $Language->phrase("QuickSearchAuto") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "=" ? " active" : "" ?>" form="flinkssrch" data-ew-action="search-type" data-search-type="="><?= $Language->phrase("QuickSearchExact") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "AND" ? " active" : "" ?>" form="flinkssrch" data-ew-action="search-type" data-search-type="AND"><?= $Language->phrase("QuickSearchAll") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "OR" ? " active" : "" ?>" form="flinkssrch" data-ew-action="search-type" data-search-type="OR"><?= $Language->phrase("QuickSearchAny") ?></button>
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
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> links">
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
<form name="flinkslist" id="flinkslist" class="ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="links">
<div id="gmp_links" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_linkslist" class="table table-bordered table-hover table-sm ew-table"><!-- .ew-table -->
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
        <th data-name="ID" class="<?= $Page->ID->headerCellClass() ?>"><div id="elh_links_ID" class="links_ID"><?= $Page->renderFieldHeader($Page->ID) ?></div></th>
<?php } ?>
<?php if ($Page->Link_Name->Visible) { // Link_Name ?>
        <th data-name="Link_Name" class="<?= $Page->Link_Name->headerCellClass() ?>"><div id="elh_links_Link_Name" class="links_Link_Name"><?= $Page->renderFieldHeader($Page->Link_Name) ?></div></th>
<?php } ?>
<?php if ($Page->URL_Slug->Visible) { // URL_Slug ?>
        <th data-name="URL_Slug" class="<?= $Page->URL_Slug->headerCellClass() ?>"><div id="elh_links_URL_Slug" class="links_URL_Slug"><?= $Page->renderFieldHeader($Page->URL_Slug) ?></div></th>
<?php } ?>
<?php if ($Page->Video_1->Visible) { // Video_1 ?>
        <th data-name="Video_1" class="<?= $Page->Video_1->headerCellClass() ?>"><div id="elh_links_Video_1" class="links_Video_1"><?= $Page->renderFieldHeader($Page->Video_1) ?></div></th>
<?php } ?>
<?php if ($Page->Video_2->Visible) { // Video_2 ?>
        <th data-name="Video_2" class="<?= $Page->Video_2->headerCellClass() ?>"><div id="elh_links_Video_2" class="links_Video_2"><?= $Page->renderFieldHeader($Page->Video_2) ?></div></th>
<?php } ?>
<?php if ($Page->Video_3->Visible) { // Video_3 ?>
        <th data-name="Video_3" class="<?= $Page->Video_3->headerCellClass() ?>"><div id="elh_links_Video_3" class="links_Video_3"><?= $Page->renderFieldHeader($Page->Video_3) ?></div></th>
<?php } ?>
<?php if ($Page->_Title->Visible) { // Title ?>
        <th data-name="_Title" class="<?= $Page->_Title->headerCellClass() ?>"><div id="elh_links__Title" class="links__Title"><?= $Page->renderFieldHeader($Page->_Title) ?></div></th>
<?php } ?>
<?php if ($Page->Active->Visible) { // Active ?>
        <th data-name="Active" class="<?= $Page->Active->headerCellClass() ?>"><div id="elh_links_Active" class="links_Active"><?= $Page->renderFieldHeader($Page->Active) ?></div></th>
<?php } ?>
<?php if ($Page->Created_AT->Visible) { // Created_AT ?>
        <th data-name="Created_AT" class="<?= $Page->Created_AT->headerCellClass() ?>"><div id="elh_links_Created_AT" class="links_Created_AT"><?= $Page->renderFieldHeader($Page->Created_AT) ?></div></th>
<?php } ?>
<?php if ($Page->Created_BY->Visible) { // Created_BY ?>
        <th data-name="Created_BY" class="<?= $Page->Created_BY->headerCellClass() ?>"><div id="elh_links_Created_BY" class="links_Created_BY"><?= $Page->renderFieldHeader($Page->Created_BY) ?></div></th>
<?php } ?>
<?php if ($Page->IP->Visible) { // IP ?>
        <th data-name="IP" class="<?= $Page->IP->headerCellClass() ?>"><div id="elh_links_IP" class="links_IP"><?= $Page->renderFieldHeader($Page->IP) ?></div></th>
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
            "id" => "r" . $Page->RowCount . "_links",
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
<span id="el<?= $Page->RowCount ?>_links_ID" class="el_links_ID"></span>
<input type="hidden" data-table="links" data-field="x_ID" data-hidden="1" name="o<?= $Page->RowIndex ?>_ID" id="o<?= $Page->RowIndex ?>_ID" value="<?= HtmlEncode($Page->ID->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_links_ID" class="el_links_ID">
<span<?= $Page->ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->ID->getDisplayValue($Page->ID->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="links" data-field="x_ID" data-hidden="1" name="x<?= $Page->RowIndex ?>_ID" id="x<?= $Page->RowIndex ?>_ID" value="<?= HtmlEncode($Page->ID->CurrentValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_links_ID" class="el_links_ID">
<span<?= $Page->ID->viewAttributes() ?>>
<?= $Page->ID->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } else { ?>
            <input type="hidden" data-table="links" data-field="x_ID" data-hidden="1" name="x<?= $Page->RowIndex ?>_ID" id="x<?= $Page->RowIndex ?>_ID" value="<?= HtmlEncode($Page->ID->CurrentValue) ?>">
    <?php } ?>
    <?php if ($Page->Link_Name->Visible) { // Link_Name ?>
        <td data-name="Link_Name"<?= $Page->Link_Name->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_links_Link_Name" class="el_links_Link_Name">
<input type="<?= $Page->Link_Name->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_Link_Name" id="x<?= $Page->RowIndex ?>_Link_Name" data-table="links" data-field="x_Link_Name" value="<?= $Page->Link_Name->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->Link_Name->getPlaceHolder()) ?>"<?= $Page->Link_Name->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Link_Name->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="links" data-field="x_Link_Name" data-hidden="1" name="o<?= $Page->RowIndex ?>_Link_Name" id="o<?= $Page->RowIndex ?>_Link_Name" value="<?= HtmlEncode($Page->Link_Name->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_links_Link_Name" class="el_links_Link_Name">
<input type="<?= $Page->Link_Name->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_Link_Name" id="x<?= $Page->RowIndex ?>_Link_Name" data-table="links" data-field="x_Link_Name" value="<?= $Page->Link_Name->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->Link_Name->getPlaceHolder()) ?>"<?= $Page->Link_Name->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Link_Name->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_links_Link_Name" class="el_links_Link_Name">
<span<?= $Page->Link_Name->viewAttributes() ?>>
<?= $Page->Link_Name->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->URL_Slug->Visible) { // URL_Slug ?>
        <td data-name="URL_Slug"<?= $Page->URL_Slug->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_links_URL_Slug" class="el_links_URL_Slug">
<input type="<?= $Page->URL_Slug->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_URL_Slug" id="x<?= $Page->RowIndex ?>_URL_Slug" data-table="links" data-field="x_URL_Slug" value="<?= $Page->URL_Slug->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->URL_Slug->getPlaceHolder()) ?>"<?= $Page->URL_Slug->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->URL_Slug->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="links" data-field="x_URL_Slug" data-hidden="1" name="o<?= $Page->RowIndex ?>_URL_Slug" id="o<?= $Page->RowIndex ?>_URL_Slug" value="<?= HtmlEncode($Page->URL_Slug->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_links_URL_Slug" class="el_links_URL_Slug">
<input type="<?= $Page->URL_Slug->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_URL_Slug" id="x<?= $Page->RowIndex ?>_URL_Slug" data-table="links" data-field="x_URL_Slug" value="<?= $Page->URL_Slug->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->URL_Slug->getPlaceHolder()) ?>"<?= $Page->URL_Slug->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->URL_Slug->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_links_URL_Slug" class="el_links_URL_Slug">
<span<?= $Page->URL_Slug->viewAttributes() ?>>
<?= $Page->URL_Slug->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->Video_1->Visible) { // Video_1 ?>
        <td data-name="Video_1"<?= $Page->Video_1->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_links_Video_1" class="el_links_Video_1">
<input type="<?= $Page->Video_1->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_Video_1" id="x<?= $Page->RowIndex ?>_Video_1" data-table="links" data-field="x_Video_1" value="<?= $Page->Video_1->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->Video_1->getPlaceHolder()) ?>"<?= $Page->Video_1->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Video_1->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="links" data-field="x_Video_1" data-hidden="1" name="o<?= $Page->RowIndex ?>_Video_1" id="o<?= $Page->RowIndex ?>_Video_1" value="<?= HtmlEncode($Page->Video_1->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_links_Video_1" class="el_links_Video_1">
<input type="<?= $Page->Video_1->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_Video_1" id="x<?= $Page->RowIndex ?>_Video_1" data-table="links" data-field="x_Video_1" value="<?= $Page->Video_1->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->Video_1->getPlaceHolder()) ?>"<?= $Page->Video_1->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Video_1->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_links_Video_1" class="el_links_Video_1">
<span<?= $Page->Video_1->viewAttributes() ?>>
<?= $Page->Video_1->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->Video_2->Visible) { // Video_2 ?>
        <td data-name="Video_2"<?= $Page->Video_2->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_links_Video_2" class="el_links_Video_2">
<input type="<?= $Page->Video_2->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_Video_2" id="x<?= $Page->RowIndex ?>_Video_2" data-table="links" data-field="x_Video_2" value="<?= $Page->Video_2->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->Video_2->getPlaceHolder()) ?>"<?= $Page->Video_2->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Video_2->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="links" data-field="x_Video_2" data-hidden="1" name="o<?= $Page->RowIndex ?>_Video_2" id="o<?= $Page->RowIndex ?>_Video_2" value="<?= HtmlEncode($Page->Video_2->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_links_Video_2" class="el_links_Video_2">
<input type="<?= $Page->Video_2->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_Video_2" id="x<?= $Page->RowIndex ?>_Video_2" data-table="links" data-field="x_Video_2" value="<?= $Page->Video_2->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->Video_2->getPlaceHolder()) ?>"<?= $Page->Video_2->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Video_2->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_links_Video_2" class="el_links_Video_2">
<span<?= $Page->Video_2->viewAttributes() ?>>
<?= $Page->Video_2->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->Video_3->Visible) { // Video_3 ?>
        <td data-name="Video_3"<?= $Page->Video_3->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_links_Video_3" class="el_links_Video_3">
<input type="<?= $Page->Video_3->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_Video_3" id="x<?= $Page->RowIndex ?>_Video_3" data-table="links" data-field="x_Video_3" value="<?= $Page->Video_3->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->Video_3->getPlaceHolder()) ?>"<?= $Page->Video_3->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Video_3->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="links" data-field="x_Video_3" data-hidden="1" name="o<?= $Page->RowIndex ?>_Video_3" id="o<?= $Page->RowIndex ?>_Video_3" value="<?= HtmlEncode($Page->Video_3->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_links_Video_3" class="el_links_Video_3">
<input type="<?= $Page->Video_3->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_Video_3" id="x<?= $Page->RowIndex ?>_Video_3" data-table="links" data-field="x_Video_3" value="<?= $Page->Video_3->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->Video_3->getPlaceHolder()) ?>"<?= $Page->Video_3->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Video_3->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_links_Video_3" class="el_links_Video_3">
<span<?= $Page->Video_3->viewAttributes() ?>>
<?= $Page->Video_3->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->_Title->Visible) { // Title ?>
        <td data-name="_Title"<?= $Page->_Title->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_links__Title" class="el_links__Title">
<input type="<?= $Page->_Title->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>__Title" id="x<?= $Page->RowIndex ?>__Title" data-table="links" data-field="x__Title" value="<?= $Page->_Title->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->_Title->getPlaceHolder()) ?>"<?= $Page->_Title->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->_Title->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="links" data-field="x__Title" data-hidden="1" name="o<?= $Page->RowIndex ?>__Title" id="o<?= $Page->RowIndex ?>__Title" value="<?= HtmlEncode($Page->_Title->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_links__Title" class="el_links__Title">
<input type="<?= $Page->_Title->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>__Title" id="x<?= $Page->RowIndex ?>__Title" data-table="links" data-field="x__Title" value="<?= $Page->_Title->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->_Title->getPlaceHolder()) ?>"<?= $Page->_Title->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->_Title->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_links__Title" class="el_links__Title">
<span<?= $Page->_Title->viewAttributes() ?>>
<?= $Page->_Title->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->Active->Visible) { // Active ?>
        <td data-name="Active"<?= $Page->Active->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_links_Active" class="el_links_Active">
<template id="tp_x<?= $Page->RowIndex ?>_Active">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="links" data-field="x_Active" name="x<?= $Page->RowIndex ?>_Active" id="x<?= $Page->RowIndex ?>_Active"<?= $Page->Active->editAttributes() ?>>
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
    data-table="links"
    data-field="x_Active"
    data-value-separator="<?= $Page->Active->displayValueSeparatorAttribute() ?>"
    <?= $Page->Active->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Page->Active->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="links" data-field="x_Active" data-hidden="1" name="o<?= $Page->RowIndex ?>_Active" id="o<?= $Page->RowIndex ?>_Active" value="<?= HtmlEncode($Page->Active->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_links_Active" class="el_links_Active">
<template id="tp_x<?= $Page->RowIndex ?>_Active">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="links" data-field="x_Active" name="x<?= $Page->RowIndex ?>_Active" id="x<?= $Page->RowIndex ?>_Active"<?= $Page->Active->editAttributes() ?>>
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
    data-table="links"
    data-field="x_Active"
    data-value-separator="<?= $Page->Active->displayValueSeparatorAttribute() ?>"
    <?= $Page->Active->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Page->Active->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_links_Active" class="el_links_Active">
<span<?= $Page->Active->viewAttributes() ?>>
<?= $Page->Active->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->Created_AT->Visible) { // Created_AT ?>
        <td data-name="Created_AT"<?= $Page->Created_AT->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="links" data-field="x_Created_AT" data-hidden="1" name="o<?= $Page->RowIndex ?>_Created_AT" id="o<?= $Page->RowIndex ?>_Created_AT" value="<?= HtmlEncode($Page->Created_AT->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_links_Created_AT" class="el_links_Created_AT">
<span<?= $Page->Created_AT->viewAttributes() ?>>
<?= $Page->Created_AT->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->Created_BY->Visible) { // Created_BY ?>
        <td data-name="Created_BY"<?= $Page->Created_BY->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="links" data-field="x_Created_BY" data-hidden="1" name="o<?= $Page->RowIndex ?>_Created_BY" id="o<?= $Page->RowIndex ?>_Created_BY" value="<?= HtmlEncode($Page->Created_BY->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_links_Created_BY" class="el_links_Created_BY">
<span<?= $Page->Created_BY->viewAttributes() ?>>
<?= $Page->Created_BY->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->IP->Visible) { // IP ?>
        <td data-name="IP"<?= $Page->IP->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="links" data-field="x_IP" data-hidden="1" name="o<?= $Page->RowIndex ?>_IP" id="o<?= $Page->RowIndex ?>_IP" value="<?= HtmlEncode($Page->IP->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_links_IP" class="el_links_IP">
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
loadjs.ready(["flinkslist","load"], () => flinkslist.updateLists(<?= $Page->RowIndex ?>));
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
    $Page->RowAttrs->merge(["data-rowindex" => $Page->RowIndex, "id" => "r0_links", "data-rowtype" => ROWTYPE_ADD]);
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
<span id="el$rowindex$_links_ID" class="el_links_ID"></span>
<input type="hidden" data-table="links" data-field="x_ID" data-hidden="1" name="o<?= $Page->RowIndex ?>_ID" id="o<?= $Page->RowIndex ?>_ID" value="<?= HtmlEncode($Page->ID->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->Link_Name->Visible) { // Link_Name ?>
        <td data-name="Link_Name">
<span id="el$rowindex$_links_Link_Name" class="el_links_Link_Name">
<input type="<?= $Page->Link_Name->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_Link_Name" id="x<?= $Page->RowIndex ?>_Link_Name" data-table="links" data-field="x_Link_Name" value="<?= $Page->Link_Name->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->Link_Name->getPlaceHolder()) ?>"<?= $Page->Link_Name->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Link_Name->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="links" data-field="x_Link_Name" data-hidden="1" name="o<?= $Page->RowIndex ?>_Link_Name" id="o<?= $Page->RowIndex ?>_Link_Name" value="<?= HtmlEncode($Page->Link_Name->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->URL_Slug->Visible) { // URL_Slug ?>
        <td data-name="URL_Slug">
<span id="el$rowindex$_links_URL_Slug" class="el_links_URL_Slug">
<input type="<?= $Page->URL_Slug->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_URL_Slug" id="x<?= $Page->RowIndex ?>_URL_Slug" data-table="links" data-field="x_URL_Slug" value="<?= $Page->URL_Slug->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->URL_Slug->getPlaceHolder()) ?>"<?= $Page->URL_Slug->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->URL_Slug->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="links" data-field="x_URL_Slug" data-hidden="1" name="o<?= $Page->RowIndex ?>_URL_Slug" id="o<?= $Page->RowIndex ?>_URL_Slug" value="<?= HtmlEncode($Page->URL_Slug->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->Video_1->Visible) { // Video_1 ?>
        <td data-name="Video_1">
<span id="el$rowindex$_links_Video_1" class="el_links_Video_1">
<input type="<?= $Page->Video_1->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_Video_1" id="x<?= $Page->RowIndex ?>_Video_1" data-table="links" data-field="x_Video_1" value="<?= $Page->Video_1->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->Video_1->getPlaceHolder()) ?>"<?= $Page->Video_1->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Video_1->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="links" data-field="x_Video_1" data-hidden="1" name="o<?= $Page->RowIndex ?>_Video_1" id="o<?= $Page->RowIndex ?>_Video_1" value="<?= HtmlEncode($Page->Video_1->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->Video_2->Visible) { // Video_2 ?>
        <td data-name="Video_2">
<span id="el$rowindex$_links_Video_2" class="el_links_Video_2">
<input type="<?= $Page->Video_2->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_Video_2" id="x<?= $Page->RowIndex ?>_Video_2" data-table="links" data-field="x_Video_2" value="<?= $Page->Video_2->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->Video_2->getPlaceHolder()) ?>"<?= $Page->Video_2->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Video_2->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="links" data-field="x_Video_2" data-hidden="1" name="o<?= $Page->RowIndex ?>_Video_2" id="o<?= $Page->RowIndex ?>_Video_2" value="<?= HtmlEncode($Page->Video_2->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->Video_3->Visible) { // Video_3 ?>
        <td data-name="Video_3">
<span id="el$rowindex$_links_Video_3" class="el_links_Video_3">
<input type="<?= $Page->Video_3->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_Video_3" id="x<?= $Page->RowIndex ?>_Video_3" data-table="links" data-field="x_Video_3" value="<?= $Page->Video_3->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->Video_3->getPlaceHolder()) ?>"<?= $Page->Video_3->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Video_3->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="links" data-field="x_Video_3" data-hidden="1" name="o<?= $Page->RowIndex ?>_Video_3" id="o<?= $Page->RowIndex ?>_Video_3" value="<?= HtmlEncode($Page->Video_3->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->_Title->Visible) { // Title ?>
        <td data-name="_Title">
<span id="el$rowindex$_links__Title" class="el_links__Title">
<input type="<?= $Page->_Title->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>__Title" id="x<?= $Page->RowIndex ?>__Title" data-table="links" data-field="x__Title" value="<?= $Page->_Title->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->_Title->getPlaceHolder()) ?>"<?= $Page->_Title->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->_Title->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="links" data-field="x__Title" data-hidden="1" name="o<?= $Page->RowIndex ?>__Title" id="o<?= $Page->RowIndex ?>__Title" value="<?= HtmlEncode($Page->_Title->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->Active->Visible) { // Active ?>
        <td data-name="Active">
<span id="el$rowindex$_links_Active" class="el_links_Active">
<template id="tp_x<?= $Page->RowIndex ?>_Active">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="links" data-field="x_Active" name="x<?= $Page->RowIndex ?>_Active" id="x<?= $Page->RowIndex ?>_Active"<?= $Page->Active->editAttributes() ?>>
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
    data-table="links"
    data-field="x_Active"
    data-value-separator="<?= $Page->Active->displayValueSeparatorAttribute() ?>"
    <?= $Page->Active->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Page->Active->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="links" data-field="x_Active" data-hidden="1" name="o<?= $Page->RowIndex ?>_Active" id="o<?= $Page->RowIndex ?>_Active" value="<?= HtmlEncode($Page->Active->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->Created_AT->Visible) { // Created_AT ?>
        <td data-name="Created_AT">
<input type="hidden" data-table="links" data-field="x_Created_AT" data-hidden="1" name="o<?= $Page->RowIndex ?>_Created_AT" id="o<?= $Page->RowIndex ?>_Created_AT" value="<?= HtmlEncode($Page->Created_AT->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->Created_BY->Visible) { // Created_BY ?>
        <td data-name="Created_BY">
<input type="hidden" data-table="links" data-field="x_Created_BY" data-hidden="1" name="o<?= $Page->RowIndex ?>_Created_BY" id="o<?= $Page->RowIndex ?>_Created_BY" value="<?= HtmlEncode($Page->Created_BY->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->IP->Visible) { // IP ?>
        <td data-name="IP">
<input type="hidden" data-table="links" data-field="x_IP" data-hidden="1" name="o<?= $Page->RowIndex ?>_IP" id="o<?= $Page->RowIndex ?>_IP" value="<?= HtmlEncode($Page->IP->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Page->ListOptions->render("body", "right", $Page->RowIndex);
?>
<script>
loadjs.ready(["flinkslist","load"], () => flinkslist.updateLists(<?= $Page->RowIndex ?>, true));
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
    ew.addEventHandlers("links");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
