<?php  
/**
 * [httpRequest description]
 * @param  [type] $sUrl    [url]
 * @param  [type] $aHeader [aHeader]
 * @param  [type] $aData   [请求数据]
 * @return [type]          [json]
 */
function httpRequest($sUrl, $aHeader, $aData){
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_URL, $sUrl);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $aHeader);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($aData));
    $sResult = curl_exec($ch);
    if($sError=curl_error($ch)){
        die($sError);
    }
    curl_close($ch);
    return $sResult;
}
//网易
function netease(){
    if(!empty($_GET)){
        switch($_GET['types']){
            case 'search':
                //搜索音乐
                if(empty($_GET['name'])){
                    echo '{"msg":"参数缺失","code":"-1"}';
                }
                if(empty($_GET['limit'])){
                    $_GET['limit']=30;
                }
                //请求地址
                $sUrl = 'http://music.163.com/api/search/get/web';
                //post数据
                $aData = array(
                    "s"=> $_GET['name'], 
                    "csrf_token"=> "", 
                    "type"=> 1, 
                    "offset"=> 0, //从第几条数据开始取
                    "limit"=> $_GET['limit'],//返回条数
                    "total"=> true
                );
                //header数据
                $aHeader = array('Referer: http://music.163.com/search/');
                //curl请求
                $sResult = httpRequest($sUrl, $aHeader, $aData);
                //转数组
                $aResData = json_decode($sResult, true);
                foreach ($aResData['result']['songs'] as $key => $value) {
                    $aResData['result']['songs'][$key]['mUrl']='https://music.163.com/song/media/outer/url?id='.$value['id'].'.mp3';
                }
                //转json显示返回数据
                $json=json_encode($aResData['result']['songs'], JSON_UNESCAPED_UNICODE);
                $json=str_replace('\/','/',$json);
                echo ($json);
                break;
            case 'lrc':
                //歌词获取
                $url='http://music.163.com/api/song/lyric?os=pc&id='.$_GET['MusicId'].'&lv=-1&kv=-1&tv=-1';
                $html = file_get_contents($url);
                $arrObj=json_decode($html,TRUE);
                echo ($arrObj['lrc']['lyric']);
                break;
            case 'detailed':
                //单曲详细信息获取
                $url='http://music.163.com/api/song/detail?id='.$_GET['MusicId'].'&ids=%5B'.$_GET['MusicId'].'%5D';
                $html = file_get_contents($url);
                $arrObj=json_decode($html,TRUE);
                $json=json_encode($arrObj['songs'], JSON_UNESCAPED_UNICODE);
                $json=str_replace('\/','/',$json);
                echo ($json);
                break;
        }
    }
}
//腾讯
function tencent(){
    switch($_GET['types']){
        case 'search':
            $w=$_GET['name'];
            $p=1;
            $n=30;
            if(!empty($_GET['p'])){
                $p=$_GET['p'];
            }
            if(!empty($_GET['n'])){
                $n=$_GET['n'];
            }
            $url='https://c.y.qq.com/soso/fcgi-bin/client_search_cp?';
            $url.='p='.$p.'&n='.$n.'&w='.$w.'&aggr=1&lossless=1&cr=1&new_json=1';
            $html = file_get_contents($url);
            //删除影响转为数组的文本
            $html = str_replace('callback(','',$html);
            $html = str_replace(')','',$html);
            $html = str_replace('<em>','',$html);
            $html = str_replace('</em>','',$html);
            //转数组
            $arrObj=json_decode($html,TRUE);
            //转json显示返回数据
            $json=json_encode($arrObj['data']['song']['list'], JSON_UNESCAPED_UNICODE);
            $json=str_replace('\/','/',$json);
            echo ($json);
            break;
    }
}
//酷狗
function kugou(){   
    switch($_GET['types']){
        case 'search':
            $pagesize=30;
            if(!empty($_GET['pagesize'])){
                $pagesize=$_GET['pagesize'];
            }
            $url='http://mobilecdn.kugou.com/api/v3/search/song?api_ver=1&area_code=1&correct=1&pagesize='.$pagesize.'&plat=2&tag=1&sver=5&showtype=10&page=1&keyword='.$_GET['name'].'&version=8990';
            $html = file_get_contents($url);
            $arrObj=json_decode($html,TRUE);
            $json=json_encode($arrObj['data']['info'], JSON_UNESCAPED_UNICODE);
            echo ($json);
            break;
        case 'detailed':
            if(empty($_GET['hash'])){
                echo '{"msg":"参数缺失","code":"-1"}';
            }
            $url='http://www.kugou.com/yy/index.php?r=play/getdata&hash='.$_GET['hash'];
            $html = file_get_contents($url);
            $arrObj=json_decode($html,TRUE);
            $json=json_encode($arrObj['data'], JSON_UNESCAPED_UNICODE);
            $json=str_replace('\/','/',$json);
            $json=str_replace('\r','',$json);
            $json=str_replace('\n','',$json);
            echo ($json);
            break;
    }
}
if(empty($_GET['method'])||empty($_GET['types'])){
    echo '{"msg":"参数缺失","code":"-1"}';
}else {
    switch($_GET['method']){
        case 'netease':
            netease();
            break;
        case 'tencent':
            tencent();
            break;
        case 'kugou':
            kugou();
            break;
    }
}
?>