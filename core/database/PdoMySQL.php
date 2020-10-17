<?php 
namespace core\database;
/**
 * @https://www.runoob.com/php/php-pdo.html
 */
class PdoMySQL{
	public static $config=array();//设置连接参数，配置信息
	public static $link=null;//保存连接标识符
	public static $pconnect=false;//是否开启长连接
	public static $dbVersion=null;//保存数据库版本
	public static $connected=false;//是否连接成功
	public static $PDOStatement=null;//保存PDOStatement对象
	public static $queryStr=null;//保存最后执行的操作
	public static $error=null;//报错错误信息
	public static $lastInsertId=null;//保存上一步插入操作产生AUTO_INCREMENT
	public static $numRows=0;//上一步操作产生受影响的记录的条数
	
	public function __construct($dbConfig=''){
		if(!class_exists("PDO")){
			self::throw_exception('不支持PDO，请先开启');
		}
		if(!is_array($dbConfig)){
			$dbConfig=array(
			'hostname'=>DB_HOST,
			'username'=>DB_USER,
			'password'=>DB_PWD,
			'database'=>DB_NAME,
			'hostport'=>DB_PORT,
			'dbms'=>DB_TYPE,
			'dsn'=>DB_TYPE.":host=".DB_HOST.";dbname=".DB_NAME
			);
		}
		if(empty($dbConfig['hostname']))self::throw_exception('没有定义数据库配置，请先定义');
		self::$config=$dbConfig;
		if(empty(self::$config['params']))self::$config['params']=array();
		if(!isset(self::$link)){
			$configs=self::$config;
			if(self::$pconnect){
				//开启长连接，添加到配置数组中
				$configs['params'][constant("PDO::ATTR_PERSISTENT")]=true;
			}
			try{
				self::$link=new PDO($configs['dsn'],$configs['username'],$configs['password'],$configs['params']);
			}catch(PDOException $e){
				self::throw_exception($e->getMessage());
			}
			if(!self::$link){
				self::throw_exception('PDO连接错误');
				return false;
			}
			self::$link->exec('SET NAMES '.DB_CHARSET);
			self::$dbVersion=self::$link->getAttribute(constant("PDO::ATTR_SERVER_VERSION"));
			self::$connected=true;
			unset($configs);
		}
	}
	
	
	public static function getAll($sql=null){
		if($sql!=null){
			self::query($sql);
		}
		
		$result=self::$PDOStatement->fetchAll(constant("PDO::FETCH_ASSOC"));
		return $result;
	}
	
	public static function getRow($sql=null){
		if($sql!=null){
			self::query($sql);
		}
		$result=self::$PDOStatement->fetch(constant("PDO::FETCH_ASSOC"));
		return $result;
	}
	
	public static function findById($tabName,$priId,$fields='*'){
		$sql='SELECT %s FROM %s WHERE id=%d';
		return self::getRow(sprintf($sql,self::parseFields($fields),$tabName,$priId));
	}
	
	
	public static function find($tables,$where=null,$fields='*',$group=null,$having=null,$order=null,$limit=null){
		$sql='SELECT '.self::parseFields($fields).' FROM '.$tables
		.self::parseWhere($where)
		.self::parseGroup($group)
		.self::parseHaving($having)
		.self::parseOrder($order)
		.self::parseLimit($limit);
		$dataAll=self::getAll($sql);
		return count($dataAll)==1?$dataAll[0]:$dataAll;
	}
	
	public static function add($data,$table){
		$keys=array_keys($data);
		array_walk($keys,array('PdoMySQL','addSpecialChar'));
		$fieldsStr=join(',',$keys);
		$values="'".join("','",array_values($data))."'";
		$sql="INSERT {$table}({$fieldsStr}) VALUES({$values})";
	
		return self::execute($sql);
	} 
	
	public static function update($data,$table,$where=null,$order=null,$limit=0){
		foreach($data as $key=>$val){
			$sets.=$key."='".$val."',";
		}
		//echo $sets;
		$sets=rtrim($sets,',');
		$sql="UPDATE {$table} SET {$sets} ".self::parseWhere($where).self::parseOrder($order).self::parseLimit($limit);
		return self::execute($sql);
	}
	
	public static function delete($table,$where=null,$order=null,$limit=0){
		$sql="DELETE FROM {$table} ".self::parseWhere($where).self::parseOrder($order).self::parseLimit($limit);
		return self::execute($sql);
	}
	
	public static function getLastSql(){
		$link=self::$link;
		if(!$link)return false;
		return self::$queryStr;
	}
	
	public static function getLastInsertId(){
		$link=self::$link;
		if(!$link)return false;
		return self::$lastInsertId;
	}
	
