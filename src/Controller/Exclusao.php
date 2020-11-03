<?php


namespace WellingtonBarbosa\Cursos\Controller;


use Doctrine\ORM\EntityManagerInterface;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use WellingtonBarbosa\Cursos\Entity\Curso;
use WellingtonBarbosa\Cursos\Helper\FlashMessageTrait;
use WellingtonBarbosa\Cursos\Infra\EntityManagerCreator;

class Exclusao implements RequestHandlerInterface
{

    use FlashMessageTrait;

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $id = filter_var(
            $request->getQueryParams()['id'],
            FILTER_VALIDATE_INT
        );

        $resposta = new Response(302, ['Location' => '/listar-cursos']);
        if (is_null($id) || $id === false) {
            $this->defineMensagem('danger', 'Curso inexistente');
            return $resposta;
        }

        $curso = $this->entityManager->getReference(
            Curso::class,
            $id
        );
        $this->entityManager->remove($curso);
        $this->entityManager->flush();
        $this->defineMensagem('success', 'Curso excluído com sucesso');

        return $resposta;
    }

}