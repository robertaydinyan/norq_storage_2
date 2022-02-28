<?php


namespace app\components;

 class Debug {

     /**
      * A collapse icon, using in the dump_var function to allow collapsing
      * an array or object
      *
      * @var string
      */
     public static $icon_collapse = 'iVBORw0KGgoAAAANSUhEUgAAABAAAAAQAQMAAAAlPW0iAAAAAXNSR0IB2cksfwAAAAlwSFlzAAAAdgAAAHYBTnsmCAAAAAZQTFRFAAAAoKCgBM77rgAAAAJ0Uk5TAP9bkSK1AAAAKElEQVR4nGNgYGD4/x+K6v8x2P8BIfkfIMT/AYTYHzAwHwAhxgagWgDfrhEIX/Q4LgAAAABJRU5ErkJggg==';
     /**
      * A collapse icon, using in the dump_var function to allow collapsing
      * an array or object
      *
      * @var string
      */
     public static $icon_expand = 'iVBORw0KGgoAAAANSUhEUgAAABAAAAAQAQMAAAAlPW0iAAAAAXNSR0IB2cksfwAAAAlwSFlzAAAAdgAAAHYBTnsmCAAAAAZQTFRFAAAAoKCgBM77rgAAAAJ0Uk5TAP9bkSK1AAAALUlEQVR4nGMoYGCoYGCoY2Cob2Cof8BQ/4Gh/g9D/T8w+gPmPgBJ1YGVFTAAAIfmEFdErkdGAAAAAElFTkSuQmCC';
     private static $hasArray = false;

     public static function var_dump($var, $return = false, $expandLevel = 1)
     {
         self::$hasArray = false;
         $toggScript = 'var colToggle = function(toggID) {var img = document.getElementById(toggID);if (document.getElementById(toggID + "-collapsable").style.display == "none") {document.getElementById(toggID + "-collapsable").style.display = "inline";setImg(toggID, 0);var previousSibling = document.getElementById(toggID + "-collapsable").previousSibling;while (previousSibling != null && (previousSibling.nodeType != 1 || previousSibling.tagName.toLowerCase() != "br")) {previousSibling = previousSibling.previousSibling;}} else {document.getElementById(toggID + "-collapsable").style.display = "none";setImg(toggID, 1);var previousSibling = document.getElementById(toggID + "-collapsable").previousSibling; while (previousSibling != null && (previousSibling.nodeType != 1 || previousSibling.tagName.toLowerCase() != "br")) {previousSibling = previousSibling.previousSibling;}}};';
         $imgScript = 'var setImg = function(objID,imgID,addStyle) {var imgStore = ["data:image/png;base64,' . self::$icon_collapse . '", "data:image/png;base64,' . self::$icon_expand . '"];if (objID) {document.getElementById(objID).setAttribute("src", imgStore[imgID]);if (addStyle){document.getElementById(objID).setAttribute("style", "position:relative;left:-5px;cursor:pointer;width:8px");}}};';
         $jsCode = preg_replace('/ +/', ' ', '<script>' . $toggScript . $imgScript . '</script>');
         $html = '<pre style="margin-bottom: 18px;' .
             'background: #000000;' .
             'border: 1px solid #e1e1e8;' .
             'padding: 8px;' .
             'border-radius: 4px;' .
             '-moz-border-radius: 4px;' .
             '-webkit-border radius: 4px;' .
             'display: block;' .
             'font-size: 12.05px;' .
             'white-space: pre-wrap;' .
             'word-wrap: break-word;' .
             'color: #56db3a;' .
             'width: max-content;' .
             'font-family: Menlo,Monaco,Consolas,\'Courier New\',monospace;">';
         $done  = array();
         $html .= self::var_dump_plain($var, intval($expandLevel), 0, $done);
         $html .= '</pre>';
         if (self::$hasArray) {
             $html = $jsCode . $html;
         }
         if (! $return) {
             echo $html;
         }
         return $html;
     }
     /**
      * Display a variable's contents using nice HTML formatting (Without
      * the <pre> tag) and will properly display the values of variables
      * like booleans and resources. Supports collapsable arrays and objects
      * as well.
      *
      * @param  mixed $var The variable to dump
      * @return string
      */
     public static function var_dump_plain($var, $expLevel, $depth = 0, $done = array())
     {
         $html = '';
         if ($expLevel > 0) {
             $expLevel--;
             $setImg = 0;
             $setStyle = 'display:inline;';
         } elseif ($expLevel == 0) {
             $setImg = 1;
             $setStyle='display:none;';
         } elseif ($expLevel < 0) {
             $setImg = 0;
             $setStyle = 'display:inline;';
         }
         if (is_bool($var)) {
             $html .= '<span style="color:#1395da;">bool</span><span style="color:#fb7f02;">(</span><strong style="color: #8c999c;">' . (($var) ? 'true' : 'false') . '</strong><span style="color:#fb7f02;">)</span>';
         } elseif (is_int($var)) {
             $html .= '<span style="color:#1395da;">int</span><span style="color:#fb7f02;">(</span><strong style="color: #8c999c;">' . $var . '</strong><span style="color:#fb7f02;">)</span>';
         } elseif (is_float($var)) {
             $html .= '<span style="color:#1395da;">float</span><span style="color:#fb7f02;">(</span><strong style="color: #8c999c;">' . $var . '</strong><span style="color:#fb7f02;">)</span>';
         } elseif (is_string($var)) {
             $html .= '<span style="color:#1395da;">string</span><span style="color:#fb7f02;">(</span><span style="color: #8c999c;">' . strlen($var) . '</span><span style="color:#fb7f02;">)</span> <strong style="color: #56db3a;">"' . self::htmlentities($var) . '"</strong>';
         } elseif (is_null($var)) {
             $html .= '<strong style="color: #56db3a;">NULL</strong>';
         } elseif (is_resource($var)) {
             $html .= '<span style="color:#1395da;">resource</span><span style="color:#fb7f02;">(</span>"' . get_resource_type($var) . '"<span style="color:#fb7f02;">)</span> <strong>"' . $var . '"</strong>';
         } elseif (is_array($var)) {
             // Check for recursion
             if ($depth > 0) {
                 foreach ($done as $prev) {
                     if ($prev === $var) {
                         $html .= '<span style="color:#1395da;">array</span><span style="color:#fb7f02;">(</span><span style="color:#8c999c;">' . count($var) . '</span><span style="color:#fb7f02;">)</span> *RECURSION DETECTED*';
                         return $html;
                     }
                 }
                 // Keep track of variables we have already processed to detect recursion
                 $done[] = &$var;
             }
             self::$hasArray = true;
             $uuid = 'include-php-' . uniqid() . mt_rand(1, 1000000);
             $html .= (!empty($var) ? ' <img id="' . $uuid . '" src="data:image/png;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs%3D" onclick="javascript:colToggle(this.id);" /><script>setImg("' . $uuid . '",'.$setImg.',1);</script>' : '') . '<span style="color:#1395da;">array</span><span style="color:#fb7f02;">(</span><span style="color:#8c999c;">' . count($var) . '</span><span style="color:#fb7f02;">)</span>';
             if (! empty($var)) {
                 $html .= ' <span id="' . $uuid . '-collapsable" style="'.$setStyle.'"><br /><span style="color: #fb7f02">[</span><br />';
                 $indent = 4;
                 $longest_key = 0;
                 foreach ($var as $key => $value) {
                     if (is_string($key)) {
                         $longest_key = max($longest_key, strlen($key) + 2);
                     } else {
                         $longest_key = max($longest_key, strlen($key));
                     }
                 }
                 foreach ($var as $key => $value) {
                     if (is_numeric($key)) {
                         $html .= str_repeat(' ', $indent) . str_pad('<span style="color: #56db3a;">'.$key.'</span>', $longest_key, ' ');
                     } else {
                         $html .= str_repeat(' ', $indent) . str_pad('<span style="color: #fb7f02;">"</span><span style="color: #56db3a;">' . self::htmlentities($key) . '</span><span style="color: #fb7f02;">"</span>', $longest_key, ' ');
                     }
                     $html .= ' <span style="color: #fb7f02">=></span> ';
                     $value = explode('<br />', self::var_dump_plain($value, $expLevel, $depth + 1, $done));
                     foreach ($value as $line => $val) {
                         if ($line != 0) {
                             $value[$line] = str_repeat(' ', $indent * 2) . $val;
                         }
                     }
                     $html .= implode('<br />', $value) . '<br />';
                 }
                 $html .= '<span style="color: #fb7f02">]</span></span>';
             }
         } elseif (is_object($var)) {
             // Check for recursion
             foreach ($done as $prev) {
                 if ($prev === $var) {
                     $html .= '<span style="color:#1395da;">object</span><span style="color:#fb7f02;">(</span><span style="color:#56db3a;">' . get_class($var) . '</span><span style="color:#fb7f02;">)</span> *RECURSION DETECTED*';
                     return $html;
                 }
             }
             // Keep track of variables we have already processed to detect recursion
             $done[] = &$var;
             self::$hasArray=true;
             $uuid = 'include-php-' . uniqid() . mt_rand(1, 1000000);
             $html .= ' <img id="' . $uuid . '" src="data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs%3D" onclick="javascript:colToggle(this.id);" /><script>setImg("' . $uuid . '",'.$setImg.',1);</script><span style="color:#1395da;">object</span><span style="color:#fb7f02;">(</span><span style="color:#56db3a;">' . get_class($var) . '</span><span style="color:#fb7f02;">)</span> <span id="' . $uuid . '-collapsable" style="'.$setStyle.'"><br /><span style="color: #fb7f02">[</span><br />';
             $varArray = (array) $var;
             $indent = 4;
             $longest_key = 0;
             foreach ($varArray as $key => $value) {
                 if (substr($key, 0, 2) == "\0*") {
                     unset($varArray[$key]);
                     $key = 'protected:' . substr($key, 2);
                     $varArray[$key] = $value;
                 } elseif (substr($key, 0, 1) == "\0") {
                     unset($varArray[$key]);
                     $key = 'private:' . substr($key, 1, strpos(substr($key, 1), "\0")) . ':' . substr($key, strpos(substr($key, 1), "\0") + 1);
                     $varArray[$key] = $value;
                 }
                 if (is_string($key)) {
                     $longest_key = max($longest_key, strlen($key) + 2);
                 } else {
                     $longest_key = max($longest_key, strlen($key));
                 }
             }
             foreach ($varArray as $key => $value) {
                 if (is_numeric($key)) {
                     $html .= str_repeat(' ', $indent) . str_pad($key, $longest_key, ' ');
                 } else {
                     $html .= str_repeat(' ', $indent) . str_pad('<span style="color: #fb7f02">"</span><span style="color: #56db3a;">' . self::htmlentities($key) . '</span><span style="color: #fb7f02">"</span>', $longest_key, ' ');
                 }
                 $html .= ' <span style="color: #fb7f02">=></span> ';
                 $value = explode('<br />', self::var_dump_plain($value, $expLevel, $depth + 1, $done));
                 foreach ($value as $line => $val) {
                     if ($line != 0) {
                         $value[$line] = str_repeat(' ', $indent * 2) . $val;
                     }
                 }
                 $html .= implode('<br />', $value) . '<br />';
             }
             $html .= '<span style="color: #fb7f02">]</span></span>';
         }
         return $html;
     }

     /**
      * Convert entities, while preserving already-encoded entities.
      *
      * @param  string $string The text to be converted
      * @return string
      */
     public static function htmlentities($string, $preserve_encoded_entities = false)
     {
         if ($preserve_encoded_entities) {
             // @codeCoverageIgnoreStart
             if (defined('HHVM_VERSION')) {
                 $translation_table = get_html_translation_table(HTML_ENTITIES, ENT_QUOTES);
             } else {
                 $translation_table = get_html_translation_table(HTML_ENTITIES, ENT_QUOTES, self::mbInternalEncoding());
             }
             // @codeCoverageIgnoreEnd
             $translation_table[chr(38)] = '&';
             return preg_replace('/&(?![A-Za-z]{0,4}\w{2,3};|#[0-9]{2,3};)/', '&amp;', strtr($string, $translation_table));
         }
         return htmlentities($string, ENT_QUOTES, self::mbInternalEncoding());
     }

     /**
      * Wrapper to prevent errors if the user doesn't have the mbstring
      * extension installed.
      *
      * @param  string $encoding
      * @return string
      */
     protected static function mbInternalEncoding($encoding = null)
     {
         if (function_exists('mb_internal_encoding')) {
             return $encoding ? mb_internal_encoding($encoding) : mb_internal_encoding();
         }
         // @codeCoverageIgnoreStart
         return 'UTF-8';
         // @codeCoverageIgnoreEnd
     }
 }