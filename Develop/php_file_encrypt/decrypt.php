<?php
/**
 * PHP混淆解密
 *
 * @return void
 * @author Sphenginx
 **/
function unscrambler($code) 
{
  if(! is_array($code)) {
    $code = str_replace('__FILE__', "'$code'", str_replace('eval', '$code=', file_get_contents($code)));
    eval('?>' . $code);
  }else {
    extract($code);
    $code = str_replace("eval", '$code=', $code);
    eval($code);
  }
  if(strstr($code, 'eval')) 
  	return unscrambler(get_defined_vars());
  else 
  	return $code;
}
// echo unscrambler('需要还原的代码或文件名');
echo unscrambler('create/create.php');