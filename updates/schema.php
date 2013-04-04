<?php

// Activity table.
$table = Db_Structure::table("forum_activity");
	$table->primary_key("activity_id", db_number);
	$table->column("type", db_varchar, 255);
	$table->column("member_id", db_number)->index();
	$table->column("from_member_id", db_number);
	$table->column("data", "tinyblob");
	$table->column("conversation_id", db_number)->index();
	$table->column("post_id", db_number)->index();
	$table->column("time", db_datetime)->index();
	$table->column("read", db_bool)->index();
	$table->save();

// Channel table.
$table = Db_Structure::table("forum_channels");
	$table->primary_key("channel_id");
	$table->column("title", db_varchar, 31);
	$table->column("slug", db_varchar, 31)->index()->unique();
	$table->column("description", db_varchar, 255);
	$table->column("parent_id", db_number);
	$table->column("lft", db_number);
	$table->column("rgt", db_number);
	$table->column("depth", db_number);
	$table->column("count_conversations", db_number);
	$table->column("count_posts", db_number);
	$table->column("attributes", "mediumblob");
	$table->save();

// Channel-group table.
$table = Db_Structure::table("forum_channel_groups");
	$table->primary_keys("channel_id", "group_id");
	$table->column("channel_id", db_number);
	$table->column("group_id", db_number);
	$table->column("view", db_bool);
	$table->column("reply", db_bool);
	$table->column("start", db_bool);
	$table->column("moderate", db_bool);
	$table->save();

// Conversation table.
$table = Db_Structure::table("forum_conversations");
	$table->primary_key("conversation_id", db_number);
	$table->column("title", db_varchar, 63);
	$table->column("channel_id", db_number)->index();
	$table->column("private", db_bool)->index();
	$table->column("sticky", db_bool);
	$table->column("locked", db_bool)->index();
	$table->column("count_posts", db_number)->index();
	$table->column("start_member_id", db_number)->index();
	$table->column("start_time", db_datetime)->index();
	$table->column("last_post_member_id", db_number);
	$table->column("last_post_time", db_datetime)->index();
	$table->column("attributes", "mediumblob");
	$table->key("sticky_last_post", array("sticky", "lastPostTime"));
	$table->save();

// Group table.
$table = Db_Structure::table("forum_groups");
	$table->primary_key("group_id", db_number);
	$table->column("name", db_varchar, 31);
	$table->column("can_suspend", db_bool);
	$table->save();

// Member table.
$table = Db_Structure::table("forum_members");
	$table->primary_key("memberId", db_number);
	$table->column("username", db_varchar, 31)->index()->unique();
	$table->column("email", db_varchar, 63)->index()->unique();
	$table->column("account", "enum('administrator','member','suspended')")->default_value("member")->index();
	$table->column("confirmed_email", db_bool);
	$table->column("password", "char", 64);
	$table->column("reset_password", "char", 32)->index();
	$table->column("join_time", db_number);
	$table->column("last_action_time", db_datetime)->index();
	$table->column("last_action_detail", "tinyblob");
	$table->column("avatar_format", "enum('jpg','png','gif')");
	$table->column("preferences", "mediumblob");
	$table->column("count_posts", db_number)->index();
	$table->column("count_conversations", db_number);
	$table->save();

// Member-channel table.
$table = Db_Structure::table("forum_member_channels");
	$table->primary_keys("member_id", "channel_id");
	$table->column("unsubscribed", db_bool);
	$table->save();

// Member-conversation table.
$table = Db_Structure::table("forum_member_conversations");
	$table->primary_key("conversation_id", db_number);
	$table->primary_key("type", "enum('member','group')", "member");
	$table->primary_key("id", db_number);
	$table->column("allowed", db_bool);
	$table->column("starred", db_bool);
	$table->column("last_read", db_number);
	$table->column("draft", "text");
	$table->column("muted", db_bool);
	$table->key('type_id', array("type", "id"));
	$table->save();

// Member-group table.
$table = Db_Structure::table("forum_member_groups");
	$table->column("member_id", db_number);
	$table->column("group_id", db_number);
	$table->key(array("member_id", "group_id"), "primary");
	$table->save();

// Member-user table.
$table = Db_Structure::table("forum_member_members");
	$table->primary_key("memberId1", "memberId2");
	$table->save();

// Post table.
$table = Db_Structure::table("forum_posts");
	$table->primary_key("post_id", db_number);
	$table->column("conversation_id", db_number);
	$table->column("member_id", db_number)->index();
	$table->column("time", db_number);
	$table->column("edit_member_id", db_number);
	$table->column("edit_time", db_number);
	$table->column("delete_member_id", db_number);
	$table->column("delete_time", db_number);
	$table->column("title", db_varchar, 63);
	$table->column("content", "text");
	$table->column("attributes", "mediumblob");
	$table->key("conversation_time", array("conversation_id", "time"));
	$table->key("title_content", array("title", "content")); // @todo Fulltext
	$table->save();

// Search table.
$table = Db_Structure::table("forum_searchs");
	$table->column("type", "enum('conversations')", "conversations");
	$table->column("ip", db_number);
	$table->column("time", db_number);
	$table->key('type_ip', array("type", "ip"));
	$table->save();

// Cookie table.
$table = Db_Structure::table("forum_cookies");
	$table->primary_key("member_id", db_number);
	$table->primary_key("series", "char", 32);
	$table->column("token", "char", 32);
	$table->save();