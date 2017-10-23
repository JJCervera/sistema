<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "atencion_para_stinfo.php" ?>
<?php include_once "atencion_equiposinfo.php" ?>
<?php include_once "usuariosinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$atencion_para_st_list = NULL; // Initialize page object first

class catencion_para_st_list extends catencion_para_st {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = "{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}";

	// Table name
	var $TableName = 'atencion_para_st';

	// Page object name
	var $PageObjName = 'atencion_para_st_list';

	// Grid form hidden field names
	var $FormName = 'fatencion_para_stlist';
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
	var $AuditTrailOnAdd = TRUE;
	var $AuditTrailOnEdit = TRUE;
	var $AuditTrailOnDelete = TRUE;
	var $AuditTrailOnView = FALSE;
	var $AuditTrailOnViewData = FALSE;
	var $AuditTrailOnSearch = FALSE;

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

		// Table object (atencion_para_st)
		if (!isset($GLOBALS["atencion_para_st"]) || get_class($GLOBALS["atencion_para_st"]) == "catencion_para_st") {
			$GLOBALS["atencion_para_st"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["atencion_para_st"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "atencion_para_stadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "atencion_para_stdelete.php";
		$this->MultiUpdateUrl = "atencion_para_stupdate.php";

		// Table object (atencion_equipos)
		if (!isset($GLOBALS['atencion_equipos'])) $GLOBALS['atencion_equipos'] = new catencion_equipos();

		// Table object (usuarios)
		if (!isset($GLOBALS['usuarios'])) $GLOBALS['usuarios'] = new cusuarios();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'atencion_para_st', TRUE);

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
		$this->FilterOptions->TagClassName = "ewFilterOption fatencion_para_stlistsrch";

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

		// Create form object
		$objForm = new cFormObj();

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
		$this->Id_Atencion->SetVisibility();
		$this->NroSerie->SetVisibility();
		$this->Nro_Tiket->SetVisibility();
		$this->Id_Tipo_Retiro->SetVisibility();
		$this->Referencia_Tipo_Retiro->SetVisibility();
		$this->Fecha_Retiro->SetVisibility();
		$this->Observacion->SetVisibility();
		$this->Fecha_Devolucion->SetVisibility();

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

		// Set up master detail parameters
		$this->SetUpMasterParms();

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
		global $EW_EXPORT, $atencion_para_st;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($atencion_para_st);
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

			// Check QueryString parameters
			if (@$_GET["a"] <> "") {
				$this->CurrentAction = $_GET["a"];

				// Clear inline mode
				if ($this->CurrentAction == "cancel")
					$this->ClearInlineMode();

				// Switch to grid edit mode
				if ($this->CurrentAction == "gridedit")
					$this->GridEditMode();

				// Switch to inline edit mode
				if ($this->CurrentAction == "edit")
					$this->InlineEditMode();

				// Switch to inline add mode
				if ($this->CurrentAction == "add" || $this->CurrentAction == "copy")
					$this->InlineAddMode();

				// Switch to grid add mode
				if ($this->CurrentAction == "gridadd")
					$this->GridAddMode();
			} else {
				if (@$_POST["a_list"] <> "") {
					$this->CurrentAction = $_POST["a_list"]; // Get action

					// Grid Update
					if (($this->CurrentAction == "gridupdate" || $this->CurrentAction == "gridoverwrite") && @$_SESSION[EW_SESSION_INLINE_MODE] == "gridedit") {
						if ($this->ValidateGridForm()) {
							$bGridUpdate = $this->GridUpdate();
						} else {
							$bGridUpdate = FALSE;
							$this->setFailureMessage($gsFormError);
						}
						if (!$bGridUpdate) {
							$this->EventCancelled = TRUE;
							$this->CurrentAction = "gridedit"; // Stay in Grid Edit mode
						}
					}

					// Inline Update
					if (($this->CurrentAction == "update" || $this->CurrentAction == "overwrite") && @$_SESSION[EW_SESSION_INLINE_MODE] == "edit")
						$this->InlineUpdate();

					// Insert Inline
					if ($this->CurrentAction == "insert" && @$_SESSION[EW_SESSION_INLINE_MODE] == "add")
						$this->InlineInsert();

					// Grid Insert
					if ($this->CurrentAction == "gridinsert" && @$_SESSION[EW_SESSION_INLINE_MODE] == "gridadd") {
						if ($this->ValidateGridForm()) {
							$bGridInsert = $this->GridInsert();
						} else {
							$bGridInsert = FALSE;
							$this->setFailureMessage($gsFormError);
						}
						if (!$bGridInsert) {
							$this->EventCancelled = TRUE;
							$this->CurrentAction = "gridadd"; // Stay in Grid Add mode
						}
					}
				}
			}

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

			// Show grid delete link for grid add / grid edit
			if ($this->AllowAddDeleteRow) {
				if ($this->CurrentAction == "gridadd" || $this->CurrentAction == "gridedit") {
					$item = $this->ListOptions->GetItem("griddelete");
					if ($item) $item->Visible = TRUE;
				}
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

		// Restore master/detail filter
		$this->DbMasterFilter = $this->GetMasterFilter(); // Restore master filter
		$this->DbDetailFilter = $this->GetDetailFilter(); // Restore detail filter
		ew_AddFilter($sFilter, $this->DbDetailFilter);
		ew_AddFilter($sFilter, $this->SearchWhere);

		// Load master record
		if ($this->CurrentMode <> "add" && $this->GetMasterFilter() <> "" && $this->getCurrentMasterTable() == "atencion_equipos") {
			global $atencion_equipos;
			$rsmaster = $atencion_equipos->LoadRs($this->DbMasterFilter);
			$this->MasterRecordExists = ($rsmaster && !$rsmaster->EOF);
			if (!$this->MasterRecordExists) {
				$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record found
				$this->Page_Terminate("atencion_equiposlist.php"); // Return to master page
			} else {
				$atencion_equipos->LoadListRowValues($rsmaster);
				$atencion_equipos->RowType = EW_ROWTYPE_MASTER; // Master row
				$atencion_equipos->RenderListRow();
				$rsmaster->Close();
			}
		}

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

	//  Exit inline mode
	function ClearInlineMode() {
		$this->setKey("Id_Atencion", ""); // Clear inline edit key
		$this->setKey("NroSerie", ""); // Clear inline edit key
		$this->LastAction = $this->CurrentAction; // Save last action
		$this->CurrentAction = ""; // Clear action
		$_SESSION[EW_SESSION_INLINE_MODE] = ""; // Clear inline mode
	}

	// Switch to Grid Add mode
	function GridAddMode() {
		$_SESSION[EW_SESSION_INLINE_MODE] = "gridadd"; // Enabled grid add
	}

	// Switch to Grid Edit mode
	function GridEditMode() {
		$_SESSION[EW_SESSION_INLINE_MODE] = "gridedit"; // Enable grid edit
	}

	// Switch to Inline Edit mode
	function InlineEditMode() {
		global $Security, $Language;
		if (!$Security->CanEdit())
			$this->Page_Terminate("login.php"); // Go to login page
		$bInlineEdit = TRUE;
		if (@$_GET["Id_Atencion"] <> "") {
			$this->Id_Atencion->setQueryStringValue($_GET["Id_Atencion"]);
		} else {
			$bInlineEdit = FALSE;
		}
		if (@$_GET["NroSerie"] <> "") {
			$this->NroSerie->setQueryStringValue($_GET["NroSerie"]);
		} else {
			$bInlineEdit = FALSE;
		}
		if ($bInlineEdit) {
			if ($this->LoadRow()) {
				$this->setKey("Id_Atencion", $this->Id_Atencion->CurrentValue); // Set up inline edit key
				$this->setKey("NroSerie", $this->NroSerie->CurrentValue); // Set up inline edit key
				$_SESSION[EW_SESSION_INLINE_MODE] = "edit"; // Enable inline edit
			}
		}
	}

	// Perform update to Inline Edit record
	function InlineUpdate() {
		global $Language, $objForm, $gsFormError;
		$objForm->Index = 1; 
		$this->LoadFormValues(); // Get form values

		// Validate form
		$bInlineUpdate = TRUE;
		if (!$this->ValidateForm()) {	
			$bInlineUpdate = FALSE; // Form error, reset action
			$this->setFailureMessage($gsFormError);
		} else {
			$bInlineUpdate = FALSE;
			$rowkey = strval($objForm->GetValue($this->FormKeyName));
			if ($this->SetupKeyValues($rowkey)) { // Set up key values
				if ($this->CheckInlineEditKey()) { // Check key
					$this->SendEmail = TRUE; // Send email on update success
					$bInlineUpdate = $this->EditRow(); // Update record
				} else {
					$bInlineUpdate = FALSE;
				}
			}
		}
		if ($bInlineUpdate) { // Update success
			if ($this->getSuccessMessage() == "")
				$this->setSuccessMessage($Language->Phrase("UpdateSuccess")); // Set up success message
			$this->ClearInlineMode(); // Clear inline edit mode
		} else {
			if ($this->getFailureMessage() == "")
				$this->setFailureMessage($Language->Phrase("UpdateFailed")); // Set update failed message
			$this->EventCancelled = TRUE; // Cancel event
			$this->CurrentAction = "edit"; // Stay in edit mode
		}
	}

	// Check Inline Edit key
	function CheckInlineEditKey() {

		//CheckInlineEditKey = True
		if (strval($this->getKey("Id_Atencion")) <> strval($this->Id_Atencion->CurrentValue))
			return FALSE;
		if (strval($this->getKey("NroSerie")) <> strval($this->NroSerie->CurrentValue))
			return FALSE;
		return TRUE;
	}

	// Switch to Inline Add mode
	function InlineAddMode() {
		global $Security, $Language;
		if (!$Security->CanAdd())
			$this->Page_Terminate("login.php"); // Return to login page
		$this->CurrentAction = "add";
		$_SESSION[EW_SESSION_INLINE_MODE] = "add"; // Enable inline add
	}

	// Perform update to Inline Add/Copy record
	function InlineInsert() {
		global $Language, $objForm, $gsFormError;
		$this->LoadOldRecord(); // Load old recordset
		$objForm->Index = 0;
		$this->LoadFormValues(); // Get form values

		// Validate form
		if (!$this->ValidateForm()) {
			$this->setFailureMessage($gsFormError); // Set validation error message
			$this->EventCancelled = TRUE; // Set event cancelled
			$this->CurrentAction = "add"; // Stay in add mode
			return;
		}
		$this->SendEmail = TRUE; // Send email on add success
		if ($this->AddRow($this->OldRecordset)) { // Add record
			if ($this->getSuccessMessage() == "")
				$this->setSuccessMessage($Language->Phrase("AddSuccess")); // Set up add success message
			$this->ClearInlineMode(); // Clear inline add mode
		} else { // Add failed
			$this->EventCancelled = TRUE; // Set event cancelled
			$this->CurrentAction = "add"; // Stay in add mode
		}
	}

	// Perform update to grid
	function GridUpdate() {
		global $Language, $objForm, $gsFormError;
		$bGridUpdate = TRUE;

		// Get old recordset
		$this->CurrentFilter = $this->BuildKeyFilter();
		if ($this->CurrentFilter == "")
			$this->CurrentFilter = "0=1";
		$sSql = $this->SQL();
		$conn = &$this->Connection();
		if ($rs = $conn->Execute($sSql)) {
			$rsold = $rs->GetRows();
			$rs->Close();
		}

		// Call Grid Updating event
		if (!$this->Grid_Updating($rsold)) {
			if ($this->getFailureMessage() == "")
				$this->setFailureMessage($Language->Phrase("GridEditCancelled")); // Set grid edit cancelled message
			return FALSE;
		}

		// Begin transaction
		$conn->BeginTrans();
		if ($this->AuditTrailOnEdit) $this->WriteAuditTrailDummy($Language->Phrase("BatchUpdateBegin")); // Batch update begin
		$sKey = "";

		// Update row index and get row key
		$objForm->Index = -1;
		$rowcnt = strval($objForm->GetValue($this->FormKeyCountName));
		if ($rowcnt == "" || !is_numeric($rowcnt))
			$rowcnt = 0;

		// Update all rows based on key
		for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {
			$objForm->Index = $rowindex;
			$rowkey = strval($objForm->GetValue($this->FormKeyName));
			$rowaction = strval($objForm->GetValue($this->FormActionName));

			// Load all values and keys
			if ($rowaction <> "insertdelete") { // Skip insert then deleted rows
				$this->LoadFormValues(); // Get form values
				if ($rowaction == "" || $rowaction == "edit" || $rowaction == "delete") {
					$bGridUpdate = $this->SetupKeyValues($rowkey); // Set up key values
				} else {
					$bGridUpdate = TRUE;
				}

				// Skip empty row
				if ($rowaction == "insert" && $this->EmptyRow()) {

					// No action required
				// Validate form and insert/update/delete record

				} elseif ($bGridUpdate) {
					if ($rowaction == "delete") {
						$this->CurrentFilter = $this->KeyFilter();
						$bGridUpdate = $this->DeleteRows(); // Delete this row
					} else if (!$this->ValidateForm()) {
						$bGridUpdate = FALSE; // Form error, reset action
						$this->setFailureMessage($gsFormError);
					} else {
						if ($rowaction == "insert") {
							$bGridUpdate = $this->AddRow(); // Insert this row
						} else {
							if ($rowkey <> "") {
								$this->SendEmail = FALSE; // Do not send email on update success
								$bGridUpdate = $this->EditRow(); // Update this row
							}
						} // End update
					}
				}
				if ($bGridUpdate) {
					if ($sKey <> "") $sKey .= ", ";
					$sKey .= $rowkey;
				} else {
					break;
				}
			}
		}
		if ($bGridUpdate) {
			$conn->CommitTrans(); // Commit transaction

			// Get new recordset
			if ($rs = $conn->Execute($sSql)) {
				$rsnew = $rs->GetRows();
				$rs->Close();
			}

			// Call Grid_Updated event
			$this->Grid_Updated($rsold, $rsnew);
			if ($this->AuditTrailOnEdit) $this->WriteAuditTrailDummy($Language->Phrase("BatchUpdateSuccess")); // Batch update success
			if ($this->getSuccessMessage() == "")
				$this->setSuccessMessage($Language->Phrase("UpdateSuccess")); // Set up update success message
			$this->ClearInlineMode(); // Clear inline edit mode
		} else {
			$conn->RollbackTrans(); // Rollback transaction
			if ($this->AuditTrailOnEdit) $this->WriteAuditTrailDummy($Language->Phrase("BatchUpdateRollback")); // Batch update rollback
			if ($this->getFailureMessage() == "")
				$this->setFailureMessage($Language->Phrase("UpdateFailed")); // Set update failed message
		}
		return $bGridUpdate;
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
			$this->Id_Atencion->setFormValue($arrKeyFlds[0]);
			if (!is_numeric($this->Id_Atencion->FormValue))
				return FALSE;
			$this->NroSerie->setFormValue($arrKeyFlds[1]);
		}
		return TRUE;
	}

	// Perform Grid Add
	function GridInsert() {
		global $Language, $objForm, $gsFormError;
		$rowindex = 1;
		$bGridInsert = FALSE;
		$conn = &$this->Connection();

		// Call Grid Inserting event
		if (!$this->Grid_Inserting()) {
			if ($this->getFailureMessage() == "") {
				$this->setFailureMessage($Language->Phrase("GridAddCancelled")); // Set grid add cancelled message
			}
			return FALSE;
		}

		// Begin transaction
		$conn->BeginTrans();

		// Init key filter
		$sWrkFilter = "";
		$addcnt = 0;
		if ($this->AuditTrailOnAdd) $this->WriteAuditTrailDummy($Language->Phrase("BatchInsertBegin")); // Batch insert begin
		$sKey = "";

		// Get row count
		$objForm->Index = -1;
		$rowcnt = strval($objForm->GetValue($this->FormKeyCountName));
		if ($rowcnt == "" || !is_numeric($rowcnt))
			$rowcnt = 0;

		// Insert all rows
		for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {

			// Load current row values
			$objForm->Index = $rowindex;
			$rowaction = strval($objForm->GetValue($this->FormActionName));
			if ($rowaction <> "" && $rowaction <> "insert")
				continue; // Skip
			$this->LoadFormValues(); // Get form values
			if (!$this->EmptyRow()) {
				$addcnt++;
				$this->SendEmail = FALSE; // Do not send email on insert success

				// Validate form
				if (!$this->ValidateForm()) {
					$bGridInsert = FALSE; // Form error, reset action
					$this->setFailureMessage($gsFormError);
				} else {
					$bGridInsert = $this->AddRow($this->OldRecordset); // Insert this row
				}
				if ($bGridInsert) {
					if ($sKey <> "") $sKey .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
					$sKey .= $this->Id_Atencion->CurrentValue;
					if ($sKey <> "") $sKey .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
					$sKey .= $this->NroSerie->CurrentValue;

					// Add filter for this record
					$sFilter = $this->KeyFilter();
					if ($sWrkFilter <> "") $sWrkFilter .= " OR ";
					$sWrkFilter .= $sFilter;
				} else {
					break;
				}
			}
		}
		if ($addcnt == 0) { // No record inserted
			$this->setFailureMessage($Language->Phrase("NoAddRecord"));
			$bGridInsert = FALSE;
		}
		if ($bGridInsert) {
			$conn->CommitTrans(); // Commit transaction

			// Get new recordset
			$this->CurrentFilter = $sWrkFilter;
			$sSql = $this->SQL();
			if ($rs = $conn->Execute($sSql)) {
				$rsnew = $rs->GetRows();
				$rs->Close();
			}

			// Call Grid_Inserted event
			$this->Grid_Inserted($rsnew);
			if ($this->AuditTrailOnAdd) $this->WriteAuditTrailDummy($Language->Phrase("BatchInsertSuccess")); // Batch insert success
			if ($this->getSuccessMessage() == "")
				$this->setSuccessMessage($Language->Phrase("InsertSuccess")); // Set up insert success message
			$this->ClearInlineMode(); // Clear grid add mode
		} else {
			$conn->RollbackTrans(); // Rollback transaction
			if ($this->AuditTrailOnAdd) $this->WriteAuditTrailDummy($Language->Phrase("BatchInsertRollback")); // Batch insert rollback
			if ($this->getFailureMessage() == "") {
				$this->setFailureMessage($Language->Phrase("InsertFailed")); // Set insert failed message
			}
		}
		return $bGridInsert;
	}

	// Check if empty row
	function EmptyRow() {
		global $objForm;
		if ($objForm->HasValue("x_Id_Atencion") && $objForm->HasValue("o_Id_Atencion") && $this->Id_Atencion->CurrentValue <> $this->Id_Atencion->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_NroSerie") && $objForm->HasValue("o_NroSerie") && $this->NroSerie->CurrentValue <> $this->NroSerie->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Nro_Tiket") && $objForm->HasValue("o_Nro_Tiket") && $this->Nro_Tiket->CurrentValue <> $this->Nro_Tiket->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Id_Tipo_Retiro") && $objForm->HasValue("o_Id_Tipo_Retiro") && $this->Id_Tipo_Retiro->CurrentValue <> $this->Id_Tipo_Retiro->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Referencia_Tipo_Retiro") && $objForm->HasValue("o_Referencia_Tipo_Retiro") && $this->Referencia_Tipo_Retiro->CurrentValue <> $this->Referencia_Tipo_Retiro->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Fecha_Retiro") && $objForm->HasValue("o_Fecha_Retiro") && $this->Fecha_Retiro->CurrentValue <> $this->Fecha_Retiro->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Observacion") && $objForm->HasValue("o_Observacion") && $this->Observacion->CurrentValue <> $this->Observacion->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Fecha_Devolucion") && $objForm->HasValue("o_Fecha_Devolucion") && $this->Fecha_Devolucion->CurrentValue <> $this->Fecha_Devolucion->OldValue)
			return FALSE;
		return TRUE;
	}

	// Validate grid form
	function ValidateGridForm() {
		global $objForm;

		// Get row count
		$objForm->Index = -1;
		$rowcnt = strval($objForm->GetValue($this->FormKeyCountName));
		if ($rowcnt == "" || !is_numeric($rowcnt))
			$rowcnt = 0;

		// Validate all records
		for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {

			// Load current row values
			$objForm->Index = $rowindex;
			$rowaction = strval($objForm->GetValue($this->FormActionName));
			if ($rowaction <> "delete" && $rowaction <> "insertdelete") {
				$this->LoadFormValues(); // Get form values
				if ($rowaction == "insert" && $this->EmptyRow()) {

					// Ignore
				} else if (!$this->ValidateForm()) {
					return FALSE;
				}
			}
		}
		return TRUE;
	}

	// Get all form values of the grid
	function GetGridFormValues() {
		global $objForm;

		// Get row count
		$objForm->Index = -1;
		$rowcnt = strval($objForm->GetValue($this->FormKeyCountName));
		if ($rowcnt == "" || !is_numeric($rowcnt))
			$rowcnt = 0;
		$rows = array();

		// Loop through all records
		for ($rowindex = 1; $rowindex <= $rowcnt; $rowindex++) {

			// Load current row values
			$objForm->Index = $rowindex;
			$rowaction = strval($objForm->GetValue($this->FormActionName));
			if ($rowaction <> "delete" && $rowaction <> "insertdelete") {
				$this->LoadFormValues(); // Get form values
				if ($rowaction == "insert" && $this->EmptyRow()) {

					// Ignore
				} else {
					$rows[] = $this->GetFieldValues("FormValue"); // Return row as array
				}
			}
		}
		return $rows; // Return as array of array
	}

	// Restore form values for current row
	function RestoreCurrentRowFormValues($idx) {
		global $objForm;

		// Get row based on current index
		$objForm->Index = $idx;
		$this->LoadFormValues(); // Load form values
	}

