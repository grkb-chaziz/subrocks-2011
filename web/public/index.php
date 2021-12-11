<?php
require '../app/vendor/autoload.php';
require '../app/protected/config.inc.php';

$router = new \Bramus\Router\Router();
$loader = new \Twig\Loader\FilesystemLoader('twig/templates');
$twig = new \Twig\Environment($loader, 
	['debug' => true] // disable manually in production
);

$userinfo = [
	"logged_in"       => false,
	"unread_messages" => 0,
	"profile_picture" => "default.jpg",
	"username"        => "joseph",

	"sql"		      => [
		"header_videos"    => array(),
	]
];

$metadata = [
    "og_context"        => [
        "title"            => "SubRocks 2011",
    ],

    "user_context"      => [
        "user_username"    => "mynamejeff9000",
        "user_bio"         => "hi my names jeff and this is my bio",
        "user_profile_pic" => "default.jpg",
        // add more soon
    ],

    "video_context"     => [
        "video_title"      => "this is a video",
        "video_author"     => "mynameisjeff9000",
        "video_descr"      => "hi this is the description",
        "video_created"    => date("d M Y H"),
        "video_thumbnail"  => "default.jpg",
        "video_file"       => "idfk.mp4",
        "video_rid"        => "idfk.mp4"
    ]
];

$router->get('/', function() use ($twig) { 
    echo $twig->render('index.twig', []);
    // Cool
});

$router->set404(function() {
    header('HTTP/1.1 404 Not Found');
    
    echo "shit doesnt exist homie";
    // 404
});

$twig->addGlobal('metadata', $metadata);
$twig->addGlobal('userinfo', $userinfo);

$router->run();
?>