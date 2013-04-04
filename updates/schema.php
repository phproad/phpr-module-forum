<?php

// Activity table.
$table = Db_Structure::table("forum_activitys");
	$table->primary_key("activityId", db_number);
	$table->column("type", db_varchar, 255);
	$table->column("memberId", db_number)->index();
	$table->column("fromMemberId", db_number);
	$table->column("data", "tinyblob");
	$table->column("conversationId", db_number)->index();
	$table->column("postId", db_number)->index();
	$table->column("time", db_datetime)->index();
	$table->column("read", db_bool)->index();
	$table->save();

// Channel table.
$table = Db_Structure::table("forum_channels");
	$table->primary_key("channelId");
	$table->column("title", db_varchar, 31);
	$table->column("slug", db_varchar, 31)->index()->unique();
	$table->column("description", db_varchar, 255);
	$table->column("parentId", db_number);
	$table->column("lft", db_number);
	$table->column("rgt", db_number);
	$table->column("depth", db_number);
	$table->column("countConversations", db_number);
	$table->column("countPosts", db_number);
	$table->column("attributes", "mediumblob");
	$table->save();

// Channel-group table.
$table = Db_Structure::table("forum_channel_groups");
	$table->primary_keys("channelId", "groupId");
	$table->column("channelId", db_number);
	$table->column("groupId", db_number);
	$table->column("view", db_bool);
	$table->column("reply", db_bool);
	$table->column("start", db_bool);
	$table->column("moderate", db_bool);
	$table->save();

// Conversation table.
$table = Db_Structure::table("forum_conversations");
	$table->primary_key("conversationId", db_number);
	$table->column("title", db_varchar, 63);
	$table->column("channelId", db_number)->index();
	$table->column("private", db_bool)->index();
	$table->column("sticky", db_bool);
	$table->column("locked", db_bool)->index();
	$table->column("countPosts", db_number)->index();
	$table->column("startMemberId", db_number)->index();
	$table->column("startTime", db_datetime)->index();
	$table->column("lastPostMemberId", db_number);
	$table->column("lastPostTime", db_datetime)->index();
	$table->column("attributes", "mediumblob");
	$table->key("stickyLastPost", array("sticky", "lastPostTime"));
	$table->save();

// Group table.
$table = Db_Structure::table("forum_groups");
	$table->primary_key("groupId", db_number);
	$table->column("name", db_varchar, 31);
	$table->column("canSuspend", db_bool);
	$table->save();

// Member table.
$table = Db_Structure::table("forum_members");
	$table->primary_key("memberId", db_number);
	$table->column("username", db_varchar, 31)->index()->unique();
	$table->column("email", db_varchar, 63)->index()->unique();
	$table->column("account", "enum('administrator','member','suspended')")->default_value("member")->index();
	$table->column("confirmedEmail", db_bool);
	$table->column("password", "char", 64);
	$table->column("resetPassword", "char", 32)->index();
	$table->column("joinTime", db_number);
	$table->column("lastActionTime", db_datetime)->index();
	$table->column("lastActionDetail", "tinyblob");
	$table->column("avatarFormat", "enum('jpg','png','gif')");
	$table->column("preferences", "mediumblob");
	$table->column("countPosts", db_number)->index();
	$table->column("countConversations", db_number);
	$table->save();

// Member-channel table.
$table = Db_Structure::table("forum_member_channels");
	$table->primary_keys("memberId", "channelId");
	$table->column("unsubscribed", db_bool);
	$table->save();

// Member-conversation table.
$table = Db_Structure::table("forum_member_conversations");
	$table->primary_key("conversationId", db_number);
	$table->primary_key("type", "enum('member','group')", "member");
	$table->primary_key("id", db_number);
	$table->column("allowed", db_bool);
	$table->column("starred", db_bool);
	$table->column("lastRead", db_number);
	$table->column("draft", "text");
	$table->column("muted", db_bool);
	$table->key('typeId', array("type", "id"));
	$table->save();

// Member-group table.
$table = Db_Structure::table("forum_member_groups");
	$table->column("memberId", db_number);
	$table->column("groupId", db_number);
	$table->key(array("memberId", "groupId"), "primary");
	$table->save();

// Member-user table.
$table = Db_Structure::table("forum_member_members");
	$table->primary_key("memberId1", "memberId2");
	$table->save();

// Post table.
$table = Db_Structure::table("forum_posts");
	$table->primary_key("postId", db_number);
	$table->column("conversationId", db_number);
	$table->column("memberId", db_number)->index();
	$table->column("time", db_number);
	$table->column("editMemberId", db_number);
	$table->column("editTime", db_number);
	$table->column("deleteMemberId", db_number);
	$table->column("deleteTime", db_number);
	$table->column("title", db_varchar, 63);
	$table->column("content", "text");
	$table->column("attributes", "mediumblob");
	$table->key("conversationTime", array("conversationId", "time"));
	$table->key("titleContent", array("title", "content")); // @todo Fulltext
	$table->save();

// Search table.
$table = Db_Structure::table("forum_searchs");
	$table->column("type", "enum('conversations')", "conversations");
	$table->column("ip", db_number);
	$table->column("time", db_number);
	$table->key('typeIp', array("type", "ip"));
	$table->save();

// Cookie table.
$table = Db_Structure::table("forum_cookies");
	$table->primary_key("memberId", db_number);
	$table->primary_key("series", "char", 32);
	$table->column("token", "char", 32);
	$table->save();