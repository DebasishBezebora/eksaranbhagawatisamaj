<?php

namespace PHPMaker2022\eksbs;

// Page object
$UserLogView = &$Page;
?>
<?php if (!$Page->isExport()) { ?>
<script>
var currentTable = <?= JsonEncode($Page->toClientVar()) ?>;
ew.deepAssign(ew.vars, { tables: { user_log: currentTable } });
var currentForm, currentPageID;
var fuser_logview;
loadjs.ready(["wrapper", "head"], function () {
    var $ = jQuery;
    // Form object
    fuser_logview = new ew.Form("fuser_logview", "view");
    currentPageID = ew.PAGE_ID = "view";
    currentForm = fuser_logview;
    loadjs.done("fuser_logview");
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
<?php $Page->ExportOptions->render("body") ?>
<?php $Page->OtherOptions->render("body") ?>
</div>
<?php } ?>
<?php $Page->showPageHeader(); ?>
<?php
$Page->showMessage();
?>
<form name="fuser_logview" id="fuser_logview" class="ew-form ew-view-form" action="<?= CurrentPageUrl(false) ?>" method="post">
<?php if (Config("CHECK_TOKEN")) { ?>
<input type="hidden" name="<?= $TokenNameKey ?>" value="<?= $TokenName ?>"><!-- CSRF token name -->
<input type="hidden" name="<?= $TokenValueKey ?>" value="<?= $TokenValue ?>"><!-- CSRF token value -->
<?php } ?>
<input type="hidden" name="t" value="user_log">
<input type="hidden" name="modal" value="<?= (int)$Page->IsModal ?>">
<table class="table table-striped table-bordered table-hover table-sm ew-view-table">
<?php if ($Page->id->Visible) { // id ?>
    <tr id="r_id"<?= $Page->id->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_user_log_id"><?= $Page->id->caption() ?></span></td>
        <td data-name="id"<?= $Page->id->cellAttributes() ?>>
<span id="el_user_log_id">
<span<?= $Page->id->viewAttributes() ?>>
<?= $Page->id->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->datetime->Visible) { // datetime ?>
    <tr id="r_datetime"<?= $Page->datetime->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_user_log_datetime"><?= $Page->datetime->caption() ?></span></td>
        <td data-name="datetime"<?= $Page->datetime->cellAttributes() ?>>
<span id="el_user_log_datetime">
<span<?= $Page->datetime->viewAttributes() ?>>
<?= $Page->datetime->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->script->Visible) { // script ?>
    <tr id="r_script"<?= $Page->script->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_user_log_script"><?= $Page->script->caption() ?></span></td>
        <td data-name="script"<?= $Page->script->cellAttributes() ?>>
<span id="el_user_log_script">
<span<?= $Page->script->viewAttributes() ?>>
<?= $Page->script->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->user->Visible) { // user ?>
    <tr id="r_user"<?= $Page->user->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_user_log_user"><?= $Page->user->caption() ?></span></td>
        <td data-name="user"<?= $Page->user->cellAttributes() ?>>
<span id="el_user_log_user">
<span<?= $Page->user->viewAttributes() ?>>
<?= $Page->user->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->_action->Visible) { // action ?>
    <tr id="r__action"<?= $Page->_action->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_user_log__action"><?= $Page->_action->caption() ?></span></td>
        <td data-name="_action"<?= $Page->_action->cellAttributes() ?>>
<span id="el_user_log__action">
<span<?= $Page->_action->viewAttributes() ?>>
<?= $Page->_action->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->_table->Visible) { // table ?>
    <tr id="r__table"<?= $Page->_table->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_user_log__table"><?= $Page->_table->caption() ?></span></td>
        <td data-name="_table"<?= $Page->_table->cellAttributes() ?>>
<span id="el_user_log__table">
<span<?= $Page->_table->viewAttributes() ?>>
<?= $Page->_table->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->field->Visible) { // field ?>
    <tr id="r_field"<?= $Page->field->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_user_log_field"><?= $Page->field->caption() ?></span></td>
        <td data-name="field"<?= $Page->field->cellAttributes() ?>>
<span id="el_user_log_field">
<span<?= $Page->field->viewAttributes() ?>>
<?= $Page->field->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->keyvalue->Visible) { // keyvalue ?>
    <tr id="r_keyvalue"<?= $Page->keyvalue->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_user_log_keyvalue"><?= $Page->keyvalue->caption() ?></span></td>
        <td data-name="keyvalue"<?= $Page->keyvalue->cellAttributes() ?>>
<span id="el_user_log_keyvalue">
<span<?= $Page->keyvalue->viewAttributes() ?>>
<?= $Page->keyvalue->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->oldvalue->Visible) { // oldvalue ?>
    <tr id="r_oldvalue"<?= $Page->oldvalue->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_user_log_oldvalue"><?= $Page->oldvalue->caption() ?></span></td>
        <td data-name="oldvalue"<?= $Page->oldvalue->cellAttributes() ?>>
<span id="el_user_log_oldvalue">
<span<?= $Page->oldvalue->viewAttributes() ?>>
<?= $Page->oldvalue->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
<?php if ($Page->newvalue->Visible) { // newvalue ?>
    <tr id="r_newvalue"<?= $Page->newvalue->rowAttributes() ?>>
        <td class="<?= $Page->TableLeftColumnClass ?>"><span id="elh_user_log_newvalue"><?= $Page->newvalue->caption() ?></span></td>
        <td data-name="newvalue"<?= $Page->newvalue->cellAttributes() ?>>
<span id="el_user_log_newvalue">
<span<?= $Page->newvalue->viewAttributes() ?>>
<?= $Page->newvalue->getViewValue() ?></span>
</span>
</td>
    </tr>
<?php } ?>
</table>
</form>
<?php
$Page->showPageFooter();
echo GetDebugMessage();
?>
<?php if (!$Page->isExport()) { ?>
<script>
loadjs.ready("load", function () {
    // Write your table-specific startup script here, no need to add script tags.
});
</script>
<?php } ?>
