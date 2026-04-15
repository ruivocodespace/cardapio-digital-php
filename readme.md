# 🍔 Cardápio Digital

Um sistema web de Cardápio Digital simples, rápido e responsivo, desenvolvido em PHP e MySQL. Este projeto permite que clientes visualizem os produtos divididos por categorias, enquanto o administrador possui um painel (Dashboard) para adicionar, editar ou remover itens do menu.

---

## 🛠️ Tecnologias Utilizadas

- **Front-end:** HTML5, CSS3 (com design responsivo para celulares).
- **Back-end:** PHP (Procedural/Sessões).
- **Banco de Dados:** MySQL.

---

## 📁 Estrutura de Pastas e Arquivos

Crie esta estrutura exata antes de começar a codificar:

```text
cardapio-digital/
│
├── config/
│   └── conexao.php             # Arquivo de conexão com o banco de dados
│
├── includes/
│   ├── header.php              # Topo do site (Menu, Logo)
│   ├── footer.php              # Rodapé
│   └── verifica_login.php      # Trava de segurança para o painel admin
│
├── uploads/
│   └── produtos/               # Onde as imagens dos lanches serão salvas (adicione o .gitkeep!)
│
├── admin/
│   ├── index.php               # Tela de Login do dono do restaurante
│   ├── dashboard.php           # Lista geral de produtos (Read/Delete)
│   ├── form_produto.php        # Formulário HTML para criar/editar produto
│   └── processa_produto.php    # O "Motor" que salva o produto e faz upload da foto
│
├── index.php                   # Tela Pública: O cardápio que o cliente vê
├── style.css                   # Arquivo de estilos visuais
└── README.md                   # Este arquivo
```
