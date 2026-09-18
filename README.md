# ✈️ Aeroporto Internacional

Sistema em PHP para simular o gerenciamento de um aeroporto: status da pista, fila de decolagem e cadastro de aviões e voos, com o estado mantido entre requisições através de sessão PHP.

![Pista de Decolagem](./assets/aero.JPG)

## 📋 Sobre o projeto

Este é um projeto de estudo que demonstra conceitos fundamentais de PHP, como:

- Manipulação de formulários com `$_POST`
- Persistência de estado usando `$_SESSION`
- Lógica condicional para exibição dinâmica de conteúdo
- Organização de um sistema em múltiplos arquivos PHP
- Integração entre HTML e PHP

## 🚦 Funcionalidades

- Exibe o status atual da pista (livre ou ocupada)
- Libera ou marca a pista como ocupada através de botões
- Fila de decolagem com os aviões aguardando a vez
- Cadastro de aviões
- Cadastro de voos
- Processamento da decolagem do próximo avião da fila
- O status e a fila permanecem salvos mesmo após recarregar a página

## 🛠️ Tecnologias utilizadas

- PHP
- HTML5
- CSS

## 📦 Pré-requisitos

- [PHP](https://www.php.net/downloads) instalado (versão 7.4 ou superior recomendada)
- Um servidor local, como o servidor embutido do PHP, XAMPP, WAMP ou similar

## ▶️ Como executar

1. Clone este repositório:

   ```bash
   git clone https://github.com/seu-usuario/aeroporto.git
   cd aeroporto
   ```

2. Inicie o servidor embutido do PHP:

   ```bash
   php -S localhost:8000
   ```

3. Abra o navegador em:

   ```
   http://localhost:8000
   ```

## 📁 Estrutura do projeto

```
.
├── assets/
│   └── aero.JPG        # Imagem usada no README
├── index.php            # Página principal com o status da pista
├── Aviao.php             # Cadastro de aviões
├── Add_voo.php           # Cadastro de voos
├── Filadecolagem.php     # Exibe a fila de decolagem
├── Decolar.php           # Processa a decolagem do próximo avião da fila
├── style.css              # Estilos da página
└── README.md              # Este arquivo
```

## 🧠 Como funciona

O status da pista é armazenado em `$_SESSION['pistalivre']`. Quando o usuário clica em um dos botões, o formulário envia os dados via `POST`, o PHP verifica qual botão foi pressionado e atualiza o valor guardado na sessão. Como a sessão persiste entre requisições, o status exibido reflete sempre a última ação do usuário — mesmo depois de recarregar a página.

Os aviões cadastrados entram na fila de decolagem (`Filadecolagem.php`), e o botão de decolar (`Decolar.php`) remove o próximo avião da fila, atualizando o estado salvo na sessão.

> 📝 **Nota:** essa seção descreve o funcionamento esperado com base na estrutura dos arquivos. Se algum desses arquivos funcionar de forma diferente, me avise para eu ajustar a explicação.

## 📄 Licença

Este projeto está sob a licença MIT. Sinta-se livre para usar, modificar e distribuir.

## ✍️ Autor

Feito como projeto de estudo de PHP.
