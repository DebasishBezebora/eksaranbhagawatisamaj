<?php

namespace PHPMaker2022\eksbs;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\FetchMode;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Table class for links
 */
class Links extends DbTable
{
    protected $SqlFrom = "";
    protected $SqlSelect = null;
    protected $SqlSelectList = null;
    protected $SqlWhere = "";
    protected $SqlGroupBy = "";
    protected $SqlHaving = "";
    protected $SqlOrderBy = "";
    public $UseSessionForListSql = true;

    // Column CSS classes
    public $LeftColumnClass = "col-sm-2 col-form-label ew-label";
    public $RightColumnClass = "col-sm-10";
    public $OffsetColumnClass = "col-sm-10 offset-sm-2";
    public $TableLeftColumnClass = "w-col-2";

    // Audit trail
    public $AuditTrailOnAdd = true;
    public $AuditTrailOnEdit = true;
    public $AuditTrailOnDelete = true;
    public $AuditTrailOnView = false;
    public $AuditTrailOnViewData = false;
    public $AuditTrailOnSearch = false;

    // Export
    public $ExportDoc;

    // Fields
    public $ID;
    public $Link_Name;
    public $URL_Slug;
    public $Link_Content;
    public $Photos;
    public $Video_1;
    public $Video_2;
    public $Video_3;
    public $_Title;
    public $Description;
    public $Keywords;
    public $Active;
    public $Created_AT;
    public $Created_BY;
    public $IP;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        global $Language, $CurrentLanguage, $CurrentLocale;
        parent::__construct();

        // Language object
        $Language = Container("language");
        $this->TableVar = 'links';
        $this->TableName = 'links';
        $this->TableType = 'TABLE';

        // Update Table
        $this->UpdateTable = "`links`";
        $this->Dbid = 'DB';
        $this->ExportAll = true;
        $this->ExportPageBreakCount = 0; // Page break per every n record (PDF only)
        $this->ExportPageOrientation = "portrait"; // Page orientation (PDF only)
        $this->ExportPageSize = "a4"; // Page size (PDF only)
        $this->ExportExcelPageOrientation = ""; // Page orientation (PhpSpreadsheet only)
        $this->ExportExcelPageSize = ""; // Page size (PhpSpreadsheet only)
        $this->ExportWordVersion = 12; // Word version (PHPWord only)
        $this->ExportWordPageOrientation = "portrait"; // Page orientation (PHPWord only)
        $this->ExportWordPageSize = "A4"; // Page orientation (PHPWord only)
        $this->ExportWordColumnWidth = null; // Cell width (PHPWord only)
        $this->DetailAdd = false; // Allow detail add
        $this->DetailEdit = false; // Allow detail edit
        $this->DetailView = false; // Allow detail view
        $this->ShowMultipleDetails = false; // Show multiple details
        $this->GridAddRowCount = 5;
        $this->AllowAddDeleteRow = true; // Allow add/delete row
        $this->UserIDAllowSecurity = Config("DEFAULT_USER_ID_ALLOW_SECURITY"); // Default User ID allowed permissions
        $this->BasicSearch = new BasicSearch($this->TableVar);

        // ID
        $this->ID = new DbField(
            'links',
            'links',
            'x_ID',
            'ID',
            '`ID`',
            '`ID`',
            3,
            11,
            -1,
            false,
            '`ID`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'NO'
        );
        $this->ID->InputTextType = "text";
        $this->ID->IsAutoIncrement = true; // Autoincrement field
        $this->ID->IsPrimaryKey = true; // Primary key field
        $this->ID->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->Fields['ID'] = &$this->ID;

