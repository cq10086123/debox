<?php
/*
Sort:1
Hidden:true
Name:编辑应用
Url:app_edit
Version:1.0
Author:易如意
Author QQ:51154393
Author Url:www.eruyi.cn
*/

if (!isset($islogin)) header("Location: /"); //非法访问
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$res = Db::table('app')->where(['id' => $id])->find();
$http=strpos(strtolower($_SERVER['server_protocol']),'https')  === false ? 'http' : 'https';
function request_uri()
{
if (isset($_SERVER['REQUEST_URI']))
{
$uri = $_SERVER['REQUEST_URI'];
}
else
{
if (isset($_SERVER['argv']))
{
$uri = $_SERVER['PHP_SELF'] .'?'. $_SERVER['argv'][0];
}
else
{
$uri = $_SERVER['PHP_SELF'] .'?'. $_SERVER['QUERY_STRING'];
}
}
return $uri;
}
?>
<div class="row">
	<div class="col-12">
		<div class="page-title-box">
			<div class="page-title-right">
				<ol class="breadcrumb m-0">
					<li class="breadcrumb-item"><a href="javascript: void(0);">首页</a></li>
					<li class="breadcrumb-item"><a href="./?app_adm">应用管理</a></li>
					<li class="breadcrumb-item active">编辑应用</li>
				</ol>
			</div>
			<h4 class="page-title"><?php echo $title; ?></h4>
		</div> <!-- end page-title-box -->
	</div> <!-- end col-->
