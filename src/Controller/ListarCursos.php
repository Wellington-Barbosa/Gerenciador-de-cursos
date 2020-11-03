<?php


namespace WellingtonBarbosa\Cursos\Controller;


use Doctrine\ORM\EntityManagerInterface;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use WellingtonBarbosa\Cursos\Entity\Curso;
use WellingtonBarbosa\Cursos\Helper\RenderizadorDeHtmlTrait;


class ListarCursos implements RequestHandlerInterface
{

    use RenderizadorDeHtmlTrait;

    private $repositorioDeCursos;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->repositorioDeCursos = $entityManager->getRepository(Curso::class);
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $html = $this->renderizaHtml('cursos/listar-cursos.php', [
           'cursos' => $this->repositorioDeCursos->findAll(),
           'titulo' => 'Listar Cursos',
        ]);

        return new Response(200, [], $html);
    }
}