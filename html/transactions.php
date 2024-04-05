<?php
/*
 * Mysql Ajax Table Editor
 *
 * Copyright (c) 2014 Chris Kitchen <info@mysqlajaxtableeditor.com>
 * All rights reserved.
 *
 * See COPYING file for license information.
 *
 * Download the latest version from
 * http://www.mysqlajaxtableeditor.com
 */
require_once('DBC.php');
require_once('Common.php');
require_once('php/lang/LangVars-en.php');
require_once('php/AjaxTableEditor.php');
class Transactions extends Common
{
	var $Editor;
	var $mateInstances = array('mate1_');
	
	protected function displayHtml()
	{
		$html = '
			
			<br />
			
			<div class="mateAjaxLoaderDiv"><div id="ajaxLoader1"><img src="images/ajax_loader.gif" alt="Loading..." /></div></div>
			
			<br /><br />
			
			<div id="'.$this->mateInstances[0].'information">
			</div>

			<div id="mateTooltipErrorDiv" style="display: none;"></div>
			
			<div id="'.$this->mateInstances[0].'titleLayer" class="mateTitleDiv">
			</div>
			
			<div id="'.$this->mateInstances[0].'tableLayer" class="mateTableDiv">
			</div>
			
			<div id="'.$this->mateInstances[0].'updateInPlaceLayer" class="mateUpdateInPlaceDiv">
			</div>
			
			<div id="'.$this->mateInstances[0].'recordLayer" class="mateRecordLayerDiv">
			</div>		
			
			<div id="'.$this->mateInstances[0].'searchButtonsLayer" class="mateSearchBtnsDiv">
			</div>';
			
		echo $html;
		
		// Set default session configuration variables here
		$defaultSessionData['orderByColumn'] = 'id';

		$defaultSessionData = base64_encode($this->Editor->jsonEncode($defaultSessionData));
		
		$javascript = '	
			<script type="text/javascript">
				var ' . $this->mateInstances[0] . ' = new mate("' . $this->mateInstances[0] . '");
				' . $this->mateInstances[0] . '.setAjaxInfo({url: "' . $_SERVER['PHP_SELF'] . '", history: true});
				' . $this->mateInstances[0] . '.init("' . $defaultSessionData . '");
				
				function startAutoCompleteInPlace(instanceName,rowNum)
				{
					var id = rowNum.length > 0 ? instanceName + "department_" + rowNum : instanceName + "department";
					$("input[type=text]#"+id).autocomplete({
						source: function(request, response) {
							$("#ajaxLoader1").css("display","block");
							var responseFun = function(data, textStatus, jqXHR) {
								response(data, textStatus, jqXHR);
								$("#ajaxLoader1").css("display","none");
							}
							$.getJSON("' . $_SERVER['PHP_SELF'] . '", { dept: request.term }, responseFun);
						}
					});
				}
				
				function startAutoComplete(instanceName)
				{
					$("input[type=text]#" + instanceName + "department").autocomplete({
						source: function(request, response) {
							$("#ajaxLoader1").css("display","block");
							var responseFun = function(data, textStatus, jqXHR) {
								response(data, textStatus, jqXHR);
								$("#ajaxLoader1").css("display","none");
							}
							$.getJSON("' . $_SERVER['PHP_SELF'] . '", { dept: request.term }, responseFun);
						}
					});
				}
				
			</script>';
		echo $javascript;
	}

	public function autoCompleteCallback($instanceName)
	{
		$this->Editor->addJavascript('startAutoComplete("' . $instanceName . '");');
	}
	
	public function autoCompleteInPlace($instanceName, $rowNum='')
	{
		$this->Editor->addJavascript('startAutoCompleteInPlace("' . $instanceName . '", "' . $rowNum . '");',1);
	}
	