</div>
<!-- end page title -->
<!-- Form row -->
<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-body">
				<form action="" method="post" id="addimg" name="addimg">
					<div class="form-row">
						<div class="form-group col-md-12">
							<label class="col-form-label">应用名称</label>
							<input type="text" class="form-control" id="name" name="name" placeholder="应用名称" value="<?php echo $res['name']; ?>" required>
						</div>
						<div class="form-group col-md-4">
							<label id="appidname" class="col-form-label">APPID</label>
							<div class="input-group">
								<input type="text" class="form-control" id="appid" name="appid" value="<?php echo $id; ?>" disabled>
								<div class="input-group-append">
									<button class="btn btn-dark eruyi-append" type="button" id="copy_id">复制</button>
								</div>
							</div>
						</div>
						<div class="form-group col-md-8">
							<label class="col-form-label">APPKEY</label>
							<div class="input-group">
								<input type="text" class="form-control" id="appkey" name="appkey" value="<?php echo $res['appkey']; ?>" disabled>
								<div class="input-group-append">
									<button class="btn btn-dark eruyi-append" type="button" id="bian_key">更换</button>
									<button class="btn btn-success" type="button" id="copy_key">复制</button>
								</div>
							</div>
						</div>
						<div class="form-group col-md-12">
								<label>全局背景图TV【空的话使用app自带的背景图】</label>
								<div class="input-group">
									<input id="ui_startad_bj" name="ui_startad_bj" type="text" class="form-control" placeholder="全局背景图" value="<?php echo $res['ui_startad_bj']; ?>">
								</div>
							</div>
							<div class="form-group col-md-12">
								<label>启动广告TV【启动的第二屏画面，支持GIF mp4 m3u8格式】</label>
								<div class="input-group">
									<input id="ui_startad" name="ui_startad" type="text" class="form-control" placeholder="启动广告" value="<?php echo $res['ui_startad']; ?>">
								</div>
							</div>
							<div class="form-group col-md-12">
								<label>启动广告mobile【启动的第二屏画面，支持GIF mp4 m3u8格式】</label>
								<div class="input-group">
									<input id="ui_startad_mobile" name="ui_startad_mobile" type="text" class="form-control" placeholder="启动广告" value="<?php echo $res['ui_startad_mobile']; ?>">
								</div>
							</div>
							<div class="form-group col-md-12">
								<label>启动广告【显示时间 单位秒】</label>
								<div class="input-group">
									<input id="ui_startad_time" name="ui_startad_time" type="text" class="form-control" placeholder="5" value="<?php echo $res['ui_startad_time']; ?>">
								</div>
							</div>

							<div class="form-group col-md-12">
								<label>播放界面右上角logo地址</label>
								<div class="input-group">
									<input id="ui_app_banner" name="ui_app_banner" type="text" class="form-control" placeholder="地址" value="<?php echo $res['ui_app_banner']; ?>">
								</div>
							</div>
							<div class="form-group col-md-12">
								<label>聚合接口【&nbsp;<a href="<?php echo explode("admin",$http.'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'])[0] . "app/"; ?>" target="_blank">生成聚合接口</a>&nbsp;】留空使用&nbsp;<?php echo explode("admin",$http.'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'])[0] . "app/api.json"; ?></label>
								<div class="input-group">
									<input id="app_json" name="app_json" type="text" class="form-control" placeholder="远端站点" value="<?php echo $res['app_json']; ?>">
								</div>
							</div>
							<div class="eruyi-checkbox">
								<input type="checkbox" id="ui_state_jk" <?php if ($res['ui_state_jk'] == 'y') : ?>checked<?php endif; ?> data-switch="warning" onchange="ui_state_jkv(this.checked)" />
								<label for="ui_state_jk" data-on-label="开启" data-off-label="关闭"></label>
								<label class="eruyi-label">是否开启后台接口加密</label>
							</div>
							<div class="form-group col-md-12">
								<label>备用接口【主接口无法访问时调用】</label>
								<div class="input-group">
									<input id="app_jsonb" name="app_jsonb" type="text" class="form-control" placeholder="备用远端站点" value="<?php echo $res['app_jsonb']; ?>">
								</div>
							</div>
							<div class="form-group col-md-12">
								<label>多仓接口【多线路聚合接口】留空使用&nbsp;<?php echo explode("admin",$http.'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'])[0] . "app/duocang.json"; ?></label>
								<div class="input-group">
									<input id="app_jsonc" name="app_jsonc" type="text" class="form-control" placeholder="多线路接口" value="<?php echo $res['app_jsonc']; ?>">
								</div>
							</div>
							<div class="eruyi-checkbox">
								<input type="checkbox" id="ui_state_dcjm" <?php if ($res['ui_state_dcjm'] == 'y') : ?>checked<?php endif; ?> data-switch="warning" onchange="ui_state_dcv(this.checked)" />
								<label for="ui_state_dcjm" data-on-label="开启" data-off-label="关闭"></label>
								<label class="eruyi-label">是否开启后台多仓接口加密</label>
							</div>
							<div class="form-group col-md-12">
								<label>关于界面右上角图片</label>
								<div class="input-group">
									<input id="ui_logo" name="ui_logo" type="text" class="form-control" placeholder="应用LOGO" value="<?php echo $res['ui_logo']; ?>">
							    </div>
							</div>
							<div class="form-group col-md-12">
								<label>首页显示轮播图或者幻灯片TV(1 为幻灯片 其他为原始轮播图 如果改为原始轮播一定不要有视频和gif不然会闪退)</label>
								<div class="input-group">
									<input id="ad_slide" name="ad_slide" type="text" class="form-control" placeholder="1 为幻灯片 其他为原始轮播图" value="<?php echo $res['ad_slide']; ?>">
							    </div>
							</div>
                        <div class="form-group col-md-12">
                            <label>首页显示轮播图或者幻灯片mobile(1 为幻灯片 其他为原始轮播图 如果改为原始轮播一定不要有视频和gif不然会闪退)</label>
                            <div class="input-group">
                                <input id="ad_slide_mobile" name="ad_slide_mobile" type="text" class="form-control" placeholder="1 为幻灯片 其他为原始轮播图" value="<?php echo $res['ad_slide_mobile']; ?>">
                            </div>
                        </div>
							<div class="form-group col-md-12">
								<label>首页幻灯片视频声音大小(范围 0 - 1 小数 如 0.25)</label>
								<div class="input-group">
									<input id="ad_slide_soundkg" name="ad_slide_soundkg" type="text" class="form-control" placeholder="如: 0.5 一半声音" value="<?php echo $res['ad_slide_soundkg']; ?>">
							    </div>
							</div>
                            <div class="form-group col-md-12">
                                <label>幻灯片轮播间隔时间【显示时间 单位秒】</label>
                                <div class="input-group">
                                    <input id="ui_startad_hdptime" name="ui_startad_hdptime" type="text" class="form-control" placeholder="5" value="<?php echo $res['ui_startad_hdptime']; ?>">
                                </div>
                            </div>
							<div class="form-group col-md-12">
								<label>非会员免费试看时间(单位为秒 直播点播共用)</label>
								<div class="input-group">
									<input id="free_time" name="free_time" type="text" class="form-control" placeholder="单位为秒" value="<?php echo $res['free_time']; ?>">
							    </div>
							</div>
							<div class="form-group col-md-12">
								<label>非会员免费试看提示自动关闭时间(单位为秒 直播点播共用 必须小于试看时间)</label>
								<div class="input-group">
									<input id="free_time_tip" name="free_time_tip" type="text" class="form-control" placeholder="单位为秒" value="<?php echo $res['free_time_tip']; ?>">
							    </div>
							</div>
							<div class="form-group col-md-12">
								<label>试看结束跳转界面(false试看结束返回详情页，true支付页 需打开支付控制)</label>
								<div class="input-group">
									<input id="isToPay" name="isToPay" type="text" class="form-control" placeholder="false试看结束返回详情页，true支付页" value="<?php echo $res['isToPay']; ?>">
							    </div>
							</div>
							<div class="form-group col-md-12">
								<label>最新公告显示方式(1 为多条消息垂直轮播 其他数字为原始跑马灯)</label>
								<div class="input-group">
									<input id="isNoticeShow" name="isNoticeShow" type="text" class="form-control" placeholder="1 为多条消息垂直轮播 其他数字为原始跑马灯" value="<?php echo $res['isNoticeShow']; ?>">
							    </div>
							</div>
							<div class="form-group col-md-12">
								<label>加密密码(格式 key|iv 接口、直播、站点通用密码  key和iv都必须为16位)</label>
								<div class="input-group">
									<input id="livePass" name="livePass" type="text" class="form-control" placeholder="key|iv" value="<?php echo $res['livePass']; ?>">
							    </div>
							</div>
							<div class="form-group col-md-12">
								<label>直播地址(没加密的地址 下面有开关 如果 开 将优先使用这里的地址内容已加密 不得为空,如果为 关 则使用线路里带的直播)&nbsp;<?php echo explode("admin",$http.'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'])[0] . "app/live.txt"; ?></label>
								<div class="input-group">
									<input id="liveUrl" name="liveUrl" type="text" class="form-control" placeholder="没加密的直播地址" value="<?php echo $res['liveUrl']; ?>">
							    </div>
							</div>

							<div class="eruyi-checkbox">
								<input type="checkbox" id="ui_state_live" <?php if ($res['ui_state_live'] == 'y') : ?>checked<?php endif; ?> data-switch="warning" onchange="ui_state_livev(this.checked)" />
								<label for="ui_state_live" data-on-label="开启" data-off-label="关闭"></label>
								<label class="eruyi-label">是否开启加密直播(不开启的话将使用接口直播)</label>
							</div>

							<div class="form-group col-md-12">
								<label>播放视频顶部提示信息(文字|5 就是开始播放后5秒消失)</label>
								<div class="input-group">
									<input id="play_tips" name="play_tips" type="text" class="form-control" placeholder="文字|时间" value="<?php echo $res['play_tips']; ?>">
							    </div>
							</div>

							<div class="form-group col-md-12">
								<label>活动地址【我的代金券里面最新活动按钮】</label>
								<div class="input-group">
									<input id="app_huodong" name="app_huodong" type="text" class="form-control" placeholder="网页地址，会生成二维码" value="<?php echo $res['app_huodong']; ?>">
								</div>
							</div>
							<div class="form-group col-md-12">
								<label>解析背景【播放前背景】</label>
								<div class="input-group">
									<input id="ui_paybackg" name="ui_paybackg" type="text" class="form-control" placeholder="完整的图片地址，建议尺寸：1125x618" value="<?php echo $res['ui_paybackg']; ?>">
								</div>
							</div>
							<div class="form-group col-md-12">
								<label>个人中心卡券包里的在线客服【扫码跳转的URL】</label>
								<div class="input-group">
									<input id="ui_kefu" name="ui_kefu" type="text" class="form-control" placeholder="http://wpa.qq.com/msgrd?v=3&uin=qq号码&site=qq&menu=yes" value="<?php echo $res['ui_kefu']; ?>">
								</div>
							</div>
							<div class="form-group col-md-12">
								<label>用户反馈群【关于界面】</label>
								<div class="input-group">
									<input id="ui_group" name="ui_group" type="text" class="form-control" placeholder="888888888" value="<?php echo $res['ui_group']; ?>">
								</div>
							</div>

                            <div class="form-group col-md-12">
                                <label>mobile我的-联系客服</label>
                                <div class="input-group">
                                    <input id="ui_kefu_mobile" name="ui_kefu_mobile" type="text" class="form-control" placeholder="http://wpa.qq.com/msgrd?v=3&uin=qq号码&site=qq&menu=yes" value="<?php echo $res['ui_kefu_mobile']; ?>">
                                </div>
                            </div>
                            <div class="form-group col-md-12">
                                <label>mobile我的-官方QQ群</label>
                                <div class="input-group">
                                    <input id="ui_group_mobile" name="ui_group_mobile" type="text" class="form-control" placeholder="888888888" value="<?php echo $res['ui_group_mobile']; ?>">
                                </div>
                            </div>

							<div class="form-group col-md-12">
								<label>添加公众号【个人中心第六按钮 格式 显示名称|链接】</label>
								<div class="input-group">
									<input id="ui_kefu2" name="ui_kefu2" type="text" class="form-control" placeholder="QQ群|http://wpa.qq.com/msgrd?v=3&uin=qq号码&site=qq&menu=yes" value="<?php echo $res['ui_kefu2']; ?>">
								</div>
							</div>
							<div class="form-group col-md-12">
								<label>个人中心第一张缩略图</label>
								<div class="input-group">
									<input id="ui_button3backg" name="ui_button3backg" type="text" class="form-control" placeholder="完整的图片地址" value="<?php echo $res['ui_button3backg']; ?>">
								</div>
							</div>
							<div class="form-group col-md-12">
								<label>个人中心第一张弹出大图</label>
								<div class="input-group">
									<input id="ui_buttonadimg" name="ui_buttonadimg" type="text" class="form-control" placeholder="完整的图片地址" value="<?php echo $res['ui_buttonadimg']; ?>">
								</div>
							</div>
							<div class="form-group col-md-12">
								<label>个人中心第二张缩略图</label>
								<div class="input-group">
									<input id="ui_button3backg2" name="ui_button3backg2" type="text" class="form-control" placeholder="完整的图片地址" value="<?php echo $res['ui_button3backg2']; ?>">
								</div>
							</div>
							<div class="form-group col-md-12">
								<label>个人中心第二张弹出大图</label>
								<div class="input-group">
									<input id="ui_buttonadimg2" name="ui_buttonadimg2" type="text" class="form-control" placeholder="完整的图片地址" value="<?php echo $res['ui_buttonadimg2']; ?>">
								</div>
							</div>
							<div class="form-group col-md-12">
								<label>个人中心第三张缩略图</label>
								<div class="input-group">
									<input id="ui_button3backg3" name="ui_button3backg3" type="text" class="form-control" placeholder="完整的图片地址" value="<?php echo $res['ui_button3backg3']; ?>">
								</div>
							</div>
							<div class="form-group col-md-12">
								<label>个人中心第三张弹出大图</label>
								<div class="input-group">
									<input id="ui_buttonadimg3" name="ui_buttonadimg3" type="text" class="form-control" placeholder="完整的图片地址" value="<?php echo $res['ui_buttonadimg3']; ?>">
								</div>
							</div>
							<div class="form-group col-md-12">
								<label>多仓线路里只有VIP才显示的线路【多个用|分开 多仓名称】</label>
								<div class="input-group">
									<input id="ui_vipdc" name="ui_vipdc" type="text" class="form-control" placeholder="如:俊佬线路|蜂蜜线路" value="<?php echo $res['ui_vipdc']; ?>">
								</div>
							</div>
							<div class="form-group col-md-12">
								<label>多仓线路里只有指定账号才显示的线路【多个用|分开 多仓名称】</label>
								<div class="input-group">
									<input id="ui_vipdc_zdmc" name="ui_vipdc_zdmc" type="text" class="form-control" placeholder="如:俊佬线路|蜂蜜线路" value="<?php echo $res['ui_vipdc_zdmc']; ?>">
								</div>
							</div>
							<div class="form-group col-md-12">
								<label>多仓线路里只有指定账号才显示的线路【多个用|分开 账号名称】</label>
								<div class="input-group">
									<input id="ui_vipdc_zdzh" name="ui_vipdc_zdzh" type="text" class="form-control" placeholder="如:136584|269878" value="<?php echo $res['ui_vipdc_zdzh']; ?>">
								</div>
							</div>
							<div class="form-group col-md-12">
								<label>多仓线路里只有指定账号才显示的线路需要输入的密码</label>
								<div class="input-group">
									<input id="ui_vipdc_zdzhpass" name="ui_vipdc_zdzhpass" type="text" class="form-control" placeholder="如:123456" value="<?php echo $res['ui_vipdc_zdzhpass']; ?>">
								</div>
							</div>

							<div class="form-group col-md-12">
								<label>直播多仓线路里只有VIP才显示的线路【多个用|分开 直播名称】(暂不可用)</label>
								<div class="input-group">
									<input id="ui_vipzb" name="ui_vipzb" type="text" class="form-control" placeholder="如:俊佬线路|蜂蜜线路" value="<?php echo $res['ui_vipzb']; ?>">
								</div>
							</div>
							<div class="form-group col-md-12">
								<label>直播多仓线路里只有指定账号才显示的线路【多个用|分开 直播多仓名称】(暂不可用)</label>
								<div class="input-group">
									<input id="ui_vipzb_zdmc" name="ui_vipzb_zdmc" type="text" class="form-control" placeholder="如:俊佬线路|蜂蜜线路" value="<?php echo $res['ui_vipzb_zdmc']; ?>">
								</div>
							</div>
							<div class="form-group col-md-12">
								<label>直播多仓线路里只有指定账号才显示的线路【多个用|分开 账号名称】(暂不可用)</label>
								<div class="input-group">
									<input id="ui_vipzb_zdzh" name="ui_vipzb_zdzh" type="text" class="form-control" placeholder="如:136584|269878" value="<?php echo $res['ui_vipzb_zdzh']; ?>">
								</div>
							</div>
							<div class="form-group col-md-12">
								<label>直播多仓线路里只有指定账号才显示的线路需要输入的密码(暂不可用)</label>
								<div class="input-group">
									<input id="ui_vipzb_zdzhpass" name="ui_vipzb_zdzhpass" type="text" class="form-control" placeholder="如:123456" value="<?php echo $res['ui_vipzb_zdzhpass']; ?>">
								</div>
							</div>
							<div class="form-group col-md-12">
								<label>屏蔽播放源【多个用|分开】</label>
								<div class="input-group">
									<input id="ui_removersc" name="ui_removersc" type="text" class="form-control" placeholder="如：lzm3u8|ffm3u8" value="<?php echo $res['ui_removersc']; ?>">
								</div>
							</div>
							<div class="form-group col-md-12">
								<label>屏蔽解析【多个用|分开】</label>
								<div class="input-group">
									<input id="ui_remove_parses" name="ui_remove_parses" type="text" class="form-control" placeholder="如：WEB解析|故人" value="<?php echo $res['ui_remove_parses']; ?>">
								</div>
							</div>
							<div class="form-group col-md-12">
								<label>屏蔽分类【多个用|分开】</label>
								<div class="input-group">
									<input id="ui_remove_class" name="ui_remove_class" type="text" class="form-control" placeholder="如：分类一|分类二" value="<?php echo $res['ui_remove_class']; ?>">
								</div>
							</div>
							<div class="form-group col-md-12">
								<label>需要解析去插播视频广告的播放器名称【多个用|分开 要配合app/adjx.php规则使用 没有规则的请不要在这里填写 否则无法播放】</label>
								<div class="input-group">
									<input id="ui_remove_adjx" name="ui_remove_adjx" type="text" class="form-control" placeholder="如：lzm3u8|ffm3u8" value="<?php echo $res['ui_remove_adjx']; ?>">
								</div>
							</div>
							<div class="form-group col-md-6">
								<div class="form-group">
									<label>播放器名称【多个用|分开】详情页替换播放器名称</label>
									<div class="input-group">
										<textarea class="form-control" id="ui_parse_name" name="ui_parse_name" rows="5" placeholder="如：qq=>腾讯视频|qiyi=>爱奇艺"><?php echo $res['ui_parse_name']; ?></textarea>
									</div>
								</div>
							</div>
							<div class="form-group col-md-6">
								<div class="form-row">
									<div class="form-group col-md-12">
										<label for="example-textarea">关于软件【高亮部分用|隔开】</label>
										<textarea class="form-control" id="app_about" name="app_about" rows="5" placeholder="如：iTVBox|是XXX旗下平台....."><?php echo $res['app_about']; ?></textarea>
									</div>
								</div>
							</div>
							<div class="form-group col-md-12">
							<div class="eruyi-checkbox">
								<input type="checkbox" id="ui_state_jkjxkg" <?php if ($res['ui_state_jkjxkg'] == 'y') : ?>checked<?php endif; ?> data-switch="warning" onchange="ui_state_jkjxv(this.checked)" />
								<label for="ui_state_jkjxkg" data-on-label="开启" data-off-label="关闭"></label>
								<label class="eruyi-label">是否开启接口自带解析(不开启的话将只使用后台添加的解析)</label>
							</div>
							</div>
							<div class="form-group col-md-12">
								<div class="eruyi-checkbox">
									<input type="checkbox" id="ui_state_livevip" <?php if ($res['ui_state_livevip'] == 'y') : ?>checked<?php endif; ?> data-switch="warning" onchange="ui_state_livevipv(this.checked)" />
									<label for="ui_state_livevip" data-on-label="开启" data-off-label="关闭"></label>
									<label class="eruyi-label">是否开启只有vip才可以打开直播(不开启的话只要登录用户就可以打开)</label>
								</div>
							</div>
					</div>
				</form>
			</div> <!-- end card-body -->
		</div> <!-- end card-->
	</div> <!-- end col -->
