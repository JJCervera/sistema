<?php
if (session_id() == "") session_start(); // Init session data
ob_start(); // Turn on output buffering
?>
<?php include_once "ewcfg13.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "ewmysql13.php") ?>
<?php include_once "phpfn13.php" ?>
<?php include_once "reasignacion_equipoinfo.php" ?>
<?php include_once "usuariosinfo.php" ?>
<?php include_once "userfn13.php" ?>
<?php

//
// Page class
//

$reasignacion_equipo_update = NULL; // Initialize page object first

class creasignacion_equipo_update extends creasignacion_equipo {

	// Page ID
	var $PageID = 'update';

	// Project ID
	var $ProjectID = "{9FD9BA28-0339-4B41-9A45-0CAE935EFE3A}";

	// Table name
	var $TableName = 'reasignacion_equipo';

	// Page object name
	var $PageObjName = 'reasignacion_equipo_update';

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
	var $AuditTrailOnAdd = FALSE;
	var $AuditTrailOnEdit = TRUE;
	var $AuditTrailOnDelete = FALSE;
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

		// Table object (reasignacion_equipo)
		if (!isset($GLOBALS["reasignacion_equipo"]) || get_class($GLOBALS["reasignacion_equipo"]) == "creasignacion_equipo") {
			$GLOBALS["reasignacion_equipo"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["reasignacion_equipo"];
		}

		// Table object (usuarios)
		if (!isset($GLOBALS['usuarios'])) $GLOBALS['usuarios'] = new cusuarios();

		// Page ID
		if (!defined("EW_PAGE_ID"))
			define("EW_PAGE_ID", 'update', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EW_TABLE_NAME"))
			define("EW_TABLE_NAME", 'reasignacion_equipo', TRUE);

		// Start timer
		if (!isset($GLOBALS["gTimer"])) $GLOBALS["gTimer"] = new cTimer();

		// Open connection
		if (!isset($conn)) $conn = ew_Connect($this->DBID);

		// User table object (usuarios)
		if (!isset($UserTable)) {
			$UserTable = new cusuarios();
			$UserTableConn = Conn($UserTable->DBID);
		}
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
		if (!$Security->CanEdit()) {
			$Security->SaveLastUrl();
			$this->setFailureMessage(ew_DeniedMsg()); // Set no permission
			if ($Security->CanList())
				$this->Page_Terminate(ew_GetUrl("reasignacion_equipolist.php"));
			else
				$this->Page_Terminate(ew_GetUrl("login.php"));
		}
		if ($Security->IsLoggedIn()) {
			$Security->UserID_Loading();
			$Security->LoadUserID();
			$Security->UserID_Loaded();
		}

		// Create form object
		$objForm = new cFormObj();
		$this->CurrentAction = (@$_GET["a"] <> "") ? $_GET["a"] : @$_POST["a_list"]; // Set up current action
		$this->Id_Reasignacion->SetVisibility();
		$this->Id_Reasignacion->Visible = !$this->IsAdd() && !$this->IsCopy() && !$this->IsGridAdd();
		$this->Titular_Original->SetVisibility();
		$this->Dni->SetVisibility();
		$this->NroSerie->SetVisibility();
		$this->Nuevo_Titular->SetVisibility();
		$this->Dni_Nuevo_Tit->SetVisibility();
		$this->Id_Motivo_Reasig->SetVisibility();
		$this->Observacion->SetVisibility();
		$this->Fecha_Reasignacion->SetVisibility();
		$this->Usuario->SetVisibility();
		$this->Fecha_Actualizacion->SetVisibility();

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
		global $EW_EXPORT, $reasignacion_equipo;
		if ($this->CustomExport <> "" && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, $EW_EXPORT)) {
				$sContent = ob_get_contents();
			if ($gsExportFile == "") $gsExportFile = $this->TableVar;
			$class = $EW_EXPORT[$this->CustomExport];
			if (class_exists($class)) {
				$doc = new $class($reasignacion_equipo);
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

			// Handle modal response
			if ($this->IsModal) {
				$row = array();
				$row["url"] = $url;
				echo ew_ArrayToJson(array($row));
			} else {
				header("Location: " . $url);
			}
		}
		exit();
	}
	var $FormClassName = "form-horizontal ewForm ewUpdateForm";
	var $IsModal = FALSE;
	var $RecKeys;
	var $Disabled;
	var $Recordset;
	var $UpdateCount = 0;

	//
	// Page main
	//
	function Page_Main() {
		global $objForm, $Language, $gsFormError;
		global $gbSkipHeaderFooter;

		// Check modal
		$this->IsModal = (@$_GET["modal"] == "1" || @$_POST["modal"] == "1");
		if ($this->IsModal)
			$gbSkipHeaderFooter = TRUE;

		// Set up Breadcrumb
		$this->SetupBreadcrumb();

		// Try to load keys from list form
		$this->RecKeys = $this->GetRecordKeys(); // Load record keys
		if (@$_POST["a_update"] <> "") {

			// Get action
			$this->CurrentAction = $_POST["a_update"];
			$this->LoadFormValues(); // Get form values

			// Validate form
			if (!$this->ValidateForm()) {
				$this->CurrentAction = "I"; // Form error, reset action
				$this->setFailureMessage($gsFormError);
			}
		} else {
			$this->LoadMultiUpdateValues(); // Load initial values to form
		}
		if (count($this->RecKeys) <= 0)
			$this->Page_Terminate("reasignacion_equipolist.php"); // No records selected, return to list
		switch ($this->CurrentAction) {
			case "U": // Update
				if ($this->UpdateRows()) { // Update Records based on key
					if ($this->getSuccessMessage() == "")
						$this->setSuccessMessage($Language->Phrase("UpdateSuccess")); // Set up update success message
					$this->Page_Terminate($this->getReturnUrl()); // Return to caller
				} else {
					$this->RestoreFormValues(); // Restore form values
				}
		}

		// Render row
		$this->RowType = EW_ROWTYPE_EDIT; // Render edit
		$this->ResetAttrs();
		$this->RenderRow();
	}

	// Load initial values to form if field values are identical in all selected records
	function LoadMultiUpdateValues() {
		$this->CurrentFilter = $this->GetKeyFilter();

		// Load recordset
		if ($this->Recordset = $this->LoadRecordset()) {
			$i = 1;
			while (!$this->Recordset->EOF) {
				if ($i == 1) {
					$this->Id_Reasignacion->setDbValue($this->Recordset->fields('Id_Reasignacion'));
					$this->Titular_Original->setDbValue($this->Recordset->fields('Titular_Original'));
					$this->Dni->setDbValue($this->Recordset->fields('Dni'));
					$this->NroSerie->setDbValue($this->Recordset->fields('NroSerie'));
					$this->Nuevo_Titular->setDbValue($this->Recordset->fields('Nuevo_Titular'));
					$this->Dni_Nuevo_Tit->setDbValue($this->Recordset->fields('Dni_Nuevo_Tit'));
					$this->Id_Motivo_Reasig->setDbValue($this->Recordset->fields('Id_Motivo_Reasig'));
					$this->Observacion->setDbValue($this->Recordset->fields('Observacion'));
					$this->Fecha_Reasignacion->setDbValue($this->Recordset->fields('Fecha_Reasignacion'));
					$this->Usuario->setDbValue($this->Recordset->fields('Usuario'));
					$this->Fecha_Actualizacion->setDbValue($this->Recordset->fields('Fecha_Actualizacion'));
				} else {
					if (!ew_CompareValue($this->Id_Reasignacion->DbValue, $this->Recordset->fields('Id_Reasignacion')))
						$this->Id_Reasignacion->CurrentValue = NULL;
					if (!ew_CompareValue($this->Titular_Original->DbValue, $this->Recordset->fields('Titular_Original')))
						$this->Titular_Original->CurrentValue = NULL;
					if (!ew_CompareValue($this->Dni->DbValue, $this->Recordset->fields('Dni')))
						$this->Dni->CurrentValue = NULL;
					if (!ew_CompareValue($this->NroSerie->DbValue, $this->Recordset->fields('NroSerie')))
						$this->NroSerie->CurrentValue = NULL;
					if (!ew_CompareValue($this->Nuevo_Titular->DbValue, $this->Recordset->fields('Nuevo_Titular')))
						$this->Nuevo_Titular->CurrentValue = NULL;
					if (!ew_CompareValue($this->Dni_Nuevo_Tit->DbValue, $this->Recordset->fields('Dni_Nuevo_Tit')))
						$this->Dni_Nuevo_Tit->CurrentValue = NULL;
					if (!ew_CompareValue($this->Id_Motivo_Reasig->DbValue, $this->Recordset->fields('Id_Motivo_Reasig')))
						$this->Id_Motivo_Reasig->CurrentValue = NULL;
					if (!ew_CompareValue($this->Observacion->DbValue, $this->Recordset->fields('Observacion')))
						$this->Observacion->CurrentValue = NULL;
					if (!ew_CompareValue($this->Fecha_Reasignacion->DbValue, $this->Recordset->fields('Fecha_Reasignacion')))
						$this->Fecha_Reasignacion->CurrentValue = NULL;
					if (!ew_CompareValue($this->Usuario->DbValue, $this->Recordset->fields('Usuario')))
						$this->Usuario->CurrentValue = NULL;
					if (!ew_CompareValue($this->Fecha_Actualizacion->DbValue, $this->Recordset->fields('Fecha_Actualizacion')))
						$this->Fecha_Actualizacion->CurrentValue = NULL;
				}
				$i++;
				$this->Recordset->MoveNext();
			}
			$this->Recordset->Close();
		}
	}

	// Set up key value
	function SetupKeyValues($key) {
		$sKeyFld = $key;
		if (!is_numeric($sKeyFld))
			return FALSE;
		$this->Id_Reasignacion->CurrentValue = $sKeyFld;
		return TRUE;
	}

	// Update all selected rows
	function UpdateRows() {
		global $Language;
		$conn = &$this->Connection();
		$conn->BeginTrans();
		if ($this->AuditTrailOnEdit) $this->WriteAuditTrailDummy($Language->Phrase("BatchUpdateBegin")); // Batch update begin

		// Get old recordset
		$this->CurrentFilter = $this->GetKeyFilter();
		$sSql = $this->SQL();
		$rsold = $conn->Execute($sSql);

		// Update all rows
		$sKey = "";
		foreach ($this->RecKeys as $key) {
			if ($this->SetupKeyValues($key)) {
				$sThisKey = $key;
				$this->SendEmail = FALSE; // Do not send email on update success
				$this->UpdateCount += 1; // Update record count for records being updated
				$UpdateRows = $this->EditRow(); // Update this row
			} else {
				$UpdateRows = FALSE;
			}
			if (!$UpdateRows)
				break; // Update failed
			if ($sKey <> "") $sKey .= ", ";
			$sKey .= $sThisKey;
		}

		// Check if all rows updated
		if ($UpdateRows) {
			$conn->CommitTrans(); // Commit transaction

			// Get new recordset
			$rsnew = $conn->Execute($sSql);
			if ($this->AuditTrailOnEdit) $this->WriteAuditTrailDummy($Language->Phrase("BatchUpdateSuccess")); // Batch update success
		} else {
			$conn->RollbackTrans(); // Rollback transaction
			if ($this->AuditTrailOnEdit) $this->WriteAuditTrailDummy($Language->Phrase("BatchUpdateRollback")); // Batch update rollback
		}
		return $UpdateRows;
	}

	// Get upload files
	function GetUploadFiles() {
		global $objForm, $Language;

		// Get upload data
	}

	// Load form values
	function LoadFormValues() {

		// Load from form
		global $objForm;
		if (!$this->Id_Reasignacion->FldIsDetailKey)
			$this->Id_Reasignacion->setFormValue($objForm->GetValue("x_Id_Reasignacion"));
		if (!$this->Titular_Original->FldIsDetailKey) {
			$this->Titular_Original->setFormValue($objForm->GetValue("x_Titular_Original"));
		}
		$this->Titular_Original->MultiUpdate = $objForm->GetValue("u_Titular_Original");
		if (!$this->Dni->FldIsDetailKey) {
			$this->Dni->setFormValue($objForm->GetValue("x_Dni"));
		}
		$this->Dni->MultiUpdate = $objForm->GetValue("u_Dni");
		if (!$this->NroSerie->FldIsDetailKey) {
			$this->NroSerie->setFormValue($objForm->GetValue("x_NroSerie"));
		}
		$this->NroSerie->MultiUpdate = $objForm->GetValue("u_NroSerie");
		if (!$this->Nuevo_Titular->FldIsDetailKey) {
			$this->Nuevo_Titular->setFormValue($objForm->GetValue("x_Nuevo_Titular"));
		}
		$this->Nuevo_Titular->MultiUpdate = $objForm->GetValue("u_Nuevo_Titular");
		if (!$this->Dni_Nuevo_Tit->FldIsDetailKey) {
			$this->Dni_Nuevo_Tit->setFormValue($objForm->GetValue("x_Dni_Nuevo_Tit"));
		}
		$this->Dni_Nuevo_Tit->MultiUpdate = $objForm->GetValue("u_Dni_Nuevo_Tit");
		if (!$this->Id_Motivo_Reasig->FldIsDetailKey) {
			$this->Id_Motivo_Reasig->setFormValue($objForm->GetValue("x_Id_Motivo_Reasig"));
		}
		$this->Id_Motivo_Reasig->MultiUpdate = $objForm->GetValue("u_Id_Motivo_Reasig");
		if (!$this->Observacion->FldIsDetailKey) {
			$this->Observacion->setFormValue($objForm->GetValue("x_Observacion"));
		}
		$this->Observacion->MultiUpdate = $objForm->GetValue("u_Observacion");
		if (!$this->Fecha_Reasignacion->FldIsDetailKey) {
			$this->Fecha_Reasignacion->setFormValue($objForm->GetValue("x_Fecha_Reasignacion"));
			$this->Fecha_Reasignacion->CurrentValue = ew_UnFormatDateTime($this->Fecha_Reasignacion->CurrentValue, 7);
		}
		$this->Fecha_Reasignacion->MultiUpdate = $objForm->GetValue("u_Fecha_Reasignacion");
		if (!$this->Usuario->FldIsDetailKey) {
			$this->Usuario->setFormValue($objForm->GetValue("x_Usuario"));
		}
		$this->Usuario->MultiUpdate = $objForm->GetValue("u_Usuario");
		if (!$this->Fecha_Actualizacion->FldIsDetailKey) {
			$this->Fecha_Actualizacion->setFormValue($objForm->GetValue("x_Fecha_Actualizacion"));
			$this->Fecha_Actualizacion->CurrentValue = ew_UnFormatDateTime($this->Fecha_Actualizacion->CurrentValue, 0);
		}
		$this->Fecha_Actualizacion->MultiUpdate = $objForm->GetValue("u_Fecha_Actualizacion");
	}

	// Restore form values
	function RestoreFormValues() {
		global $objForm;
		$this->Id_Reasignacion->CurrentValue = $this->Id_Reasignacion->FormValue;
		$this->Titular_Original->CurrentValue = $this->Titular_Original->FormValue;
		$this->Dni->CurrentValue = $this->Dni->FormValue;
		$this->NroSerie->CurrentValue = $this->NroSerie->FormValue;
		$this->Nuevo_Titular->CurrentValue = $this->Nuevo_Titular->FormValue;
		$this->Dni_Nuevo_Tit->CurrentValue = $this->Dni_Nuevo_Tit->FormValue;
		$this->Id_Motivo_Reasig->CurrentValue = $this->Id_Motivo_Reasig->FormValue;
		$this->Observacion->CurrentValue = $this->Observacion->FormValue;
		$this->Fecha_Reasignacion->CurrentValue = $this->Fecha_Reasignacion->FormValue;
		$this->Fecha_Reasignacion->CurrentValue = ew_UnFormatDateTime($this->Fecha_Reasignacion->CurrentValue, 7);
		$this->Usuario->CurrentValue = $this->Usuario->FormValue;
		$this->Fecha_Actualizacion->CurrentValue = $this->Fecha_Actualizacion->FormValue;
		$this->Fecha_Actualizacion->CurrentValue = ew_UnFormatDateTime($this->Fecha_Actualizacion->CurrentValue, 0);
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
		$this->Id_Reasignacion->setDbValue($rs->fields('Id_Reasignacion'));
		$this->Titular_Original->setDbValue($rs->fields('Titular_Original'));
		$this->Dni->setDbValue($rs->fields('Dni'));
		$this->NroSerie->setDbValue($rs->fields('NroSerie'));
		$this->Nuevo_Titular->setDbValue($rs->fields('Nuevo_Titular'));
		$this->Dni_Nuevo_Tit->setDbValue($rs->fields('Dni_Nuevo_Tit'));
		$this->Id_Motivo_Reasig->setDbValue($rs->fields('Id_Motivo_Reasig'));
		$this->Observacion->setDbValue($rs->fields('Observacion'));
		$this->Fecha_Reasignacion->setDbValue($rs->fields('Fecha_Reasignacion'));
		$this->Usuario->setDbValue($rs->fields('Usuario'));
		$this->Fecha_Actualizacion->setDbValue($rs->fields('Fecha_Actualizacion'));
	}

	// Load DbValue from recordset
	function LoadDbValues(&$rs) {
		if (!$rs || !is_array($rs) && $rs->EOF) return;
		$row = is_array($rs) ? $rs : $rs->fields;
		$this->Id_Reasignacion->DbValue = $row['Id_Reasignacion'];
		$this->Titular_Original->DbValue = $row['Titular_Original'];
		$this->Dni->DbValue = $row['Dni'];
		$this->NroSerie->DbValue = $row['NroSerie'];
		$this->Nuevo_Titular->DbValue = $row['Nuevo_Titular'];
		$this->Dni_Nuevo_Tit->DbValue = $row['Dni_Nuevo_Tit'];
		$this->Id_Motivo_Reasig->DbValue = $row['Id_Motivo_Reasig'];
		$this->Observacion->DbValue = $row['Observacion'];
		$this->Fecha_Reasignacion->DbValue = $row['Fecha_Reasignacion'];
		$this->Usuario->DbValue = $row['Usuario'];
		$this->Fecha_Actualizacion->DbValue = $row['Fecha_Actualizacion'];
	}

	// Render row values based on field settings
	function RenderRow() {
		global $Security, $Language, $gsLanguage;

		// Initialize URLs
		// Call Row_Rendering event

		$this->Row_Rendering();

		// Common render codes for all row types
		// Id_Reasignacion
		// Titular_Original
		// Dni
		// NroSerie
		// Nuevo_Titular
		// Dni_Nuevo_Tit
		// Id_Motivo_Reasig
		// Observacion
		// Fecha_Reasignacion
		// Usuario
		// Fecha_Actualizacion

		if ($this->RowType == EW_ROWTYPE_VIEW) { // View row

		// Id_Reasignacion
		$this->Id_Reasignacion->ViewValue = $this->Id_Reasignacion->CurrentValue;
		$this->Id_Reasignacion->ViewCustomAttributes = "";

		// Titular_Original
		$this->Titular_Original->ViewValue = $this->Titular_Original->CurrentValue;
		if (strval($this->Titular_Original->CurrentValue) <> "") {
			$sFilterWrk = "`Apellidos_Nombres`" . ew_SearchString("=", $this->Titular_Original->CurrentValue, EW_DATATYPE_MEMO, "");
		$sSqlWrk = "SELECT `Apellidos_Nombres`, `Apellidos_Nombres` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `personas`";
		$sWhereWrk = "";
		$this->Titular_Original->LookupFilters = array("dx1" => "`Apellidos_Nombres`");
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Titular_Original, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Titular_Original->ViewValue = $this->Titular_Original->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Titular_Original->ViewValue = $this->Titular_Original->CurrentValue;
			}
		} else {
			$this->Titular_Original->ViewValue = NULL;
		}
		$this->Titular_Original->ViewCustomAttributes = "";

		// Dni
		$this->Dni->ViewValue = $this->Dni->CurrentValue;
		$this->Dni->ViewCustomAttributes = "";

		// NroSerie
		$this->NroSerie->ViewValue = $this->NroSerie->CurrentValue;
		if (strval($this->NroSerie->CurrentValue) <> "") {
			$sFilterWrk = "`NroSerie`" . ew_SearchString("=", $this->NroSerie->CurrentValue, EW_DATATYPE_STRING, "");
		$sSqlWrk = "SELECT `NroSerie`, `NroSerie` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `equipos`";
		$sWhereWrk = "";
		$this->NroSerie->LookupFilters = array("dx1" => "`NroSerie`");
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->NroSerie, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->NroSerie->ViewValue = $this->NroSerie->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->NroSerie->ViewValue = $this->NroSerie->CurrentValue;
			}
		} else {
			$this->NroSerie->ViewValue = NULL;
		}
		$this->NroSerie->ViewCustomAttributes = "";

		// Nuevo_Titular
		$this->Nuevo_Titular->ViewValue = $this->Nuevo_Titular->CurrentValue;
		if (strval($this->Nuevo_Titular->CurrentValue) <> "") {
			$sFilterWrk = "`Apellidos_Nombres`" . ew_SearchString("=", $this->Nuevo_Titular->CurrentValue, EW_DATATYPE_MEMO, "");
		$sSqlWrk = "SELECT `Apellidos_Nombres`, `Apellidos_Nombres` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `personas`";
		$sWhereWrk = "";
		$this->Nuevo_Titular->LookupFilters = array("dx1" => "`Apellidos_Nombres`");
		$lookuptblfilter = "`NroSerie`='0'";
		ew_AddFilter($sWhereWrk, $lookuptblfilter);
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Nuevo_Titular, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Nuevo_Titular->ViewValue = $this->Nuevo_Titular->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Nuevo_Titular->ViewValue = $this->Nuevo_Titular->CurrentValue;
			}
		} else {
			$this->Nuevo_Titular->ViewValue = NULL;
		}
		$this->Nuevo_Titular->ViewCustomAttributes = "";

