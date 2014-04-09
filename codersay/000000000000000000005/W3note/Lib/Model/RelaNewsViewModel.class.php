<?php
class RelaNewsViewModel extends ViewModel {

    public $viewFields = array(

        'News'=>array('id','title','status'),

        'Tagged'=>array('tagId','recordId','_on'=>'Tagged.recordId=News.id'),
      );
}
?>