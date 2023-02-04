<?php

namespace PHPMaker2022\eksbs;

// Page object
$EventCategoryList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { event_category: currentTable } });
var currentForm, currentPageID;
var fevent_categorylist;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fevent_categorylist = new ew.Form("fevent_categorylist", "list");
    currentPageID = ew.PAGE_ID = "list";
    currentForm = fevent_categorylist;
    fevent_categorylist.formKeyCountName = "<?= $Page->FormKeyCountName ?>";

    // Add fields
    var fields = currentTable.fields;
    fevent_categorylist.addFields([
        ["ID", [fields.ID.visible && fields.ID.required ? ew.Validators.required(fields.ID.caption) : null], fields.ID.isInvalid],
        ["Category", [fields.Category.visible && fields.Category.required ? ew.Validators.required(fields.Category.caption) : null], fields.Category.isInvalid],
        ["Active", [fields.Active.visible && fields.Active.required ? ew.Validators.required(fields.Active.caption) : null], fields.Active.isInvalid],
        ["Created_BY", [fields.Created_BY.visible && fields.Created_BY.required ? ew.Validators.required(fields.Created_BY.caption) : null], fields.Created_BY.isInvalid],
        ["Created_AT", [fields.Created_AT.visible && fields.Created_AT.required ? ew.Validators.required(fields.Created_AT.caption) : null], fields.Created_AT.isInvalid],
        ["IP", [fields.IP.visible && fields.IP.required ? ew.Validators.required(fields.IP.caption) : null], fields.IP.isInvalid]
    ]);

    // Check empty row
    fevent_categorylist.emptyRow = function (rowIndex) {
        var fobj = this.getForm(),
            fields = [["Category",false],["Active",true]];
        if (fields.some(field => ew.valueChanged(fobj, rowIndex, ...field)))
            return false;
        return true;
    }

    // Form_CustomValidate
    fevent_categorylist.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    fevent_categorylist.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    fevent_categorylist.lists.Active = <?= $Page->Active->toClientList($Page) ?>;
    loadjs.done("fevent_categorylist");
});
var fevent_categorysrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object for search
    fevent_categorysrch = new ew.Form("fevent_categorysrch", "list");
    currentSearchForm = fevent_categorysrch;

    // Dynamic selection lists

    // Filters
    fevent_categorysrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("fevent_categorysrch");
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
<form name="fevent_categorysrch" id="fevent_categorysrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>">
<div id="fevent_categorysrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="event_category">
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
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "" ? " active" : "" ?>" form="fevent_categorysrch" data-ew-action="search-type"><?= $Language->phrase("QuickSearchAuto") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "=" ? " active" : "" ?>" form="fevent_categorysrch" data-ew-action="search-type" data-search-type="="><?= $Language->phrase("QuickSearchExact") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "AND" ? " active" : "" ?>" form="fevent_categorysrch" data-ew-action="search-type" data-search-type="AND"><?= $Language->phrase("QuickSearchAll") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "OR" ? " active" : "" ?>" form="fevent_categorysrch" data-ew-action="search-type" data-search-type="OR"><?= $Language->phrase("QuickSearchAny") ?></button>
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
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> event_category">
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
<form name="fevent_categorylist" id="fevent_categorylist" class="ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="event_category">
<div id="gmp_event_category" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_event_categorylist" class="table table-bordered table-hover table-sm ew-table"><!-- .ew-table -->
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
        <th data-name="ID" class="<?= $Page->ID->headerCellClass() ?>"><div id="elh_event_category_ID" class="event_category_ID"><?= $Page->renderFieldHeader($Page->ID) ?></div></th>
