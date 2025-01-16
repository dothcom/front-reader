
# Contribuindo

## Patterns

    Todos os códigos necessitam seguir o PSR12
    Todos os códigos precisam passar no Laravel Pint
    Todos os códigos precisam passar nas validações do PhpStan (TODOING)
    Todos os códigos precisam passar no Pest Type Coverage (TODOING)
    Todos os códigos precisam ser testados com Pest (TODOING)

## Preparando o Ambiente

1. Faça o fork do repositório [front-reader](https://github.com/dothcom/front-reader)

2. Clone o repositório forkeado em seu computador


3. Dentro de um projeto Laravel, crie a pasta `packages/dothcom/` na raiz do projeto

    ```bash
    mkdir -p packages/dothcom/
    ```

4. Faça um link simbólico para o pacote clonado

    ```bash
    ln -s /caminho/para/o/pacote/front-reader packages/dothcom/front-reader
    ```

    > **Nota:** A estrutura de pasta deve ser: `packages/dothcom/front-reader`

5. Open the composer.json of the Laravel project and insert the following content:

    ```
    "repositories": [
        {
            "type": "path",
            "url": "./packages/dothcom/front-reader"
        }
    ],
    ```

6. Instalando
    ```
    composer require dothcom/front-reader:dev-main
    ```

    



## Configurando composer.json    
    
    1. Em require, troque a tag para dev-main -> "dothcom/front-reader": "dev-main"
    2. Em repositories, adicione o seguinte trecho:
    
        ```
        "repositories": [
            {
                "type": "path",
                "url": "./packages/dothcom/front-reader"
            }
        ],
        ```
    3. Adicione autoload-dev:
    
        ```
        "autoload-dev": {
            "psr-4": {
                "Dothcom\\FrontReader\\": "vendor/dothcom/front-reader/src/"
            }
        },
        ```
    3. Rode o comando `composer update dothcom/front-reader` para instalar o pacote.