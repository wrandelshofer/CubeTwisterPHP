<?php
// originally from https://w...content-available-to-author-only...v.com/2011/10/23/Improving-lexing-performance-in-PHP.html
class Lexer {
    protected $regex;
    protected $offsetToToken;
 
    public function __construct(array $tokenMap) {
        $this->regex = '((' . implode(')|(', array_keys($tokenMap)) . '))A';
        $this->offsetToToken = array_values($tokenMap);
    }
 
    public function lex($string) {
        $tokens = array();
 
        $offset = 0;
        while (isset($string[$offset])) {
            if (!preg_match($this->regex, $string, $matches, null, $offset)) {
                throw new Exception(sprintf('Unexpected character "%s"', $string[$offset]));
            }
 
            // find the first non-empty element (but skipping $matches[0]) using a quick for loop
            for ($i = 1; '' === $matches[$i]; ++$i);
            $tokens[] = array($matches[0], $this->offsetToToken[$i - 1]);
            $offset += strlen($matches[0]);
        }
 
        return $tokens;
    }
 
    // a recursive function to actually build the structure
    function generate($arr=array(), $i=0) {
    	$output = array();
    	$current = null;
    	for($i;$i<count($arr);$i++) {
    		list($element, $type) = $arr[$i];
    		if ($type == 'T_OPEN') {
				$ret = $this->generate($arr, $i+1);
    			$output[$current] = $ret[0];
    			$i = $ret[1];
			}
    		elseif ($type == 'T_CLOSE')
    			return [$output, $i];
    		elseif ($type == 'T_FIELD') {
    			$output[$element] = null;
    			$current = $element;
    		}
    	}
    	return $output;
    }
 
}
 
// here begins the magic
 
// this is our $tokenMap
$tokenMap = array(
    '[^,()]+'		=> 'T_FIELD',
    ','				=> 'T_SEPARATOR',
    '\('			=> 'T_OPEN',
    '\)'			=> 'T_CLOSE'
);
 
// this is your string
$string = "id,topic,member(name,email,group(id,name)),message(id,title,body)";
 
$lex = new Lexer($tokenMap);
$structure = $lex->lex($string);
$output = $lex->generate($structure);
print_r($output);