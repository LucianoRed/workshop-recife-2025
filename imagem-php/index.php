<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Screensaver Bouncing Ball</title>
    <style>
        body {
            margin: 0;
            overflow: hidden;
            background-color: white;
            color: black;
            font-family: sans-serif;
        }
        canvas {
            display: block;
        }
        #info {
            position: absolute;
            top: 10px;
            left: 10px;
            pointer-events: none;
            opacity: 0.5;
        }
        #ui {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 24px;
            font-weight: bold;
            pointer-events: none;
        }
    </style>
</head>
<body>
    <div id="ui">
        Score: <span id="scoreDisplay">0</span>/10 | Time: <span id="timeDisplay">0.0</span>s
    </div>
    <div id="info">
        <?php echo "Servido por PHP " . phpversion(); ?>
    </div>
    <canvas id="canvas"></canvas>

    <script>
        const canvas = document.getElementById('canvas');
        const ctx = canvas.getContext('2d');
        const scoreDisplay = document.getElementById('scoreDisplay');
        const timeDisplay = document.getElementById('timeDisplay');

        let width = canvas.width = window.innerWidth;
        let height = canvas.height = window.innerHeight;

        const logoImg = new Image();
        logoImg.src = 'https://www.portodigital.org/_nuxt/img/logo.5417d9c.svg';

        // Game State
        let score = 0;
        let startTime = Date.now();
        let gameWon = false;
        const maxScore = 10;

        // Configuração da bola
        const ball = {
            x: Math.random() * (width - 100) + 50,
            y: Math.random() * (height - 100) + 50,
            vx: (Math.random() - 0.5) * 10, // Velocidade X aleatória
            vy: (Math.random() - 0.5) * 10, // Velocidade Y aleatória
            radius: 50
        };

        // Garante velocidade mínima para não ficar parado
        if (Math.abs(ball.vx) < 2) ball.vx = 3;
        if (Math.abs(ball.vy) < 2) ball.vy = 3;

        // Click Handler
        window.addEventListener('mousedown', (e) => {
            if (gameWon) return;

            const rect = canvas.getBoundingClientRect();
            const mouseX = e.clientX - rect.left;
            const mouseY = e.clientY - rect.top;

            // Check collision with ball (circle approximation)
            const dist = Math.sqrt((mouseX - ball.x) ** 2 + (mouseY - ball.y) ** 2);
            
            if (dist < ball.radius) {
                score++;
                scoreDisplay.textContent = score;
                
                // Increase speed significantly
                ball.vx *= 1.3;
                ball.vy *= 1.3;

                if (score >= maxScore) {
                    gameWon = true;
                    const finalTime = ((Date.now() - startTime) / 1000).toFixed(2);
                    alert(`PARABÉNS! Você venceu em ${finalTime} segundos!`);
                }
            }
        });

        function draw() {
            // Limpa o canvas com um rastro leve (opcional, aqui limpa tudo)
            ctx.fillStyle = 'white';
            ctx.fillRect(0, 0, width, height);

            // Desenha a logo
            if (logoImg.complete) {
                ctx.drawImage(logoImg, ball.x - ball.radius, ball.y - ball.radius, ball.radius * 2, ball.radius * 2);
            }
        }

        function update() {
            if (gameWon) return;

            // Update Time
            timeDisplay.textContent = ((Date.now() - startTime) / 1000).toFixed(1);

            // Atualiza posição
            ball.x += ball.vx;
            ball.y += ball.vy;

            let hit = false;

            // Colisão com as paredes (inverte a velocidade)
            
            // Direita
            if (ball.x + ball.radius > width) {
                ball.x = width - ball.radius;
                ball.vx = -ball.vx;
                hit = true;
            }
            // Esquerda
            else if (ball.x - ball.radius < 0) {
                ball.x = ball.radius;
                ball.vx = -ball.vx;
                hit = true;
            }
            
            // Baixo
            if (ball.y + ball.radius > height) {
                ball.y = height - ball.radius;
                ball.vy = -ball.vy;
                hit = true;
            }
            // Cima
            else if (ball.y - ball.radius < 0) {
                ball.y = ball.radius;
                ball.vy = -ball.vy;
                hit = true;
            }

            // "Despistar" - Randomize angle slightly on hit
            if (hit && Math.random() < 0.3) {
                 ball.vx += (Math.random() - 0.5) * 5;
                 ball.vy += (Math.random() - 0.5) * 5;
            }

            draw();
            requestAnimationFrame(update);
        }

        window.addEventListener('resize', () => {
            width = canvas.width = window.innerWidth;
            height = canvas.height = window.innerHeight;
        });

        update();
    </script>
</body>
</html>
