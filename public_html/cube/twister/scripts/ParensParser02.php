<?php
  
  /**
  * Parse a string into an array.
  *
  * @param string $subject
  *   The subject string.
  *
  * @return array|bool
  *   The array.
  */
  
  function parse(string $subject) {
    $result = [];
    
    preg_match_all('~[^\[\]]+|\[(?<nested>(?R)*)\]~', $subject, $matches);
    
    foreach (array_filter($matches['nested']) as $match) {
      $item = [];
      $position = strpos($match, '[');
      
      if (false !== $position) {
        $item['value'] = substr($match, 0, $position);
      } else {
        $item['value'] = $match;
      }
      
      if ([] !== $children = $this->parse($match)) {
        $item['children'] = $children;
      }
      
      $result[] = $item;
    }
    
    return $result;
  }
  
  $string = "CU [R U F' [F2 U2]2 B' MD] CU'";
  
  $result = parse($string);
  var_dump($result);