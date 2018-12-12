# musicApi
抓取方法来源于
其中酷狗与QQ来源于网络上的Meting.php
网易来源于community.apicloud.com/bbs/thread-47469-1-5.html
访问形式为GET
参数:
method
值:
netease //网易
tencent //QQ
kugou //酷狗
参数:
types
值:
search //搜索单曲曲名
lrc    //获取歌词
detailed //网易云音乐与酷狗音乐单曲详细信息
hash //酷狗音乐单曲详细用到的hash
参数:
MusicId //网易云音乐ID//仅网易云音乐获取歌词与单曲详细信息用到

选填参数:
参数:
pagesize //酷狗音乐用到 一次取几条数据
参数:
p //页码 QQ音乐用到
n //一次取几条数据  QQ音乐用到
limit://一次取几条数据  网易云音乐用到
