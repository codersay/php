<?php
class UploadModel extends RelationModel{
    protected $_link = array(
        'Posts'=>array(
           'mapping_type'=>BELONGS_TO,
           'class_name'=>'Posts',
           'foreign_key'=>'post_id',
           'as_fields'=>'post_title',
        ),
        
         'Categories'=>array(
           'mapping_type'=>BELONGS_TO,
           'class_name'=>'Categories',
           'foreign_key'=>'cat_id',
           'as_fields'=>'cat_name',
       ),

        
    );
    
}
?>
