<?php

namespace PHPMaker2022\eksbs;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Page class
 */
class PhotoGalleriesEdit extends PhotoGalleries
{
    use MessagesTrait;

    // Page ID
    public $PageID = "edit";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'photo_galleries';

    // Page object name
    public $PageObjName = "PhotoGalleriesEdit";

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

        // Table object (photo_galleries)
        if (!isset($GLOBALS["photo_galleries"]) || get_class($GLOBALS["photo_galleries"]) == PROJECT_NAMESPACE . "photo_galleries") {
            $GLOBALS["photo_galleries"] = &$this;
        }

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'photo_galleries');
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
                $tbl = Container("photo_galleries");
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
                    if ($pageName == "PhotoGalleriesView") {
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

    // Properties
    public $FormClassName = "ew-form ew-edit-form";
    public $IsModal = false;
    public $IsMobileOrModal = false;
    public $DbMasterFilter;
    public $DbDetailFilter;
    public $HashValue; // Hash Value
    public $DisplayRecords = 1;
    public $StartRecord;
    public $StopRecord;
    public $TotalRecords = 0;
    public $RecordRange = 10;
    public $RecordCount;

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
        $this->ID->setVisibility();
        $this->Album_Name->setVisibility();
        $this->_Title->setVisibility();
        $this->Slug->setVisibility();
        $this->Photos->setVisibility();
        $this->Active->setVisibility();
        $this->Sort_Order->setVisibility();
        $this->Description->setVisibility();
        $this->Keywords->setVisibility();
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
        $this->FormClassName = "ew-form ew-edit-form";
        $loaded = false;
        $postBack = false;

        // Set up current action and primary key
        if (IsApi()) {
            // Load key values
            $loaded = true;
            if (($keyValue = Get("ID") ?? Key(0) ?? Route(2)) !== null) {
                $this->ID->setQueryStringValue($keyValue);
                $this->ID->setOldValue($this->ID->QueryStringValue);
            } elseif (Post("ID") !== null) {
                $this->ID->setFormValue(Post("ID"));
                $this->ID->setOldValue($this->ID->FormValue);
            } else {
                $loaded = false; // Unable to load key
            }

            // Load record
            if ($loaded) {
                $loaded = $this->loadRow();
            }
            if (!$loaded) {
                $this->setFailureMessage($Language->phrase("NoRecord")); // Set no record message
                $this->terminate();
                return;
            }
            $this->CurrentAction = "update"; // Update record directly
            $this->OldKey = $this->getKey(true); // Get from CurrentValue
            $postBack = true;
        } else {
            if (Post("action") !== null) {
                $this->CurrentAction = Post("action"); // Get action code
                if (!$this->isShow()) { // Not reload record, handle as postback
                    $postBack = true;
                }

                // Get key from Form
                $this->setKey(Post($this->OldKeyName), $this->isShow());
            } else {
                $this->CurrentAction = "show"; // Default action is display

                // Load key from QueryString
                $loadByQuery = false;
                if (($keyValue = Get("ID") ?? Route("ID")) !== null) {
                    $this->ID->setQueryStringValue($keyValue);
                    $loadByQuery = true;
                } else {
                    $this->ID->CurrentValue = null;
                }
            }

            // Load recordset
            if ($this->isShow()) {
                    // Load current record
                    $loaded = $this->loadRow();
                $this->OldKey = $loaded ? $this->getKey(true) : ""; // Get from CurrentValue
            }
        }

        // Process form if post back
        if ($postBack) {
            $this->loadFormValues(); // Get form values
        }

        // Validate form if post back
        if ($postBack) {
            if (!$this->validateForm()) {
                $this->EventCancelled = true; // Event cancelled
                $this->restoreFormValues();
                if (IsApi()) {
                    $this->terminate();
                    return;
                } else {
                    $this->CurrentAction = ""; // Form error, reset action
                }
            }
        }

        // Perform current action
        switch ($this->CurrentAction) {
            case "show": // Get a record to display
                    if (!$loaded) { // Load record based on key
                        if ($this->getFailureMessage() == "") {
                            $this->setFailureMessage($Language->phrase("NoRecord")); // No record found
                        }
                        $this->terminate("PhotoGalleriesList"); // No matching record, return to list
                        return;
                    }
                break;
            case "update": // Update
                $returnUrl = $this->getReturnUrl();
                if (GetPageName($returnUrl) == "PhotoGalleriesList") {
                    $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                }
                $this->SendEmail = true; // Send email on update success
                if ($this->editRow()) { // Update record based on key
                    if ($this->getSuccessMessage() == "") {
                        $this->setSuccessMessage($Language->phrase("UpdateSuccess")); // Update success
                    }
                    if (IsApi()) {
                        $this->terminate(true);
                        return;
                    } else {
                        $this->terminate($returnUrl); // Return to caller
                        return;
                    }
                } elseif (IsApi()) { // API request, return
                    $this->terminate();
                    return;
                } elseif ($this->getFailureMessage() == $Language->phrase("NoRecord")) {
                    $this->terminate($returnUrl); // Return to caller
                    return;
                } else {
                    $this->EventCancelled = true; // Event cancelled
                    $this->restoreFormValues(); // Restore form values if update failed
                }
        }

        // Set up Breadcrumb
        $this->setupBreadcrumb();

        // Render the record
        $this->RowType = ROWTYPE_EDIT; // Render as Edit
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

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;
        $validate = !Config("SERVER_VALIDATE");

        // Check field name 'ID' first before field var 'x_ID'
        $val = $CurrentForm->hasValue("ID") ? $CurrentForm->getValue("ID") : $CurrentForm->getValue("x_ID");
        if (!$this->ID->IsDetailKey) {
            $this->ID->setFormValue($val);
        }

        // Check field name 'Album_Name' first before field var 'x_Album_Name'
        $val = $CurrentForm->hasValue("Album_Name") ? $CurrentForm->getValue("Album_Name") : $CurrentForm->getValue("x_Album_Name");
        if (!$this->Album_Name->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Album_Name->Visible = false; // Disable update for API request
            } else {
                $this->Album_Name->setFormValue($val);
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

        // Check field name 'Slug' first before field var 'x_Slug'
        $val = $CurrentForm->hasValue("Slug") ? $CurrentForm->getValue("Slug") : $CurrentForm->getValue("x_Slug");
        if (!$this->Slug->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Slug->Visible = false; // Disable update for API request
            } else {
                $this->Slug->setFormValue($val);
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

        // Check field name 'Sort_Order' first before field var 'x_Sort_Order'
        $val = $CurrentForm->hasValue("Sort_Order") ? $CurrentForm->getValue("Sort_Order") : $CurrentForm->getValue("x_Sort_Order");
        if (!$this->Sort_Order->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->Sort_Order->Visible = false; // Disable update for API request
            } else {
                $this->Sort_Order->setFormValue($val, true, $validate);
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
        $this->getUploadFiles(); // Get upload files
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->ID->CurrentValue = $this->ID->FormValue;
        $this->Album_Name->CurrentValue = $this->Album_Name->FormValue;
        $this->_Title->CurrentValue = $this->_Title->FormValue;
        $this->Slug->CurrentValue = $this->Slug->FormValue;
        $this->Active->CurrentValue = $this->Active->FormValue;
        $this->Sort_Order->CurrentValue = $this->Sort_Order->FormValue;
        $this->Description->CurrentValue = $this->Description->FormValue;
        $this->Keywords->CurrentValue = $this->Keywords->FormValue;
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
        $this->Album_Name->setDbValue($row['Album_Name']);
        $this->_Title->setDbValue($row['Title']);
        $this->Slug->setDbValue($row['Slug']);
        $this->Photos->Upload->DbValue = $row['Photos'];
        $this->Photos->setDbValue($this->Photos->Upload->DbValue);
        $this->Active->setDbValue($row['Active']);
        $this->Sort_Order->setDbValue($row['Sort_Order']);
        $this->Description->setDbValue($row['Description']);
        $this->Keywords->setDbValue($row['Keywords']);
        $this->Created_AT->setDbValue($row['Created_AT']);
        $this->Created_BY->setDbValue($row['Created_BY']);
        $this->IP->setDbValue($row['IP']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['ID'] = null;
        $row['Album_Name'] = null;
        $row['Title'] = null;
        $row['Slug'] = null;
        $row['Photos'] = null;
        $row['Active'] = null;
        $row['Sort_Order'] = null;
        $row['Description'] = null;
        $row['Keywords'] = null;
        $row['Created_AT'] = null;
        $row['Created_BY'] = null;
        $row['IP'] = null;
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

        // Album_Name
        $this->Album_Name->RowCssClass = "row";

        // Title
        $this->_Title->RowCssClass = "row";

        // Slug
        $this->Slug->RowCssClass = "row";

        // Photos
        $this->Photos->RowCssClass = "row";

        // Active
        $this->Active->RowCssClass = "row";

        // Sort_Order
        $this->Sort_Order->RowCssClass = "row";

        // Description
        $this->Description->RowCssClass = "row";

        // Keywords
        $this->Keywords->RowCssClass = "row";

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

            // Album_Name
            $this->Album_Name->ViewValue = $this->Album_Name->CurrentValue;
            $this->Album_Name->ViewCustomAttributes = "";

            // Title
            $this->_Title->ViewValue = $this->_Title->CurrentValue;
            $this->_Title->ViewCustomAttributes = "";

            // Slug
            $this->Slug->ViewValue = $this->Slug->CurrentValue;
            $this->Slug->ViewCustomAttributes = "";

            // Photos
            if (!EmptyValue($this->Photos->Upload->DbValue)) {
                $this->Photos->ViewValue = $this->Photos->Upload->DbValue;
            } else {
                $this->Photos->ViewValue = "";
            }
            $this->Photos->ViewCustomAttributes = "";

            // Active
            if (ConvertToBool($this->Active->CurrentValue)) {
                $this->Active->ViewValue = $this->Active->tagCaption(1) != "" ? $this->Active->tagCaption(1) : "Active";
            } else {
                $this->Active->ViewValue = $this->Active->tagCaption(2) != "" ? $this->Active->tagCaption(2) : "Inactive";
            }
            $this->Active->ViewCustomAttributes = "";

            // Sort_Order
            $this->Sort_Order->ViewValue = $this->Sort_Order->CurrentValue;
            $this->Sort_Order->ViewValue = FormatNumber($this->Sort_Order->ViewValue, $this->Sort_Order->formatPattern());
            $this->Sort_Order->ViewCustomAttributes = "";

            // Description
            $this->Description->ViewValue = $this->Description->CurrentValue;
            $this->Description->ViewCustomAttributes = "";

            // Keywords
            $this->Keywords->ViewValue = $this->Keywords->CurrentValue;
            $this->Keywords->ViewCustomAttributes = "";

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

            // Album_Name
            $this->Album_Name->LinkCustomAttributes = "";
            $this->Album_Name->HrefValue = "";

            // Title
            $this->_Title->LinkCustomAttributes = "";
            $this->_Title->HrefValue = "";

            // Slug
            $this->Slug->LinkCustomAttributes = "";
            $this->Slug->HrefValue = "";

            // Photos
            $this->Photos->LinkCustomAttributes = "";
            $this->Photos->HrefValue = "";
            $this->Photos->ExportHrefValue = $this->Photos->UploadPath . $this->Photos->Upload->DbValue;

            // Active
            $this->Active->LinkCustomAttributes = "";
            $this->Active->HrefValue = "";

            // Sort_Order
            $this->Sort_Order->LinkCustomAttributes = "";
            $this->Sort_Order->HrefValue = "";

            // Description
            $this->Description->LinkCustomAttributes = "";
            $this->Description->HrefValue = "";

            // Keywords
            $this->Keywords->LinkCustomAttributes = "";
            $this->Keywords->HrefValue = "";

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

            // Album_Name
            $this->Album_Name->setupEditAttributes();
            $this->Album_Name->EditCustomAttributes = "";
            if (!$this->Album_Name->Raw) {
                $this->Album_Name->CurrentValue = HtmlDecode($this->Album_Name->CurrentValue);
            }
            $this->Album_Name->EditValue = HtmlEncode($this->Album_Name->CurrentValue);
            $this->Album_Name->PlaceHolder = RemoveHtml($this->Album_Name->caption());

            // Title
            $this->_Title->setupEditAttributes();
            $this->_Title->EditCustomAttributes = "";
            if (!$this->_Title->Raw) {
                $this->_Title->CurrentValue = HtmlDecode($this->_Title->CurrentValue);
            }
            $this->_Title->EditValue = HtmlEncode($this->_Title->CurrentValue);
            $this->_Title->PlaceHolder = RemoveHtml($this->_Title->caption());

            // Slug
            $this->Slug->setupEditAttributes();
            $this->Slug->EditCustomAttributes = "";
            if (!$this->Slug->Raw) {
                $this->Slug->CurrentValue = HtmlDecode($this->Slug->CurrentValue);
            }
            $this->Slug->EditValue = HtmlEncode($this->Slug->CurrentValue);
            $this->Slug->PlaceHolder = RemoveHtml($this->Slug->caption());

            // Photos
            $this->Photos->setupEditAttributes();
            $this->Photos->EditCustomAttributes = "";
            if (!EmptyValue($this->Photos->Upload->DbValue)) {
                $this->Photos->EditValue = $this->Photos->Upload->DbValue;
            } else {
                $this->Photos->EditValue = "";
            }
            if (!EmptyValue($this->Photos->CurrentValue)) {
                $this->Photos->Upload->FileName = $this->Photos->CurrentValue;
            }
            if ($this->isShow()) {
                RenderUploadField($this->Photos);
            }

            // Active
            $this->Active->EditCustomAttributes = "";
            $this->Active->EditValue = $this->Active->options(false);
            $this->Active->PlaceHolder = RemoveHtml($this->Active->caption());

            // Sort_Order
            $this->Sort_Order->setupEditAttributes();
            $this->Sort_Order->EditCustomAttributes = "";
            $this->Sort_Order->EditValue = HtmlEncode($this->Sort_Order->CurrentValue);
            $this->Sort_Order->PlaceHolder = RemoveHtml($this->Sort_Order->caption());
            if (strval($this->Sort_Order->EditValue) != "" && is_numeric($this->Sort_Order->EditValue)) {
                $this->Sort_Order->EditValue = FormatNumber($this->Sort_Order->EditValue, null);
            }

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

            // Created_AT

            // Created_BY

            // IP

            // Edit refer script

            // ID
            $this->ID->LinkCustomAttributes = "";
            $this->ID->HrefValue = "";

            // Album_Name
            $this->Album_Name->LinkCustomAttributes = "";
            $this->Album_Name->HrefValue = "";

            // Title
            $this->_Title->LinkCustomAttributes = "";
            $this->_Title->HrefValue = "";

            // Slug
            $this->Slug->LinkCustomAttributes = "";
            $this->Slug->HrefValue = "";

            // Photos
            $this->Photos->LinkCustomAttributes = "";
            $this->Photos->HrefValue = "";
            $this->Photos->ExportHrefValue = $this->Photos->UploadPath . $this->Photos->Upload->DbValue;

            // Active
            $this->Active->LinkCustomAttributes = "";
            $this->Active->HrefValue = "";

            // Sort_Order
            $this->Sort_Order->LinkCustomAttributes = "";
            $this->Sort_Order->HrefValue = "";

            // Description
            $this->Description->LinkCustomAttributes = "";
            $this->Description->HrefValue = "";

            // Keywords
            $this->Keywords->LinkCustomAttributes = "";
            $this->Keywords->HrefValue = "";

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
        if ($this->Album_Name->Required) {
            if (!$this->Album_Name->IsDetailKey && EmptyValue($this->Album_Name->FormValue)) {
                $this->Album_Name->addErrorMessage(str_replace("%s", $this->Album_Name->caption(), $this->Album_Name->RequiredErrorMessage));
            }
        }
        if ($this->_Title->Required) {
            if (!$this->_Title->IsDetailKey && EmptyValue($this->_Title->FormValue)) {
                $this->_Title->addErrorMessage(str_replace("%s", $this->_Title->caption(), $this->_Title->RequiredErrorMessage));
            }
        }
        if ($this->Slug->Required) {
            if (!$this->Slug->IsDetailKey && EmptyValue($this->Slug->FormValue)) {
                $this->Slug->addErrorMessage(str_replace("%s", $this->Slug->caption(), $this->Slug->RequiredErrorMessage));
            }
        }
        if ($this->Photos->Required) {
            if ($this->Photos->Upload->FileName == "" && !$this->Photos->Upload->KeepFile) {
                $this->Photos->addErrorMessage(str_replace("%s", $this->Photos->caption(), $this->Photos->RequiredErrorMessage));
            }
        }
        if ($this->Active->Required) {
            if ($this->Active->FormValue == "") {
                $this->Active->addErrorMessage(str_replace("%s", $this->Active->caption(), $this->Active->RequiredErrorMessage));
            }
        }
        if ($this->Sort_Order->Required) {
            if (!$this->Sort_Order->IsDetailKey && EmptyValue($this->Sort_Order->FormValue)) {
                $this->Sort_Order->addErrorMessage(str_replace("%s", $this->Sort_Order->caption(), $this->Sort_Order->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->Sort_Order->FormValue)) {
            $this->Sort_Order->addErrorMessage($this->Sort_Order->getErrorMessage(false));
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
            $rsnew = [];

            // Album_Name
            $this->Album_Name->setDbValueDef($rsnew, $this->Album_Name->CurrentValue, "", $this->Album_Name->ReadOnly);

            // Title
            $this->_Title->setDbValueDef($rsnew, $this->_Title->CurrentValue, "", $this->_Title->ReadOnly);

            // Slug
            $this->Slug->setDbValueDef($rsnew, $this->Slug->CurrentValue, "", $this->Slug->ReadOnly);

            // Photos
            if ($this->Photos->Visible && !$this->Photos->ReadOnly && !$this->Photos->Upload->KeepFile) {
                $this->Photos->Upload->DbValue = $rsold['Photos']; // Get original value
                if ($this->Photos->Upload->FileName == "") {
                    $rsnew['Photos'] = null;
                } else {
                    $rsnew['Photos'] = $this->Photos->Upload->FileName;
                }
            }

            // Active
            $this->Active->setDbValueDef($rsnew, strval($this->Active->CurrentValue) == "1" ? "1" : "0", 0, $this->Active->ReadOnly);

            // Sort_Order
            $this->Sort_Order->setDbValueDef($rsnew, $this->Sort_Order->CurrentValue, 0, $this->Sort_Order->ReadOnly);

            // Description
            $this->Description->setDbValueDef($rsnew, $this->Description->CurrentValue, null, $this->Description->ReadOnly);

            // Keywords
            $this->Keywords->setDbValueDef($rsnew, $this->Keywords->CurrentValue, null, $this->Keywords->ReadOnly);

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
                    $this->Photos->setDbValueDef($rsnew, $this->Photos->Upload->FileName, "", $this->Photos->ReadOnly);
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
            // Photos
            CleanUploadTempPath($this->Photos, $this->Photos->Upload->Index);
        }

        // Write JSON for API request
        if (IsApi() && $editRow) {
            $row = $this->getRecordsFromRecordset([$rsnew], true);
            WriteJson(["success" => true, $this->TableVar => $row]);
        }
        return $editRow;
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("PhotoGalleriesList"), "", $this->TableVar, true);
        $pageId = "edit";
        $Breadcrumb->add("edit", $pageId, $url);
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
}
