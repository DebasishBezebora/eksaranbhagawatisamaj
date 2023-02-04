<?php

namespace PHPMaker2022\eksbs;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Page class
 */
class LinksSearch extends Links
{
    use MessagesTrait;

    // Page ID
    public $PageID = "search";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'links';

    // Page object name
    public $PageObjName = "LinksSearch";

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
    public $FormClassName = "ew-form ew-search-form";
    public $IsModal = false;
    public $IsMobileOrModal = false;

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

        // Set up Breadcrumb
        $this->setupBreadcrumb();

        // Check modal
        if ($this->IsModal) {
            $SkipHeaderFooter = true;
        }
        $this->IsMobileOrModal = IsMobile() || $this->IsModal;
        if ($this->isPageRequest()) {
            // Get action
            $this->CurrentAction = Post("action");
            if ($this->isSearch()) {
                // Build search string for advanced search, remove blank field
                $this->loadSearchValues(); // Get search values
                if ($this->validateSearch()) {
                    $srchStr = $this->buildAdvancedSearch();
                } else {
                    $srchStr = "";
                }
                if ($srchStr != "") {
                    $srchStr = $this->getUrlParm($srchStr);
                    $srchStr = "LinksList" . "?" . $srchStr;
                    $this->terminate($srchStr); // Go to list page
                    return;
                }
            }
        }

        // Restore search settings from Session
        if (!$this->hasInvalidFields()) {
            $this->loadAdvancedSearch();
        }

        // Render row for search
        $this->RowType = ROWTYPE_SEARCH;
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

    // Build advanced search
    protected function buildAdvancedSearch()
    {
        $srchUrl = "";
        $this->buildSearchUrl($srchUrl, $this->ID); // ID
        $this->buildSearchUrl($srchUrl, $this->Link_Name); // Link_Name
        $this->buildSearchUrl($srchUrl, $this->URL_Slug); // URL_Slug
        $this->buildSearchUrl($srchUrl, $this->Link_Content); // Link_Content
        $this->buildSearchUrl($srchUrl, $this->Photos); // Photos
        $this->buildSearchUrl($srchUrl, $this->Video_1); // Video_1
        $this->buildSearchUrl($srchUrl, $this->Video_2); // Video_2
        $this->buildSearchUrl($srchUrl, $this->Video_3); // Video_3
        $this->buildSearchUrl($srchUrl, $this->_Title); // Title
        $this->buildSearchUrl($srchUrl, $this->Description); // Description
        $this->buildSearchUrl($srchUrl, $this->Keywords); // Keywords
        $this->buildSearchUrl($srchUrl, $this->Active); // Active
        $this->buildSearchUrl($srchUrl, $this->Created_AT); // Created_AT
        $this->buildSearchUrl($srchUrl, $this->Created_BY); // Created_BY
        $this->buildSearchUrl($srchUrl, $this->IP); // IP
        if ($srchUrl != "") {
            $srchUrl .= "&";
        }
        $srchUrl .= "cmd=search";
        return $srchUrl;
    }

