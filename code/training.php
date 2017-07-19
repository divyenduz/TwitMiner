<?php
    $file=file_get_contents("training.txt");
    $line=explode(PHP_EOL,$file);
    
    $f1= fopen("sports.txt", "w");
    $f2= fopen("politics.txt", "w");
    
    foreach($line as $l)
    {
        $elements=explode(" ",$l);
        $num=count($elements);
        if($num>4) //Use the tweet only if tweet length is more than 2
        {
        //Filling the sports bag
        if($elements[1]=="Sports")
        {
            for($i=2;$i<$num;$i++)
            {
                //Removal of punctuations and http links
                $ele=$elements[$i];
                $ele=str_replace("'","",$ele);
                $ele=str_replace(":","",$ele);
                $ele=str_replace("\\","",$ele);
                $ele=str_replace(",","",$ele);
                $ele=str_replace("\"","",$ele);
                $ele=str_replace("/","",$ele);
                $ele=str_replace("!","",$ele);
                $ele=str_replace(".","",$ele);
                $ele=str_replace("(","",$ele);
                $ele=str_replace(")","",$ele);
                $ele=str_replace("?","",$ele);
                
                $ele=preg_replace("/(\s?)(?<=\s|^)(http)\S*\s*/", "$1", $ele);
                //Words of length more than 4 only are stored as they are more subject oriented (assumption)
                if(strpos($ele,"http")===false && trim($ele) != "" && strlen($ele) >4)
                    fwrite($f1, strtolower($ele).PHP_EOL);
            }
        }
        
        //Filling the politics bag
        if($elements[1]=="Politics")
        {
            for($i=2;$i<$num;$i++)
            {
                //Removal of punctuations and http links
                $ele=$elements[$i];
                $ele=str_replace("'","",$ele);
                $ele=str_replace(":","",$ele);
                $ele=str_replace("\\","",$ele);
                $ele=str_replace(",","",$ele);
                $ele=str_replace("\"","",$ele);
                $ele=str_replace("/","",$ele);
                $ele=str_replace("!","",$ele);
                $ele=str_replace(".","",$ele);
                $ele=str_replace("(","",$ele);
                $ele=str_replace(")","",$ele);
                $ele=str_replace("?","",$ele);
                
                $ele=preg_replace("/(\s?)(?<=\s|^)(http)\S*\s*/", "$1", $ele);
                //Words of length more than 4 only are stored as they are more subject oriented (assumption)
                if(strpos($ele,"http")===false && trim($ele) != "" && strlen($ele) >4)
                    fwrite($f2, strtolower($ele).PHP_EOL);
            }
        }
        }
    }
    echo "End of training";
?>