		// Dni_Nuevo_Tit
		$this->Dni_Nuevo_Tit->ViewValue = $this->Dni_Nuevo_Tit->CurrentValue;
		$this->Dni_Nuevo_Tit->ViewCustomAttributes = "";

		// Id_Motivo_Reasig
		if (strval($this->Id_Motivo_Reasig->CurrentValue) <> "") {
			$sFilterWrk = "`Id_Motivo_Reasig`" . ew_SearchString("=", $this->Id_Motivo_Reasig->CurrentValue, EW_DATATYPE_NUMBER, "");
		$sSqlWrk = "SELECT `Id_Motivo_Reasig`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `motivo_reasignacion`";
		$sWhereWrk = "";
		$this->Id_Motivo_Reasig->LookupFilters = array();
		ew_AddFilter($sWhereWrk, $sFilterWrk);
		$this->Lookup_Selecting($this->Id_Motivo_Reasig, $sWhereWrk); // Call Lookup selecting
		if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			if ($rswrk && !$rswrk->EOF) { // Lookup values found
				$arwrk = array();
				$arwrk[1] = $rswrk->fields('DispFld');
				$this->Id_Motivo_Reasig->ViewValue = $this->Id_Motivo_Reasig->DisplayValue($arwrk);
				$rswrk->Close();
			} else {
				$this->Id_Motivo_Reasig->ViewValue = $this->Id_Motivo_Reasig->CurrentValue;
			}
		} else {
			$this->Id_Motivo_Reasig->ViewValue = NULL;
		}
		$this->Id_Motivo_Reasig->ViewCustomAttributes = "";

