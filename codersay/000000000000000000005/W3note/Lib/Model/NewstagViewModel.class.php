<?php
class NewstagViewModel extends ViewModel {

public $viewFields = array(

 'News'=>array('id','title','catid','keywords','description','inputtime','username','status'),

 'Columns'=>array('colId','colTitle'=>'category', '_on'=>'Columns.colId=News.catid'),
 
 'Tagged'=>array('tagId','recordId','_on'=>'Tagged.recordId=News.id'),
 );


}



?>

