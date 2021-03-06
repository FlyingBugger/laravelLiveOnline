<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use PhpParser\Node\Stmt\Return_;

class SceneController extends Controller
{
    public function  editScene(Request $request){
       $img=$request->file('pic');
        if ($img!=null &&$img->isValid()){
            $type=$img->getClientOriginalExtension();
            $filename=date('His').'-'.uniqid().".".$type;
            $path=$img->move(base_path().'/public/uploads',$filename);
            $path= '/uploads/'.$filename;
        }else{
            $path=$request->input('opic');
        }
        $type=$request->input('type');
        $topic=$request->input('topic');
        $content=$request->input('remark');
        $partakeState=$request->input('partakeState');
        $re=DB::table('createscene')->where(['id'=>$request->input('id')])->update(
            [
                'content'=>$content,
                'coverPic'=>$path,
                'type'=>$type,
                'title'=>$topic,
                'partakeState'=>$partakeState
            ]
        );
        if ($re){
            return 1;
        }
    }
    public function SceneAdd(Request $request){
    $image=$request->file('image');
        if ($image->isValid()){
            $type=$image->getClientOriginalExtension();//扩展名
            $original=$image->getRealPath();//临时绝对路径
            $filename=date('His').'-'.uniqid().".".$type;
           $path=$image->move(base_path().'/public/uploads',$filename);
            $path= '/uploads/'.$filename;
        }
        $dates=$request->input();
        $ip=$_ENV['IP_ADDR'];
        $time=strtotime("2030-11-10 22:19:21");
        $uid=uniqid();

        $md5v=md5("/live/$uid-$time-njrb");
    $rtmpUrl="rtmp://$ip:1935/live/|||".$uid."?sign=$time-$md5v";
        //处理字段
        $pid=time();
        $viewUrl=$_ENV['SITENAME'].'/scen/'.(string)$pid;
        $setter=\cache('user');
        $insertStatus=DB::table('createscene')->insert(['seter'=>$setter,'title'=>$dates['topic'],'pid'=>$pid,'viewUrl'=>$viewUrl,'content'=>$dates['remark'],'coverPic'=>$path,'type'=>$dates['type'],'rtmpUrl'=>$rtmpUrl,'createAt'=>date('Y-m-d H:i',time())]);
       if ($insertStatus){
           return 1;
       }else{
           return 0;
       }
    }

    public function  getCount(Request $request){
            if($request->input('act')=='a'){
                $a=DB::table('createscene')->orderby('id','DESC')->get();
                return $a;
            }
    }

