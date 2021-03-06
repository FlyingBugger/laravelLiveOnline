<!DOCTYPE html>
<!--suppress ALL -->
<html><head>
    <meta charset="utf-8">
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>现场管理</title>
    <link rel="stylesheet" href="/css/main/ui.css">
    <script src="/js/vue-min.js"></script>
    <script src="/js/vue-resource.js"></script>
    <link href="http://vjs.zencdn.net/4.12/video-js.css" rel="stylesheet">
    <script src="http://vjs.zencdn.net/4.12/video.js"></script>
</head>
<style>
    .fn-pt25 {
        padding-top: 20px!important;
    }
    .close:hover{
        cursor: pointer;
    }
    .progress{background:#000 ;color: white}
    .close{position: absolute;
        top: 8px;
        right: 8px;
        width: 24px;
        height: 24px;
        line-height: 24px;
        color: #fff;
        background-color: red;
        text-align: center;
        border-radius: 50%;}
    .progress div:nth-child(1){padding: 20px 0 0 0}
    .xcy-video{background: #000}
</style>
<body>

<div id="app">
    <component :is="currentView" :dir="items" v-on:refreshbizlines="makeReport"></component>
</div>
<script id="edit" type="text/template">
    <div>
        <div id="j-search" class="pz-form pz-searchform xcy-search fn-clear">
            <span id="j-back" @click="back" class="fn-left pz-btn btn-white"><i class="pz-icon icon-back1"></i> 返回</span>
            <div class="other">
                <div id="j-more" class="item">
                    <span class="pz-btn btn-white">更多操作</span>
                    <div class="itemselect itemselect-right">
                        <div class="itemoption">
                            <em class="arrow"></em>
                            <em class="arrowbg"></em>
                            <span class="j-delete">删除报道</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="fn-pl40 fn-pr40 fn-pt30 fn-pb30 fn-clear">
            <div class="pz-form">
                <form id="j-reportform">
                    <div class="formtitle fn-mb30">基本信息</div>
                    {{csrf_field()}}
                    <div class="wrap fn-clear">
                        <div class="group2">
                            <div class="row xcy-row">
                                <div class="row-title">报道内容</div>
                                <div class="row-content" data-field="content"><textarea name="content" class="j-content fn-h180">[[dir[dirIndex].content]]</textarea></div>
                            </div>
                            <div class="formtitle fn-mb30 fn-mt-1">其他信息</div>

                            <div class="wrap fn-pb30">
                                <div class="fn-clear">
                                    <div class="row fn-rate40">
                                        <div class="row-title">所属现场</div>
                                        <div class="row-content" data-field="topic"><input type="text" v-model="dir[dirIndex].scenBy"  name="scene" class="disabled" disabled=""></div>
                                    </div>
                                </div>
                                <div class="fn-clear">
                                    <div class="row fn-left fn-rate40">
                                        <div class="row-title">记者</div>
                                        <div class="row-content" data-field="reporter"><input type="text" v-model="dir[dirIndex].commiter" name="commiter" class="disabled" disabled=""></div>
                                    </div>
                                    <div class="row fn-left fn-rate40">
                                        <div class="row-title">发布时间</div>
                                        <div class="row-content" data-field="createTime"><input style="width: 159px !important;" type="text" v-model="dir[dirIndex].commitAt"  name="commitAt" class="fn-rate60 disabled" required="" placeholder="发布时间"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="group2 fn-pl40">
                            <div class="row xcy-row fn-mb0">
                                <div class="row-title">报道类型</div>
                                <div class="row-content" data-field="type">
                                    <div>
                                        <label><input type="radio" name="type" v-model="type" value="1" checked="">图文报道</label>
                                        <label><input type="radio" name="type"  v-model="type" value="4"> 视频报道</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row xcy-row">
                                <div id="j-upcontain" class="row-content">
                                    <div v-if="type ==1">
                                        <div id="j-row-img" class=" fn-left">
                                            <div class="j-uploader-tip upbtn toplayer fn-hide">
                                                <div class="fn-pt25">
                                                    <i class="pz-icon icon-img"></i>
                                                    <p class="fn-textcenter fn-mt5"></p>
                                                </div>
                                            </div>
                                            <div id="j-cover" class="xcy-cutimg">
                                                <label class="upbtn" @click="reset">
                                                    <div class="imgbar fn-hide"></div>
                                                    <div class="fn-pt25">
                                                        <i class="pz-icon icon-img"></i>
                                                        <p class="fn-textcenter fn-mt5">[[uploadsDtail.progress]]</p>
                                                    </div>
                                                    <div  v-show="uploadsDtail.close">[[uploadsDtail.mesg]]</div>
                                                    [[process]]
                                                    <div class="j-file-input fn-hide">
                                                        <input required type="file"   @change="imgUrl($event)" id="image" name="image" accept="image/gif,image/jpeg,image/jpg,image/png">
                                                    </div>
                                                </label>
                                            </div>
                                        </div>
                                        <div v-for="(x,index) in picList" v-show="ispicList">
                                            <div id="j-row-img" class=" fn-left">
                                                <div class="j-uploader-tip upbtn toplayer fn-hide">
                                                    <div class="fn-pt25" style="display: none;">
                                                        <i class="pz-icon icon-img"></i>
                                                        <p class="fn-textcenter fn-mt5"></p>
                                                    </div>
                                                </div>
                                                <div id="j-cover"  class="xcy-cutimg" >
                                                    <img :src="x" style="width: 100%;height: 100%;">
                                                    <span @click="close(index)" class="close" style="">
                                            <i class="pz-icon icon-close" style="font-size: 25px;"></i>
                                        </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div v-else>
                                        <div id="j-row-video" class="" style="position: relative;">
                                            <div class="xcy-video">
                                                <div class="imgbar"></div>
                                                <div class="j-uploader-tip upbtn toplayer fn-hide">
                                                    <div class="fn-pt25">
                                                        <i class="pz-icon icon-video"></i>
                                                        <p class="fn-textcenter fn-mt5"></p>
                                                    </div>
                                                </div>
                                                <div class="videobar toplayer fn-hide">
                                                    <div class="fn-pt30">
                                                        <span class="close"><i class="pz-icon icon-close"></i></span>
                                                        <i class="pz-icon icon-video"></i>
                                                        <p class="fn-textcenter fn-mt10">点击播放</p>
                                                    </div>
                                                </div>
                                                <div id="j-uploader-selectvideo" @click="preView" class="j-uploader-select upbtn fn-cursor-pointer" style="position: relative; z-index: 1;">
                                                    <video id="example_video_1" class="video-js vjs-default-skin vjs-big-play-centered" width="320" height="240"  controls v-show="hasVideo" :src="items"></video>
                                                    <span v-show="uploadsDtail.close" @click="close('video')" class="close"><i class="pz-icon icon-close" style="font-size: 25px;"></i></span>

                                                    <div v-show="!hasVideo" id="vcover">
                                                        <div class="progress"  v-show="tag" style="width: 100%;height: 100%">
                                                            <div ><i class="pz-icon icon-video"></i></div>

                                                            <div>[[uploadsDtail.mesg]]</div>
                                                            [[process]]
                                                        </div>
                                                        <div class="fn-pt25" v-show="!tag">
                                                            <label class="upbtn">
                                                                <i class="pz-icon icon-video"></i>
                                                                <p class="fn-textcenter fn-mt5">点击选择报道视频</p>
                                                                <div class="j-file-input fn-hide">
                                                                    <input required type="file"  @change="imgUrl($event)" id="image" name="video" accept="video/3gpp,video/mp4,.m3u8,video/x-ms-wmv,video/webm,video/quicktime,video/avi,video/mpeg,.mpeg1,.mpeg4,video/x-matroska,video/x-flv">
                                                                </div>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="actions actions-transparent fn-pt20">
                        <input type="button" @click="submit" class="pz-btn btn-success btn-big" value="保存修改">
                    </div>
                </form>
            </div>
        </div>
    </div>
</script>

<script  id="mainScen" type="text/template">
<div>
    <div id="j-search" class="pz-form pz-searchform xcy-search fn-clear">
        <div class="row-content" data-field="keyword">
            <input type="text" id="j-keyword" name="keyword" class="input-search" placeholder="请输入标题关键字" v-model="search">
        </div>
        <div class="actions">
            <input id="j-searchbtn" type="button" class="pz-btn pz-icon btn-search" value="">
        </div>
        <div id="j-ordertime" class="fn-left pz-btn btn-transparent label-normal fn-ml30">
            创建时间
            <span class="pz-sort sort-desc"></span>
        </div>
        <div class="row-content fn-ml30">
            <select id="j-state">
                <option value="0">全部报道</option>
                <option value="1">待审报道</option>
                <option value="2">已审报道</option>
            </select>
        </div>
    </div>

    <div id="j-card" class="xcy-card fn-pt30 fn-pb30 fn-pl40 fn-clear">
        <ul>
            <li v-for="(x,index) in dir">
                <div v-if="!x.pics && !x.video" >
                <div class="picbar" @click="report(index,x.id)">
                    <div class="content j-edit" >[[x.content]]</div>
                </div>
                </div>
                <div v-else-if="x.pics">

                    <div class="picbar" @click="report(index,x.id)">
                        <span v-show="x.pics.length>1" class="type">[[x.video!=null?"多图,视频":"多图"]]</span>
                        <span v-show="x.pics.length==1" class="type">[[x.video!=null?"图片,视频":"图片"]]</span>
                        <div class="title fn-ellipsis">[[x.content]]</div>
                        <div class="pic j-edit" >
                            <img :src="x.pics[0]"></div>
                    </div>
                </div>
                <div v-else-if="x.video">
                    <div class="picbar" @click="report(index,x.id)">
                        <span  class="type">视频</span>
                        <div class="title fn-ellipsis">[[x.content]]</div>
                        <div class="pic j-edit">
                            <video style="width: 100%;" :src="x.video"></video>
                        </div>
                    </div>
                </div>

                {{--PUBLIC COMONETS--}}
                <div class="action fn-clear">
                    <span class="pz-label label-normal fn-left fn-ellipsis creater"><i class="pz-icon icon-account"></i> [[x.commiter]]</span>
                    <span class="pz-label label-normal fn-left"><i class="pz-icon icon-clock"></i>[[x.commitAt]]</span>
                    <a class="j-view" @click="report(index,x.id)" href="javascript:void(0)" >预览</a>
                </div>
            </li>
        </ul>
    </div>

</div>
</script>

<script>
    new Vue({
        delimiters: ['[[', ']]'],
        el:'#app',
        data:{
            items:'',
            tes:'21',
            currentView:'',

        },
        components:{
            mainS:{
                delimiters: ['[[', ']]'],
                template:'#mainScen',
                methods:{
                    report:function (index,id) {
                        localStorage.setItem("index", index);
                        localStorage.setItem("id", id);
                        var a=[index,id];
                        this.$emit('refreshbizlines',a);
                    }
                },watch:{
                    search:function (newvalue) {
                        if (newvalue==''){
                            this.dates=this.dir;
                        }else{
                            this.dates= this.dir.filter(function (x){
                                if (x.title==newvalue){
                                    return true;
                                }else{
                                    return false;
                                }
                            });
                        }
                    }
                },
                data:function(){
                    return{
                        dates:'',
                        flag:'1',
                        search:null
                    }
                },
                props:['dir'],
                mounted:function () {
                    this.dates=this.dir;
                    console.log(this.dates)
                }
            },
            makereport:{
                delimiters: ['[[', ']]'],
                template:'#edit',
                props:['dir'],
                data:function () {
                    return{
                        dirIndex:0,
                        hasVideo:false,
                        type:1,
                        process:'',
                        tag:false,
                        ispicList:true,
                        bakpicList:new Array(),
                        picList:new Array(),
                        items:'',
                        saved:false,
                        originalDates:'',
                        uploadsDtail:{
                            close:false,
                            mesg:'',
                            progress:"点击选择封面图片"
                        },
                        vUrl:''
                    }
                },
                watch:{
                 type(newValue,b){
                     if (parseInt(newValue)==4){
                     }
                 }
                },
                methods:{
                    reset:function () {
                        this.uploadsDtail.close=false;
                        this.uploadsDtail.mesg='';
                        this.uploadsDtail.progress='点击选择封面图片';
                        this.process='';
                    },
                    submit:function () {
                        if (this.dir[this.dirIndex]['pics']){
                           // this.dir[this.dirIndex]['pics']=this.dir[this.dirIndex]['pics'].join(',');
                        }
                        this.$http.post('/Api/editReport',{act:'saveEdits','_token':'{{csrf_token()}}',dates:this.dir[this.dirIndex]}).then(function (res) {
                            if(res.body=='1'){
                                this.saved=true;
                                alert('提交成功！');
                                this.$emit('refreshbizlines','mainS');
                            }
                        },function (e) {
                            console.log(e)
                        })
                    },
                    imgUrl:function (e) {
                        var target=$('#j-row-img').clone(true);
                        var that=this;
                        $('#fn-pt25').hide();
                        // var imgUrl= window.URL.createObjectURL(e.target.files[0]);
                        if (this.type==1){
                            var data=new FormData(document.getElementById('j-reportform'));
                            data.append('act','setUp');
                            data.append('fileType','pic');
                            this.$http.post('/Api/makeremake',data,{progress:function (event) {
                                var size=event.total;
                                that.process=parseInt(event.loaded/size*100)+'%';
                                if(that.process=='100%'){
                                    that.uploadsDtail.close=true;
                                    that.uploadsDtail.mesg='上传完成，大小'+parseInt(size/1024)+'k';
                                    that.uploadsDtail.progress='点击继续上传'
                                }
                            }}).then(function (res) {
                                that.picList.push(res.body);
                                that.dir[that.dirIndex]['pics']= that.picList;
                                that.uploadsDtail.close=true;
                            },function (e) {
                                console.log(e)
                            })
                        }else{
                            //$('#upvideo').attr('src',imgUrl);
                            //video先上传 再回传地址
                            var data=new FormData(document.getElementById('j-reportform'));
                            data.append('act','setUp');
                            data.append('fileType','video');
                            this.$http.post('/Api/makeremake',data,{progress:function (event) {
                                that.tag=true;
                                var size=event.total;
                                that.process=parseInt(event.loaded/size*100)+'%';
                                if(that.process=='100%'){
                                    that.uploadsDtail.close=true;
                                    that.uploadsDtail.mesg='上传完成，大小'+parseInt(size/1024000)+'m';
                                }
                            }}).then(function (res) {
                                that.items=res.body;
                                that.dir[that.dirIndex]['video']=res.body;
                            },function (e) {
                                console.log(e)
                            })
                            $('#tVideo').attr('autoplay','autoplay');
                        }
                    },
                    back:function () {
                        if(!this.saved){
                            this.dir[this.dirIndex]=JSON.parse(this.originalDates);
                        }
                        this.$emit('refreshbizlines','mainS');
                    },
                    preView:function () {
                        if (this.items!=''){
                            this.hasVideo=true;
                        }
                    },

                    close:function (index) {
                        var that=this;
                        function reset(aim) {
                            aim.process='';
                            aim.tag=false;
                            aim.hasVideo=false;
                            aim.uploadsDtail.close=false;
                            aim.uploadsDtail.mesg='上传中...';
                        }
                        var target=null;
                        var delDeep=false;
                        if (index!='video'){
                            target=this.picList[index];
                          if($.inArray(target, this.bakpicList)!=-1){

                              that.picList.splice(index,1);//
                              that.dir[that.dirIndex]['pics']=that.picList;
                              reset(that);
                          }else{
                              that.picList.splice(index,1);
                              delDeep=true;
                          }

                        }else{
                            //判断是否是新上传的文件
                           if (this.dir[this.dirIndex]['video']==this.items)
                           {
                               that.dir[that.dirIndex]['video']=null;
                               that.items='';
                               reset(that);
                           }
                           else{
                               delDeep=true;
                           }
                            target=this.items;
                        }
                        if (delDeep){
                        this.$http.post('/Api/makeremake',{act:'del','_token':'{{csrf_token()}}','target':target}).then(function (res) {
                            if (res.body=='true'){
                                alert('删除成功！')
                                parseInt(that.type)==4?this.items='':'';
                               reset(that);
                            }else{
                                alert('删除失败！')
                            }
                        },function (e) {
                            console.log(e)
                        })
                        }
                    }
                },
                mounted:function () {
                      var that=this;
                    this.dirIndex=parseInt(localStorage.getItem('index'));
                    this.originalDates=JSON.stringify(this.dir[this.dirIndex]);
                    if (this.dir[this.dirIndex]['pics']){//null
                        this.dir[this.dirIndex]['pics'].map(function (value,index,array) {
                            that.picList.push(value);
                            that.bakpicList.push(value);
                        })
                    }
                    //init video tag
                    if (this.dir[this.dirIndex]['video']){
                        this.items=this.dir[this.dirIndex]['video'];
                        this.hasVideo=true;
                        this.uploadsDtail.close=true;
                    }else{
                        this.hasVideo=false;
                        this.uploadsDtail.close=false;
                    }
                }
            }
        },
        methods:{
            makeReport:function (a) {
                if(typeof (a)=='string'){
                    this.currentView='mainS';
                }else{
                    this.currentView='makereport';
                }
            }
        },
        mounted:function () {

            this.$http.post('/Api/editReport',{act:'editreport','_token':'{{csrf_token()}}'}).then(function (res) {
                var dates=eval('('+res.body+')');
                //deal pics
                dates.map(function (value,index,array){
                    if (value.pics!='' && value.pics!=null){
                        dates[index]['pics']= value.pics.split(',');
                    }
                })
                this.items=dates;
                this.currentView='mainS';
            },function (e) {
                console.log(e)
            })
        }
    })
</script>
<script src="/js/jq.min.js"></script>

</body></html>