</div>
<!-- end row -->
<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-body">
				<form>
					<div class="eruyi-checkbox">
						<input type="checkbox" id="ui_state" <?php if ($res['ui_state'] == 'y') : ?>checked<?php endif; ?> data-switch="warning" onchange="ui_state_v(this.checked)" />
						<label for="ui_state" data-on-label="开启" data-off-label="关闭"></label>
						<label class="eruyi-label">M3U8优先</label>
					</div>
					<div class="view" name="ui_state_y" id="ui_state_y" <?php if ($res['ui_state'] == 'y') : ?> style="display: block" <?php endif; ?>>
						<p class="text-muted">
							开启后视频详情页播放器以 <code>M3U8优先</code> 排序
						</p>
					</div>
					<div class="view" name="ui_state_n" id="ui_state_n" <?php if ($res['ui_state'] == 'n') : ?> style="display: block" <?php endif; ?>>
						<p class="text-muted">
							关闭后视频详情页播放器以 <code>默认状态</code> 排序
						</p>
					</div>
					<div class="view" name="ui_state_div" id="ui_state_div" <?php if ($res['ui_state'] != '111') : ?> style="display: block" <?php endif; ?>>
						<div class="form-row">
						</div>
						<div class="form-row">
				</div>
				</div>
					<div class="form-row">
							
								</div>
						
						<div class="form-row">
							
						</div>
						<div class="form-row">
							
						</div>
					</div>
				</form>
			</div> <!-- end card-body -->
		</div> <!-- end card -->
	</div> <!-- end col -->
</div><!-- end row -->
<div class="view" name="reg_way" id="reg_way" <?php if ($res['logon_way'] == 0 || $res['logon_way'] == 2) : ?> style="display: block" <?php endif; ?>>
	<div class="row">
		<div class="col-lg-12">
			<div class="card">
				<div class="card-body">
					<form>
						<div class="eruyi-checkbox">
							<input type="checkbox" id="reg_state" <?php if ($res['reg_state'] == 'y') : ?>checked<?php endif; ?> data-switch="success" onchange="reg_state_v(this.checked)" />
							<label for="reg_state" data-on-label="开启" data-off-label="关闭"></label>
							<label class="eruyi-label">注册控制</label>
						</div>
						<div class="view" name="reg_state_y" id="reg_state_y" <?php if ($res['reg_state'] == 'y') : ?> style="display: block" <?php endif; ?>>
							<p class="text-muted">
								开启注册后，该应用可以 <code>正常注册</code>
							</p>
							<div class="form-row">
								<div class="form-group col-md-6">
									<label class="col-form-label">IP重复注册间隔</label>
									<div class="input-group">
										<input type="number" id="reg_ipon" name="reg_ipon" class="form-control" placeholder="设置IP重复注册间隔时间" value="<?php echo $res['reg_ipon']; ?>">
										<div class="input-group-prepend">
											<span class="input-group-text">小时</span>
										</div>
									</div>

								</div>
								<div class="form-group col-md-6">
									<label class="col-form-label">设备重复注册间隔</label>
									<div class="input-group">
										<input type="number" id="reg_inon" name="reg_inon" class="form-control" placeholder="设置设备重复注册间隔时间" value="<?php echo $res['reg_inon']; ?>">
										<div class="input-group-prepend">
											<span class="input-group-text">小时</span>
										</div>
									</div>

								</div>
							</div>
							<div class="form-row">
								<div class="form-group col-md-4">
									<label class="col-form-label">注册奖励类型</label>
									<select class="form-control" name="reg_award" id="reg_award" onchange="reg_change()">
										<option value="vip" <?php if ($res['reg_award'] == 'vip') echo 'selected = "selected"'; ?>>会员</option>
										<option value="fen" <?php if ($res['reg_award'] == 'fen') echo 'selected = "selected"'; ?>>积分</option>
									</select>
								</div>
								<div class="form-group col-md-8">
									<label class="col-form-label">注册奖励数</label>
									<div class="input-group">
										<input type="number" id="reg_award_num" name="reg_award_num" class="form-control" placeholder="0则不奖励" value="<?php echo $res['reg_award_num']; ?>">
										<div class="input-group-prepend">
											<span class="input-group-text" id="reg_award_a"><?php if ($res['reg_award'] == 'vip') : ?>分钟<?php else : ?>积分<?php endif; ?></span>
										</div>
									</div>
								</div>
							</div>
							<div class="form-row">
								<div class="form-group col-md-4">
									<label class="col-form-label">邀请奖励类型【暂未适配】</label>
									<select class="form-control" name="inv_award" id="inv_award" onchange="inv_change()">
										<option value="vip" <?php if ($res['inv_award'] == 'vip') echo 'selected = "selected"'; ?>>会员</option>
										<option value="fen" <?php if ($res['inv_award'] == 'fen') echo 'selected = "selected"'; ?>>积分</option>
									</select>
								</div>
								<div class="form-group col-md-8">
									<label class="col-form-label">邀请奖励数</label>
									<div class="input-group">
										<input type="number" id="inv_award_num" name="inv_award_num" class="form-control" placeholder="0则不奖励" value="<?php echo $res['inv_award_num']; ?>">
										<div class="input-group-prepend">
											<span class="input-group-text" id="inv_award_a"><?php if ($res['inv_award'] == 'vip') : ?>小时<?php else : ?>积分<?php endif; ?></span>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="view" name="reg_state_n" id="reg_state_n" <?php if ($res['reg_state'] == 'n') : ?> style="display: block" <?php endif; ?>>
							<p class="text-muted">
								关闭注册后，该应用 <code>禁止所有用户注册</code>
							</p>
							<div class="form-group">
								<label class="col-form-label">注册关闭提示</label>
								<input type="text" id="reg_notice" name="reg_notice" class="form-control" placeholder="告诉用户为什么关闭注册" value="<?php echo $res['reg_notice']; ?>">
							</div>
						</div>
					</form>

				</div> <!-- end card-body -->
			</div> <!-- end card -->
		</div> <!-- end col -->
	</div> <!-- end view -->
