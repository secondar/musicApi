# musicApi
抓取方法来源于<br>
其中酷狗与QQ来源于网络上的Meting.php<br>
网易来源于community.apicloud.com/bbs/thread-47469-1-5.html<br>
访问形式为GET<br>
参数:<br>
method<br>
值:<br>
netease //网易<br>
tencent //QQ<br>
kugou //酷狗<br>
参数:<br>
types<br>
值:<br>
search //搜索单曲曲名<br>
lrc    //获取歌词<br>
detailed //网易云音乐与酷狗音乐单曲详细信息<br>
hash //酷狗音乐单曲详细用到的hash<br>
参数:<br>
MusicId //网易云音乐ID//仅网易云音乐获取歌词与单曲详细信息用到<br>

选填参数:<br>
参数:<br>
pagesize //酷狗音乐用到 一次取几条数据<br>
参数:<br>
p //页码 QQ音乐用到<br>
n //一次取几条数据  QQ音乐用到<br>
limit://一次取几条数据  网易云音乐用到<br>
