<?php
/**
 *  导出Excel类
 */
class ExcelWriter
{
    var $charset = 'utf-8';
    var $filename;
    var $rows = array();

    function ExcelWriter($charset, $filename)
    {
        $this->filename = $filename;
        $this->charset = $charset;
    }

    /**
     * 增加一行
     *
     * @author  Sphenginx
     * @return  array
     */
    function &add_row()
    {
        $i = count($this->rows);
        $this->rows[$i] = array();

        return $this->rows[$i];
    }

    /**
     * 增加一列
     *
     * @author  Sphenginx
     * @param   array   $row
     * @param   mix     $val
     * @return  void
     */
    function add_col(&$row, $val)
    {
        $row[] = $val;
    }

    /**
     * 增加整个数组到Excel中
     *
     * @author  Sphenginx
     * @param   array   $arr
     * @return  boolean
     */
    function add_array($arr)
    {
        if (empty($arr) || !is_array($arr))
        {
            trigger_error('Not a valid array', E_USER_WARNING);
            return;
        }

        foreach ($arr AS $key=>$val)
        {
            if (is_array($val))
            {
                $row =& $this->add_row();
                foreach ($val AS $k=>$v)
                {
                    $this->add_col($row, $v);
                }
            }
        }
    }

    /**
     * 获得该文档的内容
     *
     * @author  Sphenginx
     * @return  string
     */
    function _fetch()
    {
        $excel = $this->_get_header();

        foreach ($this->rows AS $key=>$val)
        {
            $excel .= "<tr>\r\n";
            foreach ($val AS $k=>$v)
            {
                $excel .= "  <td class=xl24 width=64 >{$v}</td>\r\n";
            }
            $excel .= "</tr>\r\n";
        }

        $excel .= $this->_get_footer();

        return $excel;
    }

    /**
     * 输出到浏览器，通知用户下载
     *
     * @author  Sphenginx
     * @return  void
     */
    function output()
    {
        header("Content-type: application/vnd.ms-excel; charset={$this->charset}");
        header("Content-Disposition: attachment; filename={$this->filename}.xls");

        echo $this->_fetch();
    }


    /**
     * 获得excel文件的头部
     *
     * @author  Sphenginx
     * @return  string
     */
    function _get_header()
    {
        $header = <<<EOH
<html xmlns:o="urn:schemas-microsoft-com:office:office"
xmlns:x="urn:schemas-microsoft-com:office:excel"
xmlns="http://www.w3.org/TR/REC-html40">

<head>
<meta http-equiv=Content-Type content="text/html; charset=%s">
<meta name=ProgId content=Excel.Sheet>
<!--[if gte mso 9]><xml>
 <o:DocumentProperties>
  <o:LastAuthor>Sriram</o:LastAuthor>
  <o:LastSaved>2005-01-02T07:46:23Z</o:LastSaved>
  <o:Version>10.2625</o:Version>
 </o:DocumentProperties>
 <o:OfficeDocumentSettings>
  <o:DownloadComponents/>
 </o:OfficeDocumentSettings>
</xml><![endif]-->
<style>
<!--table
    {mso-displayed-decimal-separator:"\.";
    mso-displayed-thousand-separator:"\,";}
@page
    {margin:1.0in .75in 1.0in .75in;
    mso-header-margin:.5in;
    mso-footer-margin:.5in;}
tr
    {mso-height-source:auto;}
col
    {mso-width-source:auto;}
br
    {mso-data-placement:same-cell;}
.style0
    {mso-number-format:General;
    text-align:general;
    vertical-align:bottom;
    white-space:nowrap;
    mso-rotate:0;
    mso-background-source:auto;
    mso-pattern:auto;
    color:windowtext;
    font-size:10.0pt;
    font-weight:400;
    font-style:normal;
    text-decoration:none;
    font-family:Arial;
    mso-generic-font-family:auto;
    mso-font-charset:0;
    border:none;
    mso-protection:locked visible;
    mso-style-name:Normal;
    mso-style-id:0;}
td
    {mso-style-parent:style0;
    padding-top:1px;
    padding-right:1px;
    padding-left:1px;
    mso-ignore:padding;
    color:windowtext;
    font-size:10.0pt;
    font-weight:400;
    font-style:normal;
    text-decoration:none;
    font-family:Arial;
    mso-generic-font-family:auto;
    mso-font-charset:0;
    mso-number-format:General;
    text-align:general;
    vertical-align:bottom;
    border:none;
    mso-background-source:auto;
    mso-pattern:auto;
    mso-protection:locked visible;
    white-space:nowrap;
    mso-rotate:0;}
.xl24
    {mso-style-parent:style0;
    white-space:normal;}
-->
</style>
<!--[if gte mso 9]><xml>
 <x:ExcelWorkbook>
  <x:ExcelWorksheets>
   <x:ExcelWorksheet>
    <x:Name>srirmam</x:Name>
    <x:WorksheetOptions>
     <x:Selected/>
     <x:ProtectContents>False</x:ProtectContents>
     <x:ProtectObjects>False</x:ProtectObjects>
     <x:ProtectScenarios>False</x:ProtectScenarios>
    </x:WorksheetOptions>
   </x:ExcelWorksheet>
  </x:ExcelWorksheets>
  <x:WindowHeight>10005</x:WindowHeight>
  <x:WindowWidth>10005</x:WindowWidth>
  <x:WindowTopX>120</x:WindowTopX>
  <x:WindowTopY>135</x:WindowTopY>
  <x:ProtectStructure>False</x:ProtectStructure>
  <x:ProtectWindows>False</x:ProtectWindows>
 </x:ExcelWorkbook>
</xml><![endif]-->
</head>

<body link=blue vlink=purple>
<table x:str border=0 cellpadding=0 cellspacing=0 style='border-collapse: collapse;table-layout:fixed;'>

EOH;
        return sprintf($header, $this->charset);
    }

    /**
     * 获得excel文件的结尾部分
     *
     * @author  Sphenginx
     * @return  string
     */
    function _get_footer()
    {
        return "</table></body></html>";
    }
};

?>