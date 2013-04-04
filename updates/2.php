<?php

// Create the administrator member.
$member = array(
	"username" => $info["adminUser"],
	"email" => $info["adminEmail"],
	"password" => $info["adminPass"],
	"account" => "Administrator",
	"confirmed_email" => true
);
Forum_Member::create()->save($member);

// Set the session's userId and user information variables to the administrator, so that all entities
// created below will be created by the administrator user.
ET::$session->userId = 1;
ET::$session->user = ET::memberModel()->getById(1);

// Create the moderator group.
Forum_Group::create()->save(array(
	"name" => "Moderator",
	"can_suspend" => true
));

// Create the General Discussion channel.
$channel = Forum_Channel::create()->save(array(
	"title" => "General Discussion",
	"slug" => slug("General Discussion")
));

$channel->setPermissions(array(
	GROUP_ID_GUEST => array("view" => true),
	GROUP_ID_MEMBER => array("view" => true, "reply" => true, "start" => true),
	1 => array("view" => true, "reply" => true, "start" => true, "moderate" => true)
));

// Create the Staff Only channel.
$channel = Forum_Channel::create()->save(array(
	"title" => "Staff Only",
	"slug" => slug("Staff Only")
));
$channel->setPermissions(array(
	1 => array("view" => true, "reply" => true, "start" => true, "moderate" => true)
));

// Create a welcome conversation.
Forum_Conversation::create()->save(array(
	"title" => "Welcome to Forum!",
	"content" => "[b]Welcome to Forum![/b]\n\nForum is powered by [url=http://esotalk.org]esoTalk[/url], the simple, fast, free web-forum.\n\nFeel free to edit or delete this conversation. Otherwise, it's time to get posting!\n\nAnyway, good luck, and we hope you enjoy using esoTalk.",
	"channel_id" => 1
));

// Create a helpful private conversation with the administrator.
Forum_Conversation::create()->save(array(
	"title" => "Pssst! Want a few tips?",
	"content" => "Hey dude, congrats on getting esoTalk installed!\n\nCool! Your forum is now good-to-go, but you might want to customize it with your own logo, design, and settings—so here's how.\n\n[h]Changing the Logo[/h]\n\n1. Go to the [url=".C("esoTalk.baseURL")."admin/settings]Forum Settings[/url] section of your administration panel.\n2. Select 'Show an image in the header' for the 'Forum header' setting.\n3. Find and select the image file you wish to use.\n4. Click 'Save Changes'. The logo will automatically be resized so it fits nicely in the header.\n\n[h]Changing the Appearance[/h]\n\n1. Go to the [url=".C("esoTalk.baseURL")."admin/appearance]Appearance[/url] section of your administration panel.\n2. Choose colors for the header, page background, or select a background image. (More skins will be available soon.)\n3. Click 'Save Changes', and your forum's appearance will be updated!\n\n[h]Managing Channels[/h]\n\n'Channels' are a way to categorize conversations in your forum. You can create as many or as few channels as you like, nest them, and give them custom permissions.\n\n1. Go to the [url=".C("esoTalk.baseURL")."admin/channels]Channels[/url] section of your administration panel.\n2. Click 'Create Channel' and fill out a title, description, and select permissions to add a new channel.\n3. Drag and drop channels to rearrange and nest them.\n\n[h]Getting Help[/h]\n\nIf you need help, come and give us a yell at the [url=http://esotalk.org/forum]esoTalk Support Forum[/url]. Don't worry—we don't bite!",
	"channel_id" => 1,
	"type" => "member", 
	"id" => 1
));