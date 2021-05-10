<?php
error_reporting( E_ALL&~E_NOTICE );
class ToNum {
    public function float_to_num($str) {
        $str = preg_replace('/([0-9])([0-9]{2})$/', '$1.$2', $str);
        $str = preg_replace('/([0-9])([0-9]{2}\.)/', '$1.$2', $str);
        $str = preg_replace('/([0-9])([0-9]{2}\.)/', '$1.$2', $str);
        $str = preg_replace('/([0-9])([0-9]{2}\.)/', '$1.$2', $str);
        $str = preg_replace('/\.0([1-9])/', '.$1', $str);
        $str = preg_replace('/\.00/', '', $str);
        return $str;
    }
}

class ToFloat {
    protected $array = array();
    public function num_to_float($num) {
        $str = preg_replace('/^([0-9]{1,2})\./', '${1}a', $num);
        $str = preg_replace('/\.([1-9])\./', '.0${1}.', $str);
        $str = preg_replace('/\.([1-9])\./', '.0${1}.', $str);
        $str = preg_replace('/\.([1-9])$/', '.0${1}', $str);
        $str = preg_replace('/a([1-9])\./', 'a${1}b', $str);
        $str = preg_replace('/\./', '', $str);
        $str = preg_replace('/a([1-9]b)/', 'a0${1}', $str);
        $str = preg_replace('/b/', '', $str);
        $str = preg_replace('/a([1-9])$/', 'a0${1}', $str);
        $str = preg_replace('/a/', '.', $str);
        $str = $str * 1e8;
        $str = (string)$str;
        return $str;
    }
    public function arr_to_float($array) {
        $count = count($array);
        for ($i = 0; $i < ($count+1)/8; $i++) {
            $array[1+8*$i] = $this->num_to_float($array[1+8*$i]);
        }
        return array_filter($array);
    }
}

class ReadExcel{
    protected $arr_text = array();
    public function csv_to_array($path) {
        $text_str = file_get_contents($path);
        $trim_text = trim($text_str);//去除换行符、制表符、多余空格
        $replace_text = preg_replace('/`/', '^`', $trim_text);
        $replace_text = preg_replace('/(.)$/', '${1}^', $replace_text);
        $replace_text = preg_replace('/([\x{4e00}-\x{9fa5}])([\s\^]*)$/u', '${1}', $replace_text);
        $replace_text = preg_replace('/([\^])/', '', $replace_text,1);
        $this->arr_text = explode('^', $replace_text);
        return $this->arr_text;
    }
}

class InputFilter { 
    public function input_filter($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
}

class DiffCss{
    static function justice($string) {
        $arr = explode('.', $string);
        $num = count($arr);
        switch ($num){
            case '1':return 'title1';break;
            case '2':return 'title2';break;
            case '3':return 'title3';break;
            case '4':return 'title4';break;
            case '5':return 'title5';break;
            default:return 'title1';break;
        }
    }
}