
# Contribuindo

## Patterns

    Todos os códigos necessitam seguir o PSR12
    Todos os códigos precisam passar no Laravel Pint

## Preparando o Ambiente

1. Faça o fork do repositório [front-reader](https://github.com/dothcom/front-reader)


2. Dentro de um projeto Laravel, crie a pasta `packages/dothcom/` na raiz do projeto

    ```bash
    mkdir -p packages/dothcom/
    ```

3. Clone o repositório forkado dentro da pasta `packages/dothcom/`

    ```bash
    git clone https://github.com/MEU-USUARIO/front-reader
    ```

    > **Nota:** A estrutura de pasta deve ser: `packages/dothcom/front-reader`

4. Insira no composer.json

    ```
    "repositories": [
        {
            "type": "path",
            "url": "./packages/dothcom/front-reader"
        }
    ],


    "minimum-stability": "dev",
    ```

5. Instale o pacote

    ```bash
    composer require dothcom/front-reader:dev-main
    ```
