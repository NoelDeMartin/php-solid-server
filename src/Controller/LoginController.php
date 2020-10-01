<?php declare(strict_types=1);

namespace Pdsinterop\Solid\Controller;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class LoginController extends AbstractController
{
    final public function __invoke(ServerRequestInterface $request, array $args): ResponseInterface
    {
        $postBody = $request->getParsedBody();
        $response = $this->getResponse();
        // var_dump($_SESSION);
        if (isset($_SESSION['userid'])) {
          $user = $_SESSION['userid'];
		  if ($_GET['returnUrl']) {
			$response = $response->withStatus(302, "Redirecting");
			$response = $response->withHeader("Location", $_GET['returnUrl']);
			return $response;
		  }
          $response->getBody()->write("<h1>Already logged in as $user</h1>");
        } else if ($postBody['username'] == "admin" || ($postBody['username'] == $_ENV['USER'] && $postBody['password'] == $_ENV['PASSWORD'])) {
          $user = $postBody['username'];
          $_SESSION['userid'] =  $user;
		  if ($_GET['returnUrl']) {
			$response = $response->withStatus(302, "Redirecting");
			$response = $response->withHeader("Location", $_GET['returnUrl']);
			return $response;
		  }
          $response->getBody()->write("<h1>Welcome $user</h1>\n");
          // echo("session started\n");
          //var_dump($_SESSION);
        } else {
          // var_dump($postBody);
          //echo("cookie:\n");
          //var_dump($_COOKIE);
          //echo("session:\n");
          //var_dump($_SESSION);
          $response->getBody()->write("<h1>No (try posting user=alice&password=alice123)</h1>\n");
        }
        return $response;
    }
}
