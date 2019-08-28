<?php
class Model{
    protected $db = null;  //数据库连接对象

    public $data = null;  //当前表中数据
   //完成数据的链接的初始化
    public function __construct()
    {
        $this->init();
    }
    private function init()
    {
        $dbConfig=[
            'user'=>'root',
            'pass'=>'root',
            'dbname'=>'edu',
        ];
        $this->db=Db::getInstance($dbConfig);
    }

    public function getAll()
    {
        $sql="select * from student";
        return $this->data=$this->db->fetchAll($sql);
    }
}