</div> <!-- end row -->

<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-body">
				<form>
					<div class="eruyi-checkbox">
						<input type="checkbox" id="logon_state" <?php if ($res['logon_state'] == 'y') : ?>checked<?php endif; ?> data-switch="success" onchange="logon_state_v(this.checked)" />
						<label for="logon_state" data-on-label="开启" data-off-label="关闭"></label>
						<label class="eruyi-label">登录控制</label>
					</div>

					<div class="view" name="logon_state_y" id="logon_state_y" <?php if ($res['logon_state'] == 'y') : ?> style="display: block" <?php endif; ?>>
						<p class="text-muted">
							开启登录后，该应用下的用户可以 <code>正常登录</code> 使用软件（被禁封的用户除外）
						</p>
						<div class="form-row">
							<div class="form-group col-md-12">
								<label class="col-form-label">登录方式</label>
								<select class="form-control" name="logon_way" id="logon_way" onchange="logon_way_v(this.value)">
									<option value="0" <?php if ($res['logon_way'] == 0) echo 'selected = "selected"'; ?>>账号登录</option>
									<option value="1" <?php if ($res['logon_way'] == 1) echo 'selected = "selected"'; ?>>卡密登录</option>
									<option value="2" <?php if ($res['logon_way'] == 2) echo 'selected = "selected"'; ?>>无感认证</option>
								</select>
							</div>
						</div>
						<div class="view" name="logon_way_0" id="logon_way_0" <?php if ($res['logon_way'] == 0 || $res['logon_way'] == 2) : ?> style="display: block" <?php endif; ?>>
							<div class="form-row">
								<div class="form-group col-md-4">
									<label class="col-form-label">登录时验证设备信息</label>
									<select class="form-control" name="logon_check_in" id="logon_check_in" onchange="logon_check_in_v(this.value)">
										<option value="y" <?php if ($res['logon_check_in'] == 'y') echo 'selected = "selected"'; ?>>验证</option>
										<option value="n" <?php if ($res['logon_check_in'] == 'n') echo 'selected = "selected"'; ?>>不验证</option>
									</select>
								</div>
								<div class="form-group col-md-4">
									<label class="col-form-label">多设备登录数</label>
									<input type="number" id="logon_num" name="logon_num" class="form-control" placeholder="0或1则只允许同时登录一个设备" <?php if ($res['logon_check_in'] == 'y') : ?> disabled value="1" <?php elseif ($res['logon_check_in'] == 'n') : ?> value="<?php echo $res['logon_num']; ?>" <?php endif; ?>>
								</div>
								<div class="form-group col-md-4">
									<label class="col-form-label">设备换绑间隔时间</label>
									<div class="input-group">
										<input type="number" id="logon_check_t" name="logon_check_t" class="form-control" placeholder="0则不限制换绑间隔" value="<?php echo $res['logon_check_t']; ?>">
										<div class="input-group-prepend">
											<span class="input-group-text">小时</span>
										</div>
									</div>
								</div>
							</div>

							<div class="form-row">
								<div class="form-group col-md-4">
									<label class="col-form-label">签到奖励类型【暂未适配】</label>
									<select class="form-control" name="diary_award" id="diary_award" onchange="diary_change()">
										<option value="vip" <?php if ($res['diary_award'] == 'vip') echo 'selected = "selected"'; ?>>会员</option>
										<option value="fen" <?php if ($res['diary_award'] == 'fen') echo 'selected = "selected"'; ?>>积分</option>
									</select>
								</div>
								<div class="form-group col-md-8">
									<label class="col-form-label">签到奖励数</label>
									<div class="input-group">
										<input type="number" id="diary_award_num" name="diary_award_num" class="form-control" placeholder="0则不奖励" value="<?php echo $res['diary_award_num']; ?>">
										<div class="input-group-prepend">
											<span class="input-group-text" id="diary_award_a"><?php if ($res['diary_award'] == 'vip') : ?>分钟<?php else : ?>积分<?php endif; ?></span>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="view" name="logon_state_n" id="logon_state_n" <?php if ($res['logon_state'] == 'n') : ?> style="display: block" <?php endif; ?>>
						<p class="text-muted">
							关闭登录后 <code>所有用户</code> 都无法登录该应用了
						</p>
						<div class="form-group">
							<label class="col-form-label">登录关闭提示</label>
							<input type="text" id="logon_notice" name="logon_notice" class="form-control" placeholder="告诉用户为什么关闭登录" value="<?php echo $res['logon_notice']; ?>">
						</div>
					</div>

				</form>

			</div> <!-- end card-body -->
		</div> <!-- end card -->
	</div> <!-- end col -->
</div> <!-- end row -->

<div class="view" name="smtp_way" id="smtp_way" <?php if ($res['logon_way'] == 0 || $res['logon_way'] == 2) : ?> style="display: block" <?php endif; ?>>
	<div class="row">
		<div class="col-lg-12">
			<div class="card">
				<div class="card-body">
					<form>
						<div class="eruyi-checkbox">
							<input type="checkbox" id="smtp_state" <?php if ($res['smtp_state'] == 'y') : ?>checked<?php endif; ?> data-switch="secondary" onchange="smtp_state_v(this.checked)" />
							<label for="smtp_state" data-on-label="开启" data-off-label="关闭"></label>
							<label class="eruyi-label">邮箱控制</label>
						</div>

						<div class="view" name="smtp_state_y" id="smtp_state_y" <?php if ($res['smtp_state'] == 'y') : ?> style="display: block" <?php endif; ?>>
							<p class="text-muted">
								开启邮箱控制后，用户 <code>可以使用邮箱获取验证码</code> 注册和找回密码
							</p>

							<div class="form-row">
								<div class="form-group  col-md-6">
									<label>SMTP服务器</label>
									<input id="smtp_host" name="smtp_host" type="text" class="form-control" placeholder="邮箱服务器" value="<?php echo $res['smtp_host']; ?>">
								</div>
								<div class="form-group  col-md-6">
									<label>端口</label>
									<input id="smtp_port" name="smtp_port" type="number" class="form-control" placeholder="邮箱端口" value="<?php echo $res['smtp_port']; ?>">
								</div>
							</div>
							<div class="form-row">
								<div class="form-group  col-md-6">
									<label>SMTP用户名</label>
									<input id="smtp_user" name="smtp_user" type="text" class="form-control" placeholder="邮箱账号" value="<?php echo $res['smtp_user']; ?>">
								</div>
								<div class="form-group  col-md-6">
									<label>SMTP密码</label>
									<input id="smtp_pass" name="smtp_pass" type="text" class="form-control" placeholder="邮箱密码" value="<?php echo $res['smtp_pass']; ?>">
								</div>
							</div>
						</div>
						<div class="view" name="smtp_state_n" id="smtp_state_n" <?php if ($res['smtp_state'] == 'n') : ?> style="display: block" <?php endif; ?>>
							<p class="text-muted">
								关闭邮箱控制后，用户 <code>无法使用</code> 邮箱注册验证码和邮箱找回密码，电视验证邮箱，不好操作，先不适配
							</p>
						</div>
					</form>

				</div> <!-- end card-body -->
			</div> <!-- end card -->
		</div> <!-- end col -->
	</div><!-- end row -->
</div> <!-- end view -->

