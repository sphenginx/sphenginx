<?php
//插入排序（一维数组）
function insert_sort($arr)
{
    $count = count($arr);
    for($i=1; $i<$count; $i++){
        $tmp = $arr[$i];
        $j   = $i - 1;
        while($arr[$j] > $tmp){
            $arr[$j+1] = $arr[$j];
            $arr[$j]   = $tmp;
            $j--;
        }
    }
    return $arr;
}


//选择排序（一维数组）
function select_sort($arr)
{
    $count = count($arr);
    for($i=0; $i<$count; $i++){
        $k = $i;
        for($j=$i+1; $j<$count; $j++){
            if ($arr[$k] > $arr[$j])
                $k = $j;
            if ($k != $i){
                $tmp = $arr[$i];
                $arr[$i] = $arr[$k];
                $arr[$k] = $tmp;
            }
        }
    }
    return $arr;
}

//冒泡排序（一维数组） 
function bubble_sort($array)
{ 
    $count = count($array); 
    if ($count <= 0) return false; 
    
    for($i=0; $i<$count; $i++){ 
        for($j=$count-1; $j>$i; $j--){ 
            if ($array[$j] < $array[$j-1]){ 
                $tmp = $array[$j]; 
                $array[$j] = $array[$j-1]; 
                $array[$j-1] = $tmp; 
            } 
        } 
    } 
    return $array; 
} 

//快速排序（一维数组） 
function quick_sort($array)
{ 
    if (count($array) <= 1) return $array; 

    $key       = $array[0]; 
    $left_arr  = array(); 
    $right_arr = array(); 

    for ($i=1; $i<count($array); $i++){ 
        if ($array[$i] <= $key) 
            $left_arr[] = $array[$i]; 
        else 
            $right_arr[] = $array[$i]; 
    } 

    $left_arr  = quick_sort($left_arr); 
    $right_arr = quick_sort($right_arr); 
    
    return array_merge($left_arr, array($key), $right_arr); 
} 