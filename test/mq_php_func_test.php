#
#  Copyright (c) 2013 UCWeb Inc.
#
# This program is free software; you can redistribute it and/or modify
# it under the terms of the GNU General Public License version 2 as
# published by the Free Software Foundation.
# You may obtain a copy of the License at
#
#       http://www.gnu.org/licenses/gpl-2.0.html
#
# Email: osucmq@ucweb.com
# Author: ShaneYuan

########################
#  copyright: ucweb 
#  author: ShaneYuan   Email: yuancy@ucweb.com
#  describe: ucmq's client php extension mouble functional test
#  usage: php mq_functional_test.php
########################
<?php
// default argument
$ip='192.168.3.171';
$port=1218;
$name=1111;

// check for all required arguments 
if ($argc != 6) { 
    die("Usage: $argv[0] <ip> <port> <name> <timeout> <string> \n"); 
}

// remove first argument 
array_shift($argv);

// get and use remaining arguments 
$ip = $argv[0]; 
$port = $argv[1]; 
$name = $argv[2]; 
$t = $argv[3];
$char = $argv[4];
$success=0 ;
$fail=0;
$arr=array( "$ip:1218");

//print env
date_default_timezone_set("PRC"); 
################
echo "---- test start ----\n";
echo "ip = $ip \t";
echo "port = $port\t ";
echo "queue_name = $name\t";
echo "timeout = $t\n";
$time = date('h:i:s A');
echo "---- $time ----\n\n";
###########################

// gen put mesg 
function gen_data($data_len)
{
    $data = 1;
    for($i=0; $i<$data_len; $i++)
    {   
        $data = "1"."$data";
    }   
    return $data;
}

function put($i, $p, $n, $value, $t, $char)
{
    $result=mq_put_msg("$i:$p", "$n", "$value", $t, $char);
    $ret=$result["result"];
    //if($ret != 0)
    //{
    echo "\nresult\tindex\tpos\thttpcode\treason\tdata\n";
    echo $result["result"]."\t";
    echo $result["index"]."\t";
    echo $result["pos"]."\t";
    echo $result["httpcode"]."\t";
    echo $result["reason"]."\t";
    echo $result["data"];
    echo "[end put]{$char}\n";
    $he=trim($result["httpcode"]);
    if($char == $he)
    {
        echo "success\n";
        global $success;
        $success++;
    }
    else
    {
        echo "!!!!!!error\n";
        global $fail;
        $fail++;
    }
    //}
}

function get($i, $p, $n, $t, $char)
{
    //$arr=array("$i:$p");
    $result=mq_get_msg("$i:$p", "$n", $t ,$char);
    //$ret=$result["result"];
    //echo "printf ret = $ret\n";
    //if($ret != 0)
    //{
    echo "\nresult,\tindex\tpos\thttpcode\treason\tdata\n"; 
    echo $result["result"]."\t";
    echo $result["index"]."\t";
    echo $result["pos"]."\t";
    echo $result["httpcode"]."\t";
    echo $result["reason"]."\t";
    echo $result["data"];
    echo "\n[end get] {$char} \n";
    $he=trim($result["httpcode"]);
    if($char == $he)
    {
        echo "success\n";
        global $success;
        ++$success;
    }
    else
    {
        echo "!!!!!!error\n";
        global $fail;
        ++$fail;
    }
    //}
    #else
    #{
    #    echo "error mesg";
    #}
}

function view($i, $p, $n, $opt, $value, $t, $char)
{
    $result=mq_get_opt("$i:$p", "$n", "$opt", "$value", $t, $char);
    echo "\nresult\tindex\tpos\thttpcode\treason\tdata\n";
    echo $result["result"]."\t";
    echo $result["index"]."\t";
    echo $result["pos"]."\t";
    echo $result["httpcode"]."\t";
    echo $result["reason"]."\t";
    echo $result["data"];
    echo "\n[end view] {$char}\n";
    $he=trim($result["httpcode"]);
    if($char == $he)
    {
        echo "success\n";
        global $success;
        ++$success;
    }
    else
    {
        echo "!!!!!!error\n";
        global $fail;
        ++$fail;
    }
}

function status($i, $p, $n, $opt, $value, $t, $char)
{
    $result=mq_get_opt("$i:$p", "$n", "$opt", "$value", $t, $char);
    echo "\nresult\tindex\tpos\thttpcode\treason\tdata\n";
    echo $result["result"]."\t";
    echo $result["index"]."\t";
    echo $result["pos"]."\t";
    echo $result["httpcode"]."\t";
    echo $result["reason"]."\t";
    echo $result["data"];
    echo "\n[end status] {$char} \n";
    $he=trim($result["httpcode"]);
    if($char == $he)
    {
        echo "success\n";
        global $success;
        ++$success;
    }
    else
    {
        echo "!!!!!!error\n";
        global $fail;
        ++$fail;
    }
}