<div class="view" name="pay_way" id="pay_way" <?php if ($res['logon_way'] == 0 || $res['logon_way'] == 2) : ?> style="display: block" <?php endif; ?>>
	<div class="row">
		<div class="col-lg-12">
			<div class="card">
				<div class="card-body">
					<form>
						<div class="eruyi-checkbox">
							<input type="checkbox" id="pay_state" <?php if ($res['pay_state'] == 'y') : ?>checked<?php endif; ?> data-switch="bool" onchange="pay_state_v(this.checked)" />
							<label for="pay_state" data-on-label="开启" data-off-label="关闭"></label>
							<label class="eruyi-label">支付控制</label>
						</div>
						<div class="view" name="pay_state_y" id="pay_state_y" <?php if ($res['pay_state'] == 'y') : ?> style="display: block" <?php endif; ?>>
							<p class="text-muted">
								开启支付后可接入所有<code>易支付</code>平台, 只需要简单填写信息即可完成无缝对接<code>支付充值</code> 购买会员用户组
							</p>
							<div class="form-group">
								<label class="col-form-label">请求地址</label>
								<div class="input-group">
									<input type="text" class="form-control" id="pay_url" name="pay_url" placeholder="支持所有易支付平台，域名网址" value="<?php if ($res['pay_url'] == '') {
																																				echo 'https://pay.muitc.com';
																																			} else {
																																				echo $res['pay_url'];
																																			} ?>">
									<div class="input-group-append">
										<button class="btn btn-dark" type="button" id="alipay">商户申请</button>
									</div>
								</div>
							</div>
							<div class="form-row">
								<div class="form-group  col-md-4">
									<label>商户ID</label>
									<input id="pay_id" name="pay_id" type="text" class="form-control" placeholder="商户ID" value="<?php echo $res['pay_id']; ?>">
								</div>
								<div class="form-group  col-md-8">
									<label>商户KEY</label>
									<input id="pay_key" name="pay_key" type="text" class="form-control" placeholder="商户KEY" value="<?php echo $res['pay_key']; ?>">
								</div>
							</div>
							<div class="form-row">
								<div class="form-group col-md-4">
									<label>支付宝</label>
									<select class="form-control" name="pay_ali_state" id="pay_ali_state">
										<option value="y" <?php if ($res['pay_ali_state'] == 'y') echo 'selected = "selected"'; ?>>开启</option>
										<option value="n" <?php if ($res['pay_ali_state'] == 'n') echo 'selected = "selected"'; ?>>关闭</option>
									</select>
								</div>
								<div class="form-group col-md-4">
									<label>微信</label>
									<select class="form-control" name="pay_wx_state" id="pay_wx_state">
										<option value="y" <?php if ($res['pay_wx_state'] == 'y') echo 'selected = "selected"'; ?>>开启</option>
										<option value="n" <?php if ($res['pay_wx_state'] == 'n') echo 'selected = "selected"'; ?>>关闭</option>
									</select>
								</div>
								<div class="form-group col-md-4">
									<label>QQ钱包</label>
									<select class="form-control" name="pay_qq_state" id="pay_qq_state">
										<option value="y" <?php if ($res['pay_qq_state'] == 'y') echo 'selected = "selected"'; ?>>开启</option>
										<option value="n" <?php if ($res['pay_qq_state'] == 'n') echo 'selected = "selected"'; ?>>关闭</option>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-form-label">异步通知地址</label>
								<input type="text" class="form-control" id="pay_notify" name="pay_notify" placeholder="异步通知地址" value="<?php if ($res['pay_notify'] == '') {
																																			echo dirname(WEB_URL) . '/notify.php';
																																		} else {
																																			echo $res['pay_notify'];
																																		} ?>">
							</div>
							<div class="form-group">
								<label class="col-form-label">发卡平台地址</label>
								<input type="text" class="form-control" id="kami_url" name="kami_url" placeholder="发卡平台地址" value="<?php echo $res['kami_url']; ?>">
							</div>
						</div>
						<div class="view" name="pay_state_n" id="pay_state_n" <?php if ($res['pay_state'] == 'n') : ?> style="display: block" <?php endif; ?>>
							<p class="text-muted">
								关闭支付后该应用则<code>无法使用</code>支付功能，开启后才能进入【开通会员】否则【卡密充值】
							</p>
						</div>
					</form>
				</div> <!-- end card-body -->
			</div> <!-- end card -->
		</div> <!-- end col -->
	</div><!-- end row -->
</div> <!-- end view -->

<div class="row">
	<div class="col-lg-12">
		<div class="card">
			<div class="card-body">
				<form>
					<div class="eruyi-checkbox">
						<input type="checkbox" id="mi_state" <?php if ($res['mi_state'] == 'y') : ?>checked<?php endif; ?> data-switch="warning" onchange="mi_state_v(this.checked)" />
						<label for="mi_state" data-on-label="开启" data-off-label="关闭"></label>
						<label class="eruyi-label">安全控制</label>
					</div>
					<div class="view" name="mi_state_y" id="mi_state_y" <?php if ($res['mi_state'] == 'y') : ?> style="display: block" <?php endif; ?>>
						<p class="text-muted">
							开启安全控制后，可对应用 <code>数据</code> 进行加密, 防止数据泄露
						</p>
						<div class="form-group">
							<label>数据加密类型</label>
							<select class="form-control" name="mi_type" id="mi_type" onchange="mi_type_v(this.value)">
								<option value="0" <?php if ($res['mi_type'] == 0) echo 'selected = "selected"'; ?>>不加密</option>
								<option value="1" <?php if ($res['mi_type'] == 1) echo 'selected = "selected"'; ?>>RC4加密</option>
								<option value="2" <?php if ($res['mi_type'] == 2) echo 'selected = "selected"'; ?>>RSA加密</option>
							</select>
						</div>
						<div class="view" name="mi_type_0" id="mi_type_0" <?php if ($res['mi_type'] == 0) : ?> style="display: block" <?php endif; ?>>
							<div class="alert alert-warning alert-dismissible fade show" role="alert">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
								<strong>提示 - </strong> 该设置仅针对数据加密，不影响其他安全设置【没啥意义，请勿开启】
							</div>
						</div>

						<div class="view" name="mi_type_1" id="mi_type_1" <?php if ($res['mi_type'] == 1) : ?> style="display: block" <?php endif; ?>>
							<div class="form-group">
								<label>RC4秘钥</label>
								<div class="input-group">
									<input type="text" id="mi_rc4_key" name="mi_rc4_key" class="form-control" placeholder="RC4加解密秘钥" value="<?php echo $res['mi_rc4_key']; ?>">
									<div class="input-group-append">
										<button class="btn btn-dark" type="button" id="rc4_key">随机</button>
									</div>
								</div>
							</div>
						</div>
						<div class="view" name="mi_type_2" id="mi_type_2" <?php if ($res['mi_type'] == 2) : ?> style="display: block" <?php endif; ?>>
							<div class="form-group">
								<label>RSA私钥</label>
								<textarea class="form-control" id="mi_rsa_private_key" name="mi_rsa_private_key" rows="5" placeholder="RSA私钥"><?php echo $res['mi_rsa_private_key']; ?></textarea>
							</div>
							<div class="form-group">
								<label>RSA公钥</label>
								<textarea class="form-control" id="mi_rsa_public_key" name="mi_rsa_public_key" rows="5" placeholder="RSA公钥"><?php echo $res['mi_rsa_public_key']; ?></textarea>
							</div>
						</div>

						<div class="form-group">
							<label>数据签名</label>
							<select class="form-control" name="mi_sign" id="mi_sign">
								<option value="n" <?php if ($res['mi_sign'] == 'n') echo 'selected = "selected"'; ?>>不签名</option>
								<option value="y" <?php if ($res['mi_sign'] == 'y') echo 'selected = "selected"'; ?>>签名</option>
							</select>
						</div>
						<div class="alert alert-warning alert-dismissible fade show" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
							<strong>提示 - </strong> 若使用数据签名，可有效防止数据被篡改【如果客户端出现签名错误可尝试关闭该选项】
						</div>
						<div class="form-group">
							<label>时间差校验</label>
							<div class="input-group">
								<input id="mi_time" name="mi_time" type="number" class="form-control" placeholder="时间校验" value="<?php echo $res['mi_time']; ?>">
								<div class="input-group-prepend">
									<span class="input-group-text">秒</span>
								</div>
							</div>
						</div>
						<div class="alert alert-warning alert-dismissible fade show" role="alert">
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
							<strong>提示 - </strong> 对客户设备时间与服务器时间进行时差校验，避免用户修改本地时间非法使用VIP功能，设置 0 则不校验
						</div>
					</div>
					<div class="view" name="mi_state_n" id="mi_state_n" <?php if ($res['mi_state'] == 'n') : ?> style="display: block" <?php endif; ?>>
						<p class="text-muted">
							关闭安全控制后，该应用 <code>数据</code> 将以明文传输，不使用任何安全配置
						</p>
					</div>
				</form>
			</div> <!-- end card-body -->
		</div> <!-- end card -->
	</div> <!-- end col -->
</div><!-- end row -->