	public static function getDbVerion(){
		$link=self::$link;
		if(!$link)return false;
		return self::$dbVersion;
	}
	
	public static function showTables(){
		$tables=array();
		if(self::query("SHOW TABLES")){
			$result=self::getAll();
			foreach($result as $key=>$val){
				$tables[$key]=current($val);
			}
		}
		return $tables;
	}
	
	public static function parseWhere($where){
		$whereStr='';
		if(is_string($where)&&!empty($where)){
			$whereStr=$where;
		}
		return empty($whereStr)?'':' WHERE '.$whereStr;
	}
	
	public static function parseGroup($group){
		$groupStr='';
		if(is_array($group)){
			$groupStr.=' GROUP BY '.implode(',',$group);
		}elseif(is_string($group)&&!empty($group)){
			$groupStr.=' GROUP BY '.$group;
		}
		return empty($groupStr)?'':$groupStr;
	}
	
	public static function parseHaving($having){
		$havingStr='';
		if(is_string($having)&&!empty($having)){
			$havingStr.=' HAVING '.$having;
		}
		return $havingStr;
	}
	
	public static function parseOrder($order){
		$orderStr='';
		if(is_array($order)){
			$orderStr.=' ORDER BY '.join(',',$order);
		}elseif(is_string($order)&&!empty($order)){
			$orderStr.=' ORDER BY '.$order;
		}
		return $orderStr;
	}
	
	public static function parseLimit($limit){
		$limitStr='';
		if(is_array($limit)){
			if(count($limit)>1){
				$limitStr.=' LIMIT '.$limit[0].','.$limit[1];
			}else{
				$limitStr.=' LIMIT '.$limit[0];
			}
		}elseif(is_string($limit)&&!empty($limit)){
			$limitStr.=' LIMIT '.$limit;
		}
		return $limitStr;
	}
	
	public static function parseFields($fields){
		if(is_array($fields)){
			array_walk($fields,array('PdoMySQL','addSpecialChar'));
			$fieldsStr=implode(',',$fields);
		}elseif(is_string($fields)&&!empty($fields)){
			if(strpos($fields,'`')===false){
				$fields=explode(',',$fields);
				array_walk($fields,array('PdoMySQL','addSpecialChar'));
				$fieldsStr=implode(',',$fields);
			}else{
				$fieldsStr=$fields;
			}
		}else{
			$fieldsStr='*';
		}
		return $fieldsStr;
	}
	
	public static function addSpecialChar(&$value){
		if($value==='*'||strpos($value,'.')!==false||strpos($value,'`')!==false){
			//不用做处理
		}elseif(strpos($value,'`')===false){
			$value='`'.trim($value).'`';
		}
		return $value;
	}
	
	public static function execute($sql=null){
		$link=self::$link;
		if(!$link) return false;
		self::$queryStr=$sql;
		if(!empty(self::$PDOStatement))self::free();
		
		$result=$link->exec(self::$queryStr);
		self::haveErrorThrowException();
		if($result){
			self::$lastInsertId=$link->lastInsertId();
			self::$numRows=$result;
			return self::$numRows;
		}else{
			return false;
		}
	}
	
	public static function free(){
		self::$PDOStatement=null;
	}
	public static function query($sql=''){
		$link=self::$link;
		if(!$link) return false;
		//判断之前是否有结果集，如果有的话，释放结果集
		if(!empty(self::$PDOStatement))self::free();
		self::$queryStr=$sql;
		//预处理 返回stmt对象
		self::$PDOStatement=$link->prepare(self::$queryStr);
		//执行
		$res=self::$PDOStatement->execute();
		self::haveErrorThrowException();
		return $res;
	}
	public static function haveErrorThrowException(){
		$obj=empty(self::$PDOStatement)?self::$link: self::$PDOStatement;
		//返回执行错误信息 errorCode 错误号
		$arrError=$obj->errorInfo();
		//print_r($arrError);
		if($arrError[0]!='00000'){
			self::$error='SQLSTATE: '.$arrError[0].' <br/>SQL Error: '.$arrError[2].'<br/>Error SQL:'.self::$queryStr;
			self::throw_exception(self::$error);
			return false;
		}
		if(self::$queryStr==''){
			self::throw_exception('没有执行SQL语句');
			return false;
		}
	}
	
	public static function throw_exception($errMsg){
		echo '<div style="width:80%;background-color:#ABCDEF;color:black;font-size:20px;padding:20px 0px;">
				'.$errMsg.'
		</div>';
	}
	public static function close(){
		self::$link=null;
	}
	
}