function status_json($i, $p, $n, $opt, $value, $t, $char)
{
    $result=mq_get_opt("$i:$p", "$n", "status_json", "$value", $t, $char);
    echo "\nresult\tindex\tpos\thttpcode\treason\tdata\n";
    echo $result["result"]."\t";
    echo $result["index"]."\t";
    echo $result["pos"]."\t";
    echo $result["httpcode"]."\t";
    echo $result["reason"]."\t";
    echo $result["data"];
    echo "\n[end status_json] {$char} \n";
    $he=trim($result["httpcode"]);
    if($char == $he)
    {
        echo "success\n";
        global $success;
        ++$success;
    }
    else
    {
        echo "!!!!!!error\n";
        global $fail;
        ++$fail;
    }
}

function maxqueue($i, $p, $n, $opt, $value, $t, $char )
{
    $result=mq_set_opt("$i:$p", "$n", "maxqueue", $value, $t, $char);
    echo "\nresult\tindex\tpos\thttpcode\treason\tdata\n";
    echo $result["result"]."\t";
    echo $result["index"]."\t";
    echo $result["pos"]."\t";
    echo $result["httpcode"]."\t";
    echo $result["reason"]."\t";
    echo $result["data"];
    echo "[end maxqueue] {$char}\n";
    $he=trim($result["httpcode"]);
    if($char == $he)
    {
        echo "success\n";
        global $success;
        ++$success;
    }
    else
    {
        echo "!!!!!!error\n";
        global $fail;
        ++$fail;
    }
}
function delay($i, $p, $n, $opt, $value, $t, $char )
{
    $result=mq_set_opt("$i:$p", "$n", "delay", $value, $t, $char);
    echo "\nresult\tindex\tpos\thttpcode\treason\tdata\n";
    echo $result["result"]."\t";
    echo $result["index"]."\t";
    echo $result["pos"]."\t";
    echo $result["httpcode"]."\t";
    echo $result["reason"]."\t";
    echo $result["data"];
    echo "[end delay] {$char}\n";
    $he=trim($result["httpcode"]);
        if($char == $he)
    {
        echo "success\n";
        global $success;
        ++$success;
    }
    else
    {
        echo "!!!!!!error\n";
        global $fail;
        ++$fail;
    }
}

function mq_reset($i, $p, $n, $opt, $value, $t, $char )
{
    $result=mq_set_opt("$i:$p", "$n", "$opt", $value, $t, $char);
    echo "\nresult\tindex\tpos\thttpcode\treason\tdata\n";
    echo $result["result"]."\t";
    echo $result["index"]."\t";
    echo $result["pos"]."\t";
    echo $result["httpcode"]."\t";
    echo $result["reason"]."\t";
    echo $result["data"];
    echo "[end reset] {$char}\n";
    $he=trim($result["httpcode"]);
    if($char == $he)
    {
        echo "success\n";
        global $success;
        ++$success;
    }
    else
    {
        echo "!!!!!!error\n";
        global $fail;
        ++$fail;
    }
}

function synctime($i, $p, $n, $opt, $value, $t, $char )
{
    $result=mq_set_opt("$i:$p", "$n", "$opt", 10, $t, $char );
    echo "\nresult\tindex\tpos\thttpcode\treason\tdata\n";
    echo $result["result"]."\t";
    echo $result["index"]."\t";
    echo $result["pos"]."\t";
    echo $result["httpcode"]."\t";
    echo $result["reason"]."\t";
    echo $result["data"];
    echo "[end synctime] {$char} \n";
    $he=trim($result["httpcode"]);
    if($char == $he)
    {
        echo "success\n";
        global $success;
        ++$success;
    }
    else
    {
        echo "!!!!!!error\n";
        global $fail;
        ++$fail;
    }
}

function remove($i, $p, $n, $opt, $value, $t, $char)
{
    $result=mq_set_opt("$i:$p", "$n", "$opt" , $value, $t, $char);
    echo "\nresult\tindex\tpos\thttpcode\treason\tdata\n";
    echo $result["result"]."\t";
    echo $result["index"]."\t";
    echo $result["pos"]."\t";
    echo $result["httpcode"]."\t";
    echo $result["reason"]."\t";
    echo $result["data"];
    echo "[end remove]{$char} \n";
    $he=trim($result["httpcode"]);
    if($char == $he)
    {
        echo "success\n";
        global $success;
        ++$success;
    }
    else
    {
        echo "!!!!!!error\n";
        ++$fail;
    }
}

