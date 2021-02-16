if (!function_exists('pop_message')) {
	function pop_message($msg, $type="success", $redirectTo=false) {
		$color = (strtolower($type) == 'success') ? "green" : "red";
		$type  = (strtolower($type) == 'success') ? "success!" : $type."!";
		$jsRedirect = ($redirectTo) ? 'window.location.href="'.$redirectTo.'"' : ''; 
		$bodyColor  = ($redirectTo) ? '#060606f2' : '';  // do not reset(blank color) if redirected to a url
		$html = '
			<div class="pop_message_container">
                <script>
                    var redirectTo = "'.$redirectTo.'";
                    function pop_message(show) {
                        var show  = (show != "undefined") ? show : true;
                        if (!show) {
                            if (!redirectTo) {
                                document.querySelector(".pop_message_container").remove();
                            } else {
                                document.querySelector("#pop_msg_p").innerHTML = "Please wait...";
                                document.body.style.backgroundColor =  "'.$bodyColor.'";
                                '.$jsRedirect.';
                            }
                        }
                        // code to prevent resubmission of form
                        if ( window.history.replaceState ) {
                            window.history.replaceState( null, null, window.location.href );
                        }
                    }
                    document.body.style.backgroundColor =  "'.$bodyColor.'";
                </script>
                <div style="width: 100%;height: 100vh;background: #06060633;position: fixed;top: 0;left: 0;z-index: 999999;">
                    <div style="top:30%;width-100%;max-width: 390px;height: 200px;position: relative;z-index: 999999999;margin: 0 auto;border: 1px solid #ccc;box-shadow: 7px 7px 10px #00000073;background: #fff;">
                    <br>
                    <p style="color:'.$color.';text-align:center;font-size:24px;">'.strtoupper($type).'</p>
                    <hr style="margin:0;padding:0;">
                    <p style="font-size: 18px;margin:10px;text-align: center;" id="pop_msg_p">'.$msg.'</p>
                    <div style="position: absolute;bottom: 0;width: 100%;padding: 10px;text-align: center;">
                        <button onclick="pop_message(false)" style="background: #2084ff;color: #fff;font-size: 20px;border:1px solid #5bc0de;border-radius: 5px;box-shadow: 10px 10px 10px #ccc;margin: 0px 15px;width:60px;" onclick="">OK</button>
                    </div>
                </div>
			</div>
        </div>
			';
		echo $html;
		// sleep(1.75);
		if ($redirectTo != '') {
			die;
		}   
	}
}

function splitFullName($fullName) {
   $name = array('fname' => '', 'mname'=> '', 'lname'=> '');
   $nameArr = explode(" ", $fullName);
   if (isset($nameArr[0])) {
         $name['fname'] = $nameArr[0];
   }
   if (isset($nameArr[1])) {
         $name['mname'] = $nameArr[1];
   }
   if (isset($nameArr[2])) {
         unset($nameArr[0]);
         unset($nameArr[1]);
         $name['lname'] = implode(" ", $nameArr);
   }
   return $name;
}

function splitDoB($DoB) {
   $dob = array('day' => '', 'month'=> '', 'year'=> '');
   if (intval($DoB) == 0 || $DoB == '') {
         return $dob;
   }
   $dobArr = explode("-", $DoB);
   if (isset($dobArr[0])) {
         $dob['year'] = $dobArr[0];
   }
   if (isset($dobArr[1])) {
         $dob['month'] = $dobArr[1];
   }
   if (isset($dobArr[2])) {
         $dob['day'] = $dobArr[2];
   }
   return $dob;
}

function calculateAge($DoB) {
   $age = array('day' => '', 'month'=> '', 'year'=> '');
   if (intval($DoB) == 0 || $DoB == '') {
         return $age;
   }
   $dob = new DateTime($DoB);
   $today = new DateTime(date('Y-m-d'));
   $diff = $today->diff($dob);
   $age['year'] = $diff->y;
   $age['month'] = $diff->m;
   $age['day'] = $diff->d;
   return $age;
}

// Create DD MM YYYY select dropdown
function getDateSelect($yearStart, $yearEnd, $selectName) {
   $output = ''; 
   $output .= '<select class="form-control date_dd" style="width:70px;margin-right:2px;display:inline;" name="'.$selectName.'_d" id="'.$selectName.'_d">';
   $output .=   '<option value="">DD</option>';
      for ($d = 1; $d <=31; $d++) {
         $d = str_pad($d,2,'0',STR_PAD_LEFT);
         $output .= '<option value="'.$d.'">'.$d.'</option>';
      }
   $output .='</select>';
   $output .='<select class="form-control date_mm" style="width:70px;margin-right:2px;display:inline;" name="'.$selectName.'_m" id="'.$selectName.'_m">';
   $output .=   '<option value="">MM</option>';
      for ($m = 1; $m <=12; $m++) {
         $m = str_pad($m,2,'0',STR_PAD_LEFT);
         $output .= '<option value="'.$m.'">'.$m.'</option>';
      }
   $output .='</select>';
   $output .='<select class="form-control date_yyyy" style="width:80px;display:inline;" name="'.$selectName.'_y" id="'.$selectName.'_y">';
   $output .=   '<option value="">YYYY</option>';
      for ($y = $yearStart; $y < $yearEnd; $y++) {
      $output .= '<option value="'.$y.'">'.$y.'</option>';
      }
   $output .='</select>';
   return $output;
} 
