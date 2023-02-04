<?php

namespace PHPMaker2022\eksbs;

// Page object
$EventsList = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { events: currentTable } });
var currentForm, currentPageID;
var feventslist;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    feventslist = new ew.Form("feventslist", "list");
    currentPageID = ew.PAGE_ID = "list";
    currentForm = feventslist;
    feventslist.formKeyCountName = "<?= $Page->FormKeyCountName ?>";

    // Add fields
    var fields = currentTable.fields;
    feventslist.addFields([
        ["ID", [fields.ID.visible && fields.ID.required ? ew.Validators.required(fields.ID.caption) : null], fields.ID.isInvalid],
        ["Event_Date", [fields.Event_Date.visible && fields.Event_Date.required ? ew.Validators.required(fields.Event_Date.caption) : null, ew.Validators.datetime(fields.Event_Date.clientFormatPattern)], fields.Event_Date.isInvalid],
        ["Event_Category", [fields.Event_Category.visible && fields.Event_Category.required ? ew.Validators.required(fields.Event_Category.caption) : null], fields.Event_Category.isInvalid],
        ["Video_1", [fields.Video_1.visible && fields.Video_1.required ? ew.Validators.required(fields.Video_1.caption) : null], fields.Video_1.isInvalid],
        ["Video_2", [fields.Video_2.visible && fields.Video_2.required ? ew.Validators.required(fields.Video_2.caption) : null], fields.Video_2.isInvalid],
        ["Video_3", [fields.Video_3.visible && fields.Video_3.required ? ew.Validators.required(fields.Video_3.caption) : null], fields.Video_3.isInvalid],
        ["_Title", [fields._Title.visible && fields._Title.required ? ew.Validators.required(fields._Title.caption) : null], fields._Title.isInvalid],
        ["Active", [fields.Active.visible && fields.Active.required ? ew.Validators.required(fields.Active.caption) : null], fields.Active.isInvalid],
        ["Sort_Order", [fields.Sort_Order.visible && fields.Sort_Order.required ? ew.Validators.required(fields.Sort_Order.caption) : null, ew.Validators.integer], fields.Sort_Order.isInvalid],
        ["Created_BY", [fields.Created_BY.visible && fields.Created_BY.required ? ew.Validators.required(fields.Created_BY.caption) : null], fields.Created_BY.isInvalid],
        ["Created_AT", [fields.Created_AT.visible && fields.Created_AT.required ? ew.Validators.required(fields.Created_AT.caption) : null], fields.Created_AT.isInvalid],
        ["IP", [fields.IP.visible && fields.IP.required ? ew.Validators.required(fields.IP.caption) : null], fields.IP.isInvalid]
    ]);

    // Check empty row
    feventslist.emptyRow = function (rowIndex) {
        var fobj = this.getForm(),
            fields = [["Event_Date",false],["Event_Category",false],["Video_1",false],["Video_2",false],["Video_3",false],["_Title",false],["Active",true],["Sort_Order",false]];
        if (fields.some(field => ew.valueChanged(fobj, rowIndex, ...field)))
            return false;
        return true;
    }

    // Form_CustomValidate
    feventslist.customValidate = function(fobj) { // DO NOT CHANGE THIS LINE!
        // Your custom validation code here, return false if invalid.
        return true;
    }

    // Use JavaScript validation or not
    feventslist.validateRequired = ew.CLIENT_VALIDATE;

    // Dynamic selection lists
    feventslist.lists.Event_Category = <?= $Page->Event_Category->toClientList($Page) ?>;
    feventslist.lists.Active = <?= $Page->Active->toClientList($Page) ?>;
    loadjs.done("feventslist");
});
var feventssrch, currentSearchForm, currentAdvancedSearchForm;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object for search
    feventssrch = new ew.Form("feventssrch", "list");
    currentSearchForm = feventssrch;

    // Dynamic selection lists

    // Filters
    feventssrch.filterList = <?= $Page->getFilterList() ?>;
    loadjs.done("feventssrch");
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
<form name="feventssrch" id="feventssrch" class="ew-form ew-ext-search-form" action="<?= CurrentPageUrl(false) ?>">
<div id="feventssrch_search_panel" class="mb-2 mb-sm-0 <?= $Page->SearchPanelClass ?>"><!-- .ew-search-panel -->
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="events">
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
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "" ? " active" : "" ?>" form="feventssrch" data-ew-action="search-type"><?= $Language->phrase("QuickSearchAuto") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "=" ? " active" : "" ?>" form="feventssrch" data-ew-action="search-type" data-search-type="="><?= $Language->phrase("QuickSearchExact") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "AND" ? " active" : "" ?>" form="feventssrch" data-ew-action="search-type" data-search-type="AND"><?= $Language->phrase("QuickSearchAll") ?></button>
                <button type="button" class="dropdown-item<?= $Page->BasicSearch->getType() == "OR" ? " active" : "" ?>" form="feventssrch" data-ew-action="search-type" data-search-type="OR"><?= $Language->phrase("QuickSearchAny") ?></button>
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
<div class="card ew-card ew-grid<?php if ($Page->isAddOrEdit()) { ?> ew-grid-add-edit<?php } ?> events">
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
<form name="feventslist" id="feventslist" class="ew-form ew-list-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="events">
<div id="gmp_events" class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<?php if ($Page->TotalRecords > 0 || $Page->isGridEdit()) { ?>
<table id="tbl_eventslist" class="table table-bordered table-hover table-sm ew-table"><!-- .ew-table -->
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
        <th data-name="ID" class="<?= $Page->ID->headerCellClass() ?>"><div id="elh_events_ID" class="events_ID"><?= $Page->renderFieldHeader($Page->ID) ?></div></th>
<?php } ?>
<?php if ($Page->Event_Date->Visible) { // Event_Date ?>
        <th data-name="Event_Date" class="<?= $Page->Event_Date->headerCellClass() ?>"><div id="elh_events_Event_Date" class="events_Event_Date"><?= $Page->renderFieldHeader($Page->Event_Date) ?></div></th>
<?php } ?>
<?php if ($Page->Event_Category->Visible) { // Event_Category ?>
        <th data-name="Event_Category" class="<?= $Page->Event_Category->headerCellClass() ?>"><div id="elh_events_Event_Category" class="events_Event_Category"><?= $Page->renderFieldHeader($Page->Event_Category) ?></div></th>
<?php } ?>
<?php if ($Page->Video_1->Visible) { // Video_1 ?>
        <th data-name="Video_1" class="<?= $Page->Video_1->headerCellClass() ?>"><div id="elh_events_Video_1" class="events_Video_1"><?= $Page->renderFieldHeader($Page->Video_1) ?></div></th>
<?php } ?>
<?php if ($Page->Video_2->Visible) { // Video_2 ?>
        <th data-name="Video_2" class="<?= $Page->Video_2->headerCellClass() ?>"><div id="elh_events_Video_2" class="events_Video_2"><?= $Page->renderFieldHeader($Page->Video_2) ?></div></th>
<?php } ?>
<?php if ($Page->Video_3->Visible) { // Video_3 ?>
        <th data-name="Video_3" class="<?= $Page->Video_3->headerCellClass() ?>"><div id="elh_events_Video_3" class="events_Video_3"><?= $Page->renderFieldHeader($Page->Video_3) ?></div></th>
<?php } ?>
<?php if ($Page->_Title->Visible) { // Title ?>
        <th data-name="_Title" class="<?= $Page->_Title->headerCellClass() ?>"><div id="elh_events__Title" class="events__Title"><?= $Page->renderFieldHeader($Page->_Title) ?></div></th>
<?php } ?>
<?php if ($Page->Active->Visible) { // Active ?>
        <th data-name="Active" class="<?= $Page->Active->headerCellClass() ?>"><div id="elh_events_Active" class="events_Active"><?= $Page->renderFieldHeader($Page->Active) ?></div></th>
<?php } ?>
<?php if ($Page->Sort_Order->Visible) { // Sort_Order ?>
        <th data-name="Sort_Order" class="<?= $Page->Sort_Order->headerCellClass() ?>"><div id="elh_events_Sort_Order" class="events_Sort_Order"><?= $Page->renderFieldHeader($Page->Sort_Order) ?></div></th>
<?php } ?>
<?php if ($Page->Created_BY->Visible) { // Created_BY ?>
        <th data-name="Created_BY" class="<?= $Page->Created_BY->headerCellClass() ?>"><div id="elh_events_Created_BY" class="events_Created_BY"><?= $Page->renderFieldHeader($Page->Created_BY) ?></div></th>
<?php } ?>
<?php if ($Page->Created_AT->Visible) { // Created_AT ?>
        <th data-name="Created_AT" class="<?= $Page->Created_AT->headerCellClass() ?>"><div id="elh_events_Created_AT" class="events_Created_AT"><?= $Page->renderFieldHeader($Page->Created_AT) ?></div></th>
<?php } ?>
<?php if ($Page->IP->Visible) { // IP ?>
        <th data-name="IP" class="<?= $Page->IP->headerCellClass() ?>"><div id="elh_events_IP" class="events_IP"><?= $Page->renderFieldHeader($Page->IP) ?></div></th>
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
            "id" => "r" . $Page->RowCount . "_events",
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
<span id="el<?= $Page->RowCount ?>_events_ID" class="el_events_ID"></span>
<input type="hidden" data-table="events" data-field="x_ID" data-hidden="1" name="o<?= $Page->RowIndex ?>_ID" id="o<?= $Page->RowIndex ?>_ID" value="<?= HtmlEncode($Page->ID->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_events_ID" class="el_events_ID">
<span<?= $Page->ID->viewAttributes() ?>>
<input type="text" readonly class="form-control-plaintext" value="<?= HtmlEncode(RemoveHtml($Page->ID->getDisplayValue($Page->ID->EditValue))) ?>"></span>
</span>
<input type="hidden" data-table="events" data-field="x_ID" data-hidden="1" name="x<?= $Page->RowIndex ?>_ID" id="x<?= $Page->RowIndex ?>_ID" value="<?= HtmlEncode($Page->ID->CurrentValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_events_ID" class="el_events_ID">
<span<?= $Page->ID->viewAttributes() ?>>
<?= $Page->ID->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } else { ?>
            <input type="hidden" data-table="events" data-field="x_ID" data-hidden="1" name="x<?= $Page->RowIndex ?>_ID" id="x<?= $Page->RowIndex ?>_ID" value="<?= HtmlEncode($Page->ID->CurrentValue) ?>">
    <?php } ?>
    <?php if ($Page->Event_Date->Visible) { // Event_Date ?>
        <td data-name="Event_Date"<?= $Page->Event_Date->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_events_Event_Date" class="el_events_Event_Date">
<input type="<?= $Page->Event_Date->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_Event_Date" id="x<?= $Page->RowIndex ?>_Event_Date" data-table="events" data-field="x_Event_Date" value="<?= $Page->Event_Date->EditValue ?>" maxlength="10" placeholder="<?= HtmlEncode($Page->Event_Date->getPlaceHolder()) ?>"<?= $Page->Event_Date->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Event_Date->getErrorMessage() ?></div>
<?php if (!$Page->Event_Date->ReadOnly && !$Page->Event_Date->Disabled && !isset($Page->Event_Date->EditAttrs["readonly"]) && !isset($Page->Event_Date->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["feventslist", "datetimepicker"], function () {
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
    ew.createDateTimePicker("feventslist", "x<?= $Page->RowIndex ?>_Event_Date", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="events" data-field="x_Event_Date" data-hidden="1" name="o<?= $Page->RowIndex ?>_Event_Date" id="o<?= $Page->RowIndex ?>_Event_Date" value="<?= HtmlEncode($Page->Event_Date->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_events_Event_Date" class="el_events_Event_Date">
<input type="<?= $Page->Event_Date->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_Event_Date" id="x<?= $Page->RowIndex ?>_Event_Date" data-table="events" data-field="x_Event_Date" value="<?= $Page->Event_Date->EditValue ?>" maxlength="10" placeholder="<?= HtmlEncode($Page->Event_Date->getPlaceHolder()) ?>"<?= $Page->Event_Date->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Event_Date->getErrorMessage() ?></div>
<?php if (!$Page->Event_Date->ReadOnly && !$Page->Event_Date->Disabled && !isset($Page->Event_Date->EditAttrs["readonly"]) && !isset($Page->Event_Date->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["feventslist", "datetimepicker"], function () {
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
    ew.createDateTimePicker("feventslist", "x<?= $Page->RowIndex ?>_Event_Date", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_events_Event_Date" class="el_events_Event_Date">
<span<?= $Page->Event_Date->viewAttributes() ?>>
<?= $Page->Event_Date->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->Event_Category->Visible) { // Event_Category ?>
        <td data-name="Event_Category"<?= $Page->Event_Category->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_events_Event_Category" class="el_events_Event_Category">
    <select
        id="x<?= $Page->RowIndex ?>_Event_Category"
        name="x<?= $Page->RowIndex ?>_Event_Category"
        class="form-select ew-select<?= $Page->Event_Category->isInvalidClass() ?>"
        data-select2-id="feventslist_x<?= $Page->RowIndex ?>_Event_Category"
        data-table="events"
        data-field="x_Event_Category"
        data-value-separator="<?= $Page->Event_Category->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->Event_Category->getPlaceHolder()) ?>"
        <?= $Page->Event_Category->editAttributes() ?>>
        <?= $Page->Event_Category->selectOptionListHtml("x{$Page->RowIndex}_Event_Category") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->Event_Category->getErrorMessage() ?></div>
<?= $Page->Event_Category->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_Event_Category") ?>
<script>
loadjs.ready("feventslist", function() {
    var options = { name: "x<?= $Page->RowIndex ?>_Event_Category", selectId: "feventslist_x<?= $Page->RowIndex ?>_Event_Category" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (feventslist.lists.Event_Category.lookupOptions.length) {
        options.data = { id: "x<?= $Page->RowIndex ?>_Event_Category", form: "feventslist" };
    } else {
        options.ajax = { id: "x<?= $Page->RowIndex ?>_Event_Category", form: "feventslist", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.events.fields.Event_Category.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="events" data-field="x_Event_Category" data-hidden="1" name="o<?= $Page->RowIndex ?>_Event_Category" id="o<?= $Page->RowIndex ?>_Event_Category" value="<?= HtmlEncode($Page->Event_Category->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_events_Event_Category" class="el_events_Event_Category">
    <select
        id="x<?= $Page->RowIndex ?>_Event_Category"
        name="x<?= $Page->RowIndex ?>_Event_Category"
        class="form-select ew-select<?= $Page->Event_Category->isInvalidClass() ?>"
        data-select2-id="feventslist_x<?= $Page->RowIndex ?>_Event_Category"
        data-table="events"
        data-field="x_Event_Category"
        data-value-separator="<?= $Page->Event_Category->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->Event_Category->getPlaceHolder()) ?>"
        <?= $Page->Event_Category->editAttributes() ?>>
        <?= $Page->Event_Category->selectOptionListHtml("x{$Page->RowIndex}_Event_Category") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->Event_Category->getErrorMessage() ?></div>
<?= $Page->Event_Category->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_Event_Category") ?>
<script>
loadjs.ready("feventslist", function() {
    var options = { name: "x<?= $Page->RowIndex ?>_Event_Category", selectId: "feventslist_x<?= $Page->RowIndex ?>_Event_Category" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (feventslist.lists.Event_Category.lookupOptions.length) {
        options.data = { id: "x<?= $Page->RowIndex ?>_Event_Category", form: "feventslist" };
    } else {
        options.ajax = { id: "x<?= $Page->RowIndex ?>_Event_Category", form: "feventslist", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.events.fields.Event_Category.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_events_Event_Category" class="el_events_Event_Category">
<span<?= $Page->Event_Category->viewAttributes() ?>>
<?= $Page->Event_Category->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->Video_1->Visible) { // Video_1 ?>
        <td data-name="Video_1"<?= $Page->Video_1->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_events_Video_1" class="el_events_Video_1">
<input type="<?= $Page->Video_1->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_Video_1" id="x<?= $Page->RowIndex ?>_Video_1" data-table="events" data-field="x_Video_1" value="<?= $Page->Video_1->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->Video_1->getPlaceHolder()) ?>"<?= $Page->Video_1->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Video_1->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="events" data-field="x_Video_1" data-hidden="1" name="o<?= $Page->RowIndex ?>_Video_1" id="o<?= $Page->RowIndex ?>_Video_1" value="<?= HtmlEncode($Page->Video_1->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_events_Video_1" class="el_events_Video_1">
<input type="<?= $Page->Video_1->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_Video_1" id="x<?= $Page->RowIndex ?>_Video_1" data-table="events" data-field="x_Video_1" value="<?= $Page->Video_1->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->Video_1->getPlaceHolder()) ?>"<?= $Page->Video_1->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Video_1->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_events_Video_1" class="el_events_Video_1">
<span<?= $Page->Video_1->viewAttributes() ?>>
<?= $Page->Video_1->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->Video_2->Visible) { // Video_2 ?>
        <td data-name="Video_2"<?= $Page->Video_2->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_events_Video_2" class="el_events_Video_2">
<input type="<?= $Page->Video_2->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_Video_2" id="x<?= $Page->RowIndex ?>_Video_2" data-table="events" data-field="x_Video_2" value="<?= $Page->Video_2->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->Video_2->getPlaceHolder()) ?>"<?= $Page->Video_2->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Video_2->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="events" data-field="x_Video_2" data-hidden="1" name="o<?= $Page->RowIndex ?>_Video_2" id="o<?= $Page->RowIndex ?>_Video_2" value="<?= HtmlEncode($Page->Video_2->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_events_Video_2" class="el_events_Video_2">
<input type="<?= $Page->Video_2->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_Video_2" id="x<?= $Page->RowIndex ?>_Video_2" data-table="events" data-field="x_Video_2" value="<?= $Page->Video_2->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->Video_2->getPlaceHolder()) ?>"<?= $Page->Video_2->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Video_2->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_events_Video_2" class="el_events_Video_2">
<span<?= $Page->Video_2->viewAttributes() ?>>
<?= $Page->Video_2->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->Video_3->Visible) { // Video_3 ?>
        <td data-name="Video_3"<?= $Page->Video_3->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_events_Video_3" class="el_events_Video_3">
<input type="<?= $Page->Video_3->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_Video_3" id="x<?= $Page->RowIndex ?>_Video_3" data-table="events" data-field="x_Video_3" value="<?= $Page->Video_3->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->Video_3->getPlaceHolder()) ?>"<?= $Page->Video_3->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Video_3->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="events" data-field="x_Video_3" data-hidden="1" name="o<?= $Page->RowIndex ?>_Video_3" id="o<?= $Page->RowIndex ?>_Video_3" value="<?= HtmlEncode($Page->Video_3->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_events_Video_3" class="el_events_Video_3">
<input type="<?= $Page->Video_3->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_Video_3" id="x<?= $Page->RowIndex ?>_Video_3" data-table="events" data-field="x_Video_3" value="<?= $Page->Video_3->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->Video_3->getPlaceHolder()) ?>"<?= $Page->Video_3->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Video_3->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_events_Video_3" class="el_events_Video_3">
<span<?= $Page->Video_3->viewAttributes() ?>>
<?= $Page->Video_3->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->_Title->Visible) { // Title ?>
        <td data-name="_Title"<?= $Page->_Title->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_events__Title" class="el_events__Title">
<input type="<?= $Page->_Title->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>__Title" id="x<?= $Page->RowIndex ?>__Title" data-table="events" data-field="x__Title" value="<?= $Page->_Title->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->_Title->getPlaceHolder()) ?>"<?= $Page->_Title->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->_Title->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="events" data-field="x__Title" data-hidden="1" name="o<?= $Page->RowIndex ?>__Title" id="o<?= $Page->RowIndex ?>__Title" value="<?= HtmlEncode($Page->_Title->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_events__Title" class="el_events__Title">
<input type="<?= $Page->_Title->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>__Title" id="x<?= $Page->RowIndex ?>__Title" data-table="events" data-field="x__Title" value="<?= $Page->_Title->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->_Title->getPlaceHolder()) ?>"<?= $Page->_Title->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->_Title->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_events__Title" class="el_events__Title">
<span<?= $Page->_Title->viewAttributes() ?>>
<?= $Page->_Title->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->Active->Visible) { // Active ?>
        <td data-name="Active"<?= $Page->Active->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_events_Active" class="el_events_Active">
<template id="tp_x<?= $Page->RowIndex ?>_Active">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="events" data-field="x_Active" name="x<?= $Page->RowIndex ?>_Active" id="x<?= $Page->RowIndex ?>_Active"<?= $Page->Active->editAttributes() ?>>
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
    data-table="events"
    data-field="x_Active"
    data-value-separator="<?= $Page->Active->displayValueSeparatorAttribute() ?>"
    <?= $Page->Active->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Page->Active->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="events" data-field="x_Active" data-hidden="1" name="o<?= $Page->RowIndex ?>_Active" id="o<?= $Page->RowIndex ?>_Active" value="<?= HtmlEncode($Page->Active->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_events_Active" class="el_events_Active">
<template id="tp_x<?= $Page->RowIndex ?>_Active">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="events" data-field="x_Active" name="x<?= $Page->RowIndex ?>_Active" id="x<?= $Page->RowIndex ?>_Active"<?= $Page->Active->editAttributes() ?>>
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
    data-table="events"
    data-field="x_Active"
    data-value-separator="<?= $Page->Active->displayValueSeparatorAttribute() ?>"
    <?= $Page->Active->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Page->Active->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_events_Active" class="el_events_Active">
<span<?= $Page->Active->viewAttributes() ?>>
<?= $Page->Active->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->Sort_Order->Visible) { // Sort_Order ?>
        <td data-name="Sort_Order"<?= $Page->Sort_Order->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<span id="el<?= $Page->RowCount ?>_events_Sort_Order" class="el_events_Sort_Order">
<input type="<?= $Page->Sort_Order->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_Sort_Order" id="x<?= $Page->RowIndex ?>_Sort_Order" data-table="events" data-field="x_Sort_Order" value="<?= $Page->Sort_Order->EditValue ?>" size="30" maxlength="11" placeholder="<?= HtmlEncode($Page->Sort_Order->getPlaceHolder()) ?>"<?= $Page->Sort_Order->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Sort_Order->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="events" data-field="x_Sort_Order" data-hidden="1" name="o<?= $Page->RowIndex ?>_Sort_Order" id="o<?= $Page->RowIndex ?>_Sort_Order" value="<?= HtmlEncode($Page->Sort_Order->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?= $Page->RowCount ?>_events_Sort_Order" class="el_events_Sort_Order">
<input type="<?= $Page->Sort_Order->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_Sort_Order" id="x<?= $Page->RowIndex ?>_Sort_Order" data-table="events" data-field="x_Sort_Order" value="<?= $Page->Sort_Order->EditValue ?>" size="30" maxlength="11" placeholder="<?= HtmlEncode($Page->Sort_Order->getPlaceHolder()) ?>"<?= $Page->Sort_Order->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Sort_Order->getErrorMessage() ?></div>
</span>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_events_Sort_Order" class="el_events_Sort_Order">
<span<?= $Page->Sort_Order->viewAttributes() ?>>
<?= $Page->Sort_Order->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->Created_BY->Visible) { // Created_BY ?>
        <td data-name="Created_BY"<?= $Page->Created_BY->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="events" data-field="x_Created_BY" data-hidden="1" name="o<?= $Page->RowIndex ?>_Created_BY" id="o<?= $Page->RowIndex ?>_Created_BY" value="<?= HtmlEncode($Page->Created_BY->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_events_Created_BY" class="el_events_Created_BY">
<span<?= $Page->Created_BY->viewAttributes() ?>>
<?= $Page->Created_BY->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->Created_AT->Visible) { // Created_AT ?>
        <td data-name="Created_AT"<?= $Page->Created_AT->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="events" data-field="x_Created_AT" data-hidden="1" name="o<?= $Page->RowIndex ?>_Created_AT" id="o<?= $Page->RowIndex ?>_Created_AT" value="<?= HtmlEncode($Page->Created_AT->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_events_Created_AT" class="el_events_Created_AT">
<span<?= $Page->Created_AT->viewAttributes() ?>>
<?= $Page->Created_AT->getViewValue() ?></span>
</span>
<?php } ?>
</td>
    <?php } ?>
    <?php if ($Page->IP->Visible) { // IP ?>
        <td data-name="IP"<?= $Page->IP->cellAttributes() ?>>
<?php if ($Page->RowType == ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="events" data-field="x_IP" data-hidden="1" name="o<?= $Page->RowIndex ?>_IP" id="o<?= $Page->RowIndex ?>_IP" value="<?= HtmlEncode($Page->IP->OldValue) ?>">
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_EDIT) { // Edit record ?>
<?php } ?>
<?php if ($Page->RowType == ROWTYPE_VIEW) { // View record ?>
<span id="el<?= $Page->RowCount ?>_events_IP" class="el_events_IP">
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
loadjs.ready(["feventslist","load"], () => feventslist.updateLists(<?= $Page->RowIndex ?>));
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
    $Page->RowAttrs->merge(["data-rowindex" => $Page->RowIndex, "id" => "r0_events", "data-rowtype" => ROWTYPE_ADD]);
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
<span id="el$rowindex$_events_ID" class="el_events_ID"></span>
<input type="hidden" data-table="events" data-field="x_ID" data-hidden="1" name="o<?= $Page->RowIndex ?>_ID" id="o<?= $Page->RowIndex ?>_ID" value="<?= HtmlEncode($Page->ID->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->Event_Date->Visible) { // Event_Date ?>
        <td data-name="Event_Date">
<span id="el$rowindex$_events_Event_Date" class="el_events_Event_Date">
<input type="<?= $Page->Event_Date->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_Event_Date" id="x<?= $Page->RowIndex ?>_Event_Date" data-table="events" data-field="x_Event_Date" value="<?= $Page->Event_Date->EditValue ?>" maxlength="10" placeholder="<?= HtmlEncode($Page->Event_Date->getPlaceHolder()) ?>"<?= $Page->Event_Date->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Event_Date->getErrorMessage() ?></div>
<?php if (!$Page->Event_Date->ReadOnly && !$Page->Event_Date->Disabled && !isset($Page->Event_Date->EditAttrs["readonly"]) && !isset($Page->Event_Date->EditAttrs["disabled"])) { ?>
<script>
loadjs.ready(["feventslist", "datetimepicker"], function () {
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
    ew.createDateTimePicker("feventslist", "x<?= $Page->RowIndex ?>_Event_Date", jQuery.extend(true, {"useCurrent":false}, options));
});
</script>
<?php } ?>
</span>
<input type="hidden" data-table="events" data-field="x_Event_Date" data-hidden="1" name="o<?= $Page->RowIndex ?>_Event_Date" id="o<?= $Page->RowIndex ?>_Event_Date" value="<?= HtmlEncode($Page->Event_Date->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->Event_Category->Visible) { // Event_Category ?>
        <td data-name="Event_Category">
<span id="el$rowindex$_events_Event_Category" class="el_events_Event_Category">
    <select
        id="x<?= $Page->RowIndex ?>_Event_Category"
        name="x<?= $Page->RowIndex ?>_Event_Category"
        class="form-select ew-select<?= $Page->Event_Category->isInvalidClass() ?>"
        data-select2-id="feventslist_x<?= $Page->RowIndex ?>_Event_Category"
        data-table="events"
        data-field="x_Event_Category"
        data-value-separator="<?= $Page->Event_Category->displayValueSeparatorAttribute() ?>"
        data-placeholder="<?= HtmlEncode($Page->Event_Category->getPlaceHolder()) ?>"
        <?= $Page->Event_Category->editAttributes() ?>>
        <?= $Page->Event_Category->selectOptionListHtml("x{$Page->RowIndex}_Event_Category") ?>
    </select>
    <div class="invalid-feedback"><?= $Page->Event_Category->getErrorMessage() ?></div>
<?= $Page->Event_Category->Lookup->getParamTag($Page, "p_x" . $Page->RowIndex . "_Event_Category") ?>
<script>
loadjs.ready("feventslist", function() {
    var options = { name: "x<?= $Page->RowIndex ?>_Event_Category", selectId: "feventslist_x<?= $Page->RowIndex ?>_Event_Category" },
        el = document.querySelector("select[data-select2-id='" + options.selectId + "']");
    options.dropdownParent = el.closest("#ew-modal-dialog, #ew-add-opt-dialog");
    if (feventslist.lists.Event_Category.lookupOptions.length) {
        options.data = { id: "x<?= $Page->RowIndex ?>_Event_Category", form: "feventslist" };
    } else {
        options.ajax = { id: "x<?= $Page->RowIndex ?>_Event_Category", form: "feventslist", limit: ew.LOOKUP_PAGE_SIZE };
    }
    options.minimumResultsForSearch = Infinity;
    options = Object.assign({}, ew.selectOptions, options, ew.vars.tables.events.fields.Event_Category.selectOptions);
    ew.createSelect(options);
});
</script>
</span>
<input type="hidden" data-table="events" data-field="x_Event_Category" data-hidden="1" name="o<?= $Page->RowIndex ?>_Event_Category" id="o<?= $Page->RowIndex ?>_Event_Category" value="<?= HtmlEncode($Page->Event_Category->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->Video_1->Visible) { // Video_1 ?>
        <td data-name="Video_1">
<span id="el$rowindex$_events_Video_1" class="el_events_Video_1">
<input type="<?= $Page->Video_1->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_Video_1" id="x<?= $Page->RowIndex ?>_Video_1" data-table="events" data-field="x_Video_1" value="<?= $Page->Video_1->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->Video_1->getPlaceHolder()) ?>"<?= $Page->Video_1->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Video_1->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="events" data-field="x_Video_1" data-hidden="1" name="o<?= $Page->RowIndex ?>_Video_1" id="o<?= $Page->RowIndex ?>_Video_1" value="<?= HtmlEncode($Page->Video_1->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->Video_2->Visible) { // Video_2 ?>
        <td data-name="Video_2">
<span id="el$rowindex$_events_Video_2" class="el_events_Video_2">
<input type="<?= $Page->Video_2->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_Video_2" id="x<?= $Page->RowIndex ?>_Video_2" data-table="events" data-field="x_Video_2" value="<?= $Page->Video_2->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->Video_2->getPlaceHolder()) ?>"<?= $Page->Video_2->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Video_2->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="events" data-field="x_Video_2" data-hidden="1" name="o<?= $Page->RowIndex ?>_Video_2" id="o<?= $Page->RowIndex ?>_Video_2" value="<?= HtmlEncode($Page->Video_2->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->Video_3->Visible) { // Video_3 ?>
        <td data-name="Video_3">
<span id="el$rowindex$_events_Video_3" class="el_events_Video_3">
<input type="<?= $Page->Video_3->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_Video_3" id="x<?= $Page->RowIndex ?>_Video_3" data-table="events" data-field="x_Video_3" value="<?= $Page->Video_3->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->Video_3->getPlaceHolder()) ?>"<?= $Page->Video_3->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Video_3->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="events" data-field="x_Video_3" data-hidden="1" name="o<?= $Page->RowIndex ?>_Video_3" id="o<?= $Page->RowIndex ?>_Video_3" value="<?= HtmlEncode($Page->Video_3->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->_Title->Visible) { // Title ?>
        <td data-name="_Title">
<span id="el$rowindex$_events__Title" class="el_events__Title">
<input type="<?= $Page->_Title->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>__Title" id="x<?= $Page->RowIndex ?>__Title" data-table="events" data-field="x__Title" value="<?= $Page->_Title->EditValue ?>" size="30" maxlength="255" placeholder="<?= HtmlEncode($Page->_Title->getPlaceHolder()) ?>"<?= $Page->_Title->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->_Title->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="events" data-field="x__Title" data-hidden="1" name="o<?= $Page->RowIndex ?>__Title" id="o<?= $Page->RowIndex ?>__Title" value="<?= HtmlEncode($Page->_Title->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->Active->Visible) { // Active ?>
        <td data-name="Active">
<span id="el$rowindex$_events_Active" class="el_events_Active">
<template id="tp_x<?= $Page->RowIndex ?>_Active">
    <div class="form-check">
        <input type="radio" class="form-check-input" data-table="events" data-field="x_Active" name="x<?= $Page->RowIndex ?>_Active" id="x<?= $Page->RowIndex ?>_Active"<?= $Page->Active->editAttributes() ?>>
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
    data-table="events"
    data-field="x_Active"
    data-value-separator="<?= $Page->Active->displayValueSeparatorAttribute() ?>"
    <?= $Page->Active->editAttributes() ?>></selection-list>
<div class="invalid-feedback"><?= $Page->Active->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="events" data-field="x_Active" data-hidden="1" name="o<?= $Page->RowIndex ?>_Active" id="o<?= $Page->RowIndex ?>_Active" value="<?= HtmlEncode($Page->Active->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->Sort_Order->Visible) { // Sort_Order ?>
        <td data-name="Sort_Order">
<span id="el$rowindex$_events_Sort_Order" class="el_events_Sort_Order">
<input type="<?= $Page->Sort_Order->getInputTextType() ?>" name="x<?= $Page->RowIndex ?>_Sort_Order" id="x<?= $Page->RowIndex ?>_Sort_Order" data-table="events" data-field="x_Sort_Order" value="<?= $Page->Sort_Order->EditValue ?>" size="30" maxlength="11" placeholder="<?= HtmlEncode($Page->Sort_Order->getPlaceHolder()) ?>"<?= $Page->Sort_Order->editAttributes() ?>>
<div class="invalid-feedback"><?= $Page->Sort_Order->getErrorMessage() ?></div>
</span>
<input type="hidden" data-table="events" data-field="x_Sort_Order" data-hidden="1" name="o<?= $Page->RowIndex ?>_Sort_Order" id="o<?= $Page->RowIndex ?>_Sort_Order" value="<?= HtmlEncode($Page->Sort_Order->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->Created_BY->Visible) { // Created_BY ?>
        <td data-name="Created_BY">
<input type="hidden" data-table="events" data-field="x_Created_BY" data-hidden="1" name="o<?= $Page->RowIndex ?>_Created_BY" id="o<?= $Page->RowIndex ?>_Created_BY" value="<?= HtmlEncode($Page->Created_BY->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->Created_AT->Visible) { // Created_AT ?>
        <td data-name="Created_AT">
<input type="hidden" data-table="events" data-field="x_Created_AT" data-hidden="1" name="o<?= $Page->RowIndex ?>_Created_AT" id="o<?= $Page->RowIndex ?>_Created_AT" value="<?= HtmlEncode($Page->Created_AT->OldValue) ?>">
</td>
    <?php } ?>
    <?php if ($Page->IP->Visible) { // IP ?>
        <td data-name="IP">
<input type="hidden" data-table="events" data-field="x_IP" data-hidden="1" name="o<?= $Page->RowIndex ?>_IP" id="o<?= $Page->RowIndex ?>_IP" value="<?= HtmlEncode($Page->IP->OldValue) ?>">
</td>
    <?php } ?>
<?php
// Render list options (body, right)
$Page->ListOptions->render("body", "right", $Page->RowIndex);
?>
<script>
loadjs.ready(["feventslist","load"], () => feventslist.updateLists(<?= $Page->RowIndex ?>, true));
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
    ew.addEventHandlers("events");
});
</script>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