	// Get list of filters
	function GetFilterList() {
		global $UserProfile;

		// Load server side filters
		if (EW_SEARCH_FILTER_OPTION == "Server") {
			$sSavedFilterList = $UserProfile->GetSearchFilters(CurrentUserName(), "fatencion_para_stlistsrch");
		} else {
			$sSavedFilterList = "";
		}

		// Initialize
		$sFilterList = "";
		$sFilterList = ew_Concat($sFilterList, $this->Id_Atencion->AdvancedSearch->ToJSON(), ","); // Field Id_Atencion
		$sFilterList = ew_Concat($sFilterList, $this->NroSerie->AdvancedSearch->ToJSON(), ","); // Field NroSerie
		$sFilterList = ew_Concat($sFilterList, $this->Nro_Tiket->AdvancedSearch->ToJSON(), ","); // Field Nro_Tiket
		$sFilterList = ew_Concat($sFilterList, $this->Id_Tipo_Retiro->AdvancedSearch->ToJSON(), ","); // Field Id_Tipo_Retiro
		$sFilterList = ew_Concat($sFilterList, $this->Referencia_Tipo_Retiro->AdvancedSearch->ToJSON(), ","); // Field Referencia_Tipo_Retiro
		$sFilterList = ew_Concat($sFilterList, $this->Fecha_Retiro->AdvancedSearch->ToJSON(), ","); // Field Fecha_Retiro
		$sFilterList = ew_Concat($sFilterList, $this->Observacion->AdvancedSearch->ToJSON(), ","); // Field Observacion
		$sFilterList = ew_Concat($sFilterList, $this->Fecha_Devolucion->AdvancedSearch->ToJSON(), ","); // Field Fecha_Devolucion
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
			$UserProfile->SetSearchFilters(CurrentUserName(), "fatencion_para_stlistsrch", $filters);
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

		// Field Id_Atencion
		$this->Id_Atencion->AdvancedSearch->SearchValue = @$filter["x_Id_Atencion"];
		$this->Id_Atencion->AdvancedSearch->SearchOperator = @$filter["z_Id_Atencion"];
		$this->Id_Atencion->AdvancedSearch->SearchCondition = @$filter["v_Id_Atencion"];
		$this->Id_Atencion->AdvancedSearch->SearchValue2 = @$filter["y_Id_Atencion"];
		$this->Id_Atencion->AdvancedSearch->SearchOperator2 = @$filter["w_Id_Atencion"];
		$this->Id_Atencion->AdvancedSearch->Save();

		// Field NroSerie
		$this->NroSerie->AdvancedSearch->SearchValue = @$filter["x_NroSerie"];
		$this->NroSerie->AdvancedSearch->SearchOperator = @$filter["z_NroSerie"];
		$this->NroSerie->AdvancedSearch->SearchCondition = @$filter["v_NroSerie"];
		$this->NroSerie->AdvancedSearch->SearchValue2 = @$filter["y_NroSerie"];
		$this->NroSerie->AdvancedSearch->SearchOperator2 = @$filter["w_NroSerie"];
		$this->NroSerie->AdvancedSearch->Save();

		// Field Nro_Tiket
		$this->Nro_Tiket->AdvancedSearch->SearchValue = @$filter["x_Nro_Tiket"];
		$this->Nro_Tiket->AdvancedSearch->SearchOperator = @$filter["z_Nro_Tiket"];
		$this->Nro_Tiket->AdvancedSearch->SearchCondition = @$filter["v_Nro_Tiket"];
		$this->Nro_Tiket->AdvancedSearch->SearchValue2 = @$filter["y_Nro_Tiket"];
		$this->Nro_Tiket->AdvancedSearch->SearchOperator2 = @$filter["w_Nro_Tiket"];
		$this->Nro_Tiket->AdvancedSearch->Save();

		// Field Id_Tipo_Retiro
		$this->Id_Tipo_Retiro->AdvancedSearch->SearchValue = @$filter["x_Id_Tipo_Retiro"];
		$this->Id_Tipo_Retiro->AdvancedSearch->SearchOperator = @$filter["z_Id_Tipo_Retiro"];
		$this->Id_Tipo_Retiro->AdvancedSearch->SearchCondition = @$filter["v_Id_Tipo_Retiro"];
		$this->Id_Tipo_Retiro->AdvancedSearch->SearchValue2 = @$filter["y_Id_Tipo_Retiro"];
		$this->Id_Tipo_Retiro->AdvancedSearch->SearchOperator2 = @$filter["w_Id_Tipo_Retiro"];
		$this->Id_Tipo_Retiro->AdvancedSearch->Save();

		// Field Referencia_Tipo_Retiro
		$this->Referencia_Tipo_Retiro->AdvancedSearch->SearchValue = @$filter["x_Referencia_Tipo_Retiro"];
		$this->Referencia_Tipo_Retiro->AdvancedSearch->SearchOperator = @$filter["z_Referencia_Tipo_Retiro"];
		$this->Referencia_Tipo_Retiro->AdvancedSearch->SearchCondition = @$filter["v_Referencia_Tipo_Retiro"];
		$this->Referencia_Tipo_Retiro->AdvancedSearch->SearchValue2 = @$filter["y_Referencia_Tipo_Retiro"];
		$this->Referencia_Tipo_Retiro->AdvancedSearch->SearchOperator2 = @$filter["w_Referencia_Tipo_Retiro"];
		$this->Referencia_Tipo_Retiro->AdvancedSearch->Save();

		// Field Fecha_Retiro
		$this->Fecha_Retiro->AdvancedSearch->SearchValue = @$filter["x_Fecha_Retiro"];
		$this->Fecha_Retiro->AdvancedSearch->SearchOperator = @$filter["z_Fecha_Retiro"];
		$this->Fecha_Retiro->AdvancedSearch->SearchCondition = @$filter["v_Fecha_Retiro"];
		$this->Fecha_Retiro->AdvancedSearch->SearchValue2 = @$filter["y_Fecha_Retiro"];
		$this->Fecha_Retiro->AdvancedSearch->SearchOperator2 = @$filter["w_Fecha_Retiro"];
		$this->Fecha_Retiro->AdvancedSearch->Save();

		// Field Observacion
		$this->Observacion->AdvancedSearch->SearchValue = @$filter["x_Observacion"];
		$this->Observacion->AdvancedSearch->SearchOperator = @$filter["z_Observacion"];
		$this->Observacion->AdvancedSearch->SearchCondition = @$filter["v_Observacion"];
		$this->Observacion->AdvancedSearch->SearchValue2 = @$filter["y_Observacion"];
		$this->Observacion->AdvancedSearch->SearchOperator2 = @$filter["w_Observacion"];
		$this->Observacion->AdvancedSearch->Save();

		// Field Fecha_Devolucion
		$this->Fecha_Devolucion->AdvancedSearch->SearchValue = @$filter["x_Fecha_Devolucion"];
		$this->Fecha_Devolucion->AdvancedSearch->SearchOperator = @$filter["z_Fecha_Devolucion"];
		$this->Fecha_Devolucion->AdvancedSearch->SearchCondition = @$filter["v_Fecha_Devolucion"];
		$this->Fecha_Devolucion->AdvancedSearch->SearchValue2 = @$filter["y_Fecha_Devolucion"];
		$this->Fecha_Devolucion->AdvancedSearch->SearchOperator2 = @$filter["w_Fecha_Devolucion"];
		$this->Fecha_Devolucion->AdvancedSearch->Save();
		$this->BasicSearch->setKeyword(@$filter[EW_TABLE_BASIC_SEARCH]);
		$this->BasicSearch->setType(@$filter[EW_TABLE_BASIC_SEARCH_TYPE]);
	}

	// Advanced search WHERE clause based on QueryString
	function AdvancedSearchWhere($Default = FALSE) {
		global $Security;
		$sWhere = "";
		if (!$Security->CanSearch()) return "";
		$this->BuildSearchSql($sWhere, $this->Id_Atencion, $Default, FALSE); // Id_Atencion
		$this->BuildSearchSql($sWhere, $this->NroSerie, $Default, FALSE); // NroSerie
		$this->BuildSearchSql($sWhere, $this->Nro_Tiket, $Default, FALSE); // Nro_Tiket
		$this->BuildSearchSql($sWhere, $this->Id_Tipo_Retiro, $Default, FALSE); // Id_Tipo_Retiro
		$this->BuildSearchSql($sWhere, $this->Referencia_Tipo_Retiro, $Default, FALSE); // Referencia_Tipo_Retiro
		$this->BuildSearchSql($sWhere, $this->Fecha_Retiro, $Default, FALSE); // Fecha_Retiro
		$this->BuildSearchSql($sWhere, $this->Observacion, $Default, FALSE); // Observacion
		$this->BuildSearchSql($sWhere, $this->Fecha_Devolucion, $Default, FALSE); // Fecha_Devolucion

		// Set up search parm
		if (!$Default && $sWhere <> "") {
			$this->Command = "search";
		}
		if (!$Default && $this->Command == "search") {
			$this->Id_Atencion->AdvancedSearch->Save(); // Id_Atencion
			$this->NroSerie->AdvancedSearch->Save(); // NroSerie
			$this->Nro_Tiket->AdvancedSearch->Save(); // Nro_Tiket
			$this->Id_Tipo_Retiro->AdvancedSearch->Save(); // Id_Tipo_Retiro
			$this->Referencia_Tipo_Retiro->AdvancedSearch->Save(); // Referencia_Tipo_Retiro
			$this->Fecha_Retiro->AdvancedSearch->Save(); // Fecha_Retiro
			$this->Observacion->AdvancedSearch->Save(); // Observacion
			$this->Fecha_Devolucion->AdvancedSearch->Save(); // Fecha_Devolucion
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
		$this->BuildBasicSearchSQL($sWhere, $this->Id_Atencion, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->NroSerie, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Nro_Tiket, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Id_Tipo_Retiro, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Referencia_Tipo_Retiro, $arKeywords, $type);
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
		if ($this->Id_Atencion->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->NroSerie->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Nro_Tiket->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Id_Tipo_Retiro->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Referencia_Tipo_Retiro->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Fecha_Retiro->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Observacion->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Fecha_Devolucion->AdvancedSearch->IssetSession())
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
		$this->Id_Atencion->AdvancedSearch->UnsetSession();
		$this->NroSerie->AdvancedSearch->UnsetSession();
		$this->Nro_Tiket->AdvancedSearch->UnsetSession();
		$this->Id_Tipo_Retiro->AdvancedSearch->UnsetSession();
		$this->Referencia_Tipo_Retiro->AdvancedSearch->UnsetSession();
		$this->Fecha_Retiro->AdvancedSearch->UnsetSession();
		$this->Observacion->AdvancedSearch->UnsetSession();
		$this->Fecha_Devolucion->AdvancedSearch->UnsetSession();
	}

	// Restore all search parameters
	function RestoreSearchParms() {
		$this->RestoreSearch = TRUE;

		// Restore basic search values
		$this->BasicSearch->Load();

		// Restore advanced search values
		$this->Id_Atencion->AdvancedSearch->Load();
		$this->NroSerie->AdvancedSearch->Load();
		$this->Nro_Tiket->AdvancedSearch->Load();
		$this->Id_Tipo_Retiro->AdvancedSearch->Load();
		$this->Referencia_Tipo_Retiro->AdvancedSearch->Load();
		$this->Fecha_Retiro->AdvancedSearch->Load();
		$this->Observacion->AdvancedSearch->Load();
		$this->Fecha_Devolucion->AdvancedSearch->Load();
	}

	// Set up sort parameters
	function SetUpSortOrder() {

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$this->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$this->CurrentOrderType = @$_GET["ordertype"];
			$this->UpdateSort($this->Id_Atencion); // Id_Atencion
			$this->UpdateSort($this->NroSerie); // NroSerie
			$this->UpdateSort($this->Nro_Tiket); // Nro_Tiket
			$this->UpdateSort($this->Id_Tipo_Retiro); // Id_Tipo_Retiro
			$this->UpdateSort($this->Referencia_Tipo_Retiro); // Referencia_Tipo_Retiro
			$this->UpdateSort($this->Fecha_Retiro); // Fecha_Retiro
			$this->UpdateSort($this->Observacion); // Observacion
			$this->UpdateSort($this->Fecha_Devolucion); // Fecha_Devolucion
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

			// Reset master/detail keys
			if ($this->Command == "resetall") {
				$this->setCurrentMasterTable(""); // Clear master table
				$this->DbMasterFilter = "";
				$this->DbDetailFilter = "";
				$this->Id_Atencion->setSessionValue("");
				$this->NroSerie->setSessionValue("");
			}

			// Reset sorting order
			if ($this->Command == "resetsort") {
				$sOrderBy = "";
				$this->setSessionOrderBy($sOrderBy);
				$this->Id_Atencion->setSort("");
				$this->NroSerie->setSort("");
				$this->Nro_Tiket->setSort("");
				$this->Id_Tipo_Retiro->setSort("");
				$this->Referencia_Tipo_Retiro->setSort("");
				$this->Fecha_Retiro->setSort("");
				$this->Observacion->setSort("");
				$this->Fecha_Devolucion->setSort("");
			}

			// Reset start position
			$this->StartRec = 1;
			$this->setStartRecordNumber($this->StartRec);
		}
	}

