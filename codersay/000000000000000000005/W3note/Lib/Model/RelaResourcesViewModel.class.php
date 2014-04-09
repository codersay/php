<?php
class RelaResourcesViewModel extends ViewModel {

public $viewFields = array(

 'Resources'=>array('id','title','status'),

 'Tagged'=>array('tagId','recordId','_on'=>'Tagged.recordId=Resources.id'),
 );


}



?>

