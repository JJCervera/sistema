<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "titulares2Dequipos2Dtutoresinfo.php" ?>
<?php include_once "usuariosinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$titulares2Dequipos2Dtutores_list = NULL; // Initialize page object first

class ctitulares2Dequipos2Dtutores_list extends ctitulares2Dequipos2Dtutores {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = "{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}";

	// Table name
	var $TableName = 'titulares-equipos-tutores';

	// Page object name
	var $PageObjName = 'titulares2Dequipos2Dtutores_list';

	// Grid form hidden field names
	var $FormName = 'ftitulares2Dequipos2Dtutoreslist';
	var $FormActionName = 'k_action';
	var $FormKeyName = 'k_key';
	var $FormOldKeyName = 'k_oldkey';
	var $FormBlankRowName = 'k_blankrow';
	var $FormKeyCountName = 'key_count';

	// Page name
	function PageName() {
		return ew_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ew_CurrentPage() . "?";
		if ($this->UseTokenInUrl) $PageUrl .= "t=" . $this->TableVar . "&"; // Add page token
		return $PageUrl;
	}

	// Page URLs
	var $AddUrl;
	var $EditUrl;
	var $CopyUrl;
	var $DeleteUrl;
	var $ViewUrl;
	var $ListUrl;

	// Export URLs
	var $ExportPrintUrl;
	var $ExportHtmlUrl;
	var $ExportExcelUrl;
	var $ExportWordUrl;
	var $ExportXmlUrl;
	var $ExportCsvUrl;
	var $ExportPdfUrl;

	// Custom export
	var $ExportExcelCustom = FALSE;
	var $ExportWordCustom = FALSE;
	var $ExportPdfCustom = FALSE;
	var $ExportEmailCustom = FALSE;

	// Update URLs
	var $InlineAddUrl;
	var $InlineCopyUrl;
	var $InlineEditUrl;
	var $GridAddUrl;
	var $GridEditUrl;
	var $MultiDeleteUrl;
	var $MultiUpdateUrl;

	// Message
	function getMessage() {
		return @$_SESSION[EW_SESSION_MESSAGE];
	}