#���Զ���δ��ʼ��ʱ�ĸ�������
function test_1( $ip, $port, $name, $t, $char)
{
    $t = 1000;
    $value = "11";
    echo "------test 1 --------\n";
    maxqueue($ip, $port, "000", "maxqueue", 1000000000, $t, "200" );
    delay($ip, $port, "0000", "delay", 10, $t, "200" );
    put($ip, $port, "001", "hello", $t, "200" );
    get($ip, $port, "002", $t, "404" );
    view($ip, $port, "003", "view", 10, $t, "404");
    status($ip, $port, "006", "status", $value, $t, "200");
    status_json($ip, $port, "007", "status_json", $value, $t, "200");
    mq_reset($ip, $port, "008", "reset", $value, $t, "200" );
    synctime($ip, $port, "009", "synctime", $value, $t, "200" );
    remove($ip, $port, "010", "remove", $value, $t, "200");
}

#���Զ��г�ʼ���Ժ�ĸ�������
function test_2( $ip, $port, $name, $t, $char)
{
    $t = 1000;
    $value = "11";
    $name = "0001";
    echo "------test 2 --------\n";
    maxqueue($ip, $port, $name, "maxqueue", 1000000000, $t, "200" );
    delay($ip, $port, $name, "delay", 2, $t, "200" );
    put($ip, $port, $name, "hello", $t, "200" );
    put($ip, $port, $name, "hello", $t, "200" );
    put($ip, $port, $name, "hello", $t, "200" );
    put($ip, $port, $name, "hello", $t, "200" );
    get($ip, $port, $name, $t, "404" );
    sleep(2);
    get($ip, $port, $name, $t, "200" );
    view($ip, $port, $name, "view", -1, $t, "404");
    status($ip, $port, $name, "status", $value, $t, "200");
    status_json($ip, $port, $name, "status_json", $value, $t, "200");
    mq_reset($ip, $port, $name, "reset", $value, $t, "200" );
    synctime($ip, $port, $name, "synctime", $value, $t, "200" );
    remove($ip, $port, $name, "remove", $value, $t, "200");
}

##���Զ�����Ϊ�յĲ���
function test_3( $ip, $port, $name, $t, $char)
{
    $t = 1000;
    $value = "11";
    echo "------test 3 --------\n";
    maxqueue($ip, $port, "", "maxqueue", 1000000000, $t, "400" );
    put($ip, $port, "", "hello", $t, "400" );
    get($ip, $port, "", $t, "400" );
    view($ip, $port, "", "view", -1, $t, "400");
    status($ip, $port, "", "status", $value, $t, "400");
    status_json($ip, $port, "", "status_json", $value, $t, "400");
    mq_reset($ip, $port, "", "reset", $value, $t, "400");
    synctime($ip, $port, "", "synctime", $value, $t, "200");
    remove($ip, $port, "", "remove", $value, $t, "400");
}