		// Observacion
		$this->Observacion->ViewValue = $this->Observacion->CurrentValue;
		$this->Observacion->ViewCustomAttributes = "";

		// Fecha_Reasignacion
		$this->Fecha_Reasignacion->ViewValue = $this->Fecha_Reasignacion->CurrentValue;
		$this->Fecha_Reasignacion->ViewValue = ew_FormatDateTime($this->Fecha_Reasignacion->ViewValue, 7);
		$this->Fecha_Reasignacion->ViewCustomAttributes = "";

		// Usuario
		$this->Usuario->ViewValue = $this->Usuario->CurrentValue;
		$this->Usuario->ViewCustomAttributes = "";

		// Fecha_Actualizacion
		$this->Fecha_Actualizacion->ViewValue = $this->Fecha_Actualizacion->CurrentValue;
		$this->Fecha_Actualizacion->ViewValue = ew_FormatDateTime($this->Fecha_Actualizacion->ViewValue, 0);
		$this->Fecha_Actualizacion->ViewCustomAttributes = "";

			// Id_Reasignacion
			$this->Id_Reasignacion->LinkCustomAttributes = "";
			$this->Id_Reasignacion->HrefValue = "";
			$this->Id_Reasignacion->TooltipValue = "";

			// Titular_Original
			$this->Titular_Original->LinkCustomAttributes = "";
			$this->Titular_Original->HrefValue = "";
			$this->Titular_Original->TooltipValue = "";

			// Dni
			$this->Dni->LinkCustomAttributes = "";
			$this->Dni->HrefValue = "";
			$this->Dni->TooltipValue = "";

			// NroSerie
			$this->NroSerie->LinkCustomAttributes = "";
			$this->NroSerie->HrefValue = "";
			$this->NroSerie->TooltipValue = "";

			// Nuevo_Titular
			$this->Nuevo_Titular->LinkCustomAttributes = "";
			$this->Nuevo_Titular->HrefValue = "";
			$this->Nuevo_Titular->TooltipValue = "";

			// Dni_Nuevo_Tit
			$this->Dni_Nuevo_Tit->LinkCustomAttributes = "";
			$this->Dni_Nuevo_Tit->HrefValue = "";
			$this->Dni_Nuevo_Tit->TooltipValue = "";

			// Id_Motivo_Reasig
			$this->Id_Motivo_Reasig->LinkCustomAttributes = "";
			$this->Id_Motivo_Reasig->HrefValue = "";
			$this->Id_Motivo_Reasig->TooltipValue = "";

			// Observacion
			$this->Observacion->LinkCustomAttributes = "";
			$this->Observacion->HrefValue = "";
			$this->Observacion->TooltipValue = "";

			// Fecha_Reasignacion
			$this->Fecha_Reasignacion->LinkCustomAttributes = "";
			$this->Fecha_Reasignacion->HrefValue = "";
			$this->Fecha_Reasignacion->TooltipValue = "";

			// Usuario
			$this->Usuario->LinkCustomAttributes = "";
			$this->Usuario->HrefValue = "";
			$this->Usuario->TooltipValue = "";