<?php } ?>
<?php if ($Page->Category->Visible) { // Category ?>
        <th data-name="Category" class="<?= $Page->Category->headerCellClass() ?>"><div id="elh_event_category_Category" class="event_category_Category"><?= $Page->renderFieldHeader($Page->Category) ?></div></th>
<?php } ?>
<?php if ($Page->Active->Visible) { // Active ?>
        <th data-name="Active" class="<?= $Page->Active->headerCellClass() ?>"><div id="elh_event_category_Active" class="event_category_Active"><?= $Page->renderFieldHeader($Page->Active) ?></div></th>
<?php } ?>
<?php if ($Page->Created_BY->Visible) { // Created_BY ?>
        <th data-name="Created_BY" class="<?= $Page->Created_BY->headerCellClass() ?>"><div id="elh_event_category_Created_BY" class="event_category_Created_BY"><?= $Page->renderFieldHeader($Page->Created_BY) ?></div></th>
<?php } ?>
<?php if ($Page->Created_AT->Visible) { // Created_AT ?>
        <th data-name="Created_AT" class="<?= $Page->Created_AT->headerCellClass() ?>"><div id="elh_event_category_Created_AT" class="event_category_Created_AT"><?= $Page->renderFieldHeader($Page->Created_AT) ?></div></th>
<?php } ?>
<?php if ($Page->IP->Visible) { // IP ?>
        <th data-name="IP" class="<?= $Page->IP->headerCellClass() ?>"><div id="elh_event_category_IP" class="event_category_IP"><?= $Page->renderFieldHeader($Page->IP) ?></div></th>
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
            "id" => "r" . $Page->RowCount . "_event_category",
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
<span id="el<?= $Page->RowCount ?>_event_category_ID" class="el_event_category_ID"></span>
<input type="hidden" data-table="event_category" data-field="x_ID" data-hidden="1" name="o<?= $Page->RowIndex ?>_ID" id="o<?= $Page->RowIndex ?>_ID" value="<?= HtmlEncode($Page->ID->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_event_category_ID" class="el_event_category_ID">
<span<?= $Page->ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->ID->getDisplayValue($Page->ID->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="event_category" data-field="x_ID" data-hidden="1" name="x<?= $Page->RowIndex ?>_ID" id="x<?= $Page->RowIndex ?>_ID" value="<?= HtmlEncode($Page->ID->CurrentValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_event_category_ID" class="el_event_category_ID">
<span<?= $Page->ID->viewAttributes() ?>>
<?= $Page->ID->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } else { ?>
            <input type="hidden" data-table="event_category" data-field="x_ID" data-hidden="1" name="x<?= $Page->RowIndex ?>_ID" id="x<?= $Page->RowIndex ?>_ID" value="<?= HtmlEncode($Page->ID->CurrentValue) ?>">
    <?php } ?>
    <?php if ($Page->Category->Visible) { // Category ?>
        <td data-name="Category"<?= $Page->Category->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_event_category_Category" class="el_event_category_Category">
<input type="<?= $Page->Category->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_Category" id="x<?= $Page->RowIndex ?>_Category" data-table="event_category" data-field="x_Category" value="<?= $Page->Category->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->Category->getPlaceHolder()) ?>"<?= $Page->Category->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Category->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="event_category" data-field="x_Category" data-hidden="1" name="o<?= $Page->RowIndex ?>_Category" id="o<?= $Page->RowIndex ?>_Category" value="<?= HtmlEncode($Page->Category->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_event_category_Category" class="el_event_category_Category">
<input type="<?= $Page->Category->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_Category" id="x<?= $Page->RowIndex ?>_Category" data-table="event_category" data-field="x_Category" value="<?= $Page->Category->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->Category->getPlaceHolder()) ?>"<?= $Page->Category->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Category->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_event_category_Category" class="el_event_category_Category">
<span<?= $Page->Category->viewAttributes() ?>>
<?= $Page->Category->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->Active->Visible) { // Active ?>
        <td data-name="Active"<?= $Page->Active->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_event_category_Active" class="el_event_category_Active">
<template id="tp_x<?= $Page->RowIndex ?>_Active">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="event_category" data-field="x_Active" name="x<?= $Page->RowIndex ?>_Active" id="x<?= $Page->RowIndex ?>_Active"<?= $Page->Active->editAttributes() ?>>
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
    data-table="event_category"
    data-field="x_Active"
    data-value-separator="<?= $Page->Active->displayValueSeparatorAttribute() ?>"
    <?= $Page->Active->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Page->Active->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="event_category" data-field="x_Active" data-hidden="1" name="o<?= $Page->RowIndex ?>_Active" id="o<?= $Page->RowIndex ?>_Active" value="<?= HtmlEncode($Page->Active->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_event_category_Active" class="el_event_category_Active">
<template id="tp_x<?= $Page->RowIndex ?>_Active">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="event_category" data-field="x_Active" name="x<?= $Page->RowIndex ?>_Active" id="x<?= $Page->RowIndex ?>_Active"<?= $Page->Active->editAttributes() ?>>
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
    data-table="event_category"
    data-field="x_Active"
    data-value-separator="<?= $Page->Active->displayValueSeparatorAttribute() ?>"
    <?= $Page->Active->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Page->Active->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_event_category_Active" class="el_event_category_Active">
<span<?= $Page->Active->viewAttributes() ?>>
<?= $Page->Active->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->Created_BY->Visible) { // Created_BY ?>
        <td data-name="Created_BY"<?= $Page->Created_BY->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="event_category" data-field="x_Created_BY" data-hidden="1" name="o<?= $Page->RowIndex ?>_Created_BY" id="o<?= $Page->RowIndex ?>_Created_BY" value="<?= HtmlEncode($Page->Created_BY->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_event_category_Created_BY" class="el_event_category_Created_BY">
<span<?= $Page->Created_BY->viewAttributes() ?>>
<?= $Page->Created_BY->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->Created_AT->Visible) { // Created_AT ?>
        <td data-name="Created_AT"<?= $Page->Created_AT->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="event_category" data-field="x_Created_AT" data-hidden="1" name="o<?= $Page->RowIndex ?>_Created_AT" id="o<?= $Page->RowIndex ?>_Created_AT" value="<?= HtmlEncode($Page->Created_AT->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_event_category_Created_AT" class="el_event_category_Created_AT">
<span<?= $Page->Created_AT->viewAttributes() ?>>
<?= $Page->Created_AT->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->IP->Visible) { // IP ?>
        <td data-name="IP"<?= $Page->IP->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="event_category" data-field="x_IP" data-hidden="1" name="o<?= $Page->RowIndex ?>_IP" id="o<?= $Page->RowIndex ?>_IP" value="<?= HtmlEncode($Page->IP->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_event_category_IP" class="el_event_category_IP">
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
loadjs.ready(["fevent_categorylist","load"], () => fevent_categorylist.updateLists(<?= $Page->RowIndex ?>));
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
    $Page->RowAttrs->merge(["data-rowindex" => $Page->RowIndex, "id" => "r0_event_category", "data-rowtype" => ROWTYPE_ADD]);
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
<span id="el$rowindex$_event_category_ID" class="el_event_category_ID"></span>
<input type="hidden" data-table="event_category" data-field="x_ID" data-hidden="1" name="o<?= $Page->RowIndex ?>_ID" id="o<?= $Page->RowIndex ?>_ID" value="<?= HtmlEncode($Page->ID->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->Category->Visible) { // Category ?>
        <td data-name="Category">
<span id="el$rowindex$_event_category_Category" class="el_event_category_Category">
<input type="<?= $Page->Category->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_Category" id="x<?= $Page->RowIndex ?>_Category" data-table="event_category" data-field="x_Category" value="<?= $Page->Category->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->Category->getPlaceHolder()) ?>"<?= $Page->Category->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Category->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="event_category" data-field="x_Category" data-hidden="1" name="o<?= $Page->RowIndex ?>_Category" id="o<?= $Page->RowIndex ?>_Category" value="<?= HtmlEncode($Page->Category->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->Active->Visible) { // Active ?>
        <td data-name="Active">
<span id="el$rowindex$_event_category_Active" class="el_event_category_Active">
<template id="tp_x<?= $Page->RowIndex ?>_Active">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="event_category" data-field="x_Active" name="x<?= $Page->RowIndex ?>_Active" id="x<?= $Page->RowIndex ?>_Active"<?= $Page->Active->editAttributes() ?>>
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
    data-table="event_category"
    data-field="x_Active"
    data-value-separator="<?= $Page->Active->displayValueSeparatorAttribute() ?>"
    <?= $Page->Active->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Page->Active->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="event_category" data-field="x_Active" data-hidden="1" name="o<?= $Page->RowIndex ?>_Active" id="o<?= $Page->RowIndex ?>_Active" value="<?= HtmlEncode($Page->Active->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->Created_BY->Visible) { // Created_BY ?>
        <td data-name="Created_BY">
<input type="hidden" data-table="event_category" data-field="x_Created_BY" data-hidden="1" name="o<?= $Page->RowIndex ?>_Created_BY" id="o<?= $Page->RowIndex ?>_Created_BY" value="<?= HtmlEncode($Page->Created_BY->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->Created_AT->Visible) { // Created_AT ?>
        <td data-name="Created_AT">
<input type="hidden" data-table="event_category" data-field="x_Created_AT" data-hidden="1" name="o<?= $Page->RowIndex ?>_Created_AT" id="o<?= $Page->RowIndex ?>_Created_AT" value="<?= HtmlEncode($Page->Created_AT->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->IP->Visible) { // IP ?>
        <td data-name="IP">
<input type="hidden" data-table="event_category" data-field="x_IP" data-hidden="1" name="o<?= $Page->RowIndex ?>_IP" id="o<?= $Page->RowIndex ?>_IP" value="<?= HtmlEncode($Page->IP->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Page->ListOptions->render("body", "right", $Page->RowIndex);
?>
<script>
loadjs.ready(["fevent_categorylist","load"], () => fevent_categorylist.updateLists(<?= $Page->RowIndex ?>, true));
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
    ew.addEventHandlers("event_category");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
