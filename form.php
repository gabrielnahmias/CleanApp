<?php
require_once "common.php";

if (isset($_GET['n']))
	$name = Web::filter($_GET['n']);
else
	$name = NAME_RESPONDER;

$dateFieldType = ($browser["name"] == "chrome") ? "text" : "date";

?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<title><?=$name?></title>
<!-- Console.js -->
<script src="<?php echo DIR_CON; ?>/Console.min.js" type="text/javascript"></script>
<!-- date.js -->
<script src="<?php echo DIR_JS; ?>/date.js" type="text/javascript"></script>
<!-- jQuery -->
<script src="<?php echo DIR_JS; ?>/jquery-<?=VER_JQ?>.min.js" type="text/javascript"></script>
<!-- jQuery UI -->
<link href="<?php echo DIR_JQUI; ?>/css/redmond/jquery-ui-<?=VER_JQUI?>.min.css" rel="stylesheet" type="text/css">
<script src="<?php echo DIR_JQUI; ?>/jquery-ui-<?=VER_JQUI?>.min.js" type="text/javascript"></script>
<!-- CSS Reset -->
<link href="<?php echo DIR_CSS; ?>/normalize.min.css" rel="stylesheet" type="text/css">
<!-- Custom Styling -->
<link href="<?php echo DIR_CSS; ?>/styles.css" rel="stylesheet" type="text/css">
<link href="<?php echo DIR_CSS; ?>/form.css" rel="stylesheet" type="text/css">
<script type="text/javascript">
$(function() {
	// If there are any selects on the page, uncomment this to make the default option gray.
	/*$("select").change(function () {
		if(//$(this).val() == "0" ||
		   $(this).val() == "") $(this).addClass("empty");
		else $(this).removeClass("empty")
	});
	$("select").change();*/
		
	$("input[id^=duration_]").datepicker({
		yearRange: '1925:<?php echo date("Y"); ?>',
		changeMonth: true,
		changeYear: true,
		numberOfMonths: 1,
		showOtherMonths: true,
		selectOtherMonths: true,
		onChangeMonthYear: function(year, month, inst) {
			var $date = inst.input,
				sDate = (inst.selectedMonth + 1) + "/" + inst.selectedDay + "/" + inst.selectedYear;
			sDate = new Date(sDate).toString("MM/dd/yyyy");
			$date.val(sDate);
		},
		onSelect: function(sText, inst) {
			Console.debug(arguments);
			$(".ui-datepicker a").removeAttr("href");
			if (inst.inline) {
				this._updateDatepicker(inst);
			} else {
				Console.debug(this);
				this._hideDatepicker(true, this._get(inst, 'duration'));
				this._lastInput = inst.input;
				if (typeof(inst.input[0]) != 'object')
					inst.input.select(); // restore focus
				this._lastInput = null;	
			}
		}
	});
});
</script>
<style type="text/css">
body {
	margin: 10px; /* Pad for transitions */
}
</style>
</head>
<body<?=$browser['classString']?>>
    <div id="responder_form">
        <h2><?=$name?></h2>
        <form action="<?php print $_SERVER['PHP_SELF']; ?>" method="post">
            <input type="text" id="name" name="name" placeholder="Name" pattern=".{3,}" required>
            <input type="text" id="title" name="title" placeholder="Title" required>
            <textarea id="address" name="address" placeholder="Address" cols="20" required></textarea>
            <input type="email" id="email" name="email" placeholder="Email" required>
            <input type="tel" id="phone" name="phone" placeholder="Phone Number">
            <input class="inline" type="<?=$dateFieldType?>" id="duration_start" name="duration_start" placeholder="Start">
            <input class="inline" type="<?=$dateFieldType?>" id="duration_end" name="duration_end" placeholder="End">
            <!--<select>
                <option value="" selected>Select One...</option>
                <option>Test</option>
                <option>Test2</option>
                <option>Test3</option>
                <option>Test4</option>
            </select>-->
            <input type="reset" value="Reset"><input type="submit" value="Submit">
        </form>
    </div>
</body>
</html>