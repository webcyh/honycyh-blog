<?php
namespace lib;

class Vcode{
    private $width;//图片宽度
    private $height;//高度
    private $num;//字符个数
    private $codeString;//字符内容
    private $img;//图片资源
    private $pixnum;//点个数
    function __construct($h,$w,$n){
        //设置宽高以及要展示的字符的个数
        $this->width = $w;
        $this->height = $h;
        $this->num = $n;
        //设置点个数平均每10平方像素有一个
        $this->pixnum = floor(($this->width*$this->height)/10);
        //获取字符串 并且记录到session当中
        $this->codeString = $this->createString();//开始创建字符
    }
    //当将对象作为字符串输出时候调用的时候 创建画布填充 填充点 填充文字 输出图像
    function __toString(){
        $this->createimage();
        $this->setPixel();
        $this->setText();
        $this->outputImage();
    }
    //创建画布
    private function createimage(){
        //白布
        $this->img = imagecreatetruecolor($this->width,$this->height);
        //样式
        $bg = imagecolorallocate($this->img,rand(225,255),rand(225,255),rand(225,255));
        //填充
        imagefill($this->img,0,0,$bg);
        $border = imagecolorallocate($this->img,0,0,0);
        //矩形
        imagerectangle($this->img,1,1,$this->width-1,$this->height-1,$border);
    }
    //绘制点
    private function setPixel(){
        for($i=1;$i<=$this->pixnum;$i++){
            $rand = rand(0,100);
            //样式for控制水平位置 $rand 为垂直位置
            $color = imagecolorallocate($this->img,rand(0,255),rand(0,255),rand(0,255));
            imagesetpixel($this->img,$i,$rand,$color);
        }
    }
    //设置文字
    private function setText(){
        $char = $this->codeString;
        $len = strlen($this->codeString);
        $every = floor($this->width/$this->num);
        for($i=0;$i<$len;$i++){

            $x = $every*$i+$every/2;
            $fontsize = rand(17,30);
            $color = imagecolorallocate($this->img,rand(0,255),rand(0,255),rand(0,255));
            imagechar($this->img,$fontsize,$x,rand(0,$this->height-$fontsize),$char[$i],$color);
        }
    }
    //输出图片
    private function outputImage(){
        if(function_exists('imagepng')){
            header('Content-type:image/png');
        }else if(function_exists('imagejpg')){
            header('Content-type:image/jpg');
        }
        imagepng($this->img);
    }
    //创建验证码
    private function createString(){
        $str = '3456789abcdefghjkmnprstuvwxy';
        $len = strlen($str);
        $code = '';
        for($i=0;$i<$this->num;$i++){
            $code.=$str[rand(0,$len-1)];
        }
        $_SESSION['securityCode'] = $code;
        return $code;
    }
}



