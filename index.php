<?php 

$my_text_file = "test.in";
$all_lines = file($my_text_file);
$current_line_no = 1;


while($all_lines[$current_line_no]) {
    $dictionary_array = array();
    $cases = $current_line_no;
    for($i=0;$i<$all_lines[$cases];$i++){
        $current_line_no++;
        $words = explode(' ', $all_lines[$current_line_no]);
        $word1 = strtolower(trim($words[0]));
        $word2 = strtolower(trim($words[1]));
        $dictionary_array[$word1][] = $word2;
        $dictionary_array[$word2][] = $word1;
    }

    //can optimise this later
    for($i=0;$i<5;$i++) {
        foreach($dictionary_array as $key=>$dic_arr) {
            foreach($dic_arr as $new_dic_arr) {
                foreach($dic_arr as $new_dic_arr1) {
                    if($new_dic_arr !== $new_dic_arr1) {
                        if(!in_array($new_dic_arr1, $dictionary_array[$new_dic_arr])) $dictionary_array[$new_dic_arr][] = $new_dic_arr1;
                        if(!in_array($new_dic_arr, $dictionary_array[$new_dic_arr1])) $dictionary_array[$new_dic_arr1][] = $new_dic_arr;
                    }
                }
            }
        }    
    }

    $current_line_no = $current_line_no+1;
    $cases = $all_lines[$current_line_no];
    for($i=0;$i<$cases;$i++){
        $current_line_no++;
        $words = explode(' ', $all_lines[$current_line_no]);
        $word1 = strtolower(trim($words[0]));
        $word2 = strtolower(trim($words[1]));

        $file = fopen("test.txt","a+");
        if($word1 == $word2 || ($dictionary_array[$word2] && in_array($word1, $dictionary_array[$word2]))) {
            fwrite($file, "synonyms\n");
        } else {
            fwrite($file, "different\n");
        }
        fclose($file);
    }
    $current_line_no++;
}

?>
