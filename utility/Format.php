<?php
    class Format{
        public function formatDate($date){
            return $date = date("F j, Y, g:i a");
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
        public function englishToBangla($number){
            $number_array = str_split($number);
            $bangla_number = ["০" ,"১" ,"২","৩" ,"৪" ,"৫" ,"৬" ,"৭" ,"৮","৯"];
            $output = "";
            foreach($number_array as $num){
                if($num=="0"){
                    $output = $output . $bangla_number[0];
                }if($num=="1"){
                    $output = $output . $bangla_number[1];
                }if($num=="2"){
                    $output = $output . $bangla_number[2];
                }if($num=="3"){
                    $output = $output . $bangla_number[3];
                }if($num=="4"){
                    $output = $output . $bangla_number[4];
                }if($num=="5"){
                    $output = $output . $bangla_number[5];
                }if($num=="6"){
                    $output = $output . $bangla_number[6];
                }if($num=="7"){
                    $output = $output . $bangla_number[7];
                }if($num=="8"){
                    $output = $output . $bangla_number[8];
                }if($num=="9"){
                    $output = $output . $bangla_number[9];
                }
            }
            return $output;
        }
    }
?>