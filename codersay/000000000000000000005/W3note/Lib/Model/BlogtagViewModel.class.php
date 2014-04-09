<?php
class BlogtagViewModel extends ViewModel {

public $viewFields = array(

 'Blog'=>array('id','title','catid','keywords','description','inputtime','username','status'),

 'Columns'=>array('colId','colTitle'=>'category', '_on'=>'Columns.colId=Blog.catid'),
 
 'Tagged'=>array('tagId','recordId','_on'=>'Tagged.recordId=Blog.id'),
 );


}



?>

