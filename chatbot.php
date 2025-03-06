<?php
header("Content-Type: text/plain");
session_start();  // Inicia a sessão

include ("paramentros.php");

// Inicializa erro_count se ainda não estiver definido
if (!isset($_SESSION['erro_count'])) {
    $_SESSION['erro_count'] = 0;
}

$message = isset($_POST["message"]) ? strtolower(trim($_POST["message"])) : "";

// Verifica se o chat acabou de ser aberto
if (!isset($_SESSION["chat_started"])) {
    $_SESSION["chat_started"] = true;
    usleep(1000000); // 1 segundo
    $_SESSION["waiting_for_name"] = true;
    paramentros::send_response(paramentros::WELCOME_MESSAGE);
}

// Verifica se está esperando o nome do usuário
if (isset($_SESSION["waiting_for_name"])) {
    $_SESSION["user_name"] = ucfirst($message);
    unset($_SESSION["waiting_for_name"]);
    usleep(1500000); // 1.5 segundos
    paramentros::send_response("Prazer em te conhecer, {$_SESSION["user_name"]}! Como posso te ajudar?");
}

$user_name = $_SESSION["user_name"] ?? paramentros::DEFAULT_USER_NAME;

// Função para buscar resposta baseada em palavras-chave no banco de dados
$idCurso = 22;
function buscar_resposta($pdo, $message,$idCurso) {
    $stmt = $pdo->prepare("SELECT * FROM respostas WHERE FIND_IN_SET(?, keywords) AND ID_CURSO LIKE $idCurso");
   // $pdo->prepare("SELECT * FROM respostas WHERE ID_CURSO = 18 AND keywords like %'$message'% ");
    $stmt->execute([$message]);
    $result = $stmt->fetch();
    return $result ? $result['resposta'] : null;
}

$pdo = paramentros::getPDO();
$resposta = buscar_resposta($pdo, $message,$idCurso);

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

paramentros::send_response($resposta);
?>