<?php

/**
 * Please note: we can use unencoded characters like ö, é etc here as we use the html5 doctype with utf8 encoding
 * in the application's header (in views/_header.php). To add new languages simply copy this file,
 * and create a language switch in your root files.
 */

function message($phrase) {
    // General Messages
    $message['database_error'] = "A Database error has occurred: ";
    $message['compatible_php'] = "Sorry, this application does not run on a PHP version smaller than 5.3.7!";
    $message['something_wrong'] = "Looks like something went completely wrong! but dont worry It can happen to the best of us, and it just happened to you";
    $message['permission_denied'] = "Sorry, it looks like you do not have permission to perform this action";
    $message['permission_page'] = "Sorry, it looks like you do not have permission to view this page";
    $message['not_found_template'] = "Template file not found: ";
    $message['not_found_file'] = "Sorry, it looks like the file does not exist";
    $message['success_settings'] = "The website settings have been successfully updated";

    // Login Messages
    $message["empty_username_or_password"] = "Oops! It looks like your username or password is empty";
    $message["inccorect_username_or_password"] = "Oops! It looks like your username or password is incorrect";
    $message["cooldown_login"] = "You have entered an incorrect password 3 or more times already. Please wait 10 minutes to try again";
    $message["invalid_cookie"] = "Invalid cookie";
    $message["logged_out"] = "You have successfully logged out";
    $message["logged_in"] = "You have successfully logged in";
    $message["already_logged"] = "You are already logged in";
    $message["log_in"] = "You must Login first!";

    // Social Feeds
    $message["invalid_post"] = "Invalid Post ID";
    $message["empty_comment"] = "Sorry, it looks like your comment is empty";
    $message["success_comment"] = "Your Comment has been posted";
    $message["empty_post"] = "Sorry, it looks like your post is empty";
    $message["select_group"] = "Sorry, it looks like you haven't selected a group";
    $message["success_post"] = "Your post has been successfully submitted";
    $message["not_image"] = "Sorry, it looks like the file you have uploaded is not an image";
    $message["large_image"] = "Sorry, it looks like the image you have uploaded is too large";
    $message["image_exists"] = "Oops! It looks like the file you are trying to upload already exists";
    $message["allowed_image"] = "Sorry, only JPG, JPEG, PNG, SVG & GIF files are allowed";
    $message["delete_post"] = "Your post has been successfully deleted";
    $message["access_group"] = "Oops! It looks like you don't have permission to access this group";
    $message["join_group"] = "Sorry, it looks like you must join the group before you can access it";
    $message["empty_group"] = "Oops! It looks like the group you are trying to access does not exist";
    $message["empty_posts_title"] = "Wow, Such Empty!";
    $message["empty_posts_description"] = "There are no posts to display at this time. Please check back later or consider posting something yourself";
    $message["pin_post"] = "Your post has been successfully pinned";
    $message["unpin_post"] = "Your post has been successfully unpinned";
    $message["permission_pin_post"] = "Sorry, it looks like you do not have permission to pin this post";
    $message["permission_unpin_post"] = "Sorry, it looks like you do not have permission to unpin this post";
    $message["permission_mute_user"] = "Sorry, it looks like you do not have permission to mute this user";
    $message["permission_unmute_user"] = "Sorry, it looks like you do not have permission to unmute this user";
    $message["cannot_mute_yourself"] = "Sorry, you cannot mute yourself";
    $message["cannot_unmute_yourself"] = "Sorry, you cannot unmute yourself";
    $message["mute_user"] = "You have successfully muted this user";
    $message["unmute_user"] = "You have successfully unmuted this user";
    $message["muted_user"] = "Sorry, it looks like you are muted in this group and cannot post";
    $message["permission_delete_post"] = "Sorry, it looks like you do not have permission to delete this post";
    $message["permission_delete_comment"] = "Sorry, it looks like you do not have permission to delete this comment";
    $message["delete_comment"] = "You have successfully deleted the comment";
    $message["exists_comment"] = "Oops! It looks like the comment you are trying to access does not exist";
    $message["allowed_comment"] = "Sorry, it looks like you are not allowed to edit this comment";
    $message["edit_comment"] = "You have successfully edited the comment";
    $message["exists_post"] = "Sorry, it looks like the post you are trying to access does not exist";
    $message["cant_comment"] = "Sorry, it looks like you cannot comment in this group";
    $message["not_member"] = "Sorry, it looks like you are not member of this group";

    // Group
    $message["invalid_group"] = 'Invalid Group ID';
    $message["join_group"] = 'You have successfully joined the group';
    $message["leave_group"] = 'You have successfully left the group';
    $message["cant_leave_group"] = 'Oops! It looks like you cannot leave this group';
    $message["cant_join_group"] = 'Oops! It looks like you cannot join this group';
    $message["already_join_group"] = 'Sorry, it looks like you are already a member of this group';
    $message["not_join_cant_leave"] = 'Sorry, it looks like you are not a member of this group and cannot leave it';
    $message["not_registered"] = 'Sorry, it looks like you are not registered for this course';
    $message["must_be_invited"] = 'Oops! It looks like you must be invited to this group in order to view it';
    $message["permission_remove_user"] = 'Sorry, it looks like you do not have permission to remove this user';
    $message["cannot_remove_yourself"] = "Sorry, you cannot remove yourself";
    $message["remove_user"] = "The user has been successfully removed";
    $message["permissions_edit_group"] = "Sorry, it looks like you do not have permission to edit this group";
    $message["edit_group"] = "The group has been successfully edited";
    $message["empty_group_name"] = "The group name cannot be empty";
    $message["empty_group_description"] = "The group description cannot be empty";
    $message["set_group_status"] = "Sorry, it looks like the group status can only be set to either private or public";
    $message["no_announcements"] = "there are currently no announcements available in this group";
    $message["empty_group_name"] = 'Sorry, it looks like the group name is empty';
    $message["empty_group_type"] = 'Sorry, it looks like the group type is empty';
    $message["invalid_group_type"] = 'Sorry, it looks like the group type is invalid';
    $message["empty_group_status"] = 'Sorry, it looks like the group status is empty';
    $message["invalid_group_status"] = 'Sorry, it looks like the group status is invalid';
    $message["success_add_group"] = 'You have successfully created a group';
    $message["success_delete_group"] = 'The group has been successfully deleted';

    // Invite
    $message["permission_invitation_role"] = 'Sorry, it looks like you do not have permission to specify the invitation role';
    $message["invalid_invitation_userid"] = 'Invalid User ID';
    $message["invalid_invitation_role"] = 'Invalid Role';
    $message["permissions_create_invite"] = 'Sorry, it looks like you do not have permission to create an invitation link';
    $message["success_invitation_link"] = 'Your invitation link has been created successfully';
    $message["invalid_invitation_link"] = 'Sorry, it looks like the invitation link is invalid';
    $message["used_invitation_link"] = 'Oops! It looks like this invitation link has already been used';
    $message["use_invitation_link"] = 'Oops! It looks like you cannot use this invitation link';
    $message["already_invitation_link"] = 'Sorry, it looks like you cannot use this invitation link because you are already a member of the group';
    $message["own_invitation_link"] = 'Sorry, it looks like you cannot use your own invitation link';
    $message["decline_invitation"] = 'You have declined the invitation. We understand if you are unable to join us at this time, but we hope you will consider joining us in the future. Thank you for considering us';
  
    // Announcement
    $message["empty_announcement_title"] = 'Sorry, it looks like the title is empty';
    $message["empty_announcement_description"] = 'Sorry, it looks like the description is empty';
    $message["max_announcement_files"] = 'Sorry, it looks like the files size is larger than 30MB';
    $message["success_announcement"] = 'Your Announcement has been created successfully';

    // User
    $message["invalid_user"] = 'Invalid User ID';
    $message["empty_name"] = 'Sorry, it looks like the name is empty';
    $message["empty_username"] = 'Sorry, it looks like the username is empty';
    $message["empty_email"] = 'Sorry, it looks like the Email is empty';
    $message["valid_email"] = 'Sorry, it looks like the Email is not a valid email address';
    $message["empty_role"] = 'Sorry, it looks like you didn\'t choose a role';
    $message["empty_password"] = 'Sorry, it looks like the password is empty';
    $message["success_add_user"] = 'You have successfully created a user';

    // Roles
    $message["success_new_role"] = 'The new role has been successfully added';
    $message["empty_role_title"] = 'The role name cannot be empty';
    $message["success_assign_user"] = 'The user has been successfully assigned to the role';
    $message["success_remove_user"] = 'The user has been successfully removed from the role';

    // Permissions
    $message["empty_permission_title"] = 'Sorry, it looks like the permission title is empty';
    $message["empty_permission_variable"] = 'Sorry, it looks like the permission variable is empty';
    $message["preg_permission_variable"] = 'Sorry, the permission variable cannot contain any spaces';
    $message["success_delete_permission"] = 'The permission has been successfully deleted';
    $message["success_edit_permission"] = 'You have successfully edited the permission';
    $message["success_new_permission"] = 'The new permission has been successfully created';

    // Importing
    $message["empty_eql_engine"] = 'Sorry, it looks like the SQL Engine is empty';
    $message["empty_database_host"] = 'Sorry, it looks like the Host is empty';
    $message["empty_database_username"] = 'Sorry, it looks like the database username is empty';
    $message["empty_database_password"] = 'Sorry, it looks like the database password is empty';
    $message["empty_database_name"] = 'Sorry, it looks like the database name is empty';
    $message["empty_table_name"] = 'Sorry, it looks like the table name is empty';
    $message["empty_column_id"] = 'Sorry, it looks like the column id is empty';
    $message["empty_column_name"] = 'Sorry, it looks like the column name is empty';
    $message["empty_table_data"] = 'Oops! it looks like the table does not contain any data';

    // Api
    $message["success_new_api"] = 'You have successfully created a new api';
    $message["success_delete_api"] = 'You have successfully deleted the api key';
    $message["success_activate_api"] = 'You have successfully activated the api key';

    // Api Requests
    $message["unset_api_key"] = 'It looks like the API key has not been set';
    $message["unset_api_endpoint"] = 'It looks like the API endpoint has not been set';
    $message["invalid_api_key"] = 'Invalid API Key. Please ensure that the API key provided is valid';
    $message["inactive_api_key"] = 'Sorry, it looks like the provided API key is inactive';
    $message["inactive_api_access"] = 'Sorry, it looks like you do not have access to this endpoint of the API. Please verify that you have the correct permissions';

    // Files
    $message["invalid_file"] = 'Sorry, it looks like the files you are trying to access does not exits';
    $message["invalid_file_count"] = 'Sorry, it looks like you have not selected any file';
    $message["invalid_file_name"] = 'Sorry, it looks like the file name is empty';
    $message["success_update_api"] = 'You have successfully updated the api key';
    $message["max_file_size"] = 'Sorry, it looks like the files size is larger than 30MB';
    $message["success_file_upload"] = 'You have successfully uploaded the files';

    // Events
    $message["empty_event_name"] = 'Sorry, it looks like the event name is empty';
    $message["empty_event_details"] = 'Sorry, it looks like the event details is empty';
    $message["empty_event_date"] = 'Sorry, it looks like the event date is empty';
    $message["empty_event_type"] = 'Sorry, it looks like the event type is empty';
    $message["empty_event_status"] = 'Sorry, it looks like the event status is empty';
    $message["empty_event_duration"] = 'Sorry, it looks like the event duration is empty';
    $message["numeric_event_duration"] = 'Sorry, it looks like the event duration is not valid';
    $message["numeric_event_topics"] = 'Sorry, it looks like the event topics is not valid';
    $message["success_event"] = 'You have successfully created an event';
    $message["no_events"] = "there are currently no events available in this group";
    $message["invalid_event"] = "Invalid event id";

    // Profile
    $message["invalid_profile"] = "Invalid Profile ID";
    $message["private_profile"] = "Sorry, it looks like this profile is private";
    $message["confirm_password"] = "Sorry, you must confirm your password";
    $message["incorrect_password"] = "Sorry, it looks like your password is incorrect";
    $message["success_update_details"] = "You have successfully updated the profile";
    $message["current_password"] = "Sorry, it looks like the current password is empty";
    $message["new_password"] = "Sorry, it looks like the new password is empty";
    $message["new_confirm_password"] = "The password and its confirm are not the same";
    $message["success_update_password"] = "You have successfully updated the password";

    // Language
    $message["success_language"] = "You have successfully updated the language";



    return (!array_key_exists($phrase, $message)) ? $phrase : $message[$phrase];
}