			// Fecha_Actualizacion
			$this->Fecha_Actualizacion->LinkCustomAttributes = "";
			$this->Fecha_Actualizacion->HrefValue = "";
			$this->Fecha_Actualizacion->TooltipValue = "";
		} elseif ($this->RowType == EW_ROWTYPE_EDIT) { // Edit row

			// Id_Reasignacion
			$this->Id_Reasignacion->EditAttrs["class"] = "form-control";
			$this->Id_Reasignacion->EditCustomAttributes = "";
			$this->Id_Reasignacion->EditValue = $this->Id_Reasignacion->CurrentValue;
			$this->Id_Reasignacion->ViewCustomAttributes = "";

			// Titular_Original
			$this->Titular_Original->EditAttrs["class"] = "form-control";
			$this->Titular_Original->EditCustomAttributes = "";
			$this->Titular_Original->EditValue = ew_HtmlEncode($this->Titular_Original->CurrentValue);
			if (strval($this->Titular_Original->CurrentValue) <> "") {
				$sFilterWrk = "`Apellidos_Nombres`" . ew_SearchString("=", $this->Titular_Original->CurrentValue, EW_DATATYPE_MEMO, "");
			$sSqlWrk = "SELECT `Apellidos_Nombres`, `Apellidos_Nombres` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `personas`";
			$sWhereWrk = "";
			$this->Titular_Original->LookupFilters = array("dx1" => "`Apellidos_Nombres`");
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Titular_Original, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = Conn()->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$arwrk = array();
					$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
					$this->Titular_Original->EditValue = $this->Titular_Original->DisplayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->Titular_Original->EditValue = ew_HtmlEncode($this->Titular_Original->CurrentValue);
				}
			} else {
				$this->Titular_Original->EditValue = NULL;
			}
			$this->Titular_Original->PlaceHolder = ew_RemoveHtml($this->Titular_Original->FldCaption());

			// Dni
			$this->Dni->EditAttrs["class"] = "form-control";
			$this->Dni->EditCustomAttributes = "";
			$this->Dni->EditValue = ew_HtmlEncode($this->Dni->CurrentValue);
			$this->Dni->PlaceHolder = ew_RemoveHtml($this->Dni->FldCaption());

			// NroSerie
			$this->NroSerie->EditAttrs["class"] = "form-control";
			$this->NroSerie->EditCustomAttributes = "";
			$this->NroSerie->EditValue = ew_HtmlEncode($this->NroSerie->CurrentValue);
			if (strval($this->NroSerie->CurrentValue) <> "") {
				$sFilterWrk = "`NroSerie`" . ew_SearchString("=", $this->NroSerie->CurrentValue, EW_DATATYPE_STRING, "");
			$sSqlWrk = "SELECT `NroSerie`, `NroSerie` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `equipos`";
			$sWhereWrk = "";
			$this->NroSerie->LookupFilters = array("dx1" => "`NroSerie`");
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->NroSerie, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = Conn()->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$arwrk = array();
					$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
					$this->NroSerie->EditValue = $this->NroSerie->DisplayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->NroSerie->EditValue = ew_HtmlEncode($this->NroSerie->CurrentValue);
				}
			} else {
				$this->NroSerie->EditValue = NULL;
			}
			$this->NroSerie->PlaceHolder = ew_RemoveHtml($this->NroSerie->FldCaption());

			// Nuevo_Titular
			$this->Nuevo_Titular->EditAttrs["class"] = "form-control";
			$this->Nuevo_Titular->EditCustomAttributes = "";
			$this->Nuevo_Titular->EditValue = ew_HtmlEncode($this->Nuevo_Titular->CurrentValue);
			if (strval($this->Nuevo_Titular->CurrentValue) <> "") {
				$sFilterWrk = "`Apellidos_Nombres`" . ew_SearchString("=", $this->Nuevo_Titular->CurrentValue, EW_DATATYPE_MEMO, "");
			$sSqlWrk = "SELECT `Apellidos_Nombres`, `Apellidos_Nombres` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `personas`";
			$sWhereWrk = "";
			$this->Nuevo_Titular->LookupFilters = array("dx1" => "`Apellidos_Nombres`");
			$lookuptblfilter = "`NroSerie`='0'";
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Nuevo_Titular, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
				$rswrk = Conn()->Execute($sSqlWrk);
				if ($rswrk && !$rswrk->EOF) { // Lookup values found
					$arwrk = array();
					$arwrk[1] = ew_HtmlEncode($rswrk->fields('DispFld'));
					$this->Nuevo_Titular->EditValue = $this->Nuevo_Titular->DisplayValue($arwrk);
					$rswrk->Close();
				} else {
					$this->Nuevo_Titular->EditValue = ew_HtmlEncode($this->Nuevo_Titular->CurrentValue);
				}
			} else {
				$this->Nuevo_Titular->EditValue = NULL;
			}
			$this->Nuevo_Titular->PlaceHolder = ew_RemoveHtml($this->Nuevo_Titular->FldCaption());

			// Dni_Nuevo_Tit
			$this->Dni_Nuevo_Tit->EditAttrs["class"] = "form-control";
			$this->Dni_Nuevo_Tit->EditCustomAttributes = "";
			$this->Dni_Nuevo_Tit->EditValue = ew_HtmlEncode($this->Dni_Nuevo_Tit->CurrentValue);
			$this->Dni_Nuevo_Tit->PlaceHolder = ew_RemoveHtml($this->Dni_Nuevo_Tit->FldCaption());

			// Id_Motivo_Reasig
			$this->Id_Motivo_Reasig->EditAttrs["class"] = "form-control";
			$this->Id_Motivo_Reasig->EditCustomAttributes = "";
			if (trim(strval($this->Id_Motivo_Reasig->CurrentValue)) == "") {
				$sFilterWrk = "0=1";
			} else {
				$sFilterWrk = "`Id_Motivo_Reasig`" . ew_SearchString("=", $this->Id_Motivo_Reasig->CurrentValue, EW_DATATYPE_NUMBER, "");
			}
			$sSqlWrk = "SELECT `Id_Motivo_Reasig`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld`, '' AS `SelectFilterFld`, '' AS `SelectFilterFld2`, '' AS `SelectFilterFld3`, '' AS `SelectFilterFld4` FROM `motivo_reasignacion`";
			$sWhereWrk = "";
			$this->Id_Motivo_Reasig->LookupFilters = array();
			ew_AddFilter($sWhereWrk, $sFilterWrk);
			$this->Lookup_Selecting($this->Id_Motivo_Reasig, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$rswrk = Conn()->Execute($sSqlWrk);
			$arwrk = ($rswrk) ? $rswrk->GetRows() : array();
			if ($rswrk) $rswrk->Close();
			$this->Id_Motivo_Reasig->EditValue = $arwrk;

			// Observacion
			$this->Observacion->EditAttrs["class"] = "form-control";
			$this->Observacion->EditCustomAttributes = "";
			$this->Observacion->EditValue = ew_HtmlEncode($this->Observacion->CurrentValue);
			$this->Observacion->PlaceHolder = ew_RemoveHtml($this->Observacion->FldCaption());

			// Fecha_Reasignacion
			$this->Fecha_Reasignacion->EditAttrs["class"] = "form-control";
			$this->Fecha_Reasignacion->EditCustomAttributes = "";
			$this->Fecha_Reasignacion->EditValue = ew_HtmlEncode(ew_FormatDateTime($this->Fecha_Reasignacion->CurrentValue, 7));
			$this->Fecha_Reasignacion->PlaceHolder = ew_RemoveHtml($this->Fecha_Reasignacion->FldCaption());

			// Usuario
			// Fecha_Actualizacion
			// Edit refer script
			// Id_Reasignacion

			$this->Id_Reasignacion->LinkCustomAttributes = "";
			$this->Id_Reasignacion->HrefValue = "";

			// Titular_Original
			$this->Titular_Original->LinkCustomAttributes = "";
			$this->Titular_Original->HrefValue = "";

			// Dni
			$this->Dni->LinkCustomAttributes = "";
			$this->Dni->HrefValue = "";

			// NroSerie
			$this->NroSerie->LinkCustomAttributes = "";
			$this->NroSerie->HrefValue = "";

			// Nuevo_Titular
			$this->Nuevo_Titular->LinkCustomAttributes = "";
			$this->Nuevo_Titular->HrefValue = "";

			// Dni_Nuevo_Tit
			$this->Dni_Nuevo_Tit->LinkCustomAttributes = "";
			$this->Dni_Nuevo_Tit->HrefValue = "";

			// Id_Motivo_Reasig
			$this->Id_Motivo_Reasig->LinkCustomAttributes = "";
			$this->Id_Motivo_Reasig->HrefValue = "";

			// Observacion
			$this->Observacion->LinkCustomAttributes = "";
			$this->Observacion->HrefValue = "";

			// Fecha_Reasignacion
			$this->Fecha_Reasignacion->LinkCustomAttributes = "";
			$this->Fecha_Reasignacion->HrefValue = "";

			// Usuario
			$this->Usuario->LinkCustomAttributes = "";
			$this->Usuario->HrefValue = "";

			// Fecha_Actualizacion
			$this->Fecha_Actualizacion->LinkCustomAttributes = "";
			$this->Fecha_Actualizacion->HrefValue = "";
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

	// Validate form
	function ValidateForm() {
		global $Language, $gsFormError;

		// Initialize form error message
		$gsFormError = "";
		$lUpdateCnt = 0;
		if ($this->Id_Reasignacion->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->Titular_Original->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->Dni->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->NroSerie->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->Nuevo_Titular->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->Dni_Nuevo_Tit->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->Id_Motivo_Reasig->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->Observacion->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->Fecha_Reasignacion->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->Usuario->MultiUpdate == "1") $lUpdateCnt++;
		if ($this->Fecha_Actualizacion->MultiUpdate == "1") $lUpdateCnt++;
		if ($lUpdateCnt == 0) {
			$gsFormError = $Language->Phrase("NoFieldSelected");
			return FALSE;
		}

		// Check if validation required
		if (!EW_SERVER_VALIDATE)
			return ($gsFormError == "");
		if ($this->Titular_Original->MultiUpdate <> "" && !$this->Titular_Original->FldIsDetailKey && !is_null($this->Titular_Original->FormValue) && $this->Titular_Original->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Titular_Original->FldCaption(), $this->Titular_Original->ReqErrMsg));
		}
		if ($this->Dni->MultiUpdate <> "" && !$this->Dni->FldIsDetailKey && !is_null($this->Dni->FormValue) && $this->Dni->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Dni->FldCaption(), $this->Dni->ReqErrMsg));
		}
		if ($this->Dni->MultiUpdate <> "") {
			if (!ew_CheckInteger($this->Dni->FormValue)) {
				ew_AddMessage($gsFormError, $this->Dni->FldErrMsg());
			}
		}
		if ($this->NroSerie->MultiUpdate <> "" && !$this->NroSerie->FldIsDetailKey && !is_null($this->NroSerie->FormValue) && $this->NroSerie->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->NroSerie->FldCaption(), $this->NroSerie->ReqErrMsg));
		}
		if ($this->Nuevo_Titular->MultiUpdate <> "" && !$this->Nuevo_Titular->FldIsDetailKey && !is_null($this->Nuevo_Titular->FormValue) && $this->Nuevo_Titular->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Nuevo_Titular->FldCaption(), $this->Nuevo_Titular->ReqErrMsg));
		}
		if ($this->Dni_Nuevo_Tit->MultiUpdate <> "" && !$this->Dni_Nuevo_Tit->FldIsDetailKey && !is_null($this->Dni_Nuevo_Tit->FormValue) && $this->Dni_Nuevo_Tit->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Dni_Nuevo_Tit->FldCaption(), $this->Dni_Nuevo_Tit->ReqErrMsg));
		}
		if ($this->Dni_Nuevo_Tit->MultiUpdate <> "") {
			if (!ew_CheckInteger($this->Dni_Nuevo_Tit->FormValue)) {
				ew_AddMessage($gsFormError, $this->Dni_Nuevo_Tit->FldErrMsg());
			}
		}
		if ($this->Id_Motivo_Reasig->MultiUpdate <> "" && !$this->Id_Motivo_Reasig->FldIsDetailKey && !is_null($this->Id_Motivo_Reasig->FormValue) && $this->Id_Motivo_Reasig->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Id_Motivo_Reasig->FldCaption(), $this->Id_Motivo_Reasig->ReqErrMsg));
		}
		if ($this->Fecha_Reasignacion->MultiUpdate <> "" && !$this->Fecha_Reasignacion->FldIsDetailKey && !is_null($this->Fecha_Reasignacion->FormValue) && $this->Fecha_Reasignacion->FormValue == "") {
			ew_AddMessage($gsFormError, str_replace("%s", $this->Fecha_Reasignacion->FldCaption(), $this->Fecha_Reasignacion->ReqErrMsg));
		}
		if ($this->Fecha_Reasignacion->MultiUpdate <> "") {
			if (!ew_CheckEuroDate($this->Fecha_Reasignacion->FormValue)) {
				ew_AddMessage($gsFormError, $this->Fecha_Reasignacion->FldErrMsg());
			}
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

			// Titular_Original
			$this->Titular_Original->SetDbValueDef($rsnew, $this->Titular_Original->CurrentValue, NULL, $this->Titular_Original->ReadOnly || $this->Titular_Original->MultiUpdate <> "1");

			// Dni
			$this->Dni->SetDbValueDef($rsnew, $this->Dni->CurrentValue, 0, $this->Dni->ReadOnly || $this->Dni->MultiUpdate <> "1");

			// NroSerie
			$this->NroSerie->SetDbValueDef($rsnew, $this->NroSerie->CurrentValue, "", $this->NroSerie->ReadOnly || $this->NroSerie->MultiUpdate <> "1");

			// Nuevo_Titular
			$this->Nuevo_Titular->SetDbValueDef($rsnew, $this->Nuevo_Titular->CurrentValue, NULL, $this->Nuevo_Titular->ReadOnly || $this->Nuevo_Titular->MultiUpdate <> "1");

			// Dni_Nuevo_Tit
			$this->Dni_Nuevo_Tit->SetDbValueDef($rsnew, $this->Dni_Nuevo_Tit->CurrentValue, NULL, $this->Dni_Nuevo_Tit->ReadOnly || $this->Dni_Nuevo_Tit->MultiUpdate <> "1");

			// Id_Motivo_Reasig
			$this->Id_Motivo_Reasig->SetDbValueDef($rsnew, $this->Id_Motivo_Reasig->CurrentValue, 0, $this->Id_Motivo_Reasig->ReadOnly || $this->Id_Motivo_Reasig->MultiUpdate <> "1");

			// Observacion
			$this->Observacion->SetDbValueDef($rsnew, $this->Observacion->CurrentValue, NULL, $this->Observacion->ReadOnly || $this->Observacion->MultiUpdate <> "1");

			// Fecha_Reasignacion
			$this->Fecha_Reasignacion->SetDbValueDef($rsnew, ew_UnFormatDateTime($this->Fecha_Reasignacion->CurrentValue, 7), NULL, $this->Fecha_Reasignacion->ReadOnly || $this->Fecha_Reasignacion->MultiUpdate <> "1");

			// Usuario
			$this->Usuario->SetDbValueDef($rsnew, CurrentUserName(), NULL);
			$rsnew['Usuario'] = &$this->Usuario->DbValue;

			// Fecha_Actualizacion
			$this->Fecha_Actualizacion->SetDbValueDef($rsnew, ew_CurrentDate(), NULL);
			$rsnew['Fecha_Actualizacion'] = &$this->Fecha_Actualizacion->DbValue;

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

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $Breadcrumb, $Language;
		$Breadcrumb = new cBreadcrumb();
		$url = substr(ew_CurrentUrl(), strrpos(ew_CurrentUrl(), "/")+1);
		$Breadcrumb->Add("list", $this->TableVar, $this->AddMasterUrl("reasignacion_equipolist.php"), "", $this->TableVar, TRUE);
		$PageId = "update";
		$Breadcrumb->Add("update", $PageId, $url);
	}

	// Setup lookup filters of a field
	function SetupLookupFilters($fld, $pageId = null) {
		global $gsLanguage;
		$pageId = $pageId ?: $this->PageID;
		switch ($fld->FldVar) {
		case "x_Titular_Original":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Apellidos_Nombres` AS `LinkFld`, `Apellidos_Nombres` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `personas`";
			$sWhereWrk = "{filter}";
			$this->Titular_Original->LookupFilters = array("dx1" => "`Apellidos_Nombres`");
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Apellidos_Nombres` = {filter_value}", "t0" => "201", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Titular_Original, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_NroSerie":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `NroSerie` AS `LinkFld`, `NroSerie` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `equipos`";
			$sWhereWrk = "{filter}";
			$this->NroSerie->LookupFilters = array("dx1" => "`NroSerie`");
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`NroSerie` = {filter_value}", "t0" => "200", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->NroSerie, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Nuevo_Titular":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Apellidos_Nombres` AS `LinkFld`, `Apellidos_Nombres` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `personas`";
			$sWhereWrk = "{filter}";
			$this->Nuevo_Titular->LookupFilters = array("dx1" => "`Apellidos_Nombres`");
			$lookuptblfilter = "`NroSerie`='0'";
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Apellidos_Nombres` = {filter_value}", "t0" => "201", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Nuevo_Titular, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Id_Motivo_Reasig":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Id_Motivo_Reasig` AS `LinkFld`, `Descripcion` AS `DispFld`, '' AS `Disp2Fld`, '' AS `Disp3Fld`, '' AS `Disp4Fld` FROM `motivo_reasignacion`";
			$sWhereWrk = "";
			$this->Id_Motivo_Reasig->LookupFilters = array();
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "", "f0" => "`Id_Motivo_Reasig` = {filter_value}", "t0" => "3", "fn0" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Id_Motivo_Reasig, $sWhereWrk); // Call Lookup selecting
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
		case "x_Titular_Original":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Apellidos_Nombres`, `Apellidos_Nombres` AS `DispFld` FROM `personas`";
			$sWhereWrk = "`Apellidos_Nombres` LIKE '{query_value}%'";
			$this->Titular_Original->LookupFilters = array("dx1" => "`Apellidos_Nombres`");
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Titular_Original, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " LIMIT " . EW_AUTO_SUGGEST_MAX_ENTRIES;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_NroSerie":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `NroSerie`, `NroSerie` AS `DispFld` FROM `equipos`";
			$sWhereWrk = "`NroSerie` LIKE '{query_value}%'";
			$this->NroSerie->LookupFilters = array("dx1" => "`NroSerie`");
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->NroSerie, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " LIMIT " . EW_AUTO_SUGGEST_MAX_ENTRIES;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		case "x_Nuevo_Titular":
			$sSqlWrk = "";
			$sSqlWrk = "SELECT `Apellidos_Nombres`, `Apellidos_Nombres` AS `DispFld` FROM `personas`";
			$sWhereWrk = "`Apellidos_Nombres` LIKE '{query_value}%'";
			$this->Nuevo_Titular->LookupFilters = array("dx1" => "`Apellidos_Nombres`");
			$lookuptblfilter = "`NroSerie`='0'";
			ew_AddFilter($sWhereWrk, $lookuptblfilter);
			$fld->LookupFilters += array("s" => $sSqlWrk, "d" => "");
			$sSqlWrk = "";
			$this->Lookup_Selecting($this->Nuevo_Titular, $sWhereWrk); // Call Lookup selecting
			if ($sWhereWrk <> "") $sSqlWrk .= " WHERE " . $sWhereWrk;
			$sSqlWrk .= " LIMIT " . EW_AUTO_SUGGEST_MAX_ENTRIES;
			if ($sSqlWrk <> "")
				$fld->LookupFilters["s"] .= $sSqlWrk;
			break;
		}
	}

	// Write Audit Trail start/end for grid update
	function WriteAuditTrailDummy($typ) {
		$table = 'reasignacion_equipo';
		$usr = CurrentUserID();
		ew_WriteAuditTrail("log", ew_StdCurrentDateTime(), ew_ScriptName(), $usr, $typ, $table, "", "", "", "");
	}

	// Write Audit Trail (edit page)
	function WriteAuditTrailOnEdit(&$rsold, &$rsnew) {
		global $Language;
		if (!$this->AuditTrailOnEdit) return;
		$table = 'reasignacion_equipo';

		// Get key value
		$key = "";
		if ($key <> "") $key .= $GLOBALS["EW_COMPOSITE_KEY_SEPARATOR"];
		$key .= $rsold['Id_Reasignacion'];

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
}
?>
<?php ew_Header(TRUE) ?>
<?php

