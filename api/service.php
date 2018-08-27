<?php
/*
* service.php for the web api
* 
*/

require '../dao/DatabaseOperation.php';
$method = $_GET['action'];
if (isset($_GET['updated_on'])) 
{
$updated_on = $_GET['updated_on'];
}
else 
{
$updated_on = 0;
}

$json = file_get_contents('php://input');

$obj =json_decode($json);


switch ($method) 
{

case "login":
//print_r(json_encode($obj));break;
$response = checkLogin($obj->{'loginname'}, $obj->{'password'});
if ($response != null) {
$result = array("result" => "success", "user" => $response);
} 
else
 {
$result = array("result" => "failed", "msg" => "Incorrect username or password!");
}
print_r(json_encode($result));
break;


case "forgotpassword":
$data = array();


if (isset($obj->{'email'}))
{
$to = $obj->{'email'};
$subject = "Forgot Password";
$dummyPassword = generateRandomString();
$message = getForgotPasswordMessage($dummyPassword);
$headers = "From: Friend Work\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
if (isEmailExists($obj->{'email'})) 
{
$mail = mail($to, $subject, $message, $headers);
print_r(json_encode(resetPass($obj, $dummyPassword)));
}
else 
{
$data['result'] = 'failed';
$data['msg'] = 'No such user exist';
print_r(json_encode($data));
}
}
else
{
$data['result'] = 'failed';
$data['msg'] = 'Invalid data';
print_r(json_encode($data));
}
break;


case "changepassword":
$data = array();
if (isset($obj->{'new_password'}) && isset($obj->{'user_id'})) 
{
print_r(json_encode(changePass($obj)));
}
else
{
$data['result'] = 'failed';
$data['msg'] = 'Invalid data';
print_r(json_encode($data));
}
break;


case "signup":

$data = array();

// $data2 = json_decode($_REQUEST['user_data']);
$data2 = json_decode($_REQUEST['user_data']); 

if(isset($data2->{'user_id'}))
{
$user_id = addUser($data2);
$response = uploadIDs($_FILES['id_front'], $_FILES['id_back'], $user_id);
$data['result'] = 'success';
$data['msg'] = 'Registered Successfully!';
print_r(json_encode($data));
}
else if (isEmailExists($data2->{'loginname'}) == true) 
{
$data['result'] = 'failed';
$data['msg'] = 'Login name must be unique!';
print_r(json_encode($data));
} 
else 
{
$user_id = addUser($data2);
if ($user_id > 0) 
{
$response = uploadIDs($_FILES['id_front'], $_FILES['id_back'], $user_id);
$data['result'] = 'success';
$data['msg'] = 'Registered Successfully!';
print_r(json_encode($data));
} else
{
$data['result'] = 'failed';
$data['msg'] = 'Failed to process';
print_r(json_encode($data));
}
}
break;

case "updateprofile":
$data = array();
$data2 = json_decode($_REQUEST['user_data']);
$response = updateUser($_FILES['profile_image'], $data2);
if ($response > 0) {
$data['result'] = 'success';
$data['profile_image'] = '/uploads/ProfileImages/' . $data2->{'user_id'} . '/profile_image.png';
$data['msg'] = 'Profile updated successfully!';
} else {
$data['result'] = 'failed';
$data['msg'] = 'Some error occured, Please try later!';
}
print_r(json_encode($data));
break;

case "allcategories":
print_r(json_encode(getAllCategories()));
break;


case "postjob":
$data = array();
$data2 = json_decode($_REQUEST['job_data']);
$job_id = insertJob($data2);
if ($job_id > 0) {
$response = uploadJobImages($_FILES['image1'], $_FILES['image2'], $_FILES['image3'], $job_id);
$data['result'] = 'success';
$data['msg'] = 'Job posted successfully!';
print_r(json_encode($data));
} 
else
{
$data['result'] = 'failed';
$data['msg'] = 'Some error occured!';
print_r(json_encode($data));
}
break;

case "findjobs":
$data = array();
if (isset($obj->{'category_id'}) && isset($obj->{'category_name'})) 
{
print_r(json_encode(findJobs($obj)));
} 
else 
{
$data['result'] = 'failed';
$data['msg'] = 'Invalid data';
print_r(json_encode($data));
}
break;

case "postmessage":
$data = array();
if (isset($obj->{'message'})) 
{
$message_id = insertMessage($obj);
if ($message_id > 0) 
{
$data['result'] = 'success';
$data['msg'] = 'Message posted successfully!';
print_r(json_encode($data));
} 
else 
{
$data['result'] = 'failed';
$data['msg'] = 'Some error occured!';
print_r(json_encode($data));
}
}
else 
{
$data['result'] = 'failed';
$data['msg'] = 'Invalid data';
print_r(json_encode($data));
}
break;

case "findmessages":
$data = array();
if (isset($obj->{'user_id'})) 
{
print_r(json_encode(findMessages($obj)));
} 
else 
{
$data['result'] = 'failed';
$data['msg'] = 'Invalid data';
print_r(json_encode($data));
}
break;

case "updatereadstatus":
$data = array();
if (isset($obj->{'message_id'})) 
{
print_r(json_encode(updateReadStatus($obj)));
} 
else 
{
$data['result'] = 'failed';
$data['msg'] = 'Invalid data';
print_r(json_encode($data));
}
break;

case "totalnewmessages":
$data = array();
if (isset($obj->{'user_id'})) 
{
print_r(json_encode(getNewMessages($obj)));
}
else
{
$data['result'] = 'failed';
$data['msg'] = 'Invalid data';
print_r(json_encode($data));
}
break;

case "getprojects":
$data = array();
if (isset($obj->{'user_id'})) 
{
print_r(json_encode(getAllProjects($obj)));
} else
{
$data['result'] = 'failed';
$data['msg'] = 'Invalid data';
print_r(json_encode($data));
}
break;


case "updatejobstatus":
$data = array();
if (isset($obj->{'job_id'}))
{
print_r(json_encode(updateJobStatus($obj)));
} 
else 
{
$data['result'] = 'failed';
$data['msg'] = 'Invalid data';
print_r(json_encode($data));
}
break;

case "getuser":
$data = array();
if (isset($obj->{'user_id'}))
{
print_r(json_encode(getUser($obj)));
} 
else 
{
$data['result'] = 'failed';
$data['msg'] = 'Invalid data';
print_r(json_encode($data));
}
break;

case "register" :
$data = array();
if (isEmailUnique($obj->{'email_id'}) && checkUniqueNumber($obj->{'contact_number'})) 
{
$data['result'] = 'success';
$data['msg'] = 'registered';
}
else
{
$data['result'] = 'failed';
$data['msg'] = 'Email Id Or Phone Number already registered!';
}
print_r(json_encode($data));
break;

case "itemImages":
$itemId = $_GET['item_id'];
print_r(json_encode(getImages($itemId)));
break;

case "categories":
print_r(json_encode(categories()));
break;

case "posts":
$page = $_GET['page'];
$user_id = null;
$searchStr = "";
if (isset($_GET['search']))
{
$searchStr = $_GET['search'];
}
if (isset($_GET['user_id']))
{
$user_id = $_GET['user_id'];
}
if (isset($_GET['page']))
{
$data['result'] = 'success';
$data['data'] = posts($page, $searchStr, $user_id);
print_r(json_encode($data));
}
else
{
$data['result'] = 'failed';
$data['msg'] = 'Invalid data';
print_r(json_encode($data));
}
break;
case "deletePost":
if (isset($obj->{'post_id'})) 
{
print_r(json_encode(deletePost($obj->{'post_id'})));
}
else
{
$data['result'] = 'failed';
$data['msg'] = 'Invalid data';
print_r(json_encode($data));
}
break;

case "deleteChat":
if (isset($obj->{'post_id'})) 
{
if (!checkPost($obj))
{
print_r(json_encode(deleteChat($obj)));
}
else 
{
$data['result'] = 'failed';
$data['msg'] = 'user not auto';
print_r(json_encode($data));
}
} 
else 
{
$data['result'] = 'failed';
$data['msg'] = 'Invalid data';
print_r(json_encode($data));
}
break;

case "chatHistory":
if (isset($obj->{'from_user_id'}) && isset($obj->{'to_user_id'}) && isset($obj->{'page'})) 
{
print_r(json_encode(chatHistory($obj)));
} 
else 
{
$data['result'] = 'failed';
$data['msg'] = 'Invalid data';
print_r(json_encode($data));
}
break;

case "checkOnlineStatus":
$postData['user_id'] = $obj->{'user_id'};
$postData['flag'] = $obj->{'flag'};
if (isset($obj->{'user_id'}) && isset($obj->{'flag'})) {
print_r(json_encode(checkStatus($postData)));
}
else
{
$data['result'] = 'failed';
$data['msg'] = 'Invalid data';
print_r(json_encode($data));
}
break;

case "recentChat":
if (isset($_GET['user_id']) && isset($_GET['page'])) 
{
print_r(json_encode(recentChat($_GET['user_id'], $_GET['page'])));
} 
else
{
$data['result'] = 'failed';
$data['msg'] = 'Invalid data';
print_r(json_encode($data));
}
break;

case "chat":
if (isset($obj->{'message_from_id'}) && isset($obj->{'message_to_id'}) && isset($obj->{'message'}) && isset($obj->{'message'})) 
{
print_r(json_encode(chat($obj)));
} else {
$data['result'] = 'failed';
$data['msg'] = 'Invalid data';
print_r(json_encode($data));
}
break;

case "checkUserLogin":
$response = checkUserLogin($obj->{'contact_number'}, $obj->{'password'});
if ($response != null) 
{
updateGcm($obj->{'contact_number'}, $obj->{'gcm_id'}, $obj->{'latlong'}, $obj->{'city'});
$result = array("result" => "success", "user" => $response);
} 
else 
{
$result = array("result" => "failed", "msg" => "invalid user name or password!");
}
print_r(json_encode($result));
break;

case "verification":
$response = checkVerifaction($obj->{'user_id'}, $obj->{'verification_code'}, $obj->{'latlong'});
if ($response != null) 
{
$result = array("result" => "success", "user" => $response);
} 
else 
{
$result = array("result" => "failed", "msg" => "invalid verification code!");
}
print_r(json_encode($result));
break;



case "addpost":
$postData = array();
$data = array();
if (isset($_POST['user_id']) 
&& isset($_POST['category_id']) 
&& isset($_POST['title']) 
&& isset($_POST['desc']) 
&& count($_FILES)) 
{
$postData['user_id'] = $_POST['user_id'];
$postData['category_id'] = $_POST['category_id'];
$postData['title'] = $_POST['title'];
$postData['desc'] = $_POST['desc'];
$output = addPost($postData);
if ($output > 0)
{
$source = array();
$source['source_id'] = $output;
$source['source_code'] = 'POST';
//print_r($_FILES);
foreach ($_FILES as $key => $image)
{
fileUpload($image, $source);
}
$data['result'] = 'success';
$data['msg'] = 'Post Added Successfully!';
print_r(json_encode($data));
}
else
{
$data['result'] = 'failed';
$data['msg'] = 'Failed to process';
print_r(json_encode($data));
}
} 
else 
{
$data['result'] = 'failed';
$data['msg'] = 'Invalid data';
print_r(json_encode($data));
}
break;

case "editpost":
$postData = array();
$data = array();
//echo isset($_POST['user_id'])."  ". isset($_POST['category_id']) ."  ".  isset($_POST['title'])."  ". isset($_POST['desc']) ."  ".  count($_FILES);

if (isset($_POST['user_id']) && isset($_POST['category_id']) && isset($_POST['title']) && isset($_POST['desc'])) 
{
$postData['user_id'] = $_POST['user_id'];
$postData['category_id'] = $_POST['category_id'];
$postData['title'] = $_POST['title'];
$postData['desc'] = $_POST['desc'];
$postData['post_id'] = $_POST['post_id'];
$deletedImages = json_decode($_REQUEST['deleted_images']);

foreach ($deletedImages as $key => $image_id) 
{
fileDelete($image_id);
}

$output = editPost($postData);
if ($output > 0) 
{
$source = array();
$source['source_id'] = $output;
$source['source_code'] = 'POST';
//print_r($_FILES);
foreach ($_FILES as $key => $image) 
{
fileUpload($image, $source);
}
$data['result'] = 'success';
$data['msg'] = 'Post Updated Successfully!';
print_r(json_encode($data));
}
else
{
$data['result'] = 'failed';
$data['msg'] = 'Failed to process';
print_r(json_encode($data));
}
}
else
{
$data['result'] = 'failed';
$data['msg'] = 'Invalid data';
print_r(json_encode($data));
}
break;

default:
print_r('Service Started');
break;
}

function getForgotPasswordMessage($dummyPassword) 
{
return "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\n"
. "<html xmlns=\"http://www.w3.org/1999/xhtml\">\n"
. "<head>\n"
. "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />\n"
. "<title>Untitled Document</title>\n"
. "</head>\n"
. "<body>\n"
. "<div style=\"margin:0px auto;display:table;font-family:Arial, Helvetica, sans-serif;font-size:14px;\">\n"
. "<p><h4 style=\"margin:0px;padding:0px;text-align:left;\">  Dear User,</h4><br />\n"
. "You requested to recover your password, for account with Friend Work.<br />\n"
. "Here is provided a dummy password for login, Change it, after login.<br />\n"
. "<span style=\"color:#009;\"> Password: " . $dummyPassword . "</span><br />\n"
. "<br />\n"
. "Thanks & Regards<br />\n"
. "Friend Work</p>\n"
. "</div>\n"
. "</body>\n"
. "</html>";
}

function generateRandomString() 
{
$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ~!@#$%^&*()_+';
$charactersLength = strlen($characters);
$randomString = '';
for ($i = 0; $i < 8; $i++) 
{
$randomString .= $characters[rand(0, $charactersLength - 1)];
}
return $randomString;
}

?>