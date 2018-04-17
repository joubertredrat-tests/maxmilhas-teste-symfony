# Teste MaxMilhas - Versão Symfony Framework

Esta versão do teste foi programada usando o [Symfony Framework](https://symfony.com) versão 3.4.

## Execução

Para execução deste projeto, execute o comando abaixo.

    docker-compose up

Ao final do processo de instalação, o projeto estará disponível em `http://localhost:4000`.

#### Endereços

* Formulário: [http://localhost:4000/form](http://localhost:3000/form)
* Documentação da API: [http://localhost:4000/docs](http://localhost:3000/docs)
* Base da API: [http://localhost:4000/api/v1](http://localhost:3000/api/v1)


## Informações

O projeto foi desenvolvido usando abordagem de programação agnóstica a frameworks e conceitos de [Domain Driven Design](https://en.wikipedia.org/wiki/Domain-driven_design),
recebendo o código da camada de negócio originalmente da versão Slim Framework, tendo sido necessário
somente a adequação do framework ao código existente.

A camada de negócio está na pasta `src/Application`, sendo totalmente portável
para qualquer outro framework ou sistema que utilize PHP 7.1 ou superior.

A camada de infraestrutura está na pasta `src/AppBundle`, sendo ela responsável por tratar a requisição,
interação com a camada de negócio e retorno da requisição.

Todo código fonte de `src/Application` e `src/App` estão em conformidade com as [PSR-1](https://www.php-fig.org/psr/psr-1/) e [PSR-2](https://www.php-fig.org/psr/psr-2/)
e estão documentados no padrão [PHPDoc](https://en.wikipedia.org/wiki/PHPDoc).

Todo código fonte de `src/Application` foram codificados considerando type hint e return type.

Escolhi a versão 3.4 e não a 4.0 do framework pois estou mais familiarizado com ele, além de ser [LTS](https://en.wikipedia.org/wiki/Long-term_support).

## Todo

A validação de um CPF válido está na model `CpfBlacklist` e `CpfBlacklistEvent`, porém,
seria interessante desacoplar, criar um [Value Object](https://en.wikipedia.org/wiki/Value_object) `Cpf` e atribuir a ele a responsabilidade
por validar a string de CPF, tornando `CpfBlacklist`, `CpfBlacklistEvent` e outras implementações usuários de `Cpf` 
