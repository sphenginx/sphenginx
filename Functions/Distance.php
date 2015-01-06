<?php
	/**
     * 用mysql的内置函数获取两个经纬度直接的距离
     *
     * @param float $latitude  用户传入的纬度
     * @param float $longitude 用户传入的经度
     * 
     * @return string
     * @author sphenginx
     **/
    function getDistance($latitude, $longitude)
    {
        return "ROUND(6378.138*2*ASIN(SQRT(POW(SIN(($latitude*PI()/180-latitude*PI()/180)/2),2)+COS($latitude*PI()/180)*COS(latitude*PI()/180)*POW(SIN(($longitude*PI()/180-longitude*PI()/180)/2),2)))*1000) AS distance";
    }

    /**
     * 查找一定范围内的经纬度值
     * @param float 纬度  
     * @param float 经度  
     * @param int   查找半径(m)
     * @return  array 最小纬度、经度，最大纬度、经度 
     */
    function getAround($latitude, $longitude, $raidusMile = 1500)
    {  
        // $PI           = 3.14159265;            // 圆周率
        // $EARTH_RADIUS = 6378137;               // 地球半径
        // $RAD          = Math.PI / 180.0;       // 弧度
        $degree       = (24901*1609)/360.0; 
        $dpmLat            = 1/$degree;  
        $radiusLat         = $dpmLat*$raidusMile;  
        $minLat            = $latitude - $radiusLat;  
        $maxLat            = $latitude + $radiusLat;  
        $mpdLng            = $degree*cos($latitude * ($PI/180));  
        $dpmLng            = 1 / $mpdLng;  
        $radiusLng         = $dpmLng*$raidusMile;  
        $minLng            = $longitude - $radiusLng;  
        $maxLng            = $longitude + $radiusLng; 
        $result['minwei']  = $minLat;
        $result['minjing'] = $minLng;
        $result['maxwei']  = $maxLat;
        $result['maxjing'] = $maxLng;
        return $result;
    }