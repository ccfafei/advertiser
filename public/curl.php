<?php

$crawl = [
    'crawl_url_config' => [
        'etherchain' => 'https://www.etherchain.org/charts/topMiners',//全网各大矿池信息,抓网页
        'ethermine' => 'https://api.ethermine.org/poolStats',//ethermine实际算力api
        'sparkpool' => 'https://eth.sparkpool.com/api/pool/index',//星火api
        'f2pool' => 'https://www.f2pool.com/',//鱼池抓网页
        'miningpoolhub' => 'https://miningpoolhub.com/',//miningpoolhub抓网页
        'dwarfpool' => 'http://dwarfpool.com/',//dwarfpool抓网页
        'bwpool' => 'https://www.bwpool.net/pool/i/btcIndexChartsData?type=2&coint=eth',//BW的api
        'uupool' => 'https://uupool.cn/api/getAllInfo.php',// 双U的api
        'firepool' => 'https://www.h-pool.com/eth/api/v2/front/pool/poolinfo',//火池
        'zqminer' => '',//战旗暂时没有
    ]
];

$html = init();
var_dump($html);

function init(){
    $result = "";
    global $crawl;
    $arr = $crawl['crawl_url_config'];
    if(empty($_GET['query'])){
        return $result;
    }
    $params = $_GET['query'];
    if(key_exists($params,$arr)){
        $url = $arr[$params];
        $result = curl_get($url);
    }
    return $result;
}

/**
 * @param string $url 访问链接
 * @param int $retry 重试次数, 默认3次
 * @param int $sleep 重试间隔时间, 默认1s
 * @return bool|mixed curl返回结果
 * desc 有重试功能的curlget
 */
function curl_get($url, $retry = 3, $sleep = 1)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 信任任何证书
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); // 检查证书中是否设置域名（为0也可以，就是连域名存在与否都不验证了）

    $output = curl_exec($ch);
    while (($errNo = curl_errno($ch)) && $retry--) { //发生错误重试
        sleep($sleep); //阻塞1s
        $output = curl_exec($ch);
    }
    curl_close($ch);
    return $output;
}