<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <title>Laboratório Docker + PHP – 5 Exercícios</title>
  <style>
    body {
      font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
      max-width: 900px;
      margin: 0 auto;
      padding: 20px;
      line-height: 1.6;
    }
    h1, h2, h3 {
      color: #222;
    }
    h1 {
      margin-bottom: 0.2em;
    }
    h2 {
      margin-top: 1.8em;
    }
    h3 {
      margin-top: 1.2em;
    }
    code {
      font-family: Consolas, "Fira Code", Menlo, Monaco, "Courier New", monospace;
      font-size: 0.95em;
    }
    pre {
      background: #f4f4f4;
      padding: 10px 12px;
      border-radius: 6px;
      overflow-x: auto;
      font-size: 0.9em;
    }
    .objetivo {
      font-style: italic;
      color: #444;
    }
    .secao {
      margin-bottom: 2em;
      padding-bottom: 1em;
      border-bottom: 1px solid #ddd;
    }
    .tag {
      display: inline-block;
      background: #eee;
      padding: 2px 6px;
      border-radius: 4px;
      font-size: 0.8em;
      margin-right: 4px;
    }
  </style>
</head>
<body>

  <h1>Laboratório Docker + PHP – 5 Exercícios</h1>
  
  <div class="secao" style="background-color: #eef; padding: 15px; border-left: 5px solid #0078d4;">
    <h3>🖥️ Instruções para Windows</h3>
    <p>
      Como a maioria dos alunos está utilizando Windows, siga os passos abaixo para preparar seu ambiente:
    </p>
    <ol>
      <li>Pressione <strong>Windows + R</strong> no teclado.</li>
      <li>Digite <code>cmd</code> e pressione <strong>Enter</strong>.</li>
      <li>O prompt de comando abrirá, geralmente na pasta <code>C:\Users\aluno</code> (ou seu usuário).</li>
      <li>Crie a pasta do laboratório com o comando: <code>mkdir docker-php-lab</code></li>
      <li>Entre na pasta: <code>cd docker-php-lab</code></li>
    </ol>
    <p>
      <em>Nota: Nos exercícios abaixo, quando vir comandos com <code>$(pwd)</code> (Linux/Mac), 
      substitua por <code>%cd%</code> no CMD do Windows ou use o caminho absoluto.</em>
    </p>
  </div>

  <p>
    Roteiro simples de exercícios para aprender Docker/Podman com PHP.<br />
    Sugestão: crie uma pasta <code>docker-php-lab/</code> e dentro dela subpastas
    <code>ex1</code>, <code>ex2</code>, etc.
  </p>

  <!-- Exercício 1 -->
  <div class="secao">
    <h2>Exercício 1 – Primeiro Dockerfile com PHP (CLI)</h2>
    <p class="objetivo">
      Objetivo: Criar um <code>Dockerfile</code> simples com PHP (linha de comando) que imprime
      “Hello from Docker/Podman!”.
    </p>

    <h3>Enunciado</h3>
    <ol>
      <li>Crie uma pasta <code>ex1</code>.</li>
      <li>Dentro dela, crie um arquivo <code>app.php</code> que imprime uma mensagem simples.</li>
      <li>Crie um <code>Dockerfile</code> que:
        <ul>
          <li>Use a imagem base <code>php:8.2-cli</code>;</li>
          <li>Copie o <code>app.php</code> para dentro da imagem;</li>
          <li>Defina o comando padrão para rodar o <code>app.php</code>.</li>
        </ul>
      </li>
      <li>Faça o build da imagem.</li>
      <li>Rode o container a partir dessa imagem.</li>
    </ol>

    <h3>Resolução</h3>

    <p><strong>Arquivos em <code>ex1/</code>:</strong></p>

    <p><strong><code>app.php</code></strong></p>
    <pre><code class="language-php">&lt;?php
echo "Hello from Docker/Podman!\n";
</code></pre>

    <p><strong><code>Dockerfile</code></strong></p>
    <pre><code class="language-dockerfile">FROM php:8.2-cli

WORKDIR /app

COPY app.php /app/app.php

