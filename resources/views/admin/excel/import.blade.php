<section class="content">


	<div class="box">
		<div class="box-header with-border">
			<h3 class="box-title">文件上传</h3>
			<div class="box-tools pull-right"></div>
			<!-- /.box-tools -->
		</div>
		<!-- /.box-header -->
		<div class="box-body" style="display: block;">
			<form method="post" action="/admin/exceltrade/check" class="form-horizontal"
				accept-charset="UTF-8" 
				enctype="multipart/form-data">
				<div class="box-body fields-group">

					<div class="form-group  ">

						<label for="file" class="col-sm-2 control-label">Excel文件:</label>

						<div class="col-sm-8">


							<input type="file" class="file" accept="application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" name="file" />


						</div>
					</div>


				</div>

				<!-- /.box-body -->
				<div class="box-footer">
					<div class="col-md-2"></div>

					<div class="col-md-8">
						<div class="btn-group pull-left">
							<button type="reset" class="btn btn-warning pull-right">重置</button>
						</div>
						<div class="btn-group pull-right">
							<button type="submit" class="btn btn-info pull-right">提交</button>
						</div>

					</div>

				</div>
				<input hidden="{{ csrf_token() }}" />
			</form>

		</div>
	</div>
	</div>
	</div>

</section>
<script data-exec-on-popstate>
$(function () {
                    
$("input.file").fileinput({
	"overwriteInitial":true,
	"initialPreviewAsData":true,
	"browseLabel":"\u6d4f\u89c8",
	"showRemove":false,
	"showUpload":false,
	"deleteExtraData":{"file":"_file_del_","_file_del_":"","_method":"put","_token":"{{ csrf_token() }}"}
		});
   

 });
</script>

<!-- ./wrapper -->

