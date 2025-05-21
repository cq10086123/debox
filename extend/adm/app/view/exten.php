<?php
/*
Sort:3
Hidden:false
Name:解析配置
Url:app_exten
Right:app_exten
Version:1.0
Author:易如意
Author QQ:51154393
Author Url:www.eruyi.cn
*/

if (!isset($islogin)) header("Location: /"); //非法访问
$nums = Db::table('app_exten')->count();
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$url = "./?app_exten&page=";
$bnums = ($page - 1) * $ENUMS;
?>

<!-- start page title -->
<div class="row">
	<div class="col-12">
		<div class="page-title-box">
			<div class="page-title-right">
				<ol class="breadcrumb m-0">
					<li class="breadcrumb-item"><a href="javascript: void(0);">首页</a></li>
					<li class="breadcrumb-item active">应用</li>
				</ol>
			</div>
			<h4 class="page-title"><?php echo $title; ?></h4>
		</div> <!-- end page-title-box -->
	</div> <!-- end col-->
</div>
<!-- end page title -->

<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-body">
				<div class="row mb-2">
					<div class="col-lg-8">
						<button type="button" onclick="modal_cut('add',0,0,0,0)" class="btn btn-danger mb-2 mr-2" data-toggle="modal" data-target="#modal"><i class="mdi mdi-briefcase-plus-outline mr-1"></i>添加解析接口</button>
					</div>
					<div class="col-lg-4">
						<div class="text-lg-right">
							<form action="" method="post">
								<div class="input-group">
									<input type="text" class="form-control" name="so" placeholder="搜索" value='<?php echo $so; ?>'>
									<span class="mdi mdi-magnify"></span>
									<div class="input-group-append">
										<button class="btn btn-primary" type="submit">搜索</button>
									</div>
								</div>
							</form>
						</div>
					</div><!-- end col-->
				</div>
				<form action="" method="post" name="form_log" id="form_log">
					<div class="table-responsive">
						<table class="table table-centered table-striped dt-responsive nowrap w-100">
							<thead>
								<tr>
									<th style="width: 20px;">
										<div class="custom-control custom-checkbox">
											<input type="checkbox" class="custom-control-input" id="all" onclick="checkAll();">
											<label class="custom-control-label" for="all">&nbsp;</label>
										</div>
									</th>
									<th style="width: 100px;">
										<center><span class="badge badge-light-lighten">解析名</span></center>
									</th>
									<th><span class="badge badge-light-lighten">配置内容</span></th>
									<th style="width: 150px;">
										<center><span class="badge badge-light-lighten">是否加密</span></center>
									</th>
									<th style="width: 150px;">
										<center><span class="badge badge-light-lighten">状态</span></center>
									</th>
									<th style="width: 150px;">
										<center><span class="badge badge-light-lighten">应用名称</span></center>
									</th>
									<th style="width: 75px;">
										<center><span class="badge badge-light-lighten">编辑</span></center>
									</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$app = Db::table('app_exten', 'as K')->field('K.*,A.name as appname')->JOIN('app', 'as A', 'K.appid=A.id');
								if ($so) {
									$app = $app->where('K.name', 'like', "%{$so}%")->whereOr('K.data', 'like', "%{$so}%")->order('id desc');
								} else {
									$app = $app->order('id desc')->limit($bnums, $ENUMS);
								}
								$res = $app->select(); //false
								//die($res);
								foreach ($res as $k => $v) {
									$rows = $res[$k];
								?>
									<tr>
										<td>
											<div class="custom-control custom-checkbox">
												<input type="checkbox" class="custom-control-input" name="ids[]" value="<?php echo $rows['id']; ?>" id="<?php echo 'check_' . $rows['id']; ?>">
												<label class="custom-control-label" for="<?php echo 'check_' . $rows['id']; ?>"></label>
											</div>
										</td>
										<td>
											<center><?php echo $rows['name']; ?></center>
										</td>
										<td>
											<?php echo mb_substr($rows['data'], 0, 50, 'utf-8') . "..." ?>
										</td>
										<td>
											<center><?php if ($rows['statejm'] == 'n') : ?><span class="badge badge-danger">关闭<?php else : ?><span class="badge badge-success">开启<?php endif; ?></span></center>
										</td>
										<td>
											<center><?php if ($rows['state'] == 'n') : ?><span class="badge badge-danger">关闭<?php else : ?><span class="badge badge-success">开启<?php endif; ?></span></center>
										</td>
										<td>
											<center>
												<?php if (empty($rows['appname'])) : ?><span class="badge badge-danger"><i class="mdi mdi-close-circle"></i> 应用不存在
													<?php else : ?><span class="badge badge-primary"><i class="mdi mdi-cube-outline"></i> <?php echo $rows['appname']; ?>
														<?php endif; ?>
														</span></center>
										</td>
										<td>
											<center><a href="javascript:void(0);" onclick="modal_cut('edit',<?php echo $rows['id']; ?>,'<?php echo $rows['api']; ?>','<?php echo $rows['name']; ?>','<?php echo $rows['data']; ?>',<?php echo $rows['appid']; ?>,'<?php echo $rows['state']; ?>','<?php echo $rows['statejm']; ?>','<?php echo $rows['type']; ?>')" class="action-icon"> <i class="mdi mdi-border-color" data-toggle="modal" data-target="#modal"></i></a></center>
										</td>
										
									</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
					<div class="progress-w-percent-s"></div>
					<div class="form-row">
						<div class="form-group col-md-6 mt-2">
							<div class="col-sm-4">
								<div class="list_footer">
									选中项：<a href="javascript:void(0);" onclick="delsubmit()" id="delsubmit">删除</a>
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<nav aria-label="Page navigation example">
								<ul class="pagination justify-content-end">
									<?php if (!$so) {
										echo pagination($nums, $ENUMS, $page, $url);
									} ?>
								</ul>
							</nav>
						</div>
					</div>
				</form>
			</div> <!-- end card-body-->
		</div> <!-- end card-->
	</div> <!-- end col -->
</div>
<!-- end row -->

<div id="modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="modal_title">添加解析接口配置</h4>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			</div>
			<div class="modal-body">
				<?php if ($app_num > 0) : ?>
					<form class="pl-6 pr-6" method="post">
						<input class="form-control" type="number" id="exten_id" name="exten_id" value="" placeholder="配置ID" hidden>

						<div class="form-row">
							<div class="form-group col-md-4">
								<label>接口类型</label>
								<select class="form-control" name="exten_type" id="exten_type">
									<option value="0">XML</option>
									<option value="1">JSON</option>
									<option value="2">多JSON</option>
									<option value="3">聚合接口</option>
								</select>
							</div>
							<div class="form-group col-md-4">
								<label>接口名称</label>
								<input type="text" id="exten_name" name="exten_name" class="form-control" placeholder="解析名称" value="" required>
							</div>
						</div>

						<div class="form-group">
							<label class="col-form-label">解析接口【多个用英文(,)隔开】</label>
							<input class="form-control" type="text" id="exten_api" name="exten_api" placeholder="第三方接口" required>
						</div>

						<div class="form-group">
							<label>适配播放源【要应用的flag，多个用英文(,)隔开】</label>
							<textarea id="exten_data" name="exten_data" class="form-control" maxlength="255" rows="3" placeholder="如：youku,优酷,mgtv"><?php echo $res['exten_data']; ?></textarea>
						</div>

						<div class="form-group">
							<label>绑定应用</label>
							<select class="form-control" name="exten_appid" id="exten_appid">
								<?php
								$res = Db::table('app')->order('id desc')->select();
								foreach ($res as $k => $v) {
									$rows = $res[$k];
								?>
									<option value="<?php echo $rows['id']; ?>"><?php echo $rows['name']; ?></option>
								<?php } ?>
							</select>
						</div>

						<div class="eruyi-checkbox">
							<label class="eruyi-label">状态</label>&nbsp;&nbsp;
							<input type="checkbox" id="state" <?php if ($rows['state'] == 'y') : ?>checked<?php endif; ?> data-switch="success" onchange="" />
							<label for="state" data-on-label="开启" data-off-label="关闭"></label>
						</div>

						<div class="eruyi-checkbox">
							<label class="eruyi-label">是否加密</label>&nbsp;&nbsp;
							<input type="checkbox" id="statejm" <?php if ($rows['statejm'] == 'y') : ?>checked<?php endif; ?> data-switch="success" onchange="" />
							<label for="statejm" data-on-label="开启" data-off-label="关闭"></label>
						</div>

						<div id="add" class="form-group text-center">
							<button class="btn btn-primary" type="submit" name="add_submit" id="add_submit" value="确定">确认添加</button>
						</div>
						<div id="edit" class="form-group text-center" hidden>
							<button class="btn btn-primary" type="submit" name="edit_submit" id="edit_submit" value="确定">确认编辑</button>
						</div>
					</form>
				<?php else : ?>
					<div class="text-center" style="margin-top:4rem!important;margin-bottom:6rem!important">
						<img src="../assets/images/no-app.svg" height="120" alt="File not found Image">
						<h4 class="text-uppercase mt-3 mb-3">需要添加应用后开启该功能</h4>
						<a href="./?app_adm"><button type="button" class="btn btn-dark">添加应用</button></a>
					</div>
				<?php endif; ?>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script>
	$('#add_submit').click(function() {
		var state = document.getElementById("state").checked;
		if (state) {
			state = 'y';
		} else {
			state = 'n';
		}
		var statejm = document.getElementById("statejm").checked;
		if (statejm) {
			statejm = 'y';
		} else {
			statejm = 'n';
		}
		let t = window.jQuery;
		var exten_api = $("input[name='exten_api']").val();
		var exten_type = $("select[name='exten_type']").val();
		var exten_name = $("input[name='exten_name']").val();
		var exten_data = $("textarea[name='exten_data']").val();
		var exten_appid = $("select[name='exten_appid']").val();
		document.getElementById('add_submit').innerHTML = "<span class=\"spinner-border spinner-border-sm mr-1\" role=\"status\" aria-hidden=\"true\"></span>正在添加";
		document.getElementById('add_submit').disabled = true;
		$.ajax({
			cache: false,
			type: "POST", //请求的方式
			url: "ajax.php?act=app_exten_add", //请求的文件名
			data: {
				api: exten_api,
				name: exten_name,
				data: exten_data,
				appid: exten_appid,
				state: state,
				statejm: statejm,
				type: exten_type
			},
			dataType: 'json',
			success: function(data) {
				console.log(data);
				document.getElementById('add_submit').disabled = false;
				document.getElementById('add_submit').innerHTML = "确认添加";
				if (data.code == 200) {
					t.NotificationApp.send("成功", data.msg, "top-center", "rgba(0,0,0,0.2)", "success")
					window.setTimeout("window.location='" + window.location.href + "'", 1000);
				} else {
					t.NotificationApp.send("失败", data.msg, "top-center", "rgba(0,0,0,0.2)", "error")
				}
			}
		});
		return false; //重要语句：如果是像a链接那种有href属性注册的点击事件，可以阻止它跳转。
	});

	$('#edit_submit').click(function() {
		var state = document.getElementById("state").checked;
		if (state) {
			state = 'y';
		} else {
			state = 'n';
		}
		var statejm = document.getElementById("statejm").checked;
		if (statejm) {
			statejm = 'y';
		} else {
			statejm = 'n';
		}
		let t = window.jQuery;
		var exten_id = $("input[name='exten_id']").val();
		var exten_api = $("input[name='exten_api']").val();
		var exten_type = $("select[name='exten_type']").val();
		var exten_name = $("input[name='exten_name']").val();
		var exten_data = $("textarea[name='exten_data']").val();
		var exten_appid = $("select[name='exten_appid']").val();
		document.getElementById('edit_submit').innerHTML = "<span class=\"spinner-border spinner-border-sm mr-1\" role=\"status\" aria-hidden=\"true\"></span>正在编辑";
		document.getElementById('edit_submit').disabled = true;

		$.ajax({
			cache: false,
			type: "POST", //请求的方式
			url: "ajax.php?act=app_exten_edit", //请求的文件名
			data: {
				id: exten_id,
				api: exten_api,
				name: exten_name,
				data: exten_data,
				appid: exten_appid,
				state: state,
				statejm: statejm,
				type: exten_type
			},
			dataType: 'json',
			success: function(data) {
				console.log(data);
				document.getElementById('edit_submit').disabled = false;
				document.getElementById('edit_submit').innerHTML = "确认编辑";
				if (data.code == 200) {
					t.NotificationApp.send("成功", data.msg, "top-center", "rgba(0,0,0,0.2)", "success")
					window.setTimeout("window.location='" + window.location.href + "'", 1000);
				} else {
					t.NotificationApp.send("失败", data.msg, "top-center", "rgba(0,0,0,0.2)", "error")
				}
			}
		});
		return false; //重要语句：如果是像a链接那种有href属性注册的点击事件，可以阻止它跳转。
	});

	function modal_cut(type, id, api, name, data, appid, state,statejm, apitype) {
		if (type == 'add') {
			document.getElementById("modal_title").innerHTML = "添加解析接口配置";
			document.getElementById("add").removeAttribute("hidden");
			document.getElementById("edit").setAttribute("hidden", true);
			document.getElementById("exten_id").value = '';
			document.getElementById("exten_api").value = '';
			document.getElementById("exten_name").value = '';
			document.getElementById("exten_data").value = '';
			document.getElementById("state").value = '';
			document.getElementById("statejm").value = '';
			document.getElementById("exten_type")[apitype].selected = true;
		} else {
			document.getElementById("modal_title").innerHTML = "编辑解析接口配置";
			document.getElementById("edit").removeAttribute("hidden");
			document.getElementById("add").setAttribute("hidden", true);
			document.getElementById("exten_id").value = id;
			document.getElementById("exten_api").value = api;
			document.getElementById("exten_name").value = name;
			document.getElementById("exten_data").value = data;
			document.getElementById("exten_appid").value = appid;
			if (state == 'y') {
				document.getElementById("state").checked = true;
			} else {
				document.getElementById("state").checked = false;
			}
			if (statejm == 'y') {
				document.getElementById("statejm").checked = true;
			} else {
				document.getElementById("statejm").checked = false;
			}
			document.getElementById("exten_type")[apitype].selected = true;
		}
	}

	function checkAll() {
		var code_Values = document.getElementsByTagName("input");
		var all = document.getElementById("all");
		if (code_Values.length) {
			for (i = 0; i < code_Values.length; i++) {
				if (code_Values[i].type == "checkbox") {
					code_Values[i].checked = all.checked;
				}
			}
		} else {
			if (code_Values.type == "checkbox") {
				code_Values.checked = all.checked;
			}
		}
	}

	function delsubmit() {
		var id_array = new Array();
		$("input[name='ids[]']:checked").each(function() {
			id_array.push($(this).val()); //向数组中添加元素 
		}); //获取界面复选框的所有值
		//ar chapterstr = id_array.join(',');//把复选框的值以数组形式存放
		var url = window.location.href;
		let t = window.jQuery;
		if (id_array.length <= 0) {
			t.NotificationApp.send("提示", "请选择要删除的项目", "top-center", "rgba(0,0,0,0.2)", "warning")
			return false;
		}
		document.getElementById("delsubmit").innerHTML = "<div class=\"spinner-border spinner-border-sm mr-1\" style=\"margin-bottom:2px!important\" role=\"status\"></div>删除中";
		document.getElementById("delsubmit").className = "text-title";
		$("#delsubmit").attr("disabled", true).css("pointer-events", "none");

		console.log(id_array);
		$.ajax({
			cache: false,
			type: "POST", //请求的方式
			url: "ajax.php?act=app_exten_del", //请求的文件名
			data: {
				id: id_array
			},
			dataType: 'json',
			success: function(data) {
				if (data.code == 200) {
					t.NotificationApp.send("成功", data.msg, "top-center", "rgba(0,0,0,0.2)", "success")
				} else {
					t.NotificationApp.send("失败", data.msg, "top-center", "rgba(0,0,0,0.2)", "error")
				}
				//console.log(data);
				window.setTimeout("window.location='" + url + "'", 1000);
			}
		});
		return false; //重要语句：如果是像a链接那种有href属性注册的点击事件，可以阻止它跳转。
	}
</script>