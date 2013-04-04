<?php

// Activity table.
$table = Db_Structure::table("activity");
	$table->column("activityId", "int(11) unsigned", false);
	$table->column("type", "varchar(255)");
	$table->column("memberId", "int(11) unsigned", false);
	$table->column("fromMemberId", "int(11) unsigned");
	$table->column("data", "tinyblob");
	$table->column("conversationId", "int(11) unsigned");
	$table->column("postId", "int(11) unsigned");
	$table->column("time", "int(11) unsigned");
	$table->column("read", "tinyint(1)", 0);
	$table->key("activityId", "primary");
	$table->key("memberId");
	$table->key("time");
	$table->key("type");
	$table->key("conversationId");
	$table->key("postId");
	$table->key("read");
	$table->save();

// Channel table.
$table = Db_Structure::table("channel");
	$table->primary_key("channelId");
	$table->column("title", "varchar(31)", false);
	$table->column("slug", "varchar(31)", false);
	$table->column("description", "varchar(255)");
	$table->column("parentId", "int(11)");
	$table->column("lft", "int(11)", 0);
	$table->column("rgt", "int(11)", 0);
	$table->column("depth", "int(11)", 0);
	$table->column("countConversations", "int(11)", 0);
	$table->column("countPosts", "int(11)", 0);
	$table->column("attributes", "mediumblob");
	$table->key("slug")->unique();
	$table->save();

// Channel-group table.
$table = Db_Structure::table("channel_group");
	$table->primary_keys("channelId", "groupId");
	$table->column("channelId", "int(11) unsigned", false);
	$table->column("groupId", "int(11)", false);
	$table->column("view", "tinyint(1)", 0);
	$table->column("reply", "tinyint(1)", 0);
	$table->column("start", "tinyint(1)", 0);
	$table->column("moderate", "tinyint(1)", 0);
	$table->save();

// Conversation table.
$table = Db_Structure::table("conversation");
	$table->column("conversationId", "int(11) unsigned", false);
	$table->column("title", "varchar(63)");
	$table->column("channelId", "int(11) unsigned");
	$table->column("private", "tinyint(1)", 0);
	$table->column("sticky", "tinyint(1)", 0);
	$table->column("locked", "tinyint(1)", 0);
	$table->column("countPosts", "smallint(5)", 0);
	$table->column("startMemberId", "int(11) unsigned", false);
	$table->column("startTime", "int(11) unsigned", false);
	$table->column("lastPostMemberId", "int(11) unsigned");
	$table->column("lastPostTime", "int(11) unsigned");
	$table->column("attributes", "mediumblob");
	$table->key("conversationId", "primary");
	$table->key("stickyLastPost", array("sticky", "lastPostTime")); // for the ordering of results
	$table->key("lastPostTime"); // also for the ordering of results, and the last post gambit
	$table->key("countPosts"); // for the posts gambit
	$table->key("startTime"); // for the "order by newest" gambit
	$table->key("locked"); // for the locked gambit
	$table->key("private"); // for the private gambit
	$table->key("startMemberId"); // for the author gambit
	$table->key("channelId"); // for filtering by channel
	$table->save();

// Group table.
$table = Db_Structure::table("group");
	$table->column("groupId", "int(11) unsigned", false);
	$table->column("name", "varchar(31)", "");
	$table->column("canSuspend", "tinyint(1)", 0);
	$table->key("groupId", "primary");
	$table->save();

// Member table.
$table = Db_Structure::table("member");
	$table->column("memberId", "int(11) unsigned", false);
	$table->column("username", "varchar(31)", "");
	$table->column("email", "varchar(63)", false);
	$table->column("account", "enum('administrator','member','suspended')", "member");
	$table->column("confirmedEmail", "tinyint(1)", 0);
	$table->column("password", "char(64)", "");
	$table->column("resetPassword", "char(32)");
	$table->column("joinTime", "int(11) unsigned", false);
	$table->column("lastActionTime", "int(11) unsigned");
	$table->column("lastActionDetail", "tinyblob");
	$table->column("avatarFormat", "enum('jpg','png','gif')");
	$table->column("preferences", "mediumblob");
	$table->column("countPosts", "int(11) unsigned", 0);
	$table->column("countConversations", "int(11) unsigned", 0);
	$table->key("memberId", "primary");
	$table->key("username", "unique");
	$table->key("email", "unique");
	$table->key("lastActionTime");
	$table->key("account");
	$table->key("countPosts");
	$table->key("resetPassword");
	$table->save();

// Member-channel table.
$table = Db_Structure::table("member_channel");
	$table->primary_keys("memberId", "channelId");
	$table->column("unsubscribed", "tinyint(1)", 0);
	$table->save();

// Member-conversation table.
$table = Db_Structure::table("member_conversation");
	$table->primary_key("conversationId", "int(11) unsigned", false);
	$table->primary_key("type", "enum('member','group')", "member");
	$table->primary_key("id", "int(11)", false);
	$table->column("allowed", "tinyint(1)", 0);
	$table->column("starred", "tinyint(1)", 0);
	$table->column("lastRead", "smallint(5)", 0);
	$table->column("draft", "text");
	$table->column("muted", "tinyint(1)", 0);
	$table->key('typeId', array("type", "id"));
	$table->save();

// Member-group table.
$table = Db_Structure::table("member_group");
	$table->column("memberId", "int(11) unsigned", false);
	$table->column("groupId", "int(11) unsigned", false);
	$table->key(array("memberId", "groupId"), "primary");
	$table->save();

// Member-user table.
$table = Db_Structure::table("member_member");
	$table->primary_key("memberId1", "memberId2");
	$table->save();

// Post table.
$table = Db_Structure::table("post");
	$table->primary_key("postId", "int(11) unsigned", false);
	$table->column("conversationId", "int(11) unsigned", false);
	$table->column("memberId", "int(11) unsigned", false);
	$table->column("time", "int(11) unsigned", false);
	$table->column("editMemberId", "int(11) unsigned");
	$table->column("editTime", "int(11) unsigned");
	$table->column("deleteMemberId", "int(11) unsigned");
	$table->column("deleteTime", "int(11) unsigned");
	$table->column("title", "varchar(63)", false);
	$table->column("content", "text", false);
	$table->column("attributes", "mediumblob");
	$table->key("memberId");
	$table->key(array("conversationId", "time"));
	$table->key(array("title", "content"), "fulltext");
	$table->save();

// Search table.
$table = Db_Structure::table("search");
	$table->column("type", "enum('conversations')", "conversations");
	$table->column("ip", "int(11) unsigned", false);
	$table->column("time", "int(11) unsigned", false);
	$table->key('typeIp', array("type", "ip"));
	$table->save();

// Cookie table.
$table = Db_Structure::table("cookie");
	$table->primary_key("memberId", "int(11) unsigned", false);
	$table->primary_key("series", "char(32)", false);
	$table->column("token", "char(32)", false);
	$table->save();