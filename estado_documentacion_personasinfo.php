<?php

// Global variable for table object
$estado_documentacion_personas = NULL;

//
// Table class for estado_documentacion_personas
//
class cestado_documentacion_personas extends cTable {
	var $Apellidos_Nombres;
	var $Dni;
	var $Id_Curso;
	var $Id_Division;
	var $Id_Turno;
	var $Id_Estado;
	var $Id_Cargo;
	var $Matricula;
	var $Certificado_Pase;
	var $Tiene_DNI;
	var $Certificado_Medico;
	var $Posee_Autorizacion;
	var $Cooperadora;

	//
	// Table class constructor
	//
	function __construct() {
		global $Language;

		// Language object
		if (!isset($Language)) $Language = new cLanguage();
		$this->TableVar = 'estado_documentacion_personas';
		$this->TableName = 'estado_documentacion_personas';
		$this->TableType = 'VIEW';

		// Update Table
		$this->UpdateTable = "`estado_documentacion_personas`";
		$this->DBID = 'DB';
		$this->ExportAll = TRUE;
		$this->ExportPageBreakCount = 0; // Page break per every n record (PDF only)
		$this->ExportPageOrientation = "portrait"; // Page orientation (PDF only)
		$this->ExportPageSize = "a4"; // Page size (PDF only)
		$this->ExportExcelPageOrientation = ""; // Page orientation (PHPExcel only)
		$this->ExportExcelPageSize = ""; // Page size (PHPExcel only)
		$this->DetailAdd = FALSE; // Allow detail add
		$this->DetailEdit = FALSE; // Allow detail edit
		$this->DetailView = FALSE; // Allow detail view
		$this->ShowMultipleDetails = FALSE; // Show multiple details
		$this->GridAddRowCount = 1;
		$this->AllowAddDeleteRow = ew_AllowAddDeleteRow(); // Allow add/delete row
		$this->UserIDAllowSecurity = 0; // User ID Allow
		$this->BasicSearch = new cBasicSearch($this->TableVar);

		// Apellidos_Nombres
		$this->Apellidos_Nombres = new cField('estado_documentacion_personas', 'estado_documentacion_personas', 'x_Apellidos_Nombres', 'Apellidos_Nombres', '`Apellidos_Nombres`', '`Apellidos_Nombres`', 201, -1, FALSE, '`Apellidos_Nombres`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Apellidos_Nombres->Sortable = TRUE; // Allow sort
		$this->fields['Apellidos_Nombres'] = &$this->Apellidos_Nombres;

		// Dni
		$this->Dni = new cField('estado_documentacion_personas', 'estado_documentacion_personas', 'x_Dni', 'Dni', '`Dni`', '`Dni`', 3, -1, FALSE, '`Dni`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Dni->Sortable = TRUE; // Allow sort
		$this->Dni->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Dni'] = &$this->Dni;

		// Id_Curso
		$this->Id_Curso = new cField('estado_documentacion_personas', 'estado_documentacion_personas', 'x_Id_Curso', 'Id_Curso', '`Id_Curso`', '`Id_Curso`', 3, -1, FALSE, '`Id_Curso`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->Id_Curso->Sortable = TRUE; // Allow sort
		$this->Id_Curso->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->Id_Curso->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->fields['Id_Curso'] = &$this->Id_Curso;

		// Id_Division
		$this->Id_Division = new cField('estado_documentacion_personas', 'estado_documentacion_personas', 'x_Id_Division', 'Id_Division', '`Id_Division`', '`Id_Division`', 3, -1, FALSE, '`Id_Division`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->Id_Division->Sortable = TRUE; // Allow sort
		$this->Id_Division->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->Id_Division->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->fields['Id_Division'] = &$this->Id_Division;

		// Id_Turno
		$this->Id_Turno = new cField('estado_documentacion_personas', 'estado_documentacion_personas', 'x_Id_Turno', 'Id_Turno', '`Id_Turno`', '`Id_Turno`', 3, -1, FALSE, '`Id_Turno`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->Id_Turno->Sortable = TRUE; // Allow sort
		$this->Id_Turno->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->Id_Turno->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->fields['Id_Turno'] = &$this->Id_Turno;

		// Id_Estado
		$this->Id_Estado = new cField('estado_documentacion_personas', 'estado_documentacion_personas', 'x_Id_Estado', 'Id_Estado', '`Id_Estado`', '`Id_Estado`', 3, -1, FALSE, '`Id_Estado`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'SELECT');
		$this->Id_Estado->Sortable = TRUE; // Allow sort
		$this->Id_Estado->UsePleaseSelect = TRUE; // Use PleaseSelect by default
		$this->Id_Estado->PleaseSelectText = $Language->Phrase("PleaseSelect"); // PleaseSelect text
		$this->Id_Estado->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Id_Estado'] = &$this->Id_Estado;

		// Id_Cargo
		$this->Id_Cargo = new cField('estado_documentacion_personas', 'estado_documentacion_personas', 'x_Id_Cargo', 'Id_Cargo', '`Id_Cargo`', '`Id_Cargo`', 3, -1, FALSE, '`Id_Cargo`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'TEXT');
		$this->Id_Cargo->Sortable = TRUE; // Allow sort
		$this->Id_Cargo->FldDefaultErrMsg = $Language->Phrase("IncorrectInteger");
		$this->fields['Id_Cargo'] = &$this->Id_Cargo;

		// Matricula
		$this->Matricula = new cField('estado_documentacion_personas', 'estado_documentacion_personas', 'x_Matricula', 'Matricula', '`Matricula`', '`Matricula`', 200, -1, FALSE, '`Matricula`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'RADIO');
		$this->Matricula->Sortable = TRUE; // Allow sort
		$this->Matricula->OptionCount = 2;
		$this->fields['Matricula'] = &$this->Matricula;

		// Certificado_Pase
		$this->Certificado_Pase = new cField('estado_documentacion_personas', 'estado_documentacion_personas', 'x_Certificado_Pase', 'Certificado_Pase', '`Certificado_Pase`', '`Certificado_Pase`', 200, -1, FALSE, '`Certificado_Pase`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'RADIO');
		$this->Certificado_Pase->Sortable = TRUE; // Allow sort
		$this->Certificado_Pase->OptionCount = 2;
		$this->fields['Certificado_Pase'] = &$this->Certificado_Pase;

		// Tiene_DNI
		$this->Tiene_DNI = new cField('estado_documentacion_personas', 'estado_documentacion_personas', 'x_Tiene_DNI', 'Tiene_DNI', '`Tiene_DNI`', '`Tiene_DNI`', 200, -1, FALSE, '`Tiene_DNI`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'RADIO');
		$this->Tiene_DNI->Sortable = TRUE; // Allow sort
		$this->Tiene_DNI->OptionCount = 2;
		$this->fields['Tiene_DNI'] = &$this->Tiene_DNI;

		// Certificado_Medico
		$this->Certificado_Medico = new cField('estado_documentacion_personas', 'estado_documentacion_personas', 'x_Certificado_Medico', 'Certificado_Medico', '`Certificado_Medico`', '`Certificado_Medico`', 200, -1, FALSE, '`Certificado_Medico`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'RADIO');
		$this->Certificado_Medico->Sortable = TRUE; // Allow sort
		$this->Certificado_Medico->OptionCount = 2;
		$this->fields['Certificado_Medico'] = &$this->Certificado_Medico;

		// Posee_Autorizacion
		$this->Posee_Autorizacion = new cField('estado_documentacion_personas', 'estado_documentacion_personas', 'x_Posee_Autorizacion', 'Posee_Autorizacion', '`Posee_Autorizacion`', '`Posee_Autorizacion`', 200, -1, FALSE, '`Posee_Autorizacion`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'RADIO');
		$this->Posee_Autorizacion->Sortable = TRUE; // Allow sort
		$this->Posee_Autorizacion->OptionCount = 2;
		$this->fields['Posee_Autorizacion'] = &$this->Posee_Autorizacion;

		// Cooperadora
		$this->Cooperadora = new cField('estado_documentacion_personas', 'estado_documentacion_personas', 'x_Cooperadora', 'Cooperadora', '`Cooperadora`', '`Cooperadora`', 200, -1, FALSE, '`Cooperadora`', FALSE, FALSE, FALSE, 'FORMATTED TEXT', 'RADIO');
		$this->Cooperadora->Sortable = TRUE; // Allow sort
		$this->Cooperadora->OptionCount = 2;
		$this->fields['Cooperadora'] = &$this->Cooperadora;
	}

	// Set Field Visibility
	function SetFieldVisibility($fldparm) {
		global $Security;
		return $this->$fldparm->Visible; // Returns original value
	}

	// Single column sort
	function UpdateSort(&$ofld) {
		if ($this->CurrentOrder == $ofld->FldName) {
			$sSortField = $ofld->FldExpression;
			$sLastSort = $ofld->getSort();
			if ($this->CurrentOrderType == "ASC" || $this->CurrentOrderType == "DESC") {
				$sThisSort = $this->CurrentOrderType;
			} else {
				$sThisSort = ($sLastSort == "ASC") ? "DESC" : "ASC";
			}
			$ofld->setSort($sThisSort);
			$this->setSessionOrderBy($sSortField . " " . $sThisSort); // Save to Session
		} else {
			$ofld->setSort("");
		}
	}

	// Table level SQL
	var $_SqlFrom = "";

	function getSqlFrom() { // From
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`estado_documentacion_personas`";
	}

	function SqlFrom() { // For backward compatibility
		return $this->getSqlFrom();
	}

	function setSqlFrom($v) {
		$this->_SqlFrom = $v;
	}
	var $_SqlSelect = "";

	function getSqlSelect() { // Select
		return ($this->_SqlSelect <> "") ? $this->_SqlSelect : "SELECT * FROM " . $this->getSqlFrom();
	}

	function SqlSelect() { // For backward compatibility
		return $this->getSqlSelect();
	}

	function setSqlSelect($v) {
		$this->_SqlSelect = $v;
	}
	var $_SqlWhere = "";

	function getSqlWhere() { // Where
		$sWhere = ($this->_SqlWhere <> "") ? $this->_SqlWhere : "";
		$this->TableFilter = "";
		ew_AddFilter($sWhere, $this->TableFilter);
		return $sWhere;
	}

	function SqlWhere() { // For backward compatibility
		return $this->getSqlWhere();
	}

	function setSqlWhere($v) {
		$this->_SqlWhere = $v;
	}
	var $_SqlGroupBy = "";

	function getSqlGroupBy() { // Group By
		return ($this->_SqlGroupBy <> "") ? $this->_SqlGroupBy : "";
	}

	function SqlGroupBy() { // For backward compatibility
		return $this->getSqlGroupBy();
	}

	function setSqlGroupBy($v) {
		$this->_SqlGroupBy = $v;
	}
	var $_SqlHaving = "";

	function getSqlHaving() { // Having
		return ($this->_SqlHaving <> "") ? $this->_SqlHaving : "";
	}

	function SqlHaving() { // For backward compatibility
		return $this->getSqlHaving();
	}

	function setSqlHaving($v) {
		$this->_SqlHaving = $v;
	}
	var $_SqlOrderBy = "";

	function getSqlOrderBy() { // Order By
		return ($this->_SqlOrderBy <> "") ? $this->_SqlOrderBy : "`Apellidos_Nombres` ASC";
	}

	function SqlOrderBy() { // For backward compatibility
		return $this->getSqlOrderBy();
	}

	function setSqlOrderBy($v) {
		$this->_SqlOrderBy = $v;
	}

	// Apply User ID filters
	function ApplyUserIDFilters($sFilter) {
		return $sFilter;
	}

	// Check if User ID security allows view all
	function UserIDAllow($id = "") {
		$allow = EW_USER_ID_ALLOW;
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
			case "changepwd":
			case "forgotpwd":
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

	// Get SQL
	function GetSQL($where, $orderby) {
		return ew_BuildSelectSql($this->getSqlSelect(), $this->getSqlWhere(),
			$this->getSqlGroupBy(), $this->getSqlHaving(), $this->getSqlOrderBy(),
			$where, $orderby);
	}

	// Table SQL
	function SQL() {
		$sFilter = $this->CurrentFilter;
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql($this->getSqlSelect(), $this->getSqlWhere(),
			$this->getSqlGroupBy(), $this->getSqlHaving(), $this->getSqlOrderBy(),
			$sFilter, $sSort);
	}

	// Table SQL with List page filter
	function SelectSQL() {
		$sFilter = $this->getSessionWhere();
		ew_AddFilter($sFilter, $this->CurrentFilter);
		$sFilter = $this->ApplyUserIDFilters($sFilter);
		$this->Recordset_Selecting($sFilter);
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql($this->getSqlSelect(), $this->getSqlWhere(), $this->getSqlGroupBy(),
			$this->getSqlHaving(), $this->getSqlOrderBy(), $sFilter, $sSort);
	}

	// Get ORDER BY clause
	function GetOrderBy() {
		$sSort = $this->getSessionOrderBy();
		return ew_BuildSelectSql("", "", "", "", $this->getSqlOrderBy(), "", $sSort);
	}

	// Try to get record count
	function TryGetRecordCount($sSql) {
		$cnt = -1;
		if (($this->TableType == 'TABLE' || $this->TableType == 'VIEW' || $this->TableType == 'LINKTABLE') && preg_match("/^SELECT \* FROM/i", $sSql)) {
			$sSql = "SELECT COUNT(*) FROM" . preg_replace('/^SELECT\s([\s\S]+)?\*\sFROM/i', "", $sSql);
			$sOrderBy = $this->GetOrderBy();
			if (substr($sSql, strlen($sOrderBy) * -1) == $sOrderBy)
				$sSql = substr($sSql, 0, strlen($sSql) - strlen($sOrderBy)); // Remove ORDER BY clause
		} else {
			$sSql = "SELECT COUNT(*) FROM (" . $sSql . ") EW_COUNT_TABLE";
		}
		$conn = &$this->Connection();
		if ($rs = $conn->Execute($sSql)) {
			if (!$rs->EOF && $rs->FieldCount() > 0) {
				$cnt = $rs->fields[0];
				$rs->Close();
			}
		}
		return intval($cnt);
	}

	// Get record count based on filter (for detail record count in master table pages)
	function LoadRecordCount($sFilter) {
		$origFilter = $this->CurrentFilter;
		$this->CurrentFilter = $sFilter;
		$this->Recordset_Selecting($this->CurrentFilter);

		//$sSql = $this->SQL();
		$sSql = $this->GetSQL($this->CurrentFilter, "");
		$cnt = $this->TryGetRecordCount($sSql);
		if ($cnt == -1) {
			if ($rs = $this->LoadRs($this->CurrentFilter)) {
				$cnt = $rs->RecordCount();
				$rs->Close();
			}
		}
		$this->CurrentFilter = $origFilter;
		return intval($cnt);
	}

	// Get record count (for current List page)
	function SelectRecordCount() {
		$sSql = $this->SelectSQL();
		$cnt = $this->TryGetRecordCount($sSql);
		if ($cnt == -1) {
			$conn = &$this->Connection();
			if ($rs = $conn->Execute($sSql)) {
				$cnt = $rs->RecordCount();
				$rs->Close();
			}
		}
		return intval($cnt);
	}

	// INSERT statement
	function InsertSQL(&$rs) {
		$names = "";
		$values = "";
		foreach ($rs as $name => $value) {
			if (!isset($this->fields[$name]) || $this->fields[$name]->FldIsCustom)
				continue;
			$names .= $this->fields[$name]->FldExpression . ",";
			$values .= ew_QuotedValue($value, $this->fields[$name]->FldDataType, $this->DBID) . ",";
		}
		while (substr($names, -1) == ",")
			$names = substr($names, 0, -1);
		while (substr($values, -1) == ",")
			$values = substr($values, 0, -1);
		return "INSERT INTO " . $this->UpdateTable . " ($names) VALUES ($values)";
	}

	// Insert
	function Insert(&$rs) {
		$conn = &$this->Connection();
		return $conn->Execute($this->InsertSQL($rs));
	}

	// UPDATE statement
	function UpdateSQL(&$rs, $where = "", $curfilter = TRUE) {
		$sql = "UPDATE " . $this->UpdateTable . " SET ";
		foreach ($rs as $name => $value) {
			if (!isset($this->fields[$name]) || $this->fields[$name]->FldIsCustom)
				continue;
			$sql .= $this->fields[$name]->FldExpression . "=";
			$sql .= ew_QuotedValue($value, $this->fields[$name]->FldDataType, $this->DBID) . ",";
		}
		while (substr($sql, -1) == ",")
			$sql = substr($sql, 0, -1);
		$filter = ($curfilter) ? $this->CurrentFilter : "";
		if (is_array($where))
			$where = $this->ArrayToFilter($where);
		ew_AddFilter($filter, $where);
		if ($filter <> "")	$sql .= " WHERE " . $filter;
		return $sql;
	}

	// Update
	function Update(&$rs, $where = "", $rsold = NULL, $curfilter = TRUE) {
		$conn = &$this->Connection();
		return $conn->Execute($this->UpdateSQL($rs, $where, $curfilter));
	}

	// DELETE statement
	function DeleteSQL(&$rs, $where = "", $curfilter = TRUE) {
		$sql = "DELETE FROM " . $this->UpdateTable . " WHERE ";
		if (is_array($where))
			$where = $this->ArrayToFilter($where);
		if ($rs) {
			if (array_key_exists('Dni', $rs))
				ew_AddFilter($where, ew_QuotedName('Dni', $this->DBID) . '=' . ew_QuotedValue($rs['Dni'], $this->Dni->FldDataType, $this->DBID));
		}
		$filter = ($curfilter) ? $this->CurrentFilter : "";
		ew_AddFilter($filter, $where);
		if ($filter <> "")
			$sql .= $filter;
		else
			$sql .= "0=1"; // Avoid delete
		return $sql;
	}

	// Delete
	function Delete(&$rs, $where = "", $curfilter = TRUE) {
		$conn = &$this->Connection();
		return $conn->Execute($this->DeleteSQL($rs, $where, $curfilter));
	}

	// Key filter WHERE clause
	function SqlKeyFilter() {
		return "`Dni` = @Dni@";
	}

	// Key filter
	function KeyFilter() {
		$sKeyFilter = $this->SqlKeyFilter();
		if (!is_numeric($this->Dni->CurrentValue))
			$sKeyFilter = "0=1"; // Invalid key
		$sKeyFilter = str_replace("@Dni@", ew_AdjustSql($this->Dni->CurrentValue, $this->DBID), $sKeyFilter); // Replace key value
		return $sKeyFilter;
	}

	// Return page URL
	function getReturnUrl() {
		$name = EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL;

		// Get referer URL automatically
		if (ew_ServerVar("HTTP_REFERER") <> "" && ew_ReferPage() <> ew_CurrentPage() && ew_ReferPage() <> "login.php") // Referer not same page or login page
			$_SESSION[$name] = ew_ServerVar("HTTP_REFERER"); // Save to Session
		if (@$_SESSION[$name] <> "") {
			return $_SESSION[$name];
		} else {
			return "estado_documentacion_personaslist.php";
		}
	}

	function setReturnUrl($v) {
		$_SESSION[EW_PROJECT_NAME . "_" . $this->TableVar . "_" . EW_TABLE_RETURN_URL] = $v;
	}

	// List URL
	function GetListUrl() {
		return "estado_documentacion_personaslist.php";
	}

	// View URL
	function GetViewUrl($parm = "") {
		if ($parm <> "")
			$url = $this->KeyUrl("estado_documentacion_personasview.php", $this->UrlParm($parm));
		else
			$url = $this->KeyUrl("estado_documentacion_personasview.php", $this->UrlParm(EW_TABLE_SHOW_DETAIL . "="));
		return $this->AddMasterUrl($url);
	}

	// Add URL
	function GetAddUrl($parm = "") {
		if ($parm <> "")
			$url = "estado_documentacion_personasadd.php?" . $this->UrlParm($parm);
		else
			$url = "estado_documentacion_personasadd.php";
		return $this->AddMasterUrl($url);
	}

	// Edit URL
	function GetEditUrl($parm = "") {
		$url = $this->KeyUrl("estado_documentacion_personasedit.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline edit URL
	function GetInlineEditUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=edit"));
		return $this->AddMasterUrl($url);
	}

	// Copy URL
	function GetCopyUrl($parm = "") {
		$url = $this->KeyUrl("estado_documentacion_personasadd.php", $this->UrlParm($parm));
		return $this->AddMasterUrl($url);
	}

	// Inline copy URL
	function GetInlineCopyUrl() {
		$url = $this->KeyUrl(ew_CurrentPage(), $this->UrlParm("a=copy"));
		return $this->AddMasterUrl($url);
	}

	// Delete URL
	function GetDeleteUrl() {
		return $this->KeyUrl("estado_documentacion_personasdelete.php", $this->UrlParm());
	}

	// Add master url
	function AddMasterUrl($url) {
		return $url;
	}

	function KeyToJson() {
		$json = "";
		$json .= "Dni:" . ew_VarToJson($this->Dni->CurrentValue, "number", "'");
		return "{" . $json . "}";
	}

	// Add key value to URL
	function KeyUrl($url, $parm = "") {
		$sUrl = $url . "?";
		if ($parm <> "") $sUrl .= $parm . "&";
		if (!is_null($this->Dni->CurrentValue)) {
			$sUrl .= "Dni=" . urlencode($this->Dni->CurrentValue);
		} else {
			return "javascript:ew_Alert(ewLanguage.Phrase('InvalidRecord'));";
		}
		return $sUrl;
	}

	// Sort URL
	function SortUrl(&$fld) {
		if ($this->CurrentAction <> "" || $this->Export <> "" ||
			in_array($fld->FldType, array(128, 204, 205))) { // Unsortable data type
				return "";
		} elseif ($fld->Sortable) {
			$sUrlParm = $this->UrlParm("order=" . urlencode($fld->FldName) . "&amp;ordertype=" . $fld->ReverseSort());
			return $this->AddMasterUrl(ew_CurrentPage() . "?" . $sUrlParm);
		} else {
			return "";
		}
	}

	// Get record keys from $_POST/$_GET/$_SESSION
	function GetRecordKeys() {
		global $EW_COMPOSITE_KEY_SEPARATOR;
		$arKeys = array();
		$arKey = array();
		if (isset($_POST["key_m"])) {
			$arKeys = ew_StripSlashes($_POST["key_m"]);
			$cnt = count($arKeys);
		} elseif (isset($_GET["key_m"])) {
			$arKeys = ew_StripSlashes($_GET["key_m"]);
			$cnt = count($arKeys);
		} elseif (!empty($_GET) || !empty($_POST)) {
			$isPost = ew_IsHttpPost();
			if ($isPost && isset($_POST["Dni"]))
				$arKeys[] = ew_StripSlashes($_POST["Dni"]);
			elseif (isset($_GET["Dni"]))
				$arKeys[] = ew_StripSlashes($_GET["Dni"]);
			else
				$arKeys = NULL; // Do not setup

			//return $arKeys; // Do not return yet, so the values will also be checked by the following code
		}

		// Check keys
		$ar = array();
		if (is_array($arKeys)) {
			foreach ($arKeys as $key) {
				if (!is_numeric($key))
					continue;
				$ar[] = $key;
			}
		}
		return $ar;
	}

	// Get key filter
	function GetKeyFilter() {
		$arKeys = $this->GetRecordKeys();
		$sKeyFilter = "";
		foreach ($arKeys as $key) {
			if ($sKeyFilter <> "") $sKeyFilter .= " OR ";
			$this->Dni->CurrentValue = $key;
			$sKeyFilter .= "(" . $this->KeyFilter() . ")";
		}
		return $sKeyFilter;
	}

	// Load rows based on filter
	function &LoadRs($sFilter) {

		// Set up filter (SQL WHERE clause) and get return SQL
		//$this->CurrentFilter = $sFilter;
		//$sSql = $this->SQL();

		$sSql = $this->GetSQL($sFilter, "");
		$conn = &$this->Connection();
		$rs = $conn->Execute($sSql);
		return $rs;
	}

	// Load row values from recordset
	function LoadListRowValues(&$rs) {
		$this->Apellidos_Nombres->setDbValue($rs->fields('Apellidos_Nombres'));
		$this->Dni->setDbValue($rs->fields('Dni'));
		$this->Id_Curso->setDbValue($rs->fields('Id_Curso'));
		$this->Id_Division->setDbValue($rs->fields('Id_Division'));
		$this->Id_Turno->setDbValue($rs->fields('Id_Turno'));
		$this->Id_Estado->setDbValue($rs->fields('Id_Estado'));
		$this->Id_Cargo->setDbValue($rs->fields('Id_Cargo'));
		$this->Matricula->setDbValue($rs->fields('Matricula'));
		$this->Certificado_Pase->setDbValue($rs->fields('Certificado_Pase'));
		$this->Tiene_DNI->setDbValue($rs->fields('Tiene_DNI'));
		$this->Certificado_Medico->setDbValue($rs->fields('Certificado_Medico'));
		$this->Posee_Autorizacion->setDbValue($rs->fields('Posee_Autorizacion'));
		$this->Cooperadora->setDbValue($rs->fields('Cooperadora'));
	}

	// Render list row values
	function RenderListRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

   // Common render codes
		// Apellidos_Nombres
		// Dni
		// Id_Curso
		// Id_Division
		// Id_Turno
		// Id_Estado
		// Id_Cargo
		// Matricula
		// Certificado_Pase
		// Tiene_DNI
		// Certificado_Medico
		// Posee_Autorizacion
		// Cooperadora
		// Apellidos_Nombres

		$this->Apellidos_Nombres->ViewValue = $this->Apellidos_Nombres->CurrentValue;
		$this->Apellidos_Nombres->ViewCustomAttributes = "";

		// Dni
		$this->Dni->ViewValue = $this->Dni->CurrentValue;
		$this->Dni->ViewCustomAttributes = "";

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

		// Id_Cargo
		$this->Id_Cargo->ViewValue = $this->Id_Cargo->CurrentValue;
		$this->Id_Cargo->ViewCustomAttributes = "";

		// Matricula
		if (strval($this->Matricula->CurrentValue) <> "") {
			$this->Matricula->ViewValue = $this->Matricula->OptionCaption($this->Matricula->CurrentValue);
		} else {
			$this->Matricula->ViewValue = NULL;
		}
		$this->Matricula->ViewCustomAttributes = "";

		// Certificado_Pase
		if (strval($this->Certificado_Pase->CurrentValue) <> "") {
			$this->Certificado_Pase->ViewValue = $this->Certificado_Pase->OptionCaption($this->Certificado_Pase->CurrentValue);
		} else {
			$this->Certificado_Pase->ViewValue = NULL;
		}
		$this->Certificado_Pase->ViewCustomAttributes = "";

		// Tiene_DNI
		if (strval($this->Tiene_DNI->CurrentValue) <> "") {
			$this->Tiene_DNI->ViewValue = $this->Tiene_DNI->OptionCaption($this->Tiene_DNI->CurrentValue);
		} else {
			$this->Tiene_DNI->ViewValue = NULL;
		}
		$this->Tiene_DNI->ViewCustomAttributes = "";

		// Certificado_Medico
		if (strval($this->Certificado_Medico->CurrentValue) <> "") {
			$this->Certificado_Medico->ViewValue = $this->Certificado_Medico->OptionCaption($this->Certificado_Medico->CurrentValue);
		} else {
			$this->Certificado_Medico->ViewValue = NULL;
		}
		$this->Certificado_Medico->ViewCustomAttributes = "";

		// Posee_Autorizacion
		if (strval($this->Posee_Autorizacion->CurrentValue) <> "") {
			$this->Posee_Autorizacion->ViewValue = $this->Posee_Autorizacion->OptionCaption($this->Posee_Autorizacion->CurrentValue);
		} else {
			$this->Posee_Autorizacion->ViewValue = NULL;
		}
		$this->Posee_Autorizacion->ViewCustomAttributes = "";

		// Cooperadora
		if (strval($this->Cooperadora->CurrentValue) <> "") {
			$this->Cooperadora->ViewValue = $this->Cooperadora->OptionCaption($this->Cooperadora->CurrentValue);
		} else {
			$this->Cooperadora->ViewValue = NULL;
		}
		$this->Cooperadora->ViewCustomAttributes = "";

		// Apellidos_Nombres
		$this->Apellidos_Nombres->LinkCustomAttributes = "";
		$this->Apellidos_Nombres->HrefValue = "";
		$this->Apellidos_Nombres->TooltipValue = "";

		// Dni
		$this->Dni->LinkCustomAttributes = "";
		$this->Dni->HrefValue = "";
		$this->Dni->TooltipValue = "";

		// Id_Curso
		$this->Id_Curso->LinkCustomAttributes = "";
		$this->Id_Curso->HrefValue = "";
		$this->Id_Curso->TooltipValue = "";

		// Id_Division
		$this->Id_Division->LinkCustomAttributes = "";
		$this->Id_Division->HrefValue = "";
		$this->Id_Division->TooltipValue = "";

		// Id_Turno
		$this->Id_Turno->LinkCustomAttributes = "";
		$this->Id_Turno->HrefValue = "";
		$this->Id_Turno->TooltipValue = "";

		// Id_Estado
		$this->Id_Estado->LinkCustomAttributes = "";
		$this->Id_Estado->HrefValue = "";
		$this->Id_Estado->TooltipValue = "";

		// Id_Cargo
		$this->Id_Cargo->LinkCustomAttributes = "";
		$this->Id_Cargo->HrefValue = "";
		$this->Id_Cargo->TooltipValue = "";

		// Matricula
		$this->Matricula->LinkCustomAttributes = "";
		$this->Matricula->HrefValue = "";
		$this->Matricula->TooltipValue = "";

		// Certificado_Pase
		$this->Certificado_Pase->LinkCustomAttributes = "";
		$this->Certificado_Pase->HrefValue = "";
		$this->Certificado_Pase->TooltipValue = "";

		// Tiene_DNI
		$this->Tiene_DNI->LinkCustomAttributes = "";
		$this->Tiene_DNI->HrefValue = "";
		$this->Tiene_DNI->TooltipValue = "";

		// Certificado_Medico
		$this->Certificado_Medico->LinkCustomAttributes = "";
		$this->Certificado_Medico->HrefValue = "";
		$this->Certificado_Medico->TooltipValue = "";

		// Posee_Autorizacion
		$this->Posee_Autorizacion->LinkCustomAttributes = "";
		$this->Posee_Autorizacion->HrefValue = "";
		$this->Posee_Autorizacion->TooltipValue = "";

		// Cooperadora
		$this->Cooperadora->LinkCustomAttributes = "";
		$this->Cooperadora->HrefValue = "";
		$this->Cooperadora->TooltipValue = "";

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Render edit row values
	function RenderEditRow() {
		global $Security, $gsLanguage, $Language;

		// Call Row Rendering event
		$this->Row_Rendering();

		// Apellidos_Nombres
		$this->Apellidos_Nombres->EditAttrs["class"] = "form-control";
		$this->Apellidos_Nombres->EditCustomAttributes = "";
		$this->Apellidos_Nombres->EditValue = $this->Apellidos_Nombres->CurrentValue;
		$this->Apellidos_Nombres->PlaceHolder = ew_RemoveHtml($this->Apellidos_Nombres->FldCaption());

		// Dni
		$this->Dni->EditAttrs["class"] = "form-control";
		$this->Dni->EditCustomAttributes = "";
		$this->Dni->EditValue = $this->Dni->CurrentValue;
		$this->Dni->ViewCustomAttributes = "";

		// Id_Curso
		$this->Id_Curso->EditAttrs["class"] = "form-control";
		$this->Id_Curso->EditCustomAttributes = "";

		// Id_Division
		$this->Id_Division->EditAttrs["class"] = "form-control";
		$this->Id_Division->EditCustomAttributes = "";

		// Id_Turno
		$this->Id_Turno->EditAttrs["class"] = "form-control";
		$this->Id_Turno->EditCustomAttributes = "";

		// Id_Estado
		$this->Id_Estado->EditAttrs["class"] = "form-control";
		$this->Id_Estado->EditCustomAttributes = "";

		// Id_Cargo
		$this->Id_Cargo->EditAttrs["class"] = "form-control";
		$this->Id_Cargo->EditCustomAttributes = "";
		$this->Id_Cargo->EditValue = $this->Id_Cargo->CurrentValue;
		$this->Id_Cargo->PlaceHolder = ew_RemoveHtml($this->Id_Cargo->FldCaption());

		// Matricula
		$this->Matricula->EditCustomAttributes = "";
		$this->Matricula->EditValue = $this->Matricula->Options(FALSE);

		// Certificado_Pase
		$this->Certificado_Pase->EditCustomAttributes = "";
		$this->Certificado_Pase->EditValue = $this->Certificado_Pase->Options(FALSE);

		// Tiene_DNI
		$this->Tiene_DNI->EditCustomAttributes = "";
		$this->Tiene_DNI->EditValue = $this->Tiene_DNI->Options(FALSE);

		// Certificado_Medico
		$this->Certificado_Medico->EditCustomAttributes = "";
		$this->Certificado_Medico->EditValue = $this->Certificado_Medico->Options(FALSE);

		// Posee_Autorizacion
		$this->Posee_Autorizacion->EditCustomAttributes = "";
		$this->Posee_Autorizacion->EditValue = $this->Posee_Autorizacion->Options(FALSE);

		// Cooperadora
		$this->Cooperadora->EditCustomAttributes = "";
		$this->Cooperadora->EditValue = $this->Cooperadora->Options(FALSE);

		// Call Row Rendered event
		$this->Row_Rendered();
	}

	// Aggregate list row values
	function AggregateListRowValues() {
	}

	// Aggregate list row (for rendering)
	function AggregateListRow() {

		// Call Row Rendered event
		$this->Row_Rendered();
	}
	var $ExportDoc;

	// Export data in HTML/CSV/Word/Excel/Email/PDF format
	function ExportDocument(&$Doc, &$Recordset, $StartRec, $StopRec, $ExportPageType = "") {
		if (!$Recordset || !$Doc)
			return;
		if (!$Doc->ExportCustom) {

			// Write header
			$Doc->ExportTableHeader();
			if ($Doc->Horizontal) { // Horizontal format, write header
				$Doc->BeginExportRow();
				if ($ExportPageType == "view") {
					if ($this->Apellidos_Nombres->Exportable) $Doc->ExportCaption($this->Apellidos_Nombres);
					if ($this->Dni->Exportable) $Doc->ExportCaption($this->Dni);
					if ($this->Id_Curso->Exportable) $Doc->ExportCaption($this->Id_Curso);
					if ($this->Id_Division->Exportable) $Doc->ExportCaption($this->Id_Division);
					if ($this->Id_Turno->Exportable) $Doc->ExportCaption($this->Id_Turno);
					if ($this->Id_Estado->Exportable) $Doc->ExportCaption($this->Id_Estado);
					if ($this->Id_Cargo->Exportable) $Doc->ExportCaption($this->Id_Cargo);
					if ($this->Matricula->Exportable) $Doc->ExportCaption($this->Matricula);
					if ($this->Certificado_Pase->Exportable) $Doc->ExportCaption($this->Certificado_Pase);
					if ($this->Tiene_DNI->Exportable) $Doc->ExportCaption($this->Tiene_DNI);
					if ($this->Certificado_Medico->Exportable) $Doc->ExportCaption($this->Certificado_Medico);
					if ($this->Posee_Autorizacion->Exportable) $Doc->ExportCaption($this->Posee_Autorizacion);
					if ($this->Cooperadora->Exportable) $Doc->ExportCaption($this->Cooperadora);
				} else {
					if ($this->Apellidos_Nombres->Exportable) $Doc->ExportCaption($this->Apellidos_Nombres);
					if ($this->Dni->Exportable) $Doc->ExportCaption($this->Dni);
					if ($this->Id_Curso->Exportable) $Doc->ExportCaption($this->Id_Curso);
					if ($this->Id_Division->Exportable) $Doc->ExportCaption($this->Id_Division);
					if ($this->Id_Turno->Exportable) $Doc->ExportCaption($this->Id_Turno);
					if ($this->Id_Estado->Exportable) $Doc->ExportCaption($this->Id_Estado);
					if ($this->Id_Cargo->Exportable) $Doc->ExportCaption($this->Id_Cargo);
					if ($this->Matricula->Exportable) $Doc->ExportCaption($this->Matricula);
					if ($this->Certificado_Pase->Exportable) $Doc->ExportCaption($this->Certificado_Pase);
					if ($this->Tiene_DNI->Exportable) $Doc->ExportCaption($this->Tiene_DNI);
					if ($this->Certificado_Medico->Exportable) $Doc->ExportCaption($this->Certificado_Medico);
					if ($this->Posee_Autorizacion->Exportable) $Doc->ExportCaption($this->Posee_Autorizacion);
					if ($this->Cooperadora->Exportable) $Doc->ExportCaption($this->Cooperadora);
				}
				$Doc->EndExportRow();
			}
		}

		// Move to first record
		$RecCnt = $StartRec - 1;
		if (!$Recordset->EOF) {
			$Recordset->MoveFirst();
			if ($StartRec > 1)
				$Recordset->Move($StartRec - 1);
		}
		while (!$Recordset->EOF && $RecCnt < $StopRec) {
			$RecCnt++;
			if (intval($RecCnt) >= intval($StartRec)) {
				$RowCnt = intval($RecCnt) - intval($StartRec) + 1;

				// Page break
				if ($this->ExportPageBreakCount > 0) {
					if ($RowCnt > 1 && ($RowCnt - 1) % $this->ExportPageBreakCount == 0)
						$Doc->ExportPageBreak();
				}
				$this->LoadListRowValues($Recordset);

				// Render row
				$this->RowType = EW_ROWTYPE_VIEW; // Render view
				$this->ResetAttrs();
				$this->RenderListRow();
				if (!$Doc->ExportCustom) {
					$Doc->BeginExportRow($RowCnt); // Allow CSS styles if enabled
					if ($ExportPageType == "view") {
						if ($this->Apellidos_Nombres->Exportable) $Doc->ExportField($this->Apellidos_Nombres);
						if ($this->Dni->Exportable) $Doc->ExportField($this->Dni);
						if ($this->Id_Curso->Exportable) $Doc->ExportField($this->Id_Curso);
						if ($this->Id_Division->Exportable) $Doc->ExportField($this->Id_Division);
						if ($this->Id_Turno->Exportable) $Doc->ExportField($this->Id_Turno);
						if ($this->Id_Estado->Exportable) $Doc->ExportField($this->Id_Estado);
						if ($this->Id_Cargo->Exportable) $Doc->ExportField($this->Id_Cargo);
						if ($this->Matricula->Exportable) $Doc->ExportField($this->Matricula);
						if ($this->Certificado_Pase->Exportable) $Doc->ExportField($this->Certificado_Pase);
						if ($this->Tiene_DNI->Exportable) $Doc->ExportField($this->Tiene_DNI);
						if ($this->Certificado_Medico->Exportable) $Doc->ExportField($this->Certificado_Medico);
						if ($this->Posee_Autorizacion->Exportable) $Doc->ExportField($this->Posee_Autorizacion);
						if ($this->Cooperadora->Exportable) $Doc->ExportField($this->Cooperadora);
					} else {
						if ($this->Apellidos_Nombres->Exportable) $Doc->ExportField($this->Apellidos_Nombres);
						if ($this->Dni->Exportable) $Doc->ExportField($this->Dni);
						if ($this->Id_Curso->Exportable) $Doc->ExportField($this->Id_Curso);
						if ($this->Id_Division->Exportable) $Doc->ExportField($this->Id_Division);
						if ($this->Id_Turno->Exportable) $Doc->ExportField($this->Id_Turno);
						if ($this->Id_Estado->Exportable) $Doc->ExportField($this->Id_Estado);
						if ($this->Id_Cargo->Exportable) $Doc->ExportField($this->Id_Cargo);
						if ($this->Matricula->Exportable) $Doc->ExportField($this->Matricula);
						if ($this->Certificado_Pase->Exportable) $Doc->ExportField($this->Certificado_Pase);
						if ($this->Tiene_DNI->Exportable) $Doc->ExportField($this->Tiene_DNI);
						if ($this->Certificado_Medico->Exportable) $Doc->ExportField($this->Certificado_Medico);
						if ($this->Posee_Autorizacion->Exportable) $Doc->ExportField($this->Posee_Autorizacion);
						if ($this->Cooperadora->Exportable) $Doc->ExportField($this->Cooperadora);
					}
					$Doc->EndExportRow();
				}
			}

			// Call Row Export server event
			if ($Doc->ExportCustom)
				$this->Row_Export($Recordset->fields);
			$Recordset->MoveNext();
		}
		if (!$Doc->ExportCustom) {
			$Doc->ExportTableFooter();
		}
	}

	// Get auto fill value
	function GetAutoFill($id, $val) {
		$rsarr = array();
		$rowcnt = 0;

		// Output
		if (is_array($rsarr) && $rowcnt > 0) {
			$fldcnt = count($rsarr[0]);
			for ($i = 0; $i < $rowcnt; $i++) {
				for ($j = 0; $j < $fldcnt; $j++) {
					$str = strval($rsarr[$i][$j]);
					$str = ew_ConvertToUtf8($str);
					if (isset($post["keepCRLF"])) {
						$str = str_replace(array("\r", "\n"), array("\\r", "\\n"), $str);
					} else {
						$str = str_replace(array("\r", "\n"), array(" ", " "), $str);
					}
					$rsarr[$i][$j] = $str;
				}
			}
			return ew_ArrayToJson($rsarr);
		} else {
			return FALSE;
		}
	}

	// Table level events
	// Recordset Selecting event
	function Recordset_Selecting(&$filter) {

		// Enter your code here	
	}

	// Recordset Selected event
	function Recordset_Selected(&$rs) {

		//echo "Recordset Selected";
	}

	// Recordset Search Validated event
	function Recordset_SearchValidated() {

		// Example:
		//$this->MyField1->AdvancedSearch->SearchValue = "your search criteria"; // Search value

	}

	// Recordset Searching event
	function Recordset_Searching(&$filter) {

		// Enter your code here	
	}

	// Row_Selecting event
	function Row_Selecting(&$filter) {

		// Enter your code here	
	}

	// Row Selected event
	function Row_Selected(&$rs) {

		//echo "Row Selected";
	}

	// Row Inserting event
	function Row_Inserting($rsold, &$rsnew) {

		// Enter your code here
		// To cancel, set return value to FALSE

		return TRUE;
	}

	// Row Inserted event
	function Row_Inserted($rsold, &$rsnew) {

		//echo "Row Inserted"
	}

	// Row Updating event
	function Row_Updating($rsold, &$rsnew) {

		// Enter your code here
		// To cancel, set return value to FALSE

		return TRUE;
	}

	// Row Updated event
	function Row_Updated($rsold, &$rsnew) {

		//echo "Row Updated";
	}

	// Row Update Conflict event
	function Row_UpdateConflict($rsold, &$rsnew) {

		// Enter your code here
		// To ignore conflict, set return value to FALSE

		return TRUE;
	}

	// Grid Inserting event
	function Grid_Inserting() {

		// Enter your code here
		// To reject grid insert, set return value to FALSE

		return TRUE;
	}

	// Grid Inserted event
	function Grid_Inserted($rsnew) {

		//echo "Grid Inserted";
	}

	// Grid Updating event
	function Grid_Updating($rsold) {

		// Enter your code here
		// To reject grid update, set return value to FALSE

		return TRUE;
	}

	// Grid Updated event
	function Grid_Updated($rsold, $rsnew) {

		//echo "Grid Updated";
	}

	// Row Deleting event
	function Row_Deleting(&$rs) {

		// Enter your code here
		// To cancel, set return value to False

		return TRUE;
	}

	// Row Deleted event
	function Row_Deleted(&$rs) {

		//echo "Row Deleted";
	}

	// Email Sending event
	function Email_Sending(&$Email, &$Args) {

		//var_dump($Email); var_dump($Args); exit();
		return TRUE;
	}

	// Lookup Selecting event
	function Lookup_Selecting($fld, &$filter) {

		//var_dump($fld->FldName, $fld->LookupFilters, $filter); // Uncomment to view the filter
		// Enter your code here

	}

	// Row Rendering event
	function Row_Rendering() {

		// Enter your code here	
	}

	// Row Rendered event
	function Row_Rendered() {

		// To view properties of field class, use:
		//var_dump($this-><FieldName>); 

	}

	// User ID Filtering event
	function UserID_Filtering(&$filter) {

		// Enter your code here
	}
}
?>