    // Build search URL
    protected function buildSearchUrl(&$url, &$fld, $oprOnly = false)
    {
        global $CurrentForm;
        $wrk = "";
        $fldParm = $fld->Param;
        $fldVal = $CurrentForm->getValue("x_$fldParm");
        $fldOpr = $CurrentForm->getValue("z_$fldParm");
        $fldCond = $CurrentForm->getValue("v_$fldParm");
        $fldVal2 = $CurrentForm->getValue("y_$fldParm");
        $fldOpr2 = $CurrentForm->getValue("w_$fldParm");
        if (is_array($fldVal)) {
            $fldVal = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $fldVal);
        }
        if (is_array($fldVal2)) {
            $fldVal2 = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $fldVal2);
        }
        $fldOpr = strtoupper(trim($fldOpr));
        $fldDataType = ($fld->IsVirtual) ? DATATYPE_STRING : $fld->DataType;
        if ($fldOpr == "BETWEEN") {
            $isValidValue = ($fldDataType != DATATYPE_NUMBER) ||
                ($fldDataType == DATATYPE_NUMBER && $this->searchValueIsNumeric($fld, $fldVal) && $this->searchValueIsNumeric($fld, $fldVal2));
            if ($fldVal != "" && $fldVal2 != "" && $isValidValue) {
                $wrk = "x_" . $fldParm . "=" . urlencode($fldVal) .
                    "&y_" . $fldParm . "=" . urlencode($fldVal2) .
                    "&z_" . $fldParm . "=" . urlencode($fldOpr);
            }
        } else {
            $isValidValue = ($fldDataType != DATATYPE_NUMBER) ||
                ($fldDataType == DATATYPE_NUMBER && $this->searchValueIsNumeric($fld, $fldVal));
            if ($fldVal != "" && $isValidValue && IsValidOperator($fldOpr, $fldDataType)) {
                $wrk = "x_" . $fldParm . "=" . urlencode($fldVal) .
                    "&z_" . $fldParm . "=" . urlencode($fldOpr);
            } elseif ($fldOpr == "IS NULL" || $fldOpr == "IS NOT NULL" || ($fldOpr != "" && $oprOnly && IsValidOperator($fldOpr, $fldDataType))) {
                $wrk = "z_" . $fldParm . "=" . urlencode($fldOpr);
            }
            $isValidValue = ($fldDataType != DATATYPE_NUMBER) ||
                ($fldDataType == DATATYPE_NUMBER && $this->searchValueIsNumeric($fld, $fldVal2));
            if ($fldVal2 != "" && $isValidValue && IsValidOperator($fldOpr2, $fldDataType)) {
                if ($wrk != "") {
                    $wrk .= "&v_" . $fldParm . "=" . urlencode($fldCond) . "&";
                }
                $wrk .= "y_" . $fldParm . "=" . urlencode($fldVal2) .
                    "&w_" . $fldParm . "=" . urlencode($fldOpr2);
            } elseif ($fldOpr2 == "IS NULL" || $fldOpr2 == "IS NOT NULL" || ($fldOpr2 != "" && $oprOnly && IsValidOperator($fldOpr2, $fldDataType))) {
                if ($wrk != "") {
                    $wrk .= "&v_" . $fldParm . "=" . urlencode($fldCond) . "&";
                }
                $wrk .= "w_" . $fldParm . "=" . urlencode($fldOpr2);
            }
        }
        if ($wrk != "") {
            if ($url != "") {
                $url .= "&";
            }
            $url .= $wrk;
        }
    }

    // Check if search value is numeric
    protected function searchValueIsNumeric($fld, $value)
    {
        if (IsFloatFormat($fld->Type)) {
            $value = ConvertToFloatString($value);
        }
        return is_numeric($value);
    }

    // Load search values for validation
    protected function loadSearchValues()
    {
        // Load search values
        $hasValue = false;

        // ID
        if ($this->ID->AdvancedSearch->get()) {
            $hasValue = true;
        }

        // Link_Name
        if ($this->Link_Name->AdvancedSearch->get()) {
            $hasValue = true;
        }

        // URL_Slug
        if ($this->URL_Slug->AdvancedSearch->get()) {
            $hasValue = true;
        }

        // Link_Content
        if ($this->Link_Content->AdvancedSearch->get()) {
            $hasValue = true;
        }

        // Photos
        if ($this->Photos->AdvancedSearch->get()) {
            $hasValue = true;
        }

        // Video_1
        if ($this->Video_1->AdvancedSearch->get()) {
            $hasValue = true;
        }

        // Video_2
        if ($this->Video_2->AdvancedSearch->get()) {
            $hasValue = true;
        }

        // Video_3
        if ($this->Video_3->AdvancedSearch->get()) {
            $hasValue = true;
        }

        // Title
        if ($this->_Title->AdvancedSearch->get()) {
            $hasValue = true;
        }

        // Description
        if ($this->Description->AdvancedSearch->get()) {
            $hasValue = true;
        }

        // Keywords
        if ($this->Keywords->AdvancedSearch->get()) {
            $hasValue = true;
        }

        // Active
        if ($this->Active->AdvancedSearch->get()) {
            $hasValue = true;
        }

        // Created_AT
        if ($this->Created_AT->AdvancedSearch->get()) {
            $hasValue = true;
        }

        // Created_BY
        if ($this->Created_BY->AdvancedSearch->get()) {
            $hasValue = true;
        }

        // IP
        if ($this->IP->AdvancedSearch->get()) {
            $hasValue = true;
        }
        return $hasValue;
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

            // ID
            $this->ID->LinkCustomAttributes = "";
            $this->ID->HrefValue = "";
            $this->ID->TooltipValue = "";

            // Link_Name
            $this->Link_Name->LinkCustomAttributes = "";
            $this->Link_Name->HrefValue = "";
            $this->Link_Name->TooltipValue = "";

            // URL_Slug
            $this->URL_Slug->LinkCustomAttributes = "";
            $this->URL_Slug->HrefValue = "";
            $this->URL_Slug->TooltipValue = "";

            // Link_Content
            $this->Link_Content->LinkCustomAttributes = "";
            $this->Link_Content->HrefValue = "";
            $this->Link_Content->TooltipValue = "";

            // Photos
            $this->Photos->LinkCustomAttributes = "";
            $this->Photos->HrefValue = "";
            $this->Photos->ExportHrefValue = $this->Photos->UploadPath . $this->Photos->Upload->DbValue;
            $this->Photos->TooltipValue = "";

            // Video_1
            $this->Video_1->LinkCustomAttributes = "";
            $this->Video_1->HrefValue = "";
            $this->Video_1->TooltipValue = "";

            // Video_2
            $this->Video_2->LinkCustomAttributes = "";
            $this->Video_2->HrefValue = "";
            $this->Video_2->TooltipValue = "";

            // Video_3
            $this->Video_3->LinkCustomAttributes = "";
            $this->Video_3->HrefValue = "";
            $this->Video_3->TooltipValue = "";

            // Title
            $this->_Title->LinkCustomAttributes = "";
            $this->_Title->HrefValue = "";
            $this->_Title->TooltipValue = "";

            // Description
            $this->Description->LinkCustomAttributes = "";
            $this->Description->HrefValue = "";
            $this->Description->TooltipValue = "";

            // Keywords
            $this->Keywords->LinkCustomAttributes = "";
            $this->Keywords->HrefValue = "";
            $this->Keywords->TooltipValue = "";

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
        } elseif ($this->RowType == ROWTYPE_SEARCH) {
            // ID
            $this->ID->setupEditAttributes();
            $this->ID->EditCustomAttributes = "";
            $this->ID->EditValue = HtmlEncode($this->ID->AdvancedSearch->SearchValue);
            $this->ID->PlaceHolder = RemoveHtml($this->ID->caption());

            // Link_Name
            $this->Link_Name->setupEditAttributes();
            $this->Link_Name->EditCustomAttributes = "";
            if (!$this->Link_Name->Raw) {
                $this->Link_Name->AdvancedSearch->SearchValue = HtmlDecode($this->Link_Name->AdvancedSearch->SearchValue);
            }
            $this->Link_Name->EditValue = HtmlEncode($this->Link_Name->AdvancedSearch->SearchValue);
            $this->Link_Name->PlaceHolder = RemoveHtml($this->Link_Name->caption());

            // URL_Slug
            $this->URL_Slug->setupEditAttributes();
            $this->URL_Slug->EditCustomAttributes = "";
            if (!$this->URL_Slug->Raw) {
                $this->URL_Slug->AdvancedSearch->SearchValue = HtmlDecode($this->URL_Slug->AdvancedSearch->SearchValue);
            }
            $this->URL_Slug->EditValue = HtmlEncode($this->URL_Slug->AdvancedSearch->SearchValue);
            $this->URL_Slug->PlaceHolder = RemoveHtml($this->URL_Slug->caption());

            // Link_Content
            $this->Link_Content->setupEditAttributes();
            $this->Link_Content->EditCustomAttributes = "";
            $this->Link_Content->EditValue = HtmlEncode($this->Link_Content->AdvancedSearch->SearchValue);
            $this->Link_Content->PlaceHolder = RemoveHtml($this->Link_Content->caption());

            // Photos
            $this->Photos->setupEditAttributes();
            $this->Photos->EditCustomAttributes = "";
            if (!$this->Photos->Raw) {
                $this->Photos->AdvancedSearch->SearchValue = HtmlDecode($this->Photos->AdvancedSearch->SearchValue);
            }
            $this->Photos->EditValue = HtmlEncode($this->Photos->AdvancedSearch->SearchValue);
            $this->Photos->PlaceHolder = RemoveHtml($this->Photos->caption());

            // Video_1
            $this->Video_1->setupEditAttributes();
            $this->Video_1->EditCustomAttributes = "";
            if (!$this->Video_1->Raw) {
                $this->Video_1->AdvancedSearch->SearchValue = HtmlDecode($this->Video_1->AdvancedSearch->SearchValue);
            }
            $this->Video_1->EditValue = HtmlEncode($this->Video_1->AdvancedSearch->SearchValue);
            $this->Video_1->PlaceHolder = RemoveHtml($this->Video_1->caption());

            // Video_2
            $this->Video_2->setupEditAttributes();
            $this->Video_2->EditCustomAttributes = "";
            if (!$this->Video_2->Raw) {
                $this->Video_2->AdvancedSearch->SearchValue = HtmlDecode($this->Video_2->AdvancedSearch->SearchValue);
            }
            $this->Video_2->EditValue = HtmlEncode($this->Video_2->AdvancedSearch->SearchValue);
            $this->Video_2->PlaceHolder = RemoveHtml($this->Video_2->caption());

            // Video_3
            $this->Video_3->setupEditAttributes();
            $this->Video_3->EditCustomAttributes = "";
            if (!$this->Video_3->Raw) {
                $this->Video_3->AdvancedSearch->SearchValue = HtmlDecode($this->Video_3->AdvancedSearch->SearchValue);
            }
            $this->Video_3->EditValue = HtmlEncode($this->Video_3->AdvancedSearch->SearchValue);
            $this->Video_3->PlaceHolder = RemoveHtml($this->Video_3->caption());

            // Title
            $this->_Title->setupEditAttributes();
            $this->_Title->EditCustomAttributes = "";
            if (!$this->_Title->Raw) {
                $this->_Title->AdvancedSearch->SearchValue = HtmlDecode($this->_Title->AdvancedSearch->SearchValue);
            }
            $this->_Title->EditValue = HtmlEncode($this->_Title->AdvancedSearch->SearchValue);
            $this->_Title->PlaceHolder = RemoveHtml($this->_Title->caption());

            // Description
            $this->Description->setupEditAttributes();
            $this->Description->EditCustomAttributes = "";
            $this->Description->EditValue = HtmlEncode($this->Description->AdvancedSearch->SearchValue);
            $this->Description->PlaceHolder = RemoveHtml($this->Description->caption());

            // Keywords
            $this->Keywords->setupEditAttributes();
            $this->Keywords->EditCustomAttributes = "";
            $this->Keywords->EditValue = HtmlEncode($this->Keywords->AdvancedSearch->SearchValue);
            $this->Keywords->PlaceHolder = RemoveHtml($this->Keywords->caption());

            // Active
            $this->Active->EditCustomAttributes = "";
            $this->Active->EditValue = $this->Active->options(false);
            $this->Active->PlaceHolder = RemoveHtml($this->Active->caption());

            // Created_AT
            $this->Created_AT->setupEditAttributes();
            $this->Created_AT->EditCustomAttributes = "";
            $this->Created_AT->EditValue = HtmlEncode(FormatDateTime(UnFormatDateTime($this->Created_AT->AdvancedSearch->SearchValue, $this->Created_AT->formatPattern()), $this->Created_AT->formatPattern()));
            $this->Created_AT->PlaceHolder = RemoveHtml($this->Created_AT->caption());

            // Created_BY
            $this->Created_BY->setupEditAttributes();
            $this->Created_BY->EditCustomAttributes = "";
            if (!$this->Created_BY->Raw) {
                $this->Created_BY->AdvancedSearch->SearchValue = HtmlDecode($this->Created_BY->AdvancedSearch->SearchValue);
            }
            $this->Created_BY->EditValue = HtmlEncode($this->Created_BY->AdvancedSearch->SearchValue);
            $this->Created_BY->PlaceHolder = RemoveHtml($this->Created_BY->caption());

            // IP
            $this->IP->setupEditAttributes();
            $this->IP->EditCustomAttributes = "";
            if (!$this->IP->Raw) {
                $this->IP->AdvancedSearch->SearchValue = HtmlDecode($this->IP->AdvancedSearch->SearchValue);
            }
            $this->IP->EditValue = HtmlEncode($this->IP->AdvancedSearch->SearchValue);
            $this->IP->PlaceHolder = RemoveHtml($this->IP->caption());
        }
        if ($this->RowType == ROWTYPE_ADD || $this->RowType == ROWTYPE_EDIT || $this->RowType == ROWTYPE_SEARCH) { // Add/Edit/Search row
            $this->setupFieldTitles();
        }

        // Call Row Rendered event
        if ($this->RowType != ROWTYPE_AGGREGATEINIT) {
            $this->rowRendered();
        }
    }

    // Validate search
    protected function validateSearch()
    {
        // Check if validation required
        if (!Config("SERVER_VALIDATE")) {
            return true;
        }
        if (!CheckInteger($this->ID->AdvancedSearch->SearchValue)) {
            $this->ID->addErrorMessage($this->ID->getErrorMessage(false));
        }
        if (!CheckDate($this->Created_AT->AdvancedSearch->SearchValue, $this->Created_AT->formatPattern())) {
            $this->Created_AT->addErrorMessage($this->Created_AT->getErrorMessage(false));
        }

        // Return validate result
        $validateSearch = !$this->hasInvalidFields();

        // Call Form_CustomValidate event
        $formCustomError = "";
        $validateSearch = $validateSearch && $this->formCustomValidate($formCustomError);
        if ($formCustomError != "") {
            $this->setFailureMessage($formCustomError);
        }
        return $validateSearch;
    }

    // Load advanced search
    public function loadAdvancedSearch()
    {
        $this->ID->AdvancedSearch->load();
        $this->Link_Name->AdvancedSearch->load();
        $this->URL_Slug->AdvancedSearch->load();
        $this->Link_Content->AdvancedSearch->load();
        $this->Photos->AdvancedSearch->load();
        $this->Video_1->AdvancedSearch->load();
        $this->Video_2->AdvancedSearch->load();
        $this->Video_3->AdvancedSearch->load();
        $this->_Title->AdvancedSearch->load();
        $this->Description->AdvancedSearch->load();
        $this->Keywords->AdvancedSearch->load();
        $this->Active->AdvancedSearch->load();
        $this->Created_AT->AdvancedSearch->load();
        $this->Created_BY->AdvancedSearch->load();
        $this->IP->AdvancedSearch->load();
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("LinksList"), "", $this->TableVar, true);
        $pageId = "search";
        $Breadcrumb->add("search", $pageId, $url);
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