// Create page object
if (!isset($reasignacion_equipo_update)) $reasignacion_equipo_update = new creasignacion_equipo_update();

// Page init
$reasignacion_equipo_update->Page_Init();

// Page main
$reasignacion_equipo_update->Page_Main();

// Global Page Rendering event (in userfn*.php)
Page_Rendering();

// Page Rendering event
$reasignacion_equipo_update->Page_Render();
?>
<?php include_once "header.php" ?>
<script type="text/javascript">

// Form object
var CurrentPageID = EW_PAGE_ID = "update";
var CurrentForm = freasignacion_equipoupdate = new ew_Form("freasignacion_equipoupdate", "update");

// Validate form
freasignacion_equipoupdate.Validate = function() {
	if (!this.ValidateRequired)
		return true; // Ignore validation
	var $ = jQuery, fobj = this.GetForm(), $fobj = $(fobj);
	if ($fobj.find("#a_confirm").val() == "F")
		return true;
	if (!ew_UpdateSelected(fobj)) {
		ew_Alert(ewLanguage.Phrase("NoFieldSelected"));
		return false;
	}
	var elm, felm, uelm, addcnt = 0;
	var $k = $fobj.find("#" + this.FormKeyCountName); // Get key_count
	var rowcnt = ($k[0]) ? parseInt($k.val(), 10) : 1;
	var startcnt = (rowcnt == 0) ? 0 : 1; // Check rowcnt == 0 => Inline-Add
	var gridinsert = $fobj.find("#a_list").val() == "gridinsert";
	for (var i = startcnt; i <= rowcnt; i++) {
		var infix = ($k[0]) ? String(i) : "";
		$fobj.data("rowindex", infix);
			elm = this.GetElements("x" + infix + "_Titular_Original");
			uelm = this.GetElements("u" + infix + "_Titular_Original");
			if (uelm && uelm.checked) {
				if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
					return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $reasignacion_equipo->Titular_Original->FldCaption(), $reasignacion_equipo->Titular_Original->ReqErrMsg)) ?>");
			}
			elm = this.GetElements("x" + infix + "_Dni");
			uelm = this.GetElements("u" + infix + "_Dni");
			if (uelm && uelm.checked) {
				if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
					return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $reasignacion_equipo->Dni->FldCaption(), $reasignacion_equipo->Dni->ReqErrMsg)) ?>");
			}
			elm = this.GetElements("x" + infix + "_Dni");
			uelm = this.GetElements("u" + infix + "_Dni");
			if (uelm && uelm.checked && elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($reasignacion_equipo->Dni->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_NroSerie");
			uelm = this.GetElements("u" + infix + "_NroSerie");
			if (uelm && uelm.checked) {
				if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
					return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $reasignacion_equipo->NroSerie->FldCaption(), $reasignacion_equipo->NroSerie->ReqErrMsg)) ?>");
			}
			elm = this.GetElements("x" + infix + "_Nuevo_Titular");
			uelm = this.GetElements("u" + infix + "_Nuevo_Titular");
			if (uelm && uelm.checked) {
				if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
					return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $reasignacion_equipo->Nuevo_Titular->FldCaption(), $reasignacion_equipo->Nuevo_Titular->ReqErrMsg)) ?>");
			}
			elm = this.GetElements("x" + infix + "_Dni_Nuevo_Tit");
			uelm = this.GetElements("u" + infix + "_Dni_Nuevo_Tit");
			if (uelm && uelm.checked) {
				if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
					return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $reasignacion_equipo->Dni_Nuevo_Tit->FldCaption(), $reasignacion_equipo->Dni_Nuevo_Tit->ReqErrMsg)) ?>");
			}
			elm = this.GetElements("x" + infix + "_Dni_Nuevo_Tit");
			uelm = this.GetElements("u" + infix + "_Dni_Nuevo_Tit");
			if (uelm && uelm.checked && elm && !ew_CheckInteger(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($reasignacion_equipo->Dni_Nuevo_Tit->FldErrMsg()) ?>");
			elm = this.GetElements("x" + infix + "_Id_Motivo_Reasig");
			uelm = this.GetElements("u" + infix + "_Id_Motivo_Reasig");
			if (uelm && uelm.checked) {
				if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
					return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $reasignacion_equipo->Id_Motivo_Reasig->FldCaption(), $reasignacion_equipo->Id_Motivo_Reasig->ReqErrMsg)) ?>");
			}
			elm = this.GetElements("x" + infix + "_Fecha_Reasignacion");
			uelm = this.GetElements("u" + infix + "_Fecha_Reasignacion");
			if (uelm && uelm.checked) {
				if (elm && !ew_IsHidden(elm) && !ew_HasValue(elm))
					return this.OnError(elm, "<?php echo ew_JsEncode2(str_replace("%s", $reasignacion_equipo->Fecha_Reasignacion->FldCaption(), $reasignacion_equipo->Fecha_Reasignacion->ReqErrMsg)) ?>");
			}
			elm = this.GetElements("x" + infix + "_Fecha_Reasignacion");
			uelm = this.GetElements("u" + infix + "_Fecha_Reasignacion");
			if (uelm && uelm.checked && elm && !ew_CheckEuroDate(elm.value))
				return this.OnError(elm, "<?php echo ew_JsEncode2($reasignacion_equipo->Fecha_Reasignacion->FldErrMsg()) ?>");

			// Fire Form_CustomValidate event
			if (!this.Form_CustomValidate(fobj))
				return false;
	}
	return true;
}