    public function getScenelist(Request $request){
        $id=Input::get('id');//对应的id
          if ($request->input('act')=='getList'){
              $re=DB::table('createscene')->orderby('id','DESC')->get();
             return json_encode($re);
          }elseif ($request->input('act')=='setTop'){
            //setTop 选找出最大数，然后+1
              $maxSet=DB::table('createscene')->max('setTop');
              if(DB::table('createscene')->where('id',$id)->update(['setTop'=>++$maxSet])){
                  return 1;
              }else{
                  return 0;
              }
          }elseif($request->input('act')=='cancelTop'){
              if(DB::table('createscene')->where('id',$id)->update(['settop'=>0])){
                  return 1;
              }else{
                  return 0;
              }
          }elseif($request->input('act')=='end'){
              if(DB::table('createscene')->where('id',$id)->update(['status'=>0])){
                  return 1;
              }else{
                  return 0;
              }
          }elseif($request->input('act')=='pushLive'){
              if(DB::table('createscene')->where('id',$id)->update(['status'=>16])){
                  return 1;
              }else{
                  return 0;
              }
          }elseif($request->input('act')=='pushLive'){
              if(DB::table('createscene')->where('id',$id)->update(['status'=>16])){
                  return 1;
              }else{
                  return 0;
              }
          }elseif($request->input('del')=='del'){
              //9.26 删除场景  暂时未能处理
              /*
              if(DB::table('createscene')->where('id',$id)->update(['status'=>16])){
                  return 1;
              }else{
                  return 0;
              }*/
          }
    }
    public function getDetails(Request $request)
    {
        $id=$request->input('id');
        if($request->input('act')=='getDetail'){
            $res=DB::table('createscene')->where('id',$id)->get();
            return json_encode($res);
        }
    }
    public  function changePwd(Request $request){
       $table=null;
        $username=\cache('user');
            if (cache('user')!=''&& cache('user')=='admin'){
                $table="admin";
            }else{
                $table='adminuser';
            }

       $re=DB::table($table)->where(['name' => $username])->get();

            //TEST

        if(!empty($re)){
            if (Crypt::decrypt($re[0]->password)==$request->input('ypw')){
                if ($request->input('xpw')!=$request->input('qrpw')){
                    return json_encode(array(
                        'status'=>0,
                        'details'=>'密码不一致'
                    ));
                }else{
                    $newPwd=Crypt::encrypt($request->input('xpw'));

                    $r=DB::table($table)->where(['name' => $username])->update(['password'=>$newPwd]);
                        if($r==1){
                            Cache::forget('user');
                            session(['user'=>'']);
                            return json_encode(array(
                                'status'=>6,
                                'details'=>'成功'
                            ));
                        }else{
                            return json_encode(array(
                                'status'=>5,
                                'details'=>'重试'
                            ));
                        }
                }
            }else{
                return json_encode(array(
                    'status'=>1,
                    'details'=>'原密码错误'
                ));
            }
        }else{
            return json_encode(array(
                'status'=>5,
                'details'=>'重试'
            ));
        }

      //  return $dbs->password;
    }
    public function  addUser(Request $request){
        $postDates=$request->all();
        $rArrs=null;
        foreach ($postDates as $key=>$value){
            if ($value=='' ||$value ==null){
                $rArrs=array(
                    'status'=>0,
                   'content'=> '输入不能有空'
                );
                return json_encode($rArrs);
            }
        }
        if ($postDates['password']!=$postDates['password2']){
            $rArrs=array(
                'status'=>1,
                'content'=> '俩次密码不一致'
            );
            return json_encode($rArrs);
        }
        $pwd=Crypt::encrypt($postDates['password2']);
        //writeInto disk
        $re=DB::table('adminuser')->insert([
            'count'=>$postDates['mobile'],
            'password'=>$pwd,
            'name'=>$postDates['nick'],
            'createtime'=>date('Y-m-d H-i-s',time()),
            'role'=>$postDates['role']
        ]);
        if ($re){
            $rArrs=array(
                'status'=>6,
                'content'=> '成功'
            );
        }else{
            $rArrs=array(
                'status'=>7,
                'content'=> '重试'
            );
        }
        return json_encode($rArrs);
    }
    public function getAUser(Request $request){
        if ($request->input('act')!='getAdminUsers'){
            return json_encode(array(
                'status'=>403,
                'content'=>'not Allowed'
            ));
        }elseif($request->input('id')!=null){
            $dates=DB::table('adminuser')->where(['id'=>$request->input('id')])->get();
            return json_encode($dates);
        }else{
            $dates=DB::table('adminuser')->orderBy('id','desc')->get();
            return json_encode($dates);
        }
    }
    public function setAUser(Request $request){
        switch ($request->input('act')){
            case 'setStatus':
                $active=$request->input('active');
                if ($active==0){
                    $active=1;
                }else{
                    $active=0;
                }
                $set=DB::table('adminuser')->where(['id'=>$request->input('id')])->update(['active'=>$active]);
              return 1;
                break;
            case 'editInfo':
                 //是否修改密码
                 if ($request->input('password')!=null){
                     if ($request->input('password')!=$request->input('password2')){
                         return json_encode(array(
                             'status'=>0,
                             'content'=>'incorrect pwd'
                         ));
                     }else{
                         //Crypt 加密
                         $pwd=Crypt::encrypt($request->input('password2'));
                         $re=DB::table('adminuser')->where(['id'=>$request->input('id')])->update([
                             'count'=>$request->input('mobile'),
                             'password'=>$pwd,
                             'role'=>$request->input('role'),
                             'name'=>$request->input('nick')
                         ]);
                         if ($re){
                             return json_encode(array(
                                 'status'=>6,
                                 'content'=>'succees'
                             ));
                         }else{
                             return json_encode(array(
                                 'status'=>2,
                                 'content'=>'try again'
                             ));
                         }
                     }
                 }else{
                     $re=DB::table('adminuser')->where(['id'=>$request->input('id')])->update([
                         'count'=>$request->input('mobile'),
                         'role'=>$request->input('role'),
                         'name'=>$request->input('nick')
                     ]);
                     if ($re){
                         return json_encode(array(
                             'status'=>6,
                             'content'=>'succees'
                         ));
                     }else{
                         return json_encode(array(
                             'status'=>2,
                             'content'=>'try again'
                         ));
                     }
                 }
                break;
        }

    }
    public function DeleteUser(Request $request){
        if ($request->input('act')=='delUser'){
            $re=DB::table('adminuser')->where(['id'=>$request->input('id')])->delete();
             if ($re==1){
                 return json_encode(array(
                     'status'=>6,
                     'content'=>'success'
                 ));
             }else{
                 return json_encode(array(
                     'status'=>2,
                     'content'=>'try again'
                 ));
             }
        }else{
            return json_encode(array(
                'status'=>403,
                'content'=>'forbid'
            ));
        }
    }
    public function makeReport(Request $request){
        if ($request->input('act')!='makereport') return 0;
        $username=\cache('user');
        $dates=DB::table('createscene')->where(['status'=>16])->get();

       if(!$dates->isEmpty()){
            return json_encode($dates);
       }
        return 0;
    }
    public function logout(Request $request)
    {
        if ($request->input('act')!='logout') return 0;
        Cache::forget('user');
        session(['user'=>'']);
        return 1;
    }
    public function makeremake(Request $request){
        if ($request->input('act')=='setUp' && $request->input('fileType')=='video' ){
            $image=$request->file('video');
            if ($image->isValid()){
                $type=$image->getClientOriginalExtension();//扩展名
                $original=$image->getRealPath();//临时绝对路径
                $filename=date('His').'-'.uniqid().".".$type;
                $path=$image->move(base_path().'/public/flur',$filename);
                $path= '/flur/'.$filename;
                return $path;
            }
        }elseif($request->input('act')=='setUp' && $request->input('fileType')=='pic'){
            $image=$request->file('image');
            if ($image->isValid()){
                $type=$image->getClientOriginalExtension();//扩展名
                $original=$image->getRealPath();//临时绝对路径
                $filename=date('His').'-'.uniqid().".".$type;
                $path=$image->move(base_path().'/public/img/commentsP',$filename);
                $path= '/img/commentsP/'.$filename;
                return $path;
            }
        }elseif ($request->input('act')=='del'){
         return json_encode(@unlink(substr($request->input('target'),1,strlen($request->input('target'))-1)));
        }else{
            $datas=$request->input();
            $datas['video']==null?$video='':$video=$datas['video'];
            $logInfo=DB::table('comments')->insert([
                'pid'=>$datas['id'],
                'content'=>$datas['content'],
                'pics'=>$datas['pics'],
                'video'=>$datas['video'],
                'scenBy'=>$datas['scene'],
                'commitAt'=>date('Y-m-d H-i-s'),
                'commiter'=>\cache('user'),
                'status'=>0//unsigned
            ]);
            if ($logInfo  && DB::table('createscene')->where(['id'=>$datas['id']])->increment('reports')){
                return 1;
            }else{
                return 0;
            }
        }

    }
    //edit report
    public  function editReport(Request $request){
        if ($request->input('act')=='editreport'){
            $r=DB::table('comments')->get();
            return json_encode($r);
        }elseif ($request->input('act')=='saveEdits'){
            $datas=$request->input('dates');
            $datas['pics']==null?$pics='':$pics=join(',',$datas['pics']);
            $datas['video']==null?$datas['video']='':'';
            $logInfo=DB::table('comments')->where(['id'=>$datas['id']])->update([
                'content'=>$datas['content'],
                'pics'=>$pics,
                'video'=>$datas['video'],
                'commiter'=>\cache('user')
            ]);
            if ($logInfo){
                return 1;
            }else{
                return 0;
            }
        }
    }
    public function makeComments(Request $request){
       if ($request->input('act')=='makeComments'){
          $re= DB::table('commits')->insert([
               'pid'=>$request->input('pid'),
               'content'=>$request->input('content'),
               'creatAt'=>date('Y-m-d H:i',time()),
               'scene'=>$request->input('scene'),
               'headImg'=>'/img/comment_user_head_icon.png',//default values
               'name'=>$request->input('name')
           ]);
          if ($re && DB::table('createscene')->where(['pid'=>$request->input('pid')])->increment('Ccommits')){
              return 1;
          }else{
              return 0;
          }
       }elseif ($request->input('act')=='zans'){
           if(DB::table('commits')->where(['id'=>$request->input('id')])->increment('zans')){
               $pid=$request->input('pid');
               $jsonDates=json_encode(DB::table('commits')->where(['pid'=>$pid,'status'=>1])->get());
               //$re=DB::table('commits')->get()->toArray();
               $myfile = fopen("dates/$pid.json", "w") or die("Unable to open file!");//打开
               fwrite($myfile, $jsonDates);
               fclose($myfile);
                return 1;
           }
       }elseif ($request->input('act')=='FgetAll'){
           return json_encode(DB::table('comments')->where(['pid'=>$request->input('oid')])->orderby('id','DESC')->get());
       }else{
           return 0;
       }
    }
    public function signedCommits(Request $request){
        if ($request->input('act')=='getAll'){
            return json_encode(DB::table('commits')->orderby('id','DESC')->get());
        }elseif ($request->input('act')=='pass'){
           if (DB::table('commits')->where(['id'=>$request->input('id')])->update(['status'=>1])){
               $id=$request->input('pid');
               $jsonDates=json_encode(DB::table('commits')->where(['pid'=>$id,'status'=>1])->get());
               //$re=DB::table('commits')->get()->toArray();
               $myfile = fopen("dates/$id.json", "w") or die("Unable to open file!");//打开
               fwrite($myfile, $jsonDates);
               fclose($myfile);
               return 1;//pass
           }else{
               return 0;
           }
        }elseif ($request->input('act')=='del'){
            if (DB::table('commits')->where(['id'=>$request->input('id')])->delete()){
                return 2;//ng
            }
        } elseif($request->input('act')=='delParts'){
            $flag=true;
            foreach (json_decode($request->input('dates')) as $k=>$v){
               if (!DB::table('commits')->where(['id'=>$v])->delete()){
                   $flag=false;
               }
            }
            if ($flag){
                return 1;
            }else{
                return 0;
            }
        } elseif($request->input('act')=='passParts'){
            $flag=true;
            foreach (json_decode($request->input('dates')) as $k=>$v){

                if (!DB::table('commits')->where(['id'=>$v])->update(['status'=>1])){
                    $flag=false;
                }
            }
            if ($flag){
                return 1;
            }else{
                return 0;
            }
        }else{
            return 0;
        }
    }
}
