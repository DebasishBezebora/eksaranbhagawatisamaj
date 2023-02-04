<?php

namespace PHPMaker2022\eksbs;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Page class
 */
class LinksAdd extends Links
{
    use MessagesTrait;

    // Page ID
    public $PageID = "add";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'links';

    // Page object name
    public $PageObjName = "LinksAdd";

    // View file path
    public $View = null;

    // Title
    public $Title = null; // Title for <title> tag

    // Rendering View
    public $RenderingView = false;

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

        // Table object (links)
        if (!isset($GLOBALS["links"]) || get_class($GLOBALS["links"]) == PROJECT_NAMESPACE . "links") {
            $GLOBALS["links"] = &$this;
        }

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'links');
        }

        // Start timer
        $DebugTimer = Container("timer");

        // Debug message
        LoadDebugMessage();

        // Open connection
        $GLOBALS["Conn"] = $GLOBALS["Conn"] ?? $this->getConnection();

        // User table object
        $UserTable = Container("usertable");
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
                $tbl = Container("links");
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

            // Handle modal response
            if ($this->IsModal) { // Show as modal
                $row = ["url" => GetUrl($url), "modal" => "1"];
                $pageName = GetPageName($url);
                if ($pageName != $this->getListUrl()) { // Not List page
                    $row["caption"] = $this->getModalCaption($pageName);
                    if ($pageName == "LinksView") {
                        $row["view"] = "1";
                    }
                } else { // List page should not be shown as modal => error
                    $row["error"] = $this->getFailureMessage();
                    $this->clearFailureMessage();
                }
                WriteJson($row);
            } else {
                SaveDebugMessage();
                Redirect(GetUrl($url));
            }
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
		        $this->Photos->OldUploadPath = "files/";
		        $this->Photos->UploadPath = $this->Photos->OldUploadPath;
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
    public $FormClassName = "ew-form ew-add-form";
    public $IsModal = false;
    public $IsMobileOrModal = false;
    public $DbMasterFilter = "";
    public $DbDetailFilter = "";
    public $StartRecord;
    public $Priv = 0;
    public $OldRecordset;
    public $CopyRecord;

    /**
     * Page run
     *
     * @return void
     */
    public function run()
    {
        global $ExportType, $CustomExportType, $ExportFileName, $UserProfile, $Language, $Security, $CurrentForm,
            $SkipHeaderFooter;

        // Is modal
        $this->IsModal = Param("modal") == "1";
        $this->UseLayout = $this->UseLayout && !$this->IsModal;

        // Use layout
        $this->UseLayout = $this->UseLayout && ConvertToBool(Param("layout", true));

        // Create form object
        $CurrentForm = new HttpForm();
        $this->CurrentAction = Param("action"); // Set up current action
        $this->ID->Visible = false;
        $this->Link_Name->setVisibility();
        $this->URL_Slug->setVisibility();
        $this->Link_Content->setVisibility();
        $this->Photos->setVisibility();
        $this->Video_1->setVisibility();
        $this->Video_2->setVisibility();
        $this->Video_3->setVisibility();
        $this->_Title->setVisibility();
        $this->Description->setVisibility();
        $this->Keywords->setVisibility();
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

        // Set up lookup cache
        $this->setupLookupOptions($this->Active);

        // Check modal
        if ($this->IsModal) {
            $SkipHeaderFooter = true;
        }
        $this->IsMobileOrModal = IsMobile() || $this->IsModal;
        $this->FormClassName = "ew-form ew-add-form";
        $postBack = false;

        // Set up current action
        if (IsApi()) {
            $this->CurrentAction = "insert"; // Add record directly
            $postBack = true;
        } elseif (Post("action") !== null) {
            $this->CurrentAction = Post("action"); // Get form action
            $this->setKey(Post($this->OldKeyName));
            $postBack = true;
        } else {
            // Load key values from QueryString
            if (($keyValue = Get("ID") ?? Route("ID")) !== null) {
                $this->ID->setQueryStringValue($keyValue);
            }
            $this->OldKey = $this->getKey(true); // Get from CurrentValue
            $this->CopyRecord = !EmptyValue($this->OldKey);
            if ($this->CopyRecord) {
                $this->CurrentAction = "copy"; // Copy record
            } else {
                $this->CurrentAction = "show"; // Display blank record
            }
        }

        // Load old record / default values
        $loaded = $this->loadOldRecord();

        // Load form values
        if ($postBack) {
            $this->loadFormValues(); // Load form values
        }

        // Validate form if post back
        if ($postBack) {
            if (!$this->validateForm()) {
                $this->EventCancelled = true; // Event cancelled
                $this->restoreFormValues(); // Restore form values
                if (IsApi()) {
                    $this->terminate();
                    return;
                } else {
                    $this->CurrentAction = "show"; // Form error, reset action
                }
            }
        }

        // Perform current action
        switch ($this->CurrentAction) {
            case "copy": // Copy an existing record
                if (!$loaded) { // Record not loaded
                    if ($this->getFailureMessage() == "") {
                        $this->setFailureMessage($Language->phrase("NoRecord")); // No record found
                    }
                    $this->terminate("LinksList"); // No matching record, return to list
                    return;
                }
                break;
            case "insert": // Add new record
                $this->SendEmail = true; // Send email on add success
                if ($this->addRow($this->OldRecordset)) { // Add successful
                    if ($this->getSuccessMessage() == "" && Post("addopt") != "1") { // Skip success message for addopt (done in JavaScript)
                        $this->setSuccessMessage($Language->phrase("AddSuccess")); // Set up success message
                    }
                    $returnUrl = $this->getReturnUrl();
                    if (GetPageName($returnUrl) == "LinksList") {
                        $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                    } elseif (GetPageName($returnUrl) == "LinksView") {
                        $returnUrl = $this->getViewUrl(); // View page, return to View page with keyurl directly
                    }
                    if (IsApi()) { // Return to caller
                        $this->terminate(true);
                        return;
                    } else {
                        $this->terminate($returnUrl);
                        return;
                    }
                } elseif (IsApi()) { // API request, return
                    $this->terminate();
                    return;
                } else {
                    $this->EventCancelled = true; // Event cancelled
                    $this->restoreFormValues(); // Add failed, restore form values
                }
        }

        // Set up Breadcrumb
        $this->setupBreadcrumb();

        // Render row based on row type
        $this->RowType = ROWTYPE_ADD; // Render add type

        // Render row
        $this->resetAttributes();
        $this->renderRow();

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

    // Get upload files
    protected function getUploadFiles()
    {
        global $CurrentForm, $Language;
        $this->Photos->Upload->Index = $CurrentForm->Index;
        $this->Photos->Upload->uploadFile();
        $this->Photos->CurrentValue = $this->Photos->Upload->FileName;
    }

    // Load default values
    protected function loadDefaultValues()
    {
        $this->ID->CurrentValue = null;
        $this->ID->OldValue = $this->ID->CurrentValue;
        $this->Link_Name->CurrentValue = null;
        $this->Link_Name->OldValue = $this->Link_Name->CurrentValue;
        $this->URL_Slug->CurrentValue = null;
        $this->URL_Slug->OldValue = $this->URL_Slug->CurrentValue;
        $this->Link_Content->CurrentValue = null;
        $this->Link_Content->OldValue = $this->Link_Content->CurrentValue;
        $this->Photos->Upload->DbValue = null;
        $this->Photos->OldValue = $this->Photos->Upload->DbValue;
        $this->Photos->CurrentValue = null; // Clear file related field
        $this->Video_1->CurrentValue = null;
        $this->Video_1->OldValue = $this->Video_1->CurrentValue;
        $this->Video_2->CurrentValue = null;
        $this->Video_2->OldValue = $this->Video_2->CurrentValue;
        $this->Video_3->CurrentValue = null;
        $this->Video_3->OldValue = $this->Video_3->CurrentValue;
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

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;
        $validate = !Config("SERVER_VALIDATE");

        // Check field name 'Link_Name' first before field var 'x_Link_Name'
        $val = $CurrentForm->hasValue("Link_Name") ? $CurrentForm->getValue("Link_Name") : $CurrentForm->getValue("x_Link_Name");
        if (!$this->Link_Name->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Link_Name->Visible = false; // Disable update for API request
            } else {
                $this->Link_Name->setFormValue($val);
            }
        }

        // Check field name 'URL_Slug' first before field var 'x_URL_Slug'
        $val = $CurrentForm->hasValue("URL_Slug") ? $CurrentForm->getValue("URL_Slug") : $CurrentForm->getValue("x_URL_Slug");
        if (!$this->URL_Slug->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->URL_Slug->Visible = false; // Disable update for API request
            } else {
                $this->URL_Slug->setFormValue($val);
            }
        }

        // Check field name 'Link_Content' first before field var 'x_Link_Content'
        $val = $CurrentForm->hasValue("Link_Content") ? $CurrentForm->getValue("Link_Content") : $CurrentForm->getValue("x_Link_Content");
        if (!$this->Link_Content->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Link_Content->Visible = false; // Disable update for API request
            } else {
                $this->Link_Content->setFormValue($val);
            }
        }

        // Check field name 'Video_1' first before field var 'x_Video_1'
        $val = $CurrentForm->hasValue("Video_1") ? $CurrentForm->getValue("Video_1") : $CurrentForm->getValue("x_Video_1");
        if (!$this->Video_1->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Video_1->Visible = false; // Disable update for API request
            } else {
                $this->Video_1->setFormValue($val);
            }
        }

        // Check field name 'Video_2' first before field var 'x_Video_2'
        $val = $CurrentForm->hasValue("Video_2") ? $CurrentForm->getValue("Video_2") : $CurrentForm->getValue("x_Video_2");
        if (!$this->Video_2->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Video_2->Visible = false; // Disable update for API request
            } else {
                $this->Video_2->setFormValue($val);
            }
        }

        // Check field name 'Video_3' first before field var 'x_Video_3'
        $val = $CurrentForm->hasValue("Video_3") ? $CurrentForm->getValue("Video_3") : $CurrentForm->getValue("x_Video_3");
        if (!$this->Video_3->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Video_3->Visible = false; // Disable update for API request
            } else {
                $this->Video_3->setFormValue($val);
            }
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

        // Check field name 'Description' first before field var 'x_Description'
        $val = $CurrentForm->hasValue("Description") ? $CurrentForm->getValue("Description") : $CurrentForm->getValue("x_Description");
        if (!$this->Description->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Description->Visible = false; // Disable update for API request
            } else {
                $this->Description->setFormValue($val);
            }
        }

        // Check field name 'Keywords' first before field var 'x_Keywords'
        $val = $CurrentForm->hasValue("Keywords") ? $CurrentForm->getValue("Keywords") : $CurrentForm->getValue("x_Keywords");
        if (!$this->Keywords->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Keywords->Visible = false; // Disable update for API request
            } else {
                $this->Keywords->setFormValue($val);
            }
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

        // Check field name 'Created_BY' first before field var 'x_Created_BY'
        $val = $CurrentForm->hasValue("Created_BY") ? $CurrentForm->getValue("Created_BY") : $CurrentForm->getValue("x_Created_BY");
        if (!$this->Created_BY->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Created_BY->Visible = false; // Disable update for API request
            } else {
                $this->Created_BY->setFormValue($val);
            }
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

        // Check field name 'ID' first before field var 'x_ID'
        $val = $CurrentForm->hasValue("ID") ? $CurrentForm->getValue("ID") : $CurrentForm->getValue("x_ID");
		$this->Photos->OldUploadPath = "files/";
		$this->Photos->UploadPath = $this->Photos->OldUploadPath;
        $this->getUploadFiles(); // Get upload files
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->Link_Name->CurrentValue = $this->Link_Name->FormValue;
        $this->URL_Slug->CurrentValue = $this->URL_Slug->FormValue;
        $this->Link_Content->CurrentValue = $this->Link_Content->FormValue;
        $this->Video_1->CurrentValue = $this->Video_1->FormValue;
        $this->Video_2->CurrentValue = $this->Video_2->FormValue;
        $this->Video_3->CurrentValue = $this->Video_3->FormValue;
        $this->_Title->CurrentValue = $this->_Title->FormValue;
        $this->Description->CurrentValue = $this->Description->FormValue;
        $this->Keywords->CurrentValue = $this->Keywords->FormValue;
        $this->Active->CurrentValue = $this->Active->FormValue;
        $this->Created_AT->CurrentValue = $this->Created_AT->FormValue;
        $this->Created_AT->CurrentValue = UnFormatDateTime($this->Created_AT->CurrentValue, $this->Created_AT->formatPattern());
        $this->Created_BY->CurrentValue = $this->Created_BY->FormValue;
        $this->IP->CurrentValue = $this->IP->FormValue;
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
        $this->Link_Name->setDbValue($row['Link_Name']);
        $this->URL_Slug->setDbValue($row['URL_Slug']);
        $this->Link_Content->setDbValue($row['Link_Content']);
        $this->Photos->Upload->DbValue = $row['Photos'];
        $this->Photos->setDbValue($this->Photos->Upload->DbValue);
        $this->Video_1->setDbValue($row['Video_1']);
        $this->Video_2->setDbValue($row['Video_2']);
        $this->Video_3->setDbValue($row['Video_3']);
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
        $row['Link_Name'] = $this->Link_Name->CurrentValue;
        $row['URL_Slug'] = $this->URL_Slug->CurrentValue;
        $row['Link_Content'] = $this->Link_Content->CurrentValue;
        $row['Photos'] = $this->Photos->Upload->DbValue;
        $row['Video_1'] = $this->Video_1->CurrentValue;
        $row['Video_2'] = $this->Video_2->CurrentValue;
        $row['Video_3'] = $this->Video_3->CurrentValue;
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

        // Call Row_Rendering event
        $this->rowRendering();

        // Common render codes for all row types

        // ID
        $this->ID->RowCssClass = "row";

        // Link_Name
        $this->Link_Name->RowCssClass = "row";

        // URL_Slug
        $this->URL_Slug->RowCssClass = "row";

        // Link_Content
        $this->Link_Content->RowCssClass = "row";

        // Photos
        $this->Photos->RowCssClass = "row";

        // Video_1
        $this->Video_1->RowCssClass = "row";

        // Video_2
        $this->Video_2->RowCssClass = "row";

        // Video_3
        $this->Video_3->RowCssClass = "row";

        // Title
        $this->_Title->RowCssClass = "row";

        // Description
        $this->Description->RowCssClass = "row";

        // Keywords
        $this->Keywords->RowCssClass = "row";

        // Active
        $this->Active->RowCssClass = "row";

        // Created_AT
        $this->Created_AT->RowCssClass = "row";

        // Created_BY
        $this->Created_BY->RowCssClass = "row";

        // IP
        $this->IP->RowCssClass = "row";

        // View row
        if ($this->RowType == ROWTYPE_VIEW) {
            // ID
            $this->ID->ViewValue = $this->ID->CurrentValue;
            $this->ID->ViewCustomAttributes = "";

            // Link_Name
            $this->Link_Name->ViewValue = $this->Link_Name->CurrentValue;
            $this->Link_Name->ViewCustomAttributes = "";

            // URL_Slug
            $this->URL_Slug->ViewValue = $this->URL_Slug->CurrentValue;
            $this->URL_Slug->ViewCustomAttributes = "";

            // Link_Content
            $this->Link_Content->ViewValue = $this->Link_Content->CurrentValue;
            $this->Link_Content->ViewCustomAttributes = "";

            // Photos
            $this->Photos->UploadPath = "files/";
            if (!EmptyValue($this->Photos->Upload->DbValue)) {
                $this->Photos->ViewValue = $this->Photos->Upload->DbValue;
            } else {
                $this->Photos->ViewValue = "";
            }
            $this->Photos->ViewCustomAttributes = "";

            // Video_1
            $this->Video_1->ViewValue = $this->Video_1->CurrentValue;
            $this->Video_1->ViewCustomAttributes = "";

            // Video_2
            $this->Video_2->ViewValue = $this->Video_2->CurrentValue;
            $this->Video_2->ViewCustomAttributes = "";

            // Video_3
            $this->Video_3->ViewValue = $this->Video_3->CurrentValue;
            $this->Video_3->ViewCustomAttributes = "";

            // Title
            $this->_Title->ViewValue = $this->_Title->CurrentValue;
            $this->_Title->ViewCustomAttributes = "";

            // Description
            $this->Description->ViewValue = $this->Description->CurrentValue;
            $this->Description->ViewCustomAttributes = "";

            // Keywords
            $this->Keywords->ViewValue = $this->Keywords->CurrentValue;
            $this->Keywords->ViewCustomAttributes = "";

            // Active
            if (ConvertToBool($this->Active->CurrentValue)) {
                $this->Active->ViewValue = $this->Active->tagCaption(1) != "" ? $this->Active->tagCaption(1) : "Active";
            } else {
                $this->Active->ViewValue = $this->Active->tagCaption(2) != "" ? $this->Active->tagCaption(2) : "Inactive";
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

            // Link_Name
            $this->Link_Name->LinkCustomAttributes = "";
            $this->Link_Name->HrefValue = "";

            // URL_Slug
            $this->URL_Slug->LinkCustomAttributes = "";
            $this->URL_Slug->HrefValue = "";

            // Link_Content
            $this->Link_Content->LinkCustomAttributes = "";
            $this->Link_Content->HrefValue = "";

            // Photos
            $this->Photos->LinkCustomAttributes = "";
            $this->Photos->HrefValue = "";
            $this->Photos->ExportHrefValue = $this->Photos->UploadPath . $this->Photos->Upload->DbValue;

            // Video_1
            $this->Video_1->LinkCustomAttributes = "";
            $this->Video_1->HrefValue = "";

            // Video_2
            $this->Video_2->LinkCustomAttributes = "";
            $this->Video_2->HrefValue = "";

            // Video_3
            $this->Video_3->LinkCustomAttributes = "";
            $this->Video_3->HrefValue = "";

            // Title
            $this->_Title->LinkCustomAttributes = "";
            $this->_Title->HrefValue = "";

            // Description
            $this->Description->LinkCustomAttributes = "";
            $this->Description->HrefValue = "";

            // Keywords
            $this->Keywords->LinkCustomAttributes = "";
            $this->Keywords->HrefValue = "";

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
        } elseif ($this->RowType == ROWTYPE_ADD) {
            // Link_Name
            $this->Link_Name->setupEditAttributes();
            $this->Link_Name->EditCustomAttributes = "";
            if (!$this->Link_Name->Raw) {
                $this->Link_Name->CurrentValue = HtmlDecode($this->Link_Name->CurrentValue);
            }
            $this->Link_Name->EditValue = HtmlEncode($this->Link_Name->CurrentValue);
            $this->Link_Name->PlaceHolder = RemoveHtml($this->Link_Name->caption());

            // URL_Slug
            $this->URL_Slug->setupEditAttributes();
            $this->URL_Slug->EditCustomAttributes = "";
            if (!$this->URL_Slug->Raw) {
                $this->URL_Slug->CurrentValue = HtmlDecode($this->URL_Slug->CurrentValue);
            }
            $this->URL_Slug->EditValue = HtmlEncode($this->URL_Slug->CurrentValue);
            $this->URL_Slug->PlaceHolder = RemoveHtml($this->URL_Slug->caption());

            // Link_Content
            $this->Link_Content->setupEditAttributes();
            $this->Link_Content->EditCustomAttributes = "";
            $this->Link_Content->EditValue = HtmlEncode($this->Link_Content->CurrentValue);
            $this->Link_Content->PlaceHolder = RemoveHtml($this->Link_Content->caption());

            // Photos
            $this->Photos->setupEditAttributes();
            $this->Photos->EditCustomAttributes = "";
            $this->Photos->UploadPath = "files/";
            if (!EmptyValue($this->Photos->Upload->DbValue)) {
                $this->Photos->EditValue = $this->Photos->Upload->DbValue;
            } else {
                $this->Photos->EditValue = "";
            }
            if (!EmptyValue($this->Photos->CurrentValue)) {
                $this->Photos->Upload->FileName = $this->Photos->CurrentValue;
            }
            if ($this->isShow() || $this->isCopy()) {
                RenderUploadField($this->Photos);
            }

            // Video_1
            $this->Video_1->setupEditAttributes();
            $this->Video_1->EditCustomAttributes = "";
            if (!$this->Video_1->Raw) {
                $this->Video_1->CurrentValue = HtmlDecode($this->Video_1->CurrentValue);
            }
            $this->Video_1->EditValue = HtmlEncode($this->Video_1->CurrentValue);
            $this->Video_1->PlaceHolder = RemoveHtml($this->Video_1->caption());

            // Video_2
            $this->Video_2->setupEditAttributes();
            $this->Video_2->EditCustomAttributes = "";
            if (!$this->Video_2->Raw) {
                $this->Video_2->CurrentValue = HtmlDecode($this->Video_2->CurrentValue);
            }
            $this->Video_2->EditValue = HtmlEncode($this->Video_2->CurrentValue);
            $this->Video_2->PlaceHolder = RemoveHtml($this->Video_2->caption());

            // Video_3
            $this->Video_3->setupEditAttributes();
            $this->Video_3->EditCustomAttributes = "";
            if (!$this->Video_3->Raw) {
                $this->Video_3->CurrentValue = HtmlDecode($this->Video_3->CurrentValue);
            }
            $this->Video_3->EditValue = HtmlEncode($this->Video_3->CurrentValue);
            $this->Video_3->PlaceHolder = RemoveHtml($this->Video_3->caption());

            // Title
            $this->_Title->setupEditAttributes();
            $this->_Title->EditCustomAttributes = "";
            if (!$this->_Title->Raw) {
                $this->_Title->CurrentValue = HtmlDecode($this->_Title->CurrentValue);
            }
            $this->_Title->EditValue = HtmlEncode($this->_Title->CurrentValue);
            $this->_Title->PlaceHolder = RemoveHtml($this->_Title->caption());

            // Description
            $this->Description->setupEditAttributes();
            $this->Description->EditCustomAttributes = "";
            $this->Description->EditValue = HtmlEncode($this->Description->CurrentValue);
            $this->Description->PlaceHolder = RemoveHtml($this->Description->caption());

            // Keywords
            $this->Keywords->setupEditAttributes();
            $this->Keywords->EditCustomAttributes = "";
            $this->Keywords->EditValue = HtmlEncode($this->Keywords->CurrentValue);
            $this->Keywords->PlaceHolder = RemoveHtml($this->Keywords->caption());

            // Active
            $this->Active->EditCustomAttributes = "";
            $this->Active->EditValue = $this->Active->options(false);
            $this->Active->PlaceHolder = RemoveHtml($this->Active->caption());

            // Created_AT

            // Created_BY

            // IP

            // Add refer script

            // Link_Name
            $this->Link_Name->LinkCustomAttributes = "";
            $this->Link_Name->HrefValue = "";

            // URL_Slug
            $this->URL_Slug->LinkCustomAttributes = "";
            $this->URL_Slug->HrefValue = "";

            // Link_Content
            $this->Link_Content->LinkCustomAttributes = "";
            $this->Link_Content->HrefValue = "";

            // Photos
            $this->Photos->LinkCustomAttributes = "";
            $this->Photos->HrefValue = "";
            $this->Photos->ExportHrefValue = $this->Photos->UploadPath . $this->Photos->Upload->DbValue;

            // Video_1
            $this->Video_1->LinkCustomAttributes = "";
            $this->Video_1->HrefValue = "";

            // Video_2
            $this->Video_2->LinkCustomAttributes = "";
            $this->Video_2->HrefValue = "";

            // Video_3
            $this->Video_3->LinkCustomAttributes = "";
            $this->Video_3->HrefValue = "";

            // Title
            $this->_Title->LinkCustomAttributes = "";
            $this->_Title->HrefValue = "";

            // Description
            $this->Description->LinkCustomAttributes = "";
            $this->Description->HrefValue = "";

            // Keywords
            $this->Keywords->LinkCustomAttributes = "";
            $this->Keywords->HrefValue = "";

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
        if ($this->Link_Name->Required) {
            if (!$this->Link_Name->IsDetailKey && EmptyValue($this->Link_Name->FormValue)) {
                $this->Link_Name->addErrorMessage(str_replace("%s", $this->Link_Name->caption(), $this->Link_Name->RequiredErrorMessage));
            }
        }
        if ($this->URL_Slug->Required) {
            if (!$this->URL_Slug->IsDetailKey && EmptyValue($this->URL_Slug->FormValue)) {
                $this->URL_Slug->addErrorMessage(str_replace("%s", $this->URL_Slug->caption(), $this->URL_Slug->RequiredErrorMessage));
            }
        }
        if ($this->Link_Content->Required) {
            if (!$this->Link_Content->IsDetailKey && EmptyValue($this->Link_Content->FormValue)) {
                $this->Link_Content->addErrorMessage(str_replace("%s", $this->Link_Content->caption(), $this->Link_Content->RequiredErrorMessage));
            }
        }
        if ($this->Photos->Required) {
            if ($this->Photos->Upload->FileName == "" && !$this->Photos->Upload->KeepFile) {
                $this->Photos->addErrorMessage(str_replace("%s", $this->Photos->caption(), $this->Photos->RequiredErrorMessage));
            }
        }
        if ($this->Video_1->Required) {
            if (!$this->Video_1->IsDetailKey && EmptyValue($this->Video_1->FormValue)) {
                $this->Video_1->addErrorMessage(str_replace("%s", $this->Video_1->caption(), $this->Video_1->RequiredErrorMessage));
            }
        }
        if ($this->Video_2->Required) {
            if (!$this->Video_2->IsDetailKey && EmptyValue($this->Video_2->FormValue)) {
                $this->Video_2->addErrorMessage(str_replace("%s", $this->Video_2->caption(), $this->Video_2->RequiredErrorMessage));
            }
        }
        if ($this->Video_3->Required) {
            if (!$this->Video_3->IsDetailKey && EmptyValue($this->Video_3->FormValue)) {
                $this->Video_3->addErrorMessage(str_replace("%s", $this->Video_3->caption(), $this->Video_3->RequiredErrorMessage));
            }
        }
        if ($this->_Title->Required) {
            if (!$this->_Title->IsDetailKey && EmptyValue($this->_Title->FormValue)) {
                $this->_Title->addErrorMessage(str_replace("%s", $this->_Title->caption(), $this->_Title->RequiredErrorMessage));
            }
        }
        if ($this->Description->Required) {
            if (!$this->Description->IsDetailKey && EmptyValue($this->Description->FormValue)) {
                $this->Description->addErrorMessage(str_replace("%s", $this->Description->caption(), $this->Description->RequiredErrorMessage));
            }
        }
        if ($this->Keywords->Required) {
            if (!$this->Keywords->IsDetailKey && EmptyValue($this->Keywords->FormValue)) {
                $this->Keywords->addErrorMessage(str_replace("%s", $this->Keywords->caption(), $this->Keywords->RequiredErrorMessage));
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

    // Add record
    protected function addRow($rsold = null)
    {
        global $Language, $Security;
        if ($this->URL_Slug->CurrentValue != "") { // Check field with unique index
            $filter = "(`URL_Slug` = '" . AdjustSql($this->URL_Slug->CurrentValue, $this->Dbid) . "')";
            $rsChk = $this->loadRs($filter)->fetch();
            if ($rsChk !== false) {
                $idxErrMsg = str_replace("%f", $this->URL_Slug->caption(), $Language->phrase("DupIndex"));
                $idxErrMsg = str_replace("%v", $this->URL_Slug->CurrentValue, $idxErrMsg);
                $this->setFailureMessage($idxErrMsg);
                return false;
            }
        }
        $conn = $this->getConnection();

        // Load db values from rsold
        $this->loadDbValues($rsold);
        if ($rsold) {
            $this->Photos->OldUploadPath = "files/";
            $this->Photos->UploadPath = $this->Photos->OldUploadPath;
        }
        $rsnew = [];

        // Link_Name
        $this->Link_Name->setDbValueDef($rsnew, $this->Link_Name->CurrentValue, "", false);

        // URL_Slug
        $this->URL_Slug->setDbValueDef($rsnew, $this->URL_Slug->CurrentValue, "", false);

        // Link_Content
        $this->Link_Content->setDbValueDef($rsnew, $this->Link_Content->CurrentValue, "", false);

        // Photos
        if ($this->Photos->Visible && !$this->Photos->Upload->KeepFile) {
            $this->Photos->Upload->DbValue = ""; // No need to delete old file
            if ($this->Photos->Upload->FileName == "") {
                $rsnew['Photos'] = null;
            } else {
                $rsnew['Photos'] = $this->Photos->Upload->FileName;
            }
        }

        // Video_1
        $this->Video_1->setDbValueDef($rsnew, $this->Video_1->CurrentValue, null, false);

        // Video_2
        $this->Video_2->setDbValueDef($rsnew, $this->Video_2->CurrentValue, null, false);

        // Video_3
        $this->Video_3->setDbValueDef($rsnew, $this->Video_3->CurrentValue, null, false);

        // Title
        $this->_Title->setDbValueDef($rsnew, $this->_Title->CurrentValue, "", false);

        // Description
        $this->Description->setDbValueDef($rsnew, $this->Description->CurrentValue, null, false);

        // Keywords
        $this->Keywords->setDbValueDef($rsnew, $this->Keywords->CurrentValue, null, false);

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
        if ($this->Photos->Visible && !$this->Photos->Upload->KeepFile) {
            $this->Photos->UploadPath = "files/";
            $oldFiles = EmptyValue($this->Photos->Upload->DbValue) ? [] : explode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $this->Photos->htmlDecode(strval($this->Photos->Upload->DbValue)));
            if (!EmptyValue($this->Photos->Upload->FileName)) {
                $newFiles = explode(Config("MULTIPLE_UPLOAD_SEPARATOR"), strval($this->Photos->Upload->FileName));
                $NewFileCount = count($newFiles);
                for ($i = 0; $i < $NewFileCount; $i++) {
                    if ($newFiles[$i] != "") {
                        $file = $newFiles[$i];
                        $tempPath = UploadTempPath($this->Photos, $this->Photos->Upload->Index);
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
                            $file1 = UniqueFilename($this->Photos->physicalUploadPath(), $file); // Get new file name
                            if ($file1 != $file) { // Rename temp file
                                while (file_exists($tempPath . $file1) || file_exists($this->Photos->physicalUploadPath() . $file1)) { // Make sure no file name clash
                                    $file1 = UniqueFilename([$this->Photos->physicalUploadPath(), $tempPath], $file1, true); // Use indexed name
                                }
                                rename($tempPath . $file, $tempPath . $file1);
                                $newFiles[$i] = $file1;
                            }
                        }
                    }
                }
                $this->Photos->Upload->DbValue = empty($oldFiles) ? "" : implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $oldFiles);
                $this->Photos->Upload->FileName = implode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $newFiles);
                $this->Photos->setDbValueDef($rsnew, $this->Photos->Upload->FileName, null, false);
            }
        }

        // Call Row Inserting event
        $insertRow = $this->rowInserting($rsold, $rsnew);
        if ($insertRow) {
            $addRow = $this->insert($rsnew);
            if ($addRow) {
                if ($this->Photos->Visible && !$this->Photos->Upload->KeepFile) {
                    $oldFiles = EmptyValue($this->Photos->Upload->DbValue) ? [] : explode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $this->Photos->htmlDecode(strval($this->Photos->Upload->DbValue)));
                    if (!EmptyValue($this->Photos->Upload->FileName)) {
                        $newFiles = explode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $this->Photos->Upload->FileName);
                        $newFiles2 = explode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $this->Photos->htmlDecode($rsnew['Photos']));
                        $newFileCount = count($newFiles);
                        for ($i = 0; $i < $newFileCount; $i++) {
                            if ($newFiles[$i] != "") {
                                $file = UploadTempPath($this->Photos, $this->Photos->Upload->Index) . $newFiles[$i];
                                if (file_exists($file)) {
                                    if (@$newFiles2[$i] != "") { // Use correct file name
                                        $newFiles[$i] = $newFiles2[$i];
                                    }
                                    if (!$this->Photos->Upload->SaveToFile($newFiles[$i], true, $i)) { // Just replace
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
                                @unlink($this->Photos->oldPhysicalUploadPath() . $oldFile);
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
            // Photos
            CleanUploadTempPath($this->Photos, $this->Photos->Upload->Index);
        }

        // Write JSON for API request
        if (IsApi() && $addRow) {
            $row = $this->getRecordsFromRecordset([$rsnew], true);
            WriteJson(["success" => true, $this->TableVar => $row]);
        }
        return $addRow;
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("LinksList"), "", $this->TableVar, true);
        $pageId = ($this->isCopy()) ? "Copy" : "Add";
        $Breadcrumb->add("add", $pageId, $url);
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
}
