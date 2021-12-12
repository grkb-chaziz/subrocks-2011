<?php
require '../app/vendor/autoload.php';
require '../app/protected/config.inc.php';
require '../app/protected/fetch.php';
require '../app/protected/update.php';
require '../app/protected/delete.php';
require '../app/protected/insert.php';
require '../app/protected/formatting.php';

$router = new \Bramus\Router\Router();
$formatter = new \Misc\Formatter\Formatter();
$fetch = new \Database\Fetch\Fetcher($__db);
$loader = new \Twig\Loader\FilesystemLoader('twig/templates');
$twig = new \Twig\Environment($loader, 
	['debug' => true] // disable manually in production
);

$userinfo = [
	"logged_in"       => false,
	"unread_messages" => 0,
	"profile_picture" => "default.jpg",
	"username"        => "joseph",
];

$metadata = [
    "og_context"        => [
        "title"            => "SubRocks 2011",
    ],

    "user_context"      => [
        "user_username"    => "mynamejeff9000",
        "user_bio"         => "hi my names jeff and this is my bio",
        "user_profile_pic" => "default.jpg",
        // fallback, use new classes to fetch user info and cast it to user_context
    ],

    "video_context"     => [
        "video_title"      => "this is a video",
        "video_author"     => "mynameisjeff9000",
        "video_descr"      => "hi this is the description",
        "video_created"    => date("d M Y H"),
        "video_thumbnail"  => "default.jpg",
        "video_file"       => "idfk.mp4",
        "video_rid"        => "idfk.mp4"
        // fallback, use new classes to fetch video info and cast it to video_context
    ]
];

$requested_queries = [
    "recommended_for_you_index" => array(),
];

$router->get('/', function() use ($twig, $__db, $requested_queries, $formatter) { 
    $recommended_videos = $__db->prepare("SELECT * FROM videos ORDER BY rand() DESC LIMIT 4");
	$recommended_videos->execute();
	
	while($video = $recommended_videos->fetch(PDO::FETCH_ASSOC)) { 
        /*
            $video['age'] = $__time_h->time_elapsed_string($video['publish']);		
            $video['duration'] = $__time_h->timestamp($video['duration']);
            $video['views'] = $__video_h->fetch_video_views($video['rid']);
            $video['author'] = htmlspecialchars($video['author']);		
            $video['title'] = htmlspecialchars($video['title']);
            $video['description'] = $__video_h->shorten_description($video['description'], 50);
        */

        $video['description'] = $formatter->shorten_description($video['description'], 50);
		$requested_queries["recommended_for_you_index"][] = $video;
	}

	$requested_queries["recommended_for_you_index"]["results"] = $recommended_videos->rowCount();
    echo highlight_string("<?php\n\$data =\n" . var_export($requested_queries, true) . ";\n?>");

    echo $twig->render('index.twig', []);
});

$router->set404(function() {
    header('HTTP/1.1 404 Not Found');
    echo "PAGE DOESN'T EXIST";
});

$twig->addGlobal('metadata', $metadata);
$twig->addGlobal('userinfo', $userinfo);
$twig->addGlobal('rows', $requested_queries);

$router->run();
?>