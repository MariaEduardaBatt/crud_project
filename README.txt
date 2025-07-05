SISTEMA CRUD EM PHP - 2º TRABALHO PRÁTICO

Desenvolvido por: [Nome do Aluno]
Disciplina: Banco de Dados, PHP e Login
Professor: Dr. Ricardo Ramos de Oliveira
Instituição: Instituto Federal de Educação, Ciência e Tecnologia do Sul de Minas Gerais (IFSULDEMINAS)

DESCRIÇÃO DO PROJETO:
Sistema web completo desenvolvido em PHP procedural para gerenciamento de produtos com sistema de autenticação de usuários. O projeto implementa todas as funcionalidades CRUD (Create, Read, Update, Delete) com interface responsiva e moderna.

TECNOLOGIAS UTILIZADAS:
- PHP 8.1 (procedural)
- MySQL 8.0
- HTML5
- CSS3 com design responsivo
- JavaScript (para confirmação de exclusão)
- Sessões PHP para controle de acesso

FUNCIONALIDADES IMPLEMENTADAS:

1. SISTEMA DE AUTENTICAÇÃO:
   ✓ Página de login com validação
   ✓ Página de registro de novos usuários
   ✓ Criptografia de senhas com password_hash()
   ✓ Controle de sessões PHP
   ✓ Logout seguro
   ✓ Proteção de páginas restritas

2. CRUD DE PRODUTOS:
   ✓ Criar: Adicionar produtos com nome, preço, quantidade, descrição e imagem
   ✓ Ler: Listar produtos com exibição de imagens
   ✓ Atualizar: Editar dados e trocar imagens
   ✓ Deletar: Remover produtos com confirmação JavaScript

3. FUNCIONALIDADES EXTRAS:
   ✓ Busca por nome de produto
   ✓ Ordenação do mais novo para o mais antigo
   ✓ Upload de imagens (JPG, JPEG, PNG - máx. 2MB)
   ✓ Design responsivo para mobile e desktop
   ✓ Interface moderna com gradientes e animações

ESTRUTURA DO BANCO DE DADOS:

Tabela usuarios:
- id (INT, AUTO_INCREMENT, PRIMARY KEY)
- nome (VARCHAR(100))
- email (VARCHAR(100), UNIQUE)
- senha (VARCHAR(255))

Tabela produtos:
- id (INT, AUTO_INCREMENT, PRIMARY KEY)
- nome (VARCHAR(100), NOT NULL)
- preco (DECIMAL(10,2), NOT NULL)
- quantidade (INT, NOT NULL)
- descricao (TEXT)
- imagem (VARCHAR(255))
- data_criacao (DATETIME, DEFAULT CURRENT_TIMESTAMP)

MEDIDAS DE SEGURANÇA IMPLEMENTADAS:
- Senhas criptografadas com password_hash()
- Verificação de $_SESSION em páginas protegidas
- Escape de strings com mysqli_real_escape_string()
- Validação de tipos de arquivo para upload
- Limitação de tamanho de arquivo (2MB)
- Nomes únicos para arquivos de imagem

ESTRUTURA DE ARQUIVOS:
/
├── config.php              # Configuração do banco de dados
├── index.php               # Página inicial (redireciona para login)
├── login.php               # Página de login
├── registro.php            # Página de registro
├── logout.php              # Script de logout
├── verificar_login.php     # Verificação de autenticação
├── produtos.php            # Listagem de produtos
├── adicionar_produto.php   # Formulário de adição
├── editar_produto.php      # Formulário de edição
├── excluir_produto.php     # Script de exclusão
├── style.css               # Estilos CSS
├── README.txt              # Este arquivo
└── produtos/
    └── imagens/            # Diretório para imagens dos produtos

INSTRUÇÕES DE INSTALAÇÃO:

1. Configurar servidor web (Apache) com PHP e MySQL
2. Criar banco de dados 'crud_db'
3. Executar os comandos SQL para criar as tabelas
4. Configurar as credenciais do banco em config.php
5. Copiar arquivos para o diretório web
6. Definir permissões de escrita para produtos/imagens/

COMANDOS SQL PARA CRIAÇÃO DAS TABELAS:

CREATE DATABASE crud_db;
USE crud_db;

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    senha VARCHAR(255)
);

CREATE TABLE produtos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    preco DECIMAL(10,2) NOT NULL,
    quantidade INT NOT NULL,
    descricao TEXT,
    imagem VARCHAR(255),
    data_criacao DATETIME DEFAULT CURRENT_TIMESTAMP
);

LINK DO VÍDEO DE APRESENTAÇÃO:
[Inserir link do YouTube aqui]

OBSERVAÇÕES:
- Projeto desenvolvido seguindo rigorosamente as especificações do trabalho
- Não foram utilizadas bibliotecas ou frameworks externos
- Código limpo e bem documentado
- Interface responsiva e moderna
- Todas as funcionalidades testadas e validadas

