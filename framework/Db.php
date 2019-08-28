<?php
class Db{

    private $conn=null; //私有化链接

    private $num=null;

    private $lastInsertId=null;

    private $dbConfig=[
      'user'=>'root',
      'pass'=>'root',
      'dbname'=>'edu',
      'charset'=>'utf-8',
      'host'=>'127.0.0.1',
      'db'=>'mysql',
      'port'=>3306
    ];



    private static $instance=null; //私有化实例


    private function __construct($parms=[])
    {
        $this->dbConfig=array_merge($this->dbConfig,$parms);
        $this->connect();
    }

    private function __clone()
    {
        // TODO: Implement __clone() method.
    }

    /**
     * @return Db|null
     *
     */
    public static function getInstance()
    {
        if(!self::$instance instanceof self)
        {
            return self::$instance=new self;
        }
        return self::$instance;
    }

    private function connect()
    {
        try{
            //创建数据源
            $dsn="{$this->dbConfig['db']}:host={$this->dbConfig['host']};
            port={$this->dbConfig['port']};dbname={$this->dbConfig['dbname']}";
//            print_r($dsn);die;
            //创建链接
            $this->conn=new PDO($dsn,$this->dbConfig['user'],$this->dbConfig['pass']);
            //设置客户端查询
            $this->conn->query("set NAMES {$this->dbConfig['charset']}");

        }catch (PDOException $e)
        {
            die('数据库连接失败'.$e->getMessage());
        }
    }

    public function exec($sql)
    {
        //新增、删除，修改
        $num=$this->conn->exec($sql);
        if($num>0){
            if(null !== $this->conn->lastInsertId()){
                $this->lastInsertId=$this->conn->lastInsertId();
            }
            $this->num=$num;


        }else{
            $error = $this->conn->errorInfo(); //获取最后操作的错误信息的数组
            //[0]错误标识符[1]错误代码[2]错误信息
            print '操作失败'.$error[0].':'.$error[1].':'.$error[2];
        }
    }

    public function fetch($sql)
    {
       return $this->conn->query($sql)->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * @param $sql
     */
    public function fetchAll($sql)
    {
        return $this->conn->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

}

//$a=Db::getInstance();
//
//print_r($a->fetchAll("select * from student"));
