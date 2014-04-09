<?php
class BlogtypeViewModel extends ViewModel {

public $viewFields = array(

 'Blog'=>array('id','title','typeid','keywords','description','inputtime','username','userid','status'),
 
 'Type'=>array('typename','_on'=>'Type.id=Blog.typeid'),
 );


}



?>

