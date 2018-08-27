<?php
include ('config/config.php');

if (isset($_REQUEST['user_id']) && !empty($_REQUEST['user_id'])) {
	$user_id = $_REQUEST['user_id'];
	$qry = "SELECT * FROM registration WHERE user_id = '$user_id'";
	$resnum = mysqli_query($con, $qry);
	$res = mysqli_num_rows($resnum);
	if ($res != 0) {
		$qry = "SELECT * FROM `feeds_m` WHERE `feedowner_id`='$user_id'";
		$resnum = mysqli_query($con, $qry);
		$res1 = mysqli_num_rows($resnum);
		if ($res1 != 0) {
			$sql = "SELECT r. * , pc. * FROM feeds_m pc, registration r WHERE pc.feedowner_id = '$user_id' 
            AND pc.action_owner_id = r.user_id ORDER BY `id` DESC  ";
			$resnum = mysqli_query($con, $sql);
			$res = mysqli_num_rows($resnum);
			$r = array();
			
			while ($result_arr = mysqli_fetch_assoc($resnum)) {
				if ($result_arr) {
					array_push($r, $result_arr);
				}
			}

			$all_data = array();
			foreach($r as $c) {


				$type = $c['feed_type'];
				$posts = $c['post_id'];
				$val = 'false';
				if ($type == 'Likes Prayer') {
					$qry = "SELECT * FROM `prayer_like`  WHERE `prayer_id`='$posts' && user_id = '$user_id'";
					$resnum = mysqli_query($con, $qry);
					$res1 = mysqli_num_rows($resnum);
					if ($res1 != 0) {
						$val = 'true';
					}
				}
				else
				if ($type == 'Posted Good News') {
					$qry = "SELECT * FROM `goodnews_like`  WHERE `gnews_id`='$posts' && user_id = '$user_id'";
					$resnum = mysqli_query($con, $qry);
					$res1 = mysqli_num_rows($resnum);
					if ($res1 != 0) {
						$val = 'true';
					}
				}
				else
				if ($type == 'likes Good news') {
					$qry = "SELECT * FROM `goodnews_like`  WHERE `gnews_id`='$posts' && user_id = '$user_id'";
					$resnum = mysqli_query($con, $qry);
					$res1 = mysqli_num_rows($resnum);
					if ($res1 != 0) {
						$val = 'true';
					}
				}
				else
				if ($type == 'Prayer Comment') {
					$qry = "SELECT * FROM `prayer_like`  WHERE `prayer_id`='$posts' && user_id = '$user_id'";
					$resnum = mysqli_query($con, $qry);
					$res1 = mysqli_num_rows($resnum);
					if ($res1 != 0) {
						$val = 'true';
					}
				}
				else
				if ($type == 'Posted Prayer') {
					$qry = "SELECT * FROM `prayer_like`  WHERE `prayer_id`='$posts' && user_id = '$user_id'";
					$resnum = mysqli_query($con, $qry);
					$res1 = mysqli_num_rows($resnum);
					if ($res1 != 0) {
						$val = 'true';
					}
				}
				else
				if ($type == 'Good news Comment') {
					$qry = "SELECT * FROM `goodnews_like`  WHERE `gnews_id`='$posts' && user_id = '$user_id'";
					$resnum = mysqli_query($con, $qry);
					$res1 = mysqli_num_rows($resnum);
					if ($res1 != 0) {
						$val = 'true';
					}
				}

				$c['is_like'] = $val;
				$all_data[] = $c;
			}

			if ($res > 0) {
				$result = array(
					"response" => array(
						'code' => '201',
						'message' => "Feed found successfully",
						'data' => $all_data
					)
				);
				print_r(json_encode($result));
			}
		}
		else {
			$r1 = array();
			$result = array(
				"response" => array(
					'code' => '200',
					'message' => "There is no feeds",
					'data' => $r1
				)
			);
			print_r(json_encode($result));
		}
	}
	else {
		$r1 = array();
		$result = array(
			"response" => array(
				'code' => '200',
				'message' => "User not found"
			)
		);
		print_r(json_encode($result));
	}
}
else {
	$result = array(
		"response" => array(
			'code' => '200',
			'message' => "Data not found"
		)
	);
	print_r(json_encode($result));
}