CMD ["php", "/app/app.php"]
</code></pre>

    <p><strong>Build da imagem</strong> (no diretório <code>ex1/</code>):</p>

    <p><span class="tag">Docker</span></p>
    <pre><code class="language-bash">docker build -t php-hello-ex1 .</code></pre>

    <p><span class="tag">Podman</span></p>
    <pre><code class="language-bash">podman build -t php-hello-ex1 .</code></pre>

    <p><strong>Rodando o container</strong></p>

    <p><span class="tag">Docker</span></p>
    <pre><code class="language-bash">docker run --rm php-hello-ex1</code></pre>

    <p><span class="tag">Podman</span></p>
    <pre><code class="language-bash">podman run --rm php-hello-ex1</code></pre>

    <p><strong>Saída esperada:</strong></p>
    <pre><code>Hello from Docker/Podman!</code></pre>
  </div>

  <!-- Exercício 2 -->
  <div class="secao">
    <h2>Exercício 2 – Variáveis de ambiente no container</h2>
    <p class="objetivo">
      Objetivo: Usar variável de ambiente para personalizar a mensagem.
    </p>

    <h3>Enunciado</h3>
    <ol>
      <li>Copie a pasta <code>ex1</code> para <code>ex2</code>.</li>
      <li>Altere o <code>app.php</code> para:
        <ul>
          <li>Ler a variável de ambiente <code>APP_NAME</code> (se não existir, usar “DefaultApp”);</li>
          <li>Imprimir <code>Hello from {APP_NAME}!</code>.</li>
        </ul>
      </li>
      <li>Reaproveite o <code>Dockerfile</code>.</li>
      <li>Faça o build com outro nome de imagem.</li>
      <li>Rode o container passando uma variável de ambiente <code>APP_NAME</code>.</li>
    </ol>

    <h3>Resolução</h3>

    <p><strong>Arquivos em <code>ex2/</code>:</strong></p>

    <p><strong><code>app.php</code></strong></p>
    <pre><code class="language-php">&lt;?php
$appName = getenv('APP_NAME') ?: 'DefaultApp';
echo "Hello from {$appName}!\n";
</code></pre>

    <p><strong><code>Dockerfile</code></strong> (igual ao do exercício 1)</p>
    <pre><code class="language-dockerfile">FROM php:8.2-cli

WORKDIR /app

COPY app.php /app/app.php

CMD ["php", "/app/app.php"]
</code></pre>

    <p><strong>Build da imagem</strong> (no diretório <code>ex2/</code>):</p>

    <p><span class="tag">Docker</span></p>
    <pre><code class="language-bash">docker build -t php-env-ex2 .</code></pre>

    <p><span class="tag">Podman</span></p>
    <pre><code class="language-bash">podman build -t php-env-ex2 .</code></pre>

    <p><strong>Rodando o container com variável de ambiente</strong></p>

    <p><span class="tag">Docker</span></p>
    <pre><code class="language-bash">docker run --rm -e APP_NAME="MyFirstPHPApp" php-env-ex2</code></pre>

    <p><span class="tag">Podman</span></p>
    <pre><code class="language-bash">podman run --rm -e APP_NAME="MyFirstPHPApp" php-env-ex2</code></pre>

    <p><strong>Saída esperada:</strong></p>
    <pre><code>Hello from MyFirstPHPApp!</code></pre>

    <p>Se rodar sem <code>-e APP_NAME=...</code>:</p>
    <pre><code>Hello from DefaultApp!</code></pre>
  </div>

  <!-- Exercício 3 -->
  <div class="secao">
    <h2>Exercício 3 – Servindo uma página PHP via Apache</h2>
    <p class="objetivo">
      Objetivo: Criar uma imagem que roda um servidor web com PHP e Apache, expondo a porta 80.
    </p>

    <h3>Enunciado</h3>
    <ol>
      <li>Crie uma pasta <code>ex3</code>.</li>
      <li>Crie um <code>index.php</code> simples que mostre:
        <ul>
          <li>Um título: “Bem-vindo ao meu container PHP”;</li>
          <li>Um texto ou <code>phpinfo()</code> (opcional).</li>
        </ul>
      </li>
      <li>Crie um <code>Dockerfile</code> que:
        <ul>
          <li>Use a imagem <code>php:8.2-apache</code>;</li>
          <li>Copie o <code>index.php</code> para <code>/var/www/html/</code>;</li>
          <li>Exponha a porta <code>80</code>.</li>
        </ul>
      </li>
      <li>Faça o build da imagem.</li>
      <li>Rode o container mapeando a porta 8080 do host para 80 do container.</li>
      <li>Acesse no navegador: <code>http://localhost:8080</code>.</li>
    </ol>

    <h3>Resolução</h3>

    <p><strong>Arquivos em <code>ex3/</code>:</strong></p>

    <p><strong><code>index.php</code></strong></p>
    <pre><code class="language-php">&lt;?php
