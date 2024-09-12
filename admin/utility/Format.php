<?php
    class Format{
        public function formatDate($date){
            return date("F j, Y, g:i a",strtotime($date));
        }
        public function short_text($text, $limit=500){
            $text = substr($text,0,$limit);
			$text = str_replace(array("<br>", "\r"), '', $text);
			$text = str_replace(array("<b>", "\r"), '', $text);
			$text = str_replace(array("</b>", "\r"), '', $text);
			$text = str_replace(array("<pre>", "\r"), '', $text);
			$text = str_replace(array("</pre>", "\r"), '', $text);
			$text = str_replace(array("\n", "\r"), '', $text);
            $text = substr($text,0,strrpos($text, ' '));
            return $text= $text."....";
        }
    }
?>