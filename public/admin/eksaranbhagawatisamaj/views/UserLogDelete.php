<?php

namespace PHPMaker2022\eksbs;

// Page object
$UserLogDelete = &$Page;
?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { user_log: currentTable } });
var currentForm, currentPageID;
var fuser_logdelete;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fuser_logdelete = new ew.Form("fuser_logdelete", "delete");
    currentPageID = ew.PAGE_ID = "delete";
    currentForm = fuser_logdelete;
    loadjs.done("fuser_logdelete");
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
<form name="fuser_logdelete" id="fuser_logdelete" class="ew-form ew-delete-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="user_log">
<input type="hidden" name="action" id="action" value="delete">
<?php foreach ($Page->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode(Config("COMPOSITE_KEY_SEPARATOR"), $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?= HtmlEncode($keyvalue) ?>">
<?php } ?>
<div class="card ew-card ew-grid">
<div class="<?= ResponsiveTableClass() ?>card-body ew-grid-middle-panel">
<table class="table table-bordered table-hover table-sm ew-table">
    <thead>
    <tr class="ew-table-header">
<?php if ($Page->id->Visible) { // id ?>
        <th class="<?= $Page->id->headerCellClass() ?>"><span id="elh_user_log_id" class="user_log_id"><?= $Page->id->caption() ?></span></th>
<?php } ?>
<?php if ($Page->datetime->Visible) { // datetime ?>
        <th class="<?= $Page->datetime->headerCellClass() ?>"><span id="elh_user_log_datetime" class="user_log_datetime"><?= $Page->datetime->caption() ?></span></th>
<?php } ?>
<?php if ($Page->script->Visible) { // script ?>
        <th class="<?= $Page->script->headerCellClass() ?>"><span id="elh_user_log_script" class="user_log_script"><?= $Page->script->caption() ?></span></th>
<?php } ?>
<?php if ($Page->user->Visible) { // user ?>
        <th class="<?= $Page->user->headerCellClass() ?>"><span id="elh_user_log_user" class="user_log_user"><?= $Page->user->caption() ?></span></th>
<?php } ?>
<?php if ($Page->_action->Visible) { // action ?>
        <th class="<?= $Page->_action->headerCellClass() ?>"><span id="elh_user_log__action" class="user_log__action"><?= $Page->_action->caption() ?></span></th>
<?php } ?>
<?php if ($Page->_table->Visible) { // table ?>
        <th class="<?= $Page->_table->headerCellClass() ?>"><span id="elh_user_log__table" class="user_log__table"><?= $Page->_table->caption() ?></span></th>
<?php } ?>
<?php if ($Page->field->Visible) { // field ?>
        <th class="<?= $Page->field->headerCellClass() ?>"><span id="elh_user_log_field" class="user_log_field"><?= $Page->field->caption() ?></span></th>
<?php } ?>
    </tr>
    </thead>
    <tbody>
<?php
$Page->RecordCount = 0;
$i = 0;
while (!$Page->Recordset->EOF) {
    $Page->RecordCount++;
    $Page->RowCount++;

    // Set row properties
    $Page->resetAttributes();
    $Page->RowType = ROWTYPE_VIEW; // View

    // Get the field contents
    $Page->loadRowValues($Page->Recordset);

    // Render row
    $Page->renderRow();
?>
    <tr <?= $Page->rowAttributes() ?>>
<?php if ($Page->id->Visible) { // id ?>
        <td<?= $Page->id->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_user_log_id" class="el_user_log_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->datetime->Visible) { // datetime ?>
        <td<?= $Page->datetime->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_user_log_datetime" class="el_user_log_datetime">
<span<?= $Page->datetime->viewAttributes() ?>>
<?= $Page->datetime->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->script->Visible) { // script ?>
        <td<?= $Page->script->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_user_log_script" class="el_user_log_script">
<span<?= $Page->script->viewAttributes() ?>>
<?= $Page->script->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->user->Visible) { // user ?>
        <td<?= $Page->user->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_user_log_user" class="el_user_log_user">
<span<?= $Page->user->viewAttributes() ?>>
<?= $Page->user->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->_action->Visible) { // action ?>
        <td<?= $Page->_action->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_user_log__action" class="el_user_log__action">
<span<?= $Page->_action->viewAttributes() ?>>
<?= $Page->_action->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->_table->Visible) { // table ?>
        <td<?= $Page->_table->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_user_log__table" class="el_user_log__table">
<span<?= $Page->_table->viewAttributes() ?>>
<?= $Page->_table->getViewValue() ?></span>
</span>
</td>
<?php } ?>
<?php if ($Page->field->Visible) { // field ?>
        <td<?= $Page->field->cellAttributes() ?>>
<span id="el<?= $Page->RowCount ?>_user_log_field" class="el_user_log_field">
<span<?= $Page->field->viewAttributes() ?>>
<?= $Page->field->getViewValue() ?></span>
</span>
</td>
<?php } ?>
    </tr>
<?php
    $Page->Recordset->moveNext();
}
$Page->Recordset->close();
?>
</tbody>
</table>
</div>
</div>
<div>
<button class="btn btn-primary ew-btn" name="btn-action" id="btn-action" type="submit"><?= $Language->phrase("DeleteBtn") ?></button>
<button class="btn btn-default ew-btn" name="btn-cancel" id="btn-cancel" type="button" data-href="<?= HtmlEncode(GetUrl($Page->getReturnUrl())) ?>"><?= $Language->phrase("CancelBtn") ?></button>
</div>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