        // Link_Name
        $this->Link_Name = new DbField(
            'links',
            'links',
            'x_Link_Name',
            'Link_Name',
            '`Link_Name`',
            '`Link_Name`',
            200,
            255,
            -1,
            false,
            '`Link_Name`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->Link_Name->InputTextType = "text";
        $this->Link_Name->Nullable = false; // NOT NULL field
        $this->Link_Name->Required = true; // Required field
        $this->Fields['Link_Name'] = &$this->Link_Name;

        // URL_Slug
        $this->URL_Slug = new DbField(
            'links',
            'links',
            'x_URL_Slug',
            'URL_Slug',
            '`URL_Slug`',
            '`URL_Slug`',
            200,
            255,
            -1,
            false,
            '`URL_Slug`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->URL_Slug->InputTextType = "text";
        $this->URL_Slug->Nullable = false; // NOT NULL field
        $this->URL_Slug->Required = true; // Required field
        $this->Fields['URL_Slug'] = &$this->URL_Slug;

        // Link_Content
        $this->Link_Content = new DbField(
            'links',
            'links',
            'x_Link_Content',
            'Link_Content',
            '`Link_Content`',
            '`Link_Content`',
            201,
            -1,
            -1,
            false,
            '`Link_Content`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXTAREA'
        );
        $this->Link_Content->InputTextType = "text";
        $this->Link_Content->Nullable = false; // NOT NULL field
        $this->Link_Content->Required = true; // Required field
        $this->Fields['Link_Content'] = &$this->Link_Content;

        // Photos
        $this->Photos = new DbField(
            'links',
            'links',
            'x_Photos',
            'Photos',
            '`Photos`',
            '`Photos`',
            201,
            65535,
            -1,
            true,
            '`Photos`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'FILE'
        );
        $this->Photos->InputTextType = "text";
        $this->Photos->UploadAllowedFileExt = "gif,jpeg,jpg,png";
        $this->Photos->UploadMultiple = true;
        $this->Photos->Upload->UploadMultiple = true;
        $this->Photos->UploadMaxFileCount = 20;
        $this->Photos->UploadPath = "files/";
        $this->Fields['Photos'] = &$this->Photos;

        // Video_1
        $this->Video_1 = new DbField(
            'links',
            'links',
            'x_Video_1',
            'Video_1',
            '`Video_1`',
            '`Video_1`',
            200,
            255,
            -1,
            false,
            '`Video_1`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->Video_1->InputTextType = "text";
        $this->Fields['Video_1'] = &$this->Video_1;

        // Video_2
        $this->Video_2 = new DbField(
            'links',
            'links',
            'x_Video_2',
            'Video_2',
            '`Video_2`',
            '`Video_2`',
            200,
            255,
            -1,
            false,
            '`Video_2`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->Video_2->InputTextType = "text";
        $this->Fields['Video_2'] = &$this->Video_2;

        // Video_3
        $this->Video_3 = new DbField(
            'links',
            'links',
            'x_Video_3',
            'Video_3',
            '`Video_3`',
            '`Video_3`',
            200,
            255,
            -1,
            false,
            '`Video_3`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->Video_3->InputTextType = "text";
        $this->Fields['Video_3'] = &$this->Video_3;

        // Title
        $this->_Title = new DbField(
            'links',
            'links',
            'x__Title',
            'Title',
            '`Title`',
            '`Title`',
            200,
            255,
            -1,
            false,
            '`Title`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->_Title->InputTextType = "text";
        $this->_Title->Nullable = false; // NOT NULL field
        $this->_Title->Required = true; // Required field
        $this->Fields['Title'] = &$this->_Title;

        // Description
        $this->Description = new DbField(
            'links',
            'links',
            'x_Description',
            'Description',
            '`Description`',
            '`Description`',
            201,
            65535,
            -1,
            false,
            '`Description`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXTAREA'
        );
        $this->Description->InputTextType = "text";
        $this->Fields['Description'] = &$this->Description;

        // Keywords
        $this->Keywords = new DbField(
            'links',
            'links',
            'x_Keywords',
            'Keywords',
            '`Keywords`',
            '`Keywords`',
            201,
            65535,
            -1,
            false,
            '`Keywords`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXTAREA'
        );
        $this->Keywords->InputTextType = "text";
        $this->Fields['Keywords'] = &$this->Keywords;

        // Active
        $this->Active = new DbField(
            'links',
            'links',
            'x_Active',
            'Active',
            '`Active`',
            '`Active`',
            202,
            1,
            -1,
            false,
            '`Active`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'RADIO'
        );
        $this->Active->InputTextType = "text";
        $this->Active->Nullable = false; // NOT NULL field
        $this->Active->Required = true; // Required field
        $this->Active->DataType = DATATYPE_BOOLEAN;
        $this->Active->Lookup = new Lookup('Active', 'links', false, '', ["","","",""], [], [], [], [], [], [], '', '', "");
        $this->Active->OptionCount = 2;
        $this->Fields['Active'] = &$this->Active;

        // Created_AT
        $this->Created_AT = new DbField(
            'links',
            'links',
            'x_Created_AT',
            'Created_AT',
            '`Created_AT`',
            CastDateFieldForLike("`Created_AT`", 0, "DB"),
            135,
            19,
            0,
            false,
            '`Created_AT`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->Created_AT->InputTextType = "text";
        $this->Created_AT->Nullable = false; // NOT NULL field
        $this->Created_AT->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->Fields['Created_AT'] = &$this->Created_AT;

        // Created_BY
        $this->Created_BY = new DbField(
            'links',
            'links',
            'x_Created_BY',
            'Created_BY',
            '`Created_BY`',
            '`Created_BY`',
            200,
            50,
            -1,
            false,
            '`Created_BY`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->Created_BY->InputTextType = "text";
        $this->Created_BY->Nullable = false; // NOT NULL field
        $this->Fields['Created_BY'] = &$this->Created_BY;

        // IP
        $this->IP = new DbField(
            'links',
            'links',
            'x_IP',
            'IP',
            '`IP`',
            '`IP`',
            200,
            50,
            -1,
            false,
            '`IP`',
            false,
            false,
            false,
            'FORMATTED TEXT',
            'TEXT'
        );
        $this->IP->InputTextType = "text";
        $this->IP->Nullable = false; // NOT NULL field
        $this->Fields['IP'] = &$this->IP;

        // Add Doctrine Cache
        $this->Cache = new ArrayCache();
        $this->CacheProfile = new \Doctrine\DBAL\Cache\QueryCacheProfile(0, $this->TableVar);
    }

    // Field Visibility
    public function getFieldVisibility($fldParm)
    {
        global $Security;
        return $this->$fldParm->Visible; // Returns original value
    }

    // Set left column class (must be predefined col-*-* classes of Bootstrap grid system)
    public function setLeftColumnClass($class)
    {
        if (preg_match('/^col\-(\w+)\-(\d+)$/', $class, $match)) {
            $this->LeftColumnClass = $class . " col-form-label ew-label";
            $this->RightColumnClass = "col-" . $match[1] . "-" . strval(12 - (int)$match[2]);
            $this->OffsetColumnClass = $this->RightColumnClass . " " . str_replace("col-", "offset-", $class);
            $this->TableLeftColumnClass = preg_replace('/^col-\w+-(\d+)$/', "w-col-$1", $class); // Change to w-col-*
        }
    }

    // Single column sort
    public function updateSort(&$fld)
    {
        if ($this->CurrentOrder == $fld->Name) {
            $sortField = $fld->Expression;
            $lastSort = $fld->getSort();
            if (in_array($this->CurrentOrderType, ["ASC", "DESC", "NO"])) {
                $curSort = $this->CurrentOrderType;
            } else {
                $curSort = $lastSort;
            }
            $fld->setSort($curSort);
            $orderBy = in_array($curSort, ["ASC", "DESC"]) ? $sortField . " " . $curSort : "";
            $this->setSessionOrderBy($orderBy); // Save to Session
        } else {
            $fld->setSort("");
        }
    }

    // Table level SQL
    public function getSqlFrom() // From
    {
        return ($this->SqlFrom != "") ? $this->SqlFrom : "`links`";
    }

    public function sqlFrom() // For backward compatibility
    {
        return $this->getSqlFrom();
    }

    public function setSqlFrom($v)
    {
        $this->SqlFrom = $v;
    }

    public function getSqlSelect() // Select
    {
        return $this->SqlSelect ?? $this->getQueryBuilder()->select("*");
    }

    public function sqlSelect() // For backward compatibility
    {
        return $this->getSqlSelect();
    }

    public function setSqlSelect($v)
    {
        $this->SqlSelect = $v;
    }

    public function getSqlWhere() // Where
    {
        $where = ($this->SqlWhere != "") ? $this->SqlWhere : "";
        $this->DefaultFilter = "";
        AddFilter($where, $this->DefaultFilter);
        return $where;
    }

    public function sqlWhere() // For backward compatibility
    {
        return $this->getSqlWhere();
    }

    public function setSqlWhere($v)
    {
        $this->SqlWhere = $v;
    }

    public function getSqlGroupBy() // Group By
    {
        return ($this->SqlGroupBy != "") ? $this->SqlGroupBy : "";
    }

    public function sqlGroupBy() // For backward compatibility
    {
        return $this->getSqlGroupBy();
    }

    public function setSqlGroupBy($v)
    {
        $this->SqlGroupBy = $v;
    }

    public function getSqlHaving() // Having
    {
        return ($this->SqlHaving != "") ? $this->SqlHaving : "";
    }

    public function sqlHaving() // For backward compatibility
    {
        return $this->getSqlHaving();
    }

    public function setSqlHaving($v)
    {
        $this->SqlHaving = $v;
    }

    public function getSqlOrderBy() // Order By
    {
        return ($this->SqlOrderBy != "") ? $this->SqlOrderBy : $this->DefaultSort;
    }

    public function sqlOrderBy() // For backward compatibility
    {
        return $this->getSqlOrderBy();
    }

    public function setSqlOrderBy($v)
    {
        $this->SqlOrderBy = $v;
    }

    // Apply User ID filters
    public function applyUserIDFilters($filter)
    {
        return $filter;
    }

    // Check if User ID security allows view all
    public function userIDAllow($id = "")
    {
        $allow = $this->UserIDAllowSecurity;
        switch ($id) {
            case "add":
            case "copy":
            case "gridadd":
            case "register":
            case "addopt":
                return (($allow & 1) == 1);
            case "edit":
            case "gridedit":
            case "update":
            case "changepassword":
            case "resetpassword":
                return (($allow & 4) == 4);
            case "delete":
                return (($allow & 2) == 2);
            case "view":
                return (($allow & 32) == 32);
            case "search":
                return (($allow & 64) == 64);
            default:
                return (($allow & 8) == 8);
        }
    }

    /**
     * Get record count
     *
     * @param string|QueryBuilder $sql SQL or QueryBuilder
     * @param mixed $c Connection
     * @return int
     */
    public function getRecordCount($sql, $c = null)
    {
        $cnt = -1;
        $rs = null;
        if ($sql instanceof QueryBuilder) { // Query builder
            $sqlwrk = clone $sql;
            $sqlwrk = $sqlwrk->resetQueryPart("orderBy")->getSQL();
        } else {
            $sqlwrk = $sql;
        }
        $pattern = '/^SELECT\s([\s\S]+)\sFROM\s/i';
        // Skip Custom View / SubQuery / SELECT DISTINCT / ORDER BY
        if (
            ($this->TableType == 'TABLE' || $this->TableType == 'VIEW' || $this->TableType == 'LINKTABLE') &&
            preg_match($pattern, $sqlwrk) && !preg_match('/\(\s*(SELECT[^)]+)\)/i', $sqlwrk) &&
            !preg_match('/^\s*select\s+distinct\s+/i', $sqlwrk) && !preg_match('/\s+order\s+by\s+/i', $sqlwrk)
        ) {
            $sqlwrk = "SELECT COUNT(*) FROM " . preg_replace($pattern, "", $sqlwrk);
        } else {
            $sqlwrk = "SELECT COUNT(*) FROM (" . $sqlwrk . ") COUNT_TABLE";
        }
        $conn = $c ?? $this->getConnection();
        $cnt = $conn->fetchOne($sqlwrk);
        if ($cnt !== false) {
            return (int)$cnt;
        }

        // Unable to get count by SELECT COUNT(*), execute the SQL to get record count directly
        return ExecuteRecordCount($sql, $conn);
    }

    // Get SQL
    public function getSql($where, $orderBy = "")
    {
        return $this->buildSelectSql(
            $this->getSqlSelect(),
            $this->getSqlFrom(),
            $this->getSqlWhere(),
            $this->getSqlGroupBy(),
            $this->getSqlHaving(),
            $this->getSqlOrderBy(),
            $where,
            $orderBy
        )->getSQL();
    }

    // Table SQL
    public function getCurrentSql()
    {
        $filter = $this->CurrentFilter;
        $filter = $this->applyUserIDFilters($filter);
        $sort = $this->getSessionOrderBy();
        return $this->getSql($filter, $sort);
    }

    /**
     * Table SQL with List page filter
     *
     * @return QueryBuilder
     */
    public function getListSql()
    {
        $filter = $this->UseSessionForListSql ? $this->getSessionWhere() : "";
        AddFilter($filter, $this->CurrentFilter);
        $filter = $this->applyUserIDFilters($filter);
        $this->recordsetSelecting($filter);
        $select = $this->getSqlSelect();
        $from = $this->getSqlFrom();
        $sort = $this->UseSessionForListSql ? $this->getSessionOrderBy() : "";
        $this->Sort = $sort;
        return $this->buildSelectSql(
            $select,
            $from,
            $this->getSqlWhere(),
            $this->getSqlGroupBy(),
            $this->getSqlHaving(),
            $this->getSqlOrderBy(),
            $filter,
            $sort
        );
    }

    // Get ORDER BY clause
    public function getOrderBy()
    {
        $orderBy = $this->getSqlOrderBy();
        $sort = $this->getSessionOrderBy();
        if ($orderBy != "" && $sort != "") {
            $orderBy .= ", " . $sort;
        } elseif ($sort != "") {
            $orderBy = $sort;
        }
        return $orderBy;
    }

    // Get record count based on filter (for detail record count in master table pages)
    public function loadRecordCount($filter)
    {
        $origFilter = $this->CurrentFilter;
        $this->CurrentFilter = $filter;
        $this->recordsetSelecting($this->CurrentFilter);
        $select = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlSelect() : $this->getQueryBuilder()->select("*");
        $groupBy = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlGroupBy() : "";
        $having = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlHaving() : "";
        $sql = $this->buildSelectSql($select, $this->getSqlFrom(), $this->getSqlWhere(), $groupBy, $having, "", $this->CurrentFilter, "");
        $cnt = $this->getRecordCount($sql);
        $this->CurrentFilter = $origFilter;
        return $cnt;
    }

    // Get record count (for current List page)
    public function listRecordCount()
    {
        $filter = $this->getSessionWhere();
        AddFilter($filter, $this->CurrentFilter);
        $filter = $this->applyUserIDFilters($filter);
        $this->recordsetSelecting($filter);
        $select = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlSelect() : $this->getQueryBuilder()->select("*");
        $groupBy = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlGroupBy() : "";
        $having = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlHaving() : "";
        $sql = $this->buildSelectSql($select, $this->getSqlFrom(), $this->getSqlWhere(), $groupBy, $having, "", $filter, "");
        $cnt = $this->getRecordCount($sql);
        return $cnt;
    }

    /**
     * INSERT statement
     *
     * @param mixed $rs
     * @return QueryBuilder
     */
    public function insertSql(&$rs)
    {
        $queryBuilder = $this->getQueryBuilder();
        $queryBuilder->insert($this->UpdateTable);
        foreach ($rs as $name => $value) {
            if (!isset($this->Fields[$name]) || $this->Fields[$name]->IsCustom) {
                continue;
            }
            $type = GetParameterType($this->Fields[$name], $value, $this->Dbid);
            $queryBuilder->setValue($this->Fields[$name]->Expression, $queryBuilder->createPositionalParameter($value, $type));
        }
        return $queryBuilder;
    }

    // Insert
    public function insert(&$rs)
    {
        $conn = $this->getConnection();
        $success = $this->insertSql($rs)->execute();
        if ($success) {
            // Get insert id if necessary
            $this->ID->setDbValue($conn->lastInsertId());
            $rs['ID'] = $this->ID->DbValue;
            if ($this->AuditTrailOnAdd) {
                $this->writeAuditTrailOnAdd($rs);
            }
        }
        return $success;
    }

    /**
     * UPDATE statement
     *
     * @param array $rs Data to be updated
     * @param string|array $where WHERE clause
     * @param string $curfilter Filter
     * @return QueryBuilder
     */
    public function updateSql(&$rs, $where = "", $curfilter = true)
    {
        $queryBuilder = $this->getQueryBuilder();
        $queryBuilder->update($this->UpdateTable);
        foreach ($rs as $name => $value) {
            if (!isset($this->Fields[$name]) || $this->Fields[$name]->IsCustom || $this->Fields[$name]->IsAutoIncrement) {
                continue;
            }
            $type = GetParameterType($this->Fields[$name], $value, $this->Dbid);
            $queryBuilder->set($this->Fields[$name]->Expression, $queryBuilder->createPositionalParameter($value, $type));
        }
        $filter = ($curfilter) ? $this->CurrentFilter : "";
        if (is_array($where)) {
            $where = $this->arrayToFilter($where);
        }
        AddFilter($filter, $where);
        if ($filter != "") {
            $queryBuilder->where($filter);
        }
        return $queryBuilder;
    }

    // Update
    public function update(&$rs, $where = "", $rsold = null, $curfilter = true)
    {
        // If no field is updated, execute may return 0. Treat as success
        $success = $this->updateSql($rs, $where, $curfilter)->execute();
        $success = ($success > 0) ? $success : true;
        if ($success && $this->AuditTrailOnEdit && $rsold) {
            $rsaudit = $rs;
            $fldname = 'ID';
            if (!array_key_exists($fldname, $rsaudit)) {
                $rsaudit[$fldname] = $rsold[$fldname];
            }
            $this->writeAuditTrailOnEdit($rsold, $rsaudit);
        }
        return $success;
    }

    /**
     * DELETE statement
     *
     * @param array $rs Key values
     * @param string|array $where WHERE clause
     * @param string $curfilter Filter
     * @return QueryBuilder
     */
    public function deleteSql(&$rs, $where = "", $curfilter = true)
    {
        $queryBuilder = $this->getQueryBuilder();
        $queryBuilder->delete($this->UpdateTable);
        if (is_array($where)) {
            $where = $this->arrayToFilter($where);
        }
        if ($rs) {
            if (array_key_exists('ID', $rs)) {
                AddFilter($where, QuotedName('ID', $this->Dbid) . '=' . QuotedValue($rs['ID'], $this->ID->DataType, $this->Dbid));
            }
        }
        $filter = ($curfilter) ? $this->CurrentFilter : "";
        AddFilter($filter, $where);
        return $queryBuilder->where($filter != "" ? $filter : "0=1");
    }

    // Delete
    public function delete(&$rs, $where = "", $curfilter = false)
    {
        $success = true;
        if ($success) {
            $success = $this->deleteSql($rs, $where, $curfilter)->execute();
        }
        if ($success && $this->AuditTrailOnDelete) {
            $this->writeAuditTrailOnDelete($rs);
        }
        return $success;
    }

    // Load DbValue from recordset or array
    protected function loadDbValues($row)
    {
        if (!is_array($row)) {
            return;
        }
        $this->ID->DbValue = $row['ID'];
        $this->Link_Name->DbValue = $row['Link_Name'];
        $this->URL_Slug->DbValue = $row['URL_Slug'];
        $this->Link_Content->DbValue = $row['Link_Content'];
        $this->Photos->Upload->DbValue = $row['Photos'];
        $this->Video_1->DbValue = $row['Video_1'];
        $this->Video_2->DbValue = $row['Video_2'];
        $this->Video_3->DbValue = $row['Video_3'];
        $this->_Title->DbValue = $row['Title'];
        $this->Description->DbValue = $row['Description'];
        $this->Keywords->DbValue = $row['Keywords'];
        $this->Active->DbValue = $row['Active'];
        $this->Created_AT->DbValue = $row['Created_AT'];
        $this->Created_BY->DbValue = $row['Created_BY'];
        $this->IP->DbValue = $row['IP'];
    }

    // Delete uploaded files
    public function deleteUploadedFiles($row)
    {
        $this->loadDbValues($row);
        $this->Photos->OldUploadPath = "files/";
        $oldFiles = EmptyValue($row['Photos']) ? [] : explode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $row['Photos']);
        foreach ($oldFiles as $oldFile) {
            if (file_exists($this->Photos->oldPhysicalUploadPath() . $oldFile)) {
                @unlink($this->Photos->oldPhysicalUploadPath() . $oldFile);
            }
        }
    }

    // Record filter WHERE clause
    protected function sqlKeyFilter()
    {
        return "`ID` = @ID@";
    }

    // Get Key
    public function getKey($current = false)
    {
        $keys = [];
        $val = $current ? $this->ID->CurrentValue : $this->ID->OldValue;
        if (EmptyValue($val)) {
            return "";
        } else {
            $keys[] = $val;
        }
        return implode(Config("COMPOSITE_KEY_SEPARATOR"), $keys);
    }

    // Set Key
    public function setKey($key, $current = false)
    {
        $this->OldKey = strval($key);
        $keys = explode(Config("COMPOSITE_KEY_SEPARATOR"), $this->OldKey);
        if (count($keys) == 1) {
            if ($current) {
                $this->ID->CurrentValue = $keys[0];
            } else {
                $this->ID->OldValue = $keys[0];
            }
        }
    }

    // Get record filter
    public function getRecordFilter($row = null)
    {
        $keyFilter = $this->sqlKeyFilter();
        if (is_array($row)) {
            $val = array_key_exists('ID', $row) ? $row['ID'] : null;
        } else {
            $val = $this->ID->OldValue !== null ? $this->ID->OldValue : $this->ID->CurrentValue;
        }
        if (!is_numeric($val)) {
            return "0=1"; // Invalid key
        }
        if ($val === null) {
            return "0=1"; // Invalid key
        } else {
            $keyFilter = str_replace("@ID@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
        }
        return $keyFilter;
    }

    // Return page URL
    public function getReturnUrl()
    {
        $referUrl = ReferUrl();
        $referPageName = ReferPageName();
        $name = PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_RETURN_URL");
        // Get referer URL automatically
        if ($referUrl != "" && $referPageName != CurrentPageName() && $referPageName != "login") { // Referer not same page or login page
            $_SESSION[$name] = $referUrl; // Save to Session
        }
        return $_SESSION[$name] ?? GetUrl("LinksList");
    }

    // Set return page URL
    public function setReturnUrl($v)
    {
        $_SESSION[PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_RETURN_URL")] = $v;
    }

    // Get modal caption
    public function getModalCaption($pageName)
    {
        global $Language;
        if ($pageName == "LinksView") {
            return $Language->phrase("View");
        } elseif ($pageName == "LinksEdit") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "LinksAdd") {
            return $Language->phrase("Add");
        } else {
            return "";
        }
    }

    // API page name
    public function getApiPageName($action)
    {
        switch (strtolower($action)) {
            case Config("API_VIEW_ACTION"):
                return "LinksView";
            case Config("API_ADD_ACTION"):
                return "LinksAdd";
            case Config("API_EDIT_ACTION"):
                return "LinksEdit";
            case Config("API_DELETE_ACTION"):
                return "LinksDelete";
            case Config("API_LIST_ACTION"):
                return "LinksList";
            default:
                return "";
        }
    }

    // List URL
    public function getListUrl()
    {
        return "LinksList";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("LinksView", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("LinksView", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "LinksAdd?" . $this->getUrlParm($parm);
        } else {
            $url = "LinksAdd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("LinksEdit", $this->getUrlParm($parm));
        return $this->addMasterUrl($url);
    }

    // Inline edit URL
    public function getInlineEditUrl()
    {
        $url = $this->keyUrl(CurrentPageName(), $this->getUrlParm("action=edit"));
        return $this->addMasterUrl($url);
    }

    // Copy URL
    public function getCopyUrl($parm = "")
    {
        $url = $this->keyUrl("LinksAdd", $this->getUrlParm($parm));
        return $this->addMasterUrl($url);
    }

    // Inline copy URL
    public function getInlineCopyUrl()
    {
        $url = $this->keyUrl(CurrentPageName(), $this->getUrlParm("action=copy"));
        return $this->addMasterUrl($url);
    }

    // Delete URL
    public function getDeleteUrl()
    {
        return $this->keyUrl("LinksDelete", $this->getUrlParm());
    }

    // Add master url
    public function addMasterUrl($url)
    {
        return $url;
    }

    public function keyToJson($htmlEncode = false)
    {
        $json = "";
        $json .= "\"ID\":" . JsonEncode($this->ID->CurrentValue, "number");
        $json = "{" . $json . "}";
        if ($htmlEncode) {
            $json = HtmlEncode($json);
        }
        return $json;
    }

    // Add key value to URL
    public function keyUrl($url, $parm = "")
    {
        if ($this->ID->CurrentValue !== null) {
            $url .= "/" . $this->encodeKeyValue($this->ID->CurrentValue);
        } else {
            return "javascript:ew.alert(ew.language.phrase('InvalidRecord'));";
        }
        if ($parm != "") {
            $url .= "?" . $parm;
        }
        return $url;
    }

    // Render sort
    public function renderFieldHeader($fld)
    {
        global $Security, $Language;
        $sortUrl = "";
        $attrs = "";
        if ($fld->Sortable) {
            $sortUrl = $this->sortUrl($fld);
            $attrs = ' role="button" data-sort-url="' . $sortUrl . '" data-sort-type="1"';
        }
        $html = '<div class="ew-table-header-caption"' . $attrs . '>' . $fld->caption() . '</div>';
        if ($sortUrl) {
            $html .= '<div class="ew-table-header-sort">' . $fld->getSortIcon() . '</div>';
        }
        if ($fld->UseFilter && $Security->canSearch()) {
            $html .= '<div class="ew-filter-dropdown-btn" data-ew-action="filter" data-table="' . $fld->TableVar . '" data-field="' . $fld->FieldVar .
                '"><div class="ew-table-header-filter" role="button" aria-haspopup="true">' . $Language->phrase("Filter") . '</div></div>';
        }
        $html = '<div class="ew-table-header-btn">' . $html . '</div>';
        if ($this->UseCustomTemplate) {
            $scriptId = str_replace("{id}", $fld->TableVar . "_" . $fld->Param, "tpc_{id}");
            $html = '<template id="' . $scriptId . '">' . $html . '</template>';
        }
        return $html;
    }

    // Sort URL
    public function sortUrl($fld)
    {
        if (
            $this->CurrentAction || $this->isExport() ||
            in_array($fld->Type, [128, 204, 205])
        ) { // Unsortable data type
                return "";
        } elseif ($fld->Sortable) {
            $urlParm = $this->getUrlParm("order=" . urlencode($fld->Name) . "&amp;ordertype=" . $fld->getNextSort());
            return $this->addMasterUrl(CurrentPageName() . "?" . $urlParm);
        } else {
            return "";
        }
    }

    // Get record keys from Post/Get/Session
    public function getRecordKeys()
    {
        $arKeys = [];
        $arKey = [];
        if (Param("key_m") !== null) {
            $arKeys = Param("key_m");
            $cnt = count($arKeys);
        } else {
            if (($keyValue = Param("ID") ?? Route("ID")) !== null) {
                $arKeys[] = $keyValue;
            } elseif (IsApi() && (($keyValue = Key(0) ?? Route(2)) !== null)) {
                $arKeys[] = $keyValue;
            } else {
                $arKeys = null; // Do not setup
            }

            //return $arKeys; // Do not return yet, so the values will also be checked by the following code
        }
        // Check keys
        $ar = [];
        if (is_array($arKeys)) {
            foreach ($arKeys as $key) {
                if (!is_numeric($key)) {
                    continue;
                }
                $ar[] = $key;
            }
        }
        return $ar;
    }

    // Get filter from record keys
    public function getFilterFromRecordKeys($setCurrent = true)
    {
        $arKeys = $this->getRecordKeys();
        $keyFilter = "";
        foreach ($arKeys as $key) {
            if ($keyFilter != "") {
                $keyFilter .= " OR ";
            }
            if ($setCurrent) {
                $this->ID->CurrentValue = $key;
            } else {
                $this->ID->OldValue = $key;
            }
            $keyFilter .= "(" . $this->getRecordFilter() . ")";
        }
        return $keyFilter;
    }

    // Load recordset based on filter
    public function loadRs($filter)
    {
        $sql = $this->getSql($filter); // Set up filter (WHERE Clause)
        $conn = $this->getConnection();
        return $conn->executeQuery($sql);
    }

    // Load row values from record
    public function loadListRowValues(&$rs)
    {
        if (is_array($rs)) {
            $row = $rs;
        } elseif ($rs && property_exists($rs, "fields")) { // Recordset
            $row = $rs->fields;
        } else {
            return;
        }
        $this->ID->setDbValue($row['ID']);
        $this->Link_Name->setDbValue($row['Link_Name']);
        $this->URL_Slug->setDbValue($row['URL_Slug']);
        $this->Link_Content->setDbValue($row['Link_Content']);
        $this->Photos->Upload->DbValue = $row['Photos'];
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

    // Render list row values
    public function renderListRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // Common render codes

        // ID

        // Link_Name

        // URL_Slug

        // Link_Content

        // Photos

        // Video_1

        // Video_2

        // Video_3

        // Title

        // Description

        // Keywords

        // Active

        // Created_AT

        // Created_BY

        // IP

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

        // Call Row Rendered event
        $this->rowRendered();

        // Save data for Custom Template
        $this->Rows[] = $this->customTemplateFieldValues();
    }

    // Render edit row values
    public function renderEditRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // ID
        $this->ID->setupEditAttributes();
        $this->ID->EditCustomAttributes = "";
        $this->ID->EditValue = $this->ID->CurrentValue;
        $this->ID->ViewCustomAttributes = "";

        // Link_Name
        $this->Link_Name->setupEditAttributes();
        $this->Link_Name->EditCustomAttributes = "";
        if (!$this->Link_Name->Raw) {
            $this->Link_Name->CurrentValue = HtmlDecode($this->Link_Name->CurrentValue);
        }
        $this->Link_Name->EditValue = $this->Link_Name->CurrentValue;
        $this->Link_Name->PlaceHolder = RemoveHtml($this->Link_Name->caption());

        // URL_Slug
        $this->URL_Slug->setupEditAttributes();
        $this->URL_Slug->EditCustomAttributes = "";
        if (!$this->URL_Slug->Raw) {
            $this->URL_Slug->CurrentValue = HtmlDecode($this->URL_Slug->CurrentValue);
        }
        $this->URL_Slug->EditValue = $this->URL_Slug->CurrentValue;
        $this->URL_Slug->PlaceHolder = RemoveHtml($this->URL_Slug->caption());

        // Link_Content
        $this->Link_Content->setupEditAttributes();
        $this->Link_Content->EditCustomAttributes = "";
        $this->Link_Content->EditValue = $this->Link_Content->CurrentValue;
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

        // Video_1
        $this->Video_1->setupEditAttributes();
        $this->Video_1->EditCustomAttributes = "";
        if (!$this->Video_1->Raw) {
            $this->Video_1->CurrentValue = HtmlDecode($this->Video_1->CurrentValue);
        }
        $this->Video_1->EditValue = $this->Video_1->CurrentValue;
        $this->Video_1->PlaceHolder = RemoveHtml($this->Video_1->caption());

        // Video_2
        $this->Video_2->setupEditAttributes();
        $this->Video_2->EditCustomAttributes = "";
        if (!$this->Video_2->Raw) {
            $this->Video_2->CurrentValue = HtmlDecode($this->Video_2->CurrentValue);
        }
        $this->Video_2->EditValue = $this->Video_2->CurrentValue;
        $this->Video_2->PlaceHolder = RemoveHtml($this->Video_2->caption());

        // Video_3
        $this->Video_3->setupEditAttributes();
        $this->Video_3->EditCustomAttributes = "";
        if (!$this->Video_3->Raw) {
            $this->Video_3->CurrentValue = HtmlDecode($this->Video_3->CurrentValue);
        }
        $this->Video_3->EditValue = $this->Video_3->CurrentValue;
        $this->Video_3->PlaceHolder = RemoveHtml($this->Video_3->caption());

        // Title
        $this->_Title->setupEditAttributes();
        $this->_Title->EditCustomAttributes = "";
        if (!$this->_Title->Raw) {
            $this->_Title->CurrentValue = HtmlDecode($this->_Title->CurrentValue);
        }
        $this->_Title->EditValue = $this->_Title->CurrentValue;
        $this->_Title->PlaceHolder = RemoveHtml($this->_Title->caption());

        // Description
        $this->Description->setupEditAttributes();
        $this->Description->EditCustomAttributes = "";
        $this->Description->EditValue = $this->Description->CurrentValue;
        $this->Description->PlaceHolder = RemoveHtml($this->Description->caption());

        // Keywords
        $this->Keywords->setupEditAttributes();
        $this->Keywords->EditCustomAttributes = "";
        $this->Keywords->EditValue = $this->Keywords->CurrentValue;
        $this->Keywords->PlaceHolder = RemoveHtml($this->Keywords->caption());

        // Active
        $this->Active->EditCustomAttributes = "";
        $this->Active->EditValue = $this->Active->options(false);
        $this->Active->PlaceHolder = RemoveHtml($this->Active->caption());

        // Created_AT

        // Created_BY

        // IP

        // Call Row Rendered event
        $this->rowRendered();
    }

    // Aggregate list row values
    public function aggregateListRowValues()
    {
    }

    // Aggregate list row (for rendering)
    public function aggregateListRow()
    {
        // Call Row Rendered event
        $this->rowRendered();
    }

    // Export data in HTML/CSV/Word/Excel/Email/PDF format
    public function exportDocument($doc, $recordset, $startRec = 1, $stopRec = 1, $exportPageType = "")
    {
        if (!$recordset || !$doc) {
            return;
        }
        if (!$doc->ExportCustom) {
            // Write header
            $doc->exportTableHeader();
            if ($doc->Horizontal) { // Horizontal format, write header
                $doc->beginExportRow();
                if ($exportPageType == "view") {
                    $doc->exportCaption($this->ID);
                    $doc->exportCaption($this->Link_Name);
                    $doc->exportCaption($this->URL_Slug);
                    $doc->exportCaption($this->Link_Content);
                    $doc->exportCaption($this->Photos);
                    $doc->exportCaption($this->Video_1);
                    $doc->exportCaption($this->Video_2);
                    $doc->exportCaption($this->Video_3);
                    $doc->exportCaption($this->_Title);
                    $doc->exportCaption($this->Description);
                    $doc->exportCaption($this->Keywords);
                    $doc->exportCaption($this->Active);
                    $doc->exportCaption($this->Created_AT);
                    $doc->exportCaption($this->Created_BY);
                    $doc->exportCaption($this->IP);
                } else {
                    $doc->exportCaption($this->ID);
                    $doc->exportCaption($this->Link_Name);
                    $doc->exportCaption($this->URL_Slug);
                    $doc->exportCaption($this->Video_1);
                    $doc->exportCaption($this->Video_2);
                    $doc->exportCaption($this->Video_3);
                    $doc->exportCaption($this->_Title);
                    $doc->exportCaption($this->Active);
                    $doc->exportCaption($this->Created_AT);
                    $doc->exportCaption($this->Created_BY);
                    $doc->exportCaption($this->IP);
                }
                $doc->endExportRow();
            }
        }

        // Move to first record
        $recCnt = $startRec - 1;
        $stopRec = ($stopRec > 0) ? $stopRec : PHP_INT_MAX;
        while (!$recordset->EOF && $recCnt < $stopRec) {
            $row = $recordset->fields;
            $recCnt++;
            if ($recCnt >= $startRec) {
                $rowCnt = $recCnt - $startRec + 1;

                // Page break
                if ($this->ExportPageBreakCount > 0) {
                    if ($rowCnt > 1 && ($rowCnt - 1) % $this->ExportPageBreakCount == 0) {
                        $doc->exportPageBreak();
                    }
                }
                $this->loadListRowValues($row);

                // Render row
                $this->RowType = ROWTYPE_VIEW; // Render view
                $this->resetAttributes();
                $this->renderListRow();
                if (!$doc->ExportCustom) {
                    $doc->beginExportRow($rowCnt); // Allow CSS styles if enabled
                    if ($exportPageType == "view") {
                        $doc->exportField($this->ID);
                        $doc->exportField($this->Link_Name);
                        $doc->exportField($this->URL_Slug);
                        $doc->exportField($this->Link_Content);
                        $doc->exportField($this->Photos);
                        $doc->exportField($this->Video_1);
                        $doc->exportField($this->Video_2);
                        $doc->exportField($this->Video_3);
                        $doc->exportField($this->_Title);
                        $doc->exportField($this->Description);
                        $doc->exportField($this->Keywords);
                        $doc->exportField($this->Active);
                        $doc->exportField($this->Created_AT);
                        $doc->exportField($this->Created_BY);
                        $doc->exportField($this->IP);
                    } else {
                        $doc->exportField($this->ID);
                        $doc->exportField($this->Link_Name);
                        $doc->exportField($this->URL_Slug);
                        $doc->exportField($this->Video_1);
                        $doc->exportField($this->Video_2);
                        $doc->exportField($this->Video_3);
                        $doc->exportField($this->_Title);
                        $doc->exportField($this->Active);
                        $doc->exportField($this->Created_AT);
                        $doc->exportField($this->Created_BY);
                        $doc->exportField($this->IP);
                    }
                    $doc->endExportRow($rowCnt);
                }
            }

            // Call Row Export server event
            if ($doc->ExportCustom) {
                $this->rowExport($row);
            }
            $recordset->moveNext();
        }
        if (!$doc->ExportCustom) {
            $doc->exportTableFooter();
        }
    }

    // Get file data
    public function getFileData($fldparm, $key, $resize, $width = 0, $height = 0, $plugins = [])
    {
        $width = ($width > 0) ? $width : Config("THUMBNAIL_DEFAULT_WIDTH");
        $height = ($height > 0) ? $height : Config("THUMBNAIL_DEFAULT_HEIGHT");

        // Set up field name / file name field / file type field
        $fldName = "";
        $fileNameFld = "";
        $fileTypeFld = "";
        if ($fldparm == 'Photos') {
            $fldName = "Photos";
            $fileNameFld = "Photos";
        } else {
            return false; // Incorrect field
        }

        // Set up key values
        $ar = explode(Config("COMPOSITE_KEY_SEPARATOR"), $key);
        if (count($ar) == 1) {
            $this->ID->CurrentValue = $ar[0];
        } else {
            return false; // Incorrect key
        }

        // Set up filter (WHERE Clause)
        $filter = $this->getRecordFilter();
        $this->CurrentFilter = $filter;
        $sql = $this->getCurrentSql();
        $conn = $this->getConnection();
        $dbtype = GetConnectionType($this->Dbid);
        if ($row = $conn->fetchAssociative($sql)) {
            $val = $row[$fldName];
            if (!EmptyValue($val)) {
                $fld = $this->Fields[$fldName];

                // Binary data
                if ($fld->DataType == DATATYPE_BLOB) {
                    if ($dbtype != "MYSQL") {
                        if (is_resource($val) && get_resource_type($val) == "stream") { // Byte array
                            $val = stream_get_contents($val);
                        }
                    }
                    if ($resize) {
                        ResizeBinary($val, $width, $height, $plugins);
                    }

                    // Write file type
                    if ($fileTypeFld != "" && !EmptyValue($row[$fileTypeFld])) {
                        AddHeader("Content-type", $row[$fileTypeFld]);
                    } else {
                        AddHeader("Content-type", ContentType($val));
                    }

                    // Write file name
                    $downloadPdf = !Config("EMBED_PDF") && Config("DOWNLOAD_PDF_FILE");
                    if ($fileNameFld != "" && !EmptyValue($row[$fileNameFld])) {
                        $fileName = $row[$fileNameFld];
                        $pathinfo = pathinfo($fileName);
                        $ext = strtolower(@$pathinfo["extension"]);
                        $isPdf = SameText($ext, "pdf");
                        if ($downloadPdf || !$isPdf) { // Skip header if not download PDF
                            AddHeader("Content-Disposition", "attachment; filename=\"" . $fileName . "\"");
                        }
                    } else {
                        $ext = ContentExtension($val);
                        $isPdf = SameText($ext, ".pdf");
                        if ($isPdf && $downloadPdf) { // Add header if download PDF
                            AddHeader("Content-Disposition", "attachment; filename=\"" . $fileName . "\"");
                        }
                    }

                    // Write file data
                    if (
                        StartsString("PK", $val) &&
                        ContainsString($val, "[Content_Types].xml") &&
                        ContainsString($val, "_rels") &&
                        ContainsString($val, "docProps")
                    ) { // Fix Office 2007 documents
                        if (!EndsString("\0\0\0", $val)) { // Not ends with 3 or 4 \0
                            $val .= "\0\0\0\0";
                        }
                    }

                    // Clear any debug message
                    if (ob_get_length()) {
                        ob_end_clean();
                    }

                    // Write binary data
                    Write($val);

                // Upload to folder
                } else {
                    if ($fld->UploadMultiple) {
                        $files = explode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $val);
                    } else {
                        $files = [$val];
                    }
                    $data = [];
                    $ar = [];
                    foreach ($files as $file) {
                        if (!EmptyValue($file)) {
                            if (Config("ENCRYPT_FILE_PATH")) {
                                $ar[$file] = FullUrl(GetApiUrl(Config("API_FILE_ACTION") .
                                    "/" . $this->TableVar . "/" . Encrypt($fld->physicalUploadPath() . $file)));
                            } else {
                                $ar[$file] = FullUrl($fld->hrefPath() . $file);
                            }
                        }
                    }
                    $data[$fld->Param] = $ar;
                    WriteJson($data);
                }
            }
            return true;
        }
        return false;
    }

    // Write Audit Trail start/end for grid update
    public function writeAuditTrailDummy($typ)
    {
        $table = 'links';
        $usr = CurrentUserName();
        WriteAuditLog($usr, $typ, $table, "", "", "", "");
    }

    // Write Audit Trail (add page)
    public function writeAuditTrailOnAdd(&$rs)
    {
        global $Language;
        if (!$this->AuditTrailOnAdd) {
            return;
        }
        $table = 'links';

        // Get key value
        $key = "";
        if ($key != "") {
            $key .= Config("COMPOSITE_KEY_SEPARATOR");
        }
        $key .= $rs['ID'];

        // Write Audit Trail
        $usr = CurrentUserName();
        foreach (array_keys($rs) as $fldname) {
            if (array_key_exists($fldname, $this->Fields) && $this->Fields[$fldname]->DataType != DATATYPE_BLOB) { // Ignore BLOB fields
                if ($this->Fields[$fldname]->HtmlTag == "PASSWORD") {
                    $newvalue = $Language->phrase("PasswordMask"); // Password Field
                } elseif ($this->Fields[$fldname]->DataType == DATATYPE_MEMO) {
                    if (Config("AUDIT_TRAIL_TO_DATABASE")) {
                        $newvalue = $rs[$fldname];
                    } else {
                        $newvalue = "[MEMO]"; // Memo Field
                    }
                } elseif ($this->Fields[$fldname]->DataType == DATATYPE_XML) {
                    $newvalue = "[XML]"; // XML Field
                } else {
                    $newvalue = $rs[$fldname];
                }
                WriteAuditLog($usr, "A", $table, $fldname, $key, "", $newvalue);
            }
        }
    }

    // Write Audit Trail (edit page)
    public function writeAuditTrailOnEdit(&$rsold, &$rsnew)
    {
        global $Language;
        if (!$this->AuditTrailOnEdit) {
            return;
        }
        $table = 'links';

        // Get key value
        $key = "";
        if ($key != "") {
            $key .= Config("COMPOSITE_KEY_SEPARATOR");
        }
        $key .= $rsold['ID'];

        // Write Audit Trail
        $usr = CurrentUserName();
        foreach (array_keys($rsnew) as $fldname) {
            if (array_key_exists($fldname, $this->Fields) && array_key_exists($fldname, $rsold) && $this->Fields[$fldname]->DataType != DATATYPE_BLOB) { // Ignore BLOB fields
                if ($this->Fields[$fldname]->DataType == DATATYPE_DATE) { // DateTime field
                    $modified = (FormatDateTime($rsold[$fldname], 0) != FormatDateTime($rsnew[$fldname], 0));
                } else {
                    $modified = !CompareValue($rsold[$fldname], $rsnew[$fldname]);
                }
                if ($modified) {
                    if ($this->Fields[$fldname]->HtmlTag == "PASSWORD") { // Password Field
                        $oldvalue = $Language->phrase("PasswordMask");
                        $newvalue = $Language->phrase("PasswordMask");
                    } elseif ($this->Fields[$fldname]->DataType == DATATYPE_MEMO) { // Memo field
                        if (Config("AUDIT_TRAIL_TO_DATABASE")) {
                            $oldvalue = $rsold[$fldname];
                            $newvalue = $rsnew[$fldname];
                        } else {
                            $oldvalue = "[MEMO]";
                            $newvalue = "[MEMO]";
                        }
                    } elseif ($this->Fields[$fldname]->DataType == DATATYPE_XML) { // XML field
                        $oldvalue = "[XML]";
                        $newvalue = "[XML]";
                    } else {
                        $oldvalue = $rsold[$fldname];
                        $newvalue = $rsnew[$fldname];
                    }
                    WriteAuditLog($usr, "U", $table, $fldname, $key, $oldvalue, $newvalue);
                }
            }
        }
    }

    // Write Audit Trail (delete page)
    public function writeAuditTrailOnDelete(&$rs)
    {
        global $Language;
        if (!$this->AuditTrailOnDelete) {
            return;
        }
        $table = 'links';

        // Get key value
        $key = "";
        if ($key != "") {
            $key .= Config("COMPOSITE_KEY_SEPARATOR");
        }
        $key .= $rs['ID'];

        // Write Audit Trail
        $curUser = CurrentUserName();
        foreach (array_keys($rs) as $fldname) {
            if (array_key_exists($fldname, $this->Fields) && $this->Fields[$fldname]->DataType != DATATYPE_BLOB) { // Ignore BLOB fields
                if ($this->Fields[$fldname]->HtmlTag == "PASSWORD") {
                    $oldvalue = $Language->phrase("PasswordMask"); // Password Field
                } elseif ($this->Fields[$fldname]->DataType == DATATYPE_MEMO) {
                    if (Config("AUDIT_TRAIL_TO_DATABASE")) {
                        $oldvalue = $rs[$fldname];
                    } else {
                        $oldvalue = "[MEMO]"; // Memo field
                    }
                } elseif ($this->Fields[$fldname]->DataType == DATATYPE_XML) {
                    $oldvalue = "[XML]"; // XML field
                } else {
                    $oldvalue = $rs[$fldname];
                }
                WriteAuditLog($curUser, "D", $table, $fldname, $key, $oldvalue, "");
            }
        }
    }

    // Table level events

    // Recordset Selecting event
    public function recordsetSelecting(&$filter)
    {
        // Enter your code here
    }

    // Recordset Selected event
    public function recordsetSelected(&$rs)
    {
        //Log("Recordset Selected");
    }

    // Recordset Search Validated event
    public function recordsetSearchValidated()
    {
        // Example:
        //$this->MyField1->AdvancedSearch->SearchValue = "your search criteria"; // Search value
    }

    // Recordset Searching event
    public function recordsetSearching(&$filter)
    {
        // Enter your code here
    }

    // Row_Selecting event
    public function rowSelecting(&$filter)
    {
        // Enter your code here
    }

    // Row Selected event
    public function rowSelected(&$rs)
    {
        //Log("Row Selected");
    }

    // Row Inserting event
    public function rowInserting($rsold, &$rsnew)
    {
        // Enter your code here
        // To cancel, set return value to false
        return true;
    }

    // Row Inserted event
    public function rowInserted($rsold, &$rsnew)
    {
        //Log("Row Inserted");
    }

    // Row Updating event
    public function rowUpdating($rsold, &$rsnew)
    {
        // Enter your code here
        // To cancel, set return value to false
        return true;
    }

    // Row Updated event
    public function rowUpdated($rsold, &$rsnew)
    {
        //Log("Row Updated");
    }

    // Row Update Conflict event
    public function rowUpdateConflict($rsold, &$rsnew)
    {
        // Enter your code here
        // To ignore conflict, set return value to false
        return true;
    }

    // Grid Inserting event
    public function gridInserting()
    {
        // Enter your code here
        // To reject grid insert, set return value to false
        return true;
    }

    // Grid Inserted event
    public function gridInserted($rsnew)
    {
        //Log("Grid Inserted");
    }

    // Grid Updating event
    public function gridUpdating($rsold)
    {
        // Enter your code here
        // To reject grid update, set return value to false
        return true;
    }

    // Grid Updated event
    public function gridUpdated($rsold, $rsnew)
    {
        //Log("Grid Updated");
    }

    // Row Deleting event
    public function rowDeleting(&$rs)
    {
        // Enter your code here
        // To cancel, set return value to False
        return true;
    }

    // Row Deleted event
    public function rowDeleted(&$rs)
    {
        //Log("Row Deleted");
    }

    // Email Sending event
    public function emailSending($email, &$args)
    {
        //var_dump($email); var_dump($args); exit();
        return true;
    }

    // Lookup Selecting event
    public function lookupSelecting($fld, &$filter)
    {
        //var_dump($fld->Name, $fld->Lookup, $filter); // Uncomment to view the filter
        // Enter your code here
    }

    // Row Rendering event
    public function rowRendering()
    {
        // Enter your code here
    }

    // Row Rendered event
    public function rowRendered()
    {
        // To view properties of field class, use:
        //var_dump($this-><FieldName>);
    }

    // User ID Filtering event
    public function userIdFiltering(&$filter)
    {
        // Enter your code here
    }
}