echo "&lt;h1&gt;Bem-vindo ao meu container PHP!&lt;/h1&gt;";
echo "&lt;p&gt;Se você está vendo isso, o Apache + PHP dentro do container está funcionando.&lt;/p&gt;";
// Opcional:
// phpinfo();
</code></pre>

    <p><strong><code>Dockerfile</code></strong></p>
    <pre><code class="language-dockerfile">FROM php:8.2-apache

# Ativa o mod_rewrite (opcional, útil para apps futuras):
RUN a2enmod rewrite

# Copia o index.php para o DocumentRoot padrão do Apache
COPY index.php /var/www/html/index.php

EXPOSE 80
</code></pre>

    <p><strong>Build da imagem</strong> (no diretório <code>ex3/</code>):</p>

    <p><span class="tag">Docker</span></p>
    <pre><code class="language-bash">docker build -t php-apache-ex3 .</code></pre>

    <p><span class="tag">Podman</span></p>
    <pre><code class="language-bash">podman build -t php-apache-ex3 .</code></pre>

    <p><strong>Rodando o container</strong></p>

    <p><span class="tag">Docker</span></p>
    <pre><code class="language-bash">docker run --rm -p 8080:80 php-apache-ex3</code></pre>

    <p><span class="tag">Podman</span></p>
    <pre><code class="language-bash">podman run --rm -p 8080:80 php-apache-ex3</code></pre>

    <p>Abra o navegador em <code>http://localhost:8080</code> para ver a página PHP.</p>
  </div>

  <!-- Exercício 4 -->
  <div class="secao">
    <h2>Exercício 4 – Usando bind mount para editar o código sem rebuild</h2>
    <p class="objetivo">
      Objetivo: Rodar um container Apache+PHP usando bind mount de uma pasta local, para poder alterar o código sem refazer o build.
    </p>

    <h3>Enunciado</h3>
    <ol>
      <li>Crie uma pasta <code>ex4</code> com um subdiretório <code>src/</code>.</li>
      <li>Dentro de <code>src/</code>, crie um <code>index.php</code> com uma mensagem simples.</li>
      <li>Use diretamente a imagem oficial <code>php:8.2-apache</code> (não precisa de Dockerfile).</li>
      <li>Rode o container mapeando:
        <ul>
          <li>A pasta <code>src/</code> do host em <code>/var/www/html</code> do container;</li>
          <li>A porta 8081 → 80.</li>
        </ul>
      </li>
      <li>Abra o navegador em <code>http://localhost:8081</code>.</li>
      <li>Edite o <code>index.php</code> e recarregue o navegador para ver a mudança sem rebuild.</li>
    </ol>

    <h3>Resolução</h3>

    <p><strong>Arquivos em <code>ex4/src/</code>:</strong></p>

    <p><strong><code>index.php</code></strong></p>
    <pre><code class="language-php">&lt;?php
echo "&lt;h1&gt;Meu app PHP em bind mount&lt;/h1&gt;";
echo "&lt;p&gt;Versão 1&lt;/p&gt;";
</code></pre>

    <p><strong>Rodando o container com bind mount</strong> (no diretório <code>ex4/</code>):</p>

    <p><span class="tag">Linux / Mac / PowerShell</span></p>
    <pre><code class="language-bash">docker run --rm \
  -p 8081:80 \
  -v "$(pwd)/src:/var/www/html" \
  php:8.2-apache
</code></pre>

    <p><span class="tag">Windows (CMD)</span></p>
    <pre><code class="language-cmd">docker run --rm ^
  -p 8081:80 ^
  -v "%cd%\src:/var/www/html" ^
  php:8.2-apache
</code></pre>

    <p><span class="tag">Podman (Linux / Mac)</span></p>
    <pre><code class="language-bash">podman run --rm \
  -p 8081:80 \
  -v "$(pwd)/src:/var/www/html" \
  php:8.2-apache
