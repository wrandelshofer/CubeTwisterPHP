<?php 
  
  /* 
  ***************************************************************************************************
  * tw-functions.php
  * 
  * Twister-Funktionen
  * 
  * Autor: Walter Randelshofer
  * Version: 0.5.1
  * Letztes Update: 23.03.2022 wr
  ***************************************************************************************************
  */
  
  
  /* --- Subroutines --- */
  
  /* 
  ---------------------------------------------------------------------------------------------------
  * getPar($parID)
  * 
  * Gets form parameter values.
  * Parameter: $parID (STRING): The form parameter name.
  * 
  * Return: Value of form parameter.
  * 
  * EXAMPLE:
  * --------
  * $input = stripslashes(getPar("input"));
  * 
  * RESULT:
  * -------
  * Value of the form parameter 'input'. For example: test
  ---------------------------------------------------------------------------------------------------
  */
  function getPar($parID) {
    $pPost = $_POST[$parID];
    $pGet  = $_GET[$parID];
    if ($pPost == "") {$p = $pGet;} else {$p = $pPost;}
    
    return $p;
  }
  
  
  
  
  /* 
  ---------------------------------------------------------------------------------------------------
  * cleanString($str)
  * 
  * Removes whitespace characters at the beginning and at the end of the string.
  * Removes superfluos whitespace withing the string
  * Works with multiline strings (m modifier is used!).
  * 
  * Parameter: $str (STRING): The text.
  * 
  * Return: STRING.
  ---------------------------------------------------------------------------------------------------
  */
  function cleanString($str) {
    $str = preg_replace("'^\s+'",'',$str); // Leerzeichen am Anfang des Strings entfernen
    $str = preg_replace("'\s+$'",'',$str); // Leerzeichen am Schluss des Strings entfernen
    $str = preg_replace("'  *'",' ',$str); // Überflüssige Leerzeichen entfernen
    
    return $str;
  }
  
  
  
  
  
  /* 
  ---------------------------------------------------------------------------------------------------
  * removeWhitespace($string)
  * 
  * Removes whitespace characters at the beginning and at the end of the string.
  * Works only within a single line (m modifier is not used!).
  * 
  * Parameter: $string (STRING): The text.
  * 
  * Return: STRING.
  ---------------------------------------------------------------------------------------------------
  */
  function removeWhitespace($string) {
    $string = preg_replace('/^\s+/', '', $string); // Leerzeichen am Anfang des Strings entfernen.
    $string = preg_replace('/\s+$/', '', $string); // Leerzeichen am Schluss des Strings entfernen.
    
    return $string;
  }
  
  
  
  
  /* 
  ---------------------------------------------------------------------------------------------------
  * titleUriEncode($str)
  * 
  * Encodes strings with URI characters.
  * 
  * Parameter: $str (STRING): The text.
  * 
  * Return: STRING.
  ---------------------------------------------------------------------------------------------------
  */
  function titleUriEncode($str) {
    $entities     = array('%21', '%2A', '%27', '%28', '%29', '%3B', '%3A', '%40', '%26', '%3D', '%2B', '%24', '%2C', '%2F', '%3F', '%25', '%23', '%5B', '%5D');
    $replacements = array('!',   '*',   "'",   "(",   ")",   ";",   ":",   "@",   "&",   "=",   "+",   "$",   ",",   "/",   "?",   "%",   "#",   "[",   "]");
    
    
    /* --- Remove and replace some of the characters --- */
    $str = str_replace(',','',$str);       // Komma [,] entfernen
    $str = str_replace('.','',$str);       // Punkt [.] entfernen
    $str = str_replace(':','',$str);       // Doppelpunkt [:] entfernen
    $str = str_replace(';','',$str);       // Strichpunkt [;] entfernen
    
    $str = str_replace('/',' ',$str);      // Slash [/] durch Leerzeichen [ ] ersetzen
    
    $str = preg_replace("'  *'",' ',$str); // Überflüssige Leerzeichen entfernen
    $str = str_replace(' ','_',$str);      // Leerzeichen durch Underline [_] ersetzen
    
    
    /* --- Encode the modified string --- */
    $str = str_replace($entities, $replacements, urlencode($str));;
    
    return $str;
  }
  
  
  
  
  
  /* 
  ---------------------------------------------------------------------------------------------------
  * removeAccent($string)
  * 
  * Removes accents and replaces them with ASCII equivalents.
  * 
  * Parameter: $string (STRING): The text.
  * 
  * Return: STRING.
  ---------------------------------------------------------------------------------------------------
  */
  function removeAccent($string) { 
    $a = array('À', 'Á', 'Â', 'Ã', 'Ä',  'Å', 'Æ',  'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ð', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö',  'Ø', 'Ù', 'Ú', 'Û', 'Ü',  'Ý', 'ß',  'à', 'á', 'â', 'ã', 'ä',  'å', 'æ',  'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö',  'ø', 'ù', 'ú', 'û', 'ü',  'ý', 'ÿ', 'Ā', 'ā', 'Ă', 'ă', 'Ą', 'ą', 'Ć', 'ć', 'Ĉ', 'ĉ', 'Ċ', 'ċ', 'Č', 'č', 'Ď', 'ď', 'Đ', 'đ', 'Ē', 'ē', 'Ĕ', 'ĕ', 'Ė', 'ė', 'Ę', 'ę', 'Ě', 'ě', 'Ĝ', 'ĝ', 'Ğ', 'ğ', 'Ġ', 'ġ', 'Ģ', 'ģ', 'Ĥ', 'ĥ', 'Ħ', 'ħ', 'Ĩ', 'ĩ', 'Ī', 'ī', 'Ĭ', 'ĭ', 'Į', 'į', 'İ', 'ı', 'Ĳ',  'ĳ',  'Ĵ', 'ĵ', 'Ķ', 'ķ', 'Ĺ', 'ĺ', 'Ļ', 'ļ', 'Ľ', 'ľ', 'Ŀ', 'ŀ', 'Ł', 'ł', 'Ń', 'ń', 'Ņ', 'ņ', 'Ň', 'ň', 'ŉ', 'Ō', 'ō', 'Ŏ', 'ŏ', 'Ő', 'ő', 'Œ',  'œ',  'Ŕ', 'ŕ', 'Ŗ', 'ŗ', 'Ř', 'ř', 'Ś', 'ś', 'Ŝ', 'ŝ', 'Ş', 'ş', 'Š', 'š', 'Ţ', 'ţ', 'Ť', 'ť', 'Ŧ', 'ŧ', 'Ũ', 'ũ', 'Ū', 'ū', 'Ŭ', 'ŭ', 'Ů', 'ů', 'Ű', 'ű', 'Ų', 'ų', 'Ŵ', 'ŵ', 'Ŷ', 'ŷ', 'Ÿ', 'Ź', 'ź', 'Ż', 'ż', 'Ž', 'ž', 'ſ', 'ƒ', 'Ơ', 'ơ', 'Ư', 'ư', 'Ǎ', 'ǎ', 'Ǐ', 'ǐ', 'Ǒ', 'ǒ', 'Ǔ', 'ǔ', 'Ǖ', 'ǖ', 'Ǘ', 'ǘ', 'Ǚ', 'ǚ', 'Ǜ', 'ǜ', 'Ǻ', 'ǻ', 'Ǽ',  'ǽ',  'Ǿ', 'ǿ');
    $b = array('A', 'A', 'A', 'A', 'Ae', 'A', 'AE', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'D', 'N', 'O', 'O', 'O', 'O', 'Oe', 'O', 'U', 'U', 'U', 'Ue', 'Y', 'ss', 'a', 'a', 'a', 'a', 'ae', 'a', 'ae', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'oe', 'o', 'u', 'u', 'u', 'ue', 'y', 'y', 'A', 'a', 'A', 'a', 'A', 'a', 'C', 'c', 'C', 'c', 'C', 'c', 'C', 'c', 'D', 'd', 'D', 'd', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'E', 'e', 'G', 'g', 'G', 'g', 'G', 'g', 'G', 'g', 'H', 'h', 'H', 'h', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'I', 'i', 'IJ', 'ij', 'J', 'j', 'K', 'k', 'L', 'l', 'L', 'l', 'L', 'l', 'L', 'l', 'l', 'l', 'N', 'n', 'N', 'n', 'N', 'n', 'n', 'O', 'o', 'O', 'o', 'O', 'o', 'OE', 'oe', 'R', 'r', 'R', 'r', 'R', 'r', 'S', 's', 'S', 's', 'S', 's', 'S', 's', 'T', 't', 'T', 't', 'T', 't', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'W', 'w', 'Y', 'y', 'Y', 'Z', 'z', 'Z', 'z', 'Z', 'z', 's', 'f', 'O', 'o', 'U', 'u', 'A', 'a', 'I', 'i', 'O', 'o', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'U', 'u', 'A', 'a', 'AE', 'ae', 'O', 'o');
    
    return str_replace($a, $b, $string);
  }
  
  
  
  
  
  /* 
  ---------------------------------------------------------------------------------------------------
  * postSlugTitle($string)
  * 
  * Post slug generator, for cretating clean URLs from titles. It works with many languages.
  * Removes accents and replaces them with ASCII equivalents.
  * Only accepts letters (a-z, A-Z), numbers (0-9) and the - character.
  * Converts upper case letters into lower case letters.
  * 
  * Requires: Function removeAccent().
  * 
  * Parameter: $string (STRING): The text.
  * 
  * Example: postSlugTitle(' -Lo#&@rem  IPSUM //dolor-/sit - amet-/-consectetur! 12 -- ') 
  * will output: lorem-ipsum-dolor-sit-amet-consectetur-12
  * 
  * Return: STRING.
  ---------------------------------------------------------------------------------------------------
  */
  function postSlugTitle($string) { 
    return strtolower(preg_replace(array('/[^a-zA-Z0-9 -]/', '/[ -]+/', '/^-|-$/'), array('', '-', ''), removeAccent($string)));
  }
  
  
  
  
  
  /* 
  ---------------------------------------------------------------------------------------------------
  * postSlugFilename($string)
  * 
  * Post slug generator, for cretating clean URLs from titles. It works with many languages.
  * Removes accents and replaces them with ASCII equivalents.
  * Only accepts letters (a-z, A-Z), numbers (0-9) and the - and _ characters.
  * Removes the _ character at the beginnin of the string.
  * 
  * Requires: Function removeAccent().
  * 
  * Parameter: $string (STRING): The text.
  * 
  * Example: postSlug(' -Lo#&@rem  IPSUM //dolor-/sit - amet-/-consectetur! 12 -- ') 
  * will output: Lorem-IPSUM-dolor-sit-amet-consectetur-12
  * 
  * Return: STRING.
  ---------------------------------------------------------------------------------------------------
  */
  function postSlugFilename($string) { 
    $string = preg_replace('/\./', '-', $string); // Replace . (point) with - (dash) character.
    $string = preg_replace(array('/[^a-zA-Z0-9 \_-]/', '/[ -]+/', '/^-|-$/'), array('', '-', ''), removeAccent($string));
    $string = preg_replace('/^_*/', '', $string); // Remove any _ (underscore) characters at the begining of the string. 
    
    return $string;
  }
  
  
  
  
  
  /* 
  ---------------------------------------------------------------------------------------------------
  * floatFormat($aNumber, $precision)
  * 
  * Converts integer or float numbers into formated numbers.
  * Formats only numbers with a maximum of 9 digits before the comma!
  * Formats only numbers with a maximum of 5 digits after the comma!
  * It also allows to define the amount of digits after the comma.
  * 
  * Parameter: $aNumber (INTEGER or FLOAT): 123456789 or 123456789.12345.
  * Parameter: $precision (INTEGER): 
  * 
  * Return: STRING.
  ---------------------------------------------------------------------------------------------------
  */
  function floatFormat($aNumber, $precision) {
    $leftPart      = ""; // Number part before the comma (input).
    $rightPart     = ""; // Number part after the comma (input).
    $i             = 0;
    $digit         = ""; // Digit of the number.
    $formLeftPart  = ""; // Number part before the comma (formated).
    $formRightPart = ""; // Number part after the comma (formated).
    $formNumber    = ""; // Formated number.
    
    
    /* --- Variables --- */
    $delimiter = "'"; // Delimiter for groups of 3 digits before and after the comma.
    
    
    /* --- Function Beginn --- */
    list($leftPart, $rightPart) = explode(".", $aNumber);
    
    
    /* --- Format number left of the comma --- */
    $leftPart = intval($leftPart);
    if ($leftPart == 0) {$leftPart = "0";}
    
    $formLeftPart = "";
    for ($i = 0; $i < strlen($leftPart); $i++) {
      if  ($i != 0 && (strlen($leftPart)-$i) % 3 == 0) {
        $formLeftPart = $formLeftPart . $delimiter;
      }
      $digit = substr($leftPart, $i, 1);
      $formLeftPart = $formLeftPart . $digit;
    }
    
    
    /* --- Format number right of the comma --- */
    if ($rightPart == 0 || $rightPart == "") {$rightPart = "0";}
    
    if (strlen($rightPart) < $precision) {
      for ($i = strlen($rightPart); $i < $precision; $i++) {
        $rightPart = $rightPart ."0";
      }
    } else {
      $rightPart = substr($rightPart, 0, $precision);
    }
    
    $formRightPart = "";
    for ($i = 0; $i < strlen($rightPart); $i++) {
      if  ($i != 0 && $i % 3 == 0) {
        $formRightPart = $formRightPart . $delimiter;
      }
      $digit = substr($rightPart, $i, 1);
      $formRightPart = $formRightPart . $digit;
    }
    
    
    /* --- Build formatted number --- */
    $i = strlen($rightPart);
    if ($precision == 0 || $precision == "") {
      $formNumber = $formLeftPart;
    } else {
      $formNumber = $formLeftPart .".". $formRightPart;
    }
    
    return $formNumber;
  }
  
  
  
  
  
  /* 
  ---------------------------------------------------------------------------------------------------
  * dec2Base($numberDecimal, $base)
  * 
  * - Converts only positive decimal integer with a maximum of 9 digits into a choosen base number.
  * - Destination base range from 2 to 62.
  * - To convert into hexadecimal use base 16, into octal use base 8, into dual use base 2 ...
  * 
  * Parameter: $numberDecimal (STRING): 123456789.
  * Parameter: $base (INTEGER): 16 (Destination base).
  * 
  * Return: STRING.
  * 
  * EXAMPLE:
  * --------
  * $year_base = dec2Base('2000', 62);
  * 
  * RESULT:
  * -------
  * WG
  ---------------------------------------------------------------------------------------------------
  */
  function dec2Base($numberDecimal, $base) {
    $digit      = "";
    $remain     = $numberDecimal;
    $numberBase = "";
    
    if ($remain == 0) {
      $numberBase = "0";
    } else {
      while ($remain > 0) {
        $digit = $remain % $base;
        $numberBase = substr("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz", $digit, 1) . $numberBase;
        $remain = intval($remain / $base);
      }
    }
    
    return $numberBase;
  }
  
  
  
  
  
  /* 
  ---------------------------------------------------------------------------------------------------
  * base2Dec($numberBase, $base)
  * 
  * - Converts only positve integer from a base origin into a decimal numbers with a maximum of 9 digits.
  * - Origin base range from 2 to 62.
  * - To convert from hexadecimal use base 16, from octal use base 8, from dual use base 2 ...
  * 
  * Parameter: $numberBase (STRING): 75BCD.
  * Parameter: $base (INTEGER): 16 (Origin base).
  * 
  * Return: INTEGER.
  * 
  * EXAMPLE:
  * --------
  * $year_dec = base2Dec('WG', 62);
  * 
  * RESULT:
  * -------
  * 2000
  ---------------------------------------------------------------------------------------------------
  */
  function base2Dec($numberBase, $base) {
    $digit         = "";
    $i             = 0;
    $numberDecimal = 0;
    
    for ($i = 0; $i < strlen($numberBase); $i++) {
      $digit = strrpos("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz", substr($numberBase, $i, 1));
      $numberDecimal = $numberDecimal * $base + $digit;
    }
    
    return $numberDecimal;
  }
  
  
  
  
  
  /* 
  ---------------------------------------------------------------------------------------------------
  * bytesFormat($bytes, $precision)
  * 
  * - Converts bytes into a human readable file size expression.
  * 
  * Requires: Function wcaFloatFormat().
  * 
  * Parameter: $bytes (STRING): 1024.
  * Parameter: $precision (INTEGER): 2.
  * 
  * Return: STRING.
  * 
  * EXAMPLE:
  * --------
  * $txt_bytes = bytesFormat(123456789, 2);
  * 
  * RESULT:
  * -------
  * 117.73 MB
  ---------------------------------------------------------------------------------------------------
  */
  function bytesFormat($bytes, $precision) {
    $bytes     = floatval($bytes);
    $value     = 0;
    $formValue = "";
    $formBytes = "";
    
    $arBytes = array(
      0 => array("UNIT" => "TB",    "VALUE" => pow(1024, 4)), // Terabyte
      1 => array("UNIT" => "GB",    "VALUE" => pow(1024, 3)), // Gigabyte
      2 => array("UNIT" => "MB",    "VALUE" => pow(1024, 2)), // Megabyte
      3 => array("UNIT" => "KB",    "VALUE" => 1024),         // Kilobyte
      4 => array("UNIT" => "Bytes", "VALUE" => 1)             // Byte
    );
    
    foreach ($arBytes as $arItem) {
      if ($bytes >= $arItem["VALUE"]) { // On values >= 1.
        $value = $bytes / $arItem["VALUE"];
        if ($bytes < 1024) {
          $formValue = wcaFloatFormat(intval($bytes), $precision);
        } else {
          $formValue = wcaFloatFormat($value, $precision);
        }
        $formBytes = $formValue ." ". $arItem["UNIT"];
        break;
      } else { // On values < 1.
        $formValue = intval($bytes);
        $formBytes = $formValue ." ". $arItem["UNIT"];
      }
    }
    
    return $formBytes;
  }
  
  
  
  
  
  /* 
  ---------------------------------------------------------------------------------------------------
  * minFormat($minutes, $mode)
  * 
  * - Converts minutes into a formated hours and minute expression.
  * - Converts only positive integer.
  * - Range from 0 to 1339.
  * 
  * Parameter: $minutes (INTEGER): 75.
  * Parameter: $hMode (STRING): Values: HH = 01(:00); H = 1(:00).
  * Parameter: $mMode (STRING): Values: MM = (01:)00; m = (01)"".
  * 
  * Return: STRING.
  * 
  * EXAMPLE:
  * --------
  * $txt_hour_min = minFormat(75);
  * 
  * RESULT:
  * -------
  * 1:15
  ---------------------------------------------------------------------------------------------------
  */
  function minFormat($minutes, $hMode, $mMode) {
    $stdPart     = 0;  // Full hours.
    $minPart     = 0;  // Remaining minutes.
    $txt_stdPart = ""; // Full hours (formated text).
    $txt_minPart = ""; // Remaining minutes (formated text).
    $formMinutes = ""; // Formated minutes.
    
    
    /* --- Function Beginn --- */
    $minutes = floor(intval($minutes)); // The floor() function rounds a number DOWN to the nearest integer, if necessary. For example: 42.4 = 42.
    
    if ($minutes >= 1) {
      $stdPart = floor($minutes / 60); // Get full hours.
      $minPart = $minutes % 60;        // Get remaining minutes.
    } else {
      $stdPart = 0;
      $minPart = 0;
    }
    
    
    /* --- Formating modes --- */
    if ($hMode == "H") { // Mode H  =  1.
      $txt_stdPart = $stdPart;                                                           // Hours: No leading zero.
    } else {             // Mode HH = 01.
      if ($stdPart < 10) {$txt_stdPart = "0". $stdPart;} else {$txt_stdPart = $stdPart;} // Hours: Leading zero on values below 10 (Default).
    }
    
    if ($minPart < 10) {$txt_minPart = "0". $minPart;} else {$txt_minPart = $minPart;}   // Minutes: Leading zero on values below 10.
    
    
    /* --- Build formatted number --- */
    if ($minPart < 1) {
      if ($mMode == "m") {
        $formMinutes = $txt_stdPart;
      } else {
        $formMinutes = $txt_stdPart .":". $txt_minPart;
      }
    } else {
      $formMinutes = $txt_stdPart .":". $txt_minPart;
    }
    
    return $formMinutes;
  }
  
  
  
  
  
  /* 
  ---------------------------------------------------------------------------------------------------
  * changeByteOrder($num)
  * 
  * Source: http://shiplu.mokadd.im/95/convert-little-endian-to-big-endian-in-php-or-vice-versa
  * 
  * - Converts Little-Endian to Big-Endian or vice versa (changes the byte-order).
  *   PHP doesn't provide any function for this, even though it has functions for almost everything.
  * - If your machines byte-order is Little-Endian, it will change it to Big-Endian.
  * - If your machines byte-order is Big-Endian, it will change the number to Little-Endian.
  * 
  * Parameter: $num (DATA).
  * 
  * Return: DATA.
  * 
  * EXAMPLE:
  * --------
  * php > echo var_dump(5254071951610216, changeByteOrder(5254071951610216448));
  * int(5254071951610216)
  * int(20120214104648)
  * 
  * php > echo var_dump(2147483648, changeByteOrder(2147483648));
  * int(2147483648)
  * int(128)
  ---------------------------------------------------------------------------------------------------
  */
  function wcaChangeByteOrder($num) {
    $data = "";
    $u    = "";
    $f    = "";
    
    $data = dechex($num); // Decimal to hexadecimal conversion of the data.
    
    if (strlen($data) <= 2) {
      return $num;
    }
    
    $u = unpack("H*", strrev(pack("H*", $data))); // Unpack and revert the hex value.
    $f = hexdec($u[1]); // Hexadecimal to decimal conversion of the data.
    
    return $f;
  }
  
  
  
  
  /* 
  ---------------------------------------------------------------------------------------------------
  * alg2xC_SseToTwizzle($alg)
  * 
  * Converts 2x2 Pocket Cube SSE algorithms into TWIZZLE notation.
  * 
  * Parameter: $alg (STRING): The algorithm.
  * 
  * Return: STRING.
  ---------------------------------------------------------------------------------------------------
  */
  function alg2xC_SseToTwizzle($alg) {
    /* --- 2xC: Preferences --- */
    $useSiGN    = false; // Notation style: SiGN or TWIZZLE (Default).
    $useMarkers = false; // 01.04.2021: Unfortunately Twizzle Explorer doesn't handle Markers correctly!
    
    /* --- 2xC: Marker --- */
    if ($useMarkers != true) {
      $alg = str_replace("·","",$alg); $alg = str_replace(".","",$alg); // Remove Markers!
    } else {
      $alg = str_replace("·",".",$alg);
    }
    
    /* ··································································································· */
    /* --- 2xC: SSE -> CODE: [7] Cube rotations --- */
    $alg = preg_replace("/CR'/","<701>",$alg); $alg = preg_replace("/CR-/","<701>",$alg);   $alg = preg_replace("/CR2/","<702>",$alg);   $alg = preg_replace("/CR/","<703>",$alg);
    $alg = preg_replace("/CL'/","<704>",$alg); $alg = preg_replace("/CL-/","<704>",$alg);   $alg = preg_replace("/CL2/","<705>",$alg);   $alg = preg_replace("/CL/","<706>",$alg);
    $alg = preg_replace("/CF'/","<707>",$alg); $alg = preg_replace("/CF-/","<707>",$alg);   $alg = preg_replace("/CF2/","<708>",$alg);   $alg = preg_replace("/CF/","<709>",$alg);
    $alg = preg_replace("/CB'/","<710>",$alg); $alg = preg_replace("/CB-/","<710>",$alg);   $alg = preg_replace("/CB2/","<711>",$alg);   $alg = preg_replace("/CB/","<712>",$alg);
    $alg = preg_replace("/CU'/","<713>",$alg); $alg = preg_replace("/CU-/","<713>",$alg);   $alg = preg_replace("/CU2/","<714>",$alg);   $alg = preg_replace("/CU/","<715>",$alg);
    $alg = preg_replace("/CD'/","<716>",$alg); $alg = preg_replace("/CD-/","<716>",$alg);   $alg = preg_replace("/CD2/","<717>",$alg);   $alg = preg_replace("/CD/","<718>",$alg);
    
    /* --- 2xC: SSE -> CODE: [9] Face twists --- */
    $alg = preg_replace("/R'/","<901>",$alg); $alg = preg_replace("/R-/","<901>",$alg);   $alg = preg_replace("/R2/","<902>",$alg);   $alg = preg_replace("/R/","<903>",$alg);
    $alg = preg_replace("/L'/","<904>",$alg); $alg = preg_replace("/L-/","<904>",$alg);   $alg = preg_replace("/L2/","<905>",$alg);   $alg = preg_replace("/L/","<906>",$alg);
    $alg = preg_replace("/F'/","<907>",$alg); $alg = preg_replace("/F-/","<907>",$alg);   $alg = preg_replace("/F2/","<908>",$alg);   $alg = preg_replace("/F/","<909>",$alg);
    $alg = preg_replace("/B'/","<910>",$alg); $alg = preg_replace("/B-/","<910>",$alg);   $alg = preg_replace("/B2/","<911>",$alg);   $alg = preg_replace("/B/","<912>",$alg);
    $alg = preg_replace("/U'/","<913>",$alg); $alg = preg_replace("/U-/","<913>",$alg);   $alg = preg_replace("/U2/","<914>",$alg);   $alg = preg_replace("/U/","<915>",$alg);
    $alg = preg_replace("/D'/","<916>",$alg); $alg = preg_replace("/D-/","<916>",$alg);   $alg = preg_replace("/D2/","<917>",$alg);   $alg = preg_replace("/D/","<918>",$alg);
    
    /* ··································································································· */
    /* --- 2xC: CODE -> TWIZZLE: [7] Cube rotations --- */
    if ($useSiGN == true) { // Bei SiGN:
      $alg = preg_replace("/<701>/","x'",$alg);   $alg = preg_replace("/<702>/","x2",$alg);   $alg = preg_replace("/<703>/","x",$alg);
      $alg = preg_replace("/<704>/","x",$alg);    $alg = preg_replace("/<705>/","x2",$alg);   $alg = preg_replace("/<706>/","x'",$alg);
      $alg = preg_replace("/<707>/","z'",$alg);   $alg = preg_replace("/<708>/","z2",$alg);   $alg = preg_replace("/<709>/","z",$alg);
      $alg = preg_replace("/<710>/","z",$alg);    $alg = preg_replace("/<711>/","z2",$alg);   $alg = preg_replace("/<712>/","z'",$alg);
      $alg = preg_replace("/<713>/","y'",$alg);   $alg = preg_replace("/<714>/","y2",$alg);   $alg = preg_replace("/<715>/","y",$alg);
      $alg = preg_replace("/<716>/","y",$alg);    $alg = preg_replace("/<717>/","y2",$alg);   $alg = preg_replace("/<718>/","y'",$alg);
    } else {               // Sonst (TWIZZLE):
      $alg = preg_replace("/<701>/","Rv'",$alg);   $alg = preg_replace("/<702>/","Rv2",$alg);   $alg = preg_replace("/<703>/","Rv",$alg);
      $alg = preg_replace("/<704>/","Rv",$alg);    $alg = preg_replace("/<705>/","Rv2",$alg);   $alg = preg_replace("/<706>/","Rv'",$alg);
      $alg = preg_replace("/<707>/","Fv'",$alg);   $alg = preg_replace("/<708>/","Fv2",$alg);   $alg = preg_replace("/<709>/","Fv",$alg);
      $alg = preg_replace("/<710>/","Fv",$alg);    $alg = preg_replace("/<711>/","Fv2",$alg);   $alg = preg_replace("/<712>/","Fv'",$alg);
      $alg = preg_replace("/<713>/","Uv'",$alg);   $alg = preg_replace("/<714>/","Uv2",$alg);   $alg = preg_replace("/<715>/","Uv",$alg);
      $alg = preg_replace("/<716>/","Uv",$alg);    $alg = preg_replace("/<717>/","Uv2",$alg);   $alg = preg_replace("/<718>/","Uv'",$alg);
    }
    
    /* --- 2xC: CODE -> TWIZZLE: [9] Face twists --- */
    $alg = preg_replace("/<901>/","R'",$alg);   $alg = preg_replace("/<902>/","R2",$alg);   $alg = preg_replace("/<903>/","R",$alg);
    $alg = preg_replace("/<904>/","L'",$alg);   $alg = preg_replace("/<905>/","L2",$alg);   $alg = preg_replace("/<906>/","L",$alg);
    $alg = preg_replace("/<907>/","F'",$alg);   $alg = preg_replace("/<908>/","F2",$alg);   $alg = preg_replace("/<909>/","F",$alg);
    $alg = preg_replace("/<910>/","B'",$alg);   $alg = preg_replace("/<911>/","B2",$alg);   $alg = preg_replace("/<912>/","B",$alg);
    $alg = preg_replace("/<913>/","U'",$alg);   $alg = preg_replace("/<914>/","U2",$alg);   $alg = preg_replace("/<915>/","U",$alg);
    $alg = preg_replace("/<916>/","D'",$alg);   $alg = preg_replace("/<917>/","D2",$alg);   $alg = preg_replace("/<918>/","D",$alg);
    
    return $alg;
  }
  
  
  
  
  /* 
  ---------------------------------------------------------------------------------------------------
  * alg2xC_TwizzleToSse($alg)
  * 
  * Converts 2x2 Pocket Cube TWIZZLE algorithms into SSE notation.
  * 
  * Parameter: $alg (STRING): The algorithm.
  * 
  * Return: STRING.
  ---------------------------------------------------------------------------------------------------
  */
  function alg2xC_TwizzleToSse($alg) {
    /* --- 2xC: Marker --- */
    $alg = str_replace(".","·",$alg);
    
    /* ··································································································· */
    /* --- 2xC: TWIZZLE -> CODE: [7] Cube rotations --- */
    $alg = preg_replace("/Rv'/","<701>",$alg); $alg = preg_replace("/Rv2/","<702>",$alg); $alg = preg_replace("/Rv/","<703>",$alg);
    $alg = preg_replace("/Lv'/","<703>",$alg); $alg = preg_replace("/Lv2/","<702>",$alg); $alg = preg_replace("/Lv/","<701>",$alg);
    $alg = preg_replace("/Fv'/","<704>",$alg); $alg = preg_replace("/Fv2/","<705>",$alg); $alg = preg_replace("/Fv/","<706>",$alg);
    $alg = preg_replace("/Bv'/","<706>",$alg); $alg = preg_replace("/Bv2/","<705>",$alg); $alg = preg_replace("/Bv/","<704>",$alg);
    $alg = preg_replace("/Uv'/","<707>",$alg); $alg = preg_replace("/Uv2/","<708>",$alg); $alg = preg_replace("/Uv/","<709>",$alg);
    $alg = preg_replace("/Dv'/","<709>",$alg); $alg = preg_replace("/Dv2/","<708>",$alg); $alg = preg_replace("/Dv/","<707>",$alg);
    
    $alg = preg_replace("/x'/","<701>",$alg); $alg = preg_replace("/x2/","<702>",$alg); $alg = preg_replace("/x/","<703>",$alg);
    $alg = preg_replace("/z'/","<704>",$alg); $alg = preg_replace("/z2/","<705>",$alg); $alg = preg_replace("/z/","<706>",$alg);
    $alg = preg_replace("/y'/","<707>",$alg); $alg = preg_replace("/y2/","<708>",$alg); $alg = preg_replace("/y/","<709>",$alg);
    
    /* --- 2xC: TWIZZLE -> CODE: [9] Face twists --- */
    $alg = preg_replace("/R'/","<901>",$alg); $alg = preg_replace("/R2/","<902>",$alg); $alg = preg_replace("/R/","<903>",$alg);
    $alg = preg_replace("/L'/","<904>",$alg); $alg = preg_replace("/L2/","<905>",$alg); $alg = preg_replace("/L/","<906>",$alg);
    $alg = preg_replace("/F'/","<907>",$alg); $alg = preg_replace("/F2/","<908>",$alg); $alg = preg_replace("/F/","<909>",$alg);
    $alg = preg_replace("/B'/","<910>",$alg); $alg = preg_replace("/B2/","<911>",$alg); $alg = preg_replace("/B/","<912>",$alg);
    $alg = preg_replace("/U'/","<913>",$alg); $alg = preg_replace("/U2/","<914>",$alg); $alg = preg_replace("/U/","<915>",$alg);
    $alg = preg_replace("/D'/","<916>",$alg); $alg = preg_replace("/D2/","<917>",$alg); $alg = preg_replace("/D/","<918>",$alg);
    
    /* ··································································································· */
    /* --- 2xC: CODE -> SSE: [7] Cube rotations --- */
    $alg = preg_replace("/<701>/","CR'",$alg); $alg = preg_replace("/<702>/","CR2",$alg); $alg = preg_replace("/<703>/","CR",$alg);
    $alg = preg_replace("/<704>/","CF'",$alg); $alg = preg_replace("/<705>/","CF2",$alg); $alg = preg_replace("/<706>/","CF",$alg);
    $alg = preg_replace("/<707>/","CU'",$alg); $alg = preg_replace("/<708>/","CU2",$alg); $alg = preg_replace("/<709>/","CU",$alg);
    
    /* --- 2xC: CODE -> SSE: [9] Face twists --- */
    $alg = preg_replace("/<901>/","R'",$alg); $alg = preg_replace("/<902>/","R2",$alg); $alg = preg_replace("/<903>/","R",$alg);
    $alg = preg_replace("/<904>/","L'",$alg); $alg = preg_replace("/<905>/","L2",$alg); $alg = preg_replace("/<906>/","L",$alg);
    $alg = preg_replace("/<907>/","F'",$alg); $alg = preg_replace("/<908>/","F2",$alg); $alg = preg_replace("/<909>/","F",$alg);
    $alg = preg_replace("/<910>/","B'",$alg); $alg = preg_replace("/<911>/","B2",$alg); $alg = preg_replace("/<912>/","B",$alg);
    $alg = preg_replace("/<913>/","U'",$alg); $alg = preg_replace("/<914>/","U2",$alg); $alg = preg_replace("/<915>/","U",$alg);
    $alg = preg_replace("/<916>/","D'",$alg); $alg = preg_replace("/<917>/","D2",$alg); $alg = preg_replace("/<918>/","D",$alg);
    
    return $alg;
  }
  
  
  
  
  /* 
  ---------------------------------------------------------------------------------------------------
  * alg3xC_SseToTwizzle($alg)
  * 
  * Converts 3x3 Rubik's Cube SSE algorithms into TWIZZLE notation.
  * 
  * Parameter: $alg (STRING): The algorithm.
  * 
  * Return: STRING.
  ---------------------------------------------------------------------------------------------------
  */
  function alg3xC_SseToTwizzle($alg) {
    /* --- 3xC: Preferences --- */
    $useSiGN    = true; // Notation style: SiGN or TWIZZLE (Default).
    $useMarkers = false; // 01.04.2021: Unfortunately Twizzle Explorer doesn't handle Markers correctly!
    
    /* --- 3xC: Marker --- */
    if ($useMarkers != true) {
      $alg = str_replace("·","",$alg); $alg = str_replace(".","",$alg); // Remove Markers!
    } else {
      $alg = str_replace("·",".",$alg);
    }
    
    /* ··································································································· */
    /* --- 3xC: SSE -> CODE: [5] Mid-layer [1] (Numbered layer) [6] (Wide) twists --- */
    $alg = preg_replace("/MR'/","<101>",$alg); $alg = preg_replace("/MR-/","<101>",$alg);   $alg = preg_replace("/MR2/","<102>",$alg);   $alg = preg_replace("/MR/","<103>",$alg);
    $alg = preg_replace("/ML'/","<104>",$alg); $alg = preg_replace("/ML-/","<104>",$alg);   $alg = preg_replace("/ML2/","<105>",$alg);   $alg = preg_replace("/ML/","<106>",$alg);
    $alg = preg_replace("/MF'/","<107>",$alg); $alg = preg_replace("/MF-/","<107>",$alg);   $alg = preg_replace("/MF2/","<108>",$alg);   $alg = preg_replace("/MF/","<109>",$alg);
    $alg = preg_replace("/MB'/","<110>",$alg); $alg = preg_replace("/MB-/","<110>",$alg);   $alg = preg_replace("/MB2/","<111>",$alg);   $alg = preg_replace("/MB/","<112>",$alg);
    $alg = preg_replace("/MU'/","<113>",$alg); $alg = preg_replace("/MU-/","<113>",$alg);   $alg = preg_replace("/MU2/","<114>",$alg);   $alg = preg_replace("/MU/","<115>",$alg);
    $alg = preg_replace("/MD'/","<116>",$alg); $alg = preg_replace("/MD-/","<116>",$alg);   $alg = preg_replace("/MD2/","<117>",$alg);   $alg = preg_replace("/MD/","<118>",$alg);
    
    $alg = preg_replace("/NR'/","<101>",$alg); $alg = preg_replace("/NR-/","<101>",$alg);   $alg = preg_replace("/NR2/","<102>",$alg);   $alg = preg_replace("/NR/","<103>",$alg);
    $alg = preg_replace("/NL'/","<104>",$alg); $alg = preg_replace("/NL-/","<104>",$alg);   $alg = preg_replace("/NL2/","<105>",$alg);   $alg = preg_replace("/NL/","<106>",$alg);
    $alg = preg_replace("/NF'/","<107>",$alg); $alg = preg_replace("/NF-/","<107>",$alg);   $alg = preg_replace("/NF2/","<108>",$alg);   $alg = preg_replace("/NF/","<109>",$alg);
    $alg = preg_replace("/NB'/","<110>",$alg); $alg = preg_replace("/NB-/","<110>",$alg);   $alg = preg_replace("/NB2/","<111>",$alg);   $alg = preg_replace("/NB/","<112>",$alg);
    $alg = preg_replace("/NU'/","<113>",$alg); $alg = preg_replace("/NU-/","<113>",$alg);   $alg = preg_replace("/NU2/","<114>",$alg);   $alg = preg_replace("/NU/","<115>",$alg);
    $alg = preg_replace("/ND'/","<116>",$alg); $alg = preg_replace("/ND-/","<116>",$alg);   $alg = preg_replace("/ND2/","<117>",$alg);   $alg = preg_replace("/ND/","<118>",$alg);
    
    $alg = preg_replace("/WR'/","<101>",$alg); $alg = preg_replace("/WR-/","<101>",$alg);   $alg = preg_replace("/WR2/","<102>",$alg);   $alg = preg_replace("/WR/","<103>",$alg);
    $alg = preg_replace("/WL'/","<104>",$alg); $alg = preg_replace("/WL-/","<104>",$alg);   $alg = preg_replace("/WL2/","<105>",$alg);   $alg = preg_replace("/WL/","<106>",$alg);
    $alg = preg_replace("/WF'/","<107>",$alg); $alg = preg_replace("/WF-/","<107>",$alg);   $alg = preg_replace("/WF2/","<108>",$alg);   $alg = preg_replace("/WF/","<109>",$alg);
    $alg = preg_replace("/WB'/","<110>",$alg); $alg = preg_replace("/WB-/","<110>",$alg);   $alg = preg_replace("/WB2/","<111>",$alg);   $alg = preg_replace("/WB/","<112>",$alg);
    $alg = preg_replace("/WU'/","<113>",$alg); $alg = preg_replace("/WU-/","<113>",$alg);   $alg = preg_replace("/WU2/","<114>",$alg);   $alg = preg_replace("/WU/","<115>",$alg);
    $alg = preg_replace("/WD'/","<116>",$alg); $alg = preg_replace("/WD-/","<116>",$alg);   $alg = preg_replace("/WD2/","<117>",$alg);   $alg = preg_replace("/WD/","<118>",$alg);
    
    /* --- 3xC: SSE -> CODE: [2] Slice twists --- */
    $alg = preg_replace("/SR'/","<201>",$alg); $alg = preg_replace("/SR-/","<201>",$alg);   $alg = preg_replace("/SR2/","<202>",$alg);   $alg = preg_replace("/SR/","<203>",$alg);
    $alg = preg_replace("/SL'/","<203>",$alg); $alg = preg_replace("/SL-/","<203>",$alg);   $alg = preg_replace("/SL2/","<202>",$alg);   $alg = preg_replace("/SL/","<201>",$alg);
    $alg = preg_replace("/SF'/","<204>",$alg); $alg = preg_replace("/SF-/","<204>",$alg);   $alg = preg_replace("/SF2/","<205>",$alg);   $alg = preg_replace("/SF/","<206>",$alg);
    $alg = preg_replace("/SB'/","<206>",$alg); $alg = preg_replace("/SB-/","<206>",$alg);   $alg = preg_replace("/SB2/","<205>",$alg);   $alg = preg_replace("/SB/","<204>",$alg);
    $alg = preg_replace("/SU'/","<207>",$alg); $alg = preg_replace("/SU-/","<207>",$alg);   $alg = preg_replace("/SU2/","<208>",$alg);   $alg = preg_replace("/SU/","<209>",$alg);
    $alg = preg_replace("/SD'/","<209>",$alg); $alg = preg_replace("/SD-/","<209>",$alg);   $alg = preg_replace("/SD2/","<208>",$alg);   $alg = preg_replace("/SD/","<207>",$alg);
    
    /* --- 3xC: SSE -> CODE: [3] Tier twists --- */
    $alg = preg_replace("/TR'/","<301>",$alg); $alg = preg_replace("/TR-/","<301>",$alg);   $alg = preg_replace("/TR2/","<302>",$alg);   $alg = preg_replace("/TR/","<303>",$alg);
    $alg = preg_replace("/TL'/","<304>",$alg); $alg = preg_replace("/TL-/","<304>",$alg);   $alg = preg_replace("/TL2/","<305>",$alg);   $alg = preg_replace("/TL/","<306>",$alg);
    $alg = preg_replace("/TF'/","<307>",$alg); $alg = preg_replace("/TF-/","<307>",$alg);   $alg = preg_replace("/TF2/","<308>",$alg);   $alg = preg_replace("/TF/","<309>",$alg);
    $alg = preg_replace("/TB'/","<310>",$alg); $alg = preg_replace("/TB-/","<310>",$alg);   $alg = preg_replace("/TB2/","<311>",$alg);   $alg = preg_replace("/TB/","<312>",$alg);
    $alg = preg_replace("/TU'/","<313>",$alg); $alg = preg_replace("/TU-/","<313>",$alg);   $alg = preg_replace("/TU2/","<314>",$alg);   $alg = preg_replace("/TU/","<315>",$alg);
    $alg = preg_replace("/TD'/","<316>",$alg); $alg = preg_replace("/TD-/","<316>",$alg);   $alg = preg_replace("/TD2/","<317>",$alg);   $alg = preg_replace("/TD/","<318>",$alg);
    
    /* --- 3xC: SSE -> CODE: [7] Cube rotations --- */
    $alg = preg_replace("/CR'/","<701>",$alg); $alg = preg_replace("/CR-/","<701>",$alg);   $alg = preg_replace("/CR2/","<702>",$alg);   $alg = preg_replace("/CR/","<703>",$alg);
    $alg = preg_replace("/CL'/","<704>",$alg); $alg = preg_replace("/CL-/","<704>",$alg);   $alg = preg_replace("/CL2/","<705>",$alg);   $alg = preg_replace("/CL/","<706>",$alg);
    $alg = preg_replace("/CF'/","<707>",$alg); $alg = preg_replace("/CF-/","<707>",$alg);   $alg = preg_replace("/CF2/","<708>",$alg);   $alg = preg_replace("/CF/","<709>",$alg);
    $alg = preg_replace("/CB'/","<710>",$alg); $alg = preg_replace("/CB-/","<710>",$alg);   $alg = preg_replace("/CB2/","<711>",$alg);   $alg = preg_replace("/CB/","<712>",$alg);
    $alg = preg_replace("/CU'/","<713>",$alg); $alg = preg_replace("/CU-/","<713>",$alg);   $alg = preg_replace("/CU2/","<714>",$alg);   $alg = preg_replace("/CU/","<715>",$alg);
    $alg = preg_replace("/CD'/","<716>",$alg); $alg = preg_replace("/CD-/","<716>",$alg);   $alg = preg_replace("/CD2/","<717>",$alg);   $alg = preg_replace("/CD/","<718>",$alg);
    
    /* --- 3xC: SSE -> CODE: [9] Face twists --- */
    $alg = preg_replace("/R'/","<901>",$alg); $alg = preg_replace("/R-/","<901>",$alg);   $alg = preg_replace("/R2/","<902>",$alg);   $alg = preg_replace("/R/","<903>",$alg);
    $alg = preg_replace("/L'/","<904>",$alg); $alg = preg_replace("/L-/","<904>",$alg);   $alg = preg_replace("/L2/","<905>",$alg);   $alg = preg_replace("/L/","<906>",$alg);
    $alg = preg_replace("/F'/","<907>",$alg); $alg = preg_replace("/F-/","<907>",$alg);   $alg = preg_replace("/F2/","<908>",$alg);   $alg = preg_replace("/F/","<909>",$alg);
    $alg = preg_replace("/B'/","<910>",$alg); $alg = preg_replace("/B-/","<910>",$alg);   $alg = preg_replace("/B2/","<911>",$alg);   $alg = preg_replace("/B/","<912>",$alg);
    $alg = preg_replace("/U'/","<913>",$alg); $alg = preg_replace("/U-/","<913>",$alg);   $alg = preg_replace("/U2/","<914>",$alg);   $alg = preg_replace("/U/","<915>",$alg);
    $alg = preg_replace("/D'/","<916>",$alg); $alg = preg_replace("/D-/","<916>",$alg);   $alg = preg_replace("/D2/","<917>",$alg);   $alg = preg_replace("/D/","<918>",$alg);
    
    /* ··································································································· */
    /* --- 3xC: CODE -> TWIZZLE: [5] Mid-layer [1] (Numbered layer) [6] (Wide) twists --- */
    if ($useSiGN == true) { // Bei SiGN:
      $alg = preg_replace("/<101>/","M",$alg);    $alg = preg_replace("/<102>/","M2",$alg);   $alg = preg_replace("/<103>/","M'",$alg);
      $alg = preg_replace("/<104>/","M'",$alg);   $alg = preg_replace("/<105>/","M2",$alg);   $alg = preg_replace("/<106>/","M",$alg);
      $alg = preg_replace("/<107>/","S'",$alg);   $alg = preg_replace("/<108>/","S2",$alg);   $alg = preg_replace("/<109>/","S",$alg);
      $alg = preg_replace("/<110>/","S",$alg);    $alg = preg_replace("/<111>/","S2",$alg);   $alg = preg_replace("/<112>/","S'",$alg);
      $alg = preg_replace("/<113>/","E",$alg);    $alg = preg_replace("/<114>/","E2",$alg);   $alg = preg_replace("/<115>/","E'",$alg);
      $alg = preg_replace("/<116>/","E'",$alg);   $alg = preg_replace("/<117>/","E2",$alg);   $alg = preg_replace("/<118>/","E",$alg);
    } else {               // Sonst (TWIZZLE):
      $alg = preg_replace("/<101>/","2R'",$alg);   $alg = preg_replace("/<102>/","2R2",$alg);   $alg = preg_replace("/<103>/","2R",$alg);
      $alg = preg_replace("/<104>/","2L'",$alg);   $alg = preg_replace("/<105>/","2L2",$alg);   $alg = preg_replace("/<106>/","2L",$alg);
      $alg = preg_replace("/<107>/","2F'",$alg);   $alg = preg_replace("/<108>/","2F2",$alg);   $alg = preg_replace("/<109>/","2F",$alg);
      $alg = preg_replace("/<110>/","2B'",$alg);   $alg = preg_replace("/<111>/","2B2",$alg);   $alg = preg_replace("/<112>/","2B",$alg);
      $alg = preg_replace("/<113>/","2U'",$alg);   $alg = preg_replace("/<114>/","2U2",$alg);   $alg = preg_replace("/<115>/","2U",$alg);
      $alg = preg_replace("/<116>/","2D'",$alg);   $alg = preg_replace("/<117>/","2D2",$alg);   $alg = preg_replace("/<118>/","2D",$alg);
    }
    
    /* --- 3xC: CODE -> TWIZZLE: [2] Slice twists --- */
    $alg = preg_replace("/<201>/","R' L",$alg);   $alg = preg_replace("/<202>/","R2 L2",$alg);   $alg = preg_replace("/<203>/","R L'",$alg);
    $alg = preg_replace("/<204>/","F' B",$alg);   $alg = preg_replace("/<205>/","F2 B2",$alg);   $alg = preg_replace("/<206>/","F B'",$alg);
    $alg = preg_replace("/<207>/","U' D",$alg);   $alg = preg_replace("/<208>/","U2 D2",$alg);   $alg = preg_replace("/<209>/","U D'",$alg);
    
    /* --- 3xC: CODE -> TWIZZLE: [3] Tier twists --- */
    $alg = preg_replace("/<301>/","r'",$alg);   $alg = preg_replace("/<302>/","r2",$alg);   $alg = preg_replace("/<303>/","r",$alg);
    $alg = preg_replace("/<304>/","l'",$alg);   $alg = preg_replace("/<305>/","l2",$alg);   $alg = preg_replace("/<306>/","l",$alg);
    $alg = preg_replace("/<307>/","f'",$alg);   $alg = preg_replace("/<308>/","f2",$alg);   $alg = preg_replace("/<309>/","f",$alg);
    $alg = preg_replace("/<310>/","b'",$alg);   $alg = preg_replace("/<311>/","b2",$alg);   $alg = preg_replace("/<312>/","b",$alg);
    $alg = preg_replace("/<313>/","u'",$alg);   $alg = preg_replace("/<314>/","u2",$alg);   $alg = preg_replace("/<315>/","u",$alg);
    $alg = preg_replace("/<316>/","d'",$alg);   $alg = preg_replace("/<317>/","d2",$alg);   $alg = preg_replace("/<318>/","d",$alg);
    
    /* --- 3xC: CODE -> TWIZZLE: [7] Cube rotations --- */
    $useSiGN    = false; // Notation style: SiGN or TWIZZLE (Default).
    if ($useSiGN == true) { // Bei SiGN:
      $alg = preg_replace("/<701>/","x'",$alg);   $alg = preg_replace("/<702>/","x2",$alg);   $alg = preg_replace("/<703>/","x",$alg);
      $alg = preg_replace("/<704>/","x",$alg);    $alg = preg_replace("/<705>/","x2",$alg);   $alg = preg_replace("/<706>/","x'",$alg);
      $alg = preg_replace("/<707>/","z'",$alg);   $alg = preg_replace("/<708>/","z2",$alg);   $alg = preg_replace("/<709>/","z",$alg);
      $alg = preg_replace("/<710>/","z",$alg);    $alg = preg_replace("/<711>/","z2",$alg);   $alg = preg_replace("/<712>/","z'",$alg);
      $alg = preg_replace("/<713>/","y'",$alg);   $alg = preg_replace("/<714>/","y2",$alg);   $alg = preg_replace("/<715>/","y",$alg);
      $alg = preg_replace("/<716>/","y",$alg);    $alg = preg_replace("/<717>/","y2",$alg);   $alg = preg_replace("/<718>/","y'",$alg);
    } else {               // Sonst (TWIZZLE):
      $alg = preg_replace("/<701>/","Rv'",$alg);   $alg = preg_replace("/<702>/","Rv2",$alg);   $alg = preg_replace("/<703>/","Rv",$alg);
      $alg = preg_replace("/<704>/","Rv",$alg);    $alg = preg_replace("/<705>/","Rv2",$alg);   $alg = preg_replace("/<706>/","Rv'",$alg);
      $alg = preg_replace("/<707>/","Fv'",$alg);   $alg = preg_replace("/<708>/","Fv2",$alg);   $alg = preg_replace("/<709>/","Fv",$alg);
      $alg = preg_replace("/<710>/","Fv",$alg);    $alg = preg_replace("/<711>/","Fv2",$alg);   $alg = preg_replace("/<712>/","Fv'",$alg);
      $alg = preg_replace("/<713>/","Uv'",$alg);   $alg = preg_replace("/<714>/","Uv2",$alg);   $alg = preg_replace("/<715>/","Uv",$alg);
      $alg = preg_replace("/<716>/","Uv",$alg);    $alg = preg_replace("/<717>/","Uv2",$alg);   $alg = preg_replace("/<718>/","Uv'",$alg);
    }
    
    /* --- 3xC: CODE -> TWIZZLE: [9] Face twists --- */
    $alg = preg_replace("/<901>/","R'",$alg);   $alg = preg_replace("/<902>/","R2",$alg);   $alg = preg_replace("/<903>/","R",$alg);
    $alg = preg_replace("/<904>/","L'",$alg);   $alg = preg_replace("/<905>/","L2",$alg);   $alg = preg_replace("/<906>/","L",$alg);
    $alg = preg_replace("/<907>/","F'",$alg);   $alg = preg_replace("/<908>/","F2",$alg);   $alg = preg_replace("/<909>/","F",$alg);
    $alg = preg_replace("/<910>/","B'",$alg);   $alg = preg_replace("/<911>/","B2",$alg);   $alg = preg_replace("/<912>/","B",$alg);
    $alg = preg_replace("/<913>/","U'",$alg);   $alg = preg_replace("/<914>/","U2",$alg);   $alg = preg_replace("/<915>/","U",$alg);
    $alg = preg_replace("/<916>/","D'",$alg);   $alg = preg_replace("/<917>/","D2",$alg);   $alg = preg_replace("/<918>/","D",$alg);
    
    return $alg;
  }
  
  
  
  
  /* 
  ---------------------------------------------------------------------------------------------------
  * alg3xC_TwizzleToSse($alg)
  * 
  * Converts 3x3 Rubik's Cube TWIZZLE algorithms into SSE notation.
  * 
  * Parameter: $alg (STRING): The algorithm.
  * 
  * Return: STRING.
  ---------------------------------------------------------------------------------------------------
  */
  function alg3xC_TwizzleToSse($alg) {
    /* --- 3xC: Marker --- */
    $alg = str_replace(".","·",$alg);
    
    /* ··································································································· */
    /* --- 3xC: TWIZZLE -> CODE: [5] Mid-layer [1] (Numbered layer) [6] (Wide) twists --- */
    $alg = preg_replace("/2R'/","<101>",$alg); $alg = preg_replace("/2R2/","<102>",$alg); $alg = preg_replace("/2R/","<103>",$alg);
    $alg = preg_replace("/2L'/","<104>",$alg); $alg = preg_replace("/2L2/","<105>",$alg); $alg = preg_replace("/2L/","<106>",$alg);
    $alg = preg_replace("/2F'/","<107>",$alg); $alg = preg_replace("/2F2/","<108>",$alg); $alg = preg_replace("/2F/","<109>",$alg);
    $alg = preg_replace("/2B'/","<110>",$alg); $alg = preg_replace("/2B2/","<111>",$alg); $alg = preg_replace("/2B/","<112>",$alg);
    $alg = preg_replace("/2U'/","<113>",$alg); $alg = preg_replace("/2U2/","<114>",$alg); $alg = preg_replace("/2U/","<115>",$alg);
    $alg = preg_replace("/2D'/","<116>",$alg); $alg = preg_replace("/2D2/","<117>",$alg); $alg = preg_replace("/2D/","<118>",$alg);
    
    /* --- 3xC: TWIZZLE -> CODE: [3] Tier twists (WCA) --- */
    $alg = preg_replace("/Rw'/","<301>",$alg); $alg = preg_replace("/Rw2/","<302>",$alg); $alg = preg_replace("/Rw/","<303>",$alg);
    $alg = preg_replace("/Lw'/","<304>",$alg); $alg = preg_replace("/Lw2/","<305>",$alg); $alg = preg_replace("/Lw/","<306>",$alg);
    $alg = preg_replace("/Fw'/","<307>",$alg); $alg = preg_replace("/Fw2/","<308>",$alg); $alg = preg_replace("/Fw/","<309>",$alg);
    $alg = preg_replace("/Bw'/","<310>",$alg); $alg = preg_replace("/Bw2/","<311>",$alg); $alg = preg_replace("/Bw/","<312>",$alg);
    $alg = preg_replace("/Uw'/","<313>",$alg); $alg = preg_replace("/Uw2/","<314>",$alg); $alg = preg_replace("/Uw/","<315>",$alg);
    $alg = preg_replace("/Dw'/","<316>",$alg); $alg = preg_replace("/Dw2/","<317>",$alg); $alg = preg_replace("/Dw/","<318>",$alg);
    
    /* --- 3xC: TWIZZLE -> CODE: [7] Cube rotations --- */
    $alg = preg_replace("/Rv'/","<701>",$alg); $alg = preg_replace("/Rv2/","<702>",$alg); $alg = preg_replace("/Rv/","<703>",$alg);
    $alg = preg_replace("/Lv'/","<703>",$alg); $alg = preg_replace("/Lv2/","<702>",$alg); $alg = preg_replace("/Lv/","<701>",$alg);
    $alg = preg_replace("/Fv'/","<704>",$alg); $alg = preg_replace("/Fv2/","<705>",$alg); $alg = preg_replace("/Fv/","<706>",$alg);
    $alg = preg_replace("/Bv'/","<706>",$alg); $alg = preg_replace("/Bv2/","<705>",$alg); $alg = preg_replace("/Bv/","<704>",$alg);
    $alg = preg_replace("/Uv'/","<707>",$alg); $alg = preg_replace("/Uv2/","<708>",$alg); $alg = preg_replace("/Uv/","<709>",$alg);
    $alg = preg_replace("/Dv'/","<709>",$alg); $alg = preg_replace("/Dv2/","<708>",$alg); $alg = preg_replace("/Dv/","<707>",$alg);
    
    $alg = preg_replace("/x'/","<701>",$alg); $alg = preg_replace("/x2/","<702>",$alg); $alg = preg_replace("/x/","<703>",$alg);
    $alg = preg_replace("/z'/","<704>",$alg); $alg = preg_replace("/z2/","<705>",$alg); $alg = preg_replace("/z/","<706>",$alg);
    $alg = preg_replace("/y'/","<707>",$alg); $alg = preg_replace("/y2/","<708>",$alg); $alg = preg_replace("/y/","<709>",$alg);
    
    /* --- 3xC: TWIZZLE -> CODE: [5] Mid-layer [1] (Numbered layer) [6] (Wide) twists --- */
    $alg = preg_replace("/M'/","<103>",$alg); $alg = preg_replace("/M2/","<102>",$alg); $alg = preg_replace("/M/","<101>",$alg);
    $alg = preg_replace("/S'/","<107>",$alg); $alg = preg_replace("/S2/","<108>",$alg); $alg = preg_replace("/S/","<109>",$alg);
    $alg = preg_replace("/E'/","<115>",$alg); $alg = preg_replace("/E2/","<114>",$alg); $alg = preg_replace("/E/","<113>",$alg);
    
    /* --- 3xC: TWIZZLE -> CODE: [9] Face twists --- */
    $alg = preg_replace("/R'/","<901>",$alg); $alg = preg_replace("/R2/","<902>",$alg); $alg = preg_replace("/R/","<903>",$alg);
    $alg = preg_replace("/L'/","<904>",$alg); $alg = preg_replace("/L2/","<905>",$alg); $alg = preg_replace("/L/","<906>",$alg);
    $alg = preg_replace("/F'/","<907>",$alg); $alg = preg_replace("/F2/","<908>",$alg); $alg = preg_replace("/F/","<909>",$alg);
    $alg = preg_replace("/B'/","<910>",$alg); $alg = preg_replace("/B2/","<911>",$alg); $alg = preg_replace("/B/","<912>",$alg);
    $alg = preg_replace("/U'/","<913>",$alg); $alg = preg_replace("/U2/","<914>",$alg); $alg = preg_replace("/U/","<915>",$alg);
    $alg = preg_replace("/D'/","<916>",$alg); $alg = preg_replace("/D2/","<917>",$alg); $alg = preg_replace("/D/","<918>",$alg);
    
    /* --- 3xC: TWIZZLE -> CODE: [3] Tier twists (SiGN) --- */
    $alg = preg_replace("/r'/","<301>",$alg); $alg = preg_replace("/r2/","<302>",$alg); $alg = preg_replace("/r/","<303>",$alg);
    $alg = preg_replace("/l'/","<304>",$alg); $alg = preg_replace("/l2/","<305>",$alg); $alg = preg_replace("/l/","<306>",$alg);
    $alg = preg_replace("/f'/","<307>",$alg); $alg = preg_replace("/f2/","<308>",$alg); $alg = preg_replace("/f/","<309>",$alg);
    $alg = preg_replace("/b'/","<310>",$alg); $alg = preg_replace("/b2/","<311>",$alg); $alg = preg_replace("/b/","<312>",$alg);
    $alg = preg_replace("/u'/","<313>",$alg); $alg = preg_replace("/u2/","<314>",$alg); $alg = preg_replace("/u/","<315>",$alg);
    $alg = preg_replace("/d'/","<316>",$alg); $alg = preg_replace("/d2/","<317>",$alg); $alg = preg_replace("/d/","<318>",$alg);
    
    /* ··································································································· */
    /* --- 3xC: CODE -> SSE: [5] Mid-layer [1] (Numbered layer) [6] (Wide) twists --- */
    $alg = preg_replace("/<101>/","MR'",$alg); $alg = preg_replace("/<102>/","MR2",$alg); $alg = preg_replace("/<103>/","MR",$alg);
    $alg = preg_replace("/<104>/","ML'",$alg); $alg = preg_replace("/<105>/","ML2",$alg); $alg = preg_replace("/<106>/","ML",$alg);
    $alg = preg_replace("/<107>/","MF'",$alg); $alg = preg_replace("/<108>/","MF2",$alg); $alg = preg_replace("/<109>/","MF",$alg);
    $alg = preg_replace("/<110>/","MB'",$alg); $alg = preg_replace("/<111>/","MB2",$alg); $alg = preg_replace("/<112>/","MB",$alg);
    $alg = preg_replace("/<113>/","MU'",$alg); $alg = preg_replace("/<114>/","MU2",$alg); $alg = preg_replace("/<115>/","MU",$alg);
    $alg = preg_replace("/<116>/","MD'",$alg); $alg = preg_replace("/<117>/","MD2",$alg); $alg = preg_replace("/<118>/","MD",$alg);
    
    /* --- 3xC: CODE -> SSE: [7] Cube rotations --- */
    $alg = preg_replace("/<701>/","CR'",$alg); $alg = preg_replace("/<702>/","CR2",$alg); $alg = preg_replace("/<703>/","CR",$alg);
    $alg = preg_replace("/<704>/","CF'",$alg); $alg = preg_replace("/<705>/","CF2",$alg); $alg = preg_replace("/<706>/","CF",$alg);
    $alg = preg_replace("/<707>/","CU'",$alg); $alg = preg_replace("/<708>/","CU2",$alg); $alg = preg_replace("/<709>/","CU",$alg);
    
    /* --- 3xC: CODE -> SSE: [9] Face twists --- */
    $alg = preg_replace("/<901>/","R'",$alg); $alg = preg_replace("/<902>/","R2",$alg); $alg = preg_replace("/<903>/","R",$alg);
    $alg = preg_replace("/<904>/","L'",$alg); $alg = preg_replace("/<905>/","L2",$alg); $alg = preg_replace("/<906>/","L",$alg);
    $alg = preg_replace("/<907>/","F'",$alg); $alg = preg_replace("/<908>/","F2",$alg); $alg = preg_replace("/<909>/","F",$alg);
    $alg = preg_replace("/<910>/","B'",$alg); $alg = preg_replace("/<911>/","B2",$alg); $alg = preg_replace("/<912>/","B",$alg);
    $alg = preg_replace("/<913>/","U'",$alg); $alg = preg_replace("/<914>/","U2",$alg); $alg = preg_replace("/<915>/","U",$alg);
    $alg = preg_replace("/<916>/","D'",$alg); $alg = preg_replace("/<917>/","D2",$alg); $alg = preg_replace("/<918>/","D",$alg);
    
    /* --- 3xC: CODE -> SSE: [3] Tier twists --- */
    $alg = preg_replace("/<301>/","TR'",$alg); $alg = preg_replace("/<302>/","TR2",$alg); $alg = preg_replace("/<303>/","TR",$alg);
    $alg = preg_replace("/<304>/","TL'",$alg); $alg = preg_replace("/<305>/","TL2",$alg); $alg = preg_replace("/<306>/","TL",$alg);
    $alg = preg_replace("/<307>/","TF'",$alg); $alg = preg_replace("/<308>/","TF2",$alg); $alg = preg_replace("/<309>/","TF",$alg);
    $alg = preg_replace("/<310>/","TB'",$alg); $alg = preg_replace("/<311>/","TB2",$alg); $alg = preg_replace("/<312>/","TB",$alg);
    $alg = preg_replace("/<313>/","TU'",$alg); $alg = preg_replace("/<314>/","TU2",$alg); $alg = preg_replace("/<315>/","TU",$alg);
    $alg = preg_replace("/<316>/","TD'",$alg); $alg = preg_replace("/<317>/","TD2",$alg); $alg = preg_replace("/<318>/","TD",$alg);
    
    return $alg;
  }
  
  
  
  
  /* 
  ---------------------------------------------------------------------------------------------------
  * alg4xC_SseToTwizzle($alg)
  * 
  * Converts 4x4 Revenge Cube SSE algorithms into TWIZZLE notation.
  * 
  * Parameter: $alg (STRING): The algorithm.
  * 
  * Return: STRING.
  ---------------------------------------------------------------------------------------------------
  */
  function alg4xC_SseToTwizzle($alg) {
    /* --- 4xC: Preferences --- */
    $useSiGN    = false; // Notation style: SiGN or TWIZZLE (Default).
    $useMarkers = false; // 01.04.2021: Unfortunately Twizzle Explorer doesn't handle Markers correctly!
    
    /* --- 4xC: Marker --- */
    if ($useMarkers != true) {
      $alg = str_replace("·","",$alg); $alg = str_replace(".","",$alg); // Remove Markers!
    } else {
      $alg = str_replace("·",".",$alg);
    }
    
    /* ··································································································· */
    /* --- 4xC: SSE -> CODE: [1] Numbered-layer twists --- */
    $alg = preg_replace("/N3R'/","<106>",$alg); $alg = preg_replace("/N3R-/","<106>",$alg);   $alg = preg_replace("/N3R2/","<105>",$alg);   $alg = preg_replace("/N3R/","<104>",$alg);
    $alg = preg_replace("/N3L'/","<103>",$alg); $alg = preg_replace("/N3L-/","<103>",$alg);   $alg = preg_replace("/N3L2/","<102>",$alg);   $alg = preg_replace("/N3L/","<101>",$alg);
    $alg = preg_replace("/N3F'/","<112>",$alg); $alg = preg_replace("/N3F-/","<112>",$alg);   $alg = preg_replace("/N3F2/","<111>",$alg);   $alg = preg_replace("/N3F/","<110>",$alg);
    $alg = preg_replace("/N3B'/","<109>",$alg); $alg = preg_replace("/N3B-/","<109>",$alg);   $alg = preg_replace("/N3B2/","<108>",$alg);   $alg = preg_replace("/N3B/","<107>",$alg);
    $alg = preg_replace("/N3U'/","<118>",$alg); $alg = preg_replace("/N3U-/","<118>",$alg);   $alg = preg_replace("/N3U2/","<117>",$alg);   $alg = preg_replace("/N3U/","<116>",$alg);
    $alg = preg_replace("/N3D'/","<115>",$alg); $alg = preg_replace("/N3D-/","<115>",$alg);   $alg = preg_replace("/N3D2/","<114>",$alg);   $alg = preg_replace("/N3D/","<113>",$alg);
    
    $alg = preg_replace("/MR'/","<101>",$alg); $alg = preg_replace("/MR-/","<101>",$alg);   $alg = preg_replace("/MR2/","<102>",$alg);   $alg = preg_replace("/MR/","<103>",$alg);
    $alg = preg_replace("/ML'/","<104>",$alg); $alg = preg_replace("/ML-/","<104>",$alg);   $alg = preg_replace("/ML2/","<105>",$alg);   $alg = preg_replace("/ML/","<106>",$alg);
    $alg = preg_replace("/MF'/","<107>",$alg); $alg = preg_replace("/MF-/","<107>",$alg);   $alg = preg_replace("/MF2/","<108>",$alg);   $alg = preg_replace("/MF/","<109>",$alg);
    $alg = preg_replace("/MB'/","<110>",$alg); $alg = preg_replace("/MB-/","<110>",$alg);   $alg = preg_replace("/MB2/","<111>",$alg);   $alg = preg_replace("/MB/","<112>",$alg);
    $alg = preg_replace("/MU'/","<113>",$alg); $alg = preg_replace("/MU-/","<113>",$alg);   $alg = preg_replace("/MU2/","<114>",$alg);   $alg = preg_replace("/MU/","<115>",$alg);
    $alg = preg_replace("/MD'/","<116>",$alg); $alg = preg_replace("/MD-/","<116>",$alg);   $alg = preg_replace("/MD2/","<117>",$alg);   $alg = preg_replace("/MD/","<118>",$alg);
    
    $alg = preg_replace("/NR'/","<101>",$alg); $alg = preg_replace("/NR-/","<101>",$alg);   $alg = preg_replace("/NR2/","<102>",$alg);   $alg = preg_replace("/NR/","<103>",$alg);
    $alg = preg_replace("/NL'/","<104>",$alg); $alg = preg_replace("/NL-/","<104>",$alg);   $alg = preg_replace("/NL2/","<105>",$alg);   $alg = preg_replace("/NL/","<106>",$alg);
    $alg = preg_replace("/NF'/","<107>",$alg); $alg = preg_replace("/NF-/","<107>",$alg);   $alg = preg_replace("/NF2/","<108>",$alg);   $alg = preg_replace("/NF/","<109>",$alg);
    $alg = preg_replace("/NB'/","<110>",$alg); $alg = preg_replace("/NB-/","<110>",$alg);   $alg = preg_replace("/NB2/","<111>",$alg);   $alg = preg_replace("/NB/","<112>",$alg);
    $alg = preg_replace("/NU'/","<113>",$alg); $alg = preg_replace("/NU-/","<113>",$alg);   $alg = preg_replace("/NU2/","<114>",$alg);   $alg = preg_replace("/NU/","<115>",$alg);
    $alg = preg_replace("/ND'/","<116>",$alg); $alg = preg_replace("/ND-/","<116>",$alg);   $alg = preg_replace("/ND2/","<117>",$alg);   $alg = preg_replace("/ND/","<118>",$alg);
    
    /* --- 4xC: SSE -> CODE: [2] Slice twists --- */
    $alg = preg_replace("/SR'/","<201>",$alg); $alg = preg_replace("/SR-/","<201>",$alg);   $alg = preg_replace("/SR2/","<202>",$alg);   $alg = preg_replace("/SR/","<203>",$alg);
    $alg = preg_replace("/SL'/","<204>",$alg); $alg = preg_replace("/SL-/","<204>",$alg);   $alg = preg_replace("/SL2/","<205>",$alg);   $alg = preg_replace("/SL/","<206>",$alg);
    $alg = preg_replace("/SF'/","<207>",$alg); $alg = preg_replace("/SF-/","<207>",$alg);   $alg = preg_replace("/SF2/","<208>",$alg);   $alg = preg_replace("/SF/","<209>",$alg);
    $alg = preg_replace("/SB'/","<210>",$alg); $alg = preg_replace("/SB-/","<210>",$alg);   $alg = preg_replace("/SB2/","<211>",$alg);   $alg = preg_replace("/SB/","<212>",$alg);
    $alg = preg_replace("/SU'/","<213>",$alg); $alg = preg_replace("/SU-/","<213>",$alg);   $alg = preg_replace("/SU2/","<214>",$alg);   $alg = preg_replace("/SU/","<215>",$alg);
    $alg = preg_replace("/SD'/","<216>",$alg); $alg = preg_replace("/SD-/","<216>",$alg);   $alg = preg_replace("/SD2/","<217>",$alg);   $alg = preg_replace("/SD/","<218>",$alg);
    
    $alg = preg_replace("/S2-2R'/","<219>",$alg); $alg = preg_replace("/S2-2R-/","<219>",$alg);   $alg = preg_replace("/S2-2R2/","<220>",$alg);   $alg = preg_replace("/S2-2R/","<221>",$alg);
    $alg = preg_replace("/S2-2L'/","<222>",$alg); $alg = preg_replace("/S2-2L-/","<222>",$alg);   $alg = preg_replace("/S2-2L2/","<223>",$alg);   $alg = preg_replace("/S2-2L/","<224>",$alg);
    $alg = preg_replace("/S2-2F'/","<225>",$alg); $alg = preg_replace("/S2-2F-/","<225>",$alg);   $alg = preg_replace("/S2-2F2/","<226>",$alg);   $alg = preg_replace("/S2-2F/","<227>",$alg);
    $alg = preg_replace("/S2-2B'/","<228>",$alg); $alg = preg_replace("/S2-2B-/","<228>",$alg);   $alg = preg_replace("/S2-2B2/","<229>",$alg);   $alg = preg_replace("/S2-2B/","<230>",$alg);
    $alg = preg_replace("/S2-2U'/","<231>",$alg); $alg = preg_replace("/S2-2U-/","<231>",$alg);   $alg = preg_replace("/S2-2U2/","<232>",$alg);   $alg = preg_replace("/S2-2U/","<233>",$alg);
    $alg = preg_replace("/S2-2D'/","<234>",$alg); $alg = preg_replace("/S2-2D-/","<234>",$alg);   $alg = preg_replace("/S2-2D2/","<235>",$alg);   $alg = preg_replace("/S2-2D/","<236>",$alg);
    
    /* --- 4xC: SSE -> CODE: [3] Tier twists --- */
    $alg = preg_replace("/T3R'/","<301>",$alg); $alg = preg_replace("/T3R-/","<301>",$alg);   $alg = preg_replace("/T3R2/","<302>",$alg);   $alg = preg_replace("/T3R/","<303>",$alg);
    $alg = preg_replace("/T3L'/","<304>",$alg); $alg = preg_replace("/T3L-/","<304>",$alg);   $alg = preg_replace("/T3L2/","<305>",$alg);   $alg = preg_replace("/T3L/","<306>",$alg);
    $alg = preg_replace("/T3F'/","<307>",$alg); $alg = preg_replace("/T3F-/","<307>",$alg);   $alg = preg_replace("/T3F2/","<308>",$alg);   $alg = preg_replace("/T3F/","<309>",$alg);
    $alg = preg_replace("/T3B'/","<310>",$alg); $alg = preg_replace("/T3B-/","<310>",$alg);   $alg = preg_replace("/T3B2/","<311>",$alg);   $alg = preg_replace("/T3B/","<312>",$alg);
    $alg = preg_replace("/T3U'/","<313>",$alg); $alg = preg_replace("/T3U-/","<313>",$alg);   $alg = preg_replace("/T3U2/","<314>",$alg);   $alg = preg_replace("/T3U/","<315>",$alg);
    $alg = preg_replace("/T3D'/","<316>",$alg); $alg = preg_replace("/T3D-/","<316>",$alg);   $alg = preg_replace("/T3D2/","<317>",$alg);   $alg = preg_replace("/T3D/","<318>",$alg);
    
    $alg = preg_replace("/TR'/","<319>",$alg); $alg = preg_replace("/TR-/","<319>",$alg);   $alg = preg_replace("/TR2/","<320>",$alg);   $alg = preg_replace("/TR/","<321>",$alg);
    $alg = preg_replace("/TL'/","<322>",$alg); $alg = preg_replace("/TL-/","<322>",$alg);   $alg = preg_replace("/TL2/","<323>",$alg);   $alg = preg_replace("/TL/","<324>",$alg);
    $alg = preg_replace("/TF'/","<325>",$alg); $alg = preg_replace("/TF-/","<325>",$alg);   $alg = preg_replace("/TF2/","<326>",$alg);   $alg = preg_replace("/TF/","<327>",$alg);
    $alg = preg_replace("/TB'/","<328>",$alg); $alg = preg_replace("/TB-/","<328>",$alg);   $alg = preg_replace("/TB2/","<329>",$alg);   $alg = preg_replace("/TB/","<330>",$alg);
    $alg = preg_replace("/TU'/","<331>",$alg); $alg = preg_replace("/TU-/","<331>",$alg);   $alg = preg_replace("/TU2/","<332>",$alg);   $alg = preg_replace("/TU/","<333>",$alg);
    $alg = preg_replace("/TD'/","<334>",$alg); $alg = preg_replace("/TD-/","<334>",$alg);   $alg = preg_replace("/TD2/","<335>",$alg);   $alg = preg_replace("/TD/","<336>",$alg);
    
    /* --- 4xC: SSE -> CODE: [6] Wide-layer twists [5] (Mid-layer twists) [4] (Void twists) [1] Numbered layer twists --- */
    $alg = preg_replace("/WR'/","<501>",$alg); $alg = preg_replace("/WR-/","<501>",$alg);   $alg = preg_replace("/WR2/","<502>",$alg);   $alg = preg_replace("/WR/","<503>",$alg);
    $alg = preg_replace("/WL'/","<504>",$alg); $alg = preg_replace("/WL-/","<504>",$alg);   $alg = preg_replace("/WL2/","<505>",$alg);   $alg = preg_replace("/WL/","<506>",$alg);
    $alg = preg_replace("/WF'/","<507>",$alg); $alg = preg_replace("/WF-/","<507>",$alg);   $alg = preg_replace("/WF2/","<508>",$alg);   $alg = preg_replace("/WF/","<509>",$alg);
    $alg = preg_replace("/WB'/","<510>",$alg); $alg = preg_replace("/WB-/","<510>",$alg);   $alg = preg_replace("/WB2/","<511>",$alg);   $alg = preg_replace("/WB/","<512>",$alg);
    $alg = preg_replace("/WU'/","<513>",$alg); $alg = preg_replace("/WU-/","<513>",$alg);   $alg = preg_replace("/WU2/","<514>",$alg);   $alg = preg_replace("/WU/","<515>",$alg);
    $alg = preg_replace("/WD'/","<516>",$alg); $alg = preg_replace("/WD-/","<516>",$alg);   $alg = preg_replace("/WD2/","<517>",$alg);   $alg = preg_replace("/WD/","<518>",$alg);
    
    $alg = preg_replace("/M2R'/","<501>",$alg); $alg = preg_replace("/M2R-/","<501>",$alg);   $alg = preg_replace("/M2R2/","<502>",$alg);   $alg = preg_replace("/M2R/","<503>",$alg);
    $alg = preg_replace("/M2L'/","<504>",$alg); $alg = preg_replace("/M2L-/","<504>",$alg);   $alg = preg_replace("/M2L2/","<505>",$alg);   $alg = preg_replace("/M2L/","<506>",$alg);
    $alg = preg_replace("/M2F'/","<507>",$alg); $alg = preg_replace("/M2F-/","<507>",$alg);   $alg = preg_replace("/M2F2/","<508>",$alg);   $alg = preg_replace("/M2F/","<509>",$alg);
    $alg = preg_replace("/M2B'/","<510>",$alg); $alg = preg_replace("/M2B-/","<510>",$alg);   $alg = preg_replace("/M2B2/","<511>",$alg);   $alg = preg_replace("/M2B/","<512>",$alg);
    $alg = preg_replace("/M2U'/","<513>",$alg); $alg = preg_replace("/M2U-/","<513>",$alg);   $alg = preg_replace("/M2U2/","<514>",$alg);   $alg = preg_replace("/M2U/","<515>",$alg);
    $alg = preg_replace("/M2D'/","<516>",$alg); $alg = preg_replace("/M2D-/","<516>",$alg);   $alg = preg_replace("/M2D2/","<517>",$alg);   $alg = preg_replace("/M2D/","<518>",$alg);
    
    $alg = preg_replace("/VR'/","<501>",$alg); $alg = preg_replace("/VR-/","<501>",$alg);   $alg = preg_replace("/VR2/","<502>",$alg);   $alg = preg_replace("/VR/","<503>",$alg);
    $alg = preg_replace("/VL'/","<504>",$alg); $alg = preg_replace("/VL-/","<504>",$alg);   $alg = preg_replace("/VL2/","<505>",$alg);   $alg = preg_replace("/VL/","<506>",$alg);
    $alg = preg_replace("/VF'/","<507>",$alg); $alg = preg_replace("/VF-/","<507>",$alg);   $alg = preg_replace("/VF2/","<508>",$alg);   $alg = preg_replace("/VF/","<509>",$alg);
    $alg = preg_replace("/VB'/","<510>",$alg); $alg = preg_replace("/VB-/","<510>",$alg);   $alg = preg_replace("/VB2/","<511>",$alg);   $alg = preg_replace("/VB/","<512>",$alg);
    $alg = preg_replace("/VU'/","<513>",$alg); $alg = preg_replace("/VU-/","<513>",$alg);   $alg = preg_replace("/VU2/","<514>",$alg);   $alg = preg_replace("/VU/","<515>",$alg);
    $alg = preg_replace("/VD'/","<516>",$alg); $alg = preg_replace("/VD-/","<516>",$alg);   $alg = preg_replace("/VD2/","<517>",$alg);   $alg = preg_replace("/VD/","<518>",$alg);
    
    $alg = preg_replace("/N2-3R'/","<501>",$alg); $alg = preg_replace("/N2-3R-/","<501>",$alg);   $alg = preg_replace("/N2-3R2/","<502>",$alg);   $alg = preg_replace("/N2-3R/","<503>",$alg);
    $alg = preg_replace("/N2-3L'/","<504>",$alg); $alg = preg_replace("/N2-3L-/","<504>",$alg);   $alg = preg_replace("/N2-3L2/","<505>",$alg);   $alg = preg_replace("/N2-3L/","<506>",$alg);
    $alg = preg_replace("/N2-3F'/","<507>",$alg); $alg = preg_replace("/N2-3F-/","<507>",$alg);   $alg = preg_replace("/N2-3F2/","<508>",$alg);   $alg = preg_replace("/N2-3F/","<509>",$alg);
    $alg = preg_replace("/N2-3B'/","<510>",$alg); $alg = preg_replace("/N2-3B-/","<510>",$alg);   $alg = preg_replace("/N2-3B2/","<511>",$alg);   $alg = preg_replace("/N2-3B/","<512>",$alg);
    $alg = preg_replace("/N2-3U'/","<513>",$alg); $alg = preg_replace("/N2-3U-/","<513>",$alg);   $alg = preg_replace("/N2-3U2/","<514>",$alg);   $alg = preg_replace("/N2-3U/","<515>",$alg);
    $alg = preg_replace("/N2-3D'/","<516>",$alg); $alg = preg_replace("/N2-3D-/","<516>",$alg);   $alg = preg_replace("/N2-3D2/","<517>",$alg);   $alg = preg_replace("/N2-3D/","<518>",$alg);
    
    /* --- 4xC: SSE -> CODE: [7] Cube rotations --- */
    $alg = preg_replace("/CR'/","<701>",$alg); $alg = preg_replace("/CR-/","<701>",$alg);   $alg = preg_replace("/CR2/","<702>",$alg);   $alg = preg_replace("/CR/","<703>",$alg);
    $alg = preg_replace("/CL'/","<704>",$alg); $alg = preg_replace("/CL-/","<704>",$alg);   $alg = preg_replace("/CL2/","<705>",$alg);   $alg = preg_replace("/CL/","<706>",$alg);
    $alg = preg_replace("/CF'/","<707>",$alg); $alg = preg_replace("/CF-/","<707>",$alg);   $alg = preg_replace("/CF2/","<708>",$alg);   $alg = preg_replace("/CF/","<709>",$alg);
    $alg = preg_replace("/CB'/","<710>",$alg); $alg = preg_replace("/CB-/","<710>",$alg);   $alg = preg_replace("/CB2/","<711>",$alg);   $alg = preg_replace("/CB/","<712>",$alg);
    $alg = preg_replace("/CU'/","<713>",$alg); $alg = preg_replace("/CU-/","<713>",$alg);   $alg = preg_replace("/CU2/","<714>",$alg);   $alg = preg_replace("/CU/","<715>",$alg);
    $alg = preg_replace("/CD'/","<716>",$alg); $alg = preg_replace("/CD-/","<716>",$alg);   $alg = preg_replace("/CD2/","<717>",$alg);   $alg = preg_replace("/CD/","<718>",$alg);
    
    /* --- 4xC: SSE -> CODE: [9] Face twists --- */
    $alg = preg_replace("/R'/","<901>",$alg); $alg = preg_replace("/R-/","<901>",$alg);   $alg = preg_replace("/R2/","<902>",$alg);   $alg = preg_replace("/R/","<903>",$alg);
    $alg = preg_replace("/L'/","<904>",$alg); $alg = preg_replace("/L-/","<904>",$alg);   $alg = preg_replace("/L2/","<905>",$alg);   $alg = preg_replace("/L/","<906>",$alg);
    $alg = preg_replace("/F'/","<907>",$alg); $alg = preg_replace("/F-/","<907>",$alg);   $alg = preg_replace("/F2/","<908>",$alg);   $alg = preg_replace("/F/","<909>",$alg);
    $alg = preg_replace("/B'/","<910>",$alg); $alg = preg_replace("/B-/","<910>",$alg);   $alg = preg_replace("/B2/","<911>",$alg);   $alg = preg_replace("/B/","<912>",$alg);
    $alg = preg_replace("/U'/","<913>",$alg); $alg = preg_replace("/U-/","<913>",$alg);   $alg = preg_replace("/U2/","<914>",$alg);   $alg = preg_replace("/U/","<915>",$alg);
    $alg = preg_replace("/D'/","<916>",$alg); $alg = preg_replace("/D-/","<916>",$alg);   $alg = preg_replace("/D2/","<917>",$alg);   $alg = preg_replace("/D/","<918>",$alg);
    
    /* ··································································································· */
    /* --- 4xC: CODE -> TWIZZLE: [1] Numbered-layer twists --- */
    $alg = preg_replace("/<101>/","2R'",$alg);   $alg = preg_replace("/<102>/","2R2",$alg);   $alg = preg_replace("/<103>/","2R",$alg);
    $alg = preg_replace("/<104>/","2L'",$alg);   $alg = preg_replace("/<105>/","2L2",$alg);   $alg = preg_replace("/<106>/","2L",$alg);
    $alg = preg_replace("/<107>/","2F'",$alg);   $alg = preg_replace("/<108>/","2F2",$alg);   $alg = preg_replace("/<109>/","2F",$alg);
    $alg = preg_replace("/<110>/","2B'",$alg);   $alg = preg_replace("/<111>/","2B2",$alg);   $alg = preg_replace("/<112>/","2B",$alg);
    $alg = preg_replace("/<113>/","2U'",$alg);   $alg = preg_replace("/<114>/","2U2",$alg);   $alg = preg_replace("/<115>/","2U",$alg);
    $alg = preg_replace("/<116>/","2D'",$alg);   $alg = preg_replace("/<117>/","2D2",$alg);   $alg = preg_replace("/<118>/","2D",$alg);
    
    /* --- 4xC: CODE -> TWIZZLE: [2] Slice twists --- */
    $alg = preg_replace("/<201>/","R' L",$alg);   $alg = preg_replace("/<202>/","R2 L2",$alg);   $alg = preg_replace("/<203>/","R L'",$alg);
    $alg = preg_replace("/<204>/","R L'",$alg);   $alg = preg_replace("/<205>/","R2 L2",$alg);   $alg = preg_replace("/<206>/","R' L",$alg);
    $alg = preg_replace("/<207>/","F' B",$alg);   $alg = preg_replace("/<208>/","F2 B2",$alg);   $alg = preg_replace("/<209>/","F B'",$alg);
    $alg = preg_replace("/<210>/","F B'",$alg);   $alg = preg_replace("/<211>/","F2 B2",$alg);   $alg = preg_replace("/<212>/","F' B",$alg);
    $alg = preg_replace("/<213>/","U' D",$alg);   $alg = preg_replace("/<214>/","U2 D2",$alg);   $alg = preg_replace("/<215>/","U D'",$alg);
    $alg = preg_replace("/<216>/","U D'",$alg);   $alg = preg_replace("/<217>/","U2 D2",$alg);   $alg = preg_replace("/<218>/","U' D",$alg);
    
    $alg = preg_replace("/<219>/","R' l",$alg);   $alg = preg_replace("/<220>/","R2 l2",$alg);   $alg = preg_replace("/<221>/","R l'",$alg);
    $alg = preg_replace("/<222>/","r L'",$alg);   $alg = preg_replace("/<223>/","r2 L2",$alg);   $alg = preg_replace("/<224>/","r' L",$alg);
    $alg = preg_replace("/<225>/","F' b",$alg);   $alg = preg_replace("/<226>/","F2 b2",$alg);   $alg = preg_replace("/<227>/","F b'",$alg);
    $alg = preg_replace("/<228>/","f B'",$alg);   $alg = preg_replace("/<229>/","f2 B2",$alg);   $alg = preg_replace("/<230>/","f' B",$alg);
    $alg = preg_replace("/<231>/","U' d",$alg);   $alg = preg_replace("/<232>/","U2 d2",$alg);   $alg = preg_replace("/<233>/","U d'",$alg);
    $alg = preg_replace("/<234>/","u D'",$alg);   $alg = preg_replace("/<235>/","u2 D2",$alg);   $alg = preg_replace("/<236>/","u' D",$alg);
    
    /* --- 4xC: CODE -> TWIZZLE: [3] Tier twists --- */
    $alg = preg_replace("/<301>/","3r'",$alg);   $alg = preg_replace("/<302>/","3r2",$alg);   $alg = preg_replace("/<303>/","3r",$alg);
    $alg = preg_replace("/<304>/","3l'",$alg);   $alg = preg_replace("/<305>/","3l2",$alg);   $alg = preg_replace("/<306>/","3l",$alg);
    $alg = preg_replace("/<307>/","3f'",$alg);   $alg = preg_replace("/<308>/","3f2",$alg);   $alg = preg_replace("/<309>/","3f",$alg);
    $alg = preg_replace("/<310>/","3b'",$alg);   $alg = preg_replace("/<311>/","3b2",$alg);   $alg = preg_replace("/<312>/","3b",$alg);
    $alg = preg_replace("/<313>/","3u'",$alg);   $alg = preg_replace("/<314>/","3u2",$alg);   $alg = preg_replace("/<315>/","3u",$alg);
    $alg = preg_replace("/<316>/","3d'",$alg);   $alg = preg_replace("/<317>/","3d2",$alg);   $alg = preg_replace("/<318>/","3d",$alg);
    
    $alg = preg_replace("/<319>/","r'",$alg);   $alg = preg_replace("/<320>/","r2",$alg);   $alg = preg_replace("/<321>/","r",$alg);
    $alg = preg_replace("/<322>/","l'",$alg);   $alg = preg_replace("/<323>/","l2",$alg);   $alg = preg_replace("/<324>/","l",$alg);
    $alg = preg_replace("/<325>/","f'",$alg);   $alg = preg_replace("/<326>/","f2",$alg);   $alg = preg_replace("/<327>/","f",$alg);
    $alg = preg_replace("/<328>/","b'",$alg);   $alg = preg_replace("/<329>/","b2",$alg);   $alg = preg_replace("/<330>/","b",$alg);
    $alg = preg_replace("/<331>/","u'",$alg);   $alg = preg_replace("/<332>/","u2",$alg);   $alg = preg_replace("/<333>/","u",$alg);
    $alg = preg_replace("/<334>/","d'",$alg);   $alg = preg_replace("/<335>/","d2",$alg);   $alg = preg_replace("/<336>/","d",$alg);
    
    /* --- 4xC: CODE -> TWIZZLE: [6] Wide-layer twists [5] (Mid-layer twists) --- */
    if ($useSiGN == true) { // Bei SiGN:
      $alg = preg_replace("/<501>/","m",$alg);    $alg = preg_replace("/<502>/","m2",$alg);   $alg = preg_replace("/<503>/","m'",$alg);
      $alg = preg_replace("/<504>/","m'",$alg);   $alg = preg_replace("/<505>/","m2",$alg);   $alg = preg_replace("/<506>/","m",$alg);
      $alg = preg_replace("/<507>/","s'",$alg);   $alg = preg_replace("/<508>/","s2",$alg);   $alg = preg_replace("/<509>/","s",$alg);
      $alg = preg_replace("/<510>/","s",$alg);    $alg = preg_replace("/<511>/","s2",$alg);   $alg = preg_replace("/<512>/","s'",$alg);
      $alg = preg_replace("/<513>/","e",$alg);    $alg = preg_replace("/<514>/","e2",$alg);   $alg = preg_replace("/<515>/","e'",$alg);
      $alg = preg_replace("/<516>/","e'",$alg);   $alg = preg_replace("/<517>/","e2",$alg);   $alg = preg_replace("/<518>/","e",$alg);
    } else {               // Sonst (TWIZZLE):
      $alg = preg_replace("/<501>/","2-3R'",$alg);   $alg = preg_replace("/<502>/","2-3R2",$alg);   $alg = preg_replace("/<503>/","2-3R",$alg);
      $alg = preg_replace("/<504>/","2-3L'",$alg);   $alg = preg_replace("/<505>/","2-3L2",$alg);   $alg = preg_replace("/<506>/","2-3L",$alg);
      $alg = preg_replace("/<507>/","2-3F'",$alg);   $alg = preg_replace("/<508>/","2-3F2",$alg);   $alg = preg_replace("/<509>/","2-3F",$alg);
      $alg = preg_replace("/<510>/","2-3B'",$alg);   $alg = preg_replace("/<511>/","2-3B2",$alg);   $alg = preg_replace("/<512>/","2-3B",$alg);
      $alg = preg_replace("/<513>/","2-3U'",$alg);   $alg = preg_replace("/<514>/","2-3U2",$alg);   $alg = preg_replace("/<515>/","2-3U",$alg);
      $alg = preg_replace("/<516>/","2-3D'",$alg);   $alg = preg_replace("/<517>/","2-3D2",$alg);   $alg = preg_replace("/<518>/","2-3D",$alg);
    }
    
    /* --- 4xC: CODE -> TWIZZLE: [7] Cube rotations --- */
    if ($useSiGN == true) { // Bei SiGN:
      $alg = preg_replace("/<701>/","x'",$alg);   $alg = preg_replace("/<702>/","x2",$alg);   $alg = preg_replace("/<703>/","x",$alg);
      $alg = preg_replace("/<704>/","x",$alg);    $alg = preg_replace("/<705>/","x2",$alg);   $alg = preg_replace("/<706>/","x'",$alg);
      $alg = preg_replace("/<707>/","z'",$alg);   $alg = preg_replace("/<708>/","z2",$alg);   $alg = preg_replace("/<709>/","z",$alg);
      $alg = preg_replace("/<710>/","z",$alg);    $alg = preg_replace("/<711>/","z2",$alg);   $alg = preg_replace("/<712>/","z'",$alg);
      $alg = preg_replace("/<713>/","y'",$alg);   $alg = preg_replace("/<714>/","y2",$alg);   $alg = preg_replace("/<715>/","y",$alg);
      $alg = preg_replace("/<716>/","y",$alg);    $alg = preg_replace("/<717>/","y2",$alg);   $alg = preg_replace("/<718>/","y'",$alg);
    } else {               // Sonst (TWIZZLE):
      $alg = preg_replace("/<701>/","Rv'",$alg);   $alg = preg_replace("/<702>/","Rv2",$alg);   $alg = preg_replace("/<703>/","Rv",$alg);
      $alg = preg_replace("/<704>/","Rv",$alg);    $alg = preg_replace("/<705>/","Rv2",$alg);   $alg = preg_replace("/<706>/","Rv'",$alg);
      $alg = preg_replace("/<707>/","Fv'",$alg);   $alg = preg_replace("/<708>/","Fv2",$alg);   $alg = preg_replace("/<709>/","Fv",$alg);
      $alg = preg_replace("/<710>/","Fv",$alg);    $alg = preg_replace("/<711>/","Fv2",$alg);   $alg = preg_replace("/<712>/","Fv'",$alg);
      $alg = preg_replace("/<713>/","Uv'",$alg);   $alg = preg_replace("/<714>/","Uv2",$alg);   $alg = preg_replace("/<715>/","Uv",$alg);
      $alg = preg_replace("/<716>/","Uv",$alg);    $alg = preg_replace("/<717>/","Uv2",$alg);   $alg = preg_replace("/<718>/","Uv'",$alg);
    }
    
    /* --- 4xC: CODE -> TWIZZLE: [9] Face twists --- */
    $alg = preg_replace("/<901>/","R'",$alg);   $alg = preg_replace("/<902>/","R2",$alg);   $alg = preg_replace("/<903>/","R",$alg);
    $alg = preg_replace("/<904>/","L'",$alg);   $alg = preg_replace("/<905>/","L2",$alg);   $alg = preg_replace("/<906>/","L",$alg);
    $alg = preg_replace("/<907>/","F'",$alg);   $alg = preg_replace("/<908>/","F2",$alg);   $alg = preg_replace("/<909>/","F",$alg);
    $alg = preg_replace("/<910>/","B'",$alg);   $alg = preg_replace("/<911>/","B2",$alg);   $alg = preg_replace("/<912>/","B",$alg);
    $alg = preg_replace("/<913>/","U'",$alg);   $alg = preg_replace("/<914>/","U2",$alg);   $alg = preg_replace("/<915>/","U",$alg);
    $alg = preg_replace("/<916>/","D'",$alg);   $alg = preg_replace("/<917>/","D2",$alg);   $alg = preg_replace("/<918>/","D",$alg);
    
    return $alg;
  }
  
  
  
  
  /* 
  ---------------------------------------------------------------------------------------------------
  * alg4xC_TwizzleToSse($alg)
  * 
  * Converts 4x4 Revenge Cube TWIZZLE algorithms into SSE notation.
  * 
  * Parameter: $alg (STRING): The algorithm.
  * 
  * Return: STRING.
  ---------------------------------------------------------------------------------------------------
  */
  function alg4xC_TwizzleToSse($alg) {
    /* --- 4xC: Marker --- */
    $alg = str_replace(".","·",$alg);
    
    /* ··································································································· */
    /* --- 4xC: TWIZZLE -> CODE: [6] Wide layer twists --- */
    $alg = preg_replace("/2-3R'/","<601>",$alg); $alg = preg_replace("/2-3R2/","<602>",$alg); $alg = preg_replace("/2-3R/","<603>",$alg);
    $alg = preg_replace("/2-3L'/","<604>",$alg); $alg = preg_replace("/2-3L2/","<605>",$alg); $alg = preg_replace("/2-3L/","<606>",$alg);
    $alg = preg_replace("/2-3F'/","<607>",$alg); $alg = preg_replace("/2-3F2/","<608>",$alg); $alg = preg_replace("/2-3F/","<609>",$alg);
    $alg = preg_replace("/2-3B'/","<610>",$alg); $alg = preg_replace("/2-3B2/","<611>",$alg); $alg = preg_replace("/2-3B/","<612>",$alg);
    $alg = preg_replace("/2-3U'/","<613>",$alg); $alg = preg_replace("/2-3U2/","<614>",$alg); $alg = preg_replace("/2-3U/","<615>",$alg);
    $alg = preg_replace("/2-3D'/","<616>",$alg); $alg = preg_replace("/2-3D2/","<617>",$alg); $alg = preg_replace("/2-3D/","<618>",$alg);
    
    $alg = preg_replace("/m'/","<603>",$alg); $alg = preg_replace("/m2/","<602>",$alg); $alg = preg_replace("/m/","<601>",$alg);
    $alg = preg_replace("/s'/","<607>",$alg); $alg = preg_replace("/s2/","<608>",$alg); $alg = preg_replace("/s/","<609>",$alg);
    $alg = preg_replace("/e'/","<615>",$alg); $alg = preg_replace("/e2/","<614>",$alg); $alg = preg_replace("/e/","<613>",$alg);
    
    /* --- 4xC: TWIZZLE -> CODE: [3] Tier twists (WCA) --- */
    $alg = preg_replace("/3Rw'/","<301>",$alg); $alg = preg_replace("/3Rw2/","<302>",$alg); $alg = preg_replace("/3Rw/","<303>",$alg);
    $alg = preg_replace("/3Lw'/","<304>",$alg); $alg = preg_replace("/3Lw2/","<305>",$alg); $alg = preg_replace("/3Lw/","<306>",$alg);
    $alg = preg_replace("/3Fw'/","<307>",$alg); $alg = preg_replace("/3Fw2/","<308>",$alg); $alg = preg_replace("/3Fw/","<309>",$alg);
    $alg = preg_replace("/3Bw'/","<310>",$alg); $alg = preg_replace("/3Bw2/","<311>",$alg); $alg = preg_replace("/3Bw/","<312>",$alg);
    $alg = preg_replace("/3Uw'/","<313>",$alg); $alg = preg_replace("/3Uw2/","<314>",$alg); $alg = preg_replace("/3Uw/","<315>",$alg);
    $alg = preg_replace("/3Dw'/","<316>",$alg); $alg = preg_replace("/3Dw2/","<317>",$alg); $alg = preg_replace("/3Dw/","<318>",$alg);
    
    /* --- 4xC: TWIZZLE -> CODE: [1] Numbered layer twists --- */
    $alg = preg_replace("/2R'/","<101>",$alg); $alg = preg_replace("/2R2/","<102>",$alg); $alg = preg_replace("/2R/","<103>",$alg);
    $alg = preg_replace("/2L'/","<104>",$alg); $alg = preg_replace("/2L2/","<105>",$alg); $alg = preg_replace("/2L/","<106>",$alg);
    $alg = preg_replace("/2F'/","<107>",$alg); $alg = preg_replace("/2F2/","<108>",$alg); $alg = preg_replace("/2F/","<109>",$alg);
    $alg = preg_replace("/2B'/","<110>",$alg); $alg = preg_replace("/2B2/","<111>",$alg); $alg = preg_replace("/2B/","<112>",$alg);
    $alg = preg_replace("/2U'/","<113>",$alg); $alg = preg_replace("/2U2/","<114>",$alg); $alg = preg_replace("/2U/","<115>",$alg);
    $alg = preg_replace("/2D'/","<116>",$alg); $alg = preg_replace("/2D2/","<117>",$alg); $alg = preg_replace("/2D/","<118>",$alg);
    
    $alg = preg_replace("/3R'/","<106>",$alg); $alg = preg_replace("/3R2/","<105>",$alg); $alg = preg_replace("/3R/","<104>",$alg);
    $alg = preg_replace("/3L'/","<103>",$alg); $alg = preg_replace("/3L2/","<102>",$alg); $alg = preg_replace("/3L/","<101>",$alg);
    $alg = preg_replace("/3F'/","<112>",$alg); $alg = preg_replace("/3F2/","<111>",$alg); $alg = preg_replace("/3F/","<110>",$alg);
    $alg = preg_replace("/3B'/","<109>",$alg); $alg = preg_replace("/3B2/","<108>",$alg); $alg = preg_replace("/3B/","<107>",$alg);
    $alg = preg_replace("/3U'/","<118>",$alg); $alg = preg_replace("/3U2/","<117>",$alg); $alg = preg_replace("/3U/","<116>",$alg);
    $alg = preg_replace("/3D'/","<115>",$alg); $alg = preg_replace("/3D2/","<114>",$alg); $alg = preg_replace("/3D/","<113>",$alg);
    
    /* --- 4xC: TWIZZLE -> CODE: [3] Tier twists (SiGN) --- */
    $alg = preg_replace("/3r'/","<301>",$alg); $alg = preg_replace("/3r2/","<302>",$alg); $alg = preg_replace("/3r/","<303>",$alg);
    $alg = preg_replace("/3l'/","<304>",$alg); $alg = preg_replace("/3l2/","<305>",$alg); $alg = preg_replace("/3l/","<306>",$alg);
    $alg = preg_replace("/3f'/","<307>",$alg); $alg = preg_replace("/3f2/","<308>",$alg); $alg = preg_replace("/3f/","<309>",$alg);
    $alg = preg_replace("/3b'/","<310>",$alg); $alg = preg_replace("/3b2/","<311>",$alg); $alg = preg_replace("/3b/","<312>",$alg);
    $alg = preg_replace("/3u'/","<313>",$alg); $alg = preg_replace("/3u2/","<314>",$alg); $alg = preg_replace("/3u/","<315>",$alg);
    $alg = preg_replace("/3d'/","<316>",$alg); $alg = preg_replace("/3d2/","<317>",$alg); $alg = preg_replace("/3d/","<318>",$alg);
    
    /* --- 4xC: TWIZZLE -> CODE: [3] Tier twists (WCA) --- */
    $alg = preg_replace("/Rw'/","<319>",$alg); $alg = preg_replace("/Rw2/","<320>",$alg); $alg = preg_replace("/Rw/","<321>",$alg);
    $alg = preg_replace("/Lw'/","<322>",$alg); $alg = preg_replace("/Lw2/","<323>",$alg); $alg = preg_replace("/Lw/","<324>",$alg);
    $alg = preg_replace("/Fw'/","<325>",$alg); $alg = preg_replace("/Fw2/","<326>",$alg); $alg = preg_replace("/Fw/","<327>",$alg);
    $alg = preg_replace("/Bw'/","<328>",$alg); $alg = preg_replace("/Bw2/","<329>",$alg); $alg = preg_replace("/Bw/","<330>",$alg);
    $alg = preg_replace("/Uw'/","<331>",$alg); $alg = preg_replace("/Uw2/","<332>",$alg); $alg = preg_replace("/Uw/","<333>",$alg);
    $alg = preg_replace("/Dw'/","<334>",$alg); $alg = preg_replace("/Dw2/","<335>",$alg); $alg = preg_replace("/Dw/","<336>",$alg);
    
    /* --- 4xC: TWIZZLE -> CODE: [7] Cube rotations --- */
    $alg = preg_replace("/Rv'/","<701>",$alg); $alg = preg_replace("/Rv2/","<702>",$alg); $alg = preg_replace("/Rv/","<703>",$alg);
    $alg = preg_replace("/Lv'/","<703>",$alg); $alg = preg_replace("/Lv2/","<702>",$alg); $alg = preg_replace("/Lv/","<701>",$alg);
    $alg = preg_replace("/Fv'/","<704>",$alg); $alg = preg_replace("/Fv2/","<705>",$alg); $alg = preg_replace("/Fv/","<706>",$alg);
    $alg = preg_replace("/Bv'/","<706>",$alg); $alg = preg_replace("/Bv2/","<705>",$alg); $alg = preg_replace("/Bv/","<704>",$alg);
    $alg = preg_replace("/Uv'/","<707>",$alg); $alg = preg_replace("/Uv2/","<708>",$alg); $alg = preg_replace("/Uv/","<709>",$alg);
    $alg = preg_replace("/Dv'/","<709>",$alg); $alg = preg_replace("/Dv2/","<708>",$alg); $alg = preg_replace("/Dv/","<707>",$alg);
    
    $alg = preg_replace("/x'/","<701>",$alg); $alg = preg_replace("/x2/","<702>",$alg); $alg = preg_replace("/x/","<703>",$alg);
    $alg = preg_replace("/z'/","<704>",$alg); $alg = preg_replace("/z2/","<705>",$alg); $alg = preg_replace("/z/","<706>",$alg);
    $alg = preg_replace("/y'/","<707>",$alg); $alg = preg_replace("/y2/","<708>",$alg); $alg = preg_replace("/y/","<709>",$alg);
    
    /* --- 4xC: TWIZZLE -> CODE: [9] Face twists --- */
    $alg = preg_replace("/R'/","<901>",$alg); $alg = preg_replace("/R2/","<902>",$alg); $alg = preg_replace("/R/","<903>",$alg);
    $alg = preg_replace("/L'/","<904>",$alg); $alg = preg_replace("/L2/","<905>",$alg); $alg = preg_replace("/L/","<906>",$alg);
    $alg = preg_replace("/F'/","<907>",$alg); $alg = preg_replace("/F2/","<908>",$alg); $alg = preg_replace("/F/","<909>",$alg);
    $alg = preg_replace("/B'/","<910>",$alg); $alg = preg_replace("/B2/","<911>",$alg); $alg = preg_replace("/B/","<912>",$alg);
    $alg = preg_replace("/U'/","<913>",$alg); $alg = preg_replace("/U2/","<914>",$alg); $alg = preg_replace("/U/","<915>",$alg);
    $alg = preg_replace("/D'/","<916>",$alg); $alg = preg_replace("/D2/","<917>",$alg); $alg = preg_replace("/D/","<918>",$alg);
    
    /* --- 4xC: TWIZZLE -> CODE: [3] Tier twists (SiGN) --- */
    $alg = preg_replace("/r'/","<319>",$alg); $alg = preg_replace("/r2/","<320>",$alg); $alg = preg_replace("/r/","<321>",$alg);
    $alg = preg_replace("/l'/","<322>",$alg); $alg = preg_replace("/l2/","<323>",$alg); $alg = preg_replace("/l/","<324>",$alg);
    $alg = preg_replace("/f'/","<325>",$alg); $alg = preg_replace("/f2/","<326>",$alg); $alg = preg_replace("/f/","<327>",$alg);
    $alg = preg_replace("/b'/","<328>",$alg); $alg = preg_replace("/b2/","<329>",$alg); $alg = preg_replace("/b/","<330>",$alg);
    $alg = preg_replace("/u'/","<331>",$alg); $alg = preg_replace("/u2/","<332>",$alg); $alg = preg_replace("/u/","<333>",$alg);
    $alg = preg_replace("/d'/","<334>",$alg); $alg = preg_replace("/d2/","<335>",$alg); $alg = preg_replace("/d/","<336>",$alg);
    
    /* ··································································································· */
    /* --- 4xC: CODE -> SSE: [6] Wide layer twists --- */
    $alg = preg_replace("/<601>/","WR'",$alg); $alg = preg_replace("/<602>/","WR2",$alg); $alg = preg_replace("/<603>/","WR",$alg);
    $alg = preg_replace("/<604>/","WL'",$alg); $alg = preg_replace("/<605>/","WL2",$alg); $alg = preg_replace("/<606>/","WL",$alg);
    $alg = preg_replace("/<607>/","WF'",$alg); $alg = preg_replace("/<608>/","WF2",$alg); $alg = preg_replace("/<609>/","WF",$alg);
    $alg = preg_replace("/<610>/","WB'",$alg); $alg = preg_replace("/<611>/","WB2",$alg); $alg = preg_replace("/<612>/","WB",$alg);
    $alg = preg_replace("/<613>/","WU'",$alg); $alg = preg_replace("/<614>/","WU2",$alg); $alg = preg_replace("/<615>/","WU",$alg);
    $alg = preg_replace("/<616>/","WD'",$alg); $alg = preg_replace("/<617>/","WD2",$alg); $alg = preg_replace("/<618>/","WD",$alg);
    
    /* --- 4xC: CODE -> SSE: [1] Numbered layer twists --- */
    $alg = preg_replace("/<101>/","MR'",$alg); $alg = preg_replace("/<102>/","MR2",$alg); $alg = preg_replace("/<103>/","MR",$alg);
    $alg = preg_replace("/<104>/","ML'",$alg); $alg = preg_replace("/<105>/","ML2",$alg); $alg = preg_replace("/<106>/","ML",$alg);
    $alg = preg_replace("/<107>/","MF'",$alg); $alg = preg_replace("/<108>/","MF2",$alg); $alg = preg_replace("/<109>/","MF",$alg);
    $alg = preg_replace("/<110>/","MB'",$alg); $alg = preg_replace("/<111>/","MB2",$alg); $alg = preg_replace("/<112>/","MB",$alg);
    $alg = preg_replace("/<113>/","MU'",$alg); $alg = preg_replace("/<114>/","MU2",$alg); $alg = preg_replace("/<115>/","MU",$alg);
    $alg = preg_replace("/<116>/","MD'",$alg); $alg = preg_replace("/<117>/","MD2",$alg); $alg = preg_replace("/<118>/","MD",$alg);
    
    /* --- 4xC: CODE -> SSE: [3] Tier twists --- */
    $alg = preg_replace("/<301>/","T3R'",$alg); $alg = preg_replace("/<302>/","T3R2",$alg); $alg = preg_replace("/<303>/","T3R",$alg);
    $alg = preg_replace("/<304>/","T3L'",$alg); $alg = preg_replace("/<305>/","T3L2",$alg); $alg = preg_replace("/<306>/","T3L",$alg);
    $alg = preg_replace("/<307>/","T3F'",$alg); $alg = preg_replace("/<308>/","T3F2",$alg); $alg = preg_replace("/<309>/","T3F",$alg);
    $alg = preg_replace("/<310>/","T3B'",$alg); $alg = preg_replace("/<311>/","T3B2",$alg); $alg = preg_replace("/<312>/","T3B",$alg);
    $alg = preg_replace("/<313>/","T3U'",$alg); $alg = preg_replace("/<314>/","T3U2",$alg); $alg = preg_replace("/<315>/","T3U",$alg);
    $alg = preg_replace("/<316>/","T3D'",$alg); $alg = preg_replace("/<317>/","T3D2",$alg); $alg = preg_replace("/<318>/","T3D",$alg);
    
    $alg = preg_replace("/<319>/","TR'",$alg); $alg = preg_replace("/<320>/","TR2",$alg); $alg = preg_replace("/<321>/","TR",$alg);
    $alg = preg_replace("/<322>/","TL'",$alg); $alg = preg_replace("/<323>/","TL2",$alg); $alg = preg_replace("/<324>/","TL",$alg);
    $alg = preg_replace("/<325>/","TF'",$alg); $alg = preg_replace("/<326>/","TF2",$alg); $alg = preg_replace("/<327>/","TF",$alg);
    $alg = preg_replace("/<328>/","TB'",$alg); $alg = preg_replace("/<329>/","TB2",$alg); $alg = preg_replace("/<330>/","TB",$alg);
    $alg = preg_replace("/<331>/","TU'",$alg); $alg = preg_replace("/<332>/","TU2",$alg); $alg = preg_replace("/<333>/","TU",$alg);
    $alg = preg_replace("/<334>/","TD'",$alg); $alg = preg_replace("/<335>/","TD2",$alg); $alg = preg_replace("/<336>/","TD",$alg);
    
    /* --- 4xC: CODE -> SSE: [7] Cube rotations --- */
    $alg = preg_replace("/<701>/","CR'",$alg); $alg = preg_replace("/<702>/","CR2",$alg); $alg = preg_replace("/<703>/","CR",$alg);
    $alg = preg_replace("/<704>/","CF'",$alg); $alg = preg_replace("/<705>/","CF2",$alg); $alg = preg_replace("/<706>/","CF",$alg);
    $alg = preg_replace("/<707>/","CU'",$alg); $alg = preg_replace("/<708>/","CU2",$alg); $alg = preg_replace("/<709>/","CU",$alg);
    
    /* --- 4xC: CODE -> SSE: [9] Face twists --- */
    $alg = preg_replace("/<901>/","R'",$alg); $alg = preg_replace("/<902>/","R2",$alg); $alg = preg_replace("/<903>/","R",$alg);
    $alg = preg_replace("/<904>/","L'",$alg); $alg = preg_replace("/<905>/","L2",$alg); $alg = preg_replace("/<906>/","L",$alg);
    $alg = preg_replace("/<907>/","F'",$alg); $alg = preg_replace("/<908>/","F2",$alg); $alg = preg_replace("/<909>/","F",$alg);
    $alg = preg_replace("/<910>/","B'",$alg); $alg = preg_replace("/<911>/","B2",$alg); $alg = preg_replace("/<912>/","B",$alg);
    $alg = preg_replace("/<913>/","U'",$alg); $alg = preg_replace("/<914>/","U2",$alg); $alg = preg_replace("/<915>/","U",$alg);
    $alg = preg_replace("/<916>/","D'",$alg); $alg = preg_replace("/<917>/","D2",$alg); $alg = preg_replace("/<918>/","D",$alg);
    
    return $alg;
  }
  
  
  
  
  /* 
  ---------------------------------------------------------------------------------------------------
  * alg5xC_SseToTwizzle($alg)
  * 
  * Converts 5x5 Professor Cube SSE algorithms into TWIZZLE notation.
  * 
  * Parameter: $alg (STRING): The algorithm.
  * 
  * Return: STRING.
  ---------------------------------------------------------------------------------------------------
  */
  function alg5xC_SseToTwizzle($alg) {
    /* --- 5xC: Preferences --- */
    $useSiGN    = false; // Notation style: SiGN or TWIZZLE (Default).
    $useMarkers = false; // 01.04.2021: Unfortunately Twizzle Explorer doesn't handle Markers correctly!
    
    /* --- 5xC: Marker --- */
    if ($useMarkers != true) {
      $alg = str_replace("·","",$alg); $alg = str_replace(".","",$alg); // Remove Markers!
    } else {
      $alg = str_replace("·",".",$alg);
    }
    
    /* ··································································································· */
    /* --- 5xC: SSE -> CODE: [1] Numbered-layer twists --- */
    $alg = preg_replace("/NR'/","<101>",$alg); $alg = preg_replace("/NR-/","<101>",$alg);   $alg = preg_replace("/NR2/","<102>",$alg);   $alg = preg_replace("/NR/","<103>",$alg);
    $alg = preg_replace("/NL'/","<104>",$alg); $alg = preg_replace("/NL-/","<104>",$alg);   $alg = preg_replace("/NL2/","<105>",$alg);   $alg = preg_replace("/NL/","<106>",$alg);
    $alg = preg_replace("/NF'/","<107>",$alg); $alg = preg_replace("/NF-/","<107>",$alg);   $alg = preg_replace("/NF2/","<108>",$alg);   $alg = preg_replace("/NF/","<109>",$alg);
    $alg = preg_replace("/NB'/","<110>",$alg); $alg = preg_replace("/NB-/","<110>",$alg);   $alg = preg_replace("/NB2/","<111>",$alg);   $alg = preg_replace("/NB/","<112>",$alg);
    $alg = preg_replace("/NU'/","<113>",$alg); $alg = preg_replace("/NU-/","<113>",$alg);   $alg = preg_replace("/NU2/","<114>",$alg);   $alg = preg_replace("/NU/","<115>",$alg);
    $alg = preg_replace("/ND'/","<116>",$alg); $alg = preg_replace("/ND-/","<116>",$alg);   $alg = preg_replace("/ND2/","<117>",$alg);   $alg = preg_replace("/ND/","<118>",$alg);
    
    $alg = preg_replace("/N4R'/","<106>",$alg); $alg = preg_replace("/N4R-/","<106>",$alg);   $alg = preg_replace("/N4R2/","<105>",$alg);   $alg = preg_replace("/N4R/","<104>",$alg);
    $alg = preg_replace("/N4L'/","<103>",$alg); $alg = preg_replace("/N4L-/","<103>",$alg);   $alg = preg_replace("/N4L2/","<102>",$alg);   $alg = preg_replace("/N4L/","<101>",$alg);
    $alg = preg_replace("/N4F'/","<112>",$alg); $alg = preg_replace("/N4F-/","<112>",$alg);   $alg = preg_replace("/N4F2/","<111>",$alg);   $alg = preg_replace("/N4F/","<110>",$alg);
    $alg = preg_replace("/N4B'/","<109>",$alg); $alg = preg_replace("/N4B-/","<109>",$alg);   $alg = preg_replace("/N4B2/","<108>",$alg);   $alg = preg_replace("/N4B/","<107>",$alg);
    $alg = preg_replace("/N4U'/","<118>",$alg); $alg = preg_replace("/N4U-/","<118>",$alg);   $alg = preg_replace("/N4U2/","<117>",$alg);   $alg = preg_replace("/N4U/","<116>",$alg);
    $alg = preg_replace("/N4D'/","<115>",$alg); $alg = preg_replace("/N4D-/","<115>",$alg);   $alg = preg_replace("/N4D2/","<114>",$alg);   $alg = preg_replace("/N4D/","<113>",$alg);
    
    $alg = preg_replace("/N3R'/","<119>",$alg); $alg = preg_replace("/N3R-/","<119>",$alg);   $alg = preg_replace("/N3R2/","<120>",$alg);   $alg = preg_replace("/N3R/","<121>",$alg);
    $alg = preg_replace("/N3L'/","<122>",$alg); $alg = preg_replace("/N3L-/","<122>",$alg);   $alg = preg_replace("/N3L2/","<123>",$alg);   $alg = preg_replace("/N3L/","<124>",$alg);
    $alg = preg_replace("/N3F'/","<125>",$alg); $alg = preg_replace("/N3F-/","<125>",$alg);   $alg = preg_replace("/N3F2/","<126>",$alg);   $alg = preg_replace("/N3F/","<127>",$alg);
    $alg = preg_replace("/N3B'/","<128>",$alg); $alg = preg_replace("/N3B-/","<128>",$alg);   $alg = preg_replace("/N3B2/","<129>",$alg);   $alg = preg_replace("/N3B/","<130>",$alg);
    $alg = preg_replace("/N3U'/","<131>",$alg); $alg = preg_replace("/N3U-/","<131>",$alg);   $alg = preg_replace("/N3U2/","<132>",$alg);   $alg = preg_replace("/N3U/","<133>",$alg);
    $alg = preg_replace("/N3D'/","<134>",$alg); $alg = preg_replace("/N3D-/","<134>",$alg);   $alg = preg_replace("/N3D2/","<135>",$alg);   $alg = preg_replace("/N3D/","<136>",$alg);
    
    $alg = preg_replace("/MR'/","<119>",$alg); $alg = preg_replace("/MR-/","<119>",$alg);   $alg = preg_replace("/MR2/","<120>",$alg);   $alg = preg_replace("/MR/","<121>",$alg);
    $alg = preg_replace("/ML'/","<122>",$alg); $alg = preg_replace("/ML-/","<122>",$alg);   $alg = preg_replace("/ML2/","<123>",$alg);   $alg = preg_replace("/ML/","<124>",$alg);
    $alg = preg_replace("/MF'/","<125>",$alg); $alg = preg_replace("/MF-/","<125>",$alg);   $alg = preg_replace("/MF2/","<126>",$alg);   $alg = preg_replace("/MF/","<127>",$alg);
    $alg = preg_replace("/MB'/","<128>",$alg); $alg = preg_replace("/MB-/","<128>",$alg);   $alg = preg_replace("/MB2/","<129>",$alg);   $alg = preg_replace("/MB/","<130>",$alg);
    $alg = preg_replace("/MU'/","<131>",$alg); $alg = preg_replace("/MU-/","<131>",$alg);   $alg = preg_replace("/MU2/","<132>",$alg);   $alg = preg_replace("/MU/","<133>",$alg);
    $alg = preg_replace("/MD'/","<134>",$alg); $alg = preg_replace("/MD-/","<134>",$alg);   $alg = preg_replace("/MD2/","<135>",$alg);   $alg = preg_replace("/MD/","<136>",$alg);
    
    /* --- 5xC: SSE -> CODE: [2] Slice twists --- */
    $alg = preg_replace("/S2R'/","<201>",$alg); $alg = preg_replace("/S2R-/","<201>",$alg);   $alg = preg_replace("/S2R2/","<202>",$alg);   $alg = preg_replace("/S2R/","<203>",$alg);
    $alg = preg_replace("/S2L'/","<204>",$alg); $alg = preg_replace("/S2L-/","<204>",$alg);   $alg = preg_replace("/S2L2/","<205>",$alg);   $alg = preg_replace("/S2L/","<206>",$alg);
    $alg = preg_replace("/S2F'/","<207>",$alg); $alg = preg_replace("/S2F-/","<207>",$alg);   $alg = preg_replace("/S2F2/","<208>",$alg);   $alg = preg_replace("/S2F/","<209>",$alg);
    $alg = preg_replace("/S2B'/","<210>",$alg); $alg = preg_replace("/S2B-/","<210>",$alg);   $alg = preg_replace("/S2B2/","<211>",$alg);   $alg = preg_replace("/S2B/","<212>",$alg);
    $alg = preg_replace("/S2U'/","<213>",$alg); $alg = preg_replace("/S2U-/","<213>",$alg);   $alg = preg_replace("/S2U2/","<214>",$alg);   $alg = preg_replace("/S2U/","<215>",$alg);
    $alg = preg_replace("/S2D'/","<216>",$alg); $alg = preg_replace("/S2D-/","<216>",$alg);   $alg = preg_replace("/S2D2/","<217>",$alg);   $alg = preg_replace("/S2D/","<218>",$alg);
    
    $alg = preg_replace("/SR'/","<219>",$alg); $alg = preg_replace("/SR-/","<219>",$alg);   $alg = preg_replace("/SR2/","<220>",$alg);   $alg = preg_replace("/SR/","<221>",$alg);
    $alg = preg_replace("/SL'/","<222>",$alg); $alg = preg_replace("/SL-/","<222>",$alg);   $alg = preg_replace("/SL2/","<223>",$alg);   $alg = preg_replace("/SL/","<224>",$alg);
    $alg = preg_replace("/SF'/","<225>",$alg); $alg = preg_replace("/SF-/","<225>",$alg);   $alg = preg_replace("/SF2/","<226>",$alg);   $alg = preg_replace("/SF/","<227>",$alg);
    $alg = preg_replace("/SB'/","<228>",$alg); $alg = preg_replace("/SB-/","<228>",$alg);   $alg = preg_replace("/SB2/","<229>",$alg);   $alg = preg_replace("/SB/","<230>",$alg);
    $alg = preg_replace("/SU'/","<231>",$alg); $alg = preg_replace("/SU-/","<231>",$alg);   $alg = preg_replace("/SU2/","<232>",$alg);   $alg = preg_replace("/SU/","<233>",$alg);
    $alg = preg_replace("/SD'/","<234>",$alg); $alg = preg_replace("/SD-/","<234>",$alg);   $alg = preg_replace("/SD2/","<235>",$alg);   $alg = preg_replace("/SD/","<236>",$alg);
    
    $alg = preg_replace("/S2-2R'/","<237>",$alg); $alg = preg_replace("/S2-2R-/","<237>",$alg);   $alg = preg_replace("/S2-2R2/","<238>",$alg);   $alg = preg_replace("/S2-2R/","<239>",$alg);
    $alg = preg_replace("/S2-2L'/","<240>",$alg); $alg = preg_replace("/S2-2L-/","<240>",$alg);   $alg = preg_replace("/S2-2L2/","<241>",$alg);   $alg = preg_replace("/S2-2L/","<242>",$alg);
    $alg = preg_replace("/S2-2F'/","<243>",$alg); $alg = preg_replace("/S2-2F-/","<243>",$alg);   $alg = preg_replace("/S2-2F2/","<244>",$alg);   $alg = preg_replace("/S2-2F/","<245>",$alg);
    $alg = preg_replace("/S2-2B'/","<246>",$alg); $alg = preg_replace("/S2-2B-/","<246>",$alg);   $alg = preg_replace("/S2-2B2/","<247>",$alg);   $alg = preg_replace("/S2-2B/","<248>",$alg);
    $alg = preg_replace("/S2-2U'/","<249>",$alg); $alg = preg_replace("/S2-2U-/","<249>",$alg);   $alg = preg_replace("/S2-2U2/","<250>",$alg);   $alg = preg_replace("/S2-2U/","<251>",$alg);
    $alg = preg_replace("/S2-2D'/","<252>",$alg); $alg = preg_replace("/S2-2D-/","<252>",$alg);   $alg = preg_replace("/S2-2D2/","<253>",$alg);   $alg = preg_replace("/S2-2D/","<254>",$alg);
    
    $alg = preg_replace("/S2-3R'/","<255>",$alg); $alg = preg_replace("/S2-3R-/","<255>",$alg);   $alg = preg_replace("/S2-3R2/","<256>",$alg);   $alg = preg_replace("/S2-3R/","<257>",$alg);
    $alg = preg_replace("/S2-3L'/","<258>",$alg); $alg = preg_replace("/S2-3L-/","<258>",$alg);   $alg = preg_replace("/S2-3L2/","<259>",$alg);   $alg = preg_replace("/S2-3L/","<260>",$alg);
    $alg = preg_replace("/S2-3F'/","<261>",$alg); $alg = preg_replace("/S2-3F-/","<261>",$alg);   $alg = preg_replace("/S2-3F2/","<262>",$alg);   $alg = preg_replace("/S2-3F/","<263>",$alg);
    $alg = preg_replace("/S2-3B'/","<264>",$alg); $alg = preg_replace("/S2-3B-/","<264>",$alg);   $alg = preg_replace("/S2-3B2/","<265>",$alg);   $alg = preg_replace("/S2-3B/","<266>",$alg);
    $alg = preg_replace("/S2-3U'/","<267>",$alg); $alg = preg_replace("/S2-3U-/","<267>",$alg);   $alg = preg_replace("/S2-3U2/","<268>",$alg);   $alg = preg_replace("/S2-3U/","<269>",$alg);
    $alg = preg_replace("/S2-3D'/","<270>",$alg); $alg = preg_replace("/S2-3D-/","<270>",$alg);   $alg = preg_replace("/S2-3D2/","<271>",$alg);   $alg = preg_replace("/S2-3D/","<272>",$alg);
    
    /* --- 5xC: SSE -> CODE: [3] Tier twists --- */
    $alg = preg_replace("/T4R'/","<301>",$alg); $alg = preg_replace("/T4R-/","<301>",$alg);   $alg = preg_replace("/T4R2/","<302>",$alg);   $alg = preg_replace("/T4R/","<303>",$alg);
    $alg = preg_replace("/T4L'/","<304>",$alg); $alg = preg_replace("/T4L-/","<304>",$alg);   $alg = preg_replace("/T4L2/","<305>",$alg);   $alg = preg_replace("/T4L/","<306>",$alg);
    $alg = preg_replace("/T4F'/","<307>",$alg); $alg = preg_replace("/T4F-/","<307>",$alg);   $alg = preg_replace("/T4F2/","<308>",$alg);   $alg = preg_replace("/T4F/","<309>",$alg);
    $alg = preg_replace("/T4B'/","<310>",$alg); $alg = preg_replace("/T4B-/","<310>",$alg);   $alg = preg_replace("/T4B2/","<311>",$alg);   $alg = preg_replace("/T4B/","<312>",$alg);
    $alg = preg_replace("/T4U'/","<313>",$alg); $alg = preg_replace("/T4U-/","<313>",$alg);   $alg = preg_replace("/T4U2/","<314>",$alg);   $alg = preg_replace("/T4U/","<315>",$alg);
    $alg = preg_replace("/T4D'/","<316>",$alg); $alg = preg_replace("/T4D-/","<316>",$alg);   $alg = preg_replace("/T4D2/","<317>",$alg);   $alg = preg_replace("/T4D/","<318>",$alg);
    
    $alg = preg_replace("/T3R'/","<319>",$alg); $alg = preg_replace("/T3R-/","<319>",$alg);   $alg = preg_replace("/T3R2/","<320>",$alg);   $alg = preg_replace("/T3R/","<321>",$alg);
    $alg = preg_replace("/T3L'/","<322>",$alg); $alg = preg_replace("/T3L-/","<322>",$alg);   $alg = preg_replace("/T3L2/","<323>",$alg);   $alg = preg_replace("/T3L/","<324>",$alg);
    $alg = preg_replace("/T3F'/","<325>",$alg); $alg = preg_replace("/T3F-/","<325>",$alg);   $alg = preg_replace("/T3F2/","<326>",$alg);   $alg = preg_replace("/T3F/","<327>",$alg);
    $alg = preg_replace("/T3B'/","<328>",$alg); $alg = preg_replace("/T3B-/","<328>",$alg);   $alg = preg_replace("/T3B2/","<329>",$alg);   $alg = preg_replace("/T3B/","<330>",$alg);
    $alg = preg_replace("/T3U'/","<331>",$alg); $alg = preg_replace("/T3U-/","<331>",$alg);   $alg = preg_replace("/T3U2/","<332>",$alg);   $alg = preg_replace("/T3U/","<333>",$alg);
    $alg = preg_replace("/T3D'/","<334>",$alg); $alg = preg_replace("/T3D-/","<334>",$alg);   $alg = preg_replace("/T3D2/","<335>",$alg);   $alg = preg_replace("/T3D/","<336>",$alg);
    
    $alg = preg_replace("/TR'/","<337>",$alg); $alg = preg_replace("/TR-/","<337>",$alg);   $alg = preg_replace("/TR2/","<338>",$alg);   $alg = preg_replace("/TR/","<339>",$alg);
    $alg = preg_replace("/TL'/","<340>",$alg); $alg = preg_replace("/TL-/","<340>",$alg);   $alg = preg_replace("/TL2/","<341>",$alg);   $alg = preg_replace("/TL/","<342>",$alg);
    $alg = preg_replace("/TF'/","<343>",$alg); $alg = preg_replace("/TF-/","<343>",$alg);   $alg = preg_replace("/TF2/","<344>",$alg);   $alg = preg_replace("/TF/","<345>",$alg);
    $alg = preg_replace("/TB'/","<346>",$alg); $alg = preg_replace("/TB-/","<346>",$alg);   $alg = preg_replace("/TB2/","<347>",$alg);   $alg = preg_replace("/TB/","<348>",$alg);
    $alg = preg_replace("/TU'/","<349>",$alg); $alg = preg_replace("/TU-/","<349>",$alg);   $alg = preg_replace("/TU2/","<350>",$alg);   $alg = preg_replace("/TU/","<351>",$alg);
    $alg = preg_replace("/TD'/","<352>",$alg); $alg = preg_replace("/TD-/","<352>",$alg);   $alg = preg_replace("/TD2/","<353>",$alg);   $alg = preg_replace("/TD/","<354>",$alg);
    
    /* --- 5xC: SSE -> CODE: [4] Void twists [1] Numbered layer twists --- */
    $alg = preg_replace("/VR'/","<401>",$alg); $alg = preg_replace("/VR-/","<401>",$alg);   $alg = preg_replace("/VR2/","<402>",$alg);   $alg = preg_replace("/VR/","<403>",$alg);
    $alg = preg_replace("/VL'/","<404>",$alg); $alg = preg_replace("/VL-/","<404>",$alg);   $alg = preg_replace("/VL2/","<405>",$alg);   $alg = preg_replace("/VL/","<406>",$alg);
    $alg = preg_replace("/VF'/","<407>",$alg); $alg = preg_replace("/VF-/","<407>",$alg);   $alg = preg_replace("/VF2/","<408>",$alg);   $alg = preg_replace("/VF/","<409>",$alg);
    $alg = preg_replace("/VB'/","<410>",$alg); $alg = preg_replace("/VB-/","<410>",$alg);   $alg = preg_replace("/VB2/","<411>",$alg);   $alg = preg_replace("/VB/","<412>",$alg);
    $alg = preg_replace("/VU'/","<413>",$alg); $alg = preg_replace("/VU-/","<413>",$alg);   $alg = preg_replace("/VU2/","<414>",$alg);   $alg = preg_replace("/VU/","<415>",$alg);
    $alg = preg_replace("/VD'/","<416>",$alg); $alg = preg_replace("/VD-/","<416>",$alg);   $alg = preg_replace("/VD2/","<417>",$alg);   $alg = preg_replace("/VD/","<418>",$alg);
    
    $alg = preg_replace("/N2-3R'/","<401>",$alg); $alg = preg_replace("/N2-3R-/","<401>",$alg);   $alg = preg_replace("/N2-3R2/","<402>",$alg);   $alg = preg_replace("/N2-3R/","<403>",$alg);
    $alg = preg_replace("/N2-3L'/","<404>",$alg); $alg = preg_replace("/N2-3L-/","<404>",$alg);   $alg = preg_replace("/N2-3L2/","<405>",$alg);   $alg = preg_replace("/N2-3L/","<406>",$alg);
    $alg = preg_replace("/N2-3F'/","<407>",$alg); $alg = preg_replace("/N2-3F-/","<407>",$alg);   $alg = preg_replace("/N2-3F2/","<408>",$alg);   $alg = preg_replace("/N2-3F/","<409>",$alg);
    $alg = preg_replace("/N2-3B'/","<410>",$alg); $alg = preg_replace("/N2-3B-/","<410>",$alg);   $alg = preg_replace("/N2-3B2/","<411>",$alg);   $alg = preg_replace("/N2-3B/","<412>",$alg);
    $alg = preg_replace("/N2-3U'/","<413>",$alg); $alg = preg_replace("/N2-3U-/","<413>",$alg);   $alg = preg_replace("/N2-3U2/","<414>",$alg);   $alg = preg_replace("/N2-3U/","<415>",$alg);
    $alg = preg_replace("/N2-3D'/","<416>",$alg); $alg = preg_replace("/N2-3D-/","<416>",$alg);   $alg = preg_replace("/N2-3D2/","<417>",$alg);   $alg = preg_replace("/N2-3D/","<418>",$alg);
    
    $alg = preg_replace("/M2R'/","<401>",$alg); $alg = preg_replace("/M2R-/","<401>",$alg);   $alg = preg_replace("/M2R2/","<402>",$alg);   $alg = preg_replace("/M2R/","<403>",$alg);
    $alg = preg_replace("/M2L'/","<404>",$alg); $alg = preg_replace("/M2L-/","<404>",$alg);   $alg = preg_replace("/M2L2/","<405>",$alg);   $alg = preg_replace("/M2L/","<406>",$alg);
    $alg = preg_replace("/M2F'/","<407>",$alg); $alg = preg_replace("/M2F-/","<407>",$alg);   $alg = preg_replace("/M2F2/","<408>",$alg);   $alg = preg_replace("/M2F/","<409>",$alg);
    $alg = preg_replace("/M2B'/","<410>",$alg); $alg = preg_replace("/M2B-/","<410>",$alg);   $alg = preg_replace("/M2B2/","<411>",$alg);   $alg = preg_replace("/M2B/","<412>",$alg);
    $alg = preg_replace("/M2U'/","<413>",$alg); $alg = preg_replace("/M2U-/","<413>",$alg);   $alg = preg_replace("/M2U2/","<414>",$alg);   $alg = preg_replace("/M2U/","<415>",$alg);
    $alg = preg_replace("/M2D'/","<416>",$alg); $alg = preg_replace("/M2D-/","<416>",$alg);   $alg = preg_replace("/M2D2/","<417>",$alg);   $alg = preg_replace("/M2D/","<418>",$alg);
    
    /* --- 5xC: SSE -> CODE: [6] Wide-layer twists [5] (Mid-layer twists) [4] (Void twists) [1] Numbered layer twists --- */
    $alg = preg_replace("/WR'/","<501>",$alg); $alg = preg_replace("/WR-/","<501>",$alg);   $alg = preg_replace("/WR2/","<502>",$alg);   $alg = preg_replace("/WR/","<503>",$alg);
    $alg = preg_replace("/WL'/","<504>",$alg); $alg = preg_replace("/WL-/","<504>",$alg);   $alg = preg_replace("/WL2/","<505>",$alg);   $alg = preg_replace("/WL/","<506>",$alg);
    $alg = preg_replace("/WF'/","<507>",$alg); $alg = preg_replace("/WF-/","<507>",$alg);   $alg = preg_replace("/WF2/","<508>",$alg);   $alg = preg_replace("/WF/","<509>",$alg);
    $alg = preg_replace("/WB'/","<510>",$alg); $alg = preg_replace("/WB-/","<510>",$alg);   $alg = preg_replace("/WB2/","<511>",$alg);   $alg = preg_replace("/WB/","<512>",$alg);
    $alg = preg_replace("/WU'/","<513>",$alg); $alg = preg_replace("/WU-/","<513>",$alg);   $alg = preg_replace("/WU2/","<514>",$alg);   $alg = preg_replace("/WU/","<515>",$alg);
    $alg = preg_replace("/WD'/","<516>",$alg); $alg = preg_replace("/WD-/","<516>",$alg);   $alg = preg_replace("/WD2/","<517>",$alg);   $alg = preg_replace("/WD/","<518>",$alg);
    
    $alg = preg_replace("/M3R'/","<501>",$alg); $alg = preg_replace("/M3R-/","<501>",$alg);   $alg = preg_replace("/M3R2/","<502>",$alg);   $alg = preg_replace("/M3R/","<503>",$alg);
    $alg = preg_replace("/M3L'/","<504>",$alg); $alg = preg_replace("/M3L-/","<504>",$alg);   $alg = preg_replace("/M3L2/","<505>",$alg);   $alg = preg_replace("/M3L/","<506>",$alg);
    $alg = preg_replace("/M3F'/","<507>",$alg); $alg = preg_replace("/M3F-/","<507>",$alg);   $alg = preg_replace("/M3F2/","<508>",$alg);   $alg = preg_replace("/M3F/","<509>",$alg);
    $alg = preg_replace("/M3B'/","<510>",$alg); $alg = preg_replace("/M3B-/","<510>",$alg);   $alg = preg_replace("/M3B2/","<511>",$alg);   $alg = preg_replace("/M3B/","<512>",$alg);
    $alg = preg_replace("/M3U'/","<513>",$alg); $alg = preg_replace("/M3U-/","<513>",$alg);   $alg = preg_replace("/M3U2/","<514>",$alg);   $alg = preg_replace("/M3U/","<515>",$alg);
    $alg = preg_replace("/M3D'/","<516>",$alg); $alg = preg_replace("/M3D-/","<516>",$alg);   $alg = preg_replace("/M3D2/","<517>",$alg);   $alg = preg_replace("/M3D/","<518>",$alg);
    
    $alg = preg_replace("/V3R'/","<501>",$alg); $alg = preg_replace("/V3R-/","<501>",$alg);   $alg = preg_replace("/V3R2/","<502>",$alg);   $alg = preg_replace("/V3R/","<503>",$alg);
    $alg = preg_replace("/V3L'/","<504>",$alg); $alg = preg_replace("/V3L-/","<504>",$alg);   $alg = preg_replace("/V3L2/","<505>",$alg);   $alg = preg_replace("/V3L/","<506>",$alg);
    $alg = preg_replace("/V3F'/","<507>",$alg); $alg = preg_replace("/V3F-/","<507>",$alg);   $alg = preg_replace("/V3F2/","<508>",$alg);   $alg = preg_replace("/V3F/","<509>",$alg);
    $alg = preg_replace("/V3B'/","<510>",$alg); $alg = preg_replace("/V3B-/","<510>",$alg);   $alg = preg_replace("/V3B2/","<511>",$alg);   $alg = preg_replace("/V3B/","<512>",$alg);
    $alg = preg_replace("/V3U'/","<513>",$alg); $alg = preg_replace("/V3U-/","<513>",$alg);   $alg = preg_replace("/V3U2/","<514>",$alg);   $alg = preg_replace("/V3U/","<515>",$alg);
    $alg = preg_replace("/V3D'/","<516>",$alg); $alg = preg_replace("/V3D-/","<516>",$alg);   $alg = preg_replace("/V3D2/","<517>",$alg);   $alg = preg_replace("/V3D/","<518>",$alg);
    
    $alg = preg_replace("/N2-4R'/","<501>",$alg); $alg = preg_replace("/N2-4R-/","<501>",$alg);   $alg = preg_replace("/N2-4R2/","<502>",$alg);   $alg = preg_replace("/N2-4R/","<503>",$alg);
    $alg = preg_replace("/N2-4L'/","<504>",$alg); $alg = preg_replace("/N2-4L-/","<504>",$alg);   $alg = preg_replace("/N2-4L2/","<505>",$alg);   $alg = preg_replace("/N2-4L/","<506>",$alg);
    $alg = preg_replace("/N2-4F'/","<507>",$alg); $alg = preg_replace("/N2-4F-/","<507>",$alg);   $alg = preg_replace("/N2-4F2/","<508>",$alg);   $alg = preg_replace("/N2-4F/","<509>",$alg);
    $alg = preg_replace("/N2-4B'/","<510>",$alg); $alg = preg_replace("/N2-4B-/","<510>",$alg);   $alg = preg_replace("/N2-4B2/","<511>",$alg);   $alg = preg_replace("/N2-4B/","<512>",$alg);
    $alg = preg_replace("/N2-4U'/","<513>",$alg); $alg = preg_replace("/N2-4U-/","<513>",$alg);   $alg = preg_replace("/N2-4U2/","<514>",$alg);   $alg = preg_replace("/N2-4U/","<515>",$alg);
    $alg = preg_replace("/N2-4D'/","<516>",$alg); $alg = preg_replace("/N2-4D-/","<516>",$alg);   $alg = preg_replace("/N2-4D2/","<517>",$alg);   $alg = preg_replace("/N2-4D/","<518>",$alg);
    
    /* --- 5xC: SSE -> CODE: [7] Cube rotations --- */
    $alg = preg_replace("/CR'/","<701>",$alg); $alg = preg_replace("/CR-/","<701>",$alg);   $alg = preg_replace("/CR2/","<702>",$alg);   $alg = preg_replace("/CR/","<703>",$alg);
    $alg = preg_replace("/CL'/","<704>",$alg); $alg = preg_replace("/CL-/","<704>",$alg);   $alg = preg_replace("/CL2/","<705>",$alg);   $alg = preg_replace("/CL/","<706>",$alg);
    $alg = preg_replace("/CF'/","<707>",$alg); $alg = preg_replace("/CF-/","<707>",$alg);   $alg = preg_replace("/CF2/","<708>",$alg);   $alg = preg_replace("/CF/","<709>",$alg);
    $alg = preg_replace("/CB'/","<710>",$alg); $alg = preg_replace("/CB-/","<710>",$alg);   $alg = preg_replace("/CB2/","<711>",$alg);   $alg = preg_replace("/CB/","<712>",$alg);
    $alg = preg_replace("/CU'/","<713>",$alg); $alg = preg_replace("/CU-/","<713>",$alg);   $alg = preg_replace("/CU2/","<714>",$alg);   $alg = preg_replace("/CU/","<715>",$alg);
    $alg = preg_replace("/CD'/","<716>",$alg); $alg = preg_replace("/CD-/","<716>",$alg);   $alg = preg_replace("/CD2/","<717>",$alg);   $alg = preg_replace("/CD/","<718>",$alg);
    
    /* --- 5xC: SSE -> CODE: [9] Face twists --- */
    $alg = preg_replace("/R'/","<901>",$alg); $alg = preg_replace("/R-/","<901>",$alg);   $alg = preg_replace("/R2/","<902>",$alg);   $alg = preg_replace("/R/","<903>",$alg);
    $alg = preg_replace("/L'/","<904>",$alg); $alg = preg_replace("/L-/","<904>",$alg);   $alg = preg_replace("/L2/","<905>",$alg);   $alg = preg_replace("/L/","<906>",$alg);
    $alg = preg_replace("/F'/","<907>",$alg); $alg = preg_replace("/F-/","<907>",$alg);   $alg = preg_replace("/F2/","<908>",$alg);   $alg = preg_replace("/F/","<909>",$alg);
    $alg = preg_replace("/B'/","<910>",$alg); $alg = preg_replace("/B-/","<910>",$alg);   $alg = preg_replace("/B2/","<911>",$alg);   $alg = preg_replace("/B/","<912>",$alg);
    $alg = preg_replace("/U'/","<913>",$alg); $alg = preg_replace("/U-/","<913>",$alg);   $alg = preg_replace("/U2/","<914>",$alg);   $alg = preg_replace("/U/","<915>",$alg);
    $alg = preg_replace("/D'/","<916>",$alg); $alg = preg_replace("/D-/","<916>",$alg);   $alg = preg_replace("/D2/","<917>",$alg);   $alg = preg_replace("/D/","<918>",$alg);
    
    /* ··································································································· */
    /* --- 5xC: CODE -> TWIZZLE: [1] Numbered-layer twists --- */
    $alg = preg_replace("/<101>/","2R'",$alg);   $alg = preg_replace("/<102>/","2R2",$alg);   $alg = preg_replace("/<103>/","2R",$alg);
    $alg = preg_replace("/<104>/","2L'",$alg);   $alg = preg_replace("/<105>/","2L2",$alg);   $alg = preg_replace("/<106>/","2L",$alg);
    $alg = preg_replace("/<107>/","2F'",$alg);   $alg = preg_replace("/<108>/","2F2",$alg);   $alg = preg_replace("/<109>/","2F",$alg);
    $alg = preg_replace("/<110>/","2B'",$alg);   $alg = preg_replace("/<111>/","2B2",$alg);   $alg = preg_replace("/<112>/","2B",$alg);
    $alg = preg_replace("/<113>/","2U'",$alg);   $alg = preg_replace("/<114>/","2U2",$alg);   $alg = preg_replace("/<115>/","2U",$alg);
    $alg = preg_replace("/<116>/","2D'",$alg);   $alg = preg_replace("/<117>/","2D2",$alg);   $alg = preg_replace("/<118>/","2D",$alg);
    
    if ($useSiGN == true) { // Bei SiGN:
      $alg = preg_replace("/<119>/","M",$alg);    $alg = preg_replace("/<120>/","M2",$alg);   $alg = preg_replace("/<121>/","M'",$alg);
      $alg = preg_replace("/<122>/","M'",$alg);   $alg = preg_replace("/<123>/","M2",$alg);   $alg = preg_replace("/<124>/","M",$alg);
      $alg = preg_replace("/<125>/","S'",$alg);   $alg = preg_replace("/<126>/","S2",$alg);   $alg = preg_replace("/<127>/","S",$alg);
      $alg = preg_replace("/<128>/","S",$alg);    $alg = preg_replace("/<129>/","S2",$alg);   $alg = preg_replace("/<130>/","S'",$alg);
      $alg = preg_replace("/<131>/","E",$alg);    $alg = preg_replace("/<132>/","E2",$alg);   $alg = preg_replace("/<133>/","E'",$alg);
      $alg = preg_replace("/<134>/","E'",$alg);   $alg = preg_replace("/<135>/","E2",$alg);   $alg = preg_replace("/<136>/","E",$alg);
    } else {               // Sonst (TWIZZLE):
      $alg = preg_replace("/<119>/","3R'",$alg);   $alg = preg_replace("/<120>/","3R2",$alg);   $alg = preg_replace("/<121>/","3R",$alg);
      $alg = preg_replace("/<122>/","3L'",$alg);   $alg = preg_replace("/<123>/","3L2",$alg);   $alg = preg_replace("/<124>/","3L",$alg);
      $alg = preg_replace("/<125>/","3F'",$alg);   $alg = preg_replace("/<126>/","3F2",$alg);   $alg = preg_replace("/<127>/","3F",$alg);
      $alg = preg_replace("/<128>/","3B'",$alg);   $alg = preg_replace("/<129>/","3B2",$alg);   $alg = preg_replace("/<130>/","3B",$alg);
      $alg = preg_replace("/<131>/","3U'",$alg);   $alg = preg_replace("/<132>/","3U2",$alg);   $alg = preg_replace("/<133>/","3U",$alg);
      $alg = preg_replace("/<134>/","3D'",$alg);   $alg = preg_replace("/<135>/","3D2",$alg);   $alg = preg_replace("/<136>/","3D",$alg);
    }
    
    /* --- 5xC: CODE -> TWIZZLE: [2] Slice twists --- */
    $alg = preg_replace("/<201>/","r' l",$alg);   $alg = preg_replace("/<202>/","r2 l2",$alg);   $alg = preg_replace("/<203>/","r l'",$alg);
    $alg = preg_replace("/<204>/","r l'",$alg);   $alg = preg_replace("/<205>/","r2 l2",$alg);   $alg = preg_replace("/<206>/","r' l",$alg);
    $alg = preg_replace("/<207>/","f' b",$alg);   $alg = preg_replace("/<208>/","f2 b2",$alg);   $alg = preg_replace("/<209>/","f b'",$alg);
    $alg = preg_replace("/<210>/","f b'",$alg);   $alg = preg_replace("/<211>/","f2 b2",$alg);   $alg = preg_replace("/<212>/","f' b",$alg);
    $alg = preg_replace("/<213>/","u' d",$alg);   $alg = preg_replace("/<214>/","u2 d2",$alg);   $alg = preg_replace("/<215>/","u d'",$alg);
    $alg = preg_replace("/<216>/","u d'",$alg);   $alg = preg_replace("/<217>/","u2 d2",$alg);   $alg = preg_replace("/<218>/","u' d",$alg);
    
    $alg = preg_replace("/<219>/","R' L",$alg);   $alg = preg_replace("/<220>/","R2 L2",$alg);   $alg = preg_replace("/<221>/","R L'",$alg);
    $alg = preg_replace("/<222>/","R L'",$alg);   $alg = preg_replace("/<223>/","R2 L2",$alg);   $alg = preg_replace("/<224>/","R' L",$alg);
    $alg = preg_replace("/<225>/","F' B",$alg);   $alg = preg_replace("/<226>/","F2 B2",$alg);   $alg = preg_replace("/<227>/","F B'",$alg);
    $alg = preg_replace("/<228>/","F B'",$alg);   $alg = preg_replace("/<229>/","F2 B2",$alg);   $alg = preg_replace("/<230>/","F' B",$alg);
    $alg = preg_replace("/<231>/","U' D",$alg);   $alg = preg_replace("/<232>/","U2 D2",$alg);   $alg = preg_replace("/<233>/","U D'",$alg);
    $alg = preg_replace("/<234>/","U D'",$alg);   $alg = preg_replace("/<235>/","U2 D2",$alg);   $alg = preg_replace("/<236>/","U' D",$alg);
    
    $alg = preg_replace("/<237>/","R' 3l",$alg);   $alg = preg_replace("/<238>/","R2 3l2",$alg);   $alg = preg_replace("/<239>/","R 3l'",$alg);
    $alg = preg_replace("/<240>/","3r L'",$alg);   $alg = preg_replace("/<241>/","3r2 L2",$alg);   $alg = preg_replace("/<242>/","3r' L",$alg);
    $alg = preg_replace("/<243>/","F' 3b",$alg);   $alg = preg_replace("/<244>/","F2 3b2",$alg);   $alg = preg_replace("/<245>/","F 3b'",$alg);
    $alg = preg_replace("/<246>/","3f B'",$alg);   $alg = preg_replace("/<247>/","3f2 B2",$alg);   $alg = preg_replace("/<248>/","3f' B",$alg);
    $alg = preg_replace("/<249>/","U' 3d",$alg);   $alg = preg_replace("/<250>/","U2 3d2",$alg);   $alg = preg_replace("/<251>/","U 3d'",$alg);
    $alg = preg_replace("/<252>/","3u D'",$alg);   $alg = preg_replace("/<253>/","3u2 D2",$alg);   $alg = preg_replace("/<254>/","3u' D",$alg);
    
    $alg = preg_replace("/<255>/","R' l",$alg);   $alg = preg_replace("/<256>/","R2 l2",$alg);   $alg = preg_replace("/<257>/","R l'",$alg);
    $alg = preg_replace("/<258>/","r L'",$alg);   $alg = preg_replace("/<259>/","r2 L2",$alg);   $alg = preg_replace("/<260>/","r' L",$alg);
    $alg = preg_replace("/<261>/","F' b",$alg);   $alg = preg_replace("/<262>/","F2 b2",$alg);   $alg = preg_replace("/<263>/","F b'",$alg);
    $alg = preg_replace("/<264>/","f B'",$alg);   $alg = preg_replace("/<265>/","f2 B2",$alg);   $alg = preg_replace("/<266>/","f' B",$alg);
    $alg = preg_replace("/<267>/","U' d",$alg);   $alg = preg_replace("/<268>/","U2 d2",$alg);   $alg = preg_replace("/<269>/","U d'",$alg);
    $alg = preg_replace("/<270>/","u D'",$alg);   $alg = preg_replace("/<271>/","u2 D2",$alg);   $alg = preg_replace("/<272>/","u' D",$alg);
    
    /* --- 5xC: CODE -> TWIZZLE: [3] Tier twists --- */
    $alg = preg_replace("/<301>/","4r'",$alg);   $alg = preg_replace("/<302>/","4r2",$alg);   $alg = preg_replace("/<303>/","4r",$alg);
    $alg = preg_replace("/<304>/","4l'",$alg);   $alg = preg_replace("/<305>/","4l2",$alg);   $alg = preg_replace("/<306>/","4l",$alg);
    $alg = preg_replace("/<307>/","4f'",$alg);   $alg = preg_replace("/<308>/","4f2",$alg);   $alg = preg_replace("/<309>/","4f",$alg);
    $alg = preg_replace("/<310>/","4b'",$alg);   $alg = preg_replace("/<311>/","4b2",$alg);   $alg = preg_replace("/<312>/","4b",$alg);
    $alg = preg_replace("/<313>/","4u'",$alg);   $alg = preg_replace("/<314>/","4u2",$alg);   $alg = preg_replace("/<315>/","4u",$alg);
    $alg = preg_replace("/<316>/","4d'",$alg);   $alg = preg_replace("/<317>/","4d2",$alg);   $alg = preg_replace("/<318>/","4d",$alg);
    
    $alg = preg_replace("/<319>/","3r'",$alg);   $alg = preg_replace("/<320>/","3r2",$alg);   $alg = preg_replace("/<321>/","3r",$alg);
    $alg = preg_replace("/<322>/","3l'",$alg);   $alg = preg_replace("/<323>/","3l2",$alg);   $alg = preg_replace("/<324>/","3l",$alg);
    $alg = preg_replace("/<325>/","3f'",$alg);   $alg = preg_replace("/<326>/","3f2",$alg);   $alg = preg_replace("/<327>/","3f",$alg);
    $alg = preg_replace("/<328>/","3b'",$alg);   $alg = preg_replace("/<329>/","3b2",$alg);   $alg = preg_replace("/<330>/","3b",$alg);
    $alg = preg_replace("/<331>/","3u'",$alg);   $alg = preg_replace("/<332>/","3u2",$alg);   $alg = preg_replace("/<333>/","3u",$alg);
    $alg = preg_replace("/<334>/","3d'",$alg);   $alg = preg_replace("/<335>/","3d2",$alg);   $alg = preg_replace("/<336>/","3d",$alg);
    
    $alg = preg_replace("/<337>/","r'",$alg);   $alg = preg_replace("/<338>/","r2",$alg);   $alg = preg_replace("/<339>/","r",$alg);
    $alg = preg_replace("/<340>/","l'",$alg);   $alg = preg_replace("/<341>/","l2",$alg);   $alg = preg_replace("/<342>/","l",$alg);
    $alg = preg_replace("/<343>/","f'",$alg);   $alg = preg_replace("/<344>/","f2",$alg);   $alg = preg_replace("/<345>/","f",$alg);
    $alg = preg_replace("/<346>/","b'",$alg);   $alg = preg_replace("/<347>/","b2",$alg);   $alg = preg_replace("/<348>/","b",$alg);
    $alg = preg_replace("/<349>/","u'",$alg);   $alg = preg_replace("/<350>/","u2",$alg);   $alg = preg_replace("/<351>/","u",$alg);
    $alg = preg_replace("/<352>/","d'",$alg);   $alg = preg_replace("/<353>/","d2",$alg);   $alg = preg_replace("/<354>/","d",$alg);
    
    /* --- 5xC: CODE -> TWIZZLE: [4] Void twists --- */
    $alg = preg_replace("/<401>/","2-3R'",$alg);   $alg = preg_replace("/<402>/","2-3R2",$alg);   $alg = preg_replace("/<403>/","2-3R",$alg);
    $alg = preg_replace("/<404>/","2-3L'",$alg);   $alg = preg_replace("/<405>/","2-3L2",$alg);   $alg = preg_replace("/<406>/","2-3L",$alg);
    $alg = preg_replace("/<407>/","2-3F'",$alg);   $alg = preg_replace("/<408>/","2-3F2",$alg);   $alg = preg_replace("/<409>/","2-3F",$alg);
    $alg = preg_replace("/<410>/","2-3B'",$alg);   $alg = preg_replace("/<411>/","2-3B2",$alg);   $alg = preg_replace("/<412>/","2-3B",$alg);
    $alg = preg_replace("/<413>/","2-3U'",$alg);   $alg = preg_replace("/<414>/","2-3U2",$alg);   $alg = preg_replace("/<415>/","2-3U",$alg);
    $alg = preg_replace("/<416>/","2-3D'",$alg);   $alg = preg_replace("/<417>/","2-3D2",$alg);   $alg = preg_replace("/<418>/","2-3D",$alg);
    
    /* --- 5xC: CODE -> TWIZZLE: [6] Wide-layer twists [5] (Mid-layer twists) --- */
    if ($useSiGN == true) { // Bei SiGN:
      $alg = preg_replace("/<501>/","m",$alg);    $alg = preg_replace("/<502>/","m2",$alg);   $alg = preg_replace("/<503>/","m'",$alg);
      $alg = preg_replace("/<504>/","m'",$alg);   $alg = preg_replace("/<505>/","m2",$alg);   $alg = preg_replace("/<506>/","m",$alg);
      $alg = preg_replace("/<507>/","s'",$alg);   $alg = preg_replace("/<508>/","s2",$alg);   $alg = preg_replace("/<509>/","s",$alg);
      $alg = preg_replace("/<510>/","s",$alg);    $alg = preg_replace("/<511>/","s2",$alg);   $alg = preg_replace("/<512>/","s'",$alg);
      $alg = preg_replace("/<513>/","e",$alg);    $alg = preg_replace("/<514>/","e2",$alg);   $alg = preg_replace("/<515>/","e'",$alg);
      $alg = preg_replace("/<516>/","e'",$alg);   $alg = preg_replace("/<517>/","e2",$alg);   $alg = preg_replace("/<518>/","e",$alg);
    } else {               // Sonst (TWIZZLE):
      $alg = preg_replace("/<501>/","2-4R'",$alg);   $alg = preg_replace("/<502>/","2-4R2",$alg);   $alg = preg_replace("/<503>/","2-4R",$alg);
      $alg = preg_replace("/<504>/","2-4L'",$alg);   $alg = preg_replace("/<505>/","2-4L2",$alg);   $alg = preg_replace("/<506>/","2-4L",$alg);
      $alg = preg_replace("/<507>/","2-4F'",$alg);   $alg = preg_replace("/<508>/","2-4F2",$alg);   $alg = preg_replace("/<509>/","2-4F",$alg);
      $alg = preg_replace("/<510>/","2-4B'",$alg);   $alg = preg_replace("/<511>/","2-4B2",$alg);   $alg = preg_replace("/<512>/","2-4B",$alg);
      $alg = preg_replace("/<513>/","2-4U'",$alg);   $alg = preg_replace("/<514>/","2-4U2",$alg);   $alg = preg_replace("/<515>/","2-4U",$alg);
      $alg = preg_replace("/<516>/","2-4D'",$alg);   $alg = preg_replace("/<517>/","2-4D2",$alg);   $alg = preg_replace("/<518>/","2-4D",$alg);
    }
    
    /* --- 5xC: CODE -> TWIZZLE: [7] Cube rotations --- */
    if ($useSiGN == true) { // Bei SiGN:
      $alg = preg_replace("/<701>/","x'",$alg);   $alg = preg_replace("/<702>/","x2",$alg);   $alg = preg_replace("/<703>/","x",$alg);
      $alg = preg_replace("/<704>/","x",$alg);    $alg = preg_replace("/<705>/","x2",$alg);   $alg = preg_replace("/<706>/","x'",$alg);
      $alg = preg_replace("/<707>/","z'",$alg);   $alg = preg_replace("/<708>/","z2",$alg);   $alg = preg_replace("/<709>/","z",$alg);
      $alg = preg_replace("/<710>/","z",$alg);    $alg = preg_replace("/<711>/","z2",$alg);   $alg = preg_replace("/<712>/","z'",$alg);
      $alg = preg_replace("/<713>/","y'",$alg);   $alg = preg_replace("/<714>/","y2",$alg);   $alg = preg_replace("/<715>/","y",$alg);
      $alg = preg_replace("/<716>/","y",$alg);    $alg = preg_replace("/<717>/","y2",$alg);   $alg = preg_replace("/<718>/","y'",$alg);
    } else {               // Sonst (TWIZZLE):
      $alg = preg_replace("/<701>/","Rv'",$alg);   $alg = preg_replace("/<702>/","Rv2",$alg);   $alg = preg_replace("/<703>/","Rv",$alg);
      $alg = preg_replace("/<704>/","Rv",$alg);    $alg = preg_replace("/<705>/","Rv2",$alg);   $alg = preg_replace("/<706>/","Rv'",$alg);
      $alg = preg_replace("/<707>/","Fv'",$alg);   $alg = preg_replace("/<708>/","Fv2",$alg);   $alg = preg_replace("/<709>/","Fv",$alg);
      $alg = preg_replace("/<710>/","Fv",$alg);    $alg = preg_replace("/<711>/","Fv2",$alg);   $alg = preg_replace("/<712>/","Fv'",$alg);
      $alg = preg_replace("/<713>/","Uv'",$alg);   $alg = preg_replace("/<714>/","Uv2",$alg);   $alg = preg_replace("/<715>/","Uv",$alg);
      $alg = preg_replace("/<716>/","Uv",$alg);    $alg = preg_replace("/<717>/","Uv2",$alg);   $alg = preg_replace("/<718>/","Uv'",$alg);
    }
    
    /* --- 5xC: CODE -> TWIZZLE: [9] Face twists --- */
    $alg = preg_replace("/<901>/","R'",$alg);   $alg = preg_replace("/<902>/","R2",$alg);   $alg = preg_replace("/<903>/","R",$alg);
    $alg = preg_replace("/<904>/","L'",$alg);   $alg = preg_replace("/<905>/","L2",$alg);   $alg = preg_replace("/<906>/","L",$alg);
    $alg = preg_replace("/<907>/","F'",$alg);   $alg = preg_replace("/<908>/","F2",$alg);   $alg = preg_replace("/<909>/","F",$alg);
    $alg = preg_replace("/<910>/","B'",$alg);   $alg = preg_replace("/<911>/","B2",$alg);   $alg = preg_replace("/<912>/","B",$alg);
    $alg = preg_replace("/<913>/","U'",$alg);   $alg = preg_replace("/<914>/","U2",$alg);   $alg = preg_replace("/<915>/","U",$alg);
    $alg = preg_replace("/<916>/","D'",$alg);   $alg = preg_replace("/<917>/","D2",$alg);   $alg = preg_replace("/<918>/","D",$alg);
    
    return $alg;
  }
  
  
  
  
  /* 
  ---------------------------------------------------------------------------------------------------
  * alg5xC_TwizzleToSse($alg)
  * 
  * Converts 5x5 Professor Cube TWIZZLE algorithms into SSE notation.
  * 
  * Parameter: $alg (STRING): The algorithm.
  * 
  * Return: STRING.
  ---------------------------------------------------------------------------------------------------
  */
  function alg5xC_TwizzleToSse($alg) {
    /* --- 5xC: Marker --- */
    $alg = str_replace(".","·",$alg);
    
    /* ··································································································· */
    /* --- 5xC: TWIZZLE -> CODE: [6] Wide layer twists --- */
    $alg = preg_replace("/2-4R'/","<601>",$alg); $alg = preg_replace("/2-4R2/","<602>",$alg); $alg = preg_replace("/2-4R/","<603>",$alg);
    $alg = preg_replace("/2-4L'/","<604>",$alg); $alg = preg_replace("/2-4L2/","<605>",$alg); $alg = preg_replace("/2-4L/","<606>",$alg);
    $alg = preg_replace("/2-4F'/","<607>",$alg); $alg = preg_replace("/2-4F2/","<608>",$alg); $alg = preg_replace("/2-4F/","<609>",$alg);
    $alg = preg_replace("/2-4B'/","<610>",$alg); $alg = preg_replace("/2-4B2/","<611>",$alg); $alg = preg_replace("/2-4B/","<612>",$alg);
    $alg = preg_replace("/2-4U'/","<613>",$alg); $alg = preg_replace("/2-4U2/","<614>",$alg); $alg = preg_replace("/2-4U/","<615>",$alg);
    $alg = preg_replace("/2-4D'/","<616>",$alg); $alg = preg_replace("/2-4D2/","<617>",$alg); $alg = preg_replace("/2-4D/","<618>",$alg);
    
    $alg = preg_replace("/m'/","<603>",$alg); $alg = preg_replace("/m2/","<602>",$alg); $alg = preg_replace("/m/","<601>",$alg);
    $alg = preg_replace("/s'/","<607>",$alg); $alg = preg_replace("/s2/","<608>",$alg); $alg = preg_replace("/s/","<609>",$alg);
    $alg = preg_replace("/e'/","<615>",$alg); $alg = preg_replace("/e2/","<614>",$alg); $alg = preg_replace("/e/","<613>",$alg);
    
    /* --- 5xC: TWIZZLE -> CODE: [4] Void twists --- */
    $alg = preg_replace("/2-3R'/","<401>",$alg); $alg = preg_replace("/2-3R2/","<402>",$alg); $alg = preg_replace("/2-3R/","<403>",$alg);
    $alg = preg_replace("/2-3L'/","<404>",$alg); $alg = preg_replace("/2-3L2/","<405>",$alg); $alg = preg_replace("/2-3L/","<406>",$alg);
    $alg = preg_replace("/2-3F'/","<407>",$alg); $alg = preg_replace("/2-3F2/","<408>",$alg); $alg = preg_replace("/2-3F/","<409>",$alg);
    $alg = preg_replace("/2-3B'/","<410>",$alg); $alg = preg_replace("/2-3B2/","<411>",$alg); $alg = preg_replace("/2-3B/","<412>",$alg);
    $alg = preg_replace("/2-3U'/","<413>",$alg); $alg = preg_replace("/2-3U2/","<414>",$alg); $alg = preg_replace("/2-3U/","<415>",$alg);
    $alg = preg_replace("/2-3D'/","<416>",$alg); $alg = preg_replace("/2-3D2/","<417>",$alg); $alg = preg_replace("/2-3D/","<418>",$alg);
    
    /* --- 5xC: TWIZZLE -> CODE: [3] Tier twists (WCA) --- */
    $alg = preg_replace("/4Rw'/","<301>",$alg); $alg = preg_replace("/4Rw2/","<302>",$alg); $alg = preg_replace("/4Rw/","<303>",$alg);
    $alg = preg_replace("/4Lw'/","<304>",$alg); $alg = preg_replace("/4Lw2/","<305>",$alg); $alg = preg_replace("/4Lw/","<306>",$alg);
    $alg = preg_replace("/4Fw'/","<307>",$alg); $alg = preg_replace("/4Fw2/","<308>",$alg); $alg = preg_replace("/4Fw/","<309>",$alg);
    $alg = preg_replace("/4Bw'/","<310>",$alg); $alg = preg_replace("/4Bw2/","<311>",$alg); $alg = preg_replace("/4Bw/","<312>",$alg);
    $alg = preg_replace("/4Uw'/","<313>",$alg); $alg = preg_replace("/4Uw2/","<314>",$alg); $alg = preg_replace("/4Uw/","<315>",$alg);
    $alg = preg_replace("/4Dw'/","<316>",$alg); $alg = preg_replace("/4Dw2/","<317>",$alg); $alg = preg_replace("/4Dw/","<318>",$alg);
    
    $alg = preg_replace("/3Rw'/","<319>",$alg); $alg = preg_replace("/3Rw2/","<320>",$alg); $alg = preg_replace("/3Rw/","<321>",$alg);
    $alg = preg_replace("/3Lw'/","<322>",$alg); $alg = preg_replace("/3Lw2/","<323>",$alg); $alg = preg_replace("/3Lw/","<324>",$alg);
    $alg = preg_replace("/3Fw'/","<325>",$alg); $alg = preg_replace("/3Fw2/","<326>",$alg); $alg = preg_replace("/3Fw/","<327>",$alg);
    $alg = preg_replace("/3Bw'/","<328>",$alg); $alg = preg_replace("/3Bw2/","<329>",$alg); $alg = preg_replace("/3Bw/","<330>",$alg);
    $alg = preg_replace("/3Uw'/","<331>",$alg); $alg = preg_replace("/3Uw2/","<332>",$alg); $alg = preg_replace("/3Uw/","<333>",$alg);
    $alg = preg_replace("/3Dw'/","<334>",$alg); $alg = preg_replace("/3Dw2/","<335>",$alg); $alg = preg_replace("/3Dw/","<336>",$alg);
    
    /* --- 5xC: TWIZZLE -> CODE: [1] Numbered layer twists --- */
    $alg = preg_replace("/2R'/","<101>",$alg); $alg = preg_replace("/2R2/","<102>",$alg); $alg = preg_replace("/2R/","<103>",$alg);
    $alg = preg_replace("/2L'/","<104>",$alg); $alg = preg_replace("/2L2/","<105>",$alg); $alg = preg_replace("/2L/","<106>",$alg);
    $alg = preg_replace("/2F'/","<107>",$alg); $alg = preg_replace("/2F2/","<108>",$alg); $alg = preg_replace("/2F/","<109>",$alg);
    $alg = preg_replace("/2B'/","<110>",$alg); $alg = preg_replace("/2B2/","<111>",$alg); $alg = preg_replace("/2B/","<112>",$alg);
    $alg = preg_replace("/2U'/","<113>",$alg); $alg = preg_replace("/2U2/","<114>",$alg); $alg = preg_replace("/2U/","<115>",$alg);
    $alg = preg_replace("/2D'/","<116>",$alg); $alg = preg_replace("/2D2/","<117>",$alg); $alg = preg_replace("/2D/","<118>",$alg);
    
    $alg = preg_replace("/3R'/","<119>",$alg); $alg = preg_replace("/3R2/","<120>",$alg); $alg = preg_replace("/3R/","<121>",$alg);
    $alg = preg_replace("/3L'/","<122>",$alg); $alg = preg_replace("/3L2/","<123>",$alg); $alg = preg_replace("/3L/","<124>",$alg);
    $alg = preg_replace("/3F'/","<125>",$alg); $alg = preg_replace("/3F2/","<126>",$alg); $alg = preg_replace("/3F/","<127>",$alg);
    $alg = preg_replace("/3B'/","<128>",$alg); $alg = preg_replace("/3B2/","<129>",$alg); $alg = preg_replace("/3B/","<130>",$alg);
    $alg = preg_replace("/3U'/","<131>",$alg); $alg = preg_replace("/3U2/","<132>",$alg); $alg = preg_replace("/3U/","<133>",$alg);
    $alg = preg_replace("/3D'/","<134>",$alg); $alg = preg_replace("/3D2/","<135>",$alg); $alg = preg_replace("/3D/","<136>",$alg);
    
    $alg = preg_replace("/4R'/","<106>",$alg); $alg = preg_replace("/4R2/","<105>",$alg); $alg = preg_replace("/4R/","<104>",$alg);
    $alg = preg_replace("/4L'/","<103>",$alg); $alg = preg_replace("/4L2/","<102>",$alg); $alg = preg_replace("/4L/","<101>",$alg);
    $alg = preg_replace("/4F'/","<112>",$alg); $alg = preg_replace("/4F2/","<111>",$alg); $alg = preg_replace("/4F/","<110>",$alg);
    $alg = preg_replace("/4B'/","<109>",$alg); $alg = preg_replace("/4B2/","<108>",$alg); $alg = preg_replace("/4B/","<107>",$alg);
    $alg = preg_replace("/4U'/","<118>",$alg); $alg = preg_replace("/4U2/","<117>",$alg); $alg = preg_replace("/4U/","<116>",$alg);
    $alg = preg_replace("/4D'/","<115>",$alg); $alg = preg_replace("/4D2/","<114>",$alg); $alg = preg_replace("/4D/","<113>",$alg);
    
    /* --- 5xC: TWIZZLE -> CODE: [3] Tier twists (SiGN) --- */
    $alg = preg_replace("/4r'/","<301>",$alg); $alg = preg_replace("/4r2/","<302>",$alg); $alg = preg_replace("/4r/","<303>",$alg);
    $alg = preg_replace("/4l'/","<304>",$alg); $alg = preg_replace("/4l2/","<305>",$alg); $alg = preg_replace("/4l/","<306>",$alg);
    $alg = preg_replace("/4f'/","<307>",$alg); $alg = preg_replace("/4f2/","<308>",$alg); $alg = preg_replace("/4f/","<309>",$alg);
    $alg = preg_replace("/4b'/","<310>",$alg); $alg = preg_replace("/4b2/","<311>",$alg); $alg = preg_replace("/4b/","<312>",$alg);
    $alg = preg_replace("/4u'/","<313>",$alg); $alg = preg_replace("/4u2/","<314>",$alg); $alg = preg_replace("/4u/","<315>",$alg);
    $alg = preg_replace("/4d'/","<316>",$alg); $alg = preg_replace("/4d2/","<317>",$alg); $alg = preg_replace("/4d/","<318>",$alg);
    
    $alg = preg_replace("/3r'/","<319>",$alg); $alg = preg_replace("/3r2/","<320>",$alg); $alg = preg_replace("/3r/","<321>",$alg);
    $alg = preg_replace("/3l'/","<322>",$alg); $alg = preg_replace("/3l2/","<323>",$alg); $alg = preg_replace("/3l/","<324>",$alg);
    $alg = preg_replace("/3f'/","<325>",$alg); $alg = preg_replace("/3f2/","<326>",$alg); $alg = preg_replace("/3f/","<327>",$alg);
    $alg = preg_replace("/3b'/","<328>",$alg); $alg = preg_replace("/3b2/","<329>",$alg); $alg = preg_replace("/3b/","<330>",$alg);
    $alg = preg_replace("/3u'/","<331>",$alg); $alg = preg_replace("/3u2/","<332>",$alg); $alg = preg_replace("/3u/","<333>",$alg);
    $alg = preg_replace("/3d'/","<334>",$alg); $alg = preg_replace("/3d2/","<335>",$alg); $alg = preg_replace("/3d/","<336>",$alg);
    
    /* --- 5xC: TWIZZLE -> CODE: [3] Tier twists (WCA) --- */
    $alg = preg_replace("/Rw'/","<337>",$alg); $alg = preg_replace("/Rw2/","<338>",$alg); $alg = preg_replace("/Rw/","<339>",$alg);
    $alg = preg_replace("/Lw'/","<340>",$alg); $alg = preg_replace("/Lw2/","<341>",$alg); $alg = preg_replace("/Lw/","<342>",$alg);
    $alg = preg_replace("/Fw'/","<343>",$alg); $alg = preg_replace("/Fw2/","<344>",$alg); $alg = preg_replace("/Fw/","<345>",$alg);
    $alg = preg_replace("/Bw'/","<346>",$alg); $alg = preg_replace("/Bw2/","<347>",$alg); $alg = preg_replace("/Bw/","<348>",$alg);
    $alg = preg_replace("/Uw'/","<349>",$alg); $alg = preg_replace("/Uw2/","<350>",$alg); $alg = preg_replace("/Uw/","<351>",$alg);
    $alg = preg_replace("/Dw'/","<352>",$alg); $alg = preg_replace("/Dw2/","<353>",$alg); $alg = preg_replace("/Dw/","<354>",$alg);
    
    /* --- 5xC: TWIZZLE -> CODE: [7] Cube rotations --- */
    $alg = preg_replace("/Rv'/","<701>",$alg); $alg = preg_replace("/Rv2/","<702>",$alg); $alg = preg_replace("/Rv/","<703>",$alg);
    $alg = preg_replace("/Lv'/","<703>",$alg); $alg = preg_replace("/Lv2/","<702>",$alg); $alg = preg_replace("/Lv/","<701>",$alg);
    $alg = preg_replace("/Fv'/","<704>",$alg); $alg = preg_replace("/Fv2/","<705>",$alg); $alg = preg_replace("/Fv/","<706>",$alg);
    $alg = preg_replace("/Bv'/","<706>",$alg); $alg = preg_replace("/Bv2/","<705>",$alg); $alg = preg_replace("/Bv/","<704>",$alg);
    $alg = preg_replace("/Uv'/","<707>",$alg); $alg = preg_replace("/Uv2/","<708>",$alg); $alg = preg_replace("/Uv/","<709>",$alg);
    $alg = preg_replace("/Dv'/","<709>",$alg); $alg = preg_replace("/Dv2/","<708>",$alg); $alg = preg_replace("/Dv/","<707>",$alg);
    
    $alg = preg_replace("/x'/","<701>",$alg); $alg = preg_replace("/x2/","<702>",$alg); $alg = preg_replace("/x/","<703>",$alg);
    $alg = preg_replace("/z'/","<704>",$alg); $alg = preg_replace("/z2/","<705>",$alg); $alg = preg_replace("/z/","<706>",$alg);
    $alg = preg_replace("/y'/","<707>",$alg); $alg = preg_replace("/y2/","<708>",$alg); $alg = preg_replace("/y/","<709>",$alg);
    
    /* --- 5xC: TWIZZLE -> CODE: [5] Mid-layer [1] (Numbered layer) [6] (Wide) twists --- */
    $alg = preg_replace("/M'/","<121>",$alg); $alg = preg_replace("/M2/","<120>",$alg); $alg = preg_replace("/M/","<119>",$alg);
    $alg = preg_replace("/S'/","<125>",$alg); $alg = preg_replace("/S2/","<126>",$alg); $alg = preg_replace("/S/","<127>",$alg);
    $alg = preg_replace("/E'/","<133>",$alg); $alg = preg_replace("/E2/","<132>",$alg); $alg = preg_replace("/E/","<131>",$alg);
    
    /* --- 5xC: TWIZZLE -> CODE: [9] Face twists --- */
    $alg = preg_replace("/R'/","<901>",$alg); $alg = preg_replace("/R2/","<902>",$alg); $alg = preg_replace("/R/","<903>",$alg);
    $alg = preg_replace("/L'/","<904>",$alg); $alg = preg_replace("/L2/","<905>",$alg); $alg = preg_replace("/L/","<906>",$alg);
    $alg = preg_replace("/F'/","<907>",$alg); $alg = preg_replace("/F2/","<908>",$alg); $alg = preg_replace("/F/","<909>",$alg);
    $alg = preg_replace("/B'/","<910>",$alg); $alg = preg_replace("/B2/","<911>",$alg); $alg = preg_replace("/B/","<912>",$alg);
    $alg = preg_replace("/U'/","<913>",$alg); $alg = preg_replace("/U2/","<914>",$alg); $alg = preg_replace("/U/","<915>",$alg);
    $alg = preg_replace("/D'/","<916>",$alg); $alg = preg_replace("/D2/","<917>",$alg); $alg = preg_replace("/D/","<918>",$alg);
    
    /* --- 5xC: TWIZZLE -> CODE: [3] Tier twists (SiGN) --- */
    $alg = preg_replace("/r'/","<337>",$alg); $alg = preg_replace("/r2/","<338>",$alg); $alg = preg_replace("/r/","<339>",$alg);
    $alg = preg_replace("/l'/","<340>",$alg); $alg = preg_replace("/l2/","<341>",$alg); $alg = preg_replace("/l/","<342>",$alg);
    $alg = preg_replace("/f'/","<343>",$alg); $alg = preg_replace("/f2/","<344>",$alg); $alg = preg_replace("/f/","<345>",$alg);
    $alg = preg_replace("/b'/","<346>",$alg); $alg = preg_replace("/b2/","<347>",$alg); $alg = preg_replace("/b/","<348>",$alg);
    $alg = preg_replace("/u'/","<349>",$alg); $alg = preg_replace("/u2/","<350>",$alg); $alg = preg_replace("/u/","<351>",$alg);
    $alg = preg_replace("/d'/","<352>",$alg); $alg = preg_replace("/d2/","<353>",$alg); $alg = preg_replace("/d/","<354>",$alg);
    
    /* ··································································································· */
    /* --- 5xC: CODE -> SSE: [6] Wide layer twists --- */
    $alg = preg_replace("/<601>/","WR'",$alg); $alg = preg_replace("/<602>/","WR2",$alg); $alg = preg_replace("/<603>/","WR",$alg);
    $alg = preg_replace("/<604>/","WL'",$alg); $alg = preg_replace("/<605>/","WL2",$alg); $alg = preg_replace("/<606>/","WL",$alg);
    $alg = preg_replace("/<607>/","WF'",$alg); $alg = preg_replace("/<608>/","WF2",$alg); $alg = preg_replace("/<609>/","WF",$alg);
    $alg = preg_replace("/<610>/","WB'",$alg); $alg = preg_replace("/<611>/","WB2",$alg); $alg = preg_replace("/<612>/","WB",$alg);
    $alg = preg_replace("/<613>/","WU'",$alg); $alg = preg_replace("/<614>/","WU2",$alg); $alg = preg_replace("/<615>/","WU",$alg);
    $alg = preg_replace("/<616>/","WD'",$alg); $alg = preg_replace("/<617>/","WD2",$alg); $alg = preg_replace("/<618>/","WD",$alg);
    
    /* --- 5xC: CODE -> SSE: [4] Void twists --- */
    $alg = preg_replace("/<401>/","VR'",$alg); $alg = preg_replace("/<402>/","VR2",$alg); $alg = preg_replace("/<403>/","VR",$alg);
    $alg = preg_replace("/<404>/","VL'",$alg); $alg = preg_replace("/<405>/","VL2",$alg); $alg = preg_replace("/<406>/","VL",$alg);
    $alg = preg_replace("/<407>/","VF'",$alg); $alg = preg_replace("/<408>/","VF2",$alg); $alg = preg_replace("/<409>/","VF",$alg);
    $alg = preg_replace("/<410>/","VB'",$alg); $alg = preg_replace("/<411>/","VB2",$alg); $alg = preg_replace("/<412>/","VB",$alg);
    $alg = preg_replace("/<413>/","VU'",$alg); $alg = preg_replace("/<414>/","VU2",$alg); $alg = preg_replace("/<415>/","VU",$alg);
    $alg = preg_replace("/<416>/","VD'",$alg); $alg = preg_replace("/<417>/","VD2",$alg); $alg = preg_replace("/<418>/","VD",$alg);
    
    /* --- 5xC: CODE -> SSE: [1] Numbered layer twists --- */
    $alg = preg_replace("/<101>/","NR'",$alg); $alg = preg_replace("/<102>/","NR2",$alg); $alg = preg_replace("/<103>/","NR",$alg);
    $alg = preg_replace("/<104>/","NL'",$alg); $alg = preg_replace("/<105>/","NL2",$alg); $alg = preg_replace("/<106>/","NL",$alg);
    $alg = preg_replace("/<107>/","NF'",$alg); $alg = preg_replace("/<108>/","NF2",$alg); $alg = preg_replace("/<109>/","NF",$alg);
    $alg = preg_replace("/<110>/","NB'",$alg); $alg = preg_replace("/<111>/","NB2",$alg); $alg = preg_replace("/<112>/","NB",$alg);
    $alg = preg_replace("/<113>/","NU'",$alg); $alg = preg_replace("/<114>/","NU2",$alg); $alg = preg_replace("/<115>/","NU",$alg);
    $alg = preg_replace("/<116>/","ND'",$alg); $alg = preg_replace("/<117>/","ND2",$alg); $alg = preg_replace("/<118>/","ND",$alg);
    
    $alg = preg_replace("/<119>/","MR'",$alg); $alg = preg_replace("/<120>/","MR2",$alg); $alg = preg_replace("/<121>/","MR",$alg);
    $alg = preg_replace("/<122>/","ML'",$alg); $alg = preg_replace("/<123>/","ML2",$alg); $alg = preg_replace("/<124>/","ML",$alg);
    $alg = preg_replace("/<125>/","MF'",$alg); $alg = preg_replace("/<126>/","MF2",$alg); $alg = preg_replace("/<127>/","MF",$alg);
    $alg = preg_replace("/<128>/","MB'",$alg); $alg = preg_replace("/<129>/","MB2",$alg); $alg = preg_replace("/<130>/","MB",$alg);
    $alg = preg_replace("/<131>/","MU'",$alg); $alg = preg_replace("/<132>/","MU2",$alg); $alg = preg_replace("/<133>/","MU",$alg);
    $alg = preg_replace("/<134>/","MD'",$alg); $alg = preg_replace("/<135>/","MD2",$alg); $alg = preg_replace("/<136>/","MD",$alg);
    
    /* --- 5xC: CODE -> SSE: [3] Tier twists --- */
    $alg = preg_replace("/<301>/","T4R'",$alg); $alg = preg_replace("/<302>/","T4R2",$alg); $alg = preg_replace("/<303>/","T4R",$alg);
    $alg = preg_replace("/<304>/","T4L'",$alg); $alg = preg_replace("/<305>/","T4L2",$alg); $alg = preg_replace("/<306>/","T4L",$alg);
    $alg = preg_replace("/<307>/","T4F'",$alg); $alg = preg_replace("/<308>/","T4F2",$alg); $alg = preg_replace("/<309>/","T4F",$alg);
    $alg = preg_replace("/<310>/","T4B'",$alg); $alg = preg_replace("/<311>/","T4B2",$alg); $alg = preg_replace("/<312>/","T4B",$alg);
    $alg = preg_replace("/<313>/","T4U'",$alg); $alg = preg_replace("/<314>/","T4U2",$alg); $alg = preg_replace("/<315>/","T4U",$alg);
    $alg = preg_replace("/<316>/","T4D'",$alg); $alg = preg_replace("/<317>/","T4D2",$alg); $alg = preg_replace("/<318>/","T4D",$alg);
    
    $alg = preg_replace("/<319>/","T3R'",$alg); $alg = preg_replace("/<320>/","T3R2",$alg); $alg = preg_replace("/<321>/","T3R",$alg);
    $alg = preg_replace("/<322>/","T3L'",$alg); $alg = preg_replace("/<323>/","T3L2",$alg); $alg = preg_replace("/<324>/","T3L",$alg);
    $alg = preg_replace("/<325>/","T3F'",$alg); $alg = preg_replace("/<326>/","T3F2",$alg); $alg = preg_replace("/<327>/","T3F",$alg);
    $alg = preg_replace("/<328>/","T3B'",$alg); $alg = preg_replace("/<329>/","T3B2",$alg); $alg = preg_replace("/<330>/","T3B",$alg);
    $alg = preg_replace("/<331>/","T3U'",$alg); $alg = preg_replace("/<332>/","T3U2",$alg); $alg = preg_replace("/<333>/","T3U",$alg);
    $alg = preg_replace("/<334>/","T3D'",$alg); $alg = preg_replace("/<335>/","T3D2",$alg); $alg = preg_replace("/<336>/","T3D",$alg);
    
    $alg = preg_replace("/<337>/","TR'",$alg); $alg = preg_replace("/<338>/","TR2",$alg); $alg = preg_replace("/<339>/","TR",$alg);
    $alg = preg_replace("/<340>/","TL'",$alg); $alg = preg_replace("/<341>/","TL2",$alg); $alg = preg_replace("/<342>/","TL",$alg);
    $alg = preg_replace("/<343>/","TF'",$alg); $alg = preg_replace("/<344>/","TF2",$alg); $alg = preg_replace("/<345>/","TF",$alg);
    $alg = preg_replace("/<346>/","TB'",$alg); $alg = preg_replace("/<347>/","TB2",$alg); $alg = preg_replace("/<348>/","TB",$alg);
    $alg = preg_replace("/<349>/","TU'",$alg); $alg = preg_replace("/<350>/","TU2",$alg); $alg = preg_replace("/<351>/","TU",$alg);
    $alg = preg_replace("/<352>/","TD'",$alg); $alg = preg_replace("/<353>/","TD2",$alg); $alg = preg_replace("/<354>/","TD",$alg);
    
    /* --- 5xC: CODE -> SSE: [7] Cube rotations --- */
    $alg = preg_replace("/<701>/","CR'",$alg); $alg = preg_replace("/<702>/","CR2",$alg); $alg = preg_replace("/<703>/","CR",$alg);
    $alg = preg_replace("/<704>/","CF'",$alg); $alg = preg_replace("/<705>/","CF2",$alg); $alg = preg_replace("/<706>/","CF",$alg);
    $alg = preg_replace("/<707>/","CU'",$alg); $alg = preg_replace("/<708>/","CU2",$alg); $alg = preg_replace("/<709>/","CU",$alg);
    
    /* --- 5xC: CODE -> SSE: [9] Face twists --- */
    $alg = preg_replace("/<901>/","R'",$alg); $alg = preg_replace("/<902>/","R2",$alg); $alg = preg_replace("/<903>/","R",$alg);
    $alg = preg_replace("/<904>/","L'",$alg); $alg = preg_replace("/<905>/","L2",$alg); $alg = preg_replace("/<906>/","L",$alg);
    $alg = preg_replace("/<907>/","F'",$alg); $alg = preg_replace("/<908>/","F2",$alg); $alg = preg_replace("/<909>/","F",$alg);
    $alg = preg_replace("/<910>/","B'",$alg); $alg = preg_replace("/<911>/","B2",$alg); $alg = preg_replace("/<912>/","B",$alg);
    $alg = preg_replace("/<913>/","U'",$alg); $alg = preg_replace("/<914>/","U2",$alg); $alg = preg_replace("/<915>/","U",$alg);
    $alg = preg_replace("/<916>/","D'",$alg); $alg = preg_replace("/<917>/","D2",$alg); $alg = preg_replace("/<918>/","D",$alg);
    
    return $alg;
  }
  
  
  
  
  /* 
  ---------------------------------------------------------------------------------------------------
  * alg6xC_SseToTwizzle($alg)
  * 
  * Converts 6x6 V-Cube 6 SSE algorithms into TWIZZLE notation.
  * 
  * Parameter: $alg (STRING): The algorithm.
  * 
  * Return: STRING.
  ---------------------------------------------------------------------------------------------------
  */
  function alg6xC_SseToTwizzle($alg) {
    /* --- 6xC: Preferences --- */
    $useSiGN    = false; // Notation style: SiGN or TWIZZLE (Default).
    $useMarkers = false; // 01.04.2021: Unfortunately Twizzle Explorer doesn't handle Markers correctly!
    
    /* --- 6xC: Marker --- */
    if ($useMarkers != true) {
      $alg = str_replace("·","",$alg); $alg = str_replace(".","",$alg); // Remove Markers!
    } else {
      $alg = str_replace("·",".",$alg);
    }
    
    /* ··································································································· */
    /* --- 6xC: SSE -> CODE: [1] Numbered-layer twists [5] Mid-layer twists --- */
    $alg = preg_replace("/NR'/","<101>",$alg); $alg = preg_replace("/NR-/","<101>",$alg);   $alg = preg_replace("/NR2/","<102>",$alg);   $alg = preg_replace("/NR/","<103>",$alg);
    $alg = preg_replace("/NL'/","<104>",$alg); $alg = preg_replace("/NL-/","<104>",$alg);   $alg = preg_replace("/NL2/","<105>",$alg);   $alg = preg_replace("/NL/","<106>",$alg);
    $alg = preg_replace("/NF'/","<107>",$alg); $alg = preg_replace("/NF-/","<107>",$alg);   $alg = preg_replace("/NF2/","<108>",$alg);   $alg = preg_replace("/NF/","<109>",$alg);
    $alg = preg_replace("/NB'/","<110>",$alg); $alg = preg_replace("/NB-/","<110>",$alg);   $alg = preg_replace("/NB2/","<111>",$alg);   $alg = preg_replace("/NB/","<112>",$alg);
    $alg = preg_replace("/NU'/","<113>",$alg); $alg = preg_replace("/NU-/","<113>",$alg);   $alg = preg_replace("/NU2/","<114>",$alg);   $alg = preg_replace("/NU/","<115>",$alg);
    $alg = preg_replace("/ND'/","<116>",$alg); $alg = preg_replace("/ND-/","<116>",$alg);   $alg = preg_replace("/ND2/","<117>",$alg);   $alg = preg_replace("/ND/","<118>",$alg);
    
    $alg = preg_replace("/N5R'/","<106>",$alg); $alg = preg_replace("/N5R-/","<106>",$alg);   $alg = preg_replace("/N5R2/","<105>",$alg);   $alg = preg_replace("/N5R/","<104>",$alg);
    $alg = preg_replace("/N5L'/","<103>",$alg); $alg = preg_replace("/N5L-/","<103>",$alg);   $alg = preg_replace("/N5L2/","<102>",$alg);   $alg = preg_replace("/N5L/","<101>",$alg);
    $alg = preg_replace("/N5F'/","<112>",$alg); $alg = preg_replace("/N5F-/","<112>",$alg);   $alg = preg_replace("/N5F2/","<111>",$alg);   $alg = preg_replace("/N5F/","<110>",$alg);
    $alg = preg_replace("/N5B'/","<109>",$alg); $alg = preg_replace("/N5B-/","<109>",$alg);   $alg = preg_replace("/N5B2/","<108>",$alg);   $alg = preg_replace("/N5B/","<107>",$alg);
    $alg = preg_replace("/N5U'/","<118>",$alg); $alg = preg_replace("/N5U-/","<118>",$alg);   $alg = preg_replace("/N5U2/","<117>",$alg);   $alg = preg_replace("/N5U/","<116>",$alg);
    $alg = preg_replace("/N5D'/","<115>",$alg); $alg = preg_replace("/N5D-/","<115>",$alg);   $alg = preg_replace("/N5D2/","<114>",$alg);   $alg = preg_replace("/N5D/","<113>",$alg);
    
    $alg = preg_replace("/N3R'/","<119>",$alg); $alg = preg_replace("/N3R-/","<119>",$alg);   $alg = preg_replace("/N3R2/","<120>",$alg);   $alg = preg_replace("/N3R/","<121>",$alg);
    $alg = preg_replace("/N3L'/","<122>",$alg); $alg = preg_replace("/N3L-/","<122>",$alg);   $alg = preg_replace("/N3L2/","<123>",$alg);   $alg = preg_replace("/N3L/","<124>",$alg);
    $alg = preg_replace("/N3F'/","<125>",$alg); $alg = preg_replace("/N3F-/","<125>",$alg);   $alg = preg_replace("/N3F2/","<126>",$alg);   $alg = preg_replace("/N3F/","<127>",$alg);
    $alg = preg_replace("/N3B'/","<128>",$alg); $alg = preg_replace("/N3B-/","<128>",$alg);   $alg = preg_replace("/N3B2/","<129>",$alg);   $alg = preg_replace("/N3B/","<130>",$alg);
    $alg = preg_replace("/N3U'/","<131>",$alg); $alg = preg_replace("/N3U-/","<131>",$alg);   $alg = preg_replace("/N3U2/","<132>",$alg);   $alg = preg_replace("/N3U/","<133>",$alg);
    $alg = preg_replace("/N3D'/","<134>",$alg); $alg = preg_replace("/N3D-/","<134>",$alg);   $alg = preg_replace("/N3D2/","<135>",$alg);   $alg = preg_replace("/N3D/","<136>",$alg);
    
    $alg = preg_replace("/N4R'/","<124>",$alg); $alg = preg_replace("/N4R-/","<124>",$alg);   $alg = preg_replace("/N4R2/","<123>",$alg);   $alg = preg_replace("/N4R/","<122>",$alg);
    $alg = preg_replace("/N4L'/","<121>",$alg); $alg = preg_replace("/N4L-/","<121>",$alg);   $alg = preg_replace("/N4L2/","<120>",$alg);   $alg = preg_replace("/N4L/","<119>",$alg);
    $alg = preg_replace("/N4F'/","<130>",$alg); $alg = preg_replace("/N4F-/","<130>",$alg);   $alg = preg_replace("/N4F2/","<129>",$alg);   $alg = preg_replace("/N4F/","<128>",$alg);
    $alg = preg_replace("/N4B'/","<127>",$alg); $alg = preg_replace("/N4B-/","<127>",$alg);   $alg = preg_replace("/N4B2/","<126>",$alg);   $alg = preg_replace("/N4B/","<125>",$alg);
    $alg = preg_replace("/N4U'/","<136>",$alg); $alg = preg_replace("/N4U-/","<136>",$alg);   $alg = preg_replace("/N4U2/","<135>",$alg);   $alg = preg_replace("/N4U/","<134>",$alg);
    $alg = preg_replace("/N4D'/","<133>",$alg); $alg = preg_replace("/N4D-/","<133>",$alg);   $alg = preg_replace("/N4D2/","<132>",$alg);   $alg = preg_replace("/N4D/","<131>",$alg);
    
    $alg = preg_replace("/MR'/","<119>",$alg); $alg = preg_replace("/MR-/","<119>",$alg);   $alg = preg_replace("/MR2/","<120>",$alg);   $alg = preg_replace("/MR/","<121>",$alg);
    $alg = preg_replace("/ML'/","<122>",$alg); $alg = preg_replace("/ML-/","<122>",$alg);   $alg = preg_replace("/ML2/","<123>",$alg);   $alg = preg_replace("/ML/","<124>",$alg);
    $alg = preg_replace("/MF'/","<125>",$alg); $alg = preg_replace("/MF-/","<125>",$alg);   $alg = preg_replace("/MF2/","<126>",$alg);   $alg = preg_replace("/MF/","<127>",$alg);
    $alg = preg_replace("/MB'/","<128>",$alg); $alg = preg_replace("/MB-/","<128>",$alg);   $alg = preg_replace("/MB2/","<129>",$alg);   $alg = preg_replace("/MB/","<130>",$alg);
    $alg = preg_replace("/MU'/","<131>",$alg); $alg = preg_replace("/MU-/","<131>",$alg);   $alg = preg_replace("/MU2/","<132>",$alg);   $alg = preg_replace("/MU/","<133>",$alg);
    $alg = preg_replace("/MD'/","<134>",$alg); $alg = preg_replace("/MD-/","<134>",$alg);   $alg = preg_replace("/MD2/","<135>",$alg);   $alg = preg_replace("/MD/","<136>",$alg);
    
    /* --- 6xC: SSE -> CODE: [2] Slice twists --- */
    $alg = preg_replace("/S2R'/","<201>",$alg); $alg = preg_replace("/S2R-/","<201>",$alg);   $alg = preg_replace("/S2R2/","<202>",$alg);   $alg = preg_replace("/S2R/","<203>",$alg);
    $alg = preg_replace("/S2L'/","<204>",$alg); $alg = preg_replace("/S2L-/","<204>",$alg);   $alg = preg_replace("/S2L2/","<205>",$alg);   $alg = preg_replace("/S2L/","<206>",$alg);
    $alg = preg_replace("/S2F'/","<207>",$alg); $alg = preg_replace("/S2F-/","<207>",$alg);   $alg = preg_replace("/S2F2/","<208>",$alg);   $alg = preg_replace("/S2F/","<209>",$alg);
    $alg = preg_replace("/S2B'/","<210>",$alg); $alg = preg_replace("/S2B-/","<210>",$alg);   $alg = preg_replace("/S2B2/","<211>",$alg);   $alg = preg_replace("/S2B/","<212>",$alg);
    $alg = preg_replace("/S2U'/","<213>",$alg); $alg = preg_replace("/S2U-/","<213>",$alg);   $alg = preg_replace("/S2U2/","<214>",$alg);   $alg = preg_replace("/S2U/","<215>",$alg);
    $alg = preg_replace("/S2D'/","<216>",$alg); $alg = preg_replace("/S2D-/","<216>",$alg);   $alg = preg_replace("/S2D2/","<217>",$alg);   $alg = preg_replace("/S2D/","<218>",$alg);
    
    $alg = preg_replace("/SR'/","<219>",$alg); $alg = preg_replace("/SR-/","<219>",$alg);   $alg = preg_replace("/SR2/","<220>",$alg);   $alg = preg_replace("/SR/","<221>",$alg);
    $alg = preg_replace("/SL'/","<222>",$alg); $alg = preg_replace("/SL-/","<222>",$alg);   $alg = preg_replace("/SL2/","<223>",$alg);   $alg = preg_replace("/SL/","<224>",$alg);
    $alg = preg_replace("/SF'/","<225>",$alg); $alg = preg_replace("/SF-/","<225>",$alg);   $alg = preg_replace("/SF2/","<226>",$alg);   $alg = preg_replace("/SF/","<227>",$alg);
    $alg = preg_replace("/SB'/","<228>",$alg); $alg = preg_replace("/SB-/","<228>",$alg);   $alg = preg_replace("/SB2/","<229>",$alg);   $alg = preg_replace("/SB/","<230>",$alg);
    $alg = preg_replace("/SU'/","<231>",$alg); $alg = preg_replace("/SU-/","<231>",$alg);   $alg = preg_replace("/SU2/","<232>",$alg);   $alg = preg_replace("/SU/","<233>",$alg);
    $alg = preg_replace("/SD'/","<234>",$alg); $alg = preg_replace("/SD-/","<234>",$alg);   $alg = preg_replace("/SD2/","<235>",$alg);   $alg = preg_replace("/SD/","<236>",$alg);
    
    $alg = preg_replace("/S2-2R'/","<237>",$alg); $alg = preg_replace("/S2-2R-/","<237>",$alg);   $alg = preg_replace("/S2-2R2/","<238>",$alg);   $alg = preg_replace("/S2-2R/","<239>",$alg);
    $alg = preg_replace("/S2-2L'/","<240>",$alg); $alg = preg_replace("/S2-2L-/","<240>",$alg);   $alg = preg_replace("/S2-2L2/","<241>",$alg);   $alg = preg_replace("/S2-2L/","<242>",$alg);
    $alg = preg_replace("/S2-2F'/","<243>",$alg); $alg = preg_replace("/S2-2F-/","<243>",$alg);   $alg = preg_replace("/S2-2F2/","<244>",$alg);   $alg = preg_replace("/S2-2F/","<245>",$alg);
    $alg = preg_replace("/S2-2B'/","<246>",$alg); $alg = preg_replace("/S2-2B-/","<246>",$alg);   $alg = preg_replace("/S2-2B2/","<247>",$alg);   $alg = preg_replace("/S2-2B/","<248>",$alg);
    $alg = preg_replace("/S2-2U'/","<249>",$alg); $alg = preg_replace("/S2-2U-/","<249>",$alg);   $alg = preg_replace("/S2-2U2/","<250>",$alg);   $alg = preg_replace("/S2-2U/","<251>",$alg);
    $alg = preg_replace("/S2-2D'/","<252>",$alg); $alg = preg_replace("/S2-2D-/","<252>",$alg);   $alg = preg_replace("/S2-2D2/","<253>",$alg);   $alg = preg_replace("/S2-2D/","<254>",$alg);
    
    $alg = preg_replace("/S2-3R'/","<255>",$alg); $alg = preg_replace("/S2-3R-/","<255>",$alg);   $alg = preg_replace("/S2-3R2/","<256>",$alg);   $alg = preg_replace("/S2-3R/","<257>",$alg);
    $alg = preg_replace("/S2-3L'/","<258>",$alg); $alg = preg_replace("/S2-3L-/","<258>",$alg);   $alg = preg_replace("/S2-3L2/","<259>",$alg);   $alg = preg_replace("/S2-3L/","<260>",$alg);
    $alg = preg_replace("/S2-3F'/","<261>",$alg); $alg = preg_replace("/S2-3F-/","<261>",$alg);   $alg = preg_replace("/S2-3F2/","<262>",$alg);   $alg = preg_replace("/S2-3F/","<263>",$alg);
    $alg = preg_replace("/S2-3B'/","<264>",$alg); $alg = preg_replace("/S2-3B-/","<264>",$alg);   $alg = preg_replace("/S2-3B2/","<265>",$alg);   $alg = preg_replace("/S2-3B/","<266>",$alg);
    $alg = preg_replace("/S2-3U'/","<267>",$alg); $alg = preg_replace("/S2-3U-/","<267>",$alg);   $alg = preg_replace("/S2-3U2/","<268>",$alg);   $alg = preg_replace("/S2-3U/","<269>",$alg);
    $alg = preg_replace("/S2-3D'/","<270>",$alg); $alg = preg_replace("/S2-3D-/","<270>",$alg);   $alg = preg_replace("/S2-3D2/","<271>",$alg);   $alg = preg_replace("/S2-3D/","<272>",$alg);
    
    $alg = preg_replace("/S2-4R'/","<273>",$alg); $alg = preg_replace("/S2-4R-/","<273>",$alg);   $alg = preg_replace("/S2-4R2/","<274>",$alg);   $alg = preg_replace("/S2-4R/","<275>",$alg);
    $alg = preg_replace("/S2-4L'/","<276>",$alg); $alg = preg_replace("/S2-4L-/","<276>",$alg);   $alg = preg_replace("/S2-4L2/","<277>",$alg);   $alg = preg_replace("/S2-4L/","<278>",$alg);
    $alg = preg_replace("/S2-4F'/","<279>",$alg); $alg = preg_replace("/S2-4F-/","<279>",$alg);   $alg = preg_replace("/S2-4F2/","<280>",$alg);   $alg = preg_replace("/S2-4F/","<281>",$alg);
    $alg = preg_replace("/S2-4B'/","<282>",$alg); $alg = preg_replace("/S2-4B-/","<282>",$alg);   $alg = preg_replace("/S2-4B2/","<283>",$alg);   $alg = preg_replace("/S2-4B/","<284>",$alg);
    $alg = preg_replace("/S2-4U'/","<285>",$alg); $alg = preg_replace("/S2-4U-/","<285>",$alg);   $alg = preg_replace("/S2-4U2/","<286>",$alg);   $alg = preg_replace("/S2-4U/","<287>",$alg);
    $alg = preg_replace("/S2-4D'/","<288>",$alg); $alg = preg_replace("/S2-4D-/","<288>",$alg);   $alg = preg_replace("/S2-4D2/","<289>",$alg);   $alg = preg_replace("/S2-4D/","<290>",$alg);
    
    $alg = preg_replace("/S3-3R'/","<291>",$alg);  $alg = preg_replace("/S3-3R-/","<291>",$alg);    $alg = preg_replace("/S3-3R2/","<292>",$alg);    $alg = preg_replace("/S3-3R/","<293>",$alg);
    $alg = preg_replace("/S3-3L'/","<294>",$alg);  $alg = preg_replace("/S3-3L-/","<294>",$alg);    $alg = preg_replace("/S3-3L2/","<295>",$alg);    $alg = preg_replace("/S3-3L/","<276>",$alg);
    $alg = preg_replace("/S3-3F'/","<297>",$alg);  $alg = preg_replace("/S3-3F-/","<297>",$alg);    $alg = preg_replace("/S3-3F2/","<298>",$alg);    $alg = preg_replace("/S3-3F/","<299>",$alg);
    $alg = preg_replace("/S3-3B'/","<2100>",$alg); $alg = preg_replace("/S3-3B-/","<2100>",$alg);   $alg = preg_replace("/S3-3B2/","<2101>",$alg);   $alg = preg_replace("/S3-3B/","<2102>",$alg);
    $alg = preg_replace("/S3-3U'/","<2103>",$alg); $alg = preg_replace("/S3-3U-/","<2103>",$alg);   $alg = preg_replace("/S3-3U2/","<2104>",$alg);   $alg = preg_replace("/S3-3U/","<2105>",$alg);
    $alg = preg_replace("/S3-3D'/","<2106>",$alg); $alg = preg_replace("/S3-3D-/","<2106>",$alg);   $alg = preg_replace("/S3-3D2/","<2107>",$alg);   $alg = preg_replace("/S3-3D/","<2108>",$alg);
    
    /* S3-4R */
    
    /* --- 6xC: SSE -> CODE: [3] Tier twists --- */
    $alg = preg_replace("/T5R'/","<301>",$alg); $alg = preg_replace("/T5R-/","<301>",$alg);   $alg = preg_replace("/T5R2/","<302>",$alg);   $alg = preg_replace("/T5R/","<303>",$alg);
    $alg = preg_replace("/T5L'/","<304>",$alg); $alg = preg_replace("/T5L-/","<304>",$alg);   $alg = preg_replace("/T5L2/","<305>",$alg);   $alg = preg_replace("/T5L/","<306>",$alg);
    $alg = preg_replace("/T5F'/","<307>",$alg); $alg = preg_replace("/T5F-/","<307>",$alg);   $alg = preg_replace("/T5F2/","<308>",$alg);   $alg = preg_replace("/T5F/","<309>",$alg);
    $alg = preg_replace("/T5B'/","<310>",$alg); $alg = preg_replace("/T5B-/","<310>",$alg);   $alg = preg_replace("/T5B2/","<311>",$alg);   $alg = preg_replace("/T5B/","<312>",$alg);
    $alg = preg_replace("/T5U'/","<313>",$alg); $alg = preg_replace("/T5U-/","<313>",$alg);   $alg = preg_replace("/T5U2/","<314>",$alg);   $alg = preg_replace("/T5U/","<315>",$alg);
    $alg = preg_replace("/T5D'/","<316>",$alg); $alg = preg_replace("/T5D-/","<316>",$alg);   $alg = preg_replace("/T5D2/","<317>",$alg);   $alg = preg_replace("/T5D/","<318>",$alg);
    
    $alg = preg_replace("/T4R'/","<319>",$alg); $alg = preg_replace("/T4R-/","<319>",$alg);   $alg = preg_replace("/T4R2/","<320>",$alg);   $alg = preg_replace("/T4R/","<321>",$alg);
    $alg = preg_replace("/T4L'/","<322>",$alg); $alg = preg_replace("/T4L-/","<322>",$alg);   $alg = preg_replace("/T4L2/","<323>",$alg);   $alg = preg_replace("/T4L/","<324>",$alg);
    $alg = preg_replace("/T4F'/","<325>",$alg); $alg = preg_replace("/T4F-/","<325>",$alg);   $alg = preg_replace("/T4F2/","<326>",$alg);   $alg = preg_replace("/T4F/","<327>",$alg);
    $alg = preg_replace("/T4B'/","<328>",$alg); $alg = preg_replace("/T4B-/","<328>",$alg);   $alg = preg_replace("/T4B2/","<329>",$alg);   $alg = preg_replace("/T4B/","<330>",$alg);
    $alg = preg_replace("/T4U'/","<331>",$alg); $alg = preg_replace("/T4U-/","<331>",$alg);   $alg = preg_replace("/T4U2/","<332>",$alg);   $alg = preg_replace("/T4U/","<333>",$alg);
    $alg = preg_replace("/T4D'/","<334>",$alg); $alg = preg_replace("/T4D-/","<334>",$alg);   $alg = preg_replace("/T4D2/","<335>",$alg);   $alg = preg_replace("/T4D/","<336>",$alg);
    
    $alg = preg_replace("/T3R'/","<337>",$alg); $alg = preg_replace("/T3R-/","<337>",$alg);   $alg = preg_replace("/T3R2/","<338>",$alg);   $alg = preg_replace("/T3R/","<339>",$alg);
    $alg = preg_replace("/T3L'/","<340>",$alg); $alg = preg_replace("/T3L-/","<340>",$alg);   $alg = preg_replace("/T3L2/","<341>",$alg);   $alg = preg_replace("/T3L/","<342>",$alg);
    $alg = preg_replace("/T3F'/","<343>",$alg); $alg = preg_replace("/T3F-/","<343>",$alg);   $alg = preg_replace("/T3F2/","<344>",$alg);   $alg = preg_replace("/T3F/","<345>",$alg);
    $alg = preg_replace("/T3B'/","<346>",$alg); $alg = preg_replace("/T3B-/","<346>",$alg);   $alg = preg_replace("/T3B2/","<347>",$alg);   $alg = preg_replace("/T3B/","<348>",$alg);
    $alg = preg_replace("/T3U'/","<349>",$alg); $alg = preg_replace("/T3U-/","<349>",$alg);   $alg = preg_replace("/T3U2/","<350>",$alg);   $alg = preg_replace("/T3U/","<351>",$alg);
    $alg = preg_replace("/T3D'/","<352>",$alg); $alg = preg_replace("/T3D-/","<352>",$alg);   $alg = preg_replace("/T3D2/","<353>",$alg);   $alg = preg_replace("/T3D/","<354>",$alg);
    
    $alg = preg_replace("/TR'/","<355>",$alg); $alg = preg_replace("/TR-/","<355>",$alg);   $alg = preg_replace("/TR2/","<356>",$alg);   $alg = preg_replace("/TR/","<357>",$alg);
    $alg = preg_replace("/TL'/","<358>",$alg); $alg = preg_replace("/TL-/","<358>",$alg);   $alg = preg_replace("/TL2/","<359>",$alg);   $alg = preg_replace("/TL/","<360>",$alg);
    $alg = preg_replace("/TF'/","<361>",$alg); $alg = preg_replace("/TF-/","<361>",$alg);   $alg = preg_replace("/TF2/","<362>",$alg);   $alg = preg_replace("/TF/","<363>",$alg);
    $alg = preg_replace("/TB'/","<364>",$alg); $alg = preg_replace("/TB-/","<364>",$alg);   $alg = preg_replace("/TB2/","<365>",$alg);   $alg = preg_replace("/TB/","<366>",$alg);
    $alg = preg_replace("/TU'/","<367>",$alg); $alg = preg_replace("/TU-/","<367>",$alg);   $alg = preg_replace("/TU2/","<368>",$alg);   $alg = preg_replace("/TU/","<369>",$alg);
    $alg = preg_replace("/TD'/","<370>",$alg); $alg = preg_replace("/TD-/","<370>",$alg);   $alg = preg_replace("/TD2/","<371>",$alg);   $alg = preg_replace("/TD/","<372>",$alg);
    
    /* --- 6xC: SSE -> CODE: [4] Void twists [1] Numbered layer twists--- */
    $alg = preg_replace("/V3R'/","<401>",$alg); $alg = preg_replace("/V3R-/","<401>",$alg);   $alg = preg_replace("/V3R2/","<402>",$alg);   $alg = preg_replace("/V3R/","<403>",$alg);
    $alg = preg_replace("/V3L'/","<404>",$alg); $alg = preg_replace("/V3L-/","<404>",$alg);   $alg = preg_replace("/V3L2/","<405>",$alg);   $alg = preg_replace("/V3L/","<406>",$alg);
    $alg = preg_replace("/V3F'/","<407>",$alg); $alg = preg_replace("/V3F-/","<407>",$alg);   $alg = preg_replace("/V3F2/","<408>",$alg);   $alg = preg_replace("/V3F/","<409>",$alg);
    $alg = preg_replace("/V3B'/","<410>",$alg); $alg = preg_replace("/V3B-/","<410>",$alg);   $alg = preg_replace("/V3B2/","<411>",$alg);   $alg = preg_replace("/V3B/","<412>",$alg);
    $alg = preg_replace("/V3U'/","<413>",$alg); $alg = preg_replace("/V3U-/","<413>",$alg);   $alg = preg_replace("/V3U2/","<414>",$alg);   $alg = preg_replace("/V3U/","<415>",$alg);
    $alg = preg_replace("/V3D'/","<416>",$alg); $alg = preg_replace("/V3D-/","<416>",$alg);   $alg = preg_replace("/V3D2/","<417>",$alg);   $alg = preg_replace("/V3D/","<418>",$alg);
    
    $alg = preg_replace("/N2-4R'/","<401>",$alg); $alg = preg_replace("/N2-4R-/","<401>",$alg);   $alg = preg_replace("/N2-4R2/","<402>",$alg);   $alg = preg_replace("/N2-4R/","<403>",$alg);
    $alg = preg_replace("/N2-4L'/","<404>",$alg); $alg = preg_replace("/N2-4L-/","<404>",$alg);   $alg = preg_replace("/N2-4L2/","<405>",$alg);   $alg = preg_replace("/N2-4L/","<406>",$alg);
    $alg = preg_replace("/N2-4F'/","<407>",$alg); $alg = preg_replace("/N2-4F-/","<407>",$alg);   $alg = preg_replace("/N2-4F2/","<408>",$alg);   $alg = preg_replace("/N2-4F/","<409>",$alg);
    $alg = preg_replace("/N2-4B'/","<410>",$alg); $alg = preg_replace("/N2-4B-/","<410>",$alg);   $alg = preg_replace("/N2-4B2/","<411>",$alg);   $alg = preg_replace("/N2-4B/","<412>",$alg);
    $alg = preg_replace("/N2-4U'/","<413>",$alg); $alg = preg_replace("/N2-4U-/","<413>",$alg);   $alg = preg_replace("/N2-4U2/","<414>",$alg);   $alg = preg_replace("/N2-4U/","<415>",$alg);
    $alg = preg_replace("/N2-4D'/","<416>",$alg); $alg = preg_replace("/N2-4D-/","<416>",$alg);   $alg = preg_replace("/N2-4D2/","<417>",$alg);   $alg = preg_replace("/N2-4D/","<418>",$alg);
    
    $alg = preg_replace("/M3R'/","<401>",$alg); $alg = preg_replace("/M3R-/","<401>",$alg);   $alg = preg_replace("/M3R2/","<402>",$alg);   $alg = preg_replace("/M3R/","<403>",$alg);
    $alg = preg_replace("/M3L'/","<404>",$alg); $alg = preg_replace("/M3L-/","<404>",$alg);   $alg = preg_replace("/M3L2/","<405>",$alg);   $alg = preg_replace("/M3L/","<406>",$alg);
    $alg = preg_replace("/M3F'/","<407>",$alg); $alg = preg_replace("/M3F-/","<407>",$alg);   $alg = preg_replace("/M3F2/","<408>",$alg);   $alg = preg_replace("/M3F/","<409>",$alg);
    $alg = preg_replace("/M3B'/","<410>",$alg); $alg = preg_replace("/M3B-/","<410>",$alg);   $alg = preg_replace("/M3B2/","<411>",$alg);   $alg = preg_replace("/M3B/","<412>",$alg);
    $alg = preg_replace("/M3U'/","<413>",$alg); $alg = preg_replace("/M3U-/","<413>",$alg);   $alg = preg_replace("/M3U2/","<414>",$alg);   $alg = preg_replace("/M3U/","<415>",$alg);
    $alg = preg_replace("/M3D'/","<416>",$alg); $alg = preg_replace("/M3D-/","<416>",$alg);   $alg = preg_replace("/M3D2/","<417>",$alg);   $alg = preg_replace("/M3D/","<418>",$alg);
    
    $alg = preg_replace("/VR'/","<419>",$alg); $alg = preg_replace("/VR-/","<419>",$alg);   $alg = preg_replace("/VR2/","<420>",$alg);   $alg = preg_replace("/VR/","<421>",$alg);
    $alg = preg_replace("/VL'/","<422>",$alg); $alg = preg_replace("/VL-/","<422>",$alg);   $alg = preg_replace("/VL2/","<423>",$alg);   $alg = preg_replace("/VL/","<424>",$alg);
    $alg = preg_replace("/VF'/","<425>",$alg); $alg = preg_replace("/VF-/","<425>",$alg);   $alg = preg_replace("/VF2/","<426>",$alg);   $alg = preg_replace("/VF/","<427>",$alg);
    $alg = preg_replace("/VB'/","<428>",$alg); $alg = preg_replace("/VB-/","<428>",$alg);   $alg = preg_replace("/VB2/","<429>",$alg);   $alg = preg_replace("/VB/","<430>",$alg);
    $alg = preg_replace("/VU'/","<431>",$alg); $alg = preg_replace("/VU-/","<431>",$alg);   $alg = preg_replace("/VU2/","<432>",$alg);   $alg = preg_replace("/VU/","<433>",$alg);
    $alg = preg_replace("/VD'/","<434>",$alg); $alg = preg_replace("/VD-/","<434>",$alg);   $alg = preg_replace("/VD2/","<435>",$alg);   $alg = preg_replace("/VD/","<436>",$alg);
    
    $alg = preg_replace("/N2-3R'/","<419>",$alg); $alg = preg_replace("/N2-3R-/","<419>",$alg);   $alg = preg_replace("/N2-3R2/","<420>",$alg);   $alg = preg_replace("/N2-3R/","<421>",$alg);
    $alg = preg_replace("/N2-3L'/","<422>",$alg); $alg = preg_replace("/N2-3L-/","<422>",$alg);   $alg = preg_replace("/N2-3L2/","<423>",$alg);   $alg = preg_replace("/N2-3L/","<424>",$alg);
    $alg = preg_replace("/N2-3F'/","<425>",$alg); $alg = preg_replace("/N2-3F-/","<425>",$alg);   $alg = preg_replace("/N2-3F2/","<426>",$alg);   $alg = preg_replace("/N2-3F/","<427>",$alg);
    $alg = preg_replace("/N2-3B'/","<428>",$alg); $alg = preg_replace("/N2-3B-/","<428>",$alg);   $alg = preg_replace("/N2-3B2/","<429>",$alg);   $alg = preg_replace("/N2-3B/","<430>",$alg);
    $alg = preg_replace("/N2-3U'/","<431>",$alg); $alg = preg_replace("/N2-3U-/","<431>",$alg);   $alg = preg_replace("/N2-3U2/","<432>",$alg);   $alg = preg_replace("/N2-3U/","<433>",$alg);
    $alg = preg_replace("/N2-3D'/","<434>",$alg); $alg = preg_replace("/N2-3D-/","<434>",$alg);   $alg = preg_replace("/N2-3D2/","<435>",$alg);   $alg = preg_replace("/N2-3D/","<436>",$alg);
    
    /* --- 6xC: SSE -> CODE: [5] Mid-layer twists [1] Numbered layer twists --- */
    $alg = preg_replace("/M2R'/","<501>",$alg); $alg = preg_replace("/M2R-/","<501>",$alg);   $alg = preg_replace("/M2R2/","<502>",$alg);   $alg = preg_replace("/M2R/","<503>",$alg);
    $alg = preg_replace("/M2L'/","<504>",$alg); $alg = preg_replace("/M2L-/","<504>",$alg);   $alg = preg_replace("/M2L2/","<505>",$alg);   $alg = preg_replace("/M2L/","<506>",$alg);
    $alg = preg_replace("/M2F'/","<507>",$alg); $alg = preg_replace("/M2F-/","<507>",$alg);   $alg = preg_replace("/M2F2/","<508>",$alg);   $alg = preg_replace("/M2F/","<509>",$alg);
    $alg = preg_replace("/M2B'/","<510>",$alg); $alg = preg_replace("/M2B-/","<510>",$alg);   $alg = preg_replace("/M2B2/","<511>",$alg);   $alg = preg_replace("/M2B/","<512>",$alg);
    $alg = preg_replace("/M2U'/","<513>",$alg); $alg = preg_replace("/M2U-/","<513>",$alg);   $alg = preg_replace("/M2U2/","<514>",$alg);   $alg = preg_replace("/M2U/","<515>",$alg);
    $alg = preg_replace("/M2D'/","<516>",$alg); $alg = preg_replace("/M2D-/","<516>",$alg);   $alg = preg_replace("/M2D2/","<517>",$alg);   $alg = preg_replace("/M2D/","<518>",$alg);
    
    $alg = preg_replace("/N3-4R'/","<501>",$alg); $alg = preg_replace("/N3-4R-/","<501>",$alg);   $alg = preg_replace("/N3-4R2/","<502>",$alg);   $alg = preg_replace("/N3-4R/","<503>",$alg);
    $alg = preg_replace("/N3-4L'/","<504>",$alg); $alg = preg_replace("/N3-4L-/","<504>",$alg);   $alg = preg_replace("/N3-4L2/","<505>",$alg);   $alg = preg_replace("/N3-4L/","<506>",$alg);
    $alg = preg_replace("/N3-4F'/","<507>",$alg); $alg = preg_replace("/N3-4F-/","<507>",$alg);   $alg = preg_replace("/N3-4F2/","<508>",$alg);   $alg = preg_replace("/N3-4F/","<509>",$alg);
    $alg = preg_replace("/N3-4B'/","<510>",$alg); $alg = preg_replace("/N3-4B-/","<510>",$alg);   $alg = preg_replace("/N3-4B2/","<511>",$alg);   $alg = preg_replace("/N3-4B/","<512>",$alg);
    $alg = preg_replace("/N3-4U'/","<513>",$alg); $alg = preg_replace("/N3-4U-/","<513>",$alg);   $alg = preg_replace("/N3-4U2/","<514>",$alg);   $alg = preg_replace("/N3-4U/","<515>",$alg);
    $alg = preg_replace("/N3-4D'/","<516>",$alg); $alg = preg_replace("/N3-4D-/","<516>",$alg);   $alg = preg_replace("/N3-4D2/","<517>",$alg);   $alg = preg_replace("/N3-4D/","<518>",$alg);
    
    /* --- 6xC: SSE -> CODE: [6] Wide-layer twists [5] (Mid-layer twists) [4] (Void twists) [1] Numbered layer twists --- */
    $alg = preg_replace("/WR'/","<601>",$alg); $alg = preg_replace("/WR-/","<601>",$alg);   $alg = preg_replace("/WR2/","<602>",$alg);   $alg = preg_replace("/WR/","<603>",$alg);
    $alg = preg_replace("/WL'/","<604>",$alg); $alg = preg_replace("/WL-/","<604>",$alg);   $alg = preg_replace("/WL2/","<605>",$alg);   $alg = preg_replace("/WL/","<606>",$alg);
    $alg = preg_replace("/WF'/","<607>",$alg); $alg = preg_replace("/WF-/","<607>",$alg);   $alg = preg_replace("/WF2/","<608>",$alg);   $alg = preg_replace("/WF/","<609>",$alg);
    $alg = preg_replace("/WB'/","<610>",$alg); $alg = preg_replace("/WB-/","<610>",$alg);   $alg = preg_replace("/WB2/","<611>",$alg);   $alg = preg_replace("/WB/","<612>",$alg);
    $alg = preg_replace("/WU'/","<613>",$alg); $alg = preg_replace("/WU-/","<613>",$alg);   $alg = preg_replace("/WU2/","<614>",$alg);   $alg = preg_replace("/WU/","<615>",$alg);
    $alg = preg_replace("/WD'/","<616>",$alg); $alg = preg_replace("/WD-/","<616>",$alg);   $alg = preg_replace("/WD2/","<617>",$alg);   $alg = preg_replace("/WD/","<618>",$alg);
    
    $alg = preg_replace("/M4R'/","<601>",$alg); $alg = preg_replace("/M4R-/","<601>",$alg);   $alg = preg_replace("/M4R2/","<602>",$alg);   $alg = preg_replace("/M4R/","<603>",$alg);
    $alg = preg_replace("/M4L'/","<604>",$alg); $alg = preg_replace("/M4L-/","<604>",$alg);   $alg = preg_replace("/M4L2/","<605>",$alg);   $alg = preg_replace("/M4L/","<606>",$alg);
    $alg = preg_replace("/M4F'/","<607>",$alg); $alg = preg_replace("/M4F-/","<607>",$alg);   $alg = preg_replace("/M4F2/","<608>",$alg);   $alg = preg_replace("/M4F/","<609>",$alg);
    $alg = preg_replace("/M4B'/","<610>",$alg); $alg = preg_replace("/M4B-/","<610>",$alg);   $alg = preg_replace("/M4B2/","<611>",$alg);   $alg = preg_replace("/M4B/","<612>",$alg);
    $alg = preg_replace("/M4U'/","<613>",$alg); $alg = preg_replace("/M4U-/","<613>",$alg);   $alg = preg_replace("/M4U2/","<614>",$alg);   $alg = preg_replace("/M4U/","<615>",$alg);
    $alg = preg_replace("/M4D'/","<616>",$alg); $alg = preg_replace("/M4D-/","<616>",$alg);   $alg = preg_replace("/M4D2/","<617>",$alg);   $alg = preg_replace("/M4D/","<618>",$alg);
    
    $alg = preg_replace("/V4R'/","<601>",$alg); $alg = preg_replace("/V4R-/","<601>",$alg);   $alg = preg_replace("/V4R2/","<602>",$alg);   $alg = preg_replace("/V4R/","<603>",$alg);
    $alg = preg_replace("/V4L'/","<604>",$alg); $alg = preg_replace("/V4L-/","<604>",$alg);   $alg = preg_replace("/V4L2/","<605>",$alg);   $alg = preg_replace("/V4L/","<606>",$alg);
    $alg = preg_replace("/V4F'/","<607>",$alg); $alg = preg_replace("/V4F-/","<607>",$alg);   $alg = preg_replace("/V4F2/","<608>",$alg);   $alg = preg_replace("/V4F/","<609>",$alg);
    $alg = preg_replace("/V4B'/","<610>",$alg); $alg = preg_replace("/V4B-/","<610>",$alg);   $alg = preg_replace("/V4B2/","<611>",$alg);   $alg = preg_replace("/V4B/","<612>",$alg);
    $alg = preg_replace("/V4U'/","<613>",$alg); $alg = preg_replace("/V4U-/","<613>",$alg);   $alg = preg_replace("/V4U2/","<614>",$alg);   $alg = preg_replace("/V4U/","<615>",$alg);
    $alg = preg_replace("/V4D'/","<616>",$alg); $alg = preg_replace("/V4D-/","<616>",$alg);   $alg = preg_replace("/V4D2/","<617>",$alg);   $alg = preg_replace("/V4D/","<618>",$alg);
    
    $alg = preg_replace("/N2-5R'/","<601>",$alg); $alg = preg_replace("/N2-5R-/","<601>",$alg);   $alg = preg_replace("/N2-5R2/","<602>",$alg);   $alg = preg_replace("/N2-5R/","<603>",$alg);
    $alg = preg_replace("/N2-5L'/","<604>",$alg); $alg = preg_replace("/N2-5L-/","<604>",$alg);   $alg = preg_replace("/N2-5L2/","<605>",$alg);   $alg = preg_replace("/N2-5L/","<606>",$alg);
    $alg = preg_replace("/N2-5F'/","<607>",$alg); $alg = preg_replace("/N2-5F-/","<607>",$alg);   $alg = preg_replace("/N2-5F2/","<608>",$alg);   $alg = preg_replace("/N2-5F/","<609>",$alg);
    $alg = preg_replace("/N2-5B'/","<610>",$alg); $alg = preg_replace("/N2-5B-/","<610>",$alg);   $alg = preg_replace("/N2-5B2/","<611>",$alg);   $alg = preg_replace("/N2-5B/","<612>",$alg);
    $alg = preg_replace("/N2-5U'/","<613>",$alg); $alg = preg_replace("/N2-5U-/","<613>",$alg);   $alg = preg_replace("/N2-5U2/","<614>",$alg);   $alg = preg_replace("/N2-5U/","<615>",$alg);
    $alg = preg_replace("/N2-5D'/","<616>",$alg); $alg = preg_replace("/N2-5D-/","<616>",$alg);   $alg = preg_replace("/N2-5D2/","<617>",$alg);   $alg = preg_replace("/N2-5D/","<618>",$alg);
    
    /* --- 6xC: SSE -> CODE: [7] Cube rotations --- */
    $alg = preg_replace("/CR'/","<701>",$alg); $alg = preg_replace("/CR-/","<701>",$alg);   $alg = preg_replace("/CR2/","<702>",$alg);   $alg = preg_replace("/CR/","<703>",$alg);
    $alg = preg_replace("/CL'/","<704>",$alg); $alg = preg_replace("/CL-/","<704>",$alg);   $alg = preg_replace("/CL2/","<705>",$alg);   $alg = preg_replace("/CL/","<706>",$alg);
    $alg = preg_replace("/CF'/","<707>",$alg); $alg = preg_replace("/CF-/","<707>",$alg);   $alg = preg_replace("/CF2/","<708>",$alg);   $alg = preg_replace("/CF/","<709>",$alg);
    $alg = preg_replace("/CB'/","<710>",$alg); $alg = preg_replace("/CB-/","<710>",$alg);   $alg = preg_replace("/CB2/","<711>",$alg);   $alg = preg_replace("/CB/","<712>",$alg);
    $alg = preg_replace("/CU'/","<713>",$alg); $alg = preg_replace("/CU-/","<713>",$alg);   $alg = preg_replace("/CU2/","<714>",$alg);   $alg = preg_replace("/CU/","<715>",$alg);
    $alg = preg_replace("/CD'/","<716>",$alg); $alg = preg_replace("/CD-/","<716>",$alg);   $alg = preg_replace("/CD2/","<717>",$alg);   $alg = preg_replace("/CD/","<718>",$alg);
    
    /* --- 6xC: SSE -> CODE: [9] Face twists --- */
    $alg = preg_replace("/R'/","<901>",$alg); $alg = preg_replace("/R-/","<901>",$alg);   $alg = preg_replace("/R2/","<902>",$alg);   $alg = preg_replace("/R/","<903>",$alg);
    $alg = preg_replace("/L'/","<904>",$alg); $alg = preg_replace("/L-/","<904>",$alg);   $alg = preg_replace("/L2/","<905>",$alg);   $alg = preg_replace("/L/","<906>",$alg);
    $alg = preg_replace("/F'/","<907>",$alg); $alg = preg_replace("/F-/","<907>",$alg);   $alg = preg_replace("/F2/","<908>",$alg);   $alg = preg_replace("/F/","<909>",$alg);
    $alg = preg_replace("/B'/","<910>",$alg); $alg = preg_replace("/B-/","<910>",$alg);   $alg = preg_replace("/B2/","<911>",$alg);   $alg = preg_replace("/B/","<912>",$alg);
    $alg = preg_replace("/U'/","<913>",$alg); $alg = preg_replace("/U-/","<913>",$alg);   $alg = preg_replace("/U2/","<914>",$alg);   $alg = preg_replace("/U/","<915>",$alg);
    $alg = preg_replace("/D'/","<916>",$alg); $alg = preg_replace("/D-/","<916>",$alg);   $alg = preg_replace("/D2/","<917>",$alg);   $alg = preg_replace("/D/","<918>",$alg);
    
    /* ··································································································· */
    /* --- 6xC: CODE -> TWIZZLE: [1] Numbered-layer twists --- */
    $alg = preg_replace("/<101>/","2R'",$alg);   $alg = preg_replace("/<102>/","2R2",$alg);   $alg = preg_replace("/<103>/","2R",$alg);
    $alg = preg_replace("/<104>/","2L'",$alg);   $alg = preg_replace("/<105>/","2L2",$alg);   $alg = preg_replace("/<106>/","2L",$alg);
    $alg = preg_replace("/<107>/","2F'",$alg);   $alg = preg_replace("/<108>/","2F2",$alg);   $alg = preg_replace("/<109>/","2F",$alg);
    $alg = preg_replace("/<110>/","2B'",$alg);   $alg = preg_replace("/<111>/","2B2",$alg);   $alg = preg_replace("/<112>/","2B",$alg);
    $alg = preg_replace("/<113>/","2U'",$alg);   $alg = preg_replace("/<114>/","2U2",$alg);   $alg = preg_replace("/<115>/","2U",$alg);
    $alg = preg_replace("/<116>/","2D'",$alg);   $alg = preg_replace("/<117>/","2D2",$alg);   $alg = preg_replace("/<118>/","2D",$alg);
    
    $alg = preg_replace("/<119>/","3R'",$alg);   $alg = preg_replace("/<120>/","3R2",$alg);   $alg = preg_replace("/<121>/","3R",$alg);
    $alg = preg_replace("/<122>/","3L'",$alg);   $alg = preg_replace("/<123>/","3L2",$alg);   $alg = preg_replace("/<124>/","3L",$alg);
    $alg = preg_replace("/<125>/","3F'",$alg);   $alg = preg_replace("/<126>/","3F2",$alg);   $alg = preg_replace("/<127>/","3F",$alg);
    $alg = preg_replace("/<128>/","3B'",$alg);   $alg = preg_replace("/<129>/","3B2",$alg);   $alg = preg_replace("/<130>/","3B",$alg);
    $alg = preg_replace("/<131>/","3U'",$alg);   $alg = preg_replace("/<132>/","3U2",$alg);   $alg = preg_replace("/<133>/","3U",$alg);
    $alg = preg_replace("/<134>/","3D'",$alg);   $alg = preg_replace("/<135>/","3D2",$alg);   $alg = preg_replace("/<136>/","3D",$alg);
    
    /* --- 6xC: CODE -> TWIZZLE: [2] Slice twists --- */
    $alg = preg_replace("/<201>/","r' l",$alg);   $alg = preg_replace("/<202>/","r2 l2",$alg);   $alg = preg_replace("/<203>/","r l'",$alg);
    $alg = preg_replace("/<204>/","r l'",$alg);   $alg = preg_replace("/<205>/","r2 l2",$alg);   $alg = preg_replace("/<206>/","r' l",$alg);
    $alg = preg_replace("/<207>/","f' b",$alg);   $alg = preg_replace("/<208>/","f2 b2",$alg);   $alg = preg_replace("/<209>/","f b'",$alg);
    $alg = preg_replace("/<210>/","f b'",$alg);   $alg = preg_replace("/<211>/","f2 b2",$alg);   $alg = preg_replace("/<212>/","f' b",$alg);
    $alg = preg_replace("/<213>/","u' d",$alg);   $alg = preg_replace("/<214>/","u2 d2",$alg);   $alg = preg_replace("/<215>/","u d'",$alg);
    $alg = preg_replace("/<216>/","u d'",$alg);   $alg = preg_replace("/<217>/","u2 d2",$alg);   $alg = preg_replace("/<218>/","u' d",$alg);
    
    $alg = preg_replace("/<219>/","R' L",$alg);   $alg = preg_replace("/<220>/","R2 L2",$alg);   $alg = preg_replace("/<221>/","R L'",$alg);
    $alg = preg_replace("/<222>/","R L'",$alg);   $alg = preg_replace("/<223>/","R2 L2",$alg);   $alg = preg_replace("/<224>/","R' L",$alg);
    $alg = preg_replace("/<225>/","F' B",$alg);   $alg = preg_replace("/<226>/","F2 B2",$alg);   $alg = preg_replace("/<227>/","F B'",$alg);
    $alg = preg_replace("/<228>/","F B'",$alg);   $alg = preg_replace("/<229>/","F2 B2",$alg);   $alg = preg_replace("/<230>/","F' B",$alg);
    $alg = preg_replace("/<231>/","U' D",$alg);   $alg = preg_replace("/<232>/","U2 D2",$alg);   $alg = preg_replace("/<233>/","U D'",$alg);
    $alg = preg_replace("/<234>/","U D'",$alg);   $alg = preg_replace("/<235>/","U2 D2",$alg);   $alg = preg_replace("/<236>/","U' D",$alg);
    
    $alg = preg_replace("/<237>/","R' 4l",$alg);   $alg = preg_replace("/<238>/","R2 4l2",$alg);   $alg = preg_replace("/<239>/","R 4l'",$alg);
    $alg = preg_replace("/<240>/","4r L'",$alg);   $alg = preg_replace("/<241>/","4r2 L2",$alg);   $alg = preg_replace("/<242>/","4r' L",$alg);
    $alg = preg_replace("/<243>/","F' 4b",$alg);   $alg = preg_replace("/<244>/","F2 4b2",$alg);   $alg = preg_replace("/<245>/","F 4b'",$alg);
    $alg = preg_replace("/<246>/","4f B'",$alg);   $alg = preg_replace("/<247>/","4f2 B2",$alg);   $alg = preg_replace("/<248>/","4f' B",$alg);
    $alg = preg_replace("/<249>/","U' 4d",$alg);   $alg = preg_replace("/<250>/","U2 4d2",$alg);   $alg = preg_replace("/<251>/","U 4d'",$alg);
    $alg = preg_replace("/<252>/","4u D'",$alg);   $alg = preg_replace("/<253>/","4u2 D2",$alg);   $alg = preg_replace("/<254>/","4u' D",$alg);
    
    $alg = preg_replace("/<255>/","R' 3l",$alg);   $alg = preg_replace("/<256>/","R2 3l2",$alg);   $alg = preg_replace("/<257>/","R 3l'",$alg);
    $alg = preg_replace("/<258>/","3r L'",$alg);   $alg = preg_replace("/<259>/","3r2 L2",$alg);   $alg = preg_replace("/<260>/","3r' L",$alg);
    $alg = preg_replace("/<261>/","F' 3b",$alg);   $alg = preg_replace("/<262>/","F2 3b2",$alg);   $alg = preg_replace("/<263>/","F 3b'",$alg);
    $alg = preg_replace("/<264>/","3f B'",$alg);   $alg = preg_replace("/<265>/","3f2 B2",$alg);   $alg = preg_replace("/<266>/","3f' B",$alg);
    $alg = preg_replace("/<267>/","U' 3d",$alg);   $alg = preg_replace("/<268>/","U2 3d2",$alg);   $alg = preg_replace("/<269>/","U 3d'",$alg);
    $alg = preg_replace("/<270>/","3u D'",$alg);   $alg = preg_replace("/<271>/","3u2 D2",$alg);   $alg = preg_replace("/<272>/","3u' D",$alg);
    
    $alg = preg_replace("/<273>/","R' l",$alg);   $alg = preg_replace("/<274>/","R2 l2",$alg);   $alg = preg_replace("/<275>/","R l'",$alg);
    $alg = preg_replace("/<276>/","r L'",$alg);   $alg = preg_replace("/<277>/","r2 L2",$alg);   $alg = preg_replace("/<278>/","r' L",$alg);
    $alg = preg_replace("/<279>/","F' b",$alg);   $alg = preg_replace("/<280>/","F2 b2",$alg);   $alg = preg_replace("/<281>/","F b'",$alg);
    $alg = preg_replace("/<282>/","f B'",$alg);   $alg = preg_replace("/<283>/","f2 B2",$alg);   $alg = preg_replace("/<284>/","f' B",$alg);
    $alg = preg_replace("/<285>/","U' d",$alg);   $alg = preg_replace("/<286>/","U2 d2",$alg);   $alg = preg_replace("/<287>/","U d'",$alg);
    $alg = preg_replace("/<288>/","u D'",$alg);   $alg = preg_replace("/<289>/","u2 D2",$alg);   $alg = preg_replace("/<290>/","u' D",$alg);
    
    $alg = preg_replace("/<291>/","r' 3l",$alg);    $alg = preg_replace("/<292>/","r2 3l2",$alg);    $alg = preg_replace("/<293>/","r 3l'",$alg);
    $alg = preg_replace("/<294>/","3r l'",$alg);    $alg = preg_replace("/<295>/","3r2 l2",$alg);    $alg = preg_replace("/<296>/","3r' l",$alg);
    $alg = preg_replace("/<297>/","f' 3b",$alg);    $alg = preg_replace("/<298>/","f2 3b2",$alg);    $alg = preg_replace("/<299>/","f 3b'",$alg);
    $alg = preg_replace("/<2100>/","3f b'",$alg);   $alg = preg_replace("/<2101>/","3f2 b2",$alg);   $alg = preg_replace("/<2102>/","3f' b",$alg);
    $alg = preg_replace("/<2103>/","u' 3d",$alg);   $alg = preg_replace("/<2104>/","u2 3d2",$alg);   $alg = preg_replace("/<2105>/","u 3d'",$alg);
    $alg = preg_replace("/<2106>/","3u d'",$alg);   $alg = preg_replace("/<2107>/","3u2 d2",$alg);   $alg = preg_replace("/<2108>/","3u' d",$alg);
    
    /* S3-4R */
    
    /* --- 6xC: CODE -> TWIZZLE: [3] Tier twists --- */
    $alg = preg_replace("/<301>/","5r'",$alg);   $alg = preg_replace("/<302>/","5r2",$alg);   $alg = preg_replace("/<303>/","5r",$alg);
    $alg = preg_replace("/<304>/","5l'",$alg);   $alg = preg_replace("/<305>/","5l2",$alg);   $alg = preg_replace("/<306>/","5l",$alg);
    $alg = preg_replace("/<307>/","5f'",$alg);   $alg = preg_replace("/<308>/","5f2",$alg);   $alg = preg_replace("/<309>/","5f",$alg);
    $alg = preg_replace("/<310>/","5b'",$alg);   $alg = preg_replace("/<311>/","5b2",$alg);   $alg = preg_replace("/<312>/","5b",$alg);
    $alg = preg_replace("/<313>/","5u'",$alg);   $alg = preg_replace("/<314>/","5u2",$alg);   $alg = preg_replace("/<315>/","5u",$alg);
    $alg = preg_replace("/<316>/","5d'",$alg);   $alg = preg_replace("/<317>/","5d2",$alg);   $alg = preg_replace("/<318>/","5d",$alg);
    
    $alg = preg_replace("/<319>/","4r'",$alg);   $alg = preg_replace("/<320>/","4r2",$alg);   $alg = preg_replace("/<321>/","4r",$alg);
    $alg = preg_replace("/<322>/","4l'",$alg);   $alg = preg_replace("/<323>/","4l2",$alg);   $alg = preg_replace("/<324>/","4l",$alg);
    $alg = preg_replace("/<325>/","4f'",$alg);   $alg = preg_replace("/<326>/","4f2",$alg);   $alg = preg_replace("/<327>/","4f",$alg);
    $alg = preg_replace("/<328>/","4b'",$alg);   $alg = preg_replace("/<329>/","4b2",$alg);   $alg = preg_replace("/<330>/","4b",$alg);
    $alg = preg_replace("/<331>/","4u'",$alg);   $alg = preg_replace("/<332>/","4u2",$alg);   $alg = preg_replace("/<333>/","4u",$alg);
    $alg = preg_replace("/<334>/","4d'",$alg);   $alg = preg_replace("/<335>/","4d2",$alg);   $alg = preg_replace("/<336>/","4d",$alg);
    
    $alg = preg_replace("/<337>/","3r'",$alg);   $alg = preg_replace("/<338>/","3r2",$alg);   $alg = preg_replace("/<339>/","3r",$alg);
    $alg = preg_replace("/<340>/","3l'",$alg);   $alg = preg_replace("/<341>/","3l2",$alg);   $alg = preg_replace("/<342>/","3l",$alg);
    $alg = preg_replace("/<343>/","3f'",$alg);   $alg = preg_replace("/<344>/","3f2",$alg);   $alg = preg_replace("/<345>/","3f",$alg);
    $alg = preg_replace("/<346>/","3b'",$alg);   $alg = preg_replace("/<347>/","3b2",$alg);   $alg = preg_replace("/<348>/","3b",$alg);
    $alg = preg_replace("/<349>/","3u'",$alg);   $alg = preg_replace("/<350>/","3u2",$alg);   $alg = preg_replace("/<351>/","3u",$alg);
    $alg = preg_replace("/<352>/","3d'",$alg);   $alg = preg_replace("/<353>/","3d2",$alg);   $alg = preg_replace("/<354>/","3d",$alg);
    
    $alg = preg_replace("/<355>/","r'",$alg);   $alg = preg_replace("/<356>/","r2",$alg);   $alg = preg_replace("/<357>/","r",$alg);
    $alg = preg_replace("/<358>/","l'",$alg);   $alg = preg_replace("/<359>/","l2",$alg);   $alg = preg_replace("/<360>/","l",$alg);
    $alg = preg_replace("/<361>/","f'",$alg);   $alg = preg_replace("/<362>/","f2",$alg);   $alg = preg_replace("/<363>/","f",$alg);
    $alg = preg_replace("/<364>/","b'",$alg);   $alg = preg_replace("/<365>/","b2",$alg);   $alg = preg_replace("/<366>/","b",$alg);
    $alg = preg_replace("/<367>/","u'",$alg);   $alg = preg_replace("/<368>/","u2",$alg);   $alg = preg_replace("/<369>/","u",$alg);
    $alg = preg_replace("/<370>/","d'",$alg);   $alg = preg_replace("/<371>/","d2",$alg);   $alg = preg_replace("/<372>/","d",$alg);
    
    /* --- 6xC: CODE -> TWIZZLE: [4] Void twists --- */
    $alg = preg_replace("/<401>/","2-4R'",$alg);   $alg = preg_replace("/<402>/","2-4R2",$alg);   $alg = preg_replace("/<403>/","2-4R",$alg);
    $alg = preg_replace("/<404>/","2-4L'",$alg);   $alg = preg_replace("/<405>/","2-4L2",$alg);   $alg = preg_replace("/<406>/","2-4L",$alg);
    $alg = preg_replace("/<407>/","2-4F'",$alg);   $alg = preg_replace("/<408>/","2-4F2",$alg);   $alg = preg_replace("/<409>/","2-4F",$alg);
    $alg = preg_replace("/<410>/","2-4B'",$alg);   $alg = preg_replace("/<411>/","2-4B2",$alg);   $alg = preg_replace("/<412>/","2-4B",$alg);
    $alg = preg_replace("/<413>/","2-4U'",$alg);   $alg = preg_replace("/<414>/","2-4U2",$alg);   $alg = preg_replace("/<415>/","2-4U",$alg);
    $alg = preg_replace("/<416>/","2-4D'",$alg);   $alg = preg_replace("/<417>/","2-4D2",$alg);   $alg = preg_replace("/<418>/","2-4D",$alg);
    
    $alg = preg_replace("/<419>/","2-3R'",$alg);   $alg = preg_replace("/<420>/","2-3R2",$alg);   $alg = preg_replace("/<421>/","2-3R",$alg);
    $alg = preg_replace("/<422>/","2-3L'",$alg);   $alg = preg_replace("/<423>/","2-3L2",$alg);   $alg = preg_replace("/<424>/","2-3L",$alg);
    $alg = preg_replace("/<425>/","2-3F'",$alg);   $alg = preg_replace("/<426>/","2-3F2",$alg);   $alg = preg_replace("/<427>/","2-3F",$alg);
    $alg = preg_replace("/<428>/","2-3B'",$alg);   $alg = preg_replace("/<429>/","2-3B2",$alg);   $alg = preg_replace("/<430>/","2-3B",$alg);
    $alg = preg_replace("/<431>/","2-3U'",$alg);   $alg = preg_replace("/<432>/","2-3U2",$alg);   $alg = preg_replace("/<433>/","2-3U",$alg);
    $alg = preg_replace("/<434>/","2-3D'",$alg);   $alg = preg_replace("/<435>/","2-3D2",$alg);   $alg = preg_replace("/<436>/","2-3D",$alg);
    
    /* --- 6xC: CODE -> TWIZZLE: [5] Mid-layer twists --- */
    $alg = preg_replace("/<501>/","3-4R'",$alg);   $alg = preg_replace("/<502>/","3-4R2",$alg);   $alg = preg_replace("/<503>/","3-4R",$alg);
    $alg = preg_replace("/<504>/","3-4L'",$alg);   $alg = preg_replace("/<505>/","3-4L2",$alg);   $alg = preg_replace("/<506>/","3-4L",$alg);
    $alg = preg_replace("/<507>/","3-4F'",$alg);   $alg = preg_replace("/<508>/","3-4F2",$alg);   $alg = preg_replace("/<509>/","3-4F",$alg);
    $alg = preg_replace("/<510>/","3-4B'",$alg);   $alg = preg_replace("/<511>/","3-4B2",$alg);   $alg = preg_replace("/<512>/","3-4B",$alg);
    $alg = preg_replace("/<513>/","3-4U'",$alg);   $alg = preg_replace("/<514>/","3-4U2",$alg);   $alg = preg_replace("/<515>/","3-4U",$alg);
    $alg = preg_replace("/<516>/","3-4D'",$alg);   $alg = preg_replace("/<517>/","3-4D2",$alg);   $alg = preg_replace("/<518>/","3-4D",$alg);
    
    /* --- 6xC: CODE -> TWIZZLE: [6] Wide-layer twists [5] (Mid-layer twists) --- */
    if ($useSiGN == true) { // Bei SiGN:
      $alg = preg_replace("/<601>/","m",$alg);    $alg = preg_replace("/<602>/","m2",$alg);   $alg = preg_replace("/<603>/","m'",$alg);
      $alg = preg_replace("/<604>/","m'",$alg);   $alg = preg_replace("/<605>/","m2",$alg);   $alg = preg_replace("/<606>/","m",$alg);
      $alg = preg_replace("/<607>/","s'",$alg);   $alg = preg_replace("/<608>/","s2",$alg);   $alg = preg_replace("/<609>/","s",$alg);
      $alg = preg_replace("/<610>/","s",$alg);    $alg = preg_replace("/<611>/","s2",$alg);   $alg = preg_replace("/<612>/","s'",$alg);
      $alg = preg_replace("/<613>/","e",$alg);    $alg = preg_replace("/<614>/","e2",$alg);   $alg = preg_replace("/<615>/","e'",$alg);
      $alg = preg_replace("/<616>/","e'",$alg);   $alg = preg_replace("/<617>/","e2",$alg);   $alg = preg_replace("/<618>/","e",$alg);
    } else {               // Sonst (TWIZZLE):
      $alg = preg_replace("/<601>/","2-5R'",$alg);   $alg = preg_replace("/<602>/","2-5R2",$alg);   $alg = preg_replace("/<603>/","2-5R",$alg);
      $alg = preg_replace("/<604>/","2-5L'",$alg);   $alg = preg_replace("/<605>/","2-5L2",$alg);   $alg = preg_replace("/<606>/","2-5L",$alg);
      $alg = preg_replace("/<607>/","2-5F'",$alg);   $alg = preg_replace("/<608>/","2-5F2",$alg);   $alg = preg_replace("/<609>/","2-5F",$alg);
      $alg = preg_replace("/<610>/","2-5B'",$alg);   $alg = preg_replace("/<611>/","2-5B2",$alg);   $alg = preg_replace("/<612>/","2-5B",$alg);
      $alg = preg_replace("/<613>/","2-5U'",$alg);   $alg = preg_replace("/<614>/","2-5U2",$alg);   $alg = preg_replace("/<615>/","2-5U",$alg);
      $alg = preg_replace("/<616>/","2-5D'",$alg);   $alg = preg_replace("/<617>/","2-5D2",$alg);   $alg = preg_replace("/<618>/","2-5D",$alg);
    }
    
    /* --- 6xC: CODE -> TWIZZLE: [7] Cube rotations --- */
    if ($useSiGN == true) { // Bei SiGN:
      $alg = preg_replace("/<701>/","x'",$alg);   $alg = preg_replace("/<702>/","x2",$alg);   $alg = preg_replace("/<703>/","x",$alg);
      $alg = preg_replace("/<704>/","x",$alg);    $alg = preg_replace("/<705>/","x2",$alg);   $alg = preg_replace("/<706>/","x'",$alg);
      $alg = preg_replace("/<707>/","z'",$alg);   $alg = preg_replace("/<708>/","z2",$alg);   $alg = preg_replace("/<709>/","z",$alg);
      $alg = preg_replace("/<710>/","z",$alg);    $alg = preg_replace("/<711>/","z2",$alg);   $alg = preg_replace("/<712>/","z'",$alg);
      $alg = preg_replace("/<713>/","y'",$alg);   $alg = preg_replace("/<714>/","y2",$alg);   $alg = preg_replace("/<715>/","y",$alg);
      $alg = preg_replace("/<716>/","y",$alg);    $alg = preg_replace("/<717>/","y2",$alg);   $alg = preg_replace("/<718>/","y'",$alg);
    } else {               // Sonst (TWIZZLE):
      $alg = preg_replace("/<701>/","Rv'",$alg);   $alg = preg_replace("/<702>/","Rv2",$alg);   $alg = preg_replace("/<703>/","Rv",$alg);
      $alg = preg_replace("/<704>/","Rv",$alg);    $alg = preg_replace("/<705>/","Rv2",$alg);   $alg = preg_replace("/<706>/","Rv'",$alg);
      $alg = preg_replace("/<707>/","Fv'",$alg);   $alg = preg_replace("/<708>/","Fv2",$alg);   $alg = preg_replace("/<709>/","Fv",$alg);
      $alg = preg_replace("/<710>/","Fv",$alg);    $alg = preg_replace("/<711>/","Fv2",$alg);   $alg = preg_replace("/<712>/","Fv'",$alg);
      $alg = preg_replace("/<713>/","Uv'",$alg);   $alg = preg_replace("/<714>/","Uv2",$alg);   $alg = preg_replace("/<715>/","Uv",$alg);
      $alg = preg_replace("/<716>/","Uv",$alg);    $alg = preg_replace("/<717>/","Uv2",$alg);   $alg = preg_replace("/<718>/","Uv'",$alg);
    }
    
    /* --- 6xC: CODE -> TWIZZLE: [9] Face twists --- */
    $alg = preg_replace("/<901>/","R'",$alg);   $alg = preg_replace("/<902>/","R2",$alg);   $alg = preg_replace("/<903>/","R",$alg);
    $alg = preg_replace("/<904>/","L'",$alg);   $alg = preg_replace("/<905>/","L2",$alg);   $alg = preg_replace("/<906>/","L",$alg);
    $alg = preg_replace("/<907>/","F'",$alg);   $alg = preg_replace("/<908>/","F2",$alg);   $alg = preg_replace("/<909>/","F",$alg);
    $alg = preg_replace("/<910>/","B'",$alg);   $alg = preg_replace("/<911>/","B2",$alg);   $alg = preg_replace("/<912>/","B",$alg);
    $alg = preg_replace("/<913>/","U'",$alg);   $alg = preg_replace("/<914>/","U2",$alg);   $alg = preg_replace("/<915>/","U",$alg);
    $alg = preg_replace("/<916>/","D'",$alg);   $alg = preg_replace("/<917>/","D2",$alg);   $alg = preg_replace("/<918>/","D",$alg);
    
    return $alg;
  }
  
  
  
  
  /* 
  ---------------------------------------------------------------------------------------------------
  * alg6xC_TwizzleToSse($alg)
  * 
  * Converts 6x6 V-Cube 6 TWIZZLE algorithms into SSE notation.
  * 
  * Parameter: $alg (STRING): The algorithm.
  * 
  * Return: STRING.
  ---------------------------------------------------------------------------------------------------
  */
  function alg6xC_TwizzleToSse($alg) {
    /* --- 6xC: Marker --- */
    $alg = str_replace(".","·",$alg);
    
    /* ··································································································· */
    /* --- 6xC: TWIZZLE -> CODE: [6] Wide layer twists --- */
    $alg = preg_replace("/2-5R'/","<601>",$alg); $alg = preg_replace("/2-5R2/","<602>",$alg); $alg = preg_replace("/2-5R/","<603>",$alg);
    $alg = preg_replace("/2-5L'/","<604>",$alg); $alg = preg_replace("/2-5L2/","<605>",$alg); $alg = preg_replace("/2-5L/","<606>",$alg);
    $alg = preg_replace("/2-5F'/","<607>",$alg); $alg = preg_replace("/2-5F2/","<608>",$alg); $alg = preg_replace("/2-5F/","<609>",$alg);
    $alg = preg_replace("/2-5B'/","<610>",$alg); $alg = preg_replace("/2-5B2/","<611>",$alg); $alg = preg_replace("/2-5B/","<612>",$alg);
    $alg = preg_replace("/2-5U'/","<613>",$alg); $alg = preg_replace("/2-5U2/","<614>",$alg); $alg = preg_replace("/2-5U/","<615>",$alg);
    $alg = preg_replace("/2-5D'/","<616>",$alg); $alg = preg_replace("/2-5D2/","<617>",$alg); $alg = preg_replace("/2-5D/","<618>",$alg);
    
    $alg = preg_replace("/m'/","<603>",$alg); $alg = preg_replace("/m2/","<602>",$alg); $alg = preg_replace("/m/","<601>",$alg);
    $alg = preg_replace("/s'/","<607>",$alg); $alg = preg_replace("/s2/","<608>",$alg); $alg = preg_replace("/s/","<609>",$alg);
    $alg = preg_replace("/e'/","<615>",$alg); $alg = preg_replace("/e2/","<614>",$alg); $alg = preg_replace("/e/","<613>",$alg);
    
    /* --- 6xC: TWIZZLE -> CODE: [4] Void twists --- */
    $alg = preg_replace("/2-3R'/","<401>",$alg); $alg = preg_replace("/2-3R2/","<402>",$alg); $alg = preg_replace("/2-3R/","<403>",$alg);
    $alg = preg_replace("/2-3L'/","<404>",$alg); $alg = preg_replace("/2-3L2/","<405>",$alg); $alg = preg_replace("/2-3L/","<406>",$alg);
    $alg = preg_replace("/2-3F'/","<407>",$alg); $alg = preg_replace("/2-3F2/","<408>",$alg); $alg = preg_replace("/2-3F/","<409>",$alg);
    $alg = preg_replace("/2-3B'/","<410>",$alg); $alg = preg_replace("/2-3B2/","<411>",$alg); $alg = preg_replace("/2-3B/","<412>",$alg);
    $alg = preg_replace("/2-3U'/","<413>",$alg); $alg = preg_replace("/2-3U2/","<414>",$alg); $alg = preg_replace("/2-3U/","<415>",$alg);
    $alg = preg_replace("/2-3D'/","<416>",$alg); $alg = preg_replace("/2-3D2/","<417>",$alg); $alg = preg_replace("/2-3D/","<418>",$alg);
    
    $alg = preg_replace("/2-4R'/","<419>",$alg); $alg = preg_replace("/2-4R2/","<420>",$alg); $alg = preg_replace("/2-4R/","<421>",$alg);
    $alg = preg_replace("/2-4L'/","<422>",$alg); $alg = preg_replace("/2-4L2/","<423>",$alg); $alg = preg_replace("/2-4L/","<424>",$alg);
    $alg = preg_replace("/2-4F'/","<425>",$alg); $alg = preg_replace("/2-4F2/","<426>",$alg); $alg = preg_replace("/2-4F/","<427>",$alg);
    $alg = preg_replace("/2-4B'/","<428>",$alg); $alg = preg_replace("/2-4B2/","<429>",$alg); $alg = preg_replace("/2-4B/","<430>",$alg);
    $alg = preg_replace("/2-4U'/","<431>",$alg); $alg = preg_replace("/2-4U2/","<432>",$alg); $alg = preg_replace("/2-4U/","<433>",$alg);
    $alg = preg_replace("/2-4D'/","<434>",$alg); $alg = preg_replace("/2-4D2/","<435>",$alg); $alg = preg_replace("/2-4D/","<436>",$alg);
    
    /* --- 6xC: TWIZZLE -> CODE: [5] Mid-layer twists --- */
    $alg = preg_replace("/3-4R'/","<501>",$alg); $alg = preg_replace("/3-4R2/","<502>",$alg); $alg = preg_replace("/3-4R/","<503>",$alg);
    $alg = preg_replace("/3-4L'/","<504>",$alg); $alg = preg_replace("/3-4L2/","<505>",$alg); $alg = preg_replace("/3-4L/","<506>",$alg);
    $alg = preg_replace("/3-4F'/","<507>",$alg); $alg = preg_replace("/3-4F2/","<508>",$alg); $alg = preg_replace("/3-4F/","<509>",$alg);
    $alg = preg_replace("/3-4B'/","<510>",$alg); $alg = preg_replace("/3-4B2/","<511>",$alg); $alg = preg_replace("/3-4B/","<512>",$alg);
    $alg = preg_replace("/3-4U'/","<513>",$alg); $alg = preg_replace("/3-4U2/","<514>",$alg); $alg = preg_replace("/3-4U/","<515>",$alg);
    $alg = preg_replace("/3-4D'/","<516>",$alg); $alg = preg_replace("/3-4D2/","<517>",$alg); $alg = preg_replace("/3-4D/","<518>",$alg);
    
    /* --- 6xC: TWIZZLE -> CODE: [3] Tier twists (WCA) --- */
    $alg = preg_replace("/5Rw'/","<301>",$alg); $alg = preg_replace("/5Rw2/","<302>",$alg); $alg = preg_replace("/5Rw/","<303>",$alg);
    $alg = preg_replace("/5Lw'/","<304>",$alg); $alg = preg_replace("/5Lw2/","<305>",$alg); $alg = preg_replace("/5Lw/","<306>",$alg);
    $alg = preg_replace("/5Fw'/","<307>",$alg); $alg = preg_replace("/5Fw2/","<308>",$alg); $alg = preg_replace("/5Fw/","<309>",$alg);
    $alg = preg_replace("/5Bw'/","<310>",$alg); $alg = preg_replace("/5Bw2/","<311>",$alg); $alg = preg_replace("/5Bw/","<312>",$alg);
    $alg = preg_replace("/5Uw'/","<313>",$alg); $alg = preg_replace("/5Uw2/","<314>",$alg); $alg = preg_replace("/5Uw/","<315>",$alg);
    $alg = preg_replace("/5Dw'/","<316>",$alg); $alg = preg_replace("/5Dw2/","<317>",$alg); $alg = preg_replace("/5Dw/","<318>",$alg);
    
    $alg = preg_replace("/4Rw'/","<319>",$alg); $alg = preg_replace("/4Rw2/","<320>",$alg); $alg = preg_replace("/4Rw/","<321>",$alg);
    $alg = preg_replace("/4Lw'/","<322>",$alg); $alg = preg_replace("/4Lw2/","<323>",$alg); $alg = preg_replace("/4Lw/","<324>",$alg);
    $alg = preg_replace("/4Fw'/","<325>",$alg); $alg = preg_replace("/4Fw2/","<326>",$alg); $alg = preg_replace("/4Fw/","<327>",$alg);
    $alg = preg_replace("/4Bw'/","<328>",$alg); $alg = preg_replace("/4Bw2/","<329>",$alg); $alg = preg_replace("/4Bw/","<330>",$alg);
    $alg = preg_replace("/4Uw'/","<331>",$alg); $alg = preg_replace("/4Uw2/","<332>",$alg); $alg = preg_replace("/4Uw/","<333>",$alg);
    $alg = preg_replace("/4Dw'/","<334>",$alg); $alg = preg_replace("/4Dw2/","<335>",$alg); $alg = preg_replace("/4Dw/","<336>",$alg);
    
    $alg = preg_replace("/3Rw'/","<337>",$alg); $alg = preg_replace("/3Rw2/","<338>",$alg); $alg = preg_replace("/3Rw/","<339>",$alg);
    $alg = preg_replace("/3Lw'/","<340>",$alg); $alg = preg_replace("/3Lw2/","<341>",$alg); $alg = preg_replace("/3Lw/","<342>",$alg);
    $alg = preg_replace("/3Fw'/","<343>",$alg); $alg = preg_replace("/3Fw2/","<344>",$alg); $alg = preg_replace("/3Fw/","<345>",$alg);
    $alg = preg_replace("/3Bw'/","<346>",$alg); $alg = preg_replace("/3Bw2/","<347>",$alg); $alg = preg_replace("/3Bw/","<348>",$alg);
    $alg = preg_replace("/3Uw'/","<349>",$alg); $alg = preg_replace("/3Uw2/","<350>",$alg); $alg = preg_replace("/3Uw/","<351>",$alg);
    $alg = preg_replace("/3Dw'/","<352>",$alg); $alg = preg_replace("/3Dw2/","<353>",$alg); $alg = preg_replace("/3Dw/","<354>",$alg);
    
    /* --- 6xC: TWIZZLE -> CODE: [1] Numbered layer twists --- */
    $alg = preg_replace("/2R'/","<101>",$alg); $alg = preg_replace("/2R2/","<102>",$alg); $alg = preg_replace("/2R/","<103>",$alg);
    $alg = preg_replace("/2L'/","<104>",$alg); $alg = preg_replace("/2L2/","<105>",$alg); $alg = preg_replace("/2L/","<106>",$alg);
    $alg = preg_replace("/2F'/","<107>",$alg); $alg = preg_replace("/2F2/","<108>",$alg); $alg = preg_replace("/2F/","<109>",$alg);
    $alg = preg_replace("/2B'/","<110>",$alg); $alg = preg_replace("/2B2/","<111>",$alg); $alg = preg_replace("/2B/","<112>",$alg);
    $alg = preg_replace("/2U'/","<113>",$alg); $alg = preg_replace("/2U2/","<114>",$alg); $alg = preg_replace("/2U/","<115>",$alg);
    $alg = preg_replace("/2D'/","<116>",$alg); $alg = preg_replace("/2D2/","<117>",$alg); $alg = preg_replace("/2D/","<118>",$alg);
    
    $alg = preg_replace("/5R'/","<106>",$alg); $alg = preg_replace("/5R2/","<105>",$alg); $alg = preg_replace("/5R/","<104>",$alg);
    $alg = preg_replace("/5L'/","<103>",$alg); $alg = preg_replace("/5L2/","<102>",$alg); $alg = preg_replace("/5L/","<101>",$alg);
    $alg = preg_replace("/5F'/","<112>",$alg); $alg = preg_replace("/5F2/","<111>",$alg); $alg = preg_replace("/5F/","<110>",$alg);
    $alg = preg_replace("/5B'/","<109>",$alg); $alg = preg_replace("/5B2/","<108>",$alg); $alg = preg_replace("/5B/","<107>",$alg);
    $alg = preg_replace("/5U'/","<118>",$alg); $alg = preg_replace("/5U2/","<117>",$alg); $alg = preg_replace("/5U/","<116>",$alg);
    $alg = preg_replace("/5D'/","<115>",$alg); $alg = preg_replace("/5D2/","<114>",$alg); $alg = preg_replace("/5D/","<113>",$alg);
    
    $alg = preg_replace("/3R'/","<119>",$alg); $alg = preg_replace("/3R2/","<120>",$alg); $alg = preg_replace("/3R/","<121>",$alg);
    $alg = preg_replace("/3L'/","<122>",$alg); $alg = preg_replace("/3L2/","<123>",$alg); $alg = preg_replace("/3L/","<124>",$alg);
    $alg = preg_replace("/3F'/","<125>",$alg); $alg = preg_replace("/3F2/","<126>",$alg); $alg = preg_replace("/3F/","<127>",$alg);
    $alg = preg_replace("/3B'/","<128>",$alg); $alg = preg_replace("/3B2/","<129>",$alg); $alg = preg_replace("/3B/","<130>",$alg);
    $alg = preg_replace("/3U'/","<131>",$alg); $alg = preg_replace("/3U2/","<132>",$alg); $alg = preg_replace("/3U/","<133>",$alg);
    $alg = preg_replace("/3D'/","<134>",$alg); $alg = preg_replace("/3D2/","<135>",$alg); $alg = preg_replace("/3D/","<136>",$alg);
    
    $alg = preg_replace("/4R'/","<124>",$alg); $alg = preg_replace("/4R2/","<123>",$alg); $alg = preg_replace("/4R/","<122>",$alg);
    $alg = preg_replace("/4L'/","<121>",$alg); $alg = preg_replace("/4L2/","<120>",$alg); $alg = preg_replace("/4L/","<119>",$alg);
    $alg = preg_replace("/4F'/","<130>",$alg); $alg = preg_replace("/4F2/","<129>",$alg); $alg = preg_replace("/4F/","<128>",$alg);
    $alg = preg_replace("/4B'/","<127>",$alg); $alg = preg_replace("/4B2/","<126>",$alg); $alg = preg_replace("/4B/","<125>",$alg);
    $alg = preg_replace("/4U'/","<136>",$alg); $alg = preg_replace("/4U2/","<135>",$alg); $alg = preg_replace("/4U/","<134>",$alg);
    $alg = preg_replace("/4D'/","<133>",$alg); $alg = preg_replace("/4D2/","<132>",$alg); $alg = preg_replace("/4D/","<131>",$alg);
    
    /* --- 6xC: TWIZZLE -> CODE: [3] Tier twists (SiGN) --- */
    $alg = preg_replace("/5r'/","<301>",$alg); $alg = preg_replace("/5r2/","<302>",$alg); $alg = preg_replace("/5r/","<303>",$alg);
    $alg = preg_replace("/5l'/","<304>",$alg); $alg = preg_replace("/5l2/","<305>",$alg); $alg = preg_replace("/5l/","<306>",$alg);
    $alg = preg_replace("/5f'/","<307>",$alg); $alg = preg_replace("/5f2/","<308>",$alg); $alg = preg_replace("/5f/","<309>",$alg);
    $alg = preg_replace("/5b'/","<310>",$alg); $alg = preg_replace("/5b2/","<311>",$alg); $alg = preg_replace("/5b/","<312>",$alg);
    $alg = preg_replace("/5u'/","<313>",$alg); $alg = preg_replace("/5u2/","<314>",$alg); $alg = preg_replace("/5u/","<315>",$alg);
    $alg = preg_replace("/5d'/","<316>",$alg); $alg = preg_replace("/5d2/","<317>",$alg); $alg = preg_replace("/5d/","<318>",$alg);
    
    $alg = preg_replace("/4r'/","<319>",$alg); $alg = preg_replace("/4r2/","<320>",$alg); $alg = preg_replace("/4r/","<321>",$alg);
    $alg = preg_replace("/4l'/","<322>",$alg); $alg = preg_replace("/4l2/","<323>",$alg); $alg = preg_replace("/4l/","<324>",$alg);
    $alg = preg_replace("/4f'/","<325>",$alg); $alg = preg_replace("/4f2/","<326>",$alg); $alg = preg_replace("/4f/","<327>",$alg);
    $alg = preg_replace("/4b'/","<328>",$alg); $alg = preg_replace("/4b2/","<329>",$alg); $alg = preg_replace("/4b/","<330>",$alg);
    $alg = preg_replace("/4u'/","<331>",$alg); $alg = preg_replace("/4u2/","<332>",$alg); $alg = preg_replace("/4u/","<333>",$alg);
    $alg = preg_replace("/4d'/","<334>",$alg); $alg = preg_replace("/4d2/","<335>",$alg); $alg = preg_replace("/4d/","<336>",$alg);
    
    $alg = preg_replace("/3r'/","<337>",$alg); $alg = preg_replace("/3r2/","<338>",$alg); $alg = preg_replace("/3r/","<339>",$alg);
    $alg = preg_replace("/3l'/","<340>",$alg); $alg = preg_replace("/3l2/","<341>",$alg); $alg = preg_replace("/3l/","<342>",$alg);
    $alg = preg_replace("/3f'/","<343>",$alg); $alg = preg_replace("/3f2/","<344>",$alg); $alg = preg_replace("/3f/","<345>",$alg);
    $alg = preg_replace("/3b'/","<346>",$alg); $alg = preg_replace("/3b2/","<347>",$alg); $alg = preg_replace("/3b/","<348>",$alg);
    $alg = preg_replace("/3u'/","<349>",$alg); $alg = preg_replace("/3u2/","<350>",$alg); $alg = preg_replace("/3u/","<351>",$alg);
    $alg = preg_replace("/3d'/","<352>",$alg); $alg = preg_replace("/3d2/","<353>",$alg); $alg = preg_replace("/3d/","<354>",$alg);
    
    /* --- 6xC: TWIZZLE -> CODE: [3] Tier twists (WCA) --- */
    $alg = preg_replace("/Rw'/","<355>",$alg); $alg = preg_replace("/Rw2/","<356>",$alg); $alg = preg_replace("/Rw/","<357>",$alg);
    $alg = preg_replace("/Lw'/","<358>",$alg); $alg = preg_replace("/Lw2/","<359>",$alg); $alg = preg_replace("/Lw/","<360>",$alg);
    $alg = preg_replace("/Fw'/","<361>",$alg); $alg = preg_replace("/Fw2/","<362>",$alg); $alg = preg_replace("/Fw/","<363>",$alg);
    $alg = preg_replace("/Bw'/","<364>",$alg); $alg = preg_replace("/Bw2/","<365>",$alg); $alg = preg_replace("/Bw/","<366>",$alg);
    $alg = preg_replace("/Uw'/","<367>",$alg); $alg = preg_replace("/Uw2/","<368>",$alg); $alg = preg_replace("/Uw/","<369>",$alg);
    $alg = preg_replace("/Dw'/","<370>",$alg); $alg = preg_replace("/Dw2/","<371>",$alg); $alg = preg_replace("/Dw/","<372>",$alg);
    
    /* --- 6xC: TWIZZLE -> CODE: [7] Cube rotations --- */
    $alg = preg_replace("/Rv'/","<701>",$alg); $alg = preg_replace("/Rv2/","<702>",$alg); $alg = preg_replace("/Rv/","<703>",$alg);
    $alg = preg_replace("/Lv'/","<703>",$alg); $alg = preg_replace("/Lv2/","<702>",$alg); $alg = preg_replace("/Lv/","<701>",$alg);
    $alg = preg_replace("/Fv'/","<704>",$alg); $alg = preg_replace("/Fv2/","<705>",$alg); $alg = preg_replace("/Fv/","<706>",$alg);
    $alg = preg_replace("/Bv'/","<706>",$alg); $alg = preg_replace("/Bv2/","<705>",$alg); $alg = preg_replace("/Bv/","<704>",$alg);
    $alg = preg_replace("/Uv'/","<707>",$alg); $alg = preg_replace("/Uv2/","<708>",$alg); $alg = preg_replace("/Uv/","<709>",$alg);
    $alg = preg_replace("/Dv'/","<709>",$alg); $alg = preg_replace("/Dv2/","<708>",$alg); $alg = preg_replace("/Dv/","<707>",$alg);
    
    $alg = preg_replace("/x'/","<701>",$alg); $alg = preg_replace("/x2/","<702>",$alg); $alg = preg_replace("/x/","<703>",$alg);
    $alg = preg_replace("/z'/","<704>",$alg); $alg = preg_replace("/z2/","<705>",$alg); $alg = preg_replace("/z/","<706>",$alg);
    $alg = preg_replace("/y'/","<707>",$alg); $alg = preg_replace("/y2/","<708>",$alg); $alg = preg_replace("/y/","<709>",$alg);
    
    /* --- 6xC: TWIZZLE -> CODE: [9] Face twists --- */
    $alg = preg_replace("/R'/","<901>",$alg); $alg = preg_replace("/R2/","<902>",$alg); $alg = preg_replace("/R/","<903>",$alg);
    $alg = preg_replace("/L'/","<904>",$alg); $alg = preg_replace("/L2/","<905>",$alg); $alg = preg_replace("/L/","<906>",$alg);
    $alg = preg_replace("/F'/","<907>",$alg); $alg = preg_replace("/F2/","<908>",$alg); $alg = preg_replace("/F/","<909>",$alg);
    $alg = preg_replace("/B'/","<910>",$alg); $alg = preg_replace("/B2/","<911>",$alg); $alg = preg_replace("/B/","<912>",$alg);
    $alg = preg_replace("/U'/","<913>",$alg); $alg = preg_replace("/U2/","<914>",$alg); $alg = preg_replace("/U/","<915>",$alg);
    $alg = preg_replace("/D'/","<916>",$alg); $alg = preg_replace("/D2/","<917>",$alg); $alg = preg_replace("/D/","<918>",$alg);
    
    /* --- 6xC: TWIZZLE -> CODE: [3] Tier twists (SiGN) --- */
    $alg = preg_replace("/r'/","<355>",$alg); $alg = preg_replace("/r2/","<356>",$alg); $alg = preg_replace("/r/","<357>",$alg);
    $alg = preg_replace("/l'/","<358>",$alg); $alg = preg_replace("/l2/","<359>",$alg); $alg = preg_replace("/l/","<360>",$alg);
    $alg = preg_replace("/f'/","<361>",$alg); $alg = preg_replace("/f2/","<362>",$alg); $alg = preg_replace("/f/","<363>",$alg);
    $alg = preg_replace("/b'/","<364>",$alg); $alg = preg_replace("/b2/","<365>",$alg); $alg = preg_replace("/b/","<366>",$alg);
    $alg = preg_replace("/u'/","<367>",$alg); $alg = preg_replace("/u2/","<368>",$alg); $alg = preg_replace("/u/","<369>",$alg);
    $alg = preg_replace("/d'/","<370>",$alg); $alg = preg_replace("/d2/","<371>",$alg); $alg = preg_replace("/d/","<372>",$alg);
    
    /* ··································································································· */
    /* --- 6xC: CODE -> SSE: [6] Wide layer twists --- */
    $alg = preg_replace("/<601>/","WR'",$alg); $alg = preg_replace("/<602>/","WR2",$alg); $alg = preg_replace("/<603>/","WR",$alg);
    $alg = preg_replace("/<604>/","WL'",$alg); $alg = preg_replace("/<605>/","WL2",$alg); $alg = preg_replace("/<606>/","WL",$alg);
    $alg = preg_replace("/<607>/","WF'",$alg); $alg = preg_replace("/<608>/","WF2",$alg); $alg = preg_replace("/<609>/","WF",$alg);
    $alg = preg_replace("/<610>/","WB'",$alg); $alg = preg_replace("/<611>/","WB2",$alg); $alg = preg_replace("/<612>/","WB",$alg);
    $alg = preg_replace("/<613>/","WU'",$alg); $alg = preg_replace("/<614>/","WU2",$alg); $alg = preg_replace("/<615>/","WU",$alg);
    $alg = preg_replace("/<616>/","WD'",$alg); $alg = preg_replace("/<617>/","WD2",$alg); $alg = preg_replace("/<618>/","WD",$alg);
    
    /* --- 6xC: CODE -> SSE: [4] Void twists --- */
    $alg = preg_replace("/<401>/","VR'",$alg); $alg = preg_replace("/<402>/","VR2",$alg); $alg = preg_replace("/<403>/","VR",$alg);
    $alg = preg_replace("/<404>/","VL'",$alg); $alg = preg_replace("/<405>/","VL2",$alg); $alg = preg_replace("/<406>/","VL",$alg);
    $alg = preg_replace("/<407>/","VF'",$alg); $alg = preg_replace("/<408>/","VF2",$alg); $alg = preg_replace("/<409>/","VF",$alg);
    $alg = preg_replace("/<410>/","VB'",$alg); $alg = preg_replace("/<411>/","VB2",$alg); $alg = preg_replace("/<412>/","VB",$alg);
    $alg = preg_replace("/<413>/","VU'",$alg); $alg = preg_replace("/<414>/","VU2",$alg); $alg = preg_replace("/<415>/","VU",$alg);
    $alg = preg_replace("/<416>/","VD'",$alg); $alg = preg_replace("/<417>/","VD2",$alg); $alg = preg_replace("/<418>/","VD",$alg);
    
    $alg = preg_replace("/<419>/","V3R'",$alg); $alg = preg_replace("/<420>/","V3R2",$alg); $alg = preg_replace("/<421>/","V3R",$alg);
    $alg = preg_replace("/<422>/","V3L'",$alg); $alg = preg_replace("/<423>/","V3L2",$alg); $alg = preg_replace("/<424>/","V3L",$alg);
    $alg = preg_replace("/<425>/","V3F'",$alg); $alg = preg_replace("/<426>/","V3F2",$alg); $alg = preg_replace("/<427>/","V3F",$alg);
    $alg = preg_replace("/<428>/","V3B'",$alg); $alg = preg_replace("/<429>/","V3B2",$alg); $alg = preg_replace("/<430>/","V3B",$alg);
    $alg = preg_replace("/<431>/","V3U'",$alg); $alg = preg_replace("/<432>/","V3U2",$alg); $alg = preg_replace("/<433>/","V3U",$alg);
    $alg = preg_replace("/<434>/","V3D'",$alg); $alg = preg_replace("/<435>/","V3D2",$alg); $alg = preg_replace("/<436>/","V3D",$alg);
    
    /* --- 6xC: CODE -> SSE: [5] Mid-layer twists --- */
    $alg = preg_replace("/<501>/","M2R'",$alg); $alg = preg_replace("/<502>/","M2R2",$alg); $alg = preg_replace("/<503>/","M2R",$alg);
    $alg = preg_replace("/<504>/","M2L'",$alg); $alg = preg_replace("/<505>/","M2L2",$alg); $alg = preg_replace("/<506>/","M2L",$alg);
    $alg = preg_replace("/<507>/","M2F'",$alg); $alg = preg_replace("/<508>/","M2F2",$alg); $alg = preg_replace("/<509>/","M2F",$alg);
    $alg = preg_replace("/<510>/","M2B'",$alg); $alg = preg_replace("/<511>/","M2B2",$alg); $alg = preg_replace("/<512>/","M2B",$alg);
    $alg = preg_replace("/<513>/","M2U'",$alg); $alg = preg_replace("/<514>/","M2U2",$alg); $alg = preg_replace("/<515>/","M2U",$alg);
    $alg = preg_replace("/<516>/","M2D'",$alg); $alg = preg_replace("/<517>/","M2D2",$alg); $alg = preg_replace("/<518>/","M2D",$alg);
    
    /* --- 6xC: CODE -> SSE: [1] Numbered layer twists --- */
    $alg = preg_replace("/<101>/","NR'",$alg); $alg = preg_replace("/<102>/","NR2",$alg); $alg = preg_replace("/<103>/","NR",$alg);
    $alg = preg_replace("/<104>/","NL'",$alg); $alg = preg_replace("/<105>/","NL2",$alg); $alg = preg_replace("/<106>/","NL",$alg);
    $alg = preg_replace("/<107>/","NF'",$alg); $alg = preg_replace("/<108>/","NF2",$alg); $alg = preg_replace("/<109>/","NF",$alg);
    $alg = preg_replace("/<110>/","NB'",$alg); $alg = preg_replace("/<111>/","NB2",$alg); $alg = preg_replace("/<112>/","NB",$alg);
    $alg = preg_replace("/<113>/","NU'",$alg); $alg = preg_replace("/<114>/","NU2",$alg); $alg = preg_replace("/<115>/","NU",$alg);
    $alg = preg_replace("/<116>/","ND'",$alg); $alg = preg_replace("/<117>/","ND2",$alg); $alg = preg_replace("/<118>/","ND",$alg);
    
    $alg = preg_replace("/<119>/","MR'",$alg); $alg = preg_replace("/<120>/","MR2",$alg); $alg = preg_replace("/<121>/","MR",$alg);
    $alg = preg_replace("/<122>/","ML'",$alg); $alg = preg_replace("/<123>/","ML2",$alg); $alg = preg_replace("/<124>/","ML",$alg);
    $alg = preg_replace("/<125>/","MF'",$alg); $alg = preg_replace("/<126>/","MF2",$alg); $alg = preg_replace("/<127>/","MF",$alg);
    $alg = preg_replace("/<128>/","MB'",$alg); $alg = preg_replace("/<129>/","MB2",$alg); $alg = preg_replace("/<130>/","MB",$alg);
    $alg = preg_replace("/<131>/","MU'",$alg); $alg = preg_replace("/<132>/","MU2",$alg); $alg = preg_replace("/<133>/","MU",$alg);
    $alg = preg_replace("/<134>/","MD'",$alg); $alg = preg_replace("/<135>/","MD2",$alg); $alg = preg_replace("/<136>/","MD",$alg);
    
    /* --- 6xC: CODE -> SSE: [3] Tier twists --- */
    $alg = preg_replace("/<301>/","T5R'",$alg); $alg = preg_replace("/<302>/","T5R2",$alg); $alg = preg_replace("/<303>/","T5R",$alg);
    $alg = preg_replace("/<304>/","T5L'",$alg); $alg = preg_replace("/<305>/","T5L2",$alg); $alg = preg_replace("/<306>/","T5L",$alg);
    $alg = preg_replace("/<307>/","T5F'",$alg); $alg = preg_replace("/<308>/","T5F2",$alg); $alg = preg_replace("/<309>/","T5F",$alg);
    $alg = preg_replace("/<310>/","T5B'",$alg); $alg = preg_replace("/<311>/","T5B2",$alg); $alg = preg_replace("/<312>/","T5B",$alg);
    $alg = preg_replace("/<313>/","T5U'",$alg); $alg = preg_replace("/<314>/","T5U2",$alg); $alg = preg_replace("/<315>/","T5U",$alg);
    $alg = preg_replace("/<316>/","T5D'",$alg); $alg = preg_replace("/<317>/","T5D2",$alg); $alg = preg_replace("/<318>/","T5D",$alg);
    
    $alg = preg_replace("/<319>/","T4R'",$alg); $alg = preg_replace("/<320>/","T4R2",$alg); $alg = preg_replace("/<321>/","T4R",$alg);
    $alg = preg_replace("/<322>/","T4L'",$alg); $alg = preg_replace("/<323>/","T4L2",$alg); $alg = preg_replace("/<324>/","T4L",$alg);
    $alg = preg_replace("/<325>/","T4F'",$alg); $alg = preg_replace("/<326>/","T4F2",$alg); $alg = preg_replace("/<327>/","T4F",$alg);
    $alg = preg_replace("/<328>/","T4B'",$alg); $alg = preg_replace("/<329>/","T4B2",$alg); $alg = preg_replace("/<330>/","T4B",$alg);
    $alg = preg_replace("/<331>/","T4U'",$alg); $alg = preg_replace("/<332>/","T4U2",$alg); $alg = preg_replace("/<333>/","T4U",$alg);
    $alg = preg_replace("/<334>/","T4D'",$alg); $alg = preg_replace("/<335>/","T4D2",$alg); $alg = preg_replace("/<336>/","T4D",$alg);
    
    $alg = preg_replace("/<337>/","T3R'",$alg); $alg = preg_replace("/<338>/","T3R2",$alg); $alg = preg_replace("/<339>/","T3R",$alg);
    $alg = preg_replace("/<340>/","T3L'",$alg); $alg = preg_replace("/<341>/","T3L2",$alg); $alg = preg_replace("/<342>/","T3L",$alg);
    $alg = preg_replace("/<343>/","T3F'",$alg); $alg = preg_replace("/<344>/","T3F2",$alg); $alg = preg_replace("/<345>/","T3F",$alg);
    $alg = preg_replace("/<346>/","T3B'",$alg); $alg = preg_replace("/<347>/","T3B2",$alg); $alg = preg_replace("/<348>/","T3B",$alg);
    $alg = preg_replace("/<349>/","T3U'",$alg); $alg = preg_replace("/<350>/","T3U2",$alg); $alg = preg_replace("/<351>/","T3U",$alg);
    $alg = preg_replace("/<352>/","T3D'",$alg); $alg = preg_replace("/<353>/","T3D2",$alg); $alg = preg_replace("/<354>/","T3D",$alg);
    
    $alg = preg_replace("/<355>/","TR'",$alg); $alg = preg_replace("/<356>/","TR2",$alg); $alg = preg_replace("/<357>/","TR",$alg);
    $alg = preg_replace("/<358>/","TL'",$alg); $alg = preg_replace("/<359>/","TL2",$alg); $alg = preg_replace("/<360>/","TL",$alg);
    $alg = preg_replace("/<361>/","TF'",$alg); $alg = preg_replace("/<362>/","TF2",$alg); $alg = preg_replace("/<363>/","TF",$alg);
    $alg = preg_replace("/<364>/","TB'",$alg); $alg = preg_replace("/<365>/","TB2",$alg); $alg = preg_replace("/<366>/","TB",$alg);
    $alg = preg_replace("/<367>/","TU'",$alg); $alg = preg_replace("/<368>/","TU2",$alg); $alg = preg_replace("/<369>/","TU",$alg);
    $alg = preg_replace("/<370>/","TD'",$alg); $alg = preg_replace("/<371>/","TD2",$alg); $alg = preg_replace("/<372>/","TD",$alg);
    
    /* --- 6xC: CODE -> SSE: [7] Cube rotations --- */
    $alg = preg_replace("/<701>/","CR'",$alg); $alg = preg_replace("/<702>/","CR2",$alg); $alg = preg_replace("/<703>/","CR",$alg);
    $alg = preg_replace("/<704>/","CF'",$alg); $alg = preg_replace("/<705>/","CF2",$alg); $alg = preg_replace("/<706>/","CF",$alg);
    $alg = preg_replace("/<707>/","CU'",$alg); $alg = preg_replace("/<708>/","CU2",$alg); $alg = preg_replace("/<709>/","CU",$alg);
    
    /* --- 6xC: CODE -> SSE: [9] Face twists --- */
    $alg = preg_replace("/<901>/","R'",$alg); $alg = preg_replace("/<902>/","R2",$alg); $alg = preg_replace("/<903>/","R",$alg);
    $alg = preg_replace("/<904>/","L'",$alg); $alg = preg_replace("/<905>/","L2",$alg); $alg = preg_replace("/<906>/","L",$alg);
    $alg = preg_replace("/<907>/","F'",$alg); $alg = preg_replace("/<908>/","F2",$alg); $alg = preg_replace("/<909>/","F",$alg);
    $alg = preg_replace("/<910>/","B'",$alg); $alg = preg_replace("/<911>/","B2",$alg); $alg = preg_replace("/<912>/","B",$alg);
    $alg = preg_replace("/<913>/","U'",$alg); $alg = preg_replace("/<914>/","U2",$alg); $alg = preg_replace("/<915>/","U",$alg);
    $alg = preg_replace("/<916>/","D'",$alg); $alg = preg_replace("/<917>/","D2",$alg); $alg = preg_replace("/<918>/","D",$alg);
    
    return $alg;
  }
  
  
  
  
  /* 
  ---------------------------------------------------------------------------------------------------
  * alg7xC_SseToTwizzle($alg)
  * 
  * Converts 7x7 V-Cube 7 SSE algorithms into TWIZZLE notation.
  * 
  * Parameter: $alg (STRING): The algorithm.
  * 
  * Return: STRING.
  ---------------------------------------------------------------------------------------------------
  */
  function alg7xC_SseToTwizzle($alg) {
    /* --- 7xC: Preferences --- */
    $useSiGN    = false; // Notation style: SiGN or TWIZZLE (Default).
    $useMarkers = false; // 01.04.2021: Unfortunately Twizzle Explorer doesn't handle Markers correctly!
    
    /* --- 7xC: Marker --- */
    if ($useMarkers != true) {
      $alg = str_replace("·","",$alg); $alg = str_replace(".","",$alg); // Remove Markers!
    } else {
      $alg = str_replace("·",".",$alg);
    }
    
    /* ··································································································· */
    /* --- 7xC: SSE -> CODE: [1] Numbered-layer twists [5] Mid-layer twists --- */
    $alg = preg_replace("/NR'/","<101>",$alg); $alg = preg_replace("/NR-/","<101>",$alg);   $alg = preg_replace("/NR2/","<102>",$alg);   $alg = preg_replace("/NR/","<103>",$alg);
    $alg = preg_replace("/NL'/","<104>",$alg); $alg = preg_replace("/NL-/","<104>",$alg);   $alg = preg_replace("/NL2/","<105>",$alg);   $alg = preg_replace("/NL/","<106>",$alg);
    $alg = preg_replace("/NF'/","<107>",$alg); $alg = preg_replace("/NF-/","<107>",$alg);   $alg = preg_replace("/NF2/","<108>",$alg);   $alg = preg_replace("/NF/","<109>",$alg);
    $alg = preg_replace("/NB'/","<110>",$alg); $alg = preg_replace("/NB-/","<110>",$alg);   $alg = preg_replace("/NB2/","<111>",$alg);   $alg = preg_replace("/NB/","<112>",$alg);
    $alg = preg_replace("/NU'/","<113>",$alg); $alg = preg_replace("/NU-/","<113>",$alg);   $alg = preg_replace("/NU2/","<114>",$alg);   $alg = preg_replace("/NU/","<115>",$alg);
    $alg = preg_replace("/ND'/","<116>",$alg); $alg = preg_replace("/ND-/","<116>",$alg);   $alg = preg_replace("/ND2/","<117>",$alg);   $alg = preg_replace("/ND/","<118>",$alg);
    
    $alg = preg_replace("/N6R'/","<106>",$alg); $alg = preg_replace("/N6R-/","<106>",$alg);   $alg = preg_replace("/N6R2/","<105>",$alg);   $alg = preg_replace("/N6R/","<104>",$alg);
    $alg = preg_replace("/N6L'/","<103>",$alg); $alg = preg_replace("/N6L-/","<103>",$alg);   $alg = preg_replace("/N6L2/","<102>",$alg);   $alg = preg_replace("/N6L/","<101>",$alg);
    $alg = preg_replace("/N6F'/","<112>",$alg); $alg = preg_replace("/N6F-/","<112>",$alg);   $alg = preg_replace("/N6F2/","<111>",$alg);   $alg = preg_replace("/N6F/","<110>",$alg);
    $alg = preg_replace("/N6B'/","<109>",$alg); $alg = preg_replace("/N6B-/","<109>",$alg);   $alg = preg_replace("/N6B2/","<108>",$alg);   $alg = preg_replace("/N6B/","<107>",$alg);
    $alg = preg_replace("/N6U'/","<118>",$alg); $alg = preg_replace("/N6U-/","<118>",$alg);   $alg = preg_replace("/N6U2/","<117>",$alg);   $alg = preg_replace("/N6U/","<116>",$alg);
    $alg = preg_replace("/N6D'/","<115>",$alg); $alg = preg_replace("/N6D-/","<115>",$alg);   $alg = preg_replace("/N6D2/","<114>",$alg);   $alg = preg_replace("/N6D/","<113>",$alg);
    
    $alg = preg_replace("/N3R'/","<119>",$alg); $alg = preg_replace("/N3R-/","<119>",$alg);   $alg = preg_replace("/N3R2/","<120>",$alg);   $alg = preg_replace("/N3R/","<121>",$alg);
    $alg = preg_replace("/N3L'/","<122>",$alg); $alg = preg_replace("/N3L-/","<122>",$alg);   $alg = preg_replace("/N3L2/","<123>",$alg);   $alg = preg_replace("/N3L/","<124>",$alg);
    $alg = preg_replace("/N3F'/","<125>",$alg); $alg = preg_replace("/N3F-/","<125>",$alg);   $alg = preg_replace("/N3F2/","<126>",$alg);   $alg = preg_replace("/N3F/","<127>",$alg);
    $alg = preg_replace("/N3B'/","<128>",$alg); $alg = preg_replace("/N3B-/","<128>",$alg);   $alg = preg_replace("/N3B2/","<129>",$alg);   $alg = preg_replace("/N3B/","<130>",$alg);
    $alg = preg_replace("/N3U'/","<131>",$alg); $alg = preg_replace("/N3U-/","<131>",$alg);   $alg = preg_replace("/N3U2/","<132>",$alg);   $alg = preg_replace("/N3U/","<133>",$alg);
    $alg = preg_replace("/N3D'/","<134>",$alg); $alg = preg_replace("/N3D-/","<134>",$alg);   $alg = preg_replace("/N3D2/","<135>",$alg);   $alg = preg_replace("/N3D/","<136>",$alg);
    
    $alg = preg_replace("/N5R'/","<124>",$alg); $alg = preg_replace("/N5R-/","<124>",$alg);   $alg = preg_replace("/N5R2/","<123>",$alg);   $alg = preg_replace("/N5R/","<122>",$alg);
    $alg = preg_replace("/N5L'/","<121>",$alg); $alg = preg_replace("/N5L-/","<121>",$alg);   $alg = preg_replace("/N5L2/","<120>",$alg);   $alg = preg_replace("/N5L/","<119>",$alg);
    $alg = preg_replace("/N5F'/","<130>",$alg); $alg = preg_replace("/N5F-/","<130>",$alg);   $alg = preg_replace("/N5F2/","<129>",$alg);   $alg = preg_replace("/N5F/","<128>",$alg);
    $alg = preg_replace("/N5B'/","<127>",$alg); $alg = preg_replace("/N5B-/","<127>",$alg);   $alg = preg_replace("/N5B2/","<126>",$alg);   $alg = preg_replace("/N5B/","<125>",$alg);
    $alg = preg_replace("/N5U'/","<136>",$alg); $alg = preg_replace("/N5U-/","<136>",$alg);   $alg = preg_replace("/N5U2/","<135>",$alg);   $alg = preg_replace("/N5U/","<134>",$alg);
    $alg = preg_replace("/N5D'/","<133>",$alg); $alg = preg_replace("/N5D-/","<133>",$alg);   $alg = preg_replace("/N5D2/","<132>",$alg);   $alg = preg_replace("/N5D/","<131>",$alg);
    
    $alg = preg_replace("/N4R'/","<137>",$alg); $alg = preg_replace("/N4R-/","<137>",$alg);   $alg = preg_replace("/N4R2/","<138>",$alg);   $alg = preg_replace("/N4R/","<139>",$alg);
    $alg = preg_replace("/N4L'/","<140>",$alg); $alg = preg_replace("/N4L-/","<140>",$alg);   $alg = preg_replace("/N4L2/","<141>",$alg);   $alg = preg_replace("/N4L/","<142>",$alg);
    $alg = preg_replace("/N4F'/","<143>",$alg); $alg = preg_replace("/N4F-/","<143>",$alg);   $alg = preg_replace("/N4F2/","<144>",$alg);   $alg = preg_replace("/N4F/","<145>",$alg);
    $alg = preg_replace("/N4B'/","<146>",$alg); $alg = preg_replace("/N4B-/","<146>",$alg);   $alg = preg_replace("/N4B2/","<147>",$alg);   $alg = preg_replace("/N4B/","<148>",$alg);
    $alg = preg_replace("/N4U'/","<149>",$alg); $alg = preg_replace("/N4U-/","<149>",$alg);   $alg = preg_replace("/N4U2/","<150>",$alg);   $alg = preg_replace("/N4U/","<151>",$alg);
    $alg = preg_replace("/N4D'/","<152>",$alg); $alg = preg_replace("/N4D-/","<152>",$alg);   $alg = preg_replace("/N4D2/","<153>",$alg);   $alg = preg_replace("/N4D/","<154>",$alg);
    
    $alg = preg_replace("/MR'/","<137>",$alg); $alg = preg_replace("/MR-/","<137>",$alg);   $alg = preg_replace("/MR2/","<138>",$alg);   $alg = preg_replace("/MR/","<139>",$alg);
    $alg = preg_replace("/ML'/","<140>",$alg); $alg = preg_replace("/ML-/","<140>",$alg);   $alg = preg_replace("/ML2/","<141>",$alg);   $alg = preg_replace("/ML/","<142>",$alg);
    $alg = preg_replace("/MF'/","<143>",$alg); $alg = preg_replace("/MF-/","<143>",$alg);   $alg = preg_replace("/MF2/","<144>",$alg);   $alg = preg_replace("/MF/","<145>",$alg);
    $alg = preg_replace("/MB'/","<146>",$alg); $alg = preg_replace("/MB-/","<146>",$alg);   $alg = preg_replace("/MB2/","<147>",$alg);   $alg = preg_replace("/MB/","<148>",$alg);
    $alg = preg_replace("/MU'/","<149>",$alg); $alg = preg_replace("/MU-/","<149>",$alg);   $alg = preg_replace("/MU2/","<150>",$alg);   $alg = preg_replace("/MU/","<151>",$alg);
    $alg = preg_replace("/MD'/","<152>",$alg); $alg = preg_replace("/MD-/","<152>",$alg);   $alg = preg_replace("/MD2/","<153>",$alg);   $alg = preg_replace("/MD/","<154>",$alg);
    
    /* --- 7xC: SSE -> CODE: [2] Slice twists --- */
    $alg = preg_replace("/S3R'/","<201>",$alg); $alg = preg_replace("/S3R-/","<201>",$alg);   $alg = preg_replace("/S3R2/","<202>",$alg);   $alg = preg_replace("/S3R/","<203>",$alg);
    $alg = preg_replace("/S3L'/","<204>",$alg); $alg = preg_replace("/S3L-/","<204>",$alg);   $alg = preg_replace("/S3L2/","<205>",$alg);   $alg = preg_replace("/S3L/","<206>",$alg);
    $alg = preg_replace("/S3F'/","<207>",$alg); $alg = preg_replace("/S3F-/","<207>",$alg);   $alg = preg_replace("/S3F2/","<208>",$alg);   $alg = preg_replace("/S3F/","<209>",$alg);
    $alg = preg_replace("/S3B'/","<210>",$alg); $alg = preg_replace("/S3B-/","<210>",$alg);   $alg = preg_replace("/S3B2/","<211>",$alg);   $alg = preg_replace("/S3B/","<212>",$alg);
    $alg = preg_replace("/S3U'/","<213>",$alg); $alg = preg_replace("/S3U-/","<213>",$alg);   $alg = preg_replace("/S3U2/","<214>",$alg);   $alg = preg_replace("/S3U/","<215>",$alg);
    $alg = preg_replace("/S3D'/","<216>",$alg); $alg = preg_replace("/S3D-/","<216>",$alg);   $alg = preg_replace("/S3D2/","<217>",$alg);   $alg = preg_replace("/S3D/","<218>",$alg);
    
    $alg = preg_replace("/S2R'/","<219>",$alg); $alg = preg_replace("/S2R-/","<219>",$alg);   $alg = preg_replace("/S2R2/","<220>",$alg);   $alg = preg_replace("/S2R/","<221>",$alg);
    $alg = preg_replace("/S2L'/","<222>",$alg); $alg = preg_replace("/S2L-/","<222>",$alg);   $alg = preg_replace("/S2L2/","<223>",$alg);   $alg = preg_replace("/S2L/","<224>",$alg);
    $alg = preg_replace("/S2F'/","<225>",$alg); $alg = preg_replace("/S2F-/","<225>",$alg);   $alg = preg_replace("/S2F2/","<226>",$alg);   $alg = preg_replace("/S2F/","<227>",$alg);
    $alg = preg_replace("/S2B'/","<228>",$alg); $alg = preg_replace("/S2B-/","<228>",$alg);   $alg = preg_replace("/S2B2/","<229>",$alg);   $alg = preg_replace("/S2B/","<230>",$alg);
    $alg = preg_replace("/S2U'/","<231>",$alg); $alg = preg_replace("/S2U-/","<231>",$alg);   $alg = preg_replace("/S2U2/","<232>",$alg);   $alg = preg_replace("/S2U/","<233>",$alg);
    $alg = preg_replace("/S2D'/","<234>",$alg); $alg = preg_replace("/S2D-/","<234>",$alg);   $alg = preg_replace("/S2D2/","<235>",$alg);   $alg = preg_replace("/S2D/","<236>",$alg);
    
    $alg = preg_replace("/SR'/","<237>",$alg); $alg = preg_replace("/SR-/","<237>",$alg);   $alg = preg_replace("/SR2/","<238>",$alg);   $alg = preg_replace("/SR/","<239>",$alg);
    $alg = preg_replace("/SL'/","<240>",$alg); $alg = preg_replace("/SL-/","<240>",$alg);   $alg = preg_replace("/SL2/","<241>",$alg);   $alg = preg_replace("/SL/","<242>",$alg);
    $alg = preg_replace("/SF'/","<243>",$alg); $alg = preg_replace("/SF-/","<243>",$alg);   $alg = preg_replace("/SF2/","<244>",$alg);   $alg = preg_replace("/SF/","<245>",$alg);
    $alg = preg_replace("/SB'/","<246>",$alg); $alg = preg_replace("/SB-/","<246>",$alg);   $alg = preg_replace("/SB2/","<247>",$alg);   $alg = preg_replace("/SB/","<248>",$alg);
    $alg = preg_replace("/SU'/","<249>",$alg); $alg = preg_replace("/SU-/","<249>",$alg);   $alg = preg_replace("/SU2/","<250>",$alg);   $alg = preg_replace("/SU/","<251>",$alg);
    $alg = preg_replace("/SD'/","<252>",$alg); $alg = preg_replace("/SD-/","<252>",$alg);   $alg = preg_replace("/SD2/","<253>",$alg);   $alg = preg_replace("/SD/","<254>",$alg);
    
    $alg = preg_replace("/S2-2R'/","<255>",$alg); $alg = preg_replace("/S2-2R-/","<255>",$alg);   $alg = preg_replace("/S2-2R2/","<256>",$alg);   $alg = preg_replace("/S2-2R/","<257>",$alg);
    $alg = preg_replace("/S2-2L'/","<258>",$alg); $alg = preg_replace("/S2-2L-/","<258>",$alg);   $alg = preg_replace("/S2-2L2/","<259>",$alg);   $alg = preg_replace("/S2-2L/","<260>",$alg);
    $alg = preg_replace("/S2-2F'/","<261>",$alg); $alg = preg_replace("/S2-2F-/","<261>",$alg);   $alg = preg_replace("/S2-2F2/","<262>",$alg);   $alg = preg_replace("/S2-2F/","<263>",$alg);
    $alg = preg_replace("/S2-2B'/","<264>",$alg); $alg = preg_replace("/S2-2B-/","<264>",$alg);   $alg = preg_replace("/S2-2B2/","<265>",$alg);   $alg = preg_replace("/S2-2B/","<266>",$alg);
    $alg = preg_replace("/S2-2U'/","<267>",$alg); $alg = preg_replace("/S2-2U-/","<267>",$alg);   $alg = preg_replace("/S2-2U2/","<268>",$alg);   $alg = preg_replace("/S2-2U/","<269>",$alg);
    $alg = preg_replace("/S2-2D'/","<270>",$alg); $alg = preg_replace("/S2-2D-/","<270>",$alg);   $alg = preg_replace("/S2-2D2/","<271>",$alg);   $alg = preg_replace("/S2-2D/","<272>",$alg);
    
    $alg = preg_replace("/S2-3R'/","<273>",$alg); $alg = preg_replace("/S2-3R-/","<273>",$alg);   $alg = preg_replace("/S2-3R2/","<274>",$alg);   $alg = preg_replace("/S2-3R/","<275>",$alg);
    $alg = preg_replace("/S2-3L'/","<276>",$alg); $alg = preg_replace("/S2-3L-/","<276>",$alg);   $alg = preg_replace("/S2-3L2/","<277>",$alg);   $alg = preg_replace("/S2-3L/","<278>",$alg);
    $alg = preg_replace("/S2-3F'/","<279>",$alg); $alg = preg_replace("/S2-3F-/","<279>",$alg);   $alg = preg_replace("/S2-3F2/","<280>",$alg);   $alg = preg_replace("/S2-3F/","<281>",$alg);
    $alg = preg_replace("/S2-3B'/","<282>",$alg); $alg = preg_replace("/S2-3B-/","<282>",$alg);   $alg = preg_replace("/S2-3B2/","<283>",$alg);   $alg = preg_replace("/S2-3B/","<284>",$alg);
    $alg = preg_replace("/S2-3U'/","<285>",$alg); $alg = preg_replace("/S2-3U-/","<285>",$alg);   $alg = preg_replace("/S2-3U2/","<286>",$alg);   $alg = preg_replace("/S2-3U/","<287>",$alg);
    $alg = preg_replace("/S2-3D'/","<288>",$alg); $alg = preg_replace("/S2-3D-/","<288>",$alg);   $alg = preg_replace("/S2-3D2/","<289>",$alg);   $alg = preg_replace("/S2-3D/","<290>",$alg);
    
    $alg = preg_replace("/S2-4R'/","<291>",$alg);  $alg = preg_replace("/S2-4R-/","<291>",$alg);    $alg = preg_replace("/S2-4R2/","<292>",$alg);    $alg = preg_replace("/S2-4R/","<293>",$alg);
    $alg = preg_replace("/S2-4L'/","<294>",$alg);  $alg = preg_replace("/S2-4L-/","<294>",$alg);    $alg = preg_replace("/S2-4L2/","<295>",$alg);    $alg = preg_replace("/S2-4L/","<276>",$alg);
    $alg = preg_replace("/S2-4F'/","<297>",$alg);  $alg = preg_replace("/S2-4F-/","<297>",$alg);    $alg = preg_replace("/S2-4F2/","<298>",$alg);    $alg = preg_replace("/S2-4F/","<299>",$alg);
    $alg = preg_replace("/S2-4B'/","<2100>",$alg); $alg = preg_replace("/S2-4B-/","<2100>",$alg);   $alg = preg_replace("/S2-4B2/","<2101>",$alg);   $alg = preg_replace("/S2-4B/","<2102>",$alg);
    $alg = preg_replace("/S2-4U'/","<2103>",$alg); $alg = preg_replace("/S2-4U-/","<2103>",$alg);   $alg = preg_replace("/S2-4U2/","<2104>",$alg);   $alg = preg_replace("/S2-4U/","<2105>",$alg);
    $alg = preg_replace("/S2-4D'/","<2106>",$alg); $alg = preg_replace("/S2-4D-/","<2106>",$alg);   $alg = preg_replace("/S2-4D2/","<2107>",$alg);   $alg = preg_replace("/S2-4D/","<2108>",$alg);
    
    $alg = preg_replace("/S2-5R'/","<2109>",$alg); $alg = preg_replace("/S2-5R-/","<2109>",$alg);   $alg = preg_replace("/S2-5R2/","<2110>",$alg);   $alg = preg_replace("/S2-5R/","<2111>",$alg);
    $alg = preg_replace("/S2-5L'/","<2112>",$alg); $alg = preg_replace("/S2-5L-/","<2112>",$alg);   $alg = preg_replace("/S2-5L2/","<2113>",$alg);   $alg = preg_replace("/S2-5L/","<2114>",$alg);
    $alg = preg_replace("/S2-5F'/","<2115>",$alg); $alg = preg_replace("/S2-5F-/","<2115>",$alg);   $alg = preg_replace("/S2-5F2/","<2116>",$alg);   $alg = preg_replace("/S2-5F/","<2117>",$alg);
    $alg = preg_replace("/S2-5B'/","<2118>",$alg); $alg = preg_replace("/S2-5B-/","<2118>",$alg);   $alg = preg_replace("/S2-5B2/","<2119>",$alg);   $alg = preg_replace("/S2-5B/","<2120>",$alg);
    $alg = preg_replace("/S2-5U'/","<2121>",$alg); $alg = preg_replace("/S2-5U-/","<2121>",$alg);   $alg = preg_replace("/S2-5U2/","<2122>",$alg);   $alg = preg_replace("/S2-5U/","<2123>",$alg);
    $alg = preg_replace("/S2-5D'/","<2124>",$alg); $alg = preg_replace("/S2-5D-/","<2124>",$alg);   $alg = preg_replace("/S2-5D2/","<2125>",$alg);   $alg = preg_replace("/S2-5D/","<2126>",$alg);
    
    $alg = preg_replace("/S3-3R'/","<2127>",$alg); $alg = preg_replace("/S3-3R-/","<2127>",$alg);   $alg = preg_replace("/S3-3R2/","<2128>",$alg);   $alg = preg_replace("/S3-3R/","<2129>",$alg);
    $alg = preg_replace("/S3-3L'/","<2130>",$alg); $alg = preg_replace("/S3-3L-/","<2130>",$alg);   $alg = preg_replace("/S3-3L2/","<2131>",$alg);   $alg = preg_replace("/S3-3L/","<2132>",$alg);
    $alg = preg_replace("/S3-3F'/","<2133>",$alg); $alg = preg_replace("/S3-3F-/","<2133>",$alg);   $alg = preg_replace("/S3-3F2/","<2134>",$alg);   $alg = preg_replace("/S3-3F/","<2135>",$alg);
    $alg = preg_replace("/S3-3B'/","<2136>",$alg); $alg = preg_replace("/S3-3B-/","<2136>",$alg);   $alg = preg_replace("/S3-3B2/","<2137>",$alg);   $alg = preg_replace("/S3-3B/","<2138>",$alg);
    $alg = preg_replace("/S3-3U'/","<2139>",$alg); $alg = preg_replace("/S3-3U-/","<2139>",$alg);   $alg = preg_replace("/S3-3U2/","<2140>",$alg);   $alg = preg_replace("/S3-3U/","<2141>",$alg);
    $alg = preg_replace("/S3-3D'/","<2142>",$alg); $alg = preg_replace("/S3-3D-/","<2142>",$alg);   $alg = preg_replace("/S3-3D2/","<2143>",$alg);   $alg = preg_replace("/S3-3D/","<2144>",$alg);
    
    /* S3-4R */
    
    /* --- 7xC: SSE -> CODE: [3] Tier twists --- */
    $alg = preg_replace("/T6R'/","<301>",$alg); $alg = preg_replace("/T6R-/","<301>",$alg);   $alg = preg_replace("/T6R2/","<302>",$alg);   $alg = preg_replace("/T6R/","<303>",$alg);
    $alg = preg_replace("/T6L'/","<304>",$alg); $alg = preg_replace("/T6L-/","<304>",$alg);   $alg = preg_replace("/T6L2/","<305>",$alg);   $alg = preg_replace("/T6L/","<306>",$alg);
    $alg = preg_replace("/T6F'/","<307>",$alg); $alg = preg_replace("/T6F-/","<307>",$alg);   $alg = preg_replace("/T6F2/","<308>",$alg);   $alg = preg_replace("/T6F/","<309>",$alg);
    $alg = preg_replace("/T6B'/","<310>",$alg); $alg = preg_replace("/T6B-/","<310>",$alg);   $alg = preg_replace("/T6B2/","<311>",$alg);   $alg = preg_replace("/T6B/","<312>",$alg);
    $alg = preg_replace("/T6U'/","<313>",$alg); $alg = preg_replace("/T6U-/","<313>",$alg);   $alg = preg_replace("/T6U2/","<314>",$alg);   $alg = preg_replace("/T6U/","<315>",$alg);
    $alg = preg_replace("/T6D'/","<316>",$alg); $alg = preg_replace("/T6D-/","<316>",$alg);   $alg = preg_replace("/T6D2/","<317>",$alg);   $alg = preg_replace("/T6D/","<318>",$alg);
    
    $alg = preg_replace("/T5R'/","<319>",$alg); $alg = preg_replace("/T5R-/","<319>",$alg);   $alg = preg_replace("/T5R2/","<320>",$alg);   $alg = preg_replace("/T5R/","<321>",$alg);
    $alg = preg_replace("/T5L'/","<322>",$alg); $alg = preg_replace("/T5L-/","<322>",$alg);   $alg = preg_replace("/T5L2/","<323>",$alg);   $alg = preg_replace("/T5L/","<324>",$alg);
    $alg = preg_replace("/T5F'/","<325>",$alg); $alg = preg_replace("/T5F-/","<325>",$alg);   $alg = preg_replace("/T5F2/","<326>",$alg);   $alg = preg_replace("/T5F/","<327>",$alg);
    $alg = preg_replace("/T5B'/","<328>",$alg); $alg = preg_replace("/T5B-/","<328>",$alg);   $alg = preg_replace("/T5B2/","<329>",$alg);   $alg = preg_replace("/T5B/","<330>",$alg);
    $alg = preg_replace("/T5U'/","<331>",$alg); $alg = preg_replace("/T5U-/","<331>",$alg);   $alg = preg_replace("/T5U2/","<332>",$alg);   $alg = preg_replace("/T5U/","<333>",$alg);
    $alg = preg_replace("/T5D'/","<334>",$alg); $alg = preg_replace("/T5D-/","<334>",$alg);   $alg = preg_replace("/T5D2/","<335>",$alg);   $alg = preg_replace("/T5D/","<336>",$alg);
    
    $alg = preg_replace("/T4R'/","<337>",$alg); $alg = preg_replace("/T4R-/","<337>",$alg);   $alg = preg_replace("/T4R2/","<338>",$alg);   $alg = preg_replace("/T4R/","<339>",$alg);
    $alg = preg_replace("/T4L'/","<340>",$alg); $alg = preg_replace("/T4L-/","<340>",$alg);   $alg = preg_replace("/T4L2/","<341>",$alg);   $alg = preg_replace("/T4L/","<342>",$alg);
    $alg = preg_replace("/T4F'/","<343>",$alg); $alg = preg_replace("/T4F-/","<343>",$alg);   $alg = preg_replace("/T4F2/","<344>",$alg);   $alg = preg_replace("/T4F/","<345>",$alg);
    $alg = preg_replace("/T4B'/","<346>",$alg); $alg = preg_replace("/T4B-/","<346>",$alg);   $alg = preg_replace("/T4B2/","<347>",$alg);   $alg = preg_replace("/T4B/","<348>",$alg);
    $alg = preg_replace("/T4U'/","<349>",$alg); $alg = preg_replace("/T4U-/","<349>",$alg);   $alg = preg_replace("/T4U2/","<350>",$alg);   $alg = preg_replace("/T4U/","<351>",$alg);
    $alg = preg_replace("/T4D'/","<352>",$alg); $alg = preg_replace("/T4D-/","<352>",$alg);   $alg = preg_replace("/T4D2/","<353>",$alg);   $alg = preg_replace("/T4D/","<354>",$alg);
    
    $alg = preg_replace("/T3R'/","<355>",$alg); $alg = preg_replace("/T3R-/","<355>",$alg);   $alg = preg_replace("/T3R2/","<356>",$alg);   $alg = preg_replace("/T3R/","<357>",$alg);
    $alg = preg_replace("/T3L'/","<358>",$alg); $alg = preg_replace("/T3L-/","<358>",$alg);   $alg = preg_replace("/T3L2/","<359>",$alg);   $alg = preg_replace("/T3L/","<360>",$alg);
    $alg = preg_replace("/T3F'/","<361>",$alg); $alg = preg_replace("/T3F-/","<361>",$alg);   $alg = preg_replace("/T3F2/","<362>",$alg);   $alg = preg_replace("/T3F/","<363>",$alg);
    $alg = preg_replace("/T3B'/","<364>",$alg); $alg = preg_replace("/T3B-/","<364>",$alg);   $alg = preg_replace("/T3B2/","<365>",$alg);   $alg = preg_replace("/T3B/","<366>",$alg);
    $alg = preg_replace("/T3U'/","<367>",$alg); $alg = preg_replace("/T3U-/","<367>",$alg);   $alg = preg_replace("/T3U2/","<368>",$alg);   $alg = preg_replace("/T3U/","<369>",$alg);
    $alg = preg_replace("/T3D'/","<370>",$alg); $alg = preg_replace("/T3D-/","<370>",$alg);   $alg = preg_replace("/T3D2/","<371>",$alg);   $alg = preg_replace("/T3D/","<372>",$alg);
    
    $alg = preg_replace("/TR'/","<373>",$alg); $alg = preg_replace("/TR-/","<373>",$alg);   $alg = preg_replace("/TR2/","<374>",$alg);   $alg = preg_replace("/TR/","<375>",$alg);
    $alg = preg_replace("/TL'/","<376>",$alg); $alg = preg_replace("/TL-/","<376>",$alg);   $alg = preg_replace("/TL2/","<377>",$alg);   $alg = preg_replace("/TL/","<378>",$alg);
    $alg = preg_replace("/TF'/","<379>",$alg); $alg = preg_replace("/TF-/","<379>",$alg);   $alg = preg_replace("/TF2/","<380>",$alg);   $alg = preg_replace("/TF/","<381>",$alg);
    $alg = preg_replace("/TB'/","<382>",$alg); $alg = preg_replace("/TB-/","<382>",$alg);   $alg = preg_replace("/TB2/","<383>",$alg);   $alg = preg_replace("/TB/","<384>",$alg);
    $alg = preg_replace("/TU'/","<385>",$alg); $alg = preg_replace("/TU-/","<385>",$alg);   $alg = preg_replace("/TU2/","<386>",$alg);   $alg = preg_replace("/TU/","<387>",$alg);
    $alg = preg_replace("/TD'/","<388>",$alg); $alg = preg_replace("/TD-/","<388>",$alg);   $alg = preg_replace("/TD2/","<389>",$alg);   $alg = preg_replace("/TD/","<390>",$alg);
    
    /* --- 7xC: SSE -> CODE: [4] Void twists [1] Numbered layer twists--- */
    $alg = preg_replace("/V4R'/","<401>",$alg); $alg = preg_replace("/V4R-/","<401>",$alg);   $alg = preg_replace("/V4R2/","<402>",$alg);   $alg = preg_replace("/V4R/","<403>",$alg);
    $alg = preg_replace("/V4L'/","<404>",$alg); $alg = preg_replace("/V4L-/","<404>",$alg);   $alg = preg_replace("/V4L2/","<405>",$alg);   $alg = preg_replace("/V4L/","<406>",$alg);
    $alg = preg_replace("/V4F'/","<407>",$alg); $alg = preg_replace("/V4F-/","<407>",$alg);   $alg = preg_replace("/V4F2/","<408>",$alg);   $alg = preg_replace("/V4F/","<409>",$alg);
    $alg = preg_replace("/V4B'/","<410>",$alg); $alg = preg_replace("/V4B-/","<410>",$alg);   $alg = preg_replace("/V4B2/","<411>",$alg);   $alg = preg_replace("/V4B/","<412>",$alg);
    $alg = preg_replace("/V4U'/","<413>",$alg); $alg = preg_replace("/V4U-/","<413>",$alg);   $alg = preg_replace("/V4U2/","<414>",$alg);   $alg = preg_replace("/V4U/","<415>",$alg);
    $alg = preg_replace("/V4D'/","<416>",$alg); $alg = preg_replace("/V4D-/","<416>",$alg);   $alg = preg_replace("/V4D2/","<417>",$alg);   $alg = preg_replace("/V4D/","<418>",$alg);
    
    $alg = preg_replace("/N2-5R'/","<401>",$alg); $alg = preg_replace("/N2-5R-/","<401>",$alg);   $alg = preg_replace("/N2-5R2/","<402>",$alg);   $alg = preg_replace("/N2-5R/","<403>",$alg);
    $alg = preg_replace("/N2-5L'/","<404>",$alg); $alg = preg_replace("/N2-5L-/","<404>",$alg);   $alg = preg_replace("/N2-5L2/","<405>",$alg);   $alg = preg_replace("/N2-5L/","<406>",$alg);
    $alg = preg_replace("/N2-5F'/","<407>",$alg); $alg = preg_replace("/N2-5F-/","<407>",$alg);   $alg = preg_replace("/N2-5F2/","<408>",$alg);   $alg = preg_replace("/N2-5F/","<409>",$alg);
    $alg = preg_replace("/N2-5B'/","<410>",$alg); $alg = preg_replace("/N2-5B-/","<410>",$alg);   $alg = preg_replace("/N2-5B2/","<411>",$alg);   $alg = preg_replace("/N2-5B/","<412>",$alg);
    $alg = preg_replace("/N2-5U'/","<413>",$alg); $alg = preg_replace("/N2-5U-/","<413>",$alg);   $alg = preg_replace("/N2-5U2/","<414>",$alg);   $alg = preg_replace("/N2-5U/","<415>",$alg);
    $alg = preg_replace("/N2-5D'/","<416>",$alg); $alg = preg_replace("/N2-5D-/","<416>",$alg);   $alg = preg_replace("/N2-5D2/","<417>",$alg);   $alg = preg_replace("/N2-5D/","<418>",$alg);
    
    $alg = preg_replace("/M4R'/","<401>",$alg); $alg = preg_replace("/M4R-/","<401>",$alg);   $alg = preg_replace("/M4R2/","<402>",$alg);   $alg = preg_replace("/M4R/","<403>",$alg);
    $alg = preg_replace("/M4L'/","<404>",$alg); $alg = preg_replace("/M4L-/","<404>",$alg);   $alg = preg_replace("/M4L2/","<405>",$alg);   $alg = preg_replace("/M4L/","<406>",$alg);
    $alg = preg_replace("/M4F'/","<407>",$alg); $alg = preg_replace("/M4F-/","<407>",$alg);   $alg = preg_replace("/M4F2/","<408>",$alg);   $alg = preg_replace("/M4F/","<409>",$alg);
    $alg = preg_replace("/M4B'/","<410>",$alg); $alg = preg_replace("/M4B-/","<410>",$alg);   $alg = preg_replace("/M4B2/","<411>",$alg);   $alg = preg_replace("/M4B/","<412>",$alg);
    $alg = preg_replace("/M4U'/","<413>",$alg); $alg = preg_replace("/M4U-/","<413>",$alg);   $alg = preg_replace("/M4U2/","<414>",$alg);   $alg = preg_replace("/M4U/","<415>",$alg);
    $alg = preg_replace("/M4D'/","<416>",$alg); $alg = preg_replace("/M4D-/","<416>",$alg);   $alg = preg_replace("/M4D2/","<417>",$alg);   $alg = preg_replace("/M4D/","<418>",$alg);
    
    $alg = preg_replace("/V3R'/","<419>",$alg); $alg = preg_replace("/V3R-/","<419>",$alg);   $alg = preg_replace("/V3R2/","<420>",$alg);   $alg = preg_replace("/V3R/","<421>",$alg);
    $alg = preg_replace("/V3L'/","<422>",$alg); $alg = preg_replace("/V3L-/","<422>",$alg);   $alg = preg_replace("/V3L2/","<423>",$alg);   $alg = preg_replace("/V3L/","<424>",$alg);
    $alg = preg_replace("/V3F'/","<425>",$alg); $alg = preg_replace("/V3F-/","<425>",$alg);   $alg = preg_replace("/V3F2/","<426>",$alg);   $alg = preg_replace("/V3F/","<427>",$alg);
    $alg = preg_replace("/V3B'/","<428>",$alg); $alg = preg_replace("/V3B-/","<428>",$alg);   $alg = preg_replace("/V3B2/","<429>",$alg);   $alg = preg_replace("/V3B/","<430>",$alg);
    $alg = preg_replace("/V3U'/","<431>",$alg); $alg = preg_replace("/V3U-/","<431>",$alg);   $alg = preg_replace("/V3U2/","<432>",$alg);   $alg = preg_replace("/V3U/","<433>",$alg);
    $alg = preg_replace("/V3D'/","<434>",$alg); $alg = preg_replace("/V3D-/","<434>",$alg);   $alg = preg_replace("/V3D2/","<435>",$alg);   $alg = preg_replace("/V3D/","<436>",$alg);
    
    $alg = preg_replace("/N2-4R'/","<419>",$alg); $alg = preg_replace("/N2-4R-/","<419>",$alg);   $alg = preg_replace("/N2-4R2/","<420>",$alg);   $alg = preg_replace("/N2-4R/","<421>",$alg);
    $alg = preg_replace("/N2-4L'/","<422>",$alg); $alg = preg_replace("/N2-4L-/","<422>",$alg);   $alg = preg_replace("/N2-4L2/","<423>",$alg);   $alg = preg_replace("/N2-4L/","<424>",$alg);
    $alg = preg_replace("/N2-4F'/","<425>",$alg); $alg = preg_replace("/N2-4F-/","<425>",$alg);   $alg = preg_replace("/N2-4F2/","<426>",$alg);   $alg = preg_replace("/N2-4F/","<427>",$alg);
    $alg = preg_replace("/N2-4B'/","<428>",$alg); $alg = preg_replace("/N2-4B-/","<428>",$alg);   $alg = preg_replace("/N2-4B2/","<429>",$alg);   $alg = preg_replace("/N2-4B/","<430>",$alg);
    $alg = preg_replace("/N2-4U'/","<431>",$alg); $alg = preg_replace("/N2-4U-/","<431>",$alg);   $alg = preg_replace("/N2-4U2/","<432>",$alg);   $alg = preg_replace("/N2-4U/","<433>",$alg);
    $alg = preg_replace("/N2-4D'/","<434>",$alg); $alg = preg_replace("/N2-4D-/","<434>",$alg);   $alg = preg_replace("/N2-4D2/","<435>",$alg);   $alg = preg_replace("/N2-4D/","<436>",$alg);
    
    $alg = preg_replace("/VR'/","<437>",$alg); $alg = preg_replace("/VR-/","<437>",$alg);   $alg = preg_replace("/VR2/","<438>",$alg);   $alg = preg_replace("/VR/","<439>",$alg);
    $alg = preg_replace("/VL'/","<440>",$alg); $alg = preg_replace("/VL-/","<440>",$alg);   $alg = preg_replace("/VL2/","<441>",$alg);   $alg = preg_replace("/VL/","<442>",$alg);
    $alg = preg_replace("/VF'/","<443>",$alg); $alg = preg_replace("/VF-/","<443>",$alg);   $alg = preg_replace("/VF2/","<444>",$alg);   $alg = preg_replace("/VF/","<445>",$alg);
    $alg = preg_replace("/VB'/","<446>",$alg); $alg = preg_replace("/VB-/","<446>",$alg);   $alg = preg_replace("/VB2/","<447>",$alg);   $alg = preg_replace("/VB/","<448>",$alg);
    $alg = preg_replace("/VU'/","<449>",$alg); $alg = preg_replace("/VU-/","<449>",$alg);   $alg = preg_replace("/VU2/","<450>",$alg);   $alg = preg_replace("/VU/","<451>",$alg);
    $alg = preg_replace("/VD'/","<452>",$alg); $alg = preg_replace("/VD-/","<452>",$alg);   $alg = preg_replace("/VD2/","<453>",$alg);   $alg = preg_replace("/VD/","<454>",$alg);
    
    /* --- 7xC: SSE -> CODE: [5] Mid-layer twists [1] Numbered layer twists --- */
    $alg = preg_replace("/M3R'/","<501>",$alg); $alg = preg_replace("/M3R-/","<501>",$alg);   $alg = preg_replace("/M3R2/","<502>",$alg);   $alg = preg_replace("/M3R/","<503>",$alg);
    $alg = preg_replace("/M3L'/","<504>",$alg); $alg = preg_replace("/M3L-/","<504>",$alg);   $alg = preg_replace("/M3L2/","<505>",$alg);   $alg = preg_replace("/M3L/","<506>",$alg);
    $alg = preg_replace("/M3F'/","<507>",$alg); $alg = preg_replace("/M3F-/","<507>",$alg);   $alg = preg_replace("/M3F2/","<508>",$alg);   $alg = preg_replace("/M3F/","<509>",$alg);
    $alg = preg_replace("/M3B'/","<510>",$alg); $alg = preg_replace("/M3B-/","<510>",$alg);   $alg = preg_replace("/M3B2/","<511>",$alg);   $alg = preg_replace("/M3B/","<512>",$alg);
    $alg = preg_replace("/M3U'/","<513>",$alg); $alg = preg_replace("/M3U-/","<513>",$alg);   $alg = preg_replace("/M3U2/","<514>",$alg);   $alg = preg_replace("/M3U/","<515>",$alg);
    $alg = preg_replace("/M3D'/","<516>",$alg); $alg = preg_replace("/M3D-/","<516>",$alg);   $alg = preg_replace("/M3D2/","<517>",$alg);   $alg = preg_replace("/M3D/","<518>",$alg);
    
    $alg = preg_replace("/N3-5R'/","<501>",$alg); $alg = preg_replace("/N3-5R-/","<501>",$alg);   $alg = preg_replace("/N3-5R2/","<502>",$alg);   $alg = preg_replace("/N3-5R/","<503>",$alg);
    $alg = preg_replace("/N3-5L'/","<504>",$alg); $alg = preg_replace("/N3-5L-/","<504>",$alg);   $alg = preg_replace("/N3-5L2/","<505>",$alg);   $alg = preg_replace("/N3-5L/","<506>",$alg);
    $alg = preg_replace("/N3-5F'/","<507>",$alg); $alg = preg_replace("/N3-5F-/","<507>",$alg);   $alg = preg_replace("/N3-5F2/","<508>",$alg);   $alg = preg_replace("/N3-5F/","<509>",$alg);
    $alg = preg_replace("/N3-5B'/","<510>",$alg); $alg = preg_replace("/N3-5B-/","<510>",$alg);   $alg = preg_replace("/N3-5B2/","<511>",$alg);   $alg = preg_replace("/N3-5B/","<512>",$alg);
    $alg = preg_replace("/N3-5U'/","<513>",$alg); $alg = preg_replace("/N3-5U-/","<513>",$alg);   $alg = preg_replace("/N3-5U2/","<514>",$alg);   $alg = preg_replace("/N3-5U/","<515>",$alg);
    $alg = preg_replace("/N3-5D'/","<516>",$alg); $alg = preg_replace("/N3-5D-/","<516>",$alg);   $alg = preg_replace("/N3-5D2/","<517>",$alg);   $alg = preg_replace("/N3-5D/","<518>",$alg);
    
    $alg = preg_replace("/M2R'/","<519>",$alg); $alg = preg_replace("/M2R-/","<519>",$alg);   $alg = preg_replace("/M2R2/","<520>",$alg);   $alg = preg_replace("/M2R/","<521>",$alg);
    $alg = preg_replace("/M2L'/","<522>",$alg); $alg = preg_replace("/M2L-/","<522>",$alg);   $alg = preg_replace("/M2L2/","<523>",$alg);   $alg = preg_replace("/M2L/","<524>",$alg);
    $alg = preg_replace("/M2F'/","<525>",$alg); $alg = preg_replace("/M2F-/","<525>",$alg);   $alg = preg_replace("/M2F2/","<526>",$alg);   $alg = preg_replace("/M2F/","<527>",$alg);
    $alg = preg_replace("/M2B'/","<528>",$alg); $alg = preg_replace("/M2B-/","<528>",$alg);   $alg = preg_replace("/M2B2/","<529>",$alg);   $alg = preg_replace("/M2B/","<530>",$alg);
    $alg = preg_replace("/M2U'/","<531>",$alg); $alg = preg_replace("/M2U-/","<531>",$alg);   $alg = preg_replace("/M2U2/","<532>",$alg);   $alg = preg_replace("/M2U/","<533>",$alg);
    $alg = preg_replace("/M2D'/","<534>",$alg); $alg = preg_replace("/M2D-/","<534>",$alg);   $alg = preg_replace("/M2D2/","<535>",$alg);   $alg = preg_replace("/M2D/","<536>",$alg);
    
    $alg = preg_replace("/N3-4R'/","<519>",$alg); $alg = preg_replace("/N3-4R-/","<519>",$alg);   $alg = preg_replace("/N3-4R2/","<520>",$alg);   $alg = preg_replace("/N3-4R/","<521>",$alg);
    $alg = preg_replace("/N3-4L'/","<522>",$alg); $alg = preg_replace("/N3-4L-/","<522>",$alg);   $alg = preg_replace("/N3-4L2/","<523>",$alg);   $alg = preg_replace("/N3-4L/","<524>",$alg);
    $alg = preg_replace("/N3-4F'/","<525>",$alg); $alg = preg_replace("/N3-4F-/","<525>",$alg);   $alg = preg_replace("/N3-4F2/","<526>",$alg);   $alg = preg_replace("/N3-4F/","<527>",$alg);
    $alg = preg_replace("/N3-4B'/","<528>",$alg); $alg = preg_replace("/N3-4B-/","<528>",$alg);   $alg = preg_replace("/N3-4B2/","<529>",$alg);   $alg = preg_replace("/N3-4B/","<530>",$alg);
    $alg = preg_replace("/N3-4U'/","<531>",$alg); $alg = preg_replace("/N3-4U-/","<531>",$alg);   $alg = preg_replace("/N3-4U2/","<532>",$alg);   $alg = preg_replace("/N3-4U/","<533>",$alg);
    $alg = preg_replace("/N3-4D'/","<534>",$alg); $alg = preg_replace("/N3-4D-/","<534>",$alg);   $alg = preg_replace("/N3-4D2/","<535>",$alg);   $alg = preg_replace("/N3-4D/","<536>",$alg);
    
    /* --- 7xC: SSE -> CODE: [6] Wide-layer twists [5] (Mid-layer twists) [4] (Void twists) [1] Numbered layer twists --- */
    $alg = preg_replace("/WR'/","<601>",$alg); $alg = preg_replace("/WR-/","<601>",$alg);   $alg = preg_replace("/WR2/","<602>",$alg);   $alg = preg_replace("/WR/","<603>",$alg);
    $alg = preg_replace("/WL'/","<604>",$alg); $alg = preg_replace("/WL-/","<604>",$alg);   $alg = preg_replace("/WL2/","<605>",$alg);   $alg = preg_replace("/WL/","<606>",$alg);
    $alg = preg_replace("/WF'/","<607>",$alg); $alg = preg_replace("/WF-/","<607>",$alg);   $alg = preg_replace("/WF2/","<608>",$alg);   $alg = preg_replace("/WF/","<609>",$alg);
    $alg = preg_replace("/WB'/","<610>",$alg); $alg = preg_replace("/WB-/","<610>",$alg);   $alg = preg_replace("/WB2/","<611>",$alg);   $alg = preg_replace("/WB/","<612>",$alg);
    $alg = preg_replace("/WU'/","<613>",$alg); $alg = preg_replace("/WU-/","<613>",$alg);   $alg = preg_replace("/WU2/","<614>",$alg);   $alg = preg_replace("/WU/","<615>",$alg);
    $alg = preg_replace("/WD'/","<616>",$alg); $alg = preg_replace("/WD-/","<616>",$alg);   $alg = preg_replace("/WD2/","<617>",$alg);   $alg = preg_replace("/WD/","<618>",$alg);
    
    $alg = preg_replace("/M5R'/","<601>",$alg); $alg = preg_replace("/M5R-/","<601>",$alg);   $alg = preg_replace("/M5R2/","<602>",$alg);   $alg = preg_replace("/M5R/","<603>",$alg);
    $alg = preg_replace("/M5L'/","<604>",$alg); $alg = preg_replace("/M5L-/","<604>",$alg);   $alg = preg_replace("/M5L2/","<605>",$alg);   $alg = preg_replace("/M5L/","<606>",$alg);
    $alg = preg_replace("/M5F'/","<607>",$alg); $alg = preg_replace("/M5F-/","<607>",$alg);   $alg = preg_replace("/M5F2/","<608>",$alg);   $alg = preg_replace("/M5F/","<609>",$alg);
    $alg = preg_replace("/M5B'/","<610>",$alg); $alg = preg_replace("/M5B-/","<610>",$alg);   $alg = preg_replace("/M5B2/","<611>",$alg);   $alg = preg_replace("/M5B/","<612>",$alg);
    $alg = preg_replace("/M5U'/","<613>",$alg); $alg = preg_replace("/M5U-/","<613>",$alg);   $alg = preg_replace("/M5U2/","<614>",$alg);   $alg = preg_replace("/M5U/","<615>",$alg);
    $alg = preg_replace("/M5D'/","<616>",$alg); $alg = preg_replace("/M5D-/","<616>",$alg);   $alg = preg_replace("/M5D2/","<617>",$alg);   $alg = preg_replace("/M5D/","<618>",$alg);
    
    $alg = preg_replace("/V5R'/","<601>",$alg); $alg = preg_replace("/V5R-/","<601>",$alg);   $alg = preg_replace("/V5R2/","<602>",$alg);   $alg = preg_replace("/V5R/","<603>",$alg);
    $alg = preg_replace("/V5L'/","<604>",$alg); $alg = preg_replace("/V5L-/","<604>",$alg);   $alg = preg_replace("/V5L2/","<605>",$alg);   $alg = preg_replace("/V5L/","<606>",$alg);
    $alg = preg_replace("/V5F'/","<607>",$alg); $alg = preg_replace("/V5F-/","<607>",$alg);   $alg = preg_replace("/V5F2/","<608>",$alg);   $alg = preg_replace("/V5F/","<609>",$alg);
    $alg = preg_replace("/V5B'/","<610>",$alg); $alg = preg_replace("/V5B-/","<610>",$alg);   $alg = preg_replace("/V5B2/","<611>",$alg);   $alg = preg_replace("/V5B/","<612>",$alg);
    $alg = preg_replace("/V5U'/","<613>",$alg); $alg = preg_replace("/V5U-/","<613>",$alg);   $alg = preg_replace("/V5U2/","<614>",$alg);   $alg = preg_replace("/V5U/","<615>",$alg);
    $alg = preg_replace("/V5D'/","<616>",$alg); $alg = preg_replace("/V5D-/","<616>",$alg);   $alg = preg_replace("/V5D2/","<617>",$alg);   $alg = preg_replace("/V5D/","<618>",$alg);
    
    $alg = preg_replace("/N2-6R'/","<601>",$alg); $alg = preg_replace("/N2-6R-/","<601>",$alg);   $alg = preg_replace("/N2-6R2/","<602>",$alg);   $alg = preg_replace("/N2-6R/","<603>",$alg);
    $alg = preg_replace("/N2-6L'/","<604>",$alg); $alg = preg_replace("/N2-6L-/","<604>",$alg);   $alg = preg_replace("/N2-6L2/","<605>",$alg);   $alg = preg_replace("/N2-6L/","<606>",$alg);
    $alg = preg_replace("/N2-6F'/","<607>",$alg); $alg = preg_replace("/N2-6F-/","<607>",$alg);   $alg = preg_replace("/N2-6F2/","<608>",$alg);   $alg = preg_replace("/N2-6F/","<609>",$alg);
    $alg = preg_replace("/N2-6B'/","<610>",$alg); $alg = preg_replace("/N2-6B-/","<610>",$alg);   $alg = preg_replace("/N2-6B2/","<611>",$alg);   $alg = preg_replace("/N2-6B/","<612>",$alg);
    $alg = preg_replace("/N2-6U'/","<613>",$alg); $alg = preg_replace("/N2-6U-/","<613>",$alg);   $alg = preg_replace("/N2-6U2/","<614>",$alg);   $alg = preg_replace("/N2-6U/","<615>",$alg);
    $alg = preg_replace("/N2-6D'/","<616>",$alg); $alg = preg_replace("/N2-6D-/","<616>",$alg);   $alg = preg_replace("/N2-6D2/","<617>",$alg);   $alg = preg_replace("/N2-6D/","<618>",$alg);
    
    /* --- 7xC: SSE -> CODE: [7] Cube rotations --- */
    $alg = preg_replace("/CR'/","<701>",$alg); $alg = preg_replace("/CR-/","<701>",$alg);   $alg = preg_replace("/CR2/","<702>",$alg);   $alg = preg_replace("/CR/","<703>",$alg);
    $alg = preg_replace("/CL'/","<704>",$alg); $alg = preg_replace("/CL-/","<704>",$alg);   $alg = preg_replace("/CL2/","<705>",$alg);   $alg = preg_replace("/CL/","<706>",$alg);
    $alg = preg_replace("/CF'/","<707>",$alg); $alg = preg_replace("/CF-/","<707>",$alg);   $alg = preg_replace("/CF2/","<708>",$alg);   $alg = preg_replace("/CF/","<709>",$alg);
    $alg = preg_replace("/CB'/","<710>",$alg); $alg = preg_replace("/CB-/","<710>",$alg);   $alg = preg_replace("/CB2/","<711>",$alg);   $alg = preg_replace("/CB/","<712>",$alg);
    $alg = preg_replace("/CU'/","<713>",$alg); $alg = preg_replace("/CU-/","<713>",$alg);   $alg = preg_replace("/CU2/","<714>",$alg);   $alg = preg_replace("/CU/","<715>",$alg);
    $alg = preg_replace("/CD'/","<716>",$alg); $alg = preg_replace("/CD-/","<716>",$alg);   $alg = preg_replace("/CD2/","<717>",$alg);   $alg = preg_replace("/CD/","<718>",$alg);
    
    /* --- 7xC: SSE -> CODE: [9] Face twists --- */
    $alg = preg_replace("/R'/","<901>",$alg); $alg = preg_replace("/R-/","<901>",$alg);   $alg = preg_replace("/R2/","<902>",$alg);   $alg = preg_replace("/R/","<903>",$alg);
    $alg = preg_replace("/L'/","<904>",$alg); $alg = preg_replace("/L-/","<904>",$alg);   $alg = preg_replace("/L2/","<905>",$alg);   $alg = preg_replace("/L/","<906>",$alg);
    $alg = preg_replace("/F'/","<907>",$alg); $alg = preg_replace("/F-/","<907>",$alg);   $alg = preg_replace("/F2/","<908>",$alg);   $alg = preg_replace("/F/","<909>",$alg);
    $alg = preg_replace("/B'/","<910>",$alg); $alg = preg_replace("/B-/","<910>",$alg);   $alg = preg_replace("/B2/","<911>",$alg);   $alg = preg_replace("/B/","<912>",$alg);
    $alg = preg_replace("/U'/","<913>",$alg); $alg = preg_replace("/U-/","<913>",$alg);   $alg = preg_replace("/U2/","<914>",$alg);   $alg = preg_replace("/U/","<915>",$alg);
    $alg = preg_replace("/D'/","<916>",$alg); $alg = preg_replace("/D-/","<916>",$alg);   $alg = preg_replace("/D2/","<917>",$alg);   $alg = preg_replace("/D/","<918>",$alg);
    
    /* ··································································································· */
    /* --- 7xC: CODE -> TWIZZLE: [1] Numbered-layer twists --- */
    $alg = preg_replace("/<101>/","2R'",$alg);   $alg = preg_replace("/<102>/","2R2",$alg);   $alg = preg_replace("/<103>/","2R",$alg);
    $alg = preg_replace("/<104>/","2L'",$alg);   $alg = preg_replace("/<105>/","2L2",$alg);   $alg = preg_replace("/<106>/","2L",$alg);
    $alg = preg_replace("/<107>/","2F'",$alg);   $alg = preg_replace("/<108>/","2F2",$alg);   $alg = preg_replace("/<109>/","2F",$alg);
    $alg = preg_replace("/<110>/","2B'",$alg);   $alg = preg_replace("/<111>/","2B2",$alg);   $alg = preg_replace("/<112>/","2B",$alg);
    $alg = preg_replace("/<113>/","2U'",$alg);   $alg = preg_replace("/<114>/","2U2",$alg);   $alg = preg_replace("/<115>/","2U",$alg);
    $alg = preg_replace("/<116>/","2D'",$alg);   $alg = preg_replace("/<117>/","2D2",$alg);   $alg = preg_replace("/<118>/","2D",$alg);
    
    $alg = preg_replace("/<119>/","3R'",$alg);   $alg = preg_replace("/<120>/","3R2",$alg);   $alg = preg_replace("/<121>/","3R",$alg);
    $alg = preg_replace("/<122>/","3L'",$alg);   $alg = preg_replace("/<123>/","3L2",$alg);   $alg = preg_replace("/<124>/","3L",$alg);
    $alg = preg_replace("/<125>/","3F'",$alg);   $alg = preg_replace("/<126>/","3F2",$alg);   $alg = preg_replace("/<127>/","3F",$alg);
    $alg = preg_replace("/<128>/","3B'",$alg);   $alg = preg_replace("/<129>/","3B2",$alg);   $alg = preg_replace("/<130>/","3B",$alg);
    $alg = preg_replace("/<131>/","3U'",$alg);   $alg = preg_replace("/<132>/","3U2",$alg);   $alg = preg_replace("/<133>/","3U",$alg);
    $alg = preg_replace("/<134>/","3D'",$alg);   $alg = preg_replace("/<135>/","3D2",$alg);   $alg = preg_replace("/<136>/","3D",$alg);
    
    $alg = preg_replace("/<137>/","4R'",$alg);   $alg = preg_replace("/<138>/","4R2",$alg);   $alg = preg_replace("/<139>/","4R",$alg);
    $alg = preg_replace("/<140>/","4L'",$alg);   $alg = preg_replace("/<141>/","4L2",$alg);   $alg = preg_replace("/<142>/","4L",$alg);
    $alg = preg_replace("/<143>/","4F'",$alg);   $alg = preg_replace("/<144>/","4F2",$alg);   $alg = preg_replace("/<145>/","4F",$alg);
    $alg = preg_replace("/<146>/","4B'",$alg);   $alg = preg_replace("/<147>/","4B2",$alg);   $alg = preg_replace("/<148>/","4B",$alg);
    $alg = preg_replace("/<149>/","4U'",$alg);   $alg = preg_replace("/<150>/","4U2",$alg);   $alg = preg_replace("/<151>/","4U",$alg);
    $alg = preg_replace("/<152>/","4D'",$alg);   $alg = preg_replace("/<153>/","4D2",$alg);   $alg = preg_replace("/<154>/","4D",$alg);
    
    /* --- 7xC: CODE -> TWIZZLE: [2] Slice twists --- */
    $alg = preg_replace("/<201>/","3r' 3l",$alg);   $alg = preg_replace("/<202>/","3r2 3l2",$alg);   $alg = preg_replace("/<203>/","3r 3l'",$alg);
    $alg = preg_replace("/<204>/","3r 3l'",$alg);   $alg = preg_replace("/<205>/","3r2 3l2",$alg);   $alg = preg_replace("/<206>/","3r' 3l",$alg);
    $alg = preg_replace("/<207>/","3f' 3b",$alg);   $alg = preg_replace("/<208>/","3f2 3b2",$alg);   $alg = preg_replace("/<209>/","3f 3b'",$alg);
    $alg = preg_replace("/<210>/","3f 3b'",$alg);   $alg = preg_replace("/<211>/","3f2 3b2",$alg);   $alg = preg_replace("/<212>/","3f' 3b",$alg);
    $alg = preg_replace("/<213>/","3u' 3d",$alg);   $alg = preg_replace("/<214>/","3u2 3d2",$alg);   $alg = preg_replace("/<215>/","3u 3d'",$alg);
    $alg = preg_replace("/<216>/","3u 3d'",$alg);   $alg = preg_replace("/<217>/","3u2 3d2",$alg);   $alg = preg_replace("/<218>/","3u' 3d",$alg);
    
    $alg = preg_replace("/<219>/","r' l",$alg);   $alg = preg_replace("/<220>/","r2 l2",$alg);   $alg = preg_replace("/<221>/","r l'",$alg);
    $alg = preg_replace("/<222>/","r l'",$alg);   $alg = preg_replace("/<223>/","r2 l2",$alg);   $alg = preg_replace("/<224>/","r' l",$alg);
    $alg = preg_replace("/<225>/","f' b",$alg);   $alg = preg_replace("/<226>/","f2 b2",$alg);   $alg = preg_replace("/<227>/","f b'",$alg);
    $alg = preg_replace("/<228>/","f b'",$alg);   $alg = preg_replace("/<229>/","f2 b2",$alg);   $alg = preg_replace("/<230>/","f' b",$alg);
    $alg = preg_replace("/<231>/","u' d",$alg);   $alg = preg_replace("/<232>/","u2 d2",$alg);   $alg = preg_replace("/<233>/","u d'",$alg);
    $alg = preg_replace("/<234>/","u d'",$alg);   $alg = preg_replace("/<235>/","u2 d2",$alg);   $alg = preg_replace("/<236>/","u' d",$alg);
    
    $alg = preg_replace("/<237>/","R' L",$alg);   $alg = preg_replace("/<238>/","R2 L2",$alg);   $alg = preg_replace("/<239>/","R L'",$alg);
    $alg = preg_replace("/<240>/","R L'",$alg);   $alg = preg_replace("/<241>/","R2 L2",$alg);   $alg = preg_replace("/<242>/","R' L",$alg);
    $alg = preg_replace("/<243>/","F' B",$alg);   $alg = preg_replace("/<244>/","F2 B2",$alg);   $alg = preg_replace("/<245>/","F B'",$alg);
    $alg = preg_replace("/<246>/","F B'",$alg);   $alg = preg_replace("/<247>/","F2 B2",$alg);   $alg = preg_replace("/<248>/","F' B",$alg);
    $alg = preg_replace("/<249>/","U' D",$alg);   $alg = preg_replace("/<250>/","U2 D2",$alg);   $alg = preg_replace("/<251>/","U D'",$alg);
    $alg = preg_replace("/<252>/","U D'",$alg);   $alg = preg_replace("/<253>/","U2 D2",$alg);   $alg = preg_replace("/<254>/","U' D",$alg);
    
    $alg = preg_replace("/<255>/","R' 5l",$alg);   $alg = preg_replace("/<256>/","R2 5l2",$alg);   $alg = preg_replace("/<257>/","R 5l'",$alg);
    $alg = preg_replace("/<258>/","5r L'",$alg);   $alg = preg_replace("/<259>/","5r2 L2",$alg);   $alg = preg_replace("/<260>/","5r' L",$alg);
    $alg = preg_replace("/<261>/","F' 5b",$alg);   $alg = preg_replace("/<262>/","F2 5b2",$alg);   $alg = preg_replace("/<263>/","F 5b'",$alg);
    $alg = preg_replace("/<264>/","5f B'",$alg);   $alg = preg_replace("/<265>/","5f2 B2",$alg);   $alg = preg_replace("/<266>/","5f' B",$alg);
    $alg = preg_replace("/<267>/","U' 5d",$alg);   $alg = preg_replace("/<268>/","U2 5d2",$alg);   $alg = preg_replace("/<269>/","U 5d'",$alg);
    $alg = preg_replace("/<270>/","5u D'",$alg);   $alg = preg_replace("/<271>/","5u2 D2",$alg);   $alg = preg_replace("/<272>/","5u' D",$alg);
    
    $alg = preg_replace("/<273>/","R' 4l",$alg);   $alg = preg_replace("/<274>/","R2 4l2",$alg);   $alg = preg_replace("/<275>/","R 4l'",$alg);
    $alg = preg_replace("/<276>/","4r L'",$alg);   $alg = preg_replace("/<277>/","4r2 L2",$alg);   $alg = preg_replace("/<278>/","4r' L",$alg);
    $alg = preg_replace("/<279>/","F' 4b",$alg);   $alg = preg_replace("/<280>/","F2 4b2",$alg);   $alg = preg_replace("/<281>/","F 4b'",$alg);
    $alg = preg_replace("/<282>/","4f B'",$alg);   $alg = preg_replace("/<283>/","4f2 B2",$alg);   $alg = preg_replace("/<284>/","4f' B",$alg);
    $alg = preg_replace("/<285>/","U' 4d",$alg);   $alg = preg_replace("/<286>/","U2 4d2",$alg);   $alg = preg_replace("/<287>/","R 4d'",$alg);
    $alg = preg_replace("/<288>/","4u D'",$alg);   $alg = preg_replace("/<289>/","4u2 D2",$alg);   $alg = preg_replace("/<290>/","4u' D",$alg);
    
    $alg = preg_replace("/<291>/","R' 3l",$alg);    $alg = preg_replace("/<292>/","R2 3l2",$alg);    $alg = preg_replace("/<293>/","R 3l'",$alg);
    $alg = preg_replace("/<294>/","3r L'",$alg);    $alg = preg_replace("/<295>/","3r2 L2",$alg);    $alg = preg_replace("/<296>/","3r' L",$alg);
    $alg = preg_replace("/<297>/","F' 3b",$alg);    $alg = preg_replace("/<298>/","F2 3b2",$alg);    $alg = preg_replace("/<299>/","F 3b'",$alg);
    $alg = preg_replace("/<2100>/","3f B'",$alg);   $alg = preg_replace("/<2101>/","3f2 B2",$alg);   $alg = preg_replace("/<2102>/","3f' B",$alg);
    $alg = preg_replace("/<2103>/","U' 3d",$alg);   $alg = preg_replace("/<2104>/","U2 3d2",$alg);   $alg = preg_replace("/<2105>/","U 3d'",$alg);
    $alg = preg_replace("/<2106>/","3u D'",$alg);   $alg = preg_replace("/<2107>/","3u2 D2",$alg);   $alg = preg_replace("/<2108>/","3u' D",$alg);
    
    $alg = preg_replace("/<2109>/","R' l",$alg);   $alg = preg_replace("/<2110>/","R2 l2",$alg);   $alg = preg_replace("/<2111>/","R l'",$alg);
    $alg = preg_replace("/<2112>/","r L'",$alg);   $alg = preg_replace("/<2113>/","r2 L2",$alg);   $alg = preg_replace("/<2114>/","r' L",$alg);
    $alg = preg_replace("/<2115>/","F' b",$alg);   $alg = preg_replace("/<2116>/","F2 b2",$alg);   $alg = preg_replace("/<2117>/","F b'",$alg);
    $alg = preg_replace("/<2118>/","f B'",$alg);   $alg = preg_replace("/<2119>/","f2 B2",$alg);   $alg = preg_replace("/<2120>/","f' B",$alg);
    $alg = preg_replace("/<2121>/","U' d",$alg);   $alg = preg_replace("/<2122>/","U2 d2",$alg);   $alg = preg_replace("/<2123>/","U d'",$alg);
    $alg = preg_replace("/<2124>/","u D'",$alg);   $alg = preg_replace("/<2125>/","u2 D2",$alg);   $alg = preg_replace("/<2126>/","u' D",$alg);
    
    $alg = preg_replace("/<2127>/","r' 4l",$alg);   $alg = preg_replace("/<2128>/","r2 4l2",$alg);   $alg = preg_replace("/<2129>/","r 4l'",$alg);
    $alg = preg_replace("/<2130>/","4r l'",$alg);   $alg = preg_replace("/<2131>/","4r2 l2",$alg);   $alg = preg_replace("/<2132>/","4r' l",$alg);
    $alg = preg_replace("/<2133>/","f' 4b",$alg);   $alg = preg_replace("/<2134>/","f2 4b2",$alg);   $alg = preg_replace("/<2135>/","f 4b'",$alg);
    $alg = preg_replace("/<2136>/","4f b'",$alg);   $alg = preg_replace("/<2137>/","4f2 b2",$alg);   $alg = preg_replace("/<2138>/","4f' b",$alg);
    $alg = preg_replace("/<2139>/","u' 4d",$alg);   $alg = preg_replace("/<2140>/","u2 4d2",$alg);   $alg = preg_replace("/<2141>/","u 4d'",$alg);
    $alg = preg_replace("/<2142>/","4u d'",$alg);   $alg = preg_replace("/<2143>/","4u2 d2",$alg);   $alg = preg_replace("/<2144>/","4u' d",$alg);
    
    /* S3-4R */
    
    /* --- 7xC: CODE -> TWIZZLE: [3] Tier twists --- */
    $alg = preg_replace("/<301>/","6r'",$alg);   $alg = preg_replace("/<302>/","6r2",$alg);   $alg = preg_replace("/<303>/","6r",$alg);
    $alg = preg_replace("/<304>/","6l'",$alg);   $alg = preg_replace("/<305>/","6l2",$alg);   $alg = preg_replace("/<306>/","6l",$alg);
    $alg = preg_replace("/<307>/","6f'",$alg);   $alg = preg_replace("/<308>/","6f2",$alg);   $alg = preg_replace("/<309>/","6f",$alg);
    $alg = preg_replace("/<310>/","6b'",$alg);   $alg = preg_replace("/<311>/","6b2",$alg);   $alg = preg_replace("/<312>/","6b",$alg);
    $alg = preg_replace("/<313>/","6u'",$alg);   $alg = preg_replace("/<314>/","6u2",$alg);   $alg = preg_replace("/<315>/","6u",$alg);
    $alg = preg_replace("/<316>/","6d'",$alg);   $alg = preg_replace("/<317>/","6d2",$alg);   $alg = preg_replace("/<318>/","6d",$alg);
    
    $alg = preg_replace("/<319>/","5r'",$alg);   $alg = preg_replace("/<320>/","5r2",$alg);   $alg = preg_replace("/<321>/","5r",$alg);
    $alg = preg_replace("/<322>/","5l'",$alg);   $alg = preg_replace("/<323>/","5l2",$alg);   $alg = preg_replace("/<324>/","5l",$alg);
    $alg = preg_replace("/<325>/","5f'",$alg);   $alg = preg_replace("/<326>/","5f2",$alg);   $alg = preg_replace("/<327>/","5f",$alg);
    $alg = preg_replace("/<328>/","5b'",$alg);   $alg = preg_replace("/<329>/","5b2",$alg);   $alg = preg_replace("/<330>/","5b",$alg);
    $alg = preg_replace("/<331>/","5u'",$alg);   $alg = preg_replace("/<332>/","5u2",$alg);   $alg = preg_replace("/<333>/","5u",$alg);
    $alg = preg_replace("/<334>/","5d'",$alg);   $alg = preg_replace("/<335>/","5d2",$alg);   $alg = preg_replace("/<336>/","5d",$alg);
    
    $alg = preg_replace("/<337>/","4r'",$alg);   $alg = preg_replace("/<338>/","4r2",$alg);   $alg = preg_replace("/<339>/","4r",$alg);
    $alg = preg_replace("/<340>/","4l'",$alg);   $alg = preg_replace("/<341>/","4l2",$alg);   $alg = preg_replace("/<342>/","4l",$alg);
    $alg = preg_replace("/<343>/","4f'",$alg);   $alg = preg_replace("/<344>/","4f2",$alg);   $alg = preg_replace("/<345>/","4f",$alg);
    $alg = preg_replace("/<346>/","4b'",$alg);   $alg = preg_replace("/<347>/","4b2",$alg);   $alg = preg_replace("/<348>/","4b",$alg);
    $alg = preg_replace("/<349>/","4u'",$alg);   $alg = preg_replace("/<350>/","4u2",$alg);   $alg = preg_replace("/<351>/","4u",$alg);
    $alg = preg_replace("/<352>/","4d'",$alg);   $alg = preg_replace("/<353>/","4d2",$alg);   $alg = preg_replace("/<354>/","4d",$alg);
    
    $alg = preg_replace("/<355>/","3r'",$alg);   $alg = preg_replace("/<356>/","3r2",$alg);   $alg = preg_replace("/<357>/","3r",$alg);
    $alg = preg_replace("/<358>/","3l'",$alg);   $alg = preg_replace("/<359>/","3l2",$alg);   $alg = preg_replace("/<360>/","3l",$alg);
    $alg = preg_replace("/<361>/","3f'",$alg);   $alg = preg_replace("/<362>/","3f2",$alg);   $alg = preg_replace("/<363>/","3f",$alg);
    $alg = preg_replace("/<364>/","3b'",$alg);   $alg = preg_replace("/<365>/","3b2",$alg);   $alg = preg_replace("/<366>/","3b",$alg);
    $alg = preg_replace("/<367>/","3u'",$alg);   $alg = preg_replace("/<368>/","3u2",$alg);   $alg = preg_replace("/<369>/","3u",$alg);
    $alg = preg_replace("/<370>/","3d'",$alg);   $alg = preg_replace("/<371>/","3d2",$alg);   $alg = preg_replace("/<372>/","3d",$alg);
    
    $alg = preg_replace("/<373>/","r'",$alg);   $alg = preg_replace("/<374>/","r2",$alg);   $alg = preg_replace("/<375>/","r",$alg);
    $alg = preg_replace("/<376>/","l'",$alg);   $alg = preg_replace("/<377>/","l2",$alg);   $alg = preg_replace("/<378>/","l",$alg);
    $alg = preg_replace("/<379>/","f'",$alg);   $alg = preg_replace("/<380>/","f2",$alg);   $alg = preg_replace("/<381>/","f",$alg);
    $alg = preg_replace("/<382>/","b'",$alg);   $alg = preg_replace("/<383>/","b2",$alg);   $alg = preg_replace("/<384>/","b",$alg);
    $alg = preg_replace("/<385>/","u'",$alg);   $alg = preg_replace("/<386>/","u2",$alg);   $alg = preg_replace("/<387>/","u",$alg);
    $alg = preg_replace("/<388>/","d'",$alg);   $alg = preg_replace("/<389>/","d2",$alg);   $alg = preg_replace("/<390>/","d",$alg);
    
    /* --- 7xC: CODE -> TWIZZLE: [4] Void twists --- */
    $alg = preg_replace("/<401>/","2-5R'",$alg);   $alg = preg_replace("/<402>/","2-5R2",$alg);   $alg = preg_replace("/<403>/","2-5R",$alg);
    $alg = preg_replace("/<404>/","2-5L'",$alg);   $alg = preg_replace("/<405>/","2-5L2",$alg);   $alg = preg_replace("/<406>/","2-5L",$alg);
    $alg = preg_replace("/<407>/","2-5F'",$alg);   $alg = preg_replace("/<408>/","2-5F2",$alg);   $alg = preg_replace("/<409>/","2-5F",$alg);
    $alg = preg_replace("/<410>/","2-5B'",$alg);   $alg = preg_replace("/<411>/","2-5B2",$alg);   $alg = preg_replace("/<412>/","2-5B",$alg);
    $alg = preg_replace("/<413>/","2-5U'",$alg);   $alg = preg_replace("/<414>/","2-5U2",$alg);   $alg = preg_replace("/<415>/","2-5U",$alg);
    $alg = preg_replace("/<416>/","2-5D'",$alg);   $alg = preg_replace("/<417>/","2-5D2",$alg);   $alg = preg_replace("/<418>/","2-5D",$alg);
    
    $alg = preg_replace("/<419>/","2-4R'",$alg);   $alg = preg_replace("/<420>/","2-4R2",$alg);   $alg = preg_replace("/<421>/","2-4R",$alg);
    $alg = preg_replace("/<422>/","2-4L'",$alg);   $alg = preg_replace("/<423>/","2-4L2",$alg);   $alg = preg_replace("/<424>/","2-4L",$alg);
    $alg = preg_replace("/<425>/","2-4F'",$alg);   $alg = preg_replace("/<426>/","2-4F2",$alg);   $alg = preg_replace("/<427>/","2-4F",$alg);
    $alg = preg_replace("/<428>/","2-4B'",$alg);   $alg = preg_replace("/<429>/","2-4B2",$alg);   $alg = preg_replace("/<430>/","2-4B",$alg);
    $alg = preg_replace("/<431>/","2-4U'",$alg);   $alg = preg_replace("/<432>/","2-4U2",$alg);   $alg = preg_replace("/<433>/","2-4U",$alg);
    $alg = preg_replace("/<434>/","2-4D'",$alg);   $alg = preg_replace("/<435>/","2-4D2",$alg);   $alg = preg_replace("/<436>/","2-4D",$alg);
    
    $alg = preg_replace("/<437>/","2-3R'",$alg);   $alg = preg_replace("/<438>/","2-3R2",$alg);   $alg = preg_replace("/<439>/","2-3R",$alg);
    $alg = preg_replace("/<440>/","2-3L'",$alg);   $alg = preg_replace("/<441>/","2-3L2",$alg);   $alg = preg_replace("/<442>/","2-3L",$alg);
    $alg = preg_replace("/<443>/","2-3F'",$alg);   $alg = preg_replace("/<444>/","2-3F2",$alg);   $alg = preg_replace("/<445>/","2-3F",$alg);
    $alg = preg_replace("/<446>/","2-3B'",$alg);   $alg = preg_replace("/<447>/","2-3B2",$alg);   $alg = preg_replace("/<448>/","2-3B",$alg);
    $alg = preg_replace("/<449>/","2-3U'",$alg);   $alg = preg_replace("/<450>/","2-3U2",$alg);   $alg = preg_replace("/<451>/","2-3U",$alg);
    $alg = preg_replace("/<452>/","2-3D'",$alg);   $alg = preg_replace("/<453>/","2-3D2",$alg);   $alg = preg_replace("/<454>/","2-3D",$alg);
     
    /* --- 7xC: CODE -> TWIZZLE: [5] Mid-layer twists --- */
    $alg = preg_replace("/<501>/","3-5R'",$alg);   $alg = preg_replace("/<502>/","3-5R2",$alg);   $alg = preg_replace("/<503>/","3-5R",$alg);
    $alg = preg_replace("/<504>/","3-5L'",$alg);   $alg = preg_replace("/<505>/","3-5L2",$alg);   $alg = preg_replace("/<506>/","3-5L",$alg);
    $alg = preg_replace("/<507>/","3-5F'",$alg);   $alg = preg_replace("/<508>/","3-5F2",$alg);   $alg = preg_replace("/<509>/","3-5F",$alg);
    $alg = preg_replace("/<510>/","3-5B'",$alg);   $alg = preg_replace("/<511>/","3-5B2",$alg);   $alg = preg_replace("/<512>/","3-5B",$alg);
    $alg = preg_replace("/<513>/","3-5U'",$alg);   $alg = preg_replace("/<514>/","3-5U2",$alg);   $alg = preg_replace("/<515>/","3-5U",$alg);
    $alg = preg_replace("/<516>/","3-5D'",$alg);   $alg = preg_replace("/<517>/","3-5D2",$alg);   $alg = preg_replace("/<518>/","3-5D",$alg);
    
    $alg = preg_replace("/<519>/","3-4R'",$alg);   $alg = preg_replace("/<520>/","3-4R2",$alg);   $alg = preg_replace("/<521>/","3-4R",$alg);
    $alg = preg_replace("/<522>/","3-4L'",$alg);   $alg = preg_replace("/<523>/","3-4L2",$alg);   $alg = preg_replace("/<524>/","3-4L",$alg);
    $alg = preg_replace("/<525>/","3-4F'",$alg);   $alg = preg_replace("/<526>/","3-4F2",$alg);   $alg = preg_replace("/<527>/","3-4F",$alg);
    $alg = preg_replace("/<528>/","3-4B'",$alg);   $alg = preg_replace("/<529>/","3-4B2",$alg);   $alg = preg_replace("/<530>/","3-4B",$alg);
    $alg = preg_replace("/<531>/","3-4U'",$alg);   $alg = preg_replace("/<532>/","3-4U2",$alg);   $alg = preg_replace("/<533>/","3-4U",$alg);
    $alg = preg_replace("/<534>/","3-4D'",$alg);   $alg = preg_replace("/<535>/","3-4D2",$alg);   $alg = preg_replace("/<536>/","3-4D",$alg);
    
    /* --- 7xC: CODE -> TWIZZLE: [6] Wide-layer twists [5] (Mid-layer twists) --- */
    if ($useSiGN == true) { // Bei SiGN:
      $alg = preg_replace("/<601>/","m",$alg);    $alg = preg_replace("/<602>/","m2",$alg);   $alg = preg_replace("/<603>/","m'",$alg);
      $alg = preg_replace("/<604>/","m'",$alg);   $alg = preg_replace("/<605>/","m2",$alg);   $alg = preg_replace("/<606>/","m",$alg);
      $alg = preg_replace("/<607>/","s'",$alg);   $alg = preg_replace("/<608>/","s2",$alg);   $alg = preg_replace("/<609>/","s",$alg);
      $alg = preg_replace("/<610>/","s",$alg);    $alg = preg_replace("/<611>/","s2",$alg);   $alg = preg_replace("/<612>/","s'",$alg);
      $alg = preg_replace("/<613>/","e",$alg);    $alg = preg_replace("/<614>/","e2",$alg);   $alg = preg_replace("/<615>/","e'",$alg);
      $alg = preg_replace("/<616>/","e'",$alg);   $alg = preg_replace("/<617>/","e2",$alg);   $alg = preg_replace("/<618>/","e",$alg);
    } else {               // Sonst (TWIZZLE):
      $alg = preg_replace("/<601>/","2-6R'",$alg);   $alg = preg_replace("/<602>/","2-6R2",$alg);   $alg = preg_replace("/<603>/","2-6R",$alg);
      $alg = preg_replace("/<604>/","2-6L'",$alg);   $alg = preg_replace("/<605>/","2-6L2",$alg);   $alg = preg_replace("/<606>/","2-6L",$alg);
      $alg = preg_replace("/<607>/","2-6F'",$alg);   $alg = preg_replace("/<608>/","2-6F2",$alg);   $alg = preg_replace("/<609>/","2-6F",$alg);
      $alg = preg_replace("/<610>/","2-6B'",$alg);   $alg = preg_replace("/<611>/","2-6B2",$alg);   $alg = preg_replace("/<612>/","2-6B",$alg);
      $alg = preg_replace("/<613>/","2-6U'",$alg);   $alg = preg_replace("/<614>/","2-6U2",$alg);   $alg = preg_replace("/<615>/","2-6U",$alg);
      $alg = preg_replace("/<616>/","2-6D'",$alg);   $alg = preg_replace("/<617>/","2-6D2",$alg);   $alg = preg_replace("/<618>/","2-6D",$alg);
    }
    
    /* --- 7xC: CODE -> TWIZZLE: [7] Cube rotations --- */
    if ($useSiGN == true) { // Bei SiGN:
      $alg = preg_replace("/<701>/","x'",$alg);   $alg = preg_replace("/<702>/","x2",$alg);   $alg = preg_replace("/<703>/","x",$alg);
      $alg = preg_replace("/<704>/","x",$alg);    $alg = preg_replace("/<705>/","x2",$alg);   $alg = preg_replace("/<706>/","x'",$alg);
      $alg = preg_replace("/<707>/","z'",$alg);   $alg = preg_replace("/<708>/","z2",$alg);   $alg = preg_replace("/<709>/","z",$alg);
      $alg = preg_replace("/<710>/","z",$alg);    $alg = preg_replace("/<711>/","z2",$alg);   $alg = preg_replace("/<712>/","z'",$alg);
      $alg = preg_replace("/<713>/","y'",$alg);   $alg = preg_replace("/<714>/","y2",$alg);   $alg = preg_replace("/<715>/","y",$alg);
      $alg = preg_replace("/<716>/","y",$alg);    $alg = preg_replace("/<717>/","y2",$alg);   $alg = preg_replace("/<718>/","y'",$alg);
    } else {               // Sonst (TWIZZLE):
      $alg = preg_replace("/<701>/","Rv'",$alg);   $alg = preg_replace("/<702>/","Rv2",$alg);   $alg = preg_replace("/<703>/","Rv",$alg);
      $alg = preg_replace("/<704>/","Rv",$alg);    $alg = preg_replace("/<705>/","Rv2",$alg);   $alg = preg_replace("/<706>/","Rv'",$alg);
      $alg = preg_replace("/<707>/","Fv'",$alg);   $alg = preg_replace("/<708>/","Fv2",$alg);   $alg = preg_replace("/<709>/","Fv",$alg);
      $alg = preg_replace("/<710>/","Fv",$alg);    $alg = preg_replace("/<711>/","Fv2",$alg);   $alg = preg_replace("/<712>/","Fv'",$alg);
      $alg = preg_replace("/<713>/","Uv'",$alg);   $alg = preg_replace("/<714>/","Uv2",$alg);   $alg = preg_replace("/<715>/","Uv",$alg);
      $alg = preg_replace("/<716>/","Uv",$alg);    $alg = preg_replace("/<717>/","Uv2",$alg);   $alg = preg_replace("/<718>/","Uv'",$alg);
    }
    
    /* --- 7xC: CODE -> TWIZZLE: [9] Face twists --- */
    $alg = preg_replace("/<901>/","R'",$alg);   $alg = preg_replace("/<902>/","R2",$alg);   $alg = preg_replace("/<903>/","R",$alg);
    $alg = preg_replace("/<904>/","L'",$alg);   $alg = preg_replace("/<905>/","L2",$alg);   $alg = preg_replace("/<906>/","L",$alg);
    $alg = preg_replace("/<907>/","F'",$alg);   $alg = preg_replace("/<908>/","F2",$alg);   $alg = preg_replace("/<909>/","F",$alg);
    $alg = preg_replace("/<910>/","B'",$alg);   $alg = preg_replace("/<911>/","B2",$alg);   $alg = preg_replace("/<912>/","B",$alg);
    $alg = preg_replace("/<913>/","U'",$alg);   $alg = preg_replace("/<914>/","U2",$alg);   $alg = preg_replace("/<915>/","U",$alg);
    $alg = preg_replace("/<916>/","D'",$alg);   $alg = preg_replace("/<917>/","D2",$alg);   $alg = preg_replace("/<918>/","D",$alg);
    
    return $alg;
  }
  
  
  
  
  /* 
  ---------------------------------------------------------------------------------------------------
  * alg7xC_TwizzleToSse($alg)
  * 
  * Converts 7x7 V-Cube 7 TWIZZLE algorithms into SSE notation.
  * 
  * Parameter: $alg (STRING): The algorithm.
  * 
  * Return: STRING.
  ---------------------------------------------------------------------------------------------------
  */
  function alg7xC_TwizzleToSse($alg) {
    /* --- 7xC: Marker --- */
    $alg = str_replace(".","·",$alg);
    
    /* ··································································································· */
    /* --- 7xC: TWIZZLE -> CODE: [6] Wide layer twists --- */
    $alg = preg_replace("/2-6R'/","<601>",$alg); $alg = preg_replace("/2-6R2/","<602>",$alg); $alg = preg_replace("/2-6R/","<603>",$alg);
    $alg = preg_replace("/2-6L'/","<604>",$alg); $alg = preg_replace("/2-6L2/","<605>",$alg); $alg = preg_replace("/2-6L/","<606>",$alg);
    $alg = preg_replace("/2-6F'/","<607>",$alg); $alg = preg_replace("/2-6F2/","<608>",$alg); $alg = preg_replace("/2-6F/","<609>",$alg);
    $alg = preg_replace("/2-6B'/","<610>",$alg); $alg = preg_replace("/2-6B2/","<611>",$alg); $alg = preg_replace("/2-6B/","<612>",$alg);
    $alg = preg_replace("/2-6U'/","<613>",$alg); $alg = preg_replace("/2-6U2/","<614>",$alg); $alg = preg_replace("/2-6U/","<615>",$alg);
    $alg = preg_replace("/2-6D'/","<616>",$alg); $alg = preg_replace("/2-6D2/","<617>",$alg); $alg = preg_replace("/2-6D/","<618>",$alg);
    
    $alg = preg_replace("/m'/","<603>",$alg); $alg = preg_replace("/m2/","<602>",$alg); $alg = preg_replace("/m/","<601>",$alg);
    $alg = preg_replace("/s'/","<607>",$alg); $alg = preg_replace("/s2/","<608>",$alg); $alg = preg_replace("/s/","<609>",$alg);
    $alg = preg_replace("/e'/","<615>",$alg); $alg = preg_replace("/e2/","<614>",$alg); $alg = preg_replace("/e/","<613>",$alg);
    
    /* --- 7xC: TWIZZLE -> CODE: [4] Void twists --- */
    $alg = preg_replace("/2-3R'/","<401>",$alg); $alg = preg_replace("/2-3R2/","<402>",$alg); $alg = preg_replace("/2-3R/","<403>",$alg);
    $alg = preg_replace("/2-3L'/","<404>",$alg); $alg = preg_replace("/2-3L2/","<405>",$alg); $alg = preg_replace("/2-3L/","<406>",$alg);
    $alg = preg_replace("/2-3F'/","<407>",$alg); $alg = preg_replace("/2-3F2/","<408>",$alg); $alg = preg_replace("/2-3F/","<409>",$alg);
    $alg = preg_replace("/2-3B'/","<410>",$alg); $alg = preg_replace("/2-3B2/","<411>",$alg); $alg = preg_replace("/2-3B/","<412>",$alg);
    $alg = preg_replace("/2-3U'/","<413>",$alg); $alg = preg_replace("/2-3U2/","<414>",$alg); $alg = preg_replace("/2-3U/","<415>",$alg);
    $alg = preg_replace("/2-3D'/","<416>",$alg); $alg = preg_replace("/2-3D2/","<417>",$alg); $alg = preg_replace("/2-3D/","<418>",$alg);
    
    $alg = preg_replace("/2-4R'/","<419>",$alg); $alg = preg_replace("/2-4R2/","<420>",$alg); $alg = preg_replace("/2-4R/","<421>",$alg);
    $alg = preg_replace("/2-4L'/","<422>",$alg); $alg = preg_replace("/2-4L2/","<423>",$alg); $alg = preg_replace("/2-4L/","<424>",$alg);
    $alg = preg_replace("/2-4F'/","<425>",$alg); $alg = preg_replace("/2-4F2/","<426>",$alg); $alg = preg_replace("/2-4F/","<427>",$alg);
    $alg = preg_replace("/2-4B'/","<428>",$alg); $alg = preg_replace("/2-4B2/","<429>",$alg); $alg = preg_replace("/2-4B/","<430>",$alg);
    $alg = preg_replace("/2-4U'/","<431>",$alg); $alg = preg_replace("/2-4U2/","<432>",$alg); $alg = preg_replace("/2-4U/","<433>",$alg);
    $alg = preg_replace("/2-4D'/","<434>",$alg); $alg = preg_replace("/2-4D2/","<435>",$alg); $alg = preg_replace("/2-4D/","<436>",$alg);
    
    $alg = preg_replace("/2-5R'/","<437>",$alg); $alg = preg_replace("/2-5R2/","<438>",$alg); $alg = preg_replace("/2-5R/","<439>",$alg);
    $alg = preg_replace("/2-5L'/","<440>",$alg); $alg = preg_replace("/2-5L2/","<441>",$alg); $alg = preg_replace("/2-5L/","<442>",$alg);
    $alg = preg_replace("/2-5F'/","<443>",$alg); $alg = preg_replace("/2-5F2/","<444>",$alg); $alg = preg_replace("/2-5F/","<445>",$alg);
    $alg = preg_replace("/2-5B'/","<446>",$alg); $alg = preg_replace("/2-5B2/","<447>",$alg); $alg = preg_replace("/2-5B/","<448>",$alg);
    $alg = preg_replace("/2-5U'/","<449>",$alg); $alg = preg_replace("/2-5U2/","<450>",$alg); $alg = preg_replace("/2-5U/","<451>",$alg);
    $alg = preg_replace("/2-5D'/","<452>",$alg); $alg = preg_replace("/2-5D2/","<453>",$alg); $alg = preg_replace("/2-5D/","<454>",$alg);
    
    /* --- 7xC: TWIZZLE -> CODE: [5] Mid-layer twists --- */
    $alg = preg_replace("/3-5R'/","<501>",$alg); $alg = preg_replace("/3-5R2/","<502>",$alg); $alg = preg_replace("/3-5R/","<503>",$alg);
    $alg = preg_replace("/3-5L'/","<504>",$alg); $alg = preg_replace("/3-5L2/","<505>",$alg); $alg = preg_replace("/3-5L/","<506>",$alg);
    $alg = preg_replace("/3-5F'/","<507>",$alg); $alg = preg_replace("/3-5F2/","<508>",$alg); $alg = preg_replace("/3-5F/","<509>",$alg);
    $alg = preg_replace("/3-5B'/","<510>",$alg); $alg = preg_replace("/3-5B2/","<511>",$alg); $alg = preg_replace("/3-5B/","<512>",$alg);
    $alg = preg_replace("/3-5U'/","<513>",$alg); $alg = preg_replace("/3-5U2/","<514>",$alg); $alg = preg_replace("/3-5U/","<515>",$alg);
    $alg = preg_replace("/3-5D'/","<516>",$alg); $alg = preg_replace("/3-5D2/","<517>",$alg); $alg = preg_replace("/3-5D/","<518>",$alg);
    
    /* --- 7xC: TWIZZLE -> CODE: [3] Tier twists (WCA) --- */
    $alg = preg_replace("/6Rw'/","<301>",$alg); $alg = preg_replace("/6Rw2/","<302>",$alg); $alg = preg_replace("/6Rw/","<303>",$alg);
    $alg = preg_replace("/6Lw'/","<304>",$alg); $alg = preg_replace("/6Lw2/","<305>",$alg); $alg = preg_replace("/6Lw/","<306>",$alg);
    $alg = preg_replace("/6Fw'/","<307>",$alg); $alg = preg_replace("/6Fw2/","<308>",$alg); $alg = preg_replace("/6Fw/","<309>",$alg);
    $alg = preg_replace("/6Bw'/","<310>",$alg); $alg = preg_replace("/6Bw2/","<311>",$alg); $alg = preg_replace("/6Bw/","<312>",$alg);
    $alg = preg_replace("/6Uw'/","<313>",$alg); $alg = preg_replace("/6Uw2/","<314>",$alg); $alg = preg_replace("/6Uw/","<315>",$alg);
    $alg = preg_replace("/6Dw'/","<316>",$alg); $alg = preg_replace("/6Dw2/","<317>",$alg); $alg = preg_replace("/6Dw/","<318>",$alg);
    
    $alg = preg_replace("/5Rw'/","<319>",$alg); $alg = preg_replace("/5Rw2/","<320>",$alg); $alg = preg_replace("/5Rw/","<321>",$alg);
    $alg = preg_replace("/5Lw'/","<322>",$alg); $alg = preg_replace("/5Lw2/","<323>",$alg); $alg = preg_replace("/5Lw/","<324>",$alg);
    $alg = preg_replace("/5Fw'/","<325>",$alg); $alg = preg_replace("/5Fw2/","<326>",$alg); $alg = preg_replace("/5Fw/","<327>",$alg);
    $alg = preg_replace("/5Bw'/","<328>",$alg); $alg = preg_replace("/5Bw2/","<329>",$alg); $alg = preg_replace("/5Bw/","<330>",$alg);
    $alg = preg_replace("/5Uw'/","<331>",$alg); $alg = preg_replace("/5Uw2/","<332>",$alg); $alg = preg_replace("/5Uw/","<333>",$alg);
    $alg = preg_replace("/5Dw'/","<334>",$alg); $alg = preg_replace("/5Dw2/","<335>",$alg); $alg = preg_replace("/5Dw/","<336>",$alg);
    
    $alg = preg_replace("/4Rw'/","<337>",$alg); $alg = preg_replace("/4Rw2/","<338>",$alg); $alg = preg_replace("/4Rw/","<339>",$alg);
    $alg = preg_replace("/4Lw'/","<340>",$alg); $alg = preg_replace("/4Lw2/","<341>",$alg); $alg = preg_replace("/4Lw/","<342>",$alg);
    $alg = preg_replace("/4Fw'/","<343>",$alg); $alg = preg_replace("/4Fw2/","<344>",$alg); $alg = preg_replace("/4Fw/","<345>",$alg);
    $alg = preg_replace("/4Bw'/","<346>",$alg); $alg = preg_replace("/4Bw2/","<347>",$alg); $alg = preg_replace("/4Bw/","<348>",$alg);
    $alg = preg_replace("/4Uw'/","<349>",$alg); $alg = preg_replace("/4Uw2/","<350>",$alg); $alg = preg_replace("/4Uw/","<351>",$alg);
    $alg = preg_replace("/4Dw'/","<352>",$alg); $alg = preg_replace("/4Dw2/","<353>",$alg); $alg = preg_replace("/4Dw/","<354>",$alg);
    
    $alg = preg_replace("/3Rw'/","<355>",$alg); $alg = preg_replace("/3Rw2/","<356>",$alg); $alg = preg_replace("/3Rw/","<357>",$alg);
    $alg = preg_replace("/3Lw'/","<358>",$alg); $alg = preg_replace("/3Lw2/","<359>",$alg); $alg = preg_replace("/3Lw/","<360>",$alg);
    $alg = preg_replace("/3Fw'/","<361>",$alg); $alg = preg_replace("/3Fw2/","<362>",$alg); $alg = preg_replace("/3Fw/","<363>",$alg);
    $alg = preg_replace("/3Bw'/","<364>",$alg); $alg = preg_replace("/3Bw2/","<365>",$alg); $alg = preg_replace("/3Bw/","<366>",$alg);
    $alg = preg_replace("/3Uw'/","<367>",$alg); $alg = preg_replace("/3Uw2/","<368>",$alg); $alg = preg_replace("/3Uw/","<369>",$alg);
    $alg = preg_replace("/3Dw'/","<370>",$alg); $alg = preg_replace("/3Dw2/","<371>",$alg); $alg = preg_replace("/3Dw/","<372>",$alg);
    
    /* --- 7xC: TWIZZLE -> CODE: [1] Numbered layer twists, [5] Mid-layer twists --- */
    $alg = preg_replace("/2R'/","<101>",$alg); $alg = preg_replace("/2R2/","<102>",$alg); $alg = preg_replace("/2R/","<103>",$alg);
    $alg = preg_replace("/2L'/","<104>",$alg); $alg = preg_replace("/2L2/","<105>",$alg); $alg = preg_replace("/2L/","<106>",$alg);
    $alg = preg_replace("/2F'/","<107>",$alg); $alg = preg_replace("/2F2/","<108>",$alg); $alg = preg_replace("/2F/","<109>",$alg);
    $alg = preg_replace("/2B'/","<110>",$alg); $alg = preg_replace("/2B2/","<111>",$alg); $alg = preg_replace("/2B/","<112>",$alg);
    $alg = preg_replace("/2U'/","<113>",$alg); $alg = preg_replace("/2U2/","<114>",$alg); $alg = preg_replace("/2U/","<115>",$alg);
    $alg = preg_replace("/2D'/","<116>",$alg); $alg = preg_replace("/2D2/","<117>",$alg); $alg = preg_replace("/2D/","<118>",$alg);
    
    $alg = preg_replace("/6R'/","<106>",$alg); $alg = preg_replace("/6R2/","<105>",$alg); $alg = preg_replace("/6R/","<104>",$alg);
    $alg = preg_replace("/6L'/","<103>",$alg); $alg = preg_replace("/6L2/","<102>",$alg); $alg = preg_replace("/6L/","<101>",$alg);
    $alg = preg_replace("/6F'/","<112>",$alg); $alg = preg_replace("/6F2/","<111>",$alg); $alg = preg_replace("/6F/","<110>",$alg);
    $alg = preg_replace("/6B'/","<109>",$alg); $alg = preg_replace("/6B2/","<108>",$alg); $alg = preg_replace("/6B/","<107>",$alg);
    $alg = preg_replace("/6U'/","<118>",$alg); $alg = preg_replace("/6U2/","<117>",$alg); $alg = preg_replace("/6U/","<116>",$alg);
    $alg = preg_replace("/6D'/","<115>",$alg); $alg = preg_replace("/6D2/","<114>",$alg); $alg = preg_replace("/6D/","<113>",$alg);
    
    $alg = preg_replace("/3R'/","<119>",$alg); $alg = preg_replace("/3R2/","<120>",$alg); $alg = preg_replace("/3R/","<121>",$alg);
    $alg = preg_replace("/3L'/","<122>",$alg); $alg = preg_replace("/3L2/","<123>",$alg); $alg = preg_replace("/3L/","<124>",$alg);
    $alg = preg_replace("/3F'/","<125>",$alg); $alg = preg_replace("/3F2/","<126>",$alg); $alg = preg_replace("/3F/","<127>",$alg);
    $alg = preg_replace("/3B'/","<128>",$alg); $alg = preg_replace("/3B2/","<129>",$alg); $alg = preg_replace("/3B/","<130>",$alg);
    $alg = preg_replace("/3U'/","<131>",$alg); $alg = preg_replace("/3U2/","<132>",$alg); $alg = preg_replace("/3U/","<133>",$alg);
    $alg = preg_replace("/3D'/","<134>",$alg); $alg = preg_replace("/3D2/","<135>",$alg); $alg = preg_replace("/3D/","<136>",$alg);
    
    $alg = preg_replace("/5R'/","<124>",$alg); $alg = preg_replace("/5R2/","<123>",$alg); $alg = preg_replace("/5R/","<122>",$alg);
    $alg = preg_replace("/5L'/","<121>",$alg); $alg = preg_replace("/5L2/","<120>",$alg); $alg = preg_replace("/5L/","<119>",$alg);
    $alg = preg_replace("/5F'/","<130>",$alg); $alg = preg_replace("/5F2/","<129>",$alg); $alg = preg_replace("/5F/","<128>",$alg);
    $alg = preg_replace("/5B'/","<127>",$alg); $alg = preg_replace("/5B2/","<126>",$alg); $alg = preg_replace("/5B/","<125>",$alg);
    $alg = preg_replace("/5U'/","<136>",$alg); $alg = preg_replace("/5U2/","<135>",$alg); $alg = preg_replace("/5U/","<134>",$alg);
    $alg = preg_replace("/5D'/","<133>",$alg); $alg = preg_replace("/5D2/","<132>",$alg); $alg = preg_replace("/5D/","<131>",$alg);
    
    $alg = preg_replace("/4R'/","<137>",$alg); $alg = preg_replace("/4R2/","<138>",$alg); $alg = preg_replace("/4R/","<139>",$alg);
    $alg = preg_replace("/4L'/","<140>",$alg); $alg = preg_replace("/4L2/","<141>",$alg); $alg = preg_replace("/4L/","<142>",$alg);
    $alg = preg_replace("/4F'/","<143>",$alg); $alg = preg_replace("/4F2/","<144>",$alg); $alg = preg_replace("/4F/","<145>",$alg);
    $alg = preg_replace("/4B'/","<146>",$alg); $alg = preg_replace("/4B2/","<147>",$alg); $alg = preg_replace("/4B/","<148>",$alg);
    $alg = preg_replace("/4U'/","<149>",$alg); $alg = preg_replace("/4U2/","<150>",$alg); $alg = preg_replace("/4U/","<151>",$alg);
    $alg = preg_replace("/4D'/","<152>",$alg); $alg = preg_replace("/4D2/","<153>",$alg); $alg = preg_replace("/4D/","<154>",$alg);
    
    /* --- 7xC: TWIZZLE -> CODE: [3] Tier twists (SiGN) --- */
    $alg = preg_replace("/6r'/","<301>",$alg); $alg = preg_replace("/6r2/","<302>",$alg); $alg = preg_replace("/6r/","<303>",$alg);
    $alg = preg_replace("/6l'/","<304>",$alg); $alg = preg_replace("/6l2/","<305>",$alg); $alg = preg_replace("/6l/","<306>",$alg);
    $alg = preg_replace("/6f'/","<307>",$alg); $alg = preg_replace("/6f2/","<308>",$alg); $alg = preg_replace("/6f/","<309>",$alg);
    $alg = preg_replace("/6b'/","<310>",$alg); $alg = preg_replace("/6b2/","<311>",$alg); $alg = preg_replace("/6b/","<312>",$alg);
    $alg = preg_replace("/6u'/","<313>",$alg); $alg = preg_replace("/6u2/","<314>",$alg); $alg = preg_replace("/6u/","<315>",$alg);
    $alg = preg_replace("/6d'/","<316>",$alg); $alg = preg_replace("/6d2/","<317>",$alg); $alg = preg_replace("/6d/","<318>",$alg);
    
    $alg = preg_replace("/5r'/","<319>",$alg); $alg = preg_replace("/5r2/","<320>",$alg); $alg = preg_replace("/5r/","<321>",$alg);
    $alg = preg_replace("/5l'/","<322>",$alg); $alg = preg_replace("/5l2/","<323>",$alg); $alg = preg_replace("/5l/","<324>",$alg);
    $alg = preg_replace("/5f'/","<325>",$alg); $alg = preg_replace("/5f2/","<326>",$alg); $alg = preg_replace("/5f/","<327>",$alg);
    $alg = preg_replace("/5b'/","<328>",$alg); $alg = preg_replace("/5b2/","<329>",$alg); $alg = preg_replace("/5b/","<330>",$alg);
    $alg = preg_replace("/5u'/","<331>",$alg); $alg = preg_replace("/5u2/","<332>",$alg); $alg = preg_replace("/5u/","<333>",$alg);
    $alg = preg_replace("/5d'/","<334>",$alg); $alg = preg_replace("/5d2/","<335>",$alg); $alg = preg_replace("/5d/","<336>",$alg);
    
    $alg = preg_replace("/4r'/","<337>",$alg); $alg = preg_replace("/4r2/","<338>",$alg); $alg = preg_replace("/4r/","<339>",$alg);
    $alg = preg_replace("/4l'/","<340>",$alg); $alg = preg_replace("/4l2/","<341>",$alg); $alg = preg_replace("/4l/","<342>",$alg);
    $alg = preg_replace("/4f'/","<343>",$alg); $alg = preg_replace("/4f2/","<344>",$alg); $alg = preg_replace("/4f/","<345>",$alg);
    $alg = preg_replace("/4b'/","<346>",$alg); $alg = preg_replace("/4b2/","<347>",$alg); $alg = preg_replace("/4b/","<348>",$alg);
    $alg = preg_replace("/4u'/","<349>",$alg); $alg = preg_replace("/4u2/","<350>",$alg); $alg = preg_replace("/4u/","<351>",$alg);
    $alg = preg_replace("/4d'/","<352>",$alg); $alg = preg_replace("/4d2/","<353>",$alg); $alg = preg_replace("/4d/","<354>",$alg);
    
    $alg = preg_replace("/3r'/","<355>",$alg); $alg = preg_replace("/3r2/","<356>",$alg); $alg = preg_replace("/3r/","<357>",$alg);
    $alg = preg_replace("/3l'/","<358>",$alg); $alg = preg_replace("/3l2/","<359>",$alg); $alg = preg_replace("/3l/","<360>",$alg);
    $alg = preg_replace("/3f'/","<361>",$alg); $alg = preg_replace("/3f2/","<362>",$alg); $alg = preg_replace("/3f/","<363>",$alg);
    $alg = preg_replace("/3b'/","<364>",$alg); $alg = preg_replace("/3b2/","<365>",$alg); $alg = preg_replace("/3b/","<366>",$alg);
    $alg = preg_replace("/3u'/","<367>",$alg); $alg = preg_replace("/3u2/","<368>",$alg); $alg = preg_replace("/3u/","<369>",$alg);
    $alg = preg_replace("/3d'/","<370>",$alg); $alg = preg_replace("/3d2/","<371>",$alg); $alg = preg_replace("/3d/","<372>",$alg);
    
    /* --- 7xC: TWIZZLE -> CODE: [3] Tier twists (WCA) --- */
    $alg = preg_replace("/Rw'/","<373>",$alg); $alg = preg_replace("/Rw2/","<374>",$alg); $alg = preg_replace("/Rw/","<375>",$alg);
    $alg = preg_replace("/Lw'/","<376>",$alg); $alg = preg_replace("/Lw2/","<377>",$alg); $alg = preg_replace("/Lw/","<378>",$alg);
    $alg = preg_replace("/Fw'/","<379>",$alg); $alg = preg_replace("/Fw2/","<380>",$alg); $alg = preg_replace("/Fw/","<381>",$alg);
    $alg = preg_replace("/Bw'/","<382>",$alg); $alg = preg_replace("/Bw2/","<383>",$alg); $alg = preg_replace("/Bw/","<384>",$alg);
    $alg = preg_replace("/Uw'/","<385>",$alg); $alg = preg_replace("/Uw2/","<386>",$alg); $alg = preg_replace("/Uw/","<387>",$alg);
    $alg = preg_replace("/Dw'/","<388>",$alg); $alg = preg_replace("/Dw2/","<389>",$alg); $alg = preg_replace("/Dw/","<390>",$alg);
    
    /* --- 7xC: TWIZZLE -> CODE: [7] Cube rotations --- */
    $alg = preg_replace("/Rv'/","<701>",$alg); $alg = preg_replace("/Rv2/","<702>",$alg); $alg = preg_replace("/Rv/","<703>",$alg);
    $alg = preg_replace("/Lv'/","<703>",$alg); $alg = preg_replace("/Lv2/","<702>",$alg); $alg = preg_replace("/Lv/","<701>",$alg);
    $alg = preg_replace("/Fv'/","<704>",$alg); $alg = preg_replace("/Fv2/","<705>",$alg); $alg = preg_replace("/Fv/","<706>",$alg);
    $alg = preg_replace("/Bv'/","<706>",$alg); $alg = preg_replace("/Bv2/","<705>",$alg); $alg = preg_replace("/Bv/","<704>",$alg);
    $alg = preg_replace("/Uv'/","<707>",$alg); $alg = preg_replace("/Uv2/","<708>",$alg); $alg = preg_replace("/Uv/","<709>",$alg);
    $alg = preg_replace("/Dv'/","<709>",$alg); $alg = preg_replace("/Dv2/","<708>",$alg); $alg = preg_replace("/Dv/","<707>",$alg);
    
    $alg = preg_replace("/x'/","<701>",$alg); $alg = preg_replace("/x2/","<702>",$alg); $alg = preg_replace("/x/","<703>",$alg);
    $alg = preg_replace("/z'/","<704>",$alg); $alg = preg_replace("/z2/","<705>",$alg); $alg = preg_replace("/z/","<706>",$alg);
    $alg = preg_replace("/y'/","<707>",$alg); $alg = preg_replace("/y2/","<708>",$alg); $alg = preg_replace("/y/","<709>",$alg);
    
    /* --- 7xC: TWIZZLE -> CODE: [9] Face twists --- */
    $alg = preg_replace("/R'/","<901>",$alg); $alg = preg_replace("/R2/","<902>",$alg); $alg = preg_replace("/R/","<903>",$alg);
    $alg = preg_replace("/L'/","<904>",$alg); $alg = preg_replace("/L2/","<905>",$alg); $alg = preg_replace("/L/","<906>",$alg);
    $alg = preg_replace("/F'/","<907>",$alg); $alg = preg_replace("/F2/","<908>",$alg); $alg = preg_replace("/F/","<909>",$alg);
    $alg = preg_replace("/B'/","<910>",$alg); $alg = preg_replace("/B2/","<911>",$alg); $alg = preg_replace("/B/","<912>",$alg);
    $alg = preg_replace("/U'/","<913>",$alg); $alg = preg_replace("/U2/","<914>",$alg); $alg = preg_replace("/U/","<915>",$alg);
    $alg = preg_replace("/D'/","<916>",$alg); $alg = preg_replace("/D2/","<917>",$alg); $alg = preg_replace("/D/","<918>",$alg);
    
    /* --- 7xC: TWIZZLE -> CODE: [3] Tier twists (SiGN) --- */
    $alg = preg_replace("/r'/","<373>",$alg); $alg = preg_replace("/r2/","<374>",$alg); $alg = preg_replace("/r/","<375>",$alg);
    $alg = preg_replace("/l'/","<376>",$alg); $alg = preg_replace("/l2/","<377>",$alg); $alg = preg_replace("/l/","<378>",$alg);
    $alg = preg_replace("/f'/","<379>",$alg); $alg = preg_replace("/f2/","<380>",$alg); $alg = preg_replace("/f/","<381>",$alg);
    $alg = preg_replace("/b'/","<382>",$alg); $alg = preg_replace("/b2/","<383>",$alg); $alg = preg_replace("/b/","<384>",$alg);
    $alg = preg_replace("/u'/","<385>",$alg); $alg = preg_replace("/u2/","<386>",$alg); $alg = preg_replace("/u/","<387>",$alg);
    $alg = preg_replace("/d'/","<388>",$alg); $alg = preg_replace("/d2/","<389>",$alg); $alg = preg_replace("/d/","<390>",$alg);
    
    /* ··································································································· */
    /* --- 7xC: CODE -> SSE: [6] Wide layer twists --- */
    $alg = preg_replace("/<601>/","WR'",$alg); $alg = preg_replace("/<602>/","WR2",$alg); $alg = preg_replace("/<603>/","WR",$alg);
    $alg = preg_replace("/<604>/","WL'",$alg); $alg = preg_replace("/<605>/","WL2",$alg); $alg = preg_replace("/<606>/","WL",$alg);
    $alg = preg_replace("/<607>/","WF'",$alg); $alg = preg_replace("/<608>/","WF2",$alg); $alg = preg_replace("/<609>/","WF",$alg);
    $alg = preg_replace("/<610>/","WB'",$alg); $alg = preg_replace("/<611>/","WB2",$alg); $alg = preg_replace("/<612>/","WB",$alg);
    $alg = preg_replace("/<613>/","WU'",$alg); $alg = preg_replace("/<614>/","WU2",$alg); $alg = preg_replace("/<615>/","WU",$alg);
    $alg = preg_replace("/<616>/","WD'",$alg); $alg = preg_replace("/<617>/","WD2",$alg); $alg = preg_replace("/<618>/","WD",$alg);
    
    /* --- 7xC: CODE -> SSE: [4] Void twists --- */
    $alg = preg_replace("/<401>/","VR'",$alg); $alg = preg_replace("/<402>/","VR2",$alg); $alg = preg_replace("/<403>/","VR",$alg);
    $alg = preg_replace("/<404>/","VL'",$alg); $alg = preg_replace("/<405>/","VL2",$alg); $alg = preg_replace("/<406>/","VL",$alg);
    $alg = preg_replace("/<407>/","VF'",$alg); $alg = preg_replace("/<408>/","VF2",$alg); $alg = preg_replace("/<409>/","VF",$alg);
    $alg = preg_replace("/<410>/","VB'",$alg); $alg = preg_replace("/<411>/","VB2",$alg); $alg = preg_replace("/<412>/","VB",$alg);
    $alg = preg_replace("/<413>/","VU'",$alg); $alg = preg_replace("/<414>/","VU2",$alg); $alg = preg_replace("/<415>/","VU",$alg);
    $alg = preg_replace("/<416>/","VD'",$alg); $alg = preg_replace("/<417>/","VD2",$alg); $alg = preg_replace("/<418>/","VD",$alg);
    
    $alg = preg_replace("/<419>/","V3R'",$alg); $alg = preg_replace("/<420>/","V3R2",$alg); $alg = preg_replace("/<421>/","V3R",$alg);
    $alg = preg_replace("/<422>/","V3L'",$alg); $alg = preg_replace("/<423>/","V3L2",$alg); $alg = preg_replace("/<424>/","V3L",$alg);
    $alg = preg_replace("/<425>/","V3F'",$alg); $alg = preg_replace("/<426>/","V3F2",$alg); $alg = preg_replace("/<427>/","V3F",$alg);
    $alg = preg_replace("/<428>/","V3B'",$alg); $alg = preg_replace("/<429>/","V3B2",$alg); $alg = preg_replace("/<430>/","V3B",$alg);
    $alg = preg_replace("/<431>/","V3U'",$alg); $alg = preg_replace("/<432>/","V3U2",$alg); $alg = preg_replace("/<433>/","V3U",$alg);
    $alg = preg_replace("/<434>/","V3D'",$alg); $alg = preg_replace("/<435>/","V3D2",$alg); $alg = preg_replace("/<436>/","V3D",$alg);
    
    $alg = preg_replace("/<437>/","V4R'",$alg); $alg = preg_replace("/<438>/","V4R2",$alg); $alg = preg_replace("/<439>/","V4R",$alg);
    $alg = preg_replace("/<440>/","V4L'",$alg); $alg = preg_replace("/<441>/","V4L2",$alg); $alg = preg_replace("/<442>/","V4L",$alg);
    $alg = preg_replace("/<443>/","V4F'",$alg); $alg = preg_replace("/<444>/","V4F2",$alg); $alg = preg_replace("/<445>/","V4F",$alg);
    $alg = preg_replace("/<446>/","V4B'",$alg); $alg = preg_replace("/<447>/","V4B2",$alg); $alg = preg_replace("/<448>/","V4B",$alg);
    $alg = preg_replace("/<449>/","V4U'",$alg); $alg = preg_replace("/<450>/","V4U2",$alg); $alg = preg_replace("/<451>/","V4U",$alg);
    $alg = preg_replace("/<452>/","V4D'",$alg); $alg = preg_replace("/<453>/","V4D2",$alg); $alg = preg_replace("/<454>/","V4D",$alg);
    
    /* --- 7xC: CODE -> SSE: [5] Mid-layer twists --- */
    $alg = preg_replace("/<501>/","M3R'",$alg); $alg = preg_replace("/<502>/","M3R2",$alg); $alg = preg_replace("/<503>/","M3R",$alg);
    $alg = preg_replace("/<504>/","M3L'",$alg); $alg = preg_replace("/<505>/","M3L2",$alg); $alg = preg_replace("/<506>/","M3L",$alg);
    $alg = preg_replace("/<507>/","M3F'",$alg); $alg = preg_replace("/<508>/","M3F2",$alg); $alg = preg_replace("/<509>/","M3F",$alg);
    $alg = preg_replace("/<510>/","M3B'",$alg); $alg = preg_replace("/<511>/","M3B2",$alg); $alg = preg_replace("/<512>/","M3B",$alg);
    $alg = preg_replace("/<513>/","M3U'",$alg); $alg = preg_replace("/<514>/","M3U2",$alg); $alg = preg_replace("/<515>/","M3U",$alg);
    $alg = preg_replace("/<516>/","M3D'",$alg); $alg = preg_replace("/<517>/","M3D2",$alg); $alg = preg_replace("/<518>/","M3D",$alg);
    
    /* --- 7xC: CODE -> SSE: [1] Numbered layer twists, [5] Mid-layer twists --- */
    $alg = preg_replace("/<101>/","NR'",$alg); $alg = preg_replace("/<102>/","NR2",$alg); $alg = preg_replace("/<103>/","NR",$alg);
    $alg = preg_replace("/<104>/","NL'",$alg); $alg = preg_replace("/<105>/","NL2",$alg); $alg = preg_replace("/<106>/","NL",$alg);
    $alg = preg_replace("/<107>/","NF'",$alg); $alg = preg_replace("/<108>/","NF2",$alg); $alg = preg_replace("/<109>/","NF",$alg);
    $alg = preg_replace("/<110>/","NB'",$alg); $alg = preg_replace("/<111>/","NB2",$alg); $alg = preg_replace("/<112>/","NB",$alg);
    $alg = preg_replace("/<113>/","NU'",$alg); $alg = preg_replace("/<114>/","NU2",$alg); $alg = preg_replace("/<115>/","NU",$alg);
    $alg = preg_replace("/<116>/","ND'",$alg); $alg = preg_replace("/<117>/","ND2",$alg); $alg = preg_replace("/<118>/","ND",$alg);
    
    $alg = preg_replace("/<119>/","N3R'",$alg); $alg = preg_replace("/<120>/","N3R2",$alg); $alg = preg_replace("/<121>/","N3R",$alg);
    $alg = preg_replace("/<122>/","N3L'",$alg); $alg = preg_replace("/<123>/","N3L2",$alg); $alg = preg_replace("/<124>/","N3L",$alg);
    $alg = preg_replace("/<125>/","N3F'",$alg); $alg = preg_replace("/<126>/","N3F2",$alg); $alg = preg_replace("/<127>/","N3F",$alg);
    $alg = preg_replace("/<128>/","N3B'",$alg); $alg = preg_replace("/<129>/","N3B2",$alg); $alg = preg_replace("/<130>/","N3B",$alg);
    $alg = preg_replace("/<131>/","N3U'",$alg); $alg = preg_replace("/<132>/","N3U2",$alg); $alg = preg_replace("/<133>/","N3U",$alg);
    $alg = preg_replace("/<134>/","N3D'",$alg); $alg = preg_replace("/<135>/","N3D2",$alg); $alg = preg_replace("/<136>/","N3D",$alg);
    
    $alg = preg_replace("/<137>/","MR'",$alg); $alg = preg_replace("/<138>/","MR2",$alg); $alg = preg_replace("/<139>/","MR",$alg);
    $alg = preg_replace("/<140>/","ML'",$alg); $alg = preg_replace("/<141>/","ML2",$alg); $alg = preg_replace("/<142>/","ML",$alg);
    $alg = preg_replace("/<143>/","MF'",$alg); $alg = preg_replace("/<144>/","MF2",$alg); $alg = preg_replace("/<145>/","MF",$alg);
    $alg = preg_replace("/<146>/","MB'",$alg); $alg = preg_replace("/<147>/","MB2",$alg); $alg = preg_replace("/<148>/","MB",$alg);
    $alg = preg_replace("/<149>/","MU'",$alg); $alg = preg_replace("/<150>/","MU2",$alg); $alg = preg_replace("/<151>/","MU",$alg);
    $alg = preg_replace("/<152>/","MD'",$alg); $alg = preg_replace("/<153>/","MD2",$alg); $alg = preg_replace("/<154>/","MD",$alg);
    
    /* --- 7xC: CODE -> SSE: [3] Tier twists --- */
    $alg = preg_replace("/<301>/","T6R'",$alg); $alg = preg_replace("/<302>/","T6R2",$alg); $alg = preg_replace("/<303>/","T6R",$alg);
    $alg = preg_replace("/<304>/","T6L'",$alg); $alg = preg_replace("/<305>/","T6L2",$alg); $alg = preg_replace("/<306>/","T6L",$alg);
    $alg = preg_replace("/<307>/","T6F'",$alg); $alg = preg_replace("/<308>/","T6F2",$alg); $alg = preg_replace("/<309>/","T6F",$alg);
    $alg = preg_replace("/<310>/","T6B'",$alg); $alg = preg_replace("/<311>/","T6B2",$alg); $alg = preg_replace("/<312>/","T6B",$alg);
    $alg = preg_replace("/<313>/","T6U'",$alg); $alg = preg_replace("/<314>/","T6U2",$alg); $alg = preg_replace("/<315>/","T6U",$alg);
    $alg = preg_replace("/<316>/","T6D'",$alg); $alg = preg_replace("/<317>/","T6D2",$alg); $alg = preg_replace("/<318>/","T6D",$alg);
    
    $alg = preg_replace("/<319>/","T5R'",$alg); $alg = preg_replace("/<320>/","T5R2",$alg); $alg = preg_replace("/<321>/","T5R",$alg);
    $alg = preg_replace("/<322>/","T5L'",$alg); $alg = preg_replace("/<323>/","T5L2",$alg); $alg = preg_replace("/<324>/","T5L",$alg);
    $alg = preg_replace("/<325>/","T5F'",$alg); $alg = preg_replace("/<326>/","T5F2",$alg); $alg = preg_replace("/<327>/","T5F",$alg);
    $alg = preg_replace("/<328>/","T5B'",$alg); $alg = preg_replace("/<329>/","T5B2",$alg); $alg = preg_replace("/<330>/","T5B",$alg);
    $alg = preg_replace("/<331>/","T5U'",$alg); $alg = preg_replace("/<332>/","T5U2",$alg); $alg = preg_replace("/<333>/","T5U",$alg);
    $alg = preg_replace("/<334>/","T5D'",$alg); $alg = preg_replace("/<335>/","T5D2",$alg); $alg = preg_replace("/<336>/","T5D",$alg);
    
    $alg = preg_replace("/<337>/","T4R'",$alg); $alg = preg_replace("/<338>/","T4R2",$alg); $alg = preg_replace("/<339>/","T4R",$alg);
    $alg = preg_replace("/<340>/","T4L'",$alg); $alg = preg_replace("/<341>/","T4L2",$alg); $alg = preg_replace("/<342>/","T4L",$alg);
    $alg = preg_replace("/<343>/","T4F'",$alg); $alg = preg_replace("/<344>/","T4F2",$alg); $alg = preg_replace("/<345>/","T4F",$alg);
    $alg = preg_replace("/<346>/","T4B'",$alg); $alg = preg_replace("/<347>/","T4B2",$alg); $alg = preg_replace("/<348>/","T4B",$alg);
    $alg = preg_replace("/<349>/","T4U'",$alg); $alg = preg_replace("/<350>/","T4U2",$alg); $alg = preg_replace("/<351>/","T4U",$alg);
    $alg = preg_replace("/<352>/","T4D'",$alg); $alg = preg_replace("/<353>/","T4D2",$alg); $alg = preg_replace("/<354>/","T4D",$alg);
    
    $alg = preg_replace("/<355>/","T3R'",$alg); $alg = preg_replace("/<356>/","T3R2",$alg); $alg = preg_replace("/<357>/","T3R",$alg);
    $alg = preg_replace("/<358>/","T3L'",$alg); $alg = preg_replace("/<359>/","T3L2",$alg); $alg = preg_replace("/<360>/","T3L",$alg);
    $alg = preg_replace("/<361>/","T3F'",$alg); $alg = preg_replace("/<362>/","T3F2",$alg); $alg = preg_replace("/<363>/","T3F",$alg);
    $alg = preg_replace("/<364>/","T3B'",$alg); $alg = preg_replace("/<365>/","T3B2",$alg); $alg = preg_replace("/<366>/","T3B",$alg);
    $alg = preg_replace("/<367>/","T3U'",$alg); $alg = preg_replace("/<368>/","T3U2",$alg); $alg = preg_replace("/<369>/","T3U",$alg);
    $alg = preg_replace("/<370>/","T3D'",$alg); $alg = preg_replace("/<371>/","T3D2",$alg); $alg = preg_replace("/<372>/","T3D",$alg);
    
    /* --- 7xC: CODE -> SSE: [7] Cube rotations --- */
    $alg = preg_replace("/<701>/","CR'",$alg); $alg = preg_replace("/<702>/","CR2",$alg); $alg = preg_replace("/<703>/","CR",$alg);
    $alg = preg_replace("/<704>/","CF'",$alg); $alg = preg_replace("/<705>/","CF2",$alg); $alg = preg_replace("/<706>/","CF",$alg);
    $alg = preg_replace("/<707>/","CU'",$alg); $alg = preg_replace("/<708>/","CU2",$alg); $alg = preg_replace("/<709>/","CU",$alg);
    
    /* --- 7xC: CODE -> SSE: [9] Face twists --- */
    $alg = preg_replace("/<901>/","R'",$alg); $alg = preg_replace("/<902>/","R2",$alg); $alg = preg_replace("/<903>/","R",$alg);
    $alg = preg_replace("/<904>/","L'",$alg); $alg = preg_replace("/<905>/","L2",$alg); $alg = preg_replace("/<906>/","L",$alg);
    $alg = preg_replace("/<907>/","F'",$alg); $alg = preg_replace("/<908>/","F2",$alg); $alg = preg_replace("/<909>/","F",$alg);
    $alg = preg_replace("/<910>/","B'",$alg); $alg = preg_replace("/<911>/","B2",$alg); $alg = preg_replace("/<912>/","B",$alg);
    $alg = preg_replace("/<913>/","U'",$alg); $alg = preg_replace("/<914>/","U2",$alg); $alg = preg_replace("/<915>/","U",$alg);
    $alg = preg_replace("/<916>/","D'",$alg); $alg = preg_replace("/<917>/","D2",$alg); $alg = preg_replace("/<918>/","D",$alg);
    
    /* --- 7xC: CODE -> SSE: [3] Tier twists --- */
    $alg = preg_replace("/<373>/","TR'",$alg); $alg = preg_replace("/<374>/","TR2",$alg); $alg = preg_replace("/<375>/","TR",$alg);
    $alg = preg_replace("/<376>/","TL'",$alg); $alg = preg_replace("/<377>/","TL2",$alg); $alg = preg_replace("/<378>/","TL",$alg);
    $alg = preg_replace("/<379>/","TF'",$alg); $alg = preg_replace("/<380>/","TF2",$alg); $alg = preg_replace("/<381>/","TF",$alg);
    $alg = preg_replace("/<382>/","TB'",$alg); $alg = preg_replace("/<383>/","TB2",$alg); $alg = preg_replace("/<384>/","TB",$alg);
    $alg = preg_replace("/<385>/","TU'",$alg); $alg = preg_replace("/<386>/","TU2",$alg); $alg = preg_replace("/<387>/","TU",$alg);
    $alg = preg_replace("/<388>/","TD'",$alg); $alg = preg_replace("/<389>/","TD2",$alg); $alg = preg_replace("/<390>/","TD",$alg);
    
    return $alg;
  }
  
  
  
  
  /* 
  ---------------------------------------------------------------------------------------------------
  * alg3xP_SseToTwizzle($alg)
  * 
  * Converts 3x3 Pyraminx SSE algorithms into TWIZZLE notation.
  * 
  * Parameter: $alg (STRING): The algorithm.
  * 
  * Return: STRING.
  ---------------------------------------------------------------------------------------------------
  */
  function alg3xP_SseToTwizzle($alg) {
    /* --- 3xP: Preferences --- */
    $useMarkers = false; // 01.04.2021: Unfortunately Twizzle Explorer doesn't handle Markers correctly!
    
    /* --- 3xP: Marker --- */
    if ($useMarkers != true) {
      $alg = str_replace("·","",$alg); $alg = str_replace(".","",$alg); // Remove Markers!
    } else {
      $alg = str_replace("·",".",$alg);
    }
    
    /* ··································································································· */
    /* --- 3xP: SSE -> CODE: [5] Mid-layer [1] (Numbered layer) [6] (Wide) twists --- */
    $alg = preg_replace("/MU'/","<101>",$alg); $alg = preg_replace("/MU-/","<101>",$alg);   $alg = preg_replace("/MU/","<102>",$alg);
    $alg = preg_replace("/MR'/","<103>",$alg); $alg = preg_replace("/MR-/","<103>",$alg);   $alg = preg_replace("/MR/","<104>",$alg);
    $alg = preg_replace("/ML'/","<105>",$alg); $alg = preg_replace("/ML-/","<105>",$alg);   $alg = preg_replace("/ML/","<106>",$alg);
    $alg = preg_replace("/MB'/","<107>",$alg); $alg = preg_replace("/MB-/","<107>",$alg);   $alg = preg_replace("/MB/","<108>",$alg);
    
    $alg = preg_replace("/NU'/","<101>",$alg); $alg = preg_replace("/NU-/","<101>",$alg);   $alg = preg_replace("/NU/","<102>",$alg);
    $alg = preg_replace("/NR'/","<103>",$alg); $alg = preg_replace("/NR-/","<103>",$alg);   $alg = preg_replace("/NR/","<104>",$alg);
    $alg = preg_replace("/NL'/","<105>",$alg); $alg = preg_replace("/NL-/","<105>",$alg);   $alg = preg_replace("/NL/","<106>",$alg);
    $alg = preg_replace("/NB'/","<107>",$alg); $alg = preg_replace("/NB-/","<107>",$alg);   $alg = preg_replace("/NB/","<108>",$alg);
    
    $alg = preg_replace("/WU'/","<101>",$alg); $alg = preg_replace("/WU-/","<101>",$alg);   $alg = preg_replace("/WU/","<102>",$alg);
    $alg = preg_replace("/WR'/","<103>",$alg); $alg = preg_replace("/WR-/","<103>",$alg);   $alg = preg_replace("/WR/","<104>",$alg);
    $alg = preg_replace("/WL'/","<105>",$alg); $alg = preg_replace("/WL-/","<105>",$alg);   $alg = preg_replace("/WL/","<106>",$alg);
    $alg = preg_replace("/WB'/","<107>",$alg); $alg = preg_replace("/WB-/","<107>",$alg);   $alg = preg_replace("/WB/","<108>",$alg);
    
    /* --- 3xP: SSE -> CODE: [3] Tier twists --- */
    $alg = preg_replace("/TU'/","<301>",$alg); $alg = preg_replace("/TU-/","<301>",$alg);   $alg = preg_replace("/TU/","<302>",$alg);
    $alg = preg_replace("/TR'/","<303>",$alg); $alg = preg_replace("/TR-/","<303>",$alg);   $alg = preg_replace("/TR/","<304>",$alg);
    $alg = preg_replace("/TL'/","<305>",$alg); $alg = preg_replace("/TL-/","<305>",$alg);   $alg = preg_replace("/TL/","<306>",$alg);
    $alg = preg_replace("/TB'/","<307>",$alg); $alg = preg_replace("/TB-/","<307>",$alg);   $alg = preg_replace("/TB/","<308>",$alg);
    
    /* --- 3xP: SSE -> CODE: [7] Pyramid rotations --- */
    $alg = preg_replace("/CU'/","<701>",$alg); $alg = preg_replace("/CU-/","<701>",$alg);   $alg = preg_replace("/CU/","<702>",$alg);
    $alg = preg_replace("/CR'/","<703>",$alg); $alg = preg_replace("/CR-/","<703>",$alg);   $alg = preg_replace("/CR/","<704>",$alg);
    $alg = preg_replace("/CL'/","<705>",$alg); $alg = preg_replace("/CL-/","<705>",$alg);   $alg = preg_replace("/CL/","<706>",$alg);
    $alg = preg_replace("/CB'/","<707>",$alg); $alg = preg_replace("/CB-/","<707>",$alg);   $alg = preg_replace("/CB/","<708>",$alg);
    
    /* --- 3xP: SSE -> CODE: [9] Corner twists --- */
    $alg = preg_replace("/U'/","<901>",$alg); $alg = preg_replace("/U-/","<901>",$alg);   $alg = preg_replace("/U/","<902>",$alg);
    $alg = preg_replace("/R'/","<903>",$alg); $alg = preg_replace("/R-/","<903>",$alg);   $alg = preg_replace("/R/","<904>",$alg);
    $alg = preg_replace("/L'/","<905>",$alg); $alg = preg_replace("/L-/","<905>",$alg);   $alg = preg_replace("/L/","<906>",$alg);
    $alg = preg_replace("/B'/","<907>",$alg); $alg = preg_replace("/B-/","<907>",$alg);   $alg = preg_replace("/B/","<908>",$alg);
    
    /* ··································································································· */
    /* --- 3xP: CODE -> TWIZZLE: [5] Mid-layer [1] (Numbered layer) [6] (Wide) twists --- */
    $alg = preg_replace("/<101>/","2u'",$alg); $alg = preg_replace("/<102>/","2u",$alg);
    $alg = preg_replace("/<103>/","2r'",$alg); $alg = preg_replace("/<104>/","2r",$alg);
    $alg = preg_replace("/<105>/","2l'",$alg); $alg = preg_replace("/<106>/","2l",$alg);
    $alg = preg_replace("/<107>/","2b'",$alg); $alg = preg_replace("/<108>/","2b",$alg);
    
    /* --- 3xP: CODE -> TWIZZLE: [3] Tier twists --- */
    $alg = preg_replace("/<301>/","U'",$alg); $alg = preg_replace("/<302>/","U",$alg);
    $alg = preg_replace("/<303>/","R'",$alg); $alg = preg_replace("/<304>/","R",$alg);
    $alg = preg_replace("/<305>/","L'",$alg); $alg = preg_replace("/<306>/","L",$alg);
    $alg = preg_replace("/<307>/","B'",$alg); $alg = preg_replace("/<308>/","B",$alg);
    
    /* --- 3xP: CODE -> TWIZZLE: [7] Pyramid rotations --- */
    $alg = preg_replace("/<701>/","Uv'",$alg); $alg = preg_replace("/<702>/","Uv",$alg);
    $alg = preg_replace("/<703>/","Rv'",$alg); $alg = preg_replace("/<704>/","Rv",$alg);
    $alg = preg_replace("/<705>/","Lv'",$alg); $alg = preg_replace("/<706>/","Lv",$alg);
    $alg = preg_replace("/<707>/","Bv'",$alg); $alg = preg_replace("/<708>/","Bv",$alg);
    
    /* --- 3xP: CODE -> TWIZZLE: [9] Corner twists --- */
    $alg = preg_replace("/<901>/","u'",$alg); $alg = preg_replace("/<902>/","u",$alg);
    $alg = preg_replace("/<903>/","r'",$alg); $alg = preg_replace("/<904>/","r",$alg);
    $alg = preg_replace("/<905>/","l'",$alg); $alg = preg_replace("/<906>/","l",$alg);
    $alg = preg_replace("/<907>/","b'",$alg); $alg = preg_replace("/<908>/","b",$alg);
    
    return $alg;
  }
  
  
  
  
  /* 
  ---------------------------------------------------------------------------------------------------
  * alg3xP_TwizzleToSse($alg)
  * 
  * Converts 3x3 Pyraminx TWIZZLE algorithms into SSE notation.
  * 
  * Parameter: $alg (STRING): The algorithm.
  * 
  * Return: STRING.
  ---------------------------------------------------------------------------------------------------
  */
  function alg3xP_TwizzleToSse($alg) {
    /* --- 3xP: Marker --- */
    $alg = str_replace(".","·",$alg);
    
    /* ··································································································· */
    /* --- 3xP: TWIZZLE -> CODE: [5] Mid-layer [1] (Numbered layer) [6] (Wide) twists --- */
    $alg = preg_replace("/2u'/","<101>",$alg); $alg = preg_replace("/2u/","<102>",$alg);
    $alg = preg_replace("/2r'/","<103>",$alg); $alg = preg_replace("/2r/","<104>",$alg);
    $alg = preg_replace("/2l'/","<105>",$alg); $alg = preg_replace("/2l/","<106>",$alg);
    $alg = preg_replace("/2b'/","<107>",$alg); $alg = preg_replace("/2b/","<108>",$alg);
    
    /* --- 3xP: TWIZZLE -> CODE: [8] Face twists --- */
    $alg = preg_replace("/3u'/","<801>",$alg); $alg = preg_replace("/3u/","<802>",$alg);
    $alg = preg_replace("/3r'/","<803>",$alg); $alg = preg_replace("/3r/","<804>",$alg);
    $alg = preg_replace("/3l'/","<805>",$alg); $alg = preg_replace("/3l/","<806>",$alg);
    $alg = preg_replace("/3b'/","<807>",$alg); $alg = preg_replace("/3b/","<808>",$alg);
    
    /* --- 3xP: TWIZZLE -> CODE: [3] Tier twists --- */
    $alg = preg_replace("/2U'/","<301>",$alg); $alg = preg_replace("/2U/","<302>",$alg);
    $alg = preg_replace("/2R'/","<303>",$alg); $alg = preg_replace("/2R/","<304>",$alg);
    $alg = preg_replace("/2L'/","<305>",$alg); $alg = preg_replace("/2L/","<306>",$alg);
    $alg = preg_replace("/2B'/","<307>",$alg); $alg = preg_replace("/2B/","<308>",$alg);
    
    /* --- 3xP: TWIZZLE -> CODE: [7] Pyramid rotations --- */
    $alg = preg_replace("/Uv'/","<701>",$alg); $alg = preg_replace("/Uv/","<702>",$alg);
    $alg = preg_replace("/Rv'/","<703>",$alg); $alg = preg_replace("/Rv/","<704>",$alg);
    $alg = preg_replace("/Lv'/","<705>",$alg); $alg = preg_replace("/Lv/","<706>",$alg);
    $alg = preg_replace("/Bv'/","<707>",$alg); $alg = preg_replace("/Bv/","<708>",$alg);
    
    /* --- 3xP: TWIZZLE -> CODE: [9] Corner twists --- */
    $alg = preg_replace("/u'/","<901>",$alg); $alg = preg_replace("/u/","<902>",$alg);
    $alg = preg_replace("/r'/","<903>",$alg); $alg = preg_replace("/r/","<904>",$alg);
    $alg = preg_replace("/l'/","<905>",$alg); $alg = preg_replace("/l/","<906>",$alg);
    $alg = preg_replace("/b'/","<907>",$alg); $alg = preg_replace("/b/","<908>",$alg);
    
    /* --- 3xP: TWIZZLE -> CODE: [3] Tier twists --- */
    $alg = preg_replace("/U'/","<301>",$alg); $alg = preg_replace("/U/","<302>",$alg);
    $alg = preg_replace("/R'/","<303>",$alg); $alg = preg_replace("/R/","<304>",$alg);
    $alg = preg_replace("/L'/","<305>",$alg); $alg = preg_replace("/L/","<306>",$alg);
    $alg = preg_replace("/B'/","<307>",$alg); $alg = preg_replace("/B/","<308>",$alg);
    
    /* ··································································································· */
    /* --- 3xP: CODE -> SSE: [5] Mid-layer [1] (Numbered layer) [6] (Wide) twists --- */
    $alg = preg_replace("/<101>/","MU'",$alg); $alg = preg_replace("/<102>/","MU",$alg);
    $alg = preg_replace("/<103>/","MR'",$alg); $alg = preg_replace("/<104>/","MR",$alg);
    $alg = preg_replace("/<105>/","ML'",$alg); $alg = preg_replace("/<106>/","ML",$alg);
    $alg = preg_replace("/<107>/","MB'",$alg); $alg = preg_replace("/<108>/","MB",$alg);
    
    /* --- 3xP: CODE -> SSE: [8] Face twists --- */
    $alg = preg_replace("/<801>/","TU CU'",$alg); $alg = preg_replace("/<802>/","TU' CU",$alg);
    $alg = preg_replace("/<803>/","TR CR'",$alg); $alg = preg_replace("/<804>/","TR' CR",$alg);
    $alg = preg_replace("/<805>/","TL CL'",$alg); $alg = preg_replace("/<806>/","TL' CL",$alg);
    $alg = preg_replace("/<807>/","TB CB'",$alg); $alg = preg_replace("/<808>/","TB' CB",$alg);
    
    /* --- 3xP: CODE -> SSE: [3] Tier twists --- */
    $alg = preg_replace("/<301>/","TU'",$alg); $alg = preg_replace("/<302>/","TU",$alg);
    $alg = preg_replace("/<303>/","TR'",$alg); $alg = preg_replace("/<304>/","TR",$alg);
    $alg = preg_replace("/<305>/","TL'",$alg); $alg = preg_replace("/<306>/","TL",$alg);
    $alg = preg_replace("/<307>/","TB'",$alg); $alg = preg_replace("/<308>/","TB",$alg);
    
    /* --- 3xP: CODE -> SSE: [7] Pyramid rotations --- */
    $alg = preg_replace("/<701>/","CU'",$alg); $alg = preg_replace("/<702>/","CU",$alg);
    $alg = preg_replace("/<703>/","CR'",$alg); $alg = preg_replace("/<704>/","CR",$alg);
    $alg = preg_replace("/<705>/","CL'",$alg); $alg = preg_replace("/<706>/","CL",$alg);
    $alg = preg_replace("/<707>/","CB'",$alg); $alg = preg_replace("/<708>/","CB",$alg);
    
    /* --- 3xP: CODE -> SSE: [9] Corner twists --- */
    $alg = preg_replace("/<901>/","U'",$alg); $alg = preg_replace("/<902>/","U",$alg);
    $alg = preg_replace("/<903>/","R'",$alg); $alg = preg_replace("/<904>/","R",$alg);
    $alg = preg_replace("/<905>/","L'",$alg); $alg = preg_replace("/<906>/","L",$alg);
    $alg = preg_replace("/<907>/","B'",$alg); $alg = preg_replace("/<908>/","B",$alg);
    
    return $alg;
  }
  
  
  
  
  /* 
  ---------------------------------------------------------------------------------------------------
  * alg4xP_SseToTwizzle($alg)
  * 
  * Converts 4x4 Master Pyraminx SSE algorithms into TWIZZLE notation.
  * 
  * Parameter: $alg (STRING): The algorithm.
  * 
  * Return: STRING.
  ---------------------------------------------------------------------------------------------------
  */
  function alg4xP_SseToTwizzle($alg) {
    /* --- 4xP: Preferences --- */
    $useMarkers = false; // 01.04.2021: Unfortunately Twizzle Explorer doesn't handle Markers correctly!
    
    /* --- 4xP: Marker --- */
    if ($useMarkers != true) {
      $alg = str_replace("·","",$alg); $alg = str_replace(".","",$alg); // Remove Markers!
    } else {
      $alg = str_replace("·",".",$alg);
    }
    
    /* ··································································································· */
    /* --- 4xP: SSE -> CODE: [1] Wide-layer twists --- */
    $alg = preg_replace("/WU'/","<101>",$alg); $alg = preg_replace("/WU-/","<101>",$alg);   $alg = preg_replace("/WU/","<102>",$alg);
    $alg = preg_replace("/WR'/","<103>",$alg); $alg = preg_replace("/WR-/","<103>",$alg);   $alg = preg_replace("/WR/","<104>",$alg);
    $alg = preg_replace("/WL'/","<105>",$alg); $alg = preg_replace("/WL-/","<105>",$alg);   $alg = preg_replace("/WL/","<106>",$alg);
    $alg = preg_replace("/WB'/","<107>",$alg); $alg = preg_replace("/WB-/","<107>",$alg);   $alg = preg_replace("/WB/","<108>",$alg);
    
    $alg = preg_replace("/N2-3U'/","<101>",$alg); $alg = preg_replace("/N2-3U-/","<101>",$alg);   $alg = preg_replace("/N2-3U/","<102>",$alg);
    $alg = preg_replace("/N2-3R'/","<103>",$alg); $alg = preg_replace("/N2-3R-/","<103>",$alg);   $alg = preg_replace("/N2-3R/","<104>",$alg);
    $alg = preg_replace("/N2-3L'/","<105>",$alg); $alg = preg_replace("/N2-3L-/","<105>",$alg);   $alg = preg_replace("/N2-3L/","<106>",$alg);
    $alg = preg_replace("/N2-3B'/","<107>",$alg); $alg = preg_replace("/N2-3B-/","<107>",$alg);   $alg = preg_replace("/N2-3B/","<108>",$alg);
    
    $alg = preg_replace("/VU'/","<101>",$alg); $alg = preg_replace("/VU-/","<101>",$alg);   $alg = preg_replace("/VU/","<102>",$alg);
    $alg = preg_replace("/VR'/","<103>",$alg); $alg = preg_replace("/VR-/","<103>",$alg);   $alg = preg_replace("/VR/","<104>",$alg);
    $alg = preg_replace("/VL'/","<105>",$alg); $alg = preg_replace("/VL-/","<105>",$alg);   $alg = preg_replace("/VL/","<106>",$alg);
    $alg = preg_replace("/VB'/","<107>",$alg); $alg = preg_replace("/VB-/","<107>",$alg);   $alg = preg_replace("/VB/","<108>",$alg);
    
    /* --- 4xP: SSE -> CODE: [2] Numbered layer twists --- */
    $alg = preg_replace("/N3U'/","<201>",$alg); $alg = preg_replace("/N3U-/","<201>",$alg);   $alg = preg_replace("/N3U/","<202>",$alg);
    $alg = preg_replace("/N3R'/","<203>",$alg); $alg = preg_replace("/N3R-/","<203>",$alg);   $alg = preg_replace("/N3R/","<204>",$alg);
    $alg = preg_replace("/N3L'/","<205>",$alg); $alg = preg_replace("/N3L-/","<205>",$alg);   $alg = preg_replace("/N3L/","<206>",$alg);
    $alg = preg_replace("/N3B'/","<207>",$alg); $alg = preg_replace("/N3B-/","<207>",$alg);   $alg = preg_replace("/N3B/","<208>",$alg);
    
    $alg = preg_replace("/NU'/","<209>",$alg); $alg = preg_replace("/NU-/","<209>",$alg);   $alg = preg_replace("/NU/","<210>",$alg);
    $alg = preg_replace("/NR'/","<211>",$alg); $alg = preg_replace("/NR-/","<211>",$alg);   $alg = preg_replace("/NR/","<212>",$alg);
    $alg = preg_replace("/NL'/","<213>",$alg); $alg = preg_replace("/NL-/","<213>",$alg);   $alg = preg_replace("/NL/","<214>",$alg);
    $alg = preg_replace("/NB'/","<215>",$alg); $alg = preg_replace("/NB-/","<215>",$alg);   $alg = preg_replace("/NB/","<216>",$alg);
    
    /* --- 4xP: SSE -> CODE: [3] Tier twists --- */
    $alg = preg_replace("/T3U'/","<301>",$alg); $alg = preg_replace("/T3U-/","<301>",$alg);   $alg = preg_replace("/T3U/","<302>",$alg);
    $alg = preg_replace("/T3R'/","<303>",$alg); $alg = preg_replace("/T3R-/","<303>",$alg);   $alg = preg_replace("/T3R/","<304>",$alg);
    $alg = preg_replace("/T3L'/","<305>",$alg); $alg = preg_replace("/T3L-/","<305>",$alg);   $alg = preg_replace("/T3L/","<306>",$alg);
    $alg = preg_replace("/T3B'/","<307>",$alg); $alg = preg_replace("/T3B-/","<307>",$alg);   $alg = preg_replace("/T3B/","<308>",$alg);
    
    $alg = preg_replace("/TU'/","<309>",$alg); $alg = preg_replace("/TU-/","<309>",$alg);   $alg = preg_replace("/TU/","<310>",$alg);
    $alg = preg_replace("/TR'/","<311>",$alg); $alg = preg_replace("/TR-/","<311>",$alg);   $alg = preg_replace("/TR/","<312>",$alg);
    $alg = preg_replace("/TL'/","<313>",$alg); $alg = preg_replace("/TL-/","<313>",$alg);   $alg = preg_replace("/TL/","<314>",$alg);
    $alg = preg_replace("/TB'/","<315>",$alg); $alg = preg_replace("/TB-/","<315>",$alg);   $alg = preg_replace("/TB/","<316>",$alg);
    
    /* --- 4xP: SSE -> CODE: [7] Pyramid rotations --- */
    $alg = preg_replace("/CU'/","<701>",$alg); $alg = preg_replace("/CU-/","<701>",$alg);   $alg = preg_replace("/CU/","<702>",$alg);
    $alg = preg_replace("/CR'/","<703>",$alg); $alg = preg_replace("/CR-/","<703>",$alg);   $alg = preg_replace("/CR/","<704>",$alg);
    $alg = preg_replace("/CL'/","<705>",$alg); $alg = preg_replace("/CL-/","<705>",$alg);   $alg = preg_replace("/CL/","<706>",$alg);
    $alg = preg_replace("/CB'/","<707>",$alg); $alg = preg_replace("/CB-/","<707>",$alg);   $alg = preg_replace("/CB/","<708>",$alg);
    
    /* --- 4xP: SSE -> CODE: [9] Corner twists --- */
    $alg = preg_replace("/U'/","<901>",$alg); $alg = preg_replace("/U-/","<901>",$alg);   $alg = preg_replace("/U/","<902>",$alg);
    $alg = preg_replace("/R'/","<903>",$alg); $alg = preg_replace("/R-/","<903>",$alg);   $alg = preg_replace("/R/","<904>",$alg);
    $alg = preg_replace("/L'/","<905>",$alg); $alg = preg_replace("/L-/","<905>",$alg);   $alg = preg_replace("/L/","<906>",$alg);
    $alg = preg_replace("/B'/","<907>",$alg); $alg = preg_replace("/B-/","<907>",$alg);   $alg = preg_replace("/B/","<908>",$alg);
    
    /* ··································································································· */
    /* --- 4xP: CODE -> TWIZZLE: [1] Wide-layer twists --- */
    $alg = preg_replace("/<101>/","2-3U'",$alg); $alg = preg_replace("/<102>/","2-3U",$alg);
    $alg = preg_replace("/<103>/","2-3R'",$alg); $alg = preg_replace("/<104>/","2-3R",$alg);
    $alg = preg_replace("/<105>/","2-3L'",$alg); $alg = preg_replace("/<106>/","2-3L",$alg);
    $alg = preg_replace("/<107>/","2-3B'",$alg); $alg = preg_replace("/<108>/","2-3B",$alg);
    
    /* --- 4xP: CODE -> TWIZZLE: [2] Numbered layer twists --- */
    $alg = preg_replace("/<201>/","3U'",$alg); $alg = preg_replace("/<202>/","3U",$alg);
    $alg = preg_replace("/<203>/","3R'",$alg); $alg = preg_replace("/<204>/","3R",$alg);
    $alg = preg_replace("/<205>/","3L'",$alg); $alg = preg_replace("/<206>/","3L",$alg);
    $alg = preg_replace("/<207>/","3B'",$alg); $alg = preg_replace("/<208>/","3B",$alg);
    
    $alg = preg_replace("/<209>/","2U'",$alg); $alg = preg_replace("/<210>/","2U",$alg);
    $alg = preg_replace("/<211>/","2R'",$alg); $alg = preg_replace("/<212>/","2R",$alg);
    $alg = preg_replace("/<213>/","2L'",$alg); $alg = preg_replace("/<214>/","2L",$alg);
    $alg = preg_replace("/<215>/","2B'",$alg); $alg = preg_replace("/<216>/","2B",$alg);
    
    /* --- 4xP: CODE -> TWIZZLE: [3] Tier twists --- */
    $alg = preg_replace("/<301>/","3u'",$alg); $alg = preg_replace("/<302>/","3u",$alg);
    $alg = preg_replace("/<303>/","3r'",$alg); $alg = preg_replace("/<304>/","3r",$alg);
    $alg = preg_replace("/<305>/","3l'",$alg); $alg = preg_replace("/<306>/","3l",$alg);
    $alg = preg_replace("/<307>/","3b'",$alg); $alg = preg_replace("/<308>/","3b",$alg);
    
    $alg = preg_replace("/<309>/","u'",$alg); $alg = preg_replace("/<310>/","u",$alg);
    $alg = preg_replace("/<311>/","r'",$alg); $alg = preg_replace("/<312>/","r",$alg);
    $alg = preg_replace("/<313>/","l'",$alg); $alg = preg_replace("/<314>/","l",$alg);
    $alg = preg_replace("/<315>/","b'",$alg); $alg = preg_replace("/<316>/","b",$alg);
    
    /* --- 4xP: CODE -> TWIZZLE: [7] Pyramid rotations --- */
    $alg = preg_replace("/<701>/","Uv'",$alg); $alg = preg_replace("/<702>/","Uv",$alg);
    $alg = preg_replace("/<703>/","Rv'",$alg); $alg = preg_replace("/<704>/","Rv",$alg);
    $alg = preg_replace("/<705>/","Lv'",$alg); $alg = preg_replace("/<706>/","Lv",$alg);
    $alg = preg_replace("/<707>/","Bv'",$alg); $alg = preg_replace("/<708>/","Bv",$alg);
    
    /* --- 4xP: CODE -> TWIZZLE: [9] Corner twists --- */
    $alg = preg_replace("/<901>/","U'",$alg); $alg = preg_replace("/<902>/","U",$alg);
    $alg = preg_replace("/<903>/","R'",$alg); $alg = preg_replace("/<904>/","U",$alg);
    $alg = preg_replace("/<905>/","L'",$alg); $alg = preg_replace("/<906>/","L",$alg);
    $alg = preg_replace("/<907>/","B'",$alg); $alg = preg_replace("/<908>/","B",$alg);
    
    return $alg;
  }
  
  
  
  
  /* 
  ---------------------------------------------------------------------------------------------------
  * alg4xP_TwizzleToSse($alg)
  * 
  * Converts 4x4 Master Pyraminx TWIZZLE algorithms into SSE notation.
  * 
  * Parameter: $alg (STRING): The algorithm.
  * 
  * Return: STRING.
  ---------------------------------------------------------------------------------------------------
  */
  function alg4xP_TwizzleToSse($alg) {
    /* --- 4xP: Marker --- */
    $alg = str_replace(".","·",$alg);
    
    /* ··································································································· */
    /* --- 4xP: TWIZZLE -> CODE: [1] Wide-layer twists --- */
    $alg = preg_replace("/2-3U'/","<101>",$alg); $alg = preg_replace("/2-3U/","<102>",$alg);
    $alg = preg_replace("/2-3R'/","<103>",$alg); $alg = preg_replace("/2-3R/","<104>",$alg);
    $alg = preg_replace("/2-3L'/","<105>",$alg); $alg = preg_replace("/2-3L/","<106>",$alg);
    $alg = preg_replace("/2-3B'/","<107>",$alg); $alg = preg_replace("/2-3B/","<108>",$alg);
    
    /* --- 4xP: TWIZZLE -> CODE: [8] Face twists --- */
    $alg = preg_replace("/4U'/","<801>",$alg); $alg = preg_replace("/4U/","<802>",$alg);
    $alg = preg_replace("/4R'/","<803>",$alg); $alg = preg_replace("/4R/","<804>",$alg);
    $alg = preg_replace("/4L'/","<805>",$alg); $alg = preg_replace("/4L/","<806>",$alg);
    $alg = preg_replace("/4B'/","<807>",$alg); $alg = preg_replace("/4B/","<808>",$alg);
    
    /* --- 4xP: TWIZZLE -> CODE: [2] Numbered layer twists --- */
    $alg = preg_replace("/3U'/","<201>",$alg); $alg = preg_replace("/3U/","<202>",$alg);
    $alg = preg_replace("/3R'/","<203>",$alg); $alg = preg_replace("/3R/","<204>",$alg);
    $alg = preg_replace("/3L'/","<205>",$alg); $alg = preg_replace("/3L/","<206>",$alg);
    $alg = preg_replace("/3B'/","<207>",$alg); $alg = preg_replace("/3B/","<208>",$alg);
    
    $alg = preg_replace("/2U'/","<209>",$alg); $alg = preg_replace("/2U/","<210>",$alg);
    $alg = preg_replace("/2R'/","<211>",$alg); $alg = preg_replace("/2R/","<212>",$alg);
    $alg = preg_replace("/2L'/","<213>",$alg); $alg = preg_replace("/2L/","<214>",$alg);
    $alg = preg_replace("/2B'/","<215>",$alg); $alg = preg_replace("/2B/","<216>",$alg);
    
    /* --- 4xP: TWIZZLE -> CODE: [3] Tier twists --- */
    $alg = preg_replace("/3u'/","<301>",$alg); $alg = preg_replace("/3u/","<302>",$alg);
    $alg = preg_replace("/3r'/","<303>",$alg); $alg = preg_replace("/3r/","<304>",$alg);
    $alg = preg_replace("/3l'/","<305>",$alg); $alg = preg_replace("/3l/","<306>",$alg);
    $alg = preg_replace("/3b'/","<307>",$alg); $alg = preg_replace("/3b/","<308>",$alg);
    
    /* --- 4xP: TWIZZLE -> CODE: [7] Pyramid rotations --- */
    $alg = preg_replace("/Uv'/","<701>",$alg); $alg = preg_replace("/Uv/","<702>",$alg);
    $alg = preg_replace("/Rv'/","<703>",$alg); $alg = preg_replace("/Rv/","<704>",$alg);
    $alg = preg_replace("/Lv'/","<705>",$alg); $alg = preg_replace("/Lv/","<706>",$alg);
    $alg = preg_replace("/Bv'/","<707>",$alg); $alg = preg_replace("/Bv/","<708>",$alg);
    
    /* --- 4xP: TWIZZLE -> CODE: [9] Corner twists --- */
    $alg = preg_replace("/U'/","<901>",$alg); $alg = preg_replace("/U/","<902>",$alg);
    $alg = preg_replace("/R'/","<903>",$alg); $alg = preg_replace("/R/","<904>",$alg);
    $alg = preg_replace("/L'/","<905>",$alg); $alg = preg_replace("/L/","<906>",$alg);
    $alg = preg_replace("/B'/","<907>",$alg); $alg = preg_replace("/B/","<908>",$alg);
    
    /* --- 4xP: TWIZZLE -> CODE: [3] Tier twists --- */
    $alg = preg_replace("/u'/","<309>",$alg); $alg = preg_replace("/u/","<310>",$alg);
    $alg = preg_replace("/r'/","<311>",$alg); $alg = preg_replace("/r/","<312>",$alg);
    $alg = preg_replace("/l'/","<313>",$alg); $alg = preg_replace("/l/","<314>",$alg);
    $alg = preg_replace("/b'/","<315>",$alg); $alg = preg_replace("/b/","<316>",$alg);
    
    /* ··································································································· */
    /* --- 4xP: CODE -> SSE: [1] Wide-layer twists --- */
    $alg = preg_replace("/<101>/","WU'",$alg); $alg = preg_replace("/<102>/","WU",$alg);
    $alg = preg_replace("/<103>/","WR'",$alg); $alg = preg_replace("/<104>/","WR",$alg);
    $alg = preg_replace("/<105>/","WL'",$alg); $alg = preg_replace("/<106>/","WL",$alg);
    $alg = preg_replace("/<107>/","WB'",$alg); $alg = preg_replace("/<108>/","WB",$alg);
    
    /* --- 4xP: CODE -> SSE: [8] Face twists --- */
    $alg = preg_replace("/<801>/","T3U CU'",$alg); $alg = preg_replace("/<802>/","T3U' CU",$alg);
    $alg = preg_replace("/<803>/","T3R CR'",$alg); $alg = preg_replace("/<804>/","T3R' CR",$alg);
    $alg = preg_replace("/<805>/","T3L CL'",$alg); $alg = preg_replace("/<806>/","T3L' CL",$alg);
    $alg = preg_replace("/<807>/","T3B CB'",$alg); $alg = preg_replace("/<808>/","T3B' CB",$alg);
    
    /* --- 4xP: CODE -> SSE: [2] Numbered layer twists --- */
    $alg = preg_replace("/<201>/","N3U'",$alg); $alg = preg_replace("/<202>/","N3U",$alg);
    $alg = preg_replace("/<203>/","N3R'",$alg); $alg = preg_replace("/<204>/","N3R",$alg);
    $alg = preg_replace("/<205>/","N3L'",$alg); $alg = preg_replace("/<206>/","N3L",$alg);
    $alg = preg_replace("/<207>/","N3B'",$alg); $alg = preg_replace("/<208>/","N3B",$alg);
    
    $alg = preg_replace("/<209>/","NU'",$alg); $alg = preg_replace("/<210>/","NU",$alg);
    $alg = preg_replace("/<211>/","NR'",$alg); $alg = preg_replace("/<212>/","NR",$alg);
    $alg = preg_replace("/<213>/","NL'",$alg); $alg = preg_replace("/<214>/","NL",$alg);
    $alg = preg_replace("/<215>/","NB'",$alg); $alg = preg_replace("/<216>/","NB",$alg);
    
    /* --- 4xP: CODE -> SSE: [3] Tier twists --- */
    $alg = preg_replace("/<301>/","T3U'",$alg); $alg = preg_replace("/<302>/","T3U",$alg);
    $alg = preg_replace("/<303>/","T3R'",$alg); $alg = preg_replace("/<304>/","T3R",$alg);
    $alg = preg_replace("/<305>/","T3L'",$alg); $alg = preg_replace("/<306>/","T3L",$alg);
    $alg = preg_replace("/<307>/","T3B'",$alg); $alg = preg_replace("/<308>/","T3B",$alg);
    
    /* --- 4xP: CODE -> SSE: [7] Pyramid rotations --- */
    $alg = preg_replace("/<701>/","CU'",$alg); $alg = preg_replace("/<702>/","CU",$alg);
    $alg = preg_replace("/<703>/","CR'",$alg); $alg = preg_replace("/<704>/","CR",$alg);
    $alg = preg_replace("/<705>/","CL'",$alg); $alg = preg_replace("/<706>/","CL",$alg);
    $alg = preg_replace("/<707>/","CB'",$alg); $alg = preg_replace("/<708>/","CB",$alg);
    
    /* --- 4xP: CODE -> SSE: [9] Corner twists --- */
    $alg = preg_replace("/<901>/","U'",$alg); $alg = preg_replace("/<902>/","U",$alg);
    $alg = preg_replace("/<903>/","R'",$alg); $alg = preg_replace("/<904>/","R",$alg);
    $alg = preg_replace("/<905>/","L'",$alg); $alg = preg_replace("/<906>/","L",$alg);
    $alg = preg_replace("/<907>/","B'",$alg); $alg = preg_replace("/<908>/","B",$alg);
    
    /* --- 4xP: CODE -> SSE: [3] Tier twists --- */
    $alg = preg_replace("/<309>/","TU'",$alg); $alg = preg_replace("/<310>/","TU",$alg);
    $alg = preg_replace("/<311>/","TR'",$alg); $alg = preg_replace("/<312>/","TR",$alg);
    $alg = preg_replace("/<313>/","TL'",$alg); $alg = preg_replace("/<314>/","TL",$alg);
    $alg = preg_replace("/<315>/","TB'",$alg); $alg = preg_replace("/<316>/","TB",$alg);
    
    return $alg;
  }
  
  
  
  
  /* 
  ---------------------------------------------------------------------------------------------------
  * alg5xP_SseToTwizzle($alg)
  * 
  * Converts 5x5 Professor Pyraminx SSE algorithms into TWIZZLE notation.
  * 
  * Parameter: $alg (STRING): The algorithm.
  * 
  * Return: STRING.
  ---------------------------------------------------------------------------------------------------
  */
  function alg5xP_SseToTwizzle($alg) {
    /* --- 5xP: Preferences --- */
    $useMarkers = false; // 01.04.2021: Unfortunately Twizzle Explorer doesn't handle Markers correctly!
    
    /* --- 5xP: Marker --- */
    if ($useMarkers != true) {
      $alg = str_replace("·","",$alg); $alg = str_replace(".","",$alg); // Remove Markers!
    } else {
      $alg = str_replace("·",".",$alg);
    }
    
    /* ··································································································· */
    /* --- 5xP: SSE -> CODE: [1] Wide-layer twists --- */
    $alg = preg_replace("/WU'/","<101>",$alg); $alg = preg_replace("/WU-/","<101>",$alg);   $alg = preg_replace("/WU/","<102>",$alg);
    $alg = preg_replace("/WR'/","<103>",$alg); $alg = preg_replace("/WR-/","<103>",$alg);   $alg = preg_replace("/WR/","<104>",$alg);
    $alg = preg_replace("/WL'/","<105>",$alg); $alg = preg_replace("/WL-/","<105>",$alg);   $alg = preg_replace("/WL/","<106>",$alg);
    $alg = preg_replace("/WB'/","<107>",$alg); $alg = preg_replace("/WB-/","<107>",$alg);   $alg = preg_replace("/WB/","<108>",$alg);
    
    $alg = preg_replace("/N2-4U'/","<101>",$alg); $alg = preg_replace("/N2-4U-/","<101>",$alg);   $alg = preg_replace("/N2-4U/","<102>",$alg);
    $alg = preg_replace("/N2-4R'/","<103>",$alg); $alg = preg_replace("/N2-4R-/","<103>",$alg);   $alg = preg_replace("/N2-4R/","<104>",$alg);
    $alg = preg_replace("/N2-4L'/","<105>",$alg); $alg = preg_replace("/N2-4L-/","<105>",$alg);   $alg = preg_replace("/N2-4L/","<106>",$alg);
    $alg = preg_replace("/N2-4B'/","<107>",$alg); $alg = preg_replace("/N2-4B-/","<107>",$alg);   $alg = preg_replace("/N2-4B/","<108>",$alg);
    
    /* --- 5xP: SSE -> CODE: [2] Numbered layer twists --- */
    $alg = preg_replace("/N3-4U'/","<201>",$alg); $alg = preg_replace("/N3-4U-/","<201>",$alg);   $alg = preg_replace("/N3-4U/","<202>",$alg);
    $alg = preg_replace("/N3-4R'/","<203>",$alg); $alg = preg_replace("/N3-4R-/","<203>",$alg);   $alg = preg_replace("/N3-4R/","<204>",$alg);
    $alg = preg_replace("/N3-4L'/","<205>",$alg); $alg = preg_replace("/N3-4L-/","<205>",$alg);   $alg = preg_replace("/N3-4L/","<206>",$alg);
    $alg = preg_replace("/N3-4B'/","<207>",$alg); $alg = preg_replace("/N3-4B-/","<207>",$alg);   $alg = preg_replace("/N3-4B/","<208>",$alg);
    
    $alg = preg_replace("/N2-3U'/","<209>",$alg); $alg = preg_replace("/N2-3U-/","<209>",$alg);   $alg = preg_replace("/N2-3U/","<210>",$alg);
    $alg = preg_replace("/N2-3R'/","<211>",$alg); $alg = preg_replace("/N2-3R-/","<211>",$alg);   $alg = preg_replace("/N2-3R/","<212>",$alg);
    $alg = preg_replace("/N2-3L'/","<213>",$alg); $alg = preg_replace("/N2-3L-/","<213>",$alg);   $alg = preg_replace("/N2-3L/","<214>",$alg);
    $alg = preg_replace("/N2-3B'/","<215>",$alg); $alg = preg_replace("/N2-3B-/","<215>",$alg);   $alg = preg_replace("/N2-3B/","<216>",$alg);
    
    $alg = preg_replace("/VU'/","<209>",$alg); $alg = preg_replace("/VU-/","<209>",$alg);   $alg = preg_replace("/VU/","<210>",$alg);
    $alg = preg_replace("/VR'/","<211>",$alg); $alg = preg_replace("/VR-/","<211>",$alg);   $alg = preg_replace("/VR/","<212>",$alg);
    $alg = preg_replace("/VL'/","<213>",$alg); $alg = preg_replace("/VL-/","<213>",$alg);   $alg = preg_replace("/VL/","<214>",$alg);
    $alg = preg_replace("/VB'/","<215>",$alg); $alg = preg_replace("/VB-/","<215>",$alg);   $alg = preg_replace("/VB/","<216>",$alg);
    
    $alg = preg_replace("/N4U'/","<217>",$alg); $alg = preg_replace("/N4U-/","<217>",$alg);   $alg = preg_replace("/N4U/","<218>",$alg);
    $alg = preg_replace("/N4R'/","<219>",$alg); $alg = preg_replace("/N4R-/","<219>",$alg);   $alg = preg_replace("/N4R/","<220>",$alg);
    $alg = preg_replace("/N4L'/","<221>",$alg); $alg = preg_replace("/N4L-/","<221>",$alg);   $alg = preg_replace("/N4L/","<222>",$alg);
    $alg = preg_replace("/N4B'/","<223>",$alg); $alg = preg_replace("/N4B-/","<223>",$alg);   $alg = preg_replace("/N4B/","<224>",$alg);
    
    $alg = preg_replace("/N3U'/","<225>",$alg); $alg = preg_replace("/N3U-/","<225>",$alg);   $alg = preg_replace("/N3U/","<226>",$alg);
    $alg = preg_replace("/N3R'/","<227>",$alg); $alg = preg_replace("/N3R-/","<227>",$alg);   $alg = preg_replace("/N3R/","<228>",$alg);
    $alg = preg_replace("/N3L'/","<229>",$alg); $alg = preg_replace("/N3L-/","<229>",$alg);   $alg = preg_replace("/N3L/","<230>",$alg);
    $alg = preg_replace("/N3B'/","<231>",$alg); $alg = preg_replace("/N3B-/","<231>",$alg);   $alg = preg_replace("/N3B/","<232>",$alg);
    
    $alg = preg_replace("/NU'/","<233>",$alg); $alg = preg_replace("/NU-/","<233>",$alg);   $alg = preg_replace("/NU/","<234>",$alg);
    $alg = preg_replace("/NR'/","<235>",$alg); $alg = preg_replace("/NR-/","<235>",$alg);   $alg = preg_replace("/NR/","<236>",$alg);
    $alg = preg_replace("/NL'/","<237>",$alg); $alg = preg_replace("/NL-/","<237>",$alg);   $alg = preg_replace("/NL/","<238>",$alg);
    $alg = preg_replace("/NB'/","<239>",$alg); $alg = preg_replace("/NB-/","<239>",$alg);   $alg = preg_replace("/NB/","<240>",$alg);
    
    /* --- 5xP: SSE -> CODE: [3] Tier twists --- */
    $alg = preg_replace("/T4U'/","<301>",$alg); $alg = preg_replace("/T4U-/","<301>",$alg);   $alg = preg_replace("/T4U/","<302>",$alg);
    $alg = preg_replace("/T4R'/","<303>",$alg); $alg = preg_replace("/T4R-/","<303>",$alg);   $alg = preg_replace("/T4R/","<304>",$alg);
    $alg = preg_replace("/T4L'/","<305>",$alg); $alg = preg_replace("/T4L-/","<305>",$alg);   $alg = preg_replace("/T4L/","<306>",$alg);
    $alg = preg_replace("/T4B'/","<307>",$alg); $alg = preg_replace("/T4B-/","<307>",$alg);   $alg = preg_replace("/T4B/","<308>",$alg);
    
    $alg = preg_replace("/T3U'/","<309>",$alg); $alg = preg_replace("/T3U-/","<309>",$alg);   $alg = preg_replace("/T3U/","<310>",$alg);
    $alg = preg_replace("/T3R'/","<311>",$alg); $alg = preg_replace("/T3R-/","<311>",$alg);   $alg = preg_replace("/T3R/","<312>",$alg);
    $alg = preg_replace("/T3L'/","<313>",$alg); $alg = preg_replace("/T3L-/","<313>",$alg);   $alg = preg_replace("/T3L/","<314>",$alg);
    $alg = preg_replace("/T3B'/","<315>",$alg); $alg = preg_replace("/T3B-/","<315>",$alg);   $alg = preg_replace("/T3B/","<316>",$alg);
    
    $alg = preg_replace("/TU'/","<317>",$alg); $alg = preg_replace("/TU-/","<317>",$alg);   $alg = preg_replace("/TU/","<318>",$alg);
    $alg = preg_replace("/TR'/","<319>",$alg); $alg = preg_replace("/TR-/","<319>",$alg);   $alg = preg_replace("/TR/","<320>",$alg);
    $alg = preg_replace("/TL'/","<321>",$alg); $alg = preg_replace("/TL-/","<321>",$alg);   $alg = preg_replace("/TL/","<322>",$alg);
    $alg = preg_replace("/TB'/","<323>",$alg); $alg = preg_replace("/TB-/","<323>",$alg);   $alg = preg_replace("/TB/","<324>",$alg);
    
    /* --- 5xP: SSE -> CODE: [7] Pyramid rotations --- */
    $alg = preg_replace("/CU'/","<701>",$alg); $alg = preg_replace("/CU-/","<701>",$alg);   $alg = preg_replace("/CU/","<702>",$alg);
    $alg = preg_replace("/CR'/","<703>",$alg); $alg = preg_replace("/CR-/","<703>",$alg);   $alg = preg_replace("/CR/","<704>",$alg);
    $alg = preg_replace("/CL'/","<705>",$alg); $alg = preg_replace("/CL-/","<705>",$alg);   $alg = preg_replace("/CL/","<706>",$alg);
    $alg = preg_replace("/CB'/","<707>",$alg); $alg = preg_replace("/CB-/","<707>",$alg);   $alg = preg_replace("/CB/","<708>",$alg);
    
    /* --- 5xP: SSE -> CODE: [9] Corner twists --- */
    $alg = preg_replace("/U'/","<901>",$alg); $alg = preg_replace("/U-/","<901>",$alg);   $alg = preg_replace("/U/","<902>",$alg);
    $alg = preg_replace("/R'/","<903>",$alg); $alg = preg_replace("/R-/","<903>",$alg);   $alg = preg_replace("/R/","<904>",$alg);
    $alg = preg_replace("/L'/","<905>",$alg); $alg = preg_replace("/L-/","<905>",$alg);   $alg = preg_replace("/L/","<906>",$alg);
    $alg = preg_replace("/B'/","<907>",$alg); $alg = preg_replace("/B-/","<907>",$alg);   $alg = preg_replace("/B/","<908>",$alg);
    
    /* ··································································································· */
    /* --- 5xP: CODE -> TWIZZLE: [1] Wide-layer twists --- */
    $alg = preg_replace("/<101>/","2-4U'",$alg); $alg = preg_replace("/<102>/","2-4U",$alg);
    $alg = preg_replace("/<103>/","2-4R'",$alg); $alg = preg_replace("/<104>/","2-4R",$alg);
    $alg = preg_replace("/<105>/","2-4L'",$alg); $alg = preg_replace("/<106>/","2-4L",$alg);
    $alg = preg_replace("/<107>/","2-4B'",$alg); $alg = preg_replace("/<108>/","2-4B",$alg);
    
    /* --- 5xP: CODE -> TWIZZLE: [2] Numbered layer twists --- */
    $alg = preg_replace("/<201>/","3-4U'",$alg); $alg = preg_replace("/<202>/","3-4U",$alg);
    $alg = preg_replace("/<203>/","3-4R'",$alg); $alg = preg_replace("/<204>/","3-4R",$alg);
    $alg = preg_replace("/<205>/","3-4L'",$alg); $alg = preg_replace("/<206>/","3-4L",$alg);
    $alg = preg_replace("/<207>/","3-4B'",$alg); $alg = preg_replace("/<208>/","3-4B",$alg);
    
    $alg = preg_replace("/<209>/","2-3U'",$alg); $alg = preg_replace("/<210>/","2-3U",$alg);
    $alg = preg_replace("/<211>/","2-3R'",$alg); $alg = preg_replace("/<212>/","2-3R",$alg);
    $alg = preg_replace("/<213>/","2-3L'",$alg); $alg = preg_replace("/<214>/","2-3L",$alg);
    $alg = preg_replace("/<215>/","2-3B'",$alg); $alg = preg_replace("/<216>/","2-3B",$alg);
    
    $alg = preg_replace("/<217>/","4U'",$alg); $alg = preg_replace("/<218>/","4U",$alg);
    $alg = preg_replace("/<219>/","4R'",$alg); $alg = preg_replace("/<220>/","4R",$alg);
    $alg = preg_replace("/<221>/","4L'",$alg); $alg = preg_replace("/<222>/","4L",$alg);
    $alg = preg_replace("/<223>/","4B'",$alg); $alg = preg_replace("/<224>/","4B",$alg);
    
    $alg = preg_replace("/<225>/","3U'",$alg); $alg = preg_replace("/<226>/","3U",$alg);
    $alg = preg_replace("/<227>/","3R'",$alg); $alg = preg_replace("/<228>/","3R",$alg);
    $alg = preg_replace("/<229>/","3L'",$alg); $alg = preg_replace("/<230>/","3L",$alg);
    $alg = preg_replace("/<231>/","3B'",$alg); $alg = preg_replace("/<232>/","3B",$alg);
    
    $alg = preg_replace("/<233>/","2U'",$alg); $alg = preg_replace("/<234>/","2U",$alg);
    $alg = preg_replace("/<235>/","2R'",$alg); $alg = preg_replace("/<236>/","2R",$alg);
    $alg = preg_replace("/<237>/","2L'",$alg); $alg = preg_replace("/<238>/","2L",$alg);
    $alg = preg_replace("/<239>/","2B'",$alg); $alg = preg_replace("/<240>/","2B",$alg);
    
    /* --- 5xP: CODE -> TWIZZLE: [3] Tier twists --- */
    $alg = preg_replace("/<301>/","4u'",$alg); $alg = preg_replace("/<302>/","4u",$alg);
    $alg = preg_replace("/<303>/","4r'",$alg); $alg = preg_replace("/<304>/","4r",$alg);
    $alg = preg_replace("/<305>/","4l'",$alg); $alg = preg_replace("/<306>/","4l",$alg);
    $alg = preg_replace("/<307>/","4b'",$alg); $alg = preg_replace("/<308>/","4b",$alg);
    
    $alg = preg_replace("/<309>/","3u'",$alg); $alg = preg_replace("/<310>/","3u",$alg);
    $alg = preg_replace("/<311>/","3r'",$alg); $alg = preg_replace("/<312>/","3r",$alg);
    $alg = preg_replace("/<313>/","3l'",$alg); $alg = preg_replace("/<314>/","3l",$alg);
    $alg = preg_replace("/<315>/","3b'",$alg); $alg = preg_replace("/<316>/","3b",$alg);
    
    $alg = preg_replace("/<317>/","u'",$alg); $alg = preg_replace("/<318>/","u",$alg);
    $alg = preg_replace("/<319>/","r'",$alg); $alg = preg_replace("/<320>/","r",$alg);
    $alg = preg_replace("/<321>/","l'",$alg); $alg = preg_replace("/<322>/","l",$alg);
    $alg = preg_replace("/<323>/","b'",$alg); $alg = preg_replace("/<324>/","b",$alg);
    
    /* --- 5xP: CODE -> TWIZZLE: [7] Pyramid rotations --- */
    $alg = preg_replace("/<701>/","Uv'",$alg); $alg = preg_replace("/<702>/","Uv",$alg);
    $alg = preg_replace("/<703>/","Rv'",$alg); $alg = preg_replace("/<704>/","Rv",$alg);
    $alg = preg_replace("/<705>/","Lv'",$alg); $alg = preg_replace("/<706>/","Lv",$alg);
    $alg = preg_replace("/<707>/","Bv'",$alg); $alg = preg_replace("/<708>/","Bv",$alg);
    
    /* --- 5xP: CODE -> TWIZZLE: [9] Corner twists --- */
    $alg = preg_replace("/<901>/","U'",$alg); $alg = preg_replace("/<902>/","U",$alg);
    $alg = preg_replace("/<903>/","R'",$alg); $alg = preg_replace("/<904>/","U",$alg);
    $alg = preg_replace("/<905>/","L'",$alg); $alg = preg_replace("/<906>/","L",$alg);
    $alg = preg_replace("/<907>/","B'",$alg); $alg = preg_replace("/<908>/","B",$alg);
    
    return $alg;
  }
  
  
  
  
  /* 
  ---------------------------------------------------------------------------------------------------
  * alg5xP_TwizzleToSse($alg)
  * 
  * Converts 5x5 Professor Pyraminx TWIZZLE algorithms into SSE notation.
  * 
  * Parameter: $alg (STRING): The algorithm.
  * 
  * Return: STRING.
  ---------------------------------------------------------------------------------------------------
  */
  function alg5xP_TwizzleToSse($alg) {
    /* --- 3xP: Marker --- */
    $alg = str_replace(".","·",$alg);
    
    /* ··································································································· */
    /* --- 5xP: TWIZZLE -> CODE: [1] Wide-layer twists --- */
    $alg = preg_replace("/2-4U'/","<101>",$alg); $alg = preg_replace("/2-4U/","<102>",$alg);
    $alg = preg_replace("/2-4R'/","<103>",$alg); $alg = preg_replace("/2-4R/","<104>",$alg);
    $alg = preg_replace("/2-4L'/","<105>",$alg); $alg = preg_replace("/2-4L/","<106>",$alg);
    $alg = preg_replace("/2-4B'/","<107>",$alg); $alg = preg_replace("/2-4B/","<108>",$alg);
    
     /* --- 5xP: TWIZZLE -> CODE: [2] Numbered layer twists --- */
    $alg = preg_replace("/3-4U'/","<201>",$alg); $alg = preg_replace("/3-4U/","<202>",$alg);
    $alg = preg_replace("/3-4R'/","<203>",$alg); $alg = preg_replace("/3-4R/","<204>",$alg);
    $alg = preg_replace("/3-4L'/","<205>",$alg); $alg = preg_replace("/3-4L/","<206>",$alg);
    $alg = preg_replace("/3-4B'/","<207>",$alg); $alg = preg_replace("/3-4B/","<208>",$alg);
    
    $alg = preg_replace("/2-3U'/","<209>",$alg); $alg = preg_replace("/2-3U/","<210>",$alg);
    $alg = preg_replace("/2-3R'/","<211>",$alg); $alg = preg_replace("/2-3R/","<212>",$alg);
    $alg = preg_replace("/2-3L'/","<213>",$alg); $alg = preg_replace("/2-3L/","<214>",$alg);
    $alg = preg_replace("/2-3B'/","<215>",$alg); $alg = preg_replace("/2-3B/","<216>",$alg);
    
    /* --- 5xP: TWIZZLE -> CODE: [8] Face twists --- */
    $alg = preg_replace("/5U'/","<801>",$alg); $alg = preg_replace("/5U/","<802>",$alg);
    $alg = preg_replace("/5R'/","<803>",$alg); $alg = preg_replace("/5R/","<804>",$alg);
    $alg = preg_replace("/5L'/","<805>",$alg); $alg = preg_replace("/5L/","<806>",$alg);
    $alg = preg_replace("/5B'/","<807>",$alg); $alg = preg_replace("/5B/","<808>",$alg);
    
     /* --- 5xP: TWIZZLE -> CODE: [2] Numbered layer twists --- */
    $alg = preg_replace("/4U'/","<217>",$alg); $alg = preg_replace("/4U/","<218>",$alg);
    $alg = preg_replace("/4R'/","<219>",$alg); $alg = preg_replace("/4R/","<220>",$alg);
    $alg = preg_replace("/4L'/","<221>",$alg); $alg = preg_replace("/4L/","<222>",$alg);
    $alg = preg_replace("/4B'/","<223>",$alg); $alg = preg_replace("/4B/","<224>",$alg);
    
    $alg = preg_replace("/3U'/","<225>",$alg); $alg = preg_replace("/3U/","<226>",$alg);
    $alg = preg_replace("/3R'/","<227>",$alg); $alg = preg_replace("/3R/","<228>",$alg);
    $alg = preg_replace("/3L'/","<229>",$alg); $alg = preg_replace("/3L/","<230>",$alg);
    $alg = preg_replace("/3B'/","<231>",$alg); $alg = preg_replace("/3B/","<232>",$alg);
    
    $alg = preg_replace("/2U'/","<233>",$alg); $alg = preg_replace("/2U/","<234>",$alg);
    $alg = preg_replace("/2R'/","<235>",$alg); $alg = preg_replace("/2R/","<236>",$alg);
    $alg = preg_replace("/2L'/","<237>",$alg); $alg = preg_replace("/2L/","<238>",$alg);
    $alg = preg_replace("/2B'/","<239>",$alg); $alg = preg_replace("/2B/","<240>",$alg);
    
    /* --- 5xP: TWIZZLE -> CODE: [3] Tier twists --- */
    $alg = preg_replace("/4u'/","<301>",$alg); $alg = preg_replace("/4u/","<302>",$alg);
    $alg = preg_replace("/4r'/","<303>",$alg); $alg = preg_replace("/4r/","<304>",$alg);
    $alg = preg_replace("/4l'/","<305>",$alg); $alg = preg_replace("/4l/","<306>",$alg);
    $alg = preg_replace("/4b'/","<307>",$alg); $alg = preg_replace("/4b/","<308>",$alg);
    
    $alg = preg_replace("/3u'/","<309>",$alg); $alg = preg_replace("/3u/","<310>",$alg);
    $alg = preg_replace("/3r'/","<311>",$alg); $alg = preg_replace("/3r/","<312>",$alg);
    $alg = preg_replace("/3l'/","<313>",$alg); $alg = preg_replace("/3l/","<314>",$alg);
    $alg = preg_replace("/3b'/","<315>",$alg); $alg = preg_replace("/3b/","<316>",$alg);
    
    /* --- 5xP: TWIZZLE -> CODE: [7] Pyramid rotations --- */
    $alg = preg_replace("/Uv'/","<701>",$alg); $alg = preg_replace("/Uv/","<702>",$alg);
    $alg = preg_replace("/Rv'/","<703>",$alg); $alg = preg_replace("/Rv/","<704>",$alg);
    $alg = preg_replace("/Lv'/","<705>",$alg); $alg = preg_replace("/Lv/","<706>",$alg);
    $alg = preg_replace("/Bv'/","<707>",$alg); $alg = preg_replace("/Bv/","<708>",$alg);
    
    /* --- 5xP: TWIZZLE -> CODE: [9] Corner twists --- */
    $alg = preg_replace("/U'/","<901>",$alg); $alg = preg_replace("/U/","<902>",$alg);
    $alg = preg_replace("/R'/","<903>",$alg); $alg = preg_replace("/R/","<904>",$alg);
    $alg = preg_replace("/L'/","<905>",$alg); $alg = preg_replace("/L/","<906>",$alg);
    $alg = preg_replace("/B'/","<907>",$alg); $alg = preg_replace("/B/","<908>",$alg);
    
    /* --- 5xP: TWIZZLE -> CODE: [3] Tier twists --- */
    $alg = preg_replace("/u'/","<317>",$alg); $alg = preg_replace("/u/","<318>",$alg);
    $alg = preg_replace("/r'/","<319>",$alg); $alg = preg_replace("/r/","<320>",$alg);
    $alg = preg_replace("/l'/","<321>",$alg); $alg = preg_replace("/l/","<322>",$alg);
    $alg = preg_replace("/b'/","<323>",$alg); $alg = preg_replace("/b/","<324>",$alg);
    
    /* ··································································································· */
    /* --- 5xP: CODE -> SSE: [1] Wide-layer twists --- */
    $alg = preg_replace("/<101>/","WU'",$alg); $alg = preg_replace("/<102>/","WU",$alg);
    $alg = preg_replace("/<103>/","WR'",$alg); $alg = preg_replace("/<104>/","WR",$alg);
    $alg = preg_replace("/<105>/","WL'",$alg); $alg = preg_replace("/<106>/","WL",$alg);
    $alg = preg_replace("/<107>/","WB'",$alg); $alg = preg_replace("/<108>/","WB",$alg);
    
    /* --- 5xP: CODE -> SSE: [2] Numbered layer twists --- */
    $alg = preg_replace("/<201>/","N3-4U'",$alg); $alg = preg_replace("/<202>/","N3-4U",$alg);
    $alg = preg_replace("/<203>/","N3-4R'",$alg); $alg = preg_replace("/<204>/","N3-4R",$alg);
    $alg = preg_replace("/<205>/","N3-4L'",$alg); $alg = preg_replace("/<206>/","N3-4L",$alg);
    $alg = preg_replace("/<207>/","N3-4B'",$alg); $alg = preg_replace("/<208>/","N3-4B",$alg);
    
    $alg = preg_replace("/<209>/","N2-3U'",$alg); $alg = preg_replace("/<210>/","N2-3U",$alg);
    $alg = preg_replace("/<211>/","N2-3R'",$alg); $alg = preg_replace("/<212>/","N2-3R",$alg);
    $alg = preg_replace("/<213>/","N2-3L'",$alg); $alg = preg_replace("/<214>/","N2-3L",$alg);
    $alg = preg_replace("/<215>/","N2-3B'",$alg); $alg = preg_replace("/<216>/","N2-3B",$alg);
    
    /* --- 5xP: CODE -> SSE: [8] Face twists --- */
    $alg = preg_replace("/<801>/","T4U' CU",$alg); $alg = preg_replace("/<802>/","T4U CU'",$alg);
    $alg = preg_replace("/<803>/","T4R' CR",$alg); $alg = preg_replace("/<804>/","T4R CR'",$alg);
    $alg = preg_replace("/<805>/","T4L' CL",$alg); $alg = preg_replace("/<806>/","T4L CL'",$alg);
    $alg = preg_replace("/<807>/","T4B' CB",$alg); $alg = preg_replace("/<808>/","T4B CB'",$alg);
    
    /* --- 5xP: CODE -> SSE: [2] Numbered layer twists --- */
    $alg = preg_replace("/<217>/","N4U'",$alg); $alg = preg_replace("/<218>/","N4U",$alg);
    $alg = preg_replace("/<219>/","N4R'",$alg); $alg = preg_replace("/<220>/","N4R",$alg);
    $alg = preg_replace("/<221>/","N4L'",$alg); $alg = preg_replace("/<222>/","N4L",$alg);
    $alg = preg_replace("/<223>/","N4B'",$alg); $alg = preg_replace("/<224>/","N4B",$alg);
    
    $alg = preg_replace("/<225>/","N3U'",$alg); $alg = preg_replace("/<226>/","N3U",$alg);
    $alg = preg_replace("/<227>/","N3R'",$alg); $alg = preg_replace("/<228>/","N3R",$alg);
    $alg = preg_replace("/<229>/","N3L'",$alg); $alg = preg_replace("/<230>/","N3L",$alg);
    $alg = preg_replace("/<231>/","N3B'",$alg); $alg = preg_replace("/<232>/","N3B",$alg);
    
    $alg = preg_replace("/<233>/","NU'",$alg); $alg = preg_replace("/<234>/","NU",$alg);
    $alg = preg_replace("/<235>/","NR'",$alg); $alg = preg_replace("/<236>/","NR",$alg);
    $alg = preg_replace("/<237>/","NL'",$alg); $alg = preg_replace("/<238>/","NL",$alg);
    $alg = preg_replace("/<239>/","NB'",$alg); $alg = preg_replace("/<240>/","NB",$alg);
    
    /* --- 5xP: CODE -> SSE: [3] Tier twists --- */
    $alg = preg_replace("/<301>/","T4U'",$alg); $alg = preg_replace("/<302>/","T4U",$alg);
    $alg = preg_replace("/<303>/","T4R'",$alg); $alg = preg_replace("/<304>/","T4R",$alg);
    $alg = preg_replace("/<305>/","T4L'",$alg); $alg = preg_replace("/<306>/","T4L",$alg);
    $alg = preg_replace("/<307>/","T4B'",$alg); $alg = preg_replace("/<308>/","T4B",$alg);
    
    $alg = preg_replace("/<309>/","T3U'",$alg); $alg = preg_replace("/<310>/","T3U",$alg);
    $alg = preg_replace("/<311>/","T3R'",$alg); $alg = preg_replace("/<312>/","T3R",$alg);
    $alg = preg_replace("/<313>/","T3L'",$alg); $alg = preg_replace("/<314>/","T3L",$alg);
    $alg = preg_replace("/<315>/","T3B'",$alg); $alg = preg_replace("/<316>/","T3B",$alg);
    
    /* --- 5xP: CODE -> SSE: [7] Pyramid rotations --- */
    $alg = preg_replace("/<701>/","CU'",$alg); $alg = preg_replace("/<702>/","CU",$alg);
    $alg = preg_replace("/<703>/","CR'",$alg); $alg = preg_replace("/<704>/","CR",$alg);
    $alg = preg_replace("/<705>/","CL'",$alg); $alg = preg_replace("/<706>/","CL",$alg);
    $alg = preg_replace("/<707>/","CB'",$alg); $alg = preg_replace("/<708>/","CB",$alg);
    
    /* --- 5xP: CODE -> SSE: [9] Corner twists --- */
    $alg = preg_replace("/<901>/","U'",$alg); $alg = preg_replace("/<902>/","U",$alg);
    $alg = preg_replace("/<903>/","R'",$alg); $alg = preg_replace("/<904>/","R",$alg);
    $alg = preg_replace("/<905>/","L'",$alg); $alg = preg_replace("/<906>/","L",$alg);
    $alg = preg_replace("/<907>/","B'",$alg); $alg = preg_replace("/<908>/","B",$alg);
    
    /* --- 5xP: CODE -> SSE: [3] Tier twists --- */
    $alg = preg_replace("/<317>/","TU'",$alg); $alg = preg_replace("/<318>/","TU",$alg);
    $alg = preg_replace("/<319>/","TR'",$alg); $alg = preg_replace("/<320>/","TR",$alg);
    $alg = preg_replace("/<321>/","TL'",$alg); $alg = preg_replace("/<322>/","TL",$alg);
    $alg = preg_replace("/<323>/","TB'",$alg); $alg = preg_replace("/<324>/","TB",$alg);
    
    return $alg;
  }
  
  
  
  
  /* 
  ---------------------------------------------------------------------------------------------------
  * alg3xD_SseToTwizzle($alg)
  * 
  * Converts 3x3 Megaminx SSE algorithms into TWIZZLE notation.
  * 
  * Parameter: $alg (STRING): The algorithm.
  * 
  * Return: STRING.
  ---------------------------------------------------------------------------------------------------
  */
  function alg3xD_SseToTwizzle($alg) {
    /* --- Dodecahedron Twists --- */
    //   +0°  = R0, []     = -360° = R5', []
    //  +72°  = R1, [R]    = -288° = R4', [R]
    // +144°  = R2, [R2]   = -216° = R3', [R2]
    // +216°  = R3, [R2']  = -144° = R2', [R2']
    // +288°  = R4, [R']   =  -72° = R1', [R']
    // +360°  = R5, []     =   -0° = R0', []
    
    /* --- 3xD: Preferences --- */
    $useMarkers = false; // 01.04.2021: Unfortunately Twizzle Explorer doesn't handle Markers correctly!
    
    /* --- 3xD: Marker --- */
    if ($useMarkers != true) {
      $alg = str_replace("·","",$alg); $alg = str_replace(".","",$alg); // Remove Markers!
    } else {
      $alg = str_replace("·",".",$alg);
    }
    
    /* ··································································································· */
    /* --- 3xD: SSE -> CODE: [5] Mid-layer [1] (Numbered layer) [6] (Wide) twists --- */
    $alg = preg_replace("/MUR2'/","<101>",$alg); $alg = preg_replace("/MUR2-/","<101>",$alg);   $alg = preg_replace("/MUR'/","<102>",$alg); $alg = preg_replace("/MUR-/","<102>",$alg);   $alg = preg_replace("/MUR2/","<103>",$alg);   $alg = preg_replace("/MUR/","<104>",$alg);
    $alg = preg_replace("/MUL2'/","<105>",$alg); $alg = preg_replace("/MUL2-/","<105>",$alg);   $alg = preg_replace("/MUL'/","<106>",$alg); $alg = preg_replace("/MUL-/","<106>",$alg);   $alg = preg_replace("/MUL2/","<107>",$alg);   $alg = preg_replace("/MUL/","<108>",$alg);
    $alg = preg_replace("/MDR2'/","<109>",$alg); $alg = preg_replace("/MDR2-/","<109>",$alg);   $alg = preg_replace("/MDR'/","<110>",$alg); $alg = preg_replace("/MDR-/","<110>",$alg);   $alg = preg_replace("/MDR2/","<111>",$alg);   $alg = preg_replace("/MDR/","<112>",$alg);
    $alg = preg_replace("/MDL2'/","<113>",$alg); $alg = preg_replace("/MDL2-/","<113>",$alg);   $alg = preg_replace("/MDL'/","<114>",$alg); $alg = preg_replace("/MDL-/","<114>",$alg);   $alg = preg_replace("/MDL2/","<115>",$alg);   $alg = preg_replace("/MDL/","<116>",$alg);
    $alg = preg_replace("/MBR2'/","<117>",$alg); $alg = preg_replace("/MBR2-/","<117>",$alg);   $alg = preg_replace("/MBR'/","<118>",$alg); $alg = preg_replace("/MBR-/","<118>",$alg);   $alg = preg_replace("/MBR2/","<119>",$alg);   $alg = preg_replace("/MBR/","<120>",$alg);
    $alg = preg_replace("/MBL2'/","<121>",$alg); $alg = preg_replace("/MBL2-/","<121>",$alg);   $alg = preg_replace("/MBL'/","<122>",$alg); $alg = preg_replace("/MBL-/","<122>",$alg);   $alg = preg_replace("/MBL2/","<123>",$alg);   $alg = preg_replace("/MBL/","<124>",$alg);
    
    $alg = preg_replace("/MR2'/","<125>",$alg); $alg = preg_replace("/MR2-/","<125>",$alg);     $alg = preg_replace("/MR'/","<126>",$alg);  $alg = preg_replace("/MR-/","<126>",$alg);     $alg = preg_replace("/MR2/","<127>",$alg);    $alg = preg_replace("/MR/","<128>",$alg);
    $alg = preg_replace("/ML2'/","<129>",$alg); $alg = preg_replace("/ML2-/","<129>",$alg);     $alg = preg_replace("/ML'/","<130>",$alg);  $alg = preg_replace("/ML-/","<130>",$alg);     $alg = preg_replace("/ML2/","<131>",$alg);    $alg = preg_replace("/ML/","<132>",$alg);
    $alg = preg_replace("/MF2'/","<133>",$alg); $alg = preg_replace("/MF2-/","<133>",$alg);     $alg = preg_replace("/MF'/","<134>",$alg);  $alg = preg_replace("/MF-/","<134>",$alg);     $alg = preg_replace("/MF2/","<135>",$alg);    $alg = preg_replace("/MF/","<136>",$alg);
    $alg = preg_replace("/MB2'/","<137>",$alg); $alg = preg_replace("/MB2-/","<137>",$alg);     $alg = preg_replace("/MB'/","<138>",$alg);  $alg = preg_replace("/MB-/","<138>",$alg);     $alg = preg_replace("/MB2/","<139>",$alg);    $alg = preg_replace("/MB/","<140>",$alg);
    $alg = preg_replace("/MU2'/","<141>",$alg); $alg = preg_replace("/MU2-/","<141>",$alg);     $alg = preg_replace("/MU'/","<142>",$alg);  $alg = preg_replace("/MU-/","<142>",$alg);     $alg = preg_replace("/MU2/","<143>",$alg);    $alg = preg_replace("/MU/","<144>",$alg);
    $alg = preg_replace("/MD2'/","<145>",$alg); $alg = preg_replace("/MD2-/","<145>",$alg);     $alg = preg_replace("/MD'/","<146>",$alg);  $alg = preg_replace("/MD-/","<146>",$alg);     $alg = preg_replace("/MD2/","<147>",$alg);    $alg = preg_replace("/MD/","<148>",$alg);
    
    $alg = preg_replace("/NUR2'/","<101>",$alg); $alg = preg_replace("/NUR2-/","<101>",$alg);   $alg = preg_replace("/NUR'/","<102>",$alg); $alg = preg_replace("/NUR-/","<102>",$alg);   $alg = preg_replace("/NUR2/","<103>",$alg);   $alg = preg_replace("/NUR/","<104>",$alg);
    $alg = preg_replace("/NUL2'/","<105>",$alg); $alg = preg_replace("/NUL2-/","<105>",$alg);   $alg = preg_replace("/NUL'/","<106>",$alg); $alg = preg_replace("/NUL-/","<106>",$alg);   $alg = preg_replace("/NUL2/","<107>",$alg);   $alg = preg_replace("/NUL/","<108>",$alg);
    $alg = preg_replace("/NDR2'/","<109>",$alg); $alg = preg_replace("/NDR2-/","<109>",$alg);   $alg = preg_replace("/NDR'/","<110>",$alg); $alg = preg_replace("/NDR-/","<110>",$alg);   $alg = preg_replace("/NDR2/","<111>",$alg);   $alg = preg_replace("/NDR/","<112>",$alg);
    $alg = preg_replace("/NDL2'/","<113>",$alg); $alg = preg_replace("/NDL2-/","<113>",$alg);   $alg = preg_replace("/NDL'/","<114>",$alg); $alg = preg_replace("/NDL-/","<114>",$alg);   $alg = preg_replace("/NDL2/","<115>",$alg);   $alg = preg_replace("/NDL/","<116>",$alg);
    $alg = preg_replace("/NBR2'/","<117>",$alg); $alg = preg_replace("/NBR2-/","<117>",$alg);   $alg = preg_replace("/NBR'/","<118>",$alg); $alg = preg_replace("/NBR-/","<118>",$alg);   $alg = preg_replace("/NBR2/","<119>",$alg);   $alg = preg_replace("/NBR/","<120>",$alg);
    $alg = preg_replace("/NBL2'/","<121>",$alg); $alg = preg_replace("/NBL2-/","<121>",$alg);   $alg = preg_replace("/NBL'/","<122>",$alg); $alg = preg_replace("/NBL-/","<122>",$alg);   $alg = preg_replace("/NBL2/","<123>",$alg);   $alg = preg_replace("/NBL/","<124>",$alg);
    
    $alg = preg_replace("/NR2'/","<125>",$alg); $alg = preg_replace("/NR2-/","<125>",$alg);     $alg = preg_replace("/NR'/","<126>",$alg);  $alg = preg_replace("/NR-/","<126>",$alg);     $alg = preg_replace("/NR2/","<127>",$alg);    $alg = preg_replace("/NR/","<128>",$alg);
    $alg = preg_replace("/NL2'/","<129>",$alg); $alg = preg_replace("/NL2-/","<129>",$alg);     $alg = preg_replace("/NL'/","<130>",$alg);  $alg = preg_replace("/NL-/","<130>",$alg);     $alg = preg_replace("/NL2/","<131>",$alg);    $alg = preg_replace("/NL/","<132>",$alg);
    $alg = preg_replace("/NF2'/","<133>",$alg); $alg = preg_replace("/NF2-/","<133>",$alg);     $alg = preg_replace("/NF'/","<134>",$alg);  $alg = preg_replace("/NF-/","<134>",$alg);     $alg = preg_replace("/NF2/","<135>",$alg);    $alg = preg_replace("/NF/","<136>",$alg);
    $alg = preg_replace("/NB2'/","<137>",$alg); $alg = preg_replace("/NB2-/","<137>",$alg);     $alg = preg_replace("/NB'/","<138>",$alg);  $alg = preg_replace("/NB-/","<138>",$alg);     $alg = preg_replace("/NB2/","<139>",$alg);    $alg = preg_replace("/NB/","<140>",$alg);
    $alg = preg_replace("/NU2'/","<141>",$alg); $alg = preg_replace("/NU2-/","<141>",$alg);     $alg = preg_replace("/NU'/","<142>",$alg);  $alg = preg_replace("/NU-/","<142>",$alg);     $alg = preg_replace("/NU2/","<143>",$alg);    $alg = preg_replace("/NU/","<144>",$alg);
    $alg = preg_replace("/ND2'/","<145>",$alg); $alg = preg_replace("/ND2-/","<145>",$alg);     $alg = preg_replace("/ND'/","<146>",$alg);  $alg = preg_replace("/ND-/","<146>",$alg);     $alg = preg_replace("/ND2/","<147>",$alg);    $alg = preg_replace("/ND/","<148>",$alg);
    
    $alg = preg_replace("/WUR2'/","<101>",$alg); $alg = preg_replace("/WUR2-/","<101>",$alg);   $alg = preg_replace("/WUR'/","<102>",$alg); $alg = preg_replace("/WUR-/","<102>",$alg);   $alg = preg_replace("/WUR2/","<103>",$alg);   $alg = preg_replace("/WUR/","<104>",$alg);
    $alg = preg_replace("/WUL2'/","<105>",$alg); $alg = preg_replace("/WUL2-/","<105>",$alg);   $alg = preg_replace("/WUL'/","<106>",$alg); $alg = preg_replace("/WUL-/","<106>",$alg);   $alg = preg_replace("/WUL2/","<107>",$alg);   $alg = preg_replace("/WUL/","<108>",$alg);
    $alg = preg_replace("/WDR2'/","<109>",$alg); $alg = preg_replace("/WDR2-/","<109>",$alg);   $alg = preg_replace("/WDR'/","<110>",$alg); $alg = preg_replace("/WDR-/","<110>",$alg);   $alg = preg_replace("/WDR2/","<111>",$alg);   $alg = preg_replace("/WDR/","<112>",$alg);
    $alg = preg_replace("/WDL2'/","<113>",$alg); $alg = preg_replace("/WDL2-/","<113>",$alg);   $alg = preg_replace("/WDL'/","<114>",$alg); $alg = preg_replace("/WDL-/","<114>",$alg);   $alg = preg_replace("/WDL2/","<115>",$alg);   $alg = preg_replace("/WDL/","<116>",$alg);
    $alg = preg_replace("/WBR2'/","<117>",$alg); $alg = preg_replace("/WBR2-/","<117>",$alg);   $alg = preg_replace("/WBR'/","<118>",$alg); $alg = preg_replace("/WBR-/","<118>",$alg);   $alg = preg_replace("/WBR2/","<119>",$alg);   $alg = preg_replace("/WBR/","<120>",$alg);
    $alg = preg_replace("/WBL2'/","<121>",$alg); $alg = preg_replace("/WBL2-/","<121>",$alg);   $alg = preg_replace("/WBL'/","<122>",$alg); $alg = preg_replace("/WBL-/","<122>",$alg);   $alg = preg_replace("/WBL2/","<123>",$alg);   $alg = preg_replace("/WBL/","<124>",$alg);
    
    $alg = preg_replace("/WR2'/","<125>",$alg); $alg = preg_replace("/WR2-/","<125>",$alg);     $alg = preg_replace("/WR'/","<126>",$alg);  $alg = preg_replace("/WR-/","<126>",$alg);     $alg = preg_replace("/WR2/","<127>",$alg);    $alg = preg_replace("/WR/","<128>",$alg);
    $alg = preg_replace("/WL2'/","<129>",$alg); $alg = preg_replace("/WL2-/","<129>",$alg);     $alg = preg_replace("/WL'/","<130>",$alg);  $alg = preg_replace("/WL-/","<130>",$alg);     $alg = preg_replace("/WL2/","<131>",$alg);    $alg = preg_replace("/WL/","<132>",$alg);
    $alg = preg_replace("/WF2'/","<133>",$alg); $alg = preg_replace("/WF2-/","<133>",$alg);     $alg = preg_replace("/WF'/","<134>",$alg);  $alg = preg_replace("/WF-/","<134>",$alg);     $alg = preg_replace("/WF2/","<135>",$alg);    $alg = preg_replace("/WF/","<136>",$alg);
    $alg = preg_replace("/WB2'/","<137>",$alg); $alg = preg_replace("/WB2-/","<137>",$alg);     $alg = preg_replace("/WB'/","<138>",$alg);  $alg = preg_replace("/WB-/","<138>",$alg);     $alg = preg_replace("/WB2/","<139>",$alg);    $alg = preg_replace("/WB/","<140>",$alg);
    $alg = preg_replace("/WU2'/","<141>",$alg); $alg = preg_replace("/WU2-/","<141>",$alg);     $alg = preg_replace("/WU'/","<142>",$alg);  $alg = preg_replace("/WU-/","<142>",$alg);     $alg = preg_replace("/WU2/","<143>",$alg);    $alg = preg_replace("/WU/","<144>",$alg);
    $alg = preg_replace("/WD2'/","<145>",$alg); $alg = preg_replace("/WD2-/","<145>",$alg);     $alg = preg_replace("/WD'/","<146>",$alg);  $alg = preg_replace("/WD-/","<146>",$alg);     $alg = preg_replace("/WD2/","<147>",$alg);    $alg = preg_replace("/WD/","<148>",$alg);
    
    /* --- 3xD: SSE -> CODE: [2] Slice twists --- */
    $alg = preg_replace("/SUR2'/","<201>",$alg); $alg = preg_replace("/SUR2-/","<201>",$alg);   $alg = preg_replace("/SUR'/","<202>",$alg); $alg = preg_replace("/SUR-/","<202>",$alg);   $alg = preg_replace("/SUR2/","<203>",$alg);   $alg = preg_replace("/SUR/","<204>",$alg);
    $alg = preg_replace("/SUL2'/","<205>",$alg); $alg = preg_replace("/SUL2-/","<205>",$alg);   $alg = preg_replace("/SUL'/","<206>",$alg); $alg = preg_replace("/SUL-/","<206>",$alg);   $alg = preg_replace("/SUL2/","<207>",$alg);   $alg = preg_replace("/SUL/","<208>",$alg);
    $alg = preg_replace("/SDR2'/","<209>",$alg); $alg = preg_replace("/SDR2-/","<209>",$alg);   $alg = preg_replace("/SDR'/","<210>",$alg); $alg = preg_replace("/SDR-/","<210>",$alg);   $alg = preg_replace("/SDR2/","<211>",$alg);   $alg = preg_replace("/SDR/","<212>",$alg);
    $alg = preg_replace("/SDL2'/","<213>",$alg); $alg = preg_replace("/SDL2-/","<213>",$alg);   $alg = preg_replace("/SDL'/","<214>",$alg); $alg = preg_replace("/SDL-/","<214>",$alg);   $alg = preg_replace("/SDL2/","<215>",$alg);   $alg = preg_replace("/SDL/","<216>",$alg);
    $alg = preg_replace("/SBR2'/","<217>",$alg); $alg = preg_replace("/SBR2-/","<217>",$alg);   $alg = preg_replace("/SBR'/","<218>",$alg); $alg = preg_replace("/SBR-/","<218>",$alg);   $alg = preg_replace("/SBR2/","<219>",$alg);   $alg = preg_replace("/SBR/","<220>",$alg);
    $alg = preg_replace("/SBL2'/","<221>",$alg); $alg = preg_replace("/SBL2-/","<221>",$alg);   $alg = preg_replace("/SBL'/","<222>",$alg); $alg = preg_replace("/SBL-/","<222>",$alg);   $alg = preg_replace("/SBL2/","<223>",$alg);   $alg = preg_replace("/SBL/","<224>",$alg);
    
    $alg = preg_replace("/SR2'/","<225>",$alg); $alg = preg_replace("/SR2-/","<225>",$alg);     $alg = preg_replace("/SR'/","<226>",$alg);  $alg = preg_replace("/SR-/","<226>",$alg);     $alg = preg_replace("/SR2/","<227>",$alg);    $alg = preg_replace("/SR/","<228>",$alg);
    $alg = preg_replace("/SL2'/","<229>",$alg); $alg = preg_replace("/SL2-/","<229>",$alg);     $alg = preg_replace("/SL'/","<230>",$alg);  $alg = preg_replace("/SL-/","<230>",$alg);     $alg = preg_replace("/SL2/","<231>",$alg);    $alg = preg_replace("/SL/","<232>",$alg);
    $alg = preg_replace("/SF2'/","<233>",$alg); $alg = preg_replace("/SF2-/","<233>",$alg);     $alg = preg_replace("/SF'/","<234>",$alg);  $alg = preg_replace("/SF-/","<234>",$alg);     $alg = preg_replace("/SF2/","<235>",$alg);    $alg = preg_replace("/SF/","<236>",$alg);
    $alg = preg_replace("/SB2'/","<237>",$alg); $alg = preg_replace("/SB2-/","<237>",$alg);     $alg = preg_replace("/SB'/","<238>",$alg);  $alg = preg_replace("/SB-/","<238>",$alg);     $alg = preg_replace("/SB2/","<239>",$alg);    $alg = preg_replace("/SB/","<240>",$alg);
    $alg = preg_replace("/SU2'/","<241>",$alg); $alg = preg_replace("/SU2-/","<241>",$alg);     $alg = preg_replace("/SU'/","<242>",$alg);  $alg = preg_replace("/SU-/","<242>",$alg);     $alg = preg_replace("/SU2/","<243>",$alg);    $alg = preg_replace("/SU/","<244>",$alg);
    $alg = preg_replace("/SD2'/","<245>",$alg); $alg = preg_replace("/SD2-/","<245>",$alg);     $alg = preg_replace("/SD'/","<246>",$alg);  $alg = preg_replace("/SD-/","<246>",$alg);     $alg = preg_replace("/SD2/","<247>",$alg);    $alg = preg_replace("/SD/","<248>",$alg);
    
    /* --- 3xD: SSE -> CODE: [3] Tier twists --- */
    $alg = preg_replace("/TUR2'/","<301>",$alg); $alg = preg_replace("/TUR2-/","<301>",$alg);   $alg = preg_replace("/TUR'/","<302>",$alg); $alg = preg_replace("/TUR-/","<302>",$alg);   $alg = preg_replace("/TUR2/","<303>",$alg);   $alg = preg_replace("/TUR/","<304>",$alg);
    $alg = preg_replace("/TUL2'/","<305>",$alg); $alg = preg_replace("/TUL2-/","<305>",$alg);   $alg = preg_replace("/TUL'/","<306>",$alg); $alg = preg_replace("/TUL-/","<306>",$alg);   $alg = preg_replace("/TUL2/","<307>",$alg);   $alg = preg_replace("/TUL/","<308>",$alg);
    $alg = preg_replace("/TDR2'/","<309>",$alg); $alg = preg_replace("/TDR2-/","<309>",$alg);   $alg = preg_replace("/TDR'/","<310>",$alg); $alg = preg_replace("/TDR-/","<310>",$alg);   $alg = preg_replace("/TDR2/","<311>",$alg);   $alg = preg_replace("/TDR/","<312>",$alg);
    $alg = preg_replace("/TDL2'/","<313>",$alg); $alg = preg_replace("/TDL2-/","<313>",$alg);   $alg = preg_replace("/TDL'/","<314>",$alg); $alg = preg_replace("/TDL-/","<314>",$alg);   $alg = preg_replace("/TDL2/","<315>",$alg);   $alg = preg_replace("/TDL/","<316>",$alg);
    $alg = preg_replace("/TBR2'/","<317>",$alg); $alg = preg_replace("/TBR2-/","<317>",$alg);   $alg = preg_replace("/TBR'/","<318>",$alg); $alg = preg_replace("/TBR-/","<318>",$alg);   $alg = preg_replace("/TBR2/","<319>",$alg);   $alg = preg_replace("/TBR/","<320>",$alg);
    $alg = preg_replace("/TBL2'/","<321>",$alg); $alg = preg_replace("/TBL2-/","<321>",$alg);   $alg = preg_replace("/TBL'/","<322>",$alg); $alg = preg_replace("/TBL-/","<322>",$alg);   $alg = preg_replace("/TBL2/","<323>",$alg);   $alg = preg_replace("/TBL/","<324>",$alg);
    
    $alg = preg_replace("/TR2'/","<325>",$alg); $alg = preg_replace("/TR2-/","<325>",$alg);     $alg = preg_replace("/TR'/","<326>",$alg);  $alg = preg_replace("/TR-/","<326>",$alg);     $alg = preg_replace("/TR2/","<327>",$alg);    $alg = preg_replace("/TR/","<328>",$alg);
    $alg = preg_replace("/TL2'/","<329>",$alg); $alg = preg_replace("/TL2-/","<329>",$alg);     $alg = preg_replace("/TL'/","<330>",$alg);  $alg = preg_replace("/TL-/","<330>",$alg);     $alg = preg_replace("/TL2/","<331>",$alg);    $alg = preg_replace("/TL/","<332>",$alg);
    $alg = preg_replace("/TF2'/","<333>",$alg); $alg = preg_replace("/TF2-/","<333>",$alg);     $alg = preg_replace("/TF'/","<334>",$alg);  $alg = preg_replace("/TF-/","<334>",$alg);     $alg = preg_replace("/TF2/","<335>",$alg);    $alg = preg_replace("/TF/","<336>",$alg);
    $alg = preg_replace("/TB2'/","<337>",$alg); $alg = preg_replace("/TB2-/","<337>",$alg);     $alg = preg_replace("/TB'/","<338>",$alg);  $alg = preg_replace("/TB-/","<338>",$alg);     $alg = preg_replace("/TB2/","<339>",$alg);    $alg = preg_replace("/TB/","<340>",$alg);
    $alg = preg_replace("/TU2'/","<341>",$alg); $alg = preg_replace("/TU2-/","<341>",$alg);     $alg = preg_replace("/TU'/","<342>",$alg);  $alg = preg_replace("/TU-/","<342>",$alg);     $alg = preg_replace("/TU2/","<343>",$alg);    $alg = preg_replace("/TU/","<344>",$alg);
    $alg = preg_replace("/TD2'/","<345>",$alg); $alg = preg_replace("/TD2-/","<345>",$alg);     $alg = preg_replace("/TD'/","<346>",$alg);  $alg = preg_replace("/TD-/","<346>",$alg);     $alg = preg_replace("/TD2/","<347>",$alg);    $alg = preg_replace("/TD/","<348>",$alg);
    
    /* --- 3xD: SSE -> CODE: [7] Dodecahedron rotations --- */
    $alg = preg_replace("/CUR2'/","<701>",$alg); $alg = preg_replace("/CUR2-/","<701>",$alg);   $alg = preg_replace("/CUR'/","<702>",$alg); $alg = preg_replace("/CUR-/","<702>",$alg);   $alg = preg_replace("/CUR2/","<703>",$alg);   $alg = preg_replace("/CUR/","<704>",$alg);
    $alg = preg_replace("/CUL2'/","<705>",$alg); $alg = preg_replace("/CUL2-/","<705>",$alg);   $alg = preg_replace("/CUL'/","<706>",$alg); $alg = preg_replace("/CUL-/","<706>",$alg);   $alg = preg_replace("/CUL2/","<707>",$alg);   $alg = preg_replace("/CUL/","<708>",$alg);
    $alg = preg_replace("/CDR2'/","<709>",$alg); $alg = preg_replace("/CDR2-/","<709>",$alg);   $alg = preg_replace("/CDR'/","<710>",$alg); $alg = preg_replace("/CDR-/","<710>",$alg);   $alg = preg_replace("/CDR2/","<711>",$alg);   $alg = preg_replace("/CDR/","<712>",$alg);
    $alg = preg_replace("/CDL2'/","<713>",$alg); $alg = preg_replace("/CDL2-/","<713>",$alg);   $alg = preg_replace("/CDL'/","<714>",$alg); $alg = preg_replace("/CDL-/","<714>",$alg);   $alg = preg_replace("/CDL2/","<715>",$alg);   $alg = preg_replace("/CDL/","<716>",$alg);
    $alg = preg_replace("/CBR2'/","<717>",$alg); $alg = preg_replace("/CBR2-/","<717>",$alg);   $alg = preg_replace("/CBR'/","<718>",$alg); $alg = preg_replace("/CBR-/","<718>",$alg);   $alg = preg_replace("/CBR2/","<719>",$alg);   $alg = preg_replace("/CBR/","<720>",$alg);
    $alg = preg_replace("/CBL2'/","<721>",$alg); $alg = preg_replace("/CBL2-/","<721>",$alg);   $alg = preg_replace("/CBL'/","<722>",$alg); $alg = preg_replace("/CBL-/","<722>",$alg);   $alg = preg_replace("/CBL2/","<723>",$alg);   $alg = preg_replace("/CBL/","<724>",$alg);
    
    $alg = preg_replace("/CR2'/","<725>",$alg); $alg = preg_replace("/CR2-/","<725>",$alg);     $alg = preg_replace("/CR'/","<726>",$alg);  $alg = preg_replace("/CR-/","<726>",$alg);     $alg = preg_replace("/CR2/","<727>",$alg);    $alg = preg_replace("/CR/","<728>",$alg);
    $alg = preg_replace("/CL2'/","<729>",$alg); $alg = preg_replace("/CL2-/","<729>",$alg);     $alg = preg_replace("/CL'/","<730>",$alg);  $alg = preg_replace("/CL-/","<730>",$alg);     $alg = preg_replace("/CL2/","<731>",$alg);    $alg = preg_replace("/CL/","<732>",$alg);
    $alg = preg_replace("/CF2'/","<733>",$alg); $alg = preg_replace("/CF2-/","<733>",$alg);     $alg = preg_replace("/CF'/","<734>",$alg);  $alg = preg_replace("/CF-/","<734>",$alg);     $alg = preg_replace("/CF2/","<735>",$alg);    $alg = preg_replace("/CF/","<736>",$alg);
    $alg = preg_replace("/CB2'/","<737>",$alg); $alg = preg_replace("/CB2-/","<737>",$alg);     $alg = preg_replace("/CB'/","<738>",$alg);  $alg = preg_replace("/CB-/","<738>",$alg);     $alg = preg_replace("/CB2/","<739>",$alg);    $alg = preg_replace("/CB/","<740>",$alg);
    $alg = preg_replace("/CU2'/","<741>",$alg); $alg = preg_replace("/CU2-/","<741>",$alg);     $alg = preg_replace("/CU'/","<742>",$alg);  $alg = preg_replace("/CU-/","<742>",$alg);     $alg = preg_replace("/CU2/","<743>",$alg);    $alg = preg_replace("/CU/","<744>",$alg);
    $alg = preg_replace("/CD2'/","<745>",$alg); $alg = preg_replace("/CD2-/","<745>",$alg);     $alg = preg_replace("/CD'/","<746>",$alg);  $alg = preg_replace("/CD-/","<746>",$alg);     $alg = preg_replace("/CD2/","<747>",$alg);    $alg = preg_replace("/CD/","<748>",$alg);
    
    /* --- 3xD: SSE -> CODE: [9] Face twists --- */
    $alg = preg_replace("/UR2'/","<901>",$alg); $alg = preg_replace("/UR2-/","<901>",$alg);   $alg = preg_replace("/UR'/","<902>",$alg); $alg = preg_replace("/UR-/","<902>",$alg);   $alg = preg_replace("/UR2/","<903>",$alg);   $alg = preg_replace("/UR/","<904>",$alg);
    $alg = preg_replace("/UL2'/","<905>",$alg); $alg = preg_replace("/UL2-/","<905>",$alg);   $alg = preg_replace("/UL'/","<906>",$alg); $alg = preg_replace("/UL-/","<906>",$alg);   $alg = preg_replace("/UL2/","<907>",$alg);   $alg = preg_replace("/UL/","<908>",$alg);
    $alg = preg_replace("/DR2'/","<909>",$alg); $alg = preg_replace("/DR2-/","<909>",$alg);   $alg = preg_replace("/DR'/","<910>",$alg); $alg = preg_replace("/DR-/","<910>",$alg);   $alg = preg_replace("/DR2/","<911>",$alg);   $alg = preg_replace("/DR/","<912>",$alg);
    $alg = preg_replace("/DL2'/","<913>",$alg); $alg = preg_replace("/DL2-/","<913>",$alg);   $alg = preg_replace("/DL'/","<914>",$alg); $alg = preg_replace("/DL-/","<914>",$alg);   $alg = preg_replace("/DL2/","<915>",$alg);   $alg = preg_replace("/DL/","<916>",$alg);
    $alg = preg_replace("/BR2'/","<917>",$alg); $alg = preg_replace("/BR2-/","<917>",$alg);   $alg = preg_replace("/BR'/","<918>",$alg); $alg = preg_replace("/BR-/","<918>",$alg);   $alg = preg_replace("/BR2/","<919>",$alg);   $alg = preg_replace("/BR/","<920>",$alg);
    $alg = preg_replace("/BL2'/","<921>",$alg); $alg = preg_replace("/BL2-/","<921>",$alg);   $alg = preg_replace("/BL'/","<922>",$alg); $alg = preg_replace("/BL-/","<922>",$alg);   $alg = preg_replace("/BL2/","<923>",$alg);   $alg = preg_replace("/BL/","<924>",$alg);
    
    $alg = preg_replace("/R2'/","<925>",$alg); $alg = preg_replace("/R2-/","<925>",$alg);     $alg = preg_replace("/R'/","<926>",$alg); $alg = preg_replace("/R-/","<926>",$alg);     $alg = preg_replace("/R2/","<927>",$alg);    $alg = preg_replace("/R/","<928>",$alg);
    $alg = preg_replace("/L2'/","<929>",$alg); $alg = preg_replace("/L2-/","<929>",$alg);     $alg = preg_replace("/L'/","<930>",$alg); $alg = preg_replace("/L-/","<930>",$alg);     $alg = preg_replace("/L2/","<931>",$alg);    $alg = preg_replace("/L/","<932>",$alg);
    $alg = preg_replace("/F2'/","<933>",$alg); $alg = preg_replace("/F2-/","<933>",$alg);     $alg = preg_replace("/F'/","<934>",$alg); $alg = preg_replace("/F-/","<934>",$alg);     $alg = preg_replace("/F2/","<935>",$alg);    $alg = preg_replace("/F/","<936>",$alg);
    $alg = preg_replace("/B2'/","<937>",$alg); $alg = preg_replace("/B2-/","<937>",$alg);     $alg = preg_replace("/B'/","<938>",$alg); $alg = preg_replace("/B-/","<938>",$alg);     $alg = preg_replace("/B2/","<939>",$alg);    $alg = preg_replace("/B/","<940>",$alg);
    $alg = preg_replace("/U2'/","<941>",$alg); $alg = preg_replace("/U2-/","<941>",$alg);     $alg = preg_replace("/U'/","<942>",$alg); $alg = preg_replace("/U-/","<942>",$alg);     $alg = preg_replace("/U2/","<943>",$alg);    $alg = preg_replace("/U/","<944>",$alg);
    $alg = preg_replace("/D2'/","<945>",$alg); $alg = preg_replace("/D2-/","<945>",$alg);     $alg = preg_replace("/D'/","<946>",$alg); $alg = preg_replace("/D-/","<946>",$alg);     $alg = preg_replace("/D2/","<947>",$alg);    $alg = preg_replace("/D/","<948>",$alg);
    
    /* ··································································································· */
    /* --- 3xD: CODE -> TWIZZLE: [5] Mid-layer [1] (Numbered layer) [6] (Wide) twists --- */
    $alg = preg_replace("/<101>/","2BR2'",$alg);   $alg = preg_replace("/<102>/","2BR'",$alg);   $alg = preg_replace("/<103>/","2BR2",$alg);   $alg = preg_replace("/<104>/","2BR",$alg);
    $alg = preg_replace("/<105>/","2BL2'",$alg);   $alg = preg_replace("/<106>/","2BL'",$alg);   $alg = preg_replace("/<107>/","2BL2",$alg);   $alg = preg_replace("/<108>/","2BL",$alg);
    $alg = preg_replace("/<109>/","2FR2'",$alg);   $alg = preg_replace("/<110>/","2FR'",$alg);   $alg = preg_replace("/<111>/","2FR2",$alg);   $alg = preg_replace("/<112>/","2FR",$alg);
    $alg = preg_replace("/<113>/","2FL2'",$alg);   $alg = preg_replace("/<114>/","2FL'",$alg);   $alg = preg_replace("/<115>/","2FL2",$alg);   $alg = preg_replace("/<116>/","2FL",$alg);
    $alg = preg_replace("/<117>/","2DR2'",$alg);   $alg = preg_replace("/<118>/","2DR'",$alg);   $alg = preg_replace("/<119>/","2DR2",$alg);   $alg = preg_replace("/<120>/","2DR",$alg);
    $alg = preg_replace("/<121>/","2DL2'",$alg);   $alg = preg_replace("/<122>/","2DL'",$alg);   $alg = preg_replace("/<123>/","2DL2",$alg);   $alg = preg_replace("/<124>/","2DL",$alg);
    
    $alg = preg_replace("/<125>/","2R2'",$alg);    $alg = preg_replace("/<126>/","2R'",$alg);    $alg = preg_replace("/<127>/","2R2",$alg);    $alg = preg_replace("/<128>/","2R",$alg);
    $alg = preg_replace("/<129>/","2L2'",$alg);    $alg = preg_replace("/<130>/","2L'",$alg);    $alg = preg_replace("/<131>/","2L2",$alg);    $alg = preg_replace("/<132>/","2L",$alg);
    $alg = preg_replace("/<133>/","2F2'",$alg);    $alg = preg_replace("/<134>/","2F'",$alg);    $alg = preg_replace("/<135>/","2F2",$alg);    $alg = preg_replace("/<136>/","2F",$alg);
    $alg = preg_replace("/<137>/","2B2'",$alg);    $alg = preg_replace("/<138>/","2B'",$alg);    $alg = preg_replace("/<139>/","2B2",$alg);    $alg = preg_replace("/<140>/","2B",$alg);
    $alg = preg_replace("/<141>/","2U2'",$alg);    $alg = preg_replace("/<142>/","2U'",$alg);    $alg = preg_replace("/<143>/","2U2",$alg);    $alg = preg_replace("/<144>/","2U",$alg);
    $alg = preg_replace("/<145>/","2D2'",$alg);    $alg = preg_replace("/<146>/","2D'",$alg);    $alg = preg_replace("/<147>/","2D2",$alg);    $alg = preg_replace("/<148>/","2D",$alg);
    
    /* --- 3xD: CODE -> TWIZZLE: [2] Slice twists --- */
    $alg = preg_replace("/<201>/","BR2' FL2",$alg);   $alg = preg_replace("/<202>/","BR' FL",$alg);   $alg = preg_replace("/<203>/","BR2 FL2'",$alg);   $alg = preg_replace("/<204>/","BR FL'",$alg);
    $alg = preg_replace("/<205>/","BL2' FR2",$alg);   $alg = preg_replace("/<206>/","BL' FR",$alg);   $alg = preg_replace("/<207>/","BL2 FR2'",$alg);   $alg = preg_replace("/<208>/","BL FR'",$alg);
    $alg = preg_replace("/<209>/","FR2' BL2",$alg);   $alg = preg_replace("/<210>/","FR' BL",$alg);   $alg = preg_replace("/<211>/","FR2 BL2'",$alg);   $alg = preg_replace("/<212>/","FR BL'",$alg);
    $alg = preg_replace("/<213>/","FL2' BR2",$alg);   $alg = preg_replace("/<214>/","FL' BR",$alg);   $alg = preg_replace("/<215>/","FL2 BR2'",$alg);   $alg = preg_replace("/<216>/","FL BR'",$alg);
    $alg = preg_replace("/<217>/","DR2' L2",$alg);    $alg = preg_replace("/<218>/","DR' L",$alg);    $alg = preg_replace("/<219>/","DR2 L2'",$alg);    $alg = preg_replace("/<220>/","DR L'",$alg);
    $alg = preg_replace("/<221>/","DL2' R2",$alg);    $alg = preg_replace("/<222>/","DL' R",$alg);    $alg = preg_replace("/<223>/","DL2 R2'",$alg);    $alg = preg_replace("/<224>/","DL R'",$alg);
    
    $alg = preg_replace("/<225>/","R2' DL2",$alg);    $alg = preg_replace("/<226>/","R' DL",$alg);    $alg = preg_replace("/<227>/","R2 DL2'",$alg);    $alg = preg_replace("/<228>/","R DL'",$alg);
    $alg = preg_replace("/<229>/","L2' DR2",$alg);    $alg = preg_replace("/<230>/","L' DR",$alg);    $alg = preg_replace("/<231>/","L2 DR2'",$alg);    $alg = preg_replace("/<232>/","L DR'",$alg);
    $alg = preg_replace("/<233>/","F2' B2",$alg);     $alg = preg_replace("/<234>/","F' B",$alg);     $alg = preg_replace("/<235>/","F2 B2'",$alg);     $alg = preg_replace("/<236>/","F B'",$alg);
    $alg = preg_replace("/<237>/","B2' F2",$alg);     $alg = preg_replace("/<238>/","B' F",$alg);     $alg = preg_replace("/<239>/","B2 F2'",$alg);     $alg = preg_replace("/<240>/","B F'",$alg);
    $alg = preg_replace("/<241>/","U2' D2",$alg);     $alg = preg_replace("/<242>/","U' D",$alg);     $alg = preg_replace("/<243>/","U2 D2'",$alg);     $alg = preg_replace("/<244>/","U D'",$alg);
    $alg = preg_replace("/<245>/","D2' U2",$alg);     $alg = preg_replace("/<246>/","D' U",$alg);     $alg = preg_replace("/<247>/","D2 U2'",$alg);     $alg = preg_replace("/<248>/","D U'",$alg);
    
    /* --- 3xD: CODE -> TWIZZLE: [3] Tier twists --- */
    $alg = preg_replace("/<301>/","br2'",$alg);   $alg = preg_replace("/<302>/","br'",$alg);   $alg = preg_replace("/<303>/","br2",$alg);   $alg = preg_replace("/<304>/","br",$alg);
    $alg = preg_replace("/<305>/","bl2'",$alg);   $alg = preg_replace("/<306>/","bl'",$alg);   $alg = preg_replace("/<307>/","bl2",$alg);   $alg = preg_replace("/<308>/","bl",$alg);
    $alg = preg_replace("/<309>/","fr2'",$alg);   $alg = preg_replace("/<310>/","fr'",$alg);   $alg = preg_replace("/<311>/","fr2",$alg);   $alg = preg_replace("/<312>/","fr",$alg);
    $alg = preg_replace("/<313>/","fl2'",$alg);   $alg = preg_replace("/<314>/","fl'",$alg);   $alg = preg_replace("/<315>/","fl2",$alg);   $alg = preg_replace("/<316>/","fl",$alg);
    $alg = preg_replace("/<317>/","dr2'",$alg);   $alg = preg_replace("/<318>/","dr'",$alg);   $alg = preg_replace("/<319>/","dr2",$alg);   $alg = preg_replace("/<320>/","dr",$alg);
    $alg = preg_replace("/<321>/","dl2'",$alg);   $alg = preg_replace("/<322>/","dl'",$alg);   $alg = preg_replace("/<323>/","dl2",$alg);   $alg = preg_replace("/<324>/","dl",$alg);
    
    $alg = preg_replace("/<325>/","r2'",$alg);    $alg = preg_replace("/<326>/","r'",$alg);    $alg = preg_replace("/<327>/","r2",$alg);    $alg = preg_replace("/<328>/","r",$alg);
    $alg = preg_replace("/<329>/","l2'",$alg);    $alg = preg_replace("/<330>/","l'",$alg);    $alg = preg_replace("/<331>/","l2",$alg);    $alg = preg_replace("/<332>/","l",$alg);
    $alg = preg_replace("/<333>/","f2'",$alg);    $alg = preg_replace("/<334>/","f'",$alg);    $alg = preg_replace("/<335>/","f2",$alg);    $alg = preg_replace("/<336>/","f",$alg);
    $alg = preg_replace("/<337>/","b2'",$alg);    $alg = preg_replace("/<338>/","b'",$alg);    $alg = preg_replace("/<339>/","b2",$alg);    $alg = preg_replace("/<340>/","b",$alg);
    $alg = preg_replace("/<341>/","u2'",$alg);    $alg = preg_replace("/<342>/","u'",$alg);    $alg = preg_replace("/<343>/","u2",$alg);    $alg = preg_replace("/<344>/","u",$alg);
    $alg = preg_replace("/<345>/","d2'",$alg);    $alg = preg_replace("/<346>/","d'",$alg);    $alg = preg_replace("/<347>/","d2",$alg);    $alg = preg_replace("/<348>/","d",$alg);
    
    /* --- 3xD: CODE -> TWIZZLE: [7] Dodecahedron rotations --- */
    $alg = preg_replace("/<701>/","BRv2'",$alg);   $alg = preg_replace("/<702>/","BRv'",$alg);   $alg = preg_replace("/<703>/","BRv2",$alg);   $alg = preg_replace("/<704>/","BRv",$alg);
    $alg = preg_replace("/<705>/","BLv2'",$alg);   $alg = preg_replace("/<706>/","BLv'",$alg);   $alg = preg_replace("/<707>/","BLv2",$alg);   $alg = preg_replace("/<708>/","BLv",$alg);
    $alg = preg_replace("/<709>/","FRv2'",$alg);   $alg = preg_replace("/<710>/","FRv'",$alg);   $alg = preg_replace("/<711>/","FRv2",$alg);   $alg = preg_replace("/<712>/","FRv",$alg);
    $alg = preg_replace("/<713>/","FLv2'",$alg);   $alg = preg_replace("/<714>/","FLv'",$alg);   $alg = preg_replace("/<715>/","FLv2",$alg);   $alg = preg_replace("/<716>/","FLv",$alg);
    $alg = preg_replace("/<717>/","DRv2'",$alg);   $alg = preg_replace("/<718>/","DRv'",$alg);   $alg = preg_replace("/<719>/","DRv2",$alg);   $alg = preg_replace("/<720>/","DRv",$alg);
    $alg = preg_replace("/<721>/","DLv2'",$alg);   $alg = preg_replace("/<722>/","DLv'",$alg);   $alg = preg_replace("/<723>/","DLv2",$alg);   $alg = preg_replace("/<724>/","DLv",$alg);
    
    $alg = preg_replace("/<725>/","Rv2'",$alg);    $alg = preg_replace("/<726>/","Rv'",$alg);    $alg = preg_replace("/<727>/","Rv2",$alg);    $alg = preg_replace("/<728>/","Rv",$alg);
    $alg = preg_replace("/<729>/","Lv2'",$alg);    $alg = preg_replace("/<730>/","Lv'",$alg);    $alg = preg_replace("/<731>/","Lv2",$alg);    $alg = preg_replace("/<732>/","Lv",$alg);
    $alg = preg_replace("/<733>/","Fv2'",$alg);    $alg = preg_replace("/<734>/","Fv'",$alg);    $alg = preg_replace("/<735>/","Fv2",$alg);    $alg = preg_replace("/<736>/","Fv",$alg);
    $alg = preg_replace("/<737>/","Bv2'",$alg);    $alg = preg_replace("/<738>/","Bv'",$alg);    $alg = preg_replace("/<739>/","Bv2",$alg);    $alg = preg_replace("/<740>/","Bv",$alg);
    $alg = preg_replace("/<741>/","Uv2'",$alg);    $alg = preg_replace("/<742>/","Uv'",$alg);    $alg = preg_replace("/<743>/","Uv2",$alg);    $alg = preg_replace("/<744>/","Uv",$alg);
    $alg = preg_replace("/<745>/","Dv2'",$alg);    $alg = preg_replace("/<746>/","Dv'",$alg);    $alg = preg_replace("/<747>/","Dv2",$alg);    $alg = preg_replace("/<748>/","Dv",$alg);
    
    /* --- 3xD: CODE -> TWIZZLE: [9] Face twists --- */
    $alg = preg_replace("/<901>/","BR2'",$alg);   $alg = preg_replace("/<902>/","BR'",$alg);   $alg = preg_replace("/<903>/","BR2",$alg);   $alg = preg_replace("/<904>/","BR",$alg);
    $alg = preg_replace("/<905>/","BL2'",$alg);   $alg = preg_replace("/<906>/","BL'",$alg);   $alg = preg_replace("/<907>/","BL2",$alg);   $alg = preg_replace("/<908>/","BL",$alg);
    $alg = preg_replace("/<909>/","FR2'",$alg);   $alg = preg_replace("/<910>/","FR'",$alg);   $alg = preg_replace("/<911>/","FR2",$alg);   $alg = preg_replace("/<912>/","FR",$alg);
    $alg = preg_replace("/<913>/","FL2'",$alg);   $alg = preg_replace("/<914>/","FL'",$alg);   $alg = preg_replace("/<915>/","FL2",$alg);   $alg = preg_replace("/<916>/","FL",$alg);
    $alg = preg_replace("/<917>/","DR2'",$alg);   $alg = preg_replace("/<918>/","DR'",$alg);   $alg = preg_replace("/<919>/","DR2",$alg);   $alg = preg_replace("/<920>/","DR",$alg);
    $alg = preg_replace("/<921>/","DL2'",$alg);   $alg = preg_replace("/<922>/","DL'",$alg);   $alg = preg_replace("/<923>/","DL2",$alg);   $alg = preg_replace("/<924>/","DL",$alg);
    
    $alg = preg_replace("/<925>/","R2'",$alg);    $alg = preg_replace("/<926>/","R'",$alg);    $alg = preg_replace("/<927>/","R2",$alg);    $alg = preg_replace("/<928>/","R",$alg);
    $alg = preg_replace("/<929>/","L2'",$alg);    $alg = preg_replace("/<930>/","L'",$alg);    $alg = preg_replace("/<931>/","L2",$alg);    $alg = preg_replace("/<932>/","L",$alg);
    $alg = preg_replace("/<933>/","F2'",$alg);    $alg = preg_replace("/<934>/","F'",$alg);    $alg = preg_replace("/<935>/","F2",$alg);    $alg = preg_replace("/<936>/","F",$alg);
    $alg = preg_replace("/<937>/","B2'",$alg);    $alg = preg_replace("/<938>/","B'",$alg);    $alg = preg_replace("/<939>/","B2",$alg);    $alg = preg_replace("/<940>/","B",$alg);
    $alg = preg_replace("/<941>/","U2'",$alg);    $alg = preg_replace("/<942>/","U'",$alg);    $alg = preg_replace("/<943>/","U2",$alg);    $alg = preg_replace("/<944>/","U",$alg);
    $alg = preg_replace("/<945>/","D2'",$alg);    $alg = preg_replace("/<946>/","D'",$alg);    $alg = preg_replace("/<947>/","D2",$alg);    $alg = preg_replace("/<948>/","D",$alg);
    
    return $alg;
  }
  
  
  
  
  /* 
  ---------------------------------------------------------------------------------------------------
  * alg3xD_OldTwizzleToTwizzle($alg)
  * 
  * Converts 3x3 Megaminx Old Twizzle algorithms into Twizzle notation.
  * 
  * Parameter: $alg (STRING): The algorithm.
  * 
  * Return: STRING.
  ---------------------------------------------------------------------------------------------------
  */
  function alg3xD_OldTwizzleToTwizzle($alg) {
    /* --- Dodecahedron Twists --- */
    //   +0°  = R0, []     = -360° = R5', []
    //  +72°  = R1, [R]    = -288° = R4', [R]
    // +144°  = R2, [R2]   = -216° = R3', [R2]
    // +216°  = R3, [R2']  = -144° = R2', [R2']
    // +288°  = R4, [R']   =  -72° = R1', [R']
    // +360°  = R5, []     =   -0° = R0', []
    
    /* ··································································································· */
    /* --- 3xD: OLD TWIZZLE -> TWIZZLE --- */
    $alg = str_replace("BF","B",$alg);
    
    $alg = str_replace("bf","b",$alg);
    
    $alg = str_replace("A","FL",$alg);
    $alg = str_replace("C","FR",$alg);
    $alg = str_replace("E","DR",$alg);
    $alg = str_replace("I","DL",$alg);
    
    $alg = str_replace("a","fl",$alg);
    $alg = str_replace("c","fr",$alg);
    $alg = str_replace("e","dr",$alg);
    $alg = str_replace("i","dl",$alg);
    
    return $alg;
  }
  
  
  
  
  /* 
  ---------------------------------------------------------------------------------------------------
  * alg3xD_TwizzleToSse($alg)
  * 
  * Converts 3x3 Megaminx SiGN algorithms into SSE notation.
  * 
  * Parameter: $alg (STRING): The algorithm.
  * 
  * Return: STRING.
  ---------------------------------------------------------------------------------------------------
  */
  function alg3xD_TwizzleToSse($alg) {
    /* --- Dodecahedron Twists --- */
    //   +0°  = R0, []     = -360° = R5', []
    //  +72°  = R1, [R]    = -288° = R4', [R]
    // +144°  = R2, [R2]   = -216° = R3', [R2]
    // +216°  = R3, [R2']  = -144° = R2', [R2']
    // +288°  = R4, [R']   =  -72° = R1', [R']
    // +360°  = R5, []     =   -0° = R0', []
    
    /* --- 3xD: Marker --- */
    $alg = str_replace(".","·",$alg);
    
    /* ··································································································· */
    /* --- 3xD: OLD TWIZZLE -> CODE: [5] Mid-layer [1] (Numbered layer) [6] (Wide) twists --- */
    $alg = preg_replace("/2BF2'/","<137>",$alg);    $alg = preg_replace("/2BF'/","<138>",$alg);    $alg = preg_replace("/2BF2/","<139>",$alg);       $alg = preg_replace("/2BF/","<140>",$alg); // BF -> B.
    
    $alg = preg_replace("/2C2'/","<109>",$alg);   $alg = preg_replace("/2C'/","<110>",$alg);   $alg = preg_replace("/2C2/","<111>",$alg);      $alg = preg_replace("/2C/","<112>",$alg); // C -> FR.
    $alg = preg_replace("/2A2'/","<113>",$alg);   $alg = preg_replace("/2A'/","<114>",$alg);   $alg = preg_replace("/2A2/","<115>",$alg);      $alg = preg_replace("/2A/","<116>",$alg); // A -> FL.
    $alg = preg_replace("/2E2'/","<117>",$alg);   $alg = preg_replace("/2E'/","<118>",$alg);   $alg = preg_replace("/2E2/","<119>",$alg);      $alg = preg_replace("/2E/","<120>",$alg); // E -> DR.
    $alg = preg_replace("/2I2'/","<121>",$alg);   $alg = preg_replace("/2I'/","<122>",$alg);   $alg = preg_replace("/2I2/","<123>",$alg);      $alg = preg_replace("/2I/","<124>",$alg); // I -> DL.
    
    /* --- 3xD: TWIZZLE -> CODE: [5] Mid-layer [1] (Numbered layer) [6] (Wide) twists --- */
    $alg = preg_replace("/2BR2'/","<101>",$alg);   $alg = preg_replace("/2BR'/","<102>",$alg);   $alg = preg_replace("/2BR2/","<103>",$alg);      $alg = preg_replace("/2BR/","<104>",$alg);
    $alg = preg_replace("/2BL2'/","<105>",$alg);   $alg = preg_replace("/2BL'/","<106>",$alg);   $alg = preg_replace("/2BL2/","<107>",$alg);      $alg = preg_replace("/2BL/","<108>",$alg);
    $alg = preg_replace("/2FR2'/","<109>",$alg);   $alg = preg_replace("/2FR'/","<110>",$alg);   $alg = preg_replace("/2FR2/","<111>",$alg);      $alg = preg_replace("/2FR/","<112>",$alg);
    $alg = preg_replace("/2FL2'/","<113>",$alg);   $alg = preg_replace("/2FL'/","<114>",$alg);   $alg = preg_replace("/2FL2/","<115>",$alg);      $alg = preg_replace("/2FL/","<116>",$alg);
    $alg = preg_replace("/2DR2'/","<117>",$alg);   $alg = preg_replace("/2DR'/","<118>",$alg);   $alg = preg_replace("/2DR2/","<119>",$alg);      $alg = preg_replace("/2DR/","<120>",$alg);
    $alg = preg_replace("/2DL2'/","<121>",$alg);   $alg = preg_replace("/2DL'/","<122>",$alg);   $alg = preg_replace("/2DL2/","<123>",$alg);      $alg = preg_replace("/2DL/","<124>",$alg);
    
    $alg = preg_replace("/2R2'/","<125>",$alg);    $alg = preg_replace("/2R'/","<126>",$alg);    $alg = preg_replace("/2R2/","<127>",$alg);       $alg = preg_replace("/2R/","<128>",$alg);
    $alg = preg_replace("/2L2'/","<129>",$alg);    $alg = preg_replace("/2L'/","<130>",$alg);    $alg = preg_replace("/2L2/","<131>",$alg);       $alg = preg_replace("/2L/","<132>",$alg);
    $alg = preg_replace("/2F2'/","<133>",$alg);    $alg = preg_replace("/2F'/","<134>",$alg);    $alg = preg_replace("/2F2/","<135>",$alg);       $alg = preg_replace("/2F/","<136>",$alg);
    $alg = preg_replace("/2B2'/","<137>",$alg);    $alg = preg_replace("/2B'/","<138>",$alg);    $alg = preg_replace("/2B2/","<139>",$alg);       $alg = preg_replace("/2B/","<140>",$alg);
    $alg = preg_replace("/2U2'/","<141>",$alg);    $alg = preg_replace("/2U'/","<142>",$alg);    $alg = preg_replace("/2U2/","<143>",$alg);       $alg = preg_replace("/2U/","<144>",$alg);
    $alg = preg_replace("/2D2'/","<145>",$alg);    $alg = preg_replace("/2D'/","<146>",$alg);    $alg = preg_replace("/2D2/","<147>",$alg);       $alg = preg_replace("/2D/","<148>",$alg);
    
    /* --- 3xD: OLD TWIZZLE -> CODE: [7] Dodecahedron rotations --- */
    $alg = preg_replace("/BFv2'/","<737>",$alg);   $alg = preg_replace("/BFv'/","<738>",$alg);   $alg = preg_replace("/BFv2/","<739>",$alg);      $alg = preg_replace("/BFv/","<740>",$alg); // BF -> B.
    
    $alg = preg_replace("/Cv2'/","<709>",$alg);   $alg = preg_replace("/Cv'/","<710>",$alg);   $alg = preg_replace("/Cv2/","<711>",$alg);      $alg = preg_replace("/Cv/","<712>",$alg); // C -> FR.
    $alg = preg_replace("/Av2'/","<713>",$alg);   $alg = preg_replace("/Av'/","<714>",$alg);   $alg = preg_replace("/Av2/","<715>",$alg);      $alg = preg_replace("/Av/","<716>",$alg); // A -> FL.
    $alg = preg_replace("/Ev2'/","<717>",$alg);   $alg = preg_replace("/Ev'/","<718>",$alg);   $alg = preg_replace("/Ev2/","<719>",$alg);      $alg = preg_replace("/Ev/","<720>",$alg); // E -> DR.
    $alg = preg_replace("/Iv2'/","<721>",$alg);   $alg = preg_replace("/Iv'/","<722>",$alg);   $alg = preg_replace("/Iv2/","<723>",$alg);      $alg = preg_replace("/Iv/","<724>",$alg); // I -> DL.
    
    /* --- 3xD: TWIZZLE -> CODE: [7] Dodecahedron rotations --- */
    $alg = preg_replace("/BRv2'/","<701>",$alg);   $alg = preg_replace("/BRv'/","<702>",$alg);   $alg = preg_replace("/BRv2/","<703>",$alg);      $alg = preg_replace("/BRv/","<704>",$alg);
    $alg = preg_replace("/BLv2'/","<705>",$alg);   $alg = preg_replace("/BLv'/","<706>",$alg);   $alg = preg_replace("/BLv2/","<707>",$alg);      $alg = preg_replace("/BLv/","<708>",$alg);
    $alg = preg_replace("/FRv2'/","<709>",$alg);   $alg = preg_replace("/FRv'/","<710>",$alg);   $alg = preg_replace("/FRv2/","<711>",$alg);      $alg = preg_replace("/FRv/","<712>",$alg);
    $alg = preg_replace("/FLv2'/","<713>",$alg);   $alg = preg_replace("/FLv'/","<714>",$alg);   $alg = preg_replace("/FLv2/","<715>",$alg);      $alg = preg_replace("/FLv/","<716>",$alg);
    $alg = preg_replace("/DRv2'/","<717>",$alg);   $alg = preg_replace("/DRv'/","<718>",$alg);   $alg = preg_replace("/DRv2/","<719>",$alg);      $alg = preg_replace("/DRv/","<720>",$alg);
    $alg = preg_replace("/DLv2'/","<721>",$alg);   $alg = preg_replace("/DLv'/","<722>",$alg);   $alg = preg_replace("/DLv2/","<723>",$alg);      $alg = preg_replace("/DLv/","<724>",$alg);
    
    $alg = preg_replace("/Rv2'/","<725>",$alg);    $alg = preg_replace("/Rv'/","<726>",$alg);    $alg = preg_replace("/Rv2/","<727>",$alg);       $alg = preg_replace("/Rv/","<728>",$alg);
    $alg = preg_replace("/Lv2'/","<729>",$alg);    $alg = preg_replace("/Lv'/","<730>",$alg);    $alg = preg_replace("/Lv2/","<731>",$alg);       $alg = preg_replace("/Lv/","<732>",$alg);
    $alg = preg_replace("/Fv2'/","<733>",$alg);    $alg = preg_replace("/Fv'/","<734>",$alg);    $alg = preg_replace("/Fv2/","<735>",$alg);       $alg = preg_replace("/Fv/","<736>",$alg);
    $alg = preg_replace("/Bv2'/","<737>",$alg);    $alg = preg_replace("/Bv'/","<738>",$alg);    $alg = preg_replace("/Bv2/","<739>",$alg);       $alg = preg_replace("/Bv/","<740>",$alg);
    $alg = preg_replace("/Uv2'/","<741>",$alg);    $alg = preg_replace("/Uv'/","<742>",$alg);    $alg = preg_replace("/Uv2/","<743>",$alg);       $alg = preg_replace("/Uv/","<744>",$alg);
    $alg = preg_replace("/Dv2'/","<745>",$alg);    $alg = preg_replace("/Dv'/","<746>",$alg);    $alg = preg_replace("/Dv2/","<747>",$alg);       $alg = preg_replace("/Dv/","<748>",$alg);
    
    /* --- 3xD: OLD TWIZZLE -> CODE: [9] Face twists --- */
    $alg = preg_replace("/BF2'/","<937>",$alg);    $alg = preg_replace("/BF'/","<938>",$alg);    $alg = preg_replace("/BF2/","<939>",$alg);       $alg = preg_replace("/BF/","<940>",$alg); // BF -> B.
    
    $alg = preg_replace("/C2'/","<909>",$alg);   $alg = preg_replace("/C'/","<910>",$alg);   $alg = preg_replace("/C2/","<911>",$alg);      $alg = preg_replace("/C/","<912>",$alg); // C -> FR.
    $alg = preg_replace("/A2'/","<913>",$alg);   $alg = preg_replace("/A'/","<914>",$alg);   $alg = preg_replace("/A2/","<915>",$alg);      $alg = preg_replace("/A/","<916>",$alg); // A -> FL.
    $alg = preg_replace("/E2'/","<917>",$alg);   $alg = preg_replace("/E'/","<918>",$alg);   $alg = preg_replace("/E2/","<919>",$alg);      $alg = preg_replace("/E/","<920>",$alg); // E -> DR.
    $alg = preg_replace("/I2'/","<921>",$alg);   $alg = preg_replace("/I'/","<922>",$alg);   $alg = preg_replace("/I2/","<923>",$alg);      $alg = preg_replace("/I/","<924>",$alg); // I -> DL.
    
    /* --- 3xD: TWIZZLE -> CODE: [9] Face twists --- */
    $alg = preg_replace("/BR2'/","<901>",$alg);   $alg = preg_replace("/BR'/","<902>",$alg);   $alg = preg_replace("/BR2/","<903>",$alg);      $alg = preg_replace("/BR/","<904>",$alg);
    $alg = preg_replace("/BL2'/","<905>",$alg);   $alg = preg_replace("/BL'/","<906>",$alg);   $alg = preg_replace("/BL2/","<907>",$alg);      $alg = preg_replace("/BL/","<908>",$alg);
    $alg = preg_replace("/FR2'/","<909>",$alg);   $alg = preg_replace("/FR'/","<910>",$alg);   $alg = preg_replace("/FR2/","<911>",$alg);      $alg = preg_replace("/FR/","<912>",$alg);
    $alg = preg_replace("/FL2'/","<913>",$alg);   $alg = preg_replace("/FL'/","<914>",$alg);   $alg = preg_replace("/FL2/","<915>",$alg);      $alg = preg_replace("/FL/","<916>",$alg);
    $alg = preg_replace("/DR2'/","<917>",$alg);   $alg = preg_replace("/DR'/","<918>",$alg);   $alg = preg_replace("/DR2/","<919>",$alg);      $alg = preg_replace("/DR/","<920>",$alg);
    $alg = preg_replace("/DL2'/","<921>",$alg);   $alg = preg_replace("/DL'/","<922>",$alg);   $alg = preg_replace("/DL2/","<923>",$alg);      $alg = preg_replace("/DL/","<924>",$alg);
    
    $alg = preg_replace("/R2'/","<925>",$alg);    $alg = preg_replace("/R'/","<926>",$alg);    $alg = preg_replace("/R2/","<927>",$alg);       $alg = preg_replace("/R/","<928>",$alg);
    $alg = preg_replace("/L2'/","<929>",$alg);    $alg = preg_replace("/L'/","<930>",$alg);    $alg = preg_replace("/L2/","<931>",$alg);       $alg = preg_replace("/L/","<932>",$alg);
    $alg = preg_replace("/F2'/","<933>",$alg);    $alg = preg_replace("/F'/","<934>",$alg);    $alg = preg_replace("/F2/","<935>",$alg);       $alg = preg_replace("/F/","<936>",$alg);
    $alg = preg_replace("/B2'/","<937>",$alg);    $alg = preg_replace("/B'/","<938>",$alg);    $alg = preg_replace("/B2/","<939>",$alg);       $alg = preg_replace("/B/","<940>",$alg);
    $alg = preg_replace("/U2'/","<941>",$alg);    $alg = preg_replace("/U'/","<942>",$alg);    $alg = preg_replace("/U2/","<943>",$alg);       $alg = preg_replace("/U/","<944>",$alg);
    $alg = preg_replace("/D2'/","<945>",$alg);    $alg = preg_replace("/D'/","<946>",$alg);    $alg = preg_replace("/D2/","<947>",$alg);       $alg = preg_replace("/D/","<948>",$alg);
    
    /* --- 3xD: OLD TWIZZLE -> CODE: [3] Tier twists (SiGN) --- */
    $alg = preg_replace("/bf2'/","<337>",$alg);   $alg = preg_replace("/bf'/","<338>",$alg);   $alg = preg_replace("/bf2/","<339>",$alg);       $alg = preg_replace("/bf/","<340>",$alg); // BF -> B.
    
    $alg = preg_replace("/c2'/","<309>",$alg);   $alg = preg_replace("/c'/","<310>",$alg);   $alg = preg_replace("/c2/","<311>",$alg);      $alg = preg_replace("/c/","<312>",$alg); // C -> FR.
    $alg = preg_replace("/a2'/","<313>",$alg);   $alg = preg_replace("/a'/","<314>",$alg);   $alg = preg_replace("/a2/","<315>",$alg);      $alg = preg_replace("/a/","<316>",$alg); // A -> FL.
    $alg = preg_replace("/e2'/","<317>",$alg);   $alg = preg_replace("/e'/","<318>",$alg);   $alg = preg_replace("/e2/","<319>",$alg);      $alg = preg_replace("/e/","<320>",$alg); // E -> DR.
    $alg = preg_replace("/i2'/","<321>",$alg);   $alg = preg_replace("/i'/","<322>",$alg);   $alg = preg_replace("/i2/","<323>",$alg);      $alg = preg_replace("/i/","<324>",$alg); // I -> DL.
    
    /* --- 3xD: TWIZZLE -> CODE: [3] Tier twists (SiGN) --- */
    $alg = preg_replace("/br2'/","<301>",$alg);   $alg = preg_replace("/br'/","<302>",$alg);   $alg = preg_replace("/br2/","<303>",$alg);      $alg = preg_replace("/br/","<304>",$alg);
    $alg = preg_replace("/bl2'/","<305>",$alg);   $alg = preg_replace("/bl'/","<306>",$alg);   $alg = preg_replace("/bl2/","<307>",$alg);      $alg = preg_replace("/bl/","<308>",$alg);
    $alg = preg_replace("/fr2'/","<309>",$alg);   $alg = preg_replace("/fr'/","<310>",$alg);   $alg = preg_replace("/fr2/","<311>",$alg);      $alg = preg_replace("/fr/","<312>",$alg);
    $alg = preg_replace("/fl2'/","<313>",$alg);   $alg = preg_replace("/fl'/","<314>",$alg);   $alg = preg_replace("/fl2/","<315>",$alg);      $alg = preg_replace("/fl/","<316>",$alg);
    $alg = preg_replace("/dr2'/","<317>",$alg);   $alg = preg_replace("/dr'/","<318>",$alg);   $alg = preg_replace("/dr2/","<319>",$alg);      $alg = preg_replace("/dr/","<320>",$alg);
    $alg = preg_replace("/dl2'/","<321>",$alg);   $alg = preg_replace("/dl'/","<322>",$alg);   $alg = preg_replace("/dl2/","<323>",$alg);      $alg = preg_replace("/dl/","<324>",$alg);
    
    $alg = preg_replace("/r2'/","<325>",$alg);    $alg = preg_replace("/r'/","<326>",$alg);    $alg = preg_replace("/r2/","<327>",$alg);       $alg = preg_replace("/r/","<328>",$alg);
    $alg = preg_replace("/l2'/","<329>",$alg);    $alg = preg_replace("/l'/","<330>",$alg);    $alg = preg_replace("/l2/","<331>",$alg);       $alg = preg_replace("/l/","<332>",$alg);
    $alg = preg_replace("/f2'/","<333>",$alg);    $alg = preg_replace("/f'/","<334>",$alg);    $alg = preg_replace("/f2/","<335>",$alg);       $alg = preg_replace("/f/","<336>",$alg);
    $alg = preg_replace("/b2'/","<337>",$alg);    $alg = preg_replace("/b'/","<338>",$alg);    $alg = preg_replace("/b2/","<339>",$alg);       $alg = preg_replace("/b/","<340>",$alg);
    $alg = preg_replace("/u2'/","<341>",$alg);    $alg = preg_replace("/u'/","<342>",$alg);    $alg = preg_replace("/u2/","<343>",$alg);       $alg = preg_replace("/u/","<344>",$alg);
    $alg = preg_replace("/d2'/","<345>",$alg);    $alg = preg_replace("/d'/","<346>",$alg);    $alg = preg_replace("/d2/","<347>",$alg);       $alg = preg_replace("/d/","<348>",$alg);
    
    /* ··································································································· */
    /* --- 3xD: CODE -> SSE: [5] Mid-layer [1] (Numbered layer) [6] (Wide) twists --- */
    $alg = preg_replace("/<101>/","MUR2'",$alg);   $alg = preg_replace("/<102>/","MUR'",$alg);   $alg = preg_replace("/<103>/","MUR2",$alg);   $alg = preg_replace("/<104>/","MUR",$alg);
    $alg = preg_replace("/<105>/","MUL2'",$alg);   $alg = preg_replace("/<106>/","MUL'",$alg);   $alg = preg_replace("/<107>/","MUL2",$alg);   $alg = preg_replace("/<108>/","MUL",$alg);
    $alg = preg_replace("/<109>/","MDR2'",$alg);   $alg = preg_replace("/<110>/","MDR'",$alg);   $alg = preg_replace("/<111>/","MDR2",$alg);   $alg = preg_replace("/<112>/","MDR",$alg);
    $alg = preg_replace("/<113>/","MDL2'",$alg);   $alg = preg_replace("/<114>/","MDL'",$alg);   $alg = preg_replace("/<115>/","MDL2",$alg);   $alg = preg_replace("/<116>/","MDL",$alg);
    $alg = preg_replace("/<117>/","MBR2'",$alg);   $alg = preg_replace("/<118>/","MBR'",$alg);   $alg = preg_replace("/<119>/","MBR2",$alg);   $alg = preg_replace("/<120>/","MBR",$alg);
    $alg = preg_replace("/<121>/","MBL2'",$alg);   $alg = preg_replace("/<122>/","MBL'",$alg);   $alg = preg_replace("/<123>/","MBL2",$alg);   $alg = preg_replace("/<124>/","MBL",$alg);
    
    $alg = preg_replace("/<125>/","MR2'",$alg);    $alg = preg_replace("/<126>/","MR'",$alg);    $alg = preg_replace("/<127>/","MR2",$alg);    $alg = preg_replace("/<128>/","MR",$alg);
    $alg = preg_replace("/<129>/","ML2'",$alg);    $alg = preg_replace("/<130>/","ML'",$alg);    $alg = preg_replace("/<131>/","ML2",$alg);    $alg = preg_replace("/<132>/","ML",$alg);
    $alg = preg_replace("/<133>/","MF2'",$alg);    $alg = preg_replace("/<134>/","MF'",$alg);    $alg = preg_replace("/<135>/","MF2",$alg);    $alg = preg_replace("/<136>/","MF",$alg);
    $alg = preg_replace("/<137>/","MB2'",$alg);    $alg = preg_replace("/<138>/","MB'",$alg);    $alg = preg_replace("/<139>/","MB2",$alg);    $alg = preg_replace("/<140>/","MB",$alg);
    $alg = preg_replace("/<141>/","MU2'",$alg);    $alg = preg_replace("/<142>/","MU'",$alg);    $alg = preg_replace("/<143>/","MU2",$alg);    $alg = preg_replace("/<144>/","MU",$alg);
    $alg = preg_replace("/<145>/","MD2'",$alg);    $alg = preg_replace("/<146>/","MD'",$alg);    $alg = preg_replace("/<147>/","MD2",$alg);    $alg = preg_replace("/<148>/","MD",$alg);
    
    /* --- 3xD: CODE -> SSE: [7] Dodecahedron rotations --- */
    $alg = preg_replace("/<701>/","CUR2'",$alg);   $alg = preg_replace("/<702>/","CUR'",$alg);   $alg = preg_replace("/<703>/","CUR2",$alg);   $alg = preg_replace("/<704>/","CUR",$alg);
    $alg = preg_replace("/<705>/","CUL2'",$alg);   $alg = preg_replace("/<706>/","CUL'",$alg);   $alg = preg_replace("/<707>/","CUL2",$alg);   $alg = preg_replace("/<708>/","CUL",$alg);
    $alg = preg_replace("/<709>/","CDR2'",$alg);   $alg = preg_replace("/<710>/","CDR'",$alg);   $alg = preg_replace("/<711>/","CDR2",$alg);   $alg = preg_replace("/<712>/","CDR",$alg);
    $alg = preg_replace("/<713>/","CDL2'",$alg);   $alg = preg_replace("/<714>/","CDL'",$alg);   $alg = preg_replace("/<715>/","CDL2",$alg);   $alg = preg_replace("/<716>/","CDL",$alg);
    $alg = preg_replace("/<717>/","CBR2'",$alg);   $alg = preg_replace("/<718>/","CBR'",$alg);   $alg = preg_replace("/<719>/","CBR2",$alg);   $alg = preg_replace("/<720>/","CBR",$alg);
    $alg = preg_replace("/<721>/","CBL2'",$alg);   $alg = preg_replace("/<722>/","CBL'",$alg);   $alg = preg_replace("/<723>/","CBL2",$alg);   $alg = preg_replace("/<724>/","CBL",$alg);
    
    $alg = preg_replace("/<725>/","CR2'",$alg);    $alg = preg_replace("/<726>/","CR'",$alg);    $alg = preg_replace("/<727>/","CR2",$alg);    $alg = preg_replace("/<728>/","CR",$alg);
    $alg = preg_replace("/<729>/","CL2'",$alg);    $alg = preg_replace("/<730>/","CL'",$alg);    $alg = preg_replace("/<731>/","CL2",$alg);    $alg = preg_replace("/<732>/","CL",$alg);
    $alg = preg_replace("/<733>/","CF2'",$alg);    $alg = preg_replace("/<734>/","CF'",$alg);    $alg = preg_replace("/<735>/","CF2",$alg);    $alg = preg_replace("/<736>/","CF",$alg);
    $alg = preg_replace("/<737>/","CB2'",$alg);    $alg = preg_replace("/<738>/","CB'",$alg);    $alg = preg_replace("/<739>/","CB2",$alg);    $alg = preg_replace("/<740>/","CB",$alg);
    $alg = preg_replace("/<741>/","CU2'",$alg);    $alg = preg_replace("/<742>/","CU'",$alg);    $alg = preg_replace("/<743>/","CU2",$alg);    $alg = preg_replace("/<744>/","CU",$alg);
    $alg = preg_replace("/<745>/","CD2'",$alg);    $alg = preg_replace("/<746>/","CD'",$alg);    $alg = preg_replace("/<747>/","CD2",$alg);    $alg = preg_replace("/<748>/","CD",$alg);
    
    /* --- 3xD: CODE -> SSE: [9] Face twists --- */
    $alg = preg_replace("/<901>/","UR2'",$alg);   $alg = preg_replace("/<902>/","UR'",$alg);   $alg = preg_replace("/<903>/","UR2",$alg);   $alg = preg_replace("/<904>/","UR",$alg);
    $alg = preg_replace("/<905>/","UL2'",$alg);   $alg = preg_replace("/<906>/","UL'",$alg);   $alg = preg_replace("/<907>/","UL2",$alg);   $alg = preg_replace("/<908>/","UL",$alg);
    $alg = preg_replace("/<909>/","DR2'",$alg);   $alg = preg_replace("/<910>/","DR'",$alg);   $alg = preg_replace("/<911>/","DR2",$alg);   $alg = preg_replace("/<912>/","DR",$alg);
    $alg = preg_replace("/<913>/","DL2'",$alg);   $alg = preg_replace("/<914>/","DL'",$alg);   $alg = preg_replace("/<915>/","DL2",$alg);   $alg = preg_replace("/<916>/","DL",$alg);
    $alg = preg_replace("/<917>/","BR2'",$alg);   $alg = preg_replace("/<918>/","BR'",$alg);   $alg = preg_replace("/<919>/","BR2",$alg);   $alg = preg_replace("/<920>/","BR",$alg);
    $alg = preg_replace("/<921>/","BL2'",$alg);   $alg = preg_replace("/<922>/","BL'",$alg);   $alg = preg_replace("/<923>/","BL2",$alg);   $alg = preg_replace("/<924>/","BL",$alg);
    
    $alg = preg_replace("/<925>/","R2'",$alg);    $alg = preg_replace("/<926>/","R'",$alg);    $alg = preg_replace("/<927>/","R2",$alg);    $alg = preg_replace("/<928>/","R",$alg);
    $alg = preg_replace("/<929>/","L2'",$alg);    $alg = preg_replace("/<930>/","L'",$alg);    $alg = preg_replace("/<931>/","L2",$alg);    $alg = preg_replace("/<932>/","L",$alg);
    $alg = preg_replace("/<933>/","F2'",$alg);    $alg = preg_replace("/<934>/","F'",$alg);    $alg = preg_replace("/<935>/","F2",$alg);    $alg = preg_replace("/<936>/","F",$alg);
    $alg = preg_replace("/<937>/","B2'",$alg);    $alg = preg_replace("/<938>/","B'",$alg);    $alg = preg_replace("/<939>/","B2",$alg);    $alg = preg_replace("/<940>/","B",$alg);
    $alg = preg_replace("/<941>/","U2'",$alg);    $alg = preg_replace("/<942>/","U'",$alg);    $alg = preg_replace("/<943>/","U2",$alg);    $alg = preg_replace("/<944>/","U",$alg);
    $alg = preg_replace("/<945>/","D2'",$alg);    $alg = preg_replace("/<946>/","D'",$alg);    $alg = preg_replace("/<947>/","D2",$alg);    $alg = preg_replace("/<948>/","D",$alg);
    
    /* --- 3xD: CODE -> SSE: [3] Tier twists --- */
    $alg = preg_replace("/<301>/","TUR2'",$alg);   $alg = preg_replace("/<302>/","TUR'",$alg);   $alg = preg_replace("/<303>/","TUR2",$alg);   $alg = preg_replace("/<304>/","TUR",$alg);
    $alg = preg_replace("/<305>/","TUL2'",$alg);   $alg = preg_replace("/<306>/","TUL'",$alg);   $alg = preg_replace("/<307>/","TUL2",$alg);   $alg = preg_replace("/<308>/","TUL",$alg);
    $alg = preg_replace("/<309>/","TDR2'",$alg);   $alg = preg_replace("/<310>/","TDR'",$alg);   $alg = preg_replace("/<311>/","TDR2",$alg);   $alg = preg_replace("/<312>/","TDR",$alg);
    $alg = preg_replace("/<313>/","TDL2'",$alg);   $alg = preg_replace("/<314>/","TDL'",$alg);   $alg = preg_replace("/<315>/","TDL2",$alg);   $alg = preg_replace("/<316>/","TDL",$alg);
    $alg = preg_replace("/<317>/","TBR2'",$alg);   $alg = preg_replace("/<318>/","TBR'",$alg);   $alg = preg_replace("/<319>/","TBR2",$alg);   $alg = preg_replace("/<320>/","TBR",$alg);
    $alg = preg_replace("/<321>/","TBL2'",$alg);   $alg = preg_replace("/<322>/","TBL'",$alg);   $alg = preg_replace("/<323>/","TBL2",$alg);   $alg = preg_replace("/<324>/","TBL",$alg);
    
    $alg = preg_replace("/<325>/","TR2'",$alg);    $alg = preg_replace("/<326>/","TR'",$alg);    $alg = preg_replace("/<327>/","TR2",$alg);    $alg = preg_replace("/<328>/","TR",$alg);
    $alg = preg_replace("/<329>/","TL2'",$alg);    $alg = preg_replace("/<330>/","TL'",$alg);    $alg = preg_replace("/<331>/","TL2",$alg);    $alg = preg_replace("/<332>/","TL",$alg);
    $alg = preg_replace("/<333>/","TF2'",$alg);    $alg = preg_replace("/<334>/","TF'",$alg);    $alg = preg_replace("/<335>/","TF2",$alg);    $alg = preg_replace("/<336>/","TF",$alg);
    $alg = preg_replace("/<337>/","TB2'",$alg);    $alg = preg_replace("/<338>/","TB'",$alg);    $alg = preg_replace("/<339>/","TB2",$alg);    $alg = preg_replace("/<340>/","TB",$alg);
    $alg = preg_replace("/<341>/","TU2'",$alg);    $alg = preg_replace("/<342>/","TU'",$alg);    $alg = preg_replace("/<343>/","TU2",$alg);    $alg = preg_replace("/<344>/","TU",$alg);
    $alg = preg_replace("/<345>/","TD2'",$alg);    $alg = preg_replace("/<346>/","TD'",$alg);    $alg = preg_replace("/<347>/","TD2",$alg);    $alg = preg_replace("/<348>/","TD",$alg);
    
    return $alg;
  }
  
  
  
  
  /* 
  ---------------------------------------------------------------------------------------------------
  * alg5xD_SseToTwizzle($alg)
  * 
  * Converts 5x5 Gigaminx SSE algorithms into TWIZZLE notation.
  * 
  * Parameter: $alg (STRING): The algorithm.
  * 
  * Return: STRING.
  ---------------------------------------------------------------------------------------------------
  */
  function alg5xD_SseToTwizzle($alg) {
    /* --- Dodecahedron Twists --- */
    //   +0°  = R0, []     = -360° = R5', []
    //  +72°  = R1, [R]    = -288° = R4', [R]
    // +144°  = R2, [R2]   = -216° = R3', [R2]
    // +216°  = R3, [R2']  = -144° = R2', [R2']
    // +288°  = R4, [R']   =  -72° = R1', [R']
    // +360°  = R5, []     =   -0° = R0', []
    
    /* --- 5xD: Preferences --- */
    $useMarkers = false; // 01.04.2021: Unfortunately Twizzle Explorer doesn't handle Markers correctly!
    
    /* --- 5xD: Marker --- */
    if ($useMarkers != true) {
      $alg = str_replace("·","",$alg); $alg = str_replace(".","",$alg); // Remove Markers!
    } else {
      $alg = str_replace("·",".",$alg);
    }
    
    /* ··································································································· */
    /* --- 5xD: SSE -> CODE: [1] Numbered layer twists --- */
    $alg = preg_replace("/NUR2'/","<101>",$alg); $alg = preg_replace("/NUR2-/","<101>",$alg);   $alg = preg_replace("/NUR'/","<102>",$alg); $alg = preg_replace("/NUR-/","<102>",$alg);   $alg = preg_replace("/NUR2/","<103>",$alg);   $alg = preg_replace("/NUR/","<104>",$alg);
    $alg = preg_replace("/NUL2'/","<105>",$alg); $alg = preg_replace("/NUL2-/","<105>",$alg);   $alg = preg_replace("/NUL'/","<106>",$alg); $alg = preg_replace("/NUL-/","<106>",$alg);   $alg = preg_replace("/NUL2/","<107>",$alg);   $alg = preg_replace("/NUL/","<108>",$alg);
    $alg = preg_replace("/NDR2'/","<109>",$alg); $alg = preg_replace("/NDR2-/","<109>",$alg);   $alg = preg_replace("/NDR'/","<110>",$alg); $alg = preg_replace("/NDR-/","<110>",$alg);   $alg = preg_replace("/NDR2/","<111>",$alg);   $alg = preg_replace("/NDR/","<112>",$alg);
    $alg = preg_replace("/NDL2'/","<113>",$alg); $alg = preg_replace("/NDL2-/","<113>",$alg);   $alg = preg_replace("/NDL'/","<114>",$alg); $alg = preg_replace("/NDL-/","<114>",$alg);   $alg = preg_replace("/NDL2/","<115>",$alg);   $alg = preg_replace("/NDL/","<116>",$alg);
    $alg = preg_replace("/NBR2'/","<117>",$alg); $alg = preg_replace("/NBR2-/","<117>",$alg);   $alg = preg_replace("/NBR'/","<118>",$alg); $alg = preg_replace("/NBR-/","<118>",$alg);   $alg = preg_replace("/NBR2/","<119>",$alg);   $alg = preg_replace("/NBR/","<120>",$alg);
    $alg = preg_replace("/NBL2'/","<121>",$alg); $alg = preg_replace("/NBL2-/","<121>",$alg);   $alg = preg_replace("/NBL'/","<122>",$alg); $alg = preg_replace("/NBL-/","<122>",$alg);   $alg = preg_replace("/NBL2/","<123>",$alg);   $alg = preg_replace("/NBL/","<124>",$alg);
    
    $alg = preg_replace("/NR2'/","<125>",$alg); $alg = preg_replace("/NR2-/","<125>",$alg);     $alg = preg_replace("/NR'/","<126>",$alg); $alg = preg_replace("/NR-/","<126>",$alg);     $alg = preg_replace("/NR2/","<127>",$alg);    $alg = preg_replace("/NR/","<128>",$alg);
    $alg = preg_replace("/NL2'/","<129>",$alg); $alg = preg_replace("/NL2-/","<129>",$alg);     $alg = preg_replace("/NL'/","<130>",$alg); $alg = preg_replace("/NL-/","<130>",$alg);     $alg = preg_replace("/NL2/","<131>",$alg);    $alg = preg_replace("/NL/","<132>",$alg);
    $alg = preg_replace("/NF2'/","<133>",$alg); $alg = preg_replace("/NF2-/","<133>",$alg);     $alg = preg_replace("/NF'/","<134>",$alg); $alg = preg_replace("/NF-/","<134>",$alg);     $alg = preg_replace("/NF2/","<135>",$alg);    $alg = preg_replace("/NF/","<136>",$alg);
    $alg = preg_replace("/NB2'/","<137>",$alg); $alg = preg_replace("/NB2-/","<137>",$alg);     $alg = preg_replace("/NB'/","<138>",$alg); $alg = preg_replace("/NB-/","<138>",$alg);     $alg = preg_replace("/NB2/","<139>",$alg);    $alg = preg_replace("/NB/","<140>",$alg);
    $alg = preg_replace("/NU2'/","<141>",$alg); $alg = preg_replace("/NU2-/","<141>",$alg);     $alg = preg_replace("/NU'/","<142>",$alg); $alg = preg_replace("/NU-/","<142>",$alg);     $alg = preg_replace("/NU2/","<143>",$alg);    $alg = preg_replace("/NU/","<144>",$alg);
    $alg = preg_replace("/ND2'/","<145>",$alg); $alg = preg_replace("/ND2-/","<145>",$alg);     $alg = preg_replace("/ND'/","<146>",$alg); $alg = preg_replace("/ND-/","<146>",$alg);     $alg = preg_replace("/ND2/","<147>",$alg);    $alg = preg_replace("/ND/","<148>",$alg);
    
    $alg = preg_replace("/N4UR2'/","<115>",$alg); $alg = preg_replace("/N4UR2-/","<115>",$alg);   $alg = preg_replace("/N4UR'/","<116>",$alg); $alg = preg_replace("/N4UR-/","<116>",$alg);   $alg = preg_replace("/N4UR2/","<113>",$alg);   $alg = preg_replace("/N4UR/","<114>",$alg);
    $alg = preg_replace("/N4UL2'/","<111>",$alg); $alg = preg_replace("/N4UL2-/","<111>",$alg);   $alg = preg_replace("/N4UL'/","<112>",$alg); $alg = preg_replace("/N4UL-/","<112>",$alg);   $alg = preg_replace("/N4UL2/","<109>",$alg);   $alg = preg_replace("/N4UL/","<110>",$alg);
    $alg = preg_replace("/N4DR2'/","<107>",$alg); $alg = preg_replace("/N4DR2-/","<107>",$alg);   $alg = preg_replace("/N4DR'/","<108>",$alg); $alg = preg_replace("/N4DR-/","<108>",$alg);   $alg = preg_replace("/N4DR2/","<105>",$alg);   $alg = preg_replace("/N4DR/","<106>",$alg);
    $alg = preg_replace("/N4DL2'/","<103>",$alg); $alg = preg_replace("/N4DL2-/","<103>",$alg);   $alg = preg_replace("/N4DL'/","<104>",$alg); $alg = preg_replace("/N4DL-/","<104>",$alg);   $alg = preg_replace("/N4DL2/","<101>",$alg);   $alg = preg_replace("/N4DL/","<102>",$alg);
    $alg = preg_replace("/N4BR2'/","<131>",$alg); $alg = preg_replace("/N4BR2-/","<131>",$alg);   $alg = preg_replace("/N4BR'/","<132>",$alg); $alg = preg_replace("/N4BR-/","<132>",$alg);   $alg = preg_replace("/N4BR2/","<129>",$alg);   $alg = preg_replace("/N4BR/","<130>",$alg);
    $alg = preg_replace("/N4BL2'/","<127>",$alg); $alg = preg_replace("/N4BL2-/","<127>",$alg);   $alg = preg_replace("/N4BL'/","<128>",$alg); $alg = preg_replace("/N4BL-/","<128>",$alg);   $alg = preg_replace("/N4BL2/","<125>",$alg);   $alg = preg_replace("/N4BL/","<126>",$alg);
    
    $alg = preg_replace("/N4R2'/","<123>",$alg); $alg = preg_replace("/N4R2-/","<123>",$alg);     $alg = preg_replace("/N4R'/","<124>",$alg); $alg = preg_replace("/N4R-/","<124>",$alg);     $alg = preg_replace("/N4R2/","<121>",$alg);    $alg = preg_replace("/N4R/","<122>",$alg);
    $alg = preg_replace("/N4L2'/","<119>",$alg); $alg = preg_replace("/N4L2-/","<119>",$alg);     $alg = preg_replace("/N4L'/","<120>",$alg); $alg = preg_replace("/N4L-/","<120>",$alg);     $alg = preg_replace("/N4L2/","<117>",$alg);    $alg = preg_replace("/N4L/","<118>",$alg);
    $alg = preg_replace("/N4F2'/","<139>",$alg); $alg = preg_replace("/N4F2-/","<139>",$alg);     $alg = preg_replace("/N4F'/","<140>",$alg); $alg = preg_replace("/N4F-/","<140>",$alg);     $alg = preg_replace("/N4F2/","<137>",$alg);    $alg = preg_replace("/N4F/","<138>",$alg);
    $alg = preg_replace("/N4B2'/","<135>",$alg); $alg = preg_replace("/N4B2-/","<135>",$alg);     $alg = preg_replace("/N4B'/","<136>",$alg); $alg = preg_replace("/N4B-/","<136>",$alg);     $alg = preg_replace("/N4B2/","<133>",$alg);    $alg = preg_replace("/N4B/","<134>",$alg);
    $alg = preg_replace("/N4U2'/","<147>",$alg); $alg = preg_replace("/N4U2-/","<147>",$alg);     $alg = preg_replace("/N4U'/","<148>",$alg); $alg = preg_replace("/N4U-/","<148>",$alg);     $alg = preg_replace("/N4U2/","<145>",$alg);    $alg = preg_replace("/N4U/","<146>",$alg);
    $alg = preg_replace("/N4D2'/","<143>",$alg); $alg = preg_replace("/N4D2-/","<143>",$alg);     $alg = preg_replace("/N4D'/","<144>",$alg); $alg = preg_replace("/N4D-/","<144>",$alg);     $alg = preg_replace("/N4D2/","<141>",$alg);    $alg = preg_replace("/N4D/","<142>",$alg);
    
    $alg = preg_replace("/N3UR2'/","<149>",$alg); $alg = preg_replace("/N3UR2-/","<149>",$alg);   $alg = preg_replace("/N3UR'/","<150>",$alg); $alg = preg_replace("/N3UR-/","<150>",$alg);   $alg = preg_replace("/N3UR2/","<151>",$alg);   $alg = preg_replace("/N3UR/","<152>",$alg);
    $alg = preg_replace("/N3UL2'/","<153>",$alg); $alg = preg_replace("/N3UL2-/","<153>",$alg);   $alg = preg_replace("/N3UL'/","<154>",$alg); $alg = preg_replace("/N3UL-/","<154>",$alg);   $alg = preg_replace("/N3UL2/","<155>",$alg);   $alg = preg_replace("/N3UL/","<156>",$alg);
    $alg = preg_replace("/N3DR2'/","<157>",$alg); $alg = preg_replace("/N3DR2-/","<157>",$alg);   $alg = preg_replace("/N3DR'/","<158>",$alg); $alg = preg_replace("/N3DR-/","<158>",$alg);   $alg = preg_replace("/N3DR2/","<159>",$alg);   $alg = preg_replace("/N3DR/","<160>",$alg);
    $alg = preg_replace("/N3DL2'/","<161>",$alg); $alg = preg_replace("/N3DL2-/","<161>",$alg);   $alg = preg_replace("/N3DL'/","<162>",$alg); $alg = preg_replace("/N3DL-/","<162>",$alg);   $alg = preg_replace("/N3DL2/","<163>",$alg);   $alg = preg_replace("/N3DL/","<164>",$alg);
    $alg = preg_replace("/N3BR2'/","<165>",$alg); $alg = preg_replace("/N3BR2-/","<165>",$alg);   $alg = preg_replace("/N3BR'/","<166>",$alg); $alg = preg_replace("/N3BR-/","<166>",$alg);   $alg = preg_replace("/N3BR2/","<167>",$alg);   $alg = preg_replace("/N3BR/","<168>",$alg);
    $alg = preg_replace("/N3BL2'/","<169>",$alg); $alg = preg_replace("/N3BL2-/","<169>",$alg);   $alg = preg_replace("/N3BL'/","<170>",$alg); $alg = preg_replace("/N3BL-/","<170>",$alg);   $alg = preg_replace("/N3BL2/","<171>",$alg);   $alg = preg_replace("/N3BL/","<172>",$alg);
    
    $alg = preg_replace("/N3R2'/","<173>",$alg); $alg = preg_replace("/N3R2-/","<173>",$alg);     $alg = preg_replace("/N3R'/","<174>",$alg); $alg = preg_replace("/N3R-/","<174>",$alg);     $alg = preg_replace("/N3R2/","<175>",$alg);    $alg = preg_replace("/N3R/","<176>",$alg);
    $alg = preg_replace("/N3L2'/","<177>",$alg); $alg = preg_replace("/N3L2-/","<177>",$alg);     $alg = preg_replace("/N3L'/","<178>",$alg); $alg = preg_replace("/N3L-/","<178>",$alg);     $alg = preg_replace("/N3L2/","<179>",$alg);    $alg = preg_replace("/N3L/","<180>",$alg);
    $alg = preg_replace("/N3F2'/","<181>",$alg); $alg = preg_replace("/N3F2-/","<181>",$alg);     $alg = preg_replace("/N3F'/","<182>",$alg); $alg = preg_replace("/N3F-/","<182>",$alg);     $alg = preg_replace("/N3F2/","<183>",$alg);    $alg = preg_replace("/N3F/","<184>",$alg);
    $alg = preg_replace("/N3B2'/","<185>",$alg); $alg = preg_replace("/N3B2-/","<185>",$alg);     $alg = preg_replace("/N3B'/","<186>",$alg); $alg = preg_replace("/N3B-/","<186>",$alg);     $alg = preg_replace("/N3B2/","<187>",$alg);    $alg = preg_replace("/N3B/","<188>",$alg);
    $alg = preg_replace("/N3U2'/","<189>",$alg); $alg = preg_replace("/N3U2-/","<189>",$alg);     $alg = preg_replace("/N3U'/","<190>",$alg); $alg = preg_replace("/N3U-/","<190>",$alg);     $alg = preg_replace("/N3U2/","<191>",$alg);    $alg = preg_replace("/N3U/","<192>",$alg);
    $alg = preg_replace("/N3D2'/","<193>",$alg); $alg = preg_replace("/N3D2-/","<193>",$alg);     $alg = preg_replace("/N3D'/","<194>",$alg); $alg = preg_replace("/N3D-/","<194>",$alg);     $alg = preg_replace("/N3D2/","<195>",$alg);    $alg = preg_replace("/N3D/","<196>",$alg);
    
    $alg = preg_replace("/MUR2'/","<149>",$alg); $alg = preg_replace("/MUR2-/","<149>",$alg);   $alg = preg_replace("/MUR'/","<150>",$alg); $alg = preg_replace("/MUR-/","<150>",$alg);   $alg = preg_replace("/MUR2/","<151>",$alg);   $alg = preg_replace("/MUR/","<152>",$alg);
    $alg = preg_replace("/MUL2'/","<153>",$alg); $alg = preg_replace("/MUL2-/","<153>",$alg);   $alg = preg_replace("/MUL'/","<154>",$alg); $alg = preg_replace("/MUL-/","<154>",$alg);   $alg = preg_replace("/MUL2/","<155>",$alg);   $alg = preg_replace("/MUL/","<156>",$alg);
    $alg = preg_replace("/MDR2'/","<157>",$alg); $alg = preg_replace("/MDR2-/","<157>",$alg);   $alg = preg_replace("/MDR'/","<158>",$alg); $alg = preg_replace("/MDR-/","<158>",$alg);   $alg = preg_replace("/MDR2/","<159>",$alg);   $alg = preg_replace("/MDR/","<160>",$alg);
    $alg = preg_replace("/MDL2'/","<161>",$alg); $alg = preg_replace("/MDL2-/","<161>",$alg);   $alg = preg_replace("/MDL'/","<162>",$alg); $alg = preg_replace("/MDL-/","<162>",$alg);   $alg = preg_replace("/MDL2/","<163>",$alg);   $alg = preg_replace("/MDL/","<164>",$alg);
    $alg = preg_replace("/MBR2'/","<165>",$alg); $alg = preg_replace("/MBR2-/","<165>",$alg);   $alg = preg_replace("/MBR'/","<166>",$alg); $alg = preg_replace("/MBR-/","<166>",$alg);   $alg = preg_replace("/MBR2/","<167>",$alg);   $alg = preg_replace("/MBR/","<168>",$alg);
    $alg = preg_replace("/MBL2'/","<169>",$alg); $alg = preg_replace("/MBL2-/","<169>",$alg);   $alg = preg_replace("/MBL'/","<170>",$alg); $alg = preg_replace("/MBL-/","<170>",$alg);   $alg = preg_replace("/MBL2/","<171>",$alg);   $alg = preg_replace("/MBL/","<172>",$alg);
    
    $alg = preg_replace("/MR2'/","<173>",$alg); $alg = preg_replace("/MR2-/","<173>",$alg);     $alg = preg_replace("/MR'/","<174>",$alg); $alg = preg_replace("/MR-/","<174>",$alg);     $alg = preg_replace("/MR2/","<175>",$alg);    $alg = preg_replace("/MR/","<176>",$alg);
    $alg = preg_replace("/ML2'/","<177>",$alg); $alg = preg_replace("/ML2-/","<177>",$alg);     $alg = preg_replace("/ML'/","<178>",$alg); $alg = preg_replace("/ML-/","<178>",$alg);     $alg = preg_replace("/ML2/","<179>",$alg);    $alg = preg_replace("/ML/","<180>",$alg);
    $alg = preg_replace("/MF2'/","<181>",$alg); $alg = preg_replace("/MF2-/","<181>",$alg);     $alg = preg_replace("/MF'/","<182>",$alg); $alg = preg_replace("/MF-/","<182>",$alg);     $alg = preg_replace("/MF2/","<183>",$alg);    $alg = preg_replace("/MF/","<184>",$alg);
    $alg = preg_replace("/MB2'/","<185>",$alg); $alg = preg_replace("/MB2-/","<185>",$alg);     $alg = preg_replace("/MB'/","<186>",$alg); $alg = preg_replace("/MB-/","<186>",$alg);     $alg = preg_replace("/MB2/","<187>",$alg);    $alg = preg_replace("/MB/","<188>",$alg);
    $alg = preg_replace("/MU2'/","<189>",$alg); $alg = preg_replace("/MU2-/","<189>",$alg);     $alg = preg_replace("/MU'/","<190>",$alg); $alg = preg_replace("/MU-/","<190>",$alg);     $alg = preg_replace("/MU2/","<191>",$alg);    $alg = preg_replace("/MU/","<192>",$alg);
    $alg = preg_replace("/MD2'/","<193>",$alg); $alg = preg_replace("/MD2-/","<193>",$alg);     $alg = preg_replace("/MD'/","<194>",$alg); $alg = preg_replace("/MD-/","<194>",$alg);     $alg = preg_replace("/MD2/","<195>",$alg);    $alg = preg_replace("/MD/","<196>",$alg);
    
    /* --- 5xD: SSE -> CODE: [2] Slice twists --- */
    $alg = preg_replace("/S2UR2'/","<201>",$alg); $alg = preg_replace("/S2UR2-/","<201>",$alg);   $alg = preg_replace("/S2UR'/","<202>",$alg); $alg = preg_replace("/S2UR-/","<202>",$alg);   $alg = preg_replace("/S2UR2/","<203>",$alg);   $alg = preg_replace("/S2UR/","<204>",$alg);
    $alg = preg_replace("/S2UL2'/","<205>",$alg); $alg = preg_replace("/S2UL2-/","<205>",$alg);   $alg = preg_replace("/S2UL'/","<206>",$alg); $alg = preg_replace("/S2UL-/","<206>",$alg);   $alg = preg_replace("/S2UL2/","<207>",$alg);   $alg = preg_replace("/S2UL/","<208>",$alg);
    $alg = preg_replace("/S2DR2'/","<209>",$alg); $alg = preg_replace("/S2DR2-/","<209>",$alg);   $alg = preg_replace("/S2DR'/","<210>",$alg); $alg = preg_replace("/S2DR-/","<210>",$alg);   $alg = preg_replace("/S2DR2/","<211>",$alg);   $alg = preg_replace("/S2DR/","<212>",$alg);
    $alg = preg_replace("/S2DL2'/","<213>",$alg); $alg = preg_replace("/S2DL2-/","<213>",$alg);   $alg = preg_replace("/S2DL'/","<214>",$alg); $alg = preg_replace("/S2DL-/","<214>",$alg);   $alg = preg_replace("/S2DL2/","<215>",$alg);   $alg = preg_replace("/S2DL/","<216>",$alg);
    $alg = preg_replace("/S2BR2'/","<217>",$alg); $alg = preg_replace("/S2BR2-/","<217>",$alg);   $alg = preg_replace("/S2BR'/","<218>",$alg); $alg = preg_replace("/S2BR-/","<218>",$alg);   $alg = preg_replace("/S2BR2/","<219>",$alg);   $alg = preg_replace("/S2BR/","<220>",$alg);
    $alg = preg_replace("/S2BL2'/","<221>",$alg); $alg = preg_replace("/S2BL2-/","<221>",$alg);   $alg = preg_replace("/S2BL'/","<222>",$alg); $alg = preg_replace("/S2BL-/","<222>",$alg);   $alg = preg_replace("/S2BL2/","<223>",$alg);   $alg = preg_replace("/S2BL/","<224>",$alg);
    
    $alg = preg_replace("/S2R2'/","<225>",$alg); $alg = preg_replace("/S2R2-/","<225>",$alg);     $alg = preg_replace("/S2R'/","<226>",$alg);  $alg = preg_replace("/S2R-/","<226>",$alg);    $alg = preg_replace("/S2R2/","<227>",$alg);    $alg = preg_replace("/S2R/","<228>",$alg);
    $alg = preg_replace("/S2L2'/","<229>",$alg); $alg = preg_replace("/S2L2-/","<229>",$alg);     $alg = preg_replace("/S2L'/","<230>",$alg);  $alg = preg_replace("/S2L-/","<230>",$alg);    $alg = preg_replace("/S2L2/","<231>",$alg);    $alg = preg_replace("/S2L/","<232>",$alg);
    $alg = preg_replace("/S2F2'/","<233>",$alg); $alg = preg_replace("/S2F2-/","<233>",$alg);     $alg = preg_replace("/S2F'/","<234>",$alg);  $alg = preg_replace("/S2F-/","<234>",$alg);    $alg = preg_replace("/S2F2/","<235>",$alg);    $alg = preg_replace("/S2F/","<236>",$alg);
    $alg = preg_replace("/S2B2'/","<237>",$alg); $alg = preg_replace("/S2B2-/","<237>",$alg);     $alg = preg_replace("/S2B'/","<238>",$alg);  $alg = preg_replace("/S2B-/","<238>",$alg);    $alg = preg_replace("/S2B2/","<239>",$alg);    $alg = preg_replace("/S2B/","<240>",$alg);
    $alg = preg_replace("/S2U2'/","<241>",$alg); $alg = preg_replace("/S2U2-/","<241>",$alg);     $alg = preg_replace("/S2U'/","<242>",$alg);  $alg = preg_replace("/S2U-/","<242>",$alg);    $alg = preg_replace("/S2U2/","<243>",$alg);    $alg = preg_replace("/S2U/","<244>",$alg);
    $alg = preg_replace("/S2D2'/","<245>",$alg); $alg = preg_replace("/S2D2-/","<245>",$alg);     $alg = preg_replace("/S2D'/","<246>",$alg);  $alg = preg_replace("/S2D-/","<246>",$alg);    $alg = preg_replace("/S2D2/","<247>",$alg);    $alg = preg_replace("/S2D/","<248>",$alg);
    
    $alg = preg_replace("/SUR2'/","<249>",$alg); $alg = preg_replace("/SUR2-/","<249>",$alg);   $alg = preg_replace("/SUR'/","<250>",$alg); $alg = preg_replace("/SUR-/","<250>",$alg);   $alg = preg_replace("/SUR2/","<251>",$alg);   $alg = preg_replace("/SUR/","<252>",$alg);
    $alg = preg_replace("/SUL2'/","<253>",$alg); $alg = preg_replace("/SUL2-/","<253>",$alg);   $alg = preg_replace("/SUL'/","<254>",$alg); $alg = preg_replace("/SUL-/","<254>",$alg);   $alg = preg_replace("/SUL2/","<255>",$alg);   $alg = preg_replace("/SUL/","<256>",$alg);
    $alg = preg_replace("/SDR2'/","<257>",$alg); $alg = preg_replace("/SDR2-/","<257>",$alg);   $alg = preg_replace("/SDR'/","<258>",$alg); $alg = preg_replace("/SDR-/","<258>",$alg);   $alg = preg_replace("/SDR2/","<259>",$alg);   $alg = preg_replace("/SDR/","<260>",$alg);
    $alg = preg_replace("/SDL2'/","<261>",$alg); $alg = preg_replace("/SDL2-/","<261>",$alg);   $alg = preg_replace("/SDL'/","<262>",$alg); $alg = preg_replace("/SDL-/","<262>",$alg);   $alg = preg_replace("/SDL2/","<263>",$alg);   $alg = preg_replace("/SDL/","<264>",$alg);
    $alg = preg_replace("/SBR2'/","<265>",$alg); $alg = preg_replace("/SBR2-/","<265>",$alg);   $alg = preg_replace("/SBR'/","<266>",$alg); $alg = preg_replace("/SBR-/","<266>",$alg);   $alg = preg_replace("/SBR2/","<267>",$alg);   $alg = preg_replace("/SBR/","<268>",$alg);
    $alg = preg_replace("/SBL2'/","<269>",$alg); $alg = preg_replace("/SBL2-/","<269>",$alg);   $alg = preg_replace("/SBL'/","<270>",$alg); $alg = preg_replace("/SBL-/","<270>",$alg);   $alg = preg_replace("/SBL2/","<271>",$alg);   $alg = preg_replace("/SBL/","<272>",$alg);
    
    $alg = preg_replace("/SR2'/","<273>",$alg); $alg = preg_replace("/SR2-/","<273>",$alg);     $alg = preg_replace("/SR'/","<274>",$alg); $alg = preg_replace("/SR-/","<274>",$alg);     $alg = preg_replace("/SR2/","<275>",$alg);    $alg = preg_replace("/SR/","<276>",$alg);
    $alg = preg_replace("/SL2'/","<277>",$alg); $alg = preg_replace("/SL2-/","<277>",$alg);     $alg = preg_replace("/SL'/","<278>",$alg); $alg = preg_replace("/SL-/","<278>",$alg);     $alg = preg_replace("/SL2/","<279>",$alg);    $alg = preg_replace("/SL/","<280>",$alg);
    $alg = preg_replace("/SF2'/","<281>",$alg); $alg = preg_replace("/SF2-/","<281>",$alg);     $alg = preg_replace("/SF'/","<282>",$alg); $alg = preg_replace("/SF-/","<282>",$alg);     $alg = preg_replace("/SF2/","<283>",$alg);    $alg = preg_replace("/SF/","<284>",$alg);
    $alg = preg_replace("/SB2'/","<285>",$alg); $alg = preg_replace("/SB2-/","<285>",$alg);     $alg = preg_replace("/SB'/","<286>",$alg); $alg = preg_replace("/SB-/","<286>",$alg);     $alg = preg_replace("/SB2/","<287>",$alg);    $alg = preg_replace("/SB/","<288>",$alg);
    $alg = preg_replace("/SU2'/","<289>",$alg); $alg = preg_replace("/SU2-/","<289>",$alg);     $alg = preg_replace("/SU'/","<290>",$alg); $alg = preg_replace("/SU-/","<290>",$alg);     $alg = preg_replace("/SU2/","<291>",$alg);    $alg = preg_replace("/SU/","<292>",$alg);
    $alg = preg_replace("/SD2'/","<293>",$alg); $alg = preg_replace("/SD2-/","<293>",$alg);     $alg = preg_replace("/SD'/","<294>",$alg); $alg = preg_replace("/SD-/","<294>",$alg);     $alg = preg_replace("/SD2/","<295>",$alg);    $alg = preg_replace("/SD/","<296>",$alg);
    
    /* --- 5xD: SSE -> CODE: [3] Tier twists --- */
    $alg = preg_replace("/T4UR2'/","<301>",$alg); $alg = preg_replace("/T4UR2-/","<301>",$alg);   $alg = preg_replace("/T4UR'/","<302>",$alg); $alg = preg_replace("/T4UR-/","<302>",$alg);   $alg = preg_replace("/T4UR2/","<303>",$alg);   $alg = preg_replace("/T4UR/","<304>",$alg);
    $alg = preg_replace("/T4UL2'/","<305>",$alg); $alg = preg_replace("/T4UL2-/","<305>",$alg);   $alg = preg_replace("/T4UL'/","<306>",$alg); $alg = preg_replace("/T4UL-/","<306>",$alg);   $alg = preg_replace("/T4UL2/","<307>",$alg);   $alg = preg_replace("/T4UL/","<308>",$alg);
    $alg = preg_replace("/T4DR2'/","<309>",$alg); $alg = preg_replace("/T4DR2-/","<309>",$alg);   $alg = preg_replace("/T4DR'/","<310>",$alg); $alg = preg_replace("/T4DR-/","<310>",$alg);   $alg = preg_replace("/T4DR2/","<311>",$alg);   $alg = preg_replace("/T4DR/","<312>",$alg);
    $alg = preg_replace("/T4DL2'/","<313>",$alg); $alg = preg_replace("/T4DL2-/","<313>",$alg);   $alg = preg_replace("/T4DL'/","<314>",$alg); $alg = preg_replace("/T4DL-/","<314>",$alg);   $alg = preg_replace("/T4DL2/","<315>",$alg);   $alg = preg_replace("/T4DL/","<316>",$alg);
    $alg = preg_replace("/T4BR2'/","<317>",$alg); $alg = preg_replace("/T4BR2-/","<317>",$alg);   $alg = preg_replace("/T4BR'/","<318>",$alg); $alg = preg_replace("/T4BR-/","<318>",$alg);   $alg = preg_replace("/T4BR2/","<319>",$alg);   $alg = preg_replace("/T4BR/","<320>",$alg);
    $alg = preg_replace("/T4BL2'/","<321>",$alg); $alg = preg_replace("/T4BL2-/","<321>",$alg);   $alg = preg_replace("/T4BL'/","<322>",$alg); $alg = preg_replace("/T4BL-/","<322>",$alg);   $alg = preg_replace("/T4BL2/","<323>",$alg);   $alg = preg_replace("/T4BL/","<324>",$alg);
    
    $alg = preg_replace("/T4R2'/","<325>",$alg); $alg = preg_replace("/T4R2-/","<325>",$alg);     $alg = preg_replace("/T4R'/","<326>",$alg); $alg = preg_replace("/T4R-/","<326>",$alg);     $alg = preg_replace("/T4R2/","<327>",$alg);    $alg = preg_replace("/T4R/","<328>",$alg);
    $alg = preg_replace("/T4L2'/","<329>",$alg); $alg = preg_replace("/T4L2-/","<329>",$alg);     $alg = preg_replace("/T4L'/","<330>",$alg); $alg = preg_replace("/T4L-/","<330>",$alg);     $alg = preg_replace("/T4L2/","<331>",$alg);    $alg = preg_replace("/T4L/","<332>",$alg);
    $alg = preg_replace("/T4F2'/","<333>",$alg); $alg = preg_replace("/T4F2-/","<333>",$alg);     $alg = preg_replace("/T4F'/","<334>",$alg); $alg = preg_replace("/T4F-/","<334>",$alg);     $alg = preg_replace("/T4F2/","<335>",$alg);    $alg = preg_replace("/T4F/","<336>",$alg);
    $alg = preg_replace("/T4B2'/","<337>",$alg); $alg = preg_replace("/T4B2-/","<337>",$alg);     $alg = preg_replace("/T4B'/","<338>",$alg); $alg = preg_replace("/T4B-/","<338>",$alg);     $alg = preg_replace("/T4B2/","<339>",$alg);    $alg = preg_replace("/T4B/","<340>",$alg);
    $alg = preg_replace("/T4U2'/","<341>",$alg); $alg = preg_replace("/T4U2-/","<341>",$alg);     $alg = preg_replace("/T4U'/","<342>",$alg); $alg = preg_replace("/T4U-/","<342>",$alg);     $alg = preg_replace("/T4U2/","<343>",$alg);    $alg = preg_replace("/T4U/","<344>",$alg);
    $alg = preg_replace("/T4D2'/","<345>",$alg); $alg = preg_replace("/T4D2-/","<345>",$alg);     $alg = preg_replace("/T4D'/","<346>",$alg); $alg = preg_replace("/T4D-/","<346>",$alg);     $alg = preg_replace("/T4D2/","<347>",$alg);    $alg = preg_replace("/T4D/","<348>",$alg);
    
    $alg = preg_replace("/T3UR2'/","<349>",$alg); $alg = preg_replace("/T3UR2-/","<349>",$alg);   $alg = preg_replace("/T3UR'/","<350>",$alg); $alg = preg_replace("/T3UR-/","<350>",$alg);   $alg = preg_replace("/T3UR2/","<351>",$alg);   $alg = preg_replace("/T3UR/","<352>",$alg);
    $alg = preg_replace("/T3UL2'/","<353>",$alg); $alg = preg_replace("/T3UL2-/","<353>",$alg);   $alg = preg_replace("/T3UL'/","<354>",$alg); $alg = preg_replace("/T3UL-/","<354>",$alg);   $alg = preg_replace("/T3UL2/","<355>",$alg);   $alg = preg_replace("/T3UL/","<356>",$alg);
    $alg = preg_replace("/T3DR2'/","<357>",$alg); $alg = preg_replace("/T3DR2-/","<357>",$alg);   $alg = preg_replace("/T3DR'/","<358>",$alg); $alg = preg_replace("/T3DR-/","<358>",$alg);   $alg = preg_replace("/T3DR2/","<359>",$alg);   $alg = preg_replace("/T3DR/","<360>",$alg);
    $alg = preg_replace("/T3DL2'/","<361>",$alg); $alg = preg_replace("/T3DL2-/","<361>",$alg);   $alg = preg_replace("/T3DL'/","<362>",$alg); $alg = preg_replace("/T3DL-/","<362>",$alg);   $alg = preg_replace("/T3DL2/","<363>",$alg);   $alg = preg_replace("/T3DL/","<364>",$alg);
    $alg = preg_replace("/T3BR2'/","<365>",$alg); $alg = preg_replace("/T3BR2-/","<365>",$alg);   $alg = preg_replace("/T3BR'/","<366>",$alg); $alg = preg_replace("/T3BR-/","<366>",$alg);   $alg = preg_replace("/T3BR2/","<367>",$alg);   $alg = preg_replace("/T3BR/","<368>",$alg);
    $alg = preg_replace("/T3BL2'/","<369>",$alg); $alg = preg_replace("/T3BL2-/","<369>",$alg);   $alg = preg_replace("/T3BL'/","<370>",$alg); $alg = preg_replace("/T3BL-/","<370>",$alg);   $alg = preg_replace("/T3BL2/","<371>",$alg);   $alg = preg_replace("/T3BL/","<372>",$alg);
    
    $alg = preg_replace("/T3R2'/","<373>",$alg); $alg = preg_replace("/T3R2-/","<373>",$alg);     $alg = preg_replace("/T3R'/","<374>",$alg); $alg = preg_replace("/T3R-/","<374>",$alg);     $alg = preg_replace("/T3R2/","<375>",$alg);    $alg = preg_replace("/T3R/","<376>",$alg);
    $alg = preg_replace("/T3L2'/","<377>",$alg); $alg = preg_replace("/T3L2-/","<377>",$alg);     $alg = preg_replace("/T3L'/","<378>",$alg); $alg = preg_replace("/T3L-/","<378>",$alg);     $alg = preg_replace("/T3L2/","<379>",$alg);    $alg = preg_replace("/T3L/","<380>",$alg);
    $alg = preg_replace("/T3F2'/","<381>",$alg); $alg = preg_replace("/T3F2-/","<381>",$alg);     $alg = preg_replace("/T3F'/","<382>",$alg); $alg = preg_replace("/T3F-/","<382>",$alg);     $alg = preg_replace("/T3F2/","<383>",$alg);    $alg = preg_replace("/T3F/","<384>",$alg);
    $alg = preg_replace("/T3B2'/","<385>",$alg); $alg = preg_replace("/T3B2-/","<385>",$alg);     $alg = preg_replace("/T3B'/","<386>",$alg); $alg = preg_replace("/T3B-/","<386>",$alg);     $alg = preg_replace("/T3B2/","<387>",$alg);    $alg = preg_replace("/T3B/","<388>",$alg);
    $alg = preg_replace("/T3U2'/","<389>",$alg); $alg = preg_replace("/T3U2-/","<389>",$alg);     $alg = preg_replace("/T3U'/","<390>",$alg); $alg = preg_replace("/T3U-/","<390>",$alg);     $alg = preg_replace("/T3U2/","<391>",$alg);    $alg = preg_replace("/T3U/","<392>",$alg);
    $alg = preg_replace("/T3D2'/","<393>",$alg); $alg = preg_replace("/T3D2-/","<393>",$alg);     $alg = preg_replace("/T3D'/","<394>",$alg); $alg = preg_replace("/T3D-/","<394>",$alg);     $alg = preg_replace("/T3D2/","<395>",$alg);    $alg = preg_replace("/T3D/","<396>",$alg);
    
    $alg = preg_replace("/TUR2'/","<397>",$alg);  $alg = preg_replace("/TUR2-/","<397>",$alg);    $alg = preg_replace("/TUR'/","<398>",$alg);  $alg = preg_replace("/TUR-/","<398>",$alg);    $alg = preg_replace("/TUR2/","<399>",$alg);    $alg = preg_replace("/TUR/","<3100>",$alg);
    $alg = preg_replace("/TUL2'/","<3101>",$alg); $alg = preg_replace("/TUL2-/","<3101>",$alg);   $alg = preg_replace("/TUL'/","<3102>",$alg); $alg = preg_replace("/TUL-/","<3102>",$alg);   $alg = preg_replace("/TUL2/","<3103>",$alg);   $alg = preg_replace("/TUL/","<3104>",$alg);
    $alg = preg_replace("/TDR2'/","<3105>",$alg); $alg = preg_replace("/TDR2-/","<3105>",$alg);   $alg = preg_replace("/TDR'/","<3106>",$alg); $alg = preg_replace("/TDR-/","<3106>",$alg);   $alg = preg_replace("/TDR2/","<3107>",$alg);   $alg = preg_replace("/TDR/","<3108>",$alg);
    $alg = preg_replace("/TDL2'/","<3109>",$alg); $alg = preg_replace("/TDL2-/","<3109>",$alg);   $alg = preg_replace("/TDL'/","<3110>",$alg); $alg = preg_replace("/TDL-/","<3110>",$alg);   $alg = preg_replace("/TDL2/","<3111>",$alg);   $alg = preg_replace("/TDL/","<3112>",$alg);
    $alg = preg_replace("/TBR2'/","<3113>",$alg); $alg = preg_replace("/TBR2-/","<3113>",$alg);   $alg = preg_replace("/TBR'/","<3114>",$alg); $alg = preg_replace("/TBR-/","<3114>",$alg);   $alg = preg_replace("/TBR2/","<3115>",$alg);   $alg = preg_replace("/TBR/","<3116>",$alg);
    $alg = preg_replace("/TBL2'/","<3117>",$alg); $alg = preg_replace("/TBL2-/","<3117>",$alg);   $alg = preg_replace("/TBL'/","<3118>",$alg); $alg = preg_replace("/TBL-/","<3118>",$alg);   $alg = preg_replace("/TBL2/","<3119>",$alg);   $alg = preg_replace("/TBL/","<3120>",$alg);
    
    $alg = preg_replace("/TR2'/","<3121>",$alg); $alg = preg_replace("/TR2-/","<3121>",$alg);     $alg = preg_replace("/TR'/","<3122>",$alg); $alg = preg_replace("/TR-/","<3122>",$alg);     $alg = preg_replace("/TR2/","<3123>",$alg);    $alg = preg_replace("/TR/","<3124>",$alg);
    $alg = preg_replace("/TL2'/","<3125>",$alg); $alg = preg_replace("/TL2-/","<3125>",$alg);     $alg = preg_replace("/TL'/","<3126>",$alg); $alg = preg_replace("/TL-/","<3126>",$alg);     $alg = preg_replace("/TL2/","<3127>",$alg);    $alg = preg_replace("/TL/","<3128>",$alg);
    $alg = preg_replace("/TF2'/","<3129>",$alg); $alg = preg_replace("/TF2-/","<3129>",$alg);     $alg = preg_replace("/TF'/","<3130>",$alg); $alg = preg_replace("/TF-/","<3130>",$alg);     $alg = preg_replace("/TF2/","<3131>",$alg);    $alg = preg_replace("/TF/","<3132>",$alg);
    $alg = preg_replace("/TB2'/","<3133>",$alg); $alg = preg_replace("/TB2-/","<3133>",$alg);     $alg = preg_replace("/TB'/","<3134>",$alg); $alg = preg_replace("/TB-/","<3134>",$alg);     $alg = preg_replace("/TB2/","<3135>",$alg);    $alg = preg_replace("/TB/","<3136>",$alg);
    $alg = preg_replace("/TU2'/","<3137>",$alg); $alg = preg_replace("/TU2-/","<3137>",$alg);     $alg = preg_replace("/TU'/","<3138>",$alg); $alg = preg_replace("/TU-/","<3138>",$alg);     $alg = preg_replace("/TU2/","<3139>",$alg);    $alg = preg_replace("/TU/","<3140>",$alg);
    $alg = preg_replace("/TD2'/","<3141>",$alg); $alg = preg_replace("/TD2-/","<3141>",$alg);     $alg = preg_replace("/TD'/","<3142>",$alg); $alg = preg_replace("/TD-/","<3142>",$alg);     $alg = preg_replace("/TD2/","<3143>",$alg);    $alg = preg_replace("/TD/","<3144>",$alg);
    
    /* --- 5xD: SSE -> CODE: [4] (Void twists) --- */
    $alg = preg_replace("/VUR2'/","<401>",$alg); $alg = preg_replace("/VUR2-/","<401>",$alg);   $alg = preg_replace("/VUR'/","<402>",$alg); $alg = preg_replace("/VUR-/","<402>",$alg);   $alg = preg_replace("/VUR2/","<403>",$alg);   $alg = preg_replace("/VUR/","<404>",$alg);
    $alg = preg_replace("/VUL2'/","<405>",$alg); $alg = preg_replace("/VUL2-/","<405>",$alg);   $alg = preg_replace("/VUL'/","<406>",$alg); $alg = preg_replace("/VUL-/","<406>",$alg);   $alg = preg_replace("/VUL2/","<407>",$alg);   $alg = preg_replace("/VUL/","<408>",$alg);
    $alg = preg_replace("/VDR2'/","<409>",$alg); $alg = preg_replace("/VDR2-/","<409>",$alg);   $alg = preg_replace("/VDR'/","<410>",$alg); $alg = preg_replace("/VDR-/","<410>",$alg);   $alg = preg_replace("/VDR2/","<411>",$alg);   $alg = preg_replace("/VDR/","<412>",$alg);
    $alg = preg_replace("/VDL2'/","<413>",$alg); $alg = preg_replace("/VDL2-/","<413>",$alg);   $alg = preg_replace("/VDL'/","<414>",$alg); $alg = preg_replace("/VDL-/","<414>",$alg);   $alg = preg_replace("/VDL2/","<415>",$alg);   $alg = preg_replace("/VDL/","<416>",$alg);
    $alg = preg_replace("/VBR2'/","<417>",$alg); $alg = preg_replace("/VBR2-/","<417>",$alg);   $alg = preg_replace("/VBR'/","<418>",$alg); $alg = preg_replace("/VBR-/","<418>",$alg);   $alg = preg_replace("/VBR2/","<419>",$alg);   $alg = preg_replace("/VBR/","<420>",$alg);
    $alg = preg_replace("/VBL2'/","<421>",$alg); $alg = preg_replace("/VBL2-/","<421>",$alg);   $alg = preg_replace("/VBL'/","<422>",$alg); $alg = preg_replace("/VBL-/","<422>",$alg);   $alg = preg_replace("/VBL2/","<423>",$alg);   $alg = preg_replace("/VBL/","<424>",$alg);
    
    $alg = preg_replace("/VR2'/","<425>",$alg); $alg = preg_replace("/VR2-/","<425>",$alg);     $alg = preg_replace("/VR'/","<426>",$alg); $alg = preg_replace("/VR-/","<426>",$alg);     $alg = preg_replace("/VR2/","<427>",$alg);    $alg = preg_replace("/VR/","<428>",$alg);
    $alg = preg_replace("/VL2'/","<429>",$alg); $alg = preg_replace("/VL2-/","<429>",$alg);     $alg = preg_replace("/VL'/","<430>",$alg); $alg = preg_replace("/VL-/","<430>",$alg);     $alg = preg_replace("/VL2/","<431>",$alg);    $alg = preg_replace("/VL/","<432>",$alg);
    $alg = preg_replace("/VF2'/","<433>",$alg); $alg = preg_replace("/VF2-/","<433>",$alg);     $alg = preg_replace("/VF'/","<434>",$alg); $alg = preg_replace("/VF-/","<434>",$alg);     $alg = preg_replace("/VF2/","<435>",$alg);    $alg = preg_replace("/VF/","<436>",$alg);
    $alg = preg_replace("/VB2'/","<437>",$alg); $alg = preg_replace("/VB2-/","<437>",$alg);     $alg = preg_replace("/VB'/","<438>",$alg); $alg = preg_replace("/VB-/","<438>",$alg);     $alg = preg_replace("/VB2/","<439>",$alg);    $alg = preg_replace("/VB/","<440>",$alg);
    $alg = preg_replace("/VU2'/","<441>",$alg); $alg = preg_replace("/VU2-/","<441>",$alg);     $alg = preg_replace("/VU'/","<442>",$alg); $alg = preg_replace("/VU-/","<442>",$alg);     $alg = preg_replace("/VU2/","<443>",$alg);    $alg = preg_replace("/VU/","<444>",$alg);
    $alg = preg_replace("/VD2'/","<445>",$alg); $alg = preg_replace("/VD2-/","<445>",$alg);     $alg = preg_replace("/VD'/","<446>",$alg); $alg = preg_replace("/VD-/","<446>",$alg);     $alg = preg_replace("/VD2/","<447>",$alg);    $alg = preg_replace("/VD/","<448>",$alg);
    
    
    /* --- 5xD: SSE -> CODE: [6] Wide-layer twists [5] (Mid-layer twists) [4] (Void twists) [1] Numbered layer twists --- */
    $alg = preg_replace("/WUR2'/","<501>",$alg); $alg = preg_replace("/WUR2-/","<501>",$alg);   $alg = preg_replace("/WUR'/","<502>",$alg); $alg = preg_replace("/WUR-/","<502>",$alg);   $alg = preg_replace("/WUR2/","<503>",$alg);   $alg = preg_replace("/WUR/","<504>",$alg);
    $alg = preg_replace("/WUL2'/","<505>",$alg); $alg = preg_replace("/WUL2-/","<505>",$alg);   $alg = preg_replace("/WUL'/","<506>",$alg); $alg = preg_replace("/WUL-/","<506>",$alg);   $alg = preg_replace("/WUL2/","<507>",$alg);   $alg = preg_replace("/WUL/","<508>",$alg);
    $alg = preg_replace("/WDR2'/","<509>",$alg); $alg = preg_replace("/WDR2-/","<509>",$alg);   $alg = preg_replace("/WDR'/","<510>",$alg); $alg = preg_replace("/WDR-/","<510>",$alg);   $alg = preg_replace("/WDR2/","<511>",$alg);   $alg = preg_replace("/WDR/","<512>",$alg);
    $alg = preg_replace("/WDL2'/","<513>",$alg); $alg = preg_replace("/WDL2-/","<513>",$alg);   $alg = preg_replace("/WDL'/","<514>",$alg); $alg = preg_replace("/WDL-/","<514>",$alg);   $alg = preg_replace("/WDL2/","<515>",$alg);   $alg = preg_replace("/WDL/","<516>",$alg);
    $alg = preg_replace("/WBR2'/","<517>",$alg); $alg = preg_replace("/WBR2-/","<517>",$alg);   $alg = preg_replace("/WBR'/","<518>",$alg); $alg = preg_replace("/WBR-/","<518>",$alg);   $alg = preg_replace("/WBR2/","<519>",$alg);   $alg = preg_replace("/WBR/","<520>",$alg);
    $alg = preg_replace("/WBL2'/","<521>",$alg); $alg = preg_replace("/WBL2-/","<521>",$alg);   $alg = preg_replace("/WBL'/","<522>",$alg); $alg = preg_replace("/WBL-/","<522>",$alg);   $alg = preg_replace("/WBL2/","<523>",$alg);   $alg = preg_replace("/WBL/","<524>",$alg);
    
    $alg = preg_replace("/WR2'/","<525>",$alg); $alg = preg_replace("/WR2-/","<525>",$alg);     $alg = preg_replace("/WR'/","<526>",$alg); $alg = preg_replace("/WR-/","<526>",$alg);     $alg = preg_replace("/WR2/","<527>",$alg);    $alg = preg_replace("/WR/","<528>",$alg);
    $alg = preg_replace("/WL2'/","<529>",$alg); $alg = preg_replace("/WL2-/","<529>",$alg);     $alg = preg_replace("/WL'/","<530>",$alg); $alg = preg_replace("/WL-/","<530>",$alg);     $alg = preg_replace("/WL2/","<531>",$alg);    $alg = preg_replace("/WL/","<532>",$alg);
    $alg = preg_replace("/WF2'/","<533>",$alg); $alg = preg_replace("/WF2-/","<533>",$alg);     $alg = preg_replace("/WF'/","<534>",$alg); $alg = preg_replace("/WF-/","<534>",$alg);     $alg = preg_replace("/WF2/","<535>",$alg);    $alg = preg_replace("/WF/","<536>",$alg);
    $alg = preg_replace("/WB2'/","<537>",$alg); $alg = preg_replace("/WB2-/","<537>",$alg);     $alg = preg_replace("/WB'/","<538>",$alg); $alg = preg_replace("/WB-/","<538>",$alg);     $alg = preg_replace("/WB2/","<539>",$alg);    $alg = preg_replace("/WB/","<540>",$alg);
    $alg = preg_replace("/WU2'/","<541>",$alg); $alg = preg_replace("/WU2-/","<541>",$alg);     $alg = preg_replace("/WU'/","<542>",$alg); $alg = preg_replace("/WU-/","<542>",$alg);     $alg = preg_replace("/WU2/","<543>",$alg);    $alg = preg_replace("/WU/","<544>",$alg);
    $alg = preg_replace("/WD2'/","<545>",$alg); $alg = preg_replace("/WD2-/","<545>",$alg);     $alg = preg_replace("/WD'/","<546>",$alg); $alg = preg_replace("/WD-/","<546>",$alg);     $alg = preg_replace("/WD2/","<547>",$alg);    $alg = preg_replace("/WD/","<548>",$alg);
    
    $alg = preg_replace("/M3UR2'/","<501>",$alg); $alg = preg_replace("/M3UR2-/","<501>",$alg);   $alg = preg_replace("/M3UR'/","<502>",$alg); $alg = preg_replace("/M3UR-/","<502>",$alg);   $alg = preg_replace("/M3UR2/","<503>",$alg);   $alg = preg_replace("/M3UR/","<504>",$alg);
    $alg = preg_replace("/M3UL2'/","<505>",$alg); $alg = preg_replace("/M3UL2-/","<505>",$alg);   $alg = preg_replace("/M3UL'/","<506>",$alg); $alg = preg_replace("/M3UL-/","<506>",$alg);   $alg = preg_replace("/M3UL2/","<507>",$alg);   $alg = preg_replace("/M3UL/","<508>",$alg);
    $alg = preg_replace("/M3DR2'/","<509>",$alg); $alg = preg_replace("/M3DR2-/","<509>",$alg);   $alg = preg_replace("/M3DR'/","<510>",$alg); $alg = preg_replace("/M3DR-/","<510>",$alg);   $alg = preg_replace("/M3DR2/","<511>",$alg);   $alg = preg_replace("/M3DR/","<512>",$alg);
    $alg = preg_replace("/M3DL2'/","<513>",$alg); $alg = preg_replace("/M3DL2-/","<513>",$alg);   $alg = preg_replace("/M3DL'/","<514>",$alg); $alg = preg_replace("/M3DL-/","<514>",$alg);   $alg = preg_replace("/M3DL2/","<515>",$alg);   $alg = preg_replace("/M3DL/","<516>",$alg);
    $alg = preg_replace("/M3BR2'/","<517>",$alg); $alg = preg_replace("/M3BR2-/","<517>",$alg);   $alg = preg_replace("/M3BR'/","<518>",$alg); $alg = preg_replace("/M3BR-/","<518>",$alg);   $alg = preg_replace("/M3BR2/","<519>",$alg);   $alg = preg_replace("/M3BR/","<520>",$alg);
    $alg = preg_replace("/M3BL2'/","<521>",$alg); $alg = preg_replace("/M3BL2-/","<521>",$alg);   $alg = preg_replace("/M3BL'/","<522>",$alg); $alg = preg_replace("/M3BL-/","<522>",$alg);   $alg = preg_replace("/M3BL2/","<523>",$alg);   $alg = preg_replace("/M3BL/","<524>",$alg);
    
    $alg = preg_replace("/M3R2'/","<525>",$alg); $alg = preg_replace("/M3R2-/","<525>",$alg);     $alg = preg_replace("/M3R'/","<526>",$alg); $alg = preg_replace("/M3R-/","<526>",$alg);     $alg = preg_replace("/M3R2/","<527>",$alg);    $alg = preg_replace("/M3R/","<528>",$alg);
    $alg = preg_replace("/M3L2'/","<529>",$alg); $alg = preg_replace("/M3L2-/","<529>",$alg);     $alg = preg_replace("/M3L'/","<530>",$alg); $alg = preg_replace("/M3L-/","<530>",$alg);     $alg = preg_replace("/M3L2/","<531>",$alg);    $alg = preg_replace("/M3L/","<532>",$alg);
    $alg = preg_replace("/M3F2'/","<533>",$alg); $alg = preg_replace("/M3F2-/","<533>",$alg);     $alg = preg_replace("/M3F'/","<534>",$alg); $alg = preg_replace("/M3F-/","<534>",$alg);     $alg = preg_replace("/M3F2/","<535>",$alg);    $alg = preg_replace("/M3F/","<536>",$alg);
    $alg = preg_replace("/M3B2'/","<537>",$alg); $alg = preg_replace("/M3B2-/","<537>",$alg);     $alg = preg_replace("/M3B'/","<538>",$alg); $alg = preg_replace("/M3B-/","<538>",$alg);     $alg = preg_replace("/M3B2/","<539>",$alg);    $alg = preg_replace("/M3B/","<540>",$alg);
    $alg = preg_replace("/M3U2'/","<541>",$alg); $alg = preg_replace("/M3U2-/","<541>",$alg);     $alg = preg_replace("/M3U'/","<542>",$alg); $alg = preg_replace("/M3U-/","<542>",$alg);     $alg = preg_replace("/M3U2/","<543>",$alg);    $alg = preg_replace("/M3U/","<544>",$alg);
    $alg = preg_replace("/M3D2'/","<545>",$alg); $alg = preg_replace("/M3D2-/","<545>",$alg);     $alg = preg_replace("/M3D'/","<546>",$alg); $alg = preg_replace("/M3D-/","<546>",$alg);     $alg = preg_replace("/M3D2/","<547>",$alg);    $alg = preg_replace("/M3D/","<548>",$alg);
    
    $alg = preg_replace("/V3UR2'/","<501>",$alg); $alg = preg_replace("/V3UR2-/","<501>",$alg);   $alg = preg_replace("/V3UR'/","<502>",$alg); $alg = preg_replace("/V3UR-/","<502>",$alg);   $alg = preg_replace("/V3UR2/","<503>",$alg);   $alg = preg_replace("/V3UR/","<504>",$alg);
    $alg = preg_replace("/V3UL2'/","<505>",$alg); $alg = preg_replace("/V3UL2-/","<505>",$alg);   $alg = preg_replace("/V3UL'/","<506>",$alg); $alg = preg_replace("/V3UL-/","<506>",$alg);   $alg = preg_replace("/V3UL2/","<507>",$alg);   $alg = preg_replace("/V3UL/","<508>",$alg);
    $alg = preg_replace("/V3DR2'/","<509>",$alg); $alg = preg_replace("/V3DR2-/","<509>",$alg);   $alg = preg_replace("/V3DR'/","<510>",$alg); $alg = preg_replace("/V3DR-/","<510>",$alg);   $alg = preg_replace("/V3DR2/","<511>",$alg);   $alg = preg_replace("/V3DR/","<512>",$alg);
    $alg = preg_replace("/V3DL2'/","<513>",$alg); $alg = preg_replace("/V3DL2-/","<513>",$alg);   $alg = preg_replace("/V3DL'/","<514>",$alg); $alg = preg_replace("/V3DL-/","<514>",$alg);   $alg = preg_replace("/V3DL2/","<515>",$alg);   $alg = preg_replace("/V3DL/","<516>",$alg);
    $alg = preg_replace("/V3BR2'/","<517>",$alg); $alg = preg_replace("/V3BR2-/","<517>",$alg);   $alg = preg_replace("/V3BR'/","<518>",$alg); $alg = preg_replace("/V3BR-/","<518>",$alg);   $alg = preg_replace("/V3BR2/","<519>",$alg);   $alg = preg_replace("/V3BR/","<520>",$alg);
    $alg = preg_replace("/V3BL2'/","<521>",$alg); $alg = preg_replace("/V3BL2-/","<521>",$alg);   $alg = preg_replace("/V3BL'/","<522>",$alg); $alg = preg_replace("/V3BL-/","<522>",$alg);   $alg = preg_replace("/V3BL2/","<523>",$alg);   $alg = preg_replace("/V3BL/","<524>",$alg);
    
    $alg = preg_replace("/V3R2'/","<525>",$alg); $alg = preg_replace("/V3R2-/","<525>",$alg);     $alg = preg_replace("/V3R'/","<526>",$alg); $alg = preg_replace("/V3R-/","<526>",$alg);     $alg = preg_replace("/V3R2/","<527>",$alg);    $alg = preg_replace("/V3R/","<528>",$alg);
    $alg = preg_replace("/V3L2'/","<529>",$alg); $alg = preg_replace("/V3L2-/","<529>",$alg);     $alg = preg_replace("/V3L'/","<530>",$alg); $alg = preg_replace("/V3L-/","<530>",$alg);     $alg = preg_replace("/V3L2/","<531>",$alg);    $alg = preg_replace("/V3L/","<532>",$alg);
    $alg = preg_replace("/V3F2'/","<533>",$alg); $alg = preg_replace("/V3F2-/","<533>",$alg);     $alg = preg_replace("/V3F'/","<534>",$alg); $alg = preg_replace("/V3F-/","<534>",$alg);     $alg = preg_replace("/V3F2/","<535>",$alg);    $alg = preg_replace("/V3F/","<536>",$alg);
    $alg = preg_replace("/V3B2'/","<537>",$alg); $alg = preg_replace("/V3B2-/","<537>",$alg);     $alg = preg_replace("/V3B'/","<538>",$alg); $alg = preg_replace("/V3B-/","<538>",$alg);     $alg = preg_replace("/V3B2/","<539>",$alg);    $alg = preg_replace("/V3B/","<540>",$alg);
    $alg = preg_replace("/V3U2'/","<541>",$alg); $alg = preg_replace("/V3U2-/","<541>",$alg);     $alg = preg_replace("/V3U'/","<542>",$alg); $alg = preg_replace("/V3U-/","<542>",$alg);     $alg = preg_replace("/V3U2/","<543>",$alg);    $alg = preg_replace("/V3U/","<544>",$alg);
    $alg = preg_replace("/V3D2'/","<545>",$alg); $alg = preg_replace("/V3D2-/","<545>",$alg);     $alg = preg_replace("/V3D'/","<546>",$alg); $alg = preg_replace("/V3D-/","<546>",$alg);     $alg = preg_replace("/V3D2/","<547>",$alg);    $alg = preg_replace("/V3D/","<548>",$alg);
    
    $alg = preg_replace("/N2-4UR2'/","<501>",$alg); $alg = preg_replace("/N2-4UR2-/","<501>",$alg);   $alg = preg_replace("/N2-4UR'/","<502>",$alg); $alg = preg_replace("/N2-4UR-/","<502>",$alg);   $alg = preg_replace("/N2-4UR2/","<503>",$alg);   $alg = preg_replace("/N2-4UR/","<504>",$alg);
    $alg = preg_replace("/N2-4UL2'/","<505>",$alg); $alg = preg_replace("/N2-4UL2-/","<505>",$alg);   $alg = preg_replace("/N2-4UL'/","<506>",$alg); $alg = preg_replace("/N2-4UL-/","<506>",$alg);   $alg = preg_replace("/N2-4UL2/","<507>",$alg);   $alg = preg_replace("/N2-4UL/","<508>",$alg);
    $alg = preg_replace("/N2-4DR2'/","<509>",$alg); $alg = preg_replace("/N2-4DR2-/","<509>",$alg);   $alg = preg_replace("/N2-4DR'/","<510>",$alg); $alg = preg_replace("/N2-4DR-/","<510>",$alg);   $alg = preg_replace("/N2-4DR2/","<511>",$alg);   $alg = preg_replace("/N2-4DR/","<512>",$alg);
    $alg = preg_replace("/N2-4DL2'/","<513>",$alg); $alg = preg_replace("/N2-4DL2-/","<513>",$alg);   $alg = preg_replace("/N2-4DL'/","<514>",$alg); $alg = preg_replace("/N2-4DL-/","<514>",$alg);   $alg = preg_replace("/N2-4DL2/","<515>",$alg);   $alg = preg_replace("/N2-4DL/","<516>",$alg);
    $alg = preg_replace("/N2-4BR2'/","<517>",$alg); $alg = preg_replace("/N2-4BR2-/","<517>",$alg);   $alg = preg_replace("/N2-4BR'/","<518>",$alg); $alg = preg_replace("/N2-4BR-/","<518>",$alg);   $alg = preg_replace("/N2-4BR2/","<519>",$alg);   $alg = preg_replace("/N2-4BR/","<520>",$alg);
    $alg = preg_replace("/N2-4BL2'/","<521>",$alg); $alg = preg_replace("/N2-4BL2-/","<521>",$alg);   $alg = preg_replace("/N2-4BL'/","<522>",$alg); $alg = preg_replace("/N2-4BL-/","<522>",$alg);   $alg = preg_replace("/N2-4BL2/","<523>",$alg);   $alg = preg_replace("/N2-4BL/","<524>",$alg);
    
    $alg = preg_replace("/N2-4R2'/","<525>",$alg); $alg = preg_replace("/N2-4R2-/","<525>",$alg);     $alg = preg_replace("/N2-4R'/","<526>",$alg); $alg = preg_replace("/N2-4R-/","<526>",$alg);     $alg = preg_replace("/N2-4R2/","<527>",$alg);    $alg = preg_replace("/N2-4R/","<528>",$alg);
    $alg = preg_replace("/N2-4L2'/","<529>",$alg); $alg = preg_replace("/N2-4L2-/","<529>",$alg);     $alg = preg_replace("/N2-4L'/","<530>",$alg); $alg = preg_replace("/N2-4L-/","<530>",$alg);     $alg = preg_replace("/N2-4L2/","<531>",$alg);    $alg = preg_replace("/N2-4L/","<532>",$alg);
    $alg = preg_replace("/N2-4F2'/","<533>",$alg); $alg = preg_replace("/N2-4F2-/","<533>",$alg);     $alg = preg_replace("/N2-4F'/","<534>",$alg); $alg = preg_replace("/N2-4F-/","<534>",$alg);     $alg = preg_replace("/N2-4F2/","<535>",$alg);    $alg = preg_replace("/N2-4F/","<536>",$alg);
    $alg = preg_replace("/N2-4B2'/","<537>",$alg); $alg = preg_replace("/N2-4B2-/","<537>",$alg);     $alg = preg_replace("/N2-4B'/","<538>",$alg); $alg = preg_replace("/N2-4B-/","<538>",$alg);     $alg = preg_replace("/N2-4B2/","<539>",$alg);    $alg = preg_replace("/N2-4B/","<540>",$alg);
    $alg = preg_replace("/N2-4U2'/","<541>",$alg); $alg = preg_replace("/N2-4U2-/","<541>",$alg);     $alg = preg_replace("/N2-4U'/","<542>",$alg); $alg = preg_replace("/N2-4U-/","<542>",$alg);     $alg = preg_replace("/N2-4U2/","<543>",$alg);    $alg = preg_replace("/N2-4U/","<544>",$alg);
    $alg = preg_replace("/N2-4D2'/","<545>",$alg); $alg = preg_replace("/N2-4D2-/","<545>",$alg);     $alg = preg_replace("/N2-4D'/","<546>",$alg); $alg = preg_replace("/N2-4D-/","<546>",$alg);     $alg = preg_replace("/N2-4D2/","<547>",$alg);    $alg = preg_replace("/N2-4D/","<548>",$alg);
    
    /* --- 5xD: SSE -> CODE: [7] Dodecahedron rotations --- */
    $alg = preg_replace("/CUR2'/","<701>",$alg); $alg = preg_replace("/CUR2-/","<701>",$alg);   $alg = preg_replace("/CUR'/","<702>",$alg); $alg = preg_replace("/CUR-/","<702>",$alg);   $alg = preg_replace("/CUR2/","<703>",$alg);   $alg = preg_replace("/CUR/","<704>",$alg);
    $alg = preg_replace("/CUL2'/","<705>",$alg); $alg = preg_replace("/CUL2-/","<705>",$alg);   $alg = preg_replace("/CUL'/","<706>",$alg); $alg = preg_replace("/CUL-/","<706>",$alg);   $alg = preg_replace("/CUL2/","<707>",$alg);   $alg = preg_replace("/CUL/","<708>",$alg);
    $alg = preg_replace("/CDR2'/","<709>",$alg); $alg = preg_replace("/CDR2-/","<709>",$alg);   $alg = preg_replace("/CDR'/","<710>",$alg); $alg = preg_replace("/CDR-/","<710>",$alg);   $alg = preg_replace("/CDR2/","<711>",$alg);   $alg = preg_replace("/CDR/","<712>",$alg);
    $alg = preg_replace("/CDL2'/","<713>",$alg); $alg = preg_replace("/CDL2-/","<713>",$alg);   $alg = preg_replace("/CDL'/","<714>",$alg); $alg = preg_replace("/CDL-/","<714>",$alg);   $alg = preg_replace("/CDL2/","<715>",$alg);   $alg = preg_replace("/CDL/","<716>",$alg);
    $alg = preg_replace("/CBR2'/","<717>",$alg); $alg = preg_replace("/CBR2-/","<717>",$alg);   $alg = preg_replace("/CBR'/","<718>",$alg); $alg = preg_replace("/CBR-/","<718>",$alg);   $alg = preg_replace("/CBR2/","<719>",$alg);   $alg = preg_replace("/CBR/","<720>",$alg);
    $alg = preg_replace("/CBL2'/","<721>",$alg); $alg = preg_replace("/CBL2-/","<721>",$alg);   $alg = preg_replace("/CBL'/","<722>",$alg); $alg = preg_replace("/CBL-/","<722>",$alg);   $alg = preg_replace("/CBL2/","<723>",$alg);   $alg = preg_replace("/CBL/","<724>",$alg);
    
    $alg = preg_replace("/CR2'/","<725>",$alg); $alg = preg_replace("/CR2-/","<725>",$alg);     $alg = preg_replace("/CR'/","<726>",$alg); $alg = preg_replace("/CR-/","<726>",$alg);     $alg = preg_replace("/CR2/","<727>",$alg);    $alg = preg_replace("/CR/","<728>",$alg);
    $alg = preg_replace("/CL2'/","<729>",$alg); $alg = preg_replace("/CL2-/","<729>",$alg);     $alg = preg_replace("/CL'/","<730>",$alg); $alg = preg_replace("/CL-/","<730>",$alg);     $alg = preg_replace("/CL2/","<731>",$alg);    $alg = preg_replace("/CL/","<732>",$alg);
    $alg = preg_replace("/CF2'/","<733>",$alg); $alg = preg_replace("/CF2-/","<733>",$alg);     $alg = preg_replace("/CF'/","<734>",$alg); $alg = preg_replace("/CF-/","<734>",$alg);     $alg = preg_replace("/CF2/","<735>",$alg);    $alg = preg_replace("/CF/","<736>",$alg);
    $alg = preg_replace("/CB2'/","<737>",$alg); $alg = preg_replace("/CB2-/","<737>",$alg);     $alg = preg_replace("/CB'/","<738>",$alg); $alg = preg_replace("/CB-/","<738>",$alg);     $alg = preg_replace("/CB2/","<739>",$alg);    $alg = preg_replace("/CB/","<740>",$alg);
    $alg = preg_replace("/CU2'/","<741>",$alg); $alg = preg_replace("/CU2-/","<741>",$alg);     $alg = preg_replace("/CU'/","<742>",$alg); $alg = preg_replace("/CU-/","<742>",$alg);     $alg = preg_replace("/CU2/","<743>",$alg);    $alg = preg_replace("/CU/","<744>",$alg);
    $alg = preg_replace("/CD2'/","<745>",$alg); $alg = preg_replace("/CD2-/","<745>",$alg);     $alg = preg_replace("/CD'/","<746>",$alg); $alg = preg_replace("/CD-/","<746>",$alg);     $alg = preg_replace("/CD2/","<747>",$alg);    $alg = preg_replace("/CD/","<748>",$alg);
    
    /* --- 5xD: SSE -> CODE: [9] Face twists --- */
    $alg = preg_replace("/UR2'/","<901>",$alg); $alg = preg_replace("/UR2-/","<901>",$alg);   $alg = preg_replace("/UR'/","<902>",$alg); $alg = preg_replace("/UR-/","<902>",$alg);   $alg = preg_replace("/UR2/","<903>",$alg);   $alg = preg_replace("/UR/","<904>",$alg);
    $alg = preg_replace("/UL2'/","<905>",$alg); $alg = preg_replace("/UL2-/","<905>",$alg);   $alg = preg_replace("/UL'/","<906>",$alg); $alg = preg_replace("/UL-/","<906>",$alg);   $alg = preg_replace("/UL2/","<907>",$alg);   $alg = preg_replace("/UL/","<908>",$alg);
    $alg = preg_replace("/DR2'/","<909>",$alg); $alg = preg_replace("/DR2-/","<909>",$alg);   $alg = preg_replace("/DR'/","<910>",$alg); $alg = preg_replace("/DR-/","<910>",$alg);   $alg = preg_replace("/DR2/","<911>",$alg);   $alg = preg_replace("/DR/","<912>",$alg);
    $alg = preg_replace("/DL2'/","<913>",$alg); $alg = preg_replace("/DL2-/","<913>",$alg);   $alg = preg_replace("/DL'/","<914>",$alg); $alg = preg_replace("/DL-/","<914>",$alg);   $alg = preg_replace("/DL2/","<915>",$alg);   $alg = preg_replace("/DL/","<916>",$alg);
    $alg = preg_replace("/BR2'/","<917>",$alg); $alg = preg_replace("/BR2-/","<917>",$alg);   $alg = preg_replace("/BR'/","<918>",$alg); $alg = preg_replace("/BR-/","<918>",$alg);   $alg = preg_replace("/BR2/","<919>",$alg);   $alg = preg_replace("/BR/","<920>",$alg);
    $alg = preg_replace("/BL2'/","<921>",$alg); $alg = preg_replace("/BL2-/","<921>",$alg);   $alg = preg_replace("/BL'/","<922>",$alg); $alg = preg_replace("/BL-/","<922>",$alg);   $alg = preg_replace("/BL2/","<923>",$alg);   $alg = preg_replace("/BL/","<924>",$alg);
    
    $alg = preg_replace("/R2'/","<925>",$alg); $alg = preg_replace("/R2-/","<925>",$alg);     $alg = preg_replace("/R'/","<926>",$alg); $alg = preg_replace("/R-/","<926>",$alg);     $alg = preg_replace("/R2/","<927>",$alg);    $alg = preg_replace("/R/","<928>",$alg);
    $alg = preg_replace("/L2'/","<929>",$alg); $alg = preg_replace("/L2-/","<929>",$alg);     $alg = preg_replace("/L'/","<930>",$alg); $alg = preg_replace("/L-/","<930>",$alg);     $alg = preg_replace("/L2/","<931>",$alg);    $alg = preg_replace("/L/","<932>",$alg);
    $alg = preg_replace("/F2'/","<933>",$alg); $alg = preg_replace("/F2-/","<933>",$alg);     $alg = preg_replace("/F'/","<934>",$alg); $alg = preg_replace("/F-/","<934>",$alg);     $alg = preg_replace("/F2/","<935>",$alg);    $alg = preg_replace("/F/","<936>",$alg);
    $alg = preg_replace("/B2'/","<937>",$alg); $alg = preg_replace("/B2-/","<937>",$alg);     $alg = preg_replace("/B'/","<938>",$alg); $alg = preg_replace("/B-/","<938>",$alg);     $alg = preg_replace("/B2/","<939>",$alg);    $alg = preg_replace("/B/","<940>",$alg);
    $alg = preg_replace("/U2'/","<941>",$alg); $alg = preg_replace("/U2-/","<941>",$alg);     $alg = preg_replace("/U'/","<942>",$alg); $alg = preg_replace("/U-/","<942>",$alg);     $alg = preg_replace("/U2/","<943>",$alg);    $alg = preg_replace("/U/","<944>",$alg);
    $alg = preg_replace("/D2'/","<945>",$alg); $alg = preg_replace("/D2-/","<945>",$alg);     $alg = preg_replace("/D'/","<946>",$alg); $alg = preg_replace("/D-/","<946>",$alg);     $alg = preg_replace("/D2/","<947>",$alg);    $alg = preg_replace("/D/","<948>",$alg);
    
    /* ··································································································· */
    /* --- 5xD: CODE -> TWIZZLE: [1] Numbered layer twists --- */
    $alg = preg_replace("/<101>/","2BR2'",$alg);   $alg = preg_replace("/<102>/","2BR'",$alg);   $alg = preg_replace("/<103>/","2BR2",$alg);   $alg = preg_replace("/<104>/","2BR",$alg);
    $alg = preg_replace("/<105>/","2BL2'",$alg);   $alg = preg_replace("/<106>/","2BL'",$alg);   $alg = preg_replace("/<107>/","2BL2",$alg);   $alg = preg_replace("/<108>/","2BL",$alg);
    $alg = preg_replace("/<109>/","2FR2'",$alg);   $alg = preg_replace("/<110>/","2FR'",$alg);   $alg = preg_replace("/<111>/","2FR2",$alg);   $alg = preg_replace("/<112>/","2FR",$alg);
    $alg = preg_replace("/<113>/","2FL2'",$alg);   $alg = preg_replace("/<114>/","2FL'",$alg);   $alg = preg_replace("/<115>/","2FL2",$alg);   $alg = preg_replace("/<116>/","2FL",$alg);
    $alg = preg_replace("/<117>/","2DR2'",$alg);   $alg = preg_replace("/<118>/","2DR'",$alg);   $alg = preg_replace("/<119>/","2DR2",$alg);   $alg = preg_replace("/<120>/","2DR",$alg);
    $alg = preg_replace("/<121>/","2DL2'",$alg);   $alg = preg_replace("/<122>/","2DL'",$alg);   $alg = preg_replace("/<123>/","2DL2",$alg);   $alg = preg_replace("/<124>/","2DL",$alg);
    
    $alg = preg_replace("/<125>/","2R2'",$alg);    $alg = preg_replace("/<126>/","2R'",$alg);    $alg = preg_replace("/<127>/","2R2",$alg);    $alg = preg_replace("/<128>/","2R",$alg);
    $alg = preg_replace("/<129>/","2L2'",$alg);    $alg = preg_replace("/<130>/","2L'",$alg);    $alg = preg_replace("/<131>/","2L2",$alg);    $alg = preg_replace("/<132>/","2L",$alg);
    $alg = preg_replace("/<133>/","2F2'",$alg);    $alg = preg_replace("/<134>/","2F'",$alg);    $alg = preg_replace("/<135>/","2F2",$alg);    $alg = preg_replace("/<136>/","2F",$alg);
    $alg = preg_replace("/<137>/","2B2'",$alg);    $alg = preg_replace("/<138>/","2B'",$alg);    $alg = preg_replace("/<139>/","2B2",$alg);    $alg = preg_replace("/<140>/","2B",$alg);
    $alg = preg_replace("/<141>/","2U2'",$alg);    $alg = preg_replace("/<142>/","2U'",$alg);    $alg = preg_replace("/<143>/","2U2",$alg);    $alg = preg_replace("/<144>/","2U",$alg);
    $alg = preg_replace("/<145>/","2D2'",$alg);    $alg = preg_replace("/<146>/","2D'",$alg);    $alg = preg_replace("/<147>/","2D2",$alg);    $alg = preg_replace("/<148>/","2D",$alg);
    
    $alg = preg_replace("/<149>/","3BR2'",$alg);   $alg = preg_replace("/<150>/","3BR'",$alg);   $alg = preg_replace("/<151>/","3BR2",$alg);   $alg = preg_replace("/<152>/","3BR",$alg);
    $alg = preg_replace("/<153>/","3BL2'",$alg);   $alg = preg_replace("/<154>/","3BL'",$alg);   $alg = preg_replace("/<155>/","3BL2",$alg);   $alg = preg_replace("/<156>/","3BL",$alg);
    $alg = preg_replace("/<157>/","3FR2'",$alg);   $alg = preg_replace("/<158>/","3FR'",$alg);   $alg = preg_replace("/<159>/","3FR2",$alg);   $alg = preg_replace("/<160>/","3FR",$alg);
    $alg = preg_replace("/<161>/","3FL2'",$alg);   $alg = preg_replace("/<162>/","3FL'",$alg);   $alg = preg_replace("/<163>/","3FL2",$alg);   $alg = preg_replace("/<164>/","3FL",$alg);
    $alg = preg_replace("/<165>/","3DR2'",$alg);   $alg = preg_replace("/<166>/","3DR'",$alg);   $alg = preg_replace("/<167>/","3DR2",$alg);   $alg = preg_replace("/<168>/","3DR",$alg);
    $alg = preg_replace("/<169>/","3DL2'",$alg);   $alg = preg_replace("/<170>/","3DL'",$alg);   $alg = preg_replace("/<171>/","3DL2",$alg);   $alg = preg_replace("/<172>/","3DL",$alg);
    
    $alg = preg_replace("/<173>/","3R2'",$alg);    $alg = preg_replace("/<174>/","3R'",$alg);    $alg = preg_replace("/<175>/","3R2",$alg);    $alg = preg_replace("/<176>/","3R",$alg);
    $alg = preg_replace("/<177>/","3L2'",$alg);    $alg = preg_replace("/<178>/","3L'",$alg);    $alg = preg_replace("/<179>/","3L2",$alg);    $alg = preg_replace("/<180>/","3L",$alg);
    $alg = preg_replace("/<181>/","3F2'",$alg);    $alg = preg_replace("/<182>/","3F'",$alg);    $alg = preg_replace("/<183>/","3F2",$alg);    $alg = preg_replace("/<184>/","3F",$alg);
    $alg = preg_replace("/<185>/","3B2'",$alg);    $alg = preg_replace("/<186>/","3B'",$alg);    $alg = preg_replace("/<187>/","3B2",$alg);    $alg = preg_replace("/<188>/","3B",$alg);
    $alg = preg_replace("/<189>/","3U2'",$alg);    $alg = preg_replace("/<190>/","3U'",$alg);    $alg = preg_replace("/<191>/","3U2",$alg);    $alg = preg_replace("/<192>/","3U",$alg);
    $alg = preg_replace("/<193>/","3D2'",$alg);    $alg = preg_replace("/<194>/","3D'",$alg);    $alg = preg_replace("/<195>/","3D2",$alg);    $alg = preg_replace("/<196>/","3D",$alg);
    
    /* --- 5xD: CODE -> TWIZZLE: [2] Slice twists --- */
    $alg = preg_replace("/<201>/","br2' fl2",$alg);   $alg = preg_replace("/<202>/","br' fl",$alg);   $alg = preg_replace("/<203>/","br2 fl2'",$alg);   $alg = preg_replace("/<204>/","br fl'",$alg);
    $alg = preg_replace("/<205>/","bl2' fr2",$alg);   $alg = preg_replace("/<206>/","bl' fr",$alg);   $alg = preg_replace("/<207>/","bl2 fr2'",$alg);   $alg = preg_replace("/<208>/","bl fr'",$alg);
    $alg = preg_replace("/<209>/","fr2' bl2",$alg);   $alg = preg_replace("/<210>/","fr' bl",$alg);   $alg = preg_replace("/<211>/","fr2 bl2'",$alg);   $alg = preg_replace("/<212>/","fr bl'",$alg);
    $alg = preg_replace("/<213>/","fl2' br2",$alg);   $alg = preg_replace("/<214>/","fl' br",$alg);   $alg = preg_replace("/<215>/","fl2 br2'",$alg);   $alg = preg_replace("/<216>/","fl br'",$alg);
    $alg = preg_replace("/<217>/","dr2' l2",$alg);    $alg = preg_replace("/<218>/","dr' l",$alg);    $alg = preg_replace("/<219>/","dr2 l2'",$alg);    $alg = preg_replace("/<220>/","dr l'",$alg);
    $alg = preg_replace("/<221>/","dl2' r2",$alg);    $alg = preg_replace("/<222>/","dl' r",$alg);    $alg = preg_replace("/<223>/","dl2 r2'",$alg);    $alg = preg_replace("/<224>/","dl r'",$alg);
    
    $alg = preg_replace("/<225>/","r2' dl2",$alg);    $alg = preg_replace("/<226>/","r' dl",$alg);    $alg = preg_replace("/<227>/","r2 dl2'",$alg);    $alg = preg_replace("/<228>/","r dl'",$alg);
    $alg = preg_replace("/<229>/","l2' dr2",$alg);    $alg = preg_replace("/<230>/","l' dr",$alg);    $alg = preg_replace("/<231>/","l2 dr2'",$alg);    $alg = preg_replace("/<232>/","l dr'",$alg);
    $alg = preg_replace("/<233>/","f2' b2",$alg);     $alg = preg_replace("/<234>/","f' b",$alg);     $alg = preg_replace("/<235>/","f2 b2'",$alg);     $alg = preg_replace("/<236>/","f b'",$alg);
    $alg = preg_replace("/<237>/","b2' f2",$alg);     $alg = preg_replace("/<238>/","b' f",$alg);     $alg = preg_replace("/<239>/","b2 f2'",$alg);     $alg = preg_replace("/<240>/","b f'",$alg);
    $alg = preg_replace("/<241>/","u2' d2",$alg);     $alg = preg_replace("/<242>/","u' d",$alg);     $alg = preg_replace("/<243>/","u2 d2'",$alg);     $alg = preg_replace("/<244>/","u d'",$alg);
    $alg = preg_replace("/<245>/","d2' u2",$alg);     $alg = preg_replace("/<246>/","d' u",$alg);     $alg = preg_replace("/<247>/","d2 u2'",$alg);     $alg = preg_replace("/<248>/","d u'",$alg);
    
    $alg = preg_replace("/<249>/","BR2' FL2",$alg);   $alg = preg_replace("/<250>/","BR' FL",$alg);   $alg = preg_replace("/<251>/","BR2 FL2'",$alg);   $alg = preg_replace("/<252>/","BR FL'",$alg);
    $alg = preg_replace("/<253>/","BL2' FR2",$alg);   $alg = preg_replace("/<254>/","BL' FR",$alg);   $alg = preg_replace("/<255>/","BL2 FR2'",$alg);   $alg = preg_replace("/<256>/","BL FR'",$alg);
    $alg = preg_replace("/<257>/","FR2' BL2",$alg);   $alg = preg_replace("/<258>/","FR' BL",$alg);   $alg = preg_replace("/<259>/","FR2 BL2'",$alg);   $alg = preg_replace("/<260>/","FR BL'",$alg);
    $alg = preg_replace("/<261>/","FL2' BR2",$alg);   $alg = preg_replace("/<262>/","FL' BR",$alg);   $alg = preg_replace("/<263>/","FL2 BR2'",$alg);   $alg = preg_replace("/<264>/","FL BR'",$alg);
    $alg = preg_replace("/<265>/","DR2' L2",$alg);    $alg = preg_replace("/<266>/","DR' L",$alg);    $alg = preg_replace("/<267>/","DR2 L2'",$alg);    $alg = preg_replace("/<268>/","DR L'",$alg);
    $alg = preg_replace("/<269>/","DL2' R2",$alg);    $alg = preg_replace("/<270>/","DL' R",$alg);    $alg = preg_replace("/<271>/","DL2 R2'",$alg);    $alg = preg_replace("/<272>/","DL R'",$alg);
    
    $alg = preg_replace("/<273>/","R2' DL2",$alg);    $alg = preg_replace("/<274>/","R' DL",$alg);    $alg = preg_replace("/<275>/","R2 DL2'",$alg);    $alg = preg_replace("/<276>/","R DL'",$alg);
    $alg = preg_replace("/<277>/","L2' DR2",$alg);    $alg = preg_replace("/<278>/","L' DR",$alg);    $alg = preg_replace("/<279>/","L2 DR2'",$alg);    $alg = preg_replace("/<280>/","L DR'",$alg);
    $alg = preg_replace("/<281>/","F2' B2",$alg);     $alg = preg_replace("/<282>/","F' B",$alg);     $alg = preg_replace("/<283>/","F2 B2'",$alg);     $alg = preg_replace("/<284>/","F B'",$alg);
    $alg = preg_replace("/<285>/","B2' F2",$alg);     $alg = preg_replace("/<286>/","B' F",$alg);     $alg = preg_replace("/<287>/","B2 F2'",$alg);     $alg = preg_replace("/<288>/","B F'",$alg);
    $alg = preg_replace("/<289>/","U2' D2",$alg);     $alg = preg_replace("/<290>/","U' D",$alg);     $alg = preg_replace("/<291>/","U2 D2'",$alg);     $alg = preg_replace("/<292>/","U D'",$alg);
    $alg = preg_replace("/<293>/","D2' U2",$alg);     $alg = preg_replace("/<294>/","D' U",$alg);     $alg = preg_replace("/<295>/","D2 U2'",$alg);     $alg = preg_replace("/<296>/","D U'",$alg);
    
    /* --- 5xD: CODE -> TWIZZLE: [3] Tier twists --- */
    $alg = preg_replace("/<301>/","1-4BR2'",$alg);   $alg = preg_replace("/<302>/","1-4BR'",$alg);   $alg = preg_replace("/<303>/","1-4BR2",$alg);   $alg = preg_replace("/<304>/","1-4BR",$alg);
    $alg = preg_replace("/<305>/","1-4BL2'",$alg);   $alg = preg_replace("/<306>/","1-4BL'",$alg);   $alg = preg_replace("/<307>/","1-4BL2",$alg);   $alg = preg_replace("/<308>/","1-4BL",$alg);
    $alg = preg_replace("/<309>/","1-4FR2'",$alg);   $alg = preg_replace("/<310>/","1-4FR'",$alg);   $alg = preg_replace("/<311>/","1-4FR2",$alg);   $alg = preg_replace("/<312>/","1-4FR",$alg);
    $alg = preg_replace("/<313>/","1-4FL2'",$alg);   $alg = preg_replace("/<314>/","1-4FL'",$alg);   $alg = preg_replace("/<315>/","1-4FL2",$alg);   $alg = preg_replace("/<316>/","1-4FL",$alg);
    $alg = preg_replace("/<317>/","1-4DR2'",$alg);   $alg = preg_replace("/<318>/","1-4DR'",$alg);   $alg = preg_replace("/<319>/","1-4DR2",$alg);   $alg = preg_replace("/<320>/","1-4DR",$alg);
    $alg = preg_replace("/<321>/","1-4DL2'",$alg);   $alg = preg_replace("/<322>/","1-4DL'",$alg);   $alg = preg_replace("/<323>/","1-4DL2",$alg);   $alg = preg_replace("/<324>/","1-4DL",$alg);
    
    $alg = preg_replace("/<325>/","1-4R2'",$alg);    $alg = preg_replace("/<326>/","1-4R'",$alg);    $alg = preg_replace("/<327>/","1-4R2",$alg);    $alg = preg_replace("/<328>/","1-4R",$alg);
    $alg = preg_replace("/<329>/","1-4L2'",$alg);    $alg = preg_replace("/<330>/","1-4L'",$alg);    $alg = preg_replace("/<331>/","1-4L2",$alg);    $alg = preg_replace("/<332>/","1-4L",$alg);
    $alg = preg_replace("/<333>/","1-4F2'",$alg);    $alg = preg_replace("/<334>/","1-4F'",$alg);    $alg = preg_replace("/<335>/","1-4F2",$alg);    $alg = preg_replace("/<336>/","1-4F",$alg);
    $alg = preg_replace("/<337>/","1-4B2'",$alg);    $alg = preg_replace("/<338>/","1-4B'",$alg);    $alg = preg_replace("/<339>/","1-4B2",$alg);    $alg = preg_replace("/<340>/","1-4B",$alg);
    $alg = preg_replace("/<341>/","1-4U2'",$alg);    $alg = preg_replace("/<342>/","1-4U'",$alg);    $alg = preg_replace("/<343>/","1-4U2",$alg);    $alg = preg_replace("/<344>/","1-4U",$alg);
    $alg = preg_replace("/<345>/","1-4D2'",$alg);    $alg = preg_replace("/<346>/","1-4D'",$alg);    $alg = preg_replace("/<347>/","1-4D2",$alg);    $alg = preg_replace("/<348>/","1-4D",$alg);
    
    $alg = preg_replace("/<349>/","1-3BR2'",$alg);   $alg = preg_replace("/<350>/","1-3BR'",$alg);   $alg = preg_replace("/<351>/","1-3BR2",$alg);   $alg = preg_replace("/<352>/","1-3BR",$alg);
    $alg = preg_replace("/<353>/","1-3BL2'",$alg);   $alg = preg_replace("/<354>/","1-3BL'",$alg);   $alg = preg_replace("/<355>/","1-3BL2",$alg);   $alg = preg_replace("/<356>/","1-3BL",$alg);
    $alg = preg_replace("/<357>/","1-3FR2'",$alg);   $alg = preg_replace("/<358>/","1-3FR'",$alg);   $alg = preg_replace("/<359>/","1-3FR2",$alg);   $alg = preg_replace("/<360>/","1-3FR",$alg);
    $alg = preg_replace("/<361>/","1-3FL2'",$alg);   $alg = preg_replace("/<362>/","1-3FL'",$alg);   $alg = preg_replace("/<363>/","1-3FL2",$alg);   $alg = preg_replace("/<364>/","1-3FL",$alg);
    $alg = preg_replace("/<365>/","1-3DR2'",$alg);   $alg = preg_replace("/<366>/","1-3DR'",$alg);   $alg = preg_replace("/<367>/","1-3DR2",$alg);   $alg = preg_replace("/<368>/","1-3DR",$alg);
    $alg = preg_replace("/<369>/","1-3DL2'",$alg);   $alg = preg_replace("/<370>/","1-3DL'",$alg);   $alg = preg_replace("/<371>/","1-3DL2",$alg);   $alg = preg_replace("/<372>/","1-3DL",$alg);
    
    $alg = preg_replace("/<373>/","1-3R2'",$alg);    $alg = preg_replace("/<374>/","1-3R'",$alg);    $alg = preg_replace("/<375>/","1-3R2",$alg);    $alg = preg_replace("/<376>/","1-3R",$alg);
    $alg = preg_replace("/<377>/","1-3L2'",$alg);    $alg = preg_replace("/<378>/","1-3L'",$alg);    $alg = preg_replace("/<379>/","1-3L2",$alg);    $alg = preg_replace("/<380>/","1-3L",$alg);
    $alg = preg_replace("/<381>/","1-3F2'",$alg);    $alg = preg_replace("/<382>/","1-3F'",$alg);    $alg = preg_replace("/<383>/","1-3F2",$alg);    $alg = preg_replace("/<384>/","1-3F",$alg);
    $alg = preg_replace("/<385>/","1-3B2'",$alg);    $alg = preg_replace("/<386>/","1-3B'",$alg);    $alg = preg_replace("/<387>/","1-3B2",$alg);    $alg = preg_replace("/<388>/","1-3B",$alg);
    $alg = preg_replace("/<389>/","1-3U2'",$alg);    $alg = preg_replace("/<390>/","1-3U'",$alg);    $alg = preg_replace("/<391>/","1-3U2",$alg);    $alg = preg_replace("/<392>/","1-3U",$alg);
    $alg = preg_replace("/<393>/","1-3D2'",$alg);    $alg = preg_replace("/<394>/","1-3D'",$alg);    $alg = preg_replace("/<395>/","1-3D2",$alg);    $alg = preg_replace("/<396>/","1-3D",$alg);
    
    $alg = preg_replace("/<397>/","br2'",$alg);    $alg = preg_replace("/<398>/","br'",$alg);    $alg = preg_replace("/<399>/","br2",$alg);    $alg = preg_replace("/<3100>/","br",$alg);
    $alg = preg_replace("/<3101>/","bl2'",$alg);   $alg = preg_replace("/<3102>/","bl'",$alg);   $alg = preg_replace("/<3103>/","bl2",$alg);   $alg = preg_replace("/<3104>/","bl",$alg);
    $alg = preg_replace("/<3105>/","fr2'",$alg);   $alg = preg_replace("/<3106>/","fr'",$alg);   $alg = preg_replace("/<3107>/","fr2",$alg);   $alg = preg_replace("/<3108>/","fr",$alg);
    $alg = preg_replace("/<3109>/","fl2'",$alg);   $alg = preg_replace("/<3110>/","fl'",$alg);   $alg = preg_replace("/<3111>/","fl2",$alg);   $alg = preg_replace("/<3112>/","fl",$alg);
    $alg = preg_replace("/<3113>/","dr2'",$alg);   $alg = preg_replace("/<3114>/","dr'",$alg);   $alg = preg_replace("/<3115>/","dr2",$alg);   $alg = preg_replace("/<3116>/","dr",$alg);
    $alg = preg_replace("/<3117>/","dl2'",$alg);   $alg = preg_replace("/<3118>/","dl'",$alg);   $alg = preg_replace("/<3119>/","dl2",$alg);   $alg = preg_replace("/<3120>/","dl",$alg);
    
    $alg = preg_replace("/<3121>/","r2'",$alg);    $alg = preg_replace("/<3122>/","r'",$alg);    $alg = preg_replace("/<3123>/","r2",$alg);    $alg = preg_replace("/<3124>/","r",$alg);
    $alg = preg_replace("/<3125>/","l2'",$alg);    $alg = preg_replace("/<3126>/","l'",$alg);    $alg = preg_replace("/<3127>/","l2",$alg);    $alg = preg_replace("/<3128>/","l",$alg);
    $alg = preg_replace("/<3129>/","f2'",$alg);    $alg = preg_replace("/<3130>/","f'",$alg);    $alg = preg_replace("/<3131>/","f2",$alg);    $alg = preg_replace("/<3132>/","f",$alg);
    $alg = preg_replace("/<3133>/","b2'",$alg);    $alg = preg_replace("/<3134>/","b'",$alg);    $alg = preg_replace("/<3135>/","b2",$alg);    $alg = preg_replace("/<3136>/","b",$alg);
    $alg = preg_replace("/<3137>/","u2'",$alg);    $alg = preg_replace("/<3138>/","u'",$alg);    $alg = preg_replace("/<3139>/","u2",$alg);    $alg = preg_replace("/<3140>/","u",$alg);
    $alg = preg_replace("/<3141>/","d2'",$alg);    $alg = preg_replace("/<3142>/","d'",$alg);    $alg = preg_replace("/<3143>/","d2",$alg);    $alg = preg_replace("/<3144>/","d",$alg);
    
    /* --- 5xD: CODE -> TWIZZLE: [4] (Void twists) --- */
    $alg = preg_replace("/<401>/","2-3BR2'",$alg);   $alg = preg_replace("/<402>/","2-3BR'",$alg);   $alg = preg_replace("/<403>/","2-3BR2",$alg);   $alg = preg_replace("/<404>/","2-3BR",$alg);
    $alg = preg_replace("/<405>/","2-3BL2'",$alg);   $alg = preg_replace("/<406>/","2-3BL'",$alg);   $alg = preg_replace("/<407>/","2-3BL2",$alg);   $alg = preg_replace("/<408>/","2-3BL",$alg);
    $alg = preg_replace("/<409>/","2-3FR2'",$alg);   $alg = preg_replace("/<410>/","2-3FR'",$alg);   $alg = preg_replace("/<411>/","2-3FR2",$alg);   $alg = preg_replace("/<412>/","2-3FR",$alg);
    $alg = preg_replace("/<413>/","2-3FL2'",$alg);   $alg = preg_replace("/<414>/","2-3FL'",$alg);   $alg = preg_replace("/<415>/","2-3FL2",$alg);   $alg = preg_replace("/<416>/","2-3FL",$alg);
    $alg = preg_replace("/<417>/","2-3DR2'",$alg);   $alg = preg_replace("/<418>/","2-3DR'",$alg);   $alg = preg_replace("/<419>/","2-3DR2",$alg);   $alg = preg_replace("/<420>/","2-3DR",$alg);
    $alg = preg_replace("/<421>/","2-3DL2'",$alg);   $alg = preg_replace("/<422>/","2-3DL'",$alg);   $alg = preg_replace("/<423>/","2-3DL2",$alg);   $alg = preg_replace("/<424>/","2-3DL",$alg);
    
    $alg = preg_replace("/<425>/","2-3R2'",$alg);    $alg = preg_replace("/<426>/","2-3R'",$alg);    $alg = preg_replace("/<427>/","2-3R2",$alg);    $alg = preg_replace("/<428>/","2-3R",$alg);
    $alg = preg_replace("/<429>/","2-3L2'",$alg);    $alg = preg_replace("/<430>/","2-3L'",$alg);    $alg = preg_replace("/<431>/","2-3L2",$alg);    $alg = preg_replace("/<432>/","2-3L",$alg);
    $alg = preg_replace("/<433>/","2-3F2'",$alg);    $alg = preg_replace("/<434>/","2-3F'",$alg);    $alg = preg_replace("/<435>/","2-3F2",$alg);    $alg = preg_replace("/<436>/","2-3F",$alg);
    $alg = preg_replace("/<437>/","2-3B2'",$alg);    $alg = preg_replace("/<438>/","2-3B'",$alg);    $alg = preg_replace("/<439>/","2-3B2",$alg);    $alg = preg_replace("/<440>/","2-3B",$alg);
    $alg = preg_replace("/<441>/","2-3U2'",$alg);    $alg = preg_replace("/<442>/","2-3U'",$alg);    $alg = preg_replace("/<443>/","2-3U2",$alg);    $alg = preg_replace("/<444>/","2-3U",$alg);
    $alg = preg_replace("/<445>/","2-3D2'",$alg);    $alg = preg_replace("/<446>/","2-3D'",$alg);    $alg = preg_replace("/<447>/","2-3D2",$alg);    $alg = preg_replace("/<448>/","2-3D",$alg);
    
    /* --- 5xD: CODE -> TWIZZLE: [6] Wide-layer twists [5] (Mid-layer twists) --- */
    $alg = preg_replace("/<501>/","2-4BR2'",$alg);   $alg = preg_replace("/<502>/","2-4BR'",$alg);   $alg = preg_replace("/<503>/","2-4BR2",$alg);   $alg = preg_replace("/<504>/","2-4BR",$alg);
    $alg = preg_replace("/<505>/","2-4BL2'",$alg);   $alg = preg_replace("/<506>/","2-4BL'",$alg);   $alg = preg_replace("/<507>/","2-4BL2",$alg);   $alg = preg_replace("/<508>/","2-4BL",$alg);
    $alg = preg_replace("/<509>/","2-4FR2'",$alg);   $alg = preg_replace("/<510>/","2-4FR'",$alg);   $alg = preg_replace("/<511>/","2-4FR2",$alg);   $alg = preg_replace("/<512>/","2-4FR",$alg);
    $alg = preg_replace("/<513>/","2-4FL2'",$alg);   $alg = preg_replace("/<514>/","2-4FL'",$alg);   $alg = preg_replace("/<515>/","2-4FL2",$alg);   $alg = preg_replace("/<516>/","2-4FL",$alg);
    $alg = preg_replace("/<517>/","2-4DR2'",$alg);   $alg = preg_replace("/<518>/","2-4DR'",$alg);   $alg = preg_replace("/<519>/","2-4DR2",$alg);   $alg = preg_replace("/<520>/","2-4DR",$alg);
    $alg = preg_replace("/<521>/","2-4DL2'",$alg);   $alg = preg_replace("/<522>/","2-4DL'",$alg);   $alg = preg_replace("/<523>/","2-4DL2",$alg);   $alg = preg_replace("/<524>/","2-4DL",$alg);
    
    $alg = preg_replace("/<525>/","2-4R2'",$alg);    $alg = preg_replace("/<526>/","2-4R'",$alg);    $alg = preg_replace("/<527>/","2-4R2",$alg);    $alg = preg_replace("/<528>/","2-4R",$alg);
    $alg = preg_replace("/<529>/","2-4L2'",$alg);    $alg = preg_replace("/<530>/","2-4L'",$alg);    $alg = preg_replace("/<531>/","2-4L2",$alg);    $alg = preg_replace("/<532>/","2-4L",$alg);
    $alg = preg_replace("/<533>/","2-4F2'",$alg);    $alg = preg_replace("/<534>/","2-4F'",$alg);    $alg = preg_replace("/<535>/","2-4F2",$alg);    $alg = preg_replace("/<536>/","2-4F",$alg);
    $alg = preg_replace("/<537>/","2-4B2'",$alg);    $alg = preg_replace("/<538>/","2-4B'",$alg);    $alg = preg_replace("/<539>/","2-4B2",$alg);    $alg = preg_replace("/<540>/","2-4B",$alg);
    $alg = preg_replace("/<541>/","2-4U2'",$alg);    $alg = preg_replace("/<542>/","2-4U'",$alg);    $alg = preg_replace("/<543>/","2-4U2",$alg);    $alg = preg_replace("/<544>/","2-4U",$alg);
    $alg = preg_replace("/<545>/","2-4D2'",$alg);    $alg = preg_replace("/<546>/","2-4D'",$alg);    $alg = preg_replace("/<547>/","2-4D2",$alg);    $alg = preg_replace("/<548>/","2-4D",$alg);
    
    /* --- 5xD: CODE -> TWIZZLE: [7] Dodecahedron rotations --- */
    $alg = preg_replace("/<701>/","BRv2'",$alg);   $alg = preg_replace("/<702>/","BRv'",$alg);   $alg = preg_replace("/<703>/","BRv2",$alg);   $alg = preg_replace("/<704>/","BRv",$alg);
    $alg = preg_replace("/<705>/","BLv2'",$alg);   $alg = preg_replace("/<706>/","BLv'",$alg);   $alg = preg_replace("/<707>/","BLv2",$alg);   $alg = preg_replace("/<708>/","BLv",$alg);
    $alg = preg_replace("/<709>/","FRv2'",$alg);   $alg = preg_replace("/<710>/","FRv'",$alg);   $alg = preg_replace("/<711>/","FRv2",$alg);   $alg = preg_replace("/<712>/","FRv",$alg);
    $alg = preg_replace("/<713>/","FLv2'",$alg);   $alg = preg_replace("/<714>/","FLv'",$alg);   $alg = preg_replace("/<715>/","FLv2",$alg);   $alg = preg_replace("/<716>/","FLv",$alg);
    $alg = preg_replace("/<717>/","DRv2'",$alg);   $alg = preg_replace("/<718>/","DRv'",$alg);   $alg = preg_replace("/<719>/","DRv2",$alg);   $alg = preg_replace("/<720>/","DRv",$alg);
    $alg = preg_replace("/<721>/","DLv2'",$alg);   $alg = preg_replace("/<722>/","DLv'",$alg);   $alg = preg_replace("/<723>/","DLv2",$alg);   $alg = preg_replace("/<724>/","DLv",$alg);
    
    $alg = preg_replace("/<725>/","Rv2'",$alg);    $alg = preg_replace("/<726>/","Rv'",$alg);    $alg = preg_replace("/<727>/","Rv2",$alg);    $alg = preg_replace("/<728>/","Rv",$alg);
    $alg = preg_replace("/<729>/","Lv2'",$alg);    $alg = preg_replace("/<730>/","Lv'",$alg);    $alg = preg_replace("/<731>/","Lv2",$alg);    $alg = preg_replace("/<732>/","Lv",$alg);
    $alg = preg_replace("/<733>/","Fv2'",$alg);    $alg = preg_replace("/<734>/","Fv'",$alg);    $alg = preg_replace("/<735>/","Fv2",$alg);    $alg = preg_replace("/<736>/","Fv",$alg);
    $alg = preg_replace("/<737>/","Bv2'",$alg);    $alg = preg_replace("/<738>/","Bv'",$alg);    $alg = preg_replace("/<739>/","Bv2",$alg);    $alg = preg_replace("/<740>/","Bv",$alg);
    $alg = preg_replace("/<741>/","Uv2'",$alg);    $alg = preg_replace("/<742>/","Uv'",$alg);    $alg = preg_replace("/<743>/","Uv2",$alg);    $alg = preg_replace("/<744>/","Uv",$alg);
    $alg = preg_replace("/<745>/","Dv2'",$alg);    $alg = preg_replace("/<746>/","Dv'",$alg);    $alg = preg_replace("/<747>/","Dv2",$alg);    $alg = preg_replace("/<748>/","Dv",$alg);
    
    /* --- 5xD: CODE -> TWIZZLE: [9] Face twists --- */
    $alg = preg_replace("/<901>/","BR2'",$alg);   $alg = preg_replace("/<902>/","BR'",$alg);   $alg = preg_replace("/<903>/","BR2",$alg);   $alg = preg_replace("/<904>/","BR",$alg);
    $alg = preg_replace("/<905>/","BL2'",$alg);   $alg = preg_replace("/<906>/","BL'",$alg);   $alg = preg_replace("/<907>/","BL2",$alg);   $alg = preg_replace("/<908>/","BL",$alg);
    $alg = preg_replace("/<909>/","FR2'",$alg);   $alg = preg_replace("/<910>/","FR'",$alg);   $alg = preg_replace("/<911>/","FR2",$alg);   $alg = preg_replace("/<912>/","FR",$alg);
    $alg = preg_replace("/<913>/","FL2'",$alg);   $alg = preg_replace("/<914>/","FL'",$alg);   $alg = preg_replace("/<915>/","FL2",$alg);   $alg = preg_replace("/<916>/","FL",$alg);
    $alg = preg_replace("/<917>/","DR2'",$alg);   $alg = preg_replace("/<918>/","DR'",$alg);   $alg = preg_replace("/<919>/","DR2",$alg);   $alg = preg_replace("/<920>/","DR",$alg);
    $alg = preg_replace("/<921>/","DL2'",$alg);   $alg = preg_replace("/<922>/","DL'",$alg);   $alg = preg_replace("/<923>/","DL2",$alg);   $alg = preg_replace("/<924>/","DL",$alg);
    
    $alg = preg_replace("/<925>/","R2'",$alg);    $alg = preg_replace("/<926>/","R'",$alg);    $alg = preg_replace("/<927>/","R2",$alg);    $alg = preg_replace("/<928>/","R",$alg);
    $alg = preg_replace("/<929>/","L2'",$alg);    $alg = preg_replace("/<930>/","L'",$alg);    $alg = preg_replace("/<931>/","L2",$alg);    $alg = preg_replace("/<932>/","L",$alg);
    $alg = preg_replace("/<933>/","F2'",$alg);    $alg = preg_replace("/<934>/","F'",$alg);    $alg = preg_replace("/<935>/","F2",$alg);    $alg = preg_replace("/<936>/","F",$alg);
    $alg = preg_replace("/<937>/","B2'",$alg);    $alg = preg_replace("/<938>/","B'",$alg);    $alg = preg_replace("/<939>/","B2",$alg);    $alg = preg_replace("/<940>/","B",$alg);
    $alg = preg_replace("/<941>/","U2'",$alg);    $alg = preg_replace("/<942>/","U'",$alg);    $alg = preg_replace("/<943>/","U2",$alg);    $alg = preg_replace("/<944>/","U",$alg);
    $alg = preg_replace("/<945>/","D2'",$alg);    $alg = preg_replace("/<946>/","D'",$alg);    $alg = preg_replace("/<947>/","D2",$alg);    $alg = preg_replace("/<948>/","D",$alg);
    
    return $alg;
  }
  
  
  
  
  /* 
  ---------------------------------------------------------------------------------------------------
  * alg5xD_OldTwizzleToTwizzle($alg)
  * 
  * Converts 5x5 Gigaminx Old Twizzle algorithms into Twizzle notation.
  * 
  * Parameter: $alg (STRING): The algorithm.
  * 
  * Return: STRING.
  ---------------------------------------------------------------------------------------------------
  */
  function alg5xD_OldTwizzleToTwizzle($alg) {
    /* --- Dodecahedron Twists --- */
    //   +0°  = R0, []     = -360° = R5', []
    //  +72°  = R1, [R]    = -288° = R4', [R]
    // +144°  = R2, [R2]   = -216° = R3', [R2]
    // +216°  = R3, [R2']  = -144° = R2', [R2']
    // +288°  = R4, [R']   =  -72° = R1', [R']
    // +360°  = R5, []     =   -0° = R0', []
    
    /* ··································································································· */
    /* --- 5xD: OLD TWIZZLE -> TWIZZLE --- */
    $alg = str_replace("BF","B",$alg);
    
    $alg = str_replace("bf","b",$alg);
    
    $alg = str_replace("A","FL",$alg);
    $alg = str_replace("C","FR",$alg);
    $alg = str_replace("E","DR",$alg);
    $alg = str_replace("I","DL",$alg);
    
    $alg = str_replace("a","fl",$alg);
    $alg = str_replace("c","fr",$alg);
    $alg = str_replace("e","dr",$alg);
    $alg = str_replace("i","dl",$alg);
    
    return $alg;
  }
  
  
  
  
  /* 
  ---------------------------------------------------------------------------------------------------
  * alg5xD_TwizzleToSse($alg)
  * 
  * Converts 5x5 Gigaminx TWIZZLE algorithms into SSE notation.
  * 
  * Parameter: $alg (STRING): The algorithm.
  * 
  * Return: STRING.
  ---------------------------------------------------------------------------------------------------
  */
  function alg5xD_TwizzleToSse($alg) {
    /* --- Dodecahedron Twists --- */
    //   +0°  = R0, []     = -360° = R5', []
    //  +72°  = R1, [R]    = -288° = R4', [R]
    // +144°  = R2, [R2]   = -216° = R3', [R2]
    // +216°  = R3, [R2']  = -144° = R2', [R2']
    // +288°  = R4, [R']   =  -72° = R1', [R']
    // +360°  = R5, []     =   -0° = R0', []
    
    /* --- 5xD: Marker --- */
    $alg = str_replace(".","·",$alg);
    
    /* ··································································································· */
    /* --- 5xD: OLD TWIZZLE -> CODE: [3] Tier twists (SiGN) --- */
    $alg = preg_replace("/1-4BF2'/","<337>",$alg);   $alg = preg_replace("/1-4BF'/","<338>",$alg);   $alg = preg_replace("/1-4BF2/","<339>",$alg);      $alg = preg_replace("/1-4BF/","<340>",$alg); // BF -> B.
    
    $alg = preg_replace("/1-4C2'/","<309>",$alg);   $alg = preg_replace("/1-4C'/","<310>",$alg);   $alg = preg_replace("/1-4C2/","<311>",$alg);      $alg = preg_replace("/1-4C/","<312>",$alg); // C -> FR.
    $alg = preg_replace("/1-4A2'/","<313>",$alg);   $alg = preg_replace("/1-4A'/","<314>",$alg);   $alg = preg_replace("/1-4A2/","<315>",$alg);      $alg = preg_replace("/1-4A/","<316>",$alg); // A -> FL.
    $alg = preg_replace("/1-4E2'/","<317>",$alg);   $alg = preg_replace("/1-4E'/","<318>",$alg);   $alg = preg_replace("/1-4E2/","<319>",$alg);      $alg = preg_replace("/1-4E/","<320>",$alg); // E -> DR.
    $alg = preg_replace("/1-4I2'/","<321>",$alg);   $alg = preg_replace("/1-4I'/","<322>",$alg);   $alg = preg_replace("/1-4I2/","<323>",$alg);      $alg = preg_replace("/1-4I/","<324>",$alg); // I -> DL.
    
    /* --- 5xD: TWIZZLE -> CODE: [3] Tier twists (SiGN) --- */
    $alg = preg_replace("/1-4BR2'/","<301>",$alg);   $alg = preg_replace("/1-4BR'/","<302>",$alg);   $alg = preg_replace("/1-4BR2/","<303>",$alg);      $alg = preg_replace("/1-4BR/","<304>",$alg);
    $alg = preg_replace("/1-4BL2'/","<305>",$alg);   $alg = preg_replace("/1-4BL'/","<306>",$alg);   $alg = preg_replace("/1-4BL2/","<307>",$alg);      $alg = preg_replace("/1-4BL/","<308>",$alg);
    $alg = preg_replace("/1-4FR2'/","<309>",$alg);   $alg = preg_replace("/1-4FR'/","<310>",$alg);   $alg = preg_replace("/1-4FR2/","<311>",$alg);      $alg = preg_replace("/1-4FR/","<312>",$alg);
    $alg = preg_replace("/1-4FL2'/","<313>",$alg);   $alg = preg_replace("/1-4FL'/","<314>",$alg);   $alg = preg_replace("/1-4FL2/","<315>",$alg);      $alg = preg_replace("/1-4FL/","<316>",$alg);
    $alg = preg_replace("/1-4DR2'/","<317>",$alg);   $alg = preg_replace("/1-4DR'/","<318>",$alg);   $alg = preg_replace("/1-4DR2/","<319>",$alg);      $alg = preg_replace("/1-4DR/","<320>",$alg);
    $alg = preg_replace("/1-4DL2'/","<321>",$alg);   $alg = preg_replace("/1-4DL'/","<322>",$alg);   $alg = preg_replace("/1-4DL2/","<323>",$alg);      $alg = preg_replace("/1-4DL/","<324>",$alg);
    
    $alg = preg_replace("/1-4R2'/","<325>",$alg);    $alg = preg_replace("/1-4R'/","<326>",$alg);    $alg = preg_replace("/1-4R2/","<327>",$alg);       $alg = preg_replace("/1-4R/","<328>",$alg);
    $alg = preg_replace("/1-4L2'/","<329>",$alg);    $alg = preg_replace("/1-4L'/","<330>",$alg);    $alg = preg_replace("/1-4L2/","<331>",$alg);       $alg = preg_replace("/1-4L/","<332>",$alg);
    $alg = preg_replace("/1-4F2'/","<333>",$alg);    $alg = preg_replace("/1-4F'/","<334>",$alg);    $alg = preg_replace("/1-4F2/","<335>",$alg);       $alg = preg_replace("/1-4F/","<336>",$alg);
    $alg = preg_replace("/1-4B2'/","<337>",$alg);    $alg = preg_replace("/1-4B'/","<338>",$alg);    $alg = preg_replace("/1-4B2/","<339>",$alg);       $alg = preg_replace("/1-4B/","<340>",$alg);
    $alg = preg_replace("/1-4U2'/","<341>",$alg);    $alg = preg_replace("/1-4U'/","<342>",$alg);    $alg = preg_replace("/1-4U2/","<343>",$alg);       $alg = preg_replace("/1-4U/","<344>",$alg);
    $alg = preg_replace("/1-4D2'/","<345>",$alg);    $alg = preg_replace("/1-4D'/","<346>",$alg);    $alg = preg_replace("/1-4D2/","<347>",$alg);       $alg = preg_replace("/1-4D/","<348>",$alg);
    
    /* --- 5xD: OLD TWIZZLE -> CODE: [3] Tier twists (SiGN) --- */
    $alg = preg_replace("/1-3BF2'/","<385>",$alg);    $alg = preg_replace("/1-3BF'/","<386>",$alg);    $alg = preg_replace("/1-3BF2/","<387>",$alg);       $alg = preg_replace("/1-3BF/","<388>",$alg); // BF -> B.
    
    $alg = preg_replace("/1-3C2'/","<357>",$alg);   $alg = preg_replace("/1-3C'/","<358>",$alg);   $alg = preg_replace("/1-3C2/","<359>",$alg);      $alg = preg_replace("/1-3C/","<360>",$alg); // C -> FR.
    $alg = preg_replace("/1-3A2'/","<361>",$alg);   $alg = preg_replace("/1-3A'/","<362>",$alg);   $alg = preg_replace("/1-3A2/","<363>",$alg);      $alg = preg_replace("/1-3A/","<364>",$alg); // A -> FL.
    $alg = preg_replace("/1-3E2'/","<365>",$alg);   $alg = preg_replace("/1-3E'/","<366>",$alg);   $alg = preg_replace("/1-3E2/","<367>",$alg);      $alg = preg_replace("/1-3E/","<368>",$alg); // E -> DR.
    $alg = preg_replace("/1-3I2'/","<369>",$alg);   $alg = preg_replace("/1-3I'/","<370>",$alg);   $alg = preg_replace("/1-3I2/","<371>",$alg);      $alg = preg_replace("/1-3I/","<372>",$alg); // I -> DL.
    
    /* --- 5xD: TWIZZLE -> CODE: [3] Tier twists (SiGN) --- */
    $alg = preg_replace("/1-3BR2'/","<349>",$alg);   $alg = preg_replace("/1-3BR'/","<350>",$alg);   $alg = preg_replace("/1-3BR2/","<351>",$alg);      $alg = preg_replace("/1-3BR/","<352>",$alg);
    $alg = preg_replace("/1-3BL2'/","<353>",$alg);   $alg = preg_replace("/1-3BL'/","<354>",$alg);   $alg = preg_replace("/1-3BL2/","<355>",$alg);      $alg = preg_replace("/1-3BL/","<356>",$alg);
    $alg = preg_replace("/1-3FR2'/","<357>",$alg);   $alg = preg_replace("/1-3FR'/","<358>",$alg);   $alg = preg_replace("/1-3FR2/","<359>",$alg);      $alg = preg_replace("/1-3FR/","<360>",$alg);
    $alg = preg_replace("/1-3FL2'/","<361>",$alg);   $alg = preg_replace("/1-3FL'/","<362>",$alg);   $alg = preg_replace("/1-3FL2/","<363>",$alg);      $alg = preg_replace("/1-3FL/","<364>",$alg);
    $alg = preg_replace("/1-3DR2'/","<365>",$alg);   $alg = preg_replace("/1-3DR'/","<366>",$alg);   $alg = preg_replace("/1-3DR2/","<367>",$alg);      $alg = preg_replace("/1-3DR/","<368>",$alg);
    $alg = preg_replace("/1-3DL2'/","<369>",$alg);   $alg = preg_replace("/1-3DL'/","<370>",$alg);   $alg = preg_replace("/1-3DL2/","<371>",$alg);      $alg = preg_replace("/1-3DL/","<372>",$alg);
    
    $alg = preg_replace("/1-3R2'/","<373>",$alg);    $alg = preg_replace("/1-3R'/","<374>",$alg);    $alg = preg_replace("/1-3R2/","<375>",$alg);       $alg = preg_replace("/1-3R/","<376>",$alg);
    $alg = preg_replace("/1-3L2'/","<377>",$alg);    $alg = preg_replace("/1-3L'/","<378>",$alg);    $alg = preg_replace("/1-3L2/","<379>",$alg);       $alg = preg_replace("/1-3L/","<380>",$alg);
    $alg = preg_replace("/1-3F2'/","<381>",$alg);    $alg = preg_replace("/1-3F'/","<382>",$alg);    $alg = preg_replace("/1-3F2/","<383>",$alg);       $alg = preg_replace("/1-3F/","<384>",$alg);
    $alg = preg_replace("/1-3B2'/","<385>",$alg);    $alg = preg_replace("/1-3B'/","<386>",$alg);    $alg = preg_replace("/1-3B2/","<387>",$alg);       $alg = preg_replace("/1-3B/","<388>",$alg);
    $alg = preg_replace("/1-3U2'/","<389>",$alg);    $alg = preg_replace("/1-3U'/","<390>",$alg);    $alg = preg_replace("/1-3U2/","<391>",$alg);       $alg = preg_replace("/1-3U/","<392>",$alg);
    $alg = preg_replace("/1-3D2'/","<393>",$alg);    $alg = preg_replace("/1-3D'/","<394>",$alg);    $alg = preg_replace("/1-3D2/","<395>",$alg);       $alg = preg_replace("/1-3D/","<396>",$alg);
    
    /* --- 5xD: OLD TWIZZLE -> CODE: [6] Wide twists --- */
    $alg = preg_replace("/2-4BF2'/","<637>",$alg);   $alg = preg_replace("/2-4BF'/","<638>",$alg);   $alg = preg_replace("/2-4BF2/","<639>",$alg);      $alg = preg_replace("/2-4BF/","<640>",$alg); // BF -> B.
    
    $alg = preg_replace("/2-4C2'/","<609>",$alg);   $alg = preg_replace("/2-4C'/","<610>",$alg);   $alg = preg_replace("/2-4C2/","<611>",$alg);      $alg = preg_replace("/2-4C/","<612>",$alg); // C -> FR.
    $alg = preg_replace("/2-4A2'/","<613>",$alg);   $alg = preg_replace("/2-4A'/","<614>",$alg);   $alg = preg_replace("/2-4A2/","<615>",$alg);      $alg = preg_replace("/2-4A/","<616>",$alg); // A -> FL.
    $alg = preg_replace("/2-4E2'/","<617>",$alg);   $alg = preg_replace("/2-4E'/","<618>",$alg);   $alg = preg_replace("/2-4E2/","<619>",$alg);      $alg = preg_replace("/2-4E/","<620>",$alg); // E -> DR.
    $alg = preg_replace("/2-4I2'/","<621>",$alg);   $alg = preg_replace("/2-4I'/","<622>",$alg);   $alg = preg_replace("/2-4I2/","<623>",$alg);      $alg = preg_replace("/2-4I/","<624>",$alg); // I -> DL.
    
    /* --- 5xD: TWIZZLE -> CODE: [6] Wide twists --- */
    $alg = preg_replace("/2-4BR2'/","<601>",$alg);   $alg = preg_replace("/2-4BR'/","<602>",$alg);   $alg = preg_replace("/2-4BR2/","<603>",$alg);      $alg = preg_replace("/2-4BR/","<604>",$alg);
    $alg = preg_replace("/2-4BL2'/","<605>",$alg);   $alg = preg_replace("/2-4BL'/","<606>",$alg);   $alg = preg_replace("/2-4BL2/","<607>",$alg);      $alg = preg_replace("/2-4BL/","<608>",$alg);
    $alg = preg_replace("/2-4FR2'/","<609>",$alg);   $alg = preg_replace("/2-4FR'/","<610>",$alg);   $alg = preg_replace("/2-4FR2/","<611>",$alg);      $alg = preg_replace("/2-4FR/","<612>",$alg);
    $alg = preg_replace("/2-4FL2'/","<613>",$alg);   $alg = preg_replace("/2-4FL'/","<614>",$alg);   $alg = preg_replace("/2-4FL2/","<615>",$alg);      $alg = preg_replace("/2-4FL/","<616>",$alg);
    $alg = preg_replace("/2-4DR2'/","<617>",$alg);   $alg = preg_replace("/2-4DR'/","<618>",$alg);   $alg = preg_replace("/2-4DR2/","<619>",$alg);      $alg = preg_replace("/2-4DR/","<620>",$alg);
    $alg = preg_replace("/2-4DL2'/","<621>",$alg);   $alg = preg_replace("/2-4DL'/","<622>",$alg);   $alg = preg_replace("/2-4DL2/","<623>",$alg);      $alg = preg_replace("/2-4DL/","<624>",$alg);
    
    $alg = preg_replace("/2-4R2'/","<625>",$alg);    $alg = preg_replace("/2-4R'/","<626>",$alg);    $alg = preg_replace("/2-4R2/","<627>",$alg);       $alg = preg_replace("/2-4R/","<628>",$alg);
    $alg = preg_replace("/2-4L2'/","<629>",$alg);    $alg = preg_replace("/2-4L'/","<630>",$alg);    $alg = preg_replace("/2-4L2/","<631>",$alg);       $alg = preg_replace("/2-4L/","<632>",$alg);
    $alg = preg_replace("/2-4F2'/","<633>",$alg);    $alg = preg_replace("/2-4F'/","<634>",$alg);    $alg = preg_replace("/2-4F2/","<635>",$alg);       $alg = preg_replace("/2-4F/","<636>",$alg);
    $alg = preg_replace("/2-4B2'/","<637>",$alg);    $alg = preg_replace("/2-4B'/","<638>",$alg);    $alg = preg_replace("/2-4B2/","<639>",$alg);       $alg = preg_replace("/2-4B/","<640>",$alg);
    $alg = preg_replace("/2-4U2'/","<641>",$alg);    $alg = preg_replace("/2-4U'/","<642>",$alg);    $alg = preg_replace("/2-4U2/","<643>",$alg);       $alg = preg_replace("/2-4U/","<644>",$alg);
    $alg = preg_replace("/2-4D2'/","<645>",$alg);    $alg = preg_replace("/2-4D'/","<646>",$alg);    $alg = preg_replace("/2-4D2/","<647>",$alg);       $alg = preg_replace("/2-4D/","<648>",$alg);
    
    /* --- 5xD: OLD TWIZZLE -> CODE: [4] Void twists --- */
    $alg = preg_replace("/2-3BF2'/","<437>",$alg);   $alg = preg_replace("/2-3BF'/","<438>",$alg);   $alg = preg_replace("/2-3BF2/","<439>",$alg);      $alg = preg_replace("/2-3BF/","<440>",$alg); // BF -> B.
    
    $alg = preg_replace("/2-3C2'/","<409>",$alg);   $alg = preg_replace("/2-3C'/","<410>",$alg);   $alg = preg_replace("/2-3C2/","<411>",$alg);      $alg = preg_replace("/2-3C/","<412>",$alg); // C -> FR.
    $alg = preg_replace("/2-3A2'/","<413>",$alg);   $alg = preg_replace("/2-3A'/","<414>",$alg);   $alg = preg_replace("/2-3A2/","<415>",$alg);      $alg = preg_replace("/2-3A/","<416>",$alg); // A -> FL.
    $alg = preg_replace("/2-3E2'/","<417>",$alg);   $alg = preg_replace("/2-3E'/","<418>",$alg);   $alg = preg_replace("/2-3E2/","<419>",$alg);      $alg = preg_replace("/2-3E/","<420>",$alg); // E -> DR.
    $alg = preg_replace("/2-3I2'/","<421>",$alg);   $alg = preg_replace("/2-3I'/","<422>",$alg);   $alg = preg_replace("/2-3I2/","<423>",$alg);      $alg = preg_replace("/2-3I/","<424>",$alg); // I -> DL.
    
    /* --- 5xD: TWIZZLE -> CODE: [4] Void twists --- */
    $alg = preg_replace("/2-3BR2'/","<401>",$alg);   $alg = preg_replace("/2-3BR'/","<402>",$alg);   $alg = preg_replace("/2-3BR2/","<403>",$alg);      $alg = preg_replace("/2-3BR/","<404>",$alg);
    $alg = preg_replace("/2-3BL2'/","<405>",$alg);   $alg = preg_replace("/2-3BL'/","<406>",$alg);   $alg = preg_replace("/2-3BL2/","<407>",$alg);      $alg = preg_replace("/2-3BL/","<408>",$alg);
    $alg = preg_replace("/2-3FR2'/","<409>",$alg);   $alg = preg_replace("/2-3FR'/","<410>",$alg);   $alg = preg_replace("/2-3FR2/","<411>",$alg);      $alg = preg_replace("/2-3FR/","<412>",$alg);
    $alg = preg_replace("/2-3FL2'/","<413>",$alg);   $alg = preg_replace("/2-3FL'/","<414>",$alg);   $alg = preg_replace("/2-3FL2/","<415>",$alg);      $alg = preg_replace("/2-3FL/","<416>",$alg);
    $alg = preg_replace("/2-3DR2'/","<417>",$alg);   $alg = preg_replace("/2-3DR'/","<418>",$alg);   $alg = preg_replace("/2-3DR2/","<419>",$alg);      $alg = preg_replace("/2-3DR/","<420>",$alg);
    $alg = preg_replace("/2-3DL2'/","<421>",$alg);   $alg = preg_replace("/2-3DL'/","<422>",$alg);   $alg = preg_replace("/2-3DL2/","<423>",$alg);      $alg = preg_replace("/2-3DL/","<424>",$alg);
    
    $alg = preg_replace("/2-3R2'/","<425>",$alg);    $alg = preg_replace("/2-3R'/","<426>",$alg);    $alg = preg_replace("/2-3R2/","<427>",$alg);       $alg = preg_replace("/2-3R/","<428>",$alg);
    $alg = preg_replace("/2-3L2'/","<429>",$alg);    $alg = preg_replace("/2-3L'/","<430>",$alg);    $alg = preg_replace("/2-3L2/","<431>",$alg);       $alg = preg_replace("/2-3L/","<432>",$alg);
    $alg = preg_replace("/2-3F2'/","<433>",$alg);    $alg = preg_replace("/2-3F'/","<434>",$alg);    $alg = preg_replace("/2-3F2/","<435>",$alg);       $alg = preg_replace("/2-3F/","<436>",$alg);
    $alg = preg_replace("/2-3B2'/","<437>",$alg);    $alg = preg_replace("/2-3B'/","<438>",$alg);    $alg = preg_replace("/2-3B2/","<439>",$alg);       $alg = preg_replace("/2-3B/","<440>",$alg);
    $alg = preg_replace("/2-3U2'/","<441>",$alg);    $alg = preg_replace("/2-3U'/","<442>",$alg);    $alg = preg_replace("/2-3U2/","<443>",$alg);       $alg = preg_replace("/2-3U/","<444>",$alg);
    $alg = preg_replace("/2-3D2'/","<445>",$alg);    $alg = preg_replace("/2-3D'/","<446>",$alg);    $alg = preg_replace("/2-3D2/","<447>",$alg);       $alg = preg_replace("/2-3D/","<448>",$alg);
    
    /* --- 5xD: OLD TWIZZLE -> CODE: [1] Numbered layer twists --- */
    $alg = preg_replace("/2BF2'/","<137>",$alg);   $alg = preg_replace("/2BF'/","<138>",$alg);   $alg = preg_replace("/2BF2/","<139>",$alg);      $alg = preg_replace("/2BF/","<140>",$alg); // BF -> B.
    
    $alg = preg_replace("/2C2'/","<109>",$alg);   $alg = preg_replace("/2C'/","<110>",$alg);   $alg = preg_replace("/2C2/","<111>",$alg);      $alg = preg_replace("/2C/","<112>",$alg); // C -> FR.
    $alg = preg_replace("/2A2'/","<113>",$alg);   $alg = preg_replace("/2A'/","<114>",$alg);   $alg = preg_replace("/2A2/","<115>",$alg);      $alg = preg_replace("/2A/","<116>",$alg); // A -> FL.
    $alg = preg_replace("/2E2'/","<117>",$alg);   $alg = preg_replace("/2E'/","<118>",$alg);   $alg = preg_replace("/2E2/","<119>",$alg);      $alg = preg_replace("/2E/","<120>",$alg); // E -> DR.
    $alg = preg_replace("/2I2'/","<121>",$alg);   $alg = preg_replace("/2I'/","<122>",$alg);   $alg = preg_replace("/2I2/","<123>",$alg);      $alg = preg_replace("/2I/","<124>",$alg); // I -> DL.
    
    /* --- 5xD: TWIZZLE -> CODE: [1] Numbered layer twists --- */
    $alg = preg_replace("/2BR2'/","<101>",$alg);   $alg = preg_replace("/2BR'/","<102>",$alg);   $alg = preg_replace("/2BR2/","<103>",$alg);      $alg = preg_replace("/2BR/","<104>",$alg);
    $alg = preg_replace("/2BL2'/","<105>",$alg);   $alg = preg_replace("/2BL'/","<106>",$alg);   $alg = preg_replace("/2BL2/","<107>",$alg);      $alg = preg_replace("/2BL/","<108>",$alg);
    $alg = preg_replace("/2FR2'/","<109>",$alg);   $alg = preg_replace("/2FR'/","<110>",$alg);   $alg = preg_replace("/2FR2/","<111>",$alg);      $alg = preg_replace("/2FR/","<112>",$alg);
    $alg = preg_replace("/2FL2'/","<113>",$alg);   $alg = preg_replace("/2FL'/","<114>",$alg);   $alg = preg_replace("/2FL2/","<115>",$alg);      $alg = preg_replace("/2FL/","<116>",$alg);
    $alg = preg_replace("/2DR2'/","<117>",$alg);   $alg = preg_replace("/2DR'/","<118>",$alg);   $alg = preg_replace("/2DR2/","<119>",$alg);      $alg = preg_replace("/2DR/","<120>",$alg);
    $alg = preg_replace("/2DL2'/","<121>",$alg);   $alg = preg_replace("/2DL'/","<122>",$alg);   $alg = preg_replace("/2DL2/","<123>",$alg);      $alg = preg_replace("/2DL/","<124>",$alg);
    
    $alg = preg_replace("/2R2'/","<125>",$alg);    $alg = preg_replace("/2R'/","<126>",$alg);    $alg = preg_replace("/2R2/","<127>",$alg);       $alg = preg_replace("/2R/","<128>",$alg);
    $alg = preg_replace("/2L2'/","<129>",$alg);    $alg = preg_replace("/2L'/","<130>",$alg);    $alg = preg_replace("/2L2/","<131>",$alg);       $alg = preg_replace("/2L/","<132>",$alg);
    $alg = preg_replace("/2F2'/","<133>",$alg);    $alg = preg_replace("/2F'/","<134>",$alg);    $alg = preg_replace("/2F2/","<135>",$alg);       $alg = preg_replace("/2F/","<136>",$alg);
    $alg = preg_replace("/2B2'/","<137>",$alg);    $alg = preg_replace("/2B'/","<138>",$alg);    $alg = preg_replace("/2B2/","<139>",$alg);       $alg = preg_replace("/2B/","<140>",$alg);
    $alg = preg_replace("/2U2'/","<141>",$alg);    $alg = preg_replace("/2U'/","<142>",$alg);    $alg = preg_replace("/2U2/","<143>",$alg);       $alg = preg_replace("/2U/","<144>",$alg);
    $alg = preg_replace("/2D2'/","<145>",$alg);    $alg = preg_replace("/2D'/","<146>",$alg);    $alg = preg_replace("/2D2/","<147>",$alg);       $alg = preg_replace("/2D/","<148>",$alg);
    
    /* --- 5xD: OLD TWIZZLE -> CODE: [5] Mid-layer [1] (Numbered layer) --- */
    $alg = preg_replace("/3BF2'/","<185>",$alg);   $alg = preg_replace("/3BF'/","<186>",$alg);   $alg = preg_replace("/3BF2/","<187>",$alg);      $alg = preg_replace("/3BF/","<188>",$alg); // BF -> B.
    
    $alg = preg_replace("/3C2'/","<157>",$alg);   $alg = preg_replace("/3C'/","<158>",$alg);   $alg = preg_replace("/3C2/","<159>",$alg);      $alg = preg_replace("/3C/","<160>",$alg); // C -> FR.
    $alg = preg_replace("/3A2'/","<161>",$alg);   $alg = preg_replace("/3A'/","<162>",$alg);   $alg = preg_replace("/3A2/","<163>",$alg);      $alg = preg_replace("/3A/","<164>",$alg); // A -> FL.
    $alg = preg_replace("/3E2'/","<165>",$alg);   $alg = preg_replace("/3E'/","<166>",$alg);   $alg = preg_replace("/3E2/","<167>",$alg);      $alg = preg_replace("/3E/","<168>",$alg); // E -> DR.
    $alg = preg_replace("/3I2'/","<169>",$alg);   $alg = preg_replace("/3I'/","<170>",$alg);   $alg = preg_replace("/3I2/","<171>",$alg);      $alg = preg_replace("/3I/","<172>",$alg); // I -> DL.
    
    /* --- 3xD: TWIZZLE -> CODE: [5] Mid-layer [1] (Numbered layer) --- */
    $alg = preg_replace("/3BR2'/","<149>",$alg);   $alg = preg_replace("/3BR'/","<150>",$alg);   $alg = preg_replace("/3BR2/","<151>",$alg);      $alg = preg_replace("/3BR/","<152>",$alg);
    $alg = preg_replace("/3BL2'/","<153>",$alg);   $alg = preg_replace("/3BL'/","<154>",$alg);   $alg = preg_replace("/3BL2/","<155>",$alg);      $alg = preg_replace("/3BL/","<156>",$alg);
    $alg = preg_replace("/3FR2'/","<157>",$alg);   $alg = preg_replace("/3FR'/","<158>",$alg);   $alg = preg_replace("/3FR2/","<159>",$alg);      $alg = preg_replace("/3FR/","<160>",$alg);
    $alg = preg_replace("/3FL2'/","<161>",$alg);   $alg = preg_replace("/3FL'/","<162>",$alg);   $alg = preg_replace("/3FL2/","<163>",$alg);      $alg = preg_replace("/3FL/","<164>",$alg);
    $alg = preg_replace("/3DR2'/","<165>",$alg);   $alg = preg_replace("/3DR'/","<166>",$alg);   $alg = preg_replace("/3DR2/","<167>",$alg);      $alg = preg_replace("/3DR/","<168>",$alg);
    $alg = preg_replace("/3DL2'/","<169>",$alg);   $alg = preg_replace("/3DL'/","<170>",$alg);   $alg = preg_replace("/3DL2/","<171>",$alg);      $alg = preg_replace("/3DL/","<172>",$alg);
    
    $alg = preg_replace("/3R2'/","<173>",$alg);    $alg = preg_replace("/3R'/","<174>",$alg);    $alg = preg_replace("/3R2/","<175>",$alg);       $alg = preg_replace("/3R/","<176>",$alg);
    $alg = preg_replace("/3L2'/","<177>",$alg);    $alg = preg_replace("/3L'/","<178>",$alg);    $alg = preg_replace("/3L2/","<179>",$alg);       $alg = preg_replace("/3L/","<180>",$alg);
    $alg = preg_replace("/3F2'/","<181>",$alg);    $alg = preg_replace("/3F'/","<182>",$alg);    $alg = preg_replace("/3F2/","<183>",$alg);       $alg = preg_replace("/3F/","<184>",$alg);
    $alg = preg_replace("/3B2'/","<185>",$alg);    $alg = preg_replace("/3B'/","<186>",$alg);    $alg = preg_replace("/3B2/","<187>",$alg);       $alg = preg_replace("/3B/","<188>",$alg);
    $alg = preg_replace("/3U2'/","<189>",$alg);    $alg = preg_replace("/3U'/","<190>",$alg);    $alg = preg_replace("/3U2/","<191>",$alg);       $alg = preg_replace("/3U/","<192>",$alg);
    $alg = preg_replace("/3D2'/","<193>",$alg);    $alg = preg_replace("/3D'/","<194>",$alg);    $alg = preg_replace("/3D2/","<195>",$alg);       $alg = preg_replace("/3D/","<196>",$alg);
    
    /* --- 5xD: OLD TWIZZLE -> CODE: [7] Dodecahedron rotations --- */
    $alg = preg_replace("/BFv2'/","<737>",$alg);   $alg = preg_replace("/BFv'/","<738>",$alg);   $alg = preg_replace("/BFv2/","<739>",$alg);      $alg = preg_replace("/BFv/","<740>",$alg); // BF -> B.
    
    $alg = preg_replace("/Cv2'/","<709>",$alg);   $alg = preg_replace("/Cv'/","<710>",$alg);   $alg = preg_replace("/Cv2/","<711>",$alg);      $alg = preg_replace("/Cv/","<712>",$alg); // C -> FR.
    $alg = preg_replace("/Av2'/","<713>",$alg);   $alg = preg_replace("/Av'/","<714>",$alg);   $alg = preg_replace("/Av2/","<715>",$alg);      $alg = preg_replace("/Av/","<716>",$alg); // A -> FL.
    $alg = preg_replace("/Ev2'/","<717>",$alg);   $alg = preg_replace("/Ev'/","<718>",$alg);   $alg = preg_replace("/Ev2/","<719>",$alg);      $alg = preg_replace("/Ev/","<720>",$alg); // E -> DR.
    $alg = preg_replace("/Iv2'/","<721>",$alg);   $alg = preg_replace("/Iv'/","<722>",$alg);   $alg = preg_replace("/Iv2/","<723>",$alg);      $alg = preg_replace("/Iv/","<724>",$alg); // I -> DL.
    
    /* --- 5xD: TWIZZLE -> CODE: [7] Dodecahedron rotations --- */
    $alg = preg_replace("/BRv2'/","<701>",$alg);   $alg = preg_replace("/BRv'/","<702>",$alg);   $alg = preg_replace("/BRv2/","<703>",$alg);      $alg = preg_replace("/BRv/","<704>",$alg);
    $alg = preg_replace("/BLv2'/","<705>",$alg);   $alg = preg_replace("/BLv'/","<706>",$alg);   $alg = preg_replace("/BLv2/","<707>",$alg);      $alg = preg_replace("/BLv/","<708>",$alg);
    $alg = preg_replace("/FRv2'/","<709>",$alg);   $alg = preg_replace("/FRv'/","<710>",$alg);   $alg = preg_replace("/FRv2/","<711>",$alg);      $alg = preg_replace("/FRv/","<712>",$alg);
    $alg = preg_replace("/FLv2'/","<713>",$alg);   $alg = preg_replace("/FLv'/","<714>",$alg);   $alg = preg_replace("/FLv2/","<715>",$alg);      $alg = preg_replace("/FLv/","<716>",$alg);
    $alg = preg_replace("/DRv2'/","<717>",$alg);   $alg = preg_replace("/DRv'/","<718>",$alg);   $alg = preg_replace("/DRv2/","<719>",$alg);      $alg = preg_replace("/DRv/","<720>",$alg);
    $alg = preg_replace("/DLv2'/","<721>",$alg);   $alg = preg_replace("/DLv'/","<722>",$alg);   $alg = preg_replace("/DLv2/","<723>",$alg);      $alg = preg_replace("/DLv/","<724>",$alg);
    
    $alg = preg_replace("/Rv2'/","<725>",$alg);    $alg = preg_replace("/Rv'/","<726>",$alg);    $alg = preg_replace("/Rv2/","<727>",$alg);       $alg = preg_replace("/Rv/","<728>",$alg);
    $alg = preg_replace("/Lv2'/","<729>",$alg);    $alg = preg_replace("/Lv'/","<730>",$alg);    $alg = preg_replace("/Lv2/","<731>",$alg);       $alg = preg_replace("/Lv/","<732>",$alg);
    $alg = preg_replace("/Fv2'/","<733>",$alg);    $alg = preg_replace("/Fv'/","<734>",$alg);    $alg = preg_replace("/Fv2/","<735>",$alg);       $alg = preg_replace("/Fv/","<736>",$alg);
    $alg = preg_replace("/Bv2'/","<737>",$alg);    $alg = preg_replace("/Bv'/","<738>",$alg);    $alg = preg_replace("/Bv2/","<739>",$alg);       $alg = preg_replace("/Bv/","<740>",$alg);
    $alg = preg_replace("/Uv2'/","<741>",$alg);    $alg = preg_replace("/Uv'/","<742>",$alg);    $alg = preg_replace("/Uv2/","<743>",$alg);       $alg = preg_replace("/Uv/","<744>",$alg);
    $alg = preg_replace("/Dv2'/","<745>",$alg);    $alg = preg_replace("/Dv'/","<746>",$alg);    $alg = preg_replace("/Dv2/","<747>",$alg);       $alg = preg_replace("/Dv/","<748>",$alg);
    
    /* --- 5xD: OLD TWIZZLE -> CODE: [9] Face twists --- */
    $alg = preg_replace("/BF2'/","<937>",$alg);    $alg = preg_replace("/BF'/","<938>",$alg);    $alg = preg_replace("/BF2/","<939>",$alg);       $alg = preg_replace("/BF/","<940>",$alg); // BF -> B.
    
    $alg = preg_replace("/C2'/","<909>",$alg);   $alg = preg_replace("/C'/","<910>",$alg);   $alg = preg_replace("/C2/","<911>",$alg);      $alg = preg_replace("/C/","<912>",$alg); // C -> FR.
    $alg = preg_replace("/A2'/","<913>",$alg);   $alg = preg_replace("/A'/","<914>",$alg);   $alg = preg_replace("/A2/","<915>",$alg);      $alg = preg_replace("/A/","<916>",$alg); // A -> FL.
    $alg = preg_replace("/E2'/","<917>",$alg);   $alg = preg_replace("/E'/","<918>",$alg);   $alg = preg_replace("/E2/","<919>",$alg);      $alg = preg_replace("/E/","<920>",$alg); // E -> DR.
    $alg = preg_replace("/I2'/","<921>",$alg);   $alg = preg_replace("/I'/","<922>",$alg);   $alg = preg_replace("/I2/","<923>",$alg);      $alg = preg_replace("/I/","<924>",$alg); // I -> DL.
    
    /* --- 5xD: OLD TWIZZLE -> CODE: [3] Tier twists --- */
    $alg = preg_replace("/bf2'/","<3133>",$alg);    $alg = preg_replace("/bf'/","<3134>",$alg);    $alg = preg_replace("/bf2/","<3135>",$alg);       $alg = preg_replace("/bf/","<3136>",$alg); // BF -> B.
    
    $alg = preg_replace("/c2'/","<3105>",$alg);   $alg = preg_replace("/c'/","<3106>",$alg);   $alg = preg_replace("/c2/","<3107>",$alg);      $alg = preg_replace("/c/","<3108>",$alg); // C -> FR.
    $alg = preg_replace("/a2'/","<3109>",$alg);   $alg = preg_replace("/a'/","<3110>",$alg);   $alg = preg_replace("/a2/","<3111>",$alg);      $alg = preg_replace("/a/","<3112>",$alg); // A -> FL.
    $alg = preg_replace("/e2'/","<3113>",$alg);   $alg = preg_replace("/e'/","<3114>",$alg);   $alg = preg_replace("/e2/","<3115>",$alg);      $alg = preg_replace("/e/","<3116>",$alg); // E -> DR.
    $alg = preg_replace("/i2'/","<3117>",$alg);   $alg = preg_replace("/i'/","<3118>",$alg);   $alg = preg_replace("/i2/","<3119>",$alg);      $alg = preg_replace("/i/","<3120>",$alg); // I -> DL.
    
    /* --- 5xD: TWIZZLE -> CODE: [9] Face twists --- */
    $alg = preg_replace("/BR2'/","<901>",$alg);   $alg = preg_replace("/BR'/","<902>",$alg);   $alg = preg_replace("/BR2/","<903>",$alg);      $alg = preg_replace("/BR/","<904>",$alg);
    $alg = preg_replace("/BL2'/","<905>",$alg);   $alg = preg_replace("/BL'/","<906>",$alg);   $alg = preg_replace("/BL2/","<907>",$alg);      $alg = preg_replace("/BL/","<908>",$alg);
    $alg = preg_replace("/FR2'/","<909>",$alg);   $alg = preg_replace("/FR'/","<910>",$alg);   $alg = preg_replace("/FR2/","<911>",$alg);      $alg = preg_replace("/FR/","<912>",$alg);
    $alg = preg_replace("/FL2'/","<913>",$alg);   $alg = preg_replace("/FL'/","<914>",$alg);   $alg = preg_replace("/FL2/","<915>",$alg);      $alg = preg_replace("/FL/","<916>",$alg);
    $alg = preg_replace("/DR2'/","<917>",$alg);   $alg = preg_replace("/DR'/","<918>",$alg);   $alg = preg_replace("/DR2/","<919>",$alg);      $alg = preg_replace("/DR/","<920>",$alg);
    $alg = preg_replace("/DL2'/","<921>",$alg);   $alg = preg_replace("/DL'/","<922>",$alg);   $alg = preg_replace("/DL2/","<923>",$alg);      $alg = preg_replace("/DL/","<924>",$alg);
    
    /* --- 5xD: TWIZZLE -> CODE: [3] Tier twists --- */
    $alg = preg_replace("/br2'/","<397>",$alg);    $alg = preg_replace("/br'/","<398>",$alg);    $alg = preg_replace("/br2/","<399>",$alg);       $alg = preg_replace("/br/","<3100>",$alg);
    $alg = preg_replace("/bl2'/","<3101>",$alg);   $alg = preg_replace("/bl'/","<3102>",$alg);   $alg = preg_replace("/bl2/","<3103>",$alg);      $alg = preg_replace("/bl/","<3104>",$alg);
    $alg = preg_replace("/fr2'/","<3105>",$alg);   $alg = preg_replace("/fr'/","<3106>",$alg);   $alg = preg_replace("/fr2/","<3107>",$alg);      $alg = preg_replace("/fr/","<3108>",$alg);
    $alg = preg_replace("/fl2'/","<3109>",$alg);   $alg = preg_replace("/fl'/","<3110>",$alg);   $alg = preg_replace("/fl2/","<3111>",$alg);      $alg = preg_replace("/fl/","<3112>",$alg);
    $alg = preg_replace("/dr2'/","<3113>",$alg);   $alg = preg_replace("/dr'/","<3114>",$alg);   $alg = preg_replace("/dr2/","<3115>",$alg);      $alg = preg_replace("/dr/","<3116>",$alg);
    $alg = preg_replace("/dl2'/","<3117>",$alg);   $alg = preg_replace("/dl'/","<3118>",$alg);   $alg = preg_replace("/dl2/","<3119>",$alg);      $alg = preg_replace("/dl/","<3120>",$alg);
    
    /* --- 5xD: TWIZZLE -> CODE: [9] Face twists --- */
    $alg = preg_replace("/R2'/","<925>",$alg);    $alg = preg_replace("/R'/","<926>",$alg);    $alg = preg_replace("/R2/","<927>",$alg);       $alg = preg_replace("/R/","<928>",$alg);
    $alg = preg_replace("/L2'/","<929>",$alg);    $alg = preg_replace("/L'/","<930>",$alg);    $alg = preg_replace("/L2/","<931>",$alg);       $alg = preg_replace("/L/","<932>",$alg);
    $alg = preg_replace("/F2'/","<933>",$alg);    $alg = preg_replace("/F'/","<934>",$alg);    $alg = preg_replace("/F2/","<935>",$alg);       $alg = preg_replace("/F/","<936>",$alg);
    $alg = preg_replace("/B2'/","<937>",$alg);    $alg = preg_replace("/B'/","<938>",$alg);    $alg = preg_replace("/B2/","<939>",$alg);       $alg = preg_replace("/B/","<940>",$alg);
    $alg = preg_replace("/U2'/","<941>",$alg);    $alg = preg_replace("/U'/","<942>",$alg);    $alg = preg_replace("/U2/","<943>",$alg);       $alg = preg_replace("/U/","<944>",$alg);
    $alg = preg_replace("/D2'/","<945>",$alg);    $alg = preg_replace("/D'/","<946>",$alg);    $alg = preg_replace("/D2/","<947>",$alg);       $alg = preg_replace("/D/","<948>",$alg);
    
    /* --- 5xD: TWIZZLE -> CODE: [3] Tier twists --- */
    $alg = preg_replace("/r2'/","<3121>",$alg);    $alg = preg_replace("/r'/","<3122>",$alg);    $alg = preg_replace("/r2/","<3123>",$alg);       $alg = preg_replace("/r/","<3124>",$alg);
    $alg = preg_replace("/l2'/","<3125>",$alg);    $alg = preg_replace("/l'/","<3126>",$alg);    $alg = preg_replace("/l2/","<3127>",$alg);       $alg = preg_replace("/l/","<3128>",$alg);
    $alg = preg_replace("/f2'/","<3129>",$alg);    $alg = preg_replace("/f'/","<3130>",$alg);    $alg = preg_replace("/f2/","<3131>",$alg);       $alg = preg_replace("/f/","<3132>",$alg);
    $alg = preg_replace("/b2'/","<3133>",$alg);    $alg = preg_replace("/b'/","<3134>",$alg);    $alg = preg_replace("/b2/","<3135>",$alg);       $alg = preg_replace("/b/","<3136>",$alg);
    $alg = preg_replace("/u2'/","<3137>",$alg);    $alg = preg_replace("/u'/","<3138>",$alg);    $alg = preg_replace("/u2/","<3139>",$alg);       $alg = preg_replace("/u/","<3140>",$alg);
    $alg = preg_replace("/d2'/","<3141>",$alg);    $alg = preg_replace("/d'/","<3142>",$alg);    $alg = preg_replace("/d2/","<3143>",$alg);       $alg = preg_replace("/d/","<3144>",$alg);
    
    /* ··································································································· */
    /* --- 5xD: CODE -> SSE: [3] Tier twists --- */
    $alg = preg_replace("/<301>/","T4UR2'",$alg);   $alg = preg_replace("/<302>/","T4UR'",$alg);   $alg = preg_replace("/<303>/","T4UR2",$alg);   $alg = preg_replace("/<304>/","T4UR",$alg);
    $alg = preg_replace("/<305>/","T4UL2'",$alg);   $alg = preg_replace("/<306>/","T4UL'",$alg);   $alg = preg_replace("/<307>/","T4UL2",$alg);   $alg = preg_replace("/<308>/","T4UL",$alg);
    $alg = preg_replace("/<309>/","T4DR2'",$alg);   $alg = preg_replace("/<310>/","T4DR'",$alg);   $alg = preg_replace("/<311>/","T4DR2",$alg);   $alg = preg_replace("/<312>/","T4DR",$alg);
    $alg = preg_replace("/<313>/","T4DL2'",$alg);   $alg = preg_replace("/<314>/","T4DL'",$alg);   $alg = preg_replace("/<315>/","T4DL2",$alg);   $alg = preg_replace("/<316>/","T4DL",$alg);
    $alg = preg_replace("/<317>/","T4BR2'",$alg);   $alg = preg_replace("/<318>/","T4BR'",$alg);   $alg = preg_replace("/<319>/","T4BR2",$alg);   $alg = preg_replace("/<320>/","T4BR",$alg);
    $alg = preg_replace("/<321>/","T4BL2'",$alg);   $alg = preg_replace("/<322>/","T4BL'",$alg);   $alg = preg_replace("/<323>/","T4BL2",$alg);   $alg = preg_replace("/<324>/","T4BL",$alg);
    
    $alg = preg_replace("/<325>/","T4R2'",$alg);    $alg = preg_replace("/<326>/","T4R'",$alg);    $alg = preg_replace("/<327>/","T4R2",$alg);    $alg = preg_replace("/<328>/","T4R",$alg);
    $alg = preg_replace("/<329>/","T4L2'",$alg);    $alg = preg_replace("/<330>/","T4L'",$alg);    $alg = preg_replace("/<331>/","T4L2",$alg);    $alg = preg_replace("/<332>/","T4L",$alg);
    $alg = preg_replace("/<333>/","T4F2'",$alg);    $alg = preg_replace("/<334>/","T4F'",$alg);    $alg = preg_replace("/<335>/","T4F2",$alg);    $alg = preg_replace("/<336>/","T4F",$alg);
    $alg = preg_replace("/<337>/","T4B2'",$alg);    $alg = preg_replace("/<338>/","T4B'",$alg);    $alg = preg_replace("/<339>/","T4B2",$alg);    $alg = preg_replace("/<340>/","T4B",$alg);
    $alg = preg_replace("/<341>/","T4U2'",$alg);    $alg = preg_replace("/<342>/","T4U'",$alg);    $alg = preg_replace("/<343>/","T4U2",$alg);    $alg = preg_replace("/<344>/","T4U",$alg);
    $alg = preg_replace("/<345>/","T4D2'",$alg);    $alg = preg_replace("/<346>/","T4D'",$alg);    $alg = preg_replace("/<347>/","T4D2",$alg);    $alg = preg_replace("/<348>/","T4D",$alg);
    
    /* --- 5xD: CODE -> SSE: [3] Tier twists --- */
    $alg = preg_replace("/<349>/","T3UR2'",$alg);   $alg = preg_replace("/<350>/","T3UR'",$alg);   $alg = preg_replace("/<351>/","T3UR2",$alg);   $alg = preg_replace("/<352>/","T3UR",$alg);
    $alg = preg_replace("/<353>/","T3UL2'",$alg);   $alg = preg_replace("/<354>/","T3UL'",$alg);   $alg = preg_replace("/<355>/","T3UL2",$alg);   $alg = preg_replace("/<356>/","T3UL",$alg);
    $alg = preg_replace("/<357>/","T3DR2'",$alg);   $alg = preg_replace("/<358>/","T3DR'",$alg);   $alg = preg_replace("/<359>/","T3DR2",$alg);   $alg = preg_replace("/<360>/","T3DR",$alg);
    $alg = preg_replace("/<361>/","T3DL2'",$alg);   $alg = preg_replace("/<362>/","T3DL'",$alg);   $alg = preg_replace("/<363>/","T3DL2",$alg);   $alg = preg_replace("/<364>/","T3DL",$alg);
    $alg = preg_replace("/<365>/","T3BR2'",$alg);   $alg = preg_replace("/<366>/","T3BR'",$alg);   $alg = preg_replace("/<367>/","T3BR2",$alg);   $alg = preg_replace("/<368>/","T3BR",$alg);
    $alg = preg_replace("/<369>/","T3BL2'",$alg);   $alg = preg_replace("/<370>/","T3BL'",$alg);   $alg = preg_replace("/<371>/","T3BL2",$alg);   $alg = preg_replace("/<372>/","T3BL",$alg);
    
    $alg = preg_replace("/<373>/","T3R2'",$alg);    $alg = preg_replace("/<374>/","T3R'",$alg);    $alg = preg_replace("/<375>/","T3R2",$alg);    $alg = preg_replace("/<376>/","T3R",$alg);
    $alg = preg_replace("/<377>/","T3L2'",$alg);    $alg = preg_replace("/<378>/","T3L'",$alg);    $alg = preg_replace("/<379>/","T3L2",$alg);    $alg = preg_replace("/<380>/","T3L",$alg);
    $alg = preg_replace("/<381>/","T3F2'",$alg);    $alg = preg_replace("/<382>/","T3F'",$alg);    $alg = preg_replace("/<383>/","T3F2",$alg);    $alg = preg_replace("/<384>/","T3F",$alg);
    $alg = preg_replace("/<385>/","T3B2'",$alg);    $alg = preg_replace("/<386>/","T3B'",$alg);    $alg = preg_replace("/<387>/","T3B2",$alg);    $alg = preg_replace("/<388>/","T3B",$alg);
    $alg = preg_replace("/<389>/","T3U2'",$alg);    $alg = preg_replace("/<390>/","T3U'",$alg);    $alg = preg_replace("/<391>/","T3U2",$alg);    $alg = preg_replace("/<392>/","T3U",$alg);
    $alg = preg_replace("/<393>/","T3D2'",$alg);    $alg = preg_replace("/<394>/","T3D'",$alg);    $alg = preg_replace("/<395>/","T3D2",$alg);    $alg = preg_replace("/<396>/","T3D",$alg);
    
    /* --- 5xD: CODE -> SSE: [6] Wide twists --- */
    $alg = preg_replace("/<601>/","WUR2'",$alg);   $alg = preg_replace("/<602>/","WUR'",$alg);   $alg = preg_replace("/<603>/","WUR2",$alg);   $alg = preg_replace("/<604>/","WUR",$alg);
    $alg = preg_replace("/<605>/","WUL2'",$alg);   $alg = preg_replace("/<606>/","WUL'",$alg);   $alg = preg_replace("/<607>/","WUL2",$alg);   $alg = preg_replace("/<608>/","WUL",$alg);
    $alg = preg_replace("/<609>/","WDR2'",$alg);   $alg = preg_replace("/<610>/","WDR'",$alg);   $alg = preg_replace("/<611>/","WDR2",$alg);   $alg = preg_replace("/<612>/","WDR",$alg);
    $alg = preg_replace("/<613>/","WDL2'",$alg);   $alg = preg_replace("/<614>/","WDL'",$alg);   $alg = preg_replace("/<615>/","WDL2",$alg);   $alg = preg_replace("/<616>/","WDL",$alg);
    $alg = preg_replace("/<617>/","WBR2'",$alg);   $alg = preg_replace("/<618>/","WBR'",$alg);   $alg = preg_replace("/<619>/","WBR2",$alg);   $alg = preg_replace("/<620>/","WBR",$alg);
    $alg = preg_replace("/<621>/","WBL2'",$alg);   $alg = preg_replace("/<622>/","WBL'",$alg);   $alg = preg_replace("/<623>/","WBL2",$alg);   $alg = preg_replace("/<624>/","WBL",$alg);
    
    $alg = preg_replace("/<625>/","WR2'",$alg);    $alg = preg_replace("/<626>/","WR'",$alg);    $alg = preg_replace("/<627>/","WR2",$alg);    $alg = preg_replace("/<628>/","WR",$alg);
    $alg = preg_replace("/<629>/","WL2'",$alg);    $alg = preg_replace("/<630>/","WL'",$alg);    $alg = preg_replace("/<631>/","WL2",$alg);    $alg = preg_replace("/<632>/","WL",$alg);
    $alg = preg_replace("/<633>/","WF2'",$alg);    $alg = preg_replace("/<634>/","WF'",$alg);    $alg = preg_replace("/<635>/","WF2",$alg);    $alg = preg_replace("/<636>/","WF",$alg);
    $alg = preg_replace("/<637>/","WB2'",$alg);    $alg = preg_replace("/<638>/","WB'",$alg);    $alg = preg_replace("/<639>/","WB2",$alg);    $alg = preg_replace("/<640>/","WB",$alg);
    $alg = preg_replace("/<641>/","WU2'",$alg);    $alg = preg_replace("/<642>/","WU'",$alg);    $alg = preg_replace("/<643>/","WU2",$alg);    $alg = preg_replace("/<644>/","WU",$alg);
    $alg = preg_replace("/<645>/","WD2'",$alg);    $alg = preg_replace("/<646>/","WD'",$alg);    $alg = preg_replace("/<647>/","WD2",$alg);    $alg = preg_replace("/<648>/","WD",$alg);
    
    /* --- 5xD: CODE -> SSE: [4] Void twists --- */
    $alg = preg_replace("/<401>/","VUR2'",$alg);   $alg = preg_replace("/<402>/","VUR'",$alg);   $alg = preg_replace("/<403>/","VUR2",$alg);   $alg = preg_replace("/<404>/","VUR",$alg);
    $alg = preg_replace("/<405>/","VUL2'",$alg);   $alg = preg_replace("/<406>/","VUL'",$alg);   $alg = preg_replace("/<407>/","VUL2",$alg);   $alg = preg_replace("/<408>/","VUL",$alg);
    $alg = preg_replace("/<409>/","VDR2'",$alg);   $alg = preg_replace("/<410>/","VDR'",$alg);   $alg = preg_replace("/<411>/","VDR2",$alg);   $alg = preg_replace("/<412>/","VDR",$alg);
    $alg = preg_replace("/<413>/","VDL2'",$alg);   $alg = preg_replace("/<414>/","VDL'",$alg);   $alg = preg_replace("/<415>/","VDL2",$alg);   $alg = preg_replace("/<416>/","VDL",$alg);
    $alg = preg_replace("/<417>/","VBR2'",$alg);   $alg = preg_replace("/<418>/","VBR'",$alg);   $alg = preg_replace("/<419>/","VBR2",$alg);   $alg = preg_replace("/<420>/","VBR",$alg);
    $alg = preg_replace("/<421>/","VBL2'",$alg);   $alg = preg_replace("/<422>/","VBL'",$alg);   $alg = preg_replace("/<423>/","VBL2",$alg);   $alg = preg_replace("/<424>/","VBL",$alg);
    
    $alg = preg_replace("/<425>/","VR2'",$alg);    $alg = preg_replace("/<426>/","VR'",$alg);    $alg = preg_replace("/<427>/","VR2",$alg);    $alg = preg_replace("/<428>/","VR",$alg);
    $alg = preg_replace("/<429>/","VL2'",$alg);    $alg = preg_replace("/<430>/","VL'",$alg);    $alg = preg_replace("/<431>/","VL2",$alg);    $alg = preg_replace("/<432>/","VL",$alg);
    $alg = preg_replace("/<433>/","VF2'",$alg);    $alg = preg_replace("/<434>/","VF'",$alg);    $alg = preg_replace("/<435>/","VF2",$alg);    $alg = preg_replace("/<436>/","VF",$alg);
    $alg = preg_replace("/<437>/","VB2'",$alg);    $alg = preg_replace("/<438>/","VB'",$alg);    $alg = preg_replace("/<439>/","VB2",$alg);    $alg = preg_replace("/<440>/","VB",$alg);
    $alg = preg_replace("/<441>/","VU2'",$alg);    $alg = preg_replace("/<442>/","VU'",$alg);    $alg = preg_replace("/<443>/","VU2",$alg);    $alg = preg_replace("/<444>/","VU",$alg);
    $alg = preg_replace("/<445>/","VD2'",$alg);    $alg = preg_replace("/<446>/","VD'",$alg);    $alg = preg_replace("/<447>/","VD2",$alg);    $alg = preg_replace("/<448>/","VD",$alg);
    
    /* --- 5xD: CODE -> SSE: [1] Numbered layer twists --- */
    $alg = preg_replace("/<101>/","NUR2'",$alg);   $alg = preg_replace("/<102>/","NUR'",$alg);   $alg = preg_replace("/<103>/","NUR2",$alg);   $alg = preg_replace("/<104>/","NUR",$alg);
    $alg = preg_replace("/<105>/","NUL2'",$alg);   $alg = preg_replace("/<106>/","NUL'",$alg);   $alg = preg_replace("/<107>/","NUL2",$alg);   $alg = preg_replace("/<108>/","NUL",$alg);
    $alg = preg_replace("/<109>/","NDR2'",$alg);   $alg = preg_replace("/<110>/","NDR'",$alg);   $alg = preg_replace("/<111>/","NDR2",$alg);   $alg = preg_replace("/<112>/","NDR",$alg);
    $alg = preg_replace("/<113>/","NDL2'",$alg);   $alg = preg_replace("/<114>/","NDL'",$alg);   $alg = preg_replace("/<115>/","NDL2",$alg);   $alg = preg_replace("/<116>/","NDL",$alg);
    $alg = preg_replace("/<117>/","NBR2'",$alg);   $alg = preg_replace("/<118>/","NBR'",$alg);   $alg = preg_replace("/<119>/","NBR2",$alg);   $alg = preg_replace("/<120>/","NBR",$alg);
    $alg = preg_replace("/<121>/","NBL2'",$alg);   $alg = preg_replace("/<122>/","NBL'",$alg);   $alg = preg_replace("/<123>/","NBL2",$alg);   $alg = preg_replace("/<124>/","NBL",$alg);
    
    $alg = preg_replace("/<125>/","NR2'",$alg);    $alg = preg_replace("/<126>/","NR'",$alg);    $alg = preg_replace("/<127>/","NR2",$alg);    $alg = preg_replace("/<128>/","NR",$alg);
    $alg = preg_replace("/<129>/","NL2'",$alg);    $alg = preg_replace("/<130>/","NL'",$alg);    $alg = preg_replace("/<131>/","NL2",$alg);    $alg = preg_replace("/<132>/","NL",$alg);
    $alg = preg_replace("/<133>/","NF2'",$alg);    $alg = preg_replace("/<134>/","NF'",$alg);    $alg = preg_replace("/<135>/","NF2",$alg);    $alg = preg_replace("/<136>/","NF",$alg);
    $alg = preg_replace("/<137>/","NB2'",$alg);    $alg = preg_replace("/<138>/","NB'",$alg);    $alg = preg_replace("/<139>/","NB2",$alg);    $alg = preg_replace("/<140>/","NB",$alg);
    $alg = preg_replace("/<141>/","NU2'",$alg);    $alg = preg_replace("/<142>/","NU'",$alg);    $alg = preg_replace("/<143>/","NU2",$alg);    $alg = preg_replace("/<144>/","NU",$alg);
    $alg = preg_replace("/<145>/","ND2'",$alg);    $alg = preg_replace("/<146>/","ND'",$alg);    $alg = preg_replace("/<147>/","ND2",$alg);    $alg = preg_replace("/<148>/","ND",$alg);
    
    /* --- 5xD: CODE -> SSE: [5] Mid-layer [1] (Numbered layer) --- */
    $alg = preg_replace("/<149>/","MUR2'",$alg);   $alg = preg_replace("/<150>/","MUR'",$alg);   $alg = preg_replace("/<151>/","MUR2",$alg);   $alg = preg_replace("/<152>/","MUR",$alg);
    $alg = preg_replace("/<153>/","MUL2'",$alg);   $alg = preg_replace("/<154>/","MUL'",$alg);   $alg = preg_replace("/<155>/","MUL2",$alg);   $alg = preg_replace("/<156>/","MUL",$alg);
    $alg = preg_replace("/<157>/","MDR2'",$alg);   $alg = preg_replace("/<158>/","MDR'",$alg);   $alg = preg_replace("/<159>/","MDR2",$alg);   $alg = preg_replace("/<160>/","MDR",$alg);
    $alg = preg_replace("/<161>/","MDL2'",$alg);   $alg = preg_replace("/<162>/","MDL'",$alg);   $alg = preg_replace("/<163>/","MDL2",$alg);   $alg = preg_replace("/<164>/","MDL",$alg);
    $alg = preg_replace("/<165>/","MBR2'",$alg);   $alg = preg_replace("/<166>/","MBR'",$alg);   $alg = preg_replace("/<167>/","MBR2",$alg);   $alg = preg_replace("/<168>/","MBR",$alg);
    $alg = preg_replace("/<169>/","MBL2'",$alg);   $alg = preg_replace("/<170>/","MBL'",$alg);   $alg = preg_replace("/<171>/","MBL2",$alg);   $alg = preg_replace("/<172>/","MBL",$alg);
    
    $alg = preg_replace("/<173>/","MR2'",$alg);    $alg = preg_replace("/<174>/","MR'",$alg);    $alg = preg_replace("/<175>/","MR2",$alg);    $alg = preg_replace("/<176>/","MR",$alg);
    $alg = preg_replace("/<177>/","ML2'",$alg);    $alg = preg_replace("/<178>/","ML'",$alg);    $alg = preg_replace("/<179>/","ML2",$alg);    $alg = preg_replace("/<180>/","ML",$alg);
    $alg = preg_replace("/<181>/","MF2'",$alg);    $alg = preg_replace("/<182>/","MF'",$alg);    $alg = preg_replace("/<183>/","MF2",$alg);    $alg = preg_replace("/<184>/","MF",$alg);
    $alg = preg_replace("/<185>/","MB2'",$alg);    $alg = preg_replace("/<186>/","MB'",$alg);    $alg = preg_replace("/<187>/","MB2",$alg);    $alg = preg_replace("/<188>/","MB",$alg);
    $alg = preg_replace("/<189>/","MU2'",$alg);    $alg = preg_replace("/<190>/","MU'",$alg);    $alg = preg_replace("/<191>/","MU2",$alg);    $alg = preg_replace("/<192>/","MU",$alg);
    $alg = preg_replace("/<193>/","MD2'",$alg);    $alg = preg_replace("/<194>/","MD'",$alg);    $alg = preg_replace("/<195>/","MD2",$alg);    $alg = preg_replace("/<196>/","MD",$alg);
    
    /* --- 5xD: CODE -> SSE: [7] Dodecahedron rotations --- */
    $alg = preg_replace("/<701>/","CUR2'",$alg);   $alg = preg_replace("/<702>/","CUR'",$alg);   $alg = preg_replace("/<703>/","CUR2",$alg);   $alg = preg_replace("/<704>/","CUR",$alg);
    $alg = preg_replace("/<705>/","CUL2'",$alg);   $alg = preg_replace("/<706>/","CUL'",$alg);   $alg = preg_replace("/<707>/","CUL2",$alg);   $alg = preg_replace("/<708>/","CUL",$alg);
    $alg = preg_replace("/<709>/","CDR2'",$alg);   $alg = preg_replace("/<710>/","CDR'",$alg);   $alg = preg_replace("/<711>/","CDR2",$alg);   $alg = preg_replace("/<712>/","CDR",$alg);
    $alg = preg_replace("/<713>/","CDL2'",$alg);   $alg = preg_replace("/<714>/","CDL'",$alg);   $alg = preg_replace("/<715>/","CDL2",$alg);   $alg = preg_replace("/<716>/","CDL",$alg);
    $alg = preg_replace("/<717>/","CBR2'",$alg);   $alg = preg_replace("/<718>/","CBR'",$alg);   $alg = preg_replace("/<719>/","CBR2",$alg);   $alg = preg_replace("/<720>/","CBR",$alg);
    $alg = preg_replace("/<721>/","CBL2'",$alg);   $alg = preg_replace("/<722>/","CBL'",$alg);   $alg = preg_replace("/<723>/","CBL2",$alg);   $alg = preg_replace("/<724>/","CBL",$alg);
    
    $alg = preg_replace("/<725>/","CR2'",$alg);    $alg = preg_replace("/<726>/","CR'",$alg);    $alg = preg_replace("/<727>/","CR2",$alg);    $alg = preg_replace("/<728>/","CR",$alg);
    $alg = preg_replace("/<729>/","CL2'",$alg);    $alg = preg_replace("/<730>/","CL'",$alg);    $alg = preg_replace("/<731>/","CL2",$alg);    $alg = preg_replace("/<732>/","CL",$alg);
    $alg = preg_replace("/<733>/","CF2'",$alg);    $alg = preg_replace("/<734>/","CF'",$alg);    $alg = preg_replace("/<735>/","CF2",$alg);    $alg = preg_replace("/<736>/","CF",$alg);
    $alg = preg_replace("/<737>/","CB2'",$alg);    $alg = preg_replace("/<738>/","CB'",$alg);    $alg = preg_replace("/<739>/","CB2",$alg);    $alg = preg_replace("/<740>/","CB",$alg);
    $alg = preg_replace("/<741>/","CU2'",$alg);    $alg = preg_replace("/<742>/","CU'",$alg);    $alg = preg_replace("/<743>/","CU2",$alg);    $alg = preg_replace("/<744>/","CU",$alg);
    $alg = preg_replace("/<745>/","CD2'",$alg);    $alg = preg_replace("/<746>/","CD'",$alg);    $alg = preg_replace("/<747>/","CD2",$alg);    $alg = preg_replace("/<748>/","CD",$alg);
    
    /* --- 5xD: CODE -> SSE: [9] Face twists --- */
    $alg = preg_replace("/<901>/","UR2'",$alg);   $alg = preg_replace("/<902>/","UR'",$alg);   $alg = preg_replace("/<903>/","UR2",$alg);   $alg = preg_replace("/<904>/","UR",$alg);
    $alg = preg_replace("/<905>/","UL2'",$alg);   $alg = preg_replace("/<906>/","UL'",$alg);   $alg = preg_replace("/<907>/","UL2",$alg);   $alg = preg_replace("/<908>/","UL",$alg);
    $alg = preg_replace("/<909>/","DR2'",$alg);   $alg = preg_replace("/<910>/","DR'",$alg);   $alg = preg_replace("/<911>/","DR2",$alg);   $alg = preg_replace("/<912>/","DR",$alg);
    $alg = preg_replace("/<913>/","DL2'",$alg);   $alg = preg_replace("/<914>/","DL'",$alg);   $alg = preg_replace("/<915>/","DL2",$alg);   $alg = preg_replace("/<916>/","DL",$alg);
    $alg = preg_replace("/<917>/","BR2'",$alg);   $alg = preg_replace("/<918>/","BR'",$alg);   $alg = preg_replace("/<919>/","BR2",$alg);   $alg = preg_replace("/<920>/","BR",$alg);
    $alg = preg_replace("/<921>/","BL2'",$alg);   $alg = preg_replace("/<922>/","BL'",$alg);   $alg = preg_replace("/<923>/","BL2",$alg);   $alg = preg_replace("/<924>/","BL",$alg);
    
    /* --- 5xD: CODE -> SSE: [3] Tier twists --- */
    $alg = preg_replace("/<397>/","TUR2'",$alg);    $alg = preg_replace("/<398>/","TUR'",$alg);    $alg = preg_replace("/<399>/","TUR2",$alg);    $alg = preg_replace("/<3100>/","TUR",$alg);
    $alg = preg_replace("/<3101>/","TUL2'",$alg);   $alg = preg_replace("/<3102>/","TUL'",$alg);   $alg = preg_replace("/<3103>/","TUL2",$alg);   $alg = preg_replace("/<3104>/","TUL",$alg);
    $alg = preg_replace("/<3105>/","TDR2'",$alg);   $alg = preg_replace("/<3106>/","TDR'",$alg);   $alg = preg_replace("/<3107>/","TDR2",$alg);   $alg = preg_replace("/<3108>/","TDR",$alg);
    $alg = preg_replace("/<3109>/","TDL2'",$alg);   $alg = preg_replace("/<3110>/","TDL'",$alg);   $alg = preg_replace("/<3111>/","TDL2",$alg);   $alg = preg_replace("/<3112>/","TDL",$alg);
    $alg = preg_replace("/<3113>/","TBR2'",$alg);   $alg = preg_replace("/<3114>/","TBR'",$alg);   $alg = preg_replace("/<3115>/","TBR2",$alg);   $alg = preg_replace("/<3116>/","TBR",$alg);
    $alg = preg_replace("/<3117>/","TBL2'",$alg);   $alg = preg_replace("/<3118>/","TBL'",$alg);   $alg = preg_replace("/<3119>/","TBL2",$alg);   $alg = preg_replace("/<3120>/","TBL",$alg);
    
    /* --- 5xD: CODE -> SSE: [9] Face twists --- */
    $alg = preg_replace("/<925>/","R2'",$alg);    $alg = preg_replace("/<926>/","R'",$alg);    $alg = preg_replace("/<927>/","R2",$alg);    $alg = preg_replace("/<928>/","R",$alg);
    $alg = preg_replace("/<929>/","L2'",$alg);    $alg = preg_replace("/<930>/","L'",$alg);    $alg = preg_replace("/<931>/","L2",$alg);    $alg = preg_replace("/<932>/","L",$alg);
    $alg = preg_replace("/<933>/","F2'",$alg);    $alg = preg_replace("/<934>/","F'",$alg);    $alg = preg_replace("/<935>/","F2",$alg);    $alg = preg_replace("/<936>/","F",$alg);
    $alg = preg_replace("/<937>/","B2'",$alg);    $alg = preg_replace("/<938>/","B'",$alg);    $alg = preg_replace("/<939>/","B2",$alg);    $alg = preg_replace("/<940>/","B",$alg);
    $alg = preg_replace("/<941>/","U2'",$alg);    $alg = preg_replace("/<942>/","U'",$alg);    $alg = preg_replace("/<943>/","U2",$alg);    $alg = preg_replace("/<944>/","U",$alg);
    $alg = preg_replace("/<945>/","D2'",$alg);    $alg = preg_replace("/<946>/","D'",$alg);    $alg = preg_replace("/<947>/","D2",$alg);    $alg = preg_replace("/<948>/","D",$alg);
    
    /* --- 5xD: CODE -> SSE: [3] Tier twists --- */
    $alg = preg_replace("/<3121>/","TR2'",$alg);    $alg = preg_replace("/<3122>/","TR'",$alg);    $alg = preg_replace("/<3123>/","TR2",$alg);    $alg = preg_replace("/<3124>/","TR",$alg);
    $alg = preg_replace("/<3125>/","TL2'",$alg);    $alg = preg_replace("/<3126>/","TL'",$alg);    $alg = preg_replace("/<3127>/","TL2",$alg);    $alg = preg_replace("/<3128>/","TL",$alg);
    $alg = preg_replace("/<3129>/","TF2'",$alg);    $alg = preg_replace("/<3130>/","TF'",$alg);    $alg = preg_replace("/<3131>/","TF2",$alg);    $alg = preg_replace("/<3132>/","TF",$alg);
    $alg = preg_replace("/<3133>/","TB2'",$alg);    $alg = preg_replace("/<3134>/","TB'",$alg);    $alg = preg_replace("/<3135>/","TB2",$alg);    $alg = preg_replace("/<3136>/","TB",$alg);
    $alg = preg_replace("/<3137>/","TU2'",$alg);    $alg = preg_replace("/<3138>/","TU'",$alg);    $alg = preg_replace("/<3139>/","TU2",$alg);    $alg = preg_replace("/<3140>/","TU",$alg);
    $alg = preg_replace("/<3141>/","TD2'",$alg);    $alg = preg_replace("/<3142>/","TD'",$alg);    $alg = preg_replace("/<3143>/","TD2",$alg);    $alg = preg_replace("/<3144>/","TD",$alg);
    
    return $alg;
  }
  
  
  
  
  /* 
  ---------------------------------------------------------------------------------------------------
  * alg_TwizzleToTwizzleLink($alg)
  * 
  * Converts Twizzle algorithm into Twizzle alg parameter (Twizzle-Player).
  * 
  * Parameter: $alg (STRING): The algorithm.
  * 
  * Return: STRING.
  ---------------------------------------------------------------------------------------------------
  */
  function alg_TwizzleToTwizzleLink($alg) {
    // Hinweis: Der Twizzle-Player verwendet einen Editor der Zeilenschaltungen unterstützt.
    // Das mit [/*] beginnende und mit [*/] endende Kommentar-Token wird nicht unterstützt.
    // Kommentare können nur mit dem Token [//] angebracht werden.
    $algLink = "";
    
    $algLink = preg_replace("'^\s+'",'',$alg);        // Leerzeichen am Anfang des Strings entfernen
    $algLink = preg_replace("'\s+$'",'',$algLink);    // Leerzeichen am Schluss des Strings entfernen
    $algLink = preg_replace("'  *'"," ",$algLink);    // Überflüssige Leerzeichen entfernen.
    
    //$algLink = preg_replace("/ /","_",$algLink);      // [TWIZZLE] Provisorisch [ ] Leerzeichen durch [_] Underline ersetzen.
    $algLink = preg_replace("/ /","|",$algLink);      // [TWIZZLE] Provisorisch [ ] Leerzeichen durch [|] Vertical Line ersetzen.
    $algLink = preg_replace("/·/",".",$algLink);      // [TWIZZLE] [·] Mittelstehender Punkt durch [.] Punkt ersetzen.
    
    // [TWIZZLE] Übersetzt folgende Zeichen nicht korrekt?!: [!] %21, [#] %23, [$] %24.
    $a = array("!",   "#",   "$",   "%",   "&",   "'",   "(",   ")",   "*",   "+",   ",",   "/",   ":",   ";",   "=",   "?",   "@",   "[",   "]");
    $b = array("%21", "%23", "%24", "%25", "%26", "%27", "%28", "%29", "%2A", "%2B", "%2C", "%2F", "%3A", "%3B", "%3D", "%3F", "%40", "%5B", "%5D");
    $algLink = str_replace($a, $b, $algLink);
    
    //$algLink = preg_replace("/_/","+",$algLink);      // [TWIZZLE] Verwendet [+] Plus anstelle von [ ] Leerzeichen!
    $algLink = preg_replace("/\|/","+",$algLink);     // [TWIZZLE] Verwendet [+] Plus anstelle von [|] Leerzeichen!
    
    $algLink = preg_replace("/\r\n/","%0A",$algLink); // [\r\n] Zeilenschaltung durch [%0A] Zeilenschaltung ersetzen.
    $algLink = preg_replace("/\n/","%0A",$algLink);   // [\n] Zeilenschaltung durch [%0A] Zeilenschaltung ersetzen.
    
    return $algLink;
  }
  
  
  
  
  /* 
  ---------------------------------------------------------------------------------------------------
  * alg_SseToSseLink($alg)
  * 
  * Converts SSE algorithm into SSE alg parameter (Java-Applet-Player).
  * 
  * Parameter: $alg (STRING): The algorithm.
  * 
  * Return: STRING.
  ---------------------------------------------------------------------------------------------------
  */
  function alg_SseToSseLink($alg) {
    // Hinweis: Der SSE-Player verwendet einen Editor der keine Zeilenschaltungen unterstützt.
    // Deshalb bewirkt das Setzen des Kommentar-Tokens [//], dass alles was danach folgt ignoriert wird.
    // Um innerhalb des Algorithmus Kommentare anzubringen kann das mit [/*] beginnende und mit [*/] endende Token verwendet werden.
    
    $algLink = "";
    
    $algLink = preg_replace("'^\s+'",'',$alg);        // Leerzeichen am Anfang des Strings entfernen
    $algLink = preg_replace("'\s+$'",'',$algLink);    // Leerzeichen am Schluss des Strings entfernen
    $algLink = preg_replace("'  *'"," ",$algLink);    // Überflüssige Leerzeichen entfernen.
    
    $algLink = preg_replace("/ /","_",$algLink);      // [SSE] Provisorisch [ ] Leerzeichen durch [_] Underline ersetzen.
    $algLink = preg_replace("/'/","-",$algLink);      // [SSE] ['] Apostroph durch [-] Minus ersetzen (SSE-Parser ersetzt [-] wieder durch [']).
    $algLink = preg_replace("/·/",".",$algLink);      // [SSE] [·] Mittelstehender Punkt durch [.] Punkt ersetzen (SSE-Parser ersetzt [·] wieder durch [.]).
   
    $algLink = preg_replace("/\r\n/",".",$algLink);   // [\r\n] Zeilenschaltung durch [.] Punkt ersetzen.
    $algLink = preg_replace("/\n/",".",$algLink);     // [\n] Zeilenschaltung durch [.] Punkt ersetzen.
    $algLink = preg_replace("/\.\//","/",$algLink);   // [./] durch [/] ersetzen --> entfernt [.] Punkt vor Kommentar [/*], [//].
    
    // [SSE] Übersetzt folgende Zeichen nicht korrekt?!: [!] %21, [#] %23, [$] %24.
    $a = array("!",   "#",   "$",   "%",   "&",   "'",   "(",   ")",   "*",   "+",   ",",   "/",   ":",   ";",   "=",   "?",   "@",   "[",   "]");
    $b = array("%21", "%23", "%24", "%25", "%26", "%27", "%28", "%29", "%2A", "%2B", "%2C", "%2F", "%3A", "%3B", "%3D", "%3F", "%40", "%5B", "%5D");
    $algLink = str_replace($a, $b, $algLink);
    
    if (preg_match("/\//", $alg) == true) {           // Wenn $alg das Zeichen [/] enthält (bei Kommentar [/*], [*/], [//]:
      $algLink = preg_replace("/_/","%20",$algLink);  //   [SSE] Verwendet [%20] Leerzeichen anstelle von [ ] Leerzeichen.
    } else {                                          // Sonst ($alg ohne Kommentar):
      $algLink = preg_replace("/_/","",$algLink);     //   [SSE]: Entfernt Leerzeichen (SSE-Parser erkennt Token auch ohne Trennzeichen!).
    }
    
    return $algLink;
  }
  
  
  
  
  /* 
  ---------------------------------------------------------------------------------------------------
  * alg_SseToTwisterLink($alg)
  * 
  * Converts SSE algorithm into Twister alg parameter (Twister-Player).
  * 
  * Parameter: $alg (STRING): The algorithm.
  * 
  * Return: STRING.
  ---------------------------------------------------------------------------------------------------
  */
  function alg_SseToTwisterLink($alg) {
    // Hinweis: Der Twister-Player verwendet einen Editor der Zeilenschaltungen unterstützt.
    // Das mit [/*] beginnende und mit [*/] endende Kommentar-Token wird nicht unterstützt.
    // Kommentare können nur mit dem Token [//] angebracht werden.
    
    $algLink = "";
    
    $algLink = preg_replace("'^\s+'",'',$alg);        // Leerzeichen am Anfang des Strings entfernen
    $algLink = preg_replace("'\s+$'",'',$algLink);    // Leerzeichen am Schluss des Strings entfernen
    $algLink = preg_replace("'  *'"," ",$algLink);    // Überflüssige Leerzeichen entfernen.
    
    //$algLink = preg_replace("/ /","_",$algLink);      // [TWISTER] Provisorisch [ ] Leerzeichen durch [_] Underline ersetzen.
    $algLink = preg_replace("/ /","|",$algLink);      // [TWISTER] Provisorisch [ ] Leerzeichen durch [|] Vertical Line ersetzen.
    //$algLink = preg_replace("/·/",".",$algLink);      // [TWISTER] [·] Mittelstehender Punkt durch [.] Punkt ersetzen.
   
    // [SSE] Übersetzt folgende Zeichen nicht korrekt?!: [!] %21, [#] %23, [$] %24.
    $a = array("!",   "#",   "$",   "%",   "&",   "'",   "(",   ")",   "*",   "+",   ",",   "/",   ":",   ";",   "=",   "?",   "@",   "[",   "]",       "·");
    $b = array("%21", "%23", "%24", "%25", "%26", "%27", "%28", "%29", "%2A", "%2B", "%2C", "%2F", "%3A", "%3B", "%3D", "%3F", "%40", "%5B", "%5D",     "%C2%B7");
    $algLink = str_replace($a, $b, $algLink);
    
    //$algLink = preg_replace("/_/","%20",$algLink);    // [TWISTER] Verwendet [%20] Leerzeichen anstelle von [ ] Leerzeichen!
    $algLink = preg_replace("/\|/","%20",$algLink);   // [TWISTER] Verwendet [%20] Leerzeichen anstelle von [|] Leerzeichen!
    
    $algLink = preg_replace("/\r\n/","%0A",$algLink); // [\r\n] Zeilenschaltung durch [%0A] Zeilenschaltung ersetzen.
    $algLink = preg_replace("/\n/","%0A",$algLink);   // [\n] Zeilenschaltung durch [%0A] Zeilenschaltung ersetzen.
    
    return $algLink;
  }
  
?>
