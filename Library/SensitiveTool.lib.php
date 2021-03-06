<?php
/***
 **************************************************************
 *                                                            *
 *   .=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-.       *
 *    |                     ______                     |      *
 *    |                  .-"      "-.                  |      *
 *    |                 /            \                 |      *
 *    |     _          |              |          _     |      *
 *    |    ( \         |,  .-.  .-.  ,|         / )    |      *
 *    |     > "=._     | )(__/  \__)( |     _.=" <     |      *
 *    |    (_/"=._"=._ |/     /\     \| _.="_.="\_)    |      *
 *    |           "=._"(_     ^^     _)"_.="           |      *
 *    |               "=\__|IIIIII|__/="               |      *
 *    |              _.="| \IIIIII/ |"=._              |      *
 *    |    _     _.="_.="\          /"=._"=._     _    |      *
 *    |   ( \_.="_.="     `--------`     "=._"=._/ )   |      *
 *    |    > _.="                            "=._ <    |      *
 *    |   (_/                                    \_)   |      *
 *    |                                                |      *
 *    '-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-='      *
 *                                                            *
 *           LASCIATE OGNI SPERANZA, VOI CH'ENTRATE           *
 **************************************************************
 */
/**
 * PHP基于DFA算法过滤敏感词类:
 *
 *     在实现文字过滤的算法中，DFA是唯一比较好的实现算法。DFA即Deterministic Finite Automaton，也就是确定有穷自动机，
 * 它是是通过event和当前的state得到下一个state，即event+state=nextstate。
 *
 * 注：PHP 版本 > 5.6
 * 
 * 参考文档：https://blog.csdn.net/chenssy/article/details/26961957
 *
 * @package lib
 * @author Sphenginx
 * @DataTime 2018-07-03 09:31:12
 * 
 **/
class SensitiveTool
{
    //hashMap列表
    private static $arrHashMap = [];

    /**
     * 获取敏感词map表
     *
     * @return array
     * @author Sphenginx
     **/
    public static function getHashMap() 
    {
        return static::$arrHashMap;
    }


    /**
     * 设置hashmap信息
     *
     * @param array $hashmap 关键字列表
     *
     * @return void
     * @author Sphenginx
     **/
    public static function setHashMap($hashmap) 
    {
        static::$arrHashMap = $hashmap;
    }
 
    /**
     * 新增敏感词符
     *
     * @param string $strWord 新增关键字
     *
     * @return void
     * @author Sphenginx
     **/
    public static function addKeyWord($strWord) 
    {
        $len = mb_strlen($strWord, 'UTF-8');
 
        // 传址
        $arrHashMap = &static::$arrHashMap;
        for ($i=0; $i < $len; $i++) {
            $word = mb_substr($strWord, $i, 1, 'UTF-8');
            // 已存在
            if (isset($arrHashMap[$word])) {
                if ($i == ($len - 1)) {
                    $arrHashMap[$word]['end'] = 1;
                }
            } else {
                // 不存在
                if ($i == ($len - 1)) {
                    $arrHashMap[$word] = [];
                    $arrHashMap[$word]['end'] = 1;
                } else {
                    $arrHashMap[$word] = [];
                    $arrHashMap[$word]['end'] = 0;
                }
            }
            // 传址
            $arrHashMap = &$arrHashMap[$word];
        }
    }
 
    /**
     * 查询是否存在敏感词
     *
     * @param string $strWord 需要过滤的字符串(只匹配一次)
     *
     * @return boolean
     * @author Sphenginx
     **/
    public static function searchKey($strWord) 
    {
        $len = mb_strlen($strWord, 'UTF-8');
        $arrHashMap = static::$arrHashMap;
        for ($i=0; $i < $len; $i++) {
            $word = mb_substr($strWord, $i, 1, 'UTF-8');
            if (!isset($arrHashMap[$word])) {
                // reset hashmap
                $arrHashMap = static::$arrHashMap;
                continue;
            }
            if ($arrHashMap[$word]['end']) {
                return true;
            }
            $arrHashMap = $arrHashMap[$word];
        }
        return false;
    }

    /**
     * 过滤敏感词信息
     *
     * @param string $str 需要过滤的关键字
     * @param string $replace 需要替换的字符
     *
     * @return string $str
     * @author Sphenginx
     **/
    public static function filterWord($str, $replace = '*') 
    {
        $len = mb_strlen($str, 'UTF-8');
        $arrHashMap = static::$arrHashMap;
        $matchStr = '';
        for ($i=0; $i < $len; $i++) {
            $word = mb_substr($str, $i, 1, 'UTF-8');
            $matchStr .= $word;
            if (!isset($arrHashMap[$word])) {
                // reset hashmap
                $arrHashMap = static::$arrHashMap;
                $matchStr = '';
                continue;
            }
            if ($arrHashMap[$word]['end']) {
                $str = str_ireplace($matchStr, str_repeat($replace, mb_strlen($matchStr,'utf-8')), $str);
                $matchStr = '';
                $arrHashMap = static::$arrHashMap;
                continue;
            }
            $arrHashMap = $arrHashMap[$word];
        }
        return $str;
    }

    /**
     * 过滤邮箱和手机号(8位以上数字)
     * @param $msg
     * @return string
     */
    public static function filterTelMail($msg) 
    {
        if(is_string($msg)){
            $msg = preg_replace('/\d{8,}/', '****', $msg);
            $msg = preg_replace('/[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})/i', '****', $msg);
        }else{
            $msg = '';
        }

        return $msg;
    }
}

/***
 *              ,----------------,              ,---------,
 *         ,-----------------------,          ,"        ,"|
 *       ,"                      ,"|        ,"        ,"  |
 *      +-----------------------+  |      ,"        ,"    |
 *      |  .-----------------.  |  |     +---------+      |
 *      |  |                 |  |  |     | -==----'|      |
 *      |  |  I LOVE DOS!    |  |  |     |         |      |
 *      |  |  Bad command or |  |  |/----|`---=    |      |
 *      |  |  C:\>_          |  |  |   ,/|==== ooo |      ;
 *      |  |                 |  |  |  // |(((( [33]|    ,"
 *      |  `-----------------'  |," .;'| |((((     |  ,"
 *      +-----------------------+  ;;  | |         |,"
 *         /_)______________(_/  //'   | +---------+
 *    ___________________________/___  `,
 *   /  oooooooooooooooo  .o.  oooo /,   \,"-----------
 *  / ==ooooooooooooooo==.o.  ooo= //   ,`\--{)B     ,"
 * /_==__==========__==_ooo__ooo=_/'   /___________,"
 *
 *  以下是demo:
 */
//构建敏感词库
SensitiveTool::addKeyWord('王八蛋');
SensitiveTool::addKeyWord('王八羔子');
SensitiveTool::addKeyWord('香烟');
SensitiveTool::addKeyWord('狗儿子');
echo "<pre>";print_r(SensitiveTool::getHashMap());echo "</pre>";

//待过虑数据
$readyFilterData = [
    '王八蛋快点滚',
    '王八',
    'CNMLGBD，王八蛋狗儿子滚出去',
    '二手香烟危害更大！',
];

//过滤后的数据
$filterData = [];
foreach ($readyFilterData as $key => $data) {
    $filterData[] = SensitiveTool::filterWord($data);
}

echo "<pre>";print_r($readyFilterData);echo "</pre>";
echo "<pre>";print_r($filterData);echo "</pre>";