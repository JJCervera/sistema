<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "piso_tecnologicoinfo.php" ?>
<?php include_once "dato_establecimientoinfo.php" ?>
<?php include_once "usuariosinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$piso_tecnologico_list = NULL; // Initialize page object first

class cpiso_tecnologico_list extends cpiso_tecnologico {

	// Page ID
	var $PageID = 'list';

	// Project ID
	var $ProjectID = "{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}";

	// Table name
	var $TableName = 'piso_tecnologico';

	// Page object name
	var $PageObjName = 'piso_tecnologico_list';

	// Grid form hidden field names
	var $FormName = 'fpiso_tecnologicolist';
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

		// Table object (piso_tecnologico)
		if (!isset($GLOBALS["piso_tecnologico"]) || get_class($GLOBALS["piso_tecnologico"]) == "cpiso_tecnologico") {
			$GLOBALS["piso_tecnologico"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["piso_tecnologico"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportHtmlUrl = $this->PageUrl() . "export=html";
		$this->ExportXmlUrl = $this->PageUrl() . "export=xml";
		$this->ExportCsvUrl = $this->PageUrl() . "export=csv";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";
		$this->AddUrl = "piso_tecnologicoadd.php";
		$this->InlineAddUrl = $this->PageUrl() . "a=add";
		$this->GridAddUrl = $this->PageUrl() . "a=gridadd";
		$this->GridEditUrl = $this->PageUrl() . "a=gridedit";
		$this->MultiDeleteUrl = "piso_tecnologicodelete.php";
		$this->MultiUpdateUrl = "piso_tecnologicoupdate.php";

		// Table object (dato_establecimiento)
		if (!isset($GLOBALS['dato_establecimiento'])) $GLOBALS['dato_establecimiento'] = new cdato_establecimiento();

		// Table object (usuarios)
		if (!isset($GLOBALS['usuarios'])) $GLOBALS['usuarios'] = new cusuarios();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'list', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'piso_tecnologico', TRUE);

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
		$this->FilterOptions->TagClassName = "ewFilterOption fpiso_tecnologicolistsrch";

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
		$this->Switch->SetVisibility();
		$this->Bocas_Switch->SetVisibility();
		$this->Estado_Switch->SetVisibility();
		$this->Cantidad_Ap->SetVisibility();
		$this->Cantidad_Ap_Func->SetVisibility();
		$this->Ups->SetVisibility();
		$this->Estado_Ups->SetVisibility();
		$this->Cableado->SetVisibility();
		$this->Estado_Cableado->SetVisibility();
		$this->Porcent_Estado_Cab->SetVisibility();
		$this->Porcent_Func_Piso->SetVisibility();
		$this->Plano_Escuela->SetVisibility();
		$this->Fecha_Actualizacion->SetVisibility();
		$this->Fecha_Actualizacion->Visible = !$this->IsAddOrEdit();
		$this->Usuario->SetVisibility();
		$this->Usuario->Visible = !$this->IsAddOrEdit();

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
		global $EW_EXPORT, $piso_tecnologico;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($piso_tecnologico);
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
		if ($this->CurrentMode <> "add" && $this->GetMasterFilter() <> "" && $this->getCurrentMasterTable() == "dato_establecimiento") {
			global $dato_establecimiento;
			$rsmaster = $dato_establecimiento->LoadRs($this->DbMasterFilter);
			$this->MasterRecordExists = ($rsmaster && !$rsmaster->EOF);
			if (!$this->MasterRecordExists) {
				$this->setFailureMessage($Language->Phrase("NoRecord")); // Set no record found
				$this->Page_Terminate("dato_establecimientolist.php"); // Return to master page
			} else {
				$dato_establecimiento->LoadListRowValues($rsmaster);
				$dato_establecimiento->RowType = EW_ROWTYPE_MASTER; // Master row
				$dato_establecimiento->RenderListRow();
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
		$this->setKey("Cue", ""); // Clear inline edit key
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
		if (@$_GET["Cue"] <> "") {
			$this->Cue->setQueryStringValue($_GET["Cue"]);
		} else {
			$bInlineEdit = FALSE;
		}
		if ($bInlineEdit) {
			if ($this->LoadRow()) {
				$this->setKey("Cue", $this->Cue->CurrentValue); // Set up inline edit key
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
		if (strval($this->getKey("Cue")) <> strval($this->Cue->CurrentValue))
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
		if (count($arrKeyFlds) >= 1) {
			$this->Cue->setFormValue($arrKeyFlds[0]);
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
					$sKey .= $this->Cue->CurrentValue;

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
		if ($objForm->HasValue("x_Switch") && $objForm->HasValue("o_Switch") && $this->Switch->CurrentValue <> $this->Switch->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Bocas_Switch") && $objForm->HasValue("o_Bocas_Switch") && $this->Bocas_Switch->CurrentValue <> $this->Bocas_Switch->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Estado_Switch") && $objForm->HasValue("o_Estado_Switch") && $this->Estado_Switch->CurrentValue <> $this->Estado_Switch->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Cantidad_Ap") && $objForm->HasValue("o_Cantidad_Ap") && $this->Cantidad_Ap->CurrentValue <> $this->Cantidad_Ap->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Cantidad_Ap_Func") && $objForm->HasValue("o_Cantidad_Ap_Func") && $this->Cantidad_Ap_Func->CurrentValue <> $this->Cantidad_Ap_Func->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Ups") && $objForm->HasValue("o_Ups") && $this->Ups->CurrentValue <> $this->Ups->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Estado_Ups") && $objForm->HasValue("o_Estado_Ups") && $this->Estado_Ups->CurrentValue <> $this->Estado_Ups->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Cableado") && $objForm->HasValue("o_Cableado") && $this->Cableado->CurrentValue <> $this->Cableado->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Estado_Cableado") && $objForm->HasValue("o_Estado_Cableado") && $this->Estado_Cableado->CurrentValue <> $this->Estado_Cableado->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Porcent_Estado_Cab") && $objForm->HasValue("o_Porcent_Estado_Cab") && $this->Porcent_Estado_Cab->CurrentValue <> $this->Porcent_Estado_Cab->OldValue)
			return FALSE;
		if ($objForm->HasValue("x_Porcent_Func_Piso") && $objForm->HasValue("o_Porcent_Func_Piso") && $this->Porcent_Func_Piso->CurrentValue <> $this->Porcent_Func_Piso->OldValue)
			return FALSE;
		if (!ew_Empty($this->Plano_Escuela->Upload->Value))
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
			$sSavedFilterList = $UserProfile->GetSearchFilters(CurrentUserName(), "fpiso_tecnologicolistsrch");
		} else {
			$sSavedFilterList = "";
		}

		// Initialize
		$sFilterList = "";
		$sFilterList = ew_Concat($sFilterList, $this->Switch->AdvancedSearch->ToJSON(), ","); // Field Switch
		$sFilterList = ew_Concat($sFilterList, $this->Bocas_Switch->AdvancedSearch->ToJSON(), ","); // Field Bocas_Switch
		$sFilterList = ew_Concat($sFilterList, $this->Estado_Switch->AdvancedSearch->ToJSON(), ","); // Field Estado_Switch
		$sFilterList = ew_Concat($sFilterList, $this->Cantidad_Ap->AdvancedSearch->ToJSON(), ","); // Field Cantidad_Ap
		$sFilterList = ew_Concat($sFilterList, $this->Cantidad_Ap_Func->AdvancedSearch->ToJSON(), ","); // Field Cantidad_Ap_Func
		$sFilterList = ew_Concat($sFilterList, $this->Ups->AdvancedSearch->ToJSON(), ","); // Field Ups
		$sFilterList = ew_Concat($sFilterList, $this->Estado_Ups->AdvancedSearch->ToJSON(), ","); // Field Estado_Ups
		$sFilterList = ew_Concat($sFilterList, $this->Marca_Modelo_Serie_Ups->AdvancedSearch->ToJSON(), ","); // Field Marca_Modelo_Serie_Ups
		$sFilterList = ew_Concat($sFilterList, $this->Cableado->AdvancedSearch->ToJSON(), ","); // Field Cableado
		$sFilterList = ew_Concat($sFilterList, $this->Estado_Cableado->AdvancedSearch->ToJSON(), ","); // Field Estado_Cableado
		$sFilterList = ew_Concat($sFilterList, $this->Porcent_Estado_Cab->AdvancedSearch->ToJSON(), ","); // Field Porcent_Estado_Cab
		$sFilterList = ew_Concat($sFilterList, $this->Porcent_Func_Piso->AdvancedSearch->ToJSON(), ","); // Field Porcent_Func_Piso
		$sFilterList = ew_Concat($sFilterList, $this->Plano_Escuela->AdvancedSearch->ToJSON(), ","); // Field Plano_Escuela
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
			$UserProfile->SetSearchFilters(CurrentUserName(), "fpiso_tecnologicolistsrch", $filters);
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

		// Field Switch
		$this->Switch->AdvancedSearch->SearchValue = @$filter["x_Switch"];
		$this->Switch->AdvancedSearch->SearchOperator = @$filter["z_Switch"];
		$this->Switch->AdvancedSearch->SearchCondition = @$filter["v_Switch"];
		$this->Switch->AdvancedSearch->SearchValue2 = @$filter["y_Switch"];
		$this->Switch->AdvancedSearch->SearchOperator2 = @$filter["w_Switch"];
		$this->Switch->AdvancedSearch->Save();

		// Field Bocas_Switch
		$this->Bocas_Switch->AdvancedSearch->SearchValue = @$filter["x_Bocas_Switch"];
		$this->Bocas_Switch->AdvancedSearch->SearchOperator = @$filter["z_Bocas_Switch"];
		$this->Bocas_Switch->AdvancedSearch->SearchCondition = @$filter["v_Bocas_Switch"];
		$this->Bocas_Switch->AdvancedSearch->SearchValue2 = @$filter["y_Bocas_Switch"];
		$this->Bocas_Switch->AdvancedSearch->SearchOperator2 = @$filter["w_Bocas_Switch"];
		$this->Bocas_Switch->AdvancedSearch->Save();

		// Field Estado_Switch
		$this->Estado_Switch->AdvancedSearch->SearchValue = @$filter["x_Estado_Switch"];
		$this->Estado_Switch->AdvancedSearch->SearchOperator = @$filter["z_Estado_Switch"];
		$this->Estado_Switch->AdvancedSearch->SearchCondition = @$filter["v_Estado_Switch"];
		$this->Estado_Switch->AdvancedSearch->SearchValue2 = @$filter["y_Estado_Switch"];
		$this->Estado_Switch->AdvancedSearch->SearchOperator2 = @$filter["w_Estado_Switch"];
		$this->Estado_Switch->AdvancedSearch->Save();

		// Field Cantidad_Ap
		$this->Cantidad_Ap->AdvancedSearch->SearchValue = @$filter["x_Cantidad_Ap"];
		$this->Cantidad_Ap->AdvancedSearch->SearchOperator = @$filter["z_Cantidad_Ap"];
		$this->Cantidad_Ap->AdvancedSearch->SearchCondition = @$filter["v_Cantidad_Ap"];
		$this->Cantidad_Ap->AdvancedSearch->SearchValue2 = @$filter["y_Cantidad_Ap"];
		$this->Cantidad_Ap->AdvancedSearch->SearchOperator2 = @$filter["w_Cantidad_Ap"];
		$this->Cantidad_Ap->AdvancedSearch->Save();

		// Field Cantidad_Ap_Func
		$this->Cantidad_Ap_Func->AdvancedSearch->SearchValue = @$filter["x_Cantidad_Ap_Func"];
		$this->Cantidad_Ap_Func->AdvancedSearch->SearchOperator = @$filter["z_Cantidad_Ap_Func"];
		$this->Cantidad_Ap_Func->AdvancedSearch->SearchCondition = @$filter["v_Cantidad_Ap_Func"];
		$this->Cantidad_Ap_Func->AdvancedSearch->SearchValue2 = @$filter["y_Cantidad_Ap_Func"];
		$this->Cantidad_Ap_Func->AdvancedSearch->SearchOperator2 = @$filter["w_Cantidad_Ap_Func"];
		$this->Cantidad_Ap_Func->AdvancedSearch->Save();

		// Field Ups
		$this->Ups->AdvancedSearch->SearchValue = @$filter["x_Ups"];
		$this->Ups->AdvancedSearch->SearchOperator = @$filter["z_Ups"];
		$this->Ups->AdvancedSearch->SearchCondition = @$filter["v_Ups"];
		$this->Ups->AdvancedSearch->SearchValue2 = @$filter["y_Ups"];
		$this->Ups->AdvancedSearch->SearchOperator2 = @$filter["w_Ups"];
		$this->Ups->AdvancedSearch->Save();

		// Field Estado_Ups
		$this->Estado_Ups->AdvancedSearch->SearchValue = @$filter["x_Estado_Ups"];
		$this->Estado_Ups->AdvancedSearch->SearchOperator = @$filter["z_Estado_Ups"];
		$this->Estado_Ups->AdvancedSearch->SearchCondition = @$filter["v_Estado_Ups"];
		$this->Estado_Ups->AdvancedSearch->SearchValue2 = @$filter["y_Estado_Ups"];
		$this->Estado_Ups->AdvancedSearch->SearchOperator2 = @$filter["w_Estado_Ups"];
		$this->Estado_Ups->AdvancedSearch->Save();

		// Field Marca_Modelo_Serie_Ups
		$this->Marca_Modelo_Serie_Ups->AdvancedSearch->SearchValue = @$filter["x_Marca_Modelo_Serie_Ups"];
		$this->Marca_Modelo_Serie_Ups->AdvancedSearch->SearchOperator = @$filter["z_Marca_Modelo_Serie_Ups"];
		$this->Marca_Modelo_Serie_Ups->AdvancedSearch->SearchCondition = @$filter["v_Marca_Modelo_Serie_Ups"];
		$this->Marca_Modelo_Serie_Ups->AdvancedSearch->SearchValue2 = @$filter["y_Marca_Modelo_Serie_Ups"];
		$this->Marca_Modelo_Serie_Ups->AdvancedSearch->SearchOperator2 = @$filter["w_Marca_Modelo_Serie_Ups"];
		$this->Marca_Modelo_Serie_Ups->AdvancedSearch->Save();

		// Field Cableado
		$this->Cableado->AdvancedSearch->SearchValue = @$filter["x_Cableado"];
		$this->Cableado->AdvancedSearch->SearchOperator = @$filter["z_Cableado"];
		$this->Cableado->AdvancedSearch->SearchCondition = @$filter["v_Cableado"];
		$this->Cableado->AdvancedSearch->SearchValue2 = @$filter["y_Cableado"];
		$this->Cableado->AdvancedSearch->SearchOperator2 = @$filter["w_Cableado"];
		$this->Cableado->AdvancedSearch->Save();

		// Field Estado_Cableado
		$this->Estado_Cableado->AdvancedSearch->SearchValue = @$filter["x_Estado_Cableado"];
		$this->Estado_Cableado->AdvancedSearch->SearchOperator = @$filter["z_Estado_Cableado"];
		$this->Estado_Cableado->AdvancedSearch->SearchCondition = @$filter["v_Estado_Cableado"];
		$this->Estado_Cableado->AdvancedSearch->SearchValue2 = @$filter["y_Estado_Cableado"];
		$this->Estado_Cableado->AdvancedSearch->SearchOperator2 = @$filter["w_Estado_Cableado"];
		$this->Estado_Cableado->AdvancedSearch->Save();

		// Field Porcent_Estado_Cab
		$this->Porcent_Estado_Cab->AdvancedSearch->SearchValue = @$filter["x_Porcent_Estado_Cab"];
		$this->Porcent_Estado_Cab->AdvancedSearch->SearchOperator = @$filter["z_Porcent_Estado_Cab"];
		$this->Porcent_Estado_Cab->AdvancedSearch->SearchCondition = @$filter["v_Porcent_Estado_Cab"];
		$this->Porcent_Estado_Cab->AdvancedSearch->SearchValue2 = @$filter["y_Porcent_Estado_Cab"];
		$this->Porcent_Estado_Cab->AdvancedSearch->SearchOperator2 = @$filter["w_Porcent_Estado_Cab"];
		$this->Porcent_Estado_Cab->AdvancedSearch->Save();

		// Field Porcent_Func_Piso
		$this->Porcent_Func_Piso->AdvancedSearch->SearchValue = @$filter["x_Porcent_Func_Piso"];
		$this->Porcent_Func_Piso->AdvancedSearch->SearchOperator = @$filter["z_Porcent_Func_Piso"];
		$this->Porcent_Func_Piso->AdvancedSearch->SearchCondition = @$filter["v_Porcent_Func_Piso"];
		$this->Porcent_Func_Piso->AdvancedSearch->SearchValue2 = @$filter["y_Porcent_Func_Piso"];
		$this->Porcent_Func_Piso->AdvancedSearch->SearchOperator2 = @$filter["w_Porcent_Func_Piso"];
		$this->Porcent_Func_Piso->AdvancedSearch->Save();

		// Field Plano_Escuela
		$this->Plano_Escuela->AdvancedSearch->SearchValue = @$filter["x_Plano_Escuela"];
		$this->Plano_Escuela->AdvancedSearch->SearchOperator = @$filter["z_Plano_Escuela"];
		$this->Plano_Escuela->AdvancedSearch->SearchCondition = @$filter["v_Plano_Escuela"];
		$this->Plano_Escuela->AdvancedSearch->SearchValue2 = @$filter["y_Plano_Escuela"];
		$this->Plano_Escuela->AdvancedSearch->SearchOperator2 = @$filter["w_Plano_Escuela"];
		$this->Plano_Escuela->AdvancedSearch->Save();
		$this->BasicSearch->setKeyword(@$filter[EW_TABLE_BASIC_SEARCH]);
		$this->BasicSearch->setType(@$filter[EW_TABLE_BASIC_SEARCH_TYPE]);
	}

	// Advanced search WHERE clause based on QueryString
	function AdvancedSearchWhere($Default = FALSE) {
		global $Security;
		$sWhere = "";
		if (!$Security->CanSearch()) return "";
		$this->BuildSearchSql($sWhere, $this->Switch, $Default, FALSE); // Switch
		$this->BuildSearchSql($sWhere, $this->Bocas_Switch, $Default, FALSE); // Bocas_Switch
		$this->BuildSearchSql($sWhere, $this->Estado_Switch, $Default, FALSE); // Estado_Switch
		$this->BuildSearchSql($sWhere, $this->Cantidad_Ap, $Default, FALSE); // Cantidad_Ap
		$this->BuildSearchSql($sWhere, $this->Cantidad_Ap_Func, $Default, FALSE); // Cantidad_Ap_Func
		$this->BuildSearchSql($sWhere, $this->Ups, $Default, FALSE); // Ups
		$this->BuildSearchSql($sWhere, $this->Estado_Ups, $Default, FALSE); // Estado_Ups
		$this->BuildSearchSql($sWhere, $this->Marca_Modelo_Serie_Ups, $Default, FALSE); // Marca_Modelo_Serie_Ups
		$this->BuildSearchSql($sWhere, $this->Cableado, $Default, FALSE); // Cableado
		$this->BuildSearchSql($sWhere, $this->Estado_Cableado, $Default, FALSE); // Estado_Cableado
		$this->BuildSearchSql($sWhere, $this->Porcent_Estado_Cab, $Default, FALSE); // Porcent_Estado_Cab
		$this->BuildSearchSql($sWhere, $this->Porcent_Func_Piso, $Default, FALSE); // Porcent_Func_Piso
		$this->BuildSearchSql($sWhere, $this->Plano_Escuela, $Default, FALSE); // Plano_Escuela

		// Set up search parm
		if (!$Default && $sWhere <> "") {
			$this->Command = "search";
		}
		if (!$Default && $this->Command == "search") {
			$this->Switch->AdvancedSearch->Save(); // Switch
			$this->Bocas_Switch->AdvancedSearch->Save(); // Bocas_Switch
			$this->Estado_Switch->AdvancedSearch->Save(); // Estado_Switch
			$this->Cantidad_Ap->AdvancedSearch->Save(); // Cantidad_Ap
			$this->Cantidad_Ap_Func->AdvancedSearch->Save(); // Cantidad_Ap_Func
			$this->Ups->AdvancedSearch->Save(); // Ups
			$this->Estado_Ups->AdvancedSearch->Save(); // Estado_Ups
			$this->Marca_Modelo_Serie_Ups->AdvancedSearch->Save(); // Marca_Modelo_Serie_Ups
			$this->Cableado->AdvancedSearch->Save(); // Cableado
			$this->Estado_Cableado->AdvancedSearch->Save(); // Estado_Cableado
			$this->Porcent_Estado_Cab->AdvancedSearch->Save(); // Porcent_Estado_Cab
			$this->Porcent_Func_Piso->AdvancedSearch->Save(); // Porcent_Func_Piso
			$this->Plano_Escuela->AdvancedSearch->Save(); // Plano_Escuela
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
		$this->BuildBasicSearchSQL($sWhere, $this->Switch, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Estado_Switch, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Cantidad_Ap, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Ups, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Estado_Ups, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Marca_Modelo_Serie_Ups, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Cableado, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Estado_Cableado, $arKeywords, $type);
		$this->BuildBasicSearchSQL($sWhere, $this->Cue, $arKeywords, $type);
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
		if ($this->Switch->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Bocas_Switch->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Estado_Switch->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Cantidad_Ap->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Cantidad_Ap_Func->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Ups->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Estado_Ups->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Marca_Modelo_Serie_Ups->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Cableado->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Estado_Cableado->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Porcent_Estado_Cab->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Porcent_Func_Piso->AdvancedSearch->IssetSession())
			return TRUE;
		if ($this->Plano_Escuela->AdvancedSearch->IssetSession())
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
		$this->Switch->AdvancedSearch->LoadDefault();
		$this->Estado_Switch->AdvancedSearch->LoadDefault();
		$this->Ups->AdvancedSearch->LoadDefault();
		$this->Estado_Ups->AdvancedSearch->LoadDefault();
		$this->Cableado->AdvancedSearch->LoadDefault();
		$this->Estado_Cableado->AdvancedSearch->LoadDefault();
		return TRUE;
	}

	// Clear all basic search parameters
	function ResetBasicSearchParms() {
		$this->BasicSearch->UnsetSession();
	}

	// Clear all advanced search parameters
	function ResetAdvancedSearchParms() {
		$this->Switch->AdvancedSearch->UnsetSession();
		$this->Bocas_Switch->AdvancedSearch->UnsetSession();
		$this->Estado_Switch->AdvancedSearch->UnsetSession();
		$this->Cantidad_Ap->AdvancedSearch->UnsetSession();
		$this->Cantidad_Ap_Func->AdvancedSearch->UnsetSession();
		$this->Ups->AdvancedSearch->UnsetSession();
		$this->Estado_Ups->AdvancedSearch->UnsetSession();
		$this->Marca_Modelo_Serie_Ups->AdvancedSearch->UnsetSession();
		$this->Cableado->AdvancedSearch->UnsetSession();
		$this->Estado_Cableado->AdvancedSearch->UnsetSession();
		$this->Porcent_Estado_Cab->AdvancedSearch->UnsetSession();
		$this->Porcent_Func_Piso->AdvancedSearch->UnsetSession();
		$this->Plano_Escuela->AdvancedSearch->UnsetSession();
	}

	// Restore all search parameters
	function RestoreSearchParms() {
		$this->RestoreSearch = TRUE;

		// Restore basic search values
		$this->BasicSearch->Load();

		// Restore advanced search values
		$this->Switch->AdvancedSearch->Load();
		$this->Bocas_Switch->AdvancedSearch->Load();
		$this->Estado_Switch->AdvancedSearch->Load();
		$this->Cantidad_Ap->AdvancedSearch->Load();
		$this->Cantidad_Ap_Func->AdvancedSearch->Load();
		$this->Ups->AdvancedSearch->Load();
		$this->Estado_Ups->AdvancedSearch->Load();
		$this->Marca_Modelo_Serie_Ups->AdvancedSearch->Load();
		$this->Cableado->AdvancedSearch->Load();
		$this->Estado_Cableado->AdvancedSearch->Load();
		$this->Porcent_Estado_Cab->AdvancedSearch->Load();
		$this->Porcent_Func_Piso->AdvancedSearch->Load();
		$this->Plano_Escuela->AdvancedSearch->Load();
	}

	// Set up sort parameters
	function SetUpSortOrder() {

		// Check for "order" parameter
		if (@$_GET["order"] <> "") {
			$this->CurrentOrder = ew_StripSlashes(@$_GET["order"]);
			$this->CurrentOrderType = @$_GET["ordertype"];
			$this->UpdateSort($this->Switch); // Switch
			$this->UpdateSort($this->Bocas_Switch); // Bocas_Switch
			$this->UpdateSort($this->Estado_Switch); // Estado_Switch
			$this->UpdateSort($this->Cantidad_Ap); // Cantidad_Ap
			$this->UpdateSort($this->Cantidad_Ap_Func); // Cantidad_Ap_Func
			$this->UpdateSort($this->Ups); // Ups
			$this->UpdateSort($this->Estado_Ups); // Estado_Ups
			$this->UpdateSort($this->Cableado); // Cableado
			$this->UpdateSort($this->Estado_Cableado); // Estado_Cableado
			$this->UpdateSort($this->Porcent_Estado_Cab); // Porcent_Estado_Cab
			$this->UpdateSort($this->Porcent_Func_Piso); // Porcent_Func_Piso
			$this->UpdateSort($this->Plano_Escuela); // Plano_Escuela
			$this->UpdateSort($this->Fecha_Actualizacion); // Fecha_Actualizacion
			$this->UpdateSort($this->Usuario); // Usuario
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
				$this->Cue->setSessionValue("");
			}

			// Reset sorting order
			if ($this->Command == "resetsort") {
				$sOrderBy = "";
				$this->setSessionOrderBy($sOrderBy);
				$this->Switch->setSort("");
				$this->Bocas_Switch->setSort("");
				$this->Estado_Switch->setSort("");
				$this->Cantidad_Ap->setSort("");
				$this->Cantidad_Ap_Func->setSort("");
				$this->Ups->setSort("");
				$this->Estado_Ups->setSort("");
				$this->Cableado->setSort("");
				$this->Estado_Cableado->setSort("");
				$this->Porcent_Estado_Cab->setSort("");
				$this->Porcent_Func_Piso->setSort("");
				$this->Plano_Escuela->setSort("");
				$this->Fecha_Actualizacion->setSort("");
				$this->Usuario->setSort("");
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
			$oListOpt->Body .= "<input type=\"hidden\" name=\"k" . $this->RowIndex . "_key\" id=\"k" . $this->RowIndex . "_key\" value=\"" . ew_HtmlEncode($this->Cue->CurrentValue) . "\">";
			return;
		}

		// "view"
		$oListOpt = &$this->ListOptions->Items["view"];
		$viewcaption = ew_HtmlTitle($Language->Phrase("ViewLink"));
		if ($Security->CanView()) {
			if (ew_IsMobile())
				$oListOpt->Body = "<a class=\"ewRowLink ewView\" title=\"" . $viewcaption . "\" data-caption=\"" . $viewcaption . "\" href=\"" . ew_HtmlEncode($this->ViewUrl) . "\">" . $Language->Phrase("ViewLink") . "</a>";
			else
				$oListOpt->Body = "<a class=\"ewRowLink ewView\" title=\"" . $viewcaption . "\" data-table=\"piso_tecnologico\" data-caption=\"" . $viewcaption . "\" href=\"javascript:void(0);\" onclick=\"ew_ModalDialogShow({lnk:this,url:'" . ew_HtmlEncode($this->ViewUrl) . "'});\">" . $Language->Phrase("ViewLink") . "</a>";
		} else {
			$oListOpt->Body = "";
		}

		// "edit"
		$oListOpt = &$this->ListOptions->Items["edit"];
		$editcaption = ew_HtmlTitle($Language->Phrase("EditLink"));
		if ($Security->CanEdit()) {
			if (ew_IsMobile())
				$oListOpt->Body = "<a class=\"ewRowLink ewEdit\" title=\"" . $editcaption . "\" data-caption=\"" . $editcaption . "\" href=\"" . ew_HtmlEncode($this->EditUrl) . "\">" . $Language->Phrase("EditLink") . "</a>";
			else
				$oListOpt->Body = "<a class=\"ewRowLink ewEdit\" title=\"" . $editcaption . "\" data-table=\"piso_tecnologico\" data-caption=\"" . $editcaption . "\" href=\"javascript:void(0);\" onclick=\"ew_ModalDialogShow({lnk:this,url:'" . ew_HtmlEncode($this->EditUrl) . "',caption:'" . $editcaption . "'});\">" . $Language->Phrase("EditLink") . "</a>";
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
		$oListOpt->Body = "<input type=\"checkbox\" name=\"key_m[]\" value=\"" . ew_HtmlEncode($this->Cue->CurrentValue) . "\" onclick='ew_ClickMultiCheckbox(event);'>";
		if ($this->CurrentAction == "gridedit" && is_numeric($this->RowIndex)) {
			$this->MultiSelectKey .= "<input type=\"hidden\" name=\"" . $KeyName . "\" id=\"" . $KeyName . "\" value=\"" . $this->Cue->CurrentValue . "\">";
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
		$item->Body = "<a class=\"ewAction ewMultiDelete\" title=\"" . ew_HtmlTitle($Language->Phrase("DeleteSelectedLink")) . "\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("DeleteSelectedLink")) . "\" href=\"\" onclick=\"ew_SubmitAction(event,{f:document.fpiso_tecnologicolist,url:'" . $this->MultiDeleteUrl . "',msg:ewLanguage.Phrase('DeleteConfirmMsg')});return false;\">" . $Language->Phrase("DeleteSelectedLink") . "</a>";
		$item->Visible = ($Security->CanDelete());

		// Add multi update
		$item = &$option->Add("multiupdate");
		$item->Body = "<a class=\"ewAction ewMultiUpdate\" title=\"" . ew_HtmlTitle($Language->Phrase("UpdateSelectedLink")) . "\" data-table=\"piso_tecnologico\" data-caption=\"" . ew_HtmlTitle($Language->Phrase("UpdateSelectedLink")) . "\" href=\"\" onclick=\"ew_ModalDialogShow({lnk:this,f:document.fpiso_tecnologicolist,url:'" . $this->MultiUpdateUrl . "',caption:'" . $Language->Phrase("UpdateBtn") . "'});return false;\">" . $Language->Phrase("UpdateSelectedLink") . "</a>";
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
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"fpiso_tecnologicolistsrch\" href=\"#\">" . $Language->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = TRUE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"fpiso_tecnologicolistsrch\" href=\"#\">" . $Language->Phrase("DeleteFilter") . "</a>";
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
					$item->Body = "<a class=\"ewAction ewListAction\" title=\"" . ew_HtmlEncode($caption) . "\" data-caption=\"" . ew_HtmlEncode($caption) . "\" href=\"\" onclick=\"ew_SubmitAction(event,jQuery.extend({f:document.fpiso_tecnologicolist}," . $listaction->ToJson(TRUE) . "));return false;\">" . $icon . "</a>";
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
		$item->Body = "<button type=\"button\" class=\"btn btn-default ewSearchToggle" . $SearchToggleClass . "\" title=\"" . $Language->Phrase("SearchPanel") . "\" data-caption=\"" . $Language->Phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"fpiso_tecnologicolistsrch\">" . $Language->Phrase("SearchBtn") . "</button>";
		$item->Visible = TRUE;

		// Show all button
		$item = &$this->SearchOptions->Add("showall");
		$item->Body = "<a class=\"btn btn-default ewShowAll\" title=\"" . $Language->Phrase("ResetSearch") . "\" data-caption=\"" . $Language->Phrase("ResetSearch") . "\" href=\"" . $this->PageUrl() . "cmd=reset\">" . $Language->Phrase("ResetSearchBtn") . "</a>";
		$item->Visible = ($this->SearchWhere <> $this->DefaultSearchWhere && $this->SearchWhere <> "0=101");

		// Advanced search button
		$item = &$this->SearchOptions->Add("advancedsearch");
		$item->Body = "<a class=\"btn btn-default ewAdvancedSearch\" title=\"" . $Language->Phrase("AdvancedSearch") . "\" data-caption=\"" . $Language->Phrase("AdvancedSearch") . "\" href=\"piso_tecnologicosrch.php\">" . $Language->Phrase("AdvancedSearchBtn") . "</a>";
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

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $Language;

		// Get upload data
		$this->Plano_Escuela->Upload->Index = $objForm->Index;
		$this->Plano_Escuela->Upload->UploadFile();
		$this->Plano_Escuela->CurrentValue = $this->Plano_Escuela->Upload->FileName;
	}

	// Load default values
	function LoadDefaultValues() {
		$this->Switch->CurrentValue = 'Si';
		$this->Switch->OldValue = $this->Switch->CurrentValue;
		$this->Bocas_Switch->CurrentValue = NULL;
		$this->Bocas_Switch->OldValue = $this->Bocas_Switch->CurrentValue;
		$this->Estado_Switch->CurrentValue = NULL;
		$this->Estado_Switch->OldValue = $this->Estado_Switch->CurrentValue;
		$this->Cantidad_Ap->CurrentValue = NULL;
		$this->Cantidad_Ap->OldValue = $this->Cantidad_Ap->CurrentValue;
		$this->Cantidad_Ap_Func->CurrentValue = NULL;
		$this->Cantidad_Ap_Func->OldValue = $this->Cantidad_Ap_Func->CurrentValue;
		$this->Ups->CurrentValue = NULL;
		$this->Ups->OldValue = $this->Ups->CurrentValue;
		$this->Estado_Ups->CurrentValue = NULL;
		$this->Estado_Ups->OldValue = $this->Estado_Ups->CurrentValue;
		$this->Cableado->CurrentValue = 'Si';
		$this->Cableado->OldValue = $this->Cableado->CurrentValue;
		$this->Estado_Cableado->CurrentValue = NULL;
		$this->Estado_Cableado->OldValue = $this->Estado_Cableado->CurrentValue;
		$this->Porcent_Estado_Cab->CurrentValue = NULL;
		$this->Porcent_Estado_Cab->OldValue = $this->Porcent_Estado_Cab->CurrentValue;
		$this->Porcent_Func_Piso->CurrentValue = NULL;
		$this->Porcent_Func_Piso->OldValue = $this->Porcent_Func_Piso->CurrentValue;
		$this->Plano_Escuela->Upload->DbValue = NULL;
		$this->Plano_Escuela->OldValue = $this->Plano_Escuela->Upload->DbValue;
		$this->Fecha_Actualizacion->CurrentValue = NULL;
		$this->Fecha_Actualizacion->OldValue = $this->Fecha_Actualizacion->CurrentValue;
		$this->Usuario->CurrentValue = NULL;
		$this->Usuario->OldValue = $this->Usuario->CurrentValue;
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
		// Switch

		$this->Switch->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Switch"]);
		if ($this->Switch->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Switch->AdvancedSearch->SearchOperator = @$_GET["z_Switch"];

		// Bocas_Switch
		$this->Bocas_Switch->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Bocas_Switch"]);
		if ($this->Bocas_Switch->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Bocas_Switch->AdvancedSearch->SearchOperator = @$_GET["z_Bocas_Switch"];

		// Estado_Switch
		$this->Estado_Switch->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Estado_Switch"]);
		if ($this->Estado_Switch->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Estado_Switch->AdvancedSearch->SearchOperator = @$_GET["z_Estado_Switch"];

		// Cantidad_Ap
		$this->Cantidad_Ap->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Cantidad_Ap"]);
		if ($this->Cantidad_Ap->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Cantidad_Ap->AdvancedSearch->SearchOperator = @$_GET["z_Cantidad_Ap"];

		// Cantidad_Ap_Func
		$this->Cantidad_Ap_Func->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Cantidad_Ap_Func"]);
		if ($this->Cantidad_Ap_Func->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Cantidad_Ap_Func->AdvancedSearch->SearchOperator = @$_GET["z_Cantidad_Ap_Func"];

		// Ups
		$this->Ups->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Ups"]);
		if ($this->Ups->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Ups->AdvancedSearch->SearchOperator = @$_GET["z_Ups"];

		// Estado_Ups
		$this->Estado_Ups->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Estado_Ups"]);
		if ($this->Estado_Ups->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Estado_Ups->AdvancedSearch->SearchOperator = @$_GET["z_Estado_Ups"];

		// Marca_Modelo_Serie_Ups
		$this->Marca_Modelo_Serie_Ups->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Marca_Modelo_Serie_Ups"]);
		if ($this->Marca_Modelo_Serie_Ups->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Marca_Modelo_Serie_Ups->AdvancedSearch->SearchOperator = @$_GET["z_Marca_Modelo_Serie_Ups"];

		// Cableado
		$this->Cableado->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Cableado"]);
		if ($this->Cableado->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Cableado->AdvancedSearch->SearchOperator = @$_GET["z_Cableado"];

		// Estado_Cableado
		$this->Estado_Cableado->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Estado_Cableado"]);
		if ($this->Estado_Cableado->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Estado_Cableado->AdvancedSearch->SearchOperator = @$_GET["z_Estado_Cableado"];

		// Porcent_Estado_Cab
		$this->Porcent_Estado_Cab->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Porcent_Estado_Cab"]);
		if ($this->Porcent_Estado_Cab->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Porcent_Estado_Cab->AdvancedSearch->SearchOperator = @$_GET["z_Porcent_Estado_Cab"];

		// Porcent_Func_Piso
		$this->Porcent_Func_Piso->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Porcent_Func_Piso"]);
		if ($this->Porcent_Func_Piso->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Porcent_Func_Piso->AdvancedSearch->SearchOperator = @$_GET["z_Porcent_Func_Piso"];

		// Plano_Escuela
		$this->Plano_Escuela->AdvancedSearch->SearchValue = ew_StripSlashes(@$_GET["x_Plano_Escuela"]);
		if ($this->Plano_Escuela->AdvancedSearch->SearchValue <> "") $this->Command = "search";
		$this->Plano_Escuela->AdvancedSearch->SearchOperator = @$_GET["z_Plano_Escuela"];
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		$this->GetUploadFiles(); // Get upload files
		if (!$this->Switch->FldIsDetailKey) {
			$this->Switch->setFormValue($objForm->GetValue("x_Switch"));
		}
		$this->Switch->setOldValue($objForm->GetValue("o_Switch"));
		if (!$this->Bocas_Switch->FldIsDetailKey) {
			$this->Bocas_Switch->setFormValue($objForm->GetValue("x_Bocas_Switch"));
		}
		$this->Bocas_Switch->setOldValue($objForm->GetValue("o_Bocas_Switch"));
		if (!$this->Estado_Switch->FldIsDetailKey) {
			$this->Estado_Switch->setFormValue($objForm->GetValue("x_Estado_Switch"));
		}
		$this->Estado_Switch->setOldValue($objForm->GetValue("o_Estado_Switch"));
		if (!$this->Cantidad_Ap->FldIsDetailKey) {
			$this->Cantidad_Ap->setFormValue($objForm->GetValue("x_Cantidad_Ap"));
		}
		$this->Cantidad_Ap->setOldValue($objForm->GetValue("o_Cantidad_Ap"));
		if (!$this->Cantidad_Ap_Func->FldIsDetailKey) {
			$this->Cantidad_Ap_Func->setFormValue($objForm->GetValue("x_Cantidad_Ap_Func"));
		}
		$this->Cantidad_Ap_Func->setOldValue($objForm->GetValue("o_Cantidad_Ap_Func"));
		if (!$this->Ups->FldIsDetailKey) {
			$this->Ups->setFormValue($objForm->GetValue("x_Ups"));
		}
		$this->Ups->setOldValue($objForm->GetValue("o_Ups"));
		if (!$this->Estado_Ups->FldIsDetailKey) {
			$this->Estado_Ups->setFormValue($objForm->GetValue("x_Estado_Ups"));
		}
		$this->Estado_Ups->setOldValue($objForm->GetValue("o_Estado_Ups"));
		if (!$this->Cableado->FldIsDetailKey) {
			$this->Cableado->setFormValue($objForm->GetValue("x_Cableado"));
		}
		$this->Cableado->setOldValue($objForm->GetValue("o_Cableado"));
		if (!$this->Estado_Cableado->FldIsDetailKey) {
			$this->Estado_Cableado->setFormValue($objForm->GetValue("x_Estado_Cableado"));
		}
		$this->Estado_Cableado->setOldValue($objForm->GetValue("o_Estado_Cableado"));
		if (!$this->Porcent_Estado_Cab->FldIsDetailKey) {
			$this->Porcent_Estado_Cab->setFormValue($objForm->GetValue("x_Porcent_Estado_Cab"));
		}
		$this->Porcent_Estado_Cab->setOldValue($objForm->GetValue("o_Porcent_Estado_Cab"));
		if (!$this->Porcent_Func_Piso->FldIsDetailKey) {
			$this->Porcent_Func_Piso->setFormValue($objForm->GetValue("x_Porcent_Func_Piso"));
		}
		$this->Porcent_Func_Piso->setOldValue($objForm->GetValue("o_Porcent_Func_Piso"));
		if (!$this->Fecha_Actualizacion->FldIsDetailKey) {
			$this->Fecha_Actualizacion->setFormValue($objForm->GetValue("x_Fecha_Actualizacion"));
			$this->Fecha_Actualizacion->CurrentValue = ew_UnFormatDateTime($this->Fecha_Actualizacion->CurrentValue, 7);
		}
		$this->Fecha_Actualizacion->setOldValue($objForm->GetValue("o_Fecha_Actualizacion"));
		if (!$this->Usuario->FldIsDetailKey) {
			$this->Usuario->setFormValue($objForm->GetValue("x_Usuario"));
		}
		$this->Usuario->setOldValue($objForm->GetValue("o_Usuario"));
		if (!$this->Cue->FldIsDetailKey)
			$this->Cue->setFormValue($objForm->GetValue("x_Cue"));
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->Cue->CurrentValue = $this->Cue->FormValue;
		$this->Switch->CurrentValue = $this->Switch->FormValue;
		$this->Bocas_Switch->CurrentValue = $this->Bocas_Switch->FormValue;
		$this->Estado_Switch->CurrentValue = $this->Estado_Switch->FormValue;
		$this->Cantidad_Ap->CurrentValue = $this->Cantidad_Ap->FormValue;
		$this->Cantidad_Ap_Func->CurrentValue = $this->Cantidad_Ap_Func->FormValue;
		$this->Ups->CurrentValue = $this->Ups->FormValue;
		$this->Estado_Ups->CurrentValue = $this->Estado_Ups->FormValue;
		$this->Cableado->CurrentValue = $this->Cableado->FormValue;
		$this->Estado_Cableado->CurrentValue = $this->Estado_Cableado->FormValue;
		$this->Porcent_Estado_Cab->CurrentValue = $this->Porcent_Estado_Cab->FormValue;
		$this->Porcent_Func_Piso->CurrentValue = $this->Porcent_Func_Piso->FormValue;
		$this->Fecha_Actualizacion->CurrentValue = $this->Fecha_Actualizacion->FormValue;
		$this->Fecha_Actualizacion->CurrentValue = ew_UnFormatDateTime($this->Fecha_Actualizacion->CurrentValue, 7);
		$this->Usuario->CurrentValue = $this->Usuario->FormValue;
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
		$this->Switch->setDbValue($rs->fields('Switch'));
		$this->Bocas_Switch->setDbValue($rs->fields('Bocas_Switch'));
		$this->Estado_Switch->setDbValue($rs->fields('Estado_Switch'));
		$this->Cantidad_Ap->setDbValue($rs->fields('Cantidad_Ap'));
		$this->Cantidad_Ap_Func->setDbValue($rs->fields('Cantidad_Ap_Func'));
		$this->Ups->setDbValue($rs->fields('Ups'));
		$this->Estado_Ups->setDbValue($rs->fields('Estado_Ups'));
		$this->Marca_Modelo_Serie_Ups->setDbValue($rs->fields('Marca_Modelo_Serie_Ups'));
		$this->Cableado->setDbValue($rs->fields('Cableado'));
		$this->Estado_Cableado->setDbValue($rs->fields('Estado_Cableado'));
		$this->Porcent_Estado_Cab->setDbValue($rs->fields('Porcent_Estado_Cab'));
		$this->Porcent_Func_Piso->setDbValue($rs->fields('Porcent_Func_Piso'));
		$this->Plano_Escuela->Upload->DbValue = $rs->fields('Plano_Escuela');
		$this->Plano_Escuela->CurrentValue = $this->Plano_Escuela->Upload->DbValue;
		$this->Fecha_Actualizacion->setDbValue($rs->fields('Fecha_Actualizacion'));
		$this->Usuario->setDbValue($rs->fields('Usuario'));
		$this->Cue->setDbValue($rs->fields('Cue'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->Switch->DbValue = $row['Switch'];
		$this->Bocas_Switch->DbValue = $row['Bocas_Switch'];
		$this->Estado_Switch->DbValue = $row['Estado_Switch'];
		$this->Cantidad_Ap->DbValue = $row['Cantidad_Ap'];
		$this->Cantidad_Ap_Func->DbValue = $row['Cantidad_Ap_Func'];
		$this->Ups->DbValue = $row['Ups'];
		$this->Estado_Ups->DbValue = $row['Estado_Ups'];
		$this->Marca_Modelo_Serie_Ups->DbValue = $row['Marca_Modelo_Serie_Ups'];
		$this->Cableado->DbValue = $row['Cableado'];
		$this->Estado_Cableado->DbValue = $row['Estado_Cableado'];
		$this->Porcent_Estado_Cab->DbValue = $row['Porcent_Estado_Cab'];
		$this->Porcent_Func_Piso->DbValue = $row['Porcent_Func_Piso'];
		$this->Plano_Escuela->Upload->DbValue = $row['Plano_Escuela'];
		$this->Fecha_Actualizacion->DbValue = $row['Fecha_Actualizacion'];
		$this->Usuario->DbValue = $row['Usuario'];
		$this->Cue->DbValue = $row['Cue'];
	}

	// Load old record
	function LoadOldRecord() {

		// Load key values from Session
		$bValidKey = TRUE;
		if (strval($this->getKey("Cue")) <> "")
			$this->Cue->CurrentValue = $this->getKey("Cue"); // Cue
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
		// Switch
		// Bocas_Switch
		// Estado_Switch
		// Cantidad_Ap
		// Cantidad_Ap_Func
		// Ups
		// Estado_Ups
		// Marca_Modelo_Serie_Ups
		// Cableado
		// Estado_Cableado
		// Porcent_Estado_Cab
		// Porcent_Func_Piso
		// Plano_Escuela
		// Fecha_Actualizacion
		// Usuario
		// Cue

		$this->Cue->CellCssStyle = "white-space: nowrap;";
		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// Switch
		if (strval($this->Switch->CurrentValue) <> "") {
			$this->Switch->ViewValue = $this->Switch->OptionCaption($this->Switch->CurrentValue);
		} else {
			$this->Switch->ViewValue = NULL;
		}
		$this->Switch->ViewCustomAttributes = "";

		// Bocas_Switch
		$this->Bocas_Switch->ViewValue = $this->Bocas_Switch->CurrentValue;
		$this->Bocas_Switch->ViewCustomAttributes = "";

		// Estado_Switch
		if (strval($this->Estado_Switch->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Estado_Equipo_piso`" . ew_SearchString("=", $this->Estado_Switch->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Estado_Equipo_piso`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `estado_equipos_piso`";
		$sWhereWrk = "";
		$this->Estado_Switch->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Estado_Switch, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
		$sSqlWrk .= " ORDER BY `Descripcion` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Estado_Switch->ViewValue = $this->Estado_Switch->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Estado_Switch->ViewValue = $this->Estado_Switch->CurrentValue;
			}
		} else {
			$this->Estado_Switch->ViewValue = NULL;
		}
		$this->Estado_Switch->ViewCustomAttributes = "";

		// Cantidad_Ap
		$this->Cantidad_Ap->ViewValue = $this->Cantidad_Ap->CurrentValue;
		$this->Cantidad_Ap->ViewCustomAttributes = "";

		// Cantidad_Ap_Func
		$this->Cantidad_Ap_Func->ViewValue = $this->Cantidad_Ap_Func->CurrentValue;
		$this->Cantidad_Ap_Func->ViewCustomAttributes = "";

		// Ups
		if (strval($this->Ups->CurrentValue) <> "") {
			$this->Ups->ViewValue = $this->Ups->OptionCaption($this->Ups->CurrentValue);
		} else {
			$this->Ups->ViewValue = NULL;
		}
		$this->Ups->ViewCustomAttributes = "";

		// Estado_Ups
		if (strval($this->Estado_Ups->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Estado_Equipo_piso`" . ew_SearchString("=", $this->Estado_Ups->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Estado_Equipo_piso`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `estado_equipos_piso`";
		$sWhereWrk = "";
		$this->Estado_Ups->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Estado_Ups, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Estado_Ups->ViewValue = $this->Estado_Ups->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Estado_Ups->ViewValue = $this->Estado_Ups->CurrentValue;
			}
		} else {
			$this->Estado_Ups->ViewValue = NULL;
		}
		$this->Estado_Ups->ViewCustomAttributes = "";

		// Cableado
		if (strval($this->Cableado->CurrentValue) <> "") {
			$this->Cableado->ViewValue = $this->Cableado->OptionCaption($this->Cableado->CurrentValue);
		} else {
			$this->Cableado->ViewValue = NULL;
		}
		$this->Cableado->ViewCustomAttributes = "";

		// Estado_Cableado
		if (strval($this->Estado_Cableado->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Estado_Equipo_piso`" . ew_SearchString("=", $this->Estado_Cableado->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Estado_Equipo_piso`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `estado_equipos_piso`";
		$sWhereWrk = "";
		$this->Estado_Cableado->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Estado_Cableado, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Estado_Cableado->ViewValue = $this->Estado_Cableado->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Estado_Cableado->ViewValue = $this->Estado_Cableado->CurrentValue;
			}
		} else {
			$this->Estado_Cableado->ViewValue = NULL;
		}
		$this->Estado_Cableado->ViewCustomAttributes = "";

		// Porcent_Estado_Cab
		$this->Porcent_Estado_Cab->ViewValue = $this->Porcent_Estado_Cab->CurrentValue;
		$this->Porcent_Estado_Cab->ViewCustomAttributes = "";

		// Porcent_Func_Piso
		$this->Porcent_Func_Piso->ViewValue = $this->Porcent_Func_Piso->CurrentValue;
		$this->Porcent_Func_Piso->ViewCustomAttributes = "";

		// Plano_Escuela
		if (!ew_Empty($this->Plano_Escuela->Upload->DbValue)) {
			$this->Plano_Escuela->ViewValue = $this->Plano_Escuela->Upload->DbValue;
		} else {
			$this->Plano_Escuela->ViewValue = "";
		}
		$this->Plano_Escuela->ViewCustomAttributes = "";

		// Fecha_Actualizacion
		$this->Fecha_Actualizacion->ViewValue = $this->Fecha_Actualizacion->CurrentValue;
		$this->Fecha_Actualizacion->ViewValue = ew_FormatDateTime($this->Fecha_Actualizacion->ViewValue, 7);
		$this->Fecha_Actualizacion->ViewCustomAttributes = "";

		// Usuario
		$this->Usuario->ViewValue = $this->Usuario->CurrentValue;
		$this->Usuario->ViewCustomAttributes = "";

			// Switch
			$this->Switch->LinkCustomAttributes = "";
			$this->Switch->HrefValue = "";
			$this->Switch->TooltipValue = "";

			// Bocas_Switch
			$this->Bocas_Switch->LinkCustomAttributes = "";
			$this->Bocas_Switch->HrefValue = "";
			$this->Bocas_Switch->TooltipValue = "";

			// Estado_Switch
			$this->Estado_Switch->LinkCustomAttributes = "";
			$this->Estado_Switch->HrefValue = "";
			$this->Estado_Switch->TooltipValue = "";

			// Cantidad_Ap
			$this->Cantidad_Ap->LinkCustomAttributes = "";
			$this->Cantidad_Ap->HrefValue = "";
			$this->Cantidad_Ap->TooltipValue = "";

			// Cantidad_Ap_Func
			$this->Cantidad_Ap_Func->LinkCustomAttributes = "";
			$this->Cantidad_Ap_Func->HrefValue = "";
			$this->Cantidad_Ap_Func->TooltipValue = "";

			// Ups
			$this->Ups->LinkCustomAttributes = "";
			$this->Ups->HrefValue = "";
			$this->Ups->TooltipValue = "";

			// Estado_Ups
			$this->Estado_Ups->LinkCustomAttributes = "";
			$this->Estado_Ups->HrefValue = "";
			$this->Estado_Ups->TooltipValue = "";

			// Cableado
			$this->Cableado->LinkCustomAttributes = "";
			$this->Cableado->HrefValue = "";
			$this->Cableado->TooltipValue = "";

			// Estado_Cableado
			$this->Estado_Cableado->LinkCustomAttributes = "";
			$this->Estado_Cableado->HrefValue = "";
			$this->Estado_Cableado->TooltipValue = "";

			// Porcent_Estado_Cab
			$this->Porcent_Estado_Cab->LinkCustomAttributes = "";
			$this->Porcent_Estado_Cab->HrefValue = "";
			$this->Porcent_Estado_Cab->TooltipValue = "";

			// Porcent_Func_Piso
			$this->Porcent_Func_Piso->LinkCustomAttributes = "";
			$this->Porcent_Func_Piso->HrefValue = "";
			$this->Porcent_Func_Piso->TooltipValue = "";

			// Plano_Escuela
			$this->Plano_Escuela->LinkCustomAttributes = "";
			$this->Plano_Escuela->HrefValue = "";
			$this->Plano_Escuela->HrefValue2 = $this->Plano_Escuela->UploadPath . $this->Plano_Escuela->Upload->DbValue;
			$this->Plano_Escuela->TooltipValue = "";

			// Fecha_Actualizacion
			$this->Fecha_Actualizacion->LinkCustomAttributes = "";
			$this->Fecha_Actualizacion->HrefValue = "";
			$this->Fecha_Actualizacion->TooltipValue = "";

			// Usuario
			$this->Usuario->LinkCustomAttributes = "";
			$this->Usuario->HrefValue = "";
			$this->Usuario->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_ADD) { // Add row

			// Switch
			$this->Switch->EditCustomAttributes = "";
			$this->Switch->EditValue = $this->Switch->Options(FALSE);

			// Bocas_Switch
			$this->Bocas_Switch->EditAttrs["class"] = "form-control";
			$this->Bocas_Switch->EditCustomAttributes = "";
			$this->Bocas_Switch->EditValue = ew_HtmlEncode($this->Bocas_Switch->CurrentValue);
			$this->Bocas_Switch->PlaceHolder = ew_RemoveHtml($this->Bocas_Switch->FldCaption());

			// Estado_Switch
			$this->Estado_Switch->EditAttrs["class"] = "form-control";
			$this->Estado_Switch->EditCustomAttributes = "";
			if (trim(strval($this->Estado_Switch->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Estado_Equipo_piso`" . ew_SearchString("=", $this->Estado_Switch->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Estado_Equipo_piso`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `estado_equipos_piso`";
			$sWhereWrk = "";
			$this->Estado_Switch->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Estado_Switch, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Descripcion` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Estado_Switch->EditValue = $arwrk;

			// Cantidad_Ap
			$this->Cantidad_Ap->EditAttrs["class"] = "form-control";
			$this->Cantidad_Ap->EditCustomAttributes = "";
			$this->Cantidad_Ap->EditValue = ew_HtmlEncode($this->Cantidad_Ap->CurrentValue);
			$this->Cantidad_Ap->PlaceHolder = ew_RemoveHtml($this->Cantidad_Ap->FldCaption());

			// Cantidad_Ap_Func
			$this->Cantidad_Ap_Func->EditAttrs["class"] = "form-control";
			$this->Cantidad_Ap_Func->EditCustomAttributes = "";
			$this->Cantidad_Ap_Func->EditValue = ew_HtmlEncode($this->Cantidad_Ap_Func->CurrentValue);
			$this->Cantidad_Ap_Func->PlaceHolder = ew_RemoveHtml($this->Cantidad_Ap_Func->FldCaption());

			// Ups
			$this->Ups->EditCustomAttributes = "";
			$this->Ups->EditValue = $this->Ups->Options(FALSE);

			// Estado_Ups
			$this->Estado_Ups->EditAttrs["class"] = "form-control";
			$this->Estado_Ups->EditCustomAttributes = "";
			if (trim(strval($this->Estado_Ups->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Estado_Equipo_piso`" . ew_SearchString("=", $this->Estado_Ups->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Estado_Equipo_piso`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `estado_equipos_piso`";
			$sWhereWrk = "";
			$this->Estado_Ups->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Estado_Ups, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Estado_Ups->EditValue = $arwrk;

			// Cableado
			$this->Cableado->EditCustomAttributes = "";
			$this->Cableado->EditValue = $this->Cableado->Options(FALSE);

			// Estado_Cableado
			$this->Estado_Cableado->EditAttrs["class"] = "form-control";
			$this->Estado_Cableado->EditCustomAttributes = "";
			if (trim(strval($this->Estado_Cableado->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Estado_Equipo_piso`" . ew_SearchString("=", $this->Estado_Cableado->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Estado_Equipo_piso`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `estado_equipos_piso`";
			$sWhereWrk = "";
			$this->Estado_Cableado->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Estado_Cableado, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Estado_Cableado->EditValue = $arwrk;

			// Porcent_Estado_Cab
			$this->Porcent_Estado_Cab->EditAttrs["class"] = "form-control";
			$this->Porcent_Estado_Cab->EditCustomAttributes = "";
			$this->Porcent_Estado_Cab->EditValue = ew_HtmlEncode($this->Porcent_Estado_Cab->CurrentValue);
			$this->Porcent_Estado_Cab->PlaceHolder = ew_RemoveHtml($this->Porcent_Estado_Cab->FldCaption());

			// Porcent_Func_Piso
			$this->Porcent_Func_Piso->EditAttrs["class"] = "form-control";
			$this->Porcent_Func_Piso->EditCustomAttributes = "";
			$this->Porcent_Func_Piso->EditValue = ew_HtmlEncode($this->Porcent_Func_Piso->CurrentValue);
			$this->Porcent_Func_Piso->PlaceHolder = ew_RemoveHtml($this->Porcent_Func_Piso->FldCaption());

			// Plano_Escuela
			$this->Plano_Escuela->EditAttrs["class"] = "form-control";
			$this->Plano_Escuela->EditCustomAttributes = "";
			if (!ew_Empty($this->Plano_Escuela->Upload->DbValue)) {
				$this->Plano_Escuela->EditValue = $this->Plano_Escuela->Upload->DbValue;
			} else {
				$this->Plano_Escuela->EditValue = "";
			}
			if (!ew_Empty($this->Plano_Escuela->CurrentValue))
				$this->Plano_Escuela->Upload->FileName = $this->Plano_Escuela->CurrentValue;
			if (is_numeric($this->RowIndex) && !$this->EventCancelled) ew_RenderUploadField($this->Plano_Escuela, $this->RowIndex);

			// Fecha_Actualizacion
			// Usuario
			// Add refer script
			// Switch

			$this->Switch->LinkCustomAttributes = "";
			$this->Switch->HrefValue = "";

			// Bocas_Switch
			$this->Bocas_Switch->LinkCustomAttributes = "";
			$this->Bocas_Switch->HrefValue = "";

			// Estado_Switch
			$this->Estado_Switch->LinkCustomAttributes = "";
			$this->Estado_Switch->HrefValue = "";

			// Cantidad_Ap
			$this->Cantidad_Ap->LinkCustomAttributes = "";
			$this->Cantidad_Ap->HrefValue = "";

			// Cantidad_Ap_Func
			$this->Cantidad_Ap_Func->LinkCustomAttributes = "";
			$this->Cantidad_Ap_Func->HrefValue = "";

			// Ups
			$this->Ups->LinkCustomAttributes = "";
			$this->Ups->HrefValue = "";

			// Estado_Ups
			$this->Estado_Ups->LinkCustomAttributes = "";
			$this->Estado_Ups->HrefValue = "";

			// Cableado
			$this->Cableado->LinkCustomAttributes = "";
			$this->Cableado->HrefValue = "";

			// Estado_Cableado
			$this->Estado_Cableado->LinkCustomAttributes = "";
			$this->Estado_Cableado->HrefValue = "";

			// Porcent_Estado_Cab
			$this->Porcent_Estado_Cab->LinkCustomAttributes = "";
			$this->Porcent_Estado_Cab->HrefValue = "";

			// Porcent_Func_Piso
			$this->Porcent_Func_Piso->LinkCustomAttributes = "";
			$this->Porcent_Func_Piso->HrefValue = "";

			// Plano_Escuela
			$this->Plano_Escuela->LinkCustomAttributes = "";
			$this->Plano_Escuela->HrefValue = "";
			$this->Plano_Escuela->HrefValue2 = $this->Plano_Escuela->UploadPath . $this->Plano_Escuela->Upload->DbValue;

			// Fecha_Actualizacion
			$this->Fecha_Actualizacion->LinkCustomAttributes = "";
			$this->Fecha_Actualizacion->HrefValue = "";

			// Usuario
			$this->Usuario->LinkCustomAttributes = "";
			$this->Usuario->HrefValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// Switch
			$this->Switch->EditCustomAttributes = "";
			$this->Switch->EditValue = $this->Switch->Options(FALSE);

			// Bocas_Switch
			$this->Bocas_Switch->EditAttrs["class"] = "form-control";
			$this->Bocas_Switch->EditCustomAttributes = "";
			$this->Bocas_Switch->EditValue = ew_HtmlEncode($this->Bocas_Switch->CurrentValue);
			$this->Bocas_Switch->PlaceHolder = ew_RemoveHtml($this->Bocas_Switch->FldCaption());

			// Estado_Switch
			$this->Estado_Switch->EditAttrs["class"] = "form-control";
			$this->Estado_Switch->EditCustomAttributes = "";
			if (trim(strval($this->Estado_Switch->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Estado_Equipo_piso`" . ew_SearchString("=", $this->Estado_Switch->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Estado_Equipo_piso`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `estado_equipos_piso`";
			$sWhereWrk = "";
			$this->Estado_Switch->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Estado_Switch, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Descripcion` ASC";
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Estado_Switch->EditValue = $arwrk;

			// Cantidad_Ap
			$this->Cantidad_Ap->EditAttrs["class"] = "form-control";
			$this->Cantidad_Ap->EditCustomAttributes = "";
			$this->Cantidad_Ap->EditValue = ew_HtmlEncode($this->Cantidad_Ap->CurrentValue);
			$this->Cantidad_Ap->PlaceHolder = ew_RemoveHtml($this->Cantidad_Ap->FldCaption());

			// Cantidad_Ap_Func
			$this->Cantidad_Ap_Func->EditAttrs["class"] = "form-control";
			$this->Cantidad_Ap_Func->EditCustomAttributes = "";
			$this->Cantidad_Ap_Func->EditValue = ew_HtmlEncode($this->Cantidad_Ap_Func->CurrentValue);
			$this->Cantidad_Ap_Func->PlaceHolder = ew_RemoveHtml($this->Cantidad_Ap_Func->FldCaption());

			// Ups
			$this->Ups->EditCustomAttributes = "";
			$this->Ups->EditValue = $this->Ups->Options(FALSE);

			// Estado_Ups
			$this->Estado_Ups->EditAttrs["class"] = "form-control";
			$this->Estado_Ups->EditCustomAttributes = "";
			if (trim(strval($this->Estado_Ups->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Estado_Equipo_piso`" . ew_SearchString("=", $this->Estado_Ups->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Estado_Equipo_piso`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `estado_equipos_piso`";
			$sWhereWrk = "";
			$this->Estado_Ups->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Estado_Ups, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Estado_Ups->EditValue = $arwrk;

			// Cableado
			$this->Cableado->EditCustomAttributes = "";
			$this->Cableado->EditValue = $this->Cableado->Options(FALSE);

			// Estado_Cableado
			$this->Estado_Cableado->EditAttrs["class"] = "form-control";
			$this->Estado_Cableado->EditCustomAttributes = "";
			if (trim(strval($this->Estado_Cableado->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Estado_Equipo_piso`" . ew_SearchString("=", $this->Estado_Cableado->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Estado_Equipo_piso`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `estado_equipos_piso`";
			$sWhereWrk = "";
			$this->Estado_Cableado->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Estado_Cableado, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Estado_Cableado->EditValue = $arwrk;

			// Porcent_Estado_Cab
			$this->Porcent_Estado_Cab->EditAttrs["class"] = "form-control";
			$this->Porcent_Estado_Cab->EditCustomAttributes = "";
			$this->Porcent_Estado_Cab->EditValue = ew_HtmlEncode($this->Porcent_Estado_Cab->CurrentValue);
			$this->Porcent_Estado_Cab->PlaceHolder = ew_RemoveHtml($this->Porcent_Estado_Cab->FldCaption());

			// Porcent_Func_Piso
			$this->Porcent_Func_Piso->EditAttrs["class"] = "form-control";
			$this->Porcent_Func_Piso->EditCustomAttributes = "";
			$this->Porcent_Func_Piso->EditValue = ew_HtmlEncode($this->Porcent_Func_Piso->CurrentValue);
			$this->Porcent_Func_Piso->PlaceHolder = ew_RemoveHtml($this->Porcent_Func_Piso->FldCaption());

			// Plano_Escuela
			$this->Plano_Escuela->EditAttrs["class"] = "form-control";
			$this->Plano_Escuela->EditCustomAttributes = "";
			if (!ew_Empty($this->Plano_Escuela->Upload->DbValue)) {
				$this->Plano_Escuela->EditValue = $this->Plano_Escuela->Upload->DbValue;
			} else {
				$this->Plano_Escuela->EditValue = "";
			}
			if (!ew_Empty($this->Plano_Escuela->CurrentValue))
				$this->Plano_Escuela->Upload->FileName = $this->Plano_Escuela->CurrentValue;
			if (is_numeric($this->RowIndex) && !$this->EventCancelled) ew_RenderUploadField($this->Plano_Escuela, $this->RowIndex);

			// Fecha_Actualizacion
			// Usuario
			// Edit refer script
			// Switch

			$this->Switch->LinkCustomAttributes = "";
			$this->Switch->HrefValue = "";

			// Bocas_Switch
			$this->Bocas_Switch->LinkCustomAttributes = "";
			$this->Bocas_Switch->HrefValue = "";

			// Estado_Switch
			$this->Estado_Switch->LinkCustomAttributes = "";
			$this->Estado_Switch->HrefValue = "";

			// Cantidad_Ap
			$this->Cantidad_Ap->LinkCustomAttributes = "";
			$this->Cantidad_Ap->HrefValue = "";

			// Cantidad_Ap_Func
			$this->Cantidad_Ap_Func->LinkCustomAttributes = "";
			$this->Cantidad_Ap_Func->HrefValue = "";

			// Ups
			$this->Ups->LinkCustomAttributes = "";
			$this->Ups->HrefValue = "";

			// Estado_Ups
			$this->Estado_Ups->LinkCustomAttributes = "";
			$this->Estado_Ups->HrefValue = "";

			// Cableado
			$this->Cableado->LinkCustomAttributes = "";
			$this->Cableado->HrefValue = "";

			// Estado_Cableado
			$this->Estado_Cableado->LinkCustomAttributes = "";
			$this->Estado_Cableado->HrefValue = "";

			// Porcent_Estado_Cab
			$this->Porcent_Estado_Cab->LinkCustomAttributes = "";
			$this->Porcent_Estado_Cab->HrefValue = "";

			// Porcent_Func_Piso
			$this->Porcent_Func_Piso->LinkCustomAttributes = "";
			$this->Porcent_Func_Piso->HrefValue = "";

			// Plano_Escuela
			$this->Plano_Escuela->LinkCustomAttributes = "";
			$this->Plano_Escuela->HrefValue = "";
			$this->Plano_Escuela->HrefValue2 = $this->Plano_Escuela->UploadPath . $this->Plano_Escuela->Upload->DbValue;

			// Fecha_Actualizacion
			$this->Fecha_Actualizacion->LinkCustomAttributes = "";
			$this->Fecha_Actualizacion->HrefValue = "";

			// Usuario
			$this->Usuario->LinkCustomAttributes = "";
			$this->Usuario->HrefValue = "";
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
		if ($this->Switch->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Switch->FldCaption(), $this->Switch->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->Bocas_Switch->FormValue)) {
			ew_AddMessage($gsFormError, $this->Bocas_Switch->FldErrMsg());
		}
		if (!$this->Estado_Switch->FldIsDetailKey && !is_null($this->Estado_Switch->FormValue) && $this->Estado_Switch->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Estado_Switch->FldCaption(), $this->Estado_Switch->ReqErrMsg));
		}
		if (!$this->Cantidad_Ap->FldIsDetailKey && !is_null($this->Cantidad_Ap->FormValue) && $this->Cantidad_Ap->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Cantidad_Ap->FldCaption(), $this->Cantidad_Ap->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->Cantidad_Ap->FormValue)) {
			ew_AddMessage($gsFormError, $this->Cantidad_Ap->FldErrMsg());
		}
		if (!ew_CheckInteger($this->Cantidad_Ap_Func->FormValue)) {
			ew_AddMessage($gsFormError, $this->Cantidad_Ap_Func->FldErrMsg());
		}
		if ($this->Ups->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Ups->FldCaption(), $this->Ups->ReqErrMsg));
		}
		if (!$this->Estado_Ups->FldIsDetailKey && !is_null($this->Estado_Ups->FormValue) && $this->Estado_Ups->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Estado_Ups->FldCaption(), $this->Estado_Ups->ReqErrMsg));
		}
		if ($this->Cableado->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Cableado->FldCaption(), $this->Cableado->ReqErrMsg));
		}
		if (!$this->Estado_Cableado->FldIsDetailKey && !is_null($this->Estado_Cableado->FormValue) && $this->Estado_Cableado->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Estado_Cableado->FldCaption(), $this->Estado_Cableado->ReqErrMsg));
		}
		if (!ew_CheckInteger($this->Porcent_Estado_Cab->FormValue)) {
			ew_AddMessage($gsFormError, $this->Porcent_Estado_Cab->FldErrMsg());
		}
		if (!ew_CheckInteger($this->Porcent_Func_Piso->FormValue)) {
			ew_AddMessage($gsFormError, $this->Porcent_Func_Piso->FldErrMsg());
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
				$sThisKey .= $row['Cue'];
				$this->LoadDbValues($row);
				$OldFiles = explode(EW_MULTIPLE_UPLOAD_SEPARATOR, $row['Plano_Escuela']);
				$FileCount = count($OldFiles);
				for ($i = 0; $i < $FileCount; $i++) {
					@unlink(ew_UploadPathEx(TRUE, $this->Plano_Escuela->OldUploadPath) . $OldFiles[$i]);
				}
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

			// Switch
			$this->Switch->SetDbValueDef($rsnew, $this->Switch->CurrentValue, NULL, $this->Switch->ReadOnly);

			// Bocas_Switch
			$this->Bocas_Switch->SetDbValueDef($rsnew, $this->Bocas_Switch->CurrentValue, NULL, $this->Bocas_Switch->ReadOnly);

			// Estado_Switch
			$this->Estado_Switch->SetDbValueDef($rsnew, $this->Estado_Switch->CurrentValue, NULL, $this->Estado_Switch->ReadOnly);

			// Cantidad_Ap
			$this->Cantidad_Ap->SetDbValueDef($rsnew, $this->Cantidad_Ap->CurrentValue, NULL, $this->Cantidad_Ap->ReadOnly);

			// Cantidad_Ap_Func
			$this->Cantidad_Ap_Func->SetDbValueDef($rsnew, $this->Cantidad_Ap_Func->CurrentValue, NULL, $this->Cantidad_Ap_Func->ReadOnly);

			// Ups
			$this->Ups->SetDbValueDef($rsnew, $this->Ups->CurrentValue, NULL, $this->Ups->ReadOnly);

			// Estado_Ups
			$this->Estado_Ups->SetDbValueDef($rsnew, $this->Estado_Ups->CurrentValue, NULL, $this->Estado_Ups->ReadOnly);

			// Cableado
			$this->Cableado->SetDbValueDef($rsnew, $this->Cableado->CurrentValue, NULL, $this->Cableado->ReadOnly);

			// Estado_Cableado
			$this->Estado_Cableado->SetDbValueDef($rsnew, $this->Estado_Cableado->CurrentValue, NULL, $this->Estado_Cableado->ReadOnly);

			// Porcent_Estado_Cab
			$this->Porcent_Estado_Cab->SetDbValueDef($rsnew, $this->Porcent_Estado_Cab->CurrentValue, NULL, $this->Porcent_Estado_Cab->ReadOnly);

			// Porcent_Func_Piso
			$this->Porcent_Func_Piso->SetDbValueDef($rsnew, $this->Porcent_Func_Piso->CurrentValue, NULL, $this->Porcent_Func_Piso->ReadOnly);

			// Plano_Escuela
			if ($this->Plano_Escuela->Visible && !$this->Plano_Escuela->ReadOnly && !$this->Plano_Escuela->Upload->KeepFile) {
				$this->Plano_Escuela->Upload->DbValue = $rsold['Plano_Escuela']; // Get original value
				if ($this->Plano_Escuela->Upload->FileName == "") {
					$rsnew['Plano_Escuela'] = NULL;
				} else {
					$rsnew['Plano_Escuela'] = $this->Plano_Escuela->Upload->FileName;
				}
			}

			// Fecha_Actualizacion
			$this->Fecha_Actualizacion->SetDbValueDef($rsnew, ew_CurrentDate(), NULL);
			$rsnew['Fecha_Actualizacion'] = &$this->Fecha_Actualizacion->DbValue;

			// Usuario
			$this->Usuario->SetDbValueDef($rsnew, CurrentUserName(), NULL);
			$rsnew['Usuario'] = &$this->Usuario->DbValue;
			if ($this->Plano_Escuela->Visible && !$this->Plano_Escuela->Upload->KeepFile) {
				$OldFiles = explode(EW_MULTIPLE_UPLOAD_SEPARATOR, $this->Plano_Escuela->Upload->DbValue);
				if (!ew_Empty($this->Plano_Escuela->Upload->FileName)) {
					$NewFiles = explode(EW_MULTIPLE_UPLOAD_SEPARATOR, $this->Plano_Escuela->Upload->FileName);
					$FileCount = count($NewFiles);
					for ($i = 0; $i < $FileCount; $i++) {
						$fldvar = ($this->Plano_Escuela->Upload->Index < 0) ? $this->Plano_Escuela->FldVar : substr($this->Plano_Escuela->FldVar, 0, 1) . $this->Plano_Escuela->Upload->Index . substr($this->Plano_Escuela->FldVar, 1);
						if ($NewFiles[$i] <> "") {
							$file = $NewFiles[$i];
							if (file_exists(ew_UploadTempPath($fldvar, $this->Plano_Escuela->TblVar) . EW_PATH_DELIMITER . $file)) {
								if (!in_array($file, $OldFiles)) {
									$file1 = ew_UploadFileNameEx(ew_UploadPathEx(TRUE, $this->Plano_Escuela->UploadPath), $file); // Get new file name
									if ($file1 <> $file) { // Rename temp file
										while (file_exists(ew_UploadTempPath($fldvar, $this->Plano_Escuela->TblVar) . EW_PATH_DELIMITER . $file1)) // Make sure did not clash with existing upload file
											$file1 = ew_UniqueFilename(ew_UploadPathEx(TRUE, $this->Plano_Escuela->UploadPath), $file1, TRUE); // Use indexed name
										rename(ew_UploadTempPath($fldvar, $this->Plano_Escuela->TblVar) . EW_PATH_DELIMITER . $file, ew_UploadTempPath($fldvar, $this->Plano_Escuela->TblVar) . EW_PATH_DELIMITER . $file1);
										$NewFiles[$i] = $file1;
									}
								}
							}
						}
					}
					$this->Plano_Escuela->Upload->FileName = implode(EW_MULTIPLE_UPLOAD_SEPARATOR, $NewFiles);
					$rsnew['Plano_Escuela'] = $this->Plano_Escuela->Upload->FileName;
				} else {
					$NewFiles = array();
				}
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
					if ($this->Plano_Escuela->Visible && !$this->Plano_Escuela->Upload->KeepFile) {
						$OldFiles = explode(EW_MULTIPLE_UPLOAD_SEPARATOR, $this->Plano_Escuela->Upload->DbValue);
						if (!ew_Empty($this->Plano_Escuela->Upload->FileName)) {
							$NewFiles = explode(EW_MULTIPLE_UPLOAD_SEPARATOR, $this->Plano_Escuela->Upload->FileName);
							$NewFiles2 = explode(EW_MULTIPLE_UPLOAD_SEPARATOR, $rsnew['Plano_Escuela']);
							$FileCount = count($NewFiles);
							for ($i = 0; $i < $FileCount; $i++) {
								$fldvar = ($this->Plano_Escuela->Upload->Index < 0) ? $this->Plano_Escuela->FldVar : substr($this->Plano_Escuela->FldVar, 0, 1) . $this->Plano_Escuela->Upload->Index . substr($this->Plano_Escuela->FldVar, 1);
								if ($NewFiles[$i] <> "") {
									$file = ew_UploadTempPath($fldvar, $this->Plano_Escuela->TblVar) . EW_PATH_DELIMITER . $NewFiles[$i];
									if (file_exists($file)) {
										$this->Plano_Escuela->Upload->SaveToFile($this->Plano_Escuela->UploadPath, (@$NewFiles2[$i] <> "") ? $NewFiles2[$i] : $NewFiles[$i], TRUE, $i); // Just replace
									}
								}
							}
						} else {
							$NewFiles = array();
						}
						$FileCount = count($OldFiles);
						for ($i = 0; $i < $FileCount; $i++) {
							if ($OldFiles[$i] <> "" && !in_array($OldFiles[$i], $NewFiles))
								@unlink(ew_UploadPathEx(TRUE, $this->Plano_Escuela->OldUploadPath) . $OldFiles[$i]);
						}
					}
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

		// Plano_Escuela
		ew_CleanUploadTempPath($this->Plano_Escuela, $this->Plano_Escuela->Upload->Index);
		return $EditRow;
	}

	// Add record
	function AddRow($rsold = NULL) {
		global $Language, $Security;
		$conn = &$this->Connection();

		// Load db values from rsold
		if ($rsold) {
			$this->LoadDbValues($rsold);
		}
		$rsnew = array();

		// Switch
		$this->Switch->SetDbValueDef($rsnew, $this->Switch->CurrentValue, NULL, FALSE);

		// Bocas_Switch
		$this->Bocas_Switch->SetDbValueDef($rsnew, $this->Bocas_Switch->CurrentValue, NULL, FALSE);

		// Estado_Switch
		$this->Estado_Switch->SetDbValueDef($rsnew, $this->Estado_Switch->CurrentValue, NULL, FALSE);

		// Cantidad_Ap
		$this->Cantidad_Ap->SetDbValueDef($rsnew, $this->Cantidad_Ap->CurrentValue, NULL, FALSE);

		// Cantidad_Ap_Func
		$this->Cantidad_Ap_Func->SetDbValueDef($rsnew, $this->Cantidad_Ap_Func->CurrentValue, NULL, FALSE);

		// Ups
		$this->Ups->SetDbValueDef($rsnew, $this->Ups->CurrentValue, NULL, FALSE);

		// Estado_Ups
		$this->Estado_Ups->SetDbValueDef($rsnew, $this->Estado_Ups->CurrentValue, NULL, FALSE);

		// Cableado
		$this->Cableado->SetDbValueDef($rsnew, $this->Cableado->CurrentValue, NULL, FALSE);

		// Estado_Cableado
		$this->Estado_Cableado->SetDbValueDef($rsnew, $this->Estado_Cableado->CurrentValue, NULL, FALSE);

		// Porcent_Estado_Cab
		$this->Porcent_Estado_Cab->SetDbValueDef($rsnew, $this->Porcent_Estado_Cab->CurrentValue, NULL, FALSE);

		// Porcent_Func_Piso
		$this->Porcent_Func_Piso->SetDbValueDef($rsnew, $this->Porcent_Func_Piso->CurrentValue, NULL, FALSE);

		// Plano_Escuela
		if ($this->Plano_Escuela->Visible && !$this->Plano_Escuela->Upload->KeepFile) {
			$this->Plano_Escuela->Upload->DbValue = ""; // No need to delete old file
			if ($this->Plano_Escuela->Upload->FileName == "") {
				$rsnew['Plano_Escuela'] = NULL;
			} else {
				$rsnew['Plano_Escuela'] = $this->Plano_Escuela->Upload->FileName;
			}
		}

		// Fecha_Actualizacion
		$this->Fecha_Actualizacion->SetDbValueDef($rsnew, ew_CurrentDate(), NULL);
		$rsnew['Fecha_Actualizacion'] = &$this->Fecha_Actualizacion->DbValue;

		// Usuario
		$this->Usuario->SetDbValueDef($rsnew, CurrentUserName(), NULL);
		$rsnew['Usuario'] = &$this->Usuario->DbValue;

		// Cue
		if ($this->Cue->getSessionValue() <> "") {
			$rsnew['Cue'] = $this->Cue->getSessionValue();
		}
		if ($this->Plano_Escuela->Visible && !$this->Plano_Escuela->Upload->KeepFile) {
			$OldFiles = explode(EW_MULTIPLE_UPLOAD_SEPARATOR, $this->Plano_Escuela->Upload->DbValue);
			if (!ew_Empty($this->Plano_Escuela->Upload->FileName)) {
				$NewFiles = explode(EW_MULTIPLE_UPLOAD_SEPARATOR, $this->Plano_Escuela->Upload->FileName);
				$FileCount = count($NewFiles);
				for ($i = 0; $i < $FileCount; $i++) {
					$fldvar = ($this->Plano_Escuela->Upload->Index < 0) ? $this->Plano_Escuela->FldVar : substr($this->Plano_Escuela->FldVar, 0, 1) . $this->Plano_Escuela->Upload->Index . substr($this->Plano_Escuela->FldVar, 1);
					if ($NewFiles[$i] <> "") {
						$file = $NewFiles[$i];
						if (file_exists(ew_UploadTempPath($fldvar, $this->Plano_Escuela->TblVar) . EW_PATH_DELIMITER . $file)) {
							if (!in_array($file, $OldFiles)) {
								$file1 = ew_UploadFileNameEx(ew_UploadPathEx(TRUE, $this->Plano_Escuela->UploadPath), $file); // Get new file name
								if ($file1 <> $file) { // Rename temp file
									while (file_exists(ew_UploadTempPath($fldvar, $this->Plano_Escuela->TblVar) . EW_PATH_DELIMITER . $file1)) // Make sure did not clash with existing upload file
										$file1 = ew_UniqueFilename(ew_UploadPathEx(TRUE, $this->Plano_Escuela->UploadPath), $file1, TRUE); // Use indexed name
									rename(ew_UploadTempPath($fldvar, $this->Plano_Escuela->TblVar) . EW_PATH_DELIMITER . $file, ew_UploadTempPath($fldvar, $this->Plano_Escuela->TblVar) . EW_PATH_DELIMITER . $file1);
									$NewFiles[$i] = $file1;
								}
							}
						}
					}
				}
				$this->Plano_Escuela->Upload->FileName = implode(EW_MULTIPLE_UPLOAD_SEPARATOR, $NewFiles);
				$rsnew['Plano_Escuela'] = $this->Plano_Escuela->Upload->FileName;
			} else {
				$NewFiles = array();
			}
		}

		// Call Row Inserting event
		$rs = ($rsold == NULL) ? NULL : $rsold->fields;
		$bInsertRow = $this->Row_Inserting($rs, $rsnew);

		// Check if key value entered
		if ($bInsertRow && $this->ValidateKey && strval($rsnew['Cue']) == "") {
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
				if ($this->Plano_Escuela->Visible && !$this->Plano_Escuela->Upload->KeepFile) {
					$OldFiles = explode(EW_MULTIPLE_UPLOAD_SEPARATOR, $this->Plano_Escuela->Upload->DbValue);
					if (!ew_Empty($this->Plano_Escuela->Upload->FileName)) {
						$NewFiles = explode(EW_MULTIPLE_UPLOAD_SEPARATOR, $this->Plano_Escuela->Upload->FileName);
						$NewFiles2 = explode(EW_MULTIPLE_UPLOAD_SEPARATOR, $rsnew['Plano_Escuela']);
						$FileCount = count($NewFiles);
						for ($i = 0; $i < $FileCount; $i++) {
							$fldvar = ($this->Plano_Escuela->Upload->Index < 0) ? $this->Plano_Escuela->FldVar : substr($this->Plano_Escuela->FldVar, 0, 1) . $this->Plano_Escuela->Upload->Index . substr($this->Plano_Escuela->FldVar, 1);
							if ($NewFiles[$i] <> "") {
								$file = ew_UploadTempPath($fldvar, $this->Plano_Escuela->TblVar) . EW_PATH_DELIMITER . $NewFiles[$i];
								if (file_exists($file)) {
									$this->Plano_Escuela->Upload->SaveToFile($this->Plano_Escuela->UploadPath, (@$NewFiles2[$i] <> "") ? $NewFiles2[$i] : $NewFiles[$i], TRUE, $i); // Just replace
								}
							}
						}
					} else {
						$NewFiles = array();
					}
					$FileCount = count($OldFiles);
					for ($i = 0; $i < $FileCount; $i++) {
						if ($OldFiles[$i] <> "" && !in_array($OldFiles[$i], $NewFiles))
							@unlink(ew_UploadPathEx(TRUE, $this->Plano_Escuela->OldUploadPath) . $OldFiles[$i]);
					}
				}
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

		// Plano_Escuela
		ew_CleanUploadTempPath($this->Plano_Escuela, $this->Plano_Escuela->Upload->Index);
		return $AddRow;
	}

	// Load advanced search
	function LoadAdvancedSearch() {
		$this->Switch->AdvancedSearch->Load();
		$this->Bocas_Switch->AdvancedSearch->Load();
		$this->Estado_Switch->AdvancedSearch->Load();
		$this->Cantidad_Ap->AdvancedSearch->Load();
		$this->Cantidad_Ap_Func->AdvancedSearch->Load();
		$this->Ups->AdvancedSearch->Load();
		$this->Estado_Ups->AdvancedSearch->Load();
		$this->Marca_Modelo_Serie_Ups->AdvancedSearch->Load();
		$this->Cableado->AdvancedSearch->Load();
		$this->Estado_Cableado->AdvancedSearch->Load();
		$this->Porcent_Estado_Cab->AdvancedSearch->Load();
		$this->Porcent_Func_Piso->AdvancedSearch->Load();
		$this->Plano_Escuela->AdvancedSearch->Load();
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
		$item->Body = "<button id=\"emf_piso_tecnologico\" class=\"ewExportLink ewEmail\" title=\"" . $Language->Phrase("ExportToEmailText") . "\" data-caption=\"" . $Language->Phrase("ExportToEmailText") . "\" onclick=\"ew_EmailDialogShow({lnk:'emf_piso_tecnologico',hdr:ewLanguage.Phrase('ExportToEmailText'),f:document.fpiso_tecnologicolist,sel:false" . $url . "});\">" . $Language->Phrase("ExportToEmail") . "</button>";
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
		if (EW_EXPORT_MASTER_RECORD && $this->GetMasterFilter() <> "" && $this->getCurrentMasterTable() == "dato_establecimiento") {
			global $dato_establecimiento;
			if (!isset($dato_establecimiento)) $dato_establecimiento = new cdato_establecimiento;
			$rsmaster = $dato_establecimiento->LoadRs($this->DbMasterFilter); // Load master record
			if ($rsmaster && !$rsmaster->EOF) {
				$ExportStyle = $Doc->Style;
				$Doc->SetStyle("v"); // Change to vertical
				if ($this->Export <> "csv" || EW_EXPORT_MASTER_RECORD_FOR_CSV) {
					$Doc->Table = &$dato_establecimiento;
					$dato_establecimiento->ExportDocument($Doc, $rsmaster, 1, 1);
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
			if ($sMasterTblVar == "dato_establecimiento") {
				$bValidMaster = TRUE;
				if (@$_GET["fk_Cue"] <> "") {
					$GLOBALS["dato_establecimiento"]->Cue->setQueryStringValue($_GET["fk_Cue"]);
					$this->Cue->setQueryStringValue($GLOBALS["dato_establecimiento"]->Cue->QueryStringValue);
					$this->Cue->setSessionValue($this->Cue->QueryStringValue);
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
			if ($sMasterTblVar == "dato_establecimiento") {
				$bValidMaster = TRUE;
				if (@$_POST["fk_Cue"] <> "") {
					$GLOBALS["dato_establecimiento"]->Cue->setFormValue($_POST["fk_Cue"]);
					$this->Cue->setFormValue($GLOBALS["dato_establecimiento"]->Cue->FormValue);
					$this->Cue->setSessionValue($this->Cue->FormValue);
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
			if ($sMasterTblVar <> "dato_establecimiento") {
				if ($this->Cue->CurrentValue == "") $this->Cue->setSessionValue("");
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
		case "x_Estado_Switch":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_Estado_Equipo_piso` AS `LinkFld`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `estado_equipos_piso`";
			$sWhereWrk = "";
			$this->Estado_Switch->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_Estado_Equipo_piso` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Estado_Switch, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " ORDER BY `Descripcion` ASC";
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Estado_Ups":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_Estado_Equipo_piso` AS `LinkFld`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `estado_equipos_piso`";
			$sWhereWrk = "";
			$this->Estado_Ups->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_Estado_Equipo_piso` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Estado_Ups, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Estado_Cableado":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_Estado_Equipo_piso` AS `LinkFld`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `estado_equipos_piso`";
			$sWhereWrk = "";
			$this->Estado_Cableado->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_Estado_Equipo_piso` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Estado_Cableado, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
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
		$table = 'piso_tecnologico';
		$usr = CurrentUserID();
		ew_WriteAuditTrail("log", ew_StdCurrentDateTime(), ew_ScriptName(), $usr, $typ, $table, "", "", "", "");
	}

	// Write Audit Trail (add page)
	function WriteAuditTrailOnAdd(&$rs) {
		global $Language;
		if (!$this->AuditTrailOnAdd) return;
		$table = 'piso_tecnologico';

		// Get key value
		$key = "";
		if ($key <> "") $key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rs['Cue'];

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
		$table = 'piso_tecnologico';

		// Get key value
		$key = "";
		if ($key <> "") $key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rsold['Cue'];

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
		$table = 'piso_tecnologico';

		// Get key value
		$key = "";
		if ($key <> "")
			$key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rs['Cue'];

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
if (!isset($piso_tecnologico_list)) $piso_tecnologico_list = new cpiso_tecnologico_list();

// Page init
$piso_tecnologico_list->Page_Init();

// Page main
$piso_tecnologico_list->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$piso_tecnologico_list->Page_Render();
?>
<?php include_once "header.php" ?>
<?php if ($piso_tecnologico->Export == "") { ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "list";
var CurrentForm = fpiso_tecnologicolist = new ew_Form("fpiso_tecnologicolist", "list");
fpiso_tecnologicolist.FormKeyCountName = '<?php echo $piso_tecnologico_list->FormKeyCountName ?>';

// Validate form
fpiso_tecnologicolist.Validate = function() {
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
			elm = this.GetElements("x" + infix + "_Switch");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $piso_tecnologico->Switch->FldCaption(), $piso_tecnologico->Switch->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Bocas_Switch");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($piso_tecnologico->Bocas_Switch->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Estado_Switch");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $piso_tecnologico->Estado_Switch->FldCaption(), $piso_tecnologico->Estado_Switch->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Cantidad_Ap");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $piso_tecnologico->Cantidad_Ap->FldCaption(), $piso_tecnologico->Cantidad_Ap->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Cantidad_Ap");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($piso_tecnologico->Cantidad_Ap->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Cantidad_Ap_Func");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($piso_tecnologico->Cantidad_Ap_Func->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Ups");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $piso_tecnologico->Ups->FldCaption(), $piso_tecnologico->Ups->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Estado_Ups");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $piso_tecnologico->Estado_Ups->FldCaption(), $piso_tecnologico->Estado_Ups->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Cableado");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $piso_tecnologico->Cableado->FldCaption(), $piso_tecnologico->Cableado->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Estado_Cableado");
			if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
				return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $piso_tecnologico->Estado_Cableado->FldCaption(), $piso_tecnologico->Estado_Cableado->ReqErrMsg)) ?>");
			elm = this.GetElements("x" + infix + "_Porcent_Estado_Cab");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($piso_tecnologico->Porcent_Estado_Cab->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Porcent_Func_Piso");
			if (elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($piso_tecnologico->Porcent_Func_Piso->FldErrMsg()) ?>");

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
fpiso_tecnologicolist.EmptyRow = function(infix) {
	var fobj = this.Form;
	if (ew_ValueChanged(fobj, infix, "Switch", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Bocas_Switch", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Estado_Switch", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Cantidad_Ap", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Cantidad_Ap_Func", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Ups", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Estado_Ups", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Cableado", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Estado_Cableado", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Porcent_Estado_Cab", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Porcent_Func_Piso", false)) return false;
	if (ew_ValueChanged(fobj, infix, "Plano_Escuela", false)) return false;
	return true;
}

// Form_CustomValidate event
fpiso_tecnologicolist.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
fpiso_tecnologicolist.ValidateRequired = true;
<?php } else { ?>
fpiso_tecnologicolist.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
fpiso_tecnologicolist.Lists["x_Switch"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fpiso_tecnologicolist.Lists["x_Switch"].Options = <?php echo json_encode($piso_tecnologico->Switch->Options()) ?>;
fpiso_tecnologicolist.Lists["x_Estado_Switch"] = {"LinkField":"x_Id_Estado_Equipo_piso","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"estado_equipos_piso"};
fpiso_tecnologicolist.Lists["x_Ups"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fpiso_tecnologicolist.Lists["x_Ups"].Options = <?php echo json_encode($piso_tecnologico->Ups->Options()) ?>;
fpiso_tecnologicolist.Lists["x_Estado_Ups"] = {"LinkField":"x_Id_Estado_Equipo_piso","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"estado_equipos_piso"};
fpiso_tecnologicolist.Lists["x_Cableado"] = {"LinkField":"","Ajax":null,"AutoFill":false,"DisplayFields":["","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":""};
fpiso_tecnologicolist.Lists["x_Cableado"].Options = <?php echo json_encode($piso_tecnologico->Cableado->Options()) ?>;
fpiso_tecnologicolist.Lists["x_Estado_Cableado"] = {"LinkField":"x_Id_Estado_Equipo_piso","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"estado_equipos_piso"};

// Form object for search
var CurrentSearchForm = fpiso_tecnologicolistsrch = new ew_Form("fpiso_tecnologicolistsrch");
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<?php if ($piso_tecnologico->Export == "") { ?>
<div class="ewToolbar">
<?php if ($piso_tecnologico->Export == "") { ?>
<?php $Breadcrumb->Render(); ?>
<?php } ?>
<?php if ($piso_tecnologico_list->TotalRecs > 0 && $piso_tecnologico_list->ExportOptions->Visible()) { ?>
<?php $piso_tecnologico_list->ExportOptions->Render("body") ?>
<?php } ?>
<?php if ($piso_tecnologico_list->SearchOptions->Visible()) { ?>
<?php $piso_tecnologico_list->SearchOptions->Render("body") ?>
<?php } ?>
<?php if ($piso_tecnologico_list->FilterOptions->Visible()) { ?>
<?php $piso_tecnologico_list->FilterOptions->Render("body") ?>
<?php } ?>
<?php if ($piso_tecnologico->Export == "") { ?>
<?php echo $Language->SelectionForm(); ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php if (($piso_tecnologico->Export == "") || (EW_EXPORT_MASTER_RECORD && $piso_tecnologico->Export == "print")) { ?>
<?php
if ($piso_tecnologico_list->DbMasterFilter <> "" && $piso_tecnologico->getCurrentMasterTable() == "dato_establecimiento") {
	if ($piso_tecnologico_list->MasterRecordExists) {
?>
<?php include_once "dato_establecimientomaster.php" ?>
<?php
	}
}
?>
<?php } ?>
<?php
if ($piso_tecnologico->CurrentAction == "gridadd") {
	$piso_tecnologico->CurrentFilter = "0=1";
	$piso_tecnologico_list->StartRec = 1;
	$piso_tecnologico_list->DisplayRecs = $piso_tecnologico->GridAddRowCount;
	$piso_tecnologico_list->TotalRecs = $piso_tecnologico_list->DisplayRecs;
	$piso_tecnologico_list->StopRec = $piso_tecnologico_list->DisplayRecs;
} else {
	$bSelectLimit = $piso_tecnologico_list->UseSelectLimit;
	if ($bSelectLimit) {
		if ($piso_tecnologico_list->TotalRecs <= 0)
			$piso_tecnologico_list->TotalRecs = $piso_tecnologico->SelectRecordCount();
	} else {
		if (!$piso_tecnologico_list->Recordset && ($piso_tecnologico_list->Recordset = $piso_tecnologico_list->LoadRecordset()))
			$piso_tecnologico_list->TotalRecs = $piso_tecnologico_list->Recordset->RecordCount();
	}
	$piso_tecnologico_list->StartRec = 1;
	if ($piso_tecnologico_list->DisplayRecs <= 0 || ($piso_tecnologico->Export <> "" && $piso_tecnologico->ExportAll)) // Display all records
		$piso_tecnologico_list->DisplayRecs = $piso_tecnologico_list->TotalRecs;
	if (!($piso_tecnologico->Export <> "" && $piso_tecnologico->ExportAll))
		$piso_tecnologico_list->SetUpStartRec(); // Set up start record position
	if ($bSelectLimit)
		$piso_tecnologico_list->Recordset = $piso_tecnologico_list->LoadRecordset($piso_tecnologico_list->StartRec-1, $piso_tecnologico_list->DisplayRecs);

	// Set no record found message
	if ($piso_tecnologico->CurrentAction == "" && $piso_tecnologico_list->TotalRecs == 0) {
		if (!$Security->CanList())
			$piso_tecnologico_list->setWarningMessage(ew_DeniedMsg());
		if ($piso_tecnologico_list->SearchWhere == "0=101")
			$piso_tecnologico_list->setWarningMessage($Language->Phrase("EnterSearchCriteria"));
		else
			$piso_tecnologico_list->setWarningMessage($Language->Phrase("NoRecord"));
	}

	// Audit trail on search
	if ($piso_tecnologico_list->AuditTrailOnSearch && $piso_tecnologico_list->Command == "search" && !$piso_tecnologico_list->RestoreSearch) {
		$searchparm = ew_ServerVar("QUERY_STRING");
		$searchsql = $piso_tecnologico_list->getSessionWhere();
		$piso_tecnologico_list->WriteAuditTrailOnSearch($searchparm, $searchsql);
	}
}
$piso_tecnologico_list->RenderOtherOptions();
?>
<?php if ($Security->CanSearch()) { ?>
<?php if ($piso_tecnologico->Export == "" && $piso_tecnologico->CurrentAction == "") { ?>
<form name="fpiso_tecnologicolistsrch" id="fpiso_tecnologicolistsrch" class="form-inline ewForm" action="<?php echo ew_CurrentPage() ?>">
<?php $SearchPanelClass = ($piso_tecnologico_list->SearchWhere <> "") ? " in" : " in"; ?>
<div id="fpiso_tecnologicolistsrch_SearchPanel" class="ewSearchPanel collapse<?php echo $SearchPanelClass ?>">
<input type="hidden" name="cmd" value="search">
<input type="hidden" name="t" value="piso_tecnologico">
	<div class="ewBasicSearch">
<div id="xsr_1" class="ewRow">
	<div class="ewQuickSearch input-group">
	<input type="text" name="<?php echo EW_TABLE_BASIC_SEARCH ?>" id="<?php echo EW_TABLE_BASIC_SEARCH ?>" class="form-control" value="<?php echo ew_HtmlEncode($piso_tecnologico_list->BasicSearch->getKeyword()) ?>" placeholder="<?php echo ew_HtmlEncode($Language->Phrase("Search")) ?>">
	<input type="hidden" name="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" id="<?php echo EW_TABLE_BASIC_SEARCH_TYPE ?>" value="<?php echo ew_HtmlEncode($piso_tecnologico_list->BasicSearch->getType()) ?>">
	<div class="input-group-btn">
		<button type="button" data-toggle="dropdown" class="btn btn-default"><span id="searchtype"><?php echo $piso_tecnologico_list->BasicSearch->getTypeNameShort() ?></span><span class="caret"></span></button>
		<ul class="dropdown-menu pull-right" role="menu">
			<li<?php if ($piso_tecnologico_list->BasicSearch->getType() == "") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this)"><?php echo $Language->Phrase("QuickSearchAuto") ?></a></li>
			<li<?php if ($piso_tecnologico_list->BasicSearch->getType() == "=") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'=')"><?php echo $Language->Phrase("QuickSearchExact") ?></a></li>
			<li<?php if ($piso_tecnologico_list->BasicSearch->getType() == "AND") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'AND')"><?php echo $Language->Phrase("QuickSearchAll") ?></a></li>
			<li<?php if ($piso_tecnologico_list->BasicSearch->getType() == "OR") echo " class=\"active\""; ?>><a href="javascript:void(0);" onclick="ew_SetSearchType(this,'OR')"><?php echo $Language->Phrase("QuickSearchAny") ?></a></li>
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
<?php $piso_tecnologico_list->ShowPageHeader(); ?>
<?php
$piso_tecnologico_list->ShowMessage();
?>
<?php if ($piso_tecnologico_list->TotalRecs > 0 || $piso_tecnologico->CurrentAction <> "") { ?>
<div class="panel panel-default ewGrid piso_tecnologico">
<?php if ($piso_tecnologico->Export == "") { ?>
<div class="panel-heading ewGridUpperPanel">
<?php if ($piso_tecnologico->CurrentAction <> "gridadd" && $piso_tecnologico->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="form-inline ewForm ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($piso_tecnologico_list->Pager)) $piso_tecnologico_list->Pager = new cPrevNextPager($piso_tecnologico_list->StartRec, $piso_tecnologico_list->DisplayRecs, $piso_tecnologico_list->TotalRecs) ?>
<?php if ($piso_tecnologico_list->Pager->RecordCount > 0 && $piso_tecnologico_list->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($piso_tecnologico_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $piso_tecnologico_list->PageUrl() ?>start=<?php echo $piso_tecnologico_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($piso_tecnologico_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $piso_tecnologico_list->PageUrl() ?>start=<?php echo $piso_tecnologico_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $piso_tecnologico_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($piso_tecnologico_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $piso_tecnologico_list->PageUrl() ?>start=<?php echo $piso_tecnologico_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($piso_tecnologico_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $piso_tecnologico_list->PageUrl() ?>start=<?php echo $piso_tecnologico_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $piso_tecnologico_list->Pager->PageCount ?></span>
</div>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $piso_tecnologico_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $piso_tecnologico_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $piso_tecnologico_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($piso_tecnologico_list->OtherOptions as &$option)
		$option->Render("body");
?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
<form name="fpiso_tecnologicolist" id="fpiso_tecnologicolist" class="form-inline ewForm ewListForm" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($piso_tecnologico_list->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $piso_tecnologico_list->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="piso_tecnologico">
<?php if ($piso_tecnologico->getCurrentMasterTable() == "dato_establecimiento" && $piso_tecnologico->CurrentAction <> "") { ?>
<input type="hidden" name="<?php echo EW_TABLE_SHOW_MASTER ?>" value="dato_establecimiento">
<input type="hidden" name="fk_Cue" value="<?php echo $piso_tecnologico->Cue->getSessionValue() ?>">
<?php } ?>
<div id="gmp_piso_tecnologico" class="<?php if (ew_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<?php if ($piso_tecnologico_list->TotalRecs > 0 || $piso_tecnologico->CurrentAction == "add" || $piso_tecnologico->CurrentAction == "copy") { ?>
<table id="tbl_piso_tecnologicolist" class="table ewTable">
<?php echo $piso_tecnologico->TableCustomInnerHtml ?>
<thead><!-- Table header -->
	<tr class="ewTableHeader">
<?php

// Header row
$piso_tecnologico_list->RowType = EW_ROWTYPE_HEADER;

// Render list options
$piso_tecnologico_list->RenderListOptions();

// Render list options (header, left)
$piso_tecnologico_list->ListOptions->Render("header", "left");
?>
<?php if ($piso_tecnologico->Switch->Visible) { // Switch ?>
	<?php if ($piso_tecnologico->SortUrl($piso_tecnologico->Switch) == "") { ?>
		<th data-name="Switch"><div id="elh_piso_tecnologico_Switch" class="piso_tecnologico_Switch"><div class="ewTableHeaderCaption"><?php echo $piso_tecnologico->Switch->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Switch"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $piso_tecnologico->SortUrl($piso_tecnologico->Switch) ?>',1);"><div id="elh_piso_tecnologico_Switch" class="piso_tecnologico_Switch">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $piso_tecnologico->Switch->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($piso_tecnologico->Switch->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($piso_tecnologico->Switch->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($piso_tecnologico->Bocas_Switch->Visible) { // Bocas_Switch ?>
	<?php if ($piso_tecnologico->SortUrl($piso_tecnologico->Bocas_Switch) == "") { ?>
		<th data-name="Bocas_Switch"><div id="elh_piso_tecnologico_Bocas_Switch" class="piso_tecnologico_Bocas_Switch"><div class="ewTableHeaderCaption"><?php echo $piso_tecnologico->Bocas_Switch->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Bocas_Switch"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $piso_tecnologico->SortUrl($piso_tecnologico->Bocas_Switch) ?>',1);"><div id="elh_piso_tecnologico_Bocas_Switch" class="piso_tecnologico_Bocas_Switch">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $piso_tecnologico->Bocas_Switch->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($piso_tecnologico->Bocas_Switch->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($piso_tecnologico->Bocas_Switch->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($piso_tecnologico->Estado_Switch->Visible) { // Estado_Switch ?>
	<?php if ($piso_tecnologico->SortUrl($piso_tecnologico->Estado_Switch) == "") { ?>
		<th data-name="Estado_Switch"><div id="elh_piso_tecnologico_Estado_Switch" class="piso_tecnologico_Estado_Switch"><div class="ewTableHeaderCaption"><?php echo $piso_tecnologico->Estado_Switch->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Estado_Switch"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $piso_tecnologico->SortUrl($piso_tecnologico->Estado_Switch) ?>',1);"><div id="elh_piso_tecnologico_Estado_Switch" class="piso_tecnologico_Estado_Switch">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $piso_tecnologico->Estado_Switch->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($piso_tecnologico->Estado_Switch->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($piso_tecnologico->Estado_Switch->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($piso_tecnologico->Cantidad_Ap->Visible) { // Cantidad_Ap ?>
	<?php if ($piso_tecnologico->SortUrl($piso_tecnologico->Cantidad_Ap) == "") { ?>
		<th data-name="Cantidad_Ap"><div id="elh_piso_tecnologico_Cantidad_Ap" class="piso_tecnologico_Cantidad_Ap"><div class="ewTableHeaderCaption"><?php echo $piso_tecnologico->Cantidad_Ap->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Cantidad_Ap"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $piso_tecnologico->SortUrl($piso_tecnologico->Cantidad_Ap) ?>',1);"><div id="elh_piso_tecnologico_Cantidad_Ap" class="piso_tecnologico_Cantidad_Ap">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $piso_tecnologico->Cantidad_Ap->FldCaption() ?><?php echo $Language->Phrase("SrchLegend") ?></span><span class="ewTableHeaderSort"><?php if ($piso_tecnologico->Cantidad_Ap->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($piso_tecnologico->Cantidad_Ap->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($piso_tecnologico->Cantidad_Ap_Func->Visible) { // Cantidad_Ap_Func ?>
	<?php if ($piso_tecnologico->SortUrl($piso_tecnologico->Cantidad_Ap_Func) == "") { ?>
		<th data-name="Cantidad_Ap_Func"><div id="elh_piso_tecnologico_Cantidad_Ap_Func" class="piso_tecnologico_Cantidad_Ap_Func"><div class="ewTableHeaderCaption"><?php echo $piso_tecnologico->Cantidad_Ap_Func->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Cantidad_Ap_Func"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $piso_tecnologico->SortUrl($piso_tecnologico->Cantidad_Ap_Func) ?>',1);"><div id="elh_piso_tecnologico_Cantidad_Ap_Func" class="piso_tecnologico_Cantidad_Ap_Func">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $piso_tecnologico->Cantidad_Ap_Func->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($piso_tecnologico->Cantidad_Ap_Func->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($piso_tecnologico->Cantidad_Ap_Func->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($piso_tecnologico->Ups->Visible) { // Ups ?>
	<?php if ($piso_tecnologico->SortUrl($piso_tecnologico->Ups) == "") { ?>
		<th data-name="Ups"><div id="elh_piso_tecnologico_Ups" class="piso_tecnologico_Ups"><div class="ewTableHeaderCaption"><?php echo $piso_tecnologico->Ups->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Ups"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $piso_tecnologico->SortUrl($piso_tecnologico->Ups) ?>',1);"><div id="elh_piso_tecnologico_Ups" class="piso_tecnologico_Ups">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $piso_tecnologico->Ups->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($piso_tecnologico->Ups->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($piso_tecnologico->Ups->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($piso_tecnologico->Estado_Ups->Visible) { // Estado_Ups ?>
	<?php if ($piso_tecnologico->SortUrl($piso_tecnologico->Estado_Ups) == "") { ?>
		<th data-name="Estado_Ups"><div id="elh_piso_tecnologico_Estado_Ups" class="piso_tecnologico_Estado_Ups"><div class="ewTableHeaderCaption"><?php echo $piso_tecnologico->Estado_Ups->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Estado_Ups"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $piso_tecnologico->SortUrl($piso_tecnologico->Estado_Ups) ?>',1);"><div id="elh_piso_tecnologico_Estado_Ups" class="piso_tecnologico_Estado_Ups">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $piso_tecnologico->Estado_Ups->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($piso_tecnologico->Estado_Ups->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($piso_tecnologico->Estado_Ups->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($piso_tecnologico->Cableado->Visible) { // Cableado ?>
	<?php if ($piso_tecnologico->SortUrl($piso_tecnologico->Cableado) == "") { ?>
		<th data-name="Cableado"><div id="elh_piso_tecnologico_Cableado" class="piso_tecnologico_Cableado"><div class="ewTableHeaderCaption"><?php echo $piso_tecnologico->Cableado->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Cableado"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $piso_tecnologico->SortUrl($piso_tecnologico->Cableado) ?>',1);"><div id="elh_piso_tecnologico_Cableado" class="piso_tecnologico_Cableado">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $piso_tecnologico->Cableado->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($piso_tecnologico->Cableado->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($piso_tecnologico->Cableado->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($piso_tecnologico->Estado_Cableado->Visible) { // Estado_Cableado ?>
	<?php if ($piso_tecnologico->SortUrl($piso_tecnologico->Estado_Cableado) == "") { ?>
		<th data-name="Estado_Cableado"><div id="elh_piso_tecnologico_Estado_Cableado" class="piso_tecnologico_Estado_Cableado"><div class="ewTableHeaderCaption"><?php echo $piso_tecnologico->Estado_Cableado->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Estado_Cableado"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $piso_tecnologico->SortUrl($piso_tecnologico->Estado_Cableado) ?>',1);"><div id="elh_piso_tecnologico_Estado_Cableado" class="piso_tecnologico_Estado_Cableado">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $piso_tecnologico->Estado_Cableado->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($piso_tecnologico->Estado_Cableado->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($piso_tecnologico->Estado_Cableado->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($piso_tecnologico->Porcent_Estado_Cab->Visible) { // Porcent_Estado_Cab ?>
	<?php if ($piso_tecnologico->SortUrl($piso_tecnologico->Porcent_Estado_Cab) == "") { ?>
		<th data-name="Porcent_Estado_Cab"><div id="elh_piso_tecnologico_Porcent_Estado_Cab" class="piso_tecnologico_Porcent_Estado_Cab"><div class="ewTableHeaderCaption"><?php echo $piso_tecnologico->Porcent_Estado_Cab->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Porcent_Estado_Cab"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $piso_tecnologico->SortUrl($piso_tecnologico->Porcent_Estado_Cab) ?>',1);"><div id="elh_piso_tecnologico_Porcent_Estado_Cab" class="piso_tecnologico_Porcent_Estado_Cab">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $piso_tecnologico->Porcent_Estado_Cab->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($piso_tecnologico->Porcent_Estado_Cab->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($piso_tecnologico->Porcent_Estado_Cab->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($piso_tecnologico->Porcent_Func_Piso->Visible) { // Porcent_Func_Piso ?>
	<?php if ($piso_tecnologico->SortUrl($piso_tecnologico->Porcent_Func_Piso) == "") { ?>
		<th data-name="Porcent_Func_Piso"><div id="elh_piso_tecnologico_Porcent_Func_Piso" class="piso_tecnologico_Porcent_Func_Piso"><div class="ewTableHeaderCaption"><?php echo $piso_tecnologico->Porcent_Func_Piso->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Porcent_Func_Piso"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $piso_tecnologico->SortUrl($piso_tecnologico->Porcent_Func_Piso) ?>',1);"><div id="elh_piso_tecnologico_Porcent_Func_Piso" class="piso_tecnologico_Porcent_Func_Piso">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $piso_tecnologico->Porcent_Func_Piso->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($piso_tecnologico->Porcent_Func_Piso->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($piso_tecnologico->Porcent_Func_Piso->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($piso_tecnologico->Plano_Escuela->Visible) { // Plano_Escuela ?>
	<?php if ($piso_tecnologico->SortUrl($piso_tecnologico->Plano_Escuela) == "") { ?>
		<th data-name="Plano_Escuela"><div id="elh_piso_tecnologico_Plano_Escuela" class="piso_tecnologico_Plano_Escuela"><div class="ewTableHeaderCaption"><?php echo $piso_tecnologico->Plano_Escuela->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Plano_Escuela"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $piso_tecnologico->SortUrl($piso_tecnologico->Plano_Escuela) ?>',1);"><div id="elh_piso_tecnologico_Plano_Escuela" class="piso_tecnologico_Plano_Escuela">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $piso_tecnologico->Plano_Escuela->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($piso_tecnologico->Plano_Escuela->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($piso_tecnologico->Plano_Escuela->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($piso_tecnologico->Fecha_Actualizacion->Visible) { // Fecha_Actualizacion ?>
	<?php if ($piso_tecnologico->SortUrl($piso_tecnologico->Fecha_Actualizacion) == "") { ?>
		<th data-name="Fecha_Actualizacion"><div id="elh_piso_tecnologico_Fecha_Actualizacion" class="piso_tecnologico_Fecha_Actualizacion"><div class="ewTableHeaderCaption"><?php echo $piso_tecnologico->Fecha_Actualizacion->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Fecha_Actualizacion"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $piso_tecnologico->SortUrl($piso_tecnologico->Fecha_Actualizacion) ?>',1);"><div id="elh_piso_tecnologico_Fecha_Actualizacion" class="piso_tecnologico_Fecha_Actualizacion">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $piso_tecnologico->Fecha_Actualizacion->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($piso_tecnologico->Fecha_Actualizacion->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($piso_tecnologico->Fecha_Actualizacion->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php if ($piso_tecnologico->Usuario->Visible) { // Usuario ?>
	<?php if ($piso_tecnologico->SortUrl($piso_tecnologico->Usuario) == "") { ?>
		<th data-name="Usuario"><div id="elh_piso_tecnologico_Usuario" class="piso_tecnologico_Usuario"><div class="ewTableHeaderCaption"><?php echo $piso_tecnologico->Usuario->FldCaption() ?></div></div></th>
	<?php } else { ?>
		<th data-name="Usuario"><div class="ewPointer" onclick="ew_Sort(event,'<?php echo $piso_tecnologico->SortUrl($piso_tecnologico->Usuario) ?>',1);"><div id="elh_piso_tecnologico_Usuario" class="piso_tecnologico_Usuario">
			<div class="ewTableHeaderBtn"><span class="ewTableHeaderCaption"><?php echo $piso_tecnologico->Usuario->FldCaption() ?></span><span class="ewTableHeaderSort"><?php if ($piso_tecnologico->Usuario->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($piso_tecnologico->Usuario->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span></div>
        </div></div></th>
	<?php } ?>
<?php } ?>		
<?php

// Render list options (header, right)
$piso_tecnologico_list->ListOptions->Render("header", "right");
?>
	</tr>
</thead>
<tbody>
<?php
	if ($piso_tecnologico->CurrentAction == "add" || $piso_tecnologico->CurrentAction == "copy") {
		$piso_tecnologico_list->RowIndex = 0;
		$piso_tecnologico_list->KeyCount = $piso_tecnologico_list->RowIndex;
		if ($piso_tecnologico->CurrentAction == "add")
			$piso_tecnologico_list->LoadDefaultValues();
		if ($piso_tecnologico->EventCancelled) // Insert failed
			$piso_tecnologico_list->RestoreFormValues(); // Restore form values

		// Set row properties
		$piso_tecnologico->ResetAttrs();
		$piso_tecnologico->RowAttrs = array_merge($piso_tecnologico->RowAttrs, array('data-rowindex'=>0, 'id'=>'r0_piso_tecnologico', 'data-rowtype'=>EW_ROWTYPE_ADD));
		$piso_tecnologico->RowType = EW_ROWTYPE_ADD;

		// Render row
		$piso_tecnologico_list->RenderRow();

		// Render list options
		$piso_tecnologico_list->RenderListOptions();
		$piso_tecnologico_list->StartRowCnt = 0;
?>
	<tr<?php echo $piso_tecnologico->RowAttributes() ?>>
<?php

// Render list options (body, left)
$piso_tecnologico_list->ListOptions->Render("body", "left", $piso_tecnologico_list->RowCnt);
?>
	<?php if ($piso_tecnologico->Switch->Visible) { // Switch ?>
		<td data-name="Switch">
<span id="el<?php echo $piso_tecnologico_list->RowCnt ?>_piso_tecnologico_Switch" class="form-group piso_tecnologico_Switch">
<div id="tp_x<?php echo $piso_tecnologico_list->RowIndex ?>_Switch" class="ewTemplate"><input type="radio" data-table="piso_tecnologico" data-field="x_Switch" data-value-separator="<?php echo $piso_tecnologico->Switch->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $piso_tecnologico_list->RowIndex ?>_Switch" id="x<?php echo $piso_tecnologico_list->RowIndex ?>_Switch" value="{value}"<?php echo $piso_tecnologico->Switch->EditAttributes() ?>></div>
<div id="dsl_x<?php echo $piso_tecnologico_list->RowIndex ?>_Switch" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $piso_tecnologico->Switch->RadioButtonListHtml(FALSE, "x{$piso_tecnologico_list->RowIndex}_Switch") ?>
</div></div>
</span>
<input type="hidden" data-table="piso_tecnologico" data-field="x_Switch" name="o<?php echo $piso_tecnologico_list->RowIndex ?>_Switch" id="o<?php echo $piso_tecnologico_list->RowIndex ?>_Switch" value="<?php echo ew_HtmlEncode($piso_tecnologico->Switch->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($piso_tecnologico->Bocas_Switch->Visible) { // Bocas_Switch ?>
		<td data-name="Bocas_Switch">
<span id="el<?php echo $piso_tecnologico_list->RowCnt ?>_piso_tecnologico_Bocas_Switch" class="form-group piso_tecnologico_Bocas_Switch">
<input type="text" data-table="piso_tecnologico" data-field="x_Bocas_Switch" name="x<?php echo $piso_tecnologico_list->RowIndex ?>_Bocas_Switch" id="x<?php echo $piso_tecnologico_list->RowIndex ?>_Bocas_Switch" size="30" placeholder="<?php echo ew_HtmlEncode($piso_tecnologico->Bocas_Switch->getPlaceHolder()) ?>" value="<?php echo $piso_tecnologico->Bocas_Switch->EditValue ?>"<?php echo $piso_tecnologico->Bocas_Switch->EditAttributes() ?>>
</span>
<input type="hidden" data-table="piso_tecnologico" data-field="x_Bocas_Switch" name="o<?php echo $piso_tecnologico_list->RowIndex ?>_Bocas_Switch" id="o<?php echo $piso_tecnologico_list->RowIndex ?>_Bocas_Switch" value="<?php echo ew_HtmlEncode($piso_tecnologico->Bocas_Switch->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($piso_tecnologico->Estado_Switch->Visible) { // Estado_Switch ?>
		<td data-name="Estado_Switch">
<span id="el<?php echo $piso_tecnologico_list->RowCnt ?>_piso_tecnologico_Estado_Switch" class="form-group piso_tecnologico_Estado_Switch">
<select data-table="piso_tecnologico" data-field="x_Estado_Switch" data-value-separator="<?php echo $piso_tecnologico->Estado_Switch->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $piso_tecnologico_list->RowIndex ?>_Estado_Switch" name="x<?php echo $piso_tecnologico_list->RowIndex ?>_Estado_Switch"<?php echo $piso_tecnologico->Estado_Switch->EditAttributes() ?>>
<?php echo $piso_tecnologico->Estado_Switch->SelectOptionListHtml("x<?php echo $piso_tecnologico_list->RowIndex ?>_Estado_Switch") ?>
</select>
<input type="hidden" name="s_x<?php echo $piso_tecnologico_list->RowIndex ?>_Estado_Switch" id="s_x<?php echo $piso_tecnologico_list->RowIndex ?>_Estado_Switch" value="<?php echo $piso_tecnologico->Estado_Switch->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="piso_tecnologico" data-field="x_Estado_Switch" name="o<?php echo $piso_tecnologico_list->RowIndex ?>_Estado_Switch" id="o<?php echo $piso_tecnologico_list->RowIndex ?>_Estado_Switch" value="<?php echo ew_HtmlEncode($piso_tecnologico->Estado_Switch->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($piso_tecnologico->Cantidad_Ap->Visible) { // Cantidad_Ap ?>
		<td data-name="Cantidad_Ap">
<span id="el<?php echo $piso_tecnologico_list->RowCnt ?>_piso_tecnologico_Cantidad_Ap" class="form-group piso_tecnologico_Cantidad_Ap">
<input type="text" data-table="piso_tecnologico" data-field="x_Cantidad_Ap" name="x<?php echo $piso_tecnologico_list->RowIndex ?>_Cantidad_Ap" id="x<?php echo $piso_tecnologico_list->RowIndex ?>_Cantidad_Ap" size="30" maxlength="2" placeholder="<?php echo ew_HtmlEncode($piso_tecnologico->Cantidad_Ap->getPlaceHolder()) ?>" value="<?php echo $piso_tecnologico->Cantidad_Ap->EditValue ?>"<?php echo $piso_tecnologico->Cantidad_Ap->EditAttributes() ?>>
</span>
<input type="hidden" data-table="piso_tecnologico" data-field="x_Cantidad_Ap" name="o<?php echo $piso_tecnologico_list->RowIndex ?>_Cantidad_Ap" id="o<?php echo $piso_tecnologico_list->RowIndex ?>_Cantidad_Ap" value="<?php echo ew_HtmlEncode($piso_tecnologico->Cantidad_Ap->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($piso_tecnologico->Cantidad_Ap_Func->Visible) { // Cantidad_Ap_Func ?>
		<td data-name="Cantidad_Ap_Func">
<span id="el<?php echo $piso_tecnologico_list->RowCnt ?>_piso_tecnologico_Cantidad_Ap_Func" class="form-group piso_tecnologico_Cantidad_Ap_Func">
<input type="text" data-table="piso_tecnologico" data-field="x_Cantidad_Ap_Func" name="x<?php echo $piso_tecnologico_list->RowIndex ?>_Cantidad_Ap_Func" id="x<?php echo $piso_tecnologico_list->RowIndex ?>_Cantidad_Ap_Func" size="30" maxlength="3" placeholder="<?php echo ew_HtmlEncode($piso_tecnologico->Cantidad_Ap_Func->getPlaceHolder()) ?>" value="<?php echo $piso_tecnologico->Cantidad_Ap_Func->EditValue ?>"<?php echo $piso_tecnologico->Cantidad_Ap_Func->EditAttributes() ?>>
</span>
<input type="hidden" data-table="piso_tecnologico" data-field="x_Cantidad_Ap_Func" name="o<?php echo $piso_tecnologico_list->RowIndex ?>_Cantidad_Ap_Func" id="o<?php echo $piso_tecnologico_list->RowIndex ?>_Cantidad_Ap_Func" value="<?php echo ew_HtmlEncode($piso_tecnologico->Cantidad_Ap_Func->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($piso_tecnologico->Ups->Visible) { // Ups ?>
		<td data-name="Ups">
<span id="el<?php echo $piso_tecnologico_list->RowCnt ?>_piso_tecnologico_Ups" class="form-group piso_tecnologico_Ups">
<div id="tp_x<?php echo $piso_tecnologico_list->RowIndex ?>_Ups" class="ewTemplate"><input type="radio" data-table="piso_tecnologico" data-field="x_Ups" data-value-separator="<?php echo $piso_tecnologico->Ups->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $piso_tecnologico_list->RowIndex ?>_Ups" id="x<?php echo $piso_tecnologico_list->RowIndex ?>_Ups" value="{value}"<?php echo $piso_tecnologico->Ups->EditAttributes() ?>></div>
<div id="dsl_x<?php echo $piso_tecnologico_list->RowIndex ?>_Ups" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $piso_tecnologico->Ups->RadioButtonListHtml(FALSE, "x{$piso_tecnologico_list->RowIndex}_Ups") ?>
</div></div>
</span>
<input type="hidden" data-table="piso_tecnologico" data-field="x_Ups" name="o<?php echo $piso_tecnologico_list->RowIndex ?>_Ups" id="o<?php echo $piso_tecnologico_list->RowIndex ?>_Ups" value="<?php echo ew_HtmlEncode($piso_tecnologico->Ups->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($piso_tecnologico->Estado_Ups->Visible) { // Estado_Ups ?>
		<td data-name="Estado_Ups">
<span id="el<?php echo $piso_tecnologico_list->RowCnt ?>_piso_tecnologico_Estado_Ups" class="form-group piso_tecnologico_Estado_Ups">
<select data-table="piso_tecnologico" data-field="x_Estado_Ups" data-value-separator="<?php echo $piso_tecnologico->Estado_Ups->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $piso_tecnologico_list->RowIndex ?>_Estado_Ups" name="x<?php echo $piso_tecnologico_list->RowIndex ?>_Estado_Ups"<?php echo $piso_tecnologico->Estado_Ups->EditAttributes() ?>>
<?php echo $piso_tecnologico->Estado_Ups->SelectOptionListHtml("x<?php echo $piso_tecnologico_list->RowIndex ?>_Estado_Ups") ?>
</select>
<input type="hidden" name="s_x<?php echo $piso_tecnologico_list->RowIndex ?>_Estado_Ups" id="s_x<?php echo $piso_tecnologico_list->RowIndex ?>_Estado_Ups" value="<?php echo $piso_tecnologico->Estado_Ups->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="piso_tecnologico" data-field="x_Estado_Ups" name="o<?php echo $piso_tecnologico_list->RowIndex ?>_Estado_Ups" id="o<?php echo $piso_tecnologico_list->RowIndex ?>_Estado_Ups" value="<?php echo ew_HtmlEncode($piso_tecnologico->Estado_Ups->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($piso_tecnologico->Cableado->Visible) { // Cableado ?>
		<td data-name="Cableado">
<span id="el<?php echo $piso_tecnologico_list->RowCnt ?>_piso_tecnologico_Cableado" class="form-group piso_tecnologico_Cableado">
<div id="tp_x<?php echo $piso_tecnologico_list->RowIndex ?>_Cableado" class="ewTemplate"><input type="radio" data-table="piso_tecnologico" data-field="x_Cableado" data-value-separator="<?php echo $piso_tecnologico->Cableado->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $piso_tecnologico_list->RowIndex ?>_Cableado" id="x<?php echo $piso_tecnologico_list->RowIndex ?>_Cableado" value="{value}"<?php echo $piso_tecnologico->Cableado->EditAttributes() ?>></div>
<div id="dsl_x<?php echo $piso_tecnologico_list->RowIndex ?>_Cableado" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $piso_tecnologico->Cableado->RadioButtonListHtml(FALSE, "x{$piso_tecnologico_list->RowIndex}_Cableado") ?>
</div></div>
</span>
<input type="hidden" data-table="piso_tecnologico" data-field="x_Cableado" name="o<?php echo $piso_tecnologico_list->RowIndex ?>_Cableado" id="o<?php echo $piso_tecnologico_list->RowIndex ?>_Cableado" value="<?php echo ew_HtmlEncode($piso_tecnologico->Cableado->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($piso_tecnologico->Estado_Cableado->Visible) { // Estado_Cableado ?>
		<td data-name="Estado_Cableado">
<span id="el<?php echo $piso_tecnologico_list->RowCnt ?>_piso_tecnologico_Estado_Cableado" class="form-group piso_tecnologico_Estado_Cableado">
<select data-table="piso_tecnologico" data-field="x_Estado_Cableado" data-value-separator="<?php echo $piso_tecnologico->Estado_Cableado->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $piso_tecnologico_list->RowIndex ?>_Estado_Cableado" name="x<?php echo $piso_tecnologico_list->RowIndex ?>_Estado_Cableado"<?php echo $piso_tecnologico->Estado_Cableado->EditAttributes() ?>>
<?php echo $piso_tecnologico->Estado_Cableado->SelectOptionListHtml("x<?php echo $piso_tecnologico_list->RowIndex ?>_Estado_Cableado") ?>
</select>
<input type="hidden" name="s_x<?php echo $piso_tecnologico_list->RowIndex ?>_Estado_Cableado" id="s_x<?php echo $piso_tecnologico_list->RowIndex ?>_Estado_Cableado" value="<?php echo $piso_tecnologico->Estado_Cableado->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="piso_tecnologico" data-field="x_Estado_Cableado" name="o<?php echo $piso_tecnologico_list->RowIndex ?>_Estado_Cableado" id="o<?php echo $piso_tecnologico_list->RowIndex ?>_Estado_Cableado" value="<?php echo ew_HtmlEncode($piso_tecnologico->Estado_Cableado->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($piso_tecnologico->Porcent_Estado_Cab->Visible) { // Porcent_Estado_Cab ?>
		<td data-name="Porcent_Estado_Cab">
<span id="el<?php echo $piso_tecnologico_list->RowCnt ?>_piso_tecnologico_Porcent_Estado_Cab" class="form-group piso_tecnologico_Porcent_Estado_Cab">
<input type="text" data-table="piso_tecnologico" data-field="x_Porcent_Estado_Cab" name="x<?php echo $piso_tecnologico_list->RowIndex ?>_Porcent_Estado_Cab" id="x<?php echo $piso_tecnologico_list->RowIndex ?>_Porcent_Estado_Cab" size="30" maxlength="3" placeholder="<?php echo ew_HtmlEncode($piso_tecnologico->Porcent_Estado_Cab->getPlaceHolder()) ?>" value="<?php echo $piso_tecnologico->Porcent_Estado_Cab->EditValue ?>"<?php echo $piso_tecnologico->Porcent_Estado_Cab->EditAttributes() ?>>
</span>
<input type="hidden" data-table="piso_tecnologico" data-field="x_Porcent_Estado_Cab" name="o<?php echo $piso_tecnologico_list->RowIndex ?>_Porcent_Estado_Cab" id="o<?php echo $piso_tecnologico_list->RowIndex ?>_Porcent_Estado_Cab" value="<?php echo ew_HtmlEncode($piso_tecnologico->Porcent_Estado_Cab->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($piso_tecnologico->Porcent_Func_Piso->Visible) { // Porcent_Func_Piso ?>
		<td data-name="Porcent_Func_Piso">
<span id="el<?php echo $piso_tecnologico_list->RowCnt ?>_piso_tecnologico_Porcent_Func_Piso" class="form-group piso_tecnologico_Porcent_Func_Piso">
<input type="text" data-table="piso_tecnologico" data-field="x_Porcent_Func_Piso" name="x<?php echo $piso_tecnologico_list->RowIndex ?>_Porcent_Func_Piso" id="x<?php echo $piso_tecnologico_list->RowIndex ?>_Porcent_Func_Piso" size="30" maxlength="3" placeholder="<?php echo ew_HtmlEncode($piso_tecnologico->Porcent_Func_Piso->getPlaceHolder()) ?>" value="<?php echo $piso_tecnologico->Porcent_Func_Piso->EditValue ?>"<?php echo $piso_tecnologico->Porcent_Func_Piso->EditAttributes() ?>>
</span>
<input type="hidden" data-table="piso_tecnologico" data-field="x_Porcent_Func_Piso" name="o<?php echo $piso_tecnologico_list->RowIndex ?>_Porcent_Func_Piso" id="o<?php echo $piso_tecnologico_list->RowIndex ?>_Porcent_Func_Piso" value="<?php echo ew_HtmlEncode($piso_tecnologico->Porcent_Func_Piso->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($piso_tecnologico->Plano_Escuela->Visible) { // Plano_Escuela ?>
		<td data-name="Plano_Escuela">
<span id="el<?php echo $piso_tecnologico_list->RowCnt ?>_piso_tecnologico_Plano_Escuela" class="form-group piso_tecnologico_Plano_Escuela">
<div id="fd_x<?php echo $piso_tecnologico_list->RowIndex ?>_Plano_Escuela">
<span title="<?php echo $piso_tecnologico->Plano_Escuela->FldTitle() ? $piso_tecnologico->Plano_Escuela->FldTitle() : $Language->Phrase("ChooseFiles") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($piso_tecnologico->Plano_Escuela->ReadOnly || $piso_tecnologico->Plano_Escuela->Disabled) echo " hide"; ?>">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="piso_tecnologico" data-field="x_Plano_Escuela" name="x<?php echo $piso_tecnologico_list->RowIndex ?>_Plano_Escuela" id="x<?php echo $piso_tecnologico_list->RowIndex ?>_Plano_Escuela" multiple="multiple"<?php echo $piso_tecnologico->Plano_Escuela->EditAttributes() ?>>
</span>
<input type="hidden" name="fn_x<?php echo $piso_tecnologico_list->RowIndex ?>_Plano_Escuela" id= "fn_x<?php echo $piso_tecnologico_list->RowIndex ?>_Plano_Escuela" value="<?php echo $piso_tecnologico->Plano_Escuela->Upload->FileName ?>">
<input type="hidden" name="fa_x<?php echo $piso_tecnologico_list->RowIndex ?>_Plano_Escuela" id= "fa_x<?php echo $piso_tecnologico_list->RowIndex ?>_Plano_Escuela" value="0">
<input type="hidden" name="fs_x<?php echo $piso_tecnologico_list->RowIndex ?>_Plano_Escuela" id= "fs_x<?php echo $piso_tecnologico_list->RowIndex ?>_Plano_Escuela" value="65535">
<input type="hidden" name="fx_x<?php echo $piso_tecnologico_list->RowIndex ?>_Plano_Escuela" id= "fx_x<?php echo $piso_tecnologico_list->RowIndex ?>_Plano_Escuela" value="<?php echo $piso_tecnologico->Plano_Escuela->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?php echo $piso_tecnologico_list->RowIndex ?>_Plano_Escuela" id= "fm_x<?php echo $piso_tecnologico_list->RowIndex ?>_Plano_Escuela" value="<?php echo $piso_tecnologico->Plano_Escuela->UploadMaxFileSize ?>">
<input type="hidden" name="fc_x<?php echo $piso_tecnologico_list->RowIndex ?>_Plano_Escuela" id= "fc_x<?php echo $piso_tecnologico_list->RowIndex ?>_Plano_Escuela" value="<?php echo $piso_tecnologico->Plano_Escuela->UploadMaxFileCount ?>">
</div>
<table id="ft_x<?php echo $piso_tecnologico_list->RowIndex ?>_Plano_Escuela" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<input type="hidden" data-table="piso_tecnologico" data-field="x_Plano_Escuela" name="o<?php echo $piso_tecnologico_list->RowIndex ?>_Plano_Escuela" id="o<?php echo $piso_tecnologico_list->RowIndex ?>_Plano_Escuela" value="<?php echo ew_HtmlEncode($piso_tecnologico->Plano_Escuela->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($piso_tecnologico->Fecha_Actualizacion->Visible) { // Fecha_Actualizacion ?>
		<td data-name="Fecha_Actualizacion">
<input type="hidden" data-table="piso_tecnologico" data-field="x_Fecha_Actualizacion" name="o<?php echo $piso_tecnologico_list->RowIndex ?>_Fecha_Actualizacion" id="o<?php echo $piso_tecnologico_list->RowIndex ?>_Fecha_Actualizacion" value="<?php echo ew_HtmlEncode($piso_tecnologico->Fecha_Actualizacion->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($piso_tecnologico->Usuario->Visible) { // Usuario ?>
		<td data-name="Usuario">
<input type="hidden" data-table="piso_tecnologico" data-field="x_Usuario" name="o<?php echo $piso_tecnologico_list->RowIndex ?>_Usuario" id="o<?php echo $piso_tecnologico_list->RowIndex ?>_Usuario" value="<?php echo ew_HtmlEncode($piso_tecnologico->Usuario->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$piso_tecnologico_list->ListOptions->Render("body", "right", $piso_tecnologico_list->RowCnt);
?>
<script type="text/javascript">
fpiso_tecnologicolist.UpdateOpts(<?php echo $piso_tecnologico_list->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
<?php
if ($piso_tecnologico->ExportAll && $piso_tecnologico->Export <> "") {
	$piso_tecnologico_list->StopRec = $piso_tecnologico_list->TotalRecs;
} else {

	// Set the last record to display
	if ($piso_tecnologico_list->TotalRecs > $piso_tecnologico_list->StartRec + $piso_tecnologico_list->DisplayRecs - 1)
		$piso_tecnologico_list->StopRec = $piso_tecnologico_list->StartRec + $piso_tecnologico_list->DisplayRecs - 1;
	else
		$piso_tecnologico_list->StopRec = $piso_tecnologico_list->TotalRecs;
}

// Restore number of post back records
if ($objForm) {
	$objForm->Index = -1;
	if ($objForm->HasValue($piso_tecnologico_list->FormKeyCountName) && ($piso_tecnologico->CurrentAction == "gridadd" || $piso_tecnologico->CurrentAction == "gridedit" || $piso_tecnologico->CurrentAction == "F")) {
		$piso_tecnologico_list->KeyCount = $objForm->GetValue($piso_tecnologico_list->FormKeyCountName);
		$piso_tecnologico_list->StopRec = $piso_tecnologico_list->StartRec + $piso_tecnologico_list->KeyCount - 1;
	}
}
$piso_tecnologico_list->RecCnt = $piso_tecnologico_list->StartRec - 1;
if ($piso_tecnologico_list->Recordset && !$piso_tecnologico_list->Recordset->EOF) {
	$piso_tecnologico_list->Recordset->MoveFirst();
	$bSelectLimit = $piso_tecnologico_list->UseSelectLimit;
	if (!$bSelectLimit && $piso_tecnologico_list->StartRec > 1)
		$piso_tecnologico_list->Recordset->Move($piso_tecnologico_list->StartRec - 1);
} elseif (!$piso_tecnologico->AllowAddDeleteRow && $piso_tecnologico_list->StopRec == 0) {
	$piso_tecnologico_list->StopRec = $piso_tecnologico->GridAddRowCount;
}

// Initialize aggregate
$piso_tecnologico->RowType = EW_ROWTYPE_AGGREGATEINIT;
$piso_tecnologico->ResetAttrs();
$piso_tecnologico_list->RenderRow();
$piso_tecnologico_list->EditRowCnt = 0;
if ($piso_tecnologico->CurrentAction == "edit")
	$piso_tecnologico_list->RowIndex = 1;
if ($piso_tecnologico->CurrentAction == "gridadd")
	$piso_tecnologico_list->RowIndex = 0;
if ($piso_tecnologico->CurrentAction == "gridedit")
	$piso_tecnologico_list->RowIndex = 0;
while ($piso_tecnologico_list->RecCnt < $piso_tecnologico_list->StopRec) {
	$piso_tecnologico_list->RecCnt++;
	if (intval($piso_tecnologico_list->RecCnt) >= intval($piso_tecnologico_list->StartRec)) {
		$piso_tecnologico_list->RowCnt++;
		if ($piso_tecnologico->CurrentAction == "gridadd" || $piso_tecnologico->CurrentAction == "gridedit" || $piso_tecnologico->CurrentAction == "F") {
			$piso_tecnologico_list->RowIndex++;
			$objForm->Index = $piso_tecnologico_list->RowIndex;
			if ($objForm->HasValue($piso_tecnologico_list->FormActionName))
				$piso_tecnologico_list->RowAction = strval($objForm->GetValue($piso_tecnologico_list->FormActionName));
			elseif ($piso_tecnologico->CurrentAction == "gridadd")
				$piso_tecnologico_list->RowAction = "insert";
			else
				$piso_tecnologico_list->RowAction = "";
		}

		// Set up key count
		$piso_tecnologico_list->KeyCount = $piso_tecnologico_list->RowIndex;

		// Init row class and style
		$piso_tecnologico->ResetAttrs();
		$piso_tecnologico->CssClass = "";
		if ($piso_tecnologico->CurrentAction == "gridadd") {
			$piso_tecnologico_list->LoadDefaultValues(); // Load default values
		} else {
			$piso_tecnologico_list->LoadRowValues($piso_tecnologico_list->Recordset); // Load row values
		}
		$piso_tecnologico->RowType = EW_ROWTYPE_VIEW; // Render view
		if ($piso_tecnologico->CurrentAction == "gridadd") // Grid add
			$piso_tecnologico->RowType = EW_ROWTYPE_ADD; // Render add
		if ($piso_tecnologico->CurrentAction == "gridadd" && $piso_tecnologico->EventCancelled && !$objForm->HasValue("k_blankrow")) // Insert failed
			$piso_tecnologico_list->RestoreCurrentRowFormValues($piso_tecnologico_list->RowIndex); // Restore form values
		if ($piso_tecnologico->CurrentAction == "edit") {
			if ($piso_tecnologico_list->CheckInlineEditKey() && $piso_tecnologico_list->EditRowCnt == 0) { // Inline edit
				$piso_tecnologico->RowType = EW_ROWTYPE_EDIT; // Render edit
			}
		}
		if ($piso_tecnologico->CurrentAction == "gridedit") { // Grid edit
			if ($piso_tecnologico->EventCancelled) {
				$piso_tecnologico_list->RestoreCurrentRowFormValues($piso_tecnologico_list->RowIndex); // Restore form values
			}
			if ($piso_tecnologico_list->RowAction == "insert")
				$piso_tecnologico->RowType = EW_ROWTYPE_ADD; // Render add
			else
				$piso_tecnologico->RowType = EW_ROWTYPE_EDIT; // Render edit
		}
		if ($piso_tecnologico->CurrentAction == "edit" && $piso_tecnologico->RowType == EW_ROWTYPE_EDIT && $piso_tecnologico->EventCancelled) { // Update failed
			$objForm->Index = 1;
			$piso_tecnologico_list->RestoreFormValues(); // Restore form values
		}
		if ($piso_tecnologico->CurrentAction == "gridedit" && ($piso_tecnologico->RowType == EW_ROWTYPE_EDIT || $piso_tecnologico->RowType == EW_ROWTYPE_ADD) && $piso_tecnologico->EventCancelled) // Update failed
			$piso_tecnologico_list->RestoreCurrentRowFormValues($piso_tecnologico_list->RowIndex); // Restore form values
		if ($piso_tecnologico->RowType == EW_ROWTYPE_EDIT) // Edit row
			$piso_tecnologico_list->EditRowCnt++;

		// Set up row id / data-rowindex
		$piso_tecnologico->RowAttrs = array_merge($piso_tecnologico->RowAttrs, array('data-rowindex'=>$piso_tecnologico_list->RowCnt, 'id'=>'r' . $piso_tecnologico_list->RowCnt . '_piso_tecnologico', 'data-rowtype'=>$piso_tecnologico->RowType));

		// Render row
		$piso_tecnologico_list->RenderRow();

		// Render list options
		$piso_tecnologico_list->RenderListOptions();

		// Skip delete row / empty row for confirm page
		if ($piso_tecnologico_list->RowAction <> "delete" && $piso_tecnologico_list->RowAction <> "insertdelete" && !($piso_tecnologico_list->RowAction == "insert" && $piso_tecnologico->CurrentAction == "F" && $piso_tecnologico_list->EmptyRow())) {
?>
	<tr<?php echo $piso_tecnologico->RowAttributes() ?>>
<?php

// Render list options (body, left)
$piso_tecnologico_list->ListOptions->Render("body", "left", $piso_tecnologico_list->RowCnt);
?>
	<?php if ($piso_tecnologico->Switch->Visible) { // Switch ?>
		<td data-name="Switch"<?php echo $piso_tecnologico->Switch->CellAttributes() ?>>
<?php if ($piso_tecnologico->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $piso_tecnologico_list->RowCnt ?>_piso_tecnologico_Switch" class="form-group piso_tecnologico_Switch">
<div id="tp_x<?php echo $piso_tecnologico_list->RowIndex ?>_Switch" class="ewTemplate"><input type="radio" data-table="piso_tecnologico" data-field="x_Switch" data-value-separator="<?php echo $piso_tecnologico->Switch->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $piso_tecnologico_list->RowIndex ?>_Switch" id="x<?php echo $piso_tecnologico_list->RowIndex ?>_Switch" value="{value}"<?php echo $piso_tecnologico->Switch->EditAttributes() ?>></div>
<div id="dsl_x<?php echo $piso_tecnologico_list->RowIndex ?>_Switch" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $piso_tecnologico->Switch->RadioButtonListHtml(FALSE, "x{$piso_tecnologico_list->RowIndex}_Switch") ?>
</div></div>
</span>
<input type="hidden" data-table="piso_tecnologico" data-field="x_Switch" name="o<?php echo $piso_tecnologico_list->RowIndex ?>_Switch" id="o<?php echo $piso_tecnologico_list->RowIndex ?>_Switch" value="<?php echo ew_HtmlEncode($piso_tecnologico->Switch->OldValue) ?>">
<?php } ?>
<?php if ($piso_tecnologico->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $piso_tecnologico_list->RowCnt ?>_piso_tecnologico_Switch" class="form-group piso_tecnologico_Switch">
<div id="tp_x<?php echo $piso_tecnologico_list->RowIndex ?>_Switch" class="ewTemplate"><input type="radio" data-table="piso_tecnologico" data-field="x_Switch" data-value-separator="<?php echo $piso_tecnologico->Switch->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $piso_tecnologico_list->RowIndex ?>_Switch" id="x<?php echo $piso_tecnologico_list->RowIndex ?>_Switch" value="{value}"<?php echo $piso_tecnologico->Switch->EditAttributes() ?>></div>
<div id="dsl_x<?php echo $piso_tecnologico_list->RowIndex ?>_Switch" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $piso_tecnologico->Switch->RadioButtonListHtml(FALSE, "x{$piso_tecnologico_list->RowIndex}_Switch") ?>
</div></div>
</span>
<?php } ?>
<?php if ($piso_tecnologico->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $piso_tecnologico_list->RowCnt ?>_piso_tecnologico_Switch" class="piso_tecnologico_Switch">
<span<?php echo $piso_tecnologico->Switch->ViewAttributes() ?>>
<?php echo $piso_tecnologico->Switch->ListViewValue() ?></span>
</span>
<?php } ?>
<a id="<?php echo $piso_tecnologico_list->PageObjName . "_row_" . $piso_tecnologico_list->RowCnt ?>"></a></td>
	<?php } ?>
<?php if ($piso_tecnologico->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="piso_tecnologico" data-field="x_Cue" name="x<?php echo $piso_tecnologico_list->RowIndex ?>_Cue" id="x<?php echo $piso_tecnologico_list->RowIndex ?>_Cue" value="<?php echo ew_HtmlEncode($piso_tecnologico->Cue->CurrentValue) ?>">
<input type="hidden" data-table="piso_tecnologico" data-field="x_Cue" name="o<?php echo $piso_tecnologico_list->RowIndex ?>_Cue" id="o<?php echo $piso_tecnologico_list->RowIndex ?>_Cue" value="<?php echo ew_HtmlEncode($piso_tecnologico->Cue->OldValue) ?>">
<?php } ?>
<?php if ($piso_tecnologico->RowType == EW_ROWTYPE_EDIT || $piso_tecnologico->CurrentMode == "edit") { ?>
<input type="hidden" data-table="piso_tecnologico" data-field="x_Cue" name="x<?php echo $piso_tecnologico_list->RowIndex ?>_Cue" id="x<?php echo $piso_tecnologico_list->RowIndex ?>_Cue" value="<?php echo ew_HtmlEncode($piso_tecnologico->Cue->CurrentValue) ?>">
<?php } ?>
	<?php if ($piso_tecnologico->Bocas_Switch->Visible) { // Bocas_Switch ?>
		<td data-name="Bocas_Switch"<?php echo $piso_tecnologico->Bocas_Switch->CellAttributes() ?>>
<?php if ($piso_tecnologico->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $piso_tecnologico_list->RowCnt ?>_piso_tecnologico_Bocas_Switch" class="form-group piso_tecnologico_Bocas_Switch">
<input type="text" data-table="piso_tecnologico" data-field="x_Bocas_Switch" name="x<?php echo $piso_tecnologico_list->RowIndex ?>_Bocas_Switch" id="x<?php echo $piso_tecnologico_list->RowIndex ?>_Bocas_Switch" size="30" placeholder="<?php echo ew_HtmlEncode($piso_tecnologico->Bocas_Switch->getPlaceHolder()) ?>" value="<?php echo $piso_tecnologico->Bocas_Switch->EditValue ?>"<?php echo $piso_tecnologico->Bocas_Switch->EditAttributes() ?>>
</span>
<input type="hidden" data-table="piso_tecnologico" data-field="x_Bocas_Switch" name="o<?php echo $piso_tecnologico_list->RowIndex ?>_Bocas_Switch" id="o<?php echo $piso_tecnologico_list->RowIndex ?>_Bocas_Switch" value="<?php echo ew_HtmlEncode($piso_tecnologico->Bocas_Switch->OldValue) ?>">
<?php } ?>
<?php if ($piso_tecnologico->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $piso_tecnologico_list->RowCnt ?>_piso_tecnologico_Bocas_Switch" class="form-group piso_tecnologico_Bocas_Switch">
<input type="text" data-table="piso_tecnologico" data-field="x_Bocas_Switch" name="x<?php echo $piso_tecnologico_list->RowIndex ?>_Bocas_Switch" id="x<?php echo $piso_tecnologico_list->RowIndex ?>_Bocas_Switch" size="30" placeholder="<?php echo ew_HtmlEncode($piso_tecnologico->Bocas_Switch->getPlaceHolder()) ?>" value="<?php echo $piso_tecnologico->Bocas_Switch->EditValue ?>"<?php echo $piso_tecnologico->Bocas_Switch->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($piso_tecnologico->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $piso_tecnologico_list->RowCnt ?>_piso_tecnologico_Bocas_Switch" class="piso_tecnologico_Bocas_Switch">
<span<?php echo $piso_tecnologico->Bocas_Switch->ViewAttributes() ?>>
<?php echo $piso_tecnologico->Bocas_Switch->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($piso_tecnologico->Estado_Switch->Visible) { // Estado_Switch ?>
		<td data-name="Estado_Switch"<?php echo $piso_tecnologico->Estado_Switch->CellAttributes() ?>>
<?php if ($piso_tecnologico->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $piso_tecnologico_list->RowCnt ?>_piso_tecnologico_Estado_Switch" class="form-group piso_tecnologico_Estado_Switch">
<select data-table="piso_tecnologico" data-field="x_Estado_Switch" data-value-separator="<?php echo $piso_tecnologico->Estado_Switch->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $piso_tecnologico_list->RowIndex ?>_Estado_Switch" name="x<?php echo $piso_tecnologico_list->RowIndex ?>_Estado_Switch"<?php echo $piso_tecnologico->Estado_Switch->EditAttributes() ?>>
<?php echo $piso_tecnologico->Estado_Switch->SelectOptionListHtml("x<?php echo $piso_tecnologico_list->RowIndex ?>_Estado_Switch") ?>
</select>
<input type="hidden" name="s_x<?php echo $piso_tecnologico_list->RowIndex ?>_Estado_Switch" id="s_x<?php echo $piso_tecnologico_list->RowIndex ?>_Estado_Switch" value="<?php echo $piso_tecnologico->Estado_Switch->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="piso_tecnologico" data-field="x_Estado_Switch" name="o<?php echo $piso_tecnologico_list->RowIndex ?>_Estado_Switch" id="o<?php echo $piso_tecnologico_list->RowIndex ?>_Estado_Switch" value="<?php echo ew_HtmlEncode($piso_tecnologico->Estado_Switch->OldValue) ?>">
<?php } ?>
<?php if ($piso_tecnologico->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $piso_tecnologico_list->RowCnt ?>_piso_tecnologico_Estado_Switch" class="form-group piso_tecnologico_Estado_Switch">
<select data-table="piso_tecnologico" data-field="x_Estado_Switch" data-value-separator="<?php echo $piso_tecnologico->Estado_Switch->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $piso_tecnologico_list->RowIndex ?>_Estado_Switch" name="x<?php echo $piso_tecnologico_list->RowIndex ?>_Estado_Switch"<?php echo $piso_tecnologico->Estado_Switch->EditAttributes() ?>>
<?php echo $piso_tecnologico->Estado_Switch->SelectOptionListHtml("x<?php echo $piso_tecnologico_list->RowIndex ?>_Estado_Switch") ?>
</select>
<input type="hidden" name="s_x<?php echo $piso_tecnologico_list->RowIndex ?>_Estado_Switch" id="s_x<?php echo $piso_tecnologico_list->RowIndex ?>_Estado_Switch" value="<?php echo $piso_tecnologico->Estado_Switch->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php if ($piso_tecnologico->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $piso_tecnologico_list->RowCnt ?>_piso_tecnologico_Estado_Switch" class="piso_tecnologico_Estado_Switch">
<span<?php echo $piso_tecnologico->Estado_Switch->ViewAttributes() ?>>
<?php echo $piso_tecnologico->Estado_Switch->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($piso_tecnologico->Cantidad_Ap->Visible) { // Cantidad_Ap ?>
		<td data-name="Cantidad_Ap"<?php echo $piso_tecnologico->Cantidad_Ap->CellAttributes() ?>>
<?php if ($piso_tecnologico->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $piso_tecnologico_list->RowCnt ?>_piso_tecnologico_Cantidad_Ap" class="form-group piso_tecnologico_Cantidad_Ap">
<input type="text" data-table="piso_tecnologico" data-field="x_Cantidad_Ap" name="x<?php echo $piso_tecnologico_list->RowIndex ?>_Cantidad_Ap" id="x<?php echo $piso_tecnologico_list->RowIndex ?>_Cantidad_Ap" size="30" maxlength="2" placeholder="<?php echo ew_HtmlEncode($piso_tecnologico->Cantidad_Ap->getPlaceHolder()) ?>" value="<?php echo $piso_tecnologico->Cantidad_Ap->EditValue ?>"<?php echo $piso_tecnologico->Cantidad_Ap->EditAttributes() ?>>
</span>
<input type="hidden" data-table="piso_tecnologico" data-field="x_Cantidad_Ap" name="o<?php echo $piso_tecnologico_list->RowIndex ?>_Cantidad_Ap" id="o<?php echo $piso_tecnologico_list->RowIndex ?>_Cantidad_Ap" value="<?php echo ew_HtmlEncode($piso_tecnologico->Cantidad_Ap->OldValue) ?>">
<?php } ?>
<?php if ($piso_tecnologico->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $piso_tecnologico_list->RowCnt ?>_piso_tecnologico_Cantidad_Ap" class="form-group piso_tecnologico_Cantidad_Ap">
<input type="text" data-table="piso_tecnologico" data-field="x_Cantidad_Ap" name="x<?php echo $piso_tecnologico_list->RowIndex ?>_Cantidad_Ap" id="x<?php echo $piso_tecnologico_list->RowIndex ?>_Cantidad_Ap" size="30" maxlength="2" placeholder="<?php echo ew_HtmlEncode($piso_tecnologico->Cantidad_Ap->getPlaceHolder()) ?>" value="<?php echo $piso_tecnologico->Cantidad_Ap->EditValue ?>"<?php echo $piso_tecnologico->Cantidad_Ap->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($piso_tecnologico->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $piso_tecnologico_list->RowCnt ?>_piso_tecnologico_Cantidad_Ap" class="piso_tecnologico_Cantidad_Ap">
<span<?php echo $piso_tecnologico->Cantidad_Ap->ViewAttributes() ?>>
<?php echo $piso_tecnologico->Cantidad_Ap->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($piso_tecnologico->Cantidad_Ap_Func->Visible) { // Cantidad_Ap_Func ?>
		<td data-name="Cantidad_Ap_Func"<?php echo $piso_tecnologico->Cantidad_Ap_Func->CellAttributes() ?>>
<?php if ($piso_tecnologico->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $piso_tecnologico_list->RowCnt ?>_piso_tecnologico_Cantidad_Ap_Func" class="form-group piso_tecnologico_Cantidad_Ap_Func">
<input type="text" data-table="piso_tecnologico" data-field="x_Cantidad_Ap_Func" name="x<?php echo $piso_tecnologico_list->RowIndex ?>_Cantidad_Ap_Func" id="x<?php echo $piso_tecnologico_list->RowIndex ?>_Cantidad_Ap_Func" size="30" maxlength="3" placeholder="<?php echo ew_HtmlEncode($piso_tecnologico->Cantidad_Ap_Func->getPlaceHolder()) ?>" value="<?php echo $piso_tecnologico->Cantidad_Ap_Func->EditValue ?>"<?php echo $piso_tecnologico->Cantidad_Ap_Func->EditAttributes() ?>>
</span>
<input type="hidden" data-table="piso_tecnologico" data-field="x_Cantidad_Ap_Func" name="o<?php echo $piso_tecnologico_list->RowIndex ?>_Cantidad_Ap_Func" id="o<?php echo $piso_tecnologico_list->RowIndex ?>_Cantidad_Ap_Func" value="<?php echo ew_HtmlEncode($piso_tecnologico->Cantidad_Ap_Func->OldValue) ?>">
<?php } ?>
<?php if ($piso_tecnologico->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $piso_tecnologico_list->RowCnt ?>_piso_tecnologico_Cantidad_Ap_Func" class="form-group piso_tecnologico_Cantidad_Ap_Func">
<input type="text" data-table="piso_tecnologico" data-field="x_Cantidad_Ap_Func" name="x<?php echo $piso_tecnologico_list->RowIndex ?>_Cantidad_Ap_Func" id="x<?php echo $piso_tecnologico_list->RowIndex ?>_Cantidad_Ap_Func" size="30" maxlength="3" placeholder="<?php echo ew_HtmlEncode($piso_tecnologico->Cantidad_Ap_Func->getPlaceHolder()) ?>" value="<?php echo $piso_tecnologico->Cantidad_Ap_Func->EditValue ?>"<?php echo $piso_tecnologico->Cantidad_Ap_Func->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($piso_tecnologico->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $piso_tecnologico_list->RowCnt ?>_piso_tecnologico_Cantidad_Ap_Func" class="piso_tecnologico_Cantidad_Ap_Func">
<span<?php echo $piso_tecnologico->Cantidad_Ap_Func->ViewAttributes() ?>>
<?php echo $piso_tecnologico->Cantidad_Ap_Func->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($piso_tecnologico->Ups->Visible) { // Ups ?>
		<td data-name="Ups"<?php echo $piso_tecnologico->Ups->CellAttributes() ?>>
<?php if ($piso_tecnologico->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $piso_tecnologico_list->RowCnt ?>_piso_tecnologico_Ups" class="form-group piso_tecnologico_Ups">
<div id="tp_x<?php echo $piso_tecnologico_list->RowIndex ?>_Ups" class="ewTemplate"><input type="radio" data-table="piso_tecnologico" data-field="x_Ups" data-value-separator="<?php echo $piso_tecnologico->Ups->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $piso_tecnologico_list->RowIndex ?>_Ups" id="x<?php echo $piso_tecnologico_list->RowIndex ?>_Ups" value="{value}"<?php echo $piso_tecnologico->Ups->EditAttributes() ?>></div>
<div id="dsl_x<?php echo $piso_tecnologico_list->RowIndex ?>_Ups" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $piso_tecnologico->Ups->RadioButtonListHtml(FALSE, "x{$piso_tecnologico_list->RowIndex}_Ups") ?>
</div></div>
</span>
<input type="hidden" data-table="piso_tecnologico" data-field="x_Ups" name="o<?php echo $piso_tecnologico_list->RowIndex ?>_Ups" id="o<?php echo $piso_tecnologico_list->RowIndex ?>_Ups" value="<?php echo ew_HtmlEncode($piso_tecnologico->Ups->OldValue) ?>">
<?php } ?>
<?php if ($piso_tecnologico->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $piso_tecnologico_list->RowCnt ?>_piso_tecnologico_Ups" class="form-group piso_tecnologico_Ups">
<div id="tp_x<?php echo $piso_tecnologico_list->RowIndex ?>_Ups" class="ewTemplate"><input type="radio" data-table="piso_tecnologico" data-field="x_Ups" data-value-separator="<?php echo $piso_tecnologico->Ups->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $piso_tecnologico_list->RowIndex ?>_Ups" id="x<?php echo $piso_tecnologico_list->RowIndex ?>_Ups" value="{value}"<?php echo $piso_tecnologico->Ups->EditAttributes() ?>></div>
<div id="dsl_x<?php echo $piso_tecnologico_list->RowIndex ?>_Ups" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $piso_tecnologico->Ups->RadioButtonListHtml(FALSE, "x{$piso_tecnologico_list->RowIndex}_Ups") ?>
</div></div>
</span>
<?php } ?>
<?php if ($piso_tecnologico->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $piso_tecnologico_list->RowCnt ?>_piso_tecnologico_Ups" class="piso_tecnologico_Ups">
<span<?php echo $piso_tecnologico->Ups->ViewAttributes() ?>>
<?php echo $piso_tecnologico->Ups->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($piso_tecnologico->Estado_Ups->Visible) { // Estado_Ups ?>
		<td data-name="Estado_Ups"<?php echo $piso_tecnologico->Estado_Ups->CellAttributes() ?>>
<?php if ($piso_tecnologico->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $piso_tecnologico_list->RowCnt ?>_piso_tecnologico_Estado_Ups" class="form-group piso_tecnologico_Estado_Ups">
<select data-table="piso_tecnologico" data-field="x_Estado_Ups" data-value-separator="<?php echo $piso_tecnologico->Estado_Ups->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $piso_tecnologico_list->RowIndex ?>_Estado_Ups" name="x<?php echo $piso_tecnologico_list->RowIndex ?>_Estado_Ups"<?php echo $piso_tecnologico->Estado_Ups->EditAttributes() ?>>
<?php echo $piso_tecnologico->Estado_Ups->SelectOptionListHtml("x<?php echo $piso_tecnologico_list->RowIndex ?>_Estado_Ups") ?>
</select>
<input type="hidden" name="s_x<?php echo $piso_tecnologico_list->RowIndex ?>_Estado_Ups" id="s_x<?php echo $piso_tecnologico_list->RowIndex ?>_Estado_Ups" value="<?php echo $piso_tecnologico->Estado_Ups->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="piso_tecnologico" data-field="x_Estado_Ups" name="o<?php echo $piso_tecnologico_list->RowIndex ?>_Estado_Ups" id="o<?php echo $piso_tecnologico_list->RowIndex ?>_Estado_Ups" value="<?php echo ew_HtmlEncode($piso_tecnologico->Estado_Ups->OldValue) ?>">
<?php } ?>
<?php if ($piso_tecnologico->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $piso_tecnologico_list->RowCnt ?>_piso_tecnologico_Estado_Ups" class="form-group piso_tecnologico_Estado_Ups">
<select data-table="piso_tecnologico" data-field="x_Estado_Ups" data-value-separator="<?php echo $piso_tecnologico->Estado_Ups->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $piso_tecnologico_list->RowIndex ?>_Estado_Ups" name="x<?php echo $piso_tecnologico_list->RowIndex ?>_Estado_Ups"<?php echo $piso_tecnologico->Estado_Ups->EditAttributes() ?>>
<?php echo $piso_tecnologico->Estado_Ups->SelectOptionListHtml("x<?php echo $piso_tecnologico_list->RowIndex ?>_Estado_Ups") ?>
</select>
<input type="hidden" name="s_x<?php echo $piso_tecnologico_list->RowIndex ?>_Estado_Ups" id="s_x<?php echo $piso_tecnologico_list->RowIndex ?>_Estado_Ups" value="<?php echo $piso_tecnologico->Estado_Ups->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php if ($piso_tecnologico->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $piso_tecnologico_list->RowCnt ?>_piso_tecnologico_Estado_Ups" class="piso_tecnologico_Estado_Ups">
<span<?php echo $piso_tecnologico->Estado_Ups->ViewAttributes() ?>>
<?php echo $piso_tecnologico->Estado_Ups->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($piso_tecnologico->Cableado->Visible) { // Cableado ?>
		<td data-name="Cableado"<?php echo $piso_tecnologico->Cableado->CellAttributes() ?>>
<?php if ($piso_tecnologico->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $piso_tecnologico_list->RowCnt ?>_piso_tecnologico_Cableado" class="form-group piso_tecnologico_Cableado">
<div id="tp_x<?php echo $piso_tecnologico_list->RowIndex ?>_Cableado" class="ewTemplate"><input type="radio" data-table="piso_tecnologico" data-field="x_Cableado" data-value-separator="<?php echo $piso_tecnologico->Cableado->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $piso_tecnologico_list->RowIndex ?>_Cableado" id="x<?php echo $piso_tecnologico_list->RowIndex ?>_Cableado" value="{value}"<?php echo $piso_tecnologico->Cableado->EditAttributes() ?>></div>
<div id="dsl_x<?php echo $piso_tecnologico_list->RowIndex ?>_Cableado" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $piso_tecnologico->Cableado->RadioButtonListHtml(FALSE, "x{$piso_tecnologico_list->RowIndex}_Cableado") ?>
</div></div>
</span>
<input type="hidden" data-table="piso_tecnologico" data-field="x_Cableado" name="o<?php echo $piso_tecnologico_list->RowIndex ?>_Cableado" id="o<?php echo $piso_tecnologico_list->RowIndex ?>_Cableado" value="<?php echo ew_HtmlEncode($piso_tecnologico->Cableado->OldValue) ?>">
<?php } ?>
<?php if ($piso_tecnologico->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $piso_tecnologico_list->RowCnt ?>_piso_tecnologico_Cableado" class="form-group piso_tecnologico_Cableado">
<div id="tp_x<?php echo $piso_tecnologico_list->RowIndex ?>_Cableado" class="ewTemplate"><input type="radio" data-table="piso_tecnologico" data-field="x_Cableado" data-value-separator="<?php echo $piso_tecnologico->Cableado->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $piso_tecnologico_list->RowIndex ?>_Cableado" id="x<?php echo $piso_tecnologico_list->RowIndex ?>_Cableado" value="{value}"<?php echo $piso_tecnologico->Cableado->EditAttributes() ?>></div>
<div id="dsl_x<?php echo $piso_tecnologico_list->RowIndex ?>_Cableado" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $piso_tecnologico->Cableado->RadioButtonListHtml(FALSE, "x{$piso_tecnologico_list->RowIndex}_Cableado") ?>
</div></div>
</span>
<?php } ?>
<?php if ($piso_tecnologico->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $piso_tecnologico_list->RowCnt ?>_piso_tecnologico_Cableado" class="piso_tecnologico_Cableado">
<span<?php echo $piso_tecnologico->Cableado->ViewAttributes() ?>>
<?php echo $piso_tecnologico->Cableado->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($piso_tecnologico->Estado_Cableado->Visible) { // Estado_Cableado ?>
		<td data-name="Estado_Cableado"<?php echo $piso_tecnologico->Estado_Cableado->CellAttributes() ?>>
<?php if ($piso_tecnologico->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $piso_tecnologico_list->RowCnt ?>_piso_tecnologico_Estado_Cableado" class="form-group piso_tecnologico_Estado_Cableado">
<select data-table="piso_tecnologico" data-field="x_Estado_Cableado" data-value-separator="<?php echo $piso_tecnologico->Estado_Cableado->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $piso_tecnologico_list->RowIndex ?>_Estado_Cableado" name="x<?php echo $piso_tecnologico_list->RowIndex ?>_Estado_Cableado"<?php echo $piso_tecnologico->Estado_Cableado->EditAttributes() ?>>
<?php echo $piso_tecnologico->Estado_Cableado->SelectOptionListHtml("x<?php echo $piso_tecnologico_list->RowIndex ?>_Estado_Cableado") ?>
</select>
<input type="hidden" name="s_x<?php echo $piso_tecnologico_list->RowIndex ?>_Estado_Cableado" id="s_x<?php echo $piso_tecnologico_list->RowIndex ?>_Estado_Cableado" value="<?php echo $piso_tecnologico->Estado_Cableado->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="piso_tecnologico" data-field="x_Estado_Cableado" name="o<?php echo $piso_tecnologico_list->RowIndex ?>_Estado_Cableado" id="o<?php echo $piso_tecnologico_list->RowIndex ?>_Estado_Cableado" value="<?php echo ew_HtmlEncode($piso_tecnologico->Estado_Cableado->OldValue) ?>">
<?php } ?>
<?php if ($piso_tecnologico->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $piso_tecnologico_list->RowCnt ?>_piso_tecnologico_Estado_Cableado" class="form-group piso_tecnologico_Estado_Cableado">
<select data-table="piso_tecnologico" data-field="x_Estado_Cableado" data-value-separator="<?php echo $piso_tecnologico->Estado_Cableado->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $piso_tecnologico_list->RowIndex ?>_Estado_Cableado" name="x<?php echo $piso_tecnologico_list->RowIndex ?>_Estado_Cableado"<?php echo $piso_tecnologico->Estado_Cableado->EditAttributes() ?>>
<?php echo $piso_tecnologico->Estado_Cableado->SelectOptionListHtml("x<?php echo $piso_tecnologico_list->RowIndex ?>_Estado_Cableado") ?>
</select>
<input type="hidden" name="s_x<?php echo $piso_tecnologico_list->RowIndex ?>_Estado_Cableado" id="s_x<?php echo $piso_tecnologico_list->RowIndex ?>_Estado_Cableado" value="<?php echo $piso_tecnologico->Estado_Cableado->LookupFilterQuery() ?>">
</span>
<?php } ?>
<?php if ($piso_tecnologico->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $piso_tecnologico_list->RowCnt ?>_piso_tecnologico_Estado_Cableado" class="piso_tecnologico_Estado_Cableado">
<span<?php echo $piso_tecnologico->Estado_Cableado->ViewAttributes() ?>>
<?php echo $piso_tecnologico->Estado_Cableado->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($piso_tecnologico->Porcent_Estado_Cab->Visible) { // Porcent_Estado_Cab ?>
		<td data-name="Porcent_Estado_Cab"<?php echo $piso_tecnologico->Porcent_Estado_Cab->CellAttributes() ?>>
<?php if ($piso_tecnologico->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $piso_tecnologico_list->RowCnt ?>_piso_tecnologico_Porcent_Estado_Cab" class="form-group piso_tecnologico_Porcent_Estado_Cab">
<input type="text" data-table="piso_tecnologico" data-field="x_Porcent_Estado_Cab" name="x<?php echo $piso_tecnologico_list->RowIndex ?>_Porcent_Estado_Cab" id="x<?php echo $piso_tecnologico_list->RowIndex ?>_Porcent_Estado_Cab" size="30" maxlength="3" placeholder="<?php echo ew_HtmlEncode($piso_tecnologico->Porcent_Estado_Cab->getPlaceHolder()) ?>" value="<?php echo $piso_tecnologico->Porcent_Estado_Cab->EditValue ?>"<?php echo $piso_tecnologico->Porcent_Estado_Cab->EditAttributes() ?>>
</span>
<input type="hidden" data-table="piso_tecnologico" data-field="x_Porcent_Estado_Cab" name="o<?php echo $piso_tecnologico_list->RowIndex ?>_Porcent_Estado_Cab" id="o<?php echo $piso_tecnologico_list->RowIndex ?>_Porcent_Estado_Cab" value="<?php echo ew_HtmlEncode($piso_tecnologico->Porcent_Estado_Cab->OldValue) ?>">
<?php } ?>
<?php if ($piso_tecnologico->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $piso_tecnologico_list->RowCnt ?>_piso_tecnologico_Porcent_Estado_Cab" class="form-group piso_tecnologico_Porcent_Estado_Cab">
<input type="text" data-table="piso_tecnologico" data-field="x_Porcent_Estado_Cab" name="x<?php echo $piso_tecnologico_list->RowIndex ?>_Porcent_Estado_Cab" id="x<?php echo $piso_tecnologico_list->RowIndex ?>_Porcent_Estado_Cab" size="30" maxlength="3" placeholder="<?php echo ew_HtmlEncode($piso_tecnologico->Porcent_Estado_Cab->getPlaceHolder()) ?>" value="<?php echo $piso_tecnologico->Porcent_Estado_Cab->EditValue ?>"<?php echo $piso_tecnologico->Porcent_Estado_Cab->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($piso_tecnologico->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $piso_tecnologico_list->RowCnt ?>_piso_tecnologico_Porcent_Estado_Cab" class="piso_tecnologico_Porcent_Estado_Cab">
<span<?php echo $piso_tecnologico->Porcent_Estado_Cab->ViewAttributes() ?>>
<?php echo $piso_tecnologico->Porcent_Estado_Cab->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($piso_tecnologico->Porcent_Func_Piso->Visible) { // Porcent_Func_Piso ?>
		<td data-name="Porcent_Func_Piso"<?php echo $piso_tecnologico->Porcent_Func_Piso->CellAttributes() ?>>
<?php if ($piso_tecnologico->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $piso_tecnologico_list->RowCnt ?>_piso_tecnologico_Porcent_Func_Piso" class="form-group piso_tecnologico_Porcent_Func_Piso">
<input type="text" data-table="piso_tecnologico" data-field="x_Porcent_Func_Piso" name="x<?php echo $piso_tecnologico_list->RowIndex ?>_Porcent_Func_Piso" id="x<?php echo $piso_tecnologico_list->RowIndex ?>_Porcent_Func_Piso" size="30" maxlength="3" placeholder="<?php echo ew_HtmlEncode($piso_tecnologico->Porcent_Func_Piso->getPlaceHolder()) ?>" value="<?php echo $piso_tecnologico->Porcent_Func_Piso->EditValue ?>"<?php echo $piso_tecnologico->Porcent_Func_Piso->EditAttributes() ?>>
</span>
<input type="hidden" data-table="piso_tecnologico" data-field="x_Porcent_Func_Piso" name="o<?php echo $piso_tecnologico_list->RowIndex ?>_Porcent_Func_Piso" id="o<?php echo $piso_tecnologico_list->RowIndex ?>_Porcent_Func_Piso" value="<?php echo ew_HtmlEncode($piso_tecnologico->Porcent_Func_Piso->OldValue) ?>">
<?php } ?>
<?php if ($piso_tecnologico->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $piso_tecnologico_list->RowCnt ?>_piso_tecnologico_Porcent_Func_Piso" class="form-group piso_tecnologico_Porcent_Func_Piso">
<input type="text" data-table="piso_tecnologico" data-field="x_Porcent_Func_Piso" name="x<?php echo $piso_tecnologico_list->RowIndex ?>_Porcent_Func_Piso" id="x<?php echo $piso_tecnologico_list->RowIndex ?>_Porcent_Func_Piso" size="30" maxlength="3" placeholder="<?php echo ew_HtmlEncode($piso_tecnologico->Porcent_Func_Piso->getPlaceHolder()) ?>" value="<?php echo $piso_tecnologico->Porcent_Func_Piso->EditValue ?>"<?php echo $piso_tecnologico->Porcent_Func_Piso->EditAttributes() ?>>
</span>
<?php } ?>
<?php if ($piso_tecnologico->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $piso_tecnologico_list->RowCnt ?>_piso_tecnologico_Porcent_Func_Piso" class="piso_tecnologico_Porcent_Func_Piso">
<span<?php echo $piso_tecnologico->Porcent_Func_Piso->ViewAttributes() ?>>
<?php echo $piso_tecnologico->Porcent_Func_Piso->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($piso_tecnologico->Plano_Escuela->Visible) { // Plano_Escuela ?>
		<td data-name="Plano_Escuela"<?php echo $piso_tecnologico->Plano_Escuela->CellAttributes() ?>>
<?php if ($piso_tecnologico->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<span id="el<?php echo $piso_tecnologico_list->RowCnt ?>_piso_tecnologico_Plano_Escuela" class="form-group piso_tecnologico_Plano_Escuela">
<div id="fd_x<?php echo $piso_tecnologico_list->RowIndex ?>_Plano_Escuela">
<span title="<?php echo $piso_tecnologico->Plano_Escuela->FldTitle() ? $piso_tecnologico->Plano_Escuela->FldTitle() : $Language->Phrase("ChooseFiles") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($piso_tecnologico->Plano_Escuela->ReadOnly || $piso_tecnologico->Plano_Escuela->Disabled) echo " hide"; ?>">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="piso_tecnologico" data-field="x_Plano_Escuela" name="x<?php echo $piso_tecnologico_list->RowIndex ?>_Plano_Escuela" id="x<?php echo $piso_tecnologico_list->RowIndex ?>_Plano_Escuela" multiple="multiple"<?php echo $piso_tecnologico->Plano_Escuela->EditAttributes() ?>>
</span>
<input type="hidden" name="fn_x<?php echo $piso_tecnologico_list->RowIndex ?>_Plano_Escuela" id= "fn_x<?php echo $piso_tecnologico_list->RowIndex ?>_Plano_Escuela" value="<?php echo $piso_tecnologico->Plano_Escuela->Upload->FileName ?>">
<input type="hidden" name="fa_x<?php echo $piso_tecnologico_list->RowIndex ?>_Plano_Escuela" id= "fa_x<?php echo $piso_tecnologico_list->RowIndex ?>_Plano_Escuela" value="0">
<input type="hidden" name="fs_x<?php echo $piso_tecnologico_list->RowIndex ?>_Plano_Escuela" id= "fs_x<?php echo $piso_tecnologico_list->RowIndex ?>_Plano_Escuela" value="65535">
<input type="hidden" name="fx_x<?php echo $piso_tecnologico_list->RowIndex ?>_Plano_Escuela" id= "fx_x<?php echo $piso_tecnologico_list->RowIndex ?>_Plano_Escuela" value="<?php echo $piso_tecnologico->Plano_Escuela->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?php echo $piso_tecnologico_list->RowIndex ?>_Plano_Escuela" id= "fm_x<?php echo $piso_tecnologico_list->RowIndex ?>_Plano_Escuela" value="<?php echo $piso_tecnologico->Plano_Escuela->UploadMaxFileSize ?>">
<input type="hidden" name="fc_x<?php echo $piso_tecnologico_list->RowIndex ?>_Plano_Escuela" id= "fc_x<?php echo $piso_tecnologico_list->RowIndex ?>_Plano_Escuela" value="<?php echo $piso_tecnologico->Plano_Escuela->UploadMaxFileCount ?>">
</div>
<table id="ft_x<?php echo $piso_tecnologico_list->RowIndex ?>_Plano_Escuela" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<input type="hidden" data-table="piso_tecnologico" data-field="x_Plano_Escuela" name="o<?php echo $piso_tecnologico_list->RowIndex ?>_Plano_Escuela" id="o<?php echo $piso_tecnologico_list->RowIndex ?>_Plano_Escuela" value="<?php echo ew_HtmlEncode($piso_tecnologico->Plano_Escuela->OldValue) ?>">
<?php } ?>
<?php if ($piso_tecnologico->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<span id="el<?php echo $piso_tecnologico_list->RowCnt ?>_piso_tecnologico_Plano_Escuela" class="form-group piso_tecnologico_Plano_Escuela">
<div id="fd_x<?php echo $piso_tecnologico_list->RowIndex ?>_Plano_Escuela">
<span title="<?php echo $piso_tecnologico->Plano_Escuela->FldTitle() ? $piso_tecnologico->Plano_Escuela->FldTitle() : $Language->Phrase("ChooseFiles") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($piso_tecnologico->Plano_Escuela->ReadOnly || $piso_tecnologico->Plano_Escuela->Disabled) echo " hide"; ?>">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="piso_tecnologico" data-field="x_Plano_Escuela" name="x<?php echo $piso_tecnologico_list->RowIndex ?>_Plano_Escuela" id="x<?php echo $piso_tecnologico_list->RowIndex ?>_Plano_Escuela" multiple="multiple"<?php echo $piso_tecnologico->Plano_Escuela->EditAttributes() ?>>
</span>
<input type="hidden" name="fn_x<?php echo $piso_tecnologico_list->RowIndex ?>_Plano_Escuela" id= "fn_x<?php echo $piso_tecnologico_list->RowIndex ?>_Plano_Escuela" value="<?php echo $piso_tecnologico->Plano_Escuela->Upload->FileName ?>">
<?php if (@$_POST["fa_x<?php echo $piso_tecnologico_list->RowIndex ?>_Plano_Escuela"] == "0") { ?>
<input type="hidden" name="fa_x<?php echo $piso_tecnologico_list->RowIndex ?>_Plano_Escuela" id= "fa_x<?php echo $piso_tecnologico_list->RowIndex ?>_Plano_Escuela" value="0">
<?php } else { ?>
<input type="hidden" name="fa_x<?php echo $piso_tecnologico_list->RowIndex ?>_Plano_Escuela" id= "fa_x<?php echo $piso_tecnologico_list->RowIndex ?>_Plano_Escuela" value="1">
<?php } ?>
<input type="hidden" name="fs_x<?php echo $piso_tecnologico_list->RowIndex ?>_Plano_Escuela" id= "fs_x<?php echo $piso_tecnologico_list->RowIndex ?>_Plano_Escuela" value="65535">
<input type="hidden" name="fx_x<?php echo $piso_tecnologico_list->RowIndex ?>_Plano_Escuela" id= "fx_x<?php echo $piso_tecnologico_list->RowIndex ?>_Plano_Escuela" value="<?php echo $piso_tecnologico->Plano_Escuela->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?php echo $piso_tecnologico_list->RowIndex ?>_Plano_Escuela" id= "fm_x<?php echo $piso_tecnologico_list->RowIndex ?>_Plano_Escuela" value="<?php echo $piso_tecnologico->Plano_Escuela->UploadMaxFileSize ?>">
<input type="hidden" name="fc_x<?php echo $piso_tecnologico_list->RowIndex ?>_Plano_Escuela" id= "fc_x<?php echo $piso_tecnologico_list->RowIndex ?>_Plano_Escuela" value="<?php echo $piso_tecnologico->Plano_Escuela->UploadMaxFileCount ?>">
</div>
<table id="ft_x<?php echo $piso_tecnologico_list->RowIndex ?>_Plano_Escuela" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<?php } ?>
<?php if ($piso_tecnologico->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $piso_tecnologico_list->RowCnt ?>_piso_tecnologico_Plano_Escuela" class="piso_tecnologico_Plano_Escuela">
<span<?php echo $piso_tecnologico->Plano_Escuela->ViewAttributes() ?>>
<?php echo ew_GetFileViewTag($piso_tecnologico->Plano_Escuela, $piso_tecnologico->Plano_Escuela->ListViewValue()) ?>
</span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($piso_tecnologico->Fecha_Actualizacion->Visible) { // Fecha_Actualizacion ?>
		<td data-name="Fecha_Actualizacion"<?php echo $piso_tecnologico->Fecha_Actualizacion->CellAttributes() ?>>
<?php if ($piso_tecnologico->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="piso_tecnologico" data-field="x_Fecha_Actualizacion" name="o<?php echo $piso_tecnologico_list->RowIndex ?>_Fecha_Actualizacion" id="o<?php echo $piso_tecnologico_list->RowIndex ?>_Fecha_Actualizacion" value="<?php echo ew_HtmlEncode($piso_tecnologico->Fecha_Actualizacion->OldValue) ?>">
<?php } ?>
<?php if ($piso_tecnologico->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php } ?>
<?php if ($piso_tecnologico->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $piso_tecnologico_list->RowCnt ?>_piso_tecnologico_Fecha_Actualizacion" class="piso_tecnologico_Fecha_Actualizacion">
<span<?php echo $piso_tecnologico->Fecha_Actualizacion->ViewAttributes() ?>>
<?php echo $piso_tecnologico->Fecha_Actualizacion->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
	<?php if ($piso_tecnologico->Usuario->Visible) { // Usuario ?>
		<td data-name="Usuario"<?php echo $piso_tecnologico->Usuario->CellAttributes() ?>>
<?php if ($piso_tecnologico->RowType == EW_ROWTYPE_ADD) { // Add record ?>
<input type="hidden" data-table="piso_tecnologico" data-field="x_Usuario" name="o<?php echo $piso_tecnologico_list->RowIndex ?>_Usuario" id="o<?php echo $piso_tecnologico_list->RowIndex ?>_Usuario" value="<?php echo ew_HtmlEncode($piso_tecnologico->Usuario->OldValue) ?>">
<?php } ?>
<?php if ($piso_tecnologico->RowType == EW_ROWTYPE_EDIT) { // Edit record ?>
<?php } ?>
<?php if ($piso_tecnologico->RowType == EW_ROWTYPE_VIEW) { // View record ?>
<span id="el<?php echo $piso_tecnologico_list->RowCnt ?>_piso_tecnologico_Usuario" class="piso_tecnologico_Usuario">
<span<?php echo $piso_tecnologico->Usuario->ViewAttributes() ?>>
<?php echo $piso_tecnologico->Usuario->ListViewValue() ?></span>
</span>
<?php } ?>
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$piso_tecnologico_list->ListOptions->Render("body", "right", $piso_tecnologico_list->RowCnt);
?>
	</tr>
<?php if ($piso_tecnologico->RowType == EW_ROWTYPE_ADD || $piso_tecnologico->RowType == EW_ROWTYPE_EDIT) { ?>
<script type="text/javascript">
fpiso_tecnologicolist.UpdateOpts(<?php echo $piso_tecnologico_list->RowIndex ?>);
</script>
<?php } ?>
<?php
	}
	} // End delete row checking
	if ($piso_tecnologico->CurrentAction <> "gridadd")
		if (!$piso_tecnologico_list->Recordset->EOF) $piso_tecnologico_list->Recordset->MoveNext();
}
?>
<?php
	if ($piso_tecnologico->CurrentAction == "gridadd" || $piso_tecnologico->CurrentAction == "gridedit") {
		$piso_tecnologico_list->RowIndex = '$rowindex$';
		$piso_tecnologico_list->LoadDefaultValues();

		// Set row properties
		$piso_tecnologico->ResetAttrs();
		$piso_tecnologico->RowAttrs = array_merge($piso_tecnologico->RowAttrs, array('data-rowindex'=>$piso_tecnologico_list->RowIndex, 'id'=>'r0_piso_tecnologico', 'data-rowtype'=>EW_ROWTYPE_ADD));
		ew_AppendClass($piso_tecnologico->RowAttrs["class"], "ewTemplate");
		$piso_tecnologico->RowType = EW_ROWTYPE_ADD;

		// Render row
		$piso_tecnologico_list->RenderRow();

		// Render list options
		$piso_tecnologico_list->RenderListOptions();
		$piso_tecnologico_list->StartRowCnt = 0;
?>
	<tr<?php echo $piso_tecnologico->RowAttributes() ?>>
<?php

// Render list options (body, left)
$piso_tecnologico_list->ListOptions->Render("body", "left", $piso_tecnologico_list->RowIndex);
?>
	<?php if ($piso_tecnologico->Switch->Visible) { // Switch ?>
		<td data-name="Switch">
<span id="el$rowindex$_piso_tecnologico_Switch" class="form-group piso_tecnologico_Switch">
<div id="tp_x<?php echo $piso_tecnologico_list->RowIndex ?>_Switch" class="ewTemplate"><input type="radio" data-table="piso_tecnologico" data-field="x_Switch" data-value-separator="<?php echo $piso_tecnologico->Switch->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $piso_tecnologico_list->RowIndex ?>_Switch" id="x<?php echo $piso_tecnologico_list->RowIndex ?>_Switch" value="{value}"<?php echo $piso_tecnologico->Switch->EditAttributes() ?>></div>
<div id="dsl_x<?php echo $piso_tecnologico_list->RowIndex ?>_Switch" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $piso_tecnologico->Switch->RadioButtonListHtml(FALSE, "x{$piso_tecnologico_list->RowIndex}_Switch") ?>
</div></div>
</span>
<input type="hidden" data-table="piso_tecnologico" data-field="x_Switch" name="o<?php echo $piso_tecnologico_list->RowIndex ?>_Switch" id="o<?php echo $piso_tecnologico_list->RowIndex ?>_Switch" value="<?php echo ew_HtmlEncode($piso_tecnologico->Switch->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($piso_tecnologico->Bocas_Switch->Visible) { // Bocas_Switch ?>
		<td data-name="Bocas_Switch">
<span id="el$rowindex$_piso_tecnologico_Bocas_Switch" class="form-group piso_tecnologico_Bocas_Switch">
<input type="text" data-table="piso_tecnologico" data-field="x_Bocas_Switch" name="x<?php echo $piso_tecnologico_list->RowIndex ?>_Bocas_Switch" id="x<?php echo $piso_tecnologico_list->RowIndex ?>_Bocas_Switch" size="30" placeholder="<?php echo ew_HtmlEncode($piso_tecnologico->Bocas_Switch->getPlaceHolder()) ?>" value="<?php echo $piso_tecnologico->Bocas_Switch->EditValue ?>"<?php echo $piso_tecnologico->Bocas_Switch->EditAttributes() ?>>
</span>
<input type="hidden" data-table="piso_tecnologico" data-field="x_Bocas_Switch" name="o<?php echo $piso_tecnologico_list->RowIndex ?>_Bocas_Switch" id="o<?php echo $piso_tecnologico_list->RowIndex ?>_Bocas_Switch" value="<?php echo ew_HtmlEncode($piso_tecnologico->Bocas_Switch->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($piso_tecnologico->Estado_Switch->Visible) { // Estado_Switch ?>
		<td data-name="Estado_Switch">
<span id="el$rowindex$_piso_tecnologico_Estado_Switch" class="form-group piso_tecnologico_Estado_Switch">
<select data-table="piso_tecnologico" data-field="x_Estado_Switch" data-value-separator="<?php echo $piso_tecnologico->Estado_Switch->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $piso_tecnologico_list->RowIndex ?>_Estado_Switch" name="x<?php echo $piso_tecnologico_list->RowIndex ?>_Estado_Switch"<?php echo $piso_tecnologico->Estado_Switch->EditAttributes() ?>>
<?php echo $piso_tecnologico->Estado_Switch->SelectOptionListHtml("x<?php echo $piso_tecnologico_list->RowIndex ?>_Estado_Switch") ?>
</select>
<input type="hidden" name="s_x<?php echo $piso_tecnologico_list->RowIndex ?>_Estado_Switch" id="s_x<?php echo $piso_tecnologico_list->RowIndex ?>_Estado_Switch" value="<?php echo $piso_tecnologico->Estado_Switch->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="piso_tecnologico" data-field="x_Estado_Switch" name="o<?php echo $piso_tecnologico_list->RowIndex ?>_Estado_Switch" id="o<?php echo $piso_tecnologico_list->RowIndex ?>_Estado_Switch" value="<?php echo ew_HtmlEncode($piso_tecnologico->Estado_Switch->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($piso_tecnologico->Cantidad_Ap->Visible) { // Cantidad_Ap ?>
		<td data-name="Cantidad_Ap">
<span id="el$rowindex$_piso_tecnologico_Cantidad_Ap" class="form-group piso_tecnologico_Cantidad_Ap">
<input type="text" data-table="piso_tecnologico" data-field="x_Cantidad_Ap" name="x<?php echo $piso_tecnologico_list->RowIndex ?>_Cantidad_Ap" id="x<?php echo $piso_tecnologico_list->RowIndex ?>_Cantidad_Ap" size="30" maxlength="2" placeholder="<?php echo ew_HtmlEncode($piso_tecnologico->Cantidad_Ap->getPlaceHolder()) ?>" value="<?php echo $piso_tecnologico->Cantidad_Ap->EditValue ?>"<?php echo $piso_tecnologico->Cantidad_Ap->EditAttributes() ?>>
</span>
<input type="hidden" data-table="piso_tecnologico" data-field="x_Cantidad_Ap" name="o<?php echo $piso_tecnologico_list->RowIndex ?>_Cantidad_Ap" id="o<?php echo $piso_tecnologico_list->RowIndex ?>_Cantidad_Ap" value="<?php echo ew_HtmlEncode($piso_tecnologico->Cantidad_Ap->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($piso_tecnologico->Cantidad_Ap_Func->Visible) { // Cantidad_Ap_Func ?>
		<td data-name="Cantidad_Ap_Func">
<span id="el$rowindex$_piso_tecnologico_Cantidad_Ap_Func" class="form-group piso_tecnologico_Cantidad_Ap_Func">
<input type="text" data-table="piso_tecnologico" data-field="x_Cantidad_Ap_Func" name="x<?php echo $piso_tecnologico_list->RowIndex ?>_Cantidad_Ap_Func" id="x<?php echo $piso_tecnologico_list->RowIndex ?>_Cantidad_Ap_Func" size="30" maxlength="3" placeholder="<?php echo ew_HtmlEncode($piso_tecnologico->Cantidad_Ap_Func->getPlaceHolder()) ?>" value="<?php echo $piso_tecnologico->Cantidad_Ap_Func->EditValue ?>"<?php echo $piso_tecnologico->Cantidad_Ap_Func->EditAttributes() ?>>
</span>
<input type="hidden" data-table="piso_tecnologico" data-field="x_Cantidad_Ap_Func" name="o<?php echo $piso_tecnologico_list->RowIndex ?>_Cantidad_Ap_Func" id="o<?php echo $piso_tecnologico_list->RowIndex ?>_Cantidad_Ap_Func" value="<?php echo ew_HtmlEncode($piso_tecnologico->Cantidad_Ap_Func->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($piso_tecnologico->Ups->Visible) { // Ups ?>
		<td data-name="Ups">
<span id="el$rowindex$_piso_tecnologico_Ups" class="form-group piso_tecnologico_Ups">
<div id="tp_x<?php echo $piso_tecnologico_list->RowIndex ?>_Ups" class="ewTemplate"><input type="radio" data-table="piso_tecnologico" data-field="x_Ups" data-value-separator="<?php echo $piso_tecnologico->Ups->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $piso_tecnologico_list->RowIndex ?>_Ups" id="x<?php echo $piso_tecnologico_list->RowIndex ?>_Ups" value="{value}"<?php echo $piso_tecnologico->Ups->EditAttributes() ?>></div>
<div id="dsl_x<?php echo $piso_tecnologico_list->RowIndex ?>_Ups" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $piso_tecnologico->Ups->RadioButtonListHtml(FALSE, "x{$piso_tecnologico_list->RowIndex}_Ups") ?>
</div></div>
</span>
<input type="hidden" data-table="piso_tecnologico" data-field="x_Ups" name="o<?php echo $piso_tecnologico_list->RowIndex ?>_Ups" id="o<?php echo $piso_tecnologico_list->RowIndex ?>_Ups" value="<?php echo ew_HtmlEncode($piso_tecnologico->Ups->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($piso_tecnologico->Estado_Ups->Visible) { // Estado_Ups ?>
		<td data-name="Estado_Ups">
<span id="el$rowindex$_piso_tecnologico_Estado_Ups" class="form-group piso_tecnologico_Estado_Ups">
<select data-table="piso_tecnologico" data-field="x_Estado_Ups" data-value-separator="<?php echo $piso_tecnologico->Estado_Ups->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $piso_tecnologico_list->RowIndex ?>_Estado_Ups" name="x<?php echo $piso_tecnologico_list->RowIndex ?>_Estado_Ups"<?php echo $piso_tecnologico->Estado_Ups->EditAttributes() ?>>
<?php echo $piso_tecnologico->Estado_Ups->SelectOptionListHtml("x<?php echo $piso_tecnologico_list->RowIndex ?>_Estado_Ups") ?>
</select>
<input type="hidden" name="s_x<?php echo $piso_tecnologico_list->RowIndex ?>_Estado_Ups" id="s_x<?php echo $piso_tecnologico_list->RowIndex ?>_Estado_Ups" value="<?php echo $piso_tecnologico->Estado_Ups->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="piso_tecnologico" data-field="x_Estado_Ups" name="o<?php echo $piso_tecnologico_list->RowIndex ?>_Estado_Ups" id="o<?php echo $piso_tecnologico_list->RowIndex ?>_Estado_Ups" value="<?php echo ew_HtmlEncode($piso_tecnologico->Estado_Ups->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($piso_tecnologico->Cableado->Visible) { // Cableado ?>
		<td data-name="Cableado">
<span id="el$rowindex$_piso_tecnologico_Cableado" class="form-group piso_tecnologico_Cableado">
<div id="tp_x<?php echo $piso_tecnologico_list->RowIndex ?>_Cableado" class="ewTemplate"><input type="radio" data-table="piso_tecnologico" data-field="x_Cableado" data-value-separator="<?php echo $piso_tecnologico->Cableado->DisplayValueSeparatorAttribute() ?>" name="x<?php echo $piso_tecnologico_list->RowIndex ?>_Cableado" id="x<?php echo $piso_tecnologico_list->RowIndex ?>_Cableado" value="{value}"<?php echo $piso_tecnologico->Cableado->EditAttributes() ?>></div>
<div id="dsl_x<?php echo $piso_tecnologico_list->RowIndex ?>_Cableado" data-repeatcolumn="5" class="ewItemList" style="display: none;"><div>
<?php echo $piso_tecnologico->Cableado->RadioButtonListHtml(FALSE, "x{$piso_tecnologico_list->RowIndex}_Cableado") ?>
</div></div>
</span>
<input type="hidden" data-table="piso_tecnologico" data-field="x_Cableado" name="o<?php echo $piso_tecnologico_list->RowIndex ?>_Cableado" id="o<?php echo $piso_tecnologico_list->RowIndex ?>_Cableado" value="<?php echo ew_HtmlEncode($piso_tecnologico->Cableado->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($piso_tecnologico->Estado_Cableado->Visible) { // Estado_Cableado ?>
		<td data-name="Estado_Cableado">
<span id="el$rowindex$_piso_tecnologico_Estado_Cableado" class="form-group piso_tecnologico_Estado_Cableado">
<select data-table="piso_tecnologico" data-field="x_Estado_Cableado" data-value-separator="<?php echo $piso_tecnologico->Estado_Cableado->DisplayValueSeparatorAttribute() ?>" id="x<?php echo $piso_tecnologico_list->RowIndex ?>_Estado_Cableado" name="x<?php echo $piso_tecnologico_list->RowIndex ?>_Estado_Cableado"<?php echo $piso_tecnologico->Estado_Cableado->EditAttributes() ?>>
<?php echo $piso_tecnologico->Estado_Cableado->SelectOptionListHtml("x<?php echo $piso_tecnologico_list->RowIndex ?>_Estado_Cableado") ?>
</select>
<input type="hidden" name="s_x<?php echo $piso_tecnologico_list->RowIndex ?>_Estado_Cableado" id="s_x<?php echo $piso_tecnologico_list->RowIndex ?>_Estado_Cableado" value="<?php echo $piso_tecnologico->Estado_Cableado->LookupFilterQuery() ?>">
</span>
<input type="hidden" data-table="piso_tecnologico" data-field="x_Estado_Cableado" name="o<?php echo $piso_tecnologico_list->RowIndex ?>_Estado_Cableado" id="o<?php echo $piso_tecnologico_list->RowIndex ?>_Estado_Cableado" value="<?php echo ew_HtmlEncode($piso_tecnologico->Estado_Cableado->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($piso_tecnologico->Porcent_Estado_Cab->Visible) { // Porcent_Estado_Cab ?>
		<td data-name="Porcent_Estado_Cab">
<span id="el$rowindex$_piso_tecnologico_Porcent_Estado_Cab" class="form-group piso_tecnologico_Porcent_Estado_Cab">
<input type="text" data-table="piso_tecnologico" data-field="x_Porcent_Estado_Cab" name="x<?php echo $piso_tecnologico_list->RowIndex ?>_Porcent_Estado_Cab" id="x<?php echo $piso_tecnologico_list->RowIndex ?>_Porcent_Estado_Cab" size="30" maxlength="3" placeholder="<?php echo ew_HtmlEncode($piso_tecnologico->Porcent_Estado_Cab->getPlaceHolder()) ?>" value="<?php echo $piso_tecnologico->Porcent_Estado_Cab->EditValue ?>"<?php echo $piso_tecnologico->Porcent_Estado_Cab->EditAttributes() ?>>
</span>
<input type="hidden" data-table="piso_tecnologico" data-field="x_Porcent_Estado_Cab" name="o<?php echo $piso_tecnologico_list->RowIndex ?>_Porcent_Estado_Cab" id="o<?php echo $piso_tecnologico_list->RowIndex ?>_Porcent_Estado_Cab" value="<?php echo ew_HtmlEncode($piso_tecnologico->Porcent_Estado_Cab->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($piso_tecnologico->Porcent_Func_Piso->Visible) { // Porcent_Func_Piso ?>
		<td data-name="Porcent_Func_Piso">
<span id="el$rowindex$_piso_tecnologico_Porcent_Func_Piso" class="form-group piso_tecnologico_Porcent_Func_Piso">
<input type="text" data-table="piso_tecnologico" data-field="x_Porcent_Func_Piso" name="x<?php echo $piso_tecnologico_list->RowIndex ?>_Porcent_Func_Piso" id="x<?php echo $piso_tecnologico_list->RowIndex ?>_Porcent_Func_Piso" size="30" maxlength="3" placeholder="<?php echo ew_HtmlEncode($piso_tecnologico->Porcent_Func_Piso->getPlaceHolder()) ?>" value="<?php echo $piso_tecnologico->Porcent_Func_Piso->EditValue ?>"<?php echo $piso_tecnologico->Porcent_Func_Piso->EditAttributes() ?>>
</span>
<input type="hidden" data-table="piso_tecnologico" data-field="x_Porcent_Func_Piso" name="o<?php echo $piso_tecnologico_list->RowIndex ?>_Porcent_Func_Piso" id="o<?php echo $piso_tecnologico_list->RowIndex ?>_Porcent_Func_Piso" value="<?php echo ew_HtmlEncode($piso_tecnologico->Porcent_Func_Piso->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($piso_tecnologico->Plano_Escuela->Visible) { // Plano_Escuela ?>
		<td data-name="Plano_Escuela">
<span id="el$rowindex$_piso_tecnologico_Plano_Escuela" class="form-group piso_tecnologico_Plano_Escuela">
<div id="fd_x<?php echo $piso_tecnologico_list->RowIndex ?>_Plano_Escuela">
<span title="<?php echo $piso_tecnologico->Plano_Escuela->FldTitle() ? $piso_tecnologico->Plano_Escuela->FldTitle() : $Language->Phrase("ChooseFiles") ?>" class="btn btn-default btn-sm fileinput-button ewTooltip<?php if ($piso_tecnologico->Plano_Escuela->ReadOnly || $piso_tecnologico->Plano_Escuela->Disabled) echo " hide"; ?>">
	<span><?php echo $Language->Phrase("ChooseFileBtn") ?></span>
	<input type="file" title=" " data-table="piso_tecnologico" data-field="x_Plano_Escuela" name="x<?php echo $piso_tecnologico_list->RowIndex ?>_Plano_Escuela" id="x<?php echo $piso_tecnologico_list->RowIndex ?>_Plano_Escuela" multiple="multiple"<?php echo $piso_tecnologico->Plano_Escuela->EditAttributes() ?>>
</span>
<input type="hidden" name="fn_x<?php echo $piso_tecnologico_list->RowIndex ?>_Plano_Escuela" id= "fn_x<?php echo $piso_tecnologico_list->RowIndex ?>_Plano_Escuela" value="<?php echo $piso_tecnologico->Plano_Escuela->Upload->FileName ?>">
<input type="hidden" name="fa_x<?php echo $piso_tecnologico_list->RowIndex ?>_Plano_Escuela" id= "fa_x<?php echo $piso_tecnologico_list->RowIndex ?>_Plano_Escuela" value="0">
<input type="hidden" name="fs_x<?php echo $piso_tecnologico_list->RowIndex ?>_Plano_Escuela" id= "fs_x<?php echo $piso_tecnologico_list->RowIndex ?>_Plano_Escuela" value="65535">
<input type="hidden" name="fx_x<?php echo $piso_tecnologico_list->RowIndex ?>_Plano_Escuela" id= "fx_x<?php echo $piso_tecnologico_list->RowIndex ?>_Plano_Escuela" value="<?php echo $piso_tecnologico->Plano_Escuela->UploadAllowedFileExt ?>">
<input type="hidden" name="fm_x<?php echo $piso_tecnologico_list->RowIndex ?>_Plano_Escuela" id= "fm_x<?php echo $piso_tecnologico_list->RowIndex ?>_Plano_Escuela" value="<?php echo $piso_tecnologico->Plano_Escuela->UploadMaxFileSize ?>">
<input type="hidden" name="fc_x<?php echo $piso_tecnologico_list->RowIndex ?>_Plano_Escuela" id= "fc_x<?php echo $piso_tecnologico_list->RowIndex ?>_Plano_Escuela" value="<?php echo $piso_tecnologico->Plano_Escuela->UploadMaxFileCount ?>">
</div>
<table id="ft_x<?php echo $piso_tecnologico_list->RowIndex ?>_Plano_Escuela" class="table table-condensed pull-left ewUploadTable"><tbody class="files"></tbody></table>
</span>
<input type="hidden" data-table="piso_tecnologico" data-field="x_Plano_Escuela" name="o<?php echo $piso_tecnologico_list->RowIndex ?>_Plano_Escuela" id="o<?php echo $piso_tecnologico_list->RowIndex ?>_Plano_Escuela" value="<?php echo ew_HtmlEncode($piso_tecnologico->Plano_Escuela->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($piso_tecnologico->Fecha_Actualizacion->Visible) { // Fecha_Actualizacion ?>
		<td data-name="Fecha_Actualizacion">
<input type="hidden" data-table="piso_tecnologico" data-field="x_Fecha_Actualizacion" name="o<?php echo $piso_tecnologico_list->RowIndex ?>_Fecha_Actualizacion" id="o<?php echo $piso_tecnologico_list->RowIndex ?>_Fecha_Actualizacion" value="<?php echo ew_HtmlEncode($piso_tecnologico->Fecha_Actualizacion->OldValue) ?>">
</td>
	<?php } ?>
	<?php if ($piso_tecnologico->Usuario->Visible) { // Usuario ?>
		<td data-name="Usuario">
<input type="hidden" data-table="piso_tecnologico" data-field="x_Usuario" name="o<?php echo $piso_tecnologico_list->RowIndex ?>_Usuario" id="o<?php echo $piso_tecnologico_list->RowIndex ?>_Usuario" value="<?php echo ew_HtmlEncode($piso_tecnologico->Usuario->OldValue) ?>">
</td>
	<?php } ?>
<?php

// Render list options (body, right)
$piso_tecnologico_list->ListOptions->Render("body", "right", $piso_tecnologico_list->RowCnt);
?>
<script type="text/javascript">
fpiso_tecnologicolist.UpdateOpts(<?php echo $piso_tecnologico_list->RowIndex ?>);
</script>
	</tr>
<?php
}
?>
</tbody>
</table>
<?php } ?>
<?php if ($piso_tecnologico->CurrentAction == "add" || $piso_tecnologico->CurrentAction == "copy") { ?>
<input type="hidden" name="<?php echo $piso_tecnologico_list->FormKeyCountName ?>" id="<?php echo $piso_tecnologico_list->FormKeyCountName ?>" value="<?php echo $piso_tecnologico_list->KeyCount ?>">
<?php } ?>
<?php if ($piso_tecnologico->CurrentAction == "gridadd") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridinsert">
<input type="hidden" name="<?php echo $piso_tecnologico_list->FormKeyCountName ?>" id="<?php echo $piso_tecnologico_list->FormKeyCountName ?>" value="<?php echo $piso_tecnologico_list->KeyCount ?>">
<?php echo $piso_tecnologico_list->MultiSelectKey ?>
<?php } ?>
<?php if ($piso_tecnologico->CurrentAction == "edit") { ?>
<input type="hidden" name="<?php echo $piso_tecnologico_list->FormKeyCountName ?>" id="<?php echo $piso_tecnologico_list->FormKeyCountName ?>" value="<?php echo $piso_tecnologico_list->KeyCount ?>">
<?php } ?>
<?php if ($piso_tecnologico->CurrentAction == "gridedit") { ?>
<input type="hidden" name="a_list" id="a_list" value="gridupdate">
<input type="hidden" name="<?php echo $piso_tecnologico_list->FormKeyCountName ?>" id="<?php echo $piso_tecnologico_list->FormKeyCountName ?>" value="<?php echo $piso_tecnologico_list->KeyCount ?>">
<?php echo $piso_tecnologico_list->MultiSelectKey ?>
<?php } ?>
<?php if ($piso_tecnologico->CurrentAction == "") { ?>
<input type="hidden" name="a_list" id="a_list" value="">
<?php } ?>
</div>
</form>
<?php

// Close recordset
if ($piso_tecnologico_list->Recordset)
	$piso_tecnologico_list->Recordset->Close();
?>
<?php if ($piso_tecnologico->Export == "") { ?>
<div class="panel-footer ewGridLowerPanel">
<?php if ($piso_tecnologico->CurrentAction <> "gridadd" && $piso_tecnologico->CurrentAction <> "gridedit") { ?>
<form name="ewPagerForm" class="ewForm form-inline ewPagerForm" action="<?php echo ew_CurrentPage() ?>">
<?php if (!isset($piso_tecnologico_list->Pager)) $piso_tecnologico_list->Pager = new cPrevNextPager($piso_tecnologico_list->StartRec, $piso_tecnologico_list->DisplayRecs, $piso_tecnologico_list->TotalRecs) ?>
<?php if ($piso_tecnologico_list->Pager->RecordCount > 0 && $piso_tecnologico_list->Pager->Visible) { ?>
<div class="ewPager">
<span><?php echo $Language->Phrase("Page") ?>&nbsp;</span>
<div class="ewPrevNext"><div class="input-group">
<div class="input-group-btn">
<!--first page button-->
	<?php if ($piso_tecnologico_list->Pager->FirstButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerFirst") ?>" href="<?php echo $piso_tecnologico_list->PageUrl() ?>start=<?php echo $piso_tecnologico_list->Pager->FirstButton->Start ?>"><span class="icon-first ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerFirst") ?>"><span class="icon-first ewIcon"></span></a>
	<?php } ?>
<!--previous page button-->
	<?php if ($piso_tecnologico_list->Pager->PrevButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerPrevious") ?>" href="<?php echo $piso_tecnologico_list->PageUrl() ?>start=<?php echo $piso_tecnologico_list->Pager->PrevButton->Start ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerPrevious") ?>"><span class="icon-prev ewIcon"></span></a>
	<?php } ?>
</div>
<!--current page number-->
	<input class="form-control input-sm" type="text" name="<?php echo EW_TABLE_PAGE_NO ?>" value="<?php echo $piso_tecnologico_list->Pager->CurrentPage ?>">
<div class="input-group-btn">
<!--next page button-->
	<?php if ($piso_tecnologico_list->Pager->NextButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerNext") ?>" href="<?php echo $piso_tecnologico_list->PageUrl() ?>start=<?php echo $piso_tecnologico_list->Pager->NextButton->Start ?>"><span class="icon-next ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerNext") ?>"><span class="icon-next ewIcon"></span></a>
	<?php } ?>
<!--last page button-->
	<?php if ($piso_tecnologico_list->Pager->LastButton->Enabled) { ?>
	<a class="btn btn-default btn-sm" title="<?php echo $Language->Phrase("PagerLast") ?>" href="<?php echo $piso_tecnologico_list->PageUrl() ?>start=<?php echo $piso_tecnologico_list->Pager->LastButton->Start ?>"><span class="icon-last ewIcon"></span></a>
	<?php } else { ?>
	<a class="btn btn-default btn-sm disabled" title="<?php echo $Language->Phrase("PagerLast") ?>"><span class="icon-last ewIcon"></span></a>
	<?php } ?>
</div>
</div>
</div>
<span>&nbsp;<?php echo $Language->Phrase("of") ?>&nbsp;<?php echo $piso_tecnologico_list->Pager->PageCount ?></span>
</div>
<div class="ewPager ewRec">
	<span><?php echo $Language->Phrase("Record") ?>&nbsp;<?php echo $piso_tecnologico_list->Pager->FromIndex ?>&nbsp;<?php echo $Language->Phrase("To") ?>&nbsp;<?php echo $piso_tecnologico_list->Pager->ToIndex ?>&nbsp;<?php echo $Language->Phrase("Of") ?>&nbsp;<?php echo $piso_tecnologico_list->Pager->RecordCount ?></span>
</div>
<?php } ?>
</form>
<?php } ?>
<div class="ewListOtherOptions">
<?php
	foreach ($piso_tecnologico_list->OtherOptions as &$option)
		$option->Render("body", "bottom");
?>
</div>
<div class="clearfix"></div>
</div>
<?php } ?>
</div>
<?php } ?>
<?php if ($piso_tecnologico_list->TotalRecs == 0 && $piso_tecnologico->CurrentAction == "") { // Show other options ?>
<div class="ewListOtherOptions">
<?php
	foreach ($piso_tecnologico_list->OtherOptions as &$option) {
		$option->ButtonClass = "";
		$option->Render("body", "");
	}
?>
</div>
<div class="clearfix"></div>
<?php } ?>
<?php if ($piso_tecnologico->Export == "") { ?>
<script type="text/javascript">
fpiso_tecnologicolistsrch.FilterList = <?php echo $piso_tecnologico_list->GetFilterList() ?>;
fpiso_tecnologicolistsrch.Init();
fpiso_tecnologicolist.Init();
</script>
<?php } ?>
<?php
$piso_tecnologico_list->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<?php if ($piso_tecnologico->Export == "") { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "footer.php" ?>
<?php
$piso_tecnologico_list->Page_Terminate();
?>
