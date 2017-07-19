<?php
    $k=100; //The factor to be multiplied in case of #tags
    $factor=1;
    $file=file_get_contents("validation_test.txt");
    $lines=explode(PHP_EOL,$file);
    
    $f1= file_get_contents("sports.txt", "w");
    $f2= file_get_contents("politics.txt", "w");
    
    $f1_lines=explode(PHP_EOL, $f1);
    $f2_lines=explode(PHP_EOL, $f2);
    
    //Making the elements of the two bags of words unique.
    $f1_lines=array_unique($f1_lines);
    $f2_lines=array_unique($f2_lines);
    
    //Application of set operations
    // A=A-B
    // B=B-A
    //This reduces the duplicate factors in both the bags and makes algorithm a bit faster
    $f1_lines = array_diff($f1_lines, $f2_lines);
    $f2_lines = array_diff($f2_lines, $f1_lines);
    
    $count=0;
    $sum=0;
    
    foreach($lines as $l)
    {
        $sports=1;
        $politics=1;
        $val=1;
        $tweet="";
    
        //Seperation based on categories
        $items=explode(" ",$l);
        $id=$items[0];
        $num=count($items);
        
        //Getting the tweet
        for($i=1;$i<$num;$i++)
            $tweet=$tweet." ".$items[$i];
        
        //Dropping the http links
        $tweet=preg_replace("/(\s?)(?<=\s|^)(http)\S*\s*/", "$1", $tweet);
        
        //Removing punctuations
        $tweet=strtolower($tweet);
        $tweet=str_replace("'","",$tweet);
        $tweet=str_replace(":","",$tweet);
        $tweet=str_replace("\\","",$tweet);
        $tweet=str_replace(",","",$tweet);
        $tweet=str_replace("\"","",$tweet);
        $tweet=str_replace("/","",$tweet);
        $tweet=str_replace("!","",$tweet);
        $tweet=str_replace(".","",$tweet);
        $tweet=str_replace("(","",$tweet);
        $tweet=str_replace(")","",$tweet);
        $tweet=str_replace("?","",$tweet);
            
        foreach($f1_lines as $f1l)
        {
            if(trim($f1l)!="" && trim($tweet)!="")
            {
                if(strpos($tweet,$f1l)===false)
                {
                    //Do-nothing
                    ;
                }
                else
                {
                    if(strpos("$f1l","#")===false && strpos("$f1l","@")===false)
                        $sports=$sports+1; //Factor 1 added if word in sports is found
                    else
                    {
                        $sports=$sports+1*$k; //Factor 1 * k added if word in sports is found with a # tag
                    }
                }
            }
        }
        
        foreach($f2_lines as $f2l)
        {
            if(trim($f2l)!="" && trim($tweet)!="")
            {
                if(strpos($tweet,$f2l)===false)
                {
                    //Do-nothing
                    ;
                }
                else
                {
                    if(strpos("$f2l","#")===false && strpos("$f2l","@")===false)
                        $politics=$politics+1; //Factor 1 added if word in politics is found
                    else
                    {
                        $politics=$politics+1*$k; //Factor 1 * k added if word in politics is found with a # tag
                    }
                }
            }
        }
        
        //Reduction of the politics factor by 5 as discussed in validation and paramater tuning.
        $politics=$politics-5;
        if($politics<=0)
            $politics=1;
        $val=($sports/$politics);
        
        
        if($val>=$factor)
        {
            if(trim($id)!="")
                echo trim($id." Sports").PHP_EOL;
        }
        else
        {
            if(trim($id)!="")
                echo trim($id." Politics").PHP_EOL;
        }
    }
?>