<?php

namespace core\log;
use \core\register;
use \core\Core;

/**
 * 本地化调试输出到文件
 *
 * 我们这里约定日志的格式为
 * 错误类型 cli客户端  ser服务端 
 * 错误信息
 * $log->save(
		[
			'type'=>'cli',
			'message'  =>'select * from table limit 1'
		],
		true
	);
 */
class File
{
    protected $config = [
    	//是否使用单个文件 默认是数据库日志  异常日志 请求日志等分开记录
        'single'      => false,
        //文件大小
        'file_size'   => 2097152,
        //日志的位置
        'path'        => LOG_PATH,
        //最多存在多少文件
        'max_files'   => 0,
        //格式化的时间
        'time_format' =>'Ymd-H:i:s'
    ];

    // 合并参数
    public function __construct($config = [])
    {
    	/**
    	 * 用户可以动态设置或者使用config当中的或者当前日志类内置的配置
    	 * 优先级：动态配置>配置文件>日志内置
    	 */
    	if($configlog=register::_get('\core\config')->get('log')){
    		$configlog = array_merge($this->config, $configlog);
    	}
        if (is_array($config)) {
        	//合并数组
            $this->config = array_merge($configlog, $config);
        }
    }
    public function getConfig(){
    	return $this->config;
    }
    /**
     * 日志写入接口
     * @access public
     * @param  array    $log 日志信息
     * @param  bool     $append 是否追加请求信息
     * @return bool
     */
    public function save(array $log = [], $append = false)
    {
    	//获取日志文件路径
        $destination = $this->getMasterLogFile();
        p($destination);
        //获取路径
        $path = dirname($destination);
        //创建文件夹
        !is_dir($path) && mkdir($path, 0755, true);
        //日志信息  日志位置 独立文件写入 是否追加
        return $this->write($log, $destination, false, $append);
    }

    /**
     * 获取主日志文件名
     * @access public
     * @return string
     */
    protected function getMasterLogFile()
    {
    	//使用一个日志文件
        if ($this->config['single']) {
            $name = is_string($this->config['single']) ? $this->config['single'] : 'single';
            //得到单个文件路径
            $destination = $this->config['path'] . $name . '.log';
        } else {
            //判断是否有最大文件个数限制
            if ($this->config['max_files']) {
            	//创建文件路径
                $filename = date('Ymd') . '.log';
                //获取文件夹下文件个数 php内置函数
                $files    = glob($this->config['path'] . '*.log');
                //判断如果文件格式过大 删除旧的日志文件
                try {
                    if (count($files) > $this->config['max_files']) {
                    	//删除文件
                        unlink($files[0]);
                    }
                } catch (\Exception $e) {
                }
            } else {
            	//如果没有限制直接返回新的文件路径
                $filename = date('Ym') . DIRECTORY_SEPARATOR . date('d') . '.log';
            }

            $destination = $this->config['path'] . $filename;
        }

        return $destination;
    }

    

    /**
     * 日志写入
     * @access protected
     * @param  array     $message 日志信息
     * @param  string    $destination 日志文件
     * @param  bool      $apart 是否独立文件写入
     * @param  bool      $append 是否追加请求信息
     * @return bool
     */
    protected function write($message, $destination, $apart = false, $append = false)
    {
        // 检测日志文件大小，超过配置大小则备份日志文件重新生成
        $this->checkLogSize($destination);
        $info = [];
        // 日志信息封装 当前时间
        $info['timestamp'] = date($this->config['time_format']);
        //如果还是数组 将拼接成字符串并且换行
        foreach ($message as $type => $msg) {
            $info[$type] = is_array($msg) ? implode("\r\n", $msg) : $msg;
        }
        //这个是内存占用的调试信息【根据是否开启调试模式来判断是否执行】
        $this->getDebugLog($info, $append, $apart);
        //基本的错误信息
        $message = $this->parseLog($info);
        //记录完日志后并且返回日志信息 php内置的错误日志记录功能 3为向指定的文件写日志
        //更多 https://www.runoob.com/php/func-error-log.html
        return error_log($message, 3, $destination);
    }

    /**
     * 检查日志文件大小并自动生成备份文件
     * @access protected
     * @param  string    $destination 日志文件
     * @return void
     */
    protected function checkLogSize($destination)
    {
        if (is_file($destination) && floor($this->config['file_size']) <= filesize($destination)) {
            try {
            	//直接将过大的文件修改文件名还是使用当然的文件
                rename($destination, dirname($destination) . DIRECTORY_SEPARATOR . time() . '-' . basename($destination));
            } catch (\Exception $e) {
            }
        }
    }

    /**
     * 解析日志
     * @access protected
     * @param  array     $info 日志信息
     * @return string
     */
    protected function parseLog($info)
    {

        $requestInfo = Core::$debugs;

        array_unshift($info, "---------------------------------------------------------------\r\n[{$info['timestamp']}] {$requestInfo['ip']} {$requestInfo['method']} {$requestInfo['host']}{$requestInfo['uri']}");
        unset($info['timestamp']);
        //返回普通的格式
        return implode("\r\n", $info) . "\r\n";
    }
//获取条数日志信息
    protected function getDebugLog(&$info, $append, $apart)
    {
        if (Debug && $append) {
            // 获取基本信息 当前的时间-项目启动时间 并且保留10位
            $runtime = round(microtime(true) - BLOG_START_TIME, 10);
            $reqs    = $runtime > 0 ? number_format(1 / $runtime, 2) : '∞';
            //项目启动时候的内存和当前占用的内存
            $memory_use = number_format((memory_get_usage() - BLOG_START_TIME) / 1024, 2);
            //当前已经包含进来的文件格式
            $info = [
                'runtime' => number_format($runtime, 6) . 's',
                'reqs'    => $reqs . 'req/s',
                'memory'  => $memory_use . 'kb',
                'file'    => count(get_included_files()),
            ] + $info;
        }
    }
}
