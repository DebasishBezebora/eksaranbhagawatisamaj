<?php

namespace PHPMaker2022\eksbs;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Page class
 */
class SiteSettingsList extends SiteSettings
{
    use MessagesTrait;

    // Page ID
    public $PageID = "list";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'site_settings';

    // Page object name
    public $PageObjName = "SiteSettingsList";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

    // Grid form hidden field names
    public $FormName = "fsite_settingslist";
    public $FormActionName = "k_action";
    public $FormBlankRowName = "k_blankrow";
    public $FormKeyCountName = "key_count";

    // Page URLs
    public $AddUrl;
    public $EditUrl;
    public $CopyUrl;
    public $DeleteUrl;
    public $ViewUrl;
    public $ListUrl;

    // Update URLs
    public $InlineAddUrl;
    public $InlineCopyUrl;
    public $InlineEditUrl;
    public $GridAddUrl;
    public $GridEditUrl;
    public $MultiDeleteUrl;
    public $MultiUpdateUrl;

    // Audit Trail
    public $AuditTrailOnAdd = true;
    public $AuditTrailOnEdit = true;
    public $AuditTrailOnDelete = true;
    public $AuditTrailOnView = false;
    public $AuditTrailOnViewData = false;
    public $AuditTrailOnSearch = false;

    // Page headings
    public $Heading = "";
    public $Subheading = "";
    public $PageHeader;
    public $PageFooter;

    // Page layout
    public $UseLayout = true;

    // Page terminated
    private $terminated = false;

    // Page heading
    public function pageHeading()
    {
        global $Language;
        if ($this->Heading != "") {
            return $this->Heading;
        }
        if (method_exists($this, "tableCaption")) {
            return $this->tableCaption();
        }
        return "";
    }

    // Page subheading
    public function pageSubheading()
    {
        global $Language;
        if ($this->Subheading != "") {
            return $this->Subheading;
        }
        if ($this->TableName) {
            return $Language->phrase($this->PageID);
        }
        return "";
    }

    // Page name
    public function pageName()
    {
        return CurrentPageName();
    }

    // Page URL
    public function pageUrl($withArgs = true)
    {
        $route = GetRoute();
        $args = $route->getArguments();
        if (!$withArgs) {
            foreach ($args as $key => &$val) {
                $val = "";
            }
            unset($val);
        }
        $url = rtrim(UrlFor($route->getName(), $args), "/") . "?";
        if ($this->UseTokenInUrl) {
            $url .= "t=" . $this->TableVar . "&"; // Add page token
        }
        return $url;
    }

    // Show Page Header
    public function showPageHeader()
    {
        $header = $this->PageHeader;
        $this->pageDataRendering($header);
        if ($header != "") { // Header exists, display
            echo '<p id="ew-page-header">' . $header . '</p>';
        }
    }

    // Show Page Footer
    public function showPageFooter()
    {
        $footer = $this->PageFooter;
        $this->pageDataRendered($footer);
        if ($footer != "") { // Footer exists, display
            echo '<p id="ew-page-footer">' . $footer . '</p>';
        }
    }

    // Validate page request
    protected function isPageRequest()
    {
        global $CurrentForm;
        if ($this->UseTokenInUrl) {
            if ($CurrentForm) {
                return $this->TableVar == $CurrentForm->getValue("t");
            }
            if (Get("t") !== null) {
                return $this->TableVar == Get("t");
            }
        }
        return true;
    }

    // Constructor
    public function __construct()
    {
        global $Language, $DashboardReport, $DebugTimer;
        global $UserTable;

        // Initialize
        $GLOBALS["Page"] = &$this;

        // Language object
        $Language = Container("language");

        // Parent constuctor
        parent::__construct();

        // Table object (site_settings)
        if (!isset($GLOBALS["site_settings"]) || get_class($GLOBALS["site_settings"]) == PROJECT_NAMESPACE . "site_settings") {
            $GLOBALS["site_settings"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl(false);

        // Initialize URLs
        $this->AddUrl = "SiteSettingsAdd";
        $this->InlineAddUrl = $pageUrl . "action=add";
        $this->GridAddUrl = $pageUrl . "action=gridadd";
        $this->GridEditUrl = $pageUrl . "action=gridedit";
        $this->MultiDeleteUrl = "SiteSettingsDelete";
        $this->MultiUpdateUrl = "SiteSettingsUpdate";

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'site_settings');
        }

        // Start timer
        $DebugTimer = Container("timer");

        // Debug message
        LoadDebugMessage();

        // Open connection
        $GLOBALS["Conn"] = $GLOBALS["Conn"] ?? $this->getConnection();

        // User table object
        $UserTable = Container("usertable");

        // List options
        $this->ListOptions = new ListOptions(["Tag" => "td", "TableVar" => $this->TableVar]);

        // Export options
        $this->ExportOptions = new ListOptions(["TagClassName" => "ew-export-option"]);

        // Import options
        $this->ImportOptions = new ListOptions(["TagClassName" => "ew-import-option"]);

        // Other options
        if (!$this->OtherOptions) {
            $this->OtherOptions = new ListOptionsArray();
        }

        // Grid-Add/Edit
        $this->OtherOptions["addedit"] = new ListOptions([
            "TagClassName" => "ew-add-edit-option",
            "UseDropDownButton" => false,
            "DropDownButtonPhrase" => $Language->phrase("ButtonAddEdit"),
            "UseButtonGroup" => true
        ]);

        // Detail tables
        $this->OtherOptions["detail"] = new ListOptions(["TagClassName" => "ew-detail-option"]);
        // Actions
        $this->OtherOptions["action"] = new ListOptions(["TagClassName" => "ew-action-option"]);

        // Column visibility
        $this->OtherOptions["column"] = new ListOptions([
            "TableVar" => $this->TableVar,
            "TagClassName" => "ew-column-option",
            "ButtonGroupClass" => "ew-column-dropdown",
            "UseDropDownButton" => true,
            "DropDownButtonPhrase" => $Language->phrase("Columns"),
            "DropDownAutoClose" => "outside",
            "UseButtonGroup" => false
        ]);

        // Filter options
        $this->FilterOptions = new ListOptions(["TagClassName" => "ew-filter-option"]);

        // List actions
        $this->ListActions = new ListActions();
    }

    // Get content from stream
    public function getContents($stream = null): string
    {
        global $Response;
        return is_object($Response) ? $Response->getBody() : ob_get_clean();
    }

    // Is lookup
    public function isLookup()
    {
        return SameText(Route(0), Config("API_LOOKUP_ACTION"));
    }

    // Is AutoFill
    public function isAutoFill()
    {
        return $this->isLookup() && SameText(Post("ajax"), "autofill");
    }

    // Is AutoSuggest
    public function isAutoSuggest()
    {
        return $this->isLookup() && SameText(Post("ajax"), "autosuggest");
    }

    // Is modal lookup
    public function isModalLookup()
    {
        return $this->isLookup() && SameText(Post("ajax"), "modal");
    }

    // Is terminated
    public function isTerminated()
    {
        return $this->terminated;
    }

    /**
     * Terminate page
     *
     * @param string $url URL for direction
     * @return void
     */
    public function terminate($url = "")
    {
        if ($this->terminated) {
            return;
        }
        global $ExportFileName, $TempImages, $DashboardReport, $Response;

        // Page is terminated
        $this->terminated = true;

         // Page Unload event
        if (method_exists($this, "pageUnload")) {
            $this->pageUnload();
        }

        // Global Page Unloaded event (in userfn*.php)
        Page_Unloaded();

        // Export
        if ($this->CustomExport && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, Config("EXPORT_CLASSES"))) {
            $content = $this->getContents();
            if ($ExportFileName == "") {
                $ExportFileName = $this->TableVar;
            }
            $class = PROJECT_NAMESPACE . Config("EXPORT_CLASSES." . $this->CustomExport);
            if (class_exists($class)) {
                $tbl = Container("site_settings");
                $doc = new $class($tbl);
                $doc->Text = @$content;
                if ($this->isExport("email")) {
                    echo $this->exportEmail($doc->Text);
                } else {
                    $doc->export();
                }
                DeleteTempImages(); // Delete temp images
                return;
            }
        }
        if (!IsApi() && method_exists($this, "pageRedirecting")) {
            $this->pageRedirecting($url);
        }

        // Close connection
        CloseConnections();

        // Return for API
        if (IsApi()) {
            $res = $url === true;
            if (!$res) { // Show error
                WriteJson(array_merge(["success" => false], $this->getMessages()));
            }
            return;
        } else { // Check if response is JSON
            if (StartsString("application/json", $Response->getHeaderLine("Content-type")) && $Response->getBody()->getSize()) { // With JSON response
                $this->clearMessages();
                return;
            }
        }

