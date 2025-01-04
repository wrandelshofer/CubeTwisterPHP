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
  $cgiFile           = "index_v000-001-002.php"; // Name dieses CGIs.
  $cgiVersion        = "0.1.2"; // CGI-Version.
  
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
    "sign" => "SiGN"
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
    
    /* ··································································································· */
    /* --- 3xP: SSE -> CODE: Mid-layer twists --- */
    $alg = preg_replace("/MU'/","<101>",$alg); $alg = preg_replace("/MU/","<102>",$alg);
    $alg = preg_replace("/MR'/","<103>",$alg); $alg = preg_replace("/MR/","<104>",$alg);
    $alg = preg_replace("/ML'/","<105>",$alg); $alg = preg_replace("/ML/","<106>",$alg);
    $alg = preg_replace("/MB'/","<107>",$alg); $alg = preg_replace("/MB/","<108>",$alg);
    
    /* --- 3xP: SSE -> CODE: Tier twists --- */
    $alg = preg_replace("/TU'/","<201>",$alg); $alg = preg_replace("/TU/","<202>",$alg);
    $alg = preg_replace("/TR'/","<203>",$alg); $alg = preg_replace("/TR/","<204>",$alg);
    $alg = preg_replace("/TL'/","<205>",$alg); $alg = preg_replace("/TL/","<206>",$alg);
    $alg = preg_replace("/TB'/","<207>",$alg); $alg = preg_replace("/TB/","<208>",$alg);
    
    /* --- 3xP: SSE -> CODE: Pyramid rotations --- */
    $alg = preg_replace("/CU'/","<301>",$alg); $alg = preg_replace("/CU/","<302>",$alg);
    $alg = preg_replace("/CR'/","<303>",$alg); $alg = preg_replace("/CR/","<304>",$alg);
    $alg = preg_replace("/CL'/","<305>",$alg); $alg = preg_replace("/CL/","<306>",$alg);
    $alg = preg_replace("/CB'/","<307>",$alg); $alg = preg_replace("/CB/","<308>",$alg);
    
    /* --- 3xP: SSE -> CODE: Corner twists --- */
    $alg = preg_replace("/U'/","<401>",$alg); $alg = preg_replace("/U/","<402>",$alg);
    $alg = preg_replace("/R'/","<403>",$alg); $alg = preg_replace("/R/","<404>",$alg);
    $alg = preg_replace("/L'/","<405>",$alg); $alg = preg_replace("/L/","<406>",$alg);
    $alg = preg_replace("/B'/","<407>",$alg); $alg = preg_replace("/B/","<408>",$alg);
    
    /* ··································································································· */
    /* --- 3xP: CODE -> SiGN: Mid-layer twists --- */
    $alg = preg_replace("/<101>/","2D",$alg); $alg = preg_replace("/<102>/","2D'",$alg);
    $alg = preg_replace("/<103>/","2L",$alg); $alg = preg_replace("/<104>/","2L'",$alg);
    $alg = preg_replace("/<105>/","2R",$alg); $alg = preg_replace("/<106>/","2R'",$alg);
    $alg = preg_replace("/<107>/","2F",$alg); $alg = preg_replace("/<108>/","2F'",$alg);
    
    /* --- 3xP: CODE -> SiGN: Tier twists --- */
    $alg = preg_replace("/<201>/","flr'",$alg); $alg = preg_replace("/<202>/","flr",$alg);
    $alg = preg_replace("/<203>/","frd'",$alg); $alg = preg_replace("/<204>/","frd",$alg);
    $alg = preg_replace("/<205>/","fdl'",$alg); $alg = preg_replace("/<206>/","fdl",$alg);
    $alg = preg_replace("/<207>/","drl'",$alg); $alg = preg_replace("/<208>/","drl",$alg);
    
    /* --- 3xP: CODE -> SiGN: Pyramid rotations --- */
    $alg = preg_replace("/<301>/","Dv",$alg); $alg = preg_replace("/<302>/","Dv'",$alg);
    $alg = preg_replace("/<303>/","Lv",$alg); $alg = preg_replace("/<304>/","Lv'",$alg);
    $alg = preg_replace("/<305>/","Rv",$alg); $alg = preg_replace("/<306>/","Rv'",$alg);
    $alg = preg_replace("/<307>/","Fv",$alg); $alg = preg_replace("/<308>/","Fv'",$alg);
    
    /* --- 3xP: CODE -> SiGN: Corner twists --- */
    $alg = preg_replace("/<401>/","3D",$alg); $alg = preg_replace("/<402>/","3D'",$alg);
    $alg = preg_replace("/<403>/","3L",$alg); $alg = preg_replace("/<404>/","3L'",$alg);
    $alg = preg_replace("/<405>/","3R",$alg); $alg = preg_replace("/<406>/","3R'",$alg);
    $alg = preg_replace("/<407>/","3F",$alg); $alg = preg_replace("/<408>/","3F'",$alg);
    
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
    
    /* ··································································································· */
    /* --- 4xP: SSE -> CODE: Wide-layer twists --- */
    $alg = preg_replace("/WU'/","<101>",$alg); $alg = preg_replace("/WU/","<102>",$alg);
    $alg = preg_replace("/WR'/","<103>",$alg); $alg = preg_replace("/WR/","<104>",$alg);
    $alg = preg_replace("/WL'/","<105>",$alg); $alg = preg_replace("/WL/","<106>",$alg);
    $alg = preg_replace("/WB'/","<107>",$alg); $alg = preg_replace("/WB/","<108>",$alg);
    
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
    
    /* ··································································································· */
    /* --- 5xP: SSE -> CODE: Wide-layer twists --- */
    $alg = preg_replace("/WU'/","<101>",$alg); $alg = preg_replace("/WU-/","<101>",$alg);   $alg = preg_replace("/WU/","<102>",$alg);
    $alg = preg_replace("/WR'/","<103>",$alg); $alg = preg_replace("/WR-/","<103>",$alg);   $alg = preg_replace("/WR/","<104>",$alg);
    $alg = preg_replace("/WL'/","<105>",$alg); $alg = preg_replace("/WL-/","<105>",$alg);   $alg = preg_replace("/WL/","<106>",$alg);
    $alg = preg_replace("/WB'/","<107>",$alg); $alg = preg_replace("/WB-/","<107>",$alg);   $alg = preg_replace("/WB/","<108>",$alg);
    
    /* --- 5xP: SSE -> CODE: Numbered layer twists --- */
    $alg = preg_replace("/N3-4U'/","<201>",$alg); $alg = preg_replace("/N3-4U-/","<201>",$alg);   $alg = preg_replace("/N3-4U/","<202>",$alg);
    $alg = preg_replace("/N3-4R'/","<203>",$alg); $alg = preg_replace("/N3-4R-/","<203>",$alg);   $alg = preg_replace("/N3-4R/","<204>",$alg);
    $alg = preg_replace("/N3-4L'/","<205>",$alg); $alg = preg_replace("/N3-4L-/","<205>",$alg);   $alg = preg_replace("/N3-4L/","<206>",$alg);
    $alg = preg_replace("/N3-4B'/","<207>",$alg); $alg = preg_replace("/N3-4B-/","<207>",$alg);   $alg = preg_replace("/N3-4B/","<208>",$alg);
    
    $alg = preg_replace("/N2-3U'/","<209>",$alg); $alg = preg_replace("/N2-3U-/","<209>",$alg);   $alg = preg_replace("/N2-3U/","<210>",$alg);
    $alg = preg_replace("/N2-3R'/","<211>",$alg); $alg = preg_replace("/N2-3R-/","<211>",$alg);   $alg = preg_replace("/N2-3R/","<212>",$alg);
    $alg = preg_replace("/N2-3L'/","<213>",$alg); $alg = preg_replace("/N2-3L-/","<213>",$alg);   $alg = preg_replace("/N2-3L/","<214>",$alg);
    $alg = preg_replace("/N2-3B'/","<215>",$alg); $alg = preg_replace("/N2-3B-/","<215>",$alg);   $alg = preg_replace("/N2-3B/","<216>",$alg);
    
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
      $alg_SSE    = "";                           //*    SSE  = SiGN --> SSE
      $alg_SiGN   = $in{'alg'};                   //     SiGN = SiGN
    } else {                                      //   Sonst (SSE):
      $out{'alg'} = alg3xP_SSEToSiGN($in{'alg'}); //     OUT  = SSE --> SiGN
      $alg_SSE    = $in{'alg'};                   //     SSE  = SSE
      $alg_SiGN   = alg3xP_SSEToSiGN($in{'alg'}); //     SiGN = SSE --> SiGN
    }
  } elseif ($in{'puzzle'} == 2) {                 // Bei 4x4 Master Pyraminx:
    if ($in{'notation'} == "sign") {              //   Bei SiGN:
      $out{'alg'} = $in{'alg'};                   //     SiGN
      $alg_SSE    = "";                           //*    SSE  = SiGN --> SSE
      $alg_SiGN   = $in{'alg'};                   //     SiGN = SiGN
    } else {                                      //   Sonst (SSE):
      $out{'alg'} = alg4xP_SSEToSiGN($in{'alg'}); //     OUT  = SSE --> SiGN
      $alg_SSE    = $in{'alg'};                   //     SSE  = SSE
      $alg_SiGN   = alg4xP_SSEToSiGN($in{'alg'}); //     SiGN = SSE --> SiGN
    }
  } elseif ($in{'puzzle'} == 3) {                 // Bei 5x5 Professor Pyraminx:
    if ($in{'notation'} == "sign") {              //   Bei SiGN:
      $out{'alg'} = $in{'alg'};                   //     SiGN
      $alg_SSE    = "";                           //*    SSE  = SiGN --> SSE
      $alg_SiGN   = $in{'alg'};                   //     SiGN = SiGN
    } else {                                      //   Sonst (SSE):
      $out{'alg'} = alg5xP_SSEToSiGN($in{'alg'}); //     OUT  = SSE --> SiGN
      $alg_SSE    = $in{'alg'};                   //     SSE  = SSE
      $alg_SiGN   = alg5xP_SSEToSiGN($in{'alg'}); //     SiGN = SSE --> SiGN
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
  $hea_form         = "Twizzle Twister";
  
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
  $txt_notationSiGN = "Notation SiGN";
  
  $txt_alg          = "Algorithm";
  $hlp_alg          = "Algorithm";
  
  $txt_algSSE       = "Algorithm SSE";
  $hlp_algSSE       = "Algorithm";
  
  $txt_algSiGN      = "Algorithm SiGN";
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
