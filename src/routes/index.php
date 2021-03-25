<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app = new \Slim\App;

$app->options('/{routes:.+}', function ($request, $response, $args) {
    return $response;
});

$app->add(function ($req, $res, $next) {
    $response = $next($req, $res);
    return $response
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With,X-Powered-By, Content-Type, Accept, Origin, Authorization')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
});

$app->get('/api/colorgame', function(Request $request, Response $response){
    $sql = "SELECT * FROM colourgame";

    try{
        // Get DB Object
        $db = new db();
        // Connect
        $db = $db->connect();

        $stmt = $db->query($sql);
        $record = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($record);
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});
$app->post('/api/colorgame/add', function(Request $request, Response $response){
    $age = $request->getParam('age');
    $score = $request->getParam('score');
    $picture = $request->getParam('picture');
    $mode = $request->getParam('mode');
    $userid = $request->getParam('userid');
    $gender = $request->getParam('gender');


    $sql = "INSERT INTO colourgame (age,score,picture,mode,userid,gender) VALUES
    (:age,:score,:picture,:mode,:userid,:gender)";

    try{
        // Get DB Object
        $db = new db();
        // Connect
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':age', $age);
        $stmt->bindParam(':score',   $score);
        $stmt->bindParam(':picture',  $picture);
        $stmt->bindParam(':mode',    $mode);
        $stmt->bindParam(':userid',    $userid);
        $stmt->bindParam(':gender',    $gender);

        $stmt->execute();

        echo '{"notice": {"text": "Score Added"}';

    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

$app->get('/api/simonsays', function(Request $request, Response $response){
    $sql = "SELECT * FROM simonsays";

    try{
        // Get DB Object
        $db = new db();
        // Connect
        $db = $db->connect();

        $stmt = $db->query($sql);
        $record = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($record);
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});


$app->post('/api/simonsays/add', function(Request $request, Response $response){
    $age = $request->getParam('age');
    $time = $request->getParam('time');
    $score = $request->getParam('score');
    $mode = $request->getParam('mode');
    $userid = $request->getParam('userid');
    $gender = $request->getParam('gender');

    $sql = "INSERT INTO simonsays (age,time,score,mode,userid,gender) VALUES
    (:age,:time,:score,:mode,:userid,:gender)";

    try{
        // Get DB Object
        $db = new db();
        // Connect
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':age', $age);
        $stmt->bindParam(':time',  $time);
        $stmt->bindParam(':score',   $score);
        $stmt->bindParam(':mode',    $mode);
        $stmt->bindParam(':userid',    $userid);
        $stmt->bindParam(':gender',    $gender);


        $stmt->execute();

        echo '{"notice": {"text": "Score Added"}';

    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});

$app->get('/api/numbergame', function(Request $request, Response $response){
    $sql = "SELECT * FROM numbergame";

    try{
        // Get DB Object
        $db = new db();
        // Connect
        $db = $db->connect();

        $stmt = $db->query($sql);
        $record = $stmt->fetchAll(PDO::FETCH_OBJ);
        $db = null;
        echo json_encode($record);
    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});


$app->post('/api/numbergame/add', function(Request $request, Response $response){
    $age = $request->getParam('age');
    $score = $request->getParam('score');
    $mode = $request->getParam('mode');
    $userid = $request->getParam('userid');
    $gender = $request->getParam('gender');

    $sql = "INSERT INTO numbergame (age,score,mode,userid,gender) VALUES
    (:age,:score,:mode, :userid,:gender)";

    try{
        // Get DB Object
        $db = new db();
        // Connect
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':age', $age);
        $stmt->bindParam(':score',   $score);
        $stmt->bindParam(':mode',    $mode);
        $stmt->bindParam(':userid',    $userid);
        $stmt->bindParam(':gender',    $gender);

        $stmt->execute();

        echo '{"notice": {"text": "Score Added"}';

    } catch(PDOException $e){
        echo '{"error": {"text": '.$e->getMessage().'}';
    }
});


$app->post('/api/login', function(Request $request, Response $response){
    $username = $request->getParam('username');
    $password = $request->getParam('password');

    $tsql = "SELECT username From userlogin WHERE username = '$username' AND password = '$password'";

    $db = new db();
    // Connect
    $db = $db->connect();
    $stmt = $db->prepare($tsql);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($results);
    
});

$app->post('/api/add/playerinfo', function(Request $request, Response $response){

    $gender = $request->getParam('gender');
    $age = $request->getParam('age');

    $sql = "INSERT INTO playerinfo (gender, age) VALUES
    (:gender,:age)";

    try{
        // Get DB Object
        $db = new db();
        // Connect
        $db = $db->connect();

        $stmt = $db->prepare($sql);

        $stmt->bindParam(':gender', $gender);
        $stmt->bindParam(':age',  $age);

        $stmt->execute();

        $tsql1 = "SELECT * From playerinfo ORDER BY userid DESC LIMIT 1";
        $stmt = $db->prepare($tsql1);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $stmt->execute();
       
        echo json_encode($results);

    } catch(PDOException $e){
        echo '[{"error": {"text": '.$e->getMessage().'}]';
    }
});





?>