<?php
class RelaBlogViewModel extends ViewModel {

public $viewFields = array(

 'Blog'=>array('id','title','status'),

 'Tagged'=>array('tagId','recordId','_on'=>'Tagged.recordId=Blog.id'),
 );


}



?>

