<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/webdev/kea-kb/router.php');

// ##############################
get('/webdev/kea-kb', '/webdev/kea-kb/views/view_admin.php');

get('/webdev/kea-kb/activate/$user_uuid', '/webdev/kea-kb/views/view_activate.php');

get('/webdev/kea-kb/admin', '/webdev/kea-kb/views/view_admin.php');

get('/webdev/kea-kb/login', '/webdev/kea-kb/views/view_login.php');

get('/webdev/kea-kb/logout', '/webdev/kea-kb/bridges/bridge_logout.php');

get('/webdev/kea-kb/profile', '/webdev/kea-kb/views/view_profile.php');

get('/webdev/kea-kb/projects/$project_id', '/webdev/kea-kb/views/view_project.php');

get('/webdev/kea-kb/signup', '/webdev/kea-kb/views/view_signup.php');

get('/webdev/kea-kb/users', '/webdev/kea-kb/views/view_users.php');

get('/webdev/kea-kb/welcome', '/webdev/kea-kb/views/view_new_user.php');

get('/webdev/kea-kb/get-password', '/webdev/kea-kb/views/view_forgot.php');

get('/webdev/kea-kb/pass-reset/$user_uuid', '/webdev/kea-kb/views/view_reset_pass.php');

get('/webdev/kea-kb/sending-email/$user_uuid', '/webdev/kea-kb/bridges/bridge_delete_email.php');

get('/webdev/kea-kb/test', '/webdev/kea-kb/test.php');

get('/webdev/kea-kb/post', '/webdev/kea-kb/views/view_create_post.php');

get('/webdev/kea-kb/post/$post_id', '/webdev/kea-kb/views/view_posts_single.php');

get('/webdev/kea-kb/feed', '/webdev/kea-kb/views/view_posts_feed.php');



// ##############################¨
post('/webdev/kea-kb/admin', '/webdev/kea-kb/bridges/bridge_create_project.php');

post('/webdev/kea-kb/deactivate', '/webdev/kea-kb/bridges/bridge_deactivate.php');

post('/webdev/kea-kb/create-users-table', '/webdev/kea-kb/db/db_create_table_users.php');
post('/webdev/kea-kb/create-comments-table', '/webdev/kea-kb/db/db_create_table_comments.php');
post('/webdev/kea-kb/create-posts-table', '/webdev/kea-kb/db/db_create_table_posts.php');

post('/webdev/kea-kb/login', '/webdev/kea-kb/bridges/bridge_login.php');

post('/webdev/kea-kb/profile', '/webdev/kea-kb/bridges/bridge_update_profile.php');

post('/webdev/kea-kb/profile-pic', '/webdev/kea-kb/bridges/bridge_update_profile_pic.php');

post('/webdev/kea-kb/projects/$project_id', '/webdev/kea-kb/bridges/bridge_add_task.php');

post('/webdev/kea-kb/send-password', '/webdev/kea-kb/bridges/bridge_send_password.php');

post('/webdev/kea-kb/signup', '/webdev/kea-kb/bridges/bridge_signup.php');

post('/webdev/kea-kb/tasks/delete/$task_id', '/webdev/kea-kb/apis/api_delete_task.php');

post('/webdev/kea-kb/tasks/update/$task_id/$status', '/webdev/kea-kb/apis/api_update_task.php');

post('/webdev/kea-kb/update-password', '/webdev/kea-kb/bridges/bridge_update_password.php');

post('/webdev/kea-kb/users/delete/$user_id', '/webdev/kea-kb/apis/api_delete_user.php');

post('/webdev/kea-kb/post', '/webdev/kea-kb/bridges/bridge_create_post.php');

//leave comment from main feed page or from /post/number individual post
post('/webdev/kea-kb/comment', '/webdev/kea-kb/bridges/bridge_create_comment.php');
post('/webdev/kea-kb/post/comment', '/webdev/kea-kb/bridges/bridge_create_comment.php');


// ##############################¨
any('/webdev/kea-kb/404', '/webdev/kea-kb/views/view_404.php');