	// Set up list options
	function SetupListOptions() {
		global $Security, $Language;

		// "griddelete"
		if ($this->AllowAddDeleteRow) {
			$item = &$this->ListOptions->Add("griddelete");
			$item->CssStyle = "white-space: nowrap;";
			$item->OnLeft = TRUE;
			$item->Visible = FALSE; // Default hidden
		}

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

		// "edit"
		$item = &$this->ListOptions->Add("edit");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->CanEdit();
		$item->OnLeft = TRUE;

		// "copy"
		$item = &$this->ListOptions->Add("copy");
		$item->CssStyle = "white-space: nowrap;";
		$item->Visible = $Security->CanAdd();
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
		$item->Visible = ($Security->CanDelete() || $Security->CanEdit());
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

		// Set up row action and key
		if (is_numeric($this->RowIndex) && $this->CurrentMode <> "view") {
			$objForm->Index = $this->RowIndex;
			$ActionName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormActionName);
			$OldKeyName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormOldKeyName);
			$KeyName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormKeyName);
			$BlankRowName = str_replace("k_", "k" . $this->RowIndex . "_", $this->FormBlankRowName);
			if ($this->RowAction <> "")
				$this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $ActionName . "\" id=\"" . $ActionName . "\" value=\"" . $this->RowAction . "\">";
			if ($this->RowAction == "delete") {
				$rowkey = $objForm->GetValue($this->FormKeyName);
				$this->SetupKeyValues($rowkey);
			}
			if ($this->RowAction == "insert" && $this->CurrentAction == "F" && $this->EmptyRow())
				$this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $BlankRowName . "\" id=\"" . $BlankRowName . "\" value=\"1\">";
		}

		// "delete"
		if ($this->AllowAddDeleteRow) {
			if ($this->CurrentAction == "gridadd" || $this->CurrentAction == "gridedit") {
				$option = &$this->ListOptions;
				$option->UseButtonGroup = TRUE; // Use button group for grid delete button
				$option->UseImageAndText = TRUE; // Use image and text for grid delete button
				$oListOpt = &$option->Items["griddelete"];
				if (!$Security->CanDelete() && is_numeric($this->RowIndex) && ($this->RowAction == "" || $this->RowAction == "edit")) { // Do not allow delete existing record
					$oListOpt->Body = "&nbsp;";
				} else {
					$oListOpt->Body = "<a class=\"ewGridLink ewGridDelete\" title=\"" . ew_HtmlTitle($Language->Phrase("DeleteLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("DeleteLink")) . "\" onclick=\"return ew_DeleteGridRow(this, " . $this->RowIndex . ");\">" . $Language->Phrase("DeleteLink") . "</a>";
				}
			}
		}

		// "copy"
		$oListOpt = &$this->ListOptions->Items["copy"];
		if (($this->CurrentAction == "add" || $this->CurrentAction == "copy") && $this->RowType == EW_ROWTYPE_ADD) { // Inline Add/Copy
			$this->ListOptions->CustomItem = "copy"; // Show copy column only
			$cancelurl = $this->AddMasterUrl($this->PageUrl() . "a=cancel");
			$oListOpt->Body = "<div" . (($oListOpt->OnLeft) ? " style=\"text-align: right\"" : "") . ">" .
				"<a class=\"ewGridLink ewInlineInsert\" title=\"" . ew_HtmlTitle($Language->Phrase("InsertLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("InsertLink")) . "\" href=\"\" onclick=\"return ewForms(this).Submit('" . $this->PageName() . "');\">" . $Language->Phrase("InsertLink") . "</a>&nbsp;" .
				"<a class=\"ewGridLink ewInlineCancel\" title=\"" . ew_HtmlTitle($Language->Phrase("CancelLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("CancelLink")) . "\" href=\"" . $cancelurl . "\">" . $Language->Phrase("CancelLink") . "</a>" .
				"<input type=\"hidden\" name=\"a_list\" id=\"a_list\" value=\"insert\"></div>";
			return;
		}

		// "edit"
		$oListOpt = &$this->ListOptions->Items["edit"];
		if ($this->CurrentAction == "edit" && $this->RowType == EW_ROWTYPE_EDIT) { // Inline-Edit
			$this->ListOptions->CustomItem = "edit"; // Show edit column only
			$cancelurl = $this->AddMasterUrl($this->PageUrl() . "a=cancel");
				$oListOpt->Body = "<div" . (($oListOpt->OnLeft) ? " style=\"text-align: right\"" : "") . ">" .
					"<a class=\"ewGridLink ewInlineUpdate\" title=\"" . ew_HtmlTitle($Language->Phrase("UpdateLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("UpdateLink")) . "\" href=\"\" onclick=\"return ewForms(this).Submit('" . ew_GetHashUrl($this->PageName(), $this->PageObjName . "_row_" . $this->RowCnt) . "');\">" . $Language->Phrase("UpdateLink") . "</a>&nbsp;" .
					"<a class=\"ewGridLink ewInlineCancel\" title=\"" . ew_HtmlTitle($Language->Phrase("CancelLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("CancelLink")) . "\" href=\"" . $cancelurl . "\">" . $Language->Phrase("CancelLink") . "</a>" .
					"<input type=\"hidden\" name=\"a_list\" id=\"a_list\" value=\"update\"></div>";
			$oListOpt->Body .= "<input type=\"hidden\" name=\"k" . $this->RowIndex . "_key\" id=\"k" . $this->RowIndex . "_key\" value=\"" . ew_HtmlEncode($this->Id_Atencion->CurrentValue . $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"] . $this->NroSerie->CurrentValue) . "\">";
			return;
		}

		// "view"
		$oListOpt = &$this->ListOptions->Items["view"];
		$viewcaption = ew_HtmlTitle($Language->Phrase("ViewLink"));
		if ($Security->CanView()) {
			if (ew_IsMobile())
				$oListOpt->Body = "<a class=\"ewRowLink ewView\" title=\"" . $viewcaption . "\" data-caption=\"" . $viewcaption . "\" href=\"" . ew_HtmlEncode($this->ViewUrl) . "\">" . $Language->Phrase("ViewLink") . "</a>";
			else
				$oListOpt->Body = "<a class=\"ewRowLink ewView\" title=\"" . $viewcaption . "\" data-table=\"atencion_para_st\" data-caption=\"" . $viewcaption . "\" href=\"javascript:void(0);\" onclick=\"ew_ModalDialogShow({lnk:this,url:'" . ew_HtmlEncode($this->ViewUrl) . "'});\">" . $Language->Phrase("ViewLink") . "</a>";
		} else {
			$oListOpt->Body = "";
		}

		// "edit"
		$oListOpt = &$this->ListOptions->Items["edit"];
		$editcaption = ew_HtmlTitle($Language->Phrase("EditLink"));
		if ($Security->CanEdit()) {
			$oListOpt->Body = "<a class=\"ewRowLink ewEdit\" title=\"" . ew_HtmlTitle($Language->Phrase("EditLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("EditLink")) . "\" href=\"" . ew_HtmlEncode($this->EditUrl) . "\">" . $Language->Phrase("EditLink") . "</a>";
			$oListOpt->Body .= "<a class=\"ewRowLink ewInlineEdit\" title=\"" . ew_HtmlTitle($Language->Phrase("InlineEditLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("InlineEditLink")) . "\" href=\"" . ew_HtmlEncode(ew_GetHashUrl($this->InlineEditUrl, $this->PageObjName . "_row_" . $this->RowCnt)) . "\">" . $Language->Phrase("InlineEditLink") . "</a>";
		} else {
			$oListOpt->Body = "";
		}

		// "copy"
		$oListOpt = &$this->ListOptions->Items["copy"];
		$copycaption = ew_HtmlTitle($Language->Phrase("CopyLink"));
		if ($Security->CanAdd()) {
			$oListOpt->Body = "<a class=\"ewRowLink ewCopy\" title=\"" . $copycaption . "\" data-caption=\"" . $copycaption . "\" href=\"" . ew_HtmlEncode($this->CopyUrl) . "\">" . $Language->Phrase("CopyLink") . "</a>";
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
		$oListOpt->Body = "<input type=\"checkbox\" name=\"key_m[]\" value=\"" . ew_HtmlEncode($this->Id_Atencion->CurrentValue . $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"] . $this->NroSerie->CurrentValue) . "\" onclick='ew_ClickMultiCheckbox(event);'>";
		if ($this->CurrentAction == "gridedit" && is_numeric($this->RowIndex)) {
			$this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $KeyName . "\" id=\"" . $KeyName . "\" value=\"" . $this->Id_Atencion->CurrentValue . $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"] . $this->NroSerie->CurrentValue . "\">";
		}
		$this->RenderListOptionsExt();

		// Call ListOptions_Rendered event
		$this->ListOptions_Rendered();
	}

	// Set up other options
	function SetupOtherOptions() {
		global $Language, $Security;
		$options = &$this->OtherOptions;
		$option = $options["addedit"];

		// Add
		$item = &$option->Add("add");
		$addcaption = ew_HtmlTitle($Language->Phrase("AddLink"));
		$item->Body = "<a class=\"ewAddEdit ewAdd\" title=\"" . $addcaption . "\" data-caption=\"" . $addcaption . "\" href=\"" . ew_HtmlEncode($this->AddUrl) . "\">" . $Language->Phrase("AddLink") . "</a>";
		$item->Visible = ($this->AddUrl <> "" && $Security->CanAdd());

		// Inline Add
		$item = &$option->Add("inlineadd");
		$item->Body = "<a class=\"ewAddEdit ewInlineAdd\" title=\"" . ew_HtmlTitle($Language->Phrase("InlineAddLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("InlineAddLink")) . "\" href=\"" . ew_HtmlEncode($this->InlineAddUrl) . "\">" .$Language->Phrase("InlineAddLink") . "</a>";
		$item->Visible = ($this->InlineAddUrl <> "" && $Security->CanAdd());
		$item = &$option->Add("gridadd");
		$item->Body = "<a class=\"ewAddEdit ewGridAdd\" title=\"" . ew_HtmlTitle($Language->Phrase("GridAddLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("GridAddLink")) . "\" href=\"" . ew_HtmlEncode($this->GridAddUrl) . "\">" . $Language->Phrase("GridAddLink") . "</a>";
		$item->Visible = ($this->GridAddUrl <> "" && $Security->CanAdd());

		// Add grid edit
		$option = $options["addedit"];
		$item = &$option->Add("gridedit");
		$item->Body = "<a class=\"ewAddEdit ewGridEdit\" title=\"" . ew_HtmlTitle($Language->Phrase("GridEditLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("GridEditLink")) . "\" href=\"" . ew_HtmlEncode($this->GridEditUrl) . "\">" . $Language->Phrase("GridEditLink") . "</a>";
		$item->Visible = ($this->GridEditUrl <> "" && $Security->CanEdit());
		$option = $options["action"];

		// Add multi delete
		$item = &$option->Add("multidelete");
		$item->Body = "<a class=\"ewAction ewMultiDelete\" title=\"" . ew_HtmlTitle($Language->Phrase("DeleteSelectedLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("DeleteSelectedLink")) . "\" href=\"\" onclick=\"ew_SubmitAction(event,{f:document.fatencion_para_stlist,url:'" . $this->MultiDeleteUrl . "',msg:ewLanguage.Phrase('DeleteConfirmMsg')});return false;\">" . $Language->Phrase("DeleteSelectedLink") . "</a>";
		$item->Visible = ($Security->CanDelete());

		// Add multi update
		$item = &$option->Add("multiupdate");
		$item->Body = "<a class=\"ewAction ewMultiUpdate\" title=\"" . ew_HtmlTitle($Language->Phrase("UpdateSelectedLink")) . "\" data-table=\"atencion_para_st\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("UpdateSelectedLink")) . "\" href=\"\" onclick=\"ew_ModalDialogShow({lnk:this,f:document.fatencion_para_stlist,url:'" . $this->MultiUpdateUrl . "',caption:'" . $Language->Phrase("UpdateBtn") . "'});return false;\">" . $Language->Phrase("UpdateSelectedLink") . "</a>";
		$item->Visible = ($Security->CanEdit());

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
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"fatencion_para_stlistsrch\" href=\"#\">" . $Language->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = TRUE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"fatencion_para_stlistsrch\" href=\"#\">" . $Language->Phrase("DeleteFilter") . "</a>";
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
		if ($this->CurrentAction <> "gridadd" && $this->CurrentAction <> "gridedit") { // Not grid add/edit mode
			$option = &$options["action"];

			// Set up list action buttons
			foreach ($this->ListActions->Items as $listaction) {
				if ($listaction->Select == EW_ACTION_MULTIPLE) {
					$item = &$option->Add("custom_" . $listaction->Action);
					$caption = $listaction->Caption;
					$icon = ($listaction->Icon <> "") ? "<span class=\"" . ew_HtmlEncode($listaction->Icon) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\"></span> " : $caption;
					$item->Body = "<a class=\"ewAction ewListAction\" title=\"" . ew_HtmlEncode($caption) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({f:document.fatencion_para_stlist}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . "</a>";
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
		} else { // Grid add/edit mode

			// Hide all options first
			foreach ($options as &$option)
				$option->HideAllOptions();
			if ($this->CurrentAction == "gridadd") {
				if ($this->AllowAddDeleteRow) {

					// Add add blank row
					$option = &$options["addedit"];
					$option->UseDropDownButton = FALSE;
					$option->UseImageAndText = TRUE;
					$item = &$option->Add("addblankrow");
					$item->Body = "<a class=\"ewAddEdit ewAddBlankRow\" title=\"" . ew_HtmlTitle($Language->Phrase("AddBlankRow")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("AddBlankRow")) . "\" href=\"javascript:void(0);\" onclick=\"ew_AddGridRow(this);\">" . $Language->Phrase("AddBlankRow") . "</a>";
					$item->Visible = $Security->CanAdd();
				}
				$option = &$options["action"];
				$option->UseDropDownButton = FALSE;
				$option->UseImageAndText = TRUE;

				// Add grid insert
				$item = &$option->Add("gridinsert");
				$item->Body = "<a class=\"ewAction ewGridInsert\" title=\"" . ew_HtmlTitle($Language->Phrase("GridInsertLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("GridInsertLink")) . "\" href=\"\" onclick=\"return ewForms(this).Submit('" . $this->PageName() . "');\">" . $Language->Phrase("GridInsertLink") . "</a>";

				// Add grid cancel
				$item = &$option->Add("gridcancel");
				$cancelurl = $this->AddMasterUrl($this->PageUrl() . "a=cancel");
				$item->Body = "<a class=\"ewAction ewGridCancel\" title=\"" . ew_HtmlTitle($Language->Phrase("GridCancelLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("GridCancelLink")) . "\" href=\"" . $cancelurl . "\">" . $Language->Phrase("GridCancelLink") . "</a>";
			}
			if ($this->CurrentAction == "gridedit") {
				if ($this->AllowAddDeleteRow) {

					// Add add blank row
					$option = &$options["addedit"];
					$option->UseDropDownButton = FALSE;
					$option->UseImageAndText = TRUE;
					$item = &$option->Add("addblankrow");
					$item->Body = "<a class=\"ewAddEdit ewAddBlankRow\" title=\"" . ew_HtmlTitle($Language->Phrase("AddBlankRow")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("AddBlankRow")) . "\" href=\"javascript:void(0);\" onclick=\"ew_AddGridRow(this);\">" . $Language->Phrase("AddBlankRow") . "</a>";
					$item->Visible = $Security->CanAdd();
				}
				$option = &$options["action"];
				$option->UseDropDownButton = FALSE;
				$option->UseImageAndText = TRUE;
					$item = &$option->Add("gridsave");
					$item->Body = "<a class=\"ewAction ewGridSave\" title=\"" . ew_HtmlTitle($Language->Phrase("GridSaveLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("GridSaveLink")) . "\" href=\"\" onclick=\"return ewForms(this).Submit('" . $this->PageName() . "');\">" . $Language->Phrase("GridSaveLink") . "</a>";
					$item = &$option->Add("gridcancel");
					$cancelurl = $this->AddMasterUrl($this->PageUrl() . "a=cancel");
					$item->Body = "<a class=\"ewAction ewGridCancel\" title=\"" . ew_HtmlTitle($Language->Phrase("GridCancelLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("GridCancelLink")) . "\" href=\"" . $cancelurl . "\">" . $Language->Phrase("GridCancelLink") . "</a>";
			}
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
		$item->Body = "<button type=\"button\" class=\"btn btn-default ewSearchToggle" . $SearchToggleClass . "\" title=\"" . $Language->Phrase("SearchPanel") . "\" data-caption=\"" . $Language->Phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"fatencion_para_stlistsrch\">" . $Language->Phrase("SearchBtn") . "</button>";
		$item->Visible = TRUE;

		// Show all button
		$item = &$this->SearchOptions->Add("showall");
		$item->Body = "<a class=\"btn btn-default ewShowAll\" title=\"" . $Language->Phrase("ShowAll") . "\" data-caption=\"" . $Language->Phrase("ShowAll") . "\" href=\"" . $this->PageUrl() . "cmd=reset\">" . $Language->Phrase("ShowAllBtn") . "</a>";
		$item->Visible = ($this->SearchWhere <> $this->DefaultSearchWhere && $this->SearchWhere <> "0=101");

		// Advanced search button
		$item = &$this->SearchOptions->Add("advancedsearch");
		$item->Body = "<a class=\"btn btn-default ewAdvancedSearch\" title=\"" . $Language->Phrase("AdvancedSearch") . "\" data-caption=\"" . $Language->Phrase("AdvancedSearch") . "\" href=\"atencion_para_stsrch.php\">" . $Language->Phrase("AdvancedSearchBtn") . "</a>";
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

	// Load default values
	function LoadDefaultValues() {
		$this->Id_Atencion->CurrentValue = NULL;
		$this->Id_Atencion->OldValue = $this->Id_Atencion->CurrentValue;
		$this->NroSerie->CurrentValue = NULL;
		$this->NroSerie->OldValue = $this->NroSerie->CurrentValue;
		$this->Nro_Tiket->CurrentValue = 'PENDIENTE';
		$this->Nro_Tiket->OldValue = $this->Nro_Tiket->CurrentValue;
		$this->Id_Tipo_Retiro->CurrentValue = 1;
		$this->Id_Tipo_Retiro->OldValue = $this->Id_Tipo_Retiro->CurrentValue;
		$this->Referencia_Tipo_Retiro->CurrentValue = NULL;
		$this->Referencia_Tipo_Retiro->OldValue = $this->Referencia_Tipo_Retiro->CurrentValue;
		$this->Fecha_Retiro->CurrentValue = NULL;
		$this->Fecha_Retiro->OldValue = $this->Fecha_Retiro->CurrentValue;
		$this->Observacion->CurrentValue = NULL;
		$this->Observacion->OldValue = $this->Observacion->CurrentValue;
		$this->Fecha_Devolucion->CurrentValue = NULL;
		$this->Fecha_Devolucion->OldValue = $this->Fecha_Devolucion->CurrentValue;
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
		// Id_Atencion

		$this->Id_Atencion->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Id_Atencion"]);
		if ($this->Id_Atencion->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Id_Atencion->AdvancedSearch->SearchOperator = @$_GET["z_Id_Atencion"];

		// NroSerie
		$this->NroSerie->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_NroSerie"]);
		if ($this->NroSerie->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->NroSerie->AdvancedSearch->SearchOperator = @$_GET["z_NroSerie"];

		// Nro_Tiket
		$this->Nro_Tiket->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Nro_Tiket"]);
		if ($this->Nro_Tiket->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Nro_Tiket->AdvancedSearch->SearchOperator = @$_GET["z_Nro_Tiket"];

		// Id_Tipo_Retiro
		$this->Id_Tipo_Retiro->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Id_Tipo_Retiro"]);
		if ($this->Id_Tipo_Retiro->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Id_Tipo_Retiro->AdvancedSearch->SearchOperator = @$_GET["z_Id_Tipo_Retiro"];

		// Referencia_Tipo_Retiro
		$this->Referencia_Tipo_Retiro->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Referencia_Tipo_Retiro"]);
		if ($this->Referencia_Tipo_Retiro->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Referencia_Tipo_Retiro->AdvancedSearch->SearchOperator = @$_GET["z_Referencia_Tipo_Retiro"];

		// Fecha_Retiro
		$this->Fecha_Retiro->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Fecha_Retiro"]);
		if ($this->Fecha_Retiro->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Fecha_Retiro->AdvancedSearch->SearchOperator = @$_GET["z_Fecha_Retiro"];

		// Observacion
		$this->Observacion->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Observacion"]);
		if ($this->Observacion->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Observacion->AdvancedSearch->SearchOperator = @$_GET["z_Observacion"];

		// Fecha_Devolucion
		$this->Fecha_Devolucion->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Fecha_Devolucion"]);
		if ($this->Fecha_Devolucion->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Fecha_Devolucion->AdvancedSearch->SearchOperator = @$_GET["z_Fecha_Devolucion"];
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->Id_Atencion->FldIsDetailKey) {
			$this->Id_Atencion->setFormValue($objForm->GetValue("x_Id_Atencion"));
		}
		$this->Id_Atencion->setOldValue($objForm->GetValue("o_Id_Atencion"));
		if (!$this->NroSerie->FldIsDetailKey) {
			$this->NroSerie->setFormValue($objForm->GetValue("x_NroSerie"));
		}
		$this->NroSerie->setOldValue($objForm->GetValue("o_NroSerie"));
		if (!$this->Nro_Tiket->FldIsDetailKey) {
			$this->Nro_Tiket->setFormValue($objForm->GetValue("x_Nro_Tiket"));
		}
		$this->Nro_Tiket->setOldValue($objForm->GetValue("o_Nro_Tiket"));
		if (!$this->Id_Tipo_Retiro->FldIsDetailKey) {
			$this->Id_Tipo_Retiro->setFormValue($objForm->GetValue("x_Id_Tipo_Retiro"));
		}
		$this->Id_Tipo_Retiro->setOldValue($objForm->GetValue("o_Id_Tipo_Retiro"));
		if (!$this->Referencia_Tipo_Retiro->FldIsDetailKey) {
			$this->Referencia_Tipo_Retiro->setFormValue($objForm->GetValue("x_Referencia_Tipo_Retiro"));
		}
		$this->Referencia_Tipo_Retiro->setOldValue($objForm->GetValue("o_Referencia_Tipo_Retiro"));
		if (!$this->Fecha_Retiro->FldIsDetailKey) {
			$this->Fecha_Retiro->setFormValue($objForm->GetValue("x_Fecha_Retiro"));
			$this->Fecha_Retiro->CurrentValue = ew_UnFormatDateTime($this->Fecha_Retiro->CurrentValue, 7);
		}
		$this->Fecha_Retiro->setOldValue($objForm->GetValue("o_Fecha_Retiro"));
		if (!$this->Observacion->FldIsDetailKey) {
			$this->Observacion->setFormValue($objForm->GetValue("x_Observacion"));
		}
		$this->Observacion->setOldValue($objForm->GetValue("o_Observacion"));
		if (!$this->Fecha_Devolucion->FldIsDetailKey) {
			$this->Fecha_Devolucion->setFormValue($objForm->GetValue("x_Fecha_Devolucion"));
			$this->Fecha_Devolucion->CurrentValue = ew_UnFormatDateTime($this->Fecha_Devolucion->CurrentValue, 7);
		}
		$this->Fecha_Devolucion->setOldValue($objForm->GetValue("o_Fecha_Devolucion"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->Id_Atencion->CurrentValue = $this->Id_Atencion->FormValue;
		$this->NroSerie->CurrentValue = $this->NroSerie->FormValue;
		$this->Nro_Tiket->CurrentValue = $this->Nro_Tiket->FormValue;
		$this->Id_Tipo_Retiro->CurrentValue = $this->Id_Tipo_Retiro->FormValue;
		$this->Referencia_Tipo_Retiro->CurrentValue = $this->Referencia_Tipo_Retiro->FormValue;
		$this->Fecha_Retiro->CurrentValue = $this->Fecha_Retiro->FormValue;
		$this->Fecha_Retiro->CurrentValue = ew_UnFormatDateTime($this->Fecha_Retiro->CurrentValue, 7);
		$this->Observacion->CurrentValue = $this->Observacion->FormValue;
		$this->Fecha_Devolucion->CurrentValue = $this->Fecha_Devolucion->FormValue;
		$this->Fecha_Devolucion->CurrentValue = ew_UnFormatDateTime($this->Fecha_Devolucion->CurrentValue, 7);
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
		$this->Id_Atencion->setDbValue($rs->fields('Id_Atencion'));
		$this->NroSerie->setDbValue($rs->fields('NroSerie'));
		$this->Nro_Tiket->setDbValue($rs->fields('Nro_Tiket'));
		$this->Id_Tipo_Retiro->setDbValue($rs->fields('Id_Tipo_Retiro'));
		$this->Referencia_Tipo_Retiro->setDbValue($rs->fields('Referencia_Tipo_Retiro'));
		$this->Fecha_Retiro->setDbValue($rs->fields('Fecha_Retiro'));
		$this->Observacion->setDbValue($rs->fields('Observacion'));
		$this->Fecha_Devolucion->setDbValue($rs->fields('Fecha_Devolucion'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->Id_Atencion->DbValue = $row['Id_Atencion'];
		$this->NroSerie->DbValue = $row['NroSerie'];
		$this->Nro_Tiket->DbValue = $row['Nro_Tiket'];
		$this->Id_Tipo_Retiro->DbValue = $row['Id_Tipo_Retiro'];
		$this->Referencia_Tipo_Retiro->DbValue = $row['Referencia_Tipo_Retiro'];
		$this->Fecha_Retiro->DbValue = $row['Fecha_Retiro'];
		$this->Observacion->DbValue = $row['Observacion'];
		$this->Fecha_Devolucion->DbValue = $row['Fecha_Devolucion'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("Id_Atencion")) <> "")
			$this->Id_Atencion->CurrentValue = $this->getKey("Id_Atencion"); // Id_Atencion
		else
			$bValidKey = FALSE;
		if (strval($this->getKey("NroSerie")) <> "")
			$this->NroSerie->CurrentValue = $this->getKey("NroSerie"); // NroSerie
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
		// Id_Atencion
		// NroSerie
		// Nro_Tiket
		// Id_Tipo_Retiro
		// Referencia_Tipo_Retiro
		// Fecha_Retiro
		// Observacion
		// Fecha_Devolucion

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// Id_Atencion
		$this->Id_Atencion->ViewValue = $this->Id_Atencion->CurrentValue;
		$this->Id_Atencion->ViewCustomAttributes = "";

		// NroSerie
		$this->NroSerie->ViewValue = $this->NroSerie->CurrentValue;
		$this->NroSerie->ViewCustomAttributes = "";

		// Nro_Tiket
		$this->Nro_Tiket->ViewValue = $this->Nro_Tiket->CurrentValue;
		$this->Nro_Tiket->ViewCustomAttributes = "";

		// Id_Tipo_Retiro
		if (strval($this->Id_Tipo_Retiro->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Tipo_Retiro`" . ew_SearchString("=", $this->Id_Tipo_Retiro->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Tipo_Retiro`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tipo_retiro_atencion_st`";
		$sWhereWrk = "";
		$this->Id_Tipo_Retiro->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Tipo_Retiro, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `Descripcion` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Tipo_Retiro->ViewValue = $this->Id_Tipo_Retiro->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Tipo_Retiro->ViewValue = $this->Id_Tipo_Retiro->CurrentValue;
			}
		} else {
			$this->Id_Tipo_Retiro->ViewValue = NULL;
		}
		$this->Id_Tipo_Retiro->ViewCustomAttributes = "";

		// Referencia_Tipo_Retiro
		$this->Referencia_Tipo_Retiro->ViewValue = $this->Referencia_Tipo_Retiro->CurrentValue;
		$this->Referencia_Tipo_Retiro->ViewCustomAttributes = "";

		// Fecha_Retiro
		$this->Fecha_Retiro->ViewValue = $this->Fecha_Retiro->CurrentValue;
		$this->Fecha_Retiro->ViewValue = ew_FormatDateTime($this->Fecha_Retiro->ViewValue, 7);
		$this->Fecha_Retiro->ViewCustomAttributes = "";

		// Observacion
		$this->Observacion->ViewValue = $this->Observacion->CurrentValue;
		$this->Observacion->ViewCustomAttributes = "";

		// Fecha_Devolucion
		$this->Fecha_Devolucion->ViewValue = $this->Fecha_Devolucion->CurrentValue;
		$this->Fecha_Devolucion->ViewValue = ew_FormatDateTime($this->Fecha_Devolucion->ViewValue, 7);
		$this->Fecha_Devolucion->ViewCustomAttributes = "";

			// Id_Atencion
			$this->Id_Atencion->LinkCustomAttributes = "";
			$this->Id_Atencion->HrefValue = "";
			$this->Id_Atencion->TooltipValue = "";

			// NroSerie
			$this->NroSerie->LinkCustomAttributes = "";
			$this->NroSerie->HrefValue = "";
			$this->NroSerie->TooltipValue = "";

			// Nro_Tiket
			$this->Nro_Tiket->LinkCustomAttributes = "";
			$this->Nro_Tiket->HrefValue = "";
			$this->Nro_Tiket->TooltipValue = "";

			// Id_Tipo_Retiro
			$this->Id_Tipo_Retiro->LinkCustomAttributes = "";
			$this->Id_Tipo_Retiro->HrefValue = "";
			$this->Id_Tipo_Retiro->TooltipValue = "";

			// Referencia_Tipo_Retiro
			$this->Referencia_Tipo_Retiro->LinkCustomAttributes = "";
			$this->Referencia_Tipo_Retiro->HrefValue = "";
			$this->Referencia_Tipo_Retiro->TooltipValue = "";

			// Fecha_Retiro
			$this->Fecha_Retiro->LinkCustomAttributes = "";
			$this->Fecha_Retiro->HrefValue = "";
			$this->Fecha_Retiro->TooltipValue = "";

			// Observacion
			$this->Observacion->LinkCustomAttributes = "";
			$this->Observacion->HrefValue = "";
			$this->Observacion->TooltipValue = "";

			// Fecha_Devolucion
			$this->Fecha_Devolucion->LinkCustomAttributes = "";
			$this->Fecha_Devolucion->HrefValue = "";
			$this->Fecha_Devolucion->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// Id_Atencion
			$this->Id_Atencion->EditAttrs["class"] = "form-control";
			$this->Id_Atencion->EditCustomAttributes = "";
			if ($this->Id_Atencion->getSessionValue() <> "") {
				$this->Id_Atencion->CurrentValue = $this->Id_Atencion->getSessionValue();
				$this->Id_Atencion->OldValue = $this->Id_Atencion->CurrentValue;
			$this->Id_Atencion->ViewValue = $this->Id_Atencion->CurrentValue;
			$this->Id_Atencion->ViewCustomAttributes = "";
			} else {
			$this->Id_Atencion->EditValue = ew_HtmlEncode($this->Id_Atencion->CurrentValue);
			$this->Id_Atencion->PlaceHolder = ew_RemoveHtml($this->Id_Atencion->FldCaption());
			}

			// NroSerie
			$this->NroSerie->EditAttrs["class"] = "form-control";
			$this->NroSerie->EditCustomAttributes = "";
			if ($this->NroSerie->getSessionValue() <> "") {
				$this->NroSerie->CurrentValue = $this->NroSerie->getSessionValue();
				$this->NroSerie->OldValue = $this->NroSerie->CurrentValue;
			$this->NroSerie->ViewValue = $this->NroSerie->CurrentValue;
			$this->NroSerie->ViewCustomAttributes = "";
			} else {
			$this->NroSerie->EditValue = ew_HtmlEncode($this->NroSerie->CurrentValue);
			$this->NroSerie->PlaceHolder = ew_RemoveHtml($this->NroSerie->FldCaption());
			}

			// Nro_Tiket
			$this->Nro_Tiket->EditAttrs["class"] = "form-control";
			$this->Nro_Tiket->EditCustomAttributes = "";
			$this->Nro_Tiket->EditValue = ew_HtmlEncode($this->Nro_Tiket->CurrentValue);
			$this->Nro_Tiket->PlaceHolder = ew_RemoveHtml($this->Nro_Tiket->FldCaption());

			// Id_Tipo_Retiro
			$this->Id_Tipo_Retiro->EditAttrs["class"] = "form-control";
			$this->Id_Tipo_Retiro->EditCustomAttributes = "";
			if (trim(strval($this->Id_Tipo_Retiro->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Tipo_Retiro`" . ew_SearchString("=", $this->Id_Tipo_Retiro->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Tipo_Retiro`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `tipo_retiro_atencion_st`";
			$sWhereWrk = "";
			$this->Id_Tipo_Retiro->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Tipo_Retiro, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Descripcion` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Tipo_Retiro->EditValue = $arwrk;

			// Referencia_Tipo_Retiro
			$this->Referencia_Tipo_Retiro->EditAttrs["class"] = "form-control";
			$this->Referencia_Tipo_Retiro->EditCustomAttributes = "";
			$this->Referencia_Tipo_Retiro->EditValue = ew_HtmlEncode($this->Referencia_Tipo_Retiro->CurrentValue);
			$this->Referencia_Tipo_Retiro->PlaceHolder = ew_RemoveHtml($this->Referencia_Tipo_Retiro->FldCaption());

			// Fecha_Retiro
			$this->Fecha_Retiro->EditAttrs["class"] = "form-control";
			$this->Fecha_Retiro->EditCustomAttributes = "";
			$this->Fecha_Retiro->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->Fecha_Retiro->CurrentValue, 7));
			$this->Fecha_Retiro->PlaceHolder = ew_RemoveHtml($this->Fecha_Retiro->FldCaption());

			// Observacion
			$this->Observacion->EditAttrs["class"] = "form-control";
			$this->Observacion->EditCustomAttributes = "";
			$this->Observacion->EditValue = ew_HtmlEncode($this->Observacion->CurrentValue);
			$this->Observacion->PlaceHolder = ew_RemoveHtml($this->Observacion->FldCaption());

			// Fecha_Devolucion
			$this->Fecha_Devolucion->EditAttrs["class"] = "form-control";
			$this->Fecha_Devolucion->EditCustomAttributes = "";
			$this->Fecha_Devolucion->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->Fecha_Devolucion->CurrentValue, 7));
			$this->Fecha_Devolucion->PlaceHolder = ew_RemoveHtml($this->Fecha_Devolucion->FldCaption());

			// Add refer script
			// Id_Atencion

			$this->Id_Atencion->LinkCustomAttributes = "";
			$this->Id_Atencion->HrefValue = "";

			// NroSerie
			$this->NroSerie->LinkCustomAttributes = "";
			$this->NroSerie->HrefValue = "";

			// Nro_Tiket
			$this->Nro_Tiket->LinkCustomAttributes = "";
			$this->Nro_Tiket->HrefValue = "";

			// Id_Tipo_Retiro
			$this->Id_Tipo_Retiro->LinkCustomAttributes = "";
			$this->Id_Tipo_Retiro->HrefValue = "";

			// Referencia_Tipo_Retiro
			$this->Referencia_Tipo_Retiro->LinkCustomAttributes = "";
			$this->Referencia_Tipo_Retiro->HrefValue = "";

			// Fecha_Retiro
			$this->Fecha_Retiro->LinkCustomAttributes = "";
			$this->Fecha_Retiro->HrefValue = "";

			// Observacion
			$this->Observacion->LinkCustomAttributes = "";
			$this->Observacion->HrefValue = "";

			// Fecha_Devolucion
			$this->Fecha_Devolucion->LinkCustomAttributes = "";
			$this->Fecha_Devolucion->HrefValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// Id_Atencion
			$this->Id_Atencion->EditAttrs["class"] = "form-control";
			$this->Id_Atencion->EditCustomAttributes = "";
			if ($this->Id_Atencion->getSessionValue() <> "") {
				$this->Id_Atencion->CurrentValue = $this->Id_Atencion->getSessionValue();
				$this->Id_Atencion->OldValue = $this->Id_Atencion->CurrentValue;
			$this->Id_Atencion->ViewValue = $this->Id_Atencion->CurrentValue;
			$this->Id_Atencion->ViewCustomAttributes = "";
			} else {
			}

			// NroSerie
			$this->NroSerie->EditAttrs["class"] = "form-control";
			$this->NroSerie->EditCustomAttributes = "";
			$this->NroSerie->EditValue = $this->NroSerie->CurrentValue;
			$this->NroSerie->ViewCustomAttributes = "";

			// Nro_Tiket
			$this->Nro_Tiket->EditAttrs["class"] = "form-control";
			$this->Nro_Tiket->EditCustomAttributes = "";
			$this->Nro_Tiket->EditValue = ew_HtmlEncode($this->Nro_Tiket->CurrentValue);
			$this->Nro_Tiket->PlaceHolder = ew_RemoveHtml($this->Nro_Tiket->FldCaption());

			// Id_Tipo_Retiro
			$this->Id_Tipo_Retiro->EditAttrs["class"] = "form-control";
			$this->Id_Tipo_Retiro->EditCustomAttributes = "";
			if (trim(strval($this->Id_Tipo_Retiro->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Tipo_Retiro`" . ew_SearchString("=", $this->Id_Tipo_Retiro->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Tipo_Retiro`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `tipo_retiro_atencion_st`";
			$sWhereWrk = "";
			$this->Id_Tipo_Retiro->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Tipo_Retiro, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Descripcion` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Tipo_Retiro->EditValue = $arwrk;

			// Referencia_Tipo_Retiro
			$this->Referencia_Tipo_Retiro->EditAttrs["class"] = "form-control";
			$this->Referencia_Tipo_Retiro->EditCustomAttributes = "";
			$this->Referencia_Tipo_Retiro->EditValue = ew_HtmlEncode($this->Referencia_Tipo_Retiro->CurrentValue);
			$this->Referencia_Tipo_Retiro->PlaceHolder = ew_RemoveHtml($this->Referencia_Tipo_Retiro->FldCaption());

			// Fecha_Retiro
			$this->Fecha_Retiro->EditAttrs["class"] = "form-control";
			$this->Fecha_Retiro->EditCustomAttributes = "";
			$this->Fecha_Retiro->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->Fecha_Retiro->CurrentValue, 7));
			$this->Fecha_Retiro->PlaceHolder = ew_RemoveHtml($this->Fecha_Retiro->FldCaption());

			// Observacion
			$this->Observacion->EditAttrs["class"] = "form-control";
			$this->Observacion->EditCustomAttributes = "";
			$this->Observacion->EditValue = ew_HtmlEncode($this->Observacion->CurrentValue);
			$this->Observacion->PlaceHolder = ew_RemoveHtml($this->Observacion->FldCaption());

			// Fecha_Devolucion
			$this->Fecha_Devolucion->EditAttrs["class"] = "form-control";
			$this->Fecha_Devolucion->EditCustomAttributes = "";
			$this->Fecha_Devolucion->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->Fecha_Devolucion->CurrentValue, 7));
			$this->Fecha_Devolucion->PlaceHolder = ew_RemoveHtml($this->Fecha_Devolucion->FldCaption());

			// Edit refer script
			// Id_Atencion

			$this->Id_Atencion->LinkCustomAttributes = "";
			$this->Id_Atencion->HrefValue = "";

			// NroSerie
			$this->NroSerie->LinkCustomAttributes = "";
			$this->NroSerie->HrefValue = "";

			// Nro_Tiket
			$this->Nro_Tiket->LinkCustomAttributes = "";
			$this->Nro_Tiket->HrefValue = "";

			// Id_Tipo_Retiro
			$this->Id_Tipo_Retiro->LinkCustomAttributes = "";
			$this->Id_Tipo_Retiro->HrefValue = "";

			// Referencia_Tipo_Retiro
			$this->Referencia_Tipo_Retiro->LinkCustomAttributes = "";
			$this->Referencia_Tipo_Retiro->HrefValue = "";

			// Fecha_Retiro
			$this->Fecha_Retiro->LinkCustomAttributes = "";
			$this->Fecha_Retiro->HrefValue = "";

			// Observacion
			$this->Observacion->LinkCustomAttributes = "";
			$this->Observacion->HrefValue = "";

			// Fecha_Devolucion
			$this->Fecha_Devolucion->LinkCustomAttributes = "";
			$this->Fecha_Devolucion->HrefValue = "";
		}
		if ($this->RowType == EW_ROWTYPE_ADD ||
			$this->RowType == EW_ROWTYPE_EDIT ||
			$this->RowType == EW_ROWTYPE_SEARCH) { // Add / Edit / Search row
			$this->SetupFieldTitles();
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

	// Validate form
	function ValidateForm() {
		global $Language, $gsFormError;

		// Initialize form error message
		$gsFormError = "";

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if (!$this->NroSerie->FldIsDetailKey && !is_null($this->NroSerie->FormValue) && $this->NroSerie->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->NroSerie->FldCaption(), $this->NroSerie->ReqErrMsg));
		}
		if (!$this->Nro_Tiket->FldIsDetailKey && !is_null($this->Nro_Tiket->FormValue) && $this->Nro_Tiket->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Nro_Tiket->FldCaption(), $this->Nro_Tiket->ReqErrMsg));
		}
		if (!$this->Id_Tipo_Retiro->FldIsDetailKey && !is_null($this->Id_Tipo_Retiro->FormValue) && $this->Id_Tipo_Retiro->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Id_Tipo_Retiro->FldCaption(), $this->Id_Tipo_Retiro->ReqErrMsg));
		}
		if (!ew_CheckEuroDate($this->Fecha_Retiro->FormValue)) {
			ew_AddMessage($gsFormError, $this->Fecha_Retiro->FldErrMsg());
		}
		if (!ew_CheckEuroDate($this->Fecha_Devolucion->FormValue)) {
			ew_AddMessage($gsFormError, $this->Fecha_Devolucion->FldErrMsg());
		}

		// Return validate result
		$ValidateForm = ($gsFormError == "");

		// Call Form_CustomValidate event
		$sFormCustomError = "";
		$ValidateForm = $ValidateForm && $this->Form_CustomValidate($sFormCustomError);
		if ($sFormCustomError <> "") {
			ew_AddMessage($gsFormError, $sFormCustomError);
		}
		return $ValidateForm;
	}

	//
	// Delete records based on current filter
	//
	function DeleteRows() {
		global $Language, $Security;
		if (!$Security->CanDelete()) {
			$this->setFailureMessage($Language->Phrase("NoDeletePermission")); // No delete permission
			return FALSE;
		}
		$DeleteRows = TRUE;
		$sSql = $this->SQL();
		$conn = &$this->Connection();
		$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE) {
			return FALSE;
		} elseif ($rs->EOF) {
			$this->setFailureMessage($Language->Phrase("NoRecord")); // No record found
			$rs->Close();
			return FALSE;

		//} else {
		//	$this->LoadRowValues($rs); // Load row values

		}
		$rows = ($rs) ? $rs->GetRows() : array();
		if ($this->AuditTrailOnDelete) $this->WriteAuditTrailDummy($Language->Phrase("BatchDeleteBegin")); // Batch delete begin

		// Clone old rows
		$rsold = $rows;
		if ($rs)
			$rs->Close();

		// Call row deleting event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$DeleteRows = $this->Row_Deleting($row);
				if (!$DeleteRows) break;
			}
		}
		if ($DeleteRows) {
			$sKey = "";
			foreach ($rsold as $row) {
				$sThisKey = "";
				if ($sThisKey <> "") $sThisKey .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
				$sThisKey .= $row['Id_Atencion'];
				if ($sThisKey <> "") $sThisKey .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
				$sThisKey .= $row['NroSerie'];
				$this->LoadDbValues($row);
				$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
				$DeleteRows = $this->Delete($row); // Delete
				$conn->raiseErrorFn = '';
				if ($DeleteRows === FALSE)
					break;
				if ($sKey <> "") $sKey .= ", ";
				$sKey .= $sThisKey;
			}
		} else {

			// Set up error message
			if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage <> "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("DeleteCancelled"));
			}
		}
		if ($DeleteRows) {
			if ($DeleteRows) {
				foreach ($rsold as $row)
					$this->WriteAuditTrailOnDelete($row);
			}
			if ($this->AuditTrailOnDelete) $this->WriteAuditTrailDummy($Language->Phrase("BatchDeleteSuccess")); // Batch delete success
		} else {
		}

		// Call Row Deleted event
		if ($DeleteRows) {
			foreach ($rsold as $row) {
				$this->Row_Deleted($row);
			}
		}
		return $DeleteRows;
	}

	// Update record based on key values
	function EditRow() {
		global $Security, $Language;
		$sFilter = $this->KeyFilter();
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$conn = &$this->Connection();
		$this->CurrentFilter = $sFilter;
		$sSql = $this->SQL();
		$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
		$rs = $conn->Execute($sSql);
		$conn->raiseErrorFn = '';
		if ($rs === FALSE)
			return FALSE;
		if ($rs->EOF) {
			$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record message
			$EditRow = FALSE; // Update Failed
		} else {

			// Save old values
			$rsold = &$rs->fields;
			$this->LoadDbValues($rsold);
			$rsnew = array();

			// Id_Atencion
			// NroSerie
			// Nro_Tiket

			$this->Nro_Tiket->SetDbValueDef($rsnew, $this->Nro_Tiket->CurrentValue, NULL, $this->Nro_Tiket->ReadOnly);

			// Id_Tipo_Retiro
			$this->Id_Tipo_Retiro->SetDbValueDef($rsnew, $this->Id_Tipo_Retiro->CurrentValue, 0, $this->Id_Tipo_Retiro->ReadOnly);

			// Referencia_Tipo_Retiro
			$this->Referencia_Tipo_Retiro->SetDbValueDef($rsnew, $this->Referencia_Tipo_Retiro->CurrentValue, NULL, $this->Referencia_Tipo_Retiro->ReadOnly);

			// Fecha_Retiro
			$this->Fecha_Retiro->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->Fecha_Retiro->CurrentValue, 7), NULL, $this->Fecha_Retiro->ReadOnly);

			// Observacion
			$this->Observacion->SetDbValueDef($rsnew, $this->Observacion->CurrentValue, NULL, $this->Observacion->ReadOnly);

			// Fecha_Devolucion
			$this->Fecha_Devolucion->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->Fecha_Devolucion->CurrentValue, 7), NULL, $this->Fecha_Devolucion->ReadOnly);

			// Check referential integrity for master table 'atencion_equipos'
			$bValidMasterRecord = TRUE;
			$sMasterFilter = $this->SqlMasterFilter_atencion_equipos();
			$KeyValue = isset($rsnew['Id_Atencion']) ? $rsnew['Id_Atencion'] : $rsold['Id_Atencion'];
			if (strval($KeyValue) <> "") {
				$sMasterFilter = str_replace("@Id_Atencion@", ew_AdjustSql($KeyValue), $sMasterFilter);
			} else {
				$bValidMasterRecord = FALSE;
			}
			$KeyValue = isset($rsnew['NroSerie']) ? $rsnew['NroSerie'] : $rsold['NroSerie'];
			if (strval($KeyValue) <> "") {
				$sMasterFilter = str_replace("@NroSerie@", ew_AdjustSql($KeyValue), $sMasterFilter);
			} else {
				$bValidMasterRecord = FALSE;
			}
			if ($bValidMasterRecord) {
				if (!isset($GLOBALS["atencion_equipos"])) $GLOBALS["atencion_equipos"] = new catencion_equipos();
				$rsmaster = $GLOBALS["atencion_equipos"]->LoadRs($sMasterFilter);
				$bValidMasterRecord = ($rsmaster && !$rsmaster->EOF);
				$rsmaster->Close();
			}
			if (!$bValidMasterRecord) {
				$sRelatedRecordMsg = str_replace("%t", "atencion_equipos", $Language->Phrase("RelatedRecordRequired"));
				$this->setFailureMessage($sRelatedRecordMsg);
				$rs->Close();
				return FALSE;
			}

			// Call Row Updating event
			$bUpdateRow = $this->Row_Updating($rsold, $rsnew);
			if ($bUpdateRow) {
				$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
				if (count($rsnew) > 0)
					$EditRow = $this->Update($rsnew, "", $rsold);
				else
					$EditRow = TRUE; // No field to update
				$conn->raiseErrorFn = '';
				if ($EditRow) {
				}
			} else {
				if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

					// Use the message, do nothing
				} elseif ($this->CancelMessage <> "") {
					$this->setFailureMessage($this->CancelMessage);
					$this->CancelMessage = "";
				} else {
					$this->setFailureMessage($Language->Phrase("UpdateCancelled"));
				}
				$EditRow = FALSE;
			}
		}

		// Call Row_Updated event
		if ($EditRow)
			$this->Row_Updated($rsold, $rsnew);
		if ($EditRow) {
			$this->WriteAuditTrailOnEdit($rsold, $rsnew);
		}
		$rs->Close();
		return $EditRow;
	}

	// Add record
	function AddRow($rsold = NULL) {
		global $Language, $Security;

		// Check referential integrity for master table 'atencion_equipos'
		$bValidMasterRecord = TRUE;
		$sMasterFilter = $this->SqlMasterFilter_atencion_equipos();
		if (strval($this->Id_Atencion->CurrentValue) <> "") {
			$sMasterFilter = str_replace("@Id_Atencion@", ew_AdjustSql($this->Id_Atencion->CurrentValue, "DB"), $sMasterFilter);
		} else {
			$bValidMasterRecord = FALSE;
		}
		if (strval($this->NroSerie->CurrentValue) <> "") {
			$sMasterFilter = str_replace("@NroSerie@", ew_AdjustSql($this->NroSerie->CurrentValue, "DB"), $sMasterFilter);
		} else {
			$bValidMasterRecord = FALSE;
		}
		if ($bValidMasterRecord) {
			if (!isset($GLOBALS["atencion_equipos"])) $GLOBALS["atencion_equipos"] = new catencion_equipos();
			$rsmaster = $GLOBALS["atencion_equipos"]->LoadRs($sMasterFilter);
			$bValidMasterRecord = ($rsmaster && !$rsmaster->EOF);
			$rsmaster->Close();
		}
		if (!$bValidMasterRecord) {
			$sRelatedRecordMsg = str_replace("%t", "atencion_equipos", $Language->Phrase("RelatedRecordRequired"));
			$this->setFailureMessage($sRelatedRecordMsg);
			return FALSE;
		}
		$conn = &$this->Connection();

		// Load db values from rsold
		if ($rsold) {
			$this->LoadDbValues($rsold);
		}
		$rsnew = array();

		// Id_Atencion
		$this->Id_Atencion->SetDbValueDef($rsnew, $this->Id_Atencion->CurrentValue, 0, FALSE);

		// NroSerie
		$this->NroSerie->SetDbValueDef($rsnew, $this->NroSerie->CurrentValue, "", FALSE);

		// Nro_Tiket
		$this->Nro_Tiket->SetDbValueDef($rsnew, $this->Nro_Tiket->CurrentValue, NULL, FALSE);

		// Id_Tipo_Retiro
		$this->Id_Tipo_Retiro->SetDbValueDef($rsnew, $this->Id_Tipo_Retiro->CurrentValue, 0, FALSE);

		// Referencia_Tipo_Retiro
		$this->Referencia_Tipo_Retiro->SetDbValueDef($rsnew, $this->Referencia_Tipo_Retiro->CurrentValue, NULL, FALSE);

		// Fecha_Retiro
		$this->Fecha_Retiro->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->Fecha_Retiro->CurrentValue, 7), NULL, FALSE);

		// Observacion
		$this->Observacion->SetDbValueDef($rsnew, $this->Observacion->CurrentValue, NULL, FALSE);

		// Fecha_Devolucion
		$this->Fecha_Devolucion->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->Fecha_Devolucion->CurrentValue, 7), NULL, FALSE);

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);

		// Check if key value entered
		if ($bInsertRow && $this->ValidateKey && strval($rsnew['Id_Atencion']) == "") {
			$this->setFailureMessage($Language->Phrase("InvalidKeyValue"));
			$bInsertRow = FALSE;
		}

		// Check if key value entered
		if ($bInsertRow && $this->ValidateKey && strval($rsnew['NroSerie']) == "") {
			$this->setFailureMessage($Language->Phrase("InvalidKeyValue"));
			$bInsertRow = FALSE;
		}

		// Check for duplicate key
		if ($bInsertRow && $this->ValidateKey) {
			$sFilter = $this->KeyFilter();
			$rsChk = $this->LoadRs($sFilter);
			if ($rsChk && !$rsChk->EOF) {
				$sKeyErrMsg = str_replace("%f", $sFilter, $Language->Phrase("DupKey"));
				$this->setFailureMessage($sKeyErrMsg);
				$rsChk->Close();
				$bInsertRow = FALSE;
			}
		}
		if ($bInsertRow) {
			$conn->raiseErrorFn = $GLOBALS["EW_ERROR_FN"];
			$AddRow = $this->Insert($rsnew);
			$conn->raiseErrorFn = '';
			if ($AddRow) {
			}
		} else {
			if ($this->getSuccessMessage() <> "" || $this->getFailureMessage() <> "") {

				// Use the message, do nothing
			} elseif ($this->CancelMessage <> "") {
				$this->setFailureMessage($this->CancelMessage);
				$this->CancelMessage = "";
			} else {
				$this->setFailureMessage($Language->Phrase("InsertCancelled"));
			}
			$AddRow = FALSE;
		}
		if ($AddRow) {

			// Call Row Inserted event
			$rs = ($rsold == NULL) ? NULL : $rsold->fields;
			$this->Row_Inserted($rs, $rsnew);
			$this->WriteAuditTrailOnAdd($rsnew);
		}
		return $AddRow;
	}

	// Load advanced search
	function LoadAdvancedSearch() {
		$this->Id_Atencion->AdvancedSearch->Load();
		$this->NroSerie->AdvancedSearch->Load();
		$this->Nro_Tiket->AdvancedSearch->Load();
		$this->Id_Tipo_Retiro->AdvancedSearch->Load();
		$this->Referencia_Tipo_Retiro->AdvancedSearch->Load();
		$this->Fecha_Retiro->AdvancedSearch->Load();
		$this->Observacion->AdvancedSearch->Load();
		$this->Fecha_Devolucion->AdvancedSearch->Load();
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
		$item->Body = "<button id=\"emf_atencion_para_st\" class=\"ewExportLink ewEmail\" title=\"" . $Language->Phrase("ExportToEmailText") . "\" data-caption=\"" . $Language->Phrase("ExportToEmailText") . "\" onclick=\"ew_EmailDialogShow({lnk:'emf_atencion_para_st',hdr:ewLanguage.Phrase('ExportToEmailText'),f:document.fatencion_para_stlist,sel:false" . $url . "});\">" . $Language->Phrase("ExportToEmail") . "</button>";
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

		// Export master record
		if (EW_EXPORT_MASTER_RECORD && $this->GetMasterFilter() <> "" && $this->getCurrentMasterTable() == "atencion_equipos") {
			global $atencion_equipos;
			if (!isset($atencion_equipos)) $atencion_equipos = new catencion_equipos;
			$rsmaster = $atencion_equipos->LoadRs($this->DbMasterFilter); // Load master record
			if ($rsmaster && !$rsmaster->EOF) {
				$ExportStyle = $Doc->Style;
				$Doc->SetStyle("v"); // Change to vertical
				if ($this->Export <> "csv" || EW_EXPORT_MASTER_RECORD_FOR_CSV) {
					$Doc->Table = &$atencion_equipos;
					$atencion_equipos->ExportDocument($Doc, $rsmaster, 1, 1);
					$Doc->ExportEmptyRow();
					$Doc->Table = &$this;
				}
				$Doc->SetStyle($ExportStyle); // Restore
				$rsmaster->Close();
			}
		}
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

	// Set up master/detail based on QueryString
	function SetUpMasterParms() {
		$bValidMaster = FALSE;

		// Get the keys for master table
		if (isset($_GET[EW_TABLE_SHOW_MASTER])) {
			$sMasterTblVar = $_GET[EW_TABLE_SHOW_MASTER];
			if ($sMasterTblVar == "") {
				$bValidMaster = TRUE;
				$this->DbMasterFilter = "";
				$this->DbDetailFilter = "";
			}
			if ($sMasterTblVar == "atencion_equipos") {
				$bValidMaster = TRUE;
				if (@$_GET["fk_Id_Atencion"] <> "") {
					$GLOBALS["atencion_equipos"]->Id_Atencion->setQueryStringValue($_GET["fk_Id_Atencion"]);
					$this->Id_Atencion->setQueryStringValue($GLOBALS["atencion_equipos"]->Id_Atencion->QueryStringValue);
					$this->Id_Atencion->setSessionValue($this->Id_Atencion->QueryStringValue);
					if (!is_numeric($GLOBALS["atencion_equipos"]->Id_Atencion->QueryStringValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
				if (@$_GET["fk_NroSerie"] <> "") {
					$GLOBALS["atencion_equipos"]->NroSerie->setQueryStringValue($_GET["fk_NroSerie"]);
					$this->NroSerie->setQueryStringValue($GLOBALS["atencion_equipos"]->NroSerie->QueryStringValue);
					$this->NroSerie->setSessionValue($this->NroSerie->QueryStringValue);
				} else {
					$bValidMaster = FALSE;
				}
			}
		} elseif (isset($_POST[EW_TABLE_SHOW_MASTER])) {
			$sMasterTblVar = $_POST[EW_TABLE_SHOW_MASTER];
			if ($sMasterTblVar == "") {
				$bValidMaster = TRUE;
				$this->DbMasterFilter = "";
				$this->DbDetailFilter = "";
			}
			if ($sMasterTblVar == "atencion_equipos") {
				$bValidMaster = TRUE;
				if (@$_POST["fk_Id_Atencion"] <> "") {
					$GLOBALS["atencion_equipos"]->Id_Atencion->setFormValue($_POST["fk_Id_Atencion"]);
					$this->Id_Atencion->setFormValue($GLOBALS["atencion_equipos"]->Id_Atencion->FormValue);
					$this->Id_Atencion->setSessionValue($this->Id_Atencion->FormValue);
					if (!is_numeric($GLOBALS["atencion_equipos"]->Id_Atencion->FormValue)) $bValidMaster = FALSE;
				} else {
					$bValidMaster = FALSE;
				}
				if (@$_POST["fk_NroSerie"] <> "") {
					$GLOBALS["atencion_equipos"]->NroSerie->setFormValue($_POST["fk_NroSerie"]);
					$this->NroSerie->setFormValue($GLOBALS["atencion_equipos"]->NroSerie->FormValue);
					$this->NroSerie->setSessionValue($this->NroSerie->FormValue);
				} else {
					$bValidMaster = FALSE;
				}
			}
		}
		if ($bValidMaster) {

			// Update URL
			$this->AddUrl = $this->AddMasterUrl($this->AddUrl);
			$this->InlineAddUrl = $this->AddMasterUrl($this->InlineAddUrl);
			$this->GridAddUrl = $this->AddMasterUrl($this->GridAddUrl);
			$this->GridEditUrl = $this->AddMasterUrl($this->GridEditUrl);

			// Save current master table
			$this->setCurrentMasterTable($sMasterTblVar);

			// Reset start record counter (new master key)
			$this->StartRec = 1;
			$this->setStartRecordNumber($this->StartRec);

			// Clear previous master key from Session
			if ($sMasterTblVar <> "atencion_equipos") {
				if ($this->Id_Atencion->CurrentValue == "") $this->Id_Atencion->setSessionValue("");
				if ($this->NroSerie->CurrentValue == "") $this->NroSerie->setSessionValue("");
			}
		}
		$this->DbMasterFilter = $this->GetMasterFilter(); // Get master filter
		$this->DbDetailFilter = $this->GetDetailFilter(); // Get detail filter
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
		case "x_Id_Tipo_Retiro":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_Tipo_Retiro` AS `LinkFld`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `tipo_retiro_atencion_st`";
			$sWhereWrk = "";
			$this->Id_Tipo_Retiro->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_Tipo_Retiro` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Id_Tipo_Retiro, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Descripcion` ASC";
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		}
	}

	// Setup AutoSuggest filters of a field
	function SetupAutoSuggestFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		}
	}

	// Write Audit Trail start/end for grid update
	function WriteAuditTrailDummy($typ) {
		$table = 'atencion_para_st';
		$usr = CurrentUserID();
		ew_WriteAuditTrail("log", ew_StdCurrentDateTime(), ew_ScriptName(), $usr, $typ, $table, "", "", "", "");
	}

	// Write Audit Trail (add page)
	function WriteAuditTrailOnAdd(&$rs) {
		global $Language;
		if (!$this->AuditTrailOnAdd) return;
		$table = 'atencion_para_st';

		// Get key value
		$key = "";
		if ($key <> "") $key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rs['Id_Atencion'];
		if ($key <> "") $key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rs['NroSerie'];

		// Write Audit Trail
		$dt = ew_StdCurrentDateTime();
		$id = ew_ScriptName();
		$usr = CurrentUserID();
		foreach (array_keys($rs) as $fldname) {
			if ($this->fields[$fldname]->FldDataType <> EW_DATATYPE_BLOB) { // Ignore BLOB fields
				if ($this->fields[$fldname]->FldHtmlTag == "PASSWORD") {
					$newvalue = $Language->Phrase("PasswordMask"); // Password Field
				} elseif ($this->fields[$fldname]->FldDataType == EW_DATATYPE_MEMO) {
					if (EW_AUDIT_TRAIL_TO_DATABASE)
						$newvalue = $rs[$fldname];
					else
						$newvalue = "[MEMO]"; // Memo Field
				} elseif ($this->fields[$fldname]->FldDataType == EW_DATATYPE_XML) {
					$newvalue = "[XML]"; // XML Field
				} else {
					$newvalue = $rs[$fldname];
				}
				ew_WriteAuditTrail("log", $dt, $id, $usr, "A", $table, $fldname, $key, "", $newvalue);
			}
		}
	}

	// Write Audit Trail (edit page)
	function WriteAuditTrailOnEdit(&$rsold, &$rsnew) {
		global $Language;
		if (!$this->AuditTrailOnEdit) return;
		$table = 'atencion_para_st';

		// Get key value
		$key = "";
		if ($key <> "") $key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rsold['Id_Atencion'];
		if ($key <> "") $key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rsold['NroSerie'];

		// Write Audit Trail
		$dt = ew_StdCurrentDateTime();
		$id = ew_ScriptName();
		$usr = CurrentUserID();
		foreach (array_keys($rsnew) as $fldname) {
			if ($this->fields[$fldname]->FldDataType <> EW_DATATYPE_BLOB) { // Ignore BLOB fields
				if ($this->fields[$fldname]->FldDataType == EW_DATATYPE_DATE) { // DateTime field
					$modified = (ew_FormatDateTime($rsold[$fldname], 0) <> ew_FormatDateTime($rsnew[$fldname], 0));
				} else {
					$modified = !ew_CompareValue($rsold[$fldname], $rsnew[$fldname]);
				}
				if ($modified) {
					if ($this->fields[$fldname]->FldHtmlTag == "PASSWORD") { // Password Field
						$oldvalue = $Language->Phrase("PasswordMask");
						$newvalue = $Language->Phrase("PasswordMask");
					} elseif ($this->fields[$fldname]->FldDataType == EW_DATATYPE_MEMO) { // Memo field
						if (EW_AUDIT_TRAIL_TO_DATABASE) {
							$oldvalue = $rsold[$fldname];
							$newvalue = $rsnew[$fldname];
						} else {
							$oldvalue = "[MEMO]";
							$newvalue = "[MEMO]";
						}
					} elseif ($this->fields[$fldname]->FldDataType == EW_DATATYPE_XML) { // XML field
						$oldvalue = "[XML]";
						$newvalue = "[XML]";
					} else {
						$oldvalue = $rsold[$fldname];
						$newvalue = $rsnew[$fldname];
					}
					ew_WriteAuditTrail("log", $dt, $id, $usr, "U", $table, $fldname, $key, $oldvalue, $newvalue);
				}
			}
		}
	}

	// Write Audit Trail (delete page)
	function WriteAuditTrailOnDelete(&$rs) {
		global $Language;
		if (!$this->AuditTrailOnDelete) return;
		$table = 'atencion_para_st';

		// Get key value
		$key = "";
		if ($key <> "")
			$key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rs['Id_Atencion'];
		if ($key <> "")
			$key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rs['NroSerie'];

		// Write Audit Trail
		$dt = ew_StdCurrentDateTime();
		$id = ew_ScriptName();
		$curUser = CurrentUserID();
		foreach (array_keys($rs) as $fldname) {
			if (array_key_exists($fldname, $this->fields) && $this->fields[$fldname]->FldDataType <> EW_DATATYPE_BLOB) { // Ignore BLOB fields
				if ($this->fields[$fldname]->FldHtmlTag == "PASSWORD") {
					$oldvalue = $Language->Phrase("PasswordMask"); // Password Field
				} elseif ($this->fields[$fldname]->FldDataType == EW_DATATYPE_MEMO) {
					if (EW_AUDIT_TRAIL_TO_DATABASE)
						$oldvalue = $rs[$fldname];
					else
						$oldvalue = "[MEMO]"; // Memo field
				} elseif ($this->fields[$fldname]->FldDataType == EW_DATATYPE_XML) {
					$oldvalue = "[XML]"; // XML field
				} else {
					$oldvalue = $rs[$fldname];
				}
				ew_WriteAuditTrail("log", $dt, $id, $curUser, "D", $table, $fldname, $key, $oldvalue, "");
			}
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
if (!isset($atencion_para_st_list)) $atencion_para_st_list = new catencion_para_st_list();

// Page init
$atencion_para_st_list->Page_Init();

// Page main
$atencion_para_st_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$atencion_para_st_list->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if ($atencion_para_st->Export == "") { ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "list";
var CurrentForm = fatencion_para_stlist = new ew_Form("fatencion_para_stlist", "list");
fatencion_para_stlist.FormKeyCountName = '<?php echo $atencion_para_st_list->FormKeyCountName ?>';

// Validate form
fatencion_para_stlist.Validate = function() {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	var $ = jQuery, fobj = this.GetForm(), $fobj = $(fobj);
	if ($fobj.find("#a_confirm").val() == "F")
		return true;
	var elm, felm, uelm, addcnt = 0;
	var $k = $fobj.find("#" + this.FormKeyCountName); // Get key_count
	var rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1;
	var startcnt = (rowcnt == 0) ? 0 : 1; // Check rowcnt == 0 => Inline-Add
	var gridinsert = $fobj.find("#a_list").val() == "gridinsert";
	for (var i = startcnt; i <= rowcnt; i++) {
		var infix = ($k[0]) ? String(i) : "";
		$fobj.data("rowindex", infix);
		var checkrow = (gridinsert) ? !this.EmptyRow(infix) : true;
		if (checkrow) {
			addcnt++;
			elm = this.GetElements("x" + infix + "_NroSerie");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $atencion_para_st->NroSerie->FldCaption(), $atencion_para_st->NroSerie->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Nro_Tiket");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $atencion_para_st->Nro_Tiket->FldCaption(), $atencion_para_st->Nro_Tiket->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Id_Tipo_Retiro");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $atencion_para_st->Id_Tipo_Retiro->FldCaption(), $atencion_para_st->Id_Tipo_Retiro->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Fecha_Retiro");
			if (elm && !ew_CheckEuroDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($atencion_para_st->Fecha_Retiro->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Fecha_Devolucion");
			if (elm && !ew_CheckEuroDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($atencion_para_st->Fecha_Devolucion->FldErrMsg()) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
		} // End Grid Add checking
	}
	if (gridinsert && addcnt == 0) { // No row added
		ew_Alert(ewLanguage.Phrase("NoAddRecord"));
		return false;
	}
	return true;
}

// Check empty row
fatencion_para_stlist.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "Id_Atencion", false)) return false;
	if (ew_ValueChanged(fobj, infix, "NroSerie", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Nro_Tiket", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Id_Tipo_Retiro", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Referencia_Tipo_Retiro", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Fecha_Retiro", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Observacion", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Fecha_Devolucion", false)) return false;
	return true;
}

// Form_CustomValidate event
fatencion_para_stlist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fatencion_para_stlist.ValidateRequired = true;
<?php } else { ?>
fatencion_para_stlist.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fatencion_para_stlist.Lists["x_Id_Tipo_Retiro"] = {"LinkField":"x_Id_Tipo_Retiro","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"tipo_retiro_atencion_st"};

// Form object for search
var CurrentSearchForm = fatencion_para_stlistsrch = new ew_Form("fatencion_para_stlistsrch");
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if ($atencion_para_st->Export == "") { ?>
<div class="ewToolbar">
<?php if ($atencion_para_st->Export == "") { ?>
<?php $Breadcrumb->Render(); ?>
<?php } ?>
<?php if ($atencion_para_st_list->TotalRecs > 0 && $atencion_para_st_list->ExportOptions->Visible()) { ?>
<?php $atencion_para_st_list->ExportOptions->Render("body") ?>
<?php } ?>
<?php if ($atencion_para_st_list->SearchOptions->Visible()) { ?>
<?php $atencion_para_st_list->SearchOptions->Render("body") ?>
<?php } ?>
<?php if ($atencion_para_st_list->FilterOptions->Visible()) { ?>
<?php $atencion_para_st_list->FilterOptions->Render("body") ?>
<?php } ?>
<?php if ($atencion_para_st->Export == "") { ?>
<?php echo $Language->SelectionForm(); ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php if (($atencion_para_st->Export == "") || (EW_EXPORT_MASTER_RECORD && $atencion_para_st->Export == "print")) { ?>
<?php
if ($atencion_para_st_list->DbMasterFilter <> "" && $atencion_para_st->getCurrentMasterTable() == "atencion_equipos") {
	if ($atencion_para_st_list->MasterRecordExists) {
?>
<?php include_once "atencion_equiposmaster.php" ?>
<?php
	}
}
?>
<?php } ?>
<?php
if ($atencion_para_st->CurrentAction == "gridadd") {
	$atencion_para_st->CurrentFilter = "0=1";
	$atencion_para_st_list->StartRec = 1;
	$atencion_para_st_list->DisplayRecs = $atencion_para_st->GridAddRowCount;
	$atencion_para_st_list->TotalRecs = $atencion_para_st_list->DisplayRecs;
	$atencion_para_st_list->StopRec = $atencion_para_st_list->DisplayRecs;
} else {
	$bSelectLimit = $atencion_para_st_list->UseSelectLimit;
	if ($bSelectLimit) {
		if ($atencion_para_st_list->TotalRecs <= 0)
			$atencion_para_st_list->TotalRecs = $atencion_para_st->SelectRecordCount();
	} else {
		if (!$atencion_para_st_list->Recordset && ($atencion_para_st_list->Recordset = $atencion_para_st_list->LoadRecordset()))
			$atencion_para_st_list->TotalRecs = $atencion_para_st_list->Recordset->RecordCount();
	}
	$atencion_para_st_list->StartRec = 1;
	if ($atencion_para_st_list->DisplayRecs <= 0 || ($atencion_para_st->Export <> "" && $atencion_para_st->ExportAll)) // Display all records
		$atencion_para_st_list->DisplayRecs = $atencion_para_st_list->TotalRecs;
	if (!($atencion_para_st->Export <> "" && $atencion_para_st->ExportAll))
		$atencion_para_st_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$atencion_para_st_list->Recordset = $atencion_para_st_list->LoadRecordset($atencion_para_st_list->StartRec-1, $atencion_para_st_list->DisplayRecs);

	// Set no record found message
	if ($atencion_para_st->CurrentAction == "" && $atencion_para_st_list->TotalRecs == 0) {
		if (!$Security->CanList())
			$atencion_para_st_list->setWarningMessage(ew_DeniedMsg());
		if ($atencion_para_st_list->SearchWhere == "0=101")
			$atencion_para_st_list->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$atencion_para_st_list->setWarningMessage($Language->Phrase("NoRecord"));
	}

	// Audit trail on search
	if ($atencion_para_st_list->AuditTrailOnSearch && $atencion_para_st_list->Command == "search" && !$atencion_para_st_list->RestoreSearch) {
		$searchparm = ew_ServerVar("QUERY_STRING");
		$searchsql = $atencion_para_st_list->getSessionWhere();
		$atencion_para_st_list->WriteAuditTrailOnSearch($searchparm, $searchsql);
	}
}
$atencion_para_st_list->RenderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if ($atencion_para_st->Export == "" && $atencion_para_st->CurrentAction == "") { ?>
<form name="fatencion_para_stlistsrch" id="fatencion_para_stlistsrch" class="form-inline ewForm" action="<?php echo ew_CurrentPage() ?>">
<?php $SearchPanelClass = ($atencion_para_st_list->SearchWhere <> "") ? " in" : " in"; ?>
<div id="fatencion_para_stlistsrch_SearchPanel" class="ewSearchPanel collapse<?php echo $SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="atencion_para_st">
	<div class="ewBasicSearch">
<div id="xsr_1" class="ewRow">
	<div class="ewQuickSearch input-group">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" class="form-control" value="<?php echo ew_HtmlEncode($atencion_para_st_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo ew_HtmlEncode($Language->Phrase("Search")) ?>">
	<input type="hidden" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="<?php echo ew_HtmlEncode($atencion_para_st_list->BasicSearch->getType()) ?>">
	<div class="input-group-btn">
		<button type="button" data-toggle="dropdown" class="btn btn-default"><span id="searchtype"><?php echo $atencion_para_st_list->BasicSearch->getTypeNameShort() ?></span><span class="caret"></span></button>
		<ul class="dropdown-menu pull-right" role="menu">
			<li<?php if ($atencion_para_st_list->BasicSearch->getType() == "") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this)"><?php echo $Language->Phrase("QuickSearchAuto") ?></a></li>
			<li<?php if ($atencion_para_st_list->BasicSearch->getType() == "=") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'=')"><?php echo $Language->Phrase("QuickSearchExact") ?></a></li>
			<li<?php if ($atencion_para_st_list->BasicSearch->getType() == "AND") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'AND')"><?php echo $Language->Phrase("QuickSearchAll") ?></a></li>
			<li<?php if ($atencion_para_st_list->BasicSearch->getType() == "OR") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'OR')"><?php echo $Language->Phrase("QuickSearchAny") ?></a></li>
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
<?php $atencion_para_st_list->ShowPageHeader(); ?>
<?php
$atencion_para_st_list->ShowMessage();
?>
<?php if ($atencion_para_st_list->TotalRecs > 0 || $atencion_para_st->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid atencion_para_st">
<?php if ($atencion_para_st->Export == "") { ?>
<div class="panel-heading ewGridUpperPanel">
<?php if ($atencion_para_st->CurrentAction <> "gridadd" && $atencion_para_st->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="form-inline ewForm ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($atencion_para_st_list->Pager)) $atencion_para_st_list->Pager = new cPrevNextPager($atencion_para_st_list->StartRec, $atencion_para_st_list->DisplayRecs, $atencion_para_st_list->TotalRecs) ?>
<?php if ($atencion_para_st_list->Pager->RecordCount > 0 && $atencion_para_st_list->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($atencion_para_st_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $atencion_para_st_list->PageUrl() ?>start=<?php echo $atencion_para_st_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($atencion_para_st_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $atencion_para_st_list->PageUrl() ?>start=<?php echo $atencion_para_st_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $atencion_para_st_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($atencion_para_st_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $atencion_para_st_list->PageUrl() ?>start=<?php echo $atencion_para_st_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($atencion_para_st_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $atencion_para_st_list->PageUrl() ?>start=<?php echo $atencion_para_st_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $atencion_para_st_list->Pager->PageCount ?></span>
</div>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $atencion_para_st_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $atencion_para_st_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $atencion_para_st_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($atencion_para_st_list->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
<form name="fatencion_para_stlist" id="fatencion_para_stlist" class="form-inline ewForm ewListForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($atencion_para_st_list->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $atencion_para_st_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="atencion_para_st">
<?php if ($atencion_para_st->getCurrentMasterTable() == "atencion_equipos" && $atencion_para_st->CurrentAction <> "") { ?>
<input type="hidden" name="<?php echo EW_TABLE_SHOW_MASTER ?>" value="atencion_equipos">
<input type="hidden" name="fk_Id_Atencion" value="<?php echo $atencion_para_st->Id_Atencion->getSessionValue() ?>">
<input type="hidden" name="fk_NroSerie" value="<?php echo $atencion_para_st->NroSerie->getSessionValue() ?>">
<?php } ?>
<div id="gmp_atencion_para_st" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<?php if ($atencion_para_st_list->TotalRecs > 0 || $atencion_para_st->CurrentAction == "add" || $atencion_para_st->CurrentAction == "copy") { ?>
<table id="tbl_atencion_para_stlist" class="table ewTable">
<?php echo $atencion_para_st->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$atencion_para_st_list->RowType = EW_ROWTYPE_HEADER;

// Render list options
$atencion_para_st_list->RenderListOptions();

// Render list options (header, left)
$atencion_para_st_list->ListOptions->Render("header", "left");
?>
<?php if ($atencion_para_st->Id_Atencion->Visible) { // Id_Atencion ?>
	<?php if ($atencion_para_st->SortUrl($atencion_para_st->Id_Atencion) == "") { ?>
		<th data-name="Id_Atencion"><div id="elh_atencion_para_st_Id_Atencion" class="atencion_para_st_Id_Atencion"><div class="ewTableHeaderCaption"><?php echo $atencion_para_st->Id_Atencion->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Id_Atencion"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $atencion_para_st->SortUrl($atencion_para_st->Id_Atencion) ?>',1);"><div id="elh_atencion_para_st_Id_Atencion" class="atencion_para_st_Id_Atencion">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $atencion_para_st->Id_Atencion->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($atencion_para_st->Id_Atencion->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($atencion_para_st->Id_Atencion->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($atencion_para_st->NroSerie->Visible) { // NroSerie ?>
	<?php if ($atencion_para_st->SortUrl($atencion_para_st->NroSerie) == "") { ?>
		<th data-name="NroSerie"><div id="elh_atencion_para_st_NroSerie" class="atencion_para_st_NroSerie"><div class="ewTableHeaderCaption"><?php echo $atencion_para_st->NroSerie->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="NroSerie"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $atencion_para_st->SortUrl($atencion_para_st->NroSerie) ?>',1);"><div id="elh_atencion_para_st_NroSerie" class="atencion_para_st_NroSerie">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $atencion_para_st->NroSerie->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($atencion_para_st->NroSerie->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($atencion_para_st->NroSerie->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($atencion_para_st->Nro_Tiket->Visible) { // Nro_Tiket ?>
	<?php if ($atencion_para_st->SortUrl($atencion_para_st->Nro_Tiket) == "") { ?>
		<th data-name="Nro_Tiket"><div id="elh_atencion_para_st_Nro_Tiket" class="atencion_para_st_Nro_Tiket"><div class="ewTableHeaderCaption"><?php echo $atencion_para_st->Nro_Tiket->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Nro_Tiket"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $atencion_para_st->SortUrl($atencion_para_st->Nro_Tiket) ?>',1);"><div id="elh_atencion_para_st_Nro_Tiket" class="atencion_para_st_Nro_Tiket">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $atencion_para_st->Nro_Tiket->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($atencion_para_st->Nro_Tiket->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($atencion_para_st->Nro_Tiket->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($atencion_para_st->Id_Tipo_Retiro->Visible) { // Id_Tipo_Retiro ?>
	<?php if ($atencion_para_st->SortUrl($atencion_para_st->Id_Tipo_Retiro) == "") { ?>
		<th data-name="Id_Tipo_Retiro"><div id="elh_atencion_para_st_Id_Tipo_Retiro" class="atencion_para_st_Id_Tipo_Retiro"><div class="ewTableHeaderCaption"><?php echo $atencion_para_st->Id_Tipo_Retiro->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Id_Tipo_Retiro"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $atencion_para_st->SortUrl($atencion_para_st->Id_Tipo_Retiro) ?>',1);"><div id="elh_atencion_para_st_Id_Tipo_Retiro" class="atencion_para_st_Id_Tipo_Retiro">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $atencion_para_st->Id_Tipo_Retiro->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($atencion_para_st->Id_Tipo_Retiro->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($atencion_para_st->Id_Tipo_Retiro->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($atencion_para_st->Referencia_Tipo_Retiro->Visible) { // Referencia_Tipo_Retiro ?>
	<?php if ($atencion_para_st->SortUrl($atencion_para_st->Referencia_Tipo_Retiro) == "") { ?>
		<th data-name="Referencia_Tipo_Retiro"><div id="elh_atencion_para_st_Referencia_Tipo_Retiro" class="atencion_para_st_Referencia_Tipo_Retiro"><div class="ewTableHeaderCaption"><?php echo $atencion_para_st->Referencia_Tipo_Retiro->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Referencia_Tipo_Retiro"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $atencion_para_st->SortUrl($atencion_para_st->Referencia_Tipo_Retiro) ?>',1);"><div id="elh_atencion_para_st_Referencia_Tipo_Retiro" class="atencion_para_st_Referencia_Tipo_Retiro">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $atencion_para_st->Referencia_Tipo_Retiro->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($atencion_para_st->Referencia_Tipo_Retiro->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($atencion_para_st->Referencia_Tipo_Retiro->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($atencion_para_st->Fecha_Retiro->Visible) { // Fecha_Retiro ?>
	<?php if ($atencion_para_st->SortUrl($atencion_para_st->Fecha_Retiro) == "") { ?>
		<th data-name="Fecha_Retiro"><div id="elh_atencion_para_st_Fecha_Retiro" class="atencion_para_st_Fecha_Retiro"><div class="ewTableHeaderCaption"><?php echo $atencion_para_st->Fecha_Retiro->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Fecha_Retiro"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $atencion_para_st->SortUrl($atencion_para_st->Fecha_Retiro) ?>',1);"><div id="elh_atencion_para_st_Fecha_Retiro" class="atencion_para_st_Fecha_Retiro">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $atencion_para_st->Fecha_Retiro->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($atencion_para_st->Fecha_Retiro->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($atencion_para_st->Fecha_Retiro->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($atencion_para_st->Observacion->Visible) { // Observacion ?>
	<?php if ($atencion_para_st->SortUrl($atencion_para_st->Observacion) == "") { ?>
		<th data-name="Observacion"><div id="elh_atencion_para_st_Observacion" class="atencion_para_st_Observacion"><div class="ewTableHeaderCaption"><?php echo $atencion_para_st->Observacion->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Observacion"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $atencion_para_st->SortUrl($atencion_para_st->Observacion) ?>',1);"><div id="elh_atencion_para_st_Observacion" class="atencion_para_st_Observacion">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $atencion_para_st->Observacion->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($atencion_para_st->Observacion->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($atencion_para_st->Observacion->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($atencion_para_st->Fecha_Devolucion->Visible) { // Fecha_Devolucion ?>
	<?php if ($atencion_para_st->SortUrl($atencion_para_st->Fecha_Devolucion) == "") { ?>
		<th data-name="Fecha_Devolucion"><div id="elh_atencion_para_st_Fecha_Devolucion" class="atencion_para_st_Fecha_Devolucion"><div class="ewTableHeaderCaption"><?php echo $atencion_para_st->Fecha_Devolucion->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Fecha_Devolucion"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $atencion_para_st->SortUrl($atencion_para_st->Fecha_Devolucion) ?>',1);"><div id="elh_atencion_para_st_Fecha_Devolucion" class="atencion_para_st_Fecha_Devolucion">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $atencion_para_st->Fecha_Devolucion->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($atencion_para_st->Fecha_Devolucion->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($atencion_para_st->Fecha_Devolucion->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$atencion_para_st_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
	if ($atencion_para_st->CurrentAction == "add" || $atencion_para_st->CurrentAction == "copy") {
		$atencion_para_st_list->RowIndex = 0;
		$atencion_para_st_list->KeyCount = $atencion_para_st_list->RowIndex;
		if ($atencion_para_st->CurrentAction == "add")
			$atencion_para_st_list->LoadDefaultValues();
		if ($atencion_para_st->EventCancelled) // Insert failed
			$atencion_para_st_list->RestoreFormValues(); // Restore form values

		// Set row properties
		$atencion_para_st->ResetAttrs();
		$atencion_para_st->RowAttrs = array_merge($atencion_para_st->RowAttrs, array('data-rowindex'=>0, 'id'=>'r0_atencion_para_st', 'data-rowtype'=>EW_ROWTYPE_ADD));
		$atencion_para_st->RowType = EW_ROWTYPE_ADD;

		// Render row
		$atencion_para_st_list->RenderRow();

		// Render list options
		$atencion_para_st_list->RenderListOptions();
		$atencion_para_st_list->StartRowCnt = 0;
?>
	<tr<?php echo $atencion_para_st->RowAttributes() ?>>
<?php

// Render list options (body, left)
$atencion_para_st_list->ListOptions->Render("body", "left", $atencion_para_st_list->RowCnt);
?>
	<?php if ($atencion_para_st->Id_Atencion->Visible) { // Id_Atencion ?>
		<td data-name="Id_Atencion">
<?php if ($atencion_para_st->Id_Atencion->getSessionValue() <> "") { ?>
<input type="hidden" id="x<?php echo $atencion_para_st_list->RowIndex ?>_Id_Atencion" name="x<?php echo $atencion_para_st_list->RowIndex ?>_Id_Atencion" value="<?php echo ew_HtmlEncode($atencion_para_st->Id_Atencion->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $atencion_para_st_list->RowCnt ?>_atencion_para_st_Id_Atencion" class="form-group atencion_para_st_Id_Atencion">
<input type="hidden" data-table="atencion_para_st" data-field="x_Id_Atencion" name="x<?php echo $atencion_para_st_list->RowIndex ?>_Id_Atencion" id="x<?php echo $atencion_para_st_list->RowIndex ?>_Id_Atencion" value="<?php echo ew_HtmlEncode($atencion_para_st->Id_Atencion->CurrentValue) ?>">
</span>
<?php } ?>
<input type="hidden" data-table="atencion_para_st" data-field="x_Id_Atencion" name="o<?php echo $atencion_para_st_list->RowIndex ?>_Id_Atencion" id="o<?php echo $atencion_para_st_list->RowIndex ?>_Id_Atencion" value="<?php echo ew_HtmlEncode($atencion_para_st->Id_Atencion->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($atencion_para_st->NroSerie->Visible) { // NroSerie ?>
		<td data-name="NroSerie">
<?php if ($atencion_para_st->NroSerie->getSessionValue() <> "") { ?>
<span id="el<?php echo $atencion_para_st_list->RowCnt ?>_atencion_para_st_NroSerie" class="form-group atencion_para_st_NroSerie">
<span<?php echo $atencion_para_st->NroSerie->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $atencion_para_st->NroSerie->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $atencion_para_st_list->RowIndex ?>_NroSerie" name="x<?php echo $atencion_para_st_list->RowIndex ?>_NroSerie" value="<?php echo ew_HtmlEncode($atencion_para_st->NroSerie->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $atencion_para_st_list->RowCnt ?>_atencion_para_st_NroSerie" class="form-group atencion_para_st_NroSerie">
<input type="text" data-table="atencion_para_st" data-field="x_NroSerie" name="x<?php echo $atencion_para_st_list->RowIndex ?>_NroSerie" id="x<?php echo $atencion_para_st_list->RowIndex ?>_NroSerie" size="30" maxlength="30" placeholder="<?php echo ew_HtmlEncode($atencion_para_st->NroSerie->getPlaceHolder()) ?>" value="<?php echo $atencion_para_st->NroSerie->EditValue ?>"<?php echo $atencion_para_st->NroSerie->EditAttributes() ?>>
</span>
<?php } ?>
<input type="hidden" data-table="atencion_para_st" data-field="x_NroSerie" name="o<?php echo $atencion_para_st_list->RowIndex ?>_NroSerie" id="o<?php echo $atencion_para_st_list->RowIndex ?>_NroSerie" value="<?php echo ew_HtmlEncode($atencion_para_st->NroSerie->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($atencion_para_st->Nro_Tiket->Visible) { // Nro_Tiket ?>
		<td data-name="Nro_Tiket">
<span id="el<?php echo $atencion_para_st_list->RowCnt ?>_atencion_para_st_Nro_Tiket" class="form-group atencion_para_st_Nro_Tiket">
<input type="text" data-table="atencion_para_st" data-field="x_Nro_Tiket" name="x<?php echo $atencion_para_st_list->RowIndex ?>_Nro_Tiket" id="x<?php echo $atencion_para_st_list->RowIndex ?>_Nro_Tiket" size="10" maxlength="100" placeholder="<?php echo ew_HtmlEncode($atencion_para_st->Nro_Tiket->getPlaceHolder()) ?>" value="<?php echo $atencion_para_st->Nro_Tiket->EditValue ?>"<?php echo $atencion_para_st->Nro_Tiket->EditAttributes() ?>>
</span>
<input type="hidden" data-table="atencion_para_st" data-field="x_Nro_Tiket" name="o<?php echo $atencion_para_st_list->RowIndex ?>_Nro_Tiket" id="o<?php echo $atencion_para_st_list->RowIndex ?>_Nro_Tiket" value="<?php echo ew_HtmlEncode($atencion_para_st->Nro_Tiket->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($atencion_para_st->Id_Tipo_Retiro->Visible) { // Id_Tipo_Retiro ?>
		<td data-name="Id_Tipo_Retiro">
<span id="el<?php echo $atencion_para_st_list->RowCnt ?>_atencion_para_st_Id_Tipo_Retiro" class="form-group atencion_para_st_Id_Tipo_Retiro">
<select data-table="atencion_para_st" data-field="x_Id_Tipo_Retiro" data-value-separator="<?php echo $atencion_para_st->Id_Tipo_Retiro->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $atencion_para_st_list->RowIndex ?>_Id_Tipo_Retiro" name="x<?php echo $atencion_para_st_list->RowIndex ?>_Id_Tipo_Retiro"<?php echo $atencion_para_st->Id_Tipo_Retiro->EditAttributes() ?>>
<?php echo $atencion_para_st->Id_Tipo_Retiro->SelectOptionListHtml("x<?php echo $atencion_para_st_list->RowIndex ?>_Id_Tipo_Retiro") ?>
</select>
<input type="hidden" name="s_x<?php echo $atencion_para_st_list->RowIndex ?>_Id_Tipo_Retiro" id="s_x<?php echo $atencion_para_st_list->RowIndex ?>_Id_Tipo_Retiro" value="<?php echo $atencion_para_st->Id_Tipo_Retiro->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="atencion_para_st" data-field="x_Id_Tipo_Retiro" name="o<?php echo $atencion_para_st_list->RowIndex ?>_Id_Tipo_Retiro" id="o<?php echo $atencion_para_st_list->RowIndex ?>_Id_Tipo_Retiro" value="<?php echo ew_HtmlEncode($atencion_para_st->Id_Tipo_Retiro->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($atencion_para_st->Referencia_Tipo_Retiro->Visible) { // Referencia_Tipo_Retiro ?>
		<td data-name="Referencia_Tipo_Retiro">
<span id="el<?php echo $atencion_para_st_list->RowCnt ?>_atencion_para_st_Referencia_Tipo_Retiro" class="form-group atencion_para_st_Referencia_Tipo_Retiro">
<input type="text" data-table="atencion_para_st" data-field="x_Referencia_Tipo_Retiro" name="x<?php echo $atencion_para_st_list->RowIndex ?>_Referencia_Tipo_Retiro" id="x<?php echo $atencion_para_st_list->RowIndex ?>_Referencia_Tipo_Retiro" size="5" maxlength="50" placeholder="<?php echo ew_HtmlEncode($atencion_para_st->Referencia_Tipo_Retiro->getPlaceHolder()) ?>" value="<?php echo $atencion_para_st->Referencia_Tipo_Retiro->EditValue ?>"<?php echo $atencion_para_st->Referencia_Tipo_Retiro->EditAttributes() ?>>
</span>
<input type="hidden" data-table="atencion_para_st" data-field="x_Referencia_Tipo_Retiro" name="o<?php echo $atencion_para_st_list->RowIndex ?>_Referencia_Tipo_Retiro" id="o<?php echo $atencion_para_st_list->RowIndex ?>_Referencia_Tipo_Retiro" value="<?php echo ew_HtmlEncode($atencion_para_st->Referencia_Tipo_Retiro->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($atencion_para_st->Fecha_Retiro->Visible) { // Fecha_Retiro ?>
		<td data-name="Fecha_Retiro">
<span id="el<?php echo $atencion_para_st_list->RowCnt ?>_atencion_para_st_Fecha_Retiro" class="form-group atencion_para_st_Fecha_Retiro">
<input type="text" data-table="atencion_para_st" data-field="x_Fecha_Retiro" data-format="7" name="x<?php echo $atencion_para_st_list->RowIndex ?>_Fecha_Retiro" id="x<?php echo $atencion_para_st_list->RowIndex ?>_Fecha_Retiro" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($atencion_para_st->Fecha_Retiro->getPlaceHolder()) ?>" value="<?php echo $atencion_para_st->Fecha_Retiro->EditValue ?>"<?php echo $atencion_para_st->Fecha_Retiro->EditAttributes() ?>>
<?php if (!$atencion_para_st->Fecha_Retiro->ReadOnly && !$atencion_para_st->Fecha_Retiro->Disabled && !isset($atencion_para_st->Fecha_Retiro->EditAttrs["readonly"]) && !isset($atencion_para_st->Fecha_Retiro->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("fatencion_para_stlist", "x<?php echo $atencion_para_st_list->RowIndex ?>_Fecha_Retiro", 7);
</script>
<?php } ?>
</span>
<input type="hidden" data-table="atencion_para_st" data-field="x_Fecha_Retiro" name="o<?php echo $atencion_para_st_list->RowIndex ?>_Fecha_Retiro" id="o<?php echo $atencion_para_st_list->RowIndex ?>_Fecha_Retiro" value="<?php echo ew_HtmlEncode($atencion_para_st->Fecha_Retiro->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($atencion_para_st->Observacion->Visible) { // Observacion ?>
		<td data-name="Observacion">
<span id="el<?php echo $atencion_para_st_list->RowCnt ?>_atencion_para_st_Observacion" class="form-group atencion_para_st_Observacion">
<input type="text" data-table="atencion_para_st" data-field="x_Observacion" name="x<?php echo $atencion_para_st_list->RowIndex ?>_Observacion" id="x<?php echo $atencion_para_st_list->RowIndex ?>_Observacion" size="20" maxlength="400" placeholder="<?php echo ew_HtmlEncode($atencion_para_st->Observacion->getPlaceHolder()) ?>" value="<?php echo $atencion_para_st->Observacion->EditValue ?>"<?php echo $atencion_para_st->Observacion->EditAttributes() ?>>
</span>
<input type="hidden" data-table="atencion_para_st" data-field="x_Observacion" name="o<?php echo $atencion_para_st_list->RowIndex ?>_Observacion" id="o<?php echo $atencion_para_st_list->RowIndex ?>_Observacion" value="<?php echo ew_HtmlEncode($atencion_para_st->Observacion->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($atencion_para_st->Fecha_Devolucion->Visible) { // Fecha_Devolucion ?>
		<td data-name="Fecha_Devolucion">
<span id="el<?php echo $atencion_para_st_list->RowCnt ?>_atencion_para_st_Fecha_Devolucion" class="form-group atencion_para_st_Fecha_Devolucion">
<input type="text" data-table="atencion_para_st" data-field="x_Fecha_Devolucion" data-format="7" name="x<?php echo $atencion_para_st_list->RowIndex ?>_Fecha_Devolucion" id="x<?php echo $atencion_para_st_list->RowIndex ?>_Fecha_Devolucion" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($atencion_para_st->Fecha_Devolucion->getPlaceHolder()) ?>" value="<?php echo $atencion_para_st->Fecha_Devolucion->EditValue ?>"<?php echo $atencion_para_st->Fecha_Devolucion->EditAttributes() ?>>
<?php if (!$atencion_para_st->Fecha_Devolucion->ReadOnly && !$atencion_para_st->Fecha_Devolucion->Disabled && !isset($atencion_para_st->Fecha_Devolucion->EditAttrs["readonly"]) && !isset($atencion_para_st->Fecha_Devolucion->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("fatencion_para_stlist", "x<?php echo $atencion_para_st_list->RowIndex ?>_Fecha_Devolucion", 7);
</script>
<?php } ?>
</span>
<input type="hidden" data-table="atencion_para_st" data-field="x_Fecha_Devolucion" name="o<?php echo $atencion_para_st_list->RowIndex ?>_Fecha_Devolucion" id="o<?php echo $atencion_para_st_list->RowIndex ?>_Fecha_Devolucion" value="<?php echo ew_HtmlEncode($atencion_para_st->Fecha_Devolucion->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$atencion_para_st_list->ListOptions->Render("body", "right", $atencion_para_st_list->RowCnt);
?>
<script type="text/javascript">
fatencion_para_stlist.UpdateOpts(<?php echo $atencion_para_st_list->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
<?php
if ($atencion_para_st->ExportAll && $atencion_para_st->Export <> "") {
	$atencion_para_st_list->StopRec = $atencion_para_st_list->TotalRecs;
} else {

	// Set the last record to display
	if ($atencion_para_st_list->TotalRecs > $atencion_para_st_list->StartRec + $atencion_para_st_list->DisplayRecs - 1)
		$atencion_para_st_list->StopRec = $atencion_para_st_list->StartRec + $atencion_para_st_list->DisplayRecs - 1;
	else
		$atencion_para_st_list->StopRec = $atencion_para_st_list->TotalRecs;
}

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($atencion_para_st_list->FormKeyCountName) && ($atencion_para_st->CurrentAction == "gridadd" || $atencion_para_st->CurrentAction == "gridedit" || $atencion_para_st->CurrentAction == "F")) {
		$atencion_para_st_list->KeyCount = $objForm->GetValue($atencion_para_st_list->FormKeyCountName);
		$atencion_para_st_list->StopRec = $atencion_para_st_list->StartRec + $atencion_para_st_list->KeyCount - 1;
	}
}
$atencion_para_st_list->RecCnt = $atencion_para_st_list->StartRec - 1;
if ($atencion_para_st_list->Recordset && !$atencion_para_st_list->Recordset->EOF) {
	$atencion_para_st_list->Recordset->MoveFirst();
	$bSelectLimit = $atencion_para_st_list->UseSelectLimit;
	if (!$bSelectLimit && $atencion_para_st_list->StartRec > 1)
		$atencion_para_st_list->Recordset->Move($atencion_para_st_list->StartRec - 1);
} elseif (!$atencion_para_st->AllowAddDeleteRow && $atencion_para_st_list->StopRec == 0) {
	$atencion_para_st_list->StopRec = $atencion_para_st->GridAddRowCount;
}

// Initialize aggregate
$atencion_para_st->RowType = EW_ROWTYPE_AGGREGATEINIT;
$atencion_para_st->ResetAttrs();
$atencion_para_st_list->RenderRow();
$atencion_para_st_list->EditRowCnt = 0;
if ($atencion_para_st->CurrentAction == "edit")
	$atencion_para_st_list->RowIndex = 1;
if ($atencion_para_st->CurrentAction == "gridadd")
	$atencion_para_st_list->RowIndex = 0;
if ($atencion_para_st->CurrentAction == "gridedit")
	$atencion_para_st_list->RowIndex = 0;
while ($atencion_para_st_list->RecCnt < $atencion_para_st_list->StopRec) {
	$atencion_para_st_list->RecCnt++;
	if (intval($atencion_para_st_list->RecCnt) >= intval($atencion_para_st_list->StartRec)) {
		$atencion_para_st_list->RowCnt++;
		if ($atencion_para_st->CurrentAction == "gridadd" || $atencion_para_st->CurrentAction == "gridedit" || $atencion_para_st->CurrentAction == "F") {
			$atencion_para_st_list->RowIndex++;
			$objForm->Index = $atencion_para_st_list->RowIndex;
			if ($objForm->HasValue($atencion_para_st_list->FormActionName))
				$atencion_para_st_list->RowAction = strval($objForm->GetValue($atencion_para_st_list->FormActionName));
			elseif ($atencion_para_st->CurrentAction == "gridadd")
				$atencion_para_st_list->RowAction = "insert";
			else
				$atencion_para_st_list->RowAction = "";
		}

		// Set up key count
		$atencion_para_st_list->KeyCount = $atencion_para_st_list->RowIndex;

		// Init row class and style
		$atencion_para_st->ResetAttrs();
		$atencion_para_st->CssClass = "";
		if ($atencion_para_st->CurrentAction == "gridadd") {
			$atencion_para_st_list->LoadDefaultValues(); // Load default values
		} else {
			$atencion_para_st_list->LoadRowValues($atencion_para_st_list->Recordset); // Load row values
		}
		$atencion_para_st->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($atencion_para_st->CurrentAction == "gridadd") // Grid add
			$atencion_para_st->RowType = EW_ROWTYPE_ADD; // Render add
		if ($atencion_para_st->CurrentAction == "gridadd" && $atencion_para_st->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$atencion_para_st_list->RestoreCurrentRowFormValues($atencion_para_st_list->RowIndex); // Restore form values
		if ($atencion_para_st->CurrentAction == "edit") {
			if ($atencion_para_st_list->CheckInlineEditKey() && $atencion_para_st_list->EditRowCnt == 0) { // Inline edit
				$atencion_para_st->RowType = EW_ROWTYPE_EDIT; // Render edit
			}
		}
		if ($atencion_para_st->CurrentAction == "gridedit") { // Grid edit
			if ($atencion_para_st->EventCancelled) {
				$atencion_para_st_list->RestoreCurrentRowFormValues($atencion_para_st_list->RowIndex); // Restore form values
			}
			if ($atencion_para_st_list->RowAction == "insert")
				$atencion_para_st->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$atencion_para_st->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($atencion_para_st->CurrentAction == "edit" && $atencion_para_st->RowType == EW_ROWTYPE_EDIT && $atencion_para_st->EventCancelled) { // Update failed
			$objForm->Index = 1;
			$atencion_para_st_list->RestoreFormValues(); // Restore form values
		}
		if ($atencion_para_st->CurrentAction == "gridedit" && ($atencion_para_st->RowType == EW_ROWTYPE_EDIT || $atencion_para_st->RowType == EW_ROWTYPE_ADD) && $atencion_para_st->EventCancelled) // Update failed
			$atencion_para_st_list->RestoreCurrentRowFormValues($atencion_para_st_list->RowIndex); // Restore form values
		if ($atencion_para_st->RowType == EW_ROWTYPE_EDIT) // Edit row
			$atencion_para_st_list->EditRowCnt++;

		// Set up row id / data-rowindex
		$atencion_para_st->RowAttrs = array_merge($atencion_para_st->RowAttrs, array('data-rowindex'=>$atencion_para_st_list->RowCnt, 'id'=>'r' . $atencion_para_st_list->RowCnt . '_atencion_para_st', 'data-rowtype'=>$atencion_para_st->RowType));

		// Render row
		$atencion_para_st_list->RenderRow();

		// Render list options
		$atencion_para_st_list->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($atencion_para_st_list->RowAction <> "delete" && $atencion_para_st_list->RowAction <> "insertdelete" && !($atencion_para_st_list->RowAction == "insert" && $atencion_para_st->CurrentAction == "F" && $atencion_para_st_list->EmptyRow())) {
?>
	<tr<?php echo $atencion_para_st->RowAttributes() ?>>
<?php

// Render list options (body, left)
$atencion_para_st_list->ListOptions->Render("body", "left", $atencion_para_st_list->RowCnt);
?>
	<?php if ($atencion_para_st->Id_Atencion->Visible) { // Id_Atencion ?>
		<td data-name="Id_Atencion"<?php echo $atencion_para_st->Id_Atencion->CellAttributes() ?>>
<?php if ($atencion_para_st->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($atencion_para_st->Id_Atencion->getSessionValue() <> "") { ?>
<input type="hidden" id="x<?php echo $atencion_para_st_list->RowIndex ?>_Id_Atencion" name="x<?php echo $atencion_para_st_list->RowIndex ?>_Id_Atencion" value="<?php echo ew_HtmlEncode($atencion_para_st->Id_Atencion->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $atencion_para_st_list->RowCnt ?>_atencion_para_st_Id_Atencion" class="form-group atencion_para_st_Id_Atencion">
<input type="hidden" data-table="atencion_para_st" data-field="x_Id_Atencion" name="x<?php echo $atencion_para_st_list->RowIndex ?>_Id_Atencion" id="x<?php echo $atencion_para_st_list->RowIndex ?>_Id_Atencion" value="<?php echo ew_HtmlEncode($atencion_para_st->Id_Atencion->CurrentValue) ?>">
</span>
<?php } ?>
<input type="hidden" data-table="atencion_para_st" data-field="x_Id_Atencion" name="o<?php echo $atencion_para_st_list->RowIndex ?>_Id_Atencion" id="o<?php echo $atencion_para_st_list->RowIndex ?>_Id_Atencion" value="<?php echo ew_HtmlEncode($atencion_para_st->Id_Atencion->OldValue) ?>">
<?php } ?>
<?php if ($atencion_para_st->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php if ($atencion_para_st->Id_Atencion->getSessionValue() <> "") { ?>
<input type="hidden" id="x<?php echo $atencion_para_st_list->RowIndex ?>_Id_Atencion" name="x<?php echo $atencion_para_st_list->RowIndex ?>_Id_Atencion" value="<?php echo ew_HtmlEncode($atencion_para_st->Id_Atencion->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $atencion_para_st_list->RowCnt ?>_atencion_para_st_Id_Atencion" class="form-group atencion_para_st_Id_Atencion">
<input type="hidden" data-table="atencion_para_st" data-field="x_Id_Atencion" name="x<?php echo $atencion_para_st_list->RowIndex ?>_Id_Atencion" id="x<?php echo $atencion_para_st_list->RowIndex ?>_Id_Atencion" value="<?php echo ew_HtmlEncode($atencion_para_st->Id_Atencion->CurrentValue) ?>">
</span>
<?php } ?>
<?php } ?>
<?php if ($atencion_para_st->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $atencion_para_st_list->RowCnt ?>_atencion_para_st_Id_Atencion" class="atencion_para_st_Id_Atencion">
<span<?php echo $atencion_para_st->Id_Atencion->ViewAttributes() ?>>
<?php echo $atencion_para_st->Id_Atencion->ListViewValue() ?></span>
</span>
<?php } ?>
<a id="<?php echo $atencion_para_st_list->PageObjName . "_row_" . $atencion_para_st_list->RowCnt ?>"></a></td>
	<?php } ?>
	<?php if ($atencion_para_st->NroSerie->Visible) { // NroSerie ?>
		<td data-name="NroSerie"<?php echo $atencion_para_st->NroSerie->CellAttributes() ?>>
<?php if ($atencion_para_st->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<?php if ($atencion_para_st->NroSerie->getSessionValue() <> "") { ?>
<span id="el<?php echo $atencion_para_st_list->RowCnt ?>_atencion_para_st_NroSerie" class="form-group atencion_para_st_NroSerie">
<span<?php echo $atencion_para_st->NroSerie->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $atencion_para_st->NroSerie->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $atencion_para_st_list->RowIndex ?>_NroSerie" name="x<?php echo $atencion_para_st_list->RowIndex ?>_NroSerie" value="<?php echo ew_HtmlEncode($atencion_para_st->NroSerie->CurrentValue) ?>">
<?php } else { ?>
<span id="el<?php echo $atencion_para_st_list->RowCnt ?>_atencion_para_st_NroSerie" class="form-group atencion_para_st_NroSerie">
<input type="text" data-table="atencion_para_st" data-field="x_NroSerie" name="x<?php echo $atencion_para_st_list->RowIndex ?>_NroSerie" id="x<?php echo $atencion_para_st_list->RowIndex ?>_NroSerie" size="30" maxlength="30" placeholder="<?php echo ew_HtmlEncode($atencion_para_st->NroSerie->getPlaceHolder()) ?>" value="<?php echo $atencion_para_st->NroSerie->EditValue ?>"<?php echo $atencion_para_st->NroSerie->EditAttributes() ?>>
</span>
<?php } ?>
<input type="hidden" data-table="atencion_para_st" data-field="x_NroSerie" name="o<?php echo $atencion_para_st_list->RowIndex ?>_NroSerie" id="o<?php echo $atencion_para_st_list->RowIndex ?>_NroSerie" value="<?php echo ew_HtmlEncode($atencion_para_st->NroSerie->OldValue) ?>">
<?php } ?>
<?php if ($atencion_para_st->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $atencion_para_st_list->RowCnt ?>_atencion_para_st_NroSerie" class="form-group atencion_para_st_NroSerie">
<span<?php echo $atencion_para_st->NroSerie->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $atencion_para_st->NroSerie->EditValue ?></p></span>
</span>
<input type="hidden" data-table="atencion_para_st" data-field="x_NroSerie" name="x<?php echo $atencion_para_st_list->RowIndex ?>_NroSerie" id="x<?php echo $atencion_para_st_list->RowIndex ?>_NroSerie" value="<?php echo ew_HtmlEncode($atencion_para_st->NroSerie->CurrentValue) ?>">
<?php } ?>
<?php if ($atencion_para_st->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $atencion_para_st_list->RowCnt ?>_atencion_para_st_NroSerie" class="atencion_para_st_NroSerie">
<span<?php echo $atencion_para_st->NroSerie->ViewAttributes() ?>>
<?php echo $atencion_para_st->NroSerie->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($atencion_para_st->Nro_Tiket->Visible) { // Nro_Tiket ?>
		<td data-name="Nro_Tiket"<?php echo $atencion_para_st->Nro_Tiket->CellAttributes() ?>>
<?php if ($atencion_para_st->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $atencion_para_st_list->RowCnt ?>_atencion_para_st_Nro_Tiket" class="form-group atencion_para_st_Nro_Tiket">
<input type="text" data-table="atencion_para_st" data-field="x_Nro_Tiket" name="x<?php echo $atencion_para_st_list->RowIndex ?>_Nro_Tiket" id="x<?php echo $atencion_para_st_list->RowIndex ?>_Nro_Tiket" size="10" maxlength="100" placeholder="<?php echo ew_HtmlEncode($atencion_para_st->Nro_Tiket->getPlaceHolder()) ?>" value="<?php echo $atencion_para_st->Nro_Tiket->EditValue ?>"<?php echo $atencion_para_st->Nro_Tiket->EditAttributes() ?>>
</span>
<input type="hidden" data-table="atencion_para_st" data-field="x_Nro_Tiket" name="o<?php echo $atencion_para_st_list->RowIndex ?>_Nro_Tiket" id="o<?php echo $atencion_para_st_list->RowIndex ?>_Nro_Tiket" value="<?php echo ew_HtmlEncode($atencion_para_st->Nro_Tiket->OldValue) ?>">
<?php } ?>
<?php if ($atencion_para_st->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $atencion_para_st_list->RowCnt ?>_atencion_para_st_Nro_Tiket" class="form-group atencion_para_st_Nro_Tiket">
<input type="text" data-table="atencion_para_st" data-field="x_Nro_Tiket" name="x<?php echo $atencion_para_st_list->RowIndex ?>_Nro_Tiket" id="x<?php echo $atencion_para_st_list->RowIndex ?>_Nro_Tiket" size="10" maxlength="100" placeholder="<?php echo ew_HtmlEncode($atencion_para_st->Nro_Tiket->getPlaceHolder()) ?>" value="<?php echo $atencion_para_st->Nro_Tiket->EditValue ?>"<?php echo $atencion_para_st->Nro_Tiket->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($atencion_para_st->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $atencion_para_st_list->RowCnt ?>_atencion_para_st_Nro_Tiket" class="atencion_para_st_Nro_Tiket">
<span<?php echo $atencion_para_st->Nro_Tiket->ViewAttributes() ?>>
<?php echo $atencion_para_st->Nro_Tiket->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($atencion_para_st->Id_Tipo_Retiro->Visible) { // Id_Tipo_Retiro ?>
		<td data-name="Id_Tipo_Retiro"<?php echo $atencion_para_st->Id_Tipo_Retiro->CellAttributes() ?>>
<?php if ($atencion_para_st->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $atencion_para_st_list->RowCnt ?>_atencion_para_st_Id_Tipo_Retiro" class="form-group atencion_para_st_Id_Tipo_Retiro">
<select data-table="atencion_para_st" data-field="x_Id_Tipo_Retiro" data-value-separator="<?php echo $atencion_para_st->Id_Tipo_Retiro->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $atencion_para_st_list->RowIndex ?>_Id_Tipo_Retiro" name="x<?php echo $atencion_para_st_list->RowIndex ?>_Id_Tipo_Retiro"<?php echo $atencion_para_st->Id_Tipo_Retiro->EditAttributes() ?>>
<?php echo $atencion_para_st->Id_Tipo_Retiro->SelectOptionListHtml("x<?php echo $atencion_para_st_list->RowIndex ?>_Id_Tipo_Retiro") ?>
</select>
<input type="hidden" name="s_x<?php echo $atencion_para_st_list->RowIndex ?>_Id_Tipo_Retiro" id="s_x<?php echo $atencion_para_st_list->RowIndex ?>_Id_Tipo_Retiro" value="<?php echo $atencion_para_st->Id_Tipo_Retiro->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="atencion_para_st" data-field="x_Id_Tipo_Retiro" name="o<?php echo $atencion_para_st_list->RowIndex ?>_Id_Tipo_Retiro" id="o<?php echo $atencion_para_st_list->RowIndex ?>_Id_Tipo_Retiro" value="<?php echo ew_HtmlEncode($atencion_para_st->Id_Tipo_Retiro->OldValue) ?>">
<?php } ?>
<?php if ($atencion_para_st->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $atencion_para_st_list->RowCnt ?>_atencion_para_st_Id_Tipo_Retiro" class="form-group atencion_para_st_Id_Tipo_Retiro">
<select data-table="atencion_para_st" data-field="x_Id_Tipo_Retiro" data-value-separator="<?php echo $atencion_para_st->Id_Tipo_Retiro->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $atencion_para_st_list->RowIndex ?>_Id_Tipo_Retiro" name="x<?php echo $atencion_para_st_list->RowIndex ?>_Id_Tipo_Retiro"<?php echo $atencion_para_st->Id_Tipo_Retiro->EditAttributes() ?>>
<?php echo $atencion_para_st->Id_Tipo_Retiro->SelectOptionListHtml("x<?php echo $atencion_para_st_list->RowIndex ?>_Id_Tipo_Retiro") ?>
</select>
<input type="hidden" name="s_x<?php echo $atencion_para_st_list->RowIndex ?>_Id_Tipo_Retiro" id="s_x<?php echo $atencion_para_st_list->RowIndex ?>_Id_Tipo_Retiro" value="<?php echo $atencion_para_st->Id_Tipo_Retiro->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php if ($atencion_para_st->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $atencion_para_st_list->RowCnt ?>_atencion_para_st_Id_Tipo_Retiro" class="atencion_para_st_Id_Tipo_Retiro">
<span<?php echo $atencion_para_st->Id_Tipo_Retiro->ViewAttributes() ?>>
<?php echo $atencion_para_st->Id_Tipo_Retiro->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($atencion_para_st->Referencia_Tipo_Retiro->Visible) { // Referencia_Tipo_Retiro ?>
		<td data-name="Referencia_Tipo_Retiro"<?php echo $atencion_para_st->Referencia_Tipo_Retiro->CellAttributes() ?>>
<?php if ($atencion_para_st->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $atencion_para_st_list->RowCnt ?>_atencion_para_st_Referencia_Tipo_Retiro" class="form-group atencion_para_st_Referencia_Tipo_Retiro">
<input type="text" data-table="atencion_para_st" data-field="x_Referencia_Tipo_Retiro" name="x<?php echo $atencion_para_st_list->RowIndex ?>_Referencia_Tipo_Retiro" id="x<?php echo $atencion_para_st_list->RowIndex ?>_Referencia_Tipo_Retiro" size="5" maxlength="50" placeholder="<?php echo ew_HtmlEncode($atencion_para_st->Referencia_Tipo_Retiro->getPlaceHolder()) ?>" value="<?php echo $atencion_para_st->Referencia_Tipo_Retiro->EditValue ?>"<?php echo $atencion_para_st->Referencia_Tipo_Retiro->EditAttributes() ?>>
</span>
<input type="hidden" data-table="atencion_para_st" data-field="x_Referencia_Tipo_Retiro" name="o<?php echo $atencion_para_st_list->RowIndex ?>_Referencia_Tipo_Retiro" id="o<?php echo $atencion_para_st_list->RowIndex ?>_Referencia_Tipo_Retiro" value="<?php echo ew_HtmlEncode($atencion_para_st->Referencia_Tipo_Retiro->OldValue) ?>">
<?php } ?>
<?php if ($atencion_para_st->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $atencion_para_st_list->RowCnt ?>_atencion_para_st_Referencia_Tipo_Retiro" class="form-group atencion_para_st_Referencia_Tipo_Retiro">
<input type="text" data-table="atencion_para_st" data-field="x_Referencia_Tipo_Retiro" name="x<?php echo $atencion_para_st_list->RowIndex ?>_Referencia_Tipo_Retiro" id="x<?php echo $atencion_para_st_list->RowIndex ?>_Referencia_Tipo_Retiro" size="5" maxlength="50" placeholder="<?php echo ew_HtmlEncode($atencion_para_st->Referencia_Tipo_Retiro->getPlaceHolder()) ?>" value="<?php echo $atencion_para_st->Referencia_Tipo_Retiro->EditValue ?>"<?php echo $atencion_para_st->Referencia_Tipo_Retiro->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($atencion_para_st->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $atencion_para_st_list->RowCnt ?>_atencion_para_st_Referencia_Tipo_Retiro" class="atencion_para_st_Referencia_Tipo_Retiro">
<span<?php echo $atencion_para_st->Referencia_Tipo_Retiro->ViewAttributes() ?>>
<?php echo $atencion_para_st->Referencia_Tipo_Retiro->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($atencion_para_st->Fecha_Retiro->Visible) { // Fecha_Retiro ?>
		<td data-name="Fecha_Retiro"<?php echo $atencion_para_st->Fecha_Retiro->CellAttributes() ?>>
<?php if ($atencion_para_st->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $atencion_para_st_list->RowCnt ?>_atencion_para_st_Fecha_Retiro" class="form-group atencion_para_st_Fecha_Retiro">
<input type="text" data-table="atencion_para_st" data-field="x_Fecha_Retiro" data-format="7" name="x<?php echo $atencion_para_st_list->RowIndex ?>_Fecha_Retiro" id="x<?php echo $atencion_para_st_list->RowIndex ?>_Fecha_Retiro" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($atencion_para_st->Fecha_Retiro->getPlaceHolder()) ?>" value="<?php echo $atencion_para_st->Fecha_Retiro->EditValue ?>"<?php echo $atencion_para_st->Fecha_Retiro->EditAttributes() ?>>
<?php if (!$atencion_para_st->Fecha_Retiro->ReadOnly && !$atencion_para_st->Fecha_Retiro->Disabled && !isset($atencion_para_st->Fecha_Retiro->EditAttrs["readonly"]) && !isset($atencion_para_st->Fecha_Retiro->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("fatencion_para_stlist", "x<?php echo $atencion_para_st_list->RowIndex ?>_Fecha_Retiro", 7);
</script>
<?php } ?>
</span>
<input type="hidden" data-table="atencion_para_st" data-field="x_Fecha_Retiro" name="o<?php echo $atencion_para_st_list->RowIndex ?>_Fecha_Retiro" id="o<?php echo $atencion_para_st_list->RowIndex ?>_Fecha_Retiro" value="<?php echo ew_HtmlEncode($atencion_para_st->Fecha_Retiro->OldValue) ?>">
<?php } ?>
<?php if ($atencion_para_st->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $atencion_para_st_list->RowCnt ?>_atencion_para_st_Fecha_Retiro" class="form-group atencion_para_st_Fecha_Retiro">
<input type="text" data-table="atencion_para_st" data-field="x_Fecha_Retiro" data-format="7" name="x<?php echo $atencion_para_st_list->RowIndex ?>_Fecha_Retiro" id="x<?php echo $atencion_para_st_list->RowIndex ?>_Fecha_Retiro" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($atencion_para_st->Fecha_Retiro->getPlaceHolder()) ?>" value="<?php echo $atencion_para_st->Fecha_Retiro->EditValue ?>"<?php echo $atencion_para_st->Fecha_Retiro->EditAttributes() ?>>
<?php if (!$atencion_para_st->Fecha_Retiro->ReadOnly && !$atencion_para_st->Fecha_Retiro->Disabled && !isset($atencion_para_st->Fecha_Retiro->EditAttrs["readonly"]) && !isset($atencion_para_st->Fecha_Retiro->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("fatencion_para_stlist", "x<?php echo $atencion_para_st_list->RowIndex ?>_Fecha_Retiro", 7);
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($atencion_para_st->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $atencion_para_st_list->RowCnt ?>_atencion_para_st_Fecha_Retiro" class="atencion_para_st_Fecha_Retiro">
<span<?php echo $atencion_para_st->Fecha_Retiro->ViewAttributes() ?>>
<?php echo $atencion_para_st->Fecha_Retiro->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($atencion_para_st->Observacion->Visible) { // Observacion ?>
		<td data-name="Observacion"<?php echo $atencion_para_st->Observacion->CellAttributes() ?>>
<?php if ($atencion_para_st->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $atencion_para_st_list->RowCnt ?>_atencion_para_st_Observacion" class="form-group atencion_para_st_Observacion">
<input type="text" data-table="atencion_para_st" data-field="x_Observacion" name="x<?php echo $atencion_para_st_list->RowIndex ?>_Observacion" id="x<?php echo $atencion_para_st_list->RowIndex ?>_Observacion" size="20" maxlength="400" placeholder="<?php echo ew_HtmlEncode($atencion_para_st->Observacion->getPlaceHolder()) ?>" value="<?php echo $atencion_para_st->Observacion->EditValue ?>"<?php echo $atencion_para_st->Observacion->EditAttributes() ?>>
</span>
<input type="hidden" data-table="atencion_para_st" data-field="x_Observacion" name="o<?php echo $atencion_para_st_list->RowIndex ?>_Observacion" id="o<?php echo $atencion_para_st_list->RowIndex ?>_Observacion" value="<?php echo ew_HtmlEncode($atencion_para_st->Observacion->OldValue) ?>">
<?php } ?>
<?php if ($atencion_para_st->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $atencion_para_st_list->RowCnt ?>_atencion_para_st_Observacion" class="form-group atencion_para_st_Observacion">
<input type="text" data-table="atencion_para_st" data-field="x_Observacion" name="x<?php echo $atencion_para_st_list->RowIndex ?>_Observacion" id="x<?php echo $atencion_para_st_list->RowIndex ?>_Observacion" size="20" maxlength="400" placeholder="<?php echo ew_HtmlEncode($atencion_para_st->Observacion->getPlaceHolder()) ?>" value="<?php echo $atencion_para_st->Observacion->EditValue ?>"<?php echo $atencion_para_st->Observacion->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($atencion_para_st->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $atencion_para_st_list->RowCnt ?>_atencion_para_st_Observacion" class="atencion_para_st_Observacion">
<span<?php echo $atencion_para_st->Observacion->ViewAttributes() ?>>
<?php echo $atencion_para_st->Observacion->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($atencion_para_st->Fecha_Devolucion->Visible) { // Fecha_Devolucion ?>
		<td data-name="Fecha_Devolucion"<?php echo $atencion_para_st->Fecha_Devolucion->CellAttributes() ?>>
<?php if ($atencion_para_st->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $atencion_para_st_list->RowCnt ?>_atencion_para_st_Fecha_Devolucion" class="form-group atencion_para_st_Fecha_Devolucion">
<input type="text" data-table="atencion_para_st" data-field="x_Fecha_Devolucion" data-format="7" name="x<?php echo $atencion_para_st_list->RowIndex ?>_Fecha_Devolucion" id="x<?php echo $atencion_para_st_list->RowIndex ?>_Fecha_Devolucion" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($atencion_para_st->Fecha_Devolucion->getPlaceHolder()) ?>" value="<?php echo $atencion_para_st->Fecha_Devolucion->EditValue ?>"<?php echo $atencion_para_st->Fecha_Devolucion->EditAttributes() ?>>
<?php if (!$atencion_para_st->Fecha_Devolucion->ReadOnly && !$atencion_para_st->Fecha_Devolucion->Disabled && !isset($atencion_para_st->Fecha_Devolucion->EditAttrs["readonly"]) && !isset($atencion_para_st->Fecha_Devolucion->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("fatencion_para_stlist", "x<?php echo $atencion_para_st_list->RowIndex ?>_Fecha_Devolucion", 7);
</script>
<?php } ?>
</span>
<input type="hidden" data-table="atencion_para_st" data-field="x_Fecha_Devolucion" name="o<?php echo $atencion_para_st_list->RowIndex ?>_Fecha_Devolucion" id="o<?php echo $atencion_para_st_list->RowIndex ?>_Fecha_Devolucion" value="<?php echo ew_HtmlEncode($atencion_para_st->Fecha_Devolucion->OldValue) ?>">
<?php } ?>
<?php if ($atencion_para_st->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $atencion_para_st_list->RowCnt ?>_atencion_para_st_Fecha_Devolucion" class="form-group atencion_para_st_Fecha_Devolucion">
<input type="text" data-table="atencion_para_st" data-field="x_Fecha_Devolucion" data-format="7" name="x<?php echo $atencion_para_st_list->RowIndex ?>_Fecha_Devolucion" id="x<?php echo $atencion_para_st_list->RowIndex ?>_Fecha_Devolucion" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($atencion_para_st->Fecha_Devolucion->getPlaceHolder()) ?>" value="<?php echo $atencion_para_st->Fecha_Devolucion->EditValue ?>"<?php echo $atencion_para_st->Fecha_Devolucion->EditAttributes() ?>>
<?php if (!$atencion_para_st->Fecha_Devolucion->ReadOnly && !$atencion_para_st->Fecha_Devolucion->Disabled && !isset($atencion_para_st->Fecha_Devolucion->EditAttrs["readonly"]) && !isset($atencion_para_st->Fecha_Devolucion->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("fatencion_para_stlist", "x<?php echo $atencion_para_st_list->RowIndex ?>_Fecha_Devolucion", 7);
</script>
<?php } ?>
</span>
<?php } ?>
<?php if ($atencion_para_st->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $atencion_para_st_list->RowCnt ?>_atencion_para_st_Fecha_Devolucion" class="atencion_para_st_Fecha_Devolucion">
<span<?php echo $atencion_para_st->Fecha_Devolucion->ViewAttributes() ?>>
<?php echo $atencion_para_st->Fecha_Devolucion->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$atencion_para_st_list->ListOptions->Render("body", "right", $atencion_para_st_list->RowCnt);
?>
	</tr>
<?php if ($atencion_para_st->RowType == EW_ROWTYPE_ADD || $atencion_para_st->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fatencion_para_stlist.UpdateOpts(<?php echo $atencion_para_st_list->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($atencion_para_st->CurrentAction <> "gridadd")
		if (!$atencion_para_st_list->Recordset->EOF) $atencion_para_st_list->Recordset->MoveNext();
}
?>
<?php
	if ($atencion_para_st->CurrentAction == "gridadd" || $atencion_para_st->CurrentAction == "gridedit") {
		$atencion_para_st_list->RowIndex = '$rowindex$';
		$atencion_para_st_list->LoadDefaultValues();

		// Set row properties
		$atencion_para_st->ResetAttrs();
		$atencion_para_st->RowAttrs = array_merge($atencion_para_st->RowAttrs, array('data-rowindex'=>$atencion_para_st_list->RowIndex, 'id'=>'r0_atencion_para_st', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($atencion_para_st->RowAttrs["class"], "ewTemplate");
		$atencion_para_st->RowType = EW_ROWTYPE_ADD;

		// Render row
		$atencion_para_st_list->RenderRow();

		// Render list options
		$atencion_para_st_list->RenderListOptions();
		$atencion_para_st_list->StartRowCnt = 0;
?>
	<tr<?php echo $atencion_para_st->RowAttributes() ?>>
<?php

// Render list options (body, left)
$atencion_para_st_list->ListOptions->Render("body", "left", $atencion_para_st_list->RowIndex);
?>
	<?php if ($atencion_para_st->Id_Atencion->Visible) { // Id_Atencion ?>
		<td data-name="Id_Atencion">
<?php if ($atencion_para_st->Id_Atencion->getSessionValue() <> "") { ?>
<input type="hidden" id="x<?php echo $atencion_para_st_list->RowIndex ?>_Id_Atencion" name="x<?php echo $atencion_para_st_list->RowIndex ?>_Id_Atencion" value="<?php echo ew_HtmlEncode($atencion_para_st->Id_Atencion->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_atencion_para_st_Id_Atencion" class="form-group atencion_para_st_Id_Atencion">
<input type="hidden" data-table="atencion_para_st" data-field="x_Id_Atencion" name="x<?php echo $atencion_para_st_list->RowIndex ?>_Id_Atencion" id="x<?php echo $atencion_para_st_list->RowIndex ?>_Id_Atencion" value="<?php echo ew_HtmlEncode($atencion_para_st->Id_Atencion->CurrentValue) ?>">
</span>
<?php } ?>
<input type="hidden" data-table="atencion_para_st" data-field="x_Id_Atencion" name="o<?php echo $atencion_para_st_list->RowIndex ?>_Id_Atencion" id="o<?php echo $atencion_para_st_list->RowIndex ?>_Id_Atencion" value="<?php echo ew_HtmlEncode($atencion_para_st->Id_Atencion->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($atencion_para_st->NroSerie->Visible) { // NroSerie ?>
		<td data-name="NroSerie">
<?php if ($atencion_para_st->NroSerie->getSessionValue() <> "") { ?>
<span id="el$rowindex$_atencion_para_st_NroSerie" class="form-group atencion_para_st_NroSerie">
<span<?php echo $atencion_para_st->NroSerie->ViewAttributes() ?>>
<p class="form-control-static"><?php echo $atencion_para_st->NroSerie->ViewValue ?></p></span>
</span>
<input type="hidden" id="x<?php echo $atencion_para_st_list->RowIndex ?>_NroSerie" name="x<?php echo $atencion_para_st_list->RowIndex ?>_NroSerie" value="<?php echo ew_HtmlEncode($atencion_para_st->NroSerie->CurrentValue) ?>">
<?php } else { ?>
<span id="el$rowindex$_atencion_para_st_NroSerie" class="form-group atencion_para_st_NroSerie">
<input type="text" data-table="atencion_para_st" data-field="x_NroSerie" name="x<?php echo $atencion_para_st_list->RowIndex ?>_NroSerie" id="x<?php echo $atencion_para_st_list->RowIndex ?>_NroSerie" size="30" maxlength="30" placeholder="<?php echo ew_HtmlEncode($atencion_para_st->NroSerie->getPlaceHolder()) ?>" value="<?php echo $atencion_para_st->NroSerie->EditValue ?>"<?php echo $atencion_para_st->NroSerie->EditAttributes() ?>>
</span>
<?php } ?>
<input type="hidden" data-table="atencion_para_st" data-field="x_NroSerie" name="o<?php echo $atencion_para_st_list->RowIndex ?>_NroSerie" id="o<?php echo $atencion_para_st_list->RowIndex ?>_NroSerie" value="<?php echo ew_HtmlEncode($atencion_para_st->NroSerie->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($atencion_para_st->Nro_Tiket->Visible) { // Nro_Tiket ?>
		<td data-name="Nro_Tiket">
<span id="el$rowindex$_atencion_para_st_Nro_Tiket" class="form-group atencion_para_st_Nro_Tiket">
<input type="text" data-table="atencion_para_st" data-field="x_Nro_Tiket" name="x<?php echo $atencion_para_st_list->RowIndex ?>_Nro_Tiket" id="x<?php echo $atencion_para_st_list->RowIndex ?>_Nro_Tiket" size="10" maxlength="100" placeholder="<?php echo ew_HtmlEncode($atencion_para_st->Nro_Tiket->getPlaceHolder()) ?>" value="<?php echo $atencion_para_st->Nro_Tiket->EditValue ?>"<?php echo $atencion_para_st->Nro_Tiket->EditAttributes() ?>>
</span>
<input type="hidden" data-table="atencion_para_st" data-field="x_Nro_Tiket" name="o<?php echo $atencion_para_st_list->RowIndex ?>_Nro_Tiket" id="o<?php echo $atencion_para_st_list->RowIndex ?>_Nro_Tiket" value="<?php echo ew_HtmlEncode($atencion_para_st->Nro_Tiket->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($atencion_para_st->Id_Tipo_Retiro->Visible) { // Id_Tipo_Retiro ?>
		<td data-name="Id_Tipo_Retiro">
<span id="el$rowindex$_atencion_para_st_Id_Tipo_Retiro" class="form-group atencion_para_st_Id_Tipo_Retiro">
<select data-table="atencion_para_st" data-field="x_Id_Tipo_Retiro" data-value-separator="<?php echo $atencion_para_st->Id_Tipo_Retiro->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $atencion_para_st_list->RowIndex ?>_Id_Tipo_Retiro" name="x<?php echo $atencion_para_st_list->RowIndex ?>_Id_Tipo_Retiro"<?php echo $atencion_para_st->Id_Tipo_Retiro->EditAttributes() ?>>
<?php echo $atencion_para_st->Id_Tipo_Retiro->SelectOptionListHtml("x<?php echo $atencion_para_st_list->RowIndex ?>_Id_Tipo_Retiro") ?>
</select>
<input type="hidden" name="s_x<?php echo $atencion_para_st_list->RowIndex ?>_Id_Tipo_Retiro" id="s_x<?php echo $atencion_para_st_list->RowIndex ?>_Id_Tipo_Retiro" value="<?php echo $atencion_para_st->Id_Tipo_Retiro->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="atencion_para_st" data-field="x_Id_Tipo_Retiro" name="o<?php echo $atencion_para_st_list->RowIndex ?>_Id_Tipo_Retiro" id="o<?php echo $atencion_para_st_list->RowIndex ?>_Id_Tipo_Retiro" value="<?php echo ew_HtmlEncode($atencion_para_st->Id_Tipo_Retiro->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($atencion_para_st->Referencia_Tipo_Retiro->Visible) { // Referencia_Tipo_Retiro ?>
		<td data-name="Referencia_Tipo_Retiro">
<span id="el$rowindex$_atencion_para_st_Referencia_Tipo_Retiro" class="form-group atencion_para_st_Referencia_Tipo_Retiro">
<input type="text" data-table="atencion_para_st" data-field="x_Referencia_Tipo_Retiro" name="x<?php echo $atencion_para_st_list->RowIndex ?>_Referencia_Tipo_Retiro" id="x<?php echo $atencion_para_st_list->RowIndex ?>_Referencia_Tipo_Retiro" size="5" maxlength="50" placeholder="<?php echo ew_HtmlEncode($atencion_para_st->Referencia_Tipo_Retiro->getPlaceHolder()) ?>" value="<?php echo $atencion_para_st->Referencia_Tipo_Retiro->EditValue ?>"<?php echo $atencion_para_st->Referencia_Tipo_Retiro->EditAttributes() ?>>
</span>
<input type="hidden" data-table="atencion_para_st" data-field="x_Referencia_Tipo_Retiro" name="o<?php echo $atencion_para_st_list->RowIndex ?>_Referencia_Tipo_Retiro" id="o<?php echo $atencion_para_st_list->RowIndex ?>_Referencia_Tipo_Retiro" value="<?php echo ew_HtmlEncode($atencion_para_st->Referencia_Tipo_Retiro->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($atencion_para_st->Fecha_Retiro->Visible) { // Fecha_Retiro ?>
		<td data-name="Fecha_Retiro">
<span id="el$rowindex$_atencion_para_st_Fecha_Retiro" class="form-group atencion_para_st_Fecha_Retiro">
<input type="text" data-table="atencion_para_st" data-field="x_Fecha_Retiro" data-format="7" name="x<?php echo $atencion_para_st_list->RowIndex ?>_Fecha_Retiro" id="x<?php echo $atencion_para_st_list->RowIndex ?>_Fecha_Retiro" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($atencion_para_st->Fecha_Retiro->getPlaceHolder()) ?>" value="<?php echo $atencion_para_st->Fecha_Retiro->EditValue ?>"<?php echo $atencion_para_st->Fecha_Retiro->EditAttributes() ?>>
<?php if (!$atencion_para_st->Fecha_Retiro->ReadOnly && !$atencion_para_st->Fecha_Retiro->Disabled && !isset($atencion_para_st->Fecha_Retiro->EditAttrs["readonly"]) && !isset($atencion_para_st->Fecha_Retiro->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("fatencion_para_stlist", "x<?php echo $atencion_para_st_list->RowIndex ?>_Fecha_Retiro", 7);
</script>
<?php } ?>
</span>
<input type="hidden" data-table="atencion_para_st" data-field="x_Fecha_Retiro" name="o<?php echo $atencion_para_st_list->RowIndex ?>_Fecha_Retiro" id="o<?php echo $atencion_para_st_list->RowIndex ?>_Fecha_Retiro" value="<?php echo ew_HtmlEncode($atencion_para_st->Fecha_Retiro->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($atencion_para_st->Observacion->Visible) { // Observacion ?>
		<td data-name="Observacion">
<span id="el$rowindex$_atencion_para_st_Observacion" class="form-group atencion_para_st_Observacion">
<input type="text" data-table="atencion_para_st" data-field="x_Observacion" name="x<?php echo $atencion_para_st_list->RowIndex ?>_Observacion" id="x<?php echo $atencion_para_st_list->RowIndex ?>_Observacion" size="20" maxlength="400" placeholder="<?php echo ew_HtmlEncode($atencion_para_st->Observacion->getPlaceHolder()) ?>" value="<?php echo $atencion_para_st->Observacion->EditValue ?>"<?php echo $atencion_para_st->Observacion->EditAttributes() ?>>
</span>
<input type="hidden" data-table="atencion_para_st" data-field="x_Observacion" name="o<?php echo $atencion_para_st_list->RowIndex ?>_Observacion" id="o<?php echo $atencion_para_st_list->RowIndex ?>_Observacion" value="<?php echo ew_HtmlEncode($atencion_para_st->Observacion->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($atencion_para_st->Fecha_Devolucion->Visible) { // Fecha_Devolucion ?>
		<td data-name="Fecha_Devolucion">
<span id="el$rowindex$_atencion_para_st_Fecha_Devolucion" class="form-group atencion_para_st_Fecha_Devolucion">
<input type="text" data-table="atencion_para_st" data-field="x_Fecha_Devolucion" data-format="7" name="x<?php echo $atencion_para_st_list->RowIndex ?>_Fecha_Devolucion" id="x<?php echo $atencion_para_st_list->RowIndex ?>_Fecha_Devolucion" size="30" maxlength="100" placeholder="<?php echo ew_HtmlEncode($atencion_para_st->Fecha_Devolucion->getPlaceHolder()) ?>" value="<?php echo $atencion_para_st->Fecha_Devolucion->EditValue ?>"<?php echo $atencion_para_st->Fecha_Devolucion->EditAttributes() ?>>
<?php if (!$atencion_para_st->Fecha_Devolucion->ReadOnly && !$atencion_para_st->Fecha_Devolucion->Disabled && !isset($atencion_para_st->Fecha_Devolucion->EditAttrs["readonly"]) && !isset($atencion_para_st->Fecha_Devolucion->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("fatencion_para_stlist", "x<?php echo $atencion_para_st_list->RowIndex ?>_Fecha_Devolucion", 7);
</script>
<?php } ?>
</span>
<input type="hidden" data-table="atencion_para_st" data-field="x_Fecha_Devolucion" name="o<?php echo $atencion_para_st_list->RowIndex ?>_Fecha_Devolucion" id="o<?php echo $atencion_para_st_list->RowIndex ?>_Fecha_Devolucion" value="<?php echo ew_HtmlEncode($atencion_para_st->Fecha_Devolucion->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$atencion_para_st_list->ListOptions->Render("body", "right", $atencion_para_st_list->RowCnt);
?>
<script type="text/javascript">
fatencion_para_stlist.UpdateOpts(<?php echo $atencion_para_st_list->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($atencion_para_st->CurrentAction == "add" || $atencion_para_st->CurrentAction == "copy") { ?>
<input type="hidden" name="<?php echo $atencion_para_st_list->FormKeyCountName ?>" id="<?php echo $atencion_para_st_list->FormKeyCountName ?>" value="<?php echo $atencion_para_st_list->KeyCount ?>">
<?php } ?>
<?php if ($atencion_para_st->CurrentAction == "gridadd") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $atencion_para_st_list->FormKeyCountName ?>" id="<?php echo $atencion_para_st_list->FormKeyCountName ?>" value="<?php echo $atencion_para_st_list->KeyCount ?>">
<?php echo $atencion_para_st_list->MultiSelectKey ?>
<?php } ?>
<?php if ($atencion_para_st->CurrentAction == "edit") { ?>
<input type="hidden" name="<?php echo $atencion_para_st_list->FormKeyCountName ?>" id="<?php echo $atencion_para_st_list->FormKeyCountName ?>" value="<?php echo $atencion_para_st_list->KeyCount ?>">
<?php } ?>
<?php if ($atencion_para_st->CurrentAction == "gridedit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $atencion_para_st_list->FormKeyCountName ?>" id="<?php echo $atencion_para_st_list->FormKeyCountName ?>" value="<?php echo $atencion_para_st_list->KeyCount ?>">
<?php echo $atencion_para_st_list->MultiSelectKey ?>
<?php } ?>
<?php if ($atencion_para_st->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($atencion_para_st_list->Recordset)
	$atencion_para_st_list->Recordset->Close();
?>
<?php if ($atencion_para_st->Export == "") { ?>
<div class="panel-footer ewGridLowerPanel">
<?php if ($atencion_para_st->CurrentAction <> "gridadd" && $atencion_para_st->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-inline ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($atencion_para_st_list->Pager)) $atencion_para_st_list->Pager = new cPrevNextPager($atencion_para_st_list->StartRec, $atencion_para_st_list->DisplayRecs, $atencion_para_st_list->TotalRecs) ?>
<?php if ($atencion_para_st_list->Pager->RecordCount > 0 && $atencion_para_st_list->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($atencion_para_st_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $atencion_para_st_list->PageUrl() ?>start=<?php echo $atencion_para_st_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($atencion_para_st_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $atencion_para_st_list->PageUrl() ?>start=<?php echo $atencion_para_st_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $atencion_para_st_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($atencion_para_st_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $atencion_para_st_list->PageUrl() ?>start=<?php echo $atencion_para_st_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($atencion_para_st_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $atencion_para_st_list->PageUrl() ?>start=<?php echo $atencion_para_st_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $atencion_para_st_list->Pager->PageCount ?></span>
</div>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $atencion_para_st_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $atencion_para_st_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $atencion_para_st_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($atencion_para_st_list->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
</div>
<?php } ?>
<?php if ($atencion_para_st_list->TotalRecs == 0 && $atencion_para_st->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($atencion_para_st_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($atencion_para_st->Export == "") { ?>
<script type="text/javascript">
fatencion_para_stlistsrch.FilterList = <?php echo $atencion_para_st_list->GetFilterList() ?>;
fatencion_para_stlistsrch.Init();
fatencion_para_stlist.Init();
</script>
<?php } ?>
<?php
$atencion_para_st_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($atencion_para_st->Export == "") { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$atencion_para_st_list->Page_Terminate();
?>
