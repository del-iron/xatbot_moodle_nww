<?php
header("Content-Type: text/plain");
session_start();  // Inicia a sessão

define('WELCOME_MESSAGE', "Olá, eu sou Toinha! Como posso te ajudar hoje? Antes de começarmos, qual é o seu nome?");
define('DEFAULT_USER_NAME', "Usuário");

// Inicializa erro_count se ainda não estiver definido
if (!isset($_SESSION['erro_count'])) {
    $_SESSION['erro_count'] = 0;
}

$message = isset($_POST["message"]) ? strtolower(trim($_POST["message"])) : "";

// Função para enviar resposta e encerrar o script
function send_response($response) {
    echo $response;
    exit;
}

// Verifica se o chat acabou de ser aberto
if (!isset($_SESSION["chat_started"])) {
    $_SESSION["chat_started"] = true;
    usleep(1000000); // 1 segundo
    $_SESSION["waiting_for_name"] = true;
    send_response(WELCOME_MESSAGE);
}

// Verifica se está esperando o nome do usuário
if (isset($_SESSION["waiting_for_name"])) {
    $_SESSION["user_name"] = ucfirst($message);
    unset($_SESSION["waiting_for_name"]);
    usleep(1500000); // 1.5 segundos
    send_response("Prazer em te conhecer, {$_SESSION["user_name"]}! Como posso te ajudar?");
}

$user_name = $_SESSION["user_name"] ?? DEFAULT_USER_NAME;

// Dicionário de respostas
$respostas_keywords = [
    "senha,recuperar,esqueci,alterar,mudar,trocar" => "Você pode recuperar ou alterar sua senha clicando em 'Esqueci minha senha' na página de login do Moodle.",
    "acessar,entrar,login,logar" => "Para acessar o Moodle, acesse o site da sua instituição e faça login com seu usuário e senha.",
    "moodle,plataforma,sistema" => "O Moodle é uma plataforma de ensino à distância usada para cursos online.",
    "atividade,enviar,submeter,trabalho,tarefa" => "No Moodle, vá até a disciplina desejada, encontre a atividade e siga as instruções para envio.",
    "professores,professor,ver,visualizar,atividades" => "Seus professores podem visualizar suas atividades enviadas e fornecer feedback no Moodle.",
    "contato,contatar,professor,professores,mensagem" => "Você pode entrar em contato pelo fórum da disciplina, pelo sistema de mensagens ou e-mail institucional.",
    "problema,erro,não enviada,falha" => "Se houver problemas no envio, tente novamente ou entre em contato com o suporte.",
    "aplicativo,app,celular,mobile,smartphone" => "O Moodle possui um aplicativo oficial para Android e iOS, disponível na Play Store e App Store.",
    "notas,nota,avaliação,pontuação,desempenho" => "No Moodle, acesse a disciplina e clique em 'Notas' para visualizar seu desempenho.",
    "nota errada,erro nota,corrigir nota,problema nota" => "Se houver erro em sua nota, entre em contato com seu professor para verificar e corrigir."
];

// Função para buscar resposta baseada em palavras-chave
function buscar_resposta($message, $respostas_keywords) {
    foreach ($respostas_keywords as $keywords => $resp) {
        $keywords_array = explode(",", $keywords);
        foreach ($keywords_array as $keyword) {
            if (strpos($message, $keyword) !== false) {
                return $resp;
            }
        }
    }
    return null;
}

$resposta = buscar_resposta($message, $respostas_keywords);

// Se nenhuma palavra-chave foi encontrada, usar resposta padrão
if ($resposta === null) {
    $_SESSION['erro_count']++;

    switch ($_SESSION['erro_count']) {
        case 1:
            $resposta = "$user_name, desculpe, não encontrei uma resposta para isso. Reformule sua pergunta, por favor!";
            break;
        case 2:
            $resposta = "$user_name, não consegui entender sua solicitação. Poderia reformular de outra maneira?";
            break;
        default:
            $resposta = "$user_name, sinto muito, não consegui te entender. Encerrando o chat!";
            session_unset();
            session_destroy();
            break;
    }
}

// Simula resposta humana
usleep(rand(2000000, 4000000)); // Entre 2 e 4 segundos

send_response($resposta);
?>