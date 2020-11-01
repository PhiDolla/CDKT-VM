<?php

function milliConversion($milliseconds){
        # $uSec = $milliseconds%1000;
        $milliseconds = floor($milliseconds/1000);

        $seconds = $milliseconds%60;
        $milliseconds = floor($milliseconds/60);

        $minutes = $milliseconds%60;
        $milliseconds = floor($milliseconds/60);
	
        if($seconds == 1 || $seconds == 2 || $seconds == 3 || $seconds == 4 || $seconds == 5 || $seconds == 6 || $seconds == 7 || $seconds == 8 || $seconds == 9 || $seconds == 0){
                return "$minutes:0$seconds";
        }
        else{
                return "$minutes:$seconds";
	}
}

function convertKey($key){
	if($key == 0){
                return "Minor";
        }
        elseif($key == 1){
                return "Major";
        }	
}

function convertMode($mode){
	if($mode == 0){
		return "C";
	}	
	elseif($mode == 1){
		return "C#";
	}
	elseif($mode == 2){
                return "D";
	}
	elseif($mode == 3){
                return "D#";
	}
	elseif($mode == 4){
                return "E";
	}
	elseif($mode == 5){
                return "F";
	}
	elseif($mode == 6){
                return "F#";
	}
	elseif($mode == 7){
                return "G";
	}
	elseif($mode == 8){
                return "G#";
	}
	elseif($mode == 9){
                return "A";
	}
	elseif($mode == 10){
                return "A#";
	}
	elseif($mode == 11){
                return "B";
        }
}

?>