        // Go to URL if specified
        if ($url != "") {
            if (!Config("DEBUG") && ob_get_length()) {
                ob_end_clean();
            }
            SaveDebugMessage();
            Redirect(GetUrl($url));
        }
        return; // Return to controller
    }

    // Get records from recordset
    protected function getRecordsFromRecordset($rs, $current = false)
    {
        $rows = [];
        if (is_object($rs)) { // Recordset
            while ($rs && !$rs->EOF) {
                $this->loadRowValues($rs); // Set up DbValue/CurrentValue
		        $this->Logo->OldUploadPath = "files/";
		        $this->Logo->UploadPath = $this->Logo->OldUploadPath;
		        $this->Favicon->OldUploadPath = "files/";
		        $this->Favicon->UploadPath = $this->Favicon->OldUploadPath;
                $row = $this->getRecordFromArray($rs->fields);
                if ($current) {
                    return $row;
                } else {
                    $rows[] = $row;
                }
                $rs->moveNext();
            }
        } elseif (is_array($rs)) {
            foreach ($rs as $ar) {
                $row = $this->getRecordFromArray($ar);
                if ($current) {
                    return $row;
                } else {
                    $rows[] = $row;
                }
            }
        }
        return $rows;
    }

    // Get record from array
    protected function getRecordFromArray($ar)
    {
        $row = [];
        if (is_array($ar)) {
            foreach ($ar as $fldname => $val) {
                if (array_key_exists($fldname, $this->Fields) && ($this->Fields[$fldname]->Visible || $this->Fields[$fldname]->IsPrimaryKey)) { // Primary key or Visible
                    $fld = &$this->Fields[$fldname];
                    if ($fld->HtmlTag == "FILE") { // Upload field
                        if (EmptyValue($val)) {
                            $row[$fldname] = null;
                        } else {
                            if ($fld->DataType == DATATYPE_BLOB) {
                                $url = FullUrl(GetApiUrl(Config("API_FILE_ACTION") .
                                    "/" . $fld->TableVar . "/" . $fld->Param . "/" . rawurlencode($this->getRecordKeyValue($ar))));
                                $row[$fldname] = ["type" => ContentType($val), "url" => $url, "name" => $fld->Param . ContentExtension($val)];
                            } elseif (!$fld->UploadMultiple || !ContainsString($val, Config("MULTIPLE_UPLOAD_SEPARATOR"))) { // Single file
                                $url = FullUrl(GetApiUrl(Config("API_FILE_ACTION") .
                                    "/" . $fld->TableVar . "/" . Encrypt($fld->physicalUploadPath() . $val)));
                                $row[$fldname] = ["type" => MimeContentType($val), "url" => $url, "name" => $val];
                            } else { // Multiple files
                                $files = explode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $val);
                                $ar = [];
                                foreach ($files as $file) {
                                    $url = FullUrl(GetApiUrl(Config("API_FILE_ACTION") .
                                        "/" . $fld->TableVar . "/" . Encrypt($fld->physicalUploadPath() . $file)));
                                    if (!EmptyValue($file)) {
                                        $ar[] = ["type" => MimeContentType($file), "url" => $url, "name" => $file];
                                    }
                                }
                                $row[$fldname] = $ar;
                            }
                        }
                    } else {
                        if ($fld->DataType == DATATYPE_MEMO && $fld->MemoMaxLength > 0) {
                            $val = TruncateMemo($val, $fld->MemoMaxLength, $fld->TruncateMemoRemoveHtml);
                        }
                        $row[$fldname] = $val;
                    }
                }
            }
        }
        return $row;
    }

    // Get record key value from array
    protected function getRecordKeyValue($ar)
    {
        $key = "";
        if (is_array($ar)) {
            $key .= @$ar['ID'];
        }
        return $key;
    }

    /**
     * Hide fields for add/edit
     *
     * @return void
     */
    protected function hideFieldsForAddEdit()
    {
        if ($this->isAdd() || $this->isCopy() || $this->isGridAdd()) {
            $this->ID->Visible = false;
        }
        if ($this->isAddOrEdit()) {
            $this->Created_AT->Visible = false;
        }
        if ($this->isAddOrEdit()) {
            $this->Created_BY->Visible = false;
        }
        if ($this->isAddOrEdit()) {
            $this->IP->Visible = false;
        }
    }

    // Lookup data
    public function lookup($ar = null)
    {
        global $Language, $Security;

        // Get lookup object
        $fieldName = $ar["field"] ?? Post("field");
        $lookup = $this->Fields[$fieldName]->Lookup;

        // Get lookup parameters
        $lookupType = $ar["ajax"] ?? Post("ajax", "unknown");
        $pageSize = -1;
        $offset = -1;
        $searchValue = "";
        if (SameText($lookupType, "modal") || SameText($lookupType, "filter")) {
            $searchValue = $ar["q"] ?? Param("q") ?? $ar["sv"] ?? Post("sv", "");
            $pageSize = $ar["n"] ?? Param("n") ?? $ar["recperpage"] ?? Post("recperpage", 10);
        } elseif (SameText($lookupType, "autosuggest")) {
            $searchValue = $ar["q"] ?? Param("q", "");
            $pageSize = $ar["n"] ?? Param("n", -1);
            $pageSize = is_numeric($pageSize) ? (int)$pageSize : -1;
            if ($pageSize <= 0) {
                $pageSize = Config("AUTO_SUGGEST_MAX_ENTRIES");
            }
        }
        $start = $ar["start"] ?? Param("start", -1);
        $start = is_numeric($start) ? (int)$start : -1;
        $page = $ar["page"] ?? Param("page", -1);
        $page = is_numeric($page) ? (int)$page : -1;
        $offset = $start >= 0 ? $start : ($page > 0 && $pageSize > 0 ? ($page - 1) * $pageSize : 0);
        $userSelect = Decrypt($ar["s"] ?? Post("s", ""));
        $userFilter = Decrypt($ar["f"] ?? Post("f", ""));
        $userOrderBy = Decrypt($ar["o"] ?? Post("o", ""));
        $keys = $ar["keys"] ?? Post("keys");
        $lookup->LookupType = $lookupType; // Lookup type
        $lookup->FilterValues = []; // Clear filter values first
        if ($keys !== null) { // Selected records from modal
            if (is_array($keys)) {
                $keys = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $keys);
            }
            $lookup->FilterFields = []; // Skip parent fields if any
            $lookup->FilterValues[] = $keys; // Lookup values
            $pageSize = -1; // Show all records
        } else { // Lookup values
            $lookup->FilterValues[] = $ar["v0"] ?? $ar["lookupValue"] ?? Post("v0", Post("lookupValue", ""));
        }
        $cnt = is_array($lookup->FilterFields) ? count($lookup->FilterFields) : 0;
        for ($i = 1; $i <= $cnt; $i++) {
            $lookup->FilterValues[] = $ar["v" . $i] ?? Post("v" . $i, "");
        }
        $lookup->SearchValue = $searchValue;
        $lookup->PageSize = $pageSize;
        $lookup->Offset = $offset;
        if ($userSelect != "") {
            $lookup->UserSelect = $userSelect;
        }
        if ($userFilter != "") {
            $lookup->UserFilter = $userFilter;
        }
        if ($userOrderBy != "") {
            $lookup->UserOrderBy = $userOrderBy;
        }
        return $lookup->toJson($this, !is_array($ar)); // Use settings from current page
    }

    // Class variables
    public $ListOptions; // List options
    public $ExportOptions; // Export options
    public $SearchOptions; // Search options
    public $OtherOptions; // Other options
    public $FilterOptions; // Filter options
    public $ImportOptions; // Import options
    public $ListActions; // List actions
    public $SelectedCount = 0;
    public $SelectedIndex = 0;
    public $DisplayRecords = 20;
    public $StartRecord;
    public $StopRecord;
    public $TotalRecords = 0;
    public $RecordRange = 10;
    public $PageSizes = "10,20,50,500,1500,-1"; // Page sizes (comma separated)
    public $DefaultSearchWhere = ""; // Default search WHERE clause
    public $SearchWhere = ""; // Search WHERE clause
    public $SearchPanelClass = "ew-search-panel collapse show"; // Search Panel class
    public $SearchColumnCount = 0; // For extended search
    public $SearchFieldsPerRow = 1; // For extended search
    public $RecordCount = 0; // Record count
    public $EditRowCount;
    public $StartRowCount = 1;
    public $RowCount = 0;
    public $Attrs = []; // Row attributes and cell attributes
    public $RowIndex = 0; // Row index
    public $KeyCount = 0; // Key count
    public $MultiColumnGridClass = "row-cols-md";
    public $MultiColumnEditClass = "col-12 w-100";
    public $MultiColumnCardClass = "card h-100 ew-card";
    public $MultiColumnListOptionsPosition = "bottom-start";
    public $DbMasterFilter = ""; // Master filter
    public $DbDetailFilter = ""; // Detail filter
    public $MasterRecordExists;
    public $MultiSelectKey;
    public $Command;
    public $UserAction; // User action
    public $RestoreSearch = false;
    public $HashValue; // Hash value
    public $DetailPages;
    public $OldRecordset;

    /**
     * Page run
     *
     * @return void
     */
    public function run()
    {
        global $ExportType, $CustomExportType, $ExportFileName, $UserProfile, $Language, $Security, $CurrentForm;

        // Multi column button position
        $this->MultiColumnListOptionsPosition = Config("MULTI_COLUMN_LIST_OPTIONS_POSITION");

        // Use layout
        $this->UseLayout = $this->UseLayout && ConvertToBool(Param("layout", true));

        // Create form object
        $CurrentForm = new HttpForm();

        // Get export parameters
        $custom = "";
        if (Param("export") !== null) {
            $this->Export = Param("export");
            $custom = Param("custom", "");
        } elseif (IsPost()) {
            if (Post("exporttype") !== null) {
                $this->Export = Post("exporttype");
            }
            $custom = Post("custom", "");
        } elseif (Get("cmd") == "json") {
            $this->Export = Get("cmd");
        } else {
            $this->setExportReturnUrl(CurrentUrl());
        }
        $ExportFileName = $this->TableVar; // Get export file, used in header

        // Get custom export parameters
        if ($this->isExport() && $custom != "") {
            $this->CustomExport = $this->Export;
            $this->Export = "print";
        }
        $CustomExportType = $this->CustomExport;
        $ExportType = $this->Export; // Get export parameter, used in header
        $this->CurrentAction = Param("action"); // Set up current action

        // Get grid add count
        $gridaddcnt = Get(Config("TABLE_GRID_ADD_ROW_COUNT"), "");
        if (is_numeric($gridaddcnt) && $gridaddcnt > 0) {
            $this->GridAddRowCount = $gridaddcnt;
        }

        // Set up list options
        $this->setupListOptions();

        // Setup export options
        $this->setupExportOptions();
        $this->ID->setVisibility();
        $this->Contact_No_1->setVisibility();
        $this->Contact_No_2->setVisibility();
        $this->Brand_Name->setVisibility();
        $this->Logo->setVisibility();
        $this->Favicon->setVisibility();
        $this->Address->Visible = false;
        $this->Facebook->setVisibility();
        $this->Twitter->setVisibility();
        $this->Instagram->setVisibility();
        $this->Map->Visible = false;
        $this->_Title->setVisibility();
        $this->Description->Visible = false;
        $this->Keywords->Visible = false;
        $this->Active->setVisibility();
        $this->Created_AT->setVisibility();
        $this->Created_BY->setVisibility();
        $this->IP->setVisibility();
        $this->hideFieldsForAddEdit();

        // Set lookup cache
        if (!in_array($this->PageID, Config("LOOKUP_CACHE_PAGE_IDS"))) {
            $this->setUseLookupCache(false);
        }

        // Global Page Loading event (in userfn*.php)
        Page_Loading();

        // Page Load event
        if (method_exists($this, "pageLoad")) {
            $this->pageLoad();
        }

        // Setup other options
        $this->setupOtherOptions();

        // Set up custom action (compatible with old version)
        foreach ($this->CustomActions as $name => $action) {
            $this->ListActions->add($name, $action);
        }

        // Set up lookup cache
        $this->setupLookupOptions($this->Active);

        // Search filters
        $srchAdvanced = ""; // Advanced search filter
        $srchBasic = ""; // Basic search filter
        $filter = "";

        // Get command
        $this->Command = strtolower(Get("cmd"));
        if ($this->isPageRequest()) {
            // Process list action first
            if ($this->processListAction()) { // Ajax request
                $this->terminate();
                return;
            }

            // Set up records per page
            $this->setupDisplayRecords();

            // Handle reset command
            $this->resetCmd();

            // Set up Breadcrumb
            if (!$this->isExport()) {
                $this->setupBreadcrumb();
            }

            // Check QueryString parameters
            if (Get("action") !== null) {
                $this->CurrentAction = Get("action");

                // Clear inline mode
                if ($this->isCancel()) {
                    $this->clearInlineMode();
                }

                // Switch to grid edit mode
                if ($this->isGridEdit()) {
                    $this->gridEditMode();
                }

                // Switch to grid add mode
                if ($this->isGridAdd()) {
                    $this->gridAddMode();
                }
            } else {
                if (Post("action") !== null) {
                    $this->CurrentAction = Post("action"); // Get action

                    // Grid Update
                    if (($this->isGridUpdate() || $this->isGridOverwrite()) && Session(SESSION_INLINE_MODE) == "gridedit") {
                        if ($this->validateGridForm()) {
                            $gridUpdate = $this->gridUpdate();
                        } else {
                            $gridUpdate = false;
                        }
                        if ($gridUpdate) {
                        } else {
                            $this->EventCancelled = true;
                            $this->gridEditMode(); // Stay in Grid edit mode
                        }
                    }

                    // Grid Insert
                    if ($this->isGridInsert() && Session(SESSION_INLINE_MODE) == "gridadd") {
                        if ($this->validateGridForm()) {
                            $gridInsert = $this->gridInsert();
                        } else {
                            $gridInsert = false;
                        }
                        if ($gridInsert) {
                        } else {
                            $this->EventCancelled = true;
                            $this->gridAddMode(); // Stay in Grid add mode
                        }
                    }
                } elseif (Session(SESSION_INLINE_MODE) == "gridedit") { // Previously in grid edit mode
                    if (Get(Config("TABLE_START_REC")) !== null || Get(Config("TABLE_PAGE_NO")) !== null) { // Stay in grid edit mode if paging
                        $this->gridEditMode();
                    } else { // Reset grid edit
                        $this->clearInlineMode();
                    }
                }
            }

            // Hide list options
            if ($this->isExport()) {
                $this->ListOptions->hideAllOptions(["sequence"]);
                $this->ListOptions->UseDropDownButton = false; // Disable drop down button
                $this->ListOptions->UseButtonGroup = false; // Disable button group
            } elseif ($this->isGridAdd() || $this->isGridEdit()) {
                $this->ListOptions->hideAllOptions();
                $this->ListOptions->UseDropDownButton = false; // Disable drop down button
                $this->ListOptions->UseButtonGroup = false; // Disable button group
            }

            // Hide options
            if ($this->isExport() || $this->CurrentAction) {
                $this->ExportOptions->hideAllOptions();
                $this->FilterOptions->hideAllOptions();
                $this->ImportOptions->hideAllOptions();
            }

            // Hide other options
            if ($this->isExport()) {
                $this->OtherOptions->hideAllOptions();
            }

            // Show grid delete link for grid add / grid edit
            if ($this->AllowAddDeleteRow) {
                if ($this->isGridAdd() || $this->isGridEdit()) {
                    $item = $this->ListOptions["griddelete"];
                    if ($item) {
                        $item->Visible = true;
                    }
                }
            }

            // Get default search criteria
            AddFilter($this->DefaultSearchWhere, $this->basicSearchWhere(true));

            // Get basic search values
            $this->loadBasicSearchValues();

            // Process filter list
            if ($this->processFilterList()) {
                $this->terminate();
                return;
            }

            // Restore search parms from Session if not searching / reset / export
            if (($this->isExport() || $this->Command != "search" && $this->Command != "reset" && $this->Command != "resetall") && $this->Command != "json" && $this->checkSearchParms()) {
                $this->restoreSearchParms();
            }

            // Call Recordset SearchValidated event
            $this->recordsetSearchValidated();

            // Set up sorting order
            $this->setupSortOrder();

            // Get basic search criteria
            if (!$this->hasInvalidFields()) {
                $srchBasic = $this->basicSearchWhere();
            }
        }

        // Restore display records
        if ($this->Command != "json" && $this->getRecordsPerPage() != "") {
            $this->DisplayRecords = $this->getRecordsPerPage(); // Restore from Session
        } else {
            $this->DisplayRecords = 20; // Load default
            $this->setRecordsPerPage($this->DisplayRecords); // Save default to Session
        }

        // Load Sorting Order
        if ($this->Command != "json") {
            $this->loadSortOrder();
        }

        // Load search default if no existing search criteria
        if (!$this->checkSearchParms()) {
            // Load basic search from default
            $this->BasicSearch->loadDefault();
            if ($this->BasicSearch->Keyword != "") {
                $srchBasic = $this->basicSearchWhere();
            }
        }

        // Build search criteria
        AddFilter($this->SearchWhere, $srchAdvanced);
        AddFilter($this->SearchWhere, $srchBasic);

        // Call Recordset_Searching event
        $this->recordsetSearching($this->SearchWhere);

        // Save search criteria
        if ($this->Command == "search" && !$this->RestoreSearch) {
            $this->setSearchWhere($this->SearchWhere); // Save to Session
            $this->StartRecord = 1; // Reset start record counter
            $this->setStartRecordNumber($this->StartRecord);
        } elseif ($this->Command != "json") {
            $this->SearchWhere = $this->getSearchWhere();
        }

        // Build filter
        $filter = "";
        if (!$Security->canList()) {
            $filter = "(0=1)"; // Filter all records
        }
        AddFilter($filter, $this->DbDetailFilter);
        AddFilter($filter, $this->SearchWhere);

        // Set up filter
        if ($this->Command == "json") {
            $this->UseSessionForListSql = false; // Do not use session for ListSQL
            $this->CurrentFilter = $filter;
        } else {
            $this->setSessionWhere($filter);
            $this->CurrentFilter = "";
        }

        // Export data only
        if (!$this->CustomExport && in_array($this->Export, array_keys(Config("EXPORT_CLASSES")))) {
            $this->exportData();
            $this->terminate();
            return;
        }
        if ($this->isGridAdd()) {
            $this->CurrentFilter = "0=1";
            $this->StartRecord = 1;
            $this->DisplayRecords = $this->GridAddRowCount;
            $this->TotalRecords = $this->DisplayRecords;
            $this->StopRecord = $this->DisplayRecords;
        } else {
            $this->TotalRecords = $this->listRecordCount();
            $this->StartRecord = 1;
            if ($this->DisplayRecords <= 0 || ($this->isExport() && $this->ExportAll)) { // Display all records
                $this->DisplayRecords = $this->TotalRecords;
            }
            if (!($this->isExport() && $this->ExportAll)) { // Set up start record position
                $this->setupStartRecord();
            }
            $this->Recordset = $this->loadRecordset($this->StartRecord - 1, $this->DisplayRecords);

            // Set no record found message
            if (!$this->CurrentAction && $this->TotalRecords == 0) {
                if (!$Security->canList()) {
                    $this->setWarningMessage(DeniedMessage());
                }
                if ($this->SearchWhere == "0=101") {
                    $this->setWarningMessage($Language->phrase("EnterSearchCriteria"));
                } else {
                    $this->setWarningMessage($Language->phrase("NoRecord"));
                }
            }

            // Audit trail on search
            if ($this->AuditTrailOnSearch && $this->Command == "search" && !$this->RestoreSearch) {
                $searchParm = ServerVar("QUERY_STRING");
                $searchSql = $this->getSessionWhere();
                $this->writeAuditTrailOnSearch($searchParm, $searchSql);
            }
        }

        // Set up list action columns
        foreach ($this->ListActions->Items as $listaction) {
            if ($listaction->Allow) {
                if ($listaction->Select == ACTION_MULTIPLE) { // Show checkbox column if multiple action
                    $this->ListOptions["checkbox"]->Visible = true;
                } elseif ($listaction->Select == ACTION_SINGLE) { // Show list action column
                        $this->ListOptions["listactions"]->Visible = true; // Set visible if any list action is allowed
                }
            }
        }

        // Search options
        $this->setupSearchOptions();

        // Set up search panel class
        if ($this->SearchWhere != "") {
            AppendClass($this->SearchPanelClass, "show");
        }

        // Normal return
        if (IsApi()) {
            $rows = $this->getRecordsFromRecordset($this->Recordset);
            $this->Recordset->close();
            WriteJson(["success" => true, $this->TableVar => $rows, "totalRecordCount" => $this->TotalRecords]);
            $this->terminate(true);
            return;
        }

        // Set up pager
        $this->Pager = new PrevNextPager($this->TableVar, $this->StartRecord, $this->getRecordsPerPage(), $this->TotalRecords, $this->PageSizes, $this->RecordRange, $this->AutoHidePager, $this->AutoHidePageSizeSelector);

        // Set LoginStatus / Page_Rendering / Page_Render
        if (!IsApi() && !$this->isTerminated()) {
            // Setup login status
            SetupLoginStatus();

            // Pass login status to client side
            SetClientVar("login", LoginStatus());

            // Global Page Rendering event (in userfn*.php)
            Page_Rendering();

            // Page Render event
            if (method_exists($this, "pageRender")) {
                $this->pageRender();
            }

            // Render search option
            if (method_exists($this, "renderSearchOptions")) {
                $this->renderSearchOptions();
            }
        }
    }

    // Set up number of records displayed per page
    protected function setupDisplayRecords()
    {
        $wrk = Get(Config("TABLE_REC_PER_PAGE"), "");
        if ($wrk != "") {
            if (is_numeric($wrk)) {
                $this->DisplayRecords = (int)$wrk;
            } else {
                if (SameText($wrk, "all")) { // Display all records
                    $this->DisplayRecords = -1;
                } else {
                    $this->DisplayRecords = 20; // Non-numeric, load default
                }
            }
            $this->setRecordsPerPage($this->DisplayRecords); // Save to Session
            // Reset start position
            $this->StartRecord = 1;
            $this->setStartRecordNumber($this->StartRecord);
        }
    }

    // Exit inline mode
    protected function clearInlineMode()
    {
        $this->LastAction = $this->CurrentAction; // Save last action
        $this->CurrentAction = ""; // Clear action
        $_SESSION[SESSION_INLINE_MODE] = ""; // Clear inline mode
    }

    // Switch to Grid Add mode
    protected function gridAddMode()
    {
        $this->CurrentAction = "gridadd";
        $_SESSION[SESSION_INLINE_MODE] = "gridadd";
        $this->hideFieldsForAddEdit();
    }

    // Switch to Grid Edit mode
    protected function gridEditMode()
    {
        $this->CurrentAction = "gridedit";
        $_SESSION[SESSION_INLINE_MODE] = "gridedit";
        $this->hideFieldsForAddEdit();
    }

    // Perform update to grid
    public function gridUpdate()
    {
        global $Language, $CurrentForm;
        $gridUpdate = true;

        // Get old recordset
        $this->CurrentFilter = $this->buildKeyFilter();
        if ($this->CurrentFilter == "") {
            $this->CurrentFilter = "0=1";
        }
        $sql = $this->getCurrentSql();
        $conn = $this->getConnection();
        if ($rs = $conn->executeQuery($sql)) {
            $rsold = $rs->fetchAllAssociative();
        }

        // Call Grid Updating event
        if (!$this->gridUpdating($rsold)) {
            if ($this->getFailureMessage() == "") {
                $this->setFailureMessage($Language->phrase("GridEditCancelled")); // Set grid edit cancelled message
            }
            return false;
        }

        // Begin transaction
        if ($this->UseTransaction) {
            $conn->beginTransaction();
        }
        if ($this->AuditTrailOnEdit) {
            $this->writeAuditTrailDummy($Language->phrase("BatchUpdateBegin")); // Batch update begin
        }
        $key = "";

        // Update row index and get row key
        $CurrentForm->Index = -1;
        $rowcnt = strval($CurrentForm->getValue($this->FormKeyCountName));
        if ($rowcnt == "" || !is_numeric($rowcnt)) {
            $rowcnt = 0;
        }

        // Update all rows based on key
        for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {
            $CurrentForm->Index = $rowindex;
            $this->setKey($CurrentForm->getValue($this->OldKeyName));
            $rowaction = strval($CurrentForm->getValue($this->FormActionName));

            // Load all values and keys
            if ($rowaction != "insertdelete") { // Skip insert then deleted rows
                $this->loadFormValues(); // Get form values
                if ($rowaction == "" || $rowaction == "edit" || $rowaction == "delete") {
                    $gridUpdate = $this->OldKey != ""; // Key must not be empty
                } else {
                    $gridUpdate = true;
                }

                // Skip empty row
                if ($rowaction == "insert" && $this->emptyRow()) {
                // Validate form and insert/update/delete record
                } elseif ($gridUpdate) {
                    if ($rowaction == "delete") {
                        $this->CurrentFilter = $this->getRecordFilter();
                        $gridUpdate = $this->deleteRows(); // Delete this row
                    //} elseif (!$this->validateForm()) { // Already done in validateGridForm
                    //    $gridUpdate = false; // Form error, reset action
                    } else {
                        if ($rowaction == "insert") {
                            $gridUpdate = $this->addRow(); // Insert this row
                        } else {
                            if ($this->OldKey != "") {
                                $this->SendEmail = false; // Do not send email on update success
                                $gridUpdate = $this->editRow(); // Update this row
                            }
                        } // End update
                    }
                }
                if ($gridUpdate) {
                    if ($key != "") {
                        $key .= ", ";
                    }
                    $key .= $this->OldKey;
                } else {
                    break;
                }
            }
        }
        if ($gridUpdate) {
            if ($this->UseTransaction) { // Commit transaction
                $conn->commit();
            }

            // Get new records
            $rsnew = $conn->fetchAllAssociative($sql);

            // Call Grid_Updated event
            $this->gridUpdated($rsold, $rsnew);
            if ($this->AuditTrailOnEdit) {
                $this->writeAuditTrailDummy($Language->phrase("BatchUpdateSuccess")); // Batch update success
            }
            if ($this->getSuccessMessage() == "") {
                $this->setSuccessMessage($Language->phrase("UpdateSuccess")); // Set up update success message
            }
            $this->clearInlineMode(); // Clear inline edit mode
        } else {
            if ($this->UseTransaction) { // Rollback transaction
                $conn->rollback();
            }
            if ($this->AuditTrailOnEdit) {
                $this->writeAuditTrailDummy($Language->phrase("BatchUpdateRollback")); // Batch update rollback
            }
            if ($this->getFailureMessage() == "") {
                $this->setFailureMessage($Language->phrase("UpdateFailed")); // Set update failed message
            }
        }
        return $gridUpdate;
    }

    // Build filter for all keys
    protected function buildKeyFilter()
    {
        global $CurrentForm;
        $wrkFilter = "";

        // Update row index and get row key
        $rowindex = 1;
        $CurrentForm->Index = $rowindex;
        $thisKey = strval($CurrentForm->getValue($this->OldKeyName));
        while ($thisKey != "") {
            $this->setKey($thisKey);
            if ($this->OldKey != "") {
                $filter = $this->getRecordFilter();
                if ($wrkFilter != "") {
                    $wrkFilter .= " OR ";
                }
                $wrkFilter .= $filter;
            } else {
                $wrkFilter = "0=1";
                break;
            }

            // Update row index and get row key
            $rowindex++; // Next row
            $CurrentForm->Index = $rowindex;
            $thisKey = strval($CurrentForm->getValue($this->OldKeyName));
        }
        return $wrkFilter;
    }

    // Perform Grid Add
    public function gridInsert()
    {
        global $Language, $CurrentForm;
        $rowindex = 1;
        $gridInsert = false;
        $conn = $this->getConnection();

        // Call Grid Inserting event
        if (!$this->gridInserting()) {
            if ($this->getFailureMessage() == "") {
                $this->setFailureMessage($Language->phrase("GridAddCancelled")); // Set grid add cancelled message
            }
            return false;
        }

        // Begin transaction
        if ($this->UseTransaction) {
            $conn->beginTransaction();
        }

        // Init key filter
        $wrkfilter = "";
        $addcnt = 0;
        if ($this->AuditTrailOnAdd) {
            $this->writeAuditTrailDummy($Language->phrase("BatchInsertBegin")); // Batch insert begin
        }
        $key = "";

        // Get row count
        $CurrentForm->Index = -1;
        $rowcnt = strval($CurrentForm->getValue($this->FormKeyCountName));
        if ($rowcnt == "" || !is_numeric($rowcnt)) {
            $rowcnt = 0;
        }

        // Insert all rows
        for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {
            // Load current row values
            $CurrentForm->Index = $rowindex;
            $rowaction = strval($CurrentForm->getValue($this->FormActionName));
            if ($rowaction != "" && $rowaction != "insert") {
                continue; // Skip
            }
            if ($rowaction == "insert") {
                $this->OldKey = strval($CurrentForm->getValue($this->OldKeyName));
                $this->loadOldRecord(); // Load old record
            }
            $this->loadFormValues(); // Get form values
            if (!$this->emptyRow()) {
                $addcnt++;
                $this->SendEmail = false; // Do not send email on insert success

                // Validate form // Already done in validateGridForm
                //if (!$this->validateForm()) {
                //    $gridInsert = false; // Form error, reset action
                //} else {
                    $gridInsert = $this->addRow($this->OldRecordset); // Insert this row
                //}
                if ($gridInsert) {
                    if ($key != "") {
                        $key .= Config("COMPOSITE_KEY_SEPARATOR");
                    }
                    $key .= $this->ID->CurrentValue;

                    // Add filter for this record
                    $filter = $this->getRecordFilter();
                    if ($wrkfilter != "") {
                        $wrkfilter .= " OR ";
                    }
                    $wrkfilter .= $filter;
                } else {
                    break;
                }
            }
        }
        if ($addcnt == 0) { // No record inserted
            $this->setFailureMessage($Language->phrase("NoAddRecord"));
            $gridInsert = false;
        }
        if ($gridInsert) {
            if ($this->UseTransaction) { // Commit transaction
                $conn->commit();
            }

            // Get new records
            $this->CurrentFilter = $wrkfilter;
            $sql = $this->getCurrentSql();
            $rsnew = $conn->fetchAllAssociative($sql);

            // Call Grid_Inserted event
            $this->gridInserted($rsnew);
            if ($this->AuditTrailOnAdd) {
                $this->writeAuditTrailDummy($Language->phrase("BatchInsertSuccess")); // Batch insert success
            }
            if ($this->getSuccessMessage() == "") {
                $this->setSuccessMessage($Language->phrase("InsertSuccess")); // Set up insert success message
            }
            $this->clearInlineMode(); // Clear grid add mode
        } else {
            if ($this->UseTransaction) { // Rollback transaction
                $conn->rollback();
            }
            if ($this->AuditTrailOnAdd) {
                $this->writeAuditTrailDummy($Language->phrase("BatchInsertRollback")); // Batch insert rollback
            }
            if ($this->getFailureMessage() == "") {
                $this->setFailureMessage($Language->phrase("InsertFailed")); // Set insert failed message
            }
        }
        return $gridInsert;
    }

    // Check if empty row
    public function emptyRow()
    {
        global $CurrentForm;
        if ($CurrentForm->hasValue("x_Contact_No_1") && $CurrentForm->hasValue("o_Contact_No_1") && $this->Contact_No_1->CurrentValue != $this->Contact_No_1->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_Contact_No_2") && $CurrentForm->hasValue("o_Contact_No_2") && $this->Contact_No_2->CurrentValue != $this->Contact_No_2->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_Brand_Name") && $CurrentForm->hasValue("o_Brand_Name") && $this->Brand_Name->CurrentValue != $this->Brand_Name->OldValue) {
            return false;
        }
        if (!EmptyValue($this->Logo->Upload->Value)) {
            return false;
        }
        if (!EmptyValue($this->Favicon->Upload->Value)) {
            return false;
        }
        if ($CurrentForm->hasValue("x_Facebook") && $CurrentForm->hasValue("o_Facebook") && $this->Facebook->CurrentValue != $this->Facebook->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_Twitter") && $CurrentForm->hasValue("o_Twitter") && $this->Twitter->CurrentValue != $this->Twitter->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_Instagram") && $CurrentForm->hasValue("o_Instagram") && $this->Instagram->CurrentValue != $this->Instagram->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x__Title") && $CurrentForm->hasValue("o__Title") && $this->_Title->CurrentValue != $this->_Title->OldValue) {
            return false;
        }
        if ($CurrentForm->hasValue("x_Active") && $CurrentForm->hasValue("o_Active") && ConvertToBool($this->Active->CurrentValue) != ConvertToBool($this->Active->OldValue)) {
            return false;
        }
        return true;
    }

    // Validate grid form
    public function validateGridForm()
    {
        global $CurrentForm;
        // Get row count
        $CurrentForm->Index = -1;
        $rowcnt = strval($CurrentForm->getValue($this->FormKeyCountName));
        if ($rowcnt == "" || !is_numeric($rowcnt)) {
            $rowcnt = 0;
        }

        // Validate all records
        for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {
            // Load current row values
            $CurrentForm->Index = $rowindex;
            $rowaction = strval($CurrentForm->getValue($this->FormActionName));
            if ($rowaction != "delete" && $rowaction != "insertdelete") {
                $this->loadFormValues(); // Get form values
                if ($rowaction == "insert" && $this->emptyRow()) {
                    // Ignore
                } elseif (!$this->validateForm()) {
                    $this->EventCancelled = true;
                    return false;
                }
            }
        }
        return true;
    }

    // Get all form values of the grid
    public function getGridFormValues()
    {
        global $CurrentForm;
        // Get row count
        $CurrentForm->Index = -1;
        $rowcnt = strval($CurrentForm->getValue($this->FormKeyCountName));
        if ($rowcnt == "" || !is_numeric($rowcnt)) {
            $rowcnt = 0;
        }
        $rows = [];

        // Loop through all records
        for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {
            // Load current row values
            $CurrentForm->Index = $rowindex;
            $rowaction = strval($CurrentForm->getValue($this->FormActionName));
            if ($rowaction != "delete" && $rowaction != "insertdelete") {
                $this->loadFormValues(); // Get form values
                if ($rowaction == "insert" && $this->emptyRow()) {
                    // Ignore
                } else {
                    $rows[] = $this->getFieldValues("FormValue"); // Return row as array
                }
            }
        }
        return $rows; // Return as array of array
    }

    // Restore form values for current row
    public function restoreCurrentRowFormValues($idx)
    {
        global $CurrentForm;

        // Get row based on current index
        $CurrentForm->Index = $idx;
        $rowaction = strval($CurrentForm->getValue($this->FormActionName));
        $this->loadFormValues(); // Load form values
        // Set up invalid status correctly
        $this->resetFormError();
        if ($rowaction == "insert" && $this->emptyRow()) {
            // Ignore
        } else {
            $this->validateForm();
        }
    }

    // Reset form status
    public function resetFormError()
    {
        $this->ID->clearErrorMessage();
        $this->Contact_No_1->clearErrorMessage();
        $this->Contact_No_2->clearErrorMessage();
        $this->Brand_Name->clearErrorMessage();
        $this->Logo->clearErrorMessage();
        $this->Favicon->clearErrorMessage();
        $this->Facebook->clearErrorMessage();
        $this->Twitter->clearErrorMessage();
        $this->Instagram->clearErrorMessage();
        $this->_Title->clearErrorMessage();
        $this->Active->clearErrorMessage();
        $this->Created_AT->clearErrorMessage();
        $this->Created_BY->clearErrorMessage();
        $this->IP->clearErrorMessage();
    }

    // Get list of filters
    public function getFilterList()
    {
        global $UserProfile;

        // Initialize
        $filterList = "";
        $savedFilterList = "";

        // Load server side filters
        if (Config("SEARCH_FILTER_OPTION") == "Server" && isset($UserProfile)) {
            $savedFilterList = $UserProfile->getSearchFilters(CurrentUserName(), "fsite_settingssrch");
        }
        $filterList = Concat($filterList, $this->ID->AdvancedSearch->toJson(), ","); // Field ID
        $filterList = Concat($filterList, $this->Contact_No_1->AdvancedSearch->toJson(), ","); // Field Contact_No_1
        $filterList = Concat($filterList, $this->Contact_No_2->AdvancedSearch->toJson(), ","); // Field Contact_No_2
        $filterList = Concat($filterList, $this->Brand_Name->AdvancedSearch->toJson(), ","); // Field Brand_Name
        $filterList = Concat($filterList, $this->Logo->AdvancedSearch->toJson(), ","); // Field Logo
        $filterList = Concat($filterList, $this->Favicon->AdvancedSearch->toJson(), ","); // Field Favicon
        $filterList = Concat($filterList, $this->Address->AdvancedSearch->toJson(), ","); // Field Address
        $filterList = Concat($filterList, $this->Facebook->AdvancedSearch->toJson(), ","); // Field Facebook
        $filterList = Concat($filterList, $this->Twitter->AdvancedSearch->toJson(), ","); // Field Twitter
        $filterList = Concat($filterList, $this->Instagram->AdvancedSearch->toJson(), ","); // Field Instagram
        $filterList = Concat($filterList, $this->Map->AdvancedSearch->toJson(), ","); // Field Map
        $filterList = Concat($filterList, $this->_Title->AdvancedSearch->toJson(), ","); // Field Title
        $filterList = Concat($filterList, $this->Description->AdvancedSearch->toJson(), ","); // Field Description
        $filterList = Concat($filterList, $this->Keywords->AdvancedSearch->toJson(), ","); // Field Keywords
        $filterList = Concat($filterList, $this->Active->AdvancedSearch->toJson(), ","); // Field Active
        $filterList = Concat($filterList, $this->Created_AT->AdvancedSearch->toJson(), ","); // Field Created_AT
        $filterList = Concat($filterList, $this->Created_BY->AdvancedSearch->toJson(), ","); // Field Created_BY
        $filterList = Concat($filterList, $this->IP->AdvancedSearch->toJson(), ","); // Field IP
        if ($this->BasicSearch->Keyword != "") {
            $wrk = "\"" . Config("TABLE_BASIC_SEARCH") . "\":\"" . JsEncode($this->BasicSearch->Keyword) . "\",\"" . Config("TABLE_BASIC_SEARCH_TYPE") . "\":\"" . JsEncode($this->BasicSearch->Type) . "\"";
            $filterList = Concat($filterList, $wrk, ",");
        }

        // Return filter list in JSON
        if ($filterList != "") {
            $filterList = "\"data\":{" . $filterList . "}";
        }
        if ($savedFilterList != "") {
            $filterList = Concat($filterList, "\"filters\":" . $savedFilterList, ",");
        }
        return ($filterList != "") ? "{" . $filterList . "}" : "null";
    }

    // Process filter list
    protected function processFilterList()
    {
        global $UserProfile;
        if (Post("ajax") == "savefilters") { // Save filter request (Ajax)
            $filters = Post("filters");
            $UserProfile->setSearchFilters(CurrentUserName(), "fsite_settingssrch", $filters);
            WriteJson([["success" => true]]); // Success
            return true;
        } elseif (Post("cmd") == "resetfilter") {
            $this->restoreFilterList();
        }
        return false;
    }

    // Restore list of filters
    protected function restoreFilterList()
    {
        // Return if not reset filter
        if (Post("cmd") !== "resetfilter") {
            return false;
        }
        $filter = json_decode(Post("filter"), true);
        $this->Command = "search";

        // Field ID
        $this->ID->AdvancedSearch->SearchValue = @$filter["x_ID"];
        $this->ID->AdvancedSearch->SearchOperator = @$filter["z_ID"];
        $this->ID->AdvancedSearch->SearchCondition = @$filter["v_ID"];
        $this->ID->AdvancedSearch->SearchValue2 = @$filter["y_ID"];
        $this->ID->AdvancedSearch->SearchOperator2 = @$filter["w_ID"];
        $this->ID->AdvancedSearch->save();

        // Field Contact_No_1
        $this->Contact_No_1->AdvancedSearch->SearchValue = @$filter["x_Contact_No_1"];
        $this->Contact_No_1->AdvancedSearch->SearchOperator = @$filter["z_Contact_No_1"];
        $this->Contact_No_1->AdvancedSearch->SearchCondition = @$filter["v_Contact_No_1"];
        $this->Contact_No_1->AdvancedSearch->SearchValue2 = @$filter["y_Contact_No_1"];
        $this->Contact_No_1->AdvancedSearch->SearchOperator2 = @$filter["w_Contact_No_1"];
        $this->Contact_No_1->AdvancedSearch->save();

        // Field Contact_No_2
        $this->Contact_No_2->AdvancedSearch->SearchValue = @$filter["x_Contact_No_2"];
        $this->Contact_No_2->AdvancedSearch->SearchOperator = @$filter["z_Contact_No_2"];
        $this->Contact_No_2->AdvancedSearch->SearchCondition = @$filter["v_Contact_No_2"];
        $this->Contact_No_2->AdvancedSearch->SearchValue2 = @$filter["y_Contact_No_2"];
        $this->Contact_No_2->AdvancedSearch->SearchOperator2 = @$filter["w_Contact_No_2"];
        $this->Contact_No_2->AdvancedSearch->save();

        // Field Brand_Name
        $this->Brand_Name->AdvancedSearch->SearchValue = @$filter["x_Brand_Name"];
        $this->Brand_Name->AdvancedSearch->SearchOperator = @$filter["z_Brand_Name"];
        $this->Brand_Name->AdvancedSearch->SearchCondition = @$filter["v_Brand_Name"];
        $this->Brand_Name->AdvancedSearch->SearchValue2 = @$filter["y_Brand_Name"];
        $this->Brand_Name->AdvancedSearch->SearchOperator2 = @$filter["w_Brand_Name"];
        $this->Brand_Name->AdvancedSearch->save();

        // Field Logo
        $this->Logo->AdvancedSearch->SearchValue = @$filter["x_Logo"];
        $this->Logo->AdvancedSearch->SearchOperator = @$filter["z_Logo"];
        $this->Logo->AdvancedSearch->SearchCondition = @$filter["v_Logo"];
        $this->Logo->AdvancedSearch->SearchValue2 = @$filter["y_Logo"];
        $this->Logo->AdvancedSearch->SearchOperator2 = @$filter["w_Logo"];
        $this->Logo->AdvancedSearch->save();

        // Field Favicon
        $this->Favicon->AdvancedSearch->SearchValue = @$filter["x_Favicon"];
        $this->Favicon->AdvancedSearch->SearchOperator = @$filter["z_Favicon"];
        $this->Favicon->AdvancedSearch->SearchCondition = @$filter["v_Favicon"];
        $this->Favicon->AdvancedSearch->SearchValue2 = @$filter["y_Favicon"];
        $this->Favicon->AdvancedSearch->SearchOperator2 = @$filter["w_Favicon"];
        $this->Favicon->AdvancedSearch->save();

        // Field Address
        $this->Address->AdvancedSearch->SearchValue = @$filter["x_Address"];
        $this->Address->AdvancedSearch->SearchOperator = @$filter["z_Address"];
        $this->Address->AdvancedSearch->SearchCondition = @$filter["v_Address"];
        $this->Address->AdvancedSearch->SearchValue2 = @$filter["y_Address"];
        $this->Address->AdvancedSearch->SearchOperator2 = @$filter["w_Address"];
        $this->Address->AdvancedSearch->save();

        // Field Facebook
        $this->Facebook->AdvancedSearch->SearchValue = @$filter["x_Facebook"];
        $this->Facebook->AdvancedSearch->SearchOperator = @$filter["z_Facebook"];
        $this->Facebook->AdvancedSearch->SearchCondition = @$filter["v_Facebook"];
        $this->Facebook->AdvancedSearch->SearchValue2 = @$filter["y_Facebook"];
        $this->Facebook->AdvancedSearch->SearchOperator2 = @$filter["w_Facebook"];
        $this->Facebook->AdvancedSearch->save();

        // Field Twitter
        $this->Twitter->AdvancedSearch->SearchValue = @$filter["x_Twitter"];
        $this->Twitter->AdvancedSearch->SearchOperator = @$filter["z_Twitter"];
        $this->Twitter->AdvancedSearch->SearchCondition = @$filter["v_Twitter"];
        $this->Twitter->AdvancedSearch->SearchValue2 = @$filter["y_Twitter"];
        $this->Twitter->AdvancedSearch->SearchOperator2 = @$filter["w_Twitter"];
        $this->Twitter->AdvancedSearch->save();

        // Field Instagram
        $this->Instagram->AdvancedSearch->SearchValue = @$filter["x_Instagram"];
        $this->Instagram->AdvancedSearch->SearchOperator = @$filter["z_Instagram"];
        $this->Instagram->AdvancedSearch->SearchCondition = @$filter["v_Instagram"];
        $this->Instagram->AdvancedSearch->SearchValue2 = @$filter["y_Instagram"];
        $this->Instagram->AdvancedSearch->SearchOperator2 = @$filter["w_Instagram"];
        $this->Instagram->AdvancedSearch->save();

        // Field Map
        $this->Map->AdvancedSearch->SearchValue = @$filter["x_Map"];
        $this->Map->AdvancedSearch->SearchOperator = @$filter["z_Map"];
        $this->Map->AdvancedSearch->SearchCondition = @$filter["v_Map"];
        $this->Map->AdvancedSearch->SearchValue2 = @$filter["y_Map"];
        $this->Map->AdvancedSearch->SearchOperator2 = @$filter["w_Map"];
        $this->Map->AdvancedSearch->save();

        // Field Title
        $this->_Title->AdvancedSearch->SearchValue = @$filter["x__Title"];
        $this->_Title->AdvancedSearch->SearchOperator = @$filter["z__Title"];
        $this->_Title->AdvancedSearch->SearchCondition = @$filter["v__Title"];
        $this->_Title->AdvancedSearch->SearchValue2 = @$filter["y__Title"];
        $this->_Title->AdvancedSearch->SearchOperator2 = @$filter["w__Title"];
        $this->_Title->AdvancedSearch->save();

        // Field Description
        $this->Description->AdvancedSearch->SearchValue = @$filter["x_Description"];
        $this->Description->AdvancedSearch->SearchOperator = @$filter["z_Description"];
        $this->Description->AdvancedSearch->SearchCondition = @$filter["v_Description"];
        $this->Description->AdvancedSearch->SearchValue2 = @$filter["y_Description"];
        $this->Description->AdvancedSearch->SearchOperator2 = @$filter["w_Description"];
        $this->Description->AdvancedSearch->save();

        // Field Keywords
        $this->Keywords->AdvancedSearch->SearchValue = @$filter["x_Keywords"];
        $this->Keywords->AdvancedSearch->SearchOperator = @$filter["z_Keywords"];
        $this->Keywords->AdvancedSearch->SearchCondition = @$filter["v_Keywords"];
        $this->Keywords->AdvancedSearch->SearchValue2 = @$filter["y_Keywords"];
        $this->Keywords->AdvancedSearch->SearchOperator2 = @$filter["w_Keywords"];
        $this->Keywords->AdvancedSearch->save();

        // Field Active
        $this->Active->AdvancedSearch->SearchValue = @$filter["x_Active"];
        $this->Active->AdvancedSearch->SearchOperator = @$filter["z_Active"];
        $this->Active->AdvancedSearch->SearchCondition = @$filter["v_Active"];
        $this->Active->AdvancedSearch->SearchValue2 = @$filter["y_Active"];
        $this->Active->AdvancedSearch->SearchOperator2 = @$filter["w_Active"];
        $this->Active->AdvancedSearch->save();

        // Field Created_AT
        $this->Created_AT->AdvancedSearch->SearchValue = @$filter["x_Created_AT"];
        $this->Created_AT->AdvancedSearch->SearchOperator = @$filter["z_Created_AT"];
        $this->Created_AT->AdvancedSearch->SearchCondition = @$filter["v_Created_AT"];
        $this->Created_AT->AdvancedSearch->SearchValue2 = @$filter["y_Created_AT"];
        $this->Created_AT->AdvancedSearch->SearchOperator2 = @$filter["w_Created_AT"];
        $this->Created_AT->AdvancedSearch->save();

        // Field Created_BY
        $this->Created_BY->AdvancedSearch->SearchValue = @$filter["x_Created_BY"];
        $this->Created_BY->AdvancedSearch->SearchOperator = @$filter["z_Created_BY"];
        $this->Created_BY->AdvancedSearch->SearchCondition = @$filter["v_Created_BY"];
        $this->Created_BY->AdvancedSearch->SearchValue2 = @$filter["y_Created_BY"];
        $this->Created_BY->AdvancedSearch->SearchOperator2 = @$filter["w_Created_BY"];
        $this->Created_BY->AdvancedSearch->save();

        // Field IP
        $this->IP->AdvancedSearch->SearchValue = @$filter["x_IP"];
        $this->IP->AdvancedSearch->SearchOperator = @$filter["z_IP"];
        $this->IP->AdvancedSearch->SearchCondition = @$filter["v_IP"];
        $this->IP->AdvancedSearch->SearchValue2 = @$filter["y_IP"];
        $this->IP->AdvancedSearch->SearchOperator2 = @$filter["w_IP"];
        $this->IP->AdvancedSearch->save();
        $this->BasicSearch->setKeyword(@$filter[Config("TABLE_BASIC_SEARCH")]);
        $this->BasicSearch->setType(@$filter[Config("TABLE_BASIC_SEARCH_TYPE")]);
    }

    // Return basic search WHERE clause based on search keyword and type
    protected function basicSearchWhere($default = false)
    {
        global $Security;
        $searchStr = "";
        if (!$Security->canSearch()) {
            return "";
        }

        // Fields to search
        $searchFlds = [];
        $searchFlds[] = &$this->Contact_No_1;
        $searchFlds[] = &$this->Contact_No_2;
        $searchFlds[] = &$this->Brand_Name;
        $searchFlds[] = &$this->Logo;
        $searchFlds[] = &$this->Favicon;
        $searchFlds[] = &$this->Address;
        $searchFlds[] = &$this->Facebook;
        $searchFlds[] = &$this->Twitter;
        $searchFlds[] = &$this->Instagram;
        $searchFlds[] = &$this->Map;
        $searchFlds[] = &$this->_Title;
        $searchFlds[] = &$this->Description;
        $searchFlds[] = &$this->Keywords;
        $searchFlds[] = &$this->Created_BY;
        $searchFlds[] = &$this->IP;
        $searchKeyword = $default ? $this->BasicSearch->KeywordDefault : $this->BasicSearch->Keyword;
        $searchType = $default ? $this->BasicSearch->TypeDefault : $this->BasicSearch->Type;

        // Get search SQL
        if ($searchKeyword != "") {
            $ar = $this->BasicSearch->keywordList($default);
            $searchStr = GetQuickSearchFilter($searchFlds, $ar, $searchType, Config("BASIC_SEARCH_ANY_FIELDS"), $this->Dbid);
            if (!$default && in_array($this->Command, ["", "reset", "resetall"])) {
                $this->Command = "search";
            }
        }
        if (!$default && $this->Command == "search") {
            $this->BasicSearch->setKeyword($searchKeyword);
            $this->BasicSearch->setType($searchType);
        }
        return $searchStr;
    }

    // Check if search parm exists
    protected function checkSearchParms()
    {
        // Check basic search
        if ($this->BasicSearch->issetSession()) {
            return true;
        }
        return false;
    }

    // Clear all search parameters
    protected function resetSearchParms()
    {
        // Clear search WHERE clause
        $this->SearchWhere = "";
        $this->setSearchWhere($this->SearchWhere);

        // Clear basic search parameters
        $this->resetBasicSearchParms();
    }

    // Load advanced search default values
    protected function loadAdvancedSearchDefault()
    {
        return false;
    }

    // Clear all basic search parameters
    protected function resetBasicSearchParms()
    {
        $this->BasicSearch->unsetSession();
    }

    // Restore all search parameters
    protected function restoreSearchParms()
    {
        $this->RestoreSearch = true;

        // Restore basic search values
        $this->BasicSearch->load();
    }

    // Set up sort parameters
    protected function setupSortOrder()
    {
        // Check for "order" parameter
        if (Get("order") !== null) {
            $this->CurrentOrder = Get("order");
            $this->CurrentOrderType = Get("ordertype", "");
            $this->updateSort($this->ID); // ID
            $this->updateSort($this->Contact_No_1); // Contact_No_1
            $this->updateSort($this->Contact_No_2); // Contact_No_2
            $this->updateSort($this->Brand_Name); // Brand_Name
            $this->updateSort($this->Logo); // Logo
            $this->updateSort($this->Favicon); // Favicon
            $this->updateSort($this->Facebook); // Facebook
            $this->updateSort($this->Twitter); // Twitter
            $this->updateSort($this->Instagram); // Instagram
            $this->updateSort($this->_Title); // Title
            $this->updateSort($this->Active); // Active
            $this->updateSort($this->Created_AT); // Created_AT
            $this->updateSort($this->Created_BY); // Created_BY
            $this->updateSort($this->IP); // IP
            $this->setStartRecordNumber(1); // Reset start position
        }
    }

    // Load sort order parameters
    protected function loadSortOrder()
    {
        $orderBy = $this->getSessionOrderBy(); // Get ORDER BY from Session
        if ($orderBy == "") {
            $this->DefaultSort = "`ID` DESC";
            if ($this->getSqlOrderBy() != "") {
                $useDefaultSort = true;
                if ($this->ID->getSort() != "") {
                    $useDefaultSort = false;
                }
                if ($useDefaultSort) {
                    $this->ID->setSort("DESC");
                    $orderBy = $this->getSqlOrderBy();
                    $this->setSessionOrderBy($orderBy);
                } else {
                    $this->setSessionOrderBy("");
                }
            }
        }
    }

    // Reset command
    // - cmd=reset (Reset search parameters)
    // - cmd=resetall (Reset search and master/detail parameters)
    // - cmd=resetsort (Reset sort parameters)
    protected function resetCmd()
    {
        // Check if reset command
        if (StartsString("reset", $this->Command)) {
            // Reset search criteria
            if ($this->Command == "reset" || $this->Command == "resetall") {
                $this->resetSearchParms();
            }

            // Reset (clear) sorting order
            if ($this->Command == "resetsort") {
                $orderBy = "";
                $this->setSessionOrderBy($orderBy);
                $this->ID->setSort("");
                $this->Contact_No_1->setSort("");
                $this->Contact_No_2->setSort("");
                $this->Brand_Name->setSort("");
                $this->Logo->setSort("");
                $this->Favicon->setSort("");
                $this->Address->setSort("");
                $this->Facebook->setSort("");
                $this->Twitter->setSort("");
                $this->Instagram->setSort("");
                $this->Map->setSort("");
                $this->_Title->setSort("");
                $this->Description->setSort("");
                $this->Keywords->setSort("");
                $this->Active->setSort("");
                $this->Created_AT->setSort("");
                $this->Created_BY->setSort("");
                $this->IP->setSort("");
            }

            // Reset start position
            $this->StartRecord = 1;
            $this->setStartRecordNumber($this->StartRecord);
        }
    }

    // Set up list options
    protected function setupListOptions()
    {
        global $Security, $Language;

        // "griddelete"
        if ($this->AllowAddDeleteRow) {
            $item = &$this->ListOptions->add("griddelete");
            $item->CssClass = "text-nowrap";
            $item->OnLeft = true;
            $item->Visible = false; // Default hidden
        }

        // Add group option item ("button")
        $item = &$this->ListOptions->addGroupOption();
        $item->Body = "";
        $item->OnLeft = true;
        $item->Visible = false;

        // "view"
        $item = &$this->ListOptions->add("view");
        $item->CssClass = "text-nowrap";
        $item->Visible = $Security->canView();
        $item->OnLeft = true;

        // "edit"
        $item = &$this->ListOptions->add("edit");
        $item->CssClass = "text-nowrap";
        $item->Visible = $Security->canEdit();
        $item->OnLeft = true;

        // "copy"
        $item = &$this->ListOptions->add("copy");
        $item->CssClass = "text-nowrap";
        $item->Visible = $Security->canAdd();
        $item->OnLeft = true;

        // "delete"
        $item = &$this->ListOptions->add("delete");
        $item->CssClass = "text-nowrap";
        $item->Visible = $Security->canDelete();
        $item->OnLeft = true;

        // List actions
        $item = &$this->ListOptions->add("listactions");
        $item->CssClass = "text-nowrap";
        $item->OnLeft = true;
        $item->Visible = false;
        $item->ShowInButtonGroup = false;
        $item->ShowInDropDown = false;

        // "checkbox"
        $item = &$this->ListOptions->add("checkbox");
        $item->Visible = false;
        $item->OnLeft = true;
        $item->Header = "<div class=\"form-check\"><input type=\"checkbox\" name=\"key\" id=\"key\" class=\"form-check-input\" data-ew-action=\"select-all-keys\"></div>";
        if ($item->OnLeft) {
            $item->moveTo(0);
        }
        $item->ShowInDropDown = false;
        $item->ShowInButtonGroup = false;

        // Drop down button for ListOptions
        $this->ListOptions->UseDropDownButton = false;
        $this->ListOptions->DropDownButtonPhrase = $Language->phrase("ButtonListOptions");
        $this->ListOptions->UseButtonGroup = false;
        if ($this->ListOptions->UseButtonGroup && IsMobile()) {
            $this->ListOptions->UseDropDownButton = true;
        }

        //$this->ListOptions->ButtonClass = ""; // Class for button group

        // Call ListOptions_Load event
        $this->listOptionsLoad();
        $this->setupListOptionsExt();
        $item = $this->ListOptions[$this->ListOptions->GroupOptionName];
        $item->Visible = $this->ListOptions->groupOptionVisible();
    }

    // Set up list options (extensions)
    protected function setupListOptionsExt()
    {
            // Set up list options (to be implemented by extensions)
    }

    // Render list options
    public function renderListOptions()
    {
        global $Security, $Language, $CurrentForm, $UserProfile;
        $this->ListOptions->loadDefault();

        // Call ListOptions_Rendering event
        $this->listOptionsRendering();

        // Set up row action and key
        if ($CurrentForm && is_numeric($this->RowIndex) && $this->RowType != "view") {
            $CurrentForm->Index = $this->RowIndex;
            $actionName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormActionName);
            $oldKeyName = str_replace("k_", "k" . $this->RowIndex . "_", $this->OldKeyName);
            $blankRowName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormBlankRowName);
            if ($this->RowAction != "") {
                $this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $actionName . "\" id=\"" . $actionName . "\" value=\"" . $this->RowAction . "\">";
            }
            $oldKey = $this->getKey(false); // Get from OldValue
            if ($oldKeyName != "" && $oldKey != "") {
                $this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $oldKeyName . "\" id=\"" . $oldKeyName . "\" value=\"" . HtmlEncode($oldKey) . "\">";
            }
            if ($this->RowAction == "insert" && $this->isConfirm() && $this->emptyRow()) {
                $this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $blankRowName . "\" id=\"" . $blankRowName . "\" value=\"1\">";
            }
        }

        // "delete"
        if ($this->AllowAddDeleteRow) {
            if ($this->isGridAdd() || $this->isGridEdit()) {
                $options = &$this->ListOptions;
                $options->UseButtonGroup = true; // Use button group for grid delete button
                $opt = $options["griddelete"];
                if (!$Security->canDelete() && is_numeric($this->RowIndex) && ($this->RowAction == "" || $this->RowAction == "edit")) { // Do not allow delete existing record
                    $opt->Body = "&nbsp;";
                } else {
                    $opt->Body = "<a class=\"ew-grid-link ew-grid-delete\" title=\"" . HtmlTitle($Language->phrase("DeleteLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("DeleteLink")) . "\" data-ew-action=\"delete-grid-row\" data-rowindex=\"" . $this->RowIndex . "\">" . $Language->phrase("DeleteLink") . "</a>";
                }
            }
        }
        $pageUrl = $this->pageUrl(false);
        if ($this->CurrentMode == "view") {
            // "view"
            $opt = $this->ListOptions["view"];
            $viewcaption = HtmlTitle($Language->phrase("ViewLink"));
            if ($Security->canView()) {
                $opt->Body = "<a class=\"ew-row-link ew-view\" title=\"" . $viewcaption . "\" data-caption=\"" . $viewcaption . "\" href=\"" . HtmlEncode(GetUrl($this->ViewUrl)) . "\">" . $Language->phrase("ViewLink") . "</a>";
            } else {
                $opt->Body = "";
            }

            // "edit"
            $opt = $this->ListOptions["edit"];
            $editcaption = HtmlTitle($Language->phrase("EditLink"));
            if ($Security->canEdit()) {
                $opt->Body = "<a class=\"ew-row-link ew-edit\" title=\"" . HtmlTitle($Language->phrase("EditLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("EditLink")) . "\" href=\"" . HtmlEncode(GetUrl($this->EditUrl)) . "\">" . $Language->phrase("EditLink") . "</a>";
            } else {
                $opt->Body = "";
            }

            // "copy"
            $opt = $this->ListOptions["copy"];
            $copycaption = HtmlTitle($Language->phrase("CopyLink"));
            if ($Security->canAdd()) {
                $opt->Body = "<a class=\"ew-row-link ew-copy\" title=\"" . $copycaption . "\" data-caption=\"" . $copycaption . "\" href=\"" . HtmlEncode(GetUrl($this->CopyUrl)) . "\">" . $Language->phrase("CopyLink") . "</a>";
            } else {
                $opt->Body = "";
            }

            // "delete"
            $opt = $this->ListOptions["delete"];
            if ($Security->canDelete()) {
                $opt->Body = "<a class=\"ew-row-link ew-delete\" data-ew-action=\"\" title=\"" . HtmlTitle($Language->phrase("DeleteLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("DeleteLink")) . "\" href=\"" . HtmlEncode(GetUrl($this->DeleteUrl)) . "\">" . $Language->phrase("DeleteLink") . "</a>";
            } else {
                $opt->Body = "";
            }
        } // End View mode

        // Set up list action buttons
        $opt = $this->ListOptions["listactions"];
        if ($opt && !$this->isExport() && !$this->CurrentAction) {
            $body = "";
            $links = [];
            foreach ($this->ListActions->Items as $listaction) {
                $action = $listaction->Action;
                $allowed = $listaction->Allow;
                if ($listaction->Select == ACTION_SINGLE && $allowed) {
                    $caption = $listaction->Caption;
                    $icon = ($listaction->Icon != "") ? "<i class=\"" . HtmlEncode(str_replace(" ew-icon", "", $listaction->Icon)) . "\" data-caption=\"" . HtmlTitle($caption) . "\"></i> " : "";
                    $link = "<li><button type=\"button\" class=\"dropdown-item ew-action ew-list-action\" data-caption=\"" . HtmlTitle($caption) . "\" data-ew-action=\"submit\" form=\"fsite_settingslist\" data-key=\"" . $this->keyToJson(true) . "\"" . $listaction->toDataAttrs() . ">" . $icon . $listaction->Caption . "</button></li>";
                    if ($link != "") {
                        $links[] = $link;
                        if ($body == "") { // Setup first button
                            $body = "<button type=\"button\" class=\"btn btn-default ew-action ew-list-action\" title=\"" . HtmlTitle($caption) . "\" data-caption=\"" . HtmlTitle($caption) . "\" data-ew-action=\"submit\" form=\"fsite_settingslist\" data-key=\"" . $this->keyToJson(true) . "\"" . $listaction->toDataAttrs() . ">" . $icon . $listaction->Caption . "</button>";
                        }
                    }
                }
            }
            if (count($links) > 1) { // More than one buttons, use dropdown
                $body = "<button class=\"dropdown-toggle btn btn-default ew-actions\" title=\"" . HtmlTitle($Language->phrase("ListActionButton")) . "\" data-bs-toggle=\"dropdown\">" . $Language->phrase("ListActionButton") . "</button>";
                $content = "";
                foreach ($links as $link) {
                    $content .= "<li>" . $link . "</li>";
                }
                $body .= "<ul class=\"dropdown-menu" . ($opt->OnLeft ? "" : " dropdown-menu-right") . "\">" . $content . "</ul>";
                $body = "<div class=\"btn-group btn-group-sm\">" . $body . "</div>";
            }
            if (count($links) > 0) {
                $opt->Body = $body;
            }
        }

        // "checkbox"
        $opt = $this->ListOptions["checkbox"];
        $opt->Body = "<div class=\"form-check\"><input type=\"checkbox\" id=\"key_m_" . $this->RowCount . "\" name=\"key_m[]\" class=\"form-check-input ew-multi-select\" value=\"" . HtmlEncode($this->ID->CurrentValue) . "\" data-ew-action=\"select-key\"></div>";
        $this->renderListOptionsExt();

        // Call ListOptions_Rendered event
        $this->listOptionsRendered();
    }

    // Render list options (extensions)
    protected function renderListOptionsExt()
    {
        // Render list options (to be implemented by extensions)
        global $Security, $Language;
    }

    // Set up other options
    protected function setupOtherOptions()
    {
        global $Language, $Security;
        $options = &$this->OtherOptions;
        $option = $options["addedit"];

        // Add
        $item = &$option->add("add");
        $addcaption = HtmlTitle($Language->phrase("AddLink"));
        $item->Body = "<a class=\"ew-add-edit ew-add\" title=\"" . $addcaption . "\" data-caption=\"" . $addcaption . "\" href=\"" . HtmlEncode(GetUrl($this->AddUrl)) . "\">" . $Language->phrase("AddLink") . "</a>";
        $item->Visible = $this->AddUrl != "" && $Security->canAdd();
        $item = &$option->add("gridadd");
        $item->Body = "<a class=\"ew-add-edit ew-grid-add\" title=\"" . HtmlTitle($Language->phrase("GridAddLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("GridAddLink")) . "\" href=\"" . HtmlEncode(GetUrl($this->GridAddUrl)) . "\">" . $Language->phrase("GridAddLink") . "</a>";
        $item->Visible = $this->GridAddUrl != "" && $Security->canAdd();

        // Add grid edit
        $option = $options["addedit"];
        $item = &$option->add("gridedit");
        $item->Body = "<a class=\"ew-add-edit ew-grid-edit\" title=\"" . HtmlTitle($Language->phrase("GridEditLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("GridEditLink")) . "\" href=\"" . HtmlEncode(GetUrl($this->GridEditUrl)) . "\">" . $Language->phrase("GridEditLink") . "</a>";
        $item->Visible = $this->GridEditUrl != "" && $Security->canEdit();
        $option = $options["action"];

        // Show column list for column visibility
        if ($this->UseColumnVisibility) {
            $option = $this->OtherOptions["column"];
            $item = &$option->addGroupOption();
            $item->Body = "";
            $item->Visible = $this->UseColumnVisibility;
            $option->add("ID", $this->createColumnOption("ID"));
            $option->add("Contact_No_1", $this->createColumnOption("Contact_No_1"));
            $option->add("Contact_No_2", $this->createColumnOption("Contact_No_2"));
            $option->add("Brand_Name", $this->createColumnOption("Brand_Name"));
            $option->add("Logo", $this->createColumnOption("Logo"));
            $option->add("Favicon", $this->createColumnOption("Favicon"));
            $option->add("Facebook", $this->createColumnOption("Facebook"));
            $option->add("Twitter", $this->createColumnOption("Twitter"));
            $option->add("Instagram", $this->createColumnOption("Instagram"));
            $option->add("Title", $this->createColumnOption("Title"));
            $option->add("Active", $this->createColumnOption("Active"));
            $option->add("Created_AT", $this->createColumnOption("Created_AT"));
            $option->add("Created_BY", $this->createColumnOption("Created_BY"));
            $option->add("IP", $this->createColumnOption("IP"));
        }

        // Set up options default
        foreach ($options as $name => $option) {
            if ($name != "column") { // Always use dropdown for column
                $option->UseDropDownButton = false;
                $option->UseButtonGroup = true;
            }
            //$option->ButtonClass = ""; // Class for button group
            $item = &$option->addGroupOption();
            $item->Body = "";
            $item->Visible = false;
        }
        $options["addedit"]->DropDownButtonPhrase = $Language->phrase("ButtonAddEdit");
        $options["detail"]->DropDownButtonPhrase = $Language->phrase("ButtonDetails");
        $options["action"]->DropDownButtonPhrase = $Language->phrase("ButtonActions");

        // Filter button
        $item = &$this->FilterOptions->add("savecurrentfilter");
        $item->Body = "<a class=\"ew-save-filter\" data-form=\"fsite_settingssrch\" data-ew-action=\"none\">" . $Language->phrase("SaveCurrentFilter") . "</a>";
        $item->Visible = true;
        $item = &$this->FilterOptions->add("deletefilter");
        $item->Body = "<a class=\"ew-delete-filter\" data-form=\"fsite_settingssrch\" data-ew-action=\"none\">" . $Language->phrase("DeleteFilter") . "</a>";
        $item->Visible = true;
        $this->FilterOptions->UseDropDownButton = true;
        $this->FilterOptions->UseButtonGroup = !$this->FilterOptions->UseDropDownButton;
        $this->FilterOptions->DropDownButtonPhrase = $Language->phrase("Filters");

        // Add group option item
        $item = &$this->FilterOptions->addGroupOption();
        $item->Body = "";
        $item->Visible = false;
    }

    // Create new column option
    public function createColumnOption($name)
    {
        $field = $this->Fields[$name] ?? false;
        if ($field && $field->Visible) {
            $item = new ListOption($field->Name);
            $item->Body = '<button class="dropdown-item">' .
                '<div class="form-check ew-dropdown-checkbox">' .
                '<div class="form-check-input ew-dropdown-check-input" data-field="' . $field->Param . '"></div>' .
                '<label class="form-check-label ew-dropdown-check-label">' . $field->caption() . '</label></div></button>';
            return $item;
        }
        return null;
    }

    // Render other options
    public function renderOtherOptions()
    {
        global $Language, $Security;
        $options = &$this->OtherOptions;
        if (!$this->isGridAdd() && !$this->isGridEdit()) { // Not grid add/edit mode
            $option = $options["action"];
            // Set up list action buttons
            foreach ($this->ListActions->Items as $listaction) {
                if ($listaction->Select == ACTION_MULTIPLE) {
                    $item = &$option->add("custom_" . $listaction->Action);
                    $caption = $listaction->Caption;
                    $icon = ($listaction->Icon != "") ? '<i class="' . HtmlEncode($listaction->Icon) . '" data-caption="' . HtmlEncode($caption) . '"></i>' . $caption : $caption;
                    $item->Body = '<button type="button" class="btn btn-default ew-action ew-list-action" title="' . HtmlEncode($caption) . '" data-caption="' . HtmlEncode($caption) . '" data-ew-action="submit" form="fsite_settingslist"' . $listaction->toDataAttrs() . '>' . $icon . '</button>';
                    $item->Visible = $listaction->Allow;
                }
            }

            // Hide grid edit and other options
            if ($this->TotalRecords <= 0) {
                $option = $options["addedit"];
                $item = $option["gridedit"];
                if ($item) {
                    $item->Visible = false;
                }
                $option = $options["action"];
                $option->hideAllOptions();
            }
        } else { // Grid add/edit mode
            // Hide all options first
            foreach ($options as $option) {
                $option->hideAllOptions();
            }
            $pageUrl = $this->pageUrl(false);

            // Grid-Add
            if ($this->isGridAdd()) {
                    if ($this->AllowAddDeleteRow) {
                        // Add add blank row
                        $option = $options["addedit"];
                        $option->UseDropDownButton = false;
                        $item = &$option->add("addblankrow");
                        $item->Body = "<a type=\"button\" class=\"ew-add-edit ew-add-blank-row\" title=\"" . HtmlTitle($Language->phrase("AddBlankRow")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("AddBlankRow")) . "\" data-ew-action=\"add-grid-row\">" . $Language->phrase("AddBlankRow") . "</a>";
                        $item->Visible = $Security->canAdd();
                    }
                $option = $options["action"];
                $option->UseDropDownButton = false;
                // Add grid insert
                $item = &$option->add("gridinsert");
                $item->Body = "<button class=\"ew-action ew-grid-insert\" title=\"" . HtmlTitle($Language->phrase("GridInsertLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("GridInsertLink")) . "\" form=\"fsite_settingslist\" formaction=\"" . GetUrl($this->pageName()) . "\">" . $Language->phrase("GridInsertLink") . "</button>";
                // Add grid cancel
                $item = &$option->add("gridcancel");
                $cancelurl = $this->addMasterUrl($pageUrl . "action=cancel");
                $item->Body = "<a type=\"button\" class=\"ew-action ew-grid-cancel\" title=\"" . HtmlTitle($Language->phrase("GridCancelLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("GridCancelLink")) . "\" href=\"" . $cancelurl . "\">" . $Language->phrase("GridCancelLink") . "</a>";
            }

            // Grid-Edit
            if ($this->isGridEdit()) {
                if ($this->AllowAddDeleteRow) {
                    // Add add blank row
                    $option = $options["addedit"];
                    $option->UseDropDownButton = false;
                    $item = &$option->add("addblankrow");
                    $item->Body = "<button class=\"ew-add-edit ew-add-blank-row\" title=\"" . HtmlTitle($Language->phrase("AddBlankRow")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("AddBlankRow")) . "\" data-ew-action=\"add-grid-row\">" . $Language->phrase("AddBlankRow") . "</button>";
                    $item->Visible = $Security->canAdd();
                }
                $option = $options["action"];
                $option->UseDropDownButton = false;
                    $item = &$option->add("gridsave");
                    $item->Body = "<button class=\"ew-action ew-grid-save\" title=\"" . HtmlTitle($Language->phrase("GridSaveLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("GridSaveLink")) . "\" form=\"fsite_settingslist\" formaction=\"" . GetUrl($this->pageName()) . "\">" . $Language->phrase("GridSaveLink") . "</button>";
                    $item = &$option->add("gridcancel");
                    $cancelurl = $this->addMasterUrl($pageUrl . "action=cancel");
                    $item->Body = "<a class=\"ew-action ew-grid-cancel\" title=\"" . HtmlTitle($Language->phrase("GridCancelLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("GridCancelLink")) . "\" href=\"" . $cancelurl . "\">" . $Language->phrase("GridCancelLink") . "</a>";
            }
        }
    }

    // Process list action
    protected function processListAction()
    {
        global $Language, $Security, $Response;
        $userlist = "";
        $user = "";
        $filter = $this->getFilterFromRecordKeys();
        $userAction = Post("useraction", "");
        if ($filter != "" && $userAction != "") {
            // Check permission first
            $actionCaption = $userAction;
            if (array_key_exists($userAction, $this->ListActions->Items)) {
                $actionCaption = $this->ListActions[$userAction]->Caption;
                if (!$this->ListActions[$userAction]->Allow) {
                    $errmsg = str_replace('%s', $actionCaption, $Language->phrase("CustomActionNotAllowed"));
                    if (Post("ajax") == $userAction) { // Ajax
                        echo "<p class=\"text-danger\">" . $errmsg . "</p>";
                        return true;
                    } else {
                        $this->setFailureMessage($errmsg);
                        return false;
                    }
                }
            }
            $this->CurrentFilter = $filter;
            $sql = $this->getCurrentSql();
            $conn = $this->getConnection();
            $rs = LoadRecordset($sql, $conn);
            $this->UserAction = $userAction;
            $this->ActionValue = Post("actionvalue");

            // Call row action event
            if ($rs) {
                if ($this->UseTransaction) {
                    $conn->beginTransaction();
                }
                $this->SelectedCount = $rs->recordCount();
                $this->SelectedIndex = 0;
                while (!$rs->EOF) {
                    $this->SelectedIndex++;
                    $row = $rs->fields;
                    $processed = $this->rowCustomAction($userAction, $row);
                    if (!$processed) {
                        break;
                    }
                    $rs->moveNext();
                }
                if ($processed) {
                    if ($this->UseTransaction) { // Commit transaction
                        $conn->commit();
                    }
                    if ($this->getSuccessMessage() == "" && !ob_get_length() && !$Response->getBody()->getSize()) { // No output
                        $this->setSuccessMessage(str_replace('%s', $actionCaption, $Language->phrase("CustomActionCompleted"))); // Set up success message
                    }
                } else {
                    if ($this->UseTransaction) { // Rollback transaction
                        $conn->rollback();
                    }

                    // Set up error message
                    if ($this->getSuccessMessage() != "" || $this->getFailureMessage() != "") {
                        // Use the message, do nothing
                    } elseif ($this->CancelMessage != "") {
                        $this->setFailureMessage($this->CancelMessage);
                        $this->CancelMessage = "";
                    } else {
                        $this->setFailureMessage(str_replace('%s', $actionCaption, $Language->phrase("CustomActionFailed")));
                    }
                }
            }
            if ($rs) {
                $rs->close();
            }
            if (Post("ajax") == $userAction) { // Ajax
                if ($this->getSuccessMessage() != "") {
                    echo "<p class=\"text-success\">" . $this->getSuccessMessage() . "</p>";
                    $this->clearSuccessMessage(); // Clear message
                }
                if ($this->getFailureMessage() != "") {
                    echo "<p class=\"text-danger\">" . $this->getFailureMessage() . "</p>";
                    $this->clearFailureMessage(); // Clear message
                }
                return true;
            }
        }
        return false; // Not ajax request
    }

    // Get upload files
    protected function getUploadFiles()
    {
        global $CurrentForm, $Language;
        $this->Logo->Upload->Index = $CurrentForm->Index;
        $this->Logo->Upload->uploadFile();
        $this->Logo->CurrentValue = $this->Logo->Upload->FileName;
        $this->Favicon->Upload->Index = $CurrentForm->Index;
        $this->Favicon->Upload->uploadFile();
        $this->Favicon->CurrentValue = $this->Favicon->Upload->FileName;
    }

    // Load default values
    protected function loadDefaultValues()
    {
        $this->ID->CurrentValue = null;
        $this->ID->OldValue = $this->ID->CurrentValue;
        $this->Contact_No_1->CurrentValue = null;
        $this->Contact_No_1->OldValue = $this->Contact_No_1->CurrentValue;
        $this->Contact_No_2->CurrentValue = null;
        $this->Contact_No_2->OldValue = $this->Contact_No_2->CurrentValue;
        $this->Brand_Name->CurrentValue = null;
        $this->Brand_Name->OldValue = $this->Brand_Name->CurrentValue;
        $this->Logo->Upload->DbValue = null;
        $this->Logo->OldValue = $this->Logo->Upload->DbValue;
        $this->Favicon->Upload->DbValue = null;
        $this->Favicon->OldValue = $this->Favicon->Upload->DbValue;
        $this->Address->CurrentValue = null;
        $this->Address->OldValue = $this->Address->CurrentValue;
        $this->Facebook->CurrentValue = null;
        $this->Facebook->OldValue = $this->Facebook->CurrentValue;
        $this->Twitter->CurrentValue = null;
        $this->Twitter->OldValue = $this->Twitter->CurrentValue;
        $this->Instagram->CurrentValue = null;
        $this->Instagram->OldValue = $this->Instagram->CurrentValue;
        $this->Map->CurrentValue = null;
        $this->Map->OldValue = $this->Map->CurrentValue;
        $this->_Title->CurrentValue = null;
        $this->_Title->OldValue = $this->_Title->CurrentValue;
        $this->Description->CurrentValue = null;
        $this->Description->OldValue = $this->Description->CurrentValue;
        $this->Keywords->CurrentValue = null;
        $this->Keywords->OldValue = $this->Keywords->CurrentValue;
        $this->Active->CurrentValue = null;
        $this->Active->OldValue = $this->Active->CurrentValue;
        $this->Created_AT->CurrentValue = null;
        $this->Created_AT->OldValue = $this->Created_AT->CurrentValue;
        $this->Created_BY->CurrentValue = null;
        $this->Created_BY->OldValue = $this->Created_BY->CurrentValue;
        $this->IP->CurrentValue = null;
        $this->IP->OldValue = $this->IP->CurrentValue;
    }

    // Load basic search values
    protected function loadBasicSearchValues()
    {
        $this->BasicSearch->setKeyword(Get(Config("TABLE_BASIC_SEARCH"), ""), false);
        if ($this->BasicSearch->Keyword != "" && $this->Command == "") {
            $this->Command = "search";
        }
        $this->BasicSearch->setType(Get(Config("TABLE_BASIC_SEARCH_TYPE"), ""), false);
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;
        $validate = !Config("SERVER_VALIDATE");

        // Check field name 'ID' first before field var 'x_ID'
        $val = $CurrentForm->hasValue("ID") ? $CurrentForm->getValue("ID") : $CurrentForm->getValue("x_ID");
        if (!$this->ID->IsDetailKey && !$this->isGridAdd() && !$this->isAdd()) {
            $this->ID->setFormValue($val);
        }

        // Check field name 'Contact_No_1' first before field var 'x_Contact_No_1'
        $val = $CurrentForm->hasValue("Contact_No_1") ? $CurrentForm->getValue("Contact_No_1") : $CurrentForm->getValue("x_Contact_No_1");
        if (!$this->Contact_No_1->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Contact_No_1->Visible = false; // Disable update for API request
            } else {
                $this->Contact_No_1->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_Contact_No_1")) {
            $this->Contact_No_1->setOldValue($CurrentForm->getValue("o_Contact_No_1"));
        }

        // Check field name 'Contact_No_2' first before field var 'x_Contact_No_2'
        $val = $CurrentForm->hasValue("Contact_No_2") ? $CurrentForm->getValue("Contact_No_2") : $CurrentForm->getValue("x_Contact_No_2");
        if (!$this->Contact_No_2->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Contact_No_2->Visible = false; // Disable update for API request
            } else {
                $this->Contact_No_2->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_Contact_No_2")) {
            $this->Contact_No_2->setOldValue($CurrentForm->getValue("o_Contact_No_2"));
        }

        // Check field name 'Brand_Name' first before field var 'x_Brand_Name'
        $val = $CurrentForm->hasValue("Brand_Name") ? $CurrentForm->getValue("Brand_Name") : $CurrentForm->getValue("x_Brand_Name");
        if (!$this->Brand_Name->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Brand_Name->Visible = false; // Disable update for API request
            } else {
                $this->Brand_Name->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_Brand_Name")) {
            $this->Brand_Name->setOldValue($CurrentForm->getValue("o_Brand_Name"));
        }

        // Check field name 'Facebook' first before field var 'x_Facebook'
        $val = $CurrentForm->hasValue("Facebook") ? $CurrentForm->getValue("Facebook") : $CurrentForm->getValue("x_Facebook");
        if (!$this->Facebook->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Facebook->Visible = false; // Disable update for API request
            } else {
                $this->Facebook->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_Facebook")) {
            $this->Facebook->setOldValue($CurrentForm->getValue("o_Facebook"));
        }

        // Check field name 'Twitter' first before field var 'x_Twitter'
        $val = $CurrentForm->hasValue("Twitter") ? $CurrentForm->getValue("Twitter") : $CurrentForm->getValue("x_Twitter");
        if (!$this->Twitter->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Twitter->Visible = false; // Disable update for API request
            } else {
                $this->Twitter->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_Twitter")) {
            $this->Twitter->setOldValue($CurrentForm->getValue("o_Twitter"));
        }

        // Check field name 'Instagram' first before field var 'x_Instagram'
        $val = $CurrentForm->hasValue("Instagram") ? $CurrentForm->getValue("Instagram") : $CurrentForm->getValue("x_Instagram");
        if (!$this->Instagram->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Instagram->Visible = false; // Disable update for API request
            } else {
                $this->Instagram->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_Instagram")) {
            $this->Instagram->setOldValue($CurrentForm->getValue("o_Instagram"));
        }

        // Check field name 'Title' first before field var 'x__Title'
        $val = $CurrentForm->hasValue("Title") ? $CurrentForm->getValue("Title") : $CurrentForm->getValue("x__Title");
        if (!$this->_Title->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->_Title->Visible = false; // Disable update for API request
            } else {
                $this->_Title->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o__Title")) {
            $this->_Title->setOldValue($CurrentForm->getValue("o__Title"));
        }

        // Check field name 'Active' first before field var 'x_Active'
        $val = $CurrentForm->hasValue("Active") ? $CurrentForm->getValue("Active") : $CurrentForm->getValue("x_Active");
        if (!$this->Active->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Active->Visible = false; // Disable update for API request
            } else {
                $this->Active->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_Active")) {
            $this->Active->setOldValue($CurrentForm->getValue("o_Active"));
        }

        // Check field name 'Created_AT' first before field var 'x_Created_AT'
        $val = $CurrentForm->hasValue("Created_AT") ? $CurrentForm->getValue("Created_AT") : $CurrentForm->getValue("x_Created_AT");
        if (!$this->Created_AT->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Created_AT->Visible = false; // Disable update for API request
            } else {
                $this->Created_AT->setFormValue($val);
            }
            $this->Created_AT->CurrentValue = UnFormatDateTime($this->Created_AT->CurrentValue, $this->Created_AT->formatPattern());
        }
        if ($CurrentForm->hasValue("o_Created_AT")) {
            $this->Created_AT->setOldValue($CurrentForm->getValue("o_Created_AT"));
        }

        // Check field name 'Created_BY' first before field var 'x_Created_BY'
        $val = $CurrentForm->hasValue("Created_BY") ? $CurrentForm->getValue("Created_BY") : $CurrentForm->getValue("x_Created_BY");
        if (!$this->Created_BY->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Created_BY->Visible = false; // Disable update for API request
            } else {
                $this->Created_BY->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_Created_BY")) {
            $this->Created_BY->setOldValue($CurrentForm->getValue("o_Created_BY"));
        }

        // Check field name 'IP' first before field var 'x_IP'
        $val = $CurrentForm->hasValue("IP") ? $CurrentForm->getValue("IP") : $CurrentForm->getValue("x_IP");
        if (!$this->IP->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->IP->Visible = false; // Disable update for API request
            } else {
                $this->IP->setFormValue($val);
            }
        }
        if ($CurrentForm->hasValue("o_IP")) {
            $this->IP->setOldValue($CurrentForm->getValue("o_IP"));
        }
		$this->Logo->OldUploadPath = "files/";
		$this->Logo->UploadPath = $this->Logo->OldUploadPath;
		$this->Favicon->OldUploadPath = "files/";
		$this->Favicon->UploadPath = $this->Favicon->OldUploadPath;
        $this->getUploadFiles(); // Get upload files
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        if (!$this->isGridAdd() && !$this->isAdd()) {
            $this->ID->CurrentValue = $this->ID->FormValue;
        }
        $this->Contact_No_1->CurrentValue = $this->Contact_No_1->FormValue;
        $this->Contact_No_2->CurrentValue = $this->Contact_No_2->FormValue;
        $this->Brand_Name->CurrentValue = $this->Brand_Name->FormValue;
        $this->Facebook->CurrentValue = $this->Facebook->FormValue;
        $this->Twitter->CurrentValue = $this->Twitter->FormValue;
        $this->Instagram->CurrentValue = $this->Instagram->FormValue;
        $this->_Title->CurrentValue = $this->_Title->FormValue;
        $this->Active->CurrentValue = $this->Active->FormValue;
        $this->Created_AT->CurrentValue = $this->Created_AT->FormValue;
        $this->Created_AT->CurrentValue = UnFormatDateTime($this->Created_AT->CurrentValue, $this->Created_AT->formatPattern());
        $this->Created_BY->CurrentValue = $this->Created_BY->FormValue;
        $this->IP->CurrentValue = $this->IP->FormValue;
    }

    // Load recordset
    public function loadRecordset($offset = -1, $rowcnt = -1)
    {
        // Load List page SQL (QueryBuilder)
        $sql = $this->getListSql();

        // Load recordset
        if ($offset > -1) {
            $sql->setFirstResult($offset);
        }
        if ($rowcnt > 0) {
            $sql->setMaxResults($rowcnt);
        }
        $result = $sql->execute();
        $rs = new Recordset($result, $sql);

        // Call Recordset Selected event
        $this->recordsetSelected($rs);
        return $rs;
    }

    // Load records as associative array
    public function loadRows($offset = -1, $rowcnt = -1)
    {
        // Load List page SQL (QueryBuilder)
        $sql = $this->getListSql();

        // Load recordset
        if ($offset > -1) {
            $sql->setFirstResult($offset);
        }
        if ($rowcnt > 0) {
            $sql->setMaxResults($rowcnt);
        }
        $result = $sql->execute();
        return $result->fetchAll(FetchMode::ASSOCIATIVE);
    }

    /**
     * Load row based on key values
     *
     * @return void
     */
    public function loadRow()
    {
        global $Security, $Language;
        $filter = $this->getRecordFilter();

        // Call Row Selecting event
        $this->rowSelecting($filter);

        // Load SQL based on filter
        $this->CurrentFilter = $filter;
        $sql = $this->getCurrentSql();
        $conn = $this->getConnection();
        $res = false;
        $row = $conn->fetchAssociative($sql);
        if ($row) {
            $res = true;
            $this->loadRowValues($row); // Load row values
            if (!$this->EventCancelled) {
                $this->HashValue = $this->getRowHash($row); // Get hash value for record
            }
        }
        return $res;
    }

    /**
     * Load row values from recordset or record
     *
     * @param Recordset|array $rs Record
     * @return void
     */
    public function loadRowValues($rs = null)
    {
        if (is_array($rs)) {
            $row = $rs;
        } elseif ($rs && property_exists($rs, "fields")) { // Recordset
            $row = $rs->fields;
        } else {
            $row = $this->newRow();
        }
        if (!$row) {
            return;
        }

        // Call Row Selected event
        $this->rowSelected($row);
        $this->ID->setDbValue($row['ID']);
        $this->Contact_No_1->setDbValue($row['Contact_No_1']);
        $this->Contact_No_2->setDbValue($row['Contact_No_2']);
        $this->Brand_Name->setDbValue($row['Brand_Name']);
        $this->Logo->Upload->DbValue = $row['Logo'];
        $this->Logo->setDbValue($this->Logo->Upload->DbValue);
        $this->Favicon->Upload->DbValue = $row['Favicon'];
        $this->Favicon->setDbValue($this->Favicon->Upload->DbValue);
        $this->Address->setDbValue($row['Address']);
        $this->Facebook->setDbValue($row['Facebook']);
        $this->Twitter->setDbValue($row['Twitter']);
        $this->Instagram->setDbValue($row['Instagram']);
        $this->Map->setDbValue($row['Map']);
        $this->_Title->setDbValue($row['Title']);
        $this->Description->setDbValue($row['Description']);
        $this->Keywords->setDbValue($row['Keywords']);
        $this->Active->setDbValue($row['Active']);
        $this->Created_AT->setDbValue($row['Created_AT']);
        $this->Created_BY->setDbValue($row['Created_BY']);
        $this->IP->setDbValue($row['IP']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $this->loadDefaultValues();
        $row = [];
        $row['ID'] = $this->ID->CurrentValue;
        $row['Contact_No_1'] = $this->Contact_No_1->CurrentValue;
        $row['Contact_No_2'] = $this->Contact_No_2->CurrentValue;
        $row['Brand_Name'] = $this->Brand_Name->CurrentValue;
        $row['Logo'] = $this->Logo->Upload->DbValue;
        $row['Favicon'] = $this->Favicon->Upload->DbValue;
        $row['Address'] = $this->Address->CurrentValue;
        $row['Facebook'] = $this->Facebook->CurrentValue;
        $row['Twitter'] = $this->Twitter->CurrentValue;
        $row['Instagram'] = $this->Instagram->CurrentValue;
        $row['Map'] = $this->Map->CurrentValue;
        $row['Title'] = $this->_Title->CurrentValue;
        $row['Description'] = $this->Description->CurrentValue;
        $row['Keywords'] = $this->Keywords->CurrentValue;
        $row['Active'] = $this->Active->CurrentValue;
        $row['Created_AT'] = $this->Created_AT->CurrentValue;
        $row['Created_BY'] = $this->Created_BY->CurrentValue;
        $row['IP'] = $this->IP->CurrentValue;
        return $row;
    }

    // Load old record
    protected function loadOldRecord()
    {
        // Load old record
        $this->OldRecordset = null;
        $validKey = $this->OldKey != "";
        if ($validKey) {
            $this->CurrentFilter = $this->getRecordFilter();
            $sql = $this->getCurrentSql();
            $conn = $this->getConnection();
            $this->OldRecordset = LoadRecordset($sql, $conn);
        }
        $this->loadRowValues($this->OldRecordset); // Load row values
        return $validKey;
    }

    // Render row values based on field settings
    public function renderRow()
    {
        global $Security, $Language, $CurrentLanguage;

        // Initialize URLs
        $this->ViewUrl = $this->getViewUrl();
        $this->EditUrl = $this->getEditUrl();
        $this->InlineEditUrl = $this->getInlineEditUrl();
        $this->CopyUrl = $this->getCopyUrl();
        $this->InlineCopyUrl = $this->getInlineCopyUrl();
        $this->DeleteUrl = $this->getDeleteUrl();

        // Call Row_Rendering event
        $this->rowRendering();

        // Common render codes for all row types

        // ID

        // Contact_No_1

        // Contact_No_2

        // Brand_Name

        // Logo

        // Favicon

        // Address

        // Facebook

        // Twitter

        // Instagram

        // Map

        // Title

        // Description

        // Keywords

        // Active

        // Created_AT

        // Created_BY

        // IP

        // View row
        if ($this->RowType == ROWTYPE_VIEW) {
            // ID
            $this->ID->ViewValue = $this->ID->CurrentValue;
            $this->ID->ViewCustomAttributes = "";

            // Contact_No_1
            $this->Contact_No_1->ViewValue = $this->Contact_No_1->CurrentValue;
            $this->Contact_No_1->ViewCustomAttributes = "";

            // Contact_No_2
            $this->Contact_No_2->ViewValue = $this->Contact_No_2->CurrentValue;
            $this->Contact_No_2->ViewCustomAttributes = "";

            // Brand_Name
            $this->Brand_Name->ViewValue = $this->Brand_Name->CurrentValue;
            $this->Brand_Name->ViewCustomAttributes = "";

            // Logo
            $this->Logo->UploadPath = "files/";
            if (!EmptyValue($this->Logo->Upload->DbValue)) {
                $this->Logo->ViewValue = $this->Logo->Upload->DbValue;
            } else {
                $this->Logo->ViewValue = "";
            }
            $this->Logo->ViewCustomAttributes = "";

            // Favicon
            $this->Favicon->UploadPath = "files/";
            if (!EmptyValue($this->Favicon->Upload->DbValue)) {
                $this->Favicon->ViewValue = $this->Favicon->Upload->DbValue;
            } else {
                $this->Favicon->ViewValue = "";
            }
            $this->Favicon->ViewCustomAttributes = "";

            // Facebook
            $this->Facebook->ViewValue = $this->Facebook->CurrentValue;
            $this->Facebook->ViewCustomAttributes = "";

            // Twitter
            $this->Twitter->ViewValue = $this->Twitter->CurrentValue;
            $this->Twitter->ViewCustomAttributes = "";

            // Instagram
            $this->Instagram->ViewValue = $this->Instagram->CurrentValue;
            $this->Instagram->ViewCustomAttributes = "";

            // Title
            $this->_Title->ViewValue = $this->_Title->CurrentValue;
            $this->_Title->ViewCustomAttributes = "";

            // Active
            if (ConvertToBool($this->Active->CurrentValue)) {
                $this->Active->ViewValue = $this->Active->tagCaption(1) != "" ? $this->Active->tagCaption(1) : "Active";
            } else {
                $this->Active->ViewValue = $this->Active->tagCaption(2) != "" ? $this->Active->tagCaption(2) : "Suspend";
            }
            $this->Active->ViewCustomAttributes = "";

            // Created_AT
            $this->Created_AT->ViewValue = $this->Created_AT->CurrentValue;
            $this->Created_AT->ViewValue = FormatDateTime($this->Created_AT->ViewValue, $this->Created_AT->formatPattern());
            $this->Created_AT->ViewCustomAttributes = "";

            // Created_BY
            $this->Created_BY->ViewValue = $this->Created_BY->CurrentValue;
            $this->Created_BY->ViewCustomAttributes = "";

            // IP
            $this->IP->ViewValue = $this->IP->CurrentValue;
            $this->IP->ViewCustomAttributes = "";

            // ID
            $this->ID->LinkCustomAttributes = "";
            $this->ID->HrefValue = "";
            $this->ID->TooltipValue = "";

            // Contact_No_1
            $this->Contact_No_1->LinkCustomAttributes = "";
            $this->Contact_No_1->HrefValue = "";
            $this->Contact_No_1->TooltipValue = "";

            // Contact_No_2
            $this->Contact_No_2->LinkCustomAttributes = "";
            $this->Contact_No_2->HrefValue = "";
            $this->Contact_No_2->TooltipValue = "";

            // Brand_Name
            $this->Brand_Name->LinkCustomAttributes = "";
            $this->Brand_Name->HrefValue = "";
            $this->Brand_Name->TooltipValue = "";

            // Logo
            $this->Logo->LinkCustomAttributes = "";
            $this->Logo->HrefValue = "";
            $this->Logo->ExportHrefValue = $this->Logo->UploadPath . $this->Logo->Upload->DbValue;
            $this->Logo->TooltipValue = "";

            // Favicon
            $this->Favicon->LinkCustomAttributes = "";
            $this->Favicon->HrefValue = "";
            $this->Favicon->ExportHrefValue = $this->Favicon->UploadPath . $this->Favicon->Upload->DbValue;
            $this->Favicon->TooltipValue = "";

            // Facebook
            $this->Facebook->LinkCustomAttributes = "";
            $this->Facebook->HrefValue = "";
            $this->Facebook->TooltipValue = "";

            // Twitter
            $this->Twitter->LinkCustomAttributes = "";
            $this->Twitter->HrefValue = "";
            $this->Twitter->TooltipValue = "";

            // Instagram
            $this->Instagram->LinkCustomAttributes = "";
            $this->Instagram->HrefValue = "";
            $this->Instagram->TooltipValue = "";

            // Title
            $this->_Title->LinkCustomAttributes = "";
            $this->_Title->HrefValue = "";
            $this->_Title->TooltipValue = "";

            // Active
            $this->Active->LinkCustomAttributes = "";
            $this->Active->HrefValue = "";
            $this->Active->TooltipValue = "";

            // Created_AT
            $this->Created_AT->LinkCustomAttributes = "";
            $this->Created_AT->HrefValue = "";
            $this->Created_AT->TooltipValue = "";

            // Created_BY
            $this->Created_BY->LinkCustomAttributes = "";
            $this->Created_BY->HrefValue = "";
            $this->Created_BY->TooltipValue = "";

            // IP
            $this->IP->LinkCustomAttributes = "";
            $this->IP->HrefValue = "";
            $this->IP->TooltipValue = "";
        } elseif ($this->RowType == ROWTYPE_ADD) {
            // ID

            // Contact_No_1
            $this->Contact_No_1->setupEditAttributes();
            $this->Contact_No_1->EditCustomAttributes = "";
            if (!$this->Contact_No_1->Raw) {
                $this->Contact_No_1->CurrentValue = HtmlDecode($this->Contact_No_1->CurrentValue);
            }
            $this->Contact_No_1->EditValue = HtmlEncode($this->Contact_No_1->CurrentValue);
            $this->Contact_No_1->PlaceHolder = RemoveHtml($this->Contact_No_1->caption());

            // Contact_No_2
            $this->Contact_No_2->setupEditAttributes();
            $this->Contact_No_2->EditCustomAttributes = "";
            if (!$this->Contact_No_2->Raw) {
                $this->Contact_No_2->CurrentValue = HtmlDecode($this->Contact_No_2->CurrentValue);
            }
            $this->Contact_No_2->EditValue = HtmlEncode($this->Contact_No_2->CurrentValue);
            $this->Contact_No_2->PlaceHolder = RemoveHtml($this->Contact_No_2->caption());

            // Brand_Name
            $this->Brand_Name->setupEditAttributes();
            $this->Brand_Name->EditCustomAttributes = "";
            if (!$this->Brand_Name->Raw) {
                $this->Brand_Name->CurrentValue = HtmlDecode($this->Brand_Name->CurrentValue);
            }
            $this->Brand_Name->EditValue = HtmlEncode($this->Brand_Name->CurrentValue);
            $this->Brand_Name->PlaceHolder = RemoveHtml($this->Brand_Name->caption());

            // Logo
            $this->Logo->setupEditAttributes();
            $this->Logo->EditCustomAttributes = "";
            $this->Logo->UploadPath = "files/";
            if (!EmptyValue($this->Logo->Upload->DbValue)) {
                $this->Logo->EditValue = $this->Logo->Upload->DbValue;
            } else {
                $this->Logo->EditValue = "";
            }
            if (!EmptyValue($this->Logo->CurrentValue)) {
                if ($this->RowIndex == '$rowindex$') {
                    $this->Logo->Upload->FileName = "";
                } else {
                    $this->Logo->Upload->FileName = $this->Logo->CurrentValue;
                }
            }
            if (is_numeric($this->RowIndex)) {
                RenderUploadField($this->Logo, $this->RowIndex);
            }

            // Favicon
            $this->Favicon->setupEditAttributes();
            $this->Favicon->EditCustomAttributes = "";
            $this->Favicon->UploadPath = "files/";
            if (!EmptyValue($this->Favicon->Upload->DbValue)) {
                $this->Favicon->EditValue = $this->Favicon->Upload->DbValue;
            } else {
                $this->Favicon->EditValue = "";
            }
            if (!EmptyValue($this->Favicon->CurrentValue)) {
                if ($this->RowIndex == '$rowindex$') {
                    $this->Favicon->Upload->FileName = "";
                } else {
                    $this->Favicon->Upload->FileName = $this->Favicon->CurrentValue;
                }
            }
            if (is_numeric($this->RowIndex)) {
                RenderUploadField($this->Favicon, $this->RowIndex);
            }

            // Facebook
            $this->Facebook->setupEditAttributes();
            $this->Facebook->EditCustomAttributes = "";
            if (!$this->Facebook->Raw) {
                $this->Facebook->CurrentValue = HtmlDecode($this->Facebook->CurrentValue);
            }
            $this->Facebook->EditValue = HtmlEncode($this->Facebook->CurrentValue);
            $this->Facebook->PlaceHolder = RemoveHtml($this->Facebook->caption());

            // Twitter
            $this->Twitter->setupEditAttributes();
            $this->Twitter->EditCustomAttributes = "";
            if (!$this->Twitter->Raw) {
                $this->Twitter->CurrentValue = HtmlDecode($this->Twitter->CurrentValue);
            }
            $this->Twitter->EditValue = HtmlEncode($this->Twitter->CurrentValue);
            $this->Twitter->PlaceHolder = RemoveHtml($this->Twitter->caption());

            // Instagram
            $this->Instagram->setupEditAttributes();
            $this->Instagram->EditCustomAttributes = "";
            if (!$this->Instagram->Raw) {
                $this->Instagram->CurrentValue = HtmlDecode($this->Instagram->CurrentValue);
            }
            $this->Instagram->EditValue = HtmlEncode($this->Instagram->CurrentValue);
            $this->Instagram->PlaceHolder = RemoveHtml($this->Instagram->caption());

            // Title
            $this->_Title->setupEditAttributes();
            $this->_Title->EditCustomAttributes = "";
            if (!$this->_Title->Raw) {
                $this->_Title->CurrentValue = HtmlDecode($this->_Title->CurrentValue);
            }
            $this->_Title->EditValue = HtmlEncode($this->_Title->CurrentValue);
            $this->_Title->PlaceHolder = RemoveHtml($this->_Title->caption());

            // Active
            $this->Active->EditCustomAttributes = "";
            $this->Active->EditValue = $this->Active->options(false);
            $this->Active->PlaceHolder = RemoveHtml($this->Active->caption());

            // Created_AT

            // Created_BY

            // IP

            // Add refer script

            // ID
            $this->ID->LinkCustomAttributes = "";
            $this->ID->HrefValue = "";

            // Contact_No_1
            $this->Contact_No_1->LinkCustomAttributes = "";
            $this->Contact_No_1->HrefValue = "";

            // Contact_No_2
            $this->Contact_No_2->LinkCustomAttributes = "";
            $this->Contact_No_2->HrefValue = "";

            // Brand_Name
            $this->Brand_Name->LinkCustomAttributes = "";
            $this->Brand_Name->HrefValue = "";

            // Logo
            $this->Logo->LinkCustomAttributes = "";
            $this->Logo->HrefValue = "";
            $this->Logo->ExportHrefValue = $this->Logo->UploadPath . $this->Logo->Upload->DbValue;

            // Favicon
            $this->Favicon->LinkCustomAttributes = "";
            $this->Favicon->HrefValue = "";
            $this->Favicon->ExportHrefValue = $this->Favicon->UploadPath . $this->Favicon->Upload->DbValue;

            // Facebook
            $this->Facebook->LinkCustomAttributes = "";
            $this->Facebook->HrefValue = "";

            // Twitter
            $this->Twitter->LinkCustomAttributes = "";
            $this->Twitter->HrefValue = "";

            // Instagram
            $this->Instagram->LinkCustomAttributes = "";
            $this->Instagram->HrefValue = "";

            // Title
            $this->_Title->LinkCustomAttributes = "";
            $this->_Title->HrefValue = "";

            // Active
            $this->Active->LinkCustomAttributes = "";
            $this->Active->HrefValue = "";

            // Created_AT
            $this->Created_AT->LinkCustomAttributes = "";
            $this->Created_AT->HrefValue = "";

            // Created_BY
            $this->Created_BY->LinkCustomAttributes = "";
            $this->Created_BY->HrefValue = "";

            // IP
            $this->IP->LinkCustomAttributes = "";
            $this->IP->HrefValue = "";
        } elseif ($this->RowType == ROWTYPE_EDIT) {
            // ID
            $this->ID->setupEditAttributes();
            $this->ID->EditCustomAttributes = "";
            $this->ID->EditValue = $this->ID->CurrentValue;
            $this->ID->ViewCustomAttributes = "";

            // Contact_No_1
            $this->Contact_No_1->setupEditAttributes();
            $this->Contact_No_1->EditCustomAttributes = "";
            if (!$this->Contact_No_1->Raw) {
                $this->Contact_No_1->CurrentValue = HtmlDecode($this->Contact_No_1->CurrentValue);
            }
            $this->Contact_No_1->EditValue = HtmlEncode($this->Contact_No_1->CurrentValue);
            $this->Contact_No_1->PlaceHolder = RemoveHtml($this->Contact_No_1->caption());

            // Contact_No_2
            $this->Contact_No_2->setupEditAttributes();
            $this->Contact_No_2->EditCustomAttributes = "";
            if (!$this->Contact_No_2->Raw) {
                $this->Contact_No_2->CurrentValue = HtmlDecode($this->Contact_No_2->CurrentValue);
            }
            $this->Contact_No_2->EditValue = HtmlEncode($this->Contact_No_2->CurrentValue);
            $this->Contact_No_2->PlaceHolder = RemoveHtml($this->Contact_No_2->caption());

            // Brand_Name
            $this->Brand_Name->setupEditAttributes();
            $this->Brand_Name->EditCustomAttributes = "";
            if (!$this->Brand_Name->Raw) {
                $this->Brand_Name->CurrentValue = HtmlDecode($this->Brand_Name->CurrentValue);
            }
            $this->Brand_Name->EditValue = HtmlEncode($this->Brand_Name->CurrentValue);
            $this->Brand_Name->PlaceHolder = RemoveHtml($this->Brand_Name->caption());

            // Logo
            $this->Logo->setupEditAttributes();
            $this->Logo->EditCustomAttributes = "";
            $this->Logo->UploadPath = "files/";
            if (!EmptyValue($this->Logo->Upload->DbValue)) {
                $this->Logo->EditValue = $this->Logo->Upload->DbValue;
            } else {
                $this->Logo->EditValue = "";
            }
            if (!EmptyValue($this->Logo->CurrentValue)) {
                if ($this->RowIndex == '$rowindex$') {
                    $this->Logo->Upload->FileName = "";
                } else {
                    $this->Logo->Upload->FileName = $this->Logo->CurrentValue;
                }
            }
            if (is_numeric($this->RowIndex)) {
                RenderUploadField($this->Logo, $this->RowIndex);
            }

            // Favicon
            $this->Favicon->setupEditAttributes();
            $this->Favicon->EditCustomAttributes = "";
            $this->Favicon->UploadPath = "files/";
            if (!EmptyValue($this->Favicon->Upload->DbValue)) {
                $this->Favicon->EditValue = $this->Favicon->Upload->DbValue;
            } else {
                $this->Favicon->EditValue = "";
            }
            if (!EmptyValue($this->Favicon->CurrentValue)) {
                if ($this->RowIndex == '$rowindex$') {
                    $this->Favicon->Upload->FileName = "";
                } else {
                    $this->Favicon->Upload->FileName = $this->Favicon->CurrentValue;
                }
            }
            if (is_numeric($this->RowIndex)) {
                RenderUploadField($this->Favicon, $this->RowIndex);
            }

            // Facebook
            $this->Facebook->setupEditAttributes();
            $this->Facebook->EditCustomAttributes = "";
            if (!$this->Facebook->Raw) {
                $this->Facebook->CurrentValue = HtmlDecode($this->Facebook->CurrentValue);
            }
            $this->Facebook->EditValue = HtmlEncode($this->Facebook->CurrentValue);
            $this->Facebook->PlaceHolder = RemoveHtml($this->Facebook->caption());

            // Twitter
            $this->Twitter->setupEditAttributes();
            $this->Twitter->EditCustomAttributes = "";
            if (!$this->Twitter->Raw) {
                $this->Twitter->CurrentValue = HtmlDecode($this->Twitter->CurrentValue);
            }
            $this->Twitter->EditValue = HtmlEncode($this->Twitter->CurrentValue);
            $this->Twitter->PlaceHolder = RemoveHtml($this->Twitter->caption());

            // Instagram
            $this->Instagram->setupEditAttributes();
            $this->Instagram->EditCustomAttributes = "";
            if (!$this->Instagram->Raw) {
                $this->Instagram->CurrentValue = HtmlDecode($this->Instagram->CurrentValue);
            }
            $this->Instagram->EditValue = HtmlEncode($this->Instagram->CurrentValue);
            $this->Instagram->PlaceHolder = RemoveHtml($this->Instagram->caption());

            // Title
            $this->_Title->setupEditAttributes();
            $this->_Title->EditCustomAttributes = "";
            if (!$this->_Title->Raw) {
                $this->_Title->CurrentValue = HtmlDecode($this->_Title->CurrentValue);
            }
            $this->_Title->EditValue = HtmlEncode($this->_Title->CurrentValue);
            $this->_Title->PlaceHolder = RemoveHtml($this->_Title->caption());

            // Active
            $this->Active->EditCustomAttributes = "";
            $this->Active->EditValue = $this->Active->options(false);
            $this->Active->PlaceHolder = RemoveHtml($this->Active->caption());

            // Created_AT

            // Created_BY

            // IP

            // Edit refer script

            // ID
            $this->ID->LinkCustomAttributes = "";
            $this->ID->HrefValue = "";

            // Contact_No_1
            $this->Contact_No_1->LinkCustomAttributes = "";
            $this->Contact_No_1->HrefValue = "";

            // Contact_No_2
            $this->Contact_No_2->LinkCustomAttributes = "";
            $this->Contact_No_2->HrefValue = "";

            // Brand_Name
            $this->Brand_Name->LinkCustomAttributes = "";
            $this->Brand_Name->HrefValue = "";

            // Logo
            $this->Logo->LinkCustomAttributes = "";
            $this->Logo->HrefValue = "";
            $this->Logo->ExportHrefValue = $this->Logo->UploadPath . $this->Logo->Upload->DbValue;

            // Favicon
            $this->Favicon->LinkCustomAttributes = "";
            $this->Favicon->HrefValue = "";
            $this->Favicon->ExportHrefValue = $this->Favicon->UploadPath . $this->Favicon->Upload->DbValue;

            // Facebook
            $this->Facebook->LinkCustomAttributes = "";
            $this->Facebook->HrefValue = "";

            // Twitter
            $this->Twitter->LinkCustomAttributes = "";
            $this->Twitter->HrefValue = "";

            // Instagram
            $this->Instagram->LinkCustomAttributes = "";
            $this->Instagram->HrefValue = "";

            // Title
            $this->_Title->LinkCustomAttributes = "";
            $this->_Title->HrefValue = "";

            // Active
            $this->Active->LinkCustomAttributes = "";
            $this->Active->HrefValue = "";

            // Created_AT
            $this->Created_AT->LinkCustomAttributes = "";
            $this->Created_AT->HrefValue = "";

            // Created_BY
            $this->Created_BY->LinkCustomAttributes = "";
            $this->Created_BY->HrefValue = "";

            // IP
            $this->IP->LinkCustomAttributes = "";
            $this->IP->HrefValue = "";
        }
        if ($this->RowType == ROWTYPE_ADD || $this->RowType == ROWTYPE_EDIT || $this->RowType == ROWTYPE_SEARCH) { // Add/Edit/Search row
            $this->setupFieldTitles();
        }

        // Call Row Rendered event
        if ($this->RowType != ROWTYPE_AGGREGATEINIT) {
            $this->rowRendered();
        }
    }

    // Validate form
    protected function validateForm()
    {
        global $Language;

        // Check if validation required
        if (!Config("SERVER_VALIDATE")) {
            return true;
        }
        $validateForm = true;
        if ($this->ID->Required) {
            if (!$this->ID->IsDetailKey && EmptyValue($this->ID->FormValue)) {
                $this->ID->addErrorMessage(str_replace("%s", $this->ID->caption(), $this->ID->RequiredErrorMessage));
            }
        }
        if ($this->Contact_No_1->Required) {
            if (!$this->Contact_No_1->IsDetailKey && EmptyValue($this->Contact_No_1->FormValue)) {
                $this->Contact_No_1->addErrorMessage(str_replace("%s", $this->Contact_No_1->caption(), $this->Contact_No_1->RequiredErrorMessage));
            }
        }
        if ($this->Contact_No_2->Required) {
            if (!$this->Contact_No_2->IsDetailKey && EmptyValue($this->Contact_No_2->FormValue)) {
                $this->Contact_No_2->addErrorMessage(str_replace("%s", $this->Contact_No_2->caption(), $this->Contact_No_2->RequiredErrorMessage));
            }
        }
        if ($this->Brand_Name->Required) {
            if (!$this->Brand_Name->IsDetailKey && EmptyValue($this->Brand_Name->FormValue)) {
                $this->Brand_Name->addErrorMessage(str_replace("%s", $this->Brand_Name->caption(), $this->Brand_Name->RequiredErrorMessage));
            }
        }
        if ($this->Logo->Required) {
            if ($this->Logo->Upload->FileName == "" && !$this->Logo->Upload->KeepFile) {
                $this->Logo->addErrorMessage(str_replace("%s", $this->Logo->caption(), $this->Logo->RequiredErrorMessage));
            }
        }
        if ($this->Favicon->Required) {
            if ($this->Favicon->Upload->FileName == "" && !$this->Favicon->Upload->KeepFile) {
                $this->Favicon->addErrorMessage(str_replace("%s", $this->Favicon->caption(), $this->Favicon->RequiredErrorMessage));
            }
        }
        if ($this->Facebook->Required) {
            if (!$this->Facebook->IsDetailKey && EmptyValue($this->Facebook->FormValue)) {
                $this->Facebook->addErrorMessage(str_replace("%s", $this->Facebook->caption(), $this->Facebook->RequiredErrorMessage));
            }
        }
        if ($this->Twitter->Required) {
            if (!$this->Twitter->IsDetailKey && EmptyValue($this->Twitter->FormValue)) {
                $this->Twitter->addErrorMessage(str_replace("%s", $this->Twitter->caption(), $this->Twitter->RequiredErrorMessage));
            }
        }
        if ($this->Instagram->Required) {
            if (!$this->Instagram->IsDetailKey && EmptyValue($this->Instagram->FormValue)) {
                $this->Instagram->addErrorMessage(str_replace("%s", $this->Instagram->caption(), $this->Instagram->RequiredErrorMessage));
            }
        }
        if ($this->_Title->Required) {
            if (!$this->_Title->IsDetailKey && EmptyValue($this->_Title->FormValue)) {
                $this->_Title->addErrorMessage(str_replace("%s", $this->_Title->caption(), $this->_Title->RequiredErrorMessage));
            }
        }
        if ($this->Active->Required) {
            if ($this->Active->FormValue == "") {
                $this->Active->addErrorMessage(str_replace("%s", $this->Active->caption(), $this->Active->RequiredErrorMessage));
            }
        }
        if ($this->Created_AT->Required) {
            if (!$this->Created_AT->IsDetailKey && EmptyValue($this->Created_AT->FormValue)) {
                $this->Created_AT->addErrorMessage(str_replace("%s", $this->Created_AT->caption(), $this->Created_AT->RequiredErrorMessage));
            }
        }
        if ($this->Created_BY->Required) {
            if (!$this->Created_BY->IsDetailKey && EmptyValue($this->Created_BY->FormValue)) {
                $this->Created_BY->addErrorMessage(str_replace("%s", $this->Created_BY->caption(), $this->Created_BY->RequiredErrorMessage));
            }
        }
        if ($this->IP->Required) {
            if (!$this->IP->IsDetailKey && EmptyValue($this->IP->FormValue)) {
                $this->IP->addErrorMessage(str_replace("%s", $this->IP->caption(), $this->IP->RequiredErrorMessage));
            }
        }

        // Return validate result
        $validateForm = $validateForm && !$this->hasInvalidFields();

        // Call Form_CustomValidate event
        $formCustomError = "";
        $validateForm = $validateForm && $this->formCustomValidate($formCustomError);
        if ($formCustomError != "") {
            $this->setFailureMessage($formCustomError);
        }
        return $validateForm;
    }

    // Delete records based on current filter
    protected function deleteRows()
    {
        global $Language, $Security;
        if (!$Security->canDelete()) {
            $this->setFailureMessage($Language->phrase("NoDeletePermission")); // No delete permission
            return false;
        }
        $sql = $this->getCurrentSql();
        $conn = $this->getConnection();
        $rows = $conn->fetchAllAssociative($sql);
        if (count($rows) == 0) {
            $this->setFailureMessage($Language->phrase("NoRecord")); // No record found
            return false;
        }
        if ($this->AuditTrailOnDelete) {
            $this->writeAuditTrailDummy($Language->phrase("BatchDeleteBegin")); // Batch delete begin
        }

        // Clone old rows
        $rsold = $rows;
        $successKeys = [];
        $failKeys = [];
        foreach ($rsold as $row) {
            $thisKey = "";
            if ($thisKey != "") {
                $thisKey .= Config("COMPOSITE_KEY_SEPARATOR");
            }
            $thisKey .= $row['ID'];

            // Call row deleting event
            $deleteRow = $this->rowDeleting($row);
            if ($deleteRow) { // Delete
                $deleteRow = $this->delete($row);
            }
            if ($deleteRow === false) {
                if ($this->UseTransaction) {
                    $successKeys = []; // Reset success keys
                    break;
                }
                $failKeys[] = $thisKey;
            } else {
                if (Config("DELETE_UPLOADED_FILES")) { // Delete old files
                    $this->deleteUploadedFiles($row);
                }

                // Call Row Deleted event
                $this->rowDeleted($row);
                $successKeys[] = $thisKey;
            }
        }

        // Any records deleted
        $deleteRows = count($successKeys) > 0;
        if (!$deleteRows) {
            // Set up error message
            if ($this->getSuccessMessage() != "" || $this->getFailureMessage() != "") {
                // Use the message, do nothing
            } elseif ($this->CancelMessage != "") {
                $this->setFailureMessage($this->CancelMessage);
                $this->CancelMessage = "";
            } else {
                $this->setFailureMessage($Language->phrase("DeleteCancelled"));
            }
        }

        // Write JSON for API request
        if (IsApi() && $deleteRows) {
            $row = $this->getRecordsFromRecordset($rsold);
            WriteJson(["success" => true, $this->TableVar => $row]);
        }
        return $deleteRows;
    }

    // Update record based on key values
    protected function editRow()
    {
        global $Security, $Language;
        $oldKeyFilter = $this->getRecordFilter();
        $filter = $this->applyUserIDFilters($oldKeyFilter);
        $conn = $this->getConnection();
        $this->CurrentFilter = $filter;
        $sql = $this->getCurrentSql();
        $rsold = $conn->fetchAssociative($sql);
        if (!$rsold) {
            $this->setFailureMessage($Language->phrase("NoRecord")); // Set no record message
            $editRow = false; // Update Failed
        } else {
            // Save old values
            $this->loadDbValues($rsold);
            $this->Logo->OldUploadPath = "files/";
            $this->Logo->UploadPath = $this->Logo->OldUploadPath;
            $this->Favicon->OldUploadPath = "files/";
            $this->Favicon->UploadPath = $this->Favicon->OldUploadPath;
            $rsnew = [];

            // Contact_No_1
            $this->Contact_No_1->setDbValueDef($rsnew, $this->Contact_No_1->CurrentValue, "", $this->Contact_No_1->ReadOnly);

            // Contact_No_2
            $this->Contact_No_2->setDbValueDef($rsnew, $this->Contact_No_2->CurrentValue, null, $this->Contact_No_2->ReadOnly);

            // Brand_Name
            $this->Brand_Name->setDbValueDef($rsnew, $this->Brand_Name->CurrentValue, "", $this->Brand_Name->ReadOnly);

            // Logo
            if ($this->Logo->Visible && !$this->Logo->ReadOnly && !$this->Logo->Upload->KeepFile) {
                $this->Logo->Upload->DbValue = $rsold['Logo']; // Get original value
                if ($this->Logo->Upload->FileName == "") {
                    $rsnew['Logo'] = null;
                } else {
                    $rsnew['Logo'] = $this->Logo->Upload->FileName;
                }
            }

            // Favicon
            if ($this->Favicon->Visible && !$this->Favicon->ReadOnly && !$this->Favicon->Upload->KeepFile) {
                $this->Favicon->Upload->DbValue = $rsold['Favicon']; // Get original value
                if ($this->Favicon->Upload->FileName == "") {
                    $rsnew['Favicon'] = null;
                } else {
                    $rsnew['Favicon'] = $this->Favicon->Upload->FileName;
                }
            }

            // Facebook
            $this->Facebook->setDbValueDef($rsnew, $this->Facebook->CurrentValue, null, $this->Facebook->ReadOnly);

            // Twitter
            $this->Twitter->setDbValueDef($rsnew, $this->Twitter->CurrentValue, null, $this->Twitter->ReadOnly);

            // Instagram
            $this->Instagram->setDbValueDef($rsnew, $this->Instagram->CurrentValue, null, $this->Instagram->ReadOnly);

            // Title
            $this->_Title->setDbValueDef($rsnew, $this->_Title->CurrentValue, "", $this->_Title->ReadOnly);

            // Active
            $this->Active->setDbValueDef($rsnew, strval($this->Active->CurrentValue) == "1" ? "1" : "0", 0, $this->Active->ReadOnly);

            // Created_AT
            $this->Created_AT->CurrentValue = CurrentDateTime();
            $this->Created_AT->setDbValueDef($rsnew, $this->Created_AT->CurrentValue, CurrentDate());

            // Created_BY
            $this->Created_BY->CurrentValue = CurrentUserName();
            $this->Created_BY->setDbValueDef($rsnew, $this->Created_BY->CurrentValue, "");

            // IP
            $this->IP->CurrentValue = CurrentUserIP();
            $this->IP->setDbValueDef($rsnew, $this->IP->CurrentValue, "");
            if ($this->Logo->Visible && !$this->Logo->Upload->KeepFile) {
                $this->Logo->UploadPath = "files/";
                $oldFiles = EmptyValue($this->Logo->Upload->DbValue) ? [] : [$this->Logo->htmlDecode($this->Logo->Upload->DbValue)];
                if (!EmptyValue($this->Logo->Upload->FileName)) {
                    $newFiles = [$this->Logo->Upload->FileName];
                    $NewFileCount = count($newFiles);
                    for ($i = 0; $i < $NewFileCount; $i++) {
                        if ($newFiles[$i] != "") {
                            $file = $newFiles[$i];
                            $tempPath = UploadTempPath($this->Logo, $this->Logo->Upload->Index);
                            if (file_exists($tempPath . $file)) {
                                if (Config("DELETE_UPLOADED_FILES")) {
                                    $oldFileFound = false;
                                    $oldFileCount = count($oldFiles);
                                    for ($j = 0; $j < $oldFileCount; $j++) {
                                        $oldFile = $oldFiles[$j];
                                        if ($oldFile == $file) { // Old file found, no need to delete anymore
                                            array_splice($oldFiles, $j, 1);
                                            $oldFileFound = true;
                                            break;
                                        }
                                    }
                                    if ($oldFileFound) { // No need to check if file exists further
                                        continue;
                                    }
                                }
                                $file1 = UniqueFilename($this->Logo->physicalUploadPath(), $file); // Get new file name
                                if ($file1 != $file) { // Rename temp file
                                    while (file_exists($tempPath . $file1) || file_exists($this->Logo->physicalUploadPath() . $file1)) { // Make sure no file name clash
                                        $file1 = UniqueFilename([$this->Logo->physicalUploadPath(), $tempPath], $file1, true); // Use indexed name
                                    }
                                    rename($tempPath . $file, $tempPath . $file1);
                                    $newFiles[$i] = $file1;
                                }
                            }
                        }
                    }
                    $this->Logo->Upload->DbValue = empty($oldFiles) ? "" : implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $oldFiles);
                    $this->Logo->Upload->FileName = implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $newFiles);
                    $this->Logo->setDbValueDef($rsnew, $this->Logo->Upload->FileName, "", $this->Logo->ReadOnly);
                }
            }
            if ($this->Favicon->Visible && !$this->Favicon->Upload->KeepFile) {
                $this->Favicon->UploadPath = "files/";
                $oldFiles = EmptyValue($this->Favicon->Upload->DbValue) ? [] : [$this->Favicon->htmlDecode($this->Favicon->Upload->DbValue)];
                if (!EmptyValue($this->Favicon->Upload->FileName)) {
                    $newFiles = [$this->Favicon->Upload->FileName];
                    $NewFileCount = count($newFiles);
                    for ($i = 0; $i < $NewFileCount; $i++) {
                        if ($newFiles[$i] != "") {
                            $file = $newFiles[$i];
                            $tempPath = UploadTempPath($this->Favicon, $this->Favicon->Upload->Index);
                            if (file_exists($tempPath . $file)) {
                                if (Config("DELETE_UPLOADED_FILES")) {
                                    $oldFileFound = false;
                                    $oldFileCount = count($oldFiles);
                                    for ($j = 0; $j < $oldFileCount; $j++) {
                                        $oldFile = $oldFiles[$j];
                                        if ($oldFile == $file) { // Old file found, no need to delete anymore
                                            array_splice($oldFiles, $j, 1);
                                            $oldFileFound = true;
                                            break;
                                        }
                                    }
                                    if ($oldFileFound) { // No need to check if file exists further
                                        continue;
                                    }
                                }
                                $file1 = UniqueFilename($this->Favicon->physicalUploadPath(), $file); // Get new file name
                                if ($file1 != $file) { // Rename temp file
                                    while (file_exists($tempPath . $file1) || file_exists($this->Favicon->physicalUploadPath() . $file1)) { // Make sure no file name clash
                                        $file1 = UniqueFilename([$this->Favicon->physicalUploadPath(), $tempPath], $file1, true); // Use indexed name
                                    }
                                    rename($tempPath . $file, $tempPath . $file1);
                                    $newFiles[$i] = $file1;
                                }
                            }
                        }
                    }
                    $this->Favicon->Upload->DbValue = empty($oldFiles) ? "" : implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $oldFiles);
                    $this->Favicon->Upload->FileName = implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $newFiles);
                    $this->Favicon->setDbValueDef($rsnew, $this->Favicon->Upload->FileName, "", $this->Favicon->ReadOnly);
                }
            }

            // Call Row Updating event
            $updateRow = $this->rowUpdating($rsold, $rsnew);
            if ($updateRow) {
                if (count($rsnew) > 0) {
                    $editRow = $this->update($rsnew, "", $rsold);
                } else {
                    $editRow = true; // No field to update
                }
                if ($editRow) {
                    if ($this->Logo->Visible && !$this->Logo->Upload->KeepFile) {
                        $oldFiles = EmptyValue($this->Logo->Upload->DbValue) ? [] : [$this->Logo->htmlDecode($this->Logo->Upload->DbValue)];
                        if (!EmptyValue($this->Logo->Upload->FileName)) {
                            $newFiles = [$this->Logo->Upload->FileName];
                            $newFiles2 = [$this->Logo->htmlDecode($rsnew['Logo'])];
                            $newFileCount = count($newFiles);
                            for ($i = 0; $i < $newFileCount; $i++) {
                                if ($newFiles[$i] != "") {
                                    $file = UploadTempPath($this->Logo, $this->Logo->Upload->Index) . $newFiles[$i];
                                    if (file_exists($file)) {
                                        if (@$newFiles2[$i] != "") { // Use correct file name
                                            $newFiles[$i] = $newFiles2[$i];
                                        }
                                        if (!$this->Logo->Upload->SaveToFile($newFiles[$i], true, $i)) { // Just replace
                                            $this->setFailureMessage($Language->phrase("UploadErrMsg7"));
                                            return false;
                                        }
                                    }
                                }
                            }
                        } else {
                            $newFiles = [];
                        }
                        if (Config("DELETE_UPLOADED_FILES")) {
                            foreach ($oldFiles as $oldFile) {
                                if ($oldFile != "" && !in_array($oldFile, $newFiles)) {
                                    @unlink($this->Logo->oldPhysicalUploadPath() . $oldFile);
                                }
                            }
                        }
                    }
                    if ($this->Favicon->Visible && !$this->Favicon->Upload->KeepFile) {
                        $oldFiles = EmptyValue($this->Favicon->Upload->DbValue) ? [] : [$this->Favicon->htmlDecode($this->Favicon->Upload->DbValue)];
                        if (!EmptyValue($this->Favicon->Upload->FileName)) {
                            $newFiles = [$this->Favicon->Upload->FileName];
                            $newFiles2 = [$this->Favicon->htmlDecode($rsnew['Favicon'])];
                            $newFileCount = count($newFiles);
                            for ($i = 0; $i < $newFileCount; $i++) {
                                if ($newFiles[$i] != "") {
                                    $file = UploadTempPath($this->Favicon, $this->Favicon->Upload->Index) . $newFiles[$i];
                                    if (file_exists($file)) {
                                        if (@$newFiles2[$i] != "") { // Use correct file name
                                            $newFiles[$i] = $newFiles2[$i];
                                        }
                                        if (!$this->Favicon->Upload->SaveToFile($newFiles[$i], true, $i)) { // Just replace
                                            $this->setFailureMessage($Language->phrase("UploadErrMsg7"));
                                            return false;
                                        }
                                    }
                                }
                            }
                        } else {
                            $newFiles = [];
                        }
                        if (Config("DELETE_UPLOADED_FILES")) {
                            foreach ($oldFiles as $oldFile) {
                                if ($oldFile != "" && !in_array($oldFile, $newFiles)) {
                                    @unlink($this->Favicon->oldPhysicalUploadPath() . $oldFile);
                                }
                            }
                        }
                    }
                }
            } else {
                if ($this->getSuccessMessage() != "" || $this->getFailureMessage() != "") {
                    // Use the message, do nothing
                } elseif ($this->CancelMessage != "") {
                    $this->setFailureMessage($this->CancelMessage);
                    $this->CancelMessage = "";
                } else {
                    $this->setFailureMessage($Language->phrase("UpdateCancelled"));
                }
                $editRow = false;
            }
        }

        // Call Row_Updated event
        if ($editRow) {
            $this->rowUpdated($rsold, $rsnew);
        }

        // Clean upload path if any
        if ($editRow) {
            // Logo
            CleanUploadTempPath($this->Logo, $this->Logo->Upload->Index);

            // Favicon
            CleanUploadTempPath($this->Favicon, $this->Favicon->Upload->Index);
        }

        // Write JSON for API request
        if (IsApi() && $editRow) {
            $row = $this->getRecordsFromRecordset([$rsnew], true);
            WriteJson(["success" => true, $this->TableVar => $row]);
        }
        return $editRow;
    }

    // Load row hash
    protected function loadRowHash()
    {
        $filter = $this->getRecordFilter();

        // Load SQL based on filter
        $this->CurrentFilter = $filter;
        $sql = $this->getCurrentSql();
        $conn = $this->getConnection();
        $row = $conn->fetchAssociative($sql);
        $this->HashValue = $row ? $this->getRowHash($row) : ""; // Get hash value for record
    }

    // Get Row Hash
    public function getRowHash(&$rs)
    {
        if (!$rs) {
            return "";
        }
        $row = ($rs instanceof Recordset) ? $rs->fields : $rs;
        $hash = "";
        $hash .= GetFieldHash($row['Contact_No_1']); // Contact_No_1
        $hash .= GetFieldHash($row['Contact_No_2']); // Contact_No_2
        $hash .= GetFieldHash($row['Brand_Name']); // Brand_Name
        $hash .= GetFieldHash($row['Logo']); // Logo
        $hash .= GetFieldHash($row['Favicon']); // Favicon
        $hash .= GetFieldHash($row['Facebook']); // Facebook
        $hash .= GetFieldHash($row['Twitter']); // Twitter
        $hash .= GetFieldHash($row['Instagram']); // Instagram
        $hash .= GetFieldHash($row['Title']); // Title
        $hash .= GetFieldHash($row['Active']); // Active
        $hash .= GetFieldHash($row['Created_AT']); // Created_AT
        $hash .= GetFieldHash($row['Created_BY']); // Created_BY
        $hash .= GetFieldHash($row['IP']); // IP
        return md5($hash);
    }

    // Add record
    protected function addRow($rsold = null)
    {
        global $Language, $Security;
        $conn = $this->getConnection();

        // Load db values from rsold
        $this->loadDbValues($rsold);
        if ($rsold) {
            $this->Logo->OldUploadPath = "files/";
            $this->Logo->UploadPath = $this->Logo->OldUploadPath;
            $this->Favicon->OldUploadPath = "files/";
            $this->Favicon->UploadPath = $this->Favicon->OldUploadPath;
        }
        $rsnew = [];

        // Contact_No_1
        $this->Contact_No_1->setDbValueDef($rsnew, $this->Contact_No_1->CurrentValue, "", false);

        // Contact_No_2
        $this->Contact_No_2->setDbValueDef($rsnew, $this->Contact_No_2->CurrentValue, null, false);

        // Brand_Name
        $this->Brand_Name->setDbValueDef($rsnew, $this->Brand_Name->CurrentValue, "", false);

        // Logo
        if ($this->Logo->Visible && !$this->Logo->Upload->KeepFile) {
            $this->Logo->Upload->DbValue = ""; // No need to delete old file
            if ($this->Logo->Upload->FileName == "") {
                $rsnew['Logo'] = null;
            } else {
                $rsnew['Logo'] = $this->Logo->Upload->FileName;
            }
        }

        // Favicon
        if ($this->Favicon->Visible && !$this->Favicon->Upload->KeepFile) {
            $this->Favicon->Upload->DbValue = ""; // No need to delete old file
            if ($this->Favicon->Upload->FileName == "") {
                $rsnew['Favicon'] = null;
            } else {
                $rsnew['Favicon'] = $this->Favicon->Upload->FileName;
            }
        }

        // Facebook
        $this->Facebook->setDbValueDef($rsnew, $this->Facebook->CurrentValue, null, false);

        // Twitter
        $this->Twitter->setDbValueDef($rsnew, $this->Twitter->CurrentValue, null, false);

        // Instagram
        $this->Instagram->setDbValueDef($rsnew, $this->Instagram->CurrentValue, null, false);

        // Title
        $this->_Title->setDbValueDef($rsnew, $this->_Title->CurrentValue, "", false);

        // Active
        $this->Active->setDbValueDef($rsnew, strval($this->Active->CurrentValue) == "1" ? "1" : "0", 0, false);

        // Created_AT
        $this->Created_AT->CurrentValue = CurrentDateTime();
        $this->Created_AT->setDbValueDef($rsnew, $this->Created_AT->CurrentValue, CurrentDate());

        // Created_BY
        $this->Created_BY->CurrentValue = CurrentUserName();
        $this->Created_BY->setDbValueDef($rsnew, $this->Created_BY->CurrentValue, "");

        // IP
        $this->IP->CurrentValue = CurrentUserIP();
        $this->IP->setDbValueDef($rsnew, $this->IP->CurrentValue, "");
        if ($this->Logo->Visible && !$this->Logo->Upload->KeepFile) {
            $this->Logo->UploadPath = "files/";
            $oldFiles = EmptyValue($this->Logo->Upload->DbValue) ? [] : [$this->Logo->htmlDecode($this->Logo->Upload->DbValue)];
            if (!EmptyValue($this->Logo->Upload->FileName)) {
                $newFiles = [$this->Logo->Upload->FileName];
                $NewFileCount = count($newFiles);
                for ($i = 0; $i < $NewFileCount; $i++) {
                    if ($newFiles[$i] != "") {
                        $file = $newFiles[$i];
                        $tempPath = UploadTempPath($this->Logo, $this->Logo->Upload->Index);
                        if (file_exists($tempPath . $file)) {
                            if (Config("DELETE_UPLOADED_FILES")) {
                                $oldFileFound = false;
                                $oldFileCount = count($oldFiles);
                                for ($j = 0; $j < $oldFileCount; $j++) {
                                    $oldFile = $oldFiles[$j];
                                    if ($oldFile == $file) { // Old file found, no need to delete anymore
                                        array_splice($oldFiles, $j, 1);
                                        $oldFileFound = true;
                                        break;
                                    }
                                }
                                if ($oldFileFound) { // No need to check if file exists further
                                    continue;
                                }
                            }
                            $file1 = UniqueFilename($this->Logo->physicalUploadPath(), $file); // Get new file name
                            if ($file1 != $file) { // Rename temp file
                                while (file_exists($tempPath . $file1) || file_exists($this->Logo->physicalUploadPath() . $file1)) { // Make sure no file name clash
                                    $file1 = UniqueFilename([$this->Logo->physicalUploadPath(), $tempPath], $file1, true); // Use indexed name
                                }
                                rename($tempPath . $file, $tempPath . $file1);
                                $newFiles[$i] = $file1;
                            }
                        }
                    }
                }
                $this->Logo->Upload->DbValue = empty($oldFiles) ? "" : implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $oldFiles);
                $this->Logo->Upload->FileName = implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $newFiles);
                $this->Logo->setDbValueDef($rsnew, $this->Logo->Upload->FileName, "", false);
            }
        }
        if ($this->Favicon->Visible && !$this->Favicon->Upload->KeepFile) {
            $this->Favicon->UploadPath = "files/";
            $oldFiles = EmptyValue($this->Favicon->Upload->DbValue) ? [] : [$this->Favicon->htmlDecode($this->Favicon->Upload->DbValue)];
            if (!EmptyValue($this->Favicon->Upload->FileName)) {
                $newFiles = [$this->Favicon->Upload->FileName];
                $NewFileCount = count($newFiles);
                for ($i = 0; $i < $NewFileCount; $i++) {
                    if ($newFiles[$i] != "") {
                        $file = $newFiles[$i];
                        $tempPath = UploadTempPath($this->Favicon, $this->Favicon->Upload->Index);
                        if (file_exists($tempPath . $file)) {
                            if (Config("DELETE_UPLOADED_FILES")) {
                                $oldFileFound = false;
                                $oldFileCount = count($oldFiles);
                                for ($j = 0; $j < $oldFileCount; $j++) {
                                    $oldFile = $oldFiles[$j];
                                    if ($oldFile == $file) { // Old file found, no need to delete anymore
                                        array_splice($oldFiles, $j, 1);
                                        $oldFileFound = true;
                                        break;
                                    }
                                }
                                if ($oldFileFound) { // No need to check if file exists further
                                    continue;
                                }
                            }
                            $file1 = UniqueFilename($this->Favicon->physicalUploadPath(), $file); // Get new file name
                            if ($file1 != $file) { // Rename temp file
                                while (file_exists($tempPath . $file1) || file_exists($this->Favicon->physicalUploadPath() . $file1)) { // Make sure no file name clash
                                    $file1 = UniqueFilename([$this->Favicon->physicalUploadPath(), $tempPath], $file1, true); // Use indexed name
                                }
                                rename($tempPath . $file, $tempPath . $file1);
                                $newFiles[$i] = $file1;
                            }
                        }
                    }
                }
                $this->Favicon->Upload->DbValue = empty($oldFiles) ? "" : implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $oldFiles);
                $this->Favicon->Upload->FileName = implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $newFiles);
                $this->Favicon->setDbValueDef($rsnew, $this->Favicon->Upload->FileName, "", false);
            }
        }

        // Call Row Inserting event
        $insertRow = $this->rowInserting($rsold, $rsnew);
        if ($insertRow) {
            $addRow = $this->insert($rsnew);
            if ($addRow) {
                if ($this->Logo->Visible && !$this->Logo->Upload->KeepFile) {
                    $oldFiles = EmptyValue($this->Logo->Upload->DbValue) ? [] : [$this->Logo->htmlDecode($this->Logo->Upload->DbValue)];
                    if (!EmptyValue($this->Logo->Upload->FileName)) {
                        $newFiles = [$this->Logo->Upload->FileName];
                        $newFiles2 = [$this->Logo->htmlDecode($rsnew['Logo'])];
                        $newFileCount = count($newFiles);
                        for ($i = 0; $i < $newFileCount; $i++) {
                            if ($newFiles[$i] != "") {
                                $file = UploadTempPath($this->Logo, $this->Logo->Upload->Index) . $newFiles[$i];
                                if (file_exists($file)) {
                                    if (@$newFiles2[$i] != "") { // Use correct file name
                                        $newFiles[$i] = $newFiles2[$i];
                                    }
                                    if (!$this->Logo->Upload->SaveToFile($newFiles[$i], true, $i)) { // Just replace
                                        $this->setFailureMessage($Language->phrase("UploadErrMsg7"));
                                        return false;
                                    }
                                }
                            }
                        }
                    } else {
                        $newFiles = [];
                    }
                    if (Config("DELETE_UPLOADED_FILES")) {
                        foreach ($oldFiles as $oldFile) {
                            if ($oldFile != "" && !in_array($oldFile, $newFiles)) {
                                @unlink($this->Logo->oldPhysicalUploadPath() . $oldFile);
                            }
                        }
                    }
                }
                if ($this->Favicon->Visible && !$this->Favicon->Upload->KeepFile) {
                    $oldFiles = EmptyValue($this->Favicon->Upload->DbValue) ? [] : [$this->Favicon->htmlDecode($this->Favicon->Upload->DbValue)];
                    if (!EmptyValue($this->Favicon->Upload->FileName)) {
                        $newFiles = [$this->Favicon->Upload->FileName];
                        $newFiles2 = [$this->Favicon->htmlDecode($rsnew['Favicon'])];
                        $newFileCount = count($newFiles);
                        for ($i = 0; $i < $newFileCount; $i++) {
                            if ($newFiles[$i] != "") {
                                $file = UploadTempPath($this->Favicon, $this->Favicon->Upload->Index) . $newFiles[$i];
                                if (file_exists($file)) {
                                    if (@$newFiles2[$i] != "") { // Use correct file name
                                        $newFiles[$i] = $newFiles2[$i];
                                    }
                                    if (!$this->Favicon->Upload->SaveToFile($newFiles[$i], true, $i)) { // Just replace
                                        $this->setFailureMessage($Language->phrase("UploadErrMsg7"));
                                        return false;
                                    }
                                }
                            }
                        }
                    } else {
                        $newFiles = [];
                    }
                    if (Config("DELETE_UPLOADED_FILES")) {
                        foreach ($oldFiles as $oldFile) {
                            if ($oldFile != "" && !in_array($oldFile, $newFiles)) {
                                @unlink($this->Favicon->oldPhysicalUploadPath() . $oldFile);
                            }
                        }
                    }
                }
            }
        } else {
            if ($this->getSuccessMessage() != "" || $this->getFailureMessage() != "") {
                // Use the message, do nothing
            } elseif ($this->CancelMessage != "") {
                $this->setFailureMessage($this->CancelMessage);
                $this->CancelMessage = "";
            } else {
                $this->setFailureMessage($Language->phrase("InsertCancelled"));
            }
            $addRow = false;
        }
        if ($addRow) {
            // Call Row Inserted event
            $this->rowInserted($rsold, $rsnew);
        }

        // Clean upload path if any
        if ($addRow) {
            // Logo
            CleanUploadTempPath($this->Logo, $this->Logo->Upload->Index);

            // Favicon
            CleanUploadTempPath($this->Favicon, $this->Favicon->Upload->Index);
        }

        // Write JSON for API request
        if (IsApi() && $addRow) {
            $row = $this->getRecordsFromRecordset([$rsnew], true);
            WriteJson(["success" => true, $this->TableVar => $row]);
        }
        return $addRow;
    }

    // Get export HTML tag
    protected function getExportTag($type, $custom = false)
    {
        global $Language;
        $pageUrl = $this->pageUrl();
        $exportUrl = GetUrl($pageUrl . "export=" . $type . ($custom ? "&amp;custom=1" : ""));
        if (SameText($type, "excel")) {
            if ($custom) {
                return "<button type=\"button\" class=\"btn btn-default ew-export-link ew-excel\" title=\"" . HtmlEncode($Language->phrase("ExportToExcelText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToExcelText")) . "\" form=\"fsite_settingslist\" data-url=\"$exportUrl\" data-ew-action=\"export\" data-export=\"excel\" data-custom=\"true\" data-export-selected=\"false\">" . $Language->phrase("ExportToExcel") . "</button>";
            } else {
                return "<a href=\"$exportUrl\" class=\"btn btn-default ew-export-link ew-excel\" title=\"" . HtmlEncode($Language->phrase("ExportToExcelText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToExcelText")) . "\">" . $Language->phrase("ExportToExcel") . "</a>";
            }
        } elseif (SameText($type, "word")) {
            if ($custom) {
                return "<button type=\"button\" class=\"btn btn-default ew-export-link ew-word\" title=\"" . HtmlEncode($Language->phrase("ExportToWordText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToWordText")) . "\" form=\"fsite_settingslist\" data-url=\"$exportUrl\" data-ew-action=\"export\" data-export=\"word\" data-custom=\"true\" data-export-selected=\"false\">" . $Language->phrase("ExportToWord") . "</button>";
            } else {
                return "<a href=\"$exportUrl\" class=\"btn btn-default ew-export-link ew-word\" title=\"" . HtmlEncode($Language->phrase("ExportToWordText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToWordText")) . "\">" . $Language->phrase("ExportToWord") . "</a>";
            }
        } elseif (SameText($type, "pdf")) {
            if ($custom) {
                return "<button type=\"button\" class=\"btn btn-default ew-export-link ew-pdf\" title=\"" . HtmlEncode($Language->phrase("ExportToPdfText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToPdfText")) . "\" form=\"fsite_settingslist\" data-url=\"$exportUrl\" data-ew-action=\"export\" data-export=\"pdf\" data-custom=\"true\" data-export-selected=\"false\">" . $Language->phrase("ExportToPdf") . "</button>";
            } else {
                return "<a href=\"$exportUrl\" class=\"btn btn-default ew-export-link ew-pdf\" title=\"" . HtmlEncode($Language->phrase("ExportToPdfText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToPdfText")) . "\">" . $Language->phrase("ExportToPdf") . "</a>";
            }
        } elseif (SameText($type, "html")) {
            return "<a href=\"$exportUrl\" class=\"btn btn-default ew-export-link ew-html\" title=\"" . HtmlEncode($Language->phrase("ExportToHtmlText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToHtmlText")) . "\">" . $Language->phrase("ExportToHtml") . "</a>";
        } elseif (SameText($type, "xml")) {
            return "<a href=\"$exportUrl\" class=\"btn btn-default ew-export-link ew-xml\" title=\"" . HtmlEncode($Language->phrase("ExportToXmlText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToXmlText")) . "\">" . $Language->phrase("ExportToXml") . "</a>";
        } elseif (SameText($type, "csv")) {
            return "<a href=\"$exportUrl\" class=\"btn btn-default ew-export-link ew-csv\" title=\"" . HtmlEncode($Language->phrase("ExportToCsvText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToCsvText")) . "\">" . $Language->phrase("ExportToCsv") . "</a>";
        } elseif (SameText($type, "email")) {
            $url = $custom ? ' data-url="' . $exportUrl . '"' : '';
            return '<button type="button" class="btn btn-default ew-export-link ew-email" title="' . $Language->phrase("ExportToEmailText") . '" data-caption="' . $Language->phrase("ExportToEmailText") . '" form="fsite_settingslist" data-ew-action="email" data-hdr="' . $Language->phrase("ExportToEmailText") . '" data-sel="false"' . $url . '>' . $Language->phrase("ExportToEmail") . '</button>';
        } elseif (SameText($type, "print")) {
            return "<a href=\"$exportUrl\" class=\"btn btn-default ew-export-link ew-print\" title=\"" . HtmlEncode($Language->phrase("ExportToPrintText")) . "\" data-caption=\"" . HtmlEncode($Language->phrase("ExportToPrintText")) . "\">" . $Language->phrase("PrinterFriendly") . "</a>";
        }
    }

    // Set up export options
    protected function setupExportOptions()
    {
        global $Language;

        // Printer friendly
        $item = &$this->ExportOptions->add("print");
        $item->Body = $this->getExportTag("print");
        $item->Visible = true;

        // Export to Excel
        $item = &$this->ExportOptions->add("excel");
        $item->Body = $this->getExportTag("excel");
        $item->Visible = true;

        // Export to Word
        $item = &$this->ExportOptions->add("word");
        $item->Body = $this->getExportTag("word");
        $item->Visible = true;

        // Export to HTML
        $item = &$this->ExportOptions->add("html");
        $item->Body = $this->getExportTag("html");
        $item->Visible = true;

        // Export to XML
        $item = &$this->ExportOptions->add("xml");
        $item->Body = $this->getExportTag("xml");
        $item->Visible = true;

        // Export to CSV
        $item = &$this->ExportOptions->add("csv");
        $item->Body = $this->getExportTag("csv");
        $item->Visible = true;

        // Export to PDF
        $item = &$this->ExportOptions->add("pdf");
        $item->Body = $this->getExportTag("pdf");
        $item->Visible = false;

        // Export to Email
        $item = &$this->ExportOptions->add("email");
        $item->Body = $this->getExportTag("email");
        $item->Visible = false;

        // Drop down button for export
        $this->ExportOptions->UseButtonGroup = true;
        $this->ExportOptions->UseDropDownButton = false;
        if ($this->ExportOptions->UseButtonGroup && IsMobile()) {
            $this->ExportOptions->UseDropDownButton = true;
        }
        $this->ExportOptions->DropDownButtonPhrase = $Language->phrase("ButtonExport");

        // Add group option item
        $item = &$this->ExportOptions->addGroupOption();
        $item->Body = "";
        $item->Visible = false;
    }

    // Set up search options
    protected function setupSearchOptions()
    {
        global $Language, $Security;
        $pageUrl = $this->pageUrl();
        $this->SearchOptions = new ListOptions(["TagClassName" => "ew-search-option"]);

        // Search button
        $item = &$this->SearchOptions->add("searchtoggle");
        $searchToggleClass = ($this->SearchWhere != "") ? " active" : " active";
        $item->Body = "<a class=\"btn btn-default ew-search-toggle" . $searchToggleClass . "\" role=\"button\" title=\"" . $Language->phrase("SearchPanel") . "\" data-caption=\"" . $Language->phrase("SearchPanel") . "\" data-ew-action=\"search-toggle\" data-form=\"fsite_settingssrch\" aria-pressed=\"" . ($searchToggleClass == " active" ? "true" : "false") . "\">" . $Language->phrase("SearchLink") . "</a>";
        $item->Visible = true;

        // Show all button
        $item = &$this->SearchOptions->add("showall");
        $item->Body = "<a class=\"btn btn-default ew-show-all\" title=\"" . $Language->phrase("ShowAll") . "\" data-caption=\"" . $Language->phrase("ShowAll") . "\" href=\"" . $pageUrl . "cmd=reset\">" . $Language->phrase("ShowAllBtn") . "</a>";
        $item->Visible = ($this->SearchWhere != $this->DefaultSearchWhere && $this->SearchWhere != "0=101");

        // Button group for search
        $this->SearchOptions->UseDropDownButton = false;
        $this->SearchOptions->UseButtonGroup = true;
        $this->SearchOptions->DropDownButtonPhrase = $Language->phrase("ButtonSearch");

        // Add group option item
        $item = &$this->SearchOptions->addGroupOption();
        $item->Body = "";
        $item->Visible = false;

        // Hide search options
        if ($this->isExport() || $this->CurrentAction) {
            $this->SearchOptions->hideAllOptions();
        }
        if (!$Security->canSearch()) {
            $this->SearchOptions->hideAllOptions();
            $this->FilterOptions->hideAllOptions();
        }
    }

    // Check if any search fields
    public function hasSearchFields()
    {
        return true;
    }

    // Render search options
    protected function renderSearchOptions()
    {
        if (!$this->hasSearchFields() && $this->SearchOptions["searchtoggle"]) {
            $this->SearchOptions["searchtoggle"]->Visible = false;
        }
    }

    /**
    * Export data in HTML/CSV/Word/Excel/XML/Email/PDF format
    *
    * @param bool $return Return the data rather than output it
    * @return mixed
    */
    public function exportData($return = false)
    {
        global $Language;
        $utf8 = SameText(Config("PROJECT_CHARSET"), "utf-8");

        // Load recordset
        $this->TotalRecords = $this->listRecordCount();
        $this->StartRecord = 1;

        // Export all
        if ($this->ExportAll) {
            if (Config("EXPORT_ALL_TIME_LIMIT") >= 0) {
                @set_time_limit(Config("EXPORT_ALL_TIME_LIMIT"));
            }
            $this->DisplayRecords = $this->TotalRecords;
            $this->StopRecord = $this->TotalRecords;
        } else { // Export one page only
            $this->setupStartRecord(); // Set up start record position
            // Set the last record to display
            if ($this->DisplayRecords <= 0) {
                $this->StopRecord = $this->TotalRecords;
            } else {
                $this->StopRecord = $this->StartRecord + $this->DisplayRecords - 1;
            }
        }
        $rs = $this->loadRecordset($this->StartRecord - 1, $this->DisplayRecords <= 0 ? $this->TotalRecords : $this->DisplayRecords);
        $this->ExportDoc = GetExportDocument($this, "h");
        $doc = &$this->ExportDoc;
        if (!$doc) {
            $this->setFailureMessage($Language->phrase("ExportClassNotFound")); // Export class not found
        }
        if (!$rs || !$doc) {
            RemoveHeader("Content-Type"); // Remove header
            RemoveHeader("Content-Disposition");
            $this->showMessage();
            return;
        }
        $this->StartRecord = 1;
        $this->StopRecord = $this->DisplayRecords <= 0 ? $this->TotalRecords : $this->DisplayRecords;

        // Call Page Exporting server event
        $this->ExportDoc->ExportCustom = !$this->pageExporting();
        $header = $this->PageHeader;
        $this->pageDataRendering($header);
        $doc->Text .= $header;
        $this->exportDocument($doc, $rs, $this->StartRecord, $this->StopRecord, "");
        $footer = $this->PageFooter;
        $this->pageDataRendered($footer);
        $doc->Text .= $footer;

        // Close recordset
        $rs->close();

        // Call Page Exported server event
        $this->pageExported();

        // Export header and footer
        $doc->exportHeaderAndFooter();

        // Clean output buffer (without destroying output buffer)
        $buffer = ob_get_contents(); // Save the output buffer
        if (!Config("DEBUG") && $buffer) {
            ob_clean();
        }

        // Write debug message if enabled
        if (Config("DEBUG") && !$this->isExport("pdf")) {
            echo GetDebugMessage();
        }

        // Output data
        if ($this->isExport("email")) {
            // Export-to-email disabled
        } else {
            $doc->export();
            if ($return) {
                RemoveHeader("Content-Type"); // Remove header
                RemoveHeader("Content-Disposition");
                $content = ob_get_contents();
                if ($content) {
                    ob_clean();
                }
                if ($buffer) {
                    echo $buffer; // Resume the output buffer
                }
                return $content;
            }
        }
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $url = preg_replace('/\?cmd=reset(all){0,1}$/i', '', $url); // Remove cmd=reset / cmd=resetall
        $Breadcrumb->add("list", $this->TableVar, $url, "", $this->TableVar, true);
    }

    // Setup lookup options
    public function setupLookupOptions($fld)
    {
        if ($fld->Lookup !== null && $fld->Lookup->Options === null) {
            // Get default connection and filter
            $conn = $this->getConnection();
            $lookupFilter = "";

            // No need to check any more
            $fld->Lookup->Options = [];

            // Set up lookup SQL and connection
            switch ($fld->FieldVar) {
                case "x_Active":
                    break;
                default:
                    $lookupFilter = "";
                    break;
            }

            // Always call to Lookup->getSql so that user can setup Lookup->Options in Lookup_Selecting server event
            $sql = $fld->Lookup->getSql(false, "", $lookupFilter, $this);

            // Set up lookup cache
            if (!$fld->hasLookupOptions() && $fld->UseLookupCache && $sql != "" && count($fld->Lookup->Options) == 0) {
                $totalCnt = $this->getRecordCount($sql, $conn);
                if ($totalCnt > $fld->LookupCacheCount) { // Total count > cache count, do not cache
                    return;
                }
                $rows = $conn->executeQuery($sql)->fetchAll();
                $ar = [];
                foreach ($rows as $row) {
                    $row = $fld->Lookup->renderViewRow($row, Container($fld->Lookup->LinkTable));
                    $ar[strval($row["lf"])] = $row;
                }
                $fld->Lookup->Options = $ar;
            }
        }
    }

    // Set up starting record parameters
    public function setupStartRecord()
    {
        if ($this->DisplayRecords == 0) {
            return;
        }
        if ($this->isPageRequest()) { // Validate request
            $startRec = Get(Config("TABLE_START_REC"));
            $pageNo = Get(Config("TABLE_PAGE_NO"));
            if ($pageNo !== null) { // Check for "pageno" parameter first
                $pageNo = ParseInteger($pageNo);
                if (is_numeric($pageNo)) {
                    $this->StartRecord = ($pageNo - 1) * $this->DisplayRecords + 1;
                    if ($this->StartRecord <= 0) {
                        $this->StartRecord = 1;
                    } elseif ($this->StartRecord >= (int)(($this->TotalRecords - 1) / $this->DisplayRecords) * $this->DisplayRecords + 1) {
                        $this->StartRecord = (int)(($this->TotalRecords - 1) / $this->DisplayRecords) * $this->DisplayRecords + 1;
                    }
                    $this->setStartRecordNumber($this->StartRecord);
                }
            } elseif ($startRec !== null) { // Check for "start" parameter
                $this->StartRecord = $startRec;
                $this->setStartRecordNumber($this->StartRecord);
            }
        }
        $this->StartRecord = $this->getStartRecordNumber();

        // Check if correct start record counter
        if (!is_numeric($this->StartRecord) || $this->StartRecord == "") { // Avoid invalid start record counter
            $this->StartRecord = 1; // Reset start record counter
            $this->setStartRecordNumber($this->StartRecord);
        } elseif ($this->StartRecord > $this->TotalRecords) { // Avoid starting record > total records
            $this->StartRecord = (int)(($this->TotalRecords - 1) / $this->DisplayRecords) * $this->DisplayRecords + 1; // Point to last page first record
            $this->setStartRecordNumber($this->StartRecord);
        } elseif (($this->StartRecord - 1) % $this->DisplayRecords != 0) {
            $this->StartRecord = (int)(($this->StartRecord - 1) / $this->DisplayRecords) * $this->DisplayRecords + 1; // Point to page boundary
            $this->setStartRecordNumber($this->StartRecord);
        }
    }

    // Page Load event
    public function pageLoad()
    {
        //Log("Page Load");
    }

    // Page Unload event
    public function pageUnload()
    {
        //Log("Page Unload");
    }

    // Page Redirecting event
    public function pageRedirecting(&$url)
    {
        // Example:
        //$url = "your URL";
    }

    // Message Showing event
    // $type = ''|'success'|'failure'|'warning'
    public function messageShowing(&$msg, $type)
    {
        if ($type == 'success') {
            //$msg = "your success message";
        } elseif ($type == 'failure') {
            //$msg = "your failure message";
        } elseif ($type == 'warning') {
            //$msg = "your warning message";
        } else {
            //$msg = "your message";
        }
    }

    // Page Render event
    public function pageRender()
    {
        //Log("Page Render");
    }

    // Page Data Rendering event
    public function pageDataRendering(&$header)
    {
        // Example:
        //$header = "your header";
    }

    // Page Data Rendered event
    public function pageDataRendered(&$footer)
    {
        // Example:
        //$footer = "your footer";
    }

    // Form Custom Validate event
    public function formCustomValidate(&$customError)
    {
        // Return error message in $customError
        return true;
    }

    // ListOptions Load event
    public function listOptionsLoad()
    {
        // Example:
        //$opt = &$this->ListOptions->Add("new");
        //$opt->Header = "xxx";
        //$opt->OnLeft = true; // Link on left
        //$opt->MoveTo(0); // Move to first column
    }

    // ListOptions Rendering event
    public function listOptionsRendering()
    {
        //Container("DetailTableGrid")->DetailAdd = (...condition...); // Set to true or false conditionally
        //Container("DetailTableGrid")->DetailEdit = (...condition...); // Set to true or false conditionally
        //Container("DetailTableGrid")->DetailView = (...condition...); // Set to true or false conditionally
    }

    // ListOptions Rendered event
    public function listOptionsRendered()
    {
        // Example:
        //$this->ListOptions["new"]->Body = "xxx";
    }

    // Row Custom Action event
    public function rowCustomAction($action, $row)
    {
        // Return false to abort
        return true;
    }

    // Page Exporting event
    // $this->ExportDoc = export document object
    public function pageExporting()
    {
        //$this->ExportDoc->Text = "my header"; // Export header
        //return false; // Return false to skip default export and use Row_Export event
        return true; // Return true to use default export and skip Row_Export event
    }

    // Row Export event
    // $this->ExportDoc = export document object
    public function rowExport($rs)
    {
        //$this->ExportDoc->Text .= "my content"; // Build HTML with field value: $rs["MyField"] or $this->MyField->ViewValue
    }

    // Page Exported event
    // $this->ExportDoc = export document object
    public function pageExported()
    {
        //$this->ExportDoc->Text .= "my footer"; // Export footer
        //Log($this->ExportDoc->Text);
    }

    // Page Importing event
    public function pageImporting($reader, &$options)
    {
        //var_dump($reader); // Import data reader
        //var_dump($options); // Show all options for importing
        //return false; // Return false to skip import
        return true;
    }

    // Row Import event
    public function rowImport(&$row, $cnt)
    {
        //Log($cnt); // Import record count
        //var_dump($row); // Import row
        //return false; // Return false to skip import
        return true;
    }

    // Page Imported event
    public function pageImported($reader, $results)
    {
        //var_dump($reader); // Import data reader
        //var_dump($results); // Import results
    }
}