<!-- Form row -->
<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-body">
				<form action="" method="post" id="addimg" name="addimg">
					<div class="eruyi-checkbox">
						<input type="checkbox" id="state" <?php if ($res['state'] == 'y') : ?>checked<?php endif; ?> data-switch="success" onchange="state_v(this.checked)" />
						<label for="state" data-on-label="开启" data-off-label="关闭"></label>
						<label class="eruyi-label">应用控制</label>
					</div>

					<div class="view" name="state_y" id="state_y" <?php if ($res['state'] == 'y') : ?> style="display: block" <?php endif; ?>>
						<p class="text-muted">
							开启应用控制后，该应用下的用户可以 <code>正常使用</code>
						</p>
						<div class="form-row">
							<div class="form-group col-md-12">
								<label class="col-form-label">运营模式</label>
								<select class="form-control" name="mode" id="mode">
									<option value="y" <?php if ($res['mode'] == 'y') echo 'selected = "selected"'; ?>>收费模式</option>
									<option value="n" <?php if ($res['mode'] == 'n') echo 'selected = "selected"'; ?>>免费模式</option>
								</select>
							</div>
						</div>
						<div class="form-row">
							<div class="form-group col-md-2">
								<label class="col-form-label">TV应用版本</label>
								<input type="text" id="app_bb" name="app_bb" class="form-control" placeholder="1.0" value="<?php echo $res['app_bb']; ?>">

							</div>
							<div class="form-group col-md-10">
								<label class="col-form-label">TV更新地址</label>
								<input type="text" id="app_nurl" name="app_nurl" class="form-control" placeholder="版本更新地址" value="<?php echo $res['app_nurl']; ?>">
							</div>

						</div>
						<div class="form-row">
							<div class="form-group col-md-12">
								<label for="example-textarea">TV更新内容</label>
								<textarea class="form-control" id="app_nshow" name="app_nshow" rows="5" placeholder="版本更新内容"><?php echo $res['app_nshow']; ?></textarea>
							</div>
						</div>

						<div class="form-row">
							<div class="form-group col-md-2">
								<label class="col-form-label">mobile应用版本</label>
								<input type="text" id="app_bb_mobile" name="app_bb_mobile" class="form-control" placeholder="1.0" value="<?php echo $res['app_bb_mobile']; ?>">

							</div>
							<div class="form-group col-md-10">
								<label class="col-form-label">mobile更新地址</label>
								<input type="text" id="app_nurl_mobile" name="app_nurl_mobile" class="form-control" placeholder="版本更新地址" value="<?php echo $res['app_nurl_mobile']; ?>">
							</div>

						</div>
						<div class="form-row">
							<div class="form-group col-md-12">
								<label for="example-textarea">mobile更新内容</label>
								<textarea class="form-control" id="app_nshow_mobile" name="app_nshow_mobile" rows="5" placeholder="版本更新内容"><?php echo $res['app_nshow_mobile']; ?></textarea>
							</div>
						</div>

					</div>
					<div class="view" name="state_n" id="state_n" <?php if ($res['state'] == 'n') : ?> style="display: block" <?php endif; ?>>
						<p class="text-muted">
							关闭应用控制后，该应用下的用户 <code>不允许任何操作</code>
						</p>
						<div class="form-group">
							<label class="col-form-label">应用关闭通知</label>
							<input type="text" id="notice" name="notice" class="form-control" placeholder="告诉用户为什么关闭登录" value="<?php echo $res['notice']; ?>">
						</div>
					</div>
					<div class="form-group col-md-12">
						<div class="eruyi-checkbox">
							<input type="checkbox" id="ui_state_infojm" <?php if ($res['ui_state_infojm'] == 'y') : ?>checked<?php endif; ?> data-switch="warning" onchange="ui_state_infojmv(this.checked)" />
							<label for="ui_state_infojm" data-on-label="开启" data-off-label="关闭"></label>
							<label class="eruyi-label">是否加密本页内容的输出信息(调试用,默认打开)</label>
						</div>
					</div>
					<div class="form-group">
						<div class="custom-control custom-checkbox">
							<input type="checkbox" class="custom-control-input" id="ok" name="ok" value="y" required>
							<label class="custom-control-label" for="ok">确认是我操作</label>
						</div>
					</div>
					<button type="submit" class="btn btn-block btn-primary" name="submit" id="submit" value="确认">确认修改</button>
				</form>
				<!-- <button type="submit" class="btn btn-block btn-dark eruyi-append" name="recovery" id="recovery" value="确认">恢复默认</button> -->
			</div> <!-- end card-body -->
		</div> <!-- end card-->
	</div> <!-- end col -->
