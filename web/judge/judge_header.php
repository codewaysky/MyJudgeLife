<?php
	/** MyJudgeLife
		м╥нд╪Ч
		
		ORZ WJMZBMR
		
		ORZ plantvsbird
		ORZ lin_toto		
	*/
	
	require_once("judge_config.php");
	
	if (IN_MYOILIFE) {
		require_once($_SERVER['DOCUMENT_ROOT']."/include/header_nogui.php");
	} else {
		mysql_connect(db_host,db_user,db_pass);
		mysql_select_db(db_name);
	}
	
	//require_once("judge_func.php");
	
?>