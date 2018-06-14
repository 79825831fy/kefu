<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
	<title>客服管理</title>
</head>
<style type="text/css">

.kefu{
	width: 80%;
	margin: 0 auto;
}
.kefuList{
	width: 100%;
	border:1px solid #666;
}
tr,td{
	height: 35px;
	line-height: 30px;
	border: 1px solid red;
}
</style>
<body>
	<div class="kefu">
		<table class="kefuList">
			<tr>
				<td>账号</td>
				<td>昵称</td>
				<td>账号id</td>
				<td>账号头像</td>
				<td>操作</td>
			</tr>
			<?php if(empty($kefuList)): ?><tr>
					<td colspan="5" align="center">没有信息</td>
				</tr>
			<?php else: ?>
				<?php if(is_array($kefuList)): $i = 0; $__LIST__ = $kefuList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$kefu): $mod = ($i % 2 );++$i;?><tr>
						<td><?php echo ($kefu["kf_account"]); ?></td>
						<td><?php echo ($kefu["kf_nick"]); ?></td>
						<td><?php echo ($kefu["kf_id"]); ?></td>
						<td><image src="<?php echo ($kefu["kf_headimgurl"]); ?>" style="width:100px;height:100px;"/></td>
						<td>修改|删除</td>
					</tr><?php endforeach; endif; else: echo "" ;endif; endif; ?>
		</table>
	</div>
	
</body>
</html>