<?php


namespace WellingtonBarbosa\Cursos\Controller;


use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use WellingtonBarbosa\Cursos\Helper\RenderizadorDeHtmlTrait;

class FormularioInsercao implements RequestHandlerInterface
{

    use RenderizadorDeHtmlTrait;

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $html = $this->renderizaHtml('cusos/formulario.php', ['titulo' => 'Novo curso']);

        return new Response(200, [], $html);
    }
}