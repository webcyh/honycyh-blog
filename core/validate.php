<?php

/**
 * @Author: webcyh
 * @Date:   2020-02-19 21:05:42
 * @Last Modified by:   webcyh
 * @Last Modified time: 2020-03-06 20:28:19
 */

namespace Core;

/**
 * baseValidate
 */
class Validate
{
    protected $data = [];
    protected $rulues = [];
    protected $msg = [];
    protected $rst = [];

    protected $error = [];

    /**
     * 所有的验证器 都有的方法
     * @return [boolean] [返回验证结构]
     */
    public function check($data)
    {
        //获取所有的参数 取得要验证的参数
        foreach ($this->data as $key => $value) {
            $rst[$value] = isset($data[$value]) ? $data[$value] : '';
        }
        $this->rst = $rst;
        return $this->forcheck();//开始验证
    }

    private function forcheck()
    {
        /*对于不包含required字段的 如果存在就验证 不存在就不需要验证*/
        $rulestoArray = [];//将每个字段的验证规则进行拆分保存数值里边


        foreach ($this->rulues as $key => $value) {
            $rulestoArray[$key] = explode('|', $value);
        }
        /**
         * 遍历所有的需要验证的变量进行验证
         * @var [type]
         */
        foreach ($this->rst as $key => $value) {

            //遍历该变量对应的规则
            foreach ($rulestoArray[$key] as $key2 => $rule) {
                if ($rule == 'required' && !$value) {
                    $this->error[$key] = $this->msg[$key];
                    break;
                }
                /**
                 * 检查是否包含该方法
                 * get_class($this) 获取调用该方法的类判断该类是否存在该方法
                 */
                if (method_exists(get_class($this), $rule) ||
                    method_exists(get_class(), $rule)) {
                    if (!$this->$rule($value)) {
                        $this->error[$key] = $this->msg[$key];
                        break;
                    }
                    continue;
                }

                switch ($rule) {
                    case 'email':
                        if (!$this->verifyEmail($value)) {
                            $this->error[$key] = $this->msg[$key];
                        }
                        break;
                    case 'code':
                        if (!$this->verifycode($value)) {
                            $this->error[$key] = $this->msg[$key];
                        }
                        break;
                    case 'int':
                        if (!is_numeric($value)) {
                            $this->error[$key] = $this->msg[$key];
                        }
                        break;
                    case 'required':
                        break;
                    default:
                        list($min, $max) = explode(',', substr($rule, 6, strlen($rule) - 6));
                        $len = strlen($value);
                        if ($len < $min || $len > $max) {
                            $this->error[$key] = $this->msg[$key];
                        }
                        break;
                }
            }
        }
        return empty($this->error);
    }

    private function verifyEmail($str)
    {
        $pattern = '/^[a-z0-9]+([._-][a-z0-9]+)*@([0-9a-z]+\.[a-z]{2,14}(\.[a-z]{2})?)$/i';
        if (preg_match($pattern, $str)) {
            return true;
        } else {
            return false;
        }
    }

    private function verifycode($value)
    {
        if (isset($_SESSION['securityCode']) && strtolower($_SESSION['securityCode'])
            == strtolower(trim($value))) {
            return true;
        }
        return false;
    }

    /**
     * 返回错误信息
     * @return [Array] [错误信息]
     */

    public function errorMsg()
    {
        return implode($this->error, '<br/>');
    }

}
