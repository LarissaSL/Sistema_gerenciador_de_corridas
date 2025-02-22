# 🖥️🏎️ Dashboard Administrado de gerenciamento de corridas


---

<br><br>

## 🚀👩‍💻 Time de Desenvolvimento

-  [Giuliana Gralha](https://github.com/Giuliana09) como Engenheira Front-end
-  [Larissa Silva](https://github.com/LarissaSL) como Engenheira Back-end
-  [Leticia Graziele](https://github.com/LeticiaGraziel) como UX/UI e Auxiliar de Banco de Dados
-  [Silvana Sales](https://github.com/SilvanaMenezes) como UX/UI e Fullstack

---

<br><br>

## 📌 Pré-requisitos de Tecnologias

Para iniciar o projeto, você precisa ter os seguintes requisitos instalados:

- **[PHP](https://www.php.net/downloads.php)**  
  Verifique se você tem o PHP instalado no seu ambiente de desenvolvimento. Caso contrário, instale a versão mais recente.

- **IDE para PHP**  
  Você pode escolher entre as seguintes opções de IDE:
  - [Visual Studio Code](https://code.visualstudio.com/)

- **Docker**  
  No caso do Windows Baixa o Docker Desktop:
  - [Docker](https://www.docker.com/get-started/)


---

<br><br><br>

## 📑 Índice
### 1. Inclusões
- [Inclusões](#-inclus%C3%B5es)

### 2. Funcionalidades
- [Funcionalidades](#%EF%B8%8F-funcionalidades)

### 3. Como usar?
- [Inicio]([#%EF%B8%8F%EF%B8%8F-inicio)


### Extra 
- [Tecnologias](#-tecnologias)
- [Apêndices](#-ap%C3%AAndices)

---

<br><br><br>

## 🎯 Inclusões

- ✅ Criação do Readme da API

---

<br><br>

## ⚙️ Funcionalidades

Em desenvolvimento

<br>

**🔝 [Voltar ao Índice](#-%C3%ADndice)**

---

<br><br><br>

## 📓 Padrões de Nomenclatura nos Commits

Abaixo segue uma tabela onde explicamos um padrão para nossos commits.

| **Tipo**    | **Descrição**                                                   |
|-------------|-----------------------------------------------------------------|
| **FEAT**    | Para novos recursos                                             |
| **FIX**     | Solucionando um problema                                        |
| **RAW**     | Arquivo de configs, dados, features, parâmetros                 |
| **BUILD**   | Arquivos de build e dependências                                |
| **PERF**    | Mudança de performance                                          |
| **REMOVE**  | Exclusão de arquivos, diretórios ou código                      |
| **CHORE**   | Atualizações de tarefas de build, configs de admin, pacotes, etc|
| **REFACTOR**| Refatorações sem alterar funcionalidade                         |
| **TESTE**   | Alterações em teste                                             |
| **CI**      | Mudanças relacionadas a integração contínua                     |
| **DOCS**    | Mudanças na documentação                                        |
| **CLEANUP** | Remover trechos desnecessários                                  |
| **STYLE**   | Formatações de código                                           |

`Exemplo de uso:`
```
git commit -m "FEAT - CRUD de Usuarios"
```

<br>

**🔝 [Voltar ao Índice](#-%C3%ADndice)**

---

<br><br><br>

# 🖥️🛠️ Inicio?


## 1. No ambiente Windows Inicie o Docker

### 1.1. Crie o seu arquivo .env
```
cp .env.example .env
```

<br><br>

### 1.2. Descomente e altere as seguintes variáveis
```
DB_CONNECTION=mysql
DB_HOST=db -> Se estiver usando o arquivo do docker desse repositório
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=

CACHE_STORE=file
SESSION_DRIVER=file
```

<br><br>

### 1.3. Abra o terminal e digite
```
docker-compose up -d
```

<br><br>

### 1.4. As portas são:
- App web: 8989
- Banco com phpmyadmin: 8080

**⚠️ Nota:** Sinta-se livre para configurar o ambiente docker do jeito que preferir, assim como caso queira rodar o laravel localmente.

<br><br>

### 1.5. Rodando as Migrations 
Criar as Migrations/Tabelas do Banco
```
php artisan migrate
```

<br><br>

### 2. **⚠️ Opcional** - Seeders (Popular o banco)
Criar as Migrations + os Seeders
```
php artisan migrate --seed
```

**🔝 [Voltar ao Índice](#-%C3%ADndice)**

---

<br><br><br>


## 🛠 Tecnologias

As seguintes tecnologias foram utilizadas no desenvolvimento desse projeto:


## 📑 Apêndices


<br>

**🔝 [Voltar ao Índice](#-%C3%ADndice)**
