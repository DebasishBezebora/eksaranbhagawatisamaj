<?php

namespace PHPMaker2022\eksbs;

// Page object
$UserLevel2List = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { user_level2: currentTable } });
var currentForm, currentPageID;
var fuser_level2list;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fuser_level2list = new ew.Form("fuser_level2list", "list");
    currentPageID = ew.PAGE_ID = "list";
    currentForm = fuser_level2list;
    fuser_level2list.formKeyCountName = "<?= $Page->FormKeyCountName ?>";

    // Add fields
    var fields = currentTable.fields;
    fuser_level2list.addFields([
        ["userlevelid", [fields.userlevelid.visible && fields.userlevelid.required ? ew.Validators.required(fields.userlevelid.caption) : null, ew.Validators.userLevelId, ew.Validators.integer], fields.userlevelid.isInvalid],
        ["userlevelname", [fields.userlevelname.visible && fields.userlevelname.required ? ew.Validators.required(fields.userlevelname.caption) : null, ew.Validators.userLevelName('userlevelid')], fields.userlevelname.isInvalid]
    ]);

    // Check empty row
    fuser_level2list.emptyRow = function (rowIndex) {
        var fobj = this.getForm(),
            fields = [["userlevelid",false],["userlevelname",false]];
        if (fields.some(field => ew.valueChanged(fobj, rowIndex, ...field)))
            return false;
        return true;
    }

    // Form_CustomValidate
    fuser_level2list.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fuser_level2list.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    loadjs.done("fuser_level2list");
});
var fuser_level2srch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object for search
    fuser_level2srch = new ew.Form("fuser_level2srch", "list");
    currentSearchForm = fuser_level2srch;

    // Dynamic selection lists

    // Filters
    fuser_level2srch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("fuser_level2srch");
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
<form name="fuser_level2srch" id="fuser_level2srch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>">
<div id="fuser_level2srch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="user_level2">
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
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "" ? " active" : "" ?>" form="fuser_level2srch" data-ew-action="search-type"><?= $Language->phrase("QuickSearchAuto") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "=" ? " active" : "" ?>" form="fuser_level2srch" data-ew-action="search-type" data-search-type="="><?= $Language->phrase("QuickSearchExact") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "AND" ? " active" : "" ?>" form="fuser_level2srch" data-ew-action="search-type" data-search-type="AND"><?= $Language->phrase("QuickSearchAll") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "OR" ? " active" : "" ?>" form="fuser_level2srch" data-ew-action="search-type" data-search-type="OR"><?= $Language->phrase("QuickSearchAny") ?></button>
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
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> user_level2">
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
<form name="fuser_level2list" id="fuser_level2list" class="ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="user_level2">
<div id="gmp_user_level2" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_user_level2list" class="table table-bordered table-hover table-sm ew-table"><!-- .ew-table -->
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
<?php if ($Page->userlevelid->Visible) { // userlevelid ?>
        <th data-name="userlevelid" class="<?= $Page->userlevelid->headerCellClass() ?>"><div id="elh_user_level2_userlevelid" class="user_level2_userlevelid"><?= $Page->renderFieldHeader($Page->userlevelid) ?></div></th>
<?php } ?>
<?php if ($Page->userlevelname->Visible) { // userlevelname ?>
        <th data-name="userlevelname" class="<?= $Page->userlevelname->headerCellClass() ?>"><div id="elh_user_level2_userlevelname" class="user_level2_userlevelname"><?= $Page->renderFieldHeader($Page->userlevelname) ?></div></th>
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
            "id" => "r" . $Page->RowCount . "_user_level2",
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
    <?php if ($Page->userlevelid->Visible) { // userlevelid ?>
        <td data-name="userlevelid"<?= $Page->userlevelid->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_user_level2_userlevelid" class="el_user_level2_userlevelid">
<input type="<?= $Page->userlevelid->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_userlevelid" id="x<?= $Page->RowIndex ?>_userlevelid" data-table="user_level2" data-field="x_userlevelid" value="<?= $Page->userlevelid->EditValue ?>" size="30" maxlength="11" placeholder="<?= HtmlEncode($Page->userlevelid->getPlaceHolder()) ?>"<?= $Page->userlevelid->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->userlevelid->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="user_level2" data-field="x_userlevelid" data-hidden="1" name="o<?= $Page->RowIndex ?>_userlevelid" id="o<?= $Page->RowIndex ?>_userlevelid" value="<?= HtmlEncode($Page->userlevelid->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<input type="<?= $Page->userlevelid->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_userlevelid" id="x<?= $Page->RowIndex ?>_userlevelid" data-table="user_level2" data-field="x_userlevelid" value="<?= $Page->userlevelid->EditValue ?>" size="30" maxlength="11" placeholder="<?= HtmlEncode($Page->userlevelid->getPlaceHolder()) ?>"<?= $Page->userlevelid->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->userlevelid->getErrorMessage() ?></div>
<input type="hidden" data-table="user_level2" data-field="x_userlevelid" data-hidden="1" name="o<?= $Page->RowIndex ?>_userlevelid" id="o<?= $Page->RowIndex ?>_userlevelid" value="<?= HtmlEncode($Page->userlevelid->OldValue ?? $Page->userlevelid->CurrentValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_user_level2_userlevelid" class="el_user_level2_userlevelid">
<span<?= $Page->userlevelid->viewAttributes() ?>>
<?= $Page->userlevelid->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } else { ?>
            <input type="hidden" data-table="user_level2" data-field="x_userlevelid" data-hidden="1" name="x<?= $Page->RowIndex ?>_userlevelid" id="x<?= $Page->RowIndex ?>_userlevelid" value="<?= HtmlEncode($Page->userlevelid->CurrentValue) ?>">
    <?php } ?>
    <?php if ($Page->userlevelname->Visible) { // userlevelname ?>
        <td data-name="userlevelname"<?= $Page->userlevelname->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_user_level2_userlevelname" class="el_user_level2_userlevelname">
<input type="<?= $Page->userlevelname->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_userlevelname" id="x<?= $Page->RowIndex ?>_userlevelname" data-table="user_level2" data-field="x_userlevelname" value="<?= $Page->userlevelname->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->userlevelname->getPlaceHolder()) ?>"<?= $Page->userlevelname->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->userlevelname->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="user_level2" data-field="x_userlevelname" data-hidden="1" name="o<?= $Page->RowIndex ?>_userlevelname" id="o<?= $Page->RowIndex ?>_userlevelname" value="<?= HtmlEncode($Page->userlevelname->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_user_level2_userlevelname" class="el_user_level2_userlevelname">
<input type="<?= $Page->userlevelname->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_userlevelname" id="x<?= $Page->RowIndex ?>_userlevelname" data-table="user_level2" data-field="x_userlevelname" value="<?= $Page->userlevelname->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->userlevelname->getPlaceHolder()) ?>"<?= $Page->userlevelname->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->userlevelname->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_user_level2_userlevelname" class="el_user_level2_userlevelname">
<span<?= $Page->userlevelname->viewAttributes() ?>>
<?= $Page->userlevelname->getViewValue() ?></span>
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
loadjs.ready(["fuser_level2list","load"], () => fuser_level2list.updateLists(<?= $Page->RowIndex ?>));
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
    $Page->RowAttrs->merge(["data-rowindex" => $Page->RowIndex, "id" => "r0_user_level2", "data-rowtype" => ROWTYPE_ADD]);
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
    <?php if ($Page->userlevelid->Visible) { // userlevelid ?>
        <td data-name="userlevelid">
<span id="el$rowindex$_user_level2_userlevelid" class="el_user_level2_userlevelid">
<input type="<?= $Page->userlevelid->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_userlevelid" id="x<?= $Page->RowIndex ?>_userlevelid" data-table="user_level2" data-field="x_userlevelid" value="<?= $Page->userlevelid->EditValue ?>" size="30" maxlength="11" placeholder="<?= HtmlEncode($Page->userlevelid->getPlaceHolder()) ?>"<?= $Page->userlevelid->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->userlevelid->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="user_level2" data-field="x_userlevelid" data-hidden="1" name="o<?= $Page->RowIndex ?>_userlevelid" id="o<?= $Page->RowIndex ?>_userlevelid" value="<?= HtmlEncode($Page->userlevelid->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->userlevelname->Visible) { // userlevelname ?>
        <td data-name="userlevelname">
<span id="el$rowindex$_user_level2_userlevelname" class="el_user_level2_userlevelname">
<input type="<?= $Page->userlevelname->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_userlevelname" id="x<?= $Page->RowIndex ?>_userlevelname" data-table="user_level2" data-field="x_userlevelname" value="<?= $Page->userlevelname->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->userlevelname->getPlaceHolder()) ?>"<?= $Page->userlevelname->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->userlevelname->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="user_level2" data-field="x_userlevelname" data-hidden="1" name="o<?= $Page->RowIndex ?>_userlevelname" id="o<?= $Page->RowIndex ?>_userlevelname" value="<?= HtmlEncode($Page->userlevelname->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Page->ListOptions->render("body", "right", $Page->RowIndex);
?>
<script>
loadjs.ready(["fuser_level2list","load"], () => fuser_level2list.updateLists(<?= $Page->RowIndex ?>, true));
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
    ew.addEventHandlers("user_level2");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
