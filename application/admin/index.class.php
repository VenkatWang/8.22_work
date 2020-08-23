<?php
if(!defined("MVC")){
    die("非法入侵");
}
//use \libs\smarty;
use \libs\db;
use \libs\code;
use \libs\cookie;
class index extends main{
    function int(){
        $this->smarty->display("admin/login.html");
//        $smarty=new Smarty();
//        $smarty->setTemplateDir(TPL_PATH);
//        $smarty->setCompileDir(COMPILE_PATH);
//        $smarty->display("admin/login.html");
    }
    function login(){
//        $uname=addslashes($_POST["uname"]);
//        $pass=md5(md5($_POST["pass"]));
        $uname=$_POST["uname"];
        $pass=$_POST["pass"];
        echo $uname;
        echo $pass;
        if(strlen($uname)<3||empty($pass)){
            echo "用户名或密码不符合规范";
            return;
        }
        if(!(isset($_COOKIE["code"])&&$_COOKIE["code"]==$_POST["code"])){
             echo "验证码有误";
             return;
        }
//        $db=new mysqli("localhost","root","123456","wui2006","3308");
//        if(mysqli_connect_error()){
//            die("数据库连接错误");
//        }
        $db=$this->db;
        $result=$db->query("select * from mvcuser where uname='$uname'and pass='$pass'");
        if($result->num_rows<1){
            echo "没有相应数据，请重新登录";
        }else{
            $cookie=new cookie();
            $cookie->setCookie("login","yes");
            header("location:first");
        }
    }
    function first(){
        $cookie=new cookie();
        if($cookie->setCookie("login")&&$cookie->getCookie("login")=="yes"){
            echo "后台首页";
        }else{
            header("/admin");
        }

    }
    function mycode(){
        $code=new code();
        $code->codeLen=4;
        $code->height=40;
        $code->width=100;
        $code->lineNum["min"]=2;
        $code->lineNum["max"]=4;
        $code->fontSize["min"]=25;
        $code->out();
        //php中设置cookie


    }

}