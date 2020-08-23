<?php
namespace libs;
class code {
    public $type="png";
    public $width=160;
    public $height=60;
    public $codeLen=4;
    public $seed="abcdefhjkmnABCDFEGKJHOUY123456789";

    public $fontSize=array("min"=>15,"max"=>30);
    public $fontAngle=array("min"=>-15,"max"=>15);
    public $lineNum=array("min"=>2,"max"=>4);
    public $lineWidth=array("min"=>1,"max"=>4);
    public $pixNum=array("min"=>30,"max"=>50);
    //2.创建画布
    private function createCanvas(){
        $this->image=imagecreatetruecolor($this->width,$this->height);
        imagefill($this->image,0,0,$this->setColor());
    }
    private function setColor($type="background"){
           $r=$type=="background"?mt_rand(126,255):mt_rand(0,125);
           $g=$type=="background"?mt_rand(126,255):mt_rand(0,125);
           $b=$type=="background"?mt_rand(126,255):mt_rand(0,125);

           return imagecolorallocate($this->image,$r,$g,$b);
    }
    private function getText(){//获得随机种子
        $str="";
        for($i=0;$i<$this->codeLen;$i++){
            $str.=$this->seed[mt_rand(0,strlen($this->seed)-1)];
        }
        return $str;
    }
//    public function getStr(){
//        return strtolower($this->getText());
//    }
    private function setText(){
        $str=$this->getText();
        $this->str= strtolower($str);
        for($i=0;$i<$this->codeLen;$i++) {
            $size = mt_rand($this->fontSize["min"], $this->fontSize["max"]);  //字体大小
            $angle = mt_rand($this->fontAngle["min"], $this->fontAngle["max"]);  //角度
            $space = $this->width / ($this->codeLen * 2 - 1);
            imagettftext($this->image, $size, $angle, mt_rand(max(($i*2-1)*$space,0)+5, ($i*2+1)*$space-5), 30, $this->setColor("a"), "D:/software/wampserver/www/server/mvc-test/application/static/font/simkai.ttf", $str[$i]);
        }
    }
    //设置线条
    private function setLine(){
        $num=mt_rand($this->lineNum["min"],$this->lineNum["max"]);
        for($i=0;$i<$num;$i++) {

            $x1 = mt_rand(0, $this->width / 2);
            $x2 = mt_rand($this->width / 2, $this->width);
            $y1 = mt_rand(0, $this->height / 2);
            $y2 = mt_rand($this->height / 2, $this->height);
            imagesetthickness($this->image, mt_rand($this->lineWidth["min"], $this->lineWidth["max"]));
            imageline($this->image, $x1, $y1, $x2, $y2,$this->setColor("a"));
        }
    }
    private function setPix(){
        $num=mt_rand($this->pixNum["min"],$this->pixNum["max"]);
        for($i=0;$i<$num;$i++){
            imagesetpixel($this->image,mt_rand(0,$this->width),mt_rand(0,$this->height),$this->setColor("a"));
        }
    }

    //1.指定输出的格式
    function out(){
        header("content-type:image/".$this->type);
        //1.创建画布
        $this->createCanvas();
        //2.写文字
        $this->setText();
        $this->setLine();
        $this->setPix();
        //5.写入cookie
        setcookie("code",$this->str,0,"/");
        $outtype="image".$this->type;  //imagepng
        $outtype($this->image);
        imagedestroy($this->image); //注销画布
    }
}
//$code=new code();
//$code->width=100;
//$code->height=30;
//$code->out();
