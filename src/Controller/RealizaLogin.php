<?php


namespace WellingtonBarbosa\Cursos\Controller;


use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use WellingtonBarbosa\Cursos\Entity\Usuario;
use WellingtonBarbosa\Cursos\Helper\FlashMessageTrait;


class RealizaLogin implements RequestHandlerInterface
{
    use FlashMessageTrait;

    /**
     * @var ObjectRepository
     */
    private $repositorioDeUsuarios;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->repositorioDeUsuarios = $entityManager
            ->getRepository(Usuario::class);
    }

    public function handle(ServerRequestInterface $request): Response
    {
        $email = filter_var(
            $request->getParsedBody()['email'],
            FILTER_VALIDATE_EMAIL
        );

        $redirecionamentoLogin = new Response(302, ['Location' => '/login']);
        if (is_null($email) || $email === false) {
            $this->defineMensagem(
                'danger',
                'O e-mail digitado não é um e-mail válido.'
            );

            return $redirecionamentoLogin;
        }

        $senha = filter_input(
            INPUT_POST,
            'senha',
            FILTER_SANITIZE_STRING
        );

        /** @var Usuario $usuario */
        $usuario = $this->repositorioDeUsuarios
            ->findOneBy(['email' => $email]);

        if (is_null($usuario) || !$usuario->senhaEstaCorreta($senha)) {
            $this->defineMensagem('danger', 'E-mail ou senha inválidos');

            return $redirecionamentoLogin;
        }

        $_SESSION['logado'] = true;

        return new Response(302, ['Location' => '/listar-cursos']);
    }
}