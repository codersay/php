<?php
class BlogViewModel extends ViewModel {

public $viewFields = array(

 'Blog'=>array('id','title','catid','keywords','description','inputtime'),

 'Columns'=>array('colId','colPid','colTitle', '_on'=>'Blog.catid=Columns.colId'),

 );


}



?>

