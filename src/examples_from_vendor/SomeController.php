<?php declare(strict_types=1);

namespace Acme;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class SomeController
{
  /**
   * @var \Acme\TemplateRenderer
   */
  protected $templateRenderer;

  /**
   * Construct.
   *
   * @param \Acme\TemplateRenderer $templateRenderer
   */
  public function __construct(TemplateRenderer $templateRenderer)
  {
    $this->templateRenderer = $templateRenderer;
  }

  /**
   * Controller.
   *
   * @param \Psr\Http\Message\ServerRequestInterface $request
   *
   * @return \Psr\Http\Message\ResponseInterface
   */
  public function __invoke(ServerRequestInterface $request): ResponseInterface
  {
    $body     = $this->templateRenderer->render('some-template');

    $response = new Response();

    $response->getBody()->write($body);

    return $response->withStatus(200);
  }

  /**
   * Controller.
   *
   * @param \Psr\Http\Message\ServerRequestInterface $request
   *
   * @return \Psr\Http\Message\ResponseInterface
   */
  public function jsonResponse(ServerRequestInterface $request): ResponseInterface
  {
    $response = new Response;
    $response->getBody()->write(json_encode(/* $content */));
    return $response->withAddedHeader('content-type', 'application/json')->withStatus(200);
  }

  public function errorResponse(ServerRequestInterface $request): ResponseInterface
  {
/*
  Available HTTP Exceptions
  Status Code 	Exception 	Description
  400 	League\Route\Http\Exception\BadRequestException 	The request cannot be fulfilled due to bad syntax.
  401 	League\Route\Http\Exception\UnauthorizedException 	Similar to 403 Forbidden, but specifically for use when authentication is required and has failed or has not yet been provided.
  403 	League\Route\Http\Exception\ForbiddenException 	The request was a valid request, but the server is refusing to respond to it.
  404 	League\Route\Http\Exception\NotFoundException 	The requested resource could not be found but may be available again in the future.
  405 	League\Route\Http\Exception\MethodNotAllowedException 	A request was made of a resource using a request method not supported by that resource; for example, using GET on a form which requires data to be presented via POST, or using PUT on a read-only resource.
  406 	League\Route\Http\Exception\NotAcceptableException 	The requested resource is only capable of generating content not acceptable according to the Accept headers sent in the request.
  409 	League\Route\Http\Exception\ConflictException 	Indicates that the request could not be processed because of conflict in the request, such as an edit conflict in the case of multiple updates.
  410 	League\Route\Http\Exception\GoneException 	Indicates that the resource requested is no longer available and will not be available again.
  411 	League\Route\Http\Exception\LengthRequiredException 	The request did not specify the length of its content, which is required by the requested resource.
  412 	League\Route\Http\Exception\PreconditionFailedException 	The server does not meet one of the preconditions that the requester put on the request.
  415 	League\Route\Http\Exception\UnsupportedMediaException 	The request entity has a media type which the server or resource does not support.
  417 	League\Route\Http\Exception\ExpectationFailedException 	The server cannot meet the requirements of the Expect request-header field.
  418 	League\Route\Http\Exception\ImATeapotException 	I’m a teapot.
  428 	League\Route\Http\Exception\PreconditionRequiredException 	The origin server requires the request to be conditional.
  429 	League\Route\Http\Exception\TooManyRequestsException 	The user has sent too many requests in a given amount of time.
  451 	League\Route\Http\Exception\UnavailableForLegalReasonsException 	The resource is unavailable for legal reasons.
*/
    throw new BadRequestException;
  }
}