##���Գ�ʱ�����жϳ�ʱ
function test_4( $ip, $port, $name, $t, $char)
{
    $t = 1; //��ʱʱ�����
    $value = "11";
    echo "------test 4 --------\n";
    maxqueue($ip, $port, "1000", "maxqueue", 100000, $t, "200" );
    put($ip, $port, "1000", "hello", $t, "200" );
    get($ip, $port, "1000", $t, "200" );
    view($ip, $port, "1000", "view", 1, $t, "404");
    status($ip, $port, "1000", "status", $value, $t, "200");
    status_json($ip, $port, "1000", "status_json", $value, $t, "200");
    mq_reset($ip, $port, "1000", "reset", $value, $t, "200" );
    synctime($ip, $port, "1000", "synctime", $value, $t, "200" );
    remove($ip, $port, "1000", "remove", $value, $t, "200");
}
//ѭ������д10��
function test_5( $ip, $port, $name, $t, $char, $count)
{
    $t = 1000;
    $value = "11"; 
    echo "------test 5 --------\n";
    maxqueue($ip, $port, "100", "maxqueue", 1000000000, $t, "200" );
    synctime($ip, $port, "100", "synctime", $value, $t, "200" );
    maxqueue($ip, $port, "100", "maxqueue", 1000000000, $t, "200" );
    $time_start=microtime(true);
    for($a=0; $a<$count; $a++)
    {
        put($ip, $port, "100", "hello", $t, "200" );
    }
    $time_end=microtime(true);
    $T = $time_end - $time_start;
    echo "$T\n";
    status($ip, $port, "100", "status", $value, $t, "200");
}
##ѭ��put�Ĳ���
#function test_put( $ip, $port, $name, $t, $char, $count)
#{
#    $t = 1000;
#    $value=gen_data(1024);
#    //maxqueue($ip, $port, "put", "maxqueue", 1000000000, $t, $char );
#    for($a=0; $a<$count; $a++)
#    {   
#        $time_start=microtime(true);
#        for($b=0; $b<1000; $b++)    
#        {
#            put($ip, $port, "put", "$value", $t, $char );
#        }
#        $time_end=microtime(true);
#        $T = $time_end - $time_start;
#        $time = date('h:i:s A');
#        echo "$T\t$time\n";
#    }   
#}
##ѭ������get 
#function test_get( $ip, $port, $name, $t, $char, $count)
#{
#    $t = 1000;
#    #$value = "11"; 
#    #$time_start=microtime(true);
#    for($a=0; $a<$count; $a++)
#    {   
#        $t1=microtime(true);
#        for($b=0; $b<1000; $b++)
#        {
#            get($ip, $port, "put", $t, "200" );
#        }
#        $t2=microtime(true);
#        $t= $t2 - $t1;
#        $time = date('h:i:s A');
#        echo "$t\t$time\n";
#    }   
#    #$time_end=microtime(true);
#    #$T = $time_end - $time_start;
#    #echo "$T\n";
#}

//ѭ��������10��
function test_6( $ip, $port, $name, $t, $char, $count)
{
    $t = 1000;
    $value = "11";
    echo "------test 6 --------\n";
    //status($ip, $port, "100", "status", $value, $t, $char);
    for($a=0; $a<$count; $a++)
    {
        get($ip, $port, "100", $t, "200" );
    }                       
    //status($ip, $port, "100", "status", $value, $t, $char);
}

//���Դ����opt
function test_7( $ip, $port, $name, $t, $char)
{
    $t = 1000;
    $value = "11";
    echo "------test 7 --------\n";
    status($ip, $port, "100", "staus", $value, $t, "405");
    status($ip, $port, "100", "sta", $value, $t, "405");
}

//�����ö��еĲ���
function test_8( $ip, $port, $name, $t, $char)
{
    $t = 1000;
    $value = "11";
    echo "------test 8 --------\n";
    mq_reset($ip, $port, "2000", "reset", $value, $t, "200" );
    status($ip, $port, "2000", "status", $value, $t, "200");
    status_json($ip, $port, "2000", "status_json", $value, $t, "200");
    put($ip, $port, "2000", "hello", $t, "200" );
    view($ip, $port, "2000", "view", 1, $t, "404");
    maxqueue($ip, $port, "2000", "maxqueue", 1000000000, $t, "200" );
    synctime($ip, $port, "2000", "synctime", $value, $t, "200" );
    get($ip, $port, "2000", $t, "200" );
    mq_reset($ip, $port, "2000", "reset", $value, $t, "200" );
    remove($ip, $port, "2000", "remove", $value, $t, "200");
    mq_reset($ip, $port, "2000", "reset", $value, $t, "200" );
    put($ip, $port, "2000", "hello", $t, "200" );
}

function main( $ip, $port, $name, $t, $char )
{
    #�������޹���Ϣ
    error_reporting(E_ALL & ~E_NOTICE);
    #test_put( $ip, $port, $name, $t, $char, 500000000);
    #test_get( $ip, $port, $name, $t, $char, 500);
    //δ��ʼ�����еĲ���
    test_1( $ip, $port, $name, $t, $char);
    //��ʹ�ö��в���
    test_2( $ip, $port, $name, $t, $char);
    //������Ϊ�ղ���
    test_3( $ip, $port, $name, $t, $char);
    //��ʱ�жϲ���
    test_4( $ip, $port, $name, $t, $char);
    //ѭ��put 10��
    test_5( $ip, $port, $name, $t, $char, 10);
    //ѭ��get 10��
    test_6( $ip, $port, $name, $t, $char, 10);
    #���Դ����opt
    test_7( $ip, $port, $name, $t, $char);
    #�����ö��еĲ���
    test_8( $ip, $port, $name, $t, $char);
    echo "-----test end------\n";
    global $success;
    echo "--success [$success]---\n";
    global $fail;
    echo "--fail [$fail]--\n";
}
main( $ip, $port, $name, $t, $char );
#$time = date('h:i:s A');
#echo "---- $time ----\n";
?>
