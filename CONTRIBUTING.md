
# Contribuindo

# Requisitos

- Composer instalado na sua máquina
- API do dothnews rodando
- Tema default instalado e rodando

## Patterns

    Todos os códigos necessitam seguir o PSR12
    Todos os códigos precisam passar no Laravel Pint

## Preparando o Ambiente

1. Faça o fork do repositório [front-reader](https://github.com/dothcom/front-reader)


2. Dentro de um projeto de tema, crie a pasta `packages/dothcom/` na raiz do projeto. 

    ```bash
    mkdir -p packages/dothcom/
    ```

    Adicione ao .gitignore do projeto a pasta `packages/`

3. Clone o repositório forkado dentro da pasta `packages/dothcom/`

    ```bash
    git clone https://github.com/MEU-USUARIO/front-reader
    ```

    > **Nota:** A estrutura de pasta deve ser: `packages/dothcom/front-reader`

4. Insira no composer.json do tema o caminho para o pacote

    ```
    "repositories": [
        {
            "type": "path",
            "url": "./packages/dothcom/front-reader"
        }
    ],


    "minimum-stability": "dev",
    ```

5. Instale o pacote no projeto do tema default

    ```bash
    sail composer require dothcom/front-reader:dev-main
    ```

6. Publique os arquivos necessários

    ```bash
    sail php artisan vendor:publish --tag=front-reader-config
    ```

7. Entre no diretório do pacote e instale as dependências

    ```bash
    cd packages/dothcom/front-reader
    composer install
    ```