// Form_CustomValidate event
freasignacion_equipoupdate.Form_CustomValidate = 
 function(fobj) { // DO NOT CHANGE THIS LINE!

 	// Your custom validation code here, return false if invalid. 
 	return true;
 }

// Use JavaScript validation or not
<?php if (EW_CLIENT_VALIDATE) { ?>
freasignacion_equipoupdate.ValidateRequired = true;
<?php } else { ?>
freasignacion_equipoupdate.ValidateRequired = false; 
<?php } ?>

// Dynamic selection lists
freasignacion_equipoupdate.Lists["x_Titular_Original"] = {"LinkField":"x_Apellidos_Nombres","Ajax":true,"AutoFill":true,"DisplayFields":["x_Apellidos_Nombres","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"personas"};
freasignacion_equipoupdate.Lists["x_NroSerie"] = {"LinkField":"x_NroSerie","Ajax":true,"AutoFill":false,"DisplayFields":["x_NroSerie","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"equipos"};
freasignacion_equipoupdate.Lists["x_Nuevo_Titular"] = {"LinkField":"x_Apellidos_Nombres","Ajax":true,"AutoFill":true,"DisplayFields":["x_Apellidos_Nombres","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"personas"};
freasignacion_equipoupdate.Lists["x_Id_Motivo_Reasig"] = {"LinkField":"x_Id_Motivo_Reasig","Ajax":true,"AutoFill":false,"DisplayFields":["x_Descripcion","","",""],"ParentFields":[],"ChildFields":[],"FilterFields":[],"Options":[],"Template":"","LinkTable":"motivo_reasignacion"};

// Form object for search
</script>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php if (!$reasignacion_equipo_update->IsModal) { ?>
<div class="ewToolbar">
<?php $Breadcrumb->Render(); ?>
<?php echo $Language->SelectionForm(); ?>
<div class="clearfix"></div>
</div>
<?php } ?>
<?php $reasignacion_equipo_update->ShowPageHeader(); ?>
<?php
$reasignacion_equipo_update->ShowMessage();
?>
<form name="freasignacion_equipoupdate" id="freasignacion_equipoupdate" class="<?php echo $reasignacion_equipo_update->FormClassName ?>" action="<?php echo ew_CurrentPage() ?>" method="post">
<?php if ($reasignacion_equipo_update->CheckToken) { ?>
<input type="hidden" name="<?php echo EW_TOKEN_NAME ?>" value="<?php echo $reasignacion_equipo_update->Token ?>">
<?php } ?>
<input type="hidden" name="t" value="reasignacion_equipo">
<input type="hidden" name="a_update" id="a_update" value="U">
<?php if ($reasignacion_equipo_update->IsModal) { ?>
<input type="hidden" name="modal" value="1">
<?php } ?>
<?php foreach ($reasignacion_equipo_update->RecKeys as $key) { ?>
<?php $keyvalue = is_array($key) ? implode($EW_COMPOSITE_KEY_SEPARATOR, $key) : $key; ?>
<input type="hidden" name="key_m[]" value="<?php echo ew_HtmlEncode($keyvalue) ?>">
<?php } ?>
<div id="tbl_reasignacion_equipoupdate">
	<div class="checkbox">
		<label><input type="checkbox" name="u" id="u" onclick="ew_SelectAll(this);"> <?php echo $Language->Phrase("UpdateSelectAll") ?></label>
	</div>
<?php if ($reasignacion_equipo->Titular_Original->Visible) { // Titular_Original ?>
	<div id="r_Titular_Original" class="form-group">
		<label class="col-sm-2 control-label">
<input type="checkbox" name="u_Titular_Original" id="u_Titular_Original" value="1"<?php echo ($reasignacion_equipo->Titular_Original->MultiUpdate == "1") ? " checked" : "" ?>>
 <?php echo $reasignacion_equipo->Titular_Original->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $reasignacion_equipo->Titular_Original->CellAttributes() ?>>
<span id="el_reasignacion_equipo_Titular_Original">
<?php $reasignacion_equipo->Titular_Original->EditAttrs["onchange"] = "ew_AutoFill(this); " . @$reasignacion_equipo->Titular_Original->EditAttrs["onchange"]; ?>
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x_Titular_Original"><?php echo (strval($reasignacion_equipo->Titular_Original->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $reasignacion_equipo->Titular_Original->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($reasignacion_equipo->Titular_Original->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x_Titular_Original',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="reasignacion_equipo" data-field="x_Titular_Original" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $reasignacion_equipo->Titular_Original->DisplayValueSeparatorAttribute() ?>" name="x_Titular_Original" id="x_Titular_Original" value="<?php echo $reasignacion_equipo->Titular_Original->CurrentValue ?>"<?php echo $reasignacion_equipo->Titular_Original->EditAttributes() ?>>
<input type="hidden" name="s_x_Titular_Original" id="s_x_Titular_Original" value="<?php echo $reasignacion_equipo->Titular_Original->LookupFilterQuery() ?>">
<input type="hidden" name="ln_x_Titular_Original" id="ln_x_Titular_Original" value="x_Dni,x_NroSerie">
</span>
<?php echo $reasignacion_equipo->Titular_Original->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($reasignacion_equipo->Dni->Visible) { // Dni ?>
	<div id="r_Dni" class="form-group">
		<label for="x_Dni" class="col-sm-2 control-label">
<input type="checkbox" name="u_Dni" id="u_Dni" value="1"<?php echo ($reasignacion_equipo->Dni->MultiUpdate == "1") ? " checked" : "" ?>>
 <?php echo $reasignacion_equipo->Dni->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $reasignacion_equipo->Dni->CellAttributes() ?>>
<span id="el_reasignacion_equipo_Dni">
<input type="text" data-table="reasignacion_equipo" data-field="x_Dni" name="x_Dni" id="x_Dni" size="30" placeholder="<?php echo ew_HtmlEncode($reasignacion_equipo->Dni->getPlaceHolder()) ?>" value="<?php echo $reasignacion_equipo->Dni->EditValue ?>"<?php echo $reasignacion_equipo->Dni->EditAttributes() ?>>
</span>
<?php echo $reasignacion_equipo->Dni->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($reasignacion_equipo->NroSerie->Visible) { // NroSerie ?>
	<div id="r_NroSerie" class="form-group">
		<label class="col-sm-2 control-label">
<input type="checkbox" name="u_NroSerie" id="u_NroSerie" value="1"<?php echo ($reasignacion_equipo->NroSerie->MultiUpdate == "1") ? " checked" : "" ?>>
 <?php echo $reasignacion_equipo->NroSerie->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $reasignacion_equipo->NroSerie->CellAttributes() ?>>
<span id="el_reasignacion_equipo_NroSerie">
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x_NroSerie"><?php echo (strval($reasignacion_equipo->NroSerie->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $reasignacion_equipo->NroSerie->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($reasignacion_equipo->NroSerie->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x_NroSerie',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="reasignacion_equipo" data-field="x_NroSerie" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $reasignacion_equipo->NroSerie->DisplayValueSeparatorAttribute() ?>" name="x_NroSerie" id="x_NroSerie" value="<?php echo $reasignacion_equipo->NroSerie->CurrentValue ?>"<?php echo $reasignacion_equipo->NroSerie->EditAttributes() ?>>
<input type="hidden" name="s_x_NroSerie" id="s_x_NroSerie" value="<?php echo $reasignacion_equipo->NroSerie->LookupFilterQuery() ?>">
</span>
<?php echo $reasignacion_equipo->NroSerie->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($reasignacion_equipo->Nuevo_Titular->Visible) { // Nuevo_Titular ?>
	<div id="r_Nuevo_Titular" class="form-group">
		<label class="col-sm-2 control-label">
<input type="checkbox" name="u_Nuevo_Titular" id="u_Nuevo_Titular" value="1"<?php echo ($reasignacion_equipo->Nuevo_Titular->MultiUpdate == "1") ? " checked" : "" ?>>
 <?php echo $reasignacion_equipo->Nuevo_Titular->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $reasignacion_equipo->Nuevo_Titular->CellAttributes() ?>>
<span id="el_reasignacion_equipo_Nuevo_Titular">
<?php $reasignacion_equipo->Nuevo_Titular->EditAttrs["onchange"] = "ew_AutoFill(this); " . @$reasignacion_equipo->Nuevo_Titular->EditAttrs["onchange"]; ?>
<span class="ewLookupList">
	<span onclick="jQuery(this).parent().next().click();" tabindex="-1" class="form-control ewLookupText" id="lu_x_Nuevo_Titular"><?php echo (strval($reasignacion_equipo->Nuevo_Titular->ViewValue) == "" ? $Language->Phrase("PleaseSelect") : $reasignacion_equipo->Nuevo_Titular->ViewValue); ?></span>
</span>
<button type="button" title="<?php echo ew_HtmlEncode(str_replace("%s", ew_RemoveHtml($reasignacion_equipo->Nuevo_Titular->FldCaption()), $Language->Phrase("LookupLink", TRUE))) ?>" onclick="ew_ModalLookupShow({lnk:this,el:'x_Nuevo_Titular',m:0,n:10});" class="ewLookupBtn btn btn-default btn-sm"><span class="glyphicon glyphicon-search ewIcon"></span></button>
<input type="hidden" data-table="reasignacion_equipo" data-field="x_Nuevo_Titular" data-multiple="0" data-lookup="1" data-value-separator="<?php echo $reasignacion_equipo->Nuevo_Titular->DisplayValueSeparatorAttribute() ?>" name="x_Nuevo_Titular" id="x_Nuevo_Titular" value="<?php echo $reasignacion_equipo->Nuevo_Titular->CurrentValue ?>"<?php echo $reasignacion_equipo->Nuevo_Titular->EditAttributes() ?>>
<input type="hidden" name="s_x_Nuevo_Titular" id="s_x_Nuevo_Titular" value="<?php echo $reasignacion_equipo->Nuevo_Titular->LookupFilterQuery() ?>">
<input type="hidden" name="ln_x_Nuevo_Titular" id="ln_x_Nuevo_Titular" value="x_Dni_Nuevo_Tit">
</span>
<?php echo $reasignacion_equipo->Nuevo_Titular->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($reasignacion_equipo->Dni_Nuevo_Tit->Visible) { // Dni_Nuevo_Tit ?>
	<div id="r_Dni_Nuevo_Tit" class="form-group">
		<label for="x_Dni_Nuevo_Tit" class="col-sm-2 control-label">
<input type="checkbox" name="u_Dni_Nuevo_Tit" id="u_Dni_Nuevo_Tit" value="1"<?php echo ($reasignacion_equipo->Dni_Nuevo_Tit->MultiUpdate == "1") ? " checked" : "" ?>>
 <?php echo $reasignacion_equipo->Dni_Nuevo_Tit->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $reasignacion_equipo->Dni_Nuevo_Tit->CellAttributes() ?>>
<span id="el_reasignacion_equipo_Dni_Nuevo_Tit">
<input type="text" data-table="reasignacion_equipo" data-field="x_Dni_Nuevo_Tit" name="x_Dni_Nuevo_Tit" id="x_Dni_Nuevo_Tit" size="30" placeholder="<?php echo ew_HtmlEncode($reasignacion_equipo->Dni_Nuevo_Tit->getPlaceHolder()) ?>" value="<?php echo $reasignacion_equipo->Dni_Nuevo_Tit->EditValue ?>"<?php echo $reasignacion_equipo->Dni_Nuevo_Tit->EditAttributes() ?>>
</span>
<?php echo $reasignacion_equipo->Dni_Nuevo_Tit->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($reasignacion_equipo->Id_Motivo_Reasig->Visible) { // Id_Motivo_Reasig ?>
	<div id="r_Id_Motivo_Reasig" class="form-group">
		<label for="x_Id_Motivo_Reasig" class="col-sm-2 control-label">
<input type="checkbox" name="u_Id_Motivo_Reasig" id="u_Id_Motivo_Reasig" value="1"<?php echo ($reasignacion_equipo->Id_Motivo_Reasig->MultiUpdate == "1") ? " checked" : "" ?>>
 <?php echo $reasignacion_equipo->Id_Motivo_Reasig->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $reasignacion_equipo->Id_Motivo_Reasig->CellAttributes() ?>>
<span id="el_reasignacion_equipo_Id_Motivo_Reasig">
<select data-table="reasignacion_equipo" data-field="x_Id_Motivo_Reasig" data-value-separator="<?php echo $reasignacion_equipo->Id_Motivo_Reasig->DisplayValueSeparatorAttribute() ?>" id="x_Id_Motivo_Reasig" name="x_Id_Motivo_Reasig"<?php echo $reasignacion_equipo->Id_Motivo_Reasig->EditAttributes() ?>>
<?php echo $reasignacion_equipo->Id_Motivo_Reasig->SelectOptionListHtml("x_Id_Motivo_Reasig") ?>
</select>
<input type="hidden" name="s_x_Id_Motivo_Reasig" id="s_x_Id_Motivo_Reasig" value="<?php echo $reasignacion_equipo->Id_Motivo_Reasig->LookupFilterQuery() ?>">
</span>
<?php echo $reasignacion_equipo->Id_Motivo_Reasig->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($reasignacion_equipo->Observacion->Visible) { // Observacion ?>
	<div id="r_Observacion" class="form-group">
		<label for="x_Observacion" class="col-sm-2 control-label">
<input type="checkbox" name="u_Observacion" id="u_Observacion" value="1"<?php echo ($reasignacion_equipo->Observacion->MultiUpdate == "1") ? " checked" : "" ?>>
 <?php echo $reasignacion_equipo->Observacion->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $reasignacion_equipo->Observacion->CellAttributes() ?>>
<span id="el_reasignacion_equipo_Observacion">
<textarea data-table="reasignacion_equipo" data-field="x_Observacion" name="x_Observacion" id="x_Observacion" cols="35" rows="4" placeholder="<?php echo ew_HtmlEncode($reasignacion_equipo->Observacion->getPlaceHolder()) ?>"<?php echo $reasignacion_equipo->Observacion->EditAttributes() ?>><?php echo $reasignacion_equipo->Observacion->EditValue ?></textarea>
</span>
<?php echo $reasignacion_equipo->Observacion->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($reasignacion_equipo->Fecha_Reasignacion->Visible) { // Fecha_Reasignacion ?>
	<div id="r_Fecha_Reasignacion" class="form-group">
		<label for="x_Fecha_Reasignacion" class="col-sm-2 control-label">
<input type="checkbox" name="u_Fecha_Reasignacion" id="u_Fecha_Reasignacion" value="1"<?php echo ($reasignacion_equipo->Fecha_Reasignacion->MultiUpdate == "1") ? " checked" : "" ?>>
 <?php echo $reasignacion_equipo->Fecha_Reasignacion->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $reasignacion_equipo->Fecha_Reasignacion->CellAttributes() ?>>
<span id="el_reasignacion_equipo_Fecha_Reasignacion">
<input type="text" data-table="reasignacion_equipo" data-field="x_Fecha_Reasignacion" data-format="7" name="x_Fecha_Reasignacion" id="x_Fecha_Reasignacion" size="30" maxlength="10" placeholder="<?php echo ew_HtmlEncode($reasignacion_equipo->Fecha_Reasignacion->getPlaceHolder()) ?>" value="<?php echo $reasignacion_equipo->Fecha_Reasignacion->EditValue ?>"<?php echo $reasignacion_equipo->Fecha_Reasignacion->EditAttributes() ?>>
<?php if (!$reasignacion_equipo->Fecha_Reasignacion->ReadOnly && !$reasignacion_equipo->Fecha_Reasignacion->Disabled && !isset($reasignacion_equipo->Fecha_Reasignacion->EditAttrs["readonly"]) && !isset($reasignacion_equipo->Fecha_Reasignacion->EditAttrs["disabled"])) { ?>
<script type="text/javascript">
ew_CreateCalendar("freasignacion_equipoupdate", "x_Fecha_Reasignacion", 7);
</script>
<?php } ?>
</span>
<?php echo $reasignacion_equipo->Fecha_Reasignacion->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($reasignacion_equipo->Usuario->Visible) { // Usuario ?>
	<div id="r_Usuario" class="form-group">
		<label for="x_Usuario" class="col-sm-2 control-label">
<input type="checkbox" name="u_Usuario" id="u_Usuario" value="1"<?php echo ($reasignacion_equipo->Usuario->MultiUpdate == "1") ? " checked" : "" ?>>
 <?php echo $reasignacion_equipo->Usuario->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $reasignacion_equipo->Usuario->CellAttributes() ?>>
<?php echo $reasignacion_equipo->Usuario->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if ($reasignacion_equipo->Fecha_Actualizacion->Visible) { // Fecha_Actualizacion ?>
	<div id="r_Fecha_Actualizacion" class="form-group">
		<label for="x_Fecha_Actualizacion" class="col-sm-2 control-label">
<input type="checkbox" name="u_Fecha_Actualizacion" id="u_Fecha_Actualizacion" value="1"<?php echo ($reasignacion_equipo->Fecha_Actualizacion->MultiUpdate == "1") ? " checked" : "" ?>>
 <?php echo $reasignacion_equipo->Fecha_Actualizacion->FldCaption() ?></label>
		<div class="col-sm-10"><div<?php echo $reasignacion_equipo->Fecha_Actualizacion->CellAttributes() ?>>
<?php echo $reasignacion_equipo->Fecha_Actualizacion->CustomMsg ?></div></div>
	</div>
<?php } ?>
<?php if (!$reasignacion_equipo_update->IsModal) { ?>
	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
<button class="btn btn-primary ewButton" name="btnAction" id="btnAction" type="submit"><?php echo $Language->Phrase("UpdateBtn") ?></button>
<button class="btn btn-default ewButton" name="btnCancel" id="btnCancel" type="button" data-href="<?php echo $reasignacion_equipo_update->getReturnUrl() ?>"><?php echo $Language->Phrase("CancelBtn") ?></button>
		</div>
	</div>
<?php } ?>
</div>
</form>
<script type="text/javascript">
freasignacion_equipoupdate.Init();
</script>
<?php
$reasignacion_equipo_update->ShowPageFooter();
if (EW_DEBUG_ENABLED)
	echo ew_DebugMsg();
?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php include_once "footer.php" ?>
<?php
$reasignacion_equipo_update->Page_Terminate();
?>
