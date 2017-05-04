<?php
	include_once 'app/cls-projects.php';

	$prj_obj = new Projects();
	$prj_obj->scanCategory();

		$prj_id = 0;
	if (isset($_GET['id'])) {
		$prj_id = $_GET['id'];
	}
	$prj_details = $prj_obj->getProjects('details', $prj_id);
		
	$category = '';
	$proj_name = '';
?>
	<!--div class="row"-->
		<div class="col-sm-12">
			<h3><i class="fa fa-list-alt"></i> Project Details</h3>
			<div class="well">
			<?php
				foreach ($prj_details as $prj_detail) {
					$category = $prj_detail['cat_title'];
					$proj_name = $prj_detail['title'];
			?>			
				<table class="table">
					<thead class="">
						<th class="col-sm-2">Project:</th>
						<th class="col-sm-10">
							<?php echo $prj_detail['title'].($prj_detail['incomplete']?' &nbsp;&nbsp;<i class="fa fa-exclamation-circle return-of-d-blink text-warning"></i>':''); ?>
						</th>
					</thead>
					<tbody>
					<tr >
						<td class="col-sm-2">Description:</td>
						<td class="col-sm-10">
							<?php echo $prj_detail['desc']; ?>
						</td>
					</tr>
					<tr>
						<td class="col-sm-2">Category:</td>
						<td class="col-sm-4">
							<?php echo $prj_detail['cat_title']; ?>
						</td>
					</tr>
					<tr>
						<td class="col-sm-2">Status:</td>
						<td class="col-sm-4">
							<?php echo $prj_detail['status']; ?>
						</td>
					</tr>
					<tr >
						<td class="col-sm-2">Owner:</td>
						<td class="col-sm-10">
							<?php echo $prj_detail['owner']; ?>
						</td>
					</tr>
					<tr >
						<td class="col-sm-2">Version:</td>
						<td class="col-sm-10">
							<?php echo $prj_detail['version']; ?>
						</td>
					</tr>
					<tr >
						<td class="col-sm-2">Date Started:</td>
						<td class="col-sm-10">
							<?php echo $prj_detail['sdate']; ?>
						</td>
					</tr>
					<tr >
						<td class="col-sm-2">Date Completed:</td>
						<td class="col-sm-10">
							<?php echo $prj_detail['cdate']; ?>
						</td>
					</tr>
					<tr >
						<td class="col-sm-2">Date Created:</td>
						<td class="col-sm-10">
							<?php echo $prj_detail['created']; ?>
						</td>
					</tr>
					<tr >
						<td class="col-sm-2">Last updated:</td>
						<td class="col-sm-10">
							<?php echo $prj_detail['updated']; ?>
						</td>
					</tr>
					<tr>
						<td class="col-sm-2">Files & Sub-folders:</td>
						<td class="col-sm-10">
							<?php
								$prj_subs = $prj_obj->scanProjectDir($category, $proj_name);
								echo '<ul class="out-of-bullets">';
								foreach ($prj_subs as $prj_sub) {
									echo '<li>
											<a href="../../'.$category.'/'.$proj_name	.'/'.$prj_sub['files'].'" class="btn btn-primary btn-xs" target="_blank" style="margin-bottom:5px; margin-right:5px">
												<i class="fa fa-external-link"></i>
											</a>
											'.$prj_sub['files'].'
										  </li>';
								}
								echo '</ul>';
							?>
						</td>
					</tr>
				</tbody>
			<?php
				}
			?>
				</table>
			</div>
			<!--span class="help-block text-center">
				<i class="fa fa-exclamation-circle gps_ring text-warning"></i> - Indicates projects with incomplete details
			</span-->
		</div>
	<!--/div-->