</code></pre>

    <p><span class="tag">Podman (Windows CMD)</span></p>
    <pre><code class="language-cmd">podman run --rm ^
  -p 8081:80 ^
  -v "%cd%\src:/var/www/html" ^
  php:8.2-apache
</code></pre>

    <p>Abra <code>http://localhost:8081</code>.</p>

    <p>Troque o <code>index.php</code> para, por exemplo:</p>
    <pre><code class="language-php">&lt;?php
echo "&lt;h1&gt;Meu app PHP em bind mount&lt;/h1&gt;";
echo "&lt;p&gt;Versão 2 - modificado sem rebuild!&lt;/p&gt;";
</code></pre>

    <p>Recarregue o navegador e veja a nova versão.</p>
  </div>

  <!-- Exercício 5 -->
  <div class="secao">
    <h2>Exercício 5 – Pequena aplicação PHP com contador de visitas</h2>
    <p class="objetivo">
      Objetivo: Criar uma imagem com uma aplicação PHP simples (“contador de visitas”) e ver ela rodando em um container próprio.
    </p>

    <h3>Enunciado</h3>
    <ol>
      <li>Crie uma pasta <code>ex5</code>.</li>
      <li>Crie um arquivo <code>index.php</code> que:
        <ul>
          <li>Grave e leia um contador de visitas em um arquivo <code>contador.txt</code>;</li>
          <li>Mostre na tela quantas vezes a página já foi acessada.</li>
        </ul>
      </li>
      <li>Crie um <code>Dockerfile</code> que:
        <ul>
          <li>Use <code>php:8.2-apache</code>;</li>
          <li>Crie um diretório para armazenar o <code>contador.txt</code>, com permissões adequadas;</li>
          <li>Copie <code>index.php</code> para <code>/var/www/html/</code>.</li>
        </ul>
      </li>
      <li>Faça o build da imagem com o nome <code>php-contador-ex5</code>.</li>
      <li>Rode o container, mapeando a porta 8082 → 80.</li>
      <li>Acesse <code>http://localhost:8082</code> algumas vezes para ver o contador aumentando.</li>
    </ol>

    <h3>Resolução</h3>

    <p><strong>Arquivos em <code>ex5/</code>:</strong></p>

    <p><strong><code>index.php</code></strong></p>
    <pre><code class="language-php">&lt;?php
$arquivo = __DIR__ . '/contador.txt';

// Se o arquivo não existir, cria com zero
if (!file_exists($arquivo)) {
    file_put_contents($arquivo, "0");
}

// Lê o valor atual
$visitas = (int) file_get_contents($arquivo);

// Incrementa
$visitas++;

// Salva de volta
file_put_contents($arquivo, (string) $visitas);

// Mostra na tela
echo "&lt;h1&gt;Bem-vindo ao meu app PHP com contador!&lt;/h1&gt;";
echo "&lt;p&gt;Esta página já foi acessada &lt;strong&gt;{$visitas}&lt;/strong&gt; vezes.&lt;/p&gt;";
</code></pre>

    <p><strong><code>Dockerfile</code></strong></p>
    <pre><code class="language-dockerfile">FROM php:8.2-apache

# Diretório de trabalho
WORKDIR /var/www/html

# Copia o index.php
COPY index.php /var/www/html/index.php

# Ajusta permissões para o Apache poder escrever no arquivo de contador
RUN chown -R www-data:www-data /var/www/html \
    &amp;&amp; chmod -R 755 /var/www/html

EXPOSE 80
</code></pre>

    <p><strong>Build da imagem</strong> (no diretório <code>ex5/</code>):</p>

    <p><span class="tag">Docker</span></p>
    <pre><code class="language-bash">docker build -t php-contador-ex5 .</code></pre>

    <p><span class="tag">Podman</span></p>
    <pre><code class="language-bash">podman build -t php-contador-ex5 .</code></pre>

    <p><strong>Rodando o container</strong></p>

    <p><span class="tag">Docker</span></p>
    <pre><code class="language-bash">docker run --rm -p 8082:80 php-contador-ex5</code></pre>

    <p><span class="tag">Podman</span></p>
    <pre><code class="language-bash">podman run --rm -p 8082:80 php-contador-ex5</code></pre>

    <p>
      Acesse: <code>http://localhost:8082</code><br />
      Recarregue a página algumas vezes: o número de visitas deve aumentar.
    </p>
  </div>

</body>
</html>