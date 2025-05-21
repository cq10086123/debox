<?php
/*
Sort:10
icons:mdi mdi-clipboard-text-play-outline
Hidden:false
Name:添加直播(暂不可用)
Url:app_zb
Version:1.0
Author:易如意
Author QQ:51154393
Author Url:www.eruyi.cn
*/
if (!isset($islogin)) header("Location: /"); //非法访问
$nums = Db::table('app_zb')->count();
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$url = "./?app_zb&page=";
$bnums = ($page - 1) * $ENUMS;

?>

<!-- start page title -->
<div class="row">
	<div class="col-12">
		<div class="page-title-box">
			<div class="page-title-right">
				<ol class="breadcrumb m-0">
					<li class="breadcrumb-item"><a href="javascript: void(0);">首页</a></li>
					<li class="breadcrumb-item active">直播仓库(暂不可用)</li>
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
						<button type="button" onclick="modal_cut('add',0,0,0,0)" class="btn btn-danger mb-2 mr-2" data-toggle="modal" data-target="#modal"><i class="mdi mdi-briefcase-plus-outline mr-1"></i>添加</button>
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
									<th style="width: 20px;">
										<center><span class="badge badge-light-lighten">ID</span></center>
									</th>
									<th><span class="badge badge-light-lighten">名称</span></th>
									<th>
										<center><span class="badge badge-light-lighten">链接</span></center>
									</th>
									<th style="width: 150px;">
										<center><span class="badge badge-light-lighten">状态</span></center>
									</th>
									<th style="width: 150px;">
										<center><span class="badge badge-light-lighten">是否加密</span></center>
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
									$app = Db::table('app_zb', 'as K')->field('K.*,A.name as appname')->JOIN('app', 'as A', 'K.appid=A.id');
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
											<center><?php echo $rows['id']; ?></center>
										</td>
										<td>
											<?php echo $rows['name']; ?>
										</td>
										<td>
											<center><span class="badge badge-info-lighten"><?php echo mb_substr($rows['url'], 0, 50, 'utf-8') . "..."; ?></span></center>
										</td>
										<td>
											<center><?php if ($rows['status'] == 'n') : ?><span class="badge badge-danger">停用<?php else : ?><span class="badge badge-success">启动<?php endif; ?></span></center>
										</td>
										<td>
											<center><?php if ($rows['status_zbjm'] == 'n') : ?><span class="badge badge-danger">停用<?php else : ?><span class="badge badge-success">启动<?php endif; ?></span></center>
										</td>
										<td>
											<center>
												<?php if (empty($rows['appname'])) : ?><span class="badge badge-danger"><i class="mdi mdi-close-circle"></i> 应用不存在
													<?php else : ?><span class="badge badge-primary"><i class="mdi mdi-cube-outline"></i> <?php echo $rows['appname']; ?>
														<?php endif; ?>
														</span></center>
										</td>
										
										<td>
											<center><a href="javascript:void(0);" onclick="modal_cut('edit',<?php echo $rows['id']; ?>,'<?php echo $rows['url']; ?>','<?php echo $rows['name']; ?>','<?php echo $rows['status']; ?>','<?php echo $rows['status_zbjm']; ?>','<?php echo $rows['appid']; ?>')" class="action-icon"> <i class="mdi mdi-border-color" data-toggle="modal" data-target="#modal"></i></a></center>
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
				<h4 class="modal-title" id="modal_title">添加</h4>
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			</div>
			<div class="modal-body">
					<form class="pl-6 pr-6" method="post">
						<input class="form-control" type="number" id="zb_id" name="zb_id" value="" placeholder="配置ID" hidden>

						<div class="form-group">
							<label class="col-form-label">名称</label>
							<input class="form-control" type="text" id="zb_name" name="zb_name" placeholder="直播上显示和搜索的名称" required>
						</div>
						<div class="form-group">
							<label>链接</label>
							<input class="form-control" type="text" id="zb_url" name="zb_url" placeholder="链接" required>
						</div>

						
						<div class="form-group">
							<label>绑定应用</label>
							<select class="form-control" name="zb_appid" id="zb_appid">
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
							<input type="checkbox" id="status" <?php if ($rows['status'] == 'y') : ?>checked<?php endif; ?> data-switch="success" onchange="" />
							<label for="status" data-on-label="开启" data-off-label="关闭"></label>
						</div>
						<div class="eruyi-checkbox">
							<label class="eruyi-label">是否加密</label>&nbsp;&nbsp;
							<input type="checkbox" id="status_zbjm" <?php if ($rows['status_zbjm'] == 'y') : ?>checked<?php endif; ?> data-switch="success" onchange="" />
							<label for="status_zbjm" data-on-label="开启" data-off-label="关闭"></label>
						</div>
						<div id="add" class="form-group text-center">
							<button class="btn btn-primary" type="submit" name="add_submit" id="add_submit" value="确定">确认添加</button>
						</div>
						<div id="edit" class="form-group text-center" hidden>
							<button class="btn btn-primary" type="submit" name="edit_submit" id="edit_submit" value="确定">确认编辑</button>
						</div>
					</form>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script>
	$('#add_submit').click(function() {
		var status = document.getElementById("status").checked;
		if (status) {
			status = 'y';
		} else {
			status = 'n';
		}
		var status_zbjm = document.getElementById("status_zbjm").checked;
		if (status_zbjm) {
			status_zbjm = 'y';
		} else {
			status_zbjm = 'n';
		}
		let t = window.jQuery;
		var zb_url = $("input[name='zb_url']").val();
		var zb_name = $("input[name='zb_name']").val();
		var zb_appid = $("select[name='zb_appid']").val();
		document.getElementById('add_submit').innerHTML = "<span class=\"spinner-border spinner-border-sm mr-1\" role=\"status\" aria-hidden=\"true\"></span>正在添加";
		document.getElementById('add_submit').disabled = true;
		$.ajax({
			cache: false,
			type: "POST", //请求的方式
			url: "ajax.php?act=app_zb_add", //请求的文件名
			data: {
				url: zb_url,
				name: zb_name,
				status: status,
				status_zbjm: status_zbjm,
				appid:zb_appid
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
		var status = document.getElementById("status").checked;
		if (status) {
			status = 'y';
		} else {
			status = 'n';
		}
		var status_zbjm = document.getElementById("status_zbjm").checked;
		if (status_zbjm) {
			status_zbjm = 'y';
		} else {
			status_zbjm = 'n';
		}
		let t = window.jQuery;
		var zb_id = $("input[name='zb_id']").val();
		var zb_url = $("input[name='zb_url']").val();
		var zb_name = $("input[name='zb_name']").val();
		var zb_appid = $("select[name='zb_appid']").val();
		document.getElementById('edit_submit').innerHTML = "<span class=\"spinner-border spinner-border-sm mr-1\" role=\"status\" aria-hidden=\"true\"></span>正在编辑";
		document.getElementById('edit_submit').disabled = true;

		$.ajax({
			cache: false,
			type: "POST", //请求的方式
			url: "ajax.php?act=app_zb_edit", //请求的文件名
			data: {
				id: zb_id,
				url: zb_url,
				name: zb_name,
				status: status,
				status_zbjm: status_zbjm,
				appid: zb_appid
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

	function modal_cut(type,id, url, name, status, status_zbjm,appid) {
		if (type == 'add') {
			document.getElementById("modal_title").innerHTML = "添加";
			document.getElementById("add").removeAttribute("hidden");
			document.getElementById("edit").setAttribute("hidden", true);
			document.getElementById("zb_id").value = '';
			document.getElementById("zb_url").value = '';
			document.getElementById("zb_name").value = '';
			document.getElementById("status").value = '';
			document.getElementById("status_zbjm").value = '';
			// document.getElementById("dc_appid").value = '';
		} else {
			document.getElementById("modal_title").innerHTML = "编辑";
			document.getElementById("edit").removeAttribute("hidden");
			document.getElementById("add").setAttribute("hidden", true);
			document.getElementById("zb_id").value = id;
			document.getElementById("zb_url").value = url;
			document.getElementById("zb_name").value = name;
			document.getElementById("zb_appid").value = appid;
			if (status == 'y') {
				document.getElementById("status").checked = true;
			} else {
				document.getElementById("status").checked = false;
			}
			if (status_zbjm == 'y') {
				document.getElementById("status_zbjm").checked = true;
			} else {
				document.getElementById("status_zbjm").checked = false;
			}
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
			url: "ajax.php?act=app_zb_del", //请求的文件名
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