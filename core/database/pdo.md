# pdo
```text 
统一不同数据库接口 提供了数据库抽象层

特性
编码一致性
灵活性
高性能
面向对象特性

提供多种数据库扩展 我们只需要使用相应的扩展
```

配置mysql
```text
extension=php_pdo.dll 
extension=php_pdo_mysql.dll 

这样mysql就拥有相应的操作函数了
```

链接数据库
```text 
参数形式
$dsn = 'mysql:host=localhost;dbname=blog';
$username = 'root';
$passwd = 'roottest';
$pdo = new PDO($dsn,$username,$passwd)

URI
将配置写到文件dsn.txt当中
mysql:host=localhost;dbname=blog


$dns = 'uri:file://G:\php\dsn.txt'
$username = 'root';
$passwd = 'roottest';
$pdo = new PDO($dsn,$username,$passwd)


配置文件
php.ini 
pdo.dsn.imooc = "mysql:host=localhost;dbname=blog"


$dns = 'imooc'
$username = 'root';
$passwd = 'roottest';
$pdo = new PDO($dsn,$username,$passwd)
```

使用pdo对象
```text 
exec 执行sql 返回影响行数
query() 执行返回PDOStatement对象
prepare() 准备要执行的sql 返回pdostate
quote() 返回一个添加引号的字符串用于sql语句中
lastInsertId()返回最后插入的id
setAttribute() 返回数据库连接属性
getAttrbute() 得到数据库连接的属性
等 可以上官网看
```

```text 
$sql = EOF<<
create table test(
	id int not null ,
	username varchar(25) not null,
	passwd varchar(25) not null
)
>>
$rst = $pdo->exec($sql);

返回 0

$sql = 'insert into test value(1,"sdf","sf")';
$rst = $pdo->exec($sql);

返回 1

$sql = 'insert into test value(1,"sdf","sf"),value(2,"sdf","sf"),value(3,"sdf","sf")';
返回 3 

$id = $pdo->lastInsertId(); 3

更新删除

$sql = 'update test set username="sdf" where id=1';
$rst = $pdo->exec($sql);
返回 1

$id = $pdo->lastInsertId(); 0 针对插入操作

$sql = 'delete from tst where id=2'
$rst = $pdo->exec($sql);
返回 1

删除失败返回0


select语句返回0
```

错误号错误信息
```text
$res = $pdo->exec();
if($res ==false){
	//返回上一次操作的相关错误信息
	$pdo->errorCode();
	$pdo->errorInfo();
}

错误信息跟在命令行执行的一样
0=>sql状态 1 错误号 2 错误信息
```

query
```text
$sql = 'select * from test';
$stmt = $pdo->query($sql);


foreach($stmt as $row){
	$row['iD']
}



$sql = 'insert into test value(1,"sdf","sf"),value(2,"sdf","sf"),value(3,"sdf","sf")';
$pdo->query($sql);

增删改使用exec  query用于查询


```

prepare预处理

```text
prepare准备语句
execute执行预处理语句

$sql = 'insert into test value(1,"sdf","sf"),value(2,"sdf","sf"),value(3,"sdf","sf")';

$stmt = $pdo->prepare($sql);
$rst = $stmt->execute(); true

$rst&&$row = $stmt->fetch();//得到一个记录
$rst&&row = $stmt->fetchAll()

使用参数或者setFetchMode()方法设置取数据方式
$stmt->setFetchMode(PDO::FETCH_BOTH);ASSOC关联 索引
while($row = $stmt->fetch()){FETCH_OBJ 关联 对象

}


while($row = $stmt->fetch(PDO::FETCH_BOTH)){FETCH_OBJ 关联 对象

}
```

数据库连接属性
```text
$pdo->getAttribute()
$pdo->setAttribute()

$option=[
	PDO::ATTR_AUTOCOMMIT=>0
];
$pdo = new PDO($dsn,$username,$passwd,$option)

$pdo->getAttribute(constrant('PDO::ATTR_AUTOCOMMIT'))
$pdo->getAttribute(PDO::ATTR_ERRMODE)
$pdo->setAttribute(PDO::ATTR_AUTOCOMMIT,0)

更多可以看官网



```

pdostatement 对象使用
```text
https://www.imooc.com/u/112353/courses?sort=publish
```