	function setMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_MESSAGE], $v);
	}

	function getFailureMessage() {
		return @$_SESSION[EW_SESSION_FAILURE_MESSAGE];
	}

	function setFailureMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_FAILURE_MESSAGE], $v);
	}

	function getSuccessMessage() {
		return @$_SESSION[EW_SESSION_SUCCESS_MESSAGE];
	}

	function setSuccessMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_SUCCESS_MESSAGE], $v);
	}

	function getWarningMessage() {
		return @$_SESSION[EW_SESSION_WARNING_MESSAGE];
	}

	function setWarningMessage($v) {
		ew_AddMessage($_SESSION[EW_SESSION_WARNING_MESSAGE], $v);
	}

	// Methods to clear message
	function ClearMessage() {
		$_SESSION[EW_SESSION_MESSAGE] = "";
	}

	function ClearFailureMessage() {
		$_SESSION[EW_SESSION_FAILURE_MESSAGE] = "";
	}

	function ClearSuccessMessage() {
		$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = "";
	}

	function ClearWarningMessage() {
		$_SESSION[EW_SESSION_WARNING_MESSAGE] = "";
	}

	function ClearMessages() {
		$_SESSION[EW_SESSION_MESSAGE] = "";
		$_SESSION[EW_SESSION_FAILURE_MESSAGE] = "";
		$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = "";
		$_SESSION[EW_SESSION_WARNING_MESSAGE] = "";
	}

	// Show message
	function ShowMessage() {
		$hidden = TRUE;
		$html = "";

		// Message
		$sMessage = $this->getMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sMessage, "");
		if ($sMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sMessage;
			$html .= "<div class=\"alert alert-info ewInfo\">" . $sMessage . "</div>";
			$_SESSION[EW_SESSION_MESSAGE] = ""; // Clear message in Session
		}

		// Warning message
		$sWarningMessage = $this->getWarningMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sWarningMessage, "warning");
		if ($sWarningMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sWarningMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sWarningMessage;
			$html .= "<div class=\"alert alert-warning ewWarning\">" . $sWarningMessage . "</div>";
			$_SESSION[EW_SESSION_WARNING_MESSAGE] = ""; // Clear message in Session
		}

		// Success message
		$sSuccessMessage = $this->getSuccessMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sSuccessMessage, "success");
		if ($sSuccessMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sSuccessMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sSuccessMessage;
			$html .= "<div class=\"alert alert-success ewSuccess\">" . $sSuccessMessage . "</div>";
			$_SESSION[EW_SESSION_SUCCESS_MESSAGE] = ""; // Clear message in Session
		}

		// Failure message
		$sErrorMessage = $this->getFailureMessage();
		if (method_exists($this, "Message_Showing"))
			$this->Message_Showing($sErrorMessage, "failure");
		if ($sErrorMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sErrorMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sErrorMessage;
			$html .= "<div class=\"alert alert-danger ewError\">" . $sErrorMessage . "</div>";
			$_SESSION[EW_SESSION_FAILURE_MESSAGE] = ""; // Clear message in Session
		}
		echo "<div class=\"ewMessageDialog\"" . (($hidden) ? " style=\"display: none;\"" : "") . ">" . $html . "</div>";
	}
	var $PageHeader;
	var $PageFooter;

	// Show Page Header
	function ShowPageHeader() {
		$sHeader = $this->PageHeader;
		$this->Page_DataRendering($sHeader);
		if ($sHeader <> "") { // Header exists, display
			echo "<p>" . $sHeader . "</p>";
		}
	}

	// Show Page Footer
	function ShowPageFooter() {
		$sFooter = $this->PageFooter;
		$this->Page_DataRendered($sFooter);
		if ($sFooter <> "") { // Footer exists, display
			echo "<p>" . $sFooter . "</p>";
		}
	}

	// Validate page request
	function IsPageRequest() {
		global $objForm;
		if ($this->UseTokenInUrl) {
			if ($objForm)
				return ($this->TableVar == $objForm->GetValue("t"));
			if (@$_GET["t"] <> "")
				return ($this->TableVar == $_GET["t"]);
		} else {
			return TRUE;
		}
	}
	var $Token = "";
	var $TokenTimeout = 0;
	var $CheckToken = EW_CHECK_TOKEN;
	var $CheckTokenFn = "ew_CheckToken";
	var $CreateTokenFn = "ew_CreateToken";

	// Valid Post
	function ValidPost() {
		if (!$this->CheckToken || !ew_IsHttpPost())
			return TRUE;
		if (!isset($_POST[EW_TOKEN_NAME]))
			return FALSE;
		$fn = $this->CheckTokenFn;
		if (is_callable($fn))
			return $fn($_POST[EW_TOKEN_NAME], $this->TokenTimeout);
		return FALSE;
	}

	// Create Token
	function CreateToken() {
		global $gsToken;
		if ($this->CheckToken) {
			$fn = $this->CreateTokenFn;
			if ($this->Token == "" && is_callable($fn)) // Create token
				$this->Token = $fn();
			$gsToken = $this->Token; // Save to global variable
		}
	}

	//
	// Page class constructor
	//
	function __construct() {
		global $conn, $Language;
		global $UserTable, $UserTableConn;
		$GLOBALS["Page"] = &$this;
		$this->TokenTimeout = ew_SessionTimeoutTime();

		// Language object
		if (!isset($Language)) $Language = new cLanguage();

		// Parent constuctor
		parent::__construct();

		// Table object (titulares2Dequipos2Dtutores)
		if (!isset($GLOBALS["titulares2Dequipos2Dtutores"]) || get_class($GLOBALS["titulares2Dequipos2Dtutores"]) == "ctitulares2Dequipos2Dtutores") {
			$GLOBALS["titulares2Dequipos2Dtutores"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["titulares2Dequipos2Dtutores"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "titulares2Dequipos2Dtutoresadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "titulares2Dequipos2Dtutoresdelete.php";
		$this->MultiUpdateUrl = "titulares2Dequipos2Dtutoresupdate.php";

		// Table object (usuarios)
		if (!isset($GLOBALS['usuarios'])) $GLOBALS['usuarios'] = new cusuarios();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'titulares-equipos-tutores', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"])) $GLOBALS["gTimer"] = new cTimer();

		// Open connection
		if (!isset($conn)) $conn = ew_Connect($this->DBID);

		// User table object (usuarios)
		if (!isset($UserTable)) {
			$UserTable = new cusuarios();
			$UserTableConn = Conn($UserTable->DBID);
		}

		// List options
		$this->ListOptions = new cListOptions();
		$this->ListOptions->TableVar = $this->TableVar;

		// Export options
		$this->ExportOptions = new cListOptions();
		$this->ExportOptions->Tag = "div";
		$this->ExportOptions->TagClassName = "ewExportOption";

		// Other options
		$this->OtherOptions['addedit'] = new cListOptions();
		$this->OtherOptions['addedit']->Tag = "div";
		$this->OtherOptions['addedit']->TagClassName = "ewAddEditOption";
		$this->OtherOptions['detail'] = new cListOptions();
		$this->OtherOptions['detail']->Tag = "div";
		$this->OtherOptions['detail']->TagClassName = "ewDetailOption";
		$this->OtherOptions['action'] = new cListOptions();
		$this->OtherOptions['action']->Tag = "div";
		$this->OtherOptions['action']->TagClassName = "ewActionOption";

		// Filter options
		$this->FilterOptions = new cListOptions();
		$this->FilterOptions->Tag = "div";
		$this->FilterOptions->TagClassName = "ewFilterOption ftitulares2Dequipos2Dtutoreslistsrch";

		// List actions
		$this->ListActions = new cListActions();
	}

	//
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsCustomExport, $gsExportFile, $UserProfile, $Language, $Security, $objForm;

		// Security
		$Security = new cAdvancedSecurity();
		if (!$Security->IsLoggedIn()) $Security->AutoLogin();
		if ($Security->IsLoggedIn()) $Security->TablePermission_Loading();
		$Security->LoadCurrentUserLevel($this->ProjectID . $this->TableName);
		if ($Security->IsLoggedIn()) $Security->TablePermission_Loaded();
		if (!$Security->CanList()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
			$this->Page_Terminate(ew_GetUrl("index.php"));
		}
		if ($Security->IsLoggedIn()) {
			$Security->UserID_Loading();
			$Security->LoadUserID();
			$Security->UserID_Loaded();
		}

		// Get export parameters
		$custom = "";
		if (@$_GET["export"] <> "") {
			$this->Export = $_GET["export"];
			$custom = @$_GET["custom"];
		} elseif (@$_POST["export"] <> "") {
			$this->Export = $_POST["export"];
			$custom = @$_POST["custom"];
		} elseif (ew_IsHttpPost()) {
			if (@$_POST["exporttype"] <> "")
				$this->Export = $_POST["exporttype"];
			$custom = @$_POST["custom"];
		} else {
			$this->setExportReturnUrl(ew_CurrentUrl());
		}
		$gsExportFile = $this->TableVar; // Get export file, used in header

		// Get custom export parameters
		if ($this->Export <> "" && $custom <> "") {
			$this->CustomExport = $this->Export;
			$this->Export = "print";
		}
		$gsCustomExport = $this->CustomExport;
		$gsExport = $this->Export; // Get export parameter, used in header

		// Update Export URLs
		if (defined("EW_USE_PHPEXCEL"))
			$this->ExportExcelCustom = FALSE;
		if ($this->ExportExcelCustom)
			$this->ExportExcelUrl .= "&amp;custom=1";
		if (defined("EW_USE_PHPWORD"))
			$this->ExportWordCustom = FALSE;
		if ($this->ExportWordCustom)
			$this->ExportWordUrl .= "&amp;custom=1";
		if ($this->ExportPdfCustom)
			$this->ExportPdfUrl .= "&amp;custom=1";
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action

		// Get grid add count
		$gridaddcnt = @$_GET[EW_TABLE_GRID_ADD_ROW_COUNT];
		if (is_numeric($gridaddcnt) && $gridaddcnt > 0)
			$this->GridAddRowCount = $gridaddcnt;

		// Set up list options
		$this->SetupListOptions();

		// Setup export options
		$this->SetupExportOptions();
		$this->Apelldio_y_Nombre_Titular->SetVisibility();
		$this->Dni->SetVisibility();
		$this->Cuil->SetVisibility();
		$this->Equipo_Asignado->SetVisibility();
		$this->Apellido_y_Nombre_Tutor->SetVisibility();
		$this->Dni_Tutor->SetVisibility();
		$this->Cuil_Tutor->SetVisibility();

		// Global Page Loading event (in userfn*.php)
		Page_Loading();

		// Page Load event
		$this->Page_Load();

		// Check token
		if (!$this->ValidPost()) {
			echo $Language->Phrase("InvalidPostRequest");
			$this->Page_Terminate();
			exit();
		}

		// Process auto fill
		if (@$_POST["ajax"] == "autofill") {
			$results = $this->GetAutoFill(@$_POST["name"], @$_POST["q"]);
			if ($results) {

				// Clean output buffer
				if (!EW_DEBUG_ENABLED && ob_get_length())
					ob_end_clean();
				echo $results;
				$this->Page_Terminate();
				exit();
			}
		}

		// Create Token
		$this->CreateToken();

		// Setup other options
		$this->SetupOtherOptions();

		// Set up custom action (compatible with old version)
		foreach ($this->CustomActions as $name => $action)
			$this->ListActions->Add($name, $action);

		// Show checkbox column if multiple action
		foreach ($this->ListActions->Items as $listaction) {
			if ($listaction->Select == EW_ACTION_MULTIPLE && $listaction->Allow) {
				$this->ListOptions->Items["checkbox"]->Visible = TRUE;
				break;
			}
		}
	}

	//
	// Page_Terminate
	//
	function Page_Terminate($url = "") {
		global $gsExportFile, $gTmpImages;

		// Page Unload event
		$this->Page_Unload();

		// Global Page Unloaded event (in userfn*.php)
		Page_Unloaded();

		// Export
		global $EW_EXPORT, $titulares2Dequipos2Dtutores;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($titulares2Dequipos2Dtutores);
				$doc->Text = $sContent;
				if ($this->Export == "email")
					echo $this->ExportEmail($doc->Text);
				else
					$doc->Export();
				ew_DeleteTmpImages(); // Delete temp images
				exit();
			}
		}
		$this->Page_Redirecting($url);

		 // Close connection
		ew_CloseConn();

		// Go to URL if specified
		if ($url <> "") {
			if (!EW_DEBUG_ENABLED && ob_get_length())
				ob_end_clean();
			header("Location: " . $url);
		}
		exit();
	}

	// Class variables
	var $ListOptions; // List options
	var $ExportOptions; // Export options
	var $SearchOptions; // Search options
	var $OtherOptions = array(); // Other options
	var $FilterOptions; // Filter options
	var $ListActions; // List actions
	var $SelectedCount = 0;
	var $SelectedIndex = 0;
	var $DisplayRecs = 25;
	var $StartRec;
	var $StopRec;
	var $TotalRecs = 0;
	var $RecRange = 10;
	var $Pager;
	var $DefaultSearchWhere = ""; // Default search WHERE clause
	var $SearchWhere = ""; // Search WHERE clause
	var $RecCnt = 0; // Record count
	var $EditRowCnt;
	var $StartRowCnt = 1;
	var $RowCnt = 0;
	var $Attrs = array(); // Row attributes and cell attributes
	var $RowIndex = 0; // Row index
	var $KeyCount = 0; // Key count
	var $RowAction = ""; // Row action
	var $RowOldKey = ""; // Row old key (for copy)
	var $RecPerRow = 0;
	var $MultiColumnClass;
	var $MultiColumnEditClass = "col-sm-12";
	var $MultiColumnCnt = 12;
	var $MultiColumnEditCnt = 12;
	var $GridCnt = 0;
	var $ColCnt = 0;
	var $DbMasterFilter = ""; // Master filter
	var $DbDetailFilter = ""; // Detail filter
	var $MasterRecordExists;	
	var $MultiSelectKey;
	var $Command;
	var $RestoreSearch = FALSE;
	var $DetailPages;
	var $Recordset;
	var $OldRecordset;

	//
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError, $gsSearchError, $Security;

		// Search filters
		$sSrchAdvanced = ""; // Advanced search filter
		$sSrchBasic = ""; // Basic search filter
		$sFilter = "";

		// Get command
		$this->Command = strtolower(@$_GET["cmd"]);
		if ($this->IsPageRequest()) { // Validate request

			// Process list action first
			if ($this->ProcessListAction()) // Ajax request
				$this->Page_Terminate();

			// Handle reset command
			$this->ResetCmd();

			// Set up Breadcrumb
			if ($this->Export == "")
				$this->SetupBreadcrumb();

			// Hide list options
			if ($this->Export <> "") {
				$this->ListOptions->HideAllOptions(array("sequence"));
				$this->ListOptions->UseDropDownButton = FALSE; // Disable drop down button
				$this->ListOptions->UseButtonGroup = FALSE; // Disable button group
			} elseif ($this->CurrentAction == "gridadd" || $this->CurrentAction == "gridedit") {
				$this->ListOptions->HideAllOptions();
				$this->ListOptions->UseDropDownButton = FALSE; // Disable drop down button
				$this->ListOptions->UseButtonGroup = FALSE; // Disable button group
			}

			// Hide options
			if ($this->Export <> "" || $this->CurrentAction <> "") {
				$this->ExportOptions->HideAllOptions();
				$this->FilterOptions->HideAllOptions();
			}

			// Hide other options
			if ($this->Export <> "") {
				foreach ($this->OtherOptions as &$option)
					$option->HideAllOptions();
			}

			// Get default search criteria
			ew_AddFilter($this->DefaultSearchWhere, $this->BasicSearchWhere(TRUE));
			ew_AddFilter($this->DefaultSearchWhere, $this->AdvancedSearchWhere(TRUE));

			// Get basic search values
			$this->LoadBasicSearchValues();

			// Get and validate search values for advanced search
			$this->LoadSearchValues(); // Get search values

			// Process filter list
			$this->ProcessFilterList();
			if (!$this->ValidateSearch())
				$this->setFailureMessage($gsSearchError);

			// Restore search parms from Session if not searching / reset / export
			if (($this->Export <> "" || $this->Command <> "search" && $this->Command <> "reset" && $this->Command <> "resetall") && $this->CheckSearchParms())
				$this->RestoreSearchParms();

			// Call Recordset SearchValidated event
			$this->Recordset_SearchValidated();

			// Set up sorting order
			$this->SetUpSortOrder();

			// Get basic search criteria
			if ($gsSearchError == "")
				$sSrchBasic = $this->BasicSearchWhere();

			// Get search criteria for advanced search
			if ($gsSearchError == "")
				$sSrchAdvanced = $this->AdvancedSearchWhere();
		}

		// Restore display records
		if ($this->getRecordsPerPage() <> "") {
			$this->DisplayRecs = $this->getRecordsPerPage(); // Restore from Session
		} else {
			$this->DisplayRecs = 25; // Load default
		}

		// Load Sorting Order
		$this->LoadSortOrder();

		// Load search default if no existing search criteria
		if (!$this->CheckSearchParms()) {

			// Load basic search from default
			$this->BasicSearch->LoadDefault();
			if ($this->BasicSearch->Keyword != "")
				$sSrchBasic = $this->BasicSearchWhere();

			// Load advanced search from default
			if ($this->LoadAdvancedSearchDefault()) {
				$sSrchAdvanced = $this->AdvancedSearchWhere();
			}
		}

		// Build search criteria
		ew_AddFilter($this->SearchWhere, $sSrchAdvanced);
		ew_AddFilter($this->SearchWhere, $sSrchBasic);

		// Call Recordset_Searching event
		$this->Recordset_Searching($this->SearchWhere);

		// Save search criteria
		if ($this->Command == "search" && !$this->RestoreSearch) {
			$this->setSearchWhere($this->SearchWhere); // Save to Session
			$this->StartRec = 1; // Reset start record counter
			$this->setStartRecordNumber($this->StartRec);
		} else {
			$this->SearchWhere = $this->getSearchWhere();
		}

		// Build filter
		$sFilter = "";
		if (!$Security->CanList())
			$sFilter = "(0=1)"; // Filter all records
		ew_AddFilter($sFilter, $this->DbDetailFilter);
		ew_AddFilter($sFilter, $this->SearchWhere);

		// Set up filter in session
		$this->setSessionWhere($sFilter);
		$this->CurrentFilter = "";

		// Export data only
		if ($this->CustomExport == "" && in_array($this->Export, array("html","word","excel","xml","csv","email","pdf"))) {
			$this->ExportData();
			$this->Page_Terminate(); // Terminate response
			exit();
		}

		// Load record count first
		if (!$this->IsAddOrEdit()) {
			$bSelectLimit = $this->UseSelectLimit;
			if ($bSelectLimit) {
				$this->TotalRecs = $this->SelectRecordCount();
			} else {
				if ($this->Recordset = $this->LoadRecordset())
					$this->TotalRecs = $this->Recordset->RecordCount();
			}
		}

		// Search options
		$this->SetupSearchOptions();
	}

	// Build filter for all keys
	function BuildKeyFilter() {
		global $objForm;
		$sWrkFilter = "";

		// Update row index and get row key
		$rowindex = 1;
		$objForm->Index = $rowindex;
		$sThisKey = strval($objForm->GetValue($this->FormKeyName));
		while ($sThisKey <> "") {
			if ($this->SetupKeyValues($sThisKey)) {
				$sFilter = $this->KeyFilter();
				if ($sWrkFilter <> "") $sWrkFilter .= " OR ";
				$sWrkFilter .= $sFilter;
			} else {
				$sWrkFilter = "0=1";
				break;
			}

			// Update row index and get row key
			$rowindex++; // Next row
			$objForm->Index = $rowindex;
			$sThisKey = strval($objForm->GetValue($this->FormKeyName));
		}
		return $sWrkFilter;
	}

	// Set up key values
	function SetupKeyValues($key) {
		$arrKeyFlds = explode($GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"], $key);
		if (count($arrKeyFlds) >= 2) {
			$this->Dni->setFormValue($arrKeyFlds[0]);
			if (!is_numeric($this->Dni->FormValue))
				return FALSE;
			$this->Dni_Tutor->setFormValue($arrKeyFlds[1]);
			if (!is_numeric($this->Dni_Tutor->FormValue))
				return FALSE;
		}
		return TRUE;
	}

	// Get list of filters
	function GetFilterList() {
		global $UserProfile;

		// Load server side filters
		if (EW_SEARCH_FILTER_OPTION == "Server") {
			$sSavedFilterList = $UserProfile->GetSearchFilters(CurrentUserName(), "ftitulares2Dequipos2Dtutoreslistsrch");
		} else {
			$sSavedFilterList = "";
		}

		// Initialize
		$sFilterList = "";
		$sFilterList = ew_Concat($sFilterList, $this->Apelldio_y_Nombre_Titular->AdvancedSearch->ToJSON(), ","); // Field Apelldio y Nombre Titular
		$sFilterList = ew_Concat($sFilterList, $this->Dni->AdvancedSearch->ToJSON(), ","); // Field Dni
		$sFilterList = ew_Concat($sFilterList, $this->Cuil->AdvancedSearch->ToJSON(), ","); // Field Cuil
		$sFilterList = ew_Concat($sFilterList, $this->Id_Curso->AdvancedSearch->ToJSON(), ","); // Field Id_Curso
		$sFilterList = ew_Concat($sFilterList, $this->Id_Division->AdvancedSearch->ToJSON(), ","); // Field Id_Division
		$sFilterList = ew_Concat($sFilterList, $this->Id_Turno->AdvancedSearch->ToJSON(), ","); // Field Id_Turno
		$sFilterList = ew_Concat($sFilterList, $this->Id_Cargo->AdvancedSearch->ToJSON(), ","); // Field Id_Cargo
		$sFilterList = ew_Concat($sFilterList, $this->Id_Estado->AdvancedSearch->ToJSON(), ","); // Field Id_Estado
		$sFilterList = ew_Concat($sFilterList, $this->Equipo_Asignado->AdvancedSearch->ToJSON(), ","); // Field Equipo Asignado
		$sFilterList = ew_Concat($sFilterList, $this->Apellido_y_Nombre_Tutor->AdvancedSearch->ToJSON(), ","); // Field Apellido y Nombre Tutor
		$sFilterList = ew_Concat($sFilterList, $this->Dni_Tutor->AdvancedSearch->ToJSON(), ","); // Field Dni Tutor
		$sFilterList = ew_Concat($sFilterList, $this->Cuil_Tutor->AdvancedSearch->ToJSON(), ","); // Field Cuil Tutor
		if ($this->BasicSearch->Keyword <> "") {
			$sWrk = "\"" . EW_TABLE_BASIC_SEARCH . "\":\"" . ew_JsEncode2($this->BasicSearch->Keyword) . "\",\"" . EW_TABLE_BASIC_SEARCH_TYPE . "\":\"" . ew_JsEncode2($this->BasicSearch->Type) . "\"";
			$sFilterList = ew_Concat($sFilterList, $sWrk, ",");
		}
		$sFilterList = preg_replace('/,$/', "", $sFilterList);

		// Return filter list in json
		if ($sFilterList <> "")
			$sFilterList = "\"data\":{" . $sFilterList . "}";
		if ($sSavedFilterList <> "") {
			if ($sFilterList <> "")
				$sFilterList .= ",";
			$sFilterList .= "\"filters\":" . $sSavedFilterList;
		}
		return ($sFilterList <> "") ? "{" . $sFilterList . "}" : "null";
	}

	// Process filter list
	function ProcessFilterList() {
		global $UserProfile;
		if (@$_POST["cmd"] == "savefilters") {
			$filters = ew_StripSlashes(@$_POST["filters"]);
			$UserProfile->SetSearchFilters(CurrentUserName(), "ftitulares2Dequipos2Dtutoreslistsrch", $filters);
		} elseif (@$_POST["cmd"] == "resetfilter") {
			$this->RestoreFilterList();
		}
	}

	// Restore list of filters
	function RestoreFilterList() {

		// Return if not reset filter
		if (@$_POST["cmd"] <> "resetfilter")
			return FALSE;
		$filter = json_decode(ew_StripSlashes(@$_POST["filter"]), TRUE);
		$this->Command = "search";

		// Field Apelldio y Nombre Titular
		$this->Apelldio_y_Nombre_Titular->AdvancedSearch->SearchValue = @$filter["x_Apelldio_y_Nombre_Titular"];
		$this->Apelldio_y_Nombre_Titular->AdvancedSearch->SearchOperator = @$filter["z_Apelldio_y_Nombre_Titular"];
		$this->Apelldio_y_Nombre_Titular->AdvancedSearch->SearchCondition = @$filter["v_Apelldio_y_Nombre_Titular"];
		$this->Apelldio_y_Nombre_Titular->AdvancedSearch->SearchValue2 = @$filter["y_Apelldio_y_Nombre_Titular"];
		$this->Apelldio_y_Nombre_Titular->AdvancedSearch->SearchOperator2 = @$filter["w_Apelldio_y_Nombre_Titular"];
		$this->Apelldio_y_Nombre_Titular->AdvancedSearch->Save();

		// Field Dni
		$this->Dni->AdvancedSearch->SearchValue = @$filter["x_Dni"];
		$this->Dni->AdvancedSearch->SearchOperator = @$filter["z_Dni"];
		$this->Dni->AdvancedSearch->SearchCondition = @$filter["v_Dni"];
		$this->Dni->AdvancedSearch->SearchValue2 = @$filter["y_Dni"];
		$this->Dni->AdvancedSearch->SearchOperator2 = @$filter["w_Dni"];
		$this->Dni->AdvancedSearch->Save();

		// Field Cuil
		$this->Cuil->AdvancedSearch->SearchValue = @$filter["x_Cuil"];
		$this->Cuil->AdvancedSearch->SearchOperator = @$filter["z_Cuil"];
		$this->Cuil->AdvancedSearch->SearchCondition = @$filter["v_Cuil"];
		$this->Cuil->AdvancedSearch->SearchValue2 = @$filter["y_Cuil"];
		$this->Cuil->AdvancedSearch->SearchOperator2 = @$filter["w_Cuil"];
		$this->Cuil->AdvancedSearch->Save();

		// Field Id_Curso
		$this->Id_Curso->AdvancedSearch->SearchValue = @$filter["x_Id_Curso"];
		$this->Id_Curso->AdvancedSearch->SearchOperator = @$filter["z_Id_Curso"];
		$this->Id_Curso->AdvancedSearch->SearchCondition = @$filter["v_Id_Curso"];
		$this->Id_Curso->AdvancedSearch->SearchValue2 = @$filter["y_Id_Curso"];
		$this->Id_Curso->AdvancedSearch->SearchOperator2 = @$filter["w_Id_Curso"];
		$this->Id_Curso->AdvancedSearch->Save();

		// Field Id_Division
		$this->Id_Division->AdvancedSearch->SearchValue = @$filter["x_Id_Division"];
		$this->Id_Division->AdvancedSearch->SearchOperator = @$filter["z_Id_Division"];
		$this->Id_Division->AdvancedSearch->SearchCondition = @$filter["v_Id_Division"];
		$this->Id_Division->AdvancedSearch->SearchValue2 = @$filter["y_Id_Division"];
		$this->Id_Division->AdvancedSearch->SearchOperator2 = @$filter["w_Id_Division"];
		$this->Id_Division->AdvancedSearch->Save();

		// Field Id_Turno
		$this->Id_Turno->AdvancedSearch->SearchValue = @$filter["x_Id_Turno"];
		$this->Id_Turno->AdvancedSearch->SearchOperator = @$filter["z_Id_Turno"];
		$this->Id_Turno->AdvancedSearch->SearchCondition = @$filter["v_Id_Turno"];
		$this->Id_Turno->AdvancedSearch->SearchValue2 = @$filter["y_Id_Turno"];
		$this->Id_Turno->AdvancedSearch->SearchOperator2 = @$filter["w_Id_Turno"];
		$this->Id_Turno->AdvancedSearch->Save();

		// Field Id_Cargo
		$this->Id_Cargo->AdvancedSearch->SearchValue = @$filter["x_Id_Cargo"];
		$this->Id_Cargo->AdvancedSearch->SearchOperator = @$filter["z_Id_Cargo"];
		$this->Id_Cargo->AdvancedSearch->SearchCondition = @$filter["v_Id_Cargo"];
		$this->Id_Cargo->AdvancedSearch->SearchValue2 = @$filter["y_Id_Cargo"];
		$this->Id_Cargo->AdvancedSearch->SearchOperator2 = @$filter["w_Id_Cargo"];
		$this->Id_Cargo->AdvancedSearch->Save();

		// Field Id_Estado
		$this->Id_Estado->AdvancedSearch->SearchValue = @$filter["x_Id_Estado"];
		$this->Id_Estado->AdvancedSearch->SearchOperator = @$filter["z_Id_Estado"];
		$this->Id_Estado->AdvancedSearch->SearchCondition = @$filter["v_Id_Estado"];
		$this->Id_Estado->AdvancedSearch->SearchValue2 = @$filter["y_Id_Estado"];
		$this->Id_Estado->AdvancedSearch->SearchOperator2 = @$filter["w_Id_Estado"];
		$this->Id_Estado->AdvancedSearch->Save();

		// Field Equipo Asignado
		$this->Equipo_Asignado->AdvancedSearch->SearchValue = @$filter["x_Equipo_Asignado"];
		$this->Equipo_Asignado->AdvancedSearch->SearchOperator = @$filter["z_Equipo_Asignado"];
		$this->Equipo_Asignado->AdvancedSearch->SearchCondition = @$filter["v_Equipo_Asignado"];
		$this->Equipo_Asignado->AdvancedSearch->SearchValue2 = @$filter["y_Equipo_Asignado"];
		$this->Equipo_Asignado->AdvancedSearch->SearchOperator2 = @$filter["w_Equipo_Asignado"];
		$this->Equipo_Asignado->AdvancedSearch->Save();

		// Field Apellido y Nombre Tutor
		$this->Apellido_y_Nombre_Tutor->AdvancedSearch->SearchValue = @$filter["x_Apellido_y_Nombre_Tutor"];
		$this->Apellido_y_Nombre_Tutor->AdvancedSearch->SearchOperator = @$filter["z_Apellido_y_Nombre_Tutor"];
		$this->Apellido_y_Nombre_Tutor->AdvancedSearch->SearchCondition = @$filter["v_Apellido_y_Nombre_Tutor"];
		$this->Apellido_y_Nombre_Tutor->AdvancedSearch->SearchValue2 = @$filter["y_Apellido_y_Nombre_Tutor"];
		$this->Apellido_y_Nombre_Tutor->AdvancedSearch->SearchOperator2 = @$filter["w_Apellido_y_Nombre_Tutor"];
		$this->Apellido_y_Nombre_Tutor->AdvancedSearch->Save();

		// Field Dni Tutor
		$this->Dni_Tutor->AdvancedSearch->SearchValue = @$filter["x_Dni_Tutor"];
		$this->Dni_Tutor->AdvancedSearch->SearchOperator = @$filter["z_Dni_Tutor"];
		$this->Dni_Tutor->AdvancedSearch->SearchCondition = @$filter["v_Dni_Tutor"];
		$this->Dni_Tutor->AdvancedSearch->SearchValue2 = @$filter["y_Dni_Tutor"];
		$this->Dni_Tutor->AdvancedSearch->SearchOperator2 = @$filter["w_Dni_Tutor"];
		$this->Dni_Tutor->AdvancedSearch->Save();

		// Field Cuil Tutor
		$this->Cuil_Tutor->AdvancedSearch->SearchValue = @$filter["x_Cuil_Tutor"];
		$this->Cuil_Tutor->AdvancedSearch->SearchOperator = @$filter["z_Cuil_Tutor"];
		$this->Cuil_Tutor->AdvancedSearch->SearchCondition = @$filter["v_Cuil_Tutor"];
		$this->Cuil_Tutor->AdvancedSearch->SearchValue2 = @$filter["y_Cuil_Tutor"];
		$this->Cuil_Tutor->AdvancedSearch->SearchOperator2 = @$filter["w_Cuil_Tutor"];
		$this->Cuil_Tutor->AdvancedSearch->Save();
		$this->BasicSearch->setKeyword(@$filter[EW_TABLE_BASIC_SEARCH]);
		$this->BasicSearch->setType(@$filter[EW_TABLE_BASIC_SEARCH_TYPE]);
	}

	// Advanced search WHERE clause based on QueryString
	function AdvancedSearchWhere($Default = FALSE) {
		global $Security;
		$sWhere = "";
		if (!$Security->CanSearch()) return "";
		$this->BuildSearchSql($sWhere, $this->Apelldio_y_Nombre_Titular, $Default, FALSE); // Apelldio y Nombre Titular
		$this->BuildSearchSql($sWhere, $this->Dni, $Default, FALSE); // Dni
		$this->BuildSearchSql($sWhere, $this->Cuil, $Default, FALSE); // Cuil
		$this->BuildSearchSql($sWhere, $this->Id_Curso, $Default, FALSE); // Id_Curso
		$this->BuildSearchSql($sWhere, $this->Id_Division, $Default, FALSE); // Id_Division
		$this->BuildSearchSql($sWhere, $this->Id_Turno, $Default, FALSE); // Id_Turno
		$this->BuildSearchSql($sWhere, $this->Id_Cargo, $Default, FALSE); // Id_Cargo
		$this->BuildSearchSql($sWhere, $this->Id_Estado, $Default, FALSE); // Id_Estado
		$this->BuildSearchSql($sWhere, $this->Equipo_Asignado, $Default, FALSE); // Equipo Asignado
		$this->BuildSearchSql($sWhere, $this->Apellido_y_Nombre_Tutor, $Default, FALSE); // Apellido y Nombre Tutor
		$this->BuildSearchSql($sWhere, $this->Dni_Tutor, $Default, FALSE); // Dni Tutor
		$this->BuildSearchSql($sWhere, $this->Cuil_Tutor, $Default, FALSE); // Cuil Tutor

		// Set up search parm
		if (!$Default && $sWhere <> "") {
			$this->Command = "search";
		}
		if (!$Default && $this->Command == "search") {
			$this->Apelldio_y_Nombre_Titular->AdvancedSearch->Save(); // Apelldio y Nombre Titular
			$this->Dni->AdvancedSearch->Save(); // Dni
			$this->Cuil->AdvancedSearch->Save(); // Cuil
			$this->Id_Curso->AdvancedSearch->Save(); // Id_Curso
			$this->Id_Division->AdvancedSearch->Save(); // Id_Division
			$this->Id_Turno->AdvancedSearch->Save(); // Id_Turno
			$this->Id_Cargo->AdvancedSearch->Save(); // Id_Cargo
			$this->Id_Estado->AdvancedSearch->Save(); // Id_Estado
			$this->Equipo_Asignado->AdvancedSearch->Save(); // Equipo Asignado
			$this->Apellido_y_Nombre_Tutor->AdvancedSearch->Save(); // Apellido y Nombre Tutor
			$this->Dni_Tutor->AdvancedSearch->Save(); // Dni Tutor
			$this->Cuil_Tutor->AdvancedSearch->Save(); // Cuil Tutor
		}
		return $sWhere;
	}

	// Build search SQL
	function BuildSearchSql(&$Where, &$Fld, $Default, $MultiValue) {
		$FldParm = substr($Fld->FldVar, 2);
		$FldVal = ($Default) ? $Fld->AdvancedSearch->SearchValueDefault : $Fld->AdvancedSearch->SearchValue; // @$_GET["x_$FldParm"]
		$FldOpr = ($Default) ? $Fld->AdvancedSearch->SearchOperatorDefault : $Fld->AdvancedSearch->SearchOperator; // @$_GET["z_$FldParm"]
		$FldCond = ($Default) ? $Fld->AdvancedSearch->SearchConditionDefault : $Fld->AdvancedSearch->SearchCondition; // @$_GET["v_$FldParm"]
		$FldVal2 = ($Default) ? $Fld->AdvancedSearch->SearchValue2Default : $Fld->AdvancedSearch->SearchValue2; // @$_GET["y_$FldParm"]
		$FldOpr2 = ($Default) ? $Fld->AdvancedSearch->SearchOperator2Default : $Fld->AdvancedSearch->SearchOperator2; // @$_GET["w_$FldParm"]
		$sWrk = "";

		//$FldVal = ew_StripSlashes($FldVal);
		if (is_array($FldVal)) $FldVal = implode(",", $FldVal);

		//$FldVal2 = ew_StripSlashes($FldVal2);
		if (is_array($FldVal2)) $FldVal2 = implode(",", $FldVal2);
		$FldOpr = strtoupper(trim($FldOpr));
		if ($FldOpr == "") $FldOpr = "=";
		$FldOpr2 = strtoupper(trim($FldOpr2));
		if ($FldOpr2 == "") $FldOpr2 = "=";
		if (EW_SEARCH_MULTI_VALUE_OPTION == 1 || $FldOpr <> "LIKE" ||
			($FldOpr2 <> "LIKE" && $FldVal2 <> ""))
			$MultiValue = FALSE;
		if ($MultiValue) {
			$sWrk1 = ($FldVal <> "") ? ew_GetMultiSearchSql($Fld, $FldOpr, $FldVal, $this->DBID) : ""; // Field value 1
			$sWrk2 = ($FldVal2 <> "") ? ew_GetMultiSearchSql($Fld, $FldOpr2, $FldVal2, $this->DBID) : ""; // Field value 2
			$sWrk = $sWrk1; // Build final SQL
			if ($sWrk2 <> "")
				$sWrk = ($sWrk <> "") ? "($sWrk) $FldCond ($sWrk2)" : $sWrk2;
		} else {
			$FldVal = $this->ConvertSearchValue($Fld, $FldVal);
			$FldVal2 = $this->ConvertSearchValue($Fld, $FldVal2);
			$sWrk = ew_GetSearchSql($Fld, $FldVal, $FldOpr, $FldCond, $FldVal2, $FldOpr2, $this->DBID);
		}
		ew_AddFilter($Where, $sWrk);
	}

	// Convert search value
	function ConvertSearchValue(&$Fld, $FldVal) {
		if ($FldVal == EW_NULL_VALUE || $FldVal == EW_NOT_NULL_VALUE)
			return $FldVal;
		$Value = $FldVal;
		if ($Fld->FldDataType == EW_DATATYPE_BOOLEAN) {
			if ($FldVal <> "") $Value = ($FldVal == "1" || strtolower(strval($FldVal)) == "y" || strtolower(strval($FldVal)) == "t") ? $Fld->TrueValue : $Fld->FalseValue;
		} elseif ($Fld->FldDataType == EW_DATATYPE_DATE || $Fld->FldDataType == EW_DATATYPE_TIME) {
			if ($FldVal <> "") $Value = ew_UnFormatDateTime($FldVal, $Fld->FldDateTimeFormat);
		}
		return $Value;
	}

	// Return basic search SQL
	function BasicSearchSQL($arKeywords, $type) {
		$sWhere = "";
		$this->BuildBasicSearchSQL($sWhere, $this->Apelldio_y_Nombre_Titular, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Dni, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Cuil, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Id_Curso, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Id_Division, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Id_Turno, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Id_Cargo, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Id_Estado, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Equipo_Asignado, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Apellido_y_Nombre_Tutor, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Dni_Tutor, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Cuil_Tutor, $arKeywords, $type);
		return $sWhere;
	}

	// Build basic search SQL
	function BuildBasicSearchSql(&$Where, &$Fld, $arKeywords, $type) {
		$sDefCond = ($type == "OR") ? "OR" : "AND";
		$arSQL = array(); // Array for SQL parts
		$arCond = array(); // Array for search conditions
		$cnt = count($arKeywords);
		$j = 0; // Number of SQL parts
		for ($i = 0; $i < $cnt; $i++) {
			$Keyword = $arKeywords[$i];
			$Keyword = trim($Keyword);
			if (EW_BASIC_SEARCH_IGNORE_PATTERN <> "") {
				$Keyword = preg_replace(EW_BASIC_SEARCH_IGNORE_PATTERN, "\\", $Keyword);
				$ar = explode("\\", $Keyword);
			} else {
				$ar = array($Keyword);
			}
			foreach ($ar as $Keyword) {
				if ($Keyword <> "") {
					$sWrk = "";
					if ($Keyword == "OR" && $type == "") {
						if ($j > 0)
							$arCond[$j-1] = "OR";
					} elseif ($Keyword == EW_NULL_VALUE) {
						$sWrk = $Fld->FldExpression . " IS NULL";
					} elseif ($Keyword == EW_NOT_NULL_VALUE) {
						$sWrk = $Fld->FldExpression . " IS NOT NULL";
					} elseif ($Fld->FldIsVirtual && $Fld->FldVirtualSearch) {
						$sWrk = $Fld->FldVirtualExpression . ew_Like(ew_QuotedValue("%" . $Keyword . "%", EW_DATATYPE_STRING, $this->DBID), $this->DBID);
					} elseif ($Fld->FldDataType != EW_DATATYPE_NUMBER || is_numeric($Keyword)) {
						$sWrk = $Fld->FldBasicSearchExpression . ew_Like(ew_QuotedValue("%" . $Keyword . "%", EW_DATATYPE_STRING, $this->DBID), $this->DBID);
					}
					if ($sWrk <> "") {
						$arSQL[$j] = $sWrk;
						$arCond[$j] = $sDefCond;
						$j += 1;
					}
				}
			}
		}
		$cnt = count($arSQL);
		$bQuoted = FALSE;
		$sSql = "";
		if ($cnt > 0) {
			for ($i = 0; $i < $cnt-1; $i++) {
				if ($arCond[$i] == "OR") {
					if (!$bQuoted) $sSql .= "(";
					$bQuoted = TRUE;
				}
				$sSql .= $arSQL[$i];
				if ($bQuoted && $arCond[$i] <> "OR") {
					$sSql .= ")";
					$bQuoted = FALSE;
				}
				$sSql .= " " . $arCond[$i] . " ";
			}
			$sSql .= $arSQL[$cnt-1];
			if ($bQuoted)
				$sSql .= ")";
		}
		if ($sSql <> "") {
			if ($Where <> "") $Where .= " OR ";
			$Where .=  "(" . $sSql . ")";
		}
	}

	// Return basic search WHERE clause based on search keyword and type
	function BasicSearchWhere($Default = FALSE) {
		global $Security;
		$sSearchStr = "";
		if (!$Security->CanSearch()) return "";
		$sSearchKeyword = ($Default) ? $this->BasicSearch->KeywordDefault : $this->BasicSearch->Keyword;
		$sSearchType = ($Default) ? $this->BasicSearch->TypeDefault : $this->BasicSearch->Type;
		if ($sSearchKeyword <> "") {
			$sSearch = trim($sSearchKeyword);
			if ($sSearchType <> "=") {
				$ar = array();

				// Match quoted keywords (i.e.: "...")
				if (preg_match_all('/"([^"]*)"/i', $sSearch, $matches, PREG_SET_ORDER)) {
					foreach ($matches as $match) {
						$p = strpos($sSearch, $match[0]);
						$str = substr($sSearch, 0, $p);
						$sSearch = substr($sSearch, $p + strlen($match[0]));
						if (strlen(trim($str)) > 0)
							$ar = array_merge($ar, explode(" ", trim($str)));
						$ar[] = $match[1]; // Save quoted keyword
					}
				}

				// Match individual keywords
				if (strlen(trim($sSearch)) > 0)
					$ar = array_merge($ar, explode(" ", trim($sSearch)));

				// Search keyword in any fields
				if (($sSearchType == "OR" || $sSearchType == "AND") && $this->BasicSearch->BasicSearchAnyFields) {
					foreach ($ar as $sKeyword) {
						if ($sKeyword <> "") {
							if ($sSearchStr <> "") $sSearchStr .= " " . $sSearchType . " ";
							$sSearchStr .= "(" . $this->BasicSearchSQL(array($sKeyword), $sSearchType) . ")";
						}
					}
				} else {
					$sSearchStr = $this->BasicSearchSQL($ar, $sSearchType);
				}
			} else {
				$sSearchStr = $this->BasicSearchSQL(array($sSearch), $sSearchType);
			}
			if (!$Default) $this->Command = "search";
		}
		if (!$Default && $this->Command == "search") {
			$this->BasicSearch->setKeyword($sSearchKeyword);
			$this->BasicSearch->setType($sSearchType);
		}
		return $sSearchStr;
	}

	// Check if search parm exists
	function CheckSearchParms() {

		// Check basic search
		if ($this->BasicSearch->IssetSession())
			return TRUE;
		if ($this->Apelldio_y_Nombre_Titular->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Dni->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Cuil->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Id_Curso->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Id_Division->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Id_Turno->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Id_Cargo->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Id_Estado->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Equipo_Asignado->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Apellido_y_Nombre_Tutor->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Dni_Tutor->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Cuil_Tutor->AdvancedSearch->IssetSession())
			return TRUE;
		return FALSE;
	}

	// Clear all search parameters
	function ResetSearchParms() {

		// Clear search WHERE clause
		$this->SearchWhere = "";
		$this->setSearchWhere($this->SearchWhere);

		// Clear basic search parameters
		$this->ResetBasicSearchParms();

		// Clear advanced search parameters
		$this->ResetAdvancedSearchParms();
	}

	// Load advanced search default values
	function LoadAdvancedSearchDefault() {
		return FALSE;
	}

	// Clear all basic search parameters
	function ResetBasicSearchParms() {
		$this->BasicSearch->UnsetSession();
	}

	// Clear all advanced search parameters
	function ResetAdvancedSearchParms() {
		$this->Apelldio_y_Nombre_Titular->AdvancedSearch->UnsetSession();
		$this->Dni->AdvancedSearch->UnsetSession();
		$this->Cuil->AdvancedSearch->UnsetSession();
		$this->Id_Curso->AdvancedSearch->UnsetSession();
		$this->Id_Division->AdvancedSearch->UnsetSession();
		$this->Id_Turno->AdvancedSearch->UnsetSession();
		$this->Id_Cargo->AdvancedSearch->UnsetSession();
		$this->Id_Estado->AdvancedSearch->UnsetSession();
		$this->Equipo_Asignado->AdvancedSearch->UnsetSession();
		$this->Apellido_y_Nombre_Tutor->AdvancedSearch->UnsetSession();
		$this->Dni_Tutor->AdvancedSearch->UnsetSession();
		$this->Cuil_Tutor->AdvancedSearch->UnsetSession();
	}

	// Restore all search parameters
	function RestoreSearchParms() {
		$this->RestoreSearch = TRUE;

		// Restore basic search values
		$this->BasicSearch->Load();

		// Restore advanced search values
		$this->Apelldio_y_Nombre_Titular->AdvancedSearch->Load();
		$this->Dni->AdvancedSearch->Load();
		$this->Cuil->AdvancedSearch->Load();
		$this->Id_Curso->AdvancedSearch->Load();
		$this->Id_Division->AdvancedSearch->Load();
		$this->Id_Turno->AdvancedSearch->Load();
		$this->Id_Cargo->AdvancedSearch->Load();
		$this->Id_Estado->AdvancedSearch->Load();
		$this->Equipo_Asignado->AdvancedSearch->Load();
		$this->Apellido_y_Nombre_Tutor->AdvancedSearch->Load();
		$this->Dni_Tutor->AdvancedSearch->Load();
		$this->Cuil_Tutor->AdvancedSearch->Load();
	}

	// Set up sort parameters
	function SetUpSortOrder() {

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$this->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$this->CurrentOrderType = @$_GET["ordertype"];
			$this->UpdateSort($this->Apelldio_y_Nombre_Titular); // Apelldio y Nombre Titular
			$this->UpdateSort($this->Dni); // Dni
			$this->UpdateSort($this->Cuil); // Cuil
			$this->UpdateSort($this->Equipo_Asignado); // Equipo Asignado
			$this->UpdateSort($this->Apellido_y_Nombre_Tutor); // Apellido y Nombre Tutor
			$this->UpdateSort($this->Dni_Tutor); // Dni Tutor
			$this->UpdateSort($this->Cuil_Tutor); // Cuil Tutor
			$this->setStartRecordNumber(1); // Reset start position
		}
	}

	// Load sort order parameters
	function LoadSortOrder() {
		$sOrderBy = $this->getSessionOrderBy(); // Get ORDER BY from Session
		if ($sOrderBy == "") {
			if ($this->getSqlOrderBy() <> "") {
				$sOrderBy = $this->getSqlOrderBy();
				$this->setSessionOrderBy($sOrderBy);
				$this->Apelldio_y_Nombre_Titular->setSort("ASC");
			}
		}
	}

	// Reset command
	// - cmd=reset (Reset search parameters)
	// - cmd=resetall (Reset search and master/detail parameters)
	// - cmd=resetsort (Reset sort parameters)
	function ResetCmd() {

		// Check if reset command
		if (substr($this->Command,0,5) == "reset") {

			// Reset search criteria
			if ($this->Command == "reset" || $this->Command == "resetall")
				$this->ResetSearchParms();

			// Reset sorting order
			if ($this->Command == "resetsort") {
				$sOrderBy = "";
				$this->setSessionOrderBy($sOrderBy);
				$this->Apelldio_y_Nombre_Titular->setSort("");
				$this->Dni->setSort("");
				$this->Cuil->setSort("");
				$this->Equipo_Asignado->setSort("");
				$this->Apellido_y_Nombre_Tutor->setSort("");
				$this->Dni_Tutor->setSort("");
				$this->Cuil_Tutor->setSort("");
			}

			// Reset start position
			$this->StartRec = 1;
			$this->setStartRecordNumber($this->StartRec);
		}
	}

	// Set up list options
	function SetupListOptions() {
		global $Security, $Language;

		// Add group option item
		$item = &$this->ListOptions->Add($this->ListOptions->GroupOptionName);
		$item->Body = "";
		$item->OnLeft = TRUE;
		$item->Visible = FALSE;

		// "view"
		$item = &$this->ListOptions->Add("view");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->CanView();
		$item->OnLeft = TRUE;

		// List actions
		$item = &$this->ListOptions->Add("listactions");
		$item->CssStyle = "white-space: nowrap;";
		$item->OnLeft = TRUE;
		$item->Visible = FALSE;
		$item->ShowInButtonGroup = FALSE;
		$item->ShowInDropDown = FALSE;

		// "checkbox"
		$item = &$this->ListOptions->Add("checkbox");
		$item->Visible = FALSE;
		$item->OnLeft = TRUE;
		$item->Header = "<input type=\"checkbox\" name=\"key\" id=\"key\" onclick=\"ew_SelectAllKey(this);\">";
		$item->MoveTo(0);
		$item->ShowInDropDown = FALSE;
		$item->ShowInButtonGroup = FALSE;

		// Drop down button for ListOptions
		$this->ListOptions->UseImageAndText = TRUE;
		$this->ListOptions->UseDropDownButton = TRUE;
		$this->ListOptions->DropDownButtonPhrase = $Language->Phrase("ButtonListOptions");
		$this->ListOptions->UseButtonGroup = FALSE;
		if ($this->ListOptions->UseButtonGroup && ew_IsMobile())
			$this->ListOptions->UseDropDownButton = TRUE;
		$this->ListOptions->ButtonClass = "btn-sm"; // Class for button group

		// Call ListOptions_Load event
		$this->ListOptions_Load();
		$this->SetupListOptionsExt();
		$item = &$this->ListOptions->GetItem($this->ListOptions->GroupOptionName);
		$item->Visible = $this->ListOptions->GroupOptionVisible();
	}

	// Render list options
	function RenderListOptions() {
		global $Security, $Language, $objForm;
		$this->ListOptions->LoadDefault();

		// "view"
		$oListOpt = &$this->ListOptions->Items["view"];
		$viewcaption = ew_HtmlTitle($Language->Phrase("ViewLink"));
		if ($Security->CanView()) {
			if (ew_IsMobile())
				$oListOpt->Body = "<a class=\"ewRowLink ewView\" title=\"" . $viewcaption . "\" data-caption=\"" . $viewcaption . "\" href=\"" . ew_HtmlEncode($this->ViewUrl) . "\">" . $Language->Phrase("ViewLink") . "</a>";
			else
				$oListOpt->Body = "<a class=\"ewRowLink ewView\" title=\"" . $viewcaption . "\" data-table=\"titulares2Dequipos2Dtutores\" data-caption=\"" . $viewcaption . "\" href=\"javascript:void(0);\" onclick=\"ew_ModalDialogShow({lnk:this,url:'" . ew_HtmlEncode($this->ViewUrl) . "'});\">" . $Language->Phrase("ViewLink") . "</a>";
		} else {
			$oListOpt->Body = "";
		}

		// Set up list action buttons
		$oListOpt = &$this->ListOptions->GetItem("listactions");
		if ($oListOpt && $this->Export == "" && $this->CurrentAction == "") {
			$body = "";
			$links = array();
			foreach ($this->ListActions->Items as $listaction) {
				if ($listaction->Select == EW_ACTION_SINGLE && $listaction->Allow) {
					$action = $listaction->Action;
					$caption = $listaction->Caption;
					$icon = ($listaction->Icon <> "") ? "<span class=\"" . ew_HtmlEncode(str_replace(" ewIcon", "", $listaction->Icon)) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\"></span> " : "";
					$links[] = "<li><a class=\"ewAction ewListAction\" data-action=\"" . ew_HtmlEncode($action) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({key:" . $this->KeyToJson() . "}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . $listaction->Caption . "</a></li>";
					if (count($links) == 1) // Single button
						$body = "<a class=\"ewAction ewListAction\" data-action=\"" . ew_HtmlEncode($action) . "\" title=\"" . ew_HtmlTitle($caption) . "\" data-caption=\"" . ew_HtmlTitle($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({key:" . $this->KeyToJson() . "}," . $listaction->ToJson(TRUE) . "));return false;\">" . $Language->Phrase("ListActionButton") . "</a>";
				}
			}
			if (count($links) > 1) { // More than one buttons, use dropdown
				$body = "<button class=\"dropdown-toggle btn btn-default btn-sm ewActions\" title=\"" . ew_HtmlTitle($Language->Phrase("ListActionButton")) . "\" data-toggle=\"dropdown\">" . $Language->Phrase("ListActionButton") . "<b class=\"caret\"></b></button>";
				$content = "";
				foreach ($links as $link)
					$content .= "<li>" . $link . "</li>";
				$body .= "<ul class=\"dropdown-menu" . ($oListOpt->OnLeft ? "" : " dropdown-menu-right") . "\">". $content . "</ul>";
				$body = "<div class=\"btn-group\">" . $body . "</div>";
			}
			if (count($links) > 0) {
				$oListOpt->Body = $body;
				$oListOpt->Visible = TRUE;
			}
		}

		// "checkbox"
		$oListOpt = &$this->ListOptions->Items["checkbox"];
		$oListOpt->Body = "<input type=\"checkbox\" name=\"key_m[]\" value=\"" . ew_HtmlEncode($this->Dni->CurrentValue . $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"] . $this->Dni_Tutor->CurrentValue) . "\" onclick='ew_ClickMultiCheckbox(event);'>";
		$this->RenderListOptionsExt();

		// Call ListOptions_Rendered event
		$this->ListOptions_Rendered();
	}

	// Set up other options
	function SetupOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
		$option = $options["action"];

		// Set up options default
		foreach ($options as &$option) {
			$option->UseImageAndText = TRUE;
			$option->UseDropDownButton = FALSE;
			$option->UseButtonGroup = TRUE;
			$option->ButtonClass = "btn-sm"; // Class for button group
			$item = &$option->Add($option->GroupOptionName);
			$item->Body = "";
			$item->Visible = FALSE;
		}
		$options["addedit"]->DropDownButtonPhrase = $Language->Phrase("ButtonAddEdit");
		$options["detail"]->DropDownButtonPhrase = $Language->Phrase("ButtonDetails");
		$options["action"]->DropDownButtonPhrase = $Language->Phrase("ButtonActions");

		// Filter button
		$item = &$this->FilterOptions->Add("savecurrentfilter");
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"ftitulares2Dequipos2Dtutoreslistsrch\" href=\"#\">" . $Language->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = TRUE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"ftitulares2Dequipos2Dtutoreslistsrch\" href=\"#\">" . $Language->Phrase("DeleteFilter") . "</a>";
		$item->Visible = TRUE;
		$this->FilterOptions->UseDropDownButton = TRUE;
		$this->FilterOptions->UseButtonGroup = !$this->FilterOptions->UseDropDownButton;
		$this->FilterOptions->DropDownButtonPhrase = $Language->Phrase("Filters");

		// Add group option item
		$item = &$this->FilterOptions->Add($this->FilterOptions->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;
	}

	// Render other options
	function RenderOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
			$option = &$options["action"];

			// Set up list action buttons
			foreach ($this->ListActions->Items as $listaction) {
				if ($listaction->Select == EW_ACTION_MULTIPLE) {
					$item = &$option->Add("custom_" . $listaction->Action);
					$caption = $listaction->Caption;
					$icon = ($listaction->Icon <> "") ? "<span class=\"" . ew_HtmlEncode($listaction->Icon) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\"></span> " : $caption;
					$item->Body = "<a class=\"ewAction ewListAction\" title=\"" . ew_HtmlEncode($caption) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({f:document.ftitulares2Dequipos2Dtutoreslist}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . "</a>";
					$item->Visible = $listaction->Allow;
				}
			}

			// Hide grid edit and other options
			if ($this->TotalRecs <= 0) {
				$option = &$options["addedit"];
				$item = &$option->GetItem("gridedit");
				if ($item) $item->Visible = FALSE;
				$option = &$options["action"];
				$option->HideAllOptions();
			}
	}

	// Process list action
	function ProcessListAction() {
		global $Language, $Security;
		$userlist = "";
		$user = "";
		$sFilter = $this->GetKeyFilter();
		$UserAction = @$_POST["useraction"];
		if ($sFilter <> "" && $UserAction <> "") {

			// Check permission first
			$ActionCaption = $UserAction;
			if (array_key_exists($UserAction, $this->ListActions->Items)) {
				$ActionCaption = $this->ListActions->Items[$UserAction]->Caption;
				if (!$this->ListActions->Items[$UserAction]->Allow) {
					$errmsg = str_replace('%s', $ActionCaption, $Language->Phrase("CustomActionNotAllowed"));
					if (@$_POST["ajax"] == $UserAction) // Ajax
						echo "<p class=\"text-danger\">" . $errmsg . "</p>";
					else
						$this->setFailureMessage($errmsg);
					return FALSE;
				}
			}
			$this->CurrentFilter = $sFilter;
			$sSql = $this->SQL();
			$conn = &$this->Connection();
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$rs = $conn->Execute($sSql);
			$conn->raiseErrorFn = '';
			$this->CurrentAction = $UserAction;

			// Call row action event
			if ($rs && !$rs->EOF) {
				$conn->BeginTrans();
				$this->SelectedCount = $rs->RecordCount();
				$this->SelectedIndex = 0;
				while (!$rs->EOF) {
					$this->SelectedIndex++;
					$row = $rs->fields;
					$Processed = $this->Row_CustomAction($UserAction, $row);
					if (!$Processed) break;
					$rs->MoveNext();
				}
				if ($Processed) {
					$conn->CommitTrans(); // Commit the changes
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage(str_replace('%s', $ActionCaption, $Language->Phrase("CustomActionCompleted"))); // Set up success message
				} else {
					$conn->RollbackTrans(); // Rollback changes

					// Set up error message
					if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

						// Use the message, do nothing
					} elseif ($this->CancelMessage <> "") {
						$this->setFailureMessage($this->CancelMessage);
						$this->CancelMessage = "";
					} else {
						$this->setFailureMessage(str_replace('%s', $ActionCaption, $Language->Phrase("CustomActionFailed")));
					}
				}
			}
			if ($rs)
				$rs->Close();
			$this->CurrentAction = ""; // Clear action
			if (@$_POST["ajax"] == $UserAction) { // Ajax
				if ($this->getSuccessMessage() <> "") {
					echo "<p class=\"text-success\">" . $this->getSuccessMessage() . "</p>";
					$this->ClearSuccessMessage(); // Clear message
				}
				if ($this->getFailureMessage() <> "") {
					echo "<p class=\"text-danger\">" . $this->getFailureMessage() . "</p>";
					$this->ClearFailureMessage(); // Clear message
				}
				return TRUE;
			}
		}
		return FALSE; // Not ajax request
	}

	// Set up search options
	function SetupSearchOptions() {
		global $Language;
		$this->SearchOptions = new cListOptions();
		$this->SearchOptions->Tag = "div";
		$this->SearchOptions->TagClassName = "ewSearchOption";

		// Search button
		$item = &$this->SearchOptions->Add("searchtoggle");
		$SearchToggleClass = ($this->SearchWhere <> "") ? " active" : " active";
		$item->Body = "<button type=\"button\" class=\"btn btn-default ewSearchToggle" . $SearchToggleClass . "\" title=\"" . $Language->Phrase("SearchPanel") . "\" data-caption=\"" . $Language->Phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"ftitulares2Dequipos2Dtutoreslistsrch\">" . $Language->Phrase("SearchBtn") . "</button>";
		$item->Visible = TRUE;

		// Show all button
		$item = &$this->SearchOptions->Add("showall");
		$item->Body = "<a class=\"btn btn-default ewShowAll\" title=\"" . $Language->Phrase("ShowAll") . "\" data-caption=\"" . $Language->Phrase("ShowAll") . "\" href=\"" . $this->PageUrl() . "cmd=reset\">" . $Language->Phrase("ShowAllBtn") . "</a>";
		$item->Visible = ($this->SearchWhere <> $this->DefaultSearchWhere && $this->SearchWhere <> "0=101");

		// Advanced search button
		$item = &$this->SearchOptions->Add("advancedsearch");
		$item->Body = "<a class=\"btn btn-default ewAdvancedSearch\" title=\"" . $Language->Phrase("AdvancedSearch") . "\" data-caption=\"" . $Language->Phrase("AdvancedSearch") . "\" href=\"titulares2Dequipos2Dtutoressrch.php\">" . $Language->Phrase("AdvancedSearchBtn") . "</a>";
		$item->Visible = TRUE;

		// Button group for search
		$this->SearchOptions->UseDropDownButton = FALSE;
		$this->SearchOptions->UseImageAndText = TRUE;
		$this->SearchOptions->UseButtonGroup = TRUE;
		$this->SearchOptions->DropDownButtonPhrase = $Language->Phrase("ButtonSearch");

		// Add group option item
		$item = &$this->SearchOptions->Add($this->SearchOptions->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;

		// Hide search options
		if ($this->Export <> "" || $this->CurrentAction <> "")
			$this->SearchOptions->HideAllOptions();
		global $Security;
		if (!$Security->CanSearch()) {
			$this->SearchOptions->HideAllOptions();
			$this->FilterOptions->HideAllOptions();
		}
	}

	function SetupListOptionsExt() {
		global $Security, $Language;
	}

	function RenderListOptionsExt() {
		global $Security, $Language;
	}

	// Set up starting record parameters
	function SetUpStartRec() {
		if ($this->DisplayRecs == 0)
			return;
		if ($this->IsPageRequest()) { // Validate request
			if (@$_GET[EW_TABLE_START_REC] <> "") { // Check for "start" parameter
				$this->StartRec = $_GET[EW_TABLE_START_REC];
				$this->setStartRecordNumber($this->StartRec);
			} elseif (@$_GET[EW_TABLE_PAGE_NO] <> "") {
				$PageNo = $_GET[EW_TABLE_PAGE_NO];
				if (is_numeric($PageNo)) {
					$this->StartRec = ($PageNo-1)*$this->DisplayRecs+1;
					if ($this->StartRec <= 0) {
						$this->StartRec = 1;
					} elseif ($this->StartRec >= intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1) {
						$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1;
					}
					$this->setStartRecordNumber($this->StartRec);
				}
			}
		}
		$this->StartRec = $this->getStartRecordNumber();

		// Check if correct start record counter
		if (!is_numeric($this->StartRec) || $this->StartRec == "") { // Avoid invalid start record counter
			$this->StartRec = 1; // Reset start record counter
			$this->setStartRecordNumber($this->StartRec);
		} elseif (intval($this->StartRec) > intval($this->TotalRecs)) { // Avoid starting record > total records
			$this->StartRec = intval(($this->TotalRecs-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to last page first record
			$this->setStartRecordNumber($this->StartRec);
		} elseif (($this->StartRec-1) % $this->DisplayRecs <> 0) {
			$this->StartRec = intval(($this->StartRec-1)/$this->DisplayRecs)*$this->DisplayRecs+1; // Point to page boundary
			$this->setStartRecordNumber($this->StartRec);
		}
	}

	// Load basic search values
	function LoadBasicSearchValues() {
		$this->BasicSearch->Keyword = @$_GET[EW_TABLE_BASIC_SEARCH];
		if ($this->BasicSearch->Keyword <> "") $this->Command = "search";
		$this->BasicSearch->Type = @$_GET[EW_TABLE_BASIC_SEARCH_TYPE];
	}

	// Load search values for validation
	function LoadSearchValues() {
		global $objForm;

		// Load search values
		// Apelldio y Nombre Titular

		$this->Apelldio_y_Nombre_Titular->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Apelldio_y_Nombre_Titular"]);
		if ($this->Apelldio_y_Nombre_Titular->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Apelldio_y_Nombre_Titular->AdvancedSearch->SearchOperator = @$_GET["z_Apelldio_y_Nombre_Titular"];

		// Dni
		$this->Dni->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Dni"]);
		if ($this->Dni->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Dni->AdvancedSearch->SearchOperator = @$_GET["z_Dni"];

		// Cuil
		$this->Cuil->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Cuil"]);
		if ($this->Cuil->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Cuil->AdvancedSearch->SearchOperator = @$_GET["z_Cuil"];

		// Id_Curso
		$this->Id_Curso->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Id_Curso"]);
		if ($this->Id_Curso->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Id_Curso->AdvancedSearch->SearchOperator = @$_GET["z_Id_Curso"];

		// Id_Division
		$this->Id_Division->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Id_Division"]);
		if ($this->Id_Division->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Id_Division->AdvancedSearch->SearchOperator = @$_GET["z_Id_Division"];

		// Id_Turno
		$this->Id_Turno->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Id_Turno"]);
		if ($this->Id_Turno->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Id_Turno->AdvancedSearch->SearchOperator = @$_GET["z_Id_Turno"];

		// Id_Cargo
		$this->Id_Cargo->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Id_Cargo"]);
		if ($this->Id_Cargo->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Id_Cargo->AdvancedSearch->SearchOperator = @$_GET["z_Id_Cargo"];

		// Id_Estado
		$this->Id_Estado->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Id_Estado"]);
		if ($this->Id_Estado->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Id_Estado->AdvancedSearch->SearchOperator = @$_GET["z_Id_Estado"];

		// Equipo Asignado
		$this->Equipo_Asignado->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Equipo_Asignado"]);
		if ($this->Equipo_Asignado->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Equipo_Asignado->AdvancedSearch->SearchOperator = @$_GET["z_Equipo_Asignado"];

		// Apellido y Nombre Tutor
		$this->Apellido_y_Nombre_Tutor->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Apellido_y_Nombre_Tutor"]);
		if ($this->Apellido_y_Nombre_Tutor->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Apellido_y_Nombre_Tutor->AdvancedSearch->SearchOperator = @$_GET["z_Apellido_y_Nombre_Tutor"];

		// Dni Tutor
		$this->Dni_Tutor->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Dni_Tutor"]);
		if ($this->Dni_Tutor->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Dni_Tutor->AdvancedSearch->SearchOperator = @$_GET["z_Dni_Tutor"];

		// Cuil Tutor
		$this->Cuil_Tutor->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Cuil_Tutor"]);
		if ($this->Cuil_Tutor->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Cuil_Tutor->AdvancedSearch->SearchOperator = @$_GET["z_Cuil_Tutor"];
	}

	// Load recordset
	function LoadRecordset($offset = -1, $rowcnt = -1) {

		// Load List page SQL
		$sSql = $this->SelectSQL();
		$conn = &$this->Connection();

		// Load recordset
		$dbtype = ew_GetConnectionType($this->DBID);
		if ($this->UseSelectLimit) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			if ($dbtype == "MSSQL") {
				$rs = $conn->SelectLimit($sSql, $rowcnt, $offset, array("_hasOrderBy" => trim($this->getOrderBy()) || trim($this->getSessionOrderBy())));
			} else {
				$rs = $conn->SelectLimit($sSql, $rowcnt, $offset);
			}
			$conn->raiseErrorFn = '';
		} else {
			$rs = ew_LoadRecordset($sSql, $conn);
		}

		// Call Recordset Selected event
		$this->Recordset_Selected($rs);
		return $rs;
	}

	// Load row based on key values
	function LoadRow() {
		global $Security, $Language;
		$sFilter = $this->KeyFilter();

		// Call Row Selecting event
		$this->Row_Selecting($sFilter);

		// Load SQL based on filter
		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		$conn = &$this->Connection();
		$res = FALSE;
		$rs = ew_LoadRecordset($sSql, $conn);
		if ($rs && !$rs->EOF) {
			$res = TRUE;
			$this->LoadRowValues($rs); // Load row values
			$rs->Close();
		}
		return $res;
	}

	// Load row values from recordset
	function LoadRowValues(&$rs) {
		if (!$rs || $rs->EOF) return;

		// Call Row Selected event
		$row = &$rs->fields;
		$this->Row_Selected($row);
		$this->Apelldio_y_Nombre_Titular->setDbValue($rs->fields('Apelldio y Nombre Titular'));
		$this->Dni->setDbValue($rs->fields('Dni'));
		$this->Cuil->setDbValue($rs->fields('Cuil'));
		$this->Id_Curso->setDbValue($rs->fields('Id_Curso'));
		$this->Id_Division->setDbValue($rs->fields('Id_Division'));
		$this->Id_Turno->setDbValue($rs->fields('Id_Turno'));
		$this->Id_Cargo->setDbValue($rs->fields('Id_Cargo'));
		$this->Id_Estado->setDbValue($rs->fields('Id_Estado'));
		$this->Equipo_Asignado->setDbValue($rs->fields('Equipo Asignado'));
		$this->Apellido_y_Nombre_Tutor->setDbValue($rs->fields('Apellido y Nombre Tutor'));
		$this->Dni_Tutor->setDbValue($rs->fields('Dni Tutor'));
		$this->Cuil_Tutor->setDbValue($rs->fields('Cuil Tutor'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->Apelldio_y_Nombre_Titular->DbValue = $row['Apelldio y Nombre Titular'];
		$this->Dni->DbValue = $row['Dni'];
		$this->Cuil->DbValue = $row['Cuil'];
		$this->Id_Curso->DbValue = $row['Id_Curso'];
		$this->Id_Division->DbValue = $row['Id_Division'];
		$this->Id_Turno->DbValue = $row['Id_Turno'];
		$this->Id_Cargo->DbValue = $row['Id_Cargo'];
		$this->Id_Estado->DbValue = $row['Id_Estado'];
		$this->Equipo_Asignado->DbValue = $row['Equipo Asignado'];
		$this->Apellido_y_Nombre_Tutor->DbValue = $row['Apellido y Nombre Tutor'];
		$this->Dni_Tutor->DbValue = $row['Dni Tutor'];
		$this->Cuil_Tutor->DbValue = $row['Cuil Tutor'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("Dni")) <> "")
			$this->Dni->CurrentValue = $this->getKey("Dni"); // Dni
		else
			$bValidKey = FALSE;
		if (strval($this->getKey("Dni_Tutor")) <> "")
			$this->Dni_Tutor->CurrentValue = $this->getKey("Dni_Tutor"); // Dni Tutor
		else
			$bValidKey = FALSE;

		// Load old recordset
		if ($bValidKey) {
			$this->CurrentFilter = $this->KeyFilter();
			$sSql = $this->SQL();
			$conn = &$this->Connection();
			$this->OldRecordset = ew_LoadRecordset($sSql, $conn);
			$this->LoadRowValues($this->OldRecordset); // Load row values
		} else {
			$this->OldRecordset = NULL;
		}
		return $bValidKey;
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		$this->ViewUrl = $this->GetViewUrl();
		$this->EditUrl = $this->GetEditUrl();
		$this->InlineEditUrl = $this->GetInlineEditUrl();
		$this->CopyUrl = $this->GetCopyUrl();
		$this->InlineCopyUrl = $this->GetInlineCopyUrl();
		$this->DeleteUrl = $this->GetDeleteUrl();

		// Call Row_Rendering event
		$this->Row_Rendering();

		// Common render codes for all row types
		// Apelldio y Nombre Titular
		// Dni
		// Cuil
		// Id_Curso
		// Id_Division
		// Id_Turno
		// Id_Cargo
		// Id_Estado
		// Equipo Asignado
		// Apellido y Nombre Tutor
		// Dni Tutor
		// Cuil Tutor

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// Apelldio y Nombre Titular
		$this->Apelldio_y_Nombre_Titular->ViewValue = $this->Apelldio_y_Nombre_Titular->CurrentValue;
		$this->Apelldio_y_Nombre_Titular->ViewCustomAttributes = "";

		// Dni
		$this->Dni->ViewValue = $this->Dni->CurrentValue;
		$this->Dni->ViewCustomAttributes = "";

		// Cuil
		$this->Cuil->ViewValue = $this->Cuil->CurrentValue;
		$this->Cuil->ViewCustomAttributes = "";

		// Id_Curso
		if (strval($this->Id_Curso->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Curso`" . ew_SearchString("=", $this->Id_Curso->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Curso`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `cursos`";
		$sWhereWrk = "";
		$this->Id_Curso->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Curso, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Curso->ViewValue = $this->Id_Curso->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Curso->ViewValue = $this->Id_Curso->CurrentValue;
			}
		} else {
			$this->Id_Curso->ViewValue = NULL;
		}
		$this->Id_Curso->ViewCustomAttributes = "";

		// Id_Division
		if (strval($this->Id_Division->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Division`" . ew_SearchString("=", $this->Id_Division->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Division`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `division`";
		$sWhereWrk = "";
		$this->Id_Division->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Division, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Division->ViewValue = $this->Id_Division->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Division->ViewValue = $this->Id_Division->CurrentValue;
			}
		} else {
			$this->Id_Division->ViewValue = NULL;
		}
		$this->Id_Division->ViewCustomAttributes = "";

		// Id_Turno
		if (strval($this->Id_Turno->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Turno`" . ew_SearchString("=", $this->Id_Turno->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Turno`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `turno`";
		$sWhereWrk = "";
		$this->Id_Turno->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Turno, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Turno->ViewValue = $this->Id_Turno->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Turno->ViewValue = $this->Id_Turno->CurrentValue;
			}
		} else {
			$this->Id_Turno->ViewValue = NULL;
		}
		$this->Id_Turno->ViewCustomAttributes = "";

		// Id_Cargo
		if (strval($this->Id_Cargo->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Cargo`" . ew_SearchString("=", $this->Id_Cargo->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Cargo`, `Nombre` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `cargo_persona`";
		$sWhereWrk = "";
		$this->Id_Cargo->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Cargo, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Cargo->ViewValue = $this->Id_Cargo->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Cargo->ViewValue = $this->Id_Cargo->CurrentValue;
			}
		} else {
			$this->Id_Cargo->ViewValue = NULL;
		}
		$this->Id_Cargo->ViewCustomAttributes = "";

		// Id_Estado
		if (strval($this->Id_Estado->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Estado`" . ew_SearchString("=", $this->Id_Estado->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Estado`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `estado_persona`";
		$sWhereWrk = "";
		$this->Id_Estado->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Estado, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Estado->ViewValue = $this->Id_Estado->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Estado->ViewValue = $this->Id_Estado->CurrentValue;
			}
		} else {
			$this->Id_Estado->ViewValue = NULL;
		}
		$this->Id_Estado->ViewCustomAttributes = "";

		// Equipo Asignado
		$this->Equipo_Asignado->ViewValue = $this->Equipo_Asignado->CurrentValue;
		if (strval($this->Equipo_Asignado->CurrentValue) <> "") {
			$sFilterWrk = "`NroSerie`" . ew_SearchString("=", $this->Equipo_Asignado->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `NroSerie`, `NroSerie` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `equipos`";
		$sWhereWrk = "";
		$this->Equipo_Asignado->LookupFilters = array("dx1" => "`NroSerie`");
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Equipo_Asignado, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Equipo_Asignado->ViewValue = $this->Equipo_Asignado->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Equipo_Asignado->ViewValue = $this->Equipo_Asignado->CurrentValue;
			}
		} else {
			$this->Equipo_Asignado->ViewValue = NULL;
		}
		$this->Equipo_Asignado->ViewCustomAttributes = "";

		// Apellido y Nombre Tutor
		$this->Apellido_y_Nombre_Tutor->ViewValue = $this->Apellido_y_Nombre_Tutor->CurrentValue;
		$this->Apellido_y_Nombre_Tutor->ViewCustomAttributes = "";

		// Dni Tutor
		$this->Dni_Tutor->ViewValue = $this->Dni_Tutor->CurrentValue;
		$this->Dni_Tutor->ViewCustomAttributes = "";

		// Cuil Tutor
		$this->Cuil_Tutor->ViewValue = $this->Cuil_Tutor->CurrentValue;
		$this->Cuil_Tutor->ViewCustomAttributes = "";

			// Apelldio y Nombre Titular
			$this->Apelldio_y_Nombre_Titular->LinkCustomAttributes = "";
			$this->Apelldio_y_Nombre_Titular->HrefValue = "";
			$this->Apelldio_y_Nombre_Titular->TooltipValue = "";

			// Dni
			$this->Dni->LinkCustomAttributes = "";
			$this->Dni->HrefValue = "";
			$this->Dni->TooltipValue = "";

			// Cuil
			$this->Cuil->LinkCustomAttributes = "";
			$this->Cuil->HrefValue = "";
			$this->Cuil->TooltipValue = "";

			// Equipo Asignado
			$this->Equipo_Asignado->LinkCustomAttributes = "";
			$this->Equipo_Asignado->HrefValue = "";
			$this->Equipo_Asignado->TooltipValue = "";

			// Apellido y Nombre Tutor
			$this->Apellido_y_Nombre_Tutor->LinkCustomAttributes = "";
			$this->Apellido_y_Nombre_Tutor->HrefValue = "";
			$this->Apellido_y_Nombre_Tutor->TooltipValue = "";

			// Dni Tutor
			$this->Dni_Tutor->LinkCustomAttributes = "";
			$this->Dni_Tutor->HrefValue = "";
			$this->Dni_Tutor->TooltipValue = "";

			// Cuil Tutor
			$this->Cuil_Tutor->LinkCustomAttributes = "";
			$this->Cuil_Tutor->HrefValue = "";
			$this->Cuil_Tutor->TooltipValue = "";
		}

		// Call Row Rendered event
		if ($this->RowType <> EW_ROWTYPE_AGGREGATEINIT)
			$this->Row_Rendered();
	}

	// Validate search
	function ValidateSearch() {
		global $gsSearchError;

		// Initialize
		$gsSearchError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return TRUE;

		// Return validate result
		$ValidateSearch = ($gsSearchError == "");

		// Call Form_CustomValidate event
		$sFormCustomError = "";
		$ValidateSearch = $ValidateSearch && $this->Form_CustomValidate($sFormCustomError);
		if ($sFormCustomError <> "") {
			ew_AddMessage($gsSearchError, $sFormCustomError);
		}
		return $ValidateSearch;
	}

	// Load advanced search
	function LoadAdvancedSearch() {
		$this->Apelldio_y_Nombre_Titular->AdvancedSearch->Load();
		$this->Dni->AdvancedSearch->Load();
		$this->Cuil->AdvancedSearch->Load();
		$this->Id_Curso->AdvancedSearch->Load();
		$this->Id_Division->AdvancedSearch->Load();
		$this->Id_Turno->AdvancedSearch->Load();
		$this->Id_Cargo->AdvancedSearch->Load();
		$this->Id_Estado->AdvancedSearch->Load();
		$this->Equipo_Asignado->AdvancedSearch->Load();
		$this->Apellido_y_Nombre_Tutor->AdvancedSearch->Load();
		$this->Dni_Tutor->AdvancedSearch->Load();
		$this->Cuil_Tutor->AdvancedSearch->Load();
	}

	// Set up export options
	function SetupExportOptions() {
		global $Language;

		// Printer friendly
		$item = &$this->ExportOptions->Add("print");
		$item->Body = "<a href=\"" . $this->ExportPrintUrl . "\" class=\"ewExportLink ewPrint\" title=\"" . ew_HtmlEncode($Language->Phrase("PrinterFriendlyText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("PrinterFriendlyText")) . "\">" . $Language->Phrase("PrinterFriendly") . "</a>";
		$item->Visible = TRUE;

		// Export to Excel
		$item = &$this->ExportOptions->Add("excel");
		$item->Body = "<a href=\"" . $this->ExportExcelUrl . "\" class=\"ewExportLink ewExcel\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToExcelText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToExcelText")) . "\">" . $Language->Phrase("ExportToExcel") . "</a>";
		$item->Visible = TRUE;

		// Export to Word
		$item = &$this->ExportOptions->Add("word");
		$item->Body = "<a href=\"" . $this->ExportWordUrl . "\" class=\"ewExportLink ewWord\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToWordText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToWordText")) . "\">" . $Language->Phrase("ExportToWord") . "</a>";
		$item->Visible = TRUE;

		// Export to Html
		$item = &$this->ExportOptions->Add("html");
		$item->Body = "<a href=\"" . $this->ExportHtmlUrl . "\" class=\"ewExportLink ewHtml\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToHtmlText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToHtmlText")) . "\">" . $Language->Phrase("ExportToHtml") . "</a>";
		$item->Visible = TRUE;

		// Export to Xml
		$item = &$this->ExportOptions->Add("xml");
		$item->Body = "<a href=\"" . $this->ExportXmlUrl . "\" class=\"ewExportLink ewXml\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToXmlText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToXmlText")) . "\">" . $Language->Phrase("ExportToXml") . "</a>";
		$item->Visible = TRUE;

		// Export to Csv
		$item = &$this->ExportOptions->Add("csv");
		$item->Body = "<a href=\"" . $this->ExportCsvUrl . "\" class=\"ewExportLink ewCsv\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToCsvText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToCsvText")) . "\">" . $Language->Phrase("ExportToCsv") . "</a>";
		$item->Visible = TRUE;

		// Export to Pdf
		$item = &$this->ExportOptions->Add("pdf");
		$item->Body = "<a href=\"" . $this->ExportPdfUrl . "\" class=\"ewExportLink ewPdf\" title=\"" . ew_HtmlEncode($Language->Phrase("ExportToPDFText")) . "\" data-caption=\"" . ew_HtmlEncode($Language->Phrase("ExportToPDFText")) . "\">" . $Language->Phrase("ExportToPDF") . "</a>";
		$item->Visible = FALSE;

		// Export to Email
		$item = &$this->ExportOptions->Add("email");
		$url = "";
		$item->Body = "<button id=\"emf_titulares2Dequipos2Dtutores\" class=\"ewExportLink ewEmail\" title=\"" . $Language->Phrase("ExportToEmailText") . "\" data-caption=\"" . $Language->Phrase("ExportToEmailText") . "\" onclick=\"ew_EmailDialogShow({lnk:'emf_titulares2Dequipos2Dtutores',hdr:ewLanguage.Phrase('ExportToEmailText'),f:document.ftitulares2Dequipos2Dtutoreslist,sel:false" . $url . "});\">" . $Language->Phrase("ExportToEmail") . "</button>";
		$item->Visible = FALSE;

		// Drop down button for export
		$this->ExportOptions->UseButtonGroup = TRUE;
		$this->ExportOptions->UseImageAndText = TRUE;
		$this->ExportOptions->UseDropDownButton = TRUE;
		if ($this->ExportOptions->UseButtonGroup && ew_IsMobile())
			$this->ExportOptions->UseDropDownButton = TRUE;
		$this->ExportOptions->DropDownButtonPhrase = $Language->Phrase("ButtonExport");

		// Add group option item
		$item = &$this->ExportOptions->Add($this->ExportOptions->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;
	}

	// Export data in HTML/CSV/Word/Excel/XML/Email/PDF format
	function ExportData() {
		$utf8 = (strtolower(EW_CHARSET) == "utf-8");
		$bSelectLimit = $this->UseSelectLimit;

		// Load recordset
		if ($bSelectLimit) {
			$this->TotalRecs = $this->SelectRecordCount();
		} else {
			if (!$this->Recordset)
				$this->Recordset = $this->LoadRecordset();
			$rs = &$this->Recordset;
			if ($rs)
				$this->TotalRecs = $rs->RecordCount();
		}
		$this->StartRec = 1;

		// Export all
		if ($this->ExportAll) {
			set_time_limit(EW_EXPORT_ALL_TIME_LIMIT);
			$this->DisplayRecs = $this->TotalRecs;
			$this->StopRec = $this->TotalRecs;
		} else { // Export one page only
			$this->SetUpStartRec(); // Set up start record position

			// Set the last record to display
			if ($this->DisplayRecs <= 0) {
				$this->StopRec = $this->TotalRecs;
			} else {
				$this->StopRec = $this->StartRec + $this->DisplayRecs - 1;
			}
		}
		if ($bSelectLimit)
			$rs = $this->LoadRecordset($this->StartRec-1, $this->DisplayRecs <= 0 ? $this->TotalRecs : $this->DisplayRecs);
		if (!$rs) {
			header("Content-Type:"); // Remove header
			header("Content-Disposition:");
			$this->ShowMessage();
			return;
		}
		$this->ExportDoc = ew_ExportDocument($this, "h");
		$Doc = &$this->ExportDoc;
		if ($bSelectLimit) {
			$this->StartRec = 1;
			$this->StopRec = $this->DisplayRecs <= 0 ? $this->TotalRecs : $this->DisplayRecs;
		} else {

			//$this->StartRec = $this->StartRec;
			//$this->StopRec = $this->StopRec;

		}

		// Call Page Exporting server event
		$this->ExportDoc->ExportCustom = !$this->Page_Exporting();
		$ParentTable = "";
		$sHeader = $this->PageHeader;
		$this->Page_DataRendering($sHeader);
		$Doc->Text .= $sHeader;
		$this->ExportDocument($Doc, $rs, $this->StartRec, $this->StopRec, "");
		$sFooter = $this->PageFooter;
		$this->Page_DataRendered($sFooter);
		$Doc->Text .= $sFooter;

		// Close recordset
		$rs->Close();

		// Call Page Exported server event
		$this->Page_Exported();

		// Export header and footer
		$Doc->ExportHeaderAndFooter();

		// Clean output buffer
		if (!EW_DEBUG_ENABLED && ob_get_length())
			ob_end_clean();

		// Write debug message if enabled
		if (EW_DEBUG_ENABLED && $this->Export <> "pdf")
			echo ew_DebugMsg();

		// Output data
		$Doc->Export();
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$url = preg_replace('/\?cmd=reset(all){0,1}$/i', '', $url); // Remove cmd=reset / cmd=resetall
		$Breadcrumb->Add("list", $this->TableVar, $url, "", $this->TableVar, TRUE);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		}
	}

	// Setup AutoSuggest filters of a field
	function SetupAutoSuggestFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		}
	}

	// Page Load event
	function Page_Load() {

		//echo "Page Load";
	}

	// Page Unload event
	function Page_Unload() {

		//echo "Page Unload";
	}

	// Page Redirecting event
	function Page_Redirecting(&$url) {

		// Example:
		//$url = "your URL";

	}

	// Message Showing event
	// $type = ''|'success'|'failure'|'warning'
	function Message_Showing(&$msg, $type) {
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
	function Page_Render() {

		//echo "Page Render";
	}

	// Page Data Rendering event
	function Page_DataRendering(&$header) {

		// Example:
		//$header = "your header";

	}

	// Page Data Rendered event
	function Page_DataRendered(&$footer) {

		// Example:
		//$footer = "your footer";

	}

	// Form Custom Validate event
	function Form_CustomValidate(&$CustomError) {

		// Return error message in CustomError
		return TRUE;
	}

	// ListOptions Load event
	function ListOptions_Load() {

		// Example:
		//$opt = &$this->ListOptions->Add("new");
		//$opt->Header = "xxx";
		//$opt->OnLeft = TRUE; // Link on left
		//$opt->MoveTo(0); // Move to first column

	}

	// ListOptions Rendered event
	function ListOptions_Rendered() {

		// Example: 
		//$this->ListOptions->Items["new"]->Body = "xxx";

	}

	// Row Custom Action event
	function Row_CustomAction($action, $row) {

		// Return FALSE to abort
		return TRUE;
	}

	// Page Exporting event
	// $this->ExportDoc = export document object
	function Page_Exporting() {

		//$this->ExportDoc->Text = "my header"; // Export header
		//return FALSE; // Return FALSE to skip default export and use Row_Export event

		return TRUE; // Return TRUE to use default export and skip Row_Export event
	}

	// Row Export event
	// $this->ExportDoc = export document object
	function Row_Export($rs) {

		//$this->ExportDoc->Text .= "my content"; // Build HTML with field value: $rs["MyField"] or $this->MyField->ViewValue
	}

	// Page Exported event
	// $this->ExportDoc = export document object
	function Page_Exported() {

		//$this->ExportDoc->Text .= "my footer"; // Export footer
		//echo $this->ExportDoc->Text;

	}
}
?>
<?php ew_Header(TRUE) ?>
<?php

// Create page object
if (!isset($titulares2Dequipos2Dtutores_list)) $titulares2Dequipos2Dtutores_list = new ctitulares2Dequipos2Dtutores_list();

// Page init
$titulares2Dequipos2Dtutores_list->Page_Init();

// Page main
$titulares2Dequipos2Dtutores_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$titulares2Dequipos2Dtutores_list->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if ($titulares2Dequipos2Dtutores->Export == "") { ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "list";
var CurrentForm = ftitulares2Dequipos2Dtutoreslist = new ew_Form("ftitulares2Dequipos2Dtutoreslist", "list");
ftitulares2Dequipos2Dtutoreslist.FormKeyCountName = '<?php echo $titulares2Dequipos2Dtutores_list->FormKeyCountName ?>';

// Form_CustomValidate event
ftitulares2Dequipos2Dtutoreslist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
ftitulares2Dequipos2Dtutoreslist.ValidateRequired = true;
<?php } else { ?>
ftitulares2Dequipos2Dtutoreslist.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
ftitulares2Dequipos2Dtutoreslist.Lists["x_Equipo_Asignado"] = {"LinkField":"x_NroSerie","Ajax":true,"AutoFill":false,"DisplayFields":["x_NroSerie","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"equipos"};

// Form object for search
var CurrentSearchForm = ftitulares2Dequipos2Dtutoreslistsrch = new ew_Form("ftitulares2Dequipos2Dtutoreslistsrch");
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if ($titulares2Dequipos2Dtutores->Export == "") { ?>
<div class="ewToolbar">
<?php if ($titulares2Dequipos2Dtutores->Export == "") { ?>
<?php $Breadcrumb->Render(); ?>
<?php } ?>
<?php if ($titulares2Dequipos2Dtutores_list->TotalRecs > 0 && $titulares2Dequipos2Dtutores_list->ExportOptions->Visible()) { ?>
<?php $titulares2Dequipos2Dtutores_list->ExportOptions->Render("body") ?>
<?php } ?>
<?php if ($titulares2Dequipos2Dtutores_list->SearchOptions->Visible()) { ?>
<?php $titulares2Dequipos2Dtutores_list->SearchOptions->Render("body") ?>
<?php } ?>
<?php if ($titulares2Dequipos2Dtutores_list->FilterOptions->Visible()) { ?>
<?php $titulares2Dequipos2Dtutores_list->FilterOptions->Render("body") ?>
<?php } ?>
<?php if ($titulares2Dequipos2Dtutores->Export == "") { ?>
<?php echo $Language->SelectionForm(); ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php
	$bSelectLimit = $titulares2Dequipos2Dtutores_list->UseSelectLimit;
	if ($bSelectLimit) {
		if ($titulares2Dequipos2Dtutores_list->TotalRecs <= 0)
			$titulares2Dequipos2Dtutores_list->TotalRecs = $titulares2Dequipos2Dtutores->SelectRecordCount();
	} else {
		if (!$titulares2Dequipos2Dtutores_list->Recordset && ($titulares2Dequipos2Dtutores_list->Recordset = $titulares2Dequipos2Dtutores_list->LoadRecordset()))
			$titulares2Dequipos2Dtutores_list->TotalRecs = $titulares2Dequipos2Dtutores_list->Recordset->RecordCount();
	}
	$titulares2Dequipos2Dtutores_list->StartRec = 1;
	if ($titulares2Dequipos2Dtutores_list->DisplayRecs <= 0 || ($titulares2Dequipos2Dtutores->Export <> "" && $titulares2Dequipos2Dtutores->ExportAll)) // Display all records
		$titulares2Dequipos2Dtutores_list->DisplayRecs = $titulares2Dequipos2Dtutores_list->TotalRecs;
	if (!($titulares2Dequipos2Dtutores->Export <> "" && $titulares2Dequipos2Dtutores->ExportAll))
		$titulares2Dequipos2Dtutores_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$titulares2Dequipos2Dtutores_list->Recordset = $titulares2Dequipos2Dtutores_list->LoadRecordset($titulares2Dequipos2Dtutores_list->StartRec-1, $titulares2Dequipos2Dtutores_list->DisplayRecs);

	// Set no record found message
	if ($titulares2Dequipos2Dtutores->CurrentAction == "" && $titulares2Dequipos2Dtutores_list->TotalRecs == 0) {
		if (!$Security->CanList())
			$titulares2Dequipos2Dtutores_list->setWarningMessage(ew_DeniedMsg());
		if ($titulares2Dequipos2Dtutores_list->SearchWhere == "0=101")
			$titulares2Dequipos2Dtutores_list->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$titulares2Dequipos2Dtutores_list->setWarningMessage($Language->Phrase("NoRecord"));
	}
$titulares2Dequipos2Dtutores_list->RenderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if ($titulares2Dequipos2Dtutores->Export == "" && $titulares2Dequipos2Dtutores->CurrentAction == "") { ?>
<form name="ftitulares2Dequipos2Dtutoreslistsrch" id="ftitulares2Dequipos2Dtutoreslistsrch" class="form-inline ewForm" action="<?php echo ew_CurrentPage() ?>">
<?php $SearchPanelClass = ($titulares2Dequipos2Dtutores_list->SearchWhere <> "") ? " in" : " in"; ?>
<div id="ftitulares2Dequipos2Dtutoreslistsrch_SearchPanel" class="ewSearchPanel collapse<?php echo $SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="titulares2Dequipos2Dtutores">
	<div class="ewBasicSearch">
<div id="xsr_1" class="ewRow">
	<div class="ewQuickSearch input-group">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" class="form-control" value="<?php echo ew_HtmlEncode($titulares2Dequipos2Dtutores_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo ew_HtmlEncode($Language->Phrase("Search")) ?>">
	<input type="hidden" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="<?php echo ew_HtmlEncode($titulares2Dequipos2Dtutores_list->BasicSearch->getType()) ?>">
	<div class="input-group-btn">
		<button type="button" data-toggle="dropdown" class="btn btn-default"><span id="searchtype"><?php echo $titulares2Dequipos2Dtutores_list->BasicSearch->getTypeNameShort() ?></span><span class="caret"></span></button>
		<ul class="dropdown-menu pull-right" role="menu">
			<li<?php if ($titulares2Dequipos2Dtutores_list->BasicSearch->getType() == "") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this)"><?php echo $Language->Phrase("QuickSearchAuto") ?></a></li>
			<li<?php if ($titulares2Dequipos2Dtutores_list->BasicSearch->getType() == "=") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'=')"><?php echo $Language->Phrase("QuickSearchExact") ?></a></li>
			<li<?php if ($titulares2Dequipos2Dtutores_list->BasicSearch->getType() == "AND") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'AND')"><?php echo $Language->Phrase("QuickSearchAll") ?></a></li>
			<li<?php if ($titulares2Dequipos2Dtutores_list->BasicSearch->getType() == "OR") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'OR')"><?php echo $Language->Phrase("QuickSearchAny") ?></a></li>
		</ul>
	<button class="btn btn-primary ewButton" name="btnsubmit" id="btnsubmit" type="submit"><?php echo $Language->Phrase("QuickSearchBtn") ?></button>
	</div>
	</div>
</div>
	</div>
</div>
</form>
<?php } ?>
<?php } ?>
<?php $titulares2Dequipos2Dtutores_list->ShowPageHeader(); ?>
<?php
$titulares2Dequipos2Dtutores_list->ShowMessage();
?>
<?php if ($titulares2Dequipos2Dtutores_list->TotalRecs > 0 || $titulares2Dequipos2Dtutores->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid titulares2Dequipos2Dtutores">
<?php if ($titulares2Dequipos2Dtutores->Export == "") { ?>
<div class="panel-heading ewGridUpperPanel">
<?php if ($titulares2Dequipos2Dtutores->CurrentAction <> "gridadd" && $titulares2Dequipos2Dtutores->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="form-inline ewForm ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($titulares2Dequipos2Dtutores_list->Pager)) $titulares2Dequipos2Dtutores_list->Pager = new cPrevNextPager($titulares2Dequipos2Dtutores_list->StartRec, $titulares2Dequipos2Dtutores_list->DisplayRecs, $titulares2Dequipos2Dtutores_list->TotalRecs) ?>
<?php if ($titulares2Dequipos2Dtutores_list->Pager->RecordCount > 0 && $titulares2Dequipos2Dtutores_list->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($titulares2Dequipos2Dtutores_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $titulares2Dequipos2Dtutores_list->PageUrl() ?>start=<?php echo $titulares2Dequipos2Dtutores_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($titulares2Dequipos2Dtutores_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $titulares2Dequipos2Dtutores_list->PageUrl() ?>start=<?php echo $titulares2Dequipos2Dtutores_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $titulares2Dequipos2Dtutores_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($titulares2Dequipos2Dtutores_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $titulares2Dequipos2Dtutores_list->PageUrl() ?>start=<?php echo $titulares2Dequipos2Dtutores_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($titulares2Dequipos2Dtutores_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $titulares2Dequipos2Dtutores_list->PageUrl() ?>start=<?php echo $titulares2Dequipos2Dtutores_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $titulares2Dequipos2Dtutores_list->Pager->PageCount ?></span>
</div>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $titulares2Dequipos2Dtutores_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $titulares2Dequipos2Dtutores_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $titulares2Dequipos2Dtutores_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($titulares2Dequipos2Dtutores_list->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
<form name="ftitulares2Dequipos2Dtutoreslist" id="ftitulares2Dequipos2Dtutoreslist" class="form-inline ewForm ewListForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($titulares2Dequipos2Dtutores_list->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $titulares2Dequipos2Dtutores_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="titulares2Dequipos2Dtutores">
<div id="gmp_titulares2Dequipos2Dtutores" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<?php if ($titulares2Dequipos2Dtutores_list->TotalRecs > 0) { ?>
<table id="tbl_titulares2Dequipos2Dtutoreslist" class="table ewTable">
<?php echo $titulares2Dequipos2Dtutores->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$titulares2Dequipos2Dtutores_list->RowType = EW_ROWTYPE_HEADER;

// Render list options
$titulares2Dequipos2Dtutores_list->RenderListOptions();

// Render list options (header, left)
$titulares2Dequipos2Dtutores_list->ListOptions->Render("header", "left");
?>
<?php if ($titulares2Dequipos2Dtutores->Apelldio_y_Nombre_Titular->Visible) { // Apelldio y Nombre Titular ?>
	<?php if ($titulares2Dequipos2Dtutores->SortUrl($titulares2Dequipos2Dtutores->Apelldio_y_Nombre_Titular) == "") { ?>
		<th data-name="Apelldio_y_Nombre_Titular"><div id="elh_titulares2Dequipos2Dtutores_Apelldio_y_Nombre_Titular" class="titulares2Dequipos2Dtutores_Apelldio_y_Nombre_Titular"><div class="ewTableHeaderCaption"><?php echo $titulares2Dequipos2Dtutores->Apelldio_y_Nombre_Titular->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Apelldio_y_Nombre_Titular"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $titulares2Dequipos2Dtutores->SortUrl($titulares2Dequipos2Dtutores->Apelldio_y_Nombre_Titular) ?>',1);"><div id="elh_titulares2Dequipos2Dtutores_Apelldio_y_Nombre_Titular" class="titulares2Dequipos2Dtutores_Apelldio_y_Nombre_Titular">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $titulares2Dequipos2Dtutores->Apelldio_y_Nombre_Titular->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($titulares2Dequipos2Dtutores->Apelldio_y_Nombre_Titular->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($titulares2Dequipos2Dtutores->Apelldio_y_Nombre_Titular->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($titulares2Dequipos2Dtutores->Dni->Visible) { // Dni ?>
	<?php if ($titulares2Dequipos2Dtutores->SortUrl($titulares2Dequipos2Dtutores->Dni) == "") { ?>
		<th data-name="Dni"><div id="elh_titulares2Dequipos2Dtutores_Dni" class="titulares2Dequipos2Dtutores_Dni"><div class="ewTableHeaderCaption"><?php echo $titulares2Dequipos2Dtutores->Dni->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Dni"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $titulares2Dequipos2Dtutores->SortUrl($titulares2Dequipos2Dtutores->Dni) ?>',1);"><div id="elh_titulares2Dequipos2Dtutores_Dni" class="titulares2Dequipos2Dtutores_Dni">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $titulares2Dequipos2Dtutores->Dni->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($titulares2Dequipos2Dtutores->Dni->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($titulares2Dequipos2Dtutores->Dni->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($titulares2Dequipos2Dtutores->Cuil->Visible) { // Cuil ?>
	<?php if ($titulares2Dequipos2Dtutores->SortUrl($titulares2Dequipos2Dtutores->Cuil) == "") { ?>
		<th data-name="Cuil"><div id="elh_titulares2Dequipos2Dtutores_Cuil" class="titulares2Dequipos2Dtutores_Cuil"><div class="ewTableHeaderCaption"><?php echo $titulares2Dequipos2Dtutores->Cuil->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Cuil"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $titulares2Dequipos2Dtutores->SortUrl($titulares2Dequipos2Dtutores->Cuil) ?>',1);"><div id="elh_titulares2Dequipos2Dtutores_Cuil" class="titulares2Dequipos2Dtutores_Cuil">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $titulares2Dequipos2Dtutores->Cuil->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($titulares2Dequipos2Dtutores->Cuil->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($titulares2Dequipos2Dtutores->Cuil->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($titulares2Dequipos2Dtutores->Equipo_Asignado->Visible) { // Equipo Asignado ?>
	<?php if ($titulares2Dequipos2Dtutores->SortUrl($titulares2Dequipos2Dtutores->Equipo_Asignado) == "") { ?>
		<th data-name="Equipo_Asignado"><div id="elh_titulares2Dequipos2Dtutores_Equipo_Asignado" class="titulares2Dequipos2Dtutores_Equipo_Asignado"><div class="ewTableHeaderCaption"><?php echo $titulares2Dequipos2Dtutores->Equipo_Asignado->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Equipo_Asignado"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $titulares2Dequipos2Dtutores->SortUrl($titulares2Dequipos2Dtutores->Equipo_Asignado) ?>',1);"><div id="elh_titulares2Dequipos2Dtutores_Equipo_Asignado" class="titulares2Dequipos2Dtutores_Equipo_Asignado">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $titulares2Dequipos2Dtutores->Equipo_Asignado->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($titulares2Dequipos2Dtutores->Equipo_Asignado->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($titulares2Dequipos2Dtutores->Equipo_Asignado->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($titulares2Dequipos2Dtutores->Apellido_y_Nombre_Tutor->Visible) { // Apellido y Nombre Tutor ?>
	<?php if ($titulares2Dequipos2Dtutores->SortUrl($titulares2Dequipos2Dtutores->Apellido_y_Nombre_Tutor) == "") { ?>
		<th data-name="Apellido_y_Nombre_Tutor"><div id="elh_titulares2Dequipos2Dtutores_Apellido_y_Nombre_Tutor" class="titulares2Dequipos2Dtutores_Apellido_y_Nombre_Tutor"><div class="ewTableHeaderCaption"><?php echo $titulares2Dequipos2Dtutores->Apellido_y_Nombre_Tutor->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Apellido_y_Nombre_Tutor"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $titulares2Dequipos2Dtutores->SortUrl($titulares2Dequipos2Dtutores->Apellido_y_Nombre_Tutor) ?>',1);"><div id="elh_titulares2Dequipos2Dtutores_Apellido_y_Nombre_Tutor" class="titulares2Dequipos2Dtutores_Apellido_y_Nombre_Tutor">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $titulares2Dequipos2Dtutores->Apellido_y_Nombre_Tutor->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($titulares2Dequipos2Dtutores->Apellido_y_Nombre_Tutor->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($titulares2Dequipos2Dtutores->Apellido_y_Nombre_Tutor->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($titulares2Dequipos2Dtutores->Dni_Tutor->Visible) { // Dni Tutor ?>
	<?php if ($titulares2Dequipos2Dtutores->SortUrl($titulares2Dequipos2Dtutores->Dni_Tutor) == "") { ?>
		<th data-name="Dni_Tutor"><div id="elh_titulares2Dequipos2Dtutores_Dni_Tutor" class="titulares2Dequipos2Dtutores_Dni_Tutor"><div class="ewTableHeaderCaption"><?php echo $titulares2Dequipos2Dtutores->Dni_Tutor->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Dni_Tutor"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $titulares2Dequipos2Dtutores->SortUrl($titulares2Dequipos2Dtutores->Dni_Tutor) ?>',1);"><div id="elh_titulares2Dequipos2Dtutores_Dni_Tutor" class="titulares2Dequipos2Dtutores_Dni_Tutor">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $titulares2Dequipos2Dtutores->Dni_Tutor->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($titulares2Dequipos2Dtutores->Dni_Tutor->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($titulares2Dequipos2Dtutores->Dni_Tutor->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($titulares2Dequipos2Dtutores->Cuil_Tutor->Visible) { // Cuil Tutor ?>
	<?php if ($titulares2Dequipos2Dtutores->SortUrl($titulares2Dequipos2Dtutores->Cuil_Tutor) == "") { ?>
		<th data-name="Cuil_Tutor"><div id="elh_titulares2Dequipos2Dtutores_Cuil_Tutor" class="titulares2Dequipos2Dtutores_Cuil_Tutor"><div class="ewTableHeaderCaption"><?php echo $titulares2Dequipos2Dtutores->Cuil_Tutor->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Cuil_Tutor"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $titulares2Dequipos2Dtutores->SortUrl($titulares2Dequipos2Dtutores->Cuil_Tutor) ?>',1);"><div id="elh_titulares2Dequipos2Dtutores_Cuil_Tutor" class="titulares2Dequipos2Dtutores_Cuil_Tutor">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $titulares2Dequipos2Dtutores->Cuil_Tutor->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($titulares2Dequipos2Dtutores->Cuil_Tutor->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($titulares2Dequipos2Dtutores->Cuil_Tutor->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$titulares2Dequipos2Dtutores_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
if ($titulares2Dequipos2Dtutores->ExportAll && $titulares2Dequipos2Dtutores->Export <> "") {
	$titulares2Dequipos2Dtutores_list->StopRec = $titulares2Dequipos2Dtutores_list->TotalRecs;
} else {

	// Set the last record to display
	if ($titulares2Dequipos2Dtutores_list->TotalRecs > $titulares2Dequipos2Dtutores_list->StartRec + $titulares2Dequipos2Dtutores_list->DisplayRecs - 1)
		$titulares2Dequipos2Dtutores_list->StopRec = $titulares2Dequipos2Dtutores_list->StartRec + $titulares2Dequipos2Dtutores_list->DisplayRecs - 1;
	else
		$titulares2Dequipos2Dtutores_list->StopRec = $titulares2Dequipos2Dtutores_list->TotalRecs;
}
$titulares2Dequipos2Dtutores_list->RecCnt = $titulares2Dequipos2Dtutores_list->StartRec - 1;
if ($titulares2Dequipos2Dtutores_list->Recordset && !$titulares2Dequipos2Dtutores_list->Recordset->EOF) {
	$titulares2Dequipos2Dtutores_list->Recordset->MoveFirst();
	$bSelectLimit = $titulares2Dequipos2Dtutores_list->UseSelectLimit;
	if (!$bSelectLimit && $titulares2Dequipos2Dtutores_list->StartRec > 1)
		$titulares2Dequipos2Dtutores_list->Recordset->Move($titulares2Dequipos2Dtutores_list->StartRec - 1);
} elseif (!$titulares2Dequipos2Dtutores->AllowAddDeleteRow && $titulares2Dequipos2Dtutores_list->StopRec == 0) {
	$titulares2Dequipos2Dtutores_list->StopRec = $titulares2Dequipos2Dtutores->GridAddRowCount;
}

// Initialize aggregate
$titulares2Dequipos2Dtutores->RowType = EW_ROWTYPE_AGGREGATEINIT;
$titulares2Dequipos2Dtutores->ResetAttrs();
$titulares2Dequipos2Dtutores_list->RenderRow();
while ($titulares2Dequipos2Dtutores_list->RecCnt < $titulares2Dequipos2Dtutores_list->StopRec) {
	$titulares2Dequipos2Dtutores_list->RecCnt++;
	if (intval($titulares2Dequipos2Dtutores_list->RecCnt) >= intval($titulares2Dequipos2Dtutores_list->StartRec)) {
		$titulares2Dequipos2Dtutores_list->RowCnt++;

		// Set up key count
		$titulares2Dequipos2Dtutores_list->KeyCount = $titulares2Dequipos2Dtutores_list->RowIndex;

		// Init row class and style
		$titulares2Dequipos2Dtutores->ResetAttrs();
		$titulares2Dequipos2Dtutores->CssClass = "";
		if ($titulares2Dequipos2Dtutores->CurrentAction == "gridadd") {
		} else {
			$titulares2Dequipos2Dtutores_list->LoadRowValues($titulares2Dequipos2Dtutores_list->Recordset); // Load row values
		}
		$titulares2Dequipos2Dtutores->RowType = EW_ROWTYPE_VIEW; // Render view

		// Set up row id / data-rowindex
		$titulares2Dequipos2Dtutores->RowAttrs = array_merge($titulares2Dequipos2Dtutores->RowAttrs, array('data-rowindex'=>$titulares2Dequipos2Dtutores_list->RowCnt, 'id'=>'r' . $titulares2Dequipos2Dtutores_list->RowCnt . '_titulares2Dequipos2Dtutores', 'data-rowtype'=>$titulares2Dequipos2Dtutores->RowType));

		// Render row
		$titulares2Dequipos2Dtutores_list->RenderRow();

		// Render list options
		$titulares2Dequipos2Dtutores_list->RenderListOptions();
?>
	<tr<?php echo $titulares2Dequipos2Dtutores->RowAttributes() ?>>
<?php

// Render list options (body, left)
$titulares2Dequipos2Dtutores_list->ListOptions->Render("body", "left", $titulares2Dequipos2Dtutores_list->RowCnt);
?>
	<?php if ($titulares2Dequipos2Dtutores->Apelldio_y_Nombre_Titular->Visible) { // Apelldio y Nombre Titular ?>
		<td data-name="Apelldio_y_Nombre_Titular"<?php echo $titulares2Dequipos2Dtutores->Apelldio_y_Nombre_Titular->CellAttributes() ?>>
<span id="el<?php echo $titulares2Dequipos2Dtutores_list->RowCnt ?>_titulares2Dequipos2Dtutores_Apelldio_y_Nombre_Titular" class="titulares2Dequipos2Dtutores_Apelldio_y_Nombre_Titular">
<span<?php echo $titulares2Dequipos2Dtutores->Apelldio_y_Nombre_Titular->ViewAttributes() ?>>
<?php echo $titulares2Dequipos2Dtutores->Apelldio_y_Nombre_Titular->ListViewValue() ?></span>
</span>
<a id="<?php echo $titulares2Dequipos2Dtutores_list->PageObjName . "_row_" . $titulares2Dequipos2Dtutores_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($titulares2Dequipos2Dtutores->Dni->Visible) { // Dni ?>
		<td data-name="Dni"<?php echo $titulares2Dequipos2Dtutores->Dni->CellAttributes() ?>>
<span id="el<?php echo $titulares2Dequipos2Dtutores_list->RowCnt ?>_titulares2Dequipos2Dtutores_Dni" class="titulares2Dequipos2Dtutores_Dni">
<span<?php echo $titulares2Dequipos2Dtutores->Dni->ViewAttributes() ?>>
<?php echo $titulares2Dequipos2Dtutores->Dni->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($titulares2Dequipos2Dtutores->Cuil->Visible) { // Cuil ?>
		<td data-name="Cuil"<?php echo $titulares2Dequipos2Dtutores->Cuil->CellAttributes() ?>>
<span id="el<?php echo $titulares2Dequipos2Dtutores_list->RowCnt ?>_titulares2Dequipos2Dtutores_Cuil" class="titulares2Dequipos2Dtutores_Cuil">
<span<?php echo $titulares2Dequipos2Dtutores->Cuil->ViewAttributes() ?>>
<?php echo $titulares2Dequipos2Dtutores->Cuil->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($titulares2Dequipos2Dtutores->Equipo_Asignado->Visible) { // Equipo Asignado ?>
		<td data-name="Equipo_Asignado"<?php echo $titulares2Dequipos2Dtutores->Equipo_Asignado->CellAttributes() ?>>
<span id="el<?php echo $titulares2Dequipos2Dtutores_list->RowCnt ?>_titulares2Dequipos2Dtutores_Equipo_Asignado" class="titulares2Dequipos2Dtutores_Equipo_Asignado">
<span<?php echo $titulares2Dequipos2Dtutores->Equipo_Asignado->ViewAttributes() ?>>
<?php echo $titulares2Dequipos2Dtutores->Equipo_Asignado->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($titulares2Dequipos2Dtutores->Apellido_y_Nombre_Tutor->Visible) { // Apellido y Nombre Tutor ?>
		<td data-name="Apellido_y_Nombre_Tutor"<?php echo $titulares2Dequipos2Dtutores->Apellido_y_Nombre_Tutor->CellAttributes() ?>>
<span id="el<?php echo $titulares2Dequipos2Dtutores_list->RowCnt ?>_titulares2Dequipos2Dtutores_Apellido_y_Nombre_Tutor" class="titulares2Dequipos2Dtutores_Apellido_y_Nombre_Tutor">
<span<?php echo $titulares2Dequipos2Dtutores->Apellido_y_Nombre_Tutor->ViewAttributes() ?>>
<?php echo $titulares2Dequipos2Dtutores->Apellido_y_Nombre_Tutor->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($titulares2Dequipos2Dtutores->Dni_Tutor->Visible) { // Dni Tutor ?>
		<td data-name="Dni_Tutor"<?php echo $titulares2Dequipos2Dtutores->Dni_Tutor->CellAttributes() ?>>
<span id="el<?php echo $titulares2Dequipos2Dtutores_list->RowCnt ?>_titulares2Dequipos2Dtutores_Dni_Tutor" class="titulares2Dequipos2Dtutores_Dni_Tutor">
<span<?php echo $titulares2Dequipos2Dtutores->Dni_Tutor->ViewAttributes() ?>>
<?php echo $titulares2Dequipos2Dtutores->Dni_Tutor->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
	<?php if ($titulares2Dequipos2Dtutores->Cuil_Tutor->Visible) { // Cuil Tutor ?>
		<td data-name="Cuil_Tutor"<?php echo $titulares2Dequipos2Dtutores->Cuil_Tutor->CellAttributes() ?>>
<span id="el<?php echo $titulares2Dequipos2Dtutores_list->RowCnt ?>_titulares2Dequipos2Dtutores_Cuil_Tutor" class="titulares2Dequipos2Dtutores_Cuil_Tutor">
<span<?php echo $titulares2Dequipos2Dtutores->Cuil_Tutor->ViewAttributes() ?>>
<?php echo $titulares2Dequipos2Dtutores->Cuil_Tutor->ListViewValue() ?></span>
</span>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$titulares2Dequipos2Dtutores_list->ListOptions->Render("body", "right", $titulares2Dequipos2Dtutores_list->RowCnt);
?>
	</tr>
<?php
	}
	if ($titulares2Dequipos2Dtutores->CurrentAction <> "gridadd")
		$titulares2Dequipos2Dtutores_list->Recordset->MoveNext();
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($titulares2Dequipos2Dtutores->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($titulares2Dequipos2Dtutores_list->Recordset)
	$titulares2Dequipos2Dtutores_list->Recordset->Close();
?>
<?php if ($titulares2Dequipos2Dtutores->Export == "") { ?>
<div class="panel-footer ewGridLowerPanel">
<?php if ($titulares2Dequipos2Dtutores->CurrentAction <> "gridadd" && $titulares2Dequipos2Dtutores->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-inline ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($titulares2Dequipos2Dtutores_list->Pager)) $titulares2Dequipos2Dtutores_list->Pager = new cPrevNextPager($titulares2Dequipos2Dtutores_list->StartRec, $titulares2Dequipos2Dtutores_list->DisplayRecs, $titulares2Dequipos2Dtutores_list->TotalRecs) ?>
<?php if ($titulares2Dequipos2Dtutores_list->Pager->RecordCount > 0 && $titulares2Dequipos2Dtutores_list->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($titulares2Dequipos2Dtutores_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $titulares2Dequipos2Dtutores_list->PageUrl() ?>start=<?php echo $titulares2Dequipos2Dtutores_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($titulares2Dequipos2Dtutores_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $titulares2Dequipos2Dtutores_list->PageUrl() ?>start=<?php echo $titulares2Dequipos2Dtutores_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $titulares2Dequipos2Dtutores_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($titulares2Dequipos2Dtutores_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $titulares2Dequipos2Dtutores_list->PageUrl() ?>start=<?php echo $titulares2Dequipos2Dtutores_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($titulares2Dequipos2Dtutores_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $titulares2Dequipos2Dtutores_list->PageUrl() ?>start=<?php echo $titulares2Dequipos2Dtutores_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $titulares2Dequipos2Dtutores_list->Pager->PageCount ?></span>
</div>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $titulares2Dequipos2Dtutores_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $titulares2Dequipos2Dtutores_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $titulares2Dequipos2Dtutores_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($titulares2Dequipos2Dtutores_list->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
</div>
<?php } ?>
<?php if ($titulares2Dequipos2Dtutores_list->TotalRecs == 0 && $titulares2Dequipos2Dtutores->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($titulares2Dequipos2Dtutores_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($titulares2Dequipos2Dtutores->Export == "") { ?>
<script type="text/javascript">
ftitulares2Dequipos2Dtutoreslistsrch.FilterList = <?php echo $titulares2Dequipos2Dtutores_list->GetFilterList() ?>;
ftitulares2Dequipos2Dtutoreslistsrch.Init();
ftitulares2Dequipos2Dtutoreslist.Init();
</script>
<?php } ?>
<?php
$titulares2Dequipos2Dtutores_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($titulares2Dequipos2Dtutores->Export == "") { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$titulares2Dequipos2Dtutores_list->Page_Terminate();
?>
