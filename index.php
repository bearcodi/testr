<?php
/**
 * Step 1: Require the Slim Framework
 *
 * If you are not using Composer, you need to require the
 * Slim Framework and register its PSR-0 autoloader.
 *
 * If you are using Composer, you can skip this step.
 */
require 'Slim/Slim.php';

\Slim\Slim::registerAutoloader();

/**
 * Step 2: Instantiate a Slim application
 *
 * This example instantiates a Slim application using
 * its default settings. However, you will usually configure
 * your Slim application now by passing an associative array
 * of setting names and values into the application constructor.
 */
$app = new \Slim\Slim();

/**
 * Step 3: Define the Slim application routes
 *
 * Here we define several Slim application routes that respond
 * to appropriate HTTP request methods. In this example, the second
 * argument for `Slim::get`, `Slim::post`, `Slim::put`, `Slim::patch`, and `Slim::delete`
 * is an anonymous function.
 */

function dd($dump) {
    die(var_dump($dump));
}

$db = json_decode(file_get_contents('data/testr.json'));
//$db = array();



// GET route
$app->get(
    '/',
    function () use ($app) {
        echo file_get_contents('index.htm');
    }
);

$app->group('/api', function () use ($app, $db) {

    $app->group('/tests', function () use ($app, $db) {
    
        $app->get(
            '/?',
            function () use ($app, $db)  {

                $status = (object) array(
                    "passed" => 0,
                    "failed" => 0,
                    "total" => 0
                );

                foreach ($db->tests->data as $row) {
                    if (isset($row->passed) && $row->passed) {
                        $status->passed ++;
                    } elseif (isset($row->passed) && !$row->passed) {
                        $status->failed ++;
                    }
                }

                $status->total  = count($db->tests->data);

                $db->tests->status = $status;
                $app->response->setStatus(200);
                $app->response->headers->set('Content-Type', 'application/json');
                $app->response->setBody(json_encode($db->tests));
            }
        );
    
        $app->get(
            '/items/:id',
            function ($id) use ($app, $db) {

                foreach ($db->tests->data as $row) {
                    if ($row->id === (int) $id) {
                        $data = $row;
                        break;
                    }
                }

                $response = isset($data) ? json_encode($data) : "Item with $id not found";

                $app->response->setStatus(isset($data) ? 200 : 404);
                $app->response->headers->set('Content-Type', 'application/json');
                $app->response->setBody($response);        
            }
        );

        // POST route
        $app->post(
            '/items/:id',
            function ($id) {
                echo "ADD item $id";
            }
        );

        // PUT route
        $app->put(
            '/items/:id',
            function ($id) {
                echo "UPDATE item $id";
            }
        );

        // DELETE route
        $app->delete(
            '/items/:id',
            function ($id) {
                echo "DELETE item $id";
            }
        );
    });
});
/**
 * Step 4: Run the Slim application
 *
 * This method should be called last. This executes the Slim application
 * and returns the HTTP response to the HTTP client.
 */
$app->run();