	protected function initiateEditor()
	{
		$tableColumns['id'] = array(
			'display_text' => 'ID',
			'perms' => 'VTXQ', 
			'hidden_add' => true,
			'hidden_edit' => true,
		);

		$tableColumns['trans'] = array(
			'display_text' => 'Trans', 
			'perms' => 'EVCTXQS', 
		);

		$tableColumns['tdate'] = array(
			'display_text' => 'Date', 
			'perms' => 'EVCTAXQS', 
			'req' => false,
			'display_mask' => 'date_format(tdate,"%d %M %Y")',
			'order_mask' => 'date_format(tdate,"%Y %m %d")',
			'calendar' => array(
				'js_format' => 'dd MM yy',
				'options' => array('showButtonPanel' => true)),
				'col_header_info' => 'style="width: 180px;"',
		);
		
		$tableColumns['amount'] = array(
			'display_text' => 'Amount', 
			'perms' => 'EVCTAXQ', 
			'req' => true,
			'table_cell_info' => 'type="number" style="text-align:right; padding-right:10px"',
        );
	
		$tableColumns['account'] = array(
			'display_text' => 'Account', 
			'perms' => 'EVCTAXQS', 
			'req' => true,
			'select_query' => "select number, name from accounts",
        );
	
		$tableColumns['direction'] = array(
			'display_text' => 'Direction [1],-1', 
			'perms' => 'EVCTAXQ', 
			'req' => false,
			'checkbox' => array(
				'checked_value' => '1',
				'un_checked_value' => '-1',
			),
			'default' => '1',
        );
	
		$tableColumns['description'] = array(
			'display_text' => 'Description', 
			'perms' => 'EVCTAXQ', 
        );
	
		$tableColumns['chg_by'] = array(
			'display_text' => 'chg_by', 
			'perms' => 'VCTXQ', 
			'hidden_add' => true,
			'hidden_edit' => true,
        );
	
		$tableColumns['chg_date'] = array(
			'display_text' => 'chg_date', 
			'perms' => 'VCTXQ', 
			'hidden_add' => true,
			'hidden_edit' => true,
        );
	
		$tableName = 'transactions';
		$primaryCol = 'id';
		$errorFun = array(&$this,'logError');
		$permissions = 'EAVDQCSXHOM';
		
		$this->Editor = new AjaxTableEditor($tableName,$primaryCol,$errorFun,$permissions,$tableColumns);
		$this->Editor->setConfig('tableInfo','cellpadding="1" cellspacing="1" align="center" width="1100" class="mateTable"');
		$this->Editor->setConfig('orderByColumn','id');
		$this->Editor->setConfig('tableTitle','Transaction Journal<div style="font-size: 12px; font-weight: normal;"></div>');
		$this->Editor->setConfig('addRowTitle','Add Transaction<div style="font-size: 12px; font-weight: normal;"></div>');
		$this->Editor->setConfig('editRowTitle','Edit Transaction<div style="font-size: 12px; font-weight: normal;"></div>');
		$this->Editor->setConfig('addScreenFun',array(&$this,'autoCompleteCallback'));
		$this->Editor->setConfig('editScreenFun',array(&$this,'autoCompleteCallback'));
		$this->Editor->setConfig('editInPlaceFun',array(&$this,'autoCompleteInPlace'));
		$this->Editor->setConfig('addInPlaceFun',array(&$this,'autoCompleteInPlace'));
		$this->Editor->setConfig('instanceName',$this->mateInstances[0]);
		//$this->Editor->setConfig('editInPlace',true);
		$this->Editor->setConfig('storageType','web');
		//$this->Editor->setConfig('addInPlace',true);
		$this->Editor->setConfig('paginationLinks',true);
		//$this->Editor->setConfig('viewQuery',true);
		//$this->Editor->setConfig('escapeHtml',true);
	}
	
	function __construct()
	{
		session_start();
		ob_start();
		$this->initiateEditor();
		if(isset($_POST['json']))
		{
			if(ini_get('magic_quotes_gpc'))
			{
				$_POST['json'] = stripslashes($_POST['json']);
			}
			$this->Editor->data = $this->Editor->jsonDecode($_POST['json'],true);
			$this->Editor->setDefaults();
			$this->Editor->main();
		}
		else if(isset($_GET['mate_export']))
		{
			$this->Editor->data['sessionData'] = $_GET['session_data'];
			$this->Editor->setDefaults();
			ob_end_clean();
			header('Cache-Control: no-cache, must-revalidate');
			header('Pragma: no-cache');
			header('Content-type: application/x-msexcel');
			header('Content-Type: text/csv');
			header('Content-Disposition: attachment; filename="' . $this->Editor->tableName . '.csv"');
			// Add utf-8 signature for windows/excel
			echo chr(0xEF).chr(0xBB).chr(0xBF);
			echo $this->Editor->exportInfo();
			exit();
		}
        else if(isset($_GET['dept']))
        {
        	$this->getDeptSuggestions();
        }
		else
		{
			$this->displayHeaderHtml();
			$this->displayHtml();
			$this->displayFooterHtml();
		}
	}
}
$page = new Transactions();
?>
