Instruções para Configuração e Execução do Projeto
1. Configuração do Banco de Dados
Para criar as tabelas no banco de dados, execute o seguinte comando:

bash
Copiar código
php artisan migrate
2. Execução do Projeto
Inicie o servidor de desenvolvimento do Laravel com:

bash
Copiar código
php artisan serve
3. Compilação dos Estilos com Tailwind CSS
Para compilar os estilos usando o Tailwind CSS, execute:

bash
Copiar código
npm run dev
4. Execução do Mock de Dados
Se você precisa rodar um mock do projeto, você deve rodar os comandos em paralelo:

Iniciar o Laravel com o comando acima (php artisan serve).
Compilar o Tailwind CSS com o comando acima (npm run dev).
5. População Manual de Dados
O agendamento automático não foi configurado, então a população esporádica dos dados deve ser feita manualmente. Para isso, use:

bash
Copiar código
php artisan app:importar-dados-fornecedores
6. Conectar ao Projeto Java
O Projeto Java fornece duas URLs para conexão:

http://localhost:8080/api/v1/json
http://localhost:8080/api/v1/xml
Ao rodar o projeto, conecte o sistema a essas URLs para criar os fornecedores. Após conectar, execute novamente o comando para popular o banco de dados:

bash
Copiar código
php artisan app:importar-dados-fornecedores
Resumo dos Comandos
Criar Tabelas no Banco de Dados: php artisan migrate
Rodar o Projeto Laravel: php artisan serve
Compilar o Tailwind CSS: npm run dev
População Manual de Dados: php artisan app:importar-dados-fornecedores
