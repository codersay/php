<?php
class NewsViewModel extends ViewModel {

public $viewFields = array(

 'News'=>array('id','title','catid','keywords','description','inputtime'),

 'Columns'=>array('colId','colPid','colTitle', '_on'=>'News.catid=Columns.colId'),

 );


}



?>

