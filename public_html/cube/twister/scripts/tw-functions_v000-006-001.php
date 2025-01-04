<?php 
  
  /* 
  ***************************************************************************************************
  * Twister Functions
  * 
  * Author:      Walter Randelshofer, Hausmatt 10, CH-6405 Immensee
  * Version:     0.6.1
  * Last Update: 03.01.2023 wr
  * 
  * SSE to TWIZZLE:
  * - Complete code revision (2x to 7x Cubes, Megaminx, Gigaminx).
  * - Alternative move tokens added (2x to 7x Cubes, Megaminx, Gigaminx).
  * 
  * TWIZZLE to SSE:
  * - Complete code revision (2x to 7x Cubes, Megaminx, Gigaminx).
  * - Alternative move tokens added (2x to 7x Cubes, Megaminx, Gigaminx).
  * - Slice twist optimization added (2x to 7x Cubes, Megaminx, Gigaminx).
  * - Two-Pass optimization for Slice twists added (Megaminx, Gigaminx).
  * - Gigaminx: Bug-Fix: Mid-Layer-Twists (3B, 3U, 3D).
  * - Asymmetric Slice twists addes (4x Cube).
  * - Some asymmetric Slice twists added (5x Cube).
  * - Additional Verge Twists added (Gigaminx).
  * - Slice twist Bug Fix (3x to 7x Cubes): prevents that R' L' is translatet into SR''.
  * - Slice twist Bug Fix (Megaminx, Gigaminx): prevent that U' D' is translatet into SU''.
  * 
  * To Do:
  * - Complete code revision (3x to 5x Pyraminx).
  * - Alternative move tokens (3x to 5x Pyraminx).
  * - Asymmetric Slice twists (4x to 7x Cubes, Megaminx, Gigaminx).
  * - Fix of incorrect translations from TWIZZLE to SSE (Megaminx, Gigaminx): For example Uv' D becomes CSU' (Uv' D -> CU' D -> CSU')
  * 
  * - TWIZZLE to SSE: Gigaminx: 3U' FR2  -> MU' DR2  -> MSU'R2 (Incorrect Second-Pass-Translation!)
  *                             3U' Uv2' -> MU' CU2' -> S2U 2'.(Incorrect Second-Pass-Translation!)
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
    $str = preg_replace("'^\s+'",'',$str); // Leerzeichen am Anfang des Strings entfernen.
    $str = preg_replace("'\s+$'",'',$str); // Leerzeichen am Schluss des Strings entfernen.
    $str = preg_replace("'  *'",' ',$str); // Überflüssige Leerzeichen entfernen.
    
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
    /* C */
    $alg = preg_replace("/CR'/","<701>",$alg); $alg = preg_replace("/CR-/","<701>",$alg);   $alg = preg_replace("/CR2/","<702>",$alg);   $alg = preg_replace("/CR/","<703>",$alg);
    $alg = preg_replace("/CL'/","<703>",$alg); $alg = preg_replace("/CL-/","<703>",$alg);   $alg = preg_replace("/CL2/","<702>",$alg);   $alg = preg_replace("/CL/","<701>",$alg);
    $alg = preg_replace("/CF'/","<704>",$alg); $alg = preg_replace("/CF-/","<704>",$alg);   $alg = preg_replace("/CF2/","<705>",$alg);   $alg = preg_replace("/CF/","<706>",$alg);
    $alg = preg_replace("/CB'/","<706>",$alg); $alg = preg_replace("/CB-/","<706>",$alg);   $alg = preg_replace("/CB2/","<705>",$alg);   $alg = preg_replace("/CB/","<704>",$alg);
    $alg = preg_replace("/CU'/","<707>",$alg); $alg = preg_replace("/CU-/","<707>",$alg);   $alg = preg_replace("/CU2/","<708>",$alg);   $alg = preg_replace("/CU/","<709>",$alg);
    $alg = preg_replace("/CD'/","<709>",$alg); $alg = preg_replace("/CD-/","<709>",$alg);   $alg = preg_replace("/CD2/","<708>",$alg);   $alg = preg_replace("/CD/","<707>",$alg);
    
    /* --- 2xC: SSE -> CODE: [9] Face twists --- */
    /*   */
    $alg = preg_replace("/R'/","<901>",$alg); $alg = preg_replace("/R-/","<901>",$alg);   $alg = preg_replace("/R2/","<902>",$alg);   $alg = preg_replace("/R/","<903>",$alg);
    $alg = preg_replace("/L'/","<904>",$alg); $alg = preg_replace("/L-/","<904>",$alg);   $alg = preg_replace("/L2/","<905>",$alg);   $alg = preg_replace("/L/","<906>",$alg);
    $alg = preg_replace("/F'/","<907>",$alg); $alg = preg_replace("/F-/","<907>",$alg);   $alg = preg_replace("/F2/","<908>",$alg);   $alg = preg_replace("/F/","<909>",$alg);
    $alg = preg_replace("/B'/","<910>",$alg); $alg = preg_replace("/B-/","<910>",$alg);   $alg = preg_replace("/B2/","<911>",$alg);   $alg = preg_replace("/B/","<912>",$alg);
    $alg = preg_replace("/U'/","<913>",$alg); $alg = preg_replace("/U-/","<913>",$alg);   $alg = preg_replace("/U2/","<914>",$alg);   $alg = preg_replace("/U/","<915>",$alg);
    $alg = preg_replace("/D'/","<916>",$alg); $alg = preg_replace("/D-/","<916>",$alg);   $alg = preg_replace("/D2/","<917>",$alg);   $alg = preg_replace("/D/","<918>",$alg);
    
    /* ··································································································· */
    /* --- 2xC: CODE -> TWIZZLE: [7] Cube rotations --- */
    /* C */
    if ($useSiGN == true) { // Bei SiGN:
      $alg = preg_replace("/<701>/","x'",$alg);   $alg = preg_replace("/<702>/","x2",$alg);   $alg = preg_replace("/<703>/","x",$alg);
      $alg = preg_replace("/<704>/","z'",$alg);   $alg = preg_replace("/<705>/","z2",$alg);   $alg = preg_replace("/<706>/","z",$alg);
      $alg = preg_replace("/<707>/","y'",$alg);   $alg = preg_replace("/<708>/","y2",$alg);   $alg = preg_replace("/<709>/","y",$alg);
      
    } else {               // Sonst (TWIZZLE):
      $alg = preg_replace("/<701>/","Rv'",$alg);   $alg = preg_replace("/<702>/","Rv2",$alg);   $alg = preg_replace("/<703>/","Rv",$alg);
      $alg = preg_replace("/<704>/","Fv'",$alg);   $alg = preg_replace("/<705>/","Fv2",$alg);   $alg = preg_replace("/<706>/","Fv",$alg);
      $alg = preg_replace("/<707>/","Uv'",$alg);   $alg = preg_replace("/<708>/","Uv2",$alg);   $alg = preg_replace("/<709>/","Uv",$alg);
    }
    
    /* --- 2xC: CODE -> TWIZZLE: [9] Face twists --- */
    /*   */
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
  * 15.07.2022: Not supported Tokens by TWIZZLE:
  *   1R 1L 1F 1B 1U 1D  ->  R L F B U D
  *   2R 2L 2F 2B 2U 2D  ->  L' R' B' F' D' U'
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
    /* C */
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
    /*   */
    $alg = preg_replace("/R'/","<901>",$alg); $alg = preg_replace("/R2/","<902>",$alg); $alg = preg_replace("/R/","<903>",$alg);
    $alg = preg_replace("/L'/","<904>",$alg); $alg = preg_replace("/L2/","<905>",$alg); $alg = preg_replace("/L/","<906>",$alg);
    $alg = preg_replace("/F'/","<907>",$alg); $alg = preg_replace("/F2/","<908>",$alg); $alg = preg_replace("/F/","<909>",$alg);
    $alg = preg_replace("/B'/","<910>",$alg); $alg = preg_replace("/B2/","<911>",$alg); $alg = preg_replace("/B/","<912>",$alg);
    $alg = preg_replace("/U'/","<913>",$alg); $alg = preg_replace("/U2/","<914>",$alg); $alg = preg_replace("/U/","<915>",$alg);
    $alg = preg_replace("/D'/","<916>",$alg); $alg = preg_replace("/D2/","<917>",$alg); $alg = preg_replace("/D/","<918>",$alg);
    
    /* ··································································································· */
    /* --- 2xC: CODE -> SSE: [7] Cube rotations --- */
    /* C */
    $alg = preg_replace("/<701>/","CR'",$alg); $alg = preg_replace("/<702>/","CR2",$alg); $alg = preg_replace("/<703>/","CR",$alg);
    $alg = preg_replace("/<704>/","CF'",$alg); $alg = preg_replace("/<705>/","CF2",$alg); $alg = preg_replace("/<706>/","CF",$alg);
    $alg = preg_replace("/<707>/","CU'",$alg); $alg = preg_replace("/<708>/","CU2",$alg); $alg = preg_replace("/<709>/","CU",$alg);
    
    /* --- 2xC: CODE -> SSE: [9] Face twists --- */
    /*   */
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
    $useSiGN    = true;  // Notation style: SiGN or TWIZZLE (Default).
    $useMarkers = false; // 01.04.2021: Unfortunately Twizzle Explorer doesn't handle Markers correctly!
    
    /* --- 3xC: Marker --- */
    if ($useMarkers != true) {
      $alg = str_replace("·","",$alg); $alg = str_replace(".","",$alg); // Remove Markers!
    } else {
      $alg = str_replace("·",".",$alg);
    }
    
    /* ··································································································· */
    /* --- 3xC: SSE -> CODE: [5] Mid-layer [1] (Numbered layer) [6] (Wide) twists --- */
    /* M = N = W */
    $alg = preg_replace("/MR'/","<101>",$alg); $alg = preg_replace("/MR-/","<101>",$alg);   $alg = preg_replace("/MR2/","<102>",$alg);   $alg = preg_replace("/MR/","<103>",$alg);
    $alg = preg_replace("/ML'/","<103>",$alg); $alg = preg_replace("/ML-/","<103>",$alg);   $alg = preg_replace("/ML2/","<102>",$alg);   $alg = preg_replace("/ML/","<101>",$alg);
    $alg = preg_replace("/MF'/","<104>",$alg); $alg = preg_replace("/MF-/","<104>",$alg);   $alg = preg_replace("/MF2/","<105>",$alg);   $alg = preg_replace("/MF/","<106>",$alg);
    $alg = preg_replace("/MB'/","<106>",$alg); $alg = preg_replace("/MB-/","<106>",$alg);   $alg = preg_replace("/MB2/","<105>",$alg);   $alg = preg_replace("/MB/","<104>",$alg);
    $alg = preg_replace("/MU'/","<107>",$alg); $alg = preg_replace("/MU-/","<107>",$alg);   $alg = preg_replace("/MU2/","<108>",$alg);   $alg = preg_replace("/MU/","<109>",$alg);
    $alg = preg_replace("/MD'/","<109>",$alg); $alg = preg_replace("/MD-/","<109>",$alg);   $alg = preg_replace("/MD2/","<108>",$alg);   $alg = preg_replace("/MD/","<107>",$alg);
    
    $alg = preg_replace("/NR'/","<101>",$alg); $alg = preg_replace("/NR-/","<101>",$alg);   $alg = preg_replace("/NR2/","<102>",$alg);   $alg = preg_replace("/NR/","<103>",$alg);
    $alg = preg_replace("/NL'/","<103>",$alg); $alg = preg_replace("/NL-/","<103>",$alg);   $alg = preg_replace("/NL2/","<102>",$alg);   $alg = preg_replace("/NL/","<101>",$alg);
    $alg = preg_replace("/NF'/","<104>",$alg); $alg = preg_replace("/NF-/","<104>",$alg);   $alg = preg_replace("/NF2/","<105>",$alg);   $alg = preg_replace("/NF/","<106>",$alg);
    $alg = preg_replace("/NB'/","<106>",$alg); $alg = preg_replace("/NB-/","<106>",$alg);   $alg = preg_replace("/NB2/","<105>",$alg);   $alg = preg_replace("/NB/","<104>",$alg);
    $alg = preg_replace("/NU'/","<107>",$alg); $alg = preg_replace("/NU-/","<107>",$alg);   $alg = preg_replace("/NU2/","<108>",$alg);   $alg = preg_replace("/NU/","<109>",$alg);
    $alg = preg_replace("/ND'/","<109>",$alg); $alg = preg_replace("/ND-/","<109>",$alg);   $alg = preg_replace("/ND2/","<108>",$alg);   $alg = preg_replace("/ND/","<107>",$alg);
    
    $alg = preg_replace("/WR'/","<101>",$alg); $alg = preg_replace("/WR-/","<101>",$alg);   $alg = preg_replace("/WR2/","<102>",$alg);   $alg = preg_replace("/WR/","<103>",$alg);
    $alg = preg_replace("/WL'/","<103>",$alg); $alg = preg_replace("/WL-/","<104>",$alg);   $alg = preg_replace("/WL2/","<102>",$alg);   $alg = preg_replace("/WL/","<101>",$alg);
    $alg = preg_replace("/WF'/","<104>",$alg); $alg = preg_replace("/WF-/","<107>",$alg);   $alg = preg_replace("/WF2/","<105>",$alg);   $alg = preg_replace("/WF/","<106>",$alg);
    $alg = preg_replace("/WB'/","<106>",$alg); $alg = preg_replace("/WB-/","<110>",$alg);   $alg = preg_replace("/WB2/","<105>",$alg);   $alg = preg_replace("/WB/","<104>",$alg);
    $alg = preg_replace("/WU'/","<107>",$alg); $alg = preg_replace("/WU-/","<113>",$alg);   $alg = preg_replace("/WU2/","<108>",$alg);   $alg = preg_replace("/WU/","<109>",$alg);
    $alg = preg_replace("/WD'/","<109>",$alg); $alg = preg_replace("/WD-/","<116>",$alg);   $alg = preg_replace("/WD2/","<108>",$alg);   $alg = preg_replace("/WD/","<107>",$alg);
    
    /* --- 3xC: SSE -> CODE: [2] Slice twists --- */
    /* S = S2-2 */
    $alg = preg_replace("/SR'/","<201>",$alg); $alg = preg_replace("/SR-/","<201>",$alg);   $alg = preg_replace("/SR2/","<202>",$alg);   $alg = preg_replace("/SR/","<203>",$alg);
    $alg = preg_replace("/SL'/","<203>",$alg); $alg = preg_replace("/SL-/","<203>",$alg);   $alg = preg_replace("/SL2/","<202>",$alg);   $alg = preg_replace("/SL/","<201>",$alg);
    $alg = preg_replace("/SF'/","<204>",$alg); $alg = preg_replace("/SF-/","<204>",$alg);   $alg = preg_replace("/SF2/","<205>",$alg);   $alg = preg_replace("/SF/","<206>",$alg);
    $alg = preg_replace("/SB'/","<206>",$alg); $alg = preg_replace("/SB-/","<206>",$alg);   $alg = preg_replace("/SB2/","<205>",$alg);   $alg = preg_replace("/SB/","<204>",$alg);
    $alg = preg_replace("/SU'/","<207>",$alg); $alg = preg_replace("/SU-/","<207>",$alg);   $alg = preg_replace("/SU2/","<208>",$alg);   $alg = preg_replace("/SU/","<209>",$alg);
    $alg = preg_replace("/SD'/","<209>",$alg); $alg = preg_replace("/SD-/","<209>",$alg);   $alg = preg_replace("/SD2/","<208>",$alg);   $alg = preg_replace("/SD/","<207>",$alg);
    
    $alg = preg_replace("/S2-2R'/","<201>",$alg); $alg = preg_replace("/S2-2R-/","<201>",$alg);   $alg = preg_replace("/S2-2R2/","<202>",$alg);   $alg = preg_replace("/S2-2R/","<203>",$alg);
    $alg = preg_replace("/S2-2L'/","<203>",$alg); $alg = preg_replace("/S2-2L-/","<203>",$alg);   $alg = preg_replace("/S2-2L2/","<202>",$alg);   $alg = preg_replace("/S2-2L/","<201>",$alg);
    $alg = preg_replace("/S2-2F'/","<204>",$alg); $alg = preg_replace("/S2-2F-/","<204>",$alg);   $alg = preg_replace("/S2-2F2/","<205>",$alg);   $alg = preg_replace("/S2-2F/","<206>",$alg);
    $alg = preg_replace("/S2-2B'/","<206>",$alg); $alg = preg_replace("/S2-2B-/","<206>",$alg);   $alg = preg_replace("/S2-2B2/","<205>",$alg);   $alg = preg_replace("/S2-2B/","<204>",$alg);
    $alg = preg_replace("/S2-2U'/","<207>",$alg); $alg = preg_replace("/S2-2U-/","<207>",$alg);   $alg = preg_replace("/S2-2U2/","<208>",$alg);   $alg = preg_replace("/S2-2U/","<209>",$alg);
    $alg = preg_replace("/S2-2D'/","<209>",$alg); $alg = preg_replace("/S2-2D-/","<209>",$alg);   $alg = preg_replace("/S2-2D2/","<208>",$alg);   $alg = preg_replace("/S2-2D/","<207>",$alg);
    
    /* --- 3xC: SSE -> CODE: [3] Tier twists --- */
    /* T */
    $alg = preg_replace("/TR'/","<301>",$alg); $alg = preg_replace("/TR-/","<301>",$alg);   $alg = preg_replace("/TR2/","<302>",$alg);   $alg = preg_replace("/TR/","<303>",$alg);
    $alg = preg_replace("/TL'/","<304>",$alg); $alg = preg_replace("/TL-/","<304>",$alg);   $alg = preg_replace("/TL2/","<305>",$alg);   $alg = preg_replace("/TL/","<306>",$alg);
    $alg = preg_replace("/TF'/","<307>",$alg); $alg = preg_replace("/TF-/","<307>",$alg);   $alg = preg_replace("/TF2/","<308>",$alg);   $alg = preg_replace("/TF/","<309>",$alg);
    $alg = preg_replace("/TB'/","<310>",$alg); $alg = preg_replace("/TB-/","<310>",$alg);   $alg = preg_replace("/TB2/","<311>",$alg);   $alg = preg_replace("/TB/","<312>",$alg);
    $alg = preg_replace("/TU'/","<313>",$alg); $alg = preg_replace("/TU-/","<313>",$alg);   $alg = preg_replace("/TU2/","<314>",$alg);   $alg = preg_replace("/TU/","<315>",$alg);
    $alg = preg_replace("/TD'/","<316>",$alg); $alg = preg_replace("/TD-/","<316>",$alg);   $alg = preg_replace("/TD2/","<317>",$alg);   $alg = preg_replace("/TD/","<318>",$alg);
    
    /* --- 3xC: SSE -> CODE: [7] Cube rotations --- */
    /* C */
    $alg = preg_replace("/CR'/","<701>",$alg); $alg = preg_replace("/CR-/","<701>",$alg);   $alg = preg_replace("/CR2/","<702>",$alg);   $alg = preg_replace("/CR/","<703>",$alg);
    $alg = preg_replace("/CL'/","<703>",$alg); $alg = preg_replace("/CL-/","<703>",$alg);   $alg = preg_replace("/CL2/","<702>",$alg);   $alg = preg_replace("/CL/","<701>",$alg);
    $alg = preg_replace("/CF'/","<704>",$alg); $alg = preg_replace("/CF-/","<704>",$alg);   $alg = preg_replace("/CF2/","<705>",$alg);   $alg = preg_replace("/CF/","<706>",$alg);
    $alg = preg_replace("/CB'/","<706>",$alg); $alg = preg_replace("/CB-/","<706>",$alg);   $alg = preg_replace("/CB2/","<705>",$alg);   $alg = preg_replace("/CB/","<704>",$alg);
    $alg = preg_replace("/CU'/","<707>",$alg); $alg = preg_replace("/CU-/","<707>",$alg);   $alg = preg_replace("/CU2/","<708>",$alg);   $alg = preg_replace("/CU/","<709>",$alg);
    $alg = preg_replace("/CD'/","<709>",$alg); $alg = preg_replace("/CD-/","<709>",$alg);   $alg = preg_replace("/CD2/","<708>",$alg);   $alg = preg_replace("/CD/","<707>",$alg);
    
    /* --- 3xC: SSE -> CODE: [9] Face twists --- */
    /*   */
    $alg = preg_replace("/R'/","<901>",$alg); $alg = preg_replace("/R-/","<901>",$alg);   $alg = preg_replace("/R2/","<902>",$alg);   $alg = preg_replace("/R/","<903>",$alg);
    $alg = preg_replace("/L'/","<904>",$alg); $alg = preg_replace("/L-/","<904>",$alg);   $alg = preg_replace("/L2/","<905>",$alg);   $alg = preg_replace("/L/","<906>",$alg);
    $alg = preg_replace("/F'/","<907>",$alg); $alg = preg_replace("/F-/","<907>",$alg);   $alg = preg_replace("/F2/","<908>",$alg);   $alg = preg_replace("/F/","<909>",$alg);
    $alg = preg_replace("/B'/","<910>",$alg); $alg = preg_replace("/B-/","<910>",$alg);   $alg = preg_replace("/B2/","<911>",$alg);   $alg = preg_replace("/B/","<912>",$alg);
    $alg = preg_replace("/U'/","<913>",$alg); $alg = preg_replace("/U-/","<913>",$alg);   $alg = preg_replace("/U2/","<914>",$alg);   $alg = preg_replace("/U/","<915>",$alg);
    $alg = preg_replace("/D'/","<916>",$alg); $alg = preg_replace("/D-/","<916>",$alg);   $alg = preg_replace("/D2/","<917>",$alg);   $alg = preg_replace("/D/","<918>",$alg);
    
    /* ··································································································· */
    /* --- 3xC: CODE -> TWIZZLE: [5] Mid-layer [1] (Numbered layer) [6] (Wide) twists --- */
    /* M = N = W */
    if ($useSiGN == true) { // Bei SiGN:
      $alg = preg_replace("/<101>/","M", $alg);   $alg = preg_replace("/<102>/","M2",$alg);   $alg = preg_replace("/<103>/","M'",$alg);
      $alg = preg_replace("/<104>/","S'",$alg);   $alg = preg_replace("/<105>/","S2",$alg);   $alg = preg_replace("/<106>/","S", $alg);
      $alg = preg_replace("/<107>/","E", $alg);   $alg = preg_replace("/<108>/","E2",$alg);   $alg = preg_replace("/<109>/","E'",$alg);
      
    } else {               // Sonst (TWIZZLE):
      $alg = preg_replace("/<101>/","2R'",$alg);   $alg = preg_replace("/<102>/","2R2",$alg);   $alg = preg_replace("/<103>/","2R",$alg);
      $alg = preg_replace("/<104>/","2F'",$alg);   $alg = preg_replace("/<105>/","2F2",$alg);   $alg = preg_replace("/<106>/","2F",$alg);
      $alg = preg_replace("/<107>/","2U'",$alg);   $alg = preg_replace("/<108>/","2U2",$alg);   $alg = preg_replace("/<109>/","2U",$alg);
    }
    
    /* --- 3xC: CODE -> TWIZZLE: [2] Slice twists --- */
    /* S = S2-2 */
    $alg = preg_replace("/<201>/","R' L",$alg);   $alg = preg_replace("/<202>/","R2 L2",$alg);   $alg = preg_replace("/<203>/","R L'",$alg);
    $alg = preg_replace("/<204>/","F' B",$alg);   $alg = preg_replace("/<205>/","F2 B2",$alg);   $alg = preg_replace("/<206>/","F B'",$alg);
    $alg = preg_replace("/<207>/","U' D",$alg);   $alg = preg_replace("/<208>/","U2 D2",$alg);   $alg = preg_replace("/<209>/","U D'",$alg);
    
    /* --- 3xC: CODE -> TWIZZLE: [3] Tier twists --- */
    /* T */
    $alg = preg_replace("/<301>/","r'",$alg);   $alg = preg_replace("/<302>/","r2",$alg);   $alg = preg_replace("/<303>/","r",$alg);
    $alg = preg_replace("/<304>/","l'",$alg);   $alg = preg_replace("/<305>/","l2",$alg);   $alg = preg_replace("/<306>/","l",$alg);
    $alg = preg_replace("/<307>/","f'",$alg);   $alg = preg_replace("/<308>/","f2",$alg);   $alg = preg_replace("/<309>/","f",$alg);
    $alg = preg_replace("/<310>/","b'",$alg);   $alg = preg_replace("/<311>/","b2",$alg);   $alg = preg_replace("/<312>/","b",$alg);
    $alg = preg_replace("/<313>/","u'",$alg);   $alg = preg_replace("/<314>/","u2",$alg);   $alg = preg_replace("/<315>/","u",$alg);
    $alg = preg_replace("/<316>/","d'",$alg);   $alg = preg_replace("/<317>/","d2",$alg);   $alg = preg_replace("/<318>/","d",$alg);
    
    /* --- 3xC: CODE -> TWIZZLE: [7] Cube rotations --- */
    /* C */
    $useSiGN    = false; // Notation style: SiGN or TWIZZLE (Default).
    if ($useSiGN == true) { // Bei SiGN:
      $alg = preg_replace("/<701>/","x'",$alg);   $alg = preg_replace("/<702>/","x2",$alg);   $alg = preg_replace("/<703>/","x",$alg);
      $alg = preg_replace("/<704>/","z'",$alg);   $alg = preg_replace("/<705>/","z2",$alg);   $alg = preg_replace("/<706>/","z",$alg);
      $alg = preg_replace("/<707>/","y'",$alg);   $alg = preg_replace("/<708>/","y2",$alg);   $alg = preg_replace("/<709>/","y",$alg);
      
    } else {               // Sonst (TWIZZLE):
      $alg = preg_replace("/<701>/","Rv'",$alg);   $alg = preg_replace("/<702>/","Rv2",$alg);   $alg = preg_replace("/<703>/","Rv",$alg);
      $alg = preg_replace("/<704>/","Fv'",$alg);   $alg = preg_replace("/<705>/","Fv2",$alg);   $alg = preg_replace("/<706>/","Fv",$alg);
      $alg = preg_replace("/<707>/","Uv'",$alg);   $alg = preg_replace("/<708>/","Uv2",$alg);   $alg = preg_replace("/<709>/","Uv",$alg);
    }
    
    /* --- 3xC: CODE -> TWIZZLE: [9] Face twists --- */
    /*   */
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
  * 15.07.2022: Not supported Tokens by TWIZZLE:
  *   1-2R 1-2L 1-2F 1-2B 1-2U 1-2D  ->  TR TL TF TB TU TD
  *   1R 1L 1F 1B 1U 1D              ->  R L F B U D
  *   2R 2L 2F 2B 2U 2D              ->  MR ML MF MB MU MD
  *   3R 3L 3F 3B 3U 3D              ->  L' R' B' F' D' U'
  *   m s e                          ->  WR' WF WU'
  * 
  * Parameter: $alg (STRING): The algorithm.
  * 
  * Return: STRING.
  ---------------------------------------------------------------------------------------------------
  */
  function alg3xC_TwizzleToSse($alg) {
    /* --- 3xC: Preferences --- */
    $optSSE = true;  // Optimize SSE (rebuilds Slice twists).
    
    /* --- 3xC: Marker --- */
    $alg = str_replace(".","·",$alg);
    
    /* ··································································································· */
    /* --- 3xC: TWIZZLE -> CODE: [2] Slice twists --- */
    if ($optSSE == true) {
      /* S = S2-2 */
      $alg = preg_replace("/2L' Rv'/","<201>",$alg); $alg = preg_replace("/2L- Rv-/","<201>",$alg);   $alg = preg_replace("/2L2 Rv2/","<202>",$alg);   $alg = preg_replace("/2L Rv/","<203>",$alg);
      $alg = preg_replace("/2R' Lv'/","<203>",$alg); $alg = preg_replace("/2R- Lv-/","<203>",$alg);   $alg = preg_replace("/2R2 Lv2/","<202>",$alg);   $alg = preg_replace("/2R Lv/","<201>",$alg);
      $alg = preg_replace("/2B' Fv'/","<204>",$alg); $alg = preg_replace("/2B- Fv-/","<204>",$alg);   $alg = preg_replace("/2B2 Fv2/","<205>",$alg);   $alg = preg_replace("/2B Fv/","<206>",$alg);
      $alg = preg_replace("/2F' Bv'/","<206>",$alg); $alg = preg_replace("/2F- Bv-/","<206>",$alg);   $alg = preg_replace("/2F2 Bv2/","<205>",$alg);   $alg = preg_replace("/2F Bv/","<204>",$alg);
      $alg = preg_replace("/2D' Uv'/","<207>",$alg); $alg = preg_replace("/2D- Uv-/","<207>",$alg);   $alg = preg_replace("/2D2 Uv2/","<208>",$alg);   $alg = preg_replace("/2D Uv/","<209>",$alg);
      $alg = preg_replace("/2U' Dv'/","<209>",$alg); $alg = preg_replace("/2U- Dv-/","<209>",$alg);   $alg = preg_replace("/2U2 Dv2/","<208>",$alg);   $alg = preg_replace("/2U Dv/","<207>",$alg);
      
      $alg = preg_replace("/2R Rv'/","<201>",$alg); $alg = preg_replace("/2R Rv-/","<201>",$alg);   $alg = preg_replace("/2R2 Rv2/","<202>",$alg);   $alg = preg_replace("/2R' Rv/","<203>",$alg); $alg = preg_replace("/2R- Rv/","<203>",$alg);
      $alg = preg_replace("/2L Lv'/","<203>",$alg); $alg = preg_replace("/2L Lv-/","<203>",$alg);   $alg = preg_replace("/2L2 Lv2/","<202>",$alg);   $alg = preg_replace("/2L' Lv/","<201>",$alg); $alg = preg_replace("/2L- Lv/","<201>",$alg);
      $alg = preg_replace("/2F Fv'/","<204>",$alg); $alg = preg_replace("/2F Fv-/","<204>",$alg);   $alg = preg_replace("/2F2 Fv2/","<205>",$alg);   $alg = preg_replace("/2F' Fv/","<206>",$alg); $alg = preg_replace("/2F- Fv/","<206>",$alg);
      $alg = preg_replace("/2B Bv'/","<206>",$alg); $alg = preg_replace("/2B Bv-/","<206>",$alg);   $alg = preg_replace("/2B2 Bv2/","<205>",$alg);   $alg = preg_replace("/2B' Bv/","<204>",$alg); $alg = preg_replace("/2B- Bv/","<204>",$alg);
      $alg = preg_replace("/2U Uv'/","<207>",$alg); $alg = preg_replace("/2U Uv-/","<207>",$alg);   $alg = preg_replace("/2U2 Uv2/","<208>",$alg);   $alg = preg_replace("/2U' Uv/","<209>",$alg); $alg = preg_replace("/2U- Uv/","<209>",$alg);
      $alg = preg_replace("/2D Dv'/","<209>",$alg); $alg = preg_replace("/2D Dv-/","<209>",$alg);   $alg = preg_replace("/2D2 Dv2/","<208>",$alg);   $alg = preg_replace("/2D' Dv/","<207>",$alg); $alg = preg_replace("/2D- Dv/","<207>",$alg);
    }
    
    /* --- 3xC: TWIZZLE -> CODE: [5] Mid-layer [1] (Numbered layer) [6] (Wide) twists --- */
    /* M */
    $alg = preg_replace("/2R'/","<101>",$alg); $alg = preg_replace("/2R2/","<102>",$alg); $alg = preg_replace("/2R/","<103>",$alg);
    $alg = preg_replace("/2L'/","<103>",$alg); $alg = preg_replace("/2L2/","<102>",$alg); $alg = preg_replace("/2L/","<101>",$alg);
    $alg = preg_replace("/2F'/","<104>",$alg); $alg = preg_replace("/2F2/","<105>",$alg); $alg = preg_replace("/2F/","<106>",$alg);
    $alg = preg_replace("/2B'/","<106>",$alg); $alg = preg_replace("/2B2/","<105>",$alg); $alg = preg_replace("/2B/","<104>",$alg);
    $alg = preg_replace("/2U'/","<107>",$alg); $alg = preg_replace("/2U2/","<108>",$alg); $alg = preg_replace("/2U/","<109>",$alg);
    $alg = preg_replace("/2D'/","<109>",$alg); $alg = preg_replace("/2D2/","<108>",$alg); $alg = preg_replace("/2D/","<107>",$alg);
    
    /* --- 3xC: TWIZZLE -> CODE: [2] Slice twists --- */
    if ($optSSE == true) {
      /* S = S2-2 */
      $alg = preg_replace("/M' Rv'/","<201>",$alg); $alg = preg_replace("/M- Rv-/","<201>",$alg);   $alg = preg_replace("/M2 Rv2/","<202>",$alg);   $alg = preg_replace("/M Rv/", "<203>",$alg);
      $alg = preg_replace("/M Lv'/", "<203>",$alg); $alg = preg_replace("/M Lv-/", "<203>",$alg);   $alg = preg_replace("/M2 Lv2/","<202>",$alg);   $alg = preg_replace("/M' Lv/","<201>",$alg); $alg = preg_replace("/M- Lv/","<201>",$alg);
      $alg = preg_replace("/S Fv'/", "<204>",$alg); $alg = preg_replace("/S Fv-/", "<204>",$alg);   $alg = preg_replace("/S2 Fv2/","<205>",$alg);   $alg = preg_replace("/S' Fv/","<206>",$alg); $alg = preg_replace("/S- Fv/","<206>",$alg);
      $alg = preg_replace("/S' Bv'/","<206>",$alg); $alg = preg_replace("/S- Bv-/","<206>",$alg);   $alg = preg_replace("/S2 Bv2/","<205>",$alg);   $alg = preg_replace("/S Bv/", "<204>",$alg);
      $alg = preg_replace("/E' Uv'/","<207>",$alg); $alg = preg_replace("/E- Uv-/","<207>",$alg);   $alg = preg_replace("/E2 Uv2/","<208>",$alg);   $alg = preg_replace("/E Uv/", "<209>",$alg);
      $alg = preg_replace("/E Dv'/", "<209>",$alg); $alg = preg_replace("/E Dv-/", "<209>",$alg);   $alg = preg_replace("/E2 Dv2/","<208>",$alg);   $alg = preg_replace("/E' Dv/","<207>",$alg); $alg = preg_replace("/E' Dv/","<207>",$alg);
      
      /* Non-slice-twists */
      $alg = preg_replace("/R' L'/","<210>",$alg);
      $alg = preg_replace("/L' R'/","<210>",$alg);
      $alg = preg_replace("/F' B'/","<211>",$alg);
      $alg = preg_replace("/B' F'/","<211>",$alg);
      $alg = preg_replace("/U' D'/","<212>",$alg);
      $alg = preg_replace("/D' U'/","<212>",$alg);
      
      /* S = S2-2 */
      $alg = preg_replace("/R L'/","<203>",$alg); $alg = preg_replace("/R L-/","<203>",$alg);   $alg = preg_replace("/R2 L2/","<202>",$alg);   $alg = preg_replace("/R' L/","<201>",$alg); $alg = preg_replace("/R- L/","<201>",$alg);
      $alg = preg_replace("/L R'/","<201>",$alg); $alg = preg_replace("/L R-/","<201>",$alg);   $alg = preg_replace("/L2 R2/","<202>",$alg);   $alg = preg_replace("/L' R/","<203>",$alg); $alg = preg_replace("/L- R/","<203>",$alg);
      $alg = preg_replace("/F B'/","<206>",$alg); $alg = preg_replace("/F B-/","<206>",$alg);   $alg = preg_replace("/F2 B2/","<205>",$alg);   $alg = preg_replace("/F' B/","<204>",$alg); $alg = preg_replace("/F- B/","<204>",$alg);
      $alg = preg_replace("/B F'/","<204>",$alg); $alg = preg_replace("/B F-/","<204>",$alg);   $alg = preg_replace("/B2 F2/","<205>",$alg);   $alg = preg_replace("/B' F/","<206>",$alg); $alg = preg_replace("/B- F/","<206>",$alg);
      $alg = preg_replace("/U D'/","<209>",$alg); $alg = preg_replace("/U D-/","<209>",$alg);   $alg = preg_replace("/U2 D2/","<208>",$alg);   $alg = preg_replace("/U' D/","<207>",$alg); $alg = preg_replace("/U- D/","<207>",$alg);
      $alg = preg_replace("/D U'/","<207>",$alg); $alg = preg_replace("/D U-/","<207>",$alg);   $alg = preg_replace("/D2 U2/","<208>",$alg);   $alg = preg_replace("/D' U/","<209>",$alg); $alg = preg_replace("/D- U/","<209>",$alg);
    }
    
    /* --- 3xC: TWIZZLE -> CODE: [3] Tier twists (WCA) --- */
    /* T */
    $alg = preg_replace("/Rw'/","<301>",$alg); $alg = preg_replace("/Rw2/","<302>",$alg); $alg = preg_replace("/Rw/","<303>",$alg);
    $alg = preg_replace("/Lw'/","<304>",$alg); $alg = preg_replace("/Lw2/","<305>",$alg); $alg = preg_replace("/Lw/","<306>",$alg);
    $alg = preg_replace("/Fw'/","<307>",$alg); $alg = preg_replace("/Fw2/","<308>",$alg); $alg = preg_replace("/Fw/","<309>",$alg);
    $alg = preg_replace("/Bw'/","<310>",$alg); $alg = preg_replace("/Bw2/","<311>",$alg); $alg = preg_replace("/Bw/","<312>",$alg);
    $alg = preg_replace("/Uw'/","<313>",$alg); $alg = preg_replace("/Uw2/","<314>",$alg); $alg = preg_replace("/Uw/","<315>",$alg);
    $alg = preg_replace("/Dw'/","<316>",$alg); $alg = preg_replace("/Dw2/","<317>",$alg); $alg = preg_replace("/Dw/","<318>",$alg);
    
    /* --- 3xC: TWIZZLE -> CODE: [7] Cube rotations --- */
    /* C */
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
    /* M */
    $alg = preg_replace("/M'/","<103>",$alg); $alg = preg_replace("/M2/","<102>",$alg); $alg = preg_replace("/M/","<101>",$alg);
    $alg = preg_replace("/S'/","<104>",$alg); $alg = preg_replace("/S2/","<105>",$alg); $alg = preg_replace("/S/","<106>",$alg);
    $alg = preg_replace("/E'/","<109>",$alg); $alg = preg_replace("/E2/","<108>",$alg); $alg = preg_replace("/E/","<107>",$alg);
    
    /* --- 3xC: TWIZZLE -> CODE: [9] Face twists --- */
    /*   */
    $alg = preg_replace("/R'/","<901>",$alg); $alg = preg_replace("/R2/","<902>",$alg); $alg = preg_replace("/R/","<903>",$alg);
    $alg = preg_replace("/L'/","<904>",$alg); $alg = preg_replace("/L2/","<905>",$alg); $alg = preg_replace("/L/","<906>",$alg);
    $alg = preg_replace("/F'/","<907>",$alg); $alg = preg_replace("/F2/","<908>",$alg); $alg = preg_replace("/F/","<909>",$alg);
    $alg = preg_replace("/B'/","<910>",$alg); $alg = preg_replace("/B2/","<911>",$alg); $alg = preg_replace("/B/","<912>",$alg);
    $alg = preg_replace("/U'/","<913>",$alg); $alg = preg_replace("/U2/","<914>",$alg); $alg = preg_replace("/U/","<915>",$alg);
    $alg = preg_replace("/D'/","<916>",$alg); $alg = preg_replace("/D2/","<917>",$alg); $alg = preg_replace("/D/","<918>",$alg);
    
    /* --- 3xC: TWIZZLE -> CODE: [3] Tier twists (SiGN) --- */
    /* T */
    $alg = preg_replace("/r'/","<301>",$alg); $alg = preg_replace("/r2/","<302>",$alg); $alg = preg_replace("/r/","<303>",$alg);
    $alg = preg_replace("/l'/","<304>",$alg); $alg = preg_replace("/l2/","<305>",$alg); $alg = preg_replace("/l/","<306>",$alg);
    $alg = preg_replace("/f'/","<307>",$alg); $alg = preg_replace("/f2/","<308>",$alg); $alg = preg_replace("/f/","<309>",$alg);
    $alg = preg_replace("/b'/","<310>",$alg); $alg = preg_replace("/b2/","<311>",$alg); $alg = preg_replace("/b/","<312>",$alg);
    $alg = preg_replace("/u'/","<313>",$alg); $alg = preg_replace("/u2/","<314>",$alg); $alg = preg_replace("/u/","<315>",$alg);
    $alg = preg_replace("/d'/","<316>",$alg); $alg = preg_replace("/d2/","<317>",$alg); $alg = preg_replace("/d/","<318>",$alg);
    
    /* ··································································································· */
    /* --- 3xC: CODE -> SSE opt: [2] Slice twists --- */
    if ($optSSE == true) {
      /* Non-slice-twists */
      $alg = preg_replace("/<210>/","R' L'",$alg);
      $alg = preg_replace("/<211>/","F' B'",$alg);
      $alg = preg_replace("/<212>/","U' D'",$alg);
      
      /* S = S2-2 */
      $alg = preg_replace("/<201>/","SR'",$alg); $alg = preg_replace("/<202>/","SR2",$alg); $alg = preg_replace("/<203>/","SR",$alg);
      $alg = preg_replace("/<204>/","SF'",$alg); $alg = preg_replace("/<205>/","SF2",$alg); $alg = preg_replace("/<206>/","SF",$alg);
      $alg = preg_replace("/<207>/","SU'",$alg); $alg = preg_replace("/<208>/","SU2",$alg); $alg = preg_replace("/<209>/","SU",$alg);
    }
    
    /* --- 3xC: CODE -> SSE: [5] Mid-layer [1] (Numbered layer) [6] (Wide) twists --- */
    /* M */
    $alg = preg_replace("/<101>/","MR'",$alg); $alg = preg_replace("/<102>/","MR2",$alg); $alg = preg_replace("/<103>/","MR",$alg);
    $alg = preg_replace("/<104>/","MF'",$alg); $alg = preg_replace("/<105>/","MF2",$alg); $alg = preg_replace("/<106>/","MF",$alg);
    $alg = preg_replace("/<107>/","MU'",$alg); $alg = preg_replace("/<108>/","MU2",$alg); $alg = preg_replace("/<109>/","MU",$alg);
    
    /* --- 3xC: CODE -> SSE: [7] Cube rotations --- */
    /* C */
    $alg = preg_replace("/<701>/","CR'",$alg); $alg = preg_replace("/<702>/","CR2",$alg); $alg = preg_replace("/<703>/","CR",$alg);
    $alg = preg_replace("/<704>/","CF'",$alg); $alg = preg_replace("/<705>/","CF2",$alg); $alg = preg_replace("/<706>/","CF",$alg);
    $alg = preg_replace("/<707>/","CU'",$alg); $alg = preg_replace("/<708>/","CU2",$alg); $alg = preg_replace("/<709>/","CU",$alg);
    
    /* --- 3xC: CODE -> SSE: [9] Face twists --- */
    /*   */
    $alg = preg_replace("/<901>/","R'",$alg); $alg = preg_replace("/<902>/","R2",$alg); $alg = preg_replace("/<903>/","R",$alg);
    $alg = preg_replace("/<904>/","L'",$alg); $alg = preg_replace("/<905>/","L2",$alg); $alg = preg_replace("/<906>/","L",$alg);
    $alg = preg_replace("/<907>/","F'",$alg); $alg = preg_replace("/<908>/","F2",$alg); $alg = preg_replace("/<909>/","F",$alg);
    $alg = preg_replace("/<910>/","B'",$alg); $alg = preg_replace("/<911>/","B2",$alg); $alg = preg_replace("/<912>/","B",$alg);
    $alg = preg_replace("/<913>/","U'",$alg); $alg = preg_replace("/<914>/","U2",$alg); $alg = preg_replace("/<915>/","U",$alg);
    $alg = preg_replace("/<916>/","D'",$alg); $alg = preg_replace("/<917>/","D2",$alg); $alg = preg_replace("/<918>/","D",$alg);
    
    /* --- 3xC: CODE -> SSE: [3] Tier twists --- */
    /* T */
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
    /* --- 4xC: SSE -> CODE: [1] (Numbered-layer) [5] Mid-layer twists --- */
    /* N3 = M = N */
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
    /* S = S2-3 */
    $alg = preg_replace("/SR'/","<201>",$alg); $alg = preg_replace("/SR-/","<201>",$alg);   $alg = preg_replace("/SR2/","<202>",$alg);   $alg = preg_replace("/SR/","<203>",$alg);
    $alg = preg_replace("/SL'/","<203>",$alg); $alg = preg_replace("/SL-/","<203>",$alg);   $alg = preg_replace("/SL2/","<202>",$alg);   $alg = preg_replace("/SL/","<201>",$alg);
    $alg = preg_replace("/SF'/","<204>",$alg); $alg = preg_replace("/SF-/","<204>",$alg);   $alg = preg_replace("/SF2/","<205>",$alg);   $alg = preg_replace("/SF/","<206>",$alg);
    $alg = preg_replace("/SB'/","<206>",$alg); $alg = preg_replace("/SB-/","<206>",$alg);   $alg = preg_replace("/SB2/","<205>",$alg);   $alg = preg_replace("/SB/","<204>",$alg);
    $alg = preg_replace("/SU'/","<207>",$alg); $alg = preg_replace("/SU-/","<207>",$alg);   $alg = preg_replace("/SU2/","<208>",$alg);   $alg = preg_replace("/SU/","<209>",$alg);
    $alg = preg_replace("/SD'/","<209>",$alg); $alg = preg_replace("/SD-/","<209>",$alg);   $alg = preg_replace("/SD2/","<208>",$alg);   $alg = preg_replace("/SD/","<207>",$alg);
    
    $alg = preg_replace("/S2-3R'/","<201>",$alg); $alg = preg_replace("/S2-3R-/","<201>",$alg);   $alg = preg_replace("/S2-3R2/","<202>",$alg);   $alg = preg_replace("/S2-3R/","<203>",$alg);
    $alg = preg_replace("/S2-3L'/","<203>",$alg); $alg = preg_replace("/S2-3L-/","<203>",$alg);   $alg = preg_replace("/S2-3L2/","<202>",$alg);   $alg = preg_replace("/S2-3L/","<201>",$alg);
    $alg = preg_replace("/S2-3F'/","<204>",$alg); $alg = preg_replace("/S2-3F-/","<204>",$alg);   $alg = preg_replace("/S2-3F2/","<205>",$alg);   $alg = preg_replace("/S2-3F/","<206>",$alg);
    $alg = preg_replace("/S2-3B'/","<206>",$alg); $alg = preg_replace("/S2-3B-/","<206>",$alg);   $alg = preg_replace("/S2-3B2/","<205>",$alg);   $alg = preg_replace("/S2-3B/","<204>",$alg);
    $alg = preg_replace("/S2-3U'/","<207>",$alg); $alg = preg_replace("/S2-3U-/","<207>",$alg);   $alg = preg_replace("/S2-3U2/","<208>",$alg);   $alg = preg_replace("/S2-3U/","<209>",$alg);
    $alg = preg_replace("/S2-3D'/","<209>",$alg); $alg = preg_replace("/S2-3D-/","<209>",$alg);   $alg = preg_replace("/S2-3D2/","<208>",$alg);   $alg = preg_replace("/S2-3D/","<207>",$alg);
    
    
    /* S2-2 | S3-3 */
    $alg = preg_replace("/S2-2R'/","<210>",$alg); $alg = preg_replace("/S2-2R-/","<210>",$alg);   $alg = preg_replace("/S2-2R2/","<211>",$alg);   $alg = preg_replace("/S2-2R/","<212>",$alg);
    $alg = preg_replace("/S2-2L'/","<213>",$alg); $alg = preg_replace("/S2-2L-/","<213>",$alg);   $alg = preg_replace("/S2-2L2/","<214>",$alg);   $alg = preg_replace("/S2-2L/","<215>",$alg);
    $alg = preg_replace("/S2-2F'/","<216>",$alg); $alg = preg_replace("/S2-2F-/","<216>",$alg);   $alg = preg_replace("/S2-2F2/","<217>",$alg);   $alg = preg_replace("/S2-2F/","<218>",$alg);
    $alg = preg_replace("/S2-2B'/","<219>",$alg); $alg = preg_replace("/S2-2B-/","<219>",$alg);   $alg = preg_replace("/S2-2B2/","<220>",$alg);   $alg = preg_replace("/S2-2B/","<221>",$alg);
    $alg = preg_replace("/S2-2U'/","<222>",$alg); $alg = preg_replace("/S2-2U-/","<222>",$alg);   $alg = preg_replace("/S2-2U2/","<223>",$alg);   $alg = preg_replace("/S2-2U/","<224>",$alg);
    $alg = preg_replace("/S2-2D'/","<225>",$alg); $alg = preg_replace("/S2-2D-/","<225>",$alg);   $alg = preg_replace("/S2-2D2/","<226>",$alg);   $alg = preg_replace("/S2-2D/","<227>",$alg);
    
    $alg = preg_replace("/S3-3R'/","<215>",$alg); $alg = preg_replace("/S3-3R-/","<215>",$alg);   $alg = preg_replace("/S3-3R2/","<214>",$alg);   $alg = preg_replace("/S3-3R/","<213>",$alg);
    $alg = preg_replace("/S3-3L'/","<212>",$alg); $alg = preg_replace("/S3-3L-/","<212>",$alg);   $alg = preg_replace("/S3-3L2/","<211>",$alg);   $alg = preg_replace("/S3-3L/","<210>",$alg);
    $alg = preg_replace("/S3-3F'/","<221>",$alg); $alg = preg_replace("/S3-3F-/","<221>",$alg);   $alg = preg_replace("/S3-3F2/","<220>",$alg);   $alg = preg_replace("/S3-3F/","<219>",$alg);
    $alg = preg_replace("/S3-3B'/","<218>",$alg); $alg = preg_replace("/S3-3B-/","<218>",$alg);   $alg = preg_replace("/S3-3B2/","<217>",$alg);   $alg = preg_replace("/S3-3B/","<216>",$alg);
    $alg = preg_replace("/S3-3U'/","<227>",$alg); $alg = preg_replace("/S3-3U-/","<227>",$alg);   $alg = preg_replace("/S3-3U2/","<226>",$alg);   $alg = preg_replace("/S3-3U/","<225>",$alg);
    $alg = preg_replace("/S3-3D'/","<224>",$alg); $alg = preg_replace("/S3-3D-/","<224>",$alg);   $alg = preg_replace("/S3-3D2/","<223>",$alg);   $alg = preg_replace("/S3-3D/","<222>",$alg);
    
    /* --- 4xC: SSE -> CODE: [3] Tier twists --- */
    /* T3 */
    $alg = preg_replace("/T3R'/","<301>",$alg); $alg = preg_replace("/T3R-/","<301>",$alg);   $alg = preg_replace("/T3R2/","<302>",$alg);   $alg = preg_replace("/T3R/","<303>",$alg);
    $alg = preg_replace("/T3L'/","<304>",$alg); $alg = preg_replace("/T3L-/","<304>",$alg);   $alg = preg_replace("/T3L2/","<305>",$alg);   $alg = preg_replace("/T3L/","<306>",$alg);
    $alg = preg_replace("/T3F'/","<307>",$alg); $alg = preg_replace("/T3F-/","<307>",$alg);   $alg = preg_replace("/T3F2/","<308>",$alg);   $alg = preg_replace("/T3F/","<309>",$alg);
    $alg = preg_replace("/T3B'/","<310>",$alg); $alg = preg_replace("/T3B-/","<310>",$alg);   $alg = preg_replace("/T3B2/","<311>",$alg);   $alg = preg_replace("/T3B/","<312>",$alg);
    $alg = preg_replace("/T3U'/","<313>",$alg); $alg = preg_replace("/T3U-/","<313>",$alg);   $alg = preg_replace("/T3U2/","<314>",$alg);   $alg = preg_replace("/T3U/","<315>",$alg);
    $alg = preg_replace("/T3D'/","<316>",$alg); $alg = preg_replace("/T3D-/","<316>",$alg);   $alg = preg_replace("/T3D2/","<317>",$alg);   $alg = preg_replace("/T3D/","<318>",$alg);
    
    
    /* T */
    $alg = preg_replace("/TR'/","<319>",$alg); $alg = preg_replace("/TR-/","<319>",$alg);   $alg = preg_replace("/TR2/","<320>",$alg);   $alg = preg_replace("/TR/","<321>",$alg);
    $alg = preg_replace("/TL'/","<322>",$alg); $alg = preg_replace("/TL-/","<322>",$alg);   $alg = preg_replace("/TL2/","<323>",$alg);   $alg = preg_replace("/TL/","<324>",$alg);
    $alg = preg_replace("/TF'/","<325>",$alg); $alg = preg_replace("/TF-/","<325>",$alg);   $alg = preg_replace("/TF2/","<326>",$alg);   $alg = preg_replace("/TF/","<327>",$alg);
    $alg = preg_replace("/TB'/","<328>",$alg); $alg = preg_replace("/TB-/","<328>",$alg);   $alg = preg_replace("/TB2/","<329>",$alg);   $alg = preg_replace("/TB/","<330>",$alg);
    $alg = preg_replace("/TU'/","<331>",$alg); $alg = preg_replace("/TU-/","<331>",$alg);   $alg = preg_replace("/TU2/","<332>",$alg);   $alg = preg_replace("/TU/","<333>",$alg);
    $alg = preg_replace("/TD'/","<334>",$alg); $alg = preg_replace("/TD-/","<334>",$alg);   $alg = preg_replace("/TD2/","<335>",$alg);   $alg = preg_replace("/TD/","<336>",$alg);
    
    /* --- 4xC: SSE -> CODE: [6] Wide-layer [5] (Mid-layer) [4] (Void) [1] (Numbered layer) twists --- */
    /* W = M2 = V = N2-3 */
    $alg = preg_replace("/WR'/","<501>",$alg); $alg = preg_replace("/WR-/","<501>",$alg);   $alg = preg_replace("/WR2/","<502>",$alg);   $alg = preg_replace("/WR/","<503>",$alg);
    $alg = preg_replace("/WL'/","<503>",$alg); $alg = preg_replace("/WL-/","<503>",$alg);   $alg = preg_replace("/WL2/","<502>",$alg);   $alg = preg_replace("/WL/","<501>",$alg);
    $alg = preg_replace("/WF'/","<504>",$alg); $alg = preg_replace("/WF-/","<504>",$alg);   $alg = preg_replace("/WF2/","<505>",$alg);   $alg = preg_replace("/WF/","<506>",$alg);
    $alg = preg_replace("/WB'/","<506>",$alg); $alg = preg_replace("/WB-/","<506>",$alg);   $alg = preg_replace("/WB2/","<505>",$alg);   $alg = preg_replace("/WB/","<504>",$alg);
    $alg = preg_replace("/WU'/","<507>",$alg); $alg = preg_replace("/WU-/","<507>",$alg);   $alg = preg_replace("/WU2/","<508>",$alg);   $alg = preg_replace("/WU/","<509>",$alg);
    $alg = preg_replace("/WD'/","<509>",$alg); $alg = preg_replace("/WD-/","<509>",$alg);   $alg = preg_replace("/WD2/","<508>",$alg);   $alg = preg_replace("/WD/","<507>",$alg);
    
    $alg = preg_replace("/M2R'/","<501>",$alg); $alg = preg_replace("/M2R-/","<501>",$alg);   $alg = preg_replace("/M2R2/","<502>",$alg);   $alg = preg_replace("/M2R/","<503>",$alg);
    $alg = preg_replace("/M2L'/","<503>",$alg); $alg = preg_replace("/M2L-/","<503>",$alg);   $alg = preg_replace("/M2L2/","<502>",$alg);   $alg = preg_replace("/M2L/","<501>",$alg);
    $alg = preg_replace("/M2F'/","<504>",$alg); $alg = preg_replace("/M2F-/","<504>",$alg);   $alg = preg_replace("/M2F2/","<505>",$alg);   $alg = preg_replace("/M2F/","<506>",$alg);
    $alg = preg_replace("/M2B'/","<506>",$alg); $alg = preg_replace("/M2B-/","<506>",$alg);   $alg = preg_replace("/M2B2/","<505>",$alg);   $alg = preg_replace("/M2B/","<504>",$alg);
    $alg = preg_replace("/M2U'/","<507>",$alg); $alg = preg_replace("/M2U-/","<507>",$alg);   $alg = preg_replace("/M2U2/","<508>",$alg);   $alg = preg_replace("/M2U/","<509>",$alg);
    $alg = preg_replace("/M2D'/","<509>",$alg); $alg = preg_replace("/M2D-/","<509>",$alg);   $alg = preg_replace("/M2D2/","<508>",$alg);   $alg = preg_replace("/M2D/","<507>",$alg);
    
    $alg = preg_replace("/VR'/","<501>",$alg); $alg = preg_replace("/VR-/","<501>",$alg);   $alg = preg_replace("/VR2/","<502>",$alg);   $alg = preg_replace("/VR/","<503>",$alg);
    $alg = preg_replace("/VL'/","<503>",$alg); $alg = preg_replace("/VL-/","<503>",$alg);   $alg = preg_replace("/VL2/","<502>",$alg);   $alg = preg_replace("/VL/","<501>",$alg);
    $alg = preg_replace("/VF'/","<504>",$alg); $alg = preg_replace("/VF-/","<504>",$alg);   $alg = preg_replace("/VF2/","<505>",$alg);   $alg = preg_replace("/VF/","<506>",$alg);
    $alg = preg_replace("/VB'/","<506>",$alg); $alg = preg_replace("/VB-/","<506>",$alg);   $alg = preg_replace("/VB2/","<505>",$alg);   $alg = preg_replace("/VB/","<504>",$alg);
    $alg = preg_replace("/VU'/","<507>",$alg); $alg = preg_replace("/VU-/","<507>",$alg);   $alg = preg_replace("/VU2/","<508>",$alg);   $alg = preg_replace("/VU/","<509>",$alg);
    $alg = preg_replace("/VD'/","<509>",$alg); $alg = preg_replace("/VD-/","<509>",$alg);   $alg = preg_replace("/VD2/","<508>",$alg);   $alg = preg_replace("/VD/","<507>",$alg);
    
    $alg = preg_replace("/N2-3R'/","<501>",$alg); $alg = preg_replace("/N2-3R-/","<501>",$alg);   $alg = preg_replace("/N2-3R2/","<502>",$alg);   $alg = preg_replace("/N2-3R/","<503>",$alg);
    $alg = preg_replace("/N2-3L'/","<503>",$alg); $alg = preg_replace("/N2-3L-/","<503>",$alg);   $alg = preg_replace("/N2-3L2/","<502>",$alg);   $alg = preg_replace("/N2-3L/","<501>",$alg);
    $alg = preg_replace("/N2-3F'/","<504>",$alg); $alg = preg_replace("/N2-3F-/","<504>",$alg);   $alg = preg_replace("/N2-3F2/","<505>",$alg);   $alg = preg_replace("/N2-3F/","<506>",$alg);
    $alg = preg_replace("/N2-3B'/","<506>",$alg); $alg = preg_replace("/N2-3B-/","<506>",$alg);   $alg = preg_replace("/N2-3B2/","<505>",$alg);   $alg = preg_replace("/N2-3B/","<504>",$alg);
    $alg = preg_replace("/N2-3U'/","<507>",$alg); $alg = preg_replace("/N2-3U-/","<507>",$alg);   $alg = preg_replace("/N2-3U2/","<508>",$alg);   $alg = preg_replace("/N2-3U/","<509>",$alg);
    $alg = preg_replace("/N2-3D'/","<509>",$alg); $alg = preg_replace("/N2-3D-/","<509>",$alg);   $alg = preg_replace("/N2-3D2/","<508>",$alg);   $alg = preg_replace("/N2-3D/","<507>",$alg);
    
    /* --- 4xC: SSE -> CODE: [7] Cube rotations --- */
    /* C */
    $alg = preg_replace("/CR'/","<701>",$alg); $alg = preg_replace("/CR-/","<701>",$alg);   $alg = preg_replace("/CR2/","<702>",$alg);   $alg = preg_replace("/CR/","<703>",$alg);
    $alg = preg_replace("/CL'/","<703>",$alg); $alg = preg_replace("/CL-/","<703>",$alg);   $alg = preg_replace("/CL2/","<702>",$alg);   $alg = preg_replace("/CL/","<701>",$alg);
    $alg = preg_replace("/CF'/","<704>",$alg); $alg = preg_replace("/CF-/","<704>",$alg);   $alg = preg_replace("/CF2/","<705>",$alg);   $alg = preg_replace("/CF/","<706>",$alg);
    $alg = preg_replace("/CB'/","<706>",$alg); $alg = preg_replace("/CB-/","<706>",$alg);   $alg = preg_replace("/CB2/","<705>",$alg);   $alg = preg_replace("/CB/","<704>",$alg);
    $alg = preg_replace("/CU'/","<707>",$alg); $alg = preg_replace("/CU-/","<707>",$alg);   $alg = preg_replace("/CU2/","<708>",$alg);   $alg = preg_replace("/CU/","<709>",$alg);
    $alg = preg_replace("/CD'/","<709>",$alg); $alg = preg_replace("/CD-/","<709>",$alg);   $alg = preg_replace("/CD2/","<708>",$alg);   $alg = preg_replace("/CD/","<707>",$alg);
    
    /* --- 4xC: SSE -> CODE: [9] Face twists --- */
    /*   */
    $alg = preg_replace("/R'/","<901>",$alg); $alg = preg_replace("/R-/","<901>",$alg);   $alg = preg_replace("/R2/","<902>",$alg);   $alg = preg_replace("/R/","<903>",$alg);
    $alg = preg_replace("/L'/","<904>",$alg); $alg = preg_replace("/L-/","<904>",$alg);   $alg = preg_replace("/L2/","<905>",$alg);   $alg = preg_replace("/L/","<906>",$alg);
    $alg = preg_replace("/F'/","<907>",$alg); $alg = preg_replace("/F-/","<907>",$alg);   $alg = preg_replace("/F2/","<908>",$alg);   $alg = preg_replace("/F/","<909>",$alg);
    $alg = preg_replace("/B'/","<910>",$alg); $alg = preg_replace("/B-/","<910>",$alg);   $alg = preg_replace("/B2/","<911>",$alg);   $alg = preg_replace("/B/","<912>",$alg);
    $alg = preg_replace("/U'/","<913>",$alg); $alg = preg_replace("/U-/","<913>",$alg);   $alg = preg_replace("/U2/","<914>",$alg);   $alg = preg_replace("/U/","<915>",$alg);
    $alg = preg_replace("/D'/","<916>",$alg); $alg = preg_replace("/D-/","<916>",$alg);   $alg = preg_replace("/D2/","<917>",$alg);   $alg = preg_replace("/D/","<918>",$alg);
    
    /* ··································································································· */
    /* --- 4xC: CODE -> TWIZZLE: [1] Numbered-layer twists --- */
    /* N3 = M = N */
    $alg = preg_replace("/<101>/","2R'",$alg);   $alg = preg_replace("/<102>/","2R2",$alg);   $alg = preg_replace("/<103>/","2R",$alg);
    $alg = preg_replace("/<104>/","2L'",$alg);   $alg = preg_replace("/<105>/","2L2",$alg);   $alg = preg_replace("/<106>/","2L",$alg);
    $alg = preg_replace("/<107>/","2F'",$alg);   $alg = preg_replace("/<108>/","2F2",$alg);   $alg = preg_replace("/<109>/","2F",$alg);
    $alg = preg_replace("/<110>/","2B'",$alg);   $alg = preg_replace("/<111>/","2B2",$alg);   $alg = preg_replace("/<112>/","2B",$alg);
    $alg = preg_replace("/<113>/","2U'",$alg);   $alg = preg_replace("/<114>/","2U2",$alg);   $alg = preg_replace("/<115>/","2U",$alg);
    $alg = preg_replace("/<116>/","2D'",$alg);   $alg = preg_replace("/<117>/","2D2",$alg);   $alg = preg_replace("/<118>/","2D",$alg);
    
    /* --- 4xC: CODE -> TWIZZLE: [2] Slice twists --- */
    /* S | S2-3 */
    $alg = preg_replace("/<201>/","R' L",$alg);   $alg = preg_replace("/<202>/","R2 L2",$alg);   $alg = preg_replace("/<203>/","R L'",$alg);
    $alg = preg_replace("/<204>/","F' B",$alg);   $alg = preg_replace("/<205>/","F2 B2",$alg);   $alg = preg_replace("/<206>/","F B'",$alg);
    $alg = preg_replace("/<207>/","U' D",$alg);   $alg = preg_replace("/<208>/","U2 D2",$alg);   $alg = preg_replace("/<209>/","U D'",$alg);
    
    /* S2-2 | S3-3 */
    $alg = preg_replace("/<210>/","R' l",$alg);   $alg = preg_replace("/<211>/","R2 l2",$alg);   $alg = preg_replace("/<212>/","R l'",$alg);
    $alg = preg_replace("/<213>/","r L'",$alg);   $alg = preg_replace("/<214>/","r2 L2",$alg);   $alg = preg_replace("/<215>/","r' L",$alg);
    $alg = preg_replace("/<216>/","F' b",$alg);   $alg = preg_replace("/<217>/","F2 b2",$alg);   $alg = preg_replace("/<218>/","F b'",$alg);
    $alg = preg_replace("/<219>/","f B'",$alg);   $alg = preg_replace("/<220>/","f2 B2",$alg);   $alg = preg_replace("/<221>/","f' B",$alg);
    $alg = preg_replace("/<222>/","U' d",$alg);   $alg = preg_replace("/<223>/","U2 d2",$alg);   $alg = preg_replace("/<224>/","U d'",$alg);
    $alg = preg_replace("/<225>/","u D'",$alg);   $alg = preg_replace("/<226>/","u2 D2",$alg);   $alg = preg_replace("/<227>/","u' D",$alg);
    
    /* --- 4xC: CODE -> TWIZZLE: [3] Tier twists --- */
    /* T3 */
    $alg = preg_replace("/<301>/","3r'",$alg);   $alg = preg_replace("/<302>/","3r2",$alg);   $alg = preg_replace("/<303>/","3r",$alg);
    $alg = preg_replace("/<304>/","3l'",$alg);   $alg = preg_replace("/<305>/","3l2",$alg);   $alg = preg_replace("/<306>/","3l",$alg);
    $alg = preg_replace("/<307>/","3f'",$alg);   $alg = preg_replace("/<308>/","3f2",$alg);   $alg = preg_replace("/<309>/","3f",$alg);
    $alg = preg_replace("/<310>/","3b'",$alg);   $alg = preg_replace("/<311>/","3b2",$alg);   $alg = preg_replace("/<312>/","3b",$alg);
    $alg = preg_replace("/<313>/","3u'",$alg);   $alg = preg_replace("/<314>/","3u2",$alg);   $alg = preg_replace("/<315>/","3u",$alg);
    $alg = preg_replace("/<316>/","3d'",$alg);   $alg = preg_replace("/<317>/","3d2",$alg);   $alg = preg_replace("/<318>/","3d",$alg);
    
    /* T */
    $alg = preg_replace("/<319>/","r'",$alg);   $alg = preg_replace("/<320>/","r2",$alg);   $alg = preg_replace("/<321>/","r",$alg);
    $alg = preg_replace("/<322>/","l'",$alg);   $alg = preg_replace("/<323>/","l2",$alg);   $alg = preg_replace("/<324>/","l",$alg);
    $alg = preg_replace("/<325>/","f'",$alg);   $alg = preg_replace("/<326>/","f2",$alg);   $alg = preg_replace("/<327>/","f",$alg);
    $alg = preg_replace("/<328>/","b'",$alg);   $alg = preg_replace("/<329>/","b2",$alg);   $alg = preg_replace("/<330>/","b",$alg);
    $alg = preg_replace("/<331>/","u'",$alg);   $alg = preg_replace("/<332>/","u2",$alg);   $alg = preg_replace("/<333>/","u",$alg);
    $alg = preg_replace("/<334>/","d'",$alg);   $alg = preg_replace("/<335>/","d2",$alg);   $alg = preg_replace("/<336>/","d",$alg);
    
    /* --- 4xC: CODE -> TWIZZLE: [6] Wide-layer [5] (Mid-layer) twists --- */
    /* W = M2 = V = N2-3 */
    if ($useSiGN == true) { // Bei SiGN:
      $alg = preg_replace("/<501>/","m", $alg);   $alg = preg_replace("/<502>/","m2",$alg);   $alg = preg_replace("/<503>/","m'",$alg);
      $alg = preg_replace("/<504>/","s'",$alg);   $alg = preg_replace("/<505>/","s2",$alg);   $alg = preg_replace("/<506>/","s", $alg);
      $alg = preg_replace("/<507>/","e", $alg);   $alg = preg_replace("/<508>/","e2",$alg);   $alg = preg_replace("/<509>/","e'",$alg);
      
    } else {               // Sonst (TWIZZLE):
      $alg = preg_replace("/<501>/","2-3R'",$alg);   $alg = preg_replace("/<502>/","2-3R2",$alg);   $alg = preg_replace("/<503>/","2-3R",$alg);
      $alg = preg_replace("/<504>/","2-3F'",$alg);   $alg = preg_replace("/<505>/","2-3F2",$alg);   $alg = preg_replace("/<506>/","2-3F",$alg);
      $alg = preg_replace("/<507>/","2-3U'",$alg);   $alg = preg_replace("/<508>/","2-3U2",$alg);   $alg = preg_replace("/<509>/","2-3U",$alg);
    }
    
    /* --- 4xC: CODE -> TWIZZLE: [7] Cube rotations --- */
    /* C */
    if ($useSiGN == true) { // Bei SiGN:
      $alg = preg_replace("/<701>/","x'",$alg);   $alg = preg_replace("/<702>/","x2",$alg);   $alg = preg_replace("/<703>/","x",$alg);
      $alg = preg_replace("/<704>/","z'",$alg);   $alg = preg_replace("/<705>/","z2",$alg);   $alg = preg_replace("/<706>/","z",$alg);
      $alg = preg_replace("/<707>/","y'",$alg);   $alg = preg_replace("/<708>/","y2",$alg);   $alg = preg_replace("/<709>/","y",$alg);
      
    } else {               // Sonst (TWIZZLE):
      $alg = preg_replace("/<701>/","Rv'",$alg);   $alg = preg_replace("/<702>/","Rv2",$alg);   $alg = preg_replace("/<703>/","Rv",$alg);
      $alg = preg_replace("/<704>/","Fv'",$alg);   $alg = preg_replace("/<705>/","Fv2",$alg);   $alg = preg_replace("/<706>/","Fv",$alg);
      $alg = preg_replace("/<707>/","Uv'",$alg);   $alg = preg_replace("/<708>/","Uv2",$alg);   $alg = preg_replace("/<709>/","Uv",$alg);
    }
    
    /* --- 4xC: CODE -> TWIZZLE: [9] Face twists --- */
    /*   */
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
    /* --- 4xC: Preferences --- */
    $optSSE = true;  // Optimize SSE (rebuilds Slice twists).
    
    /* --- 4xC: Marker --- */
    $alg = str_replace(".","·",$alg);
    
    /* ··································································································· */
    /* --- 4xC: TWIZZLE -> CODE: [3] Tier twists (TWIZZLE) --- */
    /* T3 */
    $alg = preg_replace("/1-3R'/","<301>",$alg); $alg = preg_replace("/1-3R2/","<302>",$alg); $alg = preg_replace("/1-3R/","<303>",$alg);
    $alg = preg_replace("/1-3L'/","<304>",$alg); $alg = preg_replace("/1-3L2/","<305>",$alg); $alg = preg_replace("/1-3L/","<306>",$alg);
    $alg = preg_replace("/1-3F'/","<307>",$alg); $alg = preg_replace("/1-3F2/","<308>",$alg); $alg = preg_replace("/1-3F/","<309>",$alg);
    $alg = preg_replace("/1-3B'/","<310>",$alg); $alg = preg_replace("/1-3B2/","<311>",$alg); $alg = preg_replace("/1-3B/","<312>",$alg);
    $alg = preg_replace("/1-3U'/","<313>",$alg); $alg = preg_replace("/1-3U2/","<314>",$alg); $alg = preg_replace("/1-3U/","<315>",$alg);
    $alg = preg_replace("/1-3D'/","<316>",$alg); $alg = preg_replace("/1-3D2/","<317>",$alg); $alg = preg_replace("/1-3D/","<318>",$alg);
    
    
    /* T */
    $alg = preg_replace("/1-2R'/","<319>",$alg); $alg = preg_replace("/1-2R2/","<320>",$alg); $alg = preg_replace("/1-2R/","<321>",$alg);
    $alg = preg_replace("/1-2L'/","<322>",$alg); $alg = preg_replace("/1-2L2/","<323>",$alg); $alg = preg_replace("/1-2L/","<324>",$alg);
    $alg = preg_replace("/1-2F'/","<325>",$alg); $alg = preg_replace("/1-2F2/","<326>",$alg); $alg = preg_replace("/1-2F/","<327>",$alg);
    $alg = preg_replace("/1-2B'/","<328>",$alg); $alg = preg_replace("/1-2B2/","<329>",$alg); $alg = preg_replace("/1-2B/","<330>",$alg);
    $alg = preg_replace("/1-2U'/","<331>",$alg); $alg = preg_replace("/1-2U2/","<332>",$alg); $alg = preg_replace("/1-2U/","<333>",$alg);
    $alg = preg_replace("/1-2D'/","<334>",$alg); $alg = preg_replace("/1-2D2/","<335>",$alg); $alg = preg_replace("/1-2D/","<336>",$alg);
    
    /* --- 4xC: TWIZZLE -> CODE: [2] Slice twists --- */
    if ($optSSE == true) {
      /* S = S2-3 */
      $alg = preg_replace("/2-3L' Rv'/","<201>",$alg); $alg = preg_replace("/2-3L- Rv-/","<201>",$alg);   $alg = preg_replace("/2-3L2 Rv2/","<202>",$alg);   $alg = preg_replace("/2-3L Rv/","<203>",$alg);
      $alg = preg_replace("/2-3R' Lv'/","<203>",$alg); $alg = preg_replace("/2-3R- Lv-/","<203>",$alg);   $alg = preg_replace("/2-3R2 Lv2/","<202>",$alg);   $alg = preg_replace("/2-3R Lv/","<201>",$alg);
      $alg = preg_replace("/2-3B' Fv'/","<204>",$alg); $alg = preg_replace("/2-3B- Fv-/","<204>",$alg);   $alg = preg_replace("/2-3B2 Fv2/","<205>",$alg);   $alg = preg_replace("/2-3B Fv/","<206>",$alg);
      $alg = preg_replace("/2-3F' Bv'/","<206>",$alg); $alg = preg_replace("/2-3F- Bv-/","<206>",$alg);   $alg = preg_replace("/2-3F2 Bv2/","<205>",$alg);   $alg = preg_replace("/2-3F Bv/","<204>",$alg);
      $alg = preg_replace("/2-3D' Uv'/","<207>",$alg); $alg = preg_replace("/2-3D- Uv-/","<207>",$alg);   $alg = preg_replace("/2-3D2 Uv2/","<208>",$alg);   $alg = preg_replace("/2-3D Uv/","<209>",$alg);
      $alg = preg_replace("/2-3U' Dv'/","<209>",$alg); $alg = preg_replace("/2-3U- Dv-/","<209>",$alg);   $alg = preg_replace("/2-3U2 Dv2/","<208>",$alg);   $alg = preg_replace("/2-3U Dv/","<207>",$alg);
      
      $alg = preg_replace("/2-3R Rv'/","<201>",$alg); $alg = preg_replace("/2-3R Rv-/","<201>",$alg);   $alg = preg_replace("/2-3R2 Rv2/","<202>",$alg);   $alg = preg_replace("/2-3R' Rv/","<203>",$alg); $alg = preg_replace("/2-3R- Rv/","<203>",$alg);
      $alg = preg_replace("/2-3L Lv'/","<203>",$alg); $alg = preg_replace("/2-3L Lv-/","<203>",$alg);   $alg = preg_replace("/2-3L2 Lv2/","<202>",$alg);   $alg = preg_replace("/2-3L' Lv/","<201>",$alg); $alg = preg_replace("/2-3L- Lv/","<201>",$alg);
      $alg = preg_replace("/2-3F Fv'/","<204>",$alg); $alg = preg_replace("/2-3F Fv-/","<204>",$alg);   $alg = preg_replace("/2-3F2 Fv2/","<205>",$alg);   $alg = preg_replace("/2-3F' Fv/","<206>",$alg); $alg = preg_replace("/2-3F- Fv/","<206>",$alg);
      $alg = preg_replace("/2-3B Bv'/","<206>",$alg); $alg = preg_replace("/2-3B Bv-/","<206>",$alg);   $alg = preg_replace("/2-3B2 Bv2/","<205>",$alg);   $alg = preg_replace("/2-3B' Bv/","<204>",$alg); $alg = preg_replace("/2-3B- Bv/","<204>",$alg);
      $alg = preg_replace("/2-3U Uv'/","<207>",$alg); $alg = preg_replace("/2-3U Uv-/","<207>",$alg);   $alg = preg_replace("/2-3U2 Uv2/","<208>",$alg);   $alg = preg_replace("/2-3U' Uv/","<209>",$alg); $alg = preg_replace("/2-3U- Uv/","<209>",$alg);
      $alg = preg_replace("/2-3D Dv'/","<209>",$alg); $alg = preg_replace("/2-3D Dv-/","<209>",$alg);   $alg = preg_replace("/2-3D2 Dv2/","<208>",$alg);   $alg = preg_replace("/2-3D' Dv/","<207>",$alg); $alg = preg_replace("/2-3D- Dv/","<207>",$alg);
    }
    
    /* --- 4xC: TWIZZLE -> CODE: [6] Wide layer twists --- */
    /* W */
    $alg = preg_replace("/2-3R'/","<601>",$alg); $alg = preg_replace("/2-3R2/","<602>",$alg); $alg = preg_replace("/2-3R/","<603>",$alg);
    $alg = preg_replace("/2-3L'/","<603>",$alg); $alg = preg_replace("/2-3L2/","<602>",$alg); $alg = preg_replace("/2-3L/","<601>",$alg);
    $alg = preg_replace("/2-3F'/","<604>",$alg); $alg = preg_replace("/2-3F2/","<605>",$alg); $alg = preg_replace("/2-3F/","<606>",$alg);
    $alg = preg_replace("/2-3B'/","<606>",$alg); $alg = preg_replace("/2-3B2/","<605>",$alg); $alg = preg_replace("/2-3B/","<604>",$alg);
    $alg = preg_replace("/2-3U'/","<607>",$alg); $alg = preg_replace("/2-3U2/","<608>",$alg); $alg = preg_replace("/2-3U/","<609>",$alg);
    $alg = preg_replace("/2-3D'/","<609>",$alg); $alg = preg_replace("/2-3D2/","<608>",$alg); $alg = preg_replace("/2-3D/","<607>",$alg);
    
    /* --- 4xC: TWIZZLE -> CODE: [2] Slice twists --- */
    if ($optSSE == true) {
      /* S2-2 | S3-3 */
/* xxx   xxx */
      $alg = preg_replace("/2R Rv'/","<210>",$alg); $alg = preg_replace("/2R Rv-/","<210>",$alg);   $alg = preg_replace("/2R2 Rv2/","<211>",$alg);   $alg = preg_replace("/2R' Rv/","<212>",$alg); $alg = preg_replace("/2R- Rv/","<212>",$alg);
      $alg = preg_replace("/2L Lv'/","<213>",$alg); $alg = preg_replace("/2L Lv-/","<213>",$alg);   $alg = preg_replace("/2L2 Lv2/","<214>",$alg);   $alg = preg_replace("/2L' Lv/","<215>",$alg); $alg = preg_replace("/2L- Lv/","<215>",$alg);
      $alg = preg_replace("/2F Fv'/","<216>",$alg); $alg = preg_replace("/2F Fv-/","<216>",$alg);   $alg = preg_replace("/2F2 Fv2/","<217>",$alg);   $alg = preg_replace("/2F' Fv/","<218>",$alg); $alg = preg_replace("/2F- Fv/","<218>",$alg);
      $alg = preg_replace("/2B Bv'/","<219>",$alg); $alg = preg_replace("/2B Bv-/","<219>",$alg);   $alg = preg_replace("/2B2 Bv2/","<220>",$alg);   $alg = preg_replace("/2B' Bv/","<221>",$alg); $alg = preg_replace("/2B- Bv/","<221>",$alg);
      $alg = preg_replace("/2U Uv'/","<222>",$alg); $alg = preg_replace("/2U Uv-/","<222>",$alg);   $alg = preg_replace("/2U2 Uv2/","<223>",$alg);   $alg = preg_replace("/2U' Uv/","<224>",$alg); $alg = preg_replace("/2U- Uv/","<224>",$alg);
      $alg = preg_replace("/2D Dv'/","<225>",$alg); $alg = preg_replace("/2D Dv-/","<225>",$alg);   $alg = preg_replace("/2D2 Dv2/","<226>",$alg);   $alg = preg_replace("/2D' Dv/","<227>",$alg); $alg = preg_replace("/2D- Dv/","<227>",$alg);
      
      $alg = preg_replace("/3L' Rv'/","<210>",$alg); $alg = preg_replace("/3L- Rv-/","<210>",$alg);   $alg = preg_replace("/3L2 Rv2/","<211>",$alg);   $alg = preg_replace("/3L Rv/","<212>",$alg);
      $alg = preg_replace("/3R' Lv'/","<213>",$alg); $alg = preg_replace("/3R- Lv-/","<213>",$alg);   $alg = preg_replace("/3R2 Lv2/","<214>",$alg);   $alg = preg_replace("/3R Lv/","<215>",$alg);
      $alg = preg_replace("/3B' Fv'/","<216>",$alg); $alg = preg_replace("/3B- Fv-/","<216>",$alg);   $alg = preg_replace("/3B2 Fv2/","<217>",$alg);   $alg = preg_replace("/3B Fv/","<218>",$alg);
      $alg = preg_replace("/3F' Bv'/","<219>",$alg); $alg = preg_replace("/3F- Bv-/","<219>",$alg);   $alg = preg_replace("/3F2 Bv2/","<220>",$alg);   $alg = preg_replace("/3F Bv/","<221>",$alg);
      $alg = preg_replace("/3D' Uv'/","<222>",$alg); $alg = preg_replace("/3D- Uv-/","<222>",$alg);   $alg = preg_replace("/3D2 Uv2/","<223>",$alg);   $alg = preg_replace("/3D Uv/","<224>",$alg);
      $alg = preg_replace("/3U' Dv'/","<225>",$alg); $alg = preg_replace("/3U- Dv-/","<225>",$alg);   $alg = preg_replace("/3U2 Dv2/","<226>",$alg);   $alg = preg_replace("/3U Dv/","<227>",$alg);
    }
    
    /* --- 4xC: TWIZZLE -> CODE: [3] Tier twists (WCA) --- */
    /* T3 */
    $alg = preg_replace("/3Rw'/","<301>",$alg); $alg = preg_replace("/3Rw2/","<302>",$alg); $alg = preg_replace("/3Rw/","<303>",$alg);
    $alg = preg_replace("/3Lw'/","<304>",$alg); $alg = preg_replace("/3Lw2/","<305>",$alg); $alg = preg_replace("/3Lw/","<306>",$alg);
    $alg = preg_replace("/3Fw'/","<307>",$alg); $alg = preg_replace("/3Fw2/","<308>",$alg); $alg = preg_replace("/3Fw/","<309>",$alg);
    $alg = preg_replace("/3Bw'/","<310>",$alg); $alg = preg_replace("/3Bw2/","<311>",$alg); $alg = preg_replace("/3Bw/","<312>",$alg);
    $alg = preg_replace("/3Uw'/","<313>",$alg); $alg = preg_replace("/3Uw2/","<314>",$alg); $alg = preg_replace("/3Uw/","<315>",$alg);
    $alg = preg_replace("/3Dw'/","<316>",$alg); $alg = preg_replace("/3Dw2/","<317>",$alg); $alg = preg_replace("/3Dw/","<318>",$alg);
    
    /* --- 4xC: TWIZZLE -> CODE: [1] Numbered layer twists --- */
    /* M = N | N3 */
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
    
    /* --- 4xC: TWIZZLE -> CODE: [9] Face twists --- */
    /*   */
    $alg = preg_replace("/1R'/","<901>",$alg); $alg = preg_replace("/1R2/","<902>",$alg); $alg = preg_replace("/1R/","<903>",$alg);
    $alg = preg_replace("/1L'/","<904>",$alg); $alg = preg_replace("/1L2/","<905>",$alg); $alg = preg_replace("/1L/","<906>",$alg);
    $alg = preg_replace("/1F'/","<907>",$alg); $alg = preg_replace("/1F2/","<908>",$alg); $alg = preg_replace("/1F/","<909>",$alg);
    $alg = preg_replace("/1B'/","<910>",$alg); $alg = preg_replace("/1B2/","<911>",$alg); $alg = preg_replace("/1B/","<912>",$alg);
    $alg = preg_replace("/1U'/","<913>",$alg); $alg = preg_replace("/1U2/","<914>",$alg); $alg = preg_replace("/1U/","<915>",$alg);
    $alg = preg_replace("/1D'/","<916>",$alg); $alg = preg_replace("/1D2/","<917>",$alg); $alg = preg_replace("/1D/","<918>",$alg);
    
    $alg = preg_replace("/4R'/","<906>",$alg); $alg = preg_replace("/4R2/","<905>",$alg); $alg = preg_replace("/4R/","<904>",$alg);
    $alg = preg_replace("/4L'/","<903>",$alg); $alg = preg_replace("/4L2/","<902>",$alg); $alg = preg_replace("/4L/","<901>",$alg);
    $alg = preg_replace("/4F'/","<912>",$alg); $alg = preg_replace("/4F2/","<911>",$alg); $alg = preg_replace("/4F/","<910>",$alg);
    $alg = preg_replace("/4B'/","<909>",$alg); $alg = preg_replace("/4B2/","<908>",$alg); $alg = preg_replace("/4B/","<907>",$alg);
    $alg = preg_replace("/4U'/","<918>",$alg); $alg = preg_replace("/4U2/","<917>",$alg); $alg = preg_replace("/4U/","<916>",$alg);
    $alg = preg_replace("/4D'/","<915>",$alg); $alg = preg_replace("/4D2/","<914>",$alg); $alg = preg_replace("/4D/","<913>",$alg);
    
    /* --- 4xC: TWIZZLE -> CODE: [3] Tier twists (SiGN) --- */
    /* T3 */
    $alg = preg_replace("/3r'/","<301>",$alg); $alg = preg_replace("/3r2/","<302>",$alg); $alg = preg_replace("/3r/","<303>",$alg);
    $alg = preg_replace("/3l'/","<304>",$alg); $alg = preg_replace("/3l2/","<305>",$alg); $alg = preg_replace("/3l/","<306>",$alg);
    $alg = preg_replace("/3f'/","<307>",$alg); $alg = preg_replace("/3f2/","<308>",$alg); $alg = preg_replace("/3f/","<309>",$alg);
    $alg = preg_replace("/3b'/","<310>",$alg); $alg = preg_replace("/3b2/","<311>",$alg); $alg = preg_replace("/3b/","<312>",$alg);
    $alg = preg_replace("/3u'/","<313>",$alg); $alg = preg_replace("/3u2/","<314>",$alg); $alg = preg_replace("/3u/","<315>",$alg);
    $alg = preg_replace("/3d'/","<316>",$alg); $alg = preg_replace("/3d2/","<317>",$alg); $alg = preg_replace("/3d/","<318>",$alg);
    
    /* --- 4xC: TWIZZLE -> CODE: [2] Slice twists --- */
    if ($optSSE == true) {
      /* S = S2-3 */
      $alg = preg_replace("/m' Rv'/","<201>",$alg); $alg = preg_replace("/m- Rv-/","<201>",$alg);   $alg = preg_replace("/m2 Rv2/","<202>",$alg);   $alg = preg_replace("/m Rv/", "<203>",$alg);
      $alg = preg_replace("/m Lv'/", "<203>",$alg); $alg = preg_replace("/m Lv-/", "<203>",$alg);   $alg = preg_replace("/m2 Lv2/","<202>",$alg);   $alg = preg_replace("/m' Lv/","<201>",$alg); $alg = preg_replace("/m- Lv/","<201>",$alg);
      $alg = preg_replace("/s Fv'/", "<204>",$alg); $alg = preg_replace("/s Fv-/", "<204>",$alg);   $alg = preg_replace("/s2 Fv2/","<205>",$alg);   $alg = preg_replace("/s' Fv/","<206>",$alg); $alg = preg_replace("/s- Fv/","<206>",$alg);
      $alg = preg_replace("/s' Bv'/","<206>",$alg); $alg = preg_replace("/s- Bv-/","<206>",$alg);   $alg = preg_replace("/s2 Bv2/","<205>",$alg);   $alg = preg_replace("/s Bv/", "<204>",$alg);
      $alg = preg_replace("/e' Uv'/","<207>",$alg); $alg = preg_replace("/e- Uv-/","<207>",$alg);   $alg = preg_replace("/e2 Uv2/","<208>",$alg);   $alg = preg_replace("/e Uv/", "<209>",$alg);
      $alg = preg_replace("/e Dv'/", "<209>",$alg); $alg = preg_replace("/e Dv-/", "<209>",$alg);   $alg = preg_replace("/e2 Dv2/","<208>",$alg);   $alg = preg_replace("/e' Dv/","<207>",$alg); $alg = preg_replace("/e' Dv/","<207>",$alg);
      
      /* Non-slice-twists */
      $alg = preg_replace("/R' L'/","<228>",$alg);
      $alg = preg_replace("/L' R'/","<228>",$alg);
      $alg = preg_replace("/F' B'/","<229>",$alg);
      $alg = preg_replace("/B' F'/","<229>",$alg);
      $alg = preg_replace("/U' D'/","<230>",$alg);
      $alg = preg_replace("/D' U'/","<230>",$alg);
      
      /* S = S2-3 */
      $alg = preg_replace("/R L'/","<203>",$alg); $alg = preg_replace("/R L-/","<203>",$alg);   $alg = preg_replace("/R2 L2/","<202>",$alg);   $alg = preg_replace("/R' L/","<201>",$alg); $alg = preg_replace("/R- L/","<201>",$alg);
      $alg = preg_replace("/L R'/","<201>",$alg); $alg = preg_replace("/L R-/","<201>",$alg);   $alg = preg_replace("/L2 R2/","<202>",$alg);   $alg = preg_replace("/L' R/","<203>",$alg); $alg = preg_replace("/L- R/","<203>",$alg);
      $alg = preg_replace("/F B'/","<206>",$alg); $alg = preg_replace("/F B-/","<206>",$alg);   $alg = preg_replace("/F2 B2/","<205>",$alg);   $alg = preg_replace("/F' B/","<204>",$alg); $alg = preg_replace("/F- B/","<204>",$alg);
      $alg = preg_replace("/B F'/","<204>",$alg); $alg = preg_replace("/B F-/","<204>",$alg);   $alg = preg_replace("/B2 F2/","<205>",$alg);   $alg = preg_replace("/B' F/","<206>",$alg); $alg = preg_replace("/B- F/","<206>",$alg);
      $alg = preg_replace("/U D'/","<209>",$alg); $alg = preg_replace("/U D-/","<209>",$alg);   $alg = preg_replace("/U2 D2/","<208>",$alg);   $alg = preg_replace("/U' D/","<207>",$alg); $alg = preg_replace("/U- D/","<207>",$alg);
      $alg = preg_replace("/D U'/","<207>",$alg); $alg = preg_replace("/D U-/","<207>",$alg);   $alg = preg_replace("/D2 U2/","<208>",$alg);   $alg = preg_replace("/D' U/","<209>",$alg); $alg = preg_replace("/D- U/","<209>",$alg);
      
      /* S2-2 | S3-3 */
/* xxx   xxx */
      $alg = preg_replace("/R l'/","<212>",$alg); $alg = preg_replace("/R l-/","<212>",$alg);   $alg = preg_replace("/R2 l2/","<211>",$alg);   $alg = preg_replace("/R' l/","<210>",$alg); $alg = preg_replace("/R- l/","<210>",$alg);
      $alg = preg_replace("/L r'/","<215>",$alg); $alg = preg_replace("/L r-/","<215>",$alg);   $alg = preg_replace("/L2 r2/","<214>",$alg);   $alg = preg_replace("/L' r/","<213>",$alg); $alg = preg_replace("/L- r/","<213>",$alg);
      $alg = preg_replace("/F b'/","<218>",$alg); $alg = preg_replace("/F b-/","<218>",$alg);   $alg = preg_replace("/F2 b2/","<217>",$alg);   $alg = preg_replace("/F' b/","<216>",$alg); $alg = preg_replace("/F- b/","<216>",$alg);
      $alg = preg_replace("/B f'/","<221>",$alg); $alg = preg_replace("/B f-/","<221>",$alg);   $alg = preg_replace("/B2 f2/","<220>",$alg);   $alg = preg_replace("/B' f/","<219>",$alg); $alg = preg_replace("/B- f/","<219>",$alg);
      $alg = preg_replace("/U d'/","<224>",$alg); $alg = preg_replace("/U d-/","<224>",$alg);   $alg = preg_replace("/U2 d2/","<223>",$alg);   $alg = preg_replace("/U' d/","<222>",$alg); $alg = preg_replace("/U- d/","<222>",$alg);
      $alg = preg_replace("/D u'/","<227>",$alg); $alg = preg_replace("/D u-/","<227>",$alg);   $alg = preg_replace("/D2 u2/","<226>",$alg);   $alg = preg_replace("/D' u/","<225>",$alg); $alg = preg_replace("/D- u/","<225>",$alg);
      
      $alg = preg_replace("/r L'/","<213>",$alg); $alg = preg_replace("/r L-/","<213>",$alg);   $alg = preg_replace("/r2 L2/","<214>",$alg);   $alg = preg_replace("/r' L/","<215>",$alg); $alg = preg_replace("/r- L/","<215>",$alg);
      $alg = preg_replace("/l R'/","<210>",$alg); $alg = preg_replace("/l R-/","<210>",$alg);   $alg = preg_replace("/l2 R2/","<211>",$alg);   $alg = preg_replace("/l' R/","<212>",$alg); $alg = preg_replace("/l- R/","<212>",$alg);
      $alg = preg_replace("/f B'/","<219>",$alg); $alg = preg_replace("/f B-/","<219>",$alg);   $alg = preg_replace("/f2 B2/","<220>",$alg);   $alg = preg_replace("/f' B/","<221>",$alg); $alg = preg_replace("/f- B/","<221>",$alg);
      $alg = preg_replace("/b F'/","<216>",$alg); $alg = preg_replace("/b F-/","<216>",$alg);   $alg = preg_replace("/b2 F2/","<217>",$alg);   $alg = preg_replace("/b' F/","<218>",$alg); $alg = preg_replace("/b- F/","<218>",$alg);
      $alg = preg_replace("/u D'/","<225>",$alg); $alg = preg_replace("/u D-/","<225>",$alg);   $alg = preg_replace("/u2 D2/","<226>",$alg);   $alg = preg_replace("/u' D/","<227>",$alg); $alg = preg_replace("/u- D/","<227>",$alg);
      $alg = preg_replace("/d U'/","<222>",$alg); $alg = preg_replace("/d U-/","<222>",$alg);   $alg = preg_replace("/d2 U2/","<223>",$alg);   $alg = preg_replace("/d' U/","<224>",$alg); $alg = preg_replace("/d- U/","<224>",$alg);
    }
    
    /* --- 4xC: TWIZZLE -> CODE: [3] Tier twists (WCA) --- */
    /* T */
    $alg = preg_replace("/Rw'/","<319>",$alg); $alg = preg_replace("/Rw2/","<320>",$alg); $alg = preg_replace("/Rw/","<321>",$alg);
    $alg = preg_replace("/Lw'/","<322>",$alg); $alg = preg_replace("/Lw2/","<323>",$alg); $alg = preg_replace("/Lw/","<324>",$alg);
    $alg = preg_replace("/Fw'/","<325>",$alg); $alg = preg_replace("/Fw2/","<326>",$alg); $alg = preg_replace("/Fw/","<327>",$alg);
    $alg = preg_replace("/Bw'/","<328>",$alg); $alg = preg_replace("/Bw2/","<329>",$alg); $alg = preg_replace("/Bw/","<330>",$alg);
    $alg = preg_replace("/Uw'/","<331>",$alg); $alg = preg_replace("/Uw2/","<332>",$alg); $alg = preg_replace("/Uw/","<333>",$alg);
    $alg = preg_replace("/Dw'/","<334>",$alg); $alg = preg_replace("/Dw2/","<335>",$alg); $alg = preg_replace("/Dw/","<336>",$alg);
    
    /* --- 4xC: TWIZZLE -> CODE: [7] Cube rotations --- */
    /* C */
    $alg = preg_replace("/Rv'/","<701>",$alg); $alg = preg_replace("/Rv2/","<702>",$alg); $alg = preg_replace("/Rv/","<703>",$alg);
    $alg = preg_replace("/Lv'/","<703>",$alg); $alg = preg_replace("/Lv2/","<702>",$alg); $alg = preg_replace("/Lv/","<701>",$alg);
    $alg = preg_replace("/Fv'/","<704>",$alg); $alg = preg_replace("/Fv2/","<705>",$alg); $alg = preg_replace("/Fv/","<706>",$alg);
    $alg = preg_replace("/Bv'/","<706>",$alg); $alg = preg_replace("/Bv2/","<705>",$alg); $alg = preg_replace("/Bv/","<704>",$alg);
    $alg = preg_replace("/Uv'/","<707>",$alg); $alg = preg_replace("/Uv2/","<708>",$alg); $alg = preg_replace("/Uv/","<709>",$alg);
    $alg = preg_replace("/Dv'/","<709>",$alg); $alg = preg_replace("/Dv2/","<708>",$alg); $alg = preg_replace("/Dv/","<707>",$alg);
    
    $alg = preg_replace("/x'/","<701>",$alg); $alg = preg_replace("/x2/","<702>",$alg); $alg = preg_replace("/x/","<703>",$alg);
    $alg = preg_replace("/z'/","<704>",$alg); $alg = preg_replace("/z2/","<705>",$alg); $alg = preg_replace("/z/","<706>",$alg);
    $alg = preg_replace("/y'/","<707>",$alg); $alg = preg_replace("/y2/","<708>",$alg); $alg = preg_replace("/y/","<709>",$alg);
    
    /* --- 4xC: TWIZZLE -> CODE: [6] Wide layer twists --- */
    /* W */
    $alg = preg_replace("/m'/","<603>",$alg); $alg = preg_replace("/m2/","<602>",$alg); $alg = preg_replace("/m/","<601>",$alg);
    $alg = preg_replace("/s'/","<604>",$alg); $alg = preg_replace("/s2/","<605>",$alg); $alg = preg_replace("/s/","<606>",$alg);
    $alg = preg_replace("/e'/","<609>",$alg); $alg = preg_replace("/e2/","<608>",$alg); $alg = preg_replace("/e/","<607>",$alg);
    
    /* --- 4xC: TWIZZLE -> CODE: [9] Face twists --- */
    /*   */
    $alg = preg_replace("/R'/","<901>",$alg); $alg = preg_replace("/R2/","<902>",$alg); $alg = preg_replace("/R/","<903>",$alg);
    $alg = preg_replace("/L'/","<904>",$alg); $alg = preg_replace("/L2/","<905>",$alg); $alg = preg_replace("/L/","<906>",$alg);
    $alg = preg_replace("/F'/","<907>",$alg); $alg = preg_replace("/F2/","<908>",$alg); $alg = preg_replace("/F/","<909>",$alg);
    $alg = preg_replace("/B'/","<910>",$alg); $alg = preg_replace("/B2/","<911>",$alg); $alg = preg_replace("/B/","<912>",$alg);
    $alg = preg_replace("/U'/","<913>",$alg); $alg = preg_replace("/U2/","<914>",$alg); $alg = preg_replace("/U/","<915>",$alg);
    $alg = preg_replace("/D'/","<916>",$alg); $alg = preg_replace("/D2/","<917>",$alg); $alg = preg_replace("/D/","<918>",$alg);
    
    /* --- 4xC: TWIZZLE -> CODE: [3] Tier twists (SiGN) --- */
    /* T */
    $alg = preg_replace("/r'/","<319>",$alg); $alg = preg_replace("/r2/","<320>",$alg); $alg = preg_replace("/r/","<321>",$alg);
    $alg = preg_replace("/l'/","<322>",$alg); $alg = preg_replace("/l2/","<323>",$alg); $alg = preg_replace("/l/","<324>",$alg);
    $alg = preg_replace("/f'/","<325>",$alg); $alg = preg_replace("/f2/","<326>",$alg); $alg = preg_replace("/f/","<327>",$alg);
    $alg = preg_replace("/b'/","<328>",$alg); $alg = preg_replace("/b2/","<329>",$alg); $alg = preg_replace("/b/","<330>",$alg);
    $alg = preg_replace("/u'/","<331>",$alg); $alg = preg_replace("/u2/","<332>",$alg); $alg = preg_replace("/u/","<333>",$alg);
    $alg = preg_replace("/d'/","<334>",$alg); $alg = preg_replace("/d2/","<335>",$alg); $alg = preg_replace("/d/","<336>",$alg);
    
    /* ··································································································· */
    /* --- 4xC: CODE -> SSE opt: [2] Slice twists --- */
    if ($optSSE == true) {
      /* Non-slice-twists */
      $alg = preg_replace("/<228>/","R' L'",$alg);
      $alg = preg_replace("/<229>/","F' B'",$alg);
      $alg = preg_replace("/<230>/","U' D'",$alg);
      
      /* S = S2-3 */
      $alg = preg_replace("/<201>/","SR'",$alg); $alg = preg_replace("/<202>/","SR2",$alg); $alg = preg_replace("/<203>/","SR",$alg);
      $alg = preg_replace("/<204>/","SF'",$alg); $alg = preg_replace("/<205>/","SF2",$alg); $alg = preg_replace("/<206>/","SF",$alg);
      $alg = preg_replace("/<207>/","SU'",$alg); $alg = preg_replace("/<208>/","SU2",$alg); $alg = preg_replace("/<209>/","SU",$alg);
      
      /* S2-2 | S3-3 */
/* xxx   xxx */
      $alg = preg_replace("/<210>/","S2-2R'",$alg); $alg = preg_replace("/<211>/","S2-2R2",$alg); $alg = preg_replace("/<212>/","S2-2R",$alg);
      $alg = preg_replace("/<213>/","S2-2L'",$alg); $alg = preg_replace("/<214>/","S2-2L2",$alg); $alg = preg_replace("/<215>/","S2-2L",$alg);
      $alg = preg_replace("/<216>/","S2-2F'",$alg); $alg = preg_replace("/<217>/","S2-2F2",$alg); $alg = preg_replace("/<218>/","S2-2F",$alg);
      $alg = preg_replace("/<219>/","S2-2B'",$alg); $alg = preg_replace("/<220>/","S2-2B2",$alg); $alg = preg_replace("/<221>/","S2-2B",$alg);
      $alg = preg_replace("/<222>/","S2-2U'",$alg); $alg = preg_replace("/<223>/","S2-2U2",$alg); $alg = preg_replace("/<224>/","S2-2U",$alg);
      $alg = preg_replace("/<225>/","S2-2D'",$alg); $alg = preg_replace("/<226>/","S2-2D2",$alg); $alg = preg_replace("/<227>/","S2-2D",$alg);
    }
    
    /* --- 4xC: CODE -> SSE: [6] Wide layer twists --- */
    /* W */
    $alg = preg_replace("/<601>/","WR'",$alg); $alg = preg_replace("/<602>/","WR2",$alg); $alg = preg_replace("/<603>/","WR",$alg);
    $alg = preg_replace("/<604>/","WF'",$alg); $alg = preg_replace("/<605>/","WF2",$alg); $alg = preg_replace("/<606>/","WF",$alg);
    $alg = preg_replace("/<607>/","WU'",$alg); $alg = preg_replace("/<608>/","WU2",$alg); $alg = preg_replace("/<609>/","WU",$alg);
    
    /* --- 4xC: CODE -> SSE: [1] Numbered layer twists --- */
    /* M = N | N3 */
    $alg = preg_replace("/<101>/","MR'",$alg); $alg = preg_replace("/<102>/","MR2",$alg); $alg = preg_replace("/<103>/","MR",$alg);
    $alg = preg_replace("/<104>/","ML'",$alg); $alg = preg_replace("/<105>/","ML2",$alg); $alg = preg_replace("/<106>/","ML",$alg);
    $alg = preg_replace("/<107>/","MF'",$alg); $alg = preg_replace("/<108>/","MF2",$alg); $alg = preg_replace("/<109>/","MF",$alg);
    $alg = preg_replace("/<110>/","MB'",$alg); $alg = preg_replace("/<111>/","MB2",$alg); $alg = preg_replace("/<112>/","MB",$alg);
    $alg = preg_replace("/<113>/","MU'",$alg); $alg = preg_replace("/<114>/","MU2",$alg); $alg = preg_replace("/<115>/","MU",$alg);
    $alg = preg_replace("/<116>/","MD'",$alg); $alg = preg_replace("/<117>/","MD2",$alg); $alg = preg_replace("/<118>/","MD",$alg);
    
    /* --- 4xC: CODE -> SSE: [3] Tier twists --- */
    /* T3 */
    $alg = preg_replace("/<301>/","T3R'",$alg); $alg = preg_replace("/<302>/","T3R2",$alg); $alg = preg_replace("/<303>/","T3R",$alg);
    $alg = preg_replace("/<304>/","T3L'",$alg); $alg = preg_replace("/<305>/","T3L2",$alg); $alg = preg_replace("/<306>/","T3L",$alg);
    $alg = preg_replace("/<307>/","T3F'",$alg); $alg = preg_replace("/<308>/","T3F2",$alg); $alg = preg_replace("/<309>/","T3F",$alg);
    $alg = preg_replace("/<310>/","T3B'",$alg); $alg = preg_replace("/<311>/","T3B2",$alg); $alg = preg_replace("/<312>/","T3B",$alg);
    $alg = preg_replace("/<313>/","T3U'",$alg); $alg = preg_replace("/<314>/","T3U2",$alg); $alg = preg_replace("/<315>/","T3U",$alg);
    $alg = preg_replace("/<316>/","T3D'",$alg); $alg = preg_replace("/<317>/","T3D2",$alg); $alg = preg_replace("/<318>/","T3D",$alg);
    
    /* T */
    $alg = preg_replace("/<319>/","TR'",$alg); $alg = preg_replace("/<320>/","TR2",$alg); $alg = preg_replace("/<321>/","TR",$alg);
    $alg = preg_replace("/<322>/","TL'",$alg); $alg = preg_replace("/<323>/","TL2",$alg); $alg = preg_replace("/<324>/","TL",$alg);
    $alg = preg_replace("/<325>/","TF'",$alg); $alg = preg_replace("/<326>/","TF2",$alg); $alg = preg_replace("/<327>/","TF",$alg);
    $alg = preg_replace("/<328>/","TB'",$alg); $alg = preg_replace("/<329>/","TB2",$alg); $alg = preg_replace("/<330>/","TB",$alg);
    $alg = preg_replace("/<331>/","TU'",$alg); $alg = preg_replace("/<332>/","TU2",$alg); $alg = preg_replace("/<333>/","TU",$alg);
    $alg = preg_replace("/<334>/","TD'",$alg); $alg = preg_replace("/<335>/","TD2",$alg); $alg = preg_replace("/<336>/","TD",$alg);
    
    /* --- 4xC: CODE -> SSE: [7] Cube rotations --- */
    /* C */
    $alg = preg_replace("/<701>/","CR'",$alg); $alg = preg_replace("/<702>/","CR2",$alg); $alg = preg_replace("/<703>/","CR",$alg);
    $alg = preg_replace("/<704>/","CF'",$alg); $alg = preg_replace("/<705>/","CF2",$alg); $alg = preg_replace("/<706>/","CF",$alg);
    $alg = preg_replace("/<707>/","CU'",$alg); $alg = preg_replace("/<708>/","CU2",$alg); $alg = preg_replace("/<709>/","CU",$alg);
    
    /* --- 4xC: CODE -> SSE: [9] Face twists --- */
    /*   */
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
    /* --- 5xC: SSE -> CODE: [1] Numbered-layer [5] Mid-layer twists --- */
    /* N | N4 */
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
    
    
    /* N3 = M */
    $alg = preg_replace("/N3R'/","<119>",$alg); $alg = preg_replace("/N3R-/","<119>",$alg);   $alg = preg_replace("/N3R2/","<120>",$alg);   $alg = preg_replace("/N3R/","<121>",$alg);
    $alg = preg_replace("/N3L'/","<121>",$alg); $alg = preg_replace("/N3L-/","<121>",$alg);   $alg = preg_replace("/N3L2/","<120>",$alg);   $alg = preg_replace("/N3L/","<119>",$alg);
    $alg = preg_replace("/N3F'/","<122>",$alg); $alg = preg_replace("/N3F-/","<122>",$alg);   $alg = preg_replace("/N3F2/","<123>",$alg);   $alg = preg_replace("/N3F/","<124>",$alg);
    $alg = preg_replace("/N3B'/","<124>",$alg); $alg = preg_replace("/N3B-/","<124>",$alg);   $alg = preg_replace("/N3B2/","<123>",$alg);   $alg = preg_replace("/N3B/","<122>",$alg);
    $alg = preg_replace("/N3U'/","<125>",$alg); $alg = preg_replace("/N3U-/","<125>",$alg);   $alg = preg_replace("/N3U2/","<126>",$alg);   $alg = preg_replace("/N3U/","<127>",$alg);
    $alg = preg_replace("/N3D'/","<127>",$alg); $alg = preg_replace("/N3D-/","<127>",$alg);   $alg = preg_replace("/N3D2/","<126>",$alg);   $alg = preg_replace("/N3D/","<125>",$alg);
    
    $alg = preg_replace("/MR'/","<119>",$alg); $alg = preg_replace("/MR-/","<119>",$alg);   $alg = preg_replace("/MR2/","<120>",$alg);   $alg = preg_replace("/MR/","<121>",$alg);
    $alg = preg_replace("/ML'/","<121>",$alg); $alg = preg_replace("/ML-/","<121>",$alg);   $alg = preg_replace("/ML2/","<120>",$alg);   $alg = preg_replace("/ML/","<119>",$alg);
    $alg = preg_replace("/MF'/","<122>",$alg); $alg = preg_replace("/MF-/","<122>",$alg);   $alg = preg_replace("/MF2/","<123>",$alg);   $alg = preg_replace("/MF/","<124>",$alg);
    $alg = preg_replace("/MB'/","<124>",$alg); $alg = preg_replace("/MB-/","<124>",$alg);   $alg = preg_replace("/MB2/","<123>",$alg);   $alg = preg_replace("/MB/","<122>",$alg);
    $alg = preg_replace("/MU'/","<125>",$alg); $alg = preg_replace("/MU-/","<125>",$alg);   $alg = preg_replace("/MU2/","<126>",$alg);   $alg = preg_replace("/MU/","<127>",$alg);
    $alg = preg_replace("/MD'/","<127>",$alg); $alg = preg_replace("/MD-/","<127>",$alg);   $alg = preg_replace("/MD2/","<126>",$alg);   $alg = preg_replace("/MD/","<125>",$alg);
    
    /* --- 5xC: SSE -> CODE: [2] Slice twists --- */
    /* S2 = S3-3 */
    $alg = preg_replace("/S2R'/","<201>",$alg); $alg = preg_replace("/S2R-/","<201>",$alg);   $alg = preg_replace("/S2R2/","<202>",$alg);   $alg = preg_replace("/S2R/","<203>",$alg);
    $alg = preg_replace("/S2L'/","<203>",$alg); $alg = preg_replace("/S2L-/","<203>",$alg);   $alg = preg_replace("/S2L2/","<202>",$alg);   $alg = preg_replace("/S2L/","<201>",$alg);
    $alg = preg_replace("/S2F'/","<204>",$alg); $alg = preg_replace("/S2F-/","<204>",$alg);   $alg = preg_replace("/S2F2/","<205>",$alg);   $alg = preg_replace("/S2F/","<206>",$alg);
    $alg = preg_replace("/S2B'/","<206>",$alg); $alg = preg_replace("/S2B-/","<206>",$alg);   $alg = preg_replace("/S2B2/","<205>",$alg);   $alg = preg_replace("/S2B/","<204>",$alg);
    $alg = preg_replace("/S2U'/","<207>",$alg); $alg = preg_replace("/S2U-/","<207>",$alg);   $alg = preg_replace("/S2U2/","<208>",$alg);   $alg = preg_replace("/S2U/","<209>",$alg);
    $alg = preg_replace("/S2D'/","<209>",$alg); $alg = preg_replace("/S2D-/","<209>",$alg);   $alg = preg_replace("/S2D2/","<208>",$alg);   $alg = preg_replace("/S2D/","<207>",$alg);
    
    $alg = preg_replace("/S3-3R'/","<201>",$alg); $alg = preg_replace("/S3-3R-/","<201>",$alg);   $alg = preg_replace("/S3-3R2/","<202>",$alg);   $alg = preg_replace("/S3-3R/","<203>",$alg);
    $alg = preg_replace("/S3-3L'/","<203>",$alg); $alg = preg_replace("/S3-3L-/","<203>",$alg);   $alg = preg_replace("/S3-3L2/","<202>",$alg);   $alg = preg_replace("/S3-3L/","<201>",$alg);
    $alg = preg_replace("/S3-3F'/","<204>",$alg); $alg = preg_replace("/S3-3F-/","<204>",$alg);   $alg = preg_replace("/S3-3F2/","<205>",$alg);   $alg = preg_replace("/S3-3F/","<206>",$alg);
    $alg = preg_replace("/S3-3B'/","<206>",$alg); $alg = preg_replace("/S3-3B-/","<206>",$alg);   $alg = preg_replace("/S3-3B2/","<205>",$alg);   $alg = preg_replace("/S3-3B/","<204>",$alg);
    $alg = preg_replace("/S3-3U'/","<207>",$alg); $alg = preg_replace("/S3-3U-/","<207>",$alg);   $alg = preg_replace("/S3-3U2/","<208>",$alg);   $alg = preg_replace("/S3-3U/","<209>",$alg);
    $alg = preg_replace("/S3-3D'/","<209>",$alg); $alg = preg_replace("/S3-3D-/","<209>",$alg);   $alg = preg_replace("/S3-3D2/","<208>",$alg);   $alg = preg_replace("/S3-3D/","<207>",$alg);
    
    
    /* S = S2-4 */
    $alg = preg_replace("/SR'/","<210>",$alg); $alg = preg_replace("/SR-/","<210>",$alg);   $alg = preg_replace("/SR2/","<211>",$alg);   $alg = preg_replace("/SR/","<212>",$alg);
    $alg = preg_replace("/SL'/","<212>",$alg); $alg = preg_replace("/SL-/","<212>",$alg);   $alg = preg_replace("/SL2/","<211>",$alg);   $alg = preg_replace("/SL/","<210>",$alg);
    $alg = preg_replace("/SF'/","<213>",$alg); $alg = preg_replace("/SF-/","<213>",$alg);   $alg = preg_replace("/SF2/","<214>",$alg);   $alg = preg_replace("/SF/","<215>",$alg);
    $alg = preg_replace("/SB'/","<215>",$alg); $alg = preg_replace("/SB-/","<215>",$alg);   $alg = preg_replace("/SB2/","<214>",$alg);   $alg = preg_replace("/SB/","<213>",$alg);
    $alg = preg_replace("/SU'/","<216>",$alg); $alg = preg_replace("/SU-/","<216>",$alg);   $alg = preg_replace("/SU2/","<217>",$alg);   $alg = preg_replace("/SU/","<218>",$alg);
    $alg = preg_replace("/SD'/","<218>",$alg); $alg = preg_replace("/SD-/","<218>",$alg);   $alg = preg_replace("/SD2/","<217>",$alg);   $alg = preg_replace("/SD/","<216>",$alg);
    
    $alg = preg_replace("/S2-4R'/","<210>",$alg); $alg = preg_replace("/S2-4R-/","<210>",$alg);   $alg = preg_replace("/S2-4R2/","<211>",$alg);   $alg = preg_replace("/S2-4R/","<212>",$alg);
    $alg = preg_replace("/S2-4L'/","<212>",$alg); $alg = preg_replace("/S2-4L-/","<212>",$alg);   $alg = preg_replace("/S2-4L2/","<211>",$alg);   $alg = preg_replace("/S2-4L/","<210>",$alg);
    $alg = preg_replace("/S2-4F'/","<213>",$alg); $alg = preg_replace("/S2-4F-/","<213>",$alg);   $alg = preg_replace("/S2-4F2/","<214>",$alg);   $alg = preg_replace("/S2-4F/","<215>",$alg);
    $alg = preg_replace("/S2-4B'/","<215>",$alg); $alg = preg_replace("/S2-4B-/","<215>",$alg);   $alg = preg_replace("/S2-4B2/","<214>",$alg);   $alg = preg_replace("/S2-4B/","<213>",$alg);
    $alg = preg_replace("/S2-4U'/","<216>",$alg); $alg = preg_replace("/S2-4U-/","<216>",$alg);   $alg = preg_replace("/S2-4U2/","<217>",$alg);   $alg = preg_replace("/S2-4U/","<218>",$alg);
    $alg = preg_replace("/S2-4D'/","<218>",$alg); $alg = preg_replace("/S2-4D-/","<218>",$alg);   $alg = preg_replace("/S2-4D2/","<217>",$alg);   $alg = preg_replace("/S2-4D/","<216>",$alg);
    
    
    /* S2-2 | S4-4 */
    $alg = preg_replace("/S2-2R'/","<219>",$alg); $alg = preg_replace("/S2-2R-/","<219>",$alg);   $alg = preg_replace("/S2-2R2/","<220>",$alg);   $alg = preg_replace("/S2-2R/","<221>",$alg);
    $alg = preg_replace("/S2-2L'/","<222>",$alg); $alg = preg_replace("/S2-2L-/","<222>",$alg);   $alg = preg_replace("/S2-2L2/","<223>",$alg);   $alg = preg_replace("/S2-2L/","<224>",$alg);
    $alg = preg_replace("/S2-2F'/","<225>",$alg); $alg = preg_replace("/S2-2F-/","<225>",$alg);   $alg = preg_replace("/S2-2F2/","<226>",$alg);   $alg = preg_replace("/S2-2F/","<227>",$alg);
    $alg = preg_replace("/S2-2B'/","<228>",$alg); $alg = preg_replace("/S2-2B-/","<228>",$alg);   $alg = preg_replace("/S2-2B2/","<229>",$alg);   $alg = preg_replace("/S2-2B/","<230>",$alg);
    $alg = preg_replace("/S2-2U'/","<231>",$alg); $alg = preg_replace("/S2-2U-/","<231>",$alg);   $alg = preg_replace("/S2-2U2/","<232>",$alg);   $alg = preg_replace("/S2-2U/","<233>",$alg);
    $alg = preg_replace("/S2-2D'/","<234>",$alg); $alg = preg_replace("/S2-2D-/","<234>",$alg);   $alg = preg_replace("/S2-2D2/","<235>",$alg);   $alg = preg_replace("/S2-2D/","<236>",$alg);
    
    $alg = preg_replace("/S4-4R'/","<224>",$alg); $alg = preg_replace("/S4-4R-/","<224>",$alg);   $alg = preg_replace("/S4-4R2/","<223>",$alg);   $alg = preg_replace("/S4-4R/","<222>",$alg);
    $alg = preg_replace("/S4-4L'/","<221>",$alg); $alg = preg_replace("/S4-4L-/","<221>",$alg);   $alg = preg_replace("/S4-4L2/","<220>",$alg);   $alg = preg_replace("/S4-4L/","<219>",$alg);
    $alg = preg_replace("/S4-4F'/","<230>",$alg); $alg = preg_replace("/S4-4F-/","<230>",$alg);   $alg = preg_replace("/S4-4F2/","<229>",$alg);   $alg = preg_replace("/S4-4F/","<228>",$alg);
    $alg = preg_replace("/S4-4B'/","<227>",$alg); $alg = preg_replace("/S4-4B-/","<227>",$alg);   $alg = preg_replace("/S4-4B2/","<226>",$alg);   $alg = preg_replace("/S4-4B/","<225>",$alg);
    $alg = preg_replace("/S4-4U'/","<236>",$alg); $alg = preg_replace("/S4-4U-/","<236>",$alg);   $alg = preg_replace("/S4-4U2/","<235>",$alg);   $alg = preg_replace("/S4-4U/","<234>",$alg);
    $alg = preg_replace("/S4-4D'/","<233>",$alg); $alg = preg_replace("/S4-4D-/","<233>",$alg);   $alg = preg_replace("/S4-4D2/","<232>",$alg);   $alg = preg_replace("/S4-4D/","<231>",$alg);
    
    
    /* S2-3 | S3-4 */
    $alg = preg_replace("/S2-3R'/","<237>",$alg); $alg = preg_replace("/S2-3R-/","<237>",$alg);   $alg = preg_replace("/S2-3R2/","<238>",$alg);   $alg = preg_replace("/S2-3R/","<239>",$alg);
    $alg = preg_replace("/S2-3L'/","<240>",$alg); $alg = preg_replace("/S2-3L-/","<240>",$alg);   $alg = preg_replace("/S2-3L2/","<241>",$alg);   $alg = preg_replace("/S2-3L/","<242>",$alg);
    $alg = preg_replace("/S2-3F'/","<243>",$alg); $alg = preg_replace("/S2-3F-/","<243>",$alg);   $alg = preg_replace("/S2-3F2/","<244>",$alg);   $alg = preg_replace("/S2-3F/","<245>",$alg);
    $alg = preg_replace("/S2-3B'/","<246>",$alg); $alg = preg_replace("/S2-3B-/","<246>",$alg);   $alg = preg_replace("/S2-3B2/","<247>",$alg);   $alg = preg_replace("/S2-3B/","<248>",$alg);
    $alg = preg_replace("/S2-3U'/","<249>",$alg); $alg = preg_replace("/S2-3U-/","<249>",$alg);   $alg = preg_replace("/S2-3U2/","<250>",$alg);   $alg = preg_replace("/S2-3U/","<251>",$alg);
    $alg = preg_replace("/S2-3D'/","<252>",$alg); $alg = preg_replace("/S2-3D-/","<252>",$alg);   $alg = preg_replace("/S2-3D2/","<253>",$alg);   $alg = preg_replace("/S2-3D/","<254>",$alg);
    
    $alg = preg_replace("/S3-4R'/","<242>",$alg); $alg = preg_replace("/S3-4R-/","<242>",$alg);   $alg = preg_replace("/S3-4R2/","<241>",$alg);   $alg = preg_replace("/S3-4R/","<240>",$alg);
    $alg = preg_replace("/S3-4L'/","<239>",$alg); $alg = preg_replace("/S3-4L-/","<239>",$alg);   $alg = preg_replace("/S3-4L2/","<238>",$alg);   $alg = preg_replace("/S3-4L/","<237>",$alg);
    $alg = preg_replace("/S3-4F'/","<248>",$alg); $alg = preg_replace("/S3-4F-/","<248>",$alg);   $alg = preg_replace("/S3-4F2/","<247>",$alg);   $alg = preg_replace("/S3-4F/","<246>",$alg);
    $alg = preg_replace("/S3-4B'/","<245>",$alg); $alg = preg_replace("/S3-4B-/","<245>",$alg);   $alg = preg_replace("/S3-4B2/","<244>",$alg);   $alg = preg_replace("/S3-4B/","<243>",$alg);
    $alg = preg_replace("/S3-4U'/","<254>",$alg); $alg = preg_replace("/S3-4U-/","<254>",$alg);   $alg = preg_replace("/S3-4U2/","<253>",$alg);   $alg = preg_replace("/S3-4U/","<252>",$alg);
    $alg = preg_replace("/S3-4D'/","<251>",$alg); $alg = preg_replace("/S3-4D-/","<251>",$alg);   $alg = preg_replace("/S3-4D2/","<250>",$alg);   $alg = preg_replace("/S3-4D/","<249>",$alg);
    
    /* --- 5xC: SSE -> CODE: [3] Tier twists --- */
    /* T4 */
    $alg = preg_replace("/T4R'/","<301>",$alg); $alg = preg_replace("/T4R-/","<301>",$alg);   $alg = preg_replace("/T4R2/","<302>",$alg);   $alg = preg_replace("/T4R/","<303>",$alg);
    $alg = preg_replace("/T4L'/","<304>",$alg); $alg = preg_replace("/T4L-/","<304>",$alg);   $alg = preg_replace("/T4L2/","<305>",$alg);   $alg = preg_replace("/T4L/","<306>",$alg);
    $alg = preg_replace("/T4F'/","<307>",$alg); $alg = preg_replace("/T4F-/","<307>",$alg);   $alg = preg_replace("/T4F2/","<308>",$alg);   $alg = preg_replace("/T4F/","<309>",$alg);
    $alg = preg_replace("/T4B'/","<310>",$alg); $alg = preg_replace("/T4B-/","<310>",$alg);   $alg = preg_replace("/T4B2/","<311>",$alg);   $alg = preg_replace("/T4B/","<312>",$alg);
    $alg = preg_replace("/T4U'/","<313>",$alg); $alg = preg_replace("/T4U-/","<313>",$alg);   $alg = preg_replace("/T4U2/","<314>",$alg);   $alg = preg_replace("/T4U/","<315>",$alg);
    $alg = preg_replace("/T4D'/","<316>",$alg); $alg = preg_replace("/T4D-/","<316>",$alg);   $alg = preg_replace("/T4D2/","<317>",$alg);   $alg = preg_replace("/T4D/","<318>",$alg);
    
    
    /* T3 */
    $alg = preg_replace("/T3R'/","<319>",$alg); $alg = preg_replace("/T3R-/","<319>",$alg);   $alg = preg_replace("/T3R2/","<320>",$alg);   $alg = preg_replace("/T3R/","<321>",$alg);
    $alg = preg_replace("/T3L'/","<322>",$alg); $alg = preg_replace("/T3L-/","<322>",$alg);   $alg = preg_replace("/T3L2/","<323>",$alg);   $alg = preg_replace("/T3L/","<324>",$alg);
    $alg = preg_replace("/T3F'/","<325>",$alg); $alg = preg_replace("/T3F-/","<325>",$alg);   $alg = preg_replace("/T3F2/","<326>",$alg);   $alg = preg_replace("/T3F/","<327>",$alg);
    $alg = preg_replace("/T3B'/","<328>",$alg); $alg = preg_replace("/T3B-/","<328>",$alg);   $alg = preg_replace("/T3B2/","<329>",$alg);   $alg = preg_replace("/T3B/","<330>",$alg);
    $alg = preg_replace("/T3U'/","<331>",$alg); $alg = preg_replace("/T3U-/","<331>",$alg);   $alg = preg_replace("/T3U2/","<332>",$alg);   $alg = preg_replace("/T3U/","<333>",$alg);
    $alg = preg_replace("/T3D'/","<334>",$alg); $alg = preg_replace("/T3D-/","<334>",$alg);   $alg = preg_replace("/T3D2/","<335>",$alg);   $alg = preg_replace("/T3D/","<336>",$alg);
    
    
    /* T */
    $alg = preg_replace("/TR'/","<337>",$alg); $alg = preg_replace("/TR-/","<337>",$alg);   $alg = preg_replace("/TR2/","<338>",$alg);   $alg = preg_replace("/TR/","<339>",$alg);
    $alg = preg_replace("/TL'/","<340>",$alg); $alg = preg_replace("/TL-/","<340>",$alg);   $alg = preg_replace("/TL2/","<341>",$alg);   $alg = preg_replace("/TL/","<342>",$alg);
    $alg = preg_replace("/TF'/","<343>",$alg); $alg = preg_replace("/TF-/","<343>",$alg);   $alg = preg_replace("/TF2/","<344>",$alg);   $alg = preg_replace("/TF/","<345>",$alg);
    $alg = preg_replace("/TB'/","<346>",$alg); $alg = preg_replace("/TB-/","<346>",$alg);   $alg = preg_replace("/TB2/","<347>",$alg);   $alg = preg_replace("/TB/","<348>",$alg);
    $alg = preg_replace("/TU'/","<349>",$alg); $alg = preg_replace("/TU-/","<349>",$alg);   $alg = preg_replace("/TU2/","<350>",$alg);   $alg = preg_replace("/TU/","<351>",$alg);
    $alg = preg_replace("/TD'/","<352>",$alg); $alg = preg_replace("/TD-/","<352>",$alg);   $alg = preg_replace("/TD2/","<353>",$alg);   $alg = preg_replace("/TD/","<354>",$alg);
    
    /* --- 5xC: SSE -> CODE: [5] (Mid-layer) [4] Void [1] (Numbered layer) twists --- */
    /* V = M2, N2-3 | N3-4 */
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
    
    $alg = preg_replace("/N3-4R'/","<406>",$alg); $alg = preg_replace("/N3-4R-/","<406>",$alg);   $alg = preg_replace("/N3-4R2/","<405>",$alg);   $alg = preg_replace("/N3-4R/","<404>",$alg);
    $alg = preg_replace("/N3-4L'/","<403>",$alg); $alg = preg_replace("/N3-4L-/","<403>",$alg);   $alg = preg_replace("/N3-4L2/","<402>",$alg);   $alg = preg_replace("/N3-4L/","<401>",$alg);
    $alg = preg_replace("/N3-4F'/","<412>",$alg); $alg = preg_replace("/N3-4F-/","<412>",$alg);   $alg = preg_replace("/N3-4F2/","<411>",$alg);   $alg = preg_replace("/N3-4F/","<410>",$alg);
    $alg = preg_replace("/N3-4B'/","<409>",$alg); $alg = preg_replace("/N3-4B-/","<409>",$alg);   $alg = preg_replace("/N3-4B2/","<408>",$alg);   $alg = preg_replace("/N3-4B/","<407>",$alg);
    $alg = preg_replace("/N3-4U'/","<418>",$alg); $alg = preg_replace("/N3-4U-/","<418>",$alg);   $alg = preg_replace("/N3-4U2/","<417>",$alg);   $alg = preg_replace("/N3-4U/","<416>",$alg);
    $alg = preg_replace("/N3-4D'/","<415>",$alg); $alg = preg_replace("/N3-4D-/","<415>",$alg);   $alg = preg_replace("/N3-4D2/","<414>",$alg);   $alg = preg_replace("/N3-4D/","<413>",$alg);
    
    $alg = preg_replace("/M2R'/","<401>",$alg); $alg = preg_replace("/M2R-/","<401>",$alg);   $alg = preg_replace("/M2R2/","<402>",$alg);   $alg = preg_replace("/M2R/","<403>",$alg);
    $alg = preg_replace("/M2L'/","<404>",$alg); $alg = preg_replace("/M2L-/","<404>",$alg);   $alg = preg_replace("/M2L2/","<405>",$alg);   $alg = preg_replace("/M2L/","<406>",$alg);
    $alg = preg_replace("/M2F'/","<407>",$alg); $alg = preg_replace("/M2F-/","<407>",$alg);   $alg = preg_replace("/M2F2/","<408>",$alg);   $alg = preg_replace("/M2F/","<409>",$alg);
    $alg = preg_replace("/M2B'/","<410>",$alg); $alg = preg_replace("/M2B-/","<410>",$alg);   $alg = preg_replace("/M2B2/","<411>",$alg);   $alg = preg_replace("/M2B/","<412>",$alg);
    $alg = preg_replace("/M2U'/","<413>",$alg); $alg = preg_replace("/M2U-/","<413>",$alg);   $alg = preg_replace("/M2U2/","<414>",$alg);   $alg = preg_replace("/M2U/","<415>",$alg);
    $alg = preg_replace("/M2D'/","<416>",$alg); $alg = preg_replace("/M2D-/","<416>",$alg);   $alg = preg_replace("/M2D2/","<417>",$alg);   $alg = preg_replace("/M2D/","<418>",$alg);
    
    /* --- 5xC: SSE -> CODE: [6] Wide-layer [5] (Mid-layer) [4] (Void) [1] Numbered layer twists --- */
    /* W = M3 = V3 = N2-4 */
    $alg = preg_replace("/WR'/","<501>",$alg); $alg = preg_replace("/WR-/","<501>",$alg);   $alg = preg_replace("/WR2/","<502>",$alg);   $alg = preg_replace("/WR/","<503>",$alg);
    $alg = preg_replace("/WL'/","<503>",$alg); $alg = preg_replace("/WL-/","<503>",$alg);   $alg = preg_replace("/WL2/","<502>",$alg);   $alg = preg_replace("/WL/","<501>",$alg);
    $alg = preg_replace("/WF'/","<504>",$alg); $alg = preg_replace("/WF-/","<504>",$alg);   $alg = preg_replace("/WF2/","<505>",$alg);   $alg = preg_replace("/WF/","<506>",$alg);
    $alg = preg_replace("/WB'/","<506>",$alg); $alg = preg_replace("/WB-/","<506>",$alg);   $alg = preg_replace("/WB2/","<505>",$alg);   $alg = preg_replace("/WB/","<504>",$alg);
    $alg = preg_replace("/WU'/","<507>",$alg); $alg = preg_replace("/WU-/","<507>",$alg);   $alg = preg_replace("/WU2/","<508>",$alg);   $alg = preg_replace("/WU/","<509>",$alg);
    $alg = preg_replace("/WD'/","<509>",$alg); $alg = preg_replace("/WD-/","<509>",$alg);   $alg = preg_replace("/WD2/","<508>",$alg);   $alg = preg_replace("/WD/","<507>",$alg);
    
    $alg = preg_replace("/M3R'/","<501>",$alg); $alg = preg_replace("/M3R-/","<501>",$alg);   $alg = preg_replace("/M3R2/","<502>",$alg);   $alg = preg_replace("/M3R/","<503>",$alg);
    $alg = preg_replace("/M3L'/","<503>",$alg); $alg = preg_replace("/M3L-/","<503>",$alg);   $alg = preg_replace("/M3L2/","<502>",$alg);   $alg = preg_replace("/M3L/","<501>",$alg);
    $alg = preg_replace("/M3F'/","<504>",$alg); $alg = preg_replace("/M3F-/","<504>",$alg);   $alg = preg_replace("/M3F2/","<505>",$alg);   $alg = preg_replace("/M3F/","<506>",$alg);
    $alg = preg_replace("/M3B'/","<506>",$alg); $alg = preg_replace("/M3B-/","<506>",$alg);   $alg = preg_replace("/M3B2/","<505>",$alg);   $alg = preg_replace("/M3B/","<504>",$alg);
    $alg = preg_replace("/M3U'/","<507>",$alg); $alg = preg_replace("/M3U-/","<507>",$alg);   $alg = preg_replace("/M3U2/","<508>",$alg);   $alg = preg_replace("/M3U/","<509>",$alg);
    $alg = preg_replace("/M3D'/","<509>",$alg); $alg = preg_replace("/M3D-/","<509>",$alg);   $alg = preg_replace("/M3D2/","<508>",$alg);   $alg = preg_replace("/M3D/","<507>",$alg);
    
    $alg = preg_replace("/V3R'/","<501>",$alg); $alg = preg_replace("/V3R-/","<501>",$alg);   $alg = preg_replace("/V3R2/","<502>",$alg);   $alg = preg_replace("/V3R/","<503>",$alg);
    $alg = preg_replace("/V3L'/","<503>",$alg); $alg = preg_replace("/V3L-/","<503>",$alg);   $alg = preg_replace("/V3L2/","<502>",$alg);   $alg = preg_replace("/V3L/","<501>",$alg);
    $alg = preg_replace("/V3F'/","<504>",$alg); $alg = preg_replace("/V3F-/","<504>",$alg);   $alg = preg_replace("/V3F2/","<505>",$alg);   $alg = preg_replace("/V3F/","<506>",$alg);
    $alg = preg_replace("/V3B'/","<506>",$alg); $alg = preg_replace("/V3B-/","<506>",$alg);   $alg = preg_replace("/V3B2/","<505>",$alg);   $alg = preg_replace("/V3B/","<504>",$alg);
    $alg = preg_replace("/V3U'/","<507>",$alg); $alg = preg_replace("/V3U-/","<507>",$alg);   $alg = preg_replace("/V3U2/","<508>",$alg);   $alg = preg_replace("/V3U/","<509>",$alg);
    $alg = preg_replace("/V3D'/","<509>",$alg); $alg = preg_replace("/V3D-/","<509>",$alg);   $alg = preg_replace("/V3D2/","<508>",$alg);   $alg = preg_replace("/V3D/","<507>",$alg);
    
    $alg = preg_replace("/N2-4R'/","<501>",$alg); $alg = preg_replace("/N2-4R-/","<501>",$alg);   $alg = preg_replace("/N2-4R2/","<502>",$alg);   $alg = preg_replace("/N2-4R/","<503>",$alg);
    $alg = preg_replace("/N2-4L'/","<503>",$alg); $alg = preg_replace("/N2-4L-/","<503>",$alg);   $alg = preg_replace("/N2-4L2/","<502>",$alg);   $alg = preg_replace("/N2-4L/","<501>",$alg);
    $alg = preg_replace("/N2-4F'/","<504>",$alg); $alg = preg_replace("/N2-4F-/","<504>",$alg);   $alg = preg_replace("/N2-4F2/","<505>",$alg);   $alg = preg_replace("/N2-4F/","<506>",$alg);
    $alg = preg_replace("/N2-4B'/","<506>",$alg); $alg = preg_replace("/N2-4B-/","<506>",$alg);   $alg = preg_replace("/N2-4B2/","<505>",$alg);   $alg = preg_replace("/N2-4B/","<504>",$alg);
    $alg = preg_replace("/N2-4U'/","<507>",$alg); $alg = preg_replace("/N2-4U-/","<507>",$alg);   $alg = preg_replace("/N2-4U2/","<508>",$alg);   $alg = preg_replace("/N2-4U/","<509>",$alg);
    $alg = preg_replace("/N2-4D'/","<509>",$alg); $alg = preg_replace("/N2-4D-/","<509>",$alg);   $alg = preg_replace("/N2-4D2/","<508>",$alg);   $alg = preg_replace("/N2-4D/","<507>",$alg);
    
    /* --- 5xC: SSE -> CODE: [7] Cube rotations --- */
    /* C */
    $alg = preg_replace("/CR'/","<701>",$alg); $alg = preg_replace("/CR-/","<701>",$alg);   $alg = preg_replace("/CR2/","<702>",$alg);   $alg = preg_replace("/CR/","<703>",$alg);
    $alg = preg_replace("/CL'/","<703>",$alg); $alg = preg_replace("/CL-/","<703>",$alg);   $alg = preg_replace("/CL2/","<702>",$alg);   $alg = preg_replace("/CL/","<701>",$alg);
    $alg = preg_replace("/CF'/","<704>",$alg); $alg = preg_replace("/CF-/","<704>",$alg);   $alg = preg_replace("/CF2/","<705>",$alg);   $alg = preg_replace("/CF/","<706>",$alg);
    $alg = preg_replace("/CB'/","<706>",$alg); $alg = preg_replace("/CB-/","<706>",$alg);   $alg = preg_replace("/CB2/","<705>",$alg);   $alg = preg_replace("/CB/","<704>",$alg);
    $alg = preg_replace("/CU'/","<707>",$alg); $alg = preg_replace("/CU-/","<707>",$alg);   $alg = preg_replace("/CU2/","<708>",$alg);   $alg = preg_replace("/CU/","<709>",$alg);
    $alg = preg_replace("/CD'/","<709>",$alg); $alg = preg_replace("/CD-/","<709>",$alg);   $alg = preg_replace("/CD2/","<708>",$alg);   $alg = preg_replace("/CD/","<707>",$alg);
    
    /* --- 5xC: SSE -> CODE: [9] Face twists --- */
    /*   */
    $alg = preg_replace("/R'/","<901>",$alg); $alg = preg_replace("/R-/","<901>",$alg);   $alg = preg_replace("/R2/","<902>",$alg);   $alg = preg_replace("/R/","<903>",$alg);
    $alg = preg_replace("/L'/","<904>",$alg); $alg = preg_replace("/L-/","<904>",$alg);   $alg = preg_replace("/L2/","<905>",$alg);   $alg = preg_replace("/L/","<906>",$alg);
    $alg = preg_replace("/F'/","<907>",$alg); $alg = preg_replace("/F-/","<907>",$alg);   $alg = preg_replace("/F2/","<908>",$alg);   $alg = preg_replace("/F/","<909>",$alg);
    $alg = preg_replace("/B'/","<910>",$alg); $alg = preg_replace("/B-/","<910>",$alg);   $alg = preg_replace("/B2/","<911>",$alg);   $alg = preg_replace("/B/","<912>",$alg);
    $alg = preg_replace("/U'/","<913>",$alg); $alg = preg_replace("/U-/","<913>",$alg);   $alg = preg_replace("/U2/","<914>",$alg);   $alg = preg_replace("/U/","<915>",$alg);
    $alg = preg_replace("/D'/","<916>",$alg); $alg = preg_replace("/D-/","<916>",$alg);   $alg = preg_replace("/D2/","<917>",$alg);   $alg = preg_replace("/D/","<918>",$alg);
    
    /* ··································································································· */
    /* --- 5xC: CODE -> TWIZZLE: [1] Numbered-layer twists --- */
    /* N | N4 */
    $alg = preg_replace("/<101>/","2R'",$alg);   $alg = preg_replace("/<102>/","2R2",$alg);   $alg = preg_replace("/<103>/","2R",$alg);
    $alg = preg_replace("/<104>/","2L'",$alg);   $alg = preg_replace("/<105>/","2L2",$alg);   $alg = preg_replace("/<106>/","2L",$alg);
    $alg = preg_replace("/<107>/","2F'",$alg);   $alg = preg_replace("/<108>/","2F2",$alg);   $alg = preg_replace("/<109>/","2F",$alg);
    $alg = preg_replace("/<110>/","2B'",$alg);   $alg = preg_replace("/<111>/","2B2",$alg);   $alg = preg_replace("/<112>/","2B",$alg);
    $alg = preg_replace("/<113>/","2U'",$alg);   $alg = preg_replace("/<114>/","2U2",$alg);   $alg = preg_replace("/<115>/","2U",$alg);
    $alg = preg_replace("/<116>/","2D'",$alg);   $alg = preg_replace("/<117>/","2D2",$alg);   $alg = preg_replace("/<118>/","2D",$alg);
    
    /* N3 = M */
    if ($useSiGN == true) { // Bei SiGN:
      $alg = preg_replace("/<119>/","M", $alg);   $alg = preg_replace("/<120>/","M2",$alg);   $alg = preg_replace("/<121>/","M'",$alg);
      $alg = preg_replace("/<122>/","S'",$alg);   $alg = preg_replace("/<123>/","S2",$alg);   $alg = preg_replace("/<124>/","S", $alg);
      $alg = preg_replace("/<125>/","E", $alg);   $alg = preg_replace("/<126>/","E2",$alg);   $alg = preg_replace("/<127>/","E'",$alg);
      
    } else {               // Sonst (TWIZZLE):
      $alg = preg_replace("/<119>/","3R'",$alg);   $alg = preg_replace("/<120>/","3R2",$alg);   $alg = preg_replace("/<121>/","3R",$alg);
      $alg = preg_replace("/<122>/","3F'",$alg);   $alg = preg_replace("/<123>/","3F2",$alg);   $alg = preg_replace("/<124>/","3F",$alg);
      $alg = preg_replace("/<125>/","3U'",$alg);   $alg = preg_replace("/<126>/","3U2",$alg);   $alg = preg_replace("/<127>/","3U",$alg);
    }
    
    /* --- 5xC: CODE -> TWIZZLE: [2] Slice twists --- */
    /* S2 = S3-3 */
    $alg = preg_replace("/<201>/","r' l",$alg);   $alg = preg_replace("/<202>/","r2 l2",$alg);   $alg = preg_replace("/<203>/","r l'",$alg);
    $alg = preg_replace("/<204>/","f' b",$alg);   $alg = preg_replace("/<205>/","f2 b2",$alg);   $alg = preg_replace("/<206>/","f b'",$alg);
    $alg = preg_replace("/<207>/","u' d",$alg);   $alg = preg_replace("/<208>/","u2 d2",$alg);   $alg = preg_replace("/<209>/","u d'",$alg);
    
    
    /* S = S2-4 */
    $alg = preg_replace("/<210>/","R' L",$alg);   $alg = preg_replace("/<211>/","R2 L2",$alg);   $alg = preg_replace("/<212>/","R L'",$alg);
    $alg = preg_replace("/<213>/","F' B",$alg);   $alg = preg_replace("/<214>/","F2 B2",$alg);   $alg = preg_replace("/<215>/","F B'",$alg);
    $alg = preg_replace("/<216>/","U' D",$alg);   $alg = preg_replace("/<217>/","U2 D2",$alg);   $alg = preg_replace("/<218>/","U D'",$alg);
    
    
    /* S2-2 | S4-4 */
    $alg = preg_replace("/<219>/","R' 3l",$alg);   $alg = preg_replace("/<220>/","R2 3l2",$alg);   $alg = preg_replace("/<221>/","R 3l'",$alg);
    $alg = preg_replace("/<222>/","3r L'",$alg);   $alg = preg_replace("/<223>/","3r2 L2",$alg);   $alg = preg_replace("/<224>/","3r' L",$alg);
    $alg = preg_replace("/<225>/","F' 3b",$alg);   $alg = preg_replace("/<226>/","F2 3b2",$alg);   $alg = preg_replace("/<227>/","F 3b'",$alg);
    $alg = preg_replace("/<228>/","3f B'",$alg);   $alg = preg_replace("/<229>/","3f2 B2",$alg);   $alg = preg_replace("/<230>/","3f' B",$alg);
    $alg = preg_replace("/<231>/","U' 3d",$alg);   $alg = preg_replace("/<232>/","U2 3d2",$alg);   $alg = preg_replace("/<233>/","U 3d'",$alg);
    $alg = preg_replace("/<234>/","3u D'",$alg);   $alg = preg_replace("/<235>/","3u2 D2",$alg);   $alg = preg_replace("/<236>/","3u' D",$alg);
    
    
    /* S2-3 | S3-4 */
    $alg = preg_replace("/<237>/","R' l",$alg);   $alg = preg_replace("/<238>/","R2 l2",$alg);   $alg = preg_replace("/<239>/","R l'",$alg);
    $alg = preg_replace("/<240>/","r L'",$alg);   $alg = preg_replace("/<241>/","r2 L2",$alg);   $alg = preg_replace("/<242>/","r' L",$alg);
    $alg = preg_replace("/<243>/","F' b",$alg);   $alg = preg_replace("/<244>/","F2 b2",$alg);   $alg = preg_replace("/<245>/","F b'",$alg);
    $alg = preg_replace("/<246>/","f B'",$alg);   $alg = preg_replace("/<247>/","f2 B2",$alg);   $alg = preg_replace("/<248>/","f' B",$alg);
    $alg = preg_replace("/<249>/","U' d",$alg);   $alg = preg_replace("/<250>/","U2 d2",$alg);   $alg = preg_replace("/<251>/","U d'",$alg);
    $alg = preg_replace("/<252>/","u D'",$alg);   $alg = preg_replace("/<253>/","u2 D2",$alg);   $alg = preg_replace("/<254>/","u' D",$alg);
    
    /* --- 5xC: CODE -> TWIZZLE: [3] Tier twists --- */
    /* T4 */
    $alg = preg_replace("/<301>/","4r'",$alg);   $alg = preg_replace("/<302>/","4r2",$alg);   $alg = preg_replace("/<303>/","4r",$alg);
    $alg = preg_replace("/<304>/","4l'",$alg);   $alg = preg_replace("/<305>/","4l2",$alg);   $alg = preg_replace("/<306>/","4l",$alg);
    $alg = preg_replace("/<307>/","4f'",$alg);   $alg = preg_replace("/<308>/","4f2",$alg);   $alg = preg_replace("/<309>/","4f",$alg);
    $alg = preg_replace("/<310>/","4b'",$alg);   $alg = preg_replace("/<311>/","4b2",$alg);   $alg = preg_replace("/<312>/","4b",$alg);
    $alg = preg_replace("/<313>/","4u'",$alg);   $alg = preg_replace("/<314>/","4u2",$alg);   $alg = preg_replace("/<315>/","4u",$alg);
    $alg = preg_replace("/<316>/","4d'",$alg);   $alg = preg_replace("/<317>/","4d2",$alg);   $alg = preg_replace("/<318>/","4d",$alg);
    
    
    /* T3 */
    $alg = preg_replace("/<319>/","3r'",$alg);   $alg = preg_replace("/<320>/","3r2",$alg);   $alg = preg_replace("/<321>/","3r",$alg);
    $alg = preg_replace("/<322>/","3l'",$alg);   $alg = preg_replace("/<323>/","3l2",$alg);   $alg = preg_replace("/<324>/","3l",$alg);
    $alg = preg_replace("/<325>/","3f'",$alg);   $alg = preg_replace("/<326>/","3f2",$alg);   $alg = preg_replace("/<327>/","3f",$alg);
    $alg = preg_replace("/<328>/","3b'",$alg);   $alg = preg_replace("/<329>/","3b2",$alg);   $alg = preg_replace("/<330>/","3b",$alg);
    $alg = preg_replace("/<331>/","3u'",$alg);   $alg = preg_replace("/<332>/","3u2",$alg);   $alg = preg_replace("/<333>/","3u",$alg);
    $alg = preg_replace("/<334>/","3d'",$alg);   $alg = preg_replace("/<335>/","3d2",$alg);   $alg = preg_replace("/<336>/","3d",$alg);
    
    
    /* T */
    $alg = preg_replace("/<337>/","r'",$alg);   $alg = preg_replace("/<338>/","r2",$alg);   $alg = preg_replace("/<339>/","r",$alg);
    $alg = preg_replace("/<340>/","l'",$alg);   $alg = preg_replace("/<341>/","l2",$alg);   $alg = preg_replace("/<342>/","l",$alg);
    $alg = preg_replace("/<343>/","f'",$alg);   $alg = preg_replace("/<344>/","f2",$alg);   $alg = preg_replace("/<345>/","f",$alg);
    $alg = preg_replace("/<346>/","b'",$alg);   $alg = preg_replace("/<347>/","b2",$alg);   $alg = preg_replace("/<348>/","b",$alg);
    $alg = preg_replace("/<349>/","u'",$alg);   $alg = preg_replace("/<350>/","u2",$alg);   $alg = preg_replace("/<351>/","u",$alg);
    $alg = preg_replace("/<352>/","d'",$alg);   $alg = preg_replace("/<353>/","d2",$alg);   $alg = preg_replace("/<354>/","d",$alg);
    
    /* --- 5xC: CODE -> TWIZZLE: [4] Void twists --- */
    /* V = N2-3 = M2 */
    $alg = preg_replace("/<401>/","2-3R'",$alg);   $alg = preg_replace("/<402>/","2-3R2",$alg);   $alg = preg_replace("/<403>/","2-3R",$alg);
    $alg = preg_replace("/<404>/","2-3L'",$alg);   $alg = preg_replace("/<405>/","2-3L2",$alg);   $alg = preg_replace("/<406>/","2-3L",$alg);
    $alg = preg_replace("/<407>/","2-3F'",$alg);   $alg = preg_replace("/<408>/","2-3F2",$alg);   $alg = preg_replace("/<409>/","2-3F",$alg);
    $alg = preg_replace("/<410>/","2-3B'",$alg);   $alg = preg_replace("/<411>/","2-3B2",$alg);   $alg = preg_replace("/<412>/","2-3B",$alg);
    $alg = preg_replace("/<413>/","2-3U'",$alg);   $alg = preg_replace("/<414>/","2-3U2",$alg);   $alg = preg_replace("/<415>/","2-3U",$alg);
    $alg = preg_replace("/<416>/","2-3D'",$alg);   $alg = preg_replace("/<417>/","2-3D2",$alg);   $alg = preg_replace("/<418>/","2-3D",$alg);
    
    /* --- 5xC: CODE -> TWIZZLE: [6] Wide-layer [5] (Mid-layer) twists --- */
    /* W = M3 = V3 = N2-4 */
    if ($useSiGN == true) { // Bei SiGN:
      $alg = preg_replace("/<501>/","m", $alg);   $alg = preg_replace("/<502>/","m2",$alg);   $alg = preg_replace("/<503>/","m'",$alg);
      $alg = preg_replace("/<504>/","s'",$alg);   $alg = preg_replace("/<505>/","s2",$alg);   $alg = preg_replace("/<506>/","s", $alg);
      $alg = preg_replace("/<507>/","e", $alg);   $alg = preg_replace("/<508>/","e2",$alg);   $alg = preg_replace("/<509>/","e'",$alg);
      
    } else {               // Sonst (TWIZZLE):
      $alg = preg_replace("/<501>/","2-4R'",$alg);   $alg = preg_replace("/<502>/","2-4R2",$alg);   $alg = preg_replace("/<503>/","2-4R",$alg);
      $alg = preg_replace("/<504>/","2-4F'",$alg);   $alg = preg_replace("/<505>/","2-4F2",$alg);   $alg = preg_replace("/<506>/","2-4F",$alg);
      $alg = preg_replace("/<507>/","2-4U'",$alg);   $alg = preg_replace("/<508>/","2-4U2",$alg);   $alg = preg_replace("/<509>/","2-4U",$alg);
    }
    
    /* --- 5xC: CODE -> TWIZZLE: [7] Cube rotations --- */
    /* C */
    if ($useSiGN == true) { // Bei SiGN:
      $alg = preg_replace("/<701>/","x'",$alg);   $alg = preg_replace("/<702>/","x2",$alg);   $alg = preg_replace("/<703>/","x",$alg);
      $alg = preg_replace("/<704>/","z'",$alg);   $alg = preg_replace("/<705>/","z2",$alg);   $alg = preg_replace("/<706>/","z",$alg);
      $alg = preg_replace("/<707>/","y'",$alg);   $alg = preg_replace("/<708>/","y2",$alg);   $alg = preg_replace("/<709>/","y",$alg);
      
    } else {               // Sonst (TWIZZLE):
      $alg = preg_replace("/<701>/","Rv'",$alg);   $alg = preg_replace("/<702>/","Rv2",$alg);   $alg = preg_replace("/<703>/","Rv",$alg);
      $alg = preg_replace("/<704>/","Fv'",$alg);   $alg = preg_replace("/<705>/","Fv2",$alg);   $alg = preg_replace("/<706>/","Fv",$alg);
      $alg = preg_replace("/<707>/","Uv'",$alg);   $alg = preg_replace("/<708>/","Uv2",$alg);   $alg = preg_replace("/<709>/","Uv",$alg);
    }
    
    /* --- 5xC: CODE -> TWIZZLE: [9] Face twists --- */
    /*   */
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
    /* --- 5xC: Preferences --- */
    $optSSE = true;  // Optimize SSE (rebuilds Slice twists).
    
    /* --- 5xC: Marker --- */
    $alg = str_replace(".","·",$alg);
    
    /* ··································································································· */
    /* --- 5xC: TWIZZLE -> CODE: [3] Tier twists (TWIZZLE) --- */
    /* T4 */
    $alg = preg_replace("/1-4R'/","<301>",$alg); $alg = preg_replace("/1-4R2/","<302>",$alg); $alg = preg_replace("/1-4R/","<303>",$alg);
    $alg = preg_replace("/1-4L'/","<304>",$alg); $alg = preg_replace("/1-4L2/","<305>",$alg); $alg = preg_replace("/1-4L/","<306>",$alg);
    $alg = preg_replace("/1-4F'/","<307>",$alg); $alg = preg_replace("/1-4F2/","<308>",$alg); $alg = preg_replace("/1-4F/","<309>",$alg);
    $alg = preg_replace("/1-4B'/","<310>",$alg); $alg = preg_replace("/1-4B2/","<311>",$alg); $alg = preg_replace("/1-4B/","<312>",$alg);
    $alg = preg_replace("/1-4U'/","<313>",$alg); $alg = preg_replace("/1-4U2/","<314>",$alg); $alg = preg_replace("/1-4U/","<315>",$alg);
    $alg = preg_replace("/1-4D'/","<316>",$alg); $alg = preg_replace("/1-4D2/","<317>",$alg); $alg = preg_replace("/1-4D/","<318>",$alg);
    
    
    /* T3 */
    $alg = preg_replace("/1-3R'/","<319>",$alg); $alg = preg_replace("/1-3R2/","<320>",$alg); $alg = preg_replace("/1-3R/","<321>",$alg);
    $alg = preg_replace("/1-3L'/","<322>",$alg); $alg = preg_replace("/1-3L2/","<323>",$alg); $alg = preg_replace("/1-3L/","<324>",$alg);
    $alg = preg_replace("/1-3F'/","<325>",$alg); $alg = preg_replace("/1-3F2/","<326>",$alg); $alg = preg_replace("/1-3F/","<327>",$alg);
    $alg = preg_replace("/1-3B'/","<328>",$alg); $alg = preg_replace("/1-3B2/","<329>",$alg); $alg = preg_replace("/1-3B/","<330>",$alg);
    $alg = preg_replace("/1-3U'/","<331>",$alg); $alg = preg_replace("/1-3U2/","<332>",$alg); $alg = preg_replace("/1-3U/","<333>",$alg);
    $alg = preg_replace("/1-3D'/","<334>",$alg); $alg = preg_replace("/1-3D2/","<335>",$alg); $alg = preg_replace("/1-3D/","<336>",$alg);
    
    
    /* T */
    $alg = preg_replace("/1-2R'/","<337>",$alg); $alg = preg_replace("/1-2R2/","<338>",$alg); $alg = preg_replace("/1-2R/","<339>",$alg);
    $alg = preg_replace("/1-2L'/","<340>",$alg); $alg = preg_replace("/1-2L2/","<341>",$alg); $alg = preg_replace("/1-2L/","<342>",$alg);
    $alg = preg_replace("/1-2F'/","<343>",$alg); $alg = preg_replace("/1-2F2/","<344>",$alg); $alg = preg_replace("/1-2F/","<345>",$alg);
    $alg = preg_replace("/1-2B'/","<346>",$alg); $alg = preg_replace("/1-2B2/","<347>",$alg); $alg = preg_replace("/1-2B/","<348>",$alg);
    $alg = preg_replace("/1-2U'/","<349>",$alg); $alg = preg_replace("/1-2U2/","<350>",$alg); $alg = preg_replace("/1-2U/","<351>",$alg);
    $alg = preg_replace("/1-2D'/","<352>",$alg); $alg = preg_replace("/1-2D2/","<353>",$alg); $alg = preg_replace("/1-2D/","<354>",$alg);
    
    /* --- 5xC: TWIZZLE -> CODE: [2] Slice twists --- */
    if ($optSSE == true) {
      /* S = S2-4 */
      $alg = preg_replace("/2-4R Rv'/","<210>",$alg); $alg = preg_replace("/2-4R Rv-/","<210>",$alg);   $alg = preg_replace("/2-4R2 Rv2/","<211>",$alg);   $alg = preg_replace("/2-4R' Rv/","<212>",$alg); $alg = preg_replace("/2-4R- Rv/","<212>",$alg);
      $alg = preg_replace("/2-4L Lv'/","<212>",$alg); $alg = preg_replace("/2-4L Lv-/","<212>",$alg);   $alg = preg_replace("/2-4L2 Lv2/","<211>",$alg);   $alg = preg_replace("/2-4L' Lv/","<210>",$alg); $alg = preg_replace("/2-4L- Lv/","<210>",$alg);
      $alg = preg_replace("/2-4F Fv'/","<213>",$alg); $alg = preg_replace("/2-4F Fv-/","<213>",$alg);   $alg = preg_replace("/2-4F2 Fv2/","<214>",$alg);   $alg = preg_replace("/2-4F' Fv/","<215>",$alg); $alg = preg_replace("/2-4F- Fv/","<215>",$alg);
      $alg = preg_replace("/2-4B Bv'/","<215>",$alg); $alg = preg_replace("/2-4B Bv-/","<215>",$alg);   $alg = preg_replace("/2-4B2 Bv2/","<214>",$alg);   $alg = preg_replace("/2-4B' Bv/","<213>",$alg); $alg = preg_replace("/2-4B- Bv/","<213>",$alg);
      $alg = preg_replace("/2-4U Uv'/","<216>",$alg); $alg = preg_replace("/2-4U Uv-/","<216>",$alg);   $alg = preg_replace("/2-4U2 Uv2/","<217>",$alg);   $alg = preg_replace("/2-4U' Uv/","<218>",$alg); $alg = preg_replace("/2-4U- Uv/","<218>",$alg);
      $alg = preg_replace("/2-4D Dv'/","<218>",$alg); $alg = preg_replace("/2-4D Dv-/","<218>",$alg);   $alg = preg_replace("/2-4D2 Dv2/","<217>",$alg);   $alg = preg_replace("/2-4D' Dv/","<216>",$alg); $alg = preg_replace("/2-4D- Dv/","<216>",$alg);
      
      
      /* S2-3 | S3-4 */
/* xxx   xxx */
      $alg = preg_replace("/2-3R Rv'/","<237>",$alg); $alg = preg_replace("/2-3R Rv-/","<237>",$alg);   $alg = preg_replace("/2-3R2 Rv2/","<238>",$alg);   $alg = preg_replace("/2-3R' Rv/","<239>",$alg); $alg = preg_replace("/2-3R- Rv/","<239>",$alg);
      $alg = preg_replace("/2-3L Lv'/","<240>",$alg); $alg = preg_replace("/2-3L Lv-/","<240>",$alg);   $alg = preg_replace("/2-3L2 Lv2/","<241>",$alg);   $alg = preg_replace("/2-3L' Lv/","<242>",$alg); $alg = preg_replace("/2-3L- Lv/","<242>",$alg);
      $alg = preg_replace("/2-3F Fv'/","<243>",$alg); $alg = preg_replace("/2-3F Fv-/","<243>",$alg);   $alg = preg_replace("/2-3F2 Fv2/","<244>",$alg);   $alg = preg_replace("/2-3F' Fv/","<245>",$alg); $alg = preg_replace("/2-3F- Fv/","<245>",$alg);
      $alg = preg_replace("/2-3B Bv'/","<246>",$alg); $alg = preg_replace("/2-3B Bv-/","<246>",$alg);   $alg = preg_replace("/2-3B2 Bv2/","<247>",$alg);   $alg = preg_replace("/2-3B' Bv/","<248>",$alg); $alg = preg_replace("/2-3B- Bv/","<248>",$alg);
      $alg = preg_replace("/2-3U Uv'/","<249>",$alg); $alg = preg_replace("/2-3U Uv-/","<249>",$alg);   $alg = preg_replace("/2-3U2 Uv2/","<250>",$alg);   $alg = preg_replace("/2-3U' Uv/","<251>",$alg); $alg = preg_replace("/2-3U- Uv/","<251>",$alg);
      $alg = preg_replace("/2-3D Dv'/","<252>",$alg); $alg = preg_replace("/2-3D Dv-/","<252>",$alg);   $alg = preg_replace("/2-3D2 Dv2/","<253>",$alg);   $alg = preg_replace("/2-3D' Dv/","<254>",$alg); $alg = preg_replace("/2-3D- Dv/","<254>",$alg);
    }
    
    /* --- 5xC: TWIZZLE -> CODE: [6] Wide layer twists --- */
    /* W */
    $alg = preg_replace("/2-4R'/","<601>",$alg); $alg = preg_replace("/2-4R2/","<602>",$alg); $alg = preg_replace("/2-4R/","<603>",$alg);
    $alg = preg_replace("/2-4L'/","<603>",$alg); $alg = preg_replace("/2-4L2/","<602>",$alg); $alg = preg_replace("/2-4L/","<601>",$alg);
    $alg = preg_replace("/2-4F'/","<604>",$alg); $alg = preg_replace("/2-4F2/","<605>",$alg); $alg = preg_replace("/2-4F/","<606>",$alg);
    $alg = preg_replace("/2-4B'/","<606>",$alg); $alg = preg_replace("/2-4B2/","<605>",$alg); $alg = preg_replace("/2-4B/","<604>",$alg);
    $alg = preg_replace("/2-4U'/","<607>",$alg); $alg = preg_replace("/2-4U2/","<608>",$alg); $alg = preg_replace("/2-4U/","<609>",$alg);
    $alg = preg_replace("/2-4D'/","<609>",$alg); $alg = preg_replace("/2-4D2/","<608>",$alg); $alg = preg_replace("/2-4D/","<607>",$alg);
    
    $alg = preg_replace("/m'/","<603>",$alg); $alg = preg_replace("/m2/","<602>",$alg); $alg = preg_replace("/m/","<601>",$alg);
    $alg = preg_replace("/s'/","<604>",$alg); $alg = preg_replace("/s2/","<605>",$alg); $alg = preg_replace("/s/","<606>",$alg);
    $alg = preg_replace("/e'/","<609>",$alg); $alg = preg_replace("/e2/","<608>",$alg); $alg = preg_replace("/e/","<607>",$alg);
    
    /* --- 5xC: TWIZZLE -> CODE: [4] Void twists --- */
    /* V */
    $alg = preg_replace("/2-3R'/","<401>",$alg); $alg = preg_replace("/2-3R2/","<402>",$alg); $alg = preg_replace("/2-3R/","<403>",$alg);
    $alg = preg_replace("/2-3L'/","<404>",$alg); $alg = preg_replace("/2-3L2/","<405>",$alg); $alg = preg_replace("/2-3L/","<406>",$alg);
    $alg = preg_replace("/2-3F'/","<407>",$alg); $alg = preg_replace("/2-3F2/","<408>",$alg); $alg = preg_replace("/2-3F/","<409>",$alg);
    $alg = preg_replace("/2-3B'/","<410>",$alg); $alg = preg_replace("/2-3B2/","<411>",$alg); $alg = preg_replace("/2-3B/","<412>",$alg);
    $alg = preg_replace("/2-3U'/","<413>",$alg); $alg = preg_replace("/2-3U2/","<414>",$alg); $alg = preg_replace("/2-3U/","<415>",$alg);
    $alg = preg_replace("/2-3D'/","<416>",$alg); $alg = preg_replace("/2-3D2/","<417>",$alg); $alg = preg_replace("/2-3D/","<418>",$alg);
    
    /* --- 5xC: TWIZZLE -> CODE: [2] Slice twists --- */
    if ($optSSE == true) {
      /* S2 = S3-3 */
      $alg = preg_replace("/3R Rv'/","<201>",$alg); $alg = preg_replace("/3R Rv-/","<201>",$alg);   $alg = preg_replace("/3R2 Rv2/","<202>",$alg);   $alg = preg_replace("/3R' Rv/","<203>",$alg); $alg = preg_replace("/3R- Rv/","<203>",$alg);
      $alg = preg_replace("/3L Lv'/","<203>",$alg); $alg = preg_replace("/3L Lv-/","<203>",$alg);   $alg = preg_replace("/3L2 Lv2/","<202>",$alg);   $alg = preg_replace("/3L' Lv/","<201>",$alg); $alg = preg_replace("/3L- Lv/","<201>",$alg);
      $alg = preg_replace("/3F Fv'/","<204>",$alg); $alg = preg_replace("/3F Fv-/","<204>",$alg);   $alg = preg_replace("/3F2 Fv2/","<205>",$alg);   $alg = preg_replace("/3F' Fv/","<206>",$alg); $alg = preg_replace("/3F- Fv/","<206>",$alg);
      $alg = preg_replace("/3B Bv'/","<206>",$alg); $alg = preg_replace("/3B Bv-/","<206>",$alg);   $alg = preg_replace("/3B2 Bv2/","<205>",$alg);   $alg = preg_replace("/3B' Bv/","<204>",$alg); $alg = preg_replace("/3B- Bv/","<204>",$alg);
      $alg = preg_replace("/3U Uv'/","<207>",$alg); $alg = preg_replace("/3U Uv-/","<207>",$alg);   $alg = preg_replace("/3U2 Uv2/","<208>",$alg);   $alg = preg_replace("/3U' Uv/","<209>",$alg); $alg = preg_replace("/3U- Uv/","<209>",$alg);
      $alg = preg_replace("/3D Dv'/","<209>",$alg); $alg = preg_replace("/3D Dv-/","<209>",$alg);   $alg = preg_replace("/3D2 Dv2/","<208>",$alg);   $alg = preg_replace("/3D' Dv/","<207>",$alg); $alg = preg_replace("/3D- Dv/","<207>",$alg);
      
      
      /* S2-2 | S4-4 */
/* xxx   xxx */
      $alg = preg_replace("/2R Rv'/","<219>",$alg); $alg = preg_replace("/2R Rv-/","<219>",$alg);     $alg = preg_replace("/2R2 Rv2/","<220>",$alg);   $alg = preg_replace("/2R' Rv/","<221>",$alg); $alg = preg_replace("/2R- Rv/","<221>",$alg);
      $alg = preg_replace("/2L Lv'/","<222>",$alg); $alg = preg_replace("/2L Lv-/","<222>",$alg);     $alg = preg_replace("/2L2 Lv2/","<223>",$alg);   $alg = preg_replace("/2L' Lv/","<224>",$alg); $alg = preg_replace("/2L- Lv/","<224>",$alg);
      $alg = preg_replace("/2F Fv'/","<225>",$alg); $alg = preg_replace("/2F Fv-/","<225>",$alg);     $alg = preg_replace("/2F2 Fv2/","<226>",$alg);   $alg = preg_replace("/2F' Fv/","<227>",$alg); $alg = preg_replace("/2F- Fv/","<227>",$alg);
      $alg = preg_replace("/2B Bv'/","<228>",$alg); $alg = preg_replace("/2B Bv-/","<228>",$alg);     $alg = preg_replace("/2B2 Bv2/","<229>",$alg);   $alg = preg_replace("/2B' Bv/","<230>",$alg); $alg = preg_replace("/2B- Bv/","<230>",$alg);
      $alg = preg_replace("/2U Uv'/","<231>",$alg); $alg = preg_replace("/2U Uv-/","<231>",$alg);     $alg = preg_replace("/2U2 Uv2/","<232>",$alg);   $alg = preg_replace("/2U' Uv/","<233>",$alg); $alg = preg_replace("/2U- Uv/","<233>",$alg);
      $alg = preg_replace("/2D Dv'/","<234>",$alg); $alg = preg_replace("/2D Dv-/","<234>",$alg);     $alg = preg_replace("/2D2 Dv2/","<235>",$alg);   $alg = preg_replace("/2D' Dv/","<236>",$alg); $alg = preg_replace("/2D- Dv/","<236>",$alg);
      
      $alg = preg_replace("/4L' Rv'/","<219>",$alg); $alg = preg_replace("/4L- Rv-/","<219>",$alg);   $alg = preg_replace("/4L2 Rv2/","<220>",$alg);   $alg = preg_replace("/4L Rv/","<221>",$alg);
      $alg = preg_replace("/4R' Lv'/","<222>",$alg); $alg = preg_replace("/4R- Lv-/","<222>",$alg);   $alg = preg_replace("/4R2 Lv2/","<223>",$alg);   $alg = preg_replace("/4R Lv/","<224>",$alg);
      $alg = preg_replace("/4B' Fv'/","<225>",$alg); $alg = preg_replace("/4B- Fv-/","<225>",$alg);   $alg = preg_replace("/4B2 Fv2/","<226>",$alg);   $alg = preg_replace("/4B Fv/","<227>",$alg);
      $alg = preg_replace("/4F' Bv'/","<228>",$alg); $alg = preg_replace("/4F- Bv-/","<228>",$alg);   $alg = preg_replace("/4F2 Bv2/","<229>",$alg);   $alg = preg_replace("/4F Bv/","<230>",$alg);
      $alg = preg_replace("/4D' Uv'/","<231>",$alg); $alg = preg_replace("/4D- Uv-/","<231>",$alg);   $alg = preg_replace("/4D2 Uv2/","<232>",$alg);   $alg = preg_replace("/4D Uv/","<233>",$alg);
      $alg = preg_replace("/4U' Dv'/","<234>",$alg); $alg = preg_replace("/4U- Dv-/","<234>",$alg);   $alg = preg_replace("/4U2 Dv2/","<235>",$alg);   $alg = preg_replace("/4U Dv/","<236>",$alg);
      
      $alg = preg_replace("/3r L'/","<222>",$alg); $alg = preg_replace("/3r L-/","<222>",$alg);   $alg = preg_replace("/3r2 L2/","<223>",$alg);   $alg = preg_replace("/3r' L/","<224>",$alg); $alg = preg_replace("/3r- L/","<224>",$alg);
      $alg = preg_replace("/3l R'/","<219>",$alg); $alg = preg_replace("/3l R-/","<219>",$alg);   $alg = preg_replace("/3l2 R2/","<220>",$alg);   $alg = preg_replace("/3l' R/","<221>",$alg); $alg = preg_replace("/3l- R/","<221>",$alg);
      $alg = preg_replace("/3f B'/","<228>",$alg); $alg = preg_replace("/3f B-/","<228>",$alg);   $alg = preg_replace("/3f2 B2/","<229>",$alg);   $alg = preg_replace("/3f' B/","<230>",$alg); $alg = preg_replace("/3f- B/","<230>",$alg);
      $alg = preg_replace("/3b F'/","<225>",$alg); $alg = preg_replace("/3b F-/","<225>",$alg);   $alg = preg_replace("/3b2 F2/","<226>",$alg);   $alg = preg_replace("/3b' F/","<227>",$alg); $alg = preg_replace("/3b- F/","<227>",$alg);
      $alg = preg_replace("/3u D'/","<234>",$alg); $alg = preg_replace("/3u D-/","<234>",$alg);   $alg = preg_replace("/3u2 D2/","<235>",$alg);   $alg = preg_replace("/3u' D/","<236>",$alg); $alg = preg_replace("/3u- D/","<236>",$alg);
      $alg = preg_replace("/3d U'/","<231>",$alg); $alg = preg_replace("/3d U-/","<231>",$alg);   $alg = preg_replace("/3d2 U2/","<232>",$alg);   $alg = preg_replace("/3d' U/","<233>",$alg); $alg = preg_replace("/3d- U/","<233>",$alg);
    }
    
    /* --- 5xC: TWIZZLE -> CODE: [3] Tier twists (WCA) --- */
    /* T4 */
    $alg = preg_replace("/4Rw'/","<301>",$alg); $alg = preg_replace("/4Rw2/","<302>",$alg); $alg = preg_replace("/4Rw/","<303>",$alg);
    $alg = preg_replace("/4Lw'/","<304>",$alg); $alg = preg_replace("/4Lw2/","<305>",$alg); $alg = preg_replace("/4Lw/","<306>",$alg);
    $alg = preg_replace("/4Fw'/","<307>",$alg); $alg = preg_replace("/4Fw2/","<308>",$alg); $alg = preg_replace("/4Fw/","<309>",$alg);
    $alg = preg_replace("/4Bw'/","<310>",$alg); $alg = preg_replace("/4Bw2/","<311>",$alg); $alg = preg_replace("/4Bw/","<312>",$alg);
    $alg = preg_replace("/4Uw'/","<313>",$alg); $alg = preg_replace("/4Uw2/","<314>",$alg); $alg = preg_replace("/4Uw/","<315>",$alg);
    $alg = preg_replace("/4Dw'/","<316>",$alg); $alg = preg_replace("/4Dw2/","<317>",$alg); $alg = preg_replace("/4Dw/","<318>",$alg);
    
    
    /* T3 */
    $alg = preg_replace("/3Rw'/","<319>",$alg); $alg = preg_replace("/3Rw2/","<320>",$alg); $alg = preg_replace("/3Rw/","<321>",$alg);
    $alg = preg_replace("/3Lw'/","<322>",$alg); $alg = preg_replace("/3Lw2/","<323>",$alg); $alg = preg_replace("/3Lw/","<324>",$alg);
    $alg = preg_replace("/3Fw'/","<325>",$alg); $alg = preg_replace("/3Fw2/","<326>",$alg); $alg = preg_replace("/3Fw/","<327>",$alg);
    $alg = preg_replace("/3Bw'/","<328>",$alg); $alg = preg_replace("/3Bw2/","<329>",$alg); $alg = preg_replace("/3Bw/","<330>",$alg);
    $alg = preg_replace("/3Uw'/","<331>",$alg); $alg = preg_replace("/3Uw2/","<332>",$alg); $alg = preg_replace("/3Uw/","<333>",$alg);
    $alg = preg_replace("/3Dw'/","<334>",$alg); $alg = preg_replace("/3Dw2/","<335>",$alg); $alg = preg_replace("/3Dw/","<336>",$alg);
    
    /* --- 5xC: TWIZZLE -> CODE: [1] Numbered layer [5] (Mid-layer) twists --- */
    /* N | N4 */
    $alg = preg_replace("/2R'/","<101>",$alg); $alg = preg_replace("/2R2/","<102>",$alg); $alg = preg_replace("/2R/","<103>",$alg);
    $alg = preg_replace("/2L'/","<104>",$alg); $alg = preg_replace("/2L2/","<105>",$alg); $alg = preg_replace("/2L/","<106>",$alg);
    $alg = preg_replace("/2F'/","<107>",$alg); $alg = preg_replace("/2F2/","<108>",$alg); $alg = preg_replace("/2F/","<109>",$alg);
    $alg = preg_replace("/2B'/","<110>",$alg); $alg = preg_replace("/2B2/","<111>",$alg); $alg = preg_replace("/2B/","<112>",$alg);
    $alg = preg_replace("/2U'/","<113>",$alg); $alg = preg_replace("/2U2/","<114>",$alg); $alg = preg_replace("/2U/","<115>",$alg);
    $alg = preg_replace("/2D'/","<116>",$alg); $alg = preg_replace("/2D2/","<117>",$alg); $alg = preg_replace("/2D/","<118>",$alg);
    
    $alg = preg_replace("/4R'/","<106>",$alg); $alg = preg_replace("/4R2/","<105>",$alg); $alg = preg_replace("/4R/","<104>",$alg);
    $alg = preg_replace("/4L'/","<103>",$alg); $alg = preg_replace("/4L2/","<102>",$alg); $alg = preg_replace("/4L/","<101>",$alg);
    $alg = preg_replace("/4F'/","<112>",$alg); $alg = preg_replace("/4F2/","<111>",$alg); $alg = preg_replace("/4F/","<110>",$alg);
    $alg = preg_replace("/4B'/","<109>",$alg); $alg = preg_replace("/4B2/","<108>",$alg); $alg = preg_replace("/4B/","<107>",$alg);
    $alg = preg_replace("/4U'/","<118>",$alg); $alg = preg_replace("/4U2/","<117>",$alg); $alg = preg_replace("/4U/","<116>",$alg);
    $alg = preg_replace("/4D'/","<115>",$alg); $alg = preg_replace("/4D2/","<114>",$alg); $alg = preg_replace("/4D/","<113>",$alg);
    
    
    /* N3 = M */
    $alg = preg_replace("/3R'/","<119>",$alg); $alg = preg_replace("/3R2/","<120>",$alg); $alg = preg_replace("/3R/","<121>",$alg);
    $alg = preg_replace("/3L'/","<121>",$alg); $alg = preg_replace("/3L2/","<120>",$alg); $alg = preg_replace("/3L/","<119>",$alg);
    $alg = preg_replace("/3F'/","<122>",$alg); $alg = preg_replace("/3F2/","<123>",$alg); $alg = preg_replace("/3F/","<124>",$alg);
    $alg = preg_replace("/3B'/","<124>",$alg); $alg = preg_replace("/3B2/","<123>",$alg); $alg = preg_replace("/3B/","<122>",$alg);
    $alg = preg_replace("/3U'/","<125>",$alg); $alg = preg_replace("/3U2/","<126>",$alg); $alg = preg_replace("/3U/","<127>",$alg);
    $alg = preg_replace("/3D'/","<127>",$alg); $alg = preg_replace("/3D2/","<126>",$alg); $alg = preg_replace("/3D/","<125>",$alg);
    
    /* --- 5xC: TWIZZLE -> CODE: [9] Face twists --- */
    /*   */
    $alg = preg_replace("/1R'/","<901>",$alg); $alg = preg_replace("/1R2/","<902>",$alg); $alg = preg_replace("/1R/","<903>",$alg);
    $alg = preg_replace("/1L'/","<904>",$alg); $alg = preg_replace("/1L2/","<905>",$alg); $alg = preg_replace("/1L/","<906>",$alg);
    $alg = preg_replace("/1F'/","<907>",$alg); $alg = preg_replace("/1F2/","<908>",$alg); $alg = preg_replace("/1F/","<909>",$alg);
    $alg = preg_replace("/1B'/","<910>",$alg); $alg = preg_replace("/1B2/","<911>",$alg); $alg = preg_replace("/1B/","<912>",$alg);
    $alg = preg_replace("/1U'/","<913>",$alg); $alg = preg_replace("/1U2/","<914>",$alg); $alg = preg_replace("/1U/","<915>",$alg);
    $alg = preg_replace("/1D'/","<916>",$alg); $alg = preg_replace("/1D2/","<917>",$alg); $alg = preg_replace("/1D/","<918>",$alg);
    
    $alg = preg_replace("/5R'/","<906>",$alg); $alg = preg_replace("/5R2/","<905>",$alg); $alg = preg_replace("/5R/","<904>",$alg);
    $alg = preg_replace("/5L'/","<903>",$alg); $alg = preg_replace("/5L2/","<902>",$alg); $alg = preg_replace("/5L/","<901>",$alg);
    $alg = preg_replace("/5F'/","<912>",$alg); $alg = preg_replace("/5F2/","<911>",$alg); $alg = preg_replace("/5F/","<910>",$alg);
    $alg = preg_replace("/5B'/","<909>",$alg); $alg = preg_replace("/5B2/","<908>",$alg); $alg = preg_replace("/5B/","<907>",$alg);
    $alg = preg_replace("/5U'/","<918>",$alg); $alg = preg_replace("/5U2/","<917>",$alg); $alg = preg_replace("/5U/","<916>",$alg);
    $alg = preg_replace("/5D'/","<915>",$alg); $alg = preg_replace("/5D2/","<914>",$alg); $alg = preg_replace("/5D/","<913>",$alg);
    
    /* --- 5xC: TWIZZLE -> CODE: [2] Slice twists --- */
    if ($optSSE == true) {
      /* S2-2 | S4-4 */
/* xxx   xxx */
      $alg = preg_replace("/R 3l'/","<221>",$alg); $alg = preg_replace("/R 3l-/","<221>",$alg);   $alg = preg_replace("/R2 3l2/","<220>",$alg);   $alg = preg_replace("/R' 3l/","<219>",$alg); $alg = preg_replace("/R- 3l/","<219>",$alg);
      $alg = preg_replace("/L 3r'/","<224>",$alg); $alg = preg_replace("/L 3r-/","<224>",$alg);   $alg = preg_replace("/L2 3r2/","<223>",$alg);   $alg = preg_replace("/L' 3r/","<222>",$alg); $alg = preg_replace("/L- 3r/","<222>",$alg);
      $alg = preg_replace("/F 3b'/","<227>",$alg); $alg = preg_replace("/F 3b-/","<227>",$alg);   $alg = preg_replace("/F2 3b2/","<226>",$alg);   $alg = preg_replace("/F' 3b/","<225>",$alg); $alg = preg_replace("/F- 3b/","<225>",$alg);
      $alg = preg_replace("/B 3f'/","<230>",$alg); $alg = preg_replace("/B 3f-/","<230>",$alg);   $alg = preg_replace("/B2 3f2/","<229>",$alg);   $alg = preg_replace("/B' 3f/","<228>",$alg); $alg = preg_replace("/B- 3f/","<228>",$alg);
      $alg = preg_replace("/U 3d'/","<233>",$alg); $alg = preg_replace("/U 3d-/","<233>",$alg);   $alg = preg_replace("/U2 3d2/","<232>",$alg);   $alg = preg_replace("/U' 3d/","<231>",$alg); $alg = preg_replace("/U- 3d/","<231>",$alg);
      $alg = preg_replace("/D 3u'/","<236>",$alg); $alg = preg_replace("/D 3u-/","<236>",$alg);   $alg = preg_replace("/D2 3u2/","<235>",$alg);   $alg = preg_replace("/D' 3u/","<234>",$alg); $alg = preg_replace("/D- 3u/","<234>",$alg);
    }
    
    /* --- 5xC: TWIZZLE -> CODE: [3] Tier twists (SiGN) --- */
    /* T4 */
    $alg = preg_replace("/4r'/","<301>",$alg); $alg = preg_replace("/4r2/","<302>",$alg); $alg = preg_replace("/4r/","<303>",$alg);
    $alg = preg_replace("/4l'/","<304>",$alg); $alg = preg_replace("/4l2/","<305>",$alg); $alg = preg_replace("/4l/","<306>",$alg);
    $alg = preg_replace("/4f'/","<307>",$alg); $alg = preg_replace("/4f2/","<308>",$alg); $alg = preg_replace("/4f/","<309>",$alg);
    $alg = preg_replace("/4b'/","<310>",$alg); $alg = preg_replace("/4b2/","<311>",$alg); $alg = preg_replace("/4b/","<312>",$alg);
    $alg = preg_replace("/4u'/","<313>",$alg); $alg = preg_replace("/4u2/","<314>",$alg); $alg = preg_replace("/4u/","<315>",$alg);
    $alg = preg_replace("/4d'/","<316>",$alg); $alg = preg_replace("/4d2/","<317>",$alg); $alg = preg_replace("/4d/","<318>",$alg);
    
    
    /* T3 */
    $alg = preg_replace("/3r'/","<319>",$alg); $alg = preg_replace("/3r2/","<320>",$alg); $alg = preg_replace("/3r/","<321>",$alg);
    $alg = preg_replace("/3l'/","<322>",$alg); $alg = preg_replace("/3l2/","<323>",$alg); $alg = preg_replace("/3l/","<324>",$alg);
    $alg = preg_replace("/3f'/","<325>",$alg); $alg = preg_replace("/3f2/","<326>",$alg); $alg = preg_replace("/3f/","<327>",$alg);
    $alg = preg_replace("/3b'/","<328>",$alg); $alg = preg_replace("/3b2/","<329>",$alg); $alg = preg_replace("/3b/","<330>",$alg);
    $alg = preg_replace("/3u'/","<331>",$alg); $alg = preg_replace("/3u2/","<332>",$alg); $alg = preg_replace("/3u/","<333>",$alg);
    $alg = preg_replace("/3d'/","<334>",$alg); $alg = preg_replace("/3d2/","<335>",$alg); $alg = preg_replace("/3d/","<336>",$alg);
    
    /* --- 5xC: TWIZZLE -> CODE: [2] Slice twists --- */
    if ($optSSE == true) {
      /* S2 = S3-3 */
      $alg = preg_replace("/Rw Lw'/","<203>",$alg); $alg = preg_replace("/Rw Lw-/","<203>",$alg);   $alg = preg_replace("/Rw2 Lw2/","<202>",$alg);   $alg = preg_replace("/Rw' Lw/","<201>",$alg); $alg = preg_replace("/Rw- Lw/","<201>",$alg);
      $alg = preg_replace("/Lw Rw'/","<201>",$alg); $alg = preg_replace("/Lw Rw-/","<201>",$alg);   $alg = preg_replace("/Lw2 Rw2/","<202>",$alg);   $alg = preg_replace("/Lw' Rw/","<203>",$alg); $alg = preg_replace("/Lw- Rw/","<203>",$alg);
      $alg = preg_replace("/Fw Bw'/","<206>",$alg); $alg = preg_replace("/Fw Bw-/","<206>",$alg);   $alg = preg_replace("/Fw2 Bw2/","<205>",$alg);   $alg = preg_replace("/Fw' Bw/","<204>",$alg); $alg = preg_replace("/Fw- Bw/","<204>",$alg);
      $alg = preg_replace("/Bw Fw'/","<204>",$alg); $alg = preg_replace("/Bw Fw-/","<204>",$alg);   $alg = preg_replace("/Bw2 Fw2/","<205>",$alg);   $alg = preg_replace("/Bw' Fw/","<206>",$alg); $alg = preg_replace("/Bw- Fw/","<206>",$alg);
      $alg = preg_replace("/Uw Dw'/","<209>",$alg); $alg = preg_replace("/Uw Dw-/","<209>",$alg);   $alg = preg_replace("/Uw2 Dw2/","<208>",$alg);   $alg = preg_replace("/Uw' Dw/","<207>",$alg); $alg = preg_replace("/Uw- Dw/","<207>",$alg);
      $alg = preg_replace("/Dw Uw'/","<207>",$alg); $alg = preg_replace("/Dw Uw-/","<207>",$alg);   $alg = preg_replace("/Dw2 Uw2/","<208>",$alg);   $alg = preg_replace("/Dw' Uw/","<209>",$alg); $alg = preg_replace("/Dw- Uw/","<209>",$alg);
      
      $alg = preg_replace("/M' Rv'/","<201>",$alg); $alg = preg_replace("/M- Rv-/","<201>",$alg);   $alg = preg_replace("/M2 Rv2/","<202>",$alg);    $alg = preg_replace("/M Rv/", "<203>",$alg);
      $alg = preg_replace("/M Lv'/", "<203>",$alg); $alg = preg_replace("/M Lv-/", "<203>",$alg);   $alg = preg_replace("/M2 Lv2/","<202>",$alg);    $alg = preg_replace("/M' Lv/","<201>",$alg); $alg = preg_replace("/M- Lv/","<201>",$alg);
      $alg = preg_replace("/S Fv'/", "<204>",$alg); $alg = preg_replace("/S Fv-/", "<204>",$alg);   $alg = preg_replace("/S2 Fv2/","<205>",$alg);    $alg = preg_replace("/S' Fv/","<206>",$alg); $alg = preg_replace("/S- Fv/","<206>",$alg);
      $alg = preg_replace("/S' Bv'/","<206>",$alg); $alg = preg_replace("/S- Bv-/","<206>",$alg);   $alg = preg_replace("/S2 Bv2/","<205>",$alg);    $alg = preg_replace("/S Bv/", "<204>",$alg);
      $alg = preg_replace("/E' Uv'/","<207>",$alg); $alg = preg_replace("/E- Uv-/","<207>",$alg);   $alg = preg_replace("/E2 Uv2/","<208>",$alg);    $alg = preg_replace("/E Uv/", "<209>",$alg);
      $alg = preg_replace("/E Dv'/", "<209>",$alg); $alg = preg_replace("/E Dv-/", "<209>",$alg);   $alg = preg_replace("/E2 Dv2/","<208>",$alg);    $alg = preg_replace("/E' Dv/","<207>",$alg); $alg = preg_replace("/E' Dv/","<207>",$alg);
      
      $alg = preg_replace("/r l'/","<203>",$alg); $alg = preg_replace("/r l-/","<203>",$alg);       $alg = preg_replace("/r2 l2/","<202>",$alg);     $alg = preg_replace("/r' l/","<201>",$alg); $alg = preg_replace("/r- l/","<201>",$alg);
      $alg = preg_replace("/l r'/","<201>",$alg); $alg = preg_replace("/l r-/","<201>",$alg);       $alg = preg_replace("/l2 r2/","<202>",$alg);     $alg = preg_replace("/l' r/","<203>",$alg); $alg = preg_replace("/l- r/","<203>",$alg);
      $alg = preg_replace("/f b'/","<206>",$alg); $alg = preg_replace("/f b-/","<206>",$alg);       $alg = preg_replace("/f2 b2/","<205>",$alg);     $alg = preg_replace("/f' b/","<204>",$alg); $alg = preg_replace("/f- b/","<204>",$alg);
      $alg = preg_replace("/b f'/","<204>",$alg); $alg = preg_replace("/b f-/","<204>",$alg);       $alg = preg_replace("/b2 f2/","<205>",$alg);     $alg = preg_replace("/b' f/","<206>",$alg); $alg = preg_replace("/b- f/","<206>",$alg);
      $alg = preg_replace("/u d'/","<209>",$alg); $alg = preg_replace("/u d-/","<209>",$alg);       $alg = preg_replace("/u2 d2/","<208>",$alg);     $alg = preg_replace("/u' d/","<207>",$alg); $alg = preg_replace("/u- d/","<207>",$alg);
      $alg = preg_replace("/d u'/","<207>",$alg); $alg = preg_replace("/d u-/","<207>",$alg);       $alg = preg_replace("/d2 u2/","<208>",$alg);     $alg = preg_replace("/d' u/","<209>",$alg); $alg = preg_replace("/d- u/","<209>",$alg);
      
      
      /* Non-slice-twists */
      $alg = preg_replace("/R' L'/","<255>",$alg);
      $alg = preg_replace("/L' R'/","<255>",$alg);
      $alg = preg_replace("/F' B'/","<256>",$alg);
      $alg = preg_replace("/B' F'/","<256>",$alg);
      $alg = preg_replace("/U' D'/","<257>",$alg);
      $alg = preg_replace("/D' U'/","<257>",$alg);
      
      /* S = S2-4 */
      $alg = preg_replace("/R L'/","<212>",$alg); $alg = preg_replace("/R L-/","<212>",$alg);   $alg = preg_replace("/R2 L2/","<211>",$alg);   $alg = preg_replace("/R' L/","<210>",$alg); $alg = preg_replace("/R- L/","<210>",$alg);
      $alg = preg_replace("/L R'/","<210>",$alg); $alg = preg_replace("/L R-/","<210>",$alg);   $alg = preg_replace("/L2 R2/","<211>",$alg);   $alg = preg_replace("/L' R/","<212>",$alg); $alg = preg_replace("/L- R/","<212>",$alg);
      $alg = preg_replace("/F B'/","<215>",$alg); $alg = preg_replace("/F B-/","<215>",$alg);   $alg = preg_replace("/F2 B2/","<214>",$alg);   $alg = preg_replace("/F' B/","<213>",$alg); $alg = preg_replace("/F- B/","<213>",$alg);
      $alg = preg_replace("/B F'/","<213>",$alg); $alg = preg_replace("/B F-/","<213>",$alg);   $alg = preg_replace("/B2 F2/","<214>",$alg);   $alg = preg_replace("/B' F/","<215>",$alg); $alg = preg_replace("/B- F/","<215>",$alg);
      $alg = preg_replace("/U D'/","<218>",$alg); $alg = preg_replace("/U D-/","<218>",$alg);   $alg = preg_replace("/U2 D2/","<217>",$alg);   $alg = preg_replace("/U' D/","<216>",$alg); $alg = preg_replace("/U- D/","<216>",$alg);
      $alg = preg_replace("/D U'/","<216>",$alg); $alg = preg_replace("/D U-/","<216>",$alg);   $alg = preg_replace("/D2 U2/","<217>",$alg);   $alg = preg_replace("/D' U/","<218>",$alg); $alg = preg_replace("/D- U/","<218>",$alg);
      
      /* S2-2 | S4-4 */
      
      /* S2-3 | S3-4 */
/* xxx   xxx */
      $alg = preg_replace("/R l'/","<239>",$alg); $alg = preg_replace("/R l-/","<239>",$alg);   $alg = preg_replace("/R2 l2/","<238>",$alg);   $alg = preg_replace("/R' l/","<237>",$alg); $alg = preg_replace("/R- l/","<237>",$alg);
      $alg = preg_replace("/L r'/","<242>",$alg); $alg = preg_replace("/L r-/","<242>",$alg);   $alg = preg_replace("/L2 r2/","<241>",$alg);   $alg = preg_replace("/L' r/","<240>",$alg); $alg = preg_replace("/L- r/","<240>",$alg);
      $alg = preg_replace("/F b'/","<246>",$alg); $alg = preg_replace("/F b-/","<245>",$alg);   $alg = preg_replace("/F2 b2/","<244>",$alg);   $alg = preg_replace("/F' b/","<243>",$alg); $alg = preg_replace("/F- b/","<243>",$alg);
      $alg = preg_replace("/B f'/","<248>",$alg); $alg = preg_replace("/B f-/","<248>",$alg);   $alg = preg_replace("/B2 f2/","<247>",$alg);   $alg = preg_replace("/B' f/","<246>",$alg); $alg = preg_replace("/B- f/","<246>",$alg);
      $alg = preg_replace("/U d'/","<251>",$alg); $alg = preg_replace("/U d-/","<251>",$alg);   $alg = preg_replace("/U2 d2/","<250>",$alg);   $alg = preg_replace("/U' d/","<249>",$alg); $alg = preg_replace("/U- d/","<249>",$alg);
      $alg = preg_replace("/D u'/","<254>",$alg); $alg = preg_replace("/D u-/","<254>",$alg);   $alg = preg_replace("/D2 u2/","<253>",$alg);   $alg = preg_replace("/D' u/","<252>",$alg); $alg = preg_replace("/D- u/","<252>",$alg);
      
      $alg = preg_replace("/r L'/","<240>",$alg); $alg = preg_replace("/r L-/","<240>",$alg);   $alg = preg_replace("/r2 L2/","<241>",$alg);   $alg = preg_replace("/r' L/","<242>",$alg); $alg = preg_replace("/r- L/","<242>",$alg);
      $alg = preg_replace("/l R'/","<237>",$alg); $alg = preg_replace("/l R-/","<237>",$alg);   $alg = preg_replace("/l2 R2/","<238>",$alg);   $alg = preg_replace("/l' R/","<239>",$alg); $alg = preg_replace("/l- R/","<239>",$alg);
      $alg = preg_replace("/f B'/","<246>",$alg); $alg = preg_replace("/f B-/","<246>",$alg);   $alg = preg_replace("/f2 B2/","<247>",$alg);   $alg = preg_replace("/f' B/","<248>",$alg); $alg = preg_replace("/f- B/","<248>",$alg);
      $alg = preg_replace("/b F'/","<243>",$alg); $alg = preg_replace("/b F-/","<243>",$alg);   $alg = preg_replace("/b2 F2/","<244>",$alg);   $alg = preg_replace("/b' F/","<245>",$alg); $alg = preg_replace("/b- F/","<245>",$alg);
      $alg = preg_replace("/u D'/","<252>",$alg); $alg = preg_replace("/u D-/","<252>",$alg);   $alg = preg_replace("/u2 D2/","<253>",$alg);   $alg = preg_replace("/u' D/","<254>",$alg); $alg = preg_replace("/u- D/","<254>",$alg);
      $alg = preg_replace("/d U'/","<249>",$alg); $alg = preg_replace("/d U-/","<249>",$alg);   $alg = preg_replace("/d2 U2/","<250>",$alg);   $alg = preg_replace("/d' U/","<251>",$alg); $alg = preg_replace("/d- U/","<251>",$alg);
    }
    
    /* --- 5xC: TWIZZLE -> CODE: [3] Tier twists (WCA) --- */
    /* T */
    $alg = preg_replace("/Rw'/","<337>",$alg); $alg = preg_replace("/Rw2/","<338>",$alg); $alg = preg_replace("/Rw/","<339>",$alg);
    $alg = preg_replace("/Lw'/","<340>",$alg); $alg = preg_replace("/Lw2/","<341>",$alg); $alg = preg_replace("/Lw/","<342>",$alg);
    $alg = preg_replace("/Fw'/","<343>",$alg); $alg = preg_replace("/Fw2/","<344>",$alg); $alg = preg_replace("/Fw/","<345>",$alg);
    $alg = preg_replace("/Bw'/","<346>",$alg); $alg = preg_replace("/Bw2/","<347>",$alg); $alg = preg_replace("/Bw/","<348>",$alg);
    $alg = preg_replace("/Uw'/","<349>",$alg); $alg = preg_replace("/Uw2/","<350>",$alg); $alg = preg_replace("/Uw/","<351>",$alg);
    $alg = preg_replace("/Dw'/","<352>",$alg); $alg = preg_replace("/Dw2/","<353>",$alg); $alg = preg_replace("/Dw/","<354>",$alg);
    
    /* --- 5xC: TWIZZLE -> CODE: [7] Cube rotations --- */
    /* C */
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
    /* M */
    $alg = preg_replace("/M'/","<121>",$alg); $alg = preg_replace("/M2/","<120>",$alg); $alg = preg_replace("/M/","<119>",$alg);
    $alg = preg_replace("/S'/","<125>",$alg); $alg = preg_replace("/S2/","<126>",$alg); $alg = preg_replace("/S/","<127>",$alg);
    $alg = preg_replace("/E'/","<133>",$alg); $alg = preg_replace("/E2/","<132>",$alg); $alg = preg_replace("/E/","<131>",$alg);
    
    /* --- 5xC: TWIZZLE -> CODE: [9] Face twists --- */
    /*   */
    $alg = preg_replace("/R'/","<901>",$alg); $alg = preg_replace("/R2/","<902>",$alg); $alg = preg_replace("/R/","<903>",$alg);
    $alg = preg_replace("/L'/","<904>",$alg); $alg = preg_replace("/L2/","<905>",$alg); $alg = preg_replace("/L/","<906>",$alg);
    $alg = preg_replace("/F'/","<907>",$alg); $alg = preg_replace("/F2/","<908>",$alg); $alg = preg_replace("/F/","<909>",$alg);
    $alg = preg_replace("/B'/","<910>",$alg); $alg = preg_replace("/B2/","<911>",$alg); $alg = preg_replace("/B/","<912>",$alg);
    $alg = preg_replace("/U'/","<913>",$alg); $alg = preg_replace("/U2/","<914>",$alg); $alg = preg_replace("/U/","<915>",$alg);
    $alg = preg_replace("/D'/","<916>",$alg); $alg = preg_replace("/D2/","<917>",$alg); $alg = preg_replace("/D/","<918>",$alg);
    
    /* --- 5xC: TWIZZLE -> CODE: [3] Tier twists (SiGN) --- */
    /* T */
    $alg = preg_replace("/r'/","<337>",$alg); $alg = preg_replace("/r2/","<338>",$alg); $alg = preg_replace("/r/","<339>",$alg);
    $alg = preg_replace("/l'/","<340>",$alg); $alg = preg_replace("/l2/","<341>",$alg); $alg = preg_replace("/l/","<342>",$alg);
    $alg = preg_replace("/f'/","<343>",$alg); $alg = preg_replace("/f2/","<344>",$alg); $alg = preg_replace("/f/","<345>",$alg);
    $alg = preg_replace("/b'/","<346>",$alg); $alg = preg_replace("/b2/","<347>",$alg); $alg = preg_replace("/b/","<348>",$alg);
    $alg = preg_replace("/u'/","<349>",$alg); $alg = preg_replace("/u2/","<350>",$alg); $alg = preg_replace("/u/","<351>",$alg);
    $alg = preg_replace("/d'/","<352>",$alg); $alg = preg_replace("/d2/","<353>",$alg); $alg = preg_replace("/d/","<354>",$alg);
    
    /* ··································································································· */
    /* --- 5xC: CODE -> SSE opt: [2] Slice twists --- */
    if ($optSSE == true) {
      /* S2 = S3-3 */
      $alg = preg_replace("/<201>/","S2R'",$alg); $alg = preg_replace("/<202>/","S2R2",$alg); $alg = preg_replace("/<203>/","S2R",$alg);
      $alg = preg_replace("/<204>/","S2F'",$alg); $alg = preg_replace("/<205>/","S2F2",$alg); $alg = preg_replace("/<206>/","S2F",$alg);
      $alg = preg_replace("/<207>/","S2U'",$alg); $alg = preg_replace("/<208>/","S2U2",$alg); $alg = preg_replace("/<209>/","S2U",$alg);
      
      
      /* Non-slice-twists */
      $alg = preg_replace("/<255>/","R' L'",$alg);
      $alg = preg_replace("/<256>/","F' B'",$alg);
      $alg = preg_replace("/<257>/","U' D'",$alg);
      
      /* S = S2-4 */
      $alg = preg_replace("/<210>/","SR'",$alg); $alg = preg_replace("/<211>/","SR2",$alg); $alg = preg_replace("/<212>/","SR",$alg);
      $alg = preg_replace("/<213>/","SF'",$alg); $alg = preg_replace("/<214>/","SF2",$alg); $alg = preg_replace("/<215>/","SF",$alg);
      $alg = preg_replace("/<216>/","SU'",$alg); $alg = preg_replace("/<217>/","SU2",$alg); $alg = preg_replace("/<218>/","SU",$alg);
      
      
      /* S2-2 | S4-4 */
/* xxx   xxx */
      $alg = preg_replace("/<219>/","S2-2R'",$alg); $alg = preg_replace("/<220>/","S2-2R2",$alg); $alg = preg_replace("/<221>/","S2-2R",$alg);
      $alg = preg_replace("/<222>/","S2-2L'",$alg); $alg = preg_replace("/<223>/","S2-2L2",$alg); $alg = preg_replace("/<224>/","S2-2L",$alg);
      $alg = preg_replace("/<225>/","S2-2F'",$alg); $alg = preg_replace("/<226>/","S2-2F2",$alg); $alg = preg_replace("/<227>/","S2-2F",$alg);
      $alg = preg_replace("/<228>/","S2-2B'",$alg); $alg = preg_replace("/<229>/","S2-2B2",$alg); $alg = preg_replace("/<230>/","S2-2B",$alg);
      $alg = preg_replace("/<231>/","S2-2U'",$alg); $alg = preg_replace("/<232>/","S2-2U2",$alg); $alg = preg_replace("/<233>/","S2-2U",$alg);
      $alg = preg_replace("/<234>/","S2-2D'",$alg); $alg = preg_replace("/<235>/","S2-2D2",$alg); $alg = preg_replace("/<236>/","S2-2D",$alg);
      
      
      /* S2-3 | S3-4 */
/* xxx   xxx */
      $alg = preg_replace("/<237>/","S2-3R'",$alg); $alg = preg_replace("/<238>/","S2-3R2",$alg); $alg = preg_replace("/<239>/","S2-3R",$alg);
      $alg = preg_replace("/<240>/","S2-3L'",$alg); $alg = preg_replace("/<241>/","S2-3L2",$alg); $alg = preg_replace("/<242>/","S2-3L",$alg);
      $alg = preg_replace("/<243>/","S2-3F'",$alg); $alg = preg_replace("/<244>/","S2-3F2",$alg); $alg = preg_replace("/<245>/","S2-3F",$alg);
      $alg = preg_replace("/<246>/","S2-3B'",$alg); $alg = preg_replace("/<247>/","S2-3B2",$alg); $alg = preg_replace("/<248>/","S2-3B",$alg);
      $alg = preg_replace("/<249>/","S2-3U'",$alg); $alg = preg_replace("/<250>/","S2-3U2",$alg); $alg = preg_replace("/<251>/","S2-3U",$alg);
      $alg = preg_replace("/<252>/","S2-3D'",$alg); $alg = preg_replace("/<253>/","S2-3D2",$alg); $alg = preg_replace("/<254>/","S2-3D",$alg);
    }
    
    /* --- 5xC: CODE -> SSE: [6] Wide layer twists --- */
    /* W */
    $alg = preg_replace("/<601>/","WR'",$alg); $alg = preg_replace("/<602>/","WR2",$alg); $alg = preg_replace("/<603>/","WR",$alg);
    $alg = preg_replace("/<604>/","WF'",$alg); $alg = preg_replace("/<605>/","WF2",$alg); $alg = preg_replace("/<606>/","WF",$alg);
    $alg = preg_replace("/<607>/","WU'",$alg); $alg = preg_replace("/<608>/","WU2",$alg); $alg = preg_replace("/<609>/","WU",$alg);
    
    /* --- 5xC: CODE -> SSE: [4] Void twists --- */
    /* V */
    $alg = preg_replace("/<401>/","VR'",$alg); $alg = preg_replace("/<402>/","VR2",$alg); $alg = preg_replace("/<403>/","VR",$alg);
    $alg = preg_replace("/<404>/","VL'",$alg); $alg = preg_replace("/<405>/","VL2",$alg); $alg = preg_replace("/<406>/","VL",$alg);
    $alg = preg_replace("/<407>/","VF'",$alg); $alg = preg_replace("/<408>/","VF2",$alg); $alg = preg_replace("/<409>/","VF",$alg);
    $alg = preg_replace("/<410>/","VB'",$alg); $alg = preg_replace("/<411>/","VB2",$alg); $alg = preg_replace("/<412>/","VB",$alg);
    $alg = preg_replace("/<413>/","VU'",$alg); $alg = preg_replace("/<414>/","VU2",$alg); $alg = preg_replace("/<415>/","VU",$alg);
    $alg = preg_replace("/<416>/","VD'",$alg); $alg = preg_replace("/<417>/","VD2",$alg); $alg = preg_replace("/<418>/","VD",$alg);
    
    /* --- 5xC: CODE -> SSE: [1] Numbered layer [5] (Mid-layer) twists --- */
    /* N | N4 */
    $alg = preg_replace("/<101>/","NR'",$alg); $alg = preg_replace("/<102>/","NR2",$alg); $alg = preg_replace("/<103>/","NR",$alg);
    $alg = preg_replace("/<104>/","NL'",$alg); $alg = preg_replace("/<105>/","NL2",$alg); $alg = preg_replace("/<106>/","NL",$alg);
    $alg = preg_replace("/<107>/","NF'",$alg); $alg = preg_replace("/<108>/","NF2",$alg); $alg = preg_replace("/<109>/","NF",$alg);
    $alg = preg_replace("/<110>/","NB'",$alg); $alg = preg_replace("/<111>/","NB2",$alg); $alg = preg_replace("/<112>/","NB",$alg);
    $alg = preg_replace("/<113>/","NU'",$alg); $alg = preg_replace("/<114>/","NU2",$alg); $alg = preg_replace("/<115>/","NU",$alg);
    $alg = preg_replace("/<116>/","ND'",$alg); $alg = preg_replace("/<117>/","ND2",$alg); $alg = preg_replace("/<118>/","ND",$alg);
    
    
    /* N3 = M */
    $alg = preg_replace("/<119>/","MR'",$alg); $alg = preg_replace("/<120>/","MR2",$alg); $alg = preg_replace("/<121>/","MR",$alg);
    $alg = preg_replace("/<122>/","MF'",$alg); $alg = preg_replace("/<123>/","MF2",$alg); $alg = preg_replace("/<124>/","MF",$alg);
    $alg = preg_replace("/<125>/","MU'",$alg); $alg = preg_replace("/<126>/","MU2",$alg); $alg = preg_replace("/<127>/","MU",$alg);
    
    /* --- 5xC: CODE -> SSE: [3] Tier twists --- */
    /* T4 */
    $alg = preg_replace("/<301>/","T4R'",$alg); $alg = preg_replace("/<302>/","T4R2",$alg); $alg = preg_replace("/<303>/","T4R",$alg);
    $alg = preg_replace("/<304>/","T4L'",$alg); $alg = preg_replace("/<305>/","T4L2",$alg); $alg = preg_replace("/<306>/","T4L",$alg);
    $alg = preg_replace("/<307>/","T4F'",$alg); $alg = preg_replace("/<308>/","T4F2",$alg); $alg = preg_replace("/<309>/","T4F",$alg);
    $alg = preg_replace("/<310>/","T4B'",$alg); $alg = preg_replace("/<311>/","T4B2",$alg); $alg = preg_replace("/<312>/","T4B",$alg);
    $alg = preg_replace("/<313>/","T4U'",$alg); $alg = preg_replace("/<314>/","T4U2",$alg); $alg = preg_replace("/<315>/","T4U",$alg);
    $alg = preg_replace("/<316>/","T4D'",$alg); $alg = preg_replace("/<317>/","T4D2",$alg); $alg = preg_replace("/<318>/","T4D",$alg);
    
    /* T3 */
    $alg = preg_replace("/<319>/","T3R'",$alg); $alg = preg_replace("/<320>/","T3R2",$alg); $alg = preg_replace("/<321>/","T3R",$alg);
    $alg = preg_replace("/<322>/","T3L'",$alg); $alg = preg_replace("/<323>/","T3L2",$alg); $alg = preg_replace("/<324>/","T3L",$alg);
    $alg = preg_replace("/<325>/","T3F'",$alg); $alg = preg_replace("/<326>/","T3F2",$alg); $alg = preg_replace("/<327>/","T3F",$alg);
    $alg = preg_replace("/<328>/","T3B'",$alg); $alg = preg_replace("/<329>/","T3B2",$alg); $alg = preg_replace("/<330>/","T3B",$alg);
    $alg = preg_replace("/<331>/","T3U'",$alg); $alg = preg_replace("/<332>/","T3U2",$alg); $alg = preg_replace("/<333>/","T3U",$alg);
    $alg = preg_replace("/<334>/","T3D'",$alg); $alg = preg_replace("/<335>/","T3D2",$alg); $alg = preg_replace("/<336>/","T3D",$alg);
    
    
    /* T */
    $alg = preg_replace("/<337>/","TR'",$alg); $alg = preg_replace("/<338>/","TR2",$alg); $alg = preg_replace("/<339>/","TR",$alg);
    $alg = preg_replace("/<340>/","TL'",$alg); $alg = preg_replace("/<341>/","TL2",$alg); $alg = preg_replace("/<342>/","TL",$alg);
    $alg = preg_replace("/<343>/","TF'",$alg); $alg = preg_replace("/<344>/","TF2",$alg); $alg = preg_replace("/<345>/","TF",$alg);
    $alg = preg_replace("/<346>/","TB'",$alg); $alg = preg_replace("/<347>/","TB2",$alg); $alg = preg_replace("/<348>/","TB",$alg);
    $alg = preg_replace("/<349>/","TU'",$alg); $alg = preg_replace("/<350>/","TU2",$alg); $alg = preg_replace("/<351>/","TU",$alg);
    $alg = preg_replace("/<352>/","TD'",$alg); $alg = preg_replace("/<353>/","TD2",$alg); $alg = preg_replace("/<354>/","TD",$alg);
    
    /* --- 5xC: CODE -> SSE: [7] Cube rotations --- */
    /* C */
    $alg = preg_replace("/<701>/","CR'",$alg); $alg = preg_replace("/<702>/","CR2",$alg); $alg = preg_replace("/<703>/","CR",$alg);
    $alg = preg_replace("/<704>/","CF'",$alg); $alg = preg_replace("/<705>/","CF2",$alg); $alg = preg_replace("/<706>/","CF",$alg);
    $alg = preg_replace("/<707>/","CU'",$alg); $alg = preg_replace("/<708>/","CU2",$alg); $alg = preg_replace("/<709>/","CU",$alg);
    
    /* --- 5xC: CODE -> SSE: [9] Face twists --- */
    /*   */
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
    /* --- 6xC: SSE -> CODE: [1] Numbered-layer [5] Mid-layer twists --- */
    /* N | N5 */
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
    
    
    /* N3 = M | N4 = M */
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
    /* S2 = S3-4 */
    $alg = preg_replace("/S2R'/","<201>",$alg); $alg = preg_replace("/S2R-/","<201>",$alg);   $alg = preg_replace("/S2R2/","<202>",$alg);   $alg = preg_replace("/S2R/","<203>",$alg);
    $alg = preg_replace("/S2L'/","<203>",$alg); $alg = preg_replace("/S2L-/","<203>",$alg);   $alg = preg_replace("/S2L2/","<202>",$alg);   $alg = preg_replace("/S2L/","<201>",$alg);
    $alg = preg_replace("/S2F'/","<204>",$alg); $alg = preg_replace("/S2F-/","<204>",$alg);   $alg = preg_replace("/S2F2/","<205>",$alg);   $alg = preg_replace("/S2F/","<206>",$alg);
    $alg = preg_replace("/S2B'/","<206>",$alg); $alg = preg_replace("/S2B-/","<206>",$alg);   $alg = preg_replace("/S2B2/","<205>",$alg);   $alg = preg_replace("/S2B/","<204>",$alg);
    $alg = preg_replace("/S2U'/","<207>",$alg); $alg = preg_replace("/S2U-/","<207>",$alg);   $alg = preg_replace("/S2U2/","<208>",$alg);   $alg = preg_replace("/S2U/","<209>",$alg);
    $alg = preg_replace("/S2D'/","<209>",$alg); $alg = preg_replace("/S2D-/","<209>",$alg);   $alg = preg_replace("/S2D2/","<208>",$alg);   $alg = preg_replace("/S2D/","<207>",$alg);
    
    $alg = preg_replace("/S3-4R'/","<201>",$alg); $alg = preg_replace("/S3-4R-/","<201>",$alg);   $alg = preg_replace("/S3-4R2/","<202>",$alg);   $alg = preg_replace("/S3-4R/","<203>",$alg);
    $alg = preg_replace("/S3-4L'/","<203>",$alg); $alg = preg_replace("/S3-4L-/","<203>",$alg);   $alg = preg_replace("/S3-4L2/","<202>",$alg);   $alg = preg_replace("/S3-4L/","<201>",$alg);
    $alg = preg_replace("/S3-4F'/","<204>",$alg); $alg = preg_replace("/S3-4F-/","<204>",$alg);   $alg = preg_replace("/S3-4F2/","<205>",$alg);   $alg = preg_replace("/S3-4F/","<206>",$alg);
    $alg = preg_replace("/S3-4B'/","<206>",$alg); $alg = preg_replace("/S3-4B-/","<206>",$alg);   $alg = preg_replace("/S3-4B2/","<205>",$alg);   $alg = preg_replace("/S3-4B/","<204>",$alg);
    $alg = preg_replace("/S3-4U'/","<207>",$alg); $alg = preg_replace("/S3-4U-/","<207>",$alg);   $alg = preg_replace("/S3-4U2/","<208>",$alg);   $alg = preg_replace("/S3-4U/","<209>",$alg);
    $alg = preg_replace("/S3-4D'/","<209>",$alg); $alg = preg_replace("/S3-4D-/","<209>",$alg);   $alg = preg_replace("/S3-4D2/","<208>",$alg);   $alg = preg_replace("/S3-4D/","<207>",$alg);
    
    
    /* S = S2-5 */
    $alg = preg_replace("/SR'/","<210>",$alg); $alg = preg_replace("/SR-/","<210>",$alg);   $alg = preg_replace("/SR2/","<211>",$alg);   $alg = preg_replace("/SR/","<212>",$alg);
    $alg = preg_replace("/SL'/","<212>",$alg); $alg = preg_replace("/SL-/","<212>",$alg);   $alg = preg_replace("/SL2/","<211>",$alg);   $alg = preg_replace("/SL/","<210>",$alg);
    $alg = preg_replace("/SF'/","<213>",$alg); $alg = preg_replace("/SF-/","<213>",$alg);   $alg = preg_replace("/SF2/","<214>",$alg);   $alg = preg_replace("/SF/","<215>",$alg);
    $alg = preg_replace("/SB'/","<215>",$alg); $alg = preg_replace("/SB-/","<215>",$alg);   $alg = preg_replace("/SB2/","<214>",$alg);   $alg = preg_replace("/SB/","<213>",$alg);
    $alg = preg_replace("/SU'/","<216>",$alg); $alg = preg_replace("/SU-/","<216>",$alg);   $alg = preg_replace("/SU2/","<217>",$alg);   $alg = preg_replace("/SU/","<218>",$alg);
    $alg = preg_replace("/SD'/","<218>",$alg); $alg = preg_replace("/SD-/","<218>",$alg);   $alg = preg_replace("/SD2/","<217>",$alg);   $alg = preg_replace("/SD/","<216>",$alg);
    
    $alg = preg_replace("/S2-5R'/","<210>",$alg); $alg = preg_replace("/S2-5R-/","<210>",$alg);   $alg = preg_replace("/S2-5R2/","<211>",$alg);   $alg = preg_replace("/S2-5R/","<212>",$alg);
    $alg = preg_replace("/S2-5L'/","<212>",$alg); $alg = preg_replace("/S2-5L-/","<212>",$alg);   $alg = preg_replace("/S2-5L2/","<211>",$alg);   $alg = preg_replace("/S2-5L/","<210>",$alg);
    $alg = preg_replace("/S2-5F'/","<213>",$alg); $alg = preg_replace("/S2-5F-/","<213>",$alg);   $alg = preg_replace("/S2-5F2/","<214>",$alg);   $alg = preg_replace("/S2-5F/","<215>",$alg);
    $alg = preg_replace("/S2-5B'/","<215>",$alg); $alg = preg_replace("/S2-5B-/","<215>",$alg);   $alg = preg_replace("/S2-5B2/","<214>",$alg);   $alg = preg_replace("/S2-5B/","<213>",$alg);
    $alg = preg_replace("/S2-5U'/","<216>",$alg); $alg = preg_replace("/S2-5U-/","<216>",$alg);   $alg = preg_replace("/S2-5U2/","<217>",$alg);   $alg = preg_replace("/S2-5U/","<218>",$alg);
    $alg = preg_replace("/S2-5D'/","<218>",$alg); $alg = preg_replace("/S2-5D-/","<218>",$alg);   $alg = preg_replace("/S2-5D2/","<217>",$alg);   $alg = preg_replace("/S2-5D/","<216>",$alg);
    
    
    /* S2-2 | S5-5 */
    $alg = preg_replace("/S2-2R'/","<219>",$alg); $alg = preg_replace("/S2-2R-/","<219>",$alg);   $alg = preg_replace("/S2-2R2/","<220>",$alg);   $alg = preg_replace("/S2-2R/","<221>",$alg);
    $alg = preg_replace("/S2-2L'/","<222>",$alg); $alg = preg_replace("/S2-2L-/","<222>",$alg);   $alg = preg_replace("/S2-2L2/","<223>",$alg);   $alg = preg_replace("/S2-2L/","<224>",$alg);
    $alg = preg_replace("/S2-2F'/","<225>",$alg); $alg = preg_replace("/S2-2F-/","<225>",$alg);   $alg = preg_replace("/S2-2F2/","<226>",$alg);   $alg = preg_replace("/S2-2F/","<227>",$alg);
    $alg = preg_replace("/S2-2B'/","<228>",$alg); $alg = preg_replace("/S2-2B-/","<228>",$alg);   $alg = preg_replace("/S2-2B2/","<229>",$alg);   $alg = preg_replace("/S2-2B/","<230>",$alg);
    $alg = preg_replace("/S2-2U'/","<231>",$alg); $alg = preg_replace("/S2-2U-/","<231>",$alg);   $alg = preg_replace("/S2-2U2/","<232>",$alg);   $alg = preg_replace("/S2-2U/","<233>",$alg);
    $alg = preg_replace("/S2-2D'/","<234>",$alg); $alg = preg_replace("/S2-2D-/","<234>",$alg);   $alg = preg_replace("/S2-2D2/","<235>",$alg);   $alg = preg_replace("/S2-2D/","<236>",$alg);
    
    $alg = preg_replace("/S5-5R'/","<224>",$alg); $alg = preg_replace("/S5-5R-/","<224>",$alg);   $alg = preg_replace("/S5-5R2/","<223>",$alg);   $alg = preg_replace("/S5-5R/","<222>",$alg);
    $alg = preg_replace("/S5-5L'/","<221>",$alg); $alg = preg_replace("/S5-5L-/","<221>",$alg);   $alg = preg_replace("/S5-5L2/","<220>",$alg);   $alg = preg_replace("/S5-5L/","<219>",$alg);
    $alg = preg_replace("/S5-5F'/","<230>",$alg); $alg = preg_replace("/S5-5F-/","<230>",$alg);   $alg = preg_replace("/S5-5F2/","<229>",$alg);   $alg = preg_replace("/S5-5F/","<228>",$alg);
    $alg = preg_replace("/S5-5B'/","<227>",$alg); $alg = preg_replace("/S5-5B-/","<227>",$alg);   $alg = preg_replace("/S5-5B2/","<226>",$alg);   $alg = preg_replace("/S5-5B/","<225>",$alg);
    $alg = preg_replace("/S5-5U'/","<236>",$alg); $alg = preg_replace("/S5-5U-/","<236>",$alg);   $alg = preg_replace("/S5-5U2/","<235>",$alg);   $alg = preg_replace("/S5-5U/","<234>",$alg);
    $alg = preg_replace("/S5-5D'/","<233>",$alg); $alg = preg_replace("/S5-5D-/","<233>",$alg);   $alg = preg_replace("/S5-5D2/","<232>",$alg);   $alg = preg_replace("/S5-5D/","<231>",$alg);
    
    
    /* S2-3 | S4-5 */
    $alg = preg_replace("/S2-3R'/","<237>",$alg); $alg = preg_replace("/S2-3R-/","<237>",$alg);   $alg = preg_replace("/S2-3R2/","<238>",$alg);   $alg = preg_replace("/S2-3R/","<239>",$alg);
    $alg = preg_replace("/S2-3L'/","<240>",$alg); $alg = preg_replace("/S2-3L-/","<240>",$alg);   $alg = preg_replace("/S2-3L2/","<241>",$alg);   $alg = preg_replace("/S2-3L/","<242>",$alg);
    $alg = preg_replace("/S2-3F'/","<243>",$alg); $alg = preg_replace("/S2-3F-/","<243>",$alg);   $alg = preg_replace("/S2-3F2/","<244>",$alg);   $alg = preg_replace("/S2-3F/","<245>",$alg);
    $alg = preg_replace("/S2-3B'/","<246>",$alg); $alg = preg_replace("/S2-3B-/","<246>",$alg);   $alg = preg_replace("/S2-3B2/","<247>",$alg);   $alg = preg_replace("/S2-3B/","<248>",$alg);
    $alg = preg_replace("/S2-3U'/","<249>",$alg); $alg = preg_replace("/S2-3U-/","<249>",$alg);   $alg = preg_replace("/S2-3U2/","<250>",$alg);   $alg = preg_replace("/S2-3U/","<251>",$alg);
    $alg = preg_replace("/S2-3D'/","<252>",$alg); $alg = preg_replace("/S2-3D-/","<252>",$alg);   $alg = preg_replace("/S2-3D2/","<253>",$alg);   $alg = preg_replace("/S2-3D/","<254>",$alg);
    
    $alg = preg_replace("/S4-5R'/","<242>",$alg); $alg = preg_replace("/S4-5R-/","<242>",$alg);   $alg = preg_replace("/S4-5R2/","<241>",$alg);   $alg = preg_replace("/S4-5R/","<240>",$alg);
    $alg = preg_replace("/S4-5L'/","<239>",$alg); $alg = preg_replace("/S4-5L-/","<239>",$alg);   $alg = preg_replace("/S4-5L2/","<238>",$alg);   $alg = preg_replace("/S4-5L/","<237>",$alg);
    $alg = preg_replace("/S4-5F'/","<248>",$alg); $alg = preg_replace("/S4-5F-/","<248>",$alg);   $alg = preg_replace("/S4-5F2/","<247>",$alg);   $alg = preg_replace("/S4-5F/","<246>",$alg);
    $alg = preg_replace("/S4-5B'/","<245>",$alg); $alg = preg_replace("/S4-5B-/","<245>",$alg);   $alg = preg_replace("/S4-5B2/","<244>",$alg);   $alg = preg_replace("/S4-5B/","<243>",$alg);
    $alg = preg_replace("/S4-5U'/","<254>",$alg); $alg = preg_replace("/S4-5U-/","<254>",$alg);   $alg = preg_replace("/S4-5U2/","<253>",$alg);   $alg = preg_replace("/S4-5U/","<252>",$alg);
    $alg = preg_replace("/S4-5D'/","<251>",$alg); $alg = preg_replace("/S4-5D-/","<251>",$alg);   $alg = preg_replace("/S4-5D2/","<250>",$alg);   $alg = preg_replace("/S4-5D/","<249>",$alg);
    
    
    /* S2-4 | S3-5 */
    $alg = preg_replace("/S2-4R'/","<255>",$alg); $alg = preg_replace("/S2-4R-/","<255>",$alg);   $alg = preg_replace("/S2-4R2/","<256>",$alg);   $alg = preg_replace("/S2-4R/","<257>",$alg);
    $alg = preg_replace("/S2-4L'/","<258>",$alg); $alg = preg_replace("/S2-4L-/","<258>",$alg);   $alg = preg_replace("/S2-4L2/","<259>",$alg);   $alg = preg_replace("/S2-4L/","<260>",$alg);
    $alg = preg_replace("/S2-4F'/","<261>",$alg); $alg = preg_replace("/S2-4F-/","<261>",$alg);   $alg = preg_replace("/S2-4F2/","<262>",$alg);   $alg = preg_replace("/S2-4F/","<263>",$alg);
    $alg = preg_replace("/S2-4B'/","<264>",$alg); $alg = preg_replace("/S2-4B-/","<264>",$alg);   $alg = preg_replace("/S2-4B2/","<265>",$alg);   $alg = preg_replace("/S2-4B/","<266>",$alg);
    $alg = preg_replace("/S2-4U'/","<267>",$alg); $alg = preg_replace("/S2-4U-/","<267>",$alg);   $alg = preg_replace("/S2-4U2/","<268>",$alg);   $alg = preg_replace("/S2-4U/","<269>",$alg);
    $alg = preg_replace("/S2-4D'/","<270>",$alg); $alg = preg_replace("/S2-4D-/","<270>",$alg);   $alg = preg_replace("/S2-4D2/","<271>",$alg);   $alg = preg_replace("/S2-4D/","<272>",$alg);
    
    $alg = preg_replace("/S3-5R'/","<260>",$alg); $alg = preg_replace("/S3-5R-/","<260>",$alg);   $alg = preg_replace("/S3-5R2/","<259>",$alg);   $alg = preg_replace("/S3-5R/","<258>",$alg);
    $alg = preg_replace("/S3-5L'/","<257>",$alg); $alg = preg_replace("/S3-5L-/","<257>",$alg);   $alg = preg_replace("/S3-5L2/","<256>",$alg);   $alg = preg_replace("/S3-5L/","<255>",$alg);
    $alg = preg_replace("/S3-5F'/","<266>",$alg); $alg = preg_replace("/S3-5F-/","<266>",$alg);   $alg = preg_replace("/S3-5F2/","<265>",$alg);   $alg = preg_replace("/S3-5F/","<264>",$alg);
    $alg = preg_replace("/S3-5B'/","<263>",$alg); $alg = preg_replace("/S3-5B-/","<263>",$alg);   $alg = preg_replace("/S3-5B2/","<262>",$alg);   $alg = preg_replace("/S3-5B/","<261>",$alg);
    $alg = preg_replace("/S3-5U'/","<272>",$alg); $alg = preg_replace("/S3-5U-/","<272>",$alg);   $alg = preg_replace("/S3-5U2/","<271>",$alg);   $alg = preg_replace("/S3-5U/","<270>",$alg);
    $alg = preg_replace("/S3-5D'/","<269>",$alg); $alg = preg_replace("/S3-5D-/","<269>",$alg);   $alg = preg_replace("/S3-5D2/","<268>",$alg);   $alg = preg_replace("/S3-5D/","<267>",$alg);
    
    
    /* S3-3 | S4-4 */
    $alg = preg_replace("/S3-3R'/","<273>",$alg); $alg = preg_replace("/S3-3R-/","<273>",$alg);   $alg = preg_replace("/S3-3R2/","<274>",$alg);   $alg = preg_replace("/S3-3R/","<275>",$alg);
    $alg = preg_replace("/S3-3L'/","<276>",$alg); $alg = preg_replace("/S3-3L-/","<276>",$alg);   $alg = preg_replace("/S3-3L2/","<277>",$alg);   $alg = preg_replace("/S3-3L/","<278>",$alg);
    $alg = preg_replace("/S3-3F'/","<279>",$alg); $alg = preg_replace("/S3-3F-/","<279>",$alg);   $alg = preg_replace("/S3-3F2/","<280>",$alg);   $alg = preg_replace("/S3-3F/","<281>",$alg);
    $alg = preg_replace("/S3-3B'/","<282>",$alg); $alg = preg_replace("/S3-3B-/","<282>",$alg);   $alg = preg_replace("/S3-3B2/","<283>",$alg);   $alg = preg_replace("/S3-3B/","<284>",$alg);
    $alg = preg_replace("/S3-3U'/","<285>",$alg); $alg = preg_replace("/S3-3U-/","<285>",$alg);   $alg = preg_replace("/S3-3U2/","<286>",$alg);   $alg = preg_replace("/S3-3U/","<287>",$alg);
    $alg = preg_replace("/S3-3D'/","<288>",$alg); $alg = preg_replace("/S3-3D-/","<288>",$alg);   $alg = preg_replace("/S3-3D2/","<289>",$alg);   $alg = preg_replace("/S3-3D/","<290>",$alg);
    
    $alg = preg_replace("/S4-4R'/","<278>",$alg); $alg = preg_replace("/S4-4R-/","<278>",$alg);   $alg = preg_replace("/S4-4R2/","<277>",$alg);   $alg = preg_replace("/S4-4R/","<276>",$alg);
    $alg = preg_replace("/S4-4L'/","<275>",$alg); $alg = preg_replace("/S4-4L-/","<275>",$alg);   $alg = preg_replace("/S4-4L2/","<274>",$alg);   $alg = preg_replace("/S4-4L/","<273>",$alg);
    $alg = preg_replace("/S4-4F'/","<284>",$alg); $alg = preg_replace("/S4-4F-/","<284>",$alg);   $alg = preg_replace("/S4-4F2/","<283>",$alg);   $alg = preg_replace("/S4-4F/","<282>",$alg);
    $alg = preg_replace("/S4-4B'/","<281>",$alg); $alg = preg_replace("/S4-4B-/","<281>",$alg);   $alg = preg_replace("/S4-4B2/","<280>",$alg);   $alg = preg_replace("/S4-4B/","<279>",$alg);
    $alg = preg_replace("/S4-4U'/","<290>",$alg); $alg = preg_replace("/S4-4U-/","<290>",$alg);   $alg = preg_replace("/S4-4U2/","<289>",$alg);   $alg = preg_replace("/S4-4U/","<288>",$alg);
    $alg = preg_replace("/S4-4D'/","<287>",$alg); $alg = preg_replace("/S4-4D-/","<287>",$alg);   $alg = preg_replace("/S4-4D2/","<286>",$alg);   $alg = preg_replace("/S4-4D/","<285>",$alg);
    
    /* --- 6xC: SSE -> CODE: [3] Tier twists --- */
    /* T5 */
    $alg = preg_replace("/T5R'/","<301>",$alg); $alg = preg_replace("/T5R-/","<301>",$alg);   $alg = preg_replace("/T5R2/","<302>",$alg);   $alg = preg_replace("/T5R/","<303>",$alg);
    $alg = preg_replace("/T5L'/","<304>",$alg); $alg = preg_replace("/T5L-/","<304>",$alg);   $alg = preg_replace("/T5L2/","<305>",$alg);   $alg = preg_replace("/T5L/","<306>",$alg);
    $alg = preg_replace("/T5F'/","<307>",$alg); $alg = preg_replace("/T5F-/","<307>",$alg);   $alg = preg_replace("/T5F2/","<308>",$alg);   $alg = preg_replace("/T5F/","<309>",$alg);
    $alg = preg_replace("/T5B'/","<310>",$alg); $alg = preg_replace("/T5B-/","<310>",$alg);   $alg = preg_replace("/T5B2/","<311>",$alg);   $alg = preg_replace("/T5B/","<312>",$alg);
    $alg = preg_replace("/T5U'/","<313>",$alg); $alg = preg_replace("/T5U-/","<313>",$alg);   $alg = preg_replace("/T5U2/","<314>",$alg);   $alg = preg_replace("/T5U/","<315>",$alg);
    $alg = preg_replace("/T5D'/","<316>",$alg); $alg = preg_replace("/T5D-/","<316>",$alg);   $alg = preg_replace("/T5D2/","<317>",$alg);   $alg = preg_replace("/T5D/","<318>",$alg);
    
    
    /* T4 */
    $alg = preg_replace("/T4R'/","<319>",$alg); $alg = preg_replace("/T4R-/","<319>",$alg);   $alg = preg_replace("/T4R2/","<320>",$alg);   $alg = preg_replace("/T4R/","<321>",$alg);
    $alg = preg_replace("/T4L'/","<322>",$alg); $alg = preg_replace("/T4L-/","<322>",$alg);   $alg = preg_replace("/T4L2/","<323>",$alg);   $alg = preg_replace("/T4L/","<324>",$alg);
    $alg = preg_replace("/T4F'/","<325>",$alg); $alg = preg_replace("/T4F-/","<325>",$alg);   $alg = preg_replace("/T4F2/","<326>",$alg);   $alg = preg_replace("/T4F/","<327>",$alg);
    $alg = preg_replace("/T4B'/","<328>",$alg); $alg = preg_replace("/T4B-/","<328>",$alg);   $alg = preg_replace("/T4B2/","<329>",$alg);   $alg = preg_replace("/T4B/","<330>",$alg);
    $alg = preg_replace("/T4U'/","<331>",$alg); $alg = preg_replace("/T4U-/","<331>",$alg);   $alg = preg_replace("/T4U2/","<332>",$alg);   $alg = preg_replace("/T4U/","<333>",$alg);
    $alg = preg_replace("/T4D'/","<334>",$alg); $alg = preg_replace("/T4D-/","<334>",$alg);   $alg = preg_replace("/T4D2/","<335>",$alg);   $alg = preg_replace("/T4D/","<336>",$alg);
    
    
    /* T3 */
    $alg = preg_replace("/T3R'/","<337>",$alg); $alg = preg_replace("/T3R-/","<337>",$alg);   $alg = preg_replace("/T3R2/","<338>",$alg);   $alg = preg_replace("/T3R/","<339>",$alg);
    $alg = preg_replace("/T3L'/","<340>",$alg); $alg = preg_replace("/T3L-/","<340>",$alg);   $alg = preg_replace("/T3L2/","<341>",$alg);   $alg = preg_replace("/T3L/","<342>",$alg);
    $alg = preg_replace("/T3F'/","<343>",$alg); $alg = preg_replace("/T3F-/","<343>",$alg);   $alg = preg_replace("/T3F2/","<344>",$alg);   $alg = preg_replace("/T3F/","<345>",$alg);
    $alg = preg_replace("/T3B'/","<346>",$alg); $alg = preg_replace("/T3B-/","<346>",$alg);   $alg = preg_replace("/T3B2/","<347>",$alg);   $alg = preg_replace("/T3B/","<348>",$alg);
    $alg = preg_replace("/T3U'/","<349>",$alg); $alg = preg_replace("/T3U-/","<349>",$alg);   $alg = preg_replace("/T3U2/","<350>",$alg);   $alg = preg_replace("/T3U/","<351>",$alg);
    $alg = preg_replace("/T3D'/","<352>",$alg); $alg = preg_replace("/T3D-/","<352>",$alg);   $alg = preg_replace("/T3D2/","<353>",$alg);   $alg = preg_replace("/T3D/","<354>",$alg);
    
    
    /* T */
    $alg = preg_replace("/TR'/","<355>",$alg); $alg = preg_replace("/TR-/","<355>",$alg);   $alg = preg_replace("/TR2/","<356>",$alg);   $alg = preg_replace("/TR/","<357>",$alg);
    $alg = preg_replace("/TL'/","<358>",$alg); $alg = preg_replace("/TL-/","<358>",$alg);   $alg = preg_replace("/TL2/","<359>",$alg);   $alg = preg_replace("/TL/","<360>",$alg);
    $alg = preg_replace("/TF'/","<361>",$alg); $alg = preg_replace("/TF-/","<361>",$alg);   $alg = preg_replace("/TF2/","<362>",$alg);   $alg = preg_replace("/TF/","<363>",$alg);
    $alg = preg_replace("/TB'/","<364>",$alg); $alg = preg_replace("/TB-/","<364>",$alg);   $alg = preg_replace("/TB2/","<365>",$alg);   $alg = preg_replace("/TB/","<366>",$alg);
    $alg = preg_replace("/TU'/","<367>",$alg); $alg = preg_replace("/TU-/","<367>",$alg);   $alg = preg_replace("/TU2/","<368>",$alg);   $alg = preg_replace("/TU/","<369>",$alg);
    $alg = preg_replace("/TD'/","<370>",$alg); $alg = preg_replace("/TD-/","<370>",$alg);   $alg = preg_replace("/TD2/","<371>",$alg);   $alg = preg_replace("/TD/","<372>",$alg);
    
    /* --- 6xC: SSE -> CODE: [4] Void twists [1] Numbered layer twists--- */
    /* V3 = M3 = N2-4 | V3 = M3 = N3-5 */
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
    
    $alg = preg_replace("/N3-5R'/","<406>",$alg); $alg = preg_replace("/N3-5R-/","<406>",$alg);   $alg = preg_replace("/N3-5R2/","<405>",$alg);   $alg = preg_replace("/N3-5R/","<404>",$alg);
    $alg = preg_replace("/N3-5L'/","<403>",$alg); $alg = preg_replace("/N3-5L-/","<403>",$alg);   $alg = preg_replace("/N3-5L2/","<402>",$alg);   $alg = preg_replace("/N3-5L/","<401>",$alg);
    $alg = preg_replace("/N3-5F'/","<412>",$alg); $alg = preg_replace("/N3-5F-/","<412>",$alg);   $alg = preg_replace("/N3-5F2/","<411>",$alg);   $alg = preg_replace("/N3-5F/","<410>",$alg);
    $alg = preg_replace("/N3-5B'/","<409>",$alg); $alg = preg_replace("/N3-5B-/","<409>",$alg);   $alg = preg_replace("/N3-5B2/","<408>",$alg);   $alg = preg_replace("/N3-5B/","<407>",$alg);
    $alg = preg_replace("/N3-5U'/","<418>",$alg); $alg = preg_replace("/N3-5U-/","<418>",$alg);   $alg = preg_replace("/N3-5U2/","<417>",$alg);   $alg = preg_replace("/N3-5U/","<416>",$alg);
    $alg = preg_replace("/N3-5D'/","<415>",$alg); $alg = preg_replace("/N3-5D-/","<415>",$alg);   $alg = preg_replace("/N3-5D2/","<414>",$alg);   $alg = preg_replace("/N3-5D/","<413>",$alg);
    
    $alg = preg_replace("/M3R'/","<401>",$alg); $alg = preg_replace("/M3R-/","<401>",$alg);   $alg = preg_replace("/M3R2/","<402>",$alg);   $alg = preg_replace("/M3R/","<403>",$alg);
    $alg = preg_replace("/M3L'/","<404>",$alg); $alg = preg_replace("/M3L-/","<404>",$alg);   $alg = preg_replace("/M3L2/","<405>",$alg);   $alg = preg_replace("/M3L/","<406>",$alg);
    $alg = preg_replace("/M3F'/","<407>",$alg); $alg = preg_replace("/M3F-/","<407>",$alg);   $alg = preg_replace("/M3F2/","<408>",$alg);   $alg = preg_replace("/M3F/","<409>",$alg);
    $alg = preg_replace("/M3B'/","<410>",$alg); $alg = preg_replace("/M3B-/","<410>",$alg);   $alg = preg_replace("/M3B2/","<411>",$alg);   $alg = preg_replace("/M3B/","<412>",$alg);
    $alg = preg_replace("/M3U'/","<413>",$alg); $alg = preg_replace("/M3U-/","<413>",$alg);   $alg = preg_replace("/M3U2/","<414>",$alg);   $alg = preg_replace("/M3U/","<415>",$alg);
    $alg = preg_replace("/M3D'/","<416>",$alg); $alg = preg_replace("/M3D-/","<416>",$alg);   $alg = preg_replace("/M3D2/","<417>",$alg);   $alg = preg_replace("/M3D/","<418>",$alg);
    
    
    /* V = N2-3 | V = N4-5 */
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
    
    $alg = preg_replace("/N4-5R'/","<424>",$alg); $alg = preg_replace("/N4-5R-/","<424>",$alg);   $alg = preg_replace("/N4-5R2/","<423>",$alg);   $alg = preg_replace("/N4-5R/","<422>",$alg);
    $alg = preg_replace("/N4-5L'/","<421>",$alg); $alg = preg_replace("/N4-5L-/","<421>",$alg);   $alg = preg_replace("/N4-5L2/","<420>",$alg);   $alg = preg_replace("/N4-5L/","<419>",$alg);
    $alg = preg_replace("/N4-5F'/","<430>",$alg); $alg = preg_replace("/N4-5F-/","<430>",$alg);   $alg = preg_replace("/N4-5F2/","<429>",$alg);   $alg = preg_replace("/N4-5F/","<428>",$alg);
    $alg = preg_replace("/N4-5B'/","<427>",$alg); $alg = preg_replace("/N4-5B-/","<427>",$alg);   $alg = preg_replace("/N4-5B2/","<426>",$alg);   $alg = preg_replace("/N4-5B/","<425>",$alg);
    $alg = preg_replace("/N4-5U'/","<436>",$alg); $alg = preg_replace("/N4-5U-/","<436>",$alg);   $alg = preg_replace("/N4-5U2/","<435>",$alg);   $alg = preg_replace("/N4-5U/","<434>",$alg);
    $alg = preg_replace("/N4-5D'/","<433>",$alg); $alg = preg_replace("/N4-5D-/","<433>",$alg);   $alg = preg_replace("/N4-5D2/","<432>",$alg);   $alg = preg_replace("/N4-5D/","<431>",$alg);
    
    /* --- 6xC: SSE -> CODE: [5] Mid-layer twists [1] Numbered layer twists --- */
    /* M2 = N3-4 */
    $alg = preg_replace("/M2R'/","<501>",$alg); $alg = preg_replace("/M2R-/","<501>",$alg);   $alg = preg_replace("/M2R2/","<502>",$alg);   $alg = preg_replace("/M2R/","<503>",$alg);
    $alg = preg_replace("/M2L'/","<503>",$alg); $alg = preg_replace("/M2L-/","<503>",$alg);   $alg = preg_replace("/M2L2/","<502>",$alg);   $alg = preg_replace("/M2L/","<501>",$alg);
    $alg = preg_replace("/M2F'/","<504>",$alg); $alg = preg_replace("/M2F-/","<504>",$alg);   $alg = preg_replace("/M2F2/","<505>",$alg);   $alg = preg_replace("/M2F/","<506>",$alg);
    $alg = preg_replace("/M2B'/","<506>",$alg); $alg = preg_replace("/M2B-/","<506>",$alg);   $alg = preg_replace("/M2B2/","<505>",$alg);   $alg = preg_replace("/M2B/","<504>",$alg);
    $alg = preg_replace("/M2U'/","<507>",$alg); $alg = preg_replace("/M2U-/","<507>",$alg);   $alg = preg_replace("/M2U2/","<508>",$alg);   $alg = preg_replace("/M2U/","<509>",$alg);
    $alg = preg_replace("/M2D'/","<509>",$alg); $alg = preg_replace("/M2D-/","<509>",$alg);   $alg = preg_replace("/M2D2/","<508>",$alg);   $alg = preg_replace("/M2D/","<507>",$alg);
    
    $alg = preg_replace("/N3-4R'/","<501>",$alg); $alg = preg_replace("/N3-4R-/","<501>",$alg);   $alg = preg_replace("/N3-4R2/","<502>",$alg);   $alg = preg_replace("/N3-4R/","<503>",$alg);
    $alg = preg_replace("/N3-4L'/","<503>",$alg); $alg = preg_replace("/N3-4L-/","<503>",$alg);   $alg = preg_replace("/N3-4L2/","<502>",$alg);   $alg = preg_replace("/N3-4L/","<501>",$alg);
    $alg = preg_replace("/N3-4F'/","<504>",$alg); $alg = preg_replace("/N3-4F-/","<504>",$alg);   $alg = preg_replace("/N3-4F2/","<505>",$alg);   $alg = preg_replace("/N3-4F/","<506>",$alg);
    $alg = preg_replace("/N3-4B'/","<506>",$alg); $alg = preg_replace("/N3-4B-/","<506>",$alg);   $alg = preg_replace("/N3-4B2/","<505>",$alg);   $alg = preg_replace("/N3-4B/","<504>",$alg);
    $alg = preg_replace("/N3-4U'/","<507>",$alg); $alg = preg_replace("/N3-4U-/","<507>",$alg);   $alg = preg_replace("/N3-4U2/","<508>",$alg);   $alg = preg_replace("/N3-4U/","<509>",$alg);
    $alg = preg_replace("/N3-4D'/","<509>",$alg); $alg = preg_replace("/N3-4D-/","<509>",$alg);   $alg = preg_replace("/N3-4D2/","<508>",$alg);   $alg = preg_replace("/N3-4D/","<507>",$alg);
    
    /* --- 6xC: SSE -> CODE: [6] Wide-layer twists [5] (Mid-layer twists) [4] (Void twists) [1] Numbered layer twists --- */
    /* W = M4 = V4 = N2-5 */
    $alg = preg_replace("/WR'/","<601>",$alg); $alg = preg_replace("/WR-/","<601>",$alg);   $alg = preg_replace("/WR2/","<602>",$alg);   $alg = preg_replace("/WR/","<603>",$alg);
    $alg = preg_replace("/WL'/","<603>",$alg); $alg = preg_replace("/WL-/","<603>",$alg);   $alg = preg_replace("/WL2/","<602>",$alg);   $alg = preg_replace("/WL/","<601>",$alg);
    $alg = preg_replace("/WF'/","<604>",$alg); $alg = preg_replace("/WF-/","<604>",$alg);   $alg = preg_replace("/WF2/","<605>",$alg);   $alg = preg_replace("/WF/","<606>",$alg);
    $alg = preg_replace("/WB'/","<606>",$alg); $alg = preg_replace("/WB-/","<606>",$alg);   $alg = preg_replace("/WB2/","<605>",$alg);   $alg = preg_replace("/WB/","<604>",$alg);
    $alg = preg_replace("/WU'/","<607>",$alg); $alg = preg_replace("/WU-/","<607>",$alg);   $alg = preg_replace("/WU2/","<608>",$alg);   $alg = preg_replace("/WU/","<609>",$alg);
    $alg = preg_replace("/WD'/","<609>",$alg); $alg = preg_replace("/WD-/","<609>",$alg);   $alg = preg_replace("/WD2/","<608>",$alg);   $alg = preg_replace("/WD/","<607>",$alg);
    
    $alg = preg_replace("/M4R'/","<601>",$alg); $alg = preg_replace("/M4R-/","<601>",$alg);   $alg = preg_replace("/M4R2/","<602>",$alg);   $alg = preg_replace("/M4R/","<603>",$alg);
    $alg = preg_replace("/M4L'/","<603>",$alg); $alg = preg_replace("/M4L-/","<603>",$alg);   $alg = preg_replace("/M4L2/","<602>",$alg);   $alg = preg_replace("/M4L/","<601>",$alg);
    $alg = preg_replace("/M4F'/","<604>",$alg); $alg = preg_replace("/M4F-/","<604>",$alg);   $alg = preg_replace("/M4F2/","<605>",$alg);   $alg = preg_replace("/M4F/","<606>",$alg);
    $alg = preg_replace("/M4B'/","<606>",$alg); $alg = preg_replace("/M4B-/","<606>",$alg);   $alg = preg_replace("/M4B2/","<605>",$alg);   $alg = preg_replace("/M4B/","<604>",$alg);
    $alg = preg_replace("/M4U'/","<607>",$alg); $alg = preg_replace("/M4U-/","<607>",$alg);   $alg = preg_replace("/M4U2/","<608>",$alg);   $alg = preg_replace("/M4U/","<609>",$alg);
    $alg = preg_replace("/M4D'/","<609>",$alg); $alg = preg_replace("/M4D-/","<609>",$alg);   $alg = preg_replace("/M4D2/","<608>",$alg);   $alg = preg_replace("/M4D/","<607>",$alg);
    
    $alg = preg_replace("/V4R'/","<601>",$alg); $alg = preg_replace("/V4R-/","<601>",$alg);   $alg = preg_replace("/V4R2/","<602>",$alg);   $alg = preg_replace("/V4R/","<603>",$alg);
    $alg = preg_replace("/V4L'/","<603>",$alg); $alg = preg_replace("/V4L-/","<603>",$alg);   $alg = preg_replace("/V4L2/","<602>",$alg);   $alg = preg_replace("/V4L/","<601>",$alg);
    $alg = preg_replace("/V4F'/","<604>",$alg); $alg = preg_replace("/V4F-/","<604>",$alg);   $alg = preg_replace("/V4F2/","<605>",$alg);   $alg = preg_replace("/V4F/","<606>",$alg);
    $alg = preg_replace("/V4B'/","<606>",$alg); $alg = preg_replace("/V4B-/","<606>",$alg);   $alg = preg_replace("/V4B2/","<605>",$alg);   $alg = preg_replace("/V4B/","<604>",$alg);
    $alg = preg_replace("/V4U'/","<607>",$alg); $alg = preg_replace("/V4U-/","<607>",$alg);   $alg = preg_replace("/V4U2/","<608>",$alg);   $alg = preg_replace("/V4U/","<609>",$alg);
    $alg = preg_replace("/V4D'/","<609>",$alg); $alg = preg_replace("/V4D-/","<609>",$alg);   $alg = preg_replace("/V4D2/","<608>",$alg);   $alg = preg_replace("/V4D/","<607>",$alg);
    
    $alg = preg_replace("/N2-5R'/","<601>",$alg); $alg = preg_replace("/N2-5R-/","<601>",$alg);   $alg = preg_replace("/N2-5R2/","<602>",$alg);   $alg = preg_replace("/N2-5R/","<603>",$alg);
    $alg = preg_replace("/N2-5L'/","<603>",$alg); $alg = preg_replace("/N2-5L-/","<603>",$alg);   $alg = preg_replace("/N2-5L2/","<602>",$alg);   $alg = preg_replace("/N2-5L/","<601>",$alg);
    $alg = preg_replace("/N2-5F'/","<604>",$alg); $alg = preg_replace("/N2-5F-/","<604>",$alg);   $alg = preg_replace("/N2-5F2/","<605>",$alg);   $alg = preg_replace("/N2-5F/","<606>",$alg);
    $alg = preg_replace("/N2-5B'/","<606>",$alg); $alg = preg_replace("/N2-5B-/","<606>",$alg);   $alg = preg_replace("/N2-5B2/","<605>",$alg);   $alg = preg_replace("/N2-5B/","<604>",$alg);
    $alg = preg_replace("/N2-5U'/","<607>",$alg); $alg = preg_replace("/N2-5U-/","<607>",$alg);   $alg = preg_replace("/N2-5U2/","<608>",$alg);   $alg = preg_replace("/N2-5U/","<609>",$alg);
    $alg = preg_replace("/N2-5D'/","<609>",$alg); $alg = preg_replace("/N2-5D-/","<609>",$alg);   $alg = preg_replace("/N2-5D2/","<608>",$alg);   $alg = preg_replace("/N2-5D/","<607>",$alg);
    
    /* --- 6xC: SSE -> CODE: [7] Cube rotations --- */
    /* C */
    $alg = preg_replace("/CR'/","<701>",$alg); $alg = preg_replace("/CR-/","<701>",$alg);   $alg = preg_replace("/CR2/","<702>",$alg);   $alg = preg_replace("/CR/","<703>",$alg);
    $alg = preg_replace("/CL'/","<703>",$alg); $alg = preg_replace("/CL-/","<703>",$alg);   $alg = preg_replace("/CL2/","<702>",$alg);   $alg = preg_replace("/CL/","<701>",$alg);
    $alg = preg_replace("/CF'/","<704>",$alg); $alg = preg_replace("/CF-/","<704>",$alg);   $alg = preg_replace("/CF2/","<705>",$alg);   $alg = preg_replace("/CF/","<706>",$alg);
    $alg = preg_replace("/CB'/","<706>",$alg); $alg = preg_replace("/CB-/","<706>",$alg);   $alg = preg_replace("/CB2/","<705>",$alg);   $alg = preg_replace("/CB/","<704>",$alg);
    $alg = preg_replace("/CU'/","<707>",$alg); $alg = preg_replace("/CU-/","<707>",$alg);   $alg = preg_replace("/CU2/","<708>",$alg);   $alg = preg_replace("/CU/","<709>",$alg);
    $alg = preg_replace("/CD'/","<709>",$alg); $alg = preg_replace("/CD-/","<709>",$alg);   $alg = preg_replace("/CD2/","<708>",$alg);   $alg = preg_replace("/CD/","<707>",$alg);
    
    /* --- 6xC: SSE -> CODE: [9] Face twists --- */
    /*   */
    $alg = preg_replace("/R'/","<901>",$alg); $alg = preg_replace("/R-/","<901>",$alg);   $alg = preg_replace("/R2/","<902>",$alg);   $alg = preg_replace("/R/","<903>",$alg);
    $alg = preg_replace("/L'/","<904>",$alg); $alg = preg_replace("/L-/","<904>",$alg);   $alg = preg_replace("/L2/","<905>",$alg);   $alg = preg_replace("/L/","<906>",$alg);
    $alg = preg_replace("/F'/","<907>",$alg); $alg = preg_replace("/F-/","<907>",$alg);   $alg = preg_replace("/F2/","<908>",$alg);   $alg = preg_replace("/F/","<909>",$alg);
    $alg = preg_replace("/B'/","<910>",$alg); $alg = preg_replace("/B-/","<910>",$alg);   $alg = preg_replace("/B2/","<911>",$alg);   $alg = preg_replace("/B/","<912>",$alg);
    $alg = preg_replace("/U'/","<913>",$alg); $alg = preg_replace("/U-/","<913>",$alg);   $alg = preg_replace("/U2/","<914>",$alg);   $alg = preg_replace("/U/","<915>",$alg);
    $alg = preg_replace("/D'/","<916>",$alg); $alg = preg_replace("/D-/","<916>",$alg);   $alg = preg_replace("/D2/","<917>",$alg);   $alg = preg_replace("/D/","<918>",$alg);
    
    /* ··································································································· */
    /* --- 6xC: CODE -> TWIZZLE: [1] Numbered-layer twists --- */
    /* N | N5 */
    $alg = preg_replace("/<101>/","2R'",$alg);   $alg = preg_replace("/<102>/","2R2",$alg);   $alg = preg_replace("/<103>/","2R",$alg);
    $alg = preg_replace("/<104>/","2L'",$alg);   $alg = preg_replace("/<105>/","2L2",$alg);   $alg = preg_replace("/<106>/","2L",$alg);
    $alg = preg_replace("/<107>/","2F'",$alg);   $alg = preg_replace("/<108>/","2F2",$alg);   $alg = preg_replace("/<109>/","2F",$alg);
    $alg = preg_replace("/<110>/","2B'",$alg);   $alg = preg_replace("/<111>/","2B2",$alg);   $alg = preg_replace("/<112>/","2B",$alg);
    $alg = preg_replace("/<113>/","2U'",$alg);   $alg = preg_replace("/<114>/","2U2",$alg);   $alg = preg_replace("/<115>/","2U",$alg);
    $alg = preg_replace("/<116>/","2D'",$alg);   $alg = preg_replace("/<117>/","2D2",$alg);   $alg = preg_replace("/<118>/","2D",$alg);
    
    
    /* N3 = M | N4 = M */
    $alg = preg_replace("/<119>/","3R'",$alg);   $alg = preg_replace("/<120>/","3R2",$alg);   $alg = preg_replace("/<121>/","3R",$alg);
    $alg = preg_replace("/<122>/","3L'",$alg);   $alg = preg_replace("/<123>/","3L2",$alg);   $alg = preg_replace("/<124>/","3L",$alg);
    $alg = preg_replace("/<125>/","3F'",$alg);   $alg = preg_replace("/<126>/","3F2",$alg);   $alg = preg_replace("/<127>/","3F",$alg);
    $alg = preg_replace("/<128>/","3B'",$alg);   $alg = preg_replace("/<129>/","3B2",$alg);   $alg = preg_replace("/<130>/","3B",$alg);
    $alg = preg_replace("/<131>/","3U'",$alg);   $alg = preg_replace("/<132>/","3U2",$alg);   $alg = preg_replace("/<133>/","3U",$alg);
    $alg = preg_replace("/<134>/","3D'",$alg);   $alg = preg_replace("/<135>/","3D2",$alg);   $alg = preg_replace("/<136>/","3D",$alg);
    
    /* --- 6xC: CODE -> TWIZZLE: [2] Slice twists --- */
    /* S2 = S3-4 */
    $alg = preg_replace("/<201>/","r' l",$alg);   $alg = preg_replace("/<202>/","r2 l2",$alg);   $alg = preg_replace("/<203>/","r l'",$alg);
    $alg = preg_replace("/<204>/","f' b",$alg);   $alg = preg_replace("/<205>/","f2 b2",$alg);   $alg = preg_replace("/<206>/","f b'",$alg);
    $alg = preg_replace("/<207>/","u' d",$alg);   $alg = preg_replace("/<208>/","u2 d2",$alg);   $alg = preg_replace("/<209>/","u d'",$alg);
    
    
    /* S = S2-5 */
    $alg = preg_replace("/<210>/","R' L",$alg);   $alg = preg_replace("/<211>/","R2 L2",$alg);   $alg = preg_replace("/<212>/","R L'",$alg);
    $alg = preg_replace("/<213>/","F' B",$alg);   $alg = preg_replace("/<214>/","F2 B2",$alg);   $alg = preg_replace("/<215>/","F B'",$alg);
    $alg = preg_replace("/<216>/","U' D",$alg);   $alg = preg_replace("/<217>/","U2 D2",$alg);   $alg = preg_replace("/<218>/","U D'",$alg);
    
    
    /* S2-2 | S5-5 */
    $alg = preg_replace("/<219>/","R' 4l",$alg);   $alg = preg_replace("/<220>/","R2 4l2",$alg);   $alg = preg_replace("/<221>/","R 4l'",$alg);
    $alg = preg_replace("/<222>/","4r L'",$alg);   $alg = preg_replace("/<223>/","4r2 L2",$alg);   $alg = preg_replace("/<224>/","4r' L",$alg);
    $alg = preg_replace("/<225>/","F' 4b",$alg);   $alg = preg_replace("/<226>/","F2 4b2",$alg);   $alg = preg_replace("/<227>/","F 4b'",$alg);
    $alg = preg_replace("/<228>/","4f B'",$alg);   $alg = preg_replace("/<229>/","4f2 B2",$alg);   $alg = preg_replace("/<230>/","4f' B",$alg);
    $alg = preg_replace("/<231>/","U' 4d",$alg);   $alg = preg_replace("/<232>/","U2 4d2",$alg);   $alg = preg_replace("/<233>/","U 4d'",$alg);
    $alg = preg_replace("/<234>/","4u D'",$alg);   $alg = preg_replace("/<235>/","4u2 D2",$alg);   $alg = preg_replace("/<236>/","4u' D",$alg);
    
    
    /* S2-3 | S4-5 */
    $alg = preg_replace("/<237>/","R' 3l",$alg);   $alg = preg_replace("/<238>/","R2 3l2",$alg);   $alg = preg_replace("/<239>/","R 3l'",$alg);
    $alg = preg_replace("/<240>/","3r L'",$alg);   $alg = preg_replace("/<241>/","3r2 L2",$alg);   $alg = preg_replace("/<242>/","3r' L",$alg);
    $alg = preg_replace("/<243>/","F' 3b",$alg);   $alg = preg_replace("/<244>/","F2 3b2",$alg);   $alg = preg_replace("/<245>/","F 3b'",$alg);
    $alg = preg_replace("/<246>/","3f B'",$alg);   $alg = preg_replace("/<247>/","3f2 B2",$alg);   $alg = preg_replace("/<248>/","3f' B",$alg);
    $alg = preg_replace("/<249>/","U' 3d",$alg);   $alg = preg_replace("/<250>/","U2 3d2",$alg);   $alg = preg_replace("/<251>/","U 3d'",$alg);
    $alg = preg_replace("/<252>/","3u D'",$alg);   $alg = preg_replace("/<253>/","3u2 D2",$alg);   $alg = preg_replace("/<254>/","3u' D",$alg);
    
    
    /* S2-4 | S3-5 */
    $alg = preg_replace("/<255>/","R' l",$alg);   $alg = preg_replace("/<256>/","R2 l2",$alg);   $alg = preg_replace("/<257>/","R l'",$alg);
    $alg = preg_replace("/<258>/","r L'",$alg);   $alg = preg_replace("/<259>/","r2 L2",$alg);   $alg = preg_replace("/<260>/","r' L",$alg);
    $alg = preg_replace("/<261>/","F' b",$alg);   $alg = preg_replace("/<262>/","F2 b2",$alg);   $alg = preg_replace("/<263>/","F b'",$alg);
    $alg = preg_replace("/<264>/","f B'",$alg);   $alg = preg_replace("/<265>/","f2 B2",$alg);   $alg = preg_replace("/<266>/","f' B",$alg);
    $alg = preg_replace("/<267>/","U' d",$alg);   $alg = preg_replace("/<268>/","U2 d2",$alg);   $alg = preg_replace("/<269>/","U d'",$alg);
    $alg = preg_replace("/<270>/","u D'",$alg);   $alg = preg_replace("/<271>/","u2 D2",$alg);   $alg = preg_replace("/<272>/","u' D",$alg);
    
    
    /* S3-3 | S4-4 */
    $alg = preg_replace("/<273>/","r' 3l",$alg);   $alg = preg_replace("/<274>/","r2 3l2",$alg);   $alg = preg_replace("/<275>/","r 3l'",$alg);
    $alg = preg_replace("/<276>/","3r l'",$alg);   $alg = preg_replace("/<277>/","3r2 l2",$alg);   $alg = preg_replace("/<278>/","3r' l",$alg);
    $alg = preg_replace("/<279>/","f' 3b",$alg);   $alg = preg_replace("/<280>/","f2 3b2",$alg);   $alg = preg_replace("/<281>/","f 3b'",$alg);
    $alg = preg_replace("/<282>/","3f b'",$alg);   $alg = preg_replace("/<283>/","3f2 b2",$alg);   $alg = preg_replace("/<284>/","3f' b",$alg);
    $alg = preg_replace("/<285>/","u' 3d",$alg);   $alg = preg_replace("/<286>/","u2 3d2",$alg);   $alg = preg_replace("/<287>/","u 3d'",$alg);
    $alg = preg_replace("/<288>/","3u d'",$alg);   $alg = preg_replace("/<289>/","3u2 d2",$alg);   $alg = preg_replace("/<290>/","3u' d",$alg);
    
    /* --- 6xC: CODE -> TWIZZLE: [3] Tier twists --- */
    /* T5 */
    $alg = preg_replace("/<301>/","5r'",$alg);   $alg = preg_replace("/<302>/","5r2",$alg);   $alg = preg_replace("/<303>/","5r",$alg);
    $alg = preg_replace("/<304>/","5l'",$alg);   $alg = preg_replace("/<305>/","5l2",$alg);   $alg = preg_replace("/<306>/","5l",$alg);
    $alg = preg_replace("/<307>/","5f'",$alg);   $alg = preg_replace("/<308>/","5f2",$alg);   $alg = preg_replace("/<309>/","5f",$alg);
    $alg = preg_replace("/<310>/","5b'",$alg);   $alg = preg_replace("/<311>/","5b2",$alg);   $alg = preg_replace("/<312>/","5b",$alg);
    $alg = preg_replace("/<313>/","5u'",$alg);   $alg = preg_replace("/<314>/","5u2",$alg);   $alg = preg_replace("/<315>/","5u",$alg);
    $alg = preg_replace("/<316>/","5d'",$alg);   $alg = preg_replace("/<317>/","5d2",$alg);   $alg = preg_replace("/<318>/","5d",$alg);
    
    
    /* T4 */
    $alg = preg_replace("/<319>/","4r'",$alg);   $alg = preg_replace("/<320>/","4r2",$alg);   $alg = preg_replace("/<321>/","4r",$alg);
    $alg = preg_replace("/<322>/","4l'",$alg);   $alg = preg_replace("/<323>/","4l2",$alg);   $alg = preg_replace("/<324>/","4l",$alg);
    $alg = preg_replace("/<325>/","4f'",$alg);   $alg = preg_replace("/<326>/","4f2",$alg);   $alg = preg_replace("/<327>/","4f",$alg);
    $alg = preg_replace("/<328>/","4b'",$alg);   $alg = preg_replace("/<329>/","4b2",$alg);   $alg = preg_replace("/<330>/","4b",$alg);
    $alg = preg_replace("/<331>/","4u'",$alg);   $alg = preg_replace("/<332>/","4u2",$alg);   $alg = preg_replace("/<333>/","4u",$alg);
    $alg = preg_replace("/<334>/","4d'",$alg);   $alg = preg_replace("/<335>/","4d2",$alg);   $alg = preg_replace("/<336>/","4d",$alg);
    
    
    /* T3 */
    $alg = preg_replace("/<337>/","3r'",$alg);   $alg = preg_replace("/<338>/","3r2",$alg);   $alg = preg_replace("/<339>/","3r",$alg);
    $alg = preg_replace("/<340>/","3l'",$alg);   $alg = preg_replace("/<341>/","3l2",$alg);   $alg = preg_replace("/<342>/","3l",$alg);
    $alg = preg_replace("/<343>/","3f'",$alg);   $alg = preg_replace("/<344>/","3f2",$alg);   $alg = preg_replace("/<345>/","3f",$alg);
    $alg = preg_replace("/<346>/","3b'",$alg);   $alg = preg_replace("/<347>/","3b2",$alg);   $alg = preg_replace("/<348>/","3b",$alg);
    $alg = preg_replace("/<349>/","3u'",$alg);   $alg = preg_replace("/<350>/","3u2",$alg);   $alg = preg_replace("/<351>/","3u",$alg);
    $alg = preg_replace("/<352>/","3d'",$alg);   $alg = preg_replace("/<353>/","3d2",$alg);   $alg = preg_replace("/<354>/","3d",$alg);
    
    
    /* T */
    $alg = preg_replace("/<355>/","r'",$alg);   $alg = preg_replace("/<356>/","r2",$alg);   $alg = preg_replace("/<357>/","r",$alg);
    $alg = preg_replace("/<358>/","l'",$alg);   $alg = preg_replace("/<359>/","l2",$alg);   $alg = preg_replace("/<360>/","l",$alg);
    $alg = preg_replace("/<361>/","f'",$alg);   $alg = preg_replace("/<362>/","f2",$alg);   $alg = preg_replace("/<363>/","f",$alg);
    $alg = preg_replace("/<364>/","b'",$alg);   $alg = preg_replace("/<365>/","b2",$alg);   $alg = preg_replace("/<366>/","b",$alg);
    $alg = preg_replace("/<367>/","u'",$alg);   $alg = preg_replace("/<368>/","u2",$alg);   $alg = preg_replace("/<369>/","u",$alg);
    $alg = preg_replace("/<370>/","d'",$alg);   $alg = preg_replace("/<371>/","d2",$alg);   $alg = preg_replace("/<372>/","d",$alg);
    
    /* --- 6xC: CODE -> TWIZZLE: [4] Void twists --- */
    /* V3 = M3 = N2-4 | V3 = M3 = N3-5 */
    $alg = preg_replace("/<401>/","2-4R'",$alg);   $alg = preg_replace("/<402>/","2-4R2",$alg);   $alg = preg_replace("/<403>/","2-4R",$alg);
    $alg = preg_replace("/<404>/","2-4L'",$alg);   $alg = preg_replace("/<405>/","2-4L2",$alg);   $alg = preg_replace("/<406>/","2-4L",$alg);
    $alg = preg_replace("/<407>/","2-4F'",$alg);   $alg = preg_replace("/<408>/","2-4F2",$alg);   $alg = preg_replace("/<409>/","2-4F",$alg);
    $alg = preg_replace("/<410>/","2-4B'",$alg);   $alg = preg_replace("/<411>/","2-4B2",$alg);   $alg = preg_replace("/<412>/","2-4B",$alg);
    $alg = preg_replace("/<413>/","2-4U'",$alg);   $alg = preg_replace("/<414>/","2-4U2",$alg);   $alg = preg_replace("/<415>/","2-4U",$alg);
    $alg = preg_replace("/<416>/","2-4D'",$alg);   $alg = preg_replace("/<417>/","2-4D2",$alg);   $alg = preg_replace("/<418>/","2-4D",$alg);
    
    
    /* V = N2-3 | V = N4-5 */
    $alg = preg_replace("/<419>/","2-3R'",$alg);   $alg = preg_replace("/<420>/","2-3R2",$alg);   $alg = preg_replace("/<421>/","2-3R",$alg);
    $alg = preg_replace("/<422>/","2-3L'",$alg);   $alg = preg_replace("/<423>/","2-3L2",$alg);   $alg = preg_replace("/<424>/","2-3L",$alg);
    $alg = preg_replace("/<425>/","2-3F'",$alg);   $alg = preg_replace("/<426>/","2-3F2",$alg);   $alg = preg_replace("/<427>/","2-3F",$alg);
    $alg = preg_replace("/<428>/","2-3B'",$alg);   $alg = preg_replace("/<429>/","2-3B2",$alg);   $alg = preg_replace("/<430>/","2-3B",$alg);
    $alg = preg_replace("/<431>/","2-3U'",$alg);   $alg = preg_replace("/<432>/","2-3U2",$alg);   $alg = preg_replace("/<433>/","2-3U",$alg);
    $alg = preg_replace("/<434>/","2-3D'",$alg);   $alg = preg_replace("/<435>/","2-3D2",$alg);   $alg = preg_replace("/<436>/","2-3D",$alg);
    
    /* --- 6xC: CODE -> TWIZZLE: [5] Mid-layer twists --- */
    /* M2 = N3-4 */
    $alg = preg_replace("/<501>/","3-4R'",$alg);   $alg = preg_replace("/<502>/","3-4R2",$alg);   $alg = preg_replace("/<503>/","3-4R",$alg);
    $alg = preg_replace("/<504>/","3-4F'",$alg);   $alg = preg_replace("/<505>/","3-4F2",$alg);   $alg = preg_replace("/<506>/","3-4F",$alg);
    $alg = preg_replace("/<507>/","3-4U'",$alg);   $alg = preg_replace("/<508>/","3-4U2",$alg);   $alg = preg_replace("/<509>/","3-4U",$alg);
    
    /* --- 6xC: CODE -> TWIZZLE: [6] Wide-layer twists [5] (Mid-layer twists) --- */
    /* W = M4 = V4 = N2-5 */
    if ($useSiGN == true) { // Bei SiGN:
      $alg = preg_replace("/<601>/","m", $alg);   $alg = preg_replace("/<602>/","m2",$alg);   $alg = preg_replace("/<603>/","m'",$alg);
      $alg = preg_replace("/<604>/","s'",$alg);   $alg = preg_replace("/<605>/","s2",$alg);   $alg = preg_replace("/<606>/","s", $alg);
      $alg = preg_replace("/<607>/","e", $alg);   $alg = preg_replace("/<608>/","e2",$alg);   $alg = preg_replace("/<609>/","e'",$alg);
      
    } else {               // Sonst (TWIZZLE):
      $alg = preg_replace("/<601>/","2-5R'",$alg);   $alg = preg_replace("/<602>/","2-5R2",$alg);   $alg = preg_replace("/<603>/","2-5R",$alg);
      $alg = preg_replace("/<604>/","2-5F'",$alg);   $alg = preg_replace("/<605>/","2-5F2",$alg);   $alg = preg_replace("/<606>/","2-5F",$alg);
      $alg = preg_replace("/<607>/","2-5U'",$alg);   $alg = preg_replace("/<608>/","2-5U2",$alg);   $alg = preg_replace("/<609>/","2-5U",$alg);
    }
    
    /* --- 6xC: CODE -> TWIZZLE: [7] Cube rotations --- */
    /* C */
    if ($useSiGN == true) { // Bei SiGN:
      $alg = preg_replace("/<701>/","x'",$alg);   $alg = preg_replace("/<702>/","x2",$alg);   $alg = preg_replace("/<703>/","x",$alg);
      $alg = preg_replace("/<704>/","z'",$alg);   $alg = preg_replace("/<705>/","z2",$alg);   $alg = preg_replace("/<706>/","z",$alg);
      $alg = preg_replace("/<707>/","y'",$alg);   $alg = preg_replace("/<708>/","y2",$alg);   $alg = preg_replace("/<709>/","y",$alg);
      
    } else {               // Sonst (TWIZZLE):
      $alg = preg_replace("/<701>/","Rv'",$alg);   $alg = preg_replace("/<702>/","Rv2",$alg);   $alg = preg_replace("/<703>/","Rv",$alg);
      $alg = preg_replace("/<704>/","Fv'",$alg);   $alg = preg_replace("/<705>/","Fv2",$alg);   $alg = preg_replace("/<706>/","Fv",$alg);
      $alg = preg_replace("/<707>/","Uv'",$alg);   $alg = preg_replace("/<708>/","Uv2",$alg);   $alg = preg_replace("/<709>/","Uv",$alg);
    }
    
    /* --- 6xC: CODE -> TWIZZLE: [9] Face twists --- */
    /*   */
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
    /* --- 6xC: Preferences --- */
    $optSSE = true;  // Optimize SSE (rebuilds Slice twists).
    
    /* --- 6xC: Marker --- */
    $alg = str_replace(".","·",$alg);
    
    /* ··································································································· */
    /* --- 6xC: TWIZZLE -> CODE: [3] Tier twists (TWIZZLE) --- */
    /* T5 */
    $alg = preg_replace("/1-5R'/","<301>",$alg); $alg = preg_replace("/1-5R2/","<302>",$alg); $alg = preg_replace("/1-5R/","<303>",$alg);
    $alg = preg_replace("/1-5L'/","<304>",$alg); $alg = preg_replace("/1-5L2/","<305>",$alg); $alg = preg_replace("/1-5L/","<306>",$alg);
    $alg = preg_replace("/1-5F'/","<307>",$alg); $alg = preg_replace("/1-5F2/","<308>",$alg); $alg = preg_replace("/1-5F/","<309>",$alg);
    $alg = preg_replace("/1-5B'/","<310>",$alg); $alg = preg_replace("/1-5B2/","<311>",$alg); $alg = preg_replace("/1-5B/","<312>",$alg);
    $alg = preg_replace("/1-5U'/","<313>",$alg); $alg = preg_replace("/1-5U2/","<314>",$alg); $alg = preg_replace("/1-5U/","<315>",$alg);
    $alg = preg_replace("/1-5D'/","<316>",$alg); $alg = preg_replace("/1-5D2/","<317>",$alg); $alg = preg_replace("/1-5D/","<318>",$alg);
    
    
    /* T4 */
    $alg = preg_replace("/1-4R'/","<319>",$alg); $alg = preg_replace("/1-4R2/","<320>",$alg); $alg = preg_replace("/1-4R/","<321>",$alg);
    $alg = preg_replace("/1-4L'/","<322>",$alg); $alg = preg_replace("/1-4L2/","<323>",$alg); $alg = preg_replace("/1-4L/","<324>",$alg);
    $alg = preg_replace("/1-4F'/","<325>",$alg); $alg = preg_replace("/1-4F2/","<326>",$alg); $alg = preg_replace("/1-4F/","<327>",$alg);
    $alg = preg_replace("/1-4B'/","<328>",$alg); $alg = preg_replace("/1-4B2/","<329>",$alg); $alg = preg_replace("/1-4B/","<330>",$alg);
    $alg = preg_replace("/1-4U'/","<331>",$alg); $alg = preg_replace("/1-4U2/","<332>",$alg); $alg = preg_replace("/1-4U/","<333>",$alg);
    $alg = preg_replace("/1-4D'/","<334>",$alg); $alg = preg_replace("/1-4D2/","<335>",$alg); $alg = preg_replace("/1-4D/","<336>",$alg);
    
    
    /* T3 */
    $alg = preg_replace("/1-3R'/","<337>",$alg); $alg = preg_replace("/1-3R2/","<338>",$alg); $alg = preg_replace("/1-3R/","<339>",$alg);
    $alg = preg_replace("/1-3L'/","<340>",$alg); $alg = preg_replace("/1-3L2/","<341>",$alg); $alg = preg_replace("/1-3L/","<342>",$alg);
    $alg = preg_replace("/1-3F'/","<343>",$alg); $alg = preg_replace("/1-3F2/","<344>",$alg); $alg = preg_replace("/1-3F/","<345>",$alg);
    $alg = preg_replace("/1-3B'/","<346>",$alg); $alg = preg_replace("/1-3B2/","<347>",$alg); $alg = preg_replace("/1-3B/","<348>",$alg);
    $alg = preg_replace("/1-3U'/","<349>",$alg); $alg = preg_replace("/1-3U2/","<350>",$alg); $alg = preg_replace("/1-3U/","<351>",$alg);
    $alg = preg_replace("/1-3D'/","<352>",$alg); $alg = preg_replace("/1-3D2/","<353>",$alg); $alg = preg_replace("/1-3D/","<354>",$alg);
    
    
    /* T */
    $alg = preg_replace("/1-2R'/","<355>",$alg); $alg = preg_replace("/1-2R2/","<356>",$alg); $alg = preg_replace("/1-2R/","<357>",$alg);
    $alg = preg_replace("/1-2L'/","<358>",$alg); $alg = preg_replace("/1-2L2/","<359>",$alg); $alg = preg_replace("/1-2L/","<360>",$alg);
    $alg = preg_replace("/1-2F'/","<361>",$alg); $alg = preg_replace("/1-2F2/","<362>",$alg); $alg = preg_replace("/1-2F/","<363>",$alg);
    $alg = preg_replace("/1-2B'/","<364>",$alg); $alg = preg_replace("/1-2B2/","<365>",$alg); $alg = preg_replace("/1-2B/","<366>",$alg);
    $alg = preg_replace("/1-2U'/","<367>",$alg); $alg = preg_replace("/1-2U2/","<368>",$alg); $alg = preg_replace("/1-2U/","<369>",$alg);
    $alg = preg_replace("/1-2D'/","<370>",$alg); $alg = preg_replace("/1-2D2/","<371>",$alg); $alg = preg_replace("/1-2D/","<372>",$alg);
    
    /* --- 6xC: TWIZZLE -> CODE: [2] Slice twists --- */
    if ($optSSE == true) {
      /* S2 = S3-4 */
      $alg = preg_replace("/3-4L' Rv'/","<201>",$alg); $alg = preg_replace("/3-4L- Rv-/","<201>",$alg);   $alg = preg_replace("/3-4L2 Rv2/","<202>",$alg);   $alg = preg_replace("/3-4L Rv/","<203>",$alg);
      $alg = preg_replace("/3-4R' Lv'/","<203>",$alg); $alg = preg_replace("/3-4R- Lv-/","<203>",$alg);   $alg = preg_replace("/3-4R2 Lv2/","<202>",$alg);   $alg = preg_replace("/3-4R Lv/","<201>",$alg);
      $alg = preg_replace("/3-4B' Fv'/","<204>",$alg); $alg = preg_replace("/3-4B- Fv-/","<204>",$alg);   $alg = preg_replace("/3-4B2 Fv2/","<205>",$alg);   $alg = preg_replace("/3-4B Fv/","<206>",$alg);
      $alg = preg_replace("/3-4F' Bv'/","<206>",$alg); $alg = preg_replace("/3-4F- Bv-/","<206>",$alg);   $alg = preg_replace("/3-4F2 Bv2/","<205>",$alg);   $alg = preg_replace("/3-4F Bv/","<204>",$alg);
      $alg = preg_replace("/3-4D' Uv'/","<207>",$alg); $alg = preg_replace("/3-4D- Uv-/","<207>",$alg);   $alg = preg_replace("/3-4D2 Uv2/","<208>",$alg);   $alg = preg_replace("/3-4D Uv/","<209>",$alg);
      $alg = preg_replace("/3-4U' Dv'/","<209>",$alg); $alg = preg_replace("/3-4U- Dv-/","<209>",$alg);   $alg = preg_replace("/3-4U2 Dv2/","<208>",$alg);   $alg = preg_replace("/3-4U Dv/","<207>",$alg);
      
      $alg = preg_replace("/3-4R Rv'/","<201>",$alg); $alg = preg_replace("/3-4R Rv-/","<201>",$alg);   $alg = preg_replace("/3-4R2 Rv2/","<202>",$alg);   $alg = preg_replace("/3-4R' Rv/","<203>",$alg); $alg = preg_replace("/3-4R- Rv/","<203>",$alg);
      $alg = preg_replace("/3-4L Lv'/","<203>",$alg); $alg = preg_replace("/3-4L Lv-/","<203>",$alg);   $alg = preg_replace("/3-4L2 Lv2/","<202>",$alg);   $alg = preg_replace("/3-4L' Lv/","<201>",$alg); $alg = preg_replace("/3-4L- Lv/","<201>",$alg);
      $alg = preg_replace("/3-4F Fv'/","<204>",$alg); $alg = preg_replace("/3-4F Fv-/","<204>",$alg);   $alg = preg_replace("/3-4F2 Fv2/","<205>",$alg);   $alg = preg_replace("/3-4F' Fv/","<206>",$alg); $alg = preg_replace("/3-4F- Fv/","<206>",$alg);
      $alg = preg_replace("/3-4B Bv'/","<206>",$alg); $alg = preg_replace("/3-4B Bv-/","<206>",$alg);   $alg = preg_replace("/3-4B2 Bv2/","<205>",$alg);   $alg = preg_replace("/3-4B' Bv/","<204>",$alg); $alg = preg_replace("/3-4B- Bv/","<204>",$alg);
      $alg = preg_replace("/3-4U Uv'/","<207>",$alg); $alg = preg_replace("/3-4U Uv-/","<207>",$alg);   $alg = preg_replace("/3-4U2 Uv2/","<208>",$alg);   $alg = preg_replace("/3-4U' Uv/","<209>",$alg); $alg = preg_replace("/3-4U- Uv/","<209>",$alg);
      $alg = preg_replace("/3-4D Dv'/","<209>",$alg); $alg = preg_replace("/3-4D Dv-/","<209>",$alg);   $alg = preg_replace("/3-4D2 Dv2/","<208>",$alg);   $alg = preg_replace("/3-4D' Dv/","<207>",$alg); $alg = preg_replace("/3-4D- Dv/","<207>",$alg);
      
      
      /* S = S2-5 */
      $alg = preg_replace("/2-5L' Rv'/","<210>",$alg); $alg = preg_replace("/2-5L- Rv-/","<210>",$alg);   $alg = preg_replace("/2-5L2 Rv2/","<211>",$alg);   $alg = preg_replace("/2-5L Rv/","<212>",$alg);
      $alg = preg_replace("/2-5R' Lv'/","<212>",$alg); $alg = preg_replace("/2-5R- Lv-/","<212>",$alg);   $alg = preg_replace("/2-5R2 Lv2/","<211>",$alg);   $alg = preg_replace("/2-5R Lv/","<210>",$alg);
      $alg = preg_replace("/2-5B' Fv'/","<213>",$alg); $alg = preg_replace("/2-5B- Fv-/","<213>",$alg);   $alg = preg_replace("/2-5B2 Fv2/","<214>",$alg);   $alg = preg_replace("/2-5B Fv/","<215>",$alg);
      $alg = preg_replace("/2-5F' Bv'/","<215>",$alg); $alg = preg_replace("/2-5F- Bv-/","<215>",$alg);   $alg = preg_replace("/2-5F2 Bv2/","<214>",$alg);   $alg = preg_replace("/2-5F Bv/","<213>",$alg);
      $alg = preg_replace("/2-5D' Uv'/","<216>",$alg); $alg = preg_replace("/2-5D- Uv-/","<216>",$alg);   $alg = preg_replace("/2-5D2 Uv2/","<217>",$alg);   $alg = preg_replace("/2-5D Uv/","<218>",$alg);
      $alg = preg_replace("/2-5U' Dv'/","<218>",$alg); $alg = preg_replace("/2-5U- Dv-/","<218>",$alg);   $alg = preg_replace("/2-5U2 Dv2/","<217>",$alg);   $alg = preg_replace("/2-5U Dv/","<216>",$alg);
      
      $alg = preg_replace("/2-5R Rv'/","<210>",$alg); $alg = preg_replace("/2-5R Rv-/","<210>",$alg);   $alg = preg_replace("/2-5R2 Rv2/","<211>",$alg);   $alg = preg_replace("/2-5R' Rv/","<212>",$alg); $alg = preg_replace("/2-5R- Rv/","<212>",$alg);
      $alg = preg_replace("/2-5L Lv'/","<212>",$alg); $alg = preg_replace("/2-5L Lv-/","<212>",$alg);   $alg = preg_replace("/2-5L2 Lv2/","<211>",$alg);   $alg = preg_replace("/2-5L' Lv/","<210>",$alg); $alg = preg_replace("/2-5L- Lv/","<210>",$alg);
      $alg = preg_replace("/2-5F Fv'/","<213>",$alg); $alg = preg_replace("/2-5F Fv-/","<213>",$alg);   $alg = preg_replace("/2-5F2 Fv2/","<214>",$alg);   $alg = preg_replace("/2-5F' Fv/","<215>",$alg); $alg = preg_replace("/2-5F- Fv/","<215>",$alg);
      $alg = preg_replace("/2-5B Bv'/","<215>",$alg); $alg = preg_replace("/2-5B Bv-/","<215>",$alg);   $alg = preg_replace("/2-5B2 Bv2/","<214>",$alg);   $alg = preg_replace("/2-5B' Bv/","<213>",$alg); $alg = preg_replace("/2-5B- Bv/","<213>",$alg);
      $alg = preg_replace("/2-5U Uv'/","<216>",$alg); $alg = preg_replace("/2-5U Uv-/","<216>",$alg);   $alg = preg_replace("/2-5U2 Uv2/","<217>",$alg);   $alg = preg_replace("/2-5U' Uv/","<218>",$alg); $alg = preg_replace("/2-5U- Uv/","<218>",$alg);
      $alg = preg_replace("/2-5D Dv'/","<218>",$alg); $alg = preg_replace("/2-5D Dv-/","<218>",$alg);   $alg = preg_replace("/2-5D2 Dv2/","<217>",$alg);   $alg = preg_replace("/2-5D' Dv/","<216>",$alg); $alg = preg_replace("/2-5D- Dv/","<216>",$alg);
      
      /* S2-2 | S5-5 */
      
      /* S2-3 | S4-5 */
      
      /* S2-4 | S3-5 */
      
      /* S3-3 | S4-4 */
    }
    
    /* --- 6xC: TWIZZLE -> CODE: [6] Wide layer twists --- */
    /* W */
    $alg = preg_replace("/2-5R'/","<601>",$alg); $alg = preg_replace("/2-5R2/","<602>",$alg); $alg = preg_replace("/2-5R/","<603>",$alg);
    $alg = preg_replace("/2-5L'/","<603>",$alg); $alg = preg_replace("/2-5L2/","<602>",$alg); $alg = preg_replace("/2-5L/","<601>",$alg);
    $alg = preg_replace("/2-5F'/","<604>",$alg); $alg = preg_replace("/2-5F2/","<605>",$alg); $alg = preg_replace("/2-5F/","<606>",$alg);
    $alg = preg_replace("/2-5B'/","<606>",$alg); $alg = preg_replace("/2-5B2/","<605>",$alg); $alg = preg_replace("/2-5B/","<604>",$alg);
    $alg = preg_replace("/2-5U'/","<607>",$alg); $alg = preg_replace("/2-5U2/","<608>",$alg); $alg = preg_replace("/2-5U/","<609>",$alg);
    $alg = preg_replace("/2-5D'/","<609>",$alg); $alg = preg_replace("/2-5D2/","<608>",$alg); $alg = preg_replace("/2-5D/","<607>",$alg);
    
    $alg = preg_replace("/m'/","<603>",$alg); $alg = preg_replace("/m2/","<602>",$alg); $alg = preg_replace("/m/","<601>",$alg);
    $alg = preg_replace("/s'/","<604>",$alg); $alg = preg_replace("/s2/","<605>",$alg); $alg = preg_replace("/s/","<606>",$alg);
    $alg = preg_replace("/e'/","<609>",$alg); $alg = preg_replace("/e2/","<608>",$alg); $alg = preg_replace("/e/","<607>",$alg);
    
    /* --- 6xC: TWIZZLE -> CODE: [4] Void twists --- */
    /* V */
    $alg = preg_replace("/2-3R'/","<401>",$alg); $alg = preg_replace("/2-3R2/","<402>",$alg); $alg = preg_replace("/2-3R/","<403>",$alg);
    $alg = preg_replace("/2-3L'/","<404>",$alg); $alg = preg_replace("/2-3L2/","<405>",$alg); $alg = preg_replace("/2-3L/","<406>",$alg);
    $alg = preg_replace("/2-3F'/","<407>",$alg); $alg = preg_replace("/2-3F2/","<408>",$alg); $alg = preg_replace("/2-3F/","<409>",$alg);
    $alg = preg_replace("/2-3B'/","<410>",$alg); $alg = preg_replace("/2-3B2/","<411>",$alg); $alg = preg_replace("/2-3B/","<412>",$alg);
    $alg = preg_replace("/2-3U'/","<413>",$alg); $alg = preg_replace("/2-3U2/","<414>",$alg); $alg = preg_replace("/2-3U/","<415>",$alg);
    $alg = preg_replace("/2-3D'/","<416>",$alg); $alg = preg_replace("/2-3D2/","<417>",$alg); $alg = preg_replace("/2-3D/","<418>",$alg);
    
    
    /* V3 */
    $alg = preg_replace("/2-4R'/","<419>",$alg); $alg = preg_replace("/2-4R2/","<420>",$alg); $alg = preg_replace("/2-4R/","<421>",$alg);
    $alg = preg_replace("/2-4L'/","<422>",$alg); $alg = preg_replace("/2-4L2/","<423>",$alg); $alg = preg_replace("/2-4L/","<424>",$alg);
    $alg = preg_replace("/2-4F'/","<425>",$alg); $alg = preg_replace("/2-4F2/","<426>",$alg); $alg = preg_replace("/2-4F/","<427>",$alg);
    $alg = preg_replace("/2-4B'/","<428>",$alg); $alg = preg_replace("/2-4B2/","<429>",$alg); $alg = preg_replace("/2-4B/","<430>",$alg);
    $alg = preg_replace("/2-4U'/","<431>",$alg); $alg = preg_replace("/2-4U2/","<432>",$alg); $alg = preg_replace("/2-4U/","<433>",$alg);
    $alg = preg_replace("/2-4D'/","<434>",$alg); $alg = preg_replace("/2-4D2/","<435>",$alg); $alg = preg_replace("/2-4D/","<436>",$alg);
    
    /* --- 6xC: TWIZZLE -> CODE: [5] Mid-layer twists --- */
    /* M2 */
    $alg = preg_replace("/3-4R'/","<501>",$alg); $alg = preg_replace("/3-4R2/","<502>",$alg); $alg = preg_replace("/3-4R/","<503>",$alg);
    $alg = preg_replace("/3-4L'/","<504>",$alg); $alg = preg_replace("/3-4L2/","<505>",$alg); $alg = preg_replace("/3-4L/","<506>",$alg);
    $alg = preg_replace("/3-4F'/","<507>",$alg); $alg = preg_replace("/3-4F2/","<508>",$alg); $alg = preg_replace("/3-4F/","<509>",$alg);
    $alg = preg_replace("/3-4B'/","<510>",$alg); $alg = preg_replace("/3-4B2/","<511>",$alg); $alg = preg_replace("/3-4B/","<512>",$alg);
    $alg = preg_replace("/3-4U'/","<513>",$alg); $alg = preg_replace("/3-4U2/","<514>",$alg); $alg = preg_replace("/3-4U/","<515>",$alg);
    $alg = preg_replace("/3-4D'/","<516>",$alg); $alg = preg_replace("/3-4D2/","<517>",$alg); $alg = preg_replace("/3-4D/","<518>",$alg);
    
    /* --- 6xC: TWIZZLE -> CODE: [3] Tier twists (WCA) --- */
    /* T5 */
    $alg = preg_replace("/5Rw'/","<301>",$alg); $alg = preg_replace("/5Rw2/","<302>",$alg); $alg = preg_replace("/5Rw/","<303>",$alg);
    $alg = preg_replace("/5Lw'/","<304>",$alg); $alg = preg_replace("/5Lw2/","<305>",$alg); $alg = preg_replace("/5Lw/","<306>",$alg);
    $alg = preg_replace("/5Fw'/","<307>",$alg); $alg = preg_replace("/5Fw2/","<308>",$alg); $alg = preg_replace("/5Fw/","<309>",$alg);
    $alg = preg_replace("/5Bw'/","<310>",$alg); $alg = preg_replace("/5Bw2/","<311>",$alg); $alg = preg_replace("/5Bw/","<312>",$alg);
    $alg = preg_replace("/5Uw'/","<313>",$alg); $alg = preg_replace("/5Uw2/","<314>",$alg); $alg = preg_replace("/5Uw/","<315>",$alg);
    $alg = preg_replace("/5Dw'/","<316>",$alg); $alg = preg_replace("/5Dw2/","<317>",$alg); $alg = preg_replace("/5Dw/","<318>",$alg);
    
    
    /* T4 */
    $alg = preg_replace("/4Rw'/","<319>",$alg); $alg = preg_replace("/4Rw2/","<320>",$alg); $alg = preg_replace("/4Rw/","<321>",$alg);
    $alg = preg_replace("/4Lw'/","<322>",$alg); $alg = preg_replace("/4Lw2/","<323>",$alg); $alg = preg_replace("/4Lw/","<324>",$alg);
    $alg = preg_replace("/4Fw'/","<325>",$alg); $alg = preg_replace("/4Fw2/","<326>",$alg); $alg = preg_replace("/4Fw/","<327>",$alg);
    $alg = preg_replace("/4Bw'/","<328>",$alg); $alg = preg_replace("/4Bw2/","<329>",$alg); $alg = preg_replace("/4Bw/","<330>",$alg);
    $alg = preg_replace("/4Uw'/","<331>",$alg); $alg = preg_replace("/4Uw2/","<332>",$alg); $alg = preg_replace("/4Uw/","<333>",$alg);
    $alg = preg_replace("/4Dw'/","<334>",$alg); $alg = preg_replace("/4Dw2/","<335>",$alg); $alg = preg_replace("/4Dw/","<336>",$alg);
    
    
    /* T3 */
    $alg = preg_replace("/3Rw'/","<337>",$alg); $alg = preg_replace("/3Rw2/","<338>",$alg); $alg = preg_replace("/3Rw/","<339>",$alg);
    $alg = preg_replace("/3Lw'/","<340>",$alg); $alg = preg_replace("/3Lw2/","<341>",$alg); $alg = preg_replace("/3Lw/","<342>",$alg);
    $alg = preg_replace("/3Fw'/","<343>",$alg); $alg = preg_replace("/3Fw2/","<344>",$alg); $alg = preg_replace("/3Fw/","<345>",$alg);
    $alg = preg_replace("/3Bw'/","<346>",$alg); $alg = preg_replace("/3Bw2/","<347>",$alg); $alg = preg_replace("/3Bw/","<348>",$alg);
    $alg = preg_replace("/3Uw'/","<349>",$alg); $alg = preg_replace("/3Uw2/","<350>",$alg); $alg = preg_replace("/3Uw/","<351>",$alg);
    $alg = preg_replace("/3Dw'/","<352>",$alg); $alg = preg_replace("/3Dw2/","<353>",$alg); $alg = preg_replace("/3Dw/","<354>",$alg);
    
    /* --- 6xC: TWIZZLE -> CODE: [1] Numbered layer twists --- */
    /* N2 | N5 */
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
    
    
    /* N3 | N4 */
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
    
    /* --- 6xC: TWIZZLE -> CODE: [9] Face twists --- */
    /*   */
    $alg = preg_replace("/1R'/","<901>",$alg); $alg = preg_replace("/1R2/","<902>",$alg); $alg = preg_replace("/1R/","<903>",$alg);
    $alg = preg_replace("/1L'/","<904>",$alg); $alg = preg_replace("/1L2/","<905>",$alg); $alg = preg_replace("/1L/","<906>",$alg);
    $alg = preg_replace("/1F'/","<907>",$alg); $alg = preg_replace("/1F2/","<908>",$alg); $alg = preg_replace("/1F/","<909>",$alg);
    $alg = preg_replace("/1B'/","<910>",$alg); $alg = preg_replace("/1B2/","<911>",$alg); $alg = preg_replace("/1B/","<912>",$alg);
    $alg = preg_replace("/1U'/","<913>",$alg); $alg = preg_replace("/1U2/","<914>",$alg); $alg = preg_replace("/1U/","<915>",$alg);
    $alg = preg_replace("/1D'/","<916>",$alg); $alg = preg_replace("/1D2/","<917>",$alg); $alg = preg_replace("/1D/","<918>",$alg);
    
    $alg = preg_replace("/6R'/","<906>",$alg); $alg = preg_replace("/6R2/","<905>",$alg); $alg = preg_replace("/6R/","<904>",$alg);
    $alg = preg_replace("/6L'/","<903>",$alg); $alg = preg_replace("/6L2/","<902>",$alg); $alg = preg_replace("/6L/","<901>",$alg);
    $alg = preg_replace("/6F'/","<912>",$alg); $alg = preg_replace("/6F2/","<911>",$alg); $alg = preg_replace("/6F/","<910>",$alg);
    $alg = preg_replace("/6B'/","<909>",$alg); $alg = preg_replace("/6B2/","<908>",$alg); $alg = preg_replace("/6B/","<907>",$alg);
    $alg = preg_replace("/6U'/","<918>",$alg); $alg = preg_replace("/6U2/","<917>",$alg); $alg = preg_replace("/6U/","<916>",$alg);
    $alg = preg_replace("/6D'/","<915>",$alg); $alg = preg_replace("/6D2/","<914>",$alg); $alg = preg_replace("/6D/","<913>",$alg);
    
    /* --- 6xC: TWIZZLE -> CODE: [3] Tier twists (SiGN) --- */
    /* T5 */
    $alg = preg_replace("/5r'/","<301>",$alg); $alg = preg_replace("/5r2/","<302>",$alg); $alg = preg_replace("/5r/","<303>",$alg);
    $alg = preg_replace("/5l'/","<304>",$alg); $alg = preg_replace("/5l2/","<305>",$alg); $alg = preg_replace("/5l/","<306>",$alg);
    $alg = preg_replace("/5f'/","<307>",$alg); $alg = preg_replace("/5f2/","<308>",$alg); $alg = preg_replace("/5f/","<309>",$alg);
    $alg = preg_replace("/5b'/","<310>",$alg); $alg = preg_replace("/5b2/","<311>",$alg); $alg = preg_replace("/5b/","<312>",$alg);
    $alg = preg_replace("/5u'/","<313>",$alg); $alg = preg_replace("/5u2/","<314>",$alg); $alg = preg_replace("/5u/","<315>",$alg);
    $alg = preg_replace("/5d'/","<316>",$alg); $alg = preg_replace("/5d2/","<317>",$alg); $alg = preg_replace("/5d/","<318>",$alg);
    
    
    /* T4 */
    $alg = preg_replace("/4r'/","<319>",$alg); $alg = preg_replace("/4r2/","<320>",$alg); $alg = preg_replace("/4r/","<321>",$alg);
    $alg = preg_replace("/4l'/","<322>",$alg); $alg = preg_replace("/4l2/","<323>",$alg); $alg = preg_replace("/4l/","<324>",$alg);
    $alg = preg_replace("/4f'/","<325>",$alg); $alg = preg_replace("/4f2/","<326>",$alg); $alg = preg_replace("/4f/","<327>",$alg);
    $alg = preg_replace("/4b'/","<328>",$alg); $alg = preg_replace("/4b2/","<329>",$alg); $alg = preg_replace("/4b/","<330>",$alg);
    $alg = preg_replace("/4u'/","<331>",$alg); $alg = preg_replace("/4u2/","<332>",$alg); $alg = preg_replace("/4u/","<333>",$alg);
    $alg = preg_replace("/4d'/","<334>",$alg); $alg = preg_replace("/4d2/","<335>",$alg); $alg = preg_replace("/4d/","<336>",$alg);
    
    
    /* T3 */
    $alg = preg_replace("/3r'/","<337>",$alg); $alg = preg_replace("/3r2/","<338>",$alg); $alg = preg_replace("/3r/","<339>",$alg);
    $alg = preg_replace("/3l'/","<340>",$alg); $alg = preg_replace("/3l2/","<341>",$alg); $alg = preg_replace("/3l/","<342>",$alg);
    $alg = preg_replace("/3f'/","<343>",$alg); $alg = preg_replace("/3f2/","<344>",$alg); $alg = preg_replace("/3f/","<345>",$alg);
    $alg = preg_replace("/3b'/","<346>",$alg); $alg = preg_replace("/3b2/","<347>",$alg); $alg = preg_replace("/3b/","<348>",$alg);
    $alg = preg_replace("/3u'/","<349>",$alg); $alg = preg_replace("/3u2/","<350>",$alg); $alg = preg_replace("/3u/","<351>",$alg);
    $alg = preg_replace("/3d'/","<352>",$alg); $alg = preg_replace("/3d2/","<353>",$alg); $alg = preg_replace("/3d/","<354>",$alg);
    
    /* --- 6xC: TWIZZLE -> CODE: [2] Slice twists --- */
    if ($optSSE == true) {
      /* S2 = S3-4 */
      $alg = preg_replace("/Rw Lw'/","<203>",$alg); $alg = preg_replace("/Rw Lw-/","<203>",$alg);   $alg = preg_replace("/Rw2 Lw2/","<202>",$alg);   $alg = preg_replace("/Rw' Lw/","<201>",$alg); $alg = preg_replace("/Rw- Lw/","<201>",$alg);
      $alg = preg_replace("/Lw Rw'/","<201>",$alg); $alg = preg_replace("/Lw Rw-/","<201>",$alg);   $alg = preg_replace("/Lw2 Rw2/","<202>",$alg);   $alg = preg_replace("/Lw' Rw/","<203>",$alg); $alg = preg_replace("/Lw- Rw/","<203>",$alg);
      $alg = preg_replace("/Fw Bw'/","<206>",$alg); $alg = preg_replace("/Fw Bw-/","<206>",$alg);   $alg = preg_replace("/Fw2 Bw2/","<205>",$alg);   $alg = preg_replace("/Fw' Bw/","<204>",$alg); $alg = preg_replace("/Fw- Bw/","<204>",$alg);
      $alg = preg_replace("/Bw Fw'/","<204>",$alg); $alg = preg_replace("/Bw Fw-/","<204>",$alg);   $alg = preg_replace("/Bw2 Fw2/","<205>",$alg);   $alg = preg_replace("/Bw' Fw/","<206>",$alg); $alg = preg_replace("/Bw- Fw/","<206>",$alg);
      $alg = preg_replace("/Uw Dw'/","<209>",$alg); $alg = preg_replace("/Uw Dw-/","<209>",$alg);   $alg = preg_replace("/Uw2 Dw2/","<208>",$alg);   $alg = preg_replace("/Uw' Dw/","<207>",$alg); $alg = preg_replace("/Uw- Dw/","<207>",$alg);
      $alg = preg_replace("/Dw Uw'/","<207>",$alg); $alg = preg_replace("/Dw Uw-/","<207>",$alg);   $alg = preg_replace("/Dw2 Uw2/","<208>",$alg);   $alg = preg_replace("/Dw' Uw/","<209>",$alg); $alg = preg_replace("/Dw- Uw/","<209>",$alg);
      
      $alg = preg_replace("/r l'/","<203>",$alg); $alg = preg_replace("/r l-/","<203>",$alg);   $alg = preg_replace("/r2 l2/","<202>",$alg);   $alg = preg_replace("/r' l/","<201>",$alg); $alg = preg_replace("/r- l/","<201>",$alg);
      $alg = preg_replace("/l r'/","<201>",$alg); $alg = preg_replace("/l r-/","<201>",$alg);   $alg = preg_replace("/l2 r2/","<202>",$alg);   $alg = preg_replace("/l' r/","<203>",$alg); $alg = preg_replace("/l- r/","<203>",$alg);
      $alg = preg_replace("/f b'/","<206>",$alg); $alg = preg_replace("/f b-/","<206>",$alg);   $alg = preg_replace("/f2 b2/","<205>",$alg);   $alg = preg_replace("/f' b/","<204>",$alg); $alg = preg_replace("/f- b/","<204>",$alg);
      $alg = preg_replace("/b f'/","<204>",$alg); $alg = preg_replace("/b f-/","<204>",$alg);   $alg = preg_replace("/b2 f2/","<205>",$alg);   $alg = preg_replace("/b' f/","<206>",$alg); $alg = preg_replace("/b- f/","<206>",$alg);
      $alg = preg_replace("/u d'/","<209>",$alg); $alg = preg_replace("/u d-/","<209>",$alg);   $alg = preg_replace("/u2 d2/","<208>",$alg);   $alg = preg_replace("/u' d/","<207>",$alg); $alg = preg_replace("/u- d/","<207>",$alg);
      $alg = preg_replace("/d u'/","<207>",$alg); $alg = preg_replace("/d u-/","<207>",$alg);   $alg = preg_replace("/d2 u2/","<208>",$alg);   $alg = preg_replace("/d' u/","<209>",$alg); $alg = preg_replace("/d- u/","<209>",$alg);
      
      
      /* Non-slice-twists */
      $alg = preg_replace("/R' L'/","<255>",$alg);
      $alg = preg_replace("/L' R'/","<255>",$alg);
      $alg = preg_replace("/F' B'/","<256>",$alg);
      $alg = preg_replace("/B' F'/","<256>",$alg);
      $alg = preg_replace("/U' D'/","<257>",$alg);
      $alg = preg_replace("/D' U'/","<257>",$alg);
      
      /* S = S2-5 */
      $alg = preg_replace("/R L'/","<212>",$alg); $alg = preg_replace("/R L-/","<212>",$alg);   $alg = preg_replace("/R2 L2/","<211>",$alg);   $alg = preg_replace("/R' L/","<210>",$alg); $alg = preg_replace("/R- L/","<210>",$alg);
      $alg = preg_replace("/L R'/","<210>",$alg); $alg = preg_replace("/L R-/","<210>",$alg);   $alg = preg_replace("/L2 R2/","<211>",$alg);   $alg = preg_replace("/L' R/","<212>",$alg); $alg = preg_replace("/L- R/","<212>",$alg);
      $alg = preg_replace("/F B'/","<215>",$alg); $alg = preg_replace("/F B-/","<215>",$alg);   $alg = preg_replace("/F2 B2/","<214>",$alg);   $alg = preg_replace("/F' B/","<213>",$alg); $alg = preg_replace("/F- B/","<213>",$alg);
      $alg = preg_replace("/B F'/","<213>",$alg); $alg = preg_replace("/B F-/","<213>",$alg);   $alg = preg_replace("/B2 F2/","<214>",$alg);   $alg = preg_replace("/B' F/","<215>",$alg); $alg = preg_replace("/B- F/","<215>",$alg);
      $alg = preg_replace("/U D'/","<218>",$alg); $alg = preg_replace("/U D-/","<218>",$alg);   $alg = preg_replace("/U2 D2/","<217>",$alg);   $alg = preg_replace("/U' D/","<216>",$alg); $alg = preg_replace("/U- D/","<216>",$alg);
      $alg = preg_replace("/D U'/","<216>",$alg); $alg = preg_replace("/D U-/","<216>",$alg);   $alg = preg_replace("/D2 U2/","<217>",$alg);   $alg = preg_replace("/D' U/","<218>",$alg); $alg = preg_replace("/D- U/","<218>",$alg);
      
      /* S2-2 | S5-5 */
      
      /* S2-3 | S4-5 */
      
      /* S2-4 | S3-5 */
      
      /* S3-3 | S4-4 */
    }
    
    /* --- 6xC: TWIZZLE -> CODE: [3] Tier twists (WCA) --- */
    /* T */
    $alg = preg_replace("/Rw'/","<355>",$alg); $alg = preg_replace("/Rw2/","<356>",$alg); $alg = preg_replace("/Rw/","<357>",$alg);
    $alg = preg_replace("/Lw'/","<358>",$alg); $alg = preg_replace("/Lw2/","<359>",$alg); $alg = preg_replace("/Lw/","<360>",$alg);
    $alg = preg_replace("/Fw'/","<361>",$alg); $alg = preg_replace("/Fw2/","<362>",$alg); $alg = preg_replace("/Fw/","<363>",$alg);
    $alg = preg_replace("/Bw'/","<364>",$alg); $alg = preg_replace("/Bw2/","<365>",$alg); $alg = preg_replace("/Bw/","<366>",$alg);
    $alg = preg_replace("/Uw'/","<367>",$alg); $alg = preg_replace("/Uw2/","<368>",$alg); $alg = preg_replace("/Uw/","<369>",$alg);
    $alg = preg_replace("/Dw'/","<370>",$alg); $alg = preg_replace("/Dw2/","<371>",$alg); $alg = preg_replace("/Dw/","<372>",$alg);
    
    /* --- 6xC: TWIZZLE -> CODE: [7] Cube rotations --- */
    /* C */
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
    /*   */
    $alg = preg_replace("/R'/","<901>",$alg); $alg = preg_replace("/R2/","<902>",$alg); $alg = preg_replace("/R/","<903>",$alg);
    $alg = preg_replace("/L'/","<904>",$alg); $alg = preg_replace("/L2/","<905>",$alg); $alg = preg_replace("/L/","<906>",$alg);
    $alg = preg_replace("/F'/","<907>",$alg); $alg = preg_replace("/F2/","<908>",$alg); $alg = preg_replace("/F/","<909>",$alg);
    $alg = preg_replace("/B'/","<910>",$alg); $alg = preg_replace("/B2/","<911>",$alg); $alg = preg_replace("/B/","<912>",$alg);
    $alg = preg_replace("/U'/","<913>",$alg); $alg = preg_replace("/U2/","<914>",$alg); $alg = preg_replace("/U/","<915>",$alg);
    $alg = preg_replace("/D'/","<916>",$alg); $alg = preg_replace("/D2/","<917>",$alg); $alg = preg_replace("/D/","<918>",$alg);
    
    /* --- 6xC: TWIZZLE -> CODE: [3] Tier twists (SiGN) --- */
    /* T */
    $alg = preg_replace("/r'/","<355>",$alg); $alg = preg_replace("/r2/","<356>",$alg); $alg = preg_replace("/r/","<357>",$alg);
    $alg = preg_replace("/l'/","<358>",$alg); $alg = preg_replace("/l2/","<359>",$alg); $alg = preg_replace("/l/","<360>",$alg);
    $alg = preg_replace("/f'/","<361>",$alg); $alg = preg_replace("/f2/","<362>",$alg); $alg = preg_replace("/f/","<363>",$alg);
    $alg = preg_replace("/b'/","<364>",$alg); $alg = preg_replace("/b2/","<365>",$alg); $alg = preg_replace("/b/","<366>",$alg);
    $alg = preg_replace("/u'/","<367>",$alg); $alg = preg_replace("/u2/","<368>",$alg); $alg = preg_replace("/u/","<369>",$alg);
    $alg = preg_replace("/d'/","<370>",$alg); $alg = preg_replace("/d2/","<371>",$alg); $alg = preg_replace("/d/","<372>",$alg);
    
    /* ··································································································· */
    /* --- 6xC: CODE -> SSE opt: [2] Slice twists --- */
    if ($optSSE == true) {
      /* S2 = S3-4 */
      $alg = preg_replace("/<201>/","S2R'",$alg); $alg = preg_replace("/<202>/","S2R2",$alg); $alg = preg_replace("/<203>/","S2R",$alg);
      $alg = preg_replace("/<204>/","S2F'",$alg); $alg = preg_replace("/<205>/","S2F2",$alg); $alg = preg_replace("/<206>/","S2F",$alg);
      $alg = preg_replace("/<207>/","S2U'",$alg); $alg = preg_replace("/<208>/","S2U2",$alg); $alg = preg_replace("/<209>/","S2U",$alg);
      
      
      /* Non-slice-twists */
      $alg = preg_replace("/<255>/","R' L'",$alg);
      $alg = preg_replace("/<256>/","F' B'",$alg);
      $alg = preg_replace("/<257>/","U' D'",$alg);
      
      /* S = S2-5 */
      $alg = preg_replace("/<210>/","SR'",$alg); $alg = preg_replace("/<211>/","SR2",$alg); $alg = preg_replace("/<212>/","SR",$alg);
      $alg = preg_replace("/<213>/","SF'",$alg); $alg = preg_replace("/<214>/","SF2",$alg); $alg = preg_replace("/<215>/","SF",$alg);
      $alg = preg_replace("/<216>/","SU'",$alg); $alg = preg_replace("/<217>/","SU2",$alg); $alg = preg_replace("/<218>/","SU",$alg);
      
      /* S2-2 | S5-5 */
      
      /* S2-3 | S4-5 */
      
      /* S2-4 | S3-5 */
      
      /* S3-3 | S4-4 */
    }
    
    /* --- 6xC: CODE -> SSE: [6] Wide layer twists --- */
    /* W */
    $alg = preg_replace("/<601>/","WR'",$alg); $alg = preg_replace("/<602>/","WR2",$alg); $alg = preg_replace("/<603>/","WR",$alg);
    $alg = preg_replace("/<604>/","WF'",$alg); $alg = preg_replace("/<605>/","WF2",$alg); $alg = preg_replace("/<606>/","WF",$alg);
    $alg = preg_replace("/<607>/","WU'",$alg); $alg = preg_replace("/<608>/","WU2",$alg); $alg = preg_replace("/<609>/","WU",$alg);
    
    /* --- 6xC: CODE -> SSE: [4] Void twists --- */
    /* V */
    $alg = preg_replace("/<401>/","VR'",$alg); $alg = preg_replace("/<402>/","VR2",$alg); $alg = preg_replace("/<403>/","VR",$alg);
    $alg = preg_replace("/<404>/","VL'",$alg); $alg = preg_replace("/<405>/","VL2",$alg); $alg = preg_replace("/<406>/","VL",$alg);
    $alg = preg_replace("/<407>/","VF'",$alg); $alg = preg_replace("/<408>/","VF2",$alg); $alg = preg_replace("/<409>/","VF",$alg);
    $alg = preg_replace("/<410>/","VB'",$alg); $alg = preg_replace("/<411>/","VB2",$alg); $alg = preg_replace("/<412>/","VB",$alg);
    $alg = preg_replace("/<413>/","VU'",$alg); $alg = preg_replace("/<414>/","VU2",$alg); $alg = preg_replace("/<415>/","VU",$alg);
    $alg = preg_replace("/<416>/","VD'",$alg); $alg = preg_replace("/<417>/","VD2",$alg); $alg = preg_replace("/<418>/","VD",$alg);
    
    
    /* V3 */
    $alg = preg_replace("/<419>/","V3R'",$alg); $alg = preg_replace("/<420>/","V3R2",$alg); $alg = preg_replace("/<421>/","V3R",$alg);
    $alg = preg_replace("/<422>/","V3L'",$alg); $alg = preg_replace("/<423>/","V3L2",$alg); $alg = preg_replace("/<424>/","V3L",$alg);
    $alg = preg_replace("/<425>/","V3F'",$alg); $alg = preg_replace("/<426>/","V3F2",$alg); $alg = preg_replace("/<427>/","V3F",$alg);
    $alg = preg_replace("/<428>/","V3B'",$alg); $alg = preg_replace("/<429>/","V3B2",$alg); $alg = preg_replace("/<430>/","V3B",$alg);
    $alg = preg_replace("/<431>/","V3U'",$alg); $alg = preg_replace("/<432>/","V3U2",$alg); $alg = preg_replace("/<433>/","V3U",$alg);
    $alg = preg_replace("/<434>/","V3D'",$alg); $alg = preg_replace("/<435>/","V3D2",$alg); $alg = preg_replace("/<436>/","V3D",$alg);
    
    /* --- 6xC: CODE -> SSE: [5] Mid-layer twists --- */
    /* M2 */
    $alg = preg_replace("/<501>/","M2R'",$alg); $alg = preg_replace("/<502>/","M2R2",$alg); $alg = preg_replace("/<503>/","M2R",$alg);
    $alg = preg_replace("/<504>/","M2L'",$alg); $alg = preg_replace("/<505>/","M2L2",$alg); $alg = preg_replace("/<506>/","M2L",$alg);
    $alg = preg_replace("/<507>/","M2F'",$alg); $alg = preg_replace("/<508>/","M2F2",$alg); $alg = preg_replace("/<509>/","M2F",$alg);
    $alg = preg_replace("/<510>/","M2B'",$alg); $alg = preg_replace("/<511>/","M2B2",$alg); $alg = preg_replace("/<512>/","M2B",$alg);
    $alg = preg_replace("/<513>/","M2U'",$alg); $alg = preg_replace("/<514>/","M2U2",$alg); $alg = preg_replace("/<515>/","M2U",$alg);
    $alg = preg_replace("/<516>/","M2D'",$alg); $alg = preg_replace("/<517>/","M2D2",$alg); $alg = preg_replace("/<518>/","M2D",$alg);
    
    /* --- 6xC: CODE -> SSE: [1] Numbered layer twists --- */
    /* N2 | N5 */
    $alg = preg_replace("/<101>/","NR'",$alg); $alg = preg_replace("/<102>/","NR2",$alg); $alg = preg_replace("/<103>/","NR",$alg);
    $alg = preg_replace("/<104>/","NL'",$alg); $alg = preg_replace("/<105>/","NL2",$alg); $alg = preg_replace("/<106>/","NL",$alg);
    $alg = preg_replace("/<107>/","NF'",$alg); $alg = preg_replace("/<108>/","NF2",$alg); $alg = preg_replace("/<109>/","NF",$alg);
    $alg = preg_replace("/<110>/","NB'",$alg); $alg = preg_replace("/<111>/","NB2",$alg); $alg = preg_replace("/<112>/","NB",$alg);
    $alg = preg_replace("/<113>/","NU'",$alg); $alg = preg_replace("/<114>/","NU2",$alg); $alg = preg_replace("/<115>/","NU",$alg);
    $alg = preg_replace("/<116>/","ND'",$alg); $alg = preg_replace("/<117>/","ND2",$alg); $alg = preg_replace("/<118>/","ND",$alg);
    
    
    /* N3 | N4 */
    $alg = preg_replace("/<119>/","MR'",$alg); $alg = preg_replace("/<120>/","MR2",$alg); $alg = preg_replace("/<121>/","MR",$alg);
    $alg = preg_replace("/<122>/","ML'",$alg); $alg = preg_replace("/<123>/","ML2",$alg); $alg = preg_replace("/<124>/","ML",$alg);
    $alg = preg_replace("/<125>/","MF'",$alg); $alg = preg_replace("/<126>/","MF2",$alg); $alg = preg_replace("/<127>/","MF",$alg);
    $alg = preg_replace("/<128>/","MB'",$alg); $alg = preg_replace("/<129>/","MB2",$alg); $alg = preg_replace("/<130>/","MB",$alg);
    $alg = preg_replace("/<131>/","MU'",$alg); $alg = preg_replace("/<132>/","MU2",$alg); $alg = preg_replace("/<133>/","MU",$alg);
    $alg = preg_replace("/<134>/","MD'",$alg); $alg = preg_replace("/<135>/","MD2",$alg); $alg = preg_replace("/<136>/","MD",$alg);
    
    /* --- 6xC: CODE -> SSE: [3] Tier twists --- */
    /* T5 */
    $alg = preg_replace("/<301>/","T5R'",$alg); $alg = preg_replace("/<302>/","T5R2",$alg); $alg = preg_replace("/<303>/","T5R",$alg);
    $alg = preg_replace("/<304>/","T5L'",$alg); $alg = preg_replace("/<305>/","T5L2",$alg); $alg = preg_replace("/<306>/","T5L",$alg);
    $alg = preg_replace("/<307>/","T5F'",$alg); $alg = preg_replace("/<308>/","T5F2",$alg); $alg = preg_replace("/<309>/","T5F",$alg);
    $alg = preg_replace("/<310>/","T5B'",$alg); $alg = preg_replace("/<311>/","T5B2",$alg); $alg = preg_replace("/<312>/","T5B",$alg);
    $alg = preg_replace("/<313>/","T5U'",$alg); $alg = preg_replace("/<314>/","T5U2",$alg); $alg = preg_replace("/<315>/","T5U",$alg);
    $alg = preg_replace("/<316>/","T5D'",$alg); $alg = preg_replace("/<317>/","T5D2",$alg); $alg = preg_replace("/<318>/","T5D",$alg);
    
    
    /* T4 */
    $alg = preg_replace("/<319>/","T4R'",$alg); $alg = preg_replace("/<320>/","T4R2",$alg); $alg = preg_replace("/<321>/","T4R",$alg);
    $alg = preg_replace("/<322>/","T4L'",$alg); $alg = preg_replace("/<323>/","T4L2",$alg); $alg = preg_replace("/<324>/","T4L",$alg);
    $alg = preg_replace("/<325>/","T4F'",$alg); $alg = preg_replace("/<326>/","T4F2",$alg); $alg = preg_replace("/<327>/","T4F",$alg);
    $alg = preg_replace("/<328>/","T4B'",$alg); $alg = preg_replace("/<329>/","T4B2",$alg); $alg = preg_replace("/<330>/","T4B",$alg);
    $alg = preg_replace("/<331>/","T4U'",$alg); $alg = preg_replace("/<332>/","T4U2",$alg); $alg = preg_replace("/<333>/","T4U",$alg);
    $alg = preg_replace("/<334>/","T4D'",$alg); $alg = preg_replace("/<335>/","T4D2",$alg); $alg = preg_replace("/<336>/","T4D",$alg);
    
    
    /* T3 */
    $alg = preg_replace("/<337>/","T3R'",$alg); $alg = preg_replace("/<338>/","T3R2",$alg); $alg = preg_replace("/<339>/","T3R",$alg);
    $alg = preg_replace("/<340>/","T3L'",$alg); $alg = preg_replace("/<341>/","T3L2",$alg); $alg = preg_replace("/<342>/","T3L",$alg);
    $alg = preg_replace("/<343>/","T3F'",$alg); $alg = preg_replace("/<344>/","T3F2",$alg); $alg = preg_replace("/<345>/","T3F",$alg);
    $alg = preg_replace("/<346>/","T3B'",$alg); $alg = preg_replace("/<347>/","T3B2",$alg); $alg = preg_replace("/<348>/","T3B",$alg);
    $alg = preg_replace("/<349>/","T3U'",$alg); $alg = preg_replace("/<350>/","T3U2",$alg); $alg = preg_replace("/<351>/","T3U",$alg);
    $alg = preg_replace("/<352>/","T3D'",$alg); $alg = preg_replace("/<353>/","T3D2",$alg); $alg = preg_replace("/<354>/","T3D",$alg);
    
    
    /* T */
    $alg = preg_replace("/<355>/","TR'",$alg); $alg = preg_replace("/<356>/","TR2",$alg); $alg = preg_replace("/<357>/","TR",$alg);
    $alg = preg_replace("/<358>/","TL'",$alg); $alg = preg_replace("/<359>/","TL2",$alg); $alg = preg_replace("/<360>/","TL",$alg);
    $alg = preg_replace("/<361>/","TF'",$alg); $alg = preg_replace("/<362>/","TF2",$alg); $alg = preg_replace("/<363>/","TF",$alg);
    $alg = preg_replace("/<364>/","TB'",$alg); $alg = preg_replace("/<365>/","TB2",$alg); $alg = preg_replace("/<366>/","TB",$alg);
    $alg = preg_replace("/<367>/","TU'",$alg); $alg = preg_replace("/<368>/","TU2",$alg); $alg = preg_replace("/<369>/","TU",$alg);
    $alg = preg_replace("/<370>/","TD'",$alg); $alg = preg_replace("/<371>/","TD2",$alg); $alg = preg_replace("/<372>/","TD",$alg);
    
    /* --- 6xC: CODE -> SSE: [7] Cube rotations --- */
    /* C */
    $alg = preg_replace("/<701>/","CR'",$alg); $alg = preg_replace("/<702>/","CR2",$alg); $alg = preg_replace("/<703>/","CR",$alg);
    $alg = preg_replace("/<704>/","CF'",$alg); $alg = preg_replace("/<705>/","CF2",$alg); $alg = preg_replace("/<706>/","CF",$alg);
    $alg = preg_replace("/<707>/","CU'",$alg); $alg = preg_replace("/<708>/","CU2",$alg); $alg = preg_replace("/<709>/","CU",$alg);
    
    /* --- 6xC: CODE -> SSE: [9] Face twists --- */
    /*   */
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
    /* --- 7xC: SSE -> CODE: [1] Numbered-layer [5] Mid-layer twists --- */
    /* N | N6 */
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
    
    
    /* N3 | N5 */
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
    
    
    /* N4 = M */
    $alg = preg_replace("/N4R'/","<137>",$alg); $alg = preg_replace("/N4R-/","<137>",$alg);   $alg = preg_replace("/N4R2/","<138>",$alg);   $alg = preg_replace("/N4R/","<139>",$alg);
    $alg = preg_replace("/N4L'/","<139>",$alg); $alg = preg_replace("/N4L-/","<139>",$alg);   $alg = preg_replace("/N4L2/","<138>",$alg);   $alg = preg_replace("/N4L/","<137>",$alg);
    $alg = preg_replace("/N4F'/","<140>",$alg); $alg = preg_replace("/N4F-/","<140>",$alg);   $alg = preg_replace("/N4F2/","<141>",$alg);   $alg = preg_replace("/N4F/","<142>",$alg);
    $alg = preg_replace("/N4B'/","<142>",$alg); $alg = preg_replace("/N4B-/","<142>",$alg);   $alg = preg_replace("/N4B2/","<141>",$alg);   $alg = preg_replace("/N4B/","<140>",$alg);
    $alg = preg_replace("/N4U'/","<143>",$alg); $alg = preg_replace("/N4U-/","<143>",$alg);   $alg = preg_replace("/N4U2/","<144>",$alg);   $alg = preg_replace("/N4U/","<145>",$alg);
    $alg = preg_replace("/N4D'/","<145>",$alg); $alg = preg_replace("/N4D-/","<145>",$alg);   $alg = preg_replace("/N4D2/","<144>",$alg);   $alg = preg_replace("/N4D/","<143>",$alg);
    
    $alg = preg_replace("/MR'/","<137>",$alg); $alg = preg_replace("/MR-/","<137>",$alg);   $alg = preg_replace("/MR2/","<138>",$alg);   $alg = preg_replace("/MR/","<139>",$alg);
    $alg = preg_replace("/ML'/","<139>",$alg); $alg = preg_replace("/ML-/","<139>",$alg);   $alg = preg_replace("/ML2/","<138>",$alg);   $alg = preg_replace("/ML/","<137>",$alg);
    $alg = preg_replace("/MF'/","<140>",$alg); $alg = preg_replace("/MF-/","<140>",$alg);   $alg = preg_replace("/MF2/","<141>",$alg);   $alg = preg_replace("/MF/","<142>",$alg);
    $alg = preg_replace("/MB'/","<142>",$alg); $alg = preg_replace("/MB-/","<142>",$alg);   $alg = preg_replace("/MB2/","<141>",$alg);   $alg = preg_replace("/MB/","<140>",$alg);
    $alg = preg_replace("/MU'/","<143>",$alg); $alg = preg_replace("/MU-/","<143>",$alg);   $alg = preg_replace("/MU2/","<144>",$alg);   $alg = preg_replace("/MU/","<145>",$alg);
    $alg = preg_replace("/MD'/","<145>",$alg); $alg = preg_replace("/MD-/","<145>",$alg);   $alg = preg_replace("/MD2/","<144>",$alg);   $alg = preg_replace("/MD/","<143>",$alg);
    
    /* --- 7xC: SSE -> CODE: [2] Slice twists --- */
    /* S3 = S4-4 */
    $alg = preg_replace("/S3R'/","<201>",$alg); $alg = preg_replace("/S3R-/","<201>",$alg);   $alg = preg_replace("/S3R2/","<202>",$alg);   $alg = preg_replace("/S3R/","<203>",$alg);
    $alg = preg_replace("/S3L'/","<203>",$alg); $alg = preg_replace("/S3L-/","<203>",$alg);   $alg = preg_replace("/S3L2/","<202>",$alg);   $alg = preg_replace("/S3L/","<201>",$alg);
    $alg = preg_replace("/S3F'/","<204>",$alg); $alg = preg_replace("/S3F-/","<204>",$alg);   $alg = preg_replace("/S3F2/","<205>",$alg);   $alg = preg_replace("/S3F/","<206>",$alg);
    $alg = preg_replace("/S3B'/","<206>",$alg); $alg = preg_replace("/S3B-/","<206>",$alg);   $alg = preg_replace("/S3B2/","<205>",$alg);   $alg = preg_replace("/S3B/","<204>",$alg);
    $alg = preg_replace("/S3U'/","<207>",$alg); $alg = preg_replace("/S3U-/","<207>",$alg);   $alg = preg_replace("/S3U2/","<208>",$alg);   $alg = preg_replace("/S3U/","<209>",$alg);
    $alg = preg_replace("/S3D'/","<209>",$alg); $alg = preg_replace("/S3D-/","<209>",$alg);   $alg = preg_replace("/S3D2/","<208>",$alg);   $alg = preg_replace("/S3D/","<207>",$alg);
    
    $alg = preg_replace("/S4-4R'/","<201>",$alg); $alg = preg_replace("/S4-4R-/","<201>",$alg);   $alg = preg_replace("/S4-4R2/","<202>",$alg);   $alg = preg_replace("/S4-4R/","<203>",$alg);
    $alg = preg_replace("/S4-4L'/","<203>",$alg); $alg = preg_replace("/S4-4L-/","<203>",$alg);   $alg = preg_replace("/S4-4L2/","<202>",$alg);   $alg = preg_replace("/S4-4L/","<201>",$alg);
    $alg = preg_replace("/S4-4F'/","<204>",$alg); $alg = preg_replace("/S4-4F-/","<204>",$alg);   $alg = preg_replace("/S4-4F2/","<205>",$alg);   $alg = preg_replace("/S4-4F/","<206>",$alg);
    $alg = preg_replace("/S4-4B'/","<206>",$alg); $alg = preg_replace("/S4-4B-/","<206>",$alg);   $alg = preg_replace("/S4-4B2/","<205>",$alg);   $alg = preg_replace("/S4-4B/","<204>",$alg);
    $alg = preg_replace("/S4-4U'/","<207>",$alg); $alg = preg_replace("/S4-4U-/","<207>",$alg);   $alg = preg_replace("/S4-4U2/","<208>",$alg);   $alg = preg_replace("/S4-4U/","<209>",$alg);
    $alg = preg_replace("/S4-4D'/","<209>",$alg); $alg = preg_replace("/S4-4D-/","<209>",$alg);   $alg = preg_replace("/S4-4D2/","<208>",$alg);   $alg = preg_replace("/S4-4D/","<207>",$alg);
    
    
    /* S2 = S3-5 */
    $alg = preg_replace("/S2R'/","<210>",$alg); $alg = preg_replace("/S2R-/","<210>",$alg);   $alg = preg_replace("/S2R2/","<211>",$alg);   $alg = preg_replace("/S2R/","<212>",$alg);
    $alg = preg_replace("/S2L'/","<212>",$alg); $alg = preg_replace("/S2L-/","<212>",$alg);   $alg = preg_replace("/S2L2/","<211>",$alg);   $alg = preg_replace("/S2L/","<210>",$alg);
    $alg = preg_replace("/S2F'/","<213>",$alg); $alg = preg_replace("/S2F-/","<213>",$alg);   $alg = preg_replace("/S2F2/","<214>",$alg);   $alg = preg_replace("/S2F/","<215>",$alg);
    $alg = preg_replace("/S2B'/","<215>",$alg); $alg = preg_replace("/S2B-/","<215>",$alg);   $alg = preg_replace("/S2B2/","<214>",$alg);   $alg = preg_replace("/S2B/","<213>",$alg);
    $alg = preg_replace("/S2U'/","<216>",$alg); $alg = preg_replace("/S2U-/","<216>",$alg);   $alg = preg_replace("/S2U2/","<217>",$alg);   $alg = preg_replace("/S2U/","<218>",$alg);
    $alg = preg_replace("/S2D'/","<218>",$alg); $alg = preg_replace("/S2D-/","<218>",$alg);   $alg = preg_replace("/S2D2/","<217>",$alg);   $alg = preg_replace("/S2D/","<216>",$alg);
    
    $alg = preg_replace("/S3-5R'/","<210>",$alg); $alg = preg_replace("/S3-5R-/","<210>",$alg);   $alg = preg_replace("/S3-5R2/","<211>",$alg);   $alg = preg_replace("/S3-5R/","<212>",$alg);
    $alg = preg_replace("/S3-5L'/","<212>",$alg); $alg = preg_replace("/S3-5L-/","<212>",$alg);   $alg = preg_replace("/S3-5L2/","<211>",$alg);   $alg = preg_replace("/S3-5L/","<210>",$alg);
    $alg = preg_replace("/S3-5F'/","<213>",$alg); $alg = preg_replace("/S3-5F-/","<213>",$alg);   $alg = preg_replace("/S3-5F2/","<214>",$alg);   $alg = preg_replace("/S3-5F/","<215>",$alg);
    $alg = preg_replace("/S3-5B'/","<215>",$alg); $alg = preg_replace("/S3-5B-/","<215>",$alg);   $alg = preg_replace("/S3-5B2/","<214>",$alg);   $alg = preg_replace("/S3-5B/","<213>",$alg);
    $alg = preg_replace("/S3-5U'/","<216>",$alg); $alg = preg_replace("/S3-5U-/","<216>",$alg);   $alg = preg_replace("/S3-5U2/","<217>",$alg);   $alg = preg_replace("/S3-5U/","<218>",$alg);
    $alg = preg_replace("/S3-5D'/","<218>",$alg); $alg = preg_replace("/S3-5D-/","<218>",$alg);   $alg = preg_replace("/S3-5D2/","<217>",$alg);   $alg = preg_replace("/S3-5D/","<216>",$alg);
    
    
    /* S = S2-6 */
    $alg = preg_replace("/SR'/","<219>",$alg); $alg = preg_replace("/SR-/","<219>",$alg);   $alg = preg_replace("/SR2/","<220>",$alg);   $alg = preg_replace("/SR/","<221>",$alg);
    $alg = preg_replace("/SL'/","<221>",$alg); $alg = preg_replace("/SL-/","<221>",$alg);   $alg = preg_replace("/SL2/","<220>",$alg);   $alg = preg_replace("/SL/","<219>",$alg);
    $alg = preg_replace("/SF'/","<222>",$alg); $alg = preg_replace("/SF-/","<222>",$alg);   $alg = preg_replace("/SF2/","<223>",$alg);   $alg = preg_replace("/SF/","<224>",$alg);
    $alg = preg_replace("/SB'/","<224>",$alg); $alg = preg_replace("/SB-/","<224>",$alg);   $alg = preg_replace("/SB2/","<223>",$alg);   $alg = preg_replace("/SB/","<222>",$alg);
    $alg = preg_replace("/SU'/","<225>",$alg); $alg = preg_replace("/SU-/","<225>",$alg);   $alg = preg_replace("/SU2/","<226>",$alg);   $alg = preg_replace("/SU/","<227>",$alg);
    $alg = preg_replace("/SD'/","<227>",$alg); $alg = preg_replace("/SD-/","<227>",$alg);   $alg = preg_replace("/SD2/","<226>",$alg);   $alg = preg_replace("/SD/","<225>",$alg);
    
    $alg = preg_replace("/S2-6R'/","<219>",$alg); $alg = preg_replace("/S2-6R-/","<219>",$alg);   $alg = preg_replace("/S2-6R2/","<220>",$alg);   $alg = preg_replace("/S2-6R/","<221>",$alg);
    $alg = preg_replace("/S2-6L'/","<221>",$alg); $alg = preg_replace("/S2-6L-/","<221>",$alg);   $alg = preg_replace("/S2-6L2/","<220>",$alg);   $alg = preg_replace("/S2-6L/","<219>",$alg);
    $alg = preg_replace("/S2-6F'/","<222>",$alg); $alg = preg_replace("/S2-6F-/","<222>",$alg);   $alg = preg_replace("/S2-6F2/","<223>",$alg);   $alg = preg_replace("/S2-6F/","<224>",$alg);
    $alg = preg_replace("/S2-6B'/","<224>",$alg); $alg = preg_replace("/S2-6B-/","<224>",$alg);   $alg = preg_replace("/S2-6B2/","<223>",$alg);   $alg = preg_replace("/S2-6B/","<222>",$alg);
    $alg = preg_replace("/S2-6U'/","<225>",$alg); $alg = preg_replace("/S2-6U-/","<225>",$alg);   $alg = preg_replace("/S2-6U2/","<226>",$alg);   $alg = preg_replace("/S2-6U/","<227>",$alg);
    $alg = preg_replace("/S2-6D'/","<227>",$alg); $alg = preg_replace("/S2-6D-/","<227>",$alg);   $alg = preg_replace("/S2-6D2/","<226>",$alg);   $alg = preg_replace("/S2-6D/","<225>",$alg);
    
    
    /* S2-2 | S6-6 */
    $alg = preg_replace("/S2-2R'/","<228>",$alg); $alg = preg_replace("/S2-2R-/","<228>",$alg);   $alg = preg_replace("/S2-2R2/","<229>",$alg);   $alg = preg_replace("/S2-2R/","<230>",$alg);
    $alg = preg_replace("/S2-2L'/","<231>",$alg); $alg = preg_replace("/S2-2L-/","<231>",$alg);   $alg = preg_replace("/S2-2L2/","<232>",$alg);   $alg = preg_replace("/S2-2L/","<233>",$alg);
    $alg = preg_replace("/S2-2F'/","<234>",$alg); $alg = preg_replace("/S2-2F-/","<234>",$alg);   $alg = preg_replace("/S2-2F2/","<235>",$alg);   $alg = preg_replace("/S2-2F/","<236>",$alg);
    $alg = preg_replace("/S2-2B'/","<237>",$alg); $alg = preg_replace("/S2-2B-/","<237>",$alg);   $alg = preg_replace("/S2-2B2/","<238>",$alg);   $alg = preg_replace("/S2-2B/","<239>",$alg);
    $alg = preg_replace("/S2-2U'/","<240>",$alg); $alg = preg_replace("/S2-2U-/","<240>",$alg);   $alg = preg_replace("/S2-2U2/","<241>",$alg);   $alg = preg_replace("/S2-2U/","<242>",$alg);
    $alg = preg_replace("/S2-2D'/","<243>",$alg); $alg = preg_replace("/S2-2D-/","<243>",$alg);   $alg = preg_replace("/S2-2D2/","<244>",$alg);   $alg = preg_replace("/S2-2D/","<245>",$alg);
    
    $alg = preg_replace("/S6-6R'/","<233>",$alg); $alg = preg_replace("/S6-6R-/","<233>",$alg);   $alg = preg_replace("/S6-6R2/","<232>",$alg);   $alg = preg_replace("/S6-6R/","<231>",$alg);
    $alg = preg_replace("/S6-6L'/","<230>",$alg); $alg = preg_replace("/S6-6L-/","<230>",$alg);   $alg = preg_replace("/S6-6L2/","<229>",$alg);   $alg = preg_replace("/S6-6L/","<228>",$alg);
    $alg = preg_replace("/S6-6F'/","<239>",$alg); $alg = preg_replace("/S6-6F-/","<239>",$alg);   $alg = preg_replace("/S6-6F2/","<238>",$alg);   $alg = preg_replace("/S6-6F/","<237>",$alg);
    $alg = preg_replace("/S6-6B'/","<236>",$alg); $alg = preg_replace("/S6-6B-/","<236>",$alg);   $alg = preg_replace("/S6-6B2/","<235>",$alg);   $alg = preg_replace("/S6-6B/","<234>",$alg);
    $alg = preg_replace("/S6-6U'/","<245>",$alg); $alg = preg_replace("/S6-6U-/","<245>",$alg);   $alg = preg_replace("/S6-6U2/","<244>",$alg);   $alg = preg_replace("/S6-6U/","<243>",$alg);
    $alg = preg_replace("/S6-6D'/","<242>",$alg); $alg = preg_replace("/S6-6D-/","<242>",$alg);   $alg = preg_replace("/S6-6D2/","<241>",$alg);   $alg = preg_replace("/S6-6D/","<240>",$alg);
    
    
    /* S2-3 | S5-6 */
    $alg = preg_replace("/S2-3R'/","<246>",$alg); $alg = preg_replace("/S2-3R-/","<246>",$alg);   $alg = preg_replace("/S2-3R2/","<247>",$alg);   $alg = preg_replace("/S2-3R/","<248>",$alg);
    $alg = preg_replace("/S2-3L'/","<249>",$alg); $alg = preg_replace("/S2-3L-/","<249>",$alg);   $alg = preg_replace("/S2-3L2/","<250>",$alg);   $alg = preg_replace("/S2-3L/","<251>",$alg);
    $alg = preg_replace("/S2-3F'/","<252>",$alg); $alg = preg_replace("/S2-3F-/","<252>",$alg);   $alg = preg_replace("/S2-3F2/","<253>",$alg);   $alg = preg_replace("/S2-3F/","<254>",$alg);
    $alg = preg_replace("/S2-3B'/","<255>",$alg); $alg = preg_replace("/S2-3B-/","<255>",$alg);   $alg = preg_replace("/S2-3B2/","<256>",$alg);   $alg = preg_replace("/S2-3B/","<257>",$alg);
    $alg = preg_replace("/S2-3U'/","<258>",$alg); $alg = preg_replace("/S2-3U-/","<258>",$alg);   $alg = preg_replace("/S2-3U2/","<259>",$alg);   $alg = preg_replace("/S2-3U/","<260>",$alg);
    $alg = preg_replace("/S2-3D'/","<261>",$alg); $alg = preg_replace("/S2-3D-/","<261>",$alg);   $alg = preg_replace("/S2-3D2/","<262>",$alg);   $alg = preg_replace("/S2-3D/","<263>",$alg);
    
    $alg = preg_replace("/S5-6R'/","<251>",$alg); $alg = preg_replace("/S5-6R-/","<251>",$alg);   $alg = preg_replace("/S5-6R2/","<250>",$alg);   $alg = preg_replace("/S5-6R/","<249>",$alg);
    $alg = preg_replace("/S5-6L'/","<248>",$alg); $alg = preg_replace("/S5-6L-/","<248>",$alg);   $alg = preg_replace("/S5-6L2/","<247>",$alg);   $alg = preg_replace("/S5-6L/","<246>",$alg);
    $alg = preg_replace("/S5-6F'/","<257>",$alg); $alg = preg_replace("/S5-6F-/","<257>",$alg);   $alg = preg_replace("/S5-6F2/","<256>",$alg);   $alg = preg_replace("/S5-6F/","<255>",$alg);
    $alg = preg_replace("/S5-6B'/","<254>",$alg); $alg = preg_replace("/S5-6B-/","<254>",$alg);   $alg = preg_replace("/S5-6B2/","<253>",$alg);   $alg = preg_replace("/S5-6B/","<252>",$alg);
    $alg = preg_replace("/S5-6U'/","<263>",$alg); $alg = preg_replace("/S5-6U-/","<263>",$alg);   $alg = preg_replace("/S5-6U2/","<262>",$alg);   $alg = preg_replace("/S5-6U/","<261>",$alg);
    $alg = preg_replace("/S5-6D'/","<260>",$alg); $alg = preg_replace("/S5-6D-/","<260>",$alg);   $alg = preg_replace("/S5-6D2/","<259>",$alg);   $alg = preg_replace("/S5-6D/","<258>",$alg);
    
    
    /* S2-4 | S4-6 */
    $alg = preg_replace("/S2-4R'/","<264>",$alg); $alg = preg_replace("/S2-4R-/","<264>",$alg);   $alg = preg_replace("/S2-4R2/","<265>",$alg);   $alg = preg_replace("/S2-4R/","<266>",$alg);
    $alg = preg_replace("/S2-4L'/","<267>",$alg); $alg = preg_replace("/S2-4L-/","<267>",$alg);   $alg = preg_replace("/S2-4L2/","<268>",$alg);   $alg = preg_replace("/S2-4L/","<269>",$alg);
    $alg = preg_replace("/S2-4F'/","<270>",$alg); $alg = preg_replace("/S2-4F-/","<270>",$alg);   $alg = preg_replace("/S2-4F2/","<271>",$alg);   $alg = preg_replace("/S2-4F/","<272>",$alg);
    $alg = preg_replace("/S2-4B'/","<273>",$alg); $alg = preg_replace("/S2-4B-/","<273>",$alg);   $alg = preg_replace("/S2-4B2/","<274>",$alg);   $alg = preg_replace("/S2-4B/","<275>",$alg);
    $alg = preg_replace("/S2-4U'/","<276>",$alg); $alg = preg_replace("/S2-4U-/","<276>",$alg);   $alg = preg_replace("/S2-4U2/","<277>",$alg);   $alg = preg_replace("/S2-4U/","<278>",$alg);
    $alg = preg_replace("/S2-4D'/","<279>",$alg); $alg = preg_replace("/S2-4D-/","<279>",$alg);   $alg = preg_replace("/S2-4D2/","<280>",$alg);   $alg = preg_replace("/S2-4D/","<281>",$alg);
    
    $alg = preg_replace("/S4-6R'/","<269>",$alg); $alg = preg_replace("/S4-6R-/","<269>",$alg);   $alg = preg_replace("/S4-6R2/","<268>",$alg);   $alg = preg_replace("/S4-6R/","<267>",$alg);
    $alg = preg_replace("/S4-6L'/","<266>",$alg); $alg = preg_replace("/S4-6L-/","<266>",$alg);   $alg = preg_replace("/S4-6L2/","<265>",$alg);   $alg = preg_replace("/S4-6L/","<264>",$alg);
    $alg = preg_replace("/S4-6F'/","<275>",$alg); $alg = preg_replace("/S4-6F-/","<275>",$alg);   $alg = preg_replace("/S4-6F2/","<274>",$alg);   $alg = preg_replace("/S4-6F/","<273>",$alg);
    $alg = preg_replace("/S4-6B'/","<272>",$alg); $alg = preg_replace("/S4-6B-/","<272>",$alg);   $alg = preg_replace("/S4-6B2/","<271>",$alg);   $alg = preg_replace("/S4-6B/","<270>",$alg);
    $alg = preg_replace("/S4-6U'/","<281>",$alg); $alg = preg_replace("/S4-6U-/","<281>",$alg);   $alg = preg_replace("/S4-6U2/","<280>",$alg);   $alg = preg_replace("/S4-6U/","<279>",$alg);
    $alg = preg_replace("/S4-6D'/","<278>",$alg); $alg = preg_replace("/S4-6D-/","<278>",$alg);   $alg = preg_replace("/S4-6D2/","<277>",$alg);   $alg = preg_replace("/S4-6D/","<276>",$alg);
    
    
    /* S2-5 | S3-6 */
    $alg = preg_replace("/S2-5R'/","<282>",$alg); $alg = preg_replace("/S2-5R-/","<282>",$alg);   $alg = preg_replace("/S2-5R2/","<283>",$alg);   $alg = preg_replace("/S2-5R/","<284>",$alg);
    $alg = preg_replace("/S2-5L'/","<285>",$alg); $alg = preg_replace("/S2-5L-/","<285>",$alg);   $alg = preg_replace("/S2-5L2/","<286>",$alg);   $alg = preg_replace("/S2-5L/","<287>",$alg);
    $alg = preg_replace("/S2-5F'/","<288>",$alg); $alg = preg_replace("/S2-5F-/","<288>",$alg);   $alg = preg_replace("/S2-5F2/","<289>",$alg);   $alg = preg_replace("/S2-5F/","<290>",$alg);
    $alg = preg_replace("/S2-5B'/","<291>",$alg); $alg = preg_replace("/S2-5B-/","<291>",$alg);   $alg = preg_replace("/S2-5B2/","<292>",$alg);   $alg = preg_replace("/S2-5B/","<293>",$alg);
    $alg = preg_replace("/S2-5U'/","<294>",$alg); $alg = preg_replace("/S2-5U-/","<294>",$alg);   $alg = preg_replace("/S2-5U2/","<295>",$alg);   $alg = preg_replace("/S2-5U/","<296>",$alg);
    $alg = preg_replace("/S2-5D'/","<297>",$alg); $alg = preg_replace("/S2-5D-/","<297>",$alg);   $alg = preg_replace("/S2-5D2/","<298>",$alg);   $alg = preg_replace("/S2-5D/","<299>",$alg);
    
    $alg = preg_replace("/S3-6R'/","<287>",$alg); $alg = preg_replace("/S3-6R-/","<287>",$alg);   $alg = preg_replace("/S3-6R2/","<286>",$alg);   $alg = preg_replace("/S3-6R/","<285>",$alg);
    $alg = preg_replace("/S3-6L'/","<284>",$alg); $alg = preg_replace("/S3-6L-/","<284>",$alg);   $alg = preg_replace("/S3-6L2/","<283>",$alg);   $alg = preg_replace("/S3-6L/","<282>",$alg);
    $alg = preg_replace("/S3-6F'/","<293>",$alg); $alg = preg_replace("/S3-6F-/","<293>",$alg);   $alg = preg_replace("/S3-6F2/","<292>",$alg);   $alg = preg_replace("/S3-6F/","<291>",$alg);
    $alg = preg_replace("/S3-6B'/","<290>",$alg); $alg = preg_replace("/S3-6B-/","<290>",$alg);   $alg = preg_replace("/S3-6B2/","<289>",$alg);   $alg = preg_replace("/S3-6B/","<288>",$alg);
    $alg = preg_replace("/S3-6U'/","<299>",$alg); $alg = preg_replace("/S3-6U-/","<299>",$alg);   $alg = preg_replace("/S3-6U2/","<298>",$alg);   $alg = preg_replace("/S3-6U/","<297>",$alg);
    $alg = preg_replace("/S3-6D'/","<296>",$alg); $alg = preg_replace("/S3-6D-/","<296>",$alg);   $alg = preg_replace("/S3-6D2/","<295>",$alg);   $alg = preg_replace("/S3-6D/","<294>",$alg);
    
    
    /* S3-3 | S5-5 */
    $alg = preg_replace("/S3-3R'/","<2100>",$alg); $alg = preg_replace("/S3-3R-/","<2100>",$alg);   $alg = preg_replace("/S3-3R2/","<2101>",$alg);   $alg = preg_replace("/S3-3R/","<2102>",$alg);
    $alg = preg_replace("/S3-3L'/","<2103>",$alg); $alg = preg_replace("/S3-3L-/","<2103>",$alg);   $alg = preg_replace("/S3-3L2/","<2104>",$alg);   $alg = preg_replace("/S3-3L/","<2105>",$alg);
    $alg = preg_replace("/S3-3F'/","<2106>",$alg); $alg = preg_replace("/S3-3F-/","<2106>",$alg);   $alg = preg_replace("/S3-3F2/","<2107>",$alg);   $alg = preg_replace("/S3-3F/","<2108>",$alg);
    $alg = preg_replace("/S3-3B'/","<2109>",$alg); $alg = preg_replace("/S3-3B-/","<2109>",$alg);   $alg = preg_replace("/S3-3B2/","<2110>",$alg);   $alg = preg_replace("/S3-3B/","<2111>",$alg);
    $alg = preg_replace("/S3-3U'/","<2112>",$alg); $alg = preg_replace("/S3-3U-/","<2112>",$alg);   $alg = preg_replace("/S3-3U2/","<2113>",$alg);   $alg = preg_replace("/S3-3U/","<2114>",$alg);
    $alg = preg_replace("/S3-3D'/","<2115>",$alg); $alg = preg_replace("/S3-3D-/","<2115>",$alg);   $alg = preg_replace("/S3-3D2/","<2116>",$alg);   $alg = preg_replace("/S3-3D/","<2117>",$alg);
    
    $alg = preg_replace("/S5-5R'/","<2105>",$alg); $alg = preg_replace("/S5-5R-/","<2105>",$alg);   $alg = preg_replace("/S5-5R2/","<2104>",$alg);   $alg = preg_replace("/S5-5R/","<2103>",$alg);
    $alg = preg_replace("/S5-5L'/","<2102>",$alg); $alg = preg_replace("/S5-5L-/","<2102>",$alg);   $alg = preg_replace("/S5-5L2/","<2101>",$alg);   $alg = preg_replace("/S5-5L/","<2100>",$alg);
    $alg = preg_replace("/S5-5F'/","<2111>",$alg); $alg = preg_replace("/S5-5F-/","<2111>",$alg);   $alg = preg_replace("/S5-5F2/","<2110>",$alg);   $alg = preg_replace("/S5-5F/","<2109>",$alg);
    $alg = preg_replace("/S5-5B'/","<2108>",$alg); $alg = preg_replace("/S5-5B-/","<2108>",$alg);   $alg = preg_replace("/S5-5B2/","<2107>",$alg);   $alg = preg_replace("/S5-5B/","<2106>",$alg);
    $alg = preg_replace("/S5-5U'/","<2117>",$alg); $alg = preg_replace("/S5-5U-/","<2117>",$alg);   $alg = preg_replace("/S5-5U2/","<2116>",$alg);   $alg = preg_replace("/S5-5U/","<2115>",$alg);
    $alg = preg_replace("/S5-5D'/","<2114>",$alg); $alg = preg_replace("/S5-5D-/","<2114>",$alg);   $alg = preg_replace("/S5-5D2/","<2113>",$alg);   $alg = preg_replace("/S5-5D/","<2112>",$alg);
    
    
    /* S3-4 | S4-5 */
    $alg = preg_replace("/S3-4R'/","<2118>",$alg); $alg = preg_replace("/S3-4R-/","<2118>",$alg);   $alg = preg_replace("/S3-4R2/","<2119>",$alg);   $alg = preg_replace("/S3-4R/","<2120>",$alg);
    $alg = preg_replace("/S3-4L'/","<2121>",$alg); $alg = preg_replace("/S3-4L-/","<2121>",$alg);   $alg = preg_replace("/S3-4L2/","<2122>",$alg);   $alg = preg_replace("/S3-4L/","<2123>",$alg);
    $alg = preg_replace("/S3-4F'/","<2124>",$alg); $alg = preg_replace("/S3-4F-/","<2124>",$alg);   $alg = preg_replace("/S3-4F2/","<2125>",$alg);   $alg = preg_replace("/S3-4F/","<2126>",$alg);
    $alg = preg_replace("/S3-4B'/","<2127>",$alg); $alg = preg_replace("/S3-4B-/","<2127>",$alg);   $alg = preg_replace("/S3-4B2/","<2128>",$alg);   $alg = preg_replace("/S3-4B/","<2129>",$alg);
    $alg = preg_replace("/S3-4U'/","<2130>",$alg); $alg = preg_replace("/S3-4U-/","<2130>",$alg);   $alg = preg_replace("/S3-4U2/","<2131>",$alg);   $alg = preg_replace("/S3-4U/","<2132>",$alg);
    $alg = preg_replace("/S3-4D'/","<2133>",$alg); $alg = preg_replace("/S3-4D-/","<2133>",$alg);   $alg = preg_replace("/S3-4D2/","<2134>",$alg);   $alg = preg_replace("/S3-4D/","<2135>",$alg);
    
    $alg = preg_replace("/S4-5R'/","<2123>",$alg); $alg = preg_replace("/S4-5R-/","<2123>",$alg);   $alg = preg_replace("/S4-5R2/","<2122>",$alg);   $alg = preg_replace("/S4-5R/","<2121>",$alg);
    $alg = preg_replace("/S4-5L'/","<2120>",$alg); $alg = preg_replace("/S4-5L-/","<2120>",$alg);   $alg = preg_replace("/S4-5L2/","<2119>",$alg);   $alg = preg_replace("/S4-5L/","<2118>",$alg);
    $alg = preg_replace("/S4-5F'/","<2129>",$alg); $alg = preg_replace("/S4-5F-/","<2129>",$alg);   $alg = preg_replace("/S4-5F2/","<2128>",$alg);   $alg = preg_replace("/S4-5F/","<2127>",$alg);
    $alg = preg_replace("/S4-5B'/","<2126>",$alg); $alg = preg_replace("/S4-5B-/","<2126>",$alg);   $alg = preg_replace("/S4-5B2/","<2125>",$alg);   $alg = preg_replace("/S4-5B/","<2124>",$alg);
    $alg = preg_replace("/S4-5U'/","<2135>",$alg); $alg = preg_replace("/S4-5U-/","<2135>",$alg);   $alg = preg_replace("/S4-5U2/","<2134>",$alg);   $alg = preg_replace("/S4-5U/","<2133>",$alg);
    $alg = preg_replace("/S4-5D'/","<2132>",$alg); $alg = preg_replace("/S4-5D-/","<2132>",$alg);   $alg = preg_replace("/S4-5D2/","<2131>",$alg);   $alg = preg_replace("/S4-5D/","<2130>",$alg);
    
    /* --- 7xC: SSE -> CODE: [3] Tier twists --- */
    /* T6 */
    $alg = preg_replace("/T6R'/","<301>",$alg); $alg = preg_replace("/T6R-/","<301>",$alg);   $alg = preg_replace("/T6R2/","<302>",$alg);   $alg = preg_replace("/T6R/","<303>",$alg);
    $alg = preg_replace("/T6L'/","<304>",$alg); $alg = preg_replace("/T6L-/","<304>",$alg);   $alg = preg_replace("/T6L2/","<305>",$alg);   $alg = preg_replace("/T6L/","<306>",$alg);
    $alg = preg_replace("/T6F'/","<307>",$alg); $alg = preg_replace("/T6F-/","<307>",$alg);   $alg = preg_replace("/T6F2/","<308>",$alg);   $alg = preg_replace("/T6F/","<309>",$alg);
    $alg = preg_replace("/T6B'/","<310>",$alg); $alg = preg_replace("/T6B-/","<310>",$alg);   $alg = preg_replace("/T6B2/","<311>",$alg);   $alg = preg_replace("/T6B/","<312>",$alg);
    $alg = preg_replace("/T6U'/","<313>",$alg); $alg = preg_replace("/T6U-/","<313>",$alg);   $alg = preg_replace("/T6U2/","<314>",$alg);   $alg = preg_replace("/T6U/","<315>",$alg);
    $alg = preg_replace("/T6D'/","<316>",$alg); $alg = preg_replace("/T6D-/","<316>",$alg);   $alg = preg_replace("/T6D2/","<317>",$alg);   $alg = preg_replace("/T6D/","<318>",$alg);
    
    
    /* T5 */
    $alg = preg_replace("/T5R'/","<319>",$alg); $alg = preg_replace("/T5R-/","<319>",$alg);   $alg = preg_replace("/T5R2/","<320>",$alg);   $alg = preg_replace("/T5R/","<321>",$alg);
    $alg = preg_replace("/T5L'/","<322>",$alg); $alg = preg_replace("/T5L-/","<322>",$alg);   $alg = preg_replace("/T5L2/","<323>",$alg);   $alg = preg_replace("/T5L/","<324>",$alg);
    $alg = preg_replace("/T5F'/","<325>",$alg); $alg = preg_replace("/T5F-/","<325>",$alg);   $alg = preg_replace("/T5F2/","<326>",$alg);   $alg = preg_replace("/T5F/","<327>",$alg);
    $alg = preg_replace("/T5B'/","<328>",$alg); $alg = preg_replace("/T5B-/","<328>",$alg);   $alg = preg_replace("/T5B2/","<329>",$alg);   $alg = preg_replace("/T5B/","<330>",$alg);
    $alg = preg_replace("/T5U'/","<331>",$alg); $alg = preg_replace("/T5U-/","<331>",$alg);   $alg = preg_replace("/T5U2/","<332>",$alg);   $alg = preg_replace("/T5U/","<333>",$alg);
    $alg = preg_replace("/T5D'/","<334>",$alg); $alg = preg_replace("/T5D-/","<334>",$alg);   $alg = preg_replace("/T5D2/","<335>",$alg);   $alg = preg_replace("/T5D/","<336>",$alg);
    
    
    /* T4 */
    $alg = preg_replace("/T4R'/","<337>",$alg); $alg = preg_replace("/T4R-/","<337>",$alg);   $alg = preg_replace("/T4R2/","<338>",$alg);   $alg = preg_replace("/T4R/","<339>",$alg);
    $alg = preg_replace("/T4L'/","<340>",$alg); $alg = preg_replace("/T4L-/","<340>",$alg);   $alg = preg_replace("/T4L2/","<341>",$alg);   $alg = preg_replace("/T4L/","<342>",$alg);
    $alg = preg_replace("/T4F'/","<343>",$alg); $alg = preg_replace("/T4F-/","<343>",$alg);   $alg = preg_replace("/T4F2/","<344>",$alg);   $alg = preg_replace("/T4F/","<345>",$alg);
    $alg = preg_replace("/T4B'/","<346>",$alg); $alg = preg_replace("/T4B-/","<346>",$alg);   $alg = preg_replace("/T4B2/","<347>",$alg);   $alg = preg_replace("/T4B/","<348>",$alg);
    $alg = preg_replace("/T4U'/","<349>",$alg); $alg = preg_replace("/T4U-/","<349>",$alg);   $alg = preg_replace("/T4U2/","<350>",$alg);   $alg = preg_replace("/T4U/","<351>",$alg);
    $alg = preg_replace("/T4D'/","<352>",$alg); $alg = preg_replace("/T4D-/","<352>",$alg);   $alg = preg_replace("/T4D2/","<353>",$alg);   $alg = preg_replace("/T4D/","<354>",$alg);
    
    
    /* T3 */
    $alg = preg_replace("/T3R'/","<355>",$alg); $alg = preg_replace("/T3R-/","<355>",$alg);   $alg = preg_replace("/T3R2/","<356>",$alg);   $alg = preg_replace("/T3R/","<357>",$alg);
    $alg = preg_replace("/T3L'/","<358>",$alg); $alg = preg_replace("/T3L-/","<358>",$alg);   $alg = preg_replace("/T3L2/","<359>",$alg);   $alg = preg_replace("/T3L/","<360>",$alg);
    $alg = preg_replace("/T3F'/","<361>",$alg); $alg = preg_replace("/T3F-/","<361>",$alg);   $alg = preg_replace("/T3F2/","<362>",$alg);   $alg = preg_replace("/T3F/","<363>",$alg);
    $alg = preg_replace("/T3B'/","<364>",$alg); $alg = preg_replace("/T3B-/","<364>",$alg);   $alg = preg_replace("/T3B2/","<365>",$alg);   $alg = preg_replace("/T3B/","<366>",$alg);
    $alg = preg_replace("/T3U'/","<367>",$alg); $alg = preg_replace("/T3U-/","<367>",$alg);   $alg = preg_replace("/T3U2/","<368>",$alg);   $alg = preg_replace("/T3U/","<369>",$alg);
    $alg = preg_replace("/T3D'/","<370>",$alg); $alg = preg_replace("/T3D-/","<370>",$alg);   $alg = preg_replace("/T3D2/","<371>",$alg);   $alg = preg_replace("/T3D/","<372>",$alg);
    
    
    /* T */
    $alg = preg_replace("/TR'/","<373>",$alg); $alg = preg_replace("/TR-/","<373>",$alg);   $alg = preg_replace("/TR2/","<374>",$alg);   $alg = preg_replace("/TR/","<375>",$alg);
    $alg = preg_replace("/TL'/","<376>",$alg); $alg = preg_replace("/TL-/","<376>",$alg);   $alg = preg_replace("/TL2/","<377>",$alg);   $alg = preg_replace("/TL/","<378>",$alg);
    $alg = preg_replace("/TF'/","<379>",$alg); $alg = preg_replace("/TF-/","<379>",$alg);   $alg = preg_replace("/TF2/","<380>",$alg);   $alg = preg_replace("/TF/","<381>",$alg);
    $alg = preg_replace("/TB'/","<382>",$alg); $alg = preg_replace("/TB-/","<382>",$alg);   $alg = preg_replace("/TB2/","<383>",$alg);   $alg = preg_replace("/TB/","<384>",$alg);
    $alg = preg_replace("/TU'/","<385>",$alg); $alg = preg_replace("/TU-/","<385>",$alg);   $alg = preg_replace("/TU2/","<386>",$alg);   $alg = preg_replace("/TU/","<387>",$alg);
    $alg = preg_replace("/TD'/","<388>",$alg); $alg = preg_replace("/TD-/","<388>",$alg);   $alg = preg_replace("/TD2/","<389>",$alg);   $alg = preg_replace("/TD/","<390>",$alg);
    
    /* --- 7xC: SSE -> CODE: [4] Void [1] (Numbered layer) twists--- */
    /* V4 = M4 = N2-5 | V4 = M4 = N3-6 */
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
    
    $alg = preg_replace("/N3-6R'/","<406>",$alg); $alg = preg_replace("/N3-6R-/","<406>",$alg);   $alg = preg_replace("/N3-6R2/","<405>",$alg);   $alg = preg_replace("/N3-6R/","<404>",$alg);
    $alg = preg_replace("/N3-6L'/","<403>",$alg); $alg = preg_replace("/N3-6L-/","<403>",$alg);   $alg = preg_replace("/N3-6L2/","<402>",$alg);   $alg = preg_replace("/N3-6L/","<401>",$alg);
    $alg = preg_replace("/N3-6F'/","<412>",$alg); $alg = preg_replace("/N3-6F-/","<412>",$alg);   $alg = preg_replace("/N3-6F2/","<411>",$alg);   $alg = preg_replace("/N3-6F/","<410>",$alg);
    $alg = preg_replace("/N3-6B'/","<409>",$alg); $alg = preg_replace("/N3-6B-/","<409>",$alg);   $alg = preg_replace("/N3-6B2/","<408>",$alg);   $alg = preg_replace("/N3-6B/","<407>",$alg);
    $alg = preg_replace("/N3-6U'/","<418>",$alg); $alg = preg_replace("/N3-6U-/","<418>",$alg);   $alg = preg_replace("/N3-6U2/","<417>",$alg);   $alg = preg_replace("/N3-6U/","<416>",$alg);
    $alg = preg_replace("/N3-6D'/","<415>",$alg); $alg = preg_replace("/N3-6D-/","<415>",$alg);   $alg = preg_replace("/N3-6D2/","<414>",$alg);   $alg = preg_replace("/N3-6D/","<413>",$alg);
    
    $alg = preg_replace("/M4R'/","<401>",$alg); $alg = preg_replace("/M4R-/","<401>",$alg);   $alg = preg_replace("/M4R2/","<402>",$alg);   $alg = preg_replace("/M4R/","<403>",$alg);
    $alg = preg_replace("/M4L'/","<404>",$alg); $alg = preg_replace("/M4L-/","<404>",$alg);   $alg = preg_replace("/M4L2/","<405>",$alg);   $alg = preg_replace("/M4L/","<406>",$alg);
    $alg = preg_replace("/M4F'/","<407>",$alg); $alg = preg_replace("/M4F-/","<407>",$alg);   $alg = preg_replace("/M4F2/","<408>",$alg);   $alg = preg_replace("/M4F/","<409>",$alg);
    $alg = preg_replace("/M4B'/","<410>",$alg); $alg = preg_replace("/M4B-/","<410>",$alg);   $alg = preg_replace("/M4B2/","<411>",$alg);   $alg = preg_replace("/M4B/","<412>",$alg);
    $alg = preg_replace("/M4U'/","<413>",$alg); $alg = preg_replace("/M4U-/","<413>",$alg);   $alg = preg_replace("/M4U2/","<414>",$alg);   $alg = preg_replace("/M4U/","<415>",$alg);
    $alg = preg_replace("/M4D'/","<416>",$alg); $alg = preg_replace("/M4D-/","<416>",$alg);   $alg = preg_replace("/M4D2/","<417>",$alg);   $alg = preg_replace("/M4D/","<418>",$alg);
    
    
    /* V3 = N2-4 | V3 = N4-6 */
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
    
    $alg = preg_replace("/N4-6R'/","<424>",$alg); $alg = preg_replace("/N4-6R-/","<424>",$alg);   $alg = preg_replace("/N4-6R2/","<423>",$alg);   $alg = preg_replace("/N4-6R/","<422>",$alg);
    $alg = preg_replace("/N4-6L'/","<421>",$alg); $alg = preg_replace("/N4-6L-/","<421>",$alg);   $alg = preg_replace("/N4-6L2/","<420>",$alg);   $alg = preg_replace("/N4-6L/","<419>",$alg);
    $alg = preg_replace("/N4-6F'/","<430>",$alg); $alg = preg_replace("/N4-6F-/","<430>",$alg);   $alg = preg_replace("/N4-6F2/","<429>",$alg);   $alg = preg_replace("/N4-6F/","<428>",$alg);
    $alg = preg_replace("/N4-6B'/","<427>",$alg); $alg = preg_replace("/N4-6B-/","<427>",$alg);   $alg = preg_replace("/N4-6B2/","<426>",$alg);   $alg = preg_replace("/N4-6B/","<425>",$alg);
    $alg = preg_replace("/N4-6U'/","<436>",$alg); $alg = preg_replace("/N4-6U-/","<436>",$alg);   $alg = preg_replace("/N4-6U2/","<435>",$alg);   $alg = preg_replace("/N4-6U/","<434>",$alg);
    $alg = preg_replace("/N4-6D'/","<433>",$alg); $alg = preg_replace("/N4-6D-/","<433>",$alg);   $alg = preg_replace("/N4-6D2/","<432>",$alg);   $alg = preg_replace("/N4-6D/","<431>",$alg);
    
    
    /* V = N2-3 | V = N5-6 */
    $alg = preg_replace("/VR'/","<437>",$alg); $alg = preg_replace("/VR-/","<437>",$alg);   $alg = preg_replace("/VR2/","<438>",$alg);   $alg = preg_replace("/VR/","<439>",$alg);
    $alg = preg_replace("/VL'/","<440>",$alg); $alg = preg_replace("/VL-/","<440>",$alg);   $alg = preg_replace("/VL2/","<441>",$alg);   $alg = preg_replace("/VL/","<442>",$alg);
    $alg = preg_replace("/VF'/","<443>",$alg); $alg = preg_replace("/VF-/","<443>",$alg);   $alg = preg_replace("/VF2/","<444>",$alg);   $alg = preg_replace("/VF/","<445>",$alg);
    $alg = preg_replace("/VB'/","<446>",$alg); $alg = preg_replace("/VB-/","<446>",$alg);   $alg = preg_replace("/VB2/","<447>",$alg);   $alg = preg_replace("/VB/","<448>",$alg);
    $alg = preg_replace("/VU'/","<449>",$alg); $alg = preg_replace("/VU-/","<449>",$alg);   $alg = preg_replace("/VU2/","<450>",$alg);   $alg = preg_replace("/VU/","<451>",$alg);
    $alg = preg_replace("/VD'/","<452>",$alg); $alg = preg_replace("/VD-/","<452>",$alg);   $alg = preg_replace("/VD2/","<453>",$alg);   $alg = preg_replace("/VD/","<454>",$alg);
    
    $alg = preg_replace("/N2-3R'/","<437>",$alg); $alg = preg_replace("/N2-3R-/","<437>",$alg);   $alg = preg_replace("/N2-3R2/","<438>",$alg);   $alg = preg_replace("/N2-3R/","<439>",$alg);
    $alg = preg_replace("/N2-3L'/","<440>",$alg); $alg = preg_replace("/N2-3L-/","<440>",$alg);   $alg = preg_replace("/N2-3L2/","<441>",$alg);   $alg = preg_replace("/N2-3L/","<442>",$alg);
    $alg = preg_replace("/N2-3F'/","<443>",$alg); $alg = preg_replace("/N2-3F-/","<443>",$alg);   $alg = preg_replace("/N2-3F2/","<444>",$alg);   $alg = preg_replace("/N2-3F/","<445>",$alg);
    $alg = preg_replace("/N2-3B'/","<446>",$alg); $alg = preg_replace("/N2-3B-/","<446>",$alg);   $alg = preg_replace("/N2-3B2/","<447>",$alg);   $alg = preg_replace("/N2-3B/","<448>",$alg);
    $alg = preg_replace("/N2-3U'/","<449>",$alg); $alg = preg_replace("/N2-3U-/","<449>",$alg);   $alg = preg_replace("/N2-3U2/","<450>",$alg);   $alg = preg_replace("/N2-3U/","<451>",$alg);
    $alg = preg_replace("/N2-3D'/","<452>",$alg); $alg = preg_replace("/N2-3D-/","<452>",$alg);   $alg = preg_replace("/N2-3D2/","<453>",$alg);   $alg = preg_replace("/N2-3D/","<454>",$alg);
    
    $alg = preg_replace("/N5-6R'/","<442>",$alg); $alg = preg_replace("/N5-6R-/","<442>",$alg);   $alg = preg_replace("/N5-6R2/","<441>",$alg);   $alg = preg_replace("/N5-6R/","<440>",$alg);
    $alg = preg_replace("/N5-6L'/","<439>",$alg); $alg = preg_replace("/N5-6L-/","<439>",$alg);   $alg = preg_replace("/N5-6L2/","<438>",$alg);   $alg = preg_replace("/N5-6L/","<437>",$alg);
    $alg = preg_replace("/N5-6F'/","<448>",$alg); $alg = preg_replace("/N5-6F-/","<448>",$alg);   $alg = preg_replace("/N5-6F2/","<447>",$alg);   $alg = preg_replace("/N5-6F/","<446>",$alg);
    $alg = preg_replace("/N5-6B'/","<445>",$alg); $alg = preg_replace("/N5-6B-/","<445>",$alg);   $alg = preg_replace("/N5-6B2/","<444>",$alg);   $alg = preg_replace("/N5-6B/","<443>",$alg);
    $alg = preg_replace("/N5-6U'/","<454>",$alg); $alg = preg_replace("/N5-6U-/","<454>",$alg);   $alg = preg_replace("/N5-6U2/","<453>",$alg);   $alg = preg_replace("/N5-6U/","<452>",$alg);
    $alg = preg_replace("/N5-6D'/","<451>",$alg); $alg = preg_replace("/N5-6D-/","<451>",$alg);   $alg = preg_replace("/N5-6D2/","<450>",$alg);   $alg = preg_replace("/N5-6D/","<449>",$alg);
    
    /* --- 7xC: SSE -> CODE: [5] Mid-layer twists [1] (Numbered layer) twists --- */
    /* M3 = N3-5 */
    $alg = preg_replace("/M3R'/","<501>",$alg); $alg = preg_replace("/M3R-/","<501>",$alg);   $alg = preg_replace("/M3R2/","<502>",$alg);   $alg = preg_replace("/M3R/","<503>",$alg);
    $alg = preg_replace("/M3L'/","<503>",$alg); $alg = preg_replace("/M3L-/","<503>",$alg);   $alg = preg_replace("/M3L2/","<502>",$alg);   $alg = preg_replace("/M3L/","<501>",$alg);
    $alg = preg_replace("/M3F'/","<504>",$alg); $alg = preg_replace("/M3F-/","<504>",$alg);   $alg = preg_replace("/M3F2/","<505>",$alg);   $alg = preg_replace("/M3F/","<506>",$alg);
    $alg = preg_replace("/M3B'/","<506>",$alg); $alg = preg_replace("/M3B-/","<506>",$alg);   $alg = preg_replace("/M3B2/","<505>",$alg);   $alg = preg_replace("/M3B/","<504>",$alg);
    $alg = preg_replace("/M3U'/","<507>",$alg); $alg = preg_replace("/M3U-/","<507>",$alg);   $alg = preg_replace("/M3U2/","<508>",$alg);   $alg = preg_replace("/M3U/","<509>",$alg);
    $alg = preg_replace("/M3D'/","<509>",$alg); $alg = preg_replace("/M3D-/","<509>",$alg);   $alg = preg_replace("/M3D2/","<508>",$alg);   $alg = preg_replace("/M3D/","<507>",$alg);
    
    $alg = preg_replace("/N3-5R'/","<501>",$alg); $alg = preg_replace("/N3-5R-/","<501>",$alg);   $alg = preg_replace("/N3-5R2/","<502>",$alg);   $alg = preg_replace("/N3-5R/","<503>",$alg);
    $alg = preg_replace("/N3-5L'/","<503>",$alg); $alg = preg_replace("/N3-5L-/","<503>",$alg);   $alg = preg_replace("/N3-5L2/","<502>",$alg);   $alg = preg_replace("/N3-5L/","<501>",$alg);
    $alg = preg_replace("/N3-5F'/","<504>",$alg); $alg = preg_replace("/N3-5F-/","<504>",$alg);   $alg = preg_replace("/N3-5F2/","<505>",$alg);   $alg = preg_replace("/N3-5F/","<506>",$alg);
    $alg = preg_replace("/N3-5B'/","<506>",$alg); $alg = preg_replace("/N3-5B-/","<506>",$alg);   $alg = preg_replace("/N3-5B2/","<505>",$alg);   $alg = preg_replace("/N3-5B/","<504>",$alg);
    $alg = preg_replace("/N3-5U'/","<507>",$alg); $alg = preg_replace("/N3-5U-/","<507>",$alg);   $alg = preg_replace("/N3-5U2/","<508>",$alg);   $alg = preg_replace("/N3-5U/","<509>",$alg);
    $alg = preg_replace("/N3-5D'/","<509>",$alg); $alg = preg_replace("/N3-5D-/","<509>",$alg);   $alg = preg_replace("/N3-5D2/","<508>",$alg);   $alg = preg_replace("/N3-5D/","<507>",$alg);
    
    
    /* M2 = N3-4 | M2 = N4-5 */
    $alg = preg_replace("/M2R'/","<510>",$alg); $alg = preg_replace("/M2R-/","<510>",$alg);   $alg = preg_replace("/M2R2/","<511>",$alg);   $alg = preg_replace("/M2R/","<512>",$alg);
    $alg = preg_replace("/M2L'/","<513>",$alg); $alg = preg_replace("/M2L-/","<513>",$alg);   $alg = preg_replace("/M2L2/","<514>",$alg);   $alg = preg_replace("/M2L/","<515>",$alg);
    $alg = preg_replace("/M2F'/","<516>",$alg); $alg = preg_replace("/M2F-/","<516>",$alg);   $alg = preg_replace("/M2F2/","<517>",$alg);   $alg = preg_replace("/M2F/","<518>",$alg);
    $alg = preg_replace("/M2B'/","<519>",$alg); $alg = preg_replace("/M2B-/","<519>",$alg);   $alg = preg_replace("/M2B2/","<520>",$alg);   $alg = preg_replace("/M2B/","<521>",$alg);
    $alg = preg_replace("/M2U'/","<522>",$alg); $alg = preg_replace("/M2U-/","<522>",$alg);   $alg = preg_replace("/M2U2/","<523>",$alg);   $alg = preg_replace("/M2U/","<524>",$alg);
    $alg = preg_replace("/M2D'/","<525>",$alg); $alg = preg_replace("/M2D-/","<525>",$alg);   $alg = preg_replace("/M2D2/","<526>",$alg);   $alg = preg_replace("/M2D/","<527>",$alg);
    
    $alg = preg_replace("/N3-4R'/","<510>",$alg); $alg = preg_replace("/N3-4R-/","<510>",$alg);   $alg = preg_replace("/N3-4R2/","<511>",$alg);   $alg = preg_replace("/N3-4R/","<512>",$alg);
    $alg = preg_replace("/N3-4L'/","<513>",$alg); $alg = preg_replace("/N3-4L-/","<513>",$alg);   $alg = preg_replace("/N3-4L2/","<514>",$alg);   $alg = preg_replace("/N3-4L/","<515>",$alg);
    $alg = preg_replace("/N3-4F'/","<516>",$alg); $alg = preg_replace("/N3-4F-/","<516>",$alg);   $alg = preg_replace("/N3-4F2/","<517>",$alg);   $alg = preg_replace("/N3-4F/","<518>",$alg);
    $alg = preg_replace("/N3-4B'/","<519>",$alg); $alg = preg_replace("/N3-4B-/","<519>",$alg);   $alg = preg_replace("/N3-4B2/","<520>",$alg);   $alg = preg_replace("/N3-4B/","<521>",$alg);
    $alg = preg_replace("/N3-4U'/","<522>",$alg); $alg = preg_replace("/N3-4U-/","<522>",$alg);   $alg = preg_replace("/N3-4U2/","<523>",$alg);   $alg = preg_replace("/N3-4U/","<524>",$alg);
    $alg = preg_replace("/N3-4D'/","<525>",$alg); $alg = preg_replace("/N3-4D-/","<525>",$alg);   $alg = preg_replace("/N3-4D2/","<526>",$alg);   $alg = preg_replace("/N3-4D/","<527>",$alg);
    
    $alg = preg_replace("/N4-5R'/","<515>",$alg); $alg = preg_replace("/N4-5R-/","<515>",$alg);   $alg = preg_replace("/N4-5R2/","<514>",$alg);   $alg = preg_replace("/N4-5R/","<513>",$alg);
    $alg = preg_replace("/N4-5L'/","<512>",$alg); $alg = preg_replace("/N4-5L-/","<512>",$alg);   $alg = preg_replace("/N4-5L2/","<511>",$alg);   $alg = preg_replace("/N4-5L/","<510>",$alg);
    $alg = preg_replace("/N4-5F'/","<521>",$alg); $alg = preg_replace("/N4-5F-/","<521>",$alg);   $alg = preg_replace("/N4-5F2/","<520>",$alg);   $alg = preg_replace("/N4-5F/","<519>",$alg);
    $alg = preg_replace("/N4-5B'/","<518>",$alg); $alg = preg_replace("/N4-5B-/","<518>",$alg);   $alg = preg_replace("/N4-5B2/","<517>",$alg);   $alg = preg_replace("/N4-5B/","<516>",$alg);
    $alg = preg_replace("/N4-5U'/","<527>",$alg); $alg = preg_replace("/N4-5U-/","<527>",$alg);   $alg = preg_replace("/N4-5U2/","<526>",$alg);   $alg = preg_replace("/N4-5U/","<525>",$alg);
    $alg = preg_replace("/N4-5D'/","<524>",$alg); $alg = preg_replace("/N4-5D-/","<524>",$alg);   $alg = preg_replace("/N4-5D2/","<523>",$alg);   $alg = preg_replace("/N4-5D/","<522>",$alg);
    
    /* --- 7xC: SSE -> CODE: [6] Wide-layer [5] (Mid-layer) [4] (Void) [1] (Numbered layer) twists --- */
    /* W = M5 = V5 = N2-6 */
    $alg = preg_replace("/WR'/","<601>",$alg); $alg = preg_replace("/WR-/","<601>",$alg);   $alg = preg_replace("/WR2/","<602>",$alg);   $alg = preg_replace("/WR/","<603>",$alg);
    $alg = preg_replace("/WL'/","<603>",$alg); $alg = preg_replace("/WL-/","<603>",$alg);   $alg = preg_replace("/WL2/","<602>",$alg);   $alg = preg_replace("/WL/","<601>",$alg);
    $alg = preg_replace("/WF'/","<604>",$alg); $alg = preg_replace("/WF-/","<604>",$alg);   $alg = preg_replace("/WF2/","<605>",$alg);   $alg = preg_replace("/WF/","<606>",$alg);
    $alg = preg_replace("/WB'/","<606>",$alg); $alg = preg_replace("/WB-/","<606>",$alg);   $alg = preg_replace("/WB2/","<605>",$alg);   $alg = preg_replace("/WB/","<604>",$alg);
    $alg = preg_replace("/WU'/","<607>",$alg); $alg = preg_replace("/WU-/","<607>",$alg);   $alg = preg_replace("/WU2/","<608>",$alg);   $alg = preg_replace("/WU/","<609>",$alg);
    $alg = preg_replace("/WD'/","<609>",$alg); $alg = preg_replace("/WD-/","<609>",$alg);   $alg = preg_replace("/WD2/","<608>",$alg);   $alg = preg_replace("/WD/","<607>",$alg);
    
    $alg = preg_replace("/M5R'/","<601>",$alg); $alg = preg_replace("/M5R-/","<601>",$alg);   $alg = preg_replace("/M5R2/","<602>",$alg);   $alg = preg_replace("/M5R/","<603>",$alg);
    $alg = preg_replace("/M5L'/","<603>",$alg); $alg = preg_replace("/M5L-/","<603>",$alg);   $alg = preg_replace("/M5L2/","<602>",$alg);   $alg = preg_replace("/M5L/","<601>",$alg);
    $alg = preg_replace("/M5F'/","<604>",$alg); $alg = preg_replace("/M5F-/","<604>",$alg);   $alg = preg_replace("/M5F2/","<605>",$alg);   $alg = preg_replace("/M5F/","<606>",$alg);
    $alg = preg_replace("/M5B'/","<606>",$alg); $alg = preg_replace("/M5B-/","<606>",$alg);   $alg = preg_replace("/M5B2/","<605>",$alg);   $alg = preg_replace("/M5B/","<604>",$alg);
    $alg = preg_replace("/M5U'/","<607>",$alg); $alg = preg_replace("/M5U-/","<607>",$alg);   $alg = preg_replace("/M5U2/","<608>",$alg);   $alg = preg_replace("/M5U/","<609>",$alg);
    $alg = preg_replace("/M5D'/","<609>",$alg); $alg = preg_replace("/M5D-/","<609>",$alg);   $alg = preg_replace("/M5D2/","<608>",$alg);   $alg = preg_replace("/M5D/","<607>",$alg);
    
    $alg = preg_replace("/V5R'/","<601>",$alg); $alg = preg_replace("/V5R-/","<601>",$alg);   $alg = preg_replace("/V5R2/","<602>",$alg);   $alg = preg_replace("/V5R/","<603>",$alg);
    $alg = preg_replace("/V5L'/","<603>",$alg); $alg = preg_replace("/V5L-/","<603>",$alg);   $alg = preg_replace("/V5L2/","<602>",$alg);   $alg = preg_replace("/V5L/","<601>",$alg);
    $alg = preg_replace("/V5F'/","<604>",$alg); $alg = preg_replace("/V5F-/","<604>",$alg);   $alg = preg_replace("/V5F2/","<605>",$alg);   $alg = preg_replace("/V5F/","<606>",$alg);
    $alg = preg_replace("/V5B'/","<606>",$alg); $alg = preg_replace("/V5B-/","<606>",$alg);   $alg = preg_replace("/V5B2/","<605>",$alg);   $alg = preg_replace("/V5B/","<604>",$alg);
    $alg = preg_replace("/V5U'/","<607>",$alg); $alg = preg_replace("/V5U-/","<607>",$alg);   $alg = preg_replace("/V5U2/","<608>",$alg);   $alg = preg_replace("/V5U/","<609>",$alg);
    $alg = preg_replace("/V5D'/","<609>",$alg); $alg = preg_replace("/V5D-/","<609>",$alg);   $alg = preg_replace("/V5D2/","<608>",$alg);   $alg = preg_replace("/V5D/","<607>",$alg);
    
    $alg = preg_replace("/N2-6R'/","<601>",$alg); $alg = preg_replace("/N2-6R-/","<601>",$alg);   $alg = preg_replace("/N2-6R2/","<602>",$alg);   $alg = preg_replace("/N2-6R/","<603>",$alg);
    $alg = preg_replace("/N2-6L'/","<603>",$alg); $alg = preg_replace("/N2-6L-/","<603>",$alg);   $alg = preg_replace("/N2-6L2/","<602>",$alg);   $alg = preg_replace("/N2-6L/","<601>",$alg);
    $alg = preg_replace("/N2-6F'/","<604>",$alg); $alg = preg_replace("/N2-6F-/","<604>",$alg);   $alg = preg_replace("/N2-6F2/","<605>",$alg);   $alg = preg_replace("/N2-6F/","<606>",$alg);
    $alg = preg_replace("/N2-6B'/","<606>",$alg); $alg = preg_replace("/N2-6B-/","<606>",$alg);   $alg = preg_replace("/N2-6B2/","<605>",$alg);   $alg = preg_replace("/N2-6B/","<604>",$alg);
    $alg = preg_replace("/N2-6U'/","<607>",$alg); $alg = preg_replace("/N2-6U-/","<607>",$alg);   $alg = preg_replace("/N2-6U2/","<608>",$alg);   $alg = preg_replace("/N2-6U/","<609>",$alg);
    $alg = preg_replace("/N2-6D'/","<609>",$alg); $alg = preg_replace("/N2-6D-/","<609>",$alg);   $alg = preg_replace("/N2-6D2/","<608>",$alg);   $alg = preg_replace("/N2-6D/","<607>",$alg);
    
    /* --- 7xC: SSE -> CODE: [7] Cube rotations --- */
    /* C */
    $alg = preg_replace("/CR'/","<701>",$alg); $alg = preg_replace("/CR-/","<701>",$alg);   $alg = preg_replace("/CR2/","<702>",$alg);   $alg = preg_replace("/CR/","<703>",$alg);
    $alg = preg_replace("/CL'/","<703>",$alg); $alg = preg_replace("/CL-/","<703>",$alg);   $alg = preg_replace("/CL2/","<702>",$alg);   $alg = preg_replace("/CL/","<701>",$alg);
    $alg = preg_replace("/CF'/","<704>",$alg); $alg = preg_replace("/CF-/","<704>",$alg);   $alg = preg_replace("/CF2/","<705>",$alg);   $alg = preg_replace("/CF/","<706>",$alg);
    $alg = preg_replace("/CB'/","<706>",$alg); $alg = preg_replace("/CB-/","<706>",$alg);   $alg = preg_replace("/CB2/","<705>",$alg);   $alg = preg_replace("/CB/","<704>",$alg);
    $alg = preg_replace("/CU'/","<707>",$alg); $alg = preg_replace("/CU-/","<707>",$alg);   $alg = preg_replace("/CU2/","<708>",$alg);   $alg = preg_replace("/CU/","<709>",$alg);
    $alg = preg_replace("/CD'/","<709>",$alg); $alg = preg_replace("/CD-/","<709>",$alg);   $alg = preg_replace("/CD2/","<708>",$alg);   $alg = preg_replace("/CD/","<707>",$alg);
    
    /* --- 7xC: SSE -> CODE: [9] Face twists --- */
    /*   */
    $alg = preg_replace("/R'/","<901>",$alg); $alg = preg_replace("/R-/","<901>",$alg);   $alg = preg_replace("/R2/","<902>",$alg);   $alg = preg_replace("/R/","<903>",$alg);
    $alg = preg_replace("/L'/","<904>",$alg); $alg = preg_replace("/L-/","<904>",$alg);   $alg = preg_replace("/L2/","<905>",$alg);   $alg = preg_replace("/L/","<906>",$alg);
    $alg = preg_replace("/F'/","<907>",$alg); $alg = preg_replace("/F-/","<907>",$alg);   $alg = preg_replace("/F2/","<908>",$alg);   $alg = preg_replace("/F/","<909>",$alg);
    $alg = preg_replace("/B'/","<910>",$alg); $alg = preg_replace("/B-/","<910>",$alg);   $alg = preg_replace("/B2/","<911>",$alg);   $alg = preg_replace("/B/","<912>",$alg);
    $alg = preg_replace("/U'/","<913>",$alg); $alg = preg_replace("/U-/","<913>",$alg);   $alg = preg_replace("/U2/","<914>",$alg);   $alg = preg_replace("/U/","<915>",$alg);
    $alg = preg_replace("/D'/","<916>",$alg); $alg = preg_replace("/D-/","<916>",$alg);   $alg = preg_replace("/D2/","<917>",$alg);   $alg = preg_replace("/D/","<918>",$alg);
    
    /* ··································································································· */
    /* --- 7xC: CODE -> TWIZZLE: [1] Numbered-layer twists --- */
    /* N | N6 */
    $alg = preg_replace("/<101>/","2R'",$alg);   $alg = preg_replace("/<102>/","2R2",$alg);   $alg = preg_replace("/<103>/","2R",$alg);
    $alg = preg_replace("/<104>/","2L'",$alg);   $alg = preg_replace("/<105>/","2L2",$alg);   $alg = preg_replace("/<106>/","2L",$alg);
    $alg = preg_replace("/<107>/","2F'",$alg);   $alg = preg_replace("/<108>/","2F2",$alg);   $alg = preg_replace("/<109>/","2F",$alg);
    $alg = preg_replace("/<110>/","2B'",$alg);   $alg = preg_replace("/<111>/","2B2",$alg);   $alg = preg_replace("/<112>/","2B",$alg);
    $alg = preg_replace("/<113>/","2U'",$alg);   $alg = preg_replace("/<114>/","2U2",$alg);   $alg = preg_replace("/<115>/","2U",$alg);
    $alg = preg_replace("/<116>/","2D'",$alg);   $alg = preg_replace("/<117>/","2D2",$alg);   $alg = preg_replace("/<118>/","2D",$alg);
    
    
    /* N3 | N5 */
    $alg = preg_replace("/<119>/","3R'",$alg);   $alg = preg_replace("/<120>/","3R2",$alg);   $alg = preg_replace("/<121>/","3R",$alg);
    $alg = preg_replace("/<122>/","3L'",$alg);   $alg = preg_replace("/<123>/","3L2",$alg);   $alg = preg_replace("/<124>/","3L",$alg);
    $alg = preg_replace("/<125>/","3F'",$alg);   $alg = preg_replace("/<126>/","3F2",$alg);   $alg = preg_replace("/<127>/","3F",$alg);
    $alg = preg_replace("/<128>/","3B'",$alg);   $alg = preg_replace("/<129>/","3B2",$alg);   $alg = preg_replace("/<130>/","3B",$alg);
    $alg = preg_replace("/<131>/","3U'",$alg);   $alg = preg_replace("/<132>/","3U2",$alg);   $alg = preg_replace("/<133>/","3U",$alg);
    $alg = preg_replace("/<134>/","3D'",$alg);   $alg = preg_replace("/<135>/","3D2",$alg);   $alg = preg_replace("/<136>/","3D",$alg);
    
    
    /* N4 = M */
    $alg = preg_replace("/<137>/","4R'",$alg);   $alg = preg_replace("/<138>/","4R2",$alg);   $alg = preg_replace("/<139>/","4R",$alg);
    $alg = preg_replace("/<140>/","4F'",$alg);   $alg = preg_replace("/<141>/","4F2",$alg);   $alg = preg_replace("/<142>/","4F",$alg);
    $alg = preg_replace("/<143>/","4U'",$alg);   $alg = preg_replace("/<144>/","4U2",$alg);   $alg = preg_replace("/<145>/","4U",$alg);
    
    /* --- 7xC: CODE -> TWIZZLE: [2] Slice twists --- */
    /* S3 = S4-4 */
    $alg = preg_replace("/<201>/","3r' 3l",$alg);   $alg = preg_replace("/<202>/","3r2 3l2",$alg);   $alg = preg_replace("/<203>/","3r 3l'",$alg);
    $alg = preg_replace("/<204>/","3f' 3b",$alg);   $alg = preg_replace("/<205>/","3f2 3b2",$alg);   $alg = preg_replace("/<206>/","3f 3b'",$alg);
    $alg = preg_replace("/<207>/","3u' 3d",$alg);   $alg = preg_replace("/<208>/","3u2 3d2",$alg);   $alg = preg_replace("/<209>/","3u 3d'",$alg);
    
    
    /* S2 = S3-5 */
    $alg = preg_replace("/<210>/","r' l",$alg);   $alg = preg_replace("/<211>/","r2 l2",$alg);   $alg = preg_replace("/<212>/","r l'",$alg);
    $alg = preg_replace("/<213>/","f' b",$alg);   $alg = preg_replace("/<214>/","f2 b2",$alg);   $alg = preg_replace("/<215>/","f b'",$alg);
    $alg = preg_replace("/<216>/","u' d",$alg);   $alg = preg_replace("/<217>/","u2 d2",$alg);   $alg = preg_replace("/<218>/","u d'",$alg);
    
    
    /* S = S2-6 */
    $alg = preg_replace("/<219>/","R' L",$alg);   $alg = preg_replace("/<220>/","R2 L2",$alg);   $alg = preg_replace("/<221>/","R L'",$alg);
    $alg = preg_replace("/<222>/","F' B",$alg);   $alg = preg_replace("/<223>/","F2 B2",$alg);   $alg = preg_replace("/<224>/","F B'",$alg);
    $alg = preg_replace("/<225>/","U' D",$alg);   $alg = preg_replace("/<226>/","U2 D2",$alg);   $alg = preg_replace("/<227>/","U D'",$alg);
    
    
    /* S2-2 | S6-6 */
    $alg = preg_replace("/<228>/","R' 5l",$alg);   $alg = preg_replace("/<229>/","R2 5l2",$alg);   $alg = preg_replace("/<230>/","R 5l'",$alg);
    $alg = preg_replace("/<231>/","5r L'",$alg);   $alg = preg_replace("/<232>/","5r2 L2",$alg);   $alg = preg_replace("/<233>/","5r' L",$alg);
    $alg = preg_replace("/<234>/","F' 5b",$alg);   $alg = preg_replace("/<235>/","F2 5b2",$alg);   $alg = preg_replace("/<236>/","F 5b'",$alg);
    $alg = preg_replace("/<237>/","5f B'",$alg);   $alg = preg_replace("/<238>/","5f2 B2",$alg);   $alg = preg_replace("/<239>/","5f' B",$alg);
    $alg = preg_replace("/<240>/","U' 5d",$alg);   $alg = preg_replace("/<241>/","U2 5d2",$alg);   $alg = preg_replace("/<242>/","U 5d'",$alg);
    $alg = preg_replace("/<243>/","5u D'",$alg);   $alg = preg_replace("/<244>/","5u2 D2",$alg);   $alg = preg_replace("/<245>/","5u' D",$alg);
    
    
    /* S2-3 | S5-6 */
    $alg = preg_replace("/<246>/","R' 4l",$alg);   $alg = preg_replace("/<247>/","R2 4l2",$alg);   $alg = preg_replace("/<248>/","R 4l'",$alg);
    $alg = preg_replace("/<249>/","4r L'",$alg);   $alg = preg_replace("/<250>/","4r2 L2",$alg);   $alg = preg_replace("/<251>/","4r' L",$alg);
    $alg = preg_replace("/<252>/","F' 4b",$alg);   $alg = preg_replace("/<253>/","F2 4b2",$alg);   $alg = preg_replace("/<254>/","F 4b'",$alg);
    $alg = preg_replace("/<255>/","4f B'",$alg);   $alg = preg_replace("/<256>/","4f2 B2",$alg);   $alg = preg_replace("/<257>/","4f' B",$alg);
    $alg = preg_replace("/<258>/","U' 4d",$alg);   $alg = preg_replace("/<259>/","U2 4d2",$alg);   $alg = preg_replace("/<260>/","R 4d'",$alg);
    $alg = preg_replace("/<261>/","4u D'",$alg);   $alg = preg_replace("/<262>/","4u2 D2",$alg);   $alg = preg_replace("/<263>/","4u' D",$alg);
    
    
    /* S2-4 | S4-6 */
    $alg = preg_replace("/<264>/","R' 3l",$alg);   $alg = preg_replace("/<265>/","R2 3l2",$alg);   $alg = preg_replace("/<266>/","R 3l'",$alg);
    $alg = preg_replace("/<267>/","3r L'",$alg);   $alg = preg_replace("/<268>/","3r2 L2",$alg);   $alg = preg_replace("/<269>/","3r' L",$alg);
    $alg = preg_replace("/<270>/","F' 3b",$alg);   $alg = preg_replace("/<271>/","F2 3b2",$alg);   $alg = preg_replace("/<272>/","F 3b'",$alg);
    $alg = preg_replace("/<273>/","3f B'",$alg);   $alg = preg_replace("/<274>/","3f2 B2",$alg);   $alg = preg_replace("/<275>/","3f' B",$alg);
    $alg = preg_replace("/<276>/","U' 3d",$alg);   $alg = preg_replace("/<277>/","U2 3d2",$alg);   $alg = preg_replace("/<278>/","U 3d'",$alg);
    $alg = preg_replace("/<279>/","3u D'",$alg);   $alg = preg_replace("/<280>/","3u2 D2",$alg);   $alg = preg_replace("/<281>/","3u' D",$alg);
    
    
    /* S2-5 | S3-6 */
    $alg = preg_replace("/<282>/","R' l",$alg);   $alg = preg_replace("/<283>/","R2 l2",$alg);   $alg = preg_replace("/<284>/","R l'",$alg);
    $alg = preg_replace("/<285>/","r L'",$alg);   $alg = preg_replace("/<286>/","r2 L2",$alg);   $alg = preg_replace("/<287>/","r' L",$alg);
    $alg = preg_replace("/<288>/","F' b",$alg);   $alg = preg_replace("/<289>/","F2 b2",$alg);   $alg = preg_replace("/<290>/","F b'",$alg);
    $alg = preg_replace("/<291>/","f B'",$alg);   $alg = preg_replace("/<292>/","f2 B2",$alg);   $alg = preg_replace("/<293>/","f' B",$alg);
    $alg = preg_replace("/<294>/","U' d",$alg);   $alg = preg_replace("/<295>/","U2 d2",$alg);   $alg = preg_replace("/<296>/","U d'",$alg);
    $alg = preg_replace("/<297>/","u D'",$alg);   $alg = preg_replace("/<298>/","u2 D2",$alg);   $alg = preg_replace("/<299>/","u' D",$alg);
    
    
    /* S3-3 | S5-5 */
    $alg = preg_replace("/<2100>/","r' 4l",$alg);   $alg = preg_replace("/<2101>/","r2 4l2",$alg);   $alg = preg_replace("/<2102>/","r 4l'",$alg);
    $alg = preg_replace("/<2103>/","4r l'",$alg);   $alg = preg_replace("/<2104>/","4r2 l2",$alg);   $alg = preg_replace("/<2105>/","4r' l",$alg);
    $alg = preg_replace("/<2106>/","f' 4b",$alg);   $alg = preg_replace("/<2107>/","f2 4b2",$alg);   $alg = preg_replace("/<2108>/","f 4b'",$alg);
    $alg = preg_replace("/<2109>/","4f b'",$alg);   $alg = preg_replace("/<2110>/","4f2 b2",$alg);   $alg = preg_replace("/<2111>/","4f' b",$alg);
    $alg = preg_replace("/<2112>/","u' 4d",$alg);   $alg = preg_replace("/<2113>/","u2 4d2",$alg);   $alg = preg_replace("/<2114>/","u 4d'",$alg);
    $alg = preg_replace("/<2115>/","4u d'",$alg);   $alg = preg_replace("/<2116>/","4u2 d2",$alg);   $alg = preg_replace("/<2117>/","4u' d",$alg);
    
    /* S3-4R | S4-5 */
    $alg = preg_replace("/<2118>/","r' 3l",$alg);   $alg = preg_replace("/<2119>/","r2 3l2",$alg);   $alg = preg_replace("/<2120>/","r 3l'",$alg);
    $alg = preg_replace("/<2121>/","3r l'",$alg);   $alg = preg_replace("/<2122>/","3r2 l2",$alg);   $alg = preg_replace("/<2123>/","3r' l",$alg);
    $alg = preg_replace("/<2124>/","f' 3b",$alg);   $alg = preg_replace("/<2125>/","f2 3b2",$alg);   $alg = preg_replace("/<2126>/","f 3b'",$alg);
    $alg = preg_replace("/<2127>/","3f b'",$alg);   $alg = preg_replace("/<2128>/","3f2 b2",$alg);   $alg = preg_replace("/<2129>/","3f' b",$alg);
    $alg = preg_replace("/<2130>/","u' 3d",$alg);   $alg = preg_replace("/<2131>/","u2 3d2",$alg);   $alg = preg_replace("/<2132>/","u 3d'",$alg);
    $alg = preg_replace("/<2133>/","3u d'",$alg);   $alg = preg_replace("/<2134>/","3u2 d2",$alg);   $alg = preg_replace("/<2135>/","3u' d",$alg);
    
    /* --- 7xC: CODE -> TWIZZLE: [3] Tier twists --- */
    /* T6 */
    $alg = preg_replace("/<301>/","6r'",$alg);   $alg = preg_replace("/<302>/","6r2",$alg);   $alg = preg_replace("/<303>/","6r",$alg);
    $alg = preg_replace("/<304>/","6l'",$alg);   $alg = preg_replace("/<305>/","6l2",$alg);   $alg = preg_replace("/<306>/","6l",$alg);
    $alg = preg_replace("/<307>/","6f'",$alg);   $alg = preg_replace("/<308>/","6f2",$alg);   $alg = preg_replace("/<309>/","6f",$alg);
    $alg = preg_replace("/<310>/","6b'",$alg);   $alg = preg_replace("/<311>/","6b2",$alg);   $alg = preg_replace("/<312>/","6b",$alg);
    $alg = preg_replace("/<313>/","6u'",$alg);   $alg = preg_replace("/<314>/","6u2",$alg);   $alg = preg_replace("/<315>/","6u",$alg);
    $alg = preg_replace("/<316>/","6d'",$alg);   $alg = preg_replace("/<317>/","6d2",$alg);   $alg = preg_replace("/<318>/","6d",$alg);
    
    
    /* T5 */
    $alg = preg_replace("/<319>/","5r'",$alg);   $alg = preg_replace("/<320>/","5r2",$alg);   $alg = preg_replace("/<321>/","5r",$alg);
    $alg = preg_replace("/<322>/","5l'",$alg);   $alg = preg_replace("/<323>/","5l2",$alg);   $alg = preg_replace("/<324>/","5l",$alg);
    $alg = preg_replace("/<325>/","5f'",$alg);   $alg = preg_replace("/<326>/","5f2",$alg);   $alg = preg_replace("/<327>/","5f",$alg);
    $alg = preg_replace("/<328>/","5b'",$alg);   $alg = preg_replace("/<329>/","5b2",$alg);   $alg = preg_replace("/<330>/","5b",$alg);
    $alg = preg_replace("/<331>/","5u'",$alg);   $alg = preg_replace("/<332>/","5u2",$alg);   $alg = preg_replace("/<333>/","5u",$alg);
    $alg = preg_replace("/<334>/","5d'",$alg);   $alg = preg_replace("/<335>/","5d2",$alg);   $alg = preg_replace("/<336>/","5d",$alg);
    
    
    /* T4 */
    $alg = preg_replace("/<337>/","4r'",$alg);   $alg = preg_replace("/<338>/","4r2",$alg);   $alg = preg_replace("/<339>/","4r",$alg);
    $alg = preg_replace("/<340>/","4l'",$alg);   $alg = preg_replace("/<341>/","4l2",$alg);   $alg = preg_replace("/<342>/","4l",$alg);
    $alg = preg_replace("/<343>/","4f'",$alg);   $alg = preg_replace("/<344>/","4f2",$alg);   $alg = preg_replace("/<345>/","4f",$alg);
    $alg = preg_replace("/<346>/","4b'",$alg);   $alg = preg_replace("/<347>/","4b2",$alg);   $alg = preg_replace("/<348>/","4b",$alg);
    $alg = preg_replace("/<349>/","4u'",$alg);   $alg = preg_replace("/<350>/","4u2",$alg);   $alg = preg_replace("/<351>/","4u",$alg);
    $alg = preg_replace("/<352>/","4d'",$alg);   $alg = preg_replace("/<353>/","4d2",$alg);   $alg = preg_replace("/<354>/","4d",$alg);
    
    
    /* T3 */
    $alg = preg_replace("/<355>/","3r'",$alg);   $alg = preg_replace("/<356>/","3r2",$alg);   $alg = preg_replace("/<357>/","3r",$alg);
    $alg = preg_replace("/<358>/","3l'",$alg);   $alg = preg_replace("/<359>/","3l2",$alg);   $alg = preg_replace("/<360>/","3l",$alg);
    $alg = preg_replace("/<361>/","3f'",$alg);   $alg = preg_replace("/<362>/","3f2",$alg);   $alg = preg_replace("/<363>/","3f",$alg);
    $alg = preg_replace("/<364>/","3b'",$alg);   $alg = preg_replace("/<365>/","3b2",$alg);   $alg = preg_replace("/<366>/","3b",$alg);
    $alg = preg_replace("/<367>/","3u'",$alg);   $alg = preg_replace("/<368>/","3u2",$alg);   $alg = preg_replace("/<369>/","3u",$alg);
    $alg = preg_replace("/<370>/","3d'",$alg);   $alg = preg_replace("/<371>/","3d2",$alg);   $alg = preg_replace("/<372>/","3d",$alg);
    
    
    /* T */
    $alg = preg_replace("/<373>/","r'",$alg);   $alg = preg_replace("/<374>/","r2",$alg);   $alg = preg_replace("/<375>/","r",$alg);
    $alg = preg_replace("/<376>/","l'",$alg);   $alg = preg_replace("/<377>/","l2",$alg);   $alg = preg_replace("/<378>/","l",$alg);
    $alg = preg_replace("/<379>/","f'",$alg);   $alg = preg_replace("/<380>/","f2",$alg);   $alg = preg_replace("/<381>/","f",$alg);
    $alg = preg_replace("/<382>/","b'",$alg);   $alg = preg_replace("/<383>/","b2",$alg);   $alg = preg_replace("/<384>/","b",$alg);
    $alg = preg_replace("/<385>/","u'",$alg);   $alg = preg_replace("/<386>/","u2",$alg);   $alg = preg_replace("/<387>/","u",$alg);
    $alg = preg_replace("/<388>/","d'",$alg);   $alg = preg_replace("/<389>/","d2",$alg);   $alg = preg_replace("/<390>/","d",$alg);
    
    /* --- 7xC: CODE -> TWIZZLE: [4] Void twists --- */
    /* V4 = M4 = N2-5 | V4 = M4 = N3-6 */
    $alg = preg_replace("/<401>/","2-5R'",$alg);   $alg = preg_replace("/<402>/","2-5R2",$alg);   $alg = preg_replace("/<403>/","2-5R",$alg);
    $alg = preg_replace("/<404>/","2-5L'",$alg);   $alg = preg_replace("/<405>/","2-5L2",$alg);   $alg = preg_replace("/<406>/","2-5L",$alg);
    $alg = preg_replace("/<407>/","2-5F'",$alg);   $alg = preg_replace("/<408>/","2-5F2",$alg);   $alg = preg_replace("/<409>/","2-5F",$alg);
    $alg = preg_replace("/<410>/","2-5B'",$alg);   $alg = preg_replace("/<411>/","2-5B2",$alg);   $alg = preg_replace("/<412>/","2-5B",$alg);
    $alg = preg_replace("/<413>/","2-5U'",$alg);   $alg = preg_replace("/<414>/","2-5U2",$alg);   $alg = preg_replace("/<415>/","2-5U",$alg);
    $alg = preg_replace("/<416>/","2-5D'",$alg);   $alg = preg_replace("/<417>/","2-5D2",$alg);   $alg = preg_replace("/<418>/","2-5D",$alg);
    
    
    /* V3 = N2-4 | V3 = N4-6 */
    $alg = preg_replace("/<419>/","2-4R'",$alg);   $alg = preg_replace("/<420>/","2-4R2",$alg);   $alg = preg_replace("/<421>/","2-4R",$alg);
    $alg = preg_replace("/<422>/","2-4L'",$alg);   $alg = preg_replace("/<423>/","2-4L2",$alg);   $alg = preg_replace("/<424>/","2-4L",$alg);
    $alg = preg_replace("/<425>/","2-4F'",$alg);   $alg = preg_replace("/<426>/","2-4F2",$alg);   $alg = preg_replace("/<427>/","2-4F",$alg);
    $alg = preg_replace("/<428>/","2-4B'",$alg);   $alg = preg_replace("/<429>/","2-4B2",$alg);   $alg = preg_replace("/<430>/","2-4B",$alg);
    $alg = preg_replace("/<431>/","2-4U'",$alg);   $alg = preg_replace("/<432>/","2-4U2",$alg);   $alg = preg_replace("/<433>/","2-4U",$alg);
    $alg = preg_replace("/<434>/","2-4D'",$alg);   $alg = preg_replace("/<435>/","2-4D2",$alg);   $alg = preg_replace("/<436>/","2-4D",$alg);
    
    
    /* V = N2-3 | V = N5-6 */
    $alg = preg_replace("/<437>/","2-3R'",$alg);   $alg = preg_replace("/<438>/","2-3R2",$alg);   $alg = preg_replace("/<439>/","2-3R",$alg);
    $alg = preg_replace("/<440>/","2-3L'",$alg);   $alg = preg_replace("/<441>/","2-3L2",$alg);   $alg = preg_replace("/<442>/","2-3L",$alg);
    $alg = preg_replace("/<443>/","2-3F'",$alg);   $alg = preg_replace("/<444>/","2-3F2",$alg);   $alg = preg_replace("/<445>/","2-3F",$alg);
    $alg = preg_replace("/<446>/","2-3B'",$alg);   $alg = preg_replace("/<447>/","2-3B2",$alg);   $alg = preg_replace("/<448>/","2-3B",$alg);
    $alg = preg_replace("/<449>/","2-3U'",$alg);   $alg = preg_replace("/<450>/","2-3U2",$alg);   $alg = preg_replace("/<451>/","2-3U",$alg);
    $alg = preg_replace("/<452>/","2-3D'",$alg);   $alg = preg_replace("/<453>/","2-3D2",$alg);   $alg = preg_replace("/<454>/","2-3D",$alg);
     
    /* --- 7xC: CODE -> TWIZZLE: [5] Mid-layer twists --- */
    /* M3 = N3-5 */
    $alg = preg_replace("/<501>/","3-5R'",$alg);   $alg = preg_replace("/<502>/","3-5R2",$alg);   $alg = preg_replace("/<503>/","3-5R",$alg);
    $alg = preg_replace("/<504>/","3-5F'",$alg);   $alg = preg_replace("/<505>/","3-5F2",$alg);   $alg = preg_replace("/<506>/","3-5F",$alg);
    $alg = preg_replace("/<507>/","3-5U'",$alg);   $alg = preg_replace("/<508>/","3-5U2",$alg);   $alg = preg_replace("/<509>/","3-5U",$alg);
    
    
    /* M2 = N3-4 | M2 = N4-5 */
    $alg = preg_replace("/<510>/","3-4R'",$alg);   $alg = preg_replace("/<511>/","3-4R2",$alg);   $alg = preg_replace("/<512>/","3-4R",$alg);
    $alg = preg_replace("/<513>/","3-4L'",$alg);   $alg = preg_replace("/<514>/","3-4L2",$alg);   $alg = preg_replace("/<515>/","3-4L",$alg);
    $alg = preg_replace("/<516>/","3-4F'",$alg);   $alg = preg_replace("/<517>/","3-4F2",$alg);   $alg = preg_replace("/<518>/","3-4F",$alg);
    $alg = preg_replace("/<519>/","3-4B'",$alg);   $alg = preg_replace("/<520>/","3-4B2",$alg);   $alg = preg_replace("/<521>/","3-4B",$alg);
    $alg = preg_replace("/<522>/","3-4U'",$alg);   $alg = preg_replace("/<523>/","3-4U2",$alg);   $alg = preg_replace("/<524>/","3-4U",$alg);
    $alg = preg_replace("/<525>/","3-4D'",$alg);   $alg = preg_replace("/<526>/","3-4D2",$alg);   $alg = preg_replace("/<527>/","3-4D",$alg);
    
    /* --- 7xC: CODE -> TWIZZLE: [6] Wide-layer [5] (Mid-layer) twists --- */
    /* W = M5 = V5 = N2-6 */
    if ($useSiGN == true) { // Bei SiGN:
      $alg = preg_replace("/<601>/","m", $alg);   $alg = preg_replace("/<602>/","m2",$alg);   $alg = preg_replace("/<603>/","m'",$alg);
      $alg = preg_replace("/<604>/","s'",$alg);   $alg = preg_replace("/<605>/","s2",$alg);   $alg = preg_replace("/<606>/","s", $alg);
      $alg = preg_replace("/<607>/","e", $alg);   $alg = preg_replace("/<608>/","e2",$alg);   $alg = preg_replace("/<609>/","e'",$alg);
      
    } else {               // Sonst (TWIZZLE):
      $alg = preg_replace("/<601>/","2-6R'",$alg);   $alg = preg_replace("/<602>/","2-6R2",$alg);   $alg = preg_replace("/<603>/","2-6R",$alg);
      $alg = preg_replace("/<604>/","2-6F'",$alg);   $alg = preg_replace("/<605>/","2-6F2",$alg);   $alg = preg_replace("/<606>/","2-6F",$alg);
      $alg = preg_replace("/<607>/","2-6U'",$alg);   $alg = preg_replace("/<608>/","2-6U2",$alg);   $alg = preg_replace("/<609>/","2-6U",$alg);
    }
    
    /* --- 7xC: CODE -> TWIZZLE: [7] Cube rotations --- */
    /* C */
    if ($useSiGN == true) { // Bei SiGN:
      $alg = preg_replace("/<701>/","x'",$alg);   $alg = preg_replace("/<702>/","x2",$alg);   $alg = preg_replace("/<703>/","x",$alg);
      $alg = preg_replace("/<704>/","z'",$alg);   $alg = preg_replace("/<705>/","z2",$alg);   $alg = preg_replace("/<706>/","z",$alg);
      $alg = preg_replace("/<707>/","y'",$alg);   $alg = preg_replace("/<708>/","y2",$alg);   $alg = preg_replace("/<709>/","y",$alg);
      
    } else {               // Sonst (TWIZZLE):
      $alg = preg_replace("/<701>/","Rv'",$alg);   $alg = preg_replace("/<702>/","Rv2",$alg);   $alg = preg_replace("/<703>/","Rv",$alg);
      $alg = preg_replace("/<704>/","Fv'",$alg);   $alg = preg_replace("/<705>/","Fv2",$alg);   $alg = preg_replace("/<706>/","Fv",$alg);
      $alg = preg_replace("/<707>/","Uv'",$alg);   $alg = preg_replace("/<708>/","Uv2",$alg);   $alg = preg_replace("/<709>/","Uv",$alg);
    }
    
    /* --- 7xC: CODE -> TWIZZLE: [9] Face twists --- */
    /*   */
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
    /* --- 7xC: Preferences --- */
    $optSSE = true;  // Optimize SSE (rebuilds Slice twists).
    
    /* --- 7xC: Marker --- */
    $alg = str_replace(".","·",$alg);
    
    /* ··································································································· */
    /* --- 7xC: TWIZZLE -> CODE: [3] Tier twists (TWIZZLE) --- */
    /* T6 */
    $alg = preg_replace("/1-6R'/","<301>",$alg); $alg = preg_replace("/1-6R2/","<302>",$alg); $alg = preg_replace("/1-6R/","<303>",$alg);
    $alg = preg_replace("/1-6L'/","<304>",$alg); $alg = preg_replace("/1-6L2/","<305>",$alg); $alg = preg_replace("/1-6L/","<306>",$alg);
    $alg = preg_replace("/1-6F'/","<307>",$alg); $alg = preg_replace("/1-6F2/","<308>",$alg); $alg = preg_replace("/1-6F/","<309>",$alg);
    $alg = preg_replace("/1-6B'/","<310>",$alg); $alg = preg_replace("/1-6B2/","<311>",$alg); $alg = preg_replace("/1-6B/","<312>",$alg);
    $alg = preg_replace("/1-6U'/","<313>",$alg); $alg = preg_replace("/1-6U2/","<314>",$alg); $alg = preg_replace("/1-6U/","<315>",$alg);
    $alg = preg_replace("/1-6D'/","<316>",$alg); $alg = preg_replace("/1-6D2/","<317>",$alg); $alg = preg_replace("/1-6D/","<318>",$alg);
    
    
    /* T5 */
    $alg = preg_replace("/1-5R'/","<319>",$alg); $alg = preg_replace("/1-5R2/","<320>",$alg); $alg = preg_replace("/1-5R/","<321>",$alg);
    $alg = preg_replace("/1-5L'/","<322>",$alg); $alg = preg_replace("/1-5L2/","<323>",$alg); $alg = preg_replace("/1-5L/","<324>",$alg);
    $alg = preg_replace("/1-5F'/","<325>",$alg); $alg = preg_replace("/1-5F2/","<326>",$alg); $alg = preg_replace("/1-5F/","<327>",$alg);
    $alg = preg_replace("/1-5B'/","<328>",$alg); $alg = preg_replace("/1-5B2/","<329>",$alg); $alg = preg_replace("/1-5B/","<330>",$alg);
    $alg = preg_replace("/1-5U'/","<331>",$alg); $alg = preg_replace("/1-5U2/","<332>",$alg); $alg = preg_replace("/1-5U/","<333>",$alg);
    $alg = preg_replace("/1-5D'/","<334>",$alg); $alg = preg_replace("/1-5D2/","<335>",$alg); $alg = preg_replace("/1-5D/","<336>",$alg);
    
    
    /* T4 */
    $alg = preg_replace("/1-4R'/","<337>",$alg); $alg = preg_replace("/1-4R2/","<338>",$alg); $alg = preg_replace("/1-4R/","<339>",$alg);
    $alg = preg_replace("/1-4L'/","<340>",$alg); $alg = preg_replace("/1-4L2/","<341>",$alg); $alg = preg_replace("/1-4L/","<342>",$alg);
    $alg = preg_replace("/1-4F'/","<343>",$alg); $alg = preg_replace("/1-4F2/","<344>",$alg); $alg = preg_replace("/1-4F/","<345>",$alg);
    $alg = preg_replace("/1-4B'/","<346>",$alg); $alg = preg_replace("/1-4B2/","<347>",$alg); $alg = preg_replace("/1-4B/","<348>",$alg);
    $alg = preg_replace("/1-4U'/","<349>",$alg); $alg = preg_replace("/1-4U2/","<350>",$alg); $alg = preg_replace("/1-4U/","<351>",$alg);
    $alg = preg_replace("/1-4D'/","<352>",$alg); $alg = preg_replace("/1-4D2/","<353>",$alg); $alg = preg_replace("/1-4D/","<354>",$alg);
    
    
    /* T3 */
    $alg = preg_replace("/1-3R'/","<355>",$alg); $alg = preg_replace("/1-3R2/","<356>",$alg); $alg = preg_replace("/1-3R/","<357>",$alg);
    $alg = preg_replace("/1-3L'/","<358>",$alg); $alg = preg_replace("/1-3L2/","<359>",$alg); $alg = preg_replace("/1-3L/","<360>",$alg);
    $alg = preg_replace("/1-3F'/","<361>",$alg); $alg = preg_replace("/1-3F2/","<362>",$alg); $alg = preg_replace("/1-3F/","<363>",$alg);
    $alg = preg_replace("/1-3B'/","<364>",$alg); $alg = preg_replace("/1-3B2/","<365>",$alg); $alg = preg_replace("/1-3B/","<366>",$alg);
    $alg = preg_replace("/1-3U'/","<367>",$alg); $alg = preg_replace("/1-3U2/","<368>",$alg); $alg = preg_replace("/1-3U/","<369>",$alg);
    $alg = preg_replace("/1-3D'/","<370>",$alg); $alg = preg_replace("/1-3D2/","<371>",$alg); $alg = preg_replace("/1-3D/","<372>",$alg);
    
    
    /* T */
    $alg = preg_replace("/1-2R'/","<373>",$alg); $alg = preg_replace("/1-2R2/","<374>",$alg); $alg = preg_replace("/1-2R/","<375>",$alg);
    $alg = preg_replace("/1-2L'/","<376>",$alg); $alg = preg_replace("/1-2L2/","<377>",$alg); $alg = preg_replace("/1-2L/","<378>",$alg);
    $alg = preg_replace("/1-2F'/","<379>",$alg); $alg = preg_replace("/1-2F2/","<380>",$alg); $alg = preg_replace("/1-2F/","<381>",$alg);
    $alg = preg_replace("/1-2B'/","<382>",$alg); $alg = preg_replace("/1-2B2/","<383>",$alg); $alg = preg_replace("/1-2B/","<384>",$alg);
    $alg = preg_replace("/1-2U'/","<385>",$alg); $alg = preg_replace("/1-2U2/","<386>",$alg); $alg = preg_replace("/1-2U/","<387>",$alg);
    $alg = preg_replace("/1-2D'/","<388>",$alg); $alg = preg_replace("/1-2D2/","<389>",$alg); $alg = preg_replace("/1-2D/","<390>",$alg);
    
    /* --- 7xC: TWIZZLE -> CODE: [2] Slice twists --- */
    if ($optSSE == true) {
      /* S3 = S4-4 */
      $alg = preg_replace("/3Rw 3Lw'/","<203>",$alg); $alg = preg_replace("/3Rw 3Lw-/","<203>",$alg);   $alg = preg_replace("/3Rw2 3Lw2/","<202>",$alg);   $alg = preg_replace("/3Rw' 3Lw/","<201>",$alg); $alg = preg_replace("/3Rw- 3Lw/","<201>",$alg);
      $alg = preg_replace("/3Lw 3Rw'/","<201>",$alg); $alg = preg_replace("/3Lw 3Rw-/","<201>",$alg);   $alg = preg_replace("/3Lw2 3Rw2/","<202>",$alg);   $alg = preg_replace("/3Lw' 3Rw/","<203>",$alg); $alg = preg_replace("/3Lw- 3Rw/","<203>",$alg);
      $alg = preg_replace("/3Fw 3Bw'/","<206>",$alg); $alg = preg_replace("/3Fw 3Bw-/","<206>",$alg);   $alg = preg_replace("/3Fw2 3Bw2/","<205>",$alg);   $alg = preg_replace("/3Fw' 3Bw/","<204>",$alg); $alg = preg_replace("/3Fw- 3Bw/","<204>",$alg);
      $alg = preg_replace("/3Bw 3Fw'/","<204>",$alg); $alg = preg_replace("/3Bw 3Fw-/","<204>",$alg);   $alg = preg_replace("/3Bw2 3Fw2/","<205>",$alg);   $alg = preg_replace("/3Bw' 3Fw/","<206>",$alg); $alg = preg_replace("/3Bw- 3Fw/","<206>",$alg);
      $alg = preg_replace("/3Uw 3Dw'/","<209>",$alg); $alg = preg_replace("/3Uw 3Dw-/","<209>",$alg);   $alg = preg_replace("/3Uw2 3Dw2/","<208>",$alg);   $alg = preg_replace("/3Uw' 3Dw/","<207>",$alg); $alg = preg_replace("/3Uw- 3Dw/","<207>",$alg);
      $alg = preg_replace("/3Dw 3Uw'/","<207>",$alg); $alg = preg_replace("/3Dw 3Uw-/","<207>",$alg);   $alg = preg_replace("/3Dw2 3Uw2/","<208>",$alg);   $alg = preg_replace("/3Dw' 3Uw/","<209>",$alg); $alg = preg_replace("/3Dw- 3Uw/","<209>",$alg);
      
      $alg = preg_replace("/3r 3l'/","<203>",$alg); $alg = preg_replace("/3r 3l-/","<203>",$alg);   $alg = preg_replace("/3r2 3l2/","<202>",$alg);   $alg = preg_replace("/3r' 3l/","<201>",$alg); $alg = preg_replace("/3r- 3l/","<201>",$alg);
      $alg = preg_replace("/3l 3r'/","<201>",$alg); $alg = preg_replace("/3l 3r-/","<201>",$alg);   $alg = preg_replace("/3l2 3r2/","<202>",$alg);   $alg = preg_replace("/3l' 3r/","<203>",$alg); $alg = preg_replace("/3l- 3r/","<203>",$alg);
      $alg = preg_replace("/3f 3b'/","<206>",$alg); $alg = preg_replace("/3f 3b-/","<206>",$alg);   $alg = preg_replace("/3f2 3b2/","<205>",$alg);   $alg = preg_replace("/3f' 3b/","<204>",$alg); $alg = preg_replace("/3f- 3b/","<204>",$alg);
      $alg = preg_replace("/3b 3f'/","<204>",$alg); $alg = preg_replace("/3b 3f-/","<204>",$alg);   $alg = preg_replace("/3b2 3f2/","<205>",$alg);   $alg = preg_replace("/3b' 3f/","<206>",$alg); $alg = preg_replace("/3b- 3f/","<206>",$alg);
      $alg = preg_replace("/3u 3d'/","<209>",$alg); $alg = preg_replace("/3u 3d-/","<209>",$alg);   $alg = preg_replace("/3u2 3d2/","<208>",$alg);   $alg = preg_replace("/3u' 3d/","<207>",$alg); $alg = preg_replace("/3u- 3d/","<207>",$alg);
      $alg = preg_replace("/3d 3u'/","<207>",$alg); $alg = preg_replace("/3d 3u-/","<207>",$alg);   $alg = preg_replace("/3d2 3u2/","<208>",$alg);   $alg = preg_replace("/3d' 3u/","<209>",$alg); $alg = preg_replace("/3d- 3u/","<209>",$alg);
      
      $alg = preg_replace("/4L' Rv'/","<201>",$alg); $alg = preg_replace("/4L- Rv-/","<201>",$alg);   $alg = preg_replace("/4L2 Rv2/","<202>",$alg);   $alg = preg_replace("/4L Rv/","<203>",$alg);
      $alg = preg_replace("/4R' Lv'/","<203>",$alg); $alg = preg_replace("/4R- Lv-/","<203>",$alg);   $alg = preg_replace("/4R2 Lv2/","<202>",$alg);   $alg = preg_replace("/4R Lv/","<201>",$alg);
      $alg = preg_replace("/4B' Fv'/","<204>",$alg); $alg = preg_replace("/4B- Fv-/","<204>",$alg);   $alg = preg_replace("/4B2 Fv2/","<205>",$alg);   $alg = preg_replace("/4B Fv/","<206>",$alg);
      $alg = preg_replace("/4F' Bv'/","<206>",$alg); $alg = preg_replace("/4F- Bv-/","<206>",$alg);   $alg = preg_replace("/4F2 Bv2/","<205>",$alg);   $alg = preg_replace("/4F Bv/","<204>",$alg);
      $alg = preg_replace("/4D' Uv'/","<207>",$alg); $alg = preg_replace("/4D- Uv-/","<207>",$alg);   $alg = preg_replace("/4D2 Uv2/","<208>",$alg);   $alg = preg_replace("/4D Uv/","<209>",$alg);
      $alg = preg_replace("/4U' Dv'/","<209>",$alg); $alg = preg_replace("/4U- Dv-/","<209>",$alg);   $alg = preg_replace("/4U2 Dv2/","<208>",$alg);   $alg = preg_replace("/4U Dv/","<207>",$alg);
      
      $alg = preg_replace("/4R Rv'/","<201>",$alg); $alg = preg_replace("/4R Rv-/","<201>",$alg);   $alg = preg_replace("/4R2 Rv2/","<202>",$alg);   $alg = preg_replace("/4R' Rv/","<203>",$alg); $alg = preg_replace("/4R- Rv/","<203>",$alg);
      $alg = preg_replace("/4L Lv'/","<203>",$alg); $alg = preg_replace("/4L Lv-/","<203>",$alg);   $alg = preg_replace("/4L2 Lv2/","<202>",$alg);   $alg = preg_replace("/4L' Lv/","<201>",$alg); $alg = preg_replace("/4L- Lv/","<201>",$alg);
      $alg = preg_replace("/4F Fv'/","<204>",$alg); $alg = preg_replace("/4F Fv-/","<204>",$alg);   $alg = preg_replace("/4F2 Fv2/","<205>",$alg);   $alg = preg_replace("/4F' Fv/","<206>",$alg); $alg = preg_replace("/4F- Fv/","<206>",$alg);
      $alg = preg_replace("/4B Bv'/","<206>",$alg); $alg = preg_replace("/4B Bv-/","<206>",$alg);   $alg = preg_replace("/4B2 Bv2/","<205>",$alg);   $alg = preg_replace("/4B' Bv/","<204>",$alg); $alg = preg_replace("/4B- Bv/","<204>",$alg);
      $alg = preg_replace("/4U Uv'/","<207>",$alg); $alg = preg_replace("/4U Uv-/","<207>",$alg);   $alg = preg_replace("/4U2 Uv2/","<208>",$alg);   $alg = preg_replace("/4U' Uv/","<209>",$alg); $alg = preg_replace("/4U- Uv/","<209>",$alg);
      $alg = preg_replace("/4D Dv'/","<209>",$alg); $alg = preg_replace("/4D Dv-/","<209>",$alg);   $alg = preg_replace("/4D2 Dv2/","<208>",$alg);   $alg = preg_replace("/4D' Dv/","<207>",$alg); $alg = preg_replace("/4D- Dv/","<207>",$alg);
      
      $alg = preg_replace("/M' Rv'/","<201>",$alg); $alg = preg_replace("/M- Rv-/","<201>",$alg);   $alg = preg_replace("/M2 Rv2/","<202>",$alg);   $alg = preg_replace("/M Rv/", "<203>",$alg);
      $alg = preg_replace("/M Lv'/", "<203>",$alg); $alg = preg_replace("/M Lv-/", "<203>",$alg);   $alg = preg_replace("/M2 Lv2/","<202>",$alg);   $alg = preg_replace("/M' Lv/","<201>",$alg); $alg = preg_replace("/M- Lv/","<201>",$alg);
      $alg = preg_replace("/S Fv'/", "<204>",$alg); $alg = preg_replace("/S Fv-/", "<204>",$alg);   $alg = preg_replace("/S2 Fv2/","<205>",$alg);   $alg = preg_replace("/S' Fv/","<206>",$alg); $alg = preg_replace("/S- Fv/","<206>",$alg);
      $alg = preg_replace("/S' Bv'/","<206>",$alg); $alg = preg_replace("/S- Bv-/","<206>",$alg);   $alg = preg_replace("/S2 Bv2/","<205>",$alg);   $alg = preg_replace("/S Bv/", "<204>",$alg);
      $alg = preg_replace("/E' Uv'/","<207>",$alg); $alg = preg_replace("/E- Uv-/","<207>",$alg);   $alg = preg_replace("/E2 Uv2/","<208>",$alg);   $alg = preg_replace("/E Uv/", "<209>",$alg);
      $alg = preg_replace("/E Dv'/", "<209>",$alg); $alg = preg_replace("/E Dv-/", "<209>",$alg);   $alg = preg_replace("/E2 Dv2/","<208>",$alg);   $alg = preg_replace("/E' Dv/","<207>",$alg); $alg = preg_replace("/E' Dv/","<207>",$alg);
      
      
      /* S2 = S3-5 */
      $alg = preg_replace("/3-5L' Rv'/","<210>",$alg); $alg = preg_replace("/3-5L- Rv-/","<210>",$alg);   $alg = preg_replace("/3-5L2 Rv2/","<211>",$alg);   $alg = preg_replace("/3-5L Rv/","<212>",$alg);
      $alg = preg_replace("/3-5R' Lv'/","<212>",$alg); $alg = preg_replace("/3-5R- Lv-/","<212>",$alg);   $alg = preg_replace("/3-5R2 Lv2/","<211>",$alg);   $alg = preg_replace("/3-5R Lv/","<210>",$alg);
      $alg = preg_replace("/3-5B' Fv'/","<213>",$alg); $alg = preg_replace("/3-5B- Fv-/","<213>",$alg);   $alg = preg_replace("/3-5B2 Fv2/","<214>",$alg);   $alg = preg_replace("/3-5B Fv/","<215>",$alg);
      $alg = preg_replace("/3-5F' Bv'/","<215>",$alg); $alg = preg_replace("/3-5F- Bv-/","<215>",$alg);   $alg = preg_replace("/3-5F2 Bv2/","<214>",$alg);   $alg = preg_replace("/3-5F Bv/","<213>",$alg);
      $alg = preg_replace("/3-5D' Uv'/","<216>",$alg); $alg = preg_replace("/3-5D- Uv-/","<216>",$alg);   $alg = preg_replace("/3-5D2 Uv2/","<217>",$alg);   $alg = preg_replace("/3-5D Uv/","<218>",$alg);
      $alg = preg_replace("/3-5U' Dv'/","<218>",$alg); $alg = preg_replace("/3-5U- Dv-/","<218>",$alg);   $alg = preg_replace("/3-5U2 Dv2/","<217>",$alg);   $alg = preg_replace("/3-5U Dv/","<216>",$alg);
      
      $alg = preg_replace("/3-5R Rv'/","<210>",$alg); $alg = preg_replace("/3-5R Rv-/","<210>",$alg);   $alg = preg_replace("/3-5R2 Rv2/","<211>",$alg);   $alg = preg_replace("/3-5R' Rv/","<212>",$alg); $alg = preg_replace("/3-5R- Rv/","<212>",$alg);
      $alg = preg_replace("/3-5L Lv'/","<212>",$alg); $alg = preg_replace("/3-5L Lv-/","<212>",$alg);   $alg = preg_replace("/3-5L2 Lv2/","<211>",$alg);   $alg = preg_replace("/3-5L' Lv/","<210>",$alg); $alg = preg_replace("/3-5L- Lv/","<210>",$alg);
      $alg = preg_replace("/3-5F Fv'/","<213>",$alg); $alg = preg_replace("/3-5F Fv-/","<213>",$alg);   $alg = preg_replace("/3-5F2 Fv2/","<214>",$alg);   $alg = preg_replace("/3-5F' Fv/","<215>",$alg); $alg = preg_replace("/3-5F- Fv/","<215>",$alg);
      $alg = preg_replace("/3-5B Bv'/","<215>",$alg); $alg = preg_replace("/3-5B Bv-/","<215>",$alg);   $alg = preg_replace("/3-5B2 Bv2/","<214>",$alg);   $alg = preg_replace("/3-5B' Bv/","<213>",$alg); $alg = preg_replace("/3-5B- Bv/","<213>",$alg);
      $alg = preg_replace("/3-5U Uv'/","<216>",$alg); $alg = preg_replace("/3-5U Uv-/","<216>",$alg);   $alg = preg_replace("/3-5U2 Uv2/","<217>",$alg);   $alg = preg_replace("/3-5U' Uv/","<218>",$alg); $alg = preg_replace("/3-5U- Uv/","<218>",$alg);
      $alg = preg_replace("/3-5D Dv'/","<218>",$alg); $alg = preg_replace("/3-5D Dv-/","<218>",$alg);   $alg = preg_replace("/3-5D2 Dv2/","<217>",$alg);   $alg = preg_replace("/3-5D' Dv/","<216>",$alg); $alg = preg_replace("/3-5D- Dv/","<216>",$alg);
      
      
      /* S = S2-6 */
      $alg = preg_replace("/2-6L' Rv'/","<219>",$alg); $alg = preg_replace("/2-6L- Rv-/","<219>",$alg);   $alg = preg_replace("/2-6L2 Rv2/","<220>",$alg);   $alg = preg_replace("/2-6L Rv/","<221>",$alg);
      $alg = preg_replace("/2-6R' Lv'/","<221>",$alg); $alg = preg_replace("/2-6R- Lv-/","<221>",$alg);   $alg = preg_replace("/2-6R2 Lv2/","<220>",$alg);   $alg = preg_replace("/2-6R Lv/","<219>",$alg);
      $alg = preg_replace("/2-6B' Fv'/","<222>",$alg); $alg = preg_replace("/2-6B- Fv-/","<222>",$alg);   $alg = preg_replace("/2-6B2 Fv2/","<223>",$alg);   $alg = preg_replace("/2-6B Fv/","<224>",$alg);
      $alg = preg_replace("/2-6F' Bv'/","<224>",$alg); $alg = preg_replace("/2-6F- Bv-/","<224>",$alg);   $alg = preg_replace("/2-6F2 Bv2/","<223>",$alg);   $alg = preg_replace("/2-6F Bv/","<222>",$alg);
      $alg = preg_replace("/2-6D' Uv'/","<225>",$alg); $alg = preg_replace("/2-6D- Uv-/","<225>",$alg);   $alg = preg_replace("/2-6D2 Uv2/","<226>",$alg);   $alg = preg_replace("/2-6D Uv/","<227>",$alg);
      $alg = preg_replace("/2-6U' Dv'/","<227>",$alg); $alg = preg_replace("/2-6U- Dv-/","<227>",$alg);   $alg = preg_replace("/2-6U2 Dv2/","<226>",$alg);   $alg = preg_replace("/2-6U Dv/","<225>",$alg);
      
      $alg = preg_replace("/2-6R Rv'/","<219>",$alg); $alg = preg_replace("/2-6R Rv-/","<219>",$alg);   $alg = preg_replace("/2-6R2 Rv2/","<220>",$alg);   $alg = preg_replace("/2-6R' Rv/","<221>",$alg); $alg = preg_replace("/2-6R- Rv/","<221>",$alg);
      $alg = preg_replace("/2-6L Lv'/","<221>",$alg); $alg = preg_replace("/2-6L Lv-/","<221>",$alg);   $alg = preg_replace("/2-6L2 Lv2/","<220>",$alg);   $alg = preg_replace("/2-6L' Lv/","<219>",$alg); $alg = preg_replace("/2-6L- Lv/","<219>",$alg);
      $alg = preg_replace("/2-6F Fv'/","<222>",$alg); $alg = preg_replace("/2-6F Fv-/","<222>",$alg);   $alg = preg_replace("/2-6F2 Fv2/","<223>",$alg);   $alg = preg_replace("/2-6F' Fv/","<224>",$alg); $alg = preg_replace("/2-6F- Fv/","<224>",$alg);
      $alg = preg_replace("/2-6B Bv'/","<224>",$alg); $alg = preg_replace("/2-6B Bv-/","<224>",$alg);   $alg = preg_replace("/2-6B2 Bv2/","<223>",$alg);   $alg = preg_replace("/2-6B' Bv/","<222>",$alg); $alg = preg_replace("/2-6B- Bv/","<222>",$alg);
      $alg = preg_replace("/2-6U Uv'/","<225>",$alg); $alg = preg_replace("/2-6U Uv-/","<225>",$alg);   $alg = preg_replace("/2-6U2 Uv2/","<226>",$alg);   $alg = preg_replace("/2-6U' Uv/","<227>",$alg); $alg = preg_replace("/2-6U- Uv/","<227>",$alg);
      $alg = preg_replace("/2-6D Dv'/","<227>",$alg); $alg = preg_replace("/2-6D Dv-/","<227>",$alg);   $alg = preg_replace("/2-6D2 Dv2/","<226>",$alg);   $alg = preg_replace("/2-6D' Dv/","<229>",$alg); $alg = preg_replace("/2-6D- Dv/","<229>",$alg);
      
      /* S2-2 | S6-6 */
      
      /* S2-3 | S5-6 */
      
      /* S2-4 | S4-6 */
      
      /* S2-5 | S3-6 */
      
      /* S3-3 | S5-5 */
      
      /* S3-4 | S4-5 */
    }
    
    /* --- 7xC: TWIZZLE -> CODE: [6] Wide layer twists --- */
    /* W */
    $alg = preg_replace("/2-6R'/","<601>",$alg); $alg = preg_replace("/2-6R2/","<602>",$alg); $alg = preg_replace("/2-6R/","<603>",$alg);
    $alg = preg_replace("/2-6L'/","<603>",$alg); $alg = preg_replace("/2-6L2/","<602>",$alg); $alg = preg_replace("/2-6L/","<601>",$alg);
    $alg = preg_replace("/2-6F'/","<604>",$alg); $alg = preg_replace("/2-6F2/","<605>",$alg); $alg = preg_replace("/2-6F/","<606>",$alg);
    $alg = preg_replace("/2-6B'/","<606>",$alg); $alg = preg_replace("/2-6B2/","<605>",$alg); $alg = preg_replace("/2-6B/","<604>",$alg);
    $alg = preg_replace("/2-6U'/","<607>",$alg); $alg = preg_replace("/2-6U2/","<608>",$alg); $alg = preg_replace("/2-6U/","<609>",$alg);
    $alg = preg_replace("/2-6D'/","<609>",$alg); $alg = preg_replace("/2-6D2/","<608>",$alg); $alg = preg_replace("/2-6D/","<607>",$alg);
    
    $alg = preg_replace("/m'/","<603>",$alg); $alg = preg_replace("/m2/","<602>",$alg); $alg = preg_replace("/m/","<601>",$alg);
    $alg = preg_replace("/s'/","<604>",$alg); $alg = preg_replace("/s2/","<605>",$alg); $alg = preg_replace("/s/","<606>",$alg);
    $alg = preg_replace("/e'/","<609>",$alg); $alg = preg_replace("/e2/","<608>",$alg); $alg = preg_replace("/e/","<607>",$alg);
    
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
    $alg = preg_replace("/3-5L'/","<503>",$alg); $alg = preg_replace("/3-5L2/","<502>",$alg); $alg = preg_replace("/3-5L/","<501>",$alg);
    $alg = preg_replace("/3-5F'/","<504>",$alg); $alg = preg_replace("/3-5F2/","<505>",$alg); $alg = preg_replace("/3-5F/","<506>",$alg);
    $alg = preg_replace("/3-5B'/","<506>",$alg); $alg = preg_replace("/3-5B2/","<505>",$alg); $alg = preg_replace("/3-5B/","<504>",$alg);
    $alg = preg_replace("/3-5U'/","<507>",$alg); $alg = preg_replace("/3-5U2/","<508>",$alg); $alg = preg_replace("/3-5U/","<509>",$alg);
    $alg = preg_replace("/3-5D'/","<509>",$alg); $alg = preg_replace("/3-5D2/","<508>",$alg); $alg = preg_replace("/3-5D/","<507>",$alg);
    
    /* --- 7xC: TWIZZLE -> CODE: [3] Tier twists (WCA) --- */
    /* T6 */
    $alg = preg_replace("/6Rw'/","<301>",$alg); $alg = preg_replace("/6Rw2/","<302>",$alg); $alg = preg_replace("/6Rw/","<303>",$alg);
    $alg = preg_replace("/6Lw'/","<304>",$alg); $alg = preg_replace("/6Lw2/","<305>",$alg); $alg = preg_replace("/6Lw/","<306>",$alg);
    $alg = preg_replace("/6Fw'/","<307>",$alg); $alg = preg_replace("/6Fw2/","<308>",$alg); $alg = preg_replace("/6Fw/","<309>",$alg);
    $alg = preg_replace("/6Bw'/","<310>",$alg); $alg = preg_replace("/6Bw2/","<311>",$alg); $alg = preg_replace("/6Bw/","<312>",$alg);
    $alg = preg_replace("/6Uw'/","<313>",$alg); $alg = preg_replace("/6Uw2/","<314>",$alg); $alg = preg_replace("/6Uw/","<315>",$alg);
    $alg = preg_replace("/6Dw'/","<316>",$alg); $alg = preg_replace("/6Dw2/","<317>",$alg); $alg = preg_replace("/6Dw/","<318>",$alg);
    
    
    /* T5 */
    $alg = preg_replace("/5Rw'/","<319>",$alg); $alg = preg_replace("/5Rw2/","<320>",$alg); $alg = preg_replace("/5Rw/","<321>",$alg);
    $alg = preg_replace("/5Lw'/","<322>",$alg); $alg = preg_replace("/5Lw2/","<323>",$alg); $alg = preg_replace("/5Lw/","<324>",$alg);
    $alg = preg_replace("/5Fw'/","<325>",$alg); $alg = preg_replace("/5Fw2/","<326>",$alg); $alg = preg_replace("/5Fw/","<327>",$alg);
    $alg = preg_replace("/5Bw'/","<328>",$alg); $alg = preg_replace("/5Bw2/","<329>",$alg); $alg = preg_replace("/5Bw/","<330>",$alg);
    $alg = preg_replace("/5Uw'/","<331>",$alg); $alg = preg_replace("/5Uw2/","<332>",$alg); $alg = preg_replace("/5Uw/","<333>",$alg);
    $alg = preg_replace("/5Dw'/","<334>",$alg); $alg = preg_replace("/5Dw2/","<335>",$alg); $alg = preg_replace("/5Dw/","<336>",$alg);
    
    
    /* T4 */
    $alg = preg_replace("/4Rw'/","<337>",$alg); $alg = preg_replace("/4Rw2/","<338>",$alg); $alg = preg_replace("/4Rw/","<339>",$alg);
    $alg = preg_replace("/4Lw'/","<340>",$alg); $alg = preg_replace("/4Lw2/","<341>",$alg); $alg = preg_replace("/4Lw/","<342>",$alg);
    $alg = preg_replace("/4Fw'/","<343>",$alg); $alg = preg_replace("/4Fw2/","<344>",$alg); $alg = preg_replace("/4Fw/","<345>",$alg);
    $alg = preg_replace("/4Bw'/","<346>",$alg); $alg = preg_replace("/4Bw2/","<347>",$alg); $alg = preg_replace("/4Bw/","<348>",$alg);
    $alg = preg_replace("/4Uw'/","<349>",$alg); $alg = preg_replace("/4Uw2/","<350>",$alg); $alg = preg_replace("/4Uw/","<351>",$alg);
    $alg = preg_replace("/4Dw'/","<352>",$alg); $alg = preg_replace("/4Dw2/","<353>",$alg); $alg = preg_replace("/4Dw/","<354>",$alg);
    
    
    /* T3 */
    $alg = preg_replace("/3Rw'/","<355>",$alg); $alg = preg_replace("/3Rw2/","<356>",$alg); $alg = preg_replace("/3Rw/","<357>",$alg);
    $alg = preg_replace("/3Lw'/","<358>",$alg); $alg = preg_replace("/3Lw2/","<359>",$alg); $alg = preg_replace("/3Lw/","<360>",$alg);
    $alg = preg_replace("/3Fw'/","<361>",$alg); $alg = preg_replace("/3Fw2/","<362>",$alg); $alg = preg_replace("/3Fw/","<363>",$alg);
    $alg = preg_replace("/3Bw'/","<364>",$alg); $alg = preg_replace("/3Bw2/","<365>",$alg); $alg = preg_replace("/3Bw/","<366>",$alg);
    $alg = preg_replace("/3Uw'/","<367>",$alg); $alg = preg_replace("/3Uw2/","<368>",$alg); $alg = preg_replace("/3Uw/","<369>",$alg);
    $alg = preg_replace("/3Dw'/","<370>",$alg); $alg = preg_replace("/3Dw2/","<371>",$alg); $alg = preg_replace("/3Dw/","<372>",$alg);
    
    /* --- 7xC: TWIZZLE -> CODE: [1] Numbered layer, [5] Mid-layer twists --- */
    /* N2 | N6 */
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
    
    
    /* N3 | N5 */
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
    
    
    /* N4 */
    $alg = preg_replace("/4R'/","<137>",$alg); $alg = preg_replace("/4R2/","<138>",$alg); $alg = preg_replace("/4R/","<139>",$alg);
    $alg = preg_replace("/4L'/","<139>",$alg); $alg = preg_replace("/4L2/","<138>",$alg); $alg = preg_replace("/4L/","<137>",$alg);
    $alg = preg_replace("/4F'/","<140>",$alg); $alg = preg_replace("/4F2/","<141>",$alg); $alg = preg_replace("/4F/","<142>",$alg);
    $alg = preg_replace("/4B'/","<142>",$alg); $alg = preg_replace("/4B2/","<141>",$alg); $alg = preg_replace("/4B/","<140>",$alg);
    $alg = preg_replace("/4U'/","<143>",$alg); $alg = preg_replace("/4U2/","<144>",$alg); $alg = preg_replace("/4U/","<145>",$alg);
    $alg = preg_replace("/4D'/","<145>",$alg); $alg = preg_replace("/4D2/","<144>",$alg); $alg = preg_replace("/4D/","<143>",$alg);
    
    $alg = preg_replace("/M'/","<139>",$alg); $alg = preg_replace("/M2/","<138>",$alg); $alg = preg_replace("/M/","<137>",$alg);
    $alg = preg_replace("/S'/","<140>",$alg); $alg = preg_replace("/S2/","<141>",$alg); $alg = preg_replace("/S/","<142>",$alg);
    $alg = preg_replace("/E'/","<145>",$alg); $alg = preg_replace("/E2/","<144>",$alg); $alg = preg_replace("/E/","<143>",$alg);
    
    /* --- 7xC: TWIZZLE -> CODE: [9] Face twists --- */
    /* N1 | N7 */
    $alg = preg_replace("/1R'/","<901>",$alg); $alg = preg_replace("/1R2/","<902>",$alg); $alg = preg_replace("/1R/","<903>",$alg);
    $alg = preg_replace("/1L'/","<904>",$alg); $alg = preg_replace("/1L2/","<905>",$alg); $alg = preg_replace("/1L/","<906>",$alg);
    $alg = preg_replace("/1F'/","<907>",$alg); $alg = preg_replace("/1F2/","<908>",$alg); $alg = preg_replace("/1F/","<909>",$alg);
    $alg = preg_replace("/1B'/","<910>",$alg); $alg = preg_replace("/1B2/","<911>",$alg); $alg = preg_replace("/1B/","<912>",$alg);
    $alg = preg_replace("/1U'/","<913>",$alg); $alg = preg_replace("/1U2/","<914>",$alg); $alg = preg_replace("/1U/","<915>",$alg);
    $alg = preg_replace("/1D'/","<916>",$alg); $alg = preg_replace("/1D2/","<917>",$alg); $alg = preg_replace("/1D/","<918>",$alg);
    
    $alg = preg_replace("/7R'/","<906>",$alg); $alg = preg_replace("/7R2/","<905>",$alg); $alg = preg_replace("/7R/","<904>",$alg);
    $alg = preg_replace("/7L'/","<903>",$alg); $alg = preg_replace("/7L2/","<902>",$alg); $alg = preg_replace("/7L/","<901>",$alg);
    $alg = preg_replace("/7F'/","<912>",$alg); $alg = preg_replace("/7F2/","<911>",$alg); $alg = preg_replace("/7F/","<910>",$alg);
    $alg = preg_replace("/7B'/","<909>",$alg); $alg = preg_replace("/7B2/","<908>",$alg); $alg = preg_replace("/7B/","<907>",$alg);
    $alg = preg_replace("/7U'/","<918>",$alg); $alg = preg_replace("/7U2/","<917>",$alg); $alg = preg_replace("/7U/","<916>",$alg);
    $alg = preg_replace("/7D'/","<915>",$alg); $alg = preg_replace("/7D2/","<914>",$alg); $alg = preg_replace("/7D/","<913>",$alg);
    
    /* --- 7xC: TWIZZLE -> CODE: [3] Tier twists (SiGN) --- */
    /* T6 */
    $alg = preg_replace("/6r'/","<301>",$alg); $alg = preg_replace("/6r2/","<302>",$alg); $alg = preg_replace("/6r/","<303>",$alg);
    $alg = preg_replace("/6l'/","<304>",$alg); $alg = preg_replace("/6l2/","<305>",$alg); $alg = preg_replace("/6l/","<306>",$alg);
    $alg = preg_replace("/6f'/","<307>",$alg); $alg = preg_replace("/6f2/","<308>",$alg); $alg = preg_replace("/6f/","<309>",$alg);
    $alg = preg_replace("/6b'/","<310>",$alg); $alg = preg_replace("/6b2/","<311>",$alg); $alg = preg_replace("/6b/","<312>",$alg);
    $alg = preg_replace("/6u'/","<313>",$alg); $alg = preg_replace("/6u2/","<314>",$alg); $alg = preg_replace("/6u/","<315>",$alg);
    $alg = preg_replace("/6d'/","<316>",$alg); $alg = preg_replace("/6d2/","<317>",$alg); $alg = preg_replace("/6d/","<318>",$alg);
    
    
    /* T5 */
    $alg = preg_replace("/5r'/","<319>",$alg); $alg = preg_replace("/5r2/","<320>",$alg); $alg = preg_replace("/5r/","<321>",$alg);
    $alg = preg_replace("/5l'/","<322>",$alg); $alg = preg_replace("/5l2/","<323>",$alg); $alg = preg_replace("/5l/","<324>",$alg);
    $alg = preg_replace("/5f'/","<325>",$alg); $alg = preg_replace("/5f2/","<326>",$alg); $alg = preg_replace("/5f/","<327>",$alg);
    $alg = preg_replace("/5b'/","<328>",$alg); $alg = preg_replace("/5b2/","<329>",$alg); $alg = preg_replace("/5b/","<330>",$alg);
    $alg = preg_replace("/5u'/","<331>",$alg); $alg = preg_replace("/5u2/","<332>",$alg); $alg = preg_replace("/5u/","<333>",$alg);
    $alg = preg_replace("/5d'/","<334>",$alg); $alg = preg_replace("/5d2/","<335>",$alg); $alg = preg_replace("/5d/","<336>",$alg);
    
    
    /* T4 */
    $alg = preg_replace("/4r'/","<337>",$alg); $alg = preg_replace("/4r2/","<338>",$alg); $alg = preg_replace("/4r/","<339>",$alg);
    $alg = preg_replace("/4l'/","<340>",$alg); $alg = preg_replace("/4l2/","<341>",$alg); $alg = preg_replace("/4l/","<342>",$alg);
    $alg = preg_replace("/4f'/","<343>",$alg); $alg = preg_replace("/4f2/","<344>",$alg); $alg = preg_replace("/4f/","<345>",$alg);
    $alg = preg_replace("/4b'/","<346>",$alg); $alg = preg_replace("/4b2/","<347>",$alg); $alg = preg_replace("/4b/","<348>",$alg);
    $alg = preg_replace("/4u'/","<349>",$alg); $alg = preg_replace("/4u2/","<350>",$alg); $alg = preg_replace("/4u/","<351>",$alg);
    $alg = preg_replace("/4d'/","<352>",$alg); $alg = preg_replace("/4d2/","<353>",$alg); $alg = preg_replace("/4d/","<354>",$alg);
    
    
    /* T3 */
    $alg = preg_replace("/3r'/","<355>",$alg); $alg = preg_replace("/3r2/","<356>",$alg); $alg = preg_replace("/3r/","<357>",$alg);
    $alg = preg_replace("/3l'/","<358>",$alg); $alg = preg_replace("/3l2/","<359>",$alg); $alg = preg_replace("/3l/","<360>",$alg);
    $alg = preg_replace("/3f'/","<361>",$alg); $alg = preg_replace("/3f2/","<362>",$alg); $alg = preg_replace("/3f/","<363>",$alg);
    $alg = preg_replace("/3b'/","<364>",$alg); $alg = preg_replace("/3b2/","<365>",$alg); $alg = preg_replace("/3b/","<366>",$alg);
    $alg = preg_replace("/3u'/","<367>",$alg); $alg = preg_replace("/3u2/","<368>",$alg); $alg = preg_replace("/3u/","<369>",$alg);
    $alg = preg_replace("/3d'/","<370>",$alg); $alg = preg_replace("/3d2/","<371>",$alg); $alg = preg_replace("/3d/","<372>",$alg);
    
    /* --- 7xC: TWIZZLE -> CODE: [2] Slice twists --- */
    if ($optSSE == true) {
      /* S3 = S4-4 */
      
      /* S2 = S3-5 */
      $alg = preg_replace("/Rw Lw'/","<212>",$alg); $alg = preg_replace("/Rw Lw-/","<212>",$alg);   $alg = preg_replace("/Rw2 Lw2/","<211>",$alg);   $alg = preg_replace("/Rw' Lw/","<210>",$alg); $alg = preg_replace("/Rw- Lw/","<210>",$alg);
      $alg = preg_replace("/Lw Rw'/","<210>",$alg); $alg = preg_replace("/Lw Rw-/","<210>",$alg);   $alg = preg_replace("/Lw2 Rw2/","<211>",$alg);   $alg = preg_replace("/Lw' Rw/","<212>",$alg); $alg = preg_replace("/Lw- Rw/","<212>",$alg);
      $alg = preg_replace("/Fw Bw'/","<215>",$alg); $alg = preg_replace("/Fw Bw-/","<215>",$alg);   $alg = preg_replace("/Fw2 Bw2/","<214>",$alg);   $alg = preg_replace("/Fw' Bw/","<213>",$alg); $alg = preg_replace("/Fw- Bw/","<213>",$alg);
      $alg = preg_replace("/Bw Fw'/","<213>",$alg); $alg = preg_replace("/Bw Fw-/","<213>",$alg);   $alg = preg_replace("/Bw2 Fw2/","<214>",$alg);   $alg = preg_replace("/Bw' Fw/","<215>",$alg); $alg = preg_replace("/Bw- Fw/","<215>",$alg);
      $alg = preg_replace("/Uw Dw'/","<218>",$alg); $alg = preg_replace("/Uw Dw-/","<218>",$alg);   $alg = preg_replace("/Uw2 Dw2/","<217>",$alg);   $alg = preg_replace("/Uw' Dw/","<216>",$alg); $alg = preg_replace("/Uw- Dw/","<216>",$alg);
      $alg = preg_replace("/Dw Uw'/","<216>",$alg); $alg = preg_replace("/Dw Uw-/","<216>",$alg);   $alg = preg_replace("/Dw2 Uw2/","<217>",$alg);   $alg = preg_replace("/Dw' Uw/","<218>",$alg); $alg = preg_replace("/Dw- Uw/","<218>",$alg);
      
      $alg = preg_replace("/r l'/","<212>",$alg); $alg = preg_replace("/r l-/","<212>",$alg);   $alg = preg_replace("/r2 l2/","<211>",$alg);   $alg = preg_replace("/r' l/","<210>",$alg); $alg = preg_replace("/r- l/","<210>",$alg);
      $alg = preg_replace("/l r'/","<210>",$alg); $alg = preg_replace("/l r-/","<210>",$alg);   $alg = preg_replace("/l2 r2/","<211>",$alg);   $alg = preg_replace("/l' r/","<212>",$alg); $alg = preg_replace("/l- r/","<212>",$alg);
      $alg = preg_replace("/f b'/","<215>",$alg); $alg = preg_replace("/f b-/","<215>",$alg);   $alg = preg_replace("/f2 b2/","<214>",$alg);   $alg = preg_replace("/f' b/","<213>",$alg); $alg = preg_replace("/f- b/","<213>",$alg);
      $alg = preg_replace("/b f'/","<213>",$alg); $alg = preg_replace("/b f-/","<213>",$alg);   $alg = preg_replace("/b2 f2/","<214>",$alg);   $alg = preg_replace("/b' f/","<215>",$alg); $alg = preg_replace("/b- f/","<215>",$alg);
      $alg = preg_replace("/u d'/","<218>",$alg); $alg = preg_replace("/u d-/","<218>",$alg);   $alg = preg_replace("/u2 d2/","<217>",$alg);   $alg = preg_replace("/u' d/","<216>",$alg); $alg = preg_replace("/u- d/","<216>",$alg);
      $alg = preg_replace("/d u'/","<216>",$alg); $alg = preg_replace("/d u-/","<216>",$alg);   $alg = preg_replace("/d2 u2/","<217>",$alg);   $alg = preg_replace("/d' u/","<218>",$alg); $alg = preg_replace("/d- u/","<218>",$alg);
      
      
      /* Non-slice-twists */
      $alg = preg_replace("/R' L'/","<255>",$alg);
      $alg = preg_replace("/L' R'/","<255>",$alg);
      $alg = preg_replace("/F' B'/","<256>",$alg);
      $alg = preg_replace("/B' F'/","<256>",$alg);
      $alg = preg_replace("/U' D'/","<257>",$alg);
      $alg = preg_replace("/D' U'/","<257>",$alg);
      
      /* S = S2-6 */
      $alg = preg_replace("/R L'/","<221>",$alg); $alg = preg_replace("/R L-/","<221>",$alg);   $alg = preg_replace("/R2 L2/","<220>",$alg);   $alg = preg_replace("/R' L/","<219>",$alg); $alg = preg_replace("/R- L/","<219>",$alg);
      $alg = preg_replace("/L R'/","<219>",$alg); $alg = preg_replace("/L R-/","<219>",$alg);   $alg = preg_replace("/L2 R2/","<220>",$alg);   $alg = preg_replace("/L' R/","<221>",$alg); $alg = preg_replace("/L- R/","<221>",$alg);
      $alg = preg_replace("/F B'/","<224>",$alg); $alg = preg_replace("/F B-/","<224>",$alg);   $alg = preg_replace("/F2 B2/","<223>",$alg);   $alg = preg_replace("/F' B/","<222>",$alg); $alg = preg_replace("/F- B/","<222>",$alg);
      $alg = preg_replace("/B F'/","<222>",$alg); $alg = preg_replace("/B F-/","<222>",$alg);   $alg = preg_replace("/B2 F2/","<223>",$alg);   $alg = preg_replace("/B' F/","<224>",$alg); $alg = preg_replace("/B- F/","<224>",$alg);
      $alg = preg_replace("/U D'/","<227>",$alg); $alg = preg_replace("/U D-/","<227>",$alg);   $alg = preg_replace("/U2 D2/","<226>",$alg);   $alg = preg_replace("/U' D/","<225>",$alg); $alg = preg_replace("/U- D/","<225>",$alg);
      $alg = preg_replace("/D U'/","<225>",$alg); $alg = preg_replace("/D U-/","<225>",$alg);   $alg = preg_replace("/D2 U2/","<226>",$alg);   $alg = preg_replace("/D' U/","<227>",$alg); $alg = preg_replace("/D- U/","<227>",$alg);
      
      /* S2-2 | S6-6 */
      
      /* S2-3 | S5-6 */
      
      /* S2-4 | S4-6 */
      
      /* S2-5 | S3-6 */
      
      /* S3-3 | S5-5 */
      
      /* S3-4 | S4-5 */
    }
    
    /* --- 7xC: TWIZZLE -> CODE: [3] Tier twists (WCA) --- */
    /* T */
    $alg = preg_replace("/Rw'/","<373>",$alg); $alg = preg_replace("/Rw2/","<374>",$alg); $alg = preg_replace("/Rw/","<375>",$alg);
    $alg = preg_replace("/Lw'/","<376>",$alg); $alg = preg_replace("/Lw2/","<377>",$alg); $alg = preg_replace("/Lw/","<378>",$alg);
    $alg = preg_replace("/Fw'/","<379>",$alg); $alg = preg_replace("/Fw2/","<380>",$alg); $alg = preg_replace("/Fw/","<381>",$alg);
    $alg = preg_replace("/Bw'/","<382>",$alg); $alg = preg_replace("/Bw2/","<383>",$alg); $alg = preg_replace("/Bw/","<384>",$alg);
    $alg = preg_replace("/Uw'/","<385>",$alg); $alg = preg_replace("/Uw2/","<386>",$alg); $alg = preg_replace("/Uw/","<387>",$alg);
    $alg = preg_replace("/Dw'/","<388>",$alg); $alg = preg_replace("/Dw2/","<389>",$alg); $alg = preg_replace("/Dw/","<390>",$alg);
    
    /* --- 7xC: TWIZZLE -> CODE: [7] Cube rotations --- */
    /* C */
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
    /*   */
    $alg = preg_replace("/R'/","<901>",$alg); $alg = preg_replace("/R2/","<902>",$alg); $alg = preg_replace("/R/","<903>",$alg);
    $alg = preg_replace("/L'/","<904>",$alg); $alg = preg_replace("/L2/","<905>",$alg); $alg = preg_replace("/L/","<906>",$alg);
    $alg = preg_replace("/F'/","<907>",$alg); $alg = preg_replace("/F2/","<908>",$alg); $alg = preg_replace("/F/","<909>",$alg);
    $alg = preg_replace("/B'/","<910>",$alg); $alg = preg_replace("/B2/","<911>",$alg); $alg = preg_replace("/B/","<912>",$alg);
    $alg = preg_replace("/U'/","<913>",$alg); $alg = preg_replace("/U2/","<914>",$alg); $alg = preg_replace("/U/","<915>",$alg);
    $alg = preg_replace("/D'/","<916>",$alg); $alg = preg_replace("/D2/","<917>",$alg); $alg = preg_replace("/D/","<918>",$alg);
    
    /* --- 7xC: TWIZZLE -> CODE: [3] Tier twists (SiGN) --- */
    /* T */
    $alg = preg_replace("/r'/","<373>",$alg); $alg = preg_replace("/r2/","<374>",$alg); $alg = preg_replace("/r/","<375>",$alg);
    $alg = preg_replace("/l'/","<376>",$alg); $alg = preg_replace("/l2/","<377>",$alg); $alg = preg_replace("/l/","<378>",$alg);
    $alg = preg_replace("/f'/","<379>",$alg); $alg = preg_replace("/f2/","<380>",$alg); $alg = preg_replace("/f/","<381>",$alg);
    $alg = preg_replace("/b'/","<382>",$alg); $alg = preg_replace("/b2/","<383>",$alg); $alg = preg_replace("/b/","<384>",$alg);
    $alg = preg_replace("/u'/","<385>",$alg); $alg = preg_replace("/u2/","<386>",$alg); $alg = preg_replace("/u/","<387>",$alg);
    $alg = preg_replace("/d'/","<388>",$alg); $alg = preg_replace("/d2/","<389>",$alg); $alg = preg_replace("/d/","<390>",$alg);
    
    /* ··································································································· */
    /* --- 7xC: CODE -> SSE opt: [2] Slice twists --- */
    if ($optSSE == true) {
      /* S3 = S4-4 */
      $alg = preg_replace("/<201>/","S3R'",$alg); $alg = preg_replace("/<202>/","S3R2",$alg); $alg = preg_replace("/<203>/","S3R",$alg);
      $alg = preg_replace("/<204>/","S3F'",$alg); $alg = preg_replace("/<205>/","S3F2",$alg); $alg = preg_replace("/<206>/","S3F",$alg);
      $alg = preg_replace("/<207>/","S3U'",$alg); $alg = preg_replace("/<208>/","S3U2",$alg); $alg = preg_replace("/<209>/","S3U",$alg);
      
      
      /* S2 = S3-5 */
      $alg = preg_replace("/<210>/","S2R'",$alg); $alg = preg_replace("/<211>/","S2R2",$alg); $alg = preg_replace("/<212>/","S2R",$alg);
      $alg = preg_replace("/<213>/","S2F'",$alg); $alg = preg_replace("/<214>/","S2F2",$alg); $alg = preg_replace("/<215>/","S2F",$alg);
      $alg = preg_replace("/<216>/","S2U'",$alg); $alg = preg_replace("/<217>/","S2U2",$alg); $alg = preg_replace("/<218>/","S2U",$alg);
      
      
      /* Non-slice-twists */
      $alg = preg_replace("/<255>/","R' L'",$alg);
      $alg = preg_replace("/<256>/","F' B'",$alg);
      $alg = preg_replace("/<257>/","U' D'",$alg);
      
      /* S = S2-6 */
      $alg = preg_replace("/<219>/","SR'",$alg);  $alg = preg_replace("/<220>/","SR2",$alg);  $alg = preg_replace("/<221>/","SR",$alg);
      $alg = preg_replace("/<222>/","SF'",$alg);  $alg = preg_replace("/<223>/","SF2",$alg);  $alg = preg_replace("/<224>/","SF",$alg);
      $alg = preg_replace("/<225>/","SU'",$alg);  $alg = preg_replace("/<226>/","SU2",$alg);  $alg = preg_replace("/<227>/","SU",$alg);
      
      /* S2-2 | S6-6 */
      
      /* S2-3 | S5-6 */
      
      /* S2-4 | S4-6 */
      
      /* S2-5 | S3-6 */
      
      /* S3-3 | S5-5 */
      
      /* S3-4 | S4-5 */
    }
    
    /* --- 7xC: CODE -> SSE: [6] Wide layer twists --- */
    /* W */
    $alg = preg_replace("/<601>/","WR'",$alg); $alg = preg_replace("/<602>/","WR2",$alg); $alg = preg_replace("/<603>/","WR",$alg);
    $alg = preg_replace("/<604>/","WF'",$alg); $alg = preg_replace("/<605>/","WF2",$alg); $alg = preg_replace("/<606>/","WF",$alg);
    $alg = preg_replace("/<607>/","WU'",$alg); $alg = preg_replace("/<608>/","WU2",$alg); $alg = preg_replace("/<609>/","WU",$alg);
    
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
    $alg = preg_replace("/<504>/","M3F'",$alg); $alg = preg_replace("/<505>/","M3F2",$alg); $alg = preg_replace("/<506>/","M3F",$alg);
    $alg = preg_replace("/<507>/","M3U'",$alg); $alg = preg_replace("/<508>/","M3U2",$alg); $alg = preg_replace("/<509>/","M3U",$alg);
    
    /* --- 7xC: CODE -> SSE: [1] Numbered layer, [5] Mid-layer twists --- */
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
    $alg = preg_replace("/<140>/","MF'",$alg); $alg = preg_replace("/<141>/","MF2",$alg); $alg = preg_replace("/<142>/","MF",$alg);
    $alg = preg_replace("/<143>/","MU'",$alg); $alg = preg_replace("/<144>/","MU2",$alg); $alg = preg_replace("/<145>/","MU",$alg);
    
    /* --- 7xC: CODE -> SSE: [3] Tier twists --- */
    /* T6 */
    $alg = preg_replace("/<301>/","T6R'",$alg); $alg = preg_replace("/<302>/","T6R2",$alg); $alg = preg_replace("/<303>/","T6R",$alg);
    $alg = preg_replace("/<304>/","T6L'",$alg); $alg = preg_replace("/<305>/","T6L2",$alg); $alg = preg_replace("/<306>/","T6L",$alg);
    $alg = preg_replace("/<307>/","T6F'",$alg); $alg = preg_replace("/<308>/","T6F2",$alg); $alg = preg_replace("/<309>/","T6F",$alg);
    $alg = preg_replace("/<310>/","T6B'",$alg); $alg = preg_replace("/<311>/","T6B2",$alg); $alg = preg_replace("/<312>/","T6B",$alg);
    $alg = preg_replace("/<313>/","T6U'",$alg); $alg = preg_replace("/<314>/","T6U2",$alg); $alg = preg_replace("/<315>/","T6U",$alg);
    $alg = preg_replace("/<316>/","T6D'",$alg); $alg = preg_replace("/<317>/","T6D2",$alg); $alg = preg_replace("/<318>/","T6D",$alg);
    
    
    /* T5 */
    $alg = preg_replace("/<319>/","T5R'",$alg); $alg = preg_replace("/<320>/","T5R2",$alg); $alg = preg_replace("/<321>/","T5R",$alg);
    $alg = preg_replace("/<322>/","T5L'",$alg); $alg = preg_replace("/<323>/","T5L2",$alg); $alg = preg_replace("/<324>/","T5L",$alg);
    $alg = preg_replace("/<325>/","T5F'",$alg); $alg = preg_replace("/<326>/","T5F2",$alg); $alg = preg_replace("/<327>/","T5F",$alg);
    $alg = preg_replace("/<328>/","T5B'",$alg); $alg = preg_replace("/<329>/","T5B2",$alg); $alg = preg_replace("/<330>/","T5B",$alg);
    $alg = preg_replace("/<331>/","T5U'",$alg); $alg = preg_replace("/<332>/","T5U2",$alg); $alg = preg_replace("/<333>/","T5U",$alg);
    $alg = preg_replace("/<334>/","T5D'",$alg); $alg = preg_replace("/<335>/","T5D2",$alg); $alg = preg_replace("/<336>/","T5D",$alg);
    
    
    /* T4 */
    $alg = preg_replace("/<337>/","T4R'",$alg); $alg = preg_replace("/<338>/","T4R2",$alg); $alg = preg_replace("/<339>/","T4R",$alg);
    $alg = preg_replace("/<340>/","T4L'",$alg); $alg = preg_replace("/<341>/","T4L2",$alg); $alg = preg_replace("/<342>/","T4L",$alg);
    $alg = preg_replace("/<343>/","T4F'",$alg); $alg = preg_replace("/<344>/","T4F2",$alg); $alg = preg_replace("/<345>/","T4F",$alg);
    $alg = preg_replace("/<346>/","T4B'",$alg); $alg = preg_replace("/<347>/","T4B2",$alg); $alg = preg_replace("/<348>/","T4B",$alg);
    $alg = preg_replace("/<349>/","T4U'",$alg); $alg = preg_replace("/<350>/","T4U2",$alg); $alg = preg_replace("/<351>/","T4U",$alg);
    $alg = preg_replace("/<352>/","T4D'",$alg); $alg = preg_replace("/<353>/","T4D2",$alg); $alg = preg_replace("/<354>/","T4D",$alg);
    
    
    /* T3 */
    $alg = preg_replace("/<355>/","T3R'",$alg); $alg = preg_replace("/<356>/","T3R2",$alg); $alg = preg_replace("/<357>/","T3R",$alg);
    $alg = preg_replace("/<358>/","T3L'",$alg); $alg = preg_replace("/<359>/","T3L2",$alg); $alg = preg_replace("/<360>/","T3L",$alg);
    $alg = preg_replace("/<361>/","T3F'",$alg); $alg = preg_replace("/<362>/","T3F2",$alg); $alg = preg_replace("/<363>/","T3F",$alg);
    $alg = preg_replace("/<364>/","T3B'",$alg); $alg = preg_replace("/<365>/","T3B2",$alg); $alg = preg_replace("/<366>/","T3B",$alg);
    $alg = preg_replace("/<367>/","T3U'",$alg); $alg = preg_replace("/<368>/","T3U2",$alg); $alg = preg_replace("/<369>/","T3U",$alg);
    $alg = preg_replace("/<370>/","T3D'",$alg); $alg = preg_replace("/<371>/","T3D2",$alg); $alg = preg_replace("/<372>/","T3D",$alg);
    
    /* --- 7xC: CODE -> SSE: [7] Cube rotations --- */
    /* C */
    $alg = preg_replace("/<701>/","CR'",$alg); $alg = preg_replace("/<702>/","CR2",$alg); $alg = preg_replace("/<703>/","CR",$alg);
    $alg = preg_replace("/<704>/","CF'",$alg); $alg = preg_replace("/<705>/","CF2",$alg); $alg = preg_replace("/<706>/","CF",$alg);
    $alg = preg_replace("/<707>/","CU'",$alg); $alg = preg_replace("/<708>/","CU2",$alg); $alg = preg_replace("/<709>/","CU",$alg);
    
    /* --- 7xC: CODE -> SSE: [9] Face twists --- */
    /*   */
    $alg = preg_replace("/<901>/","R'",$alg); $alg = preg_replace("/<902>/","R2",$alg); $alg = preg_replace("/<903>/","R",$alg);
    $alg = preg_replace("/<904>/","L'",$alg); $alg = preg_replace("/<905>/","L2",$alg); $alg = preg_replace("/<906>/","L",$alg);
    $alg = preg_replace("/<907>/","F'",$alg); $alg = preg_replace("/<908>/","F2",$alg); $alg = preg_replace("/<909>/","F",$alg);
    $alg = preg_replace("/<910>/","B'",$alg); $alg = preg_replace("/<911>/","B2",$alg); $alg = preg_replace("/<912>/","B",$alg);
    $alg = preg_replace("/<913>/","U'",$alg); $alg = preg_replace("/<914>/","U2",$alg); $alg = preg_replace("/<915>/","U",$alg);
    $alg = preg_replace("/<916>/","D'",$alg); $alg = preg_replace("/<917>/","D2",$alg); $alg = preg_replace("/<918>/","D",$alg);
    
    /* --- 7xC: CODE -> SSE: [3] Tier twists --- */
    /* T */
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
    /* M = N = W */
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
    /* T */
    $alg = preg_replace("/TU'/","<301>",$alg); $alg = preg_replace("/TU-/","<301>",$alg);   $alg = preg_replace("/TU/","<302>",$alg);
    $alg = preg_replace("/TR'/","<303>",$alg); $alg = preg_replace("/TR-/","<303>",$alg);   $alg = preg_replace("/TR/","<304>",$alg);
    $alg = preg_replace("/TL'/","<305>",$alg); $alg = preg_replace("/TL-/","<305>",$alg);   $alg = preg_replace("/TL/","<306>",$alg);
    $alg = preg_replace("/TB'/","<307>",$alg); $alg = preg_replace("/TB-/","<307>",$alg);   $alg = preg_replace("/TB/","<308>",$alg);
    
    /* --- 3xP: SSE -> CODE: [7] Pyramid rotations --- */
    /* C */
    $alg = preg_replace("/CU'/","<701>",$alg); $alg = preg_replace("/CU-/","<701>",$alg);   $alg = preg_replace("/CU/","<702>",$alg);
    $alg = preg_replace("/CR'/","<703>",$alg); $alg = preg_replace("/CR-/","<703>",$alg);   $alg = preg_replace("/CR/","<704>",$alg);
    $alg = preg_replace("/CL'/","<705>",$alg); $alg = preg_replace("/CL-/","<705>",$alg);   $alg = preg_replace("/CL/","<706>",$alg);
    $alg = preg_replace("/CB'/","<707>",$alg); $alg = preg_replace("/CB-/","<707>",$alg);   $alg = preg_replace("/CB/","<708>",$alg);
    
    /* --- 3xP: SSE -> CODE: [9] Corner twists --- */
    /*   */
    $alg = preg_replace("/U'/","<901>",$alg); $alg = preg_replace("/U-/","<901>",$alg);   $alg = preg_replace("/U/","<902>",$alg);
    $alg = preg_replace("/R'/","<903>",$alg); $alg = preg_replace("/R-/","<903>",$alg);   $alg = preg_replace("/R/","<904>",$alg);
    $alg = preg_replace("/L'/","<905>",$alg); $alg = preg_replace("/L-/","<905>",$alg);   $alg = preg_replace("/L/","<906>",$alg);
    $alg = preg_replace("/B'/","<907>",$alg); $alg = preg_replace("/B-/","<907>",$alg);   $alg = preg_replace("/B/","<908>",$alg);
    
    /* ··································································································· */
    /* --- 3xP: CODE -> TWIZZLE: [5] Mid-layer [1] (Numbered layer) [6] (Wide) twists --- */
    /* M = N = W */
    $alg = preg_replace("/<101>/","2u'",$alg); $alg = preg_replace("/<102>/","2u",$alg);
    $alg = preg_replace("/<103>/","2r'",$alg); $alg = preg_replace("/<104>/","2r",$alg);
    $alg = preg_replace("/<105>/","2l'",$alg); $alg = preg_replace("/<106>/","2l",$alg);
    $alg = preg_replace("/<107>/","2b'",$alg); $alg = preg_replace("/<108>/","2b",$alg);
    
    /* --- 3xP: CODE -> TWIZZLE: [3] Tier twists --- */
    /* T */
    $alg = preg_replace("/<301>/","U'",$alg); $alg = preg_replace("/<302>/","U",$alg);
    $alg = preg_replace("/<303>/","R'",$alg); $alg = preg_replace("/<304>/","R",$alg);
    $alg = preg_replace("/<305>/","L'",$alg); $alg = preg_replace("/<306>/","L",$alg);
    $alg = preg_replace("/<307>/","B'",$alg); $alg = preg_replace("/<308>/","B",$alg);
    
    /* --- 3xP: CODE -> TWIZZLE: [7] Pyramid rotations --- */
    /* C */
    $alg = preg_replace("/<701>/","Uv'",$alg); $alg = preg_replace("/<702>/","Uv",$alg);
    $alg = preg_replace("/<703>/","Rv'",$alg); $alg = preg_replace("/<704>/","Rv",$alg);
    $alg = preg_replace("/<705>/","Lv'",$alg); $alg = preg_replace("/<706>/","Lv",$alg);
    $alg = preg_replace("/<707>/","Bv'",$alg); $alg = preg_replace("/<708>/","Bv",$alg);
    
    /* --- 3xP: CODE -> TWIZZLE: [9] Corner twists --- */
    /*   */
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
    /* --- 3xP: TWIZZLE -> CODE: [3] Tier twists --- */
    /* T */
    $alg = preg_replace("/2U'/","<301>",$alg); $alg = preg_replace("/2U/","<302>",$alg);
    $alg = preg_replace("/2R'/","<303>",$alg); $alg = preg_replace("/2R/","<304>",$alg);
    $alg = preg_replace("/2L'/","<305>",$alg); $alg = preg_replace("/2L/","<306>",$alg);
    $alg = preg_replace("/2B'/","<307>",$alg); $alg = preg_replace("/2B/","<308>",$alg);
    
    /* --- 3xP: TWIZZLE -> CODE: [9] Corner twists --- */
    /*   */
    $alg = preg_replace("/1U'/","<901>",$alg); $alg = preg_replace("/1U/","<902>",$alg);
    $alg = preg_replace("/1R'/","<903>",$alg); $alg = preg_replace("/1R/","<904>",$alg);
    $alg = preg_replace("/1L'/","<905>",$alg); $alg = preg_replace("/1L/","<906>",$alg);
    $alg = preg_replace("/1B'/","<907>",$alg); $alg = preg_replace("/1B/","<908>",$alg);
    
    $alg = preg_replace("/1u'/","<901>",$alg); $alg = preg_replace("/1u/","<902>",$alg);
    $alg = preg_replace("/1r'/","<903>",$alg); $alg = preg_replace("/1r/","<904>",$alg);
    $alg = preg_replace("/1l'/","<905>",$alg); $alg = preg_replace("/1l/","<906>",$alg);
    $alg = preg_replace("/1b'/","<907>",$alg); $alg = preg_replace("/1b/","<908>",$alg);
    
    /* --- 3xP: TWIZZLE -> CODE: [5] Mid-layer [1] (Numbered layer) [6] (Wide) twists --- */
    /* M */
    $alg = preg_replace("/2u'/","<101>",$alg); $alg = preg_replace("/2u/","<102>",$alg);
    $alg = preg_replace("/2r'/","<103>",$alg); $alg = preg_replace("/2r/","<104>",$alg);
    $alg = preg_replace("/2l'/","<105>",$alg); $alg = preg_replace("/2l/","<106>",$alg);
    $alg = preg_replace("/2b'/","<107>",$alg); $alg = preg_replace("/2b/","<108>",$alg);
    
    /* --- 3xP: TWIZZLE -> CODE: [8] Face twists --- */
    $alg = preg_replace("/3u'/","<801>",$alg); $alg = preg_replace("/3u/","<802>",$alg);
    $alg = preg_replace("/3r'/","<803>",$alg); $alg = preg_replace("/3r/","<804>",$alg);
    $alg = preg_replace("/3l'/","<805>",$alg); $alg = preg_replace("/3l/","<806>",$alg);
    $alg = preg_replace("/3b'/","<807>",$alg); $alg = preg_replace("/3b/","<808>",$alg);
    
    /* --- 3xP: TWIZZLE -> CODE: [7] Pyramid rotations --- */
    /* C */
    $alg = preg_replace("/Uv'/","<701>",$alg); $alg = preg_replace("/Uv/","<702>",$alg);
    $alg = preg_replace("/Rv'/","<703>",$alg); $alg = preg_replace("/Rv/","<704>",$alg);
    $alg = preg_replace("/Lv'/","<705>",$alg); $alg = preg_replace("/Lv/","<706>",$alg);
    $alg = preg_replace("/Bv'/","<707>",$alg); $alg = preg_replace("/Bv/","<708>",$alg);
    
    /* --- 3xP: TWIZZLE -> CODE: [3] Tier twists --- */
    /* T */
    $alg = preg_replace("/U'/","<301>",$alg); $alg = preg_replace("/U/","<302>",$alg);
    $alg = preg_replace("/R'/","<303>",$alg); $alg = preg_replace("/R/","<304>",$alg);
    $alg = preg_replace("/L'/","<305>",$alg); $alg = preg_replace("/L/","<306>",$alg);
    $alg = preg_replace("/B'/","<307>",$alg); $alg = preg_replace("/B/","<308>",$alg);
    
    /* --- 3xP: TWIZZLE -> CODE: [9] Corner twists --- */
    /*   */
    $alg = preg_replace("/u'/","<901>",$alg); $alg = preg_replace("/u/","<902>",$alg);
    $alg = preg_replace("/r'/","<903>",$alg); $alg = preg_replace("/r/","<904>",$alg);
    $alg = preg_replace("/l'/","<905>",$alg); $alg = preg_replace("/l/","<906>",$alg);
    $alg = preg_replace("/b'/","<907>",$alg); $alg = preg_replace("/b/","<908>",$alg);
    
    /* ··································································································· */
    /* --- 3xP: CODE -> SSE: [3] Tier twists --- */
    /* T */
    $alg = preg_replace("/<301>/","TU'",$alg); $alg = preg_replace("/<302>/","TU",$alg);
    $alg = preg_replace("/<303>/","TR'",$alg); $alg = preg_replace("/<304>/","TR",$alg);
    $alg = preg_replace("/<305>/","TL'",$alg); $alg = preg_replace("/<306>/","TL",$alg);
    $alg = preg_replace("/<307>/","TB'",$alg); $alg = preg_replace("/<308>/","TB",$alg);
    
    /* --- 3xP: CODE -> SSE: [5] Mid-layer [1] (Numbered layer) [6] (Wide) twists --- */
    /* M */
    $alg = preg_replace("/<101>/","MU'",$alg); $alg = preg_replace("/<102>/","MU",$alg);
    $alg = preg_replace("/<103>/","MR'",$alg); $alg = preg_replace("/<104>/","MR",$alg);
    $alg = preg_replace("/<105>/","ML'",$alg); $alg = preg_replace("/<106>/","ML",$alg);
    $alg = preg_replace("/<107>/","MB'",$alg); $alg = preg_replace("/<108>/","MB",$alg);
    
    /* --- 3xP: CODE -> SSE: [8] Face twists --- */
    $alg = preg_replace("/<801>/","TU CU'",$alg); $alg = preg_replace("/<802>/","TU' CU",$alg);
    $alg = preg_replace("/<803>/","TR CR'",$alg); $alg = preg_replace("/<804>/","TR' CR",$alg);
    $alg = preg_replace("/<805>/","TL CL'",$alg); $alg = preg_replace("/<806>/","TL' CL",$alg);
    $alg = preg_replace("/<807>/","TB CB'",$alg); $alg = preg_replace("/<808>/","TB' CB",$alg);
    
    /* --- 3xP: CODE -> SSE: [7] Pyramid rotations --- */
    /* C */
    $alg = preg_replace("/<701>/","CU'",$alg); $alg = preg_replace("/<702>/","CU",$alg);
    $alg = preg_replace("/<703>/","CR'",$alg); $alg = preg_replace("/<704>/","CR",$alg);
    $alg = preg_replace("/<705>/","CL'",$alg); $alg = preg_replace("/<706>/","CL",$alg);
    $alg = preg_replace("/<707>/","CB'",$alg); $alg = preg_replace("/<708>/","CB",$alg);
    
    /* --- 3xP: CODE -> SSE: [9] Corner twists --- */
    /*   */
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
    /* W = V = N2-3 */
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
    /* N3 */
    $alg = preg_replace("/N3U'/","<201>",$alg); $alg = preg_replace("/N3U-/","<201>",$alg);   $alg = preg_replace("/N3U/","<202>",$alg);
    $alg = preg_replace("/N3R'/","<203>",$alg); $alg = preg_replace("/N3R-/","<203>",$alg);   $alg = preg_replace("/N3R/","<204>",$alg);
    $alg = preg_replace("/N3L'/","<205>",$alg); $alg = preg_replace("/N3L-/","<205>",$alg);   $alg = preg_replace("/N3L/","<206>",$alg);
    $alg = preg_replace("/N3B'/","<207>",$alg); $alg = preg_replace("/N3B-/","<207>",$alg);   $alg = preg_replace("/N3B/","<208>",$alg);
    
    /* N */
    $alg = preg_replace("/NU'/","<209>",$alg); $alg = preg_replace("/NU-/","<209>",$alg);   $alg = preg_replace("/NU/","<210>",$alg);
    $alg = preg_replace("/NR'/","<211>",$alg); $alg = preg_replace("/NR-/","<211>",$alg);   $alg = preg_replace("/NR/","<212>",$alg);
    $alg = preg_replace("/NL'/","<213>",$alg); $alg = preg_replace("/NL-/","<213>",$alg);   $alg = preg_replace("/NL/","<214>",$alg);
    $alg = preg_replace("/NB'/","<215>",$alg); $alg = preg_replace("/NB-/","<215>",$alg);   $alg = preg_replace("/NB/","<216>",$alg);
    
    /* --- 4xP: SSE -> CODE: [3] Tier twists --- */
    /* T3 */
    $alg = preg_replace("/T3U'/","<301>",$alg); $alg = preg_replace("/T3U-/","<301>",$alg);   $alg = preg_replace("/T3U/","<302>",$alg);
    $alg = preg_replace("/T3R'/","<303>",$alg); $alg = preg_replace("/T3R-/","<303>",$alg);   $alg = preg_replace("/T3R/","<304>",$alg);
    $alg = preg_replace("/T3L'/","<305>",$alg); $alg = preg_replace("/T3L-/","<305>",$alg);   $alg = preg_replace("/T3L/","<306>",$alg);
    $alg = preg_replace("/T3B'/","<307>",$alg); $alg = preg_replace("/T3B-/","<307>",$alg);   $alg = preg_replace("/T3B/","<308>",$alg);
    
    /* T */
    $alg = preg_replace("/TU'/","<309>",$alg); $alg = preg_replace("/TU-/","<309>",$alg);   $alg = preg_replace("/TU/","<310>",$alg);
    $alg = preg_replace("/TR'/","<311>",$alg); $alg = preg_replace("/TR-/","<311>",$alg);   $alg = preg_replace("/TR/","<312>",$alg);
    $alg = preg_replace("/TL'/","<313>",$alg); $alg = preg_replace("/TL-/","<313>",$alg);   $alg = preg_replace("/TL/","<314>",$alg);
    $alg = preg_replace("/TB'/","<315>",$alg); $alg = preg_replace("/TB-/","<315>",$alg);   $alg = preg_replace("/TB/","<316>",$alg);
    
    /* --- 4xP: SSE -> CODE: [7] Pyramid rotations --- */
    /* C */
    $alg = preg_replace("/CU'/","<701>",$alg); $alg = preg_replace("/CU-/","<701>",$alg);   $alg = preg_replace("/CU/","<702>",$alg);
    $alg = preg_replace("/CR'/","<703>",$alg); $alg = preg_replace("/CR-/","<703>",$alg);   $alg = preg_replace("/CR/","<704>",$alg);
    $alg = preg_replace("/CL'/","<705>",$alg); $alg = preg_replace("/CL-/","<705>",$alg);   $alg = preg_replace("/CL/","<706>",$alg);
    $alg = preg_replace("/CB'/","<707>",$alg); $alg = preg_replace("/CB-/","<707>",$alg);   $alg = preg_replace("/CB/","<708>",$alg);
    
    /* --- 4xP: SSE -> CODE: [9] Corner twists --- */
    /*   */
    $alg = preg_replace("/U'/","<901>",$alg); $alg = preg_replace("/U-/","<901>",$alg);   $alg = preg_replace("/U/","<902>",$alg);
    $alg = preg_replace("/R'/","<903>",$alg); $alg = preg_replace("/R-/","<903>",$alg);   $alg = preg_replace("/R/","<904>",$alg);
    $alg = preg_replace("/L'/","<905>",$alg); $alg = preg_replace("/L-/","<905>",$alg);   $alg = preg_replace("/L/","<906>",$alg);
    $alg = preg_replace("/B'/","<907>",$alg); $alg = preg_replace("/B-/","<907>",$alg);   $alg = preg_replace("/B/","<908>",$alg);
    
    /* ··································································································· */
    /* --- 4xP: CODE -> TWIZZLE: [1] Wide-layer twists --- */
    /* W = V = N2-3 */
    $alg = preg_replace("/<101>/","2-3U'",$alg); $alg = preg_replace("/<102>/","2-3U",$alg);
    $alg = preg_replace("/<103>/","2-3R'",$alg); $alg = preg_replace("/<104>/","2-3R",$alg);
    $alg = preg_replace("/<105>/","2-3L'",$alg); $alg = preg_replace("/<106>/","2-3L",$alg);
    $alg = preg_replace("/<107>/","2-3B'",$alg); $alg = preg_replace("/<108>/","2-3B",$alg);
    
    /* --- 4xP: CODE -> TWIZZLE: [2] Numbered layer twists --- */
    /* N3 */
    $alg = preg_replace("/<201>/","3U'",$alg); $alg = preg_replace("/<202>/","3U",$alg);
    $alg = preg_replace("/<203>/","3R'",$alg); $alg = preg_replace("/<204>/","3R",$alg);
    $alg = preg_replace("/<205>/","3L'",$alg); $alg = preg_replace("/<206>/","3L",$alg);
    $alg = preg_replace("/<207>/","3B'",$alg); $alg = preg_replace("/<208>/","3B",$alg);
    
    /* N */
    $alg = preg_replace("/<209>/","2U'",$alg); $alg = preg_replace("/<210>/","2U",$alg);
    $alg = preg_replace("/<211>/","2R'",$alg); $alg = preg_replace("/<212>/","2R",$alg);
    $alg = preg_replace("/<213>/","2L'",$alg); $alg = preg_replace("/<214>/","2L",$alg);
    $alg = preg_replace("/<215>/","2B'",$alg); $alg = preg_replace("/<216>/","2B",$alg);
    
    /* --- 4xP: CODE -> TWIZZLE: [3] Tier twists --- */
    /* T3 */
    $alg = preg_replace("/<301>/","3u'",$alg); $alg = preg_replace("/<302>/","3u",$alg);
    $alg = preg_replace("/<303>/","3r'",$alg); $alg = preg_replace("/<304>/","3r",$alg);
    $alg = preg_replace("/<305>/","3l'",$alg); $alg = preg_replace("/<306>/","3l",$alg);
    $alg = preg_replace("/<307>/","3b'",$alg); $alg = preg_replace("/<308>/","3b",$alg);
    
    /* T */
    $alg = preg_replace("/<309>/","u'",$alg); $alg = preg_replace("/<310>/","u",$alg);
    $alg = preg_replace("/<311>/","r'",$alg); $alg = preg_replace("/<312>/","r",$alg);
    $alg = preg_replace("/<313>/","l'",$alg); $alg = preg_replace("/<314>/","l",$alg);
    $alg = preg_replace("/<315>/","b'",$alg); $alg = preg_replace("/<316>/","b",$alg);
    
    /* --- 4xP: CODE -> TWIZZLE: [7] Pyramid rotations --- */
    /* C */
    $alg = preg_replace("/<701>/","Uv'",$alg); $alg = preg_replace("/<702>/","Uv",$alg);
    $alg = preg_replace("/<703>/","Rv'",$alg); $alg = preg_replace("/<704>/","Rv",$alg);
    $alg = preg_replace("/<705>/","Lv'",$alg); $alg = preg_replace("/<706>/","Lv",$alg);
    $alg = preg_replace("/<707>/","Bv'",$alg); $alg = preg_replace("/<708>/","Bv",$alg);
    
    /* --- 4xP: CODE -> TWIZZLE: [9] Corner twists --- */
    /*   */
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
    /* W */
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
    /* N3 */
    $alg = preg_replace("/3U'/","<201>",$alg); $alg = preg_replace("/3U/","<202>",$alg);
    $alg = preg_replace("/3R'/","<203>",$alg); $alg = preg_replace("/3R/","<204>",$alg);
    $alg = preg_replace("/3L'/","<205>",$alg); $alg = preg_replace("/3L/","<206>",$alg);
    $alg = preg_replace("/3B'/","<207>",$alg); $alg = preg_replace("/3B/","<208>",$alg);
    
    /* N */
    $alg = preg_replace("/2U'/","<209>",$alg); $alg = preg_replace("/2U/","<210>",$alg);
    $alg = preg_replace("/2R'/","<211>",$alg); $alg = preg_replace("/2R/","<212>",$alg);
    $alg = preg_replace("/2L'/","<213>",$alg); $alg = preg_replace("/2L/","<214>",$alg);
    $alg = preg_replace("/2B'/","<215>",$alg); $alg = preg_replace("/2B/","<216>",$alg);
    
    /* --- 4xP: TWIZZLE -> CODE: [3] Tier twists --- */
    /* T3 */
    $alg = preg_replace("/3u'/","<301>",$alg); $alg = preg_replace("/3u/","<302>",$alg);
    $alg = preg_replace("/3r'/","<303>",$alg); $alg = preg_replace("/3r/","<304>",$alg);
    $alg = preg_replace("/3l'/","<305>",$alg); $alg = preg_replace("/3l/","<306>",$alg);
    $alg = preg_replace("/3b'/","<307>",$alg); $alg = preg_replace("/3b/","<308>",$alg);
    
    /* --- 3xP: TWIZZLE -> CODE: [9] Corner twists --- */
    /*   */
    $alg = preg_replace("/1u'/","<901>",$alg); $alg = preg_replace("/1u/","<902>",$alg);
    $alg = preg_replace("/1r'/","<903>",$alg); $alg = preg_replace("/1r/","<904>",$alg);
    $alg = preg_replace("/1l'/","<905>",$alg); $alg = preg_replace("/1l/","<906>",$alg);
    $alg = preg_replace("/1b'/","<907>",$alg); $alg = preg_replace("/1b/","<908>",$alg);
    
    $alg = preg_replace("/1U'/","<901>",$alg); $alg = preg_replace("/1U/","<902>",$alg);
    $alg = preg_replace("/1R'/","<903>",$alg); $alg = preg_replace("/1R/","<904>",$alg);
    $alg = preg_replace("/1L'/","<905>",$alg); $alg = preg_replace("/1L/","<906>",$alg);
    $alg = preg_replace("/1B'/","<907>",$alg); $alg = preg_replace("/1B/","<908>",$alg);
    
    /* --- 4xP: TWIZZLE -> CODE: [7] Pyramid rotations --- */
    /* C */
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
    /* T */
    $alg = preg_replace("/u'/","<309>",$alg); $alg = preg_replace("/u/","<310>",$alg);
    $alg = preg_replace("/r'/","<311>",$alg); $alg = preg_replace("/r/","<312>",$alg);
    $alg = preg_replace("/l'/","<313>",$alg); $alg = preg_replace("/l/","<314>",$alg);
    $alg = preg_replace("/b'/","<315>",$alg); $alg = preg_replace("/b/","<316>",$alg);
    
    /* ··································································································· */
    /* --- 4xP: CODE -> SSE: [1] Wide-layer twists --- */
    /* W */
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
    /* N3 */
    $alg = preg_replace("/<201>/","N3U'",$alg); $alg = preg_replace("/<202>/","N3U",$alg);
    $alg = preg_replace("/<203>/","N3R'",$alg); $alg = preg_replace("/<204>/","N3R",$alg);
    $alg = preg_replace("/<205>/","N3L'",$alg); $alg = preg_replace("/<206>/","N3L",$alg);
    $alg = preg_replace("/<207>/","N3B'",$alg); $alg = preg_replace("/<208>/","N3B",$alg);
    
    /* N */
    $alg = preg_replace("/<209>/","NU'",$alg); $alg = preg_replace("/<210>/","NU",$alg);
    $alg = preg_replace("/<211>/","NR'",$alg); $alg = preg_replace("/<212>/","NR",$alg);
    $alg = preg_replace("/<213>/","NL'",$alg); $alg = preg_replace("/<214>/","NL",$alg);
    $alg = preg_replace("/<215>/","NB'",$alg); $alg = preg_replace("/<216>/","NB",$alg);
    
    /* --- 4xP: CODE -> SSE: [3] Tier twists --- */
    /* T3 */
    $alg = preg_replace("/<301>/","T3U'",$alg); $alg = preg_replace("/<302>/","T3U",$alg);
    $alg = preg_replace("/<303>/","T3R'",$alg); $alg = preg_replace("/<304>/","T3R",$alg);
    $alg = preg_replace("/<305>/","T3L'",$alg); $alg = preg_replace("/<306>/","T3L",$alg);
    $alg = preg_replace("/<307>/","T3B'",$alg); $alg = preg_replace("/<308>/","T3B",$alg);
    
    /* --- 4xP: CODE -> SSE: [7] Pyramid rotations --- */
    /* C */
    $alg = preg_replace("/<701>/","CU'",$alg); $alg = preg_replace("/<702>/","CU",$alg);
    $alg = preg_replace("/<703>/","CR'",$alg); $alg = preg_replace("/<704>/","CR",$alg);
    $alg = preg_replace("/<705>/","CL'",$alg); $alg = preg_replace("/<706>/","CL",$alg);
    $alg = preg_replace("/<707>/","CB'",$alg); $alg = preg_replace("/<708>/","CB",$alg);
    
    /* --- 4xP: CODE -> SSE: [9] Corner twists --- */
    /*   */
    $alg = preg_replace("/<901>/","U'",$alg); $alg = preg_replace("/<902>/","U",$alg);
    $alg = preg_replace("/<903>/","R'",$alg); $alg = preg_replace("/<904>/","R",$alg);
    $alg = preg_replace("/<905>/","L'",$alg); $alg = preg_replace("/<906>/","L",$alg);
    $alg = preg_replace("/<907>/","B'",$alg); $alg = preg_replace("/<908>/","B",$alg);
    
    /* --- 4xP: CODE -> SSE: [3] Tier twists --- */
    /* T */
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
    /* W = N2-4 */
    $alg = preg_replace("/WU'/","<101>",$alg); $alg = preg_replace("/WU-/","<101>",$alg);   $alg = preg_replace("/WU/","<102>",$alg);
    $alg = preg_replace("/WR'/","<103>",$alg); $alg = preg_replace("/WR-/","<103>",$alg);   $alg = preg_replace("/WR/","<104>",$alg);
    $alg = preg_replace("/WL'/","<105>",$alg); $alg = preg_replace("/WL-/","<105>",$alg);   $alg = preg_replace("/WL/","<106>",$alg);
    $alg = preg_replace("/WB'/","<107>",$alg); $alg = preg_replace("/WB-/","<107>",$alg);   $alg = preg_replace("/WB/","<108>",$alg);
    
    $alg = preg_replace("/N2-4U'/","<101>",$alg); $alg = preg_replace("/N2-4U-/","<101>",$alg);   $alg = preg_replace("/N2-4U/","<102>",$alg);
    $alg = preg_replace("/N2-4R'/","<103>",$alg); $alg = preg_replace("/N2-4R-/","<103>",$alg);   $alg = preg_replace("/N2-4R/","<104>",$alg);
    $alg = preg_replace("/N2-4L'/","<105>",$alg); $alg = preg_replace("/N2-4L-/","<105>",$alg);   $alg = preg_replace("/N2-4L/","<106>",$alg);
    $alg = preg_replace("/N2-4B'/","<107>",$alg); $alg = preg_replace("/N2-4B-/","<107>",$alg);   $alg = preg_replace("/N2-4B/","<108>",$alg);
    
    /* --- 5xP: SSE -> CODE: [2] Numbered layer twists --- */
    /* N3-4 */
    $alg = preg_replace("/N3-4U'/","<201>",$alg); $alg = preg_replace("/N3-4U-/","<201>",$alg);   $alg = preg_replace("/N3-4U/","<202>",$alg);
    $alg = preg_replace("/N3-4R'/","<203>",$alg); $alg = preg_replace("/N3-4R-/","<203>",$alg);   $alg = preg_replace("/N3-4R/","<204>",$alg);
    $alg = preg_replace("/N3-4L'/","<205>",$alg); $alg = preg_replace("/N3-4L-/","<205>",$alg);   $alg = preg_replace("/N3-4L/","<206>",$alg);
    $alg = preg_replace("/N3-4B'/","<207>",$alg); $alg = preg_replace("/N3-4B-/","<207>",$alg);   $alg = preg_replace("/N3-4B/","<208>",$alg);
    
    /* V = N2-3 */
    $alg = preg_replace("/N2-3U'/","<209>",$alg); $alg = preg_replace("/N2-3U-/","<209>",$alg);   $alg = preg_replace("/N2-3U/","<210>",$alg);
    $alg = preg_replace("/N2-3R'/","<211>",$alg); $alg = preg_replace("/N2-3R-/","<211>",$alg);   $alg = preg_replace("/N2-3R/","<212>",$alg);
    $alg = preg_replace("/N2-3L'/","<213>",$alg); $alg = preg_replace("/N2-3L-/","<213>",$alg);   $alg = preg_replace("/N2-3L/","<214>",$alg);
    $alg = preg_replace("/N2-3B'/","<215>",$alg); $alg = preg_replace("/N2-3B-/","<215>",$alg);   $alg = preg_replace("/N2-3B/","<216>",$alg);
    
    $alg = preg_replace("/VU'/","<209>",$alg); $alg = preg_replace("/VU-/","<209>",$alg);   $alg = preg_replace("/VU/","<210>",$alg);
    $alg = preg_replace("/VR'/","<211>",$alg); $alg = preg_replace("/VR-/","<211>",$alg);   $alg = preg_replace("/VR/","<212>",$alg);
    $alg = preg_replace("/VL'/","<213>",$alg); $alg = preg_replace("/VL-/","<213>",$alg);   $alg = preg_replace("/VL/","<214>",$alg);
    $alg = preg_replace("/VB'/","<215>",$alg); $alg = preg_replace("/VB-/","<215>",$alg);   $alg = preg_replace("/VB/","<216>",$alg);
    
    /* N4 */
    $alg = preg_replace("/N4U'/","<217>",$alg); $alg = preg_replace("/N4U-/","<217>",$alg);   $alg = preg_replace("/N4U/","<218>",$alg);
    $alg = preg_replace("/N4R'/","<219>",$alg); $alg = preg_replace("/N4R-/","<219>",$alg);   $alg = preg_replace("/N4R/","<220>",$alg);
    $alg = preg_replace("/N4L'/","<221>",$alg); $alg = preg_replace("/N4L-/","<221>",$alg);   $alg = preg_replace("/N4L/","<222>",$alg);
    $alg = preg_replace("/N4B'/","<223>",$alg); $alg = preg_replace("/N4B-/","<223>",$alg);   $alg = preg_replace("/N4B/","<224>",$alg);
    
    /* N3 */
    $alg = preg_replace("/N3U'/","<225>",$alg); $alg = preg_replace("/N3U-/","<225>",$alg);   $alg = preg_replace("/N3U/","<226>",$alg);
    $alg = preg_replace("/N3R'/","<227>",$alg); $alg = preg_replace("/N3R-/","<227>",$alg);   $alg = preg_replace("/N3R/","<228>",$alg);
    $alg = preg_replace("/N3L'/","<229>",$alg); $alg = preg_replace("/N3L-/","<229>",$alg);   $alg = preg_replace("/N3L/","<230>",$alg);
    $alg = preg_replace("/N3B'/","<231>",$alg); $alg = preg_replace("/N3B-/","<231>",$alg);   $alg = preg_replace("/N3B/","<232>",$alg);
    
    /* N */
    $alg = preg_replace("/NU'/","<233>",$alg); $alg = preg_replace("/NU-/","<233>",$alg);   $alg = preg_replace("/NU/","<234>",$alg);
    $alg = preg_replace("/NR'/","<235>",$alg); $alg = preg_replace("/NR-/","<235>",$alg);   $alg = preg_replace("/NR/","<236>",$alg);
    $alg = preg_replace("/NL'/","<237>",$alg); $alg = preg_replace("/NL-/","<237>",$alg);   $alg = preg_replace("/NL/","<238>",$alg);
    $alg = preg_replace("/NB'/","<239>",$alg); $alg = preg_replace("/NB-/","<239>",$alg);   $alg = preg_replace("/NB/","<240>",$alg);
    
    /* --- 5xP: SSE -> CODE: [3] Tier twists --- */
    /* T4 */
    $alg = preg_replace("/T4U'/","<301>",$alg); $alg = preg_replace("/T4U-/","<301>",$alg);   $alg = preg_replace("/T4U/","<302>",$alg);
    $alg = preg_replace("/T4R'/","<303>",$alg); $alg = preg_replace("/T4R-/","<303>",$alg);   $alg = preg_replace("/T4R/","<304>",$alg);
    $alg = preg_replace("/T4L'/","<305>",$alg); $alg = preg_replace("/T4L-/","<305>",$alg);   $alg = preg_replace("/T4L/","<306>",$alg);
    $alg = preg_replace("/T4B'/","<307>",$alg); $alg = preg_replace("/T4B-/","<307>",$alg);   $alg = preg_replace("/T4B/","<308>",$alg);
    
    /* T3 */
    $alg = preg_replace("/T3U'/","<309>",$alg); $alg = preg_replace("/T3U-/","<309>",$alg);   $alg = preg_replace("/T3U/","<310>",$alg);
    $alg = preg_replace("/T3R'/","<311>",$alg); $alg = preg_replace("/T3R-/","<311>",$alg);   $alg = preg_replace("/T3R/","<312>",$alg);
    $alg = preg_replace("/T3L'/","<313>",$alg); $alg = preg_replace("/T3L-/","<313>",$alg);   $alg = preg_replace("/T3L/","<314>",$alg);
    $alg = preg_replace("/T3B'/","<315>",$alg); $alg = preg_replace("/T3B-/","<315>",$alg);   $alg = preg_replace("/T3B/","<316>",$alg);
    
    /* T */
    $alg = preg_replace("/TU'/","<317>",$alg); $alg = preg_replace("/TU-/","<317>",$alg);   $alg = preg_replace("/TU/","<318>",$alg);
    $alg = preg_replace("/TR'/","<319>",$alg); $alg = preg_replace("/TR-/","<319>",$alg);   $alg = preg_replace("/TR/","<320>",$alg);
    $alg = preg_replace("/TL'/","<321>",$alg); $alg = preg_replace("/TL-/","<321>",$alg);   $alg = preg_replace("/TL/","<322>",$alg);
    $alg = preg_replace("/TB'/","<323>",$alg); $alg = preg_replace("/TB-/","<323>",$alg);   $alg = preg_replace("/TB/","<324>",$alg);
    
    /* --- 5xP: SSE -> CODE: [7] Pyramid rotations --- */
    /* C */
    $alg = preg_replace("/CU'/","<701>",$alg); $alg = preg_replace("/CU-/","<701>",$alg);   $alg = preg_replace("/CU/","<702>",$alg);
    $alg = preg_replace("/CR'/","<703>",$alg); $alg = preg_replace("/CR-/","<703>",$alg);   $alg = preg_replace("/CR/","<704>",$alg);
    $alg = preg_replace("/CL'/","<705>",$alg); $alg = preg_replace("/CL-/","<705>",$alg);   $alg = preg_replace("/CL/","<706>",$alg);
    $alg = preg_replace("/CB'/","<707>",$alg); $alg = preg_replace("/CB-/","<707>",$alg);   $alg = preg_replace("/CB/","<708>",$alg);
    
    /* --- 5xP: SSE -> CODE: [9] Corner twists --- */
    /*   */
    $alg = preg_replace("/U'/","<901>",$alg); $alg = preg_replace("/U-/","<901>",$alg);   $alg = preg_replace("/U/","<902>",$alg);
    $alg = preg_replace("/R'/","<903>",$alg); $alg = preg_replace("/R-/","<903>",$alg);   $alg = preg_replace("/R/","<904>",$alg);
    $alg = preg_replace("/L'/","<905>",$alg); $alg = preg_replace("/L-/","<905>",$alg);   $alg = preg_replace("/L/","<906>",$alg);
    $alg = preg_replace("/B'/","<907>",$alg); $alg = preg_replace("/B-/","<907>",$alg);   $alg = preg_replace("/B/","<908>",$alg);
    
    /* ··································································································· */
    /* --- 5xP: CODE -> TWIZZLE: [1] Wide-layer twists --- */
    /* W = N2-4 */
    $alg = preg_replace("/<101>/","2-4U'",$alg); $alg = preg_replace("/<102>/","2-4U",$alg);
    $alg = preg_replace("/<103>/","2-4R'",$alg); $alg = preg_replace("/<104>/","2-4R",$alg);
    $alg = preg_replace("/<105>/","2-4L'",$alg); $alg = preg_replace("/<106>/","2-4L",$alg);
    $alg = preg_replace("/<107>/","2-4B'",$alg); $alg = preg_replace("/<108>/","2-4B",$alg);
    
    /* --- 5xP: CODE -> TWIZZLE: [2] Numbered layer twists --- */
    /* N3-4 */
    $alg = preg_replace("/<201>/","3-4U'",$alg); $alg = preg_replace("/<202>/","3-4U",$alg);
    $alg = preg_replace("/<203>/","3-4R'",$alg); $alg = preg_replace("/<204>/","3-4R",$alg);
    $alg = preg_replace("/<205>/","3-4L'",$alg); $alg = preg_replace("/<206>/","3-4L",$alg);
    $alg = preg_replace("/<207>/","3-4B'",$alg); $alg = preg_replace("/<208>/","3-4B",$alg);
    
    /* V = N2-3 */
    $alg = preg_replace("/<209>/","2-3U'",$alg); $alg = preg_replace("/<210>/","2-3U",$alg);
    $alg = preg_replace("/<211>/","2-3R'",$alg); $alg = preg_replace("/<212>/","2-3R",$alg);
    $alg = preg_replace("/<213>/","2-3L'",$alg); $alg = preg_replace("/<214>/","2-3L",$alg);
    $alg = preg_replace("/<215>/","2-3B'",$alg); $alg = preg_replace("/<216>/","2-3B",$alg);
    
    /* N4 */
    $alg = preg_replace("/<217>/","4U'",$alg); $alg = preg_replace("/<218>/","4U",$alg);
    $alg = preg_replace("/<219>/","4R'",$alg); $alg = preg_replace("/<220>/","4R",$alg);
    $alg = preg_replace("/<221>/","4L'",$alg); $alg = preg_replace("/<222>/","4L",$alg);
    $alg = preg_replace("/<223>/","4B'",$alg); $alg = preg_replace("/<224>/","4B",$alg);
    
    /* N3 */
    $alg = preg_replace("/<225>/","3U'",$alg); $alg = preg_replace("/<226>/","3U",$alg);
    $alg = preg_replace("/<227>/","3R'",$alg); $alg = preg_replace("/<228>/","3R",$alg);
    $alg = preg_replace("/<229>/","3L'",$alg); $alg = preg_replace("/<230>/","3L",$alg);
    $alg = preg_replace("/<231>/","3B'",$alg); $alg = preg_replace("/<232>/","3B",$alg);
    
    /* N */
    $alg = preg_replace("/<233>/","2U'",$alg); $alg = preg_replace("/<234>/","2U",$alg);
    $alg = preg_replace("/<235>/","2R'",$alg); $alg = preg_replace("/<236>/","2R",$alg);
    $alg = preg_replace("/<237>/","2L'",$alg); $alg = preg_replace("/<238>/","2L",$alg);
    $alg = preg_replace("/<239>/","2B'",$alg); $alg = preg_replace("/<240>/","2B",$alg);
    
    /* --- 5xP: CODE -> TWIZZLE: [3] Tier twists --- */
    /* T4 */
    $alg = preg_replace("/<301>/","4u'",$alg); $alg = preg_replace("/<302>/","4u",$alg);
    $alg = preg_replace("/<303>/","4r'",$alg); $alg = preg_replace("/<304>/","4r",$alg);
    $alg = preg_replace("/<305>/","4l'",$alg); $alg = preg_replace("/<306>/","4l",$alg);
    $alg = preg_replace("/<307>/","4b'",$alg); $alg = preg_replace("/<308>/","4b",$alg);
    
    /* T3 */
    $alg = preg_replace("/<309>/","3u'",$alg); $alg = preg_replace("/<310>/","3u",$alg);
    $alg = preg_replace("/<311>/","3r'",$alg); $alg = preg_replace("/<312>/","3r",$alg);
    $alg = preg_replace("/<313>/","3l'",$alg); $alg = preg_replace("/<314>/","3l",$alg);
    $alg = preg_replace("/<315>/","3b'",$alg); $alg = preg_replace("/<316>/","3b",$alg);
    
    /* T */
    $alg = preg_replace("/<317>/","u'",$alg); $alg = preg_replace("/<318>/","u",$alg);
    $alg = preg_replace("/<319>/","r'",$alg); $alg = preg_replace("/<320>/","r",$alg);
    $alg = preg_replace("/<321>/","l'",$alg); $alg = preg_replace("/<322>/","l",$alg);
    $alg = preg_replace("/<323>/","b'",$alg); $alg = preg_replace("/<324>/","b",$alg);
    
    /* --- 5xP: CODE -> TWIZZLE: [7] Pyramid rotations --- */
    /* C */
    $alg = preg_replace("/<701>/","Uv'",$alg); $alg = preg_replace("/<702>/","Uv",$alg);
    $alg = preg_replace("/<703>/","Rv'",$alg); $alg = preg_replace("/<704>/","Rv",$alg);
    $alg = preg_replace("/<705>/","Lv'",$alg); $alg = preg_replace("/<706>/","Lv",$alg);
    $alg = preg_replace("/<707>/","Bv'",$alg); $alg = preg_replace("/<708>/","Bv",$alg);
    
    /* --- 5xP: CODE -> TWIZZLE: [9] Corner twists --- */
    /*   */
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
    
    /* --- 3xP: TWIZZLE -> CODE: [9] Corner twists --- */
    $alg = preg_replace("/1u'/","<901>",$alg); $alg = preg_replace("/1u/","<902>",$alg);
    $alg = preg_replace("/1r'/","<903>",$alg); $alg = preg_replace("/1r/","<904>",$alg);
    $alg = preg_replace("/1l'/","<905>",$alg); $alg = preg_replace("/1l/","<906>",$alg);
    $alg = preg_replace("/1b'/","<907>",$alg); $alg = preg_replace("/1b/","<908>",$alg);
    
    $alg = preg_replace("/1U'/","<901>",$alg); $alg = preg_replace("/1U/","<902>",$alg);
    $alg = preg_replace("/1R'/","<903>",$alg); $alg = preg_replace("/1R/","<904>",$alg);
    $alg = preg_replace("/1L'/","<905>",$alg); $alg = preg_replace("/1L/","<906>",$alg);
    $alg = preg_replace("/1B'/","<907>",$alg); $alg = preg_replace("/1B/","<908>",$alg);
    
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
    //<s> /* M = N = W */
    $alg = preg_replace("/MUR2'/","<101>",$alg); $alg = preg_replace("/MUR2-/","<101>",$alg);   $alg = preg_replace("/MUR'/","<102>",$alg); $alg = preg_replace("/MUR-/","<102>",$alg);   $alg = preg_replace("/MUR2/","<103>",$alg);   $alg = preg_replace("/MUR/","<104>",$alg);
    $alg = preg_replace("/MDL2'/","<103>",$alg); $alg = preg_replace("/MDL2-/","<103>",$alg);   $alg = preg_replace("/MDL'/","<104>",$alg); $alg = preg_replace("/MDL-/","<104>",$alg);   $alg = preg_replace("/MDL2/","<101>",$alg);   $alg = preg_replace("/MDL/","<102>",$alg);
    $alg = preg_replace("/MUL2'/","<105>",$alg); $alg = preg_replace("/MUL2-/","<105>",$alg);   $alg = preg_replace("/MUL'/","<106>",$alg); $alg = preg_replace("/MUL-/","<106>",$alg);   $alg = preg_replace("/MUL2/","<107>",$alg);   $alg = preg_replace("/MUL/","<108>",$alg);
    $alg = preg_replace("/MDR2'/","<107>",$alg); $alg = preg_replace("/MDR2-/","<107>",$alg);   $alg = preg_replace("/MDR'/","<108>",$alg); $alg = preg_replace("/MDR-/","<108>",$alg);   $alg = preg_replace("/MDR2/","<105>",$alg);   $alg = preg_replace("/MDR/","<106>",$alg);
    $alg = preg_replace("/MBL2'/","<111>",$alg); $alg = preg_replace("/MBL2-/","<111>",$alg);   $alg = preg_replace("/MBL'/","<112>",$alg); $alg = preg_replace("/MBL-/","<112>",$alg);   $alg = preg_replace("/MBL2/","<109>",$alg);   $alg = preg_replace("/MBL/","<110>",$alg);
    $alg = preg_replace("/MBR2'/","<115>",$alg); $alg = preg_replace("/MBR2-/","<115>",$alg);   $alg = preg_replace("/MBR'/","<116>",$alg); $alg = preg_replace("/MBR-/","<116>",$alg);   $alg = preg_replace("/MBR2/","<113>",$alg);   $alg = preg_replace("/MBR/","<114>",$alg);
    
    $alg = preg_replace("/MR2'/", "<109>",$alg); $alg = preg_replace("/MR2-/", "<109>",$alg);   $alg = preg_replace("/MR'/", "<110>",$alg); $alg = preg_replace("/MR-/", "<110>",$alg);   $alg = preg_replace("/MR2/", "<111>",$alg);   $alg = preg_replace("/MR/", "<112>",$alg);
    $alg = preg_replace("/ML2'/", "<113>",$alg); $alg = preg_replace("/ML2-/", "<113>",$alg);   $alg = preg_replace("/ML'/", "<114>",$alg); $alg = preg_replace("/ML-/", "<114>",$alg);   $alg = preg_replace("/ML2/", "<115>",$alg);   $alg = preg_replace("/ML/", "<116>",$alg);
    $alg = preg_replace("/MF2'/", "<117>",$alg); $alg = preg_replace("/MF2-/", "<117>",$alg);   $alg = preg_replace("/MF'/", "<118>",$alg); $alg = preg_replace("/MF-/", "<118>",$alg);   $alg = preg_replace("/MF2/", "<119>",$alg);   $alg = preg_replace("/MF/", "<120>",$alg);
    $alg = preg_replace("/MB2'/", "<119>",$alg); $alg = preg_replace("/MB2-/", "<119>",$alg);   $alg = preg_replace("/MB'/", "<120>",$alg); $alg = preg_replace("/MB-/", "<120>",$alg);   $alg = preg_replace("/MB2/", "<117>",$alg);   $alg = preg_replace("/MB/", "<118>",$alg);
    $alg = preg_replace("/MU2'/", "<121>",$alg); $alg = preg_replace("/MU2-/", "<121>",$alg);   $alg = preg_replace("/MU'/", "<122>",$alg); $alg = preg_replace("/MU-/", "<122>",$alg);   $alg = preg_replace("/MU2/", "<123>",$alg);   $alg = preg_replace("/MU/", "<124>",$alg);
    $alg = preg_replace("/MD2'/", "<123>",$alg); $alg = preg_replace("/MD2-/", "<123>",$alg);   $alg = preg_replace("/MD'/", "<124>",$alg); $alg = preg_replace("/MD-/", "<124>",$alg);   $alg = preg_replace("/MD2/", "<121>",$alg);   $alg = preg_replace("/MD/", "<122>",$alg);
    
    
    $alg = preg_replace("/NUR2'/","<101>",$alg); $alg = preg_replace("/NUR2-/","<101>",$alg);   $alg = preg_replace("/NUR'/","<102>",$alg); $alg = preg_replace("/NUR-/","<102>",$alg);   $alg = preg_replace("/NUR2/","<103>",$alg);   $alg = preg_replace("/NUR/","<104>",$alg);
    $alg = preg_replace("/NDL2'/","<103>",$alg); $alg = preg_replace("/NDL2-/","<103>",$alg);   $alg = preg_replace("/NDL'/","<104>",$alg); $alg = preg_replace("/NDL-/","<104>",$alg);   $alg = preg_replace("/NDL2/","<101>",$alg);   $alg = preg_replace("/NDL/","<102>",$alg);
    $alg = preg_replace("/NUL2'/","<105>",$alg); $alg = preg_replace("/NUL2-/","<105>",$alg);   $alg = preg_replace("/NUL'/","<106>",$alg); $alg = preg_replace("/NUL-/","<106>",$alg);   $alg = preg_replace("/NUL2/","<107>",$alg);   $alg = preg_replace("/NUL/","<108>",$alg);
    $alg = preg_replace("/NDR2'/","<107>",$alg); $alg = preg_replace("/NDR2-/","<107>",$alg);   $alg = preg_replace("/NDR'/","<108>",$alg); $alg = preg_replace("/NDR-/","<108>",$alg);   $alg = preg_replace("/NDR2/","<105>",$alg);   $alg = preg_replace("/NDR/","<106>",$alg);
    $alg = preg_replace("/NBL2'/","<111>",$alg); $alg = preg_replace("/NBL2-/","<111>",$alg);   $alg = preg_replace("/NBL'/","<112>",$alg); $alg = preg_replace("/NBL-/","<112>",$alg);   $alg = preg_replace("/NBL2/","<109>",$alg);   $alg = preg_replace("/NBL/","<110>",$alg);
    $alg = preg_replace("/NBR2'/","<115>",$alg); $alg = preg_replace("/NBR2-/","<115>",$alg);   $alg = preg_replace("/NBR'/","<116>",$alg); $alg = preg_replace("/NBR-/","<116>",$alg);   $alg = preg_replace("/NBR2/","<113>",$alg);   $alg = preg_replace("/NBR/","<114>",$alg);
    
    $alg = preg_replace("/NR2'/", "<109>",$alg); $alg = preg_replace("/NR2-/", "<109>",$alg);   $alg = preg_replace("/NR'/", "<110>",$alg); $alg = preg_replace("/NR-/", "<110>",$alg);   $alg = preg_replace("/NR2/", "<111>",$alg);   $alg = preg_replace("/NR/", "<112>",$alg);
    $alg = preg_replace("/NL2'/", "<113>",$alg); $alg = preg_replace("/NL2-/", "<113>",$alg);   $alg = preg_replace("/NL'/", "<114>",$alg); $alg = preg_replace("/NL-/", "<114>",$alg);   $alg = preg_replace("/NL2/", "<115>",$alg);   $alg = preg_replace("/NL/", "<116>",$alg);
    $alg = preg_replace("/NF2'/", "<117>",$alg); $alg = preg_replace("/NF2-/", "<117>",$alg);   $alg = preg_replace("/NF'/", "<118>",$alg); $alg = preg_replace("/NF-/", "<118>",$alg);   $alg = preg_replace("/NF2/", "<119>",$alg);   $alg = preg_replace("/NF/", "<120>",$alg);
    $alg = preg_replace("/NB2'/", "<119>",$alg); $alg = preg_replace("/NB2-/", "<119>",$alg);   $alg = preg_replace("/NB'/", "<120>",$alg); $alg = preg_replace("/NB-/", "<120>",$alg);   $alg = preg_replace("/NB2/", "<117>",$alg);   $alg = preg_replace("/NB/", "<118>",$alg);
    $alg = preg_replace("/NU2'/", "<121>",$alg); $alg = preg_replace("/NU2-/", "<121>",$alg);   $alg = preg_replace("/NU'/", "<122>",$alg); $alg = preg_replace("/NU-/", "<122>",$alg);   $alg = preg_replace("/NU2/", "<123>",$alg);   $alg = preg_replace("/NU/", "<124>",$alg);
    $alg = preg_replace("/ND2'/", "<123>",$alg); $alg = preg_replace("/ND2-/", "<123>",$alg);   $alg = preg_replace("/ND'/", "<124>",$alg); $alg = preg_replace("/ND-/", "<124>",$alg);   $alg = preg_replace("/ND2/", "<121>",$alg);   $alg = preg_replace("/ND/", "<122>",$alg);
    
    
    $alg = preg_replace("/WUR2'/","<101>",$alg); $alg = preg_replace("/WUR2-/","<101>",$alg);   $alg = preg_replace("/WUR'/","<102>",$alg); $alg = preg_replace("/WUR-/","<102>",$alg);   $alg = preg_replace("/WUR2/","<103>",$alg);   $alg = preg_replace("/WUR/","<104>",$alg);
    $alg = preg_replace("/WDL2'/","<103>",$alg); $alg = preg_replace("/WDL2-/","<103>",$alg);   $alg = preg_replace("/WDL'/","<104>",$alg); $alg = preg_replace("/WDL-/","<104>",$alg);   $alg = preg_replace("/WDL2/","<101>",$alg);   $alg = preg_replace("/WDL/","<102>",$alg);
    $alg = preg_replace("/WUL2'/","<105>",$alg); $alg = preg_replace("/WUL2-/","<105>",$alg);   $alg = preg_replace("/WUL'/","<106>",$alg); $alg = preg_replace("/WUL-/","<106>",$alg);   $alg = preg_replace("/WUL2/","<107>",$alg);   $alg = preg_replace("/WUL/","<108>",$alg);
    $alg = preg_replace("/WDR2'/","<107>",$alg); $alg = preg_replace("/WDR2-/","<107>",$alg);   $alg = preg_replace("/WDR'/","<108>",$alg); $alg = preg_replace("/WDR-/","<108>",$alg);   $alg = preg_replace("/WDR2/","<105>",$alg);   $alg = preg_replace("/WDR/","<106>",$alg);
    $alg = preg_replace("/WBL2'/","<111>",$alg); $alg = preg_replace("/WBL2-/","<111>",$alg);   $alg = preg_replace("/WBL'/","<112>",$alg); $alg = preg_replace("/WBL-/","<112>",$alg);   $alg = preg_replace("/WBL2/","<109>",$alg);   $alg = preg_replace("/WBL/","<110>",$alg);
    $alg = preg_replace("/WBR2'/","<115>",$alg); $alg = preg_replace("/WBR2-/","<115>",$alg);   $alg = preg_replace("/WBR'/","<116>",$alg); $alg = preg_replace("/WBR-/","<116>",$alg);   $alg = preg_replace("/WBR2/","<113>",$alg);   $alg = preg_replace("/WBR/","<114>",$alg);
    
    $alg = preg_replace("/WR2'/", "<109>",$alg); $alg = preg_replace("/WR2-/", "<109>",$alg);   $alg = preg_replace("/WR'/", "<110>",$alg); $alg = preg_replace("/WR-/", "<110>",$alg);   $alg = preg_replace("/WR2/", "<111>",$alg);   $alg = preg_replace("/WR/", "<112>",$alg);
    $alg = preg_replace("/WL2'/", "<113>",$alg); $alg = preg_replace("/WL2-/", "<113>",$alg);   $alg = preg_replace("/WL'/", "<114>",$alg); $alg = preg_replace("/WL-/", "<114>",$alg);   $alg = preg_replace("/WL2/", "<115>",$alg);   $alg = preg_replace("/WL/", "<116>",$alg);
    $alg = preg_replace("/WF2'/", "<117>",$alg); $alg = preg_replace("/WF2-/", "<117>",$alg);   $alg = preg_replace("/WF'/", "<118>",$alg); $alg = preg_replace("/WF-/", "<118>",$alg);   $alg = preg_replace("/WF2/", "<119>",$alg);   $alg = preg_replace("/WF/", "<120>",$alg);
    $alg = preg_replace("/WB2'/", "<119>",$alg); $alg = preg_replace("/WB2-/", "<119>",$alg);   $alg = preg_replace("/WB'/", "<120>",$alg); $alg = preg_replace("/WB-/", "<120>",$alg);   $alg = preg_replace("/WB2/", "<117>",$alg);   $alg = preg_replace("/WB/", "<118>",$alg);
    $alg = preg_replace("/WU2'/", "<121>",$alg); $alg = preg_replace("/WU2-/", "<121>",$alg);   $alg = preg_replace("/WU'/", "<122>",$alg); $alg = preg_replace("/WU-/", "<122>",$alg);   $alg = preg_replace("/WU2/", "<123>",$alg);   $alg = preg_replace("/WU/", "<124>",$alg);
    $alg = preg_replace("/WD2'/", "<123>",$alg); $alg = preg_replace("/WD2-/", "<123>",$alg);   $alg = preg_replace("/WD'/", "<124>",$alg); $alg = preg_replace("/WD-/", "<124>",$alg);   $alg = preg_replace("/WD2/", "<121>",$alg);   $alg = preg_replace("/WD/", "<122>",$alg);
    
    /* --- 3xD: SSE -> CODE: [2] Slice twists --- */
    //<s> /* S = S2-2 */
    $alg = preg_replace("/SUR2'/","<201>",$alg); $alg = preg_replace("/SUR2-/","<201>",$alg);   $alg = preg_replace("/SUR'/","<202>",$alg); $alg = preg_replace("/SUR-/","<202>",$alg);   $alg = preg_replace("/SUR2/","<203>",$alg);   $alg = preg_replace("/SUR/","<204>",$alg);
    $alg = preg_replace("/SDL2'/","<203>",$alg); $alg = preg_replace("/SDL2-/","<203>",$alg);   $alg = preg_replace("/SDL'/","<204>",$alg); $alg = preg_replace("/SDL-/","<204>",$alg);   $alg = preg_replace("/SDL2/","<201>",$alg);   $alg = preg_replace("/SDL/","<202>",$alg);
    $alg = preg_replace("/SUL2'/","<205>",$alg); $alg = preg_replace("/SUL2-/","<205>",$alg);   $alg = preg_replace("/SUL'/","<206>",$alg); $alg = preg_replace("/SUL-/","<206>",$alg);   $alg = preg_replace("/SUL2/","<207>",$alg);   $alg = preg_replace("/SUL/","<208>",$alg);
    $alg = preg_replace("/SDR2'/","<207>",$alg); $alg = preg_replace("/SDR2-/","<207>",$alg);   $alg = preg_replace("/SDR'/","<208>",$alg); $alg = preg_replace("/SDR-/","<208>",$alg);   $alg = preg_replace("/SDR2/","<205>",$alg);   $alg = preg_replace("/SDR/","<206>",$alg);
    $alg = preg_replace("/SBL2'/","<211>",$alg); $alg = preg_replace("/SBL2-/","<211>",$alg);   $alg = preg_replace("/SBL'/","<212>",$alg); $alg = preg_replace("/SBL-/","<212>",$alg);   $alg = preg_replace("/SBL2/","<209>",$alg);   $alg = preg_replace("/SBL/","<210>",$alg);
    $alg = preg_replace("/SBR2'/","<215>",$alg); $alg = preg_replace("/SBR2-/","<215>",$alg);   $alg = preg_replace("/SBR'/","<216>",$alg); $alg = preg_replace("/SBR-/","<216>",$alg);   $alg = preg_replace("/SBR2/","<213>",$alg);   $alg = preg_replace("/SBR/","<214>",$alg);
    
    $alg = preg_replace("/SR2'/", "<209>",$alg); $alg = preg_replace("/SR2-/", "<209>",$alg);   $alg = preg_replace("/SR'/", "<210>",$alg); $alg = preg_replace("/SR-/", "<210>",$alg);   $alg = preg_replace("/SR2/", "<211>",$alg);   $alg = preg_replace("/SR/", "<212>",$alg);
    $alg = preg_replace("/SL2'/", "<213>",$alg); $alg = preg_replace("/SL2-/", "<213>",$alg);   $alg = preg_replace("/SL'/", "<214>",$alg); $alg = preg_replace("/SL-/", "<214>",$alg);   $alg = preg_replace("/SL2/", "<215>",$alg);   $alg = preg_replace("/SL/", "<216>",$alg);
    $alg = preg_replace("/SF2'/", "<217>",$alg); $alg = preg_replace("/SF2-/", "<217>",$alg);   $alg = preg_replace("/SF'/", "<218>",$alg); $alg = preg_replace("/SF-/", "<218>",$alg);   $alg = preg_replace("/SF2/", "<219>",$alg);   $alg = preg_replace("/SF/", "<220>",$alg);
    $alg = preg_replace("/SB2'/", "<219>",$alg); $alg = preg_replace("/SB2-/", "<219>",$alg);   $alg = preg_replace("/SB'/", "<220>",$alg); $alg = preg_replace("/SB-/", "<220>",$alg);   $alg = preg_replace("/SB2/", "<217>",$alg);   $alg = preg_replace("/SB/", "<218>",$alg);
    $alg = preg_replace("/SU2'/", "<221>",$alg); $alg = preg_replace("/SU2-/", "<221>",$alg);   $alg = preg_replace("/SU'/", "<222>",$alg); $alg = preg_replace("/SU-/", "<222>",$alg);   $alg = preg_replace("/SU2/", "<223>",$alg);   $alg = preg_replace("/SU/", "<224>",$alg);
    $alg = preg_replace("/SD2'/", "<223>",$alg); $alg = preg_replace("/SD2-/", "<223>",$alg);   $alg = preg_replace("/SD'/", "<224>",$alg); $alg = preg_replace("/SD-/", "<224>",$alg);   $alg = preg_replace("/SD2/", "<221>",$alg);   $alg = preg_replace("/SD/", "<222>",$alg);
    
    
    $alg = preg_replace("/S2-2UR2'/","<201>",$alg); $alg = preg_replace("/S2-2UR2-/","<201>",$alg);   $alg = preg_replace("/S2-2UR'/","<202>",$alg); $alg = preg_replace("/S2-2UR-/","<202>",$alg);   $alg = preg_replace("/S2-2UR2/","<203>",$alg);   $alg = preg_replace("/S2-2UR/","<204>",$alg);
    $alg = preg_replace("/S2-2DL2'/","<203>",$alg); $alg = preg_replace("/S2-2DL2-/","<203>",$alg);   $alg = preg_replace("/S2-2DL'/","<204>",$alg); $alg = preg_replace("/S2-2DL-/","<204>",$alg);   $alg = preg_replace("/S2-2DL2/","<201>",$alg);   $alg = preg_replace("/S2-2DL/","<202>",$alg);
    $alg = preg_replace("/S2-2UL2'/","<205>",$alg); $alg = preg_replace("/S2-2UL2-/","<205>",$alg);   $alg = preg_replace("/S2-2UL'/","<206>",$alg); $alg = preg_replace("/S2-2UL-/","<206>",$alg);   $alg = preg_replace("/S2-2UL2/","<207>",$alg);   $alg = preg_replace("/S2-2UL/","<208>",$alg);
    $alg = preg_replace("/S2-2DR2'/","<207>",$alg); $alg = preg_replace("/S2-2DR2-/","<207>",$alg);   $alg = preg_replace("/S2-2DR'/","<208>",$alg); $alg = preg_replace("/S2-2DR-/","<208>",$alg);   $alg = preg_replace("/S2-2DR2/","<205>",$alg);   $alg = preg_replace("/S2-2DR/","<206>",$alg);
    $alg = preg_replace("/S2-2BL2'/","<211>",$alg); $alg = preg_replace("/S2-2BL2-/","<211>",$alg);   $alg = preg_replace("/S2-2BL'/","<212>",$alg); $alg = preg_replace("/S2-2BL-/","<212>",$alg);   $alg = preg_replace("/S2-2BL2/","<209>",$alg);   $alg = preg_replace("/S2-2BL/","<210>",$alg);
    $alg = preg_replace("/S2-2BR2'/","<215>",$alg); $alg = preg_replace("/S2-2BR2-/","<215>",$alg);   $alg = preg_replace("/S2-2BR'/","<216>",$alg); $alg = preg_replace("/S2-2BR-/","<216>",$alg);   $alg = preg_replace("/S2-2BR2/","<213>",$alg);   $alg = preg_replace("/S2-2BR/","<214>",$alg);
    
    $alg = preg_replace("/S2-2R2'/", "<209>",$alg); $alg = preg_replace("/S2-2R2-/", "<209>",$alg);   $alg = preg_replace("/S2-2R'/", "<210>",$alg); $alg = preg_replace("/S2-2R-/", "<210>",$alg);   $alg = preg_replace("/S2-2R2/", "<211>",$alg);   $alg = preg_replace("/S2-2R/", "<212>",$alg);
    $alg = preg_replace("/S2-2L2'/", "<213>",$alg); $alg = preg_replace("/S2-2L2-/", "<213>",$alg);   $alg = preg_replace("/S2-2L'/", "<214>",$alg); $alg = preg_replace("/S2-2L-/", "<214>",$alg);   $alg = preg_replace("/S2-2L2/", "<215>",$alg);   $alg = preg_replace("/S2-2L/", "<216>",$alg);
    $alg = preg_replace("/S2-2F2'/", "<217>",$alg); $alg = preg_replace("/S2-2F2-/", "<217>",$alg);   $alg = preg_replace("/S2-2F'/", "<218>",$alg); $alg = preg_replace("/S2-2F-/", "<218>",$alg);   $alg = preg_replace("/S2-2F2/", "<219>",$alg);   $alg = preg_replace("/S2-2F/", "<220>",$alg);
    $alg = preg_replace("/S2-2B2'/", "<219>",$alg); $alg = preg_replace("/S2-2B2-/", "<219>",$alg);   $alg = preg_replace("/S2-2B'/", "<220>",$alg); $alg = preg_replace("/S2-2B-/", "<220>",$alg);   $alg = preg_replace("/S2-2B2/", "<217>",$alg);   $alg = preg_replace("/S2-2B/", "<218>",$alg);
    $alg = preg_replace("/S2-2U2'/", "<221>",$alg); $alg = preg_replace("/S2-2U2-/", "<221>",$alg);   $alg = preg_replace("/S2-2U'/", "<222>",$alg); $alg = preg_replace("/S2-2U-/", "<222>",$alg);   $alg = preg_replace("/S2-2U2/", "<223>",$alg);   $alg = preg_replace("/S2-2U/", "<224>",$alg);
    $alg = preg_replace("/S2-2D2'/", "<223>",$alg); $alg = preg_replace("/S2-2D2-/", "<223>",$alg);   $alg = preg_replace("/S2-2D'/", "<224>",$alg); $alg = preg_replace("/S2-2D-/", "<224>",$alg);   $alg = preg_replace("/S2-2D2/", "<221>",$alg);   $alg = preg_replace("/S2-2D/", "<222>",$alg);
    
    /* --- 3xD: SSE -> CODE: [3] Tier twists --- */
    //<s> /* T */
    $alg = preg_replace("/TUR2'/","<301>",$alg); $alg = preg_replace("/TUR2-/","<301>",$alg);   $alg = preg_replace("/TUR'/","<302>",$alg); $alg = preg_replace("/TUR-/","<302>",$alg);   $alg = preg_replace("/TUR2/","<303>",$alg);   $alg = preg_replace("/TUR/","<304>",$alg);
    $alg = preg_replace("/TDL2'/","<305>",$alg); $alg = preg_replace("/TDL2-/","<305>",$alg);   $alg = preg_replace("/TDL'/","<306>",$alg); $alg = preg_replace("/TDL-/","<306>",$alg);   $alg = preg_replace("/TDL2/","<307>",$alg);   $alg = preg_replace("/TDL/","<308>",$alg);
    $alg = preg_replace("/TUL2'/","<309>",$alg); $alg = preg_replace("/TUL2-/","<309>",$alg);   $alg = preg_replace("/TUL'/","<310>",$alg); $alg = preg_replace("/TUL-/","<310>",$alg);   $alg = preg_replace("/TUL2/","<311>",$alg);   $alg = preg_replace("/TUL/","<312>",$alg);
    $alg = preg_replace("/TDR2'/","<313>",$alg); $alg = preg_replace("/TDR2-/","<313>",$alg);   $alg = preg_replace("/TDR'/","<314>",$alg); $alg = preg_replace("/TDR-/","<314>",$alg);   $alg = preg_replace("/TDR2/","<315>",$alg);   $alg = preg_replace("/TDR/","<316>",$alg);
    $alg = preg_replace("/TBL2'/","<321>",$alg); $alg = preg_replace("/TBL2-/","<321>",$alg);   $alg = preg_replace("/TBL'/","<322>",$alg); $alg = preg_replace("/TBL-/","<322>",$alg);   $alg = preg_replace("/TBL2/","<323>",$alg);   $alg = preg_replace("/TBL/","<324>",$alg);
    $alg = preg_replace("/TBR2'/","<329>",$alg); $alg = preg_replace("/TBR2-/","<329>",$alg);   $alg = preg_replace("/TBR'/","<330>",$alg); $alg = preg_replace("/TBR-/","<330>",$alg);   $alg = preg_replace("/TBR2/","<331>",$alg);   $alg = preg_replace("/TBR/","<332>",$alg);
    
    $alg = preg_replace("/TR2'/", "<317>",$alg); $alg = preg_replace("/TR2-/", "<317>",$alg);   $alg = preg_replace("/TR'/", "<318>",$alg); $alg = preg_replace("/TR-/", "<318>",$alg);   $alg = preg_replace("/TR2/", "<319>",$alg);   $alg = preg_replace("/TR/", "<320>",$alg);
    $alg = preg_replace("/TL2'/", "<325>",$alg); $alg = preg_replace("/TL2-/", "<325>",$alg);   $alg = preg_replace("/TL'/", "<326>",$alg); $alg = preg_replace("/TL-/", "<326>",$alg);   $alg = preg_replace("/TL2/", "<327>",$alg);   $alg = preg_replace("/TL/", "<328>",$alg);
    $alg = preg_replace("/TF2'/", "<333>",$alg); $alg = preg_replace("/TF2-/", "<333>",$alg);   $alg = preg_replace("/TF'/", "<334>",$alg); $alg = preg_replace("/TF-/", "<334>",$alg);   $alg = preg_replace("/TF2/", "<335>",$alg);   $alg = preg_replace("/TF/", "<336>",$alg);
    $alg = preg_replace("/TB2'/", "<337>",$alg); $alg = preg_replace("/TB2-/", "<337>",$alg);   $alg = preg_replace("/TB'/", "<338>",$alg); $alg = preg_replace("/TB-/", "<338>",$alg);   $alg = preg_replace("/TB2/", "<339>",$alg);   $alg = preg_replace("/TB/", "<340>",$alg);
    $alg = preg_replace("/TU2'/", "<341>",$alg); $alg = preg_replace("/TU2-/", "<341>",$alg);   $alg = preg_replace("/TU'/", "<342>",$alg); $alg = preg_replace("/TU-/", "<342>",$alg);   $alg = preg_replace("/TU2/", "<343>",$alg);   $alg = preg_replace("/TU/", "<344>",$alg);
    $alg = preg_replace("/TD2'/", "<345>",$alg); $alg = preg_replace("/TD2-/", "<345>",$alg);   $alg = preg_replace("/TD'/", "<346>",$alg); $alg = preg_replace("/TD-/", "<346>",$alg);   $alg = preg_replace("/TD2/", "<347>",$alg);   $alg = preg_replace("/TD/", "<348>",$alg);
    
    /* --- 3xD: SSE -> CODE: [7] Dodecahedron rotations --- */
    //<s> /* C */
    $alg = preg_replace("/CUR2'/","<701>",$alg); $alg = preg_replace("/CUR2-/","<701>",$alg);   $alg = preg_replace("/CUR'/","<702>",$alg); $alg = preg_replace("/CUR-/","<702>",$alg);   $alg = preg_replace("/CUR2/","<703>",$alg);   $alg = preg_replace("/CUR/","<704>",$alg);
    $alg = preg_replace("/CDL2'/","<703>",$alg); $alg = preg_replace("/CDL2-/","<703>",$alg);   $alg = preg_replace("/CDL'/","<704>",$alg); $alg = preg_replace("/CDL-/","<704>",$alg);   $alg = preg_replace("/CDL2/","<701>",$alg);   $alg = preg_replace("/CDL/","<702>",$alg);
    $alg = preg_replace("/CUL2'/","<705>",$alg); $alg = preg_replace("/CUL2-/","<705>",$alg);   $alg = preg_replace("/CUL'/","<706>",$alg); $alg = preg_replace("/CUL-/","<706>",$alg);   $alg = preg_replace("/CUL2/","<707>",$alg);   $alg = preg_replace("/CUL/","<708>",$alg);
    $alg = preg_replace("/CDR2'/","<707>",$alg); $alg = preg_replace("/CDR2-/","<707>",$alg);   $alg = preg_replace("/CDR'/","<708>",$alg); $alg = preg_replace("/CDR-/","<708>",$alg);   $alg = preg_replace("/CDR2/","<705>",$alg);   $alg = preg_replace("/CDR/","<706>",$alg);
    $alg = preg_replace("/CBL2'/","<711>",$alg); $alg = preg_replace("/CBL2-/","<711>",$alg);   $alg = preg_replace("/CBL'/","<712>",$alg); $alg = preg_replace("/CBL-/","<712>",$alg);   $alg = preg_replace("/CBL2/","<709>",$alg);   $alg = preg_replace("/CBL/","<710>",$alg);
    $alg = preg_replace("/CBR2'/","<715>",$alg); $alg = preg_replace("/CBR2-/","<715>",$alg);   $alg = preg_replace("/CBR'/","<716>",$alg); $alg = preg_replace("/CBR-/","<716>",$alg);   $alg = preg_replace("/CBR2/","<713>",$alg);   $alg = preg_replace("/CBR/","<714>",$alg);
    
    $alg = preg_replace("/CR2'/", "<709>",$alg); $alg = preg_replace("/CR2-/", "<709>",$alg);   $alg = preg_replace("/CR'/", "<710>",$alg); $alg = preg_replace("/CR-/", "<710>",$alg);   $alg = preg_replace("/CR2/", "<711>",$alg);   $alg = preg_replace("/CR/", "<712>",$alg);
    $alg = preg_replace("/CL2'/", "<713>",$alg); $alg = preg_replace("/CL2-/", "<713>",$alg);   $alg = preg_replace("/CL'/", "<714>",$alg); $alg = preg_replace("/CL-/", "<714>",$alg);   $alg = preg_replace("/CL2/", "<715>",$alg);   $alg = preg_replace("/CL/", "<716>",$alg);
    $alg = preg_replace("/CF2'/", "<717>",$alg); $alg = preg_replace("/CF2-/", "<717>",$alg);   $alg = preg_replace("/CF'/", "<718>",$alg); $alg = preg_replace("/CF-/", "<718>",$alg);   $alg = preg_replace("/CF2/", "<719>",$alg);   $alg = preg_replace("/CF/", "<720>",$alg);
    $alg = preg_replace("/CB2'/", "<719>",$alg); $alg = preg_replace("/CB2-/", "<719>",$alg);   $alg = preg_replace("/CB'/", "<720>",$alg); $alg = preg_replace("/CB-/", "<720>",$alg);   $alg = preg_replace("/CB2/", "<717>",$alg);   $alg = preg_replace("/CB/", "<718>",$alg);
    $alg = preg_replace("/CU2'/", "<721>",$alg); $alg = preg_replace("/CU2-/", "<721>",$alg);   $alg = preg_replace("/CU'/", "<722>",$alg); $alg = preg_replace("/CU-/", "<722>",$alg);   $alg = preg_replace("/CU2/", "<723>",$alg);   $alg = preg_replace("/CU/", "<724>",$alg);
    $alg = preg_replace("/CD2'/", "<723>",$alg); $alg = preg_replace("/CD2-/", "<723>",$alg);   $alg = preg_replace("/CD'/", "<724>",$alg); $alg = preg_replace("/CD-/", "<724>",$alg);   $alg = preg_replace("/CD2/", "<721>",$alg);   $alg = preg_replace("/CD/", "<722>",$alg);
    
    /* --- 3xD: SSE -> CODE: [9] Face twists --- */
    //<s> /*   */
    $alg = preg_replace("/UR2'/","<901>",$alg); $alg = preg_replace("/UR2-/","<901>",$alg);   $alg = preg_replace("/UR'/","<902>",$alg); $alg = preg_replace("/UR-/","<902>",$alg);   $alg = preg_replace("/UR2/","<903>",$alg);   $alg = preg_replace("/UR/","<904>",$alg);
    $alg = preg_replace("/DL2'/","<905>",$alg); $alg = preg_replace("/DL2-/","<905>",$alg);   $alg = preg_replace("/DL'/","<906>",$alg); $alg = preg_replace("/DL-/","<906>",$alg);   $alg = preg_replace("/DL2/","<907>",$alg);   $alg = preg_replace("/DL/","<908>",$alg);
    $alg = preg_replace("/UL2'/","<909>",$alg); $alg = preg_replace("/UL2-/","<909>",$alg);   $alg = preg_replace("/UL'/","<910>",$alg); $alg = preg_replace("/UL-/","<910>",$alg);   $alg = preg_replace("/UL2/","<911>",$alg);   $alg = preg_replace("/UL/","<912>",$alg);
    $alg = preg_replace("/DR2'/","<913>",$alg); $alg = preg_replace("/DR2-/","<913>",$alg);   $alg = preg_replace("/DR'/","<914>",$alg); $alg = preg_replace("/DR-/","<914>",$alg);   $alg = preg_replace("/DR2/","<915>",$alg);   $alg = preg_replace("/DR/","<916>",$alg);
    $alg = preg_replace("/BL2'/","<921>",$alg); $alg = preg_replace("/BL2-/","<921>",$alg);   $alg = preg_replace("/BL'/","<922>",$alg); $alg = preg_replace("/BL-/","<922>",$alg);   $alg = preg_replace("/BL2/","<923>",$alg);   $alg = preg_replace("/BL/","<924>",$alg);
    $alg = preg_replace("/BR2'/","<929>",$alg); $alg = preg_replace("/BR2-/","<929>",$alg);   $alg = preg_replace("/BR'/","<930>",$alg); $alg = preg_replace("/BR-/","<930>",$alg);   $alg = preg_replace("/BR2/","<931>",$alg);   $alg = preg_replace("/BR/","<932>",$alg);
    
    $alg = preg_replace("/R2'/", "<917>",$alg); $alg = preg_replace("/R2-/", "<917>",$alg);   $alg = preg_replace("/R'/", "<918>",$alg); $alg = preg_replace("/R-/", "<918>",$alg);   $alg = preg_replace("/R2/", "<919>",$alg);   $alg = preg_replace("/R/", "<920>",$alg);
    $alg = preg_replace("/L2'/", "<925>",$alg); $alg = preg_replace("/L2-/", "<925>",$alg);   $alg = preg_replace("/L'/", "<926>",$alg); $alg = preg_replace("/L-/", "<926>",$alg);   $alg = preg_replace("/L2/", "<927>",$alg);   $alg = preg_replace("/L/", "<928>",$alg);
    $alg = preg_replace("/F2'/", "<933>",$alg); $alg = preg_replace("/F2-/", "<933>",$alg);   $alg = preg_replace("/F'/", "<934>",$alg); $alg = preg_replace("/F-/", "<934>",$alg);   $alg = preg_replace("/F2/", "<935>",$alg);   $alg = preg_replace("/F/", "<936>",$alg);
    $alg = preg_replace("/B2'/", "<937>",$alg); $alg = preg_replace("/B2-/", "<937>",$alg);   $alg = preg_replace("/B'/", "<938>",$alg); $alg = preg_replace("/B-/", "<938>",$alg);   $alg = preg_replace("/B2/", "<939>",$alg);   $alg = preg_replace("/B/", "<940>",$alg);
    $alg = preg_replace("/U2'/", "<941>",$alg); $alg = preg_replace("/U2-/", "<941>",$alg);   $alg = preg_replace("/U'/", "<942>",$alg); $alg = preg_replace("/U-/", "<942>",$alg);   $alg = preg_replace("/U2/", "<943>",$alg);   $alg = preg_replace("/U/", "<944>",$alg);
    $alg = preg_replace("/D2'/", "<945>",$alg); $alg = preg_replace("/D2-/", "<945>",$alg);   $alg = preg_replace("/D'/", "<946>",$alg); $alg = preg_replace("/D-/", "<946>",$alg);   $alg = preg_replace("/D2/", "<947>",$alg);   $alg = preg_replace("/D/", "<948>",$alg);
    
    /* ··································································································· */
    /* --- 3xD: CODE -> TWIZZLE: [5] Mid-layer [1] (Numbered layer) [6] (Wide) twists --- */
    //<s> /* M = N = W */
    $alg = preg_replace("/<101>/","2BR2'",$alg);   $alg = preg_replace("/<102>/","2BR'",$alg);   $alg = preg_replace("/<103>/","2BR2",$alg);   $alg = preg_replace("/<104>/","2BR",$alg);
    $alg = preg_replace("/<105>/","2BL2'",$alg);   $alg = preg_replace("/<106>/","2BL'",$alg);   $alg = preg_replace("/<107>/","2BL2",$alg);   $alg = preg_replace("/<108>/","2BL",$alg);
    
    $alg = preg_replace("/<109>/","2R2'", $alg);   $alg = preg_replace("/<110>/","2R'", $alg);   $alg = preg_replace("/<111>/","2R2", $alg);   $alg = preg_replace("/<112>/","2R", $alg);
    $alg = preg_replace("/<113>/","2L2'", $alg);   $alg = preg_replace("/<114>/","2L'", $alg);   $alg = preg_replace("/<115>/","2L2", $alg);   $alg = preg_replace("/<116>/","2L", $alg);
    $alg = preg_replace("/<117>/","2F2'", $alg);   $alg = preg_replace("/<118>/","2F'", $alg);   $alg = preg_replace("/<119>/","2F2", $alg);   $alg = preg_replace("/<120>/","2F", $alg);
    $alg = preg_replace("/<121>/","2U2'", $alg);   $alg = preg_replace("/<122>/","2U'", $alg);   $alg = preg_replace("/<123>/","2U2", $alg);   $alg = preg_replace("/<124>/","2U", $alg);
    
    /* --- 3xD: CODE -> TWIZZLE: [2] Slice twists --- */
    //<s> /* S = S2-2 */
    $alg = preg_replace("/<201>/","BR2' FL2",$alg);   $alg = preg_replace("/<202>/","BR' FL",$alg);   $alg = preg_replace("/<203>/","BR2 FL2'",$alg);   $alg = preg_replace("/<204>/","BR FL'",$alg);
    $alg = preg_replace("/<205>/","BL2' FR2",$alg);   $alg = preg_replace("/<206>/","BL' FR",$alg);   $alg = preg_replace("/<207>/","BL2 FR2'",$alg);   $alg = preg_replace("/<208>/","BL FR'",$alg);
    
    $alg = preg_replace("/<209>/","R2' DL2", $alg);   $alg = preg_replace("/<210>/","R' DL", $alg);   $alg = preg_replace("/<211>/","R2 DL2'", $alg);   $alg = preg_replace("/<212>/","R DL'", $alg);
    $alg = preg_replace("/<213>/","L2' DR2", $alg);   $alg = preg_replace("/<214>/","L' DR", $alg);   $alg = preg_replace("/<215>/","L2 DR2'", $alg);   $alg = preg_replace("/<216>/","L DR'", $alg);
    $alg = preg_replace("/<217>/","F2' B2",  $alg);   $alg = preg_replace("/<218>/","F' B",  $alg);   $alg = preg_replace("/<219>/","F2 B2'",  $alg);   $alg = preg_replace("/<220>/","F B'",  $alg);
    $alg = preg_replace("/<221>/","U2' D2",  $alg);   $alg = preg_replace("/<222>/","U' D",  $alg);   $alg = preg_replace("/<223>/","U2 D2'",  $alg);   $alg = preg_replace("/<224>/","U D'",  $alg);
    
    /* --- 3xD: CODE -> TWIZZLE: [3] Tier twists --- */
    //<s> /* T */
    $alg = preg_replace("/<301>/","br2'",$alg);   $alg = preg_replace("/<302>/","br'",$alg);   $alg = preg_replace("/<303>/","br2",$alg);   $alg = preg_replace("/<304>/","br",$alg);
    $alg = preg_replace("/<305>/","fl2'",$alg);   $alg = preg_replace("/<306>/","fl'",$alg);   $alg = preg_replace("/<307>/","fl2",$alg);   $alg = preg_replace("/<308>/","fl",$alg);
    $alg = preg_replace("/<309>/","bl2'",$alg);   $alg = preg_replace("/<310>/","bl'",$alg);   $alg = preg_replace("/<311>/","bl2",$alg);   $alg = preg_replace("/<312>/","bl",$alg);
    $alg = preg_replace("/<313>/","fr2'",$alg);   $alg = preg_replace("/<314>/","fr'",$alg);   $alg = preg_replace("/<315>/","fr2",$alg);   $alg = preg_replace("/<316>/","fr",$alg);
    $alg = preg_replace("/<321>/","dl2'",$alg);   $alg = preg_replace("/<322>/","dl'",$alg);   $alg = preg_replace("/<323>/","dl2",$alg);   $alg = preg_replace("/<324>/","dl",$alg);
    $alg = preg_replace("/<329>/","dr2'",$alg);   $alg = preg_replace("/<330>/","dr'",$alg);   $alg = preg_replace("/<331>/","dr2",$alg);   $alg = preg_replace("/<332>/","dr",$alg);
    
    $alg = preg_replace("/<317>/","r2'", $alg);   $alg = preg_replace("/<318>/","r'", $alg);   $alg = preg_replace("/<319>/","r2", $alg);   $alg = preg_replace("/<320>/","r", $alg);
    $alg = preg_replace("/<325>/","l2'", $alg);   $alg = preg_replace("/<326>/","l'", $alg);   $alg = preg_replace("/<327>/","l2", $alg);   $alg = preg_replace("/<328>/","l", $alg);
    $alg = preg_replace("/<333>/","f2'", $alg);   $alg = preg_replace("/<334>/","f'", $alg);   $alg = preg_replace("/<335>/","f2", $alg);   $alg = preg_replace("/<336>/","f", $alg);
    $alg = preg_replace("/<337>/","b2'", $alg);   $alg = preg_replace("/<338>/","b'", $alg);   $alg = preg_replace("/<339>/","b2", $alg);   $alg = preg_replace("/<340>/","b", $alg);
    $alg = preg_replace("/<341>/","u2'", $alg);   $alg = preg_replace("/<342>/","u'", $alg);   $alg = preg_replace("/<343>/","u2", $alg);   $alg = preg_replace("/<344>/","u", $alg);
    $alg = preg_replace("/<345>/","d2'", $alg);   $alg = preg_replace("/<346>/","d'", $alg);   $alg = preg_replace("/<347>/","d2", $alg);   $alg = preg_replace("/<348>/","d", $alg);
    
    /* --- 3xD: CODE -> TWIZZLE: [7] Dodecahedron rotations --- */
    //<s> /* C */
    $alg = preg_replace("/<701>/","BRv2'",$alg);   $alg = preg_replace("/<702>/","BRv'",$alg);   $alg = preg_replace("/<703>/","BRv2",$alg);   $alg = preg_replace("/<704>/","BRv",$alg);
    $alg = preg_replace("/<705>/","BLv2'",$alg);   $alg = preg_replace("/<706>/","BLv'",$alg);   $alg = preg_replace("/<707>/","BLv2",$alg);   $alg = preg_replace("/<708>/","BLv",$alg);
    
    $alg = preg_replace("/<709>/","Rv2'", $alg);   $alg = preg_replace("/<710>/","Rv'", $alg);   $alg = preg_replace("/<711>/","Rv2", $alg);   $alg = preg_replace("/<712>/","Rv", $alg);
    $alg = preg_replace("/<713>/","Lv2'", $alg);   $alg = preg_replace("/<714>/","Lv'", $alg);   $alg = preg_replace("/<715>/","Lv2", $alg);   $alg = preg_replace("/<716>/","Lv", $alg);
    $alg = preg_replace("/<717>/","Fv2'", $alg);   $alg = preg_replace("/<718>/","Fv'", $alg);   $alg = preg_replace("/<719>/","Fv2", $alg);   $alg = preg_replace("/<720>/","Fv", $alg);
    $alg = preg_replace("/<721>/","Uv2'", $alg);   $alg = preg_replace("/<722>/","Uv'", $alg);   $alg = preg_replace("/<723>/","Uv2", $alg);   $alg = preg_replace("/<724>/","Uv", $alg);
    
    /* --- 3xD: CODE -> TWIZZLE: [9] Face twists --- */
    //<s> /*   */
    $alg = preg_replace("/<901>/","BR2'",$alg);   $alg = preg_replace("/<902>/","BR'",$alg);   $alg = preg_replace("/<903>/","BR2",$alg);   $alg = preg_replace("/<904>/","BR",$alg);
    $alg = preg_replace("/<905>/","FL2'",$alg);   $alg = preg_replace("/<906>/","FL'",$alg);   $alg = preg_replace("/<907>/","FL2",$alg);   $alg = preg_replace("/<908>/","FL",$alg);
    $alg = preg_replace("/<909>/","BL2'",$alg);   $alg = preg_replace("/<910>/","BL'",$alg);   $alg = preg_replace("/<911>/","BL2",$alg);   $alg = preg_replace("/<912>/","BL",$alg);
    $alg = preg_replace("/<913>/","FR2'",$alg);   $alg = preg_replace("/<914>/","FR'",$alg);   $alg = preg_replace("/<915>/","FR2",$alg);   $alg = preg_replace("/<916>/","FR",$alg);
    $alg = preg_replace("/<921>/","DL2'",$alg);   $alg = preg_replace("/<922>/","DL'",$alg);   $alg = preg_replace("/<923>/","DL2",$alg);   $alg = preg_replace("/<924>/","DL",$alg);
    $alg = preg_replace("/<929>/","DR2'",$alg);   $alg = preg_replace("/<930>/","DR'",$alg);   $alg = preg_replace("/<931>/","DR2",$alg);   $alg = preg_replace("/<932>/","DR",$alg);
    
    $alg = preg_replace("/<917>/","R2'", $alg);   $alg = preg_replace("/<918>/","R'", $alg);   $alg = preg_replace("/<919>/","R2", $alg);   $alg = preg_replace("/<920>/","R", $alg);
    $alg = preg_replace("/<925>/","L2'", $alg);   $alg = preg_replace("/<926>/","L'", $alg);   $alg = preg_replace("/<927>/","L2", $alg);   $alg = preg_replace("/<928>/","L", $alg);
    $alg = preg_replace("/<933>/","F2'", $alg);   $alg = preg_replace("/<934>/","F'", $alg);   $alg = preg_replace("/<935>/","F2", $alg);   $alg = preg_replace("/<936>/","F", $alg);
    $alg = preg_replace("/<937>/","B2'", $alg);   $alg = preg_replace("/<938>/","B'", $alg);   $alg = preg_replace("/<939>/","B2", $alg);   $alg = preg_replace("/<940>/","B", $alg);
    $alg = preg_replace("/<941>/","U2'", $alg);   $alg = preg_replace("/<942>/","U'", $alg);   $alg = preg_replace("/<943>/","U2", $alg);   $alg = preg_replace("/<944>/","U", $alg);
    $alg = preg_replace("/<945>/","D2'", $alg);   $alg = preg_replace("/<946>/","D'", $alg);   $alg = preg_replace("/<947>/","D2", $alg);   $alg = preg_replace("/<948>/","D", $alg);
    
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
    
    /* --- 3xD: Preferences --- */
    $optSSE = true;  // Optimize SSE (rebuilds Slice twists in SSE).
    
    /* --- 3xD: Marker --- */
    $alg = str_replace(".","·",$alg);
    
    /* ··································································································· */
    /* --- 3xD: OLD TWIZZLE -> CODE: [3] Tier twists (TWIZZLE) --- */
    //<s> /* T */
    $alg = preg_replace("/1-2BF2'/","<337>",$alg);   $alg = preg_replace("/1-2BF'/","<338>",$alg);   $alg = preg_replace("/1-2BF2/","<339>",$alg);   $alg = preg_replace("/1-2BF/","<340>",$alg); // BF -> B.
    
    $alg = preg_replace("/1-2A2'/", "<305>",$alg);   $alg = preg_replace("/1-2A'/", "<306>",$alg);   $alg = preg_replace("/1-2A2/", "<307>",$alg);   $alg = preg_replace("/1-2A/", "<308>",$alg); // A  -> FL.
    $alg = preg_replace("/1-2C2'/", "<313>",$alg);   $alg = preg_replace("/1-2C'/", "<314>",$alg);   $alg = preg_replace("/1-2C2/", "<315>",$alg);   $alg = preg_replace("/1-2C/", "<316>",$alg); // C  -> FR.
    $alg = preg_replace("/1-2I2'/", "<321>",$alg);   $alg = preg_replace("/1-2I'/", "<322>",$alg);   $alg = preg_replace("/1-2I2/", "<323>",$alg);   $alg = preg_replace("/1-2I/", "<324>",$alg); // I  -> DL.
    $alg = preg_replace("/1-2E2'/", "<329>",$alg);   $alg = preg_replace("/1-2E'/", "<330>",$alg);   $alg = preg_replace("/1-2E2/", "<331>",$alg);   $alg = preg_replace("/1-2E/", "<332>",$alg); // E  -> DR.
    
    /* --- 3xD: TWIZZLE -> CODE: [3] Tier twists (TWIZZLE) --- */
    //<s> /* T */
    $alg = preg_replace("/1-2BR2'/","<301>",$alg);   $alg = preg_replace("/1-2BR'/","<302>",$alg);   $alg = preg_replace("/1-2BR2/","<303>",$alg);   $alg = preg_replace("/1-2BR/","<304>",$alg);
    $alg = preg_replace("/1-2FL2'/","<305>",$alg);   $alg = preg_replace("/1-2FL'/","<306>",$alg);   $alg = preg_replace("/1-2FL2/","<307>",$alg);   $alg = preg_replace("/1-2FL/","<308>",$alg);
    $alg = preg_replace("/1-2BL2'/","<309>",$alg);   $alg = preg_replace("/1-2BL'/","<310>",$alg);   $alg = preg_replace("/1-2BL2/","<311>",$alg);   $alg = preg_replace("/1-2BL/","<312>",$alg);
    $alg = preg_replace("/1-2FR2'/","<313>",$alg);   $alg = preg_replace("/1-2FR'/","<314>",$alg);   $alg = preg_replace("/1-2FR2/","<315>",$alg);   $alg = preg_replace("/1-2FR/","<316>",$alg);
    $alg = preg_replace("/1-2DL2'/","<321>",$alg);   $alg = preg_replace("/1-2DL'/","<322>",$alg);   $alg = preg_replace("/1-2DL2/","<323>",$alg);   $alg = preg_replace("/1-2DL/","<324>",$alg);
    $alg = preg_replace("/1-2DR2'/","<329>",$alg);   $alg = preg_replace("/1-2DR'/","<330>",$alg);   $alg = preg_replace("/1-2DR2/","<331>",$alg);   $alg = preg_replace("/1-2DR/","<332>",$alg);
    
    $alg = preg_replace("/1-2R2'/", "<317>",$alg);   $alg = preg_replace("/1-2R'/", "<318>",$alg);   $alg = preg_replace("/1-2R2/", "<319>",$alg);   $alg = preg_replace("/1-2R/", "<320>",$alg);
    $alg = preg_replace("/1-2L2'/", "<325>",$alg);   $alg = preg_replace("/1-2L'/", "<326>",$alg);   $alg = preg_replace("/1-2L2/", "<327>",$alg);   $alg = preg_replace("/1-2L/", "<328>",$alg);
    $alg = preg_replace("/1-2F2'/", "<333>",$alg);   $alg = preg_replace("/1-2F'/", "<334>",$alg);   $alg = preg_replace("/1-2F2/", "<335>",$alg);   $alg = preg_replace("/1-2F/", "<336>",$alg);
    $alg = preg_replace("/1-2B2'/", "<337>",$alg);   $alg = preg_replace("/1-2B'/", "<338>",$alg);   $alg = preg_replace("/1-2B2/", "<339>",$alg);   $alg = preg_replace("/1-2B/", "<340>",$alg);
    $alg = preg_replace("/1-2U2'/", "<341>",$alg);   $alg = preg_replace("/1-2U'/", "<342>",$alg);   $alg = preg_replace("/1-2U2/", "<343>",$alg);   $alg = preg_replace("/1-2U/", "<344>",$alg);
    $alg = preg_replace("/1-2D2'/", "<345>",$alg);   $alg = preg_replace("/1-2D'/", "<346>",$alg);   $alg = preg_replace("/1-2D2/", "<347>",$alg);   $alg = preg_replace("/1-2D/", "<348>",$alg);
    
    /* --- 3xD: TWIZZLE -> CODE: [2] Slice twists --- */
    if ($optSSE == true) {
      //<s> /* S = S2-2 */
      $alg = preg_replace("/2FL2' BRv2'/","<201>",$alg);   $alg = preg_replace("/2FL' BRv'/","<202>",$alg);   $alg = preg_replace("/2FL2 BRv2/","<203>",$alg);   $alg = preg_replace("/2FL BRv/","<204>",$alg);
      $alg = preg_replace("/2BR2' FLv2'/","<203>",$alg);   $alg = preg_replace("/2BR' FLv'/","<204>",$alg);   $alg = preg_replace("/2BR2 FLv2/","<201>",$alg);   $alg = preg_replace("/2BR FLv/","<202>",$alg);
      $alg = preg_replace("/2FR2' BLv2'/","<205>",$alg);   $alg = preg_replace("/2FR' BLv'/","<206>",$alg);   $alg = preg_replace("/2FR2 BLv2/","<207>",$alg);   $alg = preg_replace("/2FR BLv/","<208>",$alg);
      $alg = preg_replace("/2BL2' FRv2'/","<207>",$alg);   $alg = preg_replace("/2BL' FRv'/","<208>",$alg);   $alg = preg_replace("/2BL2 FRv2/","<205>",$alg);   $alg = preg_replace("/2BL FRv/","<206>",$alg);
      $alg = preg_replace("/2R2' DLv2'/", "<211>",$alg);   $alg = preg_replace("/2R' DLv'/", "<212>",$alg);   $alg = preg_replace("/2R2 DLv2/", "<209>",$alg);   $alg = preg_replace("/2R DLv/", "<210>",$alg);
      $alg = preg_replace("/2L2' DRv2'/", "<215>",$alg);   $alg = preg_replace("/2L' DRv'/", "<216>",$alg);   $alg = preg_replace("/2L2 DRv2/", "<213>",$alg);   $alg = preg_replace("/2L DRv/", "<214>",$alg);
      
      $alg = preg_replace("/2DL2' Rv2'/", "<209>",$alg);   $alg = preg_replace("/2DL' Rv'/", "<210>",$alg);   $alg = preg_replace("/2DL2 Rv2/", "<211>",$alg);   $alg = preg_replace("/2DL Rv/", "<212>",$alg);
      $alg = preg_replace("/2DR2' Lv2'/", "<213>",$alg);   $alg = preg_replace("/2DR' Lv'/", "<214>",$alg);   $alg = preg_replace("/2DR2 Lv2/", "<215>",$alg);   $alg = preg_replace("/2DR Lv/", "<216>",$alg);
      $alg = preg_replace("/2B2' Fv2'/",  "<217>",$alg);   $alg = preg_replace("/2B' Fv'/",  "<218>",$alg);   $alg = preg_replace("/2B2 Fv2/",  "<219>",$alg);   $alg = preg_replace("/2B Fv/",  "<220>",$alg);
      $alg = preg_replace("/2F2' Bv2'/",  "<219>",$alg);   $alg = preg_replace("/2F' Bv'/",  "<220>",$alg);   $alg = preg_replace("/2F2 Bv2/",  "<217>",$alg);   $alg = preg_replace("/2F Bv/",  "<218>",$alg);
      $alg = preg_replace("/2D2' Uv2'/",  "<221>",$alg);   $alg = preg_replace("/2D' Uv'/",  "<222>",$alg);   $alg = preg_replace("/2D2 Uv2/",  "<223>",$alg);   $alg = preg_replace("/2D Uv/",  "<224>",$alg);
      $alg = preg_replace("/2U2' Dv2'/",  "<223>",$alg);   $alg = preg_replace("/2U' Dv'/",  "<224>",$alg);   $alg = preg_replace("/2U2 Dv2/",  "<221>",$alg);   $alg = preg_replace("/2U Dv/",  "<222>",$alg);
      
      
      $alg = preg_replace("/2BR2 BRv2'/","<201>",$alg);   $alg = preg_replace("/2BR BRv'/","<202>",$alg);   $alg = preg_replace("/2BR2' BRv2/","<203>",$alg);   $alg = preg_replace("/2BR' BRv/","<204>",$alg);
      $alg = preg_replace("/2FL2 FLv2'/","<203>",$alg);   $alg = preg_replace("/2FL FLv'/","<204>",$alg);   $alg = preg_replace("/2FL2' FLv2/","<201>",$alg);   $alg = preg_replace("/2FL' FLv/","<202>",$alg);
      $alg = preg_replace("/2BL2 BLv2'/","<205>",$alg);   $alg = preg_replace("/2BL BLv'/","<206>",$alg);   $alg = preg_replace("/2BL2' BLv2/","<207>",$alg);   $alg = preg_replace("/2BL' BLv/","<208>",$alg);
      $alg = preg_replace("/2FR2 FRv2'/","<207>",$alg);   $alg = preg_replace("/2FR FRv'/","<208>",$alg);   $alg = preg_replace("/2FR2' FRv2/","<205>",$alg);   $alg = preg_replace("/2FR' FRv/","<206>",$alg);
      $alg = preg_replace("/2DL2 DLv2'/","<211>",$alg);   $alg = preg_replace("/2DL DLv'/","<212>",$alg);   $alg = preg_replace("/2DL2' DLv2/","<209>",$alg);   $alg = preg_replace("/2DL' DLv/","<210>",$alg);
      $alg = preg_replace("/2DR2 DRv2'/","<215>",$alg);   $alg = preg_replace("/2DR DRv'/","<216>",$alg);   $alg = preg_replace("/2DR2' DRv2/","<213>",$alg);   $alg = preg_replace("/2DR' DRv/","<214>",$alg);
      
      $alg = preg_replace("/2R2 Rv2'/",  "<209>",$alg);   $alg = preg_replace("/2R Rv'/",  "<210>",$alg);   $alg = preg_replace("/2R2' Rv2/",  "<211>",$alg);   $alg = preg_replace("/2R' Rv/",  "<212>",$alg);
      $alg = preg_replace("/2L2 Lv2'/",  "<213>",$alg);   $alg = preg_replace("/2L Lv'/",  "<214>",$alg);   $alg = preg_replace("/2L2' Lv2/",  "<215>",$alg);   $alg = preg_replace("/2L' Lv/",  "<216>",$alg);
      $alg = preg_replace("/2F2 Fv2'/",  "<217>",$alg);   $alg = preg_replace("/2F Fv'/",  "<218>",$alg);   $alg = preg_replace("/2F2' Fv2/",  "<219>",$alg);   $alg = preg_replace("/2F' Fv/",  "<220>",$alg);
      $alg = preg_replace("/2B2 Bv2'/",  "<219>",$alg);   $alg = preg_replace("/2B Bv'/",  "<220>",$alg);   $alg = preg_replace("/2B2' Bv2/",  "<217>",$alg);   $alg = preg_replace("/2B' Bv/",  "<218>",$alg);
      $alg = preg_replace("/2U2 Uv2'/",  "<221>",$alg);   $alg = preg_replace("/2U Uv'/",  "<222>",$alg);   $alg = preg_replace("/2U2' Uv2/",  "<223>",$alg);   $alg = preg_replace("/2U' Uv/",  "<224>",$alg);
      $alg = preg_replace("/2D2 Dv2'/",  "<223>",$alg);   $alg = preg_replace("/2D Dv'/",  "<224>",$alg);   $alg = preg_replace("/2D2' Dv2/",  "<221>",$alg);   $alg = preg_replace("/2D' Dv/",  "<222>",$alg);
    }
    
    /* --- 3xD: OLD TWIZZLE -> CODE: [5] Mid-layer [1] (Numbered layer) [6] (Wide) twists --- */
    //<s> /* M */
    $alg = preg_replace("/2BF2'/","<119>",$alg);   $alg = preg_replace("/2BF'/","<120>",$alg);   $alg = preg_replace("/2BF2/","<117>",$alg);   $alg = preg_replace("/2BF/","<118>",$alg); // BF -> B.
    
    $alg = preg_replace("/2A2'/", "<103>",$alg);   $alg = preg_replace("/2A'/", "<104>",$alg);   $alg = preg_replace("/2A2/", "<101>",$alg);   $alg = preg_replace("/2A/", "<102>",$alg); // A  -> FL.
    $alg = preg_replace("/2C2'/", "<107>",$alg);   $alg = preg_replace("/2C'/", "<108>",$alg);   $alg = preg_replace("/2C2/", "<105>",$alg);   $alg = preg_replace("/2C/", "<106>",$alg); // C  -> FR.
    $alg = preg_replace("/2I2'/", "<111>",$alg);   $alg = preg_replace("/2I'/", "<112>",$alg);   $alg = preg_replace("/2I2/", "<109>",$alg);   $alg = preg_replace("/2I/", "<110>",$alg); // I  -> DL.
    $alg = preg_replace("/2E2'/", "<115>",$alg);   $alg = preg_replace("/2E'/", "<116>",$alg);   $alg = preg_replace("/2E2/", "<113>",$alg);   $alg = preg_replace("/2E/", "<114>",$alg); // E  -> DR.
    
    /* --- 3xD: TWIZZLE -> CODE: [5] Mid-layer [1] (Numbered layer) [6] (Wide) twists --- */
    //<s> /* M */
    $alg = preg_replace("/2BR2'/","<101>",$alg);   $alg = preg_replace("/2BR'/","<102>",$alg);   $alg = preg_replace("/2BR2/","<103>",$alg);   $alg = preg_replace("/2BR/","<104>",$alg);
    $alg = preg_replace("/2FL2'/","<103>",$alg);   $alg = preg_replace("/2FL'/","<104>",$alg);   $alg = preg_replace("/2FL2/","<101>",$alg);   $alg = preg_replace("/2FL/","<102>",$alg);
    $alg = preg_replace("/2BL2'/","<105>",$alg);   $alg = preg_replace("/2BL'/","<106>",$alg);   $alg = preg_replace("/2BL2/","<107>",$alg);   $alg = preg_replace("/2BL/","<108>",$alg);
    $alg = preg_replace("/2FR2'/","<107>",$alg);   $alg = preg_replace("/2FR'/","<108>",$alg);   $alg = preg_replace("/2FR2/","<105>",$alg);   $alg = preg_replace("/2FR/","<106>",$alg);
    $alg = preg_replace("/2DL2'/","<111>",$alg);   $alg = preg_replace("/2DL'/","<112>",$alg);   $alg = preg_replace("/2DL2/","<109>",$alg);   $alg = preg_replace("/2DL/","<110>",$alg);
    $alg = preg_replace("/2DR2'/","<115>",$alg);   $alg = preg_replace("/2DR'/","<116>",$alg);   $alg = preg_replace("/2DR2/","<113>",$alg);   $alg = preg_replace("/2DR/","<114>",$alg);
    
    $alg = preg_replace("/2R2'/", "<109>",$alg);   $alg = preg_replace("/2R'/", "<110>",$alg);   $alg = preg_replace("/2R2/", "<111>",$alg);   $alg = preg_replace("/2R/", "<112>",$alg);
    $alg = preg_replace("/2L2'/", "<113>",$alg);   $alg = preg_replace("/2L'/", "<114>",$alg);   $alg = preg_replace("/2L2/", "<115>",$alg);   $alg = preg_replace("/2L/", "<116>",$alg);
    $alg = preg_replace("/2F2'/", "<117>",$alg);   $alg = preg_replace("/2F'/", "<118>",$alg);   $alg = preg_replace("/2F2/", "<119>",$alg);   $alg = preg_replace("/2F/", "<120>",$alg);
    $alg = preg_replace("/2B2'/", "<119>",$alg);   $alg = preg_replace("/2B'/", "<120>",$alg);   $alg = preg_replace("/2B2/", "<117>",$alg);   $alg = preg_replace("/2B/", "<118>",$alg);
    $alg = preg_replace("/2U2'/", "<121>",$alg);   $alg = preg_replace("/2U'/", "<122>",$alg);   $alg = preg_replace("/2U2/", "<123>",$alg);   $alg = preg_replace("/2U/", "<124>",$alg);
    $alg = preg_replace("/2D2'/", "<123>",$alg);   $alg = preg_replace("/2D'/", "<124>",$alg);   $alg = preg_replace("/2D2/", "<121>",$alg);   $alg = preg_replace("/2D/", "<122>",$alg);
    
    /* --- 3xD: OLD TWIZZLE -> CODE: [9] Face twists --- */
    //<s> /*   */
    $alg = preg_replace("/1BF2'/","<937>",$alg);   $alg = preg_replace("/1BF'/","<938>",$alg);   $alg = preg_replace("/1BF2/","<939>",$alg);   $alg = preg_replace("/1BF/","<940>",$alg); // BF -> B.
    
    $alg = preg_replace("/1A2'/", "<905>",$alg);   $alg = preg_replace("/1A'/", "<906>",$alg);   $alg = preg_replace("/1A2/", "<907>",$alg);   $alg = preg_replace("/1A/", "<908>",$alg); // A  -> FL.
    $alg = preg_replace("/1C2'/", "<913>",$alg);   $alg = preg_replace("/1C'/", "<914>",$alg);   $alg = preg_replace("/1C2/", "<915>",$alg);   $alg = preg_replace("/1C/", "<916>",$alg); // C  -> FR.
    $alg = preg_replace("/1I2'/", "<921>",$alg);   $alg = preg_replace("/1I'/", "<922>",$alg);   $alg = preg_replace("/1I2/", "<923>",$alg);   $alg = preg_replace("/1I/", "<924>",$alg); // I  -> DL.
    $alg = preg_replace("/1E2'/", "<929>",$alg);   $alg = preg_replace("/1E'/", "<930>",$alg);   $alg = preg_replace("/1E2/", "<931>",$alg);   $alg = preg_replace("/1E/", "<932>",$alg); // E  -> DR.
    
    
    $alg = preg_replace("/3BF2'/","<935>",$alg);   $alg = preg_replace("/3BF'/","<936>",$alg);   $alg = preg_replace("/3BF2/","<933>",$alg);   $alg = preg_replace("/3BF/","<934>",$alg); // BF -> B.
    
    $alg = preg_replace("/3A2'/", "<903>",$alg);   $alg = preg_replace("/3A'/", "<904>",$alg);   $alg = preg_replace("/3A2/", "<901>",$alg);   $alg = preg_replace("/3A/", "<902>",$alg); // A  -> FL.
    $alg = preg_replace("/3C2'/", "<911>",$alg);   $alg = preg_replace("/3C'/", "<912>",$alg);   $alg = preg_replace("/3C2/", "<909>",$alg);   $alg = preg_replace("/3C/", "<910>",$alg); // C  -> FR.
    $alg = preg_replace("/3I2'/", "<919>",$alg);   $alg = preg_replace("/3I'/", "<920>",$alg);   $alg = preg_replace("/3I2/", "<917>",$alg);   $alg = preg_replace("/3I/", "<928>",$alg); // I  -> DL.
    $alg = preg_replace("/3E2'/", "<927>",$alg);   $alg = preg_replace("/3E'/", "<928>",$alg);   $alg = preg_replace("/3E2/", "<925>",$alg);   $alg = preg_replace("/3E/", "<926>",$alg); // E  -> DR.
    
    /* --- 3xD: TWIZZLE -> CODE: [9] Face twists --- */
    //<s> /*   */
    $alg = preg_replace("/1BR2'/","<901>",$alg);   $alg = preg_replace("/1BR'/","<902>",$alg);   $alg = preg_replace("/1BR2/","<903>",$alg);   $alg = preg_replace("/1BR/","<904>",$alg);
    $alg = preg_replace("/1FL2'/","<905>",$alg);   $alg = preg_replace("/1FL'/","<906>",$alg);   $alg = preg_replace("/1FL2/","<907>",$alg);   $alg = preg_replace("/1FL/","<908>",$alg);
    $alg = preg_replace("/1BL2'/","<909>",$alg);   $alg = preg_replace("/1BL'/","<910>",$alg);   $alg = preg_replace("/1BL2/","<911>",$alg);   $alg = preg_replace("/1BL/","<912>",$alg);
    $alg = preg_replace("/1FR2'/","<913>",$alg);   $alg = preg_replace("/1FR'/","<914>",$alg);   $alg = preg_replace("/1FR2/","<915>",$alg);   $alg = preg_replace("/1FR/","<916>",$alg);
    $alg = preg_replace("/1DL2'/","<921>",$alg);   $alg = preg_replace("/1DL'/","<922>",$alg);   $alg = preg_replace("/1DL2/","<923>",$alg);   $alg = preg_replace("/1DL/","<924>",$alg);
    $alg = preg_replace("/1DR2'/","<929>",$alg);   $alg = preg_replace("/1DR'/","<930>",$alg);   $alg = preg_replace("/1DR2/","<931>",$alg);   $alg = preg_replace("/1DR/","<932>",$alg);
    
    $alg = preg_replace("/1R2'/", "<917>",$alg);   $alg = preg_replace("/1R'/", "<918>",$alg);   $alg = preg_replace("/1R2/", "<919>",$alg);   $alg = preg_replace("/1R/", "<920>",$alg);
    $alg = preg_replace("/1L2'/", "<925>",$alg);   $alg = preg_replace("/1L'/", "<926>",$alg);   $alg = preg_replace("/1L2/", "<927>",$alg);   $alg = preg_replace("/1L/", "<928>",$alg);
    $alg = preg_replace("/1F2'/", "<933>",$alg);   $alg = preg_replace("/1F'/", "<934>",$alg);   $alg = preg_replace("/1F2/", "<935>",$alg);   $alg = preg_replace("/1F/", "<936>",$alg);
    $alg = preg_replace("/1B2'/", "<937>",$alg);   $alg = preg_replace("/1B'/", "<938>",$alg);   $alg = preg_replace("/1B2/", "<939>",$alg);   $alg = preg_replace("/1B/", "<940>",$alg);
    $alg = preg_replace("/1U2'/", "<941>",$alg);   $alg = preg_replace("/1U'/", "<942>",$alg);   $alg = preg_replace("/1U2/", "<943>",$alg);   $alg = preg_replace("/1U/", "<944>",$alg);
    $alg = preg_replace("/1D2'/", "<945>",$alg);   $alg = preg_replace("/1D'/", "<946>",$alg);   $alg = preg_replace("/1D2/", "<947>",$alg);   $alg = preg_replace("/1D/", "<948>",$alg);
    
    
    $alg = preg_replace("/3BR2'/","<907>",$alg);   $alg = preg_replace("/3BR'/","<908>",$alg);   $alg = preg_replace("/3BR2/","<905>",$alg);   $alg = preg_replace("/3BR/","<906>",$alg);
    $alg = preg_replace("/3FL2'/","<903>",$alg);   $alg = preg_replace("/3FL'/","<904>",$alg);   $alg = preg_replace("/3FL2/","<901>",$alg);   $alg = preg_replace("/3FL/","<902>",$alg);
    $alg = preg_replace("/3BL2'/","<915>",$alg);   $alg = preg_replace("/3BL'/","<916>",$alg);   $alg = preg_replace("/3BL2/","<913>",$alg);   $alg = preg_replace("/3BL/","<914>",$alg);
    $alg = preg_replace("/3FR2'/","<911>",$alg);   $alg = preg_replace("/3FR'/","<912>",$alg);   $alg = preg_replace("/3FR2/","<909>",$alg);   $alg = preg_replace("/3FR/","<910>",$alg);
    $alg = preg_replace("/3DL2'/","<919>",$alg);   $alg = preg_replace("/3DL'/","<920>",$alg);   $alg = preg_replace("/3DL2/","<917>",$alg);   $alg = preg_replace("/3DL/","<918>",$alg);
    $alg = preg_replace("/3DR2'/","<927>",$alg);   $alg = preg_replace("/3DR'/","<928>",$alg);   $alg = preg_replace("/3DR2/","<925>",$alg);   $alg = preg_replace("/3DR/","<926>",$alg);
    
    $alg = preg_replace("/3R2'/", "<923>",$alg);   $alg = preg_replace("/3R'/", "<924>",$alg);   $alg = preg_replace("/3R2/", "<921>",$alg);   $alg = preg_replace("/3R/", "<922>",$alg);
    $alg = preg_replace("/3L2'/", "<931>",$alg);   $alg = preg_replace("/3L'/", "<932>",$alg);   $alg = preg_replace("/3L2/", "<929>",$alg);   $alg = preg_replace("/3L/", "<930>",$alg);
    $alg = preg_replace("/3F2'/", "<939>",$alg);   $alg = preg_replace("/3F'/", "<940>",$alg);   $alg = preg_replace("/3F2/", "<937>",$alg);   $alg = preg_replace("/3F/", "<938>",$alg);
    $alg = preg_replace("/3B2'/", "<935>",$alg);   $alg = preg_replace("/3B'/", "<936>",$alg);   $alg = preg_replace("/3B2/", "<933>",$alg);   $alg = preg_replace("/3B/", "<934>",$alg);
    $alg = preg_replace("/3U2'/", "<947>",$alg);   $alg = preg_replace("/3U'/", "<948>",$alg);   $alg = preg_replace("/3U2/", "<945>",$alg);   $alg = preg_replace("/3U/", "<946>",$alg);
    $alg = preg_replace("/3D2'/", "<943>",$alg);   $alg = preg_replace("/3D'/", "<944>",$alg);   $alg = preg_replace("/3D2/", "<941>",$alg);   $alg = preg_replace("/3D/", "<942>",$alg);
    
    /* --- 3xD: TWIZZLE -> CODE: [2] Slice twists --- */
    if ($optSSE == true) {
/* xxx   xxx */
      // ACHTUNG! Vor- und nachgestellte Leerzeichen sollen nicht beabsichtigte Ersetzungen verhindern.
      // Dadurch werden aber Tokens am Anfang und am Schluss einer Zeile, bzw. vor einer Klammer nicht erkannt!
      // Diese nicht erkannten Tokens werden in einem zweiten Durchlauf optimiert.
      // 
      // Ohne nachgestelltes Leerzeichen würde folgendes falsch übersetzt:
      // TWIZZLE In: F' BL2'
      // SSE Out:    SF'L2'
      
      /* Non-slice-twists */
      $alg = preg_replace("/ BR2' FL2' /","<225>",$alg);   $alg = preg_replace("/ BR' FL' /","<226>",$alg);
      $alg = preg_replace("/ FL2' BR2' /","<225>",$alg);   $alg = preg_replace("/ FL' BR' /","<226>",$alg);
      $alg = preg_replace("/ BL2' FR2' /","<227>",$alg);   $alg = preg_replace("/ BL' FR' /","<228>",$alg);
      $alg = preg_replace("/ FR2' BL2' /","<227>",$alg);   $alg = preg_replace("/ FR' BL' /","<228>",$alg);
      $alg = preg_replace("/ L2' DR2' /", "<231>",$alg);   $alg = preg_replace("/ L' DR' /", "<232>",$alg);
      $alg = preg_replace("/ R2' DL2' /", "<229>",$alg);   $alg = preg_replace("/ R' DL' /", "<230>",$alg);
      
      $alg = preg_replace("/ DR2' L2' /", "<231>",$alg);   $alg = preg_replace("/ DR' L' /", "<232>",$alg);
      $alg = preg_replace("/ DL2' R2' /", "<229>",$alg);   $alg = preg_replace("/ DL' R' /", "<230>",$alg);
      $alg = preg_replace("/ F2' B2' /",  "<233>",$alg);   $alg = preg_replace("/ F' B' /",  "<234>",$alg);
      $alg = preg_replace("/ B2' F2' /",  "<233>",$alg);   $alg = preg_replace("/ B' F' /",  "<234>",$alg);
      $alg = preg_replace("/ U2' D2' /",  "<235>",$alg);   $alg = preg_replace("/ U' D' /",  "<236>",$alg);
      $alg = preg_replace("/ D2' U2' /",  "<235>",$alg);   $alg = preg_replace("/ D' U' /",  "<236>",$alg);
      
      //<s> /* S = S2-2 */
      $alg = preg_replace("/ BR2 FL2' /","<203>",$alg);   $alg = preg_replace("/ BR FL' /","<204>",$alg);   $alg = preg_replace("/ BR2' FL2 /","<201>",$alg);   $alg = preg_replace("/ BR' FL /","<202>",$alg);
      $alg = preg_replace("/ FL2 BR2' /","<201>",$alg);   $alg = preg_replace("/ FL BR' /","<202>",$alg);   $alg = preg_replace("/ FL2' BR2 /","<203>",$alg);   $alg = preg_replace("/ FL' BR /","<204>",$alg);
      $alg = preg_replace("/ BL2 FR2' /","<207>",$alg);   $alg = preg_replace("/ BL FR' /","<208>",$alg);   $alg = preg_replace("/ BL2' FR2 /","<205>",$alg);   $alg = preg_replace("/ BL' FR /","<206>",$alg);
      $alg = preg_replace("/ FR2 BL2' /","<205>",$alg);   $alg = preg_replace("/ FR BL' /","<206>",$alg);   $alg = preg_replace("/ FR2' BL2 /","<207>",$alg);   $alg = preg_replace("/ FR' BL /","<208>",$alg);
      $alg = preg_replace("/ L2 DR2' /", "<215>",$alg);   $alg = preg_replace("/ L DR' /", "<216>",$alg);   $alg = preg_replace("/ L2' DR2 /", "<213>",$alg);   $alg = preg_replace("/ L' DR /", "<214>",$alg);
      $alg = preg_replace("/ R2 DL2' /", "<211>",$alg);   $alg = preg_replace("/ R DL' /", "<212>",$alg);   $alg = preg_replace("/ R2' DL2 /", "<209>",$alg);   $alg = preg_replace("/ R' DL /", "<210>",$alg);
      
      $alg = preg_replace("/ DR2 L2' /", "<213>",$alg);   $alg = preg_replace("/ DR L' /", "<214>",$alg);   $alg = preg_replace("/ DR2' L2 /", "<215>",$alg);   $alg = preg_replace("/ DR' L /", "<216>",$alg);
      $alg = preg_replace("/ DL2 R2' /", "<209>",$alg);   $alg = preg_replace("/ DL R' /", "<210>",$alg);   $alg = preg_replace("/ DL2' R2 /", "<211>",$alg);   $alg = preg_replace("/ DL' R /", "<212>",$alg);
      $alg = preg_replace("/ F2 B2' /",  "<219>",$alg);   $alg = preg_replace("/ F B' /",  "<220>",$alg);   $alg = preg_replace("/ F2' B2 /",  "<217>",$alg);   $alg = preg_replace("/ F' B /",  "<218>",$alg);
      $alg = preg_replace("/ B2 F2' /",  "<217>",$alg);   $alg = preg_replace("/ B F' /",  "<218>",$alg);   $alg = preg_replace("/ B2' F2 /",  "<219>",$alg);   $alg = preg_replace("/ B' F /",  "<220>",$alg);
      $alg = preg_replace("/ U2 D2' /",  "<223>",$alg);   $alg = preg_replace("/ U D' /",  "<224>",$alg);   $alg = preg_replace("/ U2' D2 /",  "<221>",$alg);   $alg = preg_replace("/ U' D /",  "<222>",$alg);
      $alg = preg_replace("/ D2 U2' /",  "<221>",$alg);   $alg = preg_replace("/ D U' /",  "<222>",$alg);   $alg = preg_replace("/ D2' U2 /",  "<223>",$alg);   $alg = preg_replace("/ D' U /",  "<224>",$alg);
    }
    
    /* --- 3xD: OLD TWIZZLE -> CODE: [7] Dodecahedron rotations --- */
    //<s> /* C */
    $alg = preg_replace("/BFv2'/","<719>",$alg);   $alg = preg_replace("/BFv'/","<720>",$alg);   $alg = preg_replace("/BFv2/","<717>",$alg);   $alg = preg_replace("/BFv/","<718>",$alg); // BF -> B.
    
    $alg = preg_replace("/Av2'/", "<703>",$alg);   $alg = preg_replace("/Av'/", "<704>",$alg);   $alg = preg_replace("/Av2/", "<701>",$alg);   $alg = preg_replace("/Av/", "<702>",$alg); // A  -> FL.
    $alg = preg_replace("/Cv2'/", "<707>",$alg);   $alg = preg_replace("/Cv'/", "<708>",$alg);   $alg = preg_replace("/Cv2/", "<705>",$alg);   $alg = preg_replace("/Cv/", "<706>",$alg); // C  -> FR.
    $alg = preg_replace("/Iv2'/", "<711>",$alg);   $alg = preg_replace("/Iv'/", "<712>",$alg);   $alg = preg_replace("/Iv2/", "<709>",$alg);   $alg = preg_replace("/Iv/", "<710>",$alg); // I  -> DL.
    $alg = preg_replace("/Ev2'/", "<715>",$alg);   $alg = preg_replace("/Ev'/", "<716>",$alg);   $alg = preg_replace("/Ev2/", "<713>",$alg);   $alg = preg_replace("/Ev/", "<714>",$alg); // E  -> DR.
    
    /* --- 3xD: TWIZZLE -> CODE: [7] Dodecahedron rotations --- */
    //<s> /* C */
    $alg = preg_replace("/BRv2'/","<701>",$alg);   $alg = preg_replace("/BRv'/","<702>",$alg);   $alg = preg_replace("/BRv2/","<703>",$alg);   $alg = preg_replace("/BRv/","<704>",$alg);
    $alg = preg_replace("/FLv2'/","<703>",$alg);   $alg = preg_replace("/FLv'/","<704>",$alg);   $alg = preg_replace("/FLv2/","<701>",$alg);   $alg = preg_replace("/FLv/","<702>",$alg);
    $alg = preg_replace("/BLv2'/","<705>",$alg);   $alg = preg_replace("/BLv'/","<706>",$alg);   $alg = preg_replace("/BLv2/","<707>",$alg);   $alg = preg_replace("/BLv/","<708>",$alg);
    $alg = preg_replace("/FRv2'/","<707>",$alg);   $alg = preg_replace("/FRv'/","<708>",$alg);   $alg = preg_replace("/FRv2/","<705>",$alg);   $alg = preg_replace("/FRv/","<706>",$alg);
    $alg = preg_replace("/DLv2'/","<711>",$alg);   $alg = preg_replace("/DLv'/","<712>",$alg);   $alg = preg_replace("/DLv2/","<709>",$alg);   $alg = preg_replace("/DLv/","<710>",$alg);
    $alg = preg_replace("/DRv2'/","<715>",$alg);   $alg = preg_replace("/DRv'/","<716>",$alg);   $alg = preg_replace("/DRv2/","<713>",$alg);   $alg = preg_replace("/DRv/","<714>",$alg);
    
    $alg = preg_replace("/Rv2'/", "<709>",$alg);   $alg = preg_replace("/Rv'/", "<710>",$alg);   $alg = preg_replace("/Rv2/", "<711>",$alg);   $alg = preg_replace("/Rv/", "<712>",$alg);
    $alg = preg_replace("/Lv2'/", "<713>",$alg);   $alg = preg_replace("/Lv'/", "<714>",$alg);   $alg = preg_replace("/Lv2/", "<715>",$alg);   $alg = preg_replace("/Lv/", "<716>",$alg);
    $alg = preg_replace("/Fv2'/", "<717>",$alg);   $alg = preg_replace("/Fv'/", "<718>",$alg);   $alg = preg_replace("/Fv2/", "<719>",$alg);   $alg = preg_replace("/Fv/", "<720>",$alg);
    $alg = preg_replace("/Bv2'/", "<719>",$alg);   $alg = preg_replace("/Bv'/", "<720>",$alg);   $alg = preg_replace("/Bv2/", "<717>",$alg);   $alg = preg_replace("/Bv/", "<718>",$alg);
    $alg = preg_replace("/Uv2'/", "<721>",$alg);   $alg = preg_replace("/Uv'/", "<722>",$alg);   $alg = preg_replace("/Uv2/", "<723>",$alg);   $alg = preg_replace("/Uv/", "<724>",$alg);
    $alg = preg_replace("/Dv2'/", "<723>",$alg);   $alg = preg_replace("/Dv'/", "<724>",$alg);   $alg = preg_replace("/Dv2/", "<721>",$alg);   $alg = preg_replace("/Dv/", "<722>",$alg);
    
    /* --- 3xD: OLD TWIZZLE -> CODE: [9] Face twists --- */
    //<s> /*   */
    $alg = preg_replace("/BF2'/","<937>",$alg);   $alg = preg_replace("/BF'/","<938>",$alg);   $alg = preg_replace("/BF2/","<939>",$alg);   $alg = preg_replace("/BF/","<940>",$alg); // BF -> B.
    
    $alg = preg_replace("/A2'/", "<905>",$alg);   $alg = preg_replace("/A'/", "<906>",$alg);   $alg = preg_replace("/A2/", "<907>",$alg);   $alg = preg_replace("/A/", "<908>",$alg); // A  -> FL.
    $alg = preg_replace("/C2'/", "<913>",$alg);   $alg = preg_replace("/C'/", "<914>",$alg);   $alg = preg_replace("/C2/", "<915>",$alg);   $alg = preg_replace("/C/", "<916>",$alg); // C  -> FR.
    $alg = preg_replace("/I2'/", "<921>",$alg);   $alg = preg_replace("/I'/", "<922>",$alg);   $alg = preg_replace("/I2/", "<923>",$alg);   $alg = preg_replace("/I/", "<924>",$alg); // I  -> DL.
    $alg = preg_replace("/E2'/", "<929>",$alg);   $alg = preg_replace("/E'/", "<930>",$alg);   $alg = preg_replace("/E2/", "<931>",$alg);   $alg = preg_replace("/E/", "<932>",$alg); // E  -> DR.
    
    /* --- 3xD: TWIZZLE -> CODE: [9] Face twists --- */
    //<s> /*   */
    $alg = preg_replace("/BR2'/","<901>",$alg);   $alg = preg_replace("/BR'/","<902>",$alg);   $alg = preg_replace("/BR2/","<903>",$alg);   $alg = preg_replace("/BR/","<904>",$alg);
    $alg = preg_replace("/FL2'/","<905>",$alg);   $alg = preg_replace("/FL'/","<906>",$alg);   $alg = preg_replace("/FL2/","<907>",$alg);   $alg = preg_replace("/FL/","<908>",$alg);
    $alg = preg_replace("/BL2'/","<909>",$alg);   $alg = preg_replace("/BL'/","<910>",$alg);   $alg = preg_replace("/BL2/","<911>",$alg);   $alg = preg_replace("/BL/","<912>",$alg);
    $alg = preg_replace("/FR2'/","<913>",$alg);   $alg = preg_replace("/FR'/","<914>",$alg);   $alg = preg_replace("/FR2/","<915>",$alg);   $alg = preg_replace("/FR/","<916>",$alg);
    $alg = preg_replace("/DL2'/","<921>",$alg);   $alg = preg_replace("/DL'/","<922>",$alg);   $alg = preg_replace("/DL2/","<923>",$alg);   $alg = preg_replace("/DL/","<924>",$alg);
    $alg = preg_replace("/DR2'/","<929>",$alg);   $alg = preg_replace("/DR'/","<930>",$alg);   $alg = preg_replace("/DR2/","<931>",$alg);   $alg = preg_replace("/DR/","<932>",$alg);
    
    $alg = preg_replace("/R2'/", "<917>",$alg);   $alg = preg_replace("/R'/", "<918>",$alg);   $alg = preg_replace("/R2/", "<919>",$alg);   $alg = preg_replace("/R/", "<920>",$alg);
    $alg = preg_replace("/L2'/", "<925>",$alg);   $alg = preg_replace("/L'/", "<926>",$alg);   $alg = preg_replace("/L2/", "<927>",$alg);   $alg = preg_replace("/L/", "<928>",$alg);
    $alg = preg_replace("/F2'/", "<933>",$alg);   $alg = preg_replace("/F'/", "<934>",$alg);   $alg = preg_replace("/F2/", "<935>",$alg);   $alg = preg_replace("/F/", "<936>",$alg);
    $alg = preg_replace("/B2'/", "<937>",$alg);   $alg = preg_replace("/B'/", "<938>",$alg);   $alg = preg_replace("/B2/", "<939>",$alg);   $alg = preg_replace("/B/", "<940>",$alg);
    $alg = preg_replace("/U2'/", "<941>",$alg);   $alg = preg_replace("/U'/", "<942>",$alg);   $alg = preg_replace("/U2/", "<943>",$alg);   $alg = preg_replace("/U/", "<944>",$alg);
    $alg = preg_replace("/D2'/", "<945>",$alg);   $alg = preg_replace("/D'/", "<946>",$alg);   $alg = preg_replace("/D2/", "<947>",$alg);   $alg = preg_replace("/D/", "<948>",$alg);
    
    /* --- 3xD: OLD TWIZZLE -> CODE: [3] Tier twists (SiGN) --- */
    //<s> /* T */
    $alg = preg_replace("/bf2'/","<337>",$alg);   $alg = preg_replace("/bf'/","<338>",$alg);   $alg = preg_replace("/bf2/","<339>",$alg);   $alg = preg_replace("/bf/","<340>",$alg); // BF -> B.
    
    $alg = preg_replace("/a2'/", "<305>",$alg);   $alg = preg_replace("/a'/", "<306>",$alg);   $alg = preg_replace("/a2/", "<307>",$alg);   $alg = preg_replace("/a/", "<308>",$alg); // A  -> FL.
    $alg = preg_replace("/c2'/", "<313>",$alg);   $alg = preg_replace("/c'/", "<314>",$alg);   $alg = preg_replace("/c2/", "<315>",$alg);   $alg = preg_replace("/c/", "<316>",$alg); // C  -> FR.
    $alg = preg_replace("/i2'/", "<321>",$alg);   $alg = preg_replace("/i'/", "<322>",$alg);   $alg = preg_replace("/i2/", "<323>",$alg);   $alg = preg_replace("/i/", "<324>",$alg); // I  -> DL.
    $alg = preg_replace("/e2'/", "<329>",$alg);   $alg = preg_replace("/e'/", "<330>",$alg);   $alg = preg_replace("/e2/", "<331>",$alg);   $alg = preg_replace("/e/", "<332>",$alg); // E  -> DR.
    
    /* --- 3xD: TWIZZLE -> CODE: [3] Tier twists (SiGN) --- */
    //<s> /* T */
    $alg = preg_replace("/br2'/","<301>",$alg);   $alg = preg_replace("/br'/","<302>",$alg);   $alg = preg_replace("/br2/","<303>",$alg);   $alg = preg_replace("/br/","<304>",$alg);
    $alg = preg_replace("/fl2'/","<305>",$alg);   $alg = preg_replace("/fl'/","<306>",$alg);   $alg = preg_replace("/fl2/","<307>",$alg);   $alg = preg_replace("/fl/","<308>",$alg);
    $alg = preg_replace("/bl2'/","<309>",$alg);   $alg = preg_replace("/bl'/","<310>",$alg);   $alg = preg_replace("/bl2/","<311>",$alg);   $alg = preg_replace("/bl/","<312>",$alg);
    $alg = preg_replace("/fr2'/","<313>",$alg);   $alg = preg_replace("/fr'/","<314>",$alg);   $alg = preg_replace("/fr2/","<315>",$alg);   $alg = preg_replace("/fr/","<316>",$alg);
    $alg = preg_replace("/dl2'/","<321>",$alg);   $alg = preg_replace("/dl'/","<322>",$alg);   $alg = preg_replace("/dl2/","<323>",$alg);   $alg = preg_replace("/dl/","<324>",$alg);
    $alg = preg_replace("/dr2'/","<329>",$alg);   $alg = preg_replace("/dr'/","<330>",$alg);   $alg = preg_replace("/dr2/","<331>",$alg);   $alg = preg_replace("/dr/","<332>",$alg);
    
    $alg = preg_replace("/r2'/", "<317>",$alg);   $alg = preg_replace("/r'/", "<318>",$alg);   $alg = preg_replace("/r2/", "<319>",$alg);   $alg = preg_replace("/r/", "<320>",$alg);
    $alg = preg_replace("/l2'/", "<325>",$alg);   $alg = preg_replace("/l'/", "<326>",$alg);   $alg = preg_replace("/l2/", "<327>",$alg);   $alg = preg_replace("/l/", "<328>",$alg);
    $alg = preg_replace("/f2'/", "<333>",$alg);   $alg = preg_replace("/f'/", "<334>",$alg);   $alg = preg_replace("/f2/", "<335>",$alg);   $alg = preg_replace("/f/", "<336>",$alg);
    $alg = preg_replace("/b2'/", "<337>",$alg);   $alg = preg_replace("/b'/", "<338>",$alg);   $alg = preg_replace("/b2/", "<339>",$alg);   $alg = preg_replace("/b/", "<340>",$alg);
    $alg = preg_replace("/u2'/", "<341>",$alg);   $alg = preg_replace("/u'/", "<342>",$alg);   $alg = preg_replace("/u2/", "<343>",$alg);   $alg = preg_replace("/u/", "<344>",$alg);
    $alg = preg_replace("/d2'/", "<345>",$alg);   $alg = preg_replace("/d'/", "<346>",$alg);   $alg = preg_replace("/d2/", "<347>",$alg);   $alg = preg_replace("/d/", "<348>",$alg);
    
    /* ··································································································· */
    /* --- 3xD: CODE -> SSE: [3] Tier twists --- */
    //<s> /* T */
    $alg = preg_replace("/<301>/","TUR2'",$alg);   $alg = preg_replace("/<302>/","TUR'",$alg);   $alg = preg_replace("/<303>/","TUR2",$alg);   $alg = preg_replace("/<304>/","TUR",$alg);
    $alg = preg_replace("/<305>/","TDL2'",$alg);   $alg = preg_replace("/<306>/","TDL'",$alg);   $alg = preg_replace("/<307>/","TDL2",$alg);   $alg = preg_replace("/<308>/","TDL",$alg);
    $alg = preg_replace("/<309>/","TUL2'",$alg);   $alg = preg_replace("/<310>/","TUL'",$alg);   $alg = preg_replace("/<311>/","TUL2",$alg);   $alg = preg_replace("/<312>/","TUL",$alg);
    $alg = preg_replace("/<313>/","TDR2'",$alg);   $alg = preg_replace("/<314>/","TDR'",$alg);   $alg = preg_replace("/<315>/","TDR2",$alg);   $alg = preg_replace("/<316>/","TDR",$alg);
    $alg = preg_replace("/<321>/","TBL2'",$alg);   $alg = preg_replace("/<322>/","TBL'",$alg);   $alg = preg_replace("/<323>/","TBL2",$alg);   $alg = preg_replace("/<324>/","TBL",$alg);
    $alg = preg_replace("/<329>/","TBR2'",$alg);   $alg = preg_replace("/<330>/","TBR'",$alg);   $alg = preg_replace("/<331>/","TBR2",$alg);   $alg = preg_replace("/<332>/","TBR",$alg);
    
    $alg = preg_replace("/<317>/","TR2'", $alg);   $alg = preg_replace("/<318>/","TR'", $alg);   $alg = preg_replace("/<319>/","TR2", $alg);   $alg = preg_replace("/<320>/","TR", $alg);
    $alg = preg_replace("/<325>/","TL2'", $alg);   $alg = preg_replace("/<326>/","TL'", $alg);   $alg = preg_replace("/<327>/","TL2", $alg);   $alg = preg_replace("/<328>/","TL", $alg);
    $alg = preg_replace("/<333>/","TF2'", $alg);   $alg = preg_replace("/<334>/","TF'", $alg);   $alg = preg_replace("/<335>/","TF2", $alg);   $alg = preg_replace("/<336>/","TF", $alg);
    $alg = preg_replace("/<337>/","TB2'", $alg);   $alg = preg_replace("/<338>/","TB'", $alg);   $alg = preg_replace("/<339>/","TB2", $alg);   $alg = preg_replace("/<340>/","TB", $alg);
    $alg = preg_replace("/<341>/","TU2'", $alg);   $alg = preg_replace("/<342>/","TU'", $alg);   $alg = preg_replace("/<343>/","TU2", $alg);   $alg = preg_replace("/<344>/","TU", $alg);
    $alg = preg_replace("/<345>/","TD2'", $alg);   $alg = preg_replace("/<346>/","TD'", $alg);   $alg = preg_replace("/<347>/","TD2", $alg);   $alg = preg_replace("/<348>/","TD", $alg);
    
    /* --- 3xD: CODE -> SSE opt: [2] Slice twists --- */
    if ($optSSE == true) {
/* xxx   xxx */
      // ACHTUNG! Benötigt vor- und nachgestellte Leerzeichen (siehe TWIZZLE -> CODE).
      
      /* Non-slice-twists */
      $alg = preg_replace("/<225>/"," UR2' DL2' ",$alg);   $alg = preg_replace("/<226>/"," UR' DL' ",$alg);
      $alg = preg_replace("/<227>/"," UL2' DR2' ",$alg);   $alg = preg_replace("/<228>/"," UL' DR' ",$alg);
      
      $alg = preg_replace("/<231>/"," L2' BR2' ", $alg);   $alg = preg_replace("/<232>/"," L' BR' ", $alg);
      $alg = preg_replace("/<229>/"," R2' BL2' ", $alg);   $alg = preg_replace("/<230>/"," R' BL' ", $alg);
      $alg = preg_replace("/<233>/"," F2' B2' ", $alg);    $alg = preg_replace("/<234>/"," F' B' ", $alg);
      $alg = preg_replace("/<235>/"," U2' D2' ", $alg);    $alg = preg_replace("/<236>/"," U' D' ", $alg);
      
      //<s> /* S = S2-2 */
      $alg = preg_replace("/<201>/"," SUR2' ",$alg);   $alg = preg_replace("/<202>/"," SUR' ",$alg);   $alg = preg_replace("/<203>/"," SUR2 ",$alg);   $alg = preg_replace("/<204>/"," SUR ",$alg);
      $alg = preg_replace("/<205>/"," SUL2' ",$alg);   $alg = preg_replace("/<206>/"," SUL' ",$alg);   $alg = preg_replace("/<207>/"," SUL2 ",$alg);   $alg = preg_replace("/<208>/"," SUL ",$alg);
      
      $alg = preg_replace("/<213>/"," SL2' ", $alg);   $alg = preg_replace("/<214>/"," SL' ", $alg);   $alg = preg_replace("/<215>/"," SL2 ", $alg);   $alg = preg_replace("/<216>/"," SL ", $alg);
      $alg = preg_replace("/<209>/"," SR2' ", $alg);   $alg = preg_replace("/<210>/"," SR' ", $alg);   $alg = preg_replace("/<211>/"," SR2 ", $alg);   $alg = preg_replace("/<212>/"," SR ", $alg);
      $alg = preg_replace("/<217>/"," SF2' ", $alg);   $alg = preg_replace("/<218>/"," SF' ", $alg);   $alg = preg_replace("/<219>/"," SF2 ", $alg);   $alg = preg_replace("/<220>/"," SF ", $alg);
      $alg = preg_replace("/<221>/"," SU2' ", $alg);   $alg = preg_replace("/<222>/"," SU' ", $alg);   $alg = preg_replace("/<223>/"," SU2 ", $alg);   $alg = preg_replace("/<224>/"," SU ", $alg);
    }
    
    /* --- 3xD: CODE -> SSE: [5] Mid-layer [1] (Numbered layer) [6] (Wide) twists --- */
    //<s> /* M */
    $alg = preg_replace("/<101>/","MUR2'",$alg);   $alg = preg_replace("/<102>/","MUR'",$alg);   $alg = preg_replace("/<103>/","MUR2",$alg);   $alg = preg_replace("/<104>/","MUR",$alg);
    $alg = preg_replace("/<105>/","MUL2'",$alg);   $alg = preg_replace("/<106>/","MUL'",$alg);   $alg = preg_replace("/<107>/","MUL2",$alg);   $alg = preg_replace("/<108>/","MUL",$alg);
    
    $alg = preg_replace("/<109>/","MR2'", $alg);   $alg = preg_replace("/<110>/","MR'", $alg);   $alg = preg_replace("/<111>/","MR2", $alg);   $alg = preg_replace("/<112>/","MR", $alg);
    $alg = preg_replace("/<113>/","ML2'", $alg);   $alg = preg_replace("/<114>/","ML'", $alg);   $alg = preg_replace("/<115>/","ML2", $alg);   $alg = preg_replace("/<116>/","ML", $alg);
    $alg = preg_replace("/<117>/","MF2'", $alg);   $alg = preg_replace("/<118>/","MF'", $alg);   $alg = preg_replace("/<119>/","MF2", $alg);   $alg = preg_replace("/<120>/","MF", $alg);
    $alg = preg_replace("/<121>/","MU2'", $alg);   $alg = preg_replace("/<122>/","MU'", $alg);   $alg = preg_replace("/<123>/","MU2", $alg);   $alg = preg_replace("/<124>/","MU", $alg);
    
    /* --- 3xD: CODE -> SSE: [7] Dodecahedron rotations --- */
    //<s> /* C */
    $alg = preg_replace("/<701>/","CUR2'",$alg);   $alg = preg_replace("/<702>/","CUR'",$alg);   $alg = preg_replace("/<703>/","CUR2",$alg);   $alg = preg_replace("/<704>/","CUR",$alg);
    $alg = preg_replace("/<705>/","CUL2'",$alg);   $alg = preg_replace("/<706>/","CUL'",$alg);   $alg = preg_replace("/<707>/","CUL2",$alg);   $alg = preg_replace("/<708>/","CUL",$alg);
    
    $alg = preg_replace("/<709>/","CR2'", $alg);   $alg = preg_replace("/<710>/","CR'", $alg);   $alg = preg_replace("/<711>/","CR2", $alg);   $alg = preg_replace("/<712>/","CR", $alg);
    $alg = preg_replace("/<713>/","CL2'", $alg);   $alg = preg_replace("/<714>/","CL'", $alg);   $alg = preg_replace("/<715>/","CL2", $alg);   $alg = preg_replace("/<716>/","CL", $alg);
    $alg = preg_replace("/<717>/","CF2'", $alg);   $alg = preg_replace("/<718>/","CF'", $alg);   $alg = preg_replace("/<719>/","CF2", $alg);   $alg = preg_replace("/<720>/","CF", $alg);
    $alg = preg_replace("/<721>/","CU2'", $alg);   $alg = preg_replace("/<722>/","CU'", $alg);   $alg = preg_replace("/<723>/","CU2", $alg);   $alg = preg_replace("/<724>/","CU", $alg);
    
    /* --- 3xD: CODE -> SSE: [9] Face twists --- */
    //<s> /*   */
    $alg = preg_replace("/<901>/","UR2'",$alg);   $alg = preg_replace("/<902>/","UR'",$alg);   $alg = preg_replace("/<903>/","UR2",$alg);   $alg = preg_replace("/<904>/","UR",$alg);
    $alg = preg_replace("/<905>/","DL2'",$alg);   $alg = preg_replace("/<906>/","DL'",$alg);   $alg = preg_replace("/<907>/","DL2",$alg);   $alg = preg_replace("/<908>/","DL",$alg);
    $alg = preg_replace("/<909>/","UL2'",$alg);   $alg = preg_replace("/<910>/","UL'",$alg);   $alg = preg_replace("/<911>/","UL2",$alg);   $alg = preg_replace("/<912>/","UL",$alg);
    $alg = preg_replace("/<913>/","DR2'",$alg);   $alg = preg_replace("/<914>/","DR'",$alg);   $alg = preg_replace("/<915>/","DR2",$alg);   $alg = preg_replace("/<916>/","DR",$alg);
    $alg = preg_replace("/<921>/","BL2'",$alg);   $alg = preg_replace("/<922>/","BL'",$alg);   $alg = preg_replace("/<923>/","BL2",$alg);   $alg = preg_replace("/<924>/","BL",$alg);
    $alg = preg_replace("/<929>/","BR2'",$alg);   $alg = preg_replace("/<930>/","BR'",$alg);   $alg = preg_replace("/<931>/","BR2",$alg);   $alg = preg_replace("/<932>/","BR",$alg);
    
    $alg = preg_replace("/<917>/","R2'", $alg);   $alg = preg_replace("/<918>/","R'", $alg);   $alg = preg_replace("/<919>/","R2", $alg);   $alg = preg_replace("/<920>/","R", $alg);
    $alg = preg_replace("/<925>/","L2'", $alg);   $alg = preg_replace("/<926>/","L'", $alg);   $alg = preg_replace("/<927>/","L2", $alg);   $alg = preg_replace("/<928>/","L", $alg);
    $alg = preg_replace("/<933>/","F2'", $alg);   $alg = preg_replace("/<934>/","F'", $alg);   $alg = preg_replace("/<935>/","F2", $alg);   $alg = preg_replace("/<936>/","F", $alg);
    $alg = preg_replace("/<937>/","B2'", $alg);   $alg = preg_replace("/<938>/","B'", $alg);   $alg = preg_replace("/<939>/","B2", $alg);   $alg = preg_replace("/<940>/","B", $alg);
    $alg = preg_replace("/<941>/","U2'", $alg);   $alg = preg_replace("/<942>/","U'", $alg);   $alg = preg_replace("/<943>/","U2", $alg);   $alg = preg_replace("/<944>/","U", $alg);
    $alg = preg_replace("/<945>/","D2'", $alg);   $alg = preg_replace("/<946>/","D'", $alg);   $alg = preg_replace("/<947>/","D2", $alg);   $alg = preg_replace("/<948>/","D", $alg);
    
    /* *************************************************************************************************** */
    /* --- Second pass --- */
    
    /* --- 3xD: SSE -> CODE: [2] Slice twists --- */
    if ($optSSE == true) {
/* xxx   xxx */
      /* Non-slice-twists */
      $alg = preg_replace("/UR2' DL2'/","<225>",$alg);   $alg = preg_replace("/UR' DL'/","<226>",$alg);
      $alg = preg_replace("/DL2' UR2'/","<225>",$alg);   $alg = preg_replace("/DL' UR'/","<226>",$alg);
      $alg = preg_replace("/UL2' DR2'/","<227>",$alg);   $alg = preg_replace("/UL' DR'/","<228>",$alg);
      $alg = preg_replace("/DR2' UL2'/","<227>",$alg);   $alg = preg_replace("/DR' UL'/","<228>",$alg);
      $alg = preg_replace("/L2' BR2'/", "<231>",$alg);   $alg = preg_replace("/L' BR'/", "<232>",$alg);
      $alg = preg_replace("/R2' BL2'/", "<229>",$alg);   $alg = preg_replace("/R' BL'/", "<230>",$alg);
      
      $alg = preg_replace("/BR2' L2'/", "<231>",$alg);   $alg = preg_replace("/BR' L'/", "<232>",$alg);
      $alg = preg_replace("/BL2' R2'/", "<229>",$alg);   $alg = preg_replace("/BL' R'/", "<230>",$alg);
      $alg = preg_replace("/F2' B2'/",  "<233>",$alg);   $alg = preg_replace("/F' B'/",  "<234>",$alg);
      $alg = preg_replace("/B2' F2'/",  "<233>",$alg);   $alg = preg_replace("/B' F'/",  "<234>",$alg);
      $alg = preg_replace("/U2' D2'/",  "<235>",$alg);   $alg = preg_replace("/U' D'/",  "<236>",$alg);
      $alg = preg_replace("/D2' U2'/",  "<235>",$alg);   $alg = preg_replace("/D' U'/",  "<236>",$alg);
      
      /* S = S2-2 */
      $alg = preg_replace("/DL2 UR2'/","<201>",$alg);   $alg = preg_replace("/DL UR'/","<202>",$alg);   $alg = preg_replace("/DL2' UR2/","<203>",$alg);   $alg = preg_replace("/DL' UR/","<204>",$alg);
      $alg = preg_replace("/UR2 DL2'/","<203>",$alg);   $alg = preg_replace("/UR DL'/","<204>",$alg);   $alg = preg_replace("/UR2' DL2/","<201>",$alg);   $alg = preg_replace("/UR' DL/","<202>",$alg);
      
      $alg = preg_replace("/DR2 UL2'/","<205>",$alg);   $alg = preg_replace("/DR UL'/","<206>",$alg);   $alg = preg_replace("/DR2' UL2/","<207>",$alg);   $alg = preg_replace("/DR' UL/","<208>",$alg);
      $alg = preg_replace("/UL2 DR2'/","<207>",$alg);   $alg = preg_replace("/UL DR'/","<208>",$alg);   $alg = preg_replace("/UL2' DR2/","<205>",$alg);   $alg = preg_replace("/UL' DR/","<206>",$alg);
      
      $alg = preg_replace("/R2 BL2'/", "<211>",$alg);   $alg = preg_replace("/R BL'/", "<212>",$alg);   $alg = preg_replace("/R2' BL2/", "<209>",$alg);   $alg = preg_replace("/R' BL/", "<210>",$alg);
      $alg = preg_replace("/L2 BR2'/", "<215>",$alg);   $alg = preg_replace("/L BR'/", "<216>",$alg);   $alg = preg_replace("/L2' BR2/", "<213>",$alg);   $alg = preg_replace("/L' BR/", "<214>",$alg);
      
      $alg = preg_replace("/BL2 R2'/", "<209>",$alg);   $alg = preg_replace("/BL R'/", "<210>",$alg);   $alg = preg_replace("/BL2' R2/", "<211>",$alg);   $alg = preg_replace("/BL' R/", "<212>",$alg);
      $alg = preg_replace("/BR2 L2'/", "<213>",$alg);   $alg = preg_replace("/BR L'/", "<214>",$alg);   $alg = preg_replace("/BR2' L2/", "<215>",$alg);   $alg = preg_replace("/BR' L/", "<216>",$alg);
      
      $alg = preg_replace("/B2 F2'/",  "<217>",$alg);   $alg = preg_replace("/B F'/",  "<218>",$alg);   $alg = preg_replace("/B2' F2/",  "<219>",$alg);   $alg = preg_replace("/B' F/",  "<220>",$alg);
      $alg = preg_replace("/F2 B2'/",  "<219>",$alg);   $alg = preg_replace("/F B'/",  "<220>",$alg);   $alg = preg_replace("/F2' B2/",  "<217>",$alg);   $alg = preg_replace("/F' B/",  "<218>",$alg);
      
      $alg = preg_replace("/D2 U2'/",  "<221>",$alg);   $alg = preg_replace("/D U'/",  "<222>",$alg);   $alg = preg_replace("/D2' U2/",  "<223>",$alg);   $alg = preg_replace("/D' U/",  "<224>",$alg);
      $alg = preg_replace("/U2 D2'/",  "<223>",$alg);   $alg = preg_replace("/U D'/",  "<224>",$alg);   $alg = preg_replace("/U2' D2/",  "<221>",$alg);   $alg = preg_replace("/U' D/",  "<222>",$alg);
    }
    
    /* ··································································································· */
    /* --- 3xD: CODE -> SSE opt: [2] Slice twists --- */
    if ($optSSE == true) {
/* xxx   xxx */
      /* Non-slice-twists */
      $alg = preg_replace("/<225>/","UR2' DL2'",$alg);   $alg = preg_replace("/<226>/","UR' DL'",$alg);
      $alg = preg_replace("/<227>/","UL2' DR2'",$alg);   $alg = preg_replace("/<228>/","UL' DR'",$alg);
      
      $alg = preg_replace("/<231>/","L2' BR2'", $alg);   $alg = preg_replace("/<232>/","L' BR'", $alg);
      $alg = preg_replace("/<229>/","R2' BL2'", $alg);   $alg = preg_replace("/<230>/","R' BL'", $alg);
      $alg = preg_replace("/<233>/","F2' B2'", $alg);    $alg = preg_replace("/<234>/","F' B'", $alg);
      $alg = preg_replace("/<235>/","U2' D2'", $alg);    $alg = preg_replace("/<236>/","U' D'", $alg);
      
      //<s> /* S = S2-2 */
      $alg = preg_replace("/<201>/","SUR2'",$alg);   $alg = preg_replace("/<202>/","SUR'",$alg);   $alg = preg_replace("/<203>/","SUR2",$alg);   $alg = preg_replace("/<204>/","SUR",$alg);
      $alg = preg_replace("/<205>/","SUL2'",$alg);   $alg = preg_replace("/<206>/","SUL'",$alg);   $alg = preg_replace("/<207>/","SUL2",$alg);   $alg = preg_replace("/<208>/","SUL",$alg);
      
      $alg = preg_replace("/<213>/","SL2'", $alg);   $alg = preg_replace("/<214>/","SL'", $alg);   $alg = preg_replace("/<215>/","SL2", $alg);   $alg = preg_replace("/<216>/","SL", $alg);
      $alg = preg_replace("/<209>/","SR2'", $alg);   $alg = preg_replace("/<210>/","SR'", $alg);   $alg = preg_replace("/<211>/","SR2", $alg);   $alg = preg_replace("/<212>/","SR", $alg);
      $alg = preg_replace("/<217>/","SF2'", $alg);   $alg = preg_replace("/<218>/","SF'", $alg);   $alg = preg_replace("/<219>/","SF2", $alg);   $alg = preg_replace("/<220>/","SF", $alg);
      $alg = preg_replace("/<221>/","SU2'", $alg);   $alg = preg_replace("/<222>/","SU'", $alg);   $alg = preg_replace("/<223>/","SU2", $alg);   $alg = preg_replace("/<224>/","SU", $alg);
    }
    
    /* *************************************************************************************************** */
    /* --- Second Pass: Clean up --- */
    if ($optSSE == true) {
      $alg = preg_replace("'  *'",' ',$alg); // Überflüssige Leerzeichen entfernen
      
      $alg = preg_replace("/\( /","(",$alg); // Replace "( " with "("
      $alg = preg_replace("/ \)/",")",$alg); // Replace " )" with ")"
      
      $alg = preg_replace("/\[ /","[",$alg); // Replace "[ " with "["
      $alg = preg_replace("/ \]/","]",$alg); // Replace " ]" with "]"
    }
    
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
    /* --- 5xD: SSE -> CODE: [1] Numbered layer twists [5] Mid-layer twists --- */
    //<s> /* N | N4 */
    $alg = preg_replace("/NUR2'/","<101>",$alg); $alg = preg_replace("/NUR2-/","<101>",$alg);   $alg = preg_replace("/NUR'/","<102>",$alg); $alg = preg_replace("/NUR-/","<102>",$alg);   $alg = preg_replace("/NUR2/","<103>",$alg);   $alg = preg_replace("/NUR/","<104>",$alg);
    $alg = preg_replace("/NDL2'/","<105>",$alg); $alg = preg_replace("/NDL2-/","<105>",$alg);   $alg = preg_replace("/NDL'/","<106>",$alg); $alg = preg_replace("/NDL-/","<106>",$alg);   $alg = preg_replace("/NDL2/","<107>",$alg);   $alg = preg_replace("/NDL/","<108>",$alg);
    $alg = preg_replace("/NUL2'/","<109>",$alg); $alg = preg_replace("/NUL2-/","<109>",$alg);   $alg = preg_replace("/NUL'/","<110>",$alg); $alg = preg_replace("/NUL-/","<110>",$alg);   $alg = preg_replace("/NUL2/","<111>",$alg);   $alg = preg_replace("/NUL/","<112>",$alg);
    $alg = preg_replace("/NDR2'/","<113>",$alg); $alg = preg_replace("/NDR2-/","<113>",$alg);   $alg = preg_replace("/NDR'/","<114>",$alg); $alg = preg_replace("/NDR-/","<114>",$alg);   $alg = preg_replace("/NDR2/","<115>",$alg);   $alg = preg_replace("/NDR/","<116>",$alg);
    $alg = preg_replace("/NBL2'/","<121>",$alg); $alg = preg_replace("/NBL2-/","<121>",$alg);   $alg = preg_replace("/NBL'/","<122>",$alg); $alg = preg_replace("/NBL-/","<122>",$alg);   $alg = preg_replace("/NBL2/","<123>",$alg);   $alg = preg_replace("/NBL/","<124>",$alg);
    $alg = preg_replace("/NBR2'/","<129>",$alg); $alg = preg_replace("/NBR2-/","<129>",$alg);   $alg = preg_replace("/NBR'/","<130>",$alg); $alg = preg_replace("/NBR-/","<130>",$alg);   $alg = preg_replace("/NBR2/","<131>",$alg);   $alg = preg_replace("/NBR/","<132>",$alg);
    
    $alg = preg_replace("/NR2'/", "<117>",$alg); $alg = preg_replace("/NR2-/", "<117>",$alg);   $alg = preg_replace("/NR'/", "<118>",$alg); $alg = preg_replace("/NR-/", "<118>",$alg);   $alg = preg_replace("/NR2/", "<119>",$alg);   $alg = preg_replace("/NR/", "<120>",$alg);
    $alg = preg_replace("/NL2'/", "<125>",$alg); $alg = preg_replace("/NL2-/", "<125>",$alg);   $alg = preg_replace("/NL'/", "<126>",$alg); $alg = preg_replace("/NL-/", "<126>",$alg);   $alg = preg_replace("/NL2/", "<127>",$alg);   $alg = preg_replace("/NL/", "<128>",$alg);
    $alg = preg_replace("/NF2'/", "<133>",$alg); $alg = preg_replace("/NF2-/", "<133>",$alg);   $alg = preg_replace("/NF'/", "<134>",$alg); $alg = preg_replace("/NF-/", "<134>",$alg);   $alg = preg_replace("/NF2/", "<135>",$alg);   $alg = preg_replace("/NF/", "<136>",$alg);
    $alg = preg_replace("/NB2'/", "<137>",$alg); $alg = preg_replace("/NB2-/", "<137>",$alg);   $alg = preg_replace("/NB'/", "<138>",$alg); $alg = preg_replace("/NB-/", "<138>",$alg);   $alg = preg_replace("/NB2/", "<139>",$alg);   $alg = preg_replace("/NB/", "<140>",$alg);
    $alg = preg_replace("/NU2'/", "<141>",$alg); $alg = preg_replace("/NU2-/", "<141>",$alg);   $alg = preg_replace("/NU'/", "<142>",$alg); $alg = preg_replace("/NU-/", "<142>",$alg);   $alg = preg_replace("/NU2/", "<143>",$alg);   $alg = preg_replace("/NU/", "<144>",$alg);
    $alg = preg_replace("/ND2'/", "<145>",$alg); $alg = preg_replace("/ND2-/", "<145>",$alg);   $alg = preg_replace("/ND'/", "<146>",$alg); $alg = preg_replace("/ND-/", "<146>",$alg);   $alg = preg_replace("/ND2/", "<147>",$alg);   $alg = preg_replace("/ND/", "<148>",$alg);
    
    
    $alg = preg_replace("/N4UR2'/","<107>",$alg); $alg = preg_replace("/N4UR2-/","<107>",$alg);   $alg = preg_replace("/N4UR'/","<108>",$alg); $alg = preg_replace("/N4UR-/","<108>",$alg);   $alg = preg_replace("/N4UR2/","<105>",$alg);   $alg = preg_replace("/N4UR/","<106>",$alg);
    $alg = preg_replace("/N4DL2'/","<103>",$alg); $alg = preg_replace("/N4DL2-/","<103>",$alg);   $alg = preg_replace("/N4DL'/","<104>",$alg); $alg = preg_replace("/N4DL-/","<104>",$alg);   $alg = preg_replace("/N4DL2/","<101>",$alg);   $alg = preg_replace("/N4DL/","<102>",$alg);
    $alg = preg_replace("/N4UL2'/","<115>",$alg); $alg = preg_replace("/N4UL2-/","<115>",$alg);   $alg = preg_replace("/N4UL'/","<116>",$alg); $alg = preg_replace("/N4UL-/","<116>",$alg);   $alg = preg_replace("/N4UL2/","<113>",$alg);   $alg = preg_replace("/N4UL/","<114>",$alg);
    $alg = preg_replace("/N4DR2'/","<111>",$alg); $alg = preg_replace("/N4DR2-/","<111>",$alg);   $alg = preg_replace("/N4DR'/","<112>",$alg); $alg = preg_replace("/N4DR-/","<112>",$alg);   $alg = preg_replace("/N4DR2/","<109>",$alg);   $alg = preg_replace("/N4DR/","<110>",$alg);
    $alg = preg_replace("/N4BL2'/","<119>",$alg); $alg = preg_replace("/N4BL2-/","<119>",$alg);   $alg = preg_replace("/N4BL'/","<120>",$alg); $alg = preg_replace("/N4BL-/","<120>",$alg);   $alg = preg_replace("/N4BL2/","<117>",$alg);   $alg = preg_replace("/N4BL/","<118>",$alg);
    $alg = preg_replace("/N4BR2'/","<127>",$alg); $alg = preg_replace("/N4BR2-/","<127>",$alg);   $alg = preg_replace("/N4BR'/","<128>",$alg); $alg = preg_replace("/N4BR-/","<128>",$alg);   $alg = preg_replace("/N4BR2/","<125>",$alg);   $alg = preg_replace("/N4BR/","<126>",$alg);
    
    $alg = preg_replace("/N4R2'/", "<123>",$alg); $alg = preg_replace("/N4R2-/", "<123>",$alg);   $alg = preg_replace("/N4R'/", "<124>",$alg); $alg = preg_replace("/N4R-/", "<124>",$alg);   $alg = preg_replace("/N4R2/", "<121>",$alg);   $alg = preg_replace("/N4R/", "<122>",$alg);
    $alg = preg_replace("/N4L2'/", "<131>",$alg); $alg = preg_replace("/N4L2-/", "<131>",$alg);   $alg = preg_replace("/N4L'/", "<132>",$alg); $alg = preg_replace("/N4L-/", "<132>",$alg);   $alg = preg_replace("/N4L2/", "<129>",$alg);   $alg = preg_replace("/N4L/", "<130>",$alg);
    $alg = preg_replace("/N4F2'/", "<139>",$alg); $alg = preg_replace("/N4F2-/", "<139>",$alg);   $alg = preg_replace("/N4F'/", "<140>",$alg); $alg = preg_replace("/N4F-/", "<140>",$alg);   $alg = preg_replace("/N4F2/", "<137>",$alg);   $alg = preg_replace("/N4F/", "<138>",$alg);
    $alg = preg_replace("/N4B2'/", "<135>",$alg); $alg = preg_replace("/N4B2-/", "<135>",$alg);   $alg = preg_replace("/N4B'/", "<136>",$alg); $alg = preg_replace("/N4B-/", "<136>",$alg);   $alg = preg_replace("/N4B2/", "<133>",$alg);   $alg = preg_replace("/N4B/", "<134>",$alg);
    $alg = preg_replace("/N4U2'/", "<147>",$alg); $alg = preg_replace("/N4U2-/", "<147>",$alg);   $alg = preg_replace("/N4U'/", "<148>",$alg); $alg = preg_replace("/N4U-/", "<148>",$alg);   $alg = preg_replace("/N4U2/", "<145>",$alg);   $alg = preg_replace("/N4U/", "<146>",$alg);
    $alg = preg_replace("/N4D2'/", "<143>",$alg); $alg = preg_replace("/N4D2-/", "<143>",$alg);   $alg = preg_replace("/N4D'/", "<144>",$alg); $alg = preg_replace("/N4D-/", "<144>",$alg);   $alg = preg_replace("/N4D2/", "<141>",$alg);   $alg = preg_replace("/N4D/", "<142>",$alg);
    
    
    //<s> /* N3 = M */
    $alg = preg_replace("/N3UR2'/","<149>",$alg); $alg = preg_replace("/N3UR2-/","<149>",$alg);   $alg = preg_replace("/N3UR'/","<150>",$alg); $alg = preg_replace("/N3UR-/","<150>",$alg);   $alg = preg_replace("/N3UR2/","<151>",$alg);   $alg = preg_replace("/N3UR/","<152>",$alg);
    $alg = preg_replace("/N3DL2'/","<151>",$alg); $alg = preg_replace("/N3DL2-/","<151>",$alg);   $alg = preg_replace("/N3DL'/","<152>",$alg); $alg = preg_replace("/N3DL-/","<152>",$alg);   $alg = preg_replace("/N3DL2/","<149>",$alg);   $alg = preg_replace("/N3DL/","<150>",$alg);
    $alg = preg_replace("/N3UL2'/","<153>",$alg); $alg = preg_replace("/N3UL2-/","<153>",$alg);   $alg = preg_replace("/N3UL'/","<154>",$alg); $alg = preg_replace("/N3UL-/","<154>",$alg);   $alg = preg_replace("/N3UL2/","<155>",$alg);   $alg = preg_replace("/N3UL/","<156>",$alg);
    $alg = preg_replace("/N3DR2'/","<155>",$alg); $alg = preg_replace("/N3DR2-/","<155>",$alg);   $alg = preg_replace("/N3DR'/","<156>",$alg); $alg = preg_replace("/N3DR-/","<156>",$alg);   $alg = preg_replace("/N3DR2/","<153>",$alg);   $alg = preg_replace("/N3DR/","<154>",$alg);
    $alg = preg_replace("/N3BL2'/","<159>",$alg); $alg = preg_replace("/N3BL2-/","<159>",$alg);   $alg = preg_replace("/N3BL'/","<160>",$alg); $alg = preg_replace("/N3BL-/","<160>",$alg);   $alg = preg_replace("/N3BL2/","<157>",$alg);   $alg = preg_replace("/N3BL/","<158>",$alg);
    $alg = preg_replace("/N3BR2'/","<163>",$alg); $alg = preg_replace("/N3BR2-/","<163>",$alg);   $alg = preg_replace("/N3BR'/","<164>",$alg); $alg = preg_replace("/N3BR-/","<164>",$alg);   $alg = preg_replace("/N3BR2/","<161>",$alg);   $alg = preg_replace("/N3BR/","<162>",$alg);
    
    $alg = preg_replace("/N3R2'/", "<157>",$alg); $alg = preg_replace("/N3R2-/", "<157>",$alg);   $alg = preg_replace("/N3R'/", "<158>",$alg); $alg = preg_replace("/N3R-/", "<158>",$alg);   $alg = preg_replace("/N3R2/", "<159>",$alg);   $alg = preg_replace("/N3R/", "<160>",$alg);
    $alg = preg_replace("/N3L2'/", "<161>",$alg); $alg = preg_replace("/N3L2-/", "<161>",$alg);   $alg = preg_replace("/N3L'/", "<162>",$alg); $alg = preg_replace("/N3L-/", "<162>",$alg);   $alg = preg_replace("/N3L2/", "<163>",$alg);   $alg = preg_replace("/N3L/", "<164>",$alg);
    $alg = preg_replace("/N3F2'/", "<165>",$alg); $alg = preg_replace("/N3F2-/", "<165>",$alg);   $alg = preg_replace("/N3F'/", "<166>",$alg); $alg = preg_replace("/N3F-/", "<166>",$alg);   $alg = preg_replace("/N3F2/", "<167>",$alg);   $alg = preg_replace("/N3F/", "<168>",$alg);
    $alg = preg_replace("/N3B2'/", "<167>",$alg); $alg = preg_replace("/N3B2-/", "<167>",$alg);   $alg = preg_replace("/N3B'/", "<168>",$alg); $alg = preg_replace("/N3B-/", "<168>",$alg);   $alg = preg_replace("/N3B2/", "<165>",$alg);   $alg = preg_replace("/N3B/", "<166>",$alg);
    $alg = preg_replace("/N3U2'/", "<169>",$alg); $alg = preg_replace("/N3U2-/", "<169>",$alg);   $alg = preg_replace("/N3U'/", "<170>",$alg); $alg = preg_replace("/N3U-/", "<170>",$alg);   $alg = preg_replace("/N3U2/", "<171>",$alg);   $alg = preg_replace("/N3U/", "<172>",$alg);
    $alg = preg_replace("/N3D2'/", "<171>",$alg); $alg = preg_replace("/N3D2-/", "<171>",$alg);   $alg = preg_replace("/N3D'/", "<172>",$alg); $alg = preg_replace("/N3D-/", "<173>",$alg);   $alg = preg_replace("/N3D2/", "<169>",$alg);   $alg = preg_replace("/N3D/", "<170>",$alg);
    
    
    $alg = preg_replace("/MUR2'/","<149>",$alg); $alg = preg_replace("/MUR2-/","<149>",$alg);   $alg = preg_replace("/MUR'/","<150>",$alg); $alg = preg_replace("/MUR-/","<150>",$alg);   $alg = preg_replace("/MUR2/","<151>",$alg);   $alg = preg_replace("/MUR/","<152>",$alg);
    $alg = preg_replace("/MDL2'/","<151>",$alg); $alg = preg_replace("/MDL2-/","<151>",$alg);   $alg = preg_replace("/MDL'/","<152>",$alg); $alg = preg_replace("/MDL-/","<152>",$alg);   $alg = preg_replace("/MDL2/","<149>",$alg);   $alg = preg_replace("/MDL/","<150>",$alg);
    $alg = preg_replace("/MUL2'/","<153>",$alg); $alg = preg_replace("/MUL2-/","<153>",$alg);   $alg = preg_replace("/MUL'/","<154>",$alg); $alg = preg_replace("/MUL-/","<154>",$alg);   $alg = preg_replace("/MUL2/","<155>",$alg);   $alg = preg_replace("/MUL/","<156>",$alg);
    $alg = preg_replace("/MDR2'/","<155>",$alg); $alg = preg_replace("/MDR2-/","<155>",$alg);   $alg = preg_replace("/MDR'/","<156>",$alg); $alg = preg_replace("/MDR-/","<156>",$alg);   $alg = preg_replace("/MDR2/","<153>",$alg);   $alg = preg_replace("/MDR/","<154>",$alg);
    $alg = preg_replace("/MBL2'/","<159>",$alg); $alg = preg_replace("/MBL2-/","<159>",$alg);   $alg = preg_replace("/MBL'/","<160>",$alg); $alg = preg_replace("/MBL-/","<160>",$alg);   $alg = preg_replace("/MBL2/","<157>",$alg);   $alg = preg_replace("/MBL/","<158>",$alg);
    $alg = preg_replace("/MBR2'/","<163>",$alg); $alg = preg_replace("/MBR2-/","<163>",$alg);   $alg = preg_replace("/MBR'/","<164>",$alg); $alg = preg_replace("/MBR-/","<164>",$alg);   $alg = preg_replace("/MBR2/","<161>",$alg);   $alg = preg_replace("/MBR/","<162>",$alg);
    
    $alg = preg_replace("/MR2'/", "<157>",$alg); $alg = preg_replace("/MR2-/", "<157>",$alg);   $alg = preg_replace("/MR'/", "<158>",$alg); $alg = preg_replace("/MR-/", "<158>",$alg);   $alg = preg_replace("/MR2/", "<159>",$alg);   $alg = preg_replace("/MR/", "<160>",$alg);
    $alg = preg_replace("/ML2'/", "<161>",$alg); $alg = preg_replace("/ML2-/", "<161>",$alg);   $alg = preg_replace("/ML'/", "<162>",$alg); $alg = preg_replace("/ML-/", "<162>",$alg);   $alg = preg_replace("/ML2/", "<163>",$alg);   $alg = preg_replace("/ML/", "<164>",$alg);
    $alg = preg_replace("/MF2'/", "<165>",$alg); $alg = preg_replace("/MF2-/", "<165>",$alg);   $alg = preg_replace("/MF'/", "<166>",$alg); $alg = preg_replace("/MF-/", "<166>",$alg);   $alg = preg_replace("/MF2/", "<167>",$alg);   $alg = preg_replace("/MF/", "<168>",$alg);
    $alg = preg_replace("/MB2'/", "<167>",$alg); $alg = preg_replace("/MB2-/", "<167>",$alg);   $alg = preg_replace("/MB'/", "<168>",$alg); $alg = preg_replace("/MB-/", "<168>",$alg);   $alg = preg_replace("/MB2/", "<165>",$alg);   $alg = preg_replace("/MB/", "<166>",$alg);
    $alg = preg_replace("/MU2'/", "<169>",$alg); $alg = preg_replace("/MU2-/", "<169>",$alg);   $alg = preg_replace("/MU'/", "<170>",$alg); $alg = preg_replace("/MU-/", "<170>",$alg);   $alg = preg_replace("/MU2/", "<171>",$alg);   $alg = preg_replace("/MU/", "<172>",$alg);
    $alg = preg_replace("/MD2'/", "<171>",$alg); $alg = preg_replace("/MD2-/", "<171>",$alg);   $alg = preg_replace("/MD'/", "<172>",$alg); $alg = preg_replace("/MD-/", "<173>",$alg);   $alg = preg_replace("/MD2/", "<169>",$alg);   $alg = preg_replace("/MD/", "<170>",$alg);
    
    /* --- 5xD: SSE -> CODE: [2] Slice twists --- */
    //<s> /* S2 = S3-3 */
    $alg = preg_replace("/S2UR2'/","<201>",$alg); $alg = preg_replace("/S2UR2-/","<201>",$alg);   $alg = preg_replace("/S2UR'/","<202>",$alg); $alg = preg_replace("/S2UR-/","<202>",$alg);   $alg = preg_replace("/S2UR2/","<203>",$alg);   $alg = preg_replace("/S2UR/","<204>",$alg);
    $alg = preg_replace("/S2DL2'/","<203>",$alg); $alg = preg_replace("/S2DL2-/","<203>",$alg);   $alg = preg_replace("/S2DL'/","<204>",$alg); $alg = preg_replace("/S2DL-/","<204>",$alg);   $alg = preg_replace("/S2DL2/","<201>",$alg);   $alg = preg_replace("/S2DL/","<202>",$alg);
    $alg = preg_replace("/S2UL2'/","<205>",$alg); $alg = preg_replace("/S2UL2-/","<205>",$alg);   $alg = preg_replace("/S2UL'/","<206>",$alg); $alg = preg_replace("/S2UL-/","<206>",$alg);   $alg = preg_replace("/S2UL2/","<207>",$alg);   $alg = preg_replace("/S2UL/","<208>",$alg);
    $alg = preg_replace("/S2DR2'/","<207>",$alg); $alg = preg_replace("/S2DR2-/","<207>",$alg);   $alg = preg_replace("/S2DR'/","<208>",$alg); $alg = preg_replace("/S2DR-/","<208>",$alg);   $alg = preg_replace("/S2DR2/","<205>",$alg);   $alg = preg_replace("/S2DR/","<206>",$alg);
    $alg = preg_replace("/S2BL2'/","<211>",$alg); $alg = preg_replace("/S2BL2-/","<211>",$alg);   $alg = preg_replace("/S2BL'/","<212>",$alg); $alg = preg_replace("/S2BL-/","<212>",$alg);   $alg = preg_replace("/S2BL2/","<209>",$alg);   $alg = preg_replace("/S2BL/","<210>",$alg);
    $alg = preg_replace("/S2BR2'/","<215>",$alg); $alg = preg_replace("/S2BR2-/","<215>",$alg);   $alg = preg_replace("/S2BR'/","<216>",$alg); $alg = preg_replace("/S2BR-/","<216>",$alg);   $alg = preg_replace("/S2BR2/","<213>",$alg);   $alg = preg_replace("/S2BR/","<214>",$alg);
    
    $alg = preg_replace("/S2R2'/", "<209>",$alg); $alg = preg_replace("/S2R2-/", "<209>",$alg);   $alg = preg_replace("/S2R'/", "<210>",$alg); $alg = preg_replace("/S2R-/", "<210>",$alg);   $alg = preg_replace("/S2R2/", "<211>",$alg);   $alg = preg_replace("/S2R/", "<212>",$alg);
    $alg = preg_replace("/S2L2'/", "<213>",$alg); $alg = preg_replace("/S2L2-/", "<213>",$alg);   $alg = preg_replace("/S2L'/", "<214>",$alg); $alg = preg_replace("/S2L-/", "<214>",$alg);   $alg = preg_replace("/S2L2/", "<215>",$alg);   $alg = preg_replace("/S2L/", "<216>",$alg);
    $alg = preg_replace("/S2F2'/", "<217>",$alg); $alg = preg_replace("/S2F2-/", "<217>",$alg);   $alg = preg_replace("/S2F'/", "<218>",$alg); $alg = preg_replace("/S2F-/", "<218>",$alg);   $alg = preg_replace("/S2F2/", "<219>",$alg);   $alg = preg_replace("/S2F/", "<220>",$alg);
    $alg = preg_replace("/S2B2'/", "<219>",$alg); $alg = preg_replace("/S2B2-/", "<219>",$alg);   $alg = preg_replace("/S2B'/", "<220>",$alg); $alg = preg_replace("/S2B-/", "<220>",$alg);   $alg = preg_replace("/S2B2/", "<217>",$alg);   $alg = preg_replace("/S2B/", "<218>",$alg);
    $alg = preg_replace("/S2U2'/", "<221>",$alg); $alg = preg_replace("/S2U2-/", "<221>",$alg);   $alg = preg_replace("/S2U'/", "<222>",$alg); $alg = preg_replace("/S2U-/", "<222>",$alg);   $alg = preg_replace("/S2U2/", "<223>",$alg);   $alg = preg_replace("/S2U/", "<224>",$alg);
    $alg = preg_replace("/S2D2'/", "<223>",$alg); $alg = preg_replace("/S2D2-/", "<223>",$alg);   $alg = preg_replace("/S2D'/", "<224>",$alg); $alg = preg_replace("/S2D-/", "<224>",$alg);   $alg = preg_replace("/S2D2/", "<221>",$alg);   $alg = preg_replace("/S2D/", "<222>",$alg);
    
    
    $alg = preg_replace("/S3-3UR2'/","<201>",$alg); $alg = preg_replace("/S3-3UR2-/","<201>",$alg);   $alg = preg_replace("/S3-3UR'/","<202>",$alg); $alg = preg_replace("/S3-3UR-/","<202>",$alg);   $alg = preg_replace("/S3-3UR2/","<203>",$alg);   $alg = preg_replace("/S3-3UR/","<204>",$alg);
    $alg = preg_replace("/S3-3DL2'/","<203>",$alg); $alg = preg_replace("/S3-3DL2-/","<203>",$alg);   $alg = preg_replace("/S3-3DL'/","<204>",$alg); $alg = preg_replace("/S3-3DL-/","<204>",$alg);   $alg = preg_replace("/S3-3DL2/","<201>",$alg);   $alg = preg_replace("/S3-3DL/","<202>",$alg);
    $alg = preg_replace("/S3-3UL2'/","<205>",$alg); $alg = preg_replace("/S3-3UL2-/","<205>",$alg);   $alg = preg_replace("/S3-3UL'/","<206>",$alg); $alg = preg_replace("/S3-3UL-/","<206>",$alg);   $alg = preg_replace("/S3-3UL2/","<207>",$alg);   $alg = preg_replace("/S3-3UL/","<208>",$alg);
    $alg = preg_replace("/S3-3DR2'/","<207>",$alg); $alg = preg_replace("/S3-3DR2-/","<207>",$alg);   $alg = preg_replace("/S3-3DR'/","<208>",$alg); $alg = preg_replace("/S3-3DR-/","<208>",$alg);   $alg = preg_replace("/S3-3DR2/","<205>",$alg);   $alg = preg_replace("/S3-3DR/","<206>",$alg);
    $alg = preg_replace("/S3-3BL2'/","<211>",$alg); $alg = preg_replace("/S3-3BL2-/","<211>",$alg);   $alg = preg_replace("/S3-3BL'/","<212>",$alg); $alg = preg_replace("/S3-3BL-/","<212>",$alg);   $alg = preg_replace("/S3-3BL2/","<209>",$alg);   $alg = preg_replace("/S3-3BL/","<210>",$alg);
    $alg = preg_replace("/S3-3BR2'/","<215>",$alg); $alg = preg_replace("/S3-3BR2-/","<215>",$alg);   $alg = preg_replace("/S3-3BR'/","<216>",$alg); $alg = preg_replace("/S3-3BR-/","<216>",$alg);   $alg = preg_replace("/S3-3BR2/","<213>",$alg);   $alg = preg_replace("/S3-3BR/","<214>",$alg);
    
    $alg = preg_replace("/S3-3R2'/", "<209>",$alg); $alg = preg_replace("/S3-3R2-/", "<209>",$alg);   $alg = preg_replace("/S3-3R'/", "<210>",$alg); $alg = preg_replace("/S3-3R-/", "<210>",$alg);   $alg = preg_replace("/S3-3R2/", "<211>",$alg);   $alg = preg_replace("/S3-3R/", "<212>",$alg);
    $alg = preg_replace("/S3-3L2'/", "<213>",$alg); $alg = preg_replace("/S3-3L2-/", "<213>",$alg);   $alg = preg_replace("/S3-3L'/", "<214>",$alg); $alg = preg_replace("/S3-3L-/", "<214>",$alg);   $alg = preg_replace("/S3-3L2/", "<215>",$alg);   $alg = preg_replace("/S3-3L/", "<216>",$alg);
    $alg = preg_replace("/S3-3F2'/", "<217>",$alg); $alg = preg_replace("/S3-3F2-/", "<217>",$alg);   $alg = preg_replace("/S3-3F'/", "<218>",$alg); $alg = preg_replace("/S3-3F-/", "<218>",$alg);   $alg = preg_replace("/S3-3F2/", "<219>",$alg);   $alg = preg_replace("/S3-3F/", "<220>",$alg);
    $alg = preg_replace("/S3-3B2'/", "<219>",$alg); $alg = preg_replace("/S3-3B2-/", "<219>",$alg);   $alg = preg_replace("/S3-3B'/", "<220>",$alg); $alg = preg_replace("/S3-3B-/", "<220>",$alg);   $alg = preg_replace("/S3-3B2/", "<217>",$alg);   $alg = preg_replace("/S3-3B/", "<218>",$alg);
    $alg = preg_replace("/S3-3U2'/", "<221>",$alg); $alg = preg_replace("/S3-3U2-/", "<221>",$alg);   $alg = preg_replace("/S3-3U'/", "<222>",$alg); $alg = preg_replace("/S3-3U-/", "<222>",$alg);   $alg = preg_replace("/S3-3U2/", "<223>",$alg);   $alg = preg_replace("/S3-3U/", "<224>",$alg);
    $alg = preg_replace("/S3-3D2'/", "<223>",$alg); $alg = preg_replace("/S3-3D2-/", "<223>",$alg);   $alg = preg_replace("/S3-3D'/", "<224>",$alg); $alg = preg_replace("/S3-3D-/", "<224>",$alg);   $alg = preg_replace("/S3-3D2/", "<221>",$alg);   $alg = preg_replace("/S3-3D/", "<222>",$alg);
    
    
    //<s> /* S = S2-4 */
    $alg = preg_replace("/SUR2'/","<225>",$alg); $alg = preg_replace("/SUR2-/","<225>",$alg);   $alg = preg_replace("/SUR'/","<226>",$alg); $alg = preg_replace("/SUR-/","<226>",$alg);   $alg = preg_replace("/SUR2/","<227>",$alg);   $alg = preg_replace("/SUR/","<228>",$alg);
    $alg = preg_replace("/SDL2'/","<227>",$alg); $alg = preg_replace("/SDL2-/","<227>",$alg);   $alg = preg_replace("/SDL'/","<228>",$alg); $alg = preg_replace("/SDL-/","<228>",$alg);   $alg = preg_replace("/SDL2/","<225>",$alg);   $alg = preg_replace("/SDL/","<226>",$alg);
    $alg = preg_replace("/SUL2'/","<229>",$alg); $alg = preg_replace("/SUL2-/","<229>",$alg);   $alg = preg_replace("/SUL'/","<230>",$alg); $alg = preg_replace("/SUL-/","<230>",$alg);   $alg = preg_replace("/SUL2/","<231>",$alg);   $alg = preg_replace("/SUL/","<232>",$alg);
    $alg = preg_replace("/SDR2'/","<231>",$alg); $alg = preg_replace("/SDR2-/","<231>",$alg);   $alg = preg_replace("/SDR'/","<232>",$alg); $alg = preg_replace("/SDR-/","<232>",$alg);   $alg = preg_replace("/SDR2/","<229>",$alg);   $alg = preg_replace("/SDR/","<230>",$alg);
    $alg = preg_replace("/SBL2'/","<235>",$alg); $alg = preg_replace("/SBL2-/","<235>",$alg);   $alg = preg_replace("/SBL'/","<236>",$alg); $alg = preg_replace("/SBL-/","<237>",$alg);   $alg = preg_replace("/SBL2/","<233>",$alg);   $alg = preg_replace("/SBL/","<234>",$alg);
    $alg = preg_replace("/SBR2'/","<239>",$alg); $alg = preg_replace("/SBR2-/","<239>",$alg);   $alg = preg_replace("/SBR'/","<240>",$alg); $alg = preg_replace("/SBR-/","<240>",$alg);   $alg = preg_replace("/SBR2/","<237>",$alg);   $alg = preg_replace("/SBR/","<238>",$alg);
    
    $alg = preg_replace("/SR2'/", "<233>",$alg); $alg = preg_replace("/SR2-/", "<233>",$alg);   $alg = preg_replace("/SR'/", "<234>",$alg); $alg = preg_replace("/SR-/", "<234>",$alg);   $alg = preg_replace("/SR2/", "<235>",$alg);   $alg = preg_replace("/SR/", "<236>",$alg);
    $alg = preg_replace("/SL2'/", "<237>",$alg); $alg = preg_replace("/SL2-/", "<237>",$alg);   $alg = preg_replace("/SL'/", "<238>",$alg); $alg = preg_replace("/SL-/", "<238>",$alg);   $alg = preg_replace("/SL2/", "<239>",$alg);   $alg = preg_replace("/SL/", "<240>",$alg);
    $alg = preg_replace("/SF2'/", "<241>",$alg); $alg = preg_replace("/SF2-/", "<241>",$alg);   $alg = preg_replace("/SF'/", "<242>",$alg); $alg = preg_replace("/SF-/", "<242>",$alg);   $alg = preg_replace("/SF2/", "<243>",$alg);   $alg = preg_replace("/SF/", "<244>",$alg);
    $alg = preg_replace("/SB2'/", "<243>",$alg); $alg = preg_replace("/SB2-/", "<243>",$alg);   $alg = preg_replace("/SB'/", "<244>",$alg); $alg = preg_replace("/SB-/", "<244>",$alg);   $alg = preg_replace("/SB2/", "<241>",$alg);   $alg = preg_replace("/SB/", "<242>",$alg);
    $alg = preg_replace("/SU2'/", "<245>",$alg); $alg = preg_replace("/SU2-/", "<245>",$alg);   $alg = preg_replace("/SU'/", "<246>",$alg); $alg = preg_replace("/SU-/", "<246>",$alg);   $alg = preg_replace("/SU2/", "<247>",$alg);   $alg = preg_replace("/SU/", "<248>",$alg);
    $alg = preg_replace("/SD2'/", "<247>",$alg); $alg = preg_replace("/SD2-/", "<247>",$alg);   $alg = preg_replace("/SD'/", "<248>",$alg); $alg = preg_replace("/SD-/", "<248>",$alg);   $alg = preg_replace("/SD2/", "<245>",$alg);   $alg = preg_replace("/SD/", "<246>",$alg);
    
    
    $alg = preg_replace("/S2-4UR2'/","<225>",$alg); $alg = preg_replace("/S2-4UR2-/","<225>",$alg);   $alg = preg_replace("/S2-4UR'/","<226>",$alg); $alg = preg_replace("/S2-4UR-/","<226>",$alg);   $alg = preg_replace("/S2-4UR2/","<227>",$alg);   $alg = preg_replace("/S2-4UR/","<228>",$alg);
    $alg = preg_replace("/S2-4DL2'/","<227>",$alg); $alg = preg_replace("/S2-4DL2-/","<227>",$alg);   $alg = preg_replace("/S2-4DL'/","<228>",$alg); $alg = preg_replace("/S2-4DL-/","<228>",$alg);   $alg = preg_replace("/S2-4DL2/","<225>",$alg);   $alg = preg_replace("/S2-4DL/","<226>",$alg);
    $alg = preg_replace("/S2-4UL2'/","<229>",$alg); $alg = preg_replace("/S2-4UL2-/","<229>",$alg);   $alg = preg_replace("/S2-4UL'/","<230>",$alg); $alg = preg_replace("/S2-4UL-/","<230>",$alg);   $alg = preg_replace("/S2-4UL2/","<231>",$alg);   $alg = preg_replace("/S2-4UL/","<232>",$alg);
    $alg = preg_replace("/S2-4DR2'/","<231>",$alg); $alg = preg_replace("/S2-4DR2-/","<231>",$alg);   $alg = preg_replace("/S2-4DR'/","<232>",$alg); $alg = preg_replace("/S2-4DR-/","<232>",$alg);   $alg = preg_replace("/S2-4DR2/","<229>",$alg);   $alg = preg_replace("/S2-4DR/","<230>",$alg);
    $alg = preg_replace("/S2-4BL2'/","<235>",$alg); $alg = preg_replace("/S2-4BL2-/","<235>",$alg);   $alg = preg_replace("/S2-4BL'/","<236>",$alg); $alg = preg_replace("/S2-4BL-/","<237>",$alg);   $alg = preg_replace("/S2-4BL2/","<233>",$alg);   $alg = preg_replace("/S2-4BL/","<234>",$alg);
    $alg = preg_replace("/S2-4BR2'/","<239>",$alg); $alg = preg_replace("/S2-4BR2-/","<239>",$alg);   $alg = preg_replace("/S2-4BR'/","<240>",$alg); $alg = preg_replace("/S2-4BR-/","<240>",$alg);   $alg = preg_replace("/S2-4BR2/","<237>",$alg);   $alg = preg_replace("/S2-4BR/","<238>",$alg);
    
    $alg = preg_replace("/S2-4R2'/", "<233>",$alg); $alg = preg_replace("/S2-4R2-/", "<233>",$alg);   $alg = preg_replace("/S2-4R'/", "<234>",$alg); $alg = preg_replace("/S2-4R-/", "<234>",$alg);   $alg = preg_replace("/S2-4R2/", "<235>",$alg);   $alg = preg_replace("/S2-4R/", "<236>",$alg);
    $alg = preg_replace("/S2-4L2'/", "<237>",$alg); $alg = preg_replace("/S2-4L2-/", "<237>",$alg);   $alg = preg_replace("/S2-4L'/", "<238>",$alg); $alg = preg_replace("/S2-4L-/", "<238>",$alg);   $alg = preg_replace("/S2-4L2/", "<239>",$alg);   $alg = preg_replace("/S2-4L/", "<240>",$alg);
    $alg = preg_replace("/S2-4F2'/", "<241>",$alg); $alg = preg_replace("/S2-4F2-/", "<241>",$alg);   $alg = preg_replace("/S2-4F'/", "<242>",$alg); $alg = preg_replace("/S2-4F-/", "<242>",$alg);   $alg = preg_replace("/S2-4F2/", "<243>",$alg);   $alg = preg_replace("/S2-4F/", "<244>",$alg);
    $alg = preg_replace("/S2-4B2'/", "<243>",$alg); $alg = preg_replace("/S2-4B2-/", "<243>",$alg);   $alg = preg_replace("/S2-4B'/", "<244>",$alg); $alg = preg_replace("/S2-4B-/", "<244>",$alg);   $alg = preg_replace("/S2-4B2/", "<241>",$alg);   $alg = preg_replace("/S2-4B/", "<242>",$alg);
    $alg = preg_replace("/S2-4U2'/", "<245>",$alg); $alg = preg_replace("/S2-4U2-/", "<245>",$alg);   $alg = preg_replace("/S2-4U'/", "<246>",$alg); $alg = preg_replace("/S2-4U-/", "<246>",$alg);   $alg = preg_replace("/S2-4U2/", "<247>",$alg);   $alg = preg_replace("/S2-4U/", "<248>",$alg);
    $alg = preg_replace("/S2-4D2'/", "<247>",$alg); $alg = preg_replace("/S2-4D2-/", "<247>",$alg);   $alg = preg_replace("/S2-4D'/", "<248>",$alg); $alg = preg_replace("/S2-4D-/", "<248>",$alg);   $alg = preg_replace("/S2-4D2/", "<245>",$alg);   $alg = preg_replace("/S2-4D/", "<246>",$alg);
    
    
    /* S2-2 | S4-4 */
    $alg = preg_replace("/S2-2UR2'/","<249>",$alg); $alg = preg_replace("/S2-2UR2-/","<249>",$alg);   $alg = preg_replace("/S2-2UR'/","<250>",$alg); $alg = preg_replace("/S2-2UR-/","<250>",$alg);   $alg = preg_replace("/S2-2UR2/","<251>",$alg);   $alg = preg_replace("/S2-2UR/","<252>",$alg);
    $alg = preg_replace("/S2-2DL2'/","<253>",$alg); $alg = preg_replace("/S2-2DL2-/","<253>",$alg);   $alg = preg_replace("/S2-2DL'/","<254>",$alg); $alg = preg_replace("/S2-2DL-/","<254>",$alg);   $alg = preg_replace("/S2-2DL2/","<255>",$alg);   $alg = preg_replace("/S2-2DL/","<256>",$alg);
    $alg = preg_replace("/S2-2UL2'/","<257>",$alg); $alg = preg_replace("/S2-2UL2-/","<257>",$alg);   $alg = preg_replace("/S2-2UL'/","<258>",$alg); $alg = preg_replace("/S2-2UL-/","<258>",$alg);   $alg = preg_replace("/S2-2UL2/","<259>",$alg);   $alg = preg_replace("/S2-2UL/","<260>",$alg);
    $alg = preg_replace("/S2-2DR2'/","<261>",$alg); $alg = preg_replace("/S2-2DR2-/","<261>",$alg);   $alg = preg_replace("/S2-2DR'/","<262>",$alg); $alg = preg_replace("/S2-2DR-/","<262>",$alg);   $alg = preg_replace("/S2-2DR2/","<263>",$alg);   $alg = preg_replace("/S2-2DR/","<264>",$alg);
    $alg = preg_replace("/S2-2BL2'/","<269>",$alg); $alg = preg_replace("/S2-2BL2-/","<269>",$alg);   $alg = preg_replace("/S2-2BL'/","<270>",$alg); $alg = preg_replace("/S2-2BL-/","<270>",$alg);   $alg = preg_replace("/S2-2BL2/","<271>",$alg);   $alg = preg_replace("/S2-2BL/","<272>",$alg);
    $alg = preg_replace("/S2-2BR2'/","<277>",$alg); $alg = preg_replace("/S2-2BR2-/","<277>",$alg);   $alg = preg_replace("/S2-2BR'/","<278>",$alg); $alg = preg_replace("/S2-2BR-/","<278>",$alg);   $alg = preg_replace("/S2-2BR2/","<279>",$alg);   $alg = preg_replace("/S2-2BR/","<280>",$alg);
    
    $alg = preg_replace("/S2-2R2'/", "<265>",$alg); $alg = preg_replace("/S2-2R2-/", "<265>",$alg);   $alg = preg_replace("/S2-2R'/", "<266>",$alg); $alg = preg_replace("/S2-2R-/", "<266>",$alg);   $alg = preg_replace("/S2-2R2/", "<267>",$alg);   $alg = preg_replace("/S2-2R/", "<268>",$alg);
    $alg = preg_replace("/S2-2L2'/", "<273>",$alg); $alg = preg_replace("/S2-2L2-/", "<273>",$alg);   $alg = preg_replace("/S2-2L'/", "<274>",$alg); $alg = preg_replace("/S2-2L-/", "<274>",$alg);   $alg = preg_replace("/S2-2L2/", "<275>",$alg);   $alg = preg_replace("/S2-2L/", "<276>",$alg);
    $alg = preg_replace("/S2-2F2'/", "<281>",$alg); $alg = preg_replace("/S2-2F2-/", "<281>",$alg);   $alg = preg_replace("/S2-2F'/", "<282>",$alg); $alg = preg_replace("/S2-2F-/", "<282>",$alg);   $alg = preg_replace("/S2-2F2/", "<283>",$alg);   $alg = preg_replace("/S2-2F/", "<284>",$alg);
    $alg = preg_replace("/S2-2B2'/", "<285>",$alg); $alg = preg_replace("/S2-2B2-/", "<285>",$alg);   $alg = preg_replace("/S2-2B'/", "<286>",$alg); $alg = preg_replace("/S2-2B-/", "<286>",$alg);   $alg = preg_replace("/S2-2B2/", "<287>",$alg);   $alg = preg_replace("/S2-2B/", "<288>",$alg);
    $alg = preg_replace("/S2-2U2'/", "<289>",$alg); $alg = preg_replace("/S2-2U2-/", "<289>",$alg);   $alg = preg_replace("/S2-2U'/", "<290>",$alg); $alg = preg_replace("/S2-2U-/", "<290>",$alg);   $alg = preg_replace("/S2-2U2/", "<291>",$alg);   $alg = preg_replace("/S2-2U/", "<292>",$alg);
    $alg = preg_replace("/S2-2D2'/", "<293>",$alg); $alg = preg_replace("/S2-2D2-/", "<293>",$alg);   $alg = preg_replace("/S2-2D'/", "<294>",$alg); $alg = preg_replace("/S2-2D-/", "<294>",$alg);   $alg = preg_replace("/S2-2D2/", "<295>",$alg);   $alg = preg_replace("/S2-2D/", "<296>",$alg);
    
    
    $alg = preg_replace("/S4-4UR2'/","<255>",$alg); $alg = preg_replace("/S4-4UR2-/","<255>",$alg);   $alg = preg_replace("/S4-4UR'/","<256>",$alg); $alg = preg_replace("/S4-4UR-/","<256>",$alg);   $alg = preg_replace("/S4-4UR2/","<253>",$alg);   $alg = preg_replace("/S4-4UR/","<254>",$alg);
    $alg = preg_replace("/S4-4DL2'/","<251>",$alg); $alg = preg_replace("/S4-4DL2-/","<251>",$alg);   $alg = preg_replace("/S4-4DL'/","<252>",$alg); $alg = preg_replace("/S4-4DL-/","<252>",$alg);   $alg = preg_replace("/S4-4DL2/","<249>",$alg);   $alg = preg_replace("/S4-4DL/","<250>",$alg);
    $alg = preg_replace("/S4-4UL2'/","<263>",$alg); $alg = preg_replace("/S4-4UL2-/","<263>",$alg);   $alg = preg_replace("/S4-4UL'/","<264>",$alg); $alg = preg_replace("/S4-4UL-/","<264>",$alg);   $alg = preg_replace("/S4-4UL2/","<261>",$alg);   $alg = preg_replace("/S4-4UL/","<262>",$alg);
    $alg = preg_replace("/S4-4DR2'/","<259>",$alg); $alg = preg_replace("/S4-4DR2-/","<259>",$alg);   $alg = preg_replace("/S4-4DR'/","<260>",$alg); $alg = preg_replace("/S4-4DR-/","<260>",$alg);   $alg = preg_replace("/S4-4DR2/","<257>",$alg);   $alg = preg_replace("/S4-4DR/","<258>",$alg);
    $alg = preg_replace("/S4-4BL2'/","<267>",$alg); $alg = preg_replace("/S4-4BL2-/","<267>",$alg);   $alg = preg_replace("/S4-4BL'/","<268>",$alg); $alg = preg_replace("/S4-4BL-/","<268>",$alg);   $alg = preg_replace("/S4-4BL2/","<265>",$alg);   $alg = preg_replace("/S4-4BL/","<266>",$alg);
    $alg = preg_replace("/S4-4BR2'/","<275>",$alg); $alg = preg_replace("/S4-4BR2-/","<275>",$alg);   $alg = preg_replace("/S4-4BR'/","<276>",$alg); $alg = preg_replace("/S4-4BR-/","<276>",$alg);   $alg = preg_replace("/S4-4BR2/","<273>",$alg);   $alg = preg_replace("/S4-4BR/","<274>",$alg);
    
    $alg = preg_replace("/S4-4R2'/", "<271>",$alg); $alg = preg_replace("/S4-4R2-/", "<271>",$alg);   $alg = preg_replace("/S4-4R'/", "<272>",$alg); $alg = preg_replace("/S4-4R-/", "<272>",$alg);   $alg = preg_replace("/S4-4R2/", "<269>",$alg);   $alg = preg_replace("/S4-4R/", "<270>",$alg);
    $alg = preg_replace("/S4-4L2'/", "<279>",$alg); $alg = preg_replace("/S4-4L2-/", "<279>",$alg);   $alg = preg_replace("/S4-4L'/", "<280>",$alg); $alg = preg_replace("/S4-4L-/", "<280>",$alg);   $alg = preg_replace("/S4-4L2/", "<277>",$alg);   $alg = preg_replace("/S4-4L/", "<278>",$alg);
    $alg = preg_replace("/S4-4F2'/", "<287>",$alg); $alg = preg_replace("/S4-4F2-/", "<287>",$alg);   $alg = preg_replace("/S4-4F'/", "<288>",$alg); $alg = preg_replace("/S4-4F-/", "<288>",$alg);   $alg = preg_replace("/S4-4F2/", "<285>",$alg);   $alg = preg_replace("/S4-4F/", "<286>",$alg);
    $alg = preg_replace("/S4-4B2'/", "<283>",$alg); $alg = preg_replace("/S4-4B2-/", "<283>",$alg);   $alg = preg_replace("/S4-4B'/", "<284>",$alg); $alg = preg_replace("/S4-4B-/", "<284>",$alg);   $alg = preg_replace("/S4-4B2/", "<281>",$alg);   $alg = preg_replace("/S4-4B/", "<282>",$alg);
    $alg = preg_replace("/S4-4U2'/", "<295>",$alg); $alg = preg_replace("/S4-4U2-/", "<295>",$alg);   $alg = preg_replace("/S4-4U'/", "<296>",$alg); $alg = preg_replace("/S4-4U-/", "<296>",$alg);   $alg = preg_replace("/S4-4U2/", "<293>",$alg);   $alg = preg_replace("/S4-4U/", "<294>",$alg);
    $alg = preg_replace("/S4-4D2'/", "<291>",$alg); $alg = preg_replace("/S4-4D2-/", "<291>",$alg);   $alg = preg_replace("/S4-4D'/", "<292>",$alg); $alg = preg_replace("/S4-4D-/", "<292>",$alg);   $alg = preg_replace("/S4-4D2/", "<289>",$alg);   $alg = preg_replace("/S4-4D/", "<290>",$alg);
    
    
    //<s> /* S2-3 | S3-4 */
    $alg = preg_replace("/S2-3UR2'/", "<297>",$alg); $alg = preg_replace("/S2-3UR2-/", "<297>",$alg);   $alg = preg_replace("/S2-3UR'/", "<298>",$alg); $alg = preg_replace("/S2-3UR-/", "<298>",$alg);   $alg = preg_replace("/S2-3UR2/", "<299>",$alg);   $alg = preg_replace("/S2-3UR/","<2100>",$alg);
    $alg = preg_replace("/S2-3DL2'/","<2101>",$alg); $alg = preg_replace("/S2-3DL2-/","<2101>",$alg);   $alg = preg_replace("/S2-3DL'/","<2102>",$alg); $alg = preg_replace("/S2-3DL-/","<2102>",$alg);   $alg = preg_replace("/S2-3DL2/","<2103>",$alg);   $alg = preg_replace("/S2-3DL/","<2104>",$alg);
    $alg = preg_replace("/S2-3UL2'/","<2105>",$alg); $alg = preg_replace("/S2-3UL2-/","<2105>",$alg);   $alg = preg_replace("/S2-3UL'/","<2106>",$alg); $alg = preg_replace("/S2-3UL-/","<2106>",$alg);   $alg = preg_replace("/S2-3UL2/","<2107>",$alg);   $alg = preg_replace("/S2-3UL/","<2108>",$alg);
    $alg = preg_replace("/S2-3DR2'/","<2109>",$alg); $alg = preg_replace("/S2-3DR2-/","<2109>",$alg);   $alg = preg_replace("/S2-3DR'/","<2110>",$alg); $alg = preg_replace("/S2-3DR-/","<2110>",$alg);   $alg = preg_replace("/S2-3DR2/","<2111>",$alg);   $alg = preg_replace("/S2-3DR/","<2112>",$alg);
    $alg = preg_replace("/S2-3BL2'/","<2117>",$alg); $alg = preg_replace("/S2-3BL2-/","<2117>",$alg);   $alg = preg_replace("/S2-3BL'/","<2118>",$alg); $alg = preg_replace("/S2-3BL-/","<2118>",$alg);   $alg = preg_replace("/S2-3BL2/","<2119>",$alg);   $alg = preg_replace("/S2-3BL/","<2120>",$alg);
    $alg = preg_replace("/S2-3BR2'/","<2125>",$alg); $alg = preg_replace("/S2-3BR2-/","<2125>",$alg);   $alg = preg_replace("/S2-3BR'/","<2126>",$alg); $alg = preg_replace("/S2-3BR-/","<2126>",$alg);   $alg = preg_replace("/S2-3BR2/","<2127>",$alg);   $alg = preg_replace("/S2-3BR/","<2128>",$alg);
    
    $alg = preg_replace("/S2-3R2'/","<2113>",$alg); $alg = preg_replace("/S2-3R2-/","<2113>",$alg);     $alg = preg_replace("/S2-3R'/","<2114>",$alg);  $alg = preg_replace("/S2-3R-/","<2114>",$alg);    $alg = preg_replace("/S2-3R2/","<2115>",$alg);    $alg = preg_replace("/S2-3R/","<2116>",$alg);
    $alg = preg_replace("/S2-3L2'/","<2121>",$alg); $alg = preg_replace("/S2-3L2-/","<2121>",$alg);     $alg = preg_replace("/S2-3L'/","<2122>",$alg);  $alg = preg_replace("/S2-3L-/","<2122>",$alg);    $alg = preg_replace("/S2-3L2/","<2123>",$alg);    $alg = preg_replace("/S2-3L/","<2124>",$alg);
    $alg = preg_replace("/S2-3F2'/","<2129>",$alg); $alg = preg_replace("/S2-3F2-/","<2129>",$alg);     $alg = preg_replace("/S2-3F'/","<2130>",$alg);  $alg = preg_replace("/S2-3F-/","<2130>",$alg);    $alg = preg_replace("/S2-3F2/","<2131>",$alg);    $alg = preg_replace("/S2-3F/","<2132>",$alg);
    $alg = preg_replace("/S2-3B2'/","<2133>",$alg); $alg = preg_replace("/S2-3B2-/","<2133>",$alg);     $alg = preg_replace("/S2-3B'/","<2134>",$alg);  $alg = preg_replace("/S2-3B-/","<2134>",$alg);    $alg = preg_replace("/S2-3B2/","<2135>",$alg);    $alg = preg_replace("/S2-3B/","<2136>",$alg);
    $alg = preg_replace("/S2-3U2'/","<2137>",$alg); $alg = preg_replace("/S2-3U2-/","<2137>",$alg);     $alg = preg_replace("/S2-3U'/","<2138>",$alg);  $alg = preg_replace("/S2-3U-/","<2138>",$alg);    $alg = preg_replace("/S2-3U2/","<2139>",$alg);    $alg = preg_replace("/S2-3U/","<2140>",$alg);
    $alg = preg_replace("/S2-3D2'/","<2141>",$alg); $alg = preg_replace("/S2-3D2-/","<2141>",$alg);     $alg = preg_replace("/S2-3D'/","<2142>",$alg);  $alg = preg_replace("/S2-3D-/","<2142>",$alg);    $alg = preg_replace("/S2-3D2/","<2143>",$alg);    $alg = preg_replace("/S2-3D/","<2144>",$alg);
    
    
    $alg = preg_replace("/S3-4UR2'/","<2103>",$alg); $alg = preg_replace("/S3-4UR2-/","<2103>",$alg);   $alg = preg_replace("/S3-4UR'/","<2104>",$alg); $alg = preg_replace("/S3-4UR-/","<2104>",$alg);   $alg = preg_replace("/S3-4UR2/","<2101>",$alg);   $alg = preg_replace("/S3-4UR/","<2102>",$alg);
    $alg = preg_replace("/S3-4DL2'/", "<299>",$alg); $alg = preg_replace("/S3-4DL2-/", "<299>",$alg);   $alg = preg_replace("/S3-4DL'/","<2100>",$alg); $alg = preg_replace("/S3-4DL-/","<2100>",$alg);   $alg = preg_replace("/S3-4DL2/", "<297>",$alg);   $alg = preg_replace("/S3-4DL/", "<298>",$alg);
    $alg = preg_replace("/S3-4UL2'/","<2111>",$alg); $alg = preg_replace("/S3-4UL2-/","<2111>",$alg);   $alg = preg_replace("/S3-4UL'/","<2112>",$alg); $alg = preg_replace("/S3-4UL-/","<2112>",$alg);   $alg = preg_replace("/S3-4UL2/","<2109>",$alg);   $alg = preg_replace("/S3-4UL/","<2110>",$alg);
    $alg = preg_replace("/S3-4DR2'/","<2107>",$alg); $alg = preg_replace("/S3-4DR2-/","<2107>",$alg);   $alg = preg_replace("/S3-4DR'/","<2108>",$alg); $alg = preg_replace("/S3-4DR-/","<2108>",$alg);   $alg = preg_replace("/S3-4DR2/","<2105>",$alg);   $alg = preg_replace("/S3-4DR/","<2106>",$alg);
    $alg = preg_replace("/S3-4BL2'/","<2115>",$alg); $alg = preg_replace("/S3-4BL2-/","<2115>",$alg);   $alg = preg_replace("/S3-4BL'/","<2116>",$alg); $alg = preg_replace("/S3-4BL-/","<2116>",$alg);   $alg = preg_replace("/S3-4BL2/","<2113>",$alg);   $alg = preg_replace("/S3-4BL/","<2114>",$alg);
    $alg = preg_replace("/S3-4BR2'/","<2123>",$alg); $alg = preg_replace("/S3-4BR2-/","<2123>",$alg);   $alg = preg_replace("/S3-4BR'/","<2124>",$alg); $alg = preg_replace("/S3-4BR-/","<2124>",$alg);   $alg = preg_replace("/S3-4BR2/","<2121>",$alg);   $alg = preg_replace("/S3-4BR/","<2122>",$alg);
    
    $alg = preg_replace("/S3-4R2'/", "<2119>",$alg); $alg = preg_replace("/S3-4R2-/", "<2119>",$alg);   $alg = preg_replace("/S3-4R'/", "<2120>",$alg); $alg = preg_replace("/S3-4R-/", "<2120>",$alg);   $alg = preg_replace("/S3-4R2/", "<2117>",$alg);   $alg = preg_replace("/S3-4R/", "<2118>",$alg);
    $alg = preg_replace("/S3-4L2'/", "<2127>",$alg); $alg = preg_replace("/S3-4L2-/", "<2127>",$alg);   $alg = preg_replace("/S3-4L'/", "<2128>",$alg); $alg = preg_replace("/S3-4L-/", "<2128>",$alg);   $alg = preg_replace("/S3-4L2/", "<2223>",$alg);   $alg = preg_replace("/S3-4L/", "<2224>",$alg);
    $alg = preg_replace("/S3-4F2'/", "<2135>",$alg); $alg = preg_replace("/S3-4F2-/", "<2135>",$alg);   $alg = preg_replace("/S3-4F'/", "<2136>",$alg); $alg = preg_replace("/S3-4F-/", "<2136>",$alg);   $alg = preg_replace("/S3-4F2/","<2133>", $alg);   $alg = preg_replace("/S3-4F/", "<2134>",$alg);
    $alg = preg_replace("/S3-4B2'/", "<2131>",$alg); $alg = preg_replace("/S3-4B2-/", "<2131>",$alg);   $alg = preg_replace("/S3-4B'/", "<2132>",$alg); $alg = preg_replace("/S3-4B-/", "<2132>",$alg);   $alg = preg_replace("/S3-4B2/","<2129>", $alg);   $alg = preg_replace("/S3-4B/", "<2130>",$alg);
    $alg = preg_replace("/S3-4U2'/", "<2143>",$alg); $alg = preg_replace("/S3-4U2-/", "<2143>",$alg);   $alg = preg_replace("/S3-4U'/", "<2144>",$alg); $alg = preg_replace("/S3-4U-/", "<2144>",$alg);   $alg = preg_replace("/S3-4U2/","<2141>", $alg);   $alg = preg_replace("/S3-4U/", "<2142>",$alg);
    $alg = preg_replace("/S3-4D2'/", "<2139>",$alg); $alg = preg_replace("/S3-4D2-/", "<2139>",$alg);   $alg = preg_replace("/S3-4D'/", "<2140>",$alg); $alg = preg_replace("/S3-4D-/", "<2140>",$alg);   $alg = preg_replace("/S3-4D2/","<2137>", $alg);   $alg = preg_replace("/S3-4D/", "<2138>",$alg);
    
    /* --- 5xD: SSE -> CODE: [3] Tier twists --- */
    //<s> /* T4 */
    $alg = preg_replace("/T4UR2'/","<301>",$alg); $alg = preg_replace("/T4UR2-/","<301>",$alg);   $alg = preg_replace("/T4UR'/","<302>",$alg); $alg = preg_replace("/T4UR-/","<302>",$alg);   $alg = preg_replace("/T4UR2/","<303>",$alg);   $alg = preg_replace("/T4UR/","<304>",$alg);
    $alg = preg_replace("/T4DL2'/","<305>",$alg); $alg = preg_replace("/T4DL2-/","<305>",$alg);   $alg = preg_replace("/T4DL'/","<306>",$alg); $alg = preg_replace("/T4DL-/","<306>",$alg);   $alg = preg_replace("/T4DL2/","<307>",$alg);   $alg = preg_replace("/T4DL/","<308>",$alg);
    $alg = preg_replace("/T4UL2'/","<309>",$alg); $alg = preg_replace("/T4UL2-/","<309>",$alg);   $alg = preg_replace("/T4UL'/","<310>",$alg); $alg = preg_replace("/T4UL-/","<310>",$alg);   $alg = preg_replace("/T4UL2/","<311>",$alg);   $alg = preg_replace("/T4UL/","<312>",$alg);
    $alg = preg_replace("/T4DR2'/","<313>",$alg); $alg = preg_replace("/T4DR2-/","<313>",$alg);   $alg = preg_replace("/T4DR'/","<314>",$alg); $alg = preg_replace("/T4DR-/","<314>",$alg);   $alg = preg_replace("/T4DR2/","<315>",$alg);   $alg = preg_replace("/T4DR/","<316>",$alg);
    $alg = preg_replace("/T4BL2'/","<321>",$alg); $alg = preg_replace("/T4BL2-/","<321>",$alg);   $alg = preg_replace("/T4BL'/","<322>",$alg); $alg = preg_replace("/T4BL-/","<322>",$alg);   $alg = preg_replace("/T4BL2/","<323>",$alg);   $alg = preg_replace("/T4BL/","<324>",$alg);
    $alg = preg_replace("/T4BR2'/","<329>",$alg); $alg = preg_replace("/T4BR2-/","<329>",$alg);   $alg = preg_replace("/T4BR'/","<330>",$alg); $alg = preg_replace("/T4BR-/","<330>",$alg);   $alg = preg_replace("/T4BR2/","<331>",$alg);   $alg = preg_replace("/T4BR/","<332>",$alg);
    
    $alg = preg_replace("/T4R2'/", "<317>",$alg); $alg = preg_replace("/T4R2-/", "<317>",$alg);   $alg = preg_replace("/T4R'/", "<318>",$alg); $alg = preg_replace("/T4R-/", "<318>",$alg);   $alg = preg_replace("/T4R2/", "<319>",$alg);   $alg = preg_replace("/T4R/", "<320>",$alg);
    $alg = preg_replace("/T4L2'/", "<325>",$alg); $alg = preg_replace("/T4L2-/", "<325>",$alg);   $alg = preg_replace("/T4L'/", "<326>",$alg); $alg = preg_replace("/T4L-/", "<326>",$alg);   $alg = preg_replace("/T4L2/", "<327>",$alg);   $alg = preg_replace("/T4L/", "<328>",$alg);
    $alg = preg_replace("/T4F2'/", "<333>",$alg); $alg = preg_replace("/T4F2-/", "<333>",$alg);   $alg = preg_replace("/T4F'/", "<334>",$alg); $alg = preg_replace("/T4F-/", "<334>",$alg);   $alg = preg_replace("/T4F2/", "<335>",$alg);   $alg = preg_replace("/T4F/", "<336>",$alg);
    $alg = preg_replace("/T4B2'/", "<337>",$alg); $alg = preg_replace("/T4B2-/", "<337>",$alg);   $alg = preg_replace("/T4B'/", "<338>",$alg); $alg = preg_replace("/T4B-/", "<338>",$alg);   $alg = preg_replace("/T4B2/", "<339>",$alg);   $alg = preg_replace("/T4B/", "<340>",$alg);
    $alg = preg_replace("/T4U2'/", "<341>",$alg); $alg = preg_replace("/T4U2-/", "<341>",$alg);   $alg = preg_replace("/T4U'/", "<342>",$alg); $alg = preg_replace("/T4U-/", "<342>",$alg);   $alg = preg_replace("/T4U2/", "<343>",$alg);   $alg = preg_replace("/T4U/", "<344>",$alg);
    $alg = preg_replace("/T4D2'/", "<345>",$alg); $alg = preg_replace("/T4D2-/", "<345>",$alg);   $alg = preg_replace("/T4D'/", "<346>",$alg); $alg = preg_replace("/T4D-/", "<346>",$alg);   $alg = preg_replace("/T4D2/", "<347>",$alg);   $alg = preg_replace("/T4D/", "<348>",$alg);
    
    
    //<s> /* T3 */
    $alg = preg_replace("/T3UR2'/","<349>",$alg); $alg = preg_replace("/T3UR2-/","<349>",$alg);   $alg = preg_replace("/T3UR'/","<350>",$alg); $alg = preg_replace("/T3UR-/","<350>",$alg);   $alg = preg_replace("/T3UR2/","<351>",$alg);   $alg = preg_replace("/T3UR/","<352>",$alg);
    $alg = preg_replace("/T3DL2'/","<353>",$alg); $alg = preg_replace("/T3DL2-/","<353>",$alg);   $alg = preg_replace("/T3DL'/","<354>",$alg); $alg = preg_replace("/T3DL-/","<354>",$alg);   $alg = preg_replace("/T3DL2/","<355>",$alg);   $alg = preg_replace("/T3DL/","<356>",$alg);
    $alg = preg_replace("/T3UL2'/","<357>",$alg); $alg = preg_replace("/T3UL2-/","<357>",$alg);   $alg = preg_replace("/T3UL'/","<358>",$alg); $alg = preg_replace("/T3UL-/","<358>",$alg);   $alg = preg_replace("/T3UL2/","<359>",$alg);   $alg = preg_replace("/T3UL/","<360>",$alg);
    $alg = preg_replace("/T3DR2'/","<361>",$alg); $alg = preg_replace("/T3DR2-/","<361>",$alg);   $alg = preg_replace("/T3DR'/","<362>",$alg); $alg = preg_replace("/T3DR-/","<362>",$alg);   $alg = preg_replace("/T3DR2/","<363>",$alg);   $alg = preg_replace("/T3DR/","<364>",$alg);
    $alg = preg_replace("/T3BL2'/","<369>",$alg); $alg = preg_replace("/T3BL2-/","<369>",$alg);   $alg = preg_replace("/T3BL'/","<370>",$alg); $alg = preg_replace("/T3BL-/","<370>",$alg);   $alg = preg_replace("/T3BL2/","<371>",$alg);   $alg = preg_replace("/T3BL/","<372>",$alg);
    $alg = preg_replace("/T3BR2'/","<377>",$alg); $alg = preg_replace("/T3BR2-/","<377>",$alg);   $alg = preg_replace("/T3BR'/","<378>",$alg); $alg = preg_replace("/T3BR-/","<378>",$alg);   $alg = preg_replace("/T3BR2/","<379>",$alg);   $alg = preg_replace("/T3BR/","<380>",$alg);
    
    $alg = preg_replace("/T3R2'/", "<365>",$alg); $alg = preg_replace("/T3R2-/", "<365>",$alg);   $alg = preg_replace("/T3R'/", "<366>",$alg); $alg = preg_replace("/T3R-/", "<366>",$alg);   $alg = preg_replace("/T3R2/", "<367>",$alg);   $alg = preg_replace("/T3R/", "<368>",$alg);
    $alg = preg_replace("/T3L2'/", "<373>",$alg); $alg = preg_replace("/T3L2-/", "<373>",$alg);   $alg = preg_replace("/T3L'/", "<374>",$alg); $alg = preg_replace("/T3L-/", "<374>",$alg);   $alg = preg_replace("/T3L2/", "<375>",$alg);   $alg = preg_replace("/T3L/", "<376>",$alg);
    $alg = preg_replace("/T3F2'/", "<381>",$alg); $alg = preg_replace("/T3F2-/", "<381>",$alg);   $alg = preg_replace("/T3F'/", "<382>",$alg); $alg = preg_replace("/T3F-/", "<382>",$alg);   $alg = preg_replace("/T3F2/", "<383>",$alg);   $alg = preg_replace("/T3F/", "<384>",$alg);
    $alg = preg_replace("/T3B2'/", "<385>",$alg); $alg = preg_replace("/T3B2-/", "<385>",$alg);   $alg = preg_replace("/T3B'/", "<386>",$alg); $alg = preg_replace("/T3B-/", "<386>",$alg);   $alg = preg_replace("/T3B2/", "<387>",$alg);   $alg = preg_replace("/T3B/", "<388>",$alg);
    $alg = preg_replace("/T3U2'/", "<389>",$alg); $alg = preg_replace("/T3U2-/", "<389>",$alg);   $alg = preg_replace("/T3U'/", "<390>",$alg); $alg = preg_replace("/T3U-/", "<390>",$alg);   $alg = preg_replace("/T3U2/", "<391>",$alg);   $alg = preg_replace("/T3U/", "<392>",$alg);
    $alg = preg_replace("/T3D2'/", "<393>",$alg); $alg = preg_replace("/T3D2-/", "<393>",$alg);   $alg = preg_replace("/T3D'/", "<394>",$alg); $alg = preg_replace("/T3D-/", "<394>",$alg);   $alg = preg_replace("/T3D2/", "<395>",$alg);   $alg = preg_replace("/T3D/", "<396>",$alg);
    
    
    //<s> /* T */
    $alg = preg_replace("/TUR2'/", "<397>",$alg); $alg = preg_replace("/TUR2-/", "<397>",$alg);   $alg = preg_replace("/TUR'/", "<398>",$alg); $alg = preg_replace("/TUR-/", "<398>",$alg);   $alg = preg_replace("/TUR2/", "<399>",$alg);   $alg = preg_replace("/TUR/","<3100>",$alg);
    $alg = preg_replace("/TDL2'/","<3101>",$alg); $alg = preg_replace("/TDL2-/","<3101>",$alg);   $alg = preg_replace("/TDL'/","<3102>",$alg); $alg = preg_replace("/TDL-/","<3102>",$alg);   $alg = preg_replace("/TDL2/","<3103>",$alg);   $alg = preg_replace("/TDL/","<3104>",$alg);
    $alg = preg_replace("/TUL2'/","<3105>",$alg); $alg = preg_replace("/TUL2-/","<3105>",$alg);   $alg = preg_replace("/TUL'/","<3106>",$alg); $alg = preg_replace("/TUL-/","<3106>",$alg);   $alg = preg_replace("/TUL2/","<3107>",$alg);   $alg = preg_replace("/TUL/","<3108>",$alg);
    $alg = preg_replace("/TDR2'/","<3109>",$alg); $alg = preg_replace("/TDR2-/","<3109>",$alg);   $alg = preg_replace("/TDR'/","<3110>",$alg); $alg = preg_replace("/TDR-/","<3110>",$alg);   $alg = preg_replace("/TDR2/","<3111>",$alg);   $alg = preg_replace("/TDR/","<3112>",$alg);
    $alg = preg_replace("/TBL2'/","<3117>",$alg); $alg = preg_replace("/TBL2-/","<3117>",$alg);   $alg = preg_replace("/TBL'/","<3118>",$alg); $alg = preg_replace("/TBL-/","<3118>",$alg);   $alg = preg_replace("/TBL2/","<3119>",$alg);   $alg = preg_replace("/TBL/","<3120>",$alg);
    $alg = preg_replace("/TBR2'/","<3125>",$alg); $alg = preg_replace("/TBR2-/","<3125>",$alg);   $alg = preg_replace("/TBR'/","<3126>",$alg); $alg = preg_replace("/TBR-/","<3126>",$alg);   $alg = preg_replace("/TBR2/","<3127>",$alg);   $alg = preg_replace("/TBR/","<3128>",$alg);
    
    $alg = preg_replace("/TR2'/", "<3113>",$alg); $alg = preg_replace("/TR2-/", "<3113>",$alg);   $alg = preg_replace("/TR'/", "<3114>",$alg); $alg = preg_replace("/TR-/", "<3114>",$alg);   $alg = preg_replace("/TR2/", "<3115>",$alg);   $alg = preg_replace("/TR/", "<3116>",$alg);
    $alg = preg_replace("/TL2'/", "<3121>",$alg); $alg = preg_replace("/TL2-/", "<3121>",$alg);   $alg = preg_replace("/TL'/", "<3122>",$alg); $alg = preg_replace("/TL-/", "<3122>",$alg);   $alg = preg_replace("/TL2/", "<3123>",$alg);   $alg = preg_replace("/TL/", "<3124>",$alg);
    $alg = preg_replace("/TF2'/", "<3129>",$alg); $alg = preg_replace("/TF2-/", "<3129>",$alg);   $alg = preg_replace("/TF'/", "<3130>",$alg); $alg = preg_replace("/TF-/", "<3130>",$alg);   $alg = preg_replace("/TF2/", "<3131>",$alg);   $alg = preg_replace("/TF/", "<3132>",$alg);
    $alg = preg_replace("/TB2'/", "<3133>",$alg); $alg = preg_replace("/TB2-/", "<3133>",$alg);   $alg = preg_replace("/TB'/", "<3134>",$alg); $alg = preg_replace("/TB-/", "<3134>",$alg);   $alg = preg_replace("/TB2/", "<3135>",$alg);   $alg = preg_replace("/TB/", "<3136>",$alg);
    $alg = preg_replace("/TU2'/", "<3137>",$alg); $alg = preg_replace("/TU2-/", "<3137>",$alg);   $alg = preg_replace("/TU'/", "<3138>",$alg); $alg = preg_replace("/TU-/", "<3138>",$alg);   $alg = preg_replace("/TU2/", "<3139>",$alg);   $alg = preg_replace("/TU/", "<3140>",$alg);
    $alg = preg_replace("/TD2'/", "<3141>",$alg); $alg = preg_replace("/TD2-/", "<3141>",$alg);   $alg = preg_replace("/TD'/", "<3142>",$alg); $alg = preg_replace("/TD-/", "<3142>",$alg);   $alg = preg_replace("/TD2/", "<3143>",$alg);   $alg = preg_replace("/TD/", "<3144>",$alg);
    
    /* --- 5xD: SSE -> CODE: [4] (Void twists) [1] Numbered layer twists --- */
    //<s> /* V = M2, N2-3 | N3-4 */
    $alg = preg_replace("/VUR2'/","<401>",$alg); $alg = preg_replace("/VUR2-/","<401>",$alg);   $alg = preg_replace("/VUR'/","<402>",$alg); $alg = preg_replace("/VUR-/","<402>",$alg);   $alg = preg_replace("/VUR2/","<403>",$alg);   $alg = preg_replace("/VUR/","<404>",$alg);
    $alg = preg_replace("/VDL2'/","<405>",$alg); $alg = preg_replace("/VDL2-/","<405>",$alg);   $alg = preg_replace("/VDL'/","<406>",$alg); $alg = preg_replace("/VDL-/","<406>",$alg);   $alg = preg_replace("/VDL2/","<407>",$alg);   $alg = preg_replace("/VDL/","<408>",$alg);
    $alg = preg_replace("/VUL2'/","<409>",$alg); $alg = preg_replace("/VUL2-/","<409>",$alg);   $alg = preg_replace("/VUL'/","<410>",$alg); $alg = preg_replace("/VUL-/","<410>",$alg);   $alg = preg_replace("/VUL2/","<411>",$alg);   $alg = preg_replace("/VUL/","<412>",$alg);
    $alg = preg_replace("/VDR2'/","<413>",$alg); $alg = preg_replace("/VDR2-/","<413>",$alg);   $alg = preg_replace("/VDR'/","<414>",$alg); $alg = preg_replace("/VDR-/","<414>",$alg);   $alg = preg_replace("/VDR2/","<415>",$alg);   $alg = preg_replace("/VDR/","<416>",$alg);
    $alg = preg_replace("/VBL2'/","<421>",$alg); $alg = preg_replace("/VBL2-/","<421>",$alg);   $alg = preg_replace("/VBL'/","<422>",$alg); $alg = preg_replace("/VBL-/","<422>",$alg);   $alg = preg_replace("/VBL2/","<423>",$alg);   $alg = preg_replace("/VBL/","<424>",$alg);
    $alg = preg_replace("/VBR2'/","<429>",$alg); $alg = preg_replace("/VBR2-/","<429>",$alg);   $alg = preg_replace("/VBR'/","<430>",$alg); $alg = preg_replace("/VBR-/","<430>",$alg);   $alg = preg_replace("/VBR2/","<431>",$alg);   $alg = preg_replace("/VBR/","<432>",$alg);
    
    $alg = preg_replace("/VR2'/", "<417>",$alg); $alg = preg_replace("/VR2-/", "<417>",$alg);   $alg = preg_replace("/VR'/", "<418>",$alg); $alg = preg_replace("/VR-/", "<418>",$alg);   $alg = preg_replace("/VR2/", "<419>",$alg);   $alg = preg_replace("/VR/", "<420>",$alg);
    $alg = preg_replace("/VL2'/", "<425>",$alg); $alg = preg_replace("/VL2-/", "<425>",$alg);   $alg = preg_replace("/VL'/", "<426>",$alg); $alg = preg_replace("/VL-/", "<426>",$alg);   $alg = preg_replace("/VL2/", "<427>",$alg);   $alg = preg_replace("/VL/", "<428>",$alg);
    $alg = preg_replace("/VF2'/", "<433>",$alg); $alg = preg_replace("/VF2-/", "<433>",$alg);   $alg = preg_replace("/VF'/", "<434>",$alg); $alg = preg_replace("/VF-/", "<434>",$alg);   $alg = preg_replace("/VF2/", "<435>",$alg);   $alg = preg_replace("/VF/", "<436>",$alg);
    $alg = preg_replace("/VB2'/", "<437>",$alg); $alg = preg_replace("/VB2-/", "<437>",$alg);   $alg = preg_replace("/VB'/", "<438>",$alg); $alg = preg_replace("/VB-/", "<438>",$alg);   $alg = preg_replace("/VB2/", "<439>",$alg);   $alg = preg_replace("/VB/", "<440>",$alg);
    $alg = preg_replace("/VU2'/", "<441>",$alg); $alg = preg_replace("/VU2-/", "<441>",$alg);   $alg = preg_replace("/VU'/", "<442>",$alg); $alg = preg_replace("/VU-/", "<442>",$alg);   $alg = preg_replace("/VU2/", "<443>",$alg);   $alg = preg_replace("/VU/", "<444>",$alg);
    $alg = preg_replace("/VD2'/", "<445>",$alg); $alg = preg_replace("/VD2-/", "<445>",$alg);   $alg = preg_replace("/VD'/", "<446>",$alg); $alg = preg_replace("/VD-/", "<446>",$alg);   $alg = preg_replace("/VD2/", "<447>",$alg);   $alg = preg_replace("/VD/", "<448>",$alg);
    
    
    $alg = preg_replace("/N2-3UR2'/","<401>",$alg); $alg = preg_replace("/N2-3UR2-/","<401>",$alg);   $alg = preg_replace("/N2-3UR'/","<402>",$alg); $alg = preg_replace("/N2-3UR-/","<402>",$alg);   $alg = preg_replace("/N2-3UR2/","<403>",$alg);   $alg = preg_replace("/N2-3UR/","<404>",$alg);
    $alg = preg_replace("/N2-3DL2'/","<405>",$alg); $alg = preg_replace("/N2-3DL2-/","<405>",$alg);   $alg = preg_replace("/N2-3DL'/","<406>",$alg); $alg = preg_replace("/N2-3DL-/","<406>",$alg);   $alg = preg_replace("/N2-3DL2/","<407>",$alg);   $alg = preg_replace("/N2-3DL/","<408>",$alg);
    $alg = preg_replace("/N2-3UL2'/","<409>",$alg); $alg = preg_replace("/N2-3UL2-/","<409>",$alg);   $alg = preg_replace("/N2-3UL'/","<410>",$alg); $alg = preg_replace("/N2-3UL-/","<410>",$alg);   $alg = preg_replace("/N2-3UL2/","<411>",$alg);   $alg = preg_replace("/N2-3UL/","<412>",$alg);
    $alg = preg_replace("/N2-3DR2'/","<413>",$alg); $alg = preg_replace("/N2-3DR2-/","<413>",$alg);   $alg = preg_replace("/N2-3DR'/","<414>",$alg); $alg = preg_replace("/N2-3DR-/","<414>",$alg);   $alg = preg_replace("/N2-3DR2/","<415>",$alg);   $alg = preg_replace("/N2-3DR/","<416>",$alg);
    $alg = preg_replace("/N2-3BL2'/","<421>",$alg); $alg = preg_replace("/N2-3BL2-/","<421>",$alg);   $alg = preg_replace("/N2-3BL'/","<422>",$alg); $alg = preg_replace("/N2-3BL-/","<422>",$alg);   $alg = preg_replace("/N2-3BL2/","<423>",$alg);   $alg = preg_replace("/N2-3BL/","<424>",$alg);
    $alg = preg_replace("/N2-3BR2'/","<429>",$alg); $alg = preg_replace("/N2-3BR2-/","<429>",$alg);   $alg = preg_replace("/N2-3BR'/","<430>",$alg); $alg = preg_replace("/N2-3BR-/","<430>",$alg);   $alg = preg_replace("/N2-3BR2/","<431>",$alg);   $alg = preg_replace("/N2-3BR/","<432>",$alg);
    
    $alg = preg_replace("/N2-3R2'/", "<417>",$alg); $alg = preg_replace("/N2-3R2-/", "<417>",$alg);   $alg = preg_replace("/N2-3R'/", "<418>",$alg); $alg = preg_replace("/N2-3R-/", "<418>",$alg);   $alg = preg_replace("/N2-3R2/", "<419>",$alg);   $alg = preg_replace("/N2-3R/", "<420>",$alg);
    $alg = preg_replace("/N2-3L2'/", "<425>",$alg); $alg = preg_replace("/N2-3L2-/", "<425>",$alg);   $alg = preg_replace("/N2-3L'/", "<426>",$alg); $alg = preg_replace("/N2-3L-/", "<426>",$alg);   $alg = preg_replace("/N2-3L2/", "<427>",$alg);   $alg = preg_replace("/N2-3L/", "<428>",$alg);
    $alg = preg_replace("/N2-3F2'/", "<433>",$alg); $alg = preg_replace("/N2-3F2-/", "<433>",$alg);   $alg = preg_replace("/N2-3F'/", "<434>",$alg); $alg = preg_replace("/N2-3F-/", "<434>",$alg);   $alg = preg_replace("/N2-3F2/", "<435>",$alg);   $alg = preg_replace("/N2-3F/", "<436>",$alg);
    $alg = preg_replace("/N2-3B2'/", "<437>",$alg); $alg = preg_replace("/N2-3B2-/", "<437>",$alg);   $alg = preg_replace("/N2-3B'/", "<438>",$alg); $alg = preg_replace("/N2-3B-/", "<438>",$alg);   $alg = preg_replace("/N2-3B2/", "<439>",$alg);   $alg = preg_replace("/N2-3B/", "<440>",$alg);
    $alg = preg_replace("/N2-3U2'/", "<441>",$alg); $alg = preg_replace("/N2-3U2-/", "<441>",$alg);   $alg = preg_replace("/N2-3U'/", "<442>",$alg); $alg = preg_replace("/N2-3U-/", "<442>",$alg);   $alg = preg_replace("/N2-3U2/", "<443>",$alg);   $alg = preg_replace("/N2-3U/", "<444>",$alg);
    $alg = preg_replace("/N2-3D2'/", "<445>",$alg); $alg = preg_replace("/N2-3D2-/", "<445>",$alg);   $alg = preg_replace("/N2-3D'/", "<446>",$alg); $alg = preg_replace("/N2-3D-/", "<446>",$alg);   $alg = preg_replace("/N2-3D2/", "<447>",$alg);   $alg = preg_replace("/N2-3D/", "<448>",$alg);
    
    /* N3-4 */
    $alg = preg_replace("/N3-4UR2'/","<407>",$alg); $alg = preg_replace("/N3-4UR2-/","<407>",$alg);   $alg = preg_replace("/N3-4UR'/","<408>",$alg); $alg = preg_replace("/N3-4UR-/","<408>",$alg);   $alg = preg_replace("/N3-4UR2/","<405>",$alg);   $alg = preg_replace("/N3-4UR/","<406>",$alg);
    $alg = preg_replace("/N3-4DL2'/","<403>",$alg); $alg = preg_replace("/N3-4DL2-/","<403>",$alg);   $alg = preg_replace("/N3-4DL'/","<404>",$alg); $alg = preg_replace("/N3-4DL-/","<404>",$alg);   $alg = preg_replace("/N3-4DL2/","<401>",$alg);   $alg = preg_replace("/N3-4DL/","<402>",$alg);
    $alg = preg_replace("/N3-4UL2'/","<415>",$alg); $alg = preg_replace("/N3-4UL2-/","<415>",$alg);   $alg = preg_replace("/N3-4UL'/","<416>",$alg); $alg = preg_replace("/N3-4UL-/","<416>",$alg);   $alg = preg_replace("/N3-4UL2/","<413>",$alg);   $alg = preg_replace("/N3-4UL/","<414>",$alg);
    $alg = preg_replace("/N3-4DR2'/","<411>",$alg); $alg = preg_replace("/N3-4DR2-/","<411>",$alg);   $alg = preg_replace("/N3-4DR'/","<412>",$alg); $alg = preg_replace("/N3-4DR-/","<412>",$alg);   $alg = preg_replace("/N3-4DR2/","<409>",$alg);   $alg = preg_replace("/N3-4DR/","<410>",$alg);
    $alg = preg_replace("/N3-4BL2'/","<419>",$alg); $alg = preg_replace("/N3-4BL2-/","<419>",$alg);   $alg = preg_replace("/N3-4BL'/","<420>",$alg); $alg = preg_replace("/N3-4BL-/","<420>",$alg);   $alg = preg_replace("/N3-4BL2/","<417>",$alg);   $alg = preg_replace("/N3-4BL/","<418>",$alg);
    $alg = preg_replace("/N3-4BR2'/","<427>",$alg); $alg = preg_replace("/N3-4BR2-/","<427>",$alg);   $alg = preg_replace("/N3-4BR'/","<428>",$alg); $alg = preg_replace("/N3-4BR-/","<428>",$alg);   $alg = preg_replace("/N3-4BR2/","<425>",$alg);   $alg = preg_replace("/N3-4BR/","<426>",$alg);
    
    $alg = preg_replace("/N3-4R2'/", "<423>",$alg); $alg = preg_replace("/N3-4R2-/", "<423>",$alg);   $alg = preg_replace("/N3-4R'/", "<424>",$alg); $alg = preg_replace("/N3-4R-/", "<424>",$alg);   $alg = preg_replace("/N3-4R2/", "<421>",$alg);   $alg = preg_replace("/N3-4R/", "<422>",$alg);
    $alg = preg_replace("/N3-4L2'/", "<431>",$alg); $alg = preg_replace("/N3-4L2-/", "<431>",$alg);   $alg = preg_replace("/N3-4L'/", "<432>",$alg); $alg = preg_replace("/N3-4L-/", "<432>",$alg);   $alg = preg_replace("/N3-4L2/", "<429>",$alg);   $alg = preg_replace("/N3-4L/", "<430>",$alg);
    $alg = preg_replace("/N3-4F2'/", "<439>",$alg); $alg = preg_replace("/N3-4F2-/", "<439>",$alg);   $alg = preg_replace("/N3-4F'/", "<440>",$alg); $alg = preg_replace("/N3-4F-/", "<440>",$alg);   $alg = preg_replace("/N3-4F2/", "<437>",$alg);   $alg = preg_replace("/N3-4F/", "<438>",$alg);
    $alg = preg_replace("/N3-4B2'/", "<435>",$alg); $alg = preg_replace("/N3-4B2-/", "<435>",$alg);   $alg = preg_replace("/N3-4B'/", "<436>",$alg); $alg = preg_replace("/N3-4B-/", "<436>",$alg);   $alg = preg_replace("/N3-4B2/", "<433>",$alg);   $alg = preg_replace("/N3-4B/", "<434>",$alg);
    $alg = preg_replace("/N3-4U2'/", "<447>",$alg); $alg = preg_replace("/N3-4U2-/", "<447>",$alg);   $alg = preg_replace("/N3-4U'/", "<448>",$alg); $alg = preg_replace("/N3-4U-/", "<448>",$alg);   $alg = preg_replace("/N3-4U2/", "<445>",$alg);   $alg = preg_replace("/N3-4U/", "<446>",$alg);
    $alg = preg_replace("/N3-4D2'/", "<443>",$alg); $alg = preg_replace("/N3-4D2-/", "<443>",$alg);   $alg = preg_replace("/N3-4D'/", "<444>",$alg); $alg = preg_replace("/N3-4D-/", "<444>",$alg);   $alg = preg_replace("/N3-4D2/", "<441>",$alg);   $alg = preg_replace("/N3-4D/", "<442>",$alg);
    
    
    $alg = preg_replace("/M2UR2'/","<401>",$alg); $alg = preg_replace("/M2UR2-/","<401>",$alg);   $alg = preg_replace("/M2UR'/","<402>",$alg); $alg = preg_replace("/M2UR-/","<402>",$alg);   $alg = preg_replace("/M2UR2/","<403>",$alg);   $alg = preg_replace("/M2UR/","<404>",$alg);
    $alg = preg_replace("/M2DL2'/","<405>",$alg); $alg = preg_replace("/M2DL2-/","<405>",$alg);   $alg = preg_replace("/M2DL'/","<406>",$alg); $alg = preg_replace("/M2DL-/","<406>",$alg);   $alg = preg_replace("/M2DL2/","<407>",$alg);   $alg = preg_replace("/M2DL/","<408>",$alg);
    $alg = preg_replace("/M2UL2'/","<409>",$alg); $alg = preg_replace("/M2UL2-/","<409>",$alg);   $alg = preg_replace("/M2UL'/","<410>",$alg); $alg = preg_replace("/M2UL-/","<410>",$alg);   $alg = preg_replace("/M2UL2/","<411>",$alg);   $alg = preg_replace("/M2UL/","<412>",$alg);
    $alg = preg_replace("/M2DR2'/","<413>",$alg); $alg = preg_replace("/M2DR2-/","<413>",$alg);   $alg = preg_replace("/M2DR'/","<414>",$alg); $alg = preg_replace("/M2DR-/","<414>",$alg);   $alg = preg_replace("/M2DR2/","<415>",$alg);   $alg = preg_replace("/M2DR/","<416>",$alg);
    $alg = preg_replace("/M2BL2'/","<421>",$alg); $alg = preg_replace("/M2BL2-/","<421>",$alg);   $alg = preg_replace("/M2BL'/","<422>",$alg); $alg = preg_replace("/M2BL-/","<422>",$alg);   $alg = preg_replace("/M2BL2/","<423>",$alg);   $alg = preg_replace("/M2BL/","<424>",$alg);
    $alg = preg_replace("/M2BR2'/","<429>",$alg); $alg = preg_replace("/M2BR2-/","<429>",$alg);   $alg = preg_replace("/M2BR'/","<430>",$alg); $alg = preg_replace("/M2BR-/","<430>",$alg);   $alg = preg_replace("/M2BR2/","<431>",$alg);   $alg = preg_replace("/M2BR/","<432>",$alg);
    
    $alg = preg_replace("/M2R2'/", "<417>",$alg); $alg = preg_replace("/M2R2-/", "<417>",$alg);   $alg = preg_replace("/M2R'/", "<418>",$alg); $alg = preg_replace("/M2R-/", "<418>",$alg);   $alg = preg_replace("/M2R2/", "<419>",$alg);   $alg = preg_replace("/M2R/", "<420>",$alg);
    $alg = preg_replace("/M2L2'/", "<425>",$alg); $alg = preg_replace("/M2L2-/", "<425>",$alg);   $alg = preg_replace("/M2L'/", "<426>",$alg); $alg = preg_replace("/M2L-/", "<426>",$alg);   $alg = preg_replace("/M2L2/", "<427>",$alg);   $alg = preg_replace("/M2L/", "<428>",$alg);
    $alg = preg_replace("/M2F2'/", "<433>",$alg); $alg = preg_replace("/M2F2-/", "<433>",$alg);   $alg = preg_replace("/M2F'/", "<434>",$alg); $alg = preg_replace("/M2F-/", "<434>",$alg);   $alg = preg_replace("/M2F2/", "<435>",$alg);   $alg = preg_replace("/M2F/", "<436>",$alg);
    $alg = preg_replace("/M2B2'/", "<437>",$alg); $alg = preg_replace("/M2B2-/", "<437>",$alg);   $alg = preg_replace("/M2B'/", "<438>",$alg); $alg = preg_replace("/M2B-/", "<438>",$alg);   $alg = preg_replace("/M2B2/", "<439>",$alg);   $alg = preg_replace("/M2B/", "<440>",$alg);
    $alg = preg_replace("/M2U2'/", "<441>",$alg); $alg = preg_replace("/M2U2-/", "<441>",$alg);   $alg = preg_replace("/M2U'/", "<442>",$alg); $alg = preg_replace("/M2U-/", "<442>",$alg);   $alg = preg_replace("/M2U2/", "<443>",$alg);   $alg = preg_replace("/M2U/", "<444>",$alg);
    $alg = preg_replace("/M2D2'/", "<445>",$alg); $alg = preg_replace("/M2D2-/", "<445>",$alg);   $alg = preg_replace("/M2D'/", "<446>",$alg); $alg = preg_replace("/M2D-/", "<446>",$alg);   $alg = preg_replace("/M2D2/", "<447>",$alg);   $alg = preg_replace("/M2D/", "<448>",$alg);
    
    /* --- 5xD: SSE -> CODE: [6] Wide-layer twists [5] (Mid-layer twists) [4] (Void twists) [1] Numbered layer twists --- */
    //<s> /* W = M3 = V3 = N2-4 */
    $alg = preg_replace("/WUR2'/","<501>",$alg); $alg = preg_replace("/WUR2-/","<501>",$alg);   $alg = preg_replace("/WUR'/","<502>",$alg); $alg = preg_replace("/WUR-/","<502>",$alg);   $alg = preg_replace("/WUR2/","<503>",$alg);   $alg = preg_replace("/WUR/","<504>",$alg);
    $alg = preg_replace("/WDL2'/","<503>",$alg); $alg = preg_replace("/WDL2-/","<503>",$alg);   $alg = preg_replace("/WDL'/","<504>",$alg); $alg = preg_replace("/WDL-/","<504>",$alg);   $alg = preg_replace("/WDL2/","<501>",$alg);   $alg = preg_replace("/WDL/","<502>",$alg);
    $alg = preg_replace("/WUL2'/","<505>",$alg); $alg = preg_replace("/WUL2-/","<505>",$alg);   $alg = preg_replace("/WUL'/","<506>",$alg); $alg = preg_replace("/WUL-/","<506>",$alg);   $alg = preg_replace("/WUL2/","<507>",$alg);   $alg = preg_replace("/WUL/","<508>",$alg);
    $alg = preg_replace("/WDR2'/","<507>",$alg); $alg = preg_replace("/WDR2-/","<507>",$alg);   $alg = preg_replace("/WDR'/","<508>",$alg); $alg = preg_replace("/WDR-/","<508>",$alg);   $alg = preg_replace("/WDR2/","<505>",$alg);   $alg = preg_replace("/WDR/","<506>",$alg);
    $alg = preg_replace("/WBL2'/","<511>",$alg); $alg = preg_replace("/WBL2-/","<511>",$alg);   $alg = preg_replace("/WBL'/","<512>",$alg); $alg = preg_replace("/WBL-/","<512>",$alg);   $alg = preg_replace("/WBL2/","<509>",$alg);   $alg = preg_replace("/WBL/","<510>",$alg);
    $alg = preg_replace("/WBR2'/","<515>",$alg); $alg = preg_replace("/WBR2-/","<515>",$alg);   $alg = preg_replace("/WBR'/","<516>",$alg); $alg = preg_replace("/WBR-/","<516>",$alg);   $alg = preg_replace("/WBR2/","<513>",$alg);   $alg = preg_replace("/WBR/","<514>",$alg);
    
    $alg = preg_replace("/WR2'/", "<509>",$alg); $alg = preg_replace("/WR2-/", "<509>",$alg);   $alg = preg_replace("/WR'/", "<510>",$alg); $alg = preg_replace("/WR-/", "<510>",$alg);   $alg = preg_replace("/WR2/", "<511>",$alg);   $alg = preg_replace("/WR/", "<512>",$alg);
    $alg = preg_replace("/WL2'/", "<513>",$alg); $alg = preg_replace("/WL2-/", "<513>",$alg);   $alg = preg_replace("/WL'/", "<514>",$alg); $alg = preg_replace("/WL-/", "<514>",$alg);   $alg = preg_replace("/WL2/", "<515>",$alg);   $alg = preg_replace("/WL/", "<516>",$alg);
    $alg = preg_replace("/WF2'/", "<517>",$alg); $alg = preg_replace("/WF2-/", "<517>",$alg);   $alg = preg_replace("/WF'/", "<518>",$alg); $alg = preg_replace("/WF-/", "<518>",$alg);   $alg = preg_replace("/WF2/", "<519>",$alg);   $alg = preg_replace("/WF/", "<520>",$alg);
    $alg = preg_replace("/WB2'/", "<519>",$alg); $alg = preg_replace("/WB2-/", "<519>",$alg);   $alg = preg_replace("/WB'/", "<520>",$alg); $alg = preg_replace("/WB-/", "<520>",$alg);   $alg = preg_replace("/WB2/", "<517>",$alg);   $alg = preg_replace("/WB/", "<518>",$alg);
    $alg = preg_replace("/WU2'/", "<521>",$alg); $alg = preg_replace("/WU2-/", "<521>",$alg);   $alg = preg_replace("/WU'/", "<522>",$alg); $alg = preg_replace("/WU-/", "<522>",$alg);   $alg = preg_replace("/WU2/", "<523>",$alg);   $alg = preg_replace("/WU/", "<524>",$alg);
    $alg = preg_replace("/WD2'/", "<523>",$alg); $alg = preg_replace("/WD2-/", "<523>",$alg);   $alg = preg_replace("/WD'/", "<524>",$alg); $alg = preg_replace("/WD-/", "<524>",$alg);   $alg = preg_replace("/WD2/", "<521>",$alg);   $alg = preg_replace("/WD/", "<522>",$alg);
    
    
    $alg = preg_replace("/M3UR2'/","<501>",$alg); $alg = preg_replace("/M3UR2-/","<501>",$alg);   $alg = preg_replace("/M3UR'/","<502>",$alg); $alg = preg_replace("/M3UR-/","<502>",$alg);   $alg = preg_replace("/M3UR2/","<503>",$alg);   $alg = preg_replace("/M3UR/","<504>",$alg);
    $alg = preg_replace("/M3DL2'/","<503>",$alg); $alg = preg_replace("/M3DL2-/","<503>",$alg);   $alg = preg_replace("/M3DL'/","<504>",$alg); $alg = preg_replace("/M3DL-/","<504>",$alg);   $alg = preg_replace("/M3DL2/","<501>",$alg);   $alg = preg_replace("/M3DL/","<502>",$alg);
    $alg = preg_replace("/M3UL2'/","<505>",$alg); $alg = preg_replace("/M3UL2-/","<505>",$alg);   $alg = preg_replace("/M3UL'/","<506>",$alg); $alg = preg_replace("/M3UL-/","<506>",$alg);   $alg = preg_replace("/M3UL2/","<507>",$alg);   $alg = preg_replace("/M3UL/","<508>",$alg);
    $alg = preg_replace("/M3DR2'/","<507>",$alg); $alg = preg_replace("/M3DR2-/","<507>",$alg);   $alg = preg_replace("/M3DR'/","<508>",$alg); $alg = preg_replace("/M3DR-/","<508>",$alg);   $alg = preg_replace("/M3DR2/","<505>",$alg);   $alg = preg_replace("/M3DR/","<506>",$alg);
    $alg = preg_replace("/M3BL2'/","<511>",$alg); $alg = preg_replace("/M3BL2-/","<511>",$alg);   $alg = preg_replace("/M3BL'/","<512>",$alg); $alg = preg_replace("/M3BL-/","<512>",$alg);   $alg = preg_replace("/M3BL2/","<509>",$alg);   $alg = preg_replace("/M3BL/","<510>",$alg);
    $alg = preg_replace("/M3BR2'/","<515>",$alg); $alg = preg_replace("/M3BR2-/","<515>",$alg);   $alg = preg_replace("/M3BR'/","<516>",$alg); $alg = preg_replace("/M3BR-/","<516>",$alg);   $alg = preg_replace("/M3BR2/","<513>",$alg);   $alg = preg_replace("/M3BR/","<514>",$alg);
    
    $alg = preg_replace("/M3R2'/", "<509>",$alg); $alg = preg_replace("/M3R2-/", "<509>",$alg);   $alg = preg_replace("/M3R'/", "<510>",$alg); $alg = preg_replace("/M3R-/", "<510>",$alg);   $alg = preg_replace("/M3R2/", "<511>",$alg);   $alg = preg_replace("/M3R/", "<512>",$alg);
    $alg = preg_replace("/M3L2'/", "<513>",$alg); $alg = preg_replace("/M3L2-/", "<513>",$alg);   $alg = preg_replace("/M3L'/", "<514>",$alg); $alg = preg_replace("/M3L-/", "<514>",$alg);   $alg = preg_replace("/M3L2/", "<515>",$alg);   $alg = preg_replace("/M3L/", "<516>",$alg);
    $alg = preg_replace("/M3F2'/", "<517>",$alg); $alg = preg_replace("/M3F2-/", "<517>",$alg);   $alg = preg_replace("/M3F'/", "<518>",$alg); $alg = preg_replace("/M3F-/", "<518>",$alg);   $alg = preg_replace("/M3F2/", "<519>",$alg);   $alg = preg_replace("/M3F/", "<520>",$alg);
    $alg = preg_replace("/M3B2'/", "<519>",$alg); $alg = preg_replace("/M3B2-/", "<519>",$alg);   $alg = preg_replace("/M3B'/", "<520>",$alg); $alg = preg_replace("/M3B-/", "<520>",$alg);   $alg = preg_replace("/M3B2/", "<517>",$alg);   $alg = preg_replace("/M3B/", "<518>",$alg);
    $alg = preg_replace("/M3U2'/", "<521>",$alg); $alg = preg_replace("/M3U2-/", "<521>",$alg);   $alg = preg_replace("/M3U'/", "<522>",$alg); $alg = preg_replace("/M3U-/", "<522>",$alg);   $alg = preg_replace("/M3U2/", "<523>",$alg);   $alg = preg_replace("/M3U/", "<524>",$alg);
    $alg = preg_replace("/M3D2'/", "<523>",$alg); $alg = preg_replace("/M3D2-/", "<523>",$alg);   $alg = preg_replace("/M3D'/", "<524>",$alg); $alg = preg_replace("/M3D-/", "<524>",$alg);   $alg = preg_replace("/M3D2/", "<521>",$alg);   $alg = preg_replace("/M3D/", "<522>",$alg);
    
    
    $alg = preg_replace("/V3UR2'/","<501>",$alg); $alg = preg_replace("/V3UR2-/","<501>",$alg);   $alg = preg_replace("/V3UR'/","<502>",$alg); $alg = preg_replace("/V3UR-/","<502>",$alg);   $alg = preg_replace("/V3UR2/","<503>",$alg);   $alg = preg_replace("/V3UR/","<504>",$alg);
    $alg = preg_replace("/V3DL2'/","<503>",$alg); $alg = preg_replace("/V3DL2-/","<503>",$alg);   $alg = preg_replace("/V3DL'/","<504>",$alg); $alg = preg_replace("/V3DL-/","<504>",$alg);   $alg = preg_replace("/V3DL2/","<501>",$alg);   $alg = preg_replace("/V3DL/","<502>",$alg);
    $alg = preg_replace("/V3UL2'/","<505>",$alg); $alg = preg_replace("/V3UL2-/","<505>",$alg);   $alg = preg_replace("/V3UL'/","<506>",$alg); $alg = preg_replace("/V3UL-/","<506>",$alg);   $alg = preg_replace("/V3UL2/","<507>",$alg);   $alg = preg_replace("/V3UL/","<508>",$alg);
    $alg = preg_replace("/V3DR2'/","<507>",$alg); $alg = preg_replace("/V3DR2-/","<507>",$alg);   $alg = preg_replace("/V3DR'/","<508>",$alg); $alg = preg_replace("/V3DR-/","<508>",$alg);   $alg = preg_replace("/V3DR2/","<505>",$alg);   $alg = preg_replace("/V3DR/","<506>",$alg);
    $alg = preg_replace("/V3BL2'/","<511>",$alg); $alg = preg_replace("/V3BL2-/","<511>",$alg);   $alg = preg_replace("/V3BL'/","<512>",$alg); $alg = preg_replace("/V3BL-/","<512>",$alg);   $alg = preg_replace("/V3BL2/","<509>",$alg);   $alg = preg_replace("/V3BL/","<510>",$alg);
    $alg = preg_replace("/V3BR2'/","<515>",$alg); $alg = preg_replace("/V3BR2-/","<515>",$alg);   $alg = preg_replace("/V3BR'/","<516>",$alg); $alg = preg_replace("/V3BR-/","<516>",$alg);   $alg = preg_replace("/V3BR2/","<513>",$alg);   $alg = preg_replace("/V3BR/","<514>",$alg);
    
    $alg = preg_replace("/V3R2'/", "<509>",$alg); $alg = preg_replace("/V3R2-/", "<509>",$alg);   $alg = preg_replace("/V3R'/", "<510>",$alg); $alg = preg_replace("/V3R-/", "<510>",$alg);   $alg = preg_replace("/V3R2/", "<511>",$alg);   $alg = preg_replace("/V3R/", "<512>",$alg);
    $alg = preg_replace("/V3L2'/", "<513>",$alg); $alg = preg_replace("/V3L2-/", "<513>",$alg);   $alg = preg_replace("/V3L'/", "<514>",$alg); $alg = preg_replace("/V3L-/", "<514>",$alg);   $alg = preg_replace("/V3L2/", "<515>",$alg);   $alg = preg_replace("/V3L/", "<516>",$alg);
    $alg = preg_replace("/V3F2'/", "<517>",$alg); $alg = preg_replace("/V3F2-/", "<517>",$alg);   $alg = preg_replace("/V3F'/", "<518>",$alg); $alg = preg_replace("/V3F-/", "<518>",$alg);   $alg = preg_replace("/V3F2/", "<519>",$alg);   $alg = preg_replace("/V3F/", "<520>",$alg);
    $alg = preg_replace("/V3B2'/", "<519>",$alg); $alg = preg_replace("/V3B2-/", "<519>",$alg);   $alg = preg_replace("/V3B'/", "<520>",$alg); $alg = preg_replace("/V3B-/", "<520>",$alg);   $alg = preg_replace("/V3B2/", "<517>",$alg);   $alg = preg_replace("/V3B/", "<518>",$alg);
    $alg = preg_replace("/V3U2'/", "<521>",$alg); $alg = preg_replace("/V3U2-/", "<521>",$alg);   $alg = preg_replace("/V3U'/", "<522>",$alg); $alg = preg_replace("/V3U-/", "<522>",$alg);   $alg = preg_replace("/V3U2/", "<523>",$alg);   $alg = preg_replace("/V3U/", "<524>",$alg);
    $alg = preg_replace("/V3D2'/", "<523>",$alg); $alg = preg_replace("/V3D2-/", "<523>",$alg);   $alg = preg_replace("/V3D'/", "<524>",$alg); $alg = preg_replace("/V3D-/", "<524>",$alg);   $alg = preg_replace("/V3D2/", "<521>",$alg);   $alg = preg_replace("/V3D/", "<522>",$alg);
    
    
    $alg = preg_replace("/N2-4UR2'/","<501>",$alg); $alg = preg_replace("/N2-4UR2-/","<501>",$alg);   $alg = preg_replace("/N2-4UR'/","<502>",$alg); $alg = preg_replace("/N2-4UR-/","<502>",$alg);   $alg = preg_replace("/N2-4UR2/","<503>",$alg);   $alg = preg_replace("/N2-4UR/","<504>",$alg);
    $alg = preg_replace("/N2-4DL2'/","<503>",$alg); $alg = preg_replace("/N2-4DL2-/","<503>",$alg);   $alg = preg_replace("/N2-4DL'/","<504>",$alg); $alg = preg_replace("/N2-4DL-/","<504>",$alg);   $alg = preg_replace("/N2-4DL2/","<501>",$alg);   $alg = preg_replace("/N2-4DL/","<502>",$alg);
    $alg = preg_replace("/N2-4UL2'/","<505>",$alg); $alg = preg_replace("/N2-4UL2-/","<505>",$alg);   $alg = preg_replace("/N2-4UL'/","<506>",$alg); $alg = preg_replace("/N2-4UL-/","<506>",$alg);   $alg = preg_replace("/N2-4UL2/","<507>",$alg);   $alg = preg_replace("/N2-4UL/","<508>",$alg);
    $alg = preg_replace("/N2-4DR2'/","<507>",$alg); $alg = preg_replace("/N2-4DR2-/","<507>",$alg);   $alg = preg_replace("/N2-4DR'/","<508>",$alg); $alg = preg_replace("/N2-4DR-/","<508>",$alg);   $alg = preg_replace("/N2-4DR2/","<505>",$alg);   $alg = preg_replace("/N2-4DR/","<506>",$alg);
    $alg = preg_replace("/N2-4BL2'/","<511>",$alg); $alg = preg_replace("/N2-4BL2-/","<511>",$alg);   $alg = preg_replace("/N2-4BL'/","<512>",$alg); $alg = preg_replace("/N2-4BL-/","<512>",$alg);   $alg = preg_replace("/N2-4BL2/","<509>",$alg);   $alg = preg_replace("/N2-4BL/","<510>",$alg);
    $alg = preg_replace("/N2-4BR2'/","<515>",$alg); $alg = preg_replace("/N2-4BR2-/","<515>",$alg);   $alg = preg_replace("/N2-4BR'/","<516>",$alg); $alg = preg_replace("/N2-4BR-/","<516>",$alg);   $alg = preg_replace("/N2-4BR2/","<513>",$alg);   $alg = preg_replace("/N2-4BR/","<514>",$alg);
    
    $alg = preg_replace("/N2-4R2'/", "<509>",$alg); $alg = preg_replace("/N2-4R2-/", "<509>",$alg);   $alg = preg_replace("/N2-4R'/", "<510>",$alg); $alg = preg_replace("/N2-4R-/", "<510>",$alg);   $alg = preg_replace("/N2-4R2/", "<511>",$alg);   $alg = preg_replace("/N2-4R/", "<512>",$alg);
    $alg = preg_replace("/N2-4L2'/", "<513>",$alg); $alg = preg_replace("/N2-4L2-/", "<513>",$alg);   $alg = preg_replace("/N2-4L'/", "<514>",$alg); $alg = preg_replace("/N2-4L-/", "<514>",$alg);   $alg = preg_replace("/N2-4L2/", "<515>",$alg);   $alg = preg_replace("/N2-4L/", "<516>",$alg);
    $alg = preg_replace("/N2-4F2'/", "<517>",$alg); $alg = preg_replace("/N2-4F2-/", "<517>",$alg);   $alg = preg_replace("/N2-4F'/", "<518>",$alg); $alg = preg_replace("/N2-4F-/", "<518>",$alg);   $alg = preg_replace("/N2-4F2/", "<519>",$alg);   $alg = preg_replace("/N2-4F/", "<520>",$alg);
    $alg = preg_replace("/N2-4B2'/", "<519>",$alg); $alg = preg_replace("/N2-4B2-/", "<519>",$alg);   $alg = preg_replace("/N2-4B'/", "<520>",$alg); $alg = preg_replace("/N2-4B-/", "<520>",$alg);   $alg = preg_replace("/N2-4B2/", "<517>",$alg);   $alg = preg_replace("/N2-4B/", "<518>",$alg);
    $alg = preg_replace("/N2-4U2'/", "<521>",$alg); $alg = preg_replace("/N2-4U2-/", "<521>",$alg);   $alg = preg_replace("/N2-4U'/", "<522>",$alg); $alg = preg_replace("/N2-4U-/", "<522>",$alg);   $alg = preg_replace("/N2-4U2/", "<523>",$alg);   $alg = preg_replace("/N2-4U/", "<524>",$alg);
    $alg = preg_replace("/N2-4D2'/", "<523>",$alg); $alg = preg_replace("/N2-4D2-/", "<523>",$alg);   $alg = preg_replace("/N2-4D'/", "<524>",$alg); $alg = preg_replace("/N2-4D-/", "<524>",$alg);   $alg = preg_replace("/N2-4D2/", "<521>",$alg);   $alg = preg_replace("/N2-4D/", "<522>",$alg);
    
    /* --- 5xD: SSE -> CODE: [7] Dodecahedron rotations --- */
    //<s> /* C */
    $alg = preg_replace("/CUR2'/","<701>",$alg); $alg = preg_replace("/CUR2-/","<701>",$alg);   $alg = preg_replace("/CUR'/","<702>",$alg); $alg = preg_replace("/CUR-/","<702>",$alg);   $alg = preg_replace("/CUR2/","<703>",$alg);   $alg = preg_replace("/CUR/","<704>",$alg);
    $alg = preg_replace("/CDL2'/","<703>",$alg); $alg = preg_replace("/CDL2-/","<703>",$alg);   $alg = preg_replace("/CDL'/","<704>",$alg); $alg = preg_replace("/CDL-/","<704>",$alg);   $alg = preg_replace("/CDL2/","<701>",$alg);   $alg = preg_replace("/CDL/","<702>",$alg);
    $alg = preg_replace("/CUL2'/","<705>",$alg); $alg = preg_replace("/CUL2-/","<705>",$alg);   $alg = preg_replace("/CUL'/","<706>",$alg); $alg = preg_replace("/CUL-/","<706>",$alg);   $alg = preg_replace("/CUL2/","<707>",$alg);   $alg = preg_replace("/CUL/","<708>",$alg);
    $alg = preg_replace("/CDR2'/","<707>",$alg); $alg = preg_replace("/CDR2-/","<707>",$alg);   $alg = preg_replace("/CDR'/","<708>",$alg); $alg = preg_replace("/CDR-/","<708>",$alg);   $alg = preg_replace("/CDR2/","<705>",$alg);   $alg = preg_replace("/CDR/","<706>",$alg);
    $alg = preg_replace("/CBL2'/","<711>",$alg); $alg = preg_replace("/CBL2-/","<711>",$alg);   $alg = preg_replace("/CBL'/","<712>",$alg); $alg = preg_replace("/CBL-/","<712>",$alg);   $alg = preg_replace("/CBL2/","<709>",$alg);   $alg = preg_replace("/CBL/","<710>",$alg);
    $alg = preg_replace("/CBR2'/","<715>",$alg); $alg = preg_replace("/CBR2-/","<715>",$alg);   $alg = preg_replace("/CBR'/","<716>",$alg); $alg = preg_replace("/CBR-/","<716>",$alg);   $alg = preg_replace("/CBR2/","<713>",$alg);   $alg = preg_replace("/CBR/","<714>",$alg);
    
    $alg = preg_replace("/CR2'/", "<709>",$alg); $alg = preg_replace("/CR2-/", "<709>",$alg);   $alg = preg_replace("/CR'/", "<710>",$alg); $alg = preg_replace("/CR-/", "<710>",$alg);   $alg = preg_replace("/CR2/", "<711>",$alg);   $alg = preg_replace("/CR/", "<712>",$alg);
    $alg = preg_replace("/CL2'/", "<713>",$alg); $alg = preg_replace("/CL2-/", "<713>",$alg);   $alg = preg_replace("/CL'/", "<714>",$alg); $alg = preg_replace("/CL-/", "<714>",$alg);   $alg = preg_replace("/CL2/", "<715>",$alg);   $alg = preg_replace("/CL/", "<716>",$alg);
    $alg = preg_replace("/CF2'/", "<717>",$alg); $alg = preg_replace("/CF2-/", "<717>",$alg);   $alg = preg_replace("/CF'/", "<718>",$alg); $alg = preg_replace("/CF-/", "<718>",$alg);   $alg = preg_replace("/CF2/", "<719>",$alg);   $alg = preg_replace("/CF/", "<720>",$alg);
    $alg = preg_replace("/CB2'/", "<719>",$alg); $alg = preg_replace("/CB2-/", "<719>",$alg);   $alg = preg_replace("/CB'/", "<720>",$alg); $alg = preg_replace("/CB-/", "<720>",$alg);   $alg = preg_replace("/CB2/", "<717>",$alg);   $alg = preg_replace("/CB/", "<718>",$alg);
    $alg = preg_replace("/CU2'/", "<721>",$alg); $alg = preg_replace("/CU2-/", "<721>",$alg);   $alg = preg_replace("/CU'/", "<722>",$alg); $alg = preg_replace("/CU-/", "<722>",$alg);   $alg = preg_replace("/CU2/", "<723>",$alg);   $alg = preg_replace("/CU/", "<724>",$alg);
    $alg = preg_replace("/CD2'/", "<723>",$alg); $alg = preg_replace("/CD2-/", "<723>",$alg);   $alg = preg_replace("/CD'/", "<724>",$alg); $alg = preg_replace("/CD-/", "<724>",$alg);   $alg = preg_replace("/CD2/", "<721>",$alg);   $alg = preg_replace("/CD/", "<722>",$alg);
    
    /* --- 5xD: SSE -> CODE: [9] Face twists --- */
    //<s> /*   */
    $alg = preg_replace("/UR2'/","<901>",$alg); $alg = preg_replace("/UR2-/","<901>",$alg);   $alg = preg_replace("/UR'/","<902>",$alg); $alg = preg_replace("/UR-/","<902>",$alg);   $alg = preg_replace("/UR2/","<903>",$alg);   $alg = preg_replace("/UR/","<904>",$alg);
    $alg = preg_replace("/DL2'/","<905>",$alg); $alg = preg_replace("/DL2-/","<905>",$alg);   $alg = preg_replace("/DL'/","<906>",$alg); $alg = preg_replace("/DL-/","<906>",$alg);   $alg = preg_replace("/DL2/","<907>",$alg);   $alg = preg_replace("/DL/","<908>",$alg);
    $alg = preg_replace("/UL2'/","<909>",$alg); $alg = preg_replace("/UL2-/","<909>",$alg);   $alg = preg_replace("/UL'/","<910>",$alg); $alg = preg_replace("/UL-/","<910>",$alg);   $alg = preg_replace("/UL2/","<911>",$alg);   $alg = preg_replace("/UL/","<912>",$alg);
    $alg = preg_replace("/DR2'/","<913>",$alg); $alg = preg_replace("/DR2-/","<913>",$alg);   $alg = preg_replace("/DR'/","<914>",$alg); $alg = preg_replace("/DR-/","<914>",$alg);   $alg = preg_replace("/DR2/","<915>",$alg);   $alg = preg_replace("/DR/","<916>",$alg);
    $alg = preg_replace("/BL2'/","<921>",$alg); $alg = preg_replace("/BL2-/","<921>",$alg);   $alg = preg_replace("/BL'/","<922>",$alg); $alg = preg_replace("/BL-/","<922>",$alg);   $alg = preg_replace("/BL2/","<923>",$alg);   $alg = preg_replace("/BL/","<924>",$alg);
    $alg = preg_replace("/BR2'/","<929>",$alg); $alg = preg_replace("/BR2-/","<929>",$alg);   $alg = preg_replace("/BR'/","<930>",$alg); $alg = preg_replace("/BR-/","<930>",$alg);   $alg = preg_replace("/BR2/","<931>",$alg);   $alg = preg_replace("/BR/","<932>",$alg);
    
    $alg = preg_replace("/R2'/", "<917>",$alg); $alg = preg_replace("/R2-/", "<917>",$alg);   $alg = preg_replace("/R'/", "<918>",$alg); $alg = preg_replace("/R-/", "<918>",$alg);   $alg = preg_replace("/R2/", "<919>",$alg);   $alg = preg_replace("/R/", "<920>",$alg);
    $alg = preg_replace("/L2'/", "<925>",$alg); $alg = preg_replace("/L2-/", "<925>",$alg);   $alg = preg_replace("/L'/", "<926>",$alg); $alg = preg_replace("/L-/", "<926>",$alg);   $alg = preg_replace("/L2/", "<927>",$alg);   $alg = preg_replace("/L/", "<928>",$alg);
    $alg = preg_replace("/F2'/", "<933>",$alg); $alg = preg_replace("/F2-/", "<933>",$alg);   $alg = preg_replace("/F'/", "<934>",$alg); $alg = preg_replace("/F-/", "<934>",$alg);   $alg = preg_replace("/F2/", "<935>",$alg);   $alg = preg_replace("/F/", "<936>",$alg);
    $alg = preg_replace("/B2'/", "<937>",$alg); $alg = preg_replace("/B2-/", "<937>",$alg);   $alg = preg_replace("/B'/", "<938>",$alg); $alg = preg_replace("/B-/", "<938>",$alg);   $alg = preg_replace("/B2/", "<939>",$alg);   $alg = preg_replace("/B/", "<940>",$alg);
    $alg = preg_replace("/U2'/", "<941>",$alg); $alg = preg_replace("/U2-/", "<941>",$alg);   $alg = preg_replace("/U'/", "<942>",$alg); $alg = preg_replace("/U-/", "<942>",$alg);   $alg = preg_replace("/U2/", "<943>",$alg);   $alg = preg_replace("/U/", "<944>",$alg);
    $alg = preg_replace("/D2'/", "<945>",$alg); $alg = preg_replace("/D2-/", "<945>",$alg);   $alg = preg_replace("/D'/", "<946>",$alg); $alg = preg_replace("/D-/", "<946>",$alg);   $alg = preg_replace("/D2/", "<947>",$alg);   $alg = preg_replace("/D/", "<948>",$alg);
    
    /* ··································································································· */
    /* --- 5xD: CODE -> TWIZZLE: [1] Numbered layer twists [5] Mid-layer twists --- */
    //<s> /* N | N4 */
    $alg = preg_replace("/<101>/","2BR2'",$alg);   $alg = preg_replace("/<102>/","2BR'",$alg);   $alg = preg_replace("/<103>/","2BR2",$alg);   $alg = preg_replace("/<104>/","2BR",$alg);
    $alg = preg_replace("/<105>/","2FL2'",$alg);   $alg = preg_replace("/<106>/","2FL'",$alg);   $alg = preg_replace("/<107>/","2FL2",$alg);   $alg = preg_replace("/<108>/","2FL",$alg);
    $alg = preg_replace("/<109>/","2BL2'",$alg);   $alg = preg_replace("/<110>/","2BL'",$alg);   $alg = preg_replace("/<111>/","2BL2",$alg);   $alg = preg_replace("/<112>/","2BL",$alg);
    $alg = preg_replace("/<113>/","2FR2'",$alg);   $alg = preg_replace("/<114>/","2FR'",$alg);   $alg = preg_replace("/<115>/","2FR2",$alg);   $alg = preg_replace("/<116>/","2FR",$alg);
    $alg = preg_replace("/<121>/","2DL2'",$alg);   $alg = preg_replace("/<122>/","2DL'",$alg);   $alg = preg_replace("/<123>/","2DL2",$alg);   $alg = preg_replace("/<124>/","2DL",$alg);
    $alg = preg_replace("/<129>/","2DR2'",$alg);   $alg = preg_replace("/<130>/","2DR'",$alg);   $alg = preg_replace("/<131>/","2DR2",$alg);   $alg = preg_replace("/<132>/","2DR",$alg);
    
    $alg = preg_replace("/<117>/","2R2'", $alg);   $alg = preg_replace("/<118>/","2R'", $alg);   $alg = preg_replace("/<119>/","2R2", $alg);   $alg = preg_replace("/<120>/","2R", $alg);
    $alg = preg_replace("/<125>/","2L2'", $alg);   $alg = preg_replace("/<126>/","2L'", $alg);   $alg = preg_replace("/<127>/","2L2", $alg);   $alg = preg_replace("/<128>/","2L", $alg);
    $alg = preg_replace("/<133>/","2F2'", $alg);   $alg = preg_replace("/<134>/","2F'", $alg);   $alg = preg_replace("/<135>/","2F2", $alg);   $alg = preg_replace("/<136>/","2F", $alg);
    $alg = preg_replace("/<137>/","2B2'", $alg);   $alg = preg_replace("/<138>/","2B'", $alg);   $alg = preg_replace("/<139>/","2B2", $alg);   $alg = preg_replace("/<140>/","2B", $alg);
    $alg = preg_replace("/<141>/","2U2'", $alg);   $alg = preg_replace("/<142>/","2U'", $alg);   $alg = preg_replace("/<143>/","2U2", $alg);   $alg = preg_replace("/<144>/","2U", $alg);
    $alg = preg_replace("/<145>/","2D2'", $alg);   $alg = preg_replace("/<146>/","2D'", $alg);   $alg = preg_replace("/<147>/","2D2", $alg);   $alg = preg_replace("/<148>/","2D", $alg);
    
    
    //<s> /* N3 = M */
    $alg = preg_replace("/<149>/","3BR2'",$alg);   $alg = preg_replace("/<150>/","3BR'",$alg);   $alg = preg_replace("/<151>/","3BR2",$alg);   $alg = preg_replace("/<152>/","3BR",$alg);
    $alg = preg_replace("/<153>/","3BL2'",$alg);   $alg = preg_replace("/<154>/","3BL'",$alg);   $alg = preg_replace("/<155>/","3BL2",$alg);   $alg = preg_replace("/<156>/","3BL",$alg);
    
    $alg = preg_replace("/<157>/","3R2'", $alg);   $alg = preg_replace("/<158>/","3R'", $alg);   $alg = preg_replace("/<159>/","3R2", $alg);   $alg = preg_replace("/<160>/","3R", $alg);
    $alg = preg_replace("/<161>/","3L2'", $alg);   $alg = preg_replace("/<162>/","3L'", $alg);   $alg = preg_replace("/<163>/","3L2", $alg);   $alg = preg_replace("/<164>/","3L", $alg);
    $alg = preg_replace("/<165>/","3F2'", $alg);   $alg = preg_replace("/<166>/","3F'", $alg);   $alg = preg_replace("/<167>/","3F2", $alg);   $alg = preg_replace("/<168>/","3F", $alg);
    $alg = preg_replace("/<169>/","3U2'", $alg);   $alg = preg_replace("/<170>/","3U'", $alg);   $alg = preg_replace("/<171>/","3U2", $alg);   $alg = preg_replace("/<172>/","3U", $alg);
    
    /* --- 5xD: CODE -> TWIZZLE: [2] Slice twists --- */
    //<s> /* S2 = S3-3 */
    $alg = preg_replace("/<201>/","br2' fl2",$alg);   $alg = preg_replace("/<202>/","br' fl",$alg);   $alg = preg_replace("/<203>/","br2 fl2'",$alg);   $alg = preg_replace("/<204>/","br fl'",$alg);
    $alg = preg_replace("/<205>/","bl2' fr2",$alg);   $alg = preg_replace("/<206>/","bl' fr",$alg);   $alg = preg_replace("/<207>/","bl2 fr2'",$alg);   $alg = preg_replace("/<208>/","bl fr'",$alg);
    
    $alg = preg_replace("/<209>/","r2' dl2", $alg);   $alg = preg_replace("/<210>/","r' dl", $alg);   $alg = preg_replace("/<211>/","r2 dl2'", $alg);   $alg = preg_replace("/<212>/","r dl'", $alg);
    $alg = preg_replace("/<213>/","l2' dr2", $alg);   $alg = preg_replace("/<214>/","l' dr", $alg);   $alg = preg_replace("/<215>/","l2 dr2'", $alg);   $alg = preg_replace("/<216>/","l dr'", $alg);
    $alg = preg_replace("/<217>/","f2' b2",  $alg);   $alg = preg_replace("/<218>/","f' b",  $alg);   $alg = preg_replace("/<219>/","f2 b2'",  $alg);   $alg = preg_replace("/<220>/","f b'",  $alg);
    $alg = preg_replace("/<221>/","u2' d2",  $alg);   $alg = preg_replace("/<222>/","u' d",  $alg);   $alg = preg_replace("/<223>/","u2 d2'",  $alg);   $alg = preg_replace("/<224>/","u d'",  $alg);
    
    
    //<s> /* S = S2-4 */
    $alg = preg_replace("/<225>/","BR2' FL2",$alg);   $alg = preg_replace("/<226>/","BR' FL",$alg);   $alg = preg_replace("/<227>/","BR2 FL2'",$alg);   $alg = preg_replace("/<228>/","BR FL'",$alg);
    $alg = preg_replace("/<229>/","BL2' FR2",$alg);   $alg = preg_replace("/<230>/","BL' FR",$alg);   $alg = preg_replace("/<231>/","BL2 FR2'",$alg);   $alg = preg_replace("/<232>/","BL FR'",$alg);
    
    $alg = preg_replace("/<233>/","R2' DL2", $alg);   $alg = preg_replace("/<234>/","R' DL", $alg);   $alg = preg_replace("/<235>/","R2 DL2'", $alg);   $alg = preg_replace("/<236>/","R DL'", $alg);
    $alg = preg_replace("/<237>/","L2' DR2", $alg);   $alg = preg_replace("/<238>/","L' DR", $alg);   $alg = preg_replace("/<239>/","L2 DR2'", $alg);   $alg = preg_replace("/<240>/","L DR'", $alg);
    $alg = preg_replace("/<241>/","F2' B2",  $alg);   $alg = preg_replace("/<242>/","F' B",  $alg);   $alg = preg_replace("/<243>/","F2 B2'",  $alg);   $alg = preg_replace("/<244>/","F B'",  $alg);
    $alg = preg_replace("/<245>/","U2' D2",  $alg);   $alg = preg_replace("/<246>/","U' D",  $alg);   $alg = preg_replace("/<247>/","U2 D2'", $alg);    $alg = preg_replace("/<248>/","U D'",  $alg);
    
    
    //<s> /* S2-2 | S4-4 */
    $alg = preg_replace("/<249>/","BR2' 1-3FL2",$alg);   $alg = preg_replace("/<250>/","BR' 1-3FL",$alg);   $alg = preg_replace("/<251>/","BR2 1-3FL2'",$alg);   $alg = preg_replace("/<252>/","BR 1-3FL'",$alg);
    $alg = preg_replace("/<253>/","1-3BR2 FL2'",$alg);   $alg = preg_replace("/<254>/","1-3BR FL'",$alg);   $alg = preg_replace("/<255>/","1-3BR2' FL2",$alg);   $alg = preg_replace("/<256>/","1-3BR' FL",$alg);
    $alg = preg_replace("/<257>/","BL2' 1-3FR2",$alg);   $alg = preg_replace("/<258>/","BL' 1-3FR",$alg);   $alg = preg_replace("/<259>/","BL2 1-3FR2'",$alg);   $alg = preg_replace("/<260>/","BL 1-3FR'",$alg);
    $alg = preg_replace("/<261>/","1-3BL2 FR2'",$alg);   $alg = preg_replace("/<262>/","1-3BL FR'",$alg);   $alg = preg_replace("/<263>/","1-3BL2' FR2",$alg);   $alg = preg_replace("/<264>/","1-3BL' FR",$alg);
    $alg = preg_replace("/<269>/","1-3R2 DL2'", $alg);   $alg = preg_replace("/<270>/","1-3R DL'", $alg);   $alg = preg_replace("/<271>/","1-3R2' DL2", $alg);   $alg = preg_replace("/<272>/","1-3R' DL", $alg);
    $alg = preg_replace("/<277>/","1-3L2 DR2'", $alg);   $alg = preg_replace("/<278>/","1-3L DR'", $alg);   $alg = preg_replace("/<279>/","1-3L2' DR2", $alg);   $alg = preg_replace("/<280>/","1-3L' DR", $alg);
    
    $alg = preg_replace("/<265>/","R2' 1-3DL2",$alg);    $alg = preg_replace("/<266>/","R' 1-3DL",$alg);    $alg = preg_replace("/<267>/","R2 1-3DL2'", $alg);   $alg = preg_replace("/<268>/","R 1-3DL'", $alg);
    $alg = preg_replace("/<273>/","L2' 1-3DR2",$alg);    $alg = preg_replace("/<274>/","L' 1-3DR",$alg);    $alg = preg_replace("/<275>/","L2 1-3DR2'", $alg);   $alg = preg_replace("/<276>/","L 1-3DR'", $alg);
    $alg = preg_replace("/<281>/","F2' 1-3B2", $alg);    $alg = preg_replace("/<282>/","F' 1-3B", $alg);    $alg = preg_replace("/<283>/","F2 1-3B2'",  $alg);   $alg = preg_replace("/<284>/","F 1-3B'",  $alg);
    $alg = preg_replace("/<285>/","1-3F2 B2'", $alg);    $alg = preg_replace("/<286>/","1-3F B'", $alg);    $alg = preg_replace("/<287>/","1-3F2' B2",  $alg);   $alg = preg_replace("/<288>/","1-3F' B",  $alg);
    $alg = preg_replace("/<289>/","U2' 1-3D2", $alg);    $alg = preg_replace("/<290>/","U' 1-3D", $alg);    $alg = preg_replace("/<291>/","U2 1-3D2'",  $alg);   $alg = preg_replace("/<292>/","U 1-3D'",  $alg);
    $alg = preg_replace("/<293>/","1-3U2 D2'", $alg);    $alg = preg_replace("/<294>/","1-3U D'", $alg);    $alg = preg_replace("/<295>/","1-3U2' D2",  $alg);   $alg = preg_replace("/<296>/","1-3U' D",  $alg);
    
    
    //<s> /* S2-3 | S3-4 */
    $alg = preg_replace("/<297>/", "BR2' fl2",$alg);   $alg = preg_replace("/<298>/", "BR' fl",$alg);   $alg = preg_replace("/<299>/", "BR2 fl2'",$alg);   $alg = preg_replace("/<2100>/","BR fl'",$alg);
    $alg = preg_replace("/<2101>/","br2 FL2'",$alg);   $alg = preg_replace("/<2102>/","br FL'",$alg);   $alg = preg_replace("/<2103>/","br2' FL2",$alg);   $alg = preg_replace("/<2104>/","br' FL",$alg);
    $alg = preg_replace("/<2105>/","BL2' fr2",$alg);   $alg = preg_replace("/<2106>/","BL' fr",$alg);   $alg = preg_replace("/<2107>/","BL2 fr2'",$alg);   $alg = preg_replace("/<2108>/","BL fr'",$alg);
    $alg = preg_replace("/<2109>/","bl2 FR2'",$alg);   $alg = preg_replace("/<2110>/","bl FR'",$alg);   $alg = preg_replace("/<2111>/","bl2' FR2",$alg);   $alg = preg_replace("/<2112>/","bl' FR",$alg);
    $alg = preg_replace("/<2117>/","r2 DL2'", $alg);   $alg = preg_replace("/<2118>/","r DL'", $alg);   $alg = preg_replace("/<2119>/","r2' DL2", $alg);   $alg = preg_replace("/<2120>/","r' DL", $alg);
    $alg = preg_replace("/<2125>/","l2 DR2'", $alg);   $alg = preg_replace("/<2126>/","l DR'", $alg);   $alg = preg_replace("/<2127>/","l2' DR2", $alg);   $alg = preg_replace("/<2128>/","l' DR", $alg);
   
    $alg = preg_replace("/<2113>/","R2' dl2", $alg);   $alg = preg_replace("/<2114>/","R' dl", $alg);   $alg = preg_replace("/<2115>/","R2 dl2'", $alg);   $alg = preg_replace("/<2116>/","R dl'", $alg);
    $alg = preg_replace("/<2121>/","L2' dr2", $alg);   $alg = preg_replace("/<2122>/","L' dr", $alg);   $alg = preg_replace("/<2123>/","L2 dr2'", $alg);   $alg = preg_replace("/<2124>/","L dr'", $alg);
    $alg = preg_replace("/<2129>/","F2' b2",  $alg);   $alg = preg_replace("/<2130>/","F' b",  $alg);   $alg = preg_replace("/<2131>/","F2 b2'",  $alg);   $alg = preg_replace("/<2132>/","F b'",  $alg);
    $alg = preg_replace("/<2133>/","f2 B2'",  $alg);   $alg = preg_replace("/<2134>/","f B'",  $alg);   $alg = preg_replace("/<2135>/","f2' B2",  $alg);   $alg = preg_replace("/<2136>/","f' B",  $alg);
    $alg = preg_replace("/<2137>/","U2' d2",  $alg);   $alg = preg_replace("/<2138>/","U' d",  $alg);   $alg = preg_replace("/<2139>/","U2 d2'",  $alg);   $alg = preg_replace("/<2140>/","U d'",  $alg);
    $alg = preg_replace("/<2141>/","u2 D2'",  $alg);   $alg = preg_replace("/<2142>/","u D'",  $alg);   $alg = preg_replace("/<2143>/","u2' D2",  $alg);   $alg = preg_replace("/<2144>/","u' D",  $alg);
    
    
    $alg = preg_replace("/<2193>/","br2' FL2",$alg);   $alg = preg_replace("/<2194>/","br' FL",$alg);   $alg = preg_replace("/<2195>/","br2 FL2'",$alg);   $alg = preg_replace("/<2196>/","br FL'",$alg);
    $alg = preg_replace("/<2197>/","bl2' FR2",$alg);   $alg = preg_replace("/<2198>/","bl' FR",$alg);   $alg = preg_replace("/<2199>/","bl2 FR2'",$alg);   $alg = preg_replace("/<2200>/","bl FR'",$alg);
    $alg = preg_replace("/<2201>/","fr2' BL2",$alg);   $alg = preg_replace("/<2202>/","fr' BL",$alg);   $alg = preg_replace("/<2203>/","fr2 BL2'",$alg);   $alg = preg_replace("/<2204>/","fr BL'",$alg);
    $alg = preg_replace("/<2205>/","fl2' BR2",$alg);   $alg = preg_replace("/<2206>/","fl' BR",$alg);   $alg = preg_replace("/<2207>/","fl2 BR2'",$alg);   $alg = preg_replace("/<2208>/","fl BR'",$alg);
    $alg = preg_replace("/<2209>/","dr2' L2", $alg);   $alg = preg_replace("/<2210>/","dr' L", $alg);   $alg = preg_replace("/<2211>/","dr2 L2'", $alg);   $alg = preg_replace("/<2212>/","dr L'", $alg);
    $alg = preg_replace("/<2213>/","dl2' R2", $alg);   $alg = preg_replace("/<2214>/","dl' R", $alg);   $alg = preg_replace("/<2215>/","dl2 R2'", $alg);   $alg = preg_replace("/<2216>/","dl R'", $alg);
    
    $alg = preg_replace("/<2217>/","r2' DL2", $alg);   $alg = preg_replace("/<2218>/","r' DL", $alg);   $alg = preg_replace("/<2219>/","r2 DL2'", $alg);   $alg = preg_replace("/<2220>/","r DL'", $alg);
    $alg = preg_replace("/<2221>/","l2' DR2", $alg);   $alg = preg_replace("/<2222>/","l' DR", $alg);   $alg = preg_replace("/<2223>/","l2 DR2'", $alg);   $alg = preg_replace("/<2224>/","l DR'", $alg);
    $alg = preg_replace("/<2225>/","f2' B2",  $alg);   $alg = preg_replace("/<2226>/","f' B",  $alg);   $alg = preg_replace("/<2227>/","f2 B2'",  $alg);   $alg = preg_replace("/<2228>/","f B'",  $alg);
    $alg = preg_replace("/<2229>/","b2' F2",  $alg);   $alg = preg_replace("/<2230>/","b' F",  $alg);   $alg = preg_replace("/<2231>/","b2 F2'",  $alg);   $alg = preg_replace("/<2232>/","b F'",  $alg);
    $alg = preg_replace("/<2233>/","u2' D2",  $alg);   $alg = preg_replace("/<2234>/","u' D",  $alg);   $alg = preg_replace("/<2235>/","u2 D2'",  $alg);   $alg = preg_replace("/<2236>/","u D'",  $alg);
    $alg = preg_replace("/<2237>/","d2' U2",  $alg);   $alg = preg_replace("/<2238>/","d' U",  $alg);   $alg = preg_replace("/<2239>/","d2 U2'",  $alg);   $alg = preg_replace("/<2240>/","d U'",  $alg);
    
    /* --- 5xD: CODE -> TWIZZLE: [3] Tier twists --- */
    //<s> /* T4 */
    $alg = preg_replace("/<301>/","1-4BR2'",$alg);   $alg = preg_replace("/<302>/","1-4BR'",$alg);   $alg = preg_replace("/<303>/","1-4BR2",$alg);   $alg = preg_replace("/<304>/","1-4BR",$alg);
    $alg = preg_replace("/<305>/","1-4FL2'",$alg);   $alg = preg_replace("/<306>/","1-4FL'",$alg);   $alg = preg_replace("/<307>/","1-4FL2",$alg);   $alg = preg_replace("/<308>/","1-4FL",$alg);
    $alg = preg_replace("/<309>/","1-4BL2'",$alg);   $alg = preg_replace("/<310>/","1-4BL'",$alg);   $alg = preg_replace("/<311>/","1-4BL2",$alg);   $alg = preg_replace("/<312>/","1-4BL",$alg);
    $alg = preg_replace("/<313>/","1-4FR2'",$alg);   $alg = preg_replace("/<314>/","1-4FR'",$alg);   $alg = preg_replace("/<315>/","1-4FR2",$alg);   $alg = preg_replace("/<316>/","1-4FR",$alg);
    $alg = preg_replace("/<321>/","1-4DL2'",$alg);   $alg = preg_replace("/<322>/","1-4DL'",$alg);   $alg = preg_replace("/<323>/","1-4DL2",$alg);   $alg = preg_replace("/<324>/","1-4DL",$alg);
    $alg = preg_replace("/<329>/","1-4DR2'",$alg);   $alg = preg_replace("/<330>/","1-4DR'",$alg);   $alg = preg_replace("/<331>/","1-4DR2",$alg);   $alg = preg_replace("/<332>/","1-4DR",$alg);
    
    $alg = preg_replace("/<317>/","1-4R2'", $alg);   $alg = preg_replace("/<318>/","1-4R'", $alg);   $alg = preg_replace("/<319>/","1-4R2", $alg);   $alg = preg_replace("/<320>/","1-4R", $alg);
    $alg = preg_replace("/<325>/","1-4L2'", $alg);   $alg = preg_replace("/<326>/","1-4L'", $alg);   $alg = preg_replace("/<327>/","1-4L2", $alg);   $alg = preg_replace("/<328>/","1-4L", $alg);
    $alg = preg_replace("/<333>/","1-4F2'", $alg);   $alg = preg_replace("/<334>/","1-4F'", $alg);   $alg = preg_replace("/<335>/","1-4F2", $alg);   $alg = preg_replace("/<336>/","1-4F", $alg);
    $alg = preg_replace("/<337>/","1-4B2'", $alg);   $alg = preg_replace("/<338>/","1-4B'", $alg);   $alg = preg_replace("/<339>/","1-4B2", $alg);   $alg = preg_replace("/<340>/","1-4B", $alg);
    $alg = preg_replace("/<341>/","1-4U2'", $alg);   $alg = preg_replace("/<342>/","1-4U'", $alg);   $alg = preg_replace("/<343>/","1-4U2", $alg);   $alg = preg_replace("/<344>/","1-4U", $alg);
    $alg = preg_replace("/<345>/","1-4D2'", $alg);   $alg = preg_replace("/<346>/","1-4D'", $alg);   $alg = preg_replace("/<347>/","1-4D2", $alg);   $alg = preg_replace("/<348>/","1-4D", $alg);
    
    
    //<s> /* T3 */
    $alg = preg_replace("/<349>/","1-3BR2'",$alg);   $alg = preg_replace("/<350>/","1-3BR'",$alg);   $alg = preg_replace("/<351>/","1-3BR2",$alg);   $alg = preg_replace("/<352>/","1-3BR",$alg);
    $alg = preg_replace("/<353>/","1-3FL2'",$alg);   $alg = preg_replace("/<354>/","1-3FL'",$alg);   $alg = preg_replace("/<355>/","1-3FL2",$alg);   $alg = preg_replace("/<356>/","1-3FL",$alg);
    $alg = preg_replace("/<357>/","1-3BL2'",$alg);   $alg = preg_replace("/<358>/","1-3BL'",$alg);   $alg = preg_replace("/<359>/","1-3BL2",$alg);   $alg = preg_replace("/<360>/","1-3BL",$alg);
    $alg = preg_replace("/<361>/","1-3FR2'",$alg);   $alg = preg_replace("/<362>/","1-3FR'",$alg);   $alg = preg_replace("/<363>/","1-3FR2",$alg);   $alg = preg_replace("/<364>/","1-3FR",$alg);
    $alg = preg_replace("/<369>/","1-3DL2'",$alg);   $alg = preg_replace("/<370>/","1-3DL'",$alg);   $alg = preg_replace("/<371>/","1-3DL2",$alg);   $alg = preg_replace("/<372>/","1-3DL",$alg);
    $alg = preg_replace("/<377>/","1-3DR2'",$alg);   $alg = preg_replace("/<378>/","1-3DR'",$alg);   $alg = preg_replace("/<379>/","1-3DR2",$alg);   $alg = preg_replace("/<380>/","1-3DR",$alg);
    
    $alg = preg_replace("/<365>/","1-3R2'", $alg);   $alg = preg_replace("/<366>/","1-3R'", $alg);   $alg = preg_replace("/<367>/","1-3R2", $alg);   $alg = preg_replace("/<368>/","1-3R", $alg);
    $alg = preg_replace("/<373>/","1-3L2'", $alg);   $alg = preg_replace("/<374>/","1-3L'", $alg);   $alg = preg_replace("/<375>/","1-3L2", $alg);   $alg = preg_replace("/<376>/","1-3L", $alg);
    $alg = preg_replace("/<381>/","1-3F2'", $alg);   $alg = preg_replace("/<382>/","1-3F'", $alg);   $alg = preg_replace("/<383>/","1-3F2", $alg);   $alg = preg_replace("/<384>/","1-3F", $alg);
    $alg = preg_replace("/<385>/","1-3B2'", $alg);   $alg = preg_replace("/<386>/","1-3B'", $alg);   $alg = preg_replace("/<387>/","1-3B2", $alg);   $alg = preg_replace("/<388>/","1-3B", $alg);
    $alg = preg_replace("/<389>/","1-3U2'", $alg);   $alg = preg_replace("/<390>/","1-3U'", $alg);   $alg = preg_replace("/<391>/","1-3U2", $alg);   $alg = preg_replace("/<392>/","1-3U", $alg);
    $alg = preg_replace("/<393>/","1-3D2'", $alg);   $alg = preg_replace("/<394>/","1-3D'", $alg);   $alg = preg_replace("/<395>/","1-3D2", $alg);   $alg = preg_replace("/<396>/","1-3D", $alg);
    
    
    //<s> /* T */
    $alg = preg_replace("/<397>/", "br2'",$alg);   $alg = preg_replace("/<398>/", "br'",$alg);   $alg = preg_replace("/<399>/", "br2",$alg);   $alg = preg_replace("/<3100>/","br",$alg);
    $alg = preg_replace("/<3101>/","fl2'",$alg);   $alg = preg_replace("/<3102>/","fl'",$alg);   $alg = preg_replace("/<3103>/","fl2",$alg);   $alg = preg_replace("/<3104>/","fl",$alg);
    $alg = preg_replace("/<3105>/","bl2'",$alg);   $alg = preg_replace("/<3106>/","bl'",$alg);   $alg = preg_replace("/<3107>/","bl2",$alg);   $alg = preg_replace("/<3108>/","bl",$alg);
    $alg = preg_replace("/<3109>/","fr2'",$alg);   $alg = preg_replace("/<3110>/","fr'",$alg);   $alg = preg_replace("/<3111>/","fr2",$alg);   $alg = preg_replace("/<3112>/","fr",$alg);
    $alg = preg_replace("/<3117>/","dl2'",$alg);   $alg = preg_replace("/<3118>/","dl'",$alg);   $alg = preg_replace("/<3119>/","dl2",$alg);   $alg = preg_replace("/<3120>/","dl",$alg);
    $alg = preg_replace("/<3125>/","dr2'",$alg);   $alg = preg_replace("/<3126>/","dr'",$alg);   $alg = preg_replace("/<3127>/","dr2",$alg);   $alg = preg_replace("/<3128>/","dr",$alg);
    
    $alg = preg_replace("/<3113>/","r2'", $alg);   $alg = preg_replace("/<3114>/","r'", $alg);   $alg = preg_replace("/<3115>/","r2", $alg);   $alg = preg_replace("/<3116>/","r", $alg);
    $alg = preg_replace("/<3121>/","l2'", $alg);   $alg = preg_replace("/<3122>/","l'", $alg);   $alg = preg_replace("/<3123>/","l2", $alg);   $alg = preg_replace("/<3124>/","l", $alg);
    $alg = preg_replace("/<3129>/","f2'", $alg);   $alg = preg_replace("/<3130>/","f'", $alg);   $alg = preg_replace("/<3131>/","f2", $alg);   $alg = preg_replace("/<3132>/","f", $alg);
    $alg = preg_replace("/<3133>/","b2'", $alg);   $alg = preg_replace("/<3134>/","b'", $alg);   $alg = preg_replace("/<3135>/","b2", $alg);   $alg = preg_replace("/<3136>/","b", $alg);
    $alg = preg_replace("/<3137>/","u2'", $alg);   $alg = preg_replace("/<3138>/","u'", $alg);   $alg = preg_replace("/<3139>/","u2", $alg);   $alg = preg_replace("/<3140>/","u", $alg);
    $alg = preg_replace("/<3141>/","d2'", $alg);   $alg = preg_replace("/<3142>/","d'", $alg);   $alg = preg_replace("/<3143>/","d2", $alg);   $alg = preg_replace("/<3144>/","d", $alg);
    
    /* --- 5xD: CODE -> TWIZZLE: [4] (Void twists) --- */
    //<s> /* V = M2, N2-3 | N3-4 */
    $alg = preg_replace("/<401>/","2-3BR2'",$alg);   $alg = preg_replace("/<402>/","2-3BR'",$alg);   $alg = preg_replace("/<403>/","2-3BR2",$alg);   $alg = preg_replace("/<404>/","2-3BR",$alg);
    $alg = preg_replace("/<405>/","2-3FL2'",$alg);   $alg = preg_replace("/<406>/","2-3FL'",$alg);   $alg = preg_replace("/<407>/","2-3FL2",$alg);   $alg = preg_replace("/<408>/","2-3FL",$alg);
    $alg = preg_replace("/<409>/","2-3BL2'",$alg);   $alg = preg_replace("/<410>/","2-3BL'",$alg);   $alg = preg_replace("/<411>/","2-3BL2",$alg);   $alg = preg_replace("/<412>/","2-3BL",$alg);
    $alg = preg_replace("/<413>/","2-3FR2'",$alg);   $alg = preg_replace("/<414>/","2-3FR'",$alg);   $alg = preg_replace("/<415>/","2-3FR2",$alg);   $alg = preg_replace("/<416>/","2-3FR",$alg);
    $alg = preg_replace("/<421>/","2-3DL2'",$alg);   $alg = preg_replace("/<422>/","2-3DL'",$alg);   $alg = preg_replace("/<423>/","2-3DL2",$alg);   $alg = preg_replace("/<424>/","2-3DL",$alg);
    $alg = preg_replace("/<429>/","2-3DR2'",$alg);   $alg = preg_replace("/<430>/","2-3DR'",$alg);   $alg = preg_replace("/<431>/","2-3DR2",$alg);   $alg = preg_replace("/<432>/","2-3DR",$alg);
    
    $alg = preg_replace("/<417>/","2-3R2'", $alg);   $alg = preg_replace("/<418>/","2-3R'", $alg);   $alg = preg_replace("/<419>/","2-3R2", $alg);   $alg = preg_replace("/<420>/","2-3R", $alg);
    $alg = preg_replace("/<425>/","2-3L2'", $alg);   $alg = preg_replace("/<426>/","2-3L'", $alg);   $alg = preg_replace("/<427>/","2-3L2", $alg);   $alg = preg_replace("/<428>/","2-3L", $alg);
    $alg = preg_replace("/<433>/","2-3F2'", $alg);   $alg = preg_replace("/<434>/","2-3F'", $alg);   $alg = preg_replace("/<435>/","2-3F2", $alg);   $alg = preg_replace("/<436>/","2-3F", $alg);
    $alg = preg_replace("/<437>/","2-3B2'", $alg);   $alg = preg_replace("/<438>/","2-3B'", $alg);   $alg = preg_replace("/<439>/","2-3B2", $alg);   $alg = preg_replace("/<440>/","2-3B", $alg);
    $alg = preg_replace("/<441>/","2-3U2'", $alg);   $alg = preg_replace("/<442>/","2-3U'", $alg);   $alg = preg_replace("/<443>/","2-3U2", $alg);   $alg = preg_replace("/<444>/","2-3U", $alg);
    $alg = preg_replace("/<445>/","2-3D2'", $alg);   $alg = preg_replace("/<446>/","2-3D'", $alg);   $alg = preg_replace("/<447>/","2-3D2", $alg);   $alg = preg_replace("/<448>/","2-3D", $alg);
    
    /* --- 5xD: CODE -> TWIZZLE: [6] Wide-layer twists [5] (Mid-layer twists) --- */
    //<s> /* M = N = W */
    $alg = preg_replace("/<501>/","2-4BR2'",$alg);   $alg = preg_replace("/<502>/","2-4BR'",$alg);   $alg = preg_replace("/<503>/","2-4BR2",$alg);   $alg = preg_replace("/<504>/","2-4BR",$alg);
    $alg = preg_replace("/<505>/","2-4BL2'",$alg);   $alg = preg_replace("/<506>/","2-4BL'",$alg);   $alg = preg_replace("/<507>/","2-4BL2",$alg);   $alg = preg_replace("/<508>/","2-4BL",$alg);
    
    $alg = preg_replace("/<509>/","2-4R2'", $alg);   $alg = preg_replace("/<510>/","2-4R'", $alg);   $alg = preg_replace("/<511>/","2-4R2", $alg);   $alg = preg_replace("/<512>/","2-4R", $alg);
    $alg = preg_replace("/<513>/","2-4L2'", $alg);   $alg = preg_replace("/<514>/","2-4L'", $alg);   $alg = preg_replace("/<515>/","2-4L2", $alg);   $alg = preg_replace("/<516>/","2-4L", $alg);
    $alg = preg_replace("/<517>/","2-4F2'", $alg);   $alg = preg_replace("/<518>/","2-4F'", $alg);   $alg = preg_replace("/<519>/","2-4F2", $alg);   $alg = preg_replace("/<520>/","2-4F", $alg);
    $alg = preg_replace("/<521>/","2-4U2'", $alg);   $alg = preg_replace("/<522>/","2-4U'", $alg);   $alg = preg_replace("/<523>/","2-4U2", $alg);   $alg = preg_replace("/<524>/","2-4U", $alg);
    
    /* --- 5xD: CODE -> TWIZZLE: [7] Dodecahedron rotations --- */
    //s /* C */
    $alg = preg_replace("/<701>/","BRv2'",$alg);   $alg = preg_replace("/<702>/","BRv'",$alg);   $alg = preg_replace("/<703>/","BRv2",$alg);   $alg = preg_replace("/<704>/","BRv",$alg);
    $alg = preg_replace("/<705>/","BLv2'",$alg);   $alg = preg_replace("/<706>/","BLv'",$alg);   $alg = preg_replace("/<707>/","BLv2",$alg);   $alg = preg_replace("/<708>/","BLv",$alg);
    
    $alg = preg_replace("/<709>/","Rv2'", $alg);   $alg = preg_replace("/<710>/","Rv'", $alg);   $alg = preg_replace("/<711>/","Rv2", $alg);   $alg = preg_replace("/<712>/","Rv", $alg);
    $alg = preg_replace("/<713>/","Lv2'", $alg);   $alg = preg_replace("/<714>/","Lv'", $alg);   $alg = preg_replace("/<715>/","Lv2", $alg);   $alg = preg_replace("/<716>/","Lv", $alg);
    $alg = preg_replace("/<717>/","Fv2'", $alg);   $alg = preg_replace("/<718>/","Fv'", $alg);   $alg = preg_replace("/<719>/","Fv2", $alg);   $alg = preg_replace("/<720>/","Fv", $alg);
    $alg = preg_replace("/<721>/","Uv2'", $alg);   $alg = preg_replace("/<722>/","Uv'", $alg);   $alg = preg_replace("/<723>/","Uv2", $alg);   $alg = preg_replace("/<724>/","Uv", $alg);
    
    /* --- 5xD: CODE -> TWIZZLE: [9] Face twists --- */
    //<s> /*   */
    $alg = preg_replace("/<901>/","BR2'",$alg);   $alg = preg_replace("/<902>/","BR'",$alg);   $alg = preg_replace("/<903>/","BR2",$alg);   $alg = preg_replace("/<904>/","BR",$alg);
    $alg = preg_replace("/<905>/","FL2'",$alg);   $alg = preg_replace("/<906>/","FL'",$alg);   $alg = preg_replace("/<907>/","FL2",$alg);   $alg = preg_replace("/<908>/","FL",$alg);
    $alg = preg_replace("/<909>/","BL2'",$alg);   $alg = preg_replace("/<910>/","BL'",$alg);   $alg = preg_replace("/<911>/","BL2",$alg);   $alg = preg_replace("/<912>/","BL",$alg);
    $alg = preg_replace("/<913>/","FR2'",$alg);   $alg = preg_replace("/<914>/","FR'",$alg);   $alg = preg_replace("/<915>/","FR2",$alg);   $alg = preg_replace("/<916>/","FR",$alg);
    $alg = preg_replace("/<921>/","DL2'",$alg);   $alg = preg_replace("/<922>/","DL'",$alg);   $alg = preg_replace("/<923>/","DL2",$alg);   $alg = preg_replace("/<924>/","DL",$alg);
    $alg = preg_replace("/<929>/","DR2'",$alg);   $alg = preg_replace("/<930>/","DR'",$alg);   $alg = preg_replace("/<931>/","DR2",$alg);   $alg = preg_replace("/<932>/","DR",$alg);
    
    $alg = preg_replace("/<917>/","R2'", $alg);   $alg = preg_replace("/<918>/","R'", $alg);   $alg = preg_replace("/<919>/","R2", $alg);   $alg = preg_replace("/<920>/","R", $alg);
    $alg = preg_replace("/<925>/","L2'", $alg);   $alg = preg_replace("/<926>/","L'", $alg);   $alg = preg_replace("/<927>/","L2", $alg);   $alg = preg_replace("/<928>/","L", $alg);
    $alg = preg_replace("/<933>/","F2'", $alg);   $alg = preg_replace("/<934>/","F'", $alg);   $alg = preg_replace("/<935>/","F2", $alg);   $alg = preg_replace("/<936>/","F", $alg);
    $alg = preg_replace("/<937>/","B2'", $alg);   $alg = preg_replace("/<938>/","B'", $alg);   $alg = preg_replace("/<939>/","B2", $alg);   $alg = preg_replace("/<940>/","B", $alg);
    $alg = preg_replace("/<941>/","U2'", $alg);   $alg = preg_replace("/<942>/","U'", $alg);   $alg = preg_replace("/<943>/","U2", $alg);   $alg = preg_replace("/<944>/","U", $alg);
    $alg = preg_replace("/<945>/","D2'", $alg);   $alg = preg_replace("/<946>/","D'", $alg);   $alg = preg_replace("/<947>/","D2", $alg);   $alg = preg_replace("/<948>/","D", $alg);
    
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
    
    /* --- 5xD: Preferences --- */
    $optSSE = true;  // Optimize SSE (rebuilds Slice twists).
    
    /* --- 5xD: Marker --- */
    $alg = str_replace(".","·",$alg);
    
    /* ··································································································· */
    /* --- 3xD: OLD TWIZZLE -> CODE: [3] Tier twists (TWIZZLE) --- */
    //<s> /* T4 */
    $alg = preg_replace("/1-4BF2'/","<337>",$alg);   $alg = preg_replace("/1-4BF'/","<338>",$alg);   $alg = preg_replace("/1-4BF2/","<339>",$alg);   $alg = preg_replace("/1-4BF/","<340>",$alg); // BF -> B.
    
    $alg = preg_replace("/1-4A2'/", "<305>",$alg);   $alg = preg_replace("/1-4A'/", "<306>",$alg);   $alg = preg_replace("/1-4A2/", "<307>",$alg);   $alg = preg_replace("/1-4A/", "<308>",$alg); // A  -> FL.
    $alg = preg_replace("/1-4C2'/", "<313>",$alg);   $alg = preg_replace("/1-4C'/", "<314>",$alg);   $alg = preg_replace("/1-4C2/", "<315>",$alg);   $alg = preg_replace("/1-4C/", "<316>",$alg); // C  -> FR.
    $alg = preg_replace("/1-4I2'/", "<321>",$alg);   $alg = preg_replace("/1-4I'/", "<322>",$alg);   $alg = preg_replace("/1-4I2/", "<323>",$alg);   $alg = preg_replace("/1-4I/", "<324>",$alg); // I  -> DL.
    $alg = preg_replace("/1-4E2'/", "<329>",$alg);   $alg = preg_replace("/1-4E'/", "<330>",$alg);   $alg = preg_replace("/1-4E2/", "<331>",$alg);   $alg = preg_replace("/1-4E/", "<332>",$alg); // E  -> DR.
    
    
    //<s> /* T3 */
    $alg = preg_replace("/1-3BF2'/","<385>",$alg);   $alg = preg_replace("/1-3BF'/","<386>",$alg);   $alg = preg_replace("/1-3BF2/","<387>",$alg);   $alg = preg_replace("/1-3BF/","<388>",$alg); // BF -> B.
    
    $alg = preg_replace("/1-3A2'/", "<353>",$alg);   $alg = preg_replace("/1-3A'/", "<354>",$alg);   $alg = preg_replace("/1-3A2/", "<355>",$alg);   $alg = preg_replace("/1-3A/", "<356>",$alg); // A -> FL.
    $alg = preg_replace("/1-3C2'/", "<361>",$alg);   $alg = preg_replace("/1-3C'/", "<362>",$alg);   $alg = preg_replace("/1-3C2/", "<363>",$alg);   $alg = preg_replace("/1-3C/", "<364>",$alg); // C -> FR.
    $alg = preg_replace("/1-3I2'/", "<369>",$alg);   $alg = preg_replace("/1-3I'/", "<370>",$alg);   $alg = preg_replace("/1-3I2/", "<371>",$alg);   $alg = preg_replace("/1-3I/", "<372>",$alg); // I -> DL.
    $alg = preg_replace("/1-3E2'/", "<377>",$alg);   $alg = preg_replace("/1-3E'/", "<378>",$alg);   $alg = preg_replace("/1-3E2/", "<379>",$alg);   $alg = preg_replace("/1-3E/", "<380>",$alg); // E -> DR.
    
    
    //<s> /* T */
    $alg = preg_replace("/1-2BF2'/","<3133>",$alg);   $alg = preg_replace("/1-2BF'/","<3134>",$alg);   $alg = preg_replace("/1-2BF2/","<3135>",$alg);   $alg = preg_replace("/1-2BF/","<3136>",$alg); // BF -> B.
    
    $alg = preg_replace("/1-2A2'/", "<3101>",$alg);   $alg = preg_replace("/1-2A'/", "<3102>",$alg);   $alg = preg_replace("/1-2A2/", "<3103>",$alg);   $alg = preg_replace("/1-2A/", "<3104>",$alg); // A -> FL.
    $alg = preg_replace("/1-2C2'/", "<3109>",$alg);   $alg = preg_replace("/1-2C'/", "<3110>",$alg);   $alg = preg_replace("/1-2C2/", "<3111>",$alg);   $alg = preg_replace("/1-2C/", "<3112>",$alg); // C -> FR.
    $alg = preg_replace("/1-2I2'/", "<3117>",$alg);   $alg = preg_replace("/1-2I'/", "<3118>",$alg);   $alg = preg_replace("/1-2I2/", "<3119>",$alg);   $alg = preg_replace("/1-2I/", "<3120>",$alg); // I -> DL.
    $alg = preg_replace("/1-2E2'/", "<3125>",$alg);   $alg = preg_replace("/1-2E'/", "<3126>",$alg);   $alg = preg_replace("/1-2E2/", "<3127>",$alg);   $alg = preg_replace("/1-2E/", "<3128>",$alg); // E -> DR.
    
    /* --- 3xD: TWIZZLE -> CODE: [3] Tier twists (TWIZZLE) --- */
    //<s> /* T4 */
    $alg = preg_replace("/1-4BR2'/","<301>",$alg);   $alg = preg_replace("/1-4BR'/","<302>",$alg);   $alg = preg_replace("/1-4BR2/","<303>",$alg);   $alg = preg_replace("/1-4BR/","<304>",$alg);
    $alg = preg_replace("/1-4FL2'/","<305>",$alg);   $alg = preg_replace("/1-4FL'/","<306>",$alg);   $alg = preg_replace("/1-4FL2/","<307>",$alg);   $alg = preg_replace("/1-4FL/","<308>",$alg);
    $alg = preg_replace("/1-4BL2'/","<309>",$alg);   $alg = preg_replace("/1-4BL'/","<310>",$alg);   $alg = preg_replace("/1-4BL2/","<311>",$alg);   $alg = preg_replace("/1-4BL/","<312>",$alg);
    $alg = preg_replace("/1-4FR2'/","<313>",$alg);   $alg = preg_replace("/1-4FR'/","<314>",$alg);   $alg = preg_replace("/1-4FR2/","<315>",$alg);   $alg = preg_replace("/1-4FR/","<316>",$alg);
    $alg = preg_replace("/1-4DL2'/","<321>",$alg);   $alg = preg_replace("/1-4DL'/","<322>",$alg);   $alg = preg_replace("/1-4DL2/","<323>",$alg);   $alg = preg_replace("/1-4DL/","<324>",$alg);
    $alg = preg_replace("/1-4DR2'/","<329>",$alg);   $alg = preg_replace("/1-4DR'/","<330>",$alg);   $alg = preg_replace("/1-4DR2/","<331>",$alg);   $alg = preg_replace("/1-4DR/","<332>",$alg);
    
    $alg = preg_replace("/1-4R2'/", "<317>",$alg);   $alg = preg_replace("/1-4R'/", "<318>",$alg);   $alg = preg_replace("/1-4R2/", "<319>",$alg);   $alg = preg_replace("/1-4R/", "<320>",$alg);
    $alg = preg_replace("/1-4L2'/", "<325>",$alg);   $alg = preg_replace("/1-4L'/", "<326>",$alg);   $alg = preg_replace("/1-4L2/", "<327>",$alg);   $alg = preg_replace("/1-4L/", "<328>",$alg);
    $alg = preg_replace("/1-4F2'/", "<333>",$alg);   $alg = preg_replace("/1-4F'/", "<334>",$alg);   $alg = preg_replace("/1-4F2/", "<335>",$alg);   $alg = preg_replace("/1-4F/", "<336>",$alg);
    $alg = preg_replace("/1-4B2'/", "<337>",$alg);   $alg = preg_replace("/1-4B'/", "<338>",$alg);   $alg = preg_replace("/1-4B2/", "<339>",$alg);   $alg = preg_replace("/1-4B/", "<340>",$alg);
    $alg = preg_replace("/1-4U2'/", "<341>",$alg);   $alg = preg_replace("/1-4U'/", "<342>",$alg);   $alg = preg_replace("/1-4U2/", "<343>",$alg);   $alg = preg_replace("/1-4U/", "<344>",$alg);
    $alg = preg_replace("/1-4D2'/", "<345>",$alg);   $alg = preg_replace("/1-4D'/", "<346>",$alg);   $alg = preg_replace("/1-4D2/", "<347>",$alg);   $alg = preg_replace("/1-4D/", "<348>",$alg);
    
    
    //<s> /* T3 */
    $alg = preg_replace("/1-3BR2'/","<349>",$alg);   $alg = preg_replace("/1-3BR'/","<350>",$alg);   $alg = preg_replace("/1-3BR2/","<351>",$alg);   $alg = preg_replace("/1-3BR/","<352>",$alg);
    $alg = preg_replace("/1-3FL2'/","<353>",$alg);   $alg = preg_replace("/1-3FL'/","<354>",$alg);   $alg = preg_replace("/1-3FL2/","<355>",$alg);   $alg = preg_replace("/1-3FL/","<356>",$alg);
    $alg = preg_replace("/1-3BL2'/","<357>",$alg);   $alg = preg_replace("/1-3BL'/","<358>",$alg);   $alg = preg_replace("/1-3BL2/","<359>",$alg);   $alg = preg_replace("/1-3BL/","<360>",$alg);
    $alg = preg_replace("/1-3FR2'/","<361>",$alg);   $alg = preg_replace("/1-3FR'/","<362>",$alg);   $alg = preg_replace("/1-3FR2/","<363>",$alg);   $alg = preg_replace("/1-3FR/","<364>",$alg);
    $alg = preg_replace("/1-3DL2'/","<369>",$alg);   $alg = preg_replace("/1-3DL'/","<370>",$alg);   $alg = preg_replace("/1-3DL2/","<371>",$alg);   $alg = preg_replace("/1-3DL/","<372>",$alg);
    $alg = preg_replace("/1-3DR2'/","<377>",$alg);   $alg = preg_replace("/1-3DR'/","<378>",$alg);   $alg = preg_replace("/1-3DR2/","<379>",$alg);   $alg = preg_replace("/1-3DR/","<380>",$alg);
    
    $alg = preg_replace("/1-3R2'/","<365>", $alg);   $alg = preg_replace("/1-3R'/","<366>", $alg);   $alg = preg_replace("/1-3R2/", "<367>",$alg);   $alg = preg_replace("/1-3R/", "<368>",$alg);
    $alg = preg_replace("/1-3L2'/","<373>", $alg);   $alg = preg_replace("/1-3L'/","<374>", $alg);   $alg = preg_replace("/1-3L2/", "<375>",$alg);   $alg = preg_replace("/1-3L/", "<376>",$alg);
    $alg = preg_replace("/1-3F2'/","<381>", $alg);   $alg = preg_replace("/1-3F'/","<382>", $alg);   $alg = preg_replace("/1-3F2/", "<383>",$alg);   $alg = preg_replace("/1-3F/", "<384>",$alg);
    $alg = preg_replace("/1-3B2'/","<385>", $alg);   $alg = preg_replace("/1-3B'/","<386>", $alg);   $alg = preg_replace("/1-3B2/", "<387>",$alg);   $alg = preg_replace("/1-3B/", "<388>",$alg);
    $alg = preg_replace("/1-3U2'/","<389>", $alg);   $alg = preg_replace("/1-3U'/","<390>", $alg);   $alg = preg_replace("/1-3U2/", "<391>",$alg);   $alg = preg_replace("/1-3U/", "<392>",$alg);
    $alg = preg_replace("/1-3D2'/","<393>", $alg);   $alg = preg_replace("/1-3D'/","<394>", $alg);   $alg = preg_replace("/1-3D2/", "<395>",$alg);   $alg = preg_replace("/1-3D/", "<396>",$alg);
    
    
    //<s> /* T */
    $alg = preg_replace("/1-2BR2'/", "<397>",$alg);   $alg = preg_replace("/1-2BR'/", "<398>",$alg);   $alg = preg_replace("/1-2BR2/", "<399>",$alg);   $alg = preg_replace("/1-2BR/","<3100>",$alg);
    $alg = preg_replace("/1-2FL2'/","<3101>",$alg);   $alg = preg_replace("/1-2FL'/","<3102>",$alg);   $alg = preg_replace("/1-2FL2/","<3103>",$alg);   $alg = preg_replace("/1-2FL/","<3104>",$alg);
    $alg = preg_replace("/1-2BL2'/","<3105>",$alg);   $alg = preg_replace("/1-2BL'/","<3106>",$alg);   $alg = preg_replace("/1-2BL2/","<3107>",$alg);   $alg = preg_replace("/1-2BL/","<3108>",$alg);
    $alg = preg_replace("/1-2FR2'/","<3109>",$alg);   $alg = preg_replace("/1-2FR'/","<3110>",$alg);   $alg = preg_replace("/1-2FR2/","<3111>",$alg);   $alg = preg_replace("/1-2FR/","<3112>",$alg);
    $alg = preg_replace("/1-2DL2'/","<3117>",$alg);   $alg = preg_replace("/1-2DL'/","<3118>",$alg);   $alg = preg_replace("/1-2DL2/","<3119>",$alg);   $alg = preg_replace("/1-2DL/","<3120>",$alg);
    $alg = preg_replace("/1-2DR2'/","<3125>",$alg);   $alg = preg_replace("/1-2DR'/","<3126>",$alg);   $alg = preg_replace("/1-2DR2/","<3127>",$alg);   $alg = preg_replace("/1-2DR/","<3128>",$alg);
    
    $alg = preg_replace("/1-2R2'/","<3113>", $alg);   $alg = preg_replace("/1-2R'/","<3114>", $alg);   $alg = preg_replace("/1-2R2/", "<3115>",$alg);   $alg = preg_replace("/1-2R/", "<3116>",$alg);
    $alg = preg_replace("/1-2L2'/","<3121>", $alg);   $alg = preg_replace("/1-2L'/","<3122>", $alg);   $alg = preg_replace("/1-2L2/", "<3123>",$alg);   $alg = preg_replace("/1-2L/", "<3124>",$alg);
    $alg = preg_replace("/1-2F2'/","<3129>", $alg);   $alg = preg_replace("/1-2F'/","<3130>", $alg);   $alg = preg_replace("/1-2F2/", "<3131>",$alg);   $alg = preg_replace("/1-2F/", "<3132>",$alg);
    $alg = preg_replace("/1-2B2'/","<3133>", $alg);   $alg = preg_replace("/1-2B'/","<3134>", $alg);   $alg = preg_replace("/1-2B2/", "<3135>",$alg);   $alg = preg_replace("/1-2B/", "<3136>",$alg);
    $alg = preg_replace("/1-2U2'/","<3137>", $alg);   $alg = preg_replace("/1-2U'/","<3138>", $alg);   $alg = preg_replace("/1-2U2/", "<3139>",$alg);   $alg = preg_replace("/1-2U/", "<3140>",$alg);
    $alg = preg_replace("/1-2D2'/","<3141>", $alg);   $alg = preg_replace("/1-2D'/","<3142>", $alg);   $alg = preg_replace("/1-2D2/", "<3143>",$alg);   $alg = preg_replace("/1-2D/", "<3144>",$alg);
    
    /* --- 5xD: TWIZZLE -> CODE: [2] Slice twists --- */
    if ($optSSE == true) {
      //<s> /* S2 = S3-3 */
      $alg = preg_replace("/3FL2' BRv2'/","<201>",$alg);   $alg = preg_replace("/3FL' BRv'/","<202>",$alg);   $alg = preg_replace("/3FL2 BRv2/","<203>",$alg);   $alg = preg_replace("/3FL BRv/","<204>",$alg);
      $alg = preg_replace("/3BR2' FLv2'/","<203>",$alg);   $alg = preg_replace("/3BR' FLv'/","<204>",$alg);   $alg = preg_replace("/3BR2 FLv2/","<201>",$alg);   $alg = preg_replace("/3BR FLv/","<202>",$alg);
      $alg = preg_replace("/3FR2' BLv2'/","<205>",$alg);   $alg = preg_replace("/3FR' BLv'/","<206>",$alg);   $alg = preg_replace("/3FR2 BLv2/","<207>",$alg);   $alg = preg_replace("/3FR BLv/","<208>",$alg);
      $alg = preg_replace("/3BL2' FRv2'/","<207>",$alg);   $alg = preg_replace("/3BL' FRv'/","<208>",$alg);   $alg = preg_replace("/3BL2 FRv2/","<205>",$alg);   $alg = preg_replace("/3BL FRv/","<206>",$alg);
      $alg = preg_replace("/3R2' DLv2'/", "<211>",$alg);   $alg = preg_replace("/3R' DLv'/", "<212>",$alg);   $alg = preg_replace("/3R2 DLv2/", "<209>",$alg);   $alg = preg_replace("/3R DLv/", "<210>",$alg);
      $alg = preg_replace("/3L2' DRv2'/", "<215>",$alg);   $alg = preg_replace("/3L' DRv'/", "<216>",$alg);   $alg = preg_replace("/3L2 DRv2/", "<213>",$alg);   $alg = preg_replace("/3L DRv/", "<214>",$alg);
      
      $alg = preg_replace("/3DL2' Rv2'/", "<209>",$alg);   $alg = preg_replace("/3DL' Rv'/", "<210>",$alg);   $alg = preg_replace("/3DL2 Rv2/", "<211>",$alg);   $alg = preg_replace("/3DL Rv/", "<212>",$alg);
      $alg = preg_replace("/3DR2' Lv2'/", "<213>",$alg);   $alg = preg_replace("/3DR' Lv'/", "<214>",$alg);   $alg = preg_replace("/3DR2 Lv2/", "<215>",$alg);   $alg = preg_replace("/3DR Lv/", "<216>",$alg);
      $alg = preg_replace("/3B2' Fv2'/",  "<217>",$alg);   $alg = preg_replace("/3B' Fv'/",  "<218>",$alg);   $alg = preg_replace("/3B2 Fv2/",  "<219>",$alg);   $alg = preg_replace("/3B Fv/",  "<220>",$alg);
      $alg = preg_replace("/3F2' Bv2'/",  "<219>",$alg);   $alg = preg_replace("/3F' Bv'/",  "<220>",$alg);   $alg = preg_replace("/3F2 Bv2/",  "<217>",$alg);   $alg = preg_replace("/3F Bv/",  "<218>",$alg);
      $alg = preg_replace("/3D2' Uv2'/",  "<221>",$alg);   $alg = preg_replace("/3D' Uv'/",  "<222>",$alg);   $alg = preg_replace("/3D2 Uv2/",  "<223>",$alg);   $alg = preg_replace("/3D Uv/",  "<224>",$alg);
      $alg = preg_replace("/3U2' Dv2'/",  "<223>",$alg);   $alg = preg_replace("/3U' Dv'/",  "<224>",$alg);   $alg = preg_replace("/3U2 Dv2/",  "<221>",$alg);   $alg = preg_replace("/3U Dv/",  "<222>",$alg);
      
      
      $alg = preg_replace("/3BR2 BRv2'/","<201>",$alg);   $alg = preg_replace("/3BR BRv'/","<202>",$alg);   $alg = preg_replace("/3BR2' BRv2/","<203>",$alg);   $alg = preg_replace("/3BR' BRv/","<204>",$alg);
      $alg = preg_replace("/3FL2 FLv2'/","<203>",$alg);   $alg = preg_replace("/3FL FLv'/","<204>",$alg);   $alg = preg_replace("/3FL2' FLv2/","<201>",$alg);   $alg = preg_replace("/3FL' FLv/","<202>",$alg);
      $alg = preg_replace("/3BL2 BLv2'/","<205>",$alg);   $alg = preg_replace("/3BL BLv'/","<206>",$alg);   $alg = preg_replace("/3BL2' BLv2/","<207>",$alg);   $alg = preg_replace("/3BL' BLv/","<208>",$alg);
      $alg = preg_replace("/3FR2 FRv2'/","<207>",$alg);   $alg = preg_replace("/3FR FRv'/","<208>",$alg);   $alg = preg_replace("/3FR2' FRv2/","<205>",$alg);   $alg = preg_replace("/3FR' FRv/","<206>",$alg);
      $alg = preg_replace("/3DL2 DLv2'/","<211>",$alg);   $alg = preg_replace("/3DL DLv'/","<212>",$alg);   $alg = preg_replace("/3DL2' DLv2/","<209>",$alg);   $alg = preg_replace("/3DL' DLv/","<210>",$alg);
      $alg = preg_replace("/3DR2 DRv2'/","<215>",$alg);   $alg = preg_replace("/3DR DRv'/","<216>",$alg);   $alg = preg_replace("/3DR2' DRv2/","<213>",$alg);   $alg = preg_replace("/3DR' DRv/","<214>",$alg);
      
      $alg = preg_replace("/3R2 Rv2'/",  "<209>",$alg);   $alg = preg_replace("/3R Rv'/",  "<210>",$alg);   $alg = preg_replace("/3R2' Rv2/",  "<211>",$alg);   $alg = preg_replace("/3R' Rv/",  "<212>",$alg);
      $alg = preg_replace("/3L2 Lv2'/",  "<213>",$alg);   $alg = preg_replace("/3L Lv'/",  "<214>",$alg);   $alg = preg_replace("/3L2' Lv2/",  "<215>",$alg);   $alg = preg_replace("/3L' Lv/",  "<216>",$alg);
      $alg = preg_replace("/3F2 Fv2'/",  "<217>",$alg);   $alg = preg_replace("/3F Fv'/",  "<218>",$alg);   $alg = preg_replace("/3F2' Fv2/",  "<219>",$alg);   $alg = preg_replace("/3F' Fv/",  "<220>",$alg);
      $alg = preg_replace("/3B2 Bv2'/",  "<219>",$alg);   $alg = preg_replace("/3B Bv'/",  "<220>",$alg);   $alg = preg_replace("/3B2' Bv2/",  "<217>",$alg);   $alg = preg_replace("/3B' Bv/",  "<218>",$alg);
      $alg = preg_replace("/3U2 Uv2'/",  "<221>",$alg);   $alg = preg_replace("/3U Uv'/",  "<222>",$alg);   $alg = preg_replace("/3U2' Uv2/",  "<223>",$alg);   $alg = preg_replace("/3U' Uv/",  "<224>",$alg);
      $alg = preg_replace("/3D2 Dv2'/",  "<223>",$alg);   $alg = preg_replace("/3D Dv'/",  "<224>",$alg);   $alg = preg_replace("/3D2' Dv2/",  "<221>",$alg);   $alg = preg_replace("/3D' Dv/",  "<222>",$alg);
      
      
      //<s> /* S = S2-4 */
      $alg = preg_replace("/2-4FL2' BRv2'/","<225>",$alg);   $alg = preg_replace("/2-4FL' BRv'/","<226>",$alg);   $alg = preg_replace("/2-4FL2 BRv2/","<227>",$alg);   $alg = preg_replace("/2-4FL BRv/","<228>",$alg);
      $alg = preg_replace("/2-4BR2' FLv2'/","<227>",$alg);   $alg = preg_replace("/2-4BR' FLv'/","<228>",$alg);   $alg = preg_replace("/2-4BR2 FLv2/","<225>",$alg);   $alg = preg_replace("/2-4BR FLv/","<226>",$alg);
      $alg = preg_replace("/2-4FR2' BLv2'/","<229>",$alg);   $alg = preg_replace("/2-4FR' BLv'/","<230>",$alg);   $alg = preg_replace("/2-4FR2 BLv2/","<231>",$alg);   $alg = preg_replace("/2-4FR BLv/","<232>",$alg);
      $alg = preg_replace("/2-4BL2' FRv2'/","<231>",$alg);   $alg = preg_replace("/2-4BL' FRv'/","<232>",$alg);   $alg = preg_replace("/2-4BL2 FRv2/","<229>",$alg);   $alg = preg_replace("/2-4BL FRv/","<230>",$alg);
      $alg = preg_replace("/2-4R2' DLv2'/", "<235>",$alg);   $alg = preg_replace("/2-4R' DLv'/", "<236>",$alg);   $alg = preg_replace("/2-4R2 DLv2/", "<233>",$alg);   $alg = preg_replace("/2-4R DLv/", "<234>",$alg);
      $alg = preg_replace("/2-4L2' DRv2'/", "<239>",$alg);   $alg = preg_replace("/2-4L' DRv'/", "<240>",$alg);   $alg = preg_replace("/2-4L2 DRv2/", "<237>",$alg);   $alg = preg_replace("/2-4L DRv/", "<238>",$alg);
      
      $alg = preg_replace("/2-4DL2' Rv2'/", "<233>",$alg);   $alg = preg_replace("/2-4DL' Rv'/", "<234>",$alg);   $alg = preg_replace("/2-4DL2 Rv2/", "<235>",$alg);   $alg = preg_replace("/2-4DL Rv/", "<236>",$alg);
      $alg = preg_replace("/2-4DR2' Lv2'/", "<237>",$alg);   $alg = preg_replace("/2-4DR' Lv'/", "<238>",$alg);   $alg = preg_replace("/2-4DR2 Lv2/", "<239>",$alg);   $alg = preg_replace("/2-4DR Lv/", "<240>",$alg);
      $alg = preg_replace("/2-4B2' Fv2'/",  "<241>",$alg);   $alg = preg_replace("/2-4B' Fv'/",  "<242>",$alg);   $alg = preg_replace("/2-4B2 Fv2/",  "<243>",$alg);   $alg = preg_replace("/2-4B Fv/",  "<244>",$alg);
      $alg = preg_replace("/2-4F2' Bv2'/",  "<243>",$alg);   $alg = preg_replace("/2-4F' Bv'/",  "<244>",$alg);   $alg = preg_replace("/2-4F2 Bv2/",  "<241>",$alg);   $alg = preg_replace("/2-4F Bv/",  "<242>",$alg);
      $alg = preg_replace("/2-4D2' Uv2'/",  "<245>",$alg);   $alg = preg_replace("/2-4D' Uv'/",  "<246>",$alg);   $alg = preg_replace("/2-4D2 Uv2/",  "<247>",$alg);   $alg = preg_replace("/2-4D Uv/",  "<248>",$alg);
      $alg = preg_replace("/2-4U2' Dv2'/",  "<247>",$alg);   $alg = preg_replace("/2-4U' Dv'/",  "<248>",$alg);   $alg = preg_replace("/2-4U2 Dv2/",  "<245>",$alg);   $alg = preg_replace("/2-4U Dv/",  "<246>",$alg);
      
      
      $alg = preg_replace("/2-4BR2 BRv2'/","<225>",$alg);   $alg = preg_replace("/2-4BR BRv'/","<226>",$alg);   $alg = preg_replace("/2-4BR2' BRv2/","<227>",$alg);   $alg = preg_replace("/2-4BR' BRv/","<228>",$alg);
      $alg = preg_replace("/2-4FL2 FLv2'/","<227>",$alg);   $alg = preg_replace("/2-4FL FLv'/","<228>",$alg);   $alg = preg_replace("/2-4FL2' FLv2/","<225>",$alg);   $alg = preg_replace("/2-4FL' FLv/","<226>",$alg);
      $alg = preg_replace("/2-4BL2 BLv2'/","<229>",$alg);   $alg = preg_replace("/2-4BL BLv'/","<230>",$alg);   $alg = preg_replace("/2-4BL2' BLv2/","<231>",$alg);   $alg = preg_replace("/2-4BL' BLv/","<232>",$alg);
      $alg = preg_replace("/2-4FR2 FRv2'/","<231>",$alg);   $alg = preg_replace("/2-4FR FRv'/","<232>",$alg);   $alg = preg_replace("/2-4FR2' FRv2/","<229>",$alg);   $alg = preg_replace("/2-4FR' FRv/","<230>",$alg);
      $alg = preg_replace("/2-4DL2 DLv2'/","<235>",$alg);   $alg = preg_replace("/2-4DL DLv'/","<236>",$alg);   $alg = preg_replace("/2-4DL2' DLv2/","<233>",$alg);   $alg = preg_replace("/2-4DL' DLv/","<234>",$alg);
      $alg = preg_replace("/2-4DR2 DRv2'/","<239>",$alg);   $alg = preg_replace("/2-4DR DRv'/","<240>",$alg);   $alg = preg_replace("/2-4DR2' DRv2/","<237>",$alg);   $alg = preg_replace("/2-4DR' DRv/","<238>",$alg);
      
      $alg = preg_replace("/2-4R2 Rv2'/",  "<233>",$alg);   $alg = preg_replace("/2-4R Rv'/",  "<234>",$alg);   $alg = preg_replace("/2-4R2' Rv2/",  "<235>",$alg);   $alg = preg_replace("/2-4R' Rv/",  "<236>",$alg);
      $alg = preg_replace("/2-4L2 Lv2'/",  "<237>",$alg);   $alg = preg_replace("/2-4L Lv'/",  "<238>",$alg);   $alg = preg_replace("/2-4L2' Lv2/",  "<239>",$alg);   $alg = preg_replace("/2-4L' Lv/",  "<240>",$alg);
      $alg = preg_replace("/2-4F2 Fv2'/",  "<241>",$alg);   $alg = preg_replace("/2-4F Fv'/",  "<242>",$alg);   $alg = preg_replace("/2-4F2' Fv2/",  "<243>",$alg);   $alg = preg_replace("/2-4F' Fv/",  "<244>",$alg);
      $alg = preg_replace("/2-4B2 Bv2'/",  "<243>",$alg);   $alg = preg_replace("/2-4B Bv'/",  "<244>",$alg);   $alg = preg_replace("/2-4B2' Bv2/",  "<241>",$alg);   $alg = preg_replace("/2-4B' Bv/",  "<242>",$alg);
      $alg = preg_replace("/2-4U2 Uv2'/",  "<245>",$alg);   $alg = preg_replace("/2-4U Uv'/",  "<246>",$alg);   $alg = preg_replace("/2-4U2' Uv2/",  "<247>",$alg);   $alg = preg_replace("/2-4U' Uv/",  "<248>",$alg);
      $alg = preg_replace("/2-4D2 Dv2'/",  "<247>",$alg);   $alg = preg_replace("/2-4D Dv'/",  "<248>",$alg);   $alg = preg_replace("/2-4D2' Dv2/",  "<245>",$alg);   $alg = preg_replace("/2-4D' Dv/",  "<246>",$alg);
      
      /* S2-2 | S4-4 */
      
      /* S2-3 | S3-4 */
    }
    
    /* --- 5xD: OLD TWIZZLE -> CODE: [6] Wide twists --- */
    //<s> /* W */
    $alg = preg_replace("/2-4BF2'/","<619>",$alg);   $alg = preg_replace("/2-4BF'/","<620>",$alg);   $alg = preg_replace("/2-4BF2/","<617>",$alg);   $alg = preg_replace("/2-4BF/","<618>",$alg); // BF -> B.
    
    $alg = preg_replace("/2-4A2'/", "<603>",$alg);   $alg = preg_replace("/2-4A'/", "<604>",$alg);   $alg = preg_replace("/2-4A2/", "<601>",$alg);   $alg = preg_replace("/2-4A/", "<602>",$alg); // A  -> FL.
    $alg = preg_replace("/2-4C2'/", "<607>",$alg);   $alg = preg_replace("/2-4C'/", "<608>",$alg);   $alg = preg_replace("/2-4C2/", "<605>",$alg);   $alg = preg_replace("/2-4C/", "<606>",$alg); // C  -> FR.
    $alg = preg_replace("/2-4I2'/", "<611>",$alg);   $alg = preg_replace("/2-4I'/", "<612>",$alg);   $alg = preg_replace("/2-4I2/", "<609>",$alg);   $alg = preg_replace("/2-4I/", "<610>",$alg); // I  -> DL.
    $alg = preg_replace("/2-4E2'/", "<615>",$alg);   $alg = preg_replace("/2-4E'/", "<616>",$alg);   $alg = preg_replace("/2-4E2/", "<613>",$alg);   $alg = preg_replace("/2-4E/", "<614>",$alg); // E  -> DR.
    
    /* --- 5xD: TWIZZLE -> CODE: [6] Wide twists --- */
    //<s> /* W */
    $alg = preg_replace("/2-4BR2'/","<601>",$alg);   $alg = preg_replace("/2-4BR'/","<602>",$alg);   $alg = preg_replace("/2-4BR2/","<603>",$alg);   $alg = preg_replace("/2-4BR/","<604>",$alg);
    $alg = preg_replace("/2-4FL2'/","<603>",$alg);   $alg = preg_replace("/2-4FL'/","<604>",$alg);   $alg = preg_replace("/2-4FL2/","<601>",$alg);   $alg = preg_replace("/2-4FL/","<602>",$alg);
    $alg = preg_replace("/2-4BL2'/","<605>",$alg);   $alg = preg_replace("/2-4BL'/","<606>",$alg);   $alg = preg_replace("/2-4BL2/","<607>",$alg);   $alg = preg_replace("/2-4BL/","<608>",$alg);
    $alg = preg_replace("/2-4FR2'/","<607>",$alg);   $alg = preg_replace("/2-4FR'/","<608>",$alg);   $alg = preg_replace("/2-4FR2/","<605>",$alg);   $alg = preg_replace("/2-4FR/","<606>",$alg);
    $alg = preg_replace("/2-4DL2'/","<611>",$alg);   $alg = preg_replace("/2-4DL'/","<612>",$alg);   $alg = preg_replace("/2-4DL2/","<609>",$alg);   $alg = preg_replace("/2-4DL/","<610>",$alg);
    $alg = preg_replace("/2-4DR2'/","<615>",$alg);   $alg = preg_replace("/2-4DR'/","<616>",$alg);   $alg = preg_replace("/2-4DR2/","<613>",$alg);   $alg = preg_replace("/2-4DR/","<614>",$alg);
    
    $alg = preg_replace("/2-4R2'/", "<609>",$alg);   $alg = preg_replace("/2-4R'/", "<610>",$alg);   $alg = preg_replace("/2-4R2/", "<611>",$alg);   $alg = preg_replace("/2-4R/", "<612>",$alg);
    $alg = preg_replace("/2-4L2'/", "<613>",$alg);   $alg = preg_replace("/2-4L'/", "<614>",$alg);   $alg = preg_replace("/2-4L2/", "<615>",$alg);   $alg = preg_replace("/2-4L/", "<616>",$alg);
    $alg = preg_replace("/2-4F2'/", "<617>",$alg);   $alg = preg_replace("/2-4F'/", "<618>",$alg);   $alg = preg_replace("/2-4F2/", "<619>",$alg);   $alg = preg_replace("/2-4F/", "<620>",$alg);
    $alg = preg_replace("/2-4B2'/", "<619>",$alg);   $alg = preg_replace("/2-4B'/", "<620>",$alg);   $alg = preg_replace("/2-4B2/", "<617>",$alg);   $alg = preg_replace("/2-4B/", "<618>",$alg);
    $alg = preg_replace("/2-4U2'/", "<621>",$alg);   $alg = preg_replace("/2-4U'/", "<622>",$alg);   $alg = preg_replace("/2-4U2/", "<623>",$alg);   $alg = preg_replace("/2-4U/", "<624>",$alg);
    $alg = preg_replace("/2-4D2'/", "<623>",$alg);   $alg = preg_replace("/2-4D'/", "<624>",$alg);   $alg = preg_replace("/2-4D2/", "<621>",$alg);   $alg = preg_replace("/2-4D/", "<622>",$alg);
    
    /* --- 5xD: OLD TWIZZLE -> CODE: [4] Void twists --- */
    //<s> /* V */
    $alg = preg_replace("/2-3BF2'/","<437>",$alg);   $alg = preg_replace("/2-3BF'/","<438>",$alg);   $alg = preg_replace("/2-3BF2/","<439>",$alg);   $alg = preg_replace("/2-3BF/","<440>",$alg); // BF -> B.
    
    $alg = preg_replace("/2-3A2'/", "<405>",$alg);   $alg = preg_replace("/2-3A'/", "<406>",$alg);   $alg = preg_replace("/2-3A2/", "<407>",$alg);   $alg = preg_replace("/2-3A/", "<408>",$alg); // A  -> FL.
    $alg = preg_replace("/2-3C2'/", "<413>",$alg);   $alg = preg_replace("/2-3C'/", "<414>",$alg);   $alg = preg_replace("/2-3C2/", "<415>",$alg);   $alg = preg_replace("/2-3C/", "<416>",$alg); // C  -> FR.
    $alg = preg_replace("/2-3I2'/", "<421>",$alg);   $alg = preg_replace("/2-3I'/", "<422>",$alg);   $alg = preg_replace("/2-3I2/", "<423>",$alg);   $alg = preg_replace("/2-3I/", "<424>",$alg); // I  -> DL.
    $alg = preg_replace("/2-3E2'/", "<429>",$alg);   $alg = preg_replace("/2-3E'/", "<430>",$alg);   $alg = preg_replace("/2-3E2/", "<431>",$alg);   $alg = preg_replace("/2-3E/", "<432>",$alg); // E  -> DR.
    
    
    $alg = preg_replace("/3-4BF2'/","<439>",$alg);   $alg = preg_replace("/3-4BF'/","<440>",$alg);   $alg = preg_replace("/3-4BF2/","<437>",$alg);   $alg = preg_replace("/3-4BF/","<438>",$alg); // BF -> B.
    
    $alg = preg_replace("/3-4A2'/", "<403>",$alg);   $alg = preg_replace("/3-4A'/", "<404>",$alg);   $alg = preg_replace("/3-4A2/", "<401>",$alg);   $alg = preg_replace("/3-4A/", "<402>",$alg); // A  -> FL.
    $alg = preg_replace("/3-4C2'/", "<411>",$alg);   $alg = preg_replace("/3-4C'/", "<412>",$alg);   $alg = preg_replace("/3-4C2/", "<409>",$alg);   $alg = preg_replace("/3-4C/", "<410>",$alg); // C  -> FR.
    $alg = preg_replace("/3-4I2'/", "<419>",$alg);   $alg = preg_replace("/3-4I'/", "<420>",$alg);   $alg = preg_replace("/3-4I2/", "<417>",$alg);   $alg = preg_replace("/3-4I/", "<418>",$alg); // I  -> DL.
    $alg = preg_replace("/3-4E2'/", "<427>",$alg);   $alg = preg_replace("/3-4E'/", "<428>",$alg);   $alg = preg_replace("/3-4E2/", "<425>",$alg);   $alg = preg_replace("/3-4E/", "<426>",$alg); // E  -> DR.
    
    /* --- 5xD: TWIZZLE -> CODE: [4] Void twists --- */
    //<s> /* V */
    $alg = preg_replace("/2-3BR2'/","<401>",$alg);   $alg = preg_replace("/2-3BR'/","<402>",$alg);   $alg = preg_replace("/2-3BR2/","<403>",$alg);   $alg = preg_replace("/2-3BR/","<404>",$alg);
    $alg = preg_replace("/2-3FL2'/","<405>",$alg);   $alg = preg_replace("/2-3FL'/","<406>",$alg);   $alg = preg_replace("/2-3FL2/","<407>",$alg);   $alg = preg_replace("/2-3FL/","<408>",$alg);
    $alg = preg_replace("/2-3BL2'/","<409>",$alg);   $alg = preg_replace("/2-3BL'/","<410>",$alg);   $alg = preg_replace("/2-3BL2/","<411>",$alg);   $alg = preg_replace("/2-3BL/","<412>",$alg);
    $alg = preg_replace("/2-3FR2'/","<413>",$alg);   $alg = preg_replace("/2-3FR'/","<414>",$alg);   $alg = preg_replace("/2-3FR2/","<415>",$alg);   $alg = preg_replace("/2-3FR/","<416>",$alg);
    $alg = preg_replace("/2-3DL2'/","<421>",$alg);   $alg = preg_replace("/2-3DL'/","<422>",$alg);   $alg = preg_replace("/2-3DL2/","<423>",$alg);   $alg = preg_replace("/2-3DL/","<424>",$alg);
    $alg = preg_replace("/2-3DR2'/","<429>",$alg);   $alg = preg_replace("/2-3DR'/","<430>",$alg);   $alg = preg_replace("/2-3DR2/","<431>",$alg);   $alg = preg_replace("/2-3DR/","<432>",$alg);
    
    $alg = preg_replace("/2-3R2'/", "<417>",$alg);   $alg = preg_replace("/2-3R'/", "<418>",$alg);   $alg = preg_replace("/2-3R2/", "<419>",$alg);   $alg = preg_replace("/2-3R/", "<420>",$alg);
    $alg = preg_replace("/2-3L2'/", "<425>",$alg);   $alg = preg_replace("/2-3L'/", "<426>",$alg);   $alg = preg_replace("/2-3L2/", "<427>",$alg);   $alg = preg_replace("/2-3L/", "<428>",$alg);
    $alg = preg_replace("/2-3F2'/", "<433>",$alg);   $alg = preg_replace("/2-3F'/", "<434>",$alg);   $alg = preg_replace("/2-3F2/", "<435>",$alg);   $alg = preg_replace("/2-3F/", "<436>",$alg);
    $alg = preg_replace("/2-3B2'/", "<437>",$alg);   $alg = preg_replace("/2-3B'/", "<438>",$alg);   $alg = preg_replace("/2-3B2/", "<439>",$alg);   $alg = preg_replace("/2-3B/", "<440>",$alg);
    $alg = preg_replace("/2-3U2'/", "<441>",$alg);   $alg = preg_replace("/2-3U'/", "<442>",$alg);   $alg = preg_replace("/2-3U2/", "<443>",$alg);   $alg = preg_replace("/2-3U/", "<444>",$alg);
    $alg = preg_replace("/2-3D2'/", "<445>",$alg);   $alg = preg_replace("/2-3D'/", "<446>",$alg);   $alg = preg_replace("/2-3D2/", "<447>",$alg);   $alg = preg_replace("/2-3D/", "<448>",$alg);
    
    
    $alg = preg_replace("/3-4BR2'/","<407>",$alg);   $alg = preg_replace("/3-4BR'/","<408>",$alg);   $alg = preg_replace("/3-4BR2/","<405>",$alg);   $alg = preg_replace("/3-4BR/","<406>",$alg);
    $alg = preg_replace("/3-4FL2'/","<403>",$alg);   $alg = preg_replace("/3-4FL'/","<404>",$alg);   $alg = preg_replace("/3-4FL2/","<401>",$alg);   $alg = preg_replace("/3-4FL/","<402>",$alg);
    $alg = preg_replace("/3-4BL2'/","<415>",$alg);   $alg = preg_replace("/3-4BL'/","<416>",$alg);   $alg = preg_replace("/3-4BL2/","<413>",$alg);   $alg = preg_replace("/3-4BL/","<414>",$alg);
    $alg = preg_replace("/3-4FR2'/","<411>",$alg);   $alg = preg_replace("/3-4FR'/","<412>",$alg);   $alg = preg_replace("/3-4FR2/","<409>",$alg);   $alg = preg_replace("/3-4FR/","<410>",$alg);
    $alg = preg_replace("/3-4DL2'/","<419>",$alg);   $alg = preg_replace("/3-4DL'/","<420>",$alg);   $alg = preg_replace("/3-4DL2/","<417>",$alg);   $alg = preg_replace("/3-4DL/","<418>",$alg);
    $alg = preg_replace("/3-4DR2'/","<427>",$alg);   $alg = preg_replace("/3-4DR'/","<428>",$alg);   $alg = preg_replace("/3-4DR2/","<425>",$alg);   $alg = preg_replace("/3-4DR/","<426>",$alg);
    
    $alg = preg_replace("/3-4R2'/", "<423>",$alg);   $alg = preg_replace("/3-4R'/", "<424>",$alg);   $alg = preg_replace("/3-4R2/", "<421>",$alg);   $alg = preg_replace("/3-4R/", "<422>",$alg);
    $alg = preg_replace("/3-4L2'/", "<431>",$alg);   $alg = preg_replace("/3-4L'/", "<432>",$alg);   $alg = preg_replace("/3-4L2/", "<429>",$alg);   $alg = preg_replace("/3-4L/", "<430>",$alg);
    $alg = preg_replace("/3-4F2'/", "<439>",$alg);   $alg = preg_replace("/3-4F'/", "<440>",$alg);   $alg = preg_replace("/3-4F2/", "<437>",$alg);   $alg = preg_replace("/3-4F/", "<438>",$alg);
    $alg = preg_replace("/3-4B2'/", "<435>",$alg);   $alg = preg_replace("/3-4B'/", "<436>",$alg);   $alg = preg_replace("/3-4B2/", "<433>",$alg);   $alg = preg_replace("/3-4B/", "<434>",$alg);
    $alg = preg_replace("/3-4U2'/", "<447>",$alg);   $alg = preg_replace("/3-4U'/", "<448>",$alg);   $alg = preg_replace("/3-4U2/", "<445>",$alg);   $alg = preg_replace("/3-4U/", "<446>",$alg);
    $alg = preg_replace("/3-4D2'/", "<443>",$alg);   $alg = preg_replace("/3-4D'/", "<444>",$alg);   $alg = preg_replace("/3-4D2/", "<441>",$alg);   $alg = preg_replace("/3-4D/", "<442>",$alg);
    
    /* --- 5xD: OLD TWIZZLE -> CODE: [1] Numbered layer [5] (Mid-layer) twists --- */
    //<s> /* N | N4 */
    $alg = preg_replace("/2BF2'/","<137>",$alg);   $alg = preg_replace("/2BF'/","<138>",$alg);   $alg = preg_replace("/2BF2/","<139>",$alg);   $alg = preg_replace("/2BF/","<140>",$alg); // BF -> B.
    
    $alg = preg_replace("/2A2'/", "<105>",$alg);   $alg = preg_replace("/2A'/", "<106>",$alg);   $alg = preg_replace("/2A2/", "<107>",$alg);   $alg = preg_replace("/2A/", "<108>",$alg); // A  -> FL.
    $alg = preg_replace("/2C2'/", "<113>",$alg);   $alg = preg_replace("/2C'/", "<114>",$alg);   $alg = preg_replace("/2C2/", "<115>",$alg);   $alg = preg_replace("/2C/", "<116>",$alg); // C  -> FR.
    $alg = preg_replace("/2I2'/", "<121>",$alg);   $alg = preg_replace("/2I'/", "<122>",$alg);   $alg = preg_replace("/2I2/", "<123>",$alg);   $alg = preg_replace("/2I/", "<124>",$alg); // I  -> DL.
    $alg = preg_replace("/2E2'/", "<129>",$alg);   $alg = preg_replace("/2E'/", "<130>",$alg);   $alg = preg_replace("/2E2/", "<131>",$alg);   $alg = preg_replace("/2E/", "<132>",$alg); // E  -> DR.
    
    
    $alg = preg_replace("/4BF2'/","<135>",$alg);   $alg = preg_replace("/4BF'/","<136>",$alg);   $alg = preg_replace("/4BF2/","<133>",$alg);   $alg = preg_replace("/4BF/","<134>",$alg); // BF -> B.
    
    $alg = preg_replace("/4A2'/", "<103>",$alg);   $alg = preg_replace("/4A'/", "<104>",$alg);   $alg = preg_replace("/4A2/", "<101>",$alg);   $alg = preg_replace("/4A/", "<102>",$alg); // A  -> FL.
    $alg = preg_replace("/4C2'/", "<111>",$alg);   $alg = preg_replace("/4C'/", "<112>",$alg);   $alg = preg_replace("/4C2/", "<109>",$alg);   $alg = preg_replace("/4C/", "<110>",$alg); // C  -> FR.
    $alg = preg_replace("/4I2'/", "<119>",$alg);   $alg = preg_replace("/4I'/", "<120>",$alg);   $alg = preg_replace("/4I2/", "<117>",$alg);   $alg = preg_replace("/4I/", "<118>",$alg); // I  -> DL.
    $alg = preg_replace("/4E2'/", "<127>",$alg);   $alg = preg_replace("/4E'/", "<128>",$alg);   $alg = preg_replace("/4E2/", "<125>",$alg);   $alg = preg_replace("/4E/", "<126>",$alg); // E  -> DR.
    
    
    //<s> /* N3 = M */
    $alg = preg_replace("/3BF2'/","<167>",$alg);   $alg = preg_replace("/3BF'/","<168>",$alg);   $alg = preg_replace("/3BF2/","<165>",$alg);   $alg = preg_replace("/3BF/","<166>",$alg); // BF -> B.
    
    $alg = preg_replace("/3A2'/", "<151>",$alg);   $alg = preg_replace("/3A'/", "<152>",$alg);   $alg = preg_replace("/3A2/", "<149>",$alg);   $alg = preg_replace("/3A/", "<150>",$alg); // A  -> FL.
    $alg = preg_replace("/3C2'/", "<155>",$alg);   $alg = preg_replace("/3C'/", "<156>",$alg);   $alg = preg_replace("/3C2/", "<153>",$alg);   $alg = preg_replace("/3C/", "<154>",$alg); // C  -> FR.
    $alg = preg_replace("/3I2'/", "<159>",$alg);   $alg = preg_replace("/3I'/", "<160>",$alg);   $alg = preg_replace("/3I2/", "<157>",$alg);   $alg = preg_replace("/3I/", "<158>",$alg); // I  -> DL.
    $alg = preg_replace("/3E2'/", "<163>",$alg);   $alg = preg_replace("/3E'/", "<164>",$alg);   $alg = preg_replace("/3E2/", "<161>",$alg);   $alg = preg_replace("/3E/", "<162>",$alg); // E  -> DR.
    
    /* --- 5xD: TWIZZLE -> CODE: [1] Numbered layer [5] (Mid-layer) twists --- */
    // <s> /* N | N4 */
    $alg = preg_replace("/2BR2'/","<101>",$alg);   $alg = preg_replace("/2BR'/","<102>",$alg);   $alg = preg_replace("/2BR2/","<103>",$alg);   $alg = preg_replace("/2BR/","<104>",$alg);
    $alg = preg_replace("/2FL2'/","<105>",$alg);   $alg = preg_replace("/2FL'/","<106>",$alg);   $alg = preg_replace("/2FL2/","<107>",$alg);   $alg = preg_replace("/2FL/","<108>",$alg);
    $alg = preg_replace("/2BL2'/","<109>",$alg);   $alg = preg_replace("/2BL'/","<110>",$alg);   $alg = preg_replace("/2BL2/","<111>",$alg);   $alg = preg_replace("/2BL/","<112>",$alg);
    $alg = preg_replace("/2FR2'/","<113>",$alg);   $alg = preg_replace("/2FR'/","<114>",$alg);   $alg = preg_replace("/2FR2/","<115>",$alg);   $alg = preg_replace("/2FR/","<116>",$alg);
    $alg = preg_replace("/2DL2'/","<121>",$alg);   $alg = preg_replace("/2DL'/","<122>",$alg);   $alg = preg_replace("/2DL2/","<123>",$alg);   $alg = preg_replace("/2DL/","<124>",$alg);
    $alg = preg_replace("/2DR2'/","<129>",$alg);   $alg = preg_replace("/2DR'/","<130>",$alg);   $alg = preg_replace("/2DR2/","<131>",$alg);   $alg = preg_replace("/2DR/","<132>",$alg);
    
    $alg = preg_replace("/2R2'/", "<117>",$alg);   $alg = preg_replace("/2R'/", "<118>",$alg);   $alg = preg_replace("/2R2/", "<119>",$alg);   $alg = preg_replace("/2R/", "<120>",$alg);
    $alg = preg_replace("/2L2'/", "<125>",$alg);   $alg = preg_replace("/2L'/", "<126>",$alg);   $alg = preg_replace("/2L2/", "<127>",$alg);   $alg = preg_replace("/2L/", "<128>",$alg);
    $alg = preg_replace("/2F2'/", "<133>",$alg);   $alg = preg_replace("/2F'/", "<134>",$alg);   $alg = preg_replace("/2F2/", "<135>",$alg);   $alg = preg_replace("/2F/", "<136>",$alg);
    $alg = preg_replace("/2B2'/", "<137>",$alg);   $alg = preg_replace("/2B'/", "<138>",$alg);   $alg = preg_replace("/2B2/", "<139>",$alg);   $alg = preg_replace("/2B/", "<140>",$alg);
    $alg = preg_replace("/2U2'/", "<141>",$alg);   $alg = preg_replace("/2U'/", "<142>",$alg);   $alg = preg_replace("/2U2/", "<143>",$alg);   $alg = preg_replace("/2U/", "<144>",$alg);
    $alg = preg_replace("/2D2'/", "<145>",$alg);   $alg = preg_replace("/2D'/", "<146>",$alg);   $alg = preg_replace("/2D2/", "<147>",$alg);   $alg = preg_replace("/2D/", "<148>",$alg);
    
    
    $alg = preg_replace("/4BR2'/","<107>",$alg);   $alg = preg_replace("/4BR'/","<108>",$alg);   $alg = preg_replace("/4BR2/","<105>",$alg);   $alg = preg_replace("/4BR/","<106>",$alg);
    $alg = preg_replace("/4FL2'/","<103>",$alg);   $alg = preg_replace("/4FL'/","<104>",$alg);   $alg = preg_replace("/4FL2/","<101>",$alg);   $alg = preg_replace("/4FL/","<102>",$alg);
    $alg = preg_replace("/4BL2'/","<115>",$alg);   $alg = preg_replace("/4BL'/","<116>",$alg);   $alg = preg_replace("/4BL2/","<113>",$alg);   $alg = preg_replace("/4BL/","<114>",$alg);
    $alg = preg_replace("/4FR2'/","<111>",$alg);   $alg = preg_replace("/4FR'/","<112>",$alg);   $alg = preg_replace("/4FR2/","<109>",$alg);   $alg = preg_replace("/4FR/","<110>",$alg);
    $alg = preg_replace("/4DL2'/","<119>",$alg);   $alg = preg_replace("/4DL'/","<120>",$alg);   $alg = preg_replace("/4DL2/","<117>",$alg);   $alg = preg_replace("/4DL/","<118>",$alg);
    $alg = preg_replace("/4DR2'/","<127>",$alg);   $alg = preg_replace("/4DR'/","<128>",$alg);   $alg = preg_replace("/4DR2/","<125>",$alg);   $alg = preg_replace("/4DR/","<126>",$alg);
    
    $alg = preg_replace("/4R2'/", "<123>",$alg);   $alg = preg_replace("/4R'/", "<124>",$alg);   $alg = preg_replace("/4R2/", "<121>",$alg);   $alg = preg_replace("/4R/", "<122>",$alg);
    $alg = preg_replace("/4L2'/", "<131>",$alg);   $alg = preg_replace("/4L'/", "<132>",$alg);   $alg = preg_replace("/4L2/", "<129>",$alg);   $alg = preg_replace("/4L/", "<130>",$alg);
    $alg = preg_replace("/4F2'/", "<139>",$alg);   $alg = preg_replace("/4F'/", "<140>",$alg);   $alg = preg_replace("/4F2/", "<137>",$alg);   $alg = preg_replace("/4F/", "<138>",$alg);
    $alg = preg_replace("/4B2'/", "<135>",$alg);   $alg = preg_replace("/4B'/", "<136>",$alg);   $alg = preg_replace("/4B2/", "<133>",$alg);   $alg = preg_replace("/4B/", "<134>",$alg);
    $alg = preg_replace("/4U2'/", "<147>",$alg);   $alg = preg_replace("/4U'/", "<148>",$alg);   $alg = preg_replace("/4U2/", "<145>",$alg);   $alg = preg_replace("/4U/", "<146>",$alg);
    $alg = preg_replace("/4D2'/", "<143>",$alg);   $alg = preg_replace("/4D'/", "<144>",$alg);   $alg = preg_replace("/4D2/", "<141>",$alg);   $alg = preg_replace("/4D/", "<142>",$alg);
    
    //<s> /* N3 = M */
    $alg = preg_replace("/3BR2'/","<149>",$alg);   $alg = preg_replace("/3BR'/","<150>",$alg);   $alg = preg_replace("/3BR2/","<151>",$alg);   $alg = preg_replace("/3BR/","<152>",$alg);
    $alg = preg_replace("/3FL2'/","<151>",$alg);   $alg = preg_replace("/3FL'/","<152>",$alg);   $alg = preg_replace("/3FL2/","<149>",$alg);   $alg = preg_replace("/3FL/","<150>",$alg);
    $alg = preg_replace("/3BL2'/","<153>",$alg);   $alg = preg_replace("/3BL'/","<154>",$alg);   $alg = preg_replace("/3BL2/","<155>",$alg);   $alg = preg_replace("/3BL/","<156>",$alg);
    $alg = preg_replace("/3FR2'/","<155>",$alg);   $alg = preg_replace("/3FR'/","<156>",$alg);   $alg = preg_replace("/3FR2/","<153>",$alg);   $alg = preg_replace("/3FR/","<154>",$alg);
    $alg = preg_replace("/3DL2'/","<159>",$alg);   $alg = preg_replace("/3DL'/","<160>",$alg);   $alg = preg_replace("/3DL2/","<157>",$alg);   $alg = preg_replace("/3DL/","<158>",$alg);
    $alg = preg_replace("/3DR2'/","<163>",$alg);   $alg = preg_replace("/3DR'/","<164>",$alg);   $alg = preg_replace("/3DR2/","<161>",$alg);   $alg = preg_replace("/3DR/","<162>",$alg);
    
    $alg = preg_replace("/3R2'/", "<157>",$alg);   $alg = preg_replace("/3R'/", "<158>",$alg);   $alg = preg_replace("/3R2/", "<159>",$alg);   $alg = preg_replace("/3R/", "<160>",$alg);
    $alg = preg_replace("/3L2'/", "<161>",$alg);   $alg = preg_replace("/3L'/", "<162>",$alg);   $alg = preg_replace("/3L2/", "<163>",$alg);   $alg = preg_replace("/3L/", "<164>",$alg);
    $alg = preg_replace("/3F2'/", "<165>",$alg);   $alg = preg_replace("/3F'/", "<166>",$alg);   $alg = preg_replace("/3F2/", "<167>",$alg);   $alg = preg_replace("/3F/", "<168>",$alg);
    $alg = preg_replace("/3B2'/", "<167>",$alg);   $alg = preg_replace("/3B'/", "<168>",$alg);   $alg = preg_replace("/3B2/", "<165>",$alg);   $alg = preg_replace("/3B/", "<166>",$alg);
    $alg = preg_replace("/3U2'/", "<169>",$alg);   $alg = preg_replace("/3U'/", "<170>",$alg);   $alg = preg_replace("/3U2/", "<171>",$alg);   $alg = preg_replace("/3U/", "<172>",$alg);
    $alg = preg_replace("/3D2'/", "<171>",$alg);   $alg = preg_replace("/3D'/", "<172>",$alg);   $alg = preg_replace("/3D2/", "<169>",$alg);   $alg = preg_replace("/3D/", "<170>",$alg);
    
    /* --- 5xD: TWIZZLE -> CODE: [9] Face twists --- */
    //<s> /*   */
    $alg = preg_replace("/1BR2'/","<901>",$alg);   $alg = preg_replace("/1BR'/","<902>",$alg);   $alg = preg_replace("/1BR2/","<903>",$alg);   $alg = preg_replace("/1BR/","<904>",$alg);
    $alg = preg_replace("/1FL2'/","<905>",$alg);   $alg = preg_replace("/1FL'/","<906>",$alg);   $alg = preg_replace("/1FL2/","<907>",$alg);   $alg = preg_replace("/1FL/","<908>",$alg);
    $alg = preg_replace("/1BL2'/","<909>",$alg);   $alg = preg_replace("/1BL'/","<910>",$alg);   $alg = preg_replace("/1BL2/","<911>",$alg);   $alg = preg_replace("/1BL/","<912>",$alg);
    $alg = preg_replace("/1FR2'/","<913>",$alg);   $alg = preg_replace("/1FR'/","<914>",$alg);   $alg = preg_replace("/1FR2/","<915>",$alg);   $alg = preg_replace("/1FR/","<916>",$alg);
    $alg = preg_replace("/1DL2'/","<921>",$alg);   $alg = preg_replace("/1DL'/","<922>",$alg);   $alg = preg_replace("/1DL2/","<923>",$alg);   $alg = preg_replace("/1DL/","<924>",$alg);
    $alg = preg_replace("/1DR2'/","<929>",$alg);   $alg = preg_replace("/1DR'/","<930>",$alg);   $alg = preg_replace("/1DR2/","<931>",$alg);   $alg = preg_replace("/1DR/","<932>",$alg);
    
    $alg = preg_replace("/1R2'/", "<917>",$alg);   $alg = preg_replace("/1R'/", "<918>",$alg);   $alg = preg_replace("/1R2/", "<919>",$alg);   $alg = preg_replace("/1R/", "<920>",$alg);
    $alg = preg_replace("/1L2'/", "<925>",$alg);   $alg = preg_replace("/1L'/", "<926>",$alg);   $alg = preg_replace("/1L2/", "<927>",$alg);   $alg = preg_replace("/1L/", "<928>",$alg);
    $alg = preg_replace("/1F2'/", "<933>",$alg);   $alg = preg_replace("/1F'/", "<934>",$alg);   $alg = preg_replace("/1F2/", "<935>",$alg);   $alg = preg_replace("/1F/", "<936>",$alg);
    $alg = preg_replace("/1B2'/", "<937>",$alg);   $alg = preg_replace("/1B'/", "<938>",$alg);   $alg = preg_replace("/1B2/", "<939>",$alg);   $alg = preg_replace("/1B/", "<940>",$alg);
    $alg = preg_replace("/1U2'/", "<941>",$alg);   $alg = preg_replace("/1U'/", "<942>",$alg);   $alg = preg_replace("/1U2/", "<943>",$alg);   $alg = preg_replace("/1U/", "<944>",$alg);
    $alg = preg_replace("/1D2'/", "<945>",$alg);   $alg = preg_replace("/1D'/", "<946>",$alg);   $alg = preg_replace("/1D2/", "<947>",$alg);   $alg = preg_replace("/1D/", "<948>",$alg);
    
    
    $alg = preg_replace("/5BR2'/","<907>",$alg);   $alg = preg_replace("/5BR'/","<908>",$alg);   $alg = preg_replace("/5BR2/","<905>",$alg);   $alg = preg_replace("/5BR/","<906>",$alg);
    $alg = preg_replace("/5FL2'/","<903>",$alg);   $alg = preg_replace("/5FL'/","<904>",$alg);   $alg = preg_replace("/5FL2/","<901>",$alg);   $alg = preg_replace("/5FL/","<902>",$alg);
    $alg = preg_replace("/5BL2'/","<915>",$alg);   $alg = preg_replace("/5BL'/","<916>",$alg);   $alg = preg_replace("/5BL2/","<913>",$alg);   $alg = preg_replace("/5BL/","<914>",$alg);
    $alg = preg_replace("/5FR2'/","<911>",$alg);   $alg = preg_replace("/5FR'/","<912>",$alg);   $alg = preg_replace("/5FR2/","<909>",$alg);   $alg = preg_replace("/5FR/","<910>",$alg);
    $alg = preg_replace("/5DL2'/","<919>",$alg);   $alg = preg_replace("/5DL'/","<920>",$alg);   $alg = preg_replace("/5DL2/","<917>",$alg);   $alg = preg_replace("/5DL/","<918>",$alg);
    $alg = preg_replace("/5DR2'/","<927>",$alg);   $alg = preg_replace("/5DR'/","<928>",$alg);   $alg = preg_replace("/5DR2/","<925>",$alg);   $alg = preg_replace("/5DR/","<926>",$alg);
    
    $alg = preg_replace("/5R2'/", "<923>",$alg);   $alg = preg_replace("/5R'/", "<924>",$alg);   $alg = preg_replace("/5R2/", "<921>",$alg);   $alg = preg_replace("/5R/", "<922>",$alg);
    $alg = preg_replace("/5L2'/", "<931>",$alg);   $alg = preg_replace("/5L'/", "<932>",$alg);   $alg = preg_replace("/5L2/", "<929>",$alg);   $alg = preg_replace("/5L/", "<930>",$alg);
    $alg = preg_replace("/5F2'/", "<939>",$alg);   $alg = preg_replace("/5F'/", "<940>",$alg);   $alg = preg_replace("/5F2/", "<937>",$alg);   $alg = preg_replace("/5F/", "<938>",$alg);
    $alg = preg_replace("/5B2'/", "<935>",$alg);   $alg = preg_replace("/5B'/", "<936>",$alg);   $alg = preg_replace("/5B2/", "<933>",$alg);   $alg = preg_replace("/5B/", "<934>",$alg);
    $alg = preg_replace("/5U2'/", "<947>",$alg);   $alg = preg_replace("/5U'/", "<948>",$alg);   $alg = preg_replace("/5U2/", "<945>",$alg);   $alg = preg_replace("/5U/", "<946>",$alg);
    $alg = preg_replace("/5D2'/", "<943>",$alg);   $alg = preg_replace("/5D'/", "<944>",$alg);   $alg = preg_replace("/5D2/", "<941>",$alg);   $alg = preg_replace("/5D/", "<942>",$alg);
    
    /* --- 5xD: OLD TWIZZLE -> CODE: [7] Dodecahedron rotations --- */
    //<s> /* C */
    $alg = preg_replace("/BFv2'/","<719>",$alg);   $alg = preg_replace("/BFv'/","<720>",$alg);   $alg = preg_replace("/BFv2/","<717>",$alg);   $alg = preg_replace("/BFv/","<718>",$alg); // BF -> B.
    
    $alg = preg_replace("/Av2'/", "<703>",$alg);   $alg = preg_replace("/Av'/", "<704>",$alg);   $alg = preg_replace("/Av2/", "<701>",$alg);   $alg = preg_replace("/Av/", "<702>",$alg); // A  -> FL.
    $alg = preg_replace("/Cv2'/", "<707>",$alg);   $alg = preg_replace("/Cv'/", "<708>",$alg);   $alg = preg_replace("/Cv2/", "<705>",$alg);   $alg = preg_replace("/Cv/", "<706>",$alg); // C  -> FR.
    $alg = preg_replace("/Iv2'/", "<711>",$alg);   $alg = preg_replace("/Iv'/", "<712>",$alg);   $alg = preg_replace("/Iv2/", "<709>",$alg);   $alg = preg_replace("/Iv/", "<710>",$alg); // I  -> DL.
    $alg = preg_replace("/Ev2'/", "<715>",$alg);   $alg = preg_replace("/Ev'/", "<716>",$alg);   $alg = preg_replace("/Ev2/", "<713>",$alg);   $alg = preg_replace("/Ev/", "<714>",$alg); // E  -> DR.
    
    /* --- 5xD: TWIZZLE -> CODE: [7] Dodecahedron rotations --- */
    //<s> /* C */
    $alg = preg_replace("/BRv2'/","<701>",$alg);   $alg = preg_replace("/BRv'/","<702>",$alg);   $alg = preg_replace("/BRv2/","<703>",$alg);   $alg = preg_replace("/BRv/","<704>",$alg);
    $alg = preg_replace("/FLv2'/","<703>",$alg);   $alg = preg_replace("/FLv'/","<704>",$alg);   $alg = preg_replace("/FLv2/","<701>",$alg);   $alg = preg_replace("/FLv/","<702>",$alg);
    $alg = preg_replace("/BLv2'/","<705>",$alg);   $alg = preg_replace("/BLv'/","<706>",$alg);   $alg = preg_replace("/BLv2/","<707>",$alg);   $alg = preg_replace("/BLv/","<708>",$alg);
    $alg = preg_replace("/FRv2'/","<707>",$alg);   $alg = preg_replace("/FRv'/","<708>",$alg);   $alg = preg_replace("/FRv2/","<705>",$alg);   $alg = preg_replace("/FRv/","<706>",$alg);
    $alg = preg_replace("/DLv2'/","<711>",$alg);   $alg = preg_replace("/DLv'/","<712>",$alg);   $alg = preg_replace("/DLv2/","<709>",$alg);   $alg = preg_replace("/DLv/","<710>",$alg);
    $alg = preg_replace("/DRv2'/","<715>",$alg);   $alg = preg_replace("/DRv'/","<716>",$alg);   $alg = preg_replace("/DRv2/","<713>",$alg);   $alg = preg_replace("/DRv/","<714>",$alg);
    
    $alg = preg_replace("/Rv2'/", "<709>",$alg);   $alg = preg_replace("/Rv'/", "<710>",$alg);   $alg = preg_replace("/Rv2/", "<711>",$alg);   $alg = preg_replace("/Rv/", "<712>",$alg);
    $alg = preg_replace("/Lv2'/", "<713>",$alg);   $alg = preg_replace("/Lv'/", "<714>",$alg);   $alg = preg_replace("/Lv2/", "<715>",$alg);   $alg = preg_replace("/Lv/", "<716>",$alg);
    $alg = preg_replace("/Fv2'/", "<717>",$alg);   $alg = preg_replace("/Fv'/", "<718>",$alg);   $alg = preg_replace("/Fv2/", "<719>",$alg);   $alg = preg_replace("/Fv/", "<720>",$alg);
    $alg = preg_replace("/Bv2'/", "<719>",$alg);   $alg = preg_replace("/Bv'/", "<720>",$alg);   $alg = preg_replace("/Bv2/", "<717>",$alg);   $alg = preg_replace("/Bv/", "<718>",$alg);
    $alg = preg_replace("/Uv2'/", "<721>",$alg);   $alg = preg_replace("/Uv'/", "<722>",$alg);   $alg = preg_replace("/Uv2/", "<723>",$alg);   $alg = preg_replace("/Uv/", "<724>",$alg);
    $alg = preg_replace("/Dv2'/", "<723>",$alg);   $alg = preg_replace("/Dv'/", "<724>",$alg);   $alg = preg_replace("/Dv2/", "<721>",$alg);   $alg = preg_replace("/Dv/", "<722>",$alg);
    
    /* --- 5xD: TWIZZLE -> CODE: [2] Slice twists --- */
    if ($optSSE == true) {
/* xxx XXX xxx */
      // ACHTUNG! Vor- und nachgestellte Leerzeichen sollen nicht beabsichtigte Ersetzungen verhindern.
      // Dadurch werden aber Tokens am Anfang und am Schluss einer Zeile, bzw. vor einer Klammer nicht erkannt!
      // Diese nicht erkannten Tokens werden in einem zweiten Durchlauf optimiert.
      
// ACHTUNG! Test ohne vor- und nachgestellte Leerzeichen! Prüfen ob ein zweiter Durchlauf benötigt wird!
      
      //<s> /* S2 = S3-3 */
      $alg = preg_replace("/ fl2 br2' /","<201>",$alg);   $alg = preg_replace("/ fl br' /","<202>",$alg);   $alg = preg_replace("/ fl2' br2 /","<203>",$alg);   $alg = preg_replace("/ fl' br /","<204>",$alg);
      $alg = preg_replace("/ br2 fl2' /","<203>",$alg);   $alg = preg_replace("/ br fl' /","<204>",$alg);   $alg = preg_replace("/ br2' fl2 /","<201>",$alg);   $alg = preg_replace("/ br' fl /","<202>",$alg);
      $alg = preg_replace("/ fr2 bl2' /","<205>",$alg);   $alg = preg_replace("/ fr bl' /","<206>",$alg);   $alg = preg_replace("/ fr2' bl2 /","<207>",$alg);   $alg = preg_replace("/ fr' bl /","<208>",$alg);
      $alg = preg_replace("/ bl2 fr2' /","<207>",$alg);   $alg = preg_replace("/ bl fr' /","<208>",$alg);   $alg = preg_replace("/ bl2' fr2 /","<205>",$alg);   $alg = preg_replace("/ bl' fr /","<206>",$alg);
      $alg = preg_replace("/ r2 dl2' /", "<211>",$alg);   $alg = preg_replace("/ r dl' /", "<212>",$alg);   $alg = preg_replace("/ r2' dl2 /", "<209>",$alg);   $alg = preg_replace("/ r' dl /", "<210>",$alg);
      $alg = preg_replace("/ l2 dr2' /", "<215>",$alg);   $alg = preg_replace("/ l dr' /", "<216>",$alg);   $alg = preg_replace("/ l2' dr2 /", "<213>",$alg);   $alg = preg_replace("/ l' dr /", "<214>",$alg);
      
      $alg = preg_replace("/ dl2 r2' /", "<209>",$alg);   $alg = preg_replace("/ dl r' /", "<210>",$alg);   $alg = preg_replace("/ dl2' r2 /", "<211>",$alg);   $alg = preg_replace("/ dl' r /", "<212>",$alg);
      $alg = preg_replace("/ dr2 l2' /", "<213>",$alg);   $alg = preg_replace("/ dr l' /", "<214>",$alg);   $alg = preg_replace("/ dr2' l2 /", "<215>",$alg);   $alg = preg_replace("/ dr' l /", "<216>",$alg);
      $alg = preg_replace("/ b2 f2' /",  "<217>",$alg);   $alg = preg_replace("/ b f' /",  "<218>",$alg);   $alg = preg_replace("/ b2' f2 /",  "<219>",$alg);   $alg = preg_replace("/ b' f /",  "<220>",$alg);
      $alg = preg_replace("/ f2 b2' /",  "<219>",$alg);   $alg = preg_replace("/ f b' /",  "<220>",$alg);   $alg = preg_replace("/ f2' b2 /",  "<217>",$alg);   $alg = preg_replace("/ f' b /",  "<218>",$alg);
      $alg = preg_replace("/ d2 u2' /",  "<221>",$alg);   $alg = preg_replace("/ d u' /",  "<222>",$alg);   $alg = preg_replace("/ d2' u2 /",  "<223>",$alg);   $alg = preg_replace("/ d' u /",  "<224>",$alg);
      $alg = preg_replace("/ u2 d2' /",  "<223>",$alg);   $alg = preg_replace("/ u d' /",  "<224>",$alg);   $alg = preg_replace("/ u2' d2 /",  "<221>",$alg);   $alg = preg_replace("/ u' d /",  "<222>",$alg);
      
      
      /* Non-slice-twists */
      $alg = preg_replace("/ BR2' FL2' /","<249>",$alg);   $alg = preg_replace("/ BR' FL' /","<250>",$alg);
      $alg = preg_replace("/ FL2' BR2' /","<249>",$alg);   $alg = preg_replace("/ FL' BR' /","<250>",$alg);
      $alg = preg_replace("/ BL2' FR2' /","<251>",$alg);   $alg = preg_replace("/ BL' FR' /","<252>",$alg);
      $alg = preg_replace("/ FR2' BL2' /","<251>",$alg);   $alg = preg_replace("/ FR' BL' /","<252>",$alg);
      $alg = preg_replace("/ L2' DR2' /", "<255>",$alg);   $alg = preg_replace("/ L' DR' /", "<256>",$alg);
      $alg = preg_replace("/ R2' DL2' /", "<253>",$alg);   $alg = preg_replace("/ R' DL' /", "<254>",$alg);
      
      $alg = preg_replace("/ DR2' L2' /", "<255>",$alg);   $alg = preg_replace("/ DR' L' /", "<256>",$alg);
      $alg = preg_replace("/ DL2' R2' /", "<253>",$alg);   $alg = preg_replace("/ DL' R' /", "<254>",$alg);
      $alg = preg_replace("/ F2' B2' /",  "<257>",$alg);   $alg = preg_replace("/ F' B' /",  "<258>",$alg);
      $alg = preg_replace("/ B2' F2' /",  "<257>",$alg);   $alg = preg_replace("/ B' F' /",  "<258>",$alg);
      $alg = preg_replace("/ U2' D2' /",  "<259>",$alg);   $alg = preg_replace("/ U' D' /",  "<260>",$alg);
      $alg = preg_replace("/ D2' U2' /",  "<259>",$alg);   $alg = preg_replace("/ D' U' /",  "<260>",$alg);
      
      //<s> /* S = S2-4 */
      $alg = preg_replace("/ FL2 BR2' /","<225>",$alg);   $alg = preg_replace("/ FL BR' /","<226>",$alg);   $alg = preg_replace("/ FL2' BR2 /","<227>",$alg);   $alg = preg_replace("/ FL' BR /","<228>",$alg);
      $alg = preg_replace("/ BR2 FL2' /","<227>",$alg);   $alg = preg_replace("/ BR FL' /","<228>",$alg);   $alg = preg_replace("/ BR2' FL2 /","<225>",$alg);   $alg = preg_replace("/ BR' FL /","<226>",$alg);
      $alg = preg_replace("/ FR2 BL2' /","<229>",$alg);   $alg = preg_replace("/ FR BL' /","<230>",$alg);   $alg = preg_replace("/ FR2' BL2 /","<231>",$alg);   $alg = preg_replace("/ FR' BL /","<232>",$alg);
      $alg = preg_replace("/ BL2 FR2' /","<231>",$alg);   $alg = preg_replace("/ BL FR' /","<232>",$alg);   $alg = preg_replace("/ BL2' FR2 /","<229>",$alg);   $alg = preg_replace("/ BL' FR /","<230>",$alg);
      $alg = preg_replace("/ R2 DL2' /", "<235>",$alg);   $alg = preg_replace("/ R DL' /", "<236>",$alg);   $alg = preg_replace("/ R2' DL2 /", "<233>",$alg);   $alg = preg_replace("/ R' DL /", "<234>",$alg);
      $alg = preg_replace("/ L2 DR2' /", "<239>",$alg);   $alg = preg_replace("/ L DR' /", "<240>",$alg);   $alg = preg_replace("/ L2' DR2 /", "<237>",$alg);   $alg = preg_replace("/ L' DR /", "<238>",$alg);
      
      $alg = preg_replace("/ DL2 R2' /", "<233>",$alg);   $alg = preg_replace("/ DL R' /", "<234>",$alg);   $alg = preg_replace("/ DL2' R2 /", "<235>",$alg);   $alg = preg_replace("/ DL' R /", "<236>",$alg);
      $alg = preg_replace("/ DR2 L2' /", "<237>",$alg);   $alg = preg_replace("/ DR L' /", "<238>",$alg);   $alg = preg_replace("/ DR2' L2 /", "<239>",$alg);   $alg = preg_replace("/ DR' L /", "<240>",$alg);
      $alg = preg_replace("/ B2 F2' /",  "<241>",$alg);   $alg = preg_replace("/ B F' /",  "<242>",$alg);   $alg = preg_replace("/ B2' F2 /",  "<243>",$alg);   $alg = preg_replace("/ B' F /",  "<244>",$alg);
      $alg = preg_replace("/ F2 B2' /",  "<243>",$alg);   $alg = preg_replace("/ F B' /",  "<244>",$alg);   $alg = preg_replace("/ F2' B2 /",  "<241>",$alg);   $alg = preg_replace("/ F' B /",  "<242>",$alg);
      $alg = preg_replace("/ D2 U2' /",  "<245>",$alg);   $alg = preg_replace("/ D U' /",  "<246>",$alg);   $alg = preg_replace("/ D2' U2 /",  "<247>",$alg);   $alg = preg_replace("/ D' U /",  "<248>",$alg);
      $alg = preg_replace("/ U2 D2' /",  "<247>",$alg);   $alg = preg_replace("/ U D' /",  "<248>",$alg);   $alg = preg_replace("/ U2' D2 /",  "<245>",$alg);   $alg = preg_replace("/ U' D /",  "<246>",$alg);
      
      /* S2-2 | S4-4 */
      
      /* S2-3 | S3-4 */
    }
    
    /* --- 5xD: OLD TWIZZLE -> CODE: [9] Face twists --- */
    //<s> /*   */
    $alg = preg_replace("/BF2'/","<937>",$alg);   $alg = preg_replace("/BF'/","<938>",$alg);   $alg = preg_replace("/BF2/","<939>",$alg);   $alg = preg_replace("/BF/","<940>",$alg); // BF -> B.
    
    $alg = preg_replace("/A2'/", "<905>",$alg);   $alg = preg_replace("/A'/", "<906>",$alg);   $alg = preg_replace("/A2/", "<907>",$alg);   $alg = preg_replace("/A/", "<908>",$alg); // A  -> FL.
    $alg = preg_replace("/C2'/", "<913>",$alg);   $alg = preg_replace("/C'/", "<914>",$alg);   $alg = preg_replace("/C2/", "<915>",$alg);   $alg = preg_replace("/C/", "<916>",$alg); // C  -> FR.
    $alg = preg_replace("/I2'/", "<921>",$alg);   $alg = preg_replace("/I'/", "<922>",$alg);   $alg = preg_replace("/I2/", "<923>",$alg);   $alg = preg_replace("/I/", "<924>",$alg); // I  -> DL.
    $alg = preg_replace("/E2'/", "<929>",$alg);   $alg = preg_replace("/E'/", "<930>",$alg);   $alg = preg_replace("/E2/", "<931>",$alg);   $alg = preg_replace("/E/", "<932>",$alg); // E  -> DR.
    
    /* --- 5xD: TWIZZLE -> CODE: [9] Face twists --- */
    //<s> /*   */
    $alg = preg_replace("/BR2'/","<901>",$alg);   $alg = preg_replace("/BR'/","<902>",$alg);   $alg = preg_replace("/BR2/","<903>",$alg);   $alg = preg_replace("/BR/","<904>",$alg);
    $alg = preg_replace("/FL2'/","<905>",$alg);   $alg = preg_replace("/FL'/","<906>",$alg);   $alg = preg_replace("/FL2/","<907>",$alg);   $alg = preg_replace("/FL/","<908>",$alg);
    $alg = preg_replace("/BL2'/","<909>",$alg);   $alg = preg_replace("/BL'/","<910>",$alg);   $alg = preg_replace("/BL2/","<911>",$alg);   $alg = preg_replace("/BL/","<912>",$alg);
    $alg = preg_replace("/FR2'/","<913>",$alg);   $alg = preg_replace("/FR'/","<914>",$alg);   $alg = preg_replace("/FR2/","<915>",$alg);   $alg = preg_replace("/FR/","<916>",$alg);
    $alg = preg_replace("/DL2'/","<921>",$alg);   $alg = preg_replace("/DL'/","<922>",$alg);   $alg = preg_replace("/DL2/","<923>",$alg);   $alg = preg_replace("/DL/","<924>",$alg);
    $alg = preg_replace("/DR2'/","<929>",$alg);   $alg = preg_replace("/DR'/","<930>",$alg);   $alg = preg_replace("/DR2/","<931>",$alg);   $alg = preg_replace("/DR/","<932>",$alg);
    
    $alg = preg_replace("/R2'/", "<917>",$alg);   $alg = preg_replace("/R'/", "<918>",$alg);   $alg = preg_replace("/R2/", "<919>",$alg);   $alg = preg_replace("/R/", "<920>",$alg);
    $alg = preg_replace("/L2'/", "<925>",$alg);   $alg = preg_replace("/L'/", "<926>",$alg);   $alg = preg_replace("/L2/", "<927>",$alg);   $alg = preg_replace("/L/", "<928>",$alg);
    $alg = preg_replace("/F2'/", "<933>",$alg);   $alg = preg_replace("/F'/", "<934>",$alg);   $alg = preg_replace("/F2/", "<935>",$alg);   $alg = preg_replace("/F/", "<936>",$alg);
    $alg = preg_replace("/B2'/", "<937>",$alg);   $alg = preg_replace("/B'/", "<938>",$alg);   $alg = preg_replace("/B2/", "<939>",$alg);   $alg = preg_replace("/B/", "<940>",$alg);
    $alg = preg_replace("/U2'/", "<941>",$alg);   $alg = preg_replace("/U'/", "<942>",$alg);   $alg = preg_replace("/U2/", "<943>",$alg);   $alg = preg_replace("/U/", "<944>",$alg);
    $alg = preg_replace("/D2'/", "<945>",$alg);   $alg = preg_replace("/D'/", "<946>",$alg);   $alg = preg_replace("/D2/", "<947>",$alg);   $alg = preg_replace("/D/", "<948>",$alg);
    
    /* --- 5xD: OLD TWIZZLE -> CODE: [3] Tier twists (SiGN) --- */
    //<s> /* T */
    $alg = preg_replace("/bf2'/","<3133>",$alg);   $alg = preg_replace("/bf'/","<3134>",$alg);   $alg = preg_replace("/bf2/","<3135>",$alg);   $alg = preg_replace("/bf/","<3136>",$alg); // BF -> B.
    
    $alg = preg_replace("/a2'/", "<3101>",$alg);   $alg = preg_replace("/a'/", "<3102>",$alg);   $alg = preg_replace("/a2/", "<3103>",$alg);   $alg = preg_replace("/a/", "<3104>",$alg); // A  -> FL.
    $alg = preg_replace("/c2'/", "<3109>",$alg);   $alg = preg_replace("/c'/", "<3110>",$alg);   $alg = preg_replace("/c2/", "<3111>",$alg);   $alg = preg_replace("/c/", "<3112>",$alg); // C  -> FR.
    $alg = preg_replace("/i2'/", "<3117>",$alg);   $alg = preg_replace("/i'/", "<3118>",$alg);   $alg = preg_replace("/i2/", "<3119>",$alg);   $alg = preg_replace("/i/", "<3120>",$alg); // I  -> DL.
    $alg = preg_replace("/e2'/", "<3125>",$alg);   $alg = preg_replace("/e'/", "<3126>",$alg);   $alg = preg_replace("/e2/", "<3127>",$alg);   $alg = preg_replace("/e/", "<3128>",$alg); // E  -> DR.
     
    /* --- 5xD: TWIZZLE -> CODE: [3] Tier twists (SiGN) --- */
    //<s> /* T */
    $alg = preg_replace("/br2'/", "<397>",$alg);   $alg = preg_replace("/br'/", "<398>",$alg);   $alg = preg_replace("/br2/", "<399>",$alg);   $alg = preg_replace("/br/","<3100>",$alg);
    $alg = preg_replace("/fl2'/","<3101>",$alg);   $alg = preg_replace("/fl'/","<3102>",$alg);   $alg = preg_replace("/fl2/","<3103>",$alg);   $alg = preg_replace("/fl/","<3104>",$alg);
    $alg = preg_replace("/bl2'/","<3105>",$alg);   $alg = preg_replace("/bl'/","<3106>",$alg);   $alg = preg_replace("/bl2/","<3107>",$alg);   $alg = preg_replace("/bl/","<3108>",$alg);
    $alg = preg_replace("/fr2'/","<3109>",$alg);   $alg = preg_replace("/fr'/","<3110>",$alg);   $alg = preg_replace("/fr2/","<3111>",$alg);   $alg = preg_replace("/fr/","<3112>",$alg);
    $alg = preg_replace("/dl2'/","<3117>",$alg);   $alg = preg_replace("/dl'/","<3118>",$alg);   $alg = preg_replace("/dl2/","<3119>",$alg);   $alg = preg_replace("/dl/","<3120>",$alg);
    $alg = preg_replace("/dr2'/","<3125>",$alg);   $alg = preg_replace("/dr'/","<3126>",$alg);   $alg = preg_replace("/dr2/","<3127>",$alg);   $alg = preg_replace("/dr/","<3128>",$alg);
    
    $alg = preg_replace("/r2'/", "<3113>",$alg);   $alg = preg_replace("/r'/", "<3114>",$alg);   $alg = preg_replace("/r2/", "<3115>",$alg);   $alg = preg_replace("/r/", "<3116>",$alg);
    $alg = preg_replace("/l2'/", "<3121>",$alg);   $alg = preg_replace("/l'/", "<3122>",$alg);   $alg = preg_replace("/l2/", "<3123>",$alg);   $alg = preg_replace("/l/", "<3124>",$alg);
    $alg = preg_replace("/f2'/", "<3129>",$alg);   $alg = preg_replace("/f'/", "<3130>",$alg);   $alg = preg_replace("/f2/", "<3131>",$alg);   $alg = preg_replace("/f/", "<3132>",$alg);
    $alg = preg_replace("/b2'/", "<3133>",$alg);   $alg = preg_replace("/b'/", "<3134>",$alg);   $alg = preg_replace("/b2/", "<3135>",$alg);   $alg = preg_replace("/b/", "<3136>",$alg);
    $alg = preg_replace("/u2'/", "<3137>",$alg);   $alg = preg_replace("/u'/", "<3138>",$alg);   $alg = preg_replace("/u2/", "<3139>",$alg);   $alg = preg_replace("/u/", "<3140>",$alg);
    $alg = preg_replace("/d2'/", "<3141>",$alg);   $alg = preg_replace("/d'/", "<3142>",$alg);   $alg = preg_replace("/d2/", "<3143>",$alg);   $alg = preg_replace("/d/", "<3144>",$alg);
    
    /* ··································································································· */
    /* --- 5xD: CODE -> SSE: [3] Tier twists --- */
    //<s> /* T4 */
    $alg = preg_replace("/<301>/","T4UR2'",$alg);   $alg = preg_replace("/<302>/","T4UR'",$alg);   $alg = preg_replace("/<303>/","T4UR2",$alg);   $alg = preg_replace("/<304>/","T4UR",$alg);
    $alg = preg_replace("/<305>/","T4DL2'",$alg);   $alg = preg_replace("/<306>/","T4DL'",$alg);   $alg = preg_replace("/<307>/","T4DL2",$alg);   $alg = preg_replace("/<308>/","T4DL",$alg);
    $alg = preg_replace("/<309>/","T4UL2'",$alg);   $alg = preg_replace("/<310>/","T4UL'",$alg);   $alg = preg_replace("/<311>/","T4UL2",$alg);   $alg = preg_replace("/<312>/","T4UL",$alg);
    $alg = preg_replace("/<313>/","T4DR2'",$alg);   $alg = preg_replace("/<314>/","T4DR'",$alg);   $alg = preg_replace("/<315>/","T4DR2",$alg);   $alg = preg_replace("/<316>/","T4DR",$alg);
    $alg = preg_replace("/<321>/","T4BL2'",$alg);   $alg = preg_replace("/<322>/","T4BL'",$alg);   $alg = preg_replace("/<323>/","T4BL2",$alg);   $alg = preg_replace("/<324>/","T4BL",$alg);
    $alg = preg_replace("/<329>/","T4BR2'",$alg);   $alg = preg_replace("/<330>/","T4BR'",$alg);   $alg = preg_replace("/<331>/","T4BR2",$alg);   $alg = preg_replace("/<332>/","T4BR",$alg);
    
    $alg = preg_replace("/<317>/","T4R2'", $alg);   $alg = preg_replace("/<318>/","T4R'", $alg);   $alg = preg_replace("/<319>/","T4R2", $alg);   $alg = preg_replace("/<320>/","T4R", $alg);
    $alg = preg_replace("/<325>/","T4L2'", $alg);   $alg = preg_replace("/<326>/","T4L'", $alg);   $alg = preg_replace("/<327>/","T4L2", $alg);   $alg = preg_replace("/<328>/","T4L", $alg);
    $alg = preg_replace("/<333>/","T4F2'", $alg);   $alg = preg_replace("/<334>/","T4F'", $alg);   $alg = preg_replace("/<335>/","T4F2", $alg);   $alg = preg_replace("/<336>/","T4F", $alg);
    $alg = preg_replace("/<337>/","T4B2'", $alg);   $alg = preg_replace("/<338>/","T4B'", $alg);   $alg = preg_replace("/<339>/","T4B2", $alg);   $alg = preg_replace("/<340>/","T4B", $alg);
    $alg = preg_replace("/<341>/","T4U2'", $alg);   $alg = preg_replace("/<342>/","T4U'", $alg);   $alg = preg_replace("/<343>/","T4U2", $alg);   $alg = preg_replace("/<344>/","T4U", $alg);
    $alg = preg_replace("/<345>/","T4D2'", $alg);   $alg = preg_replace("/<346>/","T4D'", $alg);   $alg = preg_replace("/<347>/","T4D2", $alg);   $alg = preg_replace("/<348>/","T4D", $alg);
    
    
    //<s> /* T3 */
    $alg = preg_replace("/<349>/","T3UR2'",$alg);   $alg = preg_replace("/<350>/","T3UR'",$alg);   $alg = preg_replace("/<351>/","T3UR2",$alg);   $alg = preg_replace("/<352>/","T3UR",$alg);
    $alg = preg_replace("/<353>/","T3DL2'",$alg);   $alg = preg_replace("/<354>/","T3DL'",$alg);   $alg = preg_replace("/<355>/","T3DL2",$alg);   $alg = preg_replace("/<356>/","T3DL",$alg);
    $alg = preg_replace("/<357>/","T3UL2'",$alg);   $alg = preg_replace("/<358>/","T3UL'",$alg);   $alg = preg_replace("/<359>/","T3UL2",$alg);   $alg = preg_replace("/<360>/","T3UL",$alg);
    $alg = preg_replace("/<361>/","T3DR2'",$alg);   $alg = preg_replace("/<362>/","T3DR'",$alg);   $alg = preg_replace("/<363>/","T3DR2",$alg);   $alg = preg_replace("/<364>/","T3DR",$alg);
    $alg = preg_replace("/<369>/","T3BL2'",$alg);   $alg = preg_replace("/<370>/","T3BL'",$alg);   $alg = preg_replace("/<371>/","T3BL2",$alg);   $alg = preg_replace("/<372>/","T3BL",$alg);
    $alg = preg_replace("/<377>/","T3BR2'",$alg);   $alg = preg_replace("/<378>/","T3BR'",$alg);   $alg = preg_replace("/<379>/","T3BR2",$alg);   $alg = preg_replace("/<380>/","T3BR",$alg);
    
    $alg = preg_replace("/<365>/","T3R2'", $alg);   $alg = preg_replace("/<366>/","T3R'", $alg);   $alg = preg_replace("/<367>/","T3R2", $alg);   $alg = preg_replace("/<368>/","T3R", $alg);
    $alg = preg_replace("/<373>/","T3L2'", $alg);   $alg = preg_replace("/<374>/","T3L'", $alg);   $alg = preg_replace("/<375>/","T3L2", $alg);   $alg = preg_replace("/<376>/","T3L", $alg);
    $alg = preg_replace("/<381>/","T3F2'", $alg);   $alg = preg_replace("/<382>/","T3F'", $alg);   $alg = preg_replace("/<383>/","T3F2", $alg);   $alg = preg_replace("/<384>/","T3F", $alg);
    $alg = preg_replace("/<385>/","T3B2'", $alg);   $alg = preg_replace("/<386>/","T3B'", $alg);   $alg = preg_replace("/<387>/","T3B2", $alg);   $alg = preg_replace("/<388>/","T3B", $alg);
    $alg = preg_replace("/<389>/","T3U2'", $alg);   $alg = preg_replace("/<390>/","T3U'", $alg);   $alg = preg_replace("/<391>/","T3U2", $alg);   $alg = preg_replace("/<392>/","T3U", $alg);
    $alg = preg_replace("/<393>/","T3D2'", $alg);   $alg = preg_replace("/<394>/","T3D'", $alg);   $alg = preg_replace("/<395>/","T3D2", $alg);   $alg = preg_replace("/<396>/","T3D", $alg);
    
    
    //<s> /* T */
    $alg = preg_replace("/<397>/", "TUR2'",$alg);   $alg = preg_replace("/<398>/", "TUR'",$alg);   $alg = preg_replace("/<399>/", "TUR2",$alg);   $alg = preg_replace("/<3100>/","TUR",$alg);
    $alg = preg_replace("/<3101>/","TDL2'",$alg);   $alg = preg_replace("/<3102>/","TDL'",$alg);   $alg = preg_replace("/<3103>/","TDL2",$alg);   $alg = preg_replace("/<3104>/","TDL",$alg);
    $alg = preg_replace("/<3105>/","TUL2'",$alg);   $alg = preg_replace("/<3106>/","TUL'",$alg);   $alg = preg_replace("/<3107>/","TUL2",$alg);   $alg = preg_replace("/<3108>/","TUL",$alg);
    $alg = preg_replace("/<3109>/","TDR2'",$alg);   $alg = preg_replace("/<3110>/","TDR'",$alg);   $alg = preg_replace("/<3111>/","TDR2",$alg);   $alg = preg_replace("/<3112>/","TDR",$alg);
    $alg = preg_replace("/<3117>/","TBL2'",$alg);   $alg = preg_replace("/<3118>/","TBL'",$alg);   $alg = preg_replace("/<3119>/","TBL2",$alg);   $alg = preg_replace("/<3120>/","TBL",$alg);
    $alg = preg_replace("/<3125>/","TBR2'",$alg);   $alg = preg_replace("/<3126>/","TBR'",$alg);   $alg = preg_replace("/<3127>/","TBR2",$alg);   $alg = preg_replace("/<3128>/","TBR",$alg);
    
    $alg = preg_replace("/<3113>/","TR2'", $alg);   $alg = preg_replace("/<3114>/","TR'", $alg);   $alg = preg_replace("/<3115>/","TR2", $alg);   $alg = preg_replace("/<3116>/","TR", $alg);
    $alg = preg_replace("/<3121>/","TL2'", $alg);   $alg = preg_replace("/<3122>/","TL'", $alg);   $alg = preg_replace("/<3123>/","TL2", $alg);   $alg = preg_replace("/<3124>/","TL", $alg);
    $alg = preg_replace("/<3129>/","TF2'", $alg);   $alg = preg_replace("/<3130>/","TF'", $alg);   $alg = preg_replace("/<3131>/","TF2", $alg);   $alg = preg_replace("/<3132>/","TF", $alg);
    $alg = preg_replace("/<3133>/","TB2'", $alg);   $alg = preg_replace("/<3134>/","TB'", $alg);   $alg = preg_replace("/<3135>/","TB2", $alg);   $alg = preg_replace("/<3136>/","TB", $alg);
    $alg = preg_replace("/<3137>/","TU2'", $alg);   $alg = preg_replace("/<3138>/","TU'", $alg);   $alg = preg_replace("/<3139>/","TU2", $alg);   $alg = preg_replace("/<3140>/","TU", $alg);
    $alg = preg_replace("/<3141>/","TD2'", $alg);   $alg = preg_replace("/<3142>/","TD'", $alg);   $alg = preg_replace("/<3143>/","TD2", $alg);   $alg = preg_replace("/<3144>/","TD", $alg);
    
    /* --- 5xD: CODE -> SSE opt: [2] Slice twists --- */
    if ($optSSE == true) {
/* xxx XXX xxx */
      // ACHTUNG! Benötigt vor- und nachgestellte Leerzeichen (siehe TWIZZLE -> CODE).
      
// ACHTUNG! Test ohne vor- und nachgestellte Leerzeichen! Prüfen ob ein zweiter Durchlauf benötigt wird!
      
      //<s> /* S2 = S3-3 */
      $alg = preg_replace("/<201>/"," S2UR2' ",$alg);   $alg = preg_replace("/<202>/"," S2UR' ",$alg);   $alg = preg_replace("/<203>/"," S2UR2 ",$alg);   $alg = preg_replace("/<204>/"," S2UR ",$alg);
      $alg = preg_replace("/<205>/"," S2UL2' ",$alg);   $alg = preg_replace("/<206>/"," S2UL' ",$alg);   $alg = preg_replace("/<207>/"," S2UL2 ",$alg);   $alg = preg_replace("/<208>/"," S2UL ",$alg);
      
      $alg = preg_replace("/<213>/"," S2L2' ", $alg);   $alg = preg_replace("/<214>/"," S2L' ", $alg);   $alg = preg_replace("/<215>/"," S2L2 ", $alg);   $alg = preg_replace("/<216>/"," S2L ", $alg);
      $alg = preg_replace("/<209>/"," S2R2' ", $alg);   $alg = preg_replace("/<210>/"," S2R' ", $alg);   $alg = preg_replace("/<211>/"," S2R2 ", $alg);   $alg = preg_replace("/<212>/"," S2R ", $alg);
      $alg = preg_replace("/<217>/"," S2F2' ", $alg);   $alg = preg_replace("/<218>/"," S2F' ", $alg);   $alg = preg_replace("/<219>/"," S2F2 ", $alg);   $alg = preg_replace("/<220>/"," S2F ", $alg);
      $alg = preg_replace("/<221>/"," S2U2' ", $alg);   $alg = preg_replace("/<222>/"," S2U' ", $alg);   $alg = preg_replace("/<223>/"," S2U2 ", $alg);   $alg = preg_replace("/<224>/"," S2U ", $alg);
      
      
      /* Non-slice-twists */
      $alg = preg_replace("/<249>/"," UR2' DL2' ",$alg);   $alg = preg_replace("/<250>/"," UR' DL' ",$alg);
      $alg = preg_replace("/<251>/"," UL2' DR2' ",$alg);   $alg = preg_replace("/<252>/"," UL' DR' ",$alg);
      
      $alg = preg_replace("/<255>/"," L2' BR2' ", $alg);   $alg = preg_replace("/<256>/"," L' BR' ", $alg);
      $alg = preg_replace("/<253>/"," R2' BL2' ", $alg);   $alg = preg_replace("/<254>/"," R' BL' ", $alg);
      $alg = preg_replace("/<257>/"," F2' B2' ", $alg);    $alg = preg_replace("/<258>/"," F' B' ", $alg);
      $alg = preg_replace("/<259>/"," U2' D2' ", $alg);    $alg = preg_replace("/<260>/"," U' D' ", $alg);
      
      //<s> /* S = S2-4 */
      $alg = preg_replace("/<225>/"," SUR2' ",$alg);   $alg = preg_replace("/<226>/"," SUR' ",$alg);   $alg = preg_replace("/<227>/"," SUR2 ",$alg);   $alg = preg_replace("/<228>/"," SUR ",$alg);
      $alg = preg_replace("/<229>/"," SUL2' ",$alg);   $alg = preg_replace("/<230>/"," SUL' ",$alg);   $alg = preg_replace("/<231>/"," SUL2 ",$alg);   $alg = preg_replace("/<232>/"," SUL ",$alg);
      
      $alg = preg_replace("/<237>/"," SL2' ", $alg);   $alg = preg_replace("/<238>/"," SL' ", $alg);   $alg = preg_replace("/<239>/"," SL2 ", $alg);   $alg = preg_replace("/<240>/"," SL ", $alg);
      $alg = preg_replace("/<233>/"," SR2' ", $alg);   $alg = preg_replace("/<234>/"," SR' ", $alg);   $alg = preg_replace("/<235>/"," SR2 ", $alg);   $alg = preg_replace("/<236>/"," SR ", $alg);
      $alg = preg_replace("/<241>/"," SF2' ", $alg);   $alg = preg_replace("/<242>/"," SF' ", $alg);   $alg = preg_replace("/<243>/"," SF2 ", $alg);   $alg = preg_replace("/<244>/"," SF ", $alg);
      $alg = preg_replace("/<245>/"," SU2' ", $alg);   $alg = preg_replace("/<246>/"," SU' ", $alg);   $alg = preg_replace("/<247>/"," SU2 ", $alg);   $alg = preg_replace("/<248>/"," SU ", $alg);
      
      /* S2-2 | S4-4 */
      
      /* S2-3 | S3-4 */
    }
    
    /* --- 5xD: CODE -> SSE: [6] Wide twists --- */
    //<s> /* W */
    $alg = preg_replace("/<601>/","WUR2'",$alg);   $alg = preg_replace("/<602>/","WUR'",$alg);   $alg = preg_replace("/<603>/","WUR2",$alg);   $alg = preg_replace("/<604>/","WUR",$alg);
    $alg = preg_replace("/<605>/","WUL2'",$alg);   $alg = preg_replace("/<606>/","WUL'",$alg);   $alg = preg_replace("/<607>/","WUL2",$alg);   $alg = preg_replace("/<608>/","WUL",$alg);
    
    $alg = preg_replace("/<609>/","WR2'", $alg);   $alg = preg_replace("/<610>/","WR'", $alg);   $alg = preg_replace("/<611>/","WR2", $alg);   $alg = preg_replace("/<612>/","WR", $alg);
    $alg = preg_replace("/<613>/","WL2'", $alg);   $alg = preg_replace("/<614>/","WL'", $alg);   $alg = preg_replace("/<615>/","WL2", $alg);   $alg = preg_replace("/<616>/","WL", $alg);
    $alg = preg_replace("/<617>/","WF2'", $alg);   $alg = preg_replace("/<618>/","WF'", $alg);   $alg = preg_replace("/<619>/","WF2", $alg);   $alg = preg_replace("/<620>/","WF", $alg);
    $alg = preg_replace("/<621>/","WU2'", $alg);   $alg = preg_replace("/<622>/","WU'", $alg);   $alg = preg_replace("/<623>/","WU2", $alg);   $alg = preg_replace("/<624>/","WU", $alg);
    
    /* --- 5xD: CODE -> SSE: [4] Void twists --- */
    //<s> /* V */
    $alg = preg_replace("/<401>/","VUR2'",$alg);   $alg = preg_replace("/<402>/","VUR'",$alg);   $alg = preg_replace("/<403>/","VUR2",$alg);   $alg = preg_replace("/<404>/","VUR",$alg);
    $alg = preg_replace("/<405>/","VDL2'",$alg);   $alg = preg_replace("/<406>/","VDL'",$alg);   $alg = preg_replace("/<407>/","VDL2",$alg);   $alg = preg_replace("/<408>/","VDL",$alg);
    $alg = preg_replace("/<409>/","VUL2'",$alg);   $alg = preg_replace("/<410>/","VUL'",$alg);   $alg = preg_replace("/<411>/","VUL2",$alg);   $alg = preg_replace("/<412>/","VUL",$alg);
    $alg = preg_replace("/<413>/","VDR2'",$alg);   $alg = preg_replace("/<414>/","VDR'",$alg);   $alg = preg_replace("/<415>/","VDR2",$alg);   $alg = preg_replace("/<416>/","VDR",$alg);
    $alg = preg_replace("/<421>/","VBL2'",$alg);   $alg = preg_replace("/<422>/","VBL'",$alg);   $alg = preg_replace("/<423>/","VBL2",$alg);   $alg = preg_replace("/<424>/","VBL",$alg);
    $alg = preg_replace("/<429>/","VBR2'",$alg);   $alg = preg_replace("/<430>/","VBR'",$alg);   $alg = preg_replace("/<431>/","VBR2",$alg);   $alg = preg_replace("/<432>/","VBR",$alg);
    
    $alg = preg_replace("/<417>/","VR2'", $alg);   $alg = preg_replace("/<418>/","VR'", $alg);   $alg = preg_replace("/<419>/","VR2", $alg);   $alg = preg_replace("/<420>/","VR", $alg);
    $alg = preg_replace("/<425>/","VL2'", $alg);   $alg = preg_replace("/<426>/","VL'", $alg);   $alg = preg_replace("/<427>/","VL2", $alg);   $alg = preg_replace("/<428>/","VL", $alg);
    $alg = preg_replace("/<433>/","VF2'", $alg);   $alg = preg_replace("/<434>/","VF'", $alg);   $alg = preg_replace("/<435>/","VF2", $alg);   $alg = preg_replace("/<436>/","VF", $alg);
    $alg = preg_replace("/<437>/","VB2'", $alg);   $alg = preg_replace("/<438>/","VB'", $alg);   $alg = preg_replace("/<439>/","VB2", $alg);   $alg = preg_replace("/<440>/","VB", $alg);
    $alg = preg_replace("/<441>/","VU2'", $alg);   $alg = preg_replace("/<442>/","VU'", $alg);   $alg = preg_replace("/<443>/","VU2", $alg);   $alg = preg_replace("/<444>/","VU", $alg);
    $alg = preg_replace("/<445>/","VD2'", $alg);   $alg = preg_replace("/<446>/","VD'", $alg);   $alg = preg_replace("/<447>/","VD2", $alg);   $alg = preg_replace("/<448>/","VD", $alg);
    
    /* --- 5xD: CODE -> SSE: [1] Numbered layer [5] (Mid-layer) twists --- */
    //<s> /* N | N4 */
    $alg = preg_replace("/<101>/","NUR2'",$alg);   $alg = preg_replace("/<102>/","NUR'",$alg);   $alg = preg_replace("/<103>/","NUR2",$alg);   $alg = preg_replace("/<104>/","NUR",$alg);
    $alg = preg_replace("/<105>/","NDL2'",$alg);   $alg = preg_replace("/<106>/","NDL'",$alg);   $alg = preg_replace("/<107>/","NDL2",$alg);   $alg = preg_replace("/<108>/","NDL",$alg);
    $alg = preg_replace("/<109>/","NUL2'",$alg);   $alg = preg_replace("/<110>/","NUL'",$alg);   $alg = preg_replace("/<111>/","NUL2",$alg);   $alg = preg_replace("/<112>/","NUL",$alg);
    $alg = preg_replace("/<113>/","NDR2'",$alg);   $alg = preg_replace("/<114>/","NDR'",$alg);   $alg = preg_replace("/<115>/","NDR2",$alg);   $alg = preg_replace("/<116>/","NDR",$alg);
    $alg = preg_replace("/<121>/","NBL2'",$alg);   $alg = preg_replace("/<122>/","NBL'",$alg);   $alg = preg_replace("/<123>/","NBL2",$alg);   $alg = preg_replace("/<124>/","NBL",$alg);
    $alg = preg_replace("/<129>/","NBR2'",$alg);   $alg = preg_replace("/<130>/","NBR'",$alg);   $alg = preg_replace("/<131>/","NBR2",$alg);   $alg = preg_replace("/<132>/","NBR",$alg);
    
    $alg = preg_replace("/<117>/","NR2'", $alg);   $alg = preg_replace("/<118>/","NR'", $alg);   $alg = preg_replace("/<119>/","NR2", $alg);   $alg = preg_replace("/<120>/","NR", $alg);
    $alg = preg_replace("/<125>/","NL2'", $alg);   $alg = preg_replace("/<126>/","NL'", $alg);   $alg = preg_replace("/<127>/","NL2", $alg);   $alg = preg_replace("/<128>/","NL", $alg);
    $alg = preg_replace("/<133>/","NF2'", $alg);   $alg = preg_replace("/<134>/","NF'", $alg);   $alg = preg_replace("/<135>/","NF2", $alg);   $alg = preg_replace("/<136>/","NF", $alg);
    $alg = preg_replace("/<137>/","NB2'", $alg);   $alg = preg_replace("/<138>/","NB'", $alg);   $alg = preg_replace("/<139>/","NB2", $alg);   $alg = preg_replace("/<140>/","NB", $alg);
    $alg = preg_replace("/<141>/","NU2'", $alg);   $alg = preg_replace("/<142>/","NU'", $alg);   $alg = preg_replace("/<143>/","NU2", $alg);   $alg = preg_replace("/<144>/","NU", $alg);
    $alg = preg_replace("/<145>/","ND2'", $alg);   $alg = preg_replace("/<146>/","ND'", $alg);   $alg = preg_replace("/<147>/","ND2", $alg);   $alg = preg_replace("/<148>/","ND", $alg);
    
    
    //<s> /* N3 = M */
    $alg = preg_replace("/<149>/","MUR2'",$alg);   $alg = preg_replace("/<150>/","MUR'",$alg);   $alg = preg_replace("/<151>/","MUR2",$alg);   $alg = preg_replace("/<152>/","MUR",$alg);
    $alg = preg_replace("/<153>/","MUL2'",$alg);   $alg = preg_replace("/<154>/","MUL'",$alg);   $alg = preg_replace("/<155>/","MUL2",$alg);   $alg = preg_replace("/<156>/","MUL",$alg);
    
    $alg = preg_replace("/<157>/","MR2'", $alg);   $alg = preg_replace("/<158>/","MR'", $alg);   $alg = preg_replace("/<159>/","MR2", $alg);   $alg = preg_replace("/<160>/","MR", $alg);
    $alg = preg_replace("/<161>/","ML2'", $alg);   $alg = preg_replace("/<162>/","ML'", $alg);   $alg = preg_replace("/<163>/","ML2", $alg);   $alg = preg_replace("/<164>/","ML", $alg);
    $alg = preg_replace("/<165>/","MF2'", $alg);   $alg = preg_replace("/<166>/","MF'", $alg);   $alg = preg_replace("/<167>/","MF2", $alg);   $alg = preg_replace("/<168>/","MF", $alg);
    $alg = preg_replace("/<169>/","MU2'", $alg);   $alg = preg_replace("/<170>/","MU'", $alg);   $alg = preg_replace("/<171>/","MU2", $alg);   $alg = preg_replace("/<172>/","MU", $alg);
    
    /* --- 5xD: CODE -> SSE: [7] Dodecahedron rotations --- */
    //<s> /* C */
    $alg = preg_replace("/<701>/","CUR2'",$alg);   $alg = preg_replace("/<702>/","CUR'",$alg);   $alg = preg_replace("/<703>/","CUR2",$alg);   $alg = preg_replace("/<704>/","CUR",$alg);
    $alg = preg_replace("/<705>/","CUL2'",$alg);   $alg = preg_replace("/<706>/","CUL'",$alg);   $alg = preg_replace("/<707>/","CUL2",$alg);   $alg = preg_replace("/<708>/","CUL",$alg);
    
    $alg = preg_replace("/<709>/","CR2'", $alg);   $alg = preg_replace("/<710>/","CR'", $alg);   $alg = preg_replace("/<711>/","CR2", $alg);   $alg = preg_replace("/<712>/","CR", $alg);
    $alg = preg_replace("/<713>/","CL2'", $alg);   $alg = preg_replace("/<714>/","CL'", $alg);   $alg = preg_replace("/<715>/","CL2", $alg);   $alg = preg_replace("/<716>/","CL", $alg);
    $alg = preg_replace("/<717>/","CF2'", $alg);   $alg = preg_replace("/<718>/","CF'", $alg);   $alg = preg_replace("/<719>/","CF2", $alg);   $alg = preg_replace("/<720>/","CF", $alg);
    $alg = preg_replace("/<721>/","CU2'", $alg);   $alg = preg_replace("/<722>/","CU'", $alg);   $alg = preg_replace("/<723>/","CU2", $alg);   $alg = preg_replace("/<724>/","CU", $alg);
    
    /* --- 5xD: CODE -> SSE: [9] Face twists --- */
    //<s> /*   */
    $alg = preg_replace("/<901>/","UR2'",$alg);   $alg = preg_replace("/<902>/","UR'",$alg);   $alg = preg_replace("/<903>/","UR2",$alg);   $alg = preg_replace("/<904>/","UR",$alg);
    $alg = preg_replace("/<905>/","DL2'",$alg);   $alg = preg_replace("/<906>/","DL'",$alg);   $alg = preg_replace("/<907>/","DL2",$alg);   $alg = preg_replace("/<908>/","DL",$alg);
    $alg = preg_replace("/<909>/","UL2'",$alg);   $alg = preg_replace("/<910>/","UL'",$alg);   $alg = preg_replace("/<911>/","UL2",$alg);   $alg = preg_replace("/<912>/","UL",$alg);
    $alg = preg_replace("/<913>/","DR2'",$alg);   $alg = preg_replace("/<914>/","DR'",$alg);   $alg = preg_replace("/<915>/","DR2",$alg);   $alg = preg_replace("/<916>/","DR",$alg);
    $alg = preg_replace("/<921>/","BL2'",$alg);   $alg = preg_replace("/<922>/","BL'",$alg);   $alg = preg_replace("/<923>/","BL2",$alg);   $alg = preg_replace("/<924>/","BL",$alg);
    $alg = preg_replace("/<929>/","BR2'",$alg);   $alg = preg_replace("/<930>/","BR'",$alg);   $alg = preg_replace("/<931>/","BR2",$alg);   $alg = preg_replace("/<932>/","BR",$alg);
    
    $alg = preg_replace("/<917>/","R2'", $alg);   $alg = preg_replace("/<918>/","R'", $alg);   $alg = preg_replace("/<919>/","R2", $alg);   $alg = preg_replace("/<920>/","R", $alg);
    $alg = preg_replace("/<925>/","L2'", $alg);   $alg = preg_replace("/<926>/","L'", $alg);   $alg = preg_replace("/<927>/","L2", $alg);   $alg = preg_replace("/<928>/","L", $alg);
    $alg = preg_replace("/<933>/","F2'", $alg);   $alg = preg_replace("/<934>/","F'", $alg);   $alg = preg_replace("/<935>/","F2", $alg);   $alg = preg_replace("/<936>/","F", $alg);
    $alg = preg_replace("/<937>/","B2'", $alg);   $alg = preg_replace("/<938>/","B'", $alg);   $alg = preg_replace("/<939>/","B2", $alg);   $alg = preg_replace("/<940>/","B", $alg);
    $alg = preg_replace("/<941>/","U2'", $alg);   $alg = preg_replace("/<942>/","U'", $alg);   $alg = preg_replace("/<943>/","U2", $alg);   $alg = preg_replace("/<944>/","U", $alg);
    $alg = preg_replace("/<945>/","D2'", $alg);   $alg = preg_replace("/<946>/","D'", $alg);   $alg = preg_replace("/<947>/","D2", $alg);   $alg = preg_replace("/<948>/","D", $alg);
    
    /* *************************************************************************************************** */
    /* --- Second pass --- */
    
// ACHTUNG! Prüfen ob ein zweiter Durchlauf benötigt wird!
    
    /* --- 5xD: SSE -> CODE: [2] Slice twists --- */
    if ($optSSE == true) {
/* xxx   xxx */
      /* S2 = S3-3 */
      $alg = preg_replace("/TDL2 TUR2'/","<201>",$alg);   $alg = preg_replace("/TDL TUR'/","<202>",$alg);   $alg = preg_replace("/TDL2' TUR2/","<203>",$alg);   $alg = preg_replace("/TDL' TUR/","<204>",$alg);
      $alg = preg_replace("/TUR2 TDL2'/","<203>",$alg);   $alg = preg_replace("/TUR TDL'/","<204>",$alg);   $alg = preg_replace("/TUR2' TDL2/","<201>",$alg);   $alg = preg_replace("/TUR' TDL/","<202>",$alg);
      
      $alg = preg_replace("/TDR2 TUL2'/","<205>",$alg);   $alg = preg_replace("/TDR TUL'/","<206>",$alg);   $alg = preg_replace("/TDR2' TUL2/","<207>",$alg);   $alg = preg_replace("/TDR' TUL/","<208>",$alg);
      $alg = preg_replace("/TUL2 TDR2'/","<207>",$alg);   $alg = preg_replace("/TUL TDR'/","<208>",$alg);   $alg = preg_replace("/TUL2' TDR2/","<205>",$alg);   $alg = preg_replace("/TUL' TDR/","<206>",$alg);
      
      $alg = preg_replace("/TR2 TBL2'/", "<211>",$alg);   $alg = preg_replace("/TR TBL'/", "<212>",$alg);   $alg = preg_replace("/TR2' TBL2/", "<209>",$alg);   $alg = preg_replace("/TR' TBL/", "<210>",$alg);
      $alg = preg_replace("/TL2 TBR2'/", "<215>",$alg);   $alg = preg_replace("/TL TBR'/", "<216>",$alg);   $alg = preg_replace("/TL2' TBR2/", "<213>",$alg);   $alg = preg_replace("/TL' TBR/", "<214>",$alg);
      
      $alg = preg_replace("/TBL2 TR2'/", "<209>",$alg);   $alg = preg_replace("/TBL TR'/", "<210>",$alg);   $alg = preg_replace("/TBL2' TR2/", "<211>",$alg);   $alg = preg_replace("/TBL' TR/", "<212>",$alg);
      $alg = preg_replace("/TBR2 TL2'/", "<213>",$alg);   $alg = preg_replace("/TBR TL'/", "<214>",$alg);   $alg = preg_replace("/TBR2' TL2/", "<215>",$alg);   $alg = preg_replace("/TBR' TL/", "<216>",$alg);
      
      $alg = preg_replace("/TB2 TF2'/",  "<217>",$alg);   $alg = preg_replace("/TB TF'/",  "<218>",$alg);   $alg = preg_replace("/TB2' TF2/",  "<219>",$alg);   $alg = preg_replace("/TB' TF/",  "<220>",$alg);
      $alg = preg_replace("/TF2 TB2'/",  "<219>",$alg);   $alg = preg_replace("/TF TB'/",  "<220>",$alg);   $alg = preg_replace("/TF2' TB2/",  "<217>",$alg);   $alg = preg_replace("/TF' TB/",  "<218>",$alg);
      
      $alg = preg_replace("/TD2 TU2'/",  "<221>",$alg);   $alg = preg_replace("/TD TU'/",  "<222>",$alg);   $alg = preg_replace("/TD2' TU2/",  "<223>",$alg);   $alg = preg_replace("/TD' TU/",  "<224>",$alg);
      $alg = preg_replace("/TU2 TD2'/",  "<223>",$alg);   $alg = preg_replace("/TU TD'/",  "<224>",$alg);   $alg = preg_replace("/TU2' TD2/",  "<221>",$alg);   $alg = preg_replace("/TU' TD/",  "<222>",$alg);
      
      
      /* Non-slice-twists */
      $alg = preg_replace("/UR2' DL2'/","<249>",$alg);   $alg = preg_replace("/UR' DL'/","<250>",$alg);
      $alg = preg_replace("/DL2' UR2'/","<249>",$alg);   $alg = preg_replace("/DL' UR'/","<250>",$alg);
      $alg = preg_replace("/UL2' DR2'/","<251>",$alg);   $alg = preg_replace("/UL' DR'/","<252>",$alg);
      $alg = preg_replace("/DR2' UL2'/","<251>",$alg);   $alg = preg_replace("/DR' UL'/","<252>",$alg);
      $alg = preg_replace("/L2' BR2'/", "<255>",$alg);   $alg = preg_replace("/L' BR'/", "<256>",$alg);
      $alg = preg_replace("/R2' BL2'/", "<253>",$alg);   $alg = preg_replace("/R' BL'/", "<254>",$alg);
      
      $alg = preg_replace("/BR2' L2'/", "<255>",$alg);   $alg = preg_replace("/BR' L'/", "<256>",$alg);
      $alg = preg_replace("/BL2' R2'/", "<253>",$alg);   $alg = preg_replace("/BL' R'/", "<254>",$alg);
      $alg = preg_replace("/F2' B2'/",  "<257>",$alg);   $alg = preg_replace("/F' B'/",  "<258>",$alg);
      $alg = preg_replace("/B2' F2'/",  "<257>",$alg);   $alg = preg_replace("/B' F'/",  "<258>",$alg);
      $alg = preg_replace("/U2' D2'/",  "<259>",$alg);   $alg = preg_replace("/U' D'/",  "<260>",$alg);
      $alg = preg_replace("/D2' U2'/",  "<259>",$alg);   $alg = preg_replace("/D' U'/",  "<260>",$alg);
      
      /* S = S2-4 */
      $alg = preg_replace("/DL2 UR2'/","<225>",$alg);   $alg = preg_replace("/DL UR'/","<226>",$alg);   $alg = preg_replace("/DL2' UR2/","<227>",$alg);   $alg = preg_replace("/DL' UR/","<228>",$alg);
      $alg = preg_replace("/UR2 DL2'/","<227>",$alg);   $alg = preg_replace("/UR DL'/","<228>",$alg);   $alg = preg_replace("/UR2' DL2/","<225>",$alg);   $alg = preg_replace("/UR' DL/","<226>",$alg);
      
      $alg = preg_replace("/DR2 UL2'/","<229>",$alg);   $alg = preg_replace("/DR UL'/","<230>",$alg);   $alg = preg_replace("/DR2' UL2/","<231>",$alg);   $alg = preg_replace("/DR' UL/","<232>",$alg);
      $alg = preg_replace("/UL2 DR2'/","<231>",$alg);   $alg = preg_replace("/UL DR'/","<232>",$alg);   $alg = preg_replace("/UL2' DR2/","<229>",$alg);   $alg = preg_replace("/UL' DR/","<230>",$alg);
      
      $alg = preg_replace("/R2 BL2'/", "<235>",$alg);   $alg = preg_replace("/R BL'/", "<236>",$alg);   $alg = preg_replace("/R2' BL2/", "<233>",$alg);   $alg = preg_replace("/R' BL/", "<234>",$alg);
      $alg = preg_replace("/L2 BR2'/", "<239>",$alg);   $alg = preg_replace("/L BR'/", "<240>",$alg);   $alg = preg_replace("/L2' BR2/", "<237>",$alg);   $alg = preg_replace("/L' BR/", "<238>",$alg);
      
      $alg = preg_replace("/BL2 R2'/", "<233>",$alg);   $alg = preg_replace("/BL R'/", "<234>",$alg);   $alg = preg_replace("/BL2' R2/", "<235>",$alg);   $alg = preg_replace("/BL' R/", "<236>",$alg);
      $alg = preg_replace("/BR2 L2'/", "<237>",$alg);   $alg = preg_replace("/BR L'/", "<238>",$alg);   $alg = preg_replace("/BR2' L2/", "<239>",$alg);   $alg = preg_replace("/BR' L/", "<240>",$alg);
      
      $alg = preg_replace("/B2 F2'/",  "<241>",$alg);   $alg = preg_replace("/B F'/",  "<242>",$alg);   $alg = preg_replace("/B2' F2/",  "<243>",$alg);   $alg = preg_replace("/B' F/",  "<244>",$alg);
      $alg = preg_replace("/F2 B2'/",  "<243>",$alg);   $alg = preg_replace("/F B'/",  "<244>",$alg);   $alg = preg_replace("/F2' B2/",  "<241>",$alg);   $alg = preg_replace("/F' B/",  "<242>",$alg);
      
      $alg = preg_replace("/D2 U2'/",  "<245>",$alg);   $alg = preg_replace("/D U'/",  "<246>",$alg);   $alg = preg_replace("/D2' U2/",  "<247>",$alg);   $alg = preg_replace("/D' U/",  "<248>",$alg);
      $alg = preg_replace("/U2 D2'/",  "<247>",$alg);   $alg = preg_replace("/U D'/",  "<248>",$alg);   $alg = preg_replace("/U2' D2/",  "<245>",$alg);   $alg = preg_replace("/U' D/",  "<246>",$alg);
      
      /* S2-2 | S4-4 */
      
      /* S2-3 | S3-4 */
    }
    
    /* ··································································································· */
    /* --- 5xD: CODE -> SSE opt: [2] Slice twists --- */
    if ($optSSE == true) {
/* xxx   xxx */
      //<s> /* S2 = S3-3 */
      $alg = preg_replace("/<201>/","S2UR2'",$alg);   $alg = preg_replace("/<202>/","S2UR'",$alg);   $alg = preg_replace("/<203>/","S2UR2",$alg);   $alg = preg_replace("/<204>/","S2UR",$alg);
      $alg = preg_replace("/<205>/","S2UL2'",$alg);   $alg = preg_replace("/<206>/","S2UL'",$alg);   $alg = preg_replace("/<207>/","S2UL2",$alg);   $alg = preg_replace("/<208>/","S2UL",$alg);
      
      $alg = preg_replace("/<213>/","S2L2'", $alg);   $alg = preg_replace("/<214>/","S2L'", $alg);   $alg = preg_replace("/<215>/","S2L2", $alg);   $alg = preg_replace("/<216>/","S2L", $alg);
      $alg = preg_replace("/<209>/","S2R2'", $alg);   $alg = preg_replace("/<210>/","S2R'", $alg);   $alg = preg_replace("/<211>/","S2R2", $alg);   $alg = preg_replace("/<212>/","S2R", $alg);
      $alg = preg_replace("/<217>/","S2F2'", $alg);   $alg = preg_replace("/<218>/","S2F'", $alg);   $alg = preg_replace("/<219>/","S2F2", $alg);   $alg = preg_replace("/<220>/","S2F", $alg);
      $alg = preg_replace("/<221>/","S2U2'", $alg);   $alg = preg_replace("/<222>/","S2U'", $alg);   $alg = preg_replace("/<223>/","S2U2", $alg);   $alg = preg_replace("/<224>/","S2U", $alg);
      
      
      /* Non-slice-twists */
      $alg = preg_replace("/<249>/","UR2' DL2'",$alg);   $alg = preg_replace("/<250>/","UR' DL'",$alg);
      $alg = preg_replace("/<251>/","UL2' DR2'",$alg);   $alg = preg_replace("/<252>/","UL' DR'",$alg);
      
      $alg = preg_replace("/<255>/","L2' BR2'", $alg);   $alg = preg_replace("/<256>/","L' BR'", $alg);
      $alg = preg_replace("/<253>/","R2' BL2'", $alg);   $alg = preg_replace("/<254>/","R' BL'", $alg);
      $alg = preg_replace("/<257>/","F2' B2'", $alg);    $alg = preg_replace("/<258>/","F' B'", $alg);
      $alg = preg_replace("/<259>/","U2' D2'", $alg);    $alg = preg_replace("/<260>/","U' D'", $alg);
      
      //<s> /* S = S2-4 */
      $alg = preg_replace("/<225>/","SUR2'",$alg);   $alg = preg_replace("/<226>/","SUR'",$alg);   $alg = preg_replace("/<227>/","SUR2",$alg);   $alg = preg_replace("/<228>/","SUR",$alg);
      $alg = preg_replace("/<229>/","SUL2'",$alg);   $alg = preg_replace("/<230>/","SUL'",$alg);   $alg = preg_replace("/<231>/","SUL2",$alg);   $alg = preg_replace("/<232>/","SUL",$alg);
      
      $alg = preg_replace("/<237>/","SL2'", $alg);   $alg = preg_replace("/<238>/","SL'", $alg);   $alg = preg_replace("/<239>/","SL2", $alg);   $alg = preg_replace("/<240>/","SL", $alg);
      $alg = preg_replace("/<233>/","SR2'", $alg);   $alg = preg_replace("/<234>/","SR'", $alg);   $alg = preg_replace("/<235>/","SR2", $alg);   $alg = preg_replace("/<236>/","SR", $alg);
      $alg = preg_replace("/<241>/","SF2'", $alg);   $alg = preg_replace("/<242>/","SF'", $alg);   $alg = preg_replace("/<243>/","SF2", $alg);   $alg = preg_replace("/<244>/","SF", $alg);
      $alg = preg_replace("/<245>/","SU2'", $alg);   $alg = preg_replace("/<246>/","SU'", $alg);   $alg = preg_replace("/<247>/","SU2", $alg);   $alg = preg_replace("/<248>/","SU", $alg);
      
      /* S2-2 | S4-4 */
      
      /* S2-3 | S3-4 */
    }
    
    /* *************************************************************************************************** */
    /* --- Second Pass: Clean up --- */
    if ($optSSE == true) {
      $alg = preg_replace("'  *'",' ',$alg); // Überflüssige Leerzeichen entfernen
      
      $alg = preg_replace("/\( /","(",$alg); // Replace "( " with "("
      $alg = preg_replace("/ \)/",")",$alg); // Replace " )" with ")"
      
      $alg = preg_replace("/\[ /","[",$alg); // Replace "[ " with "["
      $alg = preg_replace("/ \]/","]",$alg); // Replace " ]" with "]"
    }
    
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
  
  
  
  
  /* 
  ---------------------------------------------------------------------------------------------------
  * parToTwisterLink($param)
  * 
  * Converts parameter into Link parameter.
  * 
  * Parameter: $param (STRING): The parameter.
  * 
  * Return: STRING.
  ---------------------------------------------------------------------------------------------------
  */
  function parToTwisterLink($param) {
    
    $paramLink = "";
    
    $paramLink = preg_replace("'^\s+'",'',$param);        // Leerzeichen am Anfang des Strings entfernen
    $paramLink = preg_replace("'\s+$'",'',$paramLink);    // Leerzeichen am Schluss des Strings entfernen
    $paramLink = preg_replace("'  *'"," ",$paramLink);    // Überflüssige Leerzeichen entfernen.
  
    // Übersetzt folgende Zeichen nicht korrekt?!: [!] %21, [#] %23, [$] %24.
    $a = array("!",   "#",   "$",   "%",   "&",   "'",   "(",   ")",   "*",   "+",   ",",   "/",   ":",   ";",   "=",   "?",   "@",   "[",   "]");
    $b = array("%21", "%23", "%24", "%25", "%26", "%27", "%28", "%29", "%2A", "%2B", "%2C", "%2F", "%3A", "%3B", "%3D", "%3F", "%40", "%5B", "%5D");
    $paramLink = str_replace($a, $b, $paramLink);
    
    $paramLink = preg_replace("/\t/","",$paramLink);      // [\t] Tabulator entfernen.
    $paramLink = preg_replace("/\r\n/","",$paramLink);    // [\r\n] Zeilenschaltung entfernen.
    $paramLink = preg_replace("/\n/","",$paramLink);      // [\n] Zeilenschaltung entfernen.
    
    $paramLink = preg_replace("/ /","%20",$paramLink);    // [ ] Leerzeichen durch [%20] Leerzeichen ersetzen.
    
    return $paramLink;
  }
    
?>
