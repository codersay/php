<?php
//
class AdminAction extends Action{
    function _initialize(){
        A("Admin.Login")->checkLogin();
    }
}
?>