</div>
<!-- <script src="https://oss.lvdoui.net/static/Toolkit/edittwo.js"></script> -->
<script>
	$("#app_adm").addClass("active");
	$('#submit').click(function() {
		let t = window.jQuery;
		var ok = document.getElementById("ok").checked;
		var state = document.getElementById("state").checked;
		if (state) {
			state = 'y';
		} else {
			state = 'n';
		}
		var mi_state = document.getElementById("mi_state").checked;
		if (mi_state) {
			mi_state = 'y';
		} else {
			mi_state = 'n';
		}
		var pay_state = document.getElementById("pay_state").checked;
		if (pay_state) {
			pay_state = 'y';
		} else {
			pay_state = 'n';
		}
		var logon_state = document.getElementById("logon_state").checked;
		if (logon_state) {
			logon_state = 'y';
		} else {
			logon_state = 'n';
		}
		var reg_state = document.getElementById("reg_state").checked;
		if (reg_state) {
			reg_state = 'y';
		} else {
			reg_state = 'n';
		}
		var smtp_state = document.getElementById("smtp_state").checked;
		if (smtp_state) {
			smtp_state = 'y';
		} else {
			smtp_state = 'n';
		}

		var name = $("input[name='name']").val();
		var appkey = $("input[name='appkey']").val();
		
		var reg_ipon = $("input[name='reg_ipon']").val();
		var reg_inon = $("input[name='reg_inon']").val();

		var reg_award = $("select[name='reg_award']").val();
		var reg_award_num = $("input[name='reg_award_num']").val();

		var inv_award = $("select[name='inv_award']").val();
		var inv_award_num = $("input[name='inv_award_num']").val();

		var reg_notice = $("input[name='reg_notice']").val();


		var logon_way = $("select[name='logon_way']").val();
		var logon_check_in = $("select[name='logon_check_in']").val();
		var logon_check_t = $("input[name='logon_check_t']").val();
		var logon_num = $("input[name='logon_num']").val();

		var diary_award = $("select[name='diary_award']").val();
		var diary_award_num = $("input[name='diary_award_num']").val();
		var logon_notice = $("input[name='logon_notice']").val();

		var smtp_host = $("input[name='smtp_host']").val();
		var smtp_user = $("input[name='smtp_user']").val();
		var smtp_pass = $("input[name='smtp_pass']").val();
		var smtp_port = $("input[name='smtp_port']").val();

		var pay_url = $("input[name='pay_url']").val();
		var pay_id = $("input[name='pay_id']").val();
		var pay_key = $("input[name='pay_key']").val();
		var pay_ali_state = $("select[name='pay_ali_state']").val();
		var pay_wx_state = $("select[name='pay_wx_state']").val();
		var pay_qq_state = $("select[name='pay_qq_state']").val();
		var pay_notify = $("input[name='pay_notify']").val();

		var mi_type = $("select[name='mi_type']").val();
		var mi_sign = $("select[name='mi_sign']").val();
		var mi_time = $("input[name='mi_time']").val();
		var mi_rsa_private_key = $("textarea[name='mi_rsa_private_key']").val();
		var mi_rsa_public_key = $("textarea[name='mi_rsa_public_key']").val();
		var mi_rc4_key = $("input[name='mi_rc4_key']").val();

		var mode = $("select[name='mode']").val();
		var app_bb = $("input[name='app_bb']").val();
		var app_nurl = $("input[name='app_nurl']").val();
		var app_nshow = $("textarea[name='app_nshow']").val();
		var app_bb_mobile = $("input[name='app_bb_mobile']").val();
		var app_nurl_mobile = $("input[name='app_nurl_mobile']").val();
		var app_nshow_mobile = $("textarea[name='app_nshow_mobile']").val();
		var notice = $("input[name='notice']").val();

		var ui_state = document.getElementById("ui_state").checked;
		if (ui_state) {
			ui_state = 'y';
		} else {
			ui_state = 'n';
		}

		var ui_state_live = document.getElementById("ui_state_live").checked;
		if (ui_state_live) {
			ui_state_live = 'y';
		} else {
			ui_state_live = 'n';
		}

		var ui_state_jkjxkg = document.getElementById("ui_state_jkjxkg").checked;
		if (ui_state_jkjxkg) {
			ui_state_jkjxkg = 'y';
		} else {
			ui_state_jkjxkg = 'n';
		}
		var ui_state_livevip = document.getElementById("ui_state_livevip").checked;
		if (ui_state_livevip) {
			ui_state_livevip = 'y';
		} else {
			ui_state_livevip = 'n';
		}
		var ui_state_infojm = document.getElementById("ui_state_infojm").checked;
		if (ui_state_infojm) {
			ui_state_infojm = 'y';
		} else {
			ui_state_infojm = 'n';
		}
		var ui_state_jk = document.getElementById("ui_state_jk").checked;
		if (ui_state_jk) {
			ui_state_jk = 'y';
		} else {
			ui_state_jk = 'n';
		}
		var ui_state_dcjm = document.getElementById("ui_state_dcjm").checked;
		if (ui_state_dcjm) {
			ui_state_dcjm = 'y';
		} else {
			ui_state_dcjm = 'n';
		}
		
		var kami_url = $("input[name='kami_url']").val();
		var app_json = $("input[name='app_json']").val();
		var app_jsonb = $("input[name='app_jsonb']").val();
		var app_jsonc = $("input[name='app_jsonc']").val();
		var app_huodong = $("input[name='app_huodong']").val();
		var ui_paybackg = $("input[name='ui_paybackg']").val();
		var ui_kefu = $("input[name='ui_kefu']").val();
        var ui_kefu_mobile = $("input[name='ui_kefu_mobile']").val();
		var ui_kefu2 = $("input[name='ui_kefu2']").val();
		var ui_button3backg = $("input[name='ui_button3backg']").val();
		var ui_buttonadimg = $("input[name='ui_buttonadimg']").val();
		var ui_button3backg2 = $("input[name='ui_button3backg2']").val();
		var ui_button3backg3 = $("input[name='ui_button3backg3']").val();
		var ui_buttonadimg2 = $("input[name='ui_buttonadimg2']").val();
		var ui_buttonadimg3 = $("input[name='ui_buttonadimg3']").val();
		var ui_vipdc = $("input[name='ui_vipdc']").val();
		var ui_vipdc_zdmc = $("input[name='ui_vipdc_zdmc']").val();
		var ui_vipdc_zdzh = $("input[name='ui_vipdc_zdzh']").val();
		var ui_vipdc_zdzhpass = $("input[name='ui_vipdc_zdzhpass']").val();
		var ui_vipzb = $("input[name='ui_vipzb']").val();
		var ui_vipzb_zdmc = $("input[name='ui_vipzb_zdmc']").val();
		var ui_vipzb_zdzh = $("input[name='ui_vipzb_zdzh']").val();
		var ui_vipzb_zdzhpass = $("input[name='ui_vipzb_zdzhpass']").val();
		var ui_group = $("input[name='ui_group']").val();
        var ui_group_mobile = $("input[name='ui_group_mobile']").val();
		var ui_logo = $("input[name='ui_logo']").val();
		var ad_slide = $("input[name='ad_slide']").val();
        var ad_slide_mobile = $("input[name='ad_slide_mobile']").val();
		var ad_slide_soundkg = $("input[name='ad_slide_soundkg']").val();
		var free_time = $("input[name='free_time']").val();
		var free_time_tip = $("input[name='free_time_tip']").val();
		var isToPay = $("input[name='isToPay']").val();
		var isNoticeShow = $("input[name='isNoticeShow']").val();
		var livePass = $("input[name='livePass']").val();
		var liveUrl = $("input[name='liveUrl']").val();
		var play_tips = $("input[name='play_tips']").val();
		var ui_startad_bj = $("input[name='ui_startad_bj']").val();
		var ui_startad = $("input[name='ui_startad']").val();
		var ui_startad_mobile = $("input[name='ui_startad_mobile']").val();
		var ui_startad_time = $("input[name='ui_startad_time']").val();
		var ui_startad_hdptime = $("input[name='ui_startad_hdptime']").val();
		var ui_app_banner = $("input[name='ui_app_banner']").val();
		var ui_removersc = $("input[name='ui_removersc']").val();
		var ui_remove_parses = $("input[name='ui_remove_parses']").val();
		var ui_remove_class = $("input[name='ui_remove_class']").val();
		var ui_remove_adjx = $("input[name='ui_remove_adjx']").val();
		var ui_parse_name = $("textarea[name='ui_parse_name']").val();
		var app_about = $("textarea[name='app_about']").val();
		var ui_packagename = $("input[name='ui_packagename']").val();
		var ui_tongjiid = $("input[name='ui_tongjiid']").val();
		var appid = $("input[name='appid']").val();

		if (!ok) {
			t.NotificationApp.send("提示", "请确认是我操作", "top-center", "rgba(0,0,0,0.2)", "warning")
			return false;
		}
		document.getElementById('submit').innerHTML = "<span class=\"spinner-border spinner-border-sm mr-1\" role=\"status\" aria-hidden=\"true\"></span>正在修改";
		document.getElementById('submit').disabled = true;

		$.ajax({
			cache: false,
			type: "POST", //请求的方式
			url: "ajax.php?act=app_edit", //请求的文件名
			data: {
				id: appid,
				name: name,
				appkey: appkey,
				state: state,
				mi_state: mi_state,
				smtp_state: smtp_state,
				pay_state: pay_state,
				logon_state: logon_state,
				reg_state: reg_state,
				reg_ipon: reg_ipon,
				reg_inon: reg_inon,
				reg_award: reg_award,
				reg_award_num: reg_award_num,
				inv_award: inv_award,
				inv_award_num: inv_award_num,
				reg_notice: reg_notice,
				logon_way: logon_way,
				logon_check_in: logon_check_in,
				logon_check_t: logon_check_t,
				logon_num: logon_num,
				diary_award: diary_award,
				diary_award_num: diary_award_num,
				logon_notice: logon_notice,
				smtp_host: smtp_host,
				smtp_user: smtp_user,
				smtp_pass: smtp_pass,
				smtp_port: smtp_port,
				pay_url: pay_url,
				pay_id: pay_id,
				pay_key: pay_key,
				pay_ali_state: pay_ali_state,
				pay_wx_state: pay_wx_state,
				pay_qq_state: pay_qq_state,
				pay_notify: pay_notify,
				mi_type: mi_type,
				mi_sign: mi_sign,
				mi_time: mi_time,
				mi_rsa_private_key: mi_rsa_private_key,
				mi_rsa_public_key: mi_rsa_public_key,
				mi_rc4_key: mi_rc4_key,
				mode: mode,
				app_bb: app_bb,
				app_nurl: app_nurl,
				app_nshow: app_nshow,
				app_bb_mobile: app_bb_mobile,
				app_nurl_mobile: app_nurl_mobile,
				app_nshow_mobile: app_nshow_mobile,
				notice: notice,

				kami_url: kami_url,
				app_json: app_json,
				app_jsonb: app_jsonb,
				app_jsonc: app_jsonc,
				ui_state: ui_state,
				ui_state_live: ui_state_live,
				ui_state_jkjxkg: ui_state_jkjxkg,
				ui_state_livevip: ui_state_livevip,
				ui_state_infojm: ui_state_infojm,
				ui_state_jk: ui_state_jk,
				ui_state_dcjm: ui_state_dcjm,
				ui_paybackg: ui_paybackg,
				ui_kefu: ui_kefu,
                ui_kefu_mobile: ui_kefu_mobile,
				ui_kefu2: ui_kefu2,
				ui_button3backg: ui_button3backg,
				ui_buttonadimg: ui_buttonadimg,
				ui_button3backg2: ui_button3backg2,
				ui_button3backg3: ui_button3backg3,
				ui_buttonadimg2: ui_buttonadimg2,
				ui_buttonadimg3: ui_buttonadimg3,
				ui_vipdc: ui_vipdc,
				ui_vipdc_zdmc: ui_vipdc_zdmc,
				ui_vipdc_zdzh: ui_vipdc_zdzh,
				ui_vipdc_zdzhpass: ui_vipdc_zdzhpass,
				ui_vipzb: ui_vipzb,
				ui_vipzb_zdmc: ui_vipzb_zdmc,
				ui_vipzb_zdzh: ui_vipzb_zdzh,
				ui_vipzb_zdzhpass: ui_vipzb_zdzhpass,
				ui_group: ui_group,
                ui_group_mobile: ui_group_mobile,
				ui_logo: ui_logo,
				ad_slide: ad_slide,
                ad_slide_mobile: ad_slide_mobile,
				ad_slide_soundkg: ad_slide_soundkg,
				free_time: free_time,
				free_time_tip: free_time_tip,
				isToPay: isToPay,
				isNoticeShow: isNoticeShow,
				livePass: livePass,
				liveUrl: liveUrl,
				play_tips: play_tips,
				ui_startad_bj: ui_startad_bj,
				ui_startad: ui_startad,
				ui_startad_mobile: ui_startad_mobile,
				ui_startad_time: ui_startad_time,
				ui_startad_hdptime: ui_startad_hdptime,
				ui_app_banner: ui_app_banner,
				ui_removersc: ui_removersc,
				ui_remove_parses: ui_remove_parses,
				ui_remove_class: ui_remove_class,
				ui_remove_adjx: ui_remove_adjx,
				ui_parse_name: ui_parse_name,
				app_about: app_about,
				ui_packagename: ui_packagename,
				ui_tongjiid: ui_tongjiid,
				app_huodong: app_huodong
			},
			dataType: 'json',
			success: function(data) {
				// console.log(data);
				document.getElementById('submit').disabled = false;
				document.getElementById('submit').innerHTML = "确认修改";
				if (data.code == 200) {
					t.NotificationApp.send("成功", data.msg, "top-center", "rgba(0,0,0,0.2)", "success")
					document.getElementById("ok").checked = false;
					//window.setTimeout("window.location='"+window.location.href+"'",1000);
				} else {
					t.NotificationApp.send("失败", data.msg, "top-center", "rgba(0,0,0,0.2)", "error")
				}
			}
		});
		return false; //重要语句：如果是像a链接那种有href属性注册的点击事件，可以阻止它跳转。
	});

	$('#rc4_key').click(function() {
		var key = randomString(32)
		$("#mi_rc4_key").val(key);
	});

	function randomString(len) {
		len = len || 32;
		var $chars = 'ABCDEFGHJKMNPQRSTWXYZabcdefhijkmnprstwxyz2345678'; /****默认去掉了容易混淆的字符oOLl,9gq,Vv,Uu,I1****/
		var maxPos = $chars.length;
		var pwd = '';
		for (i = 0; i < len; i++) {
			pwd += $chars.charAt(Math.floor(Math.random() * maxPos));
		}
		return pwd;
	}

	function mi_type_v(i) {
		if (i == 0) {
			$("#mi_type_0").css("display", "block");
			$("#mi_type_1").css("display", "none");
			$("#mi_type_2").css("display", "none");
		} else if (i == 1) {
			$("#mi_type_0").css("display", "none");
			$("#mi_type_1").css("display", "block");
			$("#mi_type_2").css("display", "none");

		} else if (i == 2) {
			$("#mi_type_0").css("display", "none");
			$("#mi_type_1").css("display", "none");
			$("#mi_type_2").css("display", "block");
		}
	}

	function smtp_state_v(i) {
		//console.log(i);
		if (i == true) {
			$("#smtp_state_y").css("display", "block");
			$("#smtp_state_n").css("display", "none");
		} else {
			$("#smtp_state_y").css("display", "none");
			$("#smtp_state_n").css("display", "block");
		}
	}

	function mi_state_v(i) {
		//console.log(i);
		if (i == true) {
			$("#mi_state_y").css("display", "block");
			$("#mi_state_n").css("display", "none");
		} else {
			$("#mi_state_y").css("display", "none");
			$("#mi_state_n").css("display", "block");
		}
	}

	function ui_state_v(i) {
		//console.log(i);
		if (i == true) {
			$("#ui_state_y").css("display", "block");
			$("#ui_state_n").css("display", "none");
		} else {
			$("#ui_state_y").css("display", "none");
			$("#ui_state_n").css("display", "block");
		}
	}

	function pay_state_v(i) {
		//console.log(i);
		if (i == true) {
			$("#pay_state_y").css("display", "block");
			$("#pay_state_n").css("display", "none");
		} else {
			$("#pay_state_y").css("display", "none");
			$("#pay_state_n").css("display", "block");
		}
	}

	function state_v(i) {
		if (i == true) {
			$("#state_y").css("display", "block");
			$("#state_n").css("display", "none");
		} else {
			$("#state_y").css("display", "none");
			$("#state_n").css("display", "block");
		}
	}

	function logon_check_in_v(i) {
		if (i == 'y') {
			$("#logon_num").val("1");
			$("#logon_num").attr("disabled", true);
		} else {

			$("#logon_num").attr("disabled", false);
		}
	}

	function reg_state_v(i) {
		if (i == true) {
			$("#reg_state_y").css("display", "block");
			$("#reg_state_n").css("display", "none");
		} else {
			$("#reg_state_y").css("display", "none");
			$("#reg_state_n").css("display", "block");
		}
	}

	function logon_state_v(i) {
		if (i == true) {
			$("#logon_state_y").css("display", "block");
			$("#logon_state_n").css("display", "none");
		} else {
			$("#logon_state_y").css("display", "none");
			$("#logon_state_n").css("display", "block");
		}
	}

	function logon_way_v(i) {
		if (i == '0' || i == '2') {
			$("#logon_way_0").css("display", "block");
			$("#logon_way_1").css("display", "none");
			$("#reg_way").css("display", "block");
			$("#smtp_way").css("display", "block");
			$("#pay_way").css("display", "block");
		} else {
			$("#logon_way_0").css("display", "none");
			$("#logon_way_1").css("display", "block");
			$("#reg_way").css("display", "none");
			$("#smtp_way").css("display", "none");
			$("#pay_way").css("display", "none");
		}
	}

	function reg_change() {
		if ($('#reg_award').val() == 'vip') {
			document.getElementById('reg_award_a').innerHTML = "分钟";
		} else {
			document.getElementById('reg_award_a').innerHTML = "积分";
		}
	}

	function diary_change() {
		if ($('#diary_award').val() == 'vip') {
			document.getElementById('diary_award_a').innerHTML = "分钟";
		} else {
			document.getElementById('diary_award_a').innerHTML = "积分";
		}
	}

	function inv_change() {
		if ($('#inv_award').val() == 'vip') {
			document.getElementById('inv_award_a').innerHTML = "小时";
		} else {
			document.getElementById('inv_award_a').innerHTML = "积分";
		}
	}
	$('#copy_id').click(function() {
		let t = window.jQuery;
		var appid = $("input[name='appid']").val();
		var oInput = document.createElement('input');
		oInput.value = appid;
		document.body.appendChild(oInput);
		oInput.select(); // 选择对象
		document.execCommand("Copy"); // 执行浏览器复制命令
		oInput.className = 'oInput';
		oInput.style.display = 'none';
		t.NotificationApp.send("成功", 'APPID复制成功', "top-center", "rgba(0,0,0,0.2)", "success")
	});
	$('#copy_key').click(function() {
		let t = window.jQuery;
		var appkey = $("input[name='appkey']").val();
		var oInput = document.createElement('input');
		oInput.value = appkey;
		document.body.appendChild(oInput);
		oInput.select(); // 选择对象
		document.execCommand("Copy"); // 执行浏览器复制命令
		oInput.className = 'oInput';
		oInput.style.display = 'none';
		t.NotificationApp.send("成功", 'APPKEY复制成功', "top-center", "rgba(0,0,0,0.2)", "success")
	});

	$('#bian_key').click(function() {
		var appkey = randomString(32);
		$("#appkey").val(appkey);
	});

	function getQueryVariable(variable) {
		var query = window.location.search.substring(1);
		var vars = query.split("&");
		for (var i = 0; i < vars.length; i++) {
			var pair = vars[i].split("=");
			if (pair[0] == variable) {
				return pair[1];
			}
		}
		return (false);
	}

	// $('#recovery').click(function() {
	// 	let t = window.jQuery;
	// 	$("#ui_logo").val("http://oss0static.test.upcdn.net/ads/sm_logo.png");
	// 	$("#ui_startad").val("https://gimg2.baidu.com/image_search/src=http%3A%2F%2Finews.gtimg.com%2Fnewsapp_match%2F0%2F12913276164%2F0&refer=http%3A%2F%2Finews.gtimg.com&app=2002&size=f9999,10000&q=a80&n=0&g=0n&fmt=auto?sec=1664020017&t=5a8c52047a392231513cc2f6540f13c3");
	// 	$("#app_json").val("https://oss.lvdoui.net/static/TVBoxOS/static/api.json");
	// 	$("#app_jsonb").val("http://js.134584.xyz/json/pp87.json");
	// 	$("#app_jsonc").val("http://js.134584.xyz/json/pp87.json");
	// 	$("#ui_paybackg").val("http://124.222.84.216:8086/upload/app/20220808-1/66a979c9669f30b3625d32b09df3d6b7.jpg");
	// 	$("#ui_kefu").val("https://oss.lvdoui.net/ads/button3.png");
	// 	$("#ui_kefu2").val("https://oss.lvdoui.net/ads/button3.png");
	// 	$("#ui_group").val("888888888");
	// 	$("#ui_tongjiid").val("d4c411f7e4");
	// 	$("#ui_packagename").val("com.github.itvbox.osc");
	// 	$("#ui_button3backg").val("https://oss.lvdoui.net/ads/button3.png");
	// 	$("#ui_buttonadimg").val("http://oss0static.test.upcdn.net/ads/weixin2.png");
	// 	$("#ui_button3backg2").val("https://oss.lvdoui.net/ads/button3.png");
	// 	$("#ui_button3backg3").val("https://oss.lvdoui.net/ads/button3.png");
	// 	$("#ui_buttonadimg3").val("http://oss0static.test.upcdn.net/ads/weixin2.png");
	// 	$("#ui_remove_parses").val("故人|Web解析|rr解析");
	// 	$("#ui_remove_class").val("川菜|粤菜");
	// 	$("#ui_parse_name").val("qq=>腾讯视频|qiyi=>爱奇艺|youku=>优酷视频|ppayun=>七七|wasu=>华数|hnm3u8=>红牛");
	// 	$("#app_about").val("iTVBox|是TVBox二开版本，新增会员系统及调整部分UI，感谢TVBox作者开放此项目用于学习交流！本软件仅供学习参考,请于安装后24小时内删除。TVBox仓库：https://github.com/CatVodTVOfficial/TVBoxOSC");
	// 	t.NotificationApp.send("成功", '请点击确认修改', "top-center", "rgba(0,0,0,0.2)", "success")
	// });
</script>