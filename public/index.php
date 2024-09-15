<?php
require_once '../config/config.php';
require_once '../classes/Usuario.php';
require_once '../classes/Contato.php';

// Criação das tabelas e inicialização dos usuários
$usuario = new Usuario();
$usuario->criarTabela();
$usuario->inicializarUsuarios();

$contato = new Contato();
$contato->criarTabela();
$contato->inicializarContatos();

// Redirecionamento para a página de login
header('Location: login.php');

