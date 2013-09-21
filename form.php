<?php
require_once "common.php";

if (isset($_GET['n']))
	$name = Web::filter($_GET['n']);
else
	$name = NAME_RESPONDER;

$dateFieldType = ($browser['mobile']) ? "date" : "text";	// Was $browser['iOS']
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
<!-- jQuery Center Plugin -->
<script src="<?php echo DIR_JS; ?>/jquery.center.min.js" type="text/javascript"></script>
<!-- jQuery UI -->
<link href="<?php echo DIR_JQUI; ?>/css/redmond/jquery-ui-<?=VER_JQUI?>.min.css" rel="stylesheet" type="text/css">
<script src="<?php echo DIR_JQUI; ?>/jquery-ui-<?=VER_JQUI?>.min.js" type="text/javascript"></script>
<!-- CSS Reset -->
<link href="<?php echo DIR_CSS; ?>/normalize.min.css" rel="stylesheet" type="text/css">
<!-- Custom styling -->
<link href="<?php echo DIR_CSS; ?>/styles.css" rel="stylesheet" type="text/css">
<link href="<?php echo DIR_CSS; ?>/form.css" rel="stylesheet" type="text/css">
<!-- Proprietary -->
<script src="<?php echo DIR_JS; ?>/scripts.js" type="text/javascript"></script>
<script type="text/javascript">
$(function() {
	//$('<div title="Test">Test</div>', top.document.getElementById("wrapper")).dialog(CA.globals.obj.modal);
	// If there are any selects on the page, uncomment this to make the default option gray.
	/*$("select").change(function () {
		if(//$(this).val() == "0" ||
		   $(this).val() == "") $(this).addClass("empty");
		else $(this).removeClass("empty")
	});
	$("select").change();*/
	
	// Add onShow to datepicker.
	$.datepicker._updateDatepicker_original = $.datepicker._updateDatepicker;
	$.datepicker._updateDatepicker = function(inst) {
		$.datepicker._updateDatepicker_original(inst);
		var onShow = this._get(inst, 'onShow');
		if (onShow)
			onShow.apply((inst.input ? inst.input[0] : null));  // trigger custom callback
	}
	
	function checkDateRange($start, $end, current) {
		// Parse the entries
		var start = $start.val(),
			end = $end.val(),
			startDate = Date.parse(start),
			endDate = Date.parse(end)
			bothNotEmpty = (($start.val() != "") && ($end.val() != "")),
			message = "",
			// Some trickery here with my String.prototype.format() function
			// that, without additional conditions, formats the sentence with
			// the right words for the case.
			words = {
				current: current,
				preposition: (current == "end") ? "after" : "before",
				other: (current == "end") ? "start" : "end",
			};
		// First, are two dates already present? Make sure they
		// are valid if so.
		if (bothNotEmpty) {
			// Check the date range, 86400000 is the number of milliseconds in one day
			var difference = (endDate - startDate) / (24 * 60 * 60 * 1000);
			if (isNaN(startDate)) {
				message = "The start date provided is not valid, please enter a valid date.";
			} else if (isNaN(endDate)) {
				message = "The end date provided is not valid, please enter a valid date.";
			} else if (difference < 0) {
				message = "The {current} date must come {preposition} the {other} date.".format(words);
			}/* else if (difference <= 1) {
				message = "The range must be at least seven days apart.";
			}*/
			if (message != "") {
				// For now, just use alert()... I made it look fine once. >:(
				alert(message);
				//$('<div id="#date_error" title="Date Selection Error">{0}</div>'.format(message), top.document).dialog(CA.globals.obj.dialog.modal);
				//$(".ui-dialog", top).center();
				return false;
			}
		}
		return true;
	}
	$("input[type=text][id^=duration_]").datepicker({
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
			var $this = $(this),
				$start = $("#duration_start"),
				$end = $("#duration_end"),
				start = $start.val(),
				end = $end.val(),
				bothEmpty = (($start.val() == "") && ($end.val() == "")),
				which = (
						  (/duration_/gi.test(inst.id)) ?
							inst.id.replace("duration_", "") :
							inst.id
						);
			Console.debug(inst);
			if (inst.inline) {
				// This isn't going to be true in thise case.
				// It's for when it's embedded in the page.
				this._updateDatepicker(inst);
			} else {
				//Console.debug(this);
				$this.datepicker("hide");//true, this._get(inst, 'duration'));
				this._lastInput = inst.input;
				if (!checkDateRange($start, $end, which)) {
					$this.val("");
					return false;
				}
				if (typeof(inst.input[0]) !== 'object')
					inst.input.focus(); // restore focus
				this._lastInput = null;	
			}
		},
		onShow: function(e) {
			var $dates = $(".ui-datepicker a"),
				$firstDate = $dates.filter(":first");
			// If the first date selection element found has an HREF
			// attribute, remove this attribute from all the date selection
			// elements.
			if (typeof $firstDate.attr("href") !== 'undefined')
				$dates.removeAttr("href").css({cursor: "pointer"});
		}
	});
});
</script>
</head>
<body<?=$browser['classString']?>>
	<div id="wrapper">
<?php
if (isset($_POST['name'])): ?>
Thanks for submitting responder data!
<script type="text/javascript">
$("iframe", top.document).height(15);
</script>
<?php
else:
?>
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
<?php
endif;
?>
        </div>
    </div>
</body>
</html>