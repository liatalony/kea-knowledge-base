<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/router.php');

// ##############################
get('/', '/views/view_admin.php');

get('/activate/$user_uuid', '/views/view_activate.php');

get('/admin', '/views/view_admin.php');

get('/login', '/views/view_login.php');

get('/logout', '/bridges/bridge_logout.php');

get('/profile', '/views/view_profile.php');

get('/projects/$project_id', '/views/view_project.php');

get('/signup', '/views/view_signup.php');

get('/users', '/views/view_users.php');

get('/welcome', '/views/view_new_user.php');

get('/get-password', '/views/view_forgot.php');

get('/pass-reset/$user_uuid', '/views/view_reset_pass.php');

get('/sending-email/$user_uuid', '/bridges/bridge_delete_email.php');

get('/test', '/test.php');

get('/post', '/views/view_create_post.php');

get('/post/$post_id', '/views/view_posts_single.php');

get('/feed', '/views/view_posts_feed.php');



// ##############################¨
post('/admin', '/bridges/bridge_create_project.php');

post('/deactivate', '/bridges/bridge_deactivate.php');

post('/create-users-table', '/db/db_create_table.php');

post('/login', '/bridges/bridge_login.php');

post('/profile', '/bridges/bridge_update_profile.php');

post('/profile-pic', '/bridges/bridge_update_profile_pic.php');

post('/projects/$project_id', '/bridges/bridge_add_task.php');

post('/send-password', '/bridges/bridge_send_password.php');

post('/signup', '/bridges/bridge_signup.php');

post('/tasks/delete/$task_id', 'apis/api_delete_task.php');

post('/tasks/update/$task_id/$status', 'apis/api_update_task.php');

post('/update-password', '/bridges/bridge_update_password.php');

post('/users/delete/$user_id', 'apis/api_delete_user.php');

post('/post', '/bridges/bridge_create_post.php');

post('/comment', '/bridges/bridge_create_comment.php');


// ##############################¨
any('/404', '/views/view_404.php');
