<?php 
  
  
  
  /* --------------------------------------------------------------------------------------------------- */
  // Twizzle Twister
  // 
  // 
  /* --------------------------------------------------------------------------------------------------- */
  
  /* --- Preferenzen --- */
  $debugmode         = false; // true  = Zeigt Test-Werte.
                              // false = Zeigt keine Test-Werte (Default).
  
  
  
  
  /* --- Variabeln --- */
  $cgiFile           = "index_v000-001-003.php"; // Name dieses CGIs.
  $cgiVersion        = "0.1.3"; // CGI-Version.
  
  $tw_homepage       = "experiments.cubing.net/cubing.js/twizzle/"; // Twizzle Explorer Homepage
  
  $cssDir            = "styles/css";
  $cssFile           = "tw-design.css";
  
  
  
  /* --- Arrays --- */
  $puz_list = [
    // Pyraminx
    "1" => "3x3 Pyraminx", 
    "2" => "4x4 Master Pyraminx", 
    "3" => "5x5 Professor Pyraminx", 
    // Dodecaheder
    "4" => "3x3 Megaminx", 
    "5" => "5x5 Gigaminx"
  ];
  
  $puz_param = [ // Twizzle Explorer: puzzle parameter
    // Pyraminx
    "1" => "pyraminx", 
    "2" => "master+pyraminx", 
    "3" => "professor+pyraminx", 
    // Dodecaheder
    "4" => "megaminx", 
    "5" => "gigaminx"
  ];
  
  $notation = [
    "sse"  => "SSE", 
    "sign" => "Twizzle"
  ];
  
  
  
  
  
  
  
  
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
  * alg3xP_SSEToSiGN()$alg)
  * 
  * Converts 3x3 Pyraminx SSE algorithms into SiGN notation.
  * 
  * Parameter: $alg (STRING): The algorithm.
  * 
  * Return: STRING.
  ---------------------------------------------------------------------------------------------------
  */
  function alg3xP_SSEToSiGN($alg) {
    /* --- 3x: Normalize SSE inversion --- */
    $alg = str_replace("-","'",$alg); // Only if hypen (-) ist not used in algorithm tokens!
    
    /* --- 3x: Marker --- */
    $alg = str_replace("·",".",$alg);
    
    /* ··································································································· */
    /* --- 3xP: SSE -> CODE: (Wide) Mid-layer twists --- */
    $alg = preg_replace("/MU'/","<101>",$alg); $alg = preg_replace("/MU/","<102>",$alg);
    $alg = preg_replace("/MR'/","<103>",$alg); $alg = preg_replace("/MR/","<104>",$alg);
    $alg = preg_replace("/ML'/","<105>",$alg); $alg = preg_replace("/ML/","<106>",$alg);
    $alg = preg_replace("/MB'/","<107>",$alg); $alg = preg_replace("/MB/","<108>",$alg);
    
    $alg = preg_replace("/NU'/","<101>",$alg); $alg = preg_replace("/NU/","<102>",$alg);
    $alg = preg_replace("/NR'/","<103>",$alg); $alg = preg_replace("/NR/","<104>",$alg);
    $alg = preg_replace("/NL'/","<105>",$alg); $alg = preg_replace("/NL/","<106>",$alg);
    $alg = preg_replace("/NB'/","<107>",$alg); $alg = preg_replace("/NB/","<108>",$alg);
    
    $alg = preg_replace("/WU'/","<101>",$alg); $alg = preg_replace("/WU/","<102>",$alg);
    $alg = preg_replace("/WR'/","<103>",$alg); $alg = preg_replace("/WR/","<104>",$alg);
    $alg = preg_replace("/WL'/","<105>",$alg); $alg = preg_replace("/WL/","<106>",$alg);
    $alg = preg_replace("/WB'/","<107>",$alg); $alg = preg_replace("/WB/","<108>",$alg);
    
    /* --- 3xP: SSE -> CODE: Numbered layer twists --- */
    
    /* --- 3xP: SSE -> CODE: Tier twists --- */
    $alg = preg_replace("/TU'/","<301>",$alg); $alg = preg_replace("/TU/","<302>",$alg);
    $alg = preg_replace("/TR'/","<303>",$alg); $alg = preg_replace("/TR/","<304>",$alg);
    $alg = preg_replace("/TL'/","<305>",$alg); $alg = preg_replace("/TL/","<306>",$alg);
    $alg = preg_replace("/TB'/","<307>",$alg); $alg = preg_replace("/TB/","<308>",$alg);
    
    /* --- 3xP: SSE -> CODE: Pyramid rotations --- */
    $alg = preg_replace("/CU'/","<401>",$alg); $alg = preg_replace("/CU/","<402>",$alg);
    $alg = preg_replace("/CR'/","<403>",$alg); $alg = preg_replace("/CR/","<404>",$alg);
    $alg = preg_replace("/CL'/","<405>",$alg); $alg = preg_replace("/CL/","<406>",$alg);
    $alg = preg_replace("/CB'/","<407>",$alg); $alg = preg_replace("/CB/","<408>",$alg);
    
    /* --- 3xP: SSE -> CODE: Corner twists --- */
    $alg = preg_replace("/U'/","<901>",$alg); $alg = preg_replace("/U/","<902>",$alg);
    $alg = preg_replace("/R'/","<903>",$alg); $alg = preg_replace("/R/","<904>",$alg);
    $alg = preg_replace("/L'/","<905>",$alg); $alg = preg_replace("/L/","<906>",$alg);
    $alg = preg_replace("/B'/","<907>",$alg); $alg = preg_replace("/B/","<908>",$alg);
    
    /* ··································································································· */
    /* --- 3xP: CODE -> SiGN: (Wide) Mid-layer twists --- */
    $alg = preg_replace("/<101>/","2D",$alg); $alg = preg_replace("/<102>/","2D'",$alg);
    $alg = preg_replace("/<103>/","2L",$alg); $alg = preg_replace("/<104>/","2L'",$alg);
    $alg = preg_replace("/<105>/","2R",$alg); $alg = preg_replace("/<106>/","2R'",$alg);
    $alg = preg_replace("/<107>/","2F",$alg); $alg = preg_replace("/<108>/","2F'",$alg);
    
    /* --- 3xP: CODE -> SIGN: Numbered layer twists --- */
    
    /* --- 3xP: CODE -> SiGN: Tier twists --- */
    $alg = preg_replace("/<301>/","flr'",$alg); $alg = preg_replace("/<302>/","flr",$alg);
    $alg = preg_replace("/<303>/","frd'",$alg); $alg = preg_replace("/<304>/","frd",$alg);
    $alg = preg_replace("/<305>/","fdl'",$alg); $alg = preg_replace("/<306>/","fdl",$alg);
    $alg = preg_replace("/<307>/","drl'",$alg); $alg = preg_replace("/<308>/","drl",$alg);
    
    /* --- 3xP: CODE -> SiGN: Pyramid rotations --- */
    $alg = preg_replace("/<401>/","Dv",$alg); $alg = preg_replace("/<402>/","Dv'",$alg);
    $alg = preg_replace("/<403>/","Lv",$alg); $alg = preg_replace("/<404>/","Lv'",$alg);
    $alg = preg_replace("/<405>/","Rv",$alg); $alg = preg_replace("/<406>/","Rv'",$alg);
    $alg = preg_replace("/<407>/","Fv",$alg); $alg = preg_replace("/<408>/","Fv'",$alg);
    
    /* --- 3xP: CODE -> SiGN: Corner twists --- */
    $alg = preg_replace("/<901>/","3D",$alg); $alg = preg_replace("/<902>/","3D'",$alg);
    $alg = preg_replace("/<903>/","3L",$alg); $alg = preg_replace("/<904>/","3L'",$alg);
    $alg = preg_replace("/<905>/","3R",$alg); $alg = preg_replace("/<906>/","3R'",$alg);
    $alg = preg_replace("/<907>/","3F",$alg); $alg = preg_replace("/<908>/","3F'",$alg);
    
    return $alg;
  }
  
  
  
  
  /* 
  ---------------------------------------------------------------------------------------------------
  * alg3xP_SiGNToSSE()$alg)
  * 
  * Converts 3x3 Pyraminx SiGN algorithms into SSE notation.
  * 
  * Parameter: $alg (STRING): The algorithm.
  * 
  * Return: STRING.
  ---------------------------------------------------------------------------------------------------
  */
  function alg3xP_SiGNToSSE($alg) {
    /* --- 3x: Marker --- */
    $alg = str_replace(".","·",$alg);
    
    /* ··································································································· */
    /* --- 3xP: SiGN -> CODE: Tier twists --- */
    $alg = preg_replace("/2-3D'/","<301>",$alg); $alg = preg_replace("/2-3D/","<302>",$alg);
    $alg = preg_replace("/2-3L'/","<303>",$alg); $alg = preg_replace("/2-3L/","<304>",$alg);
    $alg = preg_replace("/2-3R'/","<305>",$alg); $alg = preg_replace("/2-3R/","<306>",$alg);
    $alg = preg_replace("/2-3F'/","<307>",$alg); $alg = preg_replace("/2-3F/","<308>",$alg);
    
    /* --- 3xP: SiGN -> CODE: (Wide) Mid-layer twists --- */
    $alg = preg_replace("/2D'/","<101>",$alg); $alg = preg_replace("/2D/","<102>",$alg);
    $alg = preg_replace("/2L'/","<103>",$alg); $alg = preg_replace("/2L/","<104>",$alg);
    $alg = preg_replace("/2R'/","<105>",$alg); $alg = preg_replace("/2R/","<106>",$alg);
    $alg = preg_replace("/2F'/","<107>",$alg); $alg = preg_replace("/2F/","<108>",$alg);
    
    /* --- 3xP: SIGN -> CODE: Numbered layer twists --- */
    
    /* --- 3xP: SiGN -> CODE: Tier twists --- */
    $alg = preg_replace("/flr'/","<301>",$alg); $alg = preg_replace("/flr/","<302>",$alg);   $alg = preg_replace("/rfl'/","<301>",$alg); $alg = preg_replace("/rfl/","<302>",$alg);   $alg = preg_replace("/lrf'/","<301>",$alg); $alg = preg_replace("/lrf/","<302>",$alg);
    $alg = preg_replace("/frd'/","<303>",$alg); $alg = preg_replace("/frd/","<304>",$alg);   $alg = preg_replace("/dfr'/","<303>",$alg); $alg = preg_replace("/dfr/","<304>",$alg);   $alg = preg_replace("/rdf'/","<303>",$alg); $alg = preg_replace("/rdf/","<304>",$alg);
    $alg = preg_replace("/fdl'/","<305>",$alg); $alg = preg_replace("/fdl/","<306>",$alg);   $alg = preg_replace("/lfd'/","<305>",$alg); $alg = preg_replace("/lfd/","<306>",$alg);   $alg = preg_replace("/dlf'/","<305>",$alg); $alg = preg_replace("/dlf/","<306>",$alg);
    $alg = preg_replace("/drl'/","<307>",$alg); $alg = preg_replace("/drl/","<308>",$alg);   $alg = preg_replace("/ldr'/","<307>",$alg); $alg = preg_replace("/ldr/","<308>",$alg);   $alg = preg_replace("/rld'/","<307>",$alg); $alg = preg_replace("/rld/","<308>",$alg);
    
    /* --- 3xP: SiGN -> CODE: Pyramid rotations --- */
    $alg = preg_replace("/Dv'/","<401>",$alg); $alg = preg_replace("/Dv/","<402>",$alg);
    $alg = preg_replace("/Lv'/","<403>",$alg); $alg = preg_replace("/Lv/","<404>",$alg);
    $alg = preg_replace("/Rv'/","<405>",$alg); $alg = preg_replace("/Rv/","<406>",$alg);
    $alg = preg_replace("/Fv'/","<407>",$alg); $alg = preg_replace("/Fv/","<408>",$alg);
    
    /* --- 3xP: SiGN -> CODE: Face twists --- */
    $alg = preg_replace("/D'/","<501>",$alg); $alg = preg_replace("/D/","<502>",$alg);
    $alg = preg_replace("/L'/","<503>",$alg); $alg = preg_replace("/L/","<504>",$alg);
    $alg = preg_replace("/R'/","<505>",$alg); $alg = preg_replace("/R/","<506>",$alg);
    $alg = preg_replace("/F'/","<507>",$alg); $alg = preg_replace("/F/","<508>",$alg);
    
    /* ··································································································· */
    /* --- 3xP: CODE -> SiGN: (Wide) M-layer twists --- */
    $alg = preg_replace("/<101>/","MU",$alg); $alg = preg_replace("/<102>/","MU'",$alg);
    $alg = preg_replace("/<103>/","MR",$alg); $alg = preg_replace("/<104>/","MR'",$alg);
    $alg = preg_replace("/<105>/","ML",$alg); $alg = preg_replace("/<106>/","ML'",$alg);
    $alg = preg_replace("/<107>/","MB",$alg); $alg = preg_replace("/<108>/","MB'",$alg);
    
    /* --- 3xP: CODE -> SSE: Numbered layer twists --- */
    
    /* --- 3xP: CODE -> SSE: Tier twists --- */
    $alg = preg_replace("/<301>/","TU'",$alg); $alg = preg_replace("/<302>/","TU",$alg);
    $alg = preg_replace("/<303>/","TR'",$alg); $alg = preg_replace("/<304>/","TR",$alg);
    $alg = preg_replace("/<305>/","TL'",$alg); $alg = preg_replace("/<306>/","TL",$alg);
    $alg = preg_replace("/<307>/","TB'",$alg); $alg = preg_replace("/<308>/","TB",$alg);
    
    /* --- 3xP: CODE -> SSE: Pyramid rotations --- */
    $alg = preg_replace("/<401>/","CU",$alg); $alg = preg_replace("/<402>/","CU'",$alg);
    $alg = preg_replace("/<403>/","CR",$alg); $alg = preg_replace("/<404>/","CR'",$alg);
    $alg = preg_replace("/<405>/","CL",$alg); $alg = preg_replace("/<406>/","CL'",$alg);
    $alg = preg_replace("/<407>/","CB",$alg); $alg = preg_replace("/<408>/","CB'",$alg);
    
    /* --- 3xP: CODE -> SSE: Face twists --- */
    $alg = preg_replace("/<501>/","TU' CU",$alg); $alg = preg_replace("/<502>/","TU CU'",$alg);
    $alg = preg_replace("/<503>/","TR' CR",$alg); $alg = preg_replace("/<504>/","TR CR'",$alg);
    $alg = preg_replace("/<505>/","TL' CL",$alg); $alg = preg_replace("/<506>/","TL CL'",$alg);
    $alg = preg_replace("/<507>/","TB' CB",$alg); $alg = preg_replace("/<508>/","TB CB'",$alg);
    
    return $alg;
  }
  
  
  
  
  /* 
  ---------------------------------------------------------------------------------------------------
  * alg4xP_SSEToSiGN()$alg)
  * 
  * Converts 4x4 Master Pyraminx SSE algorithms into SiGN notation.
  * 
  * Parameter: $alg (STRING): The algorithm.
  * 
  * Return: STRING.
  ---------------------------------------------------------------------------------------------------
  */
  function alg4xP_SSEToSiGN($alg) {
    /* --- 4x: Normalize SSE inversion --- */
    $alg = str_replace("-","'",$alg); // Only if hypen (-) ist not used in algorithm tokens!
    
    /* --- 4x: Marker --- */
    $alg = str_replace("·",".",$alg);
    
    /* ··································································································· */
    /* --- 4xP: SSE -> CODE: Wide-layer twists --- */
    $alg = preg_replace("/WU'/","<101>",$alg); $alg = preg_replace("/WU/","<102>",$alg);
    $alg = preg_replace("/WR'/","<103>",$alg); $alg = preg_replace("/WR/","<104>",$alg);
    $alg = preg_replace("/WL'/","<105>",$alg); $alg = preg_replace("/WL/","<106>",$alg);
    $alg = preg_replace("/WB'/","<107>",$alg); $alg = preg_replace("/WB/","<108>",$alg);
    
    $alg = preg_replace("/N2-3U'/","<101>",$alg); $alg = preg_replace("/N2-3U/","<102>",$alg);
    $alg = preg_replace("/N2-3R'/","<103>",$alg); $alg = preg_replace("/N2-3R/","<104>",$alg);
    $alg = preg_replace("/N2-3L'/","<105>",$alg); $alg = preg_replace("/N2-3L/","<106>",$alg);
    $alg = preg_replace("/N2-3B'/","<107>",$alg); $alg = preg_replace("/N2-3B/","<108>",$alg);
    
    $alg = preg_replace("/VU'/","<101>",$alg); $alg = preg_replace("/VU/","<102>",$alg);
    $alg = preg_replace("/VR'/","<103>",$alg); $alg = preg_replace("/VR/","<104>",$alg);
    $alg = preg_replace("/VL'/","<105>",$alg); $alg = preg_replace("/VL/","<106>",$alg);
    $alg = preg_replace("/VB'/","<107>",$alg); $alg = preg_replace("/VB/","<108>",$alg);
    
    /* --- 4xP: SSE -> CODE: Numbered layer twists --- */
    $alg = preg_replace("/N3U'/","<201>",$alg); $alg = preg_replace("/N3U/","<202>",$alg);
    $alg = preg_replace("/N3R'/","<203>",$alg); $alg = preg_replace("/N3R/","<204>",$alg);
    $alg = preg_replace("/N3L'/","<205>",$alg); $alg = preg_replace("/N3L/","<206>",$alg);
    $alg = preg_replace("/N3B'/","<207>",$alg); $alg = preg_replace("/N3B/","<208>",$alg);
    
    $alg = preg_replace("/NU'/","<209>",$alg); $alg = preg_replace("/NU/","<210>",$alg);
    $alg = preg_replace("/NR'/","<211>",$alg); $alg = preg_replace("/NR/","<212>",$alg);
    $alg = preg_replace("/NL'/","<213>",$alg); $alg = preg_replace("/NL/","<214>",$alg);
    $alg = preg_replace("/NB'/","<215>",$alg); $alg = preg_replace("/NB/","<216>",$alg);
    
    /* --- 4xP: SSE -> CODE: Tier twists --- */
    $alg = preg_replace("/T3U'/","<301>",$alg); $alg = preg_replace("/T3U/","<302>",$alg);
    $alg = preg_replace("/T3R'/","<303>",$alg); $alg = preg_replace("/T3R/","<304>",$alg);
    $alg = preg_replace("/T3L'/","<305>",$alg); $alg = preg_replace("/T3L/","<306>",$alg);
    $alg = preg_replace("/T3B'/","<307>",$alg); $alg = preg_replace("/T3B/","<308>",$alg);
    
    $alg = preg_replace("/TU'/","<309>",$alg); $alg = preg_replace("/TU/","<310>",$alg);
    $alg = preg_replace("/TR'/","<311>",$alg); $alg = preg_replace("/TR/","<312>",$alg);
    $alg = preg_replace("/TL'/","<313>",$alg); $alg = preg_replace("/TL/","<314>",$alg);
    $alg = preg_replace("/TB'/","<315>",$alg); $alg = preg_replace("/TB/","<316>",$alg);
    
    /* --- 4xP: SSE -> CODE: Pyramid rotations --- */
    $alg = preg_replace("/CU'/","<401>",$alg); $alg = preg_replace("/CU/","<402>",$alg);
    $alg = preg_replace("/CR'/","<403>",$alg); $alg = preg_replace("/CR/","<404>",$alg);
    $alg = preg_replace("/CL'/","<405>",$alg); $alg = preg_replace("/CL/","<406>",$alg);
    $alg = preg_replace("/CB'/","<407>",$alg); $alg = preg_replace("/CB/","<408>",$alg);
    
    /* --- 4xP: SSE -> CODE: Corner twists --- */
    $alg = preg_replace("/U'/","<901>",$alg); $alg = preg_replace("/U/","<902>",$alg);
    $alg = preg_replace("/R'/","<903>",$alg); $alg = preg_replace("/R/","<904>",$alg);
    $alg = preg_replace("/L'/","<905>",$alg); $alg = preg_replace("/L/","<906>",$alg);
    $alg = preg_replace("/B'/","<907>",$alg); $alg = preg_replace("/B/","<908>",$alg);
    
    /* ··································································································· */
    /* --- 4xP: CODE -> SiGN: Wide-layer twists --- */
    $alg = preg_replace("/<101>/","2-3D",$alg); $alg = preg_replace("/<102>/","2-3D'",$alg);
    $alg = preg_replace("/<103>/","2-3L",$alg); $alg = preg_replace("/<104>/","2-3L'",$alg);
    $alg = preg_replace("/<105>/","2-3R",$alg); $alg = preg_replace("/<106>/","2-3R'",$alg);
    $alg = preg_replace("/<107>/","2-3F",$alg); $alg = preg_replace("/<108>/","2-3F'",$alg);
    
    /* --- 4xP: CODE -> SiGN: Numbered layer twists --- */
    $alg = preg_replace("/<201>/","2D",$alg); $alg = preg_replace("/<202>/","2D'",$alg);
    $alg = preg_replace("/<203>/","2L",$alg); $alg = preg_replace("/<204>/","2L'",$alg);
    $alg = preg_replace("/<205>/","2R",$alg); $alg = preg_replace("/<206>/","2R'",$alg);
    $alg = preg_replace("/<207>/","2F",$alg); $alg = preg_replace("/<208>/","2F'",$alg);
    
    $alg = preg_replace("/<209>/","3D",$alg); $alg = preg_replace("/<210>/","3D'",$alg);
    $alg = preg_replace("/<211>/","3L",$alg); $alg = preg_replace("/<212>/","3L'",$alg);
    $alg = preg_replace("/<213>/","3R",$alg); $alg = preg_replace("/<214>/","3R'",$alg);
    $alg = preg_replace("/<215>/","3F",$alg); $alg = preg_replace("/<216>/","3F'",$alg);
    
    /* --- 4xP: CODE -> SiGN: Tier twists --- */
    $alg = preg_replace("/<301>/","3flr'",$alg); $alg = preg_replace("/<302>/","3flr",$alg);
    $alg = preg_replace("/<303>/","3frd'",$alg); $alg = preg_replace("/<304>/","3frd",$alg);
    $alg = preg_replace("/<305>/","3fdl'",$alg); $alg = preg_replace("/<306>/","3fdl",$alg);
    $alg = preg_replace("/<307>/","3drl'",$alg); $alg = preg_replace("/<308>/","3drl",$alg);
    
    $alg = preg_replace("/<309>/","flr'",$alg); $alg = preg_replace("/<310>/","flr",$alg);
    $alg = preg_replace("/<311>/","frd'",$alg); $alg = preg_replace("/<312>/","frd",$alg);
    $alg = preg_replace("/<313>/","fdl'",$alg); $alg = preg_replace("/<314>/","fdl",$alg);
    $alg = preg_replace("/<315>/","drl'",$alg); $alg = preg_replace("/<316>/","drl",$alg);
    
    /* --- 4xP: CODE -> SiGN: Pyramid rotations --- */
    $alg = preg_replace("/<401>/","Dv",$alg); $alg = preg_replace("/<402>/","Dv'",$alg);
    $alg = preg_replace("/<403>/","Lv",$alg); $alg = preg_replace("/<404>/","Lv'",$alg);
    $alg = preg_replace("/<405>/","Rv",$alg); $alg = preg_replace("/<406>/","Rv'",$alg);
    $alg = preg_replace("/<407>/","Fv",$alg); $alg = preg_replace("/<408>/","Fv'",$alg);
    
    /* --- 4xP: CODE -> SiGN: Corner twists --- */
    $alg = preg_replace("/<901>/","4D",$alg); $alg = preg_replace("/<902>/","4D'",$alg);
    $alg = preg_replace("/<903>/","4L",$alg); $alg = preg_replace("/<904>/","4L'",$alg);
    $alg = preg_replace("/<905>/","4R",$alg); $alg = preg_replace("/<906>/","4R'",$alg);
    $alg = preg_replace("/<907>/","4F",$alg); $alg = preg_replace("/<908>/","4F'",$alg);
    
    return $alg;
  }
  
  
  
  
  /* 
  ---------------------------------------------------------------------------------------------------
  * alg4xP_SiGNToSSE()$alg)
  * 
  * Converts 4x4 Master Pyraminx SiGN algorithms into SSE notation.
  * 
  * Parameter: $alg (STRING): The algorithm.
  * 
  * Return: STRING.
  ---------------------------------------------------------------------------------------------------
  */
  function alg4xP_SiGNToSSE($alg) {
    /* --- 4x: Marker --- */
    $alg = str_replace(".","·",$alg);
    
    /* ··································································································· */
    /* --- 4xP: SiGN -> CODE: Wide-layer twists --- */
    $alg = preg_replace("/2-3D'/","<101>",$alg); $alg = preg_replace("/2-3D/","<102>",$alg);
    $alg = preg_replace("/2-3L'/","<103>",$alg); $alg = preg_replace("/2-3L/","<104>",$alg);
    $alg = preg_replace("/2-3R'/","<105>",$alg); $alg = preg_replace("/2-3R/","<106>",$alg);
    $alg = preg_replace("/2-3F'/","<107>",$alg); $alg = preg_replace("/2-3F/","<108>",$alg);
    
    /* --- 4xP: SiGN -> CODE: Tier twists --- */
    $alg = preg_replace("/2-4D'/","<301>",$alg); $alg = preg_replace("/2-4D/","<302>",$alg);
    $alg = preg_replace("/2-4L'/","<303>",$alg); $alg = preg_replace("/2-4L/","<304>",$alg);
    $alg = preg_replace("/2-4R'/","<305>",$alg); $alg = preg_replace("/2-4R/","<306>",$alg);
    $alg = preg_replace("/2-4F'/","<307>",$alg); $alg = preg_replace("/2-4F/","<308>",$alg);
    
    $alg = preg_replace("/3-4D'/","<309>",$alg); $alg = preg_replace("/3-4D/","<310>",$alg);
    $alg = preg_replace("/3-4L'/","<311>",$alg); $alg = preg_replace("/3-4L/","<312>",$alg);
    $alg = preg_replace("/3-4R'/","<313>",$alg); $alg = preg_replace("/3-4R/","<314>",$alg);
    $alg = preg_replace("/3-4F'/","<315>",$alg); $alg = preg_replace("/3-4F/","<316>",$alg);
    
    /* --- 4xP: SIGN -> CODE: Numbered layer twists --- */
    $alg = preg_replace("/2D'/","<201>",$alg); $alg = preg_replace("/2D/","<202>",$alg);
    $alg = preg_replace("/2L'/","<203>",$alg); $alg = preg_replace("/2L/","<204>",$alg);
    $alg = preg_replace("/2R'/","<205>",$alg); $alg = preg_replace("/2R/","<206>",$alg);
    $alg = preg_replace("/2F'/","<207>",$alg); $alg = preg_replace("/2F/","<208>",$alg);
    
    $alg = preg_replace("/3D'/","<209>",$alg); $alg = preg_replace("/3D/","<210>",$alg);
    $alg = preg_replace("/3L'/","<211>",$alg); $alg = preg_replace("/3L/","<212>",$alg);
    $alg = preg_replace("/3R'/","<213>",$alg); $alg = preg_replace("/3R/","<214>",$alg);
    $alg = preg_replace("/3F'/","<215>",$alg); $alg = preg_replace("/3F/","<216>",$alg);
    
    /* --- 4xP: SiGN -> CODE: Corner twists --- */
    $alg = preg_replace("/4D'/","<901>",$alg); $alg = preg_replace("/4D/","<902>",$alg);
    $alg = preg_replace("/4L'/","<903>",$alg); $alg = preg_replace("/4L/","<904>",$alg);
    $alg = preg_replace("/4R'/","<905>",$alg); $alg = preg_replace("/4R/","<906>",$alg);
    $alg = preg_replace("/4F'/","<907>",$alg); $alg = preg_replace("/4F/","<908>",$alg);
    
    /* --- 4xP: SiGN -> CODE: Tier twists --- */
    $alg = preg_replace("/3flr'/","<301>",$alg); $alg = preg_replace("/3flr/","<302>",$alg);   $alg = preg_replace("/3rfl'/","<301>",$alg); $alg = preg_replace("/3rfl/","<302>",$alg);   $alg = preg_replace("/3lrf'/","<301>",$alg); $alg = preg_replace("/3lrf/","<302>",$alg);
    $alg = preg_replace("/3frd'/","<303>",$alg); $alg = preg_replace("/3frd/","<304>",$alg);   $alg = preg_replace("/3dfr'/","<303>",$alg); $alg = preg_replace("/3dfr/","<304>",$alg);   $alg = preg_replace("/3rdf'/","<303>",$alg); $alg = preg_replace("/3rdf/","<304>",$alg);
    $alg = preg_replace("/3fdl'/","<305>",$alg); $alg = preg_replace("/3fdl/","<306>",$alg);   $alg = preg_replace("/3lfd'/","<305>",$alg); $alg = preg_replace("/3lfd/","<306>",$alg);   $alg = preg_replace("/3dlf'/","<305>",$alg); $alg = preg_replace("/3dlf/","<306>",$alg);
    $alg = preg_replace("/3drl'/","<307>",$alg); $alg = preg_replace("/3drl/","<308>",$alg);   $alg = preg_replace("/3ldr'/","<307>",$alg); $alg = preg_replace("/3ldr/","<308>",$alg);   $alg = preg_replace("/3rld'/","<307>",$alg); $alg = preg_replace("/3rld/","<308>",$alg);
    
    $alg = preg_replace("/flr'/","<309>",$alg); $alg = preg_replace("/flr/","<310>",$alg);     $alg = preg_replace("/rfl'/","<309>",$alg); $alg = preg_replace("/rfl/","<310>",$alg);     $alg = preg_replace("/lrf'/","<309>",$alg); $alg = preg_replace("/lrf/","<310>",$alg);
    $alg = preg_replace("/frd'/","<311>",$alg); $alg = preg_replace("/frd/","<312>",$alg);     $alg = preg_replace("/dfr'/","<311>",$alg); $alg = preg_replace("/dfr/","<312>",$alg);     $alg = preg_replace("/rdf'/","<311>",$alg); $alg = preg_replace("/rdf/","<312>",$alg);
    $alg = preg_replace("/fdl'/","<313>",$alg); $alg = preg_replace("/fdl/","<314>",$alg);     $alg = preg_replace("/lfd'/","<313>",$alg); $alg = preg_replace("/lfd/","<314>",$alg);     $alg = preg_replace("/dlf'/","<313>",$alg); $alg = preg_replace("/dlf/","<314>",$alg);
    $alg = preg_replace("/drl'/","<315>",$alg); $alg = preg_replace("/drl/","<316>",$alg);     $alg = preg_replace("/ldr'/","<315>",$alg); $alg = preg_replace("/ldr/","<316>",$alg);     $alg = preg_replace("/rld'/","<315>",$alg); $alg = preg_replace("/rld/","<316>",$alg);
    
    /* --- 4xP: SiGN -> CODE: Pyramid rotations --- */
    $alg = preg_replace("/Dv'/","<401>",$alg); $alg = preg_replace("/Dv/","<402>",$alg);
    $alg = preg_replace("/Lv'/","<403>",$alg); $alg = preg_replace("/Lv/","<404>",$alg);
    $alg = preg_replace("/Rv'/","<405>",$alg); $alg = preg_replace("/Rv/","<406>",$alg);
    $alg = preg_replace("/Fv'/","<407>",$alg); $alg = preg_replace("/Fv/","<408>",$alg);
    
    /* --- 4xP: SiGN -> CODE: Face twists --- */
    $alg = preg_replace("/D'/","<501>",$alg); $alg = preg_replace("/D/","<502>",$alg);
    $alg = preg_replace("/L'/","<503>",$alg); $alg = preg_replace("/L/","<504>",$alg);
    $alg = preg_replace("/R'/","<505>",$alg); $alg = preg_replace("/R/","<506>",$alg);
    $alg = preg_replace("/F'/","<507>",$alg); $alg = preg_replace("/F/","<508>",$alg);
    
    /* ··································································································· */
    /* --- 4xP: CODE -> SiGN: Wide-layer twists --- */
    $alg = preg_replace("/<101>/","WU",$alg); $alg = preg_replace("/<102>/","WU'",$alg);
    $alg = preg_replace("/<103>/","WR",$alg); $alg = preg_replace("/<104>/","WR'",$alg);
    $alg = preg_replace("/<105>/","WL",$alg); $alg = preg_replace("/<106>/","WL'",$alg);
    $alg = preg_replace("/<107>/","WB",$alg); $alg = preg_replace("/<108>/","WB'",$alg);
    
    /* --- 4xP: CODE -> SSE: Numbered layer twists --- */
    $alg = preg_replace("/<201>/","N3U",$alg); $alg = preg_replace("/<202>/","N3U'",$alg);
    $alg = preg_replace("/<203>/","N3R",$alg); $alg = preg_replace("/<204>/","N3R'",$alg);
    $alg = preg_replace("/<205>/","N3L",$alg); $alg = preg_replace("/<206>/","N3L'",$alg);
    $alg = preg_replace("/<207>/","N3B",$alg); $alg = preg_replace("/<208>/","N3B'",$alg);
    
    $alg = preg_replace("/<209>/","NU",$alg); $alg = preg_replace("/<210>/","NU'",$alg);
    $alg = preg_replace("/<211>/","NR",$alg); $alg = preg_replace("/<212>/","NR'",$alg);
    $alg = preg_replace("/<213>/","NL",$alg); $alg = preg_replace("/<214>/","NL'",$alg);
    $alg = preg_replace("/<215>/","NB",$alg); $alg = preg_replace("/<216>/","NB'",$alg);
    
    /* --- 4xP: CODE -> SSE: Corner twists --- */
    $alg = preg_replace("/<901>/","U",$alg); $alg = preg_replace("/<902>/","U'",$alg);
    $alg = preg_replace("/<903>/","R",$alg); $alg = preg_replace("/<904>/","R'",$alg);
    $alg = preg_replace("/<905>/","L",$alg); $alg = preg_replace("/<906>/","L'",$alg);
    $alg = preg_replace("/<907>/","B",$alg); $alg = preg_replace("/<908>/","B'",$alg);
    
    /* --- 4xP: CODE -> SSE: Tier twists --- */
    $alg = preg_replace("/<301>/","T3U'",$alg); $alg = preg_replace("/<302>/","T3U",$alg);
    $alg = preg_replace("/<303>/","T3R'",$alg); $alg = preg_replace("/<304>/","T3R",$alg);
    $alg = preg_replace("/<305>/","T3L'",$alg); $alg = preg_replace("/<306>/","T3L",$alg);
    $alg = preg_replace("/<307>/","T3B'",$alg); $alg = preg_replace("/<308>/","T3B",$alg);
    
    $alg = preg_replace("/<309>/","TU'",$alg); $alg = preg_replace("/<310>/","TU",$alg);
    $alg = preg_replace("/<311>/","TR'",$alg); $alg = preg_replace("/<312>/","TR",$alg);
    $alg = preg_replace("/<313>/","TL'",$alg); $alg = preg_replace("/<314>/","TL",$alg);
    $alg = preg_replace("/<315>/","TB'",$alg); $alg = preg_replace("/<316>/","TB",$alg);
    
    /* --- 4xP: CODE -> SSE: Pyramid rotations --- */
    $alg = preg_replace("/<401>/","CU",$alg); $alg = preg_replace("/<402>/","CU'",$alg);
    $alg = preg_replace("/<403>/","CR",$alg); $alg = preg_replace("/<404>/","CR'",$alg);
    $alg = preg_replace("/<405>/","CL",$alg); $alg = preg_replace("/<406>/","CL'",$alg);
    $alg = preg_replace("/<407>/","CB",$alg); $alg = preg_replace("/<408>/","CB'",$alg);
    
    /* --- 4xP: CODE -> SSE: Face twists --- */
    $alg = preg_replace("/<501>/","T3U' CU",$alg); $alg = preg_replace("/<502>/","T3U CU'",$alg);
    $alg = preg_replace("/<503>/","T3R' CR",$alg); $alg = preg_replace("/<504>/","T3R CR'",$alg);
    $alg = preg_replace("/<505>/","T3L' CL",$alg); $alg = preg_replace("/<506>/","T3L CL'",$alg);
    $alg = preg_replace("/<507>/","T3B' CB",$alg); $alg = preg_replace("/<508>/","T3B CB'",$alg);
    
    return $alg;
  }
  
  
  
  
  /* 
  ---------------------------------------------------------------------------------------------------
  * alg5xP_SSEToSiGN()$alg)
  * 
  * Converts 5x5 Professor Pyraminx SSE algorithms into SiGN notation.
  * 
  * Parameter: $alg (STRING): The algorithm.
  * 
  * Return: STRING.
  ---------------------------------------------------------------------------------------------------
  */
  function alg5xP_SSEToSiGN($alg) {
    /* --- 5x: Normalize SSE inversion --- */
    //$alg = str_replace("-","'",$alg); // MUST NOT BE USED!!! Hypen (-) is used in algorithm tokens.
    
    /* --- 5x: Marker --- */
    $alg = str_replace("·",".",$alg);
    
    /* ··································································································· */
    /* --- 5xP: SSE -> CODE: Wide-layer twists --- */
    $alg = preg_replace("/WU'/","<101>",$alg); $alg = preg_replace("/WU-/","<101>",$alg);   $alg = preg_replace("/WU/","<102>",$alg);
    $alg = preg_replace("/WR'/","<103>",$alg); $alg = preg_replace("/WR-/","<103>",$alg);   $alg = preg_replace("/WR/","<104>",$alg);
    $alg = preg_replace("/WL'/","<105>",$alg); $alg = preg_replace("/WL-/","<105>",$alg);   $alg = preg_replace("/WL/","<106>",$alg);
    $alg = preg_replace("/WB'/","<107>",$alg); $alg = preg_replace("/WB-/","<107>",$alg);   $alg = preg_replace("/WB/","<108>",$alg);
    
    $alg = preg_replace("/N2-4U'/","<101>",$alg); $alg = preg_replace("/N2-4U/","<102>",$alg);
    $alg = preg_replace("/N2-4R'/","<103>",$alg); $alg = preg_replace("/N2-4R/","<104>",$alg);
    $alg = preg_replace("/N2-4L'/","<105>",$alg); $alg = preg_replace("/N2-4L/","<106>",$alg);
    $alg = preg_replace("/N2-4B'/","<107>",$alg); $alg = preg_replace("/N2-4B/","<108>",$alg);
    
    /* --- 5xP: SSE -> CODE: Numbered layer twists --- */
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
    
    /* --- 5xP: SSE -> CODE: Tier twists --- */
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
    
    /* --- 5xP: SSE -> CODE: Pyramid rotations --- */
    $alg = preg_replace("/CU'/","<401>",$alg); $alg = preg_replace("/CU-/","<401>",$alg);   $alg = preg_replace("/CU/","<402>",$alg);
    $alg = preg_replace("/CR'/","<403>",$alg); $alg = preg_replace("/CR-/","<403>",$alg);   $alg = preg_replace("/CR/","<404>",$alg);
    $alg = preg_replace("/CL'/","<405>",$alg); $alg = preg_replace("/CL-/","<405>",$alg);   $alg = preg_replace("/CL/","<406>",$alg);
    $alg = preg_replace("/CB'/","<407>",$alg); $alg = preg_replace("/CB-/","<407>",$alg);   $alg = preg_replace("/CB/","<408>",$alg);
    
    /* --- 5xP: SSE -> CODE: Corner twists --- */
    $alg = preg_replace("/U'/","<901>",$alg); $alg = preg_replace("/U/","<902>",$alg);
    $alg = preg_replace("/R'/","<903>",$alg); $alg = preg_replace("/R/","<904>",$alg);
    $alg = preg_replace("/L'/","<905>",$alg); $alg = preg_replace("/L/","<906>",$alg);
    $alg = preg_replace("/B'/","<907>",$alg); $alg = preg_replace("/B/","<908>",$alg);
    
    /* ··································································································· */
    /* --- 5xP: CODE -> SiGN: Wide-layer twists --- */
    $alg = preg_replace("/<101>/","2-4D",$alg); $alg = preg_replace("/<102>/","2-4D'",$alg);
    $alg = preg_replace("/<103>/","2-4L",$alg); $alg = preg_replace("/<104>/","2-4L'",$alg);
    $alg = preg_replace("/<105>/","2-4R",$alg); $alg = preg_replace("/<106>/","2-4R'",$alg);
    $alg = preg_replace("/<107>/","2-4F",$alg); $alg = preg_replace("/<108>/","2-4F'",$alg);
    
    /* --- 5xP: CODE -> SiGN: Numbered layer twists --- */
    $alg = preg_replace("/<201>/","2-3D",$alg); $alg = preg_replace("/<202>/","2-3D'",$alg);
    $alg = preg_replace("/<203>/","2-3L",$alg); $alg = preg_replace("/<204>/","2-3L'",$alg);
    $alg = preg_replace("/<205>/","2-3R",$alg); $alg = preg_replace("/<206>/","2-3R'",$alg);
    $alg = preg_replace("/<207>/","2-3F",$alg); $alg = preg_replace("/<208>/","2-3F'",$alg);
    
    $alg = preg_replace("/<209>/","3-4D",$alg); $alg = preg_replace("/<210>/","3-4D'",$alg);
    $alg = preg_replace("/<211>/","3-4L",$alg); $alg = preg_replace("/<212>/","3-4L'",$alg);
    $alg = preg_replace("/<213>/","3-4R",$alg); $alg = preg_replace("/<214>/","3-4R'",$alg);
    $alg = preg_replace("/<215>/","3-4F",$alg); $alg = preg_replace("/<216>/","3-4F'",$alg);
    
    $alg = preg_replace("/<217>/","2D",$alg); $alg = preg_replace("/<218>/","2D'",$alg);
    $alg = preg_replace("/<219>/","2L",$alg); $alg = preg_replace("/<220>/","2L'",$alg);
    $alg = preg_replace("/<221>/","2R",$alg); $alg = preg_replace("/<222>/","2R'",$alg);
    $alg = preg_replace("/<223>/","2F",$alg); $alg = preg_replace("/<224>/","2F'",$alg);
    
    $alg = preg_replace("/<225>/","3D",$alg); $alg = preg_replace("/<226>/","3D'",$alg);
    $alg = preg_replace("/<227>/","3L",$alg); $alg = preg_replace("/<228>/","3L'",$alg);
    $alg = preg_replace("/<229>/","3R",$alg); $alg = preg_replace("/<230>/","3R'",$alg);
    $alg = preg_replace("/<231>/","3F",$alg); $alg = preg_replace("/<232>/","3F'",$alg);
    
    $alg = preg_replace("/<233>/","4D",$alg); $alg = preg_replace("/<234>/","4D'",$alg);
    $alg = preg_replace("/<235>/","4L",$alg); $alg = preg_replace("/<236>/","4L'",$alg);
    $alg = preg_replace("/<237>/","4R",$alg); $alg = preg_replace("/<238>/","4R'",$alg);
    $alg = preg_replace("/<239>/","4F",$alg); $alg = preg_replace("/<240>/","4F'",$alg);
    
    /* --- 5xP: CODE -> SiGN: Tier twists --- */
    $alg = preg_replace("/<301>/","4flr'",$alg); $alg = preg_replace("/<302>/","4flr",$alg);
    $alg = preg_replace("/<303>/","4frd'",$alg); $alg = preg_replace("/<304>/","4frd",$alg);
    $alg = preg_replace("/<305>/","4fdl'",$alg); $alg = preg_replace("/<306>/","4fdl",$alg);
    $alg = preg_replace("/<307>/","4drl'",$alg); $alg = preg_replace("/<308>/","4drl",$alg);
    
    $alg = preg_replace("/<309>/","3flr'",$alg); $alg = preg_replace("/<310>/","3flr",$alg);
    $alg = preg_replace("/<311>/","3frd'",$alg); $alg = preg_replace("/<312>/","3frd",$alg);
    $alg = preg_replace("/<313>/","3fdl'",$alg); $alg = preg_replace("/<314>/","3fdl",$alg);
    $alg = preg_replace("/<315>/","3drl'",$alg); $alg = preg_replace("/<316>/","3drl",$alg);
    
    $alg = preg_replace("/<317>/","flr'",$alg); $alg = preg_replace("/<318>/","flr",$alg);
    $alg = preg_replace("/<319>/","frd'",$alg); $alg = preg_replace("/<320>/","frd",$alg);
    $alg = preg_replace("/<321>/","fdl'",$alg); $alg = preg_replace("/<322>/","fdl",$alg);
    $alg = preg_replace("/<323>/","drl'",$alg); $alg = preg_replace("/<324>/","drl",$alg);
    
    /* --- 5xP: CODE -> SiGN: Pyramid rotations --- */
    $alg = preg_replace("/<401>/","Dv",$alg); $alg = preg_replace("/<402>/","Dv'",$alg);
    $alg = preg_replace("/<403>/","Lv",$alg); $alg = preg_replace("/<404>/","Lv'",$alg);
    $alg = preg_replace("/<405>/","Rv",$alg); $alg = preg_replace("/<406>/","Rv'",$alg);
    $alg = preg_replace("/<407>/","Fv",$alg); $alg = preg_replace("/<408>/","Fv'",$alg);
    
    /* --- 5xP: CODE -> SiGN: Corner twists --- */
    $alg = preg_replace("/<901>/","5D",$alg); $alg = preg_replace("/<902>/","5D'",$alg);
    $alg = preg_replace("/<903>/","5L",$alg); $alg = preg_replace("/<904>/","5L'",$alg);
    $alg = preg_replace("/<905>/","5R",$alg); $alg = preg_replace("/<906>/","5R'",$alg);
    $alg = preg_replace("/<907>/","5F",$alg); $alg = preg_replace("/<908>/","5F'",$alg);
    
    return $alg;
  }
  
  
  
  
  /* 
  ---------------------------------------------------------------------------------------------------
  * alg5xP_SiGNToSSE()$alg)
  * 
  * Converts 5x5 Professor Pyraminx SiGN algorithms into SSE notation.
  * 
  * Parameter: $alg (STRING): The algorithm.
  * 
  * Return: STRING.
  ---------------------------------------------------------------------------------------------------
  */
  function alg5xP_SiGNToSSE($alg) {
    /* --- 35: Marker --- */
    $alg = str_replace(".","·",$alg);
    
    /* ··································································································· */
    /* --- 5xP: SiGN -> CODE: Wide-layer twists --- */
    $alg = preg_replace("/2-4D'/","<101>",$alg); $alg = preg_replace("/2-4D/","<102>",$alg);
    $alg = preg_replace("/2-4L'/","<103>",$alg); $alg = preg_replace("/2-4L/","<104>",$alg);
    $alg = preg_replace("/2-4R'/","<105>",$alg); $alg = preg_replace("/2-4R/","<106>",$alg);
    $alg = preg_replace("/2-4F'/","<107>",$alg); $alg = preg_replace("/2-4F/","<108>",$alg);
    
    /* --- 5xP: SiGN -> CODE: Tier twists --- */
    $alg = preg_replace("/2-5D'/","<301>",$alg); $alg = preg_replace("/2-5D/","<302>",$alg);
    $alg = preg_replace("/2-5L'/","<303>",$alg); $alg = preg_replace("/2-5L/","<304>",$alg);
    $alg = preg_replace("/2-5R'/","<305>",$alg); $alg = preg_replace("/2-5R/","<306>",$alg);
    $alg = preg_replace("/2-5F'/","<307>",$alg); $alg = preg_replace("/2-5F/","<308>",$alg);
    
    $alg = preg_replace("/3-5D'/","<309>",$alg); $alg = preg_replace("/3-5D/","<310>",$alg);
    $alg = preg_replace("/3-5L'/","<311>",$alg); $alg = preg_replace("/3-5L/","<312>",$alg);
    $alg = preg_replace("/3-5R'/","<313>",$alg); $alg = preg_replace("/3-5R/","<314>",$alg);
    $alg = preg_replace("/3-5F'/","<315>",$alg); $alg = preg_replace("/3-5F/","<316>",$alg);
    
    $alg = preg_replace("/4-5D'/","<317>",$alg); $alg = preg_replace("/4-5D/","<318>",$alg);
    $alg = preg_replace("/4-5L'/","<319>",$alg); $alg = preg_replace("/4-5L/","<320>",$alg);
    $alg = preg_replace("/4-5R'/","<321>",$alg); $alg = preg_replace("/4-5R/","<322>",$alg);
    $alg = preg_replace("/4-5F'/","<323>",$alg); $alg = preg_replace("/4-5F/","<324>",$alg);
    
     /* --- 5xP: SIGN -> CODE: Numbered layer twists --- */
    $alg = preg_replace("/2-3D'/","<201>",$alg); $alg = preg_replace("/2-3D/","<202>",$alg);
    $alg = preg_replace("/2-3L'/","<203>",$alg); $alg = preg_replace("/2-3L/","<204>",$alg);
    $alg = preg_replace("/2-3R'/","<205>",$alg); $alg = preg_replace("/2-3R/","<206>",$alg);
    $alg = preg_replace("/2-3F'/","<207>",$alg); $alg = preg_replace("/2-3F/","<208>",$alg);
    
    $alg = preg_replace("/3-4D'/","<309>",$alg); $alg = preg_replace("/3-4D/","<210>",$alg);
    $alg = preg_replace("/3-4L'/","<311>",$alg); $alg = preg_replace("/3-4L/","<212>",$alg);
    $alg = preg_replace("/3-4R'/","<313>",$alg); $alg = preg_replace("/3-4R/","<214>",$alg);
    $alg = preg_replace("/3-4F'/","<315>",$alg); $alg = preg_replace("/3-4F/","<216>",$alg);
    
    $alg = preg_replace("/2D'/","<217>",$alg); $alg = preg_replace("/2D/","<218>",$alg);
    $alg = preg_replace("/2L'/","<219>",$alg); $alg = preg_replace("/2L/","<220>",$alg);
    $alg = preg_replace("/2R'/","<221>",$alg); $alg = preg_replace("/2R/","<222>",$alg);
    $alg = preg_replace("/2F'/","<223>",$alg); $alg = preg_replace("/2F/","<224>",$alg);
    
    $alg = preg_replace("/3D'/","<225>",$alg); $alg = preg_replace("/3D/","<226>",$alg);
    $alg = preg_replace("/3L'/","<227>",$alg); $alg = preg_replace("/3L/","<228>",$alg);
    $alg = preg_replace("/3R'/","<229>",$alg); $alg = preg_replace("/3R/","<230>",$alg);
    $alg = preg_replace("/3F'/","<231>",$alg); $alg = preg_replace("/3F/","<232>",$alg);
    
    $alg = preg_replace("/4D'/","<233>",$alg); $alg = preg_replace("/4D/","<234>",$alg);
    $alg = preg_replace("/4L'/","<235>",$alg); $alg = preg_replace("/4L/","<236>",$alg);
    $alg = preg_replace("/4R'/","<237>",$alg); $alg = preg_replace("/4R/","<238>",$alg);
    $alg = preg_replace("/4F'/","<239>",$alg); $alg = preg_replace("/4F/","<240>",$alg);
    
    /* --- 5xP: SiGN -> CODE: Corner twists --- */
    $alg = preg_replace("/5D'/","<901>",$alg); $alg = preg_replace("/5D/","<902>",$alg);
    $alg = preg_replace("/5L'/","<903>",$alg); $alg = preg_replace("/5L/","<904>",$alg);
    $alg = preg_replace("/5R'/","<905>",$alg); $alg = preg_replace("/5R/","<906>",$alg);
    $alg = preg_replace("/5F'/","<907>",$alg); $alg = preg_replace("/5F/","<908>",$alg);
    
    /* --- 5xP: SiGN -> CODE: Tier twists --- */
    $alg = preg_replace("/4flr'/","<301>",$alg); $alg = preg_replace("/4flr/","<302>",$alg);   $alg = preg_replace("/4rfl'/","<301>",$alg); $alg = preg_replace("/4rfl/","<302>",$alg);   $alg = preg_replace("/4lrf'/","<301>",$alg); $alg = preg_replace("/4lrf/","<302>",$alg);
    $alg = preg_replace("/4frd'/","<303>",$alg); $alg = preg_replace("/4frd/","<304>",$alg);   $alg = preg_replace("/4dfr'/","<303>",$alg); $alg = preg_replace("/4dfr/","<304>",$alg);   $alg = preg_replace("/4rdf'/","<303>",$alg); $alg = preg_replace("/4rdf/","<304>",$alg);
    $alg = preg_replace("/4fdl'/","<305>",$alg); $alg = preg_replace("/4fdl/","<306>",$alg);   $alg = preg_replace("/4lfd'/","<305>",$alg); $alg = preg_replace("/4lfd/","<306>",$alg);   $alg = preg_replace("/4dlf'/","<305>",$alg); $alg = preg_replace("/4dlf/","<306>",$alg);
    $alg = preg_replace("/4drl'/","<307>",$alg); $alg = preg_replace("/4drl/","<308>",$alg);   $alg = preg_replace("/4ldr'/","<307>",$alg); $alg = preg_replace("/4ldr/","<308>",$alg);   $alg = preg_replace("/4rld'/","<307>",$alg); $alg = preg_replace("/4rld/","<308>",$alg);
    
    $alg = preg_replace("/3flr'/","<309>",$alg); $alg = preg_replace("/3flr/","<310>",$alg);   $alg = preg_replace("/3rfl'/","<309>",$alg); $alg = preg_replace("/3rfl/","<310>",$alg);   $alg = preg_replace("/3lrf'/","<309>",$alg); $alg = preg_replace("/3lrf/","<310>",$alg);
    $alg = preg_replace("/3frd'/","<311>",$alg); $alg = preg_replace("/3frd/","<312>",$alg);   $alg = preg_replace("/3dfr'/","<311>",$alg); $alg = preg_replace("/3dfr/","<312>",$alg);   $alg = preg_replace("/3rdf'/","<311>",$alg); $alg = preg_replace("/3rdf/","<312>",$alg);
    $alg = preg_replace("/3fdl'/","<313>",$alg); $alg = preg_replace("/3fdl/","<314>",$alg);   $alg = preg_replace("/3lfd'/","<313>",$alg); $alg = preg_replace("/3lfd/","<314>",$alg);   $alg = preg_replace("/3dlf'/","<313>",$alg); $alg = preg_replace("/3dlf/","<314>",$alg);
    $alg = preg_replace("/3drl'/","<315>",$alg); $alg = preg_replace("/3drl/","<316>",$alg);   $alg = preg_replace("/3ldr'/","<315>",$alg); $alg = preg_replace("/3ldr/","<316>",$alg);   $alg = preg_replace("/3rld'/","<315>",$alg); $alg = preg_replace("/3rld/","<316>",$alg);
    
    $alg = preg_replace("/flr'/","<317>",$alg); $alg = preg_replace("/flr/","<318>",$alg);     $alg = preg_replace("/rfl'/","<317>",$alg); $alg = preg_replace("/rfl/","<318>",$alg);     $alg = preg_replace("/lrf'/","<317>",$alg); $alg = preg_replace("/lrf/","<318>",$alg);
    $alg = preg_replace("/frd'/","<319>",$alg); $alg = preg_replace("/frd/","<320>",$alg);     $alg = preg_replace("/dfr'/","<319>",$alg); $alg = preg_replace("/dfr/","<320>",$alg);     $alg = preg_replace("/rdf'/","<319>",$alg); $alg = preg_replace("/rdf/","<320>",$alg);
    $alg = preg_replace("/fdl'/","<321>",$alg); $alg = preg_replace("/fdl/","<322>",$alg);     $alg = preg_replace("/lfd'/","<321>",$alg); $alg = preg_replace("/lfd/","<322>",$alg);     $alg = preg_replace("/dlf'/","<321>",$alg); $alg = preg_replace("/dlf/","<322>",$alg);
    $alg = preg_replace("/drl'/","<323>",$alg); $alg = preg_replace("/drl/","<324>",$alg);     $alg = preg_replace("/ldr'/","<323>",$alg); $alg = preg_replace("/ldr/","<324>",$alg);     $alg = preg_replace("/rld'/","<323>",$alg); $alg = preg_replace("/rld/","<324>",$alg);
    
    /* --- 5xP: SiGN -> CODE: Pyramid rotations --- */
    $alg = preg_replace("/Dv'/","<401>",$alg); $alg = preg_replace("/Dv/","<402>",$alg);
    $alg = preg_replace("/Lv'/","<403>",$alg); $alg = preg_replace("/Lv/","<404>",$alg);
    $alg = preg_replace("/Rv'/","<405>",$alg); $alg = preg_replace("/Rv/","<406>",$alg);
    $alg = preg_replace("/Fv'/","<407>",$alg); $alg = preg_replace("/Fv/","<408>",$alg);
    
    /* --- 5xP: SiGN -> CODE: Face twists --- */
    $alg = preg_replace("/D'/","<501>",$alg); $alg = preg_replace("/D/","<502>",$alg);
    $alg = preg_replace("/L'/","<503>",$alg); $alg = preg_replace("/L/","<504>",$alg);
    $alg = preg_replace("/R'/","<505>",$alg); $alg = preg_replace("/R/","<506>",$alg);
    $alg = preg_replace("/F'/","<507>",$alg); $alg = preg_replace("/F/","<508>",$alg);
    
    /* ··································································································· */
    /* --- 5xP: CODE -> SiGN: Wide-layer twists --- */
    $alg = preg_replace("/<101>/","WU",$alg); $alg = preg_replace("/<102>/","WU'",$alg);
    $alg = preg_replace("/<103>/","WR",$alg); $alg = preg_replace("/<104>/","WR'",$alg);
    $alg = preg_replace("/<105>/","WL",$alg); $alg = preg_replace("/<106>/","WL'",$alg);
    $alg = preg_replace("/<107>/","WB",$alg); $alg = preg_replace("/<108>/","WB'",$alg);
    
    /* --- 5xP: CODE -> SSE: Numbered layer twists --- */
    $alg = preg_replace("/<201>/","N3-4U",$alg); $alg = preg_replace("/<202>/","N3-4U'",$alg);
    $alg = preg_replace("/<203>/","N3-4R",$alg); $alg = preg_replace("/<204>/","N3-4R'",$alg);
    $alg = preg_replace("/<205>/","N3-4L",$alg); $alg = preg_replace("/<206>/","N3-4L'",$alg);
    $alg = preg_replace("/<207>/","N3-4B",$alg); $alg = preg_replace("/<208>/","N3-4B'",$alg);
    
    $alg = preg_replace("/<209>/","N2-3U",$alg); $alg = preg_replace("/<210>/","N2-3U'",$alg);
    $alg = preg_replace("/<211>/","N2-3R",$alg); $alg = preg_replace("/<212>/","N2-3R'",$alg);
    $alg = preg_replace("/<213>/","N2-3L",$alg); $alg = preg_replace("/<214>/","N2-3L'",$alg);
    $alg = preg_replace("/<215>/","N2-3B",$alg); $alg = preg_replace("/<216>/","N2-3B'",$alg);
    
    $alg = preg_replace("/<217>/","N4U",$alg); $alg = preg_replace("/<218>/","N4U'",$alg);
    $alg = preg_replace("/<219>/","N4R",$alg); $alg = preg_replace("/<220>/","N4R'",$alg);
    $alg = preg_replace("/<221>/","N4L",$alg); $alg = preg_replace("/<222>/","N4L'",$alg);
    $alg = preg_replace("/<223>/","N4B",$alg); $alg = preg_replace("/<224>/","N4B'",$alg);
    
    $alg = preg_replace("/<225>/","N3U",$alg); $alg = preg_replace("/<226>/","N3U'",$alg);
    $alg = preg_replace("/<227>/","N3R",$alg); $alg = preg_replace("/<228>/","N3R'",$alg);
    $alg = preg_replace("/<229>/","N3L",$alg); $alg = preg_replace("/<230>/","N3L'",$alg);
    $alg = preg_replace("/<231>/","N3B",$alg); $alg = preg_replace("/<232>/","N3B'",$alg);
    
    $alg = preg_replace("/<233>/","NU",$alg); $alg = preg_replace("/<234>/","NU'",$alg);
    $alg = preg_replace("/<235>/","NR",$alg); $alg = preg_replace("/<236>/","NR'",$alg);
    $alg = preg_replace("/<237>/","NL",$alg); $alg = preg_replace("/<238>/","NL'",$alg);
    $alg = preg_replace("/<239>/","NB",$alg); $alg = preg_replace("/<240>/","NB'",$alg);
    
    /* --- 5xP: CODE -> SSE: Corner twists --- */
    $alg = preg_replace("/<901>/","U",$alg); $alg = preg_replace("/<902>/","U'",$alg);
    $alg = preg_replace("/<903>/","R",$alg); $alg = preg_replace("/<904>/","R'",$alg);
    $alg = preg_replace("/<905>/","L",$alg); $alg = preg_replace("/<906>/","L'",$alg);
    $alg = preg_replace("/<907>/","B",$alg); $alg = preg_replace("/<908>/","B'",$alg);
    
    /* --- 5xP: CODE -> SSE: Tier twists --- */
    $alg = preg_replace("/<301>/","T4U'",$alg); $alg = preg_replace("/<302>/","T4U",$alg);
    $alg = preg_replace("/<303>/","T4R'",$alg); $alg = preg_replace("/<304>/","T4R",$alg);
    $alg = preg_replace("/<305>/","T4L'",$alg); $alg = preg_replace("/<306>/","T4L",$alg);
    $alg = preg_replace("/<307>/","T4B'",$alg); $alg = preg_replace("/<308>/","T4B",$alg);
    
    $alg = preg_replace("/<309>/","T3U'",$alg); $alg = preg_replace("/<310>/","T3U",$alg);
    $alg = preg_replace("/<311>/","T3R'",$alg); $alg = preg_replace("/<312>/","T3R",$alg);
    $alg = preg_replace("/<313>/","T3L'",$alg); $alg = preg_replace("/<314>/","T3L",$alg);
    $alg = preg_replace("/<315>/","T3B'",$alg); $alg = preg_replace("/<316>/","T3B",$alg);
    
    $alg = preg_replace("/<317>/","TU'",$alg); $alg = preg_replace("/<318>/","TU",$alg);
    $alg = preg_replace("/<319>/","TR'",$alg); $alg = preg_replace("/<320>/","TR",$alg);
    $alg = preg_replace("/<321>/","TL'",$alg); $alg = preg_replace("/<322>/","TL",$alg);
    $alg = preg_replace("/<323>/","TB'",$alg); $alg = preg_replace("/<324>/","TB",$alg);
    
    /* --- 4xP: CODE -> SSE: Pyramid rotations --- */
    $alg = preg_replace("/<401>/","CU",$alg); $alg = preg_replace("/<402>/","CU'",$alg);
    $alg = preg_replace("/<403>/","CR",$alg); $alg = preg_replace("/<404>/","CR'",$alg);
    $alg = preg_replace("/<405>/","CL",$alg); $alg = preg_replace("/<406>/","CL'",$alg);
    $alg = preg_replace("/<407>/","CB",$alg); $alg = preg_replace("/<408>/","CB'",$alg);
    
    /* --- 4xP: CODE -> SSE: Face twists --- */
    $alg = preg_replace("/<501>/","T4U' CU",$alg); $alg = preg_replace("/<502>/","T4U CU'",$alg);
    $alg = preg_replace("/<503>/","T4R' CR",$alg); $alg = preg_replace("/<504>/","T4R CR'",$alg);
    $alg = preg_replace("/<505>/","T4L' CL",$alg); $alg = preg_replace("/<506>/","T4L CL'",$alg);
    $alg = preg_replace("/<507>/","T4B' CB",$alg); $alg = preg_replace("/<508>/","T4B CB'",$alg);
    
    return $alg;
  }
  
  
  
  
  /* 
  ---------------------------------------------------------------------------------------------------
  * alg3xD_SSEToSiGN()$alg)
  * 
  * Converts 3x3 Megaminx SSE algorithms into SiGN notation.
  * 
  * Parameter: $alg (STRING): The algorithm.
  * 
  * Return: STRING.
  ---------------------------------------------------------------------------------------------------
  */
  function alg3xD_SSEToSiGN($alg) {
    /* --- Dodecahedron Twists --- */
    //   +0°  = R0, []     = -360° = R5', []
    //  +72°  = R1, [R]    = -288° = R4', [R]
    // +144°  = R2, [R2]   = -216° = R3', [R2]
    // +216°  = R3, [R2']  = -144° = R2', [R2']
    // +288°  = R4, [R']   =  -72° = R1', [R']
    // +360°  = R5, []     =   -0° = R0', []
    
    /* --- 3x: Normalize SSE inversion --- */
    $alg = str_replace("-","'",$alg); // Only if hypen (-) ist not used in algorithm tokens!
    
    /* --- 3x: Marker --- */
    $alg = str_replace("·",".",$alg);
    
    /* ··································································································· */
    /* --- 3xD: SSE -> CODE: (Wide) Mid-layer twists --- */
    
    /* --- 3xD: SSE -> CODE: Numbered layer twists --- */
    
    /* --- 3xD: SSE -> CODE: Tier twists --- */
    
    /* --- 3xD: SSE -> CODE: Dodecahedron rotations --- */
    $alg = preg_replace("/CUR2'/","<401>",$alg); $alg = preg_replace("/CUR2-/","<401>",$alg);   $alg = preg_replace("/CUR'/","<402>",$alg); $alg = preg_replace("/CUR-/","<402>",$alg);   $alg = preg_replace("/CUR2/","<403>",$alg);   $alg = preg_replace("/CUR/","<404>",$alg);
    $alg = preg_replace("/CUL2'/","<405>",$alg); $alg = preg_replace("/CUL2-/","<405>",$alg);   $alg = preg_replace("/CUL'/","<406>",$alg); $alg = preg_replace("/CUL-/","<406>",$alg);   $alg = preg_replace("/CUL2/","<407>",$alg);   $alg = preg_replace("/CUL/","<408>",$alg);
    $alg = preg_replace("/CDR2'/","<409>",$alg); $alg = preg_replace("/CDR2-/","<409>",$alg);   $alg = preg_replace("/CDR'/","<410>",$alg); $alg = preg_replace("/CDR-/","<410>",$alg);   $alg = preg_replace("/CDR2/","<411>",$alg);   $alg = preg_replace("/CDR/","<412>",$alg);
    $alg = preg_replace("/CDL2'/","<413>",$alg); $alg = preg_replace("/CDL2-/","<413>",$alg);   $alg = preg_replace("/CDL'/","<414>",$alg); $alg = preg_replace("/CDL-/","<414>",$alg);   $alg = preg_replace("/CDL2/","<415>",$alg);   $alg = preg_replace("/CDL/","<416>",$alg);
    $alg = preg_replace("/CBR2'/","<417>",$alg); $alg = preg_replace("/CBR2-/","<417>",$alg);   $alg = preg_replace("/CBR'/","<418>",$alg); $alg = preg_replace("/CBR-/","<418>",$alg);   $alg = preg_replace("/CBR2/","<419>",$alg);   $alg = preg_replace("/CBR/","<420>",$alg);
    $alg = preg_replace("/CBL2'/","<421>",$alg); $alg = preg_replace("/CBL2-/","<421>",$alg);   $alg = preg_replace("/CBL'/","<422>",$alg); $alg = preg_replace("/CBL-/","<422>",$alg);   $alg = preg_replace("/CBL2/","<423>",$alg);   $alg = preg_replace("/CBL/","<424>",$alg);
    
    $alg = preg_replace("/CR2'/","<425>",$alg); $alg = preg_replace("/CR2-/","<425>",$alg);     $alg = preg_replace("/CR'/","<426>",$alg);  $alg = preg_replace("/CR-/","<426>",$alg);     $alg = preg_replace("/CR2/","<427>",$alg);    $alg = preg_replace("/CR/","<428>",$alg);
    $alg = preg_replace("/CL2'/","<429>",$alg); $alg = preg_replace("/CL2-/","<429>",$alg);     $alg = preg_replace("/CL'/","<430>",$alg);  $alg = preg_replace("/CL-/","<430>",$alg);     $alg = preg_replace("/CL2/","<431>",$alg);    $alg = preg_replace("/CL/","<432>",$alg);
    $alg = preg_replace("/CF2'/","<433>",$alg); $alg = preg_replace("/CF2-/","<433>",$alg);     $alg = preg_replace("/CF'/","<434>",$alg);  $alg = preg_replace("/CF-/","<434>",$alg);     $alg = preg_replace("/CF2/","<435>",$alg);    $alg = preg_replace("/CF/","<436>",$alg);
    $alg = preg_replace("/CB2'/","<437>",$alg); $alg = preg_replace("/CB2-/","<437>",$alg);     $alg = preg_replace("/CB'/","<438>",$alg);  $alg = preg_replace("/CB-/","<438>",$alg);     $alg = preg_replace("/CB2/","<439>",$alg);    $alg = preg_replace("/CB/","<440>",$alg);
    $alg = preg_replace("/CU2'/","<441>",$alg); $alg = preg_replace("/CU2-/","<441>",$alg);     $alg = preg_replace("/CU'/","<442>",$alg);  $alg = preg_replace("/CU-/","<442>",$alg);     $alg = preg_replace("/CU2/","<443>",$alg);    $alg = preg_replace("/CU/","<444>",$alg);
    $alg = preg_replace("/CD2'/","<445>",$alg); $alg = preg_replace("/CD2-/","<445>",$alg);     $alg = preg_replace("/CD'/","<446>",$alg);  $alg = preg_replace("/CD-/","<446>",$alg);     $alg = preg_replace("/CD2/","<447>",$alg);    $alg = preg_replace("/CD/","<448>",$alg);
    
    /* --- 3xD: SSE -> CODE: Face twists --- */
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
    /* --- 3xD: CODE -> SiGN: (Wide) Mid-layer twists --- */
    
    /* --- 3xD: CODE -> SIGN: Numbered layer twists --- */
    
    /* --- 3xD: CODE -> SiGN: Tier twists --- */
    
    /* --- 3xD: CODE -> SiGN: Dodecahedron rotations --- */
    $alg = preg_replace("/<401>/","BRv2'",$alg);   $alg = preg_replace("/<402>/","BRv'",$alg);   $alg = preg_replace("/<403>/","BRv2",$alg);   $alg = preg_replace("/<404>/","BRv",$alg);
    $alg = preg_replace("/<405>/","BLv2'",$alg);   $alg = preg_replace("/<406>/","BLv'",$alg);   $alg = preg_replace("/<407>/","BLv2",$alg);   $alg = preg_replace("/<408>/","BLv",$alg);
    $alg = preg_replace("/<409>/","FRv2'",$alg);   $alg = preg_replace("/<410>/","FRv'",$alg);   $alg = preg_replace("/<411>/","FRv2",$alg);   $alg = preg_replace("/<412>/","FRv",$alg);
    $alg = preg_replace("/<413>/","FLv2'",$alg);   $alg = preg_replace("/<414>/","FLv'",$alg);   $alg = preg_replace("/<415>/","FLv2",$alg);   $alg = preg_replace("/<416>/","FLv",$alg);
    $alg = preg_replace("/<417>/","DRv2'",$alg);   $alg = preg_replace("/<418>/","DRv'",$alg);   $alg = preg_replace("/<419>/","DRv2",$alg);   $alg = preg_replace("/<420>/","DRv",$alg);
    $alg = preg_replace("/<421>/","DLv2'",$alg);   $alg = preg_replace("/<422>/","DLv'",$alg);   $alg = preg_replace("/<423>/","DLv'",$alg);   $alg = preg_replace("/<424>/","DLv",$alg);
    
    $alg = preg_replace("/<425>/","Rv2'",$alg);    $alg = preg_replace("/<426>/","Rv'",$alg);    $alg = preg_replace("/<427>/","Rv2",$alg);    $alg = preg_replace("/<428>/","Rv",$alg);
    $alg = preg_replace("/<429>/","Lv2'",$alg);    $alg = preg_replace("/<430>/","Lv'",$alg);    $alg = preg_replace("/<431>/","Lv2",$alg);    $alg = preg_replace("/<432>/","Lv",$alg);
    $alg = preg_replace("/<433>/","Fv2'",$alg);    $alg = preg_replace("/<434>/","Fv'",$alg);    $alg = preg_replace("/<435>/","Fv2",$alg);    $alg = preg_replace("/<436>/","Fv",$alg);
    $alg = preg_replace("/<437>/","Bv2'",$alg);    $alg = preg_replace("/<438>/","Bv'",$alg);    $alg = preg_replace("/<439>/","Bv2",$alg);    $alg = preg_replace("/<440>/","Bv",$alg);
    $alg = preg_replace("/<441>/","Uv2'",$alg);    $alg = preg_replace("/<442>/","Uv'",$alg);    $alg = preg_replace("/<443>/","Uv2",$alg);    $alg = preg_replace("/<444>/","Uv",$alg);
    $alg = preg_replace("/<445>/","Dv2'",$alg);    $alg = preg_replace("/<446>/","Dv'",$alg);    $alg = preg_replace("/<447>/","Dv2",$alg);    $alg = preg_replace("/<448>/","Dv",$alg);
    
    /* --- 3xD: CODE -> SiGN: Face twists --- */
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
  * alg3xD_SiGNToSSE()$alg)
  * 
  * Converts 3x3 Megaminx SiGN algorithms into SSE notation.
  * 
  * Parameter: $alg (STRING): The algorithm.
  * 
  * Return: STRING.
  ---------------------------------------------------------------------------------------------------
  */
  function alg3xD_SiGNToSSE($alg) {
    /* --- Dodecahedron Twists --- */
    //   +0°  = R0, []     = -360° = R5', []
    //  +72°  = R1, [R]    = -288° = R4', [R]
    // +144°  = R2, [R2]   = -216° = R3', [R2]
    // +216°  = R3, [R2']  = -144° = R2', [R2']
    // +288°  = R4, [R']   =  -72° = R1', [R']
    // +360°  = R5, []     =   -0° = R0', []
    
    /* --- 3x: Marker --- */
    $alg = str_replace(".","·",$alg);
    
    /* ··································································································· */
    /* --- 3xD: SiGN -> CODE: (Wide) Mid-layer twists --- */
    
    /* --- 3xD: SIGN -> CODE: Numbered layer twists --- */
    
    /* --- 3xD: SiGN -> CODE: Tier twists --- */
    
    /* --- 3xD: SiGN -> CODE: Dodecahedron rotations --- */
    $alg = preg_replace("/BRv2'/","<401>",$alg);   $alg = preg_replace("/BRv'/","<402>",$alg);   $alg = preg_replace("/BRv2/","<403>",$alg);      $alg = preg_replace("/BRv/","<404>",$alg);
    $alg = preg_replace("/BLv2'/","<405>",$alg);   $alg = preg_replace("/BLv'/","<406>",$alg);   $alg = preg_replace("/BLv2/","<407>",$alg);      $alg = preg_replace("/BLv/","<408>",$alg);
    $alg = preg_replace("/FRv2'/","<409>",$alg);   $alg = preg_replace("/FRv'/","<410>",$alg);   $alg = preg_replace("/FRv2/","<411>",$alg);      $alg = preg_replace("/FRv/","<412>",$alg);
    $alg = preg_replace("/FLv2'/","<413>",$alg);   $alg = preg_replace("/FLv'/","<414>",$alg);   $alg = preg_replace("/FLv2/","<415>",$alg);      $alg = preg_replace("/FLv/","<416>",$alg);
    $alg = preg_replace("/DRv2'/","<417>",$alg);   $alg = preg_replace("/DRv'/","<418>",$alg);   $alg = preg_replace("/DRv2/","<419>",$alg);      $alg = preg_replace("/DRv/","<420>",$alg);
    $alg = preg_replace("/DLv2'/","<421>",$alg);   $alg = preg_replace("/DLv'/","<422>",$alg);   $alg = preg_replace("/DLv2/","<423>",$alg);      $alg = preg_replace("/DLv/","<424>",$alg);
    
    $alg = preg_replace("/Rv2'/","<425>",$alg);    $alg = preg_replace("/Rv'/","<426>",$alg);    $alg = preg_replace("/Rv2/","<427>",$alg);       $alg = preg_replace("/Rv/","<428>",$alg);
    $alg = preg_replace("/Lv2'/","<429>",$alg);    $alg = preg_replace("/Lv'/","<430>",$alg);    $alg = preg_replace("/Lv2/","<431>",$alg);       $alg = preg_replace("/Lv/","<432>",$alg);
    $alg = preg_replace("/Fv2'/","<433>",$alg);    $alg = preg_replace("/Fv'/","<434>",$alg);    $alg = preg_replace("/Fv2/","<435>",$alg);       $alg = preg_replace("/Fv/","<436>",$alg);
    $alg = preg_replace("/Bv2'/","<437>",$alg);    $alg = preg_replace("/Bv'/","<438>",$alg);    $alg = preg_replace("/Bv2/","<439>",$alg);       $alg = preg_replace("/Bv/","<440>",$alg);
    $alg = preg_replace("/Uv2'/","<441>",$alg);    $alg = preg_replace("/Uv'/","<442>",$alg);    $alg = preg_replace("/Uv2/","<443>",$alg);       $alg = preg_replace("/Uv/","<444>",$alg);
    $alg = preg_replace("/Dv2'/","<445>",$alg);    $alg = preg_replace("/Dv'/","<446>",$alg);    $alg = preg_replace("/Dv2/","<447>",$alg);       $alg = preg_replace("/Dv/","<448>",$alg);
    
    /* --- 3xD: SiGN -> CODE: Face twists --- */
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
    
    /* ··································································································· */
    /* --- 3xD: CODE -> SiGN: (Wide) Mid-layer twists --- */
    
    /* --- 3xD: CODE -> SSE: Numbered layer twists --- */
    
    /* --- 3xD: CODE -> SSE: Tier twists --- */
    
    /* --- 3xD: CODE -> SSE: Dodecahedron rotations --- */
    $alg = preg_replace("/<401>/","CUR2'",$alg);   $alg = preg_replace("/<402>/","CUR'",$alg);   $alg = preg_replace("/<403>/","CUR2",$alg);   $alg = preg_replace("/<404>/","CUR",$alg);
    $alg = preg_replace("/<405>/","CUL2'",$alg);   $alg = preg_replace("/<406>/","CUL'",$alg);   $alg = preg_replace("/<407>/","CUL2",$alg);   $alg = preg_replace("/<408>/","CUL",$alg);
    $alg = preg_replace("/<409>/","CDR2'",$alg);   $alg = preg_replace("/<410>/","CDR'",$alg);   $alg = preg_replace("/<411>/","CDR2",$alg);   $alg = preg_replace("/<412>/","CDR",$alg);
    $alg = preg_replace("/<413>/","CDL2'",$alg);   $alg = preg_replace("/<414>/","CDL'",$alg);   $alg = preg_replace("/<415>/","CDL2",$alg);   $alg = preg_replace("/<416>/","CDL",$alg);
    $alg = preg_replace("/<417>/","CBR2'",$alg);   $alg = preg_replace("/<418>/","CBR'",$alg);   $alg = preg_replace("/<419>/","CBR2",$alg);   $alg = preg_replace("/<420>/","CBR",$alg);
    $alg = preg_replace("/<421>/","CBL2'",$alg);   $alg = preg_replace("/<422>/","CBL'",$alg);   $alg = preg_replace("/<423>/","CBL2",$alg);   $alg = preg_replace("/<424>/","CBL",$alg);
    
    $alg = preg_replace("/<425>/","CR2'",$alg);    $alg = preg_replace("/<426>/","CR'",$alg);    $alg = preg_replace("/<427>/","CR2",$alg);    $alg = preg_replace("/<428>/","CR",$alg);
    $alg = preg_replace("/<429>/","CL2'",$alg);    $alg = preg_replace("/<430>/","CL'",$alg);    $alg = preg_replace("/<431>/","CL2",$alg);    $alg = preg_replace("/<432>/","CL",$alg);
    $alg = preg_replace("/<433>/","CF2'",$alg);    $alg = preg_replace("/<434>/","CF'",$alg);    $alg = preg_replace("/<435>/","CF2",$alg);    $alg = preg_replace("/<436>/","CF",$alg);
    $alg = preg_replace("/<437>/","CB2'",$alg);    $alg = preg_replace("/<438>/","CB'",$alg);    $alg = preg_replace("/<439>/","CB2",$alg);    $alg = preg_replace("/<440>/","CB",$alg);
    $alg = preg_replace("/<441>/","CU2'",$alg);    $alg = preg_replace("/<442>/","CU'",$alg);    $alg = preg_replace("/<443>/","CU2",$alg);    $alg = preg_replace("/<444>/","CU",$alg);
    $alg = preg_replace("/<445>/","CD2'",$alg);    $alg = preg_replace("/<446>/","CD'",$alg);    $alg = preg_replace("/<447>/","CD2",$alg);    $alg = preg_replace("/<448>/","CD",$alg);
    
    /* --- 3xD: CODE -> SSE: Face twists --- */
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
    
    return $alg;
  }
  
  
  
  
  /* 
  ---------------------------------------------------------------------------------------------------
  * alg5xD_SSEToSiGN()$alg)
  * 
  * Converts 5x5 Gigaminx SSE algorithms into SiGN notation.
  * 
  * Parameter: $alg (STRING): The algorithm.
  * 
  * Return: STRING.
  ---------------------------------------------------------------------------------------------------
  */
  function alg5xD_SSEToSiGN($alg) {
    /* --- Dodecahedron Twists --- */
    //   +0°  = R0, []     = -360° = R5', []
    //  +72°  = R1, [R]    = -288° = R4', [R]
    // +144°  = R2, [R2]   = -216° = R3', [R2]
    // +216°  = R3, [R2']  = -144° = R2', [R2']
    // +288°  = R4, [R']   =  -72° = R1', [R']
    // +360°  = R5, []     =   -0° = R0', []
    
    /* --- 4x: Normalize SSE inversion --- */
    $alg = str_replace("-","'",$alg); // Only if hypen (-) ist not used in algorithm tokens!
    
    /* --- 4x: Marker --- */
    $alg = str_replace("·",".",$alg);
    
    /* ··································································································· */
    /* --- 5xD: SSE -> CODE: Wide twists --- */
    
    /* --- 5xD: SSE -> CODE: Numbered layer twists --- */
    $alg = preg_replace("/NUR2'/","<201>",$alg); $alg = preg_replace("/NUR2-/","<201>",$alg);   $alg = preg_replace("/NUR'/","<202>",$alg); $alg = preg_replace("/NUR-/","<202>",$alg);   $alg = preg_replace("/NUR2/","<203>",$alg);   $alg = preg_replace("/NUR/","<204>",$alg);
    $alg = preg_replace("/NUL2'/","<205>",$alg); $alg = preg_replace("/NUL2-/","<205>",$alg);   $alg = preg_replace("/NUL'/","<206>",$alg); $alg = preg_replace("/NUL-/","<206>",$alg);   $alg = preg_replace("/NUL2/","<207>",$alg);   $alg = preg_replace("/NUL/","<208>",$alg);
    $alg = preg_replace("/NDR2'/","<209>",$alg); $alg = preg_replace("/NDR2-/","<209>",$alg);   $alg = preg_replace("/NDR'/","<210>",$alg); $alg = preg_replace("/NDR-/","<210>",$alg);   $alg = preg_replace("/NDR2/","<211>",$alg);   $alg = preg_replace("/NDR/","<212>",$alg);
    $alg = preg_replace("/NDL2'/","<213>",$alg); $alg = preg_replace("/NDL2-/","<213>",$alg);   $alg = preg_replace("/NDL'/","<214>",$alg); $alg = preg_replace("/NDL-/","<214>",$alg);   $alg = preg_replace("/NDL2/","<215>",$alg);   $alg = preg_replace("/NDL/","<216>",$alg);
    $alg = preg_replace("/NBR2'/","<217>",$alg); $alg = preg_replace("/NBR2-/","<217>",$alg);   $alg = preg_replace("/NBR'/","<218>",$alg); $alg = preg_replace("/NBR-/","<218>",$alg);   $alg = preg_replace("/NBR2/","<219>",$alg);   $alg = preg_replace("/NBR/","<220>",$alg);
    $alg = preg_replace("/NBL2'/","<221>",$alg); $alg = preg_replace("/NBL2-/","<221>",$alg);   $alg = preg_replace("/NBL'/","<222>",$alg); $alg = preg_replace("/NBL-/","<222>",$alg);   $alg = preg_replace("/NBL2/","<223>",$alg);   $alg = preg_replace("/NBL/","<224>",$alg);
    
    $alg = preg_replace("/NR2'/","<225>",$alg); $alg = preg_replace("/NR2-/","<225>",$alg);     $alg = preg_replace("/NR'/","<226>",$alg); $alg = preg_replace("/NR-/","<226>",$alg);     $alg = preg_replace("/NR2/","<227>",$alg);    $alg = preg_replace("/NR/","<228>",$alg);
    $alg = preg_replace("/NL2'/","<229>",$alg); $alg = preg_replace("/NL2-/","<229>",$alg);     $alg = preg_replace("/NL'/","<230>",$alg); $alg = preg_replace("/NL-/","<230>",$alg);     $alg = preg_replace("/NL2/","<231>",$alg);    $alg = preg_replace("/NL/","<232>",$alg);
    $alg = preg_replace("/NF2'/","<233>",$alg); $alg = preg_replace("/NF2-/","<233>",$alg);     $alg = preg_replace("/NF'/","<234>",$alg); $alg = preg_replace("/NF-/","<234>",$alg);     $alg = preg_replace("/NF2/","<235>",$alg);    $alg = preg_replace("/NF/","<236>",$alg);
    $alg = preg_replace("/NB2'/","<237>",$alg); $alg = preg_replace("/NB2-/","<237>",$alg);     $alg = preg_replace("/NB'/","<238>",$alg); $alg = preg_replace("/NB-/","<238>",$alg);     $alg = preg_replace("/NB2/","<239>",$alg);    $alg = preg_replace("/NB/","<240>",$alg);
    $alg = preg_replace("/NU2'/","<241>",$alg); $alg = preg_replace("/NU2-/","<241>",$alg);     $alg = preg_replace("/NU'/","<242>",$alg); $alg = preg_replace("/NU-/","<242>",$alg);     $alg = preg_replace("/NU2/","<243>",$alg);    $alg = preg_replace("/NU/","<244>",$alg);
    $alg = preg_replace("/ND2'/","<245>",$alg); $alg = preg_replace("/ND2-/","<245>",$alg);     $alg = preg_replace("/ND'/","<246>",$alg); $alg = preg_replace("/ND-/","<246>",$alg);     $alg = preg_replace("/ND2/","<247>",$alg);    $alg = preg_replace("/ND/","<248>",$alg);
    
    /* --- 5xD: SSE -> CODE: Tier twists --- */
    $alg = preg_replace("/TUR2'/","<301>",$alg); $alg = preg_replace("/TUR2-/","<301>",$alg);   $alg = preg_replace("/TUR'/","<302>",$alg); $alg = preg_replace("/TUR-/","<302>",$alg);   $alg = preg_replace("/TUR2/","<303>",$alg);   $alg = preg_replace("/TUR/","<304>",$alg);
    $alg = preg_replace("/TUL2'/","<305>",$alg); $alg = preg_replace("/TUL2-/","<305>",$alg);   $alg = preg_replace("/TUL'/","<306>",$alg); $alg = preg_replace("/TUL-/","<306>",$alg);   $alg = preg_replace("/TUL2/","<307>",$alg);   $alg = preg_replace("/TUL/","<308>",$alg);
    $alg = preg_replace("/TDR2'/","<309>",$alg); $alg = preg_replace("/TDR2-/","<309>",$alg);   $alg = preg_replace("/TDR'/","<310>",$alg); $alg = preg_replace("/TDR-/","<310>",$alg);   $alg = preg_replace("/TDR2/","<311>",$alg);   $alg = preg_replace("/TDR/","<312>",$alg);
    $alg = preg_replace("/TDL2'/","<313>",$alg); $alg = preg_replace("/TDL2-/","<313>",$alg);   $alg = preg_replace("/TDL'/","<314>",$alg); $alg = preg_replace("/TDL-/","<314>",$alg);   $alg = preg_replace("/TDL2/","<315>",$alg);   $alg = preg_replace("/TDL/","<316>",$alg);
    $alg = preg_replace("/TBR2'/","<317>",$alg); $alg = preg_replace("/TBR2-/","<317>",$alg);   $alg = preg_replace("/TBR'/","<318>",$alg); $alg = preg_replace("/TBR-/","<318>",$alg);   $alg = preg_replace("/TBR2/","<319>",$alg);   $alg = preg_replace("/TBR/","<320>",$alg);
    $alg = preg_replace("/TBL2'/","<321>",$alg); $alg = preg_replace("/TBL2-/","<321>",$alg);   $alg = preg_replace("/TBL'/","<322>",$alg); $alg = preg_replace("/TBL-/","<322>",$alg);   $alg = preg_replace("/TBL2/","<323>",$alg);   $alg = preg_replace("/TBL/","<324>",$alg);
    
    $alg = preg_replace("/TR2'/","<325>",$alg); $alg = preg_replace("/TR2-/","<325>",$alg);     $alg = preg_replace("/TR'/","<326>",$alg); $alg = preg_replace("/TR-/","<326>",$alg);     $alg = preg_replace("/TR2/","<327>",$alg);    $alg = preg_replace("/TR/","<328>",$alg);
    $alg = preg_replace("/TL2'/","<329>",$alg); $alg = preg_replace("/TL2-/","<329>",$alg);     $alg = preg_replace("/TL'/","<330>",$alg); $alg = preg_replace("/TL-/","<330>",$alg);     $alg = preg_replace("/TL2/","<331>",$alg);    $alg = preg_replace("/TL/","<332>",$alg);
    $alg = preg_replace("/TF2'/","<333>",$alg); $alg = preg_replace("/TF2-/","<333>",$alg);     $alg = preg_replace("/TF'/","<334>",$alg); $alg = preg_replace("/TF-/","<334>",$alg);     $alg = preg_replace("/TF2/","<335>",$alg);    $alg = preg_replace("/TF/","<336>",$alg);
    $alg = preg_replace("/TB2'/","<337>",$alg); $alg = preg_replace("/TB2-/","<337>",$alg);     $alg = preg_replace("/TB'/","<338>",$alg); $alg = preg_replace("/TB-/","<338>",$alg);     $alg = preg_replace("/TB2/","<339>",$alg);    $alg = preg_replace("/TB/","<340>",$alg);
    $alg = preg_replace("/TU2'/","<341>",$alg); $alg = preg_replace("/TU2-/","<341>",$alg);     $alg = preg_replace("/TU'/","<342>",$alg); $alg = preg_replace("/TU-/","<342>",$alg);     $alg = preg_replace("/TU2/","<343>",$alg);    $alg = preg_replace("/TU/","<344>",$alg);
    $alg = preg_replace("/TD2'/","<345>",$alg); $alg = preg_replace("/TD2-/","<345>",$alg);     $alg = preg_replace("/TD'/","<346>",$alg); $alg = preg_replace("/TD-/","<346>",$alg);     $alg = preg_replace("/TD2/","<347>",$alg);    $alg = preg_replace("/TD/","<348>",$alg);
    
    /* --- 5xD: SSE -> CODE: Dodecahedron rotations --- */
    $alg = preg_replace("/CUR2'/","<401>",$alg); $alg = preg_replace("/CUR2-/","<401>",$alg);   $alg = preg_replace("/CUR'/","<402>",$alg); $alg = preg_replace("/CUR-/","<402>",$alg);   $alg = preg_replace("/CUR2/","<403>",$alg);   $alg = preg_replace("/CUR/","<404>",$alg);
    $alg = preg_replace("/CUL2'/","<405>",$alg); $alg = preg_replace("/CUL2-/","<405>",$alg);   $alg = preg_replace("/CUL'/","<406>",$alg); $alg = preg_replace("/CUL-/","<406>",$alg);   $alg = preg_replace("/CUL2/","<407>",$alg);   $alg = preg_replace("/CUL/","<408>",$alg);
    $alg = preg_replace("/CDR2'/","<409>",$alg); $alg = preg_replace("/CDR2-/","<409>",$alg);   $alg = preg_replace("/CDR'/","<410>",$alg); $alg = preg_replace("/CDR-/","<410>",$alg);   $alg = preg_replace("/CDR2/","<411>",$alg);   $alg = preg_replace("/CDR/","<412>",$alg);
    $alg = preg_replace("/CDL2'/","<413>",$alg); $alg = preg_replace("/CDL2-/","<413>",$alg);   $alg = preg_replace("/CDL'/","<414>",$alg); $alg = preg_replace("/CDL-/","<414>",$alg);   $alg = preg_replace("/CDL2/","<415>",$alg);   $alg = preg_replace("/CDL/","<416>",$alg);
    $alg = preg_replace("/CBR2'/","<417>",$alg); $alg = preg_replace("/CBR2-/","<417>",$alg);   $alg = preg_replace("/CBR'/","<418>",$alg); $alg = preg_replace("/CBR-/","<418>",$alg);   $alg = preg_replace("/CBR2/","<419>",$alg);   $alg = preg_replace("/CBR/","<420>",$alg);
    $alg = preg_replace("/CBL2'/","<421>",$alg); $alg = preg_replace("/CBL2-/","<421>",$alg);   $alg = preg_replace("/CBL'/","<422>",$alg); $alg = preg_replace("/CBL-/","<422>",$alg);   $alg = preg_replace("/CBL2/","<423>",$alg);   $alg = preg_replace("/CBL/","<424>",$alg);
    
    $alg = preg_replace("/CR2'/","<425>",$alg); $alg = preg_replace("/CR2-/","<425>",$alg);     $alg = preg_replace("/CR'/","<426>",$alg); $alg = preg_replace("/CR-/","<426>",$alg);     $alg = preg_replace("/CR2/","<427>",$alg);    $alg = preg_replace("/CR/","<428>",$alg);
    $alg = preg_replace("/CL2'/","<429>",$alg); $alg = preg_replace("/CL2-/","<429>",$alg);     $alg = preg_replace("/CL'/","<430>",$alg); $alg = preg_replace("/CL-/","<430>",$alg);     $alg = preg_replace("/CL2/","<431>",$alg);    $alg = preg_replace("/CL/","<432>",$alg);
    $alg = preg_replace("/CF2'/","<433>",$alg); $alg = preg_replace("/CF2-/","<433>",$alg);     $alg = preg_replace("/CF'/","<434>",$alg); $alg = preg_replace("/CF-/","<434>",$alg);     $alg = preg_replace("/CF2/","<435>",$alg);    $alg = preg_replace("/CF/","<436>",$alg);
    $alg = preg_replace("/CB2'/","<437>",$alg); $alg = preg_replace("/CB2-/","<437>",$alg);     $alg = preg_replace("/CB'/","<438>",$alg); $alg = preg_replace("/CB-/","<438>",$alg);     $alg = preg_replace("/CB2/","<439>",$alg);    $alg = preg_replace("/CB/","<440>",$alg);
    $alg = preg_replace("/CU2'/","<441>",$alg); $alg = preg_replace("/CU2-/","<441>",$alg);     $alg = preg_replace("/CU'/","<442>",$alg); $alg = preg_replace("/CU-/","<442>",$alg);     $alg = preg_replace("/CU2/","<443>",$alg);    $alg = preg_replace("/CU/","<444>",$alg);
    $alg = preg_replace("/CD2'/","<445>",$alg); $alg = preg_replace("/CD2-/","<445>",$alg);     $alg = preg_replace("/CD'/","<446>",$alg); $alg = preg_replace("/CD-/","<446>",$alg);     $alg = preg_replace("/CD2/","<447>",$alg);    $alg = preg_replace("/CD/","<448>",$alg);
    
    /* --- 5xD: SSE -> CODE: Face twists --- */
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
    /* --- 5xD: CODE -> SiGN: Wide twists --- */
    
    /* --- 5xD: CODE -> SIGN: Numbered layer twists --- */
    $alg = preg_replace("/<201>/","2BR2'",$alg);   $alg = preg_replace("/<202>/","2BR'",$alg);   $alg = preg_replace("/<203>/","2BR2",$alg);   $alg = preg_replace("/<204>/","2BR",$alg);
    $alg = preg_replace("/<205>/","2BL2'",$alg);   $alg = preg_replace("/<206>/","2BL'",$alg);   $alg = preg_replace("/<207>/","2BL2",$alg);   $alg = preg_replace("/<208>/","2BL",$alg);
    $alg = preg_replace("/<209>/","2FR2'",$alg);   $alg = preg_replace("/<210>/","2FR'",$alg);   $alg = preg_replace("/<211>/","2FR2",$alg);   $alg = preg_replace("/<212>/","2FR",$alg);
    $alg = preg_replace("/<213>/","2FL2'",$alg);   $alg = preg_replace("/<214>/","2FL'",$alg);   $alg = preg_replace("/<215>/","2FL2",$alg);   $alg = preg_replace("/<216>/","2FL",$alg);
    $alg = preg_replace("/<217>/","2DR2'",$alg);   $alg = preg_replace("/<218>/","2DR'",$alg);   $alg = preg_replace("/<219>/","2DR2",$alg);   $alg = preg_replace("/<220>/","2DR",$alg);
    $alg = preg_replace("/<221>/","2DL2'",$alg);   $alg = preg_replace("/<222>/","2DL'",$alg);   $alg = preg_replace("/<223>/","2DL2",$alg);   $alg = preg_replace("/<224>/","2DL",$alg);
    
    $alg = preg_replace("/<225>/","2R2'",$alg);    $alg = preg_replace("/<226>/","2R'",$alg);    $alg = preg_replace("/<227>/","2R2",$alg);    $alg = preg_replace("/<228>/","2R",$alg);
    $alg = preg_replace("/<229>/","2L2'",$alg);    $alg = preg_replace("/<230>/","2L'",$alg);    $alg = preg_replace("/<231>/","2L2",$alg);    $alg = preg_replace("/<232>/","2L",$alg);
    $alg = preg_replace("/<233>/","2F2'",$alg);    $alg = preg_replace("/<234>/","2F'",$alg);    $alg = preg_replace("/<235>/","2F2",$alg);    $alg = preg_replace("/<236>/","2F",$alg);
    $alg = preg_replace("/<237>/","2B2'",$alg);    $alg = preg_replace("/<238>/","2B'",$alg);    $alg = preg_replace("/<239>/","2B2",$alg);    $alg = preg_replace("/<240>/","2B",$alg);
    $alg = preg_replace("/<241>/","2U2'",$alg);    $alg = preg_replace("/<242>/","2U'",$alg);    $alg = preg_replace("/<243>/","2U2",$alg);    $alg = preg_replace("/<244>/","2U",$alg);
    $alg = preg_replace("/<245>/","2D2'",$alg);    $alg = preg_replace("/<246>/","2D'",$alg);    $alg = preg_replace("/<247>/","2D2",$alg);    $alg = preg_replace("/<248>/","2D",$alg);
    
    /* --- 5xD: CODE -> SiGN: Tier twists --- */
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
    
    /* --- 5xD: CODE -> SiGN: Dodecahedron rotations --- */
    $alg = preg_replace("/<401>/","BRv2'",$alg);   $alg = preg_replace("/<402>/","BRv'",$alg);   $alg = preg_replace("/<403>/","BRv2",$alg);   $alg = preg_replace("/<404>/","BRv",$alg);
    $alg = preg_replace("/<405>/","BLv2'",$alg);   $alg = preg_replace("/<406>/","BLv'",$alg);   $alg = preg_replace("/<407>/","BLv2",$alg);   $alg = preg_replace("/<408>/","BLv",$alg);
    $alg = preg_replace("/<409>/","FRv2'",$alg);   $alg = preg_replace("/<410>/","FRv'",$alg);   $alg = preg_replace("/<411>/","FRv2",$alg);   $alg = preg_replace("/<412>/","FRv",$alg);
    $alg = preg_replace("/<413>/","FLv2'",$alg);   $alg = preg_replace("/<414>/","FLv'",$alg);   $alg = preg_replace("/<415>/","FLv2",$alg);   $alg = preg_replace("/<416>/","FLv",$alg);
    $alg = preg_replace("/<417>/","DRv2'",$alg);   $alg = preg_replace("/<418>/","DRv'",$alg);   $alg = preg_replace("/<419>/","DRv2",$alg);   $alg = preg_replace("/<420>/","DRv",$alg);
    $alg = preg_replace("/<421>/","DLv2'",$alg);   $alg = preg_replace("/<422>/","DLv'",$alg);   $alg = preg_replace("/<423>/","DLv2",$alg);   $alg = preg_replace("/<424>/","DLv",$alg);
    
    $alg = preg_replace("/<425>/","Rv2'",$alg);    $alg = preg_replace("/<426>/","Rv'",$alg);    $alg = preg_replace("/<427>/","Rv2",$alg);    $alg = preg_replace("/<428>/","Rv",$alg);
    $alg = preg_replace("/<429>/","Lv2'",$alg);    $alg = preg_replace("/<430>/","Lv'",$alg);    $alg = preg_replace("/<431>/","Lv2",$alg);    $alg = preg_replace("/<432>/","Lv",$alg);
    $alg = preg_replace("/<433>/","Fv2'",$alg);    $alg = preg_replace("/<434>/","Fv'",$alg);    $alg = preg_replace("/<435>/","Fv2",$alg);    $alg = preg_replace("/<436>/","Fv",$alg);
    $alg = preg_replace("/<437>/","Bv2'",$alg);    $alg = preg_replace("/<438>/","Bv'",$alg);    $alg = preg_replace("/<439>/","Bv2",$alg);    $alg = preg_replace("/<440>/","Bv",$alg);
    $alg = preg_replace("/<441>/","Uv2'",$alg);    $alg = preg_replace("/<442>/","Uv'",$alg);    $alg = preg_replace("/<443>/","Uv2",$alg);    $alg = preg_replace("/<444>/","Uv",$alg);
    $alg = preg_replace("/<445>/","Dv2'",$alg);    $alg = preg_replace("/<446>/","Dv'",$alg);    $alg = preg_replace("/<447>/","Dv2",$alg);    $alg = preg_replace("/<448>/","Dv",$alg);
    
    /* --- 5xD: CODE -> SiGN: Face twists --- */
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
  * alg5xD_SiGNToSSE()$alg)
  * 
  * Converts 5x5 Gigaminx SiGN algorithms into SSE notation.
  * 
  * Parameter: $alg (STRING): The algorithm.
  * 
  * Return: STRING.
  ---------------------------------------------------------------------------------------------------
  */
  function alg5xD_SiGNToSSE($alg) {
    /* --- Dodecahedron Twists --- */
    //   +0°  = R0, []     = -360° = R5', []
    //  +72°  = R1, [R]    = -288° = R4', [R]
    // +144°  = R2, [R2]   = -216° = R3', [R2]
    // +216°  = R3, [R2']  = -144° = R2', [R2']
    // +288°  = R4, [R']   =  -72° = R1', [R']
    // +360°  = R5, []     =   -0° = R0', []
    
    /* --- 4x: Marker --- */
    $alg = str_replace(".","·",$alg);
    
    /* ··································································································· */
    /* --- 5xD: SiGN -> CODE: Wide twists --- */
    
    /* --- 5xD: SIGN -> CODE: Numbered layer twists --- */
    $alg = preg_replace("/2BR2'/","<201>",$alg);   $alg = preg_replace("/2BR'/","<202>",$alg);   $alg = preg_replace("/2BR2/","<203>",$alg);      $alg = preg_replace("/2BR/","<204>",$alg);
    $alg = preg_replace("/2BL2'/","<205>",$alg);   $alg = preg_replace("/2BL'/","<206>",$alg);   $alg = preg_replace("/2BL2/","<207>",$alg);      $alg = preg_replace("/2BL/","<208>",$alg);
    $alg = preg_replace("/2FR2'/","<209>",$alg);   $alg = preg_replace("/2FR'/","<210>",$alg);   $alg = preg_replace("/2FR2/","<211>",$alg);      $alg = preg_replace("/2FR/","<212>",$alg);
    $alg = preg_replace("/2FL2'/","<213>",$alg);   $alg = preg_replace("/2FL'/","<214>",$alg);   $alg = preg_replace("/2FL2/","<215>",$alg);      $alg = preg_replace("/2FL/","<216>",$alg);
    $alg = preg_replace("/2DR2'/","<217>",$alg);   $alg = preg_replace("/2DR'/","<218>",$alg);   $alg = preg_replace("/2DR2/","<219>",$alg);      $alg = preg_replace("/2DR/","<220>",$alg);
    $alg = preg_replace("/2DL2'/","<221>",$alg);   $alg = preg_replace("/2DL'/","<222>",$alg);   $alg = preg_replace("/2DL2/","<223>",$alg);      $alg = preg_replace("/2DL/","<224>",$alg);
    
    $alg = preg_replace("/2R2'/","<225>",$alg);    $alg = preg_replace("/2R'/","<226>",$alg);    $alg = preg_replace("/2R2/","<227>",$alg);       $alg = preg_replace("/2R/","<228>",$alg);
    $alg = preg_replace("/2L2'/","<229>",$alg);    $alg = preg_replace("/2L'/","<230>",$alg);    $alg = preg_replace("/2L2/","<231>",$alg);       $alg = preg_replace("/2L/","<232>",$alg);
    $alg = preg_replace("/2F2'/","<233>",$alg);    $alg = preg_replace("/2F'/","<234>",$alg);    $alg = preg_replace("/2F2/","<235>",$alg);       $alg = preg_replace("/2F/","<236>",$alg);
    $alg = preg_replace("/2B2'/","<237>",$alg);    $alg = preg_replace("/2B'/","<238>",$alg);    $alg = preg_replace("/2B2/","<239>",$alg);       $alg = preg_replace("/2B/","<240>",$alg);
    $alg = preg_replace("/2U2'/","<241>",$alg);    $alg = preg_replace("/2U'/","<242>",$alg);    $alg = preg_replace("/2U2/","<243>",$alg);       $alg = preg_replace("/2U/","<244>",$alg);
    $alg = preg_replace("/2D2'/","<245>",$alg);    $alg = preg_replace("/2D'/","<246>",$alg);    $alg = preg_replace("/2D2/","<247>",$alg);       $alg = preg_replace("/2D/","<248>",$alg);
    
    /* --- 5xD: SiGN -> CODE: Tier twists --- */
    
    /* --- 5xD: SiGN -> CODE: Dodecahedron rotations --- */
    $alg = preg_replace("/BRv2'/","<401>",$alg);   $alg = preg_replace("/BRv'/","<402>",$alg);   $alg = preg_replace("/BRv2/","<403>",$alg);      $alg = preg_replace("/BRv/","<404>",$alg);
    $alg = preg_replace("/BLv2'/","<405>",$alg);   $alg = preg_replace("/BLv'/","<406>",$alg);   $alg = preg_replace("/BLv2/","<407>",$alg);      $alg = preg_replace("/BLv/","<408>",$alg);
    $alg = preg_replace("/FRv2'/","<409>",$alg);   $alg = preg_replace("/FRv'/","<410>",$alg);   $alg = preg_replace("/FRv2/","<411>",$alg);      $alg = preg_replace("/FRv/","<412>",$alg);
    $alg = preg_replace("/FLv2'/","<413>",$alg);   $alg = preg_replace("/FLv'/","<414>",$alg);   $alg = preg_replace("/FLv2/","<415>",$alg);      $alg = preg_replace("/FLv/","<416>",$alg);
    $alg = preg_replace("/DRv2'/","<417>",$alg);   $alg = preg_replace("/DRv'/","<418>",$alg);   $alg = preg_replace("/DRv2/","<419>",$alg);      $alg = preg_replace("/DRv/","<420>",$alg);
    $alg = preg_replace("/DLv2'/","<421>",$alg);   $alg = preg_replace("/DLv'/","<422>",$alg);   $alg = preg_replace("/DLv2/","<423>",$alg);      $alg = preg_replace("/DLv/","<424>",$alg);
    
    $alg = preg_replace("/Rv2'/","<425>",$alg);    $alg = preg_replace("/Rv'/","<426>",$alg);    $alg = preg_replace("/Rv2/","<427>",$alg);       $alg = preg_replace("/Rv/","<428>",$alg);
    $alg = preg_replace("/Lv2'/","<429>",$alg);    $alg = preg_replace("/Lv'/","<430>",$alg);    $alg = preg_replace("/Lv2/","<431>",$alg);       $alg = preg_replace("/Lv/","<432>",$alg);
    $alg = preg_replace("/Fv2'/","<433>",$alg);    $alg = preg_replace("/Fv'/","<434>",$alg);    $alg = preg_replace("/Fv2/","<435>",$alg);       $alg = preg_replace("/Fv/","<436>",$alg);
    $alg = preg_replace("/Bv2'/","<437>",$alg);    $alg = preg_replace("/Bv'/","<438>",$alg);    $alg = preg_replace("/Bv2/","<439>",$alg);       $alg = preg_replace("/Bv/","<440>",$alg);
    $alg = preg_replace("/Uv2'/","<441>",$alg);    $alg = preg_replace("/Uv'/","<442>",$alg);    $alg = preg_replace("/Uv2/","<443>",$alg);       $alg = preg_replace("/Uv/","<444>",$alg);
    $alg = preg_replace("/Dv2'/","<445>",$alg);    $alg = preg_replace("/Dv'/","<446>",$alg);    $alg = preg_replace("/Dv2/","<447>",$alg);       $alg = preg_replace("/Dv/","<448>",$alg);
    
    /* --- 5xD: SiGN -> CODE: Face twists --- */
    $alg = preg_replace("/BR2'/","<901>",$alg);   $alg = preg_replace("/BR'/","<902>",$alg);   $alg = preg_replace("/BR2/","<903>",$alg);      $alg = preg_replace("/BR/","<904>",$alg);
    $alg = preg_replace("/BL2'/","<905>",$alg);   $alg = preg_replace("/BL'/","<906>",$alg);   $alg = preg_replace("/BL2/","<907>",$alg);      $alg = preg_replace("/BL/","<908>",$alg);
    $alg = preg_replace("/FR2'/","<909>",$alg);   $alg = preg_replace("/FR'/","<910>",$alg);   $alg = preg_replace("/FR2/","<911>",$alg);      $alg = preg_replace("/FR/","<912>",$alg);
    $alg = preg_replace("/FL2'/","<913>",$alg);   $alg = preg_replace("/FL'/","<914>",$alg);   $alg = preg_replace("/FL2/","<915>",$alg);      $alg = preg_replace("/FL/","<916>",$alg);
    $alg = preg_replace("/DR2'/","<917>",$alg);   $alg = preg_replace("/DR'/","<918>",$alg);   $alg = preg_replace("/DR2/","<919>",$alg);      $alg = preg_replace("/DR/","<920>",$alg);
    $alg = preg_replace("/DL2'/","<921>",$alg);   $alg = preg_replace("/DL'/","<922>",$alg);   $alg = preg_replace("/DL2/","<923>",$alg);      $alg = preg_replace("/DL/","<924>",$alg);
    
    /* --- 5xD: SiGN -> CODE: Tier twists --- */
    $alg = preg_replace("/br2'/","<301>",$alg);   $alg = preg_replace("/br'/","<302>",$alg);   $alg = preg_replace("/br2/","<303>",$alg);      $alg = preg_replace("/br/","<304>",$alg);
    $alg = preg_replace("/bl2'/","<305>",$alg);   $alg = preg_replace("/bl'/","<306>",$alg);   $alg = preg_replace("/bl2/","<307>",$alg);      $alg = preg_replace("/bl/","<308>",$alg);
    $alg = preg_replace("/fr2'/","<309>",$alg);   $alg = preg_replace("/fr'/","<310>",$alg);   $alg = preg_replace("/fr2/","<311>",$alg);      $alg = preg_replace("/fr/","<312>",$alg);
    $alg = preg_replace("/fl2'/","<313>",$alg);   $alg = preg_replace("/fl'/","<314>",$alg);   $alg = preg_replace("/fl2/","<315>",$alg);      $alg = preg_replace("/fl/","<316>",$alg);
    $alg = preg_replace("/dr2'/","<317>",$alg);   $alg = preg_replace("/dr'/","<318>",$alg);   $alg = preg_replace("/dr2/","<319>",$alg);      $alg = preg_replace("/dr/","<320>",$alg);
    $alg = preg_replace("/dl2'/","<321>",$alg);   $alg = preg_replace("/dl'/","<322>",$alg);   $alg = preg_replace("/dl2/","<323>",$alg);      $alg = preg_replace("/dl/","<324>",$alg);
    
    $alg = preg_replace("/R2'/","<925>",$alg);    $alg = preg_replace("/R'/","<926>",$alg);    $alg = preg_replace("/R2/","<927>",$alg);       $alg = preg_replace("/R/","<928>",$alg);
    $alg = preg_replace("/L2'/","<929>",$alg);    $alg = preg_replace("/L'/","<930>",$alg);    $alg = preg_replace("/L2/","<931>",$alg);       $alg = preg_replace("/L/","<932>",$alg);
    $alg = preg_replace("/F2'/","<933>",$alg);    $alg = preg_replace("/F'/","<934>",$alg);    $alg = preg_replace("/F2/","<935>",$alg);       $alg = preg_replace("/F/","<936>",$alg);
    $alg = preg_replace("/B2'/","<937>",$alg);    $alg = preg_replace("/B'/","<938>",$alg);    $alg = preg_replace("/B2/","<939>",$alg);       $alg = preg_replace("/B/","<940>",$alg);
    $alg = preg_replace("/U2'/","<941>",$alg);    $alg = preg_replace("/U'/","<942>",$alg);    $alg = preg_replace("/U2/","<943>",$alg);       $alg = preg_replace("/U/","<944>",$alg);
    $alg = preg_replace("/D2'/","<945>",$alg);    $alg = preg_replace("/D'/","<946>",$alg);    $alg = preg_replace("/D2/","<947>",$alg);       $alg = preg_replace("/D/","<948>",$alg);
    
    /* --- 5xD: SiGN -> CODE: Tier twists --- */
    $alg = preg_replace("/r2'/","<325>",$alg);    $alg = preg_replace("/r'/","<326>",$alg);    $alg = preg_replace("/r2/","<327>",$alg);       $alg = preg_replace("/r/","<328>",$alg);
    $alg = preg_replace("/l2'/","<329>",$alg);    $alg = preg_replace("/l'/","<330>",$alg);    $alg = preg_replace("/l2/","<331>",$alg);       $alg = preg_replace("/l/","<332>",$alg);
    $alg = preg_replace("/f2'/","<333>",$alg);    $alg = preg_replace("/f'/","<334>",$alg);    $alg = preg_replace("/f2/","<335>",$alg);       $alg = preg_replace("/f/","<336>",$alg);
    $alg = preg_replace("/b2'/","<337>",$alg);    $alg = preg_replace("/b'/","<338>",$alg);    $alg = preg_replace("/b2/","<339>",$alg);       $alg = preg_replace("/b/","<340>",$alg);
    $alg = preg_replace("/u2'/","<341>",$alg);    $alg = preg_replace("/u'/","<342>",$alg);    $alg = preg_replace("/u2/","<343>",$alg);       $alg = preg_replace("/u/","<344>",$alg);
    $alg = preg_replace("/d2'/","<345>",$alg);    $alg = preg_replace("/d'/","<346>",$alg);    $alg = preg_replace("/d2/","<347>",$alg);       $alg = preg_replace("/d/","<348>",$alg);
    
    /* --- 5xD: SiGN -> CODE: Tier twists --- */
    
    /* ··································································································· */
    /* --- 5xD: CODE -> SiGN: Wide twists --- */
    
    /* --- 5xD: CODE -> SSE: Numbered layer twists --- */
    $alg = preg_replace("/<201>/","NUR2'",$alg);   $alg = preg_replace("/<202>/","NUR'",$alg);   $alg = preg_replace("/<203>/","NUR2",$alg);   $alg = preg_replace("/<204>/","NUR",$alg);
    $alg = preg_replace("/<205>/","NUL2'",$alg);   $alg = preg_replace("/<206>/","NUL'",$alg);   $alg = preg_replace("/<207>/","NUL2",$alg);   $alg = preg_replace("/<208>/","NUL",$alg);
    $alg = preg_replace("/<209>/","NDR2'",$alg);   $alg = preg_replace("/<210>/","NDR'",$alg);   $alg = preg_replace("/<211>/","NDR2",$alg);   $alg = preg_replace("/<212>/","NDR",$alg);
    $alg = preg_replace("/<213>/","NDL2'",$alg);   $alg = preg_replace("/<214>/","NDL'",$alg);   $alg = preg_replace("/<215>/","NDL2",$alg);   $alg = preg_replace("/<216>/","NDL",$alg);
    $alg = preg_replace("/<217>/","NBR2'",$alg);   $alg = preg_replace("/<218>/","NBR'",$alg);   $alg = preg_replace("/<219>/","NBR2",$alg);   $alg = preg_replace("/<220>/","NBR",$alg);
    $alg = preg_replace("/<221>/","NBL2'",$alg);   $alg = preg_replace("/<222>/","NBL'",$alg);   $alg = preg_replace("/<223>/","NBL2",$alg);   $alg = preg_replace("/<224>/","NBL",$alg);
    
    $alg = preg_replace("/<225>/","NR2'",$alg);    $alg = preg_replace("/<226>/","NR'",$alg);    $alg = preg_replace("/<227>/","NR2",$alg);    $alg = preg_replace("/<228>/","NR",$alg);
    $alg = preg_replace("/<229>/","NL2'",$alg);    $alg = preg_replace("/<230>/","NL'",$alg);    $alg = preg_replace("/<231>/","NL2",$alg);    $alg = preg_replace("/<232>/","NL",$alg);
    $alg = preg_replace("/<233>/","NF2'",$alg);    $alg = preg_replace("/<234>/","NF'",$alg);    $alg = preg_replace("/<235>/","NF2",$alg);    $alg = preg_replace("/<236>/","NF",$alg);
    $alg = preg_replace("/<237>/","NB2'",$alg);    $alg = preg_replace("/<238>/","NB'",$alg);    $alg = preg_replace("/<239>/","NB2",$alg);    $alg = preg_replace("/<240>/","NB",$alg);
    $alg = preg_replace("/<241>/","NU2'",$alg);    $alg = preg_replace("/<242>/","NU'",$alg);    $alg = preg_replace("/<243>/","NU2",$alg);    $alg = preg_replace("/<244>/","NU",$alg);
    $alg = preg_replace("/<245>/","ND2'",$alg);    $alg = preg_replace("/<246>/","ND'",$alg);    $alg = preg_replace("/<247>/","ND2",$alg);    $alg = preg_replace("/<248>/","ND",$alg);
    
    /* --- 5xD: CODE -> SSE: Tier twists --- */
    
    /* --- 5xD: CODE -> SSE: Dodecahedron rotations --- */
    $alg = preg_replace("/<401>/","CUR2'",$alg);   $alg = preg_replace("/<402>/","CUR'",$alg);   $alg = preg_replace("/<403>/","CUR2",$alg);   $alg = preg_replace("/<404>/","CUR",$alg);
    $alg = preg_replace("/<405>/","CUL2'",$alg);   $alg = preg_replace("/<406>/","CUL'",$alg);   $alg = preg_replace("/<407>/","CUL2",$alg);   $alg = preg_replace("/<408>/","CUL",$alg);
    $alg = preg_replace("/<409>/","CDR2'",$alg);   $alg = preg_replace("/<410>/","CDR'",$alg);   $alg = preg_replace("/<411>/","CDR2",$alg);   $alg = preg_replace("/<412>/","CDR",$alg);
    $alg = preg_replace("/<413>/","CDL2'",$alg);   $alg = preg_replace("/<414>/","CDL'",$alg);   $alg = preg_replace("/<415>/","CDL2",$alg);   $alg = preg_replace("/<416>/","CDL",$alg);
    $alg = preg_replace("/<417>/","CBR2'",$alg);   $alg = preg_replace("/<418>/","CBR'",$alg);   $alg = preg_replace("/<419>/","CBR2",$alg);   $alg = preg_replace("/<420>/","CBR",$alg);
    $alg = preg_replace("/<421>/","CBL2'",$alg);   $alg = preg_replace("/<422>/","CBL'",$alg);   $alg = preg_replace("/<423>/","CBL2",$alg);   $alg = preg_replace("/<424>/","CBL",$alg);
    
    $alg = preg_replace("/<425>/","CR2'",$alg);    $alg = preg_replace("/<426>/","CR'",$alg);    $alg = preg_replace("/<427>/","CR2",$alg);    $alg = preg_replace("/<428>/","CR",$alg);
    $alg = preg_replace("/<429>/","CL2'",$alg);    $alg = preg_replace("/<430>/","CL'",$alg);    $alg = preg_replace("/<431>/","CL2",$alg);    $alg = preg_replace("/<432>/","CL",$alg);
    $alg = preg_replace("/<433>/","CF2'",$alg);    $alg = preg_replace("/<434>/","CF'",$alg);    $alg = preg_replace("/<435>/","CF2",$alg);    $alg = preg_replace("/<436>/","CF",$alg);
    $alg = preg_replace("/<437>/","CB2'",$alg);    $alg = preg_replace("/<438>/","CB'",$alg);    $alg = preg_replace("/<439>/","CB2",$alg);    $alg = preg_replace("/<440>/","CB",$alg);
    $alg = preg_replace("/<441>/","CU2'",$alg);    $alg = preg_replace("/<442>/","CU'",$alg);    $alg = preg_replace("/<443>/","CU2",$alg);    $alg = preg_replace("/<444>/","CU",$alg);
    $alg = preg_replace("/<445>/","CD2'",$alg);    $alg = preg_replace("/<446>/","CD'",$alg);    $alg = preg_replace("/<447>/","CD2",$alg);    $alg = preg_replace("/<448>/","CD",$alg);
    
    /* --- 5xD: CODE -> SSE: Face twists --- */
    $alg = preg_replace("/<901>/","UR2'",$alg);   $alg = preg_replace("/<902>/","UR'",$alg);   $alg = preg_replace("/<903>/","UR2",$alg);   $alg = preg_replace("/<904>/","UR",$alg);
    $alg = preg_replace("/<905>/","UL2'",$alg);   $alg = preg_replace("/<906>/","UL'",$alg);   $alg = preg_replace("/<907>/","UL2",$alg);   $alg = preg_replace("/<908>/","UL",$alg);
    $alg = preg_replace("/<909>/","DR2'",$alg);   $alg = preg_replace("/<910>/","DR'",$alg);   $alg = preg_replace("/<911>/","DR2",$alg);   $alg = preg_replace("/<912>/","DR",$alg);
    $alg = preg_replace("/<913>/","DL2'",$alg);   $alg = preg_replace("/<914>/","DL'",$alg);   $alg = preg_replace("/<915>/","DL2",$alg);   $alg = preg_replace("/<916>/","DL",$alg);
    $alg = preg_replace("/<917>/","BR2'",$alg);   $alg = preg_replace("/<918>/","BR'",$alg);   $alg = preg_replace("/<919>/","BR2",$alg);   $alg = preg_replace("/<920>/","BR",$alg);
    $alg = preg_replace("/<921>/","BL2'",$alg);   $alg = preg_replace("/<922>/","BL'",$alg);   $alg = preg_replace("/<923>/","BL2",$alg);   $alg = preg_replace("/<924>/","BL",$alg);
    
    /* --- 5xD: CODE -> SSE: Tier twists --- */
    $alg = preg_replace("/<301>/","TUR2'",$alg);   $alg = preg_replace("/<302>/","TUR'",$alg);   $alg = preg_replace("/<303>/","TUR2",$alg);   $alg = preg_replace("/<304>/","TUR",$alg);
    $alg = preg_replace("/<305>/","TUL2'",$alg);   $alg = preg_replace("/<306>/","TUL'",$alg);   $alg = preg_replace("/<307>/","TUL2",$alg);   $alg = preg_replace("/<308>/","TUL",$alg);
    $alg = preg_replace("/<309>/","TDR2'",$alg);   $alg = preg_replace("/<310>/","TDR'",$alg);   $alg = preg_replace("/<311>/","TDR2",$alg);   $alg = preg_replace("/<312>/","TDR",$alg);
    $alg = preg_replace("/<313>/","TDL2'",$alg);   $alg = preg_replace("/<314>/","TDL'",$alg);   $alg = preg_replace("/<315>/","TDL2",$alg);   $alg = preg_replace("/<316>/","TDL",$alg);
    $alg = preg_replace("/<317>/","TBR2'",$alg);   $alg = preg_replace("/<318>/","TBR'",$alg);   $alg = preg_replace("/<319>/","TBR2",$alg);   $alg = preg_replace("/<320>/","TBR",$alg);
    $alg = preg_replace("/<321>/","TBL2'",$alg);   $alg = preg_replace("/<322>/","TBL'",$alg);   $alg = preg_replace("/<323>/","TBL2",$alg);   $alg = preg_replace("/<324>/","TBL",$alg);
    
    /* --- 5xD: CODE -> SSE: Face twists --- */
    $alg = preg_replace("/<925>/","R2'",$alg);    $alg = preg_replace("/<926>/","R'",$alg);    $alg = preg_replace("/<927>/","R2",$alg);    $alg = preg_replace("/<928>/","R",$alg);
    $alg = preg_replace("/<929>/","L2'",$alg);    $alg = preg_replace("/<930>/","L'",$alg);    $alg = preg_replace("/<931>/","L2",$alg);    $alg = preg_replace("/<932>/","L",$alg);
    $alg = preg_replace("/<933>/","F2'",$alg);    $alg = preg_replace("/<934>/","F'",$alg);    $alg = preg_replace("/<935>/","F2",$alg);    $alg = preg_replace("/<936>/","F",$alg);
    $alg = preg_replace("/<937>/","B2'",$alg);    $alg = preg_replace("/<938>/","B'",$alg);    $alg = preg_replace("/<939>/","B2",$alg);    $alg = preg_replace("/<940>/","B",$alg);
    $alg = preg_replace("/<941>/","U2'",$alg);    $alg = preg_replace("/<942>/","U'",$alg);    $alg = preg_replace("/<943>/","U2",$alg);    $alg = preg_replace("/<944>/","U",$alg);
    $alg = preg_replace("/<945>/","D2'",$alg);    $alg = preg_replace("/<946>/","D'",$alg);    $alg = preg_replace("/<947>/","D2",$alg);    $alg = preg_replace("/<948>/","D",$alg);
    
    /* --- 5xD: CODE -> SSE: Tier twists --- */
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
  * alg_SiGNtoTwizzle($alg)
  * 
  * Converts SiGN algorithm into Twizzle alg parameter.
  * 
  * Parameter: $alg (STRING): The algorithm.
  * 
  * Return: STRING.
  ---------------------------------------------------------------------------------------------------
  */
  function alg_SiGNtoTwizzle($alg) {
    $a = array(" ", "'",   "(",   ")",  "[",    "]",   ",",   ":",   "/");
    $b = array("+", "%27", "%28", "%29", "%5B", "%5D", "%2C", "%3A", "%2F");
    $alg = str_replace($a, $b, $alg);
    
    $alg = preg_replace("/\r\n/","%0A",$alg); // Zeilenschaltung
    
    return $alg;
  }
  
  
  
  
  /* --------------------------------------------------------------------------------------------------- */
  /* --- Check Input A --- */
  $input_errA = false; // Fehler Eingabe A.
  
  
  // Check puzzle (Pflicht)
  $in{'puzzle'} = stripslashes(getPar("puzzle"));
  $in{'puzzle'} = preg_replace('/[^0-9]/', '', $in{'puzzle'}); //   Alle Zeichen ausser 0-9 entfernen.
  if ($in{'puzzle'} == "") {                                   //   Wenn puzzle == "":
    $input_errA = true;                                        //     puzzle darf nicht leer "" sein.
  } elseif ($in{'puzzle'} == "0") {                            //   Wenn puzzle == "0":
    $in{'puzzle'} = "";                                        //     Wert 0 durch "" ersetzen.
    $input_errA = true;                                        //     puzzle darf nicht leer "" sein.
  } else {                                                     //   Sonst (puzzle != ""):
    if ($in{'puzzle'} < 1) {$in{'puzzle'} = 1;}                //     puzzle darf nicht kleiner als 1 sein.
    if ($in{'puzzle'} > 5) {$in{'puzzle'} = 5;}                //     puzzle darf nicht grösser als 5 sein.
  }
  
  
  // Check notation (Pflicht)
  $in{'notation'} = stripslashes(getPar("notation"));
  if ($in{'notation'} != "sign") {$in{'notation'} = "sse";} // Akzeptierte Werte: 'sign', 'sse' (Default).
  
  // Check alg (Pflicht)
  $in{'alg'} = stripslashes(getPar("alg"));
  
  
  // Translate Algorithms
  if ($in{'puzzle'} == 1) {                       // Bei 3x3 Pyraminx:
    if ($in{'notation'} == "sign") {              //   Bei SiGN:
      $out{'alg'} = $in{'alg'};                   //     OUT  = SiGN
      $alg_SSE    = alg3xP_SiGNToSSE($in{'alg'}); //     SSE  = SiGN --> SSE
      $alg_SiGN   = $in{'alg'};                   //     SiGN = SiGN
    } else {                                      //   Sonst (SSE):
      $out{'alg'} = alg3xP_SSEToSiGN($in{'alg'}); //     OUT  = SSE --> SiGN
      $alg_SSE    = $in{'alg'};                   //     SSE  = SSE
      $alg_SiGN   = alg3xP_SSEToSiGN($in{'alg'}); //     SiGN = SSE --> SiGN
    }
  } elseif ($in{'puzzle'} == 2) {                 // Bei 4x4 Master Pyraminx:
    if ($in{'notation'} == "sign") {              //   Bei SiGN:
      $out{'alg'} = $in{'alg'};                   //     OUT  = SiGN
      $alg_SSE    = alg4xP_SiGNToSSE($in{'alg'}); //     SSE  = SiGN --> SSE
      $alg_SiGN   = $in{'alg'};                   //     SiGN = SiGN
    } else {                                      //   Sonst (SSE):
      $out{'alg'} = alg4xP_SSEToSiGN($in{'alg'}); //     OUT  = SSE --> SiGN
      $alg_SSE    = $in{'alg'};                   //     SSE  = SSE
      $alg_SiGN   = alg4xP_SSEToSiGN($in{'alg'}); //     SiGN = SSE --> SiGN
    }
  } elseif ($in{'puzzle'} == 3) {                 // Bei 5x5 Professor Pyraminx:
    if ($in{'notation'} == "sign") {              //   Bei SiGN:
      $out{'alg'} = $in{'alg'};                   //     OUT  = SiGN
      $alg_SSE    = alg5xP_SiGNToSSE($in{'alg'}); //     SSE  = SiGN --> SSE
      $alg_SiGN   = $in{'alg'};                   //     SiGN = SiGN
    } else {                                      //   Sonst (SSE):
      $out{'alg'} = alg5xP_SSEToSiGN($in{'alg'}); //     OUT  = SSE --> SiGN
      $alg_SSE    = $in{'alg'};                   //     SSE  = SSE
      $alg_SiGN   = alg5xP_SSEToSiGN($in{'alg'}); //     SiGN = SSE --> SiGN
    }

  } elseif ($in{'puzzle'} == 4) {                 // Bei 3x3 Megaminx:
    if ($in{'notation'} == "sign") {              //   Bei SiGN:
      $out{'alg'} = $in{'alg'};                   //     OUT  = SiGN
      $alg_SSE    = alg3xD_SiGNToSSE($in{'alg'}); //     SSE  = SiGN --> SSE
      $alg_SiGN   = $in{'alg'};                   //     SiGN = SiGN
    } else {                                      //   Sonst (SSE):
      $out{'alg'} = alg3xD_SSEToSiGN($in{'alg'}); //     OUT  = SSE --> SiGN
      $alg_SSE    = $in{'alg'};                   //     SSE  = SSE
      $alg_SiGN   = alg3xD_SSEToSiGN($in{'alg'}); //     SiGN = SSE --> SiGN
    }
  } elseif ($in{'puzzle'} == 5) {                 // Bei 5x5 Gigaminx:
    if ($in{'notation'} == "sign") {              //   Bei SiGN:
      $out{'alg'} = $in{'alg'};                   //     OUT  = SiGN
      $alg_SSE    = alg5xD_SiGNToSSE($in{'alg'}); //     SSE  = SiGN --> SSE
      $alg_SiGN   = $in{'alg'};                   //     SiGN = SiGN
    } else {                                      //   Sonst (SSE):
      $out{'alg'} = alg5xD_SSEToSiGN($in{'alg'}); //     OUT  = SSE --> SiGN
      $alg_SSE    = $in{'alg'};                   //     SSE  = SSE
      $alg_SiGN   = alg5xD_SSEToSiGN($in{'alg'}); //     SiGN = SSE --> SiGN
    }
  } else {                                        // Sonst:
    $out{'alg'} = "";                             //   ""
    $alg_SSE    = "";                             //   ""
    $alg_SiGN   = "";                             //   ""
  }
  
  // Get Twizzle Algorithm
  $alg_TW = alg_SiGNtoTwizzle($out{'alg'});       // SiGN in Twizzle konvertieren
  
  
  // Get Twizzle Link
  if ($in{'puzzle'} != "") {
    $tw_link  = "https://". $tw_homepage;
    $tw_link .= "?puzzle=". $puz_param[$in{'puzzle'}];
    $tw_link .= "&alg=". $alg_TW;
  } else {
    $tw_link = "";
  }
  
  
  
  /* --- Text Variables --- */
  $hea_form         = "Twister";
  
  $but_update       = "Update";
  $but_show         = "Display";
  
  $par_pyraminx3    = "pyraminx";           // Twizzle: puzzle parameter: 3x3 Pyraminx
  $par_pyraminx4    = "master+pyraminx";    // Twizzle: puzzle parameter: 4x4 Master Pyraminx
  $par_pyraminx5    = "professor+pyraminx"; // Twizzle: puzzle parameter: 5x5 Professor Pyraminx
  $par_megaminx3    = "megaminx";           // Twizzle: puzzle parameter: 3x3 Megaminx
  
  $txt_puzzle       = "Puzzle";
  $hlp_puzzle       = "Choose a twisty puzzle";
  
  $txt_notation     = "Notation";
  $hlp_notation     = "Choose a notation";
  $txt_notationSSE  = "Notation SSE";
  $txt_notationSiGN = "Notation Twizzle";
  
  $txt_alg          = "Algorithm";
  $hlp_alg          = "Algorithm";
  
  $txt_algSSE       = "Algorithm SSE";
  $hlp_algSSE       = "Algorithm";
  
  $txt_algSiGN      = "Algorithm Twizzle";
  $hlp_algSiGN      = "Algorithm";
  
  $txt_linkTW       = "Link Twizzle Explorer";
  
  

  /* *************************************************************************************************** */
  print "<!DOCTYPE html>\n";
  print "<html lang=\"en\" class=\"pagestatus-init\" style=\"overflow:auto;\">\n"; # iframe: displays scrollbar only when necessary
  print "\n";
  print "\n";
  
  
  /* --- TITLE: Seitentitel --- */
  print "<head>\n";
  print "  <title>". $hea_form ."</title>\n";
  print "  \n";
  
  
  /* --- META: Meta-Daten --- */
  print "  <meta name=\"Description\" content=\"". $mta_description ."\" />\n";
  print "  <meta name=\"Keywords\" content=\"". $mta_keywords ."\" />\n";
  print "  <meta name=\"Robots\" content=\"index, noodp\" />\n";
  print "  <meta charset=\"UTF-8\" />\n";
  print "  <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\"/>\n";
  print "  <!--[if IE]><meta http-equiv=\"x-ua-compatible\" content=\"IE=edge\" /><![endif]-->\n";
  print "  <meta name=\"format-detection\" content=\"telephone=no\"/>\n";
  print "  \n";
  
  
  /* --- CSS --- */
  print "  <!-- CSS BEGIN -->\n";
  print "  <link rel=\"stylesheet\" type=\"text/css\" href=\"". $cssDir ."/". $cssFile ."\"/>\n";
  print "  <!-- CSS END -->\n";
  
  
  /* --- JavaScript --- */
  
  
  print "</head>\n";
  print "\n";
  print "\n";
  print "<body>\n";
  print "  <div id=\"blockPage\">\n";
  print "    <div id=\"blockPageInner\">\n";
  print "      \n";
  
  
  /* --- header BEGIN --- */
  print "      <!-- header BEGIN -->\n";
  print "      <!-- header END -->\n";
  /* --- header END --- */
  print "      \n";
  print "      \n";
  
  
  
  
  /* --- blockBody BEGIN --- */
  print "      <!-- blockBody BEGIN -->\n";
  print "      <div id=\"blockBody\">\n";
  print "        <div id=\"blockBodyBefore\">\n";
  print "          <div id=\"blockBodyBeforeInner\"></div>\n";
  print "        </div>\n";
  print "        \n";
  print "        <div id=\"blockBodyInner\">\n";
  print "          <div id=\"blockMain\">\n";
  print "            <div id=\"blockMainInner\">\n";
  print "              <div id=\"blockContent\">\n";
  print "                <div id=\"blockContentInner\">\n";
  print "                  \n";
  print "                  \n";
  
  
  /* --- CONTENT:START --- */
  print "<!--CONTENT:START-->\n";
  /* *************************************************************************************************** */
  
  print "<div id=\"blockCGIForm\">\n";
  print "  \n";
  
  /* --- Headline: Twizzle Twister --- */
  print "  <!-- Headline: h1 -->\n";
  print "  <div class=\"elementHeadline elementHeadlineAlign_var0 elementHeadline_var0 elementHeadlineLevel_varauto\" id=\"anchor_". postSlugTitle($hea_form) ."\">\n";
  print "    <h1>". $hea_form ." <small>v". $cgiVersion."</small></h1>\n";
  print "  </div>\n";
  print "  \n";
  print "  \n";
  
  
  /* --- Text --- */
  //print "  <!-- Text -->\n";
  //print "  <div class=\"elementText elementText_var0 elementTextListStyle_var0\">\n";
  //print "    <p>\n";
  //print "      ". "Lorem ipsum" ."<br/>\n";
  //print "    </p>\n";
  //print "  </div>\n";
  //print "  \n";
  //print "  \n";
  
  
  /* ---     --- */
  print "  <!-- Leerzeile -->\n";
  print "  <div class=\"elementClearer\"> </div>\n";
  print "  <div class=\"elementClearerWithSpace spacer1\"> </div>\n";
  print "  \n";
  print "  \n";
  
  
  /* --- 01 Debug --- */
  if ($debugmode == "true") {
    print "  <!-- Text: Debug -->\n";
    print "  <div class=\"elementText elementText_var0 elementTextListStyle_var0\" style=\"overflow-wrap:break-word;\">\n";
    print "    <p>\n";
    print "      Input Error A: [". $input_errA ."]<br/>\n";
    print "      puzzle: [". $in{'puzzle'} ."]<br/>\n";
    print "      alg IN: [". $in{'alg'} ."]<br/>\n";
    print "      alg OUT: [". $out{'alg'} ."]<br/>\n";
    print "      TW: [". $alg_TW ."]<br/>\n";
    print "    </p>\n";
    print "  </div>\n";
    print "  \n";
    print "  \n";
  }
  
  
  /* --- Formular BEGIN --- */
  print "  <!-- Formular BEGIN -->\n";
  print "  <div class=\"elementStandard elementContent elementForm elementForm_var0\">\n";
  print "    <form id=\"FormA\" name=\"\" method=\"post\" action=\"". $cgiFile ."\" target=\"\">\n";
  print "      \n";
  
  
  /* --- 01 Puzzle (Select, Pflicht) --- */
  if ($in{'puzzle'} == "") {$err_class = "wglIsInvalid";} else {$err_class = "wglIsNeutral";}
  
  print "      <!-- Puzzle (Select) BEGIN -->\n";
  print "      <div class=\"formElement formElementInput\">\n";
  print "        <!-- Label: Puzzle -->\n";
  print "        <div>\n";
  print "          <label \n";
  print "            class=\"XXL ". $err_class ."\" \n";
  print "            for=\"puzzle\" \n";
  print "            >". $txt_puzzle ."<span class=\"formLabelStar\">*</span></label\n";
  print "          >\n";
  print "        </div>\n";
  print "        \n";
  
  print "        <!-- Select: Puzzle -->\n";
  print "        <div>\n";
  print "          <select \n";
  print "            class=\"XXL ". $err_class ."\" \n";
  print "            name=\"puzzle\" \n";
  print "            id=\"puzzle\" \n";
  print "            onChange='document.forms[\"FormA\"].submit();' \n";
  print "          >\n";
  
  print "            <option value=\"\">- ". $hlp_puzzle ." -</option>\n";
  
  foreach ($puz_list as $key => $val) {
    if ($in{'puzzle'} == $key) {print "            <option value=\"". $key ."\" selected=\"selected\">". $val ."</option>\n";} else {print "            <option value=\"". $key ."\">". $val ."</option>\n";}
  }
  
  print "          </select>\n";
  print "        </div>\n";
  print "      </div>\n";
  print "      <!-- Puzzle (Select) END -->\n";
  print "      \n";
  print "      \n";
  
  
  /* --- 01 Notation (Select, Pflicht) --- */
  if ($in{'notation'} == "") {$err_class = "wglIsInvalid";} else {$err_class = "wglIsNeutral";}
  
  print "      <!-- Notation (Select) BEGIN -->\n";
  print "      <div class=\"formElement formElementInput\">\n";
  print "        <!-- Label: Notation -->\n";
  print "        <div>\n";
  print "          <label \n";
  print "            class=\"XXL ". $err_class ."\" \n";
  print "            for=\"notation\" \n";
  print "            >". $txt_notation ."<span class=\"formLabelStar\">*</span></label\n";
  print "          >\n";
  print "        </div>\n";
  print "        \n";
  
  print "        <!-- Select: Notation -->\n";
  print "        <div>\n";
  print "          <select \n";
  print "            class=\"XXL ". $err_class ."\" \n";
  print "            name=\"notation\" \n";
  print "            id=\"notation\" \n";
  print "            onChange='document.forms[\"FormA\"].submit();' \n";
  print "          >\n";
  
  print "            <option value=\"\">- ". $hlp_notation ." -</option>\n";
  
  if ($in{'notation'} == "sse")  {print "            <option value=\"sse\" selected=\"selected\">". $txt_notationSSE ."</option>\n";}   else {print "            <option value=\"sse\">". $txt_notationSSE ."</option>\n";}
  if ($in{'notation'} == "sign") {print "            <option value=\"sign\" selected=\"selected\">". $txt_notationSiGN ."</option>\n";} else {print "            <option value=\"sign\">". $txt_notationSiGN ."</option>\n";}
  
  print "          </select>\n";
  print "        </div>\n";
  print "      </div>\n";
  print "      <!-- Puzzle (Select) END -->\n";
  print "      \n";
  print "      \n";
  
  
  /* --- 01 Algorithm IN (Textarea, Pflicht) --- */
  if ($in{'alg'} == "") {$err_class = "wglIsInvalid";} else {$err_class = "wglIsNeutral";}
  
  print "    <!-- Algorithm IN (Textarea) BEGIN -->\n";
  print "    <div class=\"formElement formElementInput\">\n";
  print "      <!-- Label: Algorithm IN -->\n";
  print "      <div>\n";
  print "        <label \n";
  print "          class=\"XXL ". $err_class ."\"\n";
  print "          for=\"alg\" \n";
  print "          >". $txt_alg ." ". $notation[$in{'notation'}] ."<span class=\"formLabelStar\">*</span></label\n";
  print "        >\n";
  print "      </div>\n";
  print "      \n";
  
  print "      <!-- Textarea: Algorithm IN -->\n";
  print "      <div>\n";
  print "        <textarea \n";
  print "          class=\"XXL ". $err_class ."\" \n";
  print "          name=\"alg\" \n";
  print "          id=\"alg\" \n";
  print "          maxlength=\"\" \n";
  print "          rows=\"5\" \n";
  print "          cols=\"\" \n";
  print "          wrap=\"virtual\" \n";
  print "          placeholder=\"". $txt_alg ."\" \n";
  //print "          onChange='document.forms[\"FormA\"].submit();' \n";
  print "          >". $in{'alg'} ."</textarea\n";
  print "        >\n";
  print "      </div>\n";
  print "    </div>\n";
  print "    <!-- Algorithm IN (Textarea) END -->\n";
  print "    \n";
  print "    \n";
  
  
  /* --- 01 Buttons: Update --- */
  print "    <!-- Buttons -->\n";
  print "    <div class=\"formElement formElementButton\">\n";
  print "      <div>\n";
  
  /* --- Button Display --- */
  if ($in{'puzzle'} != "") {
    print "        <a class=\"linkButtonNeutral\" href=\"". $tw_link ."\" target=\"_blank\">". $but_show ."</a>\n";
  }
  
  /* --- Button Update --- */
  print "        <button type=\"submit\" class=\"button\" onclick=\"submit();\">". $but_update ."</button>\n";
  
  print "      </div>\n";
  print "    </div>\n";
  print "    \n";
  print "    \n";
  
  
  /* ··································································································· */
  /* --- 01 Algorithm (Textarea) --- */
  $err_class = "wglIsNeutral";
  
  if ($in{'notation'} == "sign") {
    $tmp_txt = $txt_algSSE;
    $tmp_alg = $alg_SSE;
  } else {
    $tmp_txt = $txt_algSiGN;
    $tmp_alg = $alg_SiGN;
  }
  
  print "    <!-- Algorithm OUT (Textarea) BEGIN -->\n";
  print "    <div class=\"formElement formElementInput\">\n";
  print "      <!-- Label: Algorithm OUT -->\n";
  print "      <div>\n";
  print "        <label \n";
  print "          class=\"XXL ". $err_class ."\"\n";
  print "          for=\"algOUT\" \n";
  print "          >". $tmp_txt ."<span class=\"formLabelStar\"></span></label\n";
  print "        >\n";
  print "      </div>\n";
  print "      \n";
  
  print "      <!-- Textarea: Algorithm OUT -->\n";
  print "      <div>\n";
  print "        <textarea \n";
  print "          class=\"XXL ". $err_class ."\" \n";
  print "          name=\"algOUT\" \n";
  print "          id=\"algOUT\" \n";
  print "          maxlength=\"\" \n";
  print "          rows=\"5\" \n";
  print "          cols=\"\" \n";
  print "          wrap=\"virtual\" \n";
  print "          placeholder=\"". $txt_alg ."\" \n";
  //print "          onChange='document.forms[\"FormA\"].submit();' \n";
  print "          >". $tmp_alg ."</textarea\n";
  print "        >\n";
  print "      </div>\n";
  print "    </div>\n";
  print "    <!-- Algorithm OUT (Textarea) END -->\n";
  print "    \n";
  print "    \n";
  
  
  /* --- 01 Twizzle Twister Link (Textarea) --- */
  $err_class = "wglIsNeutral";
  
  print "    <!-- Twizzle Twister Link (Textarea) BEGIN -->\n";
  print "    <div class=\"formElement formElementInput\">\n";
  print "      <!-- Label: Twizzle Twister Link -->\n";
  print "      <div>\n";
  print "        <label \n";
  print "          class=\"XXL ". $err_class ."\"\n";
  print "          for=\"linkTW\" \n";
  print "          >". $txt_linkTW ."<span class=\"formLabelStar\"></span></label\n";
  print "        >\n";
  print "      </div>\n";
  print "      \n";
  
  print "      <!-- Textarea: Twizzle Twister Link -->\n";
  print "      <div>\n";
  print "        <textarea \n";
  print "          class=\"XXL ". $err_class ."\" \n";
  print "          name=\"linkTW\" \n";
  print "          id=\"linkTW\" \n";
  print "          maxlength=\"\" \n";
  print "          rows=\"3\" \n";
  print "          cols=\"\" \n";
  print "          wrap=\"virtual\" \n";
  print "          placeholder=\"". $txt_algSiGN ."\" \n";
  //print "          onChange='document.forms[\"FormA\"].submit();' \n";
  print "          >". $tw_link."</textarea\n";
  print "        >\n";
  print "      </div>\n";
  print "    </div>\n";
  print "    <!-- Twizzle Twister Link (Textarea) END -->\n";
  print "    \n";
  print "    \n";
  
  
  print "    </form>\n";
  print "  </div>\n";
  print "  <!-- Formular END -->\n";
  /* --- Formular END --- */
  print "  \n";
  print "  \n";
    
  print "</div>\n";
  
  /* *************************************************************************************************** */
  print "<!--CONTENT:STOP-->\n";
  
  
  print "                  \n";
  print "                  \n";
  print "                  <!-- blockAfter BEGIN -->\n";
  print "                  <div id=\"blockAfter\">\n";
  print "                    <div id=\"blockAfterInner\">\n";
  print "                      <!--CONTENT:START-->\n";
  print "                      <!--CONTENT:STOP-->\n";
  print "                    </div>\n";
  print "                  </div>\n";
  print "                  <!-- blockAfter END -->\n";
  print "                  \n";
  print "                  \n";
  print "                </div>\n";
  print "              </div>\n";
  print "            </div>\n";
  print "          </div>\n";
  print "        </div>\n";
  print "      </div>\n";
  print "      <!-- blockBody END -->\n";
  /* --- blockBody END --- */
  print "      \n";
  print "      \n";
  
  
  
  
  /* --- footer BEGIN --- */
  /* --- footer END --- */
  print "      \n";
  print "      \n";
  
  
  
  
  print "    </div>\n";
  print "  </div>\n";
  print "  \n";
  print "  \n";
  
  
  print "</body>\n";
  print "</html>\n";
?>
