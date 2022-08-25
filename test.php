<?php 


function solution($R) {
    $rows = count($R);
    $colomns = count($R[0]);
    $clean_squares = array();
    $right_count = 0;

    for($j = 0; $j < $rows; $j++) {
        if(isset($R[0][$j]) && $R[0][$j] == '.') {
            $clean_squares['0'.$j] = 1;
        } 
        if(isset($R[0][$j+1]) && $R[0][$j+1] == 'X') {
            $right_count++;
            $clean_squares = shiftRight(0, $j, true, $R, $clean_squares, $right_count);
            break;
        }
    }

    return $clean_squares;
}

function shiftRight($row, $column, $is_column, $R, $clean_squares, $right_count) {
    $rows = count($R);
    $colomns = count($R[0]);

    if(checkIfDone($clean_squares) || $R[$row][$column] == 'X') return $clean_squares;    
    if($is_column) {
        if($right_count%3 == 0) {
            for($i = $row-1; $i >= 0; $i--) {
                if($R[$i][$column] == '.') $clean_squares = checkAndSet($i.$column, $clean_squares);                
                if(!isset($R[$i-1][$column]) || $R[$i-1][$column] == 'X') {
                    $right_count++;
                    return shiftRight($i, $column, !$is_column, $R, $clean_squares, $right_count);
                }
            }    
        } else {
            for($i = $row+1; $i < $rows; $i++) {
                if($R[$i][$column] == '.') $clean_squares = checkAndSet($i.$column, $clean_squares);    
                if(!isset($R[$i+1][$column]) || $R[$i+1][$column] == 'X') {
                    $right_count++;
                    return shiftRight($i, $column, !$is_column, $R, $clean_squares, $right_count);
                }
            }    
        }
    } else {
        if($right_count%4 == 0) {
            for($i = $column+1; $i < $colomns; $i++) {
                if($R[$row][$i] == '.') $clean_squares = checkAndSet($row.$i, $clean_squares);
                if(!isset($R[$row][$i+1]) || $R[$row][$i+1] == 'X') {
                    $right_count = 1;
                    return shiftRight($row, $i, !$is_column, $R, $clean_squares, $right_count);
                }
            }
        } else {
            for($i = $column-1; $i >= 0; $i--) {
                if($R[$row][$i] == '.') $clean_squares = checkAndSet($row.$i, $clean_squares);
                if(!isset($R[$row][$i-1]) || $R[$row][$i-1] == 'X') {
                    $right_count++;
                    return shiftRight($row, $i, !$is_column, $R, $clean_squares, $right_count);
                }
            }
        }
    }
}

function checkIfDone($clean_squares) {
    $count = 0;
    foreach($clean_squares as $square) if($square == 2) $count++;

    return $count > 2; 
}

function checkAndSet($index, $clean_squares) {
    if(isset($clean_squares[$index])) {
        $clean_squares[$index]++;
    } else {
        $clean_squares[$index] = 1;
    }

    return $clean_squares;
}

$arr1 = array(
    array('.','.','.','.','X'),
    array('X','.','X','.','.'),
    array('X','.','X','.','.'),
    array('X','.','.','.','X')
);
$arr2 = array(
    array('.','.','.','X','.'),
    array('.','.','.','X','.'),
    array('.','.','.','.','X'),
    array('X','X','.','.','.'),
    array('.','.','.','.','X'),
    array('.','.','.','.','X')
);
$arr = array(
    array('.','.','.','.','.','.','.','X'),
    array('X','.','.','.','.','.','.','.'),
    array('.','.','.','.','.','X','.','.'),
    array('.','.','X','.','.','.','.','.'),
    array('.','.','.','X','.','X','.','.'),
    array('.','.','.','.','.','.','.','.'),
    array('.','X','.','.','.','.','.','.'),
    array('.','.','.','.','X','.','.','.'),    
    array('.','.','.','.','.','.','.','.')
);
$result = solution($arr);
?>



<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="theme-color" content="#000000" />
    <title>Bhushan's Robot</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <style>
        body {
            position: absolute;
            top: 200px;
            left: 200px;
        }

        .row {
            width: auto;
            height: 50px;
            display: grid;
            gap: 2px;
            grid-template-columns: auto auto auto auto auto auto auto auto;
            padding-bottom: 2px;
        }

        .column {
            width: 10px;
            padding: 15px;
            border: 1px solid black;
            background: cyan;
        }

        .path {
            background: black;
        }
    </style>
  </head>
  <body>
    <?php for($i=0; $i<count($arr); $i++) { ?>
        <div class="row">
            <?php for($j=0; $j<count($arr[0]); $j++) { ?>
                <div class="column column-<?=$i.$j?>">
                    <?php echo $arr[$i][$j] == 'X' ? 'X' : '' ?>
                </div>
            <?php } ?>
        </div>
    <?php } ?>
  </body>
  <script>
      function sleep(milliseconds) {  
        return new Promise(resolve => setTimeout(resolve, milliseconds));  
      }

      async function display() {
        $('.column').removeClass('path');
        var arr = [];
        <?php foreach ($result as $key=>$item) : ?>
         arr.push('<?php echo $key?>');
        <?php endforeach; ?>

        for(let key in arr) {
            await sleep(100);
            $('.column-'+arr[key]).addClass('path');
        }
      }
      display();
  </